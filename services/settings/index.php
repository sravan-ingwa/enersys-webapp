<?php 
date_default_timezone_set("Asia/Kolkata");
$maxCount = 10;
require '../Slim/Slim.php';
include('../mysql.php');
include('../functions.php');
include('../Classes/PHPExcel.php');
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->post('/zone_add','zone_add');
$app->post('/zone_update','zone_update');
$app->post('/zone_view','zone_view');
$app->post('/zone_mul_view','zone_mul_view');
$app->post('/zone_export','zone_export');
$app->post('/zone_check_delete_status','zone_check_delete_status');
$app->post('/zone_delete','zone_delete');

$app->post('/state_add','state_add');
$app->post('/state_update','state_update');
$app->post('/state_view','state_view');
$app->post('/state_mul_view','state_mul_view');
$app->post('/state_export','state_export');
$app->post('/state_check_delete_status','state_check_delete_status');
$app->post('/state_delete','state_delete');

$app->post('/district_add','district_add');
$app->post('/district_update','district_update');
$app->post('/district_view','district_view');
$app->post('/district_mul_view','district_mul_view');
$app->post('/district_export','district_export');
$app->post('/district_check_delete_status','district_check_delete_status');
$app->post('/district_delete','district_delete');

$app->post('/designation_add','designation_add');
$app->post('/designation_update','designation_update');
$app->post('/designation_view','designation_view');
$app->post('/designation_mul_view','designation_mul_view');
$app->post('/designation_export','designation_export');
$app->post('/designation_check_delete_status','designation_check_delete_status');
$app->post('/designation_delete','designation_delete');

$app->post('/department_add','department_add');
$app->post('/department_update','department_update');
$app->post('/department_view','department_view');
$app->post('/department_mul_view','department_mul_view');
$app->post('/department_export','department_export');
$app->post('/department_check_delete_status','department_check_delete_status');
$app->post('/department_delete','department_delete');

$app->post('/employee_role_add','employee_role_add');
$app->post('/employee_role_update','employee_role_update');
$app->post('/employee_role_view','employee_role_view');
$app->post('/employee_role_mul_view','employee_role_mul_view');
$app->post('/employee_role_export','employee_role_export');
$app->post('/employee_role_check_delete_status','employee_role_check_delete_status');
$app->post('/employee_role_delete','employee_role_delete');

$app->post('/warehouse_add','warehouse_add');
$app->post('/warehouse_update','warehouse_update');
$app->post('/warehouse_view','warehouse_view');
$app->post('/warehouse_mul_view','warehouse_mul_view');
$app->post('/warehouse_export','warehouse_export');
$app->post('/warehouse_check_delete_status','warehouse_check_delete_status');
$app->post('/warehouse_delete','warehouse_delete');

$app->post('/stockcode_add','stock_code_add');
$app->post('/stockcode_update','stock_code_update');
$app->post('/stockcode_view','stock_code_view');
$app->post('/stockcode_mul_view','stock_code_mul_view');
$app->post('/stockcode_export','stockcode_export');

$app->post('/segment_add','segment_add');
$app->post('/segment_update','segment_update');
$app->post('/segment_view','segment_view');
$app->post('/segment_mul_view','segment_mul_view');
$app->post('/segment_export','segment_export');

$app->post('/customer_add','customer_add');
$app->post('/customer_update','customer_update');
$app->post('/customer_view','customer_view');
$app->post('/customer_mul_view','customer_mul_view');
$app->post('/customer_export','customer_export');
$app->post('/customer_check_delete_status','customer_check_delete_status');
$app->post('/customer_delete','customer_delete');

$app->post('/product_add','product_add');
$app->post('/product_update','product_update');
$app->post('/product_view','product_view');
$app->post('/product_export','product_export');
$app->post('/product_mul_view','product_mul_view');
$app->post('/product_check_delete_status','product_check_delete_status');
$app->post('/product_delete','product_delete');

$app->post('/ticketcomplaint_add','ticketcomplaint_add');
$app->post('/ticketcomplaint_update','ticket_complaint_update');
$app->post('/ticketcomplaint_view','ticket_complaint_view');
$app->post('/ticketcomplaint_mul_view','ticket_complaint_mul_view');
$app->post('/ticket_complaint_export','ticket_complaint_export');
$app->post('/ticket_complaint_check_delete_status','ticket_complaint_check_delete_status');
$app->post('/ticket_complaint_delete','ticket_complaint_delete');

$app->post('/faultycode_add','faulty_code_add');
$app->post('/faultycode_update','faulty_code_update');
$app->post('/faultycode_view','faulty_code_view');
$app->post('/faultycode_mul_view','faulty_code_mul_view');
$app->post('/faulty_code_export','faulty_code_export');
$app->post('/faultycode_check_delete_status','faultycode_check_delete_status');
$app->post('/faultycode_delete','faultycode_delete');

$app->post('/ticketactivity_add','ticket_activity_add');
$app->post('/ticketactivity_update','ticket_activity_update');
$app->post('/ticketactivity_view','ticket_activity_view');
$app->post('/ticketactivity_mul_view','ticket_activity_mul_view');
$app->post('/ticket_activity_export','ticket_activity_export');

//$app->post('/levels_add','levels_add');
$app->post('/levels_update','levels_update');
$app->post('/levels_view','levels_view');
$app->post('/levels_mul_view','levels_mul_view');
$app->post('/level_export','level_export');

$app->post('/assets_add','assets_add');
$app->post('/assets_update','assets_update');
$app->post('/assets_view','assets_view');
$app->post('/assets_mul_view','assets_mul_view');
$app->post('/assets_export','assets_export');
$app->post('/assets_check_delete_status','assets_check_delete_status');
$app->post('/assets_delete','assets_delete');

$app->post('/item_code_add','item_code_add');
$app->post('/item_code_update','item_code_update');
$app->post('/item_code_view','item_code_view');
$app->post('/item_code_mul_view','item_code_mul_view');
$app->post('/item_code_export','item_code_export');

$app->post('/privileges_init','privileges_init');
$app->post('/privileges_add','privileges_add');
$app->post('/privileges_update','privileges_update');
$app->post('/privileges_view','privileges_view');
$app->post('/privileges_mul_view','privileges_mul_view');
$app->post('/privileges_export','privileges_export');
$app->post('/privileges_check_delete_status','privileges_check_delete_status');
$app->post('/privileges_delete','privileges_delete');

$app->post('/sitetype_add','sitetype_add');
$app->post('/sitetype_view','sitetype_view');
$app->post('/sitetype_mul_view','sitetype_mul_view');
$app->post('/sitetype_export','sitetype_export');
$app->post('/sitetype_update','sitetype_update');
$app->post('/sitetype_check_delete_status','sitetype_check_delete_status');
$app->post('/sitetype_delete','sitetype_delete');

$app->post('/sitestatus_add','sitestatus_add');
$app->post('/sitestatus_view','sitestatus_view');
$app->post('/sitestatus_mul_view','sitestatus_mul_view');
$app->post('/sitestatus_update','sitestatus_update');
$app->post('/sitestatus_export','sitestatus_export');

$app->post('/accessories_add','accessories_add');
$app->post('/accessories_view','accessories_view');
$app->post('/accessories_mul_view','accessories_mul_view');
$app->post('/accessories_update','accessories_update');
$app->post('/accessories_export','accessories_export');
$app->post('/accessories_check_delete_status','accessories_check_delete_status');
$app->post('/accessories_delete','accessories_delete');

$app->post('/milestone_add','milestone_add');
$app->post('/milestone_update','milestone_update');
$app->post('/milestone_view','milestone_view');
$app->post('/milestone_mul_view','milestone_mul_view');
$app->post('/milestone_export','milestone_export');
$app->post('/milestone_check_delete_status','milestone_check_delete_status');
$app->post('/milestone_delete','milestone_delete');

$app->post('/esca_add','esca_add');
$app->post('/esca_update','esca_update');
$app->post('/esca_view','esca_view');
$app->post('/esca_mul_view','esca_mul_view');
$app->post('/esca_export','esca_export');
$app->post('/esca_check_delete_status','esca_check_delete_status');
$app->post('/esca_delete','esca_delete');

$app->post('/dpr_add','dpr_add');
$app->post('/dpr_update','dpr_update');
$app->post('/dpr_view','dpr_view');
$app->post('/dpr_mul_view','dpr_mul_view');
$app->post('/dpr_export','dpr_export');
$app->post('/dpr_check_delete_status','dpr_check_delete_status');
$app->post('/dpr_delete','dpr_delete');

$app->post('/shift_add','shift_add');
$app->post('/shift_update','shift_update');
$app->post('/shift_view','shift_view');
$app->post('/shift_mul_view','shift_mul_view');
$app->post('/shift_export','shift_export');
$app->post('/shift_check_delete_status','shift_check_delete_status');
$app->post('/shift_delete','shift_delete');

$app->post('/moc_add','moc_add');
$app->post('/moc_update','moc_update');
$app->post('/moc_view','moc_view');
$app->post('/moc_mul_view','moc_mul_view');
$app->post('/moc_export','moc_export');
$app->post('/moc_check_delete_status','moc_check_delete_status');
$app->post('/moc_delete','moc_delete');

$app->post('/dynamic_level_add','dynamic_level_add');
$app->post('/dynamic_level_update','dynamic_level_update');
$app->post('/dynamic_level_view','dynamic_level_view');
$app->post('/dynamic_level_mul_view','dynamic_level_mul_view');
$app->post('/dynamic_level_export','dynamic_level_export');
$app->post('/dynamic_level_check_delete_status','dynamic_level_check_delete_status');
$app->post('/dynamic_level_delete','dynamic_level_delete');

//$app->post('/bucket_add','bucket_add');
$app->post('/bucket_update','bucket_update');
$app->post('/bucket_view','bucket_view');
$app->post('/bucket_mul_view','bucket_mul_view');
$app->post('/bucket_export','bucket_export');

//MobileApp
$app->post('/tree_add_update_disable','tree_add_update_disable');
$app->post('/tree_view','tree_view');
$app->post('/tree_export','tree_export');

$app->post('/manuals_update','manuals_update');
$app->post('/manuals_mul_view','manuals_mul_view');
$app->post('/manuals_view','manuals_view');
$app->post('/manuals_export','manuals_export');

$app->post('/workguide_add','workguide_add');
$app->post('/workguide_update','workguide_update');
$app->post('/workguide_mul_view','workguide_mul_view');
$app->post('/workguide_view','workguide_view');
$app->post('/workguide_export','workguide_export');
$app->post('/workguide_check_delete_status','workguide_check_delete_status');
$app->post('/workguide_delete','workguide_delete');

$app->post('/changelog_add','changelog_add');
$app->post('/changelog_update','changelog_update');
$app->post('/changelog_view','changelog_view');
$app->post('/changelog_mul_view','changelog_mul_view');
$app->post('/changelog_export','changelog_export');
$app->post('/changelog_check_delete_status','changelog_check_delete_status');
$app->post('/changelog_delete','changelog_delete');

$app->post('/privacy_policy_update','privacy_policy_update');
$app->post('/privacy_policy_view','privacy_policy_view');

$app->post('/email_sms_recipient_mul_view','email_sms_recipient_mul_view');
$app->post('/email_sms_recipient_view','email_sms_recipient_view');
$app->post('/email_sms_recipient_update','email_sms_recipient_update');
$app->post('/email_sms_recipient_delete','email_sms_recipient_delete');
$app->post('/email_sms_recipient_export','email_sms_recipient_export');

$app->run();

