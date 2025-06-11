<?php 
include ('mysql.php');
include ('email_sms_functions.php');
date_default_timezone_set("Asia/Kolkata");
$bccemail="ticket@enersys.co.in";
function all_from_mail(){ return "enersyscare_no_reply@enersys.com.cn"; }
function baseurl(){ return "https://enersyscare.co.in/"; }
function newBaseURL() {
	global $newBaseUrl;
	if ($newBaseUrl == "") {
		return baseurl();
	}
	return $newBaseUrl; 
}
function localURL() {
	global $localUrl; 
	if ($localUrl == "") {
		return baseurl();
	}
	return $localUrl; 
}
function checkempty($fv1){if($fv1=="" || $fv1=='0' || $fv1=='0000-00-00' || $fv1=='00-00-0000') return "NA";else return $fv1;}
function checkemptydash($fv1){if($fv1=="" || $fv1=='0000-00-00' || $fv1=='00-00-0000') return "-";else return $fv1;}
function spec_esc_preg($string){ return preg_replace('/[^a-zA-Z0-9_ %\?\[\]\.\(\)%&-]/s','',$string);}
function iss($a){ return (isset($a) ? $a : "");}
function dateFormat($date,$x){ global $mr_con;
	$date=str_replace(" ","",$date);
	if(strpos($date,"/")!==false)$date=str_replace("/","-",$date);
	if(preg_match("/\d{4}\-\d{1,2}-\d{1,2}/", $date) || preg_match("/\d{1,2}\-\d{1,2}-\d{4}/", $date)){
		if($date=='0000-00-00' || $date=='00-00-0000'){ $y = 'NA';}
		elseif($x=="m"){ $y = date("m-d-Y", strtotime(mysqli_real_escape_string($mr_con,$date)));}
		else{ $y = date(($x=="d" ? "d-m-Y" : "Y-m-d"), strtotime(mysqli_real_escape_string($mr_con,$date)));}
		if(strpos($y,'1970')!==false){$y = 'NA';}
	}else{$y = 'NA';}
	return $y;
}
function financial_year($a){
	$date=strtotime($a);
	$pres = date('y', $date);
	if(date('m', $date)<=3) $return = date('y',strtotime("-1 year", $date))."-".$pres;
	else $return = $pres."-".date('y',strtotime("+1 year", $date));
	return "FY ".$return;
}
function dateTimeFormat($date_time,$x){ global $mr_con;
	if(strpos($date_time,"/")!==false)$date_time=str_replace("/","-",$date_time);
	if(preg_match("/\d{4}\-\d{1,2}\-\d{1,2} \d{2}\:\d{2}\:\d{2}/", $date_time) || preg_match("/\d{1,2}\-\d{1,2}\-\d{4} \d{2}\:\d{2}\:\d{2}/", $date_time)){
		if($date_time=='0000-00-00 00:00:00' || $date_time=='00-00-0000 00:00:00'){ $y = 'NA';}
		elseif($x=="m"){ $y = date("m-d-Y H:i:s", strtotime(mysqli_real_escape_string($mr_con,$date_time)));}
		else{ $y = date(($x=="d" ? "d-m-Y H:i:s" : "Y-m-d H:i:s"), strtotime(mysqli_real_escape_string($mr_con,$date_time)));}
		if(strpos($y,'1970')!==false){$y = 'NA';}
	}else{$y = 'NA';}
	return $y;
}
function php_excel_date($date){
	return (((strpos($date,"1970")!==false) || empty($date) || $date=="0000-00-00" || $date=="0000-00-00 00:00:00") ? "-" : (PHPExcel_Shared_Date::PHPToExcel(strtotime("+5 hours +30 minutes",strtotime($date)))));
}
function date_1970_check($date){
	return (((strpos($date,"1970")!==false) || empty($date) || $date=="0000-00-00" || $date=="0000-00-00 00:00:00") ? "-" : $date);
}
function visit_exp_count($ticket_id){ global $mr_con;
	$v_re=mysqli_query($mr_con,"SELECT id FROM ec_tickets WHERE ticket_id LIKE '%".$ticket_id."%' AND ticket_id NOT LIKE '%".$ticket_id."-%' AND (efsr_no<>'' OR esca_efsr_link<>'') AND flag=0");
	return mysqli_num_rows($v_re);
}
function aging($min_date,$max_date){
	if(!empty($min_date) && $min_date!='0000-00-00 00:00:00' && !empty($max_date) && $max_date!='0000-00-00 00:00:00'){
		$date1 = strtotime($min_date);
		$date2 = strtotime($max_date);
		$subTime = $date2 - $date1;
		$d = ($subTime/(60*60*24))%365;
		$h = ($subTime/(60*60))%24;
		return ($d!='0' ? $d." D ".$h." H" : $h." H");
	}else return "-";
}

function generateTimeAsAlias() {return generateRandomString(4);}
function aliasTime($fv1,$fv2,$fv3){ return $fv1.round(microtime(true) * 1000).rand().str_shuffle($fv1);}

function generateRandomString($length = 4) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++){$randomString .= $characters[rand(0, $charactersLength - 1)];}
	return strtoupper($randomString);
}
function aliasCheck($fv1,$fv2,$fv3){ return $fv1.round(microtime(true) * 1000).rand().str_shuffle($fv1);}
function re_check_alias($new_alias,$temp_arr,$tbl,$tbl_alias){
	if(!in_array($new_alias,$temp_arr)){
		array_push($temp_arr,$new_alias);
		return $temp_arr;
	}else return re_check_alias(aliasCheck(generateRandomString(),$tbl,$tbl_alias),$temp_arr,$tbl,$tbl_alias);
}
function aliasMulCheck($fv1){ 
	global $mr_con;
	$fv1 = generateRandomString();
	return $fv1.round(microtime(true) * 1000).rand().str_shuffle($fv1);
}
function aliasFlag0($alias,$tb,$col,$retrive){ 
	global $mr_con;
	$query = "SELECT $retrive FROM $tb WHERE $col='$alias' AND flag = 0";
	if($tb=="ec_employee_master")$query .= " AND status = 'WORKING'";
	$sql = mysqli_query($mr_con, $query);
	if(mysqli_num_rows($sql)){
		$row = mysqli_fetch_array($sql);
		return $row[$retrive];
	}else return "";
}
function alias($alias,$tb,$col,$retrive){ global $mr_con;
	if($tb=="ec_employee_master" && $col=="employee_alias" && $retrive=="name")$con = ""; else $con="";
	$query = "SELECT $retrive FROM $tb WHERE $col='$alias' $con";
	$sql = mysqli_query($mr_con, $query);
	if(mysqli_num_rows($sql)){
		$row = mysqli_fetch_array($sql);
		return $row[$retrive];
	}else return "";
}
function password_rehash_update($new_hash_pwd,$table,$id){ global $mr_con;
	$sql=mysqli_query($mr_con,"UPDATE $table SET password='$new_hash_pwd' WHERE id='$id' AND flag='0'");
	return $sql ? true : false;
}
function generate_token($emp_alias, $userName, $userType){ 
	global $mr_con;
	$token = aliasCheck(generateRandomString(),'ec_token','token');
	$query = "INSERT INTO ec_token(employee_alias, employee_name, employee_type, access_token, token, created_date) VALUES('$emp_alias', '$userName', '$userType', '', '$token', '".date('Y-m-d')."')";
	$sql = mysqli_query($mr_con, $query);
	return $sql ? $token : false;
}

function get_options(){
    if (function_exists('mcrypt_create_iv')) {
        $options = [
            'cost' => 11, 'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
        ];
        return $options;
    } else if (function_exists('random_bytes')) {
        $options = [
            'cost' => 11, 'salt' => random_bytes(32)
        ];
        return $options;
    } else {
        $options = [
            'cost' => 11, 'salt' => 'abcdefghijklmnopqrstuvwxyz0123456789'
        ];
        return $options;
    }
}

