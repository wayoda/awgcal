<?php
$tag[0] = 'Sonntag';
$tag[1] = 'Montag';
$tag[2] = 'Dienstag';
$tag[3] = 'Mittwoch';
$tag[4] = 'Donnerstag';
$tag[5] = 'Freitag';
$tag[6] = 'Samstag';
include('header.php');
$stmt = $mysqli->prepare("SELECT strasse, MIN(CONVERT(hausnr, DECIMAL)), MAX(CONVERT(hausnr, DECIMAL)), tour_id FROM strassen WHERE strasse = ? AND tour_id != 0 GROUP BY tour_id ORDER BY CONVERT(hausnr, DECIMAL);");
$stmt->bind_param("s", $_GET['page']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($strasse, $hausnr1, $hausnr2, $tour);
 while($stmt->fetch()){
  if($hausnr1 != 0 && $hausnr1 != $hausnr2){
   echo '<p><div class="well" style="font-size:1.25em;"><b>'.$strasse.' '.$hausnr1.' - '.$hausnr2.'</b></div></p>';
  }else{
   echo '<p><div class="well" style="font-size:1.25em;"><b>'.$strasse.' '.$hausnr1.'</b></div></p>';
  }
  $stmt2 = $mysqli->prepare("SELECT datum, datum_alt, grau, grau50, gelb, blau, bio, sperr, baum FROM termine WHERE tour_id = ? AND datum >= CURDATE() LIMIT 1;");
  $stmt2->bind_param("i", $tour);
  $stmt2->execute();
  $stmt2->store_result();
  $stmt2->bind_result($datum, $datumalt, $grau, $grau50, $gelb, $blau, $bio, $sperr, $baum);
  $stmt2->fetch();
  echo '
<div class="row">
 <div class="col-sm-4">
  <p><b>Müllabfuhr <time datetime="'.date("Y-m-d", strtotime($datum)).'">'.date("d.m.Y", strtotime($datum)).'</time> ('.$tag[date("w", strtotime($datum))].')</b></p>
  <p><div class="btn-group" role="group">';
   if($grau == 1) echo '<button type="button" class="btn btn-default"><i class="fa fa-trash fa-2x" style="color:black"></i><br /><b>Grau</b></button> ';
   if($grau50 == 1) echo '<button type="button" class="btn btn-default"><i class="fa fa-trash-o fa-2x" style="color:grey"></i><br /><b>50%</b></button> ';
   if($gelb == 1) echo '<button type="button" class="btn btn-default"><i class="fa fa-trash fa-2x" style="color:gold"></i><br /><b>Gelb</b></button> ';
   if($blau == 1) echo '<button type="button" class="btn btn-default"><i class="fa fa-trash fa-2x" style="color:blue"></i><br /><b>Blau</b></button> ';
   if($bio == 1) echo '<button type="button" class="btn btn-default"><i class="fa fa-trash fa-2x" style="color:brown"></i><br /><b>Braun</b></button> ';
   if($sperr == 1) echo '<button type="button" class="btn btn-default"><i class="fa fa-recycle fa-2x" style="color:green"></i><br /><b>SM</b></button> ';
   if($baum == 1) echo '<button type="button" class="btn btn-default"><i class="fa fa-tree fa-2x" style="color:green"></i><br /><b>WB</b></button> ';
   echo '
  </div></p>
 </div>
 <div class="col-sm-4">
  <p><b>Sperrmüll</b></p>
  <p><div class="btn-group" role="group">';
$stmt3 = $mysqli->prepare("SELECT datum FROM termine WHERE tour_id = ? AND sperr = 1 AND datum >= CURDATE() LIMIT 4;");
$stmt3->bind_param("i", $tour);
$stmt3->execute();
$stmt3->store_result();
$stmt3->bind_result($datum);
if($stmt3->num_rows >= 1){
 while($stmt3->fetch()){
  echo '<a onclick="recycle()" class="btn btn-default"><i class="fa fa-recycle fa-2x" style="color:green"></i><br /><b>'.date("d.m.", strtotime($datum)).'</b></a> ';
 }
}else{
 echo '<button type="button" class="btn btn-default disabled"><i class="fa fa-recycle fa-2x" style="color:green"></i><br /><b>Keine Daten verfügbar</b></button> ';
}
echo '
  </div>
 </div>
 <div class="col-sm-4">
  <p><b>Kalender</b></p>
  <p><div class="btn-group" role="group">
   <a href="http://ak-ics.tal42.de/2014/'.$tour.'.ics" class="btn btn-default"><i class="fa fa-download fa-2x"></i><br /><b>2014</b></button></a>
   <a href="http://ak-ics.tal42.de/2015/'.$tour.'.ics" class="btn btn-default"><i class="fa fa-download fa-2x"></i><br /><b>2015</b></button></a>
   <a onclick="cog()" class="btn btn-default"><i class="fa fa-cog fa-2x"></i><br /><b>&nbsp;</b></button></a>
   <a href="/faq" class="btn btn-default"><i class="fa fa-question-circle fa-2x"></i><br /><b>FAQ</b></button></a>
  </div></p>
 </div>
</div>';
 }
?>
<script>
function cog() {
    alert("Hier kann bald ein individueller Kalender erstellt werden.");
}
function recycle() {
    alert("Hier kann bald ein Liste mit Staßen angezeigt werden in denen auch Spermüll abgeholt wird.");
}
</script>
<?php
include('footer.php');
?>
