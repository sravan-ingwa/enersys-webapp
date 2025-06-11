<?php 
$database['name'] = "mymgscom_enersyscare";
$database['host'] = "localhost";
$database['user'] = "application_V1";
$database['pass'] = "Enersys1234";
//$database['user'] = "root";
//$database['pass'] = "enersys123";
$con = mysql_connect($database['host'], $database['user'], $database['pass']);
$db = mysql_select_db($database['name']);
?>
		