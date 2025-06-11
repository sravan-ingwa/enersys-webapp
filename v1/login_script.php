<?php
	session_start();
	include('mysql.php');
	$myusername=addslashes($_POST["userId"]);
	$mypassword=addslashes($_POST["pass"]);
	$result=mysql_query("SELECT * FROM ss_user_details WHERE BINARY email= BINARY '$myusername' and BINARY password= BINARY '$mypassword'");
	$row=mysql_fetch_array($result);
	$count=mysql_num_rows($result);
	if($count==1){
		$_SESSION['login_user']=$row['email'];
		echo "<script type='text/javascript'>window.location='index.php'</script>";
	}
	else {$ref=uniqid();echo "<script type='text/javascript'>window.location='login.php?ref=$ref'</script>";}
?>
