<?php
require_once "test/TestCase.php";
require_once "Res.php";

class ContentsTest extends TestCase {
	public function test() {
		$str = 'aaaa<a href="http://hoge.com/123/45" target="_blank">44d4</a>5555<br>bbbbb<a href="http://foo.com/123/18" target="_blank">12111</a>99999';
		$c = new Contents($str);
		$act = $c -> html();
		$this -> assertEq('aaaa<a href="45">44d4</a>5555<br>bbbbb<a href="18">12111</a>99999', $act, "aa");
	}
}

$test = new ContentsTest();
$test -> runTest();
