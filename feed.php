<?php
require 'utility/cn_db.php';
require 'utility/push.php';
function fb_parse_feed($url,$mes){
	// Creo un nuovo oggetto XML DOM
    $xmldom = new DOMDocument();

    // Scelgo il feed RSS remoto da leggere
    $xmldom->load($url);

    // Scorro il noto rappresentato dal tag <item>
    $nodo = $xmldom->getElementsByTagName("item");
	$db=dbconn();
    //    // Effettuo un ciclo su tutti i nodi <item> trovati
    for ($i=0; $i<$nodo->length; $i++)
    {
        // Estraggo il contenuto dei singoli tag del nodo <item>
        $titolo=trim($nodo->item($i)->getElementsByTagName("title")->item(0)->childNodes->item(0)->nodeValue);
        $titolo = preg_replace("/<[^<]+?><mg.../", 'Guarda la nuova foto pubblicata', $titolo);
          $titolo=html_entity_decode( addslashes(strip_tags($titolo)));
          $link =$nodo->item($i)->getElementsByTagName("link")->item(0)->childNodes->item(0)->nodeValue;
          $desc=html_entity_decode(trim($nodo->item($i)->getElementsByTagName("description")->item(0)->childNodes->item(0)->nodeValue));
        
        
        
          $titolo=puliscistringa( addslashes(strip_tags($titolo)));
        $titolo=str_replace("_","-",$titolo);
        
        preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $desc, $matches);
		  if (count($matches[1])==0) {
			  
	//		 echo $desc;
          $pattern='|<a (.*)>(.*)</a>|iU';
            preg_match_all($pattern, $desc,$gara);
		   $imm = strip_tags($gara[0][0]);
		  }else
		  $imm =$matches[1][0];
$titolo=strip_tags($titolo);
		  $query="Select news FROM `FBNews` where news like '$link';";
		  //echo $query;
		  $sql = $db->prepare($query);
	   		 $sql->execute();
		  $num=$sql->rowCount();
		  echo "".$num;
		  if ($num==0) {
			  $query="INSERT INTO `FBNews`(`immagine`, `titolo`, `news`) VALUES ('$imm','$titolo','$link');";
		  echo $query.'<br>';
		 $sql = $db->prepare($query);
	   		 $sql->execute();
		  $numi=$sql->rowCount();
                   if($numi==1){
                      $nomevers="FBNews";
				$mes=$mes.$nomevers."-".$titolo.",";
				   }
                 }
     }
     $db=null;
    return $mes;
}
function genera_News_Athena($url,$mes){
	// Creo un nuovo oggetto XML DOM
    $xmldom = new DOMDocument();

    // Scelgo il feed RSS remoto da leggere
    $xmldom->load($url);

    // Scorro il noto rappresentato dal tag <item>
    $nodo = $xmldom->getElementsByTagName("item");
	$db=dbconn();
        // Effettuo un ciclo su tutti i nodi <item> trovati
    for ($i=0; $i<$nodo->length-1; $i++)
    {
        // Estraggo il contenuto dei singoli tag del nodo <item>
        $titolo=html_entity_decode(trim($nodo->item($i)->getElementsByTagName("title")->item(0)->childNodes->item(0)->nodeValue));
        $titolo = preg_replace("/<[^<]+?><img.../", 'Guarda la nuova foto pubblicata', $titolo);
               
          $link =$nodo->item($i)->getElementsByTagName("link")->item(0)->childNodes->item(0)->nodeValue;
          $desc=html_entity_decode(trim($nodo->item($i)->getElementsByTagName("description")->item(0)->childNodes->item(0)->nodeValue));
         //echo $desc;
          preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $desc, $matches);
          $imm = $matches[1][0];
         
          $titolo=htmlentities( addslashes(strip_tags($titolo)));
           
        $titolo=str_replace("_","-",$titolo);
          $desc= addslashes(strip_tags($desc)) ;
          $link= htmlentities( $link);
		  $imm=addslashes(trim($imm));
		  $query="Select news FROM `AthenaNews` where news like '$link' and titolo like '$titolo';";
		  $sql = $db->prepare($query);
	   		 $sql->execute();
		  $num=$sql->rowCount();
		  if ($num==0) {
			  $query="INSERT INTO `AthenaNews`(`immagine`, `titolo`, `news`) VALUES ('$imm','$titolo','$link');";
		  $sql = $db->prepare($query);
	   		 $sql->execute();
                  $numi=$sql->rowCount();
                   if($numi==1){
                      $nomevers="AthenaNews";
				$mes=$mes.$nomevers."-".$titolo.",";
		  }
                 }
     }
     $db=null;
    return $mes;
}
function generaNews($url,$mes){
 // Creo un nuovo oggetto XML DOM
    $xmldom = new DOMDocument();

    // Scelgo il feed RSS remoto da leggere
    $xmldom->load($url);

    // Scorro il noto rappresentato dal tag <item>
    $nodo = $xmldom->getElementsByTagName("item");
    // Effettuo un ciclo su tutti i nodi <item> trovati
    for ($i=0; $i<=$nodo->length-1; $i++)
    {
        // Estraggo il contenuto dei singoli tag del nodo <item>
        $titolo =$nodo->item($i)->getElementsByTagName("title")->item(0)->childNodes->item(0)->nodeValue;
        $titolo=str_replace("_","-",$titolo);
        $titolo=puliscistringa($titolo);
echo $titolo."<br><br>";
        $titolopulito=htmlentities($titolo);
		$categoria ="";
		if (strpos($url,'mxnews.net') !== false){ 
			      $categoria= $nodo->item($i)->getElementsByTagName("category")->item(1)->childNodes->item(0)->nodeValue;
                 }
echo $titolo."<br>".$categoria."aa<br>";
        $content = $nodo->item($i)->getElementsByTagName("encoded")->item(0)->childNodes->item(0)->nodeValue;
        $link = $nodo->item($i)->getElementsByTagName("link")->item(0)->childNodes->item(0)->nodeValue;
		$titolo=htmlspecialchars($titolo, ENT_QUOTES, "UTF-8");
        // Stampo a video i risultati
        if ( strpos($content,'MX1') !== false || strpos($content,'MXGP') !== false|| strpos($categoria,'MXGP') !== false || strpos($content,'MX2') !== false ){
			 $mes=generaPaginaNews($titolo,$titolopulito,$url,$content,$categoria,$mes);
                           
                      }
		}
    return $mes;
 }
