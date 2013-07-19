<?php
require_once "ThreadFactory.php";

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
		print_r($board);
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
$test->create("1372845811.dat");
