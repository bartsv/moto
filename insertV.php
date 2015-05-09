<?php
require_once 'utility/cn_db.php';
session_start();
$db=dbconn();
if(isset($_SESSION['user'])){
$v=$_GET['classe'];
$titolo=$_GET['titolo'];
$sito=$_GET['sito'];
//echo $titolo." ".$sito." ".$v;
$titolo=trim($titolo);
$titolo=addslashes($titolo);
$titolo=htmlentities($titolo);
$sito=trim($sito);
$sito=addslashes($sito);
$sito=htmlentities($sito);
$query="INSERT INTO `".$v."`( `Titolo`, `sito`) VALUES ('".$titolo."','".$sito."');";
//echo $query;
$sql = $db->prepare($query);
 $sql->execute();
$_SESSION['news']=1;
$_SESSION['classe']=$_SESSION['classe'].",".$v."-".$titolo;
}
$db=null;
echo "video inserito con successo!";
?>