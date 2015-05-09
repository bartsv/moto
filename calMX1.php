<?php
require_once 'utility/cn_db.php';
$val=$_GET["user"];
$val1=$_GET["class"];
if(strcmp($val,'m10')==0){
try{
$db=dbconn();
if(strcmp($val1,'MX1')==0)
    $query="select * from calendarioMX1";
if(strcmp($val1,'MX2')==0)
    $query="select * from calendarioMX2";
if(strcmp($val1,'MX3')==0)
    $query="select * from calendarioMX3";

if(strcmp($val1,'WMX')==0)
    $query="select * from calendarioWMX";
$sql = $db->prepare($query);
		$sql->execute(); 
while($e = $sql->fetch(PDO::FETCH_ASSOC))
        $output[]=$e;
print(json_encode($output));
$db=null;
     }catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
}
    ?>