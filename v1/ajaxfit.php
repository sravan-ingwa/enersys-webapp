<?php
include('mysql.php');
include('functions.php');
$loadType = $_POST['type'];
$loadId = $_POST['id'];
$tbna = $_POST['tbna'];
$date = $_POST['date'];
if($tbna=='smSchedule'){
	$sql="select schedule from  ss_customer_details where id='".$loadId."' AND flag='0'";$res = mysql_query($sql);
	if(mysql_num_rows($res)>0){while($row=mysql_fetch_array($res)){$HTML=$row['schedule'];}}
}
if($tbna=='prwarr'){
	$sql="select dispatch,installation from ss_customer_details where id='".$loadId."'  AND flag='0'";$res = mysql_query($sql);
	if(mysql_num_rows($res)>0){while($row=mysql_fetch_array($res)){$HTML=$row['dispatch'].",".$row['installation'];}}
}
if($tbna=='userdetails'){
	if($loadType=='CU2548'){
		$sql="select contactNo,email,customerName from ss_customer_details where id='".$loadId."'  AND flag='0'";$res = mysql_query($sql);
		if(mysql_num_rows($res)>0){$row=mysql_fetch_array($res);$HTML=$row['contactNo'].",,".$row['email'].",,".$row['customerName'];}
	}else{
		$sql="select contactNo,email,employeeName,id from ss_employee_details where employeeId='".$loadId."'  AND flag='0'";$res = mysql_query($sql);
		if(mysql_num_rows($res)>0){$row=mysql_fetch_array($res);$HTML=$row['contactNo'].",,".$row['email'].",,".$row['employeeName'].",,".$row['id'];}	
	}
}
if($tbna=='roles'){ if($loadId=='CU2548')$HTML = customerDetailsOption(); else $HTML = employeeOption(); }
echo $HTML;
?>