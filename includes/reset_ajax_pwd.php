<?php
include('../services/mysql.php');
include('../services/functions.php');
if(isset($_REQUEST['emp_alias']) && isset($_REQUEST['pwd']) && isset($_REQUEST['cpwd'])){
	$emp_alias=mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$pwd=mysqli_real_escape_string($mr_con,$_REQUEST['pwd']);
	$cpwd=mysqli_real_escape_string($mr_con,$_REQUEST['cpwd']);
	if(!isset($emp_alias) || empty($emp_alias)){$res = "Sorry try again";}
	elseif(empty($pwd)){$res = "Please Enter Password";}
	elseif(empty($cpwd)){$res = "Please Enter Confirm Password";}
	elseif($pwd !== $cpwd){$res = "Password and Confirm Password must be equal";}
	else{
		$password = password_hash_encript($pwd);
		if(strtoupper($emp_alias)=='ADMIN' || strtoupper($emp_alias)=='EADMIN'){
			$q2 = mysqli_query($mr_con,"UPDATE ec_admin SET password='$password',verification_code='0' WHERE user_name='$emp_alias' AND flag=0");
		}else{
			$q2 = mysqli_query($mr_con,"UPDATE ec_employee_master SET password='$password',verification_code='0' WHERE employee_alias='$emp_alias' AND flag=0");
		}
		if($q2){$resMsg="0@@Password has successfully changed! Please signin using new password";}
		else{$resMsg="4@@Sorry try again!";}
	}
	if(isset($res)){$resMsg="4@@".$res;}
	echo $resMsg;
}
?>