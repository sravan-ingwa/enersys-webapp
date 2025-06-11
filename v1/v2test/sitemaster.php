<?php
include('mysql.php'); 
include('functions.php');
if($_REQUEST['sbmit']){
	$alias = aliasCheck(generateRandomString(),'ec_sitemaster','site_alias');
	$zone_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['zone_alias']));
	$state_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['state_alias']));
	$district_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['district_alias']));
	$segment_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['segment_alias']));
	$customer_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['customer_alias']));
	$site_type_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_type_alias']));
	$site_id = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_id']));
	$site_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_name']));
	$product_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['product_alias']));
	$mfd_date = mysqli_real_escape_string($mr_con,$_REQUEST['mfd_date']);
	$install_date = mysqli_real_escape_string($mr_con,$_REQUEST['install_date']);
	$no_of_string = mysqli_real_escape_string($mr_con,$_REQUEST['no_of_string']);
	$technician_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['technician_name']));
	$technician_number = mysqli_real_escape_string($mr_con,$_REQUEST['technician_number']);
	$manager_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['manager_name']));
	$manager_number = mysqli_real_escape_string($mr_con,$_REQUEST['manager_number']);
	$manager_mail = mysqli_real_escape_string($mr_con,$_REQUEST['manager_mail']);
	$site_status_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_status_alias']));
	$site_address = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_address']));
	$query=mysqli_query($mr_con,"INSERT INTO ec_sitemaster(zone_alias,state_alias,district_alias,segment_alias,customer_alias,site_type_alias,site_id,site_name,site_alias,product_alias,mfd_date,install_date,no_of_string,technician_name,technician_number,manager_name,manager_number,manager_mail,site_status_alias,site_address,created_date) VALUES('$zone_alias','$state_alias','$district_alias','$segment_alias','$customer_alias','$site_type_alias','$site_id','$site_name','$alias','$product_alias','$mfd_date','$install_date','$no_of_string ','$technician_name','$technician_number','$manager_name','$manager_number','$manager_mail','$site_status_alias','$site_address','".date('Y-m-d')."')");
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sitemaster</title>
</head>
<body>
<form method="post">
<label>Zone :</label><select name="zone_alias"><option value=''>Select Zone</option><?php echo getdrop('zone_alias','zone_name','ec_zone');?></select><br><br>
<label>State :</label><select name="state_alias"><option value=''>Select State</option><?php echo getdrop('state_alias','state_name','ec_state');?></select><br><br>
<label>District :</label><select name="district_alias"><option value=''>Select District</option><?php echo getdrop('district_alias','district_name','ec_district');?></select><br><br>
<label>Segment :</label><select name="segment_alias"><option value=''>Select Segment</option><?php echo getdrop('segment_name','segment_name','ec_segment');?></select><br><br>
<label>Customer :</label><select name="customer_alias"><option value=''>Select Customer</option><?php echo getdrop('customer_alias','customer_name','ec_customer');?></select><br><br>
<label>Site Type :</label><select name="site_type_alias"><option value=''>Select Site Type</option><?php echo getdrop('site_type_alias','site_type','ec_site_type');?></select><br><br>
<label>Site ID:</label><input type="text" name="site_id"><br><br>
<label>Site Name:</label><input type="text" name="site_name"><br><br>
<label>Product :</label><select name="product_alias"><option value=''>Select Product</option><?php echo getdrop('product_alias','product_code','ec_product');?></select><br><br>
<label>MFD Date:</label><input type="date" name="mfd_date"><br><br>
<label>Install Date:</label><input type="date" name="install_date"><br><br>
<label>No Of String:</label><input type="text" name="no_of_string"><br><br>
<label>Technician Name:</label><input type="text" name="technician_name"><br><br>
<label>Technician Number:</label><input type="text" name="technician_number"><br><br>
<label>Manager Name:</label><input type="text" name="manager_name"><br><br>
<label>Manager Number:</label><input type="text" name="manager_number"><br><br>
<label>Manager Mail:</label><input type="text" name="manager_mail"><br><br>
<label>Site Status :</label><select name="site_status_alias"><option value=''>Select Site Status</option><?php echo getdrop('site_status_alias','site_status','ec_site_status');?></select><br><br>
<label>Site Address:</label><input type="text" name="site_address"><br><br>
<input type="submit" name="sbmit">
</form>
</body>
</html>