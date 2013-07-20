<?php
require_once "Res.php";
require_once "Thread.php";

class ThreadFactory {
	private $contentsFactory;
	public function __construct($contentsFactory = null){
		$this -> contentsFactory = $contentsFactory ? $contentsFactory : new ContentsFactory();
	}
	
	/** 
	 * datの内容からスレッドを生成する
	 * @return Thread 
	 * */
	private function createFromStr($datStr){
		$lines = explode("\n", trim($datStr));
		
		// レス配列の生成
		$resAry = array();
		foreach($lines as $line) {
			$res = $this->createRes($line);
			$resAry[] = $res;
		}
		
		// スレッド生成
		$thread = new Thread($resAry[0]->title, null, $resAry);
		return $thread;
	}
	
	/**
	 * 1行のデータからResを作る
	 * @return Res
	 * */
	public function createRes($resStr){
		$elm = explode("<>", $resStr);
		// $result = array();
		$res = new Res();
		$i = 0;
		$res->name = $elm[$i++];
		$res->address = $elm[$i++];
		$dateAndUid = $this->parseDateAndUid($elm[$i++]);
		$res->writeDate = new WriteDate($dateAndUid["date"]);
		$res->uid = $dateAndUid["uid"];
		$res->contents = $this->contentsFactory->create($elm[$i++]);
		$res->title = $elm[$i++];
		$res->anchors = $this->parseAnchor($res->contents -> raw());
		// $result["movie_flg"] = $this->hasMovie($result["contents"]);
		return $res;
	}
	
	private function parseDateAndUid($str) {
		$a = explode(" ID:", $str);
		return array("date" => $a[0], "uid" => $a[1]);
	}
	
	public function parseAnchor($str) {
		$str = preg_replace('@<a(?:>| [^>]*?>)(.*?)</a>@s','$1',$str);
		preg_match_all("/&gt;&gt;([0-9]+)/", $str, $a);
		
		$numbers = array();
		foreach ($a[1] as $num) {
			$numbers[] = intval($num);
		}
		
		return $numbers;
	}
	
	private function hasMovie($str) {
		return strpos($str,"youtube.com") !== false;
	}
	
	
	private function recieveAnchorCount($resAry) {
		$result = array();
		
		foreach ($resAry as $res) {
			$result[] = $res;
			foreach($res["anchors"] as $index) {
				$hi_res = $result[$index];
				if(!isset($hi_res["recieve_anchor_count"])) {
					$hi_res["recieve_anchor_count"] = 0;
				}
				$hi_res["recieve_anchor_count"]++;
				$result[$index] = $hi_res;
			}
		}
		return $result;
	}
	
	
	public function create($strDat) {
		return $this->createFromStr($strDat);
	}
}

//$a = new ThreadFactory();
//$a->test();


