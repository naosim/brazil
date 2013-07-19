<?php
require_once "test/TestCase.php";

/**
 * テスト用のサンプル
 */
class TestHoge extends TestCase {
	public function __construct() {

	}

	public function hoge() {
		echo "testで始まってないから実行されない";
	}

	public function testhoge1() {
		$this -> assertEq(true, "err");
	}

	public function testhoge2() {
		$this -> assertEq(true, "err");
	}

}

$a = new TestHoge();
$a -> runTest();

