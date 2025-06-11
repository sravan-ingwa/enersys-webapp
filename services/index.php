<?php 
require 'Slim/Slim.php';
include('mysql.php');
include('functions.php');
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->post('/login_web','login_web');
$app->post('/validate_token','validate_token');
$app->post('/logout','logout');
$app->post('/checklogin','checklogin');
$app->post('/welcomenote','welcomenote');
$app->post('/forgot','forgotpass');
$app->post('/change_password','change_password');
$app->post('/password_management','password_management');
$app->post('/lockscreen','lockscreen');
$app->post('/lockAdd','lockAdd');
$app->post('/profile_view','profile_view');
$app->post('/employeeWh','employeeWh');
$app->post('/stockexp_drop_downs','stockexp_drop_downs');
$app->post('/at_ic_check','at_ic_check');
$app->post('/settings_hide','settings_hide');
$app->post('/site_warranty_check','site_warranty_check');
//single drop downs
$app->post('/moc_drop','moc_drop');
$app->post('/shift_drop','shift_drop');
$app->post('/zone_drop','zone_drop');
$app->post('/state_drop','state_drop');
$app->post('/district_drop','district_drop');
$app->post('/segment_drop','segment_drop');
$app->post('/activity_drop','activity_drop');
$app->post('/level_drop','level_drop');
$app->post('/asset_drop','asset_drop');
$app->post('/designation_drop','designation_drop');
$app->post('/department_drop','department_drop');
$app->post('/employeerole_drop','employeerole_drop');
$app->post('/employee_list_drop','employee_list_drop');
$app->post('/privilage_drop','privilage_drop');
$app->post('/customer_drop','customer_drop');
$app->post('/other_seg','other_seg');
$app->post('/warehouse_drop','warehouse_drop');
$app->post('/warehouse_emp_drop','warehouse_emp_drop');
$app->post('/milestone_drop','milestone_drop');
$app->post('/esca_drop','esca_drop');
$app->post('/esca_name_drop','esca_name_drop');
$app->post('/esca_service_drop','esca_service_drop');
$app->post('/cell_itemcode_drop','cell_itemcode_drop');
$app->post('/access_itemcode_drop','access_itemcode_drop');
$app->post('/accessory_desc_drop','accessory_desc_drop');
$app->post('/product_desc_drop','product_desc_drop');
$app->post('/product_battery_rating_drop','product_battery_rating_drop');
$app->post('/role_employee_mul_drop','role_employee_mul_drop');
$app->post('/role_employee_mul_drop_all','role_employee_mul_drop_all');
$app->post('/ths_notified_emp','ths_notified_emp');
$app->post('/employeename_drop','employeename_drop');
$app->post('/esca_employeename_drop','esca_employeename_drop');
$app->post('/faulty_code_drop','faulty_code_drop');
$app->post('/general_emprole_drop_downs','general_emprole_drop_downs');
$app->post('/general_emprole_emplist_drop_downs','general_emprole_emplist_drop_downs');
$app->post('/req_cells_drop','req_cells_drop');
$app->post('/req_acc_drop','req_acc_drop');
$app->post('/event_dpr','event_dpr');
$app->post('/requested_cells_drop','requested_cells_drop');
$app->post('/dynamiclevel_privilage_order_drop','dynamiclevel_privilage_order_drop');
//double dependant drop downs
$app->post('/zone_state_drop','zone_state_drop');
$app->post('/state_district_drop','state_district_drop');
$app->post('/state_emp_drop','state_emp_drop');
$app->post('/activity_complaint_drop','activity_complaint_drop');
$app->post('/activity_complaint_mul_drop','activity_complaint_mul_drop');
$app->post('/segment_cust_drop','segment_cust_drop');
$app->post('/segment_sitetype_drop','segment_sitetype_drop');
//Multipleselect dropdowns
$app->post('/activity_code_drop','activity_code_drop');
$app->post('/stock_code_drop','stock_code_drop');
$app->post('/zone_state_mul_drop','zone_state_mul_drop');
$app->post('/zone_state_district_mul_dropexport','zone_state_district_mul_dropexport');
$app->post('/asset_mul_drop','asset_mul_drop');
$app->post('/asset_make_mul_drop','asset_make_mul_drop');
$app->post('/asset_sno_mul_drop','asset_sno_mul_drop');
$app->post('/assets_emp_mul_drop','assets_emp_mul_drop');
$app->post('/segment_cust_mul_drop','segment_cust_mul_drop');
$app->post('/site_prod_mul_drop','site_prod_mul_drop');
$app->post('/cust_product_mul_drop','cust_product_mul_drop');
$app->post('/zone_mul_drop_export','zone_mul_drop_export');
$app->post('/zone_state_mul_drop_export','zone_state_mul_drop_export');
$app->post('/zone_ware_mul_drop_export','zone_ware_mul_drop_export');
$app->post('/ticket_activity_mul','ticket_activity_mul');
$app->post('/ticket_site_mul','ticket_site_mul');
$app->post('/ticket_complaint_mul','ticket_complaint_mul');
$app->post('/ticket_customer_mul','ticket_customer_mul');
$app->post('/ticket_level_mul','ticket_level_mul');
$app->post('/state_whcode_mul_drop','state_whcode_mul_drop');
$app->post('/mulempdrop','mulempdrop');
//Delete
$app->post('/del_remark_reqcell','del_remark_reqcell');
//Settings Count
$app->post('/settings_count','settings_count');
$app->post('/left_menu','left_menu');
$app->post('/url_menu','url_menu');
$app->post('/whonlyclose','whonlyclose');
$app->post('/scrapcellsget','scrapcellsget');
$app->post('/sjolist','sjolist');
$app->post('/mrf_drop','mrf_drop');
//expense
$app->post('/dep_emp_drop','dep_emp_drop');
$app->post('/exp_zone_drop','exp_zone_drop');
$app->post('/exp_state_drop','exp_state_drop');
$app->post('/exp_district_drop','exp_district_drop');
$app->post('/exp_azone_drop','exp_azone_drop');
$app->post('/exp_astate_drop','exp_astate_drop');
$app->post('/exp_adistrict_drop','exp_adistrict_drop');
$app->post('/district_area_drop','district_area_drop');
$app->post('/grade_drop','grade_drop');
$app->post('/gradedesg','gradedesg');
$app->post('/exlevels_drop','exlevels_drop');
$app->post('/getTicket','getTicket');
$app->post('/admnexlevels_drop','admnexlevels_drop');
$app->post('/exp_emp_drop','exp_emp_drop');
$app->post('/loadingF','loadingF');
$app->run();
function validate_token() {
	global $mr_con;
	$token = mysqli_real_escape_string($mr_con, $_REQUEST['token']);
	$query = "SELECT * FROM ec_token WHERE token = '$token' ";
	$tokenDetails = mysqli_fetch_array(mysqli_query($mr_con, $query));
	if($tokenDetails['token']) {
		$result['token']['user_auth'] = $tokenDetails['employee_alias'];
		$result['token']['token'] = $tokenDetails['token'];
		$result['token']['user_name'] = $tokenDetails['employee_name'];
		$result['token']['employee_type'] = $tokenDetails['employee_type'];
		$result['went1'] = "#/enersyscare";
		user_history($tokenDetails['employee_alias'], $action, $_REQUEST['ip_addr']);
		$error_code='0'; 
		$error_msg='Successful!';
	} else { 
		$error_code='1'; 
		$error_msg='#Oops! Invalid request!';
	}
	$result['ErrorDetails']['ErrorCode']=$error_code;
	$result['ErrorDetails']['ErrorMessage']=$error_msg;
	echo json_encode($result);
}
function login_web(){ 
	global $mr_con;
	$user=mysqli_real_escape_string($mr_con,$_REQUEST['user']);
	$password=mysqli_real_escape_string($mr_con,$_REQUEST['pwd']);
	if(!empty($user)){
		if(!empty($password)){
			$ad_id=alias_flag_none($user,'ec_admin','user_name','id');
			if(!empty($ad_id)){ //Admin and Eadmin
				$ad_sql = mysqli_query($mr_con,"SELECT password,type,flag FROM ec_admin WHERE id='$ad_id'");
				$ad_row = mysqli_fetch_array($ad_sql);
				if($ad_row['flag']=='0'){ //$ad_row['type'];
					$hash = login_hash_encript_check($password,$ad_row['password']);
					if($hash[0]){
						if(count($hash)>1)password_rehash_update($hash[1],'ec_admin',$ad_id);
						$result['token']['user_auth']=$user;
						$result['token']['token']=generate_token($user, $userName, 0);
						$result['token']['user_name']=$user;
						$result['token']['employee_type']='0';
						$result['went1']="#/enersyscare";
						$action = $user." loggedin";
						user_history($user,$action,$_REQUEST['ip_addr']);
						$error_code='0'; $error_msg='Successful!';
					} else {
						$error_code='1'; $error_msg='Please use OKTA authentications to login!';
					}
				}else{ $error_code='1'; $error_msg='Account Locked!'; }
			}else{
				$ep_id=alias_flag_none($user,'ec_employee_master','employee_id','id');
				if(!empty($ep_id)){ 
					//Employee Master
					$ep_sql = mysqli_query($mr_con,"SELECT name,employee_alias,password,status,flag, role_alias FROM ec_employee_master WHERE id='$ep_id'");
					$ep_row = mysqli_fetch_array($ep_sql);
					if($ep_row['flag']=='0'){
						$hash = login_hash_encript_check($password,$ep_row['password']);
						if($hash[0]){
							if(count($hash)>1)password_rehash_update($hash[1],'ec_employee_master',$ep_id);
							$result['token']['user_auth']=$ep_row['employee_alias'];
							$result['token']['token']=generate_token($ep_row['employee_alias'], $ep_row['name'], 1);
							$result['token']['user_name']=$ep_row['name'];
							$result['token']['employee_type']='1';
							$result['went1']="#/enersyscare";
							$action = $ep_row['name']." loggedin";
							user_history($ep_row['employee_alias'],$action,$_REQUEST['ip_addr']);
							$error_code='0'; $error_msg='Successful!';
						} else { 
							if($ep_row['role_alias'] == '01ZMYJ4OLG') {
								$error_code='1'; $error_msg='#Oops! You have entered a wrong password!';
							} else {
								$error_code='1'; $error_msg='Please use OKTA authentications to login!';
							}
						}
					} else { 
						$error_code='1'; $error_msg='Please use OKTA authentications to login!'; 
					}
				}else {
					$es_id=alias_flag_none($user,'ec_esca','esca_id','id');
					if(!empty($es_id)){ //Esca Login
						$es_sql = mysqli_query($mr_con,"SELECT esca_name,esca_alias,password,flag FROM ec_esca WHERE id='$es_id'");
						$es_row = mysqli_fetch_array($es_sql);
						if($es_row['flag']=='0'){
							$hash = login_hash_encript_check($password,$es_row['password']);
							if($hash[0]){
								if(count($hash)>1)password_rehash_update($hash[1],'ec_esca',$es_id);
								$result['token']['user_auth']=$es_row['esca_alias'];
								$result['token']['token']=generate_token($es_row['esca_alias'], $es_row['esca_name'], 0);
								$result['token']['user_name']=$es_row['esca_name'];
								$result['token']['employee_type']='0';
								$result['went1']="#/enersyscare";
								$action = $es_row['esca_name']." (ESCA) loggedin";
								user_history($es_row['esca_alias'],$action,$_REQUEST['ip_addr']);
								$error_code='0'; $error_msg='Successful!';
							}else{ $error_code='1'; $error_msg='#Oops! You have entered a wrong password!';}
						}else{ $error_code='1'; $error_msg='Your account has Locked, Please contact admin!'; }
					}else{
						$cu_id=alias_flag_none($user,'ec_customer','customer_id','id');
						if(!empty($cu_id)){ //Customer Login
							$cu_sql = mysqli_query($mr_con,"SELECT customer_name,customer_alias,password,flag FROM ec_customer WHERE id='$cu_id'");
							$cu_row = mysqli_fetch_array($cu_sql);
							if($cu_row['flag']=='0'){
								$hash = login_hash_encript_check($password,$cu_row['password']);
								if($hash[0]){
									if(count($hash)>1)password_rehash_update($hash[1],'ec_customer',$cu_id);
									$result['token']['user_auth']=$cu_row['customer_alias'];
									$result['token']['token']=generate_token($cu_row['customer_alias'], $cu_row['customer_name'], 0);
									$result['token']['user_name']=$cu_row['customer_name'];
									$result['token']['employee_type']='0';
									$result['went1']="#/enersyscare";
									$action = $cu_row['customer_name']." (CUSTOMER) loggedin";
									user_history($cu_row['customer_alias'],$action,$_REQUEST['ip_addr']);
									$error_code='0'; $error_msg='Successful!';
								}else{ $error_code='1'; $error_msg='#Oops! You have entered a wrong password!';}
							}else{ $error_code='1'; $error_msg='Your account has Locked, Please contact admin!'; }
						}else{ $error_code = '1'; $error_msg = "Hi Your Customer ID $user is not Registered<br>Please Contact Admin"; }
					}
				}
			}
		}else{ $error_code = '1'; $error_msg = "Please Enter Password"; }
	}else{ $error_code = '1'; $error_msg = "Please Enter Employee ID"; }
	$result['ErrorDetails']['ErrorCode']=$error_code;
	$result['ErrorDetails']['ErrorMessage']=$error_msg;
	echo json_encode($result);
}
function getbesturl($emp_alias){ global $mr_con;
	$privilege_alias = alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias');
	$sql_num=mysqli_num_rows(mysqli_query($mr_con,"SELECT grantable FROM ec_privileges WHERE privilege_alias='$privilege_alias' AND privilege_item IN('CUSTOMER PULSE','FAULT ANALYSIS','MANUFACTURE MONTH WISE FAILURE','MONTHLY ANALYSIS','NATURE OF ACTIVITY','PRODUCT CONTRIBUTION IN FAILURE','TAT','TICKET STATUS','TODAYS INFO REPORT BLOCK') AND privilege_type='VIEW' AND grantable='1' AND flag=0"));
	if($sql_num > '0')return '#/dashboard';
	else{
		$pvt=array('TICKETS','PLANNER','SITEMASTER','EMPLOYEE MASTER','MATERIAL BALANCE','MATERIAL INWARD','MATERIAL OUTWARD','MATERIAL REQUEST','STOCKS','SJO SEARCH','REFRESHING','REVIVAL','EXPENSE TRACKER','TRACKING SYSTEM','IMEI ACT DEACT');
		$pvt_a=array('tickets','calendar','Sitemaster','Employeemaster','Materialbalance','Materialinward','Materialoutward','Materialrequest','items_view','sjo_search','Refreshing','Revival','expense_dashboard','usertracking','imeicontrol');
		for($sas=0;$sas<count($pvt);$sas++){
			$sql_count=mysqli_num_rows(mysqli_query($mr_con,"SELECT grantable FROM ec_privileges WHERE privilege_alias='$privilege_alias' AND privilege_item='".$pvt[$sas]."' AND privilege_type='VIEW' AND grantable='1' AND flag=0"));
			if($sql_count > '0')return '#/'.$pvt_a[$sas];
		}if($sas == count($pvt))return '#/401';
	}
}
function at_ic_check(){global $mr_con;
	$activity_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['act_alias']));
	$site_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_alias']));
	$sql=mysqli_query($mr_con,"SELECT id FROM ec_tickets WHERE site_alias='$site_alias' AND activity_alias='$activity_alias' AND flag=0");
	echo (mysqli_num_rows($sql)>'0' ? 0 : 1);
}
function settings_hide() { 
	global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, $_REQUEST['alias']));
	$result['admin_privilege'] = settingHideStatus($emp_alias);
	echo json_encode($result);
}

