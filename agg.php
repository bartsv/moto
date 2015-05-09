<?php
require_once 'utility/cn_db.php';
require 'utility/push.php';
include("calmoto.php");
$filename="datagare.txt";
$fp = fopen($filename, "r");
$letto=fread($fp, filesize($filename));
fclose($fp);
if(strcmp($letto, "")==0){
		$fp=fopen($filename, "w");
		if (flock($fp, LOCK_EX)) { // Esegue un lock esclusivo
		    fwrite($fp, time().'');
		    flock($fp, LOCK_UN); // rilascia il lock
		} else {
		    echo "Non si riesce ad eseguire il lock del file !";
		}
		fclose($fp);
 /*$db=conect();
        //vedo che giorno è e guardo se ci sono già i risultati
        $d= date('Y-m-d');
        $q="SELECT * from calendarioMX1 where data='$d'";
        
       $res=mysql_query($q);
        $num=mysql_num_rows($res);
        $row=mysql_fetch_row($res);
        $id_gara= $row[0];
mysql_close($db);
        */
       // if($num==1||$num==0){
    $agg=array(1,2,3,4,5,6);
$mes="";
   echo "<br><br>Ho ".count($agg)." Campionati<br><br>";
for ($up=0; $up<count($agg); $up++){
        
        echo"<br>Aggiorno: ".$agg[$up]."</br>";
        $mes=AggiornaCalendario($agg[$up],$mes);
      
	}
$lung=strlen($mes);
if($lung>10 && $lung<200)
Invia($mes);
else
if($lung>200)
Invia("Risultati Gare ora disponibili!");
//}
}
else
	if ($letto+710<=time()) {
		$fp=fopen($filename, "w");
		if (flock($fp, LOCK_EX)) { // Esegue un lock esclusivo
		    fwrite($fp, time().'');
		    flock($fp, LOCK_UN); // rilascia il lock
		} else {
		    echo "Non si riesce ad eseguire il lock del file !";
		}
		fclose($fp);
/*
 $db=conect();
        //vedo che giorno è e guardo se ci sono già i risultati
        $d= date('Y-m-d');
        $q="SELECT * from calendarioMX1 where data='$d'";
        
       $res=mysql_query($q);
        $num=mysql_num_rows($res);
        $row=mysql_fetch_row($res);
        $id_gara= $row[0];
mysql_close($db);
  */      
       // if($num==1||$num==0){
    $agg=array(1,2,3,4,5,6);
$mes="";
   echo "<br><br>Ho ".count($agg)." Campionati<br><br>";
for ($up=0; $up<count($agg); $up++){
        
        echo"<br>Aggiorno: ".$agg[$up]."</br>";
        $mes=AggiornaCalendario($agg[$up],$mes);
      
	}
$lung=strlen($mes);
if($lung>10 && $lung<200)
Invia($mes);
else
if($lung>200)
Invia("Risultati Gare ora disponibili!");
//}
}
?>