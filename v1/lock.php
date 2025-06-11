<?php
session_start();
include('mysql.php');
$user_check=$_SESSION['login_user'];
$ses_sql=mysql_query("SELECT * FROM ss_user_details WHERE email='$user_check'");
$row=mysql_fetch_array($ses_sql);
$login_session=$row['email'];
if(!isset($login_session) || !isset($_SESSION['login_user'])){echo "<script type='text/javascript'>window.location='login.php'</script>";}
?>
