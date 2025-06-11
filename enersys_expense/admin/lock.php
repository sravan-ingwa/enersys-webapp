<?php
session_start();
$user_check=$_SESSION['ec_admin_alias'];
if($user_check!="admin" || !isset($_SESSION['ec_admin_alias'])){echo "<script type='text/javascript'>window.location='login.php'</script>";}
?>
