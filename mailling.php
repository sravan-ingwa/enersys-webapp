<script>setInterval(function(){ window.close(); },25000);</script>
<?php
/*include('v1/mysql.php');
include('v1/functions.php');

$query=mysql_query("SELECT id,siteId,ticketId,checkStat FROM ss_tickets WHERE mailStat='1'");
while($row = mysql_fetch_array($query)){
	if($row['checkStat']=='5'){$a = mailsent($row['id']); }
	if($row['checkStat']>='0' && $row['checkStat']<'5'){$b = createMail(strtoupper(mysql_escape_string($row['siteId'])),$row['ticketId']); }
		if($a || $b){ $up = mysql_query("UPDATE ss_tickets SET mailStat='0' WHERE id='".$row['id']."'");
		if($up){ mysql_query("INSERT INTO ss_mail_log(ticketId,checkStat)VALUES('".$row['ticketId']."','".$row['checkStat']."')"); }
		}
}
//echo $b;
//DPR
mysql_close($con);
*/
date_default_timezone_set("Asia/Kolkata");

if($_SERVER["HTTPS"]!='on')header('Location: https://enersyscare.co.in'.$_SERVER['REQUEST_URI']);
include('services/mysql.php');
date_default_timezone_set("Asia/Kolkata");
//$date = date("Y-m-d");
//$query=mysqli_query($mr_con,"UPDATE ec_tickets SET level='2',old_level='1' WHERE level='1' AND old_level='2' AND transaction_date='$date' AND planned_date < '$date' AND planned_date<>'0000-00-00' AND flag='0'");

//tat update

$sql = mysqli_query($mr_con,"SELECT item_alias,bucket FROM pending_mail_log WHERE status='0' AND flag=0");
if(mysqli_num_rows($sql)>'0'){
	while($row=mysqli_fetch_array($sql)){
		$alias=$row['item_alias'];
		if($row['bucket']=="EFSR")echo curlxing("https://enersyscare.co.in/mobile_app/efsr_submit_mail.php?ticketAlias=".$alias);
		elseif($row['bucket']=="DPR")echo dpr_mail($alias);
		elseif($row['bucket']=="BADV")echo curlxing("https://enersyscare.co.in/enersys_expense/maillings/book_advance.php?ref=".$alias);
		elseif($row['bucket']=="BEXP")echo curlxing("https://enersyscare.co.in/enersys_expense/maillings/book_expense.php?ref=".$alias);
		else{
			switch($row['bucket']){
				//TT Mails
				case "NEW": list($ticket_alias,$site_alias)=explode("_",$alias);
							$return="tickets/mails/new_ticket_mail?ticket_alias=".$ticket_alias."&site_alias=".$site_alias;break;
				case "ZNC":$return="tickets/mails/zhs_nhs_close_mail?ticket_alias=".$alias;break;
				case "TTD":$return="tickets/mails/ticket_declined_mail?ticket_alias=".$alias;break;
				case "ZND":$return="tickets/mails/zhs_nhs_decline_mail?ticket_alias=".$alias;break;
				case "TSA":$return="tickets/mails/ts_approve_mail?ticket_alias=".$alias;break;
				case "TSR":$return="tickets/mails/ts_reject_mail?ticket_alias=".$alias;break;
				//FA Mails
				case "MR":$return="inventory/mails/mrmails?a=".$alias;break;
				case "PPCC":$return="inventory/mails/mpmails?a=".$alias."&b=c";break;
				case "PPCR":$return="inventory/mails/mpmails?a=".$alias."&b=r";break;
				case "INVC":$return="inventory/mails/midmails?a=".$alias."&b=i";break;
				case "DISP":$return="inventory/mails/midmails?a=".$alias."&b=d";break;
				case "MI":$return="inventory/mails/mimails?a=".$alias;break;
				case "MO":$return="inventory/mails/momails?a=".$alias;break;
				case "RV":$return="inventory/mails/mremails?a=".$alias;break;
				case "RF":$return="inventory/mails/mrfmails?a=".$alias;break;
				case "MRD":$return="inventory/mails/mrdmails?a=".$alias;break;
				case "MRS":$return="inventory/mails/mrsmails?a=".$alias;break;
				case "MRT":$return="inventory/mails/mrtmails?a=".$alias;break;
				default:$return='0';
			}
			if($return!='0')echo curlxing("https://enersyscare.co.in/services/".$return);
		}
		$upq = "update pending_mail_log set status = 1 where item_alias = '$alias'";
		mysqli_query($mr_con, $upq);
	}
}

