<?php
date_default_timezone_set("Asia/Kolkata");
require '../Slim/Slim.php';
include ('../mysql.php');
include ('../functions.php');
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->post('/calender','calender');
$app->post('/event_add','event_add');
$app->post('/event_popup','event_popup');
$app->post('/sending_emails','sending_emails');
$app->post('/cexport','cexport');
$app->post('/dprexport','dprexport');
$app->post('/delete','calender_event_delete');
$app->post('/event_update','event_update');
$app->post('/dpr_update','dpr_update');
$app->run();

function calender(){ global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['token']));
	$rex=authentication($emp_alias,$token);
	if($rex==0){ $co = 0;
		$date_sort="";$location_sort="";$emp_sort="";$final_sort="";$a=0;
		if(isset($_REQUEST['heldate']) && $_REQUEST['heldate']!=""){
			$dates_from_to=xyz($_REQUEST['heldate']);
			$date_sort=" (scheduled_on >= '".$dates_from_to[0]."' AND scheduled_on <='".$dates_from_to[1]."') AND ";
			$planned_date_sort=" (planned_date >= '".$dates_from_to[0]."' AND planned_date <='".$dates_from_to[1]."') AND ";
		}else{
			$dates_from_to=xyz(date("M Y"));
			$date_sort=" (scheduled_on >= '".$dates_from_to[0]."' AND scheduled_on <='".$dates_from_to[1]."') AND ";
			$planned_date_sort=" (planned_date >= '".$dates_from_to[0]."' AND planned_date <='".$dates_from_to[1]."') AND ";
		}
		if(isset($_REQUEST['state_alias']) && count($_REQUEST['state_alias'])>0){
			$location_sort.="state_alias RLIKE '".implode("|",$_REQUEST['state_alias'])."' AND ";
		}
		if(isset($_REQUEST['zone_alias']) && count($_REQUEST['zone_alias'])>0){
			$location_sort.="zone_alias RLIKE '".implode("|",$_REQUEST['zone_alias'])."' AND ";
		}//else $location_sort="";
		if(isset($_REQUEST['role_alias']) && count($_REQUEST['role_alias'])>0 && isset($_REQUEST['employee_alias']) && count($_REQUEST['employee_alias'])>0){$co++;
			$emp_sort=" (SELECT employee_alias FROM ec_employee_master WHERE role_alias IN('".implode("','",$_REQUEST['role_alias'])."') AND employee_alias IN('".implode("','",$_REQUEST['employee_alias'])."') AND status!='RELIEVED' AND ".$location_sort." flag='0') ";
		}elseif(isset($_REQUEST['role_alias']) && count($_REQUEST['role_alias'])>0 ){$co++;
			$emp_sort=" (SELECT employee_alias FROM ec_employee_master WHERE role_alias IN('".implode("','",$_REQUEST['role_alias'])."') AND status!='RELIEVED' AND ".$location_sort." flag='0') ";
		}elseif(isset($_REQUEST['employee_alias']) && count($_REQUEST['employee_alias'])>0){$co++;
			$emp_sort=" ('".implode("','",$_REQUEST['employee_alias'])."') ";
		}else $emp_sort="";
		
		if($emp_sort!="" && $location_sort!=""){
			$final_sort="event_alias IN (SELECT ticket_alias FROM ec_tickets WHERE $planned_date_sort service_engineer_alias IN ".$emp_sort." AND site_alias IN (SELECT site_alias FROM ec_sitemaster WHERE ".$location_sort." flag='0') AND flag='0') AND event_type='1' AND ";
		}elseif($emp_sort!="" && $location_sort==""){
			$final_sort="emp_alias IN ".$emp_sort." AND ";
		}elseif($location_sort!="" && $emp_sort==""){
			$final_sort="event_alias IN (SELECT ticket_alias FROM ec_tickets WHERE $planned_date_sort site_alias IN (SELECT site_alias FROM ec_sitemaster WHERE ".$location_sort." flag='0') AND flag='0') AND  event_type='1' AND ";
		}else $final_sort="";
		
		$engaged=mysqli_query($mr_con,"SELECT emp_alias,scheduled_on FROM ec_calender_event WHERE $date_sort $final_sort status=0 AND flag=0 GROUP BY emp_alias");
		while($engaged_row=mysqli_fetch_array($engaged)){$en_employees[]=$engaged_row['emp_alias'];}
		if(count($en_employees)>0){
			foreach($en_employees as $emp){
				$en=mysqli_query($mr_con,"SELECT emp_alias,scheduled_on FROM ec_calender_event WHERE $date_sort $final_sort emp_alias='$emp' AND status=0 AND flag=0 GROUP BY DATE_FORMAT(scheduled_on,'%y-%m-%d')");
				while($en_row=mysqli_fetch_array($en)){
					$dates=$en_row['scheduled_on'];$dat1=date("l", strtotime($dates));
					if($dat1!="Sunday"){$da[]=$dates;}
				}
			}
		}$b=count($da);
		$query=mysqli_query($mr_con,"SELECT event_type,event_alias,p_level,scheduled_on FROM ec_calender_event WHERE $date_sort $final_sort status=0 AND flag=0 GROUP BY event_alias");
		if(mysqli_num_rows($query)){$a=0;
			while($query_row=mysqli_fetch_array($query)){
					$result['events'][$a]['title']="sample_title";
					$result['events'][$a]['service_engineer']="sample_engineer";
					$result['events'][$a]['date']=date("Y-m-d");
					$result['events'][$a]['event_alias']="sample_event_alias";
					$result['events'][$a]['event_type']="sample_event";
					$result['events'][$a]['className']="bg-primary";
				$event_type[$a]=$query_row['event_type'];
				$event_alias[$a]=$query_row['event_alias'];
				$p_level[$a]=$query_row['p_level'];
				if($event_type[$a]=='0'){
					$event_query=mysqli_query($mr_con,"SELECT * FROM ec_event_details WHERE event_alias='".$event_alias[$a]."' AND flag=0");
					if(mysqli_num_rows($event_query)){
						$event_row=mysqli_fetch_array($event_query);
						$result['events'][$a]['title']=alias($event_row['dpr_alias'],'ec_dpr_category','category_alias','category');//$event_row['title'];
						$result['events'][$a]['service_engineer']=$event_row['description'];
						$result['events'][$a]['date']=dateFormat($event_row['event_date'],'y');
						$result['events'][$a]['event_alias']=$event_row['event_alias'];
						$result['events'][$a]['event_type']="Event";
						if($p_level[$a]=='1'){$clcolor="bg-warning";}
						elseif($p_level[$a]=='2'){$clcolor="bg-danger";}
						elseif($p_level[$a]=='3'){$clcolor="bg-primary";}
						else{$clcolor="bg-success";}
						$result['events'][$a]['className'] = $clcolor;
					}else{$resCode='4'; $resMsg='No Records Found';}
				}elseif($event_type[$a]=='1'){
					$sql = mysqli_query($mr_con,"SELECT level,ticket_alias,ticket_id,service_engineer_alias,planned_date,activity_alias FROM ec_tickets WHERE ticket_alias='".$event_alias[$a]."' AND flag=0");
					if(mysqli_num_rows($sql)){
						$row = mysqli_fetch_array($sql);
						$activity_code = alias($row['activity_alias'],'ec_activity','activity_alias','activity_code');
						$result['events'][$a]['title'] = $row['ticket_id']."|".$activity_code;
						$result['events'][$a]['service_engineer'] = alias($row['service_engineer_alias'],'ec_employee_master','employee_alias','name');
						$result['events'][$a]['date'] = dateFormat($row['planned_date'],'y');
						$result['events'][$a]['event_type'] = "Ticket";
						//if($row['level']=='1'){$clcolor="bg-warning";}
						if($row['level']=='2' && date('Y-m-d')>$row['planned_date']){$clcolor="bg-danger";}
						//elseif($row['level']=='3'){$clcolor="bg-primary";}
						else{$clcolor="bg-success";}
						$result['events'][$a]['className'] = $clcolor;
						$result['events'][$a]['event_alias']=$row['ticket_alias'];
					}else{$resCode='4'; $resMsg='No Records Found';}
				}else{
					$dpr_sql = mysqli_query($mr_con,"SELECT * FROM ec_dpr WHERE dpr_alias='".$event_alias[$a]."' AND flag=0");
					if(mysqli_num_rows($dpr_sql)){
						$dpr_row = mysqli_fetch_array($dpr_sql);
						if($dpr_row['category_alias']!='0')$result['events'][$a]['title'] = alias($dpr_row['category_alias'],'ec_dpr_category','category_alias','category');else $result['events'][$a]['title']="DPR Not Submitted";
						$result['events'][$a]['service_engineer']=alias($dpr_row['emp_alias'],'ec_employee_master','employee_alias','name');
						$result['events'][$a]['event_alias']=$dpr_row['dpr_alias'];
						$result['events'][$a]['date'] = dateFormat($dpr_row['sub_date_time'],'y');
						$result['events'][$a]['event_type']="DPR";
						if($p_level[$a]=='1'){$clcolor="bg-warning";}
						elseif($p_level[$a]=='2'){$clcolor="bg-danger";}
						elseif($p_level[$a]=='3'){$clcolor="bg-primary";}
						else{$clcolor="bg-success";}
						$result['events'][$a]['className'] = $clcolor;
					}else{$resCode='4'; $resMsg='No Records Found';}
				}$a++;
			}$resCode='0'; $resMsg='Success!';
		}else{$resCode='4'; $resMsg='No Records!';$result['events']=array();}
		$result['add']=grantable('ADD','PLANNER',$emp_alias);
		$result['edit']=grantable('EDIT','PLANNER',$emp_alias);
		$result['delete']=grantable('DELETE','PLANNER',$emp_alias);
		$result['export']=grantable('EXPORT','PLANNER',$emp_alias);
		$role_alias = alias($emp_alias,'ec_employee_master','employee_alias','role_alias');
		$result['not_eng']=($role_alias=='QV9IPNVA1M' || $role_alias=='01ZMYJ4OLG' ? FALSE : TRUE);
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';}
	else{$resCode='2'; $resMsg='Account Locked';}
	$result['eventcount']=$a;
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	$tdays=getingdays($dates_from_to[0],$dates_from_to[1]);
	if($co) $sql = mysqli_query($mr_con,"SELECT count(id) as ccoo FROM ec_employee_master WHERE employee_alias IN ".$emp_sort." AND $location_sort flag=0");//role_alias IN (SELECT role_alias FROM ec_emprole WHERE role_stat IN ('0','1')) AND 
	else $sql = mysqli_query($mr_con,"SELECT count(id) as ccoo FROM ec_employee_master WHERE $location_sort status!='RELIEVED' AND flag=0");//role_alias IN (SELECT role_alias FROM ec_emprole WHERE role_stat IN ('0','1')) AND 
	if(mysqli_num_rows($sql)){
		$row = mysqli_fetch_array($sql);
		$emplist_count=$row['ccoo'];
	}else $emplist_count=0;
	$totalpower = $tdays*$emplist_count;
	$result['manpower']['totalpower']=$totalpower;
	$result['manpower']['engaged']=$b;
	$result['manpower']['vacant']=$totalpower-$b;
	echo json_encode($result);
}
function event_add(){ global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['token']));
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$alias=aliasCheck(generateRandomString(),' ec_event_details','event_alias');
		$title=mysqli_real_escape_string($mr_con,$_REQUEST['title']);
		$description=mysqli_real_escape_string($mr_con,$_REQUEST['description']);
		$dt=mysqli_real_escape_string($mr_con,$_REQUEST['event_date']);$cal=date("Y-m-d",strtotime($dt));$calibration_date=date("Y-m-d",strtotime($dt))." ".date("H:i:s");
		$employee_alias=$_REQUEST['employee_alias1'];
		if(isset($_REQUEST['employee_alias1']) && count($_REQUEST['employee_alias1'])>0){$empl_alias = implode(", ",$_REQUEST['employee_alias1']);}else{$empl_alias = '';}
		$dpr_alias=mysqli_real_escape_string($mr_con,$_REQUEST['dpr_alias']);
		if(empty($title)){
			$res="Please Select Title";
		}elseif(empty($description)){
			$res="Please Select Description";
		}elseif(empty($calibration_date)){
			$res="Please Select Date of the Event";
		}
		elseif(empty($employee_alias)){
			$res="Please Select Employee";
		}
		elseif(empty($dpr_alias)){
			$res="Please Select DPR";
			}
		else{
			$s=mysqli_query($mr_con,"SELECT id FROM ec_event_details WHERE event_date='$cal' AND employee_alias='$empl_alias' AND flag=0");
			if(mysqli_num_rows($s)==0){
				$query=mysqli_query($mr_con,"INSERT INTO ec_event_details(title,description,event_date,employee_alias,created_by,dpr_alias,event_alias) VALUES('$title','$description','$calibration_date','$empl_alias','$emp_alias','$dpr_alias','$alias')");
				if($query){
					for($i=0;$i<count($employee_alias);$i++){
						$calalias=aliasCheck(generateRandomString(),' ec_calender_event','alias');
						$sql=mysqli_query($mr_con,"INSERT INTO ec_calender_event(alias,event_alias,created_on,scheduled_on,emp_alias,p_level) VALUES('$calalias','$alias','".date('Y-m-d H:i:s')."','$calibration_date','".$employee_alias[$i]."', '1')");
						$num=alias($employee_alias[$i],'ec_employee_master','employee_alias','mobile_number');
						$dprname=alias($dpr_alias,'ec_dpr_category','category_alias','category');
						$msg="Dear Team, Activity  ".$dprname." is Assigned to you on dated ".$calibration_date.", Execute the same, For more details go through the email.";
						messageSent($num,$msg);
						//addevntmail($employee_alias[$i],$calibration_date,$title,$dprname);
					}
				}if($sql){$resCode='0'; $resMsg='Successfully Created';}else{$resCode='4'; $resMsg='Error in Creating';}
			}else{$resCode='4'; $resMsg='Event Already Exists';}
	}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';}
	else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function event_popup(){  
	global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['token']));
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$alias=$_REQUEST['alias'];
		$types=$_REQUEST['types'];
		if($types=="DPR") $typess='2';
		elseif($types=="Ticket") $typess='1';
		elseif($types=="Event") $typess='0';
		$query = "SELECT event_type,event_alias FROM ec_calender_event WHERE event_alias='$alias' AND event_type='$typess' AND flag=0";
		$sql=mysqli_query($mr_con, $query);
		$sql_row=mysqli_fetch_array($sql);
		$event_type=$sql_row['event_type'];
		$event_alias=$sql_row['event_alias'];
		$cal_evnt_alias=$sql_row['alias'];
		if($event_type=='0'){
			$event=mysqli_query($mr_con,"SELECT event_alias, created_by,title,description,event_date,employee_alias,dpr_alias FROM ec_event_details WHERE event_alias='".$event_alias."'");
			if(mysqli_num_rows($event)){
				$event_row=mysqli_fetch_array($event);
				$result['title']=$event_row['title'];
				$result['event_alias']=$event_row['event_alias'];
				$result['service_engineer']=$event_row['description'];
				$result['date']=$event_row['event_date'];
				$result['event_type']=$event_type; 
				$r = explode(",",$event_row['employee_alias']);
				foreach($r as $n){ $emp_name .= alias($n,'ec_employee_master','employee_alias','name').", "; }
				$result['role_alias'] = ["01ZMYJ4OLG","RWRKFNVF49", "QV9IPNVA1M"];
				$result['employee_alias'] = $r;
				$result['employee_name'] = trim($emp_name,", ");
				$result['created_by']=(strtoupper($event_row['created_by']) || empty($event_row['created_by'])=='ADMIN' ? 'ADMIN' : alias($event_row['created_by'],'ec_employee_master','employee_alias','name'));
				$result['dpr']=alias($event_row['dpr_alias'],'ec_dpr_category','category_alias','category');
				$resCode='0'; $resMsg='Successfully Created';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}elseif($event_type=='1'){
			$ticket_id = alias($_REQUEST['alias'],'ec_tickets','ticket_alias','ticket_id');
			if (strpos($ticket_id,"|")!== false){
				$tt = explode("|",$ticket_id);
				$ticket_id = $tt[0];
			}
			$result['main_ticket_id'] = $ticket_id;
			$result['main_ticket_alias'] = $_REQUEST['alias'];
			$lvl = alias($ticket_id,'ec_tickets','ticket_id','level');
			$old_lvl = alias($ticket_id,'ec_tickets','ticket_id','old_level');
			$purpose = alias($ticket_id,'ec_tickets','ticket_id','purpose');
			$planned_date = alias($ticket_id,'ec_tickets','ticket_id','planned_date');
			$result['level_code']=$lvl;
			$result['levelcolor']=($lvl=='1' || $lvl=='2' || $lvl=='4' || $lvl=='5' ? repl_planfail_tsrej($lvl,$old_lvl,$planned_date,$purpose,'color'):alias($lvl,'ec_levels','level_alias','level_color'));
			$result['level']=($lvl=='1' || $lvl=='2' || $lvl=='4' || $lvl=='5' ? repl_planfail_tsrej($lvl,$old_lvl,$planned_date,$purpose,'name'):alias($lvl,'ec_levels','level_alias','level_name'));
			$sqlTT = mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE (ticket_id LIKE '%".$ticket_id."|%' OR ticket_id='$ticket_id') AND flag=0");
			if(mysqli_num_rows($sqlTT)){$i=0;
				while($rowTT = mysqli_fetch_array($sqlTT)){
					$site_alias = $rowTT['site_alias'];
					$ticket_alias = $rowTT['ticket_alias'];
					$result['obj'][$i]['ticket_alias']=$rowTT['ticket_alias'];
					$result['obj'][$i]['main_ticket_id']=$ticket_id;
					$result['obj'][$i]['ticket_id']=$rowTT['ticket_id'];
					$result['obj'][$i]['activity']=alias($rowTT['activity_alias'],'ec_activity','activity_alias','activity_name');
					$sqlSite = mysqli_query($mr_con,"SELECT * FROM ec_sitemaster WHERE site_alias='$site_alias'");
					if(mysqli_num_rows($sqlSite)){
						$rowSite = mysqli_fetch_array($sqlSite);
						$result['obj'][$i]['zone_name']=alias($rowSite['zone_alias'],'ec_zone','zone_alias','zone_name');
						$result['obj'][$i]['state_name']=alias($rowSite['state_alias'],'ec_state','state_alias','state_name');
						$result['obj'][$i]['district_name']=alias($rowSite['district_alias'],'ec_district','district_alias','district_name');
						$result['obj'][$i]['segment_name']=alias($rowSite['segment_alias'],'ec_segment','segment_alias','segment_name');
						$result['obj'][$i]['customer_name']=alias($rowSite['customer_alias'],'ec_customer','customer_alias','customer_name');
						$result['obj'][$i]['site_type']=alias($rowSite['site_type_alias'],'ec_site_type','site_type_alias','site_type');
						$result['obj'][$i]['site_id']=$rowSite['site_id'];
						$result['obj'][$i]['site_name']=$rowSite['site_name'];
						$product = explode(", ",$rowSite['product_alias']);
						foreach($product as $pro){ $xx .= alias($pro,'ec_product','product_alias','product_description').", "; }
						$result['obj'][$i]['product_description']=trim($xx,", ");
						$result['obj'][$i]['battery_bank_rating']=$rowSite['battery_bank_rating'];
						$result['obj'][$i]['mfd_date']=dateFormat($rowSite['mfd_date'],'d');
						$result['obj'][$i]['install_date']=dateFormat($rowSite['install_date'],'d');
						$result['obj'][$i]['no_of_string']=$rowSite['no_of_string'];
						$result['obj'][$i]['technician_name']=$rowSite['technician_name'];
						$result['obj'][$i]['technician_number']=$rowSite['technician_number'];
						$result['obj'][$i]['manager_name']=$rowSite['manager_name'];
						$result['obj'][$i]['manager_number']=$rowSite['manager_number'];
						$result['obj'][$i]['manager_mail']=$rowSite['manager_mail'];
						$result['obj'][$i]['site_status']=(sitemanfdate_check($site_alias)>0 ? 'UNDER WARRANTY' : 'OUT OF WARRANTY');
						$result['obj'][$i]['site_address']=$rowSite['site_address'];
					}
					$sqlRem = mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE item_alias='$ticket_alias' AND module='TT' AND flag=0");
					if(mysqli_num_rows($sqlRem)){$j=0;
						while($rowRem = mysqli_fetch_array($sqlRem)){
							if($rowRem['remarked_by']=='admin'){
								$remarked_by='admin'; $designation='admin';
							}else{
								$remarked_by=alias($rowRem['remarked_by'],'ec_employee_master','employee_alias','name');
								$designation=alias(alias($rowRem['remarked_by'],'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','designation');
							}
							$result['obj'][$i]['remark'][$j]['remarkedby']=ucwords(strtolower($remarked_by));
							$result['obj'][$i]['remark'][$j]['designation']=ucwords(strtolower($designation));
							$result['obj'][$i]['remark'][$j]['remarkedon']=dateFormat($rowRem['remarked_on'],'d');
							$result['obj'][$i]['remark'][$j]['remark']=$rowRem['remarks'];
							$j++;
						}
					}else{$result['obj'][$i]['remark_length']=mysqli_num_rows($sqlRem);}
					$result['obj'][$i]['activity']=alias($rowTT['activity_alias'],'ec_activity','activity_alias','activity_name');
					$result['obj'][$i]['complaint']=alias($rowTT['complaint_alias'],'ec_complaint','complaint_alias','complaint_name');
					$result['obj'][$i]['description']=$rowTT['description'];
					$result['obj'][$i]['login_date']=($rowTT['login_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['login_date']))));
					$result['obj'][$i]['faulty_cell_count']=$rowTT['faulty_cell_count'];
					$result['obj'][$i]['activation_date']=checkempty(dateFormat($rowTT['activation_date'],'d'));
					$result['obj'][$i]['planned_date']=checkempty(dateFormat($rowTT['planned_date'],'d'));
					$result['obj'][$i]['closing_date']=($rowTT['closing_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['closing_date']))));
					$result['obj'][$i]['tat']=tat($ticket_alias);
					$result['obj'][$i]['payment_terms']=checkempty($rowTT['payment_terms']);
					$result['obj'][$i]['milestone']=checkempty(alias($rowTT['milestone'],'ec_milestone','mile_stone_alais','mile_stone'));
					$result['obj'][$i]['mode_of_contact']=$rowTT['mode_of_contact'];
					$result['obj'][$i]['contact_link']=baseurl()."images/reports/".$rowTT['contact_link'];
					$result['obj'][$i]['service_engineer_alias']=checkempty($rowTT['service_engineer_alias']);
					$result['obj'][$i]['service_engineer_name']=alias($rowTT['service_engineer_alias'],'ec_employee_master','employee_alias','name');
					$result['obj'][$i]['level_code']=$rowTT['level'];
					$result['obj'][$i]['old_level_code']=$rowTT['old_level'];
					$level = $rowTT['level'];
					$old_level = $rowTT['old_level'];
					$purpose = $rowTT['purpose'];
					$result['obj'][$i]['purpose']=$purpose;
					$result['obj'][$i]['levelcolor']=($level=='1' || $level=='2' || $level=='4' || $level=='5' ? repl_planfail_tsrej($level,$old_level,$rowTT['planned_date'],$purpose,'color'):alias($level,'ec_levels','level_alias','level_color'));
					$result['obj'][$i]['level']=($level=='1' || $level=='2' || $level=='4' || $level=='5' ? repl_planfail_tsrej($level,$old_level,$rowTT['planned_date'],$purpose,'name'):alias($level,'ec_levels','level_alias','level_name'));
					if($level == '1' || $level == '2'){$result['edit'] = grantable('PD','TICKETS',$emp_alias);}
					elseif($level == '3'){$result['edit'] = grantable('ZHS','TICKETS',$emp_alias);}
					elseif($level == '4'){$result['edit'] = grantable('NHS','TICKETS',$emp_alias);}
					elseif($level == '8'){$result['edit'] = grantable('TS','TICKETS',$emp_alias);}
					else{$result['edit'] = grantable('EDIT','TICKETS',$emp_alias);}
					$result['obj'][$i]['efsr_no']=$rowTT['efsr_no'];
					$result['obj'][$i]['fsrreport']=($rowTT['efsr_no']!='' ? "e-FSR" : "-");
					$result['obj'][$i]['efsr_date']=date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['efsr_date'])));
					$result['obj'][$i]['status']=$rowTT['status'];
					$result['event_type']=$event_type;
					$i++;
				}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}elseif($event_type=='2'){
			$dpr=mysqli_query($mr_con,"SELECT dpr_alias, dpr_ref_no,category_alias,emp_alias,remarks,expense_incurred,dpr_address,sub_date_time FROM ec_dpr WHERE dpr_alias='$event_alias'");
			$dpr_row=mysqli_fetch_array($dpr);
			if(mysqli_num_rows($dpr)){
				$result['dpr_ref_no']=$dpr_row['dpr_ref_no'];
				$result['dpr_alias'] = $dpr_row['dpr_alias'];
				$result['emp_alias'] = $dpr_row['emp_alias'];
				if($dpr_row['category_alias']!='0')$result['category'] = alias($dpr_row['category_alias'],'ec_dpr_category','category_alias','category');else $result['category']="DPR Not Submitted";
				$result['employee_name'] = alias($dpr_row['emp_alias'],'ec_employee_master','employee_alias','name');
				$result['remarks'] =$dpr_row['remarks'];
				$result['expense_incurred'] =$dpr_row['expense_incurred'];
				$result['tracking_alias'] =(!empty($dpr_row['dpr_address']) ? $dpr_row['dpr_address'] : "NA");
				$result['sub_date_time'] =$dpr_row['sub_date_time'];
				$result['event_type']=$event_type;
				$resCode='0'; $resMsg='Successfully Created';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function cexport(){ global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['token']));
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		require('../Classes/PHPExcel.php');
		require('../Classes/PHPExcel/IOFactory.php');
		$filename = 'Calender_'.date('d-m-Y H_i_s');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('Calender');
		$colArr=array('Employee Name','Title','Schedule Date','Event Type','Description');
		$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
		$ch = 'A';
		foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$ch++;
		}
		$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('mm/dd/yyyy');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$final_sort="";
		if(isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date'])){
			$from_date=dateFormat($_REQUEST['from_date'],'y');
			$final_sort.=" scheduled_on >= '".$from_date."' AND ";
			//$planned_date_sort=" planned_date >= '".$from_date."' AND ";
		}
		if(isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date'])){
			$to_date=dateFormat($_REQUEST['to_date'],'y');
			$final_sort.=" scheduled_on <='".$to_date." 23:59:59' AND ";
			//$planned_date_sort=" planned_date <='".$to_date." 23:59:59' AND ";
		}
		//if($emp_sort!="")$final_sort="event_alias IN (SELECT ticket_alias FROM ec_tickets WHERE $planned_date_sort service_engineer_alias IN ".$emp_sort." AND flag='0') AND event_type='1' AND ";
		
		if(isset($_REQUEST['role_alias']) && count($_REQUEST['role_alias'])>0 ){
			$final_sort.=" emp_alias IN (SELECT employee_alias FROM ec_employee_master WHERE role_alias IN('".implode("','",$_REQUEST['role_alias'])."') AND status!='RELIEVED' AND flag='0') AND ";
		}
		$query=mysqli_query($mr_con,"SELECT event_type,event_alias,scheduled_on FROM ec_calender_event WHERE $final_sort status=0 AND flag=0 GROUP BY event_alias");
		if(mysqli_num_rows($query)){
			while($query_row=mysqli_fetch_array($query)){
				$event_tp=$query_row['event_type'];
				$event_alias=$query_row['event_alias'];
				if($event_tp=='0'){
					$event_query=mysqli_query($mr_con,"SELECT * FROM ec_event_details WHERE event_alias='$event_alias' AND flag=0");
					if(mysqli_num_rows($event_query)){
						$event_row=mysqli_fetch_array($event_query);
						$title[]=alias($event_row['dpr_alias'],'ec_dpr_category','category_alias','category');
						$service_engineer[]=alias($event_row['employee_alias'],'ec_employee_master','employee_alias','name');
						$description[]=$event_row['description'];
						$date[]=dateFormat($event_row['event_date'],'y');
						$event_type[]="Event";
					}
				}elseif($event_tp=='1'){
					$sql = mysqli_query($mr_con,"SELECT level,ticket_alias,ticket_id,service_engineer_alias,planned_date,activity_alias FROM ec_tickets WHERE ticket_alias='$event_alias' AND flag=0");
					if(mysqli_num_rows($sql)){
						$row = mysqli_fetch_array($sql);
						$title[] = $row['ticket_id']."|".alias($row['activity_alias'],'ec_activity','activity_alias','activity_code');
						$service_engineer[] = alias($row['service_engineer_alias'],'ec_employee_master','employee_alias','name');
						$description[]="-";
						$date[] = dateFormat($row['planned_date'],'y');
						$event_type[] = "Ticket";
					}
				}else{
					$dpr_sql = mysqli_query($mr_con,"SELECT * FROM ec_dpr WHERE dpr_alias='$event_alias' AND flag=0");
					if(mysqli_num_rows($dpr_sql)){
						$dpr_row = mysqli_fetch_array($dpr_sql);
						if($dpr_row['category_alias']!='0')$title[] = alias($dpr_row['category_alias'],'ec_dpr_category','category_alias','category');
						else $title[]="DPR Not Submitted";
						$service_engineer[]=alias($dpr_row['emp_alias'],'ec_employee_master','employee_alias','name');
						$description[]="-";
						$date[] = dateFormat($dpr_row['sub_date_time'],'y');
						$event_type[]="DPR";
					}
				}
			}
			for($i=0;$i<=count($title);$i++){$j=($i+2);
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$j, $service_engineer[$i]);
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$j, $title[$i]);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$j, php_excel_date($date[$i]));
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$j, $event_type[$i]);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$j, $description[$i]);
			}
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save("../../exports/$filename.xlsx");
			$result['file_name']=$filename; 
			$resCode='0'; $resMsg='export';
		}else{$resCode='4'; $resMsg='No Records Found!';}
	}elseif($rex=='1'){$resCode='1'; $resMsg='Authentication Failed';}
	else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function dprexport(){ global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['token']));
	$rex=authentication($emp_alias,$token);
	if($rex==0){ $con="";
		require('../Classes/PHPExcel.php');
		require('../Classes/PHPExcel/IOFactory.php');
		$filename = 'DPR_'.date('d-m-Y H_i_s');
		$objPHPExcel = new PHPExcel();
		$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
		if(isset($_REQUEST['role_alias1']) && count($_REQUEST['role_alias1'])>0 )$con.=" emp_alias IN (SELECT employee_alias FROM ec_employee_master WHERE role_alias IN('".implode("','",$_REQUEST['role_alias1'])."') AND status!='RELIEVED' AND flag='0') AND ";
		if(isset($_REQUEST['employee_alias1']) && count($_REQUEST['employee_alias1'])>0 )$con.=" emp_alias IN ('".implode("','",$_REQUEST['employee_alias1'])."') AND ";
		if(isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date']))$con .= "sub_date_time >= '".dateFormat($_REQUEST['from_date'],'y')."' AND ";
		if(isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date']))$con .= "sub_date_time <= '".dateFormat($_REQUEST['to_date'],'y')." 23:59:59' AND ";
		$privilege_alias = alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias');
		$objPHPExcel->setActiveSheetIndex(0);
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setTitle('DPR');
		if($privilege_alias=='OX5E3EMI0U' || $privilege_alias=='WIMYJFDJPT' || $privilege_alias=='FJ40ECJNFY' || $privilege_alias=='5KPS8Q0ZNB' ||  admin_privilege($emp_alias) || $privilege_alias=='NCPAT7QPTK'){$con .= ''; $y = '1';} //ZHS, NHS, ZCo, HO, ADMIN, MD
		else{$con .= "emp_alias='$emp_alias' AND"; $y = '0';}
		$dprArr = array("DPR Date","DPR Number","Engineer Name","Zone","Category","Expense Incurred","Remarks","Start Travel Time","On Site Time","Off Site Time","End Travel Time","Total Hours","Ticket ID");
		for($af=0,$chr='A';$af<count($dprArr);$af++,$chr++){ $sheet->SetCellValue($chr."1", $dprArr[$af]); }
		if($y){$sheet->SetCellValue("N1", "DPR Location");$h = 'N1';}else{$h = 'M1';}
		$sheet->getStyle('A1:'.$h)->applyFromArray($styleArray);
		$sheet->getStyle('A1:'.$h)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
		foreach(array("A","H","I","J","K") as $da)$sheet->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension($da)->setAutoSize(true);
		$dpr_sql = mysqli_query($mr_con,"SELECT * FROM ec_dpr WHERE $con flag='0' ORDER BY sub_date_time");
		if(mysqli_num_rows($dpr_sql)){
			$i=2;while($dpr_row = mysqli_fetch_array($dpr_sql)){
					$zone_al = alias_flag_none($dpr_row['emp_alias'],'ec_employee_master','employee_alias','zone_alias');
					$zone_arr = explode(", ",$zone_al);$zz = '';
					foreach($zone_arr as $z){$zz .=  alias($z,'ec_zone','zone_alias','zone_name').",";}
				$sheet->SetCellValue("A".$i, php_excel_date($dpr_row['sub_date_time']))
					->SetCellValue("B".$i, checkemptydash($dpr_row['dpr_ref_no']))
					->SetCellValue("C".$i, checkemptydash(alias_flag_none($dpr_row['emp_alias'],'ec_employee_master','employee_alias','name')))
					->SetCellValue("D".$i, checkemptydash(rtrim($zz,",")))
					->SetCellValue("E".$i,(empty($dpr_row['category_alias']) ? 'DPR NOT SUBMITTED':alias($dpr_row['category_alias'],'ec_dpr_category','category_alias','category')))
					->SetCellValue("F".$i, checkemptydash($dpr_row['expense_incurred']))
					->SetCellValue("G".$i, checkemptydash($dpr_row['remarks']))
					->SetCellValue("H".$i, php_excel_date($dpr_row['start_trvl_time']))
					->SetCellValue("I".$i, php_excel_date($dpr_row['on_site_time']))
					->SetCellValue("J".$i, php_excel_date($dpr_row['off_site_time']))
					->SetCellValue("K".$i, php_excel_date($dpr_row['end_trvl_time']))
					->SetCellValue("L".$i, checkemptydash($dpr_row['total_hours']))
					->SetCellValue("M".$i, checkemptydash(alias($dpr_row['ticket_alias'],'ec_tickets','ticket_alias','ticket_id')));
				if($y){
					$dpr_address = $dpr_row['dpr_address'];
					$tracking_alias = $dpr_row['tracking_alias'];
					if(empty($dpr_address) && !empty($tracking_alias)){
						$query = "SELECT lat,lng FROM ec_user_tracking WHERE tracking_alias='$tracking_alias' AND (lat<>'0' OR lng<>'0') AND flag='0'";
						$strq=mysqli_query($mr_con, $query);
						if(mysqli_num_rows($strq)){
							$rtrq=mysqli_fetch_array($strq);
							$dpr_address = "Can't get address (latitude : ".$rtrq['lat'].", langtitude : ".$rtrq['lng'].")";
						}else $dpr_address = "-";
					}
					$sheet->SetCellValue("N".$i, $dpr_address);
				}
			$i++;
		}
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save("../../exports/$filename.xlsx");
			$result['file_name']=$filename; 
			$resCode='0'; $resMsg='export';
		}else {$resCode='4'; $resMsg='No Records Found To Run Report';}
	}elseif($rex=='1'){$resCode='1'; $resMsg='Authentication Failed';}
	else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function sending_emails(){ global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['token']));
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$monthNames = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		if(isset($_REQUEST['employee_alias1']) && count($_REQUEST['employee_alias1'])>0){
			for($axa=0;$axa<count($_REQUEST['employee_alias1']);$axa++){
				$employee_alias=mysqli_real_escape_string($mr_con,$_REQUEST['employee_alias1'][$axa]);
				$start_date=mysqli_real_escape_string($mr_con,$_REQUEST['from_date']);
				$end_date=mysqli_real_escape_string($mr_con,$_REQUEST['to_date']);
				$start_date_q=date('Y-m-d',strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['from_date'])));
				$end_date_q=date('Y-m-d',strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['to_date'])));
				if(isset($_REQUEST['p_level']) && count($_REQUEST['p_level'])>0){$event_type="'".implode("','",$_REQUEST['p_level'])."'";}else $event_type="'0','1','2'";
				$e_query=mysqli_query($mr_con,"SELECT event_type,event_alias,scheduled_on FROM ec_calender_event WHERE scheduled_on >='".$start_date_q."' AND scheduled_on <= '".$end_date_q."' AND event_type IN (".$event_type.") AND emp_alias='".$employee_alias."' AND status=0 AND flag=0 GROUP BY event_alias ORDER BY scheduled_on ASC");
				if(mysqli_num_rows($e_query)>0){		
					while($e_row=mysqli_fetch_array($e_query)){
						$event_types[]=$e_row['event_type'];
						$event_alias[]=$e_row['event_alias'];
						$event_dates[]=date('d-m-Y',strtotime($e_row['scheduled_on']));
					}
					$startDate=strtotime("$start_date");$endDate=strtotime("$end_date");
					while($startDate<=$endDate){$timestamp[] = mktime(0,0,0,date('m',$startDate),1,date('Y',$startDate));$startDate = strtotime( date('Y/m/01/',$startDate).' +1 month');}
					for($x=0;$x<count($timestamp);$x++){
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
											//$calDate=($i - $startday + 1)."-".date("m-Y",$timestamp[$x]);
											$calDate1=($i - $startday + 1)."-".date("m-Y",$timestamp[$x]); 
											$calDate=date('d-m-Y',strtotime($calDate1));
											if (in_array($calDate, $event_dates))$ax.="<td style='border:1px solid #e0e0e0;background:#31527b;color:#FFF;'>". ($i - $startday + 1) . "</td>";
											else $ax.="<td style='border:1px solid #e0e0e0;'>". ($i - $startday + 1) . "</td>";
										}
										if(($i%7)==6 ) $ax.="</tr>";
									}
								$ax.="</table>";
							$ax.="</td>";
						if(($abc%2)!='0')$ax.="</tr>";
					}
					$email_id=strtolower(alias($employee_alias,'ec_employee_master','employee_alias','email_id'));
					$name=strtoupper(alias($employee_alias,'ec_employee_master','employee_alias','name'));
					$body = "<html><body style='margin:0 auto;padding:10px;font-size:100%;font-family:Calibri;width:600px;'>";
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
					$subject="Works scheduled for the period ".date('d-M-Y',strtotime($start_date))." - ".date('d-M-Y',strtotime($end_date));
					$from=all_from_mail();
					$headers="From: EnerSys Care<$from>\r\n";
					$headers.="Reply-To: $from\r\n";
					$headers.="Return-Path: $from\r\n";
					$headers.= "CC: ticket@enersys.co.in \r\n";
					//$headers .= "BCC: $bccemail \r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$abc = mail($email_id,$subject,$body,$headers);
					//if($abc)return TRUE;else return FALSE;
					
					$num=alias($n,'ec_employee_master','employee_alias','mobile_number');
					$st_a = date("d-m-Y",strtotime($from_date));
					$et_a = date("d-m-Y",strtotime($to_date));
					$msg="Dear Team, Your works has been allocated  for the period ".$st_a." to ".$et_a.", Please check your email for more details";
					//messageSent($num,$msg);
					$resCode='0'; $resMsg='Successfully Mail Sent';
				}else{$resCode='4';$resMsg='No Records to Send';}
			}
		}else{$resCode='4';$resMsg='Select Employee';}
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function event_type_desc($fv1=1){
	if($fv1=='1') return "Ticket";
	elseif($fv1=='2') return "DPR";
	elseif($fv1=='0') return "Event";
}
function eventheading($fv1=1,$fv2){ global $mr_con;
	if($fv1=='1') return alias($fv2,'ec_tickets','ticket_alias','ticket_id');
	elseif($fv1=='2') return alias(alias($fv2,'ec_dpr','dpr_alias','category_alias'),'ec_dpr_category','category_alias','category');
	elseif($fv1=='0') return alias($fv2,'ec_event_details','event_alias','title')."  Description:".alias($fv2,'ec_event_details','event_alias','description');
}