function generaPaginaNews($titolo,$titolopulito,$url,$content,$categ,$mes){
	if( strpos($titolo,'VIDEO')!==FALSE || strpos($titolo,'Video')!==FALSE)
		return $mes;
	if (strpos($content,'MX1') !== false || strpos($content,'MXGP') !== false|| strpos($categ,'MXGP') !== false || strpos($content,'MX2') !== false){
                
		$content=str_replace("&lt;br&gt;","<br>",$content);
		if (strpos($url,'mxnews.net') !== false){
                     $imm="imm/Head2.png";$urlf="http//www.mxnews.net";}
                else{
                     $imm="imm/HeadI.png";$urlf="http://www.mxlarge.com";
                }echo $titolo;
                     $content=preg_replace('|<span style=(.*)>|iU','<p>',$content);
                 
                 $content=str_replace('<td colspan="3">','<td colspan="3"><p>',$content);
                 $content=str_replace('<td colspan="4">','<td colspan="4"><p>',$content);
		$content=str_replace('<td colspan="5">','<td colspan="5"><p>',$content);
                $content=str_replace('<td>','<td><p>',$content);
$titolo1=$titolo;
$titolo2=$titolo;
        $titolo=htmlentities($titolo);
	$titol=str_replace(" ","%20",$titolo);
        $tito=str_replace(" ","",$titolo1);
		$contenuto='<!doctype html> 
	<html manifest="'.$tito.'.manifest"> 
	<head>
	  <title>news</title> 
	  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	  <link rel="stylesheet" href="prova/monitor.css" media="screen">
	  <link rel="stylesheet" href="prova/iphone.css"
	          media="screen and (max-device-width: 480px) and (orientation: portrait)">
	</head>
	<body> 
	  <header>
	    <hgroup> 
	    	<img src="'.$imm.'" />
	      <h1>'.$titolo.'</h1> 
	      </hgroup> 
	  </header>
	  <section>
	  <article> 
	    <p>'.$content.'</p>
	</article> 
	  </section>
	  <footer><p>Fonte:<br><a href="'.$urlf.'">'.$urlf.'</a></p><br><br></footer>
	</body></html>';

        $titolo=str_replace("_","-",$titolo);
	$db=dbconn();
	$cachecontenuto="CACHE MANIFEST \n\r".$titol.".html\nprova/monitor.css\nprova/iphone.css\nimm/HeadI.png\nimm/Head2.png\n\nNETWORK:\n*";
	 if (file_exists("./News/" .$titolopulito.".html") || file_exists("./News/" .$titol.".html")|| file_exists("./News/" .$tito.".manifest")){
		$db=null;
		echo "file esistente";
        return $mes;
	}
	else{
		
			file_put_contents('./News/'.$titolopulito.'.html', $contenuto); 
			file_put_contents('./News/'.$tito.'.manifest', $cachecontenuto);  
			$news="";
			$nomevers="";
                        $nomevers2="";
			$conta_MXGP=substr_count($content, "MXGP");
		$conta_MX2=substr_count($content, "MX2");
			if (strpos($url,'mxnews') !== false) {
			    if ($conta_MXGP>$conta_MX2 && strpos($categ,'MXGP') !== false) {
			    	$nomevers="NewsMX1";
$query="INSERT INTO ".$nomevers." (`titolo`, `link`) VALUES ( '".$titolo."', 'http://www.bartolomeoberrino.it/motocross/News/".$titolopulito.".html')";
			$sql = $db->prepare($query);
	   		 $sql->execute();
				}else 
                                  if ($conta_MXGP<$conta_MX2 && strpos($categ,'MXGP') !== false){
			    	$nomevers="NewsMX2";
$query="INSERT INTO ".$nomevers." (`titolo`, `link`) VALUES ( '".$titolo."', 'http://www.bartolomeoberrino.it/motocross/News/".$titolopulito.".html')";
			$sql = $db->prepare($query);
	   		 $sql->execute();
				}
                                else if ($conta_MXGP==$conta_MX2 && strpos($categ,'MXGP') !== false){
                                $nomevers="NewsMX2";
$query="INSERT INTO ".$nomevers." (`titolo`, `link`) VALUES ( '".$titolo."', 'http://www.bartolomeoberrino.it/motocross/News/".$titolopulito.".html')";
			$sql = $db->prepare($query);
	   		 $sql->execute();
$nomevers2="NewsMX1";
$query="INSERT INTO ".$nomevers2." (`titolo`, `link`) VALUES ( '".$titolo."', 'http://www.bartolomeoberrino.it/motocross/News/".$titolopulito.".html')";
			$sql = $db->prepare($query);
	   		 $sql->execute();
                                }
                                
                                echo $nomevers."<br>".$nomevers2."<br>";
				$mes=$mes.$nomevers."-".$titolo1.",";
                                if(strcmp($nomevers2,"")!=0)
				$mes=$mes.$nomevers2."-".$titolo1.",";
			
			}
			if (strpos($url,'mxlarge') !== false) {
			    if ($conta_MXGP>$conta_MX2) {
			    	$nomevers="NewsMX1_inglese";
$query="INSERT INTO ".$nomevers." (`titolo`, `link`) VALUES ( '".$titolo."', 'http://www.bartolomeoberrino.it/motocross/News/".$titolopulito.".html')";
			$sql = $db->prepare($query);
	   		 $sql->execute();
				}else 
                                  if ($conta_MXGP<$conta_MX2){
			    	$nomevers="NewsMX2_inglese";
$query="INSERT INTO ".$nomevers." (`titolo`, `link`) VALUES ( '".$titolo."', 'http://www.bartolomeoberrino.it/motocross/News/".$titolopulito.".html')";
			$sql = $db->prepare($query);
	   		 $sql->execute();
				}
                                else{
                                $nomevers="NewsMX2_inglese";
$query="INSERT INTO ".$nomevers." (`titolo`, `link`) VALUES ( '".$titolo."', 'http://www.bartolomeoberrino.it/motocross/News/".$titolopulito.".html')";
			$sql = $db->prepare($query);
	   		 $sql->execute();
$nomevers2="NewsMX1_inglese";
$query="INSERT INTO ".$nomevers2." (`titolo`, `link`) VALUES ( '".$titolo."', 'http://www.bartolomeoberrino.it/motocross/News/".$titolopulito.".html')";
			$sql = $db->prepare($query);
	   		 $sql->execute();
                                }
                                
                                echo $nomevers."<br>".$nomevers2."<br>";
				$mes=$mes.$nomevers."-".$titolo1.",";
                                if(strcmp($nomevers2,"")!=0)
				$mes=$mes.$nomevers2."-".$titolo1.",";
			echo "aa ".$mes;
			}
			
			
        }
       $db=null;
    }
return $mes;
}
function creaMess($valori){
echo "<br><br>qqq ".$valori;
	$val=explode(',', $valori);
	$stack=array();
print_r($val);
	$mes="";
		for($i=0;$i<count($val)-1;$i++){
			$tit=explode('-', $val[$i]);
			$temp=$tit[0];
echo $temp;
				if(!in_array($tit[0], $stack)){
				$temp=$tit[0];
				if(strpos($temp,'NewsMX1')!==false)
				$temp="NewsMX1";
				if(strpos($temp,'NewsMX2')!==false)
				$temp="NewsMX2";
				if(strpos($mes,$temp.':')===false)
				$mes=$mes.$temp.":".$tit[1];
				else
					$mes=$mes.','.$tit[1];
				array_push($stack, $tit[0]);
			}
		else{
                      if(strpos($mes,"")===false)
			$mes=$mes.','.$tit[1];
                      else
                        $mes=$mes.$tit[1];
                }
	}
	print_r($stack);
	echo "<br>mes ".$mes."<br>";

$pagina = file_get_contents("versione.json");
$json_output = json_decode($pagina, true);
print_r($json_output);
	if(count($stack)>0){
	
	$db=dbconn();
		for($i=0;$i<count($stack);$i++){
		$query="select valore from versioni where nome_vers = '".$stack[$i]."'";
		echo $query.'<br>';
                 $c=$stack[$i];
                 $sql = $db->prepare($query);
	   		 $sql->execute();
		$row = $sql->fetch();
		echo $row[0];
		$num=$row[0]+1;
               $json_output[$c]=$num;
		$query="update versioni  set valore=".$num." where nome_vers = '".$stack[$i]."'";
		$sql = $db->prepare($query);
	   		 $sql->execute();
		echo "versione ora ".$num." versione peima ".$row[0];
		}

 file_put_contents("versione.json", json_encode($json_output));
$db=null;
         $fp=fopen("data.txt", "w");
		if (flock($fp, LOCK_EX)) { // Esegue un lock esclusivo
		    fwrite($fp, time().'');
		    flock($fp, LOCK_UN); // rilascia il lock
		} else {
		    echo "Non si riesce ad eseguire il lock del file !";
		}
		fclose($fp);
	$lung=strlen($mes);
	if($lung>200)
	$mes='Nuove News disponibili per te';
	echo $mes;
	if(strlen($mes)>2)
	Invia($mes);
     }
}
function generaPerf($url,$mes){
 // Creo un nuovo oggetto XML DOM
    $data=file_get_contents($url);
	//echo $data;
    $xmldom = new DOMDocument();
	$xmldom->resolveExternals = true;
    // Scelgo il feed RSS remoto da leggere
    $xmldom->loadXML($data);

    // Scorro il noto rappresentato dal tag <item>
    $nodo = $xmldom->getElementsByTagName("item");
	
    // Effettuo un ciclo su tutti i nodi <item> trovati
    for ($i=0; $i<=$nodo->length-1; $i++)
    {
        // Estraggo il contenuto dei singoli tag del nodo <item>
        $titolo =htmlentities($nodo->item($i)->getElementsByTagName("title")->item(0)->childNodes->item(0)->nodeValue);
		$content=trim($nodo->item($i)->getElementsByTagName("description")->item(0)->childNodes->item(0)->nodeValue);
		  $link= $nodo->item($i)->getElementsByTagName("link")->item(0)->childNodes->item(0)->nodeValue;
		 $content= aggImm($content);
              echo $titolo;
           $titolopulito=puliscistringa($titolo);
       $mes= generaPagina1($titolo,$titolopulito, $content, $mes);
		
        // Stampo a video i risultati
        }
    return $mes;
 }
