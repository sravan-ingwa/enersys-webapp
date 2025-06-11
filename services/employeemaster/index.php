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
$app->post('/delete','employee_master_delete');
$app->post('/restore','employee_master_restore');
$app->run();
function employeemaster_add(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$alias=aliasMulCheck(generateRandomString());
		$emp_name=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['name'])));
		$emp_id=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_id'])));
		$email_id=strtolower(mysqli_real_escape_string($mr_con,trim($_REQUEST['email_id'])));
		$mobile_number=mysqli_real_escape_string($mr_con,trim($_REQUEST['mobile_number']));
		$password=password_hash_encript(mysqli_real_escape_string($mr_con,trim($_REQUEST['mobile_number'])));
		if(isset($_REQUEST['zone_alias']) && count($_REQUEST['zone_alias'])>0){$zone = implode(", ",$_REQUEST['zone_alias']);}else{$zone = '';}
		if(isset($_REQUEST['state_alias']) && count($_REQUEST['state_alias'])>0){$state = implode(", ",$_REQUEST['state_alias']);}else{$state = '';}
		if(isset($_REQUEST['segment_alias']) && count($_REQUEST['segment_alias'])>0){$segment = implode(", ",$_REQUEST['segment_alias']);}else{$segment = '';}
		if(isset($_REQUEST['customer_alias']) && count($_REQUEST['customer_alias'])>0){$customer = implode(", ",$_REQUEST['customer_alias']);}else{$customer = '';}
		$zone_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($zone)));
		$state_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($state)));
		$segment_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($segment)));
		$customer_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($customer)));
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
		$cash_card=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['cash_card']));	
		$obal=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['opening_balance']));
		$ths_notified=mysqli_real_escape_string($mr_con,$_REQUEST['ths_notified']);
		$ths_notified=($ths_notified ==1 ? '1' : '0');
		if(empty($emp_id)){$res="Please Enter Employee Id";}
		elseif(empty($emp_name)){$res="Please Enter Employee Name";}
		elseif(empty($designation_alias)){$res="Please Enter Designation";}
		elseif(empty($department_alias)){$res="Please Enter Department";}
		elseif($zone==''){$res="Please Enter Zone";}
		elseif($state==''){$res="Please Enter State";}
		elseif(empty($base_location)){$res="Please Enter Base Location";}
		elseif(empty($qualification)){$res="Please Enter Qualification";}
		elseif(empty($mobile_number) || !preg_match("/^[6-9]\d{9}$/",$mobile_number)){$res="Please Enter Valid Mobile Number";}
		elseif(empty($email_id)){$res="Please Enter Email Id";}
		elseif(empty($specialization)){$res="Please Enter Specialization";}
		elseif($totalexp==''){$res="Please Enter Total Experience";}
		elseif(empty($role_alias)){$res="Please Enter Employee Role";}
		elseif(empty($privilege_alias)){$res="Please Enter Privilege Name";}
		elseif(empty($joining_date)){$res="Please Enter Joining Date";}
		//elseif(empty($cash_card)){$res="Please Enter Cash Card";}
		//elseif($obal==""){$res="Please Enter Opening Balance";}
		//elseif($asset==''){$res="Please Select Asset Name";}
		//elseif($wh==''){$res="Please Select Warehouse Code";}
		else{
			$date=date('Y-m-d');
			$sql=mysqli_query($mr_con,"SELECT id FROM  ec_employee_master WHERE employee_id='$emp_id' AND flag=0");
			if(mysqli_num_rows($sql)==0){
				$q=mysqli_query($mr_con,"INSERT INTO ec_employee_master(name,employee_id,employee_alias,email_id,mobile_number,password,zone_alias,state_alias,segment_alias,customer_alias,base_location,designation_alias,department_alias,role_alias,esca_alias,privilege_alias,qualification,specialization,total_experience,joining_date,created_date,asset_alias,wh_alias,cash_card,ths_notified) VALUES('$emp_name','$emp_id','$alias','$email_id','$mobile_number','$password','$zone_alias','$state_alias','$segment_alias','$customer_alias','$base_location','$designation_alias','$department_alias','$role_alias','$esca_alias','$privilege_alias','$qualification','$specialization','$totalexp','$joining_date','".date('Y-m-d')."','$asset_alias','$wh_alias','$cash_card','$ths_notified')");
				if($q){
					if(!empty($obal)){
						//Cash card and Opening Balance start
						$rquestid="#".checkint(mt_rand(1000,999999999),'ec_advances','request_id');
						$alias_ad=aliasCheck(generateRandomString(),"ec_advances","advance_alias");
						$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
						$mr_con->query("INSERT INTO ec_advances(employee_alias,request_amount,total_amount,request_id,requested_date,advance_alias,approval_level) VALUES ('$alias','$obal','$obal','$rquestid','$date','$alias_ad','6')");
						$mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('Opening Balance','BA','$alias_ad','admin','$alias_remark')");
						//Cash card and Opening Balance end
					}
					$q1=mysqli_query($mr_con,"INSERT INTO ec_app_update_status(employee_alias)VALUES('$alias')");
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
		if(isset($_REQUEST['segment_alias']) && count($_REQUEST['segment_alias'])>0){$segment = implode(", ",$_REQUEST['segment_alias']);}else{$segment = '';}
		if(isset($_REQUEST['customer_alias']) && count($_REQUEST['customer_alias'])>0){$customer = implode(", ",$_REQUEST['customer_alias']);}else{$customer = '';}
		$zone_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($zone)));
		$state_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($state)));
		$segment_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($segment)));
		$customer_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($customer)));
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
		$cash_card=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['cash_card']));	
		$obal=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['opening_balance']));		
		if(isset($_REQUEST['asset_alias']) && count($_REQUEST['asset_alias'])>0){$asset = implode(", ",$_REQUEST['asset_alias']);}else{$asset = '';}
		$asset_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($asset)));
		if(isset($_REQUEST['wh_alias']) && count($_REQUEST['wh_alias'])>0){$wh = implode(", ",$_REQUEST['wh_alias']);}else{$wh = '';}
		$wh_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($wh)));
		$ths_notified=mysqli_real_escape_string($mr_con,$_REQUEST['ths_notified']);
		$ths_notified=($ths_notified ==1 ? '1' : '0');
		
		if(empty($emp_id)){$res="Please Enter Employee Id";}
		elseif(empty($emp_name)){$res="Please Enter Employee Name";}
		elseif(empty($designation_alias)){$res="Please Enter Designation";}
		elseif(empty($department_alias)){$res="Please Enter Department";}
		elseif($zone==''){$res="Please Enter Zone";}
		elseif($state==''){$res="Please Enter State";}
		elseif(empty($base_location)){$res="Please Enter Base Location";}
		elseif(empty($qualification)){$res="Please Enter Qualification";}
		elseif(empty($mobile_number) || !preg_match("/^[6-9]\d{9}$/",$mobile_number)){$res="Please Enter Valid Mobile Number";}
		elseif(empty($email_id)){$res="Please Enter Email Id";}
		elseif(empty($specialization)){$res="Please Enter Specialization";}
		elseif($totalexp==''){$res="Please Enter Total Experience";}
		elseif(empty($role_alias)){$res="Please Enter Employee Role";}
		elseif(empty($privilege_alias)){$res="Please Enter Privilege Name";}
		elseif(empty($joining_date)){$res="Please Enter Joining Date";}
		//elseif($asset==''){$res="Please Select Asset Name";}
		//elseif($wh==''){$res="Please Select Warehouse Code";}
		else{
			$sql=mysqli_query($mr_con,"SELECT status FROM ec_employee_master WHERE employee_id='$emp_id' AND employee_alias<>'$alias' AND flag=0");
			if(mysqli_num_rows($sql)==0){ $con="";
				if($status=="WORKING" && $relieving_date!='NA'){
					$con = "relieving_date='$relieving_date',";
					if(isset($_FILES["noc"]) && !empty($_FILES["noc"]['name'])){
						$link = upload_file($_FILES["noc"],"noc","pdf"); //if(isset($_REQUEST['oldimg']) && $link){@unlink($_REQUEST['oldimg']);}
						list($code,$msg) = explode(",",$link);
						if($code==0)$con .= "noc='$msg',status='RELIEVED',flag='1'";else $res=$msg;
					}else $con .= "status='RESIGNED'";
				}elseif($status=="RESIGNED"){
					$rol_alias=alias($alias,'ec_employee_master','employee_alias','role_alias');
					if($rol_alias=="01ZMYJ4OLG"){
						if($relieving_date!='NA')$con = "relieving_date='$relieving_date',status='RELIEVED',flag='1'";else $res="Please Choose Relieving Date.";
					}else{
						if(isset($_FILES["noc"]) && !empty($_FILES["noc"]['name'])){
							$link = upload_file($_FILES["noc"],"noc","pdf"); //if(isset($_REQUEST['oldimg']) && $link){@unlink($_REQUEST['oldimg']);}
							list($code,$msg) = explode(",",$link);
							if($code==0)$con = "noc='$msg',status='RELIEVED',flag='1'";else $res=$msg;
						}else $res="Please Choose NOC File";
					}
				}else $con="flag='0'";
				/*if(isset($_FILES["profile_pic"]) && !empty($_FILES["profile_pic"]['name'])){
					$pro = upload_file($_FILES["profile_pic"],"profile_pic","image");
					if($pro){$con.=",profile_pic='$pro'";}
				}*/
				if(!empty($con)){
					$q=mysqli_query($mr_con,"UPDATE ec_employee_master SET name='$emp_name',employee_id='$emp_id',email_id='$email_id',mobile_number='$mobile_number',zone_alias='$zone_alias',state_alias='$state_alias',segment_alias='$segment_alias',customer_alias='$customer_alias',base_location='$base_location',designation_alias='$designation_alias',department_alias='$department_alias',role_alias='$role_alias',esca_alias='$esca_alias',privilege_alias='$privilege_alias',qualification='$qualification',specialization='$specialization',total_experience='$totalexp',cash_card='$cash_card',joining_date='$joining_date',asset_alias='$asset_alias',wh_alias='$wh_alias',ths_notified='$ths_notified',$con WHERE employee_alias='$alias' AND flag=0");
					if($q){ $date=date('Y-m-d');
						$dism=mysqli_query($mr_con,"SELECT mrf_alias,status FROM ec_material_request WHERE status IN('1','7') AND flag=0");
						if(mysqli_num_rows($dism)){ $disr=mysqli_fetch_array($dism);
							if(($disr['status']=='1' || $disr['status']=='7') && empty(next_dynamic($disr['mrf_alias'],'E')))$disu=mysqli_query($mr_con,"UPDATE ec_material_request SET status='2' WHERE mrf_alias='".$disr['mrf_alias']."' AND flag=0");
							//if($disr['status']=='2' && !empty(next_dynamic($disr['mrf_alias'],'E')))$disu=mysqli_query($mr_con,"UPDATE ec_material_request SET status='1' WHERE mrf_alias='".$disr['mrf_alias']."' AND flag=0");
						}
						$adv_sql=mysqli_query($mr_con,"SELECT request_amount,advance_alias FROM ec_advances WHERE employee_alias='$alias' AND approved_by='' AND approval_level='6' AND flag IN ('0','1')");
						if(mysqli_num_rows($adv_sql)>0){
							$adv_row=mysqli_fetch_array($adv_sql);
							if(empty($adv_row['request_amount'])){
								mysqli_query($mr_con,"UPDATE ec_advances SET request_amount='$obal',total_amount='$obal',requested_date='$date' WHERE advance_alias='".$adv_row['advance_alias']."' AND approved_by=''");
							}
						}else{
							if(!empty($obal)){
								$rquestid="#".checkint(mt_rand(1000,999999999),'ec_advances','request_id');
								$alias_ad=aliasCheck(generateRandomString(),"ec_advances","advance_alias");
								$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
								mysqli_query($mr_con,"INSERT INTO ec_advances(employee_alias,request_amount,total_amount,request_id,requested_date,advance_alias,approval_level) VALUES ('$alias','$obal','$obal','$rquestid','$date','$alias_ad','6')");
								mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('Opening Balance','BA','$alias_ad','admin','$alias_remark')");
							}
						}
						$action="$emp_name with ID $emp_id Employee Updated";
						user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
						$resCode='0'; $resMsg='Successfull!';
					}else{$resCode = '4';$resMsg='Error in Updating!';}
				}
			}else{$res="The Requested Employee Id has already exist, Try with other values";}
		}
	}elseif($chk==1){$resCode='1';$resMsg=$_REQUEST['emp_alias'].", ".$_REQUEST['token'];}
	else{$resCode='2';$resMsg='Account Locked!';}
	if(isset($res) && !empty($res)){$resCode='4';$resMsg=$res;}
	$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function employee_master_single_view(){ global $mr_con;
	$emp_alias = $_REQUEST['emp_alias'];
	$token = $_REQUEST['token'];
		$chk=authentication($emp_alias,$token);
		if($chk==0){
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_employee_master WHERE employee_alias='$_REQUEST[alias]'");
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
					
					$result['segment_alias']=$row['segment_alias'];
					$seg = explode(", ",$row['segment_alias']);
					foreach($seg as $se){ $segg .= alias($se,'ec_segment','segment_alias','segment_name').", "; }
					$result['segment_name'] = trim($segg,", ");
					
					$result['customer_alias']=$row['customer_alias'];
					$cust = explode(", ",$row['customer_alias']);
					foreach($cust as $cu){ $cus .= alias($cu,'ec_customer','customer_alias','customer_code').", "; }
					$result['customer_code'] = trim($cus,", ");
					
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
					$result['cash_card']=$row['cash_card'];
					$result['ths_notified']=$row['ths_notified'];
					$adv_sql=mysqli_query($mr_con,"SELECT request_amount FROM ec_advances WHERE employee_alias='".$row['employee_alias']."' AND approved_by='' AND approval_level='6' AND flag IN ('0','1')");
					if(mysqli_num_rows($adv_sql)>0){
						$adv_row=mysqli_fetch_array($adv_sql);
						$opening_bal=$adv_row['request_amount'];
					}else $opening_bal='0';
					$result['opening_balance']=$opening_bal;
					$result['opening_hide']=(empty($opening_bal) ? TRUE : FALSE);
					$result['edit']=($row['status']=='RELIEVED' ? FALSE : grantable('EDIT','EMPLOYEE MASTER',$emp_alias));
				}
				$resCode='0'; $resMsg='Successfull!';
				}else{$resCode='4'; $resMsg='No Records Found';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']='2';$result['ErrorDetails']['ErrorMessage']='Account Locked!';
		echo json_encode($result);
}
function employee_master_mul_view(){ global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		if($_REQUEST['employeeId']!="")$employee_id="employee_id LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['employeeId'])."%' AND ";else $employee_id="";
		if($_REQUEST['name']!="")$name="name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['name'])."%' AND ";else $name="";
		if($_REQUEST['designation']!="")$designation="designation LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['designation'])."%' AND ";else $designation="";
		if($_REQUEST['zoneAlias']!="")$zone_alias="zone_alias LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['zoneAlias'])."%' AND ";else $zone_alias="";
		if($_REQUEST['roleName']!="")$role_name="role_alias LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['roleName'])."%' AND ";else $role_name="";
		if($_REQUEST['loginId']!="")$email_id="email_id LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['loginId'])."%' AND ";else $email_id="";
		if($_REQUEST['mobileNumber']!="")
			$mobile_number="mobile_number LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['mobileNumber'])."%' AND ";
		else 
			$mobile_number="";
		if($_REQUEST['empStatus']!="")
			$status="status LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['empStatus'])."%' AND ";
		else 
			$status=" ";
		$condtion=$employee_id.$name.$zone_alias.$role_name.$email_id.$mobile_number.$status;
		if(admin_privilege($emp_alias) || $emp_alias=='EADMIN'){$emp = "";}		
		else{
			$state_alias  = alias($emp_alias,'ec_employee_master','employee_alias','state_alias');
			$states = "'".implode("|",explode(", ",$state_alias))."'";
			$emp = "state_alias RLIKE ($states) AND";
		}
		$desg=(!empty($designation) ? "designation_alias IN (SELECT designation_alias FROM ec_designation WHERE $designation flag=0)" : " flag >= 0");
		$query = "SELECT COUNT(id) AS cnt FROM ec_employee_master WHERE $condtion $emp $desg";
		$rec=mysqli_query($mr_con, $query);
		if(mysqli_num_rows($rec)>0){
			$row1=mysqli_fetch_array($rec);
			$totalRecords=$row1['cnt'];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$query = "SELECT employee_id,name,designation_alias,zone_alias,role_alias,email_id,employee_alias,mobile_number,status FROM ec_employee_master WHERE $condtion $emp $desg ORDER BY status desc LIMIT $offset, $limit";
			$sql = mysqli_query($mr_con, $query);
			$result['employeemasterDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
					$result['employeemasterDetails'][$i]['employee_id']=$row['employee_id'];
					$result['employeemasterDetails'][$i]['name']=$row['name'];
					$result['employeemasterDetails'][$i]['designation']=alias($row['designation_alias'],'ec_designation','designation_alias','designation');
					foreach(explode(", ",$row['zone_alias']) as $y){ $yy[$i] .= alias($y,'ec_zone','zone_alias','zone_name').", "; }
					$zn=trim($yy[$i],", ");
					$result['employeemasterDetails'][$i]['zone_name']=(empty($zn) ? "--":$zn);
					//foreach(explode(", ",$row['state_alias']) as $z){ $zz[$i] .= alias($z,'ec_state','state_alias','state_name').", "; }
					//$result['employeemasterDetails'][$i]['state_name']=trim($zz[$i],", ");
					$result['employeemasterDetails'][$i]['role_name']=alias($row['role_alias'],'ec_emprole','role_alias','role_name');
					$result['employeemasterDetails'][$i]['email_id']=$row['email_id'];
					$result['employeemasterDetails'][$i]['employee_alias']=$row['employee_alias'];
					$result['employeemasterDetails'][$i]['mobile_number']=$row['mobile_number'];
					$result['employeemasterDetails'][$i]['status']=$row['status'];
					$i++;}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}$result['add']=grantable('ADD','EMPLOYEE MASTER',$emp_alias);
		$result['export']=grantable('EXPORT','EMPLOYEE MASTER',$emp_alias);
		$result['delete']=grantable('DELETE','EMPLOYEE MASTER',$emp_alias);
		$result['restore']=grantable('RESTORE','EMPLOYEE MASTER',$emp_alias);
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
	if($chk==0){ $con='';
		if(isset($_REQUEST['zone_alias']) && count($_REQUEST['zone_alias'])>0){
			$zone = implode("|",$_REQUEST['zone_alias']);
			$zone_arr=$_REQUEST['zone_alias'];
			$con .= "zone_alias RLIKE '$zone' AND ";
		}
		if(isset($_REQUEST['state_alias']) && count($_REQUEST['state_alias'])>0){
			$state = implode("|",$_REQUEST['state_alias']);
			$state_arr = $_REQUEST['state_alias'];
			$con .= "state_alias RLIKE '$state' AND ";
		}
		if(isset($_REQUEST['asset_alias']) && count($_REQUEST['asset_alias'])>0){
			$asset = implode("|",$_REQUEST['asset_alias']);
			$asset_arr = $_REQUEST['asset_alias'];
			$con .= "asset_alias RLIKE '$asset' AND ";
		}
		if(isset($_REQUEST['department_alias']) && count($_REQUEST['department_alias'])>0){
			$department_alias = implode("','",$_REQUEST['department_alias']);
			$con .= "department_alias IN ('$department_alias') AND ";
		}
		if(isset($_REQUEST['role_alias']) && count($_REQUEST['role_alias'])>0){
			$role_alias = implode("','",$_REQUEST['role_alias']);
			$con .= "role_alias IN ('$role_alias') AND ";
		}
		if(isset($_REQUEST['status']) && count($_REQUEST['status'])>0){
			$status = implode("','",$_REQUEST['status']);
			$con .= "status IN ('$status') AND ";
		}
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_employee_master WHERE $con flag IN ('0','1')"); 
		$colArr=array('Name','Employee Id','Email Id','Mobile Number','Base Location','Qualification','Specialization','Total Experience','El Experience','Joining Date','Relieving Date','Status','Device','Device 2','Created Date','Spl Previlage','Zone','State','Segment','Customer','Designation','Grade','Department','Role','Esca','Privilege','Assets','Cash Card','Opening Balance');
		$colArr2=array('name','employee_id','email_id','mobile_number','base_location','qualification','specialization','total_experience','el_experience','joining_date','relieving_date','status','device','device_2','created_date','spl_previlage');
		$filename = 'Employeemaster_'.date('d-m-Y H_i_s');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
		$ch = 'A';
		foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			if($ch=='J' || $ch=='K' || $ch=='O'){$objPHPExcel->getActiveSheet()->getStyle($ch)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$objPHPExcel->getActiveSheet()->getColumnDimension($ch)->setAutoSize(true);}
		$ch++;
		}
		$coo=1;
		while($row=mysqli_fetch_array($sql)){ $coo++; $zone_name=$state_name=$asset_name=$segment_name=$customer_code="-";
			if(!empty($row['zone_alias'])){
				$sqlz=mysqli_query($mr_con,"SELECT COUNT(id) AS zcnt,GROUP_CONCAT(zone_name) AS zone FROM ec_zone WHERE zone_alias IN('".str_replace(", ","','",$row['zone_alias'])."') AND flag='0'");
				$rowz=mysqli_fetch_array($sqlz);
				if($rowz['zcnt'])$zone_name=$rowz['zone'];
			}
			if(!empty($row['state_alias'])){
				$sqls=mysqli_query($mr_con,"SELECT COUNT(id) AS scnt,GROUP_CONCAT(state_name) AS state FROM ec_state WHERE state_alias IN('".str_replace(", ","','",$row['state_alias'])."') AND flag='0'");
				$rows=mysqli_fetch_array($sqls);
				if($rows['scnt'])$state_name=$rows['state'];
			}
			if(!empty($row['asset_alias'])){
				$sqla=mysqli_query($mr_con,"SELECT COUNT(id) AS acnt,GROUP_CONCAT(asset_name) AS asset FROM ec_assets WHERE asset_alias IN('".str_replace(", ","','",$row['asset_alias'])."') AND flag='0'");
				$rowa=mysqli_fetch_array($sqla);
				if($rowa['acnt'])$asset_name=$rowa['asset'];
			}
			if(!empty($row['segment_alias'])){
				$sqlsg=mysqli_query($mr_con,"SELECT COUNT(id) AS sgcnt,GROUP_CONCAT(segment_name) AS segment FROM ec_segment WHERE segment_alias IN('".str_replace(", ","','",$row['segment_alias'])."') AND flag='0'");
				$rowsg=mysqli_fetch_array($sqlsg);
				if($rowsg['sgcnt'])$segment_name=$rowsg['segment'];
			}
			if(!empty($row['customer_alias'])){
				$sqlc=mysqli_query($mr_con,"SELECT COUNT(id) AS ccnt,GROUP_CONCAT(customer_code) AS customer FROM ec_customer WHERE customer_alias IN('".str_replace(", ","','",$row['customer_alias'])."') AND flag='0'");
				$rowc=mysqli_fetch_array($sqlc);
				if($rowc['ccnt'])$customer_code=$rowc['customer'];
			}
			$adv_sql=mysqli_query($mr_con,"SELECT request_amount FROM ec_advances WHERE employee_alias='".$row['employee_alias']."' AND approved_by='' AND approval_level='6' AND flag IN ('0','1')");
			if(mysqli_num_rows($adv_sql)>0){
				$adv_row=mysqli_fetch_array($adv_sql);
				$opening_bal=$adv_row['request_amount'];
			}else $opening_bal='0';
			for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
				$value = $row[$colArr2[$af]];
				if($chr=='I')$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, checkemptydash(el_experience($row['joining_date'], $row['relieving_date'])));
				elseif($chr=='M' || $chr=='N')$objPHPExcel->getActiveSheet()->setCellValueExplicit($chr.$coo, (!empty($value) ? $value : '-'),PHPExcel_Cell_DataType::TYPE_STRING);
				else $objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, ($chr=='J' || $chr=='K' || $chr=='O' ? php_excel_date($value) : checkemptydash($value)));
				//$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
			}														
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$coo, checkemptydash($zone_name));
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$coo, checkemptydash($state_name));
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$coo, checkemptydash($segment_name));
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$coo, checkemptydash($customer_code));
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$coo, checkemptydash(alias($row['designation_alias'],'ec_designation','designation_alias','designation')));
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$coo, checkemptydash(alias($row['designation_alias'],'ec_designation','designation_alias','grade')));
			$objPHPExcel->getActiveSheet()->SetCellValue('W'.$coo, checkemptydash(alias($row['department_alias'],'ec_department','department_alias','department_name')));
			$objPHPExcel->getActiveSheet()->SetCellValue('X'.$coo, checkemptydash(alias($row['role_alias'],'ec_emprole','role_alias','role_name')));
			$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$coo, checkemptydash(alias($row['esca_alias'],'ec_esca','esca_alias','esca_name')));
			$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$coo, checkemptydash(alias($row['privilege_alias'],'ec_privileges','privilege_alias','privilege_name')));
			$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$coo, checkemptydash($asset_name));
			$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$coo, checkemptydash($row['cash_card']));
			$objPHPExcel->getActiveSheet()->SetCellValue('AC'.$coo, checkemptydash($opening_bal));				
				
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
			$action=$district_name." Profile picture Updated";
			user_history($emp_alias,$action,$_REQUEST['ip_addr']);
			$resCode="0";$resMsg="Successfull!";
		}
	}else{$resCode=$msg[0];$resMsg=end($msg);}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function employee_master_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	$grantable = grantable('DELETE','EMPLOYEE MASTER',$emp_alias);
	if(!$grantable){
		$resCode = 1;
		$resMsg='Authentication Failed!';
	}
	if($grantable && $rex==0) {
			
		$employee_id = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['employee_id'])));
		$employee_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['employee_alias'])));
		$email_id = mysqli_real_escape_string($mr_con,trim($_REQUEST['email_id']));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		}
		else if(empty($employee_id) || empty($email_id) || empty($employee_alias)) {
			$res="Invalid Request";
		}
		else {
			$query = "SELECT * FROM ec_employee_master WHERE employee_id = '$employee_id' AND employee_alias = '$employee_alias' AND email_id = '$email_id'
			AND `status` != 'DELETED' limit 1";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql)== 1) {
				$userDetails = mysqli_fetch_assoc($sql);
				$employee_name = $userDetails['name'];
				$query = "UPDATE ec_employee_master set `status` = 'DELETED' where employee_id = '$employee_id' AND employee_alias = '$employee_alias' AND email_id = '$email_id'";
				$sql = mysqli_query($mr_con, $query);
				if($sql) {
					$action = "Employee with employee name $employee_name and id $employee_id is deleted.";
					user_history($emp_alias, $action, $_REQUEST['ip_addr'], $remarks);
					$resCode='0';$resMsg='Successful!';
				} else {
					$res = 'Failed to delete employee details.';	
				}
			}else{$res = "Employee doesn't exist."; }
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function employee_master_restore() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	$grantable = grantable('RESTORE','EMPLOYEE MASTER',$emp_alias);
	if(!$grantable){
		$resCode = 1;
		$resMsg='Authentication Failed!';
	}
	if($grantable && $rex==0) {
			
		$employee_id = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['employee_id'])));
		$employee_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['employee_alias'])));
		$email_id = mysqli_real_escape_string($mr_con,trim($_REQUEST['email_id']));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		}
		else if(empty($employee_id) || empty($email_id) || empty($employee_alias)) {
			$res="Invalid Request";
		}
		else {
			$query = "SELECT * FROM ec_employee_master WHERE employee_id = '$employee_id' AND employee_alias = '$employee_alias' AND email_id = '$email_id'
			AND `status` = 'DELETED' limit 1";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql)== 1) {
				$userDetails = mysqli_fetch_assoc($sql);
				$employee_name = $userDetails['name'];
				$status = "WORKING";
				if($userDetails['relieving_date'] != "0000-00-00") {
					$status = "RELIEVED";
				}
				$query = "UPDATE ec_employee_master set `status` = '$status' where employee_id = '$employee_id' AND employee_alias = '$employee_alias' AND email_id = '$email_id'";
				$sql = mysqli_query($mr_con, $query);
				if($sql) {
					$action = "Employee with employee name $employee_name and id $employee_id is restored.";
					user_history($emp_alias, $action, $_REQUEST['ip_addr'], $remarks);
					$resCode='0';$resMsg='Successful!';
				} else {
					$res = 'Failed to restore employee details.';	
				}
			}else{$res = "Employee doesn't exist."; }
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

?>