<?php
header('Content-type: text/html; charset=utf-8');
require_once 'utility/cn_db.php';
$val=$_GET["user"];
$val1=$_GET["class"];
if(strcmp($val,'m10')==0){
	try{
	$db=dbconn();
if(strcmp($val1,'News')==0)
    $query="select * from AthenaNews ORDER BY  `id` ASC ";
if(strcmp($val1,'Performance')==0)
    $query="select * from AthenaPerformance ORDER BY  `id` ASC ";
if(strcmp($val1,'Piloti')==0)
    $query="select * from AthenaPiloti ORDER BY  `id` ASC ";
if(strcmp($val1,'Ufo_Plast_News')==0)
    $query="select * from UfoNews ORDER BY  `id` ASC ";
if(strcmp($val1,'UfoPiloti')==0)
    $query="select * from UfoPiloti ORDER BY  `id` ASC ";
if(strcmp($val1,'FBNews')==0)
    $query="select * from FBNews ORDER BY  `id` ASC ";

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