function bucket_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$bucket_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['bucket_alias']));
		$bucket = (isset($_REQUEST['bucket']) ? mysqli_real_escape_string($mr_con,trim($_REQUEST['bucket'])) : '');
		if(empty($bucket)){$res="Please Enter Bucket";}
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_remarks_bucket WHERE bucket='$bucket' AND bucket_alias<>'$bucket_alias' AND flag=0");
			if(mysqli_num_rows($q)==0){
				$sql = mysqli_query($mr_con,"UPDATE ec_remarks_bucket SET bucket='$bucket' WHERE bucket_alias='$bucket_alias' AND flag=0");
				if($sql){
					$action="Bucket $bucket Updated";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$resCode='0';$resMsg='Successful!';
				}else{$resCode='4';$resMsg='Error in Updating!';}
			}else{$res = 'The Requested Bucket has already exist, Try with other Bucket';}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function bucket_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$bucket_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
		$sql=mysqli_query($mr_con,"SELECT * FROM ec_remarks_bucket WHERE bucket_alias='$bucket_alias' AND flag=0");
		if(mysqli_num_rows($sql)>0){
			$row=mysqli_fetch_array($sql);
			$result['bucket_alias']=$row['bucket_alias'];
			$result['bucket']=$row['bucket'];
			$result['bucket_desc']=$row['bucket_desc'];
			$resCode='0'; $resMsg='Successful!';
		}else{$resCode='4';$resMsg='No Records Found!';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function bucket_mul_view(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){$con="";
		$con.=($_REQUEST['bucket']=="" ? "" : "bucket LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['bucket'])."%' AND ");
		$con.=($_REQUEST['bucket_desc']=="" ? "" : "bucket_desc LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['bucket_desc'])."%' AND ");
		$rec=mysqli_query($mr_con,"SELECT COUNT(id) FROM ec_remarks_bucket WHERE $con flag='0'");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT * FROM ec_remarks_bucket WHERE $con flag=0 ORDER BY bucket_level LIMIT $offset, $limit");
			$result['bucketDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['bucketDetails'][$i]['bucket_alias']=$row['bucket_alias'];
					$result['bucketDetails'][$i]['bucket']=$row['bucket'];
					$result['bucketDetails'][$i]['bucket_desc']=$row['bucket_desc']; 
				$i++;}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}
	}elseif($rex==1){ $resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	$result['add'] = false;
	$result['edit'] = grantable('EDIT', 'BUCKETS', $emp_alias);
	$result['delete'] = false;
	$result['view'] = grantable('VIEW', 'BUCKETS', $emp_alias);
	$result['export'] = grantable('EXPORT', 'BUCKETS', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function bucket_export(){ 
	global $mr_con;
	$chk = authentication($_REQUEST['emp_alias'], $_REQUEST['token']);
	if($chk==0) {
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_remarks_bucket WHERE flag=0");
		$colArr=array('Bucket', 'Bucket Description');
		$colArr2=array('bucket', 'bucket_desc');
		$filename = 'Bucket_'.date('d-m-Y H_i_s');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
		$ch = 'A';
		foreach($colArr as $colrefValue){ 
			$objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$ch++;
		}
		$coo=1;
		while($row=mysqli_fetch_array($sql)){ 
			$coo++;
			for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
				$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
			}
		}
		$objPHPExcel->getActiveSheet()->setTitle('Buckets');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save("../../exports/$filename.xlsx");
		$result['file_name']=$filename;
		$resCode='0'; $resMsg='export';
	} elseif($chk==1) { 
		$resCode='1';$resMsg='Authentication Failed!';
	} else { 
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;	
	echo json_encode($result);
}
function dynamic_level_add(){ 
	global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$privilege_alias = (isset($_REQUEST['privilege_alias']) ? mysqli_real_escape_string($mr_con,trim($_REQUEST['privilege_alias'])) : '');
		$level_name = (isset($_REQUEST['level_name']) ? mysqli_real_escape_string($mr_con,trim($_REQUEST['level_name'])) : '');
		$level_color = (isset($_REQUEST['level_color']) ? mysqli_real_escape_string($mr_con,trim($_REQUEST['level_color'])) : '');
		$grantable = (isset($_REQUEST['grantable']) ? mysqli_real_escape_string($mr_con,trim($_REQUEST['grantable'])) : '');
		$order_by = (isset($_REQUEST['order_by']) ? mysqli_real_escape_string($mr_con,trim($_REQUEST['order_by'])) : '');
		if(empty($privilege_alias))$res= "Please Select Privilege";
		elseif(empty($level_name))$res= "Please Enter Level Name";
		elseif(empty($level_color))$res= "Please Choose Level Color";
		elseif($grantable=='')$res= "Please Select Grantable";
		elseif(empty($order_by))$res= "Please Select Order";
		else{ $check=TRUE;
			if($privilege_alias=='Z4L1MEACZEUN18EBVDLV' || $privilege_alias=='MLPWZV23MRL9DZXRQVQG'){
				$eq=mysqli_query($mr_con,"SELECT order_by FROM ec_dynamic_levels WHERE privilege_alias IN('Z4L1MEACZEUN18EBVDLV','MLPWZV23MRL9DZXRQVQG') AND flag='0'");
				if(mysqli_num_rows($eq)=='1'){
					$erow=mysqli_fetch_array($eq);
					$order_by=$erow['order_by'];
					$check=FALSE;
				}
			}
			if($check){
				$ext_dynamic_alias = alias($order_by,'ec_dynamic_levels','order_by','dynamic_alias');
				if(!empty($ext_dynamic_alias)){
					$q=mysqli_query($mr_con,"SELECT MAX(order_by) as max_ordr FROM ec_dynamic_levels WHERE flag=0");
					$row=mysqli_fetch_array($q);
					$sql1=mysqli_query($mr_con,"UPDATE ec_dynamic_levels SET order_by='".($row['max_ordr']+1)."' WHERE dynamic_alias='$ext_dynamic_alias' AND flag='0'");
				}
			}
			$dynamic_alias = aliasCheck(generateRandomString(),'ec_dynamic_levels','dynamic_alias');
			$sql=mysqli_query($mr_con,"INSERT INTO ec_dynamic_levels(privilege_alias,level_name,level_color,grantable,order_by,dynamic_alias)VALUES('$privilege_alias','$level_name','$level_color','$grantable','$order_by','$dynamic_alias')");
			if($sql){
				$action="Dynamic Level ".alias($privilege_alias,'ec_privileges','privilege_alias','privilege_name')." Created";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';
			}else{$resCode='4';$resMsg='Error in Creating!';}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function dynamic_level_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$dynamic_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['dynamic_alias']));
		//$privilege_alias = (isset($_REQUEST['privilege_alias']) ? mysqli_real_escape_string($mr_con,trim($_REQUEST['privilege_alias'])) : '');
		$level_name = (isset($_REQUEST['level_name']) ? mysqli_real_escape_string($mr_con,trim($_REQUEST['level_name'])) : '');
		$level_color = (isset($_REQUEST['level_color']) ? mysqli_real_escape_string($mr_con,trim($_REQUEST['level_color'])) : '');
		$grantable = (isset($_REQUEST['grantable']) ? mysqli_real_escape_string($mr_con,trim($_REQUEST['grantable'])) : '');
		$order_by = (isset($_REQUEST['order_by']) ? mysqli_real_escape_string($mr_con,trim($_REQUEST['order_by'])) : '');
		//if(empty($privilege_alias)){$res="Please Enter Privilege";}
		if(empty($level_name))$res= "Please Enter Level Name";
		elseif(empty($level_color))$res= "Please Choose Level Color";
		elseif($grantable=='')$res= "Please Select Grantable";
		elseif(empty($order_by))$res= "Please Select Order";
		else{
			$privilege_alias=alias($dynamic_alias,'ec_dynamic_levels','dynamic_alias','privilege_alias');
			$other_privilege_alias=alias($order_by,'ec_dynamic_levels','order_by','privilege_alias');
			$other_dynamic_alias=alias($order_by,'ec_dynamic_levels','order_by','dynamic_alias'); //Old Dynamic
			if($privilege_alias=='Z4L1MEACZEUN18EBVDLV' || $privilege_alias=='MLPWZV23MRL9DZXRQVQG' || $other_privilege_alias=='Z4L1MEACZEUN18EBVDLV' || $other_privilege_alias=='MLPWZV23MRL9DZXRQVQG'){ //Update FOA OR TOA
				$exorder_by=alias($dynamic_alias,'ec_dynamic_levels','dynamic_alias','order_by'); //Old Order
				if($privilege_alias=='Z4L1MEACZEUN18EBVDLV' || $privilege_alias=='MLPWZV23MRL9DZXRQVQG'){ // Change FOA OR TOA
					$sql2=mysqli_query($mr_con,"UPDATE ec_dynamic_levels SET order_by='$order_by' WHERE privilege_alias IN ('Z4L1MEACZEUN18EBVDLV','MLPWZV23MRL9DZXRQVQG') AND flag='0'");
					$sql = mysqli_query($mr_con,"UPDATE ec_dynamic_levels SET grantable='$grantable',level_name='$level_name',level_color='$level_color' WHERE dynamic_alias = '$dynamic_alias' AND flag='0'");
					$sql3=mysqli_query($mr_con,"UPDATE ec_dynamic_levels SET order_by='$exorder_by' WHERE dynamic_alias='$other_dynamic_alias' AND flag='0'");
				}
				if($other_privilege_alias=='Z4L1MEACZEUN18EBVDLV' || $other_privilege_alias=='MLPWZV23MRL9DZXRQVQG'){ // NOT FOA OR TOA
					$sql2=mysqli_query($mr_con,"UPDATE ec_dynamic_levels SET order_by='$exorder_by' WHERE privilege_alias IN ('Z4L1MEACZEUN18EBVDLV','MLPWZV23MRL9DZXRQVQG') AND flag='0'");
					$sql = mysqli_query($mr_con,"UPDATE ec_dynamic_levels SET grantable='$grantable',level_name='$level_name',level_color='$level_color',order_by='$order_by' WHERE dynamic_alias = '$dynamic_alias' AND flag='0'");
				}
			}else $sql = mysqli_query($mr_con,"UPDATE ec_dynamic_levels AS a JOIN ec_dynamic_levels AS b ON ( a.dynamic_alias = '$dynamic_alias' AND b.dynamic_alias = '$other_dynamic_alias' ) SET a.grantable='$grantable',a.level_name='$level_name',a.level_color='$level_color', a.order_by = b.order_by, b.order_by = a.order_by");
			if($sql){
				$dism=mysqli_query($mr_con,"SELECT mrf_alias,status FROM ec_material_request WHERE status IN('1','2') AND flag=0");
				if(mysqli_num_rows($dism)){ $disr=mysqli_fetch_array($dism);
					if(($disr['status']=='1' || $disr['status']=='7') && empty(next_dynamic($disr['mrf_alias'],'E')))$disu=mysqli_query($mr_con,"UPDATE ec_material_request SET status='2' WHERE mrf_alias='".$disr['mrf_alias']."' AND flag=0");
					//if($disr['status']=='2' && !empty(next_dynamic($disr['mrf_alias'],'E')))$disu=mysqli_query($mr_con,"UPDATE ec_material_request SET status='1' WHERE mrf_alias='".$disr['mrf_alias']."' AND flag=0");
				}
				$action="Dynamic Level ".alias($privilege_alias,'ec_privileges','privilege_alias','privilege_name')." Updated";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';
			}else{$resCode='4';$resMsg='Error in Updating!';}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function dynamic_level_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$dynamic_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
		$sql=mysqli_query($mr_con,"SELECT * FROM ec_dynamic_levels WHERE dynamic_alias='$dynamic_alias' AND flag=0");
		if(mysqli_num_rows($sql)>0){
			$row=mysqli_fetch_array($sql);
			$result['dynamic_alias']=$row['dynamic_alias'];
			$result['privilege_alias']=$row['privilege_alias'];
			$result['level_name']=$row['level_name'];
			$result['level_color']=$row['level_color'];
			$result['privilege_name']=alias($row['privilege_alias'],'ec_privileges','privilege_alias','privilege_name');
			$result['grantable']=$row['grantable'];
			$result['order_by']=$row['order_by'];
			$resCode='0'; $resMsg='Successful!';
		}else{$resCode='4';$resMsg='No Records Found!';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function dynamic_level_mul_view(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){$con="";
		$con.=(empty($_REQUEST['privilege_alias']) ? "" : "privilege_alias='".mysqli_real_escape_string($mr_con,$_REQUEST['privilege_alias'])."' AND ");
		$con.=($_REQUEST['level_name']=="" ? "" : "level_name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['level_name'])."%' AND ");
		$con.=($_REQUEST['level_color']=="" ? "" : "level_color LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['level_color'])."%' AND ");
		$con.=($_REQUEST['grantable']=="" ? "" : "grantable='".mysqli_real_escape_string($mr_con,$_REQUEST['grantable'])."' AND ");
		$con.=($_REQUEST['order_by']=="" ? "" : "order_by='".mysqli_real_escape_string($mr_con,$_REQUEST['order_by'])."' AND ");
		$con.="privilege_alias IN(SELECT privilege_alias FROM ec_privileges WHERE privilege_item='MATERIAL REQUEST' AND privilege_type='SPECIAL' AND grantable='1' AND flag='0' GROUP BY privilege_alias) AND ";
		$rec=mysqli_query($mr_con,"SELECT COUNT(id) FROM ec_dynamic_levels WHERE $con flag='0'");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT * FROM ec_dynamic_levels WHERE $con flag=0 ORDER BY order_by LIMIT $offset, $limit");
			$result['dynamic_level']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['dynamic_level'][$i]['dynamic_alias']=$row['dynamic_alias'];
					$result['dynamic_level'][$i]['privilege_name']=alias($row['privilege_alias'],'ec_privileges','privilege_alias','privilege_name');
					$result['dynamic_level'][$i]['privilege_alias']=$row['privilege_alias']; 
					$result['dynamic_level'][$i]['level_name']=$row['level_name']; 
					$result['dynamic_level'][$i]['level_color']=$row['level_color']; 
					$result['dynamic_level'][$i]['grantable']=$row['grantable']; 
					$result['dynamic_level'][$i]['order_by']=$row['order_by'];
				$i++;}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}
	}elseif($rex==1){ $resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	$result['add'] = grantable('ADD', 'DYNAMIC LEVELS', $emp_alias);
	$result['edit'] = grantable('EDIT', 'DYNAMIC LEVELS', $emp_alias);
	$result['delete'] = grantable('DELETE', 'DYNAMIC LEVELS', $emp_alias);
	$result['view'] = grantable('VIEW', 'DYNAMIC LEVELS', $emp_alias);
	$result['export'] = grantable('EXPORT', 'DYNAMIC LEVELS', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function dynamic_level_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_dynamic_levels WHERE flag=0");
		$colArr=array('Privilege','Grantable','Order');
		//$colArr2=array('privilege_alias','grantable','order_by');
		$filename = 'Dynamic_level_'.date('d-m-Y H_i_s');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
		$ch = 'A';
		foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$ch++;
		}
		$coo=1;
		while($row=mysqli_fetch_array($sql)){ $coo++;
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$coo, alias($row['privilege_alias'],'ec_privileges','privilege_alias','privilege_name'))
					->SetCellValue('B'.$coo, ($row['grantable']=='1' ? 'Yes' : 'No'))
					->SetCellValue('C'.$coo, $row['order_by']);
		}
		$objPHPExcel->getActiveSheet()->setTitle('Dynamic Levels');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save("../../exports/$filename.xlsx");
		$result['file_name']=$filename;
		$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function moc_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$moc_alias = aliasCheck(generateRandomString(),'ec_moc','moc_alias');
		$moc_name = (isset($_REQUEST['moc_name']) ? mysqli_real_escape_string($mr_con,trim($_REQUEST['moc_name'])) : '');
		$moc_file = (isset($_REQUEST['moc_file']) ? mysqli_real_escape_string($mr_con,trim($_REQUEST['moc_file'])) : '0');
		$moc_text = (isset($_REQUEST['moc_text']) ? mysqli_real_escape_string($mr_con,trim($_REQUEST['moc_text'])) : '0');
		if(empty($moc_name)){$res= "Please Enter MOC";}
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_moc WHERE moc_name='$moc_name' AND flag=0");
			if(mysqli_num_rows($q)==0){
				$sql=mysqli_query($mr_con,"INSERT INTO ec_moc(moc_name,moc_file,moc_text,moc_alias)VALUES('$moc_name','$moc_file','$moc_text','$moc_alias')");
				if($sql){
					$action="MOC $moc_name Created";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					update_fields('site_details_status');
					$resCode='0';$resMsg='Successful!';
				}else{$resCode='4';$resMsg='Error in Creating!';}
			}else{$res = 'The Requested MOC has already exist, Try with other values';}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function moc_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$moc_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['moc_alias']));
		$moc_name = (isset($_REQUEST['moc_name']) ? mysqli_real_escape_string($mr_con,trim($_REQUEST['moc_name'])) : '');
		$moc_file = (isset($_REQUEST['moc_file']) ? mysqli_real_escape_string($mr_con,trim($_REQUEST['moc_file'])) : '0');
		$moc_text = (isset($_REQUEST['moc_text']) ? mysqli_real_escape_string($mr_con,trim($_REQUEST['moc_text'])) : '0');
		if(empty($moc_name)){$res="Please Enter MOC";}
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_moc WHERE moc_name='$moc_name' AND moc_alias<>'$moc_alias' AND flag=0");
			if(mysqli_num_rows($q)==0){
				$sql=mysqli_query($mr_con,"UPDATE ec_moc SET moc_name='$moc_name',moc_file='$moc_file',moc_text='$moc_text' WHERE moc_alias='$moc_alias' AND flag=0");
				if($sql){
					$action="MOC $moc_name Updated";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					update_fields('site_details_status');
					$resCode='0';$resMsg='Successful!';
				}else{$resCode='4';$resMsg='Error in Updating!';}
			}else{$res = 'The Requested MOC has already exist, Try with other values';}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function moc_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$moc_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
		$sql=mysqli_query($mr_con,"SELECT * FROM ec_moc WHERE moc_alias='$moc_alias' AND flag=0");
		if(mysqli_num_rows($sql)>0){
			$row=mysqli_fetch_array($sql);
			$result['moc_name']=$row['moc_name'];
			$result['moc_alias']=$row['moc_alias'];
			$result['moc_file']=$row['moc_file'];
			$result['moc_text']=$row['moc_text'];
			$resCode='0'; $resMsg='Successful!';
		}else{$resCode='4';$resMsg='No Records Found!';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function moc_mul_view(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){$con="";
		$con.=(empty($_REQUEST['moc_alias']) ? "" : "moc_alias='".mysqli_real_escape_string($mr_con,$_REQUEST['moc_alias'])."' AND ");
		$con.=($_REQUEST['moc_file']=="" ? "" : "moc_file='".mysqli_real_escape_string($mr_con,$_REQUEST['moc_file'])."' AND ");
		$con.=($_REQUEST['moc_text']=="" ? "" : "moc_text='".mysqli_real_escape_string($mr_con,$_REQUEST['moc_text'])."' AND ");
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_moc WHERE $con flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT * FROM ec_moc WHERE $con flag=0 LIMIT $offset, $limit");
			$result['moc_details']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['moc_details'][$i]['moc_alias']=$row['moc_alias']; 
					$result['moc_details'][$i]['moc_name']=$row['moc_name']; 
					$result['moc_details'][$i]['moc_file']=$row['moc_file']; 
					$result['moc_details'][$i]['moc_text']=$row['moc_text'];
				$i++;}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}
	}elseif($rex==1){ $resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	$result['add'] = grantable('ADD', 'MOC', $emp_alias);
	$result['edit'] = grantable('EDIT', 'MOC', $emp_alias);
	$result['delete'] = grantable('DELETE', 'MOC', $emp_alias);
	$result['view'] = grantable('VIEW', 'MOC', $emp_alias);
	$result['export'] = grantable('EXPORT', 'MOC', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function moc_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_moc WHERE flag=0");
		$colArr=array('MOC Name','MOC File','MOC Text');
		$colArr2=array('moc_name','moc_file','moc_text');
		$filename = 'MOC_'.date('d-m-Y H_i_s');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
		$ch = 'A';
		foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
		$ch++;
		}
		$coo=1;
		while($row=mysqli_fetch_array($sql)){ $coo++;
			for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
				$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, ($chr=='A' ? $row[$colArr2[$af]] : ($row[$colArr2[$af]]=='0' ? 'DISABLED' : 'ENABLED')));
			}
		}
		$objPHPExcel->getActiveSheet()->setTitle('MOC');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save("../../exports/$filename.xlsx");
		$result['file_name']=$filename;
		$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function shift_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$shift_alias = aliasCheck(generateRandomString(),'ec_shift','shift_alias');
		$shift_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['shift_name'])));
		if(empty($shift_name)){$res= "Please Enter Shift";}
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_shift WHERE shift_name='$shift_name' AND flag=0");
			if(mysqli_num_rows($q)==0){
				$sql=mysqli_query($mr_con,"INSERT INTO ec_shift(shift_name,shift_alias)VALUES('$shift_name','$shift_alias')");
				if($sql){
					$action="Shift $shift_name Created";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$resCode='0';$resMsg='Successful!';
				}else{$resCode='4';$resMsg='Error in Creating!';}
			}else{$res = 'The Requested Shift has already exist, Try with other values';}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function shift_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$shift_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['shift_alias']));
		$shift_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['shift_name'])));
		if(empty($shift_name)){$res="Please Enter Shift";}
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_shift WHERE shift_name='$shift_name' AND shift_alias<>'$shift_alias' AND flag=0");
			if(mysqli_num_rows($q)==0){
				$sql=mysqli_query($mr_con,"UPDATE ec_shift SET shift_name='$shift_name' WHERE shift_alias='$shift_alias' AND flag=0");
				if($sql){
					$action="Shift $shift_name Updated";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$resCode='0';$resMsg='Successful!';
				}else{$resCode='4';$resMsg='Error in Updating!';}
			}else{$res = 'The Requested Shift has already exist, Try with other values';}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function shift_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$shift_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
		$sql=mysqli_query($mr_con,"SELECT shift_name,shift_alias FROM ec_shift WHERE shift_alias='$shift_alias' AND flag=0");
		if(mysqli_num_rows($sql)>0){
			$row=mysqli_fetch_array($sql);
			$result['shift_name']=$row['shift_name'];
			$result['shift_alias']=$row['shift_alias'];
			$resCode='0'; $resMsg='Successful!';
		}else{$resCode='4';$resMsg='No Records Found!';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function shift_mul_view(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$con=(empty($_REQUEST['shift_alias']) ? "" : "shift_alias='".mysqli_real_escape_string($mr_con,$_REQUEST['shift_alias'])."' AND");
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_shift WHERE $con flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT shift_alias,shift_name FROM ec_shift WHERE $con flag=0 LIMIT $offset, $limit");
			$result['shift_details']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['shift_details'][$i]['shift_alias']=$row['shift_alias']; 
					$result['shift_details'][$i]['shift_name']=$row['shift_name']; 
				$i++;}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}
	}elseif($rex==1){ $resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	$result['add'] = grantable('ADD', 'SHIFTS', $emp_alias);
	$result['edit'] = grantable('EDIT', 'SHIFTS', $emp_alias);
	$result['delete'] = grantable('DELETE', 'SHIFTS', $emp_alias);
	$result['view'] = grantable('VIEW', 'SHIFTS', $emp_alias);
	$result['export'] = grantable('EXPORT', 'SHIFTS', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function shift_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_shift WHERE flag=0");
		$colArr=array('Shift Name');
		$colArr2=array('shift_name');
		$filename = 'Shifts_'.date('d-m-Y H_i_s');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
		$ch = 'A';
		foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
		$ch++;
		}
		$coo=1;
		while($row=mysqli_fetch_array($sql)){ $coo++;
			for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
				$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
			}
		}
		$objPHPExcel->getActiveSheet()->setTitle('Shift');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save("../../exports/$filename.xlsx");
		$result['file_name']=$filename;
		$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function zone_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$alias = aliasCheck(generateRandomString(),'ec_zone','zone_alias');
		$zone_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['zone_name'])));
		if(empty($zone_name)){$res= "Please Enter Zone Name";}
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_zone WHERE zone_name='$zone_name' AND flag=0");
			if(mysqli_num_rows($q)==0){
				$sql=mysqli_query($mr_con,"INSERT INTO ec_zone(zone_name,zone_alias,created_date)VALUES('$zone_name','$alias','".date('Y-m-d')."')");
				if($sql){
					$action=$zone_name." Zone Created";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$resCode='0';$resMsg='Successful!';
				}else{$resCode='4';$resMsg='Error in Creating!';}
			}else{$res = 'The Requested Zone Name has already exist, Try with other values';}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);		
}
function zone_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$zone_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['zone_alias']));
		$zone_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['zone_name'])));
		if(empty($zone_name)){$res="Please Enter Zone Name";}
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_zone WHERE zone_name='$zone_name' AND zone_alias<>'$zone_alias' AND flag=0");
			if(mysqli_num_rows($q)==0){
				$sql=mysqli_query($mr_con,"UPDATE ec_zone SET zone_name='$zone_name' WHERE zone_alias='$zone_alias' AND flag=0");
				if($sql){
					$action=$zone_name." Zone Updated";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$resCode='0';$resMsg='Successful!';
				}else{$resCode='4';$resMsg='Error in Updating!';}
			}else{$res = 'The Requested Zone Name has already exist, Try with other values';}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function zone_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$zone_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
		$sql=mysqli_query($mr_con,"SELECT zone_name,zone_alias FROM ec_zone WHERE zone_alias='$zone_alias' AND flag=0");
		if(mysqli_num_rows($sql)>0){
			$row=mysqli_fetch_array($sql);
			$result['zone_name']=$row['zone_name'];
			$result['zone_alias']=$row['zone_alias'];
			$resCode='0'; $resMsg='Successful!';
		}else{$resCode='4';$resMsg='No Records Found!';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function zone_mul_view(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		if($_REQUEST['zoneAlias']!="")$zone_alias="zone_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['zoneAlias'])."' AND ";else $zone_alias="";
		$condtion=$zone_alias;
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_zone WHERE $condtion flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT zone_alias,zone_name FROM ec_zone WHERE $condtion flag=0 LIMIT $offset, $limit");
			//echo $condtion.$offset.$limit;
			$result['zoneDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['zoneDetails'][$i]['zone_alias']=$row['zone_alias']; 
					$result['zoneDetails'][$i]['zone_name']=$row['zone_name']; 
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
	$result['add'] = grantable('ADD', 'ZONES', $emp_alias);
	$result['edit'] = grantable('EDIT', 'ZONES', $emp_alias);
	$result['delete'] = grantable('DELETE', 'ZONES', $emp_alias);
	$result['view'] = grantable('VIEW', 'ZONES', $emp_alias);
	$result['export'] = grantable('EXPORT', 'ZONES', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function zone_export(){ 
	global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_zone WHERE flag=0");
	$colArr=array('Zone Name');
	$colArr2=array('zone_name');
	$filename = 'Zone_'.date('d-m-Y H_i_s');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
	$ch = 'A';
	foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
	$ch++;
	}
	$coo=1;
	while($row=mysqli_fetch_array($sql)){ $coo++;
				for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
					$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
		}
	}
	$objPHPExcel->getActiveSheet()->setTitle('Zone');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("../../exports/$filename.xlsx");
	$result['file_name']=$filename;
	$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function state_add(){ global $mr_con;
		$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$alias = aliasCheck(generateRandomString(),'ec_state','state_alias');
			$zone_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['zone_alias'])));
			$state_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['state_name'])));
			$state_code = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['state_code'])));
		if($zone_alias=='0'){$res="Please Enter Zone Name";}
		elseif(empty($state_name)){$res= "Please Enter State Name";}
		elseif(empty($state_code)){$res= "Please Enter State Code";}
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_state WHERE (state_name='$state_name' OR state_code='$state_code') AND flag=0");
		if(mysqli_num_rows($q)==0){
			$sql=mysqli_query($mr_con,"INSERT INTO ec_state(state_name,state_code,state_alias,zone_alias,created_date)VALUES('$state_name','$state_code','$alias','$zone_alias','".date('Y-m-d')."')");
			if($sql){
				$action=$state_name." State Created";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Creating!';}
					}else{$res = 'The Requested State Name OR State Code has already exist, Try with other values';}
				}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
			$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
			echo json_encode($result);
}	
function state_update(){ global $mr_con;
		$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
		$zone_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['zone_alias'])));
		$state_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['state_name'])));
		$state_code = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['state_code'])));
		$state_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['state_alias'])));
		if($zone_alias=='0'){$res="Please Enter Zone Name";}
		elseif(empty($state_name)){$res= "Please Enter State Name";}
		elseif(empty($state_code)){$res= "Please Enter State Code";}
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_state WHERE (state_name='$state_name' OR state_code='$state_code') AND state_alias<>'$state_alias' AND flag=0");
		if(mysqli_num_rows($q)==0){
			$sql=mysqli_query($mr_con,"UPDATE ec_state SET state_name='$state_name',zone_alias='$zone_alias',state_code='$state_code' WHERE state_alias='$state_alias' AND flag=0");
			if($sql){
				$action=$state_name." State Updated";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Updating!';}
		  		}else{$res = 'The Requested State Name OR State Code has already exist, Try with other values';}
			}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function state_view(){ global $mr_con;
		$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$state_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_state WHERE state_alias='$state_alias' AND flag=0");
			if(mysqli_num_rows($sql)){
				$row=mysqli_fetch_array($sql);
					$result['zone_name']=alias($row['zone_alias'],'ec_zone','zone_alias','zone_name');
					$result['zone_alias']=$row['zone_alias'];
					$result['state_name']=$row['state_name'];
					$result['state_code']=$row['state_code'];
					$result['state_alias']=$row['state_alias'];
					$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function state_mul_view(){ global $mr_con;
		$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){
		if($_REQUEST['stateName']!="")$state_name="state_name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['stateName'])."%' AND ";else $state_name="";
		if($_REQUEST['stateCode']!="")$state_code="state_code LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['stateCode'])."%' AND ";else $state_code="";
		if($_REQUEST['zoneAlias']!="")$zone_alias="zone_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['zoneAlias'])."' AND ";else $zone_alias="";
		$condtion=$state_code.$zone_alias.$state_name;
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_state WHERE $condtion flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT state_alias,state_name,state_code,zone_alias FROM ec_state WHERE $condtion flag=0 LIMIT $offset, $limit");
			$result['stateDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['stateDetails'][$i]['zone_name']=alias($row['zone_alias'],'ec_zone','zone_alias','zone_name');
					$result['stateDetails'][$i]['state_alias']=$row['state_alias'];
					$result['stateDetails'][$i]['state_name']=$row['state_name'];
					$result['stateDetails'][$i]['state_code']=$row['state_code']; 
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
	$result['add'] = grantable('ADD', 'STATES', $emp_alias);
	$result['edit'] = grantable('EDIT', 'STATES', $emp_alias);
	$result['delete'] = grantable('DELETE', 'STATES', $emp_alias);
	$result['view'] = grantable('VIEW', 'STATES', $emp_alias);
	$result['export'] = grantable('EXPORT', 'STATES', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function state_export(){ global $mr_con;
	if(isset($_REQUEST['zone_alias']) && count($_REQUEST['zone_alias'])>0){
		$zone_arr = $_REQUEST['zone_alias'];
		$zone = implode("|",$zone_arr);
		$con .= " zone_alias RLIKE '$zone' AND";
	}else{$con .= '';}
	if(isset($_REQUEST['state_alias']) && count($_REQUEST['state_alias'])>0){
		$state_arr = $_REQUEST['state_alias'];
		$state = implode("|",$state_arr);
		$con .= " state_alias RLIKE '$state' AND";
	}else{$con .= '';}
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_state WHERE $con flag=0");
	$colArr=array('State Name','State Code','Zone Name');
	$colArr2=array('state_name','state_code');
	$filename = 'State_'.date('d-m-Y H_i_s');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
	$ch = 'A';
	foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
	$ch++;
	}
	$coo=1;
	while($row=mysqli_fetch_array($sql)){ $coo++;
		for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
			$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
		}
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$coo, alias($row['zone_alias'],'ec_zone','zone_alias','zone_name'));
	}
	$objPHPExcel->getActiveSheet()->setTitle('State');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("../../exports/$filename.xlsx");
	$result['file_name']=$filename;
	$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);

}
function district_add(){ global $mr_con;
		$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$alias = aliasCheck(generateRandomString(),'ec_district','district_alias');
			$state_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['state_alias'])));
			$district_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['district_name'])));
			$area = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['area'])));
		if($state_alias=='0'){$res="Please Enter State Name";}
		elseif(empty($district_name)){$res="Please Enter District Name";}
		elseif($area==""){$res="Please Enter Area";}
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_district WHERE district_name='$district_name' AND flag=0");
		if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"INSERT INTO ec_district(district_name,district_alias,state_alias,area,created_date)VALUES('$district_name','$alias','$state_alias','$area','".date('Y-m-d')."')");
			if($sql){
				$action=$district_name." District Created";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Creating!';}
					}else{$res = 'The Requested District Name has already exist, Try with other values';}
				}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
			$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
			echo json_encode($result);
}
function district_update(){ global $mr_con;
		$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$district_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['district_alias']));
			$state_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['state_alias'])));
			$district_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['district_name'])));
			$area = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['area'])));
			if($state_alias=='0'){$res="Please Enter State Name";}
			elseif(empty($district_name)){$res="Please Enter District Name";}
			elseif($area==""){$res="Please Enter Area";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_district WHERE district_name='$district_name' AND district_alias<>'$district_alias' AND flag=0");
				if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"UPDATE ec_district SET district_name='$district_name',state_alias='$state_alias',area='$area' WHERE district_alias='$district_alias' AND flag=0");	
			if($sql){
				$action=$district_name." District Updated";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Updating!';}
		  		}else{$res = 'The Requested District Name has already exist, Try with other values';}
			}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function district_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$district_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_district WHERE district_alias='$district_alias' AND flag=0");
			if(mysqli_num_rows($sql)>0){
				$row=mysqli_fetch_array($sql);
					$result['zone_name']=alias(alias($row['state_alias'],'ec_state','state_alias','zone_alias'),'ec_zone','zone_alias','zone_name');
					$result['zone_alias']=alias($row['state_alias'],'ec_state','state_alias','zone_alias');
					$result['state_name']=alias($row['state_alias'],'ec_state','state_alias','state_name');
					$result['state_alias']=$row['state_alias'];
					$result['district_name']=$row['district_name'];
					$result['district_alias']=$row['district_alias'];
					$result['area']=($row['area']==0 ? "Plain Area" : "Hilly Area");
					$result['area_alias']=$row['area'];
					$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function district_mul_view(){ global $mr_con;
		$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){
		if($_REQUEST['districtName']!="")$district_name="district_name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['districtName'])."%' AND ";else $district_name="";
		if($_REQUEST['stateName']!="")$state_name="state_name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['stateName'])."%' AND ";else $state_name="";
		if($_REQUEST['zoneName']!="")$zone_alias="zone_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['zoneName'])."' AND ";else $zone_alias="";
		if($_REQUEST['area']!="")$area="area ='".mysqli_real_escape_string($mr_con,$_REQUEST['area'])."' AND ";else $area="";
		$siteCondition=$state_name.$zone_alias;
		$condtion=$district_name.$area;
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_district WHERE $condtion flag=0 AND state_alias IN (SELECT state_alias FROM ec_state WHERE $siteCondition flag=0)");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT area,district_name,state_alias,district_alias FROM ec_district WHERE $condtion flag=0 AND state_alias IN (SELECT state_alias FROM ec_state WHERE $siteCondition flag=0) LIMIT $offset, $limit");
			$result['districtDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['districtDetails'][$i]['zone_name']=alias(alias($row['state_alias'],'ec_state','state_alias','zone_alias'),'ec_zone','zone_alias','zone_name');
					$result['districtDetails'][$i]['state_name']=alias($row['state_alias'],'ec_state','state_alias','state_name'); 
					$result['districtDetails'][$i]['area']=($row['area']=='0' ? "PLAIN" : "HILLY")." AREA";
					$result['districtDetails'][$i]['district_name']=$row['district_name']; 
					$result['districtDetails'][$i]['district_alias']=$row['district_alias']; 
				$i++;}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}
	}elseif($rex=='1'){
		$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	$result['add'] = grantable('ADD', 'DISTRICTS', $emp_alias);
	$result['edit'] = grantable('EDIT', 'DISTRICTS', $emp_alias);
	$result['delete'] = grantable('DELETE', 'DISTRICTS', $emp_alias);
	$result['view'] = grantable('VIEW', 'DISTRICTS', $emp_alias);
	$result['export'] = grantable('EXPORT', 'DISTRICTS', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function district_export(){ global $mr_con;
	if(isset($_REQUEST['zone_alias']) && count($_REQUEST['zone_alias'])>0){
		$zone_arr = $_REQUEST['zone_alias'];
		$zone = implode("|",$zone_arr);
		$con .= " t2.zone_alias RLIKE '$zone' AND";
	}else{$con .= '';}
	if(isset($_REQUEST['state_alias']) && count($_REQUEST['state_alias'])>0){
		$state_arr = $_REQUEST['state_alias'];
		$state = implode("|",$state_arr);
		$con .= " t1.state_alias RLIKE '$state' AND";
	}else{$con .= '';}
	if(isset($_REQUEST['district_alias']) && count($_REQUEST['district_alias'])>0){
		$district_arr = $_REQUEST['district_alias'];
		$district = implode("|",$district_arr);
		$con .= " t1.district_alias RLIKE '$district' AND";
	}else{$con .= '';}
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$sql = mysqli_query($mr_con,"SELECT t1.*,t2.* FROM ec_district t1 JOIN ec_state t2 ON t1.state_alias=t2.state_alias WHERE $con t1.flag=0 AND t2.flag=0");
		$colArr=array('District Name','Zone Name','State Name','Area');
		$colArr2=array('district_name');
		$filename = 'District_'.date('d-m-Y H_i_s');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
		$ch = 'A';
		foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
		$ch++;
		}
		$coo=1;
		while($row=mysqli_fetch_array($sql)){ $coo++;
			for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
				$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$coo, alias($row['state_alias'],'ec_state','state_alias','state_name'));
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$coo, alias(alias($row['state_alias'],'ec_state','state_alias','zone_alias'),'ec_zone','zone_alias','zone_name'));
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$coo,($row['area']=='0' ? "Plain Area" : "Hilly Area"));
		}
		$objPHPExcel->getActiveSheet()->setTitle('District');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save("../../exports/$filename.xlsx");
		$result['file_name']=$filename;
		$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function designation_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$alias = aliasCheck(generateRandomString(),'ec_designation','designation_alias');
			$grade = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['grade'])));
			$designation = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['designation'])));
			if(empty($grade)){$res="Please Enter grade";}
			elseif(empty($designation)){echo "Please Enter Designation";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_designation WHERE designation='$designation' AND flag=0");
				if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"INSERT INTO ec_designation(grade,designation,designation_alias,created_date) VALUES('S1','$designation','$alias','".date('Y-m-d')."')");
			if($sql){
				$action=$designation." Designation Created";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Creating!';}
					}else{$res = 'The Requested Designation Name has already exist, Try with other values';}
				}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
			$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
			echo json_encode($result);
}
function designation_update(){ global $mr_con;
		$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$designation_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['designation_alias']));
			$grade = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['grade'])));
			$designation = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['designation'])));

			if(empty($grade)){$res="Please Enter grade";}
			elseif(empty($designation)){echo "Please Enter Designation";}
			
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_designation WHERE designation='$designation' AND designation_alias<>'$designation_alias' AND flag=0");
				if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"UPDATE ec_designation SET designation='$designation',grade='$grade' WHERE designation_alias='$designation_alias' AND flag=0");
			if($sql){
				$action=$designation." Designation Updated";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Updating!';}
		  		}else{$res = 'The Requested Designation Name has already exist, Try with other values';}
			}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function designation_view(){ global $mr_con;
		$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$designation_alias=$_REQUEST['alias'];
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_designation WHERE designation_alias='$designation_alias' AND flag=0");
			if(mysqli_num_rows($sql)>0){
				$row=mysqli_fetch_array($sql);
					$result['designation']=$row['designation'];
					$result['designation_alias']=$row['designation_alias'];
					$result['grade']=$row['grade'];
					$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function designation_mul_view(){ global $mr_con;
		$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){
		if($_REQUEST['designationAlias']!="")$designation_alias="designation_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['designationAlias'])."' AND ";else $designation_alias="";
		if($_REQUEST['grade']!="")$grade="grade LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['grade'])."%' AND ";else $grade="";
		$condtion=$designation_alias.$description.$grade;
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_designation WHERE $condtion flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT designation_alias,designation,grade FROM ec_designation WHERE $condtion flag=0 LIMIT $offset, $limit");
			$result['designationDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['designationDetails'][$i]['designation']=$row['designation']; 
					$result['designationDetails'][$i]['designation_alias']=$row['designation_alias'];
					$result['designationDetails'][$i]['grade']=$row['grade'];
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
	$result['add'] = grantable('ADD', 'DESIGNATIONS', $emp_alias);
	$result['edit'] = grantable('EDIT', 'DESIGNATIONS', $emp_alias);
	$result['delete'] = grantable('DELETE', 'DESIGNATIONS', $emp_alias);
	$result['view'] = grantable('VIEW', 'DESIGNATIONS', $emp_alias);
	$result['export'] = grantable('EXPORT', 'DESIGNATIONS', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function designation_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_designation WHERE flag=0");
	$colArr=array('Grade','Designation');
	$colArr2=array('grade','designation');
	$filename = 'Designation_'.date('d-m-Y H_i_s');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
	$ch = 'A';
	foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
	$ch++;
	}
	$coo=1;
	while($row=mysqli_fetch_array($sql)){ $coo++;
				for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
					$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
		}
	}
	$objPHPExcel->getActiveSheet()->setTitle('Designation');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("../../exports/$filename.xlsx");
	$result['file_name']=$filename;
	$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function department_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$alias = aliasCheck(generateRandomString(),'ec_department','department_alias');
			$department_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['department_name'])));
			if(empty($department_name)){$res="Please Enter Department Name";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_department WHERE department_name='$department_name' AND flag=0");
				if(mysqli_num_rows($q)==0){
				$sql=mysqli_query($mr_con,"INSERT INTO ec_department(department_name,department_alias,created_date) VALUES('$department_name','$alias','".date('Y-m-d')."')");
				if($sql){
					$action=$department_name." Department Created";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Creating!';}
					}else{$res = 'The Requested Department Name has already exist, Try with other values';}
				}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
			$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
			echo json_encode($result);
}
function department_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
				$department_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['department_alias']));
				$department_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['department_name'])));
			if(empty($department_name)){$res="Please Enter Department Name";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_department WHERE department_name='$department_name' AND department_alias<>'$department_alias' AND flag=0");
			if(mysqli_num_rows($q)==0){
				$sql=mysqli_query($mr_con,"UPDATE ec_department SET department_name='$department_name' WHERE department_alias='$department_alias' AND flag=0");
				if($sql){
					$action=$department_name." Department Updated";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Updating!';}
		  		}else{$res = 'The Requested Department Name has already exist, Try with other values';}
			}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function department_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$department_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_department WHERE department_alias='$department_alias' AND flag=0");
			if(mysqli_num_rows($sql)>0){
				$row=mysqli_fetch_array($sql);
					$result['department_name']=$row['department_name'];
					$result['department_alias']=$row['department_alias'];
					$result['grade']=$row['grade'];
					$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function department_mul_view(){ global $mr_con;
		$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){
		if($_REQUEST['departmentName']!="")$department_name="department_name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['departmentName'])."%' AND ";else $department_name="";
		$condtion=$department_name;
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_department WHERE $condtion flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT department_alias,department_name FROM ec_department WHERE $condtion flag=0 LIMIT $offset, $limit");
			$result['departmentDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['departmentDetails'][$i]['department_name']=$row['department_name'];
					$result['departmentDetails'][$i]['department_alias']=$row['department_alias'];
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
	$result['add'] = grantable('ADD', 'DEPARTMENTS', $emp_alias);
	$result['edit'] = grantable('EDIT', 'DEPARTMENTS', $emp_alias);
	$result['delete'] = grantable('DELETE', 'DEPARTMENTS', $emp_alias);
	$result['view'] = grantable('VIEW', 'DEPARTMENTS', $emp_alias);
	$result['export'] = grantable('EXPORT', 'DEPARTMENTS', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function department_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_department WHERE flag=0");
	$colArr=array('Department Name');
	$colArr2=array('department_name');
	$filename = 'Department_'.date('d-m-Y H_i_s');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
	$ch = 'A';
	foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
	$ch++;
	}
	$coo=1;
	while($row=mysqli_fetch_array($sql)){ $coo++;
				for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
					$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
		}
	}
	$objPHPExcel->getActiveSheet()->setTitle('Department');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("../../exports/$filename.xlsx");
	$result['file_name']=$filename;
	$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function employee_role_add(){ global $mr_con;
		$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
		$alias = aliasCheck(generateRandomString(),'ec_employee_master','employee_alias');
		$role_name=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_role'])));
		$description = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['description'])));
		if(empty($role_name)){$res="Please Enter Employee Role";}
		elseif(empty($description)){$res="Please Enter Employee Description";}
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_emprole WHERE (role_name='$role_name' OR description='$description') AND flag=0");
		if(mysqli_num_rows($q)==0){
		$sql = mysqli_query($mr_con,"INSERT INTO ec_emprole(role_name,description,role_alias,created_date)VALUES('$role_name','$description','$alias','".date('Y-m-d')."')");
		if($sql){
			$action=$role_name." Employee Role Created";
			user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
			$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Creating!';}
					}else{$res = 'The Requested Employee Role OR Description has already exist, Try with other values';}
				}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
			$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
			echo json_encode($result);
}
function employee_role_update(){ global $mr_con;
		$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$role_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['role_alias']));
			$role_name=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_role'])));
			$description = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['description'])));
		if(empty($role_name)){$res="Please Enter Employee Role";}
		elseif(empty($description)){$res="Please Enter Employee Description";}
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_emprole WHERE (role_name='$role_name' OR description='$description') AND role_alias<>'$role_alias' AND flag=0");
		if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"UPDATE ec_emprole SET role_name='$role_name',description='$description' WHERE role_alias='$role_alias' AND flag=0");
			if($sql){
				$action=$role_name." Employee Role Updated";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Updating!';}
		  		}else{$res = 'The Requested Employee Role OR Description has already exist, Try with other values';}
			}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function employee_role_view(){ global $mr_con;
		$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$role_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_emprole WHERE role_alias='$role_alias' AND flag=0");
			if(mysqli_num_rows($sql)>0){
				$row=mysqli_fetch_array($sql);
					$result['role_name']=$row['role_name'];
					$result['description']=$row['description'];
					$result['role_alias']=$row['role_alias'];
					$result['grade']=$row['grade'];
					$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function employee_role_mul_view(){ global $mr_con;
		$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){
		if($_REQUEST['roleAlias']!="")$role_alias="role_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['roleAlias'])."' AND ";else $role_alias="";
		if($_REQUEST['description']!="")$description="description LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['description'])."%' AND ";else $description="";
		$condtion=$role_alias.$description;
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM  ec_emprole WHERE $condtion flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT role_alias,role_name,description FROM ec_emprole WHERE $condtion flag=0 LIMIT $offset, $limit");
			$result['emproleDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){ 
					$result['emproleDetails'][$i]['role_name']=$row['role_name'];
					$result['emproleDetails'][$i]['role_alias']=$row['role_alias'];
					$result['emproleDetails'][$i]['description']=$row['description'];
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
	$result['add'] = grantable('ADD', 'EMPLOYEE ROLES', $emp_alias);
	$result['edit'] = grantable('EDIT', 'EMPLOYEE ROLES', $emp_alias);
	$result['delete'] = grantable('DELETE', 'EMPLOYEE ROLES', $emp_alias);
	$result['view'] = grantable('VIEW', 'EMPLOYEE ROLES', $emp_alias);
	$result['export'] = grantable('EXPORT', 'EMPLOYEE ROLES', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function employee_role_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_emprole WHERE flag=0");
		$colArr=array('Role Name','Description');
		$colArr2=array('role_name','description');
		$filename = 'EmployeeRole_'.date('d-m-Y H_i_s');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
		$ch = 'A';
		foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$ch++;
		}
		$coo=1;
		while($row=mysqli_fetch_array($sql)){ $coo++;
			for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
				$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
			}
		}
		$objPHPExcel->getActiveSheet()->setTitle('EmployeeRole');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save("../../exports/$filename.xlsx");
		$result['file_name']=$filename;
		$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function warehouse_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$alias = aliasCheck(generateRandomString(),'ec_warehouse','wh_alias');
			$wh_code = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['wh_code'])));
			$wh_address = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['wh_address'])));
			$zone_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['zone_alias'])));
			$state_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['state_alias'])));
			$description = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['description'])));
			$road_permit = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['road_permit'])));
			if(empty($wh_code)){$res="Please Enter Warehouse Code";}
			elseif(empty($wh_address)){$res="Please Enter Warehouse Address";}
			elseif($zone_alias=='0'){$res="Please Select Zone";}
			elseif($state_alias=='0'){$res="Please Select State";}
			elseif(empty($description)){$res="Please Enter Description";}
			elseif($road_permit==""){$res="Select Road Permit";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_warehouse WHERE wh_code='$wh_code' AND flag=0");
				if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"INSERT INTO ec_warehouse(wh_code,wh_address,zone_alias,state_alias,description,road_permit,wh_alias,created_date)VALUES('$wh_code','$wh_address','$zone_alias','$state_alias','$description','$road_permit','$alias','".date('Y-m-d')."')");
			if($sql){
				$action=$wh_code." Warehouse Created";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Creating!';}
					}else{$res = 'The Requested Warehouse Code has already exist, Try with other values';}
				}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
			$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
			echo json_encode($result);
}
function warehouse_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$wh_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['wh_alias']));
			$wh_code = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['wh_code'])));
			$wh_address = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['wh_address'])));
			$zone_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['zone_alias'])));
			$state_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['state_alias'])));
			$description = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['description'])));
			$road_permit = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['road_permit'])));
			if(empty($wh_code)){$res="Please Enter Warehouse Code";}
			elseif(empty($wh_address)){$res="Please Enter Warehouse Address";}
			elseif(empty($zone_alias)){$res="Please Enter Zone Name";}
			elseif(empty($state_alias)){$res="Please Enter State Name";}
			elseif(empty($description)){$res="Please Enter Description";}
			elseif($road_permit==""){$res="Select Road Permit";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_warehouse WHERE wh_code='$wh_code' AND wh_alias<>'$wh_alias' AND flag=0");
				if(mysqli_num_rows($q)==0){
					$sql = mysqli_query($mr_con,"UPDATE ec_warehouse SET wh_code='$wh_code',wh_address='$wh_address',zone_alias='$zone_alias',state_alias='$state_alias',description='$description',road_permit='$road_permit' WHERE wh_alias='$wh_alias' AND flag=0");
					if($sql){
						$action=$wh_code." Warehouse Updated";
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
						$resCode='0';$resMsg='Successful!';
					}else{$resCode='4';$resMsg='Error in Updating!';}
		  		}else{$res = 'The Requested Warehouse Code has already exist, Try with other values';}
			}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
			
}
function warehouse_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$wh_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_warehouse WHERE wh_alias='$wh_alias' AND flag=0");
			if(mysqli_num_rows($sql)>0){
				$row=mysqli_fetch_array($sql);
					$result['wh_code']=$row['wh_code'];
					$result['wh_alias']=$row['wh_alias'];
					$result['wh_address']=$row['wh_address'];
					$result['zone_name']=alias($row['zone_alias'],'ec_zone','zone_alias','zone_name');
					$result['zone_alias']=$row['zone_alias'];
					$result['state_name']=alias($row['state_alias'],'ec_state','state_alias','state_name');
					$result['state_alias']=$row['state_alias'];
					$result['description']=$row['description'];
					$result['road_permit']=$row['road_permit'];
				$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function warehouse_mul_view(){ global $mr_con;
		$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){
		if($_REQUEST['zoneAlias']!="")$zone_alias="zone_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['zoneAlias'])."' AND ";else $zone_alias="";
		if($_REQUEST['stateName']!="")$state_name="state_name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['stateName'])."%' AND ";else $state_name="";
		if($_REQUEST['whCode']!="")$wh_code="wh_code LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['whCode'])."%' AND ";else $wh_code="";
		if($_REQUEST['description']!="")$description="description LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['description'])."%' AND ";else $description="";
		if($_REQUEST['whAddress']!="")$wh_address="wh_address LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['whAddress'])."%' AND ";else $wh_address="";
		if($_REQUEST['road_permit']!="")$road_permit="road_permit='".mysqli_real_escape_string($mr_con,$_REQUEST['road_permit'])."' AND ";else $road_permit="";
		$condtion=$zone_alias.$description.$wh_address.$wh_code.$road_permit;
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_warehouse WHERE $condtion flag=0 AND state_alias IN (SELECT state_alias FROM ec_state WHERE $state_name flag=0)");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT wh_alias,wh_code,wh_address,description,zone_alias,state_alias,road_permit FROM ec_warehouse WHERE $condtion flag=0 AND state_alias IN (SELECT state_alias FROM ec_state WHERE $state_name flag=0) LIMIT $offset, $limit");
			$result['warehouseDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['warehouseDetails'][$i]['zone_alias']=alias($row['zone_alias'],'ec_zone','zone_alias','zone_name');
					$result['warehouseDetails'][$i]['state_alias']=alias($row['state_alias'],'ec_state','state_alias','state_name');
					$result['warehouseDetails'][$i]['wh_address']=$row['wh_address'];
					$result['warehouseDetails'][$i]['wh_code']=$row['wh_code'];
					$result['warehouseDetails'][$i]['wh_alias']=$row['wh_alias'];
					$result['warehouseDetails'][$i]['description']=$row['description'];
					$result['warehouseDetails'][$i]['road_permit']=$row['road_permit'];
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
	$result['add'] = grantable('ADD', 'WAREHOUSES', $emp_alias);
	$result['edit'] = grantable('EDIT', 'WAREHOUSES', $emp_alias);
	$result['delete'] = grantable('DELETE', 'WAREHOUSES', $emp_alias);
	$result['view'] = grantable('VIEW', 'WAREHOUSES', $emp_alias);
	$result['export'] = grantable('EXPORT', 'WAREHOUSES', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function warehouse_export(){ global $mr_con;
	$zone_arr = array();$state_arr = array();
	if(isset($_REQUEST['zone_alias']) && count($_REQUEST['zone_alias'])>0){
		$zone_arr = $_REQUEST['zone_alias'];
		$zone = implode("|",$zone_arr);
		$con .= " zone_alias RLIKE '$zone' AND";
	}else{$con .= '';}
	if(isset($_REQUEST['state_alias']) && count($_REQUEST['state_alias'])>0){
		$state_arr = $_REQUEST['state_alias'];
		$state = implode("|",$state_arr);
		$con .= " state_alias RLIKE '$state' AND";
	}else{$con .= '';}
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_warehouse WHERE $con flag=0");
	$colArr=array('Wh Code','Wh Address','Description','Zone','State','Road Permit');
	$colArr2=array('wh_code','wh_address','description');
	$filename = 'Warehouse_'.date('d-m-Y H_i_s');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
	$ch = 'A';
	foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
	$ch++;
	}
	$coo=1;
	while($row=mysqli_fetch_array($sql)){ 
		$zone_alias=explode(", ",$row['zone_alias']);
		$zcnt=count($zone_alias);
		$state_alias = explode(", ",$row['state_alias']);
		$scnt=count($state_alias);
		$max=max($zcnt,$scnt);
		for($w=0;$w<$max;$w++){
			$a = (count($zone_arr) ? in_array($zone_alias[$w],$zone_arr) : TRUE);
			$b = (count($state_arr) ? in_array($state_alias[$w],$state_arr) : TRUE);
			if($a || $b){$coo++;
				for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
					$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$coo, alias($zone_alias[$w],'ec_zone','zone_alias','zone_name'));
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$coo, alias($state_alias[$w],'ec_state','state_alias','state_name'));
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$coo, ($row['road_permit']=='1' ? "Required":"Not Required"));
			}
		}
	}
	$objPHPExcel->getActiveSheet()->setTitle('Warehouse');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("../../exports/$filename.xlsx");
	$result['file_name']=$filename;
	$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function stock_code_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$alias = aliasCheck(generateRandomString(),'ec_stock','stock_alias');
			$stock_code = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['stock_code'])));
			$description = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['description'])));
			if(empty($stock_code)){$res="Please Enter Stock Code";}
			elseif(empty($description)){$res="Please Enter Description";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_stock WHERE (stock_code='$stock_code' OR description='$description') AND flag=0");
				if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"INSERT INTO ec_stock(stock_code,description,stock_alias,created_date)VALUES('$stock_code','$description','$alias','".date('Y-m-d')."')");
			if($sql){
				$action=$stock_code." Stock Code Created";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Creating!';}
					}else{$res = 'The Requested Stack Code OR Description has already exist, Try with other values';}
				}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
			$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
			echo json_encode($result);
}
function stock_code_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$stock_alias = mysqli_real_escape_string($mr_con,trim($_REQUEST['stock_alias']));
			$stock_code = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['stock_code'])));
			$description = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['description'])));
			if(empty($stock_code)){$res="Please Enter Stock Code";}
			elseif(empty($description)){$res="Please Enter Description";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_stock WHERE (stock_code='$stock_code' OR description='$description') AND stock_alias<>'$stock_alias' AND flag=0");
				if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"UPDATE ec_stock SET stock_code='$stock_code',description='$description' WHERE stock_alias='$stock_alias' AND flag=0");
			if($sql){
				$action=$stock_code." Stock Code Updated";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Updating!';}
		  		}else{$res = 'The Requested Stack Code OR Description has already exist, Try with other values';}
			}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function stock_code_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$stock_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_stock WHERE stock_alias='$stock_alias' AND flag=0");
			if(mysqli_num_rows($sql)>0){
				$row=mysqli_fetch_array($sql);
					$result['stock_code']=$row['stock_code'];
					$result['description']=$row['description'];
					$result['stock_alias']=$row['stock_alias'];
				$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function stock_code_mul_view(){ global $mr_con;
		$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){
		if($_REQUEST['stockAlias']!="")$stock_alias="stock_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['stockAlias'])."' AND ";else $stock_alias="";
		if($_REQUEST['description']!="")$description="description LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['description'])."%' AND ";else $description="";
		$condtion=$stock_alias.$description;
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM  ec_stock WHERE $condtion flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT stock_alias,stock_code,description FROM ec_stock WHERE $condtion flag=0 LIMIT $offset, $limit");
			$result['stockcodeDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['stockcodeDetails'][$i]['stock_code']=$row['stock_code'];
					$result['stockcodeDetails'][$i]['stock_alias']=$row['stock_alias'];
					$result['stockcodeDetails'][$i]['description']=$row['description'];
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
	$result['add'] = grantable('ADD', 'STOCK CODES', $emp_alias);
	$result['edit'] = grantable('EDIT', 'STOCK CODES', $emp_alias);
	$result['delete'] = grantable('DELETE', 'STOCK CODES', $emp_alias);
	$result['view'] = grantable('VIEW', 'STOCK CODES', $emp_alias);
	$result['export'] = grantable('EXPORT', 'STOCK CODES', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function stockcode_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_stock WHERE flag=0");
	$colArr=array('Stock Code','Description');
	$colArr2=array('stock_code','description');
	$filename = 'Stockcode_'.date('d-m-Y H_i_s');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
	$ch = 'A';
	foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
	$ch++;
	}
	$coo=1;
	while($row=mysqli_fetch_array($sql)){ $coo++;
				for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
					$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
		}
	}
	$objPHPExcel->getActiveSheet()->setTitle('Stockcode');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("../../exports/$filename.xlsx");
	$result['file_name']=$filename;
	$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function segment_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$alias = aliasCheck(generateRandomString(),'ec_segment','segment_alias');
			$segment_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['segment_name'])));
			$segment_code = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['segment_code'])));
			if(empty($segment_name)){$res="Please Enter Segment Name";}
			elseif(empty($segment_code)){$res="Please Enter Segment Code";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_segment WHERE (segment_name='$segment_name' OR segment_code='$segment_code') AND flag=0");
				if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"INSERT INTO ec_segment(segment_name,segment_code,segment_alias,created_date)VALUES('$segment_name','$segment_code','$alias','".date('Y-m-d')."')");
			if($sql){
				$action=$segment_name." Segment Name Created";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Creating!';}
					}else{$res = 'The Requested Segment Name OR Segment Code has already exist, Try with other values';}
				}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
			$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
			echo json_encode($result);
}
function segment_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$segment_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['segment_alias']));
			$segment_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['segment_name'])));
			$segment_code = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['segment_code'])));
			if(empty($segment_name)){$res="Please Enter Segment Name";}
			elseif(empty($segment_code)){$res="Please Enter Segment Code";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_segment WHERE (segment_name='$segment_name' OR segment_code='$segment_code') AND segment_alias<>'$segment_alias' AND flag=0");
				if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"UPDATE ec_segment SET segment_name='$segment_name',segment_code='$segment_code' WHERE segment_alias='$segment_alias' AND flag=0");	
			if($sql){
				$action=$segment_name." Segment Name Updated";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Updating!';}
		  		}else{$res = 'The Requested Segment Name OR Segment Code has already exist, Try with other values';}
			}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function segment_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$segment_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_segment WHERE segment_alias='$segment_alias' AND flag=0");
			if(mysqli_num_rows($sql)>0){
				$row=mysqli_fetch_array($sql);
					$result['segment_name']=$row['segment_name'];
					$result['segment_code']=$row['segment_code'];
					$result['segment_alias']=$row['segment_alias'];
				$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function segment_mul_view(){ global $mr_con;
		$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){
		if($_REQUEST['segmentAlias']!="")$segment_alias="segment_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['segmentAlias'])."' AND ";else $segment_alias="";
		if($_REQUEST['segmentCode']!="")$segment_code="segment_code LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['segmentCode'])."%' AND ";else $segment_code="";
		$condtion=$segment_alias.$segment_code;
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM  ec_segment WHERE $condtion flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT segment_alias,segment_name,segment_code FROM ec_segment WHERE $condtion flag=0 LIMIT $offset, $limit");
			$result['segmentDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['segmentDetails'][$i]['segment_name']=$row['segment_name'];
					$result['segmentDetails'][$i]['segment_alias']=$row['segment_alias'];
					$result['segmentDetails'][$i]['segment_code']=$row['segment_code'];
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
	$result['add'] = false;
	$result['edit'] = false;
	$result['delete'] = false;
	$result['view'] = grantable('VIEW', 'SEGMENTS', $emp_alias);
	$result['export'] = grantable('EXPORT', 'SEGMENTS', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function segment_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_segment WHERE flag=0");
	$colArr=array('Segment Name','Segment Code');
	$colArr2=array('segment_name','segment_code');
	$filename = 'Segment_'.date('d-m-Y H_i_s');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
	$ch = 'A';
	foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
	$ch++;
	}
	$coo=1;
	while($row=mysqli_fetch_array($sql)){ $coo++;
				for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
					$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
		}
	}
	$objPHPExcel->getActiveSheet()->setTitle('Segment');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("../../exports/$filename.xlsx");
	$result['file_name']=$filename;
	$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function customer_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$alias = aliasMulCheck(generateRandomString());
			$customer_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['customer_name'])));
			$customer_code = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['customer_code'])));
			$customer_id = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['customer_id'])));
			$password = mysqli_real_escape_string($mr_con,trim($_REQUEST['password']));
			$customer_email = mysqli_real_escape_string($mr_con,trim($_REQUEST['customer_email']));
			//$customer_contact = mysqli_real_escape_string($mr_con,trim($_REQUEST['customer_contact']));
			$dispatch = mysqli_real_escape_string($mr_con,trim($_REQUEST['dispatch']));
			$installation = mysqli_real_escape_string($mr_con,trim($_REQUEST['installation']));
			$schedule = mysqli_real_escape_string($mr_con,trim($_REQUEST['schedule']));
			$segment_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['segment_alias'])));
			$po_file = (!isset($_FILES['po_file']) || empty($_FILES['po_file']['name']) ? "":$_FILES['po_file']);
			if(isset($_REQUEST['product_alias'])){$product = implode(", ",$_REQUEST['product_alias']);}else{$product = '';}
			$product_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($product)));
			if(empty($customer_name)){$res="Please Enter Customer Name";}
			elseif(empty($customer_code)){$res="Please Enter Customer Code";}
			elseif(empty($customer_id)){$res="Please Enter Customer Id";}
			elseif(empty($password)){$res="Please Enter Password";}
			elseif(empty($customer_email)){$res="Please Enter Customer Email";}
			//elseif(empty($customer_contact)){$res="Please Enter Customer Contact";}
			elseif(empty($dispatch)){$res="Please Enter Dispatch";}
			//elseif($installation==''){$res="Please Enter Installation";}
			elseif($schedule==''){$res="Please Enter Schedule";}
			elseif($segment_alias==''){$res="Please Select Segment Name";}
			elseif(empty($po_file)){$res="Select PO Copy";}
			elseif(count($_REQUEST['product_alias'])==0){$res="Please Select Product Name";}
			else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_customer WHERE (customer_name='$customer_name' OR customer_code='$customer_code') AND flag=0");
				if(mysqli_num_rows($q)==0){
					$link = upload_file($po_file,'po_file','pdf');
					list($code,$msg1) = explode(",",$link);
					if($code=='0'){ $contact_link = $msg1;	
						$query = "INSERT INTO ec_customer( customer_name, customer_code, customer_id, password, customer_email, dispatch, installation, segment_alias, product_alias, schedule, po_file, customer_alias, created_date) VALUES ('$customer_name', '$customer_code', '$customer_id', '".password_hash_encript($password)."', '$customer_email', '$dispatch', '$installation', '$segment_alias', '$product_alias', '$schedule', '$contact_link', '$alias', '".date('Y-m-d')."')";
						$sql = mysqli_query($mr_con, $query);
						if($sql){
							$action=$customer_name." Customer Name Created";
							user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
							update_fields('serv_eng_status');
							$resCode='0';$resMsg='Successful!';
						}else{$resCode='4';$resMsg='Error in Creating!';}
					}else{$res = $msg1.', Try again!';}
				}else{$res = 'The Requested Customer Name OR Customer Code has already exist, Try with other values';}
				}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function customer_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$customer_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['customer_alias']));
		$customer_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['customer_name'])));
		$customer_code = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['customer_code'])));
		$customer_id = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['customer_id'])));
		$customer_email = mysqli_real_escape_string($mr_con,trim($_REQUEST['customer_email']));
		//$customer_contact = mysqli_real_escape_string($mr_con,trim($_REQUEST['customer_contact']));
		$dispatch = mysqli_real_escape_string($mr_con,trim($_REQUEST['dispatch']));
		$installation = mysqli_real_escape_string($mr_con,trim($_REQUEST['installation']));
		$schedule = mysqli_real_escape_string($mr_con,trim($_REQUEST['schedule']));
		$segment_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['segment_alias'])));
		if(isset($_REQUEST['product_alias'])){$product = implode(", ",$_REQUEST['product_alias']);}else{$product = '';}
		$product_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($product)));
		$status = mysqli_real_escape_string($mr_con,trim($_REQUEST['status']));
		if(empty($customer_name)){$res="Please Enter Customer Name";}
		elseif(empty($customer_code)){$res="Please Enter Customer Code";}
		elseif(empty($customer_id)){$res="Please Enter Customer Id";}
		elseif(empty($customer_email)){$res="Please Enter Customer Email";}
		//elseif(empty($customer_contact)){$res="Please Enter Customer Contact";}
		elseif(empty($dispatch)){$res="Please Enter Dispatch";}
		//elseif($installation==''){$res="Please Enter Installation";}
		elseif($schedule==''){$res="Please Enter Schedule";}
		elseif($segment_alias==''){$res="Please Enter Segment Name";}
		elseif(isset($_REQUEST['status']) && $_REQUEST['status']==''){$res="Please select Status";}
		elseif(count($_REQUEST['product_alias'])==0){$res="Please Select Product Name";}
		else{
			$con .= (isset($_REQUEST['status']) ? ",flag='$status'" : "");
			$q=mysqli_query($mr_con,"SELECT id FROM ec_customer WHERE (customer_name='$customer_name' OR customer_code='$customer_code') AND customer_alias<>'$customer_alias' AND flag IN('0','1')");
			if(mysqli_num_rows($q)==0){
				if(!empty($_FILES['po_file']['name'])){
				$link = upload_file($_FILES['po_file'],'po_file','pdf');
					list($code,$msg1) = explode(",",$link);
					if($code=='0'){ $contact_link = $msg1;}
					$con.=",po_file='$contact_link'";
				}else{$con.="";}
				$sql = mysqli_query($mr_con,"UPDATE ec_customer SET customer_name='$customer_name',customer_code='$customer_code',customer_id='$customer_id',customer_email='$customer_email',dispatch='$dispatch',installation='$installation',schedule='$schedule',product_alias='$product_alias',segment_alias='$segment_alias' $con WHERE customer_alias='$customer_alias' AND flag IN('0','1')");
				if($sql){
					$action=$customer_name." Customer Name Updated";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					update_fields('serv_eng_status');
					$resCode='0';$resMsg='Successful!';
				}else{$resCode='4';$resMsg='Error in Updating!';}
			}else{$res = 'The Requested Customer Name OR Customer Code has already exist, Try with other values';}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function customer_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
		  $customer_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
		  $sql=mysqli_query($mr_con,"SELECT * FROM ec_customer WHERE customer_alias='$customer_alias' AND flag IN('0','1')");
		if(mysqli_num_rows($sql)>0){
				$row=mysqli_fetch_array($sql);
					$result['customer_alias']=$row['customer_alias'];
					$result['customer_name']=$row['customer_name'];
					$result['customer_code']=$row['customer_code'];
					$result['customer_id']=$row['customer_id'];
					$result['customer_email']=$row['customer_email'];
					//$result['customer_contact']=$row['customer_contact'];
					$result['dispatch']=$row['dispatch'];
					$result['installation']=$row['installation'];
					$result['schedule']=$row['schedule'];
					$result['created_date']=$row['created_date'];
					$result['segment_name']=alias($row['segment_alias'],'ec_segment','segment_alias','segment_name');
					$result['segment_alias']=$row['segment_alias'];
					$product = explode(", ",$row['product_alias']);
					foreach($product as $pro){ $xx .= alias($pro,'ec_product','product_alias','product_description').", "; }
					$result['product_description'] = trim($xx,", ");
					$result['product_alias']=$row['product_alias'];
					$result['status']=$row['flag'];
					$result['emp_alias']=strtoupper($_REQUEST['emp_alias']);
					$result['po_file']=(!empty($row['po_file']) ? baseurl()."images/po_file/".$row['po_file'] : "-");
				$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function customer_mul_view(){ global $mr_con;
		$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){
		if($_REQUEST['customerName']!="")$customer_name="customer_name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['customerName'])."%' AND ";else $customer_name="";
		if($_REQUEST['customerCode']!="")$customer_code="customer_code LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['customerCode'])."%' AND ";else $customer_code="";
		if($_REQUEST['dispatch']!="")$dispatch="dispatch LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['dispatch'])."%' AND ";else $dispatch="";
		if($_REQUEST['installation']!="")$installation="installation LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['installation'])."%' AND ";else $installation="";
		if($_REQUEST['segmentAlias']!="")$segment_alias="segment_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['segmentAlias'])."' AND ";else $segment_alias="";
		if($_REQUEST['schedule']!="")$schedule="schedule LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['schedule'])."%' AND ";else $schedule="";
		if($_REQUEST['status']!="")$status="flag = '".mysqli_real_escape_string($mr_con,$_REQUEST['status'])."' AND ";else $status="";
		$condtion=$customer_name.$customer_code.$dispatch.$installation.$segment_alias.$schedule.$status;
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM  ec_customer WHERE $condtion flag IN('0','1')");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT * FROM ec_customer WHERE $condtion flag IN('0','1') LIMIT $offset, $limit");
			$result['customerDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['customerDetails'][$i]['customer_name']=$row['customer_name'];
					$result['customerDetails'][$i]['customer_alias']=$row['customer_alias'];
					$result['customerDetails'][$i]['customer_code']=$row['customer_code'];
					$result['customerDetails'][$i]['customer_id']=$row['customer_id'];
					$result['customerDetails'][$i]['dispatch']=$row['dispatch'];
					$result['customerDetails'][$i]['installation']=$row['installation'];
					$result['customerDetails'][$i]['segment_name']=alias($row['segment_alias'],'ec_segment','segment_alias','segment_name');
					$result['customerDetails'][$i]['segment_code']=alias($row['segment_alias'],'ec_segment','segment_alias','segment_code');
					$result['customerDetails'][$i]['schedule']=$row['schedule'];
					$result['customerDetails'][$i]['status']=$row['flag'];
					$result['customerDetails'][$i]['po_file']=(!empty($row['po_file']) ? baseurl()."images/po_file/".$row['po_file'] : "-");
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
	$result['add'] = grantable('ADD', 'CUSTOMERS', $emp_alias);
	$result['edit'] = grantable('EDIT', 'CUSTOMERS', $emp_alias);
	$result['delete'] = grantable('DELETE', 'CUSTOMERS', $emp_alias);
	$result['view'] = grantable('VIEW', 'CUSTOMERS', $emp_alias);
	$result['export'] = grantable('EXPORT', 'CUSTOMERS', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function customer_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){ $con='';
	if(isset($_REQUEST['product_alias']) && count($_REQUEST['product_alias'])>0){
		$product = implode("|",$_REQUEST['product_alias']);
		$product_arr = $_REQUEST['product_alias'];
		$con .= "product_alias RLIKE '$product' AND ";
	}else{$con .='';}
	if(isset($_REQUEST['status']) && $_REQUEST['status']!=''){
		$con .= "flag = '".$_REQUEST['status']."' AND ";
	}else{$con .='';}
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_customer WHERE $con flag IN('0','1')");
	$colArr=array('Customer Name','Customer Code','Customer Email','Customer Contact','Dispatch','Installation','Schedule','Segment','Product','PO Copy','Status');
	$colArr2=array('customer_name','customer_code','customer_email','customer_contact','dispatch','installation','schedule');
	$filename = 'customer_'.date('d-m-Y H_i_s');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
	$ch = 'A';
	foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
	$ch++;
	}
	$coo=1;
	while($row=mysqli_fetch_array($sql)){ 
		$product_alias=explode(", ",$row['product_alias']);
		$pcnt=count($product_alias);
		for($c=0;$c<$pcnt;$c++){
			$a = (count($product_arr) ? in_array($product_alias[$c],$product_arr) : TRUE);
			if($a){ $coo++;
				for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
					$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$coo, alias($row['segment_alias'],'ec_segment','segment_alias','segment_name'));
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$coo, alias($product_alias[$c],'ec_product','product_alias','product_description'));
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$coo, (!empty($row['po_file']) ? "YES" : "NO"));
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$coo, ($row['flag']=='1' ? "DE" : "")."ACTIVE");
			}
		}
	}
	$objPHPExcel->getActiveSheet()->setTitle('customer');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("../../exports/$filename.xlsx");
	$result['file_name']=$filename;
	$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function product_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$alias = aliasCheck(generateRandomString(),'ec_product','product_alias');
			$product_description = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['product_description'])));
			$battery_rating = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['battery_rating'])));
			$cell_voltage = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['cell_voltage'])));
			$item_code = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['item_code'])));
			$price = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['price'])));
			$weight = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['weight'])));
			if(empty($product_description)){$res="Please Enter Product Description";}
			elseif(empty($battery_rating)){$res="Please Enter Battery Rating";}
			elseif(empty($cell_voltage)){$res="Please Enter Cell Voltage";}
			elseif(empty($item_code)){$res="Please Enter Item Code";}
			elseif(empty($price)){$res="Please Enter Price";}
			elseif(empty($weight)){$res="Please Enter Weight";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_product WHERE product_description='$product_description' AND flag=0");
				if(mysqli_num_rows($q)==0){
				$sql = mysqli_query($mr_con,"INSERT INTO ec_product(product_description,battery_rating,cell_voltage,item_code,price,weight,product_alias,created_date) VALUES('$product_description','$battery_rating','$cell_voltage','$item_code','$price','$weight','$alias','".date('Y-m-d')."')");
			if($sql){
				$action=$product_description." Product Description Created";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				update_fields('serv_eng_status');
				update_fields('manual_status');
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Creating!';}
					}else{$res = 'The Requested Product Description has already exist, Try with other values';}
				}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
			$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
			echo json_encode($result);
}
function product_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$product_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['product_alias']));
			$product_description = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['product_description'])));
			$battery_rating = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['battery_rating'])));
			$cell_voltage = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['cell_voltage'])));
			$item_code = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['item_code'])));
			$price = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['price'])));
			$weight = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['weight'])));
			if(empty($product_description)){$res="Please Enter Product Description";}
			elseif(empty($battery_rating)){$res="Please Enter Battery Rating";}
			elseif(empty($cell_voltage)){$res="Please Enter Cell Voltage";}
			elseif(empty($price)){$res="Please Enter Price";}
			elseif(empty($weight)){$res="Please Enter Weight";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_product WHERE product_description='$product_description' AND product_alias<>'$product_alias' AND flag=0");
				if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"UPDATE ec_product SET product_description='$product_description',battery_rating='$battery_rating',cell_voltage='$cell_voltage',item_code='$item_code',price='$price',weight='$weight' WHERE product_alias='$product_alias' AND flag=0");
			if($sql){
				$action=$product_description." Product Description Updated";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				update_fields('serv_eng_status');
				update_fields('manual_status');
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Updating!';}
		  		}else{$res = 'The Requested Product Code has already exist, Try with other values';}
			}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function product_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$product_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_product WHERE product_alias='$product_alias' AND flag=0");
			if(mysqli_num_rows($sql)>0){
				$row=mysqli_fetch_array($sql);
					$result['product_alias']=$row['product_alias'];
					$result['product_description']=$row['product_description'];
					$result['battery_rating']=$row['battery_rating'];
					$result['cell_voltage']=$row['cell_voltage'];
					$result['item_code']=$row['item_code'];
					$result['price']=$row['price'];
					$result['weight']=$row['weight'];
				$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function product_mul_view(){ global $mr_con;
		$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){
		if($_REQUEST['batteryRating']!="")$battery_rating="battery_rating LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['batteryRating'])."%' AND ";else $battery_rating="";
		if($_REQUEST['productDescription']!="")$product_description="product_description LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['productDescription'])."%' AND ";else $product_description="";
		if($_REQUEST['price']!="")$price="price LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['price'])."%' AND ";else $price="";
		if($_REQUEST['weight']!="")$weight="weight LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['weight'])."%' AND ";else $weight="";
		if($_REQUEST['cellVoltage']!="")$cell_voltage="cell_voltage LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['cellVoltage'])."%' AND ";else $cell_voltage="";
		if($_REQUEST['itemCode']!="")$item_code="item_code LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['itemCode'])."%' AND ";else $item_code="";
		$condtion=$battery_rating.$product_description.$price.$weight.$cell_voltage.$item_code;
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM  ec_product WHERE $condtion flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT * FROM ec_product WHERE $condtion flag=0 LIMIT $offset, $limit");
			$result['productDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['productDetails'][$i]['product_alias']=$row['product_alias'];
					$result['productDetails'][$i]['product_description']=$row['product_description'];
					$result['productDetails'][$i]['battery_rating']=$row['battery_rating'];
					$result['productDetails'][$i]['cell_voltage']=$row['cell_voltage'];
					$result['productDetails'][$i]['item_code']=$row['item_code'];
					$result['productDetails'][$i]['price']=$row['price'];
					$result['productDetails'][$i]['weight']=$row['weight'];
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
	$result['add'] = grantable('ADD', 'PRODUCTS', $emp_alias);
	$result['edit'] = grantable('EDIT', 'PRODUCTS', $emp_alias);
	$result['delete'] = grantable('DELETE', 'PRODUCTS', $emp_alias);
	$result['view'] = grantable('VIEW', 'PRODUCTS', $emp_alias);
	$result['export'] = grantable('EXPORT', 'PRODUCTS', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function product_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_product WHERE flag=0");
		$colArr=array('Product Description','Battery Rating','Item Code','Cell Voltage','Price','Weight');
		$colArr2=array('product_description','battery_rating','item_code','cell_voltage','price','weight');
		$filename = 'Product_'.date('d-m-Y H_i_s');
		$objPHPExcel = new PHPExcel();
	
		$objPHPExcel->setActiveSheetIndex(0);
		$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF'),/*'size'  => 15,'name'  => 'Verdana'*/));
		$ch = 'A';
		foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
		$ch++;
		}
		$coo=1;
		while($row=mysqli_fetch_array($sql)){ $coo++;
			for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
				$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
			}
		}
		$objPHPExcel->getActiveSheet()->setTitle('Product');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save("../../exports/$filename.xlsx");
		$result['file_name']=$filename;
		$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function ticketcomplaint_add(){ 
	global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$alias = aliasCheck(generateRandomString(),'ec_complaint','complaint_alias');
			$complaint_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['complaint_name'])));
			$activity_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['activity_alias'])));
			if(empty($complaint_name)){$res="Please Enter Complaint Name";}
			elseif($activity_alias=='0'){$res="Please Enter Activity Name";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_complaint WHERE complaint_name='$complaint_name' AND flag=0");
				if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"INSERT INTO ec_complaint(complaint_name,complaint_alias,activity_alias,created_date) VALUES('$complaint_name','$alias','$activity_alias','".date('Y-m-d')."')");
			if($sql){
				$action=$complaint_name." Complaint Name Created";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				update_fields('site_details_status');
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Creating!';}
					}else{$res = 'The Requested Complaint Name has already exist, Try with other values';}
				}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
			$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
			echo json_encode($result);
}
function ticket_complaint_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$complaint_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['complaint_alias']));
			$complaint_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['complaint_name'])));
			$activity_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['activity_alias'])));
			if(empty($complaint_name)){$res="Please Enter Complaint Name";}
			elseif($activity_alias=='0'){$res="Please Enter Activity Name";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_complaint WHERE complaint_name='$complaint_name' AND complaint_alias<>'$complaint_alias' AND flag=0");
				if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"UPDATE ec_complaint SET complaint_name='$complaint_name', activity_alias='$activity_alias' WHERE complaint_alias='$complaint_alias' AND flag=0");
			if($sql){
				$action=$complaint_name." Complaint Name Updated";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				update_fields('site_details_status');
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Updating!';}
		  		}else{$res = 'The Requested Complaint Name has already exist, Try with other values';}
			}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function ticket_complaint_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
		$complaint_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
		$sql=mysqli_query($mr_con,"SELECT * FROM ec_complaint WHERE complaint_alias='$complaint_alias' AND flag=0");
		if(mysqli_num_rows($sql)>0){
				$row=mysqli_fetch_array($sql);
					$result['complaint_alias']=$row['complaint_alias'];
					$result['complaint_name']=$row['complaint_name'];
					$result['activity_name']=alias($row['activity_alias'],'ec_activity','activity_alias','activity_name');
					$result['activity_alias']=$row['activity_alias'];
					$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function ticket_complaint_mul_view(){ global $mr_con;
		$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){
		if($_REQUEST['activityAlias']!="")$activity_alias="activity_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['activityAlias'])."' AND ";else $activity_alias="";
		if($_REQUEST['complaintName']!="")$complaint_name="complaint_name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['complaintName'])."%' AND ";else $complaint_name="";
		$condtion=$activity_alias.$complaint_name;
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM  ec_complaint WHERE $condtion flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT complaint_alias,complaint_name,activity_alias FROM ec_complaint WHERE $condtion flag=0 LIMIT $offset, $limit");
			$result['complaintDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['complaintDetails'][$i]['complaint_name']=$row['complaint_name'];
					$result['complaintDetails'][$i]['complaint_alias']=$row['complaint_alias'];
					$result['complaintDetails'][$i]['activity_name']=alias($row['activity_alias'],'ec_activity','activity_alias','activity_name');
					$result['complaintDetails'][$i]['activity_code']=alias($row['activity_alias'],'ec_activity','activity_alias','activity_code');
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
	$result['add'] = grantable('ADD', 'COMPLAINTS', $emp_alias);
	$result['edit'] = grantable('EDIT', 'COMPLAINTS', $emp_alias);
	$result['delete'] = grantable('DELETE', 'COMPLAINTS', $emp_alias);
	$result['view'] = grantable('VIEW', 'COMPLAINTS', $emp_alias);
	$result['export'] = grantable('EXPORT', 'COMPLAINTS', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function ticket_complaint_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_complaint WHERE flag=0");
	$colArr=array('Complaint Name','Activity');
	$colArr2=array('complaint_name');
	$filename = 'TicketComplaint_'.date('d-m-Y H_i_s');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
	$ch = 'A';
	foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
	$ch++;
	}
	$coo=1;
	while($row=mysqli_fetch_array($sql)){ $coo++;
				for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
					$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
		}
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$coo, alias($row['activity_alias'],'ec_activity','activity_alias','activity_name'));
	}
	$objPHPExcel->getActiveSheet()->setTitle('TicketComplaint');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("../../exports/$filename.xlsx");
	$result['file_name']=$filename;
	$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);

}
function faulty_code_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$alias = aliasCheck(generateRandomString(),'ec_faulty_code','faulty_alias');
			$faulty_code = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['faulty_code'])));
			$description = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['description'])));
			if(empty($faulty_code)){$res="Please Enter Faulty Code";}
			elseif(empty($description)){$res="Please Enter Description";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_faulty_code WHERE (faulty_code='$faulty_code' OR description='$description') AND flag=0");
				if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"INSERT INTO ec_faulty_code(faulty_code,description,faulty_alias,created_date)VALUES('$faulty_code','$description','$alias','".date('Y-m-d')."')");
			if($sql){
				$action=$faulty_code." Faulty Code Created";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				update_fields('serv_eng_status');
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Creating!';}
					}else{$res = 'The Requested Faulty Code OR Description has already exist, Try with other values';}
				}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
			$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
			echo json_encode($result);
}
function faulty_code_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$faulty_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['faulty_alias']));
			$faulty_code = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['faulty_code'])));
			$description = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['description'])));
			if(empty($faulty_code)){$res="Please Enter Faulty Code";}
			elseif(empty($description)){$res="Please Enter Description";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_faulty_code WHERE (faulty_code='$faulty_code' OR description='$description') AND faulty_alias<>'$faulty_alias' AND flag=0");
				if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"UPDATE ec_faulty_code SET faulty_code='$faulty_code',description='$description' WHERE faulty_alias='$faulty_alias' AND flag=0");
			if($sql){
				$action=$faulty_code." Faulty Code Updated";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				update_fields('serv_eng_status');
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Updating!';}
		  		}else{$res = 'The Requested Faulty Code OR Description has already exist, Try with other values';}
			}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function faulty_code_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$faulty_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_faulty_code WHERE faulty_alias='$faulty_alias' AND flag=0");
			if(mysqli_num_rows($sql)>0){
				$row=mysqli_fetch_array($sql);
					$result['faulty_code']=$row['faulty_code'];
					$result['description']=$row['description'];
					$result['faulty_alias']=$row['faulty_alias'];
				$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function faulty_code_mul_view(){ global $mr_con;
		$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){
		if($_REQUEST['faultyCode']!="")$faulty_code="faulty_code LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['faultyCode'])."%' AND ";else $faulty_code="";
		if($_REQUEST['description']!="")$description="description LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['description'])."%' AND ";else $description="";
		$condtion=$faulty_code.$description;
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM  ec_faulty_code WHERE $condtion flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT faulty_alias,faulty_code,description FROM ec_faulty_code WHERE $condtion flag=0 LIMIT $offset, $limit");
			$result['faultyDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['faultyDetails'][$i]['faulty_code']=$row['faulty_code'];
					$result['faultyDetails'][$i]['faulty_alias']=$row['faulty_alias'];
					$result['faultyDetails'][$i]['description']=$row['description'];
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
	$result['add'] = grantable('ADD', 'FAULTY CODES', $emp_alias);
	$result['edit'] = grantable('EDIT', 'FAULTY CODES', $emp_alias);
	$result['delete'] = grantable('DELETE', 'FAULTY CODES', $emp_alias);
	$result['view'] = grantable('VIEW', 'FAULTY CODES', $emp_alias);
	$result['export'] = grantable('EXPORT', 'FAULTY CODES', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function faulty_code_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_faulty_code WHERE flag=0");
	$colArr=array('Faulty Code','Description');
	$colArr2=array('faulty_code','description');
	$filename = 'Faultycode_'.date('d-m-Y H_i_s');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
	$ch = 'A';
	foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
	$ch++;
	}
	$coo=1;
	while($row=mysqli_fetch_array($sql)){ $coo++;
				for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
					$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
		}
	}
	$objPHPExcel->getActiveSheet()->setTitle('Faultycode');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("../../exports/$filename.xlsx");
	$result['file_name']=$filename;
	$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);


}
function ticket_activity_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$alias = aliasCheck(generateRandomString(),'ec_activity','activity_alias');
			$activity_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['activity_name'])));
			$activity_code = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['activity_code'])));
			if(empty($activity_name)){$res="Please Enter Activity Name";}
			elseif(empty($activity_code)){$res="Please Enter Activity Code";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_activity WHERE (activity_name='$activity_name' OR activity_code='$activity_code') AND flag=0");
				if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"INSERT INTO ec_activity(activity_name,activity_code,activity_alias,created_date)VALUES('$activity_name','$activity_code','$alias','".date('Y-m-d')."')");
			if($sql){
				$action=$activity_name." Activity Name Created";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				update_fields('site_details_status');
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Creating!';}
					}else{$res = 'The Requested Activity Name OR Activity Code has already exist, Try with other values';}
				}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
			$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
			echo json_encode($result);
}
function ticket_activity_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$activity_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['activity_alias']));
			$activity_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['activity_name'])));
			$activity_code = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['activity_code'])));
			if(empty($activity_name)){$res="Please Enter Activity Name";}
			elseif(empty($activity_code)){$res="Please Enter Activity Code";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_activity WHERE (activity_name='$activity_name' OR activity_code='$activity_code') AND activity_alias<>'$activity_alias' AND flag=0");
				if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"UPDATE ec_activity SET activity_name='$activity_name', activity_code='$activity_code' WHERE activity_alias='$activity_alias' AND flag=0");
			if($sql){
				$action=$activity_name." Activity Name Updated";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				update_fields('site_details_status');
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Updating!';}
		  		}else{$res = 'The Requested Activity Name OR Activity Code has already exist, Try with other values';}
			}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function ticket_activity_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$activity_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_activity WHERE activity_alias='$activity_alias' AND flag=0");
			if(mysqli_num_rows($sql)>0){
				$row=mysqli_fetch_array($sql);
					$result['activity_name']=$row['activity_name'];
					$result['activity_code']=$row['activity_code'];
					$result['activity_alias']=$row['activity_alias'];
				$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function ticket_activity_mul_view(){ global $mr_con;
	 	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){
		if($_REQUEST['activityName']!="")$activity_name="activity_name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['activityName'])."%' AND ";else $activity_name="";
		if($_REQUEST['activityCode']!="")$activity_code="activity_code LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['activityCode'])."%' AND ";else $activity_code="";
		$condtion=$activity_name.$activity_code;
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM  ec_activity WHERE $condtion flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT activity_alias,activity_name,activity_code FROM  ec_activity WHERE $condtion flag=0 LIMIT $offset, $limit");
			$result['activityDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['activityDetails'][$i]['activity_name']=$row['activity_name'];
					$result['activityDetails'][$i]['activity_alias']=$row['activity_alias'];
					$result['activityDetails'][$i]['activity_code']=$row['activity_code'];
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
	$result['add'] = false;
	$result['edit'] = grantable('EDIT', 'ACTIVITIES', $emp_alias);
	$result['delete'] = false;
	$result['view'] = grantable('VIEW', 'ACTIVITIES', $emp_alias);
	$result['export'] = grantable('EXPORT', 'ACTIVITIES', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function ticket_activity_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_activity WHERE flag=0");
	$colArr=array('Activity Name','Activity Code');
	$colArr2=array('activity_name','activity_code');
	$filename = 'TicketActivity_'.date('d-m-Y H_i_s');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
	$ch = 'A';
	foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
	$ch++;
	}
	$coo=1;
	while($row=mysqli_fetch_array($sql)){ $coo++;
				for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
					$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
		}
	}
	$objPHPExcel->getActiveSheet()->setTitle('TicketActivity');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("../../exports/$filename.xlsx");
	$result['file_name']=$filename;
	$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
/*function levels_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$alias = mysqli_real_escape_string($mr_con,trim($_REQUEST['level_alias']));
			$level_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['level_name'])));
			if(empty($level_name)){$res="Please Enter Level Name";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_levels WHERE level_name='$level_name' AND flag=0");
			if(mysqli_num_rows($q)==0){
			$sql=mysqli_query($mr_con,"INSERT INTO ec_levels(level_name,level_alias,created_date) VALUES('$level_name','$alias','".date('Y-m-d')."')");
			if($sql){$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Creating!';}
					}else{$res = 'The Requested Level Name has already exist, Try with other values';}
				}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
			$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
			echo json_encode($result);
}*/
function levels_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$level_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['level_alias']));
			$level_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['level_name'])));
			$level_color = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['level_color'])));
			if(empty($level_name)){$res="Please Enter Level Name";}
			elseif(empty($level_color)){$res="Please Enter Level Color";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_levels WHERE level_name='$level_name' AND level_alias<>'$level_alias' AND flag=0");
			if(mysqli_num_rows($q)==0){
			$sql=mysqli_query($mr_con,"UPDATE ec_levels SET level_name='$level_name',level_color='$level_color' WHERE level_alias='$level_alias' AND flag=0");
			if($sql){
				$action=$level_name." Level Name Updated";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Updating!';}
		  		}else{$res = 'The Requested Level Name has already exist, Try with other values';}
			}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function levels_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$level_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_levels WHERE level_alias='$level_alias' AND flag=0");
			if(mysqli_num_rows($sql)>0){
				$row=mysqli_fetch_array($sql);
					$result['level_name']=$row['level_name'];
					$result['level_alias']=$row['level_alias'];
					$result['level_color']=$row['level_color'];
				$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function levels_mul_view(){ global $mr_con;
		$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){$condtion="";
		if($_REQUEST['levelName']!="")$condtion.="level_name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['levelName'])."%' AND ";else $level_name="";
		if($_REQUEST['levelColor']!="")$condtion.="level_color LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['levelColor'])."%' AND ";else $level_color="";
		$rec=mysqli_query($mr_con,"SELECT COUNT(id) FROM  ec_levels WHERE $condtion flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT level_alias,level_name,level_color FROM ec_levels WHERE $condtion flag=0 LIMIT $offset, $limit");
			$result['levelDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['levelDetails'][$i]['level_name']=$row['level_name'];
					$result['levelDetails'][$i]['level_color']=$row['level_color'];
					$result['levelDetails'][$i]['level_alias']=$row['level_alias'];
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
	$result['add'] = false;
	$result['edit'] = grantable('EDIT', 'LEVELS', $emp_alias);
	$result['delete'] = false;
	$result['view'] = grantable('VIEW', 'LEVELS', $emp_alias);
	$result['export'] = grantable('EXPORT', 'LEVELS', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function level_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_levels WHERE flag=0");
	$colArr=array('Level Name','Level Color');
	$colArr2=array('level_name','level_color');
	$filename = 'Level_'.date('d-m-Y H_i_s');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
	$ch = 'A';
	foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
	$ch++;
	}
	$coo=1;
	while($row=mysqli_fetch_array($sql)){ $coo++;
		for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
			$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
		}
	}
	$objPHPExcel->getActiveSheet()->setTitle('Level');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("../../exports/$filename.xlsx");
	$result['file_name']=$filename;
	$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function assets_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$asset_alias=aliasCheck(generateRandomString(),'ec_assets','asset_alias');
			$asset_type = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['asset_type'])));
			$asset_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['asset_name'])));
			$asset_make = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['asset_make'])));
			$asset_serial_number = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['asset_serial_number'])));
			$specification = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['specification'])));
			$calibration_date = mysqli_real_escape_string($mr_con,dateFormat(trim($_REQUEST['calibration_date']),"y"));
			$calibration_due_date = mysqli_real_escape_string($mr_con,dateFormat(trim($_REQUEST['calibration_due_date']),"y"));
			$nature_of_asset = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['nature_of_asset'])));
			if(empty($asset_type)){$res="Please Enter Asset Type";}
			elseif(empty($asset_name)){$res="Please Enter Asset Name";}
			elseif(empty($asset_make)){$res="Please Enter Asset Make";}
			elseif(empty($asset_serial_number)){$res="Please Enter Asset Serial Number";}
			elseif(empty($specification)){$res="Please Enter Specification";}
			elseif(empty($calibration_date)){$res="Please Enter Calibration Date";}
			elseif(empty($calibration_due_date)){$res="Please Enter Calibration Due Date";}
			elseif(empty($nature_of_asset)){$res="Please Enter Nature Of Asset";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_assets WHERE asset_name='$asset_name' AND flag=0");
			if(mysqli_num_rows($q)==0){
			$sql=mysqli_query($mr_con,"INSERT INTO ec_assets(asset_type,asset_name,asset_make,asset_serial_number,specification,calibration_date,calibration_due_date,nature_of_asset,asset_alias,created_date) VALUES('$asset_type','$asset_name','$asset_make','$asset_serial_number','$specification','$calibration_date','$calibration_due_date','$nature_of_asset','$asset_alias','".date('Y-m-d')."')");
			if($sql){
				$action=$asset_name." Asset Name Created";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
			$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Creating!';}
			}else{$res="The Requested Asset Name has already exist, Try with other values";}
			}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
			echo json_encode($result);
}
function assets_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
				$asset_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['asset_alias']));
				$asset_type = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['asset_type'])));
				$asset_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['asset_name'])));
				$asset_make = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['asset_make'])));
				$asset_serial_number = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['asset_serial_number'])));
				$specification = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['specification'])));
				$calibration_date = mysqli_real_escape_string($mr_con,dateFormat(trim($_REQUEST['calibration_date']),"y"));
				$calibration_due_date = mysqli_real_escape_string($mr_con,dateFormat(trim($_REQUEST['calibration_due_date']),"y"));
				$nature_of_asset = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['nature_of_asset'])));
			if(empty($asset_type)){$res="Please Enter Asset Type";}
			elseif(empty($asset_name)){$res="Please Enter Asset Name";}
			elseif(empty($asset_make)){$res="Please Enter Asset Make";}
			elseif(empty($asset_serial_number)){$res="Please Enter Asset Serial Number";}
			elseif(empty($specification)){$res="Please Enter Specification";}
			elseif(empty($calibration_date)){$res="Please Enter Calibration Date";}
			elseif(empty($calibration_due_date)){$res="Please Enter Calibration Due Date";}
			elseif(empty($nature_of_asset)){$res="Please Enter Nature Of Asset";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_assets WHERE asset_name='$asset_name' AND asset_alias<>'$asset_alias' AND flag=0");
			if(mysqli_num_rows($q)==0){
				$sql=mysqli_query($mr_con,"UPDATE ec_assets SET asset_type='$asset_type',asset_name='$asset_name',asset_make='$asset_make',asset_serial_number='$asset_serial_number',specification='$specification',calibration_date='$calibration_date',calibration_due_date='$calibration_due_date',nature_of_asset='$nature_of_asset' WHERE asset_alias='$asset_alias' AND flag=0");
				if($sql){
					$action=$asset_name." Asset Name Updated";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Updating!';}
		  		}else{$res = 'The Requested Asset Name has already exist, Try with other values';}
			}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function assets_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$asset_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_assets WHERE asset_alias='$asset_alias' AND flag=0");
			if(mysqli_num_rows($sql)>0){
				$row=mysqli_fetch_array($sql);
					$result['asset_type']=$row['asset_type'];
					$result['asset_name']=$row['asset_name'];
					$result['asset_make']=$row['asset_make'];
					$result['asset_alias']=$row['asset_alias'];
					$result['asset_serial_number']=$row['asset_serial_number'];
					$result['specification']=$row['specification'];
					$result['calibration_date']=dateFormat($row['calibration_date'],"d");
					$result['calibration_due_date']=dateFormat($row['calibration_due_date'],"d");
					$result['nature_of_asset']=$row['nature_of_asset'];
				$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function assets_mul_view(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		if($_REQUEST['assetType']!="")$asset_type="asset_type ='".mysqli_real_escape_string($mr_con,$_REQUEST['assetType'])."' AND ";else $asset_type="";
		if($_REQUEST['assetName']!="")$asset_name="asset_name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['assetName'])."%' AND ";else $asset_name="";
		if($_REQUEST['assetAlias']!="")$asset_alias="asset_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['assetAlias'])."' AND ";else $asset_alias="";
		if($_REQUEST['assetMake']!="")$asset_make="asset_make LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['assetMake'])."%' AND ";else $asset_make="";
		if($_REQUEST['assetSerialNumber']!="")$asset_serial_number="asset_serial_number LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['assetSerialNumber'])."%' AND ";else $asset_serial_number="";
		if($_REQUEST['calibrationDate']!="")$calibration_date="calibration_date LIKE '%".mysqli_real_escape_string($mr_con,dateFormat($_REQUEST['calibrationDate'],"y"))."%' AND ";else $calibration_date="";
		if($_REQUEST['calibrationDueDate']!="")$calibration_due_date="calibration_due_date LIKE '%".mysqli_real_escape_string($mr_con,dateFormat($_REQUEST['calibrationDueDate'],"y"))."%' AND ";else $calibration_due_date="";
		if($_REQUEST['natureOfAsset']!="")$nature_of_asset="nature_of_asset ='".mysqli_real_escape_string($mr_con,$_REQUEST['natureOfAsset'])."' AND ";else $nature_of_asset="";
		if($_REQUEST['specification']!="")$specification="specification LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['specification'])."%' AND ";else $specification="";
		$condtion=$asset_type.$asset_name.$asset_alias.$asset_make.$asset_serial_number.$calibration_date.$calibration_due_date.$nature_of_asset.$specification;
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM  ec_assets WHERE $condtion flag=0");
		//echo "SELECT count(id) FROM  ec_assets WHERE $condtion flag=0";
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT asset_alias,asset_type,asset_name,asset_make,asset_serial_number,specification,calibration_date,calibration_due_date,nature_of_asset FROM ec_assets WHERE $condtion flag=0 LIMIT $offset, $limit");
			$result['assetDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['assetDetails'][$i]['asset_type']=$row['asset_type'];
					$result['assetDetails'][$i]['asset_alias']=$row['asset_alias'];
					$result['assetDetails'][$i]['asset_name']=$row['asset_name'];
					$result['assetDetails'][$i]['asset_make']=$row['asset_make'];
					$result['assetDetails'][$i]['asset_serial_number']=$row['asset_serial_number'];
					$result['assetDetails'][$i]['specification']=$row['specification'];
					$result['assetDetails'][$i]['calibration_date']=dateFormat($row['calibration_date'],"d");
					$result['assetDetails'][$i]['calibration_due_date']=dateFormat($row['calibration_due_date'],"d");
					$result['assetDetails'][$i]['nature_of_asset']=$row['nature_of_asset'];
				$i++;}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	$result['add'] = grantable('ADD', 'ASSETS', $emp_alias);
	$result['edit'] = grantable('EDIT', 'ASSETS', $emp_alias);
	$result['delete'] = grantable('DELETE', 'ASSETS', $emp_alias);
	$result['view'] = grantable('VIEW', 'ASSETS', $emp_alias);
	$result['export'] = grantable('EXPORT', 'ASSETS', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function assets_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_assets WHERE flag=0");
	$colArr=array('Asset Type','Asset Name','Asset Make','Asset Serial Number','Specification','Calibration Date','Calibration Due Date','Nature Of Asset');
	$colArr2=array('asset_type','asset_name','asset_make','asset_serial_number','specification','calibration_date','calibration_due_date','nature_of_asset');
	$filename = 'Assets_'.date('d-m-Y H_i_s');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF'),/*'size'  => 15,'name'  => 'Verdana'*/ ));
	$ch = 'A';
	foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
	$ch++;
	}
	$coo=1;
	while($row=mysqli_fetch_array($sql)){ $coo++;
		for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
			$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
		}
	}
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("../../exports/$filename.xlsx");
	$result['file_name']=$filename;
	$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function item_code_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$count = count($_REQUEST['item_code']);
			for($i=0;$i<$count;$i++){
				$item_code_alias = aliasCheck(generateRandomString(),'ec_item_code','item_code_alias');
				$item_code = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['item_code'][$i])));
				$item_description = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['item_description'][$i])));
				$item_type = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['item_type'][$i])));
				$sjo_no = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['sjo_no'])));
				$invoice_no = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['invoice_no'])));
				$invoice_date = mysqli_real_escape_string($mr_con,dateFormat(trim($_REQUEST['invoice_date']),"y"));
				if(empty($item_code)){$res="Please Enter Item Code";}
				if(empty($item_description)){$res="Please Enter Item Description";}
				elseif(empty($sjo_no)){$res="Please Enter SJO Number";}
				elseif(empty($invoice_no)){$res="Please Enter Invoice Number";}
				elseif(empty($invoice_date)){$res="Please Enter Invoice Date";}
				elseif(empty($item_type)){$res="Please Select Item Type";}
				else{
					$q=mysqli_query($mr_con,"SELECT id FROM ec_item_code WHERE item_type='1' AND item_description='$item_description' AND flag=0");
					if(mysqli_num_rows($q)==0){
						$sql = mysqli_query($mr_con,"INSERT INTO ec_item_code(item_code,item_description,sjo_no,invoice_no,invoice_date,item_type,item_code_alias,created_date) VALUES('$item_code','$item_description','$sjo_no','$invoice_no','$invoice_date','$item_type','$item_code_alias','".date('Y-m-d')."')");
						if($sql){
							$action=$item_code." Item Code Created";
							user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
							$resCode='0';$resMsg='Successful!';}else{$res='Error in Creating!';}
					}else{$res='Some Cells with same Cell Number has already exist, Try with other values!';}
				}
			}
			if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function item_code_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$item_code_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['item_code_alias'])));
			$item_code = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['item_code'])));
			$item_description = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['item_description'])));
			$item_type = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['item_type'])));
			$sjo_no = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['sjo_no'])));
			$invoice_no = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['invoice_no'])));
			$invoice_date = mysqli_real_escape_string($mr_con,dateFormat(trim($_REQUEST['invoice_date']),"y"));
			if(empty($item_code)){$res="Please Enter Item Code";}
			elseif(empty($item_description)){$res="Please Enter Item Description";}
			elseif(empty($sjo_no)){$res="Please Enter SJO Number";}
			elseif(empty($invoice_no)){$res="Please Enter Invoice Number";}
			elseif(empty($invoice_date)){$res="Please Enter Invoice Date";}
			elseif(empty($item_type)){$res="Please Enter Item Type";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_item_code WHERE item_type='1' AND item_description='$item_description' AND item_code_alias<>'$item_code_alias' AND flag=0");
				if(mysqli_num_rows($q)==0){
					$sql = mysqli_query($mr_con,"UPDATE ec_item_code SET item_code='$item_code',item_description='$item_description',sjo_no='$sjo_no',invoice_no='$invoice_no',invoice_date='$invoice_date',item_type='$item_type' WHERE item_code_alias='$item_code_alias' AND flag=0");
					if($sql){
						$action=$item_code." Item Code Updated";
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
						$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Updating!';}
				}else{$res = 'Cells with same Cell Number has already exist, Try with other values!';}
			}
			if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function item_code_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$item_code_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
		$sql=mysqli_query($mr_con,"SELECT * FROM ec_item_code WHERE item_code_alias='$item_code_alias' AND flag=0");
		if(mysqli_num_rows($sql)>0){
			$row=mysqli_fetch_array($sql);
				$result['item_description']=$row['item_description'];
				$result['item_type']=($row['item_type']==1 ? "CELLS":"ACCESSORIES");
				$result['item_code_alias']=$row['item_code_alias'];
				$result['item_type_alias']=$row['item_code'];
				if($row['item_type']=="1"){$result['item_code']=alias($row['item_code'],'ec_product','product_alias','product_description');}
				else{$result['item_code']=alias($row['item_code'],'ec_accessories','accessories_alias','accessory_description');}
				$result['sjo_no']=$row['sjo_no'];
				$result['invoice_no']=$row['invoice_no'];
				$result['invoice_date']=dateFormat($row['invoice_date'],"d");
			$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4';$resMsg='No Records Found!';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function item_code_mul_view(){ global $mr_con;
		$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){
		if($_REQUEST['itemType']!="")$item_type="item_type = '".mysqli_real_escape_string($mr_con,$_REQUEST['itemType'])."' AND ";else $item_type="";
		if($_REQUEST['itemDesc']!="")$item_desc="item_description LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['itemDesc'])."%' AND ";else $item_desc="";
		if($_REQUEST['itemCode']!=""){
			$itcx=getproduct_accessoryalias($_REQUEST['itemCode']);
			if($itcx!='0')$item_code="item_code IN (".$itcx.") AND ";else $item_code="item_code ='' AND ";
		}else $item_code="";
		if($_REQUEST['sjoNo']!="")$sjo_no="sjo_no LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['sjoNo'])."%' AND ";else $sjo_no="";
		//$siteCondition=$item_code;
		$condtion=$item_type.$item_desc.$sjo_no.$item_code;
		//echo "SELECT count(id) FROM ec_item_code WHERE $condtion flag=0";
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_item_code WHERE $condtion flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="" && $_REQUEST['page_no']!="? string:2 ?")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			//echo $limit."-".$pageNo."-".$totalpages."-".$offset;
			$sql = mysqli_query($mr_con,"SELECT * FROM ec_item_code WHERE $condtion flag=0 LIMIT $offset, $limit");
			$result['itemDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['itemDetails'][$i]['item_type']=($row['item_type']==1 ? "CELLS":"ACCESSORIES");
					if($row['item_type']=="2"){
						$result['itemDetails'][$i]['item_code']=alias($row['item_code'],'ec_accessories','accessories_alias','accessory_description');
						$result['itemDetails'][$i]['item_desc']=$row['item_description'];

					}
					if($row['item_type']=="1"){
						$result['itemDetails'][$i]['item_code']=alias($row['item_code'],'ec_product','product_alias','product_description');
						$result['itemDetails'][$i]['item_desc']=$row['item_description'];
					}
					$result['itemDetails'][$i]['sjo_no']=$row['sjo_no'];
					$result['itemDetails'][$i]['item_code_alias']=$row['item_code_alias'];
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
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function item_code_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_item_code WHERE flag=0");
		$colArr=array('Item Type','Item Description','Item Price','Sjo No','Invoice No','Item Code');
		$colArr2=array('item_type','item_description','item_price','sjo_no','invoice_no');
		$filename = 'item_code_'.date('d-m-Y H_i_s');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
		$ch = 'A';
		foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$ch++;
		}
		$coo=1;
		while($row=mysqli_fetch_array($sql)){$coo++;
			for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++)$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
			$item_code=($row['item_type']==1 ? alias($row['item_code'],'ec_product','product_alias','item_code') : alias($row['item_code'],'ec_accessories','accessories_alias','item_code'));
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$coo, $item_code);
		}
		$objPHPExcel->getActiveSheet()->setTitle('Item Code');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save("../../exports/$filename.xlsx");
		$result['file_name']=$filename;
		$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function privileges_init(){ 
	global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$prv_arr=array("DASH BOARD","PLANNER","SPOT TICKETS","TICKETS","SITEMASTER","EMPLOYEE MASTER","EXPENSE TRACKER","FIELD ASSET MANAGEMENT","TRACKING SYSTEM","DYNAMIC TABS","IMEI ACT DEACT", "MASTERS", "SETTINGS", "PASSWORD MANAGEMENT");
		$dash_arr=array("TICKET STATUS","CUSTOMER PULSE","TODAYS INFO REPORT BLOCK","TAT","MONTHLY ANALYSIS","NATURE OF ACTIVITY","FAULT ANALYSIS","PRODUCT CONTRIBUTION IN FAILURE","MANUFACTURE MONTH WISE FAILURE");
		$fam_arr=array("MATERIAL BALANCE","MATERIAL INWARD","MATERIAL OUTWARD","MATERIAL REQUEST","REVIVAL","REFRESHING","SJO SEARCH","STOCKS");
		$settingsArr = array("EMAIL & SMS RECIPIENT", "BUCKETS","EMPLOYEE ROLES", "LEVELS", "PRIVACY POLICY", "DROPDOWNS", "SEGMENTS", "STOCK CODES");
		$mastersArr = array("ACCESSORIES", "ALLOWANCES", "APPROVERS", "ASSETS", "COMPLAINTS", "CUSTOMERS", "DEPARTMENTS", "DESIGNATIONS", "DISTRICTS", "DPR CATEGORIES",   "ESCA", "FAULTY CODES", "LIMITS", "MILESTONES", "MOC", "PRIVILEGES", "PRODUCTS", "SITE TYPES", "STATES", "SHIFTS", "WAREHOUSES", "WORK GUIDES", "ZONES", "ACTIVITIES",  "CHANGE LOG", "DYNAMIC LEVELS", "MANUALS");
		foreach($prv_arr as $prv){
			if($prv=="DASH BOARD")$head=array("PRIVILEGE ITEM","VIEW","SPECIAL");
			elseif($prv=="SPOT TICKETS")$head=array("PRIVILEGE ITEM","VIEW","EDIT","EXPORT","SPECIAL", "DELETE");
			elseif($prv=="TICKETS")$head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","EXPORT","PD","ZHS","NHS","TS","SPECIAL", "DELETE", "TRANSFER EFSR");
			elseif($prv=="TRACKING SYSTEM")$head=array("PRIVILEGE ITEM","VIEW","VIEW ALL","EXPORT","SPECIAL");
			elseif($prv=="FIELD ASSET MANAGEMENT")$head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","EXPORT","SPECIAL","STOCK","DELETE", "ADV EDIT");
			elseif($prv=="DYNAMIC TABS")$head=array("PRIVILEGE ITEM","TICKETS","APPROVALS","DPR","SPECIAL");
			elseif($prv=="IMEI ACT DEACT")$head=array("PRIVILEGE ITEM","VIEW","ACTIVATION","DEACTIVATION","EXPORT","SPECIAL");
			elseif($prv=="EMPLOYEE MASTER")$head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","EXPORT","SPECIAL","DELETE", "RESTORE");
			elseif($prv=="SITEMASTER")$head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT", "IMPORT", "EXPORT","SPECIAL","DELETE", "RESTORE");
			elseif($prv=="PLANNER")$head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","EXPORT","SPECIAL","DELETE");
			elseif($prv=="REVIVAL")$head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","EXPORT","SPECIAL","DELETE");
			elseif($prv=="REFRESHING")$head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","EXPORT","SPECIAL","DELETE");
			elseif($prv=="EXPENSE TRACKER")$head=array("PRIVILEGE ITEM","VIEW","VIEW ALL","ADD","EDIT","EXPORT","SPECIAL","DELETE", "MAPPING");
			elseif($prv=="STOCKS")$head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","EXPORT","SPECIAL","DELETE");
			elseif($prv=="SETTINGS")$head=array("PRIVILEGE ITEM","VIEW","EDIT","EXPORT");
			elseif($prv=="MASTERS")$head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","EXPORT","DELETE");
			elseif($prv=="PASSWORD MANAGEMENT")$head=array("PRIVILEGE ITEM","SPCL");
			else $head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","EXPORT"); 
			//REMAINING_All
			if($prv=="DASH BOARD"){
				foreach($dash_arr as $b=>$dash){
					$result[$prv]['sub'][$b]=$dash;
					$result[$prv]['head']=$head;
				}
			} elseif($prv=="FIELD ASSET MANAGEMENT") {
				foreach($fam_arr as $c=>$fam) {
					$result[$prv]['sub'][$c]=$fam;
					$result[$prv]['head']=$head;
				}
			} elseif($prv=="SETTINGS") {
				foreach($settingsArr as $c=>$setting) {
					$result[$prv]['sub'][$c]=$setting;
					$result[$prv]['head']=$head;
				}
			} elseif($prv=="MASTERS") {
				foreach($mastersArr as $c=>$master) {
					$result[$prv]['sub'][$c]=$master;
					$result[$prv]['head']=$head;
				}
			} else {
				$result[$prv]['sub'][0]=$prv;
				$result[$prv]['head']=$head;
			}
		}
	}
	elseif($chk==1){$result['ErrorDetails']['ErrorCode']='1';$result['ErrorDetails']['ErrorMessage']='Authentication Failed!';}
	else{$result['ErrorDetails']['ErrorCode']='2';$result['ErrorDetails']['ErrorMessage']='Account Locked!';}
	echo json_encode($result);
}
function privileges_add(){ 
	global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$privilege_name=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['privilege_name'])));
		if(empty($privilege_name)){$res="Please Enter Privilege name";}
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_privileges WHERE privilege_name='$privilege_name' AND flag=0");
			if(mysqli_num_rows($q)==0){ $arr_insert=array();
				$privilege_value=$_REQUEST['privilege_value'];
				$alias = aliasCheck(generateRandomString(),'ec_privileges','privilege_alias');
				foreach($privilege_value as $priv_val){
					list($item,$type,$grant)=explode("-",$priv_val);
					$arr_insert[]="('$privilege_name','$item','$type','$grant','$alias')";
				}
				if(count($arr_insert))$sql=mysqli_query($mr_con,"INSERT INTO ec_privileges(privilege_name,privilege_item,privilege_type,grantable,privilege_alias) VALUES ".implode(",",$arr_insert)."");
				if($sql){
					$action=$privilege_name." Privilege name Created";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$result['ErrorDetails']['ErrorCode']='0';$result['ErrorDetails']['ErrorMessage']='Successfull!';
				}else{$res="Error Occured";}
			}else{$res="The Requested Role Name has already exist, Try with other values";}
		}if(isset($res)){$result['ErrorDetails']['ErrorCode']='4';$result['ErrorDetails']['ErrorMessage']=$res;}
	}elseif($chk==1){$result['ErrorDetails']['ErrorCode']='1';$result['ErrorDetails']['ErrorMessage']='Authentication Failed!';}
	else{$result['ErrorDetails']['ErrorCode']='2';$result['ErrorDetails']['ErrorMessage']='Account Locked!';}
	echo json_encode($result);
}
function privileges_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$privilege_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['privilege_alias']));
		$privilege_name=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['privilege_name'])));
		if(empty($privilege_name)){$res="Please Enter Privilege name";}
		else{
			$p=mysqli_query($mr_con,"SELECT id FROM ec_privileges WHERE privilege_name='$privilege_name' AND privilege_alias<>'$privilege_alias' AND flag=0");
			if(mysqli_num_rows($p)==0){
				$privilege_value=$_REQUEST['privilege_value'];
				foreach($privilege_value as $priv_val){
					list($item,$type,$grant)=explode("-",$priv_val);
					$sql=mysqli_query($mr_con,"UPDATE ec_privileges SET privilege_name='$privilege_name',grantable='$grant' WHERE privilege_alias='$privilege_alias' AND privilege_item='$item' AND privilege_type='$type' AND flag=0");
				}
				if($sql){
					$dism=mysqli_query($mr_con,"SELECT mrf_alias,status FROM ec_material_request WHERE status IN('1','2','7') AND flag=0");
					if(mysqli_num_rows($dism)){ $disr=mysqli_fetch_array($dism);
						if(($disr['status']=='1' || $disr['status']=='7') && empty(next_dynamic($disr['mrf_alias'],'E')))$disu=mysqli_query($mr_con,"UPDATE ec_material_request SET status='2' WHERE mrf_alias='".$disr['mrf_alias']."' AND flag=0");
						//if($disr['status']=='2' && !empty(next_dynamic($disr['mrf_alias'],'E')))$disu=mysqli_query($mr_con,"UPDATE ec_material_request SET status='1' WHERE mrf_alias='".$disr['mrf_alias']."' AND flag=0");
					}
					$action=$privilege_name." Privilege name Updated";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$result['ErrorDetails']['ErrorCode']='0';$result['ErrorDetails']['ErrorMessage']='Successfull!';
				}else{$res="Error In Update";}
			}else{$res=$privilege_name."The Requested Role Name is already exist, Try with other Name".$privilege_alias;}
		}
		if(isset($res)){$result['ErrorDetails']['ErrorCode']='4';$result['ErrorDetails']['ErrorMessage']=$res;}
	}elseif($chk==1){$result['ErrorDetails']['ErrorCode']='1';$result['ErrorDetails']['ErrorMessage']='Authentication Failed!';}
	else{$result['ErrorDetails']['ErrorCode']='2';$result['ErrorDetails']['ErrorMessage']='Account Locked!';}
	echo json_encode($result);
}
function privileges_mul_view(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		if($_REQUEST['privilegeName']!="")$privilege_name="privilege_name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['privilegeName'])."%' AND ";else $privilege_name="";
		$condtion=$privilege_name;
		$query = "SELECT count(id) FROM ec_privileges WHERE $condtion flag=0 GROUP BY privilege_name";
		$rec=mysqli_query($mr_con, $query);
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords= mysqli_num_rows($rec);
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT privilege_name, privilege_alias, can_delete FROM ec_privileges WHERE $condtion flag=0 GROUP BY privilege_alias ORDER BY privilege_name LIMIT $offset, $limit");
			$result['privilegeDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;
				while($row = mysqli_fetch_array($sql)){
					$result['privilegeDetails'][$i]['privilege_name']=$row['privilege_name'];
					$result['privilegeDetails'][$i]['privilege_alias']=$row['privilege_alias'];
					$result['privilegeDetails'][$i]['can_delete']=$row['can_delete'];
					$i++;
				}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	$result['add'] = grantable('ADD', 'PRIVILEGES', $emp_alias);
	$result['edit'] = grantable('EDIT', 'PRIVILEGES', $emp_alias);
	$result['delete'] = grantable('DELETE', 'PRIVILEGES', $emp_alias);
	$result['view'] = grantable('VIEW', 'PRIVILEGES', $emp_alias);
	$result['export'] = grantable('EXPORT', 'PRIVILEGES', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function privileges_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$privilege_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
		$sql=mysqli_query($mr_con,"SELECT privilege_name,privilege_alias, privilege_item, privilege_type, grantable FROM ec_privileges WHERE privilege_alias='$privilege_alias' AND flag='0' ORDER BY privilege_item");
		while($row=mysqli_fetch_array($sql)){
			$result['name']=$row['privilege_name'];
			$result['alias']=$row['privilege_alias'];
			$result[$row['privilege_item']][$row['privilege_type']]=$row['grantable'];
		}$resCode='0'; $resMsg='Successful!';
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function privileges_export(){
	 global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_privileges WHERE flag=0");
		$colArr=array('Privilege Name','Privilege Item','Privilege Type','Grantable');
		$colArr2=array('privilege_name','privilege_item','privilege_type','grantable');
		$filename = 'Privileges_'.date('d-m-Y H_i_s');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
		$ch = 'A';
		foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$ch++;
		}
		$coo=1;
		while($row=mysqli_fetch_array($sql)){$coo++;
			for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
				$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
			}
		}
		$objPHPExcel->getActiveSheet()->setTitle('Privileges');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save("../../exports/$filename.xlsx");
		$result['file_name']=$filename;
		$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function sitetype_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$site_type_alias = aliasCheck(generateRandomString(),'ec_site_type','site_type_alias');
			$site_type= strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['site_type'])));
			$segment_alias= strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['segment_alias'])));
			if(empty($site_type)){$res="Please Enter Site Type";}
			elseif(empty($segment_alias)){$res="Please Enter Segment Name";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_site_type WHERE (segment_alias='$segment_alias' AND site_type='$site_type') AND flag=0");
				if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"INSERT INTO ec_site_type(site_type,segment_alias,site_type_alias,created_date) VALUES('$site_type','$segment_alias','$site_type_alias','".date('Y-m-d')."')");
			if($sql){
				$action=$site_type." Site Type Created";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Creating!';}
					}else{$res = 'The Requested Segment Name and Site type has already exist, Try with other values';}
				}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
			$result['ErrorDetails']['ErrorCode']=$resCode; 
			$result['ErrorDetails']['ErrorMessage']=$resMsg;
			echo json_encode($result);
}
function sitetype_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$site_type_alias = mysqli_real_escape_string($mr_con,trim($_REQUEST['site_type_alias']));
			$site_type = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['site_type'])));
			$segment_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['segment_alias'])));
			if(empty($site_type)){$res="Please Enter Site Type";}
			elseif(empty($segment_alias)){$res="Please Enter Segment Name";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_site_type WHERE (segment_alias='$segment_alias' AND site_type='$site_type') AND site_type_alias<>'$site_type_alias' AND flag=0");
				if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"UPDATE ec_site_type SET site_type='$site_type',segment_alias='$segment_alias' WHERE site_type_alias='$site_type_alias' AND flag=0");
			if($sql){
				$action=$site_type." Site Type Updated";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Updating!';}
		  		}else{$res = 'The Requested Segment Name and Site Type has already exist, Try with other values';}
			}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);

}
function sitetype_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$site_type_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_site_type WHERE site_type_alias='$site_type_alias' AND flag=0");
			if(mysqli_num_rows($sql)>0){
				$row=mysqli_fetch_array($sql);
					$result['site_type_alias']=$row['site_type_alias'];
					$result['site_type']=$row['site_type'];
					$result['segment_name']=alias($row['segment_alias'],'ec_segment','segment_alias','segment_name');
					$result['segment_alias']=$row['segment_alias'];
				$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function sitetype_mul_view(){ global $mr_con;
		$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){
		if($_REQUEST['sitetypeAlias']!="")$sitetype_alias="site_type_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['sitetypeAlias'])."' AND ";else $site_type_alias="";
		if($_REQUEST['siteType']!="")$site_type="site_type LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['siteType'])."%' AND ";else $site_type="";
		if($_REQUEST['segmentAlias']!="")$segment_alias="segment_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['segmentAlias'])."' AND ";else $segment_alias="";
		$condtion=$segment_alias.$site_type;
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM  ec_site_type WHERE $condtion flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT site_type,segment_alias,site_type_alias FROM ec_site_type WHERE $condtion flag=0 LIMIT $offset, $limit");
			$result['sitetypeDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['sitetypeDetails'][$i]['site_type']=$row['site_type'];
					$result['sitetypeDetails'][$i]['site_type_alias']=$row['site_type_alias'];
					$result['sitetypeDetails'][$i]['segment_name']=alias($row['segment_alias'],'ec_segment','segment_alias','segment_name');
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
	$result['add'] = grantable('ADD', 'SITE TYPES', $emp_alias);
	$result['edit'] = grantable('EDIT', 'SITE TYPES', $emp_alias);
	$result['delete'] = grantable('DELETE', 'SITE TYPES', $emp_alias);
	$result['view'] = grantable('VIEW', 'SITE TYPES', $emp_alias);
	$result['export'] = grantable('EXPORT', 'SITE TYPES', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function sitetype_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
	$sql = mysqli_query($mr_con,"SELECT * FROM  ec_site_type WHERE flag=0");
	$colArr=array('Site Type','Segment');
	$colArr2=array('site_type');
	$filename = 'Sitetype_'.date('d-m-Y H_i_s');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
	$ch = 'A';
	foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
	$ch++;
	}
	$coo=1;
	while($row=mysqli_fetch_array($sql)){ $coo++;
				for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
					$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
		}
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$coo, alias($row['segment_alias'],'ec_segment','segment_alias','segment_name'));
	}
	$objPHPExcel->getActiveSheet()->setTitle('Sitetype');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("../../exports/$filename.xlsx");
	$result['file_name']=$filename;
	$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function sitestatus_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$site_status_alias = aliasCheck(generateRandomString(),'ec_site_status','site_status_alias');
			$site_status= strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['site_status'])));
			if(empty($site_status)){$res="Please Enter Site Status";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_site_status WHERE site_status='$site_status' AND flag=0");
				if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"INSERT INTO ec_site_status(site_status,site_status_alias,created_date) VALUES('$site_status','$site_status_alias','".date('Y-m-d')."')");
			if($sql){
				$action=$site_status." Site Status Created";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Creating!';}
					}else{$res = 'The Requested Site status has already exist, Try with other values';}
				}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
			$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
			echo json_encode($result);
}
function sitestatus_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$site_status_alias = mysqli_real_escape_string($mr_con,trim($_REQUEST['site_status_alias']));
			$site_status = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['site_status'])));
			if(empty($site_status)){$res="Please Enter Site Status";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_site_status WHERE site_status='$site_status' AND site_status_alias<>'$site_status_alias' AND flag=0");
				if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"UPDATE ec_site_status SET site_status='$site_status' WHERE site_status_alias='$site_status_alias' AND flag=0");
			if($sql){
				$action=$site_status." Site Status Updated";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Updating!';}
		  		}else{$res = 'The Requested Site Status has already exist, Try with other values';}
			}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);

}
function sitestatus_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$site_status_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_site_status WHERE site_status_alias='$site_status_alias' AND flag=0");
			if(mysqli_num_rows($sql)>0){
				$row=mysqli_fetch_array($sql);
					$result['site_status_alias']=$row['site_status_alias'];
					$result['site_status']=$row['site_status'];
				$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function sitestatus_mul_view(){ global $mr_con;
		$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){
		if($_REQUEST['sitestatusAlias']!="")$site_status_alias="site_status_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['sitestatusAlias'])."' AND ";else $site_status_alias="";
		if($_REQUEST['siteStatus']!="")$site_status="site_status LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['siteStatus'])."%' AND ";else $site_status="";
		$condtion=$site_status;
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM  ec_site_status WHERE $condtion flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT site_status,site_status_alias FROM ec_site_status WHERE $condtion flag=0 LIMIT $offset, $limit");
			$result['sitestatusDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['sitestatusDetails'][$i]['site_status']=$row['site_status'];
					$result['sitestatusDetails'][$i]['site_status_alias']=$row['site_status_alias'];
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
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function sitestatus_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
	$sql = mysqli_query($mr_con,"SELECT * FROM  ec_site_status WHERE flag=0");
	$colArr=array('Site Status');
	$colArr2=array('site_status');
	$filename = 'Sitestatus_'.date('d-m-Y H_i_s');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
	$ch = 'A';
	foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
	$ch++;
	}
	$coo=1;
	while($row=mysqli_fetch_array($sql)){ $coo++;
				for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
					$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
		}
	}
	$objPHPExcel->getActiveSheet()->setTitle('Sitestatus');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("../../exports/$filename.xlsx");
	$result['file_name']=$filename;
	$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function accessories_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$alias = aliasCheck(generateRandomString(),'ec_accessories','accessories_alias');
		$item_code = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['item_code'])));
		$accessory_description = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['accessory_description'])));
		$measurement = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['measurement'])));
		//$product_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['product_alias'])));
		$price = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['price'])));
		$weight = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['weight'])));
		if(empty($item_code)){$res="Please Enter Item Code";}
		elseif(empty($accessory_description)){echo "Please Enter Description";}
		elseif(empty($measurement)){echo "Please Select Measurement";}
		//elseif(empty($product_alias)){echo "Please Choose Product";}
		elseif($price==""){echo "Please Enter Price";}
		elseif($weight==""){echo "Please Enter Weight";}
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_accessories WHERE (item_code='$item_code' OR accessory_description='$accessory_description') AND flag=0");
			if(mysqli_num_rows($q)==0){
				$sql = mysqli_query($mr_con,"INSERT INTO ec_accessories(accessories_alias,item_code,accessory_description,measurement,price,weight,created_date) VALUES('$alias','$item_code','$accessory_description','$measurement','$price','$weight','".date('Y-m-d')."')");
				if($sql){
					update_fields('serv_eng_status');
					$action=$accessory_description." Description Created";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$resCode='0';$resMsg='Successful!';
				}else{$resCode='4';$resMsg='Error in Creating!';}
			}else{$res = 'The Requested Item Code OR Accessory Description has already exist, Try with other values';}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function accessories_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$accessories_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['accessories_alias']));
		$item_code = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['item_code'])));
		$accessory_description = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['accessory_description'])));
		$measurement = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['measurement'])));
		//$product_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['product_alias'])));
		$price = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['price'])));
		$weight = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['weight'])));
		if(empty($item_code)){$res="Please Enter Item Code";}
		elseif(empty($accessory_description)){echo "Please Enter Description";}
		elseif(empty($measurement)){echo "Please Select Measurement";}
		//elseif(empty($product_alias)){echo "Please Choose Product";}
		elseif($price==""){echo "Please Enter Price";}
		elseif($weight==""){echo "Please Enter Weight";}
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_accessories WHERE (item_code='$item_code' OR accessory_description='$accessory_description') AND accessories_alias<>'$accessories_alias' AND flag=0");
			if(mysqli_num_rows($q)==0){
				$sql = mysqli_query($mr_con,"UPDATE ec_accessories SET item_code='$item_code',accessory_description='$accessory_description',measurement='$measurement',price='$price',weight='$weight' WHERE accessories_alias='$accessories_alias' AND flag=0");
				if($sql){
					update_fields('serv_eng_status');
					$action=$accessory_description." Description Updated";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$resCode='0';$resMsg='Successful!';
				}else{$resCode='4';$resMsg='Error in Updating!';}
			}else{$res = 'The Requested Item Code OR Accessory Description has already exist, Try with other values';}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function accessories_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$accessories_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_accessories WHERE accessories_alias='$accessories_alias' AND flag=0");
			if(mysqli_num_rows($sql)>0){
				$row=mysqli_fetch_array($sql);
					$result['accessories_alias']=$row['accessories_alias'];
					$result['item_code']=$row['item_code'];
					$result['accessory_description']=$row['accessory_description'];
					$result['measurement']=$row['measurement'];
					//$result['product_alias']=$row['product_alias'];
					//$result['product_description']=alias($row['product_alias'],'ec_product','product_alias','product_description');
					$result['price']=$row['price'];
					$result['weight']=$row['weight'];
				$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function accessories_mul_view(){ 
	global $mr_con;
		$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){
		if($_REQUEST['itemDescription']!="")$accessory_description="accessory_description LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['itemDescription'])."%' AND ";else $accessory_description="";
		//if($_REQUEST['productAlias']!="")$product_alias="product_description LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['productAlias'])."%' AND ";else $product_alias="";
		if($_REQUEST['measurement']!="")$measurement="measurement='".mysqli_real_escape_string($mr_con,$_REQUEST['measurement'])."' AND ";else $measurement="";
		if($_REQUEST['Price']!="")$price="price LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['Price'])."%' AND ";else $price="";
		if($_REQUEST['Weight']!="")$weight="weight LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['Weight'])."%' AND ";else $weight="";
		if($_REQUEST['itemCode']!="")$item_code="item_code LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['itemCode'])."%' AND ";else $item_code="";
		$condtion=$accessory_description.$measurement.$price.$weight.$item_code;
		$rec=mysqli_query($mr_con,"SELECT COUNT(id) FROM ec_accessories WHERE $condtion flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT * FROM ec_accessories WHERE $condtion flag=0 LIMIT $offset, $limit");
			$result['accessoriesDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['accessoriesDetails'][$i]['accessories_alias']=$row['accessories_alias'];
					$result['accessoriesDetails'][$i]['item_code']=$row['item_code'];
					$result['accessoriesDetails'][$i]['accessory_description']=$row['accessory_description'];
					$result['accessoriesDetails'][$i]['measurement']=$row['measurement'];
					//$result['accessoriesDetails'][$i]['product_description']=alias($row['product_alias'],'ec_product','product_alias','product_description');
					$result['accessoriesDetails'][$i]['price']=$row['price'];
					$result['accessoriesDetails'][$i]['weight']=$row['weight'];
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
	$result['add'] = grantable('ADD', 'ACCESSORIES', $emp_alias);
	$result['edit'] = grantable('EDIT', 'ACCESSORIES', $emp_alias);
	$result['delete'] = grantable('DELETE', 'ACCESSORIES', $emp_alias);
	$result['view'] = grantable('VIEW', 'ACCESSORIES', $emp_alias);
	$result['export'] = grantable('EXPORT', 'ACCESSORIES', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function accessories_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$sql = mysqli_query($mr_con,"SELECT * FROM  ec_accessories WHERE flag=0");
		$colArr=array('Item Code','Accessory Description','Measurement','Price','Weight');
		$colArr2=array('item_code','accessory_description','measurement','price','weight');
		$filename = 'Accessories_'.date('d-m-Y H_i_s');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
		$ch = 'A';
		foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$ch++;
		}$coo=1;
		while($row=mysqli_fetch_array($sql)){ $coo++;
			for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
				$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
			}//$objPHPExcel->getActiveSheet()->SetCellValue('E'.$coo, alias($row['product_alias'],'ec_product','product_alias','product_description'));
		}
		$objPHPExcel->getActiveSheet()->setTitle('Accessories');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save("../../exports/$filename.xlsx");
		$result['file_name']=$filename;
		$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function accessories_check_delete_status() {

	global $mr_con;
	global $maxCount;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			// TODO:: Need to add additional checks
			$query = "SELECT mreq.mrf_number FROM ec_accessories as acc, 
			ec_request_items as reqi, ec_material_request as mreq where
			acc.accessories_alias = '$alias' and acc.flag = 0
			and acc.accessories_alias = reqi.item_description and reqi.flag = 0		
			and reqi.mrf_alias = mreq.mrf_alias and mreq.flag = 0";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$mrf_numbers = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$mrf_numbers[] = $row['mrf_number'];
				}
				$res = buildRes("This accessory is already using in material request ", $mrf_numbers);
			} else {
			$query = "SELECT tkts.ticket_id FROM ec_accessories as acc, 
			ec_total_accessories as tacc, ec_material_received_details as rd,
			ec_material_request as mr, ec_tickets as tkts
			WHERE acc.accessories_alias = '$alias' and tacc.item_code = acc.accessories_alias and rd.item_description = tacc.acc_alias and mr.mrf_alias = rd.reference and tkts.ticket_alias = mr.ticket_alias";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['ticket_id'];
				}
				$res = buildRes("This accessory is already using in tickets ", $names);
			}
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function accessories_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$name = alias($alias,'ec_accessories','accessories_alias','accessory_description');
			$action = "Deleted Accessory - $name";
			$status = deleteSettingItem('ec_accessories', 'accessories_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete accessory";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function milestone_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$alias = aliasCheck(generateRandomString(),'ec_milestone','mile_stone_alais');
		$mile_stone = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['mile_stone'])));
		if(empty($mile_stone)){$res="Please Enter Mile Stone";}
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_milestone WHERE mile_stone='$mile_stone' AND flag=0");
			if(mysqli_num_rows($q)==0){
				$sql = mysqli_query($mr_con,"INSERT INTO ec_milestone(mile_stone_alais,mile_stone,created_date) VALUES('$alias','$mile_stone','".date('Y-m-d')."')");
				if($sql){
					$action=$mile_stone." Mile Stone Created";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					update_fields('zhs_status');
					$resCode='0';$resMsg='Successful!';
				}else{$resCode='4';$resMsg='Error in Creating!';}
			}else{$res = 'The Requested Item Code has already exist, Try with other values';}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function milestone_update(){ global $mr_con;
		$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$mile_stone_alais=mysqli_real_escape_string($mr_con,trim($_REQUEST['mile_stone_alais']));
			$mile_stone = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['mile_stone'])));
			if(empty($mile_stone)){$res="Please Enter Mile Stone";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_milestone WHERE mile_stone='$mile_stone' AND mile_stone_alais<>'$mile_stone_alais' AND flag=0");
				if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"UPDATE ec_milestone SET mile_stone='$mile_stone' WHERE mile_stone_alais='$mile_stone_alais' AND flag=0");
			if($sql){
				$action=$mile_stone." Mile Stone Updated";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				update_fields('zhs_status');
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Updating!';}
		  		}else{$res = 'The Requested Item Code has already exist, Try with other values';}
			}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}

