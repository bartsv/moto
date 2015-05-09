<?php
require_once 'utility/cn_db.php';

$tipo=addslashes(trim($_GET['tipo']));
getVersion($tipo);
function getVersion($valore){
$filename="data.txt";
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
	$tip=array("RidersMX1","RidersMX2","RidersMX3","RidersWMX","CalMX1","CalMX2","CalMX3","CalWMX","ClassMX1","ClassMX2","ClassMX3","ClassWMX","RGMX1","RGMX2","RGMX3","RGWMX","videoMX1","videoMX2","videoMX3","videoWMX","NewsMX1","NewsMX2","NewsMX1_inglese","NewsMX2_inglese","sponsor","AthenaNews","AthenaPerformance","AthenaPiloti","Ufo_Plast_News","UfoPiloti","FBNews");
	$db=dbconn;
	for ($i=0; $i < count($tip); $i++) { 
		$qu="SELECT * FROM `versioni`where nome_vers='".$tip[$i]."'";
		$sql = $db->prepare($qu);
	   		 $sql->execute();
	   		 $e=$sql->fetch();
	   		 $db=null;
        switch ($i) {
            case 0:
                $RidersMX1=$e[2];
                break;
			case 1:
                $RidersMX2=$e[2];
                break;
			case 2:
                $RidersMX3=$e[2];
                break;
			case 3:
                $RidersWMX=$e[2];
                break;
			case 4:
                $CalMX1=$e[2];
                break;
			case 5:
                $CalMX2=$e[2];
                break;
			case 6:
                $CalMX3=$e[2];
                break;
			case 7:
                $CalWMX=$e[2];
                break;
			case 8:
                $ClassMX1=$e[2];
                break;
			case 9:
                $ClassMX2=$e[2];
                break;
			case 10:
                $ClassMX3=$e[2];
                break;
			case 11:
                $ClassWMX=$e[2];
                break;
			case 12:
                $RGMX1=$e[2];
                break;
			case 13:
                $RGMX2=$e[2];
                break;
			case 14:
                $RGMX3=$e[2];
                break;
			case 15:
                $RGWMX=$e[2];
                break;
			case 16:
                $videoMX1=$e[2];
                break;
			case 17:
                $videoMX2=$e[2];
                break;
			case 18:
                $videoMX3=$e[2];
                break;
			case 19:
                $videoWMX=$e[2];
                break;
			case 20:
                $newsMX1=$e[2];
                break;
			case 21:
                $newsMX2=$e[2];
                break;
			case 22:
                $NewsMX1_ingl=$e[2];
                break;
			case 23:
                $NewsMX2_ingl=$e[2];
                break;
			case 24:
                $sponsor=$e[2];
                break;
			case 25:
                $athenaNews=$e[2];
                break;
			case 26:
                $athenaPerf=$e[2];
                break;
			case 27:
                $athenaRider=$e[2];
                case 28:
                $ufoNews=$e[2];
                break;
			case 29:
                $ufoPiloti=$e[2];
                break;case 30:
                $fbn=$e[2];
                break;
            
            default:
                
                break;
        }
	}

        $arrayName = array('RidersMX1' => $RidersMX1,'RidersMX2'=>$RidersMX2,'RidersMX3'=>$RidersMX3,'RidersWMX'=>$RidersWMX,'CalMX1'=>$CalMX1,'CalMX2'=>$CalMX2,'CalMX3'=>$CalMX3,'CalWMX'=>$CalWMX,'ClassMX1'=>$ClassMX1,'ClassMX2'=>$ClassMX2,'ClassMX3'=>$ClassMX3,'ClassWMX'=>$ClassWMX,'RGMX1'=>$RGMX1,'RGMX2'=>$RGMX2,'RGMX3'=>$RGMX3,'RGWMX'=>$RGWMX,'videoMX1'=>$videoMX1,'videoMX2'=>$videoMX2,'videoMX3'=>$videoMX3,'videoWMX'=>$videoWMX,'NewsMX1'=>$newsMX1,'NewsMX2'=>$newsMX2,'NewsMX1_inglese'=>$NewsMX1_ingl,'NewsMX2_inglese'=>$NewsMX2_ingl,'sponsor'=>$sponsor,'AthenaNews'=>$athenaNews,'AthenaPerformance'=>$athenaPerf,'AthenaPiloti'=>$athenaRider,'Ufo_Plast_News'=>$ufoNews,'UfoPiloti'=>$ufoPiloti,'FBNews'=>$fbn );
        file_put_contents("versione.json", json_encode($arrayName));
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
		$tip=array("RidersMX1","RidersMX2","RidersMX3","RidersWMX","CalMX1","CalMX2","CalMX3","CalWMX","ClassMX1","ClassMX2","ClassMX3","ClassWMX","RGMX1","RGMX2","RGMX3","RGWMX","videoMX1","videoMX2","videoMX3","videoWMX","NewsMX1","NewsMX2","NewsMX1_inglese","NewsMX2_inglese","sponsor","AthenaNews","AthenaPerformance","AthenaPiloti","Ufo_Plast_News","UfoPiloti","FBNews");
	$db=dbconn();
	for ($i=0; $i < count($tip); $i++) { 
	$qu="SELECT * FROM `versioni`where nome_vers='".$tip[$i]."'";
	$sql = $db->prepare($qu);
	   		 $sql->execute();
	$e=$sql->fetch();
	$db=null;
        switch ($i) {
            case 0:
                $RidersMX1=$e[2];
                break;
			case 1:
                $RidersMX2=$e[2];
                break;
			case 2:
                $RidersMX3=$e[2];
                break;
			case 3:
                $RidersWMX=$e[2];
                break;
			case 4:
                $CalMX1=$e[2];
                break;
			case 5:
                $CalMX2=$e[2];
                break;
			case 6:
                $CalMX3=$e[2];
                break;
			case 7:
                $CalWMX=$e[2];
                break;
			case 8:
                $ClassMX1=$e[2];
                break;
			case 9:
                $ClassMX2=$e[2];
                break;
			case 10:
                $ClassMX3=$e[2];
                break;
			case 11:
                $ClassWMX=$e[2];
                break;
			case 12:
                $RGMX1=$e[2];
                break;
			case 13:
                $RGMX2=$e[2];
                break;
			case 14:
                $RGMX3=$e[2];
                break;
			case 15:
                $RGWMX=$e[2];
                break;
			case 16:
                $videoMX1=$e[2];
                break;
			case 17:
                $videoMX2=$e[2];
                break;
			case 18:
                $videoMX3=$e[2];
                break;
			case 19:
                $videoWMX=$e[2];
                break;
			case 20:
                $newsMX1=$e[2];
                break;
			case 21:
                $newsMX2=$e[2];
                break;
			case 22:
                $NewsMX1_ingl=$e[2];
                break;
			case 23:
                $NewsMX2_ingl=$e[2];
                break;
			case 24:
                $sponsor=$e[2];
                break;
			case 25:
                $athenaNews=$e[2];
                break;

			case 26:
                $athenaPerf=$e[2];
                break;
			case 27:
                $athenaRider=$e[2];
                break;
			case 28:
                $ufoNews=$e[2];
                break;
			case 29:
                $ufoPiloti=$e[2];
                break;
			case 30:
                $fbn=$e[2];
                break;
            
            default:
                
                break;
        }
	}
        $arrayName = array('RidersMX1' =>$RidersMX1,'RidersMX2'=>$RidersMX2,'RidersMX3'=>$RidersMX3,'RidersWMX'=>$RidersWMX,'CalMX1'=>$CalMX1,'CalMX2'=>$CalMX2,'CalMX3'=>$CalMX3,'CalWMX'=>$CalWMX,'ClassMX1'=>$ClassMX1,'ClassMX2'=>$ClassMX2,'ClassMX3'=>$ClassMX3,'ClassWMX'=>$ClassWMX,'RGMX1'=>$RGMX1,'RGMX2'=>$RGMX2,'RGMX3'=>$RGMX3,'RGWMX'=>$RGWMX,'videoMX1'=>$videoMX1,'videoMX2'=>$videoMX2,'videoMX3'=>$videoMX3,'videoWMX'=>$videoWMX,'NewsMX1'=>$newsMX1,'NewsMX2'=>$newsMX2,'NewsMX1_inglese'=>$NewsMX1_ingl,'NewsMX2_inglese'=>$NewsMX2_ingl,'sponsor'=>$sponsor,'AthenaNews'=>$athenaNews,'AthenaPerformance'=>$athenaPerf,'AthenaPiloti'=>$athenaRider,'Ufo_Plast_News'=>$ufoNews,'UfoPiloti'=>$ufoPiloti,'FBNews'=>$fbn );
        file_put_contents("versione.json", json_encode($arrayName));
	}
         $json_file = file_get_contents('versione.json');
// convert the string to a json object
$jfo = json_decode($json_file,true);
// read the title value
print $jfo[$valore];
}
?>