function xyz($fsr_close_date){
	if(strpos($fsr_close_date,'—')!==false){list($a,$b) = explode("—",$fsr_close_date);}
	if(preg_match("/\d{4}\-\d{2}-\d{2}/", $fsr_close_date)){
		$start_date = date("Y-m-d", strtotime($fsr_close_date));
		$end_date=$start_date;
	}
	elseif(strpos($fsr_close_date,',')===false){
		$start_date = date("Y-m-d", strtotime($fsr_close_date));
		$end_date = date("Y-m-t", strtotime($fsr_close_date));
	}
	elseif(strpos($fsr_close_date,'—')===false){
		$start_date = date("Y-m-d", strtotime($fsr_close_date));
		$end_date=$start_date;
	}
	elseif(strpos($a,',')!==false){
		$start_date = date("Y-m-d", strtotime($a));
		$end_date = date("Y-m-d", strtotime($b));
	}elseif(preg_match("/[a-zA-Z]/", $b)){
		$year = substr($b, -4);
		$start_date = date("Y-m-d", strtotime($a.", ".$year));
		$end_date = date("Y-m-d", strtotime($b));
	}else{
		$month = substr($a, 0, 3);
		$year = substr($b, -4);
		$start_date = date("Y-m-d", strtotime($a.", ".$year));
		$end_date = date("Y-m-d", strtotime($month." ".$b));
	}
	if(strpos($start_date,'1970')!==false){$start_date = $fsr_close_date;}
	if(strpos($end_date,'1970')!==false){$end_date = $fsr_close_date;}
	//$start_date=date('Y-m-d', strtotime('-1 day', strtotime($start_date)));
	//$end_date=date('Y-m-d', strtotime('1 day', strtotime($end_date)));
	$arr = array($start_date,$end_date." 23:59:59");
	
	return $arr;
}
function getingdays($a,$b){
	/*$date1 = strtotime($a);
	$date2 = strtotime($b);
	$subTime = $date1 - $date2;
	return ($subTime/(60*60*24))%365;*/
	
	$date1 = strtotime($a); 
	$date2 = strtotime($b);
	$subTime = $date2 - $date1;
	$start = new DateTime($a);
	$end = new DateTime($b);
	$days = $start->diff($end, true)->days;
	
	$sundays = intval($days / 7) + ($start->format('N') + $days % 7 >= 7);
	return (($subTime/(60*60*24))%365)+1-$sundays;
}

