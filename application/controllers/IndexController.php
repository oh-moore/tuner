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
        $badwordsHelper=new BadwordsHelper();
        
        $badworsdsArray=$badwordsHelper->getBadWordsArray();
        
        //$response=new MashapeResponse();
        $this->lyricsYoCombo= new LyricsyoCombinator();        
        // action body
        $response=$this->lyricsYoCombo->getTopBillBoardTracks(5);
        //var_dump($response->headers);
        //var_dump($response->rawBody);
        $resultJsonArray=Zend_Json_Decoder::decode($response->rawBody);
        
        foreach($resultJsonArray["message"]["body"]["track_list"] as $track)
        {
            echo"<br/>";
            $trackId=$track["track"]["track_id"];
            echo $trackId;
            echo"<br/>";
            $trackResponse=$this->lyricsYoCombo->getTrackForId($trackId);
            $trackLyrics=Zend_Json_Decoder::decode($trackResponse->rawBody);
            $strLyrics=$trackLyrics["message"]["body"]["lyrics"]["lyrics_body"];
            $explodedLyrics=explode(" ", $strLyrics);
            
            
            $countWords=array();
            foreach($explodedLyrics as $explodedLyric)
            {
                if(array_key_exists($explodedLyric, $search_array))
                {
                    
                }
                $countWords[""]
            }
            
            $sentimentResponse=$this->lyricsYoCombo->getSentimentForTrackLyric($strLyrics);
            $sentimentJsonResponse=Zend_Json_Decoder::decode($sentimentResponse->rawBody);
            var_dump($sentimentJsonResponse);
            echo $strLyrics;
        }
        
        $this->view->abody=Zend_Json_Encoder::encode($resultJsonArray["message"]["body"]);
    }


}

