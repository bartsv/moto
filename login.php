<?php
    require_once 'utility/cn_db.php';
session_start();
    $user=$_POST['utente'];
    $psw=$_POST['pass'];
    $user=trim($user);
    $user=addslashes($user);
$db=dbconn();
//echo  $user."aa ".$_POST["pass"]." aa".md5($psw).'<br>';
    $query="Select id from admin where nome='".$user."' and password like '".md5($psw)."'";
$sql = $db->prepare($query);
$sql->execute();
$num=$sql->rowCount();
echo $num;
if($num==1)
$_SESSION['user']=$_POST['utente'];
if(isset($_SESSION['user'])){
    echo '<html><head><title>News</title>
<script type="text/javascript" src="mio.js"></script>
</head><body style="background-image: url(http://www.bartolomeoberrino.it/motocross/News/imm/sf.jpg);"><table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="2"><tbody><tr align="center"><td style="vertical-align: top;"><img style="width: 640px; height: 97px;" alt="" src="http://www.bartolomeoberrino.it/motocross/News/imm/Head.png"><div style="text-align: right;"><span style="color: white;">Ciao '.$_SESSION['user'].'<br><a href="close.php">Close</a></span><br>
</div></td></tr>';
    echo '<tr align="center"><td style="vertical-align: top;"><select id="cat" onchange="myFunction()">
<option value="1">Video</option>
<option value="2" selected="selected">Ufo</option>

</select><br><br><div id="News"><form method="post" name="form" action="insert.php" accept-charset="utf-8" enctype="multipart/form-data"><select name="classe"><option value="News">News</option><option value="Performance">Performance</option></select><select name="ling"><option value="ita">italiano</option><option value="ing">inglese</option></select><br><span style="color: white;">Titolo:<br><input type="text" name="titolo"  style="width: 900px;"><br>Testo <br><textarea  name="test" style="width: 900px; height: 200px;"></textarea><br>Immagiine<br>

<label for="file">Immagine:</label>
<input type="file" name="file" id="file">

        <br><input value="Carica" type="submit"></form></div></tr></td>';
    echo '</tbody></table></span><br></body></html>';
}
$db=null;
?>