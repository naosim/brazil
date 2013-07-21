<?php
class Res {
	/** @var string */
	public $name;
	/** @var string */
	public $address;
	// public $isAge;
	/** @var WriteDate */
	public $writeDate;
	/** @var string */
	public $uid;
	/** @var Contents */
	public $contents;
	/** @var string */
	public $title;
	/** @var number[] */
	public $anchors;
	
	/** @var array */
	public $recivedAnchorIndexes;
	
	/**
	 * 1から始まるIndex
	 */
	public $index;
}

class WriteDate {
	private $strDate;

	public function __construct($strDate) {
		$this -> strDate = $strDate;
	}

	public function strDate() {
		return $this -> strDate;
	}

}

/**
 * コンテンツ
 * 
 * コンテンツ部分はいろいろいじるので別クラス化する
 */
class Contents {
	private $raw;
	public function __construct($raw) {
		$this -> raw = $raw;
	}
	public function raw() {
		return $this -> raw;
	}
	
	public function html() {
		$result = $this -> raw;
		$result = str_replace(' target="_blank"', "", $result);
		preg_match_all('/<a href="(.*?)"/', $result, $maches);
		$searchs = $maches[0];
		$urls = $maches[1];
		$reps = array();
		
		foreach ($urls as $i => $url) {
			preg_match_all('/[^\/]*$/', $url, $a);
			$indexName = "#res" . $a[0][0];
			$rep = str_replace($url, $indexName, $searchs[$i]);
			$result = str_replace($searchs[$i], $rep, $result);
		}
		return $result;
	}
}

/**
 * コンテンツのファクトリ
 * 
 * コンテンツをいじりやすくするために。
 */
class ContentsFactory {
	public function create($strContents) {
		return new Contents($strContents);
	}
}
