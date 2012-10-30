<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LyricsyoCombinator
 *
 * @author brendanmoore
 */

require_once 'MusiXmatch.php';
require_once 'TextProcessing.php';

class LyricsyoCombinator {
    
    private $publicKey="virq0zsicq3tdgihospztp17gxlyxy";
    private $privateKey="yfrc2e7po36vqtm6hnavceagf7r4sj";
    private $musicMatchKey="31d024f7cb59af6a8ebc57c8ca8a6eb7";
    private $musicMatchApi;
    private $sundayTextApi;
    
    
    function __construct() {
        $this->musicMatchApi=new MusiXmatch($this->publicKey, $this->privateKey);
        $this->sundayTextApi=new TextProcessing($this->publicKey, $this->privateKey);
    }    
    
    public function getTopBillBoardTracks($numSongs)
    {
        $allTracks=$this->musicMatchApi->matcherBillboardTracksGet($this->musicMatchKey ,1, $numSongs, "us", "1");         
        return $allTracks;
    }
    
    public function getTrackForId($track_id)
    {
        $response=$this->musicMatchApi->trackLyricsGet($this->musicMatchKey, $track_id);
        return $response;
    }
    
    public function getSentimentForTrackLyric($lyrics)
    {
        $response=$this->sundayTextApi->sentiment($lyrics);
        return $response;
    }
}

?>
