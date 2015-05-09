<?php
require_once 'utility/cn_db.php';
$val=$_GET["user"];
$val1=$_GET["class"];
if(strcmp($val,'m10')==0){
$db=dbconn();
if(isset($val1))
    $query="select MAX(Circuito) from risultati_gare_".$val1;
$sql = $db->prepare($query);
		$sql->execute(); 
$e = $sql->fetch();
        $output=$e[0];
if(empty($output))
echo "0";
else
echo $output;
$db=null;
}
?>