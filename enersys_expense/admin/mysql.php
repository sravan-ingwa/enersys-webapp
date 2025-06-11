<?php 
$servername = "localhost";
$username = "application_V2";
$password = "Enersys1234";
$dbname = "ec_enersyscare_db";
$mr_con = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {die("Connection failed");} 
?>
		