<?php
$servername = "localhost";
$username = "systemsafe";
$password = "enersys123";
$dbname = "ec_enersyscare_db";
$mr_con = mysqli_connect($servername, $username, $password, $dbname);
if ($mr_con->connect_error) {die("Connection failed");}
?>
		