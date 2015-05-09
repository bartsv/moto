<?php
require_once 'utility/cn_db.php';
$val=trim($_GET["user"]);
$tipo=trim($_GET["tipo"]);
if(strcmp($val,'m10')==0){
$db=dbconn();
if(!empty($tipo) && strcmp($tipo,'partner')==0)
$query="SELECT * FROM `sponsor`";
else
$query="SELECT * FROM `sponsor`where genere like 'Sponsor' ";
//echo $query;
$sql = $db->prepare($qu);
$sql->execute();
while($e=$sql->fetch(PDO::FETCH_ASSOC))
        $output[]=$e;
print(json_encode($output));
$db=null;
}
    ?>