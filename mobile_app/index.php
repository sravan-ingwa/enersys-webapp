<?php

const EMP_DEVICE_STATUS_ACTIVATE_REQ = "ACTIVATE_REQUEST";
const EMP_DEVICE_STATUS_ACTIVE = "ACTIVE";
const EMP_DEVICE_STATUS_INACTIVE = "INACTIVE";

date_default_timezone_set("Asia/Kolkata");
include ('../services/mysql.php');
include ('../services/functions.php');
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->post('/register_device','register_device');
$app->post('/login','login_credentials');
$app->post('/tkt_apr_dprs','tkt_apr_dprs');
$app->post('/ticket_view','ticket_view');
$app->post('/apr_view','apr_view');
$app->post('/dpr_view','dpr_view');
$app->post('/search_tickets','search_tickets');
$app->post('/search_sjo','search_sjo');
$app->post('/profilepic_update','profilepic_update');
$app->post('/dpr_search','dpr_search');
$app->post('/manuals_search','manuals_search');
$app->post('/first_login','first_login');
$app->post('/second_login','second_login');
$app->post('/zhs_apr_submition','zhs_apr_submition');
$app->post('/nhs_apr_submition','nhs_apr_submition');
$app->post('/ts_apr_submition','ts_apr_submition');
$app->post('/md_apr_submition','md_apr_submition');
$app->post('/foa_apr_submition','foa_apr_submition');
$app->post('/toa_apr_submition','toa_apr_submition');
$app->post('/update_status','update_status');
$app->post('/check_details','check_details');
$app->post('/privacy_policy','privacy_policy');
//DropDowns
$app->post('/dpr_submit','dpr_submit');
//$app->post('/dpr_submitupdate','dpr_submitupdate');
$app->post('/efsr_submit','efsr_submit');
$app->post('/ticket_submit','ticket_submit');
$app->post('/user_location_track','user_location_track');
$app->post('/mob_tkt_notifications','mob_tkt_notifications');
$app->post('/change_log','change_log');
//$app->post('/delete_log','delete_log');
$app->run();
function mrepl_planfail_tsrej($level,$old_level,$planned,$purpose){
	if($level=='1')return ($purpose=='1' ? 'REPL DUE' : alias($level,'ec_levels','level_alias','level_name'));
	elseif($level=='2')return (date('Y-m-d') > $planned ? 'PLAN FAIL' : alias($level,'ec_levels','level_alias','level_name'));
	else return ($old_level=='8' ? 'TS REJECTED' : alias($level,'ec_levels','level_alias','level_name'));
}
function mobile_app_encode($res){
	$result['key']=base64_encode(json_encode($res));
	return json_encode($result);
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
function listchecking($tbl,$ticket_alias){ global $mr_con;
	$rec=$mr_con->query("SELECT id FROM $tbl WHERE ticket_alias='$ticket_alias'");
	return ($rec && $rec->num_rows==0 ? TRUE : FALSE);
}
function base64_to_file($name,$base,$ref){
	if($ref=='doc'){$path='../efsr_reports/reports_images/'.$name.'_'.date('Y-m-d_h_i_s').'.jpg';}
	elseif($ref=='sign'){$path='../efsr_reports/cust_engineer_images/sign_images/'.$name.'_'.date('Y-m-d_h_i_s').'.jpg';}
	elseif($ref=='photo'){$path='../efsr_reports/cust_engineer_images/'.$name.'_'.date('Y-m-d_h_i_s').'.jpg';}
	else{$path='../efsr_reports/reports_images/'.$name.'_'.date('Y-m-d_h_i_s').'.png';}
	$ss = file_put_contents($path, base64_decode($base));
	if($ss)return $path;else return '0';
}
function noofbank($ticket_alias,$bank_size,$mfg_date,$install_date,$bb_make,$bb_capacity){ global $mr_con;
	$mfg_date=mysqli_real_escape_string($mr_con,strtoupper(dateFormat($mfg_date,"y")));
	$install_date=mysqli_real_escape_string($mr_con,strtoupper(dateFormat($install_date,"y")));
	$bb_make=mysqli_real_escape_string($mr_con,strtoupper($bb_make));
	$bb_capacity=mysqli_real_escape_string($mr_con,strtoupper($bb_capacity));
	$noof_sql = mysqli_query($mr_con,"INSERT INTO ec_no_of_banks(ticket_alias,bank_size,mfg_date,install_date,bb_make,bb_capacity)VALUES('$ticket_alias','$bank_size','$mfg_date','$install_date','$bb_make','$bb_capacity')");	
	return ($noof_sql ? TRUE : FALSE);
}
function check_old_login($device,$emp_id) { global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT name FROM ec_employee_master WHERE employee_id='$emp_id'");
	if(mysqli_num_rows($sql)){
		$sql = mysqli_query($mr_con,"SELECT name FROM ec_employee_master WHERE employee_id='$emp_id' AND flag<>'1'");
		if(mysqli_num_rows($sql)){
			$sql = mysqli_query($mr_con,"SELECT device,device_2 FROM ec_employee_master WHERE employee_id='$emp_id' AND (device='$device' OR device_2='$device') AND flag=0");
			if(mysqli_num_rows($sql)){ $row=mysqli_fetch_array($sql);
				if(!empty($row['device']) || !empty($row['device_2']))$return = "0@Success";
				else $return = "-3@The Mobile IMEI Number Not Matched";
			}else {$return = "-3@The Mobile IMEI Number Not Matched";}
		}else {$return = "-2@The Employee was Resigned";}
	}else {$return = "-1@Given Employee ID $emp_id is not exist";}
	return $return;
}

function check_login($device, $emp_id) {
	global $mr_con;
	$return = "-1@Invalid device details";
	$deviceDetails = explode("@@", $device);
	if (count($deviceDetails) == 3) {
		$return = "-2@Given Employee ID $emp_id is not exist";
		$sql = mysqli_query($mr_con, "SELECT name, employee_id, pin, android_id, device_manufacturer, device_model, device_status FROM ec_employee_master WHERE employee_id='$emp_id' AND flag=0");
		if(mysqli_num_rows($sql)) {
			$row = mysqli_fetch_array($sql);
			$return = "-3@Device is not registered";
			if ($row["device_status"] == EMP_DEVICE_STATUS_INACTIVE) {
				$return = "-4@Device is inactive";
			} else if ($row["device_status"] == EMP_DEVICE_STATUS_ACTIVATE_REQ) {
				$return = "-5@Device is requested for registration";
			} else if ($row["device_status"] == EMP_DEVICE_STATUS_ACTIVE) {
				$return = "-6@Invalid device details provided";
				if ($row["android_id"] == $deviceDetails[0] && $row["device_manufacturer"] == $deviceDetails[1] && $row["device_model"] == $deviceDetails[2] ) {
					$return = "0@Success";
				}
			}
		}
	}
	return $return;
}

function register_device() {
	global $mr_con;
	date_default_timezone_set("Asia/Kolkata");
	$request = \Slim\Slim::getInstance()->request();
	$data = json_decode($request->getBody());
	$data=base64_decode($data->key);
	$login = json_decode($data);
	// $login = json_decode($request->getBody());
	$emp_id=$login->emp_id;
	$device=$login->device_id;
	$deviceDetails = explode("@@", $device);
	$msg = "-1@Invalid device details";
	if (count($deviceDetails) ==3) {
		$msg = "-2@Given Employee ID $emp_id is not exist";
		$sql = mysqli_query($mr_con, "SELECT name, employee_id, pin, android_id, device_manufacturer, device_model, device_status FROM ec_employee_master WHERE employee_id='$emp_id' AND flag=0");
		if(mysqli_num_rows($sql)) {
			$row = mysqli_fetch_array($sql);
			$msg = "-3@Device is not registered";
			if ($row["device_status"] == EMP_DEVICE_STATUS_ACTIVE) {
				$msg = "-4@Device is already registered";
			} else if ($row["device_status"] == EMP_DEVICE_STATUS_ACTIVATE_REQ) {
				$msg = "-5@Device is requested for registration";
			} else {
				$msg = "-6@Failed to register device, please contact admin";
				$androidId = $deviceDetails[0];
				$deviceManufacturer = $deviceDetails[1];
				$deviceModel = $deviceDetails[2];
				$deviceStatus = EMP_DEVICE_STATUS_ACTIVATE_REQ;
				$updateQry = "update ec_employee_master set android_id='$androidId', device_manufacturer='$deviceManufacturer', device_model='$deviceModel', device_status='$deviceStatus' WHERE employee_id='$emp_id' AND flag=0";
				$sqlUp = mysqli_query($mr_con, $updateQry);
				if ($sqlUp) {
					$msg = "0@Device registration request accepted successfully";
				}
			}
		}
	}
	list($rex,$msg)=explode("@", $msg);
	$result['err_code']=$rex;$result['err_msg']=$msg;
	// echo json_encode($result);
	echo mobile_app_encode($result);
}

function login_credentials(){ 
	global $mr_con;
	date_default_timezone_set("Asia/Kolkata");
	$request = \Slim\Slim::getInstance()->request();
	$data = json_decode($request->getBody());
	$data=base64_decode($data->key);
	$login = json_decode($data);
	// $login = json_decode($request->getBody());
	$employee_id=$login->emp_id;
	$device=$login->device_id;
	
	//obj start
		$date = date('Y_m_d_H_i_s');
		$log = (!empty($employee_id) ? $employee_id."_".$date : "empty_".$date);
		/*if(!file_exists("login_objects/".$log.".txt")){$name = $log;}else{$name = $log."_".rand();}
		$myfile = fopen("login_objects/".$name.".txt", "w") or die("Unable to open file!");
		fwrite($myfile, $data);
		fclose($myfile);*/
							 
		/*$dpr_check = $dpr_check."_".date('Y_m_d_H_i_s')."\r\n\r\n";
		$fh = fopen("dpr_objects/DPR.txt", 'a') or die("can't open file");
		fwrite($fh, $dpr_check);
		fclose($fh);*/
	//obj end
	
	list($rex,$msg)=explode("@",check_login($device, $employee_id));
	if($rex=='0'){
		$reg_id=$login->reg_id;
		$pin=$login->pin;
		$lat=$login->latitude;
		$lng=$login->longitude;
		$sqlUp = mysqli_query($mr_con,"UPDATE ec_employee_master SET reg_id='$reg_id',pin='$pin' WHERE employee_id='$employee_id' AND flag=0");
		$sql = mysqli_query($mr_con,"SELECT name,employee_alias,email_id,mobile_number,mob_profile_pic,role_alias FROM ec_employee_master WHERE employee_id='$employee_id' AND flag=0");
		$row = mysqli_fetch_array($sql);
		$employee_alias=$row['employee_alias'];
		$result['emp_name']=$row['name'];
		$result['emp_id']=$employee_id;
		$result['email_id']=$row['email_id'];
		$result['mobile_num']=$row['mobile_number'];
		$result['profile_pic']=(!empty($row['mob_profile_pic']) ? baseurl()."mobile_app/profile_pics/".$row['mob_profile_pic'] : '');
		$result['role_stat']=alias($row['role_alias'],'ec_emprole','role_alias','role_stat');
		$result['wallpaper']=alias(date('n'),'ec_wallpapers','month','wallpaper_link');
		$result['app_version']="V.1.09";
		$result['err_code']='0';
		$result['err_msg']=$msg;
		$msg="Welcome To EnersysCare";
		//notification($reg_id,$msg);
		all_tracks($employee_alias,$lat,$lng,'1','');
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	// echo json_encode($result);
	echo mobile_app_encode($result);
}
function privilege_status($privilege_alias){
	if($privilege_alias=="3WDRECJ0MA" || $privilege_alias=="PCNKPSJJEU")$stat=1;//Service Engineer
	elseif($privilege_alias=="OX5E3EMI0U")$stat=2;//ZHS
	elseif($privilege_alias=="WIMYJFDJPT")$stat=3;//NHS
	elseif($privilege_alias=="")$stat=4;//TS
	elseif($privilege_alias=="NCPAT7QPTK")$stat=5;//MD
	elseif($privilege_alias=="Z4L1MEACZEUN18EBVDLV")$stat=6;//FOA
	elseif($privilege_alias=="MLPWZV23MRL9DZXRQVQG")$stat=7;//TOA
	else $stat=0;
	return $stat;
}
function ticket_view(){
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$login = json_decode(base64_decode($login->key));
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$emp_alias=alias($emp_id,'ec_employee_master','employee_id','employee_alias');
		$result['tickets']=tickets($emp_alias,"tickets");
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	echo mobile_app_encode($result);
}
function apr_view(){
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$login = json_decode(base64_decode($login->key));
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$emp_alias=alias($emp_id,'ec_employee_master','employee_id','employee_alias');
		$stat=privilege_status(alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias'));
		if($stat!=1 && $stat!=0){$result['apr']=($stat<5 ? tickets($emp_alias,"apr",$stat) : sjo_details($emp_alias,"apr",$stat));}
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	echo mobile_app_encode($result);
}
function dpr_view(){
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$login = json_decode(base64_decode($login->key));
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$emp_alias=alias($emp_id,'ec_employee_master','employee_id','employee_alias');
		$result['dpr']=dpr($emp_alias,"dpr");
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	echo mobile_app_encode($result);
}
function dpr_search(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$login = json_decode(base64_decode($login->key));
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	$search=$login->sub_date;
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$emp_alias=alias($emp_id,'ec_employee_master','employee_id','employee_alias');
		$result=dpr($emp_alias,"search",$search);
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	echo mobile_app_encode($result);
}
function dpr($emp_alias,$ref,$search=""){ global $mr_con;
	$con=$week_dat="";
		if($ref=='search'){
			if((strlen($search)=='8') && (1 === preg_match('~[0-9]~', $search))){
				$aa=str_split($search,4);
				$aaa=str_split($aa[0],2);
				$sub_date=$aa[1]."-".$aaa[1]."-".$aaa[0];
				$con=" sub_date_time LIKE '%".$sub_date."%' AND";
			}else{$con=" dpr_ref_no LIKE '%".$search."%' AND";}
		}else $week_dat="sub_date_time >= curdate() - INTERVAL 7 DAY AND ";
		//YEARWEEK(sub_date_time) = YEARWEEK(NOW() - INTERVAL 1 WEEK)emp_alias='$emp_alias' AND
	$sql=mysqli_query($mr_con,"SELECT * FROM ec_dpr WHERE emp_alias='$emp_alias' AND $con $week_dat flag=0 ORDER BY sub_date_time DESC");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){
			$result[$i]['dpr_ref_no']=$row['dpr_ref_no'];
			//$result[$i]['employee_name']=$row['emp_alias'];
			$result[$i]['category_name']=alias($row['category_alias'],'ec_dpr_category','category_alias','category');
			$result[$i]['remarks']=$row['remarks'];
			$result[$i]['expense_incurred']=$row['expense_incurred'];
			//$result[$i]['tracking_alias']=$row['tracking_alias'];
			//$result[$i]['dpr_address']=$row['dpr_address'];
			$starttime=date("h:i a d/m/Y",strtotime($row['start_trvl_time']));
			$endtime=date("h:i a d/m/Y",strtotime($row['end_trvl_time']));
			$on_site=date("h:i a",strtotime($row['on_site_time']));
			$off_site=date("h:i a",strtotime($row['off_site_time']));
			$sub_time=date("h:i a",strtotime($row['sub_date_time']));
			$sub_date=date("Y/m/d",strtotime($row['sub_date_time']));
			
			$result[$i]['sub_date']=$sub_date;
			$result[$i]['sub_time']=$sub_time;
			$result[$i]['start_travel_time']=$starttime;
			$result[$i]['on_site_time']=$on_site;
			$result[$i]['off_site_time']=$off_site;
			$result[$i]['end_travel_time']=$endtime;
			$result[$i]['total_hours']=$row['total_hours'];
			$ticket_id = alias($row['ticket_alias'],'ec_tickets','ticket_alias','ticket_id');
			$result[$i]['ticket_number']=(empty($ticket_id) ? $row['ticket_alias'] : $ticket_id);
		$i++;}
		//$result['err_code']='0';$result['err_msg']='Success';
	}else{$result[0]['err_code']='-4';$result[0]['err_msg']='No Records';}
 return $result;
}
function check_details(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$login = json_decode(base64_decode($login->key));
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$emp_alias=alias($emp_id,'ec_employee_master','employee_id','employee_alias');
		$lat=$login->latitude;
		$lng=$login->longitude;
		all_tracks($emp_alias,$lat,$lng,'2','');
		$mysqli=mysqli_query($mr_con,"SELECT * FROM ec_app_update_status WHERE employee_alias='$emp_alias' AND flag='0'");
		if(mysqli_num_rows($mysqli)){
			$mysqli_row=mysqli_fetch_array($mysqli);
			$mnul_status=$mysqli_row['manual_status'];
			$wrk_status=$mysqli_row['workguide_status'];
			$prvcy_status=$mysqli_row['privacy_policy_help_status'];
			$drop_status=$mysqli_row['dpr_drops'];
			$site_details_status=$mysqli_row['site_details_status'];
			$phy_status=$mysqli_row['physical_obs_status'];
			$gnrl_status=$mysqli_row['general_obs_status'];
			$chrg_status=$mysqli_row['charger_det_status'];
			$frklft_status=$mysqli_row['fork_lift_status'];
			$gnrtr_status=$mysqli_row['generator_obs_status'];
			$smps_status=$mysqli_row['smps_obs_status'];
			$serv_status=$mysqli_row['serv_eng_status'];
			$zhs_status=$mysqli_row['zhs_status'];
		}else $mnul_status=$wrk_status=$prvcy_status=$drop_status=$site_details_status=$phy_status=$gnrl_status=$chrg_status=$frklft_status=$gnrtr_status=$smps_status=$serv_status=$zhs_status='0';
		//manuals
		$result['settings']['manuals']=$mnul_status;
		$result['settings']['work_guide']=$wrk_status;
		$result['settings']['privacy_policy']=$prvcy_status;
		$result['settings']['dpr']=$drop_status;
		$result['settings']['site_details']=$site_details_status;
		$result['settings']['general_observations']=$gnrl_status;
		$result['settings']['forklift_details']=$frklft_status;
		$result['settings']['generator_observations']=$gnrtr_status;
		$result['settings']['charger_details']=$chrg_status;
		$result['settings']['smps_observations']=$smps_status;
		$result['settings']['physical_observations']=$phy_status;
		$result['settings']['service_engineer_observations']=$serv_status;
		$result['settings']['zhs_dropdowns']=$zhs_status;
		$tkt_sts=grantable('TICKETS','DYNAMIC TABS',$emp_alias);
		$apr_sts=grantable('APPROVALS','DYNAMIC TABS',$emp_alias);
		$dpr_sts=grantable('DPR','DYNAMIC TABS',$emp_alias);
		$stat=privilege_status(alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias'));
		$result['tkt_sts']=$tkt_sts;
		$result['apr_sts']=$apr_sts;
		$result['dpr_sts']=$dpr_sts;
		$monday = strtotime('last monday', strtotime('tomorrow'));$sunday = strtotime('+6 days', $monday);
		if($stat==1){ //Service Engineer
			$a=date("Y-m-d", strtotime("monday this week"));
			$b=date("Y-m-d", strtotime("tuesday this week"));
			$c=date("Y-m-d", strtotime("wednesday this week"));
			$d=date("Y-m-d", strtotime("thursday this week"));
			$e=date("Y-m-d", strtotime("friday this week"));
			$f=date("Y-m-d", strtotime("saturday this week"));
			$data=array($a,$b,$c,$d,$e,$f);
			$outstanding = mysqli_query($mr_con,"SELECT COUNT(id) AS outstanding FROM ec_tickets WHERE service_engineer_alias='$emp_alias' AND level='2' AND planned_date < '$a' AND planned_date > '$f' AND flag=0");
			$o=mysqli_fetch_array($outstanding);
			$out=$o['outstanding'];
			for($i=0;$i<count($data);$i++){
				$week_date = $data[$i];
				$tkt_sql = mysqli_query($mr_con,"SELECT SUM(IF(level > '2',1,0)) AS completed,SUM(IF(level='2',1,0)) AS pending FROM ec_tickets WHERE service_engineer_alias='$emp_alias' AND planned_date = '$week_date' AND flag=0");
				$tkt_row=mysqli_fetch_array($tkt_sql);
				$completed=($tkt_row['completed']!=NULL ? $tkt_row['completed'] : 0);
				$pending=($tkt_row['pending']!=NULL ? $tkt_row['pending'] : 0);
				$result['privilege_status'][$i]['completed']=$completed;
				$result['privilege_status'][$i]['pending']=$pending;
				$result['privilege_status'][$i]['allotted']=$completed+$pending;
				$result['privilege_status'][$i]['outstanding']=$out;
				$result['privilege_status'][$i]['start_date']=date('jS M Y', strtotime($week_date));
				$result['privilege_status'][$i]['end_date']=date('jS M Y', strtotime($week_date));
				$result['privilege_status'][$i]['stat']=$stat;
			}
		}elseif($stat==2){//ZHS
			//$bkt_sql=mysqli_query($mr_con,"SELECT bucket,COUNT(id) AS cnt FROM ec_remarks WHERE bucket IN('1','2','9','11') AND  GROUP BY bucket");
			$bkt_sql=mysqli_query($mr_con,"SELECT SUM(IF(bucket='1',1,0)) AS close,SUM(IF(bucket='2',1,0)) AS decline,SUM(IF(bucket='9',1,0)) AS sendnhs,SUM(IF(bucket='11',1,0)) AS nextvisit FROM ec_remarks WHERE module='TT' AND bucket IN('1','2','9','11') AND remarked_on >= '".date('Y-m-01')."' AND remarked_on <= '".date('Y-m-t')." 23:59:59' AND remarked_by='$emp_alias' AND flag='0'");
			$bkt_row=mysqli_fetch_array($bkt_sql);
			$result['privilege_status'][0]['closed']=$bkt_row['close'];
			$result['privilege_status'][0]['declined']=$bkt_row['decline'];
			$result['privilege_status'][0]['send_nhs']=$bkt_row['sendnhs'];
			$result['privilege_status'][0]['next_visit']=$bkt_row['nextvisit'];
			$result['privilege_status'][0]['start_date']=date('jS M Y', strtotime(date('Y-m-01')));
			$result['privilege_status'][0]['end_date']=date('jS M Y', strtotime(date('Y-m-t')));
			$result['privilege_status'][0]['stat']=$stat;
		}elseif($stat==3){//NHS
			$bkt_sql=mysqli_query($mr_con,"SELECT SUM(IF(bucket='38',1,0)) AS close,SUM(IF(bucket='39',1,0)) AS decline,SUM(IF(bucket='10',1,0)) AS sendts,SUM(IF(bucket='37',1,0)) AS nextvisit FROM ec_remarks WHERE module='TT' AND bucket IN('37','38','39','10') AND remarked_on >= '".date('Y-m-01')."' AND remarked_on <= '".date('Y-m-t')." 23:59:59' AND remarked_by='$emp_alias' AND flag='0'");
			$bkt_row=mysqli_fetch_array($bkt_sql);
			$result['privilege_status'][0]['closed']=$bkt_row['close'];
			$result['privilege_status'][0]['declined']=$bkt_row['decline'];
			$result['privilege_status'][0]['send_ts']=$bkt_row['sendts'];
			$result['privilege_status'][0]['next_visit']=$bkt_row['nextvisit'];
			$result['privilege_status'][0]['start_date']=date('jS M Y', strtotime(date('Y-m-01')));
			$result['privilege_status'][0]['end_date']=date('jS M Y', strtotime(date('Y-m-t')));
			$result['privilege_status'][0]['stat']=$stat;
		}elseif($stat==4){//TS 
			$bkt_sql=mysqli_query($mr_con,"SELECT SUM(IF(bucket='12',1,0)) AS tsapr,SUM(IF(bucket='13',1,0)) AS tsrej,SUM(IF(bucket='14',1,0)) AS stkapr,SUM(IF(bucket='15',1,0)) AS stkrej FROM ec_remarks WHERE module='TT' AND bucket IN('12','13','14','15') AND remarked_on >= '".date('Y-m-01')."' AND remarked_on <= '".date('Y-m-t')." 23:59:59' AND remarked_by='$emp_alias' AND flag='0'");
			$bkt_row=mysqli_fetch_array($bkt_sql);
			$result['privilege_status'][0]['approved']='4';//$bkt_row['tsapr'];
			$result['privilege_status'][0]['rejected']='4';//$bkt_row['tsrej'];
			$result['privilege_status'][0]['hold']='4';//$bkt_row['stkapr'];
			//$result['privilege_status'][0]['stkrej']='4';//$bkt_row['stkrej'];
			$result['privilege_status'][0]['start_date']=date('jS M Y', strtotime(date('Y-m-01')));
			$result['privilege_status'][0]['end_date']=date('jS M Y', strtotime(date('Y-m-t')));
			$result['privilege_status'][0]['stat']=$stat;
		}elseif($stat==5 || $stat==6 || $stat==7){//MD,FOA,TOA
			/*$accept = mysqli_query($mr_con,"SELECT mrf_number,sjo_file,sjo_number,sjo_date,sales_invoice_no,sales_invoice_date,sales_po_no,contact_person,customer_address,customer_phone, from_wh, to_wh, date_of_request, material_value, sjo_number, ticket_alias, customer_alias, status, mrf_alias FROM ec_material_request WHERE flag='0'");
			$reject = mysqli_query($mr_con,"SELECT mrf_number,sjo_file,sjo_number,sjo_date,sales_invoice_no,sales_invoice_date,sales_po_no,contact_person,customer_address,customer_phone, from_wh, to_wh, date_of_request, material_value, sjo_number, ticket_alias, customer_alias, status, mrf_alias FROM ec_material_request WHERE flag='0'");
			$a=mysqli_fetch_array($approve);
			$r=mysqli_fetch_array($reject);*/
			$result['privilege_status'][0]['approved']='4';//$a['approve'];
			$result['privilege_status'][0]['rejected']='4';//$r['reject'];
			$result['privilege_status'][0]['start_date']=date('jS M Y', strtotime(date('Y-m-01')));
			$result['privilege_status'][0]['end_date']=date('jS M Y', strtotime(date('Y-m-t')));
			$result['privilege_status'][0]['stat']=$stat;
		}else $result['privilege_status'][0]['stat']=$stat;
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	echo mobile_app_encode($result);
}
function tkt_apr_dprs(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$login = json_decode(base64_decode($login->key));
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$emp_alias=alias($emp_id,'ec_employee_master','employee_id','employee_alias');
		$sql=mysqli_query($mr_con,"SELECT id FROM ec_notifications WHERE employee_alias = '$emp_alias' AND status='0' AND flag=0");
	 	$result['notification_count']=mysqli_num_rows($sql);
		$tkt_sts=grantable('TICKETS','DYNAMIC TABS',$emp_alias);
		$apr_sts=grantable('APPROVALS','DYNAMIC TABS',$emp_alias);
		$dpr_sts=grantable('DPR','DYNAMIC TABS',$emp_alias);
		if($tkt_sts)$result['tickets']=tickets($emp_alias,"tickets");
		if($apr_sts){
			$stat=privilege_status(alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias'));
			if($stat!=1 && $stat!=0){$result['apr']=($stat<5 ? tickets($emp_alias,"apr",$stat) : sjo_details($emp_alias,"apr",$stat));}
		}
		if($dpr_sts)$result['dpr']=dpr($emp_alias,"dpr");
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	echo mobile_app_encode($result);
}
function search_tickets(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$login = json_decode(base64_decode($login->key));
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	$ser_ticket=$login->ser_ticket;
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$emp_alias=alias($emp_id,'ec_employee_master','employee_id','employee_alias');
		$result=tickets($emp_alias,"search",$ser_ticket);
		//$result['err_code']='0';$result['err_msg']='success'.$ser_ticket;
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	echo mobile_app_encode($result);
}
function tickets($emp_alias,$ref,$st_ser=""){ global $mr_con;$inner="";
	if($ref=="tickets"){$con = "t1.service_engineer_alias='$emp_alias' AND t1.level='2' AND "; $order_by="t1.planned_date";}
	elseif($ref=="apr"){$order_by="t1.transaction_date";
		$state_alias = alias($emp_alias,'ec_employee_master','employee_alias','state_alias');
		if($st_ser==2)$con = " t1.level='3' AND t2.state_alias IN('".(!empty($state_alias) ? str_replace(", ","','",$state_alias) : "")."') AND ";//ZHS
		elseif($st_ser==3)$con = " t1.level='4' AND t2.state_alias IN('".(!empty($state_alias) ? str_replace(", ","','",$state_alias) : "")."') AND ";//NHS
		//elseif($st_ser==4)$con = "t1.level='8' AND "; //TS 9 t2.state_alias IN('') AND 
		else $con="t1.id='' AND ";//"t1.id='' AND ";
	}else{
		$con = "(t1.ticket_id LIKE '%$st_ser%' OR t2.site_id LIKE '%$st_ser%' OR t2.site_name LIKE '%$st_ser%') AND ";
		$inner = "INNER JOIN (SELECT MAX(ID) AS ID FROM ec_tickets WHERE flag='0' GROUP BY SUBSTRING_INDEX(ticket_id,'|',1)) AS P ON (t1.ID=P.ID)";
		$order_by="t1.id";
	}//else{$con = "(t1.ticket_id LIKE '%$st_ser%' OR t2.site_id LIKE '%$st_ser%' OR t2.site_name LIKE '%$st_ser%') AND t1.ticket_id NOT LIKE '%|%' AND "; $order_by="t1.id";}
	$sql = mysqli_query($mr_con,"SELECT t1.*,t2.* FROM ec_tickets t1 INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias $inner WHERE $con t1.flag='0' ORDER BY $order_by");
	if(mysqli_num_rows($sql)){ $i=0;
		while($row = mysqli_fetch_array($sql)){
			$activity_alias=$row['activity_alias'];
			$ticket_id=strtok($row['ticket_id'],"|");
			$result[$i]['ticket_id']=($ref!="search" ? $row['ticket_id'] : $ticket_id);
			$result[$i]['activity']=alias($activity_alias,'ec_activity','activity_alias','activity_name');
			$result[$i]['complaint']=alias($row['complaint_alias'],'ec_complaint','complaint_alias','complaint_name');
			$result[$i]['description']=$row['description'];
			$result[$i]['login_date']=dateTimeFormat($row['login_date'],"d");
			//$result[$i]['activation_date']=dateTimeFormat($row['activation_date'],"d");
			$result[$i]['planned_date']=dateFormat($row['planned_date'],"y");
			$result[$i]['service_engineer_name']=alias_flag_none($row['service_engineer_alias'],'ec_employee_master','employee_alias','name');
			$result[$i]['battery_bank_rating']=$row['battery_bank_rating'];
			$result[$i]['warranty_status']=($row['warranty'] ? 'UNDER WARRANTY' : 'OUT OF WARRANTY');
			$result[$i]['faulty_cell_count']=$row['faulty_cell_count'];
			$result[$i]['moc']=alias($row['mode_of_contact'],'ec_moc','moc_alias','moc_name');
			$result[$i]['moc_value']=$row['moc_num'];
			if(alias($activity_alias,'ec_activity','activity_alias','activity_type')=='0'){
				$result[$i]['service_po_number']=$row['po_number'];
				$result[$i]['service_po_date']=dateFormat($row['po_date'],'d');
				$result[$i]['service_po_link']=$row['po_link'];
			}
			$result[$i]['visits']=$row['n_visits'];
			$result[$i]['tat']=(empty($row['tat']) ? tat($row['ticket_alias']) : $row['tat']);
			$result[$i]['purpose']=$row['purpose'];
			$result[$i]['activity_code']=alias($row['activity_alias'],'ec_activity','activity_alias','activity_code');
			$result[$i]['level']=($row['level']=='1' || $row['level']=='2' || $row['level']=='4' ? mrepl_planfail_tsrej($row['level'],$row['old_level'],$row['planned_date'],$row['purpose']):alias($row['level'],'ec_levels','level_alias','level_name'));
			//$result[$i]['level']=alias($row['level'],'ec_levels','level_alias','level_name');
			//if($st_ser==4)$result[$i]['old_level']=$row['old_level'];
			$result[$i]['zone']=alias($row['zone_alias'],'ec_zone','zone_alias','zone_name');
			$result[$i]['state']=alias($row['state_alias'],'ec_state','state_alias','state_name');
			$result[$i]['district']=alias($row['district_alias'],'ec_district','district_alias','district_name');
			$result[$i]['segment']=alias($row['segment_alias'],'ec_segment','segment_alias','segment_name');
			$result[$i]['customer_code']=alias($row['customer_alias'],'ec_customer','customer_alias','customer_code');
			$result[$i]['site_type']=alias($row['site_type_alias'],'ec_site_type','site_type_alias','site_type');
			$result[$i]['site_id']=$row['site_id'];
			$result[$i]['site_name']=$row['site_name'];
			$result[$i]['product']=alias($row['product_alias'],'ec_product','product_alias','product_description');
			$result[$i]['sale_invoice_number']=$row['sale_invoice_num'];
			$result[$i]['sale_po_number']=$row['po_num'];
			$result[$i]['sale_invoice_date']=dateFormat($row['sale_invoice_date'],'d');
			$result[$i]['mfd_date']=dateFormat($row['mfd_date'],"d");
			$result[$i]['install_date']=dateFormat($row['install_date'],"d");
			$result[$i]['no_of_string']=$row['no_of_string'];
			$result[$i]['frst_lvl_con_nm']=$row['technician_name'];
			$result[$i]['frst_lvl_con_no']=$row['technician_number'];
			$result[$i]['scnd_lvl_con_nm']=$row['manager_name'];
			$result[$i]['scnd_lvl_con_no']=$row['manager_number'];
			$result[$i]['scnd_lvl_con_ml']=$row['manager_mail'];
			$result[$i]['site_address']=$row['site_address'];
			$result[$i]['efsr_no']=$row['efsr_no'];
			$ssq=mysqli_query($mr_con,"SELECT ticket_id,ticket_alias,esca_efsr_link,efsr_start,efsr_date FROM ec_tickets WHERE ticket_id LIKE '%$ticket_id%' AND ticket_id NOT LIKE '%$ticket_id-%' AND efsr_no!='' AND flag='0' ORDER BY id ASC");
			if(mysqli_num_rows($ssq)){
				$j=0;while($rrw=mysqli_fetch_array($ssq)){
					$v_no=(strpos($rrw['ticket_id'],"|")!==false ? end(explode("|",$rrw['ticket_id'])) : '1');
					$result[$i]['visit_links'][$j]['name']=(($rrw['esca_efsr_link']!='') ? 'FSR ' : 'e-FSR ').$v_no;
					$result[$i]['visit_links'][$j]['date']=dateFormat($rrw['efsr_date'],"d");
					$result[$i]['visit_links'][$j]['link']=baseurl().(!empty($rrw['esca_efsr_link']) ? "images/esca_efsr/".$rrw['esca_efsr_link'] : (empty($rrw['efsr_start']) ? "enersyscare_V2" : "mobile_app")."/pdf/index.php?ticket_alias=".$rrw['ticket_alias']);
				$j++;}
			}
			if($ref=="tickets" && $row['level']=='2')$result[$i]['replaced_cells']=replaced_cells_drop($row['ticket_alias']);
			if($ref=="apr" && $row['level']>'3'){
				$sqlRem = mysqli_query($mr_con,"SELECT t2.name,t1.bucket,t1.remarked_by,t1.remarks,t1.remarked_on FROM ec_remarks t1 LEFT JOIN ec_employee_master t2 ON t1.remarked_by=t2.employee_alias WHERE t1.item_alias='".$row['ticket_alias']."' AND bucket IN('1','2','9','11') AND (t2.privilege_alias='OX5E3EMI0U' OR t1.remarked_by='admin') AND t1.module='TT' AND t1.flag=0");//on zhs
				$zhs_name=$zhs_rem=$zhs_rem_on='NA';
				if(mysqli_num_rows($sqlRem)){
					while($rowRem = mysqli_fetch_array($sqlRem)){
						$bucket=$rowRem['bucket'];
						$zhs_name=(strtoupper($rowRem['remarked_by'])=='ADMIN' ? 'ADMIN' : $rowRem['name']);
						$zhs_rem=$rowRem['remarks'];
						$zhs_rem_on=dateTimeFormat($rowRem['remarked_on'],'d');
					}
				}
				$result[$i]['zhs']['milestone']=alias($row['milestone'],'ec_milestone','mile_stone_alais','mile_stone');
				$result[$i]['zhs']['e-fsrefficiency']=$row['payment_terms'];
				$result[$i]['zhs']['name']=$zhs_name;
				$result[$i]['zhs']['action_date']=$zhs_rem_on;
				$result[$i]['zhs']['action_taken']=alias($bucket,'ec_remarks_bucket','bucket_level','bucket');
				$result[$i]['zhs']['remarks']=$zhs_rem;
			}
			/*$sqlRem = mysqli_query($mr_con,"SELECT t2.name,t1.remarked_by,t2.privilege_alias,t1.remarks,t1.bucket,t1.remarked_on FROM ec_remarks t1 LEFT JOIN ec_employee_master t2 ON t1.remarked_by=t2.employee_alias WHERE t1.item_alias='$ticket_alias' AND bucket IN('1','2','9','10','11') AND t2.privilege_alias IN('OX5E3EMI0U','WIMYJFDJPT') AND t1.module='TT' AND t1.flag=0");//on se, esca se, zhs, nhs, ths
			$zhs_name=$zhs_rem=$zhs_rem_on=$nhs_name=$nhs_rem=$nhs_rem_on='NA';
			if(mysqli_num_rows($sqlRem)){
				while($rowRem = mysqli_fetch_array($sqlRem)){
					if(strtoupper($rowRem['remarked_by'])=='ADMIN'){
						$remarked_by='ADMIN';
						if($rowRem['bucket']=='9')$zhs=$zhs_id='ADMIN';elseif($rowRem['bucket']=='10')$nhs=$nhs_id='ADMIN';else $ths=$ths_id='ADMIN';
					}else{
						$privilege_alias=$rowRem['privilege_alias'];
						$bucket=$rowRem['bucket'];
						if($privilege_alias=='OX5E3EMI0U' && ($rowRem['bucket']=='1' || $rowRem['bucket']=='2' || $rowRem['bucket']=='9' || $rowRem['bucket']=='11')){ //ZHS
							$zhs_bucket=$rowRem['bucket'];
							$zhs_name=$rowRem['name'];
							$zhs_rem=$rowRem['remarks'];
							$zhs_rem_on=dateTimeFormat($rowRem['remarked_on'],'d');
						}elseif($privilege_alias=='WIMYJFDJPT' && ($rowRem['bucket']=='1' || $rowRem['bucket']=='2' || $rowRem['bucket']=='10' || $rowRem['bucket']=='11')){ //NHS
							$nhs_bucket=$rowRem['bucket'];
							$nhs_name=$rowRem['name'];
							$nhs_rem=$rowRem['remarks'];
							$nhs_rem_on=dateTimeFormat($rowRem['remarked_on'],'d');
						}
					}
				}
			}
			if($ref=="apr" && $row['level']>'3'){
				$result[$i]['zhs']['milestone']=alias($row['milestone'],'ec_milestone','mile_stone_alais','mile_stone');
				$result[$i]['zhs']['e-fsrefficiency']=$row['payment_terms'];
				$result[$i]['zhs']['name']=$zhs_name;
				$result[$i]['zhs']['action_date']=$zhs_rem_on;
				$result[$i]['zhs']['action_taken']=alias($zhs_bucket,'ec_remarks_bucket','bucket_level','bucket');
				$result[$i]['zhs']['remarks']=$zhs_rem;
			}if($ref=="apr" && $row['level']>'4'){
				$result[$i]['nhs']['name']=$nhs_name;
				$result[$i]['nhs']['action_date']=$nhs_rem_on;
				$result[$i]['nhs']['action_taken']=alias($nhs_bucket,'ec_remarks_bucket','bucket_level','bucket');
				$result[$i]['nhs']['remarks']=$nhs_rem;
			}
			if($stat==4){
				$tssql=mysqli_query($mr_con,"SELECT * FROM ec_ths_approved WHERE ticket_alias='".$row['ticket_alias']."' AND flag=0");
				$tssql_row=mysqli_fetch_array($tssql);
				$result[$i]['line_number']=$tssql_row['line_number'];
				$result[$i]['shift']=$tssql_row['shift'];
				$result[$i]['date_of_assembly']=$tssql_row['date_of_assembly'];
				$result[$i]['date_of_jar_form']=$tssql_row['date_of_jar_form'];
				$result[$i]['corect_act_Plan']=$tssql_row['corect_act_Plan'];
				$result[$i]['persons_notified']=$tssql_row['persons_notified'];
				$ts_alias=$tssql_row['alias'];
				$tsquery=mysqli_query($mr_con,"SELECT * FROM ec_ths_faulty_ocv WHERE ths_appr_alias='$ts_alias' AND flag=0");
				$i=0;while($ts_row=mysqli_fetch_array($tsquery)){
					$result[$i]['faulty']['faulty_cell_num']=$ts_row['faulty_cell_num'];
					$result[$i]['faulty']['ocv']=$ts_row['ocv'];
					$result[$i]['faulty']['tenth_hour']=$ts_row['tenth_hour'];
				$i++;}
			}*/
		$i++;}
	}else {$result[0]['err_code']='-4';$result[0]['err_msg']='No Tickets';}
	return $result;
}
/* function replaced_cells_drop($ticket_alias){ global $mr_con;
	$sq=mysqli_query($mr_con,"SET GLOBAL group_concat_max_len = 1000000");
	$sql1 = mysqli_query($mr_con,"SELECT GROUP_CONCAT('''',t2.item_description,'''') AS items_cd FROM ec_material_outward t1
		 INNER JOIN ec_material_sent_details t2 ON t1.alias=t2.reference
		 WHERE t1.ref_no='$ticket_alias' AND t1.from_type='1' AND t1.to_wh<>'2609' AND t1.flag=0 AND t2.flag=0");
		 $row1=mysqli_fetch_array($sql1);
	if(!empty($row1['items_cd'])){
		$item_code = $row1['items_cd'];
		$sql=mysqli_query($mr_con,"SELECT item_code_alias,item_description FROM ec_item_code WHERE invoice_no!='' AND invoice_no!='NA' AND item_code_alias IN ($item_code) AND flag=0");
		//$sql=mysqli_query($mr_con,"SELECT t2.item_code_alias,t2.item_description FROM ec_material_request t1 JOIN ec_item_code t2 ON t1.mrf_number=t2.sjo_no WHERE t1.ticket_alias='$ticket_alias' AND t2.invoice_no!='' AND t2.invoice_no!='NA' AND t1.flag=0 AND t2.flag=0");
		if(mysqli_num_rows($sql)>0){
			$result[0]['alias']=$result[0]['name']='Select';
			$i=1;while($row=mysqli_fetch_array($sql)){
				$result[$i]['alias']=$row['item_code_alias'];
				$result[$i]['name']=$row['item_description'];
			$i++;}
		}else{$result[0]['alias']='';$result[0]['name']='No Records';}
	}return $result;
} */
function replaced_cells_drop($ticket_alias){ global $mr_con;
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
				$result[0]['alias']=$result[0]['name']='Select';
				$i=1;foreach($combo_arr as $cod=>$desc){$result[$i]['alias']=$cod;$result[$i]['name']=$desc;$i++;}
			}
		}
	}return $result;
}
function site_master($site_alias){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_sitemaster WHERE site_alias='$site_alias' AND flag='0'");
	$row = mysqli_fetch_array($sql);
	$result['zone']=alias($row['zone_alias'],'ec_zone','zone_alias','zone_name');
	$result['state']=alias($row['state_alias'],'ec_state','state_alias','state_name');
	$result['district']=alias($row['district_alias'],'ec_district','district_alias','district_name');
	$result['segment']=alias($row['segment_alias'],'ec_segment','segment_alias','segment_name');
	$result['customer']=alias($row['customer_alias'],'ec_customer','customer_alias','customer_name');
	$result['customer_code']=alias($row['customer_alias'],'ec_customer','customer_alias','customer_code');
	$result['customer_number']=alias($row['customer_alias'],'ec_customer','customer_alias','customer_contact');
	$result['site_type']=alias($row['site_type_alias'],'ec_site_type','site_type_alias','site_type');
	$result['site_id']=$row['site_id'];
	$result['site_name']=$row['site_name'];
	$result['product']=alias($row['product_alias'],'ec_product','product_alias','product_description');
	$result['mfd_date']=dateFormat($row['mfd_date'],"d");
	$result['install_date']=dateFormat($row['install_date'],"d");
	$result['no_of_string']=$row['no_of_string'];
	$result['technician_name']=$row['technician_name'];
	$result['technician_number']=$row['technician_number'];
	$result['manager_name']=$row['manager_name'];
	$result['manager_number']=$row['manager_number'];
	$result['manager_mail']=$row['manager_mail'];
	$result['site_address']=$row['site_address'];
	return $result;
}

