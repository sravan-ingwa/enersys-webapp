<?php include('mysql.php');
include('functions.php');
if($_REQUEST['sbmit']){
$customer_alias=aliasCheck(generateRandomString(),'ec_customer','customer_alias');
$customer_name=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['customer_name']));
$customer_code=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['customer_code']));
$customer_email=mysqli_real_escape_string($mr_con,$_REQUEST['customer_email']);
$customer_contact=mysqli_real_escape_string($mr_con,$_REQUEST['customer_contact']);
$dispatch=mysqli_real_escape_string($mr_con,$_REQUEST['dispatch']);
$installation=mysqli_real_escape_string($mr_con,$_REQUEST['installation']);
$segment_alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['segment_alias']));
$schedule=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['schedule']));
	$query=mysqli_query($mr_con,"INSERT INTO ec_customer(customer_name,customer_code,customer_email,customer_contact,dispatch,installation,segment_alias,schedule,customer_alias,created_date) VALUES('$customer_name','$customer_code','$customer_email','$customer_contact','$dispatch','$installation','$segment_alias','$schedule','$customer_alias','".date('Y-m-d')."')");
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>customer</title>
</head>

<body>
<h1>Customer</h1>
<form method="post">
<label>Customer Name:</label><input type="text" name="customer_name"><br><br>
<label>Customer Code:</label><input type="text" name="customer_code"><br><br>
<label>Customer Email:</label><input type="text" name="customer_email"><br><br>
<label>Customer Contact:</label><input type="text" name="customer_contact"><br><br>
<label>Dispatch:</label><input type="text" name="dispatch"><br><br>
<label>	Installation:</label><input type="text" name="installation"><br><br>
<label>Segment:</label><select name="segment_alias"><option>Select Segment</option><?php echo getdrop('segment_alias','segment_name','ec_segment');?></select><br><br>
<label>	Schedule:</label><input type="text" name="schedule"><br><br>
<input type="submit" name="sbmit">
</form>
</body>
</html>