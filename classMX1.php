<?php
require_once 'utility/cn_db.php';
$val=$_GET["user"];
$val1=$_GET["class"];
if(strcmp($val,'m10')==0){
$db=dbconn();
if(strcmp($val1,'MX1')==0)
   $query="SELECT * FROM `ClassificaMX1`  order by `Punti` Desc";
if(strcmp($val1,'MX2')==0)
   $query="SELECT * FROM `ClassificaMX2` order by `Punti` Desc";
if(strcmp($val1,'MX3')==0)
   $query="SELECT * FROM `ClassificaMX3` order by `Punti` Desc";
if(strcmp($val1,'WMX')==0)
   $query="SELECT * FROM `ClassificaWMX` order by `Punti` Desc";

//$query="SELECT `Posizione`,`Riders`,`Punti` FROM `ClassificaMX1`order by `Punti` Desc";
$sql = $db->prepare($query);
		$sql->execute(); 
$db=null;
while($e = $sql->fetch(PDO::FETCH_ASSOC))
        $output[]=$e;
print(json_encode($output));
}
    ?>