<?php
date_default_timezone_set("Asia/Kolkata");
include ('mysql.php');
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->post('/login_web','login_web');
$app->post('/ticket_add','ticket_add');
$app->post('/login','login_credentials');
$app->post('/get_tickets','get_tickets');
$app->post('/search_ticket','search_ticket');
$app->post('/emp_details','edit_emp_details');
$app->post('/employee_details','employee_details');
$app->post('/emp_profilepic','emp_profilepic');
$app->post('/zone','zone');
$app->post('/state','state');
$app->post('/district','district');
$app->post('/activity','activity');
$app->post('/complaint','complaint');
$app->post('/segment','segment');
$app->post('/customer','customer');
$app->post('/department','department');
$app->post('/designation','designation');
$app->post('/faulty_code','faulty_code');
$app->post('/item_code','item_code');
$app->post('/product','product');
$app->post('/site_status','site_status');
$app->post('/site_type','site_type');
$app->post('/stock','stock');
$app->post('/warehouse','warehouse');
$app->post('/sitemaster','sitemaster');
$app->post('/tickets','tickets');
$app->post('/planned_level','planned_level');
$app->post('/efsr_upload','efsr_upload');
$app->post('/user_tracking','user_tracking');
$app->post('/site_tracker','site_tracker');
$app->post('/logout','logout');
$app->post('/dpr','dpr');
$app->post('/dpr_category','dpr_category');
$app->run();
function login_web(){
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$user=$_REQUEST['user'];
	$password=$_REQUEST['password'];
	//echo $user;
	global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT id FROM ec_employee_master WHERE email_id='$user' AND password='$password' AND flag=0");
		if(mysqli_num_rows($sql)>0){
			$emp_alias=alias($user,'ec_employee_master','email_id','employee_alias');
			$sql = mysqli_query($mr_con,"DELETE FROM ec_token WHERE employee_alias='$emp_alias'");
			$alias = aliasCheck(generateRandomString(),'ec_token','token');		
			$sql = mysqli_query($mr_con,"INSERT INTO ec_token(employee_alias,token,created_date) VALUES('$emp_alias','$alias','".date('Y-m-d')."')");
			$result['ErrorDetails']['ErrorCode']='0';
			$result['ErrorDetails']['ErrorMessage']='Successful!';
			$result['empdetails']['alias']=$emp_alias;
			$result['empdetails']['token']=$alias;
		}else{
			$result['ErrorDetails']['ErrorCode']='1';
			$result['ErrorDetails']['ErrorMessage']='Authentication Failed!';
		}echo json_encode($result);
	}
function getAddress($lat, $lon){
   $url  = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$lon."&sensor=false";
   $json = @file_get_contents($url);
   $data = json_decode($json);
   $status = $data->status;
   $address = '';
   if($status == "OK"){
      $address = $data->results[0]->formatted_address;
    }
   return $address;
  }	
function site_tracker(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	$rex=putToken($device_id,$emp_id);
	if($rex=='0'){
		$lat=$login->lat;
		$lng=$login->lng;
		$site_id=$login->site_id;
		$con_site = "flag='0',";
		if(!empty($lat)){$con_site .= "lat='$lat',";}
		if(!empty($lng)){$con_site .= "lng='$lng',";}
		if(!empty($lat) && !empty($lng)){
			$address_site=getAddress($lat, $lng);
			if(!empty($address_site)){$con_site .= "site_address='$address_site',";}
		}
		$sql = mysqli_query($mr_con,"UPDATE ec_sitemaster SET $con_site WHERE site_id='$site_id' AND flag=0");
		if($sql){$result['ErrorDetails']['ErrorCode']='0';$result['ErrorDetails']['ErrorMessage']='successful!';}
	}elseif($rex=='-3'){$result['ErrorDetails']['ErrorCode']='-3';$result['ErrorDetails']['ErrorMessage']='account locked';}
	elseif($rex=='-2'){$result['ErrorDetails']['ErrorCode']='-2';$result['ErrorDetails']['ErrorMessage']='device not matched';}
	else{$result['ErrorDetails']['ErrorCode']='-1';$result['ErrorDetails']['ErrorMessage']='authentication failed';}
	echo json_encode($result);
}
function authentication($emp_alias,$token) { global $mr_con; 
	$sql = mysqli_query($mr_con,"SELECT id FROM ec_token WHERE employee_alias='$emp_alias' AND token='$token' AND flag=0");
	$sql1 = mysqli_query($mr_con,"SELECT id FROM ec_employee_master WHERE employee_alias='$emp_alias' AND flag=1");
	$sql2 = mysqli_query($mr_con,"SELECT id FROM ec_token WHERE employee_alias='$emp_alias' AND token!='$token' AND flag=0");
	if(mysqli_num_rows($sql)>0){return '0';}
	elseif(mysqli_num_rows($sql1)>0){return '2';}
	else{return '1';}
}
function ticket_add(){
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$result['ErrorDetails']['ErrorCode']='0';
	$result['ErrorDetails']['ErrorMessage']='Successful!';
	$result['tickets']['nature']=$_REQUEST['natureofactivity'];
	$result['tickets']['siteid']=$_REQUEST['siteid'];
	echo json_encode($result);
}
function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++){$randomString .= $characters[rand(0, $charactersLength - 1)];}
    return strtoupper($randomString);
}
function aliasCheck($fv1,$fv2,$fv3){ global $mr_con;
	$rec=$mr_con->query("SELECT $fv3 FROM $fv2 WHERE $fv3='$fv1'");
	if($rec->num_rows==0)return $fv1; else return aliasCheck(generateRandomString(),$fv2,$fv3);
}
function listchecking($fv1,$fv2,$fv3){ global $mr_con;
	$rec=$mr_con->query("SELECT id FROM $fv1 WHERE $fv2='$fv3'");
	if($rec){
		if($rec->num_rows==0)return 0; else return 1;
	}else return 1;
	}
