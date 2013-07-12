<?php
/*
    クローラ作った。（とりあえず阪）
    板のURL入れると板の最新datファイルを全部持ってくる
    とりあえずプロジェクト直下に /dat フォルダ作って全部格納
 */
class chCrawler {

	private $boardUrl;
	private $subjectUrl;
	private $datList;

	/**
	 * 板のURLを引数に入れてね。
	 * http://hayabusa.2ch.net/livefoot/ とか
	 */
	public function __construct($boardUrl) {
		$this->boardUrl = $boardUrl;
		$this->subjectUrl = $boardUrl . "subject.txt";
		$this->datList = $this->getSubjectList($this->subjectUrl);
	}

	/**
	 * 板のサブジェクトに書いてある *.dat をリストで取得するよ
	 * 引数 : http://hayabusa.2ch.net/livefoot/subject.txt 的なやつ
	 */
	public function getSubjectList($subjectUrl) {
		$curl_result = $this->curlExec($subjectUrl);
		/*  datID ( *.dat ) を取得 */
		preg_match_all("/[0-9]+.dat/", $curl_result, $datGrepResult);
		return $datGrepResult[0];
	}

	/**
	 * datの名前からdatデータを取得するよ
	 * 
	 * 引数 : 1234567890.dat
	 * 返り値 : dat形式のデータ
	 */
	public function getDatfile($datname) {
		$datUrl = $this->boardUrl . "dat/" . $datname;
		return $this->curlExec($datUrl);
	}

	/**
	 * URLのデータをファイルでとってくるよ
	 * 社内LANからだとproxy設定してね
	 * 引数： http://aaa.com/a/bbb.html
	 */
	public function curlExec($url) {
		$ch = curl_init();
		$result = "";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
		curl_setopt($ch, CURLOPT_HEADER, false);
		//proxy setting
		//curl_setopt($ch, CURLOPT_PROXY, '');
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

	public function datUpdate($datList) {
		// TODO datを更新したい
		foreach ($datList as $datname) {

		}
	}

	public function datWhiter() {
		// TODO datに書き出す関数
	}
	
	/**
	 * 開発用の関数だよ
	 */
	public function Devel() {
		print("boardUrl = $this->boardUrl\n");
		print("subjectUrl = $this->subjectUrl\n");

		foreach ($this->datList as $dat) {
			$row = $this->getDatfile($dat);
			$row = mb_convert_encoding($row, 'UTF-8', 'Shift_JIS');
			$outFileName = "./dat/$dat";
			$file = fopen($outFileName, "w");
			fputs($file, $row);
			fclose($file);
		}
	}

}

$cr = new chCrawler("http://hayabusa.2ch.net/livefoot/");
$cr->Devel();
