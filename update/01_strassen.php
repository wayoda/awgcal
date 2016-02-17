<?php
include('../config/mysql.php');
$mysqli->query('TRUNCATE TABLE `strassen`');
for($b=0;$b<26;$b++){
 $url = 'http://awg.wuppertal.de/ak_app/ak_app.php?buchstabe='.chr($b+ord('A'));
 $json = file_get_contents($url);
 $daten = json_decode($json, true);
 foreach($daten['strassen'] as $s){
  $stmt = $mysqli->prepare("INSERT INTO strassen (strasse) VALUES (?)");
  $stmt->bind_param("s", $s['strassenname']);
  $stmt->execute();
  $stmt->close();
 }
}
?>