function milestone_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$mile_stone_alais=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_milestone WHERE mile_stone_alais='$mile_stone_alais' AND flag=0");
			if(mysqli_num_rows($sql)>0){
				$row=mysqli_fetch_array($sql);
					$result['mile_stone_alais']=$row['mile_stone_alais'];
					$result['mile_stone']=$row['mile_stone'];
				$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function milestone_mul_view(){ global $mr_con;
		$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){
		if($_REQUEST['mileStone']!="")$mile_stone="mile_stone LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['mileStone'])."%' AND ";else $mile_stone="";
		$condtion=$mile_stone;
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM  ec_milestone WHERE $condtion flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT mile_stone_alais,mile_stone FROM ec_milestone WHERE $condtion flag=0 LIMIT $offset, $limit");
			$result['milestoneDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['milestoneDetails'][$i]['mile_stone_alais']=$row['mile_stone_alais'];
					$result['milestoneDetails'][$i]['mile_stone']=$row['mile_stone'];
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
	$result['add'] = grantable('ADD', 'MILESTONES', $emp_alias);
	$result['edit'] = grantable('EDIT', 'MILESTONES', $emp_alias);
	$result['delete'] = grantable('DELETE', 'MILESTONES', $emp_alias);
	$result['view'] = grantable('VIEW', 'MILESTONES', $emp_alias);
	$result['export'] = grantable('EXPORT', 'MILESTONES', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function milestone_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
	$sql = mysqli_query($mr_con,"SELECT * FROM  ec_milestone WHERE flag=0");
	$colArr=array('Mile Stone');
	$colArr2=array('mile_stone');
	$filename = 'Milestone_'.date('d-m-Y H_i_s');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
	$ch = 'A';
	foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
	$ch++;
	}
	$coo=1;
	while($row=mysqli_fetch_array($sql)){ $coo++;
				for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
					$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
		}
	}
	$objPHPExcel->getActiveSheet()->setTitle('Milestone');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("../../exports/$filename.xlsx");
	$result['file_name']=$filename;
	$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function esca_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$esca_alias = aliasMulCheck(generateRandomString());
			$esca_id = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['esca_id'])));
			$esca_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['esca_name'])));
			$password = mysqli_real_escape_string($mr_con,trim($_REQUEST['password']));
			$esca_number = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['esca_number'])));
			$esca_email = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['esca_email'])));
			if(isset($_REQUEST['zone_alias'])){$zone = implode(", ",$_REQUEST['zone_alias']);}else{$zone = '';}
			if(isset($_REQUEST['state_alias'])){$state = implode(", ",$_REQUEST['state_alias']);}else{$state = '';}
			$zone_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($zone)));
			$state_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($state)));
			if(empty($esca_id)){$res="Please Enter Esca Id";}
			elseif(empty($esca_name)){$res="Please Enter Esca Name";}
			elseif(empty($password)){$res="Please Enter Password";}
			elseif(empty($esca_number)){$res="Please Enter Esca Number";}
			elseif(empty($esca_email)){$res="Please Enter Esca Email";}
			elseif(count($_REQUEST['zone_alias'])==''){$res="Please Enter Zone Name";}
			elseif(count($_REQUEST['state_alias'])==''){$res="Please Enter State Name";}
			else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_esca WHERE esca_name='$esca_name' AND flag=0");
				if(mysqli_num_rows($q)==0){
				$sql=mysqli_query($mr_con,"INSERT INTO ec_esca(esca_id,esca_name,password,esca_alias,esca_number,esca_email,zone_alias,state_alias,created_date) VALUES('$esca_id','$esca_name','".password_hash_encript($password)."','$esca_alias','$esca_number','$esca_email','$zone_alias','$state_alias','".date('Y-m-d')."')");
				if($sql){
					$action=$esca_id." Esca ID Created";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Creating!';}
					}else{$res = 'The Requested Esca Name has already exist, Try with other values';}
				}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
			$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
			echo json_encode($result);
}
function esca_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$esca_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['esca_alias']));
			$esca_id = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['esca_id'])));
			$esca_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['esca_name'])));
			$esca_number = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['esca_number'])));
			$esca_email = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['esca_email'])));
			$status = mysqli_real_escape_string($mr_con,trim($_REQUEST['status']));
			if(isset($_REQUEST['zone_alias'])){$zone = implode(", ",$_REQUEST['zone_alias']);}else{$zone = '';}
			if(isset($_REQUEST['state_alias'])){$state = implode(", ",$_REQUEST['state_alias']);}else{$state = '';}
			$zone_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($zone)));
			$state_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($state)));
			if(empty($esca_id)){$res="Please Enter Esca Id";}
			elseif(empty($esca_name)){$res="Please Enter Esca Name";}
			elseif(empty($esca_number)){$res="Please Enter Esca Number";}
			elseif(empty($esca_email)){$res="Please Enter Esca Email";}
			elseif(isset($_REQUEST['status']) && $_REQUEST['status']==''){$res="Please Select Status";}
			elseif(count($_REQUEST['zone_alias'])=='0'){$res="Please Enter Zone Name";}
			elseif(count($_REQUEST['state_alias'])=='0'){$res="Please Enter State Name";}
			else{
				$con = (isset($_REQUEST['status']) ? ",flag='$status'" : "");
				$q=mysqli_query($mr_con,"SELECT id FROM ec_esca WHERE esca_name='$esca_name' AND esca_alias<>'$esca_alias' AND flag IN('0','1')");
				if(mysqli_num_rows($q)==0){
			$sql = mysqli_query($mr_con,"UPDATE ec_esca SET esca_id='$esca_id',esca_name='$esca_name',esca_name='$esca_name',esca_number='$esca_number',esca_email='$esca_email',zone_alias='$zone_alias',state_alias='$state_alias' $con WHERE esca_alias='$esca_alias' AND flag IN('0','1')");
			if($sql){
				$action=$esca_id." Esca Id Updated";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Updating!';}
		  		}else{$res = 'The Requested Esca Name has already exist, Try with other values';}
			}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function esca_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
		$esca_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
		$sql=mysqli_query($mr_con,"SELECT * FROM ec_esca WHERE esca_alias='$esca_alias' AND flag IN('0','1')");
		if(mysqli_num_rows($sql)>0){
				$row=mysqli_fetch_array($sql);
					$result['esca_alias']=$row['esca_alias'];
					$result['esca_id']=$row['esca_id'];
					$result['esca_name']=$row['esca_name'];
					$result['esca_number']=$row['esca_number'];
					$result['esca_email']=$row['esca_email'];
					$result['status']=$row['flag'];
					$result['emp_alias']=strtoupper($_REQUEST['emp_alias']);
					$result['zone_alias']=$row['zone_alias'];
					$zone = explode(", ",$row['zone_alias']);
					foreach($zone as $z){ $zz .= alias($z,'ec_zone','zone_alias','zone_name').", "; }
					$result['zone_name'] = trim($zz,", ");
					
					$result['state_alias']=$row['state_alias'];
					$state = explode(", ",$row['state_alias']);
					foreach($state as $s){ $ss .= alias($s,'ec_state','state_alias','state_name').", "; }
					$result['state_name'] = trim($ss,", ");
					$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function esca_mul_view(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){
		if($_REQUEST['escaId']!="")$esca_id="esca_id LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['escaId'])."%' AND ";else $esca_id="";
		if($_REQUEST['escaName']!="")$esca_name="esca_name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['escaName'])."%' AND ";else $esca_name="";
		if($_REQUEST['escaNumber']!="")$esca_number="esca_number LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['escaNumber'])."%' AND ";else $esca_number="";
		if($_REQUEST['escaEmail']!="")$esca_email="esca_email LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['escaEmail'])."%' AND ";else $esca_email="";
		if($_REQUEST['zoneName']!="")$zone_alias="zone_alias LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['zoneName'])."%' AND ";else $zone_alias="";
		if($_REQUEST['status']!="")$status="flag = '".mysqli_real_escape_string($mr_con,$_REQUEST['status'])."' AND ";else $status="";
		$condtion=$esca_id.$esca_name.$esca_number.$esca_email.$zone_alias.$status;
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM  ec_esca WHERE $condtion flag IN('0','1')");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT * FROM ec_esca WHERE $condtion flag IN('0','1') LIMIT $offset, $limit");
			//echo "SELECT * FROM ec_esca WHERE $condtion flag=0 LIMIT $offset, $limit";
			$result['escaDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['escaDetails'][$i]['esca_alias']=$row['esca_alias'];
					$result['escaDetails'][$i]['esca_id']=$row['esca_id'];
					$result['escaDetails'][$i]['esca_name']=$row['esca_name'];
					$result['escaDetails'][$i]['esca_number']=$row['esca_number'];
					$result['escaDetails'][$i]['esca_email']=$row['esca_email'];
					$result['escaDetails'][$i]['status']=$row['flag'];
					foreach(explode(", ",$row['zone_alias']) as $y){ $yy[$i] .= alias($y,'ec_zone','zone_alias','zone_name').", "; }
					$result['escaDetails'][$i]['zone_name']=trim($yy[$i],", ");
								
					foreach(explode(", ",$row['state_alias']) as $z){ $zz[$i] .= alias($z,'ec_state','state_alias','state_name').", "; }
					$result['escaDetails'][$i]['state_name']=trim($zz[$i],", ");
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
	$result['add'] = grantable('ADD', 'ESCA', $emp_alias);
	$result['edit'] = grantable('EDIT', 'ESCA', $emp_alias);
	$result['delete'] = grantable('DELETE', 'ESCA', $emp_alias);
	$result['view'] = grantable('VIEW', 'ESCA', $emp_alias);
	$result['export'] = grantable('EXPORT', 'ESCA', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function esca_export(){global $mr_con;
	$zone_arr = array();$state_arr = array();
	if(isset($_REQUEST['zone_alias']) && count($_REQUEST['zone_alias'])>0){
		$zone_arr = $_REQUEST['zone_alias'];
		$zone = implode("|",$zone_arr);
		$con .= " zone_alias RLIKE '$zone' AND ";
	}else{$con .= '';}
	if(isset($_REQUEST['state_alias']) && count($_REQUEST['state_alias'])>0){
		$state_arr = $_REQUEST['state_alias'];
		$state = implode("|",$state_arr);
		$con .= " state_alias RLIKE '$state' AND ";
	}else{$con .= '';}
	if(isset($_REQUEST['status']) && $_REQUEST['status']!=''){
		$con .= " flag = '".$_REQUEST['status']."' AND ";
	}else{$con .= '';}
	
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_esca WHERE $con flag IN('0','1')");///echo "SELECT * FROM ec_esca WHERE $con flag=0";
	$colArr=array('Esca Id','Esca Name','Esca Number','Esca Email','Zone','State','Status');
	$colArr2=array('esca_id','esca_name','esca_number','esca_email');
	$filename = 'esca_'.date('d-m-Y H_i_s');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
	$ch = 'A';
	foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
	$ch++;
	}
	$coo=1;
	while($row=mysqli_fetch_array($sql)){ 
		$zone_alias = explode(", ",$row['zone_alias']);
			$zcnt=count($zone_alias);
			$state_alias = explode(", ",$row['state_alias']);
			$scnt=count($state_alias);
		$max=max($zcnt,$scnt);
		for($k=0;$k<$max;$k++){
			$a = (count($zone_arr) ? in_array($zone_alias[$k],$zone_arr) : TRUE);
			$b = (count($state_arr) ? in_array($state_alias[$k],$state_arr) : TRUE);
			if($a || $b){$coo++;
				$d = ($zone_alias[$k]!='' ?  alias($zone_alias[$k],'ec_zone','zone_alias','zone_name'):"-");
				$f = ($state_alias[$k]!='' ?  alias($state_alias[$k],'ec_state','state_alias','state_name'):"-");
				for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
					$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$coo, $d);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$coo, $f);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$coo, ($row['flag']=='1' ? 'DE' : '').'ACTIVE');
			}
		}
	}
	$objPHPExcel->getActiveSheet()->setTitle('esca');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("../../exports/$filename.xlsx");
	$result['file_name']=$filename;
	$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function dpr_add(){ 
	global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
			$alias = aliasCheck(generateRandomString(),'ec_dpr_category','category_alias');
			$category = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['category'])));
		if(empty($category)){$res= "Please Enter Category";
			}else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_dpr_category WHERE category='$category' AND flag=0");
				if(mysqli_num_rows($q)==0){
					$sql=mysqli_query($mr_con,"INSERT INTO ec_dpr_category(category,category_alias)VALUES('$category','$alias')");
					if($sql){
						$action=$category." Category Created";
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
						update_fields('dpr_drops');
						$resCode='0';$resMsg='Successful!';
					}else{
						$resCode='4';$resMsg='Error in Creating!';
					}
				}else{
					$res = 'The Requested Category has already exist, Try with other values';
				}
			}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);		
}
function dpr_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
			$category_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['category_alias']));
			$category = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['category'])));
		if(empty($category)){$res="Please Enter Category";
		}else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_dpr_category WHERE category='$category' AND category_alias<>'$category_alias' AND flag=0");
		if(mysqli_num_rows($q)==0){
				$sql=mysqli_query($mr_con,"UPDATE ec_dpr_category SET category='$category' WHERE category_alias='$category_alias' AND flag=0");
				if($sql){
					$action=$category." Category Updated";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					update_fields('dpr_drops');
					$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Updating!';}
			}else{$res = 'The Requested Category has already exist, Try with other values';}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function dpr_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$category_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
		$sql=mysqli_query($mr_con,"SELECT category,category_alias FROM ec_dpr_category WHERE category_alias='$category_alias' AND flag=0");
		if(mysqli_num_rows($sql)>0){
			$row=mysqli_fetch_array($sql);
				$result['category']=$row['category'];
				$result['category_alias']=$row['category_alias'];
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4';$resMsg='No Records Found!';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function dpr_mul_view(){ global $mr_con;
		$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){
		if($_REQUEST['Category']!="")$category="category LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['Category'])."%' AND ";else $category="";
		$condtion=$category;
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_dpr_category WHERE $condtion flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT category_alias,category FROM ec_dpr_category WHERE $condtion flag=0 LIMIT $offset, $limit");
			$result['categoryDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['categoryDetails'][$i]['category_alias']=$row['category_alias']; 
					$result['categoryDetails'][$i]['category']=$row['category']; 
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
	$result['add'] = grantable('ADD', 'DPR CATEGORIES', $emp_alias);
	$result['edit'] = grantable('EDIT', 'DPR CATEGORIES', $emp_alias);
	$result['delete'] = grantable('DELETE', 'DPR CATEGORIES', $emp_alias);
	$result['view'] = grantable('VIEW', 'DPR CATEGORIES', $emp_alias);
	$result['export'] = grantable('EXPORT', 'DPR CATEGORIES', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function dpr_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_dpr_category WHERE flag=0");
	$colArr=array('DPR Category');
	$colArr2=array('category');
	$filename = 'DPR_'.date('d-m-Y H_i_s');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
	$ch = 'A';
	foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
	$ch++;
	}
	$coo=1;
	while($row=mysqli_fetch_array($sql)){ $coo++;
		for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
			$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
		}
	}
	$objPHPExcel->getActiveSheet()->setTitle('DPR Category');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("../../exports/$filename.xlsx");
	$result['file_name']=$filename;
	$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function manuals_update(){
	global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['product_alias'])));
		if(!isset($_REQUEST['segment_alias']) || count($_REQUEST['segment_alias'])=='0')$res="Please Select Segment";
		if(!isset($_REQUEST['view_stat']) || $_REQUEST['view_stat']=='')$res="Please Select View Status";
		else{
			$view_stat=mysqli_real_escape_string($mr_con,trim($_REQUEST['view_stat']));
			if(isset($_FILES['m_file']['name']) && !empty($_FILES['m_file']['name'])){
				$link = upload_file($_FILES['m_file'],'manual_file','pdf');
				list($code,$msg1) = explode(",",$link);
				if($code=='0')$contact_link=$msg1;else $res=$msg1.', Try again!';
			}
			if(empty($res)){
				$con=(!empty($contact_link) ? " manual_pdf='$contact_link'," : "");
				$sql=mysqli_query($mr_con,"UPDATE ec_app_manuals SET $con mob_view_stat='$view_stat',segment_alias='".implode(", ",$_REQUEST['segment_alias'])."' WHERE product_alias='$alias' AND flag=0");
				if($sql){
					$action=alias($product_alias,'ec_product','product_alias','product_description')." Manuals Updated";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					update_fields('manual_status');
					$resCode='0';$resMsg='Successful!';
				}else{$resCode='4';$resMsg='Error in Creating!';}
			}
		}if(isset($res) && !empty($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function manuals_mul_view(){global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){$con="";
		if($_REQUEST['Product']!="")$con.="product_alias IN(SELECT product_alias FROM ec_product WHERE product_description LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['Product'])."%' AND flag='0') AND ";
		if($_REQUEST['segmentAlias']!="")$con.="segment_alias LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['segmentAlias'])."%' AND ";
		if($_REQUEST['view_stat']!="")$con.="mob_view_stat ='".mysqli_real_escape_string($mr_con,$_REQUEST['view_stat'])."' AND ";
		$rec=mysqli_query($mr_con,"SELECT COUNT(id) FROM ec_app_manuals WHERE $con flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT * FROM ec_app_manuals WHERE $con flag=0 LIMIT $offset, $limit");
			$result['manualDetails']=array();
			if(mysqli_num_rows($sql)){$i=0;
				while($row = mysqli_fetch_array($sql)){$sgmt=array();
					$result['manualDetails'][$i]['product_alias']=$row['product_alias'];
					$result['manualDetails'][$i]['product_name']=alias($row['product_alias'],'ec_product','product_alias','product_description');
					$result['manualDetails'][$i]['view_stat']=$row['mob_view_stat'];
					foreach(explode(", ",$row['segment_alias']) as $seg)$sgmt[]=alias($seg,'ec_segment','segment_alias','segment_name'); 
					$result['manualDetails'][$i]['segment_name']=implode(",",$sgmt);
					$result['manualDetails'][$i]['manual_file']=(!empty($row['manual_pdf']) ? baseurl()."images/reports/".$row['manual_pdf'] : ''); 
				$i++;}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	$result['add'] = grantable('ADD', 'MANUALS', $emp_alias);
	$result['edit'] = grantable('EDIT', 'MANUALS', $emp_alias);
	$result['delete'] = grantable('DELETE', 'MANUALS', $emp_alias);
	$result['view'] = grantable('VIEW', 'MANUALS', $emp_alias);
	$result['export'] = grantable('EXPORT', 'MANUALS', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function manuals_view(){global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
		$sql=mysqli_query($mr_con,"SELECT * FROM ec_app_manuals WHERE product_alias='$alias' AND flag=0");
		if(mysqli_num_rows($sql)){$sgmt=array();
			$row=mysqli_fetch_array($sql);
			$result['product_alias']=$row['product_alias'];
			$result['product_name']=alias($row['product_alias'],'ec_product','product_alias','product_description');
			$result['segment_alias']=$row['segment_alias'];
			foreach(explode(", ",$row['segment_alias']) as $seg)$sgmt[]= alias($seg,'ec_segment','segment_alias','segment_name');
			$result['segment_name'] = implode(", ",$sgmt);
			$result['view_stat']=$row['mob_view_stat'];
			//$result['manual_file']=$row['manual_pdf'];
			$resCode='0'; $resMsg='Successful!';
		}else{$resCode='4';$resMsg='No Records Found!';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function manuals_export(){global $mr_con;
	$condtion="";
	if(isset($_REQUEST['product']) && count($_REQUEST['product'])>0)$condtion.=" product_alias IN ('".implode("','",$_REQUEST['product'])."') AND ";
	if(isset($_REQUEST['segment']) && count($_REQUEST['segment'])>0)$condtion.=" segment_alias RLIKE '".implode("|",$_REQUEST['segment'])."' AND ";
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_app_manuals WHERE $condtion flag=0");
		if(mysqli_num_rows($sql)){
			$colArr=array('Product Description','Segment Name','View Status','Manual PDf');
			$filename = 'Manuals_'.date('d-m-Y H_i_s');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
			$ch = 'A';
			foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
				$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$ch++;
			}$coo=1;
			while($row=mysqli_fetch_array($sql)){
				foreach(explode(", ",$row['segment_alias']) as $segment_ali){ $coo++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$coo, alias($row['product_alias'],'ec_product','product_alias','product_description'));
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$coo, (empty($segment_ali) ? '-' : alias($segment_ali,'ec_segment','segment_alias','segment_name')));
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$coo, ($row['mob_view_stat']==1 ? 'ENABLE' : 'DISABLE'));
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$coo, (!empty($row['manual_pdf']) ? 'YES': 'NO'));
				}
			}
			$objPHPExcel->getActiveSheet()->setTitle('Manuals');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save("../../exports/$filename.xlsx");
			$result['file_name']=$filename;
			$resCode='0'; $resMsg='export';
		}else{$resCode='4';$resMsg='No Records Found';}
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function numalias($a,$b){ global $mr_con;
	$row=mysqli_fetch_array(mysqli_query($mr_con,"SELECT MAX($a)+1 AS mx FROM $b WHERE flag=0"));
	return $row['mx']+1;
}
function workguide_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$alias = numalias('guide_alias','ec_app_work_guide');
		$workguide_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['workguide_name'])));
		for($i=0;$i<count($_REQUEST['quantity']);$i++)$quantity = $_REQUEST['quantity'];
		if(empty($workguide_name))$res= "Please Enter Workguide Name";
		elseif(count(array_filter($quantity))==0)$res= "Please Enter Sub Data Name";
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_app_work_guide WHERE work_guide='$workguide_name' AND flag=0");
			if(mysqli_num_rows($q)==0){$salias="";
				$sql=mysqli_query($mr_con,"INSERT INTO ec_app_work_guide(work_guide,guide_alias,ref_id) VALUES('$workguide_name','$alias','0')");
				for($a=0;$a<count($quantity);$a++){
					$salias = numalias('guide_alias','ec_app_work_guide');
					if($quantity[$a]!='')$sq=mysqli_query($mr_con,"INSERT INTO ec_app_work_guide(work_guide,guide_alias,ref_id) VALUES('$quantity[$a]','$salias','$alias')");
				}
				if($sql && $sq){
					$action=$workguide_name." Work guide Created";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					update_fields('workguide_status');
					$resCode='0';$resMsg='Successful!';
				}else{$resCode='4';$resMsg='Error in Creating!';}
			}else{$res = 'The Requested Work guide has already exist, Try with other values';}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);		
}
function workguide_update(){global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$main_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['main_alias']));
		$sub_alias = $temp_sub_alias = $_REQUEST['sub_alias'];
		$main_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['main_name'])));
		$sub_name = $_REQUEST['sub_title'];
		if(empty($main_name)){$res="Please Enter Workguide Name";}
		elseif(count(array_filter($sub_name))!=count($sub_name)){$res="Please Enter SubWorkguide Name";}
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_app_work_guide WHERE work_guide='$main_name' AND guide_alias<>'$main_alias' AND flag=0");
			if(mysqli_num_rows($q)==0){
				$msql=mysqli_query($mr_con,"UPDATE ec_app_work_guide SET work_guide='$main_name' WHERE guide_alias='$main_alias' AND ref_id='0' AND flag=0");
				$disa=mysqli_query($mr_con,"UPDATE ec_app_work_guide SET flag='1' WHERE ref_id='$main_alias' AND guide_alias NOT IN ('".implode("','",array_filter($temp_sub_alias))."') AND flag=0");
				for($i=0;$i<count($sub_name);$i++){
					if(empty($sub_alias[$i])){
						$sss=mysqli_query($mr_con,"SELECT id FROM ec_app_work_guide WHERE id=(SELECT MAX(id) FROM ec_app_work_guide WHERE flag='0') AND flag='0'");
						$rrr=mysqli_fetch_array($sss);
						$ssql=mysqli_query($mr_con,"INSERT INTO ec_app_work_guide(work_guide,guide_alias,ref_id)VALUES('$sub_name[$i]','".($rrr['id']+1)."','$main_alias')");
					}else $ssql=mysqli_query($mr_con,"UPDATE ec_app_work_guide SET work_guide='$sub_name[$i]' WHERE guide_alias='$sub_alias[$i]' AND flag=0");
					if($msql && $ssql){
						$action=$sub_name[$i]." Workguide Updated";
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
						update_fields('workguide_status');
						$resCode='0';$resMsg='Successful!';
					}else{$resCode='4';$resMsg='Error in Updating!';}
				}
			}else{$res = 'The Requested Workguide has already exist, Try with other values';}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function workguide_mul_view(){
	global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$chk = authentication($emp_alias, $_REQUEST['token']);
	if($chk==0){ 
		$result['workguideDetails']=array();
		$work_guide=mysqli_real_escape_string($mr_con,trim($_REQUEST['work_guide']));
		$con=(!empty($work_guide) ? "work_guide LIKE '%$work_guide%' AND " : "");
		$rec=mysqli_query($mr_con,"SELECT COUNT(id) FROM ec_app_work_guide WHERE ref_id='0' AND $con flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_app_work_guide WHERE ref_id='0' AND $con flag=0 LIMIT $offset, $limit");
			if(mysqli_num_rows($sql)>0){
				$i=0;while($row=mysqli_fetch_array($sql)){
					$result['workguideDetails'][$i]['work_guide_title']=$row['work_guide'];
					$result['workguideDetails'][$i]['mainguide_alias']=$row['guide_alias'];
					$q=mysqli_query($mr_con,"SELECT work_guide,guide_alias FROM ec_app_work_guide WHERE ref_id='".$row['guide_alias']."' AND flag=0");
					if(mysqli_num_rows($q)>0){
					$j=0;while($rows=mysqli_fetch_array($q)){
						$result['workguideDetails'][$i]['sub_work_guide'][$j]['name']=$rows['work_guide'];
						$result['workguideDetails'][$i]['sub_work_guide'][$j]['alias']=$rows['guide_alias'];
					$j++;}
					}
				$i++;}
				$resCode='0';$resMsg='Successful!';
			}
		}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	$result['add'] = grantable('ADD', 'WORK GUIDES', $emp_alias);
	$result['edit'] = grantable('EDIT', 'WORK GUIDES', $emp_alias);
	$result['delete'] = grantable('DELETE', 'WORK GUIDES', $emp_alias);
	$result['view'] = grantable('VIEW', 'WORK GUIDES', $emp_alias);
	$result['export'] = grantable('EXPORT', 'WORK GUIDES', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function workguide_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
		$sql=mysqli_query($mr_con,"SELECT work_guide,guide_alias FROM ec_app_work_guide WHERE ref_id='0' AND guide_alias='$alias' AND flag=0");
		if(mysqli_num_rows($sql)>0){
			$row=mysqli_fetch_array($sql);
			$result['main_title']=$row['work_guide'];
			$result['main_alias']=$row['guide_alias'];
			$q=mysqli_query($mr_con,"SELECT work_guide,guide_alias FROM ec_app_work_guide WHERE ref_id='$alias' AND flag=0");
			if(mysqli_num_rows($q)>0){
				$j=0;while($rows=mysqli_fetch_array($q)){
					$result['sub_work_guide'][$j]['sub_title']=$rows['work_guide'];
					$result['sub_work_guide'][$j]['sub_alias']=$rows['guide_alias'];
				$j++;}
			}
			$resCode='0';$resMsg='Successful!';
		}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function workguide_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$sql = mysqli_query($mr_con,"SELECT work_guide,ref_id FROM ec_app_work_guide WHERE ref_id!='0' AND flag=0");
		if(mysqli_num_rows($sql)!=0){
			$colArr=array('Work Guide','Sub Work Guide');
			$filename = 'Workguide_'.date('d-m-Y H_i_s');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
			$ch = 'A';
			foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
				$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$ch++;
			}$coo=1;$ref_id="";
			while($row=mysqli_fetch_array($sql)){ $coo++;
				if($ref_id!=$row['ref_id']){$main = alias($row['ref_id'],'ec_app_work_guide','guide_alias','work_guide');$ref_id=$row['ref_id'];}
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$coo, $main);
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$coo, $row['work_guide']);
			}
			$objPHPExcel->getActiveSheet()->setTitle('Workguide');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save("../../exports/$filename.xlsx");
			$result['file_name']=$filename;
			$resCode='0'; $resMsg='export';
		}else{$resCode='4';$resMsg='No Records Found';}
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function tree_add_update_disable(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		if(isset($_REQUEST['tree_label']) && isset($_REQUEST['tree_data'])){
			$tree_data=$_REQUEST['tree_data'];
			$tree_label=$_REQUEST['tree_label'];
			if(count($tree_label)==count(array_filter($tree_label))){
				foreach($tree_label as $k=>$label){
					if(!empty($label)){
						$dash_count=substr_count($tree_data[$k],"_");
						if($dash_count==2){
							list($ref_id,$flag,$dummy)=explode("_",$tree_data[$k]);
							$sql=mysqli_query($mr_con,"INSERT INTO ec_app_menu_items(module_name,submodule_name,ref_id,flag)VALUES('','$label','$ref_id','$flag')");
						}elseif($dash_count==1){
							list($ref_id,$flag)=explode("_",$tree_data[$k]);
							$sql=mysqli_query($mr_con,"UPDATE ec_app_menu_items SET submodule_name='$label',flag='$flag' WHERE id='$ref_id'");
						}else $sql=mysqli_query($mr_con,"UPDATE ec_app_menu_items SET module_name='$label' WHERE ref_id='$tree_data[$k]'");
					}else{$resCode='4';$resMsg='Some values or Empty, Please check';}
				}
				if($sql){
					$sql1=mysqli_query($mr_con,"SELECT ref_id FROM ec_app_menu_items WHERE module_name='' GROUP BY ref_id");
					if(mysqli_num_rows($sql1)){
						while($row1=mysqli_fetch_array($sql1)){
							$sql2=mysqli_query($mr_con,"SELECT module_name FROM ec_app_menu_items WHERE module_name!='' AND ref_id='".$row1['ref_id']."' LIMIT 1");
							$row2=mysqli_fetch_array($sql2);
							$sql3=mysqli_query($mr_con,"UPDATE ec_app_menu_items SET module_name='".$row2['module_name']."' WHERE module_name='' AND ref_id='".$row1['ref_id']."'");
						}
					}
					if(isset($_REQUEST['tree_change'])){ $already = array();
						foreach(array_filter($_REQUEST['tree_change'])  as $id_ref){
							if(is_numeric($id_ref))$id_ref=alias_flag_none($id_ref,'ec_app_menu_items','id','ref_id');
							if(in_array($id_ref,array('A','M','O','Q','U','Z','E','W','X','Y')))$already[]='physical_obs_status';
							if(in_array($id_ref,array('I','J','S')))$already[]='generator_obs_status';
							if(in_array($id_ref,array('P','T','V')))$already[]='smps_obs_status';
							if(in_array($id_ref,array('G','K')))$already[]='charger_det_status';
							if(in_array($id_ref,array('C','R')))$already[]='fork_lift_status';
							if($id_ref=='H')$already[]='general_obs_status';
							if($id_ref=='N')$already[]='serv_eng_status';
						}foreach(array_unique($already)  as $column)update_fields($column);
					}$resCode='0';$resMsg='Successful';
				}
			}else{$resCode='4';$resMsg='Some values or Empty, Please check';}
		}else{$resCode='4';$resMsg='Update fail, Try again';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function tree_view(){
	global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$chk = authentication($emp_alias, $_REQUEST['token']);
	if($chk==0){
		//$sql=mysqli_query($mr_con,"SELECT ref_id,module_name FROM ec_app_menu_items WHERE ref_id ".($_REQUEST['alias']=='1' ? "<=" : ">")." 'M' AND ref_id NOT IN('A','B','G','K') GROUP BY ref_id ORDER BY ref_id");
		//A,E,G,K Static, B,D,F,L No Need
		$sql=mysqli_query($mr_con,"SELECT ref_id,module_name FROM ec_app_menu_items WHERE ref_id NOT IN('A','B','D','E','F','G','K','L') GROUP BY ref_id ORDER BY module_name");
		if(mysqli_num_rows($sql)>0){
			$i=0;
			while($row=mysqli_fetch_array($sql)){
				$result[$i]['ref_id']=$row['ref_id'];
				$result[$i]['label']=$row['module_name'];
				$q=mysqli_query($mr_con,"SELECT id,flag,submodule_name FROM ec_app_menu_items WHERE ref_id='".$row['ref_id']."'");
				if(mysqli_num_rows($q)>0){
					$j=0;while($rows=mysqli_fetch_array($q)){
						$result[$i]['children'][$j]['id']=$rows['id'];
						$result[$i]['children'][$j]['flag']=$rows['flag'];
						$result[$i]['children'][$j]['label']=$rows['submodule_name'];
						$result[$i]['children'][$j]['data']['description']="Description";
						$j++;
					}
				}$i++;
			}
		}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	//$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function tree_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$sql = mysqli_query($mr_con,"SELECT module_name,submodule_name,flag FROM ec_app_menu_items");
		if(mysqli_num_rows($sql)!=0){
			$colArr=array('Module Name','Sub Module Name','Status');
			//$colArr2=array('module_name','submodule_name','flag');
			$filename = 'Drop_downs_'.date('d-m-Y H_i_s');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
			$ch = 'A';
			foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
				$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
				$ch++;
			}$coo=1;
			while($row=mysqli_fetch_array($sql)){ $coo++;
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$coo, $row['module_name']);
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$coo, $row['submodule_name']);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$coo, (empty($row['flag']) ? 'DISABLED': 'ENABLED'));
			}
			$objPHPExcel->getActiveSheet()->setTitle('Drop Downs');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save("../../exports/$filename.xlsx");
			$result['file_name']=$filename;
			$resCode='0'; $resMsg='export';
		}else{$resCode='4';$resMsg='No Records Found';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function privacy_policy_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$help = mysqli_real_escape_string($mr_con,trim($_REQUEST['help']));
		$login_text = mysqli_real_escape_string($mr_con,trim($_REQUEST['login_text']));
		$privacy_policy = mysqli_real_escape_string($mr_con,trim($_REQUEST['privacy_policy']));
		if(empty($help))$res="Please Enter Help Desc Number";
		elseif(empty($login_text))$res="Please Enter Login Text";
		elseif(empty($privacy_policy))$res="Please Enter Privacy Policy";
		else{
			$sql=mysqli_query($mr_con,"UPDATE ec_app_privacy_policy SET help='$help',privacy_policy='$privacy_policy',login_text='$login_text' WHERE flag=0");
			if($sql){
				$action="Privacy Policy, help desc number and login text Updated";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				update_fields('privacy_policy_help_status');
				$resCode='0';$resMsg='Successful!';
			}else{$resCode='4';$resMsg='Error in Updating!';}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function privacy_policy_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$sql=mysqli_query($mr_con,"SELECT help,login_text,privacy_policy FROM ec_app_privacy_policy WHERE flag=0");
		if(mysqli_num_rows($sql)>0){
			$row=mysqli_fetch_array($sql);
			$result['help']=mysqli_real_escape_string($mr_con,$row['help']);
			$result['login_text']=mysqli_real_escape_string($mr_con,$row['login_text']);
			$result['privacy_policy']=stripslashes(mysqli_real_escape_string($mr_con,$row['privacy_policy']));
			$resCode='0'; $resMsg='Successful!';
		}else{$resCode='4';$resMsg='No Records Found!';}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function changelog_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$alias = numalias('log_alias','ec_app_change_log');
		$changelog_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['changelog_name'])));
		for($i=0;$i<count($_REQUEST['quantity']);$i++)$quantity = $_REQUEST['quantity'];
		if(empty($changelog_name))$res= "Please Enter Changelog Name";
		elseif(count(array_filter($quantity))==0)$res= "Please Enter Sub Data Name";
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_app_change_log WHERE change_logName='$changelog_name' AND flag=0");
			if(mysqli_num_rows($q)==0){$salias="";
				$sql=mysqli_query($mr_con,"INSERT INTO ec_app_change_log(change_logName,log_alias,ref_id) VALUES('$changelog_name','$alias','0')");
				for($a=0;$a<count($quantity);$a++){
					$salias = numalias('log_alias','ec_app_change_log');
					if($quantity[$a]!='')$sq=mysqli_query($mr_con,"INSERT INTO ec_app_change_log(change_logName,log_alias,ref_id) VALUES('$quantity[$a]','$salias','$alias')");
				}
				if($sql && $sq){
					$action=$changelog_name." Changelog Created";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					//update_fields('workguide_status');
					$resCode='0';$resMsg='Successful!';
				}else{$resCode='4';$resMsg='Error in Creating!';}
			}else{$res = 'The Requested Changelog has already exist, Try with other values';}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);		
}
function changelog_update(){global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$main_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['main_alias']));
		$sub_alias = $temp_sub_alias = $_REQUEST['sub_alias'];
		$main_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['main_name'])));
		$sub_name = $_REQUEST['sub_title'];
		if(empty($main_name)){$res="Please Enter Change Log Name";}
		elseif(count(array_filter($sub_name))!=count($sub_name)){$res="Please Enter SubChangelog Name";}
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_app_change_log WHERE change_logName='$main_name' AND log_alias<>'$main_alias' AND flag=0");
			if(mysqli_num_rows($q)==0){
				$msql=mysqli_query($mr_con,"UPDATE ec_app_change_log SET change_logName='$main_name' WHERE log_alias='$main_alias' AND ref_id='0' AND flag=0");
				$disa=mysqli_query($mr_con,"UPDATE ec_app_change_log SET flag='1' WHERE ref_id='$main_alias' AND log_alias NOT IN ('".implode("','",array_filter($temp_sub_alias))."') AND flag=0");
				for($i=0;$i<count($sub_name);$i++){
					if(empty($sub_alias[$i])){
						$sss=mysqli_query($mr_con,"SELECT id FROM ec_app_change_log WHERE id=(SELECT MAX(id) FROM ec_app_change_log WHERE flag='0') AND flag='0'");
						$rrr=mysqli_fetch_array($sss);
						$ssql=mysqli_query($mr_con,"INSERT INTO ec_app_change_log(change_logName,log_alias,ref_id)VALUES('$sub_name[$i]','".($rrr['id']+1)."','$main_alias')");
					}else $ssql=mysqli_query($mr_con,"UPDATE ec_app_change_log SET change_logName='$sub_name[$i]' WHERE log_alias='$sub_alias[$i]' AND flag=0");
					if($msql && $ssql){
						$action=$sub_name[$i]." Change Log Name Updated";
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
						//update_fields('workguide_status');
						$resCode='0';$resMsg='Successful!';
					}else{$resCode='4';$resMsg='Error in Updating!';}
				}
			}else{$res = 'The Requested Workguide has already exist, Try with other values';}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function changelog_mul_view(){
	global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$chk = authentication($emp_alias, $_REQUEST['token']);
	if($chk==0){ $result['changelogDetails']=array();
		$change_log=mysqli_real_escape_string($mr_con,trim($_REQUEST['change_log']));
		$con=(!empty($change_log) ? "change_logName LIKE '%$change_log%' AND " : "");
		$rec=mysqli_query($mr_con,"SELECT COUNT(id) FROM ec_app_change_log WHERE ref_id='0' AND $con flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_app_change_log WHERE ref_id='0' AND $con flag=0 ORDER BY change_logName DESC LIMIT $offset, $limit");
			if(mysqli_num_rows($sql)>0){
				$i=0;while($row=mysqli_fetch_array($sql)){
					$result['changelogDetails'][$i]['changelog_Name']=$row['change_logName'];
					$result['changelogDetails'][$i]['changelog_alias']=$row['log_alias'];
					$q=mysqli_query($mr_con,"SELECT * FROM ec_app_change_log WHERE ref_id='".$row['log_alias']."' AND flag=0");
					if(mysqli_num_rows($q)>0){
					$j=0;while($rows=mysqli_fetch_array($q)){
						$result['changelogDetails'][$i]['sub_changelog_Name'][$j]['name']=$rows['change_logName'];
						$result['changelogDetails'][$i]['sub_changelog_alias'][$j]['alias']=$rows['log_alias'];
					$j++;}
					}
				$i++;}
				$resCode='0';$resMsg='Successful!';
			}
		}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	$result['add'] = grantable('ADD', 'CHANGE LOG', $emp_alias);
	$result['edit'] = grantable('EDIT', 'CHANGE LOG', $emp_alias);
	$result['delete'] = grantable('DELETE', 'CHANGE LOG', $emp_alias);
	$result['view'] = grantable('VIEW', 'CHANGE LOG', $emp_alias);
	$result['export'] = grantable('EXPORT', 'CHANGE LOG', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function changelog_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
		$sql=mysqli_query($mr_con,"SELECT * FROM ec_app_change_log WHERE ref_id='0' AND log_alias='$alias' AND flag=0");
		//echo "SELECT * FROM ec_app_change_log WHERE ref_id='0' AND log_alias='$alias' AND flag=0";
		if(mysqli_num_rows($sql)>0){
			$row=mysqli_fetch_array($sql);
			$result['main_title']=$row['change_logName'];
			$result['main_alias']=$row['log_alias'];
			$q=mysqli_query($mr_con,"SELECT * FROM ec_app_change_log WHERE ref_id='$alias' AND flag=0");
			if(mysqli_num_rows($q)>0){
				$j=0;while($rows=mysqli_fetch_array($q)){
					$result['sub_changelog'][$j]['sub_title']=$rows['change_logName'];
					$result['sub_changelog'][$j]['sub_alias']=$rows['log_alias'];
				$j++;}
			}
			$resCode='0';$resMsg='Successful!';
		}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function changelog_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$sql = mysqli_query($mr_con,"SELECT change_logName,ref_id FROM ec_app_change_log WHERE ref_id!='0' AND flag=0 ORDER BY change_logName");
		if(mysqli_num_rows($sql)!=0){
			$colArr=array('Version','Change Log');
			$filename = 'Changelog_'.date('d-m-Y H_i_s');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
			$ch = 'A';
			foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
				$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$ch++;
			}$coo=1;$ref_id="";
			while($row=mysqli_fetch_array($sql)){ $coo++;
				if($ref_id!=$row['ref_id']){$main = alias($row['ref_id'],'ec_app_change_log','log_alias','change_logName');$ref_id=$row['ref_id'];}
				$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$coo, $main,PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$coo, $row['change_logName']);
			}
			$objPHPExcel->getActiveSheet()->setTitle('Change Log');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save("../../exports/$filename.xlsx");
			$result['file_name']=$filename;
			$resCode='0'; $resMsg='export';
		}else{$resCode='4';$resMsg='No Records Found';}
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function deleteSettingItem($table, $field, $val, $emp_alias, $action, $remarks, $ipAddr) {
	global $mr_con;
	$query = "UPDATE $table set flag = '9' where $field = '$val'";
	$sql = mysqli_query($mr_con, $query);
	if($sql) {
		user_history($emp_alias, $action, $ipAddr, $remarks);
		return true;
	}
	return false;
}

