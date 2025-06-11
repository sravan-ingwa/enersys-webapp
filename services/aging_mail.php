<?php
date_default_timezone_set("Asia/Kolkata");
include ('mysql.php');
include ('functions.php');

	set_time_limit(0);
	$sqlTT = mysqli_query($mr_con,"SELECT site_alias,ticket_alias,level FROM ec_tickets WHERE ((level='1' AND login_date <= DATE_SUB(NOW(),INTERVAL 6 HOUR)) OR (level='2' AND planned_date < '".date('Y-m-d')."') OR (level='3' AND efsr_date <= DATE_SUB(NOW(),INTERVAL 6 HOUR)) OR level='4') AND flag='0' ORDER BY level");
	if(mysqli_num_rows($sqlTT)){
		$email_ids=array();
		$i=0;
		$privs = getPrivilegesForEmailAndSMSSettings('email','aging_inactive_6hrs');
		while($rowTT = mysqli_fetch_array($sqlTT)) {
			$state_alias = alias($rowTT['site_alias'],'ec_sitemaster','site_alias','state_alias');
			$ticket_alias=$rowTT['ticket_alias'];
			$level=$rowTT['level'];
			if($level!='4') {
				echo aging_mail($ticket_alias,$level);
			} else {
				$remarksQuery = "SELECT id FROM ec_remarks WHERE module='TT' AND item_alias='$ticket_alias' AND remarked_on <= DATE_SUB(NOW(),INTERVAL 6 HOUR) AND bucket IN('1','2','9','11') AND flag='0'";
				$sqlRem = mysqli_query($mr_con, $remarksQuery);
				if(mysqli_num_rows($sqlRem)){
					echo aging_mail($ticket_alias,$level);
				}
			}
			$i++;
		}
	}
