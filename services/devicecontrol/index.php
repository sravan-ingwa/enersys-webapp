<?php 

include('../mysql.php');
include('../functions.php');
require('../Slim/Slim.php');
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$app->post('/device_mul_view','device_mul_view');
$app->post('/device_activate','device_activate');
$app->post('/device_deactivate','device_deactivate');

$app->run();

const EMP_DEVICE_STATUS_ACTIVATE_REQ = "ACTIVATE_REQUEST";
const EMP_DEVICE_STATUS_ACTIVE = "ACTIVE";
const EMP_DEVICE_STATUS_INACTIVE = "INACTIVE";

function device_mul_view() {  
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	$fromRecord = 1;
	$recordPerPage = 10;
	$toRecord = $fromRecord + $recordPerPage - 1;
	$totalRecords = 0;
	$totalpages = 0;
	$pageNo = 1;
	$perpagecount = mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);
	$page_no = mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);
	$employee_id = mysqli_real_escape_string($mr_con,$_REQUEST['employee_id']);
	$name = mysqli_real_escape_string($mr_con,$_REQUEST['name']);
	$action = mysqli_real_escape_string($mr_con,$_REQUEST['action']);
	if ($perpagecount != null) $recordPerPage = $perpagecount;
	if ($page_no != null) $pageNo = $page_no;
	if($rex==0) {
		$con = "";
		if ($employee_id) {
			$con .= " AND employee_id like '%$employee_id%'";
		}
		if ($name) {
			$con .= " AND name like '%$name%'";
		}
		if ($action == "ACTIVE") {
			$con .= " AND device_status in ('ACTIVE')";
		} else if ($action == "INACTIVE") {
			$con .= " AND device_status in ('ACTIVATE_REQUEST', 'INACTIVE')";
		} else {
			$con .= " AND device_status in ('ACTIVATE_REQUEST', 'ACTIVE', 'INACTIVE')";
		}
		$countQuery = "select count(employee_id) as count from ec_employee_master where flag = 0 $con";
		// echo $countQuery;exit;
		$rec = mysqli_fetch_array(mysqli_query($mr_con, $countQuery));
		if(!empty($rec['count'])) {
			$fromRecord = ($pageNo - 1) * $recordPerPage;
			$toRecord = $fromRecord + $recordPerPage - 1;
			$query = "select employee_alias, name, employee_id, mobile_number, android_id, device_manufacturer, device_model, device_status from ec_employee_master where device_status in ('ACTIVATE_REQUEST', 'ACTIVE', 'INACTIVE') and flag = 0 $con";
			// echo $query;exit;
			$query .= " limit $fromRecord , $recordPerPage";
			$totalRecords = $rec['count'];
			$fromRecord += 1;
			$selectSql = mysqli_query($mr_con, $query);
			$i=0;
			while($rowEmp = mysqli_fetch_array($selectSql)){
				$result['devices'][$i]['emp_alias']=$rowEmp['employee_alias'];
				$result['devices'][$i]['name']=$rowEmp['name'];
				$result['devices'][$i]['employee_id']=$rowEmp['employee_id'];
				$result['devices'][$i]['mobile_number']=$rowEmp['mobile_number'];
				$result['devices'][$i]['android_id']=$rowEmp['android_id'];
				$result['devices'][$i]['device_manufacturer']=$rowEmp['device_manufacturer'];
				$result['devices'][$i]['device_model']=$rowEmp['device_model'];
				$result['devices'][$i]['device_status']=$rowEmp['device_status'];

				$result['devices'][$i]['act_grant']=false;
				$result['devices'][$i]['deact_grant']=false;
				if ($rowEmp['device_status'] == "ACTIVATE_REQUEST" || $rowEmp['device_status'] == "INACTIVE") {
					$result['devices'][$i]['act_grant'] = grantable('ACTIVATION', 'IMEI ACT DEACT', $emp_alias);
				} else if ($rowEmp['device_status'] == "ACTIVE") {
					$result['devices'][$i]['deact_grant'] = grantable('DEACTIVATION', 'IMEI ACT DEACT', $emp_alias);
				}
				$i++;
			}
			$toRecord = ($fromRecord -1) + $i;
		}
		$result['export']=grantable('EXPORT','IMEI ACT DEACT',$emp_alias);
	}elseif($rex==1){ $resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;

	$totalpages = ceil($totalRecords/$recordPerPage);
	if($totalRecords>=1)
		for($x=0;$x<=$totalpages;$x++) $result['pages'][$x]=$x; 
	else $result['pages'][1]=1;
	echo json_encode($result);
}

function device_activate() {
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$device_emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['device_emp_alias']);
	$rex=authentication($emp_alias,$token);
	if($rex==0) {
		$query = "select employee_alias, name, employee_id, mobile_number, android_id, device_manufacturer, device_model, device_status from ec_employee_master where device_status in ('ACTIVATE_REQUEST', 'ACTIVE', 'INACTIVE') and flag = 0 and employee_alias='$device_emp_alias'";
		$rec = mysqli_fetch_array(mysqli_query($mr_con, $query));
		if($rec) {
			if ($rec["device_status"] != "ACTIVE") {
				$updateQry = "update ec_employee_master set device_status='ACTIVE' WHERE employee_alias='$device_emp_alias' AND flag=0";
				$sqlUp = mysqli_query($mr_con, $updateQry);
				if ($sqlUp) {
					$resCode = "0"; 
					$resMsg = "Employee device activated successfully";
				} else {
					$resCode = "4"; 
					$resMsg = "Employee device failed to activate";
				}
			} else {
				$resCode = "4"; 
				$resMsg = "Employee device is already active";
			}
		} else {
			$resCode = "4"; 
			$resMsg = "Employee device not found";
		}
	}elseif($rex==1){ $resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function device_deactivate() {
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$device_emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['device_emp_alias']);
	$rex=authentication($emp_alias,$token);
	if($rex==0) {
		$query = "select employee_alias, name, employee_id, mobile_number, android_id, device_manufacturer, device_model, device_status from ec_employee_master where device_status in ('ACTIVATE_REQUEST', 'ACTIVE', 'INACTIVE') and flag = 0 and employee_alias='$device_emp_alias'";
		$rec = mysqli_fetch_array(mysqli_query($mr_con, $query));
		if($rec) {
			if ($rec['device_status'] != "INACTIVE") {
				$updateQry = "update ec_employee_master set device_status='INACTIVE' WHERE employee_alias='$device_emp_alias' AND flag=0";
				$sqlUp = mysqli_query($mr_con, $updateQry);
				if ($sqlUp) {
					$resCode = "0"; 
					$resMsg = "Employee device de-activated successfully";
				} else {
					$resCode = "4"; 
					$resMsg = "Employee device failed to de-activate";
				}
			} else {
				$resCode = "4"; 
				$resMsg = "Employee device is already inactive";
			}
		} else {
			$resCode = "4"; 
			$resMsg = "Employee device not found";
		}
	}elseif($rex==1){ $resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);

}
