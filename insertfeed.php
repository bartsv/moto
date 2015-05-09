<?php
    include("feed.php");
$filename="datafeed.txt";
$fp = fopen($filename, "r");
$letto=fread($fp, filesize($filename));
fclose($fp);
if(strcmp($letto, "")==0){
		$fp=fopen($filename, "w");
		if (flock($fp, LOCK_EX)) { // Esegue un lock esclusivo
		    fwrite($fp, time().'');
		    flock($fp, LOCK_UN); // rilascia il lock
		} else {
		    echo "Non si riesce ad eseguire il lock del file !";
		}
		fclose($fp);
	$mes="";
$mes=generaPerf("http://www.athenaparts.com/nodes/promoted.rss",$mes);
$mes=genera_News_Athena("http://pipes.yahoo.com/pipes/pipe.run?_id=f63cae3e6f999f2d4b91d160ff38aab9&_render=rss",$mes);
	//echo "<br>aa<br>".$mes;
$mes=fb_parse_feed("http://pipes.yahoo.com/pipes/pipe.run?_id=ff0a7b425eb2af46388c930cd7addde1&_render=rss", $mes);
$mes=generaNews("http://www.mxlarge.com/feed/",$mes);
	$mes=generaNews("http://www.mxnews.net/feed/",$mes);
       creaMess($mes);}
else
if ($letto+900<=time()) {
		$fp=fopen($filename, "w");
		if (flock($fp, LOCK_EX)) { // Esegue un lock esclusivo
		    fwrite($fp, time().'');
		    flock($fp, LOCK_UN); // rilascia il lock
		} else {
		    echo "Non si riesce ad eseguire il lock del file !";
		}
		fclose($fp);

	$mes="";
$mes=generaPerf("http://www.athenaparts.com/nodes/promoted.rss",$mes);
$mes=genera_News_Athena("http://pipes.yahoo.com/pipes/pipe.run?_id=f63cae3e6f999f2d4b91d160ff38aab9&_render=rss",$mes);
	//echo "<br>aa<br>".$mes;
$mes=fb_parse_feed("http://pipes.yahoo.com/pipes/pipe.run?_id=ff0a7b425eb2af46388c930cd7addde1&_render=rss", $mes);
$mes=generaNews("http://www.mxlarge.com/feed/",$mes);
	$mes=generaNews("http://www.mxnews.net/feed/",$mes);
       creaMess($mes);}
?>