<?php 
include('../mysql.php');
include('../functions.php');
require('../Slim/Slim.php');
require('../Classes/PHPExcel.php');
require('../Classes/PHPExcel/IOFactory.php');
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->post('/usertracking_single_view_map','usertracking_single_view_map');
$app->post('/usertracking_history','usertracking_history');
$app->post('/usertracking_single_view','usertracking_single_view');
$app->post('/usertracking_mul_view','usertracking_mul_view');
$app->post('/user_tracking_export','user_tracking_export');
$app->run();
function usertracking_single_view(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){
		$alias = mysqli_real_escape_string($mr_con,$_REQUEST['alias']);
		if(strtoupper($alias)=='ADMIN'){
			$result['name']='ADMIN';
			$result['employee_id']='ADMIN';
			$result['employee_alias']='ADMIN';
			$result['date_time']=last_login('admin');
		}else{
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_employee_master WHERE employee_alias='$alias'");
			if(mysqli_num_rows($sql)>0){
				while($row=mysqli_fetch_array($sql)){
					$result['name']=$row['name'];
					$result['employee_id']=$row['employee_id'];
					$result['employee_alias']=$row['employee_alias'];
					$result['date_time']=last_login($row['employee_alias']);
				}
				$resCode='0'; $resMsg='Successfull!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function usertracking_mul_view(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){ 
		$cond="";
		// $viewAll = grantable('VIEW ALL', 'TRACKING SYSTEM', $emp_alias);
		$admin = grantable('VIEW ALL', 'TRACKING SYSTEM', $emp_alias);
		if(isset($_REQUEST['employeeId']) && !empty($_REQUEST['employeeId'])){
			$employee_id = strtoupper(mysqli_real_escape_string($mr_con, $_REQUEST['employeeId']));
			$cond.="employee_id LIKE '%$employee_id%' AND ";
		}
		if(isset($_REQUEST['name']) && !empty($_REQUEST['name'])){$name=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['name']));$cond.="name LIKE '%$name%' AND ";}
		if(isset($_REQUEST['status']) && !empty($_REQUEST['status'])){$status=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['status']));$cond.="status='$status' AND ";}
		if(isset($_REQUEST['designation']) && !empty($_REQUEST['designation'])){$designation=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['designation']));$cond.="designation_alias IN (SELECT designation_alias FROM ec_designation WHERE designation LIKE '%$designation%' AND flag=0) AND ";}
		if(isset($_REQUEST['dateTime']) && !empty($_REQUEST['dateTime'])){
			$dateTime = dateFormat(mysqli_real_escape_string($mr_con,$_REQUEST['dateTime']),'y');
			$cond.="employee_alias IN (SELECT DISTINCT(employee_alias) FROM ec_user_history WHERE date_time LIKE '%$dateTime%' AND employee_alias NOT IN(SELECT DISTINCT(employee_alias) FROM ec_user_history WHERE date_time > '$dateTime 23:59:59' AND flag='0') AND flag=0) AND ";
			$admin_last_login = last_login('admin');
		} else {
			if($admin)
			$admin_last_login = last_login('admin');
		}
		// $admin = admin_privilege($emp_alias);
		$admin = grantable('VIEW ALL', 'TRACKING SYSTEM', $emp_alias);
		$admin_sort=(((strpos("ADMIN",$employee_id)!==false || strpos("ADMIN",$name)!==false || strpos("ADMINISTRATION",$designation)!==false || $status=="WORKING" || strpos($admin_last_login,$dateTime)!==false) || empty($cond)) && $admin ? TRUE : FALSE); 
		if(!$admin)$cond.="department_alias='".alias_flag_none($emp_alias,'ec_employee_master','employee_alias','department_alias')."' AND ";
		$rec=mysqli_query($mr_con,"SELECT COUNT(id) FROM ec_employee_master WHERE $cond flag IN('0','1')");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT status,employee_id,name,designation_alias,employee_alias FROM ec_employee_master WHERE $cond flag IN('0','1') LIMIT $offset, $limit");
			$result['usertrackingMulDetails']=array();
			if($admin_sort){  $i=1;
				$result['usertrackingMulDetails'][0]['employee_id']='ADMIN';
				$result['usertrackingMulDetails'][0]['name']='ADMIN';
				$result['usertrackingMulDetails'][0]['designation']='ADMINISTRATION';
				$result['usertrackingMulDetails'][0]['employee_alias']='ADMIN';
				$result['usertrackingMulDetails'][0]['status']='WORKING';
				$result['usertrackingMulDetails'][0]['date_time']=$admin_last_login;
			}else $i=0;
			if(mysqli_num_rows($sql)){
				while($row = mysqli_fetch_array($sql)){
					$result['usertrackingMulDetails'][$i]['employee_id']=$row['employee_id'];
					$result['usertrackingMulDetails'][$i]['name']=$row['name'];
					$result['usertrackingMulDetails'][$i]['designation']=alias($row['designation_alias'],'ec_designation','designation_alias','designation');
					$result['usertrackingMulDetails'][$i]['employee_alias']=$row['employee_alias'];
					$result['usertrackingMulDetails'][$i]['status']=$row['status'];
					$result['usertrackingMulDetails'][$i]['date_time']=last_login($row['employee_alias']);
					$i++;}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}$result['export']=grantable('EXPORT','TRACKING SYSTEM',$emp_alias);
	}elseif($rex==1){ $resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x;else $result['pages'][1]=1;
	echo json_encode($result);		
}

