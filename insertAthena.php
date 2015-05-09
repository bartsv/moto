<?php
require_once 'utility/cn_db.php';
session_start();
$db=conect();
if(isset($_SESSION['user'])){
$titolo=$_POST['titolo'];
$testo=$_POST['test'];
$classe=$_POST['classe'];
$tit=$_POST['titolo'];
$tit=trim($tit);
$nomevers="";
$testo=str_replace("\n", "<br>", $testo);
$titolo=htmlentities($titolo);
$tit=htmlentities($tit);
$titolo=trim($titolo);
$titolo=addslashes($titolo);
$testo=htmlentities($testo,ENT_QUOTES, "UTF-8");
$titolo=htmlentities($titolo,ENT_QUOTES, "UTF-8");

$tit=htmlentities($tit,ENT_QUOTES, "UTF-8");
$testo=str_replace("&lt;br&gt;","<br>",$testo);

$testo=trim($testo);
$testo=addslashes($testo);
$t=str_replace(' ','',$titolo);
//creazione file html
echo 'crea file<br>';
if(strcmp($test,' ')!=0 && strcmp($titolo,' ')!=0){
//echo "qui";

$contenuto='<!doctype html> 
<html manifest="'.$t.'.manifest"> 
<head>
  <title>news</title> 
  <link rel="stylesheet" href="prova/monitor.css" media="screen">
  <link rel="stylesheet" href="prova/iphone.css"
          media="screen and (max-device-width: 480px) and (orientation: portrait)">
</head>
<body> 
  <header>
    <hgroup>';
	if(strcmp($classe, 'News')==0) 
    	$contenuto=$contenuto.'<img src="imm/athenanews.jpg" />';
    else
		$contenuto=$contenuto.'<img src="imm/athenaperf.jpg" />';
      $contenuto=$contenuto.'<h1>'.$tit.'</h1> 
      </hgroup> 
  </header>
  <section>
  <article> 
    <p>'.$testo.'</p>
</article> 
  </section>
</body></html>';
$titolo=str_replace('.','',$titolo);
$titolo=str_replace('!','',$titolo);
$titolo=str_replace('?','',$titolo);
$titol=str_replace(' ','%20',$titolo);

$cachecontenuto="CACHE MANIFEST \n\r".$titol.".html\nprova/monitor.css\nprova/iphone.css\nimm/athenanews.jpg\nimm/athenaperf.jpg";
 if (file_exists("./Athena/" .$titolo.".html")){
mysql_close($db);
echo "file esistente";
}
else{
if(!empty($titolo)&& !empty($testo) ){
$t=  str_replace(' ','',$titolo);
$t=str_replace(".","",$t);
$t=str_replace("?","",$t);
$t=str_replace("!","",$t);
file_put_contents('./Athena/'.$t.'.html', $contenuto);
file_put_contents('./Athena/'.$t.'.manifest', $cachecontenuto);  
$news="";
echo 'news '.$tit;
$_SESSION['news']=1;
$_SESSION['classe']=$_SESSION['classe'].",Athena".$classe."-".$tit;
if(strcmp($classe, 'News')==0) 
$query="INSERT INTO Athena".$classe." (`titolo`, `news`) VALUES ( '".$tit."', 'http://www.bartolomeoberrino.it/motocross/Athena/".$titolo.".html')";
else
$query="INSERT INTO Athena".$classe." (`titolo`, `text`) VALUES ( '".$tit."', 'http://www.bartolomeoberrino.it/motocross/Athena/".$titolo.".html')";
$res=mysql_query($query);
echo "<br>file inserito con successo";
mysql_close($db);

header("refresh: 5; url=login.php");
exit;
}
else
echo "<br>Impossibile inerire la news,manca il titolo od il testo";
}
}
}
mysql_close($db);

header("refresh: 5; url=login.php");
exit;
?>