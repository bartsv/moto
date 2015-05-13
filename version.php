<?php
require_once 'utility/cn_db.php';

$tipo=addslashes(trim($_GET['tipo']));
getVersion($tipo);
function getVersion($valore){
/*$filename="data.txt";
$fp = fopen($filename, "r");
$letto=fread($fp, filesize($filename));
//echo $letto."zz";
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
	$db=dbconn;
		$qu="SELECT nome_vers,valore FROM `versioni`;";
		$sql = $db->prepare($qu);
	   		 $sql->execute();
	   		 while($e=$sql->fetch(PDO::FETCH_ASSOC))
	   		        $output[]=$e;
   		 $db=null;
        file_put_contents("versione.json", json_encode($output));
}
else
	if ($letto+5800<=time()) {
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
	   		 while($e=$sql->fetch(PDO::FETCH_ASSOC))
	   		        $output[]=$e;
	   		        
	   		        $db=null;
	   		 file_put_contents("versione.json", json_encode($output));
}	*/
         $json_file = file_get_contents('versione.json');
        // print(json_decode($json_file,true));
         
         
// convert the string to a json object
$jfo = json_decode($json_file,true);
// read the title value
//print $jfo[1]['valore'];
for($i=0;$i<count($jfo);$i++){
     if($jfo[$i]['nome_vers']==$valore){
     print $jfo[$i]['valore'];
     break;
     }
}


}
?>