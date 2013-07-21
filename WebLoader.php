<?php

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
