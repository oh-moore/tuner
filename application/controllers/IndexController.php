<?php

include 'mashape/LyricsyoCombinator.php';
include 'mashape/BadwordsHelper.php';

class IndexController extends Zend_Controller_Action
{


    public function init()
    {
        /* Initialize action controller here */
        $this->lyricsYoCombo= new LyricsyoCombinator();
    }

    public function indexAction()
    {
        $isNew=$this->getRequest()->getParam("isnew");
        $getNewFile=false;
        if($isNew!="" || $isNew!=null)
        {
            if($isNew==true)
            {
                $getNewFile=true;
            }
        }
        $isLyrics=true;
        $jsonLyricsArray=null;
        $fileLyricsJson = "./lyrics.json";
        try{            
            $txtLyricsJson=file_get_contents($fileLyricsJson);         
            $jsonLyricsArray=Zend_Json_Decoder::decode($txtLyricsJson);
        }
        catch(Exception $ex)
        {
            error_log($ex);
            $isLyrics=false;
        }
        
        if($jsonLyricsArray==null || count($jsonLyricsArray)==0 || $getNewFile==true)
        {
            error_log("Has lyrics is not found ".count($jsonLyricsArray));
            $isLyrics=false;
        }
        

        
        //Get helper for detecting bad or profane words

        $newJsonLyricsArray=array();
        if($isLyrics==false)
        {
            $this->lyricsYoCombo= new LyricsyoCombinator();        
            // action body
            $response=$this->lyricsYoCombo->getTopBillBoardTracks(100);       
            $resultJsonArray=Zend_Json_Decoder::decode($response->rawBody);
            $jsonLyricsArray=$resultJsonArray["message"]["body"]["track_list"];

            foreach($jsonLyricsArray as $track)
            {
                $newJsonLyricsArray[$track["track"]["track_id"]]=$track["track"];                
            }
        }
        else
        {
            $newJsonLyricsArray=$jsonLyricsArray;
        }
        
        $positiveTrack=null;
        $negativeTrack=null;
        $sexiestTrack=null;
        $whinyTrack=null;
        
        $profanityArray=array();    
        
        
        //Find if we have already identified this weeks positive, negative, sexiest, whiny tracks
        
        if(array_key_exists("positiveTrack",$newJsonLyricsArray))
        {            
            $positiveId=$newJsonLyricsArray["positiveTrack"];
            if(array_key_exists($positiveId,$newJsonLyricsArray))
            {
                $positiveTrack=$newJsonLyricsArray[$positiveId];
            }
            else {
                $getNewFile=true;
            }
        }
        else
        {
            $getNewFile=true;
        }        
        
        if(array_key_exists("negativeTrack",$newJsonLyricsArray))
        {            
            $theid=$newJsonLyricsArray["negativeTrack"];
            if(array_key_exists($theid,$newJsonLyricsArray))
            {
                $negativeTrack=$newJsonLyricsArray[$theid];  
            }
            else {
                $getNewFile=true;
            }            
                     
        }        
        else
        {
            $getNewFile=true;
        }
        
        if(array_key_exists("sexyTrack",$newJsonLyricsArray))
        {            
            $theid=$newJsonLyricsArray["sexyTrack"];
            if(array_key_exists($theid,$newJsonLyricsArray))
            {
                $sexiestTrack=$newJsonLyricsArray[$theid];  
            }
            else {
                $getNewFile=true;
            }                        
        }
        else
        {
            $getNewFile=true;
        }
        
        if(array_key_exists("whinyTrack",$newJsonLyricsArray))
        {            
            $theid=$newJsonLyricsArray["whinyTrack"];
            error_log($theid);
            if(array_key_exists($theid,$newJsonLyricsArray))
            {
                $whinyTrack=$newJsonLyricsArray[$theid];  
            }
            else {
                $getNewFile=true;
            }              
        }     
        else
        {
            $getNewFile=true;
        }
        
        if(array_key_exists("profanityArray",$newJsonLyricsArray))
        {
            $profanityArray=$newJsonLyricsArray["profanityArray"];
        }
        else
        {
            $getNewFile=true;
        }        
        
        if(array_key_exists("profanityArray",$newJsonLyricsArray))
        {
            $profanityArray=$newJsonLyricsArray["profanityArray"];
        }
        else
        {
            $getNewFile=true;
        }               
        
        if(array_key_exists("gushyArray",$newJsonLyricsArray))
        {
            $gushArray=$newJsonLyricsArray["gushyArray"];
        }
        else
        {
            $getNewFile=true;
        }               
        
        if(array_key_exists("materialArray",$newJsonLyricsArray))
        {
            $materialArray=$newJsonLyricsArray["materialArray"];
        }
        else
        {
            $getNewFile=true;
        }          
        
        if($getNewFile==true)
        {
            $newJsonLyricsArray=$this->updateJson($newJsonLyricsArray,$fileLyricsJson);
            $profanityArray=$newJsonLyricsArray["profanityArray"];
            $gushArray=$newJsonLyricsArray["gushArray"];
            $materialArray=$newJsonLyricsArray["materialArray"];
        }

        
        usort($profanityArray, 	function ($a, $b)
                {
                        return $a["count_words"] < $b["count_words"];
                }
        );      
        
        usort($gushArray, function ($a, $b)
                {
                        return $a["count_words"] < $b["count_words"];
                }
        );      
        
        usort($materialArray, function ($a, $b)
                {
                        return $a["count_words"] < $b["count_words"];
                }
        );             
        
        $this->view->trackDict=Zend_Json_Encoder::encode($newJsonLyricsArray);
        $this->view->profanityDict=Zend_Json_Encoder::encode($profanityArray);
        
        $this->view->gushArray=$gushArray;
        $this->view->profanityArray=$profanityArray;
        $this->view->materialArray=$materialArray;
        $this->view->trackArray=$newJsonLyricsArray;
    }


