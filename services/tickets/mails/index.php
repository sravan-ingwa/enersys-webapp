<?php
date_default_timezone_set("Asia/Kolkata");
require '../../Slim/Slim.php';
include ('../../mysql.php');
include ('../../functions.php');
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->get('/new_ticket_mail','new_ticket_mail');
$app->get('/zhs_nhs_close_mail','zhs_nhs_close_mail');
$app->get('/ticket_declined_mail','ticket_declined_mail');
$app->get('/zhs_nhs_decline_mail','zhs_nhs_decline_mail');
$app->get('/ts_approve_mail','ts_approve_mail');
$app->get('/ts_reject_mail','ts_reject_mail');
$app->run();
function new_ticket_mail(){ 
	global $mr_con;
	$site_alias = mysqli_real_escape_string($mr_con,$_REQUEST['site_alias']);
	$ticket_alias = mysqli_real_escape_string($mr_con,$_REQUEST['ticket_alias']);
	$ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
	$site_name = alias($site_alias,'ec_sitemaster','site_alias','site_name');
	if(!empty($site_alias) && !empty($ticket_alias) && !empty($ticket_id) && !empty($site_name)){
		date_default_timezone_set("Asia/Kolkata");
		$sql = mysqli_query($mr_con,"SELECT manager_mail,manager_name,state_alias FROM ec_sitemaster WHERE site_alias='$site_alias'");
		$row=mysqli_fetch_array($sql);
		$to = $row['manager_mail'];
		$state_alias = $row['state_alias'];
		$rowesca = mysqli_fetch_array(mysqli_query($mr_con,"SELECT GROUP_CONCAT(email_id) AS email FROM ec_employee_master WHERE privilege_alias='OX5E3EMI0U' AND state_alias LIKE '%$state_alias%' AND status='WORKING' AND flag='0'"));
		$ccemail = "ticket@enersys.co.in".(!empty($rowesca['email']) ? ",".$rowesca['email'] : "");
		$sub = "New Ticket - ".$ticket_id." - ".date("d-m-Y");
		$sqlTT = mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE ticket_alias='$ticket_alias' AND flag='0'");
		if(mysqli_num_rows($sqlTT)>0){
			$rowTT=mysqli_fetch_array($sqlTT);
			$head=array("Ticket ID","Login Date","Activity","Zone","State","District","Site ID","Site Name","Site Type","Product","Battery Bank Rating","No Of Strings","Segment","Customer Name","Manufacturing Date","Installation Date","First Level Contact Name","First Level Contact Number","Second Level Contact Name","Second Level Contact Number","Second Level Contact email","Site Address","MOC","Ticket Status","Site Status","Faulty Cell Count","Complete Observation","TAT","Complaint","Level");
			$content[]=$rowTT['ticket_id'];
			$content[]=($rowTT['login_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['login_date']))));
			$content[]=alias($rowTT['activity_alias'],'ec_activity','activity_alias','activity_name');
			$sqlSite = mysqli_query($mr_con,"SELECT * FROM ec_sitemaster WHERE site_alias='$site_alias'");
			if(mysqli_num_rows($sqlSite)){
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
				$seg_ali=($rowSite['segment_alias']=='YGRKJJD4N7' ? TRUE : FALSE);
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
			$content[]=$rowTT['status'];
			$content[]=($rowTT['warranty']>0 ? 'UNDER WARRANTY' : 'OUT OF WARRANTY');
			$content[]=$rowTT['faulty_cell_count'];
			$content[]=$rowTT['description'];
			$content[]=tat($ticket_alias);
			$content[]=alias($rowTT['complaint_alias'],'ec_complaint','complaint_alias','complaint_name');
			$content[]=alias($rowTT['level'],'ec_levels','level_alias','level_name');
		}
		$body="<p>Dear ".ucfirst(strtolower($row['manager_name'])).",</p>";
		if(alias($rowTT['activity_alias'],'ec_activity','activity_alias','activity_type')=='1'){
			$body.="<p>Thank you for contacting us today with your complaint/problem.</p>";
			$body.="<p>We view complaints as positive and helpful feedback and will do everything we can to resolve this fairly and quickly to your satisfaction.</p>";
			$body.="<p>We aim to respond to you within 5 Working days with a suitable resolution.</p>";
			$body.="<p>Should you need to contact us again regarding this matter, your reference number is ".$ticket_id."</p>";
			$body.="<p>I look forward to reaching a suitable resolution to this matter and thank you again for taking time to raise this with us.</p>";					   
		}else $body.="<p>A New Ticket has been Registered in ".strtoupper(alias($row['state_alias'],'ec_state','state_alias','state_name'))." State. Below are the details of Ticket.</p>";
		
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
		$body.="</table><br>";
		$body.="<p>If you have any concerns please feel free to write us to service@enersys.co.in or Call us at 040-6704 6704</p><br>";
		$body.="<p style='font-style:italic;font-size:12px;'>*** This is a System generated email, Please do not reply ***</p>";
		
		//return $body;
		$logName = $ticket_alias . "_" . $site_alias;
		ecSendMails("new_tt_registration", $state_alias, $sub, $body, $to, $logName, "NEW");
	}
}
function zhs_nhs_close_mail(){  
	global $mr_con;
	date_default_timezone_set("Asia/Kolkata");
	$ticket_alias = mysqli_real_escape_string($mr_con,$_REQUEST['ticket_alias']);
	$site_alias = alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
	$ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
	$sql = mysqli_query($mr_con,"SELECT manager_mail,manager_name,state_alias FROM ec_sitemaster where site_alias='$site_alias' AND flag='0'");
	$row=mysqli_fetch_array($sql);
	$to = (!empty($row['manager_mail']) && filter_var($row['manager_mail'], FILTER_VALIDATE_EMAIL) ? $row['manager_mail'] : "ticket@enersys.co.in");
	$state_alias = $row['state_alias'];
	$rowesca = mysqli_fetch_array(mysqli_query($mr_con,"SELECT GROUP_CONCAT(email_id) AS email FROM ec_employee_master WHERE privilege_alias='OX5E3EMI0U' AND state_alias LIKE '%$state_alias%' AND status='WORKING' AND flag='0'"));
	$ccemail = "ticket@enersys.co.in".(!empty($rowesca['email']) ? ",".$rowesca['email'] : "");
	$sub = "Ticket Closed - ".$ticket_id." - ".date("d-m-Y");
	$sqlTT = mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE ticket_alias='".$ticket_alias."' AND flag='0'");
	if(mysqli_num_rows($sqlTT)>0){
		$rowTT=mysqli_fetch_array($sqlTT);
		$head=array("Ticket ID","Login Date","Planned Date","Activity","Zone","State","District","Site ID","Site Name","Site Type","Product","Battery Bank Rating","No Of Strings","Segment","Customer Name","Manufacturing Date","Installation Date","First Level Contact Name","First Level Contact Number","Second Level Contact Name","Second Level Contact Number","Second Level Contact email","Site Address","MOC","Service Engineer","Milestone","efsr No","efsr Date","Closing Date","Ticket Status","Site Status","Faulty Cell Count Reported By Customer","Complete Observation","TAT","Complaint","Level","Remarks");
		$content[]=$rowTT['ticket_id'];
		$content[]=($rowTT['login_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['login_date']))));
		$content[]=($rowTT['planned_date']=="" && $rowTT['planned_date']=='0000-00-00' ? "NA" : date("d-m-Y", strtotime(mysqli_real_escape_string($mr_con,$rowTT['planned_date']))));
		$content[]=alias($rowTT['activity_alias'],'ec_activity','activity_alias','activity_name');
		$sqlSite = mysqli_query($mr_con,"SELECT * FROM ec_sitemaster WHERE site_alias='$site_alias' AND flag=0");
		if(mysqli_num_rows($sqlSite)){
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
			$seg_ali=($rowSite['segment_alias']=='YGRKJJD4N7' ? TRUE : FALSE);
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
		$content[]=alias($rowTT['service_engineer_alias'],'ec_employee_master','employee_alias','name');
		$content[]=alias($rowTT['milestone'],'ec_milestone','mile_stone_alais','mile_stone');
		$content[]=$rowTT['efsr_no'];
		$content[]=$rowTT['efsr_date'];
		$content[]=($rowTT['closing_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['closing_date']))));
		$content[]=$rowTT['status'];
		$content[]=($rowTT['warranty']>0 ? 'UNDER WARRANTY' : 'OUT OF WARRANTY');
		$content[]=$rowTT['faulty_cell_count'];
		$content[]=$rowTT['description'];
		$content[]=tat($ticket_alias);
		$content[]=alias($rowTT['complaint_alias'],'ec_complaint','complaint_alias','complaint_name');
		$content[]=alias($rowTT['level'],'ec_levels','level_alias','level_name');
		$remsql=mysqli_query($mr_con,"SELECT remarks FROM ec_remarks WHERE id IN (SELECT MAX(id) FROM ec_remarks WHERE module='TT' AND item_alias='$ticket_alias' AND flag='0') AND flag='0'");
		$remrow=mysqli_fetch_array($remsql);
		$content[]=strtoupper($remrow['remarks']);
		$serv=alias($ticket_alias,'ec_engineer_observation','ticket_alias','total_faulty_count');
		if($serv!="" && $serv!="NA"){array_push($head,"Faulty Cell Count Reported By Service Engineer");$content[]=$serv;}
	}
	$body="<p>Dear ".ucfirst(strtolower($row['manager_name'])).",</p>";
	$body.="<p>A Ticket has been Closed in ".strtoupper(alias($row['state_alias'],'ec_state','state_alias','state_name'))." State. Below are the details of Ticket.</p>";
	$body.="<h3 style='background:#2a6496;color:#FFF;padding:0 5px;line-height:30px;font-size:16px;'>Ticket Details</h3>";
	$body.="<table style='border-collapse:collapse;width:100%;'>";
	$c=count($head);
	for($a=0;$a<$c;$a++){
		$body.="<tr>";
		for($b=$a;$b<=($a+1);$b++){
			$body.="<td style='padding:2px 5px;text-align:justify;border:1px solid #000;'>
			<h4 style='display:block;color:#2a6496;font-weight:bold; margin:0;padding:2px;'>".ucfirst($head[$b])."</h4>
			<p style='display:block;margin:0;padding:1px;'>".ucfirst($content[$b])."</p>
			</td>";
		}
		$a++;
		$body.="</tr>";
	}
	$body.="</table><br>";
	$esca_efsr_link = alias($ticket_alias,'ec_tickets','ticket_alias','esca_efsr_link');
	//$efsr_ = alias($ticket_alias,'ec_tickets','ticket_alias','esca_efsr_link');
	if(!empty($esca_efsr_link) && $esca_efsr_link!='NA'){ $link = "images/esca_efsr/".$esca_efsr_link; $efsr='0';}
	elseif(!empty($rowTT['efsr_no'])){$link = (empty($rowTT['efsr_start']) ? "enersyscare_V2" : "mobile_app")."/pdf/index.php?ticket_alias=".$ticket_alias; $efsr='1';}
	else{$link = ""; $efsr='0';}
	if(!empty($link))$body.="<p>For details please go through the ".($efsr ? 'e-' : '')."FSR Enclosed <a href='".baseurl().$link."' target='_blank'>Click here</a></p>";
	$body.="<p>If you have any concerns please feel free to write us to service@enersys.co.in or Call us at 040-6704 6704</p>";
	$body.="<p style='font-style:italic;font-size:12px;'>*** This is a System generated email, Please do not reply ***</p>";
	//return $body;
	
	$logName = $ticket_alias;
	ecSendMails("zonal_nhs_close_decline_ticket", $state_alias, $sub, $body, $to, $logName, "ZNC");
}
function ticket_declined_mail(){ global $mr_con; //global $bccemail;//$ticket_alias
	$ticket_alias = mysqli_real_escape_string($mr_con,$_REQUEST['ticket_alias']);
	$ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
	$site_alias = alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
	date_default_timezone_set("Asia/Kolkata");
	$sql = mysqli_query($mr_con,"SELECT manager_mail,manager_name,state_alias FROM ec_sitemaster where site_alias='$site_alias' AND flag='0'");
	$row=mysqli_fetch_array($sql);
	$to = (!empty($row['manager_mail']) && filter_var($row['manager_mail'], FILTER_VALIDATE_EMAIL) ? $row['manager_mail'] : "ticket@enersys.co.in");
	$state_alias = $row['state_alias'];
	$rowesca = mysqli_fetch_array(mysqli_query($mr_con,"SELECT GROUP_CONCAT(email_id) AS email FROM ec_employee_master WHERE privilege_alias='OX5E3EMI0U' AND state_alias LIKE '%$state_alias%' AND status='WORKING' AND flag='0'"));
	$ccemail = "ticket@enersys.co.in".(!empty($rowesca['email']) ? ",".$rowesca['email'] : "");
	$sub = "Ticket Declined - ".$ticket_id." - ".date("d-m-Y");
	$sqlTT = mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE ticket_alias='".$ticket_alias."' AND flag='0'");
	if(mysqli_num_rows($sqlTT)>0){
		$rowTT=mysqli_fetch_array($sqlTT);
		$head=array("Ticket ID","Login Date","Activity","Zone","State","District","Site ID","Site Name","Site Type","Product","Battery Bank Rating","No Of Strings","Segment","Customer Name","Manufacturing Date","Installation Date","First Level Contact Name","First Level Contact Number","Second Level Contact Name","Second Level Contact Number","Second Level Contact email","Site Address","MOC","Closing Date","Ticket Status","Site Status","Faulty Cell Count Reported By Customer","Complete Observation","TAT","Complaint","Level","Remarks");
		if(!empty($rowTT['planned_date']) && $rowTT['planned_date']!='0000-00-00'){ array_splice($head, 2, 0, "Planned Date"); $chk = 24;}else{$chk = 23;}
		if(!empty($rowTT['service_engineer_alias'])){ array_splice($head, $chk, 0, "Service Engineer"); }
		if(!empty($rowTT['milestone'])){array_push($head,"Milestone");}
		if(!empty($rowTT['efsr_no'])){array_push($head,"efsr No","efsr Date");}
		$content[]=$rowTT['ticket_id'];
		$content[]=($rowTT['login_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['login_date']))));
		if(!empty($rowTT['planned_date']) && $rowTT['planned_date']!='0000-00-00'){ $content[]=($rowTT['planned_date']=="" ? "NA" : date("d-m-Y", strtotime(mysqli_real_escape_string($mr_con,$rowTT['planned_date']))));}
		$content[]=alias($rowTT['activity_alias'],'ec_activity','activity_alias','activity_name');
		$sqlSite = mysqli_query($mr_con,"SELECT * FROM ec_sitemaster WHERE site_alias='$site_alias' AND flag=0");
		if(mysqli_num_rows($sqlSite)){
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
			$seg_ali=($rowSite['segment_alias']=='YGRKJJD4N7' ? TRUE : FALSE);
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
		if(!empty($rowTT['service_engineer_alias'])){ $content[]=alias($rowTT['service_engineer_alias'],'ec_employee_master','employee_alias','name'); }
		$content[]=($rowTT['closing_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['closing_date']))));
		$content[]=$rowTT['status'];
		$content[]=($rowTT['warranty']>0 ? 'UNDER WARRANTY' : 'OUT OF WARRANTY');
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
		$serv=alias($ticket_alias,'ec_engineer_observation','ticket_alias','total_faulty_count');
		if($serv!="" && $serv!="NA"){array_push($head,"Faulty Cell Count Reported By Service Engineer");$content[]=$serv;}
	}
	$body="<p>Dear ".ucfirst(strtolower($row['manager_name'])).",</p>";
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
	$body.="</table><br>";
	$esca_efsr_link = alias($ticket_alias,'ec_tickets','ticket_alias','esca_efsr_link');
	//$efsr_ = alias($ticket_alias,'ec_tickets','ticket_alias','esca_efsr_link');
	if(!empty($esca_efsr_link) && $esca_efsr_link!='NA'){ $link = "images/esca_efsr/".$esca_efsr_link; $efsr='0';}
	elseif(!empty($rowTT['efsr_no'])){$link = (empty($rowTT['efsr_start']) ? "enersyscare_V2" : "mobile_app")."/pdf/index.php?ticket_alias=".$ticket_alias; $efsr='1';}
	else{$link = ""; $efsr='0';}
	if(!empty($link))$body.="<p>For details please go through the ".($efsr ? 'e-' : '')."FSR Enclosed <a href='".baseurl().$link."' target='_blank'>Click here</a></p>";
	$body.="<p>If you have any concerns please feel free to write us to service@enersys.co.in or Call us at 040-6704 6704</p>";
	$body.="<p style='font-style:italic;font-size:12px;'>*** This is a System generated email, Please do not reply ***</p>";
	//return $body;
	$logName = $ticket_alias;
	ecSendMails("zonal_nhs_close_decline_ticket", $state_alias, $sub, $body, $to, $logName, "ZND");
}
function zhs_nhs_decline_mail(){ global $mr_con; //global $bccemail;//$ticket_alias
	$ticket_alias = mysqli_real_escape_string($mr_con,$_REQUEST['ticket_alias']);
	$site_alias = alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
	$state_alias = alias($site_alias,'ec_sitemaster','site_alias','state_alias');
	$segment_alias = alias($site_alias,'ec_sitemaster','site_alias','segment_alias');
	$e_sig_id = alias($ticket_alias,'ec_e_signature','ticket_alias','id');
	if($segment_alias=='HXL5A1HOTZ' && !empty($e_sig_id) && $e_sig_id !='NA'){ // Only for Telecom segment.
		//Ref
		$ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
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
		
		$to = $cust_email;
		$sub = "Ticket Declined - ".$ticket_id." - ".date("d-m-Y");
		
		$state_ali = alias($site_alias,'ec_sitemaster','site_alias','state_alias');
		$sqlEsca = mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='OX5E3EMI0U' AND state_alias LIKE '%$state_ali%' AND flag='0'");
		$zhsmail= "";
		if(mysqli_num_rows($sqlEsca)>0){
			$rowesca=mysqli_fetch_array($sqlEsca);
			$zhsmail= $rowesca['email_id'];
		}
		$semail = alias(alias($ticket_alias,'ec_tickets','ticket_alias','service_engineer_alias'),'ec_employee_master','employee_alias','email_id');
		$ccemail= "ticket@enersys.co.in".(!empty($zhsmail) && filter_var($zhsmail, FILTER_VALIDATE_EMAIL) ? ", ".$zhsmail : "").(!empty($semail) && filter_var($semail, FILTER_VALIDATE_EMAIL) ? ", ".$semail : "");
		$date = date('d-m-Y');
		$link = urlencode($ticket_alias."|".$status."|".$date."|".$remarks);
		
		$body = "<html><body>";
		$body.="<table width='800px' style='border-collapse:collapse;' cellpadding='3' align='center'>";
		
		$body.="<tr align='center'>";
		$body.="<th align='right' style='border:1px solid #ddd; border-bottom:1px solid #fff;'>";
		$body.="<a href='".baseurl()."enersyscare_V2/print_decline.php?a=".$link."' target='_blank'>Print</a>";
		$body.="</th>";
		$body.="</tr>";
		
			$body.="<tr align='center'>";
				$body.="<th align='center' style='border:1px solid #ddd; border-bottom:1px solid #fff;'>";
					$body.="<table width='100%'>";
						$body.="<tr>";
							$body.="<th align='left'><img src='".baseurl()."images/gallery/EnerSyslogo.png' alt='EnerSys_logo' width='150'></th>";
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
					
					$body .= "<table style='border-collapse:collapse;' cellpadding='8' align='center'>
						<tr><td width='40%'>1.&nbsp;&nbsp;SMPS Display							</td><td>:&nbsp;&nbsp;<span ".color($smps_display,'1').">".$smps_display."</span></td></tr>
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
							$esca_efsr_link = alias($ticket_alias,'ec_tickets','ticket_alias','esca_efsr_link');
							$efsr_start = alias($ticket_alias,'ec_tickets','ticket_alias','efsr_start');
							$link = (!empty($esca_efsr_link) ? "images/esca_efsr/".$esca_efsr_link : (empty($efsr_start) ? "enersyscare_V2" : "mobile_app")."/pdf/index.php?ticket_alias=".$ticket_alias);
							$body.="<td align='left'>For details please go through the ".(strpos($link,"ticket_alias")!==false ? 'e-' : '')."FSR Enclosed <a href='".baseurl().$link."' target='_blank'>Click here</a></td>";
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
		$body.="<p>If you have any concerns please feel free to write us to service@enersys.co.in or Call us at 040-6704 6704</p><br>";
		$body.="<p style='font-style:italic;text-align:center;'><small>*** This is a System generated email, Please do not reply ***</small></p>";
		$body.="</body></html>";

		$logName = $ticket_alias;
		ecSendMails("zonal_nhs_close_decline_ticket", $state_alias, $sub, $body, $to, $logName, "ZND");
	}else curlxing(baseurl()."services/tickets/mails/ticket_declined_mail?ticket_alias=".$ticket_alias);
}
function ts_approve_mail(){  global $mr_con; //global $bccemail;
	date_default_timezone_set("Asia/Kolkata");
	$ticket_alias = mysqli_real_escape_string($mr_con,$_REQUEST['ticket_alias']);
	//$ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
	$sqlTT = mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE ticket_alias='$ticket_alias' AND flag='0'");
	if(mysqli_num_rows($sqlTT)>0){
		$site_alias = alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
		$rowTT=mysqli_fetch_array($sqlTT);
		$to="service@enersys.co.in,".mail_relieved_filter("ushha@enersys.co.in,nathani.rajasekhar@enersys.co.in");
		$state_alias=alias($site_alias,'ec_sitemaster','site_alias','state_alias');
		$to="";
		$sub = "Technical Clearance to Raise SJO against TT Number : ".$rowTT['ticket_id'];
		$head=array("Ticket ID","Login Date");
		$content[]=$rowTT['ticket_id'];
		$content[]=($rowTT['login_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['login_date']))));
		if($rowTT['planned_date']!="" && $rowTT['planned_date']!='0000-00-00'){array_push($head,"Planned Date");$content[]=date("d-m-Y", strtotime(mysqli_real_escape_string($mr_con,$rowTT['planned_date'])));}
		$head1=array("Activity","Zone","State","District","Site ID","Site Name","Site Type","Product");
		$head2=array_merge($head,$head1);
		$content[]=alias($rowTT['activity_alias'],'ec_activity','activity_alias','activity_name');
		$sqlSite = mysqli_query($mr_con,"SELECT * FROM ec_sitemaster WHERE site_alias='$site_alias' AND flag=0");
		if(mysqli_num_rows($sqlSite)){
			//$ticket_alias = alias($ticket_id,'ec_tickets','ticket_id','ticket_alias');
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
		if(!empty($remrow['remarks'])){array_push($head8,"TS Remarks");$content[]=strtoupper($remrow['remarks']);}
	}

	//$body="<p>Dear $m,</p>";
	$body.="<p>Dear Team,<br/><br/>Raise the SJO as per the given comments.</p>";
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
	
	$sqlTS = mysqli_query($mr_con,"SELECT * FROM ec_ths_approved WHERE ticket_alias='$ticket_alias' AND flag='0'");
	if(mysqli_num_rows($sqlTS)>0){
		$rowTS=mysqli_fetch_array($sqlTS);
		$sql3=mysqli_query($mr_con,"SELECT GROUP_CONCAT(name SEPARATOR ',<br>') AS emp_name, GROUP_CONCAT(email_id) AS emp_mail FROM ec_employee_master WHERE employee_alias IN ('".str_replace("|","','",$rowTS['persons_notified'])."') AND flag='0'");
		$to.=",".$emp_row['emp_mail'];
		$emp_row=mysqli_fetch_array($sql3);
		$remths=mysqli_query($mr_con,"SELECT remarks,bucket FROM ec_remarks WHERE bucket IN('12','13','14','15','31','32') AND module='TT' AND item_alias='$ticket_alias' AND flag='0'");
		$rem_ths=mysqli_fetch_array($remths);
		$bucket=$rem_ths['bucket'];
		if($bucket=='12' || $bucket=='13' || $bucket=='14' || $bucket=='15')$root_remark=$rem_ths['remarks'];
		if($bucket=='31' || $bucket=='32')$dis_remark=$rem_ths['remarks'];
		$tail=array("CAR Number","Line Number","Shift","Date Of Assembly","Date Of Jar formation","Corrective Actions Planned","Persons Notified","Root Cause of nonconformity","Deposition","Prevent Recurrence");
		$content1[]=checkempty($rowTS['car_number']);
		$content1[]=checkempty($rowTS['line_number']);
		$content1[]=checkempty(alias($rowTS['shift'],'ec_shift','shift_alias','shift_name'));
		$content1[]=($rowTS['date_of_assembly']=="" || $rowTS['date_of_assembly']=="0000-00-00" ? "NA" : date("d-m-Y", strtotime(mysqli_real_escape_string($mr_con,$rowTS['date_of_assembly']))));
		$content1[]=($rowTS['date_of_jar_form']=="" || $rowTS['date_of_jar_form']=="0000-00-00" ? "NA" : date("d-m-Y", strtotime(mysqli_real_escape_string($mr_con,$rowTS['date_of_jar_form']))));
		$content1[]=checkempty(strtoupper($rowTS['corect_act_Plan']));
		$content1[]=checkempty($emp_row['emp_name']);
		$content1[]=checkempty($root_remark);
		$content1[]=checkempty($rowTS['deposition']);
		$content1[]=checkempty($dis_remark);
		
		$body.="<br><h3 style='background:#2a6496;color:#FFF;padding:0 5px;line-height:30px;font-size:16px;'>TS Details</h3>";
		$body.="<table style='border-collapse:collapse;width:100%;'>";
		$c=count($tail);
		for($a=0;$a<$c;$a++){
			$body.="<tr>";
			for($b=$a;$b<=($a+1);$b++){
				$body.="<td style='padding:2px 5px;text-align:justify;border:1px solid #000;'>
				<h4 style='display:block;color:#2a6496;font-weight:bold; margin:0;padding:2px;'>".($tail[$b])."</h4>
				<p style='display:block;margin:0;padding:1px;'>".strtoupper($content1[$b])."</p>
				</td>";
			}
			$a++;
			$body.="</tr>";
		}
		$body.="</table><br>";
		
		$sqlFO = mysqli_query($mr_con,"SELECT * FROM ec_ths_faulty_ocv WHERE ths_appr_alias='".$rowTS['alias']."' AND flag=0");
		if(mysqli_num_rows($sqlFO)>0){
			$body.="<br><h3 style='background:#2a6496;color:#FFF;padding:0 5px;line-height:30px;font-size:16px;'>FAULTY CELLS Details</h3>";
			$body.="<table style='border-collapse:collapse;width:100%;'>";
			$body.="<tr>
						<th style='padding:2px 5px;text-align:justify;border:1px solid #000;'>
							<h4 style='display:block;color:#2a6496;font-weight:bold; margin:0;padding:2px;'>FAULTY CELL No.</h4>
						</th>
						<th style='padding:2px 5px;text-align:justify;border:1px solid #000;'>
							<h4 style='display:block;color:#2a6496;font-weight:bold; margin:0;padding:2px;'>OCV AT DISPATCH</h4>
						</th>
						<th style='padding:2px 5px;text-align:justify;border:1px solid #000;'>
							<h4 style='display:block;color:#2a6496;font-weight:bold; margin:0;padding:2px;'>10TH HOUR READING</h4>
						</th>
					</tr>";
			$i=1;while($rowFO=mysqli_fetch_array($sqlFO)){
			$body.="<tr>
						<td style='padding:2px 5px;text-align:justify;border:1px solid #000;'>
							<p style='display:block;margin:0;padding:1px;'>".checkempty($rowFO['faulty_cell_num'])."</p>
						</td>
						<td style='padding:2px 5px;text-align:justify;border:1px solid #000;'>
							<p style='display:block;margin:0;padding:1px;'>".checkempty($rowFO['ocv'])."</p>
						</td>
						<td style='padding:2px 5px;text-align:justify;border:1px solid #000;'>
							<p style='display:block;margin:0;padding:1px;'>".checkempty($rowFO['tenth_hour'])."</p>
						</td>
					</tr>";
				$i++;
			}
			$body.="</table><br>";
		}
	}
	
	$esca_efsr_link = alias($ticket_alias,'ec_tickets','ticket_alias','esca_efsr_link');
	$efsr_start = alias($ticket_alias,'ec_tickets','ticket_alias','efsr_start');
	//$efsr_ = alias($ticket_alias,'ec_tickets','ticket_alias','esca_efsr_link');
	if(!empty($esca_efsr_link) && $esca_efsr_link!='NA'){ $link = "images/esca_efsr/".$esca_efsr_link; $efsr='0';}
	elseif(!empty($rowTT['efsr_no'])){$link = (empty($efsr_start) ? "enersyscare_V2" : "mobile_app")."/pdf/index.php?ticket_alias=".$ticket_alias; $efsr='1';}
	else{$link = ""; $efsr='0';}
	if(!empty($link))$body.="<p>For details please go through the ".($efsr ? 'e-' : '')."FSR Enclosed <a href='".baseurl().$link."' target='_blank'>Click here</a></p>";
	$body.="<p>If you have any concerns please feel free to write us to service@enersys.co.in or Call us at 040-6704 6704</p>";
	$body.="<p style='font-style:italic;font-size:12px;'>*** This is a System generated email, Please do not reply ***</p>";
	
	$logName = $ticket_alias;
	ecSendMails("technical_service_approved", $state_alias, $sub, $body, $to, $logName, "TSA");
}
function ts_reject_mail(){  global $mr_con; //global $bccemail;
	date_default_timezone_set("Asia/Kolkata");
	$ticket_alias = mysqli_real_escape_string($mr_con,$_REQUEST['ticket_alias']);
	//$ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
	$sqlTT = mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE ticket_alias='$ticket_alias' AND flag='0'");
	if(mysqli_num_rows($sqlTT)>0){
		$site_alias = alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
		$rowTT=mysqli_fetch_array($sqlTT);
		$to="service@enersys.co.in,".mail_relieved_filter("nathani.rajasekhar@enersys.co.in");
		$to = "";
		$state_alias=alias($site_alias,'ec_sitemaster','site_alias','state_alias');
		$sub = "Technical Clearance Rejected against TT Number : ".$rowTT['ticket_id'];
		$head=array("Ticket ID","Login Date");
		$content[]=$rowTT['ticket_id'];
		$content[]=($rowTT['login_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['login_date']))));
		if($rowTT['planned_date']!="" && $rowTT['planned_date']!='0000-00-00'){array_push($head,"Planned Date");$content[]=date("d-m-Y", strtotime(mysqli_real_escape_string($mr_con,$rowTT['planned_date'])));}
		$head1=array("Activity","Zone","State","District","Site ID","Site Name","Site Type","Product");
		$head2=array_merge($head,$head1);
		$content[]=alias($rowTT['activity_alias'],'ec_activity','activity_alias','activity_name');
		$sqlSite = mysqli_query($mr_con,"SELECT * FROM ec_sitemaster WHERE site_alias='$site_alias' AND flag=0");
		if(mysqli_num_rows($sqlSite)){
			//$ticket_alias = alias($ticket_id,'ec_tickets','ticket_id','ticket_alias');
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
		$content[]=($rowTT['warranty']>0 ? 'UNDER WARRANTY' : 'OUT OF WARRANTY');
		$content[]=$rowTT['faulty_cell_count'];
		$content[]=$rowTT['description'];
		if($rowTT['level']>5){array_push($head6,"TAT");$content[]=tat($ticket_alias);}
		$head7=array("Complaint","Level");
		$head8=array_merge($head6,$head7);
		$content[]=alias($rowTT['complaint_alias'],'ec_complaint','complaint_alias','complaint_name');
		$content[]=nhsDue_tsRej_level($rowTT['level'],$rowTT['old_level']);
		$remsql=mysqli_query($mr_con,"SELECT remarks FROM ec_remarks WHERE id IN (SELECT MAX(id) FROM ec_remarks WHERE module='TT' AND item_alias='$ticket_alias' AND flag='0') AND flag='0'");
		$remrow=mysqli_fetch_array($remsql);
		if(!empty($remrow['remarks'])){array_push($head8,"TS Remarks");$content[]=strtoupper($remrow['remarks']);}
	}
	//$body="<p>Dear $m,</p>";
	$body.="<p>Dear Team,<br/><br/>TS Rejected the ticket as per the given comments.</p>";
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
	$efsr_start = alias($ticket_alias,'ec_tickets','ticket_alias','efsr_start');
	//$efsr_ = alias($ticket_alias,'ec_tickets','ticket_alias','esca_efsr_link');
	if(!empty($esca_efsr_link) && $esca_efsr_link!='NA'){ $link = "images/esca_efsr/".$esca_efsr_link; $efsr='0';}
	elseif(!empty($rowTT['efsr_no'])){$link = (empty($efsr_start) ? "enersyscare_V2" : "mobile_app")."/pdf/index.php?ticket_alias=".$ticket_alias; $efsr='1';}
	else{$link = ""; $efsr='0';}
	if(!empty($link))$body.="<p>For details please go through the ".($efsr ? 'e-' : '')."FSR Enclosed <a href='".baseurl().$link."' target='_blank'>Click here</a></p>";
	$body.="<p>If you have any concerns please feel free to write us to service@enersys.co.in or Call us at 040-6704 6704</p>";
	$body.="<p style='font-style:italic;font-size:12px;'>*** This is a System generated email, Please do not reply ***</p>";
	$logName = $ticket_alias;
	ecSendMails("technical_service_rejected", $state_alias, $sub, $body, $to, $logName, "TSR");
}
?>