function myFunction()
{
var sel = document.getElementById("cat");
var val=sel.options[sel.selectedIndex].value ;
if(val=="3"){
document.getElementById("News").innerHTML='<form method="post" name="form" action="insertAthena.php" accept-charset="utf-8"  enctype="multipart/form-data"><select name="classe"><option value="Performance">Performance</option><option value="News">News</option></select><br><span style="color: white;">Titolo:<br><input type="text" name="titolo"  style="width: 900px;"><br>Testo <br><textarea  name="test" style="width: 900px; height: 200px;"></textarea><br><input value="Carica" type="submit"></form>';
}
else
if(val=="2"){
document.getElementById("News").innerHTML='<form method="post" name="form" action="insert.php" accept-charset="utf-8"  enctype="multipart/form-data"><select name="classe"><option value="News">News</option><option value="Performance">Performance</option></select><select name="ling"><option value="ita">italiano</option><option value="ing">inglese</option></select><br><span style="color: white;">Titolo:<br><input type="text" name="titolo"  style="width: 900px;"><br>Testo <br><textarea  name="test" style="width: 900px; height: 200px;"></textarea><br>Immagiine<br><label for="file">Immagine:</label><input type="file" name="file" id="file"><br><input value="Carica" type="submit"></form>';
}else
document.getElementById("News").innerHTML='<form method="post" name="form" onsubmit="insertVideo(this);return false;" accept-charset="utf-8"  enctype="multipart/form-data"><select name="classe"><option value="videoMX1">Video MX1</option><option value="videoMX2">Video MX2</option><option value="videoMX3">Video MX3</option><option value="videoWMX">Video WMX</option></select><br><span style="color: white;">Titolo Video :<br><input type="text" name="titolo"  style="width: 500px;"><br>Link : <br><input type="text" name="sito" style="width: 500px;"><br><input value="Carica" type="submit"></form>';
}


function insertVideo(form){
AJAXReqV("GET","insertV.php",true,form);
}

function AJAXReqV(method,url,bool,form){
 var titolo=form.titolo.value;
  var classe=form.classe.value;
  var sito=form.sito.value;
if(titolo=="" && sito==""){
window.alert("compile i campi mancanti "+titolo);
return;
}
else{
  if(window.XMLHttpRequest){
    m = new XMLHttpRequest();
  } else 
  
  if(window.ActiveXObject){
    m = new ActiveXObject("Microsoft.XMLHTTP");
    
    if(!m){
      m = new ActiveXObject("Msxml2.XMLHTTP");
    }
  }
  
  if(m){

m.open("GET","insertV.php?titolo="+titolo+"&classe="+classe+"&sito="+sito,true);

m.send();
m.onreadystatechange=function()
  {
    if (m.readyState==4 && m.status==200)
    {
    window.alert(m.responseText);
    }
  };

  }else{
    window.alert("Impossibilitati ad usare AJAX");
}
  }
}