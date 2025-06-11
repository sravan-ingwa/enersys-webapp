<?php
include('mysql.php');
include('functions.php');
if($_REQUEST['sbmit']){
$product_description=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['product_description']));
$battery_rating=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['battery_rating']));
$cell_voltage=mysqli_real_escape_string($mr_con,$_REQUEST['cell_voltage']);
$product_alias=aliasCheck(generateRandomString(),'ec_product','product_alias');
	$query=mysqli_query($mr_con,"INSERT INTO ec_product(product_description,battery_rating,cell_voltage,created_date,product_alias) VALUES('$product_description','$battery_rating','$cell_voltage','".date('Y-m-d')."','$product_alias')");
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
<div class="col-md-4 form-group"><label>	Product Code:</label><input type="text" class="form-control"  name="product_description"></div>
<div class="col-md-4 form-group"><label>	Battery Rating:</label><input type="text" class="form-control"  name="battery_rating"></div>
<div class="col-md-4 form-group"><label>	Cell Voltage:</label><input type="text" class="form-control"  name="cell_voltage"></div>
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