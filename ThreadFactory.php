<?php

class ThreadFactory {
	/** htmlを作って吐く */
	public function create($datStr){
		$lines = explode("\n", trim($datStr));
		$resAry = array();
		foreach($lines as $line) {
			print $line . "\n";
			$dict = $this->createRes($line);
			$resAry[] = $dict;
		}
		
		print_r($resAry);
		
		// createHtml($resAry);
	}
	
	/** 1行のデータから連想配列作る */
	private function createRes($resStr){
		$elm = explode("<>", $resStr);
		$result = array();
		$i = 0;
		$result["name"] = $elm[$i++];
		$result["address"] = $elm[$i++];
		$dateAndUid = $this->parseDateAndUid($elm[$i++]);
		$result["date"] = $dateAndUid["date"];
		$result["uid"] = $dateAndUid["uid"];
		$result["contents"] = $elm[$i++];
		$result["title"] = $elm[$i++];
		$anchors = $this->parseAnchor($result["contents"]);
		$result["anchors"] = $anchors;
		$result["movie_flg"] = $this->hasMovie($result["contents"]);
		return $result;
	}
	
	private function parseDateAndUid($str) {
		$a = explode("ID:", $str);
		return array("date" => $a[0], "uid" => $a[1]);
	}
	
	private function parseAnchor($str) {
		$str = preg_replace('@<a(?:>| [^>]*?>)(.*?)</a>@s','$1',$str);
		preg_match_all("/&gt;&gt;([0-9]+)/", $str, $a);
		return $a[1];
	}
	
	private function hasMovie($str) {
// 		preg_match_all("/youtube.com/", $str, $a);
		return strpos($str,"youtube.com") !== false;
	}
	
	private function createHtml($resAry) {
	}
	
	public function test() {
		$this->create($this->loadDat("1372500160.dat"));
	}
	
	
	public function loadDat($filename) {
		$path = "dat/";
		return file_get_contents($path . $filename);
	}
}

$a = new ThreadFactory();
$a->test();


