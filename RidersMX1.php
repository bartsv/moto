<?php
require_once 'utility/cn_db.php';
$val=$_GET["user"];
$val1=$_GET["class"];
if(strcmp($val,'m10')==0){
if(strcmp($val1,'MX1')==0)
    $query="select * from Riders";
if(strcmp($val1,'MX2')==0)
    $query="select * from RidersMX2";
if(strcmp($val1,'MX3')==0)
    $query="select * from RidersMX3";
if(strcmp($val1,'WMX')==0)
    $query="select * from RidersWMX";
header('Content-type: text/html;charset=utf-8');
$db=dbconn();
$sql = $db->prepare($query);
$sql->execute();
while($e=$sql->fetch(PDO::FETCH_ASSOC)){
       $r[] = $e;
}
$db=null;
echo json_encode($r);
}
    ?>