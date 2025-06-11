<script>setInterval(function(){ window.close();},25000);</script>
<?php
if($_SERVER["HTTPS"]!='on')header('Location: https://enersyscare.co.in'.$_SERVER['REQUEST_URI']);
include('v1/mysql.php');
date_default_timezone_set("Asia/Kolkata");
$query=mysql_query("SELECT id,customerCode,mfdDate,installDate,siteStatus FROM ss_site_master");
	while($row = mysql_fetch_array($query)){
		$a=warrantyLeft($row['customerCode'],$row['mfdDate'],$row['installDate'],'warr');
		if($row['siteStatus']=="Amc"){$b = "Amc";}
		else{$b=warrantyLeft($row['customerCode'],$row['mfdDate'],$row['installDate'],'sell'); }
		$ac=mysql_query("UPDATE ss_site_master SET warrantyMonths='".$a."',siteStatus='".$b."' WHERE id='$row[id]' ");
	}
function warrantyLeft($f1,$f2,$f3,$f4){
	date_default_timezone_set("Asia/Kolkata");
	
	$res = mysql_query("select dispatch,installation from ss_customer_details where id='".$f1."' AND flag='0'");
	if(mysql_num_rows($res)>0){$row=mysql_fetch_array($res);
		
		$dis = $row['dispatch'];
		$inst = $row['installation'];
		
		$diff1 = abs(strtotime(date('Y-m-d')) - strtotime($f2)); //$years = $diff / (365*60*60*24);
		$mfd = round($diff1 / 2592000);//30*60*60*24 = 2592000
		
		$diff2 = abs(strtotime(date('Y-m-d')) - strtotime($f3));
		$install = round($diff2 / 2592000);
	
	if($f2=='0000-00-00' || $f2==NULL || $f2==''){ $mfd = 0; }
	if($f3=='0000-00-00' || $f3==NULL || $f3==''){ $install = 0; }

	if($f2=='0000-00-00' && $f3=='0000-00-00'){	if(($dis <= $inst)){ return warr($dis,'Not Given',$f4); } else{ return warr($inst,'Not Given',$f4);} }
	elseif(($dis-$mfd <= 0) || ($inst-$install <= 0)){ if(($dis-$mfd) < ($inst-$install)){ return warr($dis,'Out Of Warranty',$f4);}else{return warr($inst,'Out Of Warranty',$f4);}	}
	elseif(($dis-$mfd) > ($inst-$install)){ return warr($inst,'Warranty',$f4); }
	elseif(($dis-$mfd) < ($inst-$install)){ return warr($dis,'Warranty',$f4); }
	else{ return warr($dis,'Warranty',$f4); } // ($dis-$mfd) == ($inst-$install)
	}
}
function warr($a,$b,$c){if($c=='sell'){ return $b; }else{ return $a;} }

/*$saturday = date("d", strtotime("Saturday"));
$today = date("d");
if($saturday==$today){
	$query = mysql_query("SELECT roleId FROM ss_user_role WHERE privilageType='Create' AND privilageItem='8865' AND flag='0' GROUP BY roleId");
	while($ab = mysql_fetch_array($query)){
		$queryy=mysql_query("SELECT contact FROM ss_user_details WHERE role='$ab[roleId]' AND flag=0 GROUP BY contact");
		if(mysql_num_rows($queryy)>0){
			while($abc = mysql_fetch_array($queryy)){
				$ch=curl_init();
				$numberx=mysql_escape_string($abc['contact']);
				$messagex=urlencode("Dear Team, Good Morning !! Kindly book the Expense incurred from Monday to Friday in Enersys care today  Without fail.");
				curl_setopt($ch, CURLOPT_URL, "http://bhashsms.com/api/sendmsg.php?user=enersyscare&pass=sairaam@5050&sender=EnrSys&phone=".$numberx."&text=".$messagex."&priority=ndnd&stype=normal");
				curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
				curl_setopt($ch, CURLOPT_TIMEOUT, 1);
				curl_exec($ch);
				curl_close($ch);
			}
		}
	}
}*/



