<?php
	date_default_timezone_set("Asia/Kolkata");
	include ('../services/mysql.php');
	include ('../services/email_sms_functions.php');
	function all_from_mail(){ return "enersyscare_no_reply@enersys.com.cn"; }
	function baseurl(){ return "https://enersyscare.co.in/";}
	function alias($alias,$tb,$col,$retrive){ global $mr_con;
		$sql = mysqli_query($mr_con,"SELECT $retrive FROM $tb WHERE $col='$alias' AND flag=0");
		if(mysqli_num_rows($sql)){
			$row = mysqli_fetch_array($sql);
			return $row[$retrive];
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
	function color($a,$b){ global $red;
		switch($b){
			case '1': $xyz=(strpos(strtoupper($a),'WORKING')!==false ? '#2a6496' : '#FF0000');break;
			case '2': $xyz=($a=='NO' ? '#2a6496' : '#FF0000');break;
			case '3': $xyz=($a=='CORRECT' ? '#2a6496' : '#FF0000');break;
			case '4': $xyz=($a=='SET AT RIGHT VOLTAGE' ? '#2a6496' : '#FF0000');break;
			case '5': $xyz=($a=='AVAILABLE' ? '#2a6496' : '#FF0000');break;
			case '6': $xyz=($a=='NORMAL' || $a=='LOW'? '#2a6496' : '#FF0000');break;
			case '7': $xyz='#2a6496';break;
			case '8': $xyz=($a=='MATCHED TO BATTERY' ? '#2a6496' : '#FF0000');break;
		}
		//return "style='color:".$xyz."'";
		if($xyz=='#FF0000'){$red++;}
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
	$ticket_alias=$_REQUEST['ticketAlias'];
	$ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
	$site_alias = alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
	$site_name = alias($site_alias,'ec_sitemaster','site_alias','site_name');
	
	if(!empty($ticket_alias) && !empty($ticket_id) && !empty($site_alias) && !empty($site_name)){
		//Ref
			$status = alias($ticket_alias,'ec_tickets','ticket_alias','status');
			$site_name = alias($site_alias,'ec_sitemaster','site_alias','site_name');
			$site_address = alias($site_alias,'ec_sitemaster','site_alias','site_address');
			$job_performed = alias($ticket_alias,'ec_engineer_observation','ticket_alias','job_performed');
		//To
			$cust_name = alias($ticket_alias,'ec_e_signature','ticket_alias','name');
			$cust_contact_number = alias($ticket_alias,'ec_e_signature','ticket_alias','contact_number');
			
			$clust_manager_mail = alias($site_alias,'ec_sitemaster','site_alias','manager_mail');
			$em = alias($ticket_alias,'ec_e_signature','ticket_alias','email');

			$cust_email = $clust_manager_mail.(!empty($em) && filter_var($em, FILTER_VALIDATE_EMAIL) && $clust_manager_mail != $em ? ", ".$em : "");
			
		//1.
			$smps_display = alias($ticket_alias,'ec_technical_observation','ticket_alias','single_panel_rating');
		//2.
			$site_load = alias($ticket_alias,'ec_general_observation','ticket_alias','site_load');
			$no_of_string = alias($site_alias,'ec_sitemaster','site_alias','no_of_string');
			$battery_rating = alias($site_alias,'ec_sitemaster','site_alias','battery_bank_rating');
			$a = get_string_between($battery_rating, "V", "A");
			$b = (!empty($a) ? $a : 0)*$no_of_string;
			$base_amps = ((($b/5)+$site_load)*6)/5;
			$smr_rating = alias($ticket_alias,'ec_technical_observation','ticket_alias','charge_controller_rate');
			$no_of_working = alias($ticket_alias,'ec_technical_observation','ticket_alias','no_solar_panels');
			$final_amps = ($smr_rating * $no_of_working * 4)/5;
			$base_final = ($final_amps > $base_amps ? "NO" : "YES");
		//3. Per Cell Voltage : 2.25 Volts 
			$float_voltage = alias($ticket_alias,'ec_technical_observation','ticket_alias','float_voltage');
			$battery_float = alias($ticket_alias,'ec_battery_bank_bb_cap','ticket_alias','battery_bank_rating');
			$bb_float = preg_replace('/\D/', '', $battery_float);
			if($bb_float=='24'){$bb_diff = ($float_voltage - 27);}
			elseif($bb_float=='48'){$bb_diff = ($float_voltage - 54); }
			if(abs($bb_diff)<='0.2'){$float_res = 'CORRECT';}
			elseif($bb_diff){$float_res = 'HIGH';}
			else{$float_res = 'LOW';}
		//4. Per Cell voltage : 1.85 Volts 
			$lvd_status = alias($ticket_alias,'ec_technical_observation','ticket_alias','voltage_regulation');
			$low_voltage_cutoff = alias($ticket_alias,'ec_technical_observation','ticket_alias','low_voltage_cutoff');
			$battery_lvd = alias($ticket_alias,'ec_battery_bank_bb_cap','ticket_alias','battery_bank_rating');
			$bb_lvd = preg_replace('/\D/', '', $battery_lvd);
			if($bb_lvd=='24'){ $diff_lvd = ($low_voltage_cutoff - 22.2); }
			elseif($bb_lvd=='48'){$diff_lvd = ($low_voltage_cutoff - 44.4); }
			if($lvd_status=='BYPASS'){$lvd_res = 'BYPASSED';}
			elseif(abs($diff_lvd)<='0.5'){$lvd_res = 'SET AT RIGHT VOLTAGE';}
			else{$lvd_res = 'SET AT WRONG VOLTAGE';}
		//5.
			$dg_status = alias($ticket_alias,'ec_general_observation','ticket_alias','dg_status');
			$dg_working_condition = alias($ticket_alias,'ec_general_observation','ticket_alias','dg_working_condition');
			if($dg_status=='NON DG'){$generator = 'NON DG';}
			else{
				if($dg_working_condition=='MANUAL'){$generator = 'MANUAL MODE';}
				else{$generator = 'AVAILABLE';}
			}
		//6.
			$temperature = alias($ticket_alias,'ec_physical_observation','ticket_alias','temperature');
			list($x,$y,$z)=explode("|",$temperature);
			if($y>30){$temp='HIGH';}
			elseif($y>24 && $y<30){$temp='NORMAL';}
			else{$temp='LOW';}
		//7.
			$mfd_date = alias($site_alias,'ec_sitemaster','site_alias','mfd_date');
			$install_date = alias($site_alias,'ec_sitemaster','site_alias','install_date');
			if(empty($mfd_date) || $mfd_date=='0000-00-00')$mfd_date = date('Y-m-d');
			if(empty($install_date) || $install_date=='0000-00-00')$install_date = date('Y-m-d');
			$date1 = new DateTime($mfd_date);
			$date2 = new DateTime($install_date);
			$diff_days = $date2->diff($date1)->format("%a");
			$months = floor($diff_days/30);
			$days = ($diff_days%30);
			if($months!=0){$abc = $months." MONTHS ";}
			if($days!=0){$abc .= $days." DAYS";}
			$storage_period  = $abc;
		//8.
			$site_load_res = ( $site_load <= ($a/10) ? 'MATCHED TO BATTERY' : 'MISMATCHED TO BATTERY');
		
		//9.
			$remsql=mysqli_query($mr_con,"SELECT remarks FROM ec_remarks WHERE id IN (SELECT MAX(id) FROM ec_remarks WHERE module='TT' AND item_alias='$ticket_alias' AND flag='0') AND flag='0'");
			$remrow=mysqli_fetch_array($remsql);
			$remarks=$remrow['remarks'];

			$to_mail_id = $cust_email;
			$sub = "Site Visited - ".$ticket_id." - ".date("d-m-Y");
			$zhsmail = '';
			$state_alias = alias($site_alias,'ec_sitemaster','site_alias','state_alias');
			$zhs_query = mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE state_alias LIKE '%". $state_alias ."%' AND privilege_alias='OX5E3EMI0U' AND flag='0'");
			if(mysqli_num_rows($zhs_query)){
				$zhs_row = mysqli_fetch_array($zhs_query);
				$zhsmail = $zhs_row['email_id'];
			}
			$semail = alias(alias($ticket_alias,'ec_tickets','ticket_alias','service_engineer_alias'),'ec_employee_master','employee_alias','email_id');
			$ccemail= "ticket@enersys.co.in".(!empty($zhsmail) && filter_var($zhsmail, FILTER_VALIDATE_EMAIL) ? ", ".$zhsmail : "").(!empty($semail) && filter_var($semail, FILTER_VALIDATE_EMAIL) ? ", ".$semail : "");
			$date = date('d-m-Y');
			$link = urlencode($ticket_alias."|".$status."|".$date."|".$remarks);
			
			$body = "<html><body>";
			$body.="<table width='800px' style='border-collapse:collapse;' cellpadding='3' align='center'>";
			
			$body.="<tr align='center'>";
			$body.="<th align='right' style='border:1px solid #ddd; border-bottom:1px solid #fff;'>";
			$body.="<a href='".baseurl()."mobile_app/print_site.php?a=".$link."' target='_blank'>Print</a>";
			$body.="</th>";
			$body.="</tr>";
			
			$body.="<tr align='center'>";
			$body.="<th align='center' style='border:1px solid #ddd; border-bottom:1px solid #fff;'>";
			$body.="<table width='100%'>";
			$body.="<tr>";
			$body.="<th align='left'><img src='".baseurl()."mobile_app/pdf/images/e_logo_r.png' alt='EnerSys_logo' width='150'></th>";
			$body.="<th align='right'><h3>EnerSys India Batteries Pvt. Ltd.</h3></th>";
			$body.="</tr>";
			$body.="</table>";
			$body.="</th>";
			$body.="</tr>";
			$body.="<tr>";
			$body.="<td align='center' style='border:1px solid #ddd;'>";
			$body.="<table width='100%' cellpadding='3'>";
			$body.="<tr>";
			$body.="<td align='right'><b>Date : </b>".$date."</td>";
			$body.="</tr>";
			$body.="<tr>";
			$body.="<td align='center'><u><h3>RECORD OF SITE CONDITIONS</h3></u></td>";
			$body.="</tr>";
			$body.="</table><br><br>";
			$body.="<table width='100%' cellpadding='3'>";
			$body.="<tr>";
			$body.="<td align='left'>Ref:  TT Number: <b>".$ticket_id."</b>, Ticket Status: <b>".$status."</b>, Site Name: <b>".$site_name."</b>, Job Performed: <b>".$job_performed."</b></td>";
			$body.="</tr>";
			$body.="</table><br>";
			$body.="<table width='100%' cellpadding='3'>";
			$body.="<tr>";
			$body.="<td align='left'>To,</td>";
			$body.="</tr>";
			$body.="<tr>";
			$body.="<td align='left'>Name : ".$cust_name."</td>";
			$body.="</tr>";
			$body.="<tr>";
			$body.="<td align='left'>Address : ".$site_address."</td>";
			$body.="</tr>";
			$body.="<tr>";
			$body.="<td align='left'>Number : ".$cust_contact_number."</td>";
			$body.="</tr>";
			$body.="<tr>";
			$body.="<td align='left'>Email : ".strtolower($cust_email)."</td>";
			$body.="</tr>";
			$body.="</table><br>";
			$body.="<table width='100%' cellpadding='4'>";
			$body.="<tr>";
			$body.="<td align='left'>Dear Sir/Madam,</td>";
			$body.="</tr>";
			$body.="<tr>";
			$body.="<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Following the visit to site, our Service Engineer had observed below site conditions which will affect the Battery Bank Performance:</td>";
			$body.="</tr>";
			$body.="</table><br>";
			$red = 0;
			$body .= "<table style='border-collapse:collapse;' cellpadding='8' align='center'>
			<tr><td width='40%'>1.&nbsp;&nbsp;SMPS Display				</td><td>:&nbsp;&nbsp;<span>".$smps_display."</span></td></tr>
			<tr><td>2.&nbsp;&nbsp;SMPS under capacity					</td><td>:&nbsp;&nbsp;<span ".color($base_final,'2').">".$base_final."</span></td></tr>
			<tr><td>3.&nbsp;&nbsp;Battery bank charging float voltages	</td><td>:&nbsp;&nbsp;<span ".color($float_res,'3').">".$float_res."</span></td></tr>
			<tr><td>4.&nbsp;&nbsp;LVDS cut-off							</td><td>:&nbsp;&nbsp;<span ".color($lvd_res,'4').">".$lvd_res."</span></td></tr>
			<tr><td>5.&nbsp;&nbsp;Generator								</td><td>:&nbsp;&nbsp;<span ".color($generator,'5').">".$generator."</span></td></tr>
			<tr><td>6.&nbsp;&nbsp;Battery cabinet / Room Temperature	</td><td>:&nbsp;&nbsp;<span ".color($temp,'6').">".$temp."</span></td></tr>
			<tr><td>7.&nbsp;&nbsp;Storage period before installation	</td><td>:&nbsp;&nbsp;<span ".color($storage_period,'7').">".$storage_period."</span></td></tr>
			<tr><td>8.&nbsp;&nbsp;Load Current							</td><td>:&nbsp;&nbsp;<span ".color($site_load_res,'8').">".$site_load_res."</span></td></tr>
			<tr><td>9.&nbsp;&nbsp;Remarks								</td><td>:&nbsp;&nbsp;<span>".str_replace(",",", ",$remarks)."</span></td></tr>
			</table><br>";
			
			$body.="<table width='100%' cellpadding='8'>";
			$body.="<tr>";
			$body.="<td align='left'>For details please go through the e-FSR Enclosed <a href='".baseurl()."mobile_app/pdf/index.php?ticket_alias=".$ticket_alias."' target='_blank'>Click here</a></td>";
			$body.="</tr>";
			if($red > 1){
				$body.="<tr>";
				$body.="<td align='left'><u><b>Because of the above site conditions, the performance of our battery will be affected and failure to set right the conditions will result in our warranty being null and void..</b></u></td>";
				$body.="</tr>";
			}
			$body.="<tr>";
			$body.="<td align='left'>We have extended our best possible service support, in spite of the above site conditions.</td>";
			$body.="</tr>";
			$body.="<tr>";
			$body.="<td align='left'>Hope we have clarified all the issues, we are requesting to kindly rectify the parameters and conditions at site as per our VRLA batteries installation, operational and maintenance manual for optimal life and performance of VRLA batteries.</td>";
			$body.="</tr>";
			if($red > 1){
				$body.="<tr>";
				$body.="<td align='left'><b>Should you require our services to set right the above, we would be happy to send you our quote for the services.<b></td>";
				$body.="</tr>";
			}
			$body.="</table><br>";
			
			$body.="<table width='100%' cellpadding='3'>";
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
			$body.="</td>";
			$body.="</tr>";
			$body.="</table>";
			$body.="<p>If you have any concerns please feel free to write us to service@enersys.co.in or Call us at 040-6704 6704</p><br>";
			$body.="<p style='font-style:italic;text-align:center;'><small>*** This is a System generated email, Please do not reply ***</small></p>";
			$body.="</body></html>";
			
			$logName = $ticket_alias;
			$to = $cust_email;
			ecSendMails("efsr_submit", $state_alias, $sub, $body, $to, $logName, "EFSR");

	}
?>