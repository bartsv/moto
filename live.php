<?php	$urlmondiale="http://results.mxgp.com/mxgp/liveresults2.aspx";
		//$urlnazioni="http://results.mxgp.com/mxgp/liveresults2.aspx";
		live($urlmondiale);
       
    function live($url){
      
            $data = file_get_contents($url);
           // echo $data;
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
            
            
            
            $data = str_replace("\r\n",'',$data);
            $data = str_replace("\t",'',$data);
            $data = str_replace("&iacute",'i',$data);
            $data = str_replace("ü",'u',$data);
             $pattern_gara='|<td(.*)>(.*)</td>|iU';
            preg_match_all($pattern_gara, $data,$gara);
            $gara_array=$gara[0];
			//print_r($gara_array);
			
            $temp=explode("-",$gara_array[0]);
       //    echo htmlentities(strip_tags($temp[1]));
                        
			if(strcmp($gara_array[1], "<td></td>")==0)
			$i=17;
			else    
			$i=18;
                       // echo $i."<br><br>";
			if(count($temp)>3){
				//echo "<br>aaaa".$temp[3]."aaa";
				$result='{"classe":"'.$temp[1].'","gara":"'.strip_tags(trim($temp[2]."-".$temp[3])).'","result":[';
				if (strpos($temp[3],'Time Practice') !== false || strpos($temp[3],'Free Practice') !== false || strpos(strip_tags($temp[3]),'up') !== false) {
					//echo "qui";
					return LiveTimePractice($gara_array,$result);
				}
			}
			else {
				$result='{"classe":"'.strip_tags($temp[1]).'","gara":"'.strip_tags(trim($temp[2])).'","result":[';
				if (strpos(strip_tags($temp[2]),'Time Practice') !== false || strpos(strip_tags($temp[2]),'Free Practice') !== false || strpos(strip_tags($temp[1]),'Warm') !== false || strpos(strip_tags($temp[2]),'up') !== false) {
					return LiveTimePractice($gara_array,$result);
				}
			}
			//echo "<br><br>".$i."<br>";
			//echo $i."<br>".htmlentities($gara_array[1]);
			while ($i < count($gara_array)) {
				//echo $gara_array[$i+2]."<br>";
				$nom=explode(",", $gara_array[$i+2]);
				$result=$result.'{"Posizione":"'.strip_tags(trim($gara_array[$i])).
				'","Numero_moto":"'.strip_tags(trim($gara_array[$i+1])).
				'","Pilota":"'.strip_tags($nom[1]).' '.strip_tags($nom[0]).'","Nation":"'.preg_replace('/\s+/', '', htmlentities(strip_tags(trim($gara_array[$i+3]))))
				.'","Bike":"'.strip_tags(trim($gara_array[$i+4])).'","Time":"'.strip_tags(trim($gara_array[$i+5])).
				'","Laps":"'.strip_tags(trim($gara_array[$i+6])).'","diff_primo":"'.strip_tags(trim($gara_array[$i+7])).'","diff_prec":"'.
				strip_tags($gara_array[$i+8]).'","bestlap":"'.strip_tags($gara_array[$i+9]).
				'","L1":"'.strip_tags(trim($gara_array[$i+11])).'","L2":"'.strip_tags(trim($gara_array[$i+12])).'","L3":"'.strip_tags(trim($gara_array[$i+13])).'"}';
				
					$i+=15;
					if ($i<count($gara_array)) {
						$result=$result.",";
					}
				
			}
			
			$result=$result.']}';
       	echo $result;
    }
function LiveTimePractice($gara_array,$r){
//print_r($gara_array);
	if(strpos($gara_array[1],'Session') !== false)
		$i=17;
		else {
			$i=16;
		}
	while ($i < count($gara_array)) {
	//echo $gara_array[$i+2]."aaa<br>";
				$nom=explode(",", strip_tags($gara_array[$i+2]));
				$r=$r.'{"Posizione":"'.strip_tags($gara_array[$i]).'","Numero_moto":"'.strip_tags($gara_array[$i+1]).'","Pilota":"'.$nom[1]." ".$nom[0].'","Nation":"'.preg_replace('/\s+/', '', htmlentities(strip_tags(trim($gara_array[$i+3])))).'","Bike":"'.strip_tags($gara_array[$i+4]).'","Time":"'.strip_tags($gara_array[$i+5]).'","Laps":"'.strip_tags($gara_array[$i+6]).'","diff_primo":"'.strip_tags($gara_array[$i+7]).'","diff_prec":"'.strip_tags($gara_array[$i+8]).'","bestlap":"'.strip_tags($gara_array[$i+5]).'","L1":"'.strip_tags($gara_array[$i+10]).'","L2":"'.strip_tags(trim($gara_array[$i+11])).'","L3":"'.strip_tags(trim($gara_array[$i+12])).'"}';
				$i+=14;
					if ($i<count($gara_array)) {
						$r=$r.",";
					}
				
			}
			
			$r=$r.']}';
       	echo $r;
}
{
	
}
?>