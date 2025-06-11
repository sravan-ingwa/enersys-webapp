<?php 
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
require('../Classes/PHPExcel.php');
require('../Classes/PHPExcel/IOFactory.php');
require('../Slim/Slim.php');
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->post('/employeemaster_add','employeemaster_add');
$app->post('/employeemaster_update','employee_master_update');
$app->post('/employeemaster_single_view','employee_master_single_view');
$app->post('/employeemaster_mul_view','employee_master_mul_view');
$app->post('/employeemaster_export','employeemaster_export');
$app->post('/profile_upload','profile_upload');
//tickets
$app->post('/ticket_mul_view','ticket_mul_view');
$app->post('/ticket_view','ticket_view');
$app->post('/ticket_export','ticket_export');
$app->post('/ticket_autocomplete','ticket_autocomplete');
//Dashboard
$app->post('/yogzkmi_fun','yogzkmi_fun');
$app->post('/ticket_status','ticket_status');
$app->post('/customer_pulse','customer_pulse');
$app->post('/today_info_report_block','today_info_report_block');
$app->post('/tat_status','tat_status');
$app->post('/nature_of_activity','nature_of_activity');
$app->run();
function yogzkmi_fun(){
	global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		$s_temp=alias($emp_alias,'ec_esca','esca_alias','state_alias');
		$c1="state_alias IN ('".implode("','", explode(", ",$s_temp))."') AND state_name<>'FACTORY' AND ";
		$q1=mysqli_query($mr_con,"SELECT state_name as name,state_alias as alias FROM ec_state WHERE $c1 flag='0' ORDER BY name");
		$q2=mysqli_query($mr_con,"SELECT customer_code as name,customer_alias as alias FROM ec_customer WHERE flag='0' ORDER BY name");
		$q3=mysqli_query($mr_con,"SELECT segment_name as name,segment_alias as alias FROM ec_segment WHERE flag='0' ORDER BY name");
		$q4=mysqli_query($mr_con,"SELECT description as name,faulty_alias as alias FROM ec_faulty_code WHERE flag='0' ORDER BY name");
		$q5=mysqli_query($mr_con,"SELECT activity_code as name,activity_alias as alias FROM ec_activity WHERE flag='0' ORDER BY name");
		if(mysqli_num_rows($q1)>'0'){$x=0;while($r1=mysqli_fetch_array($q1)){$result['ss'][$x]['name']=$r1['name'];$result['ss'][$x]['alias']=$r1['alias'];$x++;}}else{$result['ss'][0]['name']="No Records";$result['ss'][0]['alias']="0";}
		if(mysqli_num_rows($q2)>'0'){$x=0;while($r1=mysqli_fetch_array($q2)){$result['cs'][$x]['name']=$r1['name'];$result['cs'][$x]['alias']=$r1['alias'];$x++;}}else{$result['cs'][0]['name']="No Records";$result['cs'][0]['alias']="0";}
		if(mysqli_num_rows($q3)>'0'){$x=0;while($r1=mysqli_fetch_array($q3)){$result['ses'][$x]['name']=$r1['name'];$result['ses'][$x]['alias']=$r1['alias'];$x++;}}else{$result['ses'][0]['name']="No Records";$result['ses'][0]['alias']="0";}
		if(mysqli_num_rows($q4)>'0'){$x=0;while($r1=mysqli_fetch_array($q4)){$result['fs'][$x]['name']=$r1['name'];$result['fs'][$x]['alias']=$r1['alias'];$x++;}}else{$result['fs'][0]['name']="No Records";$result['fs'][0]['alias']="0";}
		if(mysqli_num_rows($q5)>'0'){$x=0;while($r1=mysqli_fetch_array($q5)){$result['acs'][$x]['name']=$r1['name'];$result['acs'][$x]['alias']=$r1['alias'];$x++;}}else{$result['acs'][0]['name']="No Records";$result['acs'][0]['alias']="0";}
		for($c=14;$c<=date('y');$c++){
			$result['yrr'][$c-14]['name']="20".$c."-".($c+1);
			$result['yrr'][$c-14]['alias']=$c;
		}
	}
	echo json_encode($result);
}
function employeemaster_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$alias=aliasCheck(generateRandomString(),' ec_employee_master','employee_alias');
		$emp_name=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['name'])));
		$emp_id=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_id'])));
		$email_id=strtolower(mysqli_real_escape_string($mr_con,trim($_REQUEST['email_id'])));
		$mobile_number=mysqli_real_escape_string($mr_con,trim($_REQUEST['mobile_number']));
		$password=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['mobile_number'])));
		if(isset($_REQUEST['zone_alias']) && count($_REQUEST['zone_alias'])>0){$zone = implode(", ",$_REQUEST['zone_alias']);}else{$zone = '';}
		if(isset($_REQUEST['state_alias']) && count($_REQUEST['state_alias'])>0){$state = implode(", ",$_REQUEST['state_alias']);}else{$state = '';}
		$zone_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($zone)));
		$state_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($state)));
		$base_location=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['base_location'])));
		$designation_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['designation_alias'])));
		$department_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['department_alias'])));
		$role_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['role_alias'])));
		if(isset($_REQUEST['esca_alias'])){$esca_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['esca_alias'])));}else{$esca_alias="";}
		$privilege_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['privilege_alias'])));
		$qualification=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['qualification'])));
		$specialization=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['specialization'])));
		$totalexp=mysqli_real_escape_string($mr_con,trim($_REQUEST['total_experience']));
		$joining_date=strtoupper(mysqli_real_escape_string($mr_con,dateFormat(trim($_REQUEST['joining_date']),"y")));
		if(isset($_REQUEST['asset_alias']) && count($_REQUEST['asset_alias'])>0){$asset = implode(", ",$_REQUEST['asset_alias']);}else{$asset = '';}
		$asset_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($asset)));
		if(isset($_REQUEST['wh_alias']) && count($_REQUEST['wh_alias'])>0){$wh = implode(", ",$_REQUEST['wh_alias']);}else{$wh = '';}
		$wh_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($wh)));
		if(empty($emp_id)){$res="Please Enter Employee Id";}
		elseif(empty($emp_name)){$res="Please Enter Employee Name";}
		elseif(empty($designation_alias)){$res="Please Enter Designation";}
		elseif(empty($department_alias)){$res="Please Enter Department";}
		elseif($zone==''){$res="Please Enter Zone";}
		elseif($state==''){$res="Please Enter State";}
		elseif(empty($base_location)){$res="Please Enter Base Location";}
		elseif(empty($qualification)){$res="Please Enter Qualification";}
		elseif(empty($mobile_number)){$res="Please Enter Mobile Number";}
		elseif(empty($email_id)){$res="Please Enter Email Id";}
		elseif(empty($specialization)){$res="Please Enter Specialization";}
		elseif($totalexp==''){$res="Please Enter Total Experience";}
		elseif(empty($role_alias)){$res="Please Enter Employee Role";}
		elseif(empty($privilege_alias)){$res="Please Enter Privilege Name";}
		elseif(empty($joining_date)){$res="Please Enter Joining Date";}
		elseif($asset==''){$res="Please Select Asset Name";}
		elseif($wh==''){$res="Please Select Warehouse Code";}
		else{
			$sql=mysqli_query($mr_con,"SELECT id FROM  ec_employee_master WHERE employee_id='$emp_id' AND email_id='$email_id' AND flag=0");
			if(mysqli_num_rows($sql)==0){
				$q=mysqli_query($mr_con,"INSERT INTO ec_employee_master(name,employee_id,employee_alias,email_id,mobile_number,password,zone_alias,state_alias,base_location,designation_alias,department_alias,role_alias,esca_alias,privilege_alias,qualification,specialization,total_experience,joining_date,created_date,asset_alias,wh_alias) VALUES('$emp_name','$emp_id','$alias','$email_id','$mobile_number','$password','$zone_alias','$state_alias','$base_location','$designation_alias','$department_alias','$role_alias','$esca_alias','$privilege_alias','$qualification','$specialization','$totalexp','$joining_date','".date('Y-m-d')."','$asset_alias','$wh_alias')");
				if($q){
					$action=$district_name." $emp_name with ID $emp_id Employee Created";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$resCode='0'; $resMsg='Successfull!';
				}else{$resCode='4'; $resMsg='Error in adding!';}
			}else{$res="The Requested Employee Id AND Email Id has already exist, Try with other values";}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function employee_master_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['employee_alias'])));
		$emp_name=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['name'])));
		$emp_id=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_id'])));
		$email_id=strtolower(mysqli_real_escape_string($mr_con,trim($_REQUEST['email_id'])));
		$mobile_number=mysqli_real_escape_string($mr_con,trim($_REQUEST['mobile_number']));
		if(isset($_REQUEST['zone_alias']) && count($_REQUEST['zone_alias'])>0){$zone = implode(", ",$_REQUEST['zone_alias']);}else{$zone = '';}
		if(isset($_REQUEST['state_alias']) && count($_REQUEST['state_alias'])>0){$state = implode(", ",$_REQUEST['state_alias']);}else{$state = '';}
		$zone_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($zone)));
		$state_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($state)));
		$base_location=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['base_location'])));
		$designation_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['designation_alias'])));
		$department_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['department_alias'])));
		$role_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['role_alias'])));
		if(isset($_REQUEST['esca_alias'])){$esca_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['esca_alias'])));}else{$esca_alias="";}
		$privilege_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['privilege_alias'])));
		$qualification=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['qualification'])));
		$specialization=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['specialization'])));
		$totalexp=mysqli_real_escape_string($mr_con,trim($_REQUEST['total_experience']));
		$el_exp=mysqli_real_escape_string($mr_con,trim($_REQUEST['el_exp']));
		$status=mysqli_real_escape_string($mr_con,trim($_REQUEST['status']));
		$joining_date=mysqli_real_escape_string($mr_con,dateFormat(trim($_REQUEST['joining_date']),"y"));
		$relieving_date=mysqli_real_escape_string($mr_con,dateFormat(trim($_REQUEST['relieving_date']),"y"));
		if(isset($_REQUEST['asset_alias']) && count($_REQUEST['asset_alias'])>0){$asset = implode(", ",$_REQUEST['asset_alias']);}else{$asset = '';}
		$asset_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($asset)));
		if(isset($_REQUEST['wh_alias']) && count($_REQUEST['wh_alias'])>0){$wh = implode(", ",$_REQUEST['wh_alias']);}else{$wh = '';}
		$wh_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($wh)));
		if(empty($emp_id)){$res="Please Enter Employee Id";}
		elseif(empty($emp_name)){$res="Please Enter Employee Name";}
		elseif(empty($designation_alias)){$res="Please Enter Designation";}
		elseif(empty($department_alias)){$res="Please Enter Department";}
		elseif($zone==''){$res="Please Enter Zone";}
		elseif($state==''){$res="Please Enter State";}
		elseif(empty($base_location)){$res="Please Enter Base Location";}
		elseif(empty($qualification)){$res="Please Enter Qualification";}
		elseif(empty($mobile_number)){$res="Please Enter Mobile Number";}
		elseif(empty($email_id)){$res="Please Enter Email Id";}
		elseif(empty($specialization)){$res="Please Enter Specialization";}
		elseif($totalexp==''){$res="Please Enter Total Experience";}
		elseif(empty($role_alias)){$res="Please Enter Employee Role";}
		elseif(empty($privilege_alias)){$res="Please Enter Privilege Name";}
		elseif(empty($joining_date)){$res="Please Enter Joining Date";}
		elseif($asset==''){$res="Please Select Asset Name";}
		elseif($wh==''){$res="Please Select Warehouse Code";}
		else{
			$sql=mysqli_query($mr_con,"SELECT status FROM ec_employee_master WHERE employee_id='$emp_id' AND employee_alias<>'$alias' AND flag=0");
			if(mysqli_num_rows($sql)==0){
				if($status=="WORKING" && $relieving_date!='NA'){ $con = "status='RESIGNED',relieving_date='$relieving_date'";} 
				elseif($status=="RESIGNED"){
					if(isset($_FILES["noc"]) && !empty($_FILES["noc"]['name'])){
						$link = upload_file($_FILES["noc"],"noc","pdf"); //if(isset($_REQUEST['oldimg']) && $link){@unlink($_REQUEST['oldimg']);}
						$msg = explode(",",$link);
						if($msg[0]==0){$con = "noc='".end($msg)."',status='RELIEVED'";}else{$con="status='RESIGNED'";$res=end($msg);}
					}else{$res="Please Choose NOC file";}
				}else{$con="status='WORKING'";}
				/*if(isset($_FILES["profile_pic"]) && !empty($_FILES["profile_pic"]['name'])){
					$pro = upload_file($_FILES["profile_pic"],"profile_pic","image");
					if($pro){$con.=",profile_pic='$pro'";}
				}*/
				$q=mysqli_query($mr_con,"UPDATE ec_employee_master SET name='$emp_name',employee_id='$emp_id',email_id='$email_id',mobile_number='$mobile_number',zone_alias='$zone_alias',state_alias='$state_alias',base_location='$base_location',designation_alias='$designation_alias',department_alias='$department_alias',role_alias='$role_alias',esca_alias='$esca_alias',privilege_alias='$privilege_alias',qualification='$qualification',specialization='$specialization',total_experience='$totalexp',joining_date='$joining_date',asset_alias='$asset_alias',wh_alias='$wh_alias',$con WHERE employee_alias='$alias' AND flag=0");
				if($q){
					$action="$emp_name with ID $emp_id Employee Updated";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$resCode='0'; $resMsg='Successfull!';
				}else{$resCode = '4';$resMsg='Error in Updating!';}
			}else{$res="The Requested Employee Id has already exist, Try with other values";}
		}
	}elseif($chk==1){$resCode='1';$resMsg=$_REQUEST['emp_alias'].", ".$_REQUEST['token'];}
	else{$resCode='2';$resMsg='Account Locked!';}
	if(isset($res)){$resCode='4';$resMsg=$res;}
	$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function employee_master_single_view(){ global $mr_con;
	$emp_alias = $_REQUEST['emp_alias'];
	$token = $_REQUEST['token'];
		$chk=authentication($emp_alias,$token);
		if($chk==0){
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_employee_master WHERE employee_alias='$_REQUEST[alias]' AND flag=0");
			if(mysqli_num_rows($sql)>0){
				while($row=mysqli_fetch_array($sql)){
					if(!empty($row['profile_pic'])){$result['profile_pic']="images/profile_pics/".$row['profile_pic'];}else{$result['profile_pic']="images/gallery/profile_male";}
					if(!empty($row['noc'])){$result['noc']="images/reports/".$row['noc'];}
					$result['name']=$row['name'];
					$result['employee_id']=$row['employee_id'];
					$result['employee_alias']=$row['employee_alias'];
					$result['email_id']=$row['email_id'];
					$result['mobile_number']=$row['mobile_number'];
					$result['base_location']=$row['base_location'];
					$result['qualification']=$row['qualification'];
					$result['specialization']=$row['specialization'];
					$result['total_experience']=$row['total_experience'];
					$result['el_experience']=el_experience($row['joining_date'], $row['relieving_date']);
					$result['joining_date']=dateFormat($row['joining_date'],'d');
					$result['relieving_date']=dateFormat($row['relieving_date'],'d');
					$result['status']=$row['status'];
					$result['created_date']=dateFormat($row['created_date'],'d');
					$result['spl_previlage']=$row['spl_previlage'];
					$result['device']=$row['device'];
					
					$result['zone_alias']=$row['zone_alias'];
					$zone = explode(", ",$row['zone_alias']);
					foreach($zone as $z){ $zz .= alias($z,'ec_zone','zone_alias','zone_name').", "; }
					$result['zone_name'] = trim($zz,", ");
					
					$result['state_alias']=$row['state_alias'];
					$state = explode(", ",$row['state_alias']);
					foreach($state as $s){ $ss .= alias($s,'ec_state','state_alias','state_name').", "; }
					$result['state_name'] = trim($ss,", ");
					
					$result['asset_alias']=$row['asset_alias'];
					$asset = explode(", ",$row['asset_alias']);
					foreach($asset as $a){
						$aa .= alias($a,'ec_assets','asset_alias','asset_name').", "; 
						$bb .= alias($a,'ec_assets','asset_alias','asset_make').", ";
						$cc .= alias($a,'ec_assets','asset_alias','asset_serial_number').", ";
					}
					
					$result['wh_alias']=$row['wh_alias'];
					$wh = explode(", ",$row['wh_alias']);
					foreach($wh as $a){
						$xx .= alias($a,'ec_warehouse','wh_alias','wh_code').", "; 
						
					}
					$result['wh_code']=trim($xx,", ");
					$result['asset_name'] = trim($aa,", ");
					$result['asset_make'] = trim($bb,", ");
					$result['asset_serial_number'] = trim($cc,", ");
					
					$aatt = array();
					foreach($asset as $at){	$aatt[] = alias($at,'ec_assets','asset_alias','asset_type'); }
					$result['asset_type']=implode(", ",array_unique($aatt));
					
					$result['grade']=alias($row['designation_alias'],'ec_designation','designation_alias','grade');
					$result['designation']=alias($row['designation_alias'],'ec_designation','designation_alias','designation');
					$result['designation_alias']=$row['designation_alias'];
					$result['department_name']=alias($row['department_alias'],'ec_department','department_alias','department_name');
					$result['department_alias']=$row['department_alias'];
					$result['role_name']=alias($row['role_alias'],'ec_emprole','role_alias','role_name');
					$result['role_alias']=$row['role_alias'];
					$result['esca_name']=alias($row['esca_alias'],'ec_esca','esca_alias','esca_name');
					$result['esca_alias']=$row['esca_alias'];
					$result['privilege_name']=alias($row['privilege_alias'],'ec_privileges','privilege_alias','privilege_name');
					$result['privilege_alias']=$row['privilege_alias'];
					$result['noc']=$row['noc'];
					
					$result['edit']=grantable('EDIT','EMPLOYEE MASTER',$emp_alias);
				}
				$resCode='0'; $resMsg='Successfull!';
				}else{$resCode='4'; $resMsg='No Records Found';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']='2';$result['ErrorDetails']['ErrorMessage']='Account Locked!';
		echo json_encode($result);
}
function employee_master_mul_view(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		if($_REQUEST['employeeId']!="")$employee_id="employee_id LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['employeeId'])."%' AND ";else $employee_id="";
		if($_REQUEST['name']!="")$name="name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['name'])."%' AND ";else $name="";
		if($_REQUEST['designation']!="")$designation="designation LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['designation'])."%' AND ";else $designation="";
		if($_REQUEST['zoneAlias']!="")$zone_alias="zone_alias LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['zoneAlias'])."%' AND ";else $zone_alias="";
		if($_REQUEST['roleName']!="")$role_name="role_name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['roleName'])."%' AND ";else $role_name="";
		if($_REQUEST['loginId']!="")$email_id="email_id LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['loginId'])."%' AND ";else $email_id="";
		if($_REQUEST['mobileNumber']!="")$mobile_number="mobile_number LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['mobileNumber'])."%' AND ";else $mobile_number="";
		$siteCondition=$designation;
		$condtion=$employee_id.$name.$zone_alias.$email_id.$mobile_number;
		$con = " esca_alias='$emp_alias' AND";
		$query = "SELECT count(id) FROM ec_employee_master WHERE $con $condtion flag=0 AND $emp designation_alias IN (SELECT designation_alias FROM ec_designation WHERE $siteCondition flag=0 AND role_alias IN (SELECT role_alias FROM ec_emprole WHERE $role_name flag=0))";
		$rec=mysqli_query($mr_con, $query);
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			//echo "SELECT * FROM ec_employee_master WHERE $condtion flag=0 AND designation_alias IN (SELECT designation_alias FROM ec_designation WHERE $siteCondition flag=0 AND role_alias IN (SELECT role_alias FROM ec_emprole WHERE $role_name flag=0)) LIMIT $offset, $limit";
			$sql = mysqli_query($mr_con,"SELECT * FROM ec_employee_master WHERE $con $condtion flag=0 AND $emp designation_alias IN (SELECT designation_alias FROM ec_designation WHERE $siteCondition flag=0 AND role_alias IN (SELECT role_alias FROM ec_emprole WHERE $role_name flag=0)) LIMIT $offset, $limit");
			$result['employeemasterDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['employeemasterDetails'][$i]['employee_id']=$row['employee_id'];
					$result['employeemasterDetails'][$i]['name']=$row['name'];
					$result['employeemasterDetails'][$i]['designation']=alias($row['designation_alias'],'ec_designation','designation_alias','designation');
					
					foreach(explode(", ",$row['zone_alias']) as $y){ $yy[$i] .= alias($y,'ec_zone','zone_alias','zone_name').", "; }
					$result['employeemasterDetails'][$i]['zone_name']=trim($yy[$i],", ");
					foreach(explode(", ",$row['state_alias']) as $z){ $zz[$i] .= alias($z,'ec_state','state_alias','state_name').", "; }
					$result['employeemasterDetails'][$i]['state_name']=trim($zz[$i],", ");
					$result['employeemasterDetails'][$i]['role_name']=alias($row['role_alias'],'ec_emprole','role_alias','role_name');
					$result['employeemasterDetails'][$i]['email_id']=$row['email_id'];
					$result['employeemasterDetails'][$i]['employee_alias']=$row['employee_alias'];
					$result['employeemasterDetails'][$i]['mobile_number']=$row['mobile_number'];
					$i++;}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}$result['add']=grantable('ADD','EMPLOYEE MASTER',$emp_alias);
		$result['export']=grantable('EXPORT','EMPLOYEE MASTER',$emp_alias);
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
function employeemaster_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	$emp_alias = $_REQUEST['emp_alias'];
	if($chk==0){ 
		$con='';
		if(isset($_REQUEST['zone_alias']) && count($_REQUEST['zone_alias'])>0){
			$zone = implode("|",$_REQUEST['zone_alias']);
			$zone_arr=$_REQUEST['zone_alias'];
			$con .= "zone_alias RLIKE '$zone' AND";
		}else{$con .='';}
		if(isset($_REQUEST['state_alias']) && count($_REQUEST['state_alias'])>0){
			$state = implode("|",$_REQUEST['state_alias']);
			$state_arr = $_REQUEST['state_alias'];
			$con .= "state_alias RLIKE '$state' AND";
		}else{$con .= '';}
		if(isset($_REQUEST['asset_alias']) && count($_REQUEST['asset_alias'])>0){
			$asset = implode("|",$_REQUEST['asset_alias']);
			$asset_arr = $_REQUEST['asset_alias'];
			$con .= "asset_alias RLIKE '$asset' AND";
		}else{$con .= '';}
		$empcon = " esca_alias='$emp_alias' AND";
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_employee_master WHERE $empcon $con flag IN('0','1')");
		$colArr=array('Name','Employee Id','Email Id','Mobile Number','Base Location','Qualification','Specialization','Total Experience','El Experience','Joining Date','Relieving Date','Status','Device','Device 2','Created Date','Spl Previlage','Zone','State','Designation','Department','Role','Esca','Privilege','Assets');
		$colArr2=array('name','employee_id','email_id','mobile_number','base_location','qualification','specialization','total_experience','el_experience','joining_date','relieving_date','status','device','device_2','created_date','spl_previlage');
		$filename = 'Employeemaster_'.date('d-m-Y H_i_s');
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
			$asset_alias = explode(", ",$row['asset_alias']);
			$acnt=count($asset_alias);
			$max = max($zcnt,$scnt,$acnt);
			for($z=0;$z<$max;$z++){
				$a = (count($zone_arr) ? in_array($zone_alias[$z],$zone_arr) : TRUE);
				$b = (count($state_arr) ? in_array($state_alias[$z],$state_arr) : TRUE);
				$c = (count($asset_arr) ? in_array($asset_alias[$z],$asset_arr) : TRUE);
				if($a || $b || $c){ $coo++;
					$d = ($zone_alias[$z]!='' ?  alias($zone_alias[$z],'ec_zone','zone_alias','zone_name'):"-");
					$e = ($state_alias[$z]!='' ?  alias($state_alias[$z],'ec_state','state_alias','state_name'):"-");
					$f = ($asset_alias[$z]!='' ?  alias($asset_alias[$z],'ec_assets','asset_alias','asset_name'):"-");
					for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
						$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
					}
					$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$coo, $d);
					$objPHPExcel->getActiveSheet()->SetCellValue('R'.$coo, $e);
					$objPHPExcel->getActiveSheet()->SetCellValue('S'.$coo, alias($row['designation_alias'],'ec_designation','designation_alias','designation'));
					$objPHPExcel->getActiveSheet()->SetCellValue('T'.$coo, alias($row['department_alias'],'ec_department','department_alias','department_name'));
					$objPHPExcel->getActiveSheet()->SetCellValue('U'.$coo, alias($row['role_alias'],'ec_emprole','role_alias','role_name'));
					$objPHPExcel->getActiveSheet()->SetCellValue('V'.$coo, alias($row['esca_alias'],'ec_esca','esca_alias','esca_name'));
					$objPHPExcel->getActiveSheet()->SetCellValue('W'.$coo, alias($row['privilege_alias'],'ec_privileges','privilege_alias','privilege_name'));
					$objPHPExcel->getActiveSheet()->SetCellValue('X'.$coo, $f);
				}
			}
		}	
	$objPHPExcel->getActiveSheet()->setTitle('Employeemaster');
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
function profile_upload(){ global $mr_con;
	$emp_alias=$_REQUEST['emp_alias'];
	$old_profile_pic = $_REQUEST['old_profile_pic'];
	$pic = upload_file($_FILES['profile_pic'],'profile_pic','image');
	$msg = explode(",",$pic);
	if($msg[0]=="0"){$pic = end($msg);
		$sql=mysqli_query($mr_con,"UPDATE ec_employee_master SET profile_pic='$pic' WHERE employee_alias='$emp_alias'");
		if(strpos($old_profile_pic,"gallery")=== false){
			if(isset($old_profile_pic) && file_exists("../../".$old_profile_pic) && $sql){@unlink("../../".$old_profile_pic);}
			$action = alias($emp_alias,'ec_employee_master','employee_alias','name')." Profile picture Updated";
			user_history($emp_alias,$action,$_REQUEST['ip_addr']);
			$resCode="0";$resMsg="Successfull!";
		}
	}else{$resCode=$msg[0];$resMsg=end($msg);}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

//tickets
function ticket_mul_view(){  global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		if($_REQUEST['ticketId']!="")$c1="t1.ticket_id LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['ticketId'])."%' AND ";else $c1="";
		if($_REQUEST['loginDate']!="")$c2="t1.login_date LIKE '%".mysqli_real_escape_string($mr_con,dateFormat($_REQUEST['loginDate'],'y'))."%' AND ";else $c2="";
		if($_REQUEST['activityAlias']!="")$c3="t5.activity_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['activityAlias'])."' AND ";else $c3="";
		if($_REQUEST['segmentAlias']!="")$c4="t4.segment_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['segmentAlias'])."' AND ";else $c4="";
		if($_REQUEST['siteId']!="")$c5="t2.site_name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['siteId'])."%' AND ";else $c5="";
		if($_REQUEST['customerName']!="")$c6="t3.customer_code LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['customerName'])."%' AND ";else $c6="";
		if($_REQUEST['levels']!=""){
			$lvl = mysqli_real_escape_string($mr_con,$_REQUEST['levels']);			
			$c7 = levelCheck($lvl);
		}else {$c7="";}
		if($_REQUEST['tat']!="")$c8="t1.tat ='".mysqli_real_escape_string($mr_con,$_REQUEST['tat'])."' AND ";else $c8="";
		if($_REQUEST['visits']!="")$c9="t1.n_visits = '".mysqli_real_escape_string($mr_con,$_REQUEST['visits'])."' AND ";else $c9="";
		
		$employee_alias=array();
		$recq=mysqli_query($mr_con,"SELECT employee_alias FROM ec_employee_master WHERE esca_alias='$emp_alias' AND flag IN ('0','1')");
		if(mysqli_num_rows($recq)>0){
			while($rowq=mysqli_fetch_array($recq)){$employee_alias[]=$rowq['employee_alias'];  }
		}
		$empls = implode("','",$employee_alias);
		$c11= "t1.service_engineer_alias IN ('$empls') AND ";
		//$c11="";
		//$c11= "t1.ticket_alias IN ('".esca_tkt_alias($employee_alias)."') AND ";
		
		if($_REQUEST['report']!="")$c12="t1.ticket_alias IN (".report_sort($_REQUEST['report']).") AND ";else $c12="";
		if($_REQUEST['mrs']!="")$c13="t1.ticket_alias IN (".mrs_sort($_REQUEST['mrs']).") AND ";else $c13="";
		
		$cond=$c1.$c2.$c3.$c4.$c5.$c6.$c7.$c8.$c9.$c10.$c11.$c12.$c13;
		$rec=mysqli_query($mr_con,"SELECT count(DISTINCT SUBSTRING_INDEX(t1.ticket_id,'|',1)) AS totalListing FROM ec_tickets t1
		INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias
		INNER JOIN ec_customer t3 ON t2.customer_alias=t3.customer_alias
		INNER JOIN ec_segment t4 ON t2.segment_alias=t4.segment_alias
		INNER JOIN ec_activity t5 ON t1.activity_alias=t5.activity_alias
		WHERE $cond t1.flag='0'");
		if(mysqli_num_rows($rec) && count($employee_alias)){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row['totalListing'];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sqlTT = mysqli_query($mr_con,"SELECT t1.ticket_alias,SUBSTRING_INDEX(t1.ticket_id,'|',1) AS ticket_idx,t1.login_date,t1.purpose,t1.planned_date,t1.level,t1.old_level,t1.status,t1.tat,t1.esca_efsr_link,t1.efsr_date,t1.efsr_no,t1.n_visits,t2.site_name,t2.site_id,t3.customer_code,t3.customer_name,t4.segment_code,t4.segment_name,t5.activity_code,t5.activity_name,t6.level_name,t6.level_color FROM ec_tickets t1
				INNER JOIN (SELECT MAX(ID) AS ID FROM ec_tickets GROUP BY SUBSTRING_INDEX(ticket_id,'|',1)) AS P ON (t1.ID=P.ID)
						INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias
						INNER JOIN ec_customer t3 ON t2.customer_alias=t3.customer_alias
						INNER JOIN ec_segment t4 ON t2.segment_alias=t4.segment_alias
						INNER JOIN ec_activity t5 ON t1.activity_alias=t5.activity_alias
						INNER JOIN ec_levels t6 ON t1.level=t6.level_alias
						WHERE $cond t1.flag='0' ORDER BY t1.id DESC LIMIT $offset, $limit");
			//echo "WHERE $cond t1.flag='0'";
			$result['ticketDetails']=array();
			if(mysqli_num_rows($sqlTT)){
				$i=0;while($rowTT = mysqli_fetch_array($sqlTT)){
					$result['ticketDetails'][$i]['ticket_alias']=$rowTT['ticket_alias'];
					$result['ticketDetails'][$i]['ticket_id']=$rowTT['ticket_idx'];//(strpos($rowTT['ticket_id'],"|")!==false ? strtok($rowTT['ticket_id'], "|") : $rowTT['ticket_id']);
					$result['ticketDetails'][$i]['login_date']=dateFormat($rowTT['login_date'],'d');
					$result['ticketDetails'][$i]['activity']=$rowTT['activity_code'];
					$result['ticketDetails'][$i]['levelcolor']=($rowTT['level']=='1' || $rowTT['level']=='2' || $rowTT['level']=='4' || $rowTT['level']=='5' ? repl_planfail_tsrej($rowTT['level'],$rowTT['old_level'],$rowTT['planned_date'],$rowTT['purpose'],'color'):$rowTT['level_color']);
					$result['ticketDetails'][$i]['levelname']=($rowTT['level']=='1' || $rowTT['level']=='2' || $rowTT['level']=='4' || $rowTT['level']=='5' ? repl_planfail_tsrej($rowTT['level'],$rowTT['old_level'],$rowTT['planned_date'],$rowTT['purpose'],'name'):$rowTT['level_name']);
					$result['ticketDetails'][$i]['pl_levelname']=($rowTT['level']=='2' ? $rowTT['planned_date']:$rowTT['level_name']);
					$result['ticketDetails'][$i]['level']=$rowTT['level'];
					$result['ticketDetails'][$i]['status']=$rowTT['status'];
					$result['ticketDetails'][$i]['tat']=(!empty($rowTT['tat']) ? $rowTT['tat'] : tat($rowTT['ticket_alias']));//checkempty($rowTT['tat']);
					$result['ticketDetails'][$i]['visits']=$rowTT['n_visits'];//visits($result['ticketDetails'][$i]['ticket_id']);
					if($rowTT['efsr_no']!=''){
						$result['ticketDetails'][$i]['efsr_date']=$rowTT['efsr_date'];
						if($rowTT['esca_efsr_link']!=''){
							$result['ticketDetails'][$i]['fsrreport']='2';
							$result['ticketDetails'][$i]['esca_efsr_link']=baseurl()."images/esca_efsr/".$rowTT['esca_efsr_link'];
						}else{
							$result['ticketDetails'][$i]['fsrreport']='1';
							$result['ticketDetails'][$i]['esca_efsr_link']=baseurl()."enersyscare_V2/pdf/?ticket_alias=".$rowTT['ticket_alias'];
						}
					}else{$result['ticketDetails'][$i]['fsrreport']=0;}
					$result['ticketDetails'][$i]['mrf'] = mrfStatus($rowTT['ticket_alias']);
						$result['ticketDetails'][$i]['segment_code']=$rowTT['segment_code'];
						$result['ticketDetails'][$i]['segment_name']=$rowTT['segment_name'];
						$result['ticketDetails'][$i]['site_name'] = $rowTT['site_name'];
						$result['ticketDetails'][$i]['customer_code']=$rowTT['customer_code'];
						$result['ticketDetails'][$i]['customer_name']=$rowTT['customer_name'];
					$i++;}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}else{$resCode='4'; $resMsg='No Records Found';}
		$result['add']=grantable('ADD','TICKETS',$emp_alias);
		$result['export']=grantable('EXPORT','TICKETS',$emp_alias);
	}elseif($rex==1){
		$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function ticket_view(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$ticket_id = alias($_REQUEST['alias'],'ec_tickets','ticket_alias','ticket_id');
		if (strpos($ticket_id,"|")!== false){
			$tt = explode("|",$ticket_id);
			$ticket_id = $tt[0];
		}
		$result['main_ticket_id'] = $ticket_id;
		$result['main_ticket_alias'] = $_REQUEST['alias'];
		$lvl = alias($ticket_id,'ec_tickets','ticket_id','level');
		$old_lvl = alias($ticket_id,'ec_tickets','ticket_id','old_level');
		$planned_date = alias($ticket_id,'ec_tickets','ticket_id','planned_date');
		$purpose = alias($ticket_id,'ec_tickets','ticket_id','purpose');
		$result['level_code']=$lvl;
		$result['levelcolor']=($lvl=='1' || $lvl=='2' || $lvl=='4' || $lvl=='5' ? repl_planfail_tsrej($lvl,$old_lvl,$planned_date,$purpose,'color'):alias($lvl,'ec_levels','level_alias','level_color'));
		$result['level']=($lvl=='1' || $lvl=='2' || $lvl=='4' || $lvl=='5' ? repl_planfail_tsrej($lvl,$old_lvl,$planned_date,$purpose,'name'):alias($lvl,'ec_levels','level_alias','level_name'));
		
		$sqlTT = mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE (ticket_id LIKE '%".$ticket_id."|%' OR ticket_id = '$ticket_id') AND flag=0");
		if(mysqli_num_rows($sqlTT)){
			$i=0;while($rowTT = mysqli_fetch_array($sqlTT)){
				$site_alias = $rowTT['site_alias'];
				$ticket_alias = $rowTT['ticket_alias'];
				$result['obj'][$i]['ticket_alias']=$rowTT['ticket_alias'];
				$result['obj'][$i]['main_ticket_id']=$ticket_id;
				$result['obj'][$i]['ticket_id']=$rowTT['ticket_id'];
				$result['obj'][$i]['activity']=alias($rowTT['activity_alias'],'ec_activity','activity_alias','activity_name');
				$sqlSite = mysqli_query($mr_con,"SELECT * FROM ec_sitemaster WHERE site_alias='$site_alias' AND flag=0");
				if(mysqli_num_rows($sqlSite)){
					$rowSite = mysqli_fetch_array($sqlSite);
					$result['obj'][$i]['zone_name']=alias($rowSite['zone_alias'],'ec_zone','zone_alias','zone_name');
					$result['obj'][$i]['state_name']=alias($rowSite['state_alias'],'ec_state','state_alias','state_name');
					$result['obj'][$i]['district_name']=alias($rowSite['district_alias'],'ec_district','district_alias','district_name');
					$result['obj'][$i]['segment_name']=alias($rowSite['segment_alias'],'ec_segment','segment_alias','segment_name');
					$result['obj'][$i]['customer_name']=alias($rowSite['customer_alias'],'ec_customer','customer_alias','customer_name');
					$result['obj'][$i]['site_type']=alias($rowSite['site_type_alias'],'ec_site_type','site_type_alias','site_type');
					$result['obj'][$i]['site_id']=$rowSite['site_id'];
					$result['obj'][$i]['site_name']=$rowSite['site_name'];
					
					$product = explode(", ",$rowSite['product_alias']);
					foreach($product as $pro){ $xx .= alias($pro,'ec_product','product_alias','product_description').", "; }
					$result['obj'][$i]['product_description']=trim($xx,", ");
					
					$result['obj'][$i]['battery_bank_rating']=$rowSite['battery_bank_rating'];
					$result['obj'][$i]['mfd_date']=dateFormat($rowSite['mfd_date'],'d');
					$result['obj'][$i]['install_date']=dateFormat($rowSite['install_date'],'d');
					$result['obj'][$i]['no_of_string']=$rowSite['no_of_string'];
					$result['obj'][$i]['technician_name']=$rowSite['technician_name'];
					$result['obj'][$i]['technician_number']=$rowSite['technician_number'];
					$result['obj'][$i]['manager_name']=$rowSite['manager_name'];
					$result['obj'][$i]['manager_number']=$rowSite['manager_number'];
					$result['obj'][$i]['manager_mail']=$rowSite['manager_mail'];
					$result['obj'][$i]['site_status']=(sitemanfdate_check($site_alias)>0 ? 'UNDER WARRANTY' : 'OUT OF WARRANTY');
					$result['obj'][$i]['site_address']=$rowSite['site_address'];
				}
				$sqlRem = mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE item_alias='$ticket_alias' AND module='TT' AND flag=0");
				if(mysqli_num_rows($sqlRem)){
					$j=0;while($rowRem = mysqli_fetch_array($sqlRem)){
						if($rowRem['remarked_by']=='admin'){$remarked_by='admin'; $designation='admin';}
						else{
							$remarked_by=alias($rowRem['remarked_by'],'ec_employee_master','employee_alias','name');
							$designation=alias(alias($rowRem['remarked_by'],'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','designation');
						}
						$result['obj'][$i]['remark'][$j]['remarkedby']=ucwords(strtolower($remarked_by));
						$result['obj'][$i]['remark'][$j]['designation']=ucwords(strtolower($designation));
						$result['obj'][$i]['remark'][$j]['remarkedon']=dateFormat($rowRem['remarked_on'],'d');
						$result['obj'][$i]['remark'][$j]['remark']=$rowRem['remarks'];
					$j++;}
				}else{$result['obj'][$i]['remark_length']=mysqli_num_rows($sqlRem);}
				$result['obj'][$i]['activity']=alias($rowTT['activity_alias'],'ec_activity','activity_alias','activity_name');
				$result['obj'][$i]['complaint']=alias($rowTT['complaint_alias'],'ec_complaint','complaint_alias','complaint_name');
				$result['obj'][$i]['description']=$rowTT['description'];
				$result['obj'][$i]['login_date']=($rowTT['login_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['login_date']))));
				$result['obj'][$i]['faulty_cell_count']=$rowTT['faulty_cell_count'];
				$result['obj'][$i]['activation_date']=checkempty(dateFormat($rowTT['activation_date'],'d'));
				$result['obj'][$i]['planned_date']=checkempty(dateFormat($rowTT['planned_date'],'d'));
				$result['obj'][$i]['closing_date']=($rowTT['closing_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['closing_date']))));
				$result['obj'][$i]['tat']=tat($ticket_alias);
				$result['obj'][$i]['payment_terms']=checkempty($rowTT['payment_terms']);
				$result['obj'][$i]['milestone']=checkempty(alias($rowTT['milestone'],'ec_milestone','mile_stone_alais','mile_stone'));
				$result['obj'][$i]['mode_of_contact']=$rowTT['mode_of_contact'];
				$result['obj'][$i]['contact_link']=baseurl()."images/reports/".$rowTT['contact_link'];
				$result['obj'][$i]['service_engineer_alias']=checkempty($rowTT['service_engineer_alias']);
				$result['obj'][$i]['service_engineer_name']=alias($rowTT['service_engineer_alias'],'ec_employee_master','employee_alias','name');
				$result['obj'][$i]['level_code']=$rowTT['level'];
				$result['obj'][$i]['old_level_code']=$rowTT['old_level'];
				$result['obj'][$i]['purpose']=$rowTT['purpose'];
				
				$level = $rowTT['level'];
				$result['obj'][$i]['levelcolor']=($level=='2' || $level=='4' || $level=='5' ? repl_planfail_tsrej($level,$rowTT['old_level'],$rowTT['planned_date'],$rowTT['purpose'],'color'):alias($level,'ec_levels','level_alias','level_color'));
				$result['obj'][$i]['level']=($level=='2' || $level=='4' || $level=='5' ? repl_planfail_tsrej($level,$rowTT['old_level'],$rowTT['planned_date'],$rowTT['purpose'],'name'):alias($level,'ec_levels','level_alias','level_name'));

				//$result['edit']=grantable('Edit','Tickets',$emp_alias);
				if($level == '1' || $level == '2'){$result['edit'] = grantable('PD','TICKETS',$emp_alias);}
				elseif($level == '3'){$result['edit'] = grantable('ZHS','TICKETS',$emp_alias);}
				elseif($level == '4'){$result['edit'] = grantable('NHS','TICKETS',$emp_alias);}
				elseif($level == '8'){$result['edit'] = grantable('TS','TICKETS',$emp_alias);}
				else{$result['edit'] = grantable('EDIT','TICKETS',$emp_alias);}

				$result['obj'][$i]['efsr_no']=$rowTT['efsr_no'];
				$result['obj'][$i]['fsrreport']=($rowTT['efsr_no']!='' ? "e-FSR" : "-");
				$result['obj'][$i]['efsr_date']=date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['efsr_date'])));
				$result['obj'][$i]['status']=$rowTT['status'];
			$i++;}
			$resCode='0'; $resMsg='Successful!';
		}else{$resCode='4'; $resMsg='No Records Found';}
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function ticket_export(){ global $mr_con;
	set_time_limit(0);
	ini_set('memory_limit', '512M');
	$emp_ali = $_REQUEST['emp_alias'];
	$token = $_REQUEST['token'];
	$chk=authentication($emp_ali,$token);
	if($chk==0){ $con='';$in_emp='';
	$esca_sql = mysqli_query($mr_con,"SELECT GROUP_CONCAT(employee_alias SEPARATOR ''',''') AS emp_ali FROM ec_employee_master WHERE esca_alias='$emp_ali' AND flag='0'");
	if(mysqli_num_rows($esca_sql)){
		$esca_row = mysqli_fetch_array($esca_sql);
		$in_emp = $esca_row['emp_ali'];
	}
	$con .= "T1.service_engineer_alias IN('$in_emp') AND ";
	if(isset($_REQUEST['zone_alias']) && count($_REQUEST['zone_alias'])>0){
		$zone = implode("|",$_REQUEST['zone_alias']);
		$zone_arr = $_REQUEST['zone_alias'];
		$con .= "T2.zone_alias RLIKE '$zone' AND ";
	}
	if(isset($_REQUEST['state_alias']) && count($_REQUEST['state_alias'])>0){
		$state = implode("|",$_REQUEST['state_alias']);
		$state_arr = $_REQUEST['state_alias'];
		$con .= "T2.state_alias RLIKE '$state' AND ";
	}
	if(isset($_REQUEST['activity_alias']) && count($_REQUEST['activity_alias'])>0)$con .= "T1.activity_alias RLIKE '".implode("|",$_REQUEST['activity_alias'])."' AND ";
	if(isset($_REQUEST['complaint_alias']) && count($_REQUEST['complaint_alias'])>0)$con .= "T1.complaint_alias RLIKE '".implode("|",$_REQUEST['complaint_alias'])."' AND ";
	if(isset($_REQUEST['customer_alias']) && count($_REQUEST['customer_alias'])>0)$con .= "T2.customer_alias RLIKE '".implode("|",$_REQUEST['customer_alias'])."' AND ";
	if(isset($_REQUEST['level_alias']) && count($_REQUEST['level_alias'])>0){
		$level_alias=$_REQUEST['level_alias'];
		if(!in_array('2',$level_alias) && !in_array('8',$level_alias))$con .= "T1.level RLIKE '".implode("|",$level_alias)."' AND ";
		else foreach($level_alias as $lvl)$con .= levelCheck($lvl);
	}
	if(isset($_REQUEST['segment_alias']) && count($_REQUEST['segment_alias'])>0)$con .= "T2.segment_alias RLIKE '".implode("|",$_REQUEST['segment_alias'])."' AND ";
	if(isset($_REQUEST['product']) && count($_REQUEST['product'])>0)$con .= "T2.product_alias RLIKE '".implode("|",$_REQUEST['product'])."' AND ";
	if(isset($_REQUEST['tat']) && count($_REQUEST['tat'])>0)$con .= "T1.tat RLIKE '".implode("|",$_REQUEST['tat'])."' AND ";
	if(isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date']))$con .= "login_date >= '".dateFormat($_REQUEST['from_date'],'y')."' AND ";
	if(isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date']))$con .= "login_date <= '".dateFormat($_REQUEST['to_date'],'y')." 23:59:59' AND ";
	$export_bifurcation = array();
	if(isset($_REQUEST['export_bifurcation']) && count($_REQUEST['export_bifurcation'])>0){
		$export_bifurcation = $_REQUEST['export_bifurcation'];
		$valid = TRUE;
	}else{$valid = FALSE;}
	if($valid){
	$f_arr = array(1=>'TICKETS_',2=>'TTSA_');
	foreach($f_arr as $k=>$v){
		if(in_array($k,$export_bifurcation)){// || !count($export_bifurcation)
			$file_name .= $v;
			if($k==1){$tt_dt=TRUE;}
			if($k==2){$tt_sa=TRUE;}
		}
	}
	$filename = $file_name.date('d-m-Y H_i_s');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("EnersysCare")->setLastModifiedBy("EnersysCare")->setTitle("Office 2007 XLSX Tickets Document")->setSubject("Office 2007 XLSX Tickets Document")->setDescription("Tickets document for Office 2007 XLSX, generated using PHP classes.");
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
	$no_rec=$sh_index = 0;
	if($tt_dt){
		$objPHPExcel->setActiveSheetIndex($sh_index);
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setTitle('Tickets');
		$sql=mysqli_query($mr_con,"SELECT T1.*, T2.* FROM ec_tickets T1 JOIN ec_sitemaster T2 ON T1.site_alias = T2.site_alias AND $con T1.flag=0");
		if(mysqli_num_rows($sql)){
			$colArr = array("Ticket ID","Login Date","Visit Generated Date","Mode Of Contact","Zone","State","District","Site ID","Site Name","Site Address","First Level Contact Name","First Level Contact Number","Second Level Contact Name","Second Level Contact Number","Second Level Contact Email","Segment","Customer","Activity","Nature of Complaint","Complaint Description","No of Faulty Cells reported by Customer","No of Faulty Cells reported by Service Engineer","Product","Battery Bank Rating","No Of String","Mfd Date","Install Date","Site Type","Warranty Status","Activation Date","Planned Date","Planned Service Engineer","Planned Service Engineer Role","Planned Service Engineer Number","efsr No","efsr Date","Closing Date","TAT","Visits","Level","Ticket Status","Milestone","eFSR Efficiency","MRS","Visited SE Name","Visited SE Remarks","Visited SE Action Date and Time","Visited SE Action Taken","ZHS Name","ZHS Remarks","ZHS Action Date and Time","ZHS Aging","NHS Name","NHS Remarks","NHS Action Date and Time","NHS Aging");
			//$colArr2=array('ticket_id','mode_of_contact','faulty_cell_count','description','login_date','activation_date','planned_date','payment_terms','closing_date','status','site_id','mfd_date','install_date','no_of_string','technician_name','technician_number','manager_name','manager_number','manager_mail','site_address');
			$last_key = end(array_keys($colArr));
			$last_alpha = num2alpha($last_key);
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
			$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue)); $ch++; }
			$date_arr = array("B","C","AB","AC","AE","AH","AK","AL","AQ","AR","BC","BH","BM","BR","BV","BY","CB","CE","CI");
			foreach($date_arr as $da){$sheet->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension($da)->setAutoSize(true);}
			$coo=1;
			while($row=mysqli_fetch_array($sql)){ $coo++;
				// 1) Ticket Details
				$ticket_alias = $row['ticket_alias'];
				
				// 2) Faulty Count
				$f_count1 = alias($ticket_alias,'ec_engineer_observation','ticket_alias','total_faulty_count');
				$rep_cells=alias($ticket_alias,'ec_engineer_observation','ticket_alias','replaced_cell_no');
				if(!empty($rep_cells) && strtoupper($rep_cells)!="NIL" && $rep_cells!="-" && $rep_cells!="0"){
					$rep_count=count(explode(",",str_replace(" ","",$rep_cells)));
				}else $rep_count='0';
				if(strpos($row['ticket_id'],"|")!==false)if($f_count1=="NA" || $f_count1=="")$f_count1 = alias(alias(strtok($row['ticket_id'], "|"),'ec_tickets','ticket_id','ticket_alias'),'ec_engineer_observation','ticket_alias','total_faulty_count');
				$rem_result=all_remarks($ticket_alias);
				// 1) Ticket Details
				$ticket_id = strtok($row['ticket_id'],"|");
				$sheet->SetCellValue('A'.$coo, checkemptydash($ticket_id))
					->SetCellValue('B'.$coo, ($row['login_date']=="" ? "-" : php_excel_date($row['login_date'])))
					->SetCellValue('C'.$coo, ($row['visit_gen_date']=="" ? "-" : php_excel_date($row['visit_gen_date'])))
					->SetCellValue('D'.$coo, checkemptydash(alias($row['mode_of_contact'],'ec_moc','moc_alias','moc_name')))
					->SetCellValue('E'.$coo, checkemptydash($row['moc_num']))
					->SetCellValue('F'.$coo, checkemptydash(alias($row['zone_alias'],'ec_zone','zone_alias','zone_name')))
					->SetCellValue('G'.$coo, checkemptydash(alias($row['state_alias'],'ec_state','state_alias','state_name')))
					->SetCellValue('H'.$coo, checkemptydash(alias($row['district_alias'],'ec_district','district_alias','district_name')))
					->SetCellValue('I'.$coo, checkemptydash($row['site_id']))
					->SetCellValue('J'.$coo, checkemptydash($row['site_name']))
					->SetCellValue('K'.$coo, checkemptydash($row['site_address']))
					->SetCellValue('L'.$coo, checkemptydash($row['technician_name']))
					->SetCellValue('M'.$coo, checkemptydash($row['technician_number']))
					->SetCellValue('N'.$coo, checkemptydash($row['manager_name']))
					->SetCellValue('O'.$coo, checkemptydash($row['manager_number']))
					->SetCellValue('P'.$coo, checkemptydash($row['manager_mail']))
					->SetCellValue('Q'.$coo, checkemptydash(alias($row['segment_alias'],'ec_segment','segment_alias','segment_name')))
					->SetCellValue('R'.$coo, checkemptydash(alias($row['customer_alias'],'ec_customer','customer_alias','customer_code')))
					->SetCellValue('S'.$coo, checkemptydash(alias($row['activity_alias'],'ec_activity','activity_alias','activity_name')))
					->SetCellValue('T'.$coo, checkemptydash(alias($row['complaint_alias'],'ec_complaint','complaint_alias','complaint_name')))
					->SetCellValue('U'.$coo, checkemptydash($row['description']))
					->SetCellValue('V'.$coo, checkemptydash($row['faulty_cell_count']))
					->SetCellValue('W'.$coo, checkemptydash($f_count1))
					->SetCellValue('X'.$coo, checkemptydash($rep_count))
					->SetCellValue('Y'.$coo, checkemptydash(alias($row['product_alias'],'ec_product','product_alias','product_description')))
					->SetCellValue('Z'.$coo, checkemptydash($row['battery_bank_rating']))
					->SetCellValue('AA'.$coo, checkemptydash($row['no_of_string']))
					->SetCellValue('AB'.$coo, php_excel_date($row['mfd_date']))
					->SetCellValue('AC'.$coo, php_excel_date($row['install_date']))
				
					->SetCellValue('AD'.$coo, checkemptydash($row['sale_invoice_num']))
					->SetCellValue('AE'.$coo, php_excel_date($row['sale_invoice_date']))
					->SetCellValue('AF'.$coo, checkemptydash($row['po_num']))
					->SetCellValue('AG'.$coo, checkemptydash($row['po_number']))
					->SetCellValue('AH'.$coo, php_excel_date($row['po_date']))
					
					->SetCellValue('AI'.$coo, checkemptydash(alias($row['site_type_alias'],'ec_site_type','site_type_alias','site_type')))
					->SetCellValue('AJ'.$coo, ($row['warranty']>0 ? 'UNDER WARRANTY' : 'OUT OF WARRANTY'))
					->SetCellValue('AK'.$coo, php_excel_date($row['activation_date']))
					->SetCellValue('AL'.$coo, php_excel_date($row['planned_date']))
					->SetCellValue('AM'.$coo, checkemptydash(alias_flag_none($row['service_engineer_alias'],'ec_employee_master','employee_alias','name')))
					->SetCellValue('AN'.$coo, checkemptydash(alias(alias($row['service_engineer_alias'],'ec_employee_master','employee_alias','role_alias'),'ec_emprole','role_alias','role_name')))
					->SetCellValue('AO'.$coo, checkemptydash(alias_flag_none($row['service_engineer_alias'],'ec_employee_master','employee_alias','mobile_number')))
					->SetCellValue('AP'.$coo, checkemptydash($row['efsr_no']))
					->SetCellValue('AQ'.$coo, ($row['efsr_date']=="" ? "-" : php_excel_date($row['efsr_date'])))
					->SetCellValue('AR'.$coo, ($row['closing_date']=="" || $row['level']<6 ? "-" : php_excel_date($row['closing_date'])))
					->SetCellValue('AS'.$coo, checkemptydash((!empty($row['tat']) ? $row['tat'] : tat($row['ticket_alias']))))
					->SetCellValue('AT'.$coo, visit_exp_count($ticket_id))
					->SetCellValue('AU'.$coo, checkemptydash(($row['level']=='1' || $row['level']=='2' || $row['level']=='4' || $row['level']=='5' ? repl_planfail_tsrej($row['level'],$row['old_level'],$row['planned_date'],$row['purpose'],'name'):alias($row['level'],'ec_levels','level_alias','level_name'))))
					->SetCellValue('AV'.$coo, checkemptydash($row['status']))
					->SetCellValue('AW'.$coo, checkemptydash(alias($row['milestone'],'ec_milestone','mile_stone_alais','mile_stone')))
					->SetCellValue('AX'.$coo, checkemptydash($row['payment_terms']))
					->SetCellValue('AY'.$coo, checkemptydash(mrfStatus($row['ticket_alias'])))
					
					->SetCellValue('AZ'.$coo,checkemptydash(implode(" | ",$rem_result['se_rem'])))
					->SetCellValue('BA'.$coo,checkemptydash(implode(" | ",$rem_result['se_buc'])))
					->SetCellValue('BB'.$coo,checkemptydash(implode(" | ",$rem_result['se_by'])))
					->SetCellValue('BC'.$coo,checkemptydash((count($rem_result['se_on'])==1 ? php_excel_date(end($rem_result['se_on'])) : implode(" | ",$rem_result['se_on']))))
					->SetCellValue('BD'.$coo,checkemptydash(implode(" | ",$rem_result['se_act'])))

					->SetCellValue('BE'.$coo,checkemptydash(implode(" | ",$rem_result['zhs_rem'])))
					->SetCellValue('BF'.$coo,checkemptydash(implode(" | ",$rem_result['zhs_buc'])))
					->SetCellValue('BG'.$coo,checkemptydash(implode(" | ",$rem_result['zhs_by'])))
					
					->SetCellValue('BH'.$coo,checkemptydash((count($rem_result['zhs_on'])==1 ? php_excel_date(end($rem_result['zhs_on'])) : implode(" | ",$rem_result['zhs_on']))))
					->SetCellValue('BI'.$coo,checkemptydash(implode(" | ",$rem_result['zhs_age'])))

					->SetCellValue('BJ'.$coo,checkemptydash(implode(" | ",$rem_result['nhs_rem'])))
					->SetCellValue('BK'.$coo,checkemptydash(implode(" | ",$rem_result['nhs_buc'])))
					->SetCellValue('BL'.$coo,checkemptydash(implode(" | ",$rem_result['nhs_by'])))
					->SetCellValue('BM'.$coo,checkemptydash((count($rem_result['nhs_on'])==1 ? php_excel_date(end($rem_result['nhs_on'])) : implode(" | ",$rem_result['nhs_on']))))
					->SetCellValue('BN'.$coo,checkemptydash(implode(" | ",$rem_result['nhs_age'])))

					->SetCellValue('BO'.$coo,checkemptydash(implode(" | ",$rem_result['ts_rem'])))
					->SetCellValue('BP'.$coo,checkemptydash(implode(" | ",$rem_result['ts_buc'])))
					->SetCellValue('BQ'.$coo,checkemptydash(implode(" | ",$rem_result['ts_by'])))
					->SetCellValue('BR'.$coo,checkemptydash((count($rem_result['ts_on'])==1 ? php_excel_date(end($rem_result['ts_on'])) : implode(" | ",$rem_result['ts_on']))))
					->SetCellValue('BS'.$coo,checkemptydash(implode(" | ",$rem_result['ts_age'])))
					
					->SetCellValue('BT'.$coo,checkemptydash(implode(" | ",$rem_result['out_rem'])))
					->SetCellValue('BU'.$coo,checkemptydash(implode(" | ",$rem_result['out_by'])))
					->SetCellValue('BV'.$coo,checkemptydash((count($rem_result['out_on'])==1 ? php_excel_date(end($rem_result['out_on'])) : implode(" | ",$rem_result['out_on']))))
					
					->SetCellValue('BW'.$coo,checkemptydash(implode(" | ",$rem_result['ai_rem'])))
					->SetCellValue('BX'.$coo,checkemptydash(implode(" | ",$rem_result['ai_by'])))
					->SetCellValue('BY'.$coo,checkemptydash((count($rem_result['ai_on'])==1 ? php_excel_date(end($rem_result['ai_on'])) : implode(" | ",$rem_result['ai_on']))))
					
					->SetCellValue('BZ'.$coo,checkemptydash(implode(" | ",$rem_result['req_rem'])))
					->SetCellValue('CA'.$coo,checkemptydash(implode(" | ",$rem_result['req_by'])))
					->SetCellValue('CB'.$coo,checkemptydash((count($rem_result['req_on'])==1 ? php_excel_date(end($rem_result['req_on'])) : implode(" | ",$rem_result['req_on']))))
					
					->SetCellValue('CC'.$coo,checkemptydash(implode(" | ",$rem_result['plan_rem'])))
					->SetCellValue('CD'.$coo,checkemptydash(implode(" | ",$rem_result['plan_by'])))
					->SetCellValue('CE'.$coo,checkemptydash((count($rem_result['plan_on'])==1 ? php_excel_date(end($rem_result['plan_on'])) : implode(" | ",$rem_result['plan_on']))))
					
					->SetCellValue('CF'.$coo,checkemptydash(implode(" | ",$rem_result['other_rem'])))
					->SetCellValue('CG'.$coo,checkemptydash(implode(" | ",$rem_result['other_buc'])))
					->SetCellValue('CH'.$coo,checkemptydash(implode(" | ",$rem_result['other_by'])))
					->SetCellValue('CI'.$coo,checkemptydash((count($rem_result['other_on'])==1 ? php_excel_date(end($rem_result['other_on'])) : implode(" | ",$rem_result['other_on']))));
			}$no_rec++;
		}$sh_index++;
	}
//TT SA
	if($tt_sa){
		if($sh_index>0){ $objPHPExcel->createSheet(); }
		$objPHPExcel->setActiveSheetIndex($sh_index);
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setTitle('TT SA');
		$sql=mysqli_query($mr_con,"SELECT T1.*, T2.* FROM ec_tickets T1 JOIN ec_sitemaster T2 ON T1.site_alias = T2.site_alias AND $con T1.flag=0");
		if(mysqli_num_rows($sql)){
			$colArr = array("Ticket ID","Login Date","Visit Generated Date","Mode Of Contact","Zone","State","District","Site ID","Site Name","Site Address","First Level Contact Name","First Level Contact Number","Second Level Contact Name","Second Level Contact Number","Second Level Contact Email","Segment","Customer","Activity","Nature of Complaint","Complaint Description","No of Faulty Cells reported by Customer","No of faulty cells reported by Service Engineer","Product","Battery Bank Rating","No Of String","Mfd Date","Install Date","Site Type","Warranty Status","Activation Date","Planned Date","Planned Service Engineer","Planned Service Engineer Role","Planned Service Engineer Number","efsr No","efsr Date","Closing Date","TAT","Visits","Level","Ticket Status","Milestone","eFSR Efficiency","MRS","Faulty Code","Job Performed","Train No","Express Name","Coach No","Pre Attnd","Poh","Rpoh","Zone","Division","Workshop","Altenate Make","RRU Make","Invertor Make","Regulator Make","Voltage Regulation","Altenate Belt Status","Icc Tightness","Heating Melting Marks","Terminal Tightness","Alt No Belt Avl","Physical Damage","Vent Plug Tightness","Belt","Log Book","Coach Status","Cell Buldge","Charger Band","Manf Date","Serial No","Charger Type","Voltage","Charging Current","High Voltage Cutoff","Voltage Ripple","Voltage Regulation","Fork Lift Brand","Fork Lift Model","Fork Lift Manf Date","Battery Type","Bank Serial No","Manfacturing Date","Installation Date","Plug Type","Acid Level","Float Voltage","Boast Voltage","Current Limit","Voltage Ripple","Voltage Rgulation","High Voltage Cutoff","Low Voltage Cutoff","Panel Make","Panel Rating","Charge Controller Rate","Charge Controller Make","No Solar Panels","Single Panel Rating","Panel Manufacturing Date","Charge Control Manufacturing Date","Panel Installation Date","Physical Damages","Leakage","Temperature","Acid Temp Discharge","Acid Temp Charge","Cells Temp After Use","Cells Temp At Charge","General Observation","Terminal Torque","Vent Plug Thickness","Site Load","Dg Status","Dg Make","Dg Capacity","Dg Working Condition","Avg Dg Run","Eb Supply","Failures Per Day","Avg Power Cut","Required Acc","Required Cells","Faulty Cell Sr No","Replaced Cells Count","Customer Comments","Customer Name","Customer Designation","Customer Contact Number","Customer Email","Rating 1","Rating 2","Rating 3","Rating 4","Rating 5","Visited SE Name","Visited SE Remarks","Visited SE Action Date and Time","Visited SE Action Taken","ZHS Name","ZHS Remarks","ZHS Action Date and Time","ZHS Aging","NHS Name","NHS Remarks","NHS Action Date and Time","NHS Aging");
			//$colArr2=array('ticket_id','mode_of_contact','faulty_cell_count','description','login_date','activation_date','planned_date','payment_terms','closing_date','status','site_id','mfd_date','install_date','no_of_string','technician_name','technician_number','manager_name','manager_number','manager_mail','site_address');
			$last_key = end(array_keys($colArr));
			$last_alpha = num2alpha($last_key);
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
			$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue)); $ch++; }
			$sqlR=mysqli_query($mr_con,"SELECT COUNT(id) AS mycount FROM ec_remarks WHERE module='TT' AND flag=0 GROUP BY item_alias ORDER BY mycount DESC LIMIT 1");
			$rowR=mysqli_fetch_array($sqlR);
			$max_rem_count = $rowR['0'];
			$xx = $yy = 'EU'; 
			for($h=0;$h<$max_rem_count;$h++){
				$sheet->SetCellValue($xx.'1','Remarked By ('.($h+1).')'); $xx++;
				$sheet->SetCellValue($xx.'1','Remark ('.($h+1).')');  $xx++;
				$sheet->SetCellValue($xx.'1','Remarked On ('.($h+1).')');
				$sheet->getStyle($xx)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension($xx)->setAutoSize(true);
				$xx++;
			} $xx--;
			$sheet->getStyle($yy.'1:'.$xx.'1')->applyFromArray($styleArray);
			$sheet->getStyle($yy.'1:'.$xx.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$date_arr = array("B","C","Z","AA","AD","AE","AJ","AK","AX","AY","AZ","BU","CE","CH","CI","CY","CZ","DA","EK","EO","ES");
			foreach($date_arr as $da){$sheet->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension($da)->setAutoSize(true);}
			$coo=1;
			while($row=mysqli_fetch_array($sql)){ $coo++;
				// 1) Ticket Details
				$ticket_alias = $row['ticket_alias'];
				
				// 2) Engineer Observation
				$tkt_segeng=mysqli_query($mr_con,"SELECT * FROM ec_engineer_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_segeng_row=mysqli_fetch_array($tkt_segeng);
				$f_count = $tkt_segeng_row['total_faulty_count'];
				$rep_cells = $tkt_segeng_row['replaced_cell_no'];
				if(!empty($rep_cells) && strtoupper($rep_cells)!="NIL" && $rep_cells!="-" && $rep_cells!="0"){
					$rep_count=count(explode(",",str_replace(" ","",$rep_cells)));
				}else{$rep_count='0';}
				if(strpos($row['ticket_id'],"|")!==false){
					if(empty(mysqli_num_rows($tkt_segeng)) || $f_count==""){
						$f_count = alias(alias(strtok($row['ticket_id'], "|"),'ec_tickets','ticket_id','ticket_alias'),'ec_engineer_observation','ticket_alias','total_faulty_count');
					}
				}	
				// 3) Coach History
				$tkt_seg=mysqli_query($mr_con,"SELECT * FROM ec_coach_history WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_seg_row=mysqli_fetch_array($tkt_seg);
				
				// 4) Equipment Details
				$tkt_segeq=mysqli_query($mr_con,"SELECT * FROM ec_equip_details WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_segeq_row=mysqli_fetch_array($tkt_segeq);
				
				// 5) Checkpoints
				$tkt_segchk=mysqli_query($mr_con,"SELECT * FROM  ec_check_points WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_segchk_row=mysqli_fetch_array($tkt_segchk);
				
				// 6) Charger Details
				$tkt_segchg=mysqli_query($mr_con,"SELECT * FROM  ec_charger_details WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_segchg_row=mysqli_fetch_array($tkt_segchg);
				
				// 7) Fork Lift
				$tkt_segfrk=mysqli_query($mr_con,"SELECT * FROM  ec_fork_lift WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_segfrk_row=mysqli_fetch_array($tkt_segfrk);
				
				// 8) Battery Details
				$tkt_segbat=mysqli_query($mr_con,"SELECT * FROM  ec_battery_details WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_segbat_row=mysqli_fetch_array($tkt_segbat);
				
				// 9) Technical observations
				$tkt_segtch=mysqli_query($mr_con,"SELECT * FROM  ec_technical_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_segtch_row=mysqli_fetch_array($tkt_segtch);
				
				// 10) physical Observations
				$tkt_segphy=mysqli_query($mr_con,"SELECT * FROM  ec_physical_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_segphy_row=mysqli_fetch_array($tkt_segphy);
				
				// 11) General Observations
				$tkt_seggnr=mysqli_query($mr_con,"SELECT * FROM  ec_general_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_seggnr_row=mysqli_fetch_array($tkt_seggnr);
				
				// 12) Power Observations
				$tkt_segpwr=mysqli_query($mr_con,"SELECT * FROM  ec_power_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_segpwr_row=mysqli_fetch_array($tkt_segpwr);
				
				// 13) E-signature 
				$tkt_segesig=mysqli_query($mr_con,"SELECT * FROM  ec_e_signature WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_segesig_row=mysqli_fetch_array($tkt_segesig);
				
				// 14) Customer Satisfaction
				$tkt_segsatis=mysqli_query($mr_con,"SELECT * FROM  ec_customer_satisfaction WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_segsatis_row=mysqli_fetch_array($tkt_segsatis);
				
				// 15) Remarks
				$sqlRem=mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE module='TT' AND item_alias='$ticket_alias' AND flag=0 ORDER BY id");
				$seBy='';$seOn='';$seRem='';$seAction='';$zhsBy='';$zhsOn='';$zhsRem='';$zhsAge='';$nhsBy='';$nhsOn='';$nhsRem='';$nhsAge='';
				//unset($othBy);unset($othOn);unset($othRem);
				$othBy = array();$othOn = array();$othRem = array();
				while($rowRem = mysqli_fetch_array($sqlRem)){
					if(strtoupper($rowRem['remarked_by'])=='ADMIN'){
						$othBy[]='ADMIN';
						$othOn[]=($rowRem['remarked_on']=="" || $rowRem['remarked_on']=="0000-00-00 00:00:00" ? "-" : php_excel_date($rowRem['remarked_on']));
						$othRem[]= $rowRem['remarks'];
					}else{
						$remarked_by=alias_flag_none($rowRem['remarked_by'],'ec_employee_master','employee_alias','name');
						$remarked_on = ($rowRem['remarked_on']=="" || $rowRem['remarked_on']=="0000-00-00 00:00:00" ? "-" : php_excel_date($rowRem['remarked_on']));
						$remarks = $rowRem['remarks'];
						$bucket=$rowRem['bucket'];
						//$privilege_alias = alias_flag_none($rowRem['remarked_by'],'ec_employee_master','employee_alias','privilege_alias');
						//if($privilege_alias=='3WDRECJ0MA' || $privilege_alias=='PCNKPSJJEU' ){
						if($rowRem['remarked_by']==$row['service_engineer_alias'] && $seBy=='' && ($bucket=='7' || $bucket=='8')){
							$seBy=$remarked_by;
							$seOn=$remarked_on;
							$seOn_aging=$rowRem['remarked_on'];
							$seRem=$remarks;
							$seAction=alias($ticket_alias,'ec_ticket_action','ticket_alias','observation');
						}elseif($zhsBy=='' && ($bucket=='1' || $bucket=='2' || $bucket=='9' || $bucket=='11')){
							$zhsBy=$remarked_by;
							$zhsOn=$remarked_on;
							$zhsOn_aging=$rowRem['remarked_on'];
							$zhsRem=$remarks;
							$zhsAge=aging($seOn_aging,$rowRem['remarked_on']);
						}elseif($nhsBy=='' && ($bucket=='37' || $bucket=='38' || $bucket=='10' || $bucket=='39')){
							$nhsBy=$remarked_by;
							$nhsOn=$remarked_on;
							$nhsRem=$remarks;
							$nhsAge=aging($zhsOn_aging,$rowRem['remarked_on']);
						}else{
							$othBy[]=$remarked_by;
							$othOn[]=$remarked_on;
							$othRem[]=$remarks;
						}
					}
				}
				
				// 1) Ticket Details
					$ticket_id = strtok($row['ticket_id'],"|");
					$sheet->SetCellValue('A'.$coo, checkemptydash($ticket_id))
						->SetCellValue('B'.$coo, ($row['login_date']=="" ? "-" : php_excel_date($row['login_date'])))
						->SetCellValue('C'.$coo, ($row['visit_gen_date']=="" ? "-" : php_excel_date($row['visit_gen_date'])))
						->SetCellValue('D'.$coo, checkemptydash($row['mode_of_contact']))
						->SetCellValue('E'.$coo, checkemptydash(alias($row['zone_alias'],'ec_zone','zone_alias','zone_name')))
						->SetCellValue('F'.$coo, checkemptydash(alias($row['state_alias'],'ec_state','state_alias','state_name')))
						->SetCellValue('G'.$coo, checkemptydash(alias($row['district_alias'],'ec_district','district_alias','district_name')))
						->SetCellValue('H'.$coo, checkemptydash($row['site_id']))
						->SetCellValue('I'.$coo, checkemptydash($row['site_name']))
						->SetCellValue('J'.$coo, checkemptydash($row['site_address']))
						->SetCellValue('K'.$coo, checkemptydash($row['technician_name']))
						->SetCellValue('L'.$coo, checkemptydash($row['technician_number']))
						->SetCellValue('M'.$coo, checkemptydash($row['manager_name']))
						->SetCellValue('N'.$coo, checkemptydash($row['manager_number']))
						->SetCellValue('O'.$coo, checkemptydash($row['manager_mail']))
						->SetCellValue('P'.$coo, checkemptydash(alias($row['segment_alias'],'ec_segment','segment_alias','segment_name')))
						->SetCellValue('Q'.$coo, checkemptydash(alias($row['customer_alias'],'ec_customer','customer_alias','customer_code')))
						->SetCellValue('R'.$coo, checkemptydash(alias($row['activity_alias'],'ec_activity','activity_alias','activity_name')))
						->SetCellValue('S'.$coo, checkemptydash(alias($row['complaint_alias'],'ec_complaint','complaint_alias','complaint_name')))
						->SetCellValue('T'.$coo, checkemptydash($row['description']))
						->SetCellValue('U'.$coo, checkemptydash($row['faulty_cell_count']))
						->SetCellValue('V'.$coo, checkemptydash($f_count))
						->SetCellValue('W'.$coo, checkemptydash(alias($row['product_alias'],'ec_product','product_alias','product_description')))
						->SetCellValue('X'.$coo, checkemptydash($row['battery_bank_rating']))
						->SetCellValue('Y'.$coo, checkemptydash($row['no_of_string']))
						->SetCellValue('Z'.$coo, php_excel_date($row['mfd_date']))
						->SetCellValue('AA'.$coo, php_excel_date($row['install_date']))
						->SetCellValue('AB'.$coo, checkemptydash(alias($row['site_type_alias'],'ec_site_type','site_type_alias','site_type')))
						->SetCellValue('AC'.$coo, (sitemanfdate_check($row['site_alias']) ? "UNDER WARRANTY" : "OUT OF WARRANTY"))
						->SetCellValue('AD'.$coo, php_excel_date($row['activation_date']))
						->SetCellValue('AE'.$coo, php_excel_date($row['planned_date']))
						->SetCellValue('AF'.$coo, checkemptydash(alias_flag_none($row['service_engineer_alias'],'ec_employee_master','employee_alias','name')))
						->SetCellValue('AG'.$coo, checkemptydash(alias(alias_flag_none($row['service_engineer_alias'],'ec_employee_master','employee_alias','role_alias'),'ec_emprole','role_alias','role_name')))
						->SetCellValue('AH'.$coo, checkemptydash(alias_flag_none($row['service_engineer_alias'],'ec_employee_master','employee_alias','mobile_number')))
						->SetCellValue('AI'.$coo, checkemptydash($row['efsr_no']))
						->SetCellValue('AJ'.$coo, ($row['efsr_date']=="" ? "-" : php_excel_date($row['efsr_date'])))
						->SetCellValue('AK'.$coo, ($row['closing_date']=="" || $row['level']<6 ? "-" : php_excel_date($row['closing_date'])))
						->SetCellValue('AL'.$coo, checkemptydash((!empty($row['tat']) ? $row['tat'] : tat($ticket_alias))))
						->SetCellValue('AM'.$coo, visit_exp_count($ticket_id))
						->SetCellValue('AN'.$coo, checkemptydash(($row['level']=='1' || $row['level']=='2' || $row['level']=='4' || $row['level']=='5' ? repl_planfail_tsrej($row['level'],$row['old_level'],$row['planned_date'],$row['purpose'],'name'):alias($row['level'],'ec_levels','level_alias','level_name'))))
						->SetCellValue('AO'.$coo, checkemptydash($row['status']))
						->SetCellValue('AP'.$coo, checkemptydash(alias($row['milestone'],'ec_milestone','mile_stone_alais','mile_stone')))
						->SetCellValue('AQ'.$coo, checkemptydash($row['payment_terms']))
						->SetCellValue('AR'.$coo, checkemptydash(mrfStatus($row['ticket_alias'])))
				// 2) Engineer Observation
						->SetCellValue('AS'.$coo, checkemptydash(alias($tkt_segeng_row['faulty_code_alias'],'ec_faulty_code','faulty_alias','description')))
						->SetCellValue('AT'.$coo, checkemptydash($tkt_segeng_row['job_performed']))
				// 3) Coach History
						->SetCellValue('AU'.$coo, checkemptydash($tkt_seg_row['train_no']))
						->SetCellValue('AV'.$coo, checkemptydash($tkt_seg_row['express_name']))
						->SetCellValue('AW'.$coo, checkemptydash($tkt_seg_row['coach_no']))
						->SetCellValue('AX'.$coo, php_excel_date($tkt_seg_row['pre_attnd']))
						->SetCellValue('AY'.$coo, php_excel_date($tkt_seg_row['poh']))
						->SetCellValue('AZ'.$coo, php_excel_date($tkt_seg_row['rpoh']))
						->SetCellValue('BA'.$coo, checkemptydash($tkt_seg_row['zone']))
						->SetCellValue('BB'.$coo, checkemptydash($tkt_seg_row['division']))
						->SetCellValue('BC'.$coo, checkemptydash($tkt_seg_row['workshop']))
				// 4) Equipment details
						->SetCellValue('BD'.$coo, checkemptydash($tkt_segeq_row['altenate_make']))
						->SetCellValue('BE'.$coo, checkemptydash($tkt_segeq_row['rru_make']))
						->SetCellValue('BF'.$coo, checkemptydash($tkt_segeq_row['invertor_make']))
						->SetCellValue('BG'.$coo, checkemptydash($tkt_segeq_row['regulator_make']))
						->SetCellValue('BH'.$coo, checkemptydash($tkt_segeq_row['voltage_regulation']))
						->SetCellValue('BI'.$coo, checkemptydash($tkt_segeq_row['altenate_belt_status']))
				// 5) Checkpoints
						->SetCellValue('BJ'.$coo, checkemptydash($tkt_segchk_row['icc_tightness']))
						->SetCellValue('BK'.$coo, checkemptydash($tkt_segchk_row['heating_melting_marks']))
						->SetCellValue('BL'.$coo, checkemptydash($tkt_segchk_row['terminal_tightness']))
						->SetCellValue('BM'.$coo, checkemptydash($tkt_segchk_row['alt_no_belt_avl']))
						->SetCellValue('BN'.$coo, checkemptydash($tkt_segchk_row['physical_damage']))
						->SetCellValue('BO'.$coo, checkemptydash($tkt_segchk_row['vent_plug_tightness']))
						->SetCellValue('BP'.$coo, checkemptydash($tkt_segchk_row['belt']))
						->SetCellValue('BQ'.$coo, checkemptydash($tkt_segchk_row['log_book']))
						->SetCellValue('BR'.$coo, checkemptydash($tkt_segchk_row['coach_status']))
						->SetCellValue('BS'.$coo, checkemptydash($tkt_segchk_row['cell_buldge']))
				// 6) Charger Details
						->SetCellValue('BT'.$coo, checkemptydash($tkt_segchg_row['charger_band']))
						->SetCellValue('BU'.$coo, php_excel_date($tkt_segchg_row['mfd_date']))
						->SetCellValue('BV'.$coo, checkemptydash($tkt_segchg_row['serial_no']))
						->SetCellValue('BW'.$coo, checkemptydash($tkt_segchg_row['charger_type']))
						->SetCellValue('BX'.$coo, checkemptydash($tkt_segchg_row['voltage']))
						->SetCellValue('BY'.$coo, checkemptydash($tkt_segchg_row['charging_current']))
						->SetCellValue('BZ'.$coo, checkemptydash($tkt_segchg_row['high_voltage_cutoff']))
						->SetCellValue('CA'.$coo, checkemptydash($tkt_segchg_row['voltage_ripple']))
						->SetCellValue('CB'.$coo, checkemptydash($tkt_segchg_row['voltage_regulation']))
				// 7) Fork Lift
						->SetCellValue('CC'.$coo, checkemptydash($tkt_segfrk_row['fork_lift_brand']))
						->SetCellValue('CD'.$coo, checkemptydash($tkt_segfrk_row['fork_lift_model']))
						->SetCellValue('CE'.$coo, php_excel_date($tkt_segfrk_row['fork_lift_manf_date']))
				// 8) Battery Details
						->SetCellValue('CF'.$coo, checkemptydash($tkt_segbat_row['battey_type']))
						->SetCellValue('CG'.$coo, checkemptydash($tkt_segbat_row['bank_serial_no']))
						->SetCellValue('CH'.$coo, php_excel_date($tkt_segbat_row['manf_date']))
						->SetCellValue('CI'.$coo, php_excel_date($tkt_segbat_row['ins_date']))
						->SetCellValue('CJ'.$coo, checkemptydash($tkt_segbat_row['plug_type']))
						->SetCellValue('CK'.$coo, checkemptydash($tkt_segbat_row['acid_level']))
				// 9) Technical observations
						->SetCellValue('CL'.$coo, checkemptydash($tkt_segtch_row['float_voltage']))
						->SetCellValue('CM'.$coo, checkemptydash($tkt_segtch_row['boast_voltage']))
						->SetCellValue('CN'.$coo, checkemptydash($tkt_segtch_row['current_limit']))
						->SetCellValue('CO'.$coo, checkemptydash($tkt_segtch_row['voltage_ripple']))
						->SetCellValue('CP'.$coo, checkemptydash($tkt_segtch_row['voltage_regulation']))
						->SetCellValue('CQ'.$coo, checkemptydash($tkt_segtch_row['high_voltage_cutoff']))
						->SetCellValue('CR'.$coo, checkemptydash($tkt_segtch_row['low_voltage_cutoff']))
						->SetCellValue('CS'.$coo, checkemptydash($tkt_segtch_row['panel_make']))
						->SetCellValue('CT'.$coo, checkemptydash($tkt_segtch_row['panel_rating']))
						->SetCellValue('CU'.$coo, checkemptydash($tkt_segtch_row['charge_controller_rate']))
						->SetCellValue('CV'.$coo, checkemptydash($tkt_segtch_row['charge_controller_make']))
						->SetCellValue('CW'.$coo, checkemptydash($tkt_segtch_row['no_solar_panels']))
						->SetCellValue('CX'.$coo, checkemptydash($tkt_segtch_row['single_panel_rating']))
						->SetCellValue('CY'.$coo, php_excel_date($tkt_segtch_row['panel_manufacturing_date']))
						->SetCellValue('CZ'.$coo, php_excel_date($tkt_segtch_row['charge_control_manufacturing_date']))
						->SetCellValue('DA'.$coo, php_excel_date($tkt_segtch_row['panel_installation_date']))
				// 10) physical Observations
						->SetCellValue('DB'.$coo, checkemptydash($tkt_segphy_row['physical_damages']))
						->SetCellValue('DC'.$coo, checkemptydash($tkt_segphy_row['leakage']))
						->SetCellValue('DD'.$coo, checkemptydash($tkt_segphy_row['temperature']))
						->SetCellValue('DE'.$coo, checkemptydash($tkt_segphy_row['acid_temp_discharge']))
						->SetCellValue('DF'.$coo, checkemptydash($tkt_segphy_row['acid_temp_charge']))
						->SetCellValue('DG'.$coo, checkemptydash($tkt_segphy_row['cells_temp_after_use']))
						->SetCellValue('DH'.$coo, checkemptydash($tkt_segphy_row['cells_temp_at_charge']))
						->SetCellValue('DI'.$coo, checkemptydash($tkt_segphy_row['general_observation']))
						->SetCellValue('DJ'.$coo, checkemptydash($tkt_segphy_row['terminal_torque']))
						->SetCellValue('DK'.$coo, checkemptydash($tkt_segphy_row['vent_plug_thickness']))
				// 11) General Observations
						->SetCellValue('DL'.$coo, checkemptydash($tkt_seggnr_row['site_load']))
						->SetCellValue('DM'.$coo, checkemptydash($tkt_seggnr_row['dg_status']))
						->SetCellValue('DN'.$coo, checkemptydash($tkt_seggnr_row['dg_make']))
						->SetCellValue('DO'.$coo, checkemptydash($tkt_seggnr_row['dg_capacity']))
						->SetCellValue('DP'.$coo, checkemptydash($tkt_seggnr_row['dg_working_condition']))
						->SetCellValue('DQ'.$coo, checkemptydash($tkt_seggnr_row['avg_dg_run']))
				// 12)Power Observations
						->SetCellValue('DR'.$coo, checkemptydash($tkt_segpwr_row['eb_supply']))
						->SetCellValue('DS'.$coo, checkemptydash($tkt_segpwr_row['failures_per_day']))
						->SetCellValue('DT'.$coo, checkemptydash($tkt_segpwr_row['avg_power_cut']))
				// 2) Engineer Observation
						->SetCellValue('DU'.$coo, checkemptydash($tkt_segeng_row['req_acc']))
						->SetCellValue('DV'.$coo, checkemptydash($tkt_segeng_row['req_cells']))
						->SetCellValue('DW'.$coo, checkemptydash($tkt_segeng_row['faulty_cell_sr_no']))
						->SetCellValue('DX'.$coo, checkemptydash($rep_count))
				//Customer Comment
						->SetCellValue('DY'.$coo, checkemptydash(alias($ticket_alias,'ec_customer_comments','ticket_alias','customer_comments')))
				// 13) E-signature
						->SetCellValue('DZ'.$coo, checkemptydash($tkt_segesig_row['name']))
						->SetCellValue('EA'.$coo, checkemptydash($tkt_segesig_row['designation']))
						->SetCellValue('EB'.$coo, checkemptydash($tkt_segesig_row['contact_number']))
						->SetCellValue('EC'.$coo, checkemptydash($tkt_segesig_row['email']))
				// 14) Customer Satisfaction
						->SetCellValue('ED'.$coo, checkemptydash($tkt_segsatis_row['q1']))
						->SetCellValue('EE'.$coo, checkemptydash($tkt_segsatis_row['q2']))
						->SetCellValue('EF'.$coo, checkemptydash($tkt_segsatis_row['q3']))
						->SetCellValue('EG'.$coo, checkemptydash($tkt_segsatis_row['q4']))
						->SetCellValue('EH'.$coo, checkemptydash($tkt_segsatis_row['q5']))
				// 15) Remarks
						->SetCellValue('EI'.$coo,checkemptydash($seBy))
						->SetCellValue('EJ'.$coo,checkemptydash($seRem))
						->SetCellValue('EK'.$coo,$seOn)
						->SetCellValue('EL'.$coo,checkemptydash($seAction))
		
						->SetCellValue('EM'.$coo,checkemptydash($zhsBy))
						->SetCellValue('EN'.$coo,checkemptydash($zhsRem))
						->SetCellValue('EO'.$coo,$zhsOn)
						->SetCellValue('EP'.$coo,checkemptydash($zhsAge))
		
						->SetCellValue('EQ'.$coo,checkemptydash($nhsBy))
						->SetCellValue('ER'.$coo,checkemptydash($nhsRem))
						->SetCellValue('ES'.$coo,$nhsOn)
						->SetCellValue('ET'.$coo,checkemptydash($nhsAge));
				
				$cd = $c = 'EU';
				if(count($othBy)){
					for($i=0;$i<count($othBy);$i++){
						$sheet->SetCellValue($c.$coo, checkemptydash($othBy[$i])); $c++;
						$sheet->SetCellValue($c.$coo, checkemptydash($othRem[$i])); $c++;
						$sheet->SetCellValue($c.$coo, $othOn[$i]); $c++;
					}
				}
				$cd = $c = $xx;
				$planned_remarks = alias($ticket_alias,'ec_tickets','ticket_alias','planned_remarks');
				if(!empty($planned_remarks)){
					$planned_arr = explode(", ",$planned_remarks);
					$sheet->SetCellValue($c.'1', "Re Plan Count");
					$sheet->SetCellValue($c.$coo, count($planned_arr));$c++;
					foreach($planned_arr as $k=>$plann){
						list($date,$service_ali,$rem_ali) = explode("|",$plann);
						$sheet->getStyle($c)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension($c)->setAutoSize(true);
						$sheet->SetCellValue($c.'1','Planned Date ('.($k+1).')')
							->SetCellValue($c.$coo, ($date=="" || $date=="0000-00-00 00:00:00" ? "-" : php_excel_date($date)));
						$c++;
						$sheet->SetCellValue($c.'1','Service Engineer ('.($k+1).')')
							->SetCellValue($c.$coo, checkemptydash(alias_flag_none($service_ali,'ec_employee_master','employee_alias','name')));
						$c++;
						$sheet->SetCellValue($c.'1','Remarks ('.($k+1).')')
							->SetCellValue($c.$coo, checkemptydash(alias($rem_ali,'ec_remarks','remark_alias','remarks')));
						$c++;
					}$c--;
						$sheet->getStyle($cd.'1:'.$c.'1')->applyFromArray($styleArray);
						$sheet->getStyle($cd.'1:'.$c.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
				}
			}$no_rec++;
		}$sh_index++;
	}
	if($no_rec>0){
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save("../../exports/$filename.xlsx");
		$result['file_name']=$filename;
		$resCode='0'; $resMsg='export';
	}else{$resCode='4';$resMsg='No Records found to Run Report!';}
	}else{$resCode='4';$resMsg='Please Select the Datatype';}
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function sub_tickets_close_decline($ticket_alias,$sub_con){ global $mr_con;
	$ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
	if (strpos($ticket_id,"|")!== false){
		$tt = explode("|",$ticket_id);
		$ticket = $tt[0];
		$ret = $ticket."|".end($tt);
		$sqlTT = mysqli_query($mr_con,"UPDATE ec_tickets SET $sub_con WHERE ticket_id='$ticket' AND flag=0");
		for($i=2;$i<end($tt);$i++){
			$ticket1 = $ticket."|".$i;
			$sqlTT = mysqli_query($mr_con,"UPDATE ec_tickets SET $sub_con WHERE ticket_id='$ticket1' AND flag=0");
		}
	}
}
function subticket($ticket_alias){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT ticket_id,activity_alias,site_alias,complaint_alias,mode_of_contact,contact_link,description FROM ec_tickets WHERE ticket_alias='$ticket_alias' AND flag=0");
	$row=mysqli_fetch_array($sql);
	$ticket_id=subTTCheck($row['ticket_id']);
	$activity_alias=$row['activity_alias'];
	$site_alias=$row['site_alias'];
	$complaint_alias=$row['complaint_alias'];
	$mode_of_contact=$row['mode_of_contact'];
	$contact_link=$row['contact_link'];
	$description=$row['description'];
	$alias = aliasCheck(generateRandomString(),'ec_tickets','ticket_alias');
	$sql1 = mysqli_query($mr_con,"INSERT INTO ec_tickets(ticket_id,activity_alias,site_alias,complaint_alias,mode_of_contact,contact_link,description,login_date,level,old_level,status,ticket_alias)VALUES('$ticket_id','$activity_alias','$site_alias','$complaint_alias','$mode_of_contact','$contact_link','$description','".date('Y-m-d h:i:s A')."','1','1','Open','$alias')");
}
function subTTCheck($ticket_id){
	if (strpos($ticket_id,"|")!== false){
		$tt = explode("|",$ticket_id);
		$ret = $tt[0]."|".(end($tt)+1);
	}else{$ret = $ticket_id."|2";}
	return $ret;
}
//function ticket_5to6_update($ticket_alias,$reject){ global $mr_con;}
//function ticket_6to7_update($ticket_alias,$reject){ global $mr_con;}
function ticket_autocomplete(){ global $mr_con;
	if(isset($_REQUEST['emp_alias'])){$emp_alias = $_REQUEST['emp_alias'];}
	if(strtoupper($emp_alias)=='ADMIN'){$emp = "";}
	else{
		$state_alias  = alias($emp_alias,'ec_employee_master','employee_alias','state_alias');
		$states = "'".implode("','",explode(", ",$state_alias))."'";
		$emp = "state_alias IN ($states) AND";
	}
	if(isset($_REQUEST['alias']))$alias="site_id LIKE '%".mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']))."%' AND";else $alias="";
	$request = \Slim\Slim::getInstance()->request();
		$sql = mysqli_query($mr_con,"SELECT site_id,site_alias FROM ec_sitemaster WHERE $alias $emp flag=0");
		if(mysqli_num_rows($sql)>0){$i=0;
			while($row=mysqli_fetch_array($sql)){$result[$i]['site_id']=$row['site_id'];$result[$i]['site_status'] = sitemanfdate_check($row['site_alias']);$i++;}
		}else{$result[0]['site_id']="Add to Site Master";}
	echo json_encode($result);
}
function onlineTickets(){ global $mr_con;
	if(isset($_REQUEST['emp_alias'])){$emp_alias = $_REQUEST['emp_alias'];}
	if(strtoupper($emp_alias)=='ADMIN'){$emp = "";}
	else{
		$state_alias  = alias($emp_alias,'ec_employee_master','employee_alias','state_alias');
		$states = "'".implode("','",explode(", ",$state_alias))."'";
		$emp = "state_alias IN ($states) AND";
	}
	if(isset($_REQUEST['alias']))$alias="site_id LIKE '%".mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']))."%' AND";else $alias="";
	$request = \Slim\Slim::getInstance()->request();
		$sql = mysqli_query($mr_con,"SELECT site_id,site_alias FROM ec_sitemaster WHERE $alias $emp flag=0");
		if(mysqli_num_rows($sql)>0){$i=0;
			while($row=mysqli_fetch_array($sql)){$result[$i]['site_id']=$row['site_id'];$result[$i]['site_status'] = sitemanfdate_check($row['site_alias']);$i++;}
		}else{$result[0]['site_id']="Add Manually";}
	echo json_encode($result);
}
//function ticket_5to6_update($ticket_alias,$reject){ global $mr_con;}
//function ticket_6to7_update($ticket_alias,$reject){ global $mr_con;}
function zoneMsg($activity_alias,$site_alias,$ticket_id){ global $mr_con;
	$zone_alias=alias($site_alias,'ec_sitemaster','site_alias','zone_alias');
	$activity_name = alias($activity_alias,'ec_activity','activity_alias','activity_name');
	$site_name = alias($site_alias,'ec_sitemaster','site_alias','site_name');
	$sql=mysqli_query($mr_con,"SELECT mobile_number FROM ec_employee_master WHERE zone_alias RLIKE '%$zone_alias%' AND role_alias<>'01ZMYJ4OLG' AND privilege_alias='OX5E3EMI0U' AND flag=0"); // Not ESCA role and ZHS privilage
	if(mysqli_num_rows($sql)>0){
		while($row = mysqli_fetch_array($sql)){
			$num=mysqli_real_escape_string($mr_con,$row['mobile_number']);
			$msg=urlencode( "Greetings from Enersys, your complaint has been registered against the ".$activity_name." of Site name- ".$site_name." Ticket No- ".$ticket_id.".");
			if(!empty($num)){messageSent($num,$msg);}
		}
	}
}
//Dashboard
function ticket_status(){ global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){
		$result['tktstatusDetails']=array();
		if(isset($_REQUEST['state_alias'])){$state_alias=$_REQUEST['state_alias'];}else{$state_alias="";}
		if(isset($_REQUEST['segment_alias'])){$seg=$_REQUEST['segment_alias'];}else{$seg="";}
		if(isset($_REQUEST['faulty_alias'])){$fal=$_REQUEST['faulty_alias'];}else{$fal="";}
		if(isset($_REQUEST['customer_alias'])){$cust=$_REQUEST['customer_alias'];}else{$cust="";}
		if(isset($_REQUEST['activity_alias'])){$activity_alias=$_REQUEST['activity_alias'];}else{$activity_alias="";}
		if(isset($_REQUEST['tat'])){$tat=$_REQUEST['tat'];}else{$tat="";}
		if(isset($_REQUEST['year'])&&!empty($_REQUEST['year'])){
			$year=$_REQUEST['year'];
			$from_date="20".$year."-04-01";
			$to_date="20".($year+1)."-03-31";
		}else{$from_date=0;$to_date=0;}
		$level_query=mysqli_query($mr_con,"SELECT level_name,level_alias FROM ec_levels WHERE level_alias<>'5' AND flag=0");
		while($level_row=mysqli_fetch_array($level_query)){
			$level_name[] = $level_row['level_name'];
			$level_alias[] = $level_row['level_alias'];
		}
		array_push($level_alias,"8");
		array_push($level_name,"PLAN FAIL");
		
		$s=mysqli_query($mr_con,"SELECT zone_alias,employee_alias FROM ec_employee_master WHERE esca_alias='$emp_alias' AND flag=0");
		$employee_alias = array();//$empzone=array();
		while($s_row=mysqli_fetch_array($s)){ $employee_alias[]=$s_row['employee_alias'];$empzn.=$s_row['zone_alias'].", "; }
		$l=implode("','",$employee_alias);
		$con = " t1.service_engineer_alias IN ('$l') AND";
		$empzone=array_unique(explode(", ",rtrim($empzn,", ")));
		
		$zone_query=mysqli_query($mr_con,"SELECT zone_name,zone_alias FROM ec_zone WHERE flag=0 LIMIT 0,4");
		while($zone_row=mysqli_fetch_array($zone_query)){
			$zone_name[] = $zone_row['zone_name'];
			$zone_alias[] = $zone_row['zone_alias'];
		}
		$level_count = count($level_alias);
		$zone_count = count($zone_alias);
		for($i=0;$i<$level_count;$i++){
			$result['tktstatusDetails'][$i]['level_name']=$level_name[$i];
			$tot=0;
			for($j=0;$j<$zone_count;$j++){
				$zx = $zone_alias[$j];
				$zone_alias1 = (in_array($zx,$empzone) ? $zx : "");
				$fun = zone_count($level_alias[$i],$state_alias,$zone_alias1,$seg,$fal,$cust,$activity_alias,$tat,$from_date,$to_date,$con);
				if($i==0){$result['tktzone_name'][$j]['zone_name']=$zone_name[$j];}
				$result['tktstatusDetails'][$i]['zone_count'][$j]['count']=$fun;
				if($i<5){$pot+=$fun;}
				if($i==5 || $i==6){$ss+=$fun;}
				if($i==7 || $i==8){$tt+=$fun;}
				$tot+=$fun;
				if($j==0){$a+=$fun;}
				if($j==1){$b+=$fun;}
				if($j==2){$c+=$fun;}
				if($j==3){$d+=$fun;}
				$e+=$fun;		
			}
			$result['tktstatusDetails'][$i]['value']=$tot;
		}
		$sm=$pot+$tt;
		$result['details'][0]['cnt_value']=$a;
		$result['details'][1]['cnt_value']=$b;
		$result['details'][2]['cnt_value']=$c;
		$result['details'][3]['cnt_value']=$d;
		$result['details'][4]['cnt_value']=$e;
		$result['status']='STATUS';
		$result['total']='TOTAL';
		$result['grandtotal']='Grand Total';
		$result['opened']=$sm;
		$result['closed']=$ss;
		$result['txtopened']='OPEN';
		$result['txtclosed']='CLOSED';
		if($sql){$resCode='0'; $resMsg='Successfull!';
		}else{$resCode='4'; $resMsg='No Records Found';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function zone_count($level,$state_alias,$zone_alias,$segment,$faulty_code,$customer,$activity_alias,$tat,$from_date,$to_date,$con){ global $mr_con;
	if($from_date!='0' && $to_date!='0')$con .= " t1.login_date >= '".$from_date."' AND t1.login_date <= '".$to_date."' AND";
	if($level=='2'){
		$con .= " t1.level='$level' AND t1.planned_date >= '".date('Y-m-d')."' AND";
	}elseif($level=='8'){
		$con .= " t1.level='2' AND t1.planned_date < '".date('Y-m-d')."' AND";
	}elseif($level=='6' || $level=='7'){
		$con .= " t1.level='$level' AND t1.ticket_id NOT LIKE '%|%' AND";
	}else{
		$con .= " t1.level='$level' AND";
	}
	if(isset($state_alias) && ($state_alias>0)){
		$state=implode("|",$state_alias);
		$con .= " t2.state_alias RLIKE '$state' AND";
	}
	if(isset($segment) && count($segment)>0 && !empty($segment)){
		$seg = implode("|",$segment);
		$con .= " t2.segment_alias RLIKE '$seg' AND";
	}
	if(isset($faulty_code) && count($faulty_code)>0 && !empty($faulty_code)){
		$gh=array();
		$faulty = implode("|",$faulty_code);
		$gh=mul_alias($faulty ,'ec_engineer_observation','faulty_code_alias','ticket_alias');
		$g=implode("|",$gh);
		if(!empty($g)){
			$con .= " t1.ticket_alias RLIKE '$g' AND";
		}
	}
	if(isset($customer) && count($customer)>0 && !empty($customer)){
		$cu=implode("|",$customer);
		$con .= " t2.customer_alias RLIKE '$cu' AND";
	}
	if(isset($activity_alias) && count($activity_alias)>0 && !empty($activity_alias)){
		$activity=implode("|",$activity_alias);
		$con .=" t1.activity_alias RLIKE '$activity' AND";
	}
	if(isset($tat) && count($tat)>0 && !empty($tat)){
		$ta=implode("|",$tat);
		$con .=" t1.tat RLIKE '$ta' AND";
	}
	$tt_sql=mysqli_query($mr_con,"SELECT t1.id FROM ec_tickets t1 JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias WHERE $con t2.zone_alias='$zone_alias' AND t1.flag=0");
	//echo "SELECT t1.id FROM ec_tickets t1 JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias WHERE $con t2.zone_alias='$zone_alias' AND t1.flag=0<br>";
	$total_count=mysqli_num_rows($tt_sql);
	return $total_count;
}
function customer_pulse(){ global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){ $a1=array();
		if(isset($_REQUEST['state_alias'])&&!empty($_REQUEST['state_alias']))$sa="t5.state_alias IN ('".implode("','",$_REQUEST['state_alias'])."') AND ";else $sa="";
		if(isset($_REQUEST['customer_alias'])&&!empty($_REQUEST['customer_alias']))$ca="t5.customer_alias IN ('".implode("','",$_REQUEST['customer_alias'])."') AND ";else $ca="";
		if(isset($_REQUEST['segment_alias'])&&!empty($_REQUEST['segment_alias']))$sga="t5.segment_alias IN ('".implode("','",$_REQUEST['segment_alias'])."') AND ";else $sga="";
		if(isset($_REQUEST['activity_alias'])&&!empty($_REQUEST['activity_alias']))$act="t3.activity_alias IN ('".implode("','",$_REQUEST['activity_alias'])."') AND ";else $act="";
		if(isset($_REQUEST['year'])&&!empty($_REQUEST['year'])){
			$year=$_REQUEST['year'];
			$from_date="20".$year."-04-01";
			$to_date="20".($year+1)."-03-31";
		}else{$from_date=$to_date=0;}
		if($from_date!='0' && $to_date!='0'){
			$cd= " t3.login_date >= '".$from_date."' AND t3.login_date <= '".$to_date."' AND";
		}else $cd="";
		$cobb=$sa.$ca.$sga.$cd.$act;
		//if($cobb!="")
			$wer=' INNER JOIN ec_tickets t3 ON t1.ticket_alias=t3.ticket_alias INNER JOIN ec_sitemaster t5 ON t3.site_alias=t5.site_alias ';
		//else $wer="";
		$sql1=mysqli_query($mr_con,"SELECT t2.q1,t2.q2, t2.q3, t2.q4, t2.q5 FROM 
			ec_customer_comments t1 
			INNER JOIN ec_customer_satisfaction t2 ON t1.ticket_alias=t2.ticket_alias $wer
			INNER JOIN ec_employee_master t4 ON t3.service_engineer_alias=t4.employee_alias
			WHERE $sa $ca $sga $cd t4.esca_alias='$emp_alias' AND t1.flag=0 AND t2.flag=0");
			if(mysqli_num_rows($sql1)>'0'){
				while($row1=mysqli_fetch_array($sql1)){
					$a1[]=$row1['q1'];
					$a1[]=$row1['q2'];
					$a1[]=$row1['q3'];
					$a1[]=$row1['q4'];
					$a1[]=$row1['q5'];
				}
			}else{
				$result['data']['columns'][0][0]='NO Pulse';
				$result['data']['columns'][0][1]='0';
				$result['color']['pattern'][0]='#e0e0e0';
			}
		$result['bindto']='#esca_c_pulse';
		if(array_sum($a1)>'0'){
			$count = count($a1)/5;
			$result['data']['columns'][0][]="Pulse";
			$result['data']['columns'][0][]=array_sum($a1)*100 /($count * 25 );
			$result['color']['pattern'][0]='#FF0000';
			$result['color']['pattern'][1]='#F97600';
			$result['color']['pattern'][2]='#F6C600';
			$result['color']['pattern'][3]='#60B044';
			$result['color']['threshold']['values'][0]=25;
			$result['color']['threshold']['values'][1]=50;
			$result['color']['threshold']['values'][2]=75;
			$result['color']['threshold']['values'][3]=100;
		}
		$result['data']['type']='gauge';
		$result['size']['height']='343';
		$result['gauge']['width']='70';
		$result['admin'] = $emp_alias;
		if($sql && $sql1){$resCode='0'; $resMsg='Successfull!';
		}else{$resCode='4'; $resMsg='No Records Found';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function today_info_report_block(){global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){
		if(isset($_REQUEST['state_alias'])&&!empty($_REQUEST['state_alias']))$sa="t2.state_alias IN ('".implode("','",$_REQUEST['state_alias'])."') AND ";else $sa="";
		if(isset($_REQUEST['customer_alias'])&&!empty($_REQUEST['customer_alias']))$ca="t2.customer_alias IN ('".implode("','",$_REQUEST['customer_alias'])."') AND ";else $ca="";
		if(isset($_REQUEST['segment_alias'])&&!empty($_REQUEST['segment_alias']))$sga="t2.segment_alias IN ('".implode("','",$_REQUEST['segment_alias'])."') AND ";else $sga="";
		if(isset($_REQUEST['activity_alias'])&&!empty($_REQUEST['activity_alias']))$act="t1.activity_alias IN ('".implode("','",$_REQUEST['activity_alias'])."') AND ";else $act="";
		if(isset($_REQUEST['faulty_alias'])&&!empty($_REQUEST['faulty_alias'])){
			$fa_a=' INNER JOIN ec_engineer_observation t3 ON t1.ticket_alias=t3.ticket_alias ';
			$fa="t3.faulty_code_alias IN ('".implode("','",$_REQUEST['faulty_alias'])."') AND ";
		}else{$fa="";$fa_a="";}
		if(isset($_REQUEST['tat'])&&!empty($_REQUEST['tat'])){$tatt= "t1.tat IN ('".implode("','",$_REQUEST['tat'])."') AND ";}else $tatt="";
		$con=$sa.$ca.$sga.$fa.$tatt.$act;
		$sql=mysqli_query($mr_con,"SELECT level_alias,level_name FROM ec_levels WHERE level_alias<>'0' AND flag=0");
		$i=0;while($l_row=mysqli_fetch_array($sql)){
			$cc['level'][$i]=$l_row['level_name'];
			$query=mysqli_query($mr_con,"SELECT COUNT(t1.id) AS coun FROM ec_tickets t1 
				INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias
				INNER JOIN ec_employee_master t4 ON t1.service_engineer_alias=t4.employee_alias
				$fa_a WHERE $con t4.esca_alias='$emp_alias' AND t1.level='".$l_row['level_alias']."' AND transaction_date ='".date('Y-m-d')."' AND t1.flag=0 AND t2.flag=0");
			if(mysqli_num_rows($query)>'0'){$ro = mysqli_fetch_array($query);$co = $ro['coun'];}else{$co = 0;}
			$mm['tktcount'][0]="Tickets";
			$mm['tktcount'][$i+1]=$co;
			$kk+=$co;
		$i++;}
		$result['totalcount']=$kk;
		$result['bindto']='#esca_td_info';
		$result['data']['columns'][0]=$mm['tktcount'];
		$result['data']['type']="bar";
		$result['color']['pattern'][0]="#3F51B5";
		$result['color']['pattern'][1]="#38B4EE";
		$result['color']['pattern'][2]="#4CAF50";
		$result['color']['pattern'][3]="#E91E63";
		$result['axis']['x']['type']='category';
		$result['axis']['x']['categories']=$cc['level'];
		$result['legend']['position']='inset';
		$result['bar']['width']['ratio']='0.4';
		$result['size']['height']='350';
		$result['admin'] = $emp_alias;
		if($sql){$resCode='0'; $resMsg='Successfull!';
		}else{$resCode='4'; $resMsg='No Records Found';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
 
}
function tat_status(){ global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){$con = ""; $emp = ""; $yr = "";
		if(isset($_REQUEST['state_alias'])&&!empty($_REQUEST['state_alias']))$sa="t2.state_alias IN ('".implode("','",$_REQUEST['state_alias'])."') AND ";else $sa="";
		if(isset($_REQUEST['customer_alias'])&&!empty($_REQUEST['customer_alias']))$ca="t2.customer_alias IN ('".implode("','",$_REQUEST['customer_alias'])."') AND ";else $ca="";
		if(isset($_REQUEST['segment_alias'])&&!empty($_REQUEST['segment_alias']))$sga="t2.segment_alias IN ('".implode("','",$_REQUEST['segment_alias'])."') AND ";else $sga="";
		if(isset($_REQUEST['activity_alias'])&&!empty($_REQUEST['activity_alias']))$act="t1.activity_alias IN ('".implode("','",$_REQUEST['activity_alias'])."') AND ";else $act="";
		if(isset($_REQUEST['faulty_alias'])&&!empty($_REQUEST['faulty_alias'])){
			$fa_a=' INNER JOIN ec_engineer_observation t3 ON t1.ticket_alias=t3.ticket_alias ';
			$fa="t3.faulty_code_alias IN ('".implode("','",$_REQUEST['faulty_alias'])."') AND ";
		}else{$fa="";$fa_a="";}
		if(isset($_REQUEST['year'])&&!empty($_REQUEST['year'])){
			$year=$_REQUEST['year'];
			$from_date="20".$year."-04-01";
			$to_date="20".($year+1)."-03-31";
		}else{
			$m=date('m');
			$year=(($m=='01' || $m=='02' || $m=='03') ? date('y', strtotime('-1 year')) : date('y'));
			$from_date="20".$year."-04-01";
			$to_date="20".($year+1)."-03-31";
		}
		if($from_date!='0' && $to_date!='0')$cd= " t1.login_date >= '".$from_date."' AND t1.login_date <= '".$to_date."' AND ";else $cd="";
		$con=$sa.$ca.$sga.$cd.$fa.$act;
		$query=mysqli_query($mr_con,"SELECT  count(t1.id) as der, t1.tat FROM ec_tickets t1
		INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias
		INNER JOIN ec_employee_master t4 ON t1.service_engineer_alias=t4.employee_alias $fa_a
		WHERE $con t4.esca_alias='$emp_alias' AND t1.flag=0 GROUP BY t1.tat");
		if(mysqli_num_rows($query)>'0'){$de=0;
			while($row=mysqli_fetch_array($query)){
				$result['data']['columns'][$de][0]=$row['tat'];
				$result['data']['columns'][$de][1]=$row['der'];
				$de++;
			}
		}else{
			$result['data']['columns'][0][0]='NO TAT';
			$result['data']['columns'][0][1]='1';
			$result['color']['pattern'][0]='#e0e0e0';
		}
		$result['bindto']='#esca_tat_con';
		$result['data']['type']='pie';
		$result['size']['height']='350';
		$result['pie']['width']='70';
		if($query){$resCode='0'; $resMsg='Successfull!';
		}else{$resCode='4'; $resMsg='No Records Found';}
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']=$resCode;$result['ErrorDetails']=$resMsg;
	echo json_encode($result);
}
function nature_of_activity(){ global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){ $con = "";
		if(isset($_REQUEST['state_alias'])&&!empty($_REQUEST['state_alias']))$sa="t2.state_alias IN ('".implode("','",$_REQUEST['state_alias'])."') AND ";else $sa="";
		if(isset($_REQUEST['customer_alias'])&&!empty($_REQUEST['customer_alias']))$ca="t2.customer_alias IN ('".implode("','",$_REQUEST['customer_alias'])."') AND ";else $ca="";
		if(isset($_REQUEST['segment_alias'])&&!empty($_REQUEST['segment_alias']))$sga="t2.segment_alias IN ('".implode("','",$_REQUEST['segment_alias'])."') AND ";else $sga="";
		if(isset($_REQUEST['year'])&&!empty($_REQUEST['year'])){
			$year=$_REQUEST['year'];
			$from_date="20".$year."-04-01";
			$to_date="20".($year+1)."-03-31";
		}else{$from_date=0;$to_date=0;}
		if($from_date!='0' && $to_date!='0')$cd= " t1.login_date >= '".$from_date."' AND t1.login_date <= '".$to_date."' AND";else $cd="";
		$con=$sa.$ca.$sga.$cd;
		$aa['actname'] = array();$c=0;$i=0;
		$sql=mysqli_query($mr_con,"SELECT COUNT(t1.id) as gty,t3.activity_code FROM ec_tickets t1 INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias INNER JOIN ec_activity t3 ON t1.activity_alias=t3.activity_alias WHERE $con t1.service_engineer_alias IN(SELECT employee_alias FROM ec_employee_master WHERE esca_alias='$emp_alias') AND t1.service_engineer_alias<>'' AND t1.level<>'5' AND t1.flag='0' GROUP BY t1.activity_alias");
		while($sql_row=mysqli_fetch_array($sql)){
			$aa['actname'][$i][]=$sql_row['activity_code'];	
			$c+= $aa['actname'][$i][]=$sql_row['gty'];	
		$i++;}
		$result['bindto']='#esca_n_act';
		if($c){
			$result['color']['pattern'][0]='#3F51B5';
			$result['color']['pattern'][1]='#4CAF50';
			$result['color']['pattern'][2]='#f44336';
			$result['color']['pattern'][3]='#E91E63';
			$result['color']['pattern'][4]='#38B4EE';
		}else{
			unset($aa['actname']);
			$aa['actname'][0][0]='No Activity';	
			$aa['actname'][0][1]=1;
			$result['color']['pattern'][0]='#e0e0e0';
		}
		$result['data']['columns']=$aa['actname'];
		$result['data']['type']="donut";
		$result['size']['height']='350';
		$result['donut']['width']='70';
		if($query){$resCode='0'; $resMsg='Successfull!';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function num2alpha($n){
    for($r = ""; $n >= 0; $n = intval($n / 26) - 1) $r = chr($n%26 + 0x41) . $r;
    return $r;
}
function esca_tkt_alias($employee_alias){ global $mr_con;
	$ticket_id=array();
	$sql = mysqli_query($mr_con,"SELECT SUBSTRING_INDEX(ticket_id,'|',1) AS ticket_idx FROM ec_tickets WHERE service_engineer_alias IN('".implode("','",$employee_alias)."') AND flag='0' GROUP BY ticket_idx ORDER BY id");
	while($row=mysqli_fetch_array($sql)){
		$ticket_id[]=$row['ticket_idx'];
	}
	$sqlTT = mysqli_query($mr_con,"SELECT GROUP_CONCAT(ticket_alias SEPARATOR ''',''') AS ticket_alias FROM ec_tickets WHERE ticket_id RLIKE '".implode("|",$ticket_id)."' AND flag='0' AND level<>'5' ORDER BY id DESC");
	$rowtt=mysqli_fetch_array($sqlTT);
	return $rowtt['ticket_alias'];
	//return count(explode("','",$rowtt['ticket_alias']));
}
?>