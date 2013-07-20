<?php
require_once "ThreadFactory.php";
class MovieThread {
	public $thead;
	public $movies;

	public function __construct($thead) {
		$this -> thread = $thead;
	}

	public function name() {
		return $this -> thead -> name();
	}

	public function id() {
		return $this -> thead -> id();
	}

	public function resArray() {
		return $this -> thead -> resArray();
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
		$result->movies = $this->getMovieUrls($strDat);
		return $result;
	}

	public static function hasMovie($str) {
		return strpos($str, '.youtube.com') !== false;
	}
	
		private function getMovieUrls($strDat) {
		$result = array();
		preg_match_all('/(?:^|[\s　]+)((?:https?|ftp):\/\/[^\s　]+)/', $strDat, $urls);
		foreach ($urls[1] as $url) {
			if(MovieThreadFactory::hasMovie($url))$result[] = $url;
		}
		
		return $result;
	}
}
