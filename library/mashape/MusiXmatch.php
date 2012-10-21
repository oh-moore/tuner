<?php
require_once("MashapeClient.php");


class MusiXmatch {
	const PUBLIC_DNS = "musixmatchcom-musixmatch.p.mashape.com";
	private $authHandlers;

	function __construct($publicKey, $privateKey) {
		$this->authHandlers = array();
		$this->authHandlers[] = new MashapeAuthentication($publicKey, $privateKey);
		
	}
        
        public function matcherBillboardTracksGet($apikey ,$page =1, $pageSize=100, $country="us", $hasLyrics=1)
        {
		$parameters = array(
				"apikey" => $apikey,
				"page" => $page,
				"page_size" => $pageSize,
				"country" => $country,
                                "f_has_lyrics" => $hasLyrics
                       );

		$response = HttpClient::doRequest(
				HttpMethod::GET,
				"https://" . self::PUBLIC_DNS . "/ws/1.1/chart.tracks.get",
				$parameters,
				$this->authHandlers,
				ContentType::FORM,
				true);
		return $response;            
        }
        
	public function matcherTrackGet($apikey, $q_artist, $q_track, $q_album = null) {
		$parameters = array(
				"apikey" => $apikey,
				"q_artist" => $q_artist,
				"q_track" => $q_track,
				"q_album" => $q_album);

		$response = HttpClient::doRequest(
				HttpMethod::GET,
				"https://" . self::PUBLIC_DNS . "/ws/1.1/matcher.track.get",
				$parameters,
				$this->authHandlers,
				ContentType::FORM,
				true);
		return $response;
	}
	public function trackLyricsGet($apikey, $track_id) {
		$parameters = array(
				"apikey" => $apikey,
				"track_id" => $track_id);

		$response = HttpClient::doRequest(
				HttpMethod::GET,
				"https://" . self::PUBLIC_DNS . "/ws/1.1/track.lyrics.get",
				$parameters,
				$this->authHandlers,
				ContentType::FORM,
				true);
		return $response;
	}
	public function trackSearch($apikey, $q_artist, $q_track, $q_lyrics = null) {
		$parameters = array(
				"apikey" => $apikey,
				"q_artist" => $q_artist,
				"q_track" => $q_track,
				"q_lyrics" => $q_lyrics);

		$response = HttpClient::doRequest(
				HttpMethod::GET,
				"https://" . self::PUBLIC_DNS . "/ws/1.1/track.search",
				$parameters,
				$this->authHandlers,
				ContentType::FORM,
				true);
		return $response;
	}
	

	
}
?>