<?php
require_once "MovieThreadFactory.php";

class ThreadTitleSearch {
	private $webLoader;
	
	public function __construct($webLoader = null) {
		$this -> webLoader = $webLoader ? $webLoader : new WebLoader();
	}

	/**
	 * スレッド名で検索して、ヒットしたdat名の配列を返す
	 *
	 * @return array
	 */
	public function search($boardUrl, $searchWords = null) {
		$this -> boardUrl = $boardUrl;
		$this -> subjectUrl = $boardUrl . "subject.txt";
		$datNames = $this -> getSubjectList($this -> subjectUrl, $searchWords);
		
		$result = array();
		foreach ($datNames as $datName) {
			$threadRaw = $this -> getDatfile($boardUrl, $datName);
			
			// 動画が無い場合はキャンセル
			// if(!MovieThreadFactory::hasMovie($threadRaw)) continue;

			$outFileName = "./dat/$datName";
			$file = fopen($outFileName, "w");
			fputs($file, $threadRaw);
			fclose($file);
			$result[] = $outFileName;
		}
		
		return $datNames;
	}

	public function getSubjectList($subjectUrl, $searchWords = null) {
		// ネットから撮ってくる
		$curl_result = trim($this -> webLoader -> load($subjectUrl));
		
		// 検索キーワードを含むものを探す
		$searchStr = $searchWords == null ? "" : implode('|', $searchWords);
		preg_match_all("/.*($searchStr).*\n/", $curl_result, $datGrepResult);
		$result = $datGrepResult[0];
		
		// dat名だけにする
		$count = count($result);
		for ($i=0; $i < $count; $i++) {
			$a = explode("<>", $result[$i]);
			$result[$i] = $a[0];
		}
		return $result;
	}
	
	public function getDatfile($boardUrl, $datname) {
		$datUrl = $boardUrl . "dat/" . $datname; 
		return $this -> webLoader -> load($datUrl); 
	}
	
	
}

class WebLoader {
	public function load($url) {
		$ch = curl_init();
		$result = "";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Monazilla/1.00 (kanata/1.00)');
		//proxy setting
		//curl_setopt($ch, CURLOPT_PROXY, '');
		$result = curl_exec($ch);
		curl_close($ch);
		$result = mb_convert_encoding($result, 'utf8', 'sjis-win');
		
		return $result;
	}

}