function email_check($email){
	return (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) ? TRUE : FALSE);
}
function subject_body($ticket_alias,$level){ global $mr_con;
	switch($level){
		case '1': $fetch="login_date";$return="Inactive_activate the";break;
		case '2': $fetch="planned_date";$return="Plan Failed_replan the";break;
		case '3': $fetch="efsr_date";$return="ZHS Pending_Clear the ZHS pending";break;
		case '4': $fetch="id";$return="NHS Pending_Clear the NHS pending";break;
		default : $fetch="login_date";$return="Inactive_activate the";
	}
	if($level!='4'){ $min_date = alias($ticket_alias,'ec_tickets','ticket_alias',$fetch); }
	else{
		$sqlRem = mysqli_query($mr_con,"SELECT remarked_on FROM ec_remarks WHERE module='TT' AND item_alias='$ticket_alias' AND remarked_on <= DATE_SUB(NOW(),INTERVAL 6 HOUR) AND remarked_by IN(SELECT employee_alias FROM ec_employee_master WHERE privilege_alias='OX5E3EMI0U' AND flag='0')");
		if(mysqli_num_rows($sqlRem)){
			$rowRem=mysqli_fetch_array($sqlRem);
			$min_date=$rowRem['remarked_on'];
		}else{$min_date=date('Y-m-d H:i:s');}
	}
	return $return."_".aging1($min_date);
}
function aging1($min_date){
	if(!empty($min_date) && $min_date!='0000-00-00 00:00:00'){
		$date1 = strtotime($min_date);
		$date2 = strtotime(date('Y-m-d H:i:s'));
		$subTime = $date2 - $date1;
		$d = ($subTime/(60*60*24))%365;
		$h = ($subTime/(60*60))%24;
		return ($d!='0' ? $d." Days ".$h." Hours" : $h." Hours");
	}else{return "6";}
}
function aging_mail($ticket_alias, $level) {

	global $mr_con;
	date_default_timezone_set("Asia/Kolkata");
	$site_alias = alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
	$state_alias = alias($site_alias,'ec_sitemaster','site_alias','state_alias');
	$ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
	$ccemail=(!empty($cc) ? $cc.",":"")."ticket@enersys.co.in";
	list($subb,$bodyy,$time)=explode("_",subject_body($ticket_alias,$level));
	$sub = $subb." Ticket ".strtok($ticket_id,"|")." > ".$time;
	$sqlTT = mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE ticket_id='".$ticket_id."' AND flag='0'");
	if(mysqli_num_rows($sqlTT)>0){
		$rowTT=mysqli_fetch_array($sqlTT);
		$head=array("Ticket ID","Login Date");
		$content[]=$rowTT['ticket_id'];
		$content[]=($rowTT['login_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['login_date']))));
		if($rowTT['planned_date']!="" && $rowTT['planned_date']!='0000-00-00'){array_push($head,"Planned Date");$content[]=date("d-m-Y", strtotime(mysqli_real_escape_string($mr_con,$rowTT['planned_date'])));}
		$head1=array("Activity","Zone","State","District","Site ID","Site Name","Site Type","Product");
		$head2=array_merge($head,$head1);
		$head4=array();
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
		$content[]=alias($rowTT['mode_of_contact'],'ec_moc','moc_alias','moc_name');
		if(!empty($rowTT['service_engineer_alias'])){array_push($head4,"Service Engineer");$content[]=alias($rowTT['service_engineer_alias'],'ec_employee_master','employee_alias','name');}
		if(!empty($rowTT['milestone'])){array_push($head4,"Milestone");$content[]=alias($rowTT['milestone'],'ec_milestone','mile_stone_alais','mile_stone');}
		if(!empty($rowTT['efsr_no'])){array_push($head4,"efsr No");$content[]=$rowTT['efsr_no'];}
		if(!empty($rowTT['efsr_date'])){array_push($head4,"efsr Date");$content[]=$rowTT['efsr_date'];}
		if($rowTT['closing_date']!="" && $rowTT['level']>5){array_push($head4,"Closing Date");$content[]=date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['closing_date'])));}
		$head5=array("Ticket Status","Site Status","Faulty Cell Count","Complete Observation");
		$head6=array_merge($head4,$head5);
		$content[]=$rowTT['status'];
		$content[]=(sitemanfdate_check($site_alias)>0 ? 'UNDER WARRANTY' : 'OUT OF WARRANTY');
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
	$body="<p>Dear Team, Kindly ".$bodyy." Ticket on Priority,</p>";
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
	elseif(!empty($rowTT['efsr_no'])){$link = "enersyscare_V2/pdf/?ticket_alias=".$ticket_alias; $efsr='1';}
	else{$link = ""; $efsr='0';}
	if(!empty($link))$body.="<p>For details please go through the ".($efsr ? 'e-' : '')."FSR Enclosed <a href='".baseurl().$link."' target='_blank'>Click here</a></p>";
	$body.="<p>If you have any concerns please feel free to write us to service@enersys.co.in or Call us at 040-6704 6704</p>";
	$body.="<p style='font-style:italic;font-size:12px;'>*** This is a System generated email, Please do not reply ***</p>";

	$logName = $ticket_alias . "_" . $state_alais;
	echo $ticket_id . "<<<>>>" . $level . "</br>";
	if($level == 3) {
		ecSendMails("zonal_approval_pending_6hrs", $state_alias, $sub, $body, "", $logName, "ZHSP");
	} else if($level == 4) {
		ecSendMails("nhs_approval_pending_6hrs", $state_alias, $sub, $body, "", $logName, "NHSP");
	} else {
		ecSendMails("aging_inactive_6hrs", $state_alias, $sub, $body, "", $logName, "AIA");
	}
/*
	$from=all_from_mail();
	$headers="From: EnerSys Care <$from>\r\n";
	$headers.="Reply-To: $from\r\n";
	$headers.="Return-Path: $from\r\n";
	$headers .= "CC: $ccemail \r\n";
	//$headers .= "BCC: $bccemail \r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$abc = mail($to,$sub,$body,$headers);
	*/
	//if($abc)return TRUE;else return FALSE;
	//echo $body."<br>";
}

