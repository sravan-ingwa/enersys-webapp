<?php
include('mysql.php');
include('functions.php');
if($_REQUEST['sbmit']){
$product_code=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['product_code']));
$battery_rating=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['battery_rating']));
$cell_voltage=mysqli_real_escape_string($mr_con,$_REQUEST['cell_voltage']);
$cell_rating=mysqli_real_escape_string($mr_con,$_REQUEST['cell_rating']);
$product_alias=aliasCheck(generateRandomString(),'ec_product','product_alias');
	$query=mysqli_query($mr_con,"INSERT INTO ec_product(product_code,battery_rating,cell_voltage,cell_rating,created_date,product_alias) VALUES('$product_code','$battery_rating','$cell_voltage','$cell_rating','".date('Y-m-d')."','$product_alias')");
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<body>
<h1>Product</h1>
<form method="post">
<label>	Product Code:</label><input type="text" name="product_code"><br><br>
<label>	Battery Rating:</label><input type="text" name="battery_rating"><br><br>
<label>	Cell Voltage:</label><input type="text" name="cell_voltage"><br><br>
<label>	Cell Rating:</label><input type="text" name="cell_rating"><br><br>
<input type="submit" name="sbmit">
</form>
</body>
</html>