function login_credentials(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$data = urldecode($request->getBody());
	$login = json_decode($request->getBody());
	$employee_id=$login->emp_id;
	$device=$login->device_id;
	
	//obj start
		$date = date('Y_m_d_H_i_s');
		$log = (!empty($employee_id) ? $employee_id."_".$date : "empty_".$date);
		if(!file_exists("login_objects/".$log.".txt")){$name = $log;}else{$name = $log."_".rand();}
		$myfile = fopen("login_objects/".$name.".txt", "w") or die("Unable to open file!");
		fwrite($myfile, $data);
		fclose($myfile);
	//obj end
	
	$rex=putToken($device,$employee_id);
	if($rex=='0'){
		$reg_id=$login->reg_id;
		$pin=$login->pin;
		$emp_alias=alias($employee_id,'ec_employee_master','employee_id','employee_alias');
		$sqlUp = mysqli_query($mr_con,"UPDATE ec_employee_master SET reg_id='$reg_id',pin='$pin' WHERE employee_alias='$emp_alias' AND flag=0");
		$sql = mysqli_query($mr_con,"SELECT name,employee_id,email_id,mobile_number,profile_pic,status,role_alias FROM ec_employee_master WHERE employee_alias='$emp_alias' AND flag=0");
		$row = mysqli_fetch_array($sql);
		$result['ErrorDetails']['ErrorCode']='0';
		$result['ErrorDetails']['ErrorMessage']="Success";
		$result['EmployeeDetails']['Employee_name']=$row['name'];
		$result['EmployeeDetails']['employee_id']=$row['employee_id'];
		$result['EmployeeDetails']['email_id']=$row['email_id'];
		$result['EmployeeDetails']['mobile_number']=$row['mobile_number'];
		$result['EmployeeDetails']['profile_pic']=$row['profile_pic'];
		$result['EmployeeDetails']['status']=$row['status'];
		$result['EmployeeDetails']['role_stat']=alias($row['role_alias'],'ec_emprole','role_alias','role_stat');
		
		$not_visitedSql = mysqli_query($mr_con,"SELECT id FROM ec_tickets WHERE service_engineer_alias='$emp_alias' AND level='2' AND flag=0");
		$visitedSql = mysqli_query($mr_con,"SELECT id FROM ec_tickets WHERE service_engineer_alias='$emp_alias' AND level > '2' AND planned_date >= '".date('Y-m-01')."' AND planned_date <= '".date('Y-m-31')."' AND flag=0");
		$not_visited=mysqli_num_rows($not_visitedSql); $visited=mysqli_num_rows($visitedSql);
		if($not_visited>0){ $not_visited_count=$not_visited; }else{$not_visited_count='0';}
		if($visited>0){ $visited_count=$visited;}else{$visited_count='0';}
		$a = $not_visited_count+$visited_count;
		$result['EmployeeDetails']['not_visited']=($a=='0' ? '0' : (($not_visited_count)*100)/$a);
		$result['EmployeeDetails']['visited']=($a=='0' ? '0' : (($visited_count)*100)/$a);
		$result['app_version']="V.1.09";
		date_default_timezone_set("Asia/Kolkata");
		$month = date('n');
		$result['wallpaper']['wallpaper']=alias($month,'ec_wallpapers','month','wallpaper_link');
	}
	elseif($rex=='-3'){$result['ErrorDetails']['ErrorCode']='-3';$result['ErrorDetails']['ErrorMessage']='account locked';}
	elseif($rex=='-2'){$result['ErrorDetails']['ErrorCode']='-2';$result['ErrorDetails']['ErrorMessage']='device not matched';}
	else{$result['ErrorDetails']['ErrorCode']='-1';$result['ErrorDetails']['ErrorMessage']='authentication failed';}
	echo json_encode($result);
}
function putToken($device,$emp_id) { global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT employee_alias FROM ec_employee_master WHERE employee_id='$emp_id' AND (device='$device' OR device_2='$device') AND flag=0");
	$sql1 = mysqli_query($mr_con,"SELECT id FROM ec_employee_master WHERE employee_id='$emp_id' AND (device='$device' OR device_2='$device') AND flag=1");
	$sql2 = mysqli_query($mr_con,"SELECT id FROM ec_employee_master WHERE employee_id='$emp_id' AND device<>'$device' AND device_2<>'$device' AND flag=0");
	if(mysqli_num_rows($sql)){
		/*if(mysqli_num_rows(mysqli_query($mr_con,"SELECT id FROM ec_token WHERE token='".md5($row['employee_alias'])."' AND flag=0"))==0){
			$row = mysqli_fetch_array($sql);
			$sql = mysqli_query($mr_con,"INSERT INTO ec_token(employee_alias,device,token,created_date) VALUES('$row[employee_alias]','$device','".md5($row['employee_alias'])."','".date('Y-m-d')."')");	
		}*/
		return '0';
	}
	elseif(mysqli_num_rows($sql1)){return '-3';}
	elseif(mysqli_num_rows($sql2)){return '-2';}
	else{return '-1';}
}
function getToken($emp_id,$token){ global $mr_con; return '0';
	$sql = mysqli_query($mr_con,"SELECT id FROM ec_token WHERE employee_alias='".alias($emp_id,'ec_employee_master','employee_id','employee_alias')."' AND token='$token' AND flag=0");
	if(mysqli_num_rows($sql)){return '0';}else{return '-1';}
}
function get_tickets(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	$page_no=$login->page_no;
	$rex=putToken($device_id,$emp_id);
	//$rex='0';
	if($rex=='0'){
		$emp_alias = alias($emp_id,'ec_employee_master','employee_id','employee_alias');
		$pg=($page_no-1);
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_tickets WHERE service_engineer_alias='$emp_alias' AND level='2' AND flag=0");
			//if(mysql_num_rows($rec)){
				$row1=mysqli_fetch_array($rec);
				$rec_limit = 100;
				$rec_count = $row1[0];
				if(is_float($rec_count/$rec_limit)){$totalpages=round($rec_count/$rec_limit)+1;}else{$totalpages=$rec_count/$rec_limit;}
				if($pageNo!="all"){$page = ($pageNo-1);
				if($page<0){$page=0;}
				$offset = $rec_limit * $page ;}
				else{$page = 0;$offset = $rec_limit * $page ;}
				$left_rec=$rec_count-($page*$rec_limit);
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE service_engineer_alias='$emp_alias' AND level='2' AND flag=0 ORDER BY planned_date LIMIT $offset, $rec_limit");
		//if(mysql_num_rows($sql)){
		$record = '{"ErrorDetails":{"ErrorCode":0,"ErrorMessage":"Success"},"ticket":[';
		while($row = mysqli_fetch_array($sql)){
			$record .= '{"ticket_id":"'.$row['ticket_id'].'","ticket_alias":"'.$row['ticket_alias'].'",'.site_master($row['site_alias']).request_cell($row['ticket_alias']).remarks($row['ticket_alias']).'
						"activity":"'.alias($row['activity_alias'],'ec_activity','activity_alias','activity_name').'",
						"complaint":"'.alias($row['complaint_alias'],'ec_complaint','complaint_alias','complaint_name').'",
						"description":"'.urlencode($row['description']).'",
						"login_date":"'.($row['login_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$row['login_date'])))).'",
						"activation_date":"'.dateFormat($row['activation_date'],"d").'",
						"planned_date":"'.dateFormat($row['planned_date'],"y").'",
						"service_engineer_alias":"'.alias($row['service_engineer_alias'],'ec_employee_master','employee_alias','name').'",
						"closing_date":"'.($row['closing_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$row['closing_date'])))).'",
						"level":"'.alias($row['level'],'ec_levels','level_alias','level_name').'",
						"status":"'.$row['status'].'",
						"lat":"'.alias($row['site_alias'],'ec_sitemaster','site_alias','lat').'",
						"lan":"'.alias($row['site_alias'],'ec_sitemaster','site_alias','lng').'"},';
					}
			$cord .= rtrim($record,",");
			$cord .= '],'.cell_details().','.engineer_performance($emp_alias).',"total_pages":"'.$totalpages.'","app_version":"V.1.09"}';
			echo $cord;
					//}
		//}
	}elseif($rex=='-3'){echo '{"ErrorDetails":{"ErrorCode":-3,"ErrorMessage":"account locked"}}';}
	elseif($rex=='-2'){echo '{"ErrorDetails":{"ErrorCode":-2,"ErrorMessage":"device not matched"}}';}
	else{echo '{"ErrorDetails":{"ErrorCode":-1,"ErrorMessage":"authentication failed"}}';}
}
function site_master($alias){ global $mr_con; $row['site_address']="NA";
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_sitemaster WHERE site_alias='$alias' AND flag=0");
	//if(mysqli_num_rows($sql)){
		$row = mysqli_fetch_array($sql);
		$add = '"zone":"'.alias($row['zone_alias'],'ec_zone','zone_alias','zone_name').'",';
		$add .= '"state":"'.alias($row['state_alias'],'ec_state','state_alias','state_name').'",';
		$add .= '"district":"'.alias($row['district_alias'],'ec_district','district_alias','district_name').'",';
		$add .= '"segment":"'.alias($row['segment_alias'],'ec_segment','segment_alias','segment_name').'",';
		$add .= '"customer":"'.alias($row['customer_alias'],'ec_customer','customer_alias','customer_name').'",';
		$add .= '"customer_code":"'.alias($row['customer_alias'],'ec_customer','customer_alias','customer_code').'",';
		$add .= '"customer_number":"'.alias($row['customer_alias'],'ec_customer','customer_alias','customer_contact').'",';
		$add .= '"site_type":"'.alias($row['site_type_alias'],'ec_site_type','site_type_alias','site_type').'",';
		$add .= '"site_id":"'.$row['site_id'].'",';
		$add .= '"site_name":"'.$row['site_name'].'",';
		$add .= '"product":"'.alias($row['product_alias'],'ec_product','product_alias','product_description').'",';
		$add .= '"mfd_date":"'.dateFormat($row['mfd_date'],"d").'",';
		$add .= '"install_date":"'.dateFormat($row['install_date'],"d").'",';
		$add .= '"no_of_string":"'.$row['no_of_string'].'",';
		$add .= '"technician_name":"'.$row['technician_name'].'",';
		$add .= '"technician_number":"'.$row['technician_number'].'",';
		$add .= '"manager_name":"'.$row['manager_name'].'",';
		$add .= '"manager_number":"'.$row['manager_number'].'",';
		$add .= '"manager_mail":"'.$row['manager_mail'].'",';
		$add .= '"site_address":"'.urlencode($row['site_address']).'",';
		return $add;
	//}
}
function remarks($alias){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE item_alias='$alias' AND flag=0");
	//if(mysqli_num_rows($sql)){
	$rem_by=array();$rem_on=array();$rem=array();
		$ix=0;
		while($row = mysqli_fetch_array($sql)){
			$rem_by[$ix]=(strtoupper($row['remarked_by'])=='ADMIN' ? 'ADMIN' : ucwords(strtolower(alias($row['remarked_by'],'ec_employee_master','employee_alias','name'))));
			$rem_on[$ix]=dateTimeFormat($row['remarked_on'],"d");
			$rem[$ix]=urlencode($row['remarks']);
			$ix++;
		}
		$rby='"'.implode('","',$rem_by).'"';
		$ron='"'.implode('","',$rem_on).'"';
		$rmsg='"'.implode('","',$rem).'"';
		
		$add = '"remarks":{"remarkedby":['.$rby.'],';
		$add.= '"remarkedon":['.$ron.'],';
		$add.= '"remark":['.$rmsg.']},';
		return $add;
	//}
}
function engineer_performance($emp_alias){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT name,email_id,mobile_number FROM ec_employee_master WHERE employee_alias='$emp_alias' AND flag=0");
	$row = mysqli_fetch_array($sql);
	$employee_name=$row['name'];
	$email_id=$row['email_id'];
	$mobile_number=$row['mobile_number'];
	$not_visitedSql = mysqli_query($mr_con,"SELECT id FROM ec_tickets WHERE service_engineer_alias='$emp_alias' AND level='2' AND flag=0");
	$visitedSql = mysqli_query($mr_con,"SELECT id FROM ec_tickets WHERE service_engineer_alias='$emp_alias' AND level > '2' AND planned_date >= '".date('Y-m-01')."' AND planned_date <= '".date('Y-m-31')."' AND flag=0");
	$not_visited=mysqli_num_rows($not_visitedSql); $visited=mysqli_num_rows($visitedSql);
	if($not_visited>0){ $not_visited_count=$not_visited; }else{$not_visited_count='0';}
	if($visited>0){ $visited_count=$visited;}else{$visited_count='0';}
	$a = $not_visited_count+$visited_count;
	$result = '"EmployeeDetails":[{
					"not_visited":"'.($a=='0' ? '0' : (($not_visited_count)*100)/$a).'",
					"visited":"'.($a=='0' ? '0' : (($visited_count)*100)/$a).'",
					"Employee_name":"'.$employee_name.'",
					"email_id":"'.$email_id.'",
					"mobile_number":"'.$mobile_number.'"
				}]';
	return $result;
}
function request_cell($ticket_alias){ global $mr_con;
$ali_list = alias($ticket_alias,'ec_material_outward','ref_no','alias');
	$record = '"request_cell":[';
	if(!empty($ali_list) && $ali_list!='NA'){
		$fqs_sql = mysqli_query($mr_con,"SELECT item_description FROM ec_material_sent_details WHERE reference='$ali_list' AND flag=0");
		if(mysqli_num_rows($fqs_sql)){
			while($row = mysqli_fetch_array($fqs_sql)){
				$record .= '{"item_description":"'.alias($row['item_description'],'ec_item_code','item_code_alias','item_description').'","item_code_alias":"'.$row['item_description'].'"},';
			}
		}else{$record .= '{"item_description":"","item_code_alias":""},';}
	}else{$record .= '{"item_description":"","item_code_alias":""},';}
	$cord = rtrim($record,",");
	$cord .= '],';
	return $cord;
}
function cell_details(){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT accessory_description,accessories_alias FROM ec_accessories WHERE flag=0");
	$sql2 = mysqli_query($mr_con,"SELECT product_description,product_alias,battery_rating FROM ec_product WHERE flag=0");
	$sql3 = mysqli_query($mr_con,"SELECT description,faulty_alias FROM ec_faulty_code WHERE flag=0");
	$record = '"cell":[';
		while($row = mysqli_fetch_array($sql)){
			$record .= '{"cell_no":"'.$row['accessory_description'].'","cell_alias":"'.$row['accessories_alias'].'"},';
		}
			$cord = rtrim($record,",");
			$cord .= '],"product":[';
		while($row2 = mysqli_fetch_array($sql2)){
			$cord .= '{"product_code":"'.$row2['product_description'].'","product_alias":"'.$row2['product_alias'].'","battery_rating":"'.$row2['battery_rating'].'"},';
		}
			$cord1 = rtrim($cord,",");
			$cord1 .= '],"faulty":[';
		while($row3 = mysqli_fetch_array($sql3)){
			$cord1 .= '{"faulty_code":"'.$row3['description'].'","faulty_alias":"'.$row3['faulty_alias'].'"},';
		}
			$cord2 = rtrim($cord1,",");
			$cord2 .= ']';
			return $cord2;
}
function alias($alias,$tb,$col,$retrive){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT $retrive FROM $tb WHERE $col='$alias' AND flag=0");
	if(mysqli_num_rows($sql)){
		$row = mysqli_fetch_array($sql);
		return $row[$retrive];
	}else{return 'NA';}
}
function employee_details(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT name,employee_id FROM ec_employee_master WHERE device<>0 AND flag=0");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){
		$result['employeeDetails'][$i]['employee_id']=$row['employee_id'];
		$result['employeeDetails'][$i]['employee_name']=$row['name']; $i++;}
	}
	echo json_encode($result);
}
function edit_emp_details(){ global $mr_con;
	$rex=getToken($_REQUEST['emp_id'],$_REQUEST['token']);
	if($rex=='0'){
		$id = $_REQUEST['id'];
		$emp_name = $_REQUEST['emp_name'];
		$emp_mobile = $_REQUEST['emp_mobile'];
		$emp_email = $_REQUEST['emp_email'];
		$sql = mysqli_query($mr_con,"UPDATE ec_employee_master SET name='$emp_name',mobile_number='$emp_mobile',email_id='$emp_email' WHERE id='$id' AND flag=0");
		if($sql){echo '{"ErrorDetails":{"ErrorCode":0,"ErrorMessage":"Success"}}'; }
	}else{echo '{"ErrorDetails":{"ErrorCode":-1,"ErrorMessage":"authentication failed"}}';}
}
function emp_profilepic(){ global $mr_con;
	$rex=getToken($_REQUEST['emp_id'],$_REQUEST['token']);
	if($rex=='0'){
		$id = $_REQUEST['id'];
		$pic = upload_file($_FILES['profile'],'profile_pic','image');
		if($pic){
			$sq = mysqli_query($mr_con,"SELECT profile_pic FROM ec_employee_master WHERE id='$id' AND flag=0");
			$ro = mysqli_fetch_array($sq); $oldPic = $ro['profile_pic'];
			$sql = mysqli_query($mr_con,"UPDATE ec_employee_master SET profile_pic='$pic' WHERE id='$id' AND flag=0");
			if($sql){ @unlink($oldPic); echo '{"ErrorDetails":{"ErrorCode":0,"ErrorMessage":"Success"}}'; }
		}else{echo '{"ErrorDetails":{"ErrorCode":1,"ErrorMessage":"Error in uploading"}}';}
	}else{echo '{"ErrorDetails":{"ErrorCode":-1,"ErrorMessage":"authentication failed"}}';}
}
function search_ticket(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	$ticket_id = $login->ticket_id;
	$page_no=$login->page_no;
	$rex=putToken($device_id,$emp_id);
	if($rex=='0'){
		$pg=($page_no-1);
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_tickets WHERE ticket_id LIKE '%".$ticket_id."%' AND flag=0");
			//if(mysql_num_rows($rec)){
				$row1=mysqli_fetch_array($rec);
				$rec_limit = 10;
				$rec_count = $row1[0];
				if(is_float($rec_count/$rec_limit)){$totalpages=round($rec_count/$rec_limit)+1;}else{$totalpages=$rec_count/$rec_limit;}
				if($pageNo!="all"){$page = ($pageNo-1);
				if($page<0){$page=0;}
				$offset = $rec_limit * $page ;}
				else{$page = 0;$offset = $rec_limit * $page ;}
				$left_rec=$rec_count-($page*$rec_limit);
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE ticket_id LIKE '%".$ticket_id."%' AND flag=0 LIMIT $offset, $rec_limit");
		//if(mysql_num_rows($sql)){
		$record = '{"ErrorDetails":{"ErrorCode":0,"ErrorMessage":"Success"},"ticket":[';
		while($row = mysqli_fetch_array($sql)){
			$record .= '{"ticket_id":"'.$row['ticket_id'].'",'.site_master($row['site_alias']).remarks($row['ticket_alias']).'
						"activity":"'.alias($row['activity_alias'],'ec_activity','activity_alias','activity_name').'",
						"complaint":"'.alias($row['complaint_alias'],'ec_complaint','complaint_alias','complaint_name').'",
						"description":"'.$row['description'].'",
						"login_date":"'.($row['login_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$row['login_date'])))).'",
						"activation_date":"'.dateFormat($row['activation_date'],"d").'",
						"planned_date":"'.dateFormat($row['planned_date'],"y").'",
						"service_engineer_alias":"'.alias($row['service_engineer_alias'],'ec_employee_master','employee_alias','name').'",
						"closing_date":"'.($row['closing_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$row['closing_date'])))).'",
						"level":"'.alias($row['level'],'ec_levels','level_alias','level_name').'",
						"status":"'.$row['status'].'",
						"lat":"'.alias($row['site_alias'],'ec_sitemaster','site_alias','lat').'",
						"lan":"'.alias($row['site_alias'],'ec_sitemaster','site_alias','lng').'"},';
					}
			$cord .= rtrim($record,",");
			$cord .= '],"total_pages":"'.$totalpages.'"}';
			echo $cord;
		//}
	}elseif($rex=='-3'){echo '{"ErrorDetails":{"ErrorCode":-3,"ErrorMessage":"account locked"}}';}
	elseif($rex=='-2'){echo '{"ErrorDetails":{"ErrorCode":-2,"ErrorMessage":"device not matched"}}';}
	else{echo '{"ErrorDetails":{"ErrorCode":-1,"ErrorMessage":"authentication failed"}}';}
}
function zone(){ global $mr_con;
	$rex=getToken($_REQUEST['emp_id'],$_REQUEST['token']);
	if($rex=='0'){
		$alias = aliasCheck(generateRandomString(),'ec_zone','zone_alias');
		$zone_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['zone_name']));
		$sql = mysqli_query($mr_con,"INSERT INTO ec_zone(zone_name,zone_alias,created_date)VALUES('$zone_name','$alias','".date('Y-m-d')."')");
		if($sql){echo '{"err_details":{"err_code":0,"err_message":"Success"}}'; }
	}else{echo '{"err_details":{"err_code":-1,"err_message":"authentication failed"}}';}
}
function state(){ global $mr_con;
	$rex=getToken($_REQUEST['emp_id'],$_REQUEST['token']);
	if($rex=='0'){
		$alias = aliasCheck(generateRandomString(),'ec_state','state_alias');
		$zone_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['zone_alias']));
		$state_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['state_name']));
		$sql = mysqli_query($mr_con,"INSERT INTO ec_state(state_name,state_alias,zone_alias,created_date)VALUES('$state_name','$alias','$zone_alias','".date('Y-m-d')."')");
		if($sql){echo '{"err_details":{"err_code":0,"err_message":"Success"}}'; }
	}else{echo '{"err_details":{"err_code":-1,"err_message":"authentication failed"}}';}
}
function district(){ global $mr_con;
	$rex=getToken($_REQUEST['emp_id'],$_REQUEST['token']);
	if($rex=='0'){
		$alias = aliasCheck(generateRandomString(),'ec_district','district_alias');
		$state_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['state_alias']));
		$district_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['district_name']));
		$sql = mysqli_query($mr_con,"INSERT INTO ec_district(district_name,district_alias,state_alias,created_date)VALUES('$district_name','$alias','$state_alias','".date('Y-m-d')."')");
		if($sql){echo '{"err_details":{"err_code":0,"err_message":"Success"}}'; }
	}else{echo '{"err_details":{"err_code":-1,"err_message":"authentication failed"}}';}
}
function activity(){ global $mr_con;
	$rex=getToken($_REQUEST['emp_id'],$_REQUEST['token']);
	if($rex=='0'){
		$alias = aliasCheck(generateRandomString(),'ec_activity','activity_alias');
		$activity_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['activity_name']));
		$activity_code = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['activity_code']));
		$sql = mysqli_query($mr_con,"INSERT INTO ec_activity(activity_name,activity_code,activity_alias,created_date)VALUES('$activity_name','$activity_code','$alias','".date('Y-m-d')."')");
		if($sql){echo '{"err_details":{"err_code":0,"err_message":"Success"}}'; }
	}else{echo '{"err_details":{"err_code":-1,"err_message":"authentication failed"}}';}
}
function complaint(){ global $mr_con;
	$rex=getToken($_REQUEST['emp_id'],$_REQUEST['token']);
	if($rex=='0'){
		$alias = aliasCheck(generateRandomString(),'ec_complaint','complaint_alias');
		$complaint_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['complaint_name']));
		$activity_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['activity_alias']));
		$sql = mysqli_query($mr_con,"INSERT INTO ec_complaint(complaint_name,complaint_alias,activity_alias,created_date)VALUES('$complaint_name','$alias','$activity_alias','".date('Y-m-d')."')");
		if($sql){echo '{"err_details":{"err_code":0,"err_message":"Success"}}'; }
	}else{echo '{"err_details":{"err_code":-1,"err_message":"authentication failed"}}';}
}
function segment(){ global $mr_con;
	$rex=getToken($_REQUEST['emp_id'],$_REQUEST['token']);
	if($rex=='0'){
		$alias = aliasCheck(generateRandomString(),'ec_segment','segment_alias');
		$segment_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['segment_name']));
		$sql = mysqli_query($mr_con,"INSERT INTO ec_segment(segment_name,segment_alias,created_date)VALUES('$segment_name','$alias','".date('Y-m-d')."')");
		if($sql){echo '{"err_details":{"err_code":0,"err_message":"Success"}}'; }
	}else{echo '{"err_details":{"err_code":-1,"err_message":"authentication failed"}}';}
}
function customer(){ global $mr_con;
	$rex=getToken($_REQUEST['emp_id'],$_REQUEST['token']);
	if($rex=='0'){
		$alias = aliasCheck(generateRandomString(),'ec_customer','customer_alias');
		$customer_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['customer_name']));
		$customer_code = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['customer_code']));
		$customer_email = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['customer_email']));
		$customer_contact = mysqli_real_escape_string($mr_con,$_REQUEST['customer_contact']);
		$dispatch = mysqli_real_escape_string($mr_con,$_REQUEST['dispatch']);
		$installation = mysqli_real_escape_string($mr_con,$_REQUEST['installation']);
		$schedule = mysqli_real_escape_string($mr_con,$_REQUEST['schedule']);
		$segment_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['segment_alias']));
		$sql = mysqli_query($mr_con,"INSERT INTO ec_customer(customer_name,customer_code,customer_email,customer_contact,dispatch,installation,segment_alias,schedule,customer_alias,created_date)VALUES('$customer_name','$customer_code','$customer_email','$customer_contact','$dispatch','$installation','$segment_alias','$schedule','$alias','".date('Y-m-d')."')");
		if($sql){echo '{"err_details":{"err_code":0,"err_message":"Success"}}'; }
	}else{echo '{"err_details":{"err_code":-1,"err_message":"authentication failed"}}';}
}
function department(){ global $mr_con;
	$rex=getToken($_REQUEST['emp_id'],$_REQUEST['token']);
	if($rex=='0'){
		$alias = aliasCheck(generateRandomString(),'ec_department','department_alias');
		$department_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['department_name']));
		$spl = mysqli_real_escape_string($mr_con,$_REQUEST['spl']);
		$sql = mysqli_query($mr_con,"INSERT INTO ec_department(department_name,spl,department_alias,created_date)VALUES('$department_name','$spl','$alias','".date('Y-m-d')."')");
		if($sql){echo '{"err_details":{"err_code":0,"err_message":"Success"}}'; }
	}else{echo '{"err_details":{"err_code":-1,"err_message":"authentication failed"}}';}
}
function designation(){ global $mr_con;
	$rex=getToken($_REQUEST['emp_id'],$_REQUEST['token']);
	if($rex=='0'){
		$alias = aliasCheck(generateRandomString(),'ec_designation','designation_alias');
		$grade = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['grade']));
		$designation = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['designation']));
		$description = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['description']));
		$sql = mysqli_query($mr_con,"INSERT INTO ec_designation(grade,designation,description,designation_alias,created_date)VALUES('$grade','$designation','$description','$alias','".date('Y-m-d')."')");
		if($sql){echo '{"err_details":{"err_code":0,"err_message":"Success"}}'; }
	}else{echo '{"err_details":{"err_code":-1,"err_message":"authentication failed"}}';}
}
function faulty_code(){ global $mr_con;
	$rex=getToken($_REQUEST['emp_id'],$_REQUEST['token']);
	if($rex=='0'){
		$alias = aliasCheck(generateRandomString(),'ec_faulty_code','faulty_alias');
		$faulty_code = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['faulty_code']));
		$description = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['description']));
		$sql = mysqli_query($mr_con,"INSERT INTO ec_faulty_code(faulty_code,description,faulty_alias,created_date)VALUES('$faulty_code','$description','$alias','".date('Y-m-d')."')");
		if($sql){echo '{"err_details":{"err_code":0,"err_message":"Success"}}'; }
	}else{echo '{"err_details":{"err_code":-1,"err_message":"authentication failed"}}';}
}
function item_code(){ global $mr_con;
	$rex=getToken($_REQUEST['emp_id'],$_REQUEST['token']);
	if($rex=='0'){
		$alias = aliasCheck(generateRandomString(),'ec_item_code','item_alias');
		$item_code = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['item_code']));
		$item_price = mysqli_real_escape_string($mr_con,$_REQUEST['item_price']);
		$description = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['description']));
		$sql = mysqli_query($mr_con,"INSERT INTO ec_item_code(item_code,item_price,description,item_alias,created_date)VALUES('$item_code','$item_price','$description','$alias','".date('Y-m-d')."')");
		if($sql){echo '{"err_details":{"err_code":0,"err_message":"Success"}}'; }
	}else{echo '{"err_details":{"err_code":-1,"err_message":"authentication failed"}}';}
}
function product(){ global $mr_con;
	$rex=getToken($_REQUEST['emp_id'],$_REQUEST['token']);
	if($rex=='0'){
		$alias = aliasCheck(generateRandomString(),'ec_product','product_alias');
		$product_description = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['product_description']));
		$battery_rating = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['battery_rating']));
		$cell_voltage = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['cell_voltage']));
		$sql = mysqli_query($mr_con,"INSERT INTO ec_product(product_description,battery_rating,cell_voltage,product_alias,created_date)VALUES('$product_description','$battery_rating','$cell_voltage','$alias','".date('Y-m-d')."')");
		if($sql){echo '{"err_details":{"err_code":0,"err_message":"Success"}}'; }
	}else{echo '{"err_details":{"err_code":-1,"err_message":"authentication failed"}}';}
}
function site_status(){ global $mr_con;
	$rex=getToken($_REQUEST['emp_id'],$_REQUEST['token']);
	if($rex=='0'){
		$alias = aliasCheck(generateRandomString(),'ec_site_status','site_status_alias');
		$site_status = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_status']));
		$sql = mysqli_query($mr_con,"INSERT INTO ec_site_status(site_status,site_status_alias,created_date)VALUES('$site_status','$alias','".date('Y-m-d')."')");
		if($sql){echo '{"err_details":{"err_code":0,"err_message":"Success"}}'; }
	}else{echo '{"err_details":{"err_code":-1,"err_message":"authentication failed"}}';}
}
function site_type(){ global $mr_con;
	$rex=getToken($_REQUEST['emp_id'],$_REQUEST['token']);
	if($rex=='0'){
		$alias = aliasCheck(generateRandomString(),'ec_site_type','site_type_alias');
		$site_type = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_type']));
		$segment_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['segment_alias']));
		$sql = mysqli_query($mr_con,"INSERT INTO ec_site_type(site_type,segment_alias,site_type_alias,created_date)VALUES('$site_type','$segment_alias','$alias','".date('Y-m-d')."')");
		if($sql){echo '{"err_details":{"err_code":0,"err_message":"Success"}}'; }
	}else{echo '{"err_details":{"err_code":-1,"err_message":"authentication failed"}}';}
}
function stock(){ global $mr_con;
	$rex=getToken($_REQUEST['emp_id'],$_REQUEST['token']);
	if($rex=='0'){
		$alias = aliasCheck(generateRandomString(),'ec_stock','stock_alias');
		$stock_code = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['stock_code']));
		$description = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['description']));
		$sql = mysqli_query($mr_con,"INSERT INTO ec_stock(stock_code,description,stock_alias,created_date)VALUES('$stock_code','$description','$alias','".date('Y-m-d')."')");
		if($sql){echo '{"err_details":{"err_code":0,"err_message":"Success"}}'; }
	}else{echo '{"err_details":{"err_code":-1,"err_message":"authentication failed"}}';}
}
function warehouse(){ global $mr_con;
	$rex=getToken($_REQUEST['emp_id'],$_REQUEST['token']);
	if($rex=='0'){
		$alias = aliasCheck(generateRandomString(),'ec_warehouse','wh_alias');
		$wh_code = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['wh_code']));
		$wh_address = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['wh_address']));
		$zone_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['zone_alias']));
		$state_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['state_alias']));
		$employee_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['employee_alias']));
		$description = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['description']));
		$sql = mysqli_query($mr_con,"INSERT INTO ec_warehouse(wh_code,wh_address,zone_alias,state_alias,employee_alias,description,wh_alias,created_date)VALUES('$wh_code','$wh_address','$zone_alias','$state_alias','$employee_alias','$description','$alias','".date('Y-m-d')."')");
		if($sql){echo '{"err_details":{"err_code":0,"err_message":"Success"}}'; }
	}else{echo '{"err_details":{"err_code":-1,"err_message":"authentication failed"}}';}
}
function sitemaster(){ global $mr_con;
	$rex=getToken($_REQUEST['emp_id'],$_REQUEST['token']);
	if($rex=='0'){
		$alias = aliasCheck(generateRandomString(),'ec_sitemaster','site_alias');
		$zone_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['zone_alias']));
		$state_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['state_alias']));
		$district_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['district_alias']));
		$segment_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['segment_alias']));
		$customer_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['customer_alias']));
		$site_type_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_type_alias']));
		$site_id = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_id']));
		$site_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_name']));
		$product_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['product_alias']));
		$mfd_date = dateFormat($_REQUEST['mfd_date'],"y");
		$install_date = dateFormat($_REQUEST['install_date'],"y");
		$no_of_string = mysqli_real_escape_string($mr_con,$_REQUEST['no_of_string']);
		$technician_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['technician_name']));
		$technician_number = mysqli_real_escape_string($mr_con,$_REQUEST['technician_number']);
		$manager_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['manager_name']));
		$manager_number = mysqli_real_escape_string($mr_con,$_REQUEST['manager_number']);
		$manager_mail = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['manager_mail']));
		$site_status_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_status_alias']));
		$site_address = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_address']));
		$sql = mysqli_query($mr_con,"INSERT INTO ec_sitemaster(zone_alias,state_alias,district_alias,segment_alias,customer_alias,site_type_alias,site_id,site_name,site_alias,product_alias,mfd_date,install_date,no_of_string,technician_name,technician_number,manager_name,manager_number,manager_mail,site_status_alias,site_address,created_date)VALUES('$zone_alias','$state_alias','$district_alias','$segment_alias','$customer_alias','$site_type_alias','$site_id','$site_name','$alias','$product_alias','$mfd_date','$install_date','$no_of_string','$technician_name','$technician_number','$manager_name','$manager_number','$manager_mail','$site_status_alias','$site_address','".date('Y-m-d')."')");
		if($sql){echo '{"err_details":{"err_code":0,"err_message":"Success"}}'; }
	}else{echo '{"err_details":{"err_code":-1,"err_message":"authentication failed"}}';}
}
function tickets(){ global $mr_con;
	$rex=getToken($_REQUEST['emp_id'],$_REQUEST['token']);
	if($rex=='0'){
		$alias = aliasCheck(generateRandomString(),'ec_tickets','ticket_alias');
		$ticket_id=ticketsID(alias(alias($_REQUEST['site_alias'],'ec_sitemaster','site_alias','state_alias'),'ec_state','state_alias','state_code'),1);
		$activity_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['activity_alias']));
		$site_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_alias']));
		$complaint_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['complaint_alias']));
		$mode_of_contact = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mode_of_contact']));
		$contact_link = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['contact_link']));
		$description = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['description']));
		$status = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['status']));
		$sql = mysqli_query($mr_con,"INSERT INTO ec_tickets(ticket_id,activity_alias,site_alias,complaint_alias,mode_of_contact,contact_link,description,login_date,status,ticket_alias)VALUES('$ticket_id','$activity_alias','$site_alias','$complaint_alias','$mode_of_contact','$contact_link','$description','".date("Y-m-d")."','$status','$alias')");
		if($sql){echo '{"err_details":{"err_code":0,"err_message":"Success"}}'; }
	}else{echo '{"err_details":{"err_code":-1,"err_message":"authentication failed"}}';}
}
function planned_level(){
	$ticket_id=$_REQUEST['ticket_id'];
	$planned_date=dateFormat($_REQUEST['planned_date'],"y");
	$service_engineer=mysqli_real_escape_string($mr_con,strtoupper($_REQUEST['service_engineer']));
	$query=mysqli_query($mr_con,"UPDATE ec_tickets SET planned_date='$planned_date', service_engineer_alias='$service_engineer', activation_date='".date("Y-m-d")."', level='2' WHERE ticket_id='$ticket_id'");
	$reg_id=alias($service_engineer,'ec_employee_master','employee_alias','reg_id');
	$msg="Dear team, New site with TT number ".$ticket_id." is assigned to you . Planned date - ".$planned_date;
	if($query)notification($reg_id,$msg);
}
function ticketsID($state,$i){
	$sql = mysql_query("SELECT ticket_id FROM ec_tickets");
	$num = (mysql_num_rows($sql)+$i);
	if($num > 999){$x = "TT".$state."".$num;}
	elseif($num > 99){$x = "TT".$state."0".$num;}
	elseif($num > 9){$x = "TT".$state."00".$num;}
	else{$x = "TT".$state."000".$num;}
	$newTT = preg_replace('/\D/', '', $x);
	while($tt = mysql_fetch_array($sql)){
		$oldTT = preg_replace('/\D/', '', $tt['ticket_id']);
		if($oldTT==$newTT){ $arr[] = $oldTT;}
	}
	if(count($arr)==0){ return $x; }
	else{return ticketsID($state,($i+1)); }
}
function notification($reg_id,$mssg){
	// API access key from Google API's Console
	define( 'API_ACCESS_KEY', 'AIzaSyCPr4vEYPiylMHvnV--vULqzK4wBMQuGYU' );
	$registrationIds = array($reg_id);
	// prep the bundle
	$msg = array('message' 	=> strtoupper($mssg));
	$fields = array(
		'registration_ids' 	=> $registrationIds,
		'data'			=> $msg
	);
	$headers = array(
		'Authorization: key=' . API_ACCESS_KEY,
		'Content-Type: application/json'
	);
	$ch = curl_init();
	curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
	curl_setopt( $ch,CURLOPT_POST, true );
	curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	$result = curl_exec($ch );
	curl_close( $ch );
}
function user_tracking(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$update=json_decode($request->getBody(),true);
	$emp_id=$update['emp_id'];
	$device_id =$update['device_id'];
	$rex=putToken($device_id,$emp_id);
	if($rex=='0'){
		$emp_alias = alias($emp_id,'ec_employee_master','employee_id','employee_alias');
		$lat=mysqli_real_escape_string($mr_con,$update['lat']);
		$lng=mysqli_real_escape_string($mr_con,$update['lng']);
		$date_time=mysqli_real_escape_string($mr_con,$update['date_time']);
		$type=mysqli_real_escape_string($mr_con,$update['type']);
		$tracking_alias = aliasCheck(generateRandomString(),'ec_user_tracking','tracking_alias');
		$sql = mysqli_query($mr_con,"INSERT INTO ec_user_tracking(employee_alias,lat,lng,date_time,type,tracking_alias)VALUES('$emp_alias','$lat','$lng','$date_time','$type','$tracking_alias')");
		if($sql){ $resCode = '0'; $resMsg = "Successful";}
		else{$resCode = '1'; $resMsg = "failure"; }
	}
	elseif($rex=='-3'){$resCode = '-3'; $resMsg = "account locked";}
	elseif($rex=='-2'){$resCode = '-2'; $resMsg = "device not matched";}
	else{$resCode = '-1'; $resMsg = "authentication failed";}
	$result['err_details']['err_code']=$resCode;$result['err_details']['err_message']=$resMsg;
	echo json_encode($result);
	}