function password_hash_encript($pwd){
	$options = get_options();
	return password_hash($pwd, PASSWORD_DEFAULT, $options);
}
function login_hash_encript_check($pwd,$hash){
	//print_r ( password_get_info ( $hash ) );
	// Verify stored hash against plain-text password
	if (password_verify($pwd, $hash)) {
		// The cost parameter can change over time as hardware improves
		//$options = array('cost' => 11);
		$options = get_options();
		// Check if a newer hashing algorithm is available
		// or the cost has changed
		if (password_needs_rehash($hash, PASSWORD_DEFAULT, $options)) {
			// If so, create a new hash, and replace the old one
			 $new_hash = password_hash($pwd, PASSWORD_DEFAULT, $options);
			 $result=[ true, $new_hash];
		}else $result=[ true ];
	}else $result=[ false ];
	return $result;
}
function alias_flag_none($alias,$tb,$col,$retrive){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT $retrive FROM $tb WHERE $col='$alias'");
	if(mysqli_num_rows($sql)){
		$row = mysqli_fetch_array($sql);
		return $row[$retrive];
	}else return "";
}
function mul_alias($alias,$tb,$col,$retrive){ global $mr_con;
		$sql = mysqli_query($mr_con,"SELECT $retrive FROM $tb WHERE $col RLIKE '$alias' AND flag=0");
		$result=array();
		if(mysqli_num_rows($sql)){
			while($row = mysqli_fetch_array($sql)){
			$result[]=$row[$retrive];}
		}
		return $result;
}
function car_random($a){ global $mr_con;
	$rand="CAR-".$a;
	$query=mysqli_query($mr_con,"SELECT id FROM ec_ths_approved WHERE car_number='$rand' AND flag=0");
	return (mysqli_num_rows($query) ? car_random(rand(00000,99999)) : $rand);
}
function admin_privilege($emp_alias){ global $mr_con;
	if(strtoupper($emp_alias)=="ADMIN")return TRUE;
	else{
		$privilege_alias=alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias');
		if(!empty($privilege_alias)){
			$query=mysqli_query($mr_con,"SELECT id FROM ec_privileges WHERE privilege_alias='$privilege_alias' AND grantable='0' AND flag=0");
			return (mysqli_num_rows($query) ? FALSE : TRUE);
		}else return FALSE;
	}
}
function authentication($emp_alias,$token) { global $mr_con; 
	if($emp_alias=="admin" && $token=="admin") return '0';
	else{
		// password will expire in 2 hours
		// $query = "SELECT id FROM ec_token WHERE employee_alias='$emp_alias' AND token='$token' AND flag=0 AND DATE_ADD(last_updated, INTERVAL 2 HOUR) > now()";
		$query = "SELECT id FROM ec_token WHERE employee_alias='$emp_alias' AND token='$token' AND flag=0";
		$sql = mysqli_query($mr_con, $query);
		if(mysqli_num_rows($sql)>0) return '0';
		else {
			$sql1 = mysqli_query($mr_con,"SELECT id FROM ec_employee_master WHERE employee_alias='$emp_alias' AND flag=1");
			if(mysqli_num_rows($sql1)>0) return '2';
			else return '1';
			//$sql2 = mysqli_query($mr_con,"SELECT id FROM ec_token WHERE employee_alias='$emp_alias' AND token!='$token' AND flag=0");
		}
	}
}
function passwordAuthentication($emp_alias, $password) { 
	global $mr_con; 
	$query = "SELECT name, employee_alias, password, status, flag FROM ec_employee_master WHERE employee_alias='$emp_alias'";
	$ep_sql = mysqli_query($mr_con, $query);
	$ep_row = mysqli_fetch_array($ep_sql);
	$hash = login_hash_encript_check($password, $ep_row['password']);
	if($hash[0]) {
		return '0';
	} else {
		return '1';
	}
}
/*function remarks_bucketing($bucket) {
	switch($bucket){
		case '1' : return "CLOSED"; // Closed at any level
		case '2' : return "DECLINED"; // Declined at any level
		case '3' : return "OUT OF WARRANTY"; // Out of warranty at TT Inactive level
		case '4' : return "AT AND I&C"; // Only for AT and I&C at TT Inactive level
		case '5' : return "REQUIRED CELL"; // Required Cell Remarks at Inactive and Planned level
		case '6' : return "RE PLANNED"; // Re-planned Remarks at Planned level
		case '7' : return "FSR SUBMIT"; // FSR Submit Remarks at planned level
		case '8' : return "EFSR SUBMIT"; // EFSR Submit Remarks at planned level
		case '9' : return "SEND TO NHS"; // NHS Approval required at zonal level
		case '10' : return "SEND TO TS"; // TS Approval required at NHS level
		case '11' : return "NEXT VISIT"; // Approved for next visit at zonal as well as NHS level
		case '12' : return "TS APPROVED"; // TS approved TT which is come from NHS at NHS level
		case '13' : return "TS REJECTED"; // TS rejected TT which is come from NHS at NHS level
		case '14' : return "STOCK APPROVED"; // Stock approved at TS level which is come from Cells Required at inctive OR planned level
		case '15' : return "STOCK REJECTED"; // Stock rejected at TS level which is come from Cells Required at inctive OR planned level
			
		case '16' : return "REQUEST ADD"; // HO Coordinator raise the SJO
		case '17' : return "REQUEST EDIT"; // HO Coordinator Send for Approval to 
		case '18' : return "MD APPROVED"; // MD Approved Stock
		case '19' : return "MD HOLD"; // MD Hold Stock
		case '20' : return "MD REJECTED"; // MD Rejected Stock
		case '21' : return "DYNAMIC APPROVED"; // Any Dynamic level privilege Approved Stock
		case '22' : return "DYNAMIC REJECTED"; // Any Dynamic level privilege Rejected Stock
		case '23' : return "READYNESS"; // PPC Add Readyness Date
		case '24' : return "RE READYNESS"; // PPC Add Re Readyness Date
		case '25' : return "INWARD FW"; // Inward from factory to Warehouse(ZHS)
		case '26' : return "INWARD SW"; // Inward from site to Warehouse(ZHS)
		case '27' : return "INWARD WF"; // Inward from Warehouse to factory(CHANDRA SHEKAR)
		case '28' : return "OUTWARD FW"; // Outward from factory to Warehouse(RAVI KANTH)
		case '29' : return "OUTWARD WS"; // Outward from Warehouse to Site(ZHS)
		case '30' : return "OUTWARD WF"; // Outward from Warehouse to factory(ZHS)
		default : return "NA";
	}
}*/
function create_zipfile($files,$loc_file_name){
	$zip = new ZipArchive(); //create new zip opbject
	$zip->open($loc_file_name, ZipArchive::CREATE);
	foreach($files as $file)$zip->addFromString(basename($file),file_get_contents($file));
	$zip->close(); //close zip
}
function upload_file($file,$ref,$type){ 
	global $mr_con;
	if(isset($file['name']) && !empty($file['name'])){
		$fileName = $ref.'_'.date('Y_m_d_H_i_s');
		$arr=($type=='image' ? array('png','jpg','jpeg','gif','tif','rif','bmp','bpg') : array('pdf'));
		$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
		if(in_array($ext,$arr)){
			if($file["size"]<=5242880){//5MB
				$name = $fileName.".".$ext;
				if($ref=='profile_pic'){$path = "../../images/profile_pics/".$name;}
				elseif($ref=='esca_efsr'){$path = "../../images/esca_efsr/".$name;}
				elseif($ref=='po_file'){$path = "../../images/po_file/".$name;}
				else{$path = "../../images/reports/".$name;}
				if(file_exists($path)){$result = "2,".$name." already exists";}
				else{
					$move = move_uploaded_file($file["tmp_name"],$path);
					$pic = mysqli_real_escape_string($mr_con,$name);
					if($move){$result = "0,".$pic;}
					else{$result = "1,Error in Uploading file";}
				}
			}else{ $result = "2,The file size must be lessthan OR equal to 5MB"; }
		}else{ $result = "3,Choosen file is not an ".$type." file"; }
	}else{ $result = "4,Please Upload pdf file."; }
	return $result;
}
function ticketsID($site,$state,$i){ global $mr_con;
	$manf=(!empty($site) ? sitemanfdate_check($site) : 0);
	if($manf<=0){
		$sql = mysqli_query($mr_con,"SELECT id FROM ec_tickets WHERE ticket_id NOT LIKE '%|%' AND ticket_id NOT LIKE '%-%' AND flag='0'");
		$num = (mysqli_num_rows($sql)+$i); $arr = array();
		if($num > 999){$y = $num;}
		elseif($num > 99){$y = "0".$num;}
		elseif($num > 9){$y = "00".$num;}
		else{$y = "000".$num;}
		$x = "TT".$state.date("dmy").$y;
		$sql1 = mysqli_query($mr_con,"SELECT id FROM ec_tickets WHERE ticket_id LIKE '%".$y."' AND ticket_id NOT LIKE '%|%' AND ticket_id NOT LIKE '%-%' AND flag='0'");
		if(mysqli_num_rows($sql1)=='0'){ return $x; }
		else{return ticketsID($site,$state,($i+1)); }
	}else{
		$query = mysqli_query($mr_con,"SELECT ticket_id FROM ec_tickets WHERE site_alias='$site' && flag='0' ORDER BY login_date");
		if(mysqli_num_rows($query)>0){$ax=0;
			while($row=mysqli_fetch_array($query)){
				if (strpos($row['ticket_id'],'|')=== false){
					$ricketid[$ax]=$row['ticket_id'];
					$ax++;
				}
			}
			$al=range('A','Z');
			$count=count($ricketid);
			$alp=$count-1;
			if(strpos(end($ricketid),'-')!== false){
				list($ticket,$letter) = explode("-",end($ricketid));$letter++;
				return $ticket."-".$letter;
			}else return $ricketid[0]."-".$al[$alp];
		}else{
			$sql = mysqli_query($mr_con,"SELECT id FROM ec_tickets WHERE ticket_id NOT LIKE '%|%' AND ticket_id NOT LIKE '%-%' AND flag='0'");
			$num = (mysqli_num_rows($sql)+$i); $arr = array();
			if($num > 999){$y = $num;}
			elseif($num > 99){$y = "0".$num;}
			elseif($num > 9){$y = "00".$num;}
			else{$y = "000".$num;}
			$x = "TT".$state.date("dmy").$y;
			$sql1 = mysqli_query($mr_con,"SELECT id FROM ec_tickets WHERE ticket_id LIKE '%".$y."' AND ticket_id NOT LIKE '%|%' AND ticket_id NOT LIKE '%-%' AND flag='0'");
			if(mysqli_num_rows($sql1)=='0'){ return $x; }
			else{return ticketsID($site,$state,($i+1)); }
		}
	}
}
function sitemanfdate_check($site_alias){ global $mr_con;
	$cust=alias_flag_none($site_alias,'ec_sitemaster','site_alias','customer_alias');
	$sale=dateFormat(alias_flag_none($site_alias,'ec_sitemaster','site_alias','sale_invoice_date'),'y');
	$mfd_date=dateFormat(alias_flag_none($site_alias,'ec_sitemaster','site_alias','mfd_date'),'y');
	$idate=dateFormat(alias_flag_none($site_alias,'ec_sitemaster','site_alias','install_date'),'y');
	$mdate=($sale=='NA' ? $mfd_date : $sale);
	if($cust==""){$status=0;}
	elseif($mdate=="NA" && $idate=="NA"){$status=0;}
	else{
		if($mdate!="NA"){
			$date1 = new DateTime($mdate);
			$date2 = new DateTime(date("Y-m-d"));
			$warrantyd1 = $date2->diff($date1)->format("%a");
		}else{$warrantyd1 = "NA";}
		if($idate!="NA"){
			$date1 = new DateTime($idate);
			$date2 = new DateTime(date("Y-m-d"));
			$warrantyd2 = $date2->diff($date1)->format("%a");
		}else{$warrantyd2 = "NA";}
		$sql=mysqli_query($mr_con,"SELECT dispatch,installation,schedule FROM ec_customer WHERE customer_alias='$cust' AND flag=0");
		if(mysqli_num_rows($sql)){
			$row=mysqli_fetch_array($sql);
			$dispatch=$row["dispatch"]*30;
			$installation=$row["installation"]*30;
			if($row["dispatch"]==0){$warrantyd1 = "NA";}
			if($row["installation"]==0){$warrantyd2 = "NA";}
			if($warrantyd1 != "NA"){$tempw1=$dispatch-$warrantyd1;$na1="";}else{$tempw1=0;$na1="NA";}
			if($warrantyd2 != "NA"){$tempw2=$installation-$warrantyd2;$na2="";}else{$tempw2=0;$na2="NA";}
			if($na1=="NA"){ $status = ($tempw2<=0 ? 0 : 1); }
			elseif($na2=="NA"){ $status = ($tempw1<=0 ? 0 : 1);}
			else{ $status = ($tempw1<=0 || $tempw2<=0 ? 0 : 1); }
		}else{$status=0;}
	}
	return $status;
}
function tat($ticket_alias){ global $mr_con;
	date_default_timezone_set("Asia/Kolkata");
	$ticket_id=strtok(alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id'),"|");
	$sql=mysqli_query($mr_con,"SELECT login_date,closing_date FROM ec_tickets WHERE id = (SELECT MAX(id) FROM ec_tickets WHERE ticket_id LIKE '%".$ticket_id."%' AND ticket_id NOT LIKE '%".$ticket_id."-%') AND flag='0'");
	$row=mysqli_fetch_array($sql);
	$login_date=date_create($row['login_date']);
	$closing_date=date_create(empty($row['closing_date']) ? date('Y-m-d') : $row['closing_date']);
	$diff=date_diff($login_date,$closing_date);
	$for_mat = $diff->format("%R%a");
	if($for_mat <= 15) return "TAT-1";
	elseif($for_mat >= 16 && $for_mat <= 25) return "TAT-2";
	else return "TAT-3"; //$for_mat > 25
}
function repl_planfail_tsrej($level,$old_level,$planned,$purpose,$ref){
	if($level=='1'){
		if($purpose=='1')$result = ($ref=='name' ? 'REPL DUE' : alias(1,'ec_levels','level_alias','level_color'));		
		else $result = ($ref=='name' ? alias($level,'ec_levels','level_alias','level_name') : alias($level,'ec_levels','level_alias','level_color'));
	}elseif($level=='2'){
		$today = date('Y-m-d');
		if($today > $planned)$result = ($ref=='name' ? 'PLAN FAIL' : alias(1,'ec_levels','level_alias','level_color'));		
		else $result = ($ref=='name' ? alias($level,'ec_levels','level_alias','level_name') : alias($level,'ec_levels','level_alias','level_color'));
	}elseif($level=='4'){
		if($old_level=='8')$result = ($ref=='name' ? 'TS REJECTED' : alias(4,'ec_levels','level_alias','level_color'));
		else $result = ($ref=='name' ? alias($level,'ec_levels','level_alias','level_name') : alias($level,'ec_levels','level_alias','level_color'));
	}else{ //$level=='5'
		$result = ($ref=='name' ? ts_approved_lvl($old_level) : alias($level,'ec_levels','level_alias','level_color'));
	}
	return $result;
}
function nhsDue_tsRej_level($level,$old_level){
	return ($level=='4' && $old_level=='8' ? 'TS REJECTED' : alias($level,'ec_levels','level_alias','level_name'));
}
function grantable($privilege_type,$privilege_item,$emp_alias){ global $mr_con;
	if(strtoupper($emp_alias)=='ADMIN')$result=TRUE;
	elseif(strtoupper($emp_alias)=='EADMIN') {
		if($privilege_item=='ALLOWANCES' || $privilege_item=='APPROVERS' || $privilege_item=='DEPARTMENTS' || $privilege_item=='DESIGNATIONS' || $privilege_item == 'LIMITS' || $privilege_item == 'SETTINGS') {
			$result = TRUE;
		} else {
			$result=($privilege_type=='ADD' || $privilege_type=='EDIT'  ? TRUE : FALSE);
		}
	} else {
		$privilege_alias = alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias');
		$query = "SELECT grantable FROM ec_privileges WHERE privilege_item = '$privilege_item' AND privilege_type = '$privilege_type' AND privilege_alias='$privilege_alias' AND flag='0'";
		$sql=mysqli_query($mr_con, $query);
		$row = mysqli_fetch_array($sql);
		$result = ($row['grantable']=='1' ? TRUE : FALSE);
	}
	return $result;
}
function getempwarehouse($fv1){ global $mr_con;
	if($fv1!=""){
		if(admin_privilege($fv1)){
			$sql=mysqli_query($mr_con,"SELECT wh_alias FROM ec_warehouse WHERE flag=0");
			if(mysqli_num_rows($sql)){$wh_temp=array();
				while($row=mysqli_fetch_array($sql)){$wh_temp[]=$row['wh_alias'];}
				$wh="'".implode("','", $wh_temp)."'";
			}else{$wh=0;}
		}else{
			$wh=alias($fv1,'ec_employee_master','employee_alias','wh_alias');
			if($wh==""){
				$state=alias($fv1,'ec_employee_master','employee_alias','state_alias');
				if($state!=""){
					$state="'".str_replace(", ","','",$state)."'";
					$sql=mysqli_query($mr_con,"SELECT wh_alias FROM ec_warehouse WHERE state_alias IN ($state) AND flag=0");
					if(mysqli_num_rows($sql)){$wh_temp=array();
						while($row=mysqli_fetch_array($sql)){$wh_temp[]=$row['wh_alias'];}
						$wh="'".implode("','", $wh_temp)."'";
					}else{$wh=0;}
				}else{$wh=0;}
			}else $wh="'".str_replace(", ","','",$wh)."'";
		}
	}else{$wh=0;}
	return $wh;
}
function user_history($emp_alias,$action,$ip, $remarks = ''){ 
	global $mr_con;
	if ($action != "") {
		$query = "INSERT INTO ec_user_history(employee_alias, action, date_time, ip_address,  remarks) VALUES('$emp_alias', '$action', '" . date('Y-m-d H:i:s') . "', '$ip',  '$remarks')";
		$sql=mysqli_query($mr_con, $query);
		return ($sql ? TRUE : FALSE);
	}
}
function user_track_type($type){
	if($type!=""){
		switch($type){
			case '0': return "T";break; //Triggering
			case '1': return "L";break; //First Time Login
			case '2': return "A";break; //Second Time Login
			case '3': return "E";break; //eFSR
			case '4': return "D";break; //DPR
			default : return "";
		}
	}else return "";
}
function pending_mail_log($item_alias,$bucket){global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT id FROM pending_mail_log WHERE item_alias='$item_alias' AND bucket='$bucket' AND status='0' AND flag='0'");
	if(mysqli_num_rows($sql)=='0'){
		$mail=mysqli_query($mr_con,"INSERT INTO pending_mail_log(item_alias,bucket)VALUES('$item_alias','$bucket')");
		if($mail)return TRUE;else return FALSE;
	}
}
function success_mail_log($item_alias,$bucket){global $mr_con;
	$mail=mysqli_query($mr_con,"UPDATE pending_mail_log SET status='1' WHERE item_alias='$item_alias' AND bucket='$bucket' AND flag=0");
	if($mail)return TRUE;else return FALSE;
}
function messageSent($num,$msg) {
	
	$smsDetails = $GLOBALS['envSms'];
	if(preg_match("/\d{10}/", $num) && isset($smsDetails['send']) && $smsDetails['send']) {
		$postDetails = "user=" . $smsDetails['user'];
		$postDetails .= "&pass=" . $smsDetails['pass'];
		$postDetails .= "&sender=" . $smsDetails['sender'];
		$postDetails .= "&priority=" . $smsDetails['priority'];
		$postDetails .= "&stype=" . $smsDetails['stype'];
		$postDetails .= "&phone=" . $num;
		$postDetails .= "&text=" . $msg;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $smsDetails['url']);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postDetails);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_exec ($curl);
		curl_close ($curl);
	}
}
function curlxing($url){
	$chu = curl_init();
	curl_setopt($chu, CURLOPT_URL, $url);
	curl_setopt($chu, CURLOPT_FRESH_CONNECT, true);
	curl_setopt($chu, CURLOPT_TIMEOUT, 30);
	curl_setopt($chu, CURLOPT_SSL_VERIFYPEER, false);
	curl_exec($chu);
	curl_close($chu);
}
function notification($reg_id,$mssg){
	// API access key from Google API's Console
	define('API_ACCESS_KEY', 'AIzaSyCHJ1h1U0y8-wIAtbIw_-rAhkK5opA_2qo');
	//define('API_ACCESS_KEY', 'AIzaSyCPr4vEYPiylMHvnV--vULqzK4wBMQuGYU');
	$registrationIds = array($reg_id);
	// prep the bundle
	$msg = array('message' 	=> urlencode($mssg));
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
function admin_privilege_get_emp_priv($ref="P"){ global $mr_con; $result=array();
	$sql=mysqli_query($mr_con,"SELECT privilege_alias FROM ec_privileges WHERE flag=0 GROUP BY privilege_alias HAVING SUM(grantable = 1)>0 AND SUM(grantable <> 1)=0");
	if(mysqli_num_rows($sql)){
		while($queR = mysqli_fetch_array($sql))$result[]= $queR["privilege_alias"];
		if($ref=="E"){
			$sql0 = mysqli_query($mr_con,"SELECT employee_alias FROM ec_employee_master WHERE privilege_alias IN('".implode("','",$result)."') AND flag='0'");
			if(mysqli_num_rows($sql0)){ $result=array();
				while($row0 = mysqli_fetch_array($sql0)){
					$result[]=$row0['employee_alias'];
				}
			}
		}
	}
	return $result;
}
function ticket_notification($ticket_alias,$msgg) {
	global $mr_con;
	$notif_alias=aliasCheck(generateRandomString(),'ec_notifications','notif_alias');
	$level=alias_flag_none($ticket_alias,'ec_tickets','ticket_alias','level');
	$old_level=alias_flag_none($ticket_alias,'ec_tickets','ticket_alias','old_level');
	$state_alias=alias_flag_none(alias_flag_none($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','state_alias');
	if($level=='1' || $level=='6' || $level=='7')$con="state_alias LIKE '%".$state_alias."%' AND";
	elseif($level=='2' || $level=='3')$con="((state_alias LIKE '%".$state_alias."%' AND role_alias='RWRKFNVF49') OR employee_alias='".alias_flag_none($ticket_alias,'ec_tickets','ticket_alias','service_engineer_alias')."') AND";
	elseif($old_level=='2' || $old_level=='3')$con="state_alias LIKE '%".$state_alias."%' AND privilege_alias='OX5E3EMI0U' AND";
	elseif($old_level=='3' || $old_level=='4')$con="state_alias LIKE '%".$state_alias."%' AND privilege_alias='WIMYJFDJPT' AND";
	else $con="id='' AND";
	//$con=($level=='2' ? "(state_alias LIKE '%".$state_alias."%' OR employee_alias='".alias($ticket_alias,'ec_tickets','ticket_alias','service_engineer_alias')."') AND" : "state_alias LIKE '%".$state_alias."%' AND");
	$sql1=mysqli_query($mr_con,"INSERT INTO ec_notifications(employee_alias,title_ticket,msg_stage,type_ref,notif_alias) VALUES('ADMIN','$ticket_alias','$level','1','$notif_alias')");
	$ap = admin_privilege_get_emp_priv();
	$admin_privileges = "'".implode("','",$ap)."'";
	if(count($ap)){
		$sql0 = mysqli_query($mr_con,"SELECT employee_alias FROM ec_employee_master WHERE privilege_alias IN($admin_privileges) AND flag='0'");
		if(mysqli_num_rows($sql0)){
			while($row0 = mysqli_fetch_array($sql0)){
				$sql20=mysqli_query($mr_con,"INSERT INTO ec_notifications(employee_alias,title_ticket,msg_stage,type_ref,notif_alias)VALUES('".$row0['employee_alias']."','$ticket_alias','$level','1','$notif_alias')");
				if($sql20){
					$reg_id0 = alias($row0['employee_alias'],'ec_employee_master','employee_alias','reg_id');			
					if(!empty($reg_id0))notification($reg_id0,$msgg);
				}
			}
		}
	}
	$sql = mysqli_query($mr_con,"SELECT employee_alias FROM ec_employee_master WHERE $con privilege_alias NOT IN($admin_privileges) AND department_alias='TTTCL87RPU' AND flag='0'");
	if(mysqli_num_rows($sql)){
		while($row = mysqli_fetch_array($sql)){
			$sql2=mysqli_query($mr_con,"INSERT INTO ec_notifications(employee_alias,title_ticket,msg_stage,type_ref,notif_alias)VALUES('".$row['employee_alias']."','$ticket_alias','$level','1','$notif_alias')");
			if($sql2){
				//if($level == '1' || $level == '6' || $level == '7'){
					$reg_id = alias($row['employee_alias'],'ec_employee_master','employee_alias','reg_id');			
					if(!empty($reg_id))notification($reg_id,$msgg);
				//}
			}
		}
	}
}
function inventory_notification($material_alias,$msg,$type_ref){ global $mr_con;
	$emp_arr=array();
	if($type_ref=='3' || $type_ref=='6'){ //Request OR Stocks
		$from=alias($material_alias,'ec_material_request','mrf_alias','from_wh');
		$to=alias($material_alias,'ec_material_request','mrf_alias','to_wh');
		$some_emp=$all_emp=$nhs_m=$ee_arr=array(); $to_all = FALSE;
		$n_z_onrs_sql=mysqli_query($mr_con,"SELECT GROUP_CONCAT(employee_alias) AS emp_n FROM ec_employee_master WHERE (privilege_alias IN ('WIMYJFDJPT','5KPS8Q0ZNB') OR (".sub_query($from,$to)." privilege_alias='OX5E3EMI0U')) AND flag=0 AND status='WORKING'");//nhs, zhs, onrol se
		$nhs_row=mysqli_fetch_array($n_z_onrs_sql);$nhs_m=explode(",",$nhs_row['emp_n']);
		if($type_ref=='3'){ //Request
			$status = alias($material_alias,'ec_material_request','mrf_alias','status');
			if($status=='1'){
				$dyn_emp_ali = next_dynamic($material_alias,'E');
				if(!empty($dyn_emp_ali)){
					$ee_arr = explode(",",$dyn_emp_ali);
					foreach($ee_arr as $emp_ali){
						$reg_id = alias($emp_ali,'ec_employee_master','employee_alias','reg_id');
						$sjo_number=alias($material_alias,'ec_material_request','mrf_alias','sjo_number');
						$wh_code = alias($from,'ec_warehouse','wh_alias','wh_code');
						notification($reg_id,"Material Request of SJO No-$sjo_number from Warehouse $wh_code is awaiting for your Approval.");
					}
				}else $to_all = TRUE;
			}else $to_all = TRUE;
		}
		if($type_ref=='6' || $to_all){ //Stocks
			if(alias($to,'ec_warehouse','wh_alias','wh_type')=='1'){
				//$mr_to=array('ADMIN','neeraj@enersys.co.in','varaprasad@enersys.co.in','chandra@enersys.co.in','Ravikanthp@enersys.co.in','sudhakararaju@enersys.co.in','anandak@enersys.co.in','sivakumar.p@enersys.co.in','madan@enersys.co.in','rambhupal@enersys.co.in','pradeep@enersys.co.in','saivaranasi@enersys.co.in');
				$some_emp=array('ENVHMNCXOV','NR9MM7AOMZ','DRAAEUSYLY','6FXIYMITVD','8NSGB0LGBB','T8EHH2HD0K','KSOG2VPKZ9','SPTKCHOURA','LEL6OD13N2','QNMIHK3B8V','ZKZJSB4ND9','S2UOKHPZNA');
			}else{
				//$mr_to=array('ADMIN','pradeep@enersys.co.in','saivaranasi@enersys.co.in');
				$some_emp=array('ZKZJSB4ND9','S2UOKHPZNA');
			}
		}$all_emp=array_merge($some_emp,$nhs_m,$ee_arr);
		$emp_arr=array_filter(array_unique($all_emp));
	}elseif($type_ref=='4'){ //Inward
		$from=alias($material_alias,'ec_material_inward','alias','from_wh');
		$to=alias($material_alias,'ec_material_inward','alias','to_wh');
		$some_emp=array();$all_emp=array();$nhs_m=array();
		$n_z_onrs_sql=mysqli_query($mr_con,"SELECT GROUP_CONCAT(employee_alias) AS emp_n  FROM ec_employee_master WHERE (privilege_alias IN ('WIMYJFDJPT','5KPS8Q0ZNB') OR (".sub_query($from,$to)." privilege_alias='OX5E3EMI0U')) AND flag=0 AND status='WORKING'");//nhs, zhs, onrol se
		$nhs_row=mysqli_fetch_array($n_z_onrs_sql);$nhs_m=explode(",",$nhs_row['emp_n']);
		if(alias($to,'ec_warehouse','wh_alias','wh_type')=='1'){
			//$mr_to=array('govindarajulu@enersys.co.in','chandra@enersys.co.in','ravikanthp@enersys.co.in','anandak@enersys.co.in','varaprasad@enersys.co.in','sivakumar.p@enersys.co.in','sudhakararaju@enersys.co.in','madan@enersys.co.in');
			$some_emp=array('6RKSASVPDJ','DRAAEUSYLY','6FXIYMITVD','T8EHH2HD0K','NR9MM7AOMZ','KSOG2VPKZ9','8NSGB0LGBB','SPTKCHOURA');
		}elseif(alias($from,'ec_warehouse','wh_alias','wh_type')=='1'){
			//$mr_to=array('ravikanthp@enersys.co.in','anandak@enersys.co.in','varaprasad@enersys.co.in','sivakumar.p@enersys.co.in','sudhakararaju@enersys.co.in','madan@enersys.co.in');
			$some_emp=array('6FXIYMITVD','T8EHH2HD0K','NR9MM7AOMZ','KSOG2VPKZ9','8NSGB0LGBB','SPTKCHOURA');
		}
		$all_emp=array_merge($some_emp,$nhs_m);
		$emp_arr=array_filter(array_unique($all_emp));
	}elseif($type_ref=='5'){ //Outward
		$from=alias($material_alias,'ec_material_outward','alias','from_wh');
		$to=alias($material_alias,'ec_material_outward','alias','to_wh');
		$res_eng=alias($material_alias,'ec_material_outward','alias','resp_engineer');
		$some_emp=array();$all_emp=array();$nhs_m=array();
		$n_z_onrs_sql=mysqli_query($mr_con,"SELECT GROUP_CONCAT(employee_alias) AS emp_n  FROM ec_employee_master WHERE (privilege_alias IN ('WIMYJFDJPT','5KPS8Q0ZNB') OR (".sub_query($from,$to)." privilege_alias='OX5E3EMI0U')) AND flag=0 AND status='WORKING'");//nhs, zhs, onrol se
		$nhs_row=mysqli_fetch_array($n_z_onrs_sql);$nhs_m=explode(",",$nhs_row['emp_n']);
		if(alias($to,'ec_warehouse','wh_alias','wh_type')=='1'){
			//$mr_to=array('fieldasset@enersys.co.in','govindarajulu@enersys.co.in','chandra@enersys.co.in','Ravikanthp@enersys.co.in','rambhupal@enersys.co.in','anandak@enersys.co.in','varaprasad@enersys.co.in','sivakumar.p@enersys.co.in','sudhakararaju@enersys.co.in','madan@enersys.co.in');
			$some_emp=array('6RKSASVPDJ','DRAAEUSYLY','6FXIYMITVD','QNMIHK3B8V','T8EHH2HD0K','NR9MM7AOMZ','KSOG2VPKZ9','8NSGB0LGBB','SPTKCHOURA','LEL6OD13N2');
		}elseif(alias($from,'ec_warehouse','wh_alias','wh_type')=='1'){
			//$mr_cc=array('fieldasset@enersys.co.in','anandak@enersys.co.in','varaprasad@enersys.co.in','sivakumar.p@enersys.co.in','sudhakararaju@enersys.co.in','madan@enersys.co.in','chandra@enersys.co.in','Ravikanthp@enersys.co.in','neeraj@enersys.co.in');
			$some_emp=array('T8EHH2HD0K','NR9MM7AOMZ','KSOG2VPKZ9','8NSGB0LGBB','SPTKCHOURA','DRAAEUSYLY','6FXIYMITVD','LEL6OD13N2','ENVHMNCXOV');
		}$all_emp=array_merge($some_emp,$nhs_m);
		array_push($all_emp,$res_eng);
		$emp_arr=array_filter(array_unique($all_emp));
	}elseif($type_ref=='7' || $type_ref=='8'){
		$tb=($type_ref=='7' ? "ec_material_revival" : "ec_material_refreshing");
		$rvQuery=mysqli_query($mr_con,"SELECT wh_alias FROM $tb WHERE item_alias='$material_alias' AND flag=0 GROUP BY item_alias");
		if(mysqli_num_rows($rvQuery)>'0'){ $rvRow=mysqli_fetch_array($rvQuery);
			$n_z_onrs_sql=mysqli_query($mr_con,"SELECT GROUP_CONCAT(employee_alias) AS emp_n FROM ec_employee_master WHERE wh_alias LIKE '%".$rvRow['wh_alias']."%' AND flag=0 AND status='WORKING'");
			$nhs_row=mysqli_fetch_array($n_z_onrs_sql);
			$emp_arr=array_unique(array_filter(explode(",",$nhs_row['emp_n'])));
		}
	}array_push($emp_arr,"ADMIN");
	//return implode("<br>",$emp_arr);
	$emp_arr=array_unique(array_filter(array_merge($emp_arr,admin_privilege_get_emp_priv("E"))));
	if(count($emp_arr)){
		$notif_alias=aliasCheck(generateRandomString(),'ec_notifications','notif_alias');
		foreach($emp_arr as $employee_alias){
			$sql=mysqli_query($mr_con,"INSERT INTO ec_notifications(employee_alias,title_ticket,msg_stage,type_ref,notif_alias) VALUES('$employee_alias','$material_alias','$msg','$type_ref','$notif_alias')");
			//if($sql){$reg_id = alias($employee_alias,'ec_employee_master','employee_alias','reg_id');notification($reg_id,$msg);	}
		}
	}
}
function sub_query($from_wh,$to_wh){ global $mr_con;
	$conn=($from_wh=="NAA" ? "wh_alias IN ('".implode("','",$to_wh)."')" : "(wh_alias='$from_wh' OR wh_alias='$to_wh')");
	$sub_query=mysqli_query($mr_con,"SELECT COUNT(id) AS num,GROUP_CONCAT(state_alias SEPARATOR '|') AS alias  FROM ec_warehouse WHERE $conn AND flag='0'");
	$sub_row=mysqli_fetch_array($sub_query);
	return ($sub_row['num'] ? "state_alias RLIKE('".$sub_row['alias']."') AND" : "state_alias IN('') AND");
}
function getproduct_accessoryalias($vvvv=""){ global $mr_con;
	if($vvvv!=""){
		$siteCondition = "accessory_description LIKE '%$vvvv%' AND ";
		$siteCondition1 = "product_description LIKE '%$vvvv%' AND ";
	}else{$siteCondition=$siteCondition1="";}
	$sql=mysqli_query($mr_con,"SELECT accessories_alias as alias FROM ec_accessories WHERE $siteCondition flag=0 UNION SELECT product_alias as alias FROM ec_product WHERE $siteCondition1 flag=0");
	if(mysqli_num_rows($sql)){
		while($row=mysqli_fetch_array($sql)){
			$dcd[]=$row['alias'];
		}
		$tre="'".implode("','",$dcd)."'";
		return $tre;
	}else{return 0;}
}
function sitestatus($cust,$svdate,$idate){ global $mr_con;
	if($cust==""){$left='CHOOSE CUSTOMER';$months='0';$status='CHOOSE CUSTOMER';}
	//elseif($svdate=="NA" && $idate=="NA"){$left='NOT GIVEN';$months='0';$status='NOT GIVEN';}
	elseif($svdate=="NA"){$left='CHOOSE SALE INVOICE DATE';$months='0';$status='CHOOSE SALE INVOICE DATE';}
	else{
		//if($svdate!="NA"){
			$date1 = new DateTime($svdate);
			$date2 = new DateTime(date("Y-m-d"));
			$warrantyd1 = $date2->diff($date1)->format("%a");
		//}else{$warrantyd1 = "NA";}
		if($idate!="NA"){
			$date1 = new DateTime($idate);
			$date2 = new DateTime(date("Y-m-d"));
			$warrantyd2 = $date2->diff($date1)->format("%a");
		}else{$warrantyd2 = "NA";}
		$sql=mysqli_query($mr_con,"SELECT dispatch,installation,schedule FROM ec_customer WHERE customer_alias='$cust' AND flag=0");
		if(mysqli_num_rows($sql)){
			$row=mysqli_fetch_array($sql);
			$result['schedule']=$row["schedule"];
			$dispatch=$row["dispatch"]*30;
			$installation=$row["installation"]*30;
			if($row["dispatch"]==0){$warrantyd1 = "NA";}
			if($row["installation"]==0){$warrantyd2 = "NA";}
			if($warrantyd1 != "NA"){$tempw1=$dispatch-$warrantyd1;$na1="";}else{$tempw1=0;$na1="NA";}
			if($warrantyd2 != "NA"){$tempw2=$installation-$warrantyd2;$na2="";}else{$tempw2=0;$na2="NA";}
			if($na1=="NA"){ $months=$row["installation"];
				if($tempw2 <= 0){$left="OUT OF WARRANTY"; $status="OUT OF WARRANTY";}
				else{ $left=warr($tempw2); $status="UNDER WARRANTY"; }
			}elseif($na2=="NA"){ $months=$row["dispatch"];
				if($tempw1 <= 0){ $left="OUT OF WARRANTY"; $status="OUT OF WARRANTY";}
				else{ $left=warr($tempw1); $status="UNDER WARRANTY"; }
			}else{
				if($tempw1 <= 0 || $tempw2 <= 0){
					if($tempw1 < $tempw2){ $months=$row["dispatch"];}else{$months=$row["installation"];}
					$left="OUT OF WARRANTY"; $status="OUT OF WARRANTY";
				}elseif($tempw1 > $tempw2){
					$months=$row["installation"];
					$left=warr($tempw2); $status="UNDER WARRANTY";
				}else{// $tempw1 < $tempw2 OR $tempw1 == $tempw2
					$months=$row["dispatch"];
					$left=warr($tempw1); $status="UNDER WARRANTY";
				}
			}
		}else{$left='OUT OF WARRANTY'; $months='0'; $status="OUT OF WARRANTY";}
	}
	$result['warrantyleft'] = $left;
	$result['warrantymonths'] = $months;
	$result['warrantystatus'] = $status;
 return $result;
}
function warr($xyz){
	$f = round($xyz/30);
	$p = ($xyz%30);
	if($f!=0){$abc = $f." Months ";}else{$abc = "";}
	if($p!=0){$abc .= $p." Days";}
	return $abc;//$f." Months";
}

function el_experience($j_date, $rDate = "") {
	if(!empty($j_date) && $j_date!='0000-00-00'){
		$date1 = new DateTime($j_date);
		$date2 = new DateTime(date('Y-m-d'));
		if ($rDate != "" && $rDate != "0000-00-00") {
			$date2 = new DateTime($rDate);
		}
		return $diff = $date2->diff($date1)->format("%y Years, %m Months , %d Days");
	}else return '-';
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
function get_string_between($string, $start, $end){
    $string = " ".$string;
    $ini = strpos($string,$start);
    if ($ini == 0) return "";
    $ini += strlen($start);
    $len = strpos($string,$end,$ini) - $ini;
    return substr($string,$ini,$len);
}
function getAddress($lat,$lng) {
	$key_arr=['AIzaSyCF82XXUtT0vzMTcEPpTXvKQPr1keMNr_4','AIzaSyAYPw6oFHktAMhQqp34PptnkDEdmXwC3s0','AIzaSyAwd0OLvubYtKkEWwMe4Fe0DQpauX0pzlk','AIzaSyDF3F09RkYcibDuTFaINrWFBOG7ilCsVL0','AIzaSyC1dyD2kzPmZPmM4-oGYnIH_0x--0hVSY8'];
	$key_arr = ['AIzaSyAaUYGCjfKVFX6iDfP8uFG7yGzM7nr47Mc'];
	$address = "";
	foreach($key_arr as $key) {
		$data = json_decode(@file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&sensor=false&key=$key"));
		if($data->status == "OK"){
			$address = $data->results[0]->formatted_address;
			continue;
		}
		elseif($data->status == "ZERO_RESULTS"){
			continue;
		}
	}
	return $address;
}
function getoneremark_all($fv1,$fv2){global $mr_con;
	$rq2="SELECT remarks FROM ec_remarks WHERE module='".$fv2."' AND item_alias='".$fv1."'";
	$rb=mysqli_query($mr_con,$rq2);
	if(mysqli_num_rows($rb)){
		$rbb=mysqli_fetch_array($rb);
		return $rbb['remarks'];
	}else return '';
}

function send_mail($ticket_alias,$mail_id){
	global $mr_con; //global $bccemail;
	date_default_timezone_set("Asia/Kolkata");
	$site_alias = alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
	$ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
	if(!empty($mail_id) && filter_var($mail_id, FILTER_VALIDATE_EMAIL)){
		$sub = "Ticket Details - ".$ticket_id." - ".date("d-m-Y");
		$sqlTT = mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE ticket_alias='$ticket_alias' AND flag='0'");
		if(mysqli_num_rows($sqlTT)>0){
			$rowTT=mysqli_fetch_array($sqlTT);
			$head=array("Ticket ID","Login Date");
			$content[]=$rowTT['ticket_id'];
			$content[]=($rowTT['login_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['login_date']))));
			if($rowTT['planned_date']!="" && $rowTT['planned_date']!='0000-00-00'){array_push($head,"Planned Date");$content[]=date("d-m-Y", strtotime(mysqli_real_escape_string($mr_con,$rowTT['planned_date'])));}
			$head1=array("Activity","Zone","State","District","Site ID","Site Name","Site Type","Product");
			$head2=array_merge($head,$head1);
			$content[]=alias($rowTT['activity_alias'],'ec_activity','activity_alias','activity_name');
			$sqlSite = mysqli_query($mr_con,"SELECT * FROM ec_sitemaster WHERE site_alias='$site_alias' AND flag=0");
			if(mysqli_num_rows($sqlSite)){
				$ticket_alias = alias($ticket_id,'ec_tickets','ticket_id','ticket_alias');
				$rowSite = mysqli_fetch_array($sqlSite);
				$content[]=alias($rowSite['zone_alias'],'ec_zone','zone_alias','zone_name');
				$content[]=alias($rowSite['state_alias'],'ec_state','state_alias','state_name');
				$content[]=alias($rowSite['district_alias'],'ec_district','district_alias','district_name');
				$content[]=$rowSite['site_id'];
				$content[]=$rowSite['site_name'];
				$content[]=alias($rowSite['site_type_alias'],'ec_site_type','site_type_alias','site_type');
			
				$product = explode(", ",$rowSite['product_alias']);
				foreach($product as $pro){ $xx .= alias($pro,'ec_product','product_alias','product_description').", "; }
				$content[]=trim($xx,", ");
				
				if(!empty($rowSite['battery_bank_rating'])){array_push($head2,"Battery Bank Rating");$content[]=$rowSite['battery_bank_rating'];}
				$head3=array("No Of Strings","Segment","Customer Name","Manufacturing Date","Installation Date","First Level Contact Name","First Level Contact Number","Second Level Contact Name","Second Level Contact Number","Second Level Contact email","Site Address","MOC");
				$head4=array_merge($head2,$head3);
				$content[]=$rowSite['no_of_string'];
				$content[]=alias($rowSite['segment_alias'],'ec_segment','segment_alias','segment_name');
				$content[]=alias($rowSite['customer_alias'],'ec_customer','customer_alias','customer_name');
				$content[]=dateFormat($rowSite['mfd_date'],'d');
				$content[]=dateFormat($rowSite['install_date'],'d');
				$content[]=$rowSite['technician_name'];
				$content[]=$rowSite['technician_number'];
				$content[]=$rowSite['manager_name'];
				$content[]=$rowSite['manager_number'];
				$content[]=$rowSite['manager_mail'];
				$content[]=$rowSite['site_address'];
			}
			$content[]=$rowTT['mode_of_contact'];
			if(!empty($rowTT['service_engineer_alias'])){array_push($head4,"Service Engineer");$content[]=alias($rowTT['service_engineer_alias'],'ec_employee_master','employee_alias','name');}
			if(!empty($rowTT['milestone'])){array_push($head4,"Milestone");$content[]=alias($rowTT['milestone'],'ec_milestone','mile_stone_alais','mile_stone');}
			if(!empty($rowTT['efsr_no'])){array_push($head4,"efsr No");$content[]=$rowTT['efsr_no'];}
			if(!empty($rowTT['efsr_date'])){array_push($head4,"efsr Date");$content[]=$rowTT['efsr_date'];}
			if($rowTT['closing_date']!="" && $rowTT['level']>5){array_push($head4,"Closing Date");$content[]=date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['closing_date'])));}
			$head5=array("Ticket Status","Site Status","Faulty Cell Count","Complete Observation");
			$head6=array_merge($head4,$head5);
			$content[]=$rowTT['status'];
			$content[]=($rowTT['warranty']>0 ? 'UNDER WARRANTY' : 'OUT OF WARRANTY');
			$content[]=$rowTT['faulty_cell_count'];
			$content[]=$rowTT['description'];
			if($rowTT['level']>5){array_push($head6,"TAT");$content[]=tat($ticket_alias);}
			$head7=array("Complaint","Level");
			$head8=array_merge($head6,$head7);
			$content[]=alias($rowTT['complaint_alias'],'ec_complaint','complaint_alias','complaint_name');
			$content[]=alias($rowTT['level'],'ec_levels','level_alias','level_name');
			$remsql=mysqli_query($mr_con,"SELECT remarks FROM ec_remarks WHERE id IN (SELECT MAX(id) FROM ec_remarks WHERE module='TT' AND item_alias='$ticket_alias' AND flag='0') AND flag='0'");
			$remrow=mysqli_fetch_array($remsql);
			if(!empty($remrow['remarks'])){array_push($head8,"Remarks");$content[]=strtoupper($remrow['remarks']);}
		}
		$body="<p>Dear $mail_id,</p>";
		$body.="<p>Below are the Ticket Details.</p>";
		$body.="<h3 style='background:#2a6496;color:#FFF;padding:0 5px;line-height:30px;font-size:16px;'>Ticket Details</h3>";
		$body.="<table style='border-collapse:collapse;width:100%;'>";
		$c=count($head8);
		for($a=0;$a<$c;$a++){
			$body.="<tr>";
			for($b=$a;$b<=($a+1);$b++){
				$body.="<td style='padding:2px 5px;text-align:justify;border:1px solid #000;'>
				<h4 style='display:block;color:#2a6496;font-weight:bold; margin:0;padding:2px;'>".ucfirst($head8[$b])."</h4>
				<p style='display:block;margin:0;padding:1px;'>".ucfirst($content[$b])."</p>
				</td>";
			}
			$a++;
			$body.="</tr>";
		}
		$body.="</table><br>";
		$esca_efsr_link = alias($ticket_alias,'ec_tickets','ticket_alias','esca_efsr_link');
		$efsr_ = alias($ticket_alias,'ec_tickets','ticket_alias','esca_efsr_link');
		if(!empty($esca_efsr_link) && $esca_efsr_link!='NA'){ $link = "images/esca_efsr/".$esca_efsr_link; $efsr='0';}
		elseif(!empty($rowTT['efsr_no'])){$link = "mobile_app/pdf/index.php?ticket_alias=".$ticket_alias; $efsr='1';}
		else{$link = ""; $efsr='0';}
		if(!empty($link))$body.="<p>For details please go through the ".($efsr ? 'e-' : '')."FSR Enclosed <a href='".baseurl().$link."' target='_blank'>Click here</a></p>";
		$body.="<p>If you have any concerns please feel free to write us to service@enersys.co.in or Call us at 040-6704 6704</p>";
		$body.="<p style='font-style:italic;font-size:12px;'>*** This is a System generated email, Please do not reply ***</p>";
		
		$from=all_from_mail();
		$headers="From: EnerSys Care <$from> \r\n";
		$headers.="Reply-To: $from \r\n";
		$headers.="Return-Path: $from \r\n";
		$headers.= "CC: ticket@enersys.co.in \r\n";
		//$headers .= "BCC: $bccemail \r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$abc = mail($mail_id,$sub,$body,$headers);
		if($abc)return TRUE;
		else return FALSE;
	}else return FALSE;
}
function mail_relieved_filter($to_cc_mail){ global $mr_con;
	if(!empty($to_cc_mail)){
		$to_cc_sql = mysqli_fetch_array(mysqli_query($mr_con,"SELECT GROUP_CONCAT(email_id) AS email FROM ec_employee_master WHERE email_id IN('".str_replace(",","','",str_replace(" ","",$to_cc_mail))."') AND status='WORKING' AND flag='0'"));
		return (empty($to_cc_sql['email']) ? 'service@enersys.co.in' : $to_cc_sql['email']);
	}else return 'service@enersys.co.in';
}
function all_mail_code($to_cc_mail_arr,$sub,$body,$tt_mrf_alias,$ref,$tt_fam){ global $mr_con;
	if($tt_fam=="TT"){$default_mail = "ticket@enersys.co.in";$from_lable = "Care";}else{$default_mail = "fieldasset@enersys.co.in";$from_lable = "Inventory";}
	foreach($to_cc_mail_arr as $k=>$to_cc_mail){
		if(is_array($to_cc_mail) && count($to_cc_mail)){
			$to_cc_sql = mysqli_fetch_array(mysqli_query($mr_con,"SELECT GROUP_CONCAT(email_id) AS email FROM ec_employee_master WHERE email_id IN('".implode("','",$to_cc_mail)."') AND status='WORKING' AND flag='0'"));
			if(empty($k))$to_mail = (empty($to_cc_sql['email']) ? $default_mail : $to_cc_sql['email']);
			else $cc_mail = (empty($to_cc_sql['email']) ? $default_mail : $to_cc_sql['email'].",".$default_mail);
		}else $to_mail = $cc_mail = $default_mail;
	}
	$from=all_from_mail();
	$headers="From: EnerSys $from_lable <$from>\r\n";
	$headers.="Reply-To: $from\r\n";
	$headers.="Return-Path: $from\r\n";
	$headers .= "CC: $cc_mail \r\n";
	//$headers .= "BCC: $bcc_mail \r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$abc = mail($to_mail,$sub,$body,$headers);
	if($abc)success_mail_log($tt_mrf_alias,$ref);
	else pending_mail_log($tt_mrf_alias,$ref);
}
function sms_contacts($ref_alias,$ref_arr,$ref=""){ global $mr_con;
	$contacts_arr=array();
	if(gettype($ref_arr)=='array'){
		foreach($ref_arr as $sub_ref){
			if($sub_ref=="CUST")array_push($contacts_arr,alias($ref_alias,'ec_material_request','mrf_alias','customer_phone'));
			elseif($sub_ref=="SE"){
				$ticket_alias=(empty($ref) ? alias($ref_alias,'ec_material_request','mrf_alias','ticket_alias') : alias($ref_alias,'ec_material_outward','sjo_number','ref_no'));
				if($ticket_alias!="2609")array_push($contacts_arr,alias(alias($ticket_alias,'ec_tickets','ticket_alias','service_engineer_alias'),'ec_employee_master','employee_alias','mobile_number'));
			}elseif($sub_ref=="ZHS"){
				$state_alias = (empty($ref) ? alias(alias($ref_alias,'ec_material_request','mrf_alias','from_wh'),'ec_warehouse','wh_alias','state_alias'): alias(alias($ref_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','state_alias'));
				$sql=mysqli_query($mr_con,"SELECT mobile_number FROM ec_employee_master WHERE state_alias LIKE '%$state_alias%' AND privilege_alias='OX5E3EMI0U' AND flag='0'");
				if(mysqli_num_rows($sql))while($row=mysqli_fetch_array($sql))array_push($contacts_arr,$row['mobile_number']);
			}elseif($sub_ref=="NHS")array_push($contacts_arr,alias('WIMYJFDJPT','ec_employee_master','privilege_alias','mobile_number'));
			elseif($sub_ref=="TS"){
				$sql1=mysqli_query($mr_con,"SELECT privilege_alias FROM ec_privileges WHERE privilege_item='TICKETS' AND privilege_type='TS' AND grantable='1' AND flag='0' GROUP BY privilege_alias");
				if(mysqli_num_rows($sql1))while($row1 = mysqli_fetch_array($sql1))$contacts_arr=mul_priv_contact($contacts_arr,$row1['privilege_alias']);
			}elseif($sub_ref=="HO")$contacts_arr=mul_priv_contact($contacts_arr,'5KPS8Q0ZNB');
			elseif($sub_ref=="PPC")$contacts_arr=mul_priv_contact($contacts_arr,'8BSTDFFQEP');
			elseif($sub_ref=="STORES")$contacts_arr=mul_priv_contact($contacts_arr,'OKNEQ3IPOBOYI9FOUN8O');
			elseif($sub_ref=="QUALITY")$contacts_arr=mul_priv_contact($contacts_arr,'DWH4PLGSLK');
			elseif($sub_ref=="LOGISTICS")$contacts_arr=mul_priv_contact($contacts_arr,'GM5I41RNLO');
			elseif($sub_ref=="FC")$contacts_arr=mul_priv_contact($contacts_arr,'1WQ94CRGJM');
			elseif($sub_ref=="INVOICE")$contacts_arr=mul_priv_contact($contacts_arr,'BWIHQNHG8F');
			else array_push($contacts_arr,"8341664365");
		}
	}return $contacts_arr;
}
function mul_priv_contact($contacts_arr,$privilege_alias){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT mobile_number FROM ec_employee_master WHERE privilege_alias='$privilege_alias' AND mobile_number<>'7730090760' AND flag='0'");
	if(mysqli_num_rows($sql)){
		while($row=mysqli_fetch_array($sql))
			array_push($contacts_arr,$row['mobile_number']);
	}return $contacts_arr;
}

function mul_priv_mails($privilege_alias, $state) { 
	global $mr_con;
	$q = "SELECT email_id FROM ec_employee_master WHERE privilege_alias = '$privilege_alias' AND flag='0'";
	if($state != 'all') {
		$q .= " AND state_alias like '%$state%' ";
	}
	$sql=mysqli_query($mr_con, $q);
	$mails = [];
	if(mysqli_num_rows($sql)){
		while($row=mysqli_fetch_array($sql))
			$mails[] = $row['email_id'];
	}
	return $mails;
}

function request_desc_sms($mrf_alias,$ref=""){ global $mr_con;
	if(!empty($ref)&& $ref=="OUT"){
		$sql=mysqli_query($mr_con,"SELECT ref_no FROM ec_material_outward WHERE from_type='1' AND sjo_number='$mrf_alias' AND flag='0'");
		if(mysqli_num_rows($sql)){$row1=mysqli_fetch_array($sql);$ticket_alias =$row1['ref_no'];}
	}else $ticket_alias = alias($mrf_alias,'ec_material_request','mrf_alias','ticket_alias');
	$ticket_id=($ticket_alias!='2609' && !empty($ticket_alias) ? alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id'):"BUFFER");
	$sql3 = mysqli_query($mr_con,"SELECT item_type,item_description,quantity FROM ec_request_items WHERE mrf_alias='$mrf_alias' AND flag='0'");
	if(mysqli_num_rows($sql3)){ $item_desc="";
		while($row3=mysqli_fetch_array($sql3)){
			if($row3['item_type']=='1')$item_desc.=alias($row3['item_description'],'ec_product','product_alias','product_description').($ref!="CUST" ? " - ".$row3['quantity']." Cells, ":"");
			else $item_desc.=alias($row3['item_description'],'ec_accessories','accessories_alias','accessory_description').($ref!="CUST" ? " - ".$row3['quantity']." Accessories, ":"");
		}
		return $ticket_id."_@".rtrim($item_desc,",");
	}else return $ticket_id."_@ NA";
}
function mul_dynamic($emp_alias){ 
	global $mr_con;
	$query = "SELECT t2.id FROM ec_dynamic_levels t1 INNER JOIN ec_employee_master t2 ON t1.privilege_alias=t2.privilege_alias WHERE t1.grantable='1' AND t2.employee_alias='$emp_alias' AND t2.privilege_alias IN(SELECT privilege_alias FROM ec_privileges WHERE privilege_item='MATERIAL REQUEST' AND privilege_type='SPECIAL' AND grantable='1' AND flag='0' GROUP BY privilege_alias) AND t2.flag='0'";
	$sqlt=mysqli_query($mr_con, $query);
	if(mysqli_num_rows($sqlt)>'0'){
		$query = "SELECT mrf_alias FROM ec_material_request WHERE status IN('1','7') AND flag='0'";
		$sqlr=mysqli_query($mr_con, $query);
		if(mysqli_num_rows($sqlr)>'0'){ $mrf_alias=array();
			while($rowr = mysqli_fetch_array($sqlr)){
				$tem_alias = next_dynamic($rowr['mrf_alias'],'E');
				if(!empty($tem_alias) && strpos($tem_alias,$emp_alias)!==false) $mrf_alias[]=$rowr['mrf_alias'];
			}if(count($mrf_alias)>'0')return implode("','",$mrf_alias);else return NULL;
		}else return NULL;
	}else return 'NA';
}
function transit_damaged($transit_damaged){
	if($transit_damaged==1)return "Yes";
	elseif($transit_damaged==0)return "No";
	else return "NA";
}
function amount_range($amount_range){
	if($amount_range==1)return "<= 59,999";
	elseif($amount_range==2)return ">= 60,000";
	else return "NA";
}
function next_dynamic($mrf_alias,$ref,$l=""){ global $mr_con;
	$status=alias($mrf_alias,'ec_material_request','mrf_alias','status');
	if(!empty($status) && ($status=='1' || $status=='7' || $status=='10')){
		$transit_damaged=alias($mrf_alias,'ec_material_request','mrf_alias','transit_damaged');
		$ticket_alias = alias($mrf_alias,'ec_material_request','mrf_alias','ticket_alias');
		if($ticket_alias=='2609')$segment_alias=alias(alias($mrf_alias,'ec_material_request','mrf_alias','customer_alias'),'ec_customer','customer_alias','segment_alias');
		else $segment_alias=alias(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','segment_alias');
		$sql2=mysqli_query($mr_con,"SELECT id FROM ec_request_items WHERE mrf_alias='$mrf_alias' AND item_type='1' AND cell_type='2' AND flag='0'");
		$sql3=mysqli_query($mr_con,"SELECT id FROM ec_request_items WHERE mrf_alias='$mrf_alias' AND item_type='1' AND flag='0'");
		if($segment_alias=='YGRKJJD4N7' || $transit_damaged=='1' || mysqli_num_rows($sql2) || mysqli_num_rows($sql3)=='0')
			$newrv="";
		else 
			$newrv="";
		$con = "t2.privilege_alias IN(SELECT privilege_alias FROM ec_privileges WHERE privilege_item='MATERIAL REQUEST' AND privilege_type='SPECIAL' AND grantable='1' AND flag='0' GROUP BY privilege_alias) AND ";
		$sql=mysqli_query($mr_con,"SELECT GROUP_CONCAT(t1.privilege_alias) AS priv,GROUP_CONCAT(t2.employee_alias) AS empl FROM ec_dynamic_levels t1 
		  INNER JOIN ec_employee_master t2 ON t1.privilege_alias=t2.privilege_alias
		  WHERE t1.grantable='1' AND $con $newrv t2.flag='0' GROUP BY t1.order_by ORDER BY t1.order_by DESC");
		$count=mysqli_num_rows($sql);
		if($count){ $i='0';
			$status=alias($mrf_alias,'ec_material_request','mrf_alias','status');
			$con1 = ($status=='1' ? "bucket IN('21','22')":"bucket='20'")." AND";
			while($row = mysqli_fetch_array($sql)){ $i++;
				$ref_alias = ($ref=='E' ? $row['empl'] : $row['priv']);
				$sql1=mysqli_query($mr_con,"SELECT COUNT(id) AS count,GROUP_CONCAT(DISTINCT bucket) as g_bucket FROM ec_remarks WHERE remark_alias IN('".str_replace(",","','",$row['priv'])."') AND item_alias='$mrf_alias' AND module='MR' AND $con1 flag='0'");
				$row1 = mysqli_fetch_array($sql1);
				if($row1['count']>'0'){
					$g_bucket=$row1['g_bucket'];
					if(strpos($g_bucket,'21')!==false){ //21 APPROVED
						if($i=='1') return NULL; else return (empty($l) ? "":($i>'2' ? "R_":"L_")).$priv_empl;
					}elseif(strpos($g_bucket,'20')!==false || strpos($g_bucket,'22')!==false){ //20 HOLD //22 REJECTED
						return (empty($l) ? "":($i>'1' ? "R_":"L_")).$ref_alias;
					}else return NULL;
				}else{ $priv_empl = $ref_alias; if($i==$count)return (empty($l) ? "":($count>'1' ? "R_":"L_")).$ref_alias;}
			}
		}else return NULL;
	}else return NULL;
}
function j_getticketID($fv1){ global $mr_con;
	if($fv1!='0' && $fv1!=""){
		$ticket_id_temp=array();
		$tick_alias=cleanitemcodes($fv1);
		$sql2 = mysqli_query($mr_con,"SELECT ticket_id FROM ec_tickets WHERE ticket_alias IN ($tick_alias) AND flag=0");
		if(mysqli_num_rows($sql2)){
			while($row2=mysqli_fetch_array($sql2)){
				$ticket_id_temp[]=strtok($row2['ticket_id'],"|");
			}return implode(", ",$ticket_id_temp);
		}else return ($fv1=='2609' ? 'BUFFER' : 0);
	}else return 0;
}
function cleanitemcodes($fv1){
	$a1=explode(", ",$fv1);
	if(count($a1)>0){
		for($x=0;$x<count($a1);$x++){
			$a2[$x]=preg_replace('/\|.*/', '', $a1[$x]);
		}
		return "'".implode("','",$a2)."'";
	}else return "";
}
function getitemtype($fv1){
	if($fv1=="1") return "CELLS";
	elseif($fv1=="2")return "ACCESSORIES";
	else return "NA";
}
function getitemname($fv1,$fv2){
	if($fv1=="1" || $fv1=="CELLS") $res=alias($fv2,'ec_product','product_alias','product_description');
	elseif($fv1=="2" || $fv1=="ACCESSORIES")$res=preg_replace("~\x{00a0}~siu"," ",alias($fv2,'ec_accessories','accessories_alias','accessory_description'));
	else $res="";
	return (empty($res) ? "NA" : $res);
}
function get_cell_type($cell_type){
	if($cell_type=="1")$res="NEW";elseif($cell_type=="NEW")$res="1";
	elseif($cell_type=="2")$res="REVIVED";elseif($cell_type=="REVIVED")$res="2";
	else $res="";
	return (empty($res) ? "NA" : $res);
}
function get_road_permit($road_permit){
	if($road_permit=="1")$res="REQUIRED";elseif($road_permit=="REQUIRED")$res="1";
	elseif($road_permit=="0")$res="NOT REQUIRED";elseif($road_permit=="NOT REQUIRED")$res="0";
	else $res="";
	return (empty($res) ? "NA" : $res);
}
function outward_nm_clr($status,$ref){
	return ($ref=='name' ? alias($status,'ec_inventory_levels','level_alias','level_name') : alias($status,'ec_inventory_levels','level_alias','level_color'));
}
function current_location($stage,$location_type,$location){
	if($stage=='1')return "UNDER TRANSIT";
	elseif($location_type=='0')return "FACTORY";
	elseif($location_type=='1')return alias($location,'ec_warehouse','wh_alias','wh_code');
	elseif($location_type=='2')return alias($location,'ec_sitemaster','site_alias','site_name');
	elseif($location_type=='3')return "CUSTOMER BUFFER";
	else return "NA";
}
function outward_lvl_update($cell_arr,$out,$in){ global $mr_con;
	$cells_alias = implode("','",$cell_arr);
	$sql=mysqli_query($mr_con,"SELECT GROUP_CONCAT(DISTINCT '''',t1.alias,'''') AS alia FROM ec_material_outward t1 INNER JOIN ec_material_sent_details t2 ON t1.alias=t2.reference WHERE t1.from_type='$out' AND t2.item_description IN('$cells_alias') AND t1.flag='0'");
	if(mysqli_num_rows($sql)){ $row=mysqli_fetch_array($sql);
		$sql_out=mysqli_query($mr_con,"SELECT COUNT(t2.id) AS cnt_out,GROUP_CONCAT(DISTINCT t2.item_description) AS item_desc,t1.alias FROM ec_material_outward t1 INNER JOIN ec_material_sent_details t2 ON t1.alias=t2.reference WHERE t1.alias IN(".$row['alia'].") AND t1.flag='0' GROUP BY t1.alias");
		if(mysqli_num_rows($sql_out)){
			while($row_out=mysqli_fetch_array($sql_out)){ $out_arr=$in_arr=array();
				if($row_out['cnt_out']>'0'){
					$out_arr=explode(",",$row_out['item_desc']);$out_alias=$row_out['alias'];
					$sql_in=mysqli_query($mr_con,"SELECT COUNT(t2.id) AS cnt_in,GROUP_CONCAT(DISTINCT t2.item_description) AS item_desc FROM ec_material_inward t1 INNER JOIN ec_material_received_details t2 ON t1.alias=t2.reference WHERE t1.from_type='$in' AND t2.item_description IN('".implode("','",$out_arr)."') AND t1.flag='0'");
					$row_in=mysqli_fetch_array($sql_in);
					if($row_in['cnt_in']>'0')$in_arr=explode(",",$row_in['item_desc']);
					if(count($out_arr)>'0' && count($in_arr)=='0')$status='4';else $status = (count(array_diff($out_arr,$in_arr))=='0' ? '6' : '0');
					$sql1=mysqli_query($mr_con,"UPDATE ec_material_outward SET status='$status' WHERE from_type='$out' AND alias='$out_alias' AND flag='0'");
				}
			}
		}else $sql1=FALSE;
	}else $sql1=FALSE;
	return ($sql1 ? TRUE:FALSE);
}
function fam_lvl_nm_clr($status,$ref,$mrf_alias,$readiness_date=""){
	date_default_timezone_set("Asia/Kolkata");
	if(($status=='1' || $status=='7') && !empty($mrf_alias)) {
		$privilege_aliass=next_dynamic($mrf_alias,'P');
		if(strpos($privilege_aliass,",")!==false){
			list($privilege1,$privilege2)=explode(",",$privilege_aliass);
			if($ref=='name')$result = aliasFlag0($privilege1,'ec_dynamic_levels','privilege_alias','level_name').($status=='1' ? ' PENDING':' HOLD');
			else $result = aliasFlag0($privilege1,'ec_dynamic_levels','privilege_alias','level_color');
		} else {
			$result = ($ref=='name' ? aliasFlag0($privilege_aliass,'ec_dynamic_levels','privilege_alias','level_name').($status=='1' ? ' PENDING':' HOLD') : aliasFlag0($privilege_aliass,'ec_dynamic_levels','privilege_alias','level_color'));
		} 
	} elseif($ref=='name') {
		$result = aliasFlag0($status,'ec_inventory_levels','level_alias','level_name');
	} else {
		$result = ($status=='2' && $readiness_date < date('Y-m-d') ? aliasFlag0('6','ec_inventory_levels','level_alias','level_color') : aliasFlag0($status,'ec_inventory_levels','level_alias','level_color'));
	}
	return $result;
}
function in_m_s_t($from_type,$from_wh,$ref_no){
	if($from_type=='1'){
		$mrf_number = alias($ref_no,'ec_material_request','ticket_alias','mrf_number');
		$sjo_number = alias($ref_no,'ec_material_request','ticket_alias','sjo_number');
		$ticket_id = strtok(alias($ref_no,'ec_tickets','ticket_alias','ticket_id'),"|");
	}elseif($from_type=='2'&&$from_wh=='2609'){
		$mrf_number = alias($ref_no,'ec_material_request','mrf_alias','mrf_number');
		$sjo_number = alias($ref_no,'ec_material_request','mrf_alias','sjo_number');
		$ticket_id = 'BUFFER';
	}elseif($from_type=='2'&&$from_wh!='2609'){
		$mrf_number = '-';
		$sjo_number = '-';
		$ticket_id = '-';
	}elseif($from_type=='3'){
		$mrf_number = alias($ref_no,'ec_material_request','mrf_alias','mrf_number');
		$sjo_number = alias($ref_no,'ec_material_request','mrf_alias','sjo_number');
		$re=alias($ref_no,'ec_material_request','mrf_alias','ticket_alias');
		$ticket_id = ($re=="2609" ? "BUFFER" : strtok(alias($re,'ec_tickets','ticket_alias','ticket_id'),"|"));
	}else{
		$mrf_number = '-';
		$sjo_number = '-';
		$ticket_id = '-';
	}
	return $mrf_number."@".$sjo_number."@".$ticket_id;
}
function out_m_s_t($from_type,$to_wh,$ref_no,$sjo_num){ global $mr_con;  //1-> Wh to Site, 2-> Wh to Fact, 3-> Fact to Wh.
	if($from_type=='1')$ticket_id=($to_wh=='2609' ? "BUFFER" : strtok(alias($ref_no,'ec_tickets','ticket_alias','ticket_id'),"|"));
	elseif($from_type=='3'){
		$tt_alias = alias($sjo_num,'ec_material_request','mrf_alias','ticket_alias');
		if(!empty($tt_alias))$ticket_id= ($tt_alias=='2609' ? "BUFFER" : strtok(alias($tt_alias,'ec_tickets','ticket_alias','ticket_id'),"|"));
		else $ticket_id="-";
	}else $ticket_id="-";
	if(!empty($sjo_num)){
		$mrf_number = alias($sjo_num,'ec_material_request','mrf_alias','mrf_number');
		$sjo_number = alias($sjo_num,'ec_material_request','mrf_alias','sjo_number');
	}else $mrf_number=$sjo_number='NON SJO';
	return $mrf_number."@".$sjo_number."@".$ticket_id;
}
// start - expense traker
function alreadyexist($fv1,$fv2,$fv3){global $mr_con;
	$rec=$mr_con->query("SELECT id FROM $fv2 WHERE $fv3='$fv1'");
	if($rec->num_rows==0)return 0; else return 1;
}
// For Tickets starts
function all_remarks($ticket_alias){ global $mr_con;
	$result['se_by']=$result['se_on']=$result['se_rem']=$result['se_buc']=$result['se_act']=$result['zhs_by']=$result['zhs_on']=$result['zhs_rem']=$result['zhs_buc']=$result['zhs_age']=$result['nhs_by']=$result['nhs_on']=$result['nhs_rem']=$result['nhs_buc']=$result['nhs_age']=$result['ts_by']=$result['ts_on']=$result['ts_rem']=$result['ts_buc']=$result['ts_age']=$result['out_by']=$result['out_on']=$result['out_rem']=$result['ai_by']=$result['ai_on']=$result['ai_rem']=$result['req_by']=$result['req_on']=$result['req_rem']=$result['plan_by']=$result['plan_on']=$result['plan_rem']=$result['admn_rem']=$result['admn_buc']=$result['admn_by']=$result['admn_on']=$result['other_by']=$result['other_on']=$result['other_buc']=$result['other_rem']=array();
	$sqlRem=mysqli_query($mr_con,"SELECT remarks,bucket,remarked_by,remarked_on FROM ec_remarks WHERE module='TT' AND item_alias='$ticket_alias' AND flag=0 ORDER BY id");
	while($rowRem = mysqli_fetch_array($sqlRem)){
		$remarked_by=(strtoupper($rowRem['remarked_by'])=='ADMIN' ? 'ADMIN' : alias_flag_none($rowRem['remarked_by'],'ec_employee_master','employee_alias','name'));
		$remarked_on = ($rowRem['remarked_on']=="0000-00-00 00:00:00" ? "" : $rowRem['remarked_on']);
		$remarks = $rowRem['remarks'];
		$bucket=$rowRem['bucket'];
		//$privilege_alias = alias_flag_none($rowRem['remarked_by'],'ec_employee_master','employee_alias','privilege_alias');
		$service_engineer_alias = alias($ticket_alias,'ec_tickets','ticket_alias','service_engineer_alias');
		if($remarked_by=='ADMIN'){
			//ADMIN
			$result['admn_by'][]=$remarked_by;
			$result['admn_on'][]=$remarked_on;
			$result['admn_buc'][]=alias($bucket,'ec_remarks_bucket','bucket_level','bucket');
			$result['admn_rem'][]=$remarks;
		}elseif($rowRem['remarked_by']==$service_engineer_alias && ($bucket=='7' || $bucket=='8')){ //FSR SUBMIT, EFSR SUBMIT
			//SE
			$result['se_by'][]=$remarked_by;
			$result['se_on'][]=$se_on=$remarked_on;
			$result['se_rem'][]=$remarks;
			$result['se_buc'][]=alias($bucket,'ec_remarks_bucket','bucket_level','bucket');
			$result['se_act'][]=alias($ticket_alias,'ec_ticket_action','ticket_alias','observation');
		}elseif($bucket=='1' || $bucket=='2' || $bucket=='9' || $bucket=='11'){ //CLOSED, DECLINED, SEND TO NHS, NEXT VISIT
			//ZHS
			$result['zhs_by'][]=$remarked_by;
			$result['zhs_on'][]=$zhs_on=$remarked_on;
			$result['zhs_rem'][]=$remarks;
			$result['zhs_buc'][]=alias($bucket,'ec_remarks_bucket','bucket_level','bucket');
			$result['zhs_age'][]=aging($se_on,$remarked_on);
		}elseif($bucket=='10' || $bucket=='37' || $bucket=='38' || $bucket=='39'){//SEND TO TS, NEXT VISIT, CLOSED, DECLINED
			//NHS
			$result['nhs_by'][]=$remarked_by;
			$result['nhs_on'][]=$nhs_on=$remarked_on;
			$result['nhs_rem'][]=$remarks;
			$result['nhs_buc'][]=alias($bucket,'ec_remarks_bucket','bucket_level','bucket');
			$result['nhs_age'][]=aging($zhs_on,$remarked_on);
		}//elseif(($privilege_alias=='OR2I0G7ZAH1CH') && ($bucket=='12' || $bucket=='13' || $bucket=='14' || $bucket=='15')){//TS APPROVED, TS REJECTED, STOCK APPROVED, STOCK REJECTED
		elseif($bucket=='12' || $bucket=='13' || $bucket=='14' || $bucket=='15'){//TS APPROVED, TS REJECTED, STOCK APPROVED, STOCK REJECTED
			//TS
			$result['ts_by'][]=$remarked_by;
			$result['ts_on'][]=$remarked_on;
			$result['ts_rem'][]=$remarks;
			$result['ts_buc'][]=alias($bucket,'ec_remarks_bucket','bucket_level','bucket');
			$result['ts_age'][]=aging($nhs_on,$remarked_on);
		}elseif($bucket=='3'){ //OUT OF WARRANTY
			$result['out_by'][]=$remarked_by;
			$result['out_on'][]=$remarked_on;
			$result['out_rem'][]=$remarks;
		}elseif($bucket=='4'){ //AT AND I&C
			$result['ai_by'][]=$remarked_by;
			$result['ai_on'][]=$remarked_on;
			$result['ai_rem'][]=$remarks;
		}elseif($bucket=='5'){ //REQUIRED CELL
			$result['req_by'][]=$remarked_by;
			$result['req_on'][]=$remarked_on;
			$result['req_rem'][]=$remarks;
		}elseif($bucket=='6'){ //RE PLANNED
			$result['plan_by'][]=$remarked_by;
			$result['plan_on'][]=$remarked_on;
			$result['plan_rem'][]=$remarks;
		}else{ //OTHER
			$result['other_by'][]=$remarked_by;
			$result['other_on'][]=$remarked_on;
			$result['other_buc'][]=alias($bucket,'ec_remarks_bucket','bucket_level','bucket');
			$result['other_rem'][]=$remarks;
		}
	}
	return $result;
}
function levelCheck($lvl){ global $mr_con;
	if($lvl=='rpl')return "t1.level='1' AND t1.purpose='1' AND ";
	elseif($lvl=='1')return "t1.level='1' AND t1.purpose='0' AND ";
	elseif($lvl=='pf')return "t1.level='2' AND t1.planned_date<'".date('Y-m-d')."' AND ";
	elseif($lvl=='2')return "t1.level='2' AND t1.planned_date>='".date('Y-m-d')."' AND ";
	elseif($lvl=='tsr')return "t1.level='4' AND t1.old_level='8' AND ";
	elseif($lvl=='4')return "t1.level='4' AND t1.old_level='3' AND ";
	else return "t1.level='$lvl' AND ";
}
function ts_approved_lvl($old_lvl){
	if($old_lvl=='3')return "ZHS NEXT VISIT";
	elseif($old_lvl=='4')return "NHS NEXT VISIT";
	else return "TS APPROVED"; //$old_lvl=='8' OR any
}
function report_sort($report){ global $mr_con;  //0->FSR; 1->e-FSR
	$sql=mysqli_query($mr_con,"SELECT GROUP_CONCAT('''',ticket_alias,'''') AS tt_alias FROM ec_tickets WHERE efsr_no<>'' AND (CASE WHEN $report = 0 THEN esca_efsr_link<>'' ELSE esca_efsr_link='' END) AND flag=0");
	$row = mysqli_fetch_array($sql);
	return $row['tt_alias'];
}
function mrs_sort($mrs){ 
	global $mr_con;
	if($mrs=='CLS' || $mrs=='ITS'){
		$ci_row = mysqli_fetch_array(mysqli_query($mr_con,"SELECT GROUP_CONCAT('''',ref_no,'''') AS tt_alias FROM ec_material_outward WHERE IF('$mrs'='CLS', status='6', status IN('4','0')) AND from_type='1' AND ref_no!='2609' AND flag='0'"));
		if(!empty($ci_row['tt_alias']))return $ci_row['tt_alias'];else return "''";
	} else if ($mrs=='INW' || $mrs=='ITF' || $mrs=='RTF') { 
		$in_row = mysqli_fetch_array(mysqli_query($mr_con,"SELECT GROUP_CONCAT('''',t1.ticket_alias,'''') AS tt_alias FROM ec_material_request t1 LEFT JOIN ec_material_outward t2 ON t1.mrf_alias=t2.sjo_number WHERE IF('$mrs'='INW' || '$mrs'='ITF', t2.from_type='3' && t2.sjo_number NOT IN(SELECT sjo_number FROM ec_material_outward WHERE from_type='1' AND flag='0') && IF('$mrs'='INW', t2.status='6', t2.status IN('4','0')), t2.status IS NULL) AND t1.ticket_alias NOT IN('','0','2609') AND t1.flag='0'"));
		if(!empty($in_row['tt_alias']))return $in_row['tt_alias'];else return "''";
	} else if ($mrs=='BLANK') {
		$ci_row = mysqli_fetch_array(mysqli_query($mr_con,"SELECT GROUP_CONCAT('''',ticket_alias,'''') AS tt_alias FROM ec_tickets WHERE flag='0' and ticket_alias not in (select ticket_alias from ec_material_request) and ticket_alias not in (select ref_no from ec_material_outward)"));
		if(!empty($ci_row['tt_alias']))return $ci_row['tt_alias'];else return "''";
	}
}
function mrfStatus($ticket_alias){ global $mr_con;
	$ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
	$tkt_id=strtok($ticket_id, "|");
	$q = mysqli_query($mr_con,"SELECT ticket_alias FROM ec_tickets WHERE ticket_id LIKE '$tkt_id%' AND ticket_id NOT LIKE '".$tkt_id."-%' AND flag='0' ORDER BY id DESC");
	$i=1;
	while($r=mysqli_fetch_array($q)) {
		return sub_mrfStatus($ticket_alias);
		if($tt!="-"){ return $tt;break; }
		else{ if(mysqli_num_rows($q)==$i){return "-";}}
		$i++;
	}
}
function sub_mrfStatus($ticket_alias){ global $mr_con;
	$out_sql = mysqli_query($mr_con,"SELECT status FROM ec_material_outward WHERE from_type='1' AND ref_no='$ticket_alias' AND flag='0'");
	if(mysqli_num_rows($out_sql)){
		$out_row=mysqli_fetch_array($out_sql);
		$status = $out_row['status'];
		if($status=='6')return "CLS";elseif($status=='4' || $status=='0')return "ITS";else return "-";
	}else{
		$sql = mysqli_query($mr_con,"SELECT mrf_alias FROM ec_material_request WHERE ticket_alias='$ticket_alias' AND flag='0'");
		if(mysqli_num_rows($sql)){
			$row=mysqli_fetch_array($sql);
			$out_sql1 = mysqli_query($mr_con,"SELECT status FROM ec_material_outward WHERE from_type='3' AND sjo_number='".$row['mrf_alias']."' AND flag='0'");
			if(mysqli_num_rows($out_sql1)){
				$out_row1=mysqli_fetch_array($out_sql1);
				$status1 = $out_row1['status'];
				if($status1=='6')return "INW";elseif($status1=='4' || $status1=='0')return "ITF";else return "-";
			}else return "RTF";
		}else return "-";
	}
}
// For Tickets ends
function gradedesg1($gradedesg){global $mr_con;
	$rec=$mr_con->query("SELECT designation FROM ec_designation WHERE grade='$gradedesg' AND flag=0 ORDER BY designation");
	if($rec->num_rows>0){$res="";
		while($row = $rec->fetch_assoc()){
			$res.=$row['designation'].", ";
		}
		return rtrim($res,", ");
	}
}
function expense_levels($level_alias){
	if($level_alias==1){return "Approver Level";}
	elseif($level_alias==2){return "HR Level";}
	elseif($level_alias==3){return "Finance Level";}
	elseif($level_alias==4){return "HOD Level";}
	else{return "MD Level";}
}
function checkApproval($fv1){global $mr_con;
	$rec=$mr_con->query("SELECT id FROM ec_expense_approvals WHERE approver = '$fv1' AND flag=0");
	if($rec->num_rows>0){return 1;}else return 0;
}
function toatlAdvances($fv1){
	global $mr_con;
	$rec=$mr_con->query("SELECT SUM(request_amount) AS totalRequest FROM ec_advances WHERE employee_alias='$fv1' AND approval_level IN ('6','7') AND flag=0");
	if($rec->num_rows > 0){
		$row = $rec->fetch_assoc();
		if($row['totalRequest'] > 0) return $row['totalRequest']; else return 0;
	}else return 0;
}
function totalExpenses($fv1){
	global $mr_con;
	$rec=$mr_con->query("SELECT SUM(total_tour_expenses) AS totalRequest FROM ec_expenses WHERE employee_alias='$fv1' AND approval_level IN ('6') AND flag=0");
	if($rec->num_rows > 0){
		$row = $rec->fetch_assoc();
		if($row['totalRequest'] > 0) return $row['totalRequest']; else return 0;
	}else return 0;
}
function totalReimbursement($fv1){
	global $mr_con;
	$rec1=$mr_con->query("SELECT SUM(reimbursement_amount) AS totalReimbursement FROM ec_expenses WHERE employee_alias='$fv1' AND approval_level IN ('7','6') AND flag=0");
	if($rec1->num_rows > 0){
		$row1 = $rec1->fetch_assoc();
		if($row1['totalReimbursement'] > 0) return $row1['totalReimbursement']; else return 0;
		}else return 0;
}
function totalRefund($fv1){
	global $mr_con;
	$rec1=$mr_con->query("SELECT SUM(refund_amount) AS refund_amount FROM ec_expenses WHERE employee_alias='$fv1' AND approval_level IN ('7','6') AND flag=0");
	if($rec1->num_rows > 0){
		$row1 = $rec1->fetch_assoc();
		if($row1['refund_amount'] > 0) return $row1['refund_amount']; else return 0;
		}else return 0;
}
function employeeDetails($fv1,$fv2){
	global $mr_con;
	if($fv2=="admin"){return "Admin";}
	else{
		$rec=$mr_con->query("SELECT $fv1 FROM ec_employee_master WHERE employee_alias='$fv2'");
		if($rec->num_rows > 0){$row = $rec->fetch_assoc();return $row[$fv1];}else return 0;
	}
}
function checkspldep($emp_alias){ global $mr_con;
	return alias(alias($emp_alias,'ec_employee_master','employee_alias','department_alias'),'ec_department','department_alias','spl');
}

function grade($fv1){
	global $mr_con;
	$rec=$mr_con->query("SELECT grade FROM ec_designation WHERE designation_alias = (SELECT designation_alias FROM ec_employee_master WHERE employee_alias='$fv1' AND flag =0) AND flag=0");
	if($rec->num_rows > 0){$row = $rec->fetch_assoc();return $row['grade'];}else return 0;
}
function advancelimit($fv1){
	global $mr_con;
	$rec=$mr_con->query("SELECT limit_amount FROM ec_expense_limits WHERE designation_alias = (SELECT designation_alias FROM ec_employee_master WHERE employee_alias='$fv1' AND flag =0) AND flag=0");
	if($rec->num_rows > 0) {
		$row = $rec->fetch_assoc();
		return $row['limit_amount'];
	} else {
		return 10000;
	} 
}
function advanceNotSettled($fv1){
	global $mr_con;
	$rec=$mr_con->query("SELECT SUM(request_amount) AS totalRequest FROM ec_advances WHERE employee_alias='$fv1' AND approval_level IN ('7','6') AND flag=0");
	$rec1=$mr_con->query("SELECT SUM(total_tour_expenses) AS totalRequest1,SUM(reimbursement_amount) AS totalReiem, SUM(refund_amount) AS totalRefund FROM ec_expenses WHERE employee_alias='$fv1' AND approval_level IN ('7','6') AND flag=0");

	//if($rec->num_rows > 0){
	if($rec){
		$row = $rec->fetch_assoc();
		$row1 = $rec1->fetch_assoc();
		return ($row['totalRequest']-($row1['totalRequest1']-$row1['totalReiem'])-$row1['totalRefund']);
		}else return 0;
}
function listPendingAdvances($fv1){
	global $mr_con;
	$rec=$mr_con->query("SELECT request_id,total_amount,requested_date,approved_by FROM ec_advances WHERE employee_alias='$fv1' AND approval_level='6' AND total_amount!='0' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=array('request_id'=>$row['request_id'],'total_amount'=>$row['total_amount'],'requested_date'=>$row['requested_date'],'approved_by'=>$row['approved_by']);}
		return $result;
	}else return 0;
}
function expenseApprovalLevels($fv1){
	global $mr_con;
	$fv2=employeeDetails('department_alias',$fv1);
	$rec=$mr_con->query("SELECT approval_level FROM ec_expense_approvals WHERE approver ='$fv1' AND flag=0 ORDER BY approval_level DESC");
	if($rec->num_rows>0){$row = $rec->fetch_assoc();return $row['approval_level'];}else return 0;
}
function advapplevels($advap){
	if($advap=='0'){return 'DRAFT';}
	elseif($advap=='1'){return 'APPROVER PENDING';}
	elseif($advap=='2'){return 'HOD PENDING';}
	elseif($advap=='3'){return 'SCM PENDING';}
	elseif($advap=='4'){return 'FINANCE PENDING';}
	elseif($advap=='5'){return 'MD PENDING';}
	elseif($advap=='6'){return 'APPROVED';}
	elseif($advap=='7'){return 'CLOSED';}
	else{return 'REJECTED';}
}
function requesttype($fv1,$fv2){
	global $mr_con;
	$rec=$mr_con->query("SELECT id FROM ec_advances WHERE request_id='$fv1' AND advance_alias='$fv2' AND flag=0");
	$rec1=$mr_con->query("SELECT id FROM ec_expenses WHERE bill_number='$fv1' AND expenses_alias='$fv2' AND flag=0");
	if($rec->num_rows>0) return "advance";
	else if($rec1->num_rows>0) return "expense";
	else return "NA"; 
}
function exlevelsName($fv1){
	global $mr_con;
	$rec=$mr_con->query("SELECT level_name FROM ec_expense_level WHERE level_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){$row = $rec->fetch_assoc(); return $row['level_name'];}else return 0;
}

function approvelvl($fv1){
	global $mr_con;
	$rec=$mr_con->query("SELECT approval_level FROM ec_expense_approvals WHERE approver='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=$row['approval_level'];}
		return $result;
	}else return 0;
}
function expensefullView($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT utr_num,report,bill_number,po_gnr, employee_alias,period_of_visit_from,period_of_visit_to,places_of_visit,purpose,total_tour_expenses,requested_date,expenses_alias,approval_level,reimbursement_amount,refund_amount,approved_by,approved_date FROM ec_expenses WHERE expenses_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){
			$result[]=array('utr_num'=>$row['utr_num'],'bill_number'=>$row['bill_number'],'po_gnr'=>$row['po_gnr'],'employee_alias'=>$row['employee_alias'],'period_of_visit_from'=>$row['period_of_visit_from'],'period_of_visit_to'=>$row['period_of_visit_to'],'places_of_visit'=>$row['places_of_visit'],'purpose'=>$row['purpose'],'total_tour_expenses'=>$row['total_tour_expenses'],'requested_date'=>$row['requested_date'],'expenses_alias'=>$row['expenses_alias'],'approval_level'=>$row['approval_level'],'report'=>$row['report'],'reimbursement_amount'=>$row['reimbursement_amount'],'refund_amount'=>$row['refund_amount'],'approved_by'=>$row['approved_by'],'approved_date'=>$row['approved_date']);
		}
		return $result;
	}else return 0;
} 
function getRoleStat($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT role_stat FROM ec_emprole WHERE flag=0 AND role_alias='$fv1'");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){
		$result = $row['role_stat'];
		}
	return $result;
	}else return 0;
}
function getTicketName($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT ticket_id FROM ec_tickets WHERE ticket_alias = '$fv1' AND flag=0");
	if($rec->num_rows>0){
	$row = $rec->fetch_assoc();
	$result=$row['ticket_id'];
	return $result;
	}else return '';
}

function getArea($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT area FROM ec_district WHERE flag=0 AND district_alias = '$fv1'");
	if($rec->num_rows>0){
	$row =$rec->fetch_assoc();
	return $res = $row['area'];
	}else return -1;
}
function getWeights($fv1,$fv2){ global $mr_con;
	$get = ($fv2=='weight' ? 'weight' : 'product_description');
	$rec=$mr_con->query("SELECT $get as res FROM ec_product WHERE flag=0 AND product_alias = '$fv1'");
	if($rec->num_rows>0){
	$row =$rec->fetch_assoc();
	return $res = $row['res'];
	}else return 0;
}
function getNames($fv1,$fv2){ global $mr_con;
	$where = ($fv2=='ec_zone' ? 'zone_alias' : ($fv2=='ec_state' ? 'state_alias' : 'district_alias'));
	$get = ($fv2=='ec_zone' ? 'zone_name' : ($fv2=='ec_state' ? 'state_name' : 'district_name'));
	$rec=$mr_con->query("SELECT $get as res FROM $fv2 WHERE flag=0 AND $where = '$fv1'");
	if($rec->num_rows>0){
	$row =$rec->fetch_assoc();
	return $res = $row['res'];
	}else return 0;
}
function checkint($fv1,$fv2,$fv3){ global $mr_con;
	$rec=$mr_con->query("SELECT id FROM $fv2 WHERE $fv3='#.".$fv1."'");
	return $rec->num_rows==0 ? $fv1 : checkint(mt_rand(1000,999999999),$fv2,$fv3);
}
function advancefullView($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT report,utr_num, employee_alias, request_amount, total_amount, request_id, approved_by, requested_date, advance_alias, approval_level FROM ec_advances WHERE advance_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){
			$result[]=array('employee_alias'=>$row['employee_alias'],'request_id'=>$row['request_id'],'utr_num'=>$row['utr_num'],'request_amount'=>$row['request_amount'],'total_amount'=>$row['total_amount'],'requested_date'=>$row['requested_date'],'approved_by'=>$row['approved_by'],'approval_level'=>exlevelsName($row['approval_level']),'approval_level1'=>$row['approval_level'],'advance_alias'=>$row['advance_alias'],'report'=>$row['report']);
			}
		return $result;
	}else return 0;
}
function chouldshow($fv1,$fv2){
	$q=approvelvl($fv1);
	if($q!=0){
		switch ($fv2){
			case '1': $level=1;break;
			case '2': $level=4;break;
			case '3': $level=2;break;
			case '4': $level=3;break;
			case '5': $level=5;break;
			default: $level=0;break;
		}
		if(in_array($level, $q)){return 1;
		}else return 0;
	}else return 0;
}
function financeemp($fv1){
	global $mr_con;
	$fv1=alias($fv1,'ec_employee_master','employee_alias','department_alias');
	$rec=$mr_con->query("SELECT spl FROM ec_department WHERE department_alias='$fv1' AND flag=0");
	if($rec->num_rows > 0){
		$row = $rec->fetch_assoc();
		if($row['spl'] =='2') return $row['spl']; else return 0;
	}else return 0;
}
function totalAdvance($fv1,$fv2){ global $mr_con; 
	$ta=advanceNotSettled($fv2)+$fv1;
	$al=advancelimit($fv2);
	if($ta>$al) return $ta.'|1';
	else return $ta.'|0';
	}
function selflodgingamount($fv1,$fv2,$fv3,$fv4){ global $mr_con;
	$fv2=grade($fv2);
	$fv1="lodging_allowances_".$fv1;
	$rec=$mr_con->query("SELECT $fv1 FROM ec_daily_allowances WHERE grade ='$fv2' AND flag=0");
	if($rec->num_rows>0){
		$row = $rec->fetch_assoc();
		if($row[$fv1]!="ACT"){
			$date1 = new DateTime($fv3);
			$date2 = new DateTime($fv4);
			if($date1<=$date2){
				$diff = ($date2->diff($date1)->format("%a"));
				return (($row[$fv1]/2)*$diff);
			}else{return 0;}
		}
		else{return "";}
	}
	else return "";
}
function bordaingamount($fv1,$fv2,$fv3,$fv4){ global $mr_con;
	$fv2=grade($fv2);
	$fv1="boarding_allowances_".$fv1;
	$rec=$mr_con->query("SELECT $fv1 FROM ec_daily_allowances WHERE grade ='$fv2' AND flag=0");
	if($rec->num_rows>0){
		$row = $rec->fetch_assoc();
		if($row[$fv1]!="ACT"){
			$date1 = new DateTime($fv3);
			$date2 = new DateTime($fv4);
			if($date1<=$date2){
				$diff = ($date2->diff($date1)->format("%a"))+1;
				return (($row[$fv1])*$diff);
			}else{return 0;}
		}
		else{return "";}
		
	}
	else return "";
}
function noofDays($fv1,$fv2){
	$date1=date_create($fv1);
	$date2=date_create($fv2);
	$diff=date_diff($date1,$date2);
	return ($diff->format("%a")+1);
}

function getRemarks($fv1,$fv2){ global $mr_con;
	$rec=$mr_con->query("SELECT remarks, remarked_by, remarked_on FROM ec_remarks WHERE item_alias='$fv1' AND module='$fv2' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=array('remarks'=>$row['remarks'],'remarked_by'=>$row['remarked_by'],'remarked_on'=>$row['remarked_on']);}
		return $result;
	}else return 0;
}
function empdrop(){ global $mr_con;
	$rec=$mr_con->query("SELECT employee_alias,name FROM ec_employee_master WHERE flag=0 ORDER BY name");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('name'=>$row['name'],'alias'=>$row['employee_alias']);}
	return $result;
	}else return 0;
}
function empDeptdrop($appr_dept,$emp_alias){ global $mr_con;
	$exp_arr = explode(',',$appr_dept);
	$check_arr = '';
	$carr = count($exp_arr);
	$i=1;
	foreach($exp_arr as $exp){
		$check_arr .= "'";
		$check_arr .= $exp;
		$check_arr .= "'";
		if($carr != $i)$check_arr .= ", ";
		$i++;
	}
	$rec=$mr_con->query("(SELECT employee_alias,name FROM ec_employee_master WHERE employee_alias='$emp_alias' AND flag=0) UNION ALL (SELECT employee_alias,name FROM ec_employee_master WHERE flag=0 AND department_alias IN ($check_arr)) ORDER BY name");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('name'=>$row['name'],'alias'=>$row['employee_alias']);}
	return $result;
	}else return 0;
}
function expo($a){
	foreach(explode("|",$a) as $b){$c[]=alias_flag_none($b,'ec_employee_master','employee_alias','name');}
	return implode(", ",$c);
}
function exp_for($tbl,$buc=1){
	
	if($tbl=='ec_localconveyance' && $buc==0 && $buc!=null)return 'Secondary Transportation';
	else{
		switch($tbl){
			case 'ec_conveyance': return 'Conveyance'; break;
			case 'ec_localconveyance': return 'Local Conveyance'; break;
			case 'ec_lodging': return 'Lodging'; break;
			case 'ec_boarding': return 'Boarding'; break;
			case 'ec_other_expenses': return 'Other Expenses'; break;
			default : return 'No Expense';
		}
	}
}
function advancedetlimited($fv2,$fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT $fv2 FROM ec_advances WHERE advance_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){$row = $rec->fetch_assoc(); return $row[$fv2];}else return 0;
}
function urllink($fv1){
	if($fv1>='2016-04-15') {$url_path = baseurl();} else{$url_path = baseurl().'enersys_expense/';}return $url_path;
}
function alreadyexist_level($fv1,$fv2,$mr_con){
	$rec=$mr_con->query("SELECT id FROM ec_expense_approvals WHERE approval_dep='$fv1' AND approval_level='$fv2'");
	if($rec->num_rows==0)return 0; else return 1;
}
function dat($a){if(!empty($a))return date_format(date_create($a),"jS M Y");else return false;}
function expensedetlimited($fv2,$fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT $fv2 FROM ec_expenses WHERE expenses_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){$row = $rec->fetch_assoc(); return $row[$fv2];}else return 0;
}
function checkopbal($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT id FROM ec_advances WHERE employee_alias='".$fv1."' AND approved_by='' AND approval_level='6' AND flag='0'");
	if($rec->num_rows>0)return 1;else return 0;
	//return $rec->num_rows==0 ? 0 : 1;
}
function getDprCat($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT category FROM ec_dpr_category WHERE flag=0 AND category_alias = '$fv1'");
	if($rec->num_rows>0){
	$row = $rec->fetch_assoc();
	$result=$row['category'];
	return $result;
	}else return 0;
}
function ec_conveyance($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,document_link,created_date,dpr_number,ticket_alias FROM ec_conveyance WHERE expenses_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=array('expenses_alias'=>$row['expenses_alias'],'date_of_travel'=>$row['date_of_travel'],'mode_of_travel'=>$row['mode_of_travel'],'from_place'=>$row['from_place'],'to_place'=>$row['to_place'],'amount'=>$row['amount'],'alias'=>$row['alias'],'document_link'=>$row['document_link'],'created_date'=>$row['created_date'],'dpr_number'=>$row['dpr_number'],'ticket_alias'=>$row['ticket_alias']);}
		return $result;
	}else return 0;
}
function ec_localconveyance($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,created_date,zone_alias,state_alias,district_alias,bucket,capacity,quantity,km,dpr_number,ticket_alias FROM ec_localconveyance WHERE expenses_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=array('expenses_alias'=>$row['expenses_alias'],'date_of_travel'=>$row['date_of_travel'],'mode_of_travel'=>$row['mode_of_travel'],'from_place'=>$row['from_place'],'to_place'=>$row['to_place'],'amount'=>$row['amount'],'alias'=>$row['alias'],'created_date'=>$row['created_date'],'zone_alias'=>$row['zone_alias'],'state_alias'=>$row['state_alias'],'district_alias'=>$row['district_alias'],'bucket'=>$row['bucket'],'capacity'=>$row['capacity'],'quantity'=>$row['quantity'],'km'=>$row['km'],'dpr_number'=>$row['dpr_number'],'ticket_alias'=>$row['ticket_alias']);}
		return $result;
	}else return 0;
}
function ec_lodging($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT expenses_alias,type_of_stay,check_in,check_out,hotel_name,amount,alias,document_link,created_date,zone_alias,state_alias,district_alias,dpr_number,ticket_alias FROM ec_lodging WHERE  expenses_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=array('expenses_alias'=>$row['expenses_alias'],'type_of_stay'=>$row['type_of_stay'],'check_in'=>$row['check_in'],'check_out'=>$row['check_out'],'hotel_name'=>$row['hotel_name'],'amount'=>$row['amount'],'alias'=>$row['alias'],'document_link'=>$row['document_link'],'created_date'=>$row['created_date'],'zone_alias'=>$row['zone_alias'],'state_alias'=>$row['state_alias'],'district_alias'=>$row['district_alias'],'dpr_number'=>$row['dpr_number'],'ticket_alias'=>$row['ticket_alias']);}
		return $result;
	}else return 0;
}
function ec_boarding($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT expenses_alias,check_in,check_out,state,amount,alias,created_date,zone_alias,state_alias,district_alias,dpr_number,ticket_alias FROM ec_boarding WHERE expenses_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=array('expenses_alias'=>$row['expenses_alias'],'check_in'=>$row['check_in'],'check_out'=>$row['check_out'],'state'=>$row['state'],'amount'=>$row['amount'],'alias'=>$row['alias'],'created_date'=>$row['created_date'],'zone_alias'=>$row['zone_alias'],'state_alias'=>$row['state_alias'],'district_alias'=>$row['district_alias'],'dpr_number'=>$row['dpr_number'],'ticket_alias'=>$row['ticket_alias']);}
		return $result;
	}else return 0;
}
function ec_other_expenses($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT expenses_alias,description,amount,checked_date,alias,document_link,created_date,dpr_number,ticket_alias FROM ec_other_expenses WHERE  expenses_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=array('expenses_alias'=>$row['expenses_alias'],'description'=>$row['description'],'amount'=>$row['amount'],'checked_date'=>$row['checked_date'],'alias'=>$row['alias'],'document_link'=>$row['document_link'],'created_date'=>$row['created_date'],'dpr_number'=>$row['dpr_number'],'ticket_alias'=>$row['ticket_alias']);}
		return $result;
	}else return 0;
}
function moneyFormatIndia($num){
	$explrestunits = "" ;
	if(is_float($num)) {
		$thecash1 = sprintf("%01.2f", $num);
		$exp = explode('.',$thecash1);
		$exp1 = $exp[0];
		if(strlen($exp1)>3){
			$lastthree = substr($exp1, strlen($exp1)-3, strlen($exp1));
			$restunits = substr($exp1, 0, strlen($exp1)-3); // extracts the last three digits
			$restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
			$expunit = str_split($restunits, 2);
			for($i=0; $i<sizeof($expunit); $i++){
				// creates each of the 2's group and adds a comma to the end
				if($i==0){$explrestunits .= (int)$expunit[$i].",";} // if is first value , convert into integer
				else{$explrestunits .= $expunit[$i].",";}
			}$thecash = $explrestunits.$lastthree.".".$exp[1];
		}else{$thecash = $exp1.".".$exp[1];}
	
	} else {
		if(strlen($num)>3){
			$lastthree = substr($num, strlen($num)-3, strlen($num));
			$restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
			$restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
			$expunit = str_split($restunits, 2);
			for($i=0; $i<sizeof($expunit); $i++){
				// creates each of the 2's group and adds a comma to the end
				if($i==0){$explrestunits .= (int)$expunit[$i].",";} // if is first value , convert into integer
				else{$explrestunits .= $expunit[$i].",";}
			}$thecash = $explrestunits.$lastthree;
		}else{$thecash = $num;}
	}
	
	return $thecash; // writes the final format where $currency is the currency symbol.
}
function approvelLevelemplist($fv1,$fv2){ global $mr_con;
	$rec=$mr_con->query("SELECT approver FROM ec_expense_approvals WHERE approval_dep ='$fv1' AND approval_level ='$fv2' AND flag=0");
	if($rec->num_rows>0){$row = $rec->fetch_assoc();return $row['approver'];}else return 0;
}
function hodname($fv1){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT department_alias FROM ec_employee_master WHERE employee_alias='$fv1' AND flag=0");
	if(mysqli_num_rows($sql)>0){
		$row=mysqli_fetch_array($sql);
		$emp_dep=$row['department_alias'];
		$query=mysqli_query($mr_con,"SELECT approver FROM ec_expense_approvals WHERE approval_dep='$emp_dep' AND approval_level='2' AND flag=0");
			if(mysqli_num_rows($query)>0){
				$deprow=mysqli_fetch_array($query);
				$hname=employeeDetails('name',$deprow['approver']);
				return $hname;
			}else return 0;
	}else{return 0;}
}
function ebill($fv1){global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT bill_number FROM ec_expenses WHERE expenses_alias='$fv1' AND flag=0");
	if(mysqli_num_rows($sql)>0){
		$row=mysqli_fetch_array($sql);
		$billnum=$row['bill_number'];
		return $billnum;
	}else{return '';}
}
function areq($fv1){global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT request_id FROM ec_advances WHERE advance_alias='$fv1' AND flag=0");
	if(mysqli_num_rows($sql)>0){
		$row=mysqli_fetch_array($sql);
		$areq_id=$row['request_id'];
		return $areq_id;
	}else{return '';}
}
function update_fields($field_name){ global $mr_con;
	if(!empty($field_name)){
		if(mysqli_num_rows(mysqli_query($mr_con,"SHOW COLUMNS FROM ec_app_update_status LIKE '$field_name'"))){
			return (mysqli_query($mr_con,"UPDATE ec_app_update_status SET $field_name='1' WHERE flag=0") ? TRUE : FALSE);
		}else return FALSE;
	}else return FALSE;
}

