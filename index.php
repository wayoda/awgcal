<?php
include('config/settings.php');
include('config/mysql.php');
if(!isset($_GET['page'])||$_GET['page']==''){ // Startseite ausgeben
 include('site/home.php');
}elseif(preg_match('/^[A-Z]$/', $_GET['page'])){ // Straßenverzeichnis X ausgeben
 $title = 'Strassenverzeichnis '.urldecode($_GET['page']).' | '.$title;
 $canonical = $url.'/'.$_GET['page'];
 include('site/verzeichnis.php');
}elseif(in_array($_GET['page'], $static, true)){ // Statische Seiten augeben
 $canonical = $url.'/'.$_GET['page'];
 include('site/'.$_GET['page'].'.php');
}else{
 $stmt = $mysqli->prepare("SELECT strasse FROM strassen WHERE strasse = ? LIMIT 1;");
 $stmt->bind_param("s", $_GET['page']);
 $stmt->execute();
 $stmt->store_result();
 if($stmt->num_rows == 1){
  $title = urldecode($_GET['page']).' | '.$title;
  $canonical = $url.'/'.$_GET['page'];
  include('site/strassen.php');
 }else{
  include('error404.php');
 }
}
?>
