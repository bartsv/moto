<?php
require_once 'utility/cn_db.php';
getVersion();
function getVersion(){
/*$filename="data.txt";
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
	$db=dbconn();
	$qu="SELECT nome_vers,valore FROM `versioni`;";
	$sql = $db->prepare($qu);
	   		 $sql->execute();
	while($e=$sql->fetch(PDO::FETCH_ASSOC)){
	     $output[]=$e;
	}
	$db=null;
	file_put_contents("versione.json", json_encode($output));
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
	$db=dbconn();
	$qu="SELECT nome_vers,valore FROM `versioni`;";
	$sql = $db->prepare($qu);
	   		 $sql->execute();
	while($e=$sql->fetch(PDO::FETCH_ASSOC)){
	     $output[]=$e;
	}
	$db=null;
	file_put_contents("versione.json", json_encode($output));
	}
  */       $json_file = file_get_contents('versione.json');
         echo $json_file;
}
?>