/*
$arr=array("14","15","16","17","18","30","31","1","2","3","4");
if(in_array(date('d'),$arr)){
	if(in_array(date('d'),array("14","15","16","17","18"))){$ff = date('F')." F1 till 18th ".date("F Y");}
	elseif(in_array(date('d'),array("30","31"))){$ff = date('F')." F2 till 4th ".date("F Y",strtotime("+1 months"));}
	elseif(in_array(date('d'),array("1","2","3","4"))){$ff = date("F",strtotime("-1 months"))." F2 till 4th ".date("F Y");}
	$query = mysql_query("SELECT roleId FROM ss_user_role WHERE privilageType='Create' AND privilageItem='8865' AND flag='0' GROUP BY roleId");
	while($ab = mysql_fetch_array($query)){
		$queryy=mysql_query("SELECT contact FROM ss_user_details WHERE role='$ab[roleId]' AND flag=0 GROUP BY contact");
		if(mysql_num_rows($queryy)>0){
			while($abc = mysql_fetch_array($queryy)){
				$ch=curl_init();
				$numberx=mysql_escape_string($abc['contact']);
				$messagex=urlencode("Dear Team, this is to inform you that Book Expense option is open in Enersys care of ".$ff.",  Kindly book the Expense.");
				curl_setopt($ch, CURLOPT_URL, "http://bhashsms.com/api/sendmsg.php?user=enersyscare&pass=sairaam@5050&sender=EnrSys&phone=".$numberx."&text=".$messagex."&priority=ndnd&stype=normal");
				curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
				curl_setopt($ch, CURLOPT_TIMEOUT, 1);
				curl_exec($ch);
				curl_close($ch);
			}
		}
	}
}*/
mysql_close($con);

include('services/mysql.php');

//DPR Not submitted code
$sql=mysqli_query($mr_con,"SELECT employee_alias FROM ec_employee_master WHERE (role_alias ='QV9IPNVA1M' OR employee_alias IN('2V1E5SRIXL','S6E12BKPSR','DJ6QIQ0UKNEXI','KFSY2KIDZJXXO','4IHDC2FIR05QR','K9V3LKWVYJLR4')) AND status='WORKING' AND flag=0");
//DASARA RAJU GANESH, RAVI CHOURASIA, DEBENDHAR NAYAK, LINGARAJ SWAIN, PAWAN SRIVASTAV, PRAMODH S
$yesdate=date("Y-m-d",strtotime("-1 days"));
while($sql_row=mysqli_fetch_array($sql)){
	$sql1=mysqli_query($mr_con,"SELECT id FROM ec_dpr WHERE emp_alias='".$sql_row['employee_alias']."' AND sub_date_time LIKE '%$yesdate%' AND flag=0");
	if(mysqli_num_rows($sql1)=='0'){
		$dpr_ref_no = dpr_ref_no();
		$dpr_alias=aliasCheck(generateRandomString(),'ec_dpr','dpr_alias');
		$employee_alias=$sql_row['employee_alias'];
		$dpr_query=mysqli_query($mr_con,"INSERT INTO ec_dpr(dpr_ref_no,emp_alias,category_alias,remarks,expense_incurred,dpr_address,dpr_alias,sub_date_time) VALUES('$dpr_ref_no','$employee_alias','0','Your Dpr is not Submitted','0','0','$dpr_alias','$yesdate 23:59:59')");
		$alias=aliasCheck(generateRandomString(),'ec_calender_event','alias');
		$event_query=mysqli_query($mr_con,"INSERT INTO ec_calender_event(alias,event_type,event_alias,created_on,scheduled_on,emp_alias) VALUES('$alias','2','$dpr_alias','$yesdate','$yesdate 23:59:59','$employee_alias')");
	}
}

