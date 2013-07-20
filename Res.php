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
