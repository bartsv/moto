<?php
header('Content-Type: text/html; charset=utf-8');
require_once 'utility/cn_db.php';
$val=$_GET["user"];
$val1=$_GET["tipo"];
if(strcmp($val,'m10')==0){
$db=dbconn();
if(strcmp($val1,'MX1')==0)
    $query="select * from NewsMX1 ORDER BY  `NewsMX1`.`id` DESC  ";
if(strcmp($val1,'MX1I')==0)
    $query="select * from `NewsMX1_inglese` ORDER BY  `NewsMX1_inglese`.`id` DESC  ";
if(strcmp($val1,'MX1_inglese')==0)
    $query="select * from `NewsMX1_inglese` ORDER BY  `NewsMX1_inglese`.`id` DESC  ";

if(strcmp($val1,'MX2')==0)
    $query="select * from NewsMX2 ORDER BY  `NewsMX2`.`id` DESC ";
if(strcmp($val1,'MX2I')==0)
    $query="select * from `NewsMX2_inglese` ORDER BY  `NewsMX2_inglese`.`id` DESC ";
if(strcmp($val1,'MX2_inglese')==0)
    $query="select * from `NewsMX2_inglese` ORDER BY  `NewsMX2_inglese`.`id` DESC ";
$sql = $db->prepare($query);
		$sql->execute(); 
$db=null;
while($e = $sql->fetch(PDO::FETCH_ASSOC))
        $output[]=$e;
print(json_encode($output));
}
    ?>