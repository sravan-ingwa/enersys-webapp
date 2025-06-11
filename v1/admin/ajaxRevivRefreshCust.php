<?php
include('mysql.php');include('functions.php');
$val = $_REQUEST['val'];
$sql = mysql_query("SELECT * FROM ss_material_inward WHERE mrfNumber='$val'");
while($row = mysql_fetch_array($sql)){ echo $row['custName'];}
?>