    function updateJson($newJsonLyricsArray, $fileLyricsJson)
    {
        $badwordsHelper=new BadwordsHelper();        
        $badwordsArray=$badwordsHelper->getBadWordsArray();  
        $gushwordsArray=$badwordsHelper->getGushyWordsArray();
        $materialwordsArray=$badwordsHelper->getMaterialWordsArray();
        $sexywordsArray=$badwordsHelper->getSexyWordsArray();
        $whinywordsArray=$badwordsHelper->getWhinyWordsArray();
        $posValue=0;
        $posTrack=null;
        $negValue=0;
        $negTrack=null;        
        $profanityArray=array();
        $gushArray=array();
        $materialArray=array();
        
        foreach($newJsonLyricsArray as $id=>$track)
        {        
            if(!array_key_exists("track_id",$track))
            {
                
            }
            else
            {
                error_log($track["track_id"]);

                $strLyrics="";
                if(!array_key_exists("lyrics",$track))
                {                
                    error_log("We don't have lyrics yet, so getting them");
                    $trackResponse=$this->lyricsYoCombo->getTrackForId($id);
                    $trackLyrics=Zend_Json_Decoder::decode($trackResponse->rawBody);
                    error_log($trackResponse->rawBody);
                    $strLyrics=$trackLyrics["message"]["body"]["lyrics"]["lyrics_body"];                
                    $track["lyrics"]=$strLyrics;
                }
                else
                {
                    $strLyrics=$track["lyrics"];
                }


                $explodedLyrics=explode(" ", $strLyrics);
                
                
                //COUNT PROFANITY
                $countWords=array();
                $sexiestCount=0;
                $whinyCount=0;
                $whinyTrack=null;
                $sexiestTrack=null;
                if(!array_key_exists("profanities" ,$track) || count($track["profanities"])!=0)
                {
                    foreach($explodedLyrics as $explodedLyric)
                    {                
                        foreach($badwordsArray as $badword)
                        {
                            if($explodedLyric==$badword)
                            {
                                //echo "Badword found ".$explodedLyric;
                                if(!array_key_exists($explodedLyric, $countWords))
                                {
                                    $countWords[$explodedLyric]=1;
                                }
                                else {
                                    $countWords[$explodedLyric]=$countWords[$explodedLyric]+1;
                                }                        
                            }                    
                        }
                        $sexyCountInt=0;
                        foreach($sexywordsArray as $badword)
                        {
                            if($explodedLyric==$badword)
                            {
                                $sexyCountInt=$sexyCountInt+1;                                  
                            }                    
                        }                        
                        if($sexyCountInt>$sexiestCount)
                        {
                            $sexiestCount=$sexyCountInt;
                            $sexiestTrack=$track["track_id"];
                        }
                        
                        $whinyCountInt=0;
                        foreach($whinywordsArray as $badword)
                        {
                            
                            if($explodedLyric==$badword)
                            {
                                error_log("Whiny count found "+$whinyCountInt);
                                $whinyCountInt=$whinyCountInt+1;                                  
                            }                    
                        }           
                        
                        if($whinyCountInt>$whinyCount)
                        {
                            $whinyCount=$whinyCountInt;
                            $whinyTrack=$track["track_id"];
                        }                        

                    }
                    $track["profanities"]=$countWords;
                }
                else
                {
                    $countWords=$track["profanities"];
                }


                if(count($countWords)>0)
                {
                    //echo "<b>Artist: </b> ".$track["artist_name"]."<br/>";
                    //echo "<img src='".$track["album_coverart_100x100"]."' width='100' height='100'/><br/>";
                    //echo "Profanities:<br/>";
                    $ac=0;
                    foreach($countWords as $abadword => $countword)
                    {
                        $ac=$ac+(int)$countword;                    
                    }
                    $profanityArray[$track["track_id"]]=array(
                                                                "count_words"=>$ac,
                                                                "words" => $countWords,
                                                                "track_id" => $track["track_id"]
                                                            );
                }
                
                //COUNT GUSH
                $countWords=array();
                if(!array_key_exists("gush" ,$track) || count($track["gush"])!=0)
                {
                    foreach($explodedLyrics as $explodedLyric)
                    {                
                        foreach($gushwordsArray as $badword)
                        {
                            if($explodedLyric==$badword)
                            {
                                //echo "Badword found ".$explodedLyric;
                                if(!array_key_exists($explodedLyric, $countWords))
                                {
                                    $countWords[$explodedLyric]=1;
                                }
                                else {
                                    $countWords[$explodedLyric]=$countWords[$explodedLyric]+1;
                                }                        
                            }                    
                        }

                    }
                    $track["gush"]=$countWords;
                }
                else
                {
                    $countWords=$track["gush"];
                }


                if(count($countWords)>0)
                {
                    //echo "<b>Artist: </b> ".$track["artist_name"]."<br/>";
                    //echo "<img src='".$track["album_coverart_100x100"]."' width='100' height='100'/><br/>";
                    //echo "Profanities:<br/>";
                    $ac=0;
                    foreach($countWords as $agushword => $countword)
                    {
                        $ac=$ac+(int)$countword;                    
                    }
                    $gushArray[$track["track_id"]]=array(
                                                                "count_words"=>$ac,
                                                                "words" => $countWords,
                                                                "track_id" => $track["track_id"]
                                                            );
                }                
                //END GUSH

                //MATERIAL ARRAY
                
                $countWords=array();
                if(!array_key_exists("material" ,$track) || count($track["material"])!=0)
                {
                    foreach($explodedLyrics as $explodedLyric)
                    {                
                        foreach($materialwordsArray as $badword)
                        {
                            if($explodedLyric==$badword)
                            {
                                //echo "Badword found ".$explodedLyric;
                                if(!array_key_exists($explodedLyric, $countWords))
                                {
                                    $countWords[$explodedLyric]=1;
                                }
                                else {
                                    $countWords[$explodedLyric]=$countWords[$explodedLyric]+1;
                                }                        
                            }                    
                        }

                    }
                    $track["material"]=$countWords;
                }
                else
                {
                    $countWords=$track["material"];
                }


                if(count($countWords)>0)
                {
                    //echo "<b>Artist: </b> ".$track["artist_name"]."<br/>";
                    //echo "<img src='".$track["album_coverart_100x100"]."' width='100' height='100'/><br/>";
                    //echo "Profanities:<br/>";
                    $ac=0;
                    foreach($countWords as $agushword => $countword)
                    {
                        $ac=$ac+(int)$countword;                    
                    }
                    $materialArray[$track["track_id"]]=array(
                                                                "count_words"=>$ac,
                                                                "words" => $countWords,
                                                                "track_id" => $track["track_id"]
                                                            );
                }                
                
                //END MATERIAL 
                
                
                $sentimentJsonResponse=null;
                if(!array_key_exists("sentiments" ,$track))
                {
                    $sentimentResponse=$this->lyricsYoCombo->getSentimentForTrackLyric($strLyrics);
                    $sentimentJsonResponse=Zend_Json_Decoder::decode($sentimentResponse->rawBody);                
                    $track["sentiments"]=$sentimentJsonResponse;                       
                }
                else {
                    $sentimentJsonResponse=$track["sentiments"];
                }

                if($sentimentJsonResponse!=null)
                {
                    $labelResp=$sentimentJsonResponse["label"];
                    $respVal=$sentimentJsonResponse["probability"][$labelResp];                
                    if($labelResp=="pos")
                    {
                        if((double)$respVal > $posValue)
                        {
                            $posValue=$respVal;
                            $posTrack=$track;
                        }
                    } 
                    else if($labelResp=="neg")
                    {
                        if((double)$respVal > $negValue)
                        {
                            $negValue=$respVal;
                            $negTrack=$track;
                        }
                    }                
                }
                $newJsonLyricsArray[$id]=$track;
                }
            }
            $newJsonLyricsArray["whinyTrack"]=$whinyTrack;
            $newJsonLyricsArray["sexyTrack"]=$sexiestTrack;
            $newJsonLyricsArray["negativeTrack"]=$negTrack["track_id"];
            $newJsonLyricsArray["positiveTrack"]=$posTrack["track_id"];
    
            $newJsonLyricsArray["profanityArray"]=$profanityArray; 
            $newJsonLyricsArray["gushArray"]=$gushArray; 
            $newJsonLyricsArray["materialArray"]=$materialArray; 

            $fh = fopen($fileLyricsJson, 'w');  
            fwrite($fh, Zend_Json_Encoder::encode($newJsonLyricsArray));
            fclose($fh);     
            
        return $newJsonLyricsArray;
    }

}

