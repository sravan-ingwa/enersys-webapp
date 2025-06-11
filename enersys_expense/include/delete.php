<?php
$servername = "localhost";
$username = "root";
$password = "enersys123";
$dbname = "ec_enersyscare_db";
$mr_con = new mysqli($servername, $username, $password, $dbname);
if ($mr_con->connect_error) {die("Connection failed");} 
function alias($alias,$tb,$col,$retrive){
	global $mr_con;
	$sql = $mr_con->query("SELECT $retrive FROM $tb WHERE $col='$alias' AND flag=0");
	if(mysqli_num_rows($sql)){
		$row = mysqli_fetch_array($sql);
		return $row[$retrive];
	}
}
$expenses_alias = '1HVGFL5UNJ';
$arr = array("ec_conveyance","ec_expenses","ec_localconveyance","ec_lodging","ec_other_expenses");
foreach($arr as $abc){
	if($abc!="ec_expenses" && $abc!="ec_localconveyance"){
		$xyz = alias($expenses_alias,$abc,"expenses_alias","document_link");
		if(file_exists($xyz))@unlink($xyz);
	}
	$sql = mysqli_query($mr_con,"DELETE FROM $abc WHERE expenses_alias='$expenses_alias' AND flag=0");
}
?>]