<?php
include('../config/mysql.php');
$s = $mysqli->query("SELECT * FROM strassen WHERE tour_id IS NULL");

while($row=$s->fetch_assoc()){
 $url = 'http://awg.wuppertal.de/ak_app/ak_app.php?strasse='.urlencode($row['strasse']).'&monat_von=1&monat_bis=12&jahr_von='.date("Y").'&jahr_bis='.(date("Y")+1);
 $json = file_get_contents($url);
 $daten = json_decode($json, true);
 if(empty($daten['hausnummern'])){ // Keine Hausnummer benötigt
  $stmt = $mysqli->prepare("SELECT tour_id FROM touren WHERE tour_bez = ? AND sperr_id = ? AND papier_id = ?;");
  $stmt->bind_param("sii", $daten['tour_bez'], $daten['sperrmuell_id'], $daten['papier_id']);
  $stmt->execute();
  $stmt->store_result();
  if($stmt->num_rows < 1){ // tour_id wird falls notwendig angelegt
   $stmt2 = $mysqli->prepare("INSERT INTO touren (tour_bez, sperr_id, papier_id) VALUES (?, ?, ?);");
   $stmt2->bind_param("sii", $daten['tour_bez'], $daten['sperrmuell_id'], $daten['papier_id']);
   $stmt2->execute();
   $tour_id = $stmt2->insert_id;
   $stmt2->close();
  }else{
   $stmt->bind_result($tour_id);
   $stmt->fetch();
  }
  $stmt->close();

  $stmt = $mysqli->prepare("UPDATE strassen SET tour_id = ? WHERE strasse = ?;");
  $stmt->bind_param("is", $tour_id, $row['strasse']);
  $stmt->execute();
  $stmt->close();

  foreach($daten['tage'] as $datum=>$daten){
   if($daten['tonne_grau'] == 'x' OR $daten['tonne_grau50'] == 'x' OR $daten['tonne_gelb'] == 'x' OR $daten['papier'] == 'x' OR $daten['tonne_bio'] == 'x' OR $daten['sperrmuell'] == 'x' OR $daten['weihnachtsbaum'] == 'x'){
    $stmt = $mysqli->prepare("INSERT INTO termine (tour_id, datum, datum_alt, grau, grau50, gelb, blau, bio, sperr, baum) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
    $grau = ($daten['tonne_grau'] == 'x') ? 1 : 0;
    $grau50 = ($daten['tonne_grau50'] == 'x') ? 1 : 0;
    $gelb = ($daten['tonne_gelb'] == 'x') ? 1 : 0;
    $blau = ($daten['papier'] == 'x') ? 1 : 0;
    $bio = ($daten['tonne_bio'] == 'x') ? 1 : 0;
    $sperr = ($daten['sperrmuell'] == 'x') ? 1 : 0;
    $baum = ($daten['weihnachtsbaum'] == 'x') ? 1 : 0;
    $stmt->bind_param("issiiiiiii", $tour_id, $datum, $daten['verschoben_von'], $grau, $grau50, $gelb, $blau, $bio, $sperr, $baum);
    $stmt->execute();
    $stmt->close();
   }
  }
 }else{ // Hausnummern anlegen
  foreach($daten['hausnummern'] as $hausnummer=>$daten){
   $stmt = $mysqli->prepare("INSERT INTO strassen (strasse, hausnr) VALUES (?, ?);");
   $stmt->bind_param("ss", $row['strasse'], $daten['hausnummer']);
   $stmt->execute();
   $stmt->close();
  }
 }
}
$mysqli->close();
?>
