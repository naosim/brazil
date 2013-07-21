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
		preg_match_all('/(?:^|[\s　]+)((?:https?|ftp):\/\/[^\s　]+)/', $strDat, $urls);
		foreach ($urls[1] as $url) {
			if (MovieThreadFactory::hasMovie($url)) {
				// うしろに&amp;がついてることがあるからフィルタ
				$a = explode("&", $url);
				if($this -> isExistYoutube($a[0])) {				
					$result[] = $a[0];
				}
			}
		}

		return $result;
	}
	
	private function isExistYoutube($movieUrl) {
		$a = explode("?v=", $movieUrl);
		$id = $a[1];
		$loader = new WebLoader();
		$result = $loader -> load("http://gdata.youtube.com/feeds/api/videos/$id");
		return strpos($result, "<?xml version='1.0' encoding='UTF-8'?>") !== false;
	}

}
