<?php 


error_reporting(0);
ini_set('display_errors', 0);

include('env.php');
$mr_con = new mysqli($servername, $username, $password, $dbname);
if ($mr_con->connect_error) {die("Connection failed");} 

$query = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
mysqli_query($mr_con,$query);

?>
