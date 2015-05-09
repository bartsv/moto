<?php
require_once 'utility/cn_db.php';
$val=$_GET["user"];
$val1=$_GET["class"];
$val2=$_GET['circuito'];
$w="where Circuito=".$val2;
if(isset($val2))
$w="where Circuito>=".$val2." ";
if(strcmp($val,'m10')==0){
$db=dbconn();
if(strcmp($val1,'MX1')==0)
    $query="SELECT Circuito,sessione,Posizione,Numero,Riders,Nazionalita,Federazione,Bike,laps,Tempo,distacco_primo,distacco_pos,bestLap,tipo
FROM  `risultati_gare_MX1`  ".$w."
ORDER BY sessione,  `Posizione` ASC ";
if(strcmp($val1,'MX2')==0)
    $query="SELECT Circuito,sessione,Posizione,Numero,Riders,Nazionalita,Federazione,Bike,laps,Tempo,distacco_primo,distacco_pos,bestLap,tipo
FROM  `risultati_gare_MX2`   ".$w."
ORDER BY sessione,  `Posizione` ASC ";
if(strcmp($val1,'MX3')==0)
    $query="SELECT Circuito,sessione,Posizione,Numero,Riders,Nazionalita,Federazione,Bike,laps,Tempo,distacco_primo,distacco_pos,bestLap,tipo
FROM  `risultati_gare_MX3`    ".$w."
ORDER BY sessione,  `Posizione` ASC ";
if(strcmp($val1,'WMX')==0)
    $query="SELECT Circuito,sessione,Posizione,Numero,Riders,Nazionalita,Federazione,Bike,laps,Tempo,distacco_primo,distacco_pos,bestLap,tipo
FROM  `risultati_gare_WMX`   ".$w."
ORDER BY sessione,  `Posizione` ASC ";
$sql = $db->prepare($query);
$sql->execute();
while($e=$sql->fetch(PDO::FETCH_ASSOC))
        $output[]=$e;
print(json_encode($output));
$db=null;
}
    ?>