<?php
require_once 'utility/cn_db.php';
$val=$_GET["user"];
$val1=$_GET["tipo"];
if(strcmp($val,'m10')==0){
$db=dbconn();
if(strcmp($val1,'MX1')==0)
    $query="select * from videoMX1 ORDER BY  `id` DESC ";

if(strcmp($val1,'MX2')==0)
    $query="select * from videoMX2 ORDER BY `id` Desc ";
if(strcmp($val1,'MX3')==0)
    $query="select * from videoMX3 ORDER BY `id` Desc ";
if(strcmp($val1,'WMX')==0)
    $query="select * from videoWMX ORDER BY  `id` DESC ";
$sql = $db->prepare($query);
$sql->execute();
while($e=$sql->fetch(PDO::FETCH_ASSOC))
        $output[]=$e;
print(json_encode($output));
$db=null;
}
    ?>