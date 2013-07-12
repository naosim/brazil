<?php
/*
 * 実験用
 */
$fp = fopen($argv[1], 'r');
$count =0;
while (!feof($fp)) {
	if($count > 30){ break; }
	$line = fgets($fp);
	preg_match("/youtube.com\/watch\?v=([0-9a-zA-Z-].*?)\s/", $line, $youtubeId);
	$htmlsrc = '<iframe width="640" height="360" src=' . "http://www.youtube.com/embed/$youtubeId[1]". 
	       ' frameborder="0" allowfullscreen></iframe>';
	print $line. "<br/>";
	print $htmlsrc . "<br/>";
	$count++;
}