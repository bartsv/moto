<?php
require_once 'utility/cn_db.php';
$val=$_GET["user"];
$val1=$_GET["class"];
if(strcmp($val,'m10')==0){
$db=dbconn();
if(strcmp($val1,'MX1')==0)
    $query="select * from classifica_moto_MX1 ORDER BY  `classifica_moto_MX1`.`punti` DESC ";
if(strcmp($val1,'MX2')==0)
    $query="select * from classifica_moto_MX2 ORDER BY  `classifica_moto_MX2`.`punti` DESC ";
if(strcmp($val1,'MX3')==0)
    $query="select * from classifica_moto_MX3 ORDER BY  `classifica_moto_MX3`.`punti` DESC ";
if(strcmp($val1,'WMX')==0)
    $query="select * from classifica_moto_WMX ORDER BY  `classifica_moto_WMX`.`punti` DESC ";
$sql = $db->prepare($query);
		$sql->execute();
while($e = $sql->fetch(PDO::FETCH_ASSOC))
        $output[]=$e;
$db=null;
print(json_encode($output));
}
    ?>