//PPC Pending Aging Mails
ppc_pending_aging_mail();
function ppc_pending_aging_mail(){  
	global $mr_con;
	date_default_timezone_set("Asia/Kolkata");
	$sqlmrf = mysqli_query($mr_con,"SELECT t1.mrf_number,t1.mrf_alias,t1.sjo_number,t2.remarked_on,t1.readiness_date,t1.ppc_mail_log,t1.from_wh,t1.to_wh,t3.privilege_alias FROM ec_material_request t1
		INNER JOIN ec_remarks t2 ON t1.mrf_alias=t2.item_alias
        INNER JOIN (SELECT MAX(id) AS ID FROM ec_remarks WHERE module IN('MR','MO') GROUP BY item_alias) AS P ON (t2.id=P.ID)
		INNER JOIN ec_employee_master t3 ON t3.employee_alias=t2.remarked_by
		WHERE ((t1.status='0' AND t1.readiness_date!='0000-00-00' AND t2.module='MO' AND t3.privilege_alias='GM5I41RNLO') OR
		(t1.status='2' AND t1.readiness_date!='0000-00-00' AND t1.readiness_date<'".date('Y-m-d')."' AND t2.module='MR' AND t3.privilege_alias='8BSTDFFQEP') OR
		(t1.status='2' AND t1.readiness_date='0000-00-00' AND t1.ticket_alias='2609' AND t2.module='MR' AND t3.privilege_alias='WIMYJFDJPT') OR
		(t1.status='2' AND t1.readiness_date='0000-00-00' AND t1.ticket_alias!='2609' AND t2.module='MR' AND t3.privilege_alias='5KPS8Q0ZNB')) AND t2.remarked_on <= DATE_SUB(NOW(),INTERVAL 8 HOUR) AND t3.flag='0' ORDER BY t2.id DESC");
	if(mysqli_num_rows($sqlmrf)){
		while($rowmrf=mysqli_fetch_array($sqlmrf)){
			$mrf_alias=$rowmrf['mrf_alias'];
			$mrf_number=$rowmrf['mrf_number'];
			$sjo_number=$rowmrf['sjo_number'];
			$from_wh=$rowmrf['from_wh'];
			$to_wh=$rowmrf['to_wh'];
			$road_permit=get_road_permit(alias($from_wh,'ec_warehouse','wh_alias','road_permit'));
			$readiness_date=($rowmrf['privilege_alias']!='8BSTDFFQEP' ? "NA" : dateFormat($rowmrf['readiness_date'],'d'));
			$min_date=$rowmrf['remarked_on'];
			$ppc_mail_log=$rowmrf['ppc_mail_log'];
			
			$sql1 = mysqli_query($mr_con,"SELECT * FROM ec_request_items WHERE mrf_alias ='$mrf_alias' AND flag=0");
			if(mysqli_num_rows($sql1)){
				$i=0;
				while($row1=mysqli_fetch_array($sql1)){
					$item_type[$i]=$row1['item_type'];
					$item_description[$i]=getitemname($item_type[$i],$row1['item_description']);
					$quantity[$i]=$row1['quantity'];
					$tappr_quanty[$i]=$row1['tappr_quanty'];
					$sent_quanty[$i]=($row1['quantity']-$row1['left_quanty']);
					$i++;
				}
			}
			$sub = "PPC Pending SJO ".$sjo_number." > ".aging1($min_date);
			echo "<br>" . $sub. "<br>";
			$body="<p>Dear PPC,</p>";
			$body.="<p>".($readiness_date=="NA" ? "Kindly plan the Material Readiness on priority":"Previous given Material Readiness date was failed kindly replan again")."</p>";
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
									$body.="<td align='center'><u><h5 style='margin:2px;'>REMINDER OF MATERIAL READINESS DATE PENDING</h5></u></td>";
								$body.="</tr>";
							$body.="</table><br>";
							$body.="<table border='1' width='95%' style='border-collapse:collapse; border:1px solid #ddd' cellpadding='8'>";
								$body.="<tr>";
									$body.="<th>MRF Number</th>";
									$body.="<th>SJO Number</th>";
									$body.="<th>Road Permit</th>";
									$body.="<th>Material Readiness Date</th>";
								$body.="</tr>";
								$body.="<tr style='text-align:center'>";
									$body.="<td>".$mrf_number."</td>";
									$body.="<td>".$sjo_number."</td>";
									$body.="<td>".$road_permit."</td>";
									$body.="<td>".$readiness_date."</td>";
								$body.="</tr>";
							$body.="</table><br>";	
						$body.="<table width='100%' cellpadding='2'>";
							$body.="<tr>";
								$body.="<td align='center'><u><h5 style='margin:2px;'>REQUIRED ITEMS</h5></u></td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table border='1' width='95%' style='border-collapse:collapse; border:1px solid #ddd' cellpadding='5'>";
							$body.="<tr align='left'><th>SL No.</th><th>Type</th><th>Item</th><th>Req. Qty</th><th>PPC Qty.</th><th>Sent Qty.</th></tr>";
							for($r=0;$r<count($item_type);$r++){
							$body.="<tr>";
								$body.="<td>".($r+1)."</td>";
								$body.="<td>".($item_type[$r]==1 ? "Cell":"Accessory")."</td>";
								$body.="<td>".$item_description[$r]."</td>";
								$body.="<td>".$quantity[$r]."</td>";
								$body.="<td>".$tappr_quanty[$r]."</td>";
								$body.="<td>".$sent_quanty[$r]."</td>";
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
			$state_alais = alias($row['from_wh'],'ec_warehouse','wh_alias','state_alias');
			// Factory QC
			$defaultMails = mul_priv_mails('DWH4PLGSLK', 'all');
			$logName = $ticket_alias . "_" . $state_alais;
			$to = implode(",", $defaultMails);
			ecSendMails("ppc_pending_morethan_8hrs", $state_alias, $sub, $body, $to, $logName, 'PPCAG');
		}
	}
}

function aging2($min_date){
	if(!empty($min_date) && $min_date!='0000-00-00 00:00:00'){
		$date1 = strtotime($min_date);
		$date2 = strtotime(date('Y-m-d H:i:s'));
		$subTime = $date2 - $date1;
		$d = ($subTime/(60*60*24))%365;
		$h = ($subTime/(60*60))%24;
		return ($d!='0' ? $d." Days ".$h." Hours" : $h." Hours");
	}else{return "8";}
}

?>