function logout(){ global $mr_con;
	$emp_alias = alias($_REQUEST['emp_id'],'ec_employee_master','employee_id','employee_alias');
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$sql = mysqli_query($mr_con,"DELETE FROM ec_token WHERE employee_alias='$emp_alias' AND token='$token' AND flag=0");
	if($sql){echo '{"ErrorDetails":{"ErrorCode":0,"ErrorMessage":"Success"}}'; }
	else{echo '{"ErrorDetails":{"ErrorCode":1,"ErrorMessage":"failure"}}'; }
}
function upload_file($file,$ref,$type){
	if(isset($file['name']) || !empty($file['name'])){
		$fileName = uniqid($ref.'_').$file['name'];
		if($type=='image'){$arr = array('png','jpg','gif','tif','rif','bmp','bpg');}
		else{$arr = array('pdf');}
		$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
		if(in_array($ext,$arr)){
			$name = $fileName.".".$extension;
				if($ref=='profile_pic'){$path = "profile_pics/".$name;}else{$path = "reports_images/".$name;}
				if(file_exists($path)){echo "<script>alert('".$name." already exists')</script>";}
				else{
					$move = move_uploaded_file($file["tmp_name"],$path);
					$pic = mysql_real_escape_string($path);
				if($move){return $pic;}else{return FALSE;}
				}
		}else{ echo "<script>alert('Chosen file is not an ".$type." file')</script>"; }
	}
}
function efsr_upload(){	global $mr_con;
	date_default_timezone_set("Asia/Kolkata");
	$request=\Slim\Slim::getInstance()->request();
	$efsr_check = urldecode($request->getBody());
	$update=json_decode($request->getBody(),true);
	$ticket_id=$update['ticket_details']['ticket_no'];
	//obj start
		if(strpos($ticket_id,"|")!== false){ $ticket_id = str_replace("|","_",$ticket_id); }
		if(!file_exists("ticket_objects/".$ticket_id.".txt")){$tt = $ticket_id;}else{$tt = $ticket_id."_".rand();}
		$myfile = fopen("ticket_objects/".$tt.".txt", "w") or die("Unable to open file!");
		fwrite($myfile, $efsr_check);
		fclose($myfile);
	//obj end
	$emp_id=$update['user_det']['emp_id'];
	$device_id =$update['user_det']['device_id'];
	$rex=putToken($device_id,$emp_id);
	if($rex=='0'){
		$ticket_alias = $update['ticket_details']['ticket_alias'];//alias($ticket_id,'ec_tickets','ticket_id','ticket_alias');
		if(listchecking('ec_physical_observation','ticket_alias',$ticket_alias)==0 && listchecking('ec_technical_observation','ticket_alias',$ticket_alias)==0 && listchecking('ec_general_observation','ticket_alias',$ticket_alias)==0 && listchecking('ec_power_observation','ticket_alias',$ticket_alias)==0 && listchecking('ec_battery_bank_bb_cap','ticket_alias',$ticket_alias)==0 && listchecking('ec_engineer_observation','ticket_alias',$ticket_alias)==0 && listchecking('ec_customer_comments','ticket_alias',$ticket_alias)==0 && listchecking('ec_customer_satisfaction','ticket_alias',$ticket_alias)==0 && listchecking('ec_e_signature','ticket_alias',$ticket_alias)==0){  
			//SiteMaster Update
			$man_date = dateFormat($update['ticket_details']['manufacturing_date'],"y");
			$inst_date = dateFormat($update['ticket_details']['install_date'],"y");
			$service_engineer_alias = alias($ticket_alias,'ec_tickets','ticket_alias','service_engineer_alias');
			$site_alias = alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
			$lat=$update['user_det']['lat'];
			$lng=$update['user_det']['lng'];
			$con_site = "";
			if(!empty($lat)){$con_site .= "lat='$lat',";}
			if(!empty($lng)){$con_site .= "lng='$lng',";}
			if(!empty($lat) && !empty($lng)){
				$address_site=getAddress($lat, $lng);
				if(!empty($address_site)){$con_site .= "site_address='$address_site',";}
			}
			$aa=alias($site_alias,'ec_sitemaster','site_alias','mfd_date');
			$bb=alias($site_alias,'ec_sitemaster','site_alias','install_date');
			if(!empty($man_date) && $man_date!='NA' && (empty($aa) || $aa=='NA')){$con_site .= "mfd_date='$man_date',";}
			if(!empty($inst_date) && $inst_date!='NA' && (empty($bb) || $bb=='NA')){$con_site .= "install_date='$inst_date',";}
			$sql = mysqli_query($mr_con,"UPDATE ec_sitemaster SET $con_site flag=0 WHERE site_alias='$site_alias' AND flag=0");
			$segment_alias = alias($site_alias,'ec_sitemaster','site_alias','segment_alias');
			if($segment_alias=="TQMBDTF5ZI"){ //Railways
				//coach_history
				$coach_alias = aliasCheck(generateRandomString(),'ec_coach_history','item_alias');
				$train_no=mysqli_real_escape_string($mr_con,strtoupper($update['history_of_the_coach']['train_number']));
				$express_name=mysqli_real_escape_string($mr_con,strtoupper($update['history_of_the_coach']['express_name']));
				$coach_no=mysqli_real_escape_string($mr_con,strtoupper($update['history_of_the_coach']['coach_number']));
				$pre_attnd=mysqli_real_escape_string($mr_con,strtoupper(dateFormat($update['history_of_the_coach']['previous_attended_date'],"y")));
				$poh=mysqli_real_escape_string($mr_con,strtoupper(dateFormat($update['history_of_the_coach']['poh_date'],"y")));
				$rpoh=mysqli_real_escape_string($mr_con,strtoupper(dateFormat($update['history_of_the_coach']['rpoh_date'],"y")));
				$zone=mysqli_real_escape_string($mr_con,strtoupper($update['history_of_the_coach']['zone']));
				$division=mysqli_real_escape_string($mr_con,strtoupper($update['history_of_the_coach']['division']));
				$workshop=mysqli_real_escape_string($mr_con,strtoupper($update['history_of_the_coach']['workshop_or_yard']));
				$coach_sql = mysqli_query($mr_con,"INSERT INTO ec_coach_history(ticket_alias,train_no,express_name,coach_no,pre_attnd,poh,rpoh,zone,division,workshop,item_alias)VALUES('$ticket_alias','$train_no','$express_name','$coach_no','$pre_attnd','$poh','$rpoh','$zone','$division','$workshop','$coach_alias')");	
				
				//equipment_details				
				$equip_alias = aliasCheck(generateRandomString(),'ec_equip_details','item_alias');
				$altenate_make=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['alternate_make']));
				$rru_make=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['rru_erru_make']));
				$invertor_make=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['invertor_make']));
				$regulator_make=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['regulator_make']));
				$voltage_regulation=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['voltage_regulation']));
				$altenate_belt_status=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['alternator_belt_status']));
				if(isset($update['equipment_details']['alternate_make_image'])){
					$altenate_make_doc = base64_to_file('altenate_make_doc',$update['equipment_details']['alternate_make_image'],'doc');
				}else{$altenate_make_doc='0';}
				if(isset($update['equipment_details']['alternator_belt_status_image'])){$altenate_belt_doc = base64_to_file('altenate_belt_doc',$update['equipment_details']['alternator_belt_status_image'],'doc');}else{$altenate_belt_doc='0';}
				$equip_sql = mysqli_query($mr_con,"INSERT INTO ec_equip_details(ticket_alias,altenate_make,altenate_make_doc,rru_make,invertor_make,regulator_make,voltage_regulation,altenate_belt_status,altenate_belt_doc,item_alias)VALUES('$ticket_alias','$altenate_make','$altenate_make_doc','$rru_make','$invertor_make','$regulator_make','$voltage_regulation','$altenate_belt_status','$altenate_belt_doc','$equip_alias')");	
				
				//check_points
				$check_points_alias = aliasCheck(generateRandomString(),'ec_check_points','item_alias');				
				$icc_tightness=mysqli_real_escape_string($mr_con,strtoupper($update['check_points']['icc_tightness']));
				$heating_melting_marks=mysqli_real_escape_string($mr_con,strtoupper($update['check_points']['any_heating_or_melt_marks']));
				$terminal_tightness=mysqli_real_escape_string($mr_con,strtoupper($update['check_points']['terminal_tightness']));
				$alt_no_belt_avl=mysqli_real_escape_string($mr_con,strtoupper($update['check_points']['alternate_no_of_belts_available']));
				$physical_damage=mysqli_real_escape_string($mr_con,strtoupper($update['check_points']['any_physical_damages']));
				$vent_plug_tightness=mysqli_real_escape_string($mr_con,strtoupper($update['check_points']['vent_plug_tightness']));
				$belt=mysqli_real_escape_string($mr_con,strtoupper($update['check_points']['vent_belt']));
				$log_book=mysqli_real_escape_string($mr_con,strtoupper($update['check_points']['log_book']));
				$coach_status=mysqli_real_escape_string($mr_con,strtoupper($update['check_points']['coach_status']));
				$cell_buldge=mysqli_real_escape_string($mr_con,strtoupper($update['check_points']['cell_budge']));
				if(isset($update['check_points']['physical_damages_image'])){$physical_damage_pic = base64_to_file('physical_damage_pic',$update['check_points']['physical_damages_image'],'doc');}else{$physical_damage_pic='0';}
				if(isset($update['check_points']['cell_budge_image'])){$cell_buldge_pic = base64_to_file('cell_buldge_pic',$update['check_points']['cell_budge_image'],'doc');}else{$cell_buldge_pic='0';}
				$check_points_sql = mysqli_query($mr_con,"INSERT INTO ec_check_points(ticket_alias,icc_tightness,heating_melting_marks,terminal_tightness,alt_no_belt_avl,physical_damage,physical_damage_pic,vent_plug_tightness,belt,log_book,coach_status,cell_buldge,cell_buldge_pic,item_alias)VALUES('$ticket_alias','$icc_tightness','$heating_melting_marks','$terminal_tightness','$alt_no_belt_avl','$physical_damage','$physical_damage_pic','$vent_plug_tightness','$belt','$log_book','$coach_status','$cell_buldge','$cell_buldge_pic','$check_points_alias')");	
	
			}elseif($segment_alias=="YGRKJJD4N7"){ //Motive Power
				//Physical observation
				$physical_alias = aliasCheck(generateRandomString(),'ec_physical_observation','item_alias');
				$physical_damages =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['physical_damages']));
				$leakage =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['leakage']));
				$room_temperature =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['room_temperature']));
				$ambient_temperature =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['ambient_temperature']));
				$temperature="INDOOR|".$room_temperature."|".$ambient_temperature;
				$acid_temp_discharge =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['acid_temp_discharge']));
				$acid_temp_charge =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['acid_temp_charge']));
				$cells_temp_after_use =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['cells_temp_after_use']));
				$cells_temp_at_charge =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['cells_temp_at_charge']));
				$general_observation =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['general_observations']));
				$terminal_torque_type =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['terminal_torque']));
				$no_of_cell_loose =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['no_of_cell_loose']));
				$no_of_cell_tightened =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['no_of_cell_tightened']));
				$terminal_torque=$terminal_torque_type."|".$no_of_cell_loose."|".$no_of_cell_tightened;
				//$vent_plug =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['vent_plug']));
				if(isset($update['physical_observations']['physical_damage_image'])){$physical_damage_image = base64_to_file('physical_damage_pic',$update['physical_observations']['physical_damage_image'],'doc');}else{$physical_damage_image ='0';}
				if(isset($update['physical_observations']['leakage_image'])){$leakage_image = base64_to_file('leakage_image',$update['physical_observations']['leakage_image'],'doc');}else{$leakage_image ='0';}
				$physical_sql = mysqli_query($mr_con,"INSERT INTO ec_physical_observation(ticket_alias,physical_damages,leakage,temperature,acid_temp_discharge,acid_temp_charge,cells_temp_after_use,cells_temp_at_charge,general_observation,terminal_torque,item_alias,physical_damages_document,leakage_document)VALUES('$ticket_alias','$physical_damages','$leakage','$temperature','$acid_temp_discharge','$acid_temp_charge','$cells_temp_after_use','$cells_temp_at_charge','$general_observation','$terminal_torque','$physical_alias','$physical_damage_image','$leakage_image')");
				
				//charger_details
				$charger_alias = aliasCheck(generateRandomString(),'ec_charger_details','item_alias');
				$charger_band=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['charger_brand']));
				$manf_date=dateFormat($update['charger_details']['charger_manufacturing_date'],"y");
				$serial_no=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['serial_number']));
				$charger_type=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['charger_type']));
				$voltage=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['voltage']));
				$charging_current=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['charging_current']));
				$high_voltage_cutoff=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['high_voltage_cut_off']));
				$voltage_ripple=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['voltage_ripple']));
				$voltage_regulation=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['voltage_regulation']));
				if(isset($update['charger_details']['charger_image'])){ $charger_pic = base64_to_file('charger_pic',$update['charger_details']['charger_image'],'doc');}else{$charger_pic='0';}
				$charger_sql = mysqli_query($mr_con,"INSERT INTO ec_charger_details(ticket_alias,charger_band,manf_date,serial_no,charger_type,voltage,charging_current,high_voltage_cutoff,voltage_ripple,voltage_regulation,charger_pic,item_alias)VALUES('$ticket_alias','$charger_band','$manf_date','$serial_no','$charger_type','$voltage','$charging_current','$high_voltage_cutoff','$voltage_ripple','$voltage_regulation','$charger_pic','$charger_alias')");	

				//forklift_details
				$forklift_alias = aliasCheck(generateRandomString(),'ec_fork_lift','item_alias');
				$fork_lift_brand=mysqli_real_escape_string($mr_con,strtoupper($update['forklift_details']['forklift_brand']));
				$fork_lift_model=mysqli_real_escape_string($mr_con,strtoupper($update['forklift_details']['forklift_model']));
				$fork_lift_manf_date=dateFormat($update['forklift_details']['forklift_manufacturing_date'],"y");
				if(isset($update['forklift_details']['forklift_image'])){$fork_lift_pic = base64_to_file('fork_lift_pic',$update['forklift_details']['forklift_image'],'doc');}else{$fork_lift_pic='0';}
				$forklift_sql = mysqli_query($mr_con,"INSERT INTO ec_fork_lift(ticket_alias,fork_lift_brand,fork_lift_model,fork_lift_manf_date,fork_lift_pic,item_alias)VALUES('$ticket_alias','$fork_lift_brand','$fork_lift_model','$fork_lift_manf_date','$fork_lift_pic','$forklift_alias')");	
				
				//battery_details
				$battey_alias = aliasCheck(generateRandomString(),'ec_battery_details','item_alias');
				$battey_type=mysqli_real_escape_string($mr_con,strtoupper($update['forklift_details']['battery_type']));
				$bank_serial_no=mysqli_real_escape_string($mr_con,strtoupper($update['forklift_details']['battery_bank_serial_number']));
				$manf_date=dateFormat($update['forklift_details']['manufacturing_date'],"y");
				$ins_date=dateFormat($update['forklift_details']['installation_date'],"y");
				$plug_type=mysqli_real_escape_string($mr_con,strtoupper($update['forklift_details']['plug_type']));
				$acid_level=mysqli_real_escape_string($mr_con,strtoupper($update['forklift_details']['acid_level']));
				$battey_sql = mysqli_query($mr_con,"INSERT INTO ec_battery_details(ticket_alias,battey_type,bank_serial_no,manf_date,ins_date,plug_type,acid_level,item_alias)VALUES('$ticket_alias','$battey_type','$bank_serial_no','$manf_date','$ins_date','$plug_type','$acid_level','$battey_alias')");	
			
			}elseif($segment_alias=="SMEY7SL24I" || $segment_alias=="W0PBT7IAZE"){ //UPS OR Power control
				
				//UPS-FSR/POWER Control-FSR
				$ups_alias = aliasCheck(generateRandomString(),'ec_technical_observation','item_alias');
				$float_voltage=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observations']['float_voltage']));
				$boast_voltage=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observations']['boast_voltage']));
				$current_limit=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observations']['current_limit']));
				$voltage_ripple=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observations']['voltage_ripple']));
				$voltage_regulation=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observations']['voltage_regulation']));
				$high_voltage_cutoff=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observations']['high_voltage_cut_off']));
				$low_voltage_cutoff=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observations']['low_voltage_cut_off']));
				$panel_make=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observations']['ups_make']));
				$panel_rating=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observations']['ups_rating']));
				$panel_manufacturing_date=dateFormat($update['ups_observations']['ups_manufacturing_date'],"y");
				$panel_installation_date=dateFormat($update['ups_observations']['ups_installtaion_date'],"y");
				if(isset($update['ups_observations']['float_voltage_image'])){$document_1 = base64_to_file('float_voltage_image_ups_pc',$update['ups_observations']['float_voltage_image'],'doc');}else{$document_1='0';}
				if(isset($update['ups_observations']['boast_voltage_image'])){$document_2 = base64_to_file('boast_voltage_image_ups_pc',$update['ups_observations']['boast_voltage_image'],'doc');}else{$document_2='0';}
				$ups_sql = mysqli_query($mr_con,"INSERT INTO ec_technical_observation(ticket_alias,float_voltage,boast_voltage,current_limit,voltage_ripple,voltage_regulation,high_voltage_cutoff,low_voltage_cutoff,panel_make,panel_rating,charge_controller_rate,charge_controller_make,no_solar_panels,single_panel_rating,panel_manufacturing_date,charge_control_manufacturing_date,panel_installation_date,item_alias,document_1,document_2,document_3,document_4,document_5)VALUES('$ticket_alias','$float_voltage','$boast_voltage','$current_limit','$voltage_ripple','$voltage_regulation','$high_voltage_cutoff','$low_voltage_cutoff','$panel_make','$panel_rating','0','0','0','0','$panel_manufacturing_date','0','$panel_installation_date','$ups_alias','$document_1','$document_2','0','0','0')");	

			}elseif($segment_alias=="KWJCZKSTBL" || $segment_alias=="DDEYO7NTTC"){ // Solar OR Telecom-Solar
				//Solar/Telecom-Solar
				$solar_telecom_alias = aliasCheck(generateRandomString(),'ec_technical_observation','item_alias');
				$float_voltage=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['float_voltage']));
				$boast_voltage=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['boast_voltage']));
				$current_limit=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['current_limit']));
				$voltage_ripple=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['voltage_ripple']));
				$voltage_regulation=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['voltage_regulation']));
				$high_voltage_cutoff=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['high_voltage_cut_off']));
				$low_voltage_cutoff=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['low_voltage_cut_off']));
				$panel_make=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['panel_make']));
				$panel_rating=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['panel_rating']));
				$charge_controller_rate=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['charger_controller_rating']));
				$charge_controller_make=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['charger_controller_make']));
				$no_solar_panels=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['number_of_solar_panels']));
				$single_panel_rating=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['single_panel_rating']));
				$panel_manufacturing_date=dateFormat($update['solar_panel_controller_observations']['panel_manufacturing_date'],"y");
				$charge_control_manufacturing_date=dateFormat($update['solar_panel_controller_observations']['charge_controller_manufacturing_date'],"y");
				$panel_installation_date=dateFormat($update['solar_panel_controller_observations']['panel_installation_date'],"y");
				if(isset($update['solar_panel_controller_observations']['float_voltage_image'])){$document_1 = base64_to_file('float_voltage_image_sa_ts',$update['solar_panel_controller_observations']['float_voltage_image'],'doc');}else{$document_1='0';}
				if(isset($update['solar_panel_controller_observations']['boast_voltage_image'])){$document_2 = base64_to_file('boast_voltage_image_sa_ts',$update['solar_panel_controller_observations']['boast_voltage_image'],'doc');}else{$document_2='0';}
				if(isset($update['solar_panel_controller_observations']['number_of_solar_panels_image'])){$document_3 = base64_to_file('number_of_solar_panels_image_sa_ts',$update['solar_panel_controller_observations']['number_of_solar_panels_image'],'doc');}else{$document_3='0';}
				$solar_telecom_sql = mysqli_query($mr_con,"INSERT INTO ec_technical_observation(ticket_alias,float_voltage,boast_voltage,current_limit,voltage_ripple,voltage_regulation,high_voltage_cutoff,low_voltage_cutoff,panel_make,panel_rating,charge_controller_rate,charge_controller_make,no_solar_panels,single_panel_rating,panel_manufacturing_date,charge_control_manufacturing_date,panel_installation_date,item_alias,document_1,document_2,document_3,document_4,document_5)VALUES('$ticket_alias','$float_voltage','$boast_voltage','$current_limit','$voltage_ripple','$voltage_regulation','$high_voltage_cutoff','$low_voltage_cutoff','$panel_make','$panel_rating','$charge_controller_rate','$charge_controller_make','$no_solar_panels','$single_panel_rating','$panel_manufacturing_date','$charge_control_manufacturing_date','$panel_installation_date','$solar_telecom_alias','$document_1','$document_2','$document_3','0','0')");
			}
			if($segment_alias!="TQMBDTF5ZI" && $segment_alias!="YGRKJJD4N7"){ // Neither Railways nor Motive power
				//physical_observations
				$physical_alias = aliasCheck(generateRandomString(),'ec_physical_observation','item_alias');
				$physical_damages =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['physical_damage']));
				$leakage =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['leakage']));
				$temperature =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['temperature']));
				$general_observation =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['general_observations']));
				$terminal_torque =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['terminal_torque']));
				$vent_plug =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['vent_plug']));
				if(isset($update['physical_observations']['physical_damage_image'])){$physical_damage_image = base64_to_file('physical_damage_image',$update['physical_observations']['physical_damage_image'],'doc');}else{$physical_damage_image ='0';}
				if(isset($update['physical_observations']['leakage_image'])){$leakage_image = base64_to_file('leakage_image',$update['physical_observations']['leakage_image'],'doc');}else{$leakage_image ='0';}
				$physical_sql = mysqli_query($mr_con,"INSERT INTO ec_physical_observation(ticket_alias,physical_damages,leakage,temperature,general_observation,terminal_torque,vent_plug_thickness,item_alias,physical_damages_document,leakage_document)VALUES('$ticket_alias','$physical_damages','$leakage','$temperature','$general_observation','$terminal_torque','$vent_plug','$physical_alias','$physical_damage_image','$leakage_image')");
				if($segment_alias=="HXL5A1HOTZ"){ // Telecom
					//smps_observations
					$smps_alias = aliasCheck(generateRandomString(),'ec_technical_observation','item_alias');
					$float_voltage =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['float_voltage']));
					$boast_voltage =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['boast_voltage']));
					$current_limit =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['current_limit']));
					$voltage_ripple =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['voltage_ripple']));
					$voltage_regulation=mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['lvd_status']));// LVD'S Status
					$high_voltage_cutoff =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['high_voltage_cutoff']));
					$low_voltage_cutoff =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['low_voltage_cutoff']));
					$panel_make =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['panel_make']));// SMPS Make
					$panel_rating =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['panel_rating']));// SMPS Rating
					$charge_controller_rate =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['smr_module_rating']));// SMR Moduls Rating(Amps)
					if(isset($update['smps_observations']['charge_controller_make'])){$charge_controller_make = base64_to_file('charge_controller_make',$update['smps_observations']['charge_controller_make'],'doc');}else{$charge_controller_make='0';}
					$no_of_solar_panels =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['no_of_working_modules']));// Number of Working Modules
					$single_panel_rating =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['smps_display']));// SMPS Display
					
					$panel_manf_date =dateFormat($update['smps_observations']['panel_manf_date'],"y"); //SMPS Manufacturing Date
					$charger_controller_manf_date=dateFormat($update['smps_observations']['charger_controller_manf_date'],"y");
					$panel_install_date=dateFormat($update['smps_observations']['panel_install_date'],"y");
					if(isset($update['smps_observations']['document_1'])){$document_1 = base64_to_file('document_1',$update['smps_observations']['document_1'],'doc');}else{$document_1='0';}
					if(isset($update['smps_observations']['document_2'])){$document_2 = base64_to_file('document_2',$update['smps_observations']['document_2'],'doc');}else{$document_2='0';}
					if(isset($update['smps_observations']['document_3'])){$document_3 = base64_to_file('document_3',$update['smps_observations']['document_3'],'doc');}else{$document_3='0';}
					if(isset($update['smps_observations']['document_4'])){$document_4 = base64_to_file('document_4',$update['smps_observations']['document_4'],'doc');}else{$document_4='0';}
					if(isset($update['smps_observations']['document_5'])){$document_5 = base64_to_file('document_5',$update['smps_observations']['document_5'],'doc');}else{$document_5='0';}
					$smps_sql = mysqli_query($mr_con,"INSERT INTO ec_technical_observation(ticket_alias,float_voltage,boast_voltage,current_limit,voltage_ripple,voltage_regulation,high_voltage_cutoff,low_voltage_cutoff,panel_make,panel_rating,charge_controller_rate,charge_controller_make,no_solar_panels,single_panel_rating,panel_manufacturing_date,charge_control_manufacturing_date,panel_installation_date,item_alias,document_1,document_2,document_3,document_4,document_5)VALUES('$ticket_alias','$float_voltage','$boast_voltage','$current_limit','$voltage_ripple','$voltage_regulation','$high_voltage_cutoff','$low_voltage_cutoff','$panel_make','$panel_rating','$charge_controller_rate','charge_controller_make','$no_of_solar_panels','$single_panel_rating','$panel_manf_date','$charger_controller_manf_date','$panel_install_date','$smps_alias','$document_1','$document_2','$document_3','$document_4','$document_5')");
				}
				//generator_observations
				$general_alias = aliasCheck(generateRandomString(),'ec_general_observation','item_alias');
				$site_load =mysqli_real_escape_string($mr_con,strtoupper($update['generator_observations']['site_load']));
				$dg_status =mysqli_real_escape_string($mr_con,strtoupper($update['generator_observations']['dg_status']));
				if(isset($update['generator_observations']['dg_make'])){$dg_make =mysqli_real_escape_string($mr_con,strtoupper($update['generator_observations']['dg_make']));}else{$dg_make='0';}
				if(isset($update['generator_observations']['dg_capacity'])){$dg_capacity =mysqli_real_escape_string($mr_con,$update['generator_observations']['dg_capacity']);}else{$dg_capacity='0';}
				$dg_working_condition =mysqli_real_escape_string($mr_con,strtoupper($update['generator_observations']['dg_working_condition']));
				$avg_dg_run =mysqli_real_escape_string($mr_con,strtoupper($update['generator_observations']['avg_dg_run']));
				if(isset($update['generator_observations']['dg_pic'])){$dg_pic = base64_to_file('dg_pic',$update['generator_observations']['dg_pic'],'doc');}else{$dg_pic='0';}
				$general_sql = mysqli_query($mr_con,"INSERT INTO ec_general_observation(ticket_alias,site_load,dg_status,dg_make,dg_capacity,dg_working_condition,avg_dg_run,item_alias,dg_pic)VALUES('$ticket_alias','$site_load','$dg_status','$dg_make','$dg_capacity','$dg_working_condition','$avg_dg_run','$general_alias','$dg_pic')");

				//power_observation
				$power_alias = aliasCheck(generateRandomString(),'ec_power_observation','item_alias');
				$eb_supply =mysqli_real_escape_string($mr_con,strtoupper($update['generator_observations']['eb_supply_availability']));
				$failures_per_day =mysqli_real_escape_string($mr_con,strtoupper($update['generator_observations']['failures_per_day']));
				$avg_power_cut =mysqli_real_escape_string($mr_con,strtoupper($update['generator_observations']['avg_power_cut_hrs_in_day']));
				$power_sql = mysqli_query($mr_con,"INSERT INTO ec_power_observation(ticket_alias,eb_supply,failures_per_day,avg_power_cut,item_alias)VALUES('$ticket_alias','$eb_supply','$failures_per_day','$avg_power_cut','$power_alias')");
			}
			//Battery Observation
			$faulty_cell_sr_no =mysqli_real_escape_string($mr_con,strtoupper(trim($update['serviceengineer_observations']['faulty_cell_serial_number'])));
			$faulty_code_alias =mysqli_real_escape_string($mr_con,alias(trim($update['serviceengineer_observations']['faulty_code']),'ec_faulty_code','description','faulty_alias'));
			for($j=0;$j<count($update['battery_observation']);$j++){
				if($j<2){
					$battery_bank_bb_alias = aliasCheck(generateRandomString(),'ec_battery_bank_bb_cap','item_alias');
					$battery_bank_rating =mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j]['battery_bank_rating']));
					$bb_capacity =mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j]['bb_capacity']));
					if(isset($update['battery_observation'][$j]['battery_report_image'])){$battery_report_image = base64_to_file('battery_report_image',$update['battery_observation'][$j]['battery_report_image'],'battery');}else{$battery_report_image='0';}
					if(isset($update['battery_observation'][$j]['battery_report_image_2'])){$battery_report_image_2 = base64_to_file('battery_report_image_2',$update['battery_observation'][$j]['battery_report_image_2'],'battery_2');}else{$battery_report_image_2='0';}
					$battery_bank_bb_sql=mysqli_query($mr_con,"INSERT INTO ec_battery_bank_bb_cap(ticket_alias,battery_bank_rating,bb_capacity,image,image_2,item_alias)VALUES('$ticket_alias','$battery_bank_rating','$bb_capacity','$battery_report_image','$battery_report_image_2','$battery_bank_bb_alias')");
					for($i=0;$i<count($update['battery_observation'][$j]['cell_sl_no']);$i++){
						$battery_alias = aliasCheck(generateRandomString(),'ec_bo_telecom_ic','item_alias');
						$cell_sl_no =mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j]['cell_sl_no'][$i]));
						$mf_date =mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j]['mf_date'][$i]));
						if(strpos($faulty_cell_sr_no,trim($cell_sl_no))!== false){
							$fal_alias = aliasCheck(generateRandomString(),'ec_fsr_faulty_cells','item_alias');
							$fal_sql = mysqli_query($mr_con,"INSERT INTO ec_fsr_faulty_cells(ticket_alias,cell_sl_no,mf_date,faulty_code_alias,item_alias,fsr_type)VALUES('$ticket_alias','$cell_sl_no','$mf_date','$faulty_code_alias','$fal_alias','1')");
						}
						if($segment_alias=="YGRKJJD4N7"){
							$acid_density = mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j]['acid_density'][$i]));
						}else{$acid_density = '0';}
						//if(isset($update['battery_observation'][$j]['ocv']['ocv'])){
							$ocv =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['ocv']['ocv'][$i]);
						//}else{ $ocv =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['ocv'][$i]);}
						$hr1 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_1']['hr1'][$i]);
						$hr2 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_1']['hr2'][$i]);
						$hr3 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_1']['hr3'][$i]);
						$hr4 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_1']['hr4'][$i]);
						$hr5 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_1']['hr5'][$i]);
						$hr6 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_1']['hr6'][$i]);
						$hr7 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_1']['hr7'][$i]);
						$hr8 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_1']['hr8'][$i]);
						$hr9 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_1']['hr9'][$i]);
						$hr10 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_1']['hr10'][$i]);
						
						$hr11 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['discharge_voltage']['hr1'][$i]);
						$hr12 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['discharge_voltage']['hr2'][$i]);
						$hr13 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['discharge_voltage']['hr3'][$i]);
						$hr14 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['discharge_voltage']['hr4'][$i]);
						$hr15 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['discharge_voltage']['hr5'][$i]);
						$hr16 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['discharge_voltage']['hr6'][$i]);
						$hr17 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['discharge_voltage']['hr7'][$i]);
						$hr18 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['discharge_voltage']['hr8'][$i]);
						$hr19 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['discharge_voltage']['hr9'][$i]);
						$hr20 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['discharge_voltage']['hr10'][$i]);
						
						$hr21 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_2']['hr1'][$i]);
						$hr22 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_2']['hr2'][$i]);
						$hr23 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_2']['hr3'][$i]);
						$hr24 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_2']['hr4'][$i]);
						$hr25 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_2']['hr5'][$i]);
						$hr26 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_2']['hr6'][$i]);
						$hr27 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_2']['hr7'][$i]);
						$hr28 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_2']['hr8'][$i]);
						$hr29 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_2']['hr9'][$i]);
						$hr30 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_2']['hr10'][$i]);
						
						$remarks =mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j]['remarks'][$i]));
						$battery_sql = mysqli_query($mr_con,"INSERT INTO ec_bo_telecom_ic(cell_sl_no,mf_date,ocv,acid_density,1hr,2hr,3hr,4hr,5hr,6hr,7hr,8hr,9hr,10hr,11hr,12hr,13hr,14hr,15hr,16hr,17hr,18hr,19hr,20hr,21hr,22hr,23hr,24hr,25hr,26hr,27hr,28hr,29hr,30hr,battery_bb_alias,item_alias,remarks)VALUES('$cell_sl_no','$mf_date','$ocv','$acid_density','$hr1', '$hr2', '$hr3', '$hr4', '$hr5', '$hr6', '$hr7', '$hr8', '$hr9', '$hr10', '$hr11', '$hr12', '$hr13', '$hr14', '$hr15', '$hr16', '$hr17', '$hr18', '$hr19', '$hr20', '$hr21', '$hr22', '$hr23', '$hr24', '$hr25', '$hr26', '$hr27', '$hr28', '$hr29', '$hr30', '$battery_bank_bb_alias','$battery_alias','$remarks')");
					}
					//bo header
						$headers='ocv';//mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j]['ocv']['headers'][0]));
						$total_voltage=mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j]['ocv']['total_voltage'][0]));
						$temperature=mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j]['ocv']['temperature'][0]));
						$charging_current=mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j]['ocv']['charging_current'][0]));
						$bo_header_sql=mysqli_query($mr_con,"INSERT INTO ec_bo_headers(header,total_voltage,temperature,charging_current,item_alias,type)VALUES('$headers','$total_voltage','$temperature','$charging_current','$battery_bank_bb_alias','$headers')");
						
					$arr = array('on_charge_voltage_1','discharge_voltage','on_charge_voltage_2');
					foreach($arr as $voltage){
						for($k=0;$k<count($update['battery_observation'][$j][$voltage]['headers']);$k++){
							if(!empty($update['battery_observation'][$j][$voltage]['headers'][$k])){
								$headers=mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j][$voltage]['headers'][$k]));
								$total_voltage=mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j][$voltage]['total_voltage'][$k]));
								$temperature=mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j][$voltage]['temperature'][$k]));
								$charging_current=mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j][$voltage]['charging_current'][$k]));
								$bo_header_sql=mysqli_query($mr_con,"INSERT INTO ec_bo_headers(header,total_voltage,temperature,charging_current,item_alias,type)VALUES('$headers','$total_voltage','$temperature','$charging_current','$battery_bank_bb_alias','$voltage')");
							}
						}
					}
				}
			}
			//serviceengineer_observations
			$engineer_alias = aliasCheck(generateRandomString(),'ec_engineer_observation','item_alias');
			$faulty_cell_sr_no =mysqli_real_escape_string($mr_con,strtoupper(trim($update['serviceengineer_observations']['faulty_cell_serial_number'])));
			$faulty_code_alias =mysqli_real_escape_string($mr_con,alias(trim($update['serviceengineer_observations']['faulty_code']),'ec_faulty_code','description','faulty_alias'));
			$req_acc=mysqli_real_escape_string($mr_con,$update['serviceengineer_observations']['req_acc']);
			$req_cells=mysqli_real_escape_string($mr_con,$update['serviceengineer_observations']['req_cells']);
			
			$total_faulty_count=req_cel_acc($ticket_alias,$req_cells,'1');
			$total_acc_count=req_cel_acc($ticket_alias,$req_acc,'2');
			
			$job_performed =mysqli_real_escape_string($mr_con,strtoupper($update['serviceengineer_observations']['job_performed']));
			$remarks =mysqli_real_escape_string($mr_con,strtoupper($update['serviceengineer_observations']['remarks']));
			$action_taken =mysqli_real_escape_string($mr_con,strtoupper($update['serviceengineer_observations']['action_taken']));
			//Requested cells
			$request_cell=$update['serviceengineer_observations']['request_cell'];
			$replaced_cell_no="";
			if(isset($request_cell) && count($request_cell)){
				if(!in_array("No Replaced Cells",$request_cell)){$zx="";
					for($aa=0;$aa<count($request_cell);$aa++){
						//$zx.=alias(trim($update['serviceengineer_observations']['request_cell'][$aa]['item_description']),'ec_item_code','item_description','item_code_alias').", ";
						$zx.=trim($update['serviceengineer_observations']['request_cell'][$aa]['item_description']).", ";
					}$replaced_cell_no = rtrim($zx,", ");
				}
			}
			$faulty_cell_sr_no=str_replace(",",", ",str_replace(" ","",$faulty_cell_sr_no));
			$engineer_sql = mysqli_query($mr_con,"INSERT INTO ec_engineer_observation(ticket_alias,faulty_cell_sr_no,faulty_code_alias,req_acc,req_cells,total_faulty_count,job_performed,replaced_cell_no,item_alias)VALUES('$ticket_alias','$faulty_cell_sr_no','$faulty_code_alias','$req_acc','$req_cells','$total_faulty_count','$job_performed','$replaced_cell_no','$engineer_alias')");		
			$remark_alias = aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
			$remark_sql = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','TT','8','$ticket_alias','$service_engineer_alias','$remark_alias')");
			$action_alias = aliasCheck(generateRandomString(),'ec_ticket_action','item_alias');
			$action_sql = mysqli_query($mr_con,"INSERT INTO ec_ticket_action(ticket_alias,observation,item_alias)VALUES('$ticket_alias','$action_taken','$action_alias')");
			//Customer comments
			$customer_comments_alias = aliasCheck(generateRandomString(),'ec_customer_comments','item_alias');
			$customer_comments =mysqli_real_escape_string($mr_con,strtoupper($update['customer_satisfaction']['customer_comments']));
			$customer_comments_sql = mysqli_query($mr_con,"INSERT INTO ec_customer_comments(ticket_alias,customer_comments,item_alias)VALUES('$ticket_alias','$customer_comments','$customer_comments_alias')");
			//Customer_satisfaction
			$customer_satisfaction_alias = aliasCheck(generateRandomString(),'ec_customer_satisfaction','item_alias');
			$rating1 =mysqli_real_escape_string($mr_con,$update['customer_satisfaction']['rating1']);
			$rating2 =mysqli_real_escape_string($mr_con,$update['customer_satisfaction']['rating2']);
			$rating3 =mysqli_real_escape_string($mr_con,$update['customer_satisfaction']['rating3']);
			$rating4 =mysqli_real_escape_string($mr_con,$update['customer_satisfaction']['rating4']);
			$rating5 =mysqli_real_escape_string($mr_con,$update['customer_satisfaction']['rating5']);
			$customer_satisfaction_sql = mysqli_query($mr_con,"INSERT INTO ec_customer_satisfaction(ticket_alias,q1,q2,q3,q4,q5,item_alias)VALUES('$ticket_alias','$rating1','$rating2','$rating3','$rating4','$rating5','$customer_satisfaction_alias')");
			//esignature
			$e_signature_alias = aliasCheck(generateRandomString(),'ec_e_signature','item_alias');
			$name =mysqli_real_escape_string($mr_con,strtoupper($update['e_signature']['name']));
			$email =mysqli_real_escape_string($mr_con,$update['e_signature']['user_email']);
			$designation =mysqli_real_escape_string($mr_con,strtoupper($update['e_signature']['designation']));
			$contact_number =mysqli_real_escape_string($mr_con,$update['e_signature']['contact_number']);
			if(isset($update['e_signature']['signature_image'])){$signature_image = base64_to_file('customer_signature',$update['e_signature']['signature_image'],'sign');}else{$signature_image ='0';}
			if(isset($update['e_signature']['user_photo'])){$user_photo = base64_to_file('customer_photo',$update['e_signature']['user_photo'],'photo');}else{$user_photo ='0';}
			if(isset($update['serviceengineer_observations']['engineer_photo'])){$engineer_photo = base64_to_file('engineer_photo',$update['serviceengineer_observations']['engineer_photo'],'photo');}else{$engineer_photo ='0';}
			if(isset($update['serviceengineer_observations']['engineer_signature'])){$engineer_sign = base64_to_file('engineer_signature',$update['serviceengineer_observations']['engineer_signature'],'sign');}else{$engineer_sign ='0';}
			$e_signature_sql = mysqli_query($mr_con,"INSERT INTO ec_e_signature(ticket_alias,name,email,designation,contact_number,photo,e_signature,item_alias,engineer_photo,engineer_sign)VALUES('$ticket_alias','$name','$email','$designation','$contact_number','$user_photo','$signature_image','$e_signature_alias','$engineer_photo','$engineer_sign')");
			//customer details update in sitemaster
			$cu = "";
			if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){$cu = "manager_mail='$email', ";}
			if(!empty($contact_number)){$cu .= "manager_number='$contact_number', ";}
			$e_customer_sql = mysqli_query($mr_con,"UPDATE ec_sitemaster SET $cu flag='0' WHERE site_alias='$site_alias' AND flag='0'");
			//tickets update
			$dat = date("Y-m-d H:i:s");
			$efsr_no = efsrNoCheck(efsrRandomNo());
			$update = mysqli_query($mr_con,"UPDATE ec_tickets SET level='3',old_level='2',status='VISITED',closing_date='".$dat."',tat='".tat($ticket_alias)."',efsr_no='".$efsr_no."',efsr_date='".$dat."',transaction_date='".date('Y-m-d')."',n_visits=(n_visits+1) WHERE ticket_alias='$ticket_alias'");
			if($update){
				$ticket_id=alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
				$serNum=alias(alias($ticket_alias,'ec_tickets','ticket_alias','service_engineer_alias'),'ec_employee_master','employee_alias','mobile_number');
				$custNum=alias(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','technician_number');
				$custMsg=urlencode("Greetings from Enersys, Against against Ticket No-".$ticket_id." SE Mob-".$serNum." has completed the Site visit and status will be updated Shortly.");
				messageSent($custNum,$custMsg);
				if(!empty($faulty_cell_sr_no))$acc_inv = mysqli_query($mr_con,"UPDATE ec_tickets_inventory SET material_inward='1' WHERE ticket_alias='$ticket_alias' AND flag='0'");
				ticket_notification($ticket_alias,"Site Visited");
				if($segment_alias=="HXL5A1HOTZ")file_get_contents("http://enersyscare.co.in/enersyscare_V2/mailling.php?ticketAlias=".$ticket_alias);
				echo '{"err_details":{"err_code":0,"err_message":"Success"}}';
			}else{echo '{"err_details":{"err_code":-4,"err_message":"Not Success"}}';}
		}else{echo '{"err_details":{"err_code":-4,"err_message":"Ticket Already Submitted"}}';}
		}elseif($rex=='-3'){echo '{"err_details":{"err_code":-3,"err_message":"account locked"}}';}
		elseif($rex=='-2'){echo '{"err_details":{"err_code":-2,"err_message":"device not matched"}}';}
		else{echo '{"err_details":{"err_code":-1,"err_message":"authentication failed"}}';}
}
function req_cel_acc($ticket_alias,$req_cells,$item_type){ global $mr_con;
	$cell_alias = array(); $quanty = array();
	if(!empty($req_cells)){
		$plane = str_replace(")","",str_replace("(","",$req_cells));
		if(strpos($req_cells,",")!== false){
			$a = explode(", ",$plane);
			foreach($a as $b){
				list($cell, $quan) = explode("-",$b);
				if($item_type=='1')$cell_alias[] = alias(trim($cell),'ec_product','battery_rating','product_alias');
				else $cell_alias[] = alias(trim($cell),'ec_accessories','accessory_description','accessories_alias');
				$quanty[] =$quan;
			}					
		}else{
			list($cell, $quan) = explode("-",$plane);
			if($item_type=='1')$cell_alias[] = alias(trim($cell),'ec_product','battery_rating','product_alias');
			else $cell_alias[] = alias(trim($cell),'ec_accessories','accessory_description','accessories_alias');
			$quanty[] =$quan;
		}
		for($i=0;$i<count($cell_alias);$i++){
			$cell_alia=trim($cell_alias[$i]);
			$quant=trim($quanty[$i]);
			if(!empty($cell_alia) && $cell_alia!='NA' && !empty($quant)){
				$alias=aliasCheck(generateRandomString(),'ec_cell_required','item_alias');
				$sqlReq = mysqli_query($mr_con,"INSERT INTO ec_cell_required(ticket_alias,item_type,cell_alias,quanty,item_alias)VALUES('$ticket_alias','$item_type','$cell_alia','$quant','$alias')");
			}
		}
		if($item_type=='1')$total_faulty_count = array_sum($quanty);
	}else{$total_faulty_count = 0;}
	return $total_faulty_count;
}
function ticket_notification($ticket_alias,$msgg){ global $mr_con;
	$notif_alias=aliasCheck(generateRandomString(),'ec_notifications','notif_alias');
	$ticket_id=alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
	$level=alias($ticket_alias,'ec_tickets','ticket_alias','level');
	$state_alias=alias(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','state_alias');
	$type_ref='1';
	$sql1=mysqli_query($mr_con,"INSERT INTO ec_notifications(employee_alias,title_ticket,msg_stage,type_ref,notif_alias) VALUES('ADMIN','$ticket_alias','$level','$type_ref','$notif_alias')");
	$sql = mysqli_query($mr_con,"SELECT employee_alias FROM ec_employee_master WHERE state_alias LIKE '%".$state_alias."%' AND flag=0");
	if(mysqli_num_rows($sql)){
		while($row = mysqli_fetch_array($sql)){
			$sql2=mysqli_query($mr_con,"INSERT INTO ec_notifications(employee_alias,title_ticket,msg_stage,type_ref,notif_alias) VALUES('".$row['employee_alias']."','$ticket_alias','$level','$type_ref','$notif_alias')");
			if($sql2){
				if($level < '2'){
					$reg_id = alias($emp,'ec_employee_master','employee_alias','reg_id');			
					notification($reg_id,$ticket_id." ".$msgg);
				}
			}
		}
	}
}

/*function returnFalse($sql,$del,$ticket_alias){ global $mr_con;
	if(!$sql){
		$delSql = mysqli_query($mr_con,"DELETE FROM $del WHERE ticket_alias='$ticket_alias' AND flag=0");
		return FALSE;
	}else{ return TRUE; }
}*/
function dateFormat($date,$x){ global $mr_con;
	if(preg_match("/\d{4}\-\d{2}-\d{2}/", $date) || preg_match("/\d{2}\-\d{2}-\d{4}/", $date)){
		if($date=='0000-00-00' || $date=='00-00-0000'){ $y = 'NA';}
		elseif($x=="m"){ $y = date("m-d-Y", strtotime(mysqli_real_escape_string($mr_con,$date)));}
		else{ $y = date(($x=="d" ? "d-m-Y" : "Y-m-d"), strtotime(mysqli_real_escape_string($mr_con,$date)));}
		if(strpos($y,'1970')!==false){$y = 'NA';}
	}else{$y = 'NA';}
	return $y;
}
function dateTimeFormat($date_time,$x){ global $mr_con;
	if(preg_match("/\d{4}\-\d{2}\-\d{2} \d{2}\:\d{2}\:\d{2}/", $date_time) || preg_match("/\d{2}\-\d{2}\-\d{4} \d{2}\:\d{2}\:\d{2}/", $date_time)){
		if($date_time=='0000-00-00 00:00:00' || $date_time=='00-00-0000 00:00:00'){ $y = 'NA';}
		elseif($x=="m"){ $y = date("m-d-Y H:i:s", strtotime(mysqli_real_escape_string($mr_con,$date_time)));}
		else{ $y = date(($x=="d" ? "d-m-Y H:i:s" : "Y-m-d H:i:s"), strtotime(mysqli_real_escape_string($mr_con,$date_time)));}
		if(strpos($y,'1970')!==false){$y = 'NA';}
	}else{$y = 'NA';}
	return $y;
}
function base64_to_file($name,$base,$ref){
	if($ref=='doc'){$path='../../efsr_reports/reports_images/'.$name.'_'.date('Y-m-d_h_i_s').'.jpg';}
	elseif($ref=='sign'){$path='../../efsr_reports/cust_engineer_images/sign_images/'.$name.'_'.date('Y-m-d_h_i_s').'.jpg';}
	elseif($ref=='photo'){$path='../../efsr_reports/cust_engineer_images/'.$name.'_'.date('Y-m-d_h_i_s').'.jpg';}
	else{$path='../../efsr_reports/reports_images/'.$name.'_'.date('Y-m-d_h_i_s').'.png';}
	$ss = file_put_contents($path, base64_decode($base));
	if($ss)return $path;else return '0';
}
function efsrRandomNo($length = 5) {
		$characters = '012345';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++){$randomString .= $characters[rand(0, $charactersLength - 1)];}
		return $randomString;
}
function efsrNoCheck($fv1){ global $mr_con;
		$rec=$mr_con->query("SELECT efsr_no FROM ec_tickets WHERE efsr_no='$fv1'");
		if($rec->num_rows==0)return $fv1; else return efsrNoCheck(efsrRandomNo());
}
function tat($ticket_alias){ global $mr_con;
	$query=mysqli_query($mr_con,"SELECT login_date,closing_date FROM ec_tickets WHERE ticket_alias='$ticket_alias'");
	if(mysqli_num_rows($query)>0){
		$row=mysqli_fetch_array($query);
		$r1=date_create($row['login_date']);
		$r2=date_create($row['closing_date']);
		date_default_timezone_set("Asia/Kolkata");
		if($r2=="" || $r2=="0000-00-00"){$r2=date_create(date('Y-m-d'));}
		$diff=date_diff($r1,$r2);
		if($diff->format("%R%a") < 16){return "TAT-1";}
		elseif($diff->format("%R%a") > 15 && $diff->format("%R%a") < 26){return "TAT-2";}
		elseif($diff->format("%R%a") > 25){return "TAT-3";}
		/*return $diff->format("%R%a");*/
	}
}
function messageSent($num,$msg){
	if(preg_match("/\d{10}/", $num)){
		$chu = curl_init();
		curl_setopt($chu, CURLOPT_URL, "http://bhashsms.com/api/sendmsg.php?user=enersyscare&pass=sairaam@5050&sender=EnrSys&phone=".$num."&text=".$msg."&priority=ndnd&stype=normal");
		curl_setopt($chu, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($chu, CURLOPT_TIMEOUT, 1);
		curl_exec($chu);
		curl_close($chu);
	}
}
function color($a,$b){
	switch($b){
		case '1': $xyz=($a=='WORKING' ? '#2a6496' : '#FF0000');break;
		case '2': $xyz=($a=='NO' ? '#2a6496' : '#FF0000');break;
		case '3': $xyz=($a=='CORRECT' ? '#2a6496' : '#FF0000');break;
		case '4': $xyz=($a=='SET AT RIGHT VOLTAGE' ? '#2a6496' : '#FF0000');break;
		case '5': $xyz=($a=='AVAILABLE' ? '#2a6496' : '#FF0000');break;
		case '6': $xyz=($a=='NORMAL' || $a=='LOW'? '#2a6496' : '#FF0000');break;
		case '7': $xyz='#2a6496';break;
		case '8': $xyz=($a=='MATCHED TO BATTERY' ? '#2a6496' : '#FF0000');break;
	}
	//return "style='color:".$xyz."'";
	return "style='".($xyz=='#FF0000' ? 'font-weight:bold;' : '')."color:".$xyz."'";
}
function dpr(){ global $mr_con;
	date_default_timezone_set("Asia/Kolkata");
	$request = \Slim\Slim::getInstance()->request();
	$dpr_check = urldecode($request->getBody());
	$update = json_decode(urldecode($request->getBody()));
	$emp_id=$update->emp_id;
	$device=$update->device_id;
	$rex=putToken($device,$emp_id);
		//Obj
			$dpr_check = $dpr_check."_".date('Y_m_d_H_i_s')."\r\n\r\n";
			$fh = fopen("dpr_objects/DPR.txt", 'a') or die("can't open file");
			fwrite($fh, $dpr_check);
			fclose($fh);
		//obj
	if($rex=='0'){
		$emp_alias = alias($emp_id,'ec_employee_master','employee_id','employee_alias');
		$category = mysqli_real_escape_string($mr_con,$update->category_alias);
		$remarks = mysqli_real_escape_string($mr_con,$update->remarks);
		$expense_incurred = mysqli_real_escape_string($mr_con,$update->expense_incurred);
		if(empty($category)){$res = "Please Select Category";}
		elseif(empty($remarks)){$res = "Enter Remarks";}
		elseif(empty($expense_incurred)){$res = "Enter Expense Incurred";}
		else{
			$sql = mysqli_query($mr_con,"SELECT id FROM ec_dpr WHERE emp_alias='$emp_alias' AND sub_date_time LIKE '%".date('Y-m-d')."%' AND flag='0'");
			if(mysqli_num_rows($sql) == '0'){$lat=0;$lng=0;
				$dpr_ref_no = dpr_ref_no();
				$dpr_alias = aliasCheck(generateRandomString(),'ec_dpr','dpr_alias');
				$lat = mysqli_real_escape_string($mr_con,$update->lat);
				$lng = mysqli_real_escape_string($mr_con,$update->lan);
				$tracking_alias = aliasCheck(generateRandomString(),'ec_user_tracking','tracking_alias');
				$category_alias = alias($category,'ec_dpr_category','category','category_alias');
				$dpr_address=getAddress($lat,$lng);
				$sql_dpr = mysqli_query($mr_con,"INSERT INTO ec_dpr(dpr_ref_no,emp_alias,category_alias,remarks,expense_incurred,tracking_alias,dpr_address,dpr_alias)VALUES('$dpr_ref_no','$emp_alias','$category_alias','$remarks','$expense_incurred','$tracking_alias','$dpr_address','$dpr_alias')");
				$sql_ut = mysqli_query($mr_con,"INSERT INTO ec_user_tracking(employee_alias,lat,lng,type,tracking_alias)VALUES('$emp_alias','$lat','$lng','0','$tracking_alias')");
				if($sql_dpr){
					//event starts
					$created_on = date('Y-m-d');
					$scheduled_on = date('Y-m-d H:i:s');
					/*$state_alias =alias($emp_alias,'ec_employee_master','employee_alias','state_alias');
					if(!empty($state_alias)){
						$sqlEsca = mysqli_query($mr_con,"SELECT employee_alias FROM ec_employee_master WHERE privilege_alias='OX5E3EMI0U' AND state_alias RLIKE '".str_replace(", ","|",$state_alias)."' AND flag='0'");
						if(mysqli_num_rows($sqlEsca)>0){
							$rowesca=mysqli_fetch_array($sqlEsca);
							$zhs_alias= $rowesca['employee_alias'];
						}else{ $zhs_alias= "";}
					}else{ $zhs_alias= "";}*/
					$se_item_alias = aliasCheck(generateRandomString(),'ec_calender_event','alias');
					$sql_se = mysqli_query($mr_con,"INSERT INTO ec_calender_event(event_type,event_alias,created_on,scheduled_on,emp_alias,alias,p_level)VALUES('2','$dpr_alias','$created_on','$scheduled_on','$emp_alias','$se_item_alias','3')");
					/*$zhs_item_alias = aliasCheck(generateRandomString(),'ec_calender_event','alias');
					$sql_zhs = mysqli_query($mr_con,"INSERT INTO ec_calender_event(event_type,event_alias,created_on,scheduled_on,emp_alias,alias)VALUES('2','$dpr_alias','$created_on','$scheduled_on','$zhs_alias','$zhs_item_alias')");*/
					//if($sql_se && $sql_zhs){ $resCode='0'; $resMsg="Successful";}else{ $resCode='-5'; $resMsg="Your request is not Submitted"; }
					//event ends
					$resCode='0'; $resMsg="Thank You! Your DPR for ".date('d-m-Y')." has been Successful. Your DPR Number is ".$dpr_ref_no; dpr_mail($dpr_alias);
				}else{ $resCode='-5'; $resMsg="Your DPR request is not Submitted"; }
			}else{ $resCode='-4'; $resMsg="Sorry! Your DPR request is not Successful. You can Submit only once in a day."; }
		}
	}
	elseif($rex=='-3'){$resCode='-3';$resMsg='account locked';}
	elseif($rex=='-2'){$resCode='-2';$resMsg='device not matched';}
	else{$resCode='-1';$resMsg='authentication failed';}
	if(isset($res)){$resCode='-5';$resMsg=$res;}
	$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function dpr_category(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$update = json_decode($request->getBody());
	$emp_id=$update->emp_id;
	$device=$update->device_id;
	$rex=putToken($device,$emp_id);
	if($rex=='0'){
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_dpr_category WHERE flag=0");
		if(mysqli_num_rows($sql)){
			$i=0;while($row = mysqli_fetch_array($sql)){
				$result['dpr_cat'][$i]['category_alias'] = $row['category_alias'];
				$result['dpr_cat'][$i]['category'] = $row['category'];
			$i++;}
		}else{
			$result['dpr_category']['category_alias'] = '';
			$result['dpr_category']['category'] = 'No Records Found';
		}
	}
	elseif($rex=='-3'){$resCode='-3';$resMsg='account locked';}
	elseif($rex=='-2'){$resCode='-2';$resMsg='device not matched';}
	else{$resCode='-1';$resMsg='authentication failed';}
	$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function dpr_ref_no($i=1){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT dpr_ref_no FROM ec_dpr WHERE flag='0'");
	$num = (mysqli_num_rows($sql)+$i); $arr = array();
	if($num > 999){$x = "DPR".$num;}
	if($num > 99){$x = "DPR0".$num;}
	elseif($num > 9){$x = "DPR00".$num;}
	else{$x = "DPR000".$num;}
	$newDPR = preg_replace('/\D/', '', $x); 
	while($dpr = mysqli_fetch_array($sql)){
		$oldDPR = preg_replace('/\D/', '', $dpr['dpr_ref_no']);
		if($oldDPR==$newDPR){ $arr[] = $oldDPR;}
	}
	if(count($arr)==0){ return $x; }
	else{return dpr_ref_no(($i+1)); }
}
function dpr_mail($dpr_alias){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_dpr WHERE dpr_alias='$dpr_alias' AND flag='0'");
	if(mysqli_num_rows($sql)>0){
		$row = mysqli_fetch_array($sql);
		$dpr_ref_no = $row['dpr_ref_no'];
		$emp_alias = $row['emp_alias'];
		$category = (!empty($row['category_alias']) ? alias($row['category_alias'],'ec_dpr_category','category_alias','category') : 'DPR NOT SUBMITTED');
		$remarks = $row['remarks'];
		$expense_incurred = $row['expense_incurred'];
		$sub_date_time = $row['sub_date_time'];
		//$lat = alias($row['tracking_alias'],'ec_user_tracking','tracking_alias','lat');
		//$lng = alias($row['tracking_alias'],'ec_user_tracking','tracking_alias','lng');
		$se_sql = mysqli_query($mr_con,"SELECT employee_id,name,state_alias,designation_alias,department_alias,email_id FROM ec_employee_master WHERE employee_alias='$emp_alias' AND flag='0'");
		if(mysqli_num_rows($se_sql)){
			$se_row = mysqli_fetch_array($se_sql);
			$se_id = $se_row['employee_id'];
			$se_name = $se_row['name'];
			$se_state = $se_row['state_alias'];
			if(!empty($se_state)){ $con = "state_alias RLIKE '".str_replace(", ","|",$se_state)."' AND"; }else{$con = "";}
			$se_designation = alias($se_row['designation_alias'],'ec_designation','designation_alias','designation');
			$se_department = alias($se_row['department_alias'],'ec_department','department_alias','department_name');
			$se_mail = $se_row['email_id'];
			$sqlEsca = mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='OX5E3EMI0U' AND $con flag='0'");
			if(mysqli_num_rows($sqlEsca)>0 && !empty($con)){
				$rowesca=mysqli_fetch_array($sqlEsca);
				$zhsmail= $rowesca['email_id'];
			}else{ $zhsmail= "";}
		$se_mail = (!empty($se_mail) && filter_var($se_mail, FILTER_VALIDATE_EMAIL) ? $se_mail : "");
		$to_mail_id = $se_mail.(!empty($zhsmail) && filter_var($zhsmail, FILTER_VALIDATE_EMAIL) ? ", ".$zhsmail : "");
		$ccmail = 'ticket@enersys.co.in';
		$sub = "DPR @ $se_name @ $sub_date_time";
		$res="<p>Dear Team,</p>";
		$res.="<table width='600px' style='border-collapse:collapse;' cellpadding='3' align='center'>";
			$res.="<tr align='center'>";
				$res.="<th align='center' style='border:1px solid #ddd; border-bottom:1px solid #fff;'>";
					$res.="<table width='100%'>";
						$res.="<tr>";
							$res.="<th align='left'><img src='http://enersyscare.co.in/enersys_expense/img/EnerSyslogo.png' alt='EnerSys_logo' width='150'></th>";
							$res.="<th align='right'><h3>EnerSys India Batteries Pvt. Ltd.</h3></th>";
						$res.="</tr>";
					$res.="</table>";
				$res.="</th>";
			$res.="</tr>";
			$res.="<tr>";
				$res.="<td align='center' style='border:1px solid #ddd;'>";
					$res.="<table width='100%' cellpadding='3'>";
						$res.="<tr>";
							$res.="<td width='50%'></td>";
							$res.="<td align='left' width='20%'><b>DPR Date <br>DPR No </b></td>";
							$res.="<td align='left' width='30%'>: ".$sub_date_time."<br>: ".$dpr_ref_no."</td>";
						$res.="</tr>";
					$res.="</table>";
					$res.="<table width='100%' cellpadding='3'>";
						$res.="<tr>";
							$res.="<td align='center'><h3>Daily Progress Report</h3></td>";
						$res.="</tr>";
					$res.="</table>";
					$res.="<table style='border-collapse:collapse;' cellpadding='8' align='center'>";
						$res.="<tr>";
							$res.="<td width='50%' style='border:1px solid #ddd;'><b>Employee ID : </b>".strtoupper($se_id)."</td>";
							$res.="<td width='50%' style='border:1px solid #ddd;'><b>Employee Name : </b>".strtoupper($se_name)."</td>";
						$res.="</tr>";
						$res.="<tr>";
							$res.="<td style='border:1px solid #ddd;'><b>Department : </b>".strtoupper($se_department)."</td>";
							$res.="<td style='border:1px solid #ddd;'><b>Designation : </b>".strtoupper($se_designation)."</td>";
						$res.="</tr>";
						$res.="<tr>";
							$res.="<td style='border:1px solid #ddd;'><b>DPR Category : </b>".$category."</td>";
							$res.="<td style='border:1px solid #ddd;'><b>Total Expense Incurred : </b>".$expense_incurred."</td>";
						$res.="</tr>";
						$res.="<tr>";
							$res.="<td style='border:1px solid #ddd;' colspan='2'><b>Remarks : </b>".strtoupper($remarks)."</td>";
						$res.="</tr>";
						$res.="<tr>";
						$res.="<td align='right' colspan='2'><br></td>";
						$res.="</tr>";
					$res.="</table>";
				$res.="<br><br></td>";
			$res.="</tr>";
		$res.="</table><br><br>";
		$body=$res;
		$body.="<p style='font-style:italic;text-align:center;'><small>*** This is a System generated email, Please do not reply ***</small></p>";
		$from = 'feedback@enersys.co.in';
		$header= 'From: EnerSys Care <'.$from .'>' . "\r\n";
		$header.= 'Cc:'.$ccmail."\r\n";
		$header.= 'Reply-To: '.$from ."\r\n";
		$header.= "Content-Type: text/html\r\n";
		$header.= "X-Mailer: PHP/" . phpversion();
		$header.= 'MIME-Version: 1.0' . "\r\n";
		$admin = "-odb -f $from";
		$abc = mail($to_mail_id, $sub, $body, $header, $admin);
		if($abc)return '0';else return '1';
		}
	}
}
?>