<?php
header('Access-Control-Allow-Origin: *');
require_once 'utility/cn_db.php';
$val=$_GET["user"];
$val1=$_GET["class"];
if(strcmp($val,'m10')==0){
$db=conect();
if(strcmp($val1,'MX1')==0)
    $query="select * from calendarioMX1";
if(strcmp($val1,'MX2')==0)
    $query="select * from calendarioMX2";
if(strcmp($val1,'MX3')==0)
    $query="select * from calendarioMX3";

if(strcmp($val1,'WMX')==0)
    $query="select * from calendarioWMX";
$res=mysql_query($query);
mysql_close($db);
$num=mysql_num_rows($res);
while($e=mysql_fetch_assoc($res))
        $output[]=$e;
print(json_encode(array('item' => $output)));
}
    ?>