function calender_event_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	$grantable = grantable('DELETE','PLANNER',$emp_alias);
	if(!$grantable){
		$resCode = 1;
		$resMsg='Authentication Failed!';
	}
	if($grantable && $rex==0) {
		
		$event_type = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['event_type'])));
		$event_type_num = null;
		if($event_type == 'EVENT') {
			$event_type_num = 0;
		}
		else if($event_type == 'DPR') {
			$event_type_num = 2;
		}
		$event_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['event_alias'])));
		$date = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['date'])));
		$remarks = mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks']));
		if(empty($remarks)){
			$res="Provide remarks";
		} else if(empty($event_alias) || empty($event_type)){
			$res="Invalid Request";
		} else {
			if($event_type_num == 0 || $event_type_num == 2) {
				$conditions = "event_type = '$event_type_num' AND status=0 AND flag=0 AND event_alias = '$event_alias'";
				$query = "SELECT event_type, event_alias, p_level, scheduled_on, emp_alias FROM ec_calender_event WHERE $conditions limit 1";
				$sql = mysqli_query($mr_con, $query);
				if(mysqli_num_rows($sql)>= 1) {
					$eventDetails = mysqli_fetch_array($sql);
					$eventEmpAlias = $eventDetails['emp_alias'];
					$query = "UPDATE ec_calender_event set `status` = 9 , flag = 1 WHERE $conditions";
					$sql = mysqli_query($mr_con, $query);
					if($sql) {
						$deleteQuery = "";
						$actionType = "EVENT";
						if($event_type_num == 0) {
							$deleteQuery = "UPDATE ec_event_details set flag = 1 where event_alias = '$event_alias'";
						} elseif($event_type_num == 2) {
							$deleteQuery = "UPDATE ec_dpr set flag = 1 where dpr_alias = '$event_alias'";
							$actionType = "DPR";
						}
						$sql = mysqli_query($mr_con, $deleteQuery);
						if(strtoupper($eventEmpAlias) == 'ADMIN'){
							$empName = "ADMIN";
						} else {
							$empName = alias($eventEmpAlias,'ec_employee_master','employee_alias','name');
						}
						$action = "$empName $actionType Deleted";
						user_history($emp_alias, $action, $_REQUEST['ip_addr'], $remarks);
						$resCode='0';
						$resMsg='Successful!';
					} else {
						$res = 'Failed to delete event.';	
						$res = $query;
					}
				}else{$res = "Invalid request. Event doesn't exist."; }
			} else {
				$res = "Invalid event type.";
			}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function event_update() {

	global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['token']));
	$rex=authentication($emp_alias,$token);
	$grantable = grantable('EDIT','PLANNER',$emp_alias);
	if($rex==0) {
		$event_alias = mysqli_real_escape_string($mr_con,$_REQUEST['event_alias']);
		$title=mysqli_real_escape_string($mr_con,$_REQUEST['title']);
		$description=mysqli_real_escape_string($mr_con,$_REQUEST['description']);
		$dt=mysqli_real_escape_string($mr_con,$_REQUEST['event_date']);
		$cal=date("Y-m-d",strtotime($dt));
		$calibration_date=date("Y-m-d",strtotime($dt))." ".date("H:i:s");
		$employee_alias=$_REQUEST['employee_alias1'];
		if(isset($_REQUEST['employee_alias1']) && count($_REQUEST['employee_alias1'])>0){
			$empl_alias = implode(", ",$_REQUEST['employee_alias1']);
		} else {
			$empl_alias = '';
		}
		if(isset($_REQUEST['role_alias1']) && count($_REQUEST['role_alias1'])>0){
			$role_alias = implode(", ",$_REQUEST['role_alias1']);
		} else {
			$role_alias = '';
		}
		$dpr_alias=mysqli_real_escape_string($mr_con,$_REQUEST['dpr_alias']);
		if(empty($event_alias)){
			$res="Event details are not suffient, please contact admin.";
		} elseif(empty($title)){
			$res="Please Select Title";
		} elseif(empty($description)){
			$res="Please Select Description";
		} elseif(empty($calibration_date)){
			$res="Please Select Date of the Event";
		} elseif(empty($empl_alias)){
			$res="Please Select Employee";
		} elseif(empty($role_alias)){
			$res="Please Select Role";
		} elseif(empty($dpr_alias)){
			$res="Please Select DPR";
		} else {
			$query = "SELECT id FROM ec_event_details WHERE event_date='$cal' AND employee_alias='$empl_alias' AND event_alias != '$event_alias' AND flag=0";
			$s = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($s)==0) {
				$query = "UPDATE ec_event_details set title = '$title' , description = '$description', event_date = '$calibration_date', employee_alias = '$empl_alias', role_alias = '$role_alias', dpr_alias = '$dpr_alias' where event_alias = '$event_alias'";
				$sql = mysqli_query($mr_con, $query);
				$fail = false;
				$calenderUpdateQuery = "UPDATE ec_calender_event SET `status` = 9 , flag = 1 WHERE event_alias = '$event_alias';";
				$updateSql = mysqli_query($mr_con, $calenderUpdateQuery);
				if($sql) {
					$calenderQuery = "";
					for($i=0;$i<count($employee_alias);$i++) {
						$calalias=aliasCheck(generateRandomString(),' ec_calender_event','alias');
						$calenderQuery = "INSERT INTO ec_calender_event(alias, event_alias, created_on, scheduled_on, emp_alias, p_level) VALUES ( '$calalias', '$event_alias', '". date('Y-m-d H:i:s') ."', '$calibration_date', '".$employee_alias[$i]."', '1');";
						$insertSql = mysqli_query($mr_con, $calenderQuery);
						if($insertSql) {
							$num = alias($employee_alias[$i],'ec_employee_master','employee_alias','mobile_number');
							$dprname = alias($dpr_alias,'ec_dpr_category','category_alias','category');
							$msg="Dear Team, Activity  ".$dprname." is Assigned to you on dated ".$calibration_date.", Execute the same, For more details go through the email.";
							messageSent($num, $msg);
							//addevntmail($employee_alias[$i],$calibration_date,$title,$dprname);
						} else {
							$fail = true;
						}
					}
				}
				if($sql && !$fail) {
					if(strtoupper($emp_alias) == 'ADMIN'){
						$empName = "ADMIN";
					} else {
						$empName = alias($emp_alias,'ec_employee_master','employee_alias','name');
					}
					$action = "$empName Event updated";
					user_history($emp_alias, $action, $_REQUEST['ip_addr']);
					$resCode='0'; 
					$resMsg='Successfully Updated';
				} else {
					$resCode='4'; 
					$resMsg='Error in Updating';
				}
			} else { 
				$resCode='4'; 
				$resMsg='Event Already Exists';
			}
		}
		if(isset($res)){
			$resCode='4';
			$resMsg=$res;
		}
	} elseif($rex==1) {
		$resCode='1'; $resMsg='Authentication Failed';
	} else { 
		$resCode='2'; $resMsg='Account Locked';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode; 
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}


