<?php 
$database['name'] = "mymgscom_enersyscare";
$database['host'] = "localhost";
$database['user'] = "application_V1";
$database['pass'] = "Enersys1234";
mysql_connect($database['host'], $database['user'], $database['pass'])
or die(mysql_error() );
mysql_select_db($database['name'])
or die(mysql_error() );
?>
		