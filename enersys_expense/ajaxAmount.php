<?php
include('mysql.php');
$bucket = $_POST['bucket'];
$zone = $_POST['zonesel'];
$state = $_POST['statesel'];
$district = $_POST['dissel'];
$weight = $_POST['weight'];
$qnty = $_POST['qnty'];
$km = $_POST['km'];
$appli = $_POST['appli'];
$ref = $_POST['ref'];
$diff=1;
if($zone != '' && $state != '' && $district!= ''){
	$get = ($ref=='lc' ? 'local_conveyance' : ($ref=='ld' ? 'lodging_amount' : 'daily_allowance'));
	$get_LC = mysqli_query($mr_con,"select $get from ec_service_allowances where zone_alias='".$zone."' AND state_alias='".$state."' AND district_alias='".$district."' AND flag='0'");
	if(mysqli_num_rows($get_LC) > 0){
		$row=mysqli_fetch_array($get_LC);
		$lc = $row[$get];
	}
}else{$rec = 0;}
if($ref=='ld' || $ref=='bd'){
	if($_POST['fda'] != '' && $_POST['eda'] != ''){
	$date1 = new DateTime($_POST['fda']);
	$date2 = new DateTime($_POST['eda']);
	if($ref=='bd')
	$diff = ($date2->diff($date1)->format("%a"))+1;
	else
	$diff = ($date2->diff($date1)->format("%a"));
	$rec = $lc*$diff;}else{$rec = 0;}
}else{
	if($bucket == 1){ $rec = $lc; }
	else if($bucket == 0){ 
		$recc = (($weight*$qnty*$km*$appli)+($lc/2));
		$rec = round($recc, 2);
	}
	else{$rec = 0;}
}
echo $rec;
?>