function dpr_update() {

	global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['token']));
	$rex=authentication($emp_alias,$token);
	if($rex==0) {
		$dpr_alias = mysqli_real_escape_string($mr_con,$_REQUEST['dpr_alias']);
		$category = mysqli_real_escape_string($mr_con,$_REQUEST['category']);
		$remarks = mysqli_real_escape_string($mr_con,$_REQUEST['remarks']);
		$exp_incurred = mysqli_real_escape_string($mr_con,$_REQUEST['expense_incurred']);
		$employee_alias = $_REQUEST['employee_alias'];
		
		$dt = mysqli_real_escape_string($mr_con,$_REQUEST['sub_date_time']);
		$cal = date("Y-m-d H:i:s",strtotime($dt));
		$calibration_date = date("Y-m-d",strtotime($dt))." ".date("H:i:s");

		if(empty($dpr_alias)){
			$res="DPR details are not suffient, please contact admin.";
		} elseif(empty($category)){
			$res="Please Select category";
		} elseif(empty($remarks)){
			$res="Please provide remarks";
		} elseif(empty($calibration_date)){
			$res="Please Select Date of the Event";
		} elseif($exp_incurred!=0 && empty($exp_incurred)){
			$res="Please provide exp incurred ";
		} else {
			$query = "SELECT id FROM ec_dpr WHERE dpr_alias = '$dpr_alias' AND flag = 9";
			$s = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($s)==0) {
				$query = "UPDATE ec_dpr set category_alias = '$category' , remarks = '$remarks', sub_date_time = '$calibration_date', expense_incurred = '$exp_incurred' where dpr_alias = '$dpr_alias'";
				$sql = mysqli_query($mr_con, $query);
				$fail = false;
				$calenderUpdateQuery = "UPDATE ec_calender_event SET `status` = 9 , flag = 1 WHERE event_alias = '$dpr_alias';";
				$updateSql = mysqli_query($mr_con, $calenderUpdateQuery);
				if($sql) {
					$calenderQuery = "";
					for($i=0;$i<count($employee_alias);$i++) {
						$calalias=aliasCheck(generateRandomString(),' ec_calender_event','alias');
						$calenderQuery = "INSERT INTO ec_calender_event(alias, event_type, event_alias, created_on, scheduled_on, emp_alias, p_level) VALUES ( '$calalias', 2, '$dpr_alias', '". date('Y-m-d H:i:s') ."', '$calibration_date', '".$employee_alias[$i]."', '3');";
						$insertSql = mysqli_query($mr_con, $calenderQuery);
						if($insertSql) {
							$num = alias($employee_alias[$i],'ec_employee_master','employee_alias','mobile_number');
							$dprname = alias($dpr_alias,'ec_dpr_category','category_alias','category');
							$msg="Dear Team, Activity  ".$dprname." is Assigned to you on dated ".$calibration_date.", Execute the same, For more details go through the email.";
							messageSent($num, $msg);
							//addevntmail($employee_alias[$i],$calibration_date,$title,$dprname);
						} else {
							$fail = true;
						}
					}
				}
				if($sql && !$fail) {
					if(strtoupper($emp_alias) == 'ADMIN'){
						$empName = "ADMIN";
					} else {
						$empName = alias($emp_alias,'ec_employee_master','employee_alias','name');
					}
					$action = "$empName DPR updated";
					user_history($emp_alias, $action, $_REQUEST['ip_addr']);
					$resCode='0';$resMsg='Successful!';
					$resCode='0'; 
					$resMsg='Successfully Updated';
				} else {
					$resCode='4'; 
					$resMsg='Error in Updating';
				}
			} else { 
				$resCode='4'; 
				$resMsg='Event Already Exists';
			}
		}
		if(isset($res)){
			$resCode='4';
			$resMsg=$res;
		}
	} elseif($rex==1) {
		$resCode='1'; $resMsg='Authentication Failed';
	} else { 
		$resCode='2'; $resMsg='Account Locked';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode; 
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

?>
