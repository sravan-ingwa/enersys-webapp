<?php
include('mysql.php');

$loadType = $_POST['type'];
$loadId = $_POST['id'];
if($loadType == "Circle"){$sql="select id, circle from ss_circles where zone='".$loadId."' AND flag='0' ORDER BY circle";}
else if($loadType=="Cluster"){$sql="select id, cluster from ss_clusters where circle='".$loadId."' AND flag='0' ORDER BY cluster";}
else if($loadType=="District"){$sql="select id, district from ss_districts where cluster='".$loadId."' AND flag='0' ORDER BY district";}
else if($loadType=="CustomerName"){$sql="select id, customerCode from ss_customer_details where categories='".$loadId."' AND flag='0' ORDER BY customerCode";}
else if($loadType=="EmployeeName"){$sql="select id, employeeName from ss_employee_details where circle='".$loadId."' AND designation!='19' AND flag='0' ORDER BY employeeName";}
else if($loadType=="serviceEngineer"){
	$test = mysql_query("SELECT id FROM ss_designation WHERE designation='Service Engineer' AND flag='0'");
	$t = mysql_fetch_array($test);
	$des = $t['id'];
	$sql="SELECT id,employeeId FROM ss_employee_details WHERE circles LIKE '%$loadId%' AND designation='$des' AND flag='0'";
}
else if($loadType=="regionalManager"){
	$test = mysql_query("SELECT id FROM ss_designation WHERE designation='Regional Manager' AND flag='0'");
	$t = mysql_fetch_array($test);
	$des = $t['id'];
	$sql="SELECT id,employeeId FROM ss_employee_details WHERE circles LIKE '%$loadId%' AND designation='$des' AND flag='0'";
}
$HTML = "<option value='' disabled selected>Select $loadType</option>";
$res = mysql_query($sql);
if(mysql_num_rows($res) > 0){while($row=mysql_fetch_array($res)){$HTML.="<option value='".$row['0']."'>".$row['1']."</option>";}}
echo $HTML;
?>