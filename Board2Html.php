<?php
class Board2Html {
	public function create($boards) {
		$result = $this->createHeader();
		
		foreach ($boards as $board) {
			$result .= $this->createBordHtml($board);
		}
		$result .= $this->createFooter();
		return $result;
	}
	
	public function createHeader() {
		return '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="description" content="Bootbusiness | Short description about company"><meta name="author" content="Your name"><title>Bootbusiness | Give unique title of the page here</title><!-- Bootstrap --><link href="css/bootstrap.min.css" rel="stylesheet"><!-- Bootstrap responsive --><link href="css/bootstrap-responsive.min.css" rel="stylesheet"><!-- Font awesome - iconic font with IE7 support --> <link href="css/font-awesome.css" rel="stylesheet"><link href="css/font-awesome-ie7.css" rel="stylesheet"><!-- Bootbusiness theme --><link href="css/boot-business.css" rel="stylesheet"></head><body><!-- Start: HEADER --><header><!-- Start: Navigation wrapper --><div class="navbar navbar-fixed-top"><div class="navbar-inner"><div class="container"><a href="index.html" class="brand brand-bootbus">Bootbusiness</a><!-- Below button used for responsive navigation --></div></div></div><!-- End: Navigation wrapper --></header><!-- End: HEADER --><!-- Start: Main content --><div class="content"><div class="container"><!-- Start: Product description --><airticle class="article">';
	}
	
	public function createFooter() {
		return '</airticle><!-- End: Product description --></div></div></div><!-- End: Main content --><script type="text/javascript" src="js/jquery.min.js"></script><script type="text/javascript" src="js/bootstrap.min.js"></script><script type="text/javascript" src="js/boot-business.js"></script></body></html>';
	}
	
	
	
	public function createBordHtml($board) {
		// $board["name"];
		$urls = $board['movie_urls'];
		
		$result = "";
		$result .= $this->getYoutubeMovie($urls[0]) . '<br>';
		
		// print_r($board["reses"]);
		
		$resWithMovie = $this->getResesWithMovie($board["reses"]);
		print_r($resWithMovie);
		$result .= $this->getResHtml($board["reses"]) . '<br>';
		
		return $result;
	}
	
	public function getYoutubeMovie($url) {
		$ary = explode("?v=", $url);
		$movieId = $ary[1];
		return '<iframe width="420" height="315" src="//www.youtube.com/embed/' . $movieId . '" frameborder="0" allowfullscreen></iframe>';
		// <iframe width="420" height="315" src="//www.youtube.com/embed/IYY8xYXq5Fw" frameborder="0" allowfullscreen></iframe>
		
	}
	public function getResesWithMovie($reses) {
		$result = array();
		foreach ($reses as $res) {
			if($res["movie_flg"] == true) {$result[] = $res;}
			
		}
		return $result;
	}
	
	public function getResHtml($reses) {
		$result ="";
		foreach ($reses as $res) {
			$result .= 'name: ' . $res["name"] . '<br>';
			$result .= $res["contents"] . '<br><hr>';
		}
		
		return $result;
	}
	
	public function test() {
		$movie_urls = array("http://www.youtube.com/watch?v=IYY8xYXq5Fw", "http://www.yahoo.co.jp");
		$res0 = array("name"=>"aaaa", "contents"=>"hogehoge", "movie_flg", true);
		$res1 = array("name"=>"bbbb", "contents"=>"hogehoge", "movie_flg", true);
		$res2 = array("name"=>"cccc", "contents"=>"hogehoge");
		$reses = array($res0, $res1, $res2);
		$board = array("name"=>"title", "movie_urls" => $movie_urls, "reses"=>$reses);
		
		$boards = array($board);
		$result = $this->create($boards);
		
		print_r($result);
	} 
}

$a = new Board2Html();
$a->test();
