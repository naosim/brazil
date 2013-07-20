<?php
require_once "MovieThreadFactoryTest.php";
require_once "ThreadFactoryTest.php";


class TestAll extends TestCase {
	
	public function test_All() {
		
		$testCases = array(
			new ThreadFactroyTest(),
			new MovieThreadFactoryTest()
		);
		
		foreach ($testCases as $testCase) {
			$testCase -> runTest();
		}
	}
}

$test = new TestAll();
$test -> runTest();
