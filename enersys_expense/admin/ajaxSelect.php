<?php
include('mysql.php');
$loadType = $_POST['type'];
$loadId = $_POST['id'];
$flag = $_POST['flag'];
if($loadType == "state"){$sql="select state_alias,state_name from ec_state where zone_alias='".$loadId."' AND flag='0' ORDER BY state_name";}
else if($loadType=="district"){$sql="select district_alias, district_name from ec_district where state_alias='".$loadId."' AND flag='0' ORDER BY district_name";}
else if($loadType=="area"){$sql="select area from ec_district where district_alias='".$loadId."' AND flag='0' ORDER BY district_name";}
else if($loadType=="weight"){$sql="select weight from ec_product where product_alias='".$loadId."' AND flag='0'";}
if($loadType == "state" || $loadType == "district"){
	if($flag != 'list'){
		$HTML = "<option value='' disabled selected>Select $loadType</option>";
	}else{
		$HTML = "<option value='' disabled selected></option>";
	}
	$res = mysqli_query($mr_con,$sql);
	if(mysqli_num_rows($res) > 0){while($row=mysqli_fetch_array($res)){$HTML.="<option value='".$row['0']."'>".$row['1']."</option>";}}
	echo $HTML;
}else if($loadType == "area"){
	$res = mysqli_query($mr_con,$sql);
	if(mysqli_num_rows($res) > 0){
		
		$row=mysqli_fetch_array($res);
		$area_flag = $row['area'];
	}
	echo $area_flag;
} else if($loadType == "weight"){
	$res = mysqli_query($mr_con,$sql);
	if(mysqli_num_rows($res) > 0){
		$row=mysqli_fetch_array($res);
		$weight = $row['weight'];
	}
	echo $weight;	
}
?>