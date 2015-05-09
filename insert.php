<?php
require_once 'utility/cn_db.php';
session_start();
$db=dbconn();
if(isset($_SESSION['user'])){
$titolo=$_POST['titolo'];
$testo=$_POST['test'];
$classe=$_POST['classe'];
$lingua=$_POST['ling'];
$tit=$_POST['titolo'];
$tit=trim($tit);
$nomevers="";
if(strcmp($lingua,'ing')==0){
$titolo=$titolo.'I';
$nomevers="Ufo_Plast_News";
}else{
$nomevers="Ufo_Plast_News";
}
if(strcmp($classe,'News')==0){
$image="prova/Head.png";
}
else{
$image="prova/Head1.png";
}
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
echo "Size: " . ($_FILES["file"]["size"] ) . " kB<br>";
echo "Upload: " . $_FILES["file"]["name"] . "<br>";
//carica immagine
$allowedExts = array("gif", "jpeg", "jpg", "png");
$extension = end(explode(".", $_FILES["file"]["name"]));
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
||($_FILES["file"]["type"] == "image/GIF")
|| ($_FILES["file"]["type"] == "image/JPEG")
|| ($_FILES["file"]["type"] == "image/JPG")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

    if (file_exists("./UFO/imageUfo/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "UFO/imageUfo/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "./UFO/imageUfo/" . $_FILES["file"]["name"];
      }
    }
  }
else
  {
  echo "Invalid file";
  }
//immagine caricata
//creazione file html
echo 'crea file<br>';
if(strcmp($test,' ')!=0 && strcmp($titolo,' ')!=0){
//echo "qui";
$titol=str_replace(" ","",$titolo);
$contenuto='<!doctype html> 
<html manifest="'.$titol.'.manifest"> 
<head>
  <title>news</title> 
  <link rel="stylesheet" href="prova/monitor.css" media="screen">
  <link rel="stylesheet" href="prova/iphone.css"
          media="screen and (max-device-width: 480px) and (orientation: portrait)">
</head>
<body> 
  <header>
    <hgroup> 
      <img src="'.$image.'">
      <h1>'.$tit.'</h1> 
      </hgroup> 
  </header>
  <section>
  <article> 
  	<img src="imageUfo/'.$_FILES["file"]["name"].'" />
    <p>'.$testo.'</p>
</article> 
  </section>
  <footer><p>'.$sito.'</p></footer>
</body></html>';
echo $contenuto;
$titol=str_replace(" ","%20",$titolo);
$tito=str_replace(" ","",$titol);$tito=str_replace("?","",$titol);$tito=str_replace("!","",$titol);
$cachecontenuto="CACHE MANIFEST \n\r".$titol.".html\nprova/monitor.css\nprova/Head.jpg\nprova/Head1.jpg\nprova/iphone.css\nimm/".$_FILES["file"]["name"];
 if (file_exists("./UFO/" .$titolo.".html")){
$db=null;
echo "file esistente";
}
else{
if(!empty($titolo)&& !empty($testo) ){

$tito=str_replace(" ","",$titolo);$tito=str_replace("?","",$tito);$tito=str_replace("!","",$tito);
file_put_contents('./UFO/'.$tito.'.html', $contenuto); 
file_put_contents('./UFO/'.$tito.'.manifest', $cachecontenuto);  
$news="";
echo 'news '.$tit;
$_SESSION['news']=1;
$_SESSION['classe']=$_SESSION['classe'].",".$nomevers."-".$tit;
$db->beginTransaction();
$query="INSERT INTO UfoNews (`titolo`, `news`,`lingua`,`tipo`) VALUES ( '".$tit."', 'http://www.bartolomeoberrino.it/motocross/UFO/".$tito.".html','".$lingua."','".$classe."')";
$sql = $db->exec($query);
			 $db->commit();
echo "<br>file inserito cos successo<br>".$query."<br>".$_SESSION['classe'];
$db=null;

}
else
echo "<br>Impossibile inerire la news,manca il titolo od il testo";
}
}
}
$db=null;
header("refresh: 5; url=login.php");
exit;
?>