function usertracking_single_view_map(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['alias']);
	if(isset($_REQUEST['datemap']) && $_REQUEST['datemap']!=""){
		$datein=date_create($_REQUEST['datemap']);
		$datemap="date_time LIKE '%".date_format($datein,"Y-m-d")."%' AND";
	}
	$sql = mysqli_query($mr_con,"SELECT type,lat,lng,date_time FROM ec_user_tracking WHERE employee_alias='$emp_alias' AND $datemap lat<>'0' AND lng<>'0' AND flag=0 ORDER BY date_time DESC");
	if(mysqli_num_rows($sql)>0){ 
		$i=0;while($row = mysqli_fetch_array($sql)){
			$result[$i]['datetime']=$row['date_time'];
			$result[$i]['lat'] =$row['lat'];
			$result[$i]['long']=$row['lng'];
			$result[$i]['type']=user_track_type($row['type']);
			//$result[$i]['address']=getAddress($row['lat'], $row['lng']);
		$i++;}
	}
	echo json_encode($result);
}
function usertracking_history(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$alias = mysqli_real_escape_string($mr_con,$_REQUEST['alias']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$condtion="";
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM  ec_user_history WHERE $condtion employee_alias='$alias' AND flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT * FROM ec_user_history WHERE $condtion employee_alias='$alias' AND flag=0 ORDER BY date_time DESC LIMIT $offset, $limit");
			$result['usertrackingDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['usertrackingDetails'][$i]['action']=$row['action'];
					$result['usertrackingDetails'][$i]['employee_alias']=$row['employee_alias'];
					$result['usertrackingDetails'][$i]['date_time']=$row['date_time'];
					$result['usertrackingDetails'][$i]['remarks']=$row['remarks'];
				$i++;}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}
	}elseif($rex==1){
		$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	$result['pages']=array();
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x;else $result['pages'][1]=1;
	echo json_encode($result);
}
function last_login($employee_alias){ global $mr_con;
	$row = mysqli_fetch_array(mysqli_query($mr_con,"SELECT MAX(date_time) AS date_time FROM ec_user_history WHERE employee_alias='$employee_alias' AND flag=0"));
	return (!empty($row['date_time']) ? $row['date_time'] : 'NA');
}
function user_tracking_export(){ global $mr_con;
	set_time_limit(0);
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['alias']));
	$chk=authentication($emp_alias,$token);
	if($chk==0){ $no_rec=0;
		if(!empty($alias)){
			$admin = ($alias =='ADMIN' ? TRUE : FALSE);
			if($admin){
				$con="SELECT ip_address,action,date_time, remarks FROM ec_user_history WHERE employee_alias IN('admin','ADMIN') AND flag=0";
			} else {
				$con="SELECT t1.employee_id, t1.name, t2.ip_address, t2.action, t2.date_time, t2.remarks FROM ec_employee_master t1 JOIN ec_user_history t2 ON t1.employee_alias=t2.employee_alias WHERE t1.employee_alias='$alias' AND t2.flag=0";
			}
			$sql = mysqli_query($mr_con,"$con");
			if(mysqli_num_rows($sql)){
				$colArr=array('Employee ID','Employee Name','IP Address','Action','Action Details','Remarks');
				$colArr2=array('employee_id','name','ip_address','action','date_time','remarks');
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->setActiveSheetIndex(0);
				$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
				$ch = 'A';
				foreach($colArr as $colrefValue){
					$objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
					$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
					if($ch=='E'){$objPHPExcel->getActiveSheet()->getStyle($ch)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$objPHPExcel->getActiveSheet()->getColumnDimension($ch)->setAutoSize(true);}
					$ch++;
				}$coo=1;
				while($row=mysqli_fetch_array($sql)){ $coo++;
					if($admin){
						for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
							$value = ($chr=='A' || $chr=='B' ? "ADMIN" : $row[$colArr2[$af]]);
							$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, ($chr=='E' ? php_excel_date($value) : $value));
						}
					}else{
						for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
							$value = $row[$colArr2[$af]];
							$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, ($chr=='E' ? php_excel_date($value) : $value));
						}
					}//$objPHPExcel->getActiveSheet()->SetCellValue('C'.$coo, alias($row['designation_alias'],'ec_designation','designation_alias','designation'));	
				}
			}else $no_rec++;
		}else{
			$admin = admin_privilege($emp_alias);
			if(!$admin)$cond="WHERE department_alias='".alias_flag_none($emp_alias,'ec_employee_master','employee_alias','department_alias')."'";else $cond="";
			$sql = mysqli_query($mr_con,"SELECT employee_id,name,designation_alias,status,employee_alias FROM ec_employee_master $cond");
			if(mysqli_num_rows($sql)){
				$colArr=array('Employee ID','Employee Name','Working Status','Designation','Last Login Date');
				$colArr2=array('employee_id','name','status');
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->setActiveSheetIndex(0);
				$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
				$ch = 'A';
				foreach($colArr as $colrefValue){
					$objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',$colrefValue);
					$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
					if($ch=='E'){$objPHPExcel->getActiveSheet()->getStyle($ch)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$objPHPExcel->getActiveSheet()->getColumnDimension($ch)->setAutoSize(true);}
					$ch++;
				}$coo=2;
				if($admin){
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$coo, 'ADMIN');
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$coo, 'ADMIN');
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$coo, 'WORKING');
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$coo, 'ADMINISTRATION');
					$last_login_date = last_login("admin");
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$coo, ($last_login_date!='NA' ? php_excel_date($last_login_date) : '-'));
				}else $coo=1;
				while($row=mysqli_fetch_array($sql)){ $coo++;
					for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++)$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$coo, alias($row['designation_alias'],'ec_designation','designation_alias','designation'));
					$last_login_date = last_login($row['employee_alias']);
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$coo, ($last_login_date!='NA' ? php_excel_date($last_login_date) : '-'));
				}
			}else $no_rec++;
		}
		if($no_rec>'0'){
			$resCode='4';$resMsg='No Records to get report!';
		} else {
			$filename = 'Usertracking_'.date('d-m-Y_H_i_s');
			$objPHPExcel->getActiveSheet()->setTitle('User Tracking');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save("../../exports/$filename.xlsx");
			$result['file_name']=$filename;
			$resCode='0'; $resMsg='export';
		}
	} elseif($chk==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else { 
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
?>