//Aging mails
//if(date('H')=='13')curlxing("https://enersyscare.co.in/services/aging_mail.php");

function curlxing($url){
	$chu = curl_init();
	curl_setopt($chu, CURLOPT_URL, $url);
	curl_setopt($chu, CURLOPT_FRESH_CONNECT, true);
	curl_setopt($chu, CURLOPT_TIMEOUT, 10);
	curl_exec($chu);
	curl_close($chu);
}

if(date('H')>'07' && date('H')<'09'){
	//Dpr address Update
	$not_in ="'127','134','150','3371','3399','4031','4043','4497','4517','4536','4823','4835','4850','4857','4921','4932','5063','5074','5582','5868','5878','5882','5897','5900','5907','5920','5923','5936','5947','5953','6442','6483','7695','7716','8164'";
	$sql_addr=mysqli_query($mr_con,"SELECT t1.id,t2.lat,t2.lng FROM ec_dpr t1 INNER JOIN ec_user_tracking t2 ON t1.tracking_alias=t2.tracking_alias WHERE t1.id NOT IN($not_in) AND t1.dpr_address='' AND t1.tracking_alias<>'' AND t2.lat<>'0' AND t2.lng<>'0' AND t2.type='4' AND t1.flag='0' AND t2.flag='0'");
	if(mysqli_num_rows($sql_addr))while($row_addr=mysqli_fetch_array($sql_addr))mysqli_query($mr_con,"UPDATE ec_dpr SET dpr_address='".getAddress($row_addr['lat'],$row_addr['lng'])."' WHERE id='".$row_addr['id']."' AND flag='0'");
	
	//TAT Update
	$sql=mysqli_query($mr_con,"SELECT ticket_id FROM ec_tickets WHERE level NOT IN('5','6','7') AND flag='0'");
	while($row1=mysqli_fetch_array($sql)){
		$ticket_id=strtok($row1['ticket_id'],"|");
		$sql2=mysqli_query($mr_con,"SELECT login_date,closing_date FROM ec_tickets WHERE id = (SELECT MAX(id) FROM ec_tickets WHERE ticket_id LIKE '%$ticket_id%' AND ticket_id NOT LIKE '%$ticket_id-%') AND flag='0'");
		$row=mysqli_fetch_array($sql2);
		$login_date=date_create($row['login_date']);
		$closing_date=date_create(empty($row['closing_date']) ? date('Y-m-d') : $row['closing_date']);
		$diff=date_diff($login_date,$closing_date);
		$for_mat = $diff->format("%R%a");
		if($for_mat <= 15) $tat="TAT-1";
		elseif($for_mat >= 16 && $for_mat <= 25) $tat="TAT-2";
		else $tat="TAT-3"; //$for_mat > 25
		$sql1=mysqli_query($mr_con,"UPDATE ec_tickets SET tat='$tat' WHERE ticket_id LIKE '%$ticket_id%' AND ticket_id NOT LIKE '%$ticket_id-%' AND flag='0'");
	}
}

if(date('H')=='18'){
	// Delete token which are aging more than 1 day
	$query = "DELETE FROM ec_token WHERE last_updated < now() - INTERVAL 1 DAY";
	$sql = mysqli_query($mr_con, $query);
}

curlxing("https://enersyscare.co.in/error_log_mail.php");

