<?php
date_default_timezone_set("Asia/Kolkata");
$maxCount = 10;
require '../Slim/Slim.php';
include('../mysql.php');
include('../functions.php');
include('../Classes/PHPExcel.php');
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->post('/serallowances_add','serallowances_add');
$app->post('/serallowances_edit','serallowances_edit');
$app->post('/serallowances_mul_view','serallowances_mul_view');
$app->post('/serallowances_view','serallowances_view');
$app->post('/serallowances_check_delete_status','serallowances_check_delete_status');
$app->post('/serallowances_delete','serallowances_delete');
$app->post('/othallowances_add','othallowances_add');
$app->post('/othallowances_mul_view','othallowances_mul_view');
$app->post('/othallowances_view','othallowances_view');
$app->post('/othallowances_edit','othallowances_edit');
$app->post('/othallowances_check_delete_status','othallowances_check_delete_status');
$app->post('/othallowances_delete','othallowances_delete');
$app->post('/approvers_add','approvers_add');
$app->post('/approvers_update','approvers_update');
$app->post('/approvers_view','approvers_view');
$app->post('/approvers_mul_view','approvers_mul_view');
$app->post('/approvers_export','approvers_export');
$app->post('/approvers_check_delete_status','approvers_check_delete_status');
$app->post('/approvers_delete','approvers_delete');
$app->post('/limit_add','limit_add');
$app->post('/limit_update','limit_update');
$app->post('/limit_view','limit_view');
$app->post('/limit_mul_view','limit_mul_view');
$app->post('/limit_export','limit_export');
$app->post('/limit_check_delete_status','limit_check_delete_status');
$app->post('/limit_delete','limit_delete');
$app->post('/ser_export','ser_export');
$app->post('/oth_export','oth_export');
$app->post('/exp_dashboard','exp_dashboard');
$app->post('/dashboard_empview','dashboard_empview');
$app->post('/advances_add','advances_add');
$app->post('/advances_update','advances_update');
$app->post('/advances_adv_update','advances_adv_update');
$app->post('/advances_mul_view','advances_mul_view');
$app->post('/advances_view','advances_view');
$app->post('/adv_addview','adv_addview');
$app->post('/advances_export','advances_export');
$app->post('/total_advance','total_advance');
$app->post('/user_expences_mul_view','user_expences_mul_view');
$app->post('/user_expences_view','user_expences_view');
$app->post('/service_expences_add','service_expences_add');
$app->post('/ser_expview','ser_expview');
$app->post('/others_expences_add','others_expences_add');
$app->post('/lod_bod_amt','lod_bod_amt');
$app->post('/cap_weight','cap_weight');
$app->post('/ajaxAmount','ajaxAmount');
$app->post('/others_expences_edit','others_expences_edit');
$app->post('/adv_expences_edit','adv_expences_edit');
$app->post('/service_expences_edit','service_expences_edit');
$app->post('/dpr_details','dpr_details');
$app->post('/del_expenses','del_expenses');
$app->post('/expense_export','expense_export');
$app->post('/expense_import','expense_import');
$app->post('/expense_import_finance','expense_import_finance');
$app->post('/sendexp_email','sendexp_email');
$app->post('/del_mainexp','del_mainexp');
$app->post('/advances_delete','advances_delete');
// New Changes
$app->post('/ser_loc_single_add','ser_loc_single_add');
$app->post('/ser_loc_single_edit','ser_loc_single_edit');
$app->post('/oth_loc_single_add','oth_loc_single_add');
$app->post('/oth_loc_single_edit','oth_loc_single_edit');
$app->post('/loc_single_view','loc_single_view');
$app->post('/ser_con_single_add','ser_con_single_add');
$app->post('/oth_con_single_add','oth_con_single_add');
$app->post('/con_single_view','con_single_view');
$app->post('/ser_con_single_edit','ser_con_single_edit');
$app->post('/oth_con_single_edit','oth_con_single_edit');
$app->post('/ser_lod_single_add','ser_lod_single_add');
$app->post('/oth_lod_single_add','oth_lod_single_add');
$app->post('/lod_single_view','lod_single_view');
$app->post('/ser_lod_single_edit','ser_lod_single_edit');
$app->post('/oth_lod_single_edit','oth_lod_single_edit');
$app->post('/ser_bod_single_add','ser_bod_single_add');
$app->post('/oth_bod_single_add','oth_bod_single_add');
$app->post('/bod_single_view','bod_single_view');
$app->post('/ser_bod_single_edit','ser_bod_single_edit');
$app->post('/oth_bod_single_edit','oth_bod_single_edit');
$app->post('/ser_oth_single_add','ser_oth_single_add');
$app->post('/oth_oth_single_add','oth_oth_single_add');
$app->post('/oth_single_view','oth_single_view');
$app->post('/ser_oth_single_edit','ser_oth_single_edit');
$app->post('/oth_oth_single_edit','oth_oth_single_edit');
$app->post('/del_dyn_expenses','del_dyn_expenses');
$app->post('/expense_main_edit','expense_main_edit');
$app->post('/expense_main_adv_edit','expense_main_adv_edit');
$app->post('/user_main_expences_view','user_main_expences_view');
$app->post('/user_expense_submit','user_expense_submit');
$app->post('/user_expense_adv_save','user_expense_adv_save');
$app->post('/expense_status_change','expense_status_change');
$app->post('/advance_status_change','advance_status_change');
$app->post('/expense_delete','expense_delete');

$app->run();
// Start -Admin Settings
function serallowances_add(){ 
	global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk=='0'){
		for($i=0;$i<count($_REQUEST['district']);$i++){
		$alias=aliasCheck(generateRandomString(),"ec_service_allowances","service_allowance_alias");
		$zone=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['zone'][$i])));
		$state=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['state'][$i])));
		$district=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['district'][$i])));
		$zone1=alias(alias($_REQUEST['district'][$i],'ec_district','district_alias','state_alias'),'ec_state','state_alias','zone_alias');
		$state1=alias($_REQUEST['district'][$i],'ec_district','district_alias','state_alias') ;
		$districtname=alias($_REQUEST['district'][$i],'ec_district','district_alias','district_name');
		$lodging_amt=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['lodging_amount'])));
		$daily_allowance=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['daily_allowance'])));
		$local_conveyance=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['local_conveyance'])));
		if($zone=='0'){$res= "Select Zone";}
		elseif($state=='0'){$res= "Select State";}
		elseif($district=='0'){$res= "Select District";}
		elseif($lodging_amt==''){$res= "Enter Lodging Amount";}
		elseif($daily_allowance==''){$res= "Enter Daily Allowance";}
		elseif($local_conveyance==''){$res= "Enter Local Conveyance";}
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_service_allowances WHERE district_alias = '".$district."'");
			if(mysqli_num_rows($q)=='0'){
				$sql=mysqli_query($mr_con,"INSERT INTO ec_service_allowances (zone_alias, state_alias, district_alias, lodging_amount, daily_allowance, local_conveyance, service_allowance_alias, created_date) VALUES ('".$zone1."','".$state1."','".$district."','".$lodging_amt."','".$daily_allowance."','".$local_conveyance."','".$alias."','".date("Y-m-d")."')");
				if($sql){
					$action = "Service allowances added for district : ".$districtname;
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$resCode='0';$resMsg='Successful!';
				}else{$resCode='4';$resMsg='Error in Creating!';}
			}else{$res = 'Already exist';}
		}}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);	
}
function serallowances_edit(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$ser_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['service_allowance_alias']));
		$zone=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['zone'])));
		$state=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['state'])));
		$district=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['district'])));
		$districtname=alias($_REQUEST['district'],'ec_district','district_alias','district_name');
		$lodging_amt=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['lodging_amount'])));
		$daily_allowance=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['daily_allowance'])));
		$local_conveyance=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['local_conveyance'])));
		if($zone=='0'){$res= "Select Zone";}
		elseif($state=='0'){$res= "Select State";}
		elseif($district=='0'){$res= "Select District";}
		elseif($lodging_amt==''){$res= "Enter Lodging Amount";}
		elseif($daily_allowance==''){$res= "Enter Daily Allowance";}
		elseif($local_conveyance==''){$res= "Enter Local Conveyance";}
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_service_allowances WHERE district_alias = '".$district."' AND service_allowance_alias <> '$ser_alias'");
			if(mysqli_num_rows($q)=='0'){
				$sql=mysqli_query($mr_con,"UPDATE ec_service_allowances SET zone_alias='$zone',state_alias='$state',district_alias='$district',lodging_amount='$lodging_amt',daily_allowance='$daily_allowance',local_conveyance='$local_conveyance' WHERE service_allowance_alias='$ser_alias'");
				if($sql){
					$action = "Service allowances updated for district : ".$districtname;
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['token']);
					$resCode='0';$resMsg='Successful!';}
				else{$resCode='4';$resMsg='Error in Updating!';}
			}else{$res = 'Already exist';}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function serallowances_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk=='0'){
			$ser_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
			$sql=mysqli_query($mr_con,"SELECT *,(SELECT i.zone_name FROM ec_zone i WHERE i.zone_alias = s.zone_alias) AS zone_name, (SELECT t.state_name FROM ec_state t WHERE t.state_alias = s.state_alias) AS state_name,(SELECT d.district_name FROM ec_district d WHERE d.district_alias = s.district_alias) AS district_name,(SELECT d.area FROM ec_district d WHERE d.district_alias = s.district_alias) AS area FROM ec_service_allowances s WHERE s.service_allowance_alias='$ser_alias' AND s.flag=0");
			if(mysqli_num_rows($sql)>'0'){
				$row=mysqli_fetch_array($sql);
					$result['zone_name']=$row['zone_name'];
					$result['zone_alias']=$row['zone_alias'];
					$result['state_name']=$row['state_name'];
					$result['state_alias']=$row['state_alias'];
					$result['district_name']=$row['district_name'];
					$result['district_alias']=$row['district_alias'];
					if($row['area'] == '0')$area_disp = "PLAIN AREA";else $area_disp = "HILLY AREA";
					$result['area']=$area_disp;
					$result['lodging_amount']=$row['lodging_amount'];
					$result['daily_allowance']=$row['daily_allowance'];
					$result['local_conveyance']=$row['local_conveyance'];
					$result['service_allowance_alias']=$row['service_allowance_alias'];
					$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function serallowances_mul_view(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex=='0'){
		$zone=mysqli_real_escape_string($mr_con,$_REQUEST['zoneAlias']);
		$state=mysqli_real_escape_string($mr_con,$_REQUEST['stateAlias']);
		$district=mysqli_real_escape_string($mr_con,$_REQUEST['districtAlias']);
		$lamt=mysqli_real_escape_string($mr_con,$_REQUEST['ldgAmntAlias']);
		$dailyallow=mysqli_real_escape_string($mr_con,$_REQUEST['dailyallowAlias']);
		$lclconv=mysqli_real_escape_string($mr_con,$_REQUEST['lclconvAlias']);
		$area=mysqli_real_escape_string($mr_con,$_REQUEST['areaAlias']);
		if($zone!="")$condition= " s.zone_alias LIKE '%".$zone."%' AND ";
		if($state!="") $condition.=" s.state_alias IN (select state_alias from ec_state where state_name like '%".$state."%' and flag=0) AND ";
		if($district!="") $condition.=" s.district_alias IN (select district_alias from ec_district where district_name like '%".$district."%' and flag=0) AND ";
		if($lamt!="")$condition.=" s.lodging_amount LIKE '%".$lamt."%' AND ";
		if($dailyallow!="")$condition.=" s.daily_allowance LIKE '%".$dailyallow."%' AND ";
		if($lclconv!="")$condition.=" s.local_conveyance LIKE '%".$lclconv."%' AND ";
		if($area != ""){
		$rec=mysqli_query($mr_con,"SELECT count(s.id) FROM ec_service_allowances s,ec_district d WHERE $condition s.district_alias = d.district_alias AND d.area=$area AND s.flag=0");
		}else{
		$rec=mysqli_query($mr_con,"SELECT count(s.id) FROM ec_service_allowances s WHERE $condition s.flag=0");
		}
		if(mysqli_num_rows($rec)>'0'){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			if($area != ""){
				$sql=mysqli_query($mr_con,"SELECT *,(SELECT i.zone_name FROM ec_zone i WHERE i.zone_alias = s.zone_alias) AS zone_name, (SELECT t.state_name FROM ec_state t WHERE t.state_alias = s.state_alias) AS state_name,(SELECT d.district_name FROM ec_district d WHERE d.district_alias = s.district_alias) AS district_name,(SELECT d.area FROM ec_district d WHERE d.district_alias = s.district_alias) AS area FROM ec_service_allowances s,ec_district d WHERE $condition s.district_alias = d.district_alias AND d.area='$area' AND s.flag=0 ORDER BY s.id LIMIT $offset, $limit");
			}else{
				$sql=mysqli_query($mr_con,"SELECT *,(SELECT i.zone_name FROM ec_zone i WHERE i.zone_alias = s.zone_alias) AS zone_name, (SELECT t.state_name FROM ec_state t WHERE t.state_alias = s.state_alias) AS state_name,(SELECT d.district_name FROM ec_district d WHERE d.district_alias = s.district_alias) AS district_name,(SELECT d.area FROM ec_district d WHERE d.district_alias = s.district_alias) AS area FROM ec_service_allowances s WHERE $condition s.flag=0  ORDER BY s.id LIMIT $offset, $limit");
			}
			$result['serallowancesDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['serallowancesDetails'][$i]['zone_name']=$row['zone_name'];
					$result['serallowancesDetails'][$i]['state_name']=$row['state_name'];
					$result['serallowancesDetails'][$i]['district_name']=$row['district_name'];
					if($row['area'] == '0')$area_disp = "PLAIN AREA";else $area_disp = "HILLY AREA";
					$result['serallowancesDetails'][$i]['area']=$area_disp;
					$result['serallowancesDetails'][$i]['lodging_amount']=$row['lodging_amount'];
					$result['serallowancesDetails'][$i]['daily_allowance']=$row['daily_allowance'];
					$result['serallowancesDetails'][$i]['local_conveyance']=$row['local_conveyance'];
					$result['serallowancesDetails'][$i]['service_allowance_alias']=$row['service_allowance_alias'];
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
	$result['add'] = grantable('ADD', 'ALLOWANCES', $emp_alias);
	$result['edit'] = grantable('EDIT', 'ALLOWANCES', $emp_alias);
	$result['delete'] = grantable('DELETE', 'ALLOWANCES', $emp_alias);
	$result['view'] = grantable('VIEW', 'ALLOWANCES', $emp_alias);
	$result['export'] = grantable('EXPORT', 'ALLOWANCES', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);		
}
function ser_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk=='0'){
	$sql = mysqli_query($mr_con,"SELECT *,(SELECT i.zone_name FROM ec_zone i WHERE i.zone_alias = s.zone_alias) AS zone_name, (SELECT t.state_name FROM ec_state t WHERE t.state_alias = s.state_alias) AS state_name,(SELECT d.district_name FROM ec_district d WHERE d.district_alias = s.district_alias) AS district_name,(SELECT d.area FROM ec_district d WHERE d.district_alias = s.district_alias) AS area FROM ec_service_allowances s WHERE s.flag=0 ORDER BY s.id");
	$colArr=array('Zone','State','District','Area','Lodging Amount','Daily Allowance','Local Conveyance');
	$filename = 'Service_Allowance_'.date('d-m-Y H_i_s');
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
					if($row['area'] == '0')$area_disp = "PLAIN AREA";else $area_disp = "HILLY AREA";
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$coo, $row['zone_name']);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$coo, $row['state_name']);
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$coo, $row['district_name']);
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$coo, $area_disp);
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$coo, $row['lodging_amount']);
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$coo, $row['daily_allowance']);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$coo, $row['local_conveyance']);
				}
	$objPHPExcel->getActiveSheet()->setTitle('Approvers');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("../../exports/$filename.xlsx");
	$result['file_name']=$filename;
	$resCode='0'; $resMsg='export';
	}
	elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function othallowances_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk=='0'){
			$alias=aliasCheck(generateRandomString(),"ec_daily_allowances","allowance_alias",$mr_con);
			$grade=$_REQUEST['grade'];
			$amt1=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt1']));
			$amt2=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt2']));
			$amt3=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt3']));
			$amt4=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt4']));
			$amt5=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt5']));
			$amt6=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt6']));
			$amt7=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt7']));

			$amt8=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt8']));
			$amt9=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt9']));
			$mot=strtoupper(mysqli_real_escape_string($mr_con,implode(", ",$_REQUEST['mot'])));
			$molc=strtoupper(mysqli_real_escape_string($mr_con,implode(", ",$_REQUEST['molc'])));
			if($grade==''){$res= "Select Grade";}
			elseif($mot==''){$res= "Select Mode of travel";}
			elseif($molc==''){$res= "Select Mode of Local Conveyance";}
			elseif($amt1=='' ||$amt1=='0'){$res= "Enter Lodging Allowances A+";}
			elseif($amt2=='' ||$amt2=='0'){$res= "Enter Lodging Allowances A";}
			elseif($amt3=='' ||$amt3=='0'){$res= "Enter Lodging Allowances B";}
			elseif($amt4=='' ||$amt4=='0'){$res= "Enter Lodging Allowances C";}
			elseif($amt5=='' ||$amt5=='0'){$res= "Enter Daily/Boarding Allowances A+";}
			elseif($amt6=='' ||$amt6=='0'){$res= "Enter Daily/Boarding Allowances A";}
			elseif($amt7=='' ||$amt7=='0'){$res= "Enter Daily/Boarding Allowances B";}
			elseif($amt8=='' ||$amt8=='0'){$res= "Enter Daily/Boarding Allowances C";}
			elseif($amt9=='' ||$amt9=='0'){$res= "Enter Mobile Roaming Charges";}
			else{
				if(alreadyexist($grade,'ec_daily_allowances','grade',$mr_con)==0){
					$sql=mysqli_query($mr_con,"INSERT INTO ec_daily_allowances (grade, lodging_allowances_a1, lodging_allowances_a, lodging_allowances_b, lodging_allowances_c, boarding_allowances_a1, boarding_allowances_a, boarding_allowances_b, boarding_allowances_c, mode_of_travel, mode_of_conveyance, mobile_roaming, allowance_alias, created_date) VALUES ('".$grade."','".$amt1."','".$amt2."','".$amt3."','".$amt4."','".$amt5."','".$amt6."','".$amt7."','".$amt8."','".$mot."','".$molc."','".$amt9."','".$alias."','".date("Y-m-d")."')");
					if($sql){
						$action= "Allowances created for grade ".$grade;
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
						$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Creating!';}
				}else{
					$res = 'Already exist';
				}
			}
			if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
			$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
			echo json_encode($result);	
}
function othallowances_mul_view(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex=='0'){
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_daily_allowances WHERE flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
				$sql=mysqli_query($mr_con,"SELECT grade, lodging_allowances_a1, lodging_allowances_a, lodging_allowances_b, lodging_allowances_c, boarding_allowances_a1, boarding_allowances_a, boarding_allowances_b, boarding_allowances_c, mode_of_travel, mode_of_conveyance, mobile_roaming, allowance_alias FROM ec_daily_allowances WHERE flag=0 GROUP BY grade LIMIT $offset, $limit");
				$result['othallowancesDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['othallowancesDetails'][$i]['grade']=$row['grade'];
					$result['othallowancesDetails'][$i]['lodging_allowances_a1']=$row['lodging_allowances_a1'];
					$result['othallowancesDetails'][$i]['lodging_allowances_a']=$row['lodging_allowances_a'];
					$result['othallowancesDetails'][$i]['lodging_allowances_b']=$row['lodging_allowances_b'];
					$result['othallowancesDetails'][$i]['lodging_allowances_c']=$row['lodging_allowances_c'];
					$result['othallowancesDetails'][$i]['boarding_allowances_a1']=$row['boarding_allowances_a1'];
					$result['othallowancesDetails'][$i]['boarding_allowances_a']=$row['boarding_allowances_a'];
					$result['othallowancesDetails'][$i]['boarding_allowances_b']=$row['boarding_allowances_b'];
					$result['othallowancesDetails'][$i]['boarding_allowances_c']=$row['boarding_allowances_c'];
					$result['othallowancesDetails'][$i]['mode_of_travel']=$row['mode_of_travel'];
					$result['othallowancesDetails'][$i]['mode_of_conveyance']=$row['mode_of_conveyance'];
					$result['othallowancesDetails'][$i]['mobile_roaming']=$row['mobile_roaming'];
					$result['othallowancesDetails'][$i]['allowance_alias']=$row['allowance_alias'];
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
	$result['add'] = grantable('ADD', 'ALLOWANCES', $emp_alias);
	$result['edit'] = grantable('EDIT', 'ALLOWANCES', $emp_alias);
	$result['delete'] = grantable('DELETE', 'ALLOWANCES', $emp_alias);
	$result['view'] = grantable('VIEW', 'ALLOWANCES', $emp_alias);
	$result['export'] = grantable('EXPORT', 'ALLOWANCES', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);		
}
function othallowances_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk=='0'){
			$oth_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
			$sql=mysqli_query($mr_con,"SELECT grade, lodging_allowances_a1, lodging_allowances_a, lodging_allowances_b, lodging_allowances_c, boarding_allowances_a1, boarding_allowances_a, boarding_allowances_b, boarding_allowances_c, mode_of_travel, mode_of_conveyance, mobile_roaming, allowance_alias FROM ec_daily_allowances WHERE allowance_alias='$oth_alias' AND flag=0");
			if(mysqli_num_rows($sql)>0){
				$row=mysqli_fetch_array($sql);
				$result['allowance_alias']=$row['allowance_alias'];	
					$result['grade']=$row['grade'];		
					$result['designation']=gradedesg1($row['grade']);			
					$result['lodging_allowances_a1']=$row['lodging_allowances_a1'];
					$result['lodging_allowances_a']=$row['lodging_allowances_a'];
					$result['lodging_allowances_b']=$row['lodging_allowances_b'];
					$result['lodging_allowances_c']=$row['lodging_allowances_c'];
					$result['boarding_allowances_a1']=$row['boarding_allowances_a1'];
					$result['boarding_allowances_a']=$row['boarding_allowances_a'];
					$result['boarding_allowances_b']=$row['boarding_allowances_b'];
					$result['boarding_allowances_c']=$row['boarding_allowances_c'];
					$result['mode_of_travel']=$row['mode_of_travel'];
					$result['mode_of_conveyance']=$row['mode_of_conveyance'];
					$result['mobile_roaming']=$row['mobile_roaming'];
					$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function othallowances_edit(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk=='0'){
		$allowance_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['allowance_alias']));
		$gradename=alias($allowance_alias,'ec_daily_allowances','allowance_alias','grade');
		$amt1=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt1']));
		$amt2=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt2']));
		$amt3=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt3']));
		$amt4=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt4']));
		$amt5=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt5']));
		$amt6=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt6']));
		$amt7=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt7']));
		$amt8=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt8']));

		$amt9=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt9']));
		$mot=strtoupper(mysqli_real_escape_string($mr_con,implode(", ",$_REQUEST['mot'])));
		$molc=strtoupper(mysqli_real_escape_string($mr_con,implode(", ",$_REQUEST['molc'])));
		if($mot==''){$res= "Select Mode of travel";}
		elseif($molc==''){$res= "Select Mode of Local Conveyance";}
		elseif($amt1=='' ||$amt1=='0'){$res= "Enter Lodging Allowances A+";}
		elseif($amt2=='' ||$amt2=='0'){$res= "Enter Lodging Allowances A";}
		elseif($amt3=='' ||$amt3=='0'){$res= "Enter Lodging Allowances B";}
		elseif($amt4=='' ||$amt4=='0'){$res= "Enter Lodging Allowances C";}
		elseif($amt5=='' ||$amt5=='0'){$res= "Enter Daily/Boarding Allowances A+";}
		elseif($amt6=='' ||$amt6=='0'){$res= "Enter Daily/Boarding Allowances A";}
		elseif($amt7=='' ||$amt7=='0'){$res= "Enter Daily/Boarding Allowances B";}
		elseif($amt8=='' ||$amt8=='0'){$res= "Enter Daily/Boarding Allowances C";}
		elseif($amt9=='' ||$amt9=='0'){$res= "Enter Mobile Roaming Charges";}
		else{
			$sql=mysqli_query($mr_con,"UPDATE ec_daily_allowances SET lodging_allowances_a1='$amt1',lodging_allowances_a='$amt2',lodging_allowances_b='$amt3',lodging_allowances_c='$amt4',boarding_allowances_a1='$amt5',boarding_allowances_a='$amt6',boarding_allowances_b='$amt7',boarding_allowances_c='$amt8',mode_of_travel='$mot',mode_of_conveyance='$molc',mobile_roaming='$amt9' WHERE allowance_alias='$allowance_alias'");
			if($sql){
				$action= "Allowances updated for grade ".$gradename;
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';}
			else{$resCode='4';$resMsg='Error in Updating!';}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function oth_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk=='0'){
	$sql = mysqli_query($mr_con,"SELECT grade, lodging_allowances_a1, lodging_allowances_a, lodging_allowances_b, lodging_allowances_c, boarding_allowances_a1, boarding_allowances_a, boarding_allowances_b, boarding_allowances_c, mode_of_travel, mode_of_conveyance, mobile_roaming, allowance_alias FROM ec_daily_allowances WHERE flag=0 GROUP BY grade");
	//$colArr=array('Grade','Lodging Allowances','Daily/Boarding Allowances','Mode Of Trave','Mode Of Local Conveyance','Mobile Roaming');
	$colArr2=array('','A+','A','B','C','A+','A','B','C','','','in Rs');
	$colArr = array("A"=>"Grade", "B"=>"Lodging Allowances", "F"=>"Daily/Boarding Allowances", "J"=>"Mode Of Trave", "K"=>"Mode Of Local Conveyance", "L"=>"Mobile Roaming");
	$filename = 'Allowance_'.date('d-m-Y H_i_s');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
	$objPHPExcel->getActiveSheet()->mergeCells('B1:E1');
	$objPHPExcel->getActiveSheet()->mergeCells('F1:I1');
	foreach($colArr as $x => $colrefValue){ 
		$objPHPExcel->getActiveSheet()->SetCellValue($x.'1',ucfirst($colrefValue));
		$objPHPExcel->getActiveSheet()->getStyle($x.'1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle($x.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
	}
	$ch = 'A';
	foreach($colArr2 as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'2',ucfirst($colrefValue));
		$objPHPExcel->getActiveSheet()->getStyle($ch.'2')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle($ch.'2')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
	$ch++;
	}
	$coo=2;
	while($row=mysqli_fetch_array($sql)){ $coo++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$coo, $row['grade']);
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$coo, $row['lodging_allowances_a1']);
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$coo, $row['lodging_allowances_a']);
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$coo, $row['lodging_allowances_b']);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$coo, $row['lodging_allowances_c']);
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$coo, $row['boarding_allowances_a1']);
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$coo, $row['boarding_allowances_a']);
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$coo, $row['boarding_allowances_b']);
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.$coo, $row['boarding_allowances_c']);
		$objPHPExcel->getActiveSheet()->SetCellValue('J'.$coo, $row['mode_of_travel']);
		$objPHPExcel->getActiveSheet()->SetCellValue('K'.$coo, $row['mode_of_conveyance']);
		$objPHPExcel->getActiveSheet()->SetCellValue('L'.$coo, $row['mobile_roaming']);
	}
	$objPHPExcel->getActiveSheet()->setTitle('Approvers');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("../../exports/$filename.xlsx");
	$result['file_name']=$filename;
	$resCode='0'; $resMsg='export';
	}
	elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function approvers_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$exist = array();
			$app_level = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['app_level'])));
			$levlna = expense_levels($app_level);
			for($a=0;$a<count($_REQUEST['department_alias']);$a++){
			$alias=aliasCheck(generateRandomString(),"ec_expense_approvals","approval_alias");
			$department_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['department_alias'][$a])));
			$appdepartment_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['appdepartment_alias'])));
			$emp_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['employ_alias'])));
			if($department_name==''){$res= "Please Enter Department Name";}
			elseif($app_level==''){$res= "Please Enter Approvel Level";}
			elseif($appdepartment_name==''){$res= "Please Enter ApprovelDepartment";}
			elseif($emp_name==''){$res= "Please Enter Employee Name";}
			else{$ins=0;
				if(alreadyexist_level($department_name,$app_level,$mr_con)==0){
					$sql=mysqli_query($mr_con,"INSERT INTO ec_expense_approvals(approval_dep,approval_level,approver_dep,approver,approval_alias,created_date) VALUES('$department_name','$app_level','$appdepartment_name','$emp_name','$alias','".date('Y-m-d')."')");
						if($sql){ $ins=1; $resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Creating!';}
					}else{
						array_push($exist,$department_name);
						//$res = 'The Requested Approval Name has already exist, Try with other values';
					}
				}
			}
			$err="";
			if(count($exist)!=0){
				for($i=0;$i<count($exist);$i++){
					$err .= alias($exist[$i],'ec_department','department_alias','department_name');
					if($err!= '' && $i!=count($exist) && count($exist)!='1') $err .= ', ';
				}
				
				if($err != ''){$err = 'The requested '.$err.' already exist in '.$levlna;}
				if($ins==1 && $err != ''){$err .= 'Remaining records inserted Successfully';}	
				$res = $err;			
				if(isset($res)){$resCode='4';$resMsg=$res;}
			}else{$resCode='0';$resMsg="Inserted Successfully";}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);	
}
function approvers_update(){ global $mr_con;
		$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$approval_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['approval_alias']));
			$appdepartment_name = $_REQUEST['appdepartment_alias'];
			$emp_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['employ_alias'])));
			if($appdepartment_name==''){$res= "Please Enter ApprovelDepartment";}
			elseif($emp_name==''){$res= "Please Enter Employee Name";}
			else{
				$sql=mysqli_query($mr_con,"UPDATE ec_expense_approvals SET approver_dep='$appdepartment_name',approver='$emp_name' WHERE approval_alias='$approval_alias' AND flag=0");
				if($sql){$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Updating!';}
			}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function approvers_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$approval_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
			$sql=mysqli_query($mr_con,"SELECT approval_dep,approval_level,approver_dep,approver,approval_alias FROM ec_expense_approvals WHERE approval_alias='$approval_alias' AND flag=0");			
			if(mysqli_num_rows($sql)>0){
				$row=mysqli_fetch_array($sql);
					$result['approval_deptalias']=$row['approval_dep'];					
					$result['approval_dept_alias']=$row['approval_dep'];
					$result['approval_dept']=alias($row['approval_dep'],'ec_department','department_alias','department_name');
					$result['approval_levelalias']=$row['approval_level']; 
					$result['approval_level']=expense_levels($row['approval_level']);
					$result['approver_depalias']=$row['approver_dep'];
					$result['approver_dep']=alias($row['approver_dep'],'ec_department','department_alias','department_name');
					$result['approveralias']=$row['approver'];
					$result['approver']=alias($row['approver'],'ec_employee_master','employee_alias','name');
					$result['approval_alias']=$row['approval_alias'];
					$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function approvers_mul_view(){ global $mr_con;
		$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){
		if($_REQUEST['department_alias']!="") $condition=" approval_dep IN (select department_alias from ec_department where department_name like '%".mysqli_real_escape_string($mr_con,$_REQUEST['department_alias'])."%' and flag=0) AND ";
		if($_REQUEST['app_level']!="")$condition.="approval_level ='".mysqli_real_escape_string($mr_con,$_REQUEST['app_level'])."' AND ";
		if($_REQUEST['appdepartment_alias']!="") $condition.=" approver_dep IN (select department_alias from ec_department where department_name like '%".mysqli_real_escape_string($mr_con,$_REQUEST['appdepartment_alias'])."%' and flag=0) AND ";
		if($_REQUEST['employ_alias']!="") $condition.=" approver IN (select employee_alias from ec_employee_master where name like '%".mysqli_real_escape_string($mr_con,$_REQUEST['employ_alias'])."%' and flag=0) AND ";
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_expense_approvals WHERE $condition flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT approval_dep,approval_level,approver_dep,approver,approval_alias FROM ec_expense_approvals WHERE $condition flag=0 LIMIT $offset, $limit");
			$result['approverDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['approverDetails'][$i]['approval_deptalias']=$row['approval_dep'];
					$result['approverDetails'][$i]['approval_dept']=alias($row['approval_dep'],'ec_department','department_alias','department_name'); 
					$result['approverDetails'][$i]['approval_levelalias']=$row['approval_level'];
					$result['approverDetails'][$i]['approval_level']=expense_levels($row['approval_level']);
					$result['approverDetails'][$i]['approver_depalias']=$row['approver_dep'];
					$result['approverDetails'][$i]['approver_dep']=alias($row['approver_dep'],'ec_department','department_alias','department_name'); 
					$result['approverDetails'][$i]['approveralias']=$row['approver'];
					$result['approverDetails'][$i]['approver']=alias($row['approver'],'ec_employee_master','employee_alias','name'); 
					$result['approverDetails'][$i]['approval_alias']=$row['approval_alias'];  
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
	$result['add'] = grantable('ADD', 'APPROVERS', $emp_alias);
	$result['edit'] = grantable('EDIT', 'APPROVERS', $emp_alias);
	$result['delete'] = grantable('DELETE', 'APPROVERS', $emp_alias);
	$result['view'] = grantable('VIEW', 'APPROVERS', $emp_alias);
	$result['export'] = grantable('EXPORT', 'APPROVERS', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function approvers_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_expense_approvals WHERE flag=0");
	$colArr=array('Approval Department','Approval Level','Approver Department','Approver');
	$filename = 'Approvers_'.date('d-m-Y H_i_s');
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
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$coo, alias($row['approval_dep'],'ec_department','department_alias','department_name'));
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$coo, expense_levels($row['approval_level']));
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$coo, alias($row['approver_dep'],'ec_department','department_alias','department_name'));
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$coo, alias($row['approver'],'ec_employee_master','employee_alias','name'));
				}
	$objPHPExcel->getActiveSheet()->setTitle('Approvers');
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
function limit_add(){ global $mr_con;
		$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$exist = array();
			$limit_amount = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['limit_amount'])));
			if($limit_amount==''){$resCode='4';$resMsg= "Please Enter Limit Amount";}else{
			for($i=0;$i<count($_REQUEST['designation_alias']);$i++){
				$alias=aliasCheck(generateRandomString(),"ec_expense_limits","limit_alias");
				 $designation_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['designation_alias'][$i])));
				 $desg_name = alias($designation_name,"ec_designation","designation_alias","designation");
				if($designation_name=='0'){$res= "Please Enter Designation Name";}
				else{
				$q=mysqli_query($mr_con,"SELECT id FROM ec_expense_limits WHERE designation_alias='$designation_name' AND flag=0");
					if(mysqli_num_rows($q)==0){
						$sql=mysqli_query($mr_con,"INSERT INTO ec_expense_limits(designation_alias,limit_amount,limit_alias,created_date) VALUES('$designation_name','$limit_amount','$alias','".date('Y-m-d')."')");
						$action= "Limit added for designation ".$desg_name;
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);														
					}else{
						array_push($exist,$designation_name);
						//$res = 'The Requested Approval Name has already exist, Try with other values';
					}
				}
			}
			$err="";
			if(count($exist)!=0){
				for($i=0;$i<count($exist);$i++){
					$err .= alias($exist[$i],'ec_designation','designation_alias','designation');
					if($err!= '' && $i!=count($exist) && count($exist)!='1') $err .= ', ';
				}
			if($err != ''){$err = 'The Requested '.$err.' already exist in Limits';}
			if($ins==1 && $err != ''){$err .= 'Remaining records inserted Successfully';}	
			$res = $err;
			if(isset($res)){$resCode='4';$resMsg=$res;}
			}else{$resCode='0';$resMsg="Limits Inserted Successfully";}
			}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
			$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
			echo json_encode($result);
}
function limit_update(){ global $mr_con;
		$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
				$limit_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['limit_alias']));
				$designation_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['designation_alias'])));
				$limit_amount = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['limit_amount'])));
			if($designation_name=='0'){$res= "Please Enter Designation Name";}
			elseif($limit_amount==''){$res= "Please Enter Limit Amount";}
			else{
				$sql=mysqli_query($mr_con,"UPDATE ec_expense_limits SET limit_amount='$limit_amount' WHERE limit_alias='$limit_alias' AND flag=0");
				if($sql){
					$action= "Limit updated for designation ".$designation_name;
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);														
					$resCode='0';$resMsg='Successful!';
				}else{$resCode='4';$resMsg='Error in Updating!';}
			}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function limit_view(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$limit_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
			$sql=mysqli_query($mr_con,"SELECT designation_alias,limit_amount,limit_alias FROM ec_expense_limits WHERE limit_alias='$limit_alias' AND flag=0");
			if(mysqli_num_rows($sql)>0){
				$row=mysqli_fetch_array($sql);
					$result['designationAlias']=$row['designation_alias'];
					$result['designation_alias']=alias($row['designation_alias'],'ec_designation','designation_alias','designation');
					$result['limit_amount']=$row['limit_amount'];
					$result['limit_alias']=$row['limit_alias'];
					$resCode='0'; $resMsg='Successful!';
				}else{$resCode='4';$resMsg='No Records Found!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function limit_mul_view(){ global $mr_con;
		$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
		$rex=authentication($emp_alias,$token);
		if($rex==0){$asc="";
		if($_REQUEST['designation_alias']!="") $condition.=" designation_alias IN (SELECT designation_alias FROM ec_designation WHERE designation LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['designation_alias'])."%' AND flag=0) AND ";
		if($_REQUEST['limit_amount']!=""){$condition.="limit_amount LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['limit_amount'])."%' AND ";$asc="ORDER BY limit_amount ASC";}
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_expense_limits WHERE $condition flag=0 $asc");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT designation_alias,limit_amount,limit_alias FROM ec_expense_limits WHERE $condition flag=0 $asc LIMIT $offset, $limit");
			$result['limitDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['limitDetails'][$i]['designation_alias']=alias($row['designation_alias'],'ec_designation','designation_alias','designation'); 
					$result['limitDetails'][$i]['limit_amount']=$row['limit_amount'];
					$result['limitDetails'][$i]['limit_alias']=$row['limit_alias'];   
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
	$result['add'] = grantable('ADD', 'LIMITS', $emp_alias);
	$result['edit'] = grantable('EDIT', 'LIMITS', $emp_alias);
	$result['delete'] = grantable('DELETE', 'LIMITS', $emp_alias);
	$result['view'] = grantable('VIEW', 'LIMITS', $emp_alias);
	$result['export'] = grantable('EXPORT', 'LIMITS', $emp_alias);
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function limit_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_expense_limits WHERE flag=0");
	$colArr=array('Designation','Limit Amount');
	$colArr2=array('limit_amount');
	$filename = 'Limits_'.date('d-m-Y H_i_s');
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
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$coo, alias($row['designation_alias'],'ec_designation','designation_alias','designation'));
					for($af=0,$chr='B';$af<count($colArr2);$af++,$chr++){
					$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
					}
				}
	$objPHPExcel->getActiveSheet()->setTitle('Limits');
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
// Start - User Advances
// Start - User Advances
function advances_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$listDgn=listPendingAdvances($_REQUEST['emp_alias']);
		if($listDgn!=0){foreach($listDgn as $rec){
			$sw=employeeDetails('name',$rec['approved_by']);
			$result['request_id']=$rec['request_id'];
			$result['total_amount']=$rec['total_amount'];
			$result['requested_date']=$rec['requested_date'];
			$result['approved_by']=$sw;}}
		
			if($_REQUEST['emp_alias']!=""){
			$alias = aliasCheck(generateRandomString(),'ec_advances','advance_alias');
			$date_of_request = date('Y-m-d');
			$employee_id = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['employee_id']));
			$employee_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['employee_name']));
			$grade = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['grade']));
			$credit_limit = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['credit_limit']));
			$prev_adv = mysqli_real_escape_string($mr_con,$_REQUEST['prev_adv']);
			$current_request = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['current_request']));
			$remarks = mysqli_real_escape_string($mr_con,$_REQUEST['remarks']);
			$requestid="#".checkint(mt_rand(1000,999999999),'ec_advances','request_id');
			$remalias = aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
				if(empty($current_request)){$res="Please Enter Current Request";}
				elseif(empty($remarks)){$res="Please Enter Remarks";}
				else{$check=FALSE;
					if($_REQUEST['dept_name']!='3'){
						if(($_FILES['tplanningreport']['size']>'0')){
							$ext = pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION);
							if($ext=='pdf' || $ext=='PDF'){
								if($_FILES['tplanningreport']['size']>1153433){$res="File Size Should be less than or equal to 1MB";}else{
								$fileName=$empalias.generateRandomString()."ADV.".$ext;
								$upfile=move_uploaded_file($_FILES["tplanningreport"]["tmp_name"],"../../attachments/tourReport/".$fileName);
								if($upfile){$profileimg = "attachments/tourReport/".$fileName;$check=TRUE;}else{$profileimg="";}
								}
							}else{$res="Upload PDF files Only";}				
						}else{$res="Upload Tour Planning Report";}
					}else{$check=TRUE;}
					
					if($check){
						if($_REQUEST['ref']=="draft"){
								$ext = pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION);
								$q=mysqli_query($mr_con,"INSERT INTO ec_advances(employee_alias,request_amount,total_amount,request_id,requested_date,report,advance_alias,approval_level) VALUES('$_REQUEST[emp_alias]','$current_request','$current_request','$requestid','$date_of_request','$profileimg','$alias','0')");
								if($q){
									$action = "Advance request id: ".$requestid." saved in drafts";
									user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
								$rem=mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remarked_on,remark_alias) VALUES('$remarks','BA','$alias','$_REQUEST[emp_alias]','".date('Y-m-d')."','$remalias')");
								$emcheck=alias($requestid,'ec_advances','request_id','employee_alias');
								if($emcheck=="NA" || $emcheck==""){
									$resCode='0';$resMsg="Your Request ID ".$requestid." has been saved, But Will not Reflect in you details, So contact Admin";
								}else{
									$url=localURL()."enersys_expense/maillings/book_advance.php?ref=".$alias;
									//file_get_contents($url);
									curlxing($url);
								$resCode='0'; $resMsg='Advance Request Saved';								
								}
							$resCode='0'; $resMsg='Advance Request Saved!';} else { $resCode='4'; $resMsg='Error in adding!';}
					
					
						}else{// If Requesting Advance
					
							$levelx=expenseApprovalLevels($_REQUEST['emp_alias']);
							switch ($levelx){
								case '1': $level=2;break;
								case '2': $level=2;break;
								case '3': $level=5;break;
								case '4': $level=5;break;
								case '5': $level=4;break;
								default : $level=1;break;
							}
							$sql=mysqli_query($mr_con,"INSERT INTO ec_advances(employee_alias,request_amount,total_amount,request_id,requested_date,advance_alias,approval_level,report) VALUES ('$_REQUEST[emp_alias]','$current_request','$current_request','$requestid','$date_of_request','$alias','$level','$profileimg')");
							if($sql){
							$rem=mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remarked_on,remark_alias) VALUES ('$remarks','BA','$alias','$_REQUEST[emp_alias]','".date('Y-m-d')."','$remalias')");
							$emcheck=alias($rquestid,'ec_advances','request_id','employee_alias');
							if($emcheck=="NA" || $emcheck==""){
							$resCode='0';$resMsg="Your Request ID ".$requestid." has been Submitted, But Will not Reflect in you details, So contact Admin";
							}else{					
							$res="Advance Request successfully";
							}
							$action = "Advance request id: ".$requestid." submitted";
							user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
							$url=localURL()."enersys_expense/maillings/book_advance.php?ref=".$alias;
							//file_get_contents($url);
							curlxing($url);
							$resCode='0'; $resMsg='Successfull!';} else { $resCode='4'; $resMsg='Error in adding!';}
						}
					}
			}if(isset($res)){$resCode='4';$resMsg=$res;}			
			}
			}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
			else{$resCode='2';$resMsg='Account Locked!';}
			$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
			echo json_encode($result);
}
function adv_addview(){ global $mr_con;
 	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
					$result['employee_alias']=$_REQUEST['emp_alias'];
					$result['employee_Id']=employeeDetails('employee_id',$_REQUEST['emp_alias']);
					$result['employee_Name']=employeeDetails('name',$_REQUEST['emp_alias']); 
					$result['employee_dept']=checkspldep($_REQUEST['emp_alias']);
					if(advanceNotSettled($_REQUEST['emp_alias'])!=0){$prev=advanceNotSettled($_REQUEST['emp_alias']);$prev_1=advanceNotSettled($_REQUEST['emp_alias']);} else { $prev="No pending Advances"; $prev_1=0;}
					$result['prev_amount']=$prev;
					$result['prev_amount1']=$prev_1;
					$result['grade']=grade($_REQUEST['emp_alias']);
					$result['credit_limit']=advancelimit($_REQUEST['emp_alias']);
					$result['advancesaddDetails']=array();
				$listDgn=listPendingAdvances($_REQUEST['emp_alias']);
                        if($listDgn!=0){
							$i=0;foreach($listDgn as $rec){
							if($rec['approved_by'] != ''){
								 $exp = explode('|',$rec['approved_by']);
								 $endexp = end($exp);
								 $sw=employeeDetails('name',$endexp);
							}else{$sw='Admin';}
							$result['advancesaddDetails'][$i]['request_id']=$rec['request_id'];
							$result['advancesaddDetails'][$i]['total_amount']=$rec['total_amount'];
							$result['advancesaddDetails'][$i]['requested_date']=$rec['requested_date'];
							$result['advancesaddDetails'][$i]['approved_by']=$sw;
							$i++;}
						}
						else{$resCode='4'; $resMsg='No Records Found';}
					$resCode='0'; $resMsg='Successfull!';
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function advances_update(){ 
	global $mr_con;
	if(isset($_REQUEST['password'])) {
		$chk = 0;
	} else {
		$chk = authentication($_REQUEST['emp_alias'], $_REQUEST['token']);
	}
	ob_start();
	if($chk==0){
		$alias=mysqli_real_escape_string($mr_con,$_REQUEST['advance_alias']);
		if($_REQUEST['refer']=='0'){
				$reqAmt=mysqli_real_escape_string($mr_con,$_REQUEST['request_amount']);
				$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['remarks']);
				$tot_amount=mysqli_real_escape_string($mr_con,$_REQUEST['tot_amount']);
				$reqdate=date("Y-m-d");
				if($_REQUEST['ref']=='draft'){
					if(empty($reqAmt)){$res="Please Enter Current Request";}
					elseif(empty($reasonForAdv)){$res="Please Enter Remarks";}
					else{
						$level='0';
						if($_FILES['tplanningreport']['size']>0){
							$ext = pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION);
							if($ext=='pdf' || $ext=='PDF'){	
							if($_FILES['tplanningreport']['size']>1153433){$res="File Size Should be less than or equal to 1MB";}else{
								$fileName=$empalias.generateRandomString()."ADV.".$ext;
							$upfile=move_uploaded_file($_FILES["tplanningreport"]["tmp_name"],"../../attachments/tourReport/".$fileName);
							if($upfile){ $profileimg = "attachments/tourReport/".$fileName;
							if($_REQUEST['tplanningreport_old']!=='0' && $_REQUEST['tplanningreport_old']!=='') unlink("../../".$_REQUEST['tplanningreport_old']);
							}else{$res="Upload Tour Planning Report";}
								}
							}else{$res="Upload PDF files Only";}
						}else{$profileimg=$_REQUEST['tplanningreport_old'];}
						$sql=mysqli_query($mr_con,"UPDATE ec_advances SET last_updated = now() , request_amount='$reqAmt',total_amount='$reqAmt',requested_date='$reqdate',approval_level='$level',report='$profileimg' WHERE advance_alias='$alias'");
						$q=mysqli_query($mr_con,"UPDATE ec_remarks SET remarks='$reasonForAdv',remarked_on='".date("Y-m-d H:i:s")."' WHERE item_alias='$alias'");
						if($sql){
							$action = "Advance request id: ".areq($alias)." updated";
							user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
							$resCode = '0';$resMsg='Advance Request successfully!';}else{$resCode = '4';$resMsg='Advance Request Failed!';}								
					}if($res){$resCode=4;$resMsg=$res;}
				}
				else{
				if(empty($reqAmt)){$res="Please Enter Current Request";}
				elseif(empty($reasonForAdv)){$res="Please Enter Remarks";}
				else{
					$levelx=expenseApprovalLevels($_REQUEST['emp_alias']);
					switch ($levelx){
					case '1': $level=2;break;
					case '2': $level=2;break;
					case '3': $level=5;break;
					case '4': $level=5;break;
					case '5': $level=4;break;
					default : $level=1;break;
					}
					if($_FILES['tplanningreport']['size']>0){
						$ext = pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION);
						if($ext=='pdf' || $ext=='PDF'){	
						if($_FILES['tplanningreport']['size']>1153433){$res="File Size Should be less than or equal to 1MB";}else{$fileName=$empalias.generateRandomString()."ADV.".$ext;
						$upfile=move_uploaded_file($_FILES["tplanningreport"]["tmp_name"],"../../attachments/tourReport/".$fileName);
						if($upfile){ $profileimg = "attachments/tourReport/".$fileName;
						if($_REQUEST['tplanningreport_old']!=='0' && $_REQUEST['tplanningreport_old']!=='') unlink("../../".$_REQUEST['tplanningreport_old']);
						}else{$res="Upload Tour Planning Report";}}				
						}else{$profileimg="";}
					}else{$profileimg=$_REQUEST['tplanningreport_old'];}
					
					$sql=mysqli_query($mr_con,"UPDATE ec_advances SET last_updated = now() , request_amount='$reqAmt',total_amount='$reqAmt',requested_date='$reqdate',approval_level='$level',report='$profileimg' WHERE advance_alias='$alias'");
					$q=mysqli_query($mr_con,"UPDATE ec_remarks SET remarks='$reasonForAdv',remarked_on='".date("Y-m-d H:i:s")."' WHERE item_alias='$alias'");
					if($sql) {
						$action = "Advance request id: ".areq($alias)." submitted";
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
						$url=localURL()."enersys_expense/maillings/book_advance.php?ref=".$alias;
						//file_get_contents($url);
						curlxing($url);
						$resCode = '0';$resMsg='Advance Request successfully!';}else{$resCode = '4';$resMsg='Advance Request Failed!';}
									
					}if($res){$resCode=4;$resMsg=$res;}
			}
		}
	
	//Approver Level must be 1 and Reject
	
		if($_REQUEST['refer']=='1'){
				$empalias=mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
				$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
				$tot_amount=mysqli_real_escape_string($mr_con,$_REQUEST['tot_amount']);
				$reqdate=date("Y-m-d");
				if(empty($reasonForAdv)){$res="Please Enter The Remarks";}
				else{
				if($_REQUEST['ref']=='reject'){
					$limit =8;
					$sql=mysqli_query($mr_con,"UPDATE ec_advances SET last_updated = now() , approval_level='$limit',approved_by='$empalias' WHERE advance_alias='$alias'");
					if($sql) {
						$action = "Advance request id: ".areq($alias)." rejected";
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
						$resCode = '0'; $resMsg="Rejected successfully";} else {$resCode = '4';$resMsg="Approval Failed";}
					$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
					if($reasonForAdv!='') 
					$q=mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BA','$alias','$empalias','$alias_remark')");
					$url=localURL()."enersys_expense/maillings/book_advance.php?ref=".$alias;
					curlxing($url);
				}else{
					$advet=advancefullView($alias);
					$advanceNotSettled=advanceNotSettled($advet[0]['employee_alias']);				
					$advanceLimit=advancelimit($advet[0]['employee_alias']);
					if(($advet[0]['request_amount']+$advanceNotSettled)>$advanceLimit)$limit=2;
					else $limit =4;
					$sql=mysqli_query($mr_con,"UPDATE ec_advances SET last_updated = now() , approval_level='$limit',approved_by='$empalias',approved_date='$reqdate' WHERE advance_alias='$alias'");
					$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
					if($reasonForAdv!='') 
					$q=mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BA','$alias','$empalias','$alias_remark')");
					if($sql){ 
						$action = "Advance request id: ".areq($alias)." approved";
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
						$url=localURL()."enersys_expense/maillings/book_advance.php?ref=".$alias;
						//file_get_contents($url);
						curlxing($url);
					$resCode = '0';$resMsg="Approved successfully";} else {$resCode = '4';$resMsg="Approval Failed";}
					}
				}if($res){$resCode=4;$resMsg=$res;}
		
		}
		if($_REQUEST['refer']=='2'){
				$empalias=mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
				$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
				$reqdate=date("Y-m-d");
				if(empty($reasonForAdv)){$res="Please Enter The Remarks";}
				else{
				if($_REQUEST['ref']=='reject'){
					$limit =8;
					$sql=mysqli_query($mr_con,"UPDATE ec_advances SET last_updated = now() , approval_level='$limit',approved_by='$empalias' WHERE advance_alias='$alias'");
					if($sql) {
						$action = "Advance request id: ".areq($alias)." rejected";
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
						$resCode = '0'; $resMsg="Rejected successfully";} else {$resCode = '4';$resMsg="Approval Failed";}
					$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
					if($reasonForAdv!='') 
					$q=mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES('$reasonForAdv','BA','$alias','$empalias','$alias_remark')");
					$url=localURL()."enersys_expense/maillings/book_advance.php?ref=".$alias;
					curlxing($url);
		
				}else{
					$advet=advancefullView($alias);
					$advanceNotSettled=advanceNotSettled($advet[0]['employee_alias']);				
					$advanceLimit=advancelimit($advet[0]['employee_alias']);
					$emplevel=expenseApprovalLevels($advet[0]['employee_alias']);
					if($emplevel==0)$limit=4;
					else if($advanceNotSettled>$advanceLimit && $emplevel!=0)$limit=5;
					else if($advet[0]['request_amount']>$advanceLimit && $emplevel!=0)$limit=5;
					else $limit =4;
					$approved_by=advancedetlimited('approved_by',$alias)."|".$empalias;
					$approved_date=advancedetlimited('approved_date',$alias)."|".$reqdate;
					$sql=mysqli_query($mr_con,"UPDATE ec_advances SET last_updated = now() , approval_level='$limit',approved_by='$approved_by',approved_date='$approved_date' WHERE advance_alias='$alias'");
					$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
					if($reasonForAdv!='') mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BA','$alias','$empalias','$alias_remark')");
					if($sql){ 
						$action = "Advance request id: ".areq($alias)." approved";
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
						$url=localURL()."enersys_expense/maillings/book_advance.php?ref=".$alias;
						//file_get_contents($url);
						curlxing($url);
					$resCode = '0';$resMsg="Approved successfully";} else{$resCode = '4';$resMsg="Approval Failed";}
					}
				}if($res){$resCode=4;$resMsg=$res;}
		}
		if($_REQUEST['refer']=='4'){
				$empalias=mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
				$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
				$reqdate=date("Y-m-d");
				if(empty($reasonForAdv)){$res="Please Enter the Remarks";}
				else{
				if($_REQUEST['ref']=='reject'){
					$limit =8;
					$sql=mysqli_query($mr_con,"UPDATE ec_advances SET last_updated = now() , approval_level='$limit',approved_by='$empalias' WHERE advance_alias='$alias'");
					if($sql) {
						$action = "Advance request id: ".areq($alias)." rejected";
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
						$resCode = '0'; $resMsg="Rejected successfully";} else {$resCode = '4';$resMsg="Approval Failed";}
					$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
					if($reasonForAdv!='') 
					$q=mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES('$reasonForAdv','BA','$alias','$empalias','$alias_remark')");
					$url=localURL()."enersys_expense/maillings/book_advance.php?ref=".$alias;
					curlxing($url);
				}else{
					$limit =6;
					$approved_by=advancedetlimited('approved_by',$alias)."|".$empalias;
					$approved_date=advancedetlimited('approved_date',$alias)."|".$reqdate;
					$sql=mysqli_query($mr_con,"UPDATE ec_advances SET last_updated = now() , approval_level='$limit',approved_by='$approved_by',approved_date='$approved_date' WHERE advance_alias='$alias'");
					$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
					if($reasonForAdv!='')$q=mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BA','$alias','$empalias','$alias_remark')");
					if($sql){ 
						$action = "Advance request id: ".areq($alias)." approved";
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
						$url=localURL()."enersys_expense/maillings/book_advance.php?ref=".$alias;
						//file_get_contents($url);
						curlxing($url);
					$resCode = '0';$resMsg="Approved successfully";} else{$resCode = '4';$resMsg="Approval Failed";}
					}
				}
		}
		if($_REQUEST['refer']=='5'){
				$empalias=mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
				$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
				$reqdate=date("Y-m-d");
				if(empty($reasonForAdv)){$res="Please Enter The Remarks";}
				else{
				if($_REQUEST['ref']=='reject'){
						$action = "Advance request id: ".areq($alias)." rejected";
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$limit =8;
					$sql=mysqli_query($mr_con,"UPDATE ec_advances SET last_updated = now() , approval_level='$limit',approved_by='$empalias' WHERE advance_alias='$alias'");
					if($sql) {$resCode = '0'; $resMsg="Rejected successfully";} else {$resCode = '4';$resMsg="Approval Failed";}
					$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
					if($reasonForAdv!='') 
					$q=mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES('$reasonForAdv','BA','$alias','$empalias','$alias_remark')");
					$url=localURL()."enersys_expense/maillings/book_advance.php?ref=".$alias;
					curlxing($url);
				}else{
					$limit =4;
					$approved_by=advancedetlimited('approved_by',$alias)."|".$empalias;
					$approved_date=advancedetlimited('approved_date',$alias)."|".$reqdate;
					$sql=mysqli_query($mr_con,"UPDATE ec_advances SET last_updated = now() , approval_level='$limit',approved_by='$approved_by',approved_date='$approved_date' WHERE advance_alias='$alias'");
					$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
					if($reasonForAdv!='')$q=mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BA','$alias','$empalias','$alias_remark')");
					if($sql) {
						$action = "Advance request id: ".areq($alias)." approved";
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
						$url=localURL()."enersys_expense/maillings/book_advance.php?ref=".$alias;
						//file_get_contents($url);
						curlxing($url);
						$resCode = '0';$resMsg="Approved successfully";} else{$resCode = '4';$resMsg="Approval Failed";}
					}
				}if($res){$resCode=4;$resMsg=$res;}
		}
		if($_REQUEST['refer']=='6'){
			$empalias=$_REQUEST['emp_alias'];
			$reasonForAdv=mysqli_real_escape_string($mr_con,trim($_REQUEST['reasonForAdv']));
			$utr_num=mysqli_real_escape_string($mr_con,trim($_REQUEST['utr_num']));
			if($reasonForAdv==""){$res="Enter Remarks";}else if($utr_num==""){$res="Enter UTR Number";}else{
					$sql=mysqli_query($mr_con,"UPDATE ec_advances SET last_updated = now() , utr_num='$utr_num' WHERE advance_alias='$alias'");
					if($sql) {
						$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
						if($reasonForAdv!='')$q=mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BA','$alias','$empalias','$alias_remark')");
						$action = "UTR number added for advance request id: ".areq($alias)."";
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
						$resCode = '0';$resMsg="Updated successfully";
					} else{$resCode = '4';$resMsg="Update Failed";}
			}if($res){$resCode=4;$resMsg=$res;}
		}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
		ob_end_clean();
		echo json_encode($result);
}
function advances_adv_update() { 
	global $mr_con;
	$chk = authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0) {
		$alias = mysqli_real_escape_string($mr_con,$_REQUEST['advance_alias']);
		$empalias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
		$reasonForAdv = mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
		$reqAmt = mysqli_real_escape_string($mr_con,$_REQUEST['request_amount']);
		$utr_num = mysqli_real_escape_string($mr_con,trim($_REQUEST['utr_num']));
		$utr_num = $utr_num ? $utr_num : 0;
		$requested_date = mysqli_real_escape_string($mr_con,trim($_REQUEST['requested_date']));
		$remarks = $_REQUEST['remarks'];
		if(empty($reqAmt)){ $res="Please Enter Current Request"; }
		elseif(empty($reasonForAdv)){ $res="Please Enter Remarks"; }
		else {
			$updateQuery = "UPDATE ec_advances SET last_updated = now() , request_amount='$reqAmt',total_amount='$reqAmt', utr_num='$utr_num', requested_date = '$requested_date' WHERE advance_alias='$alias'";
			$sql = mysqli_query($mr_con, $updateQuery);
			foreach($remarks as $remark) {
				$remarkUpdateSql = "UPDATE ec_remarks SET remarks = '". $remark['remark'] ."' WHERE remark_alias = '". $remark['alias'] ."'";
				$usql = mysqli_query($mr_con, $remarkUpdateSql);
			}
			if($sql) {
				$action = "Advance request id: ".areq($alias)." updated";
				user_history($_REQUEST['emp_alias'], $action, $_REQUEST['ip_addr'], $reasonForAdv);
				$resCode = '0';$resMsg="Advances Updated successfully";
			} else {
				$resCode = '4';$resMsg="Advances Update Failed";
			}
		}
		if(isset($res)) {
			$resCode = '4';
			$resMsg = $res;
		}			
	} else if($chk==1) {
		$resCode='1';
		$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode;
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function advances_view(){ 
	global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$viewemp_advalias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
		$resultz=advancefullView($viewemp_advalias);
		$result['request_id']=$resultz[0]['request_id'];	
		$result['requested_date']=$resultz[0]['requested_date'];	
		$result['employee_Id']=employeeDetails('employee_id',$resultz[0]['employee_alias']);
		$result['employee_Name']=employeeDetails('name',$resultz[0]['employee_alias']);
		$result['employee_dep']=alias(employeeDetails('department_alias',$resultz[0]['employee_alias']),'ec_department','department_alias','department_name');
		$result['employee_des']=alias(employeeDetails('designation_alias',$resultz[0]['employee_alias']),'ec_designation','designation_alias','designation');	
		$result['grade']=alias(employeeDetails('designation_alias',$resultz[0]['employee_alias']),'ec_designation','designation_alias','grade');
		$outstanding = advanceNotSettled($resultz[0]['employee_alias']);
		if ($outstanding!=0)$prev_amount = $outstanding; else $prev_amount="No pending Advances";
		$result['prev_amount']=$prev_amount;
		$result['request_amount']=$resultz[0]['request_amount'];
		
		$result['tot_out_adv']=advanceNotSettled($resultz[0]['employee_alias'])+$resultz[0]['request_amount'];
		
	 	$result['avail_amount']=$resultz[0]['total_amount'];
        
		$result['credit_limit']=advancelimit($resultz[0]['employee_alias']);;
		$result['utr_num']=$resultz[0]['utr_num'];
		
		if(checkspldep($resultz[0]['employee_alias'])=='3'){
			$show_report = FALSE;
		} else {
			$show_report = TRUE;
		}
		$result['show_report']=$show_report;
		
		if($resultz[0]['report']!=='0' && $resultz[0]['report']!==''){
			$con_link=urllink($resultz[0]['requested_date']).$resultz[0]['report'];}else{$con_link='';}		
		$result['report']=$con_link;//echo $con_link;
		$result['hidden_report']=$resultz[0]['report'];
		$result['advance_alias']=$viewemp_advalias;
		$result['employee_dept']=checkspldep($resultz[0]['employee_alias']);
		$result['approval_level']=$resultz[0]['approval_level1'];
		if(($_REQUEST['emp_alias']==$resultz[0]['employee_alias']) && ($resultz[0]['approval_level1']==0)){
			$hover_edit = "Request";
			$edit = "1";
		}
		if(chouldshow($_REQUEST['emp_alias'],$resultz[0]['approval_level1'])==1){ 
			$hover_edit = "Approvals";
			$edit = "1";
		}
		
		//echo financeemp($_REQUEST['emp_alias'])."--".$resultz[0]['approval_level1']."--".$resultz[0]['utr_num'];exit;
		if(financeemp($_REQUEST['emp_alias'])=='2' && $resultz[0]['approval_level1']=='6' && $resultz[0]['utr_num']=='0'){
			$hover_edit = "Approvals";
			$edit = "1";
			$submit_button = "1";
		}else{
			$submit_button = "0";
		}
		if($edit =='')$edit = "0";
		$result['edit'] = $edit;
		$result['hover_edit'] = $hover_edit;
		$result['submit_button'] = $submit_button;
			$remarks_sql=mysqli_query($mr_con,"SELECT remarks, remarked_by, remarked_on, remark_alias FROM ec_remarks WHERE item_alias='$viewemp_advalias' AND module='BA' AND flag=0");
			$remarks_count = mysqli_num_rows($remarks_sql);
			$result['remarks']=array();
			$result['remarks_count']=$remarks_count;		
			if(mysqli_num_rows($remarks_sql)){
				$i=0;
				while($remarks_row = mysqli_fetch_array($remarks_sql)){
					$result['remarks'][$i]['remarks_desc']=$remarks_row['remarks'];	
					$result['remarks'][$i]['remarked_by']=employeeDetails('name',$remarks_row['remarked_by']);
					$result['remarks'][$i]['remarked_on']=date("d-M-Y", strtotime($remarks_row['remarked_on']));
					$result['remarks'][$i]['remarks_alias']=$remarks_row['remark_alias'];
					$i++;
				}
			}
			
			$query=mysqli_query($mr_con,"SELECT * FROM ec_advances WHERE employee_alias='".$resultz[0]['employee_alias']."' AND approval_level='6' AND total_amount!='0' AND flag=0");
				$result['advanceseditDetails']=array();
				if(mysqli_num_rows($query)>0){
					$i=0;while($row1=mysqli_fetch_array($query)){
						if($row1['approved_by'] != ''){
							 $exp = explode('|',$row1['approved_by']);
							 $endexp = end($exp);
							 $sw=employeeDetails('name',$endexp);
						}else{$sw='Admin';}
						$result['advanceseditDetails'][$i]['request_id']=$row1['request_id'];
						$result['advanceseditDetails'][$i]['total_amount']=$row1['total_amount'];
						$result['advanceseditDetails'][$i]['requested_date']=$row1['requested_date'];
						$result['advanceseditDetails'][$i]['approved_by']=$sw;
						$i++;}
					}else{$resCode='4'; $resMsg='No Records Found';}
			
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function adv_export_view(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	$result['exportDetails']=array();
		if($chk==0){
			$get_appr = mysqli_query($mr_con,"SELECT * from ec_expense_approvals where approver = '$emp_alias'");
			$get_cnt = mysqli_num_rows($get_appr);
			if($get_cnt > 0){
				$get_lev = mysqli_query($mr_con,"SELECT GROUP_CONCAT(DISTINCT approval_level) AS approval_level FROM ec_expense_approvals where approver = '$emp_alias'");
				$get_lev_rs = mysqli_fetch_array($get_lev);
				$appr_list = explode(',',$get_lev_rs['approval_level']);
				$all_levels =  array('3','4','5');
				$arr_inter = array_intersect($appr_list,$all_levels);
				$arr_inter_cnt = count($arr_inter);
				///$result['aplevel']=$get_lev_rs['approval_level'];
				if($arr_inter_cnt == 0){ //if approvel level must be 1 or 2
					$get_dep = mysqli_query($mr_con,"SELECT GROUP_CONCAT(DISTINCT approval_dep) AS approval_dep FROM ec_expense_approvals where approver = '$emp_alias'");
					$get_dept_rs = mysqli_fetch_array($get_dep);
					$appr_dept = $get_dept_rs['approval_dep'];//dept based aliases
				}
				
				if($get_cnt > 0){ 
					if($arr_inter_cnt > 0){
					$empDgn=empdrop();
					if($empDgn!=0){ //All employee list
						foreach($empDgn as $i => $rec){ $result['exportDetails'][$i]['alias']=$rec['alias'];$result['exportDetails'][$i]['name']=$rec['name'];}
					}else {$res="No Records Found";} 
					}else{
					$empDeptDgn=empDeptdrop($appr_dept);
					if($empDeptDgn!=0){ // Dept vice Employee list
						foreach($empDeptDgn as $j => $rec){$result['exportDetails'][$j]['alias']=$rec['alias'];$result['exportDetails'][$j]['name']=$rec['name'];}
					}else {$res="No Records Found";}
					}
				}
			}	
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function advances_mul_view(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){ 
		$condition=$condition1="";
		$chapp=checkApproval($emp_alias);
		$emp_spl_dep=checkspldep($emp_alias);
		if($_REQUEST['reqId']!=""){$condition.=$a="request_id LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['reqId'])."%' AND ";$condition1.="t1".$a;}
		if($_REQUEST['reqBy']!="") {$condition.=$a="employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE name LIKE '%".$_REQUEST['reqBy']."%') AND ";$condition1.="t1".$a;}
		if($_REQUEST['reqDate']!=""){$condition.=$a="requested_date ='".mysqli_real_escape_string($mr_con,dateFormat(trim($_REQUEST['reqDate']),'y'))."' AND ";$condition1.="t1".$a;}
		if($_REQUEST['reqAmt']!=""){$condition.=$a="request_amount LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['reqAmt'])."%' AND ";$condition1.="t1".$a;}
		if($_REQUEST['appstatus']!=""){$condition.=$a="approval_level ='".mysqli_real_escape_string($mr_con,$_REQUEST['appstatus'])."' AND ";$condition1.="t1".$a;}
		$result['eadmin']=$emp_alias;
		$viewAll = grantable('VIEW ALL', 'EXPENSE TRACKER', $emp_alias);
		if($viewAll || strtoupper($emp_alias) == 'ADMIN' || strtoupper($emp_alias) == 'EADMIN'){
			$display_name = 'yes';
			$result['display_name']=$display_name;
			$query = "SELECT count(id) FROM ec_advances WHERE approval_level<>'0' AND $condition flag=0";
			$rec = mysqli_query($mr_con, $query);
			while($row_count=mysqli_fetch_array($rec)){$r=$row_count[0];}
		}else{
		
		if($chapp==1 || $emp_spl_dep==1 || $emp_spl_dep==2) {$display_name = 'yes';}else{$display_name = 'no';}
		$result['display_name']=$display_name;
			
		if($chapp<='0' && ($emp_spl_dep=="1" || $emp_spl_dep=="2")){ 
			//dep 1 for SCM,SCM PLANT & 2 for FINANACE,FINANCE-CORPORATE  
			$rec=mysqli_query($mr_con,"(SELECT count(id) FROM ec_advances WHERE $condition flag=0 AND approval_level<>'0' AND employee_alias<>'$emp_alias') UNION ALL (SELECT count(id) FROM ec_advances WHERE $condition employee_alias='$emp_alias' AND flag=0)");
			while($row_count=mysqli_fetch_array($rec)){$r+=$row_count[0];}
		}else if($chapp>0){
		if (in_array('5', approvelvl($emp_alias))) {
			$rec=mysqli_query($mr_con,"(SELECT count(id) FROM ec_advances WHERE $condition employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE department_alias IN (SELECT approval_dep FROM ec_expense_approvals WHERE approver='$emp_alias' AND flag=0) AND (flag=0 or flag=1)) AND flag=0 AND approval_level IN('2','5') AND employee_alias<>'$emp_alias') UNION ALL (SELECT count(id) FROM ec_advances WHERE $condition employee_alias='$emp_alias' AND flag=0)");
			
			while($row_count=mysqli_fetch_array($rec)){$r+=$row_count[0];}
		}else{
			$rec=mysqli_query($mr_con,"(SELECT count(id) FROM ec_advances WHERE $condition employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE department_alias IN (SELECT approval_dep FROM ec_expense_approvals WHERE approver='$emp_alias' AND flag=0) AND (flag=0 or flag=1)) AND flag=0 AND (approval_level<>'0' && approval_level<'6') AND employee_alias<>'$emp_alias') UNION ALL (SELECT count(id) FROM ec_advances WHERE $condition employee_alias='$emp_alias' AND flag=0)");
			while($row_count=mysqli_fetch_array($rec)){$r+=$row_count[0];}	
		}
		}else{
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_advances WHERE $condition employee_alias='$emp_alias' AND flag=0");
			$row_count=mysqli_fetch_array($rec);$r=$row_count[0];
		}
		}
		//print_r(approvelvl($emp_alias));
		if($rec){
		if(mysqli_num_rows($rec)>0){
			$totalRecords=$r;
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			if($viewAll || strtoupper($emp_alias) == 'ADMIN' || strtoupper($emp_alias) == 'EADMIN'){
				$rec=mysqli_query($mr_con,"SELECT request_id,employee_alias,request_amount,total_amount,requested_date,approved_by,approval_level,advance_alias FROM ec_advances WHERE approval_level<>'0' AND $condition  flag=0 ORDER BY requested_date DESC LIMIT $offset, $limit");
			}else{
				if($chapp<='0' && ($emp_spl_dep=="1" || $emp_spl_dep=="2")){
					$rec=mysqli_query($mr_con,"(SELECT request_id,employee_alias,request_amount,total_amount,requested_date,approved_by,approval_level,advance_alias FROM ec_advances WHERE $condition flag=0 AND approval_level<>'0' AND employee_alias<>'$emp_alias') UNION ALL (SELECT request_id,employee_alias,request_amount,total_amount,requested_date,approved_by,approval_level,advance_alias FROM ec_advances WHERE $condition employee_alias='$emp_alias' AND flag=0) ORDER BY requested_date DESC LIMIT $offset, $limit");
					
				}else if($chapp>0){
				if(in_array('5', approvelvl($emp_alias))) {
					$rec=mysqli_query($mr_con,"(SELECT request_id,employee_alias,request_amount,total_amount,requested_date,approved_by,approval_level,advance_alias FROM ec_advances WHERE $condition employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE department_alias IN (SELECT approval_dep FROM ec_expense_approvals WHERE approver='$emp_alias' AND flag=0) AND (flag=0 or flag=1)) AND flag=0 AND approval_level IN('2','5') AND employee_alias<>'$emp_alias') UNION ALL (SELECT request_id,employee_alias,request_amount,total_amount,requested_date,approved_by,approval_level,advance_alias FROM ec_advances WHERE $condition employee_alias='$emp_alias' AND flag=0) ORDER BY requested_date DESC LIMIT $offset, $limit");
				}else{
					$rec=mysqli_query($mr_con,"(SELECT request_id,employee_alias,request_amount,total_amount,requested_date,approved_by,approval_level,advance_alias FROM ec_advances WHERE $condition employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE department_alias IN (SELECT approval_dep FROM ec_expense_approvals WHERE approver='$emp_alias' AND flag=0) AND (flag=0 or flag=1)) AND flag=0 AND (approval_level<>'0' && approval_level<'6') AND employee_alias<>'$emp_alias') UNION ALL (SELECT request_id,employee_alias,request_amount,total_amount,requested_date,approved_by,approval_level,advance_alias FROM ec_advances WHERE $condition employee_alias='$emp_alias' AND flag=0) ORDER BY requested_date DESC LIMIT $offset, $limit");
					}
				}else{
					$rec=mysqli_query($mr_con,"SELECT request_id,employee_alias,request_amount,total_amount,requested_date,approved_by,approval_level,advance_alias FROM ec_advances WHERE $condition employee_alias='$emp_alias' AND flag=0 ORDER BY requested_date DESC LIMIT $offset, $limit");
				}
			}//not eadmiin
			//exit;
			$result['advancesDetails']=array();
			if(strtoupper($emp_alias) == 'ADMIN' || strtoupper($emp_alias) == 'EADMIN'){
				$result['add']=FALSE;
				$result['splEdit']=True;
				$result['delete']=True;
				$result['mapping']=True;
			}else{
				$result['add']=grantable('ADD','EXPENSE TRACKER',$emp_alias);
				$result['splEdit']=grantable('SPECIAL','EXPENSE TRACKER',$emp_alias);
				$result['delete']=grantable('DELETE','EXPENSE TRACKER',$emp_alias);
				$result['mapping']=grantable('MAPPING','EXPENSE TRACKER',$emp_alias);
			}
			if(mysqli_num_rows($rec)){
				$i=0;while($row = mysqli_fetch_array($rec)){ $xyz='';
					$result['advancesDetails'][$i]['request_id']=$row['request_id'];
					$request_by = alias_flag_none($row['employee_alias'],'ec_employee_master','employee_alias','name');
					$result['advancesDetails'][$i]['request_by']= $request_by;
					$result['advancesDetails'][$i]['request_by_half'] = ((strlen($request_by) > 15) ? substr($request_by,0,15)."..." : $request_by);
					$result['advancesDetails'][$i]['requested_date']=dateFormat($row['requested_date'],'d');
					$result['advancesDetails'][$i]['request_amount']=sprintf('%0.2f',$row['request_amount']);
					$result['advancesDetails'][$i]['approval_level_name']=exlevelsName($row['approval_level']);
					$result['advancesDetails'][$i]['approval_level']=$row['approval_level'];
					$result['advancesDetails'][$i]['advance_alias']=$row['advance_alias'];
					$result['advancesDetails'][$i]['employee_alias']=$row['employee_alias'];
					$i++;}
					//$result['emp_app_level']=expenseApprovalLevels($emp_alias);
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}
		}
	}elseif($rex==1){
		$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x;else $result['pages'][1]=1;
	echo json_encode($result);		
}
function advances_export(){ 
	global $mr_con;
	set_time_limit(0);
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$get_appr = mysqli_query($mr_con,"SELECT * from ec_expense_approvals where approver = '".$_REQUEST['emp_alias']."'");
		$get_cnt = mysqli_num_rows($get_appr);
		if($get_cnt > 0){
			$get_lev = mysqli_query($mr_con,"SELECT GROUP_CONCAT(DISTINCT approval_level) AS approval_level FROM ec_expense_approvals where approver = '".$_REQUEST['emp_alias']."'");
			$get_lev_rs = mysqli_fetch_array($get_lev);
			$appr_list = explode(',',$get_lev_rs['approval_level']);
			$all_levels =  array('3','4','5');
			$arr_inter = array_intersect($appr_list,$all_levels);
			$arr_inter_cnt = count($arr_inter);
			if($arr_inter_cnt == 0){ 
				$get_dep = mysqli_query($mr_con,"SELECT GROUP_CONCAT(DISTINCT approval_dep) AS approval_dep FROM ec_expense_approvals where approver = '".$_REQUEST['emp_alias']."'");
				$get_dept_rs = mysqli_fetch_array($get_dep);
				$appr_dept = $get_dept_rs['approval_dep'];
			}
		} 
		if(isset($_REQUEST['start_date']) && !empty($_REQUEST['start_date'])){$from = date("Y-m-d", strtotime($_REQUEST['start_date']));}else{$from = '';}
		if(isset($_REQUEST['end_date']) && !empty($_REQUEST['end_date'])){$to = date("Y-m-d", strtotime($_REQUEST['end_date']));}else{$to = '';}
		$val = mysqli_real_escape_string($mr_con,$_REQUEST['amount']);
		$level = mysqli_real_escape_string($mr_con,$_REQUEST['aplevel']);
		$appr_cnt = $get_cnt;
		if($appr_cnt == "0"){
			$emp_alias = $_REQUEST['emp_alias'];
		}else{
			$emp_alias = $_REQUEST['apl'];	
		}
		if(!empty($from) && !empty($to)){$con = "(requested_date BETWEEN '$from' AND '$to') AND";}
		elseif(!empty($from) && empty($to)){$con .= "requested_date >= '$from' AND";}
		elseif(empty($from) && !empty($to)){$con .= "requested_date <= '$to' AND";}
		if(!empty($val)){$con .= " request_amount='$val' AND";}
		if($level!=''){$con .= " approval_level='$level' AND";}
		if(strtoupper($emp_alias) == 'ADMIN' || strtoupper($emp_alias) == 'EADMIN'){
			$rec=$mr_con->query("SELECT employee_alias FROM ec_employee_master WHERE flag=0 ORDER BY name");
		if($rec->num_rows>'0'){
			while($row = $rec->fetch_assoc()){$result[]=$row['employee_alias'];}
		}
		$con .= " employee_alias IN ('".implode("','",$result)."') AND";
		
		}else{
		if($emp_alias !='' && $emp_alias !='0'){$con .= " employee_alias='$emp_alias' AND";}
		else{$result=array();
		if($arr_inter_cnt == '0'){
			$check_arr=implode("','",explode(',',$appr_dept));
			$rec=$mr_con->query("SELECT employee_alias FROM ec_employee_master WHERE flag=0 AND department_alias IN ('$check_arr') ORDER BY name");
			if($rec->num_rows>'0'){
				while($row = $rec->fetch_assoc()){$result[]=$row['employee_alias'];}
			}
			$con .= " employee_alias IN ('".implode("','",$result)."') AND";
		}else{
			$rec=$mr_con->query("SELECT employee_alias FROM ec_employee_master WHERE flag=0 ORDER BY name");
			if($rec->num_rows>'0'){
				while($row = $rec->fetch_assoc()){$result[]=$row['employee_alias'];}
			}
			$con .= " employee_alias IN ('".implode("','",$result)."') AND";
		}}
		}
		//echo "SELECT * FROM ec_advances WHERE $con flag=0";
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_advances WHERE $con flag=0");
		$colArr =array('Employee ID','Employee Name','Employee Designation','Employee Grade','Employee Department','Request Amount','Total Amount','Request ID','Requested Date','Approval Level','Approved By','Approved Date');
		$colArr2 = array('request_amount','total_amount','request_id');
		if(mysqli_num_rows($sql)){
			$filename = 'Advances-'.rand(0000,9999)."-".date("Y-m-d");
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
			$date_arr = array("I","L","O");
			foreach($date_arr as $da){$objPHPExcel->getActiveSheet()->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$objPHPExcel->getActiveSheet()->getColumnDimension($da)->setAutoSize(true);}
			$coo=1;
			while($row=mysqli_fetch_array($sql)){ $coo++;
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$coo, alias($row['employee_alias'],'ec_employee_master','employee_alias','employee_id'));
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$coo, alias($row['employee_alias'],'ec_employee_master','employee_alias','name'));
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$coo, alias(alias($row['employee_alias'],'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','designation'));
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$coo, alias(alias($row['employee_alias'],'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','grade'));
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$coo, alias(alias($row['employee_alias'],'ec_employee_master','employee_alias','department_alias'),'ec_department','department_alias','department_name'));
				for($af=0,$chr='F';$af<count($colArr2);$af++,$chr++){
					$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$coo, php_excel_date($row['requested_date']));
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$coo, exlevelsName($row['approval_level']));
				
				if($row['approved_by'] != ''){
					 $sw=expo($row['approved_by']);
				}else{ if($row['approval_level'] == '6') $sw='Admin'; else $sw='';}
				
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$coo, $sw);
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$coo, str_replace("|",", ",php_excel_date($row['approved_date'])));
	
				$remSql = mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE item_alias='".$row['advance_alias']."' AND module='BA' AND flag=0");
				$cc = 'M';
				$k=1;while($remRow = mysqli_fetch_array($remSql)){
					$cd = $cc;
					$objPHPExcel->getActiveSheet()->SetCellValue($cc.'1','Remarks'.$k);
					$objPHPExcel->getActiveSheet()->SetCellValue($cc.$coo, $remRow['remarks']);$cc++;
					
					$objPHPExcel->getActiveSheet()->SetCellValue($cc.'1','Remarked By'.$k);
					$objPHPExcel->getActiveSheet()->SetCellValue($cc.$coo, (strtoupper($remRow['remarked_by'])!='ADMIN' ? alias($remRow['remarked_by'],'ec_employee_master','employee_alias','name') : "ADMIN"));$cc++;
					
					$objPHPExcel->getActiveSheet()->SetCellValue($cc.'1','Remarked On'.$k);
					$objPHPExcel->getActiveSheet()->SetCellValue($cc.$coo,php_excel_date($remRow['remarked_on']));
					
					$objPHPExcel->getActiveSheet()->getStyle($cd.'1:'.$cc.'1')->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle($cd.'1:'.$cc.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
				$cc++;$k++;
				}
			}
			
	$objPHPExcel->getActiveSheet()->setTitle('Advances');
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
// End - User Advances
// Start - User Dashboard
function exp_dashboard(){
 	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	$chapp=checkApproval($emp_alias);
	if($chk==0){
		$condition="";
		$emp_id=mysqli_real_escape_string($mr_con,$_REQUEST['emp_id']);
		$emp_name=mysqli_real_escape_string($mr_con,$_REQUEST['emp_name']);
		$dep=mysqli_real_escape_string($mr_con,$_REQUEST['dep']);
		$toal_advances=mysqli_real_escape_string($mr_con,$_REQUEST['toal_advances']);
		$total_expenses=mysqli_real_escape_string($mr_con,$_REQUEST['total_expenses']);
		$avl_balance=mysqli_real_escape_string($mr_con,$_REQUEST['avl_balance']);
		$result['dashboard']=array();
		if($emp_id!="")$condition.=" employee_id LIKE '%".$emp_id."%' AND ";
		if($emp_name!="")$condition.=" name LIKE '%".$emp_name."%' AND ";
		if($dep!="")$condition.=" department_alias ='".$dep."' AND ";
		if(strtoupper($emp_alias) == 'ADMIN' || strtoupper($emp_alias) == 'EADMIN' ||$chapp>0){
			if(strtoupper($emp_alias) == 'ADMIN' || strtoupper($emp_alias) == 'EADMIN') {
				$query = "SELECT count(id) as counti FROM ec_employee_master WHERE $condition employee_alias='$emp_alias' AND flag=0 UNION SELECT count(e.id) FROM ec_employee_master e,ec_emprole r WHERE e.role_alias = r.role_alias AND r.role_stat <> 1 AND $condition e.department_alias IN (SELECT approval_dep FROM ec_expense_approvals d WHERE d.flag=0) AND e.flag =0";
			} else {
				$query = "SELECT count(id) as counti FROM ec_employee_master WHERE $condition employee_alias='$emp_alias' AND flag=0 UNION SELECT count(e.id) FROM ec_employee_master e,ec_emprole r WHERE e.role_alias = r.role_alias AND r.role_stat <> 1 AND $condition e.department_alias IN (SELECT approval_dep FROM ec_expense_approvals d WHERE d.approver='$emp_alias' AND d.flag=0) AND e.flag =0";
			}
			$rec = mysqli_query($mr_con, $query);
			$tot = 0;
			while($row=mysqli_fetch_array($rec)){
				$tot +=$row['0'];
			}
			$totalRecords=$tot;
		}else{
			$rec=mysqli_query($mr_con,"SELECT count(id) as counti FROM ec_employee_master WHERE $condition employee_alias='$emp_alias' AND flag=0");
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
		}
		if($totalRecords>0){
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			//$totalpages=ceil($totalRecords/$limit);
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			if(strtoupper($emp_alias) == 'ADMIN' || strtoupper($emp_alias) == 'EADMIN' || $chapp>0) {
				if(strtoupper($emp_alias) == 'ADMIN' || strtoupper($emp_alias) == 'EADMIN') {
					$query = "SELECT name, employee_id, employee_alias, department_alias FROM ec_employee_master WHERE $condition employee_alias='$emp_alias' AND flag=0 UNION SELECT name, employee_id, employee_alias, department_alias FROM ec_employee_master e,ec_emprole r WHERE e.role_alias = r.role_alias AND r.role_stat <> 1 AND $condition e.department_alias IN (SELECT approval_dep FROM ec_expense_approvals d WHERE d.flag=0) AND e.flag =0 LIMIT $offset, $limit";
				} else {
					$query = "SELECT name, employee_id, employee_alias, department_alias FROM ec_employee_master WHERE $condition employee_alias='$emp_alias' AND flag=0 UNION SELECT name, employee_id, employee_alias, department_alias FROM ec_employee_master e,ec_emprole r WHERE e.role_alias = r.role_alias AND r.role_stat <> 1 AND $condition e.department_alias IN (SELECT approval_dep FROM ec_expense_approvals d WHERE d.approver='$emp_alias' AND d.flag=0) AND e.flag =0 LIMIT $offset, $limit";
				}
				$sql=mysqli_query($mr_con, $query);
			}else{
				$sql=mysqli_query($mr_con,"SELECT name, employee_id, employee_alias, department_alias FROM ec_employee_master WHERE $condition employee_alias='$emp_alias' AND flag=0");
			}
			if(mysqli_num_rows($sql)){
				$i=0;
				if(strtoupper($emp_alias) == 'ADMIN' || strtoupper($emp_alias) == 'EADMIN' || $chapp>0){
					while($row = mysqli_fetch_array($sql)){
						$result['dashboard'][$i]['employee_alias']=$row['employee_alias'];
						$result['dashboard'][$i]['name']=$row['name'];
						$result['dashboard'][$i]['name_half'] = ((strlen($row['name']) > 15) ? substr($row['name'],0,15)."..." : $row['name']);
						$result['dashboard'][$i]['employee_id']=$row['employee_id'];
						$result['dashboard'][$i]['department']=alias($row['department_alias'],'ec_department','department_alias','department_name');
						$result['dashboard'][$i]['total_advances']=sprintf('%0.2f',toatlAdvances($row['employee_alias']));
						$result['dashboard'][$i]['total_expenses']=sprintf('%0.2f',totalExpenses($row['employee_alias']));
						$result['dashboard'][$i]['reimbursement_amount']=sprintf('%0.2f',totalReimbursement($row['employee_alias']));
						$result['dashboard'][$i]['refund_amount']=sprintf('%0.2f',totalRefund($row['employee_alias']));
						$result['dashboard'][$i]['available_balance']=sprintf('%0.2f',advanceNotSettled($row['employee_alias']));
						$i++;
					}
				}else{
						$row = mysqli_fetch_array($sql);
						$result['employee_alias']=$row['employee_alias'];
						$result['name']=$row['name'];						
						$result['employee_id']=$row['employee_id'];
						$result['department']=alias($row['department_alias'],'ec_department','department_alias','department_name');
						$result['total_advances']=sprintf('%0.2f',toatlAdvances($row['employee_alias']));
						$result['total_expenses']=sprintf('%0.2f',totalExpenses($row['employee_alias']));
						$result['reimbursement_amount']=sprintf('%0.2f',totalReimbursement($row['employee_alias']));
						$result['refund_amount']=sprintf('%0.2f',totalRefund($row['employee_alias']));
						$result['available_balance']=sprintf('%0.2f',advanceNotSettled($row['employee_alias']));
						$result['designation']=alias(employeeDetails('designation_alias',$row['employee_alias']),'ec_designation','designation_alias','designation');
						$result['grade']=alias(employeeDetails('designation_alias',$row['employee_alias']),'ec_designation','designation_alias','grade');
						$cr_limit = alias(employeeDetails('designation_alias',$row['employee_alias']),'ec_expense_limits','designation_alias','limit_amount');
						if($cr_limit == ''){
							$result['credit_limit']=0;
						}else{
							$result['credit_limit']=alias(employeeDetails('designation_alias',$row['employee_alias']),'ec_expense_limits','designation_alias','limit_amount');
						}
				}
				if(strtoupper($emp_alias) == 'ADMIN' || strtoupper($emp_alias) == 'EADMIN' || $chapp > 0) {
					$result['chapp']=1;
				} else {
					$result['chapp']=0;
				}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		
		}
	}elseif($chk==1){
		$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function dashboard_empview(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$viewemp_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
			$result['employee_id']=employeeDetails('employee_id',$viewemp_alias);
			$result['employee_alias']=$viewemp_alias;
			$result['name']=employeeDetails('name',$viewemp_alias);
			$result['department']=alias(employeeDetails('department_alias',$viewemp_alias),'ec_department','department_alias','department_name');
			$result['designation']=alias(employeeDetails('designation_alias',$viewemp_alias),'ec_designation','designation_alias','designation');
			$result['grade']=alias(employeeDetails('designation_alias',$viewemp_alias),'ec_designation','designation_alias','grade');
			if(checkspldep($viewemp_alias)=='3'){
				if(getRoleStat(employeeDetails('role_alias',$viewemp_alias)) == 0){
					$service_dept_onroll = '1';
				} else {
					$service_dept_onroll = '0';
				}
			} else {
				$service_dept_onroll = '0';
			}
			$condition=$condition1="";
			$requestID=mysqli_real_escape_string($mr_con,$_REQUEST['requestID']);
			$requestDate=mysqli_real_escape_string($mr_con,$_REQUEST['requestDate']);
			if($requestDate != ''){$requestDate=date("Y-m-d", strtotime($requestDate));}

			$requestamt=mysqli_real_escape_string($mr_con,$_REQUEST['requestamt']);
			$reqStat=mysqli_real_escape_string($mr_con,$_REQUEST['reqStat']);
			$reqtype=mysqli_real_escape_string($mr_con,$_REQUEST['reqtype']);
		
			if($requestID!=""){$condition.="request_id LIKE '%".$requestID."%' AND ";$condition1.="bill_number LIKE '%".$requestID."%' AND ";}
			
			if($requestDate!=""){$condition.="requested_date ='".$requestDate."' AND ";$condition1.="requested_date ='".$requestDate."' AND ";}
			
			if($requestamt!=""){$condition.="request_amount LIKE '%".$requestamt."%' AND ";$condition1.="total_tour_expenses LIKE '%".$requestamt."%' AND ";}
			
			if($reqStat!=""){$condition.="approval_level ='".$reqStat."' AND ";$condition1.="approval_level ='".$reqStat."' AND ";}
			
			if($reqtype==0 && $reqtype!=""){$condition1="bill_number = '0000' AND ";}
			elseif($reqtype==1 && $reqtype!=""){$condition="request_id = '0000' AND ";}
			$trec = 0;
			$rec=mysqli_query($mr_con,"(SELECT count(id) as counti  FROM ec_advances WHERE employee_alias='$viewemp_alias' AND $condition flag=0) UNION (SELECT count(id) as counti FROM ec_expenses WHERE employee_alias='$viewemp_alias' AND $condition1 flag=0)");
			while($row=mysqli_fetch_array($rec)){
				$trec +=$row['0'];
			}
			$result['dashempview']=array();
		if($trec>0){
			$totalRecords=$trec;
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql=mysqli_query($mr_con,"(SELECT request_id as requestId,requested_date as rd,request_amount as amt,total_amount as tamt,approval_level as al,advance_alias as alias FROM ec_advances WHERE employee_alias='$viewemp_alias' AND $condition flag=0 ORDER BY requested_date) UNION (SELECT bill_number as requestId,requested_date as rd,total_tour_expenses as amt,flag as tamt,approval_level as al,expenses_alias as alias FROM ec_expenses WHERE employee_alias='$viewemp_alias' AND $condition1 flag=0 ORDER BY requested_date)");
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['dashempview'][$i]['requestId']=$row['requestId'];	
					$result['dashempview'][$i]['requestType']=requesttype($row['requestId'],$row['alias']);				
					$result['dashempview'][$i]['rd']=$row['rd'];
					$result['dashempview'][$i]['amt']=sprintf('%0.2f',$row['amt']);
					$result['dashempview'][$i]['tamt']=sprintf('%0.2f',$row['tamt']);
					$result['dashempview'][$i]['al']=$row['al'];
					$result['dashempview'][$i]['explevel']=exlevelsName($row['al']);
					$result['dashempview'][$i]['alias']=$row['alias'];
					$result['dashempview'][$i]['ealias']=$viewemp_alias;
					if(requesttype($row['requestId'],$row['alias']) == 'advance'){
						$result['dashempview'][$i]['download_page']='advances_download';
					}else if(requesttype($row['requestId'],$row['alias']) == 'expense'){
						if($service_dept_onroll == '1'){
							$result['dashempview'][$i]['download_page']='ser_expenses_download';
						}else if($service_dept_onroll == '0'){
							$result['dashempview'][$i]['download_page']='oth_expense_download';
						}else{
							$result['dashempview'][$i]['download_page']='';
						}				
					}else $result['dashempview'][$i]['download_page']='';
					
					$i++;}
				
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}	
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
// End - User Dashboard

function checkScmScmtLevel($empAlias) {
	global $mr_con;
	$query = "SELECT * FROM ec_expense_approvals WHERE approval_level = 2 and approver = '$empAlias'";
	$sql = mysqli_query($mr_con, $query);
	if (mysqli_num_rows($sql) > 0 ) {
		return true;
	}
	return false;
}

function checkFinanceLevel($empAlias) {
	global $mr_con;
	$query = "SELECT * FROM ec_expense_approvals WHERE approval_level = 3 and approver = '$empAlias'";
	$sql = mysqli_query($mr_con, $query);
	if (mysqli_num_rows($sql) > 0 ) {
		return true;
	}
	return false;
}

// Start - User Expense
function user_expences_mul_view(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	$chapp=checkApproval($emp_alias);
	$emp_spl_dep=checkspldep($emp_alias);
	
	$result['scm_import'] = checkScmScmtLevel($emp_alias);
	$result['finance_import'] = checkFinanceLevel($emp_alias);
	
	$viewAll = grantable('VIEW ALL', 'EXPENSE TRACKER', $emp_alias);
	if(strtoupper($emp_alias) == 'ADMIN' || strtoupper($emp_alias) == 'EADMIN'){
		$result['open_page']='';
	} else {
		if(getRoleStat(employeeDetails('role_alias',$_REQUEST['emp_alias'])) == 0) {  $open_page="serviceExpense";  } else {  $open_page="bookExpense";  }
		$result['open_page']=$open_page;
	}
	if($chapp==1 || $emp_spl_dep==1 || $emp_spl_dep==2) {$display_name = 'yes';}else{$display_name = 'no';}
	$result['eadmin']=$emp_alias;
	if($viewAll || strtoupper($emp_alias) == 'ADMIN' || strtoupper($emp_alias) == 'EADMIN'){
		$display_name = 'yes';
	}
	$result['display_name']=$display_name;
	if($chk==0){
		$condition="";
		$sortbill_number=mysqli_real_escape_string($mr_con,$_REQUEST['sortbill_number']);
		$requestDate=mysqli_real_escape_string($mr_con,$_REQUEST['requestDate']);
		$totalExpense=mysqli_real_escape_string($mr_con,$_REQUEST['totalExpense']);
		$refund_amount=mysqli_real_escape_string($mr_con,$_REQUEST['refund_amount']);
		$outbal=mysqli_real_escape_string($mr_con,$_REQUEST['outbal']);
		$placeofVisit=mysqli_real_escape_string($mr_con,$_REQUEST['placeofVisit']);
		$reqStat=mysqli_real_escape_string($mr_con,$_REQUEST['reqStat']);
		$req_by=mysqli_real_escape_string($mr_con,$_REQUEST['req_by']);
		//echo "&&".$_REQUEST['empname']."&&";
		
		if($requestDate != ''){$requestDate=date("Y-m-d", strtotime($requestDate));}
		if($sortbill_number!="") $condition.=" bill_number LIKE '%".$sortbill_number."%' AND ";
		if($requestDate!="")$condition.=" requested_date='".$requestDate."' AND ";
		if($req_by!="")$condition.=" employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE name LIKE '%$req_by%') AND ";
		if($totalExpense!="")$condition.=" total_tour_expenses LIKE '%".$totalExpense."%' AND ";
		if($refund_amount!="")$condition.=" refund_amount LIKE '%".$refund_amount."%' AND ";
		
		if($placeofVisit!="")$condition.=" places_of_visit LIKE '%".$placeofVisit."%' AND ";
		if($reqStat!="")$condition.=" approval_level LIKE '%".$reqStat."%' AND ";
		$trec = '0';
		if($viewAll || strtoupper($emp_alias) == 'ADMIN' || strtoupper($emp_alias) == 'EADMIN') {
			$display_name = 'yes';
			$result['display_name']=$display_name;
			$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_expenses WHERE approval_level<>'0' AND $condition flag=0");
			while($row=mysqli_fetch_array($rec)){$trec = $row[0];}
		}else{
			//echo $emp_spl_dep."-".$chapp;
			if($chapp<='0' && ($emp_spl_dep=="1" || $emp_spl_dep=="2")){
				$rec=mysqli_query($mr_con,"(SELECT count(id) FROM ec_expenses WHERE $condition flag=0 AND approval_level<>'0' AND employee_alias<>'$emp_alias') UNION ALL (SELECT count(id) FROM ec_expenses WHERE $condition employee_alias='$emp_alias' AND flag=0)");
				while($row=mysqli_fetch_array($rec)){
					$trec +=$row['0'];
				}
			}
			else if($chapp>0){
				if (in_array('5', approvelvl($emp_alias))) {
					$rec=mysqli_query($mr_con,"(SELECT count(id) FROM ec_expenses WHERE $condition employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE department_alias IN (SELECT approval_dep FROM ec_expense_approvals WHERE approver='$emp_alias' AND flag=0) AND (flag=0 or flag=1)) AND flag=0 AND approval_level IN('2','5') AND employee_alias<>'$emp_alias') UNION ALL (SELECT count(id) FROM ec_expenses WHERE $condition employee_alias='$emp_alias' AND flag=0)");
					while($row=mysqli_fetch_array($rec)){
						$trec +=$row['0'];
					}
				}
				else{
					$rec=mysqli_query($mr_con,"(SELECT count(id) FROM ec_expenses WHERE $condition employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE department_alias IN (SELECT approval_dep FROM ec_expense_approvals WHERE approver='$emp_alias' AND flag=0) AND (flag=0 or flag=1)) AND flag=0 AND approval_level NOT IN('0','6','7') AND employee_alias<>'$emp_alias') UNION ALL (SELECT count(id) FROM ec_expenses WHERE $condition employee_alias='$emp_alias' AND flag=0)");
					while($row=mysqli_fetch_array($rec)){
						$trec +=$row['0'];
					}
				}
			}else{
				$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_expenses WHERE $condition employee_alias='$emp_alias' AND flag=0");
				$row=mysqli_fetch_array($rec);
				$trec = $row[0];
			}
		}
		$result['user_expences']=array();
		if(strtoupper($emp_alias) == 'ADMIN' || strtoupper($emp_alias) == 'EADMIN') {
			$result['add']=FALSE;
			$result['splEdit']=True;
			$result['delete']=True;
			$result['mapping']=True;
		}else{
			$result['add']=grantable('ADD','EXPENSE TRACKER',$emp_alias);
			$result['splEdit']=grantable('SPECIAL','EXPENSE TRACKER',$emp_alias);
			$result['delete']=grantable('DELETE','EXPENSE TRACKER',$emp_alias);
			$result['mapping']=grantable('MAPPING','EXPENSE TRACKER',$emp_alias);
		}
		if($trec>0){
			$totalRecords=$trec;
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			//if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$totalpages=ceil($totalRecords/$limit);
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			
			if($viewAll || strtoupper($emp_alias) == 'ADMIN' || strtoupper($emp_alias) == 'EADMIN') {
				$sql=mysqli_query($mr_con,"SELECT id,utr_num,employee_alias,bill_number,requested_date,refund_amount,total_tour_expenses,places_of_visit,approval_level,expenses_alias FROM ec_expenses WHERE approval_level<>'0' AND $condition flag=0 ORDER BY requested_date DESC, id DESC LIMIT $offset, $limit");
			}else{
				if($chapp=='0' && ($emp_spl_dep=="1" || $emp_spl_dep=="2")){
					$sql=mysqli_query($mr_con,"(SELECT id,utr_num,employee_alias,bill_number,requested_date,refund_amount,total_tour_expenses,places_of_visit,approval_level,expenses_alias FROM ec_expenses WHERE $condition flag=0 AND approval_level<>'0' AND employee_alias<>'$emp_alias') UNION ALL (SELECT id,utr_num,employee_alias,bill_number,requested_date,refund_amount,total_tour_expenses,places_of_visit,approval_level,expenses_alias FROM ec_expenses WHERE $condition employee_alias='$emp_alias' AND flag=0) ORDER BY requested_date DESC, id DESC LIMIT $offset, $limit");
				}
				else if($chapp>0){
					if (in_array('5', approvelvl($emp_alias))) {
						$sql=mysqli_query($mr_con,"(SELECT id,utr_num,employee_alias,bill_number,requested_date,refund_amount,total_tour_expenses,places_of_visit,approval_level,expenses_alias FROM ec_expenses WHERE $condition employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE department_alias IN (SELECT approval_dep FROM ec_expense_approvals WHERE approver='$emp_alias' AND flag=0) AND (flag=0 or flag=1)) AND flag=0 AND approval_level IN('2','5') AND employee_alias<>'$emp_alias') UNION ALL (SELECT id,utr_num,employee_alias,bill_number,requested_date,refund_amount,total_tour_expenses,places_of_visit,approval_level,expenses_alias FROM ec_expenses WHERE $condition employee_alias='$emp_alias' AND flag=0) ORDER BY requested_date DESC, id DESC LIMIT $offset, $limit");
					} else {
						$sql=mysqli_query($mr_con,"(SELECT id,utr_num,employee_alias,bill_number,requested_date,refund_amount,total_tour_expenses,places_of_visit,approval_level,expenses_alias FROM ec_expenses WHERE $condition employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE department_alias IN (SELECT approval_dep FROM ec_expense_approvals WHERE approver='$emp_alias' AND flag=0) AND (flag=0 or flag=1)) AND flag=0 AND approval_level NOT IN('0','6','7') AND employee_alias<>'$emp_alias') UNION ALL (SELECT id,utr_num,employee_alias,bill_number,requested_date,refund_amount,total_tour_expenses,places_of_visit,approval_level,expenses_alias FROM ec_expenses WHERE $condition employee_alias='$emp_alias' AND flag=0) ORDER BY requested_date DESC, id DESC LIMIT $offset, $limit");
					}
				}else{
					$sql=mysqli_query($mr_con,"SELECT id,utr_num,employee_alias,bill_number,requested_date,refund_amount,total_tour_expenses,places_of_visit,approval_level,expenses_alias FROM ec_expenses WHERE $condition employee_alias='$emp_alias' AND flag=0 ORDER BY requested_date DESC, id DESC LIMIT $offset, $limit");
				}
			
			}
			
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['user_expences'][$i]['employee_alias']=$row['employee_alias'];
					$result['user_expences'][$i]['utr_num']=$row['utr_num'];
					$result['user_expences'][$i]['bill_number']=$row['bill_number'];
					$result['user_expences'][$i]['requested_date']=$row['requested_date'];
					$result['user_expences'][$i]['total_tour_expenses']=sprintf('%0.2f',$row['total_tour_expenses']);
					$result['user_expences'][$i]['refund_amount']=sprintf('%0.2f',$row['refund_amount']);
					$result['user_expences'][$i]['outbal']=sprintf('%0.2f',advanceNotSettled($row['employee_alias']));
					$result['user_expences'][$i]['approval_level']=exlevelsName($row['approval_level']);
					$place_visit=$row['places_of_visit'];
					$result['user_expences'][$i]['places_of_visit']=$place_visit;
					$result['user_expences'][$i]['places_of_visit_half'] = ((strlen($place_visit) > 12) ? substr($place_visit,0,12)."..." : $place_visit);
					$result['user_expences'][$i]['approval_level1']=$row['approval_level'];
					$result['user_expences'][$i]['expenses_alias']=$row['expenses_alias'];
					$result['user_expences'][$i]['check_approval']=$chapp;
					$result['user_expences'][$i]['checkspldep']=$emp_spl_dep;
					$emp_name=employeeDetails('name',$row['employee_alias']);
					$result['user_expences'][$i]['emp_name']= $emp_name;
					$result['user_expences'][$i]['emp_name_half'] = ((strlen($emp_name) > 15) ? substr($emp_name,0,15)."..." : $emp_name);
					$result['user_expences'][$i]['display_name']= $display_name;
					$i++;}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}else{$resCode='4'; $resMsg='No Records Found';}
	}elseif($chk==1){
		$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}

function user_expences_view(){
 	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	$viewemp_expalias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
	if($chk==0){
		$resultz=expensefullView($viewemp_expalias);
		$result['expenses_alias'] = $viewemp_expalias;
		$result['ref2'] = $resultz[0]['approval_level'];
		$result['bill_number'] = $resultz[0]['bill_number'];
		$result['requested_date'] = $resultz[0]['requested_date'];
		$result['empalias'] = $resultz[0]['employee_alias'];
		$result['employee_name'] = employeeDetails('name',$resultz[0]['employee_alias']);
		$result['empdept'] =checkspldep($resultz[0]['employee_alias']);
		$result['period_of_visit_from'] =date("d-m-Y", strtotime($resultz[0]['period_of_visit_from']));
		$result['places_of_visit'] =$resultz[0]['places_of_visit'];
		$result['po_gnr'] =$resultz[0]['po_gnr'];
		$result['employee_id'] = employeeDetails('employee_id',$resultz[0]['employee_alias']);
		$result['grade'] = alias(employeeDetails('designation_alias',$resultz[0]['employee_alias']),'ec_designation','designation_alias','grade');
		$result['places_of_visit_to'] =date("d-m-Y", strtotime($resultz[0]['period_of_visit_to']));
		$result['no_of_days'] = noofDays($resultz[0]['period_of_visit_from'],$resultz[0]['period_of_visit_to']);
		$result['purpose'] =$resultz[0]['purpose'];
		$remarks=getRemarks($viewemp_expalias,'BE');
		$result['remarkss'] =$remarks[0]['remarks'];
		if($resultz[0]['report']!=='0' && $resultz[0]['report']!=''){$tour_link=urllink($resultz[0]['requested_date']).$resultz[0]['report'];}else{$tour_link='';}
		$result['report'] = $tour_link;
		$result['hidden_report']=$resultz[0]['report'];
		if($resultz[0]['utr_num']!=='0' && $resultz[0]['utr_num']!==''){$result['utr_num'] = $resultz[0]['utr_num'];}else $result['utr_num'] ='';
		if(checkspldep($resultz[0]['employee_alias'])=='3'){
			if(getRoleStat(employeeDetails('role_alias',$resultz[0]['employee_alias'])) == 0){
				$service_dept_onroll = '1';
			} else {
				$service_dept_onroll = '0';
			}
			$show_report = FALSE;
		} else {
			$service_dept_onroll = '0';$show_report = TRUE;
		}
		$result['service_dept_onroll']=$service_dept_onroll;
		$result['show_report']=$show_report;
		
		if(($_REQUEST['emp_alias']==$resultz[0]['employee_alias']) && ($resultz[0]['approval_level']==0 || $resultz[0]['approval_level']==8)){
			$hover_edit = "Request";
			$edit = "1";
			$readonly_page = '0';
		}
		if(chouldshow($_REQUEST['emp_alias'],$resultz[0]['approval_level'])==1){ 
			$hover_edit = "Approvals";
			$edit = "1";
			$readonly_page = '1';
		}
		if(financeemp($_REQUEST['emp_alias'])=='2' && $resultz[0]['approval_level']=='6' && $resultz[0]['utr_num']=='0'){
			$hover_edit = "Approvals";
			$edit = "1";
			$readonly_page = '1';
			$submit_button= '1';
		}else{
			 $submit_button = '0';
		}
		$result['edit'] = $edit;
		$result['hover_edit'] = $hover_edit;
		$result['readonly_page'] = $readonly_page;	
		$result['submit_button'] = $submit_button;			
		if(($_REQUEST['emp_alias']==$resultz[0]['employee_alias']) && ($resultz[0]['approval_level']==0 || $resultz[0]['approval_level']==8)){
		$result['single_edit'] = TRUE;	
		}else{ $result['single_edit'] = FALSE;	}

		// conveyance
		$csql=mysqli_query($mr_con,"SELECT expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,document_link,created_date,dpr_number,ticket_alias FROM ec_conveyance WHERE expenses_alias='$viewemp_expalias' AND flag=0");
		$con_count = mysqli_num_rows($csql);
		$result['exp_conveyance']=array();
		$result['exp_con_count']=$con_count;
		if(mysqli_num_rows($csql)){
			$i=0;
			$tot_con_amt ='';$url_path='';
			while($row = mysqli_fetch_array($csql)){
				$result['exp_conveyance'][$i]['expenses_alias']=$row['expenses_alias'];	
				$result['exp_conveyance'][$i]['date_of_travel']=date("d-m-Y", strtotime($row['date_of_travel']));				
				$result['exp_conveyance'][$i]['mode_of_travel']=$row['mode_of_travel'];
				$result['exp_conveyance'][$i]['from_place']=$row['from_place'];
				$result['exp_conveyance'][$i]['to_place']=$row['to_place'];
				$result['exp_conveyance'][$i]['amount']=$row['amount'];
				$result['exp_conveyance'][$i]['alias']=$row['alias'];
				if($row['document_link']!=='0' && $row['document_link']!=''){$con_link=urllink($row['created_date']).$row['document_link'];}else{$con_link='';}
				$result['exp_conveyance'][$i]['document_link']=$con_link;
				$result['exp_conveyance'][$i]['hidden_document_link']=$row['document_link'];
				if($row['dpr_number'] != '') $con_dpr = $row['dpr_number'];else $con_dpr = '--';
				$result['exp_conveyance'][$i]['dpr_number']=$con_dpr;
				if($row['ticket_alias'] != ''){ if($row['ticket_alias'] == "1") $con_ticket_name="Others"; else $con_ticket_name=getTicketName($row['ticket_alias']);}else {$con_ticket_name='--';}
				$result['exp_conveyance'][$i]['ticket_alias']=$row['ticket_alias'];
				$result['exp_conveyance'][$i]['ticket_val']=$con_ticket_name;
				$tot_con_amt+=$row['amount'];
				$i++;
			}
			//$result['tot_con_amt'] = $tot_con_amt;
		}
		if($tot_con_amt!=''){$result['tot_con_amt'] = $tot_con_amt;}else{$result['tot_con_amt'] = 0;}

		// local conveyance
		$lcsql=mysqli_query($mr_con,"SELECT expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,created_date,zone_alias,state_alias,district_alias,bucket,capacity,quantity,km,dpr_number,ticket_alias FROM ec_localconveyance WHERE expenses_alias='$viewemp_expalias' AND flag=0");
		$lcon_count = mysqli_num_rows($lcsql);
		$result['exp_locconveyance']=array();
		$result['exp_lcon_count']=$lcon_count;
		if(mysqli_num_rows($lcsql)){
			$i=0;
			$tot_lcon_amt ='';
			while($lrow = mysqli_fetch_array($lcsql)){
				$result['exp_locconveyance'][$i]['expenses_alias']=$lrow['expenses_alias'];	
				$result['exp_locconveyance'][$i]['date_of_travel']=date("d-m-Y", strtotime($lrow['date_of_travel']));			
				$result['exp_locconveyance'][$i]['mode_of_travel']=$lrow['mode_of_travel'];
				$result['exp_locconveyance'][$i]['from_place']=$lrow['from_place'];
				$result['exp_locconveyance'][$i]['to_place']=$lrow['to_place'];
				$result['exp_locconveyance'][$i]['amount']=$lrow['amount'];
				$result['exp_locconveyance'][$i]['alias']=$lrow['alias'];
				$result['exp_locconveyance'][$i]['created_date']=$lrow['created_date'];
				$result['exp_locconveyance'][$i]['zone_alias']=$lrow['zone_alias'];
				$result['exp_locconveyance'][$i]['zone_name']=getNames($lrow['zone_alias'],'ec_zone');
				$result['exp_locconveyance'][$i]['state_alias']=$lrow['state_alias'];
				$result['exp_locconveyance'][$i]['state_name']=getNames($lrow['state_alias'],'ec_state');
				$result['exp_locconveyance'][$i]['district_alias']=$lrow['district_alias'];	
				$result['exp_locconveyance'][$i]['district_name']=getNames($lrow['district_alias'],'ec_district');	
				if($lrow['bucket'] ==0)$bucket = 'Secondary transportation';else if($lrow['bucket']  ==1) $bucket = 'Local Conveyance'; else $bucket ='';
				$result['exp_locconveyance'][$i]['bucket']=$bucket;
				$result['exp_locconveyance'][$i]['bucket_val']=$lrow['bucket'];
				if(getWeights($lrow['capacity'],'product') != 0) $capacity=getWeights($lrow['capacity'],'product'); else $capacity='';
				$result['exp_locconveyance'][$i]['capacity']=$capacity;	
				$result['exp_locconveyance'][$i]['capacity_val']=$lrow['capacity'];	
				if(getWeights($lrow['capacity'],'weight')!= 0) $weight=getWeights($lrow['capacity'],'weight'); else $weight='';				
				$result['exp_locconveyance'][$i]['weight']=$weight;	
				$result['exp_locconveyance'][$i]['quantity']=$lrow['quantity'];
				$result['exp_locconveyance'][$i]['km']=$lrow['km'];
				$result['exp_locconveyance'][$i]['dpr_number']=$lrow['dpr_number'];
				$result['exp_locconveyance'][$i]['ticket_alias']=$lrow['ticket_alias'];
				if($lrow['ticket_alias'] == "1") $loc_ticket_name="Others"; else $loc_ticket_name=getTicketName($lrow['ticket_alias']);
				$result['exp_locconveyance'][$i]['ticket_val']=$loc_ticket_name;
				if(getArea($lrow['district_alias'])==0){
					$result['exp_locconveyance'][$i]['area']='PLAIN AREA';
					 $result['exp_locconveyance'][$i]['amount_appli'] = '0.02';}
				else if(getArea($lrow['district_alias'])==1)
				{$result['exp_locconveyance'][$i]['area']='HILLY AREA'; 
				$result['exp_locconveyance'][$i]['amount_appli'] ='0.04';
				}else{
				$result['exp_locconveyance'][$i]['area']=''; 
				$result['exp_locconveyance'][$i]['amount_appli'] = '';
				}
				$tot_lcon_amt+=$lrow['amount'];

				$i++;
			}
			//$result['tot_lcon_amt'] = $tot_lcon_amt;
		}if($tot_lcon_amt!=''){$result['tot_lcon_amt'] = $tot_lcon_amt;}else{$result['tot_lcon_amt'] = 0;}
		
		// lodging
		$lod_sql=mysqli_query($mr_con,"SELECT expenses_alias,type_of_stay,check_in,check_out,hotel_name,amount,alias,document_link,created_date,zone_alias,state_alias,district_alias,dpr_number,ticket_alias FROM ec_lodging WHERE expenses_alias='$viewemp_expalias' AND flag=0");
		$lod_count = mysqli_num_rows($lod_sql);
		$result['exp_lodging']=array();
		$result['exp_lod_count']=$lod_count;
		if(mysqli_num_rows($lod_sql)){
			$i=0;
			$tot_lod_amt ='';
			while($lod_row = mysqli_fetch_array($lod_sql)){
				$result['exp_lodging'][$i]['expenses_alias']=$lod_row['expenses_alias'];	
				$result['exp_lodging'][$i]['type_of_stay']=$lod_row['type_of_stay'];				
				$result['exp_lodging'][$i]['check_in']=date("d-m-Y", strtotime($lod_row['check_in']));
				$result['exp_lodging'][$i]['check_out']=date("d-m-Y", strtotime($lod_row['check_out']));
				$result['exp_lodging'][$i]['hotel_name']=$lod_row['hotel_name'];
				$result['exp_lodging'][$i]['amount']=$lod_row['amount'];
				$result['exp_lodging'][$i]['alias']=$lod_row['alias'];
				if($lod_row['document_link']!=='0' && $lod_row['document_link']!=''){$lod_link=urllink($lod_row['created_date']).$lod_row['document_link'];}else{$lod_link='';}
				$result['exp_lodging'][$i]['document_link']=$lod_link;
				$result['exp_lodging'][$i]['hidden_document_link']=$lod_row['document_link'];
				$result['exp_lodging'][$i]['created_date']=$lod_row['created_date'];
				if($lod_row['zone_alias'] != ''){$lod_zone = getNames($lod_row['zone_alias'],'ec_zone');}else{$lod_zone = '--';}
				if($lod_row['state_alias'] != ''){$lod_state = getNames($lod_row['state_alias'],'ec_state');}else{$lod_state = '--';}
				if($lod_row['district_alias'] != ''){$lod_district = getNames($lod_row['district_alias'],'ec_district');}else{$lod_district = '--';}
				$result['exp_lodging'][$i]['zone_name']=$lod_zone;
				$result['exp_lodging'][$i]['state_name']=$lod_state;
				$result['exp_lodging'][$i]['district_name']=$lod_district;				
				$result['exp_lodging'][$i]['zone_alias']=$lod_row['zone_alias'];
				$result['exp_lodging'][$i]['state_alias']=$lod_row['state_alias'];
				$result['exp_lodging'][$i]['district_alias']=$lod_row['district_alias'];	
				if($lod_row['ticket_alias'] != ''){ if($lod_row['ticket_alias'] == "1") $lod_ticket_name="Others"; else $lod_ticket_name=getTicketName($lod_row['ticket_alias']);}else {$lod_ticket_name='--';}
				$result['exp_lodging'][$i]['ticket_alias']=$lod_row['ticket_alias'];
				$result['exp_lodging'][$i]['ticket_val']=$lod_ticket_name;				
				if($lod_row['dpr_number'] != '') $lod_dpr = $lod_row['dpr_number'];else $lod_dpr = '--';
				$result['exp_lodging'][$i]['dpr_number']=$lod_dpr;
				$tot_lod_amt+=$lod_row['amount'];
				$i++;
			}
			//$result['tot_lod_amt'] = $tot_lod_amt;
		}if($tot_lod_amt!=''){$result['tot_lod_amt'] = $tot_lod_amt;}else{$result['tot_lod_amt'] = 0;}

		
		// Boarding
		$bod_sql=mysqli_query($mr_con,"SELECT expenses_alias,check_in,check_out,state,amount,alias,created_date,zone_alias,state_alias,district_alias,dpr_number,ticket_alias FROM ec_boarding WHERE expenses_alias='$viewemp_expalias' AND flag=0");
		$bod_count = mysqli_num_rows($bod_sql);
		$result['exp_boarding']=array();
		$result['exp_bod_count']=$bod_count;
		if(mysqli_num_rows($bod_sql)){
			$i=0;
			$tot_bod_amt ='';
			while($bod_row = mysqli_fetch_array($bod_sql)){
				$result['exp_boarding'][$i]['expenses_alias']=$bod_row['expenses_alias'];	
				$result['exp_boarding'][$i]['check_in']=date("d-m-Y", strtotime($bod_row['check_in']));
				$result['exp_boarding'][$i]['check_out']=date("d-m-Y", strtotime($bod_row['check_out']));
				$result['exp_boarding'][$i]['state']=$bod_row['state'];
				$result['exp_boarding'][$i]['amount']=$bod_row['amount'];
				$result['exp_boarding'][$i]['alias']=$bod_row['alias'];
				$result['exp_boarding'][$i]['created_date']=$bod_row['created_date'];
				if($bod_row['zone_alias'] != ''){$bod_zone = getNames($bod_row['zone_alias'],'ec_zone');}else{$bod_zone = '--';}
				if($bod_row['state_alias'] != ''){$bod_state = getNames($bod_row['state_alias'],'ec_state');}else{$bod_state = '--';}
				if($bod_row['district_alias'] != ''){$bod_district = getNames($bod_row['district_alias'],'ec_district');}else{$bod_district = '--';}
				$result['exp_boarding'][$i]['zone_name']=$bod_zone;
				$result['exp_boarding'][$i]['state_name']=$bod_state;
				$result['exp_boarding'][$i]['district_name']=$bod_district;
				$result['exp_boarding'][$i]['zone_alias']=$bod_row['zone_alias'];
				$result['exp_boarding'][$i]['state_alias']=$bod_row['state_alias'];
				$result['exp_boarding'][$i]['district_alias']=$bod_row['district_alias'];	
				if($bod_row['ticket_alias'] != ''){ if($bod_row['ticket_alias'] == "1") $bod_ticket_name="Others"; else $bod_ticket_name=getTicketName($bod_row['ticket_alias']);}else {$bod_ticket_name='--';}
				$result['exp_boarding'][$i]['ticket_val']=$bod_ticket_name;
				$result['exp_boarding'][$i]['ticket_alias']=$bod_row['ticket_alias'];
				if($bod_row['dpr_number'] != '') $bod_dpr = $bod_row['dpr_number'];else $bod_dpr = '--';
				$result['exp_boarding'][$i]['dpr_number']=$bod_dpr;
				$tot_bod_amt+=$bod_row['amount'];
				$i++;
			}
			//$result['tot_bod_amt'] = $tot_bod_amt;
		}if($tot_bod_amt!=''){$result['tot_bod_amt'] = $tot_bod_amt;}else{$result['tot_bod_amt'] = 0;}

		
		// Others
		$oth_sql=mysqli_query($mr_con,"SELECT expenses_alias,description,amount,checked_date,alias,document_link,created_date,dpr_number,ticket_alias FROM ec_other_expenses WHERE  expenses_alias='$viewemp_expalias' AND flag=0");
		$oth_count = mysqli_num_rows($oth_sql);
		$result['exp_others']=array();
		$result['exp_oth_count']=$oth_count;
		if(mysqli_num_rows($oth_sql)){
			$i=0;
			$tot_oth_amt ='';
			while($oth_row = mysqli_fetch_array($oth_sql)){
				$result['exp_others'][$i]['expenses_alias']=$oth_row['expenses_alias'];	
				$result['exp_others'][$i]['description']=$oth_row['description'];
				$result['exp_others'][$i]['checked_date']=date("d-m-Y", strtotime($oth_row['checked_date']));
				if($oth_row['document_link']!=='0' && $oth_row['document_link']!=''){$oth_link=urllink($oth_row['created_date']).$oth_row['document_link'];}else{$oth_link='';}
				$result['exp_others'][$i]['document_link']=$oth_link;
				$result['exp_others'][$i]['hidden_document_link']=$oth_row['document_link'];
				$result['exp_others'][$i]['amount']=$oth_row['amount'];
				$result['exp_others'][$i]['alias']=$oth_row['alias'];
				$result['exp_others'][$i]['created_date']=$oth_row['created_date'];
				if($oth_row['ticket_alias'] != ''){ if($oth_row['ticket_alias'] == "1") $oth_ticket_name="Others"; else $oth_ticket_name=getTicketName($oth_row['ticket_alias']);}else {$oth_ticket_name='--';}
				$result['exp_others'][$i]['ticket_val']=$oth_ticket_name;
				$result['exp_others'][$i]['ticket_alias']=$oth_row['ticket_alias'];
				if($oth_row['dpr_number'] != '') $oth_dpr = $oth_row['dpr_number'];else $oth_dpr = '--';
				$result['exp_others'][$i]['dpr_number']=$oth_dpr;
				$tot_oth_amt+=$oth_row['amount'];
				$i++;
			}
			//$result['tot_oth_amt'] = $tot_oth_amt;
		}if($tot_oth_amt!=''){$result['tot_oth_amt'] = $tot_oth_amt;}else{$result['tot_oth_amt'] = 0;}
		$tot_exp_count=$con_count+$lcon_count+$lod_count+$bod_count+$oth_count;
		$result['tot_exp_count']=$tot_exp_count;

		$remarks_sql=mysqli_query($mr_con,"SELECT remarks, remarked_by, remarked_on, remark_alias FROM ec_remarks WHERE item_alias='$viewemp_expalias' AND module='BE' AND flag=0  order by id");
		$remarks_count = mysqli_num_rows($remarks_sql);
		$result['remarks']=array();
		$result['remarks_count']=$remarks_count;		
		if(mysqli_num_rows($remarks_sql)){
			$i=0;
			while($remarks_row = mysqli_fetch_array($remarks_sql)){
				if($i==0){
					$result['user_remarks'] = $remarks_row['remarks'];
				}
				$result['remarks'][$i]['remarks_desc']=$remarks_row['remarks'];	
				$result['remarks'][$i]['remarks_alias']=$remarks_row['remark_alias'];	
				$result['remarks'][$i]['remarked_by']=employeeDetails('name',$remarks_row['remarked_by']);
				$result['remarks'][$i]['remarked_by_alias']=$remarks_row['remarked_by'];
				$result['remarks'][$i]['remarked_on']=date("d-M-Y", strtotime($remarks_row['remarked_on']));
				$result['remarks'][$i]['remarked_on_format']=date("Y-m-d", strtotime($remarks_row['remarked_on']));
				$i++;
			}
		}
		$outstanding = advanceNotSettled($resultz[0]['employee_alias']);
		$result['outstanding'] = $outstanding!=0 ? $outstanding : "No pending Advances";
		$result['booked_expenses'] = round($resultz[0]['total_tour_expenses']);
		$result['reimbursement_amount'] =round($resultz[0]['reimbursement_amount']);
		$result['refund_amount'] =round($resultz[0]['refund_amount']);
		$result['final_amount'] =((round($resultz[0]['total_tour_expenses'])-$outstanding));
	}elseif($chk==1){
		$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function return_false($resMsg){
	$result['ErrorDetails']['ErrorCode']='4'; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	return json_encode($result);
}

function service_expences_add(){ 
	global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	$draft = mysqli_real_escape_string($mr_con,$_REQUEST['ref']);
	if($chk==0){
		if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['visitFromDate'])){$res="Select Visit from Date";}
		else if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['visitToDate'])){$res="Select Visit to Date";}
		//else if($_REQUEST['visitFromDate']>$_REQUEST['visitToDate']){$res="Visit end Date should be greater than or equal to Visit start Date";}
		else if(mysqli_real_escape_string($mr_con,trim($_REQUEST['placesOfVisit']))==""){$res="Enter Places Of Visit";}
		else if(mysqli_real_escape_string($mr_con,trim($_REQUEST['purpose']))==""){$res="Enter Purpose";}
		else if(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks']))==""){$res="Enter Remarks";}
/*		else if((mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_loc'])=="") && (mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_con'])=="") && (mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_lod'])=="") && (mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_bod'])=="") && (mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_oth'])=="")){$res="Enter Atleast One Expense Details";}
		else if(filter_var($_REQUEST['texp'], FILTER_VALIDATE_INT) == false){$res="Enter Atleast One Expense Details";}
*/		else{
			$mess=1;
			//Local Conveyance Validation
			for($i=0;$i<count($_REQUEST['zone_l']);$i++){
				if($_REQUEST['zone_l'][$i] == '' && $_REQUEST['state_l'][$i] == '' && $_REQUEST['district_l'][$i] == '' && $_REQUEST['bucket'][$i] =='' && $_REQUEST['dot_l'][$i]=='' && $_REQUEST['mot_l'][$i]=='' && $_REQUEST['from_l'][$i]=='' && $_REQUEST['to_l'][$i]=='' && $_REQUEST['ticket_idl'][$i]=='' && $_REQUEST['dprNum_l'][$i]=='' && $_REQUEST['amt_l'][$i]=='')	{
					$mess=1;
				}else{
					if($_REQUEST['zone_l'][$i]=='') {$resCode='4';$mess="Local Conveyance" .($i+1). ": Select  Zone";$resMsg=$mess;}
					else if($_REQUEST['state_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select State";$resMsg=$mess;}
					else if($_REQUEST['district_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select District";$resMsg=$mess;}
					else if($_REQUEST['bucket'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select Bucket";$resMsg=$mess;}
					else if($_REQUEST['bucket'][$i]!=''){
						if($_REQUEST['bucket'][$i]== "0"){
							if($_REQUEST['cap'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select Capacity";$resMsg=$mess;}
							else if($_REQUEST['quantityCell'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Enter Quantity";$resMsg=$mess;}
							else if($_REQUEST['numKilometers'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Enter No.of Kilometers";$resMsg=$mess;}
							else if($_REQUEST['dot_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select Date of travel";$resMsg=$mess;}
							else if($_REQUEST['from_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Enter From place";$resMsg=$mess;}
							else if($_REQUEST['to_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Enter To place";$resMsg=$mess;}
							else if($_REQUEST['mot_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select Mode of travel";$resMsg=$mess;}
							else if($_REQUEST['ticket_idl'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select Ticket Id";$resMsg=$mess;}
							else if($_REQUEST['dprNum_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Enter DPR Number";$resMsg=$mess;}
							else if($_REQUEST['amt_l'][$i]=='' || $_REQUEST['amt_l'][$i]=='0'){$resCode='4';$mess="Local Conveyance" .($i+1). ": Amount Required";$resMsg=$mess;}
							else $mess=1;
						}else{
							if($_REQUEST['dot_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select Date of travel";$resMsg=$mess;}
							else if($_REQUEST['from_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Enter From place";$resMsg=$mess;}
							else if($_REQUEST['to_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Enter To place";$resMsg=$mess;}
							else if($_REQUEST['mot_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select Mode of travel";$resMsg=$mess;}
							else if($_REQUEST['ticket_idl'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select Ticket Id";$resMsg=$mess;}
							else if($_REQUEST['dprNum_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Enter DPR Number";$resMsg=$mess;}
							else if($_REQUEST['amt_l'][$i]=='' || $_REQUEST['amt_l'][$i]=='0'){$resCode='4';$mess="Local Conveyance" .($i+1). ": Amount Required";$resMsg=$mess;}
							else $mess=1;
						}
					}else $mess=1;
				}
				if($mess!=1){ echo return_false($resMsg); exit;}
			}
			if($mess==1){
				//Conveyance Validation
				for($i=0;$i<count($_REQUEST['dot']);$i++){
					if($_REQUEST['dot'][$i] == '' && $_REQUEST['mot'][$i] == '' && $_REQUEST['from'][$i] == '' && $_REQUEST['to'][$i] =='' && $_REQUEST['cticket_id'][$i]=='' && $_REQUEST['cdprno'][$i]=='' && $_FILES['motbill']['name'][$i]=='' && $_REQUEST['amt'][$i]=='')	{
						$mess=1;
					}else{
						if($_REQUEST['dot'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Select Date of travel";$resMsg=$mess;}
						else if($_REQUEST['mot'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Select Mode of travel";$resMsg=$mess;}
						else if($_REQUEST['from'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Enter From place";$resMsg=$mess;}
						else if($_REQUEST['to'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Enter To place";$resMsg=$mess;}
						else if($_REQUEST['cticket_id'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Select Ticket Id";$resMsg=$mess;}
						else if($_REQUEST['cdprno'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Enter DPR Number";$resMsg=$mess;}
						else if($_FILES['motbill']['name'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Select File";$resMsg=$mess;}
						else if($_FILES['motbill']['name'][$i]!='' && $_FILES['motbill']['size'][$i]>5767168){$resCode='4';$mess="Conveyance" .($i+1). ": File Size Should be less than or equal to 5MB ";$resMsg=$mess;}
						else if($_REQUEST['amt'][$i]=='' || $_REQUEST['amt'][$i]=='0'){$resCode='4';$mess="Conveyance" .($i+1). ": Amount Required";$resMsg=$mess;}
						else $mess=1;
					}if($mess!=1){ echo return_false($resMsg); exit;}
				}
				if($mess==1){
					//Lodging Validation
					for($i=0;$i<count($_REQUEST['checkin']);$i++){
						if( $_REQUEST['typeofstay'][$i] == '' && $_REQUEST['checkin'][$i] == '' && $_REQUEST['checkout'][$i] == '' && $_REQUEST['zone_ld'][$i] == '' && $_REQUEST['state_ld'][$i] == '' && $_REQUEST['district_ld'][$i] == '' && $_REQUEST['hotelName'][$i] == '' && $_REQUEST['ticket_idld'][$i]=='' && $_REQUEST['dprNum_ld'][$i]=='' && $_REQUEST['lamt'][$i]=='' && $_FILES['lfile']['name'][$i] == '')	{
							$mess=1;
						}else{
							if($_REQUEST['typeofstay'][$i]==''){$resCode='4';$mess="Lodging" .($i+1). ": Select type of stay";$resMsg=$mess;}
							else if($_REQUEST['checkin'][$i]==''){$resCode='4';$mess="Lodging" .($i+1). ": Select Check in Date";$resMsg=$mess;}
							else if($_REQUEST['checkout'][$i]==''){$resCode='4';$mess="Lodging" .($i+1). ": Select Check Out Date";$resMsg=$mess;}
							else if($_REQUEST['ticket_idld'][$i]==''){$resCode='4';$mess="Lodging" .($i+1). ": Select Ticket Id";$resMsg=$mess;}
							else if($_REQUEST['dprNum_ld'][$i]==''){$resCode='4';$mess="Lodging" .($i+1). ": Enter DPR Number";$resMsg=$mess;}
							else if($_REQUEST['lamt'][$i]=='' || $_REQUEST['lamt'][$i]=='0'){$resCode='4';$mess="Lodging" .($i+1). ": Amount Required";$resMsg=$mess;}
							else if($_FILES['lfile']['name'][$i] !='' && $_FILES['lfile']['size'][$i]>5767168){$resCode='4';$mess="Lodging" .($i+1). ": File Size Should be less than or equal to 5MB ";$resMsg=$mess;}
							else $mess=1;
							if($_REQUEST['typeofstay'][$i]=='Self'){
								if($_REQUEST['zone_ld'][$i]==''){$resCode='4';$mess="Lodging " .($i+1). " : Select Zone";$resMsg=$mess;}
								else if($_REQUEST['state_ld'][$i]==''){$resCode='4';$mess="Lodging " .($i+1). " : Select State";$resMsg=$mess;}
								else if($_REQUEST['district_ld'][$i]==''){$resCode='4';$mess="Lodging " .($i+1). " : Select District";$resMsg=$mess;}
							}
							else if($_REQUEST['typeofstay'][$i]=='Reimbursement'){
								if($_REQUEST['hotelName'][$i]==''){$resCode='4';$mess="Lodging " .($i+1). " : Enter Hotel Name";$resMsg=$mess;}
								else if($_FILES['lfile']['size'][$i]==0){$resCode='4';$mess="Lodging " .($i+1). ": Document is mandatory for stay type Reimbursement";$resMsg=$mess;}
							}
						}
						if($mess!=1){ echo return_false($resMsg); exit;}
					}
				
				if($mess==1){
					//Boarding Validation
					for($i=0;$i<count($_REQUEST['checkinb']);$i++){
						if($_REQUEST['checkinb'][$i] == '' && $_REQUEST['checkoutb'][$i] == '' && $_REQUEST['zone_bo'][$i] == '' && $_REQUEST['state_bo'][$i] == '' && $_REQUEST['district_bo'][$i] == '' && $_REQUEST['ticket_bo'][$i] == '' && $_REQUEST['dprNum_bo'][$i]=='' && $_REQUEST['bamt'][$i]==''){
							$mess=1;
						}else{
							if($_REQUEST['checkinb'][$i]==''){$resCode='4';$mess="Boarding" .($i+1). ": Select Visit start Date";$resMsg=$mess;}
							else if($_REQUEST['checkoutb'][$i]==''){$resCode='4';$mess="Boarding" .($i+1). ": Select Visit end Date";$resMsg=$mess;}
							//else if($_REQUEST['checkinb'][$i]>$_REQUEST['checkoutb'][$i]){$resCode='4';$mess="Boarding" .($i+1). ": Visit end Date should be greater than or equal to Visit start Date";$resMsg=$mess;}
							else if($_REQUEST['zone_bo'][$i]=='') {$resCode='4';$mess="Boarding" .($i+1). ": Select Zone";$resMsg=$mess;}
							else if($_REQUEST['state_bo'][$i]==''){$resCode='4';$mess="Boarding" .($i+1). ": Select State";$resMsg=$mess;}
							else if($_REQUEST['district_bo'][$i]==''){$resCode='4';$mess="Boarding" .($i+1). ": Select District";$resMsg=$mess;}
							else if($_REQUEST['ticket_bo'][$i]==''){$resCode='4';$mess="Boarding" .($i+1). ": Select Ticket Id";$resMsg=$mess;}
							else if($_REQUEST['dprNum_bo'][$i]==''){$resCode='4';$mess="Boarding" .($i+1). ": Enter DPR Number";$resMsg=$mess;}
							else if($_REQUEST['bamt'][$i]=='' || $_REQUEST['bamt'][$i]=='0'){$resCode='4';$mess="Boarding" .($i+1). ": Amount Required";$resMsg=$mess;}
							else $mess=1;
						}
						if($mess!=1){ echo return_false($resMsg); exit;}
					}
					
					if($mess==1){
						//Others Validation
						for($i=0;$i<count($_REQUEST['others']);$i++){
							if($_REQUEST['others'][$i] == '' && $_REQUEST['odate'][$i] == '' && $_FILES['ofile']['name'][$i] == '' && $_REQUEST['ticket_ot'][$i] == '' && $_REQUEST['dprNum_ot'][$i]=='' && $_REQUEST['oamt'][$i]==''){
								$mess=1;
							}else{
								if($_REQUEST['others'][$i]==''){$resCode='4';$mess="Others" .($i+1). ": Enter Description";$resMsg=$mess;}
								else if($_REQUEST['odate'][$i]==''){$resCode='4';$mess="Others" .($i+1). ": Select Date";$resMsg=$mess;}
								else if($_FILES['ofile']['name'][$i]=='') {$resCode='4';$mess="Others" .($i+1). ": Select File";$resMsg=$mess;}
								else if($_FILES['ofile']['name'][$i]!='' && $_FILES['ofile']['size'][$i]>5767168){$resCode='4';$mess="Others" .($i+1). ": File Size Should be less than or equal to 5MB ";$resMsg=$mess;}
								else if($_REQUEST['ticket_ot'][$i]==''){$resCode='4';$mess="Others" .($i+1). ": Select Ticket Id";$resMsg=$mess;}
								else if($_REQUEST['dprNum_ot'][$i]==''){$resCode='4';$mess="Others" .($i+1). ": Enter DPR Number";$resMsg=$mess;}
								else if($_REQUEST['oamt'][$i]=='' || $_REQUEST['oamt'][$i]=='0'){$resCode='4';$mess="Others" .($i+1). ": Amount Required";$resMsg=$mess;}
								else $mess=1;
							}
							if($mess!=1){ echo return_false($resMsg); exit;}
						}
					}
				}
				}
			}
			
			if($mess==1){
				if((mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_loc'])=="") && (mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_con'])=="") && (mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_lod'])=="") && (mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_bod'])=="") && (mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_oth'])=="")){$res=$mess="Enter Atleast One Expense Details";}
			}
			
			if($mess==1){
				if((mysqli_real_escape_string($mr_con,$_REQUEST['texp'])=="") || (mysqli_real_escape_string($mr_con,$_REQUEST['texp'])=="0")){$res=$mess="Total Expense should not be empty or zero.Please Enter Atleast One Expense Details";}
			}
			if($mess==1){
				
				$rquestid="#".checkint(mt_rand(1000,999999999),'ec_expenses','bill_number');
				$empalias=$_REQUEST['emp_alias'];
				$visitFromDate=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['visitFromDate']))));
				$visitToDate=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['visitToDate']))));
				$placesOfVisit=mysqli_real_escape_string($mr_con,$_REQUEST['placesOfVisit']);
				$purpose=mysqli_real_escape_string($mr_con,$_REQUEST['purpose']);
				$remarkss=mysqli_real_escape_string($mr_con,$_REQUEST['remarks']);
				$texp=round(array_sum($_REQUEST['amt'])+array_sum($_REQUEST['amt_l'])+array_sum($_REQUEST['lamt'])+array_sum($_REQUEST['bamt'])+array_sum($_REQUEST['oamt']));
				$reqdate=date("Y-m-d");
				$alias=aliasCheck(generateRandomString(),"ec_expenses","expenses_alias");			
				$fault =array();
				//Start - Local Conveyance
				for($i=0;$i<count($_REQUEST['amt_l']);$i++){
					$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['dot_l'][$i]))));
					$fa[$i]=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mot_l'][$i]));
					$fb[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['from_l'][$i]);
					$fc[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['to_l'][$i]);
					$fd[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['amt_l'][$i]);
					$fe[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['zone_l'][$i]);
					$ff[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state_l'][$i]);
					$fg[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['district_l'][$i]);
					$fh[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['area_l'][$i]);
					$fi[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['bucket'][$i]);
					if($fi[$i] == 0){
						$fj[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['cap'][$i]);
						$fk[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['wofCell'][$i]);
						$fl[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['quantityCell'][$i]);
						$fm[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['numKilometers'][$i]);
					} else {
						$fj[$i]='';
						$fk[$i]='';
						$fl[$i]='';
						$fm[$i]='';
					}	
					$fn[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['dprNum_l'][$i]);
					$fo[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['ticket_idl'][$i]);
					$alias1=aliasCheck(generateRandomString(),"ec_localconveyance","alias");
					if($_REQUEST['zone_l'][$i] != '' && $_REQUEST['state_l'][$i] != '' && $_REQUEST['district_l'][$i] != '' && $_REQUEST['bucket'][$i] !='' && $_REQUEST['dot_l'][$i]!='' && $_REQUEST['mot_l'][$i]!='' && $_REQUEST['from_l'][$i]!='' && $_REQUEST['to_l'][$i]!='' && $_REQUEST['ticket_idl'][$i]!='' && $_REQUEST['dprNum_l'][$i]!='' && $_REQUEST['amt_l'][$i]!='')	{
						$loc_insqry = mysqli_query($mr_con,"INSERT INTO ec_localconveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,zone_alias,state_alias,district_alias,bucket,capacity,quantity,km,dpr_number,ticket_alias,alias,created_date) VALUES('$alias','$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$fe[$i]','$ff[$i]','$fg[$i]','$fi[$i]','$fj[$i]','$fl[$i]','$fm[$i]','$fn[$i]','$fo[$i]','$alias1','$reqdate')");
					}
				}
				//start - Conveyance
				for($i=0;$i<count($_REQUEST['amt']);$i++){
					$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['dot'][$i]))));
					$fa[$i]=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mot'][$i]));
					$fb[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['from'][$i]);
					$fc[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['to'][$i]);
					$fd[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['amt'][$i]);
					$fe[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['cdprno'][$i]);
					$ff[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['cticket_id'][$i]);
					if($_FILES['motbill']['size'][$i]>0){
						$ext = pathinfo($_FILES['motbill']['name'][$i], PATHINFO_EXTENSION);
						$fileName=$empalias.generateRandomString()."TC.".$ext;
						$move=move_uploaded_file($_FILES["motbill"]["tmp_name"][$i],"../../attachments/".$fileName);
						if($move){
							$profileimg = "attachments/".$fileName;
							$alias1=aliasCheck(generateRandomString(),"ec_conveyance","alias");
							if($_REQUEST['dot'][$i] != '' && $_REQUEST['mot'][$i] != '' && $_REQUEST['from'][$i] != '' && $_REQUEST['to'][$i] !='' && $_REQUEST['cticket_id'][$i]!='' && $_REQUEST['cdprno'][$i]!='' && $_FILES['motbill']['name'][$i]!='' && $_REQUEST['amt'][$i]!=''){
								mysqli_query($mr_con,"INSERT INTO ec_conveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,document_link,dpr_number,ticket_alias,created_date) VALUES('$alias','$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$alias1','$profileimg','$fe[$i]','$ff[$i]','$reqdate')");
							}
						}else{
							array_push($fault,$_FILES['motbill']['name'][$i]);
						}
					}
				}
				//End - Conveyance
				//Start - Lodging
				for($i=0;$i<count($_REQUEST['lamt']);$i++){
					$fb[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['typeofstay'][$i]);
					$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkin'][$i]))));
					$fa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkout'][$i]))));
					$fc[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['hotelName'][$i]);
					$fd[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['lamt'][$i]);
					$fe[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['zone_ld'][$i]);
					$ff[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state_ld'][$i]);
					$fg[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['district_ld'][$i]);
					$fh[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['dprNum_ld'][$i]);
					$fi[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['ticket_idld'][$i]);
					$profileimg =0;
					$alias1=aliasCheck(generateRandomString(),"ec_lodging","alias");

					if($_FILES['lfile']['size'][$i]>0){
						$ext = pathinfo($_FILES['lfile']['name'][$i], PATHINFO_EXTENSION);
						$fileName=$empalias.generateRandomString()."TL.".$ext;
						if(move_uploaded_file($_FILES["lfile"]["tmp_name"][$i],"../../attachments/".$fileName)){
							$profileimg = "attachments/".$fileName;
							$alias1=aliasCheck(generateRandomString(),"ec_lodging","alias");
							if($_REQUEST['typeofstay'][$i] != '' && $_REQUEST['checkin'][$i] != ''&& $_REQUEST['checkout'][$i] != '' && $_REQUEST['hotelName'][$i] != '' && $_REQUEST['ticket_idld'][$i]!='' && $_REQUEST['dprNum_ld'][$i]!='' && $_FILES['lfile']['name'][$i] != '' && $_REQUEST['lamt'][$i]!='') {
								$q = "INSERT INTO ec_lodging(check_in, check_out, type_of_stay, hotel_name, amount, expenses_alias, alias, document_link, created_date,  zone_alias, state_alias, district_alias, dpr_number,  ticket_alias) VALUES('$faa[$i]', '$fa[$i]', '$fb[$i]', '$fc[$i]', '$fd[$i]', '$alias', '$alias1', '$profileimg', '$reqdate', '$fe[$i]', '$ff[$i]', '$fg[$i]', '$fh[$i]', '$fi[$i]')";
								$status = mysqli_query($mr_con, $q);
							}
						}else array_push($fault, $_FILES['lfile']['name'][$i]);
					}else{
						$profileimg = '0';
						$alias1=aliasCheck(generateRandomString(),"ec_lodging","alias");

						if($_REQUEST['typeofstay'][$i] != '' && $_REQUEST['checkin'][$i] != ''&& $_REQUEST['checkout'][$i] != '' && $_REQUEST['zone_ld'][$i] != '' && $_REQUEST['state_ld'][$i] != '' && $_REQUEST['district_ld'][$i] != '' && $_REQUEST['ticket_idld'][$i]!='' && $_REQUEST['dprNum_ld'][$i]!='' && $_REQUEST['lamt'][$i]!='') {
							$q = "INSERT INTO ec_lodging(check_in, check_out, type_of_stay, hotel_name, amount, expenses_alias, alias, document_link, created_date, zone_alias, state_alias, district_alias, dpr_number, ticket_alias) VALUES('$faa[$i]', '$fa[$i]', '$fb[$i]', '$fc[$i]', '$fd[$i]', '$alias', '$alias1', '$profileimg', '$reqdate', '$fe[$i]', '$ff[$i]', '$fg[$i]', '$fh[$i]', '$fi[$i]')";
							mysqli_query($mr_con, $q);
						}
					}
				}
				//End - Lodging
				//Start - Boarding
				for($i=0;$i<count($_REQUEST['bamt']);$i++){
					$fa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkinb'][$i]))));
					$fb[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkoutb'][$i]))));
					$fc[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state'][$i]);
					$fd[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['bamt'][$i]);
					$fe[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['zone_bo'][$i]);
					$ff[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state_bo'][$i]);
					$fg[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['district_bo'][$i]);
					$fh[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['dprNum_bo'][$i]);
					$fi[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['ticket_bo'][$i]);
					$alias1=aliasCheck(generateRandomString(),"ec_boarding","alias");
					if($_REQUEST['checkinb'][$i] != '' && $_REQUEST['checkoutb'][$i] != '' && $_REQUEST['zone_bo'][$i] != '' && $_REQUEST['state_bo'][$i] != '' && $_REQUEST['district_bo'][$i] != '' && $_REQUEST['ticket_bo'][$i] != '' && $_REQUEST['dprNum_bo'][$i]!='' && $_REQUEST['bamt'][$i]!=''){
						mysqli_query($mr_con,"INSERT INTO ec_boarding(check_in,check_out,state,amount,zone_alias,state_alias,district_alias,dpr_number,ticket_alias,expenses_alias,alias,created_date) VALUES('$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$fe[$i]','$ff[$i]','$fg[$i]','$fh[$i]','$fi[$i]','$alias','$alias1','$reqdate')");
					}
				}
				//End - Boarding
				//Start - Other expenses
				for($i=0;$i<count($_REQUEST['oamt']);$i++){
					$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['odate'][$i]))));
					$fa[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['others'][$i]);
					$fb[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['oamt'][$i]);
					$fc[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['dprNum_ot'][$i]);
					$fd[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['ticket_ot'][$i]);
					if($_FILES['ofile']['size'][$i]>0){
						$ext2 = pathinfo($_FILES['ofile']['name'][$i], PATHINFO_EXTENSION);
						$fileName=$empalias.generateRandomString()."TO.".$ext2;
						if(move_uploaded_file($_FILES["ofile"]["tmp_name"][$i],"../../attachments/".$fileName)){
							$profileimg = "attachments/".$fileName;
							$alias1=aliasCheck(generateRandomString(),"ec_other_expenses","alias");
							if($_REQUEST['others'][$i] != '' && $_REQUEST['odate'][$i] != '' && $_FILES['ofile']['name'][$i] != '' && $_REQUEST['ticket_ot'][$i] != '' && $_REQUEST['dprNum_ot'][$i]!='' && $_REQUEST['oamt'][$i]!=''){
								mysqli_query($mr_con,"INSERT INTO ec_other_expenses(checked_date, description, amount, expenses_alias, alias, document_link, dpr_number, ticket_alias, created_date) VALUES('$faa[$i]','$fa[$i]','$fb[$i]','$alias','$alias1','$profileimg','$fc[$i]','$fd[$i]','$reqdate')");
							}
						}else{
							array_push($fault,$_FILES['ofile']['name'][$i]);
						}
					}
				}
				//End - Other expenses			
				if(isset($draft) && $draft=="draft"){
					$profileimg =0;
					$sql="INSERT INTO ec_expenses(bill_number,employee_alias,period_of_visit_from,period_of_visit_to,places_of_visit,purpose,total_tour_expenses,requested_date,expenses_alias,approval_level,report) VALUES ('$rquestid','$empalias','$visitFromDate','$visitToDate','$placesOfVisit','$purpose','$texp','$reqdate','$alias',0,'$profileimg')";
					if($mr_con->query($sql)===TRUE){
						$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
						if($remarkss!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$remarkss','BE','$alias','$empalias','$alias_remark')");
						$emcheck=alias($rquestid,'ec_expenses','bill_number','employee_alias');
						if($emcheck=="NA" || $emcheck==""){
							$resCode='0';$resMsg="Your Bill Number ".$rquestid." has been saved, But Will not Reflect in your details, So contact Admin";
							//$url=localURL()."enersys_expense/maillings/failed.php?type=2&ref=".$rquestid;
						}else{
							$action = "Expense request saved in drafts with Bill Number: ".$rquestid."";
							user_history($empalias,$action,$_REQUEST['ip_addr']);
							if(count($fault)!='0'){$resCode='0';$resMsg=" Bill Number: ".$rquestid.", Some Files could not be uploaded.Kinldy Resubmit from Drafts.";}
							else {$resCode='0';$resMsg="Expense Submitted successfully with Bill Number: ".$rquestid.""; }
							$resCode='0';$resMsg="Expense Request Saved with Bill Number: ".$rquestid."";
						}
					}else $res="Expense Drafting Failed";
				}else{
					$profileimg =0;
					if(count($fault)!='0'){$level=0;}
					else{
						$levelx=expenseApprovalLevels($_REQUEST['emp_alias']);
						switch ($levelx){
							case '1': $level=2;break;
							case '2': $level=5;break;
							case '3': $level=5;break;
							case '4': $level=5;break;
							case '5': $level=3;break;
							default : $level=1;break;
						}
					}
					$sql="INSERT INTO ec_expenses(bill_number,employee_alias,period_of_visit_from,period_of_visit_to,places_of_visit,purpose,total_tour_expenses,requested_date,expenses_alias,approval_level,report) VALUES ('$rquestid','$empalias','$visitFromDate','$visitToDate','$placesOfVisit','$purpose','$texp','$reqdate','$alias','$level','$profileimg')";
					if($mr_con->query($sql)===TRUE){
						$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
						if($remarkss!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$remarkss','BE','$alias','$empalias','$alias_remark')");
						$emcheck=alias($rquestid,'ec_expenses','bill_number','employee_alias');
						if($emcheck=="NA" || $emcheck==""){
							$resCode='0';$resMsg="Your Bill Number ".$rquestid." has been Submitted, But Will not Reflect in your details, So contact Admin";
							//$url=localURL()."enersys_expense/maillings/failed.php?type=1&ref=".$rquestid;
						}else{
							if($level==0){
								$action = "Expense request saved in drafts with Bill Number: ".$rquestid."";
								user_history($empalias,$action,$_REQUEST['ip_addr']);
								$resCode='0';$resMsg=" Bill Number: ".$rquestid.", Some Files could not be uploaded, So Your Expense is saved in Drafts.Kinldy Resubmit from Drafts.";}
							else {
								$action = "Expense request submitted with Bill Number: ".$rquestid."";
								user_history($empalias,$action,$_REQUEST['ip_addr']);
								$url=localURL()."enersys_expense/maillings/book_expense.php?ref=".$alias;
								//file_get_contents($url);
								curlxing($url);
								$resCode='0';$resMsg="Expense Submitted successfully with Bill Number: ".$rquestid.""; 
								}
							
						}
					}
					else $res="Expense Request Failed";
				}
			}
		}
	if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);	
}

function ser_expview(){
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$result['employee_name'] = employeeDetails('name',$_REQUEST['emp_alias']);
		$result['dateof_request'] = date('d-M-Y');
		$result['empid'] = employeeDetails('employee_id',$_REQUEST['emp_alias']);
		$result['empdept'] =checkspldep($_REQUEST['emp_alias']);
		$result['grade']=grade($_REQUEST['emp_alias']);
		if (advanceNotSettled($_REQUEST['emp_alias'])!=0) $out_bal=advanceNotSettled($_REQUEST['emp_alias']); else $out_bal="No pending Advances";
		$result['outstanding_bal']=$out_bal;
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);	
}

function others_expences_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	$draft = mysqli_real_escape_string($mr_con,$_REQUEST['ref']);
	$dept = checkspldep($_REQUEST['emp_alias']);
	if($chk==0){
		if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['visitFromDate'])){$res="Select Visit Start Date";}
		else if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['visitToDate'])){$res="Select Visit End Date";}
		//else if($_REQUEST['visitFromDate']>$_REQUEST['visitToDate']){$res="Visit end Date should be greater than or equal to Visit start Date";}
		else if(mysqli_real_escape_string($mr_con,$_REQUEST['placesOfVisit'])==""){$res="Enter Places Of Visit";}
		else if(mysqli_real_escape_string($mr_con,$_REQUEST['purpose'])==""){$res="Enter Purpose";}
		else if(mysqli_real_escape_string($mr_con,$_REQUEST['remarks'])==""){$res="Enter Remarks";}
		else if($_FILES['tplanningreport']['size']<=0 && $dept!= 3){$res="Upload Tour Report";}
		else if($_FILES['tplanningreport']['size']>0 && (pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION)!='pdf' && pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION)!='PDF')){$res="Upload PDF Only";}
		else if($_FILES['tplanningreport']['size']>1153433){$res="File Size Should be less than or equal to 1MB";}
/*		else if((mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_loc'])=="") && (mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_con'])=="") && (mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_lod'])=="") && (mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_bod'])=="") && (mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_oth'])=="")){$res="Enter Atleast One Expense Details";}
		else if(filter_var($_REQUEST['texp'], FILTER_VALIDATE_INT) == false){$res="Enter Atleast One Expense Details";}
*/		else{
			$mess=1;
			$fault=array();
			//Conveyance Validation
			for($i=0;$i<count($_REQUEST['dot']);$i++){
				if($_REQUEST['dot'][$i] == '' && $_REQUEST['mot'][$i] == '' && $_REQUEST['from'][$i] == '' && $_REQUEST['to'][$i] =='' && $_FILES['motbill']['name'][$i]=='' && $_REQUEST['amt'][$i]=='')	{
					$mess=1;
				}else{
					if($_REQUEST['dot'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Select Date of travel";$resMsg=$mess;}
					else if($_REQUEST['mot'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Select Mode of travel";$resMsg=$mess;}
					else if($_REQUEST['from'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Enter From place";$resMsg=$mess;}
					else if($_REQUEST['to'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Enter To place";$resMsg=$mess;}
					/*else if($_FILES['motbill']['name'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Select File";$resMsg=$mess;}*/
					else if($_FILES['motbill']['name'][$i]!='' && $_FILES['motbill']['size'][$i]>5767168){$resCode='4';$mess="Conveyance" .($i+1). ": File Size Should be less than or equal to 5MB ";$resMsg=$mess;}
					else if($_REQUEST['amt'][$i]=='' || $_REQUEST['amt'][$i]=='0'){$resCode='4';$mess="Conveyance" .($i+1). ": Amount Required";$resMsg=$mess;}
					else $mess=1;
				}if($mess!=1){ echo return_false($resMsg); exit;}
			}
			
			if($mess==1){
				//Local Conveyance Validation
				for($i=0;$i<count($_REQUEST['dot_l']);$i++){
					if($_REQUEST['dot_l'][$i]=='' && $_REQUEST['mot_l'][$i]=='' && $_REQUEST['from_l'][$i]=='' && $_REQUEST['to_l'][$i]=='' && $_REQUEST['amt_l'][$i]=='')	{
						$mess=1;
					}else{
						if($_REQUEST['dot_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select Date of travel";$resMsg=$mess;}
						else if($_REQUEST['mot_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select Mode of travel";$resMsg=$mess;}
						else if($_REQUEST['from_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Enter From place";$resMsg=$mess;}
						else if($_REQUEST['to_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Enter To place";$resMsg=$mess;}
						else if($_REQUEST['amt_l'][$i]=='' || $_REQUEST['amt_l'][$i]=='0'){$resCode='4';$mess="Local Conveyance" .($i+1). ": Amount Required";$resMsg=$mess;}
						else $mess=1;
					}if($mess!=1){ echo return_false($resMsg); exit;}
				}
				if($mess==1){
					//Lodging Validation
					for($i=0;$i<count($_REQUEST['typeofstay']);$i++){
						if($_REQUEST['typeofstay'][$i] == '' && $_REQUEST['checkin'][$i] == ''&& $_REQUEST['checkout'][$i] == '' && $_REQUEST['hotelName'][$i] == '' && $_FILES['lfile']['name'][$i] == '' && $_REQUEST['lamt'][$i]=='')	{
							$mess=1;
						}else{
							if($_REQUEST['typeofstay'][$i]==''){$resCode='4';$mess="Lodging" .($i+1). ": Select Type of Stay";$resMsg=$mess;}
							else if($_REQUEST['checkin'][$i]==''){$resCode='4';$mess="Lodging" .($i+1). ": Select Check in Date";$resMsg=$mess;}
							else if($_REQUEST['checkout'][$i]==''){$resCode='4';$mess="Lodging" .($i+1). ": Select Check Out Date";$resMsg=$mess;}
							else if($_REQUEST['hotelName'][$i]==''){$resCode='4';if($_REQUEST['typeofstay'][$i]=='Self'){$mess="Lodging" .($i+1). ": Select State";}else{$mess="Lodging" .($i+1). ": Enter Hotel Name";}$resMsg=$mess;}
							/*else if($_FILES['lfile']['name'][$i]==''){$resCode='4';$mess="Lodging" .($i+1). ": Select File";$resMsg=$mess;}*/
							else if($_FILES['lfile']['name'][$i]!='' && $_FILES['lfile']['size'][$i]>5767168){$resCode='4';$mess="Lodging" .($i+1). ": File Size Should be less than or equal to 5MB ";$resMsg=$mess;}
							else if($_REQUEST['lamt'][$i]=='' || $_REQUEST['lamt'][$i]=='0'){$resCode='4';$mess="Lodging" .($i+1). ": Amount Required";$resMsg=$mess;}
							else $mess=1;
						}if($mess!=1){ echo return_false($resMsg); exit;}
					}
				
				if($mess==1){
					//Boarding Validation
					for($i=0;$i<count($_REQUEST['checkinb']);$i++){
						if($_REQUEST['checkinb'][$i] == '' && $_REQUEST['checkoutb'][$i] == '' && $_REQUEST['state'][$i]=='' && $_REQUEST['bamt'][$i]==''){
							$mess=1;
						}else{
							if($_REQUEST['checkinb'][$i]==''){$resCode='4';$mess="Boarding" .($i+1). ": Visit Start Date";$resMsg=$mess;}
							else if($_REQUEST['checkoutb'][$i]==''){$resCode='4';$mess="Boarding" .($i+1). ": Visit End Date";$resMsg=$mess;}
							//else if($_REQUEST['checkinb'][$i]>$_REQUEST['checkoutb'][$i]){$resCode='4';$mess="Boarding" .($i+1). ": Visit end Date should be greater than or equal to Visit start Date";$resMsg=$mess;}
							else if($_REQUEST['state'][$i]=='') {$resCode='4';$mess="Boarding" .($i+1). ": Select State";$resMsg=$mess;}
							else if($_REQUEST['bamt'][$i]=='' || $_REQUEST['bamt'][$i]=='0'){$resCode='4';$mess="Boarding" .($i+1). ": Amount Required";$resMsg=$mess;}
							else $mess=1;
						}if($mess!=1){ echo return_false($resMsg); exit;}
					}
					
					if($mess==1){
						//Others Validation
						for($i=0;$i<count($_REQUEST['others']);$i++){
							if($_REQUEST['others'][$i] == '' && $_REQUEST['odate'][$i] == '' && $_FILES['ofile']['name'][$i] == '' && $_REQUEST['oamt'][$i]==''){
								$mess=1;
							}else{
								if($_REQUEST['others'][$i]==''){$resCode='4';$mess="Others" .($i+1). ": Enter Description";$resMsg=$mess;}
								else if($_REQUEST['odate'][$i]==''){$resCode='4';$mess="Others" .($i+1). ": Select Date";$resMsg=$mess;}
								/*else if($_FILES['ofile']['name'][$i]=='') {$resCode='4';$mess="Others" .($i+1). ": Select File";$resMsg=$mess;}*/
								else if($_FILES['ofile']['name'][$i]!='' && $_FILES['ofile']['size'][$i]>5767168){$resCode='4';$mess="Others" .($i+1). ": File Size Should be less than or equal to 5MB ";$resMsg=$mess;}
								else if($_REQUEST['oamt'][$i]=='' || $_REQUEST['oamt'][$i]=='0'){$resCode='4';$mess="Others" .($i+1). ": Amount Required";$resMsg=$mess;}
								else $mess=1;
							}if($mess!=1){ echo return_false($resMsg); exit;}
						}
					}
				}
				}
			}
			
			if($mess==1){
				if((mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_loc'])=="") && (mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_con'])=="") && (mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_lod'])=="") && (mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_bod'])=="") && (mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_oth'])=="")){$res=$mess="Enter Atleast One Expense Details";}
			}
			if($mess==1){
				if((mysqli_real_escape_string($mr_con,$_REQUEST['texp'])=="") || (mysqli_real_escape_string($mr_con,$_REQUEST['texp'])=="0")){$res=$mess="Total Expense should not be empty or zero.Please Enter Atleast One Expense Details";}
			}
			if($mess==1){
				$rquestid="#".checkint(mt_rand(1000,999999999),'ec_expenses','bill_number');
				$empalias=$_REQUEST['emp_alias'];
				$visitFromDate=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['visitFromDate']))));
				$visitToDate=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['visitToDate']))));
				$placesOfVisit=mysqli_real_escape_string($mr_con,trim($_REQUEST['placesOfVisit']));
				$purpose=mysqli_real_escape_string($mr_con,trim($_REQUEST['purpose']));
				$remarkss=mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks']));
				$texp=round(array_sum($_REQUEST['amt'])+array_sum($_REQUEST['amt_l'])+array_sum($_REQUEST['lamt'])+array_sum($_REQUEST['bamt'])+array_sum($_REQUEST['oamt']));
				$reqdate=date("Y-m-d");
				$alias=aliasCheck(generateRandomString(),"ec_expenses","expenses_alias");
				$fault =array();
				//start - Conveyance
				for($i=0;$i<count($_REQUEST['amt']);$i++){
					$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['dot'][$i]))));
					$fa[$i]=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mot'][$i]));
					$fb[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['from'][$i]);
					$fc[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['to'][$i]);
					$fd[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['amt'][$i]);
					if($_FILES['motbill']['size'][$i]>0){
						$ext = pathinfo($_FILES['motbill']['name'][$i], PATHINFO_EXTENSION);
						$fileName=$empalias.generateRandomString()."TC.".$ext;
						if(move_uploaded_file($_FILES["motbill"]["tmp_name"][$i],"../../attachments/".$fileName)){
							$profileimg = "attachments/".$fileName;
							$alias1=aliasCheck(generateRandomString(),"ec_conveyance","alias");
							if($_REQUEST['dot'][$i] != '' && $_REQUEST['mot'][$i] != '' && $_REQUEST['from'][$i] != '' && $_REQUEST['to'][$i] !='' && $_FILES['motbill']['name'][$i]!='' && $_REQUEST['amt'][$i]!='')	{
							mysqli_query($mr_con,"INSERT INTO ec_conveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,document_link,created_date) VALUES('$alias','$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$alias1','$profileimg','$reqdate')");
							}
						}else array_push($fault,$_FILES['motbill']['name'][$i]);
					}else{
							$profileimg = '0';
							$alias1=aliasCheck(generateRandomString(),"ec_conveyance","alias");
							if($_REQUEST['dot'][$i] != '' && $_REQUEST['mot'][$i] != '' && $_REQUEST['from'][$i] != '' && $_REQUEST['to'][$i] !='' && $_REQUEST['amt'][$i]!='')	{
							mysqli_query($mr_con,"INSERT INTO ec_conveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,document_link,created_date) VALUES('$alias','$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$alias1','$profileimg','$reqdate')");
							}
					}
				}
				
				//End - Conveyance
				//start -  Local Conveyance	
				for($i=0;$i<count($_REQUEST['amt_l']);$i++){
					$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['dot_l'][$i]))));
					$fa[$i]=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mot_l'][$i]));
					$fb[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['from_l'][$i]);
					$fc[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['to_l'][$i]);
					$fd[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['amt_l'][$i]);
					$alias1=aliasCheck(generateRandomString(),"ec_localconveyance","alias");
					if($_REQUEST['dot_l'][$i]!='' && $_REQUEST['mot_l'][$i]!='' && $_REQUEST['from_l'][$i]!='' && $_REQUEST['to_l'][$i]!='' && $_REQUEST['amt_l'][$i]!='')	{
					mysqli_query($mr_con,"INSERT INTO ec_localconveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,created_date) VALUES('$alias','$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$alias1','$reqdate')");
					}
				}
				//End - Local Conveyance
				//Start - Lodging
				for($i=0;$i<count($_REQUEST['lamt']);$i++){
					$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkin'][$i]))));
					$fa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkout'][$i]))));
					$fb[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['typeofstay'][$i]);
					$fc[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['hotelName'][$i]);
					$fd[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['lamt'][$i]);
					
					if($_FILES['lfile']['size'][$i]>0){
						$ext = pathinfo($_FILES['lfile']['name'][$i], PATHINFO_EXTENSION);
						$fileName=$empalias.generateRandomString()."TL.".$ext;
						if(move_uploaded_file($_FILES["lfile"]["tmp_name"][$i],"../../attachments/".$fileName)){
							$profileimg = "attachments/".$fileName;
							$alias1=aliasCheck(generateRandomString(),"ec_lodging","alias");
						if($_REQUEST['typeofstay'][$i] != '' && $_REQUEST['checkin'][$i] != ''&& $_REQUEST['checkout'][$i] != '' && $_REQUEST['hotelName'][$i] != '' && $_FILES['lfile']['name'][$i] != '' && $_REQUEST['lamt'][$i]!='')	{
							mysqli_query($mr_con,"INSERT INTO ec_lodging(check_in,check_out,type_of_stay,hotel_name,amount,expenses_alias,alias,document_link,created_date) VALUES('$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$alias','$alias1','$profileimg','$reqdate')");
						}
						}else array_push($fault,$_FILES['lfile']['name'][$i]);
					}else{
						$profileimg = '0';
						$alias1=aliasCheck(generateRandomString(),"ec_lodging","alias");
						if($_REQUEST['typeofstay'][$i] != '' && $_REQUEST['checkin'][$i] != ''&& $_REQUEST['checkout'][$i] != '' && $_REQUEST['hotelName'][$i] != '' && $_REQUEST['lamt'][$i]!='')	{
							mysqli_query($mr_con,"INSERT INTO ec_lodging(check_in,check_out,type_of_stay,hotel_name,amount,expenses_alias,alias,document_link,created_date) VALUES('$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$alias','$alias1','$profileimg','$reqdate')");
						}
					}
				}
				//End - Lodging
				//Start - Boarding
				for($i=0;$i<count($_REQUEST['bamt']);$i++){
					$fa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkinb'][$i]))));
					$fb[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkoutb'][$i]))));
					$fc[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state'][$i]);
					$fd[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['bamt'][$i]);
					$alias1=aliasCheck(generateRandomString(),"ec_boarding","alias");
					if($_REQUEST['checkinb'][$i] != '' && $_REQUEST['checkoutb'][$i] != '' && $_REQUEST['state'][$i]!='' && $_REQUEST['bamt'][$i]!=''){
					mysqli_query($mr_con,"INSERT INTO ec_boarding(check_in,check_out,state,amount,expenses_alias,alias,created_date) VALUES('$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$alias','$alias1','$reqdate')");
					}
				}
				//End - Boarding
				//Start - Other expenses
				for($i=0;$i<count($_REQUEST['oamt']);$i++){
					$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['odate'][$i]))));
					$fa[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['others'][$i]);
					$fb[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['oamt'][$i]);
					if($_FILES['ofile']['size'][$i]>0){
						$ext2 = pathinfo($_FILES['ofile']['name'][$i], PATHINFO_EXTENSION);
						$fileName=$empalias.generateRandomString()."TO.".$ext2;
						if(move_uploaded_file($_FILES["ofile"]["tmp_name"][$i],"../../attachments/".$fileName)){
							$profileimg = "attachments/".$fileName;
							$alias1=aliasCheck(generateRandomString(),"ec_other_expenses","alias");
							if($_REQUEST['others'][$i] != '' && $_REQUEST['odate'][$i] != '' && $_FILES['ofile']['name'][$i]!= '' && $_REQUEST['oamt'][$i]!=''){
							mysqli_query($mr_con,"INSERT INTO ec_other_expenses(checked_date, description, amount, expenses_alias, alias, document_link, created_date) VALUES('$faa[$i]','$fa[$i]','$fb[$i]','$alias','$alias1','$profileimg','$reqdate')");
							}
						}else array_push($fault,$_FILES['ofile']['name'][$i]);
					}else{
						$profileimg = '0';
						$alias1=aliasCheck(generateRandomString(),"ec_other_expenses","alias");
						if($_REQUEST['others'][$i] != '' && $_REQUEST['odate'][$i] != '' && $_REQUEST['oamt'][$i]!=''){
						mysqli_query($mr_con,"INSERT INTO ec_other_expenses(checked_date, description, amount, expenses_alias, alias, document_link, created_date) VALUES('$faa[$i]','$fa[$i]','$fb[$i]','$alias','$alias1','$profileimg','$reqdate')");
						}
					}
				}
				//End - Other expenses			
					if(isset($draft) && $draft=="draft"){
						if($_FILES['tplanningreport']['size']>0){
							$ext = pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION);
							$fileName=$empalias.generateRandomString()."EXP.".$ext;
							if(move_uploaded_file($_FILES["tplanningreport"]["tmp_name"],"../../attachments/tourReport/".$fileName))
							$profileimg = "attachments/tourReport/".$fileName;else $profileimg = "0";
						}else $profileimg ="0";
						$sql="INSERT INTO ec_expenses(bill_number,employee_alias,period_of_visit_from,period_of_visit_to,places_of_visit,purpose,total_tour_expenses,requested_date,expenses_alias,approval_level,report) VALUES ('$rquestid','$empalias','$visitFromDate','$visitToDate','$placesOfVisit','$purpose','$texp','$reqdate','$alias',0,'$profileimg')";
						if($mr_con->query($sql)===TRUE){
							$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
							if($remarkss!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$remarkss','BE','$alias','$empalias','$alias_remark')");
							$emcheck=alias($rquestid,'ec_expenses','bill_number','employee_alias');
							if($emcheck=="NA" || $emcheck==""){
								$resCode='0';$resMsg="Your Bill Number ".$rquestid." has been saved, But Will not Reflect in your details, So contact Admin";
								//$url=localURL()."enersys_expense/maillings/failed.php?type=2&ref=".$rquestid;
							}else{
								$action = "Expense request saved in drafts with Bill Number: ".$rquestid."";
								user_history($empalias,$action,$_REQUEST['ip_addr']);
								if(count($fault)!='0'){$resCode='0';$resMsg=" Bill Number: ".$rquestid.", Some Files could not be uploaded.Kinldy Resubmit from Drafts.";}
								else {$resCode='0';$resMsg="Expense Request Saved with Bill Number: ".$rquestid.""; }
							}
						}else $res="Expense Drafting Failed";
					}else{
						if($_FILES['tplanningreport']['size']>0){
							$ext = pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION);
							$fileName=$empalias.generateRandomString()."EXP.".$ext;
							if(move_uploaded_file($_FILES["tplanningreport"]["tmp_name"],"../../attachments/tourReport/".$fileName))
							$profileimg = "attachments/tourReport/".$fileName;else $profileimg = "0";
						}else $profileimg ="0";
						if(count($fault)!='0'){$level=0;}
						else{
							$levelx=expenseApprovalLevels($_REQUEST['emp_alias']);
							switch ($levelx){
								case '1': $level=2;break;
								case '2': $level=5;break;
								case '3': $level=5;break;
								case '4': $level=5;break;
								case '5': $level=3;break;
								default : $level=1;break;
							}
						}
						$sql="INSERT INTO ec_expenses(bill_number,employee_alias,period_of_visit_from,period_of_visit_to,places_of_visit,purpose,total_tour_expenses,requested_date,expenses_alias,approval_level,report) VALUES ('$rquestid','$empalias','$visitFromDate','$visitToDate','$placesOfVisit','$purpose','$texp','$reqdate','$alias','$level','$profileimg')";
						if($mr_con->query($sql)===TRUE){
							$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
							if($remarkss!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$remarkss','BE','$alias','$empalias','$alias_remark')");
							$emcheck=alias($rquestid,'ec_expenses','bill_number','employee_alias');
							if($emcheck=="NA" || $emcheck==""){
								$resCode='0';$resMsg="Your Bill Number ".$rquestid." has been Submitted, But Will not Reflect in your details, So contact Admin";
								//$url=localURL()."enersys_expense/maillings/failed.php?type=1&ref=".$rquestid;
							}else{
								$url=localURL()."enersys_expense/maillings/book_expense.php?ref=".$alias;
								curlxing($url);
								//$fg=file_get_contents($url);								
									if($level==0){
										$action = "Expense request saved in drafts with Bill Number: ".$rquestid."";
										user_history($empalias,$action,$_REQUEST['ip_addr']);
										$resCode='0';$resMsg=" Bill Number: ".$rquestid.", Some Files could not be uploaded, So Your Expense is saved in Drafts.Kinldy Resubmit from Drafts.";}
									else {
										$action = "Expense request submitted with Bill Number: ".$rquestid."";
										user_history($empalias,$action,$_REQUEST['ip_addr']);
										$resCode='0';$resMsg="Expense Submitted successfully with Bill Number: ".$rquestid.""; }
							}
						}
						else $res="Expense Request Failed";
					}
			}
		}
	if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);	
}
function lod_bod_amt(){
	global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk=='0'){
		if(isset($_REQUEST['locding'])){$lb_amt=selflodgingamount($_REQUEST['locding'],$_REQUEST['emp_alias'],$_REQUEST['cindate'],$_REQUEST['coutdate']);$result['lb_amt']=trim($lb_amt);}
		else if(isset($_REQUEST['bodding'])){$lb_amt= bordaingamount($_REQUEST['bodding'],$_REQUEST['emp_alias'],$_REQUEST['cindate'],$_REQUEST['coutdate']);$result['lb_amt']=trim($lb_amt);}
		else{$result['lb_amt']=0;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);	
}
function cap_weight(){	global $mr_con;
	$sel_product = $_REQUEST['capalias'];
	$rec=$mr_con->query("SELECT weight FROM ec_product WHERE flag=0 AND product_alias = '$sel_product'");
	$row =$rec->fetch_assoc();
	$result['product_weight'] = $row['weight'];
	echo json_encode($result);	
}
function ajaxAmount(){	
	global $mr_con;
	$bucket = $_REQUEST['bucket'];
	$zone = $_REQUEST['zonesel'];
	$state = $_REQUEST['statesel'];
	$district = $_REQUEST['dissel'];
	$capacity = $_REQUEST['capChange'];
	// $weight = $_REQUEST['weight'];
	$qnty = $_REQUEST['qnty'];
	$km = $_REQUEST['km'];
	//$appli = $_REQUEST['appli'];
	
	if($capacity!=''){
		$rec=$mr_con->query("SELECT weight FROM ec_product WHERE flag=0 AND product_alias = '$capacity'");
		$row =$rec->fetch_assoc();
		$weight = $row['weight'];
	}

	if($district!=''){
		$appli_sql=$mr_con->query("SELECT area FROM ec_district WHERE flag=0 AND district_alias = '$district'");
		$appli_rs =$appli_sql->fetch_assoc();
		$appli_area = $appli_rs['area'];
		if($appli_area == '0'){
			$appli = '0.02';
		}else if($appli_area == '1'){
			$appli = '0.04';
		}else{
			$appli = '0';
		}
	}
	$ref = $_REQUEST['ref'];
	$diff=1;
	if($zone != '' && $state != '' && $district!= ''){
		$get = ($ref=='lc' ? 'local_conveyance' : ($ref=='ld' ? 'lodging_amount' : 'daily_allowance'));
		$get_LC = mysqli_query($mr_con,"select $get from ec_service_allowances where zone_alias='".$zone."' AND state_alias='".$state."' AND district_alias='".$district."' AND flag='0'");
		if(mysqli_num_rows($get_LC) > 0) {
			$row=mysqli_fetch_array($get_LC);
			$lc = $row[$get];
		} else {
			$lc = '0';
		}
		if($lc != '0'){
			if($ref=='ld' || $ref=='bd'){
				if($_REQUEST['fda'] != '' && $_REQUEST['eda'] != ''){
					$firstday = dateFormat($_REQUEST['fda'],'y');
					$secondday = dateFormat($_REQUEST['eda'],'y');
					if($firstday != 'NA' && $secondday!= 'NA'){
						$date1 = new DateTime($_REQUEST['fda']);
						$date2 = new DateTime($_REQUEST['eda']);
						if($ref=='bd')
						$diff = ($date2->diff($date1)->format("%a"))+1;
						else
						$diff = ($date2->diff($date1)->format("%a"));
						$rec = $lc*$diff;

						$role = alias($_REQUEST['emp_alias'], 'ec_employee_master', 'employee_alias', 'role_alias');
						if ($role == "QV9IPNVA1M" && $ref=='ld') {
							$rec = $rec / 2;
						}
					}else{$rec = '';}
				}else {
					$rec = '';
				}
			}else{ 
				if($bucket == '1'){ $rec = $lc; }
				else if($bucket == '0'){ 
					if(isset($weight) && $weight!='' && $weight!== 'undefined' && isset($qnty) && $qnty!='' && $qnty!== 'undefined' && isset($km) && $km !='' && $km!== 'undefined'){
					$half_lc = $lc/2;
					$rec = ($weight*$qnty*$km*$appli)+$half_lc;
					}else $rec = 0;
				}else{$rec = 0;}
			}
		} else { $rec = 0; }
	}else{$rec = 0;}
	//echo $rec;exit;
	$result['ajaxAmt'] = $rec;
	echo json_encode($result);	
}

function others_expences_edit(){
	global $mr_con;
	if(isset($_REQUEST['password'])) {
		$chk = 0;
	} else {
		$chk = authentication($_REQUEST['emp_alias'], $_REQUEST['token']);
	}
	$draft = mysqli_real_escape_string($mr_con,$_REQUEST['ref']);
	ob_start();
	if($chk==0){
		//Draft
		if(isset($draft) && $draft=="request"){			
			if($_REQUEST['ref2']=='1'){
					$empalias=$_REQUEST['emp_alias'];
					$alias=$_REQUEST['id'];
					$reasonForAdv=mysqli_real_escape_string($mr_con,trim($_REQUEST['reasonForAdv']));
					if($reasonForAdv==""){$res="Enter Remarks";}else{
					$reqdate=date("Y-m-d");
					$sql="UPDATE ec_expenses SET last_updated = now() , approval_level='3',approved_by='$empalias',approved_date='$reqdate' WHERE expenses_alias='$alias'";
					if($mr_con->query($sql)===TRUE) {
					$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
					if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
						$action = "Expense approved with Bill Number: ".ebill($alias)."";
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$url=localURL()."enersys_expense/maillings/book_expense.php?ref=".$alias;
					//file_get_contents($url);
					curlxing($url);
					$resCode='0';$resMsg="Approved successfully"; 
					}else $res="Approval Failed";
					}
			}
			if($_REQUEST['ref2']=='2'){
					$empalias=$_REQUEST['emp_alias'];
					$alias=$_REQUEST['id'];
					$reasonForAdv=mysqli_real_escape_string($mr_con,trim($_REQUEST['reasonForAdv']));
					if($reasonForAdv==""){$res="Enter Remarks";}else{
					$reqdate=date("Y-m-d");
					$approved_by=expensedetlimited('approved_by',$alias)."|".$empalias;
					$approved_date=expensedetlimited('approved_date',$alias)."|".$reqdate;
					$sql="UPDATE ec_expenses SET last_updated = now() , approval_level='3',approved_by='$approved_by',approved_date='$approved_date' WHERE expenses_alias='$alias'";
					if($mr_con->query($sql)===TRUE) {
						$action = "Expense approved with Bill Number: ".ebill($alias)."";
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
						$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
						if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
						$url=localURL()."enersys_expense/maillings/book_expense.php?ref=".$alias;
						//file_get_contents($url);
						curlxing($url);
						$resCode='0';$resMsg="Approved successfully"; }else $res="Approval Failed";					
					}
			}
			if($_REQUEST['ref2']=='3'){
					$empalias=$_REQUEST['emp_alias'];
					$alias=$_REQUEST['id'];
					$reasonForAdv=mysqli_real_escape_string($mr_con,trim($_REQUEST['reasonForAdv']));
					// $po_gnr=mysqli_real_escape_string($mr_con,trim($_REQUEST['po_gnr']));
					$po_gnr="";
					if($reasonForAdv==""){$res="Enter Remarks";}
					// else if($po_gnr=="" || !is_numeric($po_gnr)){$res="Enter Valid PO/GNR Number";}
					else{
					$reqdate=date("Y-m-d");
					$approved_by=expensedetlimited('approved_by',$alias)."|".$empalias;
					$approved_date=expensedetlimited('approved_date',$alias)."|".$reqdate;
					$sql="UPDATE ec_expenses SET last_updated = now() , approval_level='4',po_gnr='$po_gnr',approved_by='$approved_by',approved_date='$approved_date' WHERE expenses_alias='$alias'";
					if($mr_con->query($sql)===TRUE) {
						$action = "Expense approved with Bill Number: ".ebill($alias)."";
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
						$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
						if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
						$url=localURL()."enersys_expense/maillings/book_expense.php?ref=".$alias;
						//file_get_contents($url);
						curlxing($url);
						$resCode='0';$resMsg="Approved successfully";
						} else $res="Approval Failed";					
					}
			}
			if($_REQUEST['ref2']=='4'){
					$empalias=$_REQUEST['emp_alias'];
					$alias=$_REQUEST['id'];
					$rem_amt=mysqli_real_escape_string($mr_con,trim($_REQUEST['rem_amt']));
					$ref_amt=mysqli_real_escape_string($mr_con,trim($_REQUEST['ref_amt']));
					if(!$ref_amt || empty($ref_amt)) {
						$ref_amt = 0;
					}
					$reasonForAdv=mysqli_real_escape_string($mr_con,trim($_REQUEST['reasonForAdv']));
					if($reasonForAdv==""){$res="Enter Remarks";}
					else if($rem_amt=="" || !is_numeric($rem_amt)){$res="Enter Valid Reimbursement";}
					else if($ref_amt!="" && !is_numeric($ref_amt)){$res="Enter Valid Refund";}
					else{
					$reqdate=date("Y-m-d");
					$approved_by=expensedetlimited('approved_by',$alias)."|".$empalias;
					$approved_date=expensedetlimited('approved_date',$alias)."|".$reqdate;
					$sql="UPDATE ec_expenses SET last_updated = now() , approval_level='6',approved_by='$approved_by',approved_date='$approved_date',reimbursement_amount='$rem_amt',refund_amount='$ref_amt' WHERE expenses_alias='$alias'";
					if($mr_con->query($sql)===TRUE){
						$action = "Expense approved with Bill Number: ".ebill($alias)."";
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
						$expense=alias($alias,'ec_expenses','expenses_alias','total_tour_expenses');
						$expense_emp_alias=alias($alias,'ec_expenses','expenses_alias','employee_alias');
						$rec=$mr_con->query("SELECT total_amount,advance_alias FROM ec_advances WHERE employee_alias='$expense_emp_alias' AND  approval_level='6' AND total_amount <>'0' AND flag=0 ORDER BY requested_date");
						if($rec->num_rows>0){$axs=0;
							while($row = $rec->fetch_assoc()){
								$advances[$axs]=$row['advance_alias'];
								$adv_amt[$axs]=$row['total_amount'];
							$axs++;}
							for($x=0;$x<count($advances);$x++){
								if($expense>'0'){
									if($adv_amt[$x]<'0'){
										$expense=$expense-$adv_amt[$x];
										$adv_amt[$x]=0;
										$query_advances="UPDATE ec_advances SET last_updated = now() , total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
									}
									else if(($adv_amt[$x]-$expense) >'0'){
										$expense1=$expense;
										$expense=$expense-$adv_amt[$x];
										$adv_amt[$x]=$adv_amt[$x]-$expense1;
										$query_advances="UPDATE ec_advances SET last_updated = now() , total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
									}
									else if(($adv_amt[$x]-$expense) =='0'){
										$expense=$expense-$adv_amt[$x];
										$adv_amt[$x]=0;
										$query_advances="UPDATE ec_advances SET last_updated = now() , total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
									}
									else{
										$expense1=$expense;
										$expense=$expense1-$adv_amt[$x];
										//$adv_amt[$x]=$adv_amt[$x]-$expense1;
										$adv_amt[$x]=0;
										$query_advances="UPDATE ec_advances SET last_updated = now() , total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
									}
									$mr_con->query($query_advances);
								}
							}
							/*if($expense>'0'){
								$x=count($advances)-1;
								$adv_amt[$x]=0-$expense;
								$query_advances="UPDATE ec_advances SET last_updated = now() , total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
								$mr_con->query($query_advances);
							}*/
						}else $asz=0;	
						
						$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
						if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
						$url=localURL()."enersys_expense/maillings/book_expense.php?ref=".$alias;
						//file_get_contents($url);
						curlxing($url);
						$resCode='0';$resMsg="Approved successfully";
					}else $res="Approval Failed";
					
					}
			}
			if($_REQUEST['ref2']=='5'){
				$empalias=$_REQUEST['emp_alias'];
				$alias=$_REQUEST['id'];
				$reasonForAdv=mysqli_real_escape_string($mr_con,trim($_REQUEST['reasonForAdv']));
				if($reasonForAdv=="") {
					$res="Enter Remarks";
				} else {
					$reqdate=date("Y-m-d");
					$approved_by=expensedetlimited('approved_by',$alias)."|".$empalias;
					$approved_date=expensedetlimited('approved_date',$alias)."|".$reqdate;
					$sql="UPDATE ec_expenses SET last_updated = now() , approval_level='3',approved_by='$approved_by',approved_date='$approved_date' WHERE expenses_alias='$alias'";
					$rs = $mr_con->query($sql);
					if($rs===TRUE) {
						$action = "Expense approved with Bill Number: ".ebill($alias)."";
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
						$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
						if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
						$url=localURL()."enersys_expense/maillings/book_expense.php?ref=".$alias;
						//file_get_contents($url);
						curlxing($url);
						$resCode='0';$resMsg="Approved successfully";
					} else $res="Approval Failed ";
				}
			}
			if($_REQUEST['ref2']=='6'){
					$empalias=$_REQUEST['emp_alias'];
					$alias=$_REQUEST['id'];
					$reasonForAdv=mysqli_real_escape_string($mr_con,trim($_REQUEST['reasonForAdv']));
					$utr_num=mysqli_real_escape_string($mr_con,trim($_REQUEST['utr_num']));
					if($reasonForAdv==""){$res="Enter Remarks";}else if($utr_num==""){$res="Enter UTR Number";}else{
					$reqdate=date("Y-m-d");
					$sql="UPDATE ec_expenses SET last_updated = now() , utr_num='$utr_num' WHERE expenses_alias='$alias'";
					if($mr_con->query($sql)===TRUE) {
						$action = "Added UTR number for expense : ".ebill($alias)."";
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
						$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
						if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
						$resCode='0';$resMsg="Updated successfully";} else $res="Update Failed";
					}
			}
		} else {
				$empalias=$_REQUEST['emp_alias'];
				$alias=$_REQUEST['id'];
				$reasonForAdv=mysqli_real_escape_string($mr_con,trim($_REQUEST['reasonForAdv']));
				if($reasonForAdv==""){$res="Enter Remarks";}else{
				$reqdate=date("Y-m-d");
				$limit =8;
				$s1=mysqli_query($mr_con,"SELECT approval_level FROM ec_expenses WHERE expenses_alias='$alias'");
				$getl = mysqli_fetch_array($s1);
				$get_prev_level = $getl['approval_level'];
				$sql="UPDATE ec_expenses SET last_updated = now() , approval_level='$limit' WHERE expenses_alias='$alias'";
				if($mr_con->query($sql)===TRUE) {
					$action = "Expense rejected with Bill Number : ".ebill($alias)."";
					user_history($_REQUEST['emp_alias'],$action,$ip_addr);
					$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
					if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
					$alias_reject=aliasCheck(generateRandomString(),"ec_rejected_levels","rejected_alias");
					$mr_con->query("INSERT INTO ec_rejected_levels(rejected_level,rejected_by,remark_alias,item_alias,rejected_alias) VALUES ('$get_prev_level','$empalias','$alias_remark','$alias','$alias_reject')");
					$url=localURL()."enersys_expense/maillings/book_expense.php?ref=".$alias;
					//file_get_contents($url);	
					curlxing($url);						
					$resCode='0';$resMsg="Rejected successfully"; 
				}else $res="Request Failed";
				//asyncInclude($url);
				}
			}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	ob_end_clean();
	echo json_encode($result);
}
function adv_expences_edit(){
	global $mr_con;
	$chk = authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	$draft = mysqli_real_escape_string($mr_con,$_REQUEST['ref']);
	if($chk==0) {
		$empalias = $_REQUEST['emp_alias'];
		$alias = $_REQUEST['id'];
		$reasonForAdv=mysqli_real_escape_string($mr_con,trim($_REQUEST['reasonForAdv']));
		if($reasonForAdv==""){
			$res="Enter Remarks";
		} else {
			$reqdate = date("Y-m-d");
			$limit = 8;
			$s1 = mysqli_query($mr_con,"SELECT approval_level FROM ec_expenses WHERE expenses_alias='$alias'");
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif ($chk=='1'){
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function service_expences_edit(){global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	$draft = mysqli_real_escape_string($mr_con,$_REQUEST['ref']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	if($chk=='0'){
		 if(isset($draft) && $draft=="request"){
			if($_REQUEST['ref2']=='1'){
					$empalias=$_REQUEST['emp_alias'];
					$alias=$_REQUEST['id'];
					$reasonForAdv=mysqli_real_escape_string($mr_con,trim($_REQUEST['reasonForAdv']));
					if($reasonForAdv==""){$res="Enter Remarks";}else{
						$reqdate=date("Y-m-d");
						$sql="UPDATE ec_expenses SET last_updated = now() , approval_level='3',approved_by='$empalias',approved_date='$reqdate' WHERE expenses_alias='$alias'";
						if($mr_con->query($sql)===TRUE){ 
						$action = "Expense approved with Bill Number: ".ebill($alias)."";
						user_history($_REQUEST['emp_alias'],$action,$ip_addr);
						$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
						if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
						$url=localURL()."enersys_expense/maillings/book_expense.php?ref=".$alias;
						//file_get_contents($url);
						curlxing($url);
						$resCode='0'; $resMsg="Approved successfully";} else $res="Approval Failed";
						
					}
			}
			if($_REQUEST['ref2']=='2'){
					$empalias=$_REQUEST['emp_alias'];
					$alias=$_REQUEST['id'];
					$reasonForAdv=mysqli_real_escape_string($mr_con,trim($_REQUEST['reasonForAdv']));
					if($reasonForAdv==""){$res="Enter Remarks";}else{
						$reqdate=date("Y-m-d");
						//$po_gnr=$_REQUEST['po_gnr'];
						$approved_by=expensedetlimited('approved_by',$alias)."|".$empalias;
						$approved_date=expensedetlimited('approved_date',$alias)."|".$reqdate;
						$sql="UPDATE ec_expenses SET last_updated = now() , approval_level='3',approved_by='$approved_by',approved_date='$approved_date' WHERE expenses_alias='$alias'";
						if($mr_con->query($sql)===TRUE) {
							$action = "Expense approved with Bill Number: ".ebill($alias)."";
							user_history($_REQUEST['emp_alias'],$action,$ip_addr);
							$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
							if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
							$url=localURL()."enersys_expense/maillings/book_expense.php?ref=".$alias;
							//file_get_contents($url);
							curlxing($url);
							$resCode='0'; $resMsg="Approved successfully";} else $res="Approval Failed";
						
					}
				}
			if($_REQUEST['ref2']=='3'){
					$empalias=$_REQUEST['emp_alias'];
					$alias=$_REQUEST['id'];
					$reasonForAdv=mysqli_real_escape_string($mr_con,trim($_REQUEST['reasonForAdv']));
					$po_gnr=trim($_REQUEST['po_gnr']);
					if($reasonForAdv==""){$res="Enter Remarks";}
					//else if($po_gnr==""){$res="Enter PO/GNR Number";}
					else{
						 $reqdate=date("Y-m-d");
						$approved_by=expensedetlimited('approved_by',$alias)."|".$empalias;
						$approved_date=expensedetlimited('approved_date',$alias)."|".$reqdate;
						$sql="UPDATE ec_expenses SET last_updated = now() , approval_level='4',po_gnr='$po_gnr',approved_by='$approved_by',approved_date='$approved_date' WHERE expenses_alias='$alias'";
						if($mr_con->query($sql)===TRUE){ 
						$action = "Expense approved with Bill Number: ".ebill($alias)."";
						user_history($_REQUEST['emp_alias'],$action,$ip_addr);						$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
						if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
						$url=localURL()."enersys_expense/maillings/book_expense.php?ref=".$alias;
						//file_get_contents($url);
						curlxing($url);
						$resCode='0'; $resMsg="Approved successfully";} else $res="Approval Failed";
						
					}
			}
			if($_REQUEST['ref2']=='4'){
					$empalias=$_REQUEST['emp_alias'];
					$alias=$_REQUEST['id'];
					$rem_amt=mysqli_real_escape_string($mr_con,trim($_REQUEST['rem_amt']));
					$ref_amt=mysqli_real_escape_string($mr_con,trim($_REQUEST['ref_amt']));
					$reasonForAdv=mysqli_real_escape_string($mr_con,trim($_REQUEST['reasonForAdv']));
					if($reasonForAdv==""){$res="Enter Remarks";}
					else if($rem_amt==""){$res="Enter Reimbursement";}
					//else if($ref_amt==""){$res="Enter Refund";}
					else{
					$reqdate=date("Y-m-d");
					$approved_by=expensedetlimited('approved_by',$alias)."|".$empalias;
					$approved_date=expensedetlimited('approved_date',$alias)."|".$reqdate;
					$sql="UPDATE ec_expenses SET last_updated = now() , approval_level='6',approved_by='$approved_by',approved_date='$approved_date',reimbursement_amount='$rem_amt',refund_amount='$ref_amt' WHERE expenses_alias='$alias'";
					if($mr_con->query($sql)===TRUE){
						$action = "Expense approved with Bill Number: ".ebill($alias)."";
						user_history($_REQUEST['emp_alias'],$action,$ip_addr);
						$expense=alias($alias,'ec_expenses','expenses_alias','total_tour_expenses');
						$expense_emp_alias=alias($alias,'ec_expenses','expenses_alias','employee_alias');
						$rec=$mr_con->query("SELECT total_amount,advance_alias FROM ec_advances WHERE employee_alias='$expense_emp_alias' AND  approval_level='6' AND total_amount <>'0' AND flag=0 ORDER BY requested_date");
						if($rec->num_rows>0){$axs=0;
							while($row = $rec->fetch_assoc()){
								$advances[$axs]=$row['advance_alias'];
								$adv_amt[$axs]=$row['total_amount'];
							$axs++;}
							for($x=0;$x<count($advances);$x++){
								if($expense>'0'){
									if($adv_amt[$x]<'0'){
										$expense=$expense-$adv_amt[$x];
										$adv_amt[$x]=0;
										$query_advances="UPDATE ec_advances SET last_updated = now() , total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
									}
									else if(($adv_amt[$x]-$expense) >'0'){
										$expense1=$expense;
										$expense=$expense-$adv_amt[$x];
										$adv_amt[$x]=$adv_amt[$x]-$expense1;
										$query_advances="UPDATE ec_advances SET last_updated = now() , total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
									}
									else if(($adv_amt[$x]-$expense) =='0'){
										$expense=$expense-$adv_amt[$x];
										$adv_amt[$x]=0;
										$query_advances="UPDATE ec_advances SET last_updated = now() , total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
									}
									else{
										$expense1=$expense;
										$expense=$expense1-$adv_amt[$x];
										//$adv_amt[$x]=$adv_amt[$x]-$expense1;
										$adv_amt[$x]=0;
										$query_advances="UPDATE ec_advances SET last_updated = now() , total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
									}
									$mr_con->query($query_advances);
								}
							}
							/*if($expense>'0'){
								$x=count($advances)-1;
								$adv_amt[$x]=0-$expense;
								$query_advances="UPDATE ec_advances SET last_updated = now() , total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
								$mr_con->query($query_advances);
							}*/
						}else $asz=0;
						$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
						if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
						$url=localURL()."enersys_expense/maillings/book_expense.php?ref=".$alias;
						//file_get_contents($url);
						curlxing($url);
						$resCode='0'; $resMsg="Approved successfully";
					}else $res="Approval Failed";
					
					}
			}
			if($_REQUEST['ref2']=='5'){
					$empalias=$_REQUEST['emp_alias'];
					$alias=$_REQUEST['id'];
					$reasonForAdv=mysqli_real_escape_string($mr_con,trim($_REQUEST['reasonForAdv']));
					if($reasonForAdv==""){$res="Enter Remarks";}else{
					$reqdate=date("Y-m-d");
					$approved_by=expensedetlimited('approved_by',$alias)."|".$empalias;
					$approved_date=expensedetlimited('approved_date',$alias)."|".$reqdate;
					$sql="UPDATE ec_expenses SET last_updated = now() , approval_level='3',approved_by='$approved_by',approved_date='$approved_date' WHERE expenses_alias='$alias'";
					if($mr_con->query($sql)===TRUE){ 
					$action = "Expense approved with Bill Number: ".ebill($alias)."";
					user_history($_REQUEST['emp_alias'],$action,$ip_addr);
					$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
					if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
					$url=localURL()."enersys_expense/maillings/book_expense.php?ref=".$alias;
					//file_get_contents($url);
					curlxing($url);
					$resCode='0'; $resMsg="Approved successfully";} else { $res="Approval Failed";}
					
					}
			}
			if($_REQUEST['ref2']=='6'){
					$empalias=$_REQUEST['emp_alias'];
					$alias=$_REQUEST['id'];
					$reasonForAdv=mysqli_real_escape_string($mr_con,trim($_REQUEST['reasonForAdv']));
					$utr_num=mysqli_real_escape_string($mr_con,trim($_REQUEST['utr_num']));//exit;
					if($reasonForAdv==""){$res="Enter Remarks";}else if($utr_num==''){$res="Enter UTR Number";}else{
						$reqdate=date("Y-m-d");
						$sql="UPDATE ec_expenses SET last_updated = now() , utr_num='$utr_num' WHERE expenses_alias='$alias'";
						if($mr_con->query($sql)===TRUE) {
						$action = "Added UTR number for expense : ".ebill($alias)."";
						user_history($_REQUEST['emp_alias'],$action,$ip_addr);
						$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
						if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
						$resCode='0'; $resMsg="Updated successfully";} else { $res="Update Failed";}
					}
			}
		
		} else {
			$empalias=$_REQUEST['emp_alias'];
			$alias=$_REQUEST['id'];
			$reasonForAdv=mysqli_real_escape_string($mr_con,trim($_REQUEST['reasonForAdv']));
			if($reasonForAdv==""){$res="Enter Remarks";}else{
			$reqdate=date("Y-m-d");
			$limit =8;
			$s1=mysqli_query($mr_con,"SELECT approval_level FROM ec_expenses WHERE expenses_alias='$alias'");
			$getl = mysqli_fetch_array($s1);
			$get_prev_level = $getl['approval_level'];
			$sql="UPDATE ec_expenses SET last_updated = now() , approval_level='$limit' WHERE expenses_alias='$alias'";
			if($mr_con->query($sql)===TRUE) {
			$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
			if($reasonForAdv!=''){ $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
			$alias_reject=aliasCheck(generateRandomString(),"ec_rejected_levels","rejected_alias");
			$mr_con->query("INSERT INTO ec_rejected_levels(rejected_level,rejected_by,remark_alias,item_alias,rejected_alias) VALUES ('$get_prev_level','$empalias','$alias_remark','$alias','$alias_reject')");
			}
				$action = "Expense rejected with Bill Number : ".ebill($alias)."";
				user_history($_REQUEST['emp_alias'],$action,$ip_addr);
			$url=localURL()."enersys_expense/maillings/book_expense.php?ref=".$alias;
			//file_get_contents($url);
			curlxing($url);
			$resCode='0'; $resMsg="Rejected successfully";} else { $res="Approval Failed";}	
			//asyncInclude($url);
			}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function dpr_details(){ global $mr_con;
	$date1=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['d1']))));
	$date2=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['d2']))));
	$empalias=$_REQUEST['emp_alias'];
	//echo "SELECT dpr_ref_no,category_alias,DATE(sub_date_time) as sub_date,remarks,expense_incurred FROM `ec_dpr` where emp_alias = '$empalias' AND DATE(sub_date_time) BETWEEN '$date1' AND '$date2'";
	$s1=mysqli_query($mr_con,"SELECT dpr_ref_no,category_alias,DATE(sub_date_time) as sub_date,remarks,expense_incurred FROM `ec_dpr` where emp_alias = '$empalias' AND DATE(sub_date_time) BETWEEN '$date1' AND '$date2'");
	$result['dprDetails']=array();
	if(mysqli_num_rows($s1)){
		$i=0;
		while($row = mysqli_fetch_array($s1)){
			if($row['category_alias']=='0'){
				$cat='Your DPR is not Submitted';
			}else{
				$cat=getDprCat($row['category_alias']);
			}
			$result['dprDetails'][$i]['dpr_ref_no']=$row['dpr_ref_no'];
			$result['dprDetails'][$i]['dpr_cat']=$cat; 
			$result['dprDetails'][$i]['sub_date']=date("Y-m-d", strtotime($row['sub_date']));
			$result['dprDetails'][$i]['dpr_remarks']=$row['remarks'];
			$result['dprDetails'][$i]['expense_incurred']=$row['expense_incurred'];
		$i++;
		}
		$resCode='0'; $resMsg='Successful!';
	}else{$resCode='4'; $resMsg='No Records Found';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function del_expenses(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex=='0'){
		$delalias = mysqli_real_escape_string($mr_con,$_REQUEST['alias']);
		$exp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['ealias']);
		$reff = mysqli_real_escape_string($mr_con,$_REQUEST['reff']);
		$get_amt_sql = mysqli_query($mr_con,"SELECT amount FROM $reff WHERE alias ='".$delalias."' AND expenses_alias ='".$exp_alias."' AND flag=0");
		$getamt_rs = mysqli_fetch_array($get_amt_sql);
		$del_amt = $getamt_rs['amount'];
		$get_amt_sqll = mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias ='".$exp_alias."' AND flag=0");
		$getamt_rss = mysqli_fetch_array($get_amt_sqll);
		$total_amt = $getamt_rss['total_tour_expenses'];	
		$diff_amt = $total_amt-$del_amt;
		$sqlTT = mysqli_query($mr_con,"DELETE FROM $reff WHERE alias ='".$delalias."' AND expenses_alias ='".$exp_alias."' AND flag=0");
		if($sqlTT){
			$update_sql = mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses = '".$diff_amt."'  WHERE expenses_alias ='".$exp_alias."' AND flag=0");
			$res='Successfully Deleted';
		}else{$res='Not Deleted';}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex=='1'){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function expense_export(){ 

	global $mr_con;
	set_time_limit(0);
	ini_set('memory_limit', '1024M');
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk=='0'){
	$get_appr = mysqli_query($mr_con,"SELECT * from ec_expense_approvals where approver = '".$_REQUEST['emp_alias']."'");
	$get_cnt = mysqli_num_rows($get_appr);
	if($get_cnt > '0'){
		$get_lev = mysqli_query($mr_con,"SELECT GROUP_CONCAT(DISTINCT approval_level) AS approval_level FROM ec_expense_approvals where approver = '".$_REQUEST['emp_alias']."'");
		$get_lev_rs = mysqli_fetch_array($get_lev);
		$appr_list = explode(',',$get_lev_rs['approval_level']);
		$all_levels =  array('3','4','5');
		$arr_inter = array_intersect($appr_list,$all_levels);
		$arr_inter_cnt = count($arr_inter);
		if($arr_inter_cnt == '0'){ 
			$get_dep = mysqli_query($mr_con,"SELECT GROUP_CONCAT(DISTINCT approval_dep) AS approval_dep FROM ec_expense_approvals where approver = '".$_REQUEST['emp_alias']."'");
			$get_dept_rs = mysqli_fetch_array($get_dep);
			$appr_dept = $get_dept_rs['approval_dep'];
		}
	} 
	
	if(isset($_REQUEST['start_date']) && !empty($_REQUEST['start_date'])){$from = date("Y-m-d", strtotime($_REQUEST['start_date']));}else{$from = '';}
	if(isset($_REQUEST['end_date']) && !empty($_REQUEST['end_date'])){$to = date("Y-m-d", strtotime($_REQUEST['end_date']));}else{$to = '';}
	$val = mysqli_real_escape_string($mr_con,$_REQUEST['amount']);
	$level = mysqli_real_escape_string($mr_con,$_REQUEST['aplevel']);
	$appr_cnt = $get_cnt;
	if($appr_cnt == "0"){
		$emp_alias = $_REQUEST['emp_alias'];
	}else{
		$emp_alias = $_REQUEST['apl'];	
	}$con="";
	/*if(!empty($from) && !empty($to)){$con = "(requested_date BETWEEN '$from' AND '$to') AND";}
	elseif(!empty($from) && empty($to)){$con .= "requested_date >= '$from' AND";}
	elseif(empty($from) && !empty($to)){$con .= "requested_date <= '$to' AND";}*/
	if(!empty($from)){$con .= "period_of_visit_from >= '$from' AND ";}
	if(!empty($to)){$con .= "period_of_visit_to <= '$to' AND ";}
	if(!empty($val)){$con .= " total_tour_expenses='$val' AND";}
	if($level!=''){
		$con .= " approval_level='$level' AND";
	}
	
		if(strtoupper($emp_alias) == 'ADMIN' || strtoupper($emp_alias) == 'EADMIN') {
		$rec=$mr_con->query("SELECT employee_alias FROM ec_employee_master WHERE flag=0 ORDER BY name");
		if($rec->num_rows>'0'){
			while($row = $rec->fetch_assoc()){$result[]=$row['employee_alias'];}
		}
		$con .= " employee_alias IN ('".implode("','",$result)."') AND";
		
	}else{
		if($emp_alias !='' && $emp_alias !='0'){$con .= " employee_alias='$emp_alias' AND";}
		else{$result=array();
		if($arr_inter_cnt == '0'){
			$check_arr=implode("','",explode(',',$appr_dept));
			$rec=$mr_con->query("SELECT employee_alias FROM ec_employee_master WHERE flag=0 AND department_alias IN ('$check_arr') ORDER BY name");
			if($rec->num_rows>'0'){
				while($row = $rec->fetch_assoc()){$result[]=$row['employee_alias'];}
			}
			$con .= " employee_alias IN ('".implode("','",$result)."') AND";
		}else{
			$rec=$mr_con->query("SELECT employee_alias FROM ec_employee_master WHERE flag=0 ORDER BY name");
			if($rec->num_rows>'0'){
				while($row = $rec->fetch_assoc()){$result[]=$row['employee_alias'];}
			}
			$con .= " employee_alias IN ('".implode("','",$result)."') AND";
		}
		}
	}

	//echo "SELECT * FROM ec_expenses WHERE $con flag=0";exit;
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_expenses WHERE $con flag=0");
	$colArr =array('Employee ID','Employee Name','Employee Designation','Employee Grade','Employee Department','Bill Number','Booking Date','Period Of Visit From','Period Of Visit To','Places Of Visit','Purpose','Expense For','Amount','Total Tour Expenses','Date Of Travel','Mode Of Travel','From','To','Type Of Stay','Visit Start Date','Visit End Date','Hotel Name/State','Ticket ID','DPR Number','Description',
	'Date','Approval Level');
	$colArr2 =array('places_of_visit','purpose');
	$colArr3 =array('total_tour_expenses');
	$tbls = array('ec_conveyance','ec_localconveyance','ec_lodging','ec_boarding','ec_other_expenses');
		if(mysqli_num_rows($sql)){
			$filename = 'Expense-'.rand(0000,9999)."-".date("Y-m-d");
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			$sheet = $objPHPExcel->getActiveSheet();
			$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF'),/*'size'  => 15,'name'  => 'Verdana'*/ ));
			$ch = 'A';
			foreach($colArr as $colrefValue){
				$sheet->SetCellValue($ch.'1',ucfirst($colrefValue));
				$sheet->getStyle($ch.'1')->applyFromArray($styleArray);
				$sheet->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$ch++;
			}
			$date_arr = array("G","H","I","O","T","U","Z");
			foreach($date_arr as $da){$sheet->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension($da)->setAutoSize(true);}
			$coo=1;
			while($row=mysqli_fetch_array($sql)){
				$explevel = $row['approval_level'];
				$empalias = $row['employee_alias'];
				if($explevel !='0'){
					foreach($tbls as $tbl){
					$subsql = mysqli_query($mr_con,"SELECT * FROM $tbl WHERE expenses_alias='".$row['expenses_alias']."' AND flag=0");
					while($subrow=mysqli_fetch_array($subsql)){ $coo++;
						$sheet->SetCellValue('A'.$coo, alias($row['employee_alias'],'ec_employee_master','employee_alias','employee_id'));
						$sheet->SetCellValue('B'.$coo, alias($row['employee_alias'],'ec_employee_master','employee_alias','name'));
						$sheet->SetCellValue('C'.$coo, alias(alias($row['employee_alias'],'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','designation'));
						$sheet->SetCellValue('D'.$coo, alias(alias($row['employee_alias'],'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','grade'));
						$sheet->SetCellValue('E'.$coo, alias(alias($row['employee_alias'],'ec_employee_master','employee_alias','department_alias'),'ec_department','department_alias','department_name'));
						$sheet->SetCellValue('F'.$coo, $row['bill_number']);
						$sheet->SetCellValue('G'.$coo, php_excel_date($row['requested_date']));
						$sheet->SetCellValue('H'.$coo, php_excel_date($row['period_of_visit_from']));
						$sheet->SetCellValue('I'.$coo, php_excel_date($row['period_of_visit_to']));
						for($af=0,$chr='J';$af<count($colArr2);$af++,$chr++){
							$sheet->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
						}
						$date_of_travel = ($tbl=='ec_conveyance' || $tbl=='ec_localconveyance' ? $subrow['date_of_travel']:'-');
						$check_in = ($tbl=='ec_lodging' || $tbl=='ec_boarding' ? $subrow['check_in']:'-');
						$check_out = ($tbl=='ec_lodging' || $tbl=='ec_boarding' ? $subrow['check_out']:'-');
						$checked_date = ($tbl=='ec_other_expenses' ? $subrow['checked_date']:'-');
						$dpr = ($subrow['dpr_number']!='' ? $subrow['dpr_number']:'-') ;
						if($subrow['ticket_alias'] == 1){
							$ticket = 'Others';	
						}else{
							$ticket = ($subrow['ticket_alias']!='' ? getTicketName($subrow['ticket_alias']):'-') ;
						}
						$sheet->SetCellValue('L'.$coo, exp_for($tbl,($tbl=='ec_localconveyance' ? $subrow['bucket'] : 1))); // Expense For
						$sheet->SetCellValue('M'.$coo, $subrow['amount']); // Amount
						$sheet->SetCellValue('N'.$coo, $row['total_tour_expenses']);// Total tour exp
						$sheet->SetCellValue('O'.$coo, ($date_of_travel=='-' ? '-' : php_excel_date($date_of_travel))); //Date Of Travel
						$sheet->SetCellValue('P'.$coo, ($tbl=='ec_conveyance' || $tbl=='ec_localconveyance' ? $subrow['mode_of_travel']:'-')); //Mode Of Travel
						$sheet->SetCellValue('Q'.$coo, ($tbl=='ec_conveyance' || $tbl=='ec_localconveyance' ? $subrow['from_place']:'-')); //From
						$sheet->SetCellValue('R'.$coo, ($tbl=='ec_conveyance' || $tbl=='ec_localconveyance' ? $subrow['to_place']:'-')); //To
						$sheet->SetCellValue('S'.$coo, ($tbl=='ec_lodging' ? $subrow['type_of_stay']:'-')); //Type Of Stay
						$sheet->SetCellValue('T'.$coo, ($check_in=='-' ? '-' : php_excel_date($check_in))); //Visit Start Date
						$sheet->SetCellValue('U'.$coo, ($check_out=='-' ? '-' : php_excel_date($check_out))); //Visit End Date
						$sheet->SetCellValue('V'.$coo, ($tbl=='ec_lodging' ? $subrow['hotel_name']:($tbl=='ec_boarding' ? $subrow['state']:'-'))); //Hotel Name/State
						$sheet->SetCellValue('W'.$coo, $ticket); 
						$sheet->SetCellValue('X'.$coo, $dpr);
						$sheet->SetCellValue('Y'.$coo, ($tbl=='ec_other_expenses' ? $subrow['description']:'-')); //Description	
						$sheet->SetCellValue('Z'.$coo, ($checked_date=='-' ? '-' : php_excel_date($checked_date))); //Date
						$sheet->SetCellValue('AA'.$coo, exlevelsName($row['approval_level'])); //approval level
						
						$remSql = mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE item_alias='".$row['expenses_alias']."' AND module='BE' AND flag=0");
						$remCount=(mysqli_num_rows($remSql)*3);
						$j=1;
						for($i=1,$cb='AB';$i<=$remCount;$i++,$cb++){
							$sheet->getStyle($cb.'1')->applyFromArray($styleArray);
							$sheet->getStyle($cb.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
							if($i%3=='1'){$sheet->SetCellValue($cb.'1','Remarks '.$j);}
							if($i%3=='2'){$sheet->SetCellValue($cb.'1','Remarked By '.$j);}
							if($i%3=='0'){
								$sheet->SetCellValue($cb.'1','Remarked On '.$j);				
								$sheet->getStyle($cb)->getNumberFormat()->setFormatCode('mm/dd/yyyy');
								$sheet->getColumnDimension($cb)->setAutoSize(true);$j++;
							}
						}
						$cc = 'AB';
						$k=1;while($remRow = mysqli_fetch_array($remSql)){
							$sheet->SetCellValue($cc.$coo, mysqli_real_escape_string($mr_con,$remRow['remarks']));$cc++;
							$sheet->SetCellValue($cc.$coo, (strtoupper($remRow['remarked_by'])!='ADMIN' ? alias($remRow['remarked_by'],'ec_employee_master','employee_alias','name') : "ADMIN"));$cc++;
							$sheet->SetCellValue($cc.$coo, php_excel_date($remRow['remarked_on']));
							$cc++;$k++;
						}
					}
				}
				} else {
					if($_REQUEST['emp_alias'] == $empalias){
						foreach($tbls as $tbl){
					$subsql = mysqli_query($mr_con,"SELECT * FROM $tbl WHERE expenses_alias='".$row['expenses_alias']."' AND flag=0");
					while($subrow=mysqli_fetch_array($subsql)){ $coo++;
						$sheet->SetCellValue('A'.$coo, alias($row['employee_alias'],'ec_employee_master','employee_alias','employee_id'));
						$sheet->SetCellValue('B'.$coo, alias($row['employee_alias'],'ec_employee_master','employee_alias','name'));
						$sheet->SetCellValue('C'.$coo, alias(alias($row['employee_alias'],'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','designation'));
						$sheet->SetCellValue('D'.$coo, alias(alias($row['employee_alias'],'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','grade'));
						$sheet->SetCellValue('E'.$coo, alias(alias($row['employee_alias'],'ec_employee_master','employee_alias','department_alias'),'ec_department','department_alias','department_name'));
						$sheet->SetCellValue('F'.$coo, $row['bill_number']);
						$sheet->SetCellValue('G'.$coo, php_excel_date($row['requested_date']));
						$sheet->SetCellValue('H'.$coo, php_excel_date($row['period_of_visit_from']));
						$sheet->SetCellValue('I'.$coo, php_excel_date($row['period_of_visit_to']));
						for($af=0,$chr='J';$af<count($colArr2);$af++,$chr++){
							$sheet->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
						}
						$date_of_travel = ($tbl=='ec_conveyance' || $tbl=='ec_localconveyance' ? $subrow['date_of_travel']:'-');
						$check_in = ($tbl=='ec_lodging' || $tbl=='ec_boarding' ? $subrow['check_in']:'-');
						$check_out = ($tbl=='ec_lodging' || $tbl=='ec_boarding' ? $subrow['check_out']:'-');
						$checked_date = ($tbl=='ec_other_expenses' ? $subrow['checked_date']:'-');
						$dpr = ($subrow['dpr_number']!='' ? $subrow['dpr_number']:'-') ;
						if($subrow['ticket_alias'] == 1){
							$ticket = 'Others';	
						}else{
							$ticket = ($subrow['ticket_alias']!='' ? getTicketName($subrow['ticket_alias']):'-') ;
						}
						$sheet->SetCellValue('L'.$coo, exp_for($tbl,($tbl=='ec_localconveyance' ? $subrow['bucket'] : 1))); // Expense For
						$sheet->SetCellValue('M'.$coo, $subrow['amount']); // Amount
						$sheet->SetCellValue('N'.$coo, $row['total_tour_expenses']);// Total tour exp
						$sheet->SetCellValue('O'.$coo, ($date_of_travel=='-' ? '-' : php_excel_date($date_of_travel))); //Date Of Travel
						$sheet->SetCellValue('P'.$coo, ($tbl=='ec_conveyance' || $tbl=='ec_localconveyance' ? $subrow['mode_of_travel']:'-')); //Mode Of Travel
						$sheet->SetCellValue('Q'.$coo, ($tbl=='ec_conveyance' || $tbl=='ec_localconveyance' ? $subrow['from_place']:'-')); //From
						$sheet->SetCellValue('R'.$coo, ($tbl=='ec_conveyance' || $tbl=='ec_localconveyance' ? $subrow['to_place']:'-')); //To
						$sheet->SetCellValue('S'.$coo, ($tbl=='ec_lodging' ? $subrow['type_of_stay']:'-')); //Type Of Stay
						$sheet->SetCellValue('T'.$coo, ($check_in=='-' ? '-' : php_excel_date($check_in))); //Visit Start Date
						$sheet->SetCellValue('U'.$coo, ($check_out=='-' ? '-' : php_excel_date($check_out))); //Visit End Date
						$sheet->SetCellValue('V'.$coo, ($tbl=='ec_lodging' ? $subrow['hotel_name']:($tbl=='ec_boarding' ? $subrow['state']:'-'))); //Hotel Name/State
						$sheet->SetCellValue('W'.$coo, $ticket); 
						$sheet->SetCellValue('X'.$coo, $dpr);
						$sheet->SetCellValue('Y'.$coo, ($tbl=='ec_other_expenses' ? $subrow['description']:'-')); //Description	
						$sheet->SetCellValue('Z'.$coo, ($checked_date=='-' ? '-' : php_excel_date($checked_date))); //Date
						$sheet->SetCellValue('AA'.$coo, exlevelsName($row['approval_level'])); //approval level
						
						$remSql = mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE item_alias='".$row['expenses_alias']."' AND module='BE' AND flag=0");
						$remCount=(mysqli_num_rows($remSql)*3);
						$j=1;
						for($i=1,$cb='AB';$i<=$remCount;$i++,$cb++){
							$sheet->getStyle($cb.'1')->applyFromArray($styleArray);
							$sheet->getStyle($cb.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
							if($i%3=='1'){$sheet->SetCellValue($cb.'1','Remarks '.$j);}
							if($i%3=='2'){$sheet->SetCellValue($cb.'1','Remarked By '.$j);}
							if($i%3=='0'){
								$sheet->SetCellValue($cb.'1','Remarked On '.$j);
								$sheet->getStyle($cb)->getNumberFormat()->setFormatCode('mm/dd/yyyy');
								$sheet->getColumnDimension($cb)->setAutoSize(true);$j++;
							}
						}
						$cc = 'AB';
						$k=1;while($remRow = mysqli_fetch_array($remSql)){
							$sheet->SetCellValue($cc.$coo, mysqli_real_escape_string($mr_con,$remRow['remarks']));$cc++;
							$sheet->SetCellValue($cc.$coo, (strtoupper($remRow['remarked_by'])!='ADMIN' ? alias($remRow['remarked_by'],'ec_employee_master','employee_alias','name') : "ADMIN"));$cc++;
							$sheet->SetCellValue($cc.$coo, php_excel_date($remRow['remarked_on']));
							$cc++;$k++;
						}
					}
				}
					}
				}
			}
			$objPHPExcel->getActiveSheet()->setTitle('Expenses');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save("../../exports/$filename.xlsx");
			$result['file_name']=$filename;
			$resCode='0'; $resMsg='export';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;	
		echo json_encode($result);
}

function expense_import(){ 
	global $mr_con;
	$emp_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias']));
	$token=mysqli_real_escape_string($mr_con,trim($_REQUEST['token']));
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		if(isset($_FILES["scm_appr"])){ //if there was an error uploading the file
			if($_FILES["scm_appr"]["error"]==0){
				 $extn = pathinfo($_FILES['scm_appr']['name'], PATHINFO_EXTENSION);
				if($extn=='xlsx' || $extn=='xls'){
					set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
					// This is the file path to be uploaded.
					$inputFileName = $_FILES["scm_appr"]["tmp_name"];
					try { $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);}
					catch(Exception $e){die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage()); }
					$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
					$highestColumm=$objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
					$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumm);
					if($highestColumnIndex=='1025' || $highestColumnIndex=='3'){
						$arrayCount = count($allDataInSheet);  
						// Here get total count of row in that Excel sheet
						$good_bill=$data_bil_arr=$po_gnr_arr=$remarks_arr=$appr_rej_arr=$emptyData=$failed=$wrongData = array();
						for($i=2;$i<=$arrayCount;$i++){
							$bill_number = strtoupper(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["A"])));
							$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["B"])));
							$appr_rej = strtoupper(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["C"])));
							if(empty($bill_number) || empty($remarks) || empty($appr_rej)) {
								$emptyData[]=$bill_number;
							} else {
								$good_bill[]=$bill_number;
								$remarks_arr[$bill_number]=$remarks;
								$appr_rej_arr[$bill_number]=$appr_rej;
							}
						}
						if(count($emptyData)==0 && count($good_bill)==($arrayCount-1)){
							$query=mysqli_query($mr_con,"SELECT COUNT(id) AS cnt,GROUP_CONCAT(expenses_alias) AS exp_ali, GROUP_CONCAT(bill_number) AS bil_num FROM ec_expenses WHERE approval_level='3' AND bill_number IN ('".implode("','",$good_bill)."') AND flag=0");
							$row=mysqli_fetch_array($query);
							$data_bil_arr=explode(",",$row['bil_num']);
							if($row['cnt']!=count($good_bill))$wrongData=array_diff($good_bill,$data_bil_arr);
							if(count($wrongData)==0){$reqdate=date("Y-m-d");
								$exp_ali_arr=explode(",",$row['exp_ali']);
								for($k=0;$k<=count($exp_ali_arr);$k++){
									$expenses_alias=$exp_ali_arr[$k];
									$remarks_val=$remarks_arr[$data_bil_arr[$k]];
									$appr_rej_val=$appr_rej_arr[$data_bil_arr[$k]];
									if($appr_rej_val=='APPROVE'){
										$approved_by=expensedetlimited('approved_by',$expenses_alias)."|".$emp_alias;
										$approved_date=expensedetlimited('approved_date',$expenses_alias)."|".$reqdate;
										$sql="UPDATE ec_expenses SET last_updated = now(), approval_level='4', approved_by='$approved_by',approved_date='$approved_date' WHERE expenses_alias='$expenses_alias'";
										if($mr_con->query($sql)){
											$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
											$mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$remarks_val','BE','$expenses_alias','$emp_alias','$alias_remark')");
											curlxing(localURL()."enersys_expense/maillings/book_expense.php?ref=".$expenses_alias);
											$action = "Expense approved with Bill Number: ".ebill($expenses_alias)."";
											user_history($emp_alias,$action,$_REQUEST['ip_addr']);
										} else $failed[] = $data_bil_arr[$k];
									}else{ //REJECT
										$s1=mysqli_query($mr_con,"SELECT approval_level FROM ec_expenses WHERE expenses_alias='$expenses_alias'");
										$getl = mysqli_fetch_array($s1);
										$get_prev_level = $getl['approval_level'];
										$sql1="UPDATE ec_expenses SET last_updated = now() , approval_level='8' WHERE expenses_alias='$expenses_alias'";
										if($mr_con->query($sql1)) {
											$action = "Expense rejected with Bill Number : ".ebill($expenses_alias)."";
											user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
											$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
											$mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$remarks_val','BE','$expenses_alias','$emp_alias','$alias_remark')");
											$alias_reject=aliasCheck(generateRandomString(),"ec_rejected_levels","rejected_alias");
											$mr_con->query("INSERT INTO ec_rejected_levels(rejected_level,rejected_by,remark_alias,item_alias,rejected_alias) VALUES ('$get_prev_level','$emp_alias','$alias_remark','$expenses_alias','$alias_reject')");
											$url=localURL()."enersys_expense/maillings/book_expense.php?ref=".$expenses_alias;
											curlxing($url);
										} else $failed[] = $data_bil_arr[$k];
									}
								}
								if(empty(count($failed))){$resCode='0'; $resMsg="All bills are successfully approved";}else $res = implode(", ",$failed).' bill numbers approval failed';
							}else $res = (count($wrongData)>1 ? implode(", ",$wrongData).' are wrong bill numbers OR these bill numbers are not belongs to SCM pending level' : end($wrongData).' is wrong bill number OR this bill number is not belongs to SCM pending level');
						}else $res = implode(", ",$emptyData).' bill numbers have empty records';
					}else $res = 'Selected excel file has wrong format.';
				}else $res = 'Invalid file...';
			}else $res = "No file selected";
		}else $res = "No file selected";
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function expense_import_finance() { 
	global $mr_con;	
	$emp_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias']));
	$token=mysqli_real_escape_string($mr_con,trim($_REQUEST['token']));
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		if(isset($_FILES["fina_appr"])) { 
			//if there was an error uploading the file
			if($_FILES["fina_appr"]["error"]==0) {
				 $extn = pathinfo($_FILES['fina_appr']['name'], PATHINFO_EXTENSION);
				if($extn=='xlsx' || $extn=='xls') {
					set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
					// This is the file path to be uploaded.
					$inputFileName = $_FILES["fina_appr"]["tmp_name"];
					try { 
						$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
					} catch(Exception $e){
						die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage()); 
					}
					$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
					$highestColumm = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
					$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumm);
					// print_r($allDataInSheet);
					if($highestColumnIndex == 5 || $highestColumnIndex == 1025) {
						$updateBills = [];
						foreach($allDataInSheet as $eachSheet) {
							if($eachSheet['A'] != 'Bill Number' && $eachSheet['A'] != ''){
								$bill_number = mysqli_real_escape_string($mr_con,trim($eachSheet["A"]));
								$reimburement = mysqli_real_escape_string($mr_con,trim($eachSheet["B"]));
								$refund = mysqli_real_escape_string($mr_con,trim($eachSheet["C"]));
								if($refund == '') {
									$refund = "0";
								}
								$remarks = strtoupper(mysqli_real_escape_string($mr_con, trim($eachSheet["D"])));
								$action = strtoupper(mysqli_real_escape_string($mr_con, trim($eachSheet["E"])));
								$q = "SELECT * FROM `ec_expenses` WHERE bill_number = '". $bill_number ."' AND approval_level = '4'";
								$expSql = mysqli_query($mr_con, $q);
								if(mysqli_num_rows($expSql) == 0) {
									$res = "$bill_number is an invalid bill no"; 
									continue;
								}
								if($action == 'APPROVE' && !ctype_digit($reimburement)) {
									$res = "Provide a valid reimbursement value for bill $bill_number"; 
									continue;
								}
								if($action == 'APPROVE' && !ctype_digit($refund)) {
									$res = "Provide a valid refund value for bill $bill_number";
									continue;
								}
								if($action != 'APPROVE' && $action != 'REJECT') {
									$res = "Provide a valid action for bill $bill_number"; 
									continue;
								}
								$expDetails = mysqli_fetch_array($expSql);
								if($action != "APPROVE") {
									$refund = 0;
									$reimburement = 0;
								}
								$bill = [
									"bill_number" => $bill_number,
									"reimburement" => $reimburement,
									"refund" => $refund,
									"remarks" => $remarks,
									"action" => $action,
									"id" => $expDetails['expenses_alias']
								];
								$updateBills[] = $bill;
							}
						}
						if(empty($res)) {
							foreach($updateBills as $eachBill) {
								$alias = $eachBill['id'];
								$rem_amt = $eachBill['reimburement'];
								$ref_amt = $eachBill['refund'];
								$reasonForAdv = $eachBill['remarks'];
								$bill_number = $eachBill['bill_number'];
								if($eachBill['action'] == 'APPROVE') {
									$reqdate=date("Y-m-d");
									$approved_by=expensedetlimited('approved_by',$alias)."|".$emp_alias;
									$approved_date=expensedetlimited('approved_date',$alias)."|".$reqdate;
									$sql="UPDATE ec_expenses SET last_updated = now() , approval_level='6',approved_by='$approved_by',approved_date='$approved_date',reimbursement_amount='$rem_amt',refund_amount='$ref_amt' WHERE expenses_alias='$alias'";
									if($mr_con->query($sql)===TRUE){
										$action = "Expense approved with Bill Number: " . $bill_number ;
										user_history($emp_alias, $action, $_REQUEST['ip_addr'], $reasonForAdv);
										$expense = alias($alias,'ec_expenses','expenses_alias','total_tour_expenses');
										$expense_emp_alias = alias($alias,'ec_expenses','expenses_alias','employee_alias');
										$rec = $mr_con->query("SELECT total_amount, advance_alias FROM ec_advances WHERE employee_alias='$expense_emp_alias' AND  approval_level='6' AND total_amount <>'0' AND flag=0 ORDER BY requested_date");
										if($rec->num_rows > 0) {
											$axs = 0;
											while($row = $rec->fetch_assoc()) {
												$advances[$axs]=$row['advance_alias'];
												$adv_amt[$axs]=$row['total_amount'];
												$axs++;
											}
											for($x=0;$x<count($advances);$x++){
												if($expense>'0') {
													if($adv_amt[$x]<'0'){
														$expense=$expense-$adv_amt[$x];
														$adv_amt[$x]=0;
														$query_advances="UPDATE ec_advances SET last_updated = now() , total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
													}
													else if(($adv_amt[$x]-$expense) >'0'){
														$expense1=$expense;
														$expense=$expense-$adv_amt[$x];
														$adv_amt[$x]=$adv_amt[$x]-$expense1;
														$query_advances="UPDATE ec_advances SET last_updated = now() , total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
													}
													else if(($adv_amt[$x]-$expense) =='0'){
														$expense=$expense-$adv_amt[$x];
														$adv_amt[$x]=0;
														$query_advances="UPDATE ec_advances SET last_updated = now() , total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
													}
													else{
														$expense1=$expense;
														$expense=$expense1-$adv_amt[$x];
														$adv_amt[$x]=0;
														$query_advances="UPDATE ec_advances SET last_updated = now() , total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
													}
													$mr_con->query($query_advances);
												}
											}
										}
										$alias_remark = aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
										if($reasonForAdv!='') 
											$mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$emp_alias','$alias_remark')");
										$url = localURL()."enersys_expense/maillings/book_expense.php?ref=".$alias;
										curlxing($url);
									} else $res .= "Approval Failed for $bill_number";
								} else {
									$reqdate = date("Y-m-d");
									$limit = 8;
									$s1 = mysqli_query($mr_con,"SELECT approval_level FROM ec_expenses WHERE expenses_alias='$alias'");
									$getl = mysqli_fetch_array($s1);
									$get_prev_level = $getl['approval_level'];
									$sql="UPDATE ec_expenses SET last_updated = now() , approval_level='$limit' WHERE expenses_alias='$alias'";
									if($mr_con->query($sql)===TRUE) {
										$action = "Expense rejected with Bill Number : " . $bill_number;
										user_history($emp_alias, $action, $ip_addr, $reasonForAdv);
										$alias_remark = aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
										if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$emp_alias','$alias_remark')");
										$alias_reject=aliasCheck(generateRandomString(),"ec_rejected_levels","rejected_alias");
										$mr_con->query("INSERT INTO ec_rejected_levels(rejected_level,rejected_by,remark_alias,item_alias,rejected_alias) VALUES ('$get_prev_level','$emp_alias','$alias_remark','$alias','$alias_reject')");
										$url = localURL()."enersys_expense/maillings/book_expense.php?ref=".$alias;
										curlxing($url);						
									} else $res .= "Request Failed for $bill_number";
								}
							} 
						}
					} else $res = 'Selected excel file has wrong format.';
				} else $res = 'Invalid file...';
			} else $res = "No file selected";
		} else $res = "No file selected";

		if(isset($res) && !empty($res)){
			$resCode='4';$resMsg=$res;
		} else {
			$resCode='0';$resMsg="Imported successfully"; 
		}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function total_advance(){global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk=='0'){
		if(isset($_REQUEST['amntCurnt'])){$crntReq=totalAdvance($_REQUEST['amntCurnt'],$_REQUEST['emp_alias']);$result['tl_amt']=trim($crntReq);}		
		else{$result['tl_amt']=0;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);	
}
function sendexp_email(){ global $mr_con;
	$emp_alias = $_REQUEST['emp_alias']; $token = $_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$exp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['exalias']));
		$exp_emp= alias($exp_alias,"ec_expenses","expenses_alias","employee_alias");
		$mail_id = employeeDetails('email_id',$exp_emp);
		if(empty($mail_id) && !filter_var($mail_id, FILTER_VALIDATE_EMAIL)){$resCode='4'; $resMsg='Please check your Mail ID';}


		else{$tr=$mail_id;
			if($tr){$resCode='0'; $resMsg=$tr;}
			else{$resCode='4'; $resMsg='Sending Failed';}
		}
	}elseif($rex=='1'){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function del_mainexp(){ global $mr_con;
	$emp_alias = $_REQUEST['emp_alias']; $token = $_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$exp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['exalias']));
		$billno = alias($exp_alias,"ec_expenses","expenses_alias","bill_number");
		$arr = array("ec_conveyance","ec_localconveyance","ec_lodging","ec_other_expenses","ec_boarding");
		foreach($arr as $abc){
			if($abc!="ec_boarding" && $abc!="ec_localconveyance"){
				$xyz = alias($exp_alias,$abc,"expenses_alias","document_link");
				if(file_exists($xyz))@unlink("../../".$xyz);
			}
			$del_in = mysqli_query($mr_con,"DELETE FROM $abc WHERE expenses_alias='$exp_alias' AND flag=0");
		}
			$del_main = mysqli_query($mr_con,"DELETE FROM ec_expenses WHERE expenses_alias='$exp_alias'");
		$del_remarks = mysqli_query($mr_con,"DELETE FROM ec_remarks WHERE item_alias='$exp_alias' AND module='BE'");
		if($del_main) {
			$action = "Expence bill number: ".$billno." deleted.";
			user_history($emp_alias,$action,$_REQUEST['ip_addr']);
			$resCode='0'; $resMsg='Bill Number: '.$billno.', Successfully Deleted';}else {$resCode='1'; $resMsg='Expense Deletion Failed';}
	}elseif($rex=='1'){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function advances_delete(){ 
	global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0) {
		$advance_alias=mysqli_real_escape_string($mr_con,$_REQUEST['advance_alias']);
		$remarks = mysqli_real_escape_string($mr_con,$_REQUEST['remarks']);
		$reqid = areq($advance_alias);
		$rec=$mr_con->query("UPDATE ec_advances SET last_updated = now() , flag = 9 WHERE advance_alias='$advance_alias'");
		$mr_con->query("UPDATE ec_remarks set flag = 9 WHERE item_alias='$advance_alias' AND module='BA'");
		if($rec) {
				$action = "Advance request id: ".$reqid." deleted.";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr'], $remarks);
				$resCode = '0';$resMsg="Advance Deleted successfully";
		} else{
			$resCode = '4';$resMsg="Advance Delete Failed";
		}
	} elseif($chk==1){
		$resCode='1';$resMsg='Authentication Failed!';
	} else { 
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
// New Changes

// Start - Local Conveyance
function ser_loc_single_add(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		$exp_alias=$_REQUEST['alias'];
		$reqdate=date("Y-m-d");
		for($i=0;$i<count($_REQUEST['zone_l']);$i++){
			if($_REQUEST['zone_l'][$i] == '' && $_REQUEST['state_l'][$i] == '' && $_REQUEST['district_l'][$i] == '' && $_REQUEST['bucket'][$i] =='' && $_REQUEST['dot_l'][$i]=='' && $_REQUEST['mot_l'][$i]=='' && $_REQUEST['from_l'][$i]=='' && $_REQUEST['to_l'][$i]=='' && $_REQUEST['ticket_idl'][$i]=='' && $_REQUEST['dprNum_l'][$i]=='' && $_REQUEST['amt_l'][$i]=='')	{
				$mess=1;
			}else{
				if($_REQUEST['zone_l'][$i]=='') {$resCode='4';$mess="Local Conveyance" .($i+1). ": Select  Zone";$resMsg=$mess;}
				else if($_REQUEST['state_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select State";$resMsg=$mess;}
				else if($_REQUEST['district_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select District";$resMsg=$mess;}
				else if($_REQUEST['bucket'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select Bucket";$resMsg=$mess;}
				else if($_REQUEST['bucket'][$i]!=''){
					if($_REQUEST['bucket'][$i]== "0"){
						if($_REQUEST['cap'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select Capacity";$resMsg=$mess;}
						else if($_REQUEST['quantityCell'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Enter Quantity";$resMsg=$mess;}
						else if($_REQUEST['numKilometers'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Enter No.of Kilometers";$resMsg=$mess;}
						else if($_REQUEST['dot_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select Date of travel";$resMsg=$mess;}
						else if($_REQUEST['from_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Enter From place";$resMsg=$mess;}
						else if($_REQUEST['to_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Enter To place";$resMsg=$mess;}
						else if($_REQUEST['mot_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select Mode of travel";$resMsg=$mess;}
						else if($_REQUEST['ticket_idl'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select Ticket Id";$resMsg=$mess;}
						else if($_REQUEST['dprNum_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Enter DPR Number";$resMsg=$mess;}
						else if($_REQUEST['amt_l'][$i]=='' || $_REQUEST['amt_l'][$i]=='0'){$resCode='4';$mess="Local Conveyance" .($i+1). ": Amount Required";$resMsg=$mess;}
						else $mess=1;
					}else{
						if($_REQUEST['dot_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select Date of travel";$resMsg=$mess;}
						else if($_REQUEST['from_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Enter From place";$resMsg=$mess;}
						else if($_REQUEST['to_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Enter To place";$resMsg=$mess;}
						else if($_REQUEST['mot_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select Mode of travel";$resMsg=$mess;}
						else if($_REQUEST['ticket_idl'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select Ticket Id";$resMsg=$mess;}
						else if($_REQUEST['dprNum_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Enter DPR Number";$resMsg=$mess;}
						else if($_REQUEST['amt_l'][$i]=='' || $_REQUEST['amt_l'][$i]=='0'){$resCode='4';$mess="Local Conveyance" .($i+1). ": Amount Required";$resMsg=$mess;}
						else $mess=1;
					}
				}else $mess=1;
			}
			if($mess!=1){ echo return_false($resMsg); exit;}
		}
		if($mess==1){
			if((mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_loc'])=="") || (mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_loc'])=='0')){$res=$mess="Enter Local Conveyance Details";}
		}
		if($mess==1){
			for($i=0;$i<count($_REQUEST['amt_l']);$i++){
				$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['dot_l'][$i]))));
				$fa[$i]=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mot_l'][$i]));
				$fb[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['from_l'][$i]);
				$fc[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['to_l'][$i]);
				$fd[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['amt_l'][$i]);
				$fe[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['zone_l'][$i]);
				$ff[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state_l'][$i]);
				$fg[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['district_l'][$i]);
				$fh[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['area_l'][$i]);
				$fi[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['bucket'][$i]);
				if($fi[$i] == 0){
					$fj[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['cap'][$i]);
					$fk[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['wofCell'][$i]);
					$fl[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['quantityCell'][$i]);
					$fm[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['numKilometers'][$i]);
				} else {
					$fj[$i]='';
					$fk[$i]='';
					$fl[$i]='';
					$fm[$i]='';
				}	
				$fn[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['dprNum_l'][$i]);
				$fo[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['ticket_idl'][$i]);
				$alias1=aliasCheck(generateRandomString(),"ec_localconveyance","alias");
				if($_REQUEST['zone_l'][$i] != '' && $_REQUEST['state_l'][$i] != '' && $_REQUEST['district_l'][$i] != '' && $_REQUEST['bucket'][$i] !='' && $_REQUEST['dot_l'][$i]!='' && $_REQUEST['mot_l'][$i]!='' && $_REQUEST['from_l'][$i]!='' && $_REQUEST['to_l'][$i]!='' && $_REQUEST['ticket_idl'][$i]!='' && $_REQUEST['dprNum_l'][$i]!='' && $_REQUEST['amt_l'][$i]!='')	{
					$loc_insqry = mysqli_query($mr_con,"INSERT INTO ec_localconveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,zone_alias,state_alias,district_alias,bucket,capacity,quantity,km,dpr_number,ticket_alias,alias,created_date) VALUES('$exp_alias','$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$fe[$i]','$ff[$i]','$fg[$i]','$fi[$i]','$fj[$i]','$fl[$i]','$fm[$i]','$fn[$i]','$fo[$i]','$alias1','$reqdate')");
					if($loc_insqry){
						$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$exp_alias."'");
						$sel_rs=mysqli_fetch_array($sel);
						$texp=$sel_rs['total_tour_expenses'];
						$upval=$texp+$fd[$i];
						$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$exp_alias."'");
					}
				}
			}
			if($loc_insqry){
				$action = "Expence bill number: ".ebill($exp_alias)." updated.";
				user_history($emp_alias,$action,$ip_addr);
				$resCode='0';$resMsg='Inserted Successfully';}else{$resCode='4';$resMsg='Failed';}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function ser_loc_single_edit(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		//Local Conveyance Validation
		if($_REQUEST['zone_l']=='') {$resCode='4';$mess="Local Conveyance : Select  Zone";$resMsg=$mess;}
		else if($_REQUEST['state_l']==''){$resCode='4';$mess="Local Conveyance : Select State";$resMsg=$mess;}
		else if($_REQUEST['district_l']==''){$resCode='4';$mess="Local Conveyance : Select District";$resMsg=$mess;}
		else if($_REQUEST['bucket']==''){$resCode='4';$mess="Local Conveyance : Select Bucket";$resMsg=$mess;}
		else if($_REQUEST['bucket']!=''){
			if($_REQUEST['bucket']== "0"){
				if($_REQUEST['cap']==''){$resCode='4';$mess="Local Conveyance : Select Capacity";$resMsg=$mess;}
				else if($_REQUEST['quantityCell']==''){$resCode='4';$mess="Local Conveyance : Enter Quantity";$resMsg=$mess;}
				else if($_REQUEST['numKilometers']==''){$resCode='4';$mess="Local Conveyance : Enter No.of Kilometers";$resMsg=$mess;}
				else if($_REQUEST['dot_l']==''){$resCode='4';$mess="Local Conveyance : Select Date of travel";$resMsg=$mess;}
				else if($_REQUEST['from_l']==''){$resCode='4';$mess="Local Conveyance : Enter From place";$resMsg=$mess;}
				else if($_REQUEST['to_l']==''){$resCode='4';$mess="Local Conveyance : Enter To place";$resMsg=$mess;}
				else if($_REQUEST['mot_l']==''){$resCode='4';$mess="Local Conveyance : Select Mode of travel";$resMsg=$mess;}
				else if($_REQUEST['ticket_idl']==''){$resCode='4';$mess="Local Conveyance : Select Ticket Id";$resMsg=$mess;}
				else if($_REQUEST['dprNum_l']==''){$resCode='4';$mess="Local Conveyance : Enter DPR Number";$resMsg=$mess;}
				else if($_REQUEST['amt_l']=='' || $_REQUEST['amt_l']=='0'){$resCode='4';$mess="Local Conveyance : Amount Required";$resMsg=$mess;}
				else $mess=1;
			}else{
				if($_REQUEST['dot_l']==''){$resCode='4';$mess="Local Conveyance : Select Date of travel";$resMsg=$mess;}
				else if($_REQUEST['from_l']==''){$resCode='4';$mess="Local Conveyance : Enter From place";$resMsg=$mess;}
				else if($_REQUEST['to_l']==''){$resCode='4';$mess="Local Conveyance : Enter To place";$resMsg=$mess;}
				else if($_REQUEST['mot_l']==''){$resCode='4';$mess="Local Conveyance : Select Mode of travel";$resMsg=$mess;}
				else if($_REQUEST['ticket_idl']==''){$resCode='4';$mess="Local Conveyance : Select Ticket Id";$resMsg=$mess;}
				else if($_REQUEST['dprNum_l']==''){$resCode='4';$mess="Local Conveyance : Enter DPR Number";$resMsg=$mess;}
				else if($_REQUEST['amt_l']=='' || $_REQUEST['amt_l']=='0'){$resCode='4';$mess="Local Conveyance : Amount Required";$resMsg=$mess;}
				else $mess=1;
			}
		}else $mess=1;
		if($mess!=1){ echo return_false($resMsg); exit;}
		if($mess==1){
			$loc_alias=$_REQUEST['idc_l'];
			$reqdate=date("Y-m-d");
			$f2=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['dot_l'])));
			$f3=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mot_l']));
			$f4=mysqli_real_escape_string($mr_con,$_REQUEST['from_l']);
			$f5=mysqli_real_escape_string($mr_con,$_REQUEST['to_l']);
			$f6=mysqli_real_escape_string($mr_con,$_REQUEST['amt_l']);
			$f7=mysqli_real_escape_string($mr_con,$_REQUEST['zone_l']);
			$f8=mysqli_real_escape_string($mr_con,$_REQUEST['state_l']);
			$f9=mysqli_real_escape_string($mr_con,$_REQUEST['district_l']);
			$f10=mysqli_real_escape_string($mr_con,$_REQUEST['area_l']);
			$f11=mysqli_real_escape_string($mr_con,$_REQUEST['bucket']);
			if($f11 == '0'){
				$f12=mysqli_real_escape_string($mr_con,$_REQUEST['cap']);
				$f13=mysqli_real_escape_string($mr_con,$_REQUEST['wofCell']);
				$f14=mysqli_real_escape_string($mr_con,$_REQUEST['quantityCell']);
				$f15=mysqli_real_escape_string($mr_con,$_REQUEST['numKilometers']);
			} else {
				$f12='';
				$f13='';
				$f14='';
				$f15='';
			}
			$f16=mysqli_real_escape_string($mr_con,$_REQUEST['dprNum_l']);
			$f17=mysqli_real_escape_string($mr_con,$_REQUEST['ticket_idl']);
			$prev_amt=mysqli_real_escape_string($mr_con,$_REQUEST['prev_amt']);
			$ealias=mysqli_real_escape_string($mr_con,$_REQUEST['expenses_alias']);
			if($loc_alias !=''){
				$up=mysqli_query($mr_con,"UPDATE ec_localconveyance SET date_of_travel='".$f2."', mode_of_travel='".$f3."', from_place='".$f4."', to_place='".$f5."', amount='".$f6."', created_date='$reqdate', zone_alias='".$f7."', state_alias='".$f8."', district_alias='".$f9."', bucket='".$f11."', capacity='".$f12."', quantity='".$f14."', km='".$f15."',dpr_number='".$f16."',ticket_alias='".$f17."'
				 WHERE alias='".$loc_alias."'");
					if($up){
						$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$ealias."'");
						$sel_rs=mysqli_fetch_array($sel);
						$texp=$sel_rs['total_tour_expenses'];
						$upval=$texp-$prev_amt+$f6;
						$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$ealias."'");
					}
				 if($up){
					 	$action = "Expence bill number: ".ebill($ealias)." updated.";
						user_history($emp_alias,$action,$ip_addr);
					 	$resCode = '0';$resMsg="Updated successfully";
					} else{$resCode = '4';$resMsg="Update Failed";}
			}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function loc_single_view(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		$loc_alias=$_REQUEST['alias'];
		$lcsql=mysqli_query($mr_con,"SELECT expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,created_date,zone_alias,state_alias,district_alias,bucket,capacity,quantity,km,dpr_number,ticket_alias FROM ec_localconveyance WHERE alias='$loc_alias' AND flag=0");
		if(mysqli_num_rows($lcsql)){
			$lrow = mysqli_fetch_array($lcsql);
			$result['expenses_alias']=$lrow['expenses_alias'];	
			$result['date_of_travel']=date("d-m-Y", strtotime($lrow['date_of_travel']));			
			$result['mode_of_travel']=$lrow['mode_of_travel'];
			$result['from_place']=$lrow['from_place'];
			$result['to_place']=$lrow['to_place'];
			$result['amount']=$lrow['amount'];
			$result['alias']=$lrow['alias'];
			$result['created_date']=$lrow['created_date'];
			$result['zone_alias']=$lrow['zone_alias'];
			$result['zone_name']=getNames($lrow['zone_alias'],'ec_zone');
			$result['state_alias']=$lrow['state_alias'];
			$result['state_name']=getNames($lrow['state_alias'],'ec_state');
			$result['district_alias']=$lrow['district_alias'];	
			$result['district_name']=getNames($lrow['district_alias'],'ec_district');	
			if($lrow['bucket'] ==0)$bucket = 'Secondary transportation';else if($lrow['bucket']  ==1) $bucket = 'Local Conveyance'; else $bucket ='';
			$result['bucket']=$bucket;
			$result['bucket_val']=$lrow['bucket'];
			if(getWeights($lrow['capacity'],'product') != 0) $capacity=getWeights($lrow['capacity'],'product'); else $capacity='';
			$result['capacity']=$capacity;	
			$result['capacity_val']=$lrow['capacity'];	
			if(getWeights($lrow['capacity'],'weight')!= 0) $weight=getWeights($lrow['capacity'],'weight'); else $weight='';				
			$result['weight']=$weight;	
			$result['quantity']=$lrow['quantity'];
			$result['km']=$lrow['km'];
			$result['dpr_number']=$lrow['dpr_number'];
			$result['ticket_alias']=$lrow['ticket_alias'];
			if($lrow['ticket_alias'] == "1") $loc_ticket_name="Others"; else $loc_ticket_name=getTicketName($lrow['ticket_alias']);
			$result['ticket_val']=$loc_ticket_name;
			if(getArea($lrow['district_alias'])==0){
				$result['area']='PLAIN AREA';
				 $result['amount_appli'] = '0.02';}
			else if(getArea($lrow['district_alias'])==1)
			{$result['area']='HILLY AREA'; 
			$result['amount_appli'] ='0.04';
			}else{
			$result['area']=''; 
			$result['amount_appli'] = '';
			}
		}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function oth_loc_single_add(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		//Local Conveyance Validation
		for($i=0;$i<count($_REQUEST['dot_l']);$i++){
			if($_REQUEST['dot_l'][$i]=='' && $_REQUEST['mot_l'][$i]=='' && $_REQUEST['from_l'][$i]=='' && $_REQUEST['to_l'][$i]=='' && $_REQUEST['amt_l'][$i]=='')	{
				$mess=1;
			}else{
				if($_REQUEST['dot_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select Date of travel";$resMsg=$mess;}
				else if($_REQUEST['mot_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Select Mode of travel";$resMsg=$mess;}
				else if($_REQUEST['from_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Enter From place";$resMsg=$mess;}
				else if($_REQUEST['to_l'][$i]==''){$resCode='4';$mess="Local Conveyance" .($i+1). ": Enter To place";$resMsg=$mess;}
				else if($_REQUEST['amt_l'][$i]=='' || $_REQUEST['amt_l'][$i]=='0'){$resCode='4';$mess="Local Conveyance" .($i+1). ": Amount Required";$resMsg=$mess;}
				else $mess=1;
			}if($mess!=1){ echo return_false($resMsg); exit;}
		}
		if($mess==1){
			if((mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_loc'])=="")||(mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_loc'])=='0')){$res=$mess="Enter Local Conveyance Details";}
		}
		if($mess==1){
			$exp_alias=$_REQUEST['alias'];
			$reqdate=date("Y-m-d");
			for($i=0;$i<count($_REQUEST['amt_l']);$i++){
				$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['dot_l'][$i]))));
				$fa[$i]=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mot_l'][$i]));
				$fb[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['from_l'][$i]);
				$fc[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['to_l'][$i]);
				$fd[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['amt_l'][$i]);
				$alias1=aliasCheck(generateRandomString(),"ec_localconveyance","alias");
				if($_REQUEST['dot_l'][$i]!='' && $_REQUEST['mot_l'][$i]!='' && $_REQUEST['from_l'][$i]!='' && $_REQUEST['to_l'][$i]!='' && $_REQUEST['amt_l'][$i]!='')	{
					$ins=mysqli_query($mr_con,"INSERT INTO ec_localconveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,created_date) VALUES('$exp_alias','$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$alias1','$reqdate')");
					if($ins){
						$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$exp_alias."'");
						$sel_rs=mysqli_fetch_array($sel);
						$texp=$sel_rs['total_tour_expenses'];
						$upval=$texp+$fd[$i];
						$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$exp_alias."'");
					}
				}
			}
			if($ins){
				$action = "Expence bill number: ".ebill($exp_alias)." updated.";
				user_history($emp_alias,$action,$ip_addr);
				$resCode='0';$resMsg='Inserted Successfully';}else{$resCode='4';$resMsg='Failed';}		
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function oth_loc_single_edit(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		//Local Conveyance Validation
		if($_REQUEST['dot_l']==''){$resCode='4';$mess="Local Conveyance : Select Date of travel";$resMsg=$mess;}
		else if($_REQUEST['mot_l']==''){$resCode='4';$mess="Local Conveyance : Select Mode of travel";$resMsg=$mess;}
		else if($_REQUEST['from_l']==''){$resCode='4';$mess="Local Conveyance : Enter From place";$resMsg=$mess;}
		else if($_REQUEST['to_l']==''){$resCode='4';$mess="Local Conveyance : Enter To place";$resMsg=$mess;}
		else if($_REQUEST['amt_l']=='' || $_REQUEST['amt_l']=='0'){$resCode='4';$mess="Local Conveyance" .($i+1). ": Amount Required";$resMsg=$mess;}
		else $mess=1;
		if($mess!=1){ echo return_false($resMsg); exit;}
		if($mess==1){
			$loc_alias=$_REQUEST['idc_l'];
			$reqdate=date("Y-m-d");
			$f2=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['dot_l'])));
			$f3=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mot_l']));
			$f4=mysqli_real_escape_string($mr_con,$_REQUEST['from_l']);
			$f5=mysqli_real_escape_string($mr_con,$_REQUEST['to_l']);
			$f6=mysqli_real_escape_string($mr_con,$_REQUEST['amt_l']);
			$prev_amt=mysqli_real_escape_string($mr_con,$_REQUEST['prev_amt']);
			$ealias=mysqli_real_escape_string($mr_con,$_REQUEST['expenses_alias']);
			if($loc_alias !=''){
				$up=mysqli_query($mr_con,"UPDATE ec_localconveyance SET date_of_travel='".$f2."', mode_of_travel='".$f3."', from_place='".$f4."', to_place='".$f5."', amount='".$f6."', created_date='$reqdate' WHERE alias='".$loc_alias."'");
					if($up){
						$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$ealias."'");
						$sel_rs=mysqli_fetch_array($sel);
						$texp=$sel_rs['total_tour_expenses'];
						$upval=$texp-$prev_amt+$f6;
						$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$ealias."'");
					}
				 if($up){
					$action = "Expence bill number: ".ebill($ealias)." updated.";
					user_history($emp_alias,$action,$ip_addr);
					 $resCode = '0';$resMsg="Updated successfully";} else{$resCode = '4';$resMsg="Update Failed";}
			}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
// End - Local Conveyance
// Start - Conveyance
function ser_con_single_add(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$chk=authentication($emp_alias,$token);
	$fault =array();
	if($chk=='0'){
		for($i=0;$i<count($_REQUEST['dot']);$i++){
			if($_REQUEST['dot'][$i] == '' && $_REQUEST['mot'][$i] == '' && $_REQUEST['from'][$i] == '' && $_REQUEST['to'][$i] =='' && $_REQUEST['cticket_id'][$i]=='' && $_REQUEST['cdprno'][$i]=='' && $_FILES['motbill']['name'][$i]=='' && $_REQUEST['amt'][$i]=='')	{
				$mess=1;
			}else{
				if($_REQUEST['dot'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Select Date of travel";$resMsg=$mess;}
				else if($_REQUEST['mot'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Select Mode of travel";$resMsg=$mess;}
				else if($_REQUEST['from'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Enter From place";$resMsg=$mess;}
				else if($_REQUEST['to'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Enter To place";$resMsg=$mess;}
				else if($_REQUEST['cticket_id'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Select Ticket Id";$resMsg=$mess;}
				else if($_REQUEST['cdprno'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Enter DPR Number";$resMsg=$mess;}
				else if($_FILES['motbill']['name'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Select File";$resMsg=$mess;}
				else if($_FILES['motbill']['name'][$i]!='' && $_FILES['motbill']['size'][$i]>5767168){$resCode='4';$mess="Conveyance" .($i+1). ": File Size Should be less than or equal to 5MB ";$resMsg=$mess;}
				else if($_REQUEST['amt'][$i]=='' || $_REQUEST['amt'][$i]=='0'){$resCode='4';$mess="Conveyance" .($i+1). ": Amount Required";$resMsg=$mess;}
				else $mess=1;
			}if($mess!=1){ echo return_false($resMsg); exit;}
		}
		if($mess==1){if(mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_con'])=="" || mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_con'])=='0'){$res=$mess="Enter Conveyance Details";}}
		if($mess==1){
			$con_alias=$_REQUEST['alias'];
			$reqdate=date("Y-m-d");
			for($i=0;$i<count($_REQUEST['amt']);$i++){
				$f2[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['dot'][$i])));
				$f3[$i]=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mot'][$i]));
				$f4[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['from'][$i]);
				$f5[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['to'][$i]);
				$f6[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['amt'][$i]);
				$f7[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['cdprno'][$i]);
				$f8[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['cticket_id'][$i]);
				if($_FILES['motbill']['size'][$i]>0){
					$ext = pathinfo($_FILES['motbill']['name'][$i], PATHINFO_EXTENSION);
					$fileName=$emp_alias.generateRandomString()."TC.".$ext;
					$move=move_uploaded_file($_FILES["motbill"]["tmp_name"][$i],"../../attachments/".$fileName);
					if($move){
						$profileimg = "attachments/".$fileName;
						$alias1=aliasCheck(generateRandomString(),"ec_conveyance","alias");
						if($_REQUEST['dot'][$i] != '' && $_REQUEST['mot'][$i] != '' && $_REQUEST['from'][$i] != '' && $_REQUEST['to'][$i] !='' && $_REQUEST['cticket_id'][$i]!='' && $_REQUEST['cdprno'][$i]!='' && $_FILES['motbill']['name'][$i]!='' && $_REQUEST['amt'][$i]!=''){
							$ins=mysqli_query($mr_con,"INSERT INTO ec_conveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,document_link,created_date,dpr_number,ticket_alias) VALUES('$con_alias','$f2[$i]','$f3[$i]','$f4[$i]','$f5[$i]','$f6[$i]','$alias1','$profileimg','$reqdate','$f7[$i]','$f8[$i]')");
							if($ins){
								$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$con_alias."'");
								$sel_rs=mysqli_fetch_array($sel);
								$texp=$sel_rs['total_tour_expenses'];
								$upval=$texp+$f6[$i];
								$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$con_alias."'");
							}
						}
					}else{
						array_push($fault,$_FILES['motbill']['name'][$i]);
					}
				}
			}
			if(count($fault)!='0'){
				$action = "Expence bill number: ".ebill($con_alias)." updated.";
				user_history($emp_alias,$action,$ip_addr);
				$resCode='0';
				$resMsg="Some Files could not be uploaded.Kindly Resubmit from Drafts.";
			}else{
				if($ins){
				$action = "Expence bill number: ".ebill($con_alias)." updated.";
				user_history($emp_alias,$action,$ip_addr);
					$resCode='0';$resMsg="Inserted Successfully";}else{$resCode='4';$resMsg='Failed';}	
			}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}

	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function oth_con_single_add(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$chk=authentication($emp_alias,$token);
	$fault =array();
	if($chk=='0'){
		//Conveyance Validation
		for($i=0;$i<count($_REQUEST['dot']);$i++){
			if($_REQUEST['dot'][$i] == '' && $_REQUEST['mot'][$i] == '' && $_REQUEST['from'][$i] == '' && $_REQUEST['to'][$i] =='' && $_FILES['motbill']['name'][$i]=='' && $_REQUEST['amt'][$i]=='')	{
				$mess=1;
			}else{
				if($_REQUEST['dot'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Select Date of travel";$resMsg=$mess;}
				else if($_REQUEST['mot'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Select Mode of travel";$resMsg=$mess;}
				else if($_REQUEST['from'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Enter From place";$resMsg=$mess;}
				else if($_REQUEST['to'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Enter To place";$resMsg=$mess;}
/*				else if($_FILES['motbill']['name'][$i]==''){$resCode='4';$mess="Conveyance" .($i+1). ": Select File";$resMsg=$mess;}
*/				else if($_FILES['motbill']['name'][$i]!='' && $_FILES['motbill']['size'][$i]>5767168){$resCode='4';$mess="Conveyance" .($i+1). ": File Size Should be less than or equal to 5MB ";$resMsg=$mess;}
				else if($_REQUEST['amt'][$i]=='' || $_REQUEST['amt'][$i]=='0'){$resCode='4';$mess="Conveyance" .($i+1). ": Amount Required";$resMsg=$mess;}
				else $mess=1;
			}if($mess!=1){ echo return_false($resMsg); exit;}
		}
		if($mess==1){if(mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_con'])=="" || mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_con'])=='0'){$res=$mess="Enter Conveyance Details";}}
		if($mess==1){
			$alias=$_REQUEST['alias'];
			$reqdate=date("Y-m-d");
			for($i=0;$i<count($_REQUEST['amt']);$i++){
				$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['dot'][$i]))));
				$fa[$i]=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mot'][$i]));
				$fb[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['from'][$i]);
				$fc[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['to'][$i]);
				$fd[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['amt'][$i]);
				if($_FILES['motbill']['size'][$i]>'0'){
					$ext = pathinfo($_FILES['motbill']['name'][$i], PATHINFO_EXTENSION);
					$fileName=$emp_alias.generateRandomString()."TC.".$ext;
					$move=move_uploaded_file($_FILES["motbill"]["tmp_name"][$i],"../../attachments/".$fileName);
					if($move){
						$profileimg = "attachments/".$fileName;
						$alias1=aliasCheck(generateRandomString(),"ec_conveyance","alias");
						if($_REQUEST['dot'][$i] != '' && $_REQUEST['mot'][$i] != '' && $_REQUEST['from'][$i] != '' && $_REQUEST['to'][$i] !='' && $_FILES['motbill']['name'][$i]!='' && $_REQUEST['amt'][$i]!=''){
						$ins=mysqli_query($mr_con,"INSERT INTO ec_conveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,document_link,created_date) VALUES('$alias','$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$alias1','$profileimg','$reqdate')");
						if($ins){
							$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$alias."'");
							$sel_rs=mysqli_fetch_array($sel);
							$texp=$sel_rs['total_tour_expenses'];
							$upval=$texp+$fd[$i];
							$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$alias."'");
						}
					}
					}else {array_push($fault,$_FILES['motbill']['name'][$i]);}
				}else{
						$profileimg = "0";
						$alias1=aliasCheck(generateRandomString(),"ec_conveyance","alias");
						if($_REQUEST['dot'][$i] != '' && $_REQUEST['mot'][$i] != '' && $_REQUEST['from'][$i] != '' && $_REQUEST['to'][$i] !='' && $_REQUEST['amt'][$i]!=''){
						$ins=mysqli_query($mr_con,"INSERT INTO ec_conveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,document_link,created_date) VALUES('$alias','$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$alias1','$profileimg','$reqdate')");
						if($ins){
							$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$alias."'");
							$sel_rs=mysqli_fetch_array($sel);
							$texp=$sel_rs['total_tour_expenses'];
							$upval=$texp+$fd[$i];
							$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$alias."'");
						}
				}
				}
			}
			if(count($fault)!='0'){
				$action = "Expence bill number: ".ebill($alias)." updated.";
				user_history($emp_alias,$action,$ip_addr);
				$resCode='0';
				$resMsg="Some Files could not be uploaded.Kindly Resubmit from Drafts.";
			}else{
				if($ins){
				$action = "Expence bill number: ".ebill($alias)." updated.";
				user_history($emp_alias,$action,$ip_addr);
					$resCode='0';$resMsg="Inserted Successfully";}else{$resCode='4';$resMsg='Failed';}	
			}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function con_single_view(){	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		$con_alias=$_REQUEST['alias'];
		$csql=mysqli_query($mr_con,"SELECT expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,document_link,created_date,dpr_number,ticket_alias FROM ec_conveyance WHERE alias='$con_alias' AND flag=0");
		if(mysqli_num_rows($csql)){
			$row = mysqli_fetch_array($csql);
			$url_path='';
			$result['expenses_alias']=$row['expenses_alias'];	
			$result['date_of_travel']=date("d-m-Y", strtotime($row['date_of_travel']));				
			$result['mode_of_travel']=$row['mode_of_travel'];
			$result['from_place']=$row['from_place'];
			$result['to_place']=$row['to_place'];
			$result['amount']=$row['amount'];
			$result['alias']=$row['alias'];
			if($row['document_link']!=='0' && $row['document_link']!=''){$con_link=urllink($row['created_date']).$row['document_link'];}else{$con_link='';}
			$result['document_link']=$con_link;
			$result['hidden_document_link']=$row['document_link'];
			if($row['dpr_number'] != '') $con_dpr = $row['dpr_number'];else $con_dpr = '--';
			$result['dpr_number']=$con_dpr;
			if($row['ticket_alias'] != ''){ if($row['ticket_alias'] == "1") $con_ticket_name="Others"; else $con_ticket_name=getTicketName($row['ticket_alias']);}else {$con_ticket_name='--';}
			$result['ticket_alias']=$row['ticket_alias'];
			$result['ticket_val']=$con_ticket_name;
		}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function ser_con_single_edit(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		if($_REQUEST['dot']==''){$resCode='4';$mess="Conveyance : Select Date of travel";$resMsg=$mess;}
		else if($_REQUEST['mot']==''){$resCode='4';$mess="Conveyance : Select Mode of travel";$resMsg=$mess;}
		else if($_REQUEST['from']==''){$resCode='4';$mess="Conveyance : Enter From place";$resMsg=$mess;}
		else if($_REQUEST['to']==''){$resCode='4';$mess="Conveyance : Enter To place";$resMsg=$mess;}
		else if($_REQUEST['cticket_id']==''){$resCode='4';$mess="Conveyance : Select Ticket Id";$resMsg=$mess;}
		else if($_REQUEST['cdprno']==''){$resCode='4';$mess="Conveyance : Enter DPR Number";$resMsg=$mess;}
		else if($_FILES['motbill']['name']=='' && ($_REQUEST['motbill_old']=='' || $_REQUEST['motbill_old']=='0')){$resCode='4';$mess="Conveyance : Select File";$resMsg=$mess;}
		else if($_FILES['motbill']['name']!='' && $_FILES['motbill']['size']>5767168){$resCode='4';$mess="Conveyance : File Size Should be less than or equal to 5MB ";$resMsg=$mess;}
		else if($_REQUEST['amt']=='' || $_REQUEST['amt']=='0'){$resCode='4';$mess="Conveyance : Amount Required";$resMsg=$mess;}
		else $mess=1;
		if($mess!=1){ echo return_false($resMsg); exit;}
		if($mess==1){
			$reqdate=date("Y-m-d");
			$f1=mysqli_real_escape_string($mr_con,$_REQUEST['idc']);
			$f2=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['dot'])));
			$f3=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mot']));
			$f4=mysqli_real_escape_string($mr_con,$_REQUEST['from']);
			$f5=mysqli_real_escape_string($mr_con,$_REQUEST['to']);
			$f6=mysqli_real_escape_string($mr_con,$_REQUEST['amt']);
			$f7=mysqli_real_escape_string($mr_con,$_REQUEST['cdprno']);
			$f8=mysqli_real_escape_string($mr_con,$_REQUEST['cticket_id']);
			$prev_amt=mysqli_real_escape_string($mr_con,$_REQUEST['prev_amt']);
			$ealias=mysqli_real_escape_string($mr_con,$_REQUEST['expenses_alias']);
			if($_FILES['motbill']['size']>0){
				$ext = pathinfo($_FILES['motbill']['name'], PATHINFO_EXTENSION);
				$fileName=$emp_alias.generateRandomString()."TC.".$ext;
				$move = move_uploaded_file($_FILES["motbill"]["tmp_name"],"../../attachments/".$fileName);
				if($move){
					$profileimg = "attachments/".$fileName;
					if($_REQUEST['motbill_old']!=='0') unlink("../../".$_REQUEST['motbill_old']);
				}else{$profileimg = ""; array_push($fault,$_FILES['motbill']['name']);}
			}else{
				$profileimg=$_REQUEST['motbill_old'];
			}
			if($profileimg != ''){
				$up=mysqli_query($mr_con,"UPDATE ec_conveyance SET 
				date_of_travel='".$f2."',
				mode_of_travel='".$f3."',
				from_place='".$f4."', 
				to_place='".$f5."', 
				amount='".$f6."', 
				document_link='".$profileimg."',
				dpr_number='".$f7."',
				ticket_alias='".$f8."',
				created_date='".$reqdate."' 
				WHERE alias='".$f1."'");
					if($up){
						$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$ealias."'");
						$sel_rs=mysqli_fetch_array($sel);
						$texp=$sel_rs['total_tour_expenses'];
						$upval=$texp-$prev_amt+$f6;
						$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$ealias."'");
					}
			}
			if($up){
				$action = "Expence bill number: ".ebill($ealias)." updated.";
				user_history($emp_alias,$action,$ip_addr);
				$resCode = '0';$resMsg="Updated successfully";} else{$resCode = '4';$resMsg="Update Failed";}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function oth_con_single_edit(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		if($_REQUEST['dot']==''){$resCode='4';$mess="Conveyance : Select Date of travel";$resMsg=$mess;}
		else if($_REQUEST['mot']==''){$resCode='4';$mess="Conveyance : Select Mode of travel";$resMsg=$mess;}
		else if($_REQUEST['from']==''){$resCode='4';$mess="Conveyance : Enter From place";$resMsg=$mess;}
		else if($_REQUEST['to']==''){$resCode='4';$mess="Conveyance : Enter To place";$resMsg=$mess;}
/*		else if($_FILES['motbill']['name']=='' && ($_REQUEST['motbill_old']=='' || $_REQUEST['motbill_old']=='0')){$resCode='4';$mess="Conveyance : Select File";$resMsg=$mess;}
*/		else if($_FILES['motbill']['name']!='' && $_FILES['motbill']['size']>5767168){$resCode='4';$mess="Conveyance : File Size Should be less than or equal to 5MB ";$resMsg=$mess;}
		else if($_REQUEST['amt']=='' || $_REQUEST['amt']=='0'){$resCode='4';$mess="Conveyance : Amount Required";$resMsg=$mess;}
		else $mess=1;
		if($mess!=1){ echo return_false($resMsg); exit;}
		if($mess==1){
			$reqdate=date("Y-m-d");
			$f1=mysqli_real_escape_string($mr_con,$_REQUEST['idc']);
			$f2=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['dot'])));
			$f3=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mot']));
			$f4=mysqli_real_escape_string($mr_con,$_REQUEST['from']);
			$f5=mysqli_real_escape_string($mr_con,$_REQUEST['to']);
			$f6=mysqli_real_escape_string($mr_con,$_REQUEST['amt']);
			$prev_amt=mysqli_real_escape_string($mr_con,$_REQUEST['prev_amt']);
			$ealias=mysqli_real_escape_string($mr_con,$_REQUEST['expenses_alias']);
			if($_FILES['motbill']['size']>0){
				$ext = pathinfo($_FILES['motbill']['name'], PATHINFO_EXTENSION);
				$fileName=$emp_alias.generateRandomString()."TC.".$ext;
				$move = move_uploaded_file($_FILES["motbill"]["tmp_name"],"../../attachments/".$fileName);
				if($move){
					$profileimg = "attachments/".$fileName;
					if($_REQUEST['motbill_old']!=='0') unlink("../../".$_REQUEST['motbill_old']);
				}else{$profileimg = ""; array_push($fault,$_FILES['motbill']['name']);}
			}else{
				$profileimg=$_REQUEST['motbill_old'];
			}
			if($profileimg != ''){
				$up=mysqli_query($mr_con,"UPDATE ec_conveyance SET 
					date_of_travel='".$f2."',
					mode_of_travel='".$f3."',
					from_place='".$f4."', 
					to_place='".$f5."', 
					amount='".$f6."', 
					document_link='".$profileimg."', 
					created_date='".$reqdate."' 
					WHERE alias='".$f1."'");
					if($up){
						$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$ealias."'");
						$sel_rs=mysqli_fetch_array($sel);
						$texp=$sel_rs['total_tour_expenses'];
						$upval=$texp-$prev_amt+$f6;
						$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$ealias."'");
					}
			}
			if($up){
				$action = "Expence bill number: ".ebill($ealias)." updated.";
				user_history($emp_alias,$action,$ip_addr);
				$resCode = '0';$resMsg="Updated successfully";} else{$resCode = '4';$resMsg="Update Failed";}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
// End - Conveyance
// Start - Lodging
function ser_lod_single_add(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		$fault =array();
		for($i=0;$i<count($_REQUEST['checkin']);$i++){
			if($_REQUEST['checkin'][$i] == '' && $_REQUEST['checkout'][$i] == '' && $_REQUEST['zone_ld'][$i] == '' && $_REQUEST['state_ld'][$i] == '' && $_REQUEST['district_ld'][$i] == '' && $_REQUEST['hotelName'][$i] == '' && $_REQUEST['ticket_idld'][$i]=='' && $_REQUEST['dprNum_ld'][$i]=='' && $_REQUEST['lamt'][$i]=='')	{
				$mess=1;
			}else{
				if($_REQUEST['typeofstay'][$i]==''){$resCode='4';$mess="Lodging : Select Type of Stay";$resMsg=$mess;}
				else if($_REQUEST['checkin'][$i]==''){$resCode='4';$mess="Lodging" .($i+1). ": Select Check In Date";$resMsg=$mess;}
				else if($_REQUEST['checkout'][$i]==''){$resCode='4';$mess="Lodging" .($i+1). ": Select Check Out Date";$resMsg=$mess;}
				else if($_REQUEST['ticket_idld'][$i]==''){$resCode='4';$mess="Lodging" .($i+1). ": Select Ticket Id";$resMsg=$mess;}
				else if($_REQUEST['dprNum_ld'][$i]==''){$resCode='4';$mess="Lodging" .($i+1). ": Enter DPR Number";$resMsg=$mess;}
				else if($_REQUEST['lamt'][$i]=='' || $_REQUEST['lamt'][$i]=='0'){$resCode='4';$mess="Lodging" .($i+1). ": Amount Required";$resMsg=$mess;}
				else if($_FILES['lfile']['name'][$i]!='' && $_FILES['lfile']['size'][$i] > 5767168){$resCode='4';$mess="Lodging : File Size Should be less than or equal to 5MB ";$resMsg=$mess;}
				else $mess=1;
				if($_REQUEST['typeofstay'][$i]=='Self'){
					if($_REQUEST['zone_ld'][$i]==''){$resCode='4';$mess="Lodging : Select Zone";$resMsg=$mess;}
					else if($_REQUEST['state_ld'][$i]==''){$resCode='4';$mess="Lodging : Select State";$resMsg=$mess;}
					else if($_REQUEST['district_ld'][$i]==''){$resCode='4';$mess="Lodging : Select District";$resMsg=$mess;}
				}
				else if($_REQUEST['typeofstay'][$i]=='Reimbursement'){
					if($_REQUEST['hotelName'][$i]==''){$resCode='4';$mess="Lodging : Enter Hotel Name";$resMsg=$mess;}
					else if($_FILES['lfile']['size'][$i]==0){$resCode='4';$mess="Lodging" .($i+1). ": Document is mandatory for stay type Reimbursement";$resMsg=$mess;}
				}
			}if($mess!=1){ echo return_false($resMsg); exit;}
		}
		if($mess==1){if(mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_lod'])=="" || mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_lod'])=='0'){$res=$mess="Enter Lodging Details";}}
		
		if($mess==1){
			$lod_alias=$_REQUEST['alias'];
			$reqdate=date("Y-m-d");
			for($i=0;$i<count($_REQUEST['lamt']);$i++){
				$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkin'][$i]))));
				$fa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkout'][$i]))));
				$fb[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['typeofstay'][$i]);
				$fc[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['hotelName'][$i]);
				$fd[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['lamt'][$i]);
				$fe[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['zone_ld'][$i]);
				$ff[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state_ld'][$i]);
				$fg[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['district_ld'][$i]);
				$fh[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['dprNum_ld'][$i]);
				$fi[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['ticket_idld'][$i]);
				$profileimg =0;
				$alias1=aliasCheck(generateRandomString(),"ec_lodging","alias");
				if($_REQUEST['checkin'][$i] != '' && $_REQUEST['checkout'][$i] != '' &&  $_REQUEST['ticket_idld'][$i]!='' && $_REQUEST['dprNum_ld'][$i]!='' && $_REQUEST['lamt'][$i]!='')	{
					if($_FILES['lfile']['size'][$i]>0){
						$ext = pathinfo($_FILES['lfile']['name'][$i], PATHINFO_EXTENSION);
						$fileName=$emp_alias.generateRandomString()."TL.".$ext;
						$move=move_uploaded_file($_FILES["lfile"]["tmp_name"][$i],"../../attachments/".$fileName);
						if($move) {
							$profileimg = "attachments/".$fileName;
						}
					}
					$q = "INSERT INTO ec_lodging(check_in,check_out,type_of_stay,hotel_name,amount,zone_alias,state_alias,district_alias,dpr_number,expenses_alias,alias,document_link,ticket_alias,created_date) VALUES('$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$fe[$i]','$ff[$i]','$fg[$i]','$fh[$i]','$lod_alias','$alias1','$profileimg','$fi[$i]','$reqdate')";
					$ins=mysqli_query($mr_con, $q);
					if($ins){
						$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$lod_alias."'");
						$sel_rs=mysqli_fetch_array($sel);
						$texp=$sel_rs['total_tour_expenses'];
						$upval=$texp+$fd[$i];
						$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$lod_alias."'");
					}
				}
			}
			if($ins){
				$action = "Expence bill number: ".ebill($lod_alias)." updated.";
				user_history($emp_alias,$action,$ip_addr);
				$resCode='0';$resMsg="Inserted Successfully";
			}else{
				$resCode='4';$resMsg='Failed';
			}	
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function oth_lod_single_add(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		$fault =array();
		for($i=0;$i<count($_REQUEST['typeofstay']);$i++){
			if($_REQUEST['typeofstay'][$i] == '' && $_REQUEST['checkin'][$i] == ''&& $_REQUEST['checkout'][$i] == '' && $_REQUEST['hotelName'][$i] == '' && $_FILES['lfile']['name'][$i] == '' && $_REQUEST['lamt'][$i]=='')	{
				$mess=1;
			}else{
				if($_REQUEST['typeofstay'][$i]==''){$resCode='4';$mess="Lodging" .($i+1). ": Select Type of Stay";$resMsg=$mess;}
				else if($_REQUEST['checkin'][$i]==''){$resCode='4';$mess="Lodging" .($i+1). ": Select Check in Date";$resMsg=$mess;}
				else if($_REQUEST['checkout'][$i]==''){$resCode='4';$mess="Lodging" .($i+1). ": Select Check Out Date";$resMsg=$mess;}
				else if($_REQUEST['hotelName'][$i]==''){$resCode='4';if($_REQUEST['typeofstay'][$i]=='Self'){$mess="Lodging" .($i+1). ": Select State";}else{$mess="Lodging" .($i+1). ": Enter Hotel Name";}$resMsg=$mess;}
/*				else if($_FILES['lfile']['name'][$i]==''){$resCode='4';$mess="Lodging" .($i+1). ": Select File";$resMsg=$mess;}
*/				else if($_FILES['lfile']['name'][$i]!='' && $_FILES['lfile']['size'][$i]>5767168){$resCode='4';$mess="Lodging" .($i+1). ": File Size Should be less than or equal to 5MB ";$resMsg=$mess;}
				else if($_REQUEST['lamt'][$i]=='' || $_REQUEST['lamt'][$i]=='0'){$resCode='4';$mess="Lodging" .($i+1). ": Amount Required";$resMsg=$mess;}
				else $mess=1;
			}if($mess!=1){ echo return_false($resMsg); exit;}
		}
		if($mess==1){if(mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_lod'])=="" || mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_lod'])=='0'){$res=$mess="Enter Lodging Details";}}
		if($mess==1){
			$alias=$_REQUEST['alias'];
			$reqdate=date("Y-m-d");
			for($i=0;$i<count($_REQUEST['lamt']);$i++){
				$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkin'][$i]))));
				$fa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkout'][$i]))));
				$fb[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['typeofstay'][$i]);
				$fc[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['hotelName'][$i]);
				$fd[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['lamt'][$i]);
				if($_FILES['lfile']['size'][$i]>0){
					$ext = pathinfo($_FILES['lfile']['name'][$i], PATHINFO_EXTENSION);
					$fileName=$emp_alias.generateRandomString()."TL.".$ext;
					$move=move_uploaded_file($_FILES["lfile"]["tmp_name"][$i],"../../attachments/".$fileName);
					if($move){
						$profileimg = "attachments/".$fileName;
						$alias1=aliasCheck(generateRandomString(),"ec_lodging","alias");
						if($_REQUEST['typeofstay'][$i] != '' && $_REQUEST['checkin'][$i] != ''&& $_REQUEST['checkout'][$i] != '' && $_REQUEST['hotelName'][$i] != '' && $_FILES['lfile']['name'][$i] != '' && $_REQUEST['lamt'][$i]!='')	{
							$ins=mysqli_query($mr_con,"INSERT INTO ec_lodging(check_in,check_out,type_of_stay,hotel_name,amount,expenses_alias,alias,document_link,created_date) VALUES('$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$alias','$alias1','$profileimg','$reqdate')");
							if($ins){
								$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$alias."'");
								$sel_rs=mysqli_fetch_array($sel);
								$texp=$sel_rs['total_tour_expenses'];
								$upval=$texp+$fd[$i];
								$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$alias."'");
							}
						}
					}else array_push($fault,$_FILES['lfile']['name'][$i]);
				}else{
					$profileimg = "0";
					$alias1=aliasCheck(generateRandomString(),"ec_lodging","alias");
					if($_REQUEST['typeofstay'][$i] != '' && $_REQUEST['checkin'][$i] != ''&& $_REQUEST['checkout'][$i] != '' && $_REQUEST['hotelName'][$i] != ''  && $_REQUEST['lamt'][$i]!='')	{
						$ins=mysqli_query($mr_con,"INSERT INTO ec_lodging(check_in,check_out,type_of_stay,hotel_name,amount,expenses_alias,alias,document_link,created_date) VALUES('$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$alias','$alias1','$profileimg','$reqdate')");
						if($ins){
							$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$alias."'");
							$sel_rs=mysqli_fetch_array($sel);
							$texp=$sel_rs['total_tour_expenses'];
							$upval=$texp+$fd[$i];
							$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$alias."'");
						}
					}
					
				}
			}
			if(count($fault)!='0'){
				$action = "Expence bill number: ".ebill($alias)." updated.";
				user_history($emp_alias,$action,$ip_addr);
				$resCode='0';
				$resMsg="Some Files could not be uploaded.Kindly Resubmit from Drafts.";
			}else{
				if($ins){
				$action = "Expence bill number: ".ebill($alias)." updated.";
				user_history($emp_alias,$action,$ip_addr);
					$resCode='0';$resMsg="Inserted Successfully";}else{$resCode='4';$resMsg='Failed';}	
			}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function lod_single_view(){	
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		$lod_alias=$_REQUEST['alias'];
		$lod_sql=mysqli_query($mr_con,"SELECT expenses_alias,type_of_stay,check_in,check_out,hotel_name,amount,alias,document_link,created_date,zone_alias,state_alias,district_alias,dpr_number,ticket_alias FROM ec_lodging WHERE alias='$lod_alias' AND flag=0");
		if(mysqli_num_rows($lod_sql)){
			$lod_row = mysqli_fetch_array($lod_sql);
			$result['expenses_alias']=$lod_row['expenses_alias'];	
			$result['type_of_stay']=$lod_row['type_of_stay'];				
			$result['check_in']=date("d-m-Y", strtotime($lod_row['check_in']));
			$result['check_out']=date("d-m-Y", strtotime($lod_row['check_out']));
			$result['hotel_name']=$lod_row['hotel_name'];
			$result['amount']=$lod_row['amount'];
			$result['amount1']=$lod_row['amount'];
			$result['alias']=$lod_row['alias'];
			if($lod_row['document_link']!=='0' && $lod_row['document_link']!=''){$lod_link=urllink($lod_row['created_date']).$lod_row['document_link'];}else{$lod_link='';}
			$result['document_link']=$lod_link;
			$result['hidden_document_link']=$lod_row['document_link'];
			$result['created_date']=$lod_row['created_date'];
			if($lod_row['zone_alias'] != ''){$lod_zone = getNames($lod_row['zone_alias'],'ec_zone');}else{$lod_zone = '--';}
			if($lod_row['state_alias'] != ''){$lod_state = getNames($lod_row['state_alias'],'ec_state');}else{$lod_state = '--';}
			if($lod_row['district_alias'] != ''){$lod_district = getNames($lod_row['district_alias'],'ec_district');}else{$lod_district = '--';}
			$result['zone_name']=$lod_zone;
			$result['state_name']=$lod_state;
			$result['district_name']=$lod_district;				
			$result['zone_alias']=$lod_row['zone_alias'];
			$result['state_alias']=$lod_row['state_alias'];
			$result['district_alias']=$lod_row['district_alias'];	
			if($lod_row['ticket_alias'] != ''){ if($lod_row['ticket_alias'] == "1") $lod_ticket_name="Others"; else $lod_ticket_name=getTicketName($lod_row['ticket_alias']);}else {$lod_ticket_name='--';}
			$result['ticket_alias']=$lod_row['ticket_alias'];
			$result['ticket_val']=$lod_ticket_name;				
			if($lod_row['dpr_number'] != '') $lod_dpr = $lod_row['dpr_number'];else $lod_dpr = '--';
			$result['dpr_number']=$lod_dpr;
		}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function ser_lod_single_edit(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		if($_REQUEST['typeofstay']==''){$resCode='4';$mess="Lodging : Select Type of Stay";$resMsg=$mess;}
		else if($_REQUEST['checkin']==''){$resCode='4';$mess="Lodging : Select Check In Date";$resMsg=$mess;}
		else if($_REQUEST['checkout']==''){$resCode='4';$mess="Lodging : Select Check Out Date";$resMsg=$mess;}
		else if($_REQUEST['ticket_idld']==''){$resCode='4';$mess="Lodging : Select Ticket Id";$resMsg=$mess;}
		else if($_REQUEST['dprNum_ld']==''){$resCode='4';$mess="Lodging : Enter DPR Number";$resMsg=$mess;}
		else if($_REQUEST['lamt']=='' || $_REQUEST['lamt']=='0'){$resCode='4';$mess="Lodging : Amount Required";$resMsg=$mess;}
		else $mess=1;
		if($_REQUEST['typeofstay']=='Self'){
			if($_REQUEST['zone_ld']==''){$resCode='4';$mess="Lodging : Select Zone";$resMsg=$mess;}
			else if($_REQUEST['state_ld']==''){$resCode='4';$mess="Lodging : Select State";$resMsg=$mess;}
			else if($_REQUEST['district_ld']==''){$resCode='4';$mess="Lodging : Select District";$resMsg=$mess;}
		}
		else if($_REQUEST['typeofstay']=='Reimbursement'){
			if($_REQUEST['hotelName']==''){$resCode='4';$mess="Lodging : Enter Hotel Name";$resMsg=$mess;}
		}
		if($mess!=1){ echo return_false($resMsg); exit;}
		if($mess==1){
			$reqdate=date("Y-m-d");
			$f1=mysqli_real_escape_string($mr_con,$_REQUEST['idl']);
			$f2=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['checkin'])));
			$f3=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['checkout'])));
			$f4=mysqli_real_escape_string($mr_con,$_REQUEST['typeofstay']);
			$f5=mysqli_real_escape_string($mr_con,$_REQUEST['hotelName']);
			$f6=mysqli_real_escape_string($mr_con,$_REQUEST['lamt']);
			$f7=mysqli_real_escape_string($mr_con,$_REQUEST['zone_ld']);
			$f8=mysqli_real_escape_string($mr_con,$_REQUEST['state_ld']);
			$f9=mysqli_real_escape_string($mr_con,$_REQUEST['district_ld']);
			$f10=mysqli_real_escape_string($mr_con,$_REQUEST['dprNum_ld']);
			$f11=mysqli_real_escape_string($mr_con,$_REQUEST['ticket_idld']);
			$prev_amt=mysqli_real_escape_string($mr_con,$_REQUEST['prev_amt']);
			$ealias=mysqli_real_escape_string($mr_con,$_REQUEST['expenses_alias']);
			$profileimg =0;
			$docQ = "";
			if($_FILES['lfile']['size']>0){
				$ext = pathinfo($_FILES['lfile']['name'][$i], PATHINFO_EXTENSION);
				$fileName=$emp_alias.generateRandomString()."TL.".$ext;
				$move=move_uploaded_file($_FILES["lfile"]["tmp_name"][$i],"../../attachments/".$fileName);
				if($move) {
					$profileimg = "attachments/".$fileName;
					$docQ = ", document_link='$profileimg'";
				}
			}
			if($f1!=''){
				$update = "UPDATE ec_lodging SET check_in='".$f2."',check_out='".$f3."',type_of_stay='".$f4."',hotel_name='".$f5."',amount='".$f6."' ,created_date='$reqdate',zone_alias='".$f7."',state_alias='".$f8."',district_alias='".$f9."',dpr_number='".$f10."',ticket_alias='".$f11."' $docQ WHERE alias='".$f1."'";
				$up=mysqli_query($mr_con, $update);
				if($up){
					$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$ealias."'");
					$sel_rs=mysqli_fetch_array($sel);
					$texp=$sel_rs['total_tour_expenses'];
					$upval=$texp-$prev_amt+$f6;
					$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$ealias."'");
				}
				if($up){
					 $action = "Expence bill number: ".ebill($ealias)." updated.";
					 user_history($emp_alias,$action,$ip_addr);
					 $resCode = '0';$resMsg="Updated successfully";
				} else{
					$resCode = '4';$resMsg="Update Failed";
				}
			}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function oth_lod_single_edit(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		if($_REQUEST['typeofstay']=='Self'){$hoteln=$_REQUEST['hotelName1']; $hmsg="Lodging : Select State";}else if($_REQUEST['typeofstay']=='Reimbursement'){$hoteln=$_REQUEST['hotelName'];$hmsg="Lodging : Enter Hotel Name";}
		if($_REQUEST['typeofstay']==''){$resCode='4';$mess="Lodging : Select Type of Stay";$resMsg=$mess;}
		else if($_REQUEST['checkin']==''){$resCode='4';$mess="Lodging : Select Check in Date";$resMsg=$mess;}
		else if($_REQUEST['checkout']==''){$resCode='4';$mess="Lodging : Select Check Out Date";$resMsg=$mess;}
		else if($hoteln==''){$resCode='4';$mess=$hmsg;$resMsg=$mess;}
/*		else if($_FILES['lfile']['name']=='' && ($_REQUEST['lfile_old']=='' || $_REQUEST['lfile_old']=='0')){$resCode='4';$mess="Lodging : Select File";$resMsg=$mess;}
*/		else if($_FILES['lfile']['name']!='' && $_FILES['lfile']['size']>5767168){$resCode='4';$mess="Lodging : File Size Should be less than or equal to 5MB ";$resMsg=$mess;}
		else if($_REQUEST['lamt']=='' || $_REQUEST['lamt']=='0'){$resCode='4';$mess="Lodging : Amount Required";$resMsg=$mess;}
		else $mess=1;
		if($mess!=1){ echo return_false($resMsg); exit;}
		if($mess==1){
			$fault=array();
			$reqdate=date("Y-m-d");
			$f1=mysqli_real_escape_string($mr_con,$_REQUEST['idl']);
			$f2=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['checkin'])));
			$f3=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['checkout'])));
			$f4=mysqli_real_escape_string($mr_con,$_REQUEST['typeofstay']);
			$f5=$hoteln;
			$f6=mysqli_real_escape_string($mr_con,$_REQUEST['lamt']);
			$prev_amt=mysqli_real_escape_string($mr_con,$_REQUEST['prev_amt']);
			$ealias=mysqli_real_escape_string($mr_con,$_REQUEST['expenses_alias']);
			if($f1 !=''){
				if($_FILES['lfile']['size']>0){
					$ext = pathinfo($_FILES['lfile']['name'], PATHINFO_EXTENSION);
					$fileName=$emp_alias.generateRandomString()."TL.".$ext;
					$move = move_uploaded_file($_FILES["lfile"]["tmp_name"],"../../attachments/".$fileName);
					if($move){ $profileimg = "attachments/".$fileName;
					if($_REQUEST['lfile_old']!=='0') unlink("../../".$_REQUEST['lfile_old']);}else{$profileimg = ""; array_push($fault,$_FILES['lfile']['name']);}
				}else{
					$profileimg=$_REQUEST['lfile_old'];
				}
				if($profileimg != ''){
					$up=mysqli_query($mr_con,"UPDATE ec_lodging SET check_in='".$f2."',check_out='".$f3."',type_of_stay='".$f4."',hotel_name='".$f5."',amount='".$f6."',document_link='$profileimg',created_date='$reqdate' WHERE alias='".$f1."'");
					if($up){
						$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$ealias."'");
						$sel_rs=mysqli_fetch_array($sel);
						$texp=$sel_rs['total_tour_expenses'];
						$upval=$texp-$prev_amt+$f6;
						$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$ealias."'");
					}
				}
				if($up){
					 $action = "Expence bill number: ".ebill($ealias)." updated.";
					 user_history($emp_alias,$action,$ip_addr);					
					$resCode = '0';$resMsg="Updated successfully";} else{$resCode = '4';$resMsg="Update Failed";}
			}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
// End - Lodging
//Start - Boarding
function ser_bod_single_add(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		for($i=0;$i<count($_REQUEST['checkinb']);$i++){
			if($_REQUEST['checkinb'][$i] == '' && $_REQUEST['checkoutb'][$i] == '' && $_REQUEST['zone_bo'][$i] == '' && $_REQUEST['state_bo'][$i] == '' && $_REQUEST['district_bo'][$i] == '' && $_REQUEST['ticket_bo'][$i] == '' && $_REQUEST['dprNum_bo'][$i]=='' && $_REQUEST['bamt'][$i]==''){
				$mess=1;
			}else{
				if($_REQUEST['checkinb'][$i]==''){$resCode='4';$mess="Boarding" .($i+1). ": Select Visit start Date";$resMsg=$mess;}
				else if($_REQUEST['checkoutb'][$i]==''){$resCode='4';$mess="Boarding" .($i+1). ": Select Visit end Date";$resMsg=$mess;}
				else if($_REQUEST['zone_bo'][$i]=='') {$resCode='4';$mess="Boarding" .($i+1). ": Select Zone";$resMsg=$mess;}
				else if($_REQUEST['state_bo'][$i]==''){$resCode='4';$mess="Boarding" .($i+1). ": Select State";$resMsg=$mess;}
				else if($_REQUEST['district_bo'][$i]==''){$resCode='4';$mess="Boarding" .($i+1). ": Select District";$resMsg=$mess;}
				else if($_REQUEST['ticket_bo'][$i]==''){$resCode='4';$mess="Boarding" .($i+1). ": Select Ticket Id";$resMsg=$mess;}
				else if($_REQUEST['dprNum_bo'][$i]==''){$resCode='4';$mess="Boarding" .($i+1). ": Enter DPR Number";$resMsg=$mess;}
				else if($_REQUEST['bamt'][$i]=='' || $_REQUEST['bamt'][$i]=='0'){$resCode='4';$mess="Boarding" .($i+1). ": Amount Required";$resMsg=$mess;}
				else $mess=1;
			}if($mess!=1){ echo return_false($resMsg); exit;}
		}
		if($mess==1){if(mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_bod'])=="" || mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_bod'])=='0'){$res=$mess="Enter Boarding Details";}}
		if($mess==1){
			$bod_alias=$_REQUEST['alias'];
			$reqdate=date("Y-m-d");
			for($i=0;$i<count($_REQUEST['bamt']);$i++){
				$fa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkinb'][$i]))));
				$fb[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkoutb'][$i]))));
				$fc[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state'][$i]);
				$fd[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['bamt'][$i]);
				$fe[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['zone_bo'][$i]);
				$ff[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state_bo'][$i]);
				$fg[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['district_bo'][$i]);
				$fh[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['dprNum_bo'][$i]);
				$fi[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['ticket_bo'][$i]);
				$alias1=aliasCheck(generateRandomString(),"ec_boarding","alias");
				if($_REQUEST['checkinb'][$i] != '' && $_REQUEST['checkoutb'][$i] != '' && $_REQUEST['zone_bo'][$i] != '' && $_REQUEST['state_bo'][$i] != '' && $_REQUEST['district_bo'][$i] != '' && $_REQUEST['ticket_bo'][$i] != '' && $_REQUEST['dprNum_bo'][$i]!='' && $_REQUEST['bamt'][$i]!=''){
					$ins=mysqli_query($mr_con,"INSERT INTO ec_boarding(check_in,check_out,state,amount,zone_alias,state_alias,district_alias,dpr_number,ticket_alias,expenses_alias,alias,created_date) VALUES('$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$fe[$i]','$ff[$i]','$fg[$i]','$fh[$i]','$fi[$i]','$bod_alias','$alias1','$reqdate')");
					if($ins){
						$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$bod_alias."'");
						$sel_rs=mysqli_fetch_array($sel);
						$texp=$sel_rs['total_tour_expenses'];
						$upval=$texp+$fd[$i];
						$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$bod_alias."'");
					}
				}
			}
			if($ins){
				$action = "Expence bill number: ".ebill($bod_alias)." updated.";
				user_history($emp_alias,$action,$ip_addr);
				$resCode='0';$resMsg="Inserted Successfully";}else{$resCode='4';$resMsg='Failed';}	
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function oth_bod_single_add(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		for($i=0;$i<count($_REQUEST['checkinb']);$i++){
			if($_REQUEST['checkinb'][$i] == '' && $_REQUEST['checkoutb'][$i] == '' && $_REQUEST['state'][$i]=='' && $_REQUEST['bamt'][$i]==''){
				$mess=1;
			}else{
				if($_REQUEST['checkinb'][$i]==''){$resCode='4';$mess="Boarding" .($i+1). ": Visit Start Date";$resMsg=$mess;}
				else if($_REQUEST['checkoutb'][$i]==''){$resCode='4';$mess="Boarding" .($i+1). ": Visit End Date";$resMsg=$mess;}
				else if($_REQUEST['state'][$i]=='') {$resCode='4';$mess="Boarding" .($i+1). ": Select State";$resMsg=$mess;}
				else if($_REQUEST['bamt'][$i]=='' || $_REQUEST['bamt'][$i]=='0'){$resCode='4';$mess="Boarding" .($i+1). ": Amount Required";$resMsg=$mess;}
				else $mess=1;
			}if($mess!=1){ echo return_false($resMsg); exit;}
		}
		if($mess==1){if(mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_bod'])=="" || mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_bod'])=='0'){$res=$mess="Enter Boarding Details";}}
		if($mess==1){
			$bod_alias=$_REQUEST['alias'];
			$reqdate=date("Y-m-d");
			for($i=0;$i<count($_REQUEST['bamt']);$i++){
				$fa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkinb'][$i]))));
				$fb[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkoutb'][$i]))));
				$fc[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state'][$i]);
				$fd[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['bamt'][$i]);
				$alias1=aliasCheck(generateRandomString(),"ec_boarding","alias");
				if($_REQUEST['checkinb'][$i] != '' && $_REQUEST['checkoutb'][$i] != '' && $_REQUEST['state'][$i]!='' && $_REQUEST['bamt'][$i]!=''){
					$ins=mysqli_query($mr_con,"INSERT INTO ec_boarding(check_in,check_out,state,amount,expenses_alias,alias,created_date) VALUES('$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$bod_alias','$alias1','$reqdate')");
					if($ins){
						$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$bod_alias."'");
						$sel_rs=mysqli_fetch_array($sel);
						$texp=$sel_rs['total_tour_expenses'];
						$upval=$texp+$fd[$i];
						$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$bod_alias."'");
					}
				}
			}
			if($ins){
				$action = "Expence bill number: ".ebill($bod_alias)." updated.";
				user_history($emp_alias,$action,$ip_addr);
				$resCode='0';$resMsg="Inserted Successfully";}else{$resCode='4';$resMsg='Failed';}	
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function bod_single_view(){	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		$bod_alias=$_REQUEST['alias'];
		$bod_sql=mysqli_query($mr_con,"SELECT expenses_alias,check_in,check_out,state,amount,alias,created_date,zone_alias,state_alias,district_alias,dpr_number,ticket_alias FROM ec_boarding WHERE alias='$bod_alias' AND flag=0");
		if(mysqli_num_rows($bod_sql)){
			$bod_row = mysqli_fetch_array($bod_sql);
			$result['expenses_alias']=$bod_row['expenses_alias'];	
			$result['check_in']=date("d-m-Y", strtotime($bod_row['check_in']));
			$result['check_out']=date("d-m-Y", strtotime($bod_row['check_out']));
			$result['state']=$bod_row['state'];
			$result['amount']=$bod_row['amount'];
			$result['alias']=$bod_row['alias'];
			$result['created_date']=$bod_row['created_date'];
			if($bod_row['zone_alias'] != ''){$bod_zone = getNames($bod_row['zone_alias'],'ec_zone');}else{$bod_zone = '--';}
			if($bod_row['state_alias'] != ''){$bod_state = getNames($bod_row['state_alias'],'ec_state');}else{$bod_state = '--';}
			if($bod_row['district_alias'] != ''){$bod_district = getNames($bod_row['district_alias'],'ec_district');}else{$bod_district = '--';}
			$result['zone_name']=$bod_zone;
			$result['state_name']=$bod_state;
			$result['district_name']=$bod_district;
			$result['zone_alias']=$bod_row['zone_alias'];
			$result['state_alias']=$bod_row['state_alias'];
			$result['district_alias']=$bod_row['district_alias'];	
			if($bod_row['ticket_alias'] != ''){ if($bod_row['ticket_alias'] == "1") $bod_ticket_name="Others"; else $bod_ticket_name=getTicketName($bod_row['ticket_alias']);}else {$bod_ticket_name='--';}
			$result['ticket_val']=$bod_ticket_name;
			$result['ticket_alias']=$bod_row['ticket_alias'];
			if($bod_row['dpr_number'] != '') $bod_dpr = $bod_row['dpr_number'];else $bod_dpr = '--';
			$result['dpr_number']=$bod_dpr;
		}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function ser_bod_single_edit(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		if($_REQUEST['checkinb']==''){$resCode='4';$mess="Boarding : Select  Visit start Date";$resMsg=$mess;}
		else if($_REQUEST['checkoutb']==''){$resCode='4';$mess="Boarding : Select Visit end Date";$resMsg=$mess;}
		else if($_REQUEST['zone_bo']=='') {$resCode='4';$mess="Boarding : Select Zone";$resMsg=$mess;}
		else if($_REQUEST['state_bo']==''){$resCode='4';$mess="Boarding : Select State";$resMsg=$mess;}
		else if($_REQUEST['district_bo']==''){$resCode='4';$mess="Boarding : Select District";$resMsg=$mess;}
		else if($_REQUEST['ticket_bo']==''){$resCode='4';$mess="Boarding : Select Ticket Id";$resMsg=$mess;}
		else if($_REQUEST['dprNum_bo']==''){$resCode='4';$mess="Boarding : Enter DPR Number";$resMsg=$mess;}
		else if($_REQUEST['bamt']=='' || $_REQUEST['bamt']=='0'){$resCode='4';$mess="Boarding : Amount Required";$resMsg=$mess;}
		else $mess=1;
		if($mess!=1){ echo return_false($resMsg); exit;}
		if($mess==1){
			$reqdate=date("Y-m-d");
			$f1=mysqli_real_escape_string($mr_con,$_REQUEST['idb']);
			$f2=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['checkinb'])));
			$f3=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['checkoutb'])));
			$f4=mysqli_real_escape_string($mr_con,$_REQUEST['state']);
			$f5=mysqli_real_escape_string($mr_con,$_REQUEST['bamt']);
			$f6=mysqli_real_escape_string($mr_con,$_REQUEST['zone_bo']);
			$f7=mysqli_real_escape_string($mr_con,$_REQUEST['state_bo']);
			$f8=mysqli_real_escape_string($mr_con,$_REQUEST['district_bo']);
			$f9=mysqli_real_escape_string($mr_con,$_REQUEST['dprNum_bo']);
			$f10=mysqli_real_escape_string($mr_con,$_REQUEST['ticket_bo']);
			$prev_amt=mysqli_real_escape_string($mr_con,$_REQUEST['prev_amt']);
			$ealias=mysqli_real_escape_string($mr_con,$_REQUEST['expenses_alias']);
			if($f1 !=''){
				$up=mysqli_query($mr_con,"UPDATE ec_boarding SET check_in='".$f2."',check_out='".$f3."',state='".$f4."',amount='".$f5."',created_date='$reqdate', zone_alias='".$f6."', state_alias='".$f7."', district_alias='".$f8."', dpr_number='".$f9."',ticket_alias='".$f10."' WHERE alias='".$f1."'");
				 if($up){$resCode = '0';$resMsg="Updated successfully";} else{$resCode = '4';$resMsg="Update Failed";}
				if($up){
					$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$ealias."'");
					$sel_rs=mysqli_fetch_array($sel);
					$texp=$sel_rs['total_tour_expenses'];
					$upval=$texp-$prev_amt+$f5;
					$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$ealias."'");
				}
				if($up){
					$action = "Expence bill number: ".ebill($ealias)." updated.";
					user_history($emp_alias,$action,$ip_addr);
					$resCode = '0';$resMsg="Updated successfully";} else{$resCode = '4';$resMsg="Update Failed";}
			}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function oth_bod_single_edit(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		if($_REQUEST['checkinb']==''){$resCode='4';$mess="Boarding : Visit Start Date";$resMsg=$mess;}
		else if($_REQUEST['checkoutb']==''){$resCode='4';$mess="Boarding : Visit End Date";$resMsg=$mess;}
		else if($_REQUEST['state']=='') {$resCode='4';$mess="Boarding : Select State";$resMsg=$mess;}
		else if($_REQUEST['bamt']=='' || $_REQUEST['bamt']=='0'){$resCode='4';$mess="Boarding : Amount Required";$resMsg=$mess;}
		else $mess=1;
		if($mess!=1){ echo return_false($resMsg); exit;}
		if($mess==1){
			$reqdate=date("Y-m-d");
			$f1=mysqli_real_escape_string($mr_con,$_REQUEST['idb']);
			$f2=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['checkinb'])));
			$f3=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['checkoutb'])));
			$f4=mysqli_real_escape_string($mr_con,$_REQUEST['state']);
			$f5=mysqli_real_escape_string($mr_con,$_REQUEST['bamt']);
			$prev_amt=mysqli_real_escape_string($mr_con,$_REQUEST['prev_amt']);
			$ealias=mysqli_real_escape_string($mr_con,$_REQUEST['expenses_alias']);
			if($f1 !=''){
				$up=mysqli_query($mr_con,"UPDATE ec_boarding SET check_in='".$f2."',check_out='".$f3."',state='".$f4."',amount='".$f5."',created_date='$reqdate' WHERE alias='".$f1."'");
				if($up){
					$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$ealias."'");
					$sel_rs=mysqli_fetch_array($sel);
					$texp=$sel_rs['total_tour_expenses'];
					$upval=$texp-$prev_amt+$f5;
					$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$ealias."'");
				}
				 if($up){
					$action = "Expence bill number: ".ebill($ealias)." updated.";
					user_history($emp_alias,$action,$ip_addr);
					 $resCode = '0';$resMsg="Updated successfully";} else{$resCode = '4';$resMsg="Update Failed";}
			}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
//End - Boarding
//Start - Other Expenses
function ser_oth_single_add(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		$fault=array();
		for($i=0;$i<count($_REQUEST['others']);$i++){
			if($_REQUEST['others'][$i] == '' && $_REQUEST['odate'][$i] == '' && $_FILES['ofile']['name'][$i] == '' && $_REQUEST['ticket_ot'][$i] == '' && $_REQUEST['dprNum_ot'][$i]=='' && $_REQUEST['oamt'][$i]==''){
				$mess=1;
			}else{
				if($_REQUEST['others'][$i]==''){$resCode='4';$mess="Others" .($i+1). ": Enter Description";$resMsg=$mess;}
				else if($_REQUEST['odate'][$i]==''){$resCode='4';$mess="Others" .($i+1). ": Select Date";$resMsg=$mess;}
				else if($_FILES['ofile']['name'][$i]=='') {$resCode='4';$mess="Others" .($i+1). ": Select File";$resMsg=$mess;}
				else if($_FILES['ofile']['name'][$i]!='' && $_FILES['ofile']['size'][$i]>5767168){$resCode='4';$mess="Others" .($i+1). ": File Size Should be less than or equal to 5MB ";$resMsg=$mess;}
				else if($_REQUEST['ticket_ot'][$i]==''){$resCode='4';$mess="Others" .($i+1). ": Select Ticket Id";$resMsg=$mess;}
				else if($_REQUEST['dprNum_ot'][$i]==''){$resCode='4';$mess="Others" .($i+1). ": Enter DPR Number";$resMsg=$mess;}
				else if($_REQUEST['oamt'][$i]=='' || $_REQUEST['oamt'][$i]=='0'){$resCode='4';$mess="Others" .($i+1). ": Amount Required";$resMsg=$mess;}
				else $mess=1;
			}if($mess!=1){ echo return_false($resMsg); exit;}
		}
		if($mess==1){if(mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_oth'])=="" || mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_oth'])=='0'){$res=$mess="Enter Other Expense Details";}}
		if($mess==1){
			$oth_alias=$_REQUEST['alias'];
			$reqdate=date("Y-m-d");
			for($i=0;$i<count($_REQUEST['oamt']);$i++){
				$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['odate'][$i]))));
				$fa[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['others'][$i]);
				$fb[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['oamt'][$i]);
				$fc[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['dprNum_ot'][$i]);
				$fd[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['ticket_ot'][$i]);
				if($_FILES['ofile']['size'][$i]>0){
					$ext2 = pathinfo($_FILES['ofile']['name'][$i], PATHINFO_EXTENSION);
					$fileName=$emp_alias.generateRandomString()."TO.".$ext2;
					if(move_uploaded_file($_FILES["ofile"]["tmp_name"][$i],"../../attachments/".$fileName)){
						$profileimg = "attachments/".$fileName;
						$alias1=aliasCheck(generateRandomString(),"ec_other_expenses","alias");
						if($_REQUEST['others'][$i] != '' && $_REQUEST['odate'][$i] != '' && $_FILES['ofile']['name'][$i] != '' && $_REQUEST['ticket_ot'][$i] != '' && $_REQUEST['dprNum_ot'][$i]!='' && $_REQUEST['oamt'][$i]!=''){
							$ins=mysqli_query($mr_con,"INSERT INTO ec_other_expenses(checked_date, description, amount, expenses_alias, alias, document_link, dpr_number, ticket_alias, created_date) VALUES('$faa[$i]','$fa[$i]','$fb[$i]','$oth_alias','$alias1','$profileimg','$fc[$i]','$fd[$i]','$reqdate')");
							if($ins){
								$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$oth_alias."'");
								$sel_rs=mysqli_fetch_array($sel);
								$texp=$sel_rs['total_tour_expenses'];
								$upval=$texp+$fb[$i];
								$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$oth_alias."'");
							}
						}
					}else{
						array_push($fault,$_FILES['ofile']['name'][$i]);
					}
				}
			}
			if(count($fault)!='0'){
				$action = "Expence bill number: ".ebill($oth_alias)." updated.";
				user_history($emp_alias,$action,$ip_addr);
				$resCode='0';
				$resMsg="Some Files could not be uploaded.Kindly Resubmit from Drafts.";
			}else{
				if($ins){
				$action = "Expence bill number: ".ebill($oth_alias)." updated.";
				user_history($emp_alias,$action,$ip_addr);
					$resCode='0';$resMsg="Inserted Successfully";}else{$resCode='4';$resMsg='Failed';}	
			}				
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}		
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function oth_oth_single_add(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		$fault=array();
		for($i=0;$i<count($_REQUEST['others']);$i++){
			if($_REQUEST['others'][$i] == '' && $_REQUEST['odate'][$i] == '' && $_FILES['ofile']['name'][$i] == '' && $_REQUEST['oamt'][$i]==''){
				$mess=1;
			}else{
				if($_REQUEST['others'][$i]==''){$resCode='4';$mess="Others" .($i+1). ": Enter Description";$resMsg=$mess;}
				else if($_REQUEST['odate'][$i]==''){$resCode='4';$mess="Others" .($i+1). ": Select Date";$resMsg=$mess;}
				/*else if($_FILES['ofile']['name'][$i]=='') {$resCode='4';$mess="Others" .($i+1). ": Select File";$resMsg=$mess;}*/
				else if($_FILES['ofile']['name'][$i]!='' && $_FILES['ofile']['size'][$i]>5767168){$resCode='4';$mess="Others" .($i+1). ": File Size Should be less than or equal to 5MB ";$resMsg=$mess;}				else if($_REQUEST['oamt'][$i]=='' || $_REQUEST['oamt'][$i]=='0'){$resCode='4';$mess="Others" .($i+1). ": Amount Required";$resMsg=$mess;}
				else $mess=1;
			}if($mess!=1){ echo return_false($resMsg); exit;}
		}
		if($mess==1){if(mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_oth'])=="" || mysqli_real_escape_string($mr_con,$_REQUEST['fare_total_oth'])=='0'){$res=$mess="Enter Other Expense Details";}}
		if($mess==1){
			$oth_alias=$_REQUEST['alias'];
			$reqdate=date("Y-m-d");
			for($i=0;$i<count($_REQUEST['oamt']);$i++){
				$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['odate'][$i]))));
				$fa[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['others'][$i]);
				$fb[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['oamt'][$i]);
				if($_FILES['ofile']['size'][$i]>0){
					$ext2 = pathinfo($_FILES['ofile']['name'][$i], PATHINFO_EXTENSION);
					$fileName=$emp_alias.generateRandomString()."TO.".$ext2;
					if(move_uploaded_file($_FILES["ofile"]["tmp_name"][$i],"../../attachments/".$fileName)){
						$profileimg = "attachments/".$fileName;
						$alias1=aliasCheck(generateRandomString(),"ec_other_expenses","alias");
						if($_REQUEST['others'][$i] != '' && $_REQUEST['odate'][$i] != '' && $_FILES['ofile']['name'][$i]!= '' && $_REQUEST['oamt'][$i]!=''){
							$ins=mysqli_query($mr_con,"INSERT INTO ec_other_expenses(checked_date, description, amount, expenses_alias, alias, document_link, created_date) VALUES('$faa[$i]','$fa[$i]','$fb[$i]','$oth_alias','$alias1','$profileimg','$reqdate')");
							if($ins){
								$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$oth_alias."'");
								$sel_rs=mysqli_fetch_array($sel);
								$texp=$sel_rs['total_tour_expenses'];
								$upval=$texp+$fb[$i];
								$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$oth_alias."'");
							}
						}
					}else array_push($fault,$_FILES['ofile']['name'][$i]);
				}else{
					$profileimg = "0";
					$alias1=aliasCheck(generateRandomString(),"ec_other_expenses","alias");
					if($_REQUEST['others'][$i] != '' && $_REQUEST['odate'][$i] != '' && $_REQUEST['oamt'][$i]!=''){
						$ins=mysqli_query($mr_con,"INSERT INTO ec_other_expenses(checked_date, description, amount, expenses_alias, alias, document_link, created_date) VALUES('$faa[$i]','$fa[$i]','$fb[$i]','$oth_alias','$alias1','$profileimg','$reqdate')");
						if($ins){
							$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$oth_alias."'");
							$sel_rs=mysqli_fetch_array($sel);
							$texp=$sel_rs['total_tour_expenses'];
							$upval=$texp+$fb[$i];
							$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$oth_alias."'");
						}
					}
				}
			}
			if(count($fault)!='0'){
				$action = "Expence bill number: ".ebill($oth_alias)." updated.";
				user_history($emp_alias,$action,$ip_addr);
			$resCode='0';
			$resMsg="Some Files could not be uploaded.Kindly Resubmit from Drafts.";
			
			}else{
				if($ins){
				$action = "Expence bill number: ".ebill($oth_alias)." updated.";
				user_history($emp_alias,$action,$ip_addr);
					$resCode='0';$resMsg="Inserted Successfully";}else{$resCode='4';$resMsg='Failed';}	
			}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
		
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function oth_single_view(){	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		$oth_alias=$_REQUEST['alias'];
		$oth_sql=mysqli_query($mr_con,"SELECT expenses_alias,description,amount,checked_date,alias,document_link,created_date,dpr_number,ticket_alias FROM ec_other_expenses WHERE alias='$oth_alias' AND flag=0");
		if(mysqli_num_rows($oth_sql)){
			$oth_row = mysqli_fetch_array($oth_sql);
			$result['expenses_alias']=$oth_row['expenses_alias'];	
			$result['description']=$oth_row['description'];
			$result['checked_date']=date("d-m-Y", strtotime($oth_row['checked_date']));
			if($oth_row['document_link']!=='0' && $oth_row['document_link']!=''){$oth_link=urllink($oth_row['created_date']).$oth_row['document_link'];}else{$oth_link='';}
			$result['document_link']=$oth_row['document_link'];
			$result['hidden_document_link']=$oth_row['document_link'];
			$result['amount']=$oth_row['amount'];
			$result['alias']=$oth_row['alias'];
			$result['created_date']=$oth_row['created_date'];
			if($oth_row['ticket_alias'] != ''){ if($oth_row['ticket_alias'] == "1") $oth_ticket_name="Others"; else $oth_ticket_name=getTicketName($oth_row['ticket_alias']);}else {$oth_ticket_name='--';}
			$result['ticket_val']=$oth_ticket_name;
			$result['ticket_alias']=$oth_row['ticket_alias'];
			if($oth_row['dpr_number'] != '') $oth_dpr = $oth_row['dpr_number'];else $oth_dpr = '--';
			$result['dpr_number']=$oth_dpr;
		}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function ser_oth_single_edit(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);

	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		$fault=array();
		if($_REQUEST['others']==''){$resCode='4';$mess="Others : Enter Description";$resMsg=$mess;}
		else if($_REQUEST['odate']==''){$resCode='4';$mess="Others : Select Date";$resMsg=$mess;}
		else if($_FILES['ofile']['name']=='' && ($_REQUEST['ofile_old']=='' || $_REQUEST['ofile_old']=='0')) {$resCode='4';$mess="Others : Select File";$resMsg=$mess;}
		else if($_FILES['ofile']['name']!='' && $_FILES['ofile']['size']>5767168){$resCode='4';$mess="Others : File Size Should be less than or equal to 5MB ";$resMsg=$mess;}
		else if($_REQUEST['ticket_ot']==''){$resCode='4';$mess="Others : Select Ticket Id";$resMsg=$mess;}
		else if($_REQUEST['dprNum_ot']==''){$resCode='4';$mess="Others : Enter DPR Number";$resMsg=$mess;}
		else if($_REQUEST['oamt']=='' || $_REQUEST['oamt']=='0'){$resCode='4';$mess="Others : Amount Required";$resMsg=$mess;}
		else $mess=1;
		if($mess!=1){ echo return_false($resMsg); exit;}
		if($mess==1){
			$reqdate=date("Y-m-d");
			$f1=mysqli_real_escape_string($mr_con,$_REQUEST['ido']);
			$f2=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['odate'])));
			$f3=mysqli_real_escape_string($mr_con,$_REQUEST['others']);
			$f6=mysqli_real_escape_string($mr_con,$_REQUEST['oamt']);
			$f7=mysql_escape_string($_REQUEST['dprNum_ot']);
			$f8=mysql_escape_string($_REQUEST['ticket_ot']);
			$prev_amt=mysqli_real_escape_string($mr_con,$_REQUEST['prev_amt']);
			$ealias=mysqli_real_escape_string($mr_con,$_REQUEST['expenses_alias']);
			if($f1!=''){
				if($_FILES['ofile']['size']>0){
					$ext = pathinfo($_FILES['ofile']['name'], PATHINFO_EXTENSION);
					$fileName=$emp_alias.generateRandomString()."TO.".$ext;
					$move = move_uploaded_file($_FILES["ofile"]["tmp_name"],"../../attachments/".$fileName);
					if($move){
						$profileimg = "attachments/".$fileName;
						if($_REQUEST['ofile_old']!=='0') unlink("../../".$_REQUEST['ofile_old']);
					}else{$profileimg = ""; array_push($fault,$_FILES['ofile']['name']);}
				}else{
					$profileimg=$_REQUEST['ofile_old'];
				}
				if($profileimg != ''){
					$up=mysqli_query($mr_con,"UPDATE ec_other_expenses SET checked_date='".$f2."',
						description='".$f3."',
						amount='".$f6."', 
						document_link='$profileimg', 
						created_date='$reqdate', dpr_number='".$f7."',ticket_alias='".$f8."' 
						WHERE alias='".$f1."'");
					if($up){
						$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$ealias."'");
						$sel_rs=mysqli_fetch_array($sel);
						$texp=$sel_rs['total_tour_expenses'];
						$upval=$texp-$prev_amt+$f6;
						$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$ealias."'");
					}
				}
			}
			if($up){
				$action = "Expence bill number: ".ebill($ealias)." updated.";
				user_history($emp_alias,$action,$ip_addr);
				$resCode = '0';$resMsg="Updated successfully";} else{$resCode = '4';$resMsg="Update Failed";}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function oth_oth_single_edit(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		if($_REQUEST['others']==''){$resCode='4';$mess="Others : Enter Description";$resMsg=$mess;}
		else if($_REQUEST['odate']==''){$resCode='4';$mess="Others : Select Date";$resMsg=$mess;}
/*		else if($_FILES['ofile']['name']=='' && ($_REQUEST['ofile_old']=='' || $_REQUEST['ofile_old']=='0')) {$resCode='4';$mess="Others : Select File";$resMsg=$mess;}
*/		else if($_FILES['ofile']['name']!='' && $_FILES['ofile']['size']>5767168){$resCode='4';$mess="Others : File Size Should be less than or equal to 5MB ";$resMsg=$mess;}
		else if($_REQUEST['oamt']=='' || $_REQUEST['oamt']=='0'){$resCode='4';$mess="Others : Amount Required";$resMsg=$mess;}
		else $mess=1;
		if($mess!=1){ echo return_false($resMsg); exit;}
		if($mess==1){
			$reqdate=date("Y-m-d");
			$fault=array();
			$f1=mysqli_real_escape_string($mr_con,$_REQUEST['ido']);
			$f2=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['odate'])));
			$f3=mysqli_real_escape_string($mr_con,$_REQUEST['others']);
			$f4=mysqli_real_escape_string($mr_con,$_REQUEST['oamt']);
			$prev_amt=mysqli_real_escape_string($mr_con,$_REQUEST['prev_amt']);
			$ealias=mysqli_real_escape_string($mr_con,$_REQUEST['expenses_alias']);
			if($f1!=''){
				if($_FILES['ofile']['size']>'0'){
					$ext = pathinfo($_FILES['ofile']['name'], PATHINFO_EXTENSION);
					$fileName=$emp_alias.generateRandomString()."TO.".$ext;
					$move = move_uploaded_file($_FILES["ofile"]["tmp_name"],"../../attachments/".$fileName);
					if($move){
						$profileimg = "attachments/".$fileName;
						if($_REQUEST['ofile_old']!=='0') unlink("../../".$_REQUEST['ofile_old']);
					}else{$profileimg = ""; array_push($fault,$_FILES['ofile']['name']);}
				}else{
					$profileimg=$_REQUEST['ofile_old'];
				}
				if($profileimg!=''){
					$up=mysqli_query($mr_con,"UPDATE ec_other_expenses SET checked_date='".$f2."',
						description='".$f3."',
						amount='".$f4."', 
						document_link='$profileimg', 
						created_date='$reqdate' 
						WHERE alias='".$f1."'");
					if($up){
						$sel=mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias = '".$ealias."'");
						$sel_rs=mysqli_fetch_array($sel);
						$texp=$sel_rs['total_tour_expenses'];
						$upval=$texp-$prev_amt+$f4;
						$update=mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses='".$upval."' WHERE expenses_alias='".$ealias."'");
					}
				}
				if($up){
					$action = "Expence bill number: ".ebill($ealias)." updated.";
					user_history($emp_alias,$action,$ip_addr);					
					$resCode = '0';$resMsg="Updated successfully";} else{$resCode = '4';$resMsg="Update Failed";}
			}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function expense_main_edit(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['visitFromDate'])){$res="Select Visit from Date";}
		else if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['visitToDate'])){$res="Select Visit to Date";}
		else if(trim($_REQUEST['placesOfVisit'])==""){$res="Enter Places Of Visit";}
		else if(trim($_REQUEST['purpose'])==""){$res="Enter Purpose";}
		else if(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks']))==""){$res="Enter Remarks";}
		else if($_FILES['tplanningreport']['size']<=0 && $_REQUEST['empdept']!= 3 && ($_REQUEST['tplanningreport_old']=='' || $_REQUEST['tplanningreport_old']=='0')){$res="Upload Tour Report";}
		else if($_FILES['tplanningreport']['size']>0 && (pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION)!='pdf' && pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION)!='PDF')){$res="Upload PDF Only";}
		else if($_FILES['tplanningreport']['size']>1153433){$res="File Size Should be less than or equal to 1MB";}
		else{
			$visitFromDate=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['visitFromDate']))));
			$visitToDate=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['visitToDate']))));
			$placesOfVisit=mysqli_real_escape_string($mr_con,$_REQUEST['placesOfVisit']);
			$purpose=mysqli_real_escape_string($mr_con,$_REQUEST['purpose']);
			$reqdate=date("Y-m-d");
			$remarkss=mysqli_real_escape_string($mr_con,$_REQUEST['remarks']);
			$remark_alias=mysqli_real_escape_string($mr_con,$_REQUEST['remark_alias']);
			$ealias=mysqli_real_escape_string($mr_con,$_REQUEST['expenses_alias']);
			$level=0;
			if($_REQUEST['empdept']!= 3){
				if($_FILES['tplanningreport']['size']>0){
					$ext = pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION);
					$fileName=$empalias.generateRandomString()."EXP.".$ext;
					$move=move_uploaded_file($_FILES["tplanningreport"]["tmp_name"],"../../attachments/tourReport/".$fileName);
					if($move){$profileimg = "attachments/tourReport/".$fileName;
						if($_REQUEST['tplanningreport_old']!=='0' && $_REQUEST['tplanningreport_old']!=='') unlink("../../".$_REQUEST['tplanningreport_old']);
					}
				}else{
					$profileimg=$_REQUEST['tplanningreport_old'];
				}
			}else{ $profileimg='0';}
			$sql="UPDATE ec_expenses SET last_updated = now() , period_of_visit_from='$visitFromDate', period_of_visit_to='$visitToDate', places_of_visit='$placesOfVisit', purpose='$purpose', requested_date='$reqdate', approval_level='$level',report='$profileimg' WHERE expenses_alias='$ealias'";
			if($_REQUEST['ref2']=='0'){
				$mr_con->query("UPDATE ec_remarks SET remarks='$remarkss',remarked_on='".date("Y-m-d H:i:s")."' WHERE item_alias='$ealias' AND remark_alias='$remark_alias'");
			}
			if($_REQUEST['ref2']=='8'){							
				$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
				if($remarkss!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$remarkss','BE','$ealias','$emp_alias','$alias_remark')");
			}
			if($mr_con->query($sql)===TRUE){
				$action = "Expence bill number: ".ebill($ealias)." updated.";
				user_history($emp_alias,$action,$ip_addr);
				$resCode='0';$resMsg='Expense Updated successfully!';
			}else{ $res="Expense Request Failed";}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);	
}

function expense_main_adv_edit(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['visitFromDate'])){$res="Select Visit from Date";}
		else if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['visitToDate'])){$res="Select Visit to Date";}
		else if(trim($_REQUEST['placesOfVisit'])==""){$res="Enter Places Of Visit";}
		else if(trim($_REQUEST['purpose'])==""){$res="Enter Purpose";}
		else if(trim($_REQUEST['remarks'])==""){$res="Enter Remarks";}
		//else if(trim($_REQUEST['poGnr'])==""){$res="Enter Po/Gnr Number";}
		else if(trim($_REQUEST['UTRNum'])==""){$res="Enter UTR Number";}
		else if($_FILES['tplanningreport']['size']<=0 && $_REQUEST['empdept']!= 3 && ($_REQUEST['tplanningreport_old']=='' || $_REQUEST['tplanningreport_old']=='0')){$res="Upload Tour Report";}
		else if($_FILES['tplanningreport']['size']>0 && (pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION)!='pdf' && pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION)!='PDF')){$res="Upload PDF Only";}
		else if($_FILES['tplanningreport']['size']>1153433){$res="File Size Should be less than or equal to 1MB";}
		else{
			$visitFromDate=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['visitFromDate']))));
			$visitToDate=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['visitToDate']))));
			$requestedDate = date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['requestedDate']))));
			$placesOfVisit=mysqli_real_escape_string($mr_con,$_REQUEST['placesOfVisit']);
			$purpose=mysqli_real_escape_string($mr_con,$_REQUEST['purpose']);
			$remarks=mysqli_real_escape_string($mr_con,$_REQUEST['remarks']);
			$poGnr = mysqli_real_escape_string($mr_con,$_REQUEST['poGnr']);
			$UTRNum = mysqli_real_escape_string($mr_con,$_REQUEST['UTRNum']);
			$ealias=mysqli_real_escape_string($mr_con,$_REQUEST['expenses_alias']);
			if($_REQUEST['empdept']!= 3){
				if($_FILES['tplanningreport']['size']>0){
					$ext = pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION);
					$fileName=$empalias.generateRandomString()."EXP.".$ext;
					$move=move_uploaded_file($_FILES["tplanningreport"]["tmp_name"],"../../attachments/tourReport/".$fileName);
					if($move){$profileimg = "attachments/tourReport/".$fileName;
						if($_REQUEST['tplanningreport_old']!=='0' && $_REQUEST['tplanningreport_old']!=='') unlink("../../".$_REQUEST['tplanningreport_old']);
					}
				}else{
					$profileimg=$_REQUEST['tplanningreport_old'];
				}
			}else{ $profileimg='0';}
			$sql="UPDATE ec_expenses SET last_updated = now() , period_of_visit_from='$visitFromDate', period_of_visit_to='$visitToDate', places_of_visit='$placesOfVisit', purpose='$purpose', requested_date='$requestedDate', report='$profileimg', po_gnr='$poGnr', utr_num='$UTRNum' WHERE expenses_alias='$ealias'";
			if($mr_con->query($sql)===TRUE){
				$action = "Expence bill number: ".ebill($ealias)." updated.";
				user_history($emp_alias, $action, $ip_addr, $remarks);
				$resCode='0';$resMsg='Expense Updated successfully!';
			} else { 
				$res="Expense Request Failed";
			}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);	
}
function user_main_expences_view(){
 	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	$viewemp_expalias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
	if($chk==0){
		$resultz=expensefullView($viewemp_expalias);
		$result['expenses_alias'] = $viewemp_expalias;
		$result['ref2'] = $resultz[0]['approval_level'];
		$result['empalias'] = $resultz[0]['employee_alias'];
		$result['empdept'] =checkspldep($resultz[0]['employee_alias']);
		$result['period_of_visit_from'] =date("d-m-Y", strtotime($resultz[0]['period_of_visit_from']));
		$result['places_of_visit'] =$resultz[0]['places_of_visit'];
		$result['places_of_visit_to'] =date("d-m-Y", strtotime($resultz[0]['period_of_visit_to']));
		$result['no_of_days'] = noofDays($resultz[0]['period_of_visit_from'],$resultz[0]['period_of_visit_to']);
		$result['purpose'] =$resultz[0]['purpose'];
		$rcnt_sql = mysqli_query($mr_con,"SELECT remark_alias,remarks FROM ec_remarks WHERE item_alias='$viewemp_expalias' AND remarked_by='".$resultz[0]['employee_alias']."' AND module='BE' AND flag=0 ORDER BY id DESC LIMIT 1");
		$remarks_q = mysqli_fetch_array($rcnt_sql);
		$result['remarkss'] =$remarks_q['remarks'];
		$result['remark_alias'] =$remarks_q['remark_alias'];
		$result['requested_date'] = date("d-m-Y", strtotime($resultz[0]['requested_date']));
		$result['po_gnr'] = $resultz[0]['po_gnr'];
		$result['utr_num'] = $resultz[0]['utr_num'];
		if($resultz[0]['report']!=='0' && $resultz[0]['report']!=''){
			$tour_link=urllink($resultz[0]['requested_date']).$resultz[0]['report'];
		}else{
			$tour_link='';
		}
		$result['report'] = $tour_link;
		$result['hidden_report']=$resultz[0]['report'];
		if(checkspldep($resultz[0]['employee_alias'])=='3'){
			if(getRoleStat(employeeDetails('role_alias',$resultz[0]['employee_alias'])) == 0){
				$service_dept_onroll = '1';
			} else {
				$service_dept_onroll = '0';
			}
		} else {
			$service_dept_onroll = '0';
		}
		$result['service_dept_onroll']=$service_dept_onroll;	

	}elseif($chk==1){
		$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function user_expense_submit(){
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	//echo $_REQUEST['ref2'];exit;
	if($chk=='0'){	
		$reqdate=date("Y-m-d");
		$alias=$_REQUEST['id'];
		$levelx=expenseApprovalLevels($emp_alias);
		switch ($levelx){
			case '1': $level=2;break;
			case '2': $level=5;break;
			case '3': $level=5;break;
			case '4': $level=5;break;
			case '5': $level=3;break;
			default : $level=1;break;
		}
		$sql="UPDATE ec_expenses SET last_updated = now() , requested_date='$reqdate', approval_level='$level' WHERE expenses_alias='$alias'";
		if($mr_con->query($sql)===TRUE) {
			$action = "Expense submitted with Bill Number: ".ebill($alias)."";
			user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
			$url=localURL()."enersys_expense/maillings/book_expense.php?ref=".$alias;
			//file_get_contents($url);	
			curlxing($url);			
			$resCode='0'; $resMsg="Expense Submitted successfully";} else{ $resCode='4'; $resMsg="Expense Request Failed";}
						
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);	
}

function user_expense_adv_save() {
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk = authentication($emp_alias,$token);
	if($chk=='0') {
		$alias = $_REQUEST['id'];
		$reimbursement = mysqli_real_escape_string($mr_con,$_REQUEST['reimbursement_amount']);
		$refund_amount = mysqli_real_escape_string($mr_con,$_REQUEST['refund_amount']);
		$sql = "UPDATE ec_expenses SET last_updated = now() , reimbursement_amount = '$reimbursement', refund_amount = '$refund_amount'  WHERE expenses_alias='$alias'";
		$remarks = $_REQUEST['remarks'];
		foreach($remarks as $remark) {
			if(!empty($remark['remarked_by_alias'])) {
				$remarkUpdate = "UPDATE ec_remarks set remarks = '" . $remark['remark'] ."', remarked_by = '" . $remark['remarked_by_alias'] ."', remarked_on = '" . $remark['remarked_on'] ." 00:00:00' WHERE remark_alias='". $remark['alias'] ."'";
				$mr_con->query($remarkUpdate);
			}
		}
		if($mr_con->query($sql) === TRUE) {
			$action = "Expense Edited with Bill Number: " . ebill($alias);
			user_history($_REQUEST['emp_alias'], $action, $_REQUEST['ip_addr']);			
			$resCode='0'; $resMsg="Expense Submitted successfully";
		} else { 
			$resCode='4'; $resMsg="Expense Request Failed";
		}
	} elseif($chk=='1') {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);	
}
function del_dyn_expenses(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$rex=authentication($emp_alias,$token);
	if($rex=='0'){
		$delalias = mysqli_real_escape_string($mr_con,$_REQUEST['alias']);
		$exp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['ealias']);
		$reff = mysqli_real_escape_string($mr_con,$_REQUEST['reff']);
		if($reff == 'lc'){
			 $tab = 'ec_localconveyance';
		}else if($reff == 'co'){
			 $tab = 'ec_conveyance';
		}else if($reff == 'ld'){
			 $tab = 'ec_lodging';
		}else if($reff == 'bd'){
			 $tab = 'ec_boarding';
		}else if($reff == 'ot'){
			 $tab = 'ec_other_expenses';
		}
		$get_amt_sql = mysqli_query($mr_con,"SELECT amount FROM $tab WHERE alias ='".$delalias."' AND expenses_alias ='".$exp_alias."' AND flag=0");
		$getamt_rs = mysqli_fetch_array($get_amt_sql);
		$del_amt = $getamt_rs['amount'];
		$get_amt_sqll = mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias ='".$exp_alias."' AND flag=0");
		$getamt_rss = mysqli_fetch_array($get_amt_sqll);
		$total_amt = $getamt_rss['total_tour_expenses'];	
		$diff_amt = $total_amt-$del_amt;
		$sqlTT = mysqli_query($mr_con,"DELETE FROM $tab WHERE alias ='".$delalias."' AND expenses_alias ='".$exp_alias."' AND flag=0");
		if($sqlTT){
			$action = "Expence bill number: ".ebill($exp_alias)." updated.";
			user_history($emp_alias,$action,$ip_addr);
			$update_sql = mysqli_query($mr_con,"UPDATE ec_expenses SET last_updated = now() , total_tour_expenses = '".$diff_amt."'  WHERE expenses_alias ='".$exp_alias."' AND flag=0");
			$res='Successfully Deleted';
		}else{$res='Not Deleted';}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex=='1'){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function advance_status_change() {
	
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk = authentication($emp_alias,$token);
	if($chk=='0') {
		$alias = $_REQUEST['advance_alias'];
		$level = $_REQUEST['mappedStatus'];
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else {
			$actualLevel = alias($alias, 'ec_advances', 'advance_alias', 'approval_level');
			if($actualLevel > $level) {
				$sql="UPDATE ec_advances SET last_updated = now() , approval_level='$level' WHERE advance_alias='$alias'";
				if($mr_con->query($sql) === TRUE) {
					$action = "Advance status changed Bill Number: ".areq($alias)."";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$resCode='0'; $resMsg="Advance Status Changed Successfully";
				} else { 
					$resCode='4'; $resMsg="Advance Status Change Request Failed";
				}
			} else {
				$resCode='4'; $resMsg="Status change cannot be upgraded";
			}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($chk=='1') {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);	
}

function expense_status_change() {

	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk = authentication($emp_alias,$token);
	if($chk=='0') {
		$alias = $_REQUEST['expenses_alias'];
		$level = $_REQUEST['mappedStatus'];
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else {
			$actualLevel = alias($alias, 'ec_expenses', 'expenses_alias', 'approval_level');
			if($actualLevel > $level) {
				$sql="UPDATE ec_expenses SET last_updated = now() , approval_level='$level' WHERE expenses_alias='$alias'";
				if($mr_con->query($sql) === TRUE) {
					$action = "Expense status changed Bill Number: ".ebill($alias)."";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$resCode='0'; $resMsg="Expense Status Changed successfully";
				} else { 
					$resCode='4'; $resMsg="Expense Status Change Request Failed";
				}
			} else {
				$resCode='4'; $resMsg="Status change cannot be upgraded";
			}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($chk=='1') {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);	
}

function expense_delete() { 
	global $mr_con;
	$chk = authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0) {
		$alias = mysqli_real_escape_string($mr_con,$_REQUEST['expense_alias']);
		$remarks = $_REQUEST['remarks'];
		$reqid = ebill($alias);
		$rec = $mr_con->query("UPDATE ec_expenses SET last_updated = now() , flag = 9 WHERE expenses_alias='$alias'");
		$mr_con->query("UPDATE ec_remarks set flag = 9 WHERE item_alias='$alias' AND module='BA'");
		if($rec) {
			$action = "Expense bill no: ".$reqid." deleted.";
			user_history($_REQUEST['emp_alias'], $action, $_REQUEST['ip_addr'], $remarks);
			$resCode = '0';$resMsg="Expense Deleted successfully";
		} else{
			$resCode = '4';$resMsg="Expense Delete Failed";
		}
	} elseif($chk==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else { 
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

function deleteSettingItem($table, $field, $val, $emp_alias, $action, $remarks, $ipAddr) {
	global $mr_con;
	if(in_array($table, ['ec_service_allowances', 'ec_daily_allowances', 'ec_expense_approvals', 'ec_expense_limits'])) {
		$query = "DELETE from $table where $field = '$val'";
	} else {
		$query = "UPDATE $table set flag = '9' where $field = '$val'";
	}
	$sql = mysqli_query($mr_con, $query);
	if($sql) {
		user_history($emp_alias, $action, $ipAddr, $remarks);
		return true;
	}
	return false;
}

function limit_check_delete_status() {
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
			$query = "SELECT name FROM ec_expense_limits el, ec_employee_master as em WHERE  el.limit_alias = '$alias' and el.designation_alias = em.designation_alias";
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

function limit_delete() {
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
			$designation = alias($alias,'ec_expense_limits','limit_alias','designation_alias');
			$name = alias($designation,'ec_designation','designation_alias','designation');
			$action = "Deleted Limit for - $name";
			$status = deleteSettingItem('ec_expense_limits', 'limit_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete limit";
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

function approvers_check_delete_status() {
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
			/*
			$query = "SELECT name FROM ec_expense_approvals ea, ec_employee_master as em WHERE  ea.approval_alias = '$alias' and ea.approval_dep = em.department_alias";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['name'];
				}
				$res = buildRes("This department is assigned for employees - ", $names);
			}
			*/
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

function approvers_delete() {
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
			$deptAlias = alias($alias,'ec_expense_approvals','approval_alias','approval_dep');
			$level = alias($alias,'ec_expense_approvals','approval_alias','approval_level');
			$deptName = alias($deptAlias,'ec_department','department_alias','department_name');
			$levelName = alias($level,'ec_expense_level','level_alias','level_name');
			$action = "Deleted Approver for department - $deptName and level - $levelName";
			$status = deleteSettingItem('ec_expense_approvals', 'approval_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete approver";
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

function serallowances_check_delete_status() {
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
			/*
			$query = "SELECT name FROM ec_expense_approvals ea, ec_employee_master as em WHERE  ea.approval_alias = '$alias' and ea.approval_dep = em.department_alias";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['name'];
				}
				$res = buildRes("This department is assigned for employees - ", $names);
			}
			*/
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

function serallowances_delete() {
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
			$dist = alias($alias,'ec_service_allowances','service_allowance_alias','district_alias');
			$name = alias($dist,'ec_district','district_alias','district_name');
			$action = "Deleted Special Allowances for district - $name";
			$status = deleteSettingItem('ec_service_allowances', 'service_allowance_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete special allowances";
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

function othallowances_check_delete_status() {
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
			/*
			$query = "SELECT name FROM ec_expense_approvals ea, ec_employee_master as em WHERE  ea.approval_alias = '$alias' and ea.approval_dep = em.department_alias";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$names = [];
				while($row = mysqli_fetch_assoc($sql)) {
					$names[] = $row['name'];
				}
				$res = buildRes("This department is assigned for employees - ", $names);
			}
			*/
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

function othallowances_delete() {
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
			$grade = alias($alias,'ec_daily_allowances','allowance_alias','grade');
			$action = "Deleted Other Allowances for grade - $grade";
			$status = deleteSettingItem('ec_daily_allowances', 'allowance_alias', $alias, $emp_alias, $action, $remarks, $_REQUEST['ip_addr']);
			if(!$status) {
				$res = "Failed to delete special allowances";
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

// End - User Expense
?>