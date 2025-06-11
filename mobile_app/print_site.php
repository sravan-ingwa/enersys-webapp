<style>
	.ener-header{font-size:15px; margin:3px;}
	.ener-add{font-size:12px; margin:1px;}
	.ener-foot{font-size:12px; font-weight:600;}
	body{font-family:Calibri;}
	.ener-cin{margin:0px 0px 3px 10px; font-size:12px; font-family:sans-serif; font-weight:400;}
	.ener-address{width:210px; word-break: break-word; display:inline-block;}
</style>
<?php
	date_default_timezone_set("Asia/Kolkata");
	include ('../services/mysql.php');
	function baseurl(){ return "https://enersyscare.co.in/";}
	function alias($alias,$tb,$col,$retrive){ global $mr_con;
		$sql = mysqli_query($mr_con,"SELECT $retrive FROM $tb WHERE $col='$alias' AND flag=0");
		if(mysqli_num_rows($sql)){
			$row = mysqli_fetch_array($sql);
			return $row[$retrive];
		}else return '0';
	}
	function get_string_between($string, $start, $end){
		$string = " ".$string;
		$ini = strpos($string,$start);
		if ($ini == 0) return "";
		$ini += strlen($start);
		$len = strpos($string,$end,$ini) - $ini;
		return substr($string,$ini,$len);
	}
	$link = urldecode($_REQUEST['a']);
	list($ticket_alias,$status,$date,$remarks) = explode("|",$link);
	//$ticket_alias=$_REQUEST['a'];
	//$ticket_alias='7YTDFL6UFT';
	$site_alias = alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
	//Ref
		$ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
		//$status = alias($ticket_alias,'ec_tickets','ticket_alias','status');
		$site_name = alias($site_alias,'ec_sitemaster','site_alias','site_name');
		$site_address = alias($site_alias,'ec_sitemaster','site_alias','site_address');
		$job_performed = alias($ticket_alias,'ec_engineer_observation','ticket_alias','job_performed');
	//To
		$cust_name = alias($ticket_alias,'ec_e_signature','ticket_alias','name');
		$cust_contact_number = alias($ticket_alias,'ec_e_signature','ticket_alias','contact_number');
		
		$clust_manager_mail = alias($site_alias,'ec_sitemaster','site_alias','manager_mail');
		$em = alias($ticket_alias,'ec_e_signature','ticket_alias','email');

		$cust_email =(!empty($em) && filter_var($em, FILTER_VALIDATE_EMAIL) ? $em :  $clust_manager_mail);
		
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
		/*$remsql=mysqli_query($mr_con,"SELECT remarks FROM ec_remarks WHERE id IN (SELECT MAX(id) FROM ec_remarks WHERE module='TT' AND item_alias='$ticket_alias' AND flag='0') AND flag='0'");
		$remrow=mysqli_fetch_array($remsql);
		$remarks=$remrow['remarks'];*/

	$body = "<html><body>";
	$body.="<table width='800px' style='border-collapse:collapse;' cellpadding='3' align='center'>";
		$body.="<tr align='center'>";
			$body.="<th align='center' style='border:1px solid #ddd; border-bottom:1px solid #fff;'>";
				$body.="<table width='100%' style='border-bottom:1px solid #000'>";
					$body.="<tr>";
						$body.="<th align='left'>
								<img src='".baseurl()."mobile_app/pdf/images/e_logo_r.png' alt='EnerSys_logo' height='80' width='150'>
								<p class='ener-cin'>CIN NO : U74999TG2007PTC052642</p>
								<p class='ener-cin'>E-Mail ID : service@enersys.co.in</p>
								</th>";
						$body.="<th align='right'>
								<p class='ener-header'>EnerSys India Batteries Private Limited</p>
								<p class='ener-add'>Factory : Narasimha Rao Palem (V), Veerullapadu (M),</p>
								<p class='ener-add'>Krishna Dist-521 181, Andhara Pradesh, India.</p>
								<p class='ener-add'>Ph: +91 8678201214/15</p>
								<p class='ener-add'>Fax: +91 8678 201 237</p>
								<p class='ener-add'>www.enersys.co.in</p>
								</th>";
					$body.="</tr>";
				$body.="</table>";
			$body.="</th>";
		$body.="</tr>";
		$body.="<tr>";
			$body.="<td align='center' style='border:1px solid #ddd;'>";
				$body.="<table width='100%'>";
					$body.="<tr>";
						$body.="<td align='right' style='font-size:13px;'><b>Date : </b>".$date."</td>";
					$body.="</tr>";
				$body.="</table>";	
				$body.="<table width='100%' style='font-size:13px;'>";
					$body.="<tr>";
						$body.="<td align='left'>To,</td>";
					$body.="</tr>";
					$body.="<tr>";
						$body.="<td>Mr/Mrs ".$cust_name."</td>";
					$body.="</tr>";
					$body.="<tr>";
						$body.="<td><span class='ener-address'>".$site_address."</span></td>";
					$body.="</tr>";
					$body.="<tr>";
						$body.="<td>+91 ".$cust_contact_number."</td>";
					$body.="</tr>";
					$body.="<tr>";
						$body.="<td>".$cust_email."</td>";
					$body.="</tr>";
				$body.="</table>";
				
				$body.="<table width='100%' cellpadding='2'>";
					$body.="<tr>";
						$body.="<td align='center'><u><h5 style='margin:2px;'>RECORD OF SITE CONDITIONS</h5></u></td>";
					$body.="</tr>";
				$body.="</table>";
				
				$body.="<table width='100%' cellpadding='3'>";
					$body.="<tr>";
						$body.="<td align='left'>Ref:  TT Number: <b>'".$ticket_id."'</b>, Ticket Status: <b>'".$status."'</b>, Site Name: <b>'".$site_name."'</b>, Job Performed: <b>'".$job_performed."'</b></td>";
					$body.="</tr>";
				$body.="</table>";
				
				$body.="<table width='100%' cellpadding='3'>";
					$body.="<tr>";
						$body.="<td align='left'>Dear Sir/Madam,</td>";
					$body.="</tr>";
					$body.="<tr>";
						$body.="<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Following the visit to site, our Service Engineer had observed below site conditions which will affect the Battery Bank Performance:</td>";
					$body.="</tr>";
				$body.="</table>";
				
				$body .= "<table style='border-collapse:collapse; font-size:13px;margin-left:80px;' cellpadding='3' align='left'>
					<tr><td width='40%'>1.&nbsp;&nbsp;SMPS Display</td><td>:&nbsp;&nbsp;<b>".$smps_display."</b></td></tr>
					<tr><td>2.&nbsp;&nbsp;SMPS under capacity</td><td>:&nbsp;&nbsp;<b>".$base_final."</b></td></tr>
					<tr><td>3.&nbsp;&nbsp;Battery bank charging float voltages</td><td>:&nbsp;&nbsp;<b>".$float_res."</b></td></tr>
					<tr><td>4.&nbsp;&nbsp;LVDS cut-off</td><td>:&nbsp;&nbsp;<b>".$lvd_res."</b></td></tr>
					<tr><td>5.&nbsp;&nbsp;Generator</td><td>:&nbsp;&nbsp;<b>".$generator."</b></td></tr>
					<tr><td>6.&nbsp;&nbsp;Battery cabinet / Room Temperature</td><td>:&nbsp;&nbsp;<b>".$temp."</b></td></tr>
					<tr><td>7.&nbsp;&nbsp;Storage period before installation</td><td>:&nbsp;&nbsp;<b>".$storage_period."</b></td></tr>
					<tr><td>8.&nbsp;&nbsp;Load Current</td><td>:&nbsp;&nbsp;<b>".$site_load_res."</b></td></tr>
					<tr><td>9.&nbsp;&nbsp;Remarks</td><td>:&nbsp;&nbsp;<b>".str_replace(",",", ",$remarks)."</b></td></tr>
					</table><br>";					
				$body.="<table width='100%' cellpadding='5'>";
					/*$body.="<tr>";
						$esca_efsr_link = alias($ticket_alias,'ec_tickets','ticket_alias','esca_efsr_link');
						$link = (!empty($esca_efsr_link) ? "images/esca_efsr/".$esca_efsr_link : "enersyscare_V2/pdf/?ticket_alias=".$ticket_alias);
						$body.="<td align='left'>For details please go through the e-FSR Enclosed <a href='".baseurl().$link."' target='_blank'>Click here</a></td>";
					$body.="</tr>";*/
					$body.="<tr>";
						$body.="<td align='left'>We have extended our best possible service support, in spite of the above site conditions.</td>";
					$body.="</tr>";
					$body.="<tr>";
						$body.="<td align='left'>Hope we have clarified all the issues, we are requesting to kindly rectify the parameters and conditions at site as per our VRLA batteries installation, operational and maintenance manual for optimal life and performance of VRLA batteries.</td>";
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
							         <p class='ener-foot'>Registered Office :EnerSys India Batteries Private Limited, Survey N.118,135,137 & 139, Narasimharaopalem (Village),Veerullapadu (Mandal), VIJAYAWADA ,Krishna (District),
									 Andhra Pradesh-521181, India, Ph :9652525292,E-Mail : service@enersys.co.in</p>
									</td>";
						$body.="</tr>";
					$body.="</tfoot>";
				$body.="</table>";
			$body.="</td>";
		$body.="</tr>";
	$body.="</table>";
	$body.="<p>If you have any concerns please feel free to write us to service@enersys.co.in or Call us at 040-6704 6704</p><br>";
	$body.="<p style='font-style:italic;text-align:center;'><small>*** This is system generated document no signature required ***</small></p>";
	$body.="</body></html>";
	echo $body;
	echo "<script>window.print();</script>";
?>