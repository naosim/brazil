<?php
require_once "test/TestCase.php";
require_once "ThreadFactory.php";

function undefine() {
	return "";
}

class ThreadFactroyTest extends TestCase {
	public function test_hoge() {
		$factory = new ThreadFactory();
		$filename = "1372499828.dat";
		$filename = file_get_contents("dat/$filename");
		$result = $factory -> create($filename);
		$this -> assertEq("fc岐阜", $result -> name(), "nameが正しい");
		$resAry = $result -> resArray();
		$this -> assertEq(125, count($resAry), "resArray count");

	}

	public function test_createRes() {
		$factory = new ThreadFactory();
		$resStr = 'さあ名無しさん、ここは守りたい<><>2013/06/29(土) 19:07:51.65 ID:Ki1/vEEi0<> <a href="../test/read.cgi/livefoot/1372499828/1" target="_blank">&gt;&gt;1</a>乙 <br>  <br> 今日も大逆転劇か。 <>';
		$res = $factory -> createRes($resStr);
		$this -> assertEq('2013/06/29(土) 19:07:51.65', $res -> writeDate -> strDate(), "writeDate");
		$this -> assertEq('Ki1/vEEi0', $res -> uid, "uid");
		$this -> assertEq(1, $res -> anchors[0], "anchors");
		$this -> assertEq(' <a href="../test/read.cgi/livefoot/1372499828/1" target="_blank">&gt;&gt;1</a>乙 <br>  <br> 今日も大逆転劇か。 ', $res -> contents -> raw(), "anchors");
	}

	public function test_parseAnchor() {
		$factory = new ThreadFactory();
		$str = ' <a href="../test/read.cgi/livefoot/1372499828/1" target="_blank">&gt;&gt;1</a>乙 <br>  <br> 今日も大逆転劇か。 ';
		$result = $factory -> parseAnchor($str);
		$this -> assertEq(1, $result[0], "anchors");
	}
	
	private function get() {
		return null;
	}
}
