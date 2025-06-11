<?php
session_start();
if(isset($_REQUEST['ref'])){
	$re=base64_encode("No Permission To view");
	if(session_destroy()){	
		echo "<script type='text/javascript'>window.location='login.php?ref2=$re'</script>";
	}
}
else{
	if(session_destroy()){	
		echo "<script type='text/javascript'>window.location='login.php'</script>";
	}
}
?>