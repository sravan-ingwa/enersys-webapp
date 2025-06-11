<?php
include('mysql.php');
include('functions.php');
$user_input = trim($_REQUEST['term']);
// Define two array, one is to store output data and other is for display
$display_json = array();
$json_arr = array();
$user_input = preg_replace('/\s+/', ' ', $user_input);
$recSql = mysql_query("SELECT * FROM ss_site_master WHERE siteID LIKE '%$user_input%' AND flag=0");
if(mysql_num_rows($recSql)>0){
	while($recResult = mysql_fetch_array($recSql)) {
		$sql = mysql_query("SELECT * FROM ss_site_master WHERE id = '$recResult[id]'");
		$row = mysql_fetch_array($sql);
  		$json_arr["id"] = $row['siteID'].",,".$row['siteName'].",,".zoneGetName($row['zone']).",,".circleGetName($row['circle']).",,".clustersGetName($row['cluster']).",,".districtsGetName($row['district']).",,".$row['mfdDate'].",,".$row['installDate'].",,".$row['noOfString'].",,".$row['customerName'].",,".$row['customerNumber'].",,".customerCategoriesGetName($row['customerCategory']).",,".$row['siteType'].",,".customerNameGetName($row['customerCode']).",,".$row['clusterManagerMail'].",,".productCodeGetName($row['productCode']);
  		$json_arr["value"] = $recResult['siteID'];
  		$json_arr["label"] = $recResult['siteID'];
  		array_push($display_json, $json_arr);
	}	
} 
else {
  $json_arr["id"] = "Add Manually";
  $json_arr["value"] = "";
  $json_arr["label"] = "Add Manually";
  array_push($display_json, $json_arr);
}
$jsonWrite = json_encode($display_json); //encode that search data
echo $jsonWrite;
?>