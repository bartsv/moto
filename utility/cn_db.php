<?php

function dbconn(){
// collegamento al database
$col = 'mysql:host=localhost;dbname=bartolom_motocross';

// blocco try per il lancio dell'istruzione
try {
  // connessione tramite creazione di un oggetto PDO
  $db = new PDO($col , 'barto_motocross','100289Ber');

return $db;
}
// blocco catch per la gestione delle eccezioni
catch(PDOException $e) {
  // notifica in caso di errorre
  echo 'Attenzione: '.$e->getMessage();
return null;
}
}
function conect()
{
$db=mysql_connect('localhost','barto_motocross','100289Ber');
if (!$db) {
		die ('Non riesco a connettermi: ' . mysql_error());
	}
     	$db_selected = mysql_select_db("bartolom_motocross",$db);
	if (!$db_selected) {
		die ("Errore nella selezione del database: " . mysql_error());
	}
	return $db;
}
?>