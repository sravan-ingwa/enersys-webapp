<?php 
include('../mysql.php');
include('../functions.php');
require('../Slim/Slim.php');
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->post('/imei_edit','imei_edit');
$app->post('/imei_deactivation','imei_deactivation');
$app->post('/imei_view','imei_view');
$app->post('/imei_mul_view','imei_mul_view');
$app->post('/imei_export','imei_export');
$app->run();
function imei_edit(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$employee_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['employee_alias'])));
		$device = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['device'])));
		$device_2 = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['device_2'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($employee_alias))$res="Sorry Try Again!";
		elseif(empty($device) && empty($device_2))$res="Please enter at least one IMEI No.";
		elseif(empty($remarks))$res="Please enter remarks";
		else{
			$sql_old = mysqli_query($mr_con,"SELECT device,device_2 FROM ec_employee_master WHERE employee_alias='$employee_alias' AND flag='0'");
			if(mysqli_num_rows($sql_old)){
				$row_old = mysqli_fetch_array($sql_old);
				$device_old = $row_old['device'];
				$device_2_old = $row_old['device_2'];
				$sql = mysqli_query($mr_con,"UPDATE ec_employee_master SET device='$device',device_2='$device_2' WHERE employee_alias='$employee_alias' AND flag='0'");
				if($sql){
					$act_name = (strtoupper($emp_alias)=='ADMIN' ? 'ADMIN' : alias($emp_alias,'ec_employee_master','employee_alias','name'));
					$name = alias($employee_alias,'ec_employee_master','employee_alias','name');
					$action=$act_name;
					if(empty($device_old) && empty($device_2_old))$action.=" is activated $name\'s First IMEI No. with $device and Second IMEI No. with $device_2.";
					else{
						if($device != $device_old || $device_2 != $device_2_old)$action.=" changed $name\'s";
						if($device != $device_old)$action.=" First IMEI No. from $device_old to $device".($device_2 != $device_2_old ? " and":".");
						if($device_2 != $device_2_old)$action.=" Second IMEI No. from $device_2_old to $device_2.";
					}
					if($action!=$act_name)$imei_his=mysqli_query($mr_con,"INSERT INTO ec_imei_history(employee_alias,action,remarks)VALUES('$employee_alias','$action','$remarks')");
					$user_action="$name employee Device IMEI No. are Updated.";
					user_history($emp_alias,$user_action,$_REQUEST['ip_addr']);
					$resCode='0';$resMsg='Successful!';
				}else $res='Sorry IMEI No\'s are not updated!';
			}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function imei_deactivation(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$employee_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['alias'])));
		$remarks = "DEVICE IMEI DEACTIVATED";//strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($employee_alias)){$res="Sorry Try Again!";}
		elseif(empty($remarks))$res="Please enter remarks";
		else{
			$sql = mysqli_query($mr_con,"UPDATE ec_employee_master SET device='0',device_2='0' WHERE employee_alias='$employee_alias' AND flag='0'");
			if($sql){
				$act_name = (strtoupper($emp_alias)=='ADMIN' ? 'ADMIN' : alias($emp_alias,'ec_employee_master','employee_alias','name'));
				$action=$act_name." is deactivated ".alias($employee_alias,'ec_employee_master','employee_alias','name')."\'s device IMEI Nos";
				$imei_his=mysqli_query($mr_con,"INSERT INTO ec_imei_history(employee_alias,action,remarks)VALUES('$employee_alias','$action','$remarks')");
				user_history($emp_alias,$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';
			}else $res='Sorry Try Again!';
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function imei_view(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$employee_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['alias'])));
		if(empty($employee_alias))$res="Sorry Try Again!";
		else{
			$sql = mysqli_query($mr_con,"SELECT employee_alias,name,employee_id,device,device_2 FROM ec_employee_master WHERE employee_alias='$employee_alias' AND flag='0'");
			if(mysqli_num_rows($sql)){
				$row=mysqli_fetch_array($sql);
				$result['employee_alias']=$row['employee_alias'];
				$result['name']=$row['name'];
				$result['employee_id']=$row['employee_id'];
				$result['device']=(empty($row['device']) ? '' : $row['device']);
				$result['device_2']=(empty($row['device_2']) ? '' : $row['device_2']);
				$resCode='0';$resMsg='Successful!';
			}else $res='No Records Found!';
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function imei_mul_view(){  global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){$con='';
		if($_REQUEST['employee_id']!="")$con.="employee_id LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['employee_id'])."%' AND ";
		if($_REQUEST['name']!="")$con.="name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['name'])."%' AND ";
		if($_REQUEST['mobile_number']!="")$con.="mobile_number LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['mobile_number'])."%' AND ";
		if($_REQUEST['device']!="")$con.="device LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['device'])."%' AND ";
		if($_REQUEST['device_2']!="")$con.="device_2 LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['device_2'])."%' AND ";
		if($_REQUEST['role_alias']!="")$con.="role_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['role_alias'])."' AND ";
		$result['act_grant']=$act_grant = grantable('ACTIVATION','IMEI ACT DEACT',$emp_alias);
		$result['deact_grant']=$deact_grant = grantable('DEACTIVATION','IMEI ACT DEACT',$emp_alias);
		if($_REQUEST['action']!=""){
			if($_REQUEST['action']=='ACT' && $act_grant)$con.="device='0' AND device_2='0' AND ";
			elseif($_REQUEST['action']=='DEACT' && $deact_grant) $con.="(device<>'0' OR  device_2<>'0') AND ";
			else $con.="flag='2' AND ";
		}else{
			if($act_grant && $deact_grant)$con.="";
			elseif($act_grant)$con.="device='0' AND device_2='0' AND ";
			elseif($deact_grant)$con.="(device<>'0' OR  device_2<>'0') AND ";
			else $con.="flag='2' AND ";
		}
		$rec=mysqli_fetch_array(mysqli_query($mr_con,"SELECT COUNT(id) AS totalListing FROM ec_employee_master WHERE $con flag='0'"));
		if(!empty($rec['totalListing'])){
			$totalRecords = $rec['totalListing'];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sqlEmp = mysqli_query($mr_con,"SELECT employee_alias,employee_id,name,mobile_number,device,device_2,role_alias FROM ec_employee_master WHERE $con flag='0' ORDER BY device DESC LIMIT $offset, $limit");
			$result['empDetails']=array();
			if(mysqli_num_rows($sqlEmp)){
				$i=0;while($rowEmp = mysqli_fetch_array($sqlEmp)){
					$result['empDetails'][$i]['emp_alias']=$rowEmp['employee_alias'];
					$result['empDetails'][$i]['employee_id']=$rowEmp['employee_id'];
					$result['empDetails'][$i]['full_name']=$rowEmp['name'];
					$result['empDetails'][$i]['name']=((strlen($rowEmp['name']) > 17) ? substr($rowEmp['name'],0,17)."..." : $rowEmp['name']);
					$result['empDetails'][$i]['mobile_number']=$rowEmp['mobile_number'];
					$result['empDetails'][$i]['device']=(empty($rowEmp['device']) ? '-' : $rowEmp['device']);
					$result['empDetails'][$i]['device_2']=(empty($rowEmp['device_2']) ? '-' : $rowEmp['device_2']);
					$result['empDetails'][$i]['emp_role']=alias($rowEmp['role_alias'],'ec_emprole','role_alias','role_name');
					$i++;}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}$result['export']=grantable('EXPORT','IMEI ACT DEACT',$emp_alias);
	}elseif($rex==1){ $resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function imei_export(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){ $con='';
		if(isset($_REQUEST['zone_alias']) && count($_REQUEST['zone_alias'])>0){
			$zone = implode("|",$_REQUEST['zone_alias']);
			$zone_arr=$_REQUEST['zone_alias'];
			$con .= "t1.zone_alias RLIKE '$zone' AND ";
		}
		if(isset($_REQUEST['state_alias']) && count($_REQUEST['state_alias'])>0){
			$state = implode("|",$_REQUEST['state_alias']);
			$state_arr = $_REQUEST['state_alias'];
			$con .= "t1.state_alias RLIKE '$state' AND ";
		}
		if(isset($_REQUEST['role_alias']) && count($_REQUEST['role_alias'])>0){
			$role_alias = implode("','",$_REQUEST['role_alias']);
			$con .= "t1.role_alias IN ('$role_alias') AND ";
		}
		if(isset($_REQUEST['action']) && count($_REQUEST['action'])>0 && count($_REQUEST['action'])<2){
			if(in_array("DEACT",$_REQUEST['action']))$con .= "(t1.device<>'0' OR t1.device_2<>'0') AND ";
			else $con .= "t1.device='0' AND t1.device_2='0' AND ";
		}
		$sql = mysqli_query($mr_con,"SELECT t1.employee_id,t1.name,t1.mobile_number,t1.device,t1.device_2,t1.role_alias,t2.action,t2.remarks,t2.date_time FROM ec_employee_master t1 LEFT JOIN ec_imei_history t2 ON t1.employee_alias=t2.employee_alias WHERE $con t1.flag='0' ORDER BY t2.date_time DESC");
		if(mysqli_num_rows($sql)){
			$colArr=array('Employee ID','Employee Name','Mobile Number','Device 1','Device 2','Employee Role','Remarks','Action Time','IMEI History','IMEI Status');
			$colArr2=array('employee_id','name','mobile_number','device','device_2','role_alias','remarks','date_time','action');
			date_default_timezone_set("Asia/Kolkata");
			$filename = 'Device_IMEI_'.date('d-m-Y H_i_s');
			require('../Classes/PHPExcel.php');
			require('../Classes/PHPExcel/IOFactory.php');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
			$ch = 'A';
			foreach(array("H") as $da){$objPHPExcel->getActiveSheet()->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$objPHPExcel->getActiveSheet()->getColumnDimension($da)->setAutoSize(true);}
			foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
				$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
				$ch++;
			}$coo=1;
			while($row=mysqli_fetch_array($sql)){ $coo++;
				for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
					$value = $row[$colArr2[$af]];
					if($chr=='D' || $chr=='E')$objPHPExcel->getActiveSheet()->setCellValueExplicit($chr.$coo,$value,PHPExcel_Cell_DataType::TYPE_STRING);
					elseif($chr=='F')$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, alias($value,'ec_emprole','role_alias','role_name'));
					elseif($chr=='H')$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, php_excel_date($row['date_time']));
					else $objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $value);
				}$objPHPExcel->getActiveSheet()->SetCellValue("J".$coo, ($row['device']=='0' && $row['device_2']=='0' ? 'DEACTIVE' : 'ACTIVE'));
			}
			$objPHPExcel->getActiveSheet()->setTitle('Device IMEI');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save("../../exports/$filename.xlsx");
			$result['file_name']=$filename;
			$resCode='0'; $resMsg='export';
		}else {$resCode='4';$resMsg='No Records found to Run Report!';}
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
?>