function inwardConditionCellUpdate($itemAlias, $location) {
	global $mr_con;
	$query = "SELECT * FROM ec_total_cell WHERE cell_alias = '$itemAlias' AND `location` = '$location' AND flag = 0";
	$sql = mysqli_query($mr_con, $query);
	if(mysqli_num_rows($sql) > 0) {
		return true;
	}
	return false;
}

function inwardConditionAccUpdate($itemAlias, $location) {
	global $mr_con;
	$query = "SELECT * FROM ec_total_accessories WHERE acc_alias = '$itemAlias' AND `location` = '$location' AND flag = 0";
	$sql = mysqli_query($mr_con, $query);
	if(mysqli_num_rows($sql) > 0) {
		return true;
	}
	return false;
}

function outwardConditionCellUpdate($itemAlias, $location) {
	global $mr_con;
	$query = "SELECT * FROM ec_total_cell WHERE cell_alias = '$itemAlias' AND `location` = '$location' AND flag = 0 AND stage = 0";
	$sql = mysqli_query($mr_con, $query);
	if(mysqli_num_rows($sql) > 0) {
		return false;
	}
	return true;
}

function outwardConditionAccUpdate($itemAlias, $location) {
	global $mr_con;
	$query = "SELECT * FROM ec_total_accessories WHERE acc_alias = '$itemAlias' AND `location` = '$location' AND flag = 0 AND stage = 0";
	$sql = mysqli_query($mr_con, $query);
	if(mysqli_num_rows($sql) > 0) {
		return false;
	}
	return true;
}

// end - expense traker
?>
