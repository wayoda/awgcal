<?php
include('header.php');
echo '   <div class="well">';
$stmt = $mysqli->query("SELECT DISTINCT strasse FROM strassen WHERE SUBSTRING(strasse,1,1) = '".$_GET['page']."' AND tour_id != 0 ORDER BY strasse ASC;");
$rows = ceil($stmt->num_rows/3);
echo '  <div class="row">'."\n";
echo '   <div class="col-sm-4">'."\n";
$i = 0;
while($row=$stmt->fetch_assoc()){
 if($i==$rows OR $i==$rows*2){
  echo '    </div>'."\n".'  <div class="col-sm-4">'."\n";
 }
 $i++;
 echo '    <p><a href="'.$row['strasse'].'">'.$row['strasse'].'</a></p>'."\n";
}
echo "     <div>\n";
echo "    <div>\n";
echo "   <div>\n";
include('footer.php');
?>
