<?php
require_once 'utility/cn_db.php';
require 'utility/push.php';
include("calmoto.php");
date_default_timezone_set('Europe/Rome');
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

?>