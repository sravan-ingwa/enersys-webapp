<?php
include('mysql.php');
include('functions.php');
if($_REQUEST['sbmit']){
$customer_name=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['customer_name']));
$customer_code=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['customer_code']));
$customer_email=mysqli_real_escape_string($mr_con,$_REQUEST['customer_email']);
$customer_contact=mysqli_real_escape_string($mr_con,$_REQUEST['customer_contact']);
$dispatch=mysqli_real_escape_string($mr_con,$_REQUEST['dispatch']);
$installation=mysqli_real_escape_string($mr_con,$_REQUEST['installation']);
$segment_alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['segment_alias']));
$schedule=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['schedule']));
$customer_alias=aliasCheck(generateRandomString(),'ec_customer','customer_alias');
$query=mysqli_query($mr_con,"INSERT INTO ec_customer(customer_name,customer_code,customer_email,customer_contact,dispatch,installation,segment_alias,schedule,customer_alias,created_date) VALUES('$customer_name','$customer_code','$customer_email','$customer_contact','$dispatch','$installation','$segment_alias','$schedule','$customer_alias','".date('Y-m-d')."')");
}
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Enersys Care</title>
<link href="css/bootstrap.css" rel="stylesheet">
<style>
.nav, .nav li{
float:none !important;
}
.nav li{
display:inline-block !important;
}
.table th{text-align:center !important;}
.dropdown-menu{min-width:50px !important;background:#f1f1f1;}
.dropdown-menu a{padding:10px !important;}
</style>
</head>
<body>
<?php include "header.php";?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title" style="display:inline-block;">Create Ticket</h3>
				</div>
				<div class="panel-body">
<form method="post">
<div class="col-md-4 form-group"><label>Customer Name:</label><input class="form-control"  type="text" name="customer_name"></div>
<div class="col-md-4 form-group"><label>Customer Code:</label><input class="form-control"  type="text" name="customer_code"></div>
<div class="col-md-4 form-group"><label>Customer Email:</label><input class="form-control"  type="text" name="customer_email"></div>
<div class="col-md-4 form-group"><label>Customer Contact:</label><input class="form-control"  type="text" name="customer_contact"></div>
<div class="col-md-4 form-group"><label>Dispatch:</label><input class="form-control"  type="text" name="dispatch"></div>
<div class="col-md-4 form-group"><label>Installation:</label><input class="form-control"  type="text" name="installation"></div>
<div class="col-md-4 form-group"><label>Segment:</label><select class="form-control"  name="segment_alias"><option>Select Segment</option><?php echo getdrop('segment_alias','segment_name','ec_segment');?></select></div>
<div class="col-md-4 form-group"><label>Schedule:</label><input class="form-control"  type="text" name="schedule"></div>
<div class="col-md-4 col-md-offset-5 form-group"><input type="submit" name="sbmit"></div>

</form>
</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
</body>
</html>