function assets_check_delete_status() {

	global $mr_con;
	global $maxCount;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			// TODO:: Need to add additional checks
			$query = "SELECT name FROM ec_employee_master WHERE asset_alias like '%$alias%' and flag = 0";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['name'];
				}
				$res = buildRes("This Asset is using by ", $names);
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function assets_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$assetName = alias($alias,'ec_assets','asset_alias','asset_name');
			$action = "Deleted asset - $assetName";
			$status = deleteSettingItem('ec_assets', 'asset_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete asset";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function ticket_complaint_check_delete_status() {

	global $mr_con;
	global $maxCount;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			// TODO:: Need to add additional checks
			$query = "SELECT ticket_id FROM ec_tickets WHERE complaint_alias like '%$alias%' and flag = 0";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['ticket_id'];
				}
				$res = buildRes("This complaint is assigned in ", $names);
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function ticket_complaint_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$name = alias($alias,'ec_complaint','complaint_alias','complaint_name');
			$action = "Deleted Complaint - $name";
			$status = deleteSettingItem('ec_complaint', 'complaint_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete complaint";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function customer_check_delete_status() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			// TODO:: Need to add additional checks
			$query = "SELECT site_id FROM ec_sitemaster WHERE customer_alias like '%$alias%' and flag = 0";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['site_id'];
				}
				$res = buildRes("This customer is assigned for sites - ", $names);
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function customer_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$name = alias($alias,'ec_customer','customer_alias','customer_name');
			$action = "Deleted Customer - $name";
			$status = deleteSettingItem('ec_customer', 'customer_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete Customer";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function department_check_delete_status() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$query = "SELECT name FROM ec_employee_master WHERE department_alias like '%$alias%'";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['name'];
				}
				$res = buildRes("This department is assigned for employees - ", $names);
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function department_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$name = alias($alias,'ec_department','department_alias','department_name');
			$action = "Deleted Department - $name";
			$status = deleteSettingItem('ec_department', 'department_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete Department";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function designation_check_delete_status() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$query = "SELECT name FROM ec_employee_master WHERE designation_alias like '%$alias%'";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['name'];
				}
				$res = buildRes("This designation is assigned for employees - ", $names);
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function designation_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$name = alias($alias,'ec_designation','designation_alias','designation');
			$action = "Deleted designation - $name";
			$status = deleteSettingItem('ec_designation', 'designation_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete designation";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function district_check_delete_status() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$query = "SELECT site_id FROM ec_sitemaster WHERE district_alias like '%$alias%' ";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['site_id'];
				}
				$res = buildRes("This district is assigned for sites - ", $names);
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function district_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$name = alias($alias,'ec_district','district_alias','district_name');
			$action = "Deleted district - $name";
			$status = deleteSettingItem('ec_district', 'district_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete district";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function dpr_check_delete_status() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {

			$query = "SELECT dpr_ref_no FROM ec_dpr WHERE category_alias like '%$alias%' and flag = 0";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['dpr_ref_no'];
				}
				$res = buildRes("This dpr is assigned for events - ", $names);
			} else {	
			$query = "SELECT title FROM ec_event_details WHERE dpr_alias like '%$alias%' and flag = 0";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['title'];
				}
				$res = buildRes("This dpr is assigned for events - ", $names);
			}
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function dpr_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$name = alias($alias,'ec_dpr_category','category_alias','category');
			$action = "Deleted dpr category - $name";
			$status = deleteSettingItem('ec_dpr_category', 'category_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete dpr category";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function employee_role_check_delete_status() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$query = "SELECT name FROM ec_employee_master WHERE role_alias like '%$alias%'";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['name'];
				}
				$res = buildRes("This role is assigned for employee - ", $names);
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function employee_role_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$name = alias($alias,'ec_emprole','role_alias','role_name');
			$action = "Deleted Employee Role - $name";
			$status = deleteSettingItem('ec_emprole', 'role_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete employee role";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function esca_check_delete_status() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function esca_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$name = alias($alias,'ec_esca','esca_alias','esca_name');
			$action = "Deleted esca - $name";
			$status = deleteSettingItem('ec_esca', 'esca_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete esca";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function faultycode_check_delete_status() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$query = "SELECT tk.ticket_id FROM ec_engineer_observation as eo, ec_tickets as tk WHERE eo.faulty_code_alias like '%$alias%' and eo.ticket_alias=tk.ticket_alias and eo.flag = 0 and tk.flag = 0";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['ticket_id'];
				}
				$res = buildRes("This faulty code is assigned for tickets - ", $names);
			} else {
				$query = "SELECT tk.ticket_id FROM ec_fsr_faulty_cells as ffc, ec_tickets as tk WHERE ffc.faulty_code_alias like '%$alias%' and ffc.ticket_alias=tk.ticket_alias and ffc.flag = 0 and tk.flag = 0";
				$sql = mysqli_query($mr_con, $query);
				if(mysqli_num_rows($sql) > 0) {
					$names = [];
					while($row = mysqli_fetch_assoc($sql)) {
						$names[] = $row['ticket_id'];
					}
					$res = buildRes("This faulty code is assigned for tickets - ", $names);
				}
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function faultycode_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$name = alias($alias,'ec_faulty_code','faulty_alias','description');
			$action = "Deleted Faulty Code - $name";
			$status = deleteSettingItem('ec_faulty_code', 'faulty_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete Faulty Code";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function milestone_check_delete_status() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$query = "SELECT ticket_id FROM ec_tickets WHERE milestone like '%$alias%' and flag = 0";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['ticket_id'];
				}
				$res = buildRes("This milestone is assigned for tickets - ", $names);
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function milestone_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$name = alias($alias,'ec_milestone','mile_stone_alais','mile_stone');
			$action = "Deleted milestone - $name";
			$status = deleteSettingItem('ec_milestone', 'mile_stone_alais', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete milestone";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function moc_check_delete_status() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$query = "SELECT ticket_id FROM ec_tickets WHERE mode_of_contact like '%$alias%' and flag = 0";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['ticket_id'];
				}
				$res = buildRes("This mode of contact is assigned for tickets - ", $names);
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function moc_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$name = alias($alias,'ec_moc','moc_alias','moc_name');
			$action = "Deleted mode of contact - $name";
			$status = deleteSettingItem('ec_moc', 'moc_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete mode of contact";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function sitetype_check_delete_status() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$query = "SELECT site_id FROM ec_sitemaster WHERE site_type_alias like '%$alias%' and flag = 0";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['site_id'];
				}
				$res = buildRes("This sitetype is assigned for sites - ", $names);
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function sitetype_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$name = alias($alias,'ec_site_type','site_type_alias','site_type');
			$sgmt = alias($alias,'ec_site_type','site_type_alias','segment_alias');
			$sgmtName = alias($sgmt,'ec_segment','segment_alias','segment_name');
			$action = "Deleted Sitetype - $name for segment $sgmtName";
			$status = deleteSettingItem('ec_site_type', 'site_type_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete Customer";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function product_check_delete_status() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$query = "SELECT site_id FROM ec_sitemaster WHERE product_alias like '%$alias%' and flag = 0";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['site_id'];
				}
				$res = buildRes("This product is assigned for sites - ", $names);
			} else {
				$query = "SELECT customer_id FROM ec_customer WHERE product_alias like '%$alias%' and flag = 0";
				$sql = mysqli_query($mr_con, $query);
				if(mysqli_num_rows($sql) > 0) {
					$names = [];
					while($row = mysqli_fetch_assoc($sql)) {
						$names[] = $row['customer_id'];
					}
					$res = buildRes("This product is assigned for customers - ", $names);
				}
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function product_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$name = alias($alias,'ec_product','product_alias','product_description');
			$action = "Deleted Product - $name ";
			$status = deleteSettingItem('ec_product', 'product_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete Product";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function state_check_delete_status() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$query = "SELECT district_name FROM ec_district WHERE state_alias like '%$alias%' and flag = 0";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['district_name'];
				}
				$res = buildRes("This state is assigned for districts - ", $names);
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function state_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$name = alias($alias,'ec_state','state_alias','state_name');
			$action = "Deleted State - $name ";
			$status = deleteSettingItem('ec_state', 'state_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete State";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function zone_check_delete_status() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$query = "SELECT state_name FROM ec_state WHERE zone_alias like '%$alias%' and flag = 0";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['state_name'];
				}
				$res = buildRes("This zone is assigned for states - ", $names);
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function zone_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$name = alias($alias,'ec_zone','zone_alias','zone_name');
			$action = "Deleted Zone - $name ";
			$status = deleteSettingItem('ec_zone', 'zone_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete Zone";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function shift_check_delete_status() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$query = "SELECT tk.ticket_id FROM ec_ths_approved as ths, ec_tickets as tk WHERE ths.shift like '%$alias%' and ths.ticket_alias=tk.ticket_alias and ths.flag = 0 and tk.flag = 0";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['ticket_id'];
				}
				$res = buildRes("This shift is assigned for tickets - ", $names);
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function shift_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$name = alias($alias,'ec_shift','shift_alias','shift_name');
			$action = "Deleted Shift - $name";
			$status = deleteSettingItem('ec_shift', 'shift_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete Shift";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function warehouse_check_delete_status() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$query = "SELECT sjo_number FROM ec_material_request WHERE (from_wh='$alias' or to_wh='$alias') and flag = 0";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['sjo_number'];
				}
				$res = buildRes("This warehouse is assigned for material request - ", $names);
			}
			$query = "SELECT trans_id FROM ec_material_inward WHERE (from_wh='$alias' or to_wh='$alias') and flag = 0";
			$sql = mysqli_query($mr_con, $query);
			if(!$res && mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['trans_id'];
				}
				$res = buildRes("This warehouse is assigned for material inwards - ", $names);
			}
			$query = "SELECT trans_id FROM ec_material_outward WHERE (from_wh='$alias' or to_wh='$alias') and flag = 0";
			$sql = mysqli_query($mr_con, $query);
			if(!$res && mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['trans_id'];
				}
				$res = buildRes("This warehouse is assigned in material outwards - ", $names);
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function warehouse_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$name = alias($alias,'ec_warehouse','wh_alias','wh_address');
			$action = "Deleted Warehouse - $name ";
			$status = deleteSettingItem('ec_warehouse', 'wh_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete Warehouse";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function privileges_check_delete_status() {
	global $mr_con;
	global $maxCount;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			// TODO:: Need to add additional checks
			$query = "SELECT name FROM ec_employee_master WHERE privilege_alias like '%$alias%' and flag = 0";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['name'];
				}
				$res = buildRes("This Privileges is using by ", $names);
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function privileges_delete() {
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$name = alias($alias,'ec_privileges','privilege_alias','privilege_name');
			$action = "Deleted Privilege - $name";
			$status = deleteSettingItem('ec_privileges', 'privilege_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete privilege";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function workguide_check_delete_status() {
	global $mr_con;
	global $maxCount;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			// No need of validaions
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function workguide_delete() {
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$name = alias($alias,'ec_app_work_guide','id','work_guide');
			$action = "Deleted Workguide - $name";
			$status = deleteSettingItem('ec_app_work_guide', 'id', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete workguide";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function changelog_check_delete_status() {
	global $mr_con;
	global $maxCount;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			// No need of validaions
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function changelog_delete() {
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$name = alias($alias,'ec_app_change_log','log_alias','change_logName');
			$action = "Deleted Changelog - $name";
			$status = deleteSettingItem('ec_app_change_log', 'log_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete workguide";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function dynamic_level_check_delete_status() {
	global $mr_con;
	global $maxCount;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			// No need of validaions
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function dynamic_level_delete() {
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$name = alias($alias,'ec_dynamic_levels','dynamic_alias','level_name');
			$action = "Deleted Dynamic Level - $name";
			$status = deleteSettingItem('ec_dynamic_levels', 'dynamic_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete workguide";
			}
			$resCode = '0'; $resMsg = 'Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function buildRes($text, $names) {

	global $maxCount;
	// return $text . implode(", ", $names);
	$res = $text . implode(", ", array_slice($names, 0, $maxCount));
	if(count($names) > $maxCount) {
		$extra = count($names) - $maxCount;
		$res .= " and +$extra others";
	}
	return $res;
}

function email_sms_recipient_mul_view(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$con = [];
		if(isset($_REQUEST['communication_type']) && $_REQUEST['communication_type']){
			$con[] = "communication_type LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['communication_type'])."%'";
		}
		if(isset($_REQUEST['entity_label']) && $_REQUEST['entity_label']){
			$con[] = "entity_label LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['entity_label'])."%'";
		}
		if(isset($_REQUEST['send_to']) && $_REQUEST['send_to']){
			$con[] = "send_to LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['send_to'])."%'";
		}
		if(isset($_REQUEST['send_cc']) && $_REQUEST['send_cc']){
			$con[] = "send_cc LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['send_cc'])."%'";
		}
		if(isset($_REQUEST['status']) && $_REQUEST['status']) {
			if($_REQUEST['status'] == 'active') {
				$con[] = "flag = 0";
			} else if($_REQUEST['status'] == 'deactivate') {
				$con[] = "flag = 1";
			}
		}
		$query = "SELECT COUNT(id) FROM ec_email_sms_settings";
		$cond = "";
		if(count($con)) {
			$cond = implode(" AND ", $con);
		}
		if($cond!=""){
			$query .= " WHERE $cond ";
		}
		$rec = mysqli_query($mr_con, $query);
		if(mysqli_num_rows($rec)>0) {
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")
				$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);
			else 
				$limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")
				$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);
			else 
				$pageNo=1;
			if(is_float($totalRecords/$limit)){
				$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;
			}else{
				$totalpages=$totalRecords/$limit;
			}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)
				$toRecord=$totalRecords;
			else 
				$toRecord=$limit*$pageNo;
			$query = "SELECT * FROM ec_email_sms_settings";
			if($cond!=""){
				$query .= " WHERE $cond ";
			}
			$query .= " ORDER BY communication_type LIMIT $offset, $limit";
			$sql = mysqli_query($mr_con, $query);
			$result['details']=array();
			if(mysqli_num_rows($sql)){
				$i=0;
				while($row = mysqli_fetch_array($sql)){
					$result['details'][$i]['alias'] = $row['alias'];
					$result['details'][$i]['communication_type'] = $row['communication_type'];
					$result['details'][$i]['entity_type'] = $row['entity_type'];
					$result['details'][$i]['entity_label'] = $row['entity_label'];
					$result['details'][$i]['send_to'] = $row['send_to'];
					$result['details'][$i]['send_cc'] = $row['send_cc'];
					$result['details'][$i]['flag'] = $row['flag'];
					$sendTo = $row['send_to'];
					$sendToArr = explode(";", $sendTo);
					$sendCc = $row['send_cc'];
					$sendCcArr = explode(";", $sendCc);
					$sendToNameArr = [];
					$sendCcNameArr = [];
					if($sendToArr) {
						$inArr = [];
						foreach($sendToArr as $eachSendTo) {
							$inArr[] = "'$eachSendTo'";
						}
						$text = "(" . implode(",", $inArr) . ")";
						$query = "SELECT DISTINCT(privilege_name) FROM ec_privileges WHERE privilege_alias in $text";
						$sql1 = mysqli_query($mr_con, $query);
						while($row1 = mysqli_fetch_array($sql1)) {
							$sendToNameArr[] = $row1['privilege_name'];
						}
					}
					if($sendCcArr) {
						$inArr = [];
						foreach($sendCcArr as $eachSendCc) {
							$inArr[] = "'$eachSendCc'";
						}
						$text = "(" . implode(",", $inArr) . ")";
						$query = "SELECT DISTINCT(privilege_name) FROM ec_privileges WHERE privilege_alias in $text";
						$sql1 = mysqli_query($mr_con, $query);
						while($row1 = mysqli_fetch_array($sql1)) {
							$sendCcNameArr[] = $row1['privilege_name'];
						}
					}
					$result['details'][$i]['send_to_name'] = implode("; ", $sendToNameArr);
					$result['details'][$i]['send_cc_name'] = implode("; ", $sendCcNameArr);
					$i++;
				}
				$resCode='0'; $resMsg='Successful!';
			}else{
				$resCode='4'; $resMsg='No Records Found';
			}
		}
	}elseif($rex==1){ 
		$resCode='1'; $resMsg='Authentication Failed';
	}else{
		$resCode='2'; $resMsg='Account Locked';
	}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	$result['add'] = false;
	$result['edit'] = grantable('EDIT', 'EMAIL & SMS RECIPIENT', $emp_alias);
	$result['delete'] = grantable('EDIT', 'EMAIL & SMS RECIPIENT', $emp_alias);
	$result['view'] = grantable('VIEW', 'EMAIL & SMS RECIPIENT', $emp_alias);
	$result['export'] = grantable('EXPORT', 'EMAIL & SMS RECIPIENT', $emp_alias);
	if($totalRecords>=1)
		for($x=0;$x<=$totalpages;$x++)
			$result['pages'][$x]=$x; 
	else 
		$result['pages'][1]=1;
	echo json_encode($result);
}

function email_sms_recipient_view(){ 
	global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
		$sql=mysqli_query($mr_con,"SELECT * FROM ec_email_sms_settings WHERE alias='$alias'");
		if(mysqli_num_rows($sql)>0){
			$row=mysqli_fetch_array($sql);
			$result['alias'] = $row['alias'];
			$result['communication_type'] = $row['communication_type'];
			$result['entity_type'] = $row['entity_type'];
			$result['entity_label'] = $row['entity_label'];
			$result['body'] = $row['body'];
			$sendTo = $row['send_to'];
			$sendToArr = explode(";", $sendTo);
			$sendCc = $row['send_cc'];
			$sendCcArr = explode(";", $sendCc);
			$sendToNameArr = [];
			$sendCcNameArr = [];
			if($sendToArr) {
				$inArr = [];
				foreach($sendToArr as $eachSendTo) {
					$inArr[] = "'$eachSendTo'";
				}
				$text = "(" . implode(",", $inArr) . ")";
				$query = "SELECT DISTINCT(privilege_name) FROM ec_privileges WHERE privilege_alias in $text";
				$sql1 = mysqli_query($mr_con, $query);
				while($row = mysqli_fetch_array($sql1)) {
					$sendToNameArr[] = $row['privilege_name'];
				}
			}
			if($sendCcArr) {
				$inArr = [];
				foreach($sendCcArr as $eachSendCc) {
					$inArr[] = "'$eachSendCc'";
				}
				$text = "(" . implode(",", $inArr) . ")";
				$query = "SELECT DISTINCT(privilege_name) FROM ec_privileges WHERE privilege_alias in $text";
				$sql1 = mysqli_query($mr_con, $query);
				while($row = mysqli_fetch_array($sql1)) {
					$sendCcNameArr[] = $row['privilege_name'];
				}
			}
			$result['send_to'] = $sendToArr;
			$result['send_cc'] = $sendCcArr;
			$result['send_to_name'] = implode("; ", $sendToNameArr);
			$result['send_cc_name'] = implode("; ", $sendCcNameArr);
			$result['flag'] = $row['flag'];
			$resCode='0'; $resMsg='Successful!';
		}else{$resCode='4';$resMsg='No Records Found!';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function email_sms_recipient_update(){ 
	global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$alias = mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
		$communicationType = mysqli_real_escape_string($mr_con,trim($_REQUEST['communication_type']));
		$entityLabel = mysqli_real_escape_string($mr_con,trim($_REQUEST['entity_label']));
		$sendTo = (isset($_REQUEST['send_to']) && count($_REQUEST['send_to'])) ? $_REQUEST['send_to'] : [];
		$sendCC = (isset($_REQUEST['send_cc']) && count($_REQUEST['send_cc'])) ? $_REQUEST['send_cc'] : [];
		$err = "";
		if(!empty($err)){
			$res = $err;
		} else {
			$sendToPrev = implode(";", $sendTo);
			$sendCCPrev = implode(";", $sendCC);
			$query = "SELECT id FROM ec_email_sms_settings WHERE alias = '$alias'";
			$q = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($q)==1) {
				$uQuery = "UPDATE ec_email_sms_settings SET send_to='$sendToPrev', send_cc='$sendCCPrev' WHERE alias='$alias'";
				$sql = mysqli_query($mr_con, $uQuery);
				if($sql){
					$action="E-Mail & SMS Recipient $entityLabel Updated";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$resCode='0';$resMsg='Successful!';
				}else{$resCode='4';$resMsg='Error in Updating!';}
			}else{$res = "The Requested E-Mail & SMS Recipient didn't exist. Contact Admin";}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function email_sms_recipient_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {	
		$alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['alias'])));
		$flag = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['flag'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$query = "SELECT * FROM ec_email_sms_settings WHERE alias = '$alias'";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql)== 1) {
				$emailSmsSettings = mysqli_fetch_assoc($sql);
				$entityName = $emailSmsSettings['entity_label'];
				if($flag ==0 ) {
					$query = "UPDATE ec_email_sms_settings set `flag` = '1' where alias = '$alias'";
					$action = "Email settings $entityName is deactivated";
				} else {
					$query = "UPDATE ec_email_sms_settings set `flag` = '0' where alias = '$alias'";
					$action = "Email settings $entityName is activated";
				}
				$sql = mysqli_query($mr_con, $query);
				if($sql) {
					user_history($emp_alias, $action, $_REQUEST['ip_addr'], $remarks);
					$resCode='0';$resMsg='Successful!';
				} else {
					if($flag ==0 ) {
						$res = 'Failed to deactivate settings details.';
					} else {
						$res = 'Failed to activate settings details.';
					}
				}
			}else{$res = "Settings doesn't exist."; }
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function email_sms_recipient_export(){ 
	global $mr_con;
	$chk = authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0) {
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_email_sms_settings WHERE flag=0");
		$colArr=array('When', 'Communication', 'To: Users Notified', 'CC: Users Notified');
		$filename = 'SMS_EMAIL_RECIPIENT_'.date('d-m-Y H_i_s');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$styleArray = array(
			'font'  => array(
				'bold'  => true, 
				'color' => array('rgb' => 'FFFFFF')
			)
		);
		$ch = 'A';
		foreach($colArr as $colrefValue){ 
			$objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$ch++;
		}
		$coo=1;
		while($row=mysqli_fetch_array($sql)){ 
			$coo++;
			for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){	
				$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
			}
			$sendTo = $row['send_to'];
			$sendToArr = explode(";", $sendTo);
			$sendCc = $row['send_cc'];
			$sendCcArr = explode(";", $sendCc);
			$sendToNameArr = [];
			$sendCcNameArr = [];
			if($sendToArr) {
				$inArr = [];
				foreach($sendToArr as $eachSendTo) {
					$inArr[] = "'$eachSendTo'";
				}
				$text = "(" . implode(",", $inArr) . ")";
				$query = "SELECT DISTINCT(privilege_name) FROM ec_privileges WHERE privilege_alias in $text";
				$sql1 = mysqli_query($mr_con, $query);
				while($row1 = mysqli_fetch_array($sql1)) {
					$sendToNameArr[] = $row1['privilege_name'];
				}
			}
			if($sendCcArr) {
				$inArr = [];
				foreach($sendCcArr as $eachSendCc) {
					$inArr[] = "'$eachSendCc'";
				}
				$text = "(" . implode(",", $inArr) . ")";
				$query = "SELECT DISTINCT(privilege_name) FROM ec_privileges WHERE privilege_alias in $text";
				$sql1 = mysqli_query($mr_con, $query);
				while($row1 = mysqli_fetch_array($sql1)) {
					$sendCcNameArr[] = $row1['privilege_name'];
				}
			}
			$send_to_name = implode("; ", $sendToNameArr);
			$send_cc_name = implode("; ", $sendCcNameArr);

			$objPHPExcel->getActiveSheet()->SetCellValue("A".$coo, $row['entity_label']);
			$objPHPExcel->getActiveSheet()->SetCellValue("B".$coo, $row['communication_type']);
			$objPHPExcel->getActiveSheet()->SetCellValue("C".$coo, $send_to_name);
			$objPHPExcel->getActiveSheet()->SetCellValue("D".$coo, $send_cc_name);
		}
		$objPHPExcel->getActiveSheet()->setTitle('SMS_EMAIL_RECIPIENT');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save("../../exports/$filename.xlsx");
		$result['file_name']=$filename;
		$resCode='0'; $resMsg='export';
	} elseif($chk==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else { 
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
?>