function all_from_mail(){ return "enersyscare_no_reply@enersys.com.cn"; }
function test_monitoring_mail(){
	$from=all_from_mail();
	$headers="From: EnerSys Care Triggering No Error<$from>\r\n";
	$headers.="Reply-To: $from\r\n";
	$headers.="Return-Path: $from\r\n";
	//$headers .= "CC: $ccmail_id \r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	return mail("naresh@techuva.com,maniraj@enersys.co.in","EnerSys Triggering Success on ".date('Y-m-d H:i:s'),"<h2>Triggered on ".date('Y-m-d H:i:s')."</h2>",$headers) ? "Triggered" : "Triggering Fail";
}
function getAddress($lat,$lng){
	global $mr_con;
	$key_arr=['AIzaSyCF82XXUtT0vzMTcEPpTXvKQPr1keMNr_4','AIzaSyAYPw6oFHktAMhQqp34PptnkDEdmXwC3s0','AIzaSyAwd0OLvubYtKkEWwMe4Fe0DQpauX0pzlk','AIzaSyDF3F09RkYcibDuTFaINrWFBOG7ilCsVL0','AIzaSyC1dyD2kzPmZPmM4-oGYnIH_0x--0hVSY8'];
	$key_arr = ['AIzaSyAaUYGCjfKVFX6iDfP8uFG7yGzM7nr47Mc'];
	$query = "INSERT INTO `ec_maps_tacking` (`lat`, `lng`) VALUES ('$lat', '$lng');";
	$sql = mysqli_query($mr_con, $query);
	foreach($key_arr as $key){
		$data = json_decode(@file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&sensor=false&key=$key"));
		if($data->status == "OK") return $data->results[0]->formatted_address;elseif($data->status == "ZERO_RESULTS")return "";
	}return "";
}
function notification($reg_id,$mssg){
	define('API_ACCESS_KEY','AIzaSyCHJ1h1U0y8-wIAtbIw_-rAhkK5opA_2qo');
	$registrationIds = array($reg_id);
	$msg = array('message' 	=> $mssg);
	$fields = array('registration_ids'=> $registrationIds,'data'=>$msg);
	$headers = array('Authorization: key=' . API_ACCESS_KEY,'Content-Type: application/json');
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
function alias($alias,$tb,$col,$retrive){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT $retrive FROM $tb WHERE $col='$alias' AND flag=0");
	if(mysqli_num_rows($sql)){
		$row = mysqli_fetch_array($sql);
		return $row[$retrive];
	}else return "";
}
function dateTimeFormat($date_time,$x){ global $mr_con;
	if(preg_match("/\d{4}\-\d{1,2}\-\d{1,2} \d{2}\:\d{2}\:\d{2}/", $date_time) || preg_match("/\d{1,2}\-\d{1,2}\-\d{4} \d{2}\:\d{2}\:\d{2}/", $date_time)){
		if($date_time=='0000-00-00 00:00:00' || $date_time=='00-00-0000 00:00:00'){ $y = 'NA';}
		elseif($x=="m"){ $y = date("m-d-Y H:i:s", strtotime(mysqli_real_escape_string($mr_con,$date_time)));}
		else{ $y = date(($x=="d" ? "d-m-Y H:i:s" : "Y-m-d H:i:s"), strtotime(mysqli_real_escape_string($mr_con,$date_time)));}
		if(strpos($y,'1970')!==false){$y = 'NA';}
	}else{$y = 'NA';}
	return $y;
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
		if(empty($row['ticket_alias']))$ticket_id = "NA";
		else{
			$ticket_id = alias($row['ticket_alias'],'ec_tickets','ticket_alias','ticket_id');
			if(empty($ticket_id))$ticket_id=$row['ticket_alias'];
		}
		$dpr_address = (empty($row['dpr_address']) ? 'NA' : $row['dpr_address']);
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
			// $ccmail = 'ticket@enersys.co.in';
			$ccmail = '';
			$sub = "DPR @ $se_name @ $sub_date_time";
			$res="<p>Dear Team,</p>";
			$res.="<table width='600px' style='border-collapse:collapse;' cellpadding='3' align='center'>";
				$res.="<tr align='center'>";
					$res.="<th align='center' style='border:1px solid #ddd; border-bottom:1px solid #fff;'>";
						$res.="<table width='100%'>";
							$res.="<tr>";
								$res.="<th align='left'><img src='https://enersyscare.co.in/mobile_app/pdf/images/e_logo_r.png' alt='EnerSys_logo' width='150'></th>";
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
			$from = all_from_mail();
			$header= 'From: EnerSys <'.$from .'>' . "\r\n";
			$header.= 'Cc:'.$ccmail."\r\n";
			$header.= 'Reply-To: '.$from ."\r\n";
			$header.= "Content-Type: text/html\r\n";
			$header.= "X-Mailer: PHP/" . phpversion();
			$header.= 'MIME-Version: 1.0' . "\r\n";
			$admin = "-odb -f $from";
			$abc = mail($to_mail_id, $sub, $res, $header, $admin);
			if($abc)success_mail_log($dpr_alias,"DPR");
			else pending_mail_log($dpr_alias,"DPR");
			if($abc)return TRUE;else return FALSE;
		}
	}
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
?>