function generaPagina1($titolo,$titolopulito,$content,$mes){
	$titol=str_replace(" ","%20",$titolo);
        $tito=str_replace(" ","",$titolopulito);
         
        $titolo=str_replace("_","-",$titolo);
        $tito=str_replace(".","",$tito);
		$cont='<!doctype html> 
	<html manifest="'.$tito.'.manifest"> 
	<head>
	  <title>news</title> 
	  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	  <link rel="stylesheet" href="prova/monitor.css" media="screen">
	  <link rel="stylesheet" href="prova/iphone.css"
	          media="screen and (max-device-width: 480px) and (orientation: portrait)">
	</head>';
		$content=str_replace("<html>",$cont,$content);
	$contenuto=$content;
         $tito=$tito."aa";
         $titol=$tito;
$cachecontenuto="CACHE MANIFEST \n\r".$tito.".html\nprova/monitor.css\nprova/iphone.css\nimm/Head.png\nNETWORK:\n*";
	 $db=dbconn();
	if (file_exists("./Athena/Performance/" .$titolopulito.".html") || file_exists("./Athena/Performance/" .$tito.".html") || file_exists("./Athena/Performance/" .$titol.".html")){
	$db=null;
	echo "file esistente";
        return $mes;
	}
	else{
		
			file_put_contents('./Athena/Performance/'.$tito.'.html', $contenuto); 
			
			file_put_contents('./Athena/Performance/'.$tito.'.manifest', $cachecontenuto);  
			$news="";
			$nomevers="AthenaPerformance";
				$mes=$mes.$nomevers."-".$titolo.",";
			$query="INSERT INTO ".$nomevers." (`titolo`, `text`) VALUES ( '".$titolo."', 'http://www.bartolomeoberrino.it/motocross/Athena/Performance/".$titol.".html')";
			//echo $query;
			$sql = $db->prepare($query);
	   		 $sql->execute();
			}
			$db=null;
             return $mes;
				
}
function aggImm($d){
	$dom = new domDocument;
	$dom->loadHTML($d);
	$dom->preserveWhiteSpace = false;
	$images = $dom->getElementsByTagName('img');
	 
	foreach ($images as $image)
	   {  
	     $imm=$image->getAttribute('src');
		 $image->setAttribute('src','http://www.athenaparts.com'.$imm);
	   }
        	   return $dom->saveXml($dom->documentElement);;
}
function puliscistringa($stringa)
{
$stringa = str_replace("à", "&aacute;", $stringa);
$stringa = str_replace("è", "&eacute;", $stringa);
$stringa = str_replace("é", "&eacute;", $stringa);
$stringa = str_replace("ò", "&oacute;", $stringa);
$stringa = str_replace("ì", "&iacute;", $stringa);
$stringa = str_replace("ù", "&uacute;", $stringa);
$stringa = ereg_replace("[^A-Za-z0-9 ]", "", $stringa );
return $stringa;
}
?>