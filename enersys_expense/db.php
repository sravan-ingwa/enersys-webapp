<?php
$base_url="http://enersyscare.co.in/enersys_expense/";
function getDB() {
	$database['name'] = "ec_enersyscare_db";
	$database['host'] = "localhost";
	$database['user'] = "root";
	$database['pass'] = "";
	$con=mysql_connect($database['host'], $database['user'], $database['pass']);
	$dbase=mysql_select_db($database['name']);
}
?>
