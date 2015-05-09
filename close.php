<?php
require 'utility/push.php';
require_once 'utility/cn_db.php';

header("refresh: 10;url= http://www.bartolomeoberrino.it/motocross/News.html");
session_start();
$valori=trim($_SESSION['classe']);
$val=explode(',', $valori);
$stack=array();
$mes="";
	for($i=1;$i<count($val);$i++){
		$tit=explode('-', $val[$i]);
		$temp=$tit[0];
			if(!in_array($tit[0], $stack)){
			$temp=$tit[0];
			if(strpos($temp,'NewsMX1')!==false)
			$temp="NewsMX1";
			if(strpos($temp,'NewsMX2')!==false)
			$temp="NewsMX2";
			if(strpos($mes,$temp.':')===false)
			$mes=$mes.$temp.":".$tit[1];
			else
				$mes=$mes.','.$tit[1];
			array_push($stack, $tit[0]);
		}
	else
		$mes=$mes.','.$tit[1];
}
print_r($stack);
echo "<br>mes ".$mes."<br>";
if($_SESSION['news']==1){
$db=dbconn();

	for($i=0;$i<count($stack);$i++){
	$query="select valore from versioni where nome_vers = '".$stack[$i]."'";
	echo $query.'<br>';
        $val=$stack[$i];
	$sql = $db->prepare($query);
	   		 $sql->execute();
	$row = $sql->fetch();
	echo $row[0];
	$num=$row[0]+1;
        $pagina = file_get_contents('versione.json');
$json_output = json_decode($pagina, true);
print $pagina;
$json_output[$val]=$num;
 file_put_contents("versione.json", json_encode($json_output));
	$query="update versioni  set valore=".$num." where nome_vers = '".$stack[$i]."'";
	$sql = $db->prepare($query);
	   		 $sql->execute();
	echo "versione ora ".$num." versione peima ".$row[0];
	}
$mes=str_replace("videoMX3:","video EMX125:",$mes);
echo $mes;
$db=null;
$lung=strlen($mes);
if($lung>200)
$mes='Nuove News disponibili per te';
if(strlen($mes)>2)
Invia($mes);
}
if(isset($_SESSION['user']))
 session_destroy();
echo "<br>Arrivederci a presto";
exit;
?>