<?php
session_start();
include('mysql.php');
$user_check=$_SESSION['ec_user_alias'];
$ses_sql=mysqli_query($mr_con,"SELECT employee_alias FROM ec_employee_master WHERE employee_alias='$user_check'");
$row=mysqli_fetch_array($ses_sql);
if(!isset($row['employee_alias']) || !isset($_SESSION['ec_user_alias'])){echo "<script type='text/javascript'>window.location='login.php'</script>";}
?>