//INVENTORY
function search_sjo(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$login = json_decode(base64_decode($login->key));
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	$ser_sjo=$login->ser_sjo;
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$emp_alias=alias($emp_id,'ec_employee_master','employee_id','employee_alias');
		$result=sjo_details($emp_alias,"search",$ser_sjo);
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	echo mobile_app_encode($result);
}
function sjo_details($emp_alias,$ref,$st_ser=""){ global $mr_con;
	if($ref=="apr"){
		if($st_ser==5 || $st_ser==6 || $st_ser==7){ //MD //FOA 4 //TOA 5 
			$mul_dynamic = mul_dynamic($emp_alias);
			if($mul_dynamic=='NA' || empty($mul_dynamic))$con = "id='' AND ";else $con = "mrf_alias IN('$mul_dynamic') AND ";
		}else $con="id='' AND ";
	}else{$con = "sjo_number LIKE '%$st_ser%' AND ";}
	$sql = mysqli_query($mr_con,"SELECT mrf_number,sjo_file,sjo_number,sjo_date,sales_invoice_no,sales_invoice_date,sales_po_no,contact_person,customer_address,customer_phone, from_wh, to_wh, date_of_request, material_value, sjo_number, ticket_alias, customer_alias, status, mrf_alias FROM ec_material_request WHERE $con flag='0' ORDER BY id DESC");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){
			$result[$i]['mrf_number']=$row['mrf_number'];
			$result[$i]['from_wh']=alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code');
			$result[$i]['to_wh']=alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code');
			$result[$i]['date_of_request']=dateFormat($row['date_of_request'],'d');
			$result[$i]['material_value']=$row['material_value'];
			$result[$i]['status']=alias($row['status'],'ec_inventory_levels','level_alias','level_name');
			$result[$i]['mrf_alias']=$row['mrf_alias'];
			if($row['ticket_alias']!='2609')$result[$i]['ticket_id']=alias($row['ticket_alias'],'ec_tickets','ticket_alias','ticket_id');
			else $result[$i]['ticket_id']="BUFFER STOCK";
			$customer_name=alias($row['customer_alias'],'ec_customer','customer_alias','customer_name');
			$result[$i]['customer']=(!empty($customer_name) ? $customer_name : "NA");
			$result[$i]['sjo_number']=$row['sjo_number'];
			$result[$i]['sjo_date']=dateFormat($row['sjo_date'],'d');
			$result[$i]['sls_inv_no']=$row['sales_invoice_no'];
			$result[$i]['sls_inv_dt']=dateFormat($row['sales_invoice_date'],'d');
			$result[$i]['sls_po_no']=$row['sales_po_no'];
			$result[$i]['con_name']=$row['contact_person'];
			$result[$i]['cust_addr']=$row['customer_address'];
			$result[$i]['cust_phn']=$row['customer_phone'];
			$result[$i]['sjo_link']=baseurl().$row['sjo_file'];
			$result[$i]['road_permit']= (alias($row['from_wh'],'ec_warehouse','wh_alias','road_permit')=='1' ? 'REQUIRED':' NOT REQUIRED');
			$remsql=mysqli_query($mr_con,"SELECT remarks,remarked_by,remarked_on,bucket FROM ec_remarks WHERE id IN (SELECT MAX(id) FROM ec_remarks WHERE module='MR' AND bucket IN('16','17','20','21','22') AND item_alias='".$row['mrf_alias']."' AND flag='0') AND flag='0'");
			if(mysqli_num_rows($remsql)){
				$remrow=mysqli_fetch_array($remsql);
				$result[$i]['md']['action_taken']=($remrow['bucket']=='21' ? "APPROVED" : ($remrow['bucket']=='22' ? "REJECTED" :($remrow['bucket']=='20' ? "HOLD" :($remrow['bucket']=='16' ? "REQUEST ADD" : "REQUEST EDIT"))));
				$result[$i]['md']['remarks']=$remrow['remarks'];
				$result[$i]['md']['remarked_by']=alias_flag_none($remrow['remarked_by'],'ec_employee_master','employee_alias','name');
				$result[$i]['md']['remarked_on']=dateTimeFormat($remrow['remarked_on'],'d');
			}
			$sql1 = mysqli_query($mr_con,"SELECT * FROM ec_request_items WHERE mrf_alias ='".$row['mrf_alias']."' AND flag='0'");
			if(mysqli_num_rows($sql1)){ $treq_qty=$tlft_qty=0;
				$j=0;while($row1=mysqli_fetch_array($sql1)){
					$result[$i]['req_items'][$j]['item_type']=($row1['cell_type']=="1" ? "NEW" : ($row1['cell_type']=="2" ? "REVIVED":"NA"));
					//$result[$i]['req_items'][$j]['item_type']=($row1['item_type']=="1" ? "CELLS" : ($row1['item_type']=="2" ? "ACCESSORIES":"NA"));
					$result[$i]['req_items'][$j]['item_desc']=getitemname(($row1['item_type']=="1" ? "CELLS" : ($row1['item_type']=="2" ? "ACCESSORIES":"NA")),$row1['item_description']);
					$treq_qty+=$result[$i]['req_items'][$j]['req_qty']=$row1['quantity'];
					$tlft_qty+=$result[$i]['req_items'][$j]['lft_qty']=$row1['left_quanty'];
					$result[$i]['req_items'][$j]['snt_qty']=$result[$i]['req_items'][$j]['req_qty']-$result[$i]['req_items'][$j]['lft_qty'];
				$j++;}
				$result[$i]['treq_qty']=$treq_qty;
				$result[$i]['tlft_qty']=$tlft_qty;
				$result[$i]['tsnt_qty']=$treq_qty-$tlft_qty;
			}else{$result[$i]['request_length'] = array();}
				/*$result[$i]['md']['name']='manish';
				$result[$i]['md']['action_date']='23-09-2016';
				$result[$i]['md']['action_taken']='sent for TS Approval';
				$result[$i]['md']['remarks']='24 new cells of 1000AH required in this site';*/
				/*$result[$i]['foa']['name']='manish';
				$result[$i]['foa']['action_date']='23-09-2016';
				$result[$i]['foa']['action_taken']='sent for TS Approval';
				$result[$i]['foa']['remarks']='24 new cells of 1000AH required in this site';*/
		$i++;}//$result['err_code']='0';$result['err_msg']='Success';
		}else {$result[0]['err_code']='-4';$result[0]['err_msg']='No SJOs';}
	return $result;
}
function mob_tkt_notifications(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$login = json_decode(base64_decode($login->key));
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$emp_alias=alias($emp_id,'ec_employee_master','employee_id','employee_alias');
		$notification_total=mysqli_num_rows(mysqli_query($mr_con,"SELECT id FROM ec_notifications WHERE employee_alias='$emp_alias' AND flag=0"));
		$sql=mysqli_query($mr_con,"SELECT msg_stage,title_ticket,type_ref,created_date FROM ec_notifications WHERE employee_alias='$emp_alias' AND msg_stage<>'' AND flag=0 ORDER BY created_date DESC LIMIT 20");
		if(mysqli_num_rows($sql)>0){
			$i=0;while($row=mysqli_fetch_array($sql)){$type_ref=$row['type_ref'];
				if($type_ref=='1'){ //Tickets
					$level=$row['msg_stage'];
					$ticket_alias=$row['title_ticket'];
					$ticket_id=alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
					$activity_name=alias(alias($ticket_alias,'ec_tickets','ticket_alias','activity_alias'),'ec_activity','activity_alias','activity_name');
					$site_name=alias_flag_none(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','site_name');
					if($level=='1'){
						$msg="Dear Team, New Complaint has been registered against the ".$activity_name." of Site name-".$site_name." Ticket No- ".$ticket_id." in your State.";
						$notification_icon="T";
						$notification_date=$row['created_date'];
					}elseif($level=='2'){
						$msg="Ticket No-".$ticket_id." against the Activity ".$activity_name." of Site name-".$site_name." is planned for site visit on Dated ".$row['created_date'].". Plan accordingly.";
						$notification_icon="T";
						$notification_date=$row['created_date'];
					}elseif($level=='3' || $level=='4'){
						$msg="e-FSR of Ticket No-".$ticket_id." against the Activity ".$activity_name." of Site name-".$site_name." awaiting for your Approval.";
						$notification_icon="A";
						$notification_date=$row['created_date'];
					}elseif($level=='6'){
						$msg="Ticket No-".$ticket_id." against the Activity ".$activity_name." of Site name-".$site_name." is Declined on Dt-'".$row['created_date']."'.";
						$notification_icon="T";
						$notification_date=$row['created_date'];
					}elseif($level=='7'){
						$msg="Ticket No-".$ticket_id." against the Activity ".$activity_name." of Site name-".$site_name." is Closed on Dt-".$row['created_date'].".";
						$notification_icon="T";
						$notification_date=$row['created_date'];
					}
				}elseif($type_ref=='2'){ //Admin Message
					$msg=$row['msg_stage'];
					$notification_icon="E";
					$notification_date=$row['created_date'];
				}else{ //FAM
					$mrf_alias=$row['title_ticket'];
					$sjo_no= alias($mrf_alias,'ec_material_request','mrf_alias','sjo_number');
					$warehouse= alias(alias($mrf_alias,'ec_material_request','mrf_alias','from_wh'),'ec_warehouse','wh_alias','wh_address');
					if(($type_ref=='3' && 1) || ($type_ref=='9' && 1) || ($type_ref=='10' && 1)){ //MD //FOA //TOA
						$msg="Material Request of SJO No-".$sjo_no." from Warehouse ".$warehouse." is awaiting for your Approval.";
						$notification_icon="E";
						$notification_date=$row['created_date'];
					}
				}
				$result[$i]['notification_msg']=$msg;
				$result[$i]['notification_icon']=$notification_icon;
				$result[$i]['notification_date']=$notification_date;
				$result[$i]['notification_total']=$notification_total;
			$i++;}
		}else {$result['err_code']='-4';$result['err_msg']='No Notifications';}
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	echo mobile_app_encode($result);
}

function profilepic_update(){ global $mr_con;
	$emp_id=$_POST['emp_id'];
	$device_id=$_POST['device_id'];
	$pic = upload_file_mob($_FILES['profile_pic'],'profile_pic','image');
	list($code,$msg) = explode(",",$pic);
	if($code=='0'){
		$sq = mysqli_query($mr_con,"SELECT mob_profile_pic FROM ec_employee_master WHERE employee_id='$emp_id' AND flag=0");
		$ro = mysqli_fetch_array($sq); $oldPic = $ro['mob_profile_pic'];
		$sql = mysqli_query($mr_con,"UPDATE ec_employee_master SET mob_profile_pic='$msg' WHERE employee_id='$emp_id' AND flag=0");
		if($sql){ @unlink($oldPic); $result['err_code']='0';$result['err_msg']="Success"; $result['profile_link']=baseurl().'mobile_app/profile_pics/'.$msg;$result['updated_date']=date('Y-m-d');}
	}else{$result['err_code']='-4';$result['err_msg']=$msg.", Try again!";}
	echo mobile_app_encode($result);
}
function upload_file_mob($file,$ref,$type){ global $mr_con;
	if(isset($file['name']) && !empty($file['name'])){
		$fileName = $ref.'_'.date('Y_m_d_H_i_s');
		$arr=($type=='image' ? array('png','jpg','jpeg','gif','tif','rif','bmp','bpg') : array('pdf'));
		$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
		if(in_array($ext,$arr)){
			if($file["size"]<=5242880){//5MB
				$name = $fileName.".".$ext;
				if($ref=='profile_pic')$path = "profile_pics/".$name;
				elseif($ref=='esca_efsr')$path = "../images/esca_efsr/".$name;
				else $path = "../images/reports/".$name;
				if(file_exists($path))$result = "2,".$name." already exists";
				else{
					$move = move_uploaded_file($file["tmp_name"],$path);
					$pic = mysqli_real_escape_string($mr_con,$name);
					if($move)$result = "0,".$pic;else $result = "1,Error in Uploading file";
				}
			}else $result = "2,The file size must be lessthan OR equal to 5MB";
		}else $result = "3,Choosen file is not an ".$type." file";
	}else $result = "4,Please Upload pdf file.";
	return $result;
}
//DropDowns
function dpr_category(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT category,category_alias FROM ec_dpr_category WHERE flag='0'");
	if(mysqli_num_rows($sql)>0){$i=0;
		while($row=mysqli_fetch_array($sql)){
			$result[$i]['alias']=$row['category_alias'];
			$result[$i]['name']=$row['category'];$i++;
		}//$result['err_code']='0';$result['err_msg']='Success';
	}else {$result[0]['err_code']='-4';$result[0]['err_msg']='No DPR';}
	return $result;
}
function dpr_tt_number($emp_alias){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT ticket_id,ticket_alias FROM ec_tickets WHERE service_engineer_alias='$emp_alias' AND planned_date='".date('Y-m-d')."' AND level='2' AND flag=0");
	if(mysqli_num_rows($sql)>0){$i=0;
		while($row=mysqli_fetch_array($sql)){
			$result[$i]['ticket_alias']=$row['ticket_alias'];
			$result[$i]['ticket_id']=$row['ticket_id'];$i++;
		}//$result['err_code']='0';$result['err_msg']='Success';
	}else {$result[0]['err_code']='-4';$result[0]['err_msg']='No DPR';}
	return $result;
}
function privacy_policy(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$login = json_decode(base64_decode($login->key));
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	$search=$login->sub_date;
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$emp_alias=alias($emp_id,'ec_employee_master','employee_id','employee_alias');
		$result=privacy_policy_help();
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	echo mobile_app_encode($result);
}
function first_login(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$login = json_decode(base64_decode($login->key));
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	$type=$login->type;
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$emp_alias=alias($emp_id,'ec_employee_master','employee_id','employee_alias');
		//manuals
			if($type=='manuals')$result['manuals']=manuals($emp_alias,'');
		//workguide
			if($type=='work_guide')$result['work_guide']=work_guide();
		//privacy policy
			if($type=='privacy_policy')$result['privacy_policy']=privacy_policy_help();
		//dpr_drops
		if($type=='dpr'){
			$result['dpr']['dpr_category']=dpr_category();
			$result['dpr']['tickets']=dpr_tt_number($emp_alias);
		}
		//site details
		if($type=='site_details'){
			$result['site_details']['nature_of_activity']=activity();
			$result['site_details']['nature_of_complaint']=complaint(); 
			$result['site_details']['moc']=moc();
		}
		//Physical Observations
		if($type=='physical_observations'){
			$result['physical_observations']['battery_top']=menu_items('A');
			$result['physical_observations']['general_observations']=menu_items('M');
			$result['physical_observations']['leakage']=menu_items('O');
			$result['physical_observations']['physical_condition']=menu_items('Q');
			$result['physical_observations']['temperature']['indoor']=menu_items('U');
			$result['physical_observations']['temperature']['outdoor']=menu_items('Z');
			$result['physical_observations']['bb_cond_motive_phyob']=menu_items('E');
			$result['physical_observations']['phy_cond_motive_power']=menu_items('W');
			$result['physical_observations']['gnrl_obs_motive_power']=menu_items('X');
			$result['physical_observations']['leakage_motive_power']=menu_items('Y');
		}
		//General Observations
		if($type=='general_observations')$result['general_observations']['coach_status']=menu_items('H');
		
		//Charger Details
		if($type=='charger_details'){
			$result['charger_details']['charger_input']=menu_items('G');
			$result['charger_details']['equilize_charger_mode']=menu_items('K');
		}
		//Forklift Details
		if($type=='forklift_details'){
			$result['forklift_details']['electrolyte_level']=menu_items('C');
			$result['forklift_details']['plug_type']=menu_items('R');
		}
		//Generator Observations
		if($type=='generator_observations'){
			$result['generator_observations']['dg_make']=menu_items('I');
			$result['generator_observations']['dg_working_condition']=menu_items('J');
			$result['generator_observations']['power_observations']=menu_items('S');
		}
		//SMPS Observations
		if($type=='smps_observations'){
			$result['smps_observations']['lvd_status']=menu_items('P');
			$result['smps_observations']['smps_display']=menu_items('T');
			$result['smps_observations']['temp_compensation']=menu_items('V');
		}
		//Service Engineer Observations
		if($type=='service_engineer_observations'){
			$result['service_engineer_observations']['fault_code']=fault_code();
			$result['service_engineer_observations']['job_performed']=menu_items('N');
			$result['service_engineer_observations']['required_cells']=cells();
			$result['service_engineer_observations']['allrequired_cells']=allcells();
			$result['service_engineer_observations']['required_accessories']=accessory();
		}
		//ZHS Drop downs
		if($type=='zhs_dropdowns'){
			$result['zhs_dropdowns']['milestone']=milestone();
			$result['zhs_dropdowns']['efsr_efficiency']=
				array(
					array("efsr_efficiency"=>"100"),
					array("efsr_efficiency"=>"90"),
					array("efsr_efficiency"=>"80"),
					array("efsr_efficiency"=>"70")
				);
		}
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	echo mobile_app_encode($result);
}

function second_login(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$login = json_decode(base64_decode($login->key));
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$emp_alias=alias($emp_id,'ec_employee_master','employee_id','employee_alias');
		$mysqli=mysqli_query($mr_con,"SELECT * FROM ec_app_update_status WHERE employee_alias='$emp_alias' AND flag='0'");
		if(mysqli_num_rows($mysqli)){
			$mysqli_row=mysqli_fetch_array($mysqli);
			$mnul_status=$mysqli_row['manual_status'];
			$wrk_status=$mysqli_row['workguide_status'];
			$prvcy_status=$mysqli_row['privacy_policy_help_status'];
			$dpr_drops=$mysqli_row['dpr_drops'];
			$site_details_status=$mysqli_row['site_details_status'];
			$phy_status=$mysqli_row['physical_obs_status'];
			$gnrl_status=$mysqli_row['general_obs_status'];
			$chrg_status=$mysqli_row['charger_det_status'];
			$frklft_status=$mysqli_row['fork_lift_status'];
			$gnrtr_status=$mysqli_row['generator_obs_status'];
			$smps_status=$mysqli_row['smps_obs_status'];
			$serv_status=$mysqli_row['serv_eng_status'];
			$zhs_status=$mysqli_row['zhs_status'];
		}else $mnul_status=$wrk_status=$prvcy_status=$dpr_drops=$site_details_status=$phy_status=$gnrl_status=$chrg_status=$frklft_status=$gnrtr_status=$smps_status=$serv_status=$zhs_status='0';
		
		//manuals
		if($mnul_status=='1')$result['manuals']=manuals($emp_alias,'');
		
		//workguide
		if($wrk_status=='1')$result['work_guide']=work_guide();
		
		//privacy policy
		if($prvcy_status=='1')$result['privacy_policy']=privacy_policy_help();
		
		//dpr_drops
		if($dpr_drops=='1'){
			$result['dpr']['dpr_category']=dpr_category();
			$result['dpr']['tickets']=dpr_tt_number($emp_alias);
		}
		//site details 
		if($site_details_status=='1'){
			$result['site_details']['nature_of_activity']=activity();
			$result['site_details']['nature_of_complaint']=complaint(); 
			$result['site_details']['moc']=moc();
		}
		//Physical Observations
		if($phy_status=='1'){
			$result['physical_observations']['battery_top']=menu_items('A');
			$result['physical_observations']['general_observations']=menu_items('M');
			$result['physical_observations']['leakage']=menu_items('O');
			$result['physical_observations']['physical_condition']=menu_items('Q');
			$result['physical_observations']['temperature']['indoor']=menu_items('U');
			$result['physical_observations']['temperature']['outdoor']=menu_items('Z');
			$result['physical_observations']['bb_cond_motive_phyob']=menu_items('E');
			$result['physical_observations']['phy_cond_motive_power']=menu_items('W');
			$result['physical_observations']['gnrl_obs_motive_power']=menu_items('X');
			$result['physical_observations']['leakage_motive_power']=menu_items('Y');
		}
		//General Observations
		if($gnrl_status=='1')$result['general_observations']['coach_status']=menu_items('H');
		
		//Charger Details
		if($chrg_status=='1'){
			$result['charger_details']['charger_input']=menu_items('G');
			$result['charger_details']['equilize_charger_mode']=menu_items('K');
		}
		//Forklift Details
		if($frklft_status=='1'){
			$result['forklift_details']['electrolyte_level']=menu_items('C');
			$result['forklift_details']['plug_type']=menu_items('R');
		}
		//Generator Observations
		if($gnrtr_status=='1'){
			$result['generator_observations']['dg_make']=menu_items('I');
			$result['generator_observations']['dg_working_condition']=menu_items('J');
			$result['generator_observations']['power_observations']=menu_items('S');
		}
		//SMPS Observations
		if($smps_status=='1'){
			$result['smps_observations']['lvd_status']=menu_items('P');
			$result['smps_observations']['smps_display']=menu_items('T');
			$result['smps_observations']['temp_compensation']=menu_items('V');
		}
		//Service Engineer Observations
		if($serv_status=='1'){
			$result['service_engineer_observations']['fault_code']=fault_code();
			$result['service_engineer_observations']['job_performed']=menu_items('N');
			$result['service_engineer_observations']['required_cells']=cells();
			$result['service_engineer_observations']['allrequired_cells']=allcells();
			$result['service_engineer_observations']['required_accessories']=accessory();
		}
		//ZHS Drop downs
		if($zhs_status=='1'){
			$result['zhs_dropdowns']['milestone']=milestone();
			$result['zhs_dropdowns']['efsr_efficiency']=
				array(
					array("efsr_efficiency"=>"100"),
					array("efsr_efficiency"=>"90"),
					array("efsr_efficiency"=>"80"),
					array("efsr_efficiency"=>"70")
				);
		}
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	echo mobile_app_encode($result);
}
function update_status(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$login = json_decode(base64_decode($login->key));
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	$status=$login->status;
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$emp_alias=alias($emp_id,'ec_employee_master','employee_id','employee_alias');
		if($status=='0'){
			$sql=mysqli_query($mr_con,"UPDATE ec_app_update_status SET manual_status='0',workguide_status='0',privacy_policy_help_status='0',general_obs_status='0',physical_obs_status='0',generator_obs_status='0',charger_det_status='0',fork_lift_status='0',serv_eng_status='0',smps_obs_status='0',dpr_drops='0',site_details_status='0' WHERE employee_alias='$emp_alias' AND flag=0");
			if($sql){$result['err_code']='0';$result['err_msg']='Success';}
		}
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	echo mobile_app_encode($result);
}
function manuals_search(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$login = json_decode(base64_decode($login->key));
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	$search=$login->search;
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$emp_alias=alias($emp_id,'ec_employee_master','employee_id','employee_alias');
		$result=manuals($emp_alias,"search",$search);
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	echo mobile_app_encode($result);
}
function manuals($emp_alias,$ref,$search=''){ global $mr_con;
	if($ref=="search")$con="t2.product_description'%".$search."%' AND ";else $con="";
	$sql = mysqli_query($mr_con,"SELECT t2.product_description,t1.manual_pdf,t1.segment_alias FROM ec_app_manuals t1 INNER JOIN ec_product t2 ON t1.product_alias=t2.product_alias WHERE $con t1.mob_view_stat='1' AND t1.flag=0");
	if(mysqli_num_rows($sql)){
		$prod=$seg_prod=array();
		while($row=mysqli_fetch_array($sql)){
			$prod[$row['product_description']]=$row['manual_pdf'];
			$seg_prod[$row['product_description']]=$row['segment_alias'];
		}
		$seg_sql = mysqli_query($mr_con,"SELECT segment_name,segment_alias FROM ec_segment WHERE flag='0' ORDER BY id");
		if(mysqli_num_rows($seg_sql)){
			while($seg_row=mysqli_fetch_array($seg_sql)){
				$searchword = $seg_row['segment_alias'];
				$product = array_keys(array_filter($seg_prod, function($var) use ($searchword) { return (strpos($var,$searchword)!==false ? $var:"");}));
				if(count($product)){
					foreach($product as $k=>$aa){
						$result[$seg_row['segment_name']][$k]['product']=$aa;
						$result[$seg_row['segment_name']][$k]['manual_link']=baseurl()."images/reports/".$prod[$aa];
					}
				}else $result[$seg_row['segment_name']]=array();
			}
		}else{$result['err_code']='-4';$result['err_msg']="No Segments Found";}
	}else{$result['err_code']='-4';$result['err_msg']="No Manuals Found";}
	return $result;
}
function work_guide(){global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT * FROM ec_app_work_guide WHERE ref_id='0' AND flag=0");
	$i=0;while($row=mysqli_fetch_array($sql)){
		$result[$i]['work_guide_title']=$row['work_guide'];
		$q=mysqli_query($mr_con,"SELECT work_guide FROM ec_app_work_guide WHERE ref_id='".$row['guide_alias']."' AND flag=0");
		$j=0;while($rows=mysqli_fetch_array($q)){
			$result[$i]['sub_work_guide'][$j]=$rows['work_guide'];
		$j++;}
	$i++;}
	return $result;
}
function privacy_policy_help(){global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT * FROM ec_app_privacy_policy WHERE flag=0");
	if(mysqli_num_rows($sql)>0){
		$i=0;while($row=mysqli_fetch_array($sql)){
		$result[$i]['help_number']=$row['help'];
		$result[$i]['login_text']=$row['login_text'];
		$result[$i]['privacy_policy']=$row['privacy_policy'];
		$i++;}
	}else{$result['err_code']='-4';$result['err_msg']='No Records';}
	return $result;
}
//Start Service Engineer Observations

function fault_code(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT faulty_alias,description FROM ec_faulty_code WHERE flag=0");
	if(mysqli_num_rows($sql)>0){
		$i=0;while($row=mysqli_fetch_array($sql)){
			$result[$i]['name']=$row['description'];
			$result[$i]['alias']=$row['faulty_alias'];
		$i++;}
	}else {$result['err_code']='-4';$result['err_msg']='No Records';}
	return $result;
}
function cells(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT customer_code,customer_alias,product_alias FROM ec_customer WHERE flag=0");
	if(mysqli_num_rows($sql)>0){
		//$i=0;while($row=mysqli_fetch_array($sql)){$xx=array();
			//$result[$i]['cust_code']=$row['customer_code'];
			//$result[$i]['cust_alias']=$row['customer_alias'];
			//$result[$i]['prod_alias']=str_replace(" ","",$row['product_alias']);
			//$aa=explode(",",str_replace(" ","",$row['product_alias']));
			//foreach($aa as $qq){$xx[]= alias($qq,'ec_product','product_alias','product_description');}
			//$result[$i]['prod_name']=implode(",",$xx);
		//$i++;}
		$i=0;while($row=mysqli_fetch_array($sql)){$xx=array();
			$result[$i]['cust_code']=$row['customer_code'];
			$result[$i]['cust_alias']=$row['customer_alias'];
			$result[$i]['prod_alias']=str_replace(" ","",$row['product_alias']);
			$aa=explode(",",str_replace(" ","",$row['product_alias']));
			foreach($aa as $qq){$bb[]=$qq;$yy[]=$xx[]= alias($qq,'ec_product','product_alias','product_description');}
			$result[$i]['prod_name']=implode(",",$xx);
			//$result['all_prod_alias']=implode(",",array_unique($bb));
			//$result['all_prod_name']=implode(",",array_unique($yy));
		$i++;}
		
	}else {$result['err_code']='-4';$result['err_msg']='No Records';}
	return $result;
}
function allcells(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT product_description,product_alias FROM ec_product WHERE flag=0");
	if(mysqli_num_rows($sql)>0){
		while($row=mysqli_fetch_array($sql)){$xx=array();
			$aa=explode(",",str_replace(" ","",$row['product_alias']));
			foreach($aa as $qq){$bb[]=$qq;$yy[]=$xx[]= $row['product_description'];}
			$result[0]['all_prod_alias']=implode(",",array_unique($bb));
			$result[0]['all_prod_name']=implode(",",array_unique($yy));
		}
	}else {$result['err_code']='-4';$result['err_msg']='No Records';}
	return $result;
}
function accessory(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT * FROM ec_accessories WHERE flag=0");
	if(mysqli_num_rows($sql)>0){
		$i=0;while($row=mysqli_fetch_array($sql)){
			$result[$i]['name']=$row['accessory_description'];
			$result[$i]['alias']=$row['accessories_alias'];
		$i++;}
	}else {$result['err_code']='-4';$result['err_msg']='No Records';}
	return $result;
}//service Engineer Obserations end
function activity(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT * FROM ec_activity WHERE flag=0");
	if(mysqli_num_rows($sql)>0){
		$i=0;while($row=mysqli_fetch_array($sql)){
			$result[$i]['activity_name']=$row['activity_name'];
			$result[$i]['activity_code']=$row['activity_code'];
			$result[$i]['activity_alias']=$row['activity_alias'];
		$i++;}
	}else {$result['err_code']='-4';$result['err_msg']='No Records';}
	return $result;
}
function complaint(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT * FROM ec_complaint WHERE flag=0");
	if(mysqli_num_rows($sql)>0){
		$i=0;while($row=mysqli_fetch_array($sql)){
			$result[$i]['complaint_name']=$row['complaint_name'];
			$result[$i]['complaint_alias']=$row['complaint_alias'];
		$i++;}
	}else {$result['err_code']='-4';$result['err_msg']='No Records';}
	return $result;
}

function moc(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT * FROM ec_moc WHERE flag=0");
	if(mysqli_num_rows($sql)>0){
		$i=0;while($row=mysqli_fetch_array($sql)){
			$result[$i]['moc_name']=$row['moc_name'];
			$result[$i]['moc_alias']=$row['moc_alias'];
		$i++;}
	}else {$result['err_code']='-4';$result['err_msg']='No Records';}
	return $result;
}

function milestone(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT mile_stone,mile_stone_alais FROM ec_milestone WHERE flag=0");
	if(mysqli_num_rows($sql)>0){
		$i=0;while($row=mysqli_fetch_array($sql)){
			$result[$i]['mile_stone']=$row['mile_stone'];
			$result[$i]['mile_stone_alias']=$row['mile_stone_alais'];
		$i++;}
	}else {$result['err_code']='-4';$result['err_msg']='No Records';}
	return $result;
}
function person_notified(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT * FROM ec_employee_master WHERE ths_notified='1' AND flag=0");
	if(mysqli_num_rows($sql)>0){
		$i=0;while($row=mysqli_fetch_array($sql)){
			$result[$i]['employee_name']=$row['name'];
			$result[$i]['employee_alias']=$row['employee_alias'];
		$i++;}
	}else {$result['err_code']='-4';$result['err_msg']='No Records';}
	return $result;
}
function menu_items($ref_id){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT submodule_name FROM ec_app_menu_items WHERE ref_id='$ref_id' AND flag=0");
	if(mysqli_num_rows($sql)>0){
	$i=0;while($row=mysqli_fetch_array($sql)){
		$result[$i]['name']=$row['submodule_name'];
	$i++;}
	}else {$result['err_code']='-4';$result['err_msg']='No Records';}
	return $result;
}
function error_check($emp_id,$function,$data){
	date_default_timezone_set("Asia/Kolkata");
	if(strpos($function,"|")!== false)$function = str_replace("|","_",$function);
	$f_name = $function."_".(!empty($emp_id) ? $emp_id : "empty")."_".date('Y_m_d_H_i_s');
	if(file_exists("error_checks/".$f_name.".txt"))$f_name = $f_name."_".rand();
	$myfile = fopen("error_checks/".$f_name.".txt", "w") or die("Unable to open file!");
	fwrite($myfile, $data);
	fclose($myfile);
}
function dpr_ref_no(){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT CONCAT('DPR',LPAD((SELECT SUBSTRING_INDEX(dpr_ref_no,'R',-1) FROM ec_dpr WHERE flag='0' ORDER BY id DESC LIMIT 1)+1, 5, '0')) AS dpr_no FROM ec_dpr WHERE flag='0'");
	$row = mysqli_fetch_array($sql);
	return $row['dpr_no'];
}
function all_tracks($emp_alias,$lat,$lng,$type,$submit_time){ global $mr_con;
	if(!empty($submit_time)){ $date_time1='date_time,'; $date_time2="'".date("Y-m-d H:i:s",strtotime($submit_time))."',"; }else $date_time1=$date_time2='';
	$tracking_alias=aliasCheck(generateRandomString(),'ec_user_tracking','tracking_alias');
	$sql=mysqli_query($mr_con,"INSERT INTO ec_user_tracking(employee_alias,lat,lng, $date_time1 type,tracking_alias)VALUES('$emp_alias','$lat','$lng', $date_time2 '$type','$tracking_alias')");
	return ($sql ? TRUE : FALSE );
}
function user_location_track(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$login = json_decode(base64_decode($login->key));
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$lat=$login->latitude;
		$lng=$login->longitude;
		$track_type=$login->track_type;
		if(empty($track_type))$track_type='0';
		$emp_alias=alias($emp_id,'ec_employee_master','employee_id','employee_alias');
		$res = all_tracks($emp_alias,$lat,$lng,$track_type,'');
		if($res){ $result['err_code']='0';$result['err_msg']='Success';}
		else {$result['err_code']='4';$result['err_msg']='Location Not Tracked';}
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	echo mobile_app_encode($result);
}
function dpr_submit(){ global $mr_con;
	date_default_timezone_set("Asia/Kolkata");
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$test_json=base64_decode($login->key);

	$login = json_decode($test_json);
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	
	//Obj
		$dpr_check = $test_json."_".date('Y_m_d_H_i_s')."\r\n\r\n";
		$fh = fopen("dpr_objects/DPR.txt", 'a') or die("can't open file");
		fwrite($fh, $dpr_check);
		fclose($fh);
	//obj
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$submit_time=$login->submit_time;
		$dpr_category=$login->dpr_category;
		if(empty($submit_time))$res="Submit Time Not Captured, Please Try Again";
		elseif(empty($dpr_category))$res="Please select DPR category";
		else{ $dpr_mail_ali="";
			$emp_alias=alias($emp_id,'ec_employee_master','employee_id','employee_alias');
			$expenses=$login->expenses;
			$start_time=$login->start_time;
			$on_site=$login->on_site;
			$off_site=$login->off_site;
			$end_time=$login->end_time;
			$total_hours=$login->total_hours;
			$lat=$login->latitude;
			$lng=$login->longitude;
			$tt_number = $login->tt_number;
			if($tt_number=='Select TT Number' || empty($tt_number))$ticket_alias="";
			else{
				$ticket_alias = alias_flag_none($tt_number,'ec_tickets','ticket_id','ticket_alias');
				if(empty($ticket_alias))$ticket_alias=$tt_number;
			}
			$dpr_address = (!empty($lat) || !empty($lng) ? mysqli_real_escape_string($mr_con,getAddress($lat, $lng)) : "");
			$remarks=mysqli_real_escape_string($mr_con,$login->remarks);
			$dpr_ref_no = dpr_ref_no();
			$tracking_alias=aliasCheck(generateRandomString(),'ec_user_tracking','tracking_alias');
			$ref_id=alias($dpr_category,'ec_dpr_category','category_alias','ref_id');
			if(!empty($ref_id)){
				$start_time=date("Y-m-d H:i:s", strtotime($start_time));
				$on_site=date("Y-m-d H:i:s", strtotime(date("Y-m-d", strtotime($start_time))." ".$on_site));
				$end_time=date("Y-m-d H:i:s", strtotime($end_time));
				$off_site=date("Y-m-d H:i:s", strtotime(date("Y-m-d", strtotime($end_time))." ".$off_site));
			}
			$submit_time=date("Y-m-d H:i:s",strtotime($submit_time));
			$submit_date=strtok($submit_time," ");
			$sql1=mysqli_query($mr_con,"SELECT category_alias,dpr_alias FROM ec_dpr WHERE sub_date_time LIKE '%$submit_date%' AND emp_alias='$emp_alias' AND flag='0'");
			if(mysqli_num_rows($sql1)){
				$row1=mysqli_fetch_array($sql1);
				if($row1['category_alias']=='0'){
					$sql=mysqli_query($mr_con,"UPDATE ec_dpr SET category_alias='$dpr_category',start_trvl_time='$start_time',on_site_time='$on_site',off_site_time='$off_site',end_trvl_time='$end_time',total_hours='$total_hours',ticket_alias='$ticket_alias',dpr_address='$dpr_address',remarks='$remarks',expense_incurred='$expenses',tracking_alias='$tracking_alias' WHERE emp_alias='$emp_alias' AND sub_date_time LIKE '%$submit_date%' AND flag='0'");
					if($sql){
						$dpr_mail_ali=$row1['dpr_alias'];
						$sql_se = mysqli_query($mr_con,"UPDATE ec_calender_event SET created_on='".date('Y-m-d')."',scheduled_on='".date('Y-m-d H:i:s')."',p_level='3' WHERE emp_alias='$emp_alias' AND p_level='0' AND sub_date_time LIKE '%$submit_date%' AND flag='0'");//event_alias='$dpr_mail_ali' AND event_type='2' AND
					}
				}else $res="DPR Already Submitted";
			}else{
				if(strtotime($submit_date) > strtotime(date("Y-m-d")))$res="Future DPR is Not Possible to Submit";
				else{
					$dpr_alias=aliasCheck(generateRandomString(),' ec_dpr','dpr_alias');
					$sql=mysqli_query($mr_con,"INSERT INTO ec_dpr(dpr_ref_no,emp_alias,category_alias,start_trvl_time,on_site_time,off_site_time,end_trvl_time,total_hours,ticket_alias,dpr_address,dpr_alias,remarks,expense_incurred,tracking_alias,sub_date_time) VALUES('$dpr_ref_no','$emp_alias','$dpr_category','$start_time','$on_site','$off_site','$end_time','$total_hours','$ticket_alias','$dpr_address','$dpr_alias','$remarks','$expenses','$tracking_alias','$submit_time')");
					if($sql){
						$dpr_mail_ali=$dpr_alias;
						$se_item_alias = aliasCheck(generateRandomString(),'ec_calender_event','alias');
						$sql_se = mysqli_query($mr_con,"INSERT INTO ec_calender_event(event_type,event_alias,created_on,scheduled_on,emp_alias,alias,p_level)VALUES('2','$dpr_alias','".date('Y-m-d')."','".date('Y-m-d H:i:s')."','$emp_alias','$se_item_alias','3')");
					}
				}
			}
			if(!isset($res)){
				if(!empty($dpr_mail_ali)){
					$sql2=mysqli_query($mr_con,"INSERT INTO ec_user_tracking(employee_alias,lat,lng,type,tracking_alias)VALUES('$emp_alias','$lat','$lng','4','$tracking_alias')");
					$sql3=mysqli_query($mr_con,"SELECT * FROM ec_dpr WHERE dpr_alias='$dpr_mail_ali' AND flag='0'");
					if($sql2 && mysqli_num_rows($sql3)){
						$row3=mysqli_fetch_array($sql3);
						$result['dpr_ref_no']=$row3['dpr_ref_no'];
						$result['dpr_category']=alias($row3['category_alias'],'ec_dpr_category','category_alias','category');
						$result['start_time']=(!empty($row3['start_trvl_time']) ? date("h:i a d/m/Y", strtotime($row3['start_trvl_time'])) : 'NA');
						$result['on_site']=$row3['on_site_time'];
						$result['off_site']=$row3['off_site_time'];
						$result['end_time']=(!empty($row3['end_trvl_time']) ? date("h:i a d/m/Y", strtotime($row3['end_trvl_time'])) : 'NA');
						$result['total_hours']=$row3['total_hours'];
						$result['tt_number']=($tt_number=='Select TT Number' || empty($tt_number) ? "NA" : $tt_number);
						$result['remarks']=$row3['remarks'];
						$result['expenses']=$row3['expense_incurred'];
						$result['latitude']=$lat;
						$result['longitude']=$lng;
						list($d_aa,$t_aa)=explode(" ",$row3['sub_date_time']);
						$result['submit_date']=date('Y/m/d',strtotime($d_aa));
						$result['submit_time']=date('h:i a', strtotime($t_aa));
						$result['err_code']='0';$result['err_msg']='Success';
					}else $res="Tracking failed";
				}else $res="DPR Not Submitted";
			}
		}
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	if(isset($res)){$result['err_code']='4';$result['err_msg']=$res;}
	echo mobile_app_encode($result);
	if(!empty($dpr_mail_ali))dpr_mail($dpr_mail_ali);
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
		$sub_date_time = dateTimeFormat($row['sub_date_time'],'d');
		$start_trvl_time = dateTimeFormat($row['start_trvl_time'],'d');
		$on_site_time = dateTimeFormat($row['on_site_time'],'d');
		$off_site_time = dateTimeFormat($row['off_site_time'],'d');
		$end_trvl_time = dateTimeFormat($row['end_trvl_time'],'d');
		$total_hours = $row['total_hours'];
		$ticket_id = (empty($row['ticket_alias']) ? 'NA' :alias($row['ticket_alias'],'ec_tickets','ticket_alias','ticket_id'));
		$dpr_address = (empty($row['dpr_address']) ? 'NA' : $row['dpr_address']);
		$se_sql = mysqli_query($mr_con,"SELECT role_alias,employee_id,name,state_alias,designation_alias,department_alias,email_id FROM ec_employee_master WHERE employee_alias='$emp_alias' AND flag='0'");
		if(mysqli_num_rows($se_sql)){
			$se_row = mysqli_fetch_array($se_sql);
			$se_id = $se_row['employee_id'];
			$se_name = $se_row['name'];
			$se_designation = alias($se_row['designation_alias'],'ec_designation','designation_alias','designation');
			$se_department = alias($se_row['department_alias'],'ec_department','department_alias','department_name');
			$se_mail = $se_row['email_id'];
			$se_state = $se_row['state_alias'];
			$role_alias = $se_row['role_alias'];
			if($role_alias=="QV9IPNVA1M" || $role_alias=="01ZMYJ4OLG"){
				$con = (!empty($se_state) ? "state_alias RLIKE '".str_replace(", ","|",$se_state)."' AND" : "");
				$sqlEsca = mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='OX5E3EMI0U' AND $con flag='0'");
				if(mysqli_num_rows($sqlEsca)>0 && !empty($con)){
					$rowesca=mysqli_fetch_array($sqlEsca);
					$zhsmail= $rowesca['email_id'];
				}else $zhsmail= "";
			}else $zhsmail="";
			$se_mail = (!empty($se_mail) && filter_var($se_mail, FILTER_VALIDATE_EMAIL) ? $se_mail : "");
			$to_mail_id = $se_mail.(!empty($zhsmail) && filter_var($zhsmail, FILTER_VALIDATE_EMAIL) ? ", ".$zhsmail : "");
			// $ccmail = 'ticket@enersys.co.in';
			$ccmail = '';
			$sub = "DPR @ $se_name @ $sub_date_time";
			$res="<p>Dear Team,</p>";
			$res.="<table width='600px' style='border-collapse:collapse;' cellpadding='3' align='center'>";
				$res.="<tr align='center'>";
					$res.="<th align='center' style='border:1px solid #ddd; border-bottom:1px solid #fff;'>";
						$res.="<table width='100%'>";
							$res.="<tr>";
								$res.="<th align='left'><img src='".baseurl()."mobile_app/pdf/images/e_logo_r.png' alt='EnerSys_logo' width='150'></th>";
								$res.="<th align='right'><h3>EnerSys India Batteries Pvt. Ltd.</h3></th>";
							$res.="</tr>";
						$res.="</table>";
					$res.="</th>";
				$res.="</tr>";
				$res.="<tr>";
					$res.="<td align='center' style='border:1px solid #ddd;'>";
						$res.="<table width='100%' cellpadding='3'>";
							$res.="<tr>";
								$res.="<td width='60%'></td>";
								$res.="<td align='left' width='13%'><b>DPR Date <br>DPR No </b></td>";
								$res.="<td align='left' width='27%'>: ".$sub_date_time."<br>: ".$dpr_ref_no."</td>";
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
							if(!empty($total_hours)){
								$res.="<tr>";
									$res.="<td style='border:1px solid #ddd;'><b>Start Travel Time : </b>".$start_trvl_time."</td>";
									$res.="<td style='border:1px solid #ddd;'><b>On Site Time : </b>".$on_site_time."</td>";
								$res.="</tr>";
								$res.="<tr>";
									$res.="<td style='border:1px solid #ddd;'><b>Off Site Time : </b>".$off_site_time."</td>";
									$res.="<td style='border:1px solid #ddd;'><b>End Travel Time : </b>".$end_trvl_time."</td>";
								$res.="</tr>";
								$res.="<tr>";
									$res.="<td style='border:1px solid #ddd;'><b>Total Hours : </b>".$total_hours."</td>";
									$res.="<td style='border:1px solid #ddd;'><b>Ticket No. : </b>".$ticket_id."</td>";
								$res.="</tr>";
							}
							$res.="<tr>";
								//$res.="<td style='border:1px solid #ddd;'><b>DPR Address : </b>".$dpr_address."</td>";
								$res.="<td style='border:1px solid #ddd;' colspan='2'><b>Remarks : </b>".strtoupper($remarks)."</td>";
							$res.="</tr>";
						$res.="</table>";
					$res.="<br><br></td>";
				$res.="</tr>";
			$res.="</table><br><br>";
			$res.="<p style='font-style:italic;text-align:center;'><small>*** This is a System generated email, Please do not reply ***</small></p>";
			$from=all_from_mail();
			$headers="From: EnerSys DPR<$from>\r\n";
			$headers.="Reply-To: $from\r\n";
			$headers.="Return-Path: $from\r\n";
			$headers .= "CC: $ccmail \r\n";
			//$headers .= "BCC: $bccmail \r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$abc = mail($to_mail_id,$sub,$res,$headers);
			if($abc)success_mail_log($dpr_alias,"DPR");
			else pending_mail_log($dpr_alias,"DPR");
			if($abc)return TRUE;else return FALSE;
		}
	}
}
function zhs_apr_submition(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$data=base64_decode($login->key);
	$login = json_decode(base64_decode($login->key));
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	$ticket_id=$login->ticket_id;
	error_check($emp_id,$ticket_id.'_zhssubmission',$data);
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$emp_alias=alias($emp_id,'ec_employee_master','employee_id','employee_alias');
		$ticket_alias=alias($ticket_id,'ec_tickets','ticket_id','ticket_alias');
		$milestone=$login->milestone;
		$payment_terms=$login->efficiency;
		$zonal_action=$login->action_taken;
		$remarks=$login->remarks;
		$cell_alias=(!empty($login->requiredcell) ? explode(",",$login->requiredcell) : array());
		$quanty=(!empty($login->requiredcellqty) ? explode(",",$login->requiredcellqty) : array());
		$acc_alias=(!empty($login->requiredacess) ? explode(",",$login->requiredacess) : array());
		$acc_qty=(!empty($login->requiredacessqty) ? explode(",",$login->requiredacessqty) : array());
		$purpose=alias($ticket_alias,'ec_tickets','ticket_alias','purpose');
		if(empty($milestone)){$res="Select Milestone";}
		elseif($milestone!='NHNYJS67AT' && $purpose=='1'){$res="Milestone doesn't match visit type";}
		elseif(empty($payment_terms)){$res="Select eFSR Efficiency";}
		elseif(empty($zonal_action)){$res="Select Zonal Action";}
		elseif(empty($remarks)){$res="Enter Remark";}
		else{$res=$con=$cel_act="";
			if(alias($ticket_alias,'ec_tickets','ticket_alias','level')=='3'){
				//cell required start
				$cell_alias_fil=array_filter($cell_alias);
				$acc_alias_fil=array_filter($acc_alias);
				$quanty_fil=array_filter($quanty);
				$acc_qty_fil=array_filter($acc_qty);
				
				$cell_count=count($cell_alias_fil);
				$acc_count=count($acc_alias_fil);
				$cell_qty=count($quanty_fil);
				$acc_qty=count($acc_qty_fil);
				if($acc_count || $cell_qty || $acc_qty){
					if($zonal_action!="1" && $zonal_action!="2"){
						if($acc_count<$acc_qty)$res="Select all Accessories";
						elseif($acc_count>$acc_qty)$res="Enter all Accessories Quantity";
						else{$cc=$ac=1; $cust_er=TRUE;
							if(isset($cust_file) && !empty($cust_file['name'])){
								$link = upload_file_mob($cust_file,'other_report','pdf');
								list($code,$msg) = explode(",",$link);
								//$code='0';$msg='test.pdf';
								if($code=='0'){ $cust_file = $msg;
									$con=",cust_file='$cust_file'";
								}else{$res=$msg; $cust_er = FALSE;}
							}
							if($cust_er){
								for($i=0;$i<$cell_count;$i++){
									$alias=aliasCheck(generateRandomString(),'ec_cell_required','item_alias');
									$ce_alias=alias(trim($cell_alias_fil[$i]),'ec_product','product_description','product_alias');
									$quant=trim($quanty_fil[$i]);
									$sqlReq = mysqli_query($mr_con,"INSERT INTO ec_cell_required(ticket_alias,item_type,cell_alias,quanty,item_alias)VALUES('$ticket_alias','1','$ce_alias','$quant','$alias')");
									$cc++;
								}
								for($i=0;$i<$acc_count;$i++){
									$alias=aliasCheck(generateRandomString(),'ec_cell_required','item_alias');
									$ac_alias=alias(trim($acc_alias_fil[$i]),'ec_accessories','accessory_description','accessories_alias');
									$ac_quant=trim($acc_qty_fil[$i]);
									$sqlReq = mysqli_query($mr_con,"INSERT INTO ec_cell_required(ticket_alias,item_type,cell_alias,quanty,item_alias)VALUES('$ticket_alias','2','$ac_alias','$ac_quant','$alias')");
									$ac++;
								}
								if($cc>1 || $ac>1)$cel_act = " and Requiered".($cc>1 ? " Cells":"").($cc>1&&$ac>1 ? " and Requiered ":"").($ac>1 ? "Accessories":"")." added.";
							}
						}
					}else $res="Required ".($cell_qty>0 ? "Cells":"").($cell_qty>0 && $acc_count>0 ? " and Required ":"").($acc_count>0 ? "Accessories":"")." not neccessory for ".($zonal_action=="1" ? 'CLOSED' : 'DECLINED')." Ticket.";
				}
				//cell required end
				if(empty($res)){
					$remarks=mysqli_real_escape_string($mr_con,$remarks);
					$cl_date = alias($ticket_alias,'ec_tickets','ticket_alias','closing_date');
					$efsr_date = alias($ticket_alias,'ec_tickets','ticket_alias','efsr_date');
					$closing_date = (empty($cl_date) || $cl_date=='0000-00-00' ? $efsr_date : $cl_date);
					$custNum=alias(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','technician_number');
					$closedMsg="Dear Customer your Ticket No-".$ticket_id." is closed on Dt-".$closing_date.".For feedback contact 040-67046704 For more details please check your e-mail";
					$declienedMsg="Dear Customer your Ticket No-".$ticket_id." is decliened on Dt-".$closing_date.".For feedback contact 040-67046704 For more details please check  your e-mail";
					if($zonal_action=="1"){ $bucket='1'; //Close Ticket
						$sub_con="level='7', old_level='3', status='CLOSED'";sub_tickets_close_decline($ticket_alias,$sub_con);$msg = $closedMsg; $action = "Ticket ".$ticket_id." Closed at zonal level";
						$acc = mysqli_query($mr_con,"UPDATE ec_cell_required SET approved_stat='6' WHERE ticket_alias='$ticket_alias' AND flag='0'");
					}elseif($zonal_action=="2"){ $bucket='2'; //BB Not Maintained Properly
						$sub_con="level='6', old_level='3', status='DECLINED'";sub_tickets_close_decline($ticket_alias,$sub_con);$msg = $declienedMsg;$action = "Ticket ".$ticket_id." Declined at zonal level";
						$acc = mysqli_query($mr_con,"UPDATE ec_cell_required SET approved_stat='6' WHERE ticket_alias='$ticket_alias' AND flag='0'");
					}elseif($zonal_action=="3"){ $bucket='9';$sub_con="level='4', old_level='3'";$msg = 'NA';$action = "Ticket ".$ticket_id." sent to NHS Approval Required";} //NHS Approval Required
					elseif($zonal_action=="4"){ $bucket='11'; //Next visit
						//$acc = mysqli_query($mr_con,"UPDATE ec_cell_required SET approved_stat='1', approved_by='$emp_alias', approved_on='".date('Y-m-d')."' WHERE ticket_alias='$ticket_alias' AND flag='0'");
						$sub_con="level='5', old_level='3', status='VISITED'"; subticket($ticket_alias,'0');$msg = 'NA'; $action = "Ticket ".$ticket_id." Zonal Approved and go to second visit";
					}
					$rec_ca=alias($ticket_alias,'ec_cell_required','ticket_alias','id');
					if($zonal_action!="3" || ($zonal_action=="3" && $rec_ca!='')){
						$sqlTT = mysqli_query($mr_con,"UPDATE ec_tickets SET milestone='$milestone',payment_terms='$payment_terms',$sub_con,transaction_date='".date('Y-m-d')."' $con WHERE ticket_alias='$ticket_alias' AND flag=0");
						$alias=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
						$sqlRem = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','TT','$bucket','$ticket_alias','$emp_alias','$alias')");
						if($sqlTT && $sqlRem){
							if($zonal_action=="1"){
								$mess="Ticket No - $ticket_id against the Activity ".alias(alias($ticket_alias,"ec_tickets","ticket_alias","activity_alias"),"ec_activity","activity_alias","activity_name")." of Site name-".alias(alias($ticket_alias,"ec_tickets","ticket_alias","site_alias"),"ec_sitemaster","site_alias","site_name")." is CLOSED on Dt-".$closing_date.".";
								ticket_notification($ticket_alias,$mess);
								//zhs_nhs_close_mail($ticket_alias);
								curlxing(baseurl()."services/tickets/mails/zhs_nhs_close_mail?ticket_alias=".$ticket_alias);
							}elseif($zonal_action=="2"){
								$mess="Ticket No - $ticket_id against the Activity ".alias(alias($ticket_alias,"ec_tickets","ticket_alias","activity_alias"),"ec_activity","activity_alias","activity_name")." of Site name-".alias(alias($ticket_alias,"ec_tickets","ticket_alias","site_alias"),"ec_sitemaster","site_alias","site_name")." is DECLINED on Dt-".$closing_date.".";
								ticket_notification($ticket_alias,$mess);
								//zhs_nhs_decline_mail($ticket_alias);
								curlxing(baseurl()."services/tickets/mails/zhs_nhs_decline_mail?ticket_alias=".$ticket_alias);
							}elseif($zonal_action=="3"){
								$mess="Ticket No - $ticket_id against the Activity ".alias(alias($ticket_alias,"ec_tickets","ticket_alias","activity_alias"),"ec_activity","activity_alias","activity_name")." of Site name-".alias(alias($ticket_alias,"ec_tickets","ticket_alias","site_alias"),"ec_sitemaster","site_alias","site_name")." is Sent to NHS for Approval.";
								ticket_notification($ticket_alias,$mess);
							}elseif($zonal_action=="4")ticket_notification($ticket_alias,"Ticket No - $ticket_id against the Activity ".alias(alias($ticket_alias,"ec_tickets","ticket_alias","activity_alias"),"ec_activity","activity_alias","activity_name")." of Site name-".alias(alias($ticket_alias,"ec_tickets","ticket_alias","site_alias"),"ec_sitemaster","site_alias","site_name")." is next visit generated by ZHS");
							user_history($emp_alias,$action.$cel_act,'ZHS SUBMITTED USING MOBILE APP');
							if($msg!='NA')messageSent($custNum,$msg);
							$resCode="0";$resMsg="Successful!";
						}else{$res="Error In Updating";}
					}else $res="There is No Required Cells OR Accessories to sent NHS approval";
				}
			}else $res="This Ticket is not belongs to ZHS at this time or else this ticket is already submitted";
		}if(isset($res) && !empty($res)){$resCode="4";$resMsg=$res;}
		$result['err_code']=$resCode;$result['err_msg']=$resMsg;
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	error_check($emp_id,$ticket_id.'_zhs_result',json_encode($result));
	echo mobile_app_encode($result);
}
function nhs_apr_submition(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$data=base64_decode($login->key);
	$login = json_decode(base64_decode($login->key));
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	$ticket_id=$login->ticket_id;
	error_check($emp_id,$ticket_id.'_nhssubmission',$data);
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$emp_alias=alias($emp_id,'ec_employee_master','employee_id','employee_alias');
		$ticket_alias=alias($ticket_id,'ec_tickets','ticket_id','ticket_alias');
		$nhs_action=$login->action_taken;
		$remarks=$login->remarks;
		if(empty($nhs_action)){$res="Select NHS Action";}
		elseif(empty($remarks)){$res="Enter Remark";}
		else{
			if(alias($ticket_alias,'ec_tickets','ticket_alias','level')=='4'){
				$remarks=mysqli_real_escape_string($mr_con,$remarks);
				$ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
				$cl_date = alias($ticket_alias,'ec_tickets','ticket_alias','closing_date');
				$efsr_date = alias($ticket_alias,'ec_tickets','ticket_alias','efsr_date');
				$closing_date = (empty($cl_date) || $cl_date=='0000-00-00' ? $efsr_date : $cl_date);
				$custNum=alias(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','technician_number');
				$closedMsg="Dear Customer your Ticket No-".$ticket_id." is closed on Dt-".$closing_date.".For feedback contact 040-67046704 For more details please check your e-mail";
				$declienedMsg="Dear Customer your Ticket No-".$ticket_id." is decliened on Dt-".$closing_date.".For feedback contact 040-67046704 For more details please check  your e-mail";
				if($nhs_action=="1"){ $bucket='38'; //Close Ticket
					$sub_con="level='7', old_level='4', status='CLOSED',";sub_tickets_close_decline($ticket_alias,$sub_con);$msg = $closedMsg; $action = "Ticket ".$ticket_id." Closed at NHS level";
					$acc = mysqli_query($mr_con,"UPDATE ec_cell_required SET approved_stat='6' WHERE ticket_alias='$ticket_alias' AND flag='0'");
				}elseif($nhs_action=="2"){ $bucket='39'; //BB Not Maintained Properly
					$sub_con="level='6', old_level='4', status='DECLINED',";sub_tickets_close_decline($ticket_alias,$sub_con);$msg = $declienedMsg;$action = "Ticket ".$ticket_id." Declined at NHS level";
					$acc = mysqli_query($mr_con,"UPDATE ec_cell_required SET approved_stat='6' WHERE ticket_alias='$ticket_alias' AND flag='0'");
				}elseif($nhs_action=="3"){$bucket='10'; $sub_con="level='8', old_level='4',";$msg = 'NA';$action = "Ticket ".$ticket_id." NHS sent to TS Approval Required";} //TS Approval Required
				elseif($nhs_action=="4"){ $bucket='37'; //Next visit
					$sub_con="level='5', old_level='4', status='VISITED',"; subticket($ticket_alias,'0');$msg = 'NA'; $action = "Ticket ".$ticket_id." NHS Approved and go to next visit";
				}else $sub_con="";
				if(!empty($sub_con)){
					$rec_ca=alias($ticket_alias,'ec_cell_required','ticket_alias','id');
					if($nhs_action!="3" || ($nhs_action=="3" && $rec_ca)){
						$sqlTT = mysqli_query($mr_con,"UPDATE ec_tickets SET $sub_con transaction_date='".date('Y-m-d')."' WHERE ticket_alias='$ticket_alias' AND flag=0");
						$alias=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
						$sqlRem = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','TT','$bucket','$ticket_alias','$emp_alias','$alias')");
						if($sqlTT && $sqlRem){
							if($nhs_action=="1"){
								$mess="Ticket No - $ticket_id against the Activity ".alias(alias($ticket_alias,"ec_tickets","ticket_alias","activity_alias"),"ec_activity","activity_alias","activity_name")." of Site name-".alias(alias($ticket_alias,"ec_tickets","ticket_alias","site_alias"),"ec_sitemaster","site_alias","site_name")." is CLOSED on Dt-".$closing_date.".";
								ticket_notification($ticket_alias,$mess);
								curlxing(baseurl()."services/tickets/mails/zhs_nhs_close_mail?ticket_alias=".$ticket_alias);//zhs_nhs_close_mail($ticket_alias);
							}elseif($nhs_action=="2"){
								$mess="Ticket No - $ticket_id against the Activity ".alias(alias($ticket_alias,"ec_tickets","ticket_alias","activity_alias"),"ec_activity","activity_alias","activity_name")." of Site name-".alias(alias($ticket_alias,"ec_tickets","ticket_alias","site_alias"),"ec_sitemaster","site_alias","site_name")." is DECLINED on Dt-".$closing_date.".";
								ticket_notification($ticket_alias,$mess);
								curlxing(baseurl()."services/tickets/mails/zhs_nhs_decline_mail?ticket_alias=".$ticket_alias);//zhs_nhs_decline_mail($ticket_alias);
							}elseif($nhs_action=="3"){
								ticket_notification($ticket_alias,"NHS Send to TS");
								curlxing(baseurl()."services/tickets/mails/nhs_approve_mail?ticket_alias=".$ticket_alias);
							}else ticket_notification($ticket_alias,"NHS generate Next Visit"); // $nhs_action=="4"
							user_history($emp_alias,$action,'NHS SUBMITTED USING MOBILE APP');
							if($msg!='NA')messageSent($custNum,$msg);
							$resCode="0";$resMsg="Successful!";
						}else{$res="Error In Updating";}
					}else $res="There is No Required Cells OR Accessories to sent TS approval";
				}else $res="Wrong In NHS Action selection";
			}else $res="This Ticket is not belongs to NHS at this time or else this ticket is already submitted";
		}if(isset($res) && !empty($res)){$resCode="4";$resMsg=$res;}
		$result['err_code']=$resCode;$result['err_msg']=$resMsg;
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	error_check($emp_id,$ticket_id.'_nhs_result',json_encode($result));
	echo mobile_app_encode($result);
}
function sub_tickets_close_decline($ticket_alias,$sub_con){ global $mr_con;
	$ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
	if (strpos($ticket_id,"|")!== false){
		$tt = explode("|",$ticket_id);
		$ticket = $tt[0];
		$ret = $ticket."|".end($tt);
		$sqlTT = mysqli_query($mr_con,"UPDATE ec_tickets SET $sub_con,transaction_date='".date('Y-m-d')."' WHERE ticket_id='$ticket' AND flag=0");
		$acc_inv = mysqli_query($mr_con,"UPDATE ec_tickets_inventory SET material_inward='2',material_outward='2' WHERE ticket_alias='$ticket_alias' AND flag='0'");
		for($i=2;$i<end($tt);$i++){
			$ticket1 = $ticket."|".$i;
			$sqlTT = mysqli_query($mr_con,"UPDATE ec_tickets SET $sub_con,transaction_date='".date('Y-m-d')."' WHERE ticket_id='$ticket1' AND flag=0");
		}
	}
}
function subticket($ticket_alias,$purpose){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT ticket_id,activity_alias,login_date,site_alias,complaint_alias,mode_of_contact,contact_link,description,n_visits,warranty FROM ec_tickets WHERE ticket_alias='$ticket_alias' AND flag=0");
	$row=mysqli_fetch_array($sql);
	$ticket_id=subTTCheck($row['ticket_id']);
	$login_date=$row['login_date'];
	$n_visits=$row['n_visits'];
	$warranty=$row['warranty'];
	$activity_alias=$row['activity_alias'];
	$site_alias=$row['site_alias'];
	$complaint_alias=$row['complaint_alias'];
	$mode_of_contact=mysqli_real_escape_string($mr_con,$row['mode_of_contact']);
	$contact_link=mysqli_real_escape_string($mr_con,$row['contact_link']);
	$description=mysqli_real_escape_string($mr_con,$row['description']);
	$alias = aliasCheck(generateRandomString(),'ec_tickets','ticket_alias');
	$sql1 = mysqli_query($mr_con,"INSERT INTO ec_tickets(ticket_id,activity_alias,site_alias,complaint_alias,mode_of_contact,contact_link,description,login_date,visit_gen_date,level,old_level,status,n_visits,warranty,purpose,ticket_alias)VALUES('$ticket_id','$activity_alias','$site_alias','$complaint_alias','$mode_of_contact','$contact_link','$description','$login_date','".date('Y-m-d H:i:s')."','1','1','OPEN','$n_visits','$warranty','$purpose','$alias')");
	if($sql1){
		$acc_inv = mysqli_query($mr_con,"INSERT INTO ec_tickets_inventory(ticket_alias,material_outward)VALUES('$alias','1')");
		$cell = alias($ticket_alias,'ec_cell_required','ticket_alias','id');
		if(!empty($cell))$sql2 = mysqli_query($mr_con,"UPDATE ec_cell_required SET ticket_alias='$alias' WHERE ticket_alias='$ticket_alias' AND approved_stat='2' AND flag='0'");
	}
}
function subTTCheck($ticket_id){
	if (strpos($ticket_id,"|")!== false){
		$tt = explode("|",$ticket_id);
		$ret = $tt[0]."|".(end($tt)+1);
	}else{$ret = $ticket_id."|2";}
	return $ret;
}
function ts_apr_submition(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$login = json_decode(base64_decode($login->key));
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$emp_alias=alias($emp_id,'ec_employee_master','employee_id','employee_alias');
		$ticket_id=$login->ticket_id;
		$ticket_alias=alias($ticket_id,'ec_tickets','ticket_id','ticket_alias');
		
		$app_qty=$login->app_qty;
		$item_alias=$login->item_alias;
		$line_number=$login->line_number;
		$shift=$login->shift;
		$date_of_assembly=$login->date_of_assembly;
		$date_of_jar_form=$login->date_of_jar_form;
		$corect_act_Plan=$login->corect_act_Plan;
		$persons_notified=$login->persons_notified;
		$faulty_cell_num=$login->faulty_cell_num;
		$ocv_at_dispatch=$login->ocv_at_dispatch;
		$tenth_hour=$login->tenth_hour;
		$ths_action=$login->action_taken;
		$remarks=$login->remarks;

		$res="";
		if(empty($ths_action)){$res="Select TS Action";}
		if(empty($remarks)){$res="Enter Remark";}
		else{
			if($ths_action=="1"){ //TS Approved
				$f_count=count($faulty_cell_num);
				$o_count=count($ocv_at_dispatch);
				$t_count=count($tenth_hour);
				if(empty($line_number)){$res="Enter Line Number";}
				elseif(empty($shift)){$res="Select Shift";}
				elseif(empty($date_of_assembly) || $date_of_assembly=='NA'){$res="Choose Date Of Assembly";}
				elseif(empty($date_of_jar_form) || $date_of_jar_form=='NA'){$res="Choose Date Of Jar Formation";}
				elseif(empty($corect_act_Plan)){$res="Enter Correct Action Plan";}
				elseif(empty($persons_notified) || count($persons_notified)=='0'){$res="Select Persons Notified";}
				elseif($f_count=='0' || $f_count!=count(array_filter($faulty_cell_num))){$res="Enter Faulty Cell Number";}
				elseif($o_count=='0' || $o_count!=count(array_filter($ocv_at_dispatch))){$res="Enter Ocv At Dispatch";}
				elseif($t_count=='0' || $t_count!=count(array_filter($tenth_hour))){$res="Enter 10th Hour Reading";}
				elseif($f_count!=count(array_unique($faulty_cell_num))){$res="Duplicate Faulty Cell Numbers are not allowed";}
				else{
					$alias=aliasCheck(generateRandomString(),'ec_ths_approved','alias');
					$sqlThs = mysqli_query($mr_con,"INSERT INTO ec_ths_approved(ticket_alias,line_number,shift,date_of_assembly,date_of_jar_form,corect_act_Plan,persons_notified,alias)VALUES('$ticket_alias','$line_number','$shift','$date_of_assembly','$date_of_jar_form','$corect_act_Plan','".implode("|",$persons_notified)."','$alias')");
					if($sqlThs){
						for($i=0;$i<$f_count;$i++){
							$faulty_ocv_alias[$i]=aliasCheck(generateRandomString(),'ec_ths_faulty_ocv','alias');
							$sqlThs_fo = mysqli_query($mr_con,"INSERT INTO ec_ths_faulty_ocv(ths_appr_alias,faulty_cell_num,ocv,tenth_hour,alias)VALUES('$alias','$faulty_cell_num[$i]','$ocv_at_dispatch[$i]','$tenth_hour[$i]','$faulty_ocv_alias[$i]')");
						}
					}
					$ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
					$acc = mysqli_query($mr_con,"UPDATE ec_cell_required SET approved_stat='2', approved_by='$emp_alias', approved_on='".date('Y-m-d')."' WHERE ticket_alias='$ticket_alias' AND flag='0'");
					$acc_inv = mysqli_query($mr_con,"UPDATE ec_tickets_inventory SET material_outward='1' WHERE ticket_alias='$ticket_alias' AND flag='0'");
					$sub_con="level='5',old_level='8',status='VISITED',"; subticket($ticket_alias);$msg = 'NA'; $action = "Ticket ".$ticket_id." TS Approved and go to second visit";
				}
			}elseif($ths_action=="2"){ //$ths_action=="5" -> TS Reject.
				$sub_con="level='4',old_level='8',status='VISITED',"; $action = "Ticket ".$ticket_id." TS Rejected the ticket";
			}
			elseif($ths_action=="3"){ // Items Approved.
				$app_count=count($app_qty);
				$item_count=count($item_alias);
				if($app_count=='0' || $app_count!=count(array_filter($app_qty))){$res="Enter Approved Quantity";}	
				elseif($item_count=='0' || $item_count!=count(array_filter($item_alias))){$res="Something Went Wrong";}
				else{
					for($i=0;$i<$app_count;$i++){
						$acc = mysqli_query($mr_con,"UPDATE ec_cell_required SET quanty='".$app_qty[$i]."', approved_stat='2', approved_by='$emp_alias', approved_on='".date('Y-m-d')."' WHERE ticket_alias='$ticket_alias' AND item_alias='".$item_alias[$i]."' AND approved_stat='1' AND flag='0'");
					}
					$acc_inv = mysqli_query($mr_con,"UPDATE ec_tickets_inventory SET material_outward='1' WHERE ticket_alias='$ticket_alias' AND flag='0'");
					$sub_con="level='1', old_level='8', status='OPEN',";$msg = 'NA';$action = "Ticket ".$ticket_id." Cells approved at TS level";
				}
			}
			elseif($ths_action=="4"){ // Items Rejected.
				$rej = mysqli_query($mr_con,"DELETE FROM ec_cell_required WHERE ticket_alias='$ticket_alias' AND approved_stat='1' AND flag='0'");
				$sub_con="level='1', old_level='8', status='OPEN',";$msg = 'NA';$action = "Ticket ".$ticket_id." Cells rejected at TS level";
			}
			if(empty($res)){
				$sqlTT = mysqli_query($mr_con,"UPDATE ec_tickets SET $sub_con transaction_date='".date('Y-m-d')."' WHERE ticket_alias='$ticket_alias' AND flag=0");
				$alias=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
				$sqlRem = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias)VALUES('$remarks','TT','$ticket_alias','$emp_alias','$alias')");
				if($sqlTT && $sqlRem){
					user_history($emp_alias,$action,'SUBMITTED USING MOBILE APP');
					//if($msg!='NA')messageSent($custNum,$msg);
					$resCode="0";$resMsg="Successful!";
					if($ths_action=="1" || $ths_action=="3"){
						ticket_notification($ticket_alias,"TS Approved");
						$xx=baseurl()."services/tickets/mails/ts_approve_mail?ticket_alias=".$ticket_alias;
						curlxing($xx);
					}
					elseif($ths_action=="2" || $ths_action=="4"){
						ticket_notification($ticket_alias,"TS Rejected");
						$xx=baseurl()."services/tickets/mails/ts_reject_mail?ticket_alias=".$ticket_alias;
						curlxing($xx);
					}
				}else{$res="Error In Updating";}
			}
		}
		if(isset($res)){$resCode="4";$resMsg=$res;}
		$result['err_code']=$resCode;$result['err_msg']=$resMsg;
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	echo mobile_app_encode($result);
}

function md_apr_submition(){
	$request = \Slim\Slim::getInstance()->request();
	echo md_foa_toa_apr_submition($request,'MD');
}
function foa_apr_submition(){
	$request = \Slim\Slim::getInstance()->request();
	echo md_foa_toa_apr_submition($request,'FOA');
}
function toa_apr_submition(){
	$request = \Slim\Slim::getInstance()->request();
	echo md_foa_toa_apr_submition($request,'TOA');
}
function md_foa_toa_apr_submition($request,$ref){ global $mr_con;
	$login = json_decode($request->getBody());
	$login = json_decode(base64_decode($login->key));
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$sjo_number=$login->sjo_number;
		$approval=$login->action_taken;
		$remarks=$login->remarks;
		if(empty($approval)){$res="Select $ref Action";}
		elseif(empty($remarks)){$res="Enter Remark";}
		else{
			$emp_alias=alias($emp_id,'ec_employee_master','employee_id','employee_alias');
			$mrf_alias=alias($sjo_number,'ec_material_request','sjo_number','mrf_alias');
			$mrf_status=alias($mrf_alias,'ec_material_request','mrf_alias','status');
			if($mrf_status=="1" || $mrf_status=="7"){ // Dynamic Level
				if(($approval=='1' || $approval=='2' || $approval=='3') && !empty($mrf_alias)){
					$list=next_dynamic($mrf_alias,'E','L');
					if(!empty($list)){
						list($next,$emp_ali)=explode("_",$list);
						if($approval=='1'){$condition=" status = '".($next=='L' ? '2':'1')."' ";$action = "Dynamic Approve:".alias($emp_alias,'ec_employee_master','employee_alias','name')." Approve"; $bucket="21";}
						elseif($approval=='2'){$condition=" status = '10' ";$action = "Dynamic Reject:".alias($emp_alias,'ec_employee_master','employee_alias','name')." Reject"; $bucket="22";}
						else {$condition=" status = '7' ";$action = "Dynamic Hold:".alias($emp_alias,'ec_employee_master','employee_alias','name')." Hold"; $bucket="20";}
						if($approval=='1' || $approval=='2'){
							if(strpos($emp_ali,",")!==false)$cooo="IN('".str_replace(",","','",$emp_ali)."')";else $cooo="='$emp_ali'";
							$sql = mysqli_query($mr_con,"UPDATE ec_dynamic_verification SET flag='1' WHERE mrf_alias='$mrf_alias' AND employee_alias $cooo AND flag=0");
						}
					}else{$condition=" status = '2' ";$action = "Dynamic Approve: Approve"; $bucket="21"; }
					$q=mysqli_query($mr_con,"SELECT sjo_number FROM ec_material_request WHERE mrf_alias='$mrf_alias' AND flag=0");
					if(mysqli_num_rows($q)>0){
						$mrf_row=mysqli_fetch_array($q);
						$sql=mysqli_query($mr_con,"UPDATE ec_material_request SET $condition WHERE mrf_alias='$mrf_alias' AND flag=0");
						if($sql){ $sjo_number = $mrf_row['sjo_number'];
							$remark_alias = alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias');
							$sql2 = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','MR','$bucket','$mrf_alias','$emp_alias','$remark_alias')");
							$privilege_alias=alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias');
							$arrr=array("ZHS","NHS","HO","PPC");
							if($privilege_alias=="NCPAT7QPTK")array_push($arrr,"TS");
							$sql4=mysqli_query($mr_con,"SELECT id FROM ec_request_items WHERE mrf_alias='$mrf_alias' AND item_type='1' AND cell_type='2' AND flag='0'");
							$from_wh=alias($mrf_alias,'ec_material_request','mrf_alias','from_wh');
							$state_alais = alias($from_wh,'ec_warehouse','wh_alias','state_alias');
							$fam_msg1="Dear Team, ".alias($privilege_alias,'ec_dynamic_levels','privilege_alias','level_name')." Action Against the SJO Number $sjo_number is ".($bucket=="20" ? "Hold" : ($bucket=="21" ? "Approved":"Reject")).($bucket!="21" ? "": (mysqli_num_rows($sql4)=='0' && $privilege_alias=="NCPAT7QPTK" ? ", This request is Processed for further Approval." : ", Kindly Initiate the further Process."));
							ecSendSms('approval1_approved_rejected', $state_alias, "", $fam_msg);
							/*
							foreach(sms_contacts($mrf_alias,$arrr) as $phnum1)messageSent($phnum1,$fam_msg1);
							*/
							if(empty(next_dynamic($mrf_alias,'E'))){
								list($ticket_id,$req_items)=explode("_@",request_desc_sms($mrf_alias,"CUST"));
								$fam_msg2="Dear Customer, Material request against $ticket_id, of $req_items was processed, will update Material readiness status shortly.";
								$custNo = alias($mrf_alias,'ec_material_request','mrf_alias','customer_phone');
								ecSendSms('mr_customer_communication', $state_alias, $custNo, $fam_msg2);
								/*
								foreach(sms_contacts($mrf_alias,array("CUST","HO")) as $phnum2)messageSent($phnum2,$fam_msg2);	
								*/
							}
							$action=$action." the requested Stock against SJO Number - ".$sjo_number;
							curlxing(baseurl()."services/inventory/mails/mrdmails?a=".$mrf_alias);
							inventory_notification($mrf_alias,$action,'3');
							user_history($emp_alias,$action,$_REQUEST['ip_addr']);
							$resCode='0';$resMsg='Successful!';
						}else{$res='Error in Updating!';}
					}else{$res='Action Not Succesful! Try again Later';}
				}else $res = 'No Request Found to Approve';
			}else $res = $mrf_status.'SJO approval by wrong one'.$mrf_alias;
		}
		if(isset($res)){$resCode="4";$resMsg=$res;}
		$result['err_code']=$resCode;$result['err_msg']=$resMsg;
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	return mobile_app_encode($result);
}
function ticket_submit(){
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$login = json_decode(base64_decode($login->key));
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;		  
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$alias=aliasCheck(generateRandomString(),' ec_tickets','ticket_alias');
		$dpr_ref_no = dpr_ref_no();
		$dpr_category=$login->dpr_category;
		$start_time=$login->end_time;//start_time;
		$on_site=$login->end_time;//on_site;
		$off_site=$login->end_time;//off_site;
		$end_time=$login->end_time;
		$total_hours=$login->total_hours;
		$tt_number=$login->tt_number;
		$remarks=$login->remarks;
		$expenses=$login->expenses;
		//$submit_time=$login->submit_time;
		//$start_time=date("Y-m-d H:i", strtotime($start_time));
		//$end_time=date("Y-m-d H:i", strtotime($end_time));
		$submit_time=$login->submit_time;
		if($dpr_category=='0'){$res="Please Select DprCategory";}
		elseif(empty($start_time)){$res="Please Enter Start Time";}
		elseif(empty($on_site)){$res="Please Enter On Site Time";}
		elseif(empty($off_site)){$res="Please Enter Off Site Time";}
		elseif(empty($end_time)){$res="Please Enter End Time";}
		elseif(empty($total_hours)){$res="Please Enter Total Hours";}
		elseif($tt_number=='0'){$res="Please Select TTNumber";}
		elseif(empty($remarks)){$res="Please Enter Remarks";}
		elseif(empty($expenses)){$res="Please Enter Expenses";}
		else{
			$emp_alias=alias($emp_id,'ec_employee_master','employee_id','employee_alias');
			$result['err_code']='0';$result['err_msg']='Success';
			$result['dpr_ref_no']=$dpr_ref_no;
			$result['dpr_category']=alias($dpr_category,'ec_dpr_category','category_alias','category');
			$result['start_time']=/*$start_time;*/date("h:i a d/m/Y", strtotime($start_time));//$start_time;
			$result['on_site']=$login->on_site;/*$on_site;*///date("h:i a d/m/Y", strtotime($on_site));//$end_time;
			$result['off_site']=$login->off_site;/*$off_site;*///date("h:i a d/m/Y", strtotime($off_site));//$end_time;
			$result['end_time']=date("h:i a d/m/Y", strtotime($end_time));//date("d/m/Y h:i a", strtotime($login->end_time));//$end_time;
			$result['total_hours']=$total_hours;
			$result['tt_number']=alias($tt_number,'ec_tickets','ticket_alias','ticket_id');
			$result['remarks']=$remarks;
			$result['expenses']=$expenses;
			$aa=explode(" ",$submit_time);
			$result['submit_date']=date('d/m/Y',strtotime($aa[0]));
			$result['submit_time']=date('h:i a', strtotime($aa[1]));
		}
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	echo mobile_app_encode($result);
}
function other_issue_fun($ticket_alias,$module,$other_issue,$other_image){ global $mr_con;
	$other_alias = aliasCheck(generateRandomString(),'ec_other_issues','item_alias');
	$other_sql = mysqli_query($mr_con,"INSERT INTO ec_other_issues(ticket_alias,module,other_issue,other_image,item_alias)VALUES('$ticket_alias','$module','$other_issue','$other_image','$other_alias')");
	return ($other_sql ? TRUE : FALSE);
}
function implode_fun($obj_arr,$ref){ global $mr_con;
	$temp=array();
	if(is_array($obj_arr)){
		foreach($obj_arr as $val)$temp[]=$val[$ref];
		return implode(", ",array_filter($temp));
	}
}
function valid_object($segment_alias,$update){ global $mr_con;
	if(!empty($segment_alias)){
		if(!isset($update['ticket_details']) || empty($update['ticket_details']) ||
			!isset($update['employee_info']) || empty($update['employee_info']) ||
			!isset($update['customer_comments']) || empty($update['customer_comments']) ||
			!isset($update['service_eng_observation']) || empty($update['service_eng_observation']))$already_exist=FALSE;
		elseif($update['ticket_details']['bob']=='1' && (!isset($update['battery_observation_report']) || empty($update['battery_observation_report'])))$already_exist=FALSE;
		elseif($segment_alias=='YGRKJJD4N7' && //MOTIVEPOWER
			(!isset($update['charger_details']) || empty($update['charger_details']) ||
			!isset($update['forklift_details']) || empty($update['forklift_details']) ||
			!isset($update['motive_physical_observation']) || empty($update['motive_physical_observation'])))$already_exist=FALSE;
		elseif($segment_alias=='TQMBDTF5ZI' && //RAILWAYS
			(!isset($update['equipment_details']) || empty($update['equipment_details']) ||
			!isset($update['general_observation']) || empty($update['general_observation']) ||
			!isset($update['history_of_coach']) || empty($update['history_of_coach'])))$already_exist=FALSE;
		elseif($segment_alias!='YGRKJJD4N7' && $segment_alias!='TQMBDTF5ZI' && $segment_alias!='TMRY7UL2VI' && // Neither MOTIVEPOWER nor RAILWAYS and OTHER
			(!isset($update['general_physical_observation']) || empty($update['general_physical_observation']) ||
			!isset($update['geneartor_observation']) || empty($update['geneartor_observation'])))$already_exist=FALSE;
		else{
			$site_input=($segment_alias=="W0PBT7IAZE" ? mysqli_real_escape_string($mr_con,strtoupper($update['general_physical_observation']['site_input'])) : "");
			if($segment_alias=="KWJCZKSTBL" || $segment_alias=="DDEYO7NTTC"){ // Solar || Telecom Solar
				$phy_dg_status=mysqli_real_escape_string($mr_con,strtoupper(trim($update['general_physical_observation']['dg_status'])));
				$phy_eb_status=mysqli_real_escape_string($mr_con,strtoupper(trim($update['general_physical_observation']['eb_status'])));
			}else $phy_dg_status=$phy_eb_status="";
			if($segment_alias=="W0PBT7IAZE" && $site_input=='FCBC' && //POWERCONTROL
				(!isset($update['fcbc_observation']) || empty($update['fcbc_observation'])))$already_exist=FALSE;
			elseif(($segment_alias=="SMEY7SL24I" && (!isset($update['ups_observation']) || empty($update['ups_observation']))) ||  //UPS || POWERCONTROL || Solar
				($segment_alias=="W0PBT7IAZE" && $site_input=='UPS' && (!isset($update['ups_observation']) || empty($update['ups_observation']))) ||
				(($segment_alias=="KWJCZKSTBL" && ($phy_dg_status=="DG SITE" || $phy_eb_status=="EB SITE")) && (!isset($update['ups_observation']) || empty($update['ups_observation']))))$already_exist=FALSE;
			elseif(($segment_alias=="KWJCZKSTBL" || $segment_alias=="DDEYO7NTTC") && //Solar || Telecom Solar
				(!isset($update['solar_panel_observation']) || empty($update['solar_panel_observation'])))$already_exist=FALSE;
			elseif(($segment_alias=="HXL5A1HOTZ" && (!isset($update['smps_observation']) || empty($update['smps_observation']))) ||  // Telecom || POWERCONTROL || Telecom Solar
				($segment_alias=="W0PBT7IAZE" && $site_input=='SMPS' && (!isset($update['smps_observation']) || empty($update['smps_observation']))) ||
				(($segment_alias=="DDEYO7NTTC" && ($phy_dg_status=="DG SITE" || $phy_eb_status=="EB SITE")) && (!isset($update['smps_observation']) || empty($update['smps_observation']))))$already_exist=FALSE;
			else $already_exist=TRUE;
		}
	}else $already_exist=FALSE;
	return $already_exist;
}
function segment_alias_fun($segment){
	switch($segment){
		case 'TELECOM': $segment_alias='HXL5A1HOTZ';break;
		case 'MOTIVEPOWER': $segment_alias='YGRKJJD4N7';break;
		case 'RAILWAY': $segment_alias='TQMBDTF5ZI';break;
		case 'SOLAR': $segment_alias='KWJCZKSTBL';break;
		case 'POWERCONTROL': $segment_alias='W0PBT7IAZE';break;
		case 'TELECOMSOLAR': $segment_alias='DDEYO7NTTC';break;
		case 'UPS': $segment_alias='SMEY7SL24I';break;
		case 'OTHER': $segment_alias='TMRY7UL2VI';break;
		default : $segment_alias='';
	}return $segment_alias;
}
function efsr_submit(){	
	global $mr_con;
	date_default_timezone_set("Asia/Kolkata");
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(), true);
	$test_json=base64_decode($login['key'],true);
	$update = json_decode($test_json,true);
	$tt_type=trim($update['ticket_details']['tt_type']);
	$ticket_alias=mysqli_real_escape_string($mr_con,strtoupper($update['ticket_details']['ticket_alias']));
	if(empty($ticket_alias)){
		$temp_tt=$ticket_alias=mysqli_real_escape_string($mr_con,strtoupper($update['ticket_details']['ticket_no']));
		if($tt_type=='0')$ticket_alias=alias($ticket_alias,'ec_tickets','ticket_id','ticket_alias');
	}else $temp_tt=$ticket_id=($tt_type!='0' ? $ticket_alias : alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id'));

	//obj start
		if(strpos($temp_tt,"|")!== false)$temp_tt = str_replace("|","_",$temp_tt);
		if(file_exists("ticket_objects/".$temp_tt.".txt"))$temp_tt = $temp_tt."_".rand();
		$myfile = fopen("ticket_objects/".$temp_tt.".txt", "w") or die("Unable to open file!");
		fwrite($myfile, $test_json);
		fclose($myfile);
	//obj end
	
	/*if(file_exists("ticket_objects/".$ticket_id1.".txt")){
		$result['err_code']='0';$result['err_msg']="Success";
	}else {$result['err_code']='-4';$result['err_msg']="File Not Stored";}
	*/
	
	$emp_id=$update['employee_info']['emp_id'];
	$device_id=$update['employee_info']['device_id'];
	$lat=$update['employee_info']['lat'];
	$lng=$update['employee_info']['lon'];
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	$tele_mail="";
	
	if($rex=='0'){ 
		$already_exist=TRUE;$res="";
		$efsr_start=$update['ticket_details']['efsr_start'];
		$efsr_date=$update['ticket_details']['efsr_date'];
		$service_engineer_alias = alias($emp_id,'ec_employee_master','employee_id','employee_alias');
		all_tracks($service_engineer_alias,$lat,$lng,'3','');
		if($tt_type=='1'){ //Spot TT //1
			$rrrr=mysqli_query($mr_con,"SELECT id FROM ec_tickets WHERE ticket_id='$ticket_id' AND flag='1'");
			if(mysqli_num_rows($rrrr)=='0'){
				if(isset($update['ticket_details']['site_details']) && !empty($update['ticket_details']['site_details'])){
					$segment_alias=segment_alias_fun(strtoupper(trim($update['ticket_details']['site_details']['segment'])));
					if(valid_object($segment_alias,$update)){
						$mssg_activity_name=$activity_alias=mysqli_real_escape_string($mr_con,strtoupper($update['ticket_details']['site_details']['activity']));
						$site_id=mysqli_real_escape_string($mr_con,strtoupper($update['ticket_details']['site_details']['site_id']));
						$mssg_site_name=$site_name=mysqli_real_escape_string($mr_con,strtoupper($update['ticket_details']['site_details']['site_name']));
						$zone=mysqli_real_escape_string($mr_con,strtoupper($update['ticket_details']['site_details']['zone']));
						$state=mysqli_real_escape_string($mr_con,strtoupper($update['ticket_details']['site_details']['state']));
						$district=mysqli_real_escape_string($mr_con,strtoupper($update['ticket_details']['site_details']['district']));
						$mfg_date=dateFormat($update['ticket_details']['site_details']['mfg_date'],'y');
						$install_date=dateFormat($update['ticket_details']['site_details']['install_date'],'y');
						$no_of_banks=$update['ticket_details']['site_details']['no_of_banks'];
						$f_l_name=mysqli_real_escape_string($mr_con,strtoupper($update['ticket_details']['site_details']['f_l_name']));
						$f_l_number=$update['ticket_details']['site_details']['f_l_number'];
						$s_l_name=mysqli_real_escape_string($mr_con,strtoupper($update['ticket_details']['site_details']['s_l_name']));
						$s_l_number=$update['ticket_details']['site_details']['s_l_number'];
						$s_l_email=mysqli_real_escape_string($mr_con,strtolower($update['ticket_details']['site_details']['s_l_email']));
						$segment=strtoupper(trim($update['ticket_details']['site_details']['segment']));
						$site_type=mysqli_real_escape_string($mr_con,strtoupper($update['ticket_details']['site_details']['site_type']));
						$customer_name=mysqli_real_escape_string($mr_con,strtoupper($update['ticket_details']['site_details']['customer_name']));
						$product_code=mysqli_real_escape_string($mr_con,strtoupper($update['ticket_details']['site_details']['product_code']));
						$site_address=mysqli_real_escape_string($mr_con,strtoupper($update['ticket_details']['site_details']['site_address']));
						$dattme=date('Y-m-d H:i:s');
						$dat=date('Y-m-d');
						$segment_alias=segment_alias_fun($segment);
						$site_alias=aliasCheck(generateRandomString(),'ec_sitemaster','site_alias');
						$sql = mysqli_query($mr_con,"INSERT INTO ec_sitemaster(zone_alias,state_alias,district_alias,segment_alias,customer_alias,site_type_alias,site_id,site_name,site_alias,product_alias,mfd_date,install_date,no_of_string,technician_name,technician_number,manager_name,manager_number,manager_mail,site_address,lat,lng,created_date,flag)VALUES('$zone','$state','$district','$segment_alias','$customer_name','$site_type','$site_id','$site_name','$site_alias','$product_code','$mfg_date','$install_date','$no_of_banks','$f_l_name','$f_l_number','$s_l_name','$s_l_number','$s_l_email','$site_address','$lat','$lng','$dat','1')");
						$ticket_alias=aliasCheck(generateRandomString(),'ec_tickets','ticket_alias');
						$tt_sql = mysqli_query($mr_con,"INSERT INTO ec_tickets(ticket_id,activity_alias,site_alias,login_date,visit_gen_date,planned_date,service_engineer_alias,level,old_level,n_visits,transaction_date,status,ticket_alias,flag)VALUES('$ticket_id','$activity_alias','$site_alias','$dattme','$dattme','$dat','$service_engineer_alias','2','2','0','$dat','OPEN','$ticket_alias','1')");
						//$tt_sql = mysqli_query($mr_con,"INSERT INTO ec_tickets(ticket_id,activity_alias,site_alias,login_date,planned_date,service_engineer_alias,level,old_level,n_visits,transaction_date,status,warranty,ticket_alias,flag)VALUES('$ticket_id','$activity_alias','$site_alias','".date('Y-m-d H:i:s')."','".date('Y-m-d')."','$service_engineer_alias','2','2','0','".date('Y-m-d')."','OPEN','".sitemanfdate_check($site_alias)."','$ticket_alias','1')");
					}else{$already_exist=FALSE;$res="Some fields are missing";}
				}else {$already_exist=FALSE; $res="Some fields are missing";}
			}else $already_exist=FALSE;
		 }elseif($tt_type=='2'){ //Off line TT //2
			$rrrr=mysqli_query($mr_con,"SELECT id FROM ec_tickets WHERE ticket_id='$ticket_id' AND flag='2'");
			if(mysqli_num_rows($rrrr)=='0'){
				if(isset($update['ticket_details']) && !empty($update['ticket_details'])){
					$segment_alias=segment_alias_fun(strtoupper($update['ticket_details']['segment']));
					if(valid_object($segment_alias,$update)){
						$ticket_alias=aliasCheck(generateRandomString(),'ec_tickets','ticket_alias');
						$mssg_activity_name = alias(alias($ticket_alias,'ec_tickets','ticket_alias','activity_alias'),'ec_activity','activity_alias','activity_name');
						$mssg_site_name=$site_name=mysqli_real_escape_string($mr_con,strtoupper($update['ticket_details']['site_name']));
						$tt_sql = mysqli_query($mr_con,"INSERT INTO ec_tickets(ticket_id,complaint_alias,description,service_engineer_alias,ticket_alias,flag)VALUES('$ticket_id','$segment_alias','$site_name','$service_engineer_alias','$ticket_alias','2')");
					}else {$already_exist=FALSE; $res="Some fields are missing";}
				}else {$already_exist=FALSE; $res="Some fields are missing";}
			}else $already_exist=FALSE;
		}else{ //Exist TT
			//$ticket_alias = alias($ticket_id,'ec_tickets','ticket_id','ticket_alias');
			$site_alias = alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
			$segment_alias = alias_flag_none($site_alias,'ec_sitemaster','site_alias','segment_alias');
			if(valid_object($segment_alias,$update)){
				if(listchecking('ec_physical_observation',$ticket_alias) &&
				   listchecking('ec_technical_observation',$ticket_alias) &&
				   listchecking('ec_general_observation',$ticket_alias) &&
				   listchecking('ec_power_observation',$ticket_alias) &&
				   listchecking('ec_battery_bank_bb_cap',$ticket_alias) &&
				   listchecking('ec_engineer_observation',$ticket_alias) &&
				   listchecking('ec_customer_comments',$ticket_alias) &&
				   listchecking('ec_customer_satisfaction',$ticket_alias) &&
				   listchecking('ec_e_signature',$ticket_alias)){
					//SiteMaster Update
					$mssg_activity_name = alias(alias($ticket_alias,'ec_tickets','ticket_alias','activity_alias'),'ec_activity','activity_alias','activity_name');
					$mssg_site_name = alias_flag_none($site_alias,'ec_sitemaster','site_alias','site_name');
					$con_site = "";
					if(!empty($lat))$con_site .= "lat='$lat',";
					if(!empty($lng))$con_site .= "lng='$lng',";
					if(!empty($lat) && !empty($lng)){
						$address_site=getAddress($lat, $lng);
						if(!empty($address_site)){$con_site .= "site_address='$address_site',";}
					}
					if($segment_alias=="TQMBDTF5ZI")$man_install = $update['history_of_coach']; //RAILWAY
					elseif($segment_alias=="YGRKJJD4N7")$man_install = $update['motive_physical_observation']; //MOTIVE POWER
					else $man_install = $update['general_physical_observation'];//Remaining all
					$man_date = dateFormat($man_install['noofbank']['valuemanandinstall'][0]['manufaturing_date'],"y");
					$inst_date = dateFormat($man_install['noofbank']['valuemanandinstall'][0]['installation_date'],"y");
					//$man_date = dateFormat($update['ticket_details']['manufacturing_date'],"y");
					//$inst_date = dateFormat($update['ticket_details']['install_date'],"y");
					
					$aa=alias_flag_none($site_alias,'ec_sitemaster','site_alias','mfd_date');
					$bb=alias_flag_none($site_alias,'ec_sitemaster','site_alias','install_date');
					if(!empty($man_date) && $man_date!='NA' && (empty($aa) || $aa=='NA' || $aa=='0000-00-00'))$con_site .= "mfd_date='$man_date',";
					if(!empty($inst_date) && $inst_date!='NA' && (empty($bb) || $bb=='NA' || $bb=='0000-00-00'))$con_site .= "install_date='$inst_date',";
					$sql = mysqli_query($mr_con,"UPDATE ec_sitemaster SET $con_site flag=0 WHERE site_alias='$site_alias'");
				}else $already_exist=FALSE;
			}else {$already_exist=FALSE; $res="Some fields are missing";}
		}
		if($already_exist){
			if($segment_alias!="TMRY7UL2VI"){ //OTHER
				if($segment_alias!="TQMBDTF5ZI" && $segment_alias!="YGRKJJD4N7"){ // Neither Railways nor Motive power
					if($segment_alias=="W0PBT7IAZE"){$site_input=mysqli_real_escape_string($mr_con,strtoupper($update['general_physical_observation']['site_input']));}else $site_input="";
					//physical_observations
					$physical_alias = aliasCheck(generateRandomString(),'ec_physical_observation','item_alias');
					//New
					$bank_size=mysqli_real_escape_string($mr_con,strtoupper($update['general_physical_observation']['noofbank']['banksize']));
					$valuemanandinstall=(isset($update['general_physical_observation']['noofbank']['valuemanandinstall']) ? $update['general_physical_observation']['noofbank']['valuemanandinstall'] : array());
					foreach($valuemanandinstall as $manandinstall)noofbank($ticket_alias,$bank_size,$manandinstall['manufaturing_date'],$manandinstall['installation_date'],$manandinstall['bbmake'],$manandinstall['bbcapacity']);
					$physical_damages=mysqli_real_escape_string($mr_con,strtoupper($update['general_physical_observation']['any_physical_damages']));
					$leakage=mysqli_real_escape_string($mr_con,strtoupper($update['general_physical_observation']['any_leakage']));
					$physical_damages=(strtoupper(trim($physical_damages))=='YES'  ? implode_fun($update['general_physical_observation']['valuephysicalcondition'],'value') : 'NO');
					$leakage=(strtoupper(trim($leakage))=='YES' ? implode_fun($update['general_physical_observation']['valueleakage'],'value') : 'NO');
					$temp_type=mysqli_real_escape_string($mr_con,strtoupper($update['general_physical_observation']['temp_type']));
					$valueindoortemp =(isset($update['general_physical_observation']['valueindoortemp']) ? implode_fun($update['general_physical_observation']['valueindoortemp'],'value') : '');
					$valueoutdoortemp =(isset($update['general_physical_observation']['valueoutdoortemp']) ? implode_fun($update['general_physical_observation']['valueoutdoortemp'],'value') : '');
					$room_temp =mysqli_real_escape_string($mr_con,strtoupper($update['general_physical_observation']['room_temp']));
					$ambient_temp =mysqli_real_escape_string($mr_con,strtoupper($update['general_physical_observation']['ambient_temp']));
					//$temperature=(!empty($valueindoortemp) ? $valueindoortemp : $valueoutdoortemp)."|".$room_temp."|".$ambient_temp;
					$temperature=(!empty($temp_type) ? $temp_type : $temp_type)."|".$room_temp."|".$ambient_temp;
					$temp_data=(!empty($valueindoortemp) ? $valueindoortemp : $valueoutdoortemp);
					$general_observation=(isset($update['general_physical_observation']['generalobservation']) ? implode_fun($update['general_physical_observation']['generalobservation'],'value') : '');
					$terminal_torque =mysqli_real_escape_string($mr_con,strtoupper($update['general_physical_observation']['terminal_torque']));
					if(strtoupper(trim($terminal_torque))=="LOOSE"){
						$no_of_cell_loose =mysqli_real_escape_string($mr_con,strtoupper($update['general_physical_observation']['torquenoofcellloose']));
						$no_of_cell_tightened =mysqli_real_escape_string($mr_con,strtoupper($update['general_physical_observation']['torquenoofcellperfect']));
						$terminal_torque=$terminal_torque."|".$no_of_cell_loose."|".$no_of_cell_tightened;
					}
					$vent_plug =mysqli_real_escape_string($mr_con,strtoupper($update['general_physical_observation']['vent_plug']));
					if(strtoupper(trim($vent_plug))=="LOOSE"){
						$no_of_cell_loose =mysqli_real_escape_string($mr_con,strtoupper($update['general_physical_observation']['ventnoofcellloose']));
						$no_of_cell_tightened =mysqli_real_escape_string($mr_con,strtoupper($update['general_physical_observation']['ventnoofcellperfect']));
						$vent_plug=$vent_plug."|".$no_of_cell_loose."|".$no_of_cell_tightened;
					}
					$other_issue =mysqli_real_escape_string($mr_con,strtoupper($update['general_physical_observation']['otherissue']['name'])); //new
					$other_image = (isset($update['general_physical_observation']['otherissue']['image']) ? base64_to_file('other_image_phyobs',$update['general_physical_observation']['otherissue']['image'],'doc') : '0'); //new
					other_issue_fun($ticket_alias,"PHYOBS",$other_issue,$other_image);
					$physical_damage_image = (isset($update['general_physical_observation']['physical_con_image']) ? base64_to_file('physical_damage_image',$update['general_physical_observation']['physical_con_image'],'doc') : '0');
					$leakage_image = (isset($update['general_physical_observation']['physical_leakage_image']) ? base64_to_file('leakage_image',$update['general_physical_observation']['physical_leakage_image'],'doc') : '0');
					if($segment_alias=="KWJCZKSTBL" || $segment_alias=="DDEYO7NTTC"){ // Solar || Telecom Solar
						$cleanness=$update['general_physical_observation']['modules_cleanness'];
						$phy_dg_status=$update['general_physical_observation']['dg_status'];
						$phy_eb_status=$update['general_physical_observation']['eb_status'];
						$dg_eb_status=(!empty($phy_dg_status) && !empty($phy_eb_status) ? $phy_dg_status."|".$phy_eb_status : "");
						$con_nm="cleanness,dg_eb_status,";
						$con_val="'$cleanness','$dg_eb_status',";
					}else{$phy_dg_status=$phy_eb_status=$con_nm=$con_val="";}
					$physical_sql = mysqli_query($mr_con,"INSERT INTO ec_physical_observation(ticket_alias,physical_damages,leakage,temperature,temp_data,general_observation,terminal_torque,vent_plug_thickness,$con_nm item_alias,physical_damages_document,leakage_document)VALUES('$ticket_alias','$physical_damages','$leakage','$temperature','$temp_data','$general_observation','$terminal_torque','$vent_plug',$con_val '$physical_alias','$physical_damage_image','$leakage_image')");
					//$result['asdf']['err_msg']="INSERT INTO ec_physical_observation(ticket_alias,physical_damages,leakage,temperature,general_observation,terminal_torque,vent_plug_thickness,item_alias,physical_damages_document,leakage_document)VALUES('$ticket_alias','$physical_damages','$leakage','$temperature','$general_observation','$terminal_torque','$vent_plug','$physical_alias','$physical_damage_image','$leakage_image')";

					//generator_observations
					$general_alias = aliasCheck(generateRandomString(),'ec_general_observation','item_alias');
					$dg_status =mysqli_real_escape_string($mr_con,strtoupper($update['geneartor_observation']['dg_status']));
					
					$dg_make=(isset($update['geneartor_observation']['makeouput']['dg_make']) ? strtoupper(implode_fun($update['geneartor_observation']['makeouput']['dg_make'],'name')) : '');
					
					$dg_capacity =mysqli_real_escape_string($mr_con,strtoupper($update['geneartor_observation']['makeouput']['dg_capacity']));
					$dg_working_condition=(isset($update['geneartor_observation']['makeouput']['dg_working_condition']) ? strtoupper(implode_fun($update['geneartor_observation']['makeouput']['dg_working_condition'],'name')) : '');
					$avg_dg_run =mysqli_real_escape_string($mr_con,strtoupper($update['geneartor_observation']['makeouput']['average_dg_run']));

					//$site_load =mysqli_real_escape_string($mr_con,strtoupper($update['geneartor_observation']['site_load'])); //old
					$dg_output =mysqli_real_escape_string($mr_con,strtoupper($update['geneartor_observation']['makeouput']['dg_output'])); //new

					$dg_pic = (isset($update['geneartor_observation']['dg_image']) ? base64_to_file('dg_pic',$update['geneartor_observation']['dg_image'],'doc') : '0');
					$general_sql = mysqli_query($mr_con,"INSERT INTO ec_general_observation(ticket_alias,dg_status,dg_make,dg_capacity,dg_working_condition,avg_dg_run,dg_output,item_alias,dg_pic)VALUES('$ticket_alias','$dg_status','$dg_make','$dg_capacity','$dg_working_condition','$avg_dg_run','$dg_output','$general_alias','$dg_pic')");

					//power_observation
					$power_alias = aliasCheck(generateRandomString(),'ec_power_observation','item_alias');
					$ebinstalldate =mysqli_real_escape_string($mr_con,dateFormat($update['geneartor_observation']['ebinstalldate'],"y")); //new
					$failures_per_day =mysqli_real_escape_string($mr_con,strtoupper($update['geneartor_observation']['noofpowercut']));
					$eb_supply =(isset($update['geneartor_observation']['ebsupplyavailable']) ? strtoupper($update['geneartor_observation']['ebsupplyavailable']) :'');
					$avg_power_cut =mysqli_real_escape_string($mr_con,strtoupper($update['geneartor_observation']['avgpowercut']));
					$other_issue =mysqli_real_escape_string($mr_con,strtoupper($update['geneartor_observation']['otherissue']['name'])); //new
					$other_image = (isset($update['geneartor_observation']['otherissue']['image']) ? base64_to_file('other_image_gnrlobs',$update['geneartor_observation']['otherissue']['image'],'doc') : '0'); //new
					other_issue_fun($ticket_alias,"GNRLOBS",$other_issue,$other_image);
					$power_sql = mysqli_query($mr_con,"INSERT INTO ec_power_observation(ticket_alias,eb_supply,failures_per_day,avg_power_cut,ebinstalldate,item_alias)VALUES('$ticket_alias','$eb_supply','$failures_per_day','$avg_power_cut','$ebinstalldate','$power_alias')");
				}
				if($segment_alias=="TQMBDTF5ZI"){ //Railways
					//coach_history
					$coach_alias = aliasCheck(generateRandomString(),'ec_coach_history','item_alias');
					$train_no=mysqli_real_escape_string($mr_con,strtoupper($update['history_of_coach']['trainnumber']));
					$express_name=mysqli_real_escape_string($mr_con,strtoupper($update['history_of_coach']['expressname']));
					$coach_no=mysqli_real_escape_string($mr_con,strtoupper($update['history_of_coach']['coachnumber']));
					$pre_attnd=mysqli_real_escape_string($mr_con,strtoupper(dateFormat($update['history_of_coach']['previous_attendant_date'],"y")));
					$poh=mysqli_real_escape_string($mr_con,strtoupper(dateFormat($update['history_of_coach']['poh_date'],"y")));
					$rpoh=mysqli_real_escape_string($mr_con,strtoupper(dateFormat($update['history_of_coach']['rpoh_date'],"y")));
					$zone=mysqli_real_escape_string($mr_con,strtoupper($update['history_of_coach']['zone']));
					$division=mysqli_real_escape_string($mr_con,strtoupper($update['history_of_coach']['division']));
					$workshop=mysqli_real_escape_string($mr_con,strtoupper($update['history_of_coach']['workshopyard']));
					$coach_sql = mysqli_query($mr_con,"INSERT INTO ec_coach_history(ticket_alias,train_no,express_name,coach_no,pre_attnd,poh,rpoh,zone,division,workshop,item_alias)VALUES('$ticket_alias','$train_no','$express_name','$coach_no','$pre_attnd','$poh','$rpoh','$zone','$division','$workshop','$coach_alias')");	
					//New
					$bank_size=mysqli_real_escape_string($mr_con,strtoupper($update['history_of_coach']['noofbank']['banksize']));
					$valuemanandinstall=$update['history_of_coach']['noofbank']['valuemanandinstall'];
					foreach($valuemanandinstall as $manandinstall)noofbank($ticket_alias,$bank_size,$manandinstall['manufaturing_date'],$manandinstall['installation_date'],$manandinstall['bbmake'],$manandinstall['bbcapacity']);
					
					//equipment_details
					$equip_alias = aliasCheck(generateRandomString(),'ec_equip_details','item_alias');
					$altenate_make=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['alternator_make']['value']));
					$rru_make=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['rru_erru_make']));
					$invertor_make=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['invertor_make']['value']));
					$regulator_make=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['regular_make']));
					$voltage_regulation=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['volateg_regulation']));
					$altenate_belt_status=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['alternator_belt_status']['value']));
					$altenate_make_doc = (isset($update['equipment_details']['alternator_make']['image']) ? base64_to_file('altenate_make_doc',$update['equipment_details']['alternator_make']['image'],'doc') : '0');
					$altenate_belt_doc = (isset($update['equipment_details']['alternator_belt_status']['image']) ? base64_to_file('alternator_belt_status',$update['equipment_details']['alternator_belt_status']['image'],'doc') : '0');
					$invertor_make_doc = (isset($update['equipment_details']['invertor_make']['image']) ? base64_to_file('invertor_make_doc',$update['equipment_details']['invertor_make']['image'],'doc') : '0'); //new
					
					//New column name
					//alternator_capacity,current_limit,equip_charger_cut_off,high_voltage_cut_off,invertor_mode,low_voltage_cut_off,invertor_make_doc
					$alternator_capacity=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['alternator_capacity']));
					$current_limit=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['current_limit']));
					$equip_charger_cut_off=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['equip_charger_cut_off']));
					$high_voltage_cut_off=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['high_voltage_cut_off']));
					$invertor_mode=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['invertor_mode']));
					$low_voltage_cut_off=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['low_voltage_cut_off']));
					
					$equip_sql = mysqli_query($mr_con,"INSERT INTO ec_equip_details(ticket_alias,altenate_make,altenate_make_doc,rru_make,invertor_make,regulator_make,voltage_regulation,altenate_belt_status,alternator_capacity,current_limit,equip_charger_cut_off,high_voltage_cut_off,invertor_mode,low_voltage_cut_off,altenate_belt_doc,invertor_make_doc,item_alias)VALUES('$ticket_alias','$altenate_make','$altenate_make_doc','$rru_make','$invertor_make','$regulator_make','$voltage_regulation','$altenate_belt_status','$alternator_capacity','$current_limit','$equip_charger_cut_off','$high_voltage_cut_off','$invertor_mode','$low_voltage_cut_off','$altenate_belt_doc','$invertor_make_doc','$equip_alias')");
					
					//check_points OR General Observation
					$check_points_alias = aliasCheck(generateRandomString(),'ec_check_points','item_alias');
					$icc_tightness=mysqli_real_escape_string($mr_con,strtoupper($update['general_observation']['icc_tightness']));
					$heating_melting_marks=mysqli_real_escape_string($mr_con,strtoupper($update['general_observation']['heat_melt_make']));
					$terminal_tightness=mysqli_real_escape_string($mr_con,strtoupper($update['general_observation']['terminal_tightness']));
					$alt_no_belt_avl=mysqli_real_escape_string($mr_con,strtoupper($update['general_observation']['alternator_belt']));
					
					$vent_plug_tightness=mysqli_real_escape_string($mr_con,strtoupper($update['general_observation']['vent_plug_tightness']));
					$belt=mysqli_real_escape_string($mr_con,strtoupper($update['general_observation']['v_belt']));
					$log_book=mysqli_real_escape_string($mr_con,strtoupper($update['general_observation']['log_book']));
					$coach_status=mysqli_real_escape_string($mr_con,strtoupper($update['general_observation']['coach_status']));
					$cell_buldge=mysqli_real_escape_string($mr_con,strtoupper($update['general_observation']['cell_buldge']['value']));
					
					$terminal_temp=mysqli_real_escape_string($mr_con,strtoupper($update['general_observation']['terminal_temp'])); //new
					$physical_damage=mysqli_real_escape_string($mr_con,strtoupper($update['general_observation']['any_physical_damages']));
					$leakage=mysqli_real_escape_string($mr_con,strtoupper($update['general_observation']['any_leakage'])); //new
					$physical_condition=(strtoupper(trim($physical_damage))=='YES' && isset($update['general_observation']['valuephysicalcondition'])  ? implode_fun($update['general_observation']['valuephysicalcondition'],'value') : ''); //new
					$leakage_condition=(strtoupper(trim($leakage))=='YES' && isset($update['general_observation']['valueleakagecondition']) ? implode_fun($update['general_observation']['valueleakagecondition'],'value') : ''); //new
					
					$cell_buldge_pic = (isset($update['general_observation']['cell_buldge_image']['image']) ? base64_to_file('cell_buldge_pic',$update['general_observation']['cell_buldge_pic']['image'],'doc') : '0');
					$physical_damage_pic = (isset($update['general_observation']['physical_con_image']) ? base64_to_file('physical_damage_pic',$update['general_observation']['physical_con_image'],'doc') : '0');
					$leakage_image_pic = (isset($update['general_observation']['Leakage_image']) ? base64_to_file('Leakage_image',$update['general_observation']['Leakage_image'],'doc') : '0'); //new
					$check_points_sql = mysqli_query($mr_con,"INSERT INTO ec_check_points(ticket_alias,icc_tightness,heating_melting_marks,terminal_tightness,alt_no_belt_avl,physical_damage,leakage,physical_condition,leakage_condition,terminal_temp,physical_damage_pic,vent_plug_tightness,belt,log_book,coach_status,cell_buldge,cell_buldge_pic,leakage_image_pic,item_alias)VALUES('$ticket_alias','$icc_tightness','$heating_melting_marks','$terminal_tightness','$alt_no_belt_avl','$physical_damage','$leakage','$physical_condition','$leakage_condition','$terminal_temp','$physical_damage_pic','$vent_plug_tightness','$belt','$log_book','$coach_status','$cell_buldge','$cell_buldge_pic','$leakage_image_pic','$check_points_alias')");
				}
				elseif($segment_alias=="YGRKJJD4N7"){ //Motive Power
					//Physical observation
					
					//New
					$bank_size=mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['noofbank']['banksize']));
					$valuemanandinstall=$update['motive_physical_observation']['noofbank']['valuemanandinstall'];
					foreach($valuemanandinstall as $manandinstall)noofbank($ticket_alias,$bank_size,$manandinstall['manufaturing_date'],$manandinstall['installation_date'],$manandinstall['bbmake'],$manandinstall['bbcapacity']);
					
					$physical_alias = aliasCheck(generateRandomString(),'ec_physical_observation','item_alias');
					$physical_damages=mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['any_physical_damages']));
					$leakage=mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['any_leakage']));
					$physical_condition=(strtoupper(trim($physical_damages))=='YES' && isset($update['motive_physical_observation']['valuephysicalcondition'])  ? implode_fun($update['motive_physical_observation']['valuephysicalcondition'],'value') : '');
					$leakage_condition=(strtoupper(trim($leakage))=='YES' && isset($update['motive_physical_observation']['valueleakagecondition']) ? implode_fun($update['motive_physical_observation']['valueleakagecondition'],'value') : '');
					$battery_top =mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['battery_top'])); //new
					$bb_condition =mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['bb_condition'])); //new
					if(strtoupper(trim($bb_condition))=="LIVE"){
						$room_temperature =mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['room_temp']));
						$ambient_temperature =mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['ambient_temp']));
						$temperature="INDOOR|".$room_temperature."|".$ambient_temperature;
						
						$electrolyte_temp_before =mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['electrolyte_temp_before'])); //new
						$electrolyte_temp_before_restperiod =mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['electrolyte_temp_before_restperiod'])); //new
						$electrolyte_temp_before_hr =mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['electrolyte_temp_before_hr'])); //new
						$elect_temp_bfr_rest_hr=$electrolyte_temp_before_restperiod."|".$electrolyte_temp_before_hr;
					
						$electrolyte_temp_after =mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['electrolyte_temp_after'])); //new
						$electrolyte_temp_after_restperiod =mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['electrolyte_temp_after_restperiod'])); //new
						$electrolyte_temp_after_hr =mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['electrolyte_temp_after_hr'])); //new
						$elect_temp_aftr_rest_hr=$electrolyte_temp_after_restperiod."|".$electrolyte_temp_after_hr;
					
					}else $temperature=$electrolyte_temp_before=$electrolyte_temp_after=$elect_temp_bfr_rest_hr=$elect_temp_aftr_rest_hr="";
					$dm_water_filling_type =mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['dm_water_filling_type'])); //new
					$log_book =mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['log_book'])); //new
					$acid_temp_discharge =mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['elec_temp_discharge']));
					$acid_temp_charge =mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['elec_temp_oncharge']));
					$cells_temp_after_use =mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['cells_after_use']));
					$cells_temp_at_charge =mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['cells_before_use']));
					$general_observation=(isset($update['motive_physical_observation']['motivegeneralobservation']) ? implode_fun($update['motive_physical_observation']['motivegeneralobservation'],'value') : '');
					$terminal_torque =mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['terminal_torque']));
					if(strtoupper(trim($terminal_torque))=="LOOSE"){
						$no_of_cell_loose =mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['torquenoofcellloose']));
						$no_of_cell_tightened =mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['torquenoofcellperfect']));
						$terminal_torque=$terminal_torque."|".$no_of_cell_loose."|".$no_of_cell_tightened;
					}
					//New column name
					//battery_top,battery_top_image,bb_condition,electrolyte_temp_before,electrolyte_temp_before_restperiod,electrolyte_temp_after,electrolyte_temp_after_restperiod,dm_water_filling_type,log_book,log_image
					$physical_damage_image = (isset($update['motive_physical_observation']['physical_image']) ? base64_to_file('physical_damage_pic',$update['motive_physical_observation']['physical_image'],'doc') : '0');
					$leakage_image = (isset($update['motive_physical_observation']['leakage_image']) ? base64_to_file('leakage_image',$update['motive_physical_observation']['leakage_image'],'doc') : '0'); //new
					$battery_top_image = (isset($update['motive_physical_observation']['battery_top_image']) ? base64_to_file('battery_top_image',$update['motive_physical_observation']['battery_top_image'],'doc') : '0'); //new
					$log_image = (isset($update['motive_physical_observation']['log_image']) ? base64_to_file('log_image',$update['motive_physical_observation']['log_image'],'doc') : '0'); //new
					$other_issue =mysqli_real_escape_string($mr_con,strtoupper($update['motive_physical_observation']['otherissue']['name']));// new
					$other_image = (isset($update['motive_physical_observation']['otherissue']['image']) ? base64_to_file('otherissue_image_mtpwr',$update['motive_physical_observation']['otherissue']['image'],'doc') : '0');
					other_issue_fun($ticket_alias,'MTPWR',$other_issue,$other_image);
					$physical_sql = mysqli_query($mr_con,"INSERT INTO ec_physical_observation(ticket_alias,physical_damages,leakage,temperature,acid_temp_discharge,acid_temp_charge,cells_temp_after_use,cells_temp_at_charge,general_observation,terminal_torque,item_alias,battery_top,bb_condition,electrolyte_temp_before,electrolyte_temp_before_restperiod,electrolyte_temp_after,electrolyte_temp_after_restperiod,dm_water_filling_type,log_book,log_image,battery_top_image,physical_damages_document,leakage_document)VALUES('$ticket_alias','$physical_damages','$leakage','$temperature','$acid_temp_discharge','$acid_temp_charge','$cells_temp_after_use','$cells_temp_at_charge','$general_observation','$terminal_torque','$physical_alias','$battery_top','$bb_condition','$electrolyte_temp_before','$elect_temp_bfr_rest_hr','$electrolyte_temp_after','$elect_temp_aftr_rest_hr','$dm_water_filling_type','$log_book','$log_image','$battery_top_image','$physical_damage_image','$leakage_image')");
					
					//charger_details
					$charger_alias = aliasCheck(generateRandomString(),'ec_charger_details','item_alias');
					$charger_band=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['charger_make']));
					
					//New column name
					//charger_capacity,charger_input,equalize_charger_mode,valueofequalize
					$charger_capacity=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['current_capacity'])); //new
					$charger_input=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['charger_input'])); //new
					$equalize_charger_mode=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['equalize_charger_mode'])); //new
					$valueofequalize=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['valueofequalize'])); //new
					$manf_date=dateFormat($update['charger_details']['charger_manu_date'],"y");
					$serial_no=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['chager_serial_number']));
					$charger_type=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['charger_type']));
					$voltage=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['charger_max_vol_limit']['value']));
					$voltage_image=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['charger_max_vol_limit']['image']));
					$charging_current=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['max_current_limit']));
					$high_voltage_cutoff=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['high_voltage_cutoff']));
					$voltage_ripple=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['voltage_ripple']));
					$voltage_regulation=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['volateg_regulation']));
					$charger_pic = (isset($update['charger_details']['charger_max_vol_limit']['image']) ? base64_to_file('voltage_image',$update['charger_details']['charger_max_vol_limit']['image'],'doc') : '0');
					$charger_sql = mysqli_query($mr_con,"INSERT INTO ec_charger_details(ticket_alias,charger_band,manf_date,serial_no,charger_type,voltage,charging_current,high_voltage_cutoff,voltage_ripple,voltage_regulation,charger_pic,charger_capacity,charger_input,equalize_charger_mode,valueofequalize,item_alias)VALUES('$ticket_alias','$charger_band','$manf_date','$serial_no','$charger_type','$voltage','$charging_current','$high_voltage_cutoff','$voltage_ripple','$voltage_regulation','$charger_pic','$charger_capacity','$charger_input','$equalize_charger_mode','$valueofequalize','$charger_alias')");	

					//forklift_details
					$forklift_alias = aliasCheck(generateRandomString(),'ec_fork_lift','item_alias');
					$fork_lift_brand=mysqli_real_escape_string($mr_con,strtoupper($update['forklift_details']['forlift_make']));
					$fork_lift_model=mysqli_real_escape_string($mr_con,strtoupper($update['forklift_details']['forlift_model']));
					$fork_lift_manf_date=dateFormat($update['forklift_details']['forklift_manu_date'],"y");
					$forklift_install_date=dateFormat($update['forklift_details']['forklift_install_date'],"y"); //new
					$forlift_capacity=mysqli_real_escape_string($mr_con,strtoupper($update['forklift_details']['forlift_capacity'])); //new
					$motor_capacity=mysqli_real_escape_string($mr_con,strtoupper($update['forklift_details']['motor_capacity'])); //new
					$under_voltage_cutoff=mysqli_real_escape_string($mr_con,strtoupper($update['forklift_details']['under_voltage_cutoff'])); //new
					$max_load_current=mysqli_real_escape_string($mr_con,strtoupper($update['forklift_details']['max_load_current'])); //new
					
					//forklift_install_date,forlift_capacity,motor_capacity,under_voltage_cutoff,max_load_current
					$forklift_sql = mysqli_query($mr_con,"INSERT INTO ec_fork_lift(ticket_alias,fork_lift_brand,fork_lift_model,fork_lift_manf_date,forklift_install_date,forlift_capacity,motor_capacity,under_voltage_cutoff,max_load_current,item_alias)VALUES('$ticket_alias','$fork_lift_brand','$fork_lift_model','$fork_lift_manf_date','$forklift_install_date','$forlift_capacity','$motor_capacity','$under_voltage_cutoff','$max_load_current','$forklift_alias')");
					
					//battery_details
					$battey_alias = aliasCheck(generateRandomString(),'ec_battery_details','item_alias');
					//$battey_type=mysqli_real_escape_string($mr_con,strtoupper($update['forklift_details']['battery_type'])); //waste /remove
					//$manf_date=dateFormat($update['forklift_details']['manufacturing_date'],"y"); //waste /remove
					//$ins_date=dateFormat($update['forklift_details']['forklift_install_date'],"y"); //waste /remove
					$bank_serial_no=mysqli_real_escape_string($mr_con,strtoupper($update['forklift_details']['battery_serial_no']));
					$plug_type=(isset($update['forklift_details']['plug_type']) ? implode_fun($update['forklift_details']['plug_type'],'name') :'');
					$acid_level=mysqli_real_escape_string($mr_con,strtoupper($update['forklift_details']['electrolyte_level']));
					$battey_sql = mysqli_query($mr_con,"INSERT INTO ec_battery_details(ticket_alias,bank_serial_no,plug_type,acid_level,item_alias)VALUES('$ticket_alias','$bank_serial_no','$plug_type','$acid_level','$battey_alias')");	
				
				}elseif($segment_alias=="W0PBT7IAZE" && $site_input=='FCBC'){ //Power control
					//POWER Control-FSR FCBC
					$fcbc_alias = aliasCheck(generateRandomString(),'ec_technical_observation','item_alias');
					$float_voltage=mysqli_real_escape_string($mr_con,strtoupper($update['fcbc_observation']['float_voltage']['value']));
					$boast_voltage=mysqli_real_escape_string($mr_con,strtoupper($update['fcbc_observation']['Boost_voltage']['value']));
					$current_limit=mysqli_real_escape_string($mr_con,strtoupper($update['fcbc_observation']['current_limit']));
					$voltage_ripple=mysqli_real_escape_string($mr_con,strtoupper($update['fcbc_observation']['voltage_ripple']));
					$voltage_regulation=mysqli_real_escape_string($mr_con,strtoupper($update['fcbc_observation']['voltage_regulation']));
					$high_voltage_cutoff=mysqli_real_escape_string($mr_con,strtoupper($update['fcbc_observation']['high_voltage_cutoff']));
					$low_voltage_cutoff=mysqli_real_escape_string($mr_con,strtoupper($update['fcbc_observation']['low_voltage_cutoff']));
					$panel_make=mysqli_real_escape_string($mr_con,strtoupper($update['fcbc_observation']['fcbc_make']));
					$panel_rating=mysqli_real_escape_string($mr_con,strtoupper($update['fcbc_observation']['fcbc_rating']));
					$panel_manufacturing_date=dateFormat($update['fcbc_observation']['man_date'],"y");
					$panel_installation_date=dateFormat($update['fcbc_observation']['install_date'],"y");
					$auto_boost=mysqli_real_escape_string($mr_con,strtoupper($update['fcbc_observation']['auto_boost'])); //new
					$temp_compensation=(isset($update['fcbc_observation']['temp_compensation']) ? implode_fun($update['fcbc_observation']['temp_compensation'],'name') : ''); //new
					$document_1 = (isset($update['fcbc_observation']['float_voltage']['image']) ? base64_to_file('float_voltage_image_fcbc_pc',$update['fcbc_observation']['float_voltage']['image'],'doc') : '0');
					$document_2 = (isset($update['fcbc_observation']['Boost_voltage']['image']) ? base64_to_file('boast_voltage_image_fcbc_pc',$update['fcbc_observation']['Boost_voltage']['image'],'doc') : '0');
					// auto_boost,temp_compensation
					$fcbc_sql = mysqli_query($mr_con,"INSERT INTO ec_technical_observation(ticket_alias,float_voltage,boast_voltage,current_limit,voltage_ripple,voltage_regulation,high_voltage_cutoff,low_voltage_cutoff,panel_make,panel_rating,panel_manufacturing_date,panel_installation_date,auto_boost,temp_compensation,site_input,item_alias,document_1,document_2)VALUES('$ticket_alias','$float_voltage','$boast_voltage','$current_limit','$voltage_ripple','$voltage_regulation','$high_voltage_cutoff','$low_voltage_cutoff','$panel_make','$panel_rating','$panel_manufacturing_date','$panel_installation_date','$auto_boost','$temp_compensation','3','$fcbc_alias','$document_1','$document_2')");
				}
				if($segment_alias=="SMEY7SL24I" || ($segment_alias=="W0PBT7IAZE" && $site_input=='UPS') || ($segment_alias=="KWJCZKSTBL" && ($phy_dg_status=="DG Site" || $phy_eb_status=="EB Site"))){ //UPS || Solar
					//UPS-FSR
					$ups_alias = aliasCheck(generateRandomString(),'ec_technical_observation','item_alias');
					$float_voltage=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observation']['float_voltage']['value']));
					$boast_voltage=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observation']['Boost_voltage']['value']));
					$current_limit=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observation']['current_limit']));
					$voltage_ripple=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observation']['voltage_ripple']));
					$voltage_regulation=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observation']['voltage_regulation']));
					$high_voltage_cutoff=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observation']['high_voltage_cutoff']));
					$low_voltage_cutoff=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observation']['low_voltage_cutoff']));
					$panel_make=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observation']['ups_make']));
					$panel_rating=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observation']['ups_rating']));
					$panel_manufacturing_date=dateFormat($update['ups_observation']['ups_man_date'],"y");
					$panel_installation_date=dateFormat($update['ups_observation']['ups_install_date'],"y");
					$auto_boost=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observation']['auto_boost'])); //new
					$temp_compensation=(isset($update['ups_observation']['temp_compensation']) ? implode_fun($update['ups_observation']['temp_compensation'],'name') : ''); //new
					$document_1 = (isset($update['ups_observation']['float_voltage']['image']) ? base64_to_file('float_voltage_image_ups_pc',$update['ups_observation']['float_voltage']['image'],'doc') : '0');
					$document_2 = (isset($update['ups_observation']['Boost_voltage']['image']) ? base64_to_file('boast_voltage_image_ups_pc',$update['ups_observation']['Boost_voltage']['image'],'doc') : '0');
					// auto_boost,temp_compensation
					$ups_sql = mysqli_query($mr_con,"INSERT INTO ec_technical_observation(ticket_alias,float_voltage,boast_voltage,current_limit,voltage_ripple,voltage_regulation,high_voltage_cutoff,low_voltage_cutoff,panel_make,panel_rating,panel_manufacturing_date,panel_installation_date,auto_boost,temp_compensation,site_input,item_alias,document_1,document_2)VALUES('$ticket_alias','$float_voltage','$boast_voltage','$current_limit','$voltage_ripple','$voltage_regulation','$high_voltage_cutoff','$low_voltage_cutoff','$panel_make','$panel_rating','$panel_manufacturing_date','$panel_installation_date','$auto_boost','$temp_compensation','5','$ups_alias','$document_1','$document_2')");	
				}
				if($segment_alias=="KWJCZKSTBL" || $segment_alias=="DDEYO7NTTC"){ // Solar || Telecom Solar
					//Solar
					$solar_telecom_alias = aliasCheck(generateRandomString(),'ec_technical_observation','item_alias');
					$float_voltage=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['float_voltage']['value']));
					$boast_voltage=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['Boost_voltage']['value']));
					$current_limit=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['current_limit']));
					$voltage_ripple=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['voltage_ripple']));
					$voltage_regulation=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['voltage_regulation']));
					$high_voltage_cutoff=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['high_voltage_cutoff']));
					$low_voltage_cutoff=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['low_voltage_cutoff']));
					$panel_make=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['panel_make']));
					$panel_rating=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['panel_rating']));
					$charge_controller_rate=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['charger_control_rating']));
					$charge_controller_make=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['charger_control_make']));
					$no_solar_panels=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['no_of_solar_panel']['value']));
					$single_panel_rating=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['single_panel_rating']));
					
					$solar_system_rating=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['solar_system_rating'])); //new
					$single_module_rating=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['single_module_rating'])); //new
					$single_pv_moddule_rating_current=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['single_pv_moddule_rating_current'])); //new
					$pv_module_eff=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['pv_module_eff'])); //new
					if($phy_dg_status=="DG Site" || $phy_eb_status=="EB Site"){
						$invertor_make=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['invertor_make'])); //new
						$invertor_capacity=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['invertor_capacity'])); //new
						$invertor_manu_date=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['invertor_manu_date'])); //new
						$invertor_install_date=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['invertor_install_date'])); //new
						$invertor_type=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['invertor_type'])); //new
						$invertor_load_current=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['invertor_load_current'])); //new
						$low_voltage_cutoff_inv=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_observation']['low_voltage_cutoff_inv'])); //new
					}else{$invertor_make=$invertor_capacity=$invertor_manu_date=$invertor_install_date=$invertor_type=$invertor_load_current=$low_voltage_cutoff_inv='';}
					//solar_system_rating,single_module_rating,single_pv_moddule_rating_current,pv_module_eff,invertor_make,invertor_capacity,invertor_manu_date,invertor_install_date,invertor_type,invertor_load_current,low_voltage_cutoff_inv
					//'$solar_system_rating','$single_module_rating','$single_pv_moddule_rating_current','$pv_module_eff','$invertor_make','$invertor_capacity','$invertor_manu_date','$invertor_install_date','$invertor_type','$invertor_load_current','$low_voltage_cutoff_inv'
					$solar_telecom_sql = mysqli_query($mr_con,"INSERT INTO ec_invertor_details(ticket_alias,invertor_make,invertor_capacity,invertor_manu_date,invertor_install_date,invertor_type,invertor_load_current,low_voltage_cutoff_inv)VALUES('$ticket_alias','$invertor_make','$invertor_capacity','$invertor_manu_date','$invertor_install_date','$invertor_type','$invertor_load_current','$low_voltage_cutoff_inv')");
					$panel_manufacturing_date=dateFormat($update['solar_panel_observation']['panel_manufacturing_date'],"y"); //old 
					$charge_control_manufacturing_date=dateFormat($update['solar_panel_observation']['charge_controller_manufacturing_date'],"y"); //old 
					$panel_installation_date=dateFormat($update['solar_panel_observation']['panel_installation_date'],"y"); //old 
					
					$document_1 = (isset($update['solar_panel_observation']['float_voltage']['image']) ? base64_to_file('float_voltage_image_sa_ts',$update['solar_panel_observation']['float_voltage']['image'],'doc') : '0');
					$document_2 = (isset($update['solar_panel_observation']['Boost_voltage']['image']) ? base64_to_file('boost_voltage_image_sa_ts',$update['solar_panel_observation']['Boost_voltage']['image'],'doc') : '0');
					$document_3 = (isset($update['solar_panel_observation']['no_of_solar_panel']['image']) ? base64_to_file('number_of_solar_panels_image_sa_ts',$update['solar_panel_observation']['no_of_solar_panel']['image'],'doc') : '0');
					
					$solar_telecom_sql = mysqli_query($mr_con,"INSERT INTO ec_technical_observation(ticket_alias,float_voltage,boast_voltage,current_limit,voltage_ripple,voltage_regulation,high_voltage_cutoff,low_voltage_cutoff,panel_make,panel_rating,charge_controller_rate,charge_controller_make,no_solar_panels,single_panel_rating,panel_manufacturing_date,charge_control_manufacturing_date,panel_installation_date,solar_system_rating,single_module_rating,single_pv_moddule_rating_current,pv_module_eff,site_input,item_alias,document_1,document_2,document_3)VALUES('$ticket_alias','$float_voltage','$boast_voltage','$current_limit','$voltage_ripple','$voltage_regulation','$high_voltage_cutoff','$low_voltage_cutoff','$panel_make','$panel_rating','$charge_controller_rate','$charge_controller_make','$no_solar_panels','$single_panel_rating','$panel_manufacturing_date','$charge_control_manufacturing_date','$panel_installation_date','$solar_system_rating','$single_module_rating','$single_pv_moddule_rating_current','$pv_module_eff','".($segment_alias=="KWJCZKSTBL" ? '2' : '4')."','$solar_telecom_alias','$document_1','$document_2','$document_3')");
				}
				if($segment_alias=="HXL5A1HOTZ" || ($segment_alias=="W0PBT7IAZE" && $site_input=='SMPS') || ($segment_alias=="DDEYO7NTTC" && ($phy_dg_status=="DG Site" || $phy_eb_status=="EB Site"))){ // Telecom || Telecom Solar
					//smps_observations
					$smps_alias = aliasCheck(generateRandomString(),'ec_technical_observation','item_alias');
					$float_voltage =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observation']['float_voltage']['value']));
					$boast_voltage =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observation']['Boost_voltage']['value']));
					$current_limit =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observation']['current_limit']));
					$voltage_ripple =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observation']['voltage_ripple']));
					$voltage_regulation=mysqli_real_escape_string($mr_con,strtoupper($update['smps_observation']['lvd_status']));
					$high_voltage_cutoff =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observation']['high_voltage_cutoff']));
					$low_voltage_cutoff =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observation']['low_voltage_cutoff']));
					$panel_make =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observation']['smps_make']));
					$panel_rating =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observation']['smps_rating']));
					$no_of_solar_panels =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observation']['no_of_working_mod']));
					
					//$single_panel_rating =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observation']['smps_display']));
					$single_panel_rating =(isset($update['smps_observation']['smps_display']) ? implode_fun($update['smps_observation']['smps_display'],'name') :'');
					
					$panel_manf_date =dateFormat($update['smps_observation']['man_date'],"y"); //SMPS Manufacturing Date
					
					$charge_controller_make =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observation']['smr_module_rating_radio']));// 
					$charge_controller_rate =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observation']['smr_module_rating_value']));// 
					$site_load =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observation']['site_load']));// new
					$temp_compensation =(isset($update['smps_observation']['temp_compensation']) ? implode_fun($update['smps_observation']['temp_compensation'],'name') : '');// new
					$auto_boost =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observation']['auto_boost'])); //new
					$other_issue =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observation']['otherissue']['name']));// new
					
					//$charger_controller_manf_date=dateFormat($update['smps_observation']['charger_controller_manf_date'],"y");
					//$panel_install_date=dateFormat($update['smps_observation']['panel_install_date'],"y");
					//if(isset($update['smps_observation']['charge_controller_make'])){$charge_controller_make = base64_to_file('charge_controller_make',$update['smps_observation']['charge_controller_make'],'doc');}else{$charge_controller_make='0';}
					
					$document_1 = (isset($update['smps_observation']['float_voltage']['image']) ? base64_to_file('float_voltage_image_tl',$update['smps_observation']['float_voltage']['image'],'doc') : '0');
					$document_2 = (isset($update['smps_observation']['Boost_voltage']['image']) ? base64_to_file('boost_voltage_image_tl',$update['smps_observation']['Boost_voltage']['image'],'doc') : '0');
					//$document_3 = (isset($update['smps_observation']['boost_voltage']['image']) ? base64_to_file('boast_voltage_image_tl',$update['smps_observation']['boost_voltage']['image'],'doc') : '0');
					//$document_4 = (isset($update['smps_observation']['boost_voltage']['image']) ? base64_to_file('boast_voltage_image_tl',$update['smps_observation']['boost_voltage']['image'],'doc') : '0');
					//$document_5 = (isset($update['smps_observation']['boost_voltage']['image']) ? base64_to_file('boast_voltage_image_tl',$update['smps_observation']['boost_voltage']['image'],'doc') : '0');
					$other_image = (isset($update['smps_observation']['otherissue']['image']) ? base64_to_file('otherissue_image_tl',$update['smps_observation']['otherissue']['image'],'doc') : '0');
					other_issue_fun($ticket_alias,"TLOBS",$other_issue,$other_image);
					$smps_sql = mysqli_query($mr_con,"INSERT INTO ec_technical_observation(ticket_alias,float_voltage,boast_voltage,current_limit,voltage_ripple,voltage_regulation,high_voltage_cutoff,low_voltage_cutoff,panel_make,panel_rating,charge_controller_rate,charge_controller_make,no_solar_panels,single_panel_rating,panel_manufacturing_date,charge_control_manufacturing_date,panel_installation_date,auto_boost,temp_compensation,site_load,site_input,item_alias,document_1,document_2,document_3,document_4,document_5)VALUES('$ticket_alias','$float_voltage','$boast_voltage','$current_limit','$voltage_ripple','$voltage_regulation','$high_voltage_cutoff','$low_voltage_cutoff','$panel_make','$panel_rating','$charge_controller_rate','$charge_controller_make','$no_of_solar_panels','$single_panel_rating','$panel_manf_date','$charger_controller_manf_date','$panel_install_date','$auto_boost','$temp_compensation','$site_load','1','$smps_alias','$document_1','$document_2','$document_3','$document_4','$document_5')");
				 }
			}
			$required_acc=$required_cl=$acc_desc=$battery_rating=$faulty_cell_arr=$job_performed=$replaced_cell_arr=array();
			//Service Engineer Observation
			$action_taken =mysqli_real_escape_string($mr_con,strtoupper(trim($update['service_eng_observation']['action_taken_suggestion'])));
			$observation =mysqli_real_escape_string($mr_con,strtoupper(trim($update['service_eng_observation']['observation'])));
			$site_address =mysqli_real_escape_string($mr_con,strtoupper(trim($update['service_eng_observation']['site_address'])));
			//$faulty_code_alias =mysqli_real_escape_string($mr_con,strtoupper(alias(trim($update['service_eng_observation']['fault_code']),'ec_faulty_code','description','faulty_alias')));
			$faulty_code_alias =mysqli_real_escape_string($mr_con,strtoupper(trim($update['service_eng_observation']['fault_code'])));
														  
			$remark_alias = aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
			$remark_sql = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$observation','TT','8','$ticket_alias','$service_engineer_alias','$remark_alias')");
			$action_alias = aliasCheck(generateRandomString(),'ec_ticket_action','item_alias');
			$action_sql = mysqli_query($mr_con,"INSERT INTO ec_ticket_action(ticket_alias,observation,item_alias)VALUES('$ticket_alias','$action_taken','$action_alias')");
			$required_accessories_arr=(is_array($update['service_eng_observation']['required_accessories']) ? array_values(array_filter($update['service_eng_observation']['required_accessories'])) : array());
			for($i=0;$i<count($required_accessories_arr);$i++){
				$required_accessories =mysqli_real_escape_string($mr_con,strtoupper(trim($required_accessories_arr[$i]['name'])));
				$required_accessories_qty =mysqli_real_escape_string($mr_con,str_replace("null","",$required_accessories_arr[$i]['qty']));
				$required_acc[$required_accessories]=$required_accessories_qty;
			}
			$required_cell_arr=(is_array($update['service_eng_observation']['required_cell']) ? array_values(array_filter($update['service_eng_observation']['required_cell'])) : array());
			for($i=0;$i<count($required_cell_arr);$i++){
				$required_cell =mysqli_real_escape_string($mr_con,strtoupper(trim($required_cell_arr[$i]['name'])));
				$required_cell_qty =mysqli_real_escape_string($mr_con,str_replace("null","",$required_cell_arr[$i]['qty']));
				$required_cl[$required_cell]=$required_cell_qty;
			}
			$job=array_filter($update['service_eng_observation']['job_performed']);
			for($i=0;$i<count($job);$i++){
				if(!empty(trim($job[$i]['name'])))$job_performed[] =mysqli_real_escape_string($mr_con,strtoupper(trim($job[$i]['name'])));
			}
			for($i=0;$i<count($update['service_eng_observation']['otherissue']);$i++){
				$other_issue =mysqli_real_escape_string($mr_con,strtoupper(trim($update['service_eng_observation']['otherissue'][$i]['name'])));
				$other_image = (isset($update['service_eng_observation']['otherissue'][$i]['image']) ? base64_to_file('otherissue_image_seo_'.$i,$update['service_eng_observation']['otherissue'][$i]['image'],'doc') : '0');
				other_issue_fun($ticket_alias,'SEOBS',$other_issue,$other_image);
			}
			//customer_comments
			$customer_comments_alias = aliasCheck(generateRandomString(),'ec_customer_comments','item_alias');
			$customer_comments =mysqli_real_escape_string($mr_con,strtoupper(trim($update['customer_comments']['customer_comments'])));
			$customer_comments_sql = mysqli_query($mr_con,"INSERT INTO ec_customer_comments(ticket_alias,customer_comments,item_alias)VALUES('$ticket_alias','$customer_comments','$customer_comments_alias')");
			 //$result['fdfdf']['err_msg']="INSERT INTO ec_customer_comments(ticket_alias,customer_comments,item_alias)VALUES('$ticket_alias','$customer_comments','$customer_comments_alias')";
			//esignature
			$e_signature_alias = aliasCheck(generateRandomString(),'ec_e_signature','item_alias');
			$name =mysqli_real_escape_string($mr_con,strtoupper(trim($update['customer_comments']['name'])));
			$email =mysqli_real_escape_string($mr_con,strtoupper(trim($update['customer_comments']['email'])));
			$designation =mysqli_real_escape_string($mr_con,strtoupper(trim($update['customer_comments']['desination'])));
			$contact_number =mysqli_real_escape_string($mr_con,strtoupper(trim($update['customer_comments']['contactnumber'])));
			$user_photo = (isset($update['customer_comments']['customer_image']) ? base64_to_file('customer_photo',$update['customer_comments']['customer_image'],'photo') : '0');
			
			if(isset($update['customer_comments']['Cus_Status']))$signature_image = $update['customer_comments']['Cus_Status'];
			else $signature_image = (isset($update['customer_comments']['customer_signature']) ? base64_to_file('customer_signature',$update['customer_comments']['customer_signature'],'sign') : '0');
			
			$engineer_photo = (isset($update['service_eng_observation']['eng_image']) ? base64_to_file('engineer_photo',$update['service_eng_observation']['eng_image'],'photo') : '0');
			$engineer_sign = (isset($update['service_eng_observation']['signature']) ? base64_to_file('engineer_signature',$update['service_eng_observation']['signature'],'sign') : '0');
			$e_signature_sql = mysqli_query($mr_con,"INSERT INTO ec_e_signature(ticket_alias,name,email,designation,contact_number,photo,e_signature,item_alias,engineer_photo,engineer_sign)VALUES('$ticket_alias','$name','$email','$designation','$contact_number','$user_photo','$signature_image','$e_signature_alias','$engineer_photo','$engineer_sign')");
			//customer details update in sitemaster
			$cu = "";
			//$cu .= (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) ? "manager_mail='$email'," : "");
			//$cu .= (!empty($contact_number) ? "manager_number='$contact_number',":"");
			$cu .= (!empty($site_address) ? "site_address='$site_address'":"");
			if(!empty($cu))$e_customer_sql = mysqli_query($mr_con,"UPDATE ec_sitemaster SET $cu WHERE site_alias='$site_alias'");
			
			//Customer_satisfaction
			$customer_satisfaction_alias = aliasCheck(generateRandomString(),'ec_customer_satisfaction','item_alias');
			$rating1 =mysqli_real_escape_string($mr_con,strtoupper(trim($update['customer_comments']['satis_response'])));
			$rating2 =mysqli_real_escape_string($mr_con,strtoupper(trim($update['customer_comments']['satis_technical'])));
			$rating3 =mysqli_real_escape_string($mr_con,strtoupper(trim($update['customer_comments']['satis_professional'])));
			$rating4 =mysqli_real_escape_string($mr_con,strtoupper(trim($update['customer_comments']['satis_service'])));
			$rating5 =mysqli_real_escape_string($mr_con,strtoupper(trim($update['customer_comments']['satis_overall'])));
			$customer_satisfaction_sql = mysqli_query($mr_con,"INSERT INTO ec_customer_satisfaction(ticket_alias,q1,q2,q3,q4,q5,item_alias)VALUES('$ticket_alias','$rating1','$rating2','$rating3','$rating4','$rating5','$customer_satisfaction_alias')");
			
			//Battery Observation
			$battery_bank_bb_alias_arr=array();
			$motiv_seg=($segment_alias=="YGRKJJD4N7" ? TRUE : FALSE);
			$noofbank =mysqli_real_escape_string($mr_con,strtoupper(trim($update['battery_observation_report']['noofbank'])));
			if(isset($update['battery_observation_report']['noofbankinfo']))
			foreach($update['battery_observation_report']['noofbankinfo'] as $i=>$start_arr){
				$bbcondition =mysqli_real_escape_string($mr_con,strtoupper(trim($start_arr['bbcondition']))); //new
				$bbratingvalue =mysqli_real_escape_string($mr_con,strtoupper(trim($start_arr['bbratingvalue'])));
				$numberofcell =mysqli_real_escape_string($mr_con,strtoupper(trim($start_arr['numberofcell'])));
				$battery_bank_bb_alias_arr[]=$battery_bank_bb_alias = aliasCheck(generateRandomString(),'ec_battery_bank_bb_cap','item_alias');
				$bb_capacity =mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation_report'][$i]['bb_capacity']));
				$battery_bank_bb_sql=mysqli_query($mr_con,"INSERT INTO ec_battery_bank_bb_cap(ticket_alias,battery_bank_rating,bb_capacity,bb_condition,item_alias)VALUES('$ticket_alias','$bbratingvalue','$numberofcell','$bbcondition','$battery_bank_bb_alias')");
			}
			if(isset($update['battery_observation_report']['battery_observation_report']))
			foreach($update['battery_observation_report']['battery_observation_report'] as $j=>$bulk_arr){
				$cellserialnumber_arr=$manf_date_arr=$remarks_arr=$voltage_1=$voltage_dis=$voltage_2=$voltage_ocv=$sgrav_1=$sgrav_dis=$sgrav_2=$sgrav_ocv=array();
				if(isset($bulk_arr['cell_serial_number']))
				foreach($bulk_arr['cell_serial_number'] as $k=>$start_arr){
					$cellserialnumber_arr[$k]=$cellserialnumber=mysqli_real_escape_string($mr_con,strtoupper(trim($start_arr['cellserialnumber'])));
					$falulty_cell=$start_arr['falulty_cell'];
					$manf_date_arr[$k]=$manf_date=(strlen($start_arr['manf_date'])=='4' ? '0'.$start_arr['manf_date'] : $start_arr['manf_date']);
					$remarks_arr[$k]=mysqli_real_escape_string($mr_con,strtoupper(trim($start_arr['remarks'])));
					$replaced_value=mysqli_real_escape_string($mr_con,strtoupper(trim($start_arr['replaced_value'])));
					if(!empty($replaced_value))$replaced_cell_arr[]=strtoupper($replaced_value);
					if($falulty_cell=='true'){$faulty_cell_arr[]=$cellserialnumber;
						$fal_alias = aliasCheck(generateRandomString(),'ec_fsr_faulty_cells','item_alias');
						$fal_sql = mysqli_query($mr_con,"INSERT INTO ec_fsr_faulty_cells(ticket_alias,cell_sl_no,mf_date,faulty_code_alias,item_alias,fsr_type)VALUES('$ticket_alias','$cellserialnumber','$manf_date','$faulty_code_alias','$fal_alias','1')");
					}
				}
				//on_charge_voltage_1
				if(isset($bulk_arr['onchargevoltageone']['timerinput']))
				foreach($bulk_arr['onchargevoltageone']['timerinput'] as $k=>$start_arr){ $total_voltage=0;
					$headers=$start_arr['timervalue'];
					$temperature=($motiv_seg ? $start_arr['elec_temp_min']."|".$start_arr['elec_temp_max'] : $start_arr['room_temp']);
					$charging_current=$start_arr['current'];
					$smps_charge_voltage=$start_arr['smps_charge_voltage']; //new
					$bb_terminal_voltage=$start_arr['bb_terminal_voltage']; //new
					if(isset($start_arr['timerreport']))
					foreach($start_arr['timerreport'] as $l=>$end_arr){
						$voltage_1[$l][$k]=$end_arr['voltagereading'];
						if($motiv_seg)$sgrav_1[$l][$k]=$end_arr['specificgravity'];
						$total_voltage+=$end_arr['voltagereading'];
					}
					$bo_header_sql=mysqli_query($mr_con,"INSERT INTO ec_bo_headers(header,total_voltage,temperature,charging_current,smps_charge_voltage,bb_terminal_voltage,item_alias,type)VALUES('$headers','$total_voltage','$temperature','$charging_current','$smps_charge_voltage','$bb_terminal_voltage','$battery_bank_bb_alias_arr[$j]','on_charge_voltage_1')");
				}
				//discharge_voltage
				if(isset($bulk_arr['discharge_voltage']['timerinput']))
				foreach($bulk_arr['discharge_voltage']['timerinput'] as $k=>$start_arr){ $total_voltage=0;
					$headers=$start_arr['timervalue'];
					$temperature=($motiv_seg ? $start_arr['elec_temp_min']."|".$start_arr['elec_temp_max'] : $start_arr['room_temp']);
					$charging_current=$start_arr['current'];
					$smps_charge_voltage=''; //new
					$bb_terminal_voltage=$start_arr['bb_terminal_voltage']; //new
					if(isset($start_arr['timerreport']))
					foreach($start_arr['timerreport'] as $l=>$end_arr){
						$voltage_dis[$l][$k]=$end_arr['voltagereading'];
						if($motiv_seg)$sgrav_dis[$l][$k]=$end_arr['specificgravity'];
						$total_voltage+=$end_arr['voltagereading'];
					}
					$bo_header_sql=mysqli_query($mr_con,"INSERT INTO ec_bo_headers(header,total_voltage,temperature,charging_current,smps_charge_voltage,bb_terminal_voltage,item_alias,type)VALUES('$headers','$total_voltage','$temperature','$charging_current','$smps_charge_voltage','$bb_terminal_voltage','$battery_bank_bb_alias_arr[$j]','discharge_voltage')");
				}
				//on_charge_voltage_2
				if(isset($bulk_arr['onchargevoltagetwo']['timerinput']))
				foreach($bulk_arr['onchargevoltagetwo']['timerinput'] as $k=>$start_arr){ $total_voltage=0;
					$headers=$start_arr['timervalue'];
					$temperature=($motiv_seg ? $start_arr['elec_temp_min']."|".$start_arr['elec_temp_max'] : $start_arr['room_temp']);
					$charging_current=$start_arr['current'];
					$smps_charge_voltage=$start_arr['smps_charge_voltage']; //new
					$bb_terminal_voltage=$start_arr['bb_terminal_voltage']; //new
					if(isset($start_arr['timerreport']))
					foreach($start_arr['timerreport'] as $l=>$end_arr){
						$voltage_2[$l][$k]=$end_arr['voltagereading'];
						if($motiv_seg)$sgrav_2[$l][$k]=$end_arr['specificgravity'];
						$total_voltage+=$end_arr['voltagereading'];
					}
					$bo_header_sql=mysqli_query($mr_con,"INSERT INTO ec_bo_headers(header,total_voltage,temperature,charging_current,smps_charge_voltage,bb_terminal_voltage,item_alias,type)VALUES('$headers','$total_voltage','$temperature','$charging_current','$smps_charge_voltage','$bb_terminal_voltage','$battery_bank_bb_alias_arr[$j]','on_charge_voltage_2')");
				}
				// ocv
				$headers='ocv';$total_voltage=0;$smps_charge_voltage='';
				$charging_current=$bulk_arr['open_circuit_voltage']['current'];
				$bb_terminal_voltage=$bulk_arr['open_circuit_voltage']['bb_terminal_voltage'];
				$temperature=($motiv_seg ? $bulk_arr['open_circuit_voltage']['elec_temp_min']."|".$bulk_arr['open_circuit_voltage']['elec_temp_max'] : $bulk_arr['open_circuit_voltage']['room_temp']);
				if(isset($bulk_arr['open_circuit_voltage']['ocv_value']))
				foreach($bulk_arr['open_circuit_voltage']['ocv_value'] as $k=>$start_arr){
					$voltage_ocv[$k]=$start_arr['voltagereading'];
					if($motiv_seg)$sgrav_ocv[$k]=$start_arr['specificgravity'];
					$total_voltage+=$start_arr['voltagereading'];
				}
				$bo_header_sql=mysqli_query($mr_con,"INSERT INTO ec_bo_headers(header,total_voltage,temperature,charging_current,smps_charge_voltage,bb_terminal_voltage,item_alias,type)VALUES('$headers','$total_voltage','$temperature','$charging_current','$smps_charge_voltage','$bb_terminal_voltage','$battery_bank_bb_alias_arr[$j]','ocv')");
				for($k=0;$k<count($cellserialnumber_arr);$k++){ // Cellserial number
					$battery_alias = aliasCheck(generateRandomString(),'ec_bo_telecom_ic','item_alias');
					$cell_sl_no =mysqli_real_escape_string($mr_con,strtoupper(trim($cellserialnumber_arr[$k])));
					$mf_date =mysqli_real_escape_string($mr_con,strtoupper(trim($manf_date_arr[$k])));
					$remarks =mysqli_real_escape_string($mr_con,strtoupper(trim($remarks_arr[$k])));
					$ocv=mysqli_real_escape_string($mr_con,strtoupper($voltage_ocv[$k]));
					if($motiv_seg)$sg_ocv=mysqli_real_escape_string($mr_con,strtoupper($sgrav_ocv[$k]));
					$hr_1=$hr_dis=$hr_2=$sghr_1=$sghr_dis=$sghr_2=array();
					for($l=0;$l<15;$l++){ // no of headers
						$hr1=mysqli_real_escape_string($mr_con,$voltage_1[$k][$l]);
						$hrdis=mysqli_real_escape_string($mr_con,$voltage_dis[$k][$l]);
						$hr2=mysqli_real_escape_string($mr_con,$voltage_2[$k][$l]);
						$hr_1[]=(!empty($hr1) ? $hr1 : "");
						$hr_dis[]=(!empty($hrdis) ? $hrdis : "");
						$hr_2[]=(!empty($hr2) ? $hr2 : "");
						if($motiv_seg){
							$sghr1=mysqli_real_escape_string($mr_con,$sgrav_1[$k][$l]);
							$sghrdis=mysqli_real_escape_string($mr_con,$sgrav_dis[$k][$l]);
							$sghr2=mysqli_real_escape_string($mr_con,$sgrav_2[$k][$l]);
							$sghr_1[]=(!empty($sghr1) ? $sghr1 : "");
							$sghr_dis[]=(!empty($sghrdis) ? $sghrdis : "");
							$sghr_2[]=(!empty($sghr2) ? $sghr2 : "");
						}
					}
					$battery_sql = mysqli_query($mr_con,"INSERT INTO ec_bo_telecom_ic(cell_sl_no,mf_date,ocv,1hr,2hr,3hr,4hr,5hr,6hr,7hr,8hr,9hr,10hr,10a_hr,10b_hr,10c_hr,10d_hr,10e_hr,11hr,12hr,13hr,14hr,15hr,16hr,17hr,18hr,19hr,20hr,20a_hr,20b_hr,20c_hr,20d_hr,20e_hr,21hr,22hr,23hr,24hr,25hr,26hr,27hr,28hr,29hr,30hr,30a_hr,30b_hr,30c_hr,30d_hr,30e_hr,battery_bb_alias,item_alias,remarks)VALUES('$cell_sl_no','$mf_date','$ocv','".implode("','",$hr_1)."', '".implode("','",$hr_dis)."', '".implode("','",$hr_2)."', '$battery_bank_bb_alias_arr[$j]','$battery_alias','$remarks')");
					if($motiv_seg)$motive_sql = mysqli_query($mr_con,"INSERT INTO ec_bo_motive_ic(bo_telecome_alias,battery_bb_alias,sg_ocv,sg_1hr,sg_2hr,sg_3hr,sg_4hr,sg_5hr,sg_6hr,sg_7hr,sg_8hr,sg_9hr,sg_10hr,sg_10a_hr,sg_10b_hr,sg_10c_hr,sg_10d_hr,sg_10e_hr,sg_11hr,sg_12hr,sg_13hr,sg_14hr,sg_15hr,sg_16hr,sg_17hr,sg_18hr,sg_19hr,sg_20hr,sg_20a_hr,sg_20b_hr,sg_20c_hr,sg_20d_hr,sg_20e_hr,sg_21hr,sg_22hr,sg_23hr,sg_24hr,sg_25hr,sg_26hr,sg_27hr,sg_28hr,sg_29hr,sg_30hr,sg_30a_hr,sg_30b_hr,sg_30c_hr,sg_30d_hr,sg_30e_hr)VALUES('$battery_alias','$battery_bank_bb_alias_arr[$j]','$sg_ocv','".implode("','",$sghr_1)."', '".implode("','",$sghr_dis)."', '".implode("','",$sghr_2)."')");
				}
			}
			foreach($required_cl as $prod_desc=>$quant){
				if(!empty($prod_desc)){
					$cell_alias=alias(trim($prod_desc),'ec_product','product_description','product_alias');
					$battery_rating[]=alias($cell_alias,'ec_product','product_alias','battery_rating')."(".$quant.")";
					$alias=aliasCheck(generateRandomString(),'ec_cell_required','item_alias');
					$sqlReq = mysqli_query($mr_con,"INSERT INTO ec_cell_required(ticket_alias,item_type,cell_alias,quanty,item_alias)VALUES('$ticket_alias','1','$cell_alias','$quant','$alias')");
				}
			}
			foreach($required_acc as $ac_desc=>$quant){
				if(!empty($ac_desc)){
					$acc_alias=alias(trim($ac_desc),'ec_accessories','accessory_description','accessories_alias');
					$acc_desc[]=$ac_desc."(".$quant.")";
					$alias=aliasCheck(generateRandomString(),'ec_cell_required','item_alias');
					$sqlReq = mysqli_query($mr_con,"INSERT INTO ec_cell_required(ticket_alias,item_type,cell_alias,quanty,item_alias)VALUES('$ticket_alias','2','$acc_alias','$quant','$alias')");
				}
			}
			$engineer_alias = aliasCheck(generateRandomString(),'ec_engineer_observation','item_alias');
			$engineer_sql = mysqli_query($mr_con,"INSERT INTO ec_engineer_observation(ticket_alias,faulty_cell_sr_no,faulty_code_alias,req_acc,req_cells,total_faulty_count,job_performed,replaced_cell_no,item_alias)VALUES('$ticket_alias','".strtoupper(implode(", ",$faulty_cell_arr))."','$faulty_code_alias','".implode(", ",$acc_desc)."','".implode(", ",$battery_rating)."','".count($faulty_cell_arr)."','".implode(", ",$job_performed)."','".implode(", ",$replaced_cell_arr)."','$engineer_alias')");
			//tickets update
			$dat = date("Y-m-d H:i:s");
			$efsr_no = efsrNoCheck(efsrRandomNo());
			$efsr_date =(!empty($efsr_date) ? $efsr_date : $dat);
			$efsr_start=(!empty($efsr_start) ? $efsr_start : $dat);
			if($tt_type=='1' || $tt_type=='2'){ //Spot TT, Off line TT
				$update = mysqli_query($mr_con,"UPDATE ec_tickets SET level='3',old_level='".($tt_type=='2' ? '2' : '3')."',status='VISITED',closing_date='$efsr_date',efsr_no='$efsr_no',efsr_start='$efsr_start',efsr_date='$efsr_date',transaction_date='".date('Y-m-d')."' WHERE ticket_alias='$ticket_alias'");
				if($update){$result['err_code']='0';$result['err_msg']='Ticket Submited Successfully';$result['pdf_id']=$ticket_alias;}
				else{$result['err_code']='-5';$result['err_msg']='Ticket Not Submited';}
			}else{ //Exist TT
				$update = mysqli_query($mr_con,"UPDATE ec_tickets SET level='3',old_level='2',status='VISITED',closing_date='$efsr_date',tat='".tat($ticket_alias)."',efsr_no='$efsr_no',efsr_start='$efsr_start',efsr_date='$efsr_date',transaction_date='".date('Y-m-d')."',n_visits=(n_visits+1) WHERE ticket_alias='$ticket_alias'");
				if($update){
					$ticket_id=alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
					// Material Outward level update and remaining replace cell get bcak to warehouse start
					$sqlou=mysqli_query($mr_con,"SELECT COUNT(t1.id) AS cnt,GROUP_CONCAT(DISTINCT t2.item_description) AS itm_cod_ali FROM ec_material_outward t1 INNER JOIN ec_material_sent_details t2 ON t1.alias=t2.reference WHERE t1.from_type='1' AND t1.to_wh<>'2609' AND t1.status<>'6' AND t1.ref_no='$ticket_alias' AND t1.flag='0'");
					$rowou=mysqli_fetch_array($sqlou);
					$tlt_arr=($rowou['cnt']>'0' ? explode(",",$rowou['itm_cod_ali']) : array());
					if(count($replaced_cell_arr)){
						$sqlrepl=mysqli_query($mr_con,"SELECT COUNT(id) AS cnt,GROUP_CONCAT(item_code_alias) AS itm_cod_ali FROM ec_item_code WHERE item_description IN('".implode("','",$replaced_cell_arr)."') AND flag='0'");
						$rowrepl=mysqli_fetch_array($sqlrepl);
						$repl_arr=($rowrepl['cnt']>'0' ? explode(",",$rowrepl['itm_cod_ali']) : array());
						if($rowrepl['cnt']>'0')$tlt_cl = mysqli_query($mr_con,"UPDATE ec_total_cell SET stage='0',site_stage='1' WHERE cell_alias IN('".implode("','",$repl_arr)."') AND flag='0'");
						foreach($repl_arr as $cel1)$hist_sql1 = mysqli_query($mr_con,"INSERT INTO ec_total_cell_history(cell_alias,message)VALUES('$cel1','Cell replaced at Site ".alias_flag_none(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','site_name')." against TT Number ".$ticket_id."')");
					}else $repl_arr=array();
					$remain_array = array_diff($tlt_arr,$repl_arr);
					if(count($remain_array)){
						$remain_sql = mysqli_query($mr_con,"UPDATE ec_total_cell old JOIN ec_total_cell new USING (id) SET new.location = old.old_location, new.location_type = old.old_location_type,new.old_location = old.location, new.old_location_type = old.location_type, old.stage='0',old.site_stage='0',old.transDate='".date('Y-m-d')."' WHERE old.cell_alias IN('".implode("','",$remain_array)."') AND old.flag='0'");
						$wh_code = alias(alias(end($remain_array),'ec_total_cell','cell_alias','location'),'ec_warehouse','wh_alias','wh_code');
						foreach($remain_array as $cel)$hist_sql = mysqli_query($mr_con,"INSERT INTO ec_total_cell_history(cell_alias,message)VALUES('$cel','Cell not utilized at site hence cell inward to warehouse : ".$wh_code."')");
					}
					$out_cl = mysqli_query($mr_con,"UPDATE ec_material_outward SET status='6' WHERE from_type='1' AND to_wh<>'2609' AND ref_no='$ticket_alias' AND flag='0'");
					// Material Outward level update and remaining replace cell get bcak to warehouse end

					$serNum=alias($service_engineer_alias,'ec_employee_master','employee_alias','mobile_number');
					$custNum=alias_flag_none($site_alias,'ec_sitemaster','site_alias','technician_number');
					$custMsg=urlencode("Greetings from Enersys, Against Ticket No-".$ticket_id." SE Mob-".$serNum." has completed the Site visit and status will be updated Shortly.");
					// messageSent($custNum,$custMsg);
					$state_alias=alias($site_alias,'ec_sitemaster','site_alias','state_alias');
					ecSendSms('job_done_with_efsr', $state_alias, $custNum, $custMsg);
					if(count($faulty_cell_arr))$acc_inv = mysqli_query($mr_con,"UPDATE ec_tickets_inventory SET material_inward='1' WHERE ticket_alias='$ticket_alias' AND flag='0'");
					$msgg="e-FSR of Ticket No-".$ticket_id." against the Activity ".$mssg_activity_name." of Site name-".$mssg_site_name." awaiting for your Approval.";
					ticket_notification($ticket_alias,$msgg);
					if($segment_alias=="HXL5A1HOTZ")$tele_mail=$ticket_alias;
					$result['err_code']='0';$result['err_msg']="Ticket Submited Successfully";$result['pdf_id']=$ticket_alias;
				}else{$result['err_code']='-5';$result['err_msg']="Ticket Not Submited";}
			}
		}else{$result['err_code']=(empty($res) ? "-4" : "-5");$result['err_msg']=(empty($res) ? "Ticket Already Submitted" : $res);}
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	
	//obj start
		if(file_exists("ticket_objects/success/".$temp_tt.".txt"))$temp_tt = $temp_tt."_".rand();
		$myfileres = fopen("ticket_objects/success/".$temp_tt.".txt", "w") or die("Unable to open file!");
		fwrite($myfileres, json_encode($result));
		fclose($myfileres);
	//obj end
	
	echo mobile_app_encode($result);
	if(!empty($tele_mail))file_get_contents(baseurl()."mobile_app/efsr_submit_mail.php?ticketAlias=".$tele_mail);
}
function change_log(){ 
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$login = json_decode(base64_decode($login->key));
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;		  
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$ver=$login->app_version;$result['change_log']['check_list']=array();
		$sql=mysqli_query($mr_con,"SELECT COUNT(id) AS cnt, MAX(change_logName) AS late_ver FROM ec_app_change_log WHERE change_logName>'$ver' AND ref_id='0' AND flag=0");
		$row_lat=mysqli_fetch_array($sql);
		if($row_lat['cnt']>0){
			$result['change_log']['status']='1';
			$query=mysqli_query($mr_con,"SELECT log_alias FROM ec_app_change_log WHERE change_logName='".$row_lat['late_ver']."' AND flag=0");
			if(mysqli_num_rows($query)){
				$row=mysqli_fetch_array($query);
				$result['change_log']['change_logName']=$row_lat['late_ver'];
				$query1=mysqli_query($mr_con,"SELECT change_logName FROM ec_app_change_log WHERE ref_id='".$row['log_alias']."' AND flag=0");
				if(mysqli_num_rows($query1)){
					$i=0;while($row1=mysqli_fetch_array($query1)){
						$result['change_log']['check_list'][$i]['change_logName']=$row1['change_logName'];
					$i++;}
				}else{$result['change_log']['change_logName']=$row_lat['late_ver']; $result['change_log']['check_list'][0]['change_logName']='No Records';}
			}else{$result['change_log']['change_logName']=$row_lat['late_ver']; $result['change_log']['check_list'][0]['change_logName']='No Records';}
		}else $result['change_log']['status']='0';
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	echo mobile_app_encode($result);
}
/*function delete_log(){ global $mr_con;
	date_default_timezone_set("Asia/Kolkata");
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody());
	$test_json=base64_decode($login->key);

	$login = json_decode($test_json);
	$emp_id=$login->emp_id;
	$device_id=$login->device_id;
	
	list($rex,$msg)=explode("@",check_login($device_id,$emp_id));
	if($rex=='0'){
		$emp_name=alias($emp_id,'ec_employee_master','employee_id','name');
		$tt_dpr_no=$login->tt_dpr_no;
		$type=$login->type;
		$log="[Date Time  : ".date("D M d H:i:s.U Y")."] [".td_type($type)." : ".$tt_dpr_no."] [Name : ".$emp_name."] [Emp ID : ".$emp_id."] [Device ID : ".$device_id."] \r\n\r\n ".$test_json."_".date('Y_m_d_H_i_s');
		
		//Obj
			$data = $test_json."_".date('Y_m_d_H_i_s')."\r\n\r\n";
			$fh = fopen("delete_log/delete_log.txt", 'a') or die("can't open file");
			fwrite($fh, $data);
			fclose($fh);
		//obj
		$result['err_code']='0';$result['err_msg']='Successful';
	}else{$result['err_code']=$rex;$result['err_msg']=$msg;}
	echo mobile_app_encode($result);
}
function td_type($type){
	switch($type){
		case '0': return "Ticket";break;
		case '1': return "Spot Ticket";break;
		case '2': return "Offline Ticket";break;
		case '3': return "DPR";break;
		default : return "NONE";
	}
}*/
?>