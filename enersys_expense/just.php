<?php
include('mysql.php');
$rec=mysqli_query($mr_con,"SELECT ea.request_id as requestId1, ee.bill_number as requestId1 FROM ec_advances ea INNER JOIN ec_expenses ee ON ea.employee_alias=ee.employee_alias WHERE ea.employee_alias='GVKDLIJ2ZK' LIMIT 0, 10");
while($row = $rec->fetch_assoc()){
	$result[]=$row['requestId1'];
}
print_r($result);
?>