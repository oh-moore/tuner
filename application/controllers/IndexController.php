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

    public function testAction()
    {
        $this->_helper->viewRenderer->setNoRender();	//Disable the rendering of a view as we're                                                                                                         //returning JSON content 
        $this->_helper->getHelper('layout')->disableLayout();	//Disable Layouts as we're returning JSON content                        
        echo "Hello";
        $badwordsHelper=new BadwordsHelper();           
        $badwords=$badwordsHelper->getBadWordsArray();
        
        $badwordsFixArray=array();
        foreach($badwords as $word)
        {
            if(!array_key_exists($word, $badwordsFixArray))
            {
                $badwordsFixArray[$word]=1;
            }
            else {
                $badwordsFixArray[$word]=$badwordsFixArray[$word]+1;
            }
        }
        
        foreach($badwordsFixArray as $word => $count)
        {
            echo '"'.$word.'",';
        }
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
            
            $sexiestTrack=$newJsonLyricsArray["sexyTrack"];
            error_log($sexiestTrack);
            if($sexiestTrack==null)
            {
                $getNewFile=true;
            }
        }        
        else
        {
            $getNewFile=true;
        }
        
        if(array_key_exists("whinyTrack",$newJsonLyricsArray))
        {            
            $whinyTrack=$newJsonLyricsArray["whinyTrack"];
            error_log($whinyTrack);
            if($whinyTrack==null)
            {
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
        
        $newJsonLyricsArray["profanityArray"]=$profanityArray;
        $newJsonLyricsArray["gushArray"]=$gushArray;
        $newJsonLyricsArray["materialArray"]=$materialArray;
        
        $this->view->trackDict=Zend_Json_Encoder::encode($newJsonLyricsArray);
        
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
        $sexiestCount=0;
        $whinyCount=0;
        $whinyTrack=null;
        $sexiestTrack=null; 
        
        $numPositiveSongs=0;
        $numNegativeSongs=0;
        $numLoveSongs=0;
        
        $i=0;
        
        foreach($newJsonLyricsArray as $id=>$track)
        {                
            if(!is_array($track))
            {
                error_log("this is not an array");
            }
            else if(!array_key_exists("track_id",$track))
            {
                error_log("this is not a track array");
            }
            else
            {
                //error_log("Track id is ".$track["track_id"]);

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

                $strLyrics=  strtolower($strLyrics);
                $n_words = preg_match_all('/([a-zA-Z]|\xC3[\x80-\x96\x98-\xB6\xB8-\xBF]|\xC5[\x92\x93\xA0\xA1\xB8\xBD\xBE]){2,}/', $strLyrics, $match_arr);
                $explodedLyrics = $match_arr[0];  
                //COUNT PROFANITY
                $countWords=array();

                if(!array_key_exists("profanities" ,$track) || count($track["profanities"])==0)
                {

                    $outputLyrics="";
                    foreach($explodedLyrics as $explodedLyric)
                    {   
                        
                        $outputLyrics=$outputLyrics." ".$explodedLyric;
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
                                    $countWords[$explodedLyric]=((int)$countWords[$explodedLyric])+1;
                                }                        
                            }                    
                        }   

                    }
                    if($track["track_id"]=="16992841"){                    
                        error_log ($outputLyrics);
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
                
                if(!array_key_exists("numLove" ,$track))
                {
                    $sexyCountInt=0;
                    $whinyCountInt=0;
                    $isLoveMentioned=false;
                    foreach($explodedLyrics as $explodedLyric)
                    {                
                        if($explodedLyric=="love" && $isLoveMentioned==false)
                        {
                            $isLoveMentioned=true;
                            $numLoveSongs=$numLoveSongs+1;
                        }                    
                        
                        foreach($sexywordsArray as $badword)
                        {                                                                       
                            //error_log("Sexy count found ".$sexyCountInt);
                            if($explodedLyric==$badword)
                            {
                                //error_log("Exploded lyric ".$explodedLyric." and word is ".$badword);                              
                                $sexyCountInt=$sexyCountInt+1;                                  
                            }                    
                        }                        
                        if($sexyCountInt>$sexiestCount)
                        {
                            
                            $sexiestCount=$sexyCountInt;
                            $sexiestTrack=$track["track_id"];
                            
                        }
                        
                        
                        foreach($whinywordsArray as $badword)
                        {
                            //error_log("Whiny count found ".$whinyCountInt);
                            if($explodedLyric==$badword)
                            {
                                //error_log("Whiny count found ".$whinyCountInt);
                                $whinyCountInt=$whinyCountInt+1;                                  
                            }                    
                        }           
                        
                        if($whinyCountInt>$whinyCount)
                        {
                            $whinyCount=$whinyCountInt;
                            $whinyTrack=$track["track_id"];
                        }  
                    }
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
                        $numPositiveSongs=$numPositiveSongs+1;
                    } 
                    else if($labelResp=="neg")
                    {
                        if((double)$respVal > $negValue)
                        {
                            $negValue=$respVal;
                            $negTrack=$track;
                            
                        }
                        $numNegativeSongs=$numNegativeSongs+1;
                    }                
                }
                $newJsonLyricsArray[$id]=$track;
                }
                $i=$i+1;
            }
        
        $newJsonLyricsArray["whinyTrack"]=$whinyTrack;
        $newJsonLyricsArray["sexyTrack"]=$sexiestTrack;
        $newJsonLyricsArray["negativeTrack"]=$negTrack["track_id"];
        $newJsonLyricsArray["positiveTrack"]=$posTrack["track_id"];

        $newJsonLyricsArray["profanityArray"]=$profanityArray; 
        $newJsonLyricsArray["gushArray"]=$gushArray; 
        $newJsonLyricsArray["materialArray"]=$materialArray; 
        $newJsonLyricsArray["numPositive"]=$numPositiveSongs;
        $newJsonLyricsArray["numNegative"]=$numNegativeSongs;
        $newJsonLyricsArray["numLove"]=$numLoveSongs;
        $newJsonLyricsArray["numProfane"]=count($profanityArray);

        $fh = fopen($fileLyricsJson, 'w');  
        fwrite($fh, Zend_Json_Encoder::encode($newJsonLyricsArray));
        fclose($fh);     
            
        return $newJsonLyricsArray;
    }

}

