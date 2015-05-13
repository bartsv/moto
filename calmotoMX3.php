<?php
//
require_once 'utility/cn_db.php';
function AggiornaCalendario($id,$mes){
$second="";
echo "baba".$id;
//$db=conect();
switch($id){
	case 1:echo 'qq';
		$url="http://results.mxgp.com/reslists.aspx?ct=6&c=33&r=1";
        $class ="MX3";
        $mes=agg($url,$class,$mes);
        break;
    case 2:
        $url="http://results.mxgp.com/reslists.aspx?ct=6&c=33&r=5";
        $class ="MX3";
       $mes= classifica($url,$class,$mes);
        break;
    case 3:
        $url="http://results.mxgp.com/reslists.aspx?ct=6&c=33&r=6";
        $q="INSERT INTO `bartolom_motocross`.`classifica_moto_MX3` (`posizione`, `Costruttore`, `punti`) VALUES";
        $class ="MX3";
        classifica_moto($url,$q,$class);
        break;
   case 4:

		$url="http://results.mxgp.com/reslists.aspx?ct=19&r=1";
$class ="WMX";
       $mes=agg($url,$class,$mes);
        break;
    case 5:
        $url="http://results.mxgp.com/reslists.aspx?ct=19&r=5";
         $class ="WMX";
echo "cc";
        $mes=classifica($url,$class,$mes);
        break;
    case 6:
        $url="http://results.mxgp.com/reslists.aspx?ct=19&r=6";
        $q="INSERT INTO `bartolom_motocross`.`classifica_moto_WMX` (`posizione`, `Costruttore`, `punti`) VALUES";
$class ="WMX";
        classifica_moto($url,$q,$class);
        break;
}
return $mes;
}
//print_r($date);
    function classifica_moto($url,$q,$class){
        $db=dbconn();
		
        $d= date('Y-m-d');
        if(strcmp($class,'MX3')==0)
            $qu="SELECT * from calendarioMX3 where data='$d'";
        if(strcmp($class,'WMX')==0)
            $qu="SELECT * from calendarioWMX where data='$d'";
        echo $qu;
       $sql = $db->prepare($qu);
	   		 $sql->execute();
	   		 $row=$sql->fetch();
        $num=$sql->rowCount();
        $id_gara= $row[0];
        echo $num;
        if($num==1){
		$data = file_get_contents($url);
		        
        $data = str_replace("\"", "", $data);
        $data = str_replace("'", "", $data);
        $data = str_replace(";", "", $data);
        $data = str_replace("(", "", $data);
        $data = str_replace(")", "", $data);
        $data = str_replace("ì", "i", $data);
        
        
        $data = str_replace("\r\n",'',$data);
        $data = str_replace("\t",'',$data);
        $data = str_replace("&iacute",'i',$data);
        
        echo $data;
        $pattern_punti='|<td align=(right)>(.*)</td>|iU';
        $pattern_moto='|<td>(.*)</td>|iU';
        preg_match_all($pattern_punti, $data, $punti);
        preg_match_all($pattern_moto, $data, $moto);
        print_r($moto[0]);
        $temp=$moto[0];
        echo "<br>";
        print_r($punti[0]);
        $temp1=$punti[0];
        //echo "<br>";
        $i=3;
        $j=1;
        $e=1;
        $que="";
			if(strcmp($class,'MX3')==0)
                $query="SELECT * FROM  `classifica_moto_MX3`";
            if(strcmp($class,'WMX')==0)
                $query="SELECT * FROM  `classifica_moto_WMX`";
            $sql = $db->prepare($query);
	   		 $sql->execute();
             $row=$sql->fetch();
            $numerop=$row[0];
            echo "<br>prima agg ".$numerop;
		if(count($temp)>0){
		$db->beginTransaction();
         $sql = $db->exec("truncate `classifica_moto_".$class."`");
			 $db->commit();
         }
         while($i<9){
            if($i==8)
            $que=$que."('".$e."','".strip_tags(trim($temp[$i]))."','".strip_tags($temp1[$j])."')";
			else
            $que=$que."('".$e."','".strip_tags(trim($temp[$i]))."','".strip_tags($temp1[$j])."'),";
            $e++;
            $i=$i+1;
            $j=$j+2;
        }
        echo $q.$que;
        
		$db->beginTransaction();
         $sql = $db->exec($q.$que);
			 $db->commit();
        }
        $db=null;

    }

    function classifica($url,$class,$mes){
        $db=dbconn();
		
        $d= date('Y-m-d');
        if(strcmp($class,'MX3')==0)
            $q="SELECT * from calendarioMX3 where data='$d'";
        if(strcmp($class,'WMX')==0)
            $q="SELECT * from calendarioWMX where data='$d'";
        echo $q;
       $sql = $db->prepare($q);
	   		 $sql->execute();
        $num=$sql->rowCount();
        $row=$sql->fetch();
        $id_gara= $row[0];
        echo $num;
        if($num==1){
        $data = file_get_contents($url);
            $data = str_replace("ü",'u',$data);
            
            $data = str_replace("é", "e", $data);
            $data = str_replace("à", "a", $data);
            $data = str_replace("è", "e", $data);
            $data = str_replace("é", "e", $data);
            $data = str_replace("ì", "i", $data);
         $data = str_replace("\"", "", $data);
            $data = str_replace("'", "", $data);
            $data = str_replace(";", "", $data);
            $data = str_replace("(", "", $data);
            $data = str_replace(")", "", $data);
            $data = str_replace("ì", "i", $data);
            $data = str_replace("ö", "o", $data);
            $data = str_replace("Ö", "O", $data);
            $data = str_replace("š", "s", $data);
			
            $data = str_replace("Â", "A", $data);
            $data = str_replace("Ã", "A", $data);
            $data = str_replace("Ä", "A", $data);
            $data = str_replace("Å", "A", $data);
            $data = str_replace("Æ", "A", $data);
            $data = str_replace("Ê", "E", $data);
            $data = str_replace("Ë", "E", $data);
			$data = str_replace("Î", "I", $data);
            $data = str_replace("Ï", "I", $data);
            $data = str_replace("Ô", "O", $data);
            $data = str_replace("Õ", "O", $data);
            $data = str_replace("Ö", "O", $data);
            $data = str_replace("Û", "U", $data);
            $data = str_replace("Ü", "U", $data);
            $data = str_replace("Š", "S", $data);
			
            $data = str_replace("â", "a", $data);
            $data = str_replace("ã", "a", $data);
            $data = str_replace("ä", "a", $data);
            $data = str_replace("å", "a", $data);
            $data = str_replace("ê", "e", $data);
            $data = str_replace("ë", "e", $data);
			$data = str_replace("î", "i", $data);
            $data = str_replace("ï", "i", $data);
            $data = str_replace("ð", "o", $data);
            $data = str_replace("ñ", "n", $data);
            $data = str_replace("ô", "o", $data);
            $data = str_replace("õ", "o", $data);
            $data = str_replace("ö", "o", $data);
            $data = str_replace("û", "u", $data);
            $data = str_replace("ü", "u", $data);
        $data = str_replace("\"", "", $data);
        $data = str_replace("'", "", $data);
        $data = str_replace(";", "", $data);
        $data = str_replace("(", "", $data);
        $data = str_replace(")", "", $data);
        $data = str_replace("ì", "i", $data);
        $data = str_replace("\r\n",'',$data);
        $data = str_replace("ü",'u',$data);
        $data = str_replace("\t",'',$data);
        $data = str_replace("&iacute",'i',$data);
        $data = str_replace("ö",'o',$data);

        $pattern_squadreC='|<td align=(right)>(.*)</td>|iU';
        $pattern_n='|<td>(.*)</td>|iU';
        $pattern_nazionalita_casaM='|<td align=(left)>(.*)</td>|iU';
        preg_match_all($pattern_n, $data, $nome);
        preg_match_all($pattern_squadreC, $data, $squadre);
        preg_match_all($pattern_nazionalita_casaM, $data, $nazionalita_casaM);
        $array_naz=$nazionalita_casaM[0];
        $temp1=$nome[0];
        $temp=$squadre[0];
		
 			if(strcmp($class,'MX3')==0)
                $qu="SELECT  c.Punti,r.nome FROM  `RidersMX3` r INNER Join ClassificaMX3 c on r.nome=c.Riders WHERE  r.`Numero_Moto` =\"".strip_tags(trim($temp[1]))."\";";
			if(strcmp($class,'WMX')==0)
                $qu="SELECT  c.Punti,r.nome FROM  `RidersWMX` r INNER Join ClassificaWMX c on r.nome=c.Riders WHERE  r.`Numero_Moto` =\"".strip_tags(trim($temp[1]))."\";";
			echo $qu."<br>";
			$sql = $db->prepare($qu);
	   		 $sql->execute();
       		 $row=$sql->fetch();
            $numerop=$row[0];
			$nomeP=$row[1];
            echo $query."<br>prima agg ".$numerop." ".strip_tags(trim($temp[2]));
		if($numerop<strip_tags(trim($temp[2]))){
 			if(strcmp($class,'MX3')==0)
              $e=13;
            if(strcmp($class,'WMX')==0)
                $e=12;
			$i=0;
        $f=1;$que="";$g=0;
		if(count($temp1)>0){
        while($e<count($temp1)){
			echo "<br>". $f."<br>";
			if(strcmp($class,'MX3')==0)
                $qu="SELECT  `nome` FROM  `bartolom_motocross`.`RidersMX3` WHERE  `Numero_Moto` =\"".strip_tags(trim($temp[$f]))."\";";
			if(strcmp($class,'WMX')==0)
                $qu="SELECT  `nome` FROM  `bartolom_motocross`.`RidersWMX` WHERE  `Numero_Moto` =\"".strip_tags(trim($temp[$f]))."\";";		
			echo $qu."<br>";
            $sql = $db->prepare($qu);
	   		 $sql->execute();
        	$num=$sql->rowCount();
       		 $row=$sql->fetch();
	    	echo "aa".$num."<br>";
            $nom="";
            $nom=$row[0];
            echo $nom."<br>";
             $j=$i+1;
             if($num==1){
               if(strcmp($class,'MX3')==0)
                $qu1="select * from ClassificaMX3 where Riders='".$nom."'";
               if(strcmp($class,'WMX')==0)
                $qu1="select * from ClassificaWMX where Riders='".$nom."'";
                $sql = $db->prepare($qu1);
	   		 $sql->execute();
        $numP=$sql->rowCount();
        $row=$sql->fetch();
              if($numP==1){
	               $qu="";
	               if(strcmp($class,'MX3')==0)
	               $qu="Update ClassificaMX3 set Posizione=".$j.",Punti='".strip_tags(trim($temp[$f+1]))."',naz='".trim(strip_tags($array_naz[$g]))."' where Riders='".$nom."'";
	               if(strcmp($class,'WMX')==0)
	               $qu="Update ClassificaWMX set Posizione=".$j.",Punti='".strip_tags(trim($temp[$f+1]))."',naz='".trim(strip_tags($array_naz[$g]))."' where               Riders='".$nom."'";
					echo $qu;
	               $sql = $db->prepare($qu);
	   		 		$sql->execute();
               }
               else{
                  if(strcmp($class,'MX3')==0)
                  $q="INSERT INTO `bartolom_motocross`.`ClassificaMX3` (`Posizione`, `Riders`, `Punti`,naz) VALUES(".$j.",'".$nom."','".trim(strip_tags($temp[$f+1]))."','".trim(strip_tags($array_naz[$g]))."')";
                  if(strcmp($class,'WMX')==0)
                  $q="INSERT INTO `bartolom_motocross`.`ClassificaWMX` (`Posizione`, `Riders`, `Punti`,naz) VALUES(".$j.",'".$nom."','".trim(strip_tags($temp[$f+1]))."','".trim(strip_tags($array_naz[$g]))."')";
                 echo "aa ".trim(strip_tags($temp[$f+1]));
                 $sql = $db->prepare($q);
	   		 	 $sql->execute();
               }
              }
             else{
				$nom=explode (",",strip_tags(trim($temp1[$e])));
				$nomev=trim($nom[1])." ".trim($nom[0]);
                 echo "non cè".$nomev."<br>";
                  
               if(strcmp($class,'MX3')==0)
                $qu1="select * from ClassificaMX3 where Riders='".$nomev."'";
               if(strcmp($class,'WMX')==0)
                $qu1="select * from ClassificaWMX where Riders='".$nomev."'";
                $sql = $db->prepare($qu1);
	   		 $sql->execute();
        $numP=$sql->rowCount();
                   echo $numP."quaa ".$nomev;
             if($numP==0){
                if(strcmp($class,'MX3')==0)
                  $q="INSERT INTO `bartolom_motocross`.`ClassificaMX3` (`Posizione`, `Riders`, `Punti`,naz) VALUES(".$j.",'".$nomev."','".trim(strip_tags($temp[$f+1]))."','".trim(strip_tags($array_naz[$g]))."')";
               if(strcmp($class,'WMX')==0)
                  $q="INSERT INTO `bartolom_motocross`.`ClassificaWMX` (`Posizione`, `Riders`, `Punti`,naz) VALUES(".$j.",'".$nomev."','".trim(strip_tags($temp[$f+1]))."','".trim(strip_tags($array_naz[$g]))."')";
                echo $q;
                $sql = $db->prepare($q);
	   		 	$sql->execute();
              }
              else{
               if(strcmp($class,'MX3')==0)
               $qu="Update ClassificaMX3 set Posizione=".$j.",Punti='".trim(strip_tags($temp[$f+1]))."',naz='".trim(strip_tags($array_naz[$g]))."' where Riders='".$nomev."'";
               if(strcmp($class,'WMX')==0)
               $qu="Update ClassificaWMX set Posizione=".$j.",Punti='".trim(strip_tags($temp[$f+1]))."',naz='".trim(strip_tags($array_naz[$g]))."' where               Riders='".$nomev."'";
             	echo $qu;
             	$sql = $db->prepare($qu);
	   		 	$sql->execute();
             }
        }
		$e++;$i++;$g=$g+2;
		 if(strcmp($class,'WMX')==0)
		$f=$f+9;
		 if(strcmp($class,'MX3')==0)
		$f=$f+10;
        }//fine while
        }
       if(strcmp($class,'MX3')==0)
                $query="SELECT  `Punti` FROM  `ClassificaMX3` WHERE  `Riders` LIKE  'Hsu%'";
            if(strcmp($class,'WMX')==0)
                $query="SELECT  `Punti` FROM  `ClassificaWMX` WHERE  `Riders` LIKE  '%Fontanesi'";
            $sql = $db->prepare($query);
	   		 	$sql->execute();
           $row=$sql->fetch();
            $num1=$row[0];
            echo "prima ".$numerop."<br>dopo agg ".$num1;
            if($num1>$numerop){
               $valore="Class".$class;
                $query="SELECT * FROM  `versioni` where   `nome_vers` ='Class".$class."'";
                 $sql = $db->prepare($query);
	   		 	$sql->execute();
                 $row=$sql->fetch();
                    $somma=$row[2]+1;
                    $q="UPDATE  `bartolom_motocross`.`versioni` SET  `valore` =  '$somma' WHERE  `versioni`.`id` =".$row[0];
                    echo "<br>".$q;
                                   $pagina = file_get_contents('versione.json');
                                   $json_output = json_decode($pagina, true);
                                    $json_output[$valore]=$somma;
                                    file_put_contents("versione.json", json_encode($json_output));
                     $sql = $db->prepare($q);
	   		 	$sql->execute();
                   $mes=$mes."World Championship Classification ".$class." ";
                 
          }
          }
          }
          $qu="SELECT nome_vers,valore FROM versioni;";
			$sql = $db->prepare($qu);
	   		 $sql->execute();
	   		 while($e=$sql->fetch(PDO::FETCH_ASSOC))
	   		        $output[]=$e;
 			file_put_contents("versione.json", json_encode($output));
        $db=null;
$fp=fopen("datagare.txt", "w");
		if (flock($fp, LOCK_EX)) { // Esegue un lock esclusivo
		    fwrite($fp, time().'');
		    flock($fp, LOCK_UN); // rilascia il lock
		} else {
		    echo "Non si riesce ad eseguire il lock del file !";
		}
		fclose($fp);
        $db=null;
        return $mes;
    }

    function agg($url,$class,$mes){
       $db=dbconn();
        //vedo che giorno è e guardo se ci sono già i risultati
        $d= date('Y-m-d');
        if(strcmp($class,'MX3')==0)
            $q="SELECT * from calendarioMX3 where data='$d'";
        if(strcmp($class,'WMX')==0)
            $q="SELECT * from calendarioWMX where data='$d'";
        echo $q;
       $sql = $db->prepare($q);
	   	$sql->execute();
        $num=$sql->rowCount();
        $row=$sql->fetch();
        $id_gara= $row[0];
        if($id_gara==0){
             $date1 = str_replace('-', '/',date('Y-m-d') );
             $tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));
               if(strcmp($class,'MX1')==0)
            $q="SELECT * from calendarioMX1 where data='$tomorrow'";
        if(strcmp($class,'MX2')==0)
            $q="SELECT * from calendarioMX2 where data='$tomorroe'";
        echo $q;
       $sql = $db->prepare($q);
	   	$sql->execute();
        $num=$sql->rowCount();
        $row=$sql->fetch();
        $id_gara= $row[0];
        }
        if($num==1 ){
            $data = file_get_contents($url);
            
            $data = str_replace("ü",'u',$data);
            
            $data = str_replace("é", "e", $data);
            $data = str_replace("à", "a", $data);
            $data = str_replace("è", "e", $data);
            $data = str_replace("é", "e", $data);
            $data = str_replace("ì", "i", $data);
            $data = str_replace("\"", "", $data);
            $data = str_replace("'", "", $data);
            $data = str_replace(";", "", $data);
            $data = str_replace("(", "", $data);
            $data = str_replace(")", "", $data);
            $data = str_replace("ì", "i", $data);
        $data = str_replace("ö",'o',$data);
            
            
            $data = str_replace("\r\n",'',$data);
            $data = str_replace("\t",'',$data);
            $data = str_replace("&iacute",'i',$data);
            echo $data;
           
            $pattern_gara='|<DIV align=center style=DISPLAY: inline FONT-SIZE: 16px TEXT-ALIGN: center ms_positioning=FlowLayout>(.*)</DIV>|iU';

            $pattern_squadreC='|<td align=(right)>(.*)</td>|iU';//[2]
            $pattern_nome='|<A href=(.*) target=(_blank)>(.*)</A></td>|iU';
            $pattern_nazionalita_casaM='|<td align=(left)>(.*)</td>|iU';
            preg_match_all($pattern_gara, $data,$gara);
            preg_match_all($pattern_squadreC, $data, $squadre);
            preg_match_all($pattern_nome, $data, $nomi);
            preg_match_all($pattern_nazionalita_casaM, $data, $nazionalita_casaM);
            $array_naz=$nazionalita_casaM[0];
            $atleti=$nomi[0];
            $squadreC=$squadre[0];
            $gara_array=$gara[0];
            $temp=explode("-",$gara_array[0]);
            
            $session=0;
            if(trim($temp[3])=="Race 1")
                $session=1;
            if(trim($temp[3])=="Race 2")
                $session=2;
            if($session==0)
               return $mes;
            $i=0;$j=$e=0;
          print_r($squadreC);
            if(strcmp($class,'MX3')==0)
                $q="INSERT INTO `bartolom_motocross`.`risultati_gare_MX3` (`Circuito`, `sessione`, `Posizione`, `Numero`, `Riders`, `Nazionalita`, `Federazione`, `Bike`, `Tempo`, `laps`, `distacco_primo`, `distacco_pos`, `bestLap`) VALUES ";
            if(strcmp($class,'WMX')==0)
                $q="INSERT INTO `bartolom_motocross`.`risultati_gare_WMX` (`Circuito`, `sessione`, `Posizione`, `Numero`, `Riders`, `Nazionalita`, `Federazione`, `Bike`, `Tempo`, `laps`, `distacco_primo`, `distacco_pos`, `bestLap`) VALUES ";

            
            if(strcmp($class,'MX3')==0)
                $query="SELECT * FROM  `risultati_gare_MX3`";
            if(strcmp($class,'WMX')==0)
                $query="SELECT * FROM  `risultati_gare_WMX`";
            $sql = $db->prepare($query);
	   		 	$sql->execute();
            $num=$sql->rowCount();
            echo "<br>prima di agg ".$num;
            $que="";
            for($i=0;$i<count($atleti);$i++){
                //  echo '<br>'.$j.'<br>';
                
                $nome = explode(",",$atleti[$i]);
                if($i==count($atleti)-1)
                    $que=$que."('".$id_gara."','".$session."','".strip_tags($squadreC[$e])."','".strip_tags($squadreC[$e+1])."','".strip_tags(trim($nome[1]))." ".strip_tags(trim($nome[0]))."','".strip_tags($array_naz[$j])."', '".strip_tags($array_naz[$j+1])."', '".strip_tags($array_naz[$j+2])."', '".strip_tags($squadreC[$e+2])."', '".strip_tags($squadreC[$e+3])."', '".strip_tags($squadreC[$e+4])."', '".strip_tags($squadreC[$e+5])."', '".strip_tags($squadreC[$e+6])."')";
                else
                    $que=$que."('".$id_gara."','".$session."','".strip_tags($squadreC[$e])."','".strip_tags($squadreC[$e+1])."','".strip_tags(trim($nome[1]))." ".strip_tags(trim($nome[0]))."','".strip_tags($array_naz[$j])."', '".strip_tags($array_naz[$j+1])."', '".strip_tags($array_naz[$j+2])."', '".strip_tags($squadreC[$e+2])."', '".strip_tags($squadreC[$e+3])."', '".strip_tags($squadreC[$e+4])."', '".strip_tags($squadreC[$e+5])."', '".strip_tags($squadreC[$e+6])."'),";
                
                $e=$e+8;
                $j=$j+4;
            }
           $qu= $q.$que;
      //  echo $qu;
      $db->beginTransaction();
      $db->exec($qu);
      $db->commit();
		   $str="";
           if(strcmp($class,'MX3')==0)
                $query="SELECT * FROM  `risultati_gare_MX3`";
            if(strcmp($class,'WMX')==0)
                $query="SELECT * FROM  `risultati_gare_WMX`";
            $sql = $db->prepare($query);
	   		 	$sql->execute();
            $num1=$sql->rowCount();
            echo "<br>dopo agg ".$num1;
            if($num1>$num){
               $valore="RG".$class;
                $query="SELECT * FROM  `versioni` where   `nome_vers` ='RG".$class."'";
                 $sql = $db->prepare($query);
	   		 	$sql->execute();
                $row=$sql->fetch();
                    $somma=$row[2]+1;
                    $q="UPDATE  `bartolom_motocross`.`versioni` SET  `valore` =  '$somma' WHERE  `versioni`.`id` =".$row[0];
                    echo "<br>".$q;
                $sql = $db->prepare($q);
	   		 	$sql->execute();
                if(strcmp($class,'MX3')==0)
                    $mes=$mes."Result of Race $session EMX125 ";
               if(strcmp($class,'WMX')==0)
                    $mes=$mes."Result of Race $session $class ";
                 
             }
        }
        $qu="SELECT nome_vers,valore FROM versioni;";
			$sql = $db->prepare($qu);
	   		 $sql->execute();
	   		 while($e=$sql->fetch(PDO::FETCH_ASSOC))
	   		        $output[]=$e;
 			file_put_contents("versione.json", json_encode($output));
        $db=null;
$fp=fopen("datagare.txt", "w");
		if (flock($fp, LOCK_EX)) { // Esegue un lock esclusivo
		    fwrite($fp, time().'');
		    flock($fp, LOCK_UN); // rilascia il lock
		} else {
		    echo "Non si riesce ad eseguire il lock del file !";
		}
		fclose($fp);
       return $mes;
    }
?>