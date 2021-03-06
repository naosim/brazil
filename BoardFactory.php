<?php
require_once "ThreadFactory.php";
require_once "Board2Html.php";

class BoardFactory {
	
	/* datを選ぶ(人気からとか) */
	public function datPickUp(){
		
	}
	
	public function create($datname){
		
		$board = array();
		
		$th = new ThreadFactory($datname);
		$reses = $th->create();
		$board['name'] = $reses[0]["title"];
		$board['movie_flg'] = $this->hasMovie($reses);
		$board['reses'] = $reses;
		if($board['movie_flg']){
			$board['movie_urls'] = $this->getMovieUrl($reses);
		}
		//print_r($board);
		return $board;
	}
	
	public function hasMovie($reses) {
		
		foreach ($reses as $res){
			if($res["movie_flg"]){
				return true;
			}
		}
		return false;
	}
	
	public function getMovieUrl($reses){
		$result = array();
		foreach ($reses as $res) {
			if(!$res["movie_flg"]){
				continue;
			}
			
// 			print_r($res);
			preg_match_all("/(youtube.com\/watch\?v=[0-9a-zA-Z-].*?)\s/", $res["contents"], $a);
			//print_r($a);
			foreach ($a[1] as $url){
				$result[] = $url;
			}
		}
		return $result;
	}
	
}

$test = new BoardFactory();
$board = $test->create("1265652965.dat");

$boards = array($board);



$html = new Board2Html();
$html_out = $html->create($boards);
print_r($html_out);

