<?php
include('../mysql.php');
$loadId = $_POST['id'];
$sql="select weight from ec_product where product_alias='".$loadId."' AND flag='0'";
$res = mysqli_query($mr_con,$sql);
if(mysqli_num_rows($res) > 0){
	$row=mysqli_fetch_array($res);
	$weight = $row['weight'];
}
echo $loadId;
?>