$not_in ="'127','134','150','3371','3399','4031','4043','4497','4517','4536','4823','4835','4850','4857','4921','4932','5063','5074','5582','5868','5878','5882','5897','5900','5907','5920','5923','5936','5947','5953','6442','6483','7695','7716','8164'";
$sql_addr=mysqli_query($mr_con,"SELECT t1.id,t2.lat,t2.lng FROM ec_dpr t1 INNER JOIN ec_user_tracking t2 ON t1.tracking_alias=t2.tracking_alias WHERE t1.id NOT IN($not_in) AND t1.dpr_address='' AND t1.tracking_alias<>'' AND t2.lat<>'0' AND t2.lng<>'0' AND t2.type='4' AND t1.flag='0' AND t2.flag='0'");
if(mysqli_num_rows($sql_addr))while($row_addr=mysqli_fetch_array($sql_addr))mysqli_query($mr_con,"UPDATE ec_dpr SET dpr_address='".getAddress($row_addr['lat'],$row_addr['lng'])."' WHERE id='".$row_addr['id']."' AND flag='0'");
function getAddress($lat,$lng){
	$key_arr=['AIzaSyCF82XXUtT0vzMTcEPpTXvKQPr1keMNr_4','AIzaSyAYPw6oFHktAMhQqp34PptnkDEdmXwC3s0','AIzaSyAwd0OLvubYtKkEWwMe4Fe0DQpauX0pzlk','AIzaSyDF3F09RkYcibDuTFaINrWFBOG7ilCsVL0','AIzaSyC1dyD2kzPmZPmM4-oGYnIH_0x--0hVSY8'];
	$key_arr = ['AIzaSyAaUYGCjfKVFX6iDfP8uFG7yGzM7nr47Mc'];
	foreach($key_arr as $key){
		$data = json_decode(@file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&sensor=false&key=$key"));
		if($data->status == "OK") return $data->results[0]->formatted_address;elseif($data->status == "ZERO_RESULTS")return "";
	}return "";
}
function all_from_mail(){ return "enersyscare_no_reply@enersys.com.cn"; }
function dpr_ref_no(){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT CONCAT('DPR',LPAD((SELECT SUBSTRING_INDEX(dpr_ref_no,'R',-1) FROM ec_dpr WHERE flag='0' ORDER BY id DESC LIMIT 1)+1, 5, '0')) AS dpr_no FROM ec_dpr WHERE flag='0'");
	$row = mysqli_fetch_array($sql);
	return $row['dpr_no'];
}
function generateRandomString($length = 20){
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
function alias($alias,$tb,$col,$retrive){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT $retrive FROM $tb WHERE $col='$alias' AND flag=0");
	if(mysqli_num_rows($sql)){
		$row = mysqli_fetch_array($sql);
		return $row[$retrive];
	}else return "";
}
//Notification auto delete before 7 days.
	$date = date('Y-m-d', strtotime('-7 days', strtotime(date('Y-m-d'))));
	$sql_not=mysqli_query($mr_con,"DELETE FROM ec_notifications WHERE created_date < '$date' AND flag=0");

//Calendar Work Schedule

function event_type_desc($fv1=1){
	if($fv1=='1') return "Ticket";
	elseif($fv1=='2') return "DPR";
	elseif($fv1=='0') return "Event";
}
function eventheading($fv1=1,$fv2){ global $mr_con;
	if($fv1=='1') return alias($fv2,'ec_tickets','ticket_alias','ticket_id');
	elseif($fv1=='2') return alias(alias($fv2,'ec_dpr','dpr_alias','category_alias'),'ec_dpr_category','category_alias','category');
	elseif($fv1=='0') return alias($fv2,'ec_event_details','event_alias','title');
}
if(date('l')=="Saturday")echo clndr_wrk_schdl_mail();
function clndr_wrk_schdl_mail(){ global $mr_con;
	$event_types=array();$event_alias=array();$event_dates=array();
	//$monthNames = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	$emp_q=mysqli_query($mr_con,"SELECT employee_alias FROM ec_employee_master WHERE (role_alias='QV9IPNVA1M' OR role_alias='RWRKFNVF49') AND department_alias='TTTCL87RPU' AND flag=0");
	while($emp_row=mysqli_fetch_array($emp_q)){
		$employee_alias=$emp_row['employee_alias'];
		$start_date = $start_date_q = date("Y-m-d");
		$end_date = $end_date_q = date("Y-m-d",strtotime("+1 week"));
		if(isset($_REQUEST['p_level']) && count($_REQUEST['p_level'])>0){$event_type="'".implode("','",$_REQUEST['p_level'])."'";}else $event_type="'0','1','2'";
		$e_query=mysqli_query($mr_con,"SELECT event_type,event_alias,scheduled_on FROM ec_calender_event WHERE scheduled_on >='".$start_date_q."' AND scheduled_on <= '".$end_date_q."' AND event_type IN (".$event_type.") AND emp_alias='".$employee_alias."' AND status=0 AND flag=0 GROUP BY event_alias ORDER BY id DESC");
		if(mysqli_num_rows($e_query)>0){
			unset($event_types);unset($event_alias);unset($event_dates);
			while($e_row=mysqli_fetch_array($e_query)){
				$event_types[]=$e_row['event_type'];
				$event_alias[]=$e_row['event_alias'];
				$event_dates[]=date('d-m-Y',strtotime($e_row['scheduled_on']));
			}
			$startDate=strtotime("$start_date_q");$endDate=strtotime("$end_date_q");
			while($startDate<=$endDate){$timestamp[] = mktime(0,0,0,date('m',$startDate),1,date('Y',$startDate));$startDate = strtotime( date('Y/m/01/',$startDate).' +1 month');}
			for($x=0;$x<count($timestamp);$x++){$ax="";
				$abc=$x;
				$maxday = date("t",$timestamp[$x]);
				$thismonth = getdate ($timestamp[$x]);
				$startday = $thismonth['wday'];
				if(($abc%2)=='0'){$ax.="<tr>";}
				$ax.="<td valign='top'>";
					$ax.="<table align='center' cellpadding='4' width='200px' style='border-collapse:collapse;color:#31527b;font-size:14px'>";
						$ax.="<tr align='center'>";
							$ax.="<td colspan='7'><strong>".date ("M-Y",$timestamp[$x])."</strong></td>";
						$ax.="</tr>";
						$ax.="<tr>";
							$ax.="<th style='border:1px solid #e0e0e0;'><span>SUN</span></th>";
							$ax.="<th style='border:1px solid #e0e0e0;'><span>MON</span></th>";
							$ax.="<th style='border:1px solid #e0e0e0;'><span>TUE</span></th>";
							$ax.="<th style='border:1px solid #e0e0e0;'><span>WED</span></th>";
							$ax.="<th style='border:1px solid #e0e0e0;'><span>THU</span></th>";
							$ax.="<th style='border:1px solid #e0e0e0;'><span>FRI</span></th>";
							$ax.="<th style='border:1px solid #e0e0e0;'><span>SAT</span></th>";
						$ax.="</tr>";
						for ($i=0; $i<($maxday+$startday); $i++) {
							if(($i%7)==0) $ax.="<tr align='center'>";
							if($i<$startday) $ax.="<td style='border:1px solid #e0e0e0;'>&nbsp;</td>";
							else{
								$dat = ($i - $startday + 1);
								$dat1=($dat>9 ? $dat : "0".$dat);
								$calDate=$dat1."-".date ("m-Y",$timestamp[$x]);
								$ax.="<td style='border:1px solid #e0e0e0;".(in_array($calDate, $event_dates) ? "background:#31527b;color:#FFF;" : "")."'>". $dat . "</td>";
							}
							if(($i%7)==6 ) $ax.="</tr>";
						}
					$ax.="</table>";
				$ax.="</td>";
				if(($abc%2)!='0')$ax.="</tr>";
			}
			$email_id=strtolower(alias($employee_alias,'ec_employee_master','employee_alias','email_id'));
			$name=strtoupper(alias($employee_alias,'ec_employee_master','employee_alias','name'));
			$body="";
			$body .= "<html><body style='margin:0 auto;padding:10px;font-size:100%;font-family:Calibri;width:600px;'>";
			$body .="<table align='center' cellpadding='5' width='600px'>";
				$body .="<tr align='left'>";
					$body .="<th style='border-bottom:2px solid #31527b; border-top:2px solid #31527b; text-align:left;color:#31527b;'>";
						$body .="<h5 style='margin:0px; font-size:14px;line-height:20px;'>".$name." Calendar</h5>";
						$body .="<p style='margin:0px; font-size:14px;line-height:20px;'>".$email_id."</p>";
						$body .="<p style='margin:0px; font-size:14px;line-height:20px;'>".date('d-M-Y',strtotime($start_date))." to ".date('d-M-Y',strtotime($end_date))."</p>";
					$body .="</th>";
				$body .="</tr>";
			$body .="</table>";
		
			$body .="<table align='center' cellpadding='6' width='600px' style='color:#31527b;'>";
				//$body .="<tr>";
					$body .=$ax;
				//$body .="</tr>";
			$body .="</table><hr>";
			$body .="<table align='center' cellpadding='5' width='600px' style='color:#31527b;text-align:left; margin-top:10px;'>";
				$body .="<tr align='left'> ";
					$body .="<th colspan='2' style='border-bottom:2px solid #31527b;'>Schedule Details</th>";
				$body .="</tr>";
				$body .="<tr align='left'>";
					$body .="<td>";
						for($gg=0;$gg<count($event_alias);$gg++){
							$body .="<p style='margin:5px 20px;line-height:25px;'><b>".$event_dates[$gg]."</b>: ". event_type_desc($event_types[$gg]).": ".eventheading($event_types[$gg],$event_alias[$gg])."</p>";
						}
					$body .="</td>";
				$body .="</tr>";
			$body .="</table>";
			$body.="</body></html>";
			$subject="Work schedule for next period ".date('d-M-Y',strtotime($start_date))." - ".date('d-M-Y',strtotime($end_date));
			$from = all_from_mail();
			$header= 'From: EnerSys Care <'.$from .'>' . "\r\n";
			$header.= 'CC: ticket@enersys.co.in' . "\r\n";
			$header.= 'Reply-To: '.$from ."\r\n";
			$header.= "Content-Type: text/html\r\n";
			$header.= "X-Mailer: PHP/" . phpversion();
			$header.= 'MIME-Version: 1.0' . "\r\n";
			$admin = "-odb -f $from";
			$abc = mail($email_id, $subject, $body, $header, $admin);
			//if($abc)return TRUE;else return FALSE;
		}
	}
}

//PPC Fail mails and update back to PPC Pending Level.
function baseurl(){ return "https://enersyscare.co.in/"; }
function get_road_permit($road_permit){
	if($road_permit=="1")$res="REQUIRED";elseif($road_permit=="REQUIRED")$res="1";
	elseif($road_permit=="0")$res="NOT REQUIRED";elseif($road_permit=="NOT REQUIRED")$res="0";
	else $res="";
	return (empty($res) ? "NA" : $res);
}
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
echo PPC_Fail_Mails();
function PPC_Fail_Mails(){global $mr_con;
	date_default_timezone_set("Asia/Kolkata");
	$date=date("Y-m-d", strtotime("yesterday"));
	$sql = mysqli_query($mr_con,"SELECT mrf_number,sjo_number,from_wh,readiness_date FROM ec_material_request WHERE readiness_date='$date' AND status='9' AND flag=0");
	$up=mysqli_query($mr_con,"UPDATE ec_material_request SET status='2' WHERE readiness_date<'".date("Y-m-d")."' AND status='9' AND flag=0");
	if(mysqli_num_rows($sql)>'0'){
		$mrf_number=$road_permit=$sjo_number=array();
		while($row=mysqli_fetch_array($sql)){
			$mrf_number[]=$row['mrf_number'];
			$road_permit[]=get_road_permit(alias($row['from_wh'],'ec_warehouse','wh_alias','road_permit'));
			$sjo_number[]=$row['sjo_number'];
			$material_readiness_date[]=dateFormat($row['readiness_date'],'d');
		}
		$sub = "PPC Material Readiness Date Failed - ".date("d-m-Y");
		$body="<p>Dear Team,</p>";
		$body.="<p>Please find the below Material Readiness Date Failed SJO details</p>";
		$body.="<html>";
			$body.="<body style='font-family:Calibri;'>";
				$body.="<table width='800px' style='border-collapse:collapse;' cellpadding='3' align='center'>";
					$body.="<tr align='center'>";
						$body.="<th align='center' style='border:1px solid #ddd; border-bottom:1px solid #fff;'>";
							$body.="<table width='100%' style='border-bottom:1px solid #000'>";
								$body.="<tr>";
									$body.="<th align='left'>";
										$body.="<img src='".baseurl()."images/gallery/EnerSyslogo.png' alt='EnerSys_logo' height='80' width='150'>";
										$body.="<p style='margin:0px 0px 3px 10px; font-size:12px; font-family:sans-serif; font-weight:400;'>CIN NO : U74999TG2007PTC052642</p>";
										$body.="<p style='margin:0px 0px 3px 10px; font-size:12px; font-family:sans-serif; font-weight:400;'>E-Mail ID : service@enersys.co.in</p>";
									$body.="</th>";
									$body.="<th align='right'>";
										$body.="<p style='font-size:15px; margin:3px;'>EnerSys India Batteries Private Limited</p>";
										$body.="<p style='font-size:12px; margin:1px;'>Factory : Narasimha Rao Palem (V), Veerullapadu (M),</p>";
										$body.="<p style='font-size:12px; margin:1px;'>Krishna Dist-521 181, Andhara Pradesh, India.</p>";
										$body.="<p style='font-size:12px; margin:1px;'>Ph: +91 8678201214/15</p>";
										$body.="<p style='font-size:12px; margin:1px;'>Fax: +91 8678 201 237</p>";
										$body.="<p style='font-size:12px; margin:1px;'>www.enersys.co.in</p>";
									$body.="</th>";
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
								$body.="<td align='center'><u><h5 style='margin:2px;'>ACKNOWLEDGEMENT FOR MATERIAL READINESS DATE FAILED</h5></u></td>";
							$body.="</tr>";
						$body.="</table><br>";
						$body.="<table border='1' width='95%' style='border-collapse:collapse; border:1px solid #ddd' cellpadding='8'>";
							$body.="<tr>";
								$body.="<th>MRF Number</th>";
								$body.="<th>SJO Number</th>";
								$body.="<th>Road Permit</th>";
								$body.="<th>Material Readiness Date</th>";
							$body.="</tr>";
							for($r=0;$r<count($sjo_number);$r++){
								$body.="<tr style='text-align:center'>";
									$body.="<td>".$mrf_number[$r]."</td>";
									$body.="<td>".$sjo_number[$r]."</td>";
									$body.="<td>".$road_permit[$r]."</td>";
									$body.="<td>".$material_readiness_date[$r]."</td>";
								$body.="</tr>";
							}
						$body.="</table><br><br>";						
						$body.="<table width='100%' cellpadding='3' style='margin-left:20px;'>";
							$body.="<tr>";
								$body.="<td align='left'><p style='color:#F00'>NOTE : The SJO Number will not be visible in Stocks if the Material Readiness is crossed, In Such cases Replan of Material Readiness need to be done by PPC. </p></td>";
							$body.="</tr>";
						$body.="</table><br><br><br>";
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
						$body.="<table width='100%' cellpadding='2' style='border-top:1px solid #000'>";
							$body.="<tfoot>";
								$body.="<tr>";
									$body.="<td align='center'>";
										$body.="<p style='font-size:11px; font-weight:600;'>Registered Office :EnerSys India Batteries Private Limited, Survey N.118,135,137 & 139, Narasimharaopalem (Village),Veerullapadu (Mandal), VIJAYAWADA ,Krishna (District),
										Andhra Pradesh-521181, India, Ph :9652525292,E-Mail : service@enersys.co.in</p>";
									$body.="</td>";
								$body.="</tr>";
							$body.="</tfoot>";
						$body.="</table>";
					$body.="</td>";
				$body.="</tr>";
			$body.="</table>";
			$body.="<p style='font-style:italic;text-align:center;'><small>*** This is a System generated email, Please do not reply ***</small></p>";
			$body.="</body>";
		$body.="</html>";
		$up=mysqli_query($mr_con,"UPDATE ec_material_request SET status='2',ppc_mail_log='1' WHERE readiness_date='$date' AND status='9' AND flag=0");
		//To and Cc mail IDS'
		$ccmail_id="fieldasset@enersys.co.in";
		$mail_Id="neeraj@enersys.co.in";
		$from=all_from_mail();
		$headers="From: EnerSys Inventory<$from>\r\n";
		$headers.="Reply-To: $from\r\n";
		$headers.="Return-Path: $from\r\n";
		$headers .= "CC: $ccmail_id \r\n";
		//$headers .= "BCC: $bccemail \r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$abc = mail($mail_Id,$sub,$body,$headers);
	}
}
mysqli_close($mr_con);
?>
