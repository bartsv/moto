<?php
include("calmotoMX3.php");
include("utility/push.php");
require_once 'utility/cn_db.php';
 $filename="datagare1.txt";
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
$mes1="";
$mes2="";
   echo "<br><br>Ho ".count($agg)." Campionati<br><br>";
for ($up=0; $up<count($agg); $up++){
        
        echo"<br>Aggiorno: ".$agg[$up]."</br>";
        $mes=AggiornaCalendario($agg[$up],$mes);
      if($up<=3)
        $mes1=$mes1.AggiornaCalendario($agg[$up],$mes);
      else
$mes2=$mes2.AggiornaCalendario($agg[$up],$mes); 
	}
$lung=strlen($mes1);
if($lung>22 && $lung<200)
Invia2($mes1);
else
if($lung>200)
Invia2("Risultati Gare ora disponibili!");
$mes1=$mes1.";".$mes2;

$lung=strlen($mes1);
if($lung>2 && $lung<200)
Invia($mes1);
else
if($lung>200)
Invia("Risultati Gare ora disponibili!");
//}
}
else
	if ($letto+1800<=time()) {
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
$mes1="";
$mes2="";
   echo "<br><br>Ho ".count($agg)." Campionati<br><br>";
for ($up=0; $up<count($agg); $up++){
        
        echo"<br>Aggiorno: ".$agg[$up]."</br>";
        $mes=AggiornaCalendario($agg[$up],$mes);
        if($up<=3)
        $mes1=$mes1.AggiornaCalendario($agg[$up],$mes);
      else
$mes2=$mes2.AggiornaCalendario($agg[$up],$mes);      
	}
$lung=strlen($mes1);
if($lung>22 && $lung<200)
Invia2($mes1);
else
if($lung>200)
Invia2("Risultati Gare ora disponibili!");
$mes1=$mes1.";".$mes2;

$lung=strlen($mes1);
if($lung>2 && $lung<200)
Invia($mes1);
else
if($lung>200)
Invia("Risultati Gare ora disponibili!");
//}
}
 
?>