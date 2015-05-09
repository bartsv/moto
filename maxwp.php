<?php
require_once 'utility/cn_db.php';
$val=$_GET["user"];
$val1=$_GET["class"];
if(strcmp($val,'m10')==0){
$db=dbconn();
if(isset($val1))
    $query="select MAX(Circuito) AS Circuito,tipo from risultati_gare_".$val1;
$sql = $db->prepare($query);
		$sql->execute(); 
$db=null;
$e = $sql->fetch();
        $output0=$e[0];
       $output1=$e[1];
if(empty($output0) && empty($output1)){
$output0=0;
       $output1=$val1;
}
echo "[{\"Circuito\":\"".$output0."\",\"tipo\":\"".$output1."\"}]";
}
?>