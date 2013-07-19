<?php
	require_once 'BoardFactory.php';
	
	$datpath = "youtubedat/";
	$ch = "grep youtube * | awk -F: '{print $1}'|uniq";
	
	$all_mem = array();
	$searchWord = "日本人";
	$youtubeList = array("1374067281.dat" , "1373863281.dat");
	
	//print_r($youtubeList);	

	foreach ($youtubeList as  $dat){
		$tmp = new BoardFactory($dat);
		$all_mem["$dat"] = $tmp->create($dat);
	}
	

	hasSearchWord($all_mem, $searchWord);
	
	function hasSearchWord($allmem,$word){

		foreach ($allmem as $key => $thread){
			
			if(strpos($thread["contents"],$word)) {
				return $key;
			}
		}
		
		
	}

	
			


