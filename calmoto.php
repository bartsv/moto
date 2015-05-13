<?php
require_once 'utility/cn_db.php';
date_default_timezone_set('Europe/Rome');
function AggiornaCalendario($id,$mes){
echo "baba".$id;
     if($id==1){
		$url="http://results.mxgp.com/reslists.aspx?ct=1&c=6&r=1";
        $class ="MX1";
       $mes= agg($url,$class,$mes);
        }
    if($id==2){
        $url="http://results.mxgp.com/reslists.aspx?ct=1&c=6&r=5";
        $class ="MX1";
        $mes=classifica($url,$class,$mes);
        }
   if($id==3){
        $url="http://results.mxgp.com/reslists.aspx?ct=1&c=6&r=6";
        $q="INSERT INTO `bartolom_motocross`.`classifica_moto_MX1` (`posizione`, `Costruttore`, `punti`) VALUES";
        $class ="MX1";
        classifica_moto($url,$q,$class);
       }
       if($id==4){
		$url="http://results.mxgp.com/reslists.aspx?ct=1&c=7&r=1";
          $class ="MX2";
        $mes=agg($url,$class,$mes);
        }
        if($id==6){
        $url="http://results.mxgp.com/reslists.aspx?ct=1&c=7&r=5";
         $class ="MX2";
echo "cc";
        $mes=classifica($url,$class,$mes);
       }
   if($id==5){
        $url="http://results.mxgp.com/reslists.aspx?ct=1&c=7&r=6";
        $q="INSERT INTO `bartolom_motocross`.`classifica_moto_MX2` (`posizione`, `Costruttore`, `punti`) VALUES";
$class ="MX2";
        classifica_moto($url,$q,$class);
}
        return($mes);
}
//print_r($date);
    function classifica_moto($url,$querys,$class){
        $db=dbconn();
		$d= date('Y-m-d');
        if(strcmp($class,'MX1')==0)
            $q="SELECT * from calendarioMX1 where data='$d'";
        if(strcmp($class,'MX2')==0)
            $q="SELECT * from calendarioMX2 where data='$d'";
        echo $q;
       $sql = $db->prepare($q);
	   		 $sql->execute();
        $num=$sql->rowCount();
        $row=$sql->fetch();
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
        
       // echo $data;
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
if(strcmp($class,'MX1')==0)
                $query="SELECT * FROM  `classifica_moto_MX1`";
            if(strcmp($class,'MX2')==0)
                $query="SELECT * FROM  `classifica_moto_MX2`";
            $sql = $db->prepare($query);
	   		 $sql->execute();
        $numerop=$sql->rowCount();
            echo "<br>prima agg ".$numerop;
if(count($temp)>0){
		$db->beginTransaction();
         $sql = $db->exec("truncate `classifica_moto_".$class."`");
			 $db->commit();
         }
        while($i<count($temp)){
            if($i==count($temp)-1)
            $que=$que."('".$e."','".strip_tags(trim($temp[$i]))."','".strip_tags($temp1[$j])."')";
else
            $que=$que."('".$e."','".strip_tags(trim($temp[$i]))."','".strip_tags($temp1[$j])."'),";
            $e++;
            $i=$i+1;
            $j=$j+2;
        }
        echo "<br>aa".$querys.$que;
        $db->beginTransaction();
         $sql = $db->exec($querys.$que);
			 $db->commit();
        }
        //echo mysql_affected_rows();
        $db=null;
}
function classifica($url,$class,$mes){
    	 $db=dbconn();
        $d= date('Y-m-d');
		echo $d;
        if(strcmp($class,'MX1')==0)
            $q="SELECT * from calendarioMX1 where data='$d'";
        if(strcmp($class,'MX2')==0)
            $q="SELECT * from calendarioMX2 where data='$d'";
        echo $q;
       $sql = $db->prepare($q);
	   		 $sql->execute();
        $num=$sql->rowCount();
        $row=$sql->fetch();
        $id_gara= $row[0];
        echo $num;
        if($num==1){
       $data = file_get_contents($url);
        
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
        
        
        // echo $data;
        $data = str_replace("\r\n",'',$data);
        $data = str_replace("\t",'',$data);
        $data = str_replace("&iacute",'i',$data);
        $pattern_squadreC='|<td align=(right)>(.*)</td>|iU';
        $pattern_n='|<td>(.*)</td>|iU';
        $pattern_nazionalita_casaM='|<td align=(left)>(.*)</td>|iU';
        preg_match_all($pattern_n, $data, $nome);
        preg_match_all($pattern_squadreC, $data, $squadre);
        preg_match_all($pattern_nazionalita_casaM, $data, $nazionalita_casaM);
        $array_naz=$nazionalita_casaM[0];
        $temp1=$nome[0];
        $temp=$squadre[0];//print_r($temp);

			if(strcmp($class,'MX1')==0)
                $qu="SELECT  c.Punti,r.nome FROM  `Riders` r INNER Join ClassificaMX1 c on r.nome=c.Riders WHERE  r.`Numero_Moto` =\""./*strip_tags(trim($temp[1]))*/"222"."\";";
			if(strcmp($class,'MX2')==0)
                $qu="SELECT  c.Punti,r.nome FROM  `RidersMX2` r INNER Join ClassificaMX2 c on r.nome=c.Riders WHERE  r.`Numero_Moto` =\"".strip_tags(trim($temp[1]))."\";";
			echo $qu."<br>";
            $sql = $db->prepare($qu);
	   		 $sql->execute();
           $row=$sql->fetch();
            $numerop=$row[0];
			$nomeP=$row[1];
            echo $query."aaaprima agg ".$numerop ."aaa ".strip_tags(trim($temp[2]));
		if($numerop<strip_tags(trim($temp[2]))){
		       
		       if(count($temp1)>0){
				$i=0;$e=24;$g=0;
		        $f=1;$que="";
		        while($e<count($temp1)){
					echo "<br>". strip_tags(trim($temp[$f])),"<br>";
					if(strcmp($class,'MX1')==0)
		                $qu="SELECT  `nome` FROM  `bartolom_motocross`.`Riders` WHERE  `Numero_Moto` =\"".strip_tags(trim($temp[$f]))."\";";
					if(strcmp($class,'MX2')==0)
		                $qu="SELECT  `nome` FROM  `bartolom_motocross`.`RidersMX2` WHERE  `Numero_Moto` =\"".strip_tags(trim($temp[$f]))."\";";		
					echo $qu."<br>";
					$sql = $db->prepare($qu);
	   		 		$sql->execute();
        			$num=$sql->rowCount();
		             echo "aa".$num."<br>";
		            $nom="";
		            $row = $sql->fetch();
		            $nom=$row[0];
		            
		             $j=$i+1;
		             if($num==1){
		             	echo $nom."<br>";
		               if(strcmp($class,'MX1')==0)
		                $qu1="select * from ClassificaMX1 where Riders='".$nom."'";
		               if(strcmp($class,'MX2')==0)
		                $qu1="select * from ClassificaMX2 where Riders='".$nom."'";
		                $sql = $db->prepare($qu1);
	   		 			$sql->execute();
                        $numP=$sql->rowCount();
						echo "azz".$numP;
			           if($numP==1){
		               $qu="";
		               if(strcmp($class,'MX1')==0)
		               $qu="Update ClassificaMX1 set Posizione=".$j.",Punti='".strip_tags(trim($temp[$f+1]))."',naz='".trim(strip_tags($array_naz[$g]))."' where Riders='".$nom."'";
		               if(strcmp($class,'MX2')==0)
		               $qu="Update ClassificaMX2 set Posizione=".$j.",Punti='".strip_tags(trim($temp[$f+1]))."',naz='".trim(strip_tags($array_naz[$g]))."' where Riders='".$nom."'";
		               echo $qu;
		               $db->beginTransaction();
		               $sql = $db->exec($qu);
			 		   $db->commit();
		               }
		               else{
		                  if(strcmp($class,'MX1')==0)
		                  $q="INSERT INTO `bartolom_motocross`.`ClassificaMX1` (`Posizione`, `Riders`, `Punti`,naz) VALUES(".$j.",'".$nom."','".trim(strip_tags($temp[$f+1]))."','".trim(strip_tags($array_naz[$g]))."')";
		                  if(strcmp($class,'MX2')==0)
		                  $q="INSERT INTO `bartolom_motocross`.`ClassificaMX2` (`Posizione`, `Riders`, `Punti`,naz) VALUES(".$j.",'".$nom."','".trim(strip_tags($temp[$f+1]))."','".trim(strip_tags($array_naz[$g]))."')";
		                 echo "aa ".trim(strip_tags($temp[$f+1]));
		                 echo "aaa".$q;
		                 $db->beginTransaction();
		               $sql = $db->exec($q);
			 		   $db->commit();
		               }
		              }
		             else{
						$nom=explode (",",strip_tags(trim($temp1[$e])));
						$nomev=trim($nom[1])." ".$nom[0];
		                 echo "no".$nomev."<br>";
		                  
		               if(strcmp($class,'MX1')==0)
		                $qu1="select * from ClassificaMX1 where Riders='".$nomev."'";
		               if(strcmp($class,'MX2')==0)
		                $qu1="select * from ClassificaMX2 where Riders='".$nomev."'";
		                $sql = $db->prepare($qu1);
	   		 			$sql->execute();
                        $numP=$sql->rowCount();
		                   echo $numP."quaa ".$nomev;
		                 if($numP==0){
		                if(strcmp($class,'MX1')==0)
		                  $q="INSERT INTO `bartolom_motocross`.`ClassificaMX1` (`Posizione`, `Riders`, `Punti`,naz) VALUES(".$j.",'".$nomev."','".trim(strip_tags($temp[$f+1]))."','".trim(strip_tags($array_naz[$g]))."')";
		               if(strcmp($class,'MX2')==0)
		                  $q="INSERT INTO `bartolom_motocross`.`ClassificaMX2` (`Posizione`, `Riders`, `Punti`,naz) VALUES(".$j.",'".$nomev."','".trim(strip_tags($temp[$f+1]))."','".trim(strip_tags($array_naz[$g]))."')";
		                echo $q;
					$db->beginTransaction();
		               $sql = $db->exec($q);
			 		   $db->commit();
		              }else{
		               if(strcmp($class,'MX1')==0)
		               $qu="Update ClassificaMX1 set Posizione=".$j.",Punti='".trim(strip_tags($temp[$f+1]))."',naz='".trim(strip_tags($array_naz[$g]))."' where Riders='".$nomev."'";
		               if(strcmp($class,'MX2')==0)
		               $qu="Update ClassificaMX2 set Posizione=".$j.",Punti='".trim(strip_tags($temp[$f+1]))."',naz='".trim(strip_tags($array_naz[$g]))."' where               Riders='".$nomev."'";
		             echo $qu;
				$db->beginTransaction();
		               $sql = $db->exec($qu);
			 		   $db->commit();
		             }
		            }
				$e++;$i++;$g=$g+2;
				$f=$f+21;
		        }//fine while
		        }
echo "<br>quaa";
		       if(strcmp($class,'MX1')==0)
		                $query="SELECT  `Punti` FROM  `ClassificaMX1` WHERE  `Riders` LIKE \"Antonio Cairoli\"";
		            if(strcmp($class,'MX2')==0)
		                $query="SELECT  `Punti` FROM  `ClassificaMX2` WHERE  `Riders` LIKE  '%Herlings'";

					echo "sss".$query;
		            $sql = $db->prepare($query);
	   		 $sql->execute();
			$row=$sql->fetch();
		            $num1=$row[0];
		            echo "prima ".$numerop." dopo agg ".$num1."<br>";
		           print_r($temp1);
		            if($num1>$numerop){
		               $valore='Class'.$class;
		                $query="SELECT * FROM  `versioni` where   `nome_vers` ='Class".$class."'";
		                 $sql = $db->prepare($query);
	   		             $sql->execute();
	   		             $row=$sql->fetch();
		                    $somma=$row[2]+1;
		                    $q="UPDATE  `bartolom_motocross`.`versioni` SET  `valore` =  '$somma' WHERE  `versioni`.`id` =".$row[0];
		                    echo "<br>qui ".$q;
		                  $db->beginTransaction();
		               $sql = $db->exec($q);
			 		   $db->commit();
		                  $mes=$mes.$class." World Championship Classification";
		                      
		                 
		          }
          }
          }
          $qu="SELECT nome_vers,valore FROM versioni";
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
    function agg($url,$class,$mes){
       $db=dbconn();
        //vedo che giorno è e guardo se ci sono già i risultati
        $d= date('Y-m-d');
        if(strcmp($class,'MX1')==0)
            $q="SELECT * from calendarioMX1 where data='$d'";
        if(strcmp($class,'MX2')==0)
            $q="SELECT * from calendarioMX2 where data='$d'";
        echo $q.'<br>';
        $sql = $db->prepare($q);
	   		 $sql->execute();
	   		 $num=$sql->rowCount();
			$row=$sql->fetch();
        $id_gara= $row[0];
        $datagara=$row[2];
        echo $datagara.'<br>';
        if($id_gara==0){
             $date1 = str_replace('-', '/',date('Y-m-d') );
             $tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));
               if(strcmp($class,'MX1')==0)
            $q="SELECT * from calendarioMX1 where data='$tomorrow'";
        if(strcmp($class,'MX2')==0)
            $q="SELECT * from calendarioMX2 where data='$tomorrow'";
        echo $q.'<br>';
        $sql = $db->prepare($q);
	   		 $sql->execute();
	   		 $num=$sql->rowCount();
			$row=$sql->fetch();
        $id_gara= $row[0];
        $datagara=$row[2];
        echo $datagara.'<br>';
        }
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
        $data = str_replace("ö",'o',$data);
            
            
            $data = str_replace("\r\n",'',$data);
            $data = str_replace("\t",'',$data);
            $data = str_replace("&iacute",'i',$data);
            //echo $data;
            $pattern_gara='|<td class=mxmiddle><DIV align=center style=DISPLAY: inline FONT-SIZE: 16px TEXT-ALIGN: center ms_positioning=FlowLayout>(.*)</DIV>|iU';
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
          //  print_r($gara_array);

            $session=-1;
            if(trim($temp[3])=="Qualifying Race")
			$session=0;
            if(trim($temp[3])=="Grand Prix Race 1" || trim($temp[3])=="Race 1")
                $session=1;
            if(trim($temp[3])=="Grand Prix Race 2" || trim($temp[3])=="Race 2")
                $session=2;
            $i=0;$j=$e=0;
   //         print_r($squadreC);
            if(strcmp($class,'MX1')==0)
                $q="INSERT INTO `bartolom_motocross`.`risultati_gare_MX1` (`Circuito`, `sessione`, `Posizione`, `Numero`, `Riders`, `Nazionalita`, `Federazione`, `Bike`, `Tempo`, `laps`, `distacco_primo`, `distacco_pos`, `bestLap`) VALUES ";
            if(strcmp($class,'MX2')==0)
                $q="INSERT INTO `bartolom_motocross`.`risultati_gare_MX2` (`Circuito`, `sessione`, `Posizione`, `Numero`, `Riders`, `Nazionalita`, `Federazione`, `Bike`, `Tempo`, `laps`, `distacco_primo`, `distacco_pos`, `bestLap`) VALUES ";

            
            if(strcmp($class,'MX1')==0)
                $query="SELECT COUNT(*) FROM  `risultati_gare_MX1`";
            if(strcmp($class,'MX2')==0)
                $query="SELECT COUNT(*) FROM  `risultati_gare_MX2`";
            
        $sql = $db->prepare($query);
	   		 $sql->execute();
			$row=$sql->fetch();
            $num=$row[0];
            echo "<br>prima di agg ".$num;
            $que="";
            if($session>=0&& $id_gara>0){
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
        }
           $qu= $q.$que;
             $date1 = str_replace('-', '/',date('Y-m-d') );
             $tomorrow = date('Y-m-d',strtotime($datagara . "-1 days"));
           echo $datagara.'sessione '.$session.'<br>d '.$tomorrow;
           if(date('Y-m-d')==$datagara && $session>0){
           echo'qq';
           $db->beginTransaction();
           $sql = $db->exec($qu);
			 $db->commit();
          }
           if($session==0 && $tomorrow==date('Y-m-d')){
             echo 'quai';
           $db->beginTransaction();
           $sql = $db->exec($qu);
			 $db->commit();}
           if(strcmp($class,'MX1')==0){
                $query="SELECT COUNT(*) FROM  `risultati_gare_MX1`";
			   $str="MXGP ";
		   }
            if(strcmp($class,'MX2')==0){
                $query="SELECT COUNT(*) FROM  `risultati_gare_MX2`";
                $str="MX2 ";
			}
            $sql = $db->prepare($query);
	   		 $sql->execute();
            $row=$sql->fetch();
            $num1=$row[0];
            echo "<br>dopo agg ".$num1;
            if($num1>$num){
               $valore='RG'.$class;
                $query="SELECT * FROM  `versioni` where   `nome_vers` ='RG".$class."'";
                 $sql = $db->prepare($query);
	   		 $sql->execute();
                $row=$sql->fetch();
                    $somma=$row[2]+1;
                    $q="UPDATE  `bartolom_motocross`.`versioni` SET  `valore` =  '$somma' WHERE  `versioni`.`id` =".$row[0];
                    echo "<br>".$q;
                                   
                    $db->beginTransaction();
                    $sql = $db->exec($q);
			 		$db->commit();
                     if($session==0)
                    $mes=$mes.$str."Result of Qualifyng Race";
                     else
                    $mes=$mes.$str."Result of Race".$session." ";
                 
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