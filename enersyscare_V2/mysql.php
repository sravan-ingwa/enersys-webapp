<?php
$servername = "localhost";
$username = "application_V2";
$password = "Enersys1234";
$dbname = "ec_enersyscare_db";
$mr_con = mysqli_connect($servername, $username, $password, $dbname);
if ($mr_con->connect_error) {die("Connection failed");}
?>
		