function settingHideStatus($emp_alias) {
	global $mr_con;
	if($emp_alias=='ADMIN' || $emp_alias=='EADMIN'){
		return true;
	} else {
		$privilege_alias = alias($emp_alias, 'ec_employee_master', 'employee_alias', 'privilege_alias');
		$query = "SELECT grantable FROM ec_privileges WHERE privilege_item in ('ACCESSORIES', 'ASSETS', 'COMPLAINTS', 'CUSTOMERS', 'DEPARTMENTS', 'DESIGNATIONS', 'DISTRICTS', 'DPR CATEGORIES', 'EMPLOYEE ROLES', 'ESCA', 'FAULTY CODES', 'MILESTONES', 'MOC', 'PRIVILEGES', 'PRODUCTS', 'SITE TYPES', 'STATES', 'SHIFTS', 'WAREHOUSES', 'WORK GUIDES', 'ZONES', 'ACTIVITIES', 'BUCKETS', 'CHANGE LOG', 'DROPDOWNS', 'DYNAMIC LEVELS', 'LEVELS', 'MANUALS', 'PRIVACY POLICY', 'SEGMENTS', 'STOCK CODES','ALLOWANCES', 'APPROVERS', 'LIMITS') AND privilege_type in ('VIEW', 'ADD', 'EDIT', 'EXPORT', 'DELETE') AND privilege_alias='$privilege_alias' AND flag='0'";
		$sql = mysqli_query($mr_con, $query);
		return mysqli_num_rows($sql) > 0 ? true : false;
	}
}
function logout(){ global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$em = alias($emp_alias,'ec_employee_master','employee_alias','name');
		$esm = alias($emp_alias,'ec_esca','esca_alias','esca_name');
		if($emp_alias=='ADMIN'){$emp_name='ADMIN';}
		elseif($emp_alias=='EADMIN'){$emp_name='EADMIN';}
		elseif($em!=""){$emp_name=$em;}
		elseif($esm!=""){$emp_name=$esm;}
		else{$emp_name=alias($emp_alias,'ec_customer','customer_alias','customer_name');}
		$action = $emp_name." loggedout";
		user_history($emp_alias,$action,$_REQUEST['ip_addr']);
		$sql=mysqli_query($mr_con,"DELETE FROM ec_token WHERE employee_alias='$emp_alias' AND token='$token' AND flag='0'");
		$resCode='0';$resMsg='Success!';
	}elseif($rex==1){ $resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function lockAdd(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	if($emp_alias!='' && $emp_alias!='0' && !empty($emp_alias) && $token!='' && $token!='0' && !empty($token)){
		$q1=mysqli_query($mr_con,"UPDATE ec_token SET stage='1' WHERE employee_alias='$emp_alias' AND token='$token'");
		if($q1)	echo 1;else echo 0;
	}else echo 0;
}
function checklogin(){global $mr_con;
	$acsd=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($acsd=='0'){
		$emp_alias=$_REQUEST['emp_alias'];
		$token=$_REQUEST['token'];
		$sql = mysqli_query($mr_con,"SELECT id FROM ec_token WHERE employee_alias='$emp_alias' AND token='$token' AND stage='0' AND flag=0");
		if(mysqli_num_rows($sql)>'0'){echo '0';}
		else{echo '3';}
	}else echo $acsd; 
}	
function welcomenote(){global $mr_con;
	$emp_id=strtoupper( mysqli_real_escape_string($mr_con,$_REQUEST['user_auth']));
	if($emp_id=='ADMIN' || $emp_id=='EADMIN'){
		$resCode='0';$resMsg=$emp_id;
		$loginType = 'okta';
	} else {
		$sql = mysqli_query($mr_con,"SELECT name,flag, role_alias FROM ec_employee_master WHERE employee_id='$emp_id'");
		$loginType = 'portal';
		if(mysqli_num_rows($sql)>0){
			$row = mysqli_fetch_array($sql);
			$resCode = $row['flag']=='0' ? '0' : ($row['flag']=='1' ? '2' : '1');
			$resMsg=$row['name'];
			if($row['role_alias'] != '01ZMYJ4OLG') {
				$loginType = 'okta';
			}
		}else{
			$sql2 = mysqli_query($mr_con,"SELECT esca_name,flag FROM ec_esca WHERE esca_id='$emp_id'");
			if(mysqli_num_rows($sql2)>0){
				$row2 = mysqli_fetch_array($sql2);
				$resCode = $row2['flag']=='0' ? '0' : ($row2['flag']=='1' ? '2' : '1');
				$resMsg=$row2['esca_name'];
			}else{
				$sql3 = mysqli_query($mr_con,"SELECT customer_name,flag FROM ec_customer WHERE customer_id='$emp_id'");
				if(mysqli_num_rows($sql3)>0){
					$row3 = mysqli_fetch_array($sql3);
					$resCode = $row3['flag']=='0' ? '0' : ($row3['flag']=='1' ? '2' : '1');
					$resMsg=$row3['customer_name'];
				}else{
					$resCode='1';$resMsg=$emp_id;
				}
			}
		}
	}
	$result['ErrorDetails']['ErrorCode']=$resCode;
	$result['token']['user_name']=$resMsg;
	$result['token']['loginType']=$loginType;
	echo json_encode($result);
}
function change_password(){ 
	global $mr_con;
	$emp_alias = $_COOKIE['emp_alias'];
	//$emp_alias=mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$old_pass=mysqli_real_escape_string($mr_con,$_REQUEST['old_pass']);
	$new_pass=mysqli_real_escape_string($mr_con,$_REQUEST['new_pass']);
	$con_pass=mysqli_real_escape_string($mr_con,$_REQUEST['con_pass']);
	if($new_pass===$con_pass){
		if(strtoupper($emp_alias)=='ADMIN' || strtoupper($emp_alias)=='EADMIN'){
			$tbl="ec_admin";$ref=$get="user_name";
		} else {
			$tbl="ec_employee_master";$ref="employee_alias";$get="name";
		}
		$sql=mysqli_query($mr_con,"SELECT $get,password,id FROM $tbl WHERE $ref='$emp_alias' AND flag='0'");
		if(mysqli_num_rows($sql)){
			$rro=mysqli_fetch_array($sql);
			$hash = login_hash_encript_check($old_pass,$rro['password']);
			if($hash[0]){
				$res = password_rehash_update(password_hash_encript($new_pass),$tbl,$rro['id']);
				if($res){
					$resCode='0';$resMsg='Successful';
					$action = $rro[$get]." has changed his/her password";
					user_history($emp_alias,$action,$_REQUEST['ip_addr']);
				}
			}else{ $resCode='4'; $resMsg='#Oops! You have entered a wrong password!';}
		}else{ $resCode='4';$resMsg='Something went wrong, please try again!';}
	}else{ $resCode='4';$resMsg='New Password and Confirm Password Should match';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function password_management(){ 
	global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		//$admin_pass=mysqli_real_escape_string($mr_con,$_REQUEST['admin_pass']);
		//if(!empty($admin_pass)){
			$user_type=mysqli_real_escape_string($mr_con,$_REQUEST['user_type']);
			$user_alias=mysqli_real_escape_string($mr_con,$_REQUEST['user_alias']);
			$new_pass=mysqli_real_escape_string($mr_con,$_REQUEST['new_pass']);
			$con_pass=mysqli_real_escape_string($mr_con,$_REQUEST['con_pass']);
			if($new_pass===$con_pass){
				if($user_type=='1'){$tbl = "ec_employee_master"; $ref="employee_alias";$name="name";}
				elseif($user_type=='2'){$tbl = "ec_esca"; $ref="esca_alias";$name="esca_name";}
				elseif($user_type=='3'){$tbl = "ec_customer"; $ref="customer_alias";$name="customer_code";}
				else{$tbl = ""; $ref="";}
				//$validUser = authenticateUser($emp_alias, $admin_pass);
				//if($validUser['status']) {
					$id = alias($user_alias, $tbl, $ref, 'id');
					$res = password_rehash_update(password_hash_encript($new_pass),$tbl,$id);
					if($res) {
						$resCode='0';
						$resMsg='Successful';
						user_history($emp_alias, "Changed ".alias($user_alias, $tbl, $ref, $name)."\'s password",$_REQUEST['ip_addr']);
					} else {
						$resCode='0';$resMsg="Sorry, password doesn\'t updated, try again!";
					}
				//} else { 
					//$resCode='4';$resMsg=$validUser['msg'];
				//}
			}else{ $resCode='4';$resMsg='New Password and Confirm Password Should match';}
		// }else { $resCode='4';$resMsg='Enter admin password';}
	}elseif($rex==1){ $resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function authenticateUser($emp_alias, $password) {
	global $mr_con; 
	$result = [
		'status' => false,
		'msg' => "",
	];
	if(strtoupper($emp_alias) == 'ADMIN') {
		$query = "SELECT password FROM ec_admin WHERE user_name='admin' AND flag='0'";
	} else {
		$query = "SELECT name, employee_alias, password, status, flag FROM ec_employee_master WHERE employee_alias='$emp_alias'";
	}
	$sql = mysqli_query($mr_con, $query);
	if(mysqli_num_rows($sql) == 0) {
		$result['msg'] = "Something wnet wrong, contact admin";
		return $result;
	}
	$rro = mysqli_fetch_array($sql);
	$hash = login_hash_encript_check($password, $rro['password']);
	if(!$hash[0]) {
		$result['msg'] = '#Oops! You have entered a wrong password!';
		return $result;
	}
	$result['status'] = true;
	return $result;
}

function lockscreen(){ global $mr_con;
	$user_alias=mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token=mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$password=mysqli_real_escape_string($mr_con,$_REQUEST['password']);
	if(!empty($user_alias)){
		if(!empty($password)){
			$ad_sql = mysqli_query($mr_con,"SELECT id,password,flag FROM ec_admin WHERE user_name='$user_alias'");
			if(mysqli_num_rows($ad_sql)){ //Admin and Eadmin
				$ad_row = mysqli_fetch_array($ad_sql);
				if($ad_row['flag']=='0'){ //$ad_row['type'];
					$hash = login_hash_encript_check($password,$ad_row['password']);
					if($hash[0]){
						if(count($hash)>1)password_rehash_update($hash[1],'ec_admin',$ad_row['id']);
						$q1=mysqli_query($mr_con,"UPDATE ec_token SET stage='0' WHERE employee_alias='$user_alias' AND token='$token'");
						$action = $user_alias." unlocked his/her account";
						user_history($user_alias,$action,$_REQUEST['ip_addr']);
						$error_code='0'; $error_msg='Unlock Successful!';
					}else{ $error_code='1'; $error_msg='#Oops! You have entered a wrong password!';}
				}else{ $error_code='1'; $error_msg='Your account locked!'; }
			}else{
				$ep_sql = mysqli_query($mr_con,"SELECT id,name,password,flag FROM ec_employee_master WHERE employee_alias='$user_alias'");
				if(mysqli_num_rows($ep_sql)){ //Employee Master
					$ep_row = mysqli_fetch_array($ep_sql);
					if($ep_row['flag']=='0'){
						$hash = login_hash_encript_check($password,$ep_row['password']);
						if($hash[0]){
							if(count($hash)>1)password_rehash_update($hash[1],'ec_employee_master',$ep_row['id']);
							$q1=mysqli_query($mr_con,"UPDATE ec_token SET stage='0' WHERE employee_alias='$user_alias' AND token='$token'");
							$action = $ep_row['name']." unlocked his/her account";
							user_history($user_alias,$action,$_REQUEST['ip_addr']);
							$error_code='0'; $error_msg='Unlock Successful!';
						}else{ $error_code='1'; $error_msg='#Oops! You have entered a wrong password!';}
					}else{ $error_code='1'; $error_msg='Your account has Locked, Please contact admin!'; }
				}else {
					$es_sql = mysqli_query($mr_con,"SELECT id,esca_name,password,flag FROM ec_esca WHERE esca_alias='$user_alias'");
					if(mysqli_num_rows($es_sql)){ //Esca Login
						$es_row = mysqli_fetch_array($es_sql);
						if($es_row['flag']=='0'){
							$hash = login_hash_encript_check($password,$es_row['password']);
							if($hash[0]){
								if(count($hash)>1)password_rehash_update($hash[1],'ec_esca',$es_row['id']);
								$q1=mysqli_query($mr_con,"UPDATE ec_token SET stage='0' WHERE employee_alias='$user_alias' AND token='$token'");
								$action = $es_row['esca_name']." unlocked his/her account";
								user_history($user_alias,$action,$_REQUEST['ip_addr']);
								$error_code='0'; $error_msg='Unlock Successful!';
							}else{ $error_code='1'; $error_msg='#Oops! You have entered a wrong password!';}
						}else{ $error_code='1'; $error_msg='Your account has Locked, Please contact admin!'; }
					}else{
						$cu_sql = mysqli_query($mr_con,"SELECT id,customer_name,password,flag FROM ec_customer WHERE customer_alias='$user_alias'");
						if(mysqli_num_rows($cu_sql)){ //Customer Login
							$cu_row = mysqli_fetch_array($cu_sql);
							if($cu_row['flag']=='0'){
								$hash = login_hash_encript_check($password,$cu_row['password']);
								if($hash[0]){
									if(count($hash)>1)password_rehash_update($hash[1],'ec_customer',$cu_row['id']);
									$q1=mysqli_query($mr_con,"UPDATE ec_token SET stage='0' WHERE employee_alias='$user_alias' AND token='$token'");
									$action = $cu_row['customer_name']." unlocked his/her account";
									user_history($user_alias,$action,$_REQUEST['ip_addr']);
									$error_code='0'; $error_msg='Unlock Successful!';
								}else{ $error_code='1'; $error_msg='#Oops! You have entered a wrong password!';}
							}else{ $error_code='1'; $error_msg='Your account has Locked, Please contact admin!'; }
						}else{ $error_code = '1'; $error_msg = "Hi Your Customer ID $user is not Registered<br>Please Contact Admin"; }
					}
				}
			}
		}else{ $error_code = '2'; $error_msg = "Please Enter Password"; }
	}else{ $error_code = '2'; $error_msg = "Please Enter Employee ID"; }
	$result['ErrorDetails']['ErrorCode']=$error_code;
	$result['ErrorDetails']['ErrorMessage']=$error_msg;
	echo json_encode($result);
}
function forgotpass(){ global $mr_con;
	$emp_id=mysqli_real_escape_string($mr_con,$_REQUEST['emp_id']);
	if(!empty($emp_id)){
		if(strtoupper($emp_id)=='ADMIN' || strtoupper($emp_id)=='EADMIN'){
			$email_id=alias($emp_id,'ec_admin','user_name','email_id');
			$emp_name=alias($emp_id,'ec_admin','user_name','user_name');
		}
		/*
		else{
			$email_id=alias($emp_id,'ec_employee_master','employee_id','email_id');
			$emp_name=alias($emp_id,'ec_employee_master','employee_id','name');
		}
		*/
		if(!empty($email_id) && $email_id!="NA"){
			$r=base64_encode(generateRandomString()."_@".$emp_id);
			if(strtoupper($emp_id)=='ADMIN' || strtoupper($emp_id)=='EADMIN'){$tbl="ec_admin";$ref="user_name";}
			else {$tbl="ec_employee_master";$ref="employee_id";}
			$q1=mysqli_query($mr_con,"UPDATE $tbl SET verification_code='$r' WHERE $ref='$emp_id'");
			if($q1){
				$sub="Verification link for Reset Password";
				$body = "<html><body style='font-family:Calibri;'>";
				$body.="<table width='800px' style='border-collapse:collapse;' cellpadding='3' align='center'>";
					$body.="<tr align='center'>";
						$body.="<th align='center' style='border:1px solid #ddd; border-bottom:1px solid #fff;'>";
							$body.="<table width='100%' style='border-bottom:1px solid #000'>";
								$body.="<tr>";
									$body.="<th align='left'>
											<img src='".baseurl()."images/gallery/EnerSyslogo.png' alt='EnerSys_logo' height='80' width='150'>
											</th>";
								$body.="</tr>";
							$body.="</table>";
						$body.="</th>";
					$body.="</tr>";
					$body.="<tr>";
						$body.="<td align='center' style='border:1px solid #ddd;'>";
							$body.="<table width='100%'>";
								$body.="<tr>";
									$body.="<td align='right' style='font-size:13px;'><b>Date : </b>".date('d-m-Y')."</td>";
								$body.="</tr>";
							$body.="</table>";	
							$body.="<table width='100%' cellpadding='2'>";
								$body.="<tr>";
									$body.="<td align='center'><u><h3 style='margin:2px;'>RESET PASSWORD</h3></u></td>";
								$body.="</tr>";
							$body.="</table>";
			
							$body.="<table width='100%' cellpadding='5'>";
								$body.="<tr>";
									$body.="<td align='left'>Dear ".$emp_name.",<br><br></td>";
								$body.="</tr>";
								$body.="<tr>";
									$body.="<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please verify the link to <a href='".baseurl()."includes/resetPassword.php?verify=".$r."' target='_blank'>reset password</a></td>";
								$body.="</tr>";
			
								$body.="<tr>";
									$body.="<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Note:</b> This link works only once.<br><br></td>";
								$body.="</tr>";
							$body.="</table>";
							
							$body.="<table width='100%' cellpadding='5'>";
								$body.="<tr>";
									$body.="<td align='left'>Thanking and assuring our best service.</td>";
								$body.="</tr>";
								$body.="<tr>";
									$body.="<td align='left'>Yours faithfully,</td>";
								$body.="</tr>";
								$body.="<tr>";
									$body.="<td align='left'>EnerSys Care.</td>";
								$body.="</tr>";
							$body.="</table>";
							
							$body.="<table width='100%' cellpadding='1' style='border-top:1px solid #000'>";
								$body.="<tfoot>";
									$body.="<tr>";
										$body.="<td align='center' style='padding:8px;'>
												 <p style='font-size:11px; font-weight:600;'>Registered Office :EnerSys India Batteries Private Limited, Survey N.118,135,137 & 139, Narasimharaopalem (Village),Veerullapadu (Mandal), VIJAYAWADA ,Krishna (District),
												 Andhra Pradesh-521181, India, Ph :9652525292,E-Mail : service@enersys.co.in</p>
												</td>";
									$body.="</tr>";
								$body.="</tfoot>";
							$body.="</table>";
							
						$body.="</td>";
					$body.="</tr>";
				$body.="</table>";
				$body.="<p style='font-style:italic;text-align:center;'><small>*** This is system generated document no signature required ***</small></p>";
				$body.="</body></html>";
				$from = all_from_mail();
				$headerg= 'From: EnerSys Care <'.$from.'>' . "\r\n";
				$headerg.= 'Reply-To: '.$from ."\r\n";
				$headerg.= "Content-Type: text/html\r\n";
				$headerg.= "X-Mailer: PHP/" . phpversion();
				$headerg.= 'MIME-Version: 1.0' . "\r\n";
				$m=mail($email_id, $sub, $body, $headerg);
				if($m){$resCode='0';$resMsg='We sent you reset link to the Registered Email ID.';}else{$resCode='4';$resMsg='Sending Failed';}
			}else{$resCode='4';$resMsg='Sorry Falied';}
		}else{$resCode='4';$resMsg='The mail is not available in our database. please check!';}
	}else{$resCode='4';$resMsg='Please Enter Employee ID';}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function profile_view(){ 
	global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['alias']));
	if($emp_alias!="ADMIN" && $emp_alias!="EADMIN"){
		$sql = mysqli_query($mr_con,"SELECT privilege_alias,employee_alias,name,profile_pic,designation_alias FROM ec_employee_master WHERE employee_alias='$emp_alias' AND flag=0");
		if(mysqli_num_rows($sql)>0){
			$row = mysqli_fetch_array($sql);
			$result['emp_name']=$row['name'];
			$result['profile_hide']='emp';
			$result['employee_alias']=$row['employee_alias'];
			$result['employee_type']='1';
			$result['privilege_alias']=$row['privilege_alias'];
			$result['emp_name_short'] = (strlen($result['emp_name']) > 15) ? substr($result['emp_name'],0,15).'....' : $result['emp_name'];
			if(!empty($row['profile_pic'])){$result['profile_pic']="images/profile_pics/".$row['profile_pic'];}else{$result['profile_pic']="images/gallery/profile_male";}
			$result['privilege_name']=alias($row['designation_alias'],"ec_designation","designation_alias","designation");
		}
		$sql1=mysqli_query($mr_con,"SELECT esca_alias,esca_name,esca_id FROM ec_esca WHERE esca_alias='$emp_alias' AND flag=0");
		if(mysqli_num_rows($sql1)>0){
			$row1 = mysqli_fetch_array($sql1);
			$result['emp_name']=$row1['esca_name'];
			$result['profile_hide']='esca';
			$result['employee_alias']=$row1['esca_alias'];
			$result['employee_type']='0';
			$result['privilege_alias']="esca";
			$result['emp_name_short'] = (strlen($result['emp_name']) > 15) ? substr($result['emp_name'],0,15).'....' : $result['emp_name'];
			$result['profile_pic']="images/gallery/profile_male";
			$result['privilege_name']='';//alias(alias($row1['esca_alias'],'ec_employee_master','esca_alias','designation_alias'),"ec_designation","designation_alias","designation");
		}
		$sql2=mysqli_query($mr_con,"SELECT customer_alias,customer_name,customer_Id FROM ec_customer WHERE customer_alias='$emp_alias' AND flag=0");
		if(mysqli_num_rows($sql2)>0){ 
			$row2 = mysqli_fetch_array($sql2);
			$result['emp_name']=$row2['customer_Id'];
			$result['profile_hide']='esca';
			$result['employee_alias']=$row2['customer_alias'];
			$result['employee_type']='0';
			$result['privilege_alias']="customer";
			$result['emp_name_short'] = (strlen($result['emp_name']) > 15) ? substr($result['emp_name'],0,15).'....' : $result['emp_name'];
			$result['profile_pic']="images/gallery/profile_male";
			$result['privilege_name']=$row2['customer_name'];
		}
	}else{
		$result['emp_name']=$emp_alias;
		$result['profile_hide']='admin';
		$result['employee_alias']=$emp_alias;
		$result['employee_type']='0';
		$result['emp_name_short'] = $emp_alias;
		$result['privilege_name']="ADMINISTRATOR";
		$result['privilege_alias']=$emp_alias;
		$result['profile_pic']="images/gallery/profile_male";
	}
	$result['password_management'] = grantable('SPCL', 'PASSWORD MANAGEMENT', $emp_alias);;
	echo json_encode($result);
}
function setting_show($emp_alias){
	$adm_priv = admin_privilege($emp_alias);
	$privilege_alias = alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias');
	return ($adm_priv || $privilege_alias=='5KPS8Q0ZNB' || $privilege_alias=='WIMYJFDJPT' ? TRUE : FALSE);
}
function left_menu(){ 
	global $mr_con;
	$emp_alias =strtoupper( mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$employee_alias=alias($emp_alias,'ec_employee_master','employee_alias','employee_alias');
	$esca_alias=alias($emp_alias,'ec_esca','esca_alias','esca_alias');
	$customer_alias=alias($emp_alias,'ec_customer','customer_alias','customer_alias');
	$rex=authentication($emp_alias,$token);
		if($rex==0){
			$adm_priv = admin_privilege($emp_alias);
			$privilege_alias = alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias');
			$result['setting_show'] = settingHideStatus($emp_alias);
			if($adm_priv){
				$sql=mysqli_query($mr_con,"SELECT privilege_item FROM ec_privileges WHERE privilege_type='VIEW' AND flag=0 GROUP BY privilege_item");
				while($row = mysqli_fetch_array($sql)){
					$str = str_replace(" ","",$row['privilege_item']);
					$result[$str]=TRUE;
				}
				$fals=array('tickets_esca','employeemaster_esca','dashboard_esca','tickets_customer','sitemaster_customer','dashboard_customer','expenseDashboard');
				foreach($fals as $fal)$result[$fal]=FALSE;
				if($emp_alias=='ADMIN')$result['ADMIN']=TRUE;
				$result['expenseDashboard']=TRUE;
				$result['privilege_alias']='ADMIN';
			}elseif($emp_alias=='EADMIN'){
				$sql=mysqli_query($mr_con,"SELECT privilege_item FROM ec_privileges WHERE privilege_type='VIEW' AND privilege_item NOT IN('EMPLOYEE MASTER','EXPENSE TRACKER') AND flag=0 GROUP BY privilege_item");
				while($row = mysqli_fetch_array($sql)){
					$str = str_replace(" ","",$row['privilege_item']);
					$result[$str] =FALSE;
				}
				$fals=array('tickets_esca','employeemaster_esca','dashboard_esca','tickets_customer','sitemaster_customer','dashboard_customer','expenseDashboard');
				foreach($fals as $fal)$result[$fal]=FALSE;
				$tru=array('EXPENSETRACKER','EMPLOYEEMASTER','EADMIN');
				foreach($tru as $tr)$result[$tr]=TRUE;
				$result['expenseDashboard']=TRUE;
				$result['privilege_alias']='EADMIN';
			}else{
				if(!empty($employee_alias)){
					$sql=mysqli_query($mr_con,"SELECT grantable,privilege_item FROM ec_privileges WHERE privilege_type='VIEW' AND privilege_alias='$privilege_alias' AND flag=0");
					while($row = mysqli_fetch_array($sql)){
						$str = str_replace(" ","",$row['privilege_item']);
						$result[$str] = ($row['grantable']=='1' ? TRUE : FALSE);
					}
					$fals=array('tickets_esca','employeemaster_esca','dashboard_esca','tickets_customer','sitemaster_customer','dashboard_customer');
					foreach($fals as $fal)$result[$fal]=FALSE;
					$result['expenseDashboard']=TRUE;
					$result['privilege_alias']=$privilege_alias;
				}elseif(!empty($esca_alias)){
					$sql=mysqli_query($mr_con,"SELECT privilege_item FROM ec_privileges WHERE privilege_type='VIEW' AND flag=0 GROUP BY privilege_item");
					while($row = mysqli_fetch_array($sql)){
						$str = str_replace(" ","",$row['privilege_item']);
						$result[$str]=FALSE;
					}
					$fals=array('tickets_customer','sitemaster_customer','dashboard_customer');
					foreach($fals as $fal)$result[$fal]=FALSE;
					$tru=array('tickets_esca','employeemaster_esca','dashboard_esca');
					foreach($tru as $tr)$result[$tr]=TRUE;
					$result['privilege_alias']='';
				}elseif(!empty($customer_alias)){
					$sql=mysqli_query($mr_con,"SELECT privilege_item FROM ec_privileges WHERE privilege_type='VIEW' AND flag=0 GROUP BY privilege_item");
					while($row = mysqli_fetch_array($sql)){
						$str = str_replace(" ","",$row['privilege_item']);
						$result[$str]=FALSE;
					}
					$fals=array('tickets_esca','employeemaster_esca','dashboard_esca');
					foreach($fals as $fal)$result[$fal]=FALSE;
					$tru=array('tickets_customer','sitemaster_customer','dashboard_customer');
					foreach($tru as $tr)$result[$tr]=TRUE;
					$result['privilege_alias']='';
				}
			}
		$resCode='0';$resMsg='Success!';
	}elseif($rex==1){
	$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function url_menu(){ global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$menu_name = mysqli_real_escape_string($mr_con,$_REQUEST['menu_name']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		if($emp_alias=='ADMIN' || strtoupper($emp_alias)=='EADMIN') {
			$result['res']=$menu_name;
		} else {
			if(strpos($menu_name," ")!== false)$result['res']='404';
			else{
				$end = explode("/",$menu_name);
				switch(end($end)){
					case 'tickets': $result['res'] = url_menu_privilege('tickets','TICKETS',$emp_alias);break;
					case 'spottickets': $result['res'] = url_menu_privilege('spottickets','SPOT TICKETS',$emp_alias);break;
					case 'calendar': $result['res'] = url_menu_privilege('calendar','PLANNER',$emp_alias);break;
					case 'Sitemaster': $result['res'] = url_menu_privilege('Sitemaster','SITEMASTER',$emp_alias);break;
					case 'Employeemaster': $result['res'] = url_menu_privilege('Employeemaster','EMPLOYEE MASTER',$emp_alias);break;
					case 'advances':  $result['res'] = url_menu_privilege('advances','EXPENSE TRACKER',$emp_alias);break;
					case 'expense':  $result['res'] = url_menu_privilege('expense','EXPENSE TRACKER',$emp_alias);break;
					case 'expense_dashboard': $result['res'] = url_menu_privilege('expense_dashboard','EXPENSE TRACKER',$emp_alias);break;
					case 'Profile': $result['res'] = 'Profile';break;
					case 'dashboard-esca': $result['res'] = 'dashboard-esca';break;
					case 'tickets-esca': $result['res'] = 'tickets-esca';break;
					case 'employeemaster-esca': $result['res'] = 'employeemaster-esca';break;
					case 'dashboard-customer': $result['res'] = 'dashboard-customer';break;
					case 'tickets-customer': $result['res'] = 'tickets-customer';break;
					case 'sitemaster-customer': $result['res'] = 'sitemaster-customer';break;
					case 'Materialbalance': $result['res'] = url_menu_privilege('Materialbalance','MATERIAL BALANCE',$emp_alias);break;
					case 'Inwardbalance': $result['res'] = url_menu_privilege('Inwardbalance','MATERIAL BALANCE',$emp_alias);break;
					case 'Outwardbalance': $result['res'] = url_menu_privilege('Outwardbalance','MATERIAL BALANCE',$emp_alias);break;
					case 'Materialinward': $result['res'] = url_menu_privilege('Materialinward','MATERIAL INWARD',$emp_alias);break;
					case 'Materialoutward': $result['res'] = url_menu_privilege('Materialoutward','MATERIAL OUTWARD',$emp_alias);break;
					case 'Materialrequest': $result['res'] = url_menu_privilege('Materialrequest','MATERIAL REQUEST',$emp_alias);break;
					case 'Refreshing': $result['res'] = url_menu_privilege('Refreshing','REFRESHING',$emp_alias);break;
					case 'Revival': $result['res'] = url_menu_privilege('Revival','REVIVAL',$emp_alias);break;
					case 'sjo_search': $result['res'] = url_menu_privilege('sjo_search','SJO SEARCH',$emp_alias);break;
					case 'items_view': $result['res'] = url_menu_privilege('items_view','STOCKS',$emp_alias);break;
					case 'usertracking': $result['res'] = url_menu_privilege('usertracking','TRACKING SYSTEM',$emp_alias);break;
					case 'deactivation': $result['res'] = url_menu_privilege('deactivation','IMEI ACT DEACT',$emp_alias);break;
					case 'imeicontrol': 
						$result['res'] = url_menu_privilege('imeicontrol','IMEI ACT DEACT',$emp_alias);
						break;
					case 'dashboard': $result['res'] = dashboard_url_menu_privilege($emp_alias);break;
					case 'settings': 
						$result['res'] = settingHideStatus($emp_alias) ? 'settings' : 'dashboard';
						break;
					case 'zone': 
						$result['res'] = url_menu_privilege('zone','ZONES',$emp_alias);
						break;
					case 'state': 
						$result['res'] = url_menu_privilege('state','STATES',$emp_alias);
						break;
					case 'district': 
						$result['res'] = url_menu_privilege('district','DISTRICTS',$emp_alias);
						break;
					case 'designation': 
						$result['res'] = url_menu_privilege('designation','DESIGNATIONS',$emp_alias);
						break;
					case 'department': 
						$result['res'] = url_menu_privilege('department','DEPARTMENTS',$emp_alias);
						break;
					case 'email_sms':
						$result['res'] = url_menu_privilege('email_sms', 'EMAIL & SMS RECIPIENT', $emp_alias);
						break;
					case 'emprole': 
						$result['res'] = url_menu_privilege('emprole','EMPLOYEE ROLES',$emp_alias);
						break;
					case 'privilages': 
						$result['res'] = url_menu_privilege('privilages','PRIVILEGES',$emp_alias);
						break;
					case 'stockcode': 
						$result['res'] = url_menu_privilege('stockcode','STOCK CODES',$emp_alias);
						break;
					case 'segment': 
						$result['res'] = url_menu_privilege('segment','SEGMENTS',$emp_alias);
						break;
					case 'customer': 
						$result['res'] = url_menu_privilege('customer','CUSTOMERS',$emp_alias);
						break;
					case 'product': 
						$result['res'] = url_menu_privilege('product','PRODUCTS',$emp_alias);
						break;
					case 'complaint': 
						$result['res'] = url_menu_privilege('complaint','COMPLAINTS',$emp_alias);
						break;
					case 'faultycode': 
						$result['res'] = url_menu_privilege('faultycode','FAULTY CODES',$emp_alias);
						break;
					case 'activity': 
						$result['res'] = url_menu_privilege('activity','ACTIVITIES',$emp_alias);
						break;
					case 'levels': 
						$result['res'] = url_menu_privilege('levels','LEVELS',$emp_alias);
						break;
					case 'warehouse': 
						$result['res'] = url_menu_privilege('warehouse','WAREHOUSES',$emp_alias);
						break;
					case 'assets': 
						$result['res'] = url_menu_privilege('assets','ASSETS',$emp_alias);
						break;
					case 'sitetype': 
						$result['res'] = url_menu_privilege('sitetype','SITE TYPES',$emp_alias);
						break;
					case 'accessories': 
						$result['res'] = url_menu_privilege('accessories','ACCESSORIES',$emp_alias);
						break;
					case 'milestone': 
						$result['res'] = url_menu_privilege('milestone','MILESTONES',$emp_alias);
						break;
					case 'esca': 
						$result['res'] = url_menu_privilege('esca','ESCA',$emp_alias);
						break;
					case 'dpr': 
						$result['res'] = url_menu_privilege('dpr','DPR CATEGORIES',$emp_alias);
						break;
					case 'shift': 
						$result['res'] = url_menu_privilege('shift','SHIFTS',$emp_alias);
						break;
					case 'moc': 
						$result['res'] = url_menu_privilege('moc','MOC',$emp_alias);
						break;
					case 'dynamiclevel': 
						$result['res'] = url_menu_privilege('dynamiclevel','DYNAMIC LEVELS',$emp_alias);
						break;
					case 'buckets': 
						$result['res'] = url_menu_privilege('buckets','BUCKETS',$emp_alias);
						break;
					case 'manuals': 
						$result['res'] = url_menu_privilege('manuals','MANUALS',$emp_alias);
						break;
					case 'workguide': 
						$result['res'] = url_menu_privilege('workguide','WORK GUIDES',$emp_alias);
						break;
					case 'changelog': 
						$result['res'] = url_menu_privilege('changelog','CHANGE LOG',$emp_alias);
						break;
					case 'allowances': 
						$result['res'] = url_menu_privilege('allowances','ALLOWANCES',$emp_alias);
						break;
					case 'approvers': 
						$result['res'] = url_menu_privilege('approvers','APPROVERS',$emp_alias);
						break;
					case 'limits': 
						$result['res'] = url_menu_privilege('limits','LIMITS',$emp_alias);
						break;
					default: $result['res']='401';
				}
			}
		}$resCode='0';$resMsg='Success!';
	}elseif($rex==1){ $resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function dashboard_url_menu_privilege($emp_alias){ global $mr_con;
	$privilege_alias = alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias');
	if(!empty($privilege_alias)){
		$sql_rows=mysqli_num_rows(mysqli_query($mr_con,"SELECT grantable FROM ec_privileges WHERE privilege_alias='$privilege_alias' AND privilege_item IN('CUSTOMER PULSE','TODAYS INFO REPORT BLOCK','TAT','MONTHLY ANALYSIS','NATURE OF ACTIVITY','FAULT ANALYSIS','PRODUCT CONTRIBUTION IN FAILURE','MANUFACTURE MONTH WISE FAILURE') AND privilege_type='VIEW' AND grantable='1' AND flag=0"));
		$res = $sql_rows > '0' ? '1' : '0';
	}else $res='0';
	return $res=='1' ? 'dashboard' : '401';
}
function url_menu_privilege($menu,$privilege_item,$emp_alias){ global $mr_con;
	$privilege_alias = alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias');
	if(!empty($privilege_alias)){
		$q = "SELECT grantable FROM ec_privileges WHERE privilege_alias='$privilege_alias' AND privilege_item='$privilege_item' AND privilege_type='VIEW' AND flag=0";
		$sql=mysqli_query($mr_con, $q);
		$row = mysqli_fetch_array($sql);
		$res = $row['grantable'];
	}else $res='0';
	if($res=='1') return $menu; else return 'dashboard';
}
function privilage_drop(){global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT privilege_name,privilege_alias FROM ec_privileges GROUP BY privilege_name");
	if(mysqli_num_rows($sql)>0){
		$i=0;while($row=mysqli_fetch_array($sql)){
		$result[$i]['name']=$row['privilege_name'];
		$result[$i]['alias']=$row['privilege_alias'];
		$i++;}
	}echo json_encode($result);
}
function accessory_desc_drop(){global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT accessory_description,accessories_alias,measurement FROM ec_accessories GROUP BY accessory_description");
	if(mysqli_num_rows($sql)>0){$i=0;
		while($row=mysqli_fetch_array($sql)){
			$result[$i]['name']=$row['accessory_description'];
			$result[$i]['alias']=$row['accessories_alias'];
			$result[$i]['measure']=$row['measurement']; $i++;
		}
	}echo json_encode($result);
}
function dynamiclevel_privilage_order_drop(){ global $mr_con;
	$x=mysqli_real_escape_string($mr_con,$_REQUEST['x']); $con="";
	$result['privilege']=$result['order']=$order=$privilege_alias=array();
	$sql=mysqli_query($mr_con,"SELECT privilege_alias,order_by FROM ec_dynamic_levels WHERE flag='0' ORDER BY order_by");
	$i=0;while($row=mysqli_fetch_array($sql)){$privilege_alias[$i]=$row['privilege_alias'];	$order[]=$row['order_by'];$i++;}
	foreach(array_unique($order) as $k=>$order_by)$result['order'][$k]['val']=$order_by;
	if($x!='edit'){
		if($x=='add'){$con="NOT";$result['order'][$k+1]['val']=(count($order)>'0' ? max($order) : 0)+1;}
		$sql1=mysqli_query($mr_con,"SELECT privilege_name,privilege_alias FROM ec_privileges WHERE privilege_item='MATERIAL REQUEST' AND privilege_type='SPECIAL' AND grantable='1' AND privilege_alias $con IN ('".implode("','",$privilege_alias)."') AND flag='0' GROUP BY privilege_alias");
		if(mysqli_num_rows($sql1)>0){
			$i=0;while($row=mysqli_fetch_array($sql1)){
				$result['privilege'][$i]['name']=$row['privilege_name'];
				$result['privilege'][$i]['alias']=$row['privilege_alias'];
			$i++;}
		}
	}echo json_encode($result);
}
function shift_drop(){echo all_drop_downs("shift_name","shift_alias","ec_shift");}
function event_dpr(){echo all_drop_downs("category","category_alias","ec_dpr_category");}
function zone_drop(){echo all_drop_downs("zone_name","zone_alias","ec_zone");}
function state_drop(){echo all_drop_downs("state_name","state_alias","ec_state");}
function district_drop(){echo all_drop_downs("district_name","district_alias","ec_district");}
function segment_drop(){echo all_drop_downs("segment_name","segment_alias","ec_segment");}
function asset_drop(){echo all_drop_downs("asset_name","asset_alias","ec_assets");}
function level_drop(){echo all_drop_downs("level_name","level_alias","ec_levels");}
function designation_drop(){echo all_drop_downs("designation","designation_alias","ec_designation");}
function department_drop(){echo all_drop_downs("department_name","department_alias","ec_department");}
function employeerole_drop(){echo all_drop_downs("role_name","role_alias","ec_emprole");}
function warehouse_drop(){echo all_drop_downs("wh_code","wh_alias","ec_warehouse");}
function cell_itemcode_drop(){echo all_drop_downs("item_code","product_alias","ec_product");}
function access_itemcode_drop(){echo all_drop_downs("item_code","accessories_alias","ec_accessories");}
//function accessory_desc_drop(){echo all_drop_downs("accessory_description","accessories_alias","ec_accessories");}
function product_desc_drop(){echo all_drop_downs("product_description","product_alias","ec_product");}
function product_battery_rating_drop(){echo all_drop_downs("battery_rating","product_alias","ec_product");}
//function privilage_drop(){echo all_drop_downs("privilege_name","privilege_alias","ec_privileges");}
function customer_drop(){
	echo all_drop_downs_no_flag_cond("customer_name","customer_alias","ec_customer");
}
function stock_code_drop(){echo all_drop_downs("description","stock_alias","ec_stock");}
function milestone_drop(){echo all_drop_downs("mile_stone","mile_stone_alais","ec_milestone");}
function esca_drop(){echo all_drop_downs("name","employee_alias","ec_employee_master");}
function esca_name_drop(){echo all_drop_downs("esca_name","esca_alias","ec_esca");}
function esca_service_drop(){echo all_drop_downs("esca_name","esca_alias","ec_esca");}
function zone_state_drop(){echo all_depDrop_downs("state_name","state_alias","ec_state","zone_alias",$_REQUEST['alias']);}
function state_district_drop(){echo all_depDrop_downs("district_name","district_alias","ec_district","state_alias",$_REQUEST['alias']);}
function activity_complaint_drop(){echo all_depDrop_downs("complaint_name","complaint_alias","ec_complaint","activity_alias",$_REQUEST['alias']);}
function activity_complaint_mul_drop(){echo all_mul_depDrop_downs("complaint_name","complaint_alias","ec_complaint","activity_alias",$_REQUEST['alias']);}
//function segment_cust_drop(){echo all_depDrop_downs("customer_code","customer_alias","ec_customer","segment_alias",$_REQUEST['alias']);}
//function segment_sitetype_drop(){echo all_depDrop_downs("site_type","site_type_alias","ec_site_type","segment_alias",$_REQUEST['alias']);}
function segment_cust_mul_drop(){echo all_mul_depDrop_downs("customer_code","customer_alias","ec_customer","segment_alias",$_REQUEST['alias']);}//Multiple drop downs
function zone_state_mul_drop(){echo all_mul_depDrop_downs("state_name","state_alias","ec_state","zone_alias",$_REQUEST['alias']);}//Multiple drop downs
function asset_mul_drop(){echo all_mul_depDrop_downs("asset_name","asset_name","ec_assets","asset_type",$_REQUEST['alias']);}
function asset_make_mul_drop(){echo all_mul_depDrop_downs("asset_make","asset_make","ec_assets","asset_name",$_REQUEST['alias']);}
function asset_sno_mul_drop(){echo all_mul_depDrop_downs("asset_serial_number","asset_alias","ec_assets","asset_make",$_REQUEST['alias']);}
function state_whcode_mul_drop(){echo all_mul_depDrop_downs("wh_code","wh_alias","ec_warehouse","state_alias",$_REQUEST['alias']);}
function dep_emp_drop(){echo all_depDrop_downs("name","employee_alias","ec_employee_master","department_alias",$_REQUEST['alias']);}

function site_warranty_check(){ global $mr_con;
	$site_alias=mysqli_real_escape_string($mr_con,$_REQUEST['alias']);
	echo json_encode(sitemanfdate_check($site_alias));
}

function segment_cust_drop(){ 
	global $mr_con;
	$segment_alias=mysqli_real_escape_string($mr_con,$_REQUEST['alias']);
	$seg_type=alias($segment_alias,'ec_segment','segment_alias','segment_type');
	$con=($seg_type!='1' ? "segment_alias='$segment_alias' AND" : "");
	$flag = "flag=0 ";
	if($_REQUEST['all'] == 1) {
		$flag = " flag in (0, 1)";
	}
	$sql=mysqli_query($mr_con,"SELECT customer_code,customer_alias FROM ec_customer WHERE $con $flag ORDER BY customer_code ASC");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['customer_alias'];$result[$i]['name']=$row['customer_code']; $i++;}
	}echo json_encode($result);
}
function segment_sitetype_drop(){ global $mr_con; $con=$grtp="";
	$segment_alias=mysqli_real_escape_string($mr_con,$_REQUEST['alias']);
	$seg_type=alias($segment_alias,'ec_segment','segment_alias','segment_type');
	if($seg_type!='1')$con="segment_alias='$segment_alias' AND";else $grtp="GROUP BY site_type";	 
	$sql=mysqli_query($mr_con,"SELECT site_type,site_type_alias FROM ec_site_type WHERE $con flag=0 $grtp");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['site_type_alias'];$result[$i]['name']=$row['site_type']; $i++;}
	}echo json_encode($result);
}
function other_seg(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT segment_name,segment_alias FROM ec_segment WHERE segment_type='1' AND flag=0");
	if(mysqli_num_rows($sql)){
		$row=mysqli_fetch_array($sql);
		$result['alias']=$row['segment_alias'];
		$result['name']=$row['segment_name'];
	}echo json_encode($result);
}
function role_employee_mul_drop_all(){ global $mr_con;
	$data=str_replace(", ",",",$_REQUEST['alias']);
	$arr="'".implode("','",explode(",",$data))."'";
	$sql=mysqli_query($mr_con,"SELECT name,employee_alias FROM ec_employee_master WHERE status<>'RELIEVED' AND role_alias IN ($arr) AND department_alias IN (SELECT department_alias FROM ec_department WHERE spl='3' AND flag='0') AND flag=0 ORDER BY name ASC");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['employee_alias'];$result[$i]['name']=$row['name']; $i++;}
	}//else{$result[0]['alias']='';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function ths_notified_emp(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT name,employee_alias FROM ec_employee_master WHERE status<>'RELIEVED' AND ths_notified ='1' AND flag=0 ORDER BY name ASC");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['employee_alias'];$result[$i]['name']=$row['name']; $i++;}
	}//else{$result[0]['alias']='';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function ticket_activity_mul(){echo all_drop_downs_mul_select("activity_name","activity_alias","ec_activity");}
function ticket_site_mul(){echo all_drop_downs_mul_select("site_id","site_alias","ec_sitemaster");}
function ticket_complaint_mul(){echo all_drop_downs_mul_select("complaint_name","complaint_alias","ec_complaint");}
function ticket_customer_mul(){echo all_drop_downs("customer_code","customer_alias","ec_customer");}
//function ticket_customer_mul(){echo all_customer_mul_select("customer_code","customer_alias","ec_customer");}
function ticket_level_mul(){echo all_drop_downs_mul_select("level_name","level_alias","ec_levels");}
function faulty_code_drop(){echo all_drop_downs("description","faulty_alias"," ec_faulty_code");}
function mulempdrop(){echo all_drop_downs("name","employee_alias"," ec_employee_master");}
function employeename_drop(){echo all_drop_downs("name","employee_alias","ec_employee_master");}
function esca_employeename_drop() {
	echo all_drop_downs("name","employee_alias","esca_employeename_drop");
}
function all_drop_downs_mul_select($name,$alias,$tb){ global $mr_con;
	$q=mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE flag=0");
	$activity_alias=array();
	while($r=mysqli_fetch_array($q)){
		$activity_alias[]=($alias=="level_alias" ? $r['level'] : $r[$alias]);
	}
	$imp= implode("|",array_unique($activity_alias));
	if(!empty($imp)){$con = "$alias RLIKE '$imp' AND";}else{$con = "";}
	$sql=mysqli_query($mr_con,"SELECT $name,$alias FROM $tb WHERE $con flag=0 ORDER BY $name ASC");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row[$alias];$result[$i]['name']=$row[$name]; $i++;}
	}//else{$result[0]['alias']='';$result[0]['name']='No Records Found';}
	return json_encode($result);
}
function all_customer_mul_select($name,$alias,$tb){ global $mr_con;
	$q=mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE flag=0");
	$customer_alias=array();
	while($r=mysqli_fetch_array($q)){
		$customer_alias[]=alias($r['site_alias'],'ec_sitemaster','site_alias','customer_alias');
	}
	$imp= implode("|",$customer_alias);
	if(!empty($imp)){$con = "$alias RLIKE '$imp' AND";}else{$con = "";}
	$sql=mysqli_query($mr_con,"SELECT $name,$alias FROM $tb WHERE $con flag=0 ORDER BY $name ASC");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row[$alias];$result[$i]['name']=$row[$name]; $i++;}
	}//else{$result[0]['alias']='';$result[0]['name']='No Records Found';}
	return json_encode($result);
}
function cust_product_mul_drop(){
	$product = alias($_REQUEST['alias'],'ec_customer','customer_alias','product_alias');
	$pro = explode(", ",$product);
	if(count($pro)){
		foreach($pro as $i=>$alias){
			$result[$i]['alias'] = $alias;
			$result[$i]['name'] = alias($alias,'ec_product','product_alias','product_description');
		}
	}//else{$result[0][$alias]='';$result[0][$name]='No Records Found';}
	echo json_encode($result);
}
function state_emp_drop() {
	global $mr_con;
	$state_alias = $_REQUEST['alias'];
	$all = $_REQUEST['all'];
	$con = "";
	if(!empty($state_alias)){
		$con = "state_alias RLIKE '$state_alias' AND ";
	}
	$query = "SELECT name, employee_alias, flag FROM ec_employee_master WHERE $con";
	if($all == 1) {
		$query .= " flag >= 0";
	} else {
		$query .= " flag=0";
	}
	$sql = mysqli_query($mr_con, $query);
	if(mysqli_num_rows($sql)) {
		$i=0;
		while($row=mysqli_fetch_array($sql)){ 
			$result[$i]['alias']=$row['employee_alias'];
			$result[$i]['name']=$row['name']; 
			$result[$i]['disable']=$row['flag'] == 0 ? false : true; 
			$i++;
		}
	}
	echo json_encode($result);
}
function zone_mul_drop_export(){ global $mr_con;
	$emp_alias = $_COOKIE['emp_alias'];
	$id = alias($emp_alias,'ec_employee_master','employee_alias','id');
	if(strtoupper($emp_alias)=='ADMIN' || empty($id) || $id=="NA"){$emp='';}
	else{
		$zone_alias = alias($emp_alias,'ec_employee_master','employee_alias','zone_alias');
		$s=mysqli_query($mr_con,"SELECT zone_alias FROM ec_employee_master WHERE employee_alias='$emp_alias' AND flag=0");
		$row=mysqli_fetch_array($s);
		$zone_alias=$row['zone_alias'];
		$arr="'".implode("','",explode(", ",$zone_alias))."'";
		$emp="zone_alias IN ($arr) AND";
	}
	$sql=mysqli_query($mr_con,"SELECT zone_name,zone_alias FROM ec_zone WHERE $emp flag=0");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['zone_alias'];$result[$i]['name']=$row['zone_name']; $i++;}
	}//else{$result[0]['zone_alias']='';$result[0]['zone_name']='No Records Found';}
	echo json_encode($result);
}
function zone_state_mul_drop_export(){global $mr_con;
	$emp_alias = $_COOKIE['emp_alias'];
	$id = alias($emp_alias,'ec_employee_master','employee_alias','id');
	if(strtoupper($emp_alias)=='ADMIN' || empty($id) || $id=="NA"){
		$alias="'".implode("','",explode(",",$_REQUEST['alias']))."'";
		$emp="zone_alias IN ($alias) AND";
	}else{
		/*$s=mysqli_query($mr_con,"SELECT zone_alias FROM ec_employee_master WHERE employee_alias='$emp_alias' AND flag=0");echo "SELECT zone_alias FROM ec_employee_master WHERE employee_alias='$emp_alias' AND flag=0";
		$row=mysqli_fetch_array($s);
		$zone_alias=$row['zone_alias'];*/
		$zone_alias = alias($emp_alias,'ec_employee_master','employee_alias','zone_alias');
		$state_alias = alias($emp_alias,'ec_employee_master','employee_alias','state_alias');
		$zarr="'".implode("','",explode(", ",$zone_alias))."'";
		$sarr="'".implode("','",explode(", ",$state_alias))."'";
		$emp="zone_alias IN ($zarr) AND state_alias IN($sarr) AND";
	}
	$sql=mysqli_query($mr_con,"SELECT state_name,state_alias FROM ec_state WHERE ".$emp." flag=0");	
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['state_alias'];$result[$i]['name']=$row['state_name']; $i++;}
	}//else{$result[0]['alias']='';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function zone_state_district_mul_dropexport(){ global $mr_con;
	$emp_alias = $_COOKIE['emp_alias'];
	if(strtoupper($emp_alias)=='ADMIN'){
		$alias="'".implode("','",explode(",",$_REQUEST['alias']))."'";
		$emp="state_alias IN ($alias) AND";
	}else{
		//$zone_alias = alias($emp_alias,'ec_employee_master','employee_alias','zone_alias');
		//$state_alias = alias($emp_alias,'ec_employee_master','employee_alias','state_alias');
		$district_alias=alias($state_alias,'ec_district','state_alias','district_alias');
		$zarr="'".implode("','",explode(", ",$zone_alias))."'";
		$sarr="'".implode("','",explode(", ",$state_alias))."'";
		$darr="'".implode("','",explode(", ",$district_alias))."'";
		$emp="state_alias IN ($sarr) AND $district_alias IN($darr) AND";
	}
	$sql=mysqli_query($mr_con,"SELECT state_alias,district_name,district_alias FROM ec_district WHERE ".$emp." flag=0");	
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['state_alias']=$row['state_alias'];$result[$i]['alias']=$row['district_alias'];$result[$i]['name']=$row['district_name']; $i++;}
	}//else{$result[0]['alias']='';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function zone_ware_mul_drop_export(){global $mr_con;
	$emp_alias = strtoupper($_COOKIE['emp_alias']); $con="";
	$zone_alias=mysqli_real_escape_string($mr_con,$_REQUEST['alias']);
	$id = alias($emp_alias,'ec_employee_master','employee_alias','id');
	if(!empty($zone_alias)){$con="zone_alias IN ('".str_replace(",","','",$zone_alias)."') AND";}
	else{
		if($emp_alias!='ADMIN'){ $con="zone_alias IN ('".str_replace(", ","','",alias($emp_alias,'ec_employee_master','employee_alias','zone_alias'))."') AND";}
	}
	$sql=mysqli_query($mr_con,"SELECT wh_address,wh_alias FROM ec_warehouse WHERE $con flag=0");	
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['wh_alias'];$result[$i]['name']=$row['wh_address']; $i++;}
	}//else{$result[0]['alias']='';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function assets_emp_mul_drop(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT asset_alias FROM ec_employee_master WHERE flag=0");
	while($row=mysqli_fetch_array($sql)){ $as .=$row['asset_alias'].", "; }
		$as = rtrim($as,", ");
		$ass=array_unique(explode(", ",$as));
		if(count($ass)){
			foreach($ass as $i=>$alias){
				$result[$i]['name']=alias($alias,'ec_assets','asset_alias','asset_name');
				$result[$i]['alias']=$alias;
			}
		}//else{$result[0]['alias']='';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function site_prod_mul_drop(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT product_alias FROM ec_sitemaster WHERE flag=0");
	while($row=mysqli_fetch_array($sql)){ $as .=$row['product_alias'].", "; }
	$as = rtrim($as,", ");
	$em=array_unique(explode(", ",$as));
	if(count($em)){
		foreach($em as $i=>$alias){
			$result[$i]['name']=alias($alias,'ec_product','product_alias','product_description');
			$result[$i]['alias']=$alias;
		}
	}//else{$result[0]['alias']='';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function employee_list_drop(){ global $mr_con; //echo all_drop_downs("name","employee_alias"," ec_employee_master");
	$sql=mysqli_query($mr_con,"SELECT name,employee_alias FROM ec_employee_master WHERE (device<>0 OR device_2<>0) AND flag=0");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['employee_alias'];$result[$i]['name']=$row['name']; $i++;}
	}//else{$result[0][$alias]='';$result[0][$name]='No Records Found';}
	echo json_encode($result);
}
function moc_drop(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT * FROM ec_moc WHERE moc_type='0' AND flag=0 ORDER BY moc_name ASC");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){
			$result[$i]['alias']=$row['moc_alias'];
			$result[$i]['name']=$row['moc_name'];
			$result[$i]['file']=$row['moc_file'];
			$result[$i]['text']=$row['moc_text'];
	 	$i++;}
	}
	echo json_encode($result);
}
function activity_code_drop(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT * FROM ec_activity WHERE flag=0 ORDER BY activity_name ASC");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){
			$result[$i]['alias']=$row['activity_alias'];
			$result[$i]['name']=$row['activity_code'];
			$result[$i]['type']=$row['activity_type'];
	 	$i++;}
	}
	echo json_encode($result);
}
function activity_drop(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT * FROM ec_activity WHERE flag=0 ORDER BY id ASC");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){
			$result[$i]['alias']=$row['activity_alias'];
			$result[$i]['name']=$row['activity_name'];
			$result[$i]['type']=$row['activity_type'];
	 	$i++;}
	}
	echo json_encode($result);
}
function all_drop_downs_no_flag_cond($name,$alias,$tb){ 
	global $mr_con;
	$query = "SELECT $name,$alias FROM $tb ORDER BY $name ASC";
	$sql=mysqli_query($mr_con, $query);
	$result = [];
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ 
			$result[$i]['alias']=$row[$alias];
			$result[$i]['name']=$row[$name]; 
			$i++;
		}
	}
	return json_encode($result);
}
function all_drop_downs($name,$alias,$tb){ 
	global $mr_con;
	$query = "SELECT $name,$alias FROM $tb WHERE flag=0 ORDER BY $name ASC";
	if($tb == "esca_employeename_drop") {
		$query = "SELECT $name, $alias FROM ec_employee_master WHERE flag=0 AND role_alias = '01ZMYJ4OLG' ORDER BY $name ASC";
	}
	$sql=mysqli_query($mr_con, $query);
	$result = [];
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row[$alias];$result[$i]['name']=$row[$name]; $i++;}
	}//else{$result[0][$alias]='';$result[0][$name]='No Records Found';}
	return json_encode($result);
}
function stockexp_drop_downs(){ global $mr_con;
	if($_REQUEST['em_alias']=='admin' || $_REQUEST['em_alias']=='ADMIN' || $_REQUEST['em_alias']=='eadmin' || $_REQUEST['em_alias']=='EADMIN'){
		$emp_alias=$_REQUEST['em_alias'];
	}else{$emp_alias=alias($_REQUEST['em_alias'],'ec_employee_master','employee_alias','privilege_alias');}
	$result['emp_alias']=$emp_alias;
	echo json_encode($result);
}
function all_depDrop_downs($name,$alias,$tb,$check,$data){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT $name,$alias FROM $tb WHERE $check='$data' AND flag=0 ORDER BY $name ASC");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row[$alias];$result[$i]['name']=$row[$name]; $i++;}
	}//else{$result[0][$alias]='';$result[0][$name]='No Records Found';}
	return json_encode($result);
}
function all_mul_depDrop_downs($name,$alias,$tb,$check,$data){ global $mr_con;
	$data=str_replace(", ",",",$data);
	$arr="'".implode("','",explode(",",$data))."'";
	$sql=mysqli_query($mr_con,"SELECT $name,$alias FROM $tb WHERE $check IN ($arr) AND flag=0 ORDER BY $name ASC");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row[$alias];$result[$i]['name']=$row[$name]; $i++;}
	}//else{$result[0]['alias']='';$result[0]['name']='No Records Found';}
	return json_encode($result);
}
function role_employee_mul_drop(){ global $mr_con;
	$data=str_replace(", ",",",$_REQUEST['alias']);
	$arr="'".implode("','",explode(",",$data))."'";
	$sql=mysqli_query($mr_con,"SELECT name,employee_alias FROM ec_employee_master WHERE role_alias IN ($arr) AND (device<>0 OR device_2<>0) AND flag=0 ORDER BY name ASC");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['employee_alias'];$result[$i]['name']=$row['name']; $i++;}
	}//else{$result[0]['alias']='';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function general_emprole_drop_downs(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT role_name,role_alias FROM ec_emprole WHERE flag=0 ORDER BY role_name ASC");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['role_alias'];$result[$i]['name']=$row['role_name']; $i++;}
	}//else{$result[0]['role_alias']='';$result[0]['role_name']='No Records Found';}
	echo json_encode($result);
}
function warehouse_emp_drop(){global $mr_con;
	$fv1 = mysqli_real_escape_string($mr_con,$_REQUEST['alias']);
	$sql=mysqli_query($mr_con,"SELECT wh_code,wh_alias FROM ec_warehouse WHERE wh_alias IN (".getempwarehouse($fv1).") AND flag=0 ORDER BY wh_code ASC");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['wh_alias'];$result[$i]['name']=$row['wh_code']; $i++;}
	}//else{$result[0][$alias]='';$result[0][$name]='No Records Found';}
	echo json_encode($result);
}
function general_emprole_emplist_drop_downs(){ global $mr_con;
	$role_alias = $_REQUEST['alias'];
	$emp_alias = $_COOKIE['emp_alias'];
	if(strtoupper($emp_alias)=='ADMIN'){$emp=''; $state_alias='1';}
	else{
		$s=mysqli_query($mr_con,"SELECT state_alias FROM ec_employee_master WHERE employee_alias='$emp_alias' AND flag=0");
		$rs=mysqli_fetch_array($s);
		$state_alias=$rs['state_alias'];
		if(!empty($state_alias)){$emp="state_alias RLIKE '".str_replace(", ","|",$state_alias)."' AND";}
		else{$emp=''; $state_alias='';}
	}
	$sql=mysqli_query($mr_con,"SELECT name,employee_alias FROM ec_employee_master WHERE role_alias='$role_alias' AND $emp status<>'RELIEVED' AND flag=0 ORDER BY name ASC");
	if(mysqli_num_rows($sql) && !empty($state_alias)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['employee_alias'];$result[$i]['name']=$row['name']; $i++;}
	}//else{$result[0]['employee_alias']='';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function requested_cells_drop(){ global $mr_con;
	$ticket_alias=$_REQUEST['alias']; $result=array();
	$sql = mysqli_query($mr_con,"SELECT COUNT(id) AS cnt,GROUP_CONCAT('''',alias,'''') AS out_ali FROM ec_material_outward WHERE ref_no='$ticket_alias' AND from_type='1' AND to_wh<>'2609' AND flag='0'");
	$row=mysqli_fetch_array($sql);
	if($row['cnt']){
		$sql1 = mysqli_query($mr_con,"SELECT COUNT(id) AS cnt,GROUP_CONCAT('''',item_description,'''') AS item_code FROM ec_material_sent_details WHERE reference IN(".$row['out_ali'].") AND flag='0'");
		$row1=mysqli_fetch_array($sql1);
		if($row1['cnt']){
			$sql2 = mysqli_query($mr_con,"SELECT COUNT(id) AS cnt,GROUP_CONCAT(item_code_alias) AS item_cod,GROUP_CONCAT(item_description) AS item_desc FROM ec_item_code WHERE item_code_alias IN(".$row1['item_code'].") AND flag='0'");
			$row2=mysqli_fetch_array($sql2);
			if($row2['cnt']){
				$item_cod=explode(",",$row2['item_cod']);
				$item_desc=explode(",",$row2['item_desc']);
				$combo_arr=array_combine($item_cod,$item_desc);
				$i=0;foreach($combo_arr as $cod=>$desc){$result[$i]['alias']=$cod;$result[$i]['name']=$desc;$i++;}
			}
		}
	}echo json_encode($result);
}
function req_cells_drop(){ global $mr_con;
	$ticket_alias=$_REQUEST['alias'];
	$site_alias = alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
	$product_alias = alias($site_alias,'ec_sitemaster','site_alias','product_alias');
	$con  = implode("','",explode(", ",$product_alias));
	$sql=mysqli_query($mr_con,"SELECT battery_rating,product_alias FROM ec_product WHERE product_alias IN ('$con') AND flag=0 ORDER BY battery_rating ASC");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['product_alias'];$result[$i]['name']=$row['battery_rating']; $i++;}
	}//else{$result[0]['alias']='';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function req_acc_drop(){ global $mr_con;
	$ticket_alias=$_REQUEST['alias'];
	$site_alias = alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
	$product_alias = alias($site_alias,'ec_sitemaster','site_alias','product_alias');
	$con  = implode("','",explode(", ",$product_alias));
	$sql=mysqli_query($mr_con,"SELECT accessory_description,accessories_alias FROM ec_accessories WHERE product_alias IN ('$con') AND flag=0 ORDER BY accessory_description ASC");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['accessories_alias'];$result[$i]['name']=$row['accessory_description']; $i++;}
	}//else{$result[0]['alias']='';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function settings_count(){ 
	global $mr_con;
	$emp_alias = $_REQUEST['emp_alias'];

	$result['accessories_add'] = grantable('ADD', 'ACCESSORIES', $emp_alias);
	$result['activity_add'] = false;
	$result['allowances_add'] = grantable('ADD', 'ALLOWANCES', $emp_alias);
	$result['approvers_add'] = grantable('ADD', 'APPROVERS', $emp_alias);
	$result['assets_add'] = grantable('ADD', 'ASSETS', $emp_alias);
	$result['bucket_add'] = grantable('ADD', 'BUCKETS', $emp_alias);
	$result['changelog_add'] = grantable('ADD', 'CHANGE LOG', $emp_alias);
	$result['complaint_add']  = grantable('ADD', 'COMPLAINTS', $emp_alias);
	$result['customer_add'] = grantable('ADD', 'CUSTOMERS', $emp_alias);
	// $result['contractprice_add'] = grantable('ADD', 'ACCESSORIES', $emp_alias);
	$result['department_add'] = grantable('ADD', 'DEPARTMENTS', $emp_alias);
	$result['designation_add'] = grantable('ADD', 'DESIGNATIONS', $emp_alias);
	$result['district_add'] = grantable('ADD', 'DISTRICTS', $emp_alias);
	$result['dpr_add'] = grantable('ADD', 'DPR CATEGORIES', $emp_alias);
	$result['dropdown_add'] = grantable('ADD', 'DROPDOWNS', $emp_alias);
	$result['dynamic_level_add'] = grantable('ADD', 'DYNAMIC LEVELS', $emp_alias);
	$result['emprole_add'] = grantable('ADD', 'EMPLOYEE ROLES', $emp_alias);
	$result['esca_add'] = grantable('ADD', 'ESCA', $emp_alias);
	$result['faulty_add'] = grantable('ADD', 'FAULTY CODES', $emp_alias);
	// $result['items_add'] = grantable('ADD', 'ACCESSORIES', $emp_alias);
	$result['levels_add'] = grantable('ADD', 'LEVELS', $emp_alias);
	$result['limits_add'] = grantable('ADD', 'LIMITS', $emp_alias);
	$result['manuals_add'] = grantable('ADD', 'MANUALS', $emp_alias);
	$result['milestone_add'] = grantable('ADD', 'MILESTONES', $emp_alias);
	$result['moc_add'] = grantable('ADD', 'MOC', $emp_alias);
	// $result['others_add'] = grantable('ADD', 'ACCESSORIES', $emp_alias);
	$result['product_add'] = grantable('ADD', 'PRODUCTS', $emp_alias);
	$result['privileges_add'] = grantable('ADD', 'PRIVILEGES', $emp_alias);
	$result['segment_add'] = grantable('ADD', 'SEGMENTS', $emp_alias);
	// $result['services_add'] = grantable('ADD', 'ACCESSORIES', $emp_alias);
	$result['sitetype_add'] = grantable('ADD', 'SITE TYPES', $emp_alias);
	// $result['sitestatus_add'] = grantable('ADD', 'ACCESSORIES', $emp_alias);
	$result['shift_add'] = grantable('ADD', 'SHIFTS', $emp_alias);
	$result['state_add'] = grantable('ADD', 'STATES', $emp_alias);
	$result['stock_add'] = grantable('ADD', 'STOCK CODES', $emp_alias);
	// $result['tree_add'] = grantable('ADD', 'ACCESSORIES', $emp_alias);
	$result['warehouse_add'] = grantable('ADD', 'WAREHOUSES', $emp_alias);
	$result['work_guide_add'] = grantable('ADD', 'WORK GUIDES', $emp_alias);
	$result['zone_add'] = grantable('ADD', 'ZONES', $emp_alias);

	$result['privacy_edit'] = grantable('EDIT', 'PRIVACY POLICY', $emp_alias);

	$result['accessories_view'] = grantable('VIEW', 'ACCESSORIES', $emp_alias);
	$result['activity_view'] = grantable('VIEW', 'ACTIVITIES', $emp_alias);
	$result['allowances_view'] = grantable('VIEW', 'ALLOWANCES', $emp_alias);
	$result['approvers_view'] = grantable('VIEW', 'APPROVERS', $emp_alias);
	$result['assets_view'] = grantable('VIEW', 'ASSETS', $emp_alias);
	$result['bucket_view'] = grantable('VIEW', 'BUCKETS', $emp_alias);
	$result['changelog_view'] = grantable('VIEW', 'CHANGE LOG', $emp_alias);
	$result['complaint_view']  = grantable('VIEW', 'COMPLAINTS', $emp_alias);
	$result['customer_view'] = grantable('VIEW', 'CUSTOMERS', $emp_alias);
	// $result['contractprice_view'] = grantable('VIEW', 'ACCESSORIES', $emp_alias);
	$result['department_view'] = grantable('VIEW', 'DEPARTMENTS', $emp_alias);
	$result['designation_view'] = grantable('VIEW', 'DESIGNATIONS', $emp_alias);
	$result['district_view'] = grantable('VIEW', 'DISTRICTS', $emp_alias);
	$result['dpr_view'] = grantable('VIEW', 'DPR CATEGORIES', $emp_alias);
	$result['dropdown_view'] = grantable('VIEW', 'DROPDOWNS', $emp_alias);
	$result['dynamic_level_view'] = grantable('VIEW', 'DYNAMIC LEVELS', $emp_alias);
	$result['email_sms_view'] = grantable('VIEW', 'EMAIL & SMS RECIPIENT', $emp_alias);
	$result['emprole_view'] = grantable('VIEW', 'EMPLOYEE ROLES', $emp_alias);
	$result['esca_view'] = grantable('VIEW', 'ESCA', $emp_alias);
	$result['faulty_view'] = grantable('VIEW', 'FAULTY CODES', $emp_alias);
	// $result['items_view'] = grantable('VIEW', 'ACCESSORIES', $emp_alias);
	$result['levels_view'] = grantable('VIEW', 'LEVELS', $emp_alias);
	$result['limits_view'] = grantable('VIEW', 'LIMITS', $emp_alias);
	$result['manuals_view'] = grantable('VIEW', 'MANUALS', $emp_alias);
	$result['milestone_view'] = grantable('VIEW', 'MILESTONES', $emp_alias);
	$result['moc_view'] = grantable('VIEW', 'MOC', $emp_alias);
	// $result['others_view'] = grantable('VIEW', 'ACCESSORIES', $emp_alias);
	$result['product_view'] = grantable('VIEW', 'PRODUCTS', $emp_alias);
	$result['privacy_view'] = grantable('VIEW', 'PRIVACY POLICY', $emp_alias);
	$result['privileges_view'] = grantable('VIEW', 'PRIVILEGES', $emp_alias);
	$result['segment_view'] = grantable('VIEW', 'SEGMENTS', $emp_alias);
	// $result['services_view'] = grantable('VIEW', 'ACCESSORIES', $emp_alias);
	$result['sitetype_view'] = grantable('VIEW', 'SITE TYPES', $emp_alias);
	// $result['sitestatus_view'] = grantable('VIEW', 'ACCESSORIES', $emp_alias);
	$result['shift_view'] = grantable('VIEW', 'SHIFTS', $emp_alias);
	$result['state_view'] = grantable('VIEW', 'STATES', $emp_alias);
	$result['stock_view'] = grantable('VIEW', 'STOCK CODES', $emp_alias);
	// $result['tree_view'] = grantable('VIEW', 'ACCESSORIES', $emp_alias);
	$result['warehouse_view'] = grantable('VIEW', 'WAREHOUSES', $emp_alias);
	$result['work_guide_view'] = grantable('VIEW', 'WORK GUIDES', $emp_alias);
	$result['zone_view'] = grantable('VIEW', 'ZONES', $emp_alias);

	$result['accessories_count']=sub_settings_count('ec_accessories');
	$result['activity_count']=sub_settings_count('ec_activity');
	$result['assets_count']=sub_settings_count('ec_assets');
	$result['items_count']=sub_settings_count('ec_item_code');
	$result['complaint_count']=sub_settings_count('ec_complaint');
	$result['customer_count']=sub_settings_count('ec_customer');
	$result['contractprice_count']=sub_settings_count('ec_contract_price');
	$result['department_count']=sub_settings_count('ec_department');
	$result['designation_count']=sub_settings_count('ec_designation');
	$result['district_count']=sub_settings_count('ec_district');
	$result['dpr_count']=sub_settings_count('ec_dpr_category');
	$result['email_sms_count']=sub_settings_count('ec_email_sms_settings');
	$result['emprole_count']=sub_settings_count('ec_emprole');
	$result['esca_count']=sub_settings_count('ec_esca');
	$result['faulty_count']=sub_settings_count('ec_faulty_code');
	$result['milestone_count']=sub_settings_count('ec_milestone');
	$result['levels_count']=sub_settings_count('ec_levels');
	$result['product_count']=sub_settings_count('ec_product');
	$result['privileges_count']=sub_settings_privilege_count('ec_privileges');
	$result['segment_count']=sub_settings_count('ec_segment');
	$result['sitetype_count']=sub_settings_count('ec_site_type');
	$result['sitestatus_count']=sub_settings_count('ec_site_status');
	$result['state_count']=sub_settings_count('ec_state');
	$result['stock_count']=sub_settings_count('ec_stock');
	$result['warehouse_count']=sub_settings_count('ec_warehouse');
	$result['zone_count']=sub_settings_count('ec_zone');
	$result['shift_count']=sub_settings_count('ec_shift');
	$result['moc_count']=sub_settings_count('ec_moc');
	$result['dynamic_level_count']=sub_settings_count('ec_dynamic_levels');
	$result['bucket_count']=sub_settings_count('ec_remarks_bucket');
	$result['tree_count']=sub_settings_count('ec_app_menu_items');
	$result['manuals_count']=sub_settings_count('ec_app_manuals');
	$result['changelog_count']=sub_settings_count('ec_app_change_log');
	
	$sql1=mysqli_query($mr_con,"SELECT id FROM ec_app_work_guide WHERE ref_id='0' AND flag=0");
	$result['work_guide_count']=mysqli_num_rows($sql1);

	//expense
	$result['services_count']=sub_settings_count('ec_service_allowances');
	$result['others_count']=sub_settings_count('ec_daily_allowances');
	$result['approvers_count']=sub_settings_count('ec_expense_approvals');
	$result['limits_count']=sub_settings_count('ec_expense_limits');
	echo json_encode($result);
}
function sub_settings_count($tbl){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT id FROM $tbl WHERE flag=0");
	return mysqli_num_rows($sql);
}
function sub_settings_privilege_count($tbl){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT id FROM $tbl WHERE flag=0 GROUP BY privilege_name");
	return mysqli_num_rows($sql);
}
function employeeWh(){ global $mr_con;
	$state=alias($_REQUEST['alias'],'ec_employee_master','employee_alias','state_alias');
	$sql=mysqli_query($mr_con,"SELECT wh_code FROM ec_warehouse WHERE state_alias='$state' AND flag=0");
	if(mysqli_num_rows($sql)){
		$row=mysqli_fetch_array($sql);
		$result['name']=$row['wh_code'];
	}//else{$result['name']='No Records Found';}
	echo json_encode($result);
}
function whonlyclose(){ global $mr_con;
	$state=alias($_REQUEST['x'],'ec_employee_master','employee_alias','state_alias');
	$sql=mysqli_query($mr_con,"SELECT mrf_number, mrf_alias FROM ec_material_request WHERE to_wh =(SELECT wh_alias FROM ec_warehouse WHERE state_alias='$state' AND flag=0 LIMIT 1) AND flag=0 AND status!='4' ");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['mrf_alias'];$result[$i]['name']=$row['mrf_number']; $i++;}
	}//else{$result[0]['alias']='';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function scrapcellsget(){
	global $mr_con;
	$from_wh=$_REQUEST['from_wh'];
	$sql=mysqli_query($mr_con,"SELECT cell_alias,item_code FROM ec_total_cell WHERE location ='$from_wh' AND condition_id IN ('3','4') AND flag=0");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){
			$result1['srapi'][$i]['alias']=$row['cell_alias'];
			$result1['srapi'][$i]['Productname']=alias($row['item_code'],'ec_product','product_alias','product_description'); 
			$result1['srapi'][$i]['name']=alias($row['cell_alias'],'ec_item_code','item_code_alias','item_description'); 
		$i++;}
	}else{$result1[0]['alias']='4';$result1[0]['name']='No Records Found';}
	echo json_encode($result1);
}
function sjolist(){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT sjo_no,item_code_alias FROM ec_item_code WHERE stat=0 AND flag=0 GROUP BY sjo_no");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['item_code_alias'];$result[$i]['name']=$row['sjo_no']; $i++;}
	}else{$result[0][$alias]='4';$result[0][$name]='No Records Found';}
	echo json_encode($result);
}
function mrf_drop(){
	global $mr_con;
	$emp_alias=$_REQUEST['x'];
	$emp_wh=getempwarehouse($emp_alias);
	$sql=mysqli_query($mr_con,"SELECT mrf_number,mrf_alias FROM ec_material_request WHERE from_wh='$emp_wh' AND to_wh='".$_REQUEST['alias']."' AND status='7' AND flag=0");
	if(mysqli_num_rows($sql)){$i=0;
		while($row=mysqli_fetch_array($sql)){ 
			$result[$i]['alias']=$row['mrf_alias'];
			$result[$i]['name']=$row['mrf_number'];
			$i++;
		}
	}else{$result[0]['alias']='4';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function del_remark_reqcell(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		list($alias,$tbl,$alias_tb) = explode(',',$_REQUEST['alias']);
		$sqlTT = mysqli_query($mr_con,"DELETE FROM $tbl WHERE $alias_tb ='".$alias."' AND flag=0");
		if($sqlTT){$resCode='0'; $resMsg='Successfully Deleted';}else{$resCode='4'; $resMsg='Not Deleted';}
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}//expense
function exp_zone_drop(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT zone_name,zone_alias FROM ec_zone WHERE flag=0");	
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['zone_alias'];$result[$i]['name']=$row['zone_name']; $i++;}
	}
	echo json_encode($result);
}
function exp_state_drop(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT state_name,state_alias FROM ec_state WHERE zone_alias = '".$_REQUEST['alias']."' AND flag=0");	
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['state_alias'];$result[$i]['name']=$row['state_name']; $i++;}
	}
	echo json_encode($result);
	
}
function exp_district_drop(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT district_name,district_alias FROM ec_district WHERE state_alias = '".$_REQUEST['alias']."' AND flag=0");	
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['district_alias'];$result[$i]['name']=$row['district_name']; $i++;}
	}
	echo json_encode($result);
	
}
function exp_azone_drop(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT zone_name,zone_alias FROM ec_zone WHERE flag=0");	
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['zone_alias'];$result[$i]['name']=$row['zone_name']; $i++;}
	}
	echo json_encode($result);
}
function exp_astate_drop(){ global $mr_con;
	$zone_alias=str_replace(",","','",$_REQUEST['alias']);
	$sql=mysqli_query($mr_con,"SELECT state_name,state_alias FROM ec_state WHERE zone_alias IN ('$zone_alias') AND flag=0");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['state_alias'];$result[$i]['name']=$row['state_name']; $i++;}
	}
	echo json_encode($result);
}
function exp_adistrict_drop(){ global $mr_con;
	$state_alias=str_replace(",","','",$_REQUEST['alias']);
	$s=mysqli_query($mr_con,"SELECT district_alias FROM ec_service_allowances WHERE flag=0");
	while($s_row=mysqli_fetch_array($s)){$district_alias[]=$s_row['district_alias'];}
	if($district_alias!=""){
	foreach($district_alias as $d){$dd.=$d.",";}$diss=trim($dd,",");$gg=str_replace(",","','",$diss);
	$sql=mysqli_query($mr_con,"SELECT district_name,district_alias FROM ec_district WHERE state_alias IN ('$state_alias') AND district_alias NOT IN ('$gg') AND flag=0");
	//echo "SELECT district_name,district_alias FROM ec_district WHERE state_alias IN ('$state_alias') AND district_alias NOT IN ('$gg') AND flag=0";
	}else{
	$sql=mysqli_query($mr_con,"SELECT district_name,district_alias FROM ec_district WHERE state_alias IN ('$state_alias') AND flag=0");
	}
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['district_alias'];$result[$i]['name']=$row['district_name']; $i++;}
	}
	echo json_encode($result);
}
function district_area_drop(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT area FROM ec_district WHERE district_alias='".$_REQUEST['alias']."' AND flag=0");
	if(mysqli_num_rows($sql)){
		$row=mysqli_fetch_array($sql);
		$result['area']=($row['area']=='0' ? 'Plain Area' : 'Hilly Area');
		$result['ammount_appl']=($row['area']=='0' ? '0.02' : '0.04');
	}//else{$result[0][$alias]='';$result[0][$name]='No Records Found';}
	echo json_encode($result);
}
function grade_drop(){ global $mr_con;
	$rec=$mr_con->query("SELECT grade FROM ec_designation WHERE flag=0 GROUP BY grade ORDER BY grade");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('grade_name'=>$row['grade']);}
	}else $result[0]['grade_name']='No Records Found';
	echo json_encode($result);
}
function gradedesg(){global $mr_con;
	$gradedesg=$_REQUEST['alias'];
	$rec=$mr_con->query("SELECT designation FROM ec_designation WHERE grade='$gradedesg' AND flag=0 ORDER BY designation");
	if($rec->num_rows>0){$res="";
		while($row = $rec->fetch_assoc()){
			$res.=$row['designation'].", ";
		}$result['designation']=rtrim($res,", ");
		echo json_encode($result);
	}
}
function exlevels_drop(){ global $mr_con;
	$emp_alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	if(($emp_alias!='ADMIN') && ($emp_alias!='EADMIN')){
		$rec=mysqli_query($mr_con,"SELECT level_name,level_alias FROM ec_expense_level WHERE flag=0 ORDER BY level_alias");
	}else{
		$rec=mysqli_query($mr_con,"SELECT level_name,level_alias FROM ec_expense_level WHERE level_alias <> '0' AND flag=0 ORDER BY level_alias");
		
	}
	//$rec=$mr_con->query("SELECT level_name,level_alias FROM ec_expense_level WHERE flag=0 ORDER BY level_alias");
	if(mysqli_num_rows($rec)>0){
	while($row = mysqli_fetch_assoc($rec)){$result[]=array('name'=>$row['level_name'],'alias'=>$row['level_alias']);}
	echo json_encode($result);
	}
}
function getTicket(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT ticket_id,ticket_alias FROM ec_tickets WHERE flag=0 AND service_engineer_alias = '".$_REQUEST['emp_alias']."'");	
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['name']=$row['ticket_id'];$result[$i]['alias']=$row['ticket_alias']; $i++;}
	}
	echo json_encode($result);	
}
function admnexlevels_drop(){ global $mr_con;
	$rec=$mr_con->query("SELECT level_name,level_alias FROM ec_expense_level WHERE level_alias!='0' AND flag=0 ORDER BY level_alias");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('name'=>$row['level_name'],'alias'=>$row['level_alias']);}
	echo json_encode($result);
	}
}
function exp_emp_drop(){ global $mr_con;
	$emp_alias=$_REQUEST['emp_alias'];
	if($emp_alias=='eadmin' || $emp_alias=='admin'){
		$empDgn=empdrop();
		foreach($empDgn as $i => $rec){ $result[$i]['alias']=$rec['alias'];$result[$i]['name']=$rec['name'];}
	}else{
		$get_appr = mysqli_query($mr_con,"SELECT * from ec_expense_approvals where approver = '$emp_alias'");
		$get_cnt = mysqli_num_rows($get_appr);
		if($get_cnt > 0){
			$get_lev = mysqli_query($mr_con,"SELECT GROUP_CONCAT(DISTINCT approval_level) AS approval_level FROM ec_expense_approvals where approver = '$emp_alias'");
			$get_lev_rs = mysqli_fetch_array($get_lev);
			$appr_list = explode(',',$get_lev_rs['approval_level']);
			
			$all_levels =  array('2','3','5');
			$arr_inter = array_intersect($appr_list,$all_levels);
			$arr_inter_cnt = count($arr_inter);
			
			$result['draft_alias']=$emp_alias;
			$result['draft_name']=alias($emp_alias,'ec_employee_master','employee_alias','name');
			if($arr_inter_cnt > 0){ //combo of 2, 3, 5
				$empDgn=empdrop();
				if($empDgn!=0){ //All employee list
					foreach($empDgn as $i => $rec){ $result[$i]['alias']=$rec['alias'];$result[$i]['name']=$rec['name'];}
				}else {$res="No Records Found";} 
			}else{
				//if approvel level must be 1 or 4
				$get_dep = mysqli_query($mr_con,"SELECT GROUP_CONCAT(DISTINCT approval_dep) AS approval_dep FROM ec_expense_approvals where approver = '$emp_alias'");
				$get_dept_rs = mysqli_fetch_array($get_dep);
				$appr_dept = $get_dept_rs['approval_dep'];//dept based aliases
				$empDeptDgn=empDeptdrop($appr_dept,$emp_alias);
				if($empDeptDgn!=0){ // Dept wise Employee list
					foreach($empDeptDgn as $j => $rec){$result[$j]['alias']=$rec['alias'];$result[$j]['name']=$rec['name'];}
				}else {$res="No Records Found";}
			}
		}else{$result['alias']='0';}		
	}
	echo json_encode($result);
}
function loadingF(){ 
	global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	$result['admin_privilege']=settingHideStatus($emp_alias);
	$esca_id=alias($emp_alias,'ec_esca','esca_alias','id');
	$cust_id=alias($emp_alias,'ec_customer','customer_alias','id'); 
	if($emp_alias=='ADMIN'){$result['empwent']="#/dashboard";}
	elseif($emp_alias=='EADMIN'){$result['empwent']="#/Employeemaster";}
	elseif(!empty($esca_id)){$result['empwent']="#/dashboard-esca";}
	elseif(!empty($cust_id)){$result['empwent']="#/dashboard-customer";}
	else{$result['empwent']=getbesturl($emp_alias);}
	if($rex==0){$resCode='0'; $resMsg='Success';}elseif($rex==1){ $resCode='1'; $resMsg='Authentication Failed';}
	else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
?>
