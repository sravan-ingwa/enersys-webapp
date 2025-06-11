<?php
include('v2/services/mysql.php');
include('v2/services/functions.php');
echo zhs_nhs_decline_mail1('SZLGLZDWZP');
function ticket_declined_mail1($ticket_alias){ global $mr_con;
	$ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
	$site_alias = alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
	date_default_timezone_set("Asia/Kolkata");
	$sql = mysqli_query($mr_con,"SELECT manager_mail,manager_name,state_alias FROM ec_sitemaster where site_alias='$site_alias' AND flag='0'");
	$row=mysqli_fetch_array($sql);
	$to = (!empty($row['manager_mail']) && filter_var($row['manager_mail'], FILTER_VALIDATE_EMAIL) ? $row['manager_mail'] : "ticket@enersys.co.in");
	$state_alias = $row['state_alias'];
	$sqlEsca = mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='OX5E3EMI0U' AND state_alias LIKE '%$state_alias%' AND flag='0'");
	if(mysqli_num_rows($sqlEsca)>0){
		$rowesca=mysqli_fetch_array($sqlEsca);
		$em = $rowesca['email_id'];
		$ccemail= "ticket@enersys.co.in".(!empty($em) && filter_var($em, FILTER_VALIDATE_EMAIL) ? ", ".$em : "");
	}else{
		$ccemail= "ticket@enersys.co.in";
	}
	$sub = "Ticket Declined - ".$ticket_id." - ".date("d-m-Y");
	$sqlTT = mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE ticket_id='".$ticket_id."' AND flag='0'");
	if(mysqli_num_rows($sqlTT)>0){
		$rowTT=mysqli_fetch_array($sqlTT);
		$head=array("Ticket ID","Login Date","Activity","Zone","State","District","Site ID","Site Name","Site Type","Product","Battery Bank Rating","No Of Strings","Segment","Customer Name","Manufacturing Date","Installation Date","Technician Name","Technician Number","Manager Name","Manager Number","Manager email","Site Address","MOC","Closing Date","Ticket Status","Site Status","Faulty Cell Count","Complete Observation","TAT","Complaint","Level","Remarks");
		if(!empty($rowTT['planned_date'])){ array_splice($head, 2, 0, "Planned Date"); $chk = 24;}else{$chk = 23;}
		if(!empty($rowTT['service_engineer_alias'])){ array_splice($head, $chk, 0, "Service Engineer"); }
		if(!empty($rowTT['milestone'])){array_push($head,"Milestone");}
		if(!empty($rowTT['efsr_no'])){array_push($head,"efsr No","efsr Date");}
		$content[]=$rowTT['ticket_id'];
		$content[]=($rowTT['login_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['login_date']))));
		if(!empty($rowTT['planned_date'])){ $content[]=($rowTT['planned_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['planned_date']))));}
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
			
			$content[]=$rowSite['battery_bank_rating'];
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
		if(!empty($rowTT['service_engineer_alias'])){ $content[]=alias($rowTT['service_engineer_alias'],'ec_employee_master','employee_alias','name'); }
		$content[]=($rowTT['closing_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['closing_date']))));
		$content[]=$rowTT['status'];
		$content[]=(sitemanfdate_check($site_alias)>0 ? 'UNDER WARRANTY' : 'OUT OF WARRANTY');
		$content[]=$rowTT['faulty_cell_count'];
		$content[]=$rowTT['description'];
		$content[]=tat($ticket_alias);
		$content[]=alias($rowTT['complaint_alias'],'ec_complaint','complaint_alias','complaint_name');
		$content[]=alias($rowTT['level'],'ec_levels','level_alias','level_name');
		$remsql=mysqli_query($mr_con,"SELECT remarks FROM ec_remarks WHERE id IN (SELECT MAX(id) FROM ec_remarks WHERE module='TT' AND item_alias='$ticket_alias' AND flag='0') AND flag='0'");
		$remrow=mysqli_fetch_array($remsql);
		$content[]=strtoupper($remrow['remarks']);
		if(!empty($rowTT['milestone'])){ $content[]=alias($rowTT['milestone'],'ec_milestone','mile_stone_alais','mile_stone');}
		if(!empty($rowTT['efsr_no'])){
			$content[]=$rowTT['efsr_no'];
			$content[]=$rowTT['efsr_date'];
		}
	}
	$body="<p>Dear ".ucfirst($row['manager_name']).",</p>";
	$body.="<p>The Ticket has been Declined in ".strtoupper(alias($row['state_alias'],'ec_state','state_alias','state_name'))." State. Below are the details of Ticket.</p>";
	$body.="<h3 style='background:#2a6496;color:#FFF;padding:0 5px;line-height:30px;font-size:16px;'>Ticket Details</h3>";
	$body.="<table style='border-collapse:collapse;width:100%;'>";
	$c=count($head);
	for($a=0;$a<$c;$a++){
		$body.="<tr>";
		for($b=$a;$b<=$a+1;$b++){
			$body.="<td style='padding:2px 5px;text-align:justify;border:1px solid #000;'>
			<h4 style='display:block;color:#2a6496;font-weight:bold; margin:0;padding:2px;'>".ucfirst($head[$b])."</h4>
			<p style='display:block;margin:0;padding:1px;'>".ucfirst($content[$b])."</p>
			</td>";
		}
		$a++;
		$body.="</tr>";
	}
	$body.="<p style='font-style:italic;font-size:12px;'>*** This is a System generated email, Please do not reply ***</p>";

	return $body;
}
function zhs_nhs_decline_mail1($ticket_alias){ global $mr_con;
	$site_alias = alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
	$segment_alias = alias($site_alias,'ec_sitemaster','site_alias','segment_alias');
	if($segment_alias=='HXL5A1HOTZ'){ // Only for Telecom segment.
		//Ref
		$ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
		$status = alias($ticket_alias,'ec_tickets','ticket_alias','status');
		$site_name = alias(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','site_name');
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
		if($bb_float=='24'){ $bb_diff = ($float_voltage - 27); }
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
		if(isset($mfd_date) && !empty($mfd_date))$date1 = new DateTime($mfd_date);else $date1 = date('Y-m-d');
		if(isset($install_date) && !empty($install_date))$date2 = new DateTime($install_date);else $date2 = date('Y-m-d');
		$diff_days = $date2->diff($date1)->format("%a");
		$months = floor($diff_days/30);
		$days = ($diff_days%30);
		if($months!=0){$abc = $months." MONTHS ";}
		if($days!=0){$abc .= $days." DAYS";}
		$storage_period  = $abc;
		
		
		//8.
		$site_load_res = ( $site_load <= ($a/10) ? 'MATCHED TO BATTERY' : 'MISMATCHED TO BATTERY');
		
		$to = $cust_email;
		$sub = "Ticket Declined - ".$ticket_id." - ".date("d-m-Y");
		$ccemail= "ticket@enersys.co.in";

		$body = "<html><body>";
		$body.="<table width='800px' style='border-collapse:collapse;' cellpadding='3' align='center'>";
			$body.="<tr align='center'>";
				$body.="<th align='center' style='border:1px solid #ddd; border-bottom:1px solid #fff;'>";
					$body.="<table width='100%'>";
						$body.="<tr>";
							$body.="<th align='left'><img src='http://enersyscare.co.in/enersys_expense/img/EnerSyslogo.png' alt='EnerSys_logo' width='150'></th>";
							$body.="<th align='right'><h3>EnerSys India Batteries Pvt. Ltd.</h3></th>";
						$body.="</tr>";
					$body.="</table>";
				$body.="</th>";
			$body.="</tr>";
			$body.="<tr>";
				$body.="<td align='center' style='border:1px solid #ddd;'>";
					$body.="<table width='100%' cellpadding='3'>";
						$body.="<tr>";
							$body.="<td align='right'><b>Date : </b>".date('d-m-Y')."</td>";
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
							$body.="<td align='left'>Number : ".$cust_contact_number."</td>";
						$body.="</tr>";
						$body.="<tr>";
							$body.="<td align='left'>Email : ".$cust_email."</td>";
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
					
					$body .= "<table style='border-collapse:collapse;' cellpadding='8' align='center'>
						<tr><td>1.&nbsp;&nbsp;SMPS Display							</td><td>:&nbsp;&nbsp;<b ".color($smps_display,'1').">".$smps_display."</b></td></tr>
						<tr><td>2.&nbsp;&nbsp;SMPS under capacity					</td><td>:&nbsp;&nbsp;<b ".color($base_final,'2').">".$base_final."</b></td></tr>
						<tr><td>3.&nbsp;&nbsp;Battery bank charging float voltages	</td><td>:&nbsp;&nbsp;<b ".color($float_res,'3').">".$float_res."</b></td></tr>
						<tr><td>4.&nbsp;&nbsp;LVDS cut-off							</td><td>:&nbsp;&nbsp;<b ".color($lvd_res,'4').">".$lvd_res."</b></td></tr>
						<tr><td>5.&nbsp;&nbsp;Generator								</td><td>:&nbsp;&nbsp;<b ".color($generator,'5').">".$generator."</b></td></tr>
						<tr><td>6.&nbsp;&nbsp;Battery cabinet / Room Temperature	</td><td>:&nbsp;&nbsp;<b ".color($temp,'6').">".$temp."</b></td></tr>
						<tr><td>7.&nbsp;&nbsp;Storage period before installation	</td><td>:&nbsp;&nbsp;<b ".color($storage_period,'7').">".$storage_period."</b></td></tr>
						<tr><td>8.&nbsp;&nbsp;Load Current							</td><td>:&nbsp;&nbsp;<b ".color($site_load_res,'8').">".$site_load_res."</b></td></tr>
						</table><br>";
						
					$body.="<table width='100%' cellpadding='8'>";
						$body.="<tr>";
							$body.="<td align='left'>For details please go through the e-FSR Enclosed <a href='http://enersyscare.co.in/enersyscare_V2/pdf/?ticket_alias=".$ticket_alias."' target='_blank'>Click here</a></td>";
						$body.="</tr>";
						$body.="<tr>";
							$body.="<td align='left'><b><u>Because of the above site conditions, the performance of our battery will be affected and failure to set right the conditions will result in our warranty being null and void..</u></b></td>";
						$body.="</tr>";
						$body.="<tr>";
							$body.="<td align='left'>We have extended our best possible service support, in spite of the above site conditions.</td>";
						$body.="</tr>";
						$body.="<tr>";
							$body.="<td align='left'>Hope we have clarified all the issues, we are requesting to kindly rectify the parameters and conditions at site as per our VRLA batteries installation, operational and maintenance manual for optimal life and performance of VRLA batteries.</td>";
						$body.="</tr>";
						$body.="<tr>";
							$body.="<td align='left'>Should you require our services to set right the above, we would be happy to send you our quote for the services.</td>";
						$body.="</tr>";
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
		$body.="<p style='font-style:italic;text-align:center;'><small>*** This is a System generated email, Please do not reply ***</small></p>";
		$body.="</body></html>";
		return $body;
	}else{ return ticket_declined_mail1($ticket_alias); }
}
/*  $new_privilege_type = 'Stock';	
	$sql = mysqli_query($mr_con,"SELECT privilege_alias,privilege_name FROM ec_privileges where flag='0' GROUP BY privilege_alias");
	while($row=mysqli_fetch_array($sql)){ $alias_arr[] = $row['privilege_alias']; $name_arr[] = $row['privilege_name'];}
	$sql1 = mysqli_query($mr_con,"SELECT privilege_item FROM ec_privileges where flag='0' GROUP BY privilege_item");
	while($row1=mysqli_fetch_array($sql1)){ $item_arr[] = $row1['privilege_item'];}
	for($i=0;$i<count($alias_arr);$i++){
		for($j=0;$j<count($item_arr);$j++){
			$sql=mysqli_query($mr_con,"INSERT INTO ec_privileges(privilege_name,privilege_item,privilege_type,grantable,privilege_alias) VALUES('$name_arr[$i]','$item_arr[$j]','$new_privilege_type','No','$alias_arr[$i]')");
		}
	}*/
	/*$to='naresh.nampelly@gmail.com';
	$sub='test';
	$body='Hai';
	$from='naresh@mymgs.com';
	$ccemail=$from;
	$header = "MIME-Version: 1.0" . "\r\n";
	$header .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	//$header .= "X-Mailer: PHP/" . phpversion();
	$header .= 'From: EnerSys Care <'.$from .'>' . "\r\n";
	$header .= 'BCc: '.$ccemail.'' . "\r\n";
	$abc = mail($to, $sub, $body, $header);
	if($abc)echo TRUE;else echo FALSE;*/
//include('mysql.php');
/*echo createMail();
function createMail(){
date_default_timezone_set("Asia/Kolkata");
	$to = 'naresh@mymgs.com';
	$ccemail= "naresh.nampelly@gmail.com";
	$sub = "New Ticket - abc - ".date("d-m-Y");
	$body="<p>Dear ".ucfirst('mahesh').",</p>";
	$body.="<p>A New Ticket has been Registered in ".strtoupper('andrapradesh')." Circle. Below are the details of Ticket.</p>";
	$body.="<h3 style='background:#2a6496;color:#FFF;padding:0 5px;line-height:30px;font-size:16px;'>Ticket Details</h3>";
	$body.="<table style='border-collapse:collapse;width:100%;'>";
	$body.="<tr>";
	$body.="<td style='padding:2px 5px;text-align:justify;border:1px solid #000;'>
	<h4 style='display:block;color:#2a6496;font-weight:bold; margin:0;padding:2px;'>".ucfirst('hai')."</h4>
	<p style='display:block;margin:0;padding:1px;'>".ucfirst('hai')."</p>
	</td>";
	$body.="</tr>";
	$body.="</table><br>";
	$body.="<p style='font-style:italic;font-size:12px;'>*** This is a System generated email, Please do not reply ***</p>";
	$from = 'naresh.nampelly29@gmail.com';
	$header= 'From: EnerSys Care <'.$from .'>' . "\r\n";
	$header.= 'Cc:'.$ccemail."\r\n";
	$header.= 'Reply-To: '.$from ."\r\n";
	$header.= "Content-Type: text/html\r\n";
	$header.= "X-Mailer: PHP/" . phpversion();
	$header.= 'MIME-Version: 1.0' . "\r\n";
	$admin = "-odb -f $from";
	$abc = mail($to, $sub, $body, $header, $admin);
	if($abc)return 'Success';else return 'Un Success';
}*/
/*function mailsent(){
	$to = 'naresh@mymgs.com';
	$ccemail= "naresh.nampelly@gmail.com, naresh.nampelly29@gmail.com";
	$sub = "Ticket Closed - XYZ - ".date("d-m-Y");
	$body="<p>Dear ".ucfirst('naresh').",</p>";
	$body.="<p>A Ticket has been Closed in ".strtoupper('telangana')." Circle. Below are the details of Ticket.</p>";
	$body.="<h3 style='background:#2a6496;color:#FFF;padding:0 5px;line-height:30px;font-size:16px;'>Ticket Details</h3>";
	$body.="<table style='border-collapse:collapse;width:100%;'>";
	$body.="<td style='padding:2px 5px;text-align:justify;border:1px solid #000;'>
	<h4 style='display:block;color:#2a6496;font-weight:bold; margin:0;padding:2px;'>".ucfirst('adsf')."</h4>
	<p style='display:block;margin:0;padding:1px;'>".ucfirst('jksdf')."</p>
	</td>";
	$body.="</tr>";
	$body.="</table><br>";
	$body.="<p style='font-style:italic;font-size:12px;'>*** This is a System generated email, Please do not reply ***</p>";
	$from = 'naresh@mymgs.com';
	$header= 'From: EnerSys Care <'.$from .'>' . "\r\n";
	$header.= 'Cc:'.$ccemail."\r\n";
	$header.= 'Reply-To: '.$from ."\r\n";
	$header.= "Content-Type: text/html\r\n";
	$header.= "X-Mailer: PHP/" . phpversion();
	$header.= 'MIME-Version: 1.0' . "\r\n";
	$admin = "-odb -f $from";
	$abc = mail($to, $sub, $body, $header, $admin);
	if($abc)return 'Success';else return 'Un Success';
}*/
//$ip = $_SERVER['REMOTE_ADDR'];echo $ip;

/*$to = "jaganbabu@mymgs.com";
$from = "naresh.nampelly@gmail.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: feedback@enersys.co.in" . "\r\n";// . "CC: jagan87_babu@yahoo.com";
//$headers .= "Disposition-Notification-To: ". $from ."\r\n";
//$headers .= "Read-Receipt-To: ". $from ."\r\n";
//$headers .= "X-Confirm-Reading-To: ". $from ."\r\n";
if(mail($to,$subject,$txt,$headers))echo "Sent"; else echo "Not Sent";*/
/*
if(isset($_REQUEST['sub'])){
	$bill=$_REQUEST['bill'];
	$query = mysql_query("SELECT id FROM ss_book_expenses WHERE billNo='$bill' AND flag=0");
	$row=mysql_fetch_array($query);
	$fare = mysql_query("SELECT SUM(amount) FROM ss_book_expenses_fare WHERE refId='$row[id]' AND flag=0");
	$hotel = mysql_query("SELECT SUM(amount) FROM ss_book_expenses_hotel WHERE refId='$row[id]' AND flag=0");
	$local = mysql_query("SELECT SUM(amount) FROM ss_book_expenses_local WHERE refId='$row[id]' AND flag=0");
	$other = mysql_query("SELECT SUM(amount) FROM ss_book_expenses_other WHERE refId='$row[id]' AND flag=0");
	
	$f=mysql_fetch_array($fare);
	$h=mysql_fetch_array($hotel);
	$l=mysql_fetch_array($local);
	$o=mysql_fetch_array($other);
	echo $f[0]." , ".$h[0]." , ".$l[0]." , ".$o[0];
	//mysql_query("SELECT amount  FROM ss_book_expenses WHERE id='$row[id]' AND flag=0");
}*/
/*if(isset($_REQUEST['sub'])){
	$bill=$_REQUEST['bill'];
	$query = mysql_query("SELECT id FROM ss_book_expenses WHERE billNo='$bill' AND flag=0");
	$row=mysql_fetch_array($query);
	mysql_query("DELETE FROM ss_book_expenses_fare WHERE refId='$row[id]' AND flag=0");
	mysql_query("DELETE FROM ss_book_expenses_hotel WHERE refId='$row[id]' AND flag=0");
	mysql_query("DELETE FROM ss_book_expenses_local WHERE refId='$row[id]' AND flag=0");
	mysql_query("DELETE FROM ss_book_expenses_other WHERE refId='$row[id]' AND flag=0");
	mysql_query("DELETE FROM ss_book_expenses WHERE id='$row[id]' AND flag=0");
}*/
/*
echo billNo();
function billNo(){
	$sql = mysql_query("SELECT billNo FROM ss_book_expenses");
while($tt = mysql_fetch_array($sql)){
	$sql1 = mysql_query("SELECT billNo FROM ss_book_expenses WHERE billNo='".$tt['billNo']."'");
	if(mysql_num_rows($sql1)>=2){ $arr[]=$tt['billNo'];}
}
	if(count($arr)==0){ return "Not Duplicate bills";}
	else{return count($arr); }
}*/
/*echo billNo(1);
function billNo($i){
	$sql = mysql_query("SELECT billNo FROM ss_book_expenses");
	$num = (mysql_num_rows($sql)+$i);
	if($num > 999){$x = "BN".$num;}
	elseif($num > 99){$x = "BN0".$num;}
	elseif($num > 9){$x = "BN00".$num;}
	else{$x = "BN000".$num;}
	$sql1 = mysql_query("SELECT billNo FROM ss_book_expenses WHERE billNo='$x'");
	if(mysql_num_rows($sql1)==0){ return $x;}
	else{return billNo(($i+1)); }
}*/

/*
echo ticketsID('AP',1);
function ticketsID($circle,$i){
	$sql = mysql_query("SELECT ticketId FROM ss_tickets");
	$num = (mysql_num_rows($sql)+$i);
	if($num > 999){$x = "TT".$circle."".$num;}
	elseif($num > 99){$x = "TT".$circle."0".$num;}
	elseif($num > 9){$x = "TT".$circle."00".$num;}
	else{$x = "TT".$circle."000".$num;}
	$newTT = preg_replace('/\D/', '', $x); 
	while($tt = mysql_fetch_array($sql)){
		$oldTT = preg_replace('/\D/', '', $tt['ticketId']);
		if($oldTT==$newTT){ $arr[] = $oldTT;}
	}
	if(count($arr)==0){ return $x; }
	else{return ticketsID($circle,($i+1)); }
}*/
/*
$f = 'F2';
$s = mysql_query("SELECT empId FROM ss_el_expense WHERE flag='0' GROUP BY empId");
while($ss = mysql_fetch_array($s)){ $b = $ss['empId']; $clr1 =0; $clr2=0;  $netExp1 =0; $netExp2=0;
	$sqlf1 = mysql_query("SELECT advCleared FROM ss_book_advance WHERE empId='$b' AND advFor='F1' AND stat='2' AND flag='0'");
	while( $rowf1=mysql_fetch_array($sqlf1)){ $clr1 += $rowf1['advCleared'];}
	$sqlf2 = mysql_query("SELECT advCleared FROM ss_book_advance WHERE empId='$b' AND advFor='F2' AND stat='2' AND flag='0'");
	while( $rowf2=mysql_fetch_array($sqlf2)){ $clr2 += $rowf2['advCleared'];}
	$sqlexp1 = mysql_query("SELECT netExpensesBooked FROM ss_book_expenses WHERE empId='$b' AND period LIKE '%F1%' AND stat='2' AND flag='0'");
	while($rowexp1=mysql_fetch_array($sqlexp1)){$netExp1 += $rowexp1['netExpensesBooked'];}
	$sqlexp2 = mysql_query("SELECT netExpensesBooked FROM ss_book_expenses WHERE empId='$b' AND period LIKE '%F2%' AND stat='2' AND flag='0'");
	while($rowexp2=mysql_fetch_array($sqlexp2)){$netExp2 += $rowexp2['netExpensesBooked'];}
	$tfb = $clr1 + $clr2 - ($netExp1 + $netExp2);
	if($f=="F1"){ $rfb1 = $clr1 - $netExp1;
		$ac = mysql_query("UPDATE ss_el_expense SET f1Balance='$rfb1', totalBalance='$tfb' WHERE empId='$b'");
	}else{$rfb2 = $clr2 - $netExp2;
		$ac = mysql_query("UPDATE ss_el_expense SET f2Balance='$rfb2', totalBalance='$tfb' WHERE empId='$b'");
	}
}*/
/*date_default_timezone_set("Asia/Kolkata");
$c = date('Y-m-d H:i:s');
$a = mysql_query("SELECT closingDate,ticketId FROM `ss_tickets` WHERE `closingDate` > '$c'");
while($b=mysql_fetch_array($a)){
//mysql_query("UPDATE `ss_tickets` SET closingDate=visitedby WHERE errorMessage='Ticket Closed' AND ticketStatus='Closed' AND `closingDate` > '$c'");
echo $b['ticketId'].", ".$b['closingDate']."<br>";
}*/
?>
<!--<form method="POST">
<input type="text" name="bill">
<input type="submit" name="sub">
</form>-->