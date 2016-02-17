<?php
include('settings.php');
global $mysqli;
$mysqli = new mysqli();
$mysqli->connect($dbhost, $dbuser, $dbpass, $dbname);
$mysqli->set_charset("utf8");
if($mysqli->connect_errno){
 printf("Connect failed: %s\n", $mysqli->connect_error);
 exit();
}
?>
