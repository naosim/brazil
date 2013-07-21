<?php
require_once "test/TestCase.php";
require_once "ThreadTitleSearch.php";

class ThreadTitleSearchTest extends TestCase {
	public function test() {
		$subjectUrl = "http://ikura.2ch.net/football/subject.txt";
		
		// $search = new ThreadTitleSearch(new WebLoaderMock());
		$search = new ThreadTitleSearch();
		$result = $search -> search('http://ikura.2ch.net/football/', array('日本'));
		print_r($result);
	}
}

class WebLoaderMock extends WebLoader {
	public function load($url) {
		$result = file_get_contents("test/sampleData/subject.txt"); 
		$result = mb_convert_encoding($result, 'utf8', 'sjis-win');
		return $result;
	}
}

$test = new ThreadTitleSearchTest();
$test->runTest();
