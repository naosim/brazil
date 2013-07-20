<?php
require_once "test/TestCase.php";
require_once "MovieThreadFactory.php";

class MovieThreadFactoryTest extends TestCase {
	public function test_hoge( ) {
		$factory = new MovieThreadFactory();
		$filename = "1372499828.dat";
		$strDat = file_get_contents("dat/$filename");
		
		$factory = new MovieThreadFactory();
		$result = $factory->create($strDat);
		$this -> assertSameType(new MovieThread(null), $result, "movie not exist");
		$this -> assertEq(3, count($result -> movies()), "movie count");
		
	}
}

$test = new MovieThreadFactoryTest();
$test -> runTest();
