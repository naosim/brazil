<?php
require_once "ThreadFactory.php";
require_once "WebLoader.php";
class MovieThread {
	public $thread;
	public $movies;

	public function __construct($thread) {
		$this -> thread = $thread;
	}

	public function name() {
		return $this -> thread -> name();
	}

	public function id() {
		return $this -> thread -> id();
	}

	public function resArray() {
		return $this -> thread -> resArray();
	}

	public function movies() {
		return $this -> movies;
	}

}

class MovieThreadFactory {

	/**
	 * @return mixed MovieThread or false
	 */
	public function create($strDat) {
		if (!MovieThreadFactory::hasMovie($strDat))
			return false;

		$threadFactory = new ThreadFactory();
		$thread = $threadFactory -> create($strDat);

		$result = new MovieThread($thread);
		$result -> movies = $this -> getMovieUrls($strDat);
		return $result;
	}

	public static function hasMovie($str) {
		return strpos($str, '.youtube.com') !== false;
	}

	private function getMovieUrls($strDat) {
		$result = array();
		preg_match_all('/(?:^|[\s　]+)((?:h?ttps?|ftp):\/\/[^\s　]+)/', $strDat, $urls);
		foreach ($urls[1] as $url) {
			$url = str_replace('&amp;', '&', $url);
			if (MovieThreadFactory::hasMovie($url)) {
				if($this -> isExistYoutube($url)) {		
					$result[] = $url;
				}
			}
		}
		return $result;
	}
	
	private function isExistYoutube($movieUrl) {
		$id = MovieThreadFactory::getYoutubeId($movieUrl);
		$loader = new WebLoader();
		$result = $loader -> load("http://gdata.youtube.com/feeds/api/videos/$id");
		return strpos($result, "<?xml version='1.0' encoding='UTF-8'?>") !== false;
	}
	
	public static function getYoutubeId($movieUrl) {
		$a = explode("v=", $movieUrl);
		$a = explode('&', $a[1]);
		return $a[0];
	}

}
