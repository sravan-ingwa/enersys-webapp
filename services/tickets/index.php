<?php
date_default_timezone_set("Asia/Kolkata");
require '../Slim/Slim.php';
include ('../mysql.php');
include ('../functions.php');
include ('efsr_functions.php');
require('../Classes/PHPExcel.php');
require('../Classes/PHPExcel/IOFactory.php');
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->post('/ticket_add','ticket_add');
$app->post('/ticket_update','ticket_update');
$app->post('/ticket_adv_update','ticket_adv_update');
$app->post('/ticket_mul_view','ticket_mul_view');
$app->post('/ticket_view','ticket_view');
$app->post('/ticket_edit_view','ticket_edit_view');
$app->post('/ticket_export','ticket_export');
$app->post('/ticket_autocomplete','ticket_autocomplete');
$app->post('/online_ticket_add','online_ticket_add');
$app->post('/onlineTickets','onlineTickets');
$app->post('/mail_send','mail_send');
$app->post('/spotticket_mul_view','spotticket_mul_view');
$app->post('/spotticket_view','spotticket_view');
$app->post('/spotticket_update','spotticket_update');
$app->post('/tt_sitename_drop','tt_sitename_drop');
$app->post('/delete_spotticket','delete_spotticket');
$app->post('/delete_ticket','delete_ticket');
$app->post('/delete_ticket_efsr','delete_ticket_efsr');
$app->post('/emp_efsr_tickets','emp_efsr_tickets');
$app->post('/map_efsr_tickets','map_efsr_tickets');
$app->post('/efsr_details','efsr_details');

$app->run();

function onlineTickets(){ global $mr_con;
	if(isset($_REQUEST['emp_alias'])){$emp_alias = $_REQUEST['emp_alias'];}
	if(strtoupper($emp_alias)=='ADMIN'){$emp = "";}
	else{
		$state_alias  = alias($emp_alias,'ec_employee_master','employee_alias','state_alias');
		$states = "'".implode("','",explode(", ",$state_alias))."'";
		$emp = "state_alias IN ($states) AND";
	}
	if(isset($_REQUEST['alias']))$alias="site_id LIKE '%".mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']))."%' AND";else $alias="";
	$request = \Slim\Slim::getInstance()->request();
		$sql = mysqli_query($mr_con,"SELECT site_id,site_alias FROM ec_sitemaster WHERE $alias $emp flag=0");
		if(mysqli_num_rows($sql)>0){$i=0;
			while($row=mysqli_fetch_array($sql)){$result[$i]['site_id']=$row['site_id'];$result[$i]['site_status'] = sitemanfdate_check($row['site_alias']);$i++;}
		}else{$result[0]['site_id']="Add Manually";}
	echo json_encode($result);
}
function online_ticket_add(){ 
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = $_REQUEST['emp_alias']; $token = $_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$help = $_REQUEST['help'];
		$ticket_alias = aliasCheck(generateRandomString(),'ec_tickets','ticket_alias');
		$activity_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['activity_alias']));
		$complaint_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['complaint_alias']));
		$description = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['description']));
		$faulty_cell_count = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['faulty_cell_count']));
		$ticket_id = "ONTT".date("dmy").rand(0001,9999);
		if($help=="ticket"){
			$site_alias = alias(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_alias'])),'ec_sitemaster','site_id','site_alias');
			if(empty($activity_alias)){$res="Select Activity";}
			elseif(empty($site_alias)){$res="Select Site ID";}
			elseif($faulty_cell_count==''){$res="Enter Faulty Cell Count";}
			elseif(empty($complaint_alias)){$res="Select Complaint";}
			elseif(empty($description)){$res="Enter Description";}
			else{
				$query=mysqli_query($mr_con,"SELECT id FROM ec_tickets WHERE site_alias ='$site_alias' AND activity_alias='$activity_alias' AND level<>'6' AND level<>'7' AND flag='0'");
				if(mysqli_num_rows($query)==0){
					$tt_sql = mysqli_query($mr_con,"INSERT INTO ec_tickets(ticket_id,activity_alias,site_alias,complaint_alias,mode_of_contact,faulty_cell_count,description,login_date,level,status,warranty,ticket_alias,transaction_date)VALUES('$ticket_id','$activity_alias','$site_alias','$complaint_alias','".alias('1','ec_moc','moc_type','moc_alias')."','$faulty_cell_count','$description','".date('Y-m-d H:i:s')."','0','OPEN','".sitemanfdate_check($site_alias)."','$ticket_alias','".date('Y-m-d')."')");
					if($tt_sql){
						$action = "Customer Create the ticket against Site Name - ".alias($site_alias,'ec_sitemaster','site_alias','site_name');
						user_history($emp_alias,$action,$_REQUEST['ip_addr']);
						$resCode='0'; $resMsg="Request Taken Successfully, Ticket Number will receive to you Shortly.";
					}else{$res = 'Sorry Try Again';}
				}else{$res = 'The Requested SiteID and activity has already exist, Try with other values'; }
			}
		}else{
			$site_alias = aliasCheck(generateRandomString(),'ec_sitemaster','site_alias');
			$zone_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['zone_alias'])));
			$state_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['state_alias'])));
			$district_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['district_alias'])));
			$segment_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['segment_alias'])));
			$customer_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['customer_alias'])));
			$site_type_alias = strtoupper(trim(mysqli_real_escape_string($mr_con,$_REQUEST['site_type_alias'])));
			$site_id = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['site_id'])));
			$site_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['site_name'])));
			if(isset($_REQUEST['product_alias']) && count($_REQUEST['product_alias'])>0){$product_alias = implode(", ",$_REQUEST['product_alias']);}else{$product_alias = '';}
			$mfd_date = mysqli_real_escape_string($mr_con,dateFormat(trim($_REQUEST['mfd_date']),'y'));
			$install_date = mysqli_real_escape_string($mr_con,dateFormat(trim($_REQUEST['install_date']),'y'));
			$no_of_string = mysqli_real_escape_string($mr_con,trim($_REQUEST['no_of_string']));
			$technician_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['technician_name'])));
			$technician_number = mysqli_real_escape_string($mr_con,trim($_REQUEST['technician_number']));
			$manager_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['manager_name'])));
			$manager_number = mysqli_real_escape_string($mr_con,trim($_REQUEST['manager_number']));
			$manager_mail = strtolower(mysqli_real_escape_string($mr_con,trim($_REQUEST['manager_mail'])));
			$site_address = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['site_address'])));
			$batt_rating = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['batt_rating'])));
			
			if(empty($activity_alias)){$res="Select Activity";}
			elseif(empty($site_alias)){$res="Select Site ID";}
			elseif($faulty_cell_count==''){$res="Enter Faulty Cell Count";}
			elseif(empty($complaint_alias)){$res="Select Complaint";}
			elseif(empty($description)){$res="Enter Description";}
			
			elseif(empty($zone_alias)){$res="Select Zone";}
			elseif(empty($state_alias)){$res="Select State";}
			elseif(empty($district_alias)){$res="Select District";}
			elseif(empty($segment_alias)){$res="Select Segment";}
			elseif(empty($customer_alias)){$res="Select Customer";}
			elseif(empty($site_type_alias)){$res="Select Site Type";}
			elseif(empty($site_id)){$res="Enter Site ID";}
			elseif(empty($site_name)){$res="Enter Site Name";}
			elseif($product_alias==''){$res="Please Select Product";}
			elseif($mfd_date=='NA' && $install_date=='NA'){$res="Choose Manufactured Date OR Installation Date";}
			elseif(empty($no_of_string)){$res="Enter No Of String";}
			elseif(empty($technician_name)){$res="Enter Technician Name";}
			elseif(empty($technician_number)){$res="Enter Technician Number";}
			elseif(empty($manager_name)){$res="Enter Manager Name";}
			elseif(empty($manager_number)){$res="Enter Manager Number";}
			elseif(empty($manager_mail)){$res="Enter Manager Mail";}
			elseif(empty($site_address)){$res="Enter Site Address";}
			elseif(empty($batt_rating)){$res="Enter Battery Rating";}
			else{
				$query=mysqli_query($mr_con,"SELECT id FROM ec_sitemaster WHERE site_id ='$site_id' AND state_alias='$state_alias'");
				if(mysqli_num_rows($query)=='0'){
					$site_sql = mysqli_query($mr_con,"INSERT INTO ec_sitemaster(zone_alias,state_alias,district_alias,segment_alias,customer_alias,site_type_alias,site_id,site_name,site_alias,product_alias,mfd_date,install_date,no_of_string,technician_name,technician_number,manager_name,manager_number,manager_mail,site_address,battery_bank_rating,created_date,flag)VALUES('$zone_alias','$state_alias','$district_alias','$segment_alias','$customer_alias','$site_type_alias','$site_id','$site_name','$site_alias','$product_alias','$mfd_date','$install_date','$no_of_string','$technician_name','$technician_number','$manager_name','$manager_number','$manager_mail','$site_address','$batt_rating','".date('Y-m-d')."','1')");
					$tt_sql = mysqli_query($mr_con,"INSERT INTO ec_tickets(ticket_id,activity_alias,site_alias,complaint_alias,mode_of_contact,faulty_cell_count,description,login_date,level,status,warranty,ticket_alias,transaction_date)VALUES('$ticket_id','$activity_alias','$site_alias','$complaint_alias','".alias('1','ec_moc','moc_type','moc_alias')."','$faulty_cell_count','$description','".date('Y-m-d H:i:s')."','0','OPEN','".sitemanfdate_check($site_alias)."','$ticket_alias','".date('Y-m-d')."')");
					if($site_sql && $tt_sql){
						$action = "Customer Create the ticket and siteID against Site Name - $site_name";
						user_history($emp_alias,$action,$_REQUEST['ip_addr']);
						$resCode='0'; $resMsg="Request Taken Successfully, Ticket Number will receive to you Shortly.";
					}else{$res = 'Sorry Try Again';}
				}else{$res = 'The Requested SiteID and State has already exist, Try with other values'; }
			}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function ticket_add(){ 
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = $_REQUEST['emp_alias']; $token = $_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	ob_start();
	if($rex==0){
		$alias = aliasCheck(generateRandomString(),'ec_tickets','ticket_alias');
		$activity_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['activity_alias']));
		$site_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_alias']));
		$complaint_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['complaint_alias']));
		$mode_of_contact = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mode_of_contact']));
		$description = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['description']));
		$faulty_cell_count = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['faulty_cell_count']));
		if(empty($activity_alias)){$res="Select Activity";}
		elseif(empty($site_alias)){$res="Select Site ID";}
		elseif($faulty_cell_count==''){$res="Enter Faulty Cell Count";}
		elseif(empty($complaint_alias)){$res="Select Complaint";}
		elseif(empty($mode_of_contact)){$res="Select Mode Of Complaint";}
		elseif(empty($description)){$res="Enter Description";}
		else{
			$activity_code=alias($activity_alias,'ec_activity','activity_alias','activity_code');
			$segment_alias=(isset($_REQUEST['segment_alias']) ? strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['segment_alias'])) : "");
			if(empty($segment_alias)){ //Other than Other Segment
				$ticket_id = ticketsID($site_alias,alias(alias($site_alias,'ec_sitemaster','site_alias','state_alias'),'ec_state','state_alias','state_code'),1);
				$po_number=$po_date=$po_link=''; $at_check='1';
				$activity_type=alias($activity_alias,'ec_activity','activity_alias','activity_type');
				$site_name=alias($site_alias,'ec_sitemaster','site_alias','site_name');
				$state_alias=alias($site_alias,'ec_sitemaster','site_alias','state_alias');
				$notif_msg="Dear Team, New Complaint has been registered against the $activity_code of Site name-$site_name Ticket No- $ticket_id in your State.";
				if($activity_type=='0'){
					$po_number = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['po_number']));
					$po_date = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['po_date']));
					if(empty($po_number)){$at_check="Enter PO Number";}
					elseif(empty($po_date)){$at_check="Choose PO Date";}
					else{
						if(isset($_FILES['po_file']) && !empty($_FILES['po_file']['name'])){
							$po_file=$_FILES['po_file'];
							$p_link = upload_file($po_file,str_replace("&","_N_",$activity_code).'_PO_FILE','pdf');
							list($po_code,$po_msg) = explode(",",$p_link);
							if($po_code=='0'){
								$po_link = $po_msg;
							}else $at_check = $po_msg;
						}else $at_check = "Please Choose PO File";
					}
				}
				if($at_check!='1')$res=$at_check;
				else{
					$moc_pdf=alias($mode_of_contact,'ec_moc','moc_alias','moc_file');
					$moc_text=alias($mode_of_contact,'ec_moc','moc_alias','moc_text');
					$moc_file=$moc_num=$res = "";
					if($moc_pdf=='1'){
						if(isset($_FILES['moc_file']) && !empty($_FILES['moc_file']['name'])){
							$moc_file=$_FILES['moc_file'];
						}else{$res = "Please Choose ".alias($mode_of_contact,'ec_moc','moc_alias','moc_name')." File";}
					}
					if($moc_text=='1'){
						if(isset($_REQUEST['moc_number']) && !empty($_REQUEST['moc_number'])){
							$moc_num=mysqli_real_escape_string($mr_con,$_REQUEST['moc_number']);
						}else{$res = "Please Enter".alias($mode_of_contact,'ec_moc','moc_alias','moc_name')." File";}
					}
					if(empty($res)){
						$query=mysqli_query($mr_con,"SELECT id FROM ec_tickets WHERE site_alias ='$site_alias' AND activity_alias='$activity_alias' AND level<>'6' AND level<>'7' AND flag='0'");
						if(mysqli_num_rows($query)==0){
							$num=alias($site_alias,'ec_sitemaster','site_alias','technician_number');
							//$msg="Greetings from Enersys, your complaint has been registered against the ".$activity_code." of Site name-".alias($site_alias,'ec_sitemaster','site_alias','site_name')." Ticket No- ".$ticket_id;
							//Message Updated 18.09.2021 as per Ravi request
							$msg="GREETINGS FROM ENERSYS, YOUR COMPLAINT HAS BEEN REGISTERED AGAINST THE AT OF SITE NAME-".alias($site_alias,'ec_sitemaster','site_alias','site_name')." Ticket No- ".$ticket_id;

							$action = $ticket_id." Ticket Created";
							if(!empty($moc_file)){
								$link = upload_file($moc_file,str_replace(" ","_",alias($mode_of_contact,'ec_moc','moc_alias','moc_name')),'pdf');
								list($code,$msg1) = explode(",",$link);
								if($code=='0'){ $contact_link = $msg1;
									$sql = mysqli_query($mr_con,"INSERT INTO ec_tickets(ticket_id,activity_alias,site_alias,complaint_alias,faulty_cell_count,mode_of_contact,contact_link,moc_num,description,login_date,level,status,warranty,po_number,po_date,po_link,ticket_alias,transaction_date)VALUES('$ticket_id','$activity_alias','$site_alias','$complaint_alias','$faulty_cell_count','$mode_of_contact','$contact_link','$moc_num','$description','".date('Y-m-d H:i:s')."','1','OPEN','".sitemanfdate_check($site_alias)."','$po_number','".dateFormat($po_date,'y')."','$po_link','$alias','".date('Y-m-d')."')");
									if($sql){
										$sql_inv = mysqli_query($mr_con,"INSERT INTO ec_tickets_inventory(ticket_alias)VALUES('$alias')");
										ticket_notification($alias,$notif_msg);
										user_history($emp_alias,$action,$_REQUEST['ip_addr']);
										ecSendSms('new_tt_registration', $state_alias, $num, $msg);
										/*
										messageSent($num,$msg);
										zoneMsg($activity_code,$site_alias,$ticket_id);
										*/
										curlxing(localURL()."services/tickets/mails/new_ticket_mail?site_alias=".$site_alias."&ticket_alias=".$alias);
										$resCode='0'; 
										$resMsg="Successful ".$ticket_id." Ticket Created";
									}
								}else{$res = $msg1.', Try again!';}
							}else{
								$contact_link='0';
								$sql = mysqli_query($mr_con,"INSERT INTO ec_tickets(ticket_id,activity_alias,site_alias,complaint_alias,faulty_cell_count,mode_of_contact,contact_link,moc_num,description,login_date,level,status,warranty,po_number,po_date,po_link,ticket_alias,transaction_date)VALUES('$ticket_id','$activity_alias','$site_alias','$complaint_alias','$faulty_cell_count','$mode_of_contact','$contact_link','$moc_num','$description','".date('Y-m-d H:i:s')."','1','OPEN','".sitemanfdate_check($site_alias)."','$po_number','".dateFormat($po_date,'y')."','$po_link','$alias','".date('Y-m-d')."')");
								if($sql){
									$sql_inv = mysqli_query($mr_con,"INSERT INTO ec_tickets_inventory(ticket_alias)VALUES('$alias')");
									ticket_notification($alias,$notif_msg);
									user_history($emp_alias,$action,$_REQUEST['ip_addr']);
									/*
									messageSent($num,$msg);
									zoneMsg($activity_code,$site_alias,$ticket_id);
									*/
									ecSendSms('new_tt_registration', $state_alias, $num, $msg);
									curlxing(localURL()."services/tickets/mails/new_ticket_mail?site_alias=".$site_alias."&ticket_alias=".$alias);
									$resCode='0'; $resMsg="Successful ".$ticket_id." Ticket Created";
								}
							}
							if(isset($_REQUEST['remarks']) && !empty($_REQUEST['remarks'])){
								$remarks = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['remarks']));
								$rem_alias=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
								$sqlRem = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','TT','3','$alias','$emp_alias','$rem_alias')");
							}
							if(isset($_REQUEST['at_ic_rem']) && !empty($_REQUEST['at_ic_rem'])){
								$at_ic_rem = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['at_ic_rem']));
								$rem_alias2=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
								$sqlRem2 = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$at_ic_rem','TT','4','$alias','$emp_alias','$rem_alias2')");
							}
						}else{$res = 'The Requested SiteID and activity has already exist, Try with other values'; }
					}
				}
			}else{ //Other Segment
				$site_id=$site_alias;
				$zone_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['zone_alias']));
				$state_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['state_alias']));
				$district_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['district_alias']));
				$customer_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['customer_alias']));
				$product_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['product_alias']));
				$site_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_name']));
				
				$site_type_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_type_alias']));
				$batt_rating = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['batt_rating']));
				$mfd_date = dateFormat(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mfd_date'])),'y');
				$install_date = dateFormat(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['install_date'])),'y');
				$sale_invoice_date = dateFormat(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['sale_invoice_date'])),'y');
				$po_num = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['po_num']));
				$sale_invoice_num = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['sale_invoice_num']));
				$no_of_string = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['no_of_string']));
				
				$site_address = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_address']));
				$technician_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['technician_name']));
				$technician_number = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['technician_number']));
				$manager_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['manager_name']));
				$manager_number = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['manager_number']));
				$manager_mail = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['manager_mail']));
				if(empty($zone_alias))$res="Select Zone";
				elseif(empty($state_alias))$res="Select State";
				elseif(empty($district_alias))$res="Select District";
				elseif(empty($customer_alias))$res="Select Customer";
				elseif(empty($product_alias))$res="Select Product";
				elseif(empty($site_name))$res="Enter Site Name";
				elseif(empty($site_address))$res="Enter Site Address";
				elseif(empty($technician_name))$res="Enter Technician Name";
				elseif(empty($technician_number))$res="Enter Technician Number";
				elseif(empty($manager_name))$res="Enter Manager Name";
				elseif(empty($manager_number))$res="Enter Manager Number";
				elseif(empty($manager_mail))$res="Enter Manager Mail";
				else{
					$ticket_id = ticketsID("",alias($state_alias,'ec_state','state_alias','state_code'),1);
					$notif_msg="Dear Team, New Complaint has been registered against the $activity_code of Site name- $site_name Ticket No- $ticket_id in your State.";
					$moc_pdf=alias($mode_of_contact,'ec_moc','moc_alias','moc_file');
					$moc_text=alias($mode_of_contact,'ec_moc','moc_alias','moc_text');
					$moc_file=$moc_num=$res = "";
					if($moc_pdf=='1'){
						if(isset($_FILES['moc_file']) && !empty($_FILES['moc_file']['name'])){
							$moc_file=$_FILES['moc_file'];
						}else{$res = "Please Choose ".alias($mode_of_contact,'ec_moc','moc_alias','moc_name')." File";}
					}
					if($moc_text=='1'){
						if(isset($_REQUEST['moc_number']) && !empty($_REQUEST['moc_number'])){
							$moc_num=mysqli_real_escape_string($mr_con,$_REQUEST['moc_number']);
						}else{$res = "Please Enter".alias($mode_of_contact,'ec_moc','moc_alias','moc_name')." File";}
					}
					if(empty($res)){
						$query=mysqli_query($mr_con,"SELECT t1.id FROM ec_tickets t1 INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias WHERE t1.activity_alias='$activity_alias' AND t2.state_alias='$state_alias' AND customer_alias='$customer_alias' AND t1.level<>'6' AND t1.level<>'7' AND t1.flag='0' AND t2.flag<>'0'");
						if(mysqli_num_rows($query)==0){
							$site_alias = aliasCheck(generateRandomString(),'ec_sitemaster','site_alias');
							$sqls = mysqli_query($mr_con,"INSERT INTO ec_sitemaster(zone_alias,state_alias,district_alias,segment_alias,customer_alias,site_type_alias,site_id,site_name,site_alias,product_alias,mfd_date,install_date,no_of_string,technician_name,technician_number,manager_name,manager_number,manager_mail,site_address,battery_bank_rating,sale_invoice_num,sale_invoice_date,po_num,created_date,flag)VALUES('$zone_alias','$state_alias','$district_alias','$segment_alias','$customer_alias','$site_type_alias','$site_id','$site_name','$site_alias','$product_alias','$mfd_date','$install_date','$no_of_string','$technician_name','$technician_number','$manager_name','$manager_number','$manager_mail','$site_address','$batt_rating','$sale_invoice_num','$sale_invoice_date','$po_num','".date('Y-m-d')."','2')");
							//$msg="Greetings from Enersys, your complaint has been registered against the ".$activity_code." of Site name- ".$site_name." Ticket No- ".$ticket_id;
							$msg="GREETINGS FROM ENERSYS, YOUR COMPLAINT HAS BEEN REGISTERED AGAINST THE AT OF SITE NAME-".alias($site_alias,'ec_sitemaster','site_alias','site_name')." Ticket No- ".$ticket_id;
							
							$action = "Other Segment ".$ticket_id." Ticket Created";
							if(!empty($moc_file)){
								$link = upload_file($moc_file,str_replace(" ","_",alias($mode_of_contact,'ec_moc','moc_alias','moc_name')),'pdf');
								list($code,$msg1) = explode(",",$link);
								if($code=='0'){ $contact_link = $msg1;
									$sql = mysqli_query($mr_con,"INSERT INTO ec_tickets(ticket_id,activity_alias,site_alias,complaint_alias,faulty_cell_count,mode_of_contact,contact_link,moc_num,description,login_date,level,status,warranty,po_number,po_date,po_link,ticket_alias,transaction_date)VALUES('$ticket_id','$activity_alias','$site_alias','$complaint_alias','$faulty_cell_count','$mode_of_contact','$contact_link','$moc_num','$description','".date('Y-m-d H:i:s')."','1','OPEN','".sitemanfdate_check($site_alias)."','$po_number','".dateFormat($po_date,'y')."','$po_link','$alias','".date('Y-m-d')."')");
									if($sql){
										$sql_inv = mysqli_query($mr_con,"INSERT INTO ec_tickets_inventory(ticket_alias)VALUES('$alias')");
										ticket_notification($alias,$notif_msg);
										user_history($emp_alias,$action,$_REQUEST['ip_addr']);
										/*
										messageSent($$technician_number,$msg);
										zoneMsg($activity_code,$site_alias,$ticket_id);
										*/
										ecSendSms('new_tt_registration', $state_alias, $num, $msg);
										curlxing(localURL()."services/tickets/mails/new_ticket_mail?site_alias=".$site_alias."&ticket_alias=".$alias);
										$resCode='0'; $resMsg="Successful ".$ticket_id." Ticket Created";
									}
								}else{$res = $msg1.', Try again!';}
							}else{
								$contact_link='0';
								$sql = mysqli_query($mr_con,"INSERT INTO ec_tickets(ticket_id,activity_alias,site_alias,complaint_alias,faulty_cell_count,mode_of_contact,contact_link,moc_num,description,login_date,level,status,warranty,po_number,po_date,po_link,ticket_alias,transaction_date)VALUES('$ticket_id','$activity_alias','$site_alias','$complaint_alias','$faulty_cell_count','$mode_of_contact','$contact_link','$moc_num','$description','".date('Y-m-d H:i:s')."','1','OPEN','".sitemanfdate_check($site_alias)."','$po_number','".dateFormat($po_date,'y')."','$po_link','$alias','".date('Y-m-d')."')");
								if($sql){
									$sql_inv = mysqli_query($mr_con,"INSERT INTO ec_tickets_inventory(ticket_alias)VALUES('$alias')");
									ticket_notification($alias,$notif_msg);
									user_history($emp_alias,$action,$_REQUEST['ip_addr']);
									/*
									messageSent($$technician_number,$msg);
									zoneMsg($activity_code,$site_alias,$ticket_id);
									*/
									ecSendSms('new_tt_registration', $state_alias, $num, $msg);
									curlxing(localURL()."services/tickets/mails/new_ticket_mail?site_alias=".$site_alias."&ticket_alias=".$alias);
									$resCode='0'; $resMsg="Successful ".$ticket_id." Ticket Created";
								}
							}
							if(isset($_REQUEST['remarks']) && !empty($_REQUEST['remarks'])){
								$remarks = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['remarks']));
								$rem_alias=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
								$sqlRem = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','TT','3','$alias','$emp_alias','$rem_alias')");
							}
							if(isset($_REQUEST['at_ic_rem']) && !empty($_REQUEST['at_ic_rem'])){
								$at_ic_rem = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['at_ic_rem']));
								$rem_alias2=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
								$sqlRem2 = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$at_ic_rem','TT','4','$alias','$emp_alias','$rem_alias2')");
							}
						}else{$res = 'The Requested SiteID and activity has already exist, Try with other values'; }
					}
				}
			}
		}if(!empty($res)){$resCode='4'; $resMsg=$res;}
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	ob_end_clean();
	echo json_encode($result);
}
function ticket_mul_view(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		if($_REQUEST['ticketId']!="")$c1="t1.ticket_id LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['ticketId'])."%' AND ";else $c1="";
		if($_REQUEST['loginDate']!="")$c2="t1.login_date LIKE '%".mysqli_real_escape_string($mr_con,dateFormat($_REQUEST['loginDate'],'y'))."%' AND ";else $c2="";
		if($_REQUEST['activityAlias']!="")$c3="t5.activity_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['activityAlias'])."' AND ";else $c3="";
		if($_REQUEST['segmentAlias']!="")$c4="t4.segment_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['segmentAlias'])."' AND ";else $c4="";
		if($_REQUEST['siteId']!="")$c5="t2.site_name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['siteId'])."%' AND ";else $c5="";
		if($_REQUEST['customerName']!="")$c6="t3.customer_code LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['customerName'])."%' AND ";else $c6="";
		if($_REQUEST['levels']!=""){
			$lvl = mysqli_real_escape_string($mr_con,$_REQUEST['levels']);			
			$c7 = levelCheck($lvl)."t1.level<>'5' AND ";
		}else $c7="t1.level<>'5' AND ";
		if($_REQUEST['tat']!="")$c8="t1.tat ='".mysqli_real_escape_string($mr_con,$_REQUEST['tat'])."' AND ";else $c8="";
		if($_REQUEST['visits']!=""){$c9="t1.n_visits = '".mysqli_real_escape_string($mr_con,$_REQUEST['visits'])."' AND ";}else{$c9="";}
		if(strtoupper($emp_alias)!='ADMIN'){
			$recq=mysqli_query($mr_con,"SELECT q1.role_stat FROM ec_emprole q1 INNER JOIN ec_employee_master q2 ON q1.role_alias=q2.role_alias WHERE q2.employee_alias='$emp_alias'");
			$rowq=mysqli_fetch_array($recq);
			$role_stat=$rowq['role_stat'];$c10="";
			if($role_stat=='0' || $role_stat=='1')$c10="t1.level='2' AND t1.service_engineer_alias='$emp_alias' AND ";
			else{
				$sss=mysqli_query($mr_con,"SELECT state_alias,segment_alias,customer_alias FROM ec_employee_master WHERE employee_alias='$emp_alias' AND flag='0'");
				if(mysqli_num_rows($sss)){
					$rrr=mysqli_fetch_array($sss);
					$state_alias=$rrr['state_alias'];
					$segment_alias=$rrr['segment_alias'];
					$customer_alias=$rrr['customer_alias'];
					if(!empty($segment_alias))$c10.= "t2.segment_alias IN ('".implode("','",explode(", ",$segment_alias))."') AND ";
					if(!empty($customer_alias))$c10.= "t2.customer_alias IN ('".implode("','",explode(", ",$customer_alias))."') AND ";
					if(!empty($state_alias))$c10.= "(t2.state_alias IN ('".implode("','",explode(", ",$state_alias))."') OR (t1.level='2' AND t1.service_engineer_alias='$emp_alias')) AND ";
				}
			}
		}
		if($_REQUEST['report']!="")$c11="t1.ticket_alias IN (".report_sort($_REQUEST['report']).") AND ";else $c11="";
		if($_REQUEST['mrs']!="")$c12="t1.ticket_alias IN (".mrs_sort($_REQUEST['mrs']).") AND ";else $c12="";

		$cond=$c1.$c2.$c3.$c4.$c5.$c6.$c7.$c8.$c9.$c10.$c11.$c12;
		$sq=mysqli_query($mr_con,"SET GLOBAL group_concat_max_len = 1000000");
		$query = "SELECT COUNT(DISTINCT SUBSTRING_INDEX(t1.ticket_id,'|',1)) AS totalListing FROM ec_tickets t1
		INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias
		INNER JOIN ec_customer t3 ON t2.customer_alias=t3.customer_alias
		INNER JOIN ec_segment t4 ON t2.segment_alias=t4.segment_alias
		INNER JOIN ec_activity t5 ON t1.activity_alias=t5.activity_alias
		WHERE $cond t1.flag='0'";
		$rec=mysqli_query($mr_con,$query);
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row['totalListing'];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			$totalpages=ceil($totalRecords/$limit);
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$selQuery = "SELECT t1.ticket_alias,SUBSTRING_INDEX(t1.ticket_id,'|',1) AS ticket_idx,t1.login_date,t1.purpose,t1.planned_date,t1.level,t1.old_level,t1.status,t1.tat,t1.esca_efsr_link,t1.efsr_start,t1.efsr_date,t1.efsr_no,t1.n_visits,t2.site_name,t2.site_id,t3.customer_code,t3.customer_name,t4.segment_code,t4.segment_name,t5.activity_code,t5.activity_name,t6.level_name,t6.level_color FROM ec_tickets t1
			INNER JOIN (SELECT MAX(ID) AS ID FROM ec_tickets WHERE flag='0' GROUP BY SUBSTRING_INDEX(ticket_id,'|',1)) AS P ON (t1.ID=P.ID)
			INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias
			INNER JOIN ec_customer t3 ON t2.customer_alias=t3.customer_alias
			INNER JOIN ec_segment t4 ON t2.segment_alias=t4.segment_alias
			INNER JOIN ec_activity t5 ON t1.activity_alias=t5.activity_alias
			INNER JOIN ec_levels t6 ON t1.level=t6.level_alias
			WHERE $cond t1.flag='0' ORDER BY t1.id DESC LIMIT $offset, $limit";
			$sqlTT = mysqli_query($mr_con, $selQuery);
			$result['ticketDetails']=array();
			if(mysqli_num_rows($sqlTT)){
				$i=0;while($rowTT = mysqli_fetch_array($sqlTT)){
					$result['ticketDetails'][$i]['ticket_alias']=$rowTT['ticket_alias'];
					$result['ticketDetails'][$i]['ticket_id']=$rowTT['ticket_idx'];//(strpos($rowTT['ticket_id'],"|")!==false ? strtok($rowTT['ticket_id'], "|") : $rowTT['ticket_id']);
					$result['ticketDetails'][$i]['login_date']=dateFormat($rowTT['login_date'],'d');
					$result['ticketDetails'][$i]['activity']=$rowTT['activity_code'];
					$result['ticketDetails'][$i]['levelcolor']=($rowTT['level']=='1' || $rowTT['level']=='2' || $rowTT['level']=='4' || $rowTT['level']=='5' ? repl_planfail_tsrej($rowTT['level'],$rowTT['old_level'],$rowTT['planned_date'],$rowTT['purpose'],'color'):$rowTT['level_color']);
					$result['ticketDetails'][$i]['levelname']=($rowTT['level']=='1' || $rowTT['level']=='2' || $rowTT['level']=='4' || $rowTT['level']=='5' ? repl_planfail_tsrej($rowTT['level'],$rowTT['old_level'],$rowTT['planned_date'],$rowTT['purpose'],'name'):$rowTT['level_name']);
					$result['ticketDetails'][$i]['pl_levelname']=($rowTT['level']=='2' ? $rowTT['planned_date']:($rowTT['level']=='1' || $rowTT['level']=='4' || $rowTT['level']=='5' ? repl_planfail_tsrej($rowTT['level'],$rowTT['old_level'],$rowTT['planned_date'],$rowTT['purpose'],'name') : $rowTT['level_name']));
					$result['ticketDetails'][$i]['level']=$rowTT['level'];
					$result['ticketDetails'][$i]['status']=$rowTT['status'];
					$result['ticketDetails'][$i]['tat']=(!empty($rowTT['tat']) ? $rowTT['tat'] : tat($rowTT['ticket_alias']));//checkempty($rowTT['tat']);
					$result['ticketDetails'][$i]['visits']=$rowTT['n_visits'];//visits($result['ticketDetails'][$i]['ticket_id']);
					if($rowTT['efsr_no']!=''){
						$result['ticketDetails'][$i]['efsr_date']=$rowTT['efsr_date'];
						if($rowTT['esca_efsr_link']!=''){
							$result['ticketDetails'][$i]['fsrreport']='2';
							$result['ticketDetails'][$i]['esca_efsr_link']=newBaseURL()."images/esca_efsr/".$rowTT['esca_efsr_link'];
						}else{
							$result['ticketDetails'][$i]['fsrreport']='1';
							$result['ticketDetails'][$i]['esca_efsr_link']=newBaseURL().(empty($rowTT['efsr_start']) ? "enersyscare_v2":"mobile_app")."/pdf/index.php?ticket_alias=".$rowTT['ticket_alias'];
						}
					}else{$result['ticketDetails'][$i]['fsrreport']=0;}
					$result['ticketDetails'][$i]['mrf'] = mrfStatus($rowTT['ticket_alias']);
						$result['ticketDetails'][$i]['segment_code']=$rowTT['segment_code'];
						$result['ticketDetails'][$i]['segment_name']=$rowTT['segment_name'];
						$result['ticketDetails'][$i]['site_name'] = $rowTT['site_name'];
						$result['ticketDetails'][$i]['customer_code']=$rowTT['customer_code'];
						$result['ticketDetails'][$i]['customer_name']=$rowTT['customer_name'];
					$i++;}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}
		$result['add']=grantable('ADD','TICKETS',$emp_alias);
		$result['export']=grantable('EXPORT','TICKETS',$emp_alias);
		$result['advEdit']=grantable('SPECIAL','TICKETS',$emp_alias);
		$result['mapping']=grantable('TRANSFER EFSR','TICKETS',$emp_alias);
		$result['delete']=grantable('DELETE','TICKETS',$emp_alias);
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function ticket_view(){ 
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$ts_grant = grantable('TS','TICKETS',$emp_alias);
		$ticket_id = alias($_REQUEST['alias'],'ec_tickets','ticket_alias','ticket_id');
		if(strpos($ticket_id,"|")!== false){
			$tt = explode("|",$ticket_id);
			$ticket_id = $tt[0];
		}
		$result['main_ticket_id'] = $ticket_id;
		$result['main_ticket_alias'] = $_REQUEST['alias'];
		$lvl = alias($ticket_id,'ec_tickets','ticket_id','level');
		$old_lvl = alias($ticket_id,'ec_tickets','ticket_id','old_level');
		$planned_date = alias($ticket_id,'ec_tickets','ticket_id','planned_date');
		$purpose = alias($ticket_id,'ec_tickets','ticket_id','purpose');
		$result['level_code']=$lvl;
		$result['levelcolor']=($lvl=='1' || $lvl=='2' || $lvl=='4' || $lvl=='5' ? repl_planfail_tsrej($lvl,$old_lvl,$planned_date,$purpose,'color'):alias($lvl,'ec_levels','level_alias','level_color'));
		$result['level']=($lvl=='1' || $lvl=='2' || $lvl=='4' || $lvl=='5' ? repl_planfail_tsrej($lvl,$old_lvl,$planned_date,$purpose,'name'):alias($lvl,'ec_levels','level_alias','level_name'));
				
		$depos=alias($_REQUEST['alias'],'ec_ths_approved','ticket_alias','deposition');
		$result['deposition_edit']=($depos=='OPEN' && $ts_grant ? TRUE : FALSE);
		$result['ts_download']=(!empty($depos) ? TRUE : FALSE);
				
		$sqlTT = mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE (ticket_id LIKE '%".$ticket_id."|%' OR ticket_id = '$ticket_id') AND flag=0");
		$efsrExists = false;
		if(mysqli_num_rows($sqlTT)){
			$i=0;while($rowTT = mysqli_fetch_array($sqlTT)){
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
					$xx='';
					$product = explode(", ",$rowSite['product_alias']);
					foreach($product as $pro){ $xx .= alias($pro,'ec_product','product_alias','product_description').", "; }
					$result['obj'][$i]['product_description']=trim($xx,", ");
					
					$result['obj'][$i]['battery_bank_rating']=$rowSite['battery_bank_rating'];
					$result['obj'][$i]['mfd_date']=dateFormat($rowSite['mfd_date'],'d');
					$result['obj'][$i]['install_date']=dateFormat($rowSite['install_date'],'d');
					
					$result['obj'][$i]['sale_invoice_date']=dateFormat($rowSite['sale_invoice_date'],'d');
					$result['obj'][$i]['sale_invoice_num']=$rowSite['sale_invoice_num'];
					$result['obj'][$i]['po_num']=$rowSite['po_num'];
					
					$result['obj'][$i]['no_of_string']=$rowSite['no_of_string'];
					$result['obj'][$i]['technician_name']=$rowSite['technician_name'];
					$result['obj'][$i]['technician_number']=$rowSite['technician_number'];
					$result['obj'][$i]['manager_name']=$rowSite['manager_name'];
					$result['obj'][$i]['manager_number']=$rowSite['manager_number'];
					$result['obj'][$i]['manager_mail']=$rowSite['manager_mail'];
					$result['obj'][$i]['site_status']=($rowSite['mfd_date']=='0000-00-00' && $rowSite['install_date']=='0000-00-00' && $rowSite['sale_invoice_date']=='0000-00-00' ? "NA" : (sitemanfdate_check($site_alias)>0 ? 'UNDER WARRANTY' : 'OUT OF WARRANTY'));
					$result['obj'][$i]['warranty']=($rowSite['mfd_date']=='0000-00-00' && $rowSite['install_date']=='0000-00-00' && $rowSite['sale_invoice_date']=='0000-00-00' ? "NA" : ($rowTT['warranty']>0 ? 'UNDER WARRANTY' : 'OUT OF WARRANTY'));
					$result['obj'][$i]['site_address']=$rowSite['site_address'];
				}
				$rem=explode(", ",$rowTT['planned_remarks']);
				if(!empty($rowTT['planned_remarks'])){
					foreach($rem as $a=>$rr){
						list($rem_date,$employ_alias,$rem_alias)=explode("|",$rr);
						$result['obj'][$i]['planremark'][$a]['rem_date']=$rem_date;
						$result['obj'][$i]['planremark'][$a]['employee_name']=alias_flag_none($employ_alias,'ec_employee_master','employee_alias','name');
						$result['obj'][$i]['planremark'][$a]['rem_alias']=alias($rem_alias,'ec_remarks','remark_alias','remarks');
					}
				}else{$result['obj'][$i]['planremark_length']=0;}
				$sqlRem = mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE item_alias='$ticket_alias' AND module='TT' AND flag=0 ORDER BY id");
				if(mysqli_num_rows($sqlRem)){
					$j=0;while($rowRem = mysqli_fetch_array($sqlRem)){
						if(strtoupper($rowRem['remarked_by'])=='ADMIN'){$remarked_by='ADMIN'; $designation='ADMIN';}
						else{
							$remarked_by=alias_flag_none($rowRem['remarked_by'],'ec_employee_master','employee_alias','name');
							$designation=alias(alias_flag_none($rowRem['remarked_by'],'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','designation');
						}
						$result['obj'][$i]['remark'][$j]['remarkedby']=strtolower($remarked_by);
						$result['obj'][$i]['remark'][$j]['bucket']=alias($rowRem['bucket'],'ec_remarks_bucket','bucket_level','bucket');
						$result['obj'][$i]['remark'][$j]['designation']=strtolower($designation);
						$result['obj'][$i]['remark'][$j]['remarkedon']=dateTimeFormat($rowRem['remarked_on'],'d');
						$result['obj'][$i]['remark'][$j]['remark']=spec_esc_preg(str_replace(",",", ",$rowRem['remarks']));
						if($rowRem['bucket']=='7' || $rowRem['bucket']=='8')$ser_obs=str_replace(",",", ",$rowRem['remarks']);
					$j++;}
				}else{$result['obj'][$i]['remark_length']=mysqli_num_rows($sqlRem);}
				$result['obj'][$i]['action']=alias($ticket_alias,'ec_ticket_action','ticket_alias','observation');
				$result['obj'][$i]['activity']=alias($rowTT['activity_alias'],'ec_activity','activity_alias','activity_name');
				$result['obj'][$i]['complaint']=alias($rowTT['complaint_alias'],'ec_complaint','complaint_alias','complaint_name');
				$result['obj'][$i]['description']=spec_esc_preg($rowTT['description']);
				$result['obj'][$i]['login_date']=($rowTT['login_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['login_date']))));
				$result['obj'][$i]['faulty_cell_count']=$rowTT['faulty_cell_count'];
				$result['obj'][$i]['activation_date']=checkempty(dateFormat($rowTT['activation_date'],'d'));
				$result['obj'][$i]['planned_date']=checkempty(dateFormat($rowTT['planned_date'],'d'));
				$result['obj'][$i]['closing_date']=($rowTT['closing_date']=="" || $rowTT['level']<6 ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['closing_date']))));
				$result['obj'][$i]['tat']=tat($ticket_alias);
				$result['obj'][$i]['payment_terms']=checkempty($rowTT['payment_terms']);
				$result['obj'][$i]['milestone']=checkempty(alias($rowTT['milestone'],'ec_milestone','mile_stone_alais','mile_stone'));
				$result['obj'][$i]['mode_of_contact']=alias($rowTT['mode_of_contact'],'ec_moc','moc_alias','moc_name');
				$result['obj'][$i]['moc_num']=$rowTT['moc_num'];
				$result['obj'][$i]['contact_link']=($rowTT['contact_link']!='0' ? baseurl()."images/reports/".$rowTT['contact_link'] : "");
				$result['obj'][$i]['cust_file']=$rowTT['cust_file'];
				$result['obj'][$i]['service_engineer_alias']=checkempty($rowTT['service_engineer_alias']);
				$result['obj'][$i]['service_engineer_name']=alias_flag_none($rowTT['service_engineer_alias'],'ec_employee_master','employee_alias','name');
				$result['obj'][$i]['level_code']=$rowTT['level'];
				$result['obj'][$i]['old_level_code']=$rowTT['old_level'];
				$result['obj'][$i]['mrf']=mrfStatus($rowTT['ticket_alias']);
				
				$result['obj'][$i]['at_check']=alias($rowTT['activity_alias'],'ec_activity','activity_alias','activity_type');
				$result['obj'][$i]['po_number']=$rowTT['po_number'];
				$result['obj'][$i]['po_date']=checkempty(dateFormat($rowTT['po_date'],'d'));
				$result['obj'][$i]['po_link']=($rowTT['po_link']!='0' ? baseurl()."images/reports/".$rowTT['po_link'] : "");
				$result['obj'][$i]['purpose']=$rowTT['purpose'];
				
				$level = $rowTT['level'];
				$result['obj'][$i]['levelcolor']=($level=='1' || $level=='2' || $level=='4' || $level=='5' ? repl_planfail_tsrej($level,$rowTT['old_level'],$rowTT['planned_date'],$rowTT['purpose'],'color'):alias($level,'ec_levels','level_alias','level_color'));
				$result['obj'][$i]['level']=($level=='1' || $level=='2' || $level=='4' || $level=='5' ? repl_planfail_tsrej($level,$rowTT['old_level'],$rowTT['planned_date'],$rowTT['purpose'],'name'):alias($level,'ec_levels','level_alias','level_name'));
			
				$deposition=alias($ticket_alias,'ec_ths_approved','ticket_alias','deposition');
				$result['obj'][$i]['deposition_edit']=($deposition=='OPEN' && $ts_grant ? TRUE : FALSE);
				$result['obj'][$i]['ts_download']=(!empty($deposition) ? TRUE : FALSE);
			//Required Cells
				$result['obj'][$i]['req']=array();
				$sqlReq=mysqli_query($mr_con,"SELECT * FROM ec_cell_required WHERE ticket_alias='$ticket_alias' AND cell_alias!='' AND cell_alias!='NA' AND quanty!='0' AND flag='0'");
				if(mysqli_num_rows($sqlReq)){
					$j=0;while($rowReq = mysqli_fetch_array($sqlReq)){
						$item_type=$rowReq['item_type'];
						if($item_type=='1')$item=alias($rowReq['cell_alias'],'ec_product','product_alias','product_description');
						else $item=alias($rowReq['cell_alias'],'ec_accessories','accessories_alias','accessory_description');
						$result['obj'][$i]['req'][$j]['item_type'] = $item_type;
						$result['obj'][$i]['req'][$j]['cell_name'] = $item;
						$result['obj'][$i]['req'][$j]['quanty'] = $rowReq['quanty'];
						$result['obj'][$i]['req'][$j]['sent_quanty'] = $rowReq['sent_quanty'];
						$result['obj'][$i]['req'][$j]['approved_stat'] = ($rowReq['approved_stat']=='1' ? "PENDING" : "APPROVED");
						$result['obj'][$i]['req'][$j]['approved_by'] =  (empty($rowReq['approved_by'])? "NA" :(strtoupper($rowReq['approved_by'])=='ADMIN' ? "ADMIN" : strtoupper(alias($rowReq['approved_by'],'ec_employee_master','employee_alias','name'))));
						$result['obj'][$i]['req'][$j]['approved_on'] = ($rowReq['approved_on']=="0000-00-00" ? "NA":dateFormat($rowReq['approved_on'],'d'));
					$j++;
					}
				}
			//Service Engineer Observation
				$sqlEng=mysqli_query($mr_con,"SELECT * FROM ec_engineer_observation WHERE ticket_alias='$ticket_alias' AND flag='0'");
				$se_count=mysqli_num_rows($sqlEng);
				if($se_count){
					$rowEng = mysqli_fetch_array($sqlEng);
					$result['obj'][$i]['req_acc'] = (!empty($rowEng['req_acc']) ? $rowEng['req_acc'] : 'NA');
					$result['obj'][$i]['req_cells'] = (!empty($rowEng['req_cells']) ? $rowEng['req_cells'] : 'NA');
					$result['obj'][$i]['faulty_cell_sr_no'] = (!empty($rowEng['faulty_cell_sr_no']) ? $rowEng['faulty_cell_sr_no'] : 'NA');
					$result['obj'][$i]['replaced_cell_no'] = (!empty($rowEng['replaced_cell_no']) ? $rowEng['replaced_cell_no'] : 'NA');
					$result['obj'][$i]['ser_obs'] = (!empty($ser_obs) ? $ser_obs : 'NA');
				}$result['obj'][$i]['se_count'] = $se_count;
				if($level == '1'){$result['edit'] = grantable('PD','TICKETS',$emp_alias);}
				elseif($level == '2'){
					if($emp_alias==$rowTT['service_engineer_alias']){
						//$role_stat = alias(alias($emp_alias,'ec_employee_master','employee_alias','role_alias'),'ec_emprole','role_alias','role_stat');
						$result['edit'] = TRUE;//($role_stat=='1' || $role_stat=='0' ? TRUE : grantable('PD','TICKETS',$emp_alias));
					}else{
						$result['edit'] = grantable('PD','TICKETS',$emp_alias);
					}
				}
				elseif($level == '3'){$result['edit'] = grantable('ZHS','TICKETS',$emp_alias);}
				elseif($level == '4'){$result['edit'] = grantable('NHS','TICKETS',$emp_alias);}
				elseif($level == '8'){$result['edit'] = $ts_grant;}
				else{$result['edit'] = grantable('EDIT','TICKETS',$emp_alias);}
				$result['adv_edit'] = ($emp_alias=='ADMIN' ? TRUE : FALSE);

				if($rowTT['efsr_no']) {
					$efsrExists = true;
				}
				$result['obj'][$i]['efsr_no']=$rowTT['efsr_no'];
				$result['obj'][$i]['efsr_start']=(empty($rowTT['efsr_start']) ? FALSE : TRUE);
				$result['obj'][$i]['esca_efsr_link']=$rowTT['esca_efsr_link'];
				if($rowTT['efsr_no']!=''){ $link = ($rowTT['esca_efsr_link']!='' ? "esca-FSR" : "e-FSR"); }else{$link = "-";}
				$result['obj'][$i]['fsrreport']=$link;
				$result['obj'][$i]['efsr_date']=date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['efsr_date'])));
				$result['obj'][$i]['status']=$rowTT['status'];
				$i++;
			}
			$result['efsrExists'] = $efsrExists;
			$resCode='0'; $resMsg='Successful!';
		}else{$resCode='4'; $resMsg='No Records Found';}
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function ticket_edit_view(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$sqlTT = mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE ticket_alias ='".$_REQUEST['alias']."' AND flag=0");
		if(mysqli_num_rows($sqlTT)){
			$rowTT = mysqli_fetch_array($sqlTT);
			$site_alias = $rowTT['site_alias'];
			$ticket_alias = $rowTT['ticket_alias'];
			$result['ticket_alias']=$rowTT['ticket_alias'];
			$result['ticket_id']=$rowTT['ticket_id'];
			$result['activity']=alias($rowTT['activity_alias'],'ec_activity','activity_alias','activity_name');
			$sqlSite = mysqli_query($mr_con,"SELECT * FROM ec_sitemaster WHERE site_alias='$site_alias' AND flag=0");
			if(mysqli_num_rows($sqlSite)){
				$rowSite = mysqli_fetch_array($sqlSite);
				$result['zone_name']=alias($rowSite['zone_alias'],'ec_zone','zone_alias','zone_name');
				$result['state_name']=alias($rowSite['state_alias'],'ec_state','state_alias','state_name');
				$result['district_name']=alias($rowSite['district_alias'],'ec_district','district_alias','district_name');
				$result['segment_name']=alias($rowSite['segment_alias'],'ec_segment','segment_alias','segment_name');
				$result['customer_name']=alias($rowSite['customer_alias'],'ec_customer','customer_alias','customer_name');
				$result['site_type']=alias($rowSite['site_type_alias'],'ec_site_type','site_type_alias','site_type');
				$result['site_id']=$rowSite['site_id'];
				$result['site_name']=$rowSite['site_name'];
				$xx = '';
				$product = explode(", ",$rowSite['product_alias']);
				foreach($product as $pro){ $xx .= alias($pro,'ec_product','product_alias','product_description').", "; }
				$result['product_description']=trim($xx,", ");

				$result['battery_bank_rating']=$rowSite['battery_bank_rating'];
				$result['mfd_date']=dateFormat($rowSite['mfd_date'],'d');
				$result['install_date']=dateFormat($rowSite['install_date'],'d');

				$result['sale_invoice_date']=dateFormat($rowSite['sale_invoice_date'],'d');
				$result['sale_invoice_num']=$rowSite['sale_invoice_num'];
				$result['po_num']=$rowSite['po_num'];

				$result['no_of_string']=$rowSite['no_of_string'];
				$result['technician_name']=$rowSite['technician_name'];
				$result['technician_number']=$rowSite['technician_number'];
				$result['manager_name']=$rowSite['manager_name'];
				$result['manager_number']=$rowSite['manager_number'];
				$result['manager_mail']=$rowSite['manager_mail'];
				$result['site_status']=($rowTT['warranty']>0 ? 'UNDER WARRANTY' : 'OUT OF WARRANTY');
				$result['site_address']=$rowSite['site_address'];
			}
			//Remarks
			$sqlRem = mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE item_alias='$ticket_alias' AND module='TT' AND flag=0 ORDER BY remarked_on");
			$rem_count=mysqli_num_rows($sqlRem);
			if($rem_count){
				$j=0;while($rowRem = mysqli_fetch_array($sqlRem)){
					if(strtoupper($rowRem['remarked_by'])=='ADMIN'){$remarked_by='ADMIN'; $privilege_name='ADMIN';}
					else{
						$remarked_by=alias_flag_none($rowRem['remarked_by'],'ec_employee_master','employee_alias','name');
						$privilege_name=alias(alias_flag_none($rowRem['remarked_by'],'ec_employee_master','employee_alias','privilege_alias'),'ec_privileges','privilege_alias','privilege_name');
						}
					$result['remark'][$j]['remark_alias']=$rowRem['remark_alias'];
					$result['remark'][$j]['remarkedby']=strtoupper($remarked_by);
					$result['remark'][$j]['bucket']=alias($rowRem['bucket'],'ec_remarks_bucket','bucket_level','bucket');
					$result['remark'][$j]['remarkedby_alias']=strtoupper($rowRem['remarked_by']);
					$result['remark'][$j]['designation']=strtoupper($privilege_name);
					$result['remark'][$j]['remarkedon']=dateTimeFormat($rowRem['remarked_on'],'d');
					$result['remark'][$j]['remark']=spec_esc_preg(str_replace(",",", ",strtoupper($rowRem['remarks'])));
				$j++;}
			}$result['remark_length']=$rem_count;

			//Service Engineer Observation
			$sqlEng=mysqli_query($mr_con,"SELECT cell_sl_no FROM ec_fsr_faulty_cells WHERE ticket_alias='$ticket_alias' AND flag='0'");
			$result['se_eng']=array();
			if(!empty(mysqli_num_rows($sqlEng))){
				$k=0;while($rowEng = mysqli_fetch_array($sqlEng)){
					$result['se_eng'][$k]['faulty_cell_sr_no']=$rowEng['cell_sl_no'];
				$k++;}
			}
			//Ticket Action
			$sqlAct = mysqli_query($mr_con,"SELECT * FROM ec_ticket_action WHERE ticket_alias='$ticket_alias' AND flag=0");
			if(mysqli_num_rows($sqlAct)){
				$j=0;while($rowAct = mysqli_fetch_array($sqlAct)){
					$result['action'][$j]['action_alias']=$rowAct['item_alias'];
					$result['action'][$j]['observation']=strtoupper($rowAct['observation']);
				$j++;}
			}else{$result['action_length']=mysqli_num_rows($sqlAct);}
			//Required Cells
			$result['required_cells']=$arr_type=array();
			$sqlReq = mysqli_query($mr_con,"SELECT * FROM ec_cell_required WHERE ticket_alias='$ticket_alias' AND cell_alias!='' AND cell_alias!='NA' AND quanty!='' AND quanty!='0' AND flag=0");
			if(mysqli_num_rows($sqlReq)){
				$k=0;while($rowReq = mysqli_fetch_array($sqlReq)){
						$item_type=$rowReq['item_type'];
						if($item_type=='1')$arr_type[]=$item=alias($rowReq['cell_alias'],'ec_product','product_alias','product_description');
						else $item=alias($rowReq['cell_alias'],'ec_accessories','accessories_alias','accessory_description');
						$result['required_cells'][$k]['item_type']=$item_type;
						$result['required_cells'][$k]['cells']=$item;
						$result['required_cells'][$k]['cell_alias']=$rowReq['cell_alias'];
						$result['required_cells'][$k]['quantity']=$rowReq['quanty'];
						$result['required_cells'][$k]['sent_quanty'] = $rowReq['sent_quanty'];
						$result['required_cells'][$k]['approved_stat']=($rowReq['approved_stat']=='1' ? "PENDING" : "APPROVED");
						$result['required_cells'][$k]['approved_stat_num']=$rowReq['approved_stat'];
						$result['required_cells'][$k]['approved_by']=(empty($rowReq['approved_by'])? "NA" :(strtoupper($rowReq['approved_by'])=='ADMIN' ? "ADMIN" : strtoupper(alias($rowReq['approved_by'],'ec_employee_master','employee_alias','name'))));
						$result['required_cells'][$k]['approved_by_alias']=strtoupper($rowReq['approved_by']);
						$result['required_cells'][$k]['approved_on']=($rowReq['approved_on']=="0000-00-00" ? "NA":dateFormat($rowReq['approved_on'],'d'));
						$result['required_cells'][$k]['item_alias']=$rowReq['item_alias'];
					$k++;
				}
			}$result['cell_type']=(count($arr_type) ? TRUE : FALSE);

			//TS Details for MD view
			$result['deposition_edit']=(alias($ticket_alias,'ec_ths_approved','ticket_alias','deposition')=='OPEN' && grantable('TS','TICKETS',$emp_alias) ? TRUE : FALSE);
			if(strtoupper($emp_alias)=='ADMIN' || admin_privilege($emp_alias) || grantable('TS','TICKETS',$emp_alias)){
				$sqlTs = mysqli_query($mr_con,"SELECT * FROM ec_ths_approved WHERE ticket_alias='$ticket_alias' AND deposition<>'' AND flag=0");
				$ts_count=mysqli_num_rows($sqlTs);
				if($ts_count){
					$rowTs = mysqli_fetch_array($sqlTs);
					$sql3=mysqli_query($mr_con,"SELECT GROUP_CONCAT(name SEPARATOR ', ') AS emp_name FROM ec_employee_master WHERE employee_alias IN ('".str_replace("|","','",$rowTs['persons_notified'])."') AND flag='0'");
					$emp_row=mysqli_fetch_array($sql3);
					$result['line_number']=$rowTs['line_number'];
					$result['shift']=alias($rowTs['shift'],'ec_shift','shift_alias','shift_name');
					$result['date_of_assembly']=($rowTs['date_of_assembly']=="" || $rowTs['date_of_assembly']=="0000-00-00" ? "NA" : date("d-m-Y", strtotime(mysqli_real_escape_string($mr_con,$rowTs['date_of_assembly']))));
					$result['date_of_jar_form']=($rowTs['date_of_jar_form']=="" || $rowTs['date_of_jar_form']=="0000-00-00" ? "NA" : date("d-m-Y", strtotime(mysqli_real_escape_string($mr_con,$rowTs['date_of_jar_form']))));
					$result['corect_act_Plan']=$rowTs['corect_act_Plan'];
					$result['deposition']=$rowTs['deposition'];
					$result['persons_notified']=$emp_row['emp_name'];
					$sql4=mysqli_query($mr_con,"SELECT * FROM ec_ths_faulty_ocv WHERE ths_appr_alias='".$rowTs['alias']."' AND flag=0");
					if(mysqli_num_rows($sql4)){
						$j=0;while($row4 = mysqli_fetch_array($sql4)){
							$result['ts_approved'][$j]['faulty_cell_num']=$row4['faulty_cell_num'];
							$result['ts_approved'][$j]['ocv']=$row4['ocv'];
							$result['ts_approved'][$j]['tenth_hour']=$row4['tenth_hour'];
						$j++;}
					}$result['ts_approved_length']=$ts_count;
				}else $result['ts_approved_length']='0';
			}else $result['ts_approved_length']='0';

			$result['activity_alias']=$rowTT['activity_alias'];
			$result['complaint_alias']=$rowTT['complaint_alias'];
			$result['complaint']=alias($rowTT['complaint_alias'],'ec_complaint','complaint_alias','complaint_name');
			$result['description']=spec_esc_preg($rowTT['description']);
			$result['login_date']=($rowTT['login_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['login_date']))));
			$result['faulty_cell_count']=$rowTT['faulty_cell_count'];
			$result['activation_date']=checkempty(dateFormat($rowTT['activation_date'],'d'));
			$result['planned_date']=checkempty(dateFormat($rowTT['planned_date'],'d'));
			$result['close_planned_date']=checkempty(dateFormat($rowTT['planned_date'],'y'));
			$result['closing_date']=($rowTT['closing_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['closing_date']))));
			$result['tat']=tat($ticket_alias);
			$result['payment_terms']=checkempty($rowTT['payment_terms']);

			$result['at_check']=alias($rowTT['activity_alias'],'ec_activity','activity_alias','activity_type');
			$result['po_number']=$rowTT['po_number'];
			$result['po_date']=checkempty(dateFormat($rowTT['po_date'],'d'));
			$result['po_link']=($rowTT['po_link']!='0' ? baseurl()."images/reports/".$rowTT['po_link'] : "");

			$result['milestone']=checkempty($rowTT['milestone']);
			$result['mode_of_contact_alias']=$rowTT['mode_of_contact'];
			$result['mode_of_contact']=alias($rowTT['mode_of_contact'],'ec_moc','moc_alias','moc_name');
			$result['moc_num']=$rowTT['moc_num'];
			$result['contact_link']=($rowTT['contact_link']!='0' ? baseurl()."images/reports/".$rowTT['contact_link'] : "");
			$se_alias=checkempty($rowTT['service_engineer_alias']);
			$result['role_alias']=alias_flag_none($se_alias,'ec_employee_master','employee_alias','role_alias');
			$result['service_engineer_alias']=$se_alias;
			if($se_alias!="NA" && $se_alias!="-" && !empty($se_alias)){
				/*$device=alias($se_alias,'ec_employee_master','employee_alias','device');
				$device_2=alias($se_alias,'ec_employee_master','employee_alias','device_2');
				if(!empty($device) || !empty($device_2) || grantable('PD','TICKETS',$emp_alias)){$result['escarole']=FALSE;$result['onrole']=TRUE;}
				else{$result['escarole']=TRUE;$result['onrole']=FALSE;}*/
				//$role_stat = alias(alias_flag_none($emp_alias,'ec_employee_master','employee_alias','role_alias'),'ec_emprole','role_alias','role_stat');
				if($emp_alias==$se_alias){
					//if($role_stat=='1' || $role_stat=='0'){
						$result['escarole']=TRUE;$result['onrole']=FALSE;
					//}else{$result['escarole']=FALSE;$result['onrole']=TRUE;}
				}else{
					$result['escarole']=FALSE;$result['onrole']=TRUE;
				}
			}else{ $result['escarole']=FALSE; $result['onrole']=FALSE;}
			$result['service_engineer_name']=alias_flag_none($se_alias,'ec_employee_master','employee_alias','name');
			$result['level_code']=$rowTT['level'];
			$result['old_level_code']=$rowTT['old_level'];

			$level = $rowTT['level'];
			$result['levelcolor']=($level=='1' || $level=='2' || $level=='4' || $level=='5' ? repl_planfail_tsrej($level,$rowTT['old_level'],$rowTT['planned_date'],$rowTT['purpose'],'color'):alias($level,'ec_levels','level_alias','level_color'));
			$result['level']=($level=='1' || $level=='2' || $level=='4' || $level=='5' ? repl_planfail_tsrej($level,$rowTT['old_level'],$rowTT['planned_date'],$rowTT['purpose'],'name'):alias($level,'ec_levels','level_alias','level_name'));
			
			if($level=='1' && $rowTT['purpose']=='1'){
				$sqlout=mysqli_query($mr_con,"SELECT id FROM ec_material_outward WHERE ref_no='$ticket_alias' AND from_type='1' AND flag='0'");
				$result['outward']=(mysqli_num_rows($sqlout) ? FALSE : TRUE);
			}else $result['outward']=FALSE;
			$result['purpose']=$rowTT['purpose'];
			$result['efsr_no']=$rowTT['efsr_no'];
			$result['efsr_date']=($rowTT['efsr_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['efsr_date']))));
			$result['status']=$rowTT['status'];
			$result['esca_efsr_link']=$rowTT['esca_efsr_link'];
			$resCode='0'; $resMsg='Successful!';
		}else{$resCode='4'; $resMsg='No Records Found';}
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function ticket_export(){ global $mr_con;
	set_time_limit(0);
	ini_set('memory_limit', '512M');
	$emp_ali = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_ali,$token);
	if($chk==0){ $con=$con1='';
	if(strtoupper($emp_ali)!="ADMIN"){
		$role_alias = alias($emp_ali,'ec_employee_master','employee_alias','role_alias');
		$role_stat = alias($role_alias,'ec_emprole','role_alias','role_stat');
		if($role_stat=='0' || $role_stat=='1'){
			$con .= "T1.service_engineer_alias='$emp_ali' AND ";
		}
	}
	if(isset($_REQUEST['zone_alias']) && count($_REQUEST['zone_alias'])>0){
		$zone = implode("|",$_REQUEST['zone_alias']);
		$zone_arr = $_REQUEST['zone_alias'];
		$con .= "T2.zone_alias RLIKE '$zone' AND ";
	}
	if(isset($_REQUEST['state_alias']) && count($_REQUEST['state_alias'])>0){
		$state = implode("|",$_REQUEST['state_alias']);
		$state_arr = $_REQUEST['state_alias'];
		$con .= "T2.state_alias RLIKE '$state' AND ";
	}else{
		if(strtoupper($emp_ali)!="ADMIN"){
			$emp_state_alias = alias($emp_ali,'ec_employee_master','employee_alias','state_alias');
			if(!empty($emp_state_alias) && $emp_state_alias!="NA"){
				$con .= "T2.state_alias IN('".str_replace(", ","','",$emp_state_alias)."') AND ";
			}else{
				$con .= "T2.state_alias='NA' AND ";
			}
		}
	}
	if(isset($_REQUEST['activity_alias']) && count($_REQUEST['activity_alias'])>0){
		$activity = implode("|",$_REQUEST['activity_alias']);
		$con .= "T1.activity_alias RLIKE '$activity' AND ";
	}
	/*if(isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date'])){
		$login_from = dateFormat($_REQUEST['from_date'],'y');
		$con .= "T1.login_date >= '$login_from' AND ";
	}
	if(isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date'])){
		$login_to = dateFormat($_REQUEST['to_date'],'y')." 23:59:59";
		$con .= "T1.login_date <= '$login_to' AND ";
	}*/
	if(isset($_REQUEST['complaint_alias']) && count($_REQUEST['complaint_alias'])>0){
		$complaint = implode("|",$_REQUEST['complaint_alias']);
		$con .= "T1.complaint_alias RLIKE '$complaint' AND ";
	}
	
	$segment_alias=alias($emp_ali,'ec_employee_master','employee_alias','segment_alias');
	if(isset($_REQUEST['segment_alias']) && count($_REQUEST['segment_alias'])>0){
		$segment = (empty($segment_alias) ? $_REQUEST['segment_alias'] : array_intersect($_REQUEST['segment_alias'],explode(", ",$segment_alias)));
	}elseif(!empty($segment_alias))$segment = explode(", ",$segment_alias);
	
	$customer_alias=alias($emp_ali,'ec_employee_master','employee_alias','customer_alias');
	if(isset($_REQUEST['customer_alias']) && count($_REQUEST['customer_alias'])>0){
		$customer = (empty($customer_alias) ? $_REQUEST['customer_alias'] : array_intersect($_REQUEST['customer_alias'],explode(", ",$customer_alias)));
	}elseif(!empty($customer_alias))$customer = explode(", ",$customer_alias);

	if(count($segment)>0)$con .= "T2.segment_alias RLIKE '".implode("|",$segment)."' AND ";
	if(count($customer)>0)$con .= "T2.customer_alias RLIKE '".implode("|",$customer)."' AND ";
	
	if(isset($_REQUEST['level_alias']) && count($_REQUEST['level_alias'])>0){
		$level_alias=$_REQUEST['level_alias'];
		if(!in_array('rpl',$level_alias) && !in_array('pf',$level_alias) && !in_array('tsr',$level_alias)){
			$level = implode("|",$level_alias);
			$con .= "T1.level RLIKE '$level' AND ";
		}else{ $att=array();
			foreach($level_alias as $lvl){
				if($lvl=='rpl')$att[] = "(t1.level='1' AND t1.purpose='1')";
				elseif($lvl=='1')$att[] = "(t1.level='1' AND t1.purpose='0')";
				elseif($lvl=='pf')$att[] = "(t1.level='2' AND t1.planned_date<'".date('Y-m-d')."')";
				elseif($lvl=='2')$att[] = "(t1.level='2' AND t1.planned_date>='".date('Y-m-d')."')";
				elseif($lvl=='tsr')$att[] = "(t1.level='4' AND t1.old_level='8')";
				elseif($lvl=='4')$att[] = "(t1.level='4' AND t1.old_level='3')";
				else $att[] = "t1.level='$lvl'";
			}
			$con.="(".implode(" OR ",$att).") AND ";
		}
	}
	if(isset($_REQUEST['product']) && count($_REQUEST['product'])>0){
		$product = implode("|",$_REQUEST['product']);
		$con .= "T2.product_alias RLIKE '$product' AND ";
	}
	if(isset($_REQUEST['tat']) && count($_REQUEST['tat'])>0){
		$tat = implode("|",$_REQUEST['tat']);
		$con .= "T1.tat RLIKE '$tat' AND ";
	}
	$export_bifurcation = array();
	if(isset($_REQUEST['export_bifurcation']) && count($_REQUEST['export_bifurcation'])>0){
		$export_bifurcation = $_REQUEST['export_bifurcation'];
		$valid = TRUE;	
		if(in_array("1",$export_bifurcation) || in_array("2",$export_bifurcation) || in_array("5",$export_bifurcation)){
			if(isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date']))$con .= "T1.login_date >= '".dateFormat($_REQUEST['from_date'],'y')."' AND ";
			if(isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date']))$con .= "T1.login_date <= '".dateFormat($_REQUEST['to_date'],'y')." 23:59:59' AND ";
		}
	}else{$valid = FALSE;}
	if($valid){
	$f_arr = array(1=>'TICKETS_',2=>'TTSA_',3=>'BTR_',4=>'TS_');
	foreach($f_arr as $k=>$v){
		if(in_array($k,$export_bifurcation)){// || !count($export_bifurcation)
			$file_name .= $v;
			if($k==1)$tt_dt=TRUE;
			if($k==2)$tt_sa=TRUE;
			if($k==3)$btr=TRUE;
			if($k==4)$ts=TRUE;
		}
	}
	//$filename = 'Tickets_'.date('d-m-Y H_i_s');
	$filename = $file_name.date('d-m-Y H_i_s');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("EnersysCare")->setLastModifiedBy("EnersysCare")->setTitle("Office 2007 XLSX Tickets Document")->setSubject("Office 2007 XLSX Tickets Document")->setDescription("Tickets document for Office 2007 XLSX, generated using PHP classes.");
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
	$no_rec = $sh_index = 0;
	if($tt_dt){
		$objPHPExcel->setActiveSheetIndex($sh_index);
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setTitle('Tickets');
		$sq=mysqli_query($mr_con,"SET GLOBAL group_concat_max_len = 1000000");
		$sql=mysqli_query($mr_con,"SELECT T1.*, T2.* FROM ec_tickets T1 JOIN ec_sitemaster T2 ON T1.site_alias = T2.site_alias AND $con T1.flag=0");
		if(mysqli_num_rows($sql)){
			$colArr = array("Ticket ID","Login Date","Visit Generated Date","Mode Of Contact","MOC Number","Zone","State","District","Site ID","Site Name","Site Address","First Level Contact Name","First Level Contact Number","Second Level Contact Name","Second Level Contact Number","Second Level Contact Email","Segment","Customer","Activity","Nature of Complaint","Complaint Description","No of Faulty Cells reported by Customer","No of Faulty Cells reported by Service Engineer","Replaced Cells Count","Product","Battery Bank Rating","No Of String","Mfd Date","Install Date","Sale Invoice Number","Sale Invoice Date","Sale PO Number","Service PO Number","Service PO Date","Site Type","Warranty Status","Activation Date","Planned Date","Planned Service Engineer","Planned Service Engineer Role","Planned Service Engineer Number","efsr No","efsr Date","Closing Date","TAT","Visits","Level","Ticket Status","Milestone","eFSR Efficiency","MRS","Visited SE Remarks","BUCKET","Visited SE Name","Visited SE Action Date and Time","Visited SE Action Taken","ZHS Remarks","BUCKET","ZHS Name","ZHS Action Date and Time","ZHS Aging","NHS Remarks","BUCKET","NHS Name","NHS Action Date and Time","NHS Aging","TS Remarks","BUCKET","TS Name","TS Action Date and Time","TS Aging","OUT OF WARRANTY Remarks","OUT OF WARRANTY Given By","OUT OF WARRANTY Action Date and Time","AT AND I&C Remarks","AT AND I&C Remarks Given By","AT AND I&C Remarks Action Date and Time","REQUIRED CELL Remarks","REQUIRED CELL Remarks Given By","REQUIRED CELL Remarks Action Date and Time","RE PLANNED Remarks","RE PLANNED Remarks Given By","RE PLANNED Remarks Action Date and Time","Admin Remarks","BUCKET","Admin Remarks Given By","Admin Remarks Action Date and Time","Other Remarks","BUCKET","Other Remarks Given By","Other Remarks Action Date and Time");
			$last_key = end(array_keys($colArr));
			$last_alpha = num2alpha($last_key);
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
			$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue)); $ch++; }
			$date_arr = array("B","C","AB","AC","AE","AH","AK","AL","AQ","AR","BC","BH","BM","BR","BV","BY","CB","CE","CI","CM");
			foreach($date_arr as $da){$sheet->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension($da)->setAutoSize(true);}
			$coo=1;
			while($row=mysqli_fetch_array($sql)){ $coo++;
				// 1) Ticket Details
				$ticket_alias = $row['ticket_alias'];
				// 2) Faulty Count
				$f_count1 = alias($ticket_alias,'ec_engineer_observation','ticket_alias','total_faulty_count');
				$rep_cells=alias($ticket_alias,'ec_engineer_observation','ticket_alias','replaced_cell_no');
				if(!empty($rep_cells) && strtoupper($rep_cells)!="NIL" && $rep_cells!="-" && $rep_cells!="0"){
					$rep_count=count(explode(",",str_replace(" ","",$rep_cells)));
				}else $rep_count='0';
				if(strpos($row['ticket_id'],"|")!==false)if($f_count1=="NA" || $f_count1=="")$f_count1 = alias(alias(strtok($row['ticket_id'], "|"),'ec_tickets','ticket_id','ticket_alias'),'ec_engineer_observation','ticket_alias','total_faulty_count');
				$rem_result=all_remarks($ticket_alias);
				// 1) Ticket Details
				$ticket_id = strtok($row['ticket_id'],"|");
				$sheet->SetCellValue('A'.$coo, checkemptydash($ticket_id))
					->SetCellValue('B'.$coo, ($row['login_date']=="" ? "-" : php_excel_date($row['login_date'])))
					->SetCellValue('C'.$coo, ($row['visit_gen_date']=="" ? "-" : php_excel_date($row['visit_gen_date'])))
					->SetCellValue('D'.$coo, checkemptydash(alias($row['mode_of_contact'],'ec_moc','moc_alias','moc_name')))
					->SetCellValue('E'.$coo, checkemptydash($row['moc_num']))
					->SetCellValue('F'.$coo, checkemptydash(alias($row['zone_alias'],'ec_zone','zone_alias','zone_name')))
					->SetCellValue('G'.$coo, checkemptydash(alias($row['state_alias'],'ec_state','state_alias','state_name')))
					->SetCellValue('H'.$coo, checkemptydash(alias($row['district_alias'],'ec_district','district_alias','district_name')))
					//->SetCellValue('I'.$coo, checkemptydash($row['site_id']))
					->setCellValueExplicit('I'.$coo, checkemptydash($row['site_id']),PHPExcel_Cell_DataType::TYPE_STRING)
					->SetCellValue('J'.$coo, checkemptydash($row['site_name']))
					->SetCellValue('K'.$coo, checkemptydash($row['site_address']))
					->SetCellValue('L'.$coo, checkemptydash($row['technician_name']))
					->SetCellValue('M'.$coo, checkemptydash($row['technician_number']))
					->SetCellValue('N'.$coo, checkemptydash($row['manager_name']))
					->SetCellValue('O'.$coo, checkemptydash($row['manager_number']))
					->SetCellValue('P'.$coo, checkemptydash($row['manager_mail']))
					->SetCellValue('Q'.$coo, checkemptydash(alias($row['segment_alias'],'ec_segment','segment_alias','segment_name')))
					->SetCellValue('R'.$coo, checkemptydash(alias($row['customer_alias'],'ec_customer','customer_alias','customer_code')))
					->SetCellValue('S'.$coo, checkemptydash(alias($row['activity_alias'],'ec_activity','activity_alias','activity_name')))
					->SetCellValue('T'.$coo, checkemptydash(alias($row['complaint_alias'],'ec_complaint','complaint_alias','complaint_name')))
					->SetCellValue('U'.$coo, checkemptydash($row['description']))
					->SetCellValue('V'.$coo, checkemptydash($row['faulty_cell_count']))
					->SetCellValue('W'.$coo, checkemptydash($f_count1))
					->SetCellValue('X'.$coo, checkemptydash($rep_count))
					->SetCellValue('Y'.$coo, checkemptydash(alias($row['product_alias'],'ec_product','product_alias','product_description')))
					->SetCellValue('Z'.$coo, checkemptydash($row['battery_bank_rating']))
					->SetCellValue('AA'.$coo, checkemptydash($row['no_of_string']))
					->SetCellValue('AB'.$coo, php_excel_date($row['mfd_date']))
					->SetCellValue('AC'.$coo, php_excel_date($row['install_date']))
					
					->SetCellValue('AD'.$coo, checkemptydash($row['sale_invoice_num']))
					->SetCellValue('AE'.$coo, php_excel_date($row['sale_invoice_date']))
					->SetCellValue('AF'.$coo, checkemptydash($row['po_num']))
					->SetCellValue('AG'.$coo, checkemptydash($row['po_number']))
					->SetCellValue('AH'.$coo, php_excel_date($row['po_date']))
					->SetCellValue('AI'.$coo, checkemptydash(alias($row['site_type_alias'],'ec_site_type','site_type_alias','site_type')))
					->SetCellValue('AJ'.$coo, ($row['warranty']>0 ? 'UNDER WARRANTY' : 'OUT OF WARRANTY'))
					->SetCellValue('AK'.$coo, php_excel_date($row['activation_date']))
					->SetCellValue('AL'.$coo, php_excel_date($row['planned_date']))
					->SetCellValue('AM'.$coo, checkemptydash(alias_flag_none($row['service_engineer_alias'],'ec_employee_master','employee_alias','name')))
					->SetCellValue('AN'.$coo, checkemptydash(alias(alias_flag_none($row['service_engineer_alias'],'ec_employee_master','employee_alias','role_alias'),'ec_emprole','role_alias','role_name')))
					->SetCellValue('AO'.$coo, checkemptydash(alias_flag_none($row['service_engineer_alias'],'ec_employee_master','employee_alias','mobile_number')))
					//->SetCellValue('AP'.$coo, checkemptydash($row['efsr_no']))
					->setCellValueExplicit('AP'.$coo, checkemptydash($row['efsr_no']),PHPExcel_Cell_DataType::TYPE_STRING)
					->SetCellValue('AQ'.$coo, ($row['efsr_date']=="" ? "-" : php_excel_date($row['efsr_date'])))
					->SetCellValue('AR'.$coo, ($row['closing_date']=="" || $row['level']<6 ? "-" : php_excel_date($row['closing_date'])))
					->SetCellValue('AS'.$coo, checkemptydash((!empty($row['tat']) ? $row['tat'] : tat($row['ticket_alias']))))
					->SetCellValue('AT'.$coo, visit_exp_count($ticket_id))
					->SetCellValue('AU'.$coo, checkemptydash(($row['level']=='1' || $row['level']=='2' || $row['level']=='4' || $row['level']=='5' ? repl_planfail_tsrej($row['level'],$row['old_level'],$row['planned_date'],$row['purpose'],'name'):alias($row['level'],'ec_levels','level_alias','level_name'))))
					->SetCellValue('AV'.$coo, checkemptydash($row['status']))
					->SetCellValue('AW'.$coo, checkemptydash(alias($row['milestone'],'ec_milestone','mile_stone_alais','mile_stone')))
					->SetCellValue('AX'.$coo, checkemptydash($row['payment_terms']))
					->SetCellValue('AY'.$coo, checkemptydash(mrfStatus($row['ticket_alias'])))
					
					->SetCellValue('AZ'.$coo,checkemptydash(implode(" | ",$rem_result['se_rem'])))
					->SetCellValue('BA'.$coo,checkemptydash(implode(" | ",$rem_result['se_buc'])))
					->SetCellValue('BB'.$coo,checkemptydash(implode(" | ",$rem_result['se_by'])))
					->SetCellValue('BC'.$coo,checkemptydash((count($rem_result['se_on'])==1 ? php_excel_date(end($rem_result['se_on'])) : implode(" | ",$rem_result['se_on']))))
					->SetCellValue('BD'.$coo,checkemptydash(implode(" | ",$rem_result['se_act'])))
	
					->SetCellValue('BE'.$coo,checkemptydash(implode(" | ",$rem_result['zhs_rem'])))
					->SetCellValue('BF'.$coo,checkemptydash(implode(" | ",$rem_result['zhs_buc'])))
					->SetCellValue('BG'.$coo,checkemptydash(implode(" | ",$rem_result['zhs_by'])))
					
					->SetCellValue('BH'.$coo,checkemptydash((count($rem_result['zhs_on'])==1 ? php_excel_date(end($rem_result['zhs_on'])) : implode(" | ",$rem_result['zhs_on']))))
					->SetCellValue('BI'.$coo,checkemptydash(implode(" | ",$rem_result['zhs_age'])))
	
					->SetCellValue('BJ'.$coo,checkemptydash(implode(" | ",$rem_result['nhs_rem'])))
					->SetCellValue('BK'.$coo,checkemptydash(implode(" | ",$rem_result['nhs_buc'])))
					->SetCellValue('BL'.$coo,checkemptydash(implode(" | ",$rem_result['nhs_by'])))
					->SetCellValue('BM'.$coo,checkemptydash((count($rem_result['nhs_on'])==1 ? php_excel_date(end($rem_result['nhs_on'])) : implode(" | ",$rem_result['nhs_on']))))
					->SetCellValue('BN'.$coo,checkemptydash(implode(" | ",$rem_result['nhs_age'])))

					->SetCellValue('BO'.$coo,checkemptydash(implode(" | ",$rem_result['ts_rem'])))
					->SetCellValue('BP'.$coo,checkemptydash(implode(" | ",$rem_result['ts_buc'])))
					->SetCellValue('BQ'.$coo,checkemptydash(implode(" | ",$rem_result['ts_by'])))
					->SetCellValue('BR'.$coo,checkemptydash((count($rem_result['ts_on'])==1 ? php_excel_date(end($rem_result['ts_on'])) : implode(" | ",$rem_result['ts_on']))))
					->SetCellValue('BS'.$coo,checkemptydash(implode(" | ",$rem_result['ts_age'])))
					
					->SetCellValue('BT'.$coo,checkemptydash(implode(" | ",$rem_result['out_rem'])))
					->SetCellValue('BU'.$coo,checkemptydash(implode(" | ",$rem_result['out_by'])))
					->SetCellValue('BV'.$coo,checkemptydash((count($rem_result['out_on'])==1 ? php_excel_date(end($rem_result['out_on'])) : implode(" | ",$rem_result['out_on']))))
					
					->SetCellValue('BW'.$coo,checkemptydash(implode(" | ",$rem_result['ai_rem'])))
					->SetCellValue('BX'.$coo,checkemptydash(implode(" | ",$rem_result['ai_by'])))
					->SetCellValue('BY'.$coo,checkemptydash((count($rem_result['ai_on'])==1 ? php_excel_date(end($rem_result['ai_on'])) : implode(" | ",$rem_result['ai_on']))))
					
					->SetCellValue('BZ'.$coo,checkemptydash(implode(" | ",$rem_result['req_rem'])))
					->SetCellValue('CA'.$coo,checkemptydash(implode(" | ",$rem_result['req_by'])))
					->SetCellValue('CB'.$coo,checkemptydash((count($rem_result['req_on'])==1 ? php_excel_date(end($rem_result['req_on'])) : implode(" | ",$rem_result['req_on']))))
					
					->SetCellValue('CC'.$coo,checkemptydash(implode(" | ",$rem_result['plan_rem'])))
					->SetCellValue('CD'.$coo,checkemptydash(implode(" | ",$rem_result['plan_by'])))
					->SetCellValue('CE'.$coo,checkemptydash((count($rem_result['plan_on'])==1 ? php_excel_date(end($rem_result['plan_on'])) : implode(" | ",$rem_result['plan_on']))))
					
					->SetCellValue('CF'.$coo,checkemptydash(implode(" | ",$rem_result['admn_rem'])))
					->SetCellValue('CG'.$coo,checkemptydash(implode(" | ",$rem_result['admn_buc'])))
					->SetCellValue('CH'.$coo,checkemptydash(implode(" | ",$rem_result['admn_by'])))
					->SetCellValue('CI'.$coo,checkemptydash((count($rem_result['admn_on'])==1 ? php_excel_date(end($rem_result['admn_on'])) : implode(" | ",$rem_result['admn_on']))))
					
					->SetCellValue('CJ'.$coo,checkemptydash(implode(" | ",$rem_result['other_rem'])))
					->SetCellValue('CK'.$coo,checkemptydash(implode(" | ",$rem_result['other_buc'])))
					->SetCellValue('CL'.$coo,checkemptydash(implode(" | ",$rem_result['other_by'])))
					->SetCellValue('CM'.$coo,checkemptydash((count($rem_result['other_on'])==1 ? php_excel_date(end($rem_result['other_on'])) : implode(" | ",$rem_result['other_on']))));
			}$no_rec++;
		}$sh_index++;
	}
//TT SA
	if($tt_sa){
		if($sh_index>0){ $objPHPExcel->createSheet(); }
		$objPHPExcel->setActiveSheetIndex($sh_index);
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setTitle('TT SA');
		$sql=mysqli_query($mr_con,"SELECT T1.*, T2.* FROM ec_tickets T1 JOIN ec_sitemaster T2 ON T1.site_alias = T2.site_alias AND $con $con1 T1.flag=0");
		if(mysqli_num_rows($sql)){
			$colArr = array("Ticket ID","Login Date","Visit Generated Date","Mode Of Contact","MOC Number","Zone","State","District","Site ID","Site Name","Site Address","First Level Contact Name","First Level Contact Number","Second Level Contact Name","Second Level Contact Number","Second Level Contact Email","Segment","Customer","Activity","Nature of Complaint","Complaint Description","No of Faulty Cells reported by Customer","No of faulty cells reported by Service Engineer","Replaced Cells Count","Product","Battery Bank Rating","No Of String","Mfd Date","Install Date","Sale Invoice Number","Sale Invoice Date","Sale PO Number","Service PO Number","Service PO Date","Site Type","Warranty Status","Activation Date","Planned Date","Planned Service Engineer","Planned Service Engineer Role","Planned Service Engineer Number","efsr No","efsr Date","Closing Date","TAT","Visits","Level","Ticket Status","Milestone","Payment Terms","MRS","Faulty Code","Job Performed","Train No","Express Name","Coach No","Pre Attnd","Poh","Rpoh","Zone","Division","Workshop","Altenate Make","RRU Make","Invertor Make","Regulator Make","Voltage Regulation","Altenate Belt Status","Icc Tightness","Heating Melting Marks","Terminal Tightness","Alt No Belt Avl","Physical Damage","Vent Plug Tightness","Belt","Log Book","Coach Status","Cell Buldge","Charger Band","Manf Date","Serial No","Charger Type","Voltage","Charging Current","High Voltage Cutoff","Voltage Ripple","Voltage Regulation","Fork Lift Brand","Fork Lift Model","Fork Lift Manf Date","Battery Type","Bank Serial No","Manfacturing Date","Installation Date","Plug Type","Acid Level","Float Voltage","Boast Voltage","Current Limit","Voltage Ripple","Voltage Rgulation","High Voltage Cutoff","Low Voltage Cutoff","Panel Make","Panel Rating","Charge Controller Rate","Charge Controller Make","No Solar Panels","Single Panel Rating","Panel Manufacturing Date","Charge Control Manufacturing Date","Panel Installation Date","Physical Damages","Leakage","Temperature","Acid Temp Discharge","Acid Temp Charge","Cells Temp After Use","Cells Temp At Charge","General Observation","Terminal Torque","Vent Plug Thickness","Site Load","Dg Status","Dg Make","Dg Capacity","Dg Working Condition","Avg Dg Run","Eb Supply","Failures Per Day","Avg Power Cut","Required Acc","Required Cells","Faulty Cell Sr No","Customer Comments","Customer Name","Customer Designation","Customer Contact Number","Customer Email","Rating 1","Rating 2","Rating 3","Rating 4","Rating 5","Visited SE Name","Visited SE Remarks","Visited SE Action Date and Time","Visited SE Action Taken","ZHS Name","ZHS Remarks","ZHS Action Date and Time","ZHS Aging","NHS Name","NHS Remarks","NHS Action Date and Time","NHS Aging");
			//$colArr2=array('ticket_id','mode_of_contact','faulty_cell_count','description','login_date','activation_date','planned_date','payment_terms','closing_date','status','site_id','mfd_date','install_date','no_of_string','technician_name','technician_number','manager_name','manager_number','manager_mail','site_address');
			$last_key = end(array_keys($colArr));
			$last_alpha = num2alpha($last_key);
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
			$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue)); $ch++; }
			$sqlR=mysqli_query($mr_con,"SELECT COUNT(id) AS mycount FROM ec_remarks WHERE module='TT' AND flag=0 GROUP BY item_alias ORDER BY mycount DESC LIMIT 1");
			$rowR=mysqli_fetch_array($sqlR);
			$max_rem_count = $rowR['0'];
			$xx = $yy = 'FA'; 
			for($h=0;$h<$max_rem_count;$h++){
				$sheet->SetCellValue($xx.'1','Remarked By ('.($h+1).')'); $xx++;
				$sheet->SetCellValue($xx.'1','Remark ('.($h+1).')');  $xx++;
				$sheet->SetCellValue($xx.'1','Remarked On ('.($h+1).')');
				$sheet->getStyle($xx)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension($xx)->setAutoSize(true);
				$xx++;
			} $xx--;
			$sheet->getStyle($yy.'1:'.$xx.'1')->applyFromArray($styleArray);
			$sheet->getStyle($yy.'1:'.$xx.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$date_arr = array("B","C","AB","AC","AE","AH","AK","AL","AQ","AR","BE","BF","BG","CB","CL","CO","CP","DF","DG","DH","EQ","EU","EY");
			foreach($date_arr as $da){$sheet->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension($da)->setAutoSize(true);}
			$coo=1;
			while($row=mysqli_fetch_array($sql)){ $coo++;
				// 1) Ticket Details
				$ticket_alias = $row['ticket_alias'];
				
				// 2) Engineer Observation
				$tkt_segeng=mysqli_query($mr_con,"SELECT * FROM ec_engineer_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_segeng_row=mysqli_fetch_array($tkt_segeng);
				$f_count = $tkt_segeng_row['total_faulty_count'];
				$rep_cells = $tkt_segeng_row['replaced_cell_no'];
				if(!empty($rep_cells) && strtoupper($rep_cells)!="NIL" && $rep_cells!="-" && $rep_cells!="0"){
					$rep_count=count(explode(",",str_replace(" ","",$rep_cells)));
				}else{$rep_count='0';}
				if(strpos($row['ticket_id'],"|")!==false){
					if(empty(mysqli_num_rows($tkt_segeng)) || $f_count==""){
						$f_count = alias(alias(strtok($row['ticket_id'], "|"),'ec_tickets','ticket_id','ticket_alias'),'ec_engineer_observation','ticket_alias','total_faulty_count');
					}
				}	
				// 3) Coach History
				$tkt_seg=mysqli_query($mr_con,"SELECT * FROM ec_coach_history WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_seg_row=mysqli_fetch_array($tkt_seg);
				
				// 4) Equipment Details
				$tkt_segeq=mysqli_query($mr_con,"SELECT * FROM ec_equip_details WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_segeq_row=mysqli_fetch_array($tkt_segeq);
				
				// 5) Checkpoints
				$tkt_segchk=mysqli_query($mr_con,"SELECT * FROM  ec_check_points WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_segchk_row=mysqli_fetch_array($tkt_segchk);
				
				// 6) Charger Details
				$tkt_segchg=mysqli_query($mr_con,"SELECT * FROM  ec_charger_details WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_segchg_row=mysqli_fetch_array($tkt_segchg);
				
				// 7) Fork Lift
				$tkt_segfrk=mysqli_query($mr_con,"SELECT * FROM  ec_fork_lift WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_segfrk_row=mysqli_fetch_array($tkt_segfrk);
				
				// 8) Battery Details
				$tkt_segbat=mysqli_query($mr_con,"SELECT * FROM  ec_battery_details WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_segbat_row=mysqli_fetch_array($tkt_segbat);
				
				// 9) Technical observations
				$tkt_segtch=mysqli_query($mr_con,"SELECT * FROM  ec_technical_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_segtch_row=mysqli_fetch_array($tkt_segtch);
				
				// 10) physical Observations
				$tkt_segphy=mysqli_query($mr_con,"SELECT * FROM  ec_physical_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_segphy_row=mysqli_fetch_array($tkt_segphy);
				
				// 11) General Observations
				$tkt_seggnr=mysqli_query($mr_con,"SELECT * FROM  ec_general_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_seggnr_row=mysqli_fetch_array($tkt_seggnr);
				
				// 12) Power Observations
				$tkt_segpwr=mysqli_query($mr_con,"SELECT * FROM  ec_power_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_segpwr_row=mysqli_fetch_array($tkt_segpwr);
				
				// 13) E-signature 
				$tkt_segesig=mysqli_query($mr_con,"SELECT * FROM  ec_e_signature WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_segesig_row=mysqli_fetch_array($tkt_segesig);
				
				// 14) Customer Satisfaction
				$tkt_segsatis=mysqli_query($mr_con,"SELECT * FROM  ec_customer_satisfaction WHERE ticket_alias='$ticket_alias' AND flag=0");
				$tkt_segsatis_row=mysqli_fetch_array($tkt_segsatis);
				
				// 15) Remarks
				$sqlRem=mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE module='TT' AND item_alias='$ticket_alias' AND flag=0 ORDER BY id");
				$seBy='';$seOn='';$seRem='';$seAction='';$zhsBy='';$zhsOn='';$zhsRem='';$zhsAge='';$nhsBy='';$nhsOn='';$nhsRem='';$nhsAge='';
				//unset($othBy);unset($othOn);unset($othRem);
				$othBy = array();$othOn = array();$othRem = array();
				while($rowRem = mysqli_fetch_array($sqlRem)){
					if(strtoupper($rowRem['remarked_by'])=='ADMIN'){
						$othBy[]='ADMIN';
						$othOn[]=($rowRem['remarked_on']=="" || $rowRem['remarked_on']=="0000-00-00 00:00:00" ? "-" : php_excel_date($rowRem['remarked_on']));
						$othRem[]= $rowRem['remarks'];
					}else{
						$remarked_by=alias_flag_none($rowRem['remarked_by'],'ec_employee_master','employee_alias','name');
						$remarked_on = ($rowRem['remarked_on']=="" || $rowRem['remarked_on']=="0000-00-00 00:00:00" ? "-" : php_excel_date($rowRem['remarked_on']));
						$remarks = $rowRem['remarks'];
						$bucket=$rowRem['bucket'];
						//$privilege_alias = alias_flag_none($rowRem['remarked_by'],'ec_employee_master','employee_alias','privilege_alias');
						//if($privilege_alias=='3WDRECJ0MA' || $privilege_alias=='PCNKPSJJEU' ){
						if($rowRem['remarked_by']==$row['service_engineer_alias'] && $seBy=='' &&  ($bucket=='7' || $bucket=='8')){
							$seBy=$remarked_by;
							$seOn=$remarked_on;
							$seOn_aging=$rowRem['remarked_on'];
							$seRem=$remarks;
							$seAction=alias($ticket_alias,'ec_ticket_action','ticket_alias','observation');
						}elseif($zhsBy=='' && ($bucket=='1' || $bucket=='2' || $bucket=='9' || $bucket=='11')){
							$zhsBy=$remarked_by;
							$zhsOn=$remarked_on;
							$zhsOn_aging=$rowRem['remarked_on'];
							$zhsRem=$remarks;
							$zhsAge=aging($seOn_aging,$rowRem['remarked_on']);
						}elseif($nhsBy=='' &&  ($bucket=='10' || $bucket=='37' || $bucket=='38' || $bucket=='39')){
							$nhsBy=$remarked_by;
							$nhsOn=$remarked_on;
							$nhsRem=$remarks;
							$nhsAge=aging($zhsOn_aging,$rowRem['remarked_on']);
						}else{
							$othBy[]=$remarked_by;
							$othOn[]=$remarked_on;
							$othRem[]=$remarks;
						}
					}
				}
				
				// 1) Ticket Details
					$ticket_id = strtok($row['ticket_id'],"|");
					$sheet->SetCellValue('A'.$coo, checkemptydash($ticket_id))
						->SetCellValue('B'.$coo, ($row['login_date']=="" ? "-" : php_excel_date($row['login_date'])))
						->SetCellValue('C'.$coo, ($row['visit_gen_date']=="" ? "-" : php_excel_date($row['visit_gen_date'])))
						->SetCellValue('D'.$coo, checkemptydash(alias($row['mode_of_contact'],'ec_moc','moc_alias','moc_name')))
						->SetCellValue('E'.$coo, checkemptydash($row['moc_num']))
						->SetCellValue('F'.$coo, checkemptydash(alias($row['zone_alias'],'ec_zone','zone_alias','zone_name')))
						->SetCellValue('G'.$coo, checkemptydash(alias($row['state_alias'],'ec_state','state_alias','state_name')))
						->SetCellValue('H'.$coo, checkemptydash(alias($row['district_alias'],'ec_district','district_alias','district_name')))
						//->SetCellValue('I'.$coo, checkemptydash($row['site_id']))
						->setCellValueExplicit('I'.$coo, checkemptydash($row['site_id']),PHPExcel_Cell_DataType::TYPE_STRING)
						->SetCellValue('J'.$coo, checkemptydash($row['site_name']))
						->SetCellValue('K'.$coo, checkemptydash($row['site_address']))
						->SetCellValue('L'.$coo, checkemptydash($row['technician_name']))
						->SetCellValue('M'.$coo, checkemptydash($row['technician_number']))
						->SetCellValue('N'.$coo, checkemptydash($row['manager_name']))
						->SetCellValue('O'.$coo, checkemptydash($row['manager_number']))
						->SetCellValue('P'.$coo, checkemptydash($row['manager_mail']))
						->SetCellValue('Q'.$coo, checkemptydash(alias($row['segment_alias'],'ec_segment','segment_alias','segment_name')))
						->SetCellValue('R'.$coo, checkemptydash(alias($row['customer_alias'],'ec_customer','customer_alias','customer_code')))
						->SetCellValue('S'.$coo, checkemptydash(alias($row['activity_alias'],'ec_activity','activity_alias','activity_name')))
						->SetCellValue('T'.$coo, checkemptydash(alias($row['complaint_alias'],'ec_complaint','complaint_alias','complaint_name')))
						->SetCellValue('U'.$coo, checkemptydash($row['description']))
						->SetCellValue('V'.$coo, checkemptydash($row['faulty_cell_count']))
						->SetCellValue('W'.$coo, checkemptydash($f_count))
						->SetCellValue('X'.$coo, checkemptydash($rep_count))
						->SetCellValue('Y'.$coo, checkemptydash(alias($row['product_alias'],'ec_product','product_alias','product_description')))
						->SetCellValue('Z'.$coo, checkemptydash($row['battery_bank_rating']))
						->SetCellValue('AA'.$coo, checkemptydash($row['no_of_string']))
						->SetCellValue('AB'.$coo, php_excel_date($row['mfd_date']))
						->SetCellValue('AC'.$coo, php_excel_date($row['install_date']))
						
						->SetCellValue('AD'.$coo, checkemptydash($row['sale_invoice_num']))
						->SetCellValue('AE'.$coo, php_excel_date($row['sale_invoice_date']))
						->SetCellValue('AF'.$coo, checkemptydash($row['po_num']))
						
						->SetCellValue('AG'.$coo, checkemptydash($row['po_number']))
						->SetCellValue('AH'.$coo, php_excel_date($row['po_date']))
						
						->SetCellValue('AI'.$coo, checkemptydash(alias($row['site_type_alias'],'ec_site_type','site_type_alias','site_type')))
						->SetCellValue('AJ'.$coo, ($row['warranty']>0 ? 'UNDER WARRANTY' : 'OUT OF WARRANTY'))
						->SetCellValue('AK'.$coo, php_excel_date($row['activation_date']))
						->SetCellValue('AL'.$coo, php_excel_date($row['planned_date']))
						->SetCellValue('AM'.$coo, checkemptydash(alias_flag_none($row['service_engineer_alias'],'ec_employee_master','employee_alias','name')))
						->SetCellValue('AN'.$coo, checkemptydash(alias(alias_flag_none($row['service_engineer_alias'],'ec_employee_master','employee_alias','role_alias'),'ec_emprole','role_alias','role_name')))
						->SetCellValue('AO'.$coo, checkemptydash(alias_flag_none($row['service_engineer_alias'],'ec_employee_master','employee_alias','mobile_number')))
						//->SetCellValue('AP'.$coo, checkemptydash($row['efsr_no']))
						->setCellValueExplicit('AP'.$coo, checkemptydash($row['efsr_no']),PHPExcel_Cell_DataType::TYPE_STRING)
						->SetCellValue('AQ'.$coo, ($row['efsr_date']=="" ? "-" : php_excel_date($row['efsr_date'])))
						->SetCellValue('AR'.$coo, ($row['closing_date']=="" || $row['level']<6 ? "-" : php_excel_date($row['closing_date'])))
						->SetCellValue('AS'.$coo, checkemptydash((!empty($row['tat']) ? $row['tat'] : tat($ticket_alias))))
						->SetCellValue('AT'.$coo, visit_exp_count($ticket_id))
						->SetCellValue('AU'.$coo, checkemptydash(($row['level']=='1' || $row['level']=='2' || $row['level']=='4' || $row['level']=='5' ? repl_planfail_tsrej($row['level'],$row['old_level'],$row['planned_date'],$row['purpose'],'name'):alias($row['level'],'ec_levels','level_alias','level_name'))))
						->SetCellValue('AV'.$coo, checkemptydash($row['status']))
						->SetCellValue('AW'.$coo, checkemptydash(alias($row['milestone'],'ec_milestone','mile_stone_alais','mile_stone')))
						->SetCellValue('AX'.$coo, checkemptydash($row['payment_terms']))
						->SetCellValue('AY'.$coo, checkemptydash(mrfStatus($row['ticket_alias'])))
				// 2) Engineer Observation
						->SetCellValue('AZ'.$coo, checkemptydash(alias($tkt_segeng_row['faulty_code_alias'],'ec_faulty_code','faulty_alias','description')))
						->SetCellValue('BA'.$coo, checkemptydash($tkt_segeng_row['job_performed']))
				// 3) Coach History
						->SetCellValue('BB'.$coo, checkemptydash($tkt_seg_row['train_no']))
						->SetCellValue('BC'.$coo, checkemptydash($tkt_seg_row['express_name']))
						->SetCellValue('BD'.$coo, checkemptydash($tkt_seg_row['coach_no']))
						->SetCellValue('BE'.$coo, php_excel_date($tkt_seg_row['pre_attnd']))
						->SetCellValue('BF'.$coo, php_excel_date($tkt_seg_row['poh']))
						->SetCellValue('BG'.$coo, php_excel_date($tkt_seg_row['rpoh']))
						->SetCellValue('BH'.$coo, checkemptydash($tkt_seg_row['zone']))
						->SetCellValue('BI'.$coo, checkemptydash($tkt_seg_row['division']))
						->SetCellValue('BJ'.$coo, checkemptydash($tkt_seg_row['workshop']))
				// 4) Equipment details
						->SetCellValue('BK'.$coo, checkemptydash($tkt_segeq_row['altenate_make']))
						->SetCellValue('BL'.$coo, checkemptydash($tkt_segeq_row['rru_make']))
						->SetCellValue('BM'.$coo, checkemptydash($tkt_segeq_row['invertor_make']))
						->SetCellValue('BN'.$coo, checkemptydash($tkt_segeq_row['regulator_make']))
						->SetCellValue('BO'.$coo, checkemptydash($tkt_segeq_row['voltage_regulation']))
						->SetCellValue('BP'.$coo, checkemptydash($tkt_segeq_row['altenate_belt_status']))
				// 5) Checkpoints
						->SetCellValue('BQ'.$coo, checkemptydash($tkt_segchk_row['icc_tightness']))
						->SetCellValue('BR'.$coo, checkemptydash($tkt_segchk_row['heating_melting_marks']))
						->SetCellValue('BS'.$coo, checkemptydash($tkt_segchk_row['terminal_tightness']))
						->SetCellValue('BT'.$coo, checkemptydash($tkt_segchk_row['alt_no_belt_avl']))
						->SetCellValue('BU'.$coo, checkemptydash($tkt_segchk_row['physical_damage']))
						->SetCellValue('BV'.$coo, checkemptydash($tkt_segchk_row['vent_plug_tightness']))
						->SetCellValue('BW'.$coo, checkemptydash($tkt_segchk_row['belt']))
						->SetCellValue('BX'.$coo, checkemptydash($tkt_segchk_row['log_book']))
						->SetCellValue('BY'.$coo, checkemptydash($tkt_segchk_row['coach_status']))
						->SetCellValue('BZ'.$coo, checkemptydash($tkt_segchk_row['cell_buldge']))
				// 6) Charger Details
						->SetCellValue('CA'.$coo, checkemptydash($tkt_segchg_row['charger_band']))
						->SetCellValue('CB'.$coo, php_excel_date($tkt_segchg_row['mfd_date']))
						->SetCellValue('CC'.$coo, checkemptydash($tkt_segchg_row['serial_no']))
						->SetCellValue('CD'.$coo, checkemptydash($tkt_segchg_row['charger_type']))
						->SetCellValue('CE'.$coo, checkemptydash($tkt_segchg_row['voltage']))
						->SetCellValue('CF'.$coo, checkemptydash($tkt_segchg_row['charging_current']))
						->SetCellValue('CG'.$coo, checkemptydash($tkt_segchg_row['high_voltage_cutoff']))
						->SetCellValue('CH'.$coo, checkemptydash($tkt_segchg_row['voltage_ripple']))
						->SetCellValue('CI'.$coo, checkemptydash($tkt_segchg_row['voltage_regulation']))
				// 7) Fork Lift
						->SetCellValue('CJ'.$coo, checkemptydash($tkt_segfrk_row['fork_lift_brand']))
						->SetCellValue('CK'.$coo, checkemptydash($tkt_segfrk_row['fork_lift_model']))
						->SetCellValue('CL'.$coo, php_excel_date($tkt_segfrk_row['fork_lift_manf_date']))
				// 8) Battery Details
						->SetCellValue('CM'.$coo, checkemptydash($tkt_segbat_row['battey_type']))
						->SetCellValue('CN'.$coo, checkemptydash($tkt_segbat_row['bank_serial_no']))
						->SetCellValue('CO'.$coo, php_excel_date($tkt_segbat_row['manf_date']))
						->SetCellValue('CP'.$coo, php_excel_date($tkt_segbat_row['ins_date']))
						->SetCellValue('CQ'.$coo, checkemptydash($tkt_segbat_row['plug_type']))
						->SetCellValue('CR'.$coo, checkemptydash($tkt_segbat_row['acid_level']))
				// 9) Technical observations
						->SetCellValue('CS'.$coo, checkemptydash($tkt_segtch_row['float_voltage']))
						->SetCellValue('CT'.$coo, checkemptydash($tkt_segtch_row['boast_voltage']))
						->SetCellValue('CU'.$coo, checkemptydash($tkt_segtch_row['current_limit']))
						->SetCellValue('CV'.$coo, checkemptydash($tkt_segtch_row['voltage_ripple']))
						->SetCellValue('CW'.$coo, checkemptydash($tkt_segtch_row['voltage_regulation']))
						->SetCellValue('CX'.$coo, checkemptydash($tkt_segtch_row['high_voltage_cutoff']))
						->SetCellValue('CY'.$coo, checkemptydash($tkt_segtch_row['low_voltage_cutoff']))
						->SetCellValue('CZ'.$coo, checkemptydash($tkt_segtch_row['panel_make']))
						->SetCellValue('DA'.$coo, checkemptydash($tkt_segtch_row['panel_rating']))
						->SetCellValue('DB'.$coo, checkemptydash($tkt_segtch_row['charge_controller_rate']))
						->SetCellValue('DC'.$coo, checkemptydash($tkt_segtch_row['charge_controller_make']))
						->SetCellValue('DD'.$coo, checkemptydash($tkt_segtch_row['no_solar_panels']))
						->SetCellValue('DE'.$coo, checkemptydash($tkt_segtch_row['single_panel_rating']))
						->SetCellValue('DF'.$coo, php_excel_date($tkt_segtch_row['panel_manufacturing_date']))
						->SetCellValue('DG'.$coo, php_excel_date($tkt_segtch_row['charge_control_manufacturing_date']))
						->SetCellValue('DH'.$coo, php_excel_date($tkt_segtch_row['panel_installation_date']))
				// 10) physical Observations
						->SetCellValue('DI'.$coo, checkemptydash($tkt_segphy_row['physical_damages']))
						->SetCellValue('DJ'.$coo, checkemptydash($tkt_segphy_row['leakage']))
						->SetCellValue('DK'.$coo, checkemptydash($tkt_segphy_row['temperature']))
						->SetCellValue('DL'.$coo, checkemptydash($tkt_segphy_row['acid_temp_discharge']))
						->SetCellValue('DM'.$coo, checkemptydash($tkt_segphy_row['acid_temp_charge']))
						->SetCellValue('DN'.$coo, checkemptydash($tkt_segphy_row['cells_temp_after_use']))
						->SetCellValue('DO'.$coo, checkemptydash($tkt_segphy_row['cells_temp_at_charge']))
						->SetCellValue('DP'.$coo, checkemptydash($tkt_segphy_row['general_observation']))
						->SetCellValue('DQ'.$coo, checkemptydash($tkt_segphy_row['terminal_torque']))
						->SetCellValue('DR'.$coo, checkemptydash($tkt_segphy_row['vent_plug_thickness']))
				// 11) General Observations
						->SetCellValue('DS'.$coo, checkemptydash($tkt_seggnr_row['site_load']))
						->SetCellValue('DT'.$coo, checkemptydash($tkt_seggnr_row['dg_status']))
						->SetCellValue('DU'.$coo, checkemptydash($tkt_seggnr_row['dg_make']))
						->SetCellValue('DV'.$coo, checkemptydash($tkt_seggnr_row['dg_capacity']))
						->SetCellValue('DW'.$coo, checkemptydash($tkt_seggnr_row['dg_working_condition']))
						->SetCellValue('DX'.$coo, checkemptydash($tkt_seggnr_row['avg_dg_run']))
				// 12)Power Observations
						->SetCellValue('DY'.$coo, checkemptydash($tkt_segpwr_row['eb_supply']))
						->SetCellValue('DZ'.$coo, checkemptydash($tkt_segpwr_row['failures_per_day']))
						->SetCellValue('EA'.$coo, checkemptydash($tkt_segpwr_row['avg_power_cut']))
				// 2) Engineer Observation
						->SetCellValue('EB'.$coo, checkemptydash($tkt_segeng_row['req_acc']))
						->SetCellValue('EC'.$coo, checkemptydash($tkt_segeng_row['req_cells']))
						->SetCellValue('ED'.$coo, checkemptydash($tkt_segeng_row['faulty_cell_sr_no']))
				//Customer Comment
						->SetCellValue('EE'.$coo, checkemptydash(alias($ticket_alias,'ec_customer_comments','ticket_alias','customer_comments')))
				// 13) E-signature
						->SetCellValue('EF'.$coo, checkemptydash($tkt_segesig_row['name']))
						->SetCellValue('EG'.$coo, checkemptydash($tkt_segesig_row['designation']))
						->SetCellValue('EH'.$coo, checkemptydash($tkt_segesig_row['contact_number']))
						->SetCellValue('EI'.$coo, checkemptydash($tkt_segesig_row['email']))
				// 14) Customer Satisfaction
						->SetCellValue('EJ'.$coo, checkemptydash($tkt_segsatis_row['q1']))
						->SetCellValue('EK'.$coo, checkemptydash($tkt_segsatis_row['q2']))
						->SetCellValue('EL'.$coo, checkemptydash($tkt_segsatis_row['q3']))
						->SetCellValue('EM'.$coo, checkemptydash($tkt_segsatis_row['q4']))
						->SetCellValue('EN'.$coo, checkemptydash($tkt_segsatis_row['q5']))
				// 15) Remarks
						->SetCellValue('EO'.$coo,checkemptydash($seBy))
						->SetCellValue('EP'.$coo,checkemptydash($seRem))
						->SetCellValue('EQ'.$coo,$seOn)
						->SetCellValue('ER'.$coo,checkemptydash($seAction))
		
						->SetCellValue('ES'.$coo,checkemptydash($zhsBy))
						->SetCellValue('ET'.$coo,checkemptydash($zhsRem))
						->SetCellValue('EU'.$coo,$zhsOn)
						->SetCellValue('EV'.$coo,checkemptydash($zhsAge))
		
						->SetCellValue('EW'.$coo,checkemptydash($nhsBy))
						->SetCellValue('EX'.$coo,checkemptydash($nhsRem))
						->SetCellValue('EY'.$coo,$nhsOn)
						->SetCellValue('EZ'.$coo,checkemptydash($nhsAge));
				
				$cd = $c = 'FA';
				if(count($othBy)){
					for($i=0;$i<count($othBy);$i++){
						$sheet->SetCellValue($c.$coo, checkemptydash($othBy[$i])); $c++;
						$sheet->SetCellValue($c.$coo, checkemptydash($othRem[$i])); $c++;
						$sheet->SetCellValue($c.$coo, $othOn[$i]); $c++;
					}
				}
				$cd = $c = $xx;
				$planned_remarks = alias($ticket_alias,'ec_tickets','ticket_alias','planned_remarks');
				if(!empty($planned_remarks)){
					$planned_arr = explode(", ",$planned_remarks);
					$sheet->SetCellValue($c.'1', "Re Plan Count");
					$sheet->SetCellValue($c.$coo, count($planned_arr));$c++;
					foreach($planned_arr as $k=>$plann){
						list($date,$service_ali,$rem_ali) = explode("|",$plann);
						$sheet->getStyle($c)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension($c)->setAutoSize(true);
						$sheet->SetCellValue($c.'1','Planned Date ('.($k+1).')')
							->SetCellValue($c.$coo, ($date=="" || $date=="0000-00-00 00:00:00" ? "-" : php_excel_date($date)));
						$c++;
						$sheet->SetCellValue($c.'1','Service Engineer ('.($k+1).')')
							->SetCellValue($c.$coo, checkemptydash(alias_flag_none($service_ali,'ec_employee_master','employee_alias','name')));
						$c++;
						$sheet->SetCellValue($c.'1','Remarks ('.($k+1).')')
							->SetCellValue($c.$coo, checkemptydash(alias($rem_ali,'ec_remarks','remark_alias','remarks')));
						$c++;
					}$c--;
						$sheet->getStyle($cd.'1:'.$c.'1')->applyFromArray($styleArray);
						$sheet->getStyle($cd.'1:'.$c.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
				}
			}$no_rec++;
		}$sh_index++;
	}

//TT BTR
	if($btr){
		$fromdate=$_REQUEST['from_date'];
		$todate=$_REQUEST['to_date'];
		$a=$z="";
		if(!empty($fromdate) && empty($todate)){
			$x=$fromdate;
			$y=date('d-m-Y');
		}
		else if(empty($fromdate) && !empty($todate)){
			$x=$todate;
			$y=date('d-m-Y');
			$a="NOT";
		}
		else if(!empty($fromdate) && !empty($todate)){
			$x=$fromdate;
			$y=$todate;
		}else {
			$x=$fromdate;
			$y=$todate;
		}
		if(!empty($x) || !empty($y))$z="T3.mf_date $a IN('".implode("','",dateranges($x,$y))."') AND";else $z="";
		
		if($sh_index>0){ $objPHPExcel->createSheet(); }
		$objPHPExcel->setActiveSheetIndex($sh_index);
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setTitle('TT BTR');
		$sql=mysqli_query($mr_con,"SELECT T1.ticket_id, T1.login_date, T2.segment_alias, T2.customer_alias, T2.product_alias,T2.no_of_string,T3.cell_sl_no,T3.mf_date,T3.faulty_code_alias FROM ec_fsr_faulty_cells T3 INNER JOIN ec_tickets T1 ON T1.ticket_alias=T3.ticket_alias INNER JOIN ec_sitemaster T2 ON T2.site_alias=T1.site_alias WHERE $z $con T3.flag=0 GROUP BY T3.cell_sl_no,T3.mf_date,T2.product_alias");
		if(mysqli_num_rows($sql)){
			$colArr = array("Ticket ID","Login Date","Segment","Customer","Product","No. Of Banks","Mfd Date","Cell Serial Number","Faulty Code");
			$last_key = end(array_keys($colArr));
			$last_alpha = num2alpha($last_key);
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
			$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue)); $ch++; }
			$sheet->getStyle("B")->getNumberFormat()->setFormatCode('mm/dd/yyyy');
			$sheet->getColumnDimension("B")->setAutoSize(true);
			$sheet->getStyle("G")->getNumberFormat()->setFormatCode('mm/dd/yyyy');
			$sheet->getColumnDimension("G")->setAutoSize(true);
			$coo=1; $prod=$customer=$segment=array();
			while($row=mysqli_fetch_array($sql)){$coo++;
				$sheet->SetCellValue('A'.$coo, checkemptydash(strtok($row['ticket_id'],'|')))
						->SetCellValue('B'.$coo, php_excel_date($row['login_date']))
						->SetCellValue('C'.$coo, checkemptydash((array_key_exists($row['segment_alias'],$segment) ? $segment[$row['segment_alias']] : $segment[$row['segment_alias']] = alias($row['segment_alias'],'ec_segment','segment_alias','segment_name'))))
						->SetCellValue('D'.$coo, checkemptydash((array_key_exists($row['customer_alias'],$customer) ? $customer[$row['customer_alias']] : $customer[$row['customer_alias']] = alias($row['customer_alias'],'ec_customer','customer_alias','customer_code'))))
						->SetCellValue('E'.$coo, checkemptydash((array_key_exists($row['product_alias'],$prod) ? $prod[$row['product_alias']] : $prod[$row['product_alias']] = alias($row['product_alias'],'ec_product','product_alias','battery_rating'))))
						->SetCellValue('F'.$coo, $row['no_of_string'])
						->SetCellValue('G'.$coo, php_excel_date(implode("-",array_reverse(explode("/","01/".$row['mf_date'])))))
						->setCellValueExplicit('H'.$coo, $row['cell_sl_no'],PHPExcel_Cell_DataType::TYPE_STRING)
						->SetCellValue('I'.$coo, alias($row['faulty_code_alias'],'ec_faulty_code','faulty_alias','description'));
			}$no_rec++;
		}else{$sheet->SetCellValue("A2", "NO RECORDS FOUND");}
		/*
		if(mysqli_num_rows($sql)){
			$colArr = array("Ticket ID","Segment","Customer","Battery Bank Rating","No. Of Banks","No. of faulty cells reported by Service Engineer","Mfd Date","Cell Serial Number","Acid Density","OCV","OC1","OC2","OC3","OC4","OC5","OC6","OC7","OC8","OC9","OC10","DC1","DC2","DC3","DC4","DC5","DC6","DC7","DC8","DC9","DC10","OCT1","OCT2","OCT3","OCT4","OCT5","OCT6","OCT7","OCT8","OCT9","OCT10","Remarks");
			$last_key = end(array_keys($colArr));
			$last_alpha = num2alpha($last_key);
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
			$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue)); $ch++; }
			$coo=1;
			while($row=mysqli_fetch_array($sql)){
				$ticket_alias = $row['ticket_alias'];				
				$item_bb_cap=mysqli_query($mr_con,"SELECT item_alias FROM ec_battery_bank_bb_cap WHERE ticket_alias='$ticket_alias' AND image='0' AND flag=0");
				if(mysqli_num_rows($item_bb_cap)){$k=1;
					while($item_bb_cap_row=mysqli_fetch_array($item_bb_cap)){ $item_alias = $item_bb_cap_row['item_alias'];
						$tkt_telecom=mysqli_query($mr_con,"SELECT * FROM ec_bo_telecom_ic WHERE battery_bb_alias='$item_alias' AND flag=0");
						
						$oc = header_fun($item_alias,'on_charge_voltage_1','header');
						$dc = header_fun($item_alias,'discharge_voltage','header');
						$oc2 = header_fun($item_alias,'on_charge_voltage_2','header');
						$coo++;
						for($z='K',$z1=0;$z1<count($oc['header']);$z++,$z1++){$sheet->SetCellValue($z.$coo, $oc['header'][$z1]);}
						for($y='U',$y1=0;$y1<count($dc['header']);$y++,$y1++){$sheet->SetCellValue($y.$coo, $dc['header'][$y1]);}
						for($x='AE',$x1=0;$x1<count($oc2['header']);$x++,$x1++){$sheet->SetCellValue($x.$coo, $oc2['header'][$x1]);}
						
						$objPHPExcel->getActiveSheet()->getStyle('K'.$coo.':AN'.$coo)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$coo.':AN'.$coo)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '996633')));
						
						while($tkt_telecom_row=mysqli_fetch_array($tkt_telecom)){ $coo++;
						$f_count = alias($ticket_alias,'ec_engineer_observation','ticket_alias','faulty_cell_sr_no');
						$sheet->SetCellValue('A'.$coo, checkemptydash(strtok($row['ticket_id'],"|")))
							->SetCellValue('B'.$coo, checkemptydash(alias($row['segment_alias'],'ec_segment','segment_alias','segment_name')))
							->SetCellValue('C'.$coo, checkemptydash(alias($row['customer_alias'],'ec_customer','customer_alias','customer_code')))
							->SetCellValue('D'.$coo, checkemptydash($row['battery_bank_rating']))
							->SetCellValue('E'.$coo, $k)
							->SetCellValue('F'.$coo, (strpos($f_count,$tkt_telecom_row['cell_sl_no'])!==false ? '1' : '0'))
							->SetCellValue('G'.$coo, $tkt_telecom_row['mf_date'])
							->SetCellValue('H'.$coo, $tkt_telecom_row['cell_sl_no'])
							->SetCellValue('I'.$coo, $tkt_telecom_row['acid_density'])
							->SetCellValue('J'.$coo, $tkt_telecom_row['ocv'])
							->SetCellValue('K'.$coo, $tkt_telecom_row['1hr'])
							->SetCellValue('L'.$coo, $tkt_telecom_row['2hr'])
							->SetCellValue('M'.$coo, $tkt_telecom_row['3hr'])
							->SetCellValue('N'.$coo, $tkt_telecom_row['4hr'])
							->SetCellValue('O'.$coo, $tkt_telecom_row['5hr'])
							->SetCellValue('P'.$coo, $tkt_telecom_row['6hr'])
							->SetCellValue('Q'.$coo, $tkt_telecom_row['7hr'])
							->SetCellValue('R'.$coo, $tkt_telecom_row['8hr'])
							->SetCellValue('S'.$coo, $tkt_telecom_row['9hr'])
							->SetCellValue('T'.$coo, $tkt_telecom_row['10hr'])
							->SetCellValue('U'.$coo, $tkt_telecom_row['11hr'])
							->SetCellValue('V'.$coo, $tkt_telecom_row['12hr'])
							->SetCellValue('W'.$coo, $tkt_telecom_row['13hr'])
							->SetCellValue('X'.$coo, $tkt_telecom_row['14hr'])
							->SetCellValue('Y'.$coo, $tkt_telecom_row['15hr'])
							->SetCellValue('Z'.$coo, $tkt_telecom_row['16hr'])
							->SetCellValue('AA'.$coo, $tkt_telecom_row['17hr'])
							->SetCellValue('AB'.$coo, $tkt_telecom_row['18hr'])
							->SetCellValue('AC'.$coo, $tkt_telecom_row['19hr'])
							->SetCellValue('AD'.$coo, $tkt_telecom_row['20hr'])
							->SetCellValue('AE'.$coo, $tkt_telecom_row['21hr'])
							->SetCellValue('AF'.$coo, $tkt_telecom_row['22hr'])
							->SetCellValue('AG'.$coo, $tkt_telecom_row['23hr'])
							->SetCellValue('AH'.$coo, $tkt_telecom_row['24hr'])
							->SetCellValue('AI'.$coo, $tkt_telecom_row['25hr'])
							->SetCellValue('AJ'.$coo, $tkt_telecom_row['26hr'])
							->SetCellValue('AK'.$coo, $tkt_telecom_row['27hr'])
							->SetCellValue('AL'.$coo, $tkt_telecom_row['28hr'])
							->SetCellValue('AM'.$coo, $tkt_telecom_row['29hr'])
							->SetCellValue('AN'.$coo, $tkt_telecom_row['30hr'])
							->SetCellValue('AO'.$coo, (!empty($tkt_telecom_row['remarks']) ? $tkt_telecom_row['remarks'] : '-'));
						}
						$id = alias($item_alias,'ec_bo_headers','item_alias','id');
						if(!empty($id) && $id!='NA'){
							$coo++; $coo1 = $coo;
							$ocv_tv = header_fun($item_alias,'ocv','total_voltage');
							$oc_tv = header_fun($item_alias,'on_charge_voltage_1','total_voltage');
							$dc_tv = header_fun($item_alias,'discharge_voltage','total_voltage');
							$oc2_tv = header_fun($item_alias,'on_charge_voltage_2','total_voltage');
							$sheet->SetCellValue('I'.$coo, 'Total Voltage (V)');
							$sheet->SetCellValue('J'.$coo, $ocv_tv['total_voltage'][0]);
							for($z='K',$z1=0;$z1<count($oc_tv['total_voltage']);$z++,$z1++){$sheet->SetCellValue($z.$coo, $oc_tv['total_voltage'][$z1]);}
							for($y='U',$y1=0;$y1<count($dc_tv['total_voltage']);$y++,$y1++){$sheet->SetCellValue($y.$coo, $dc_tv['total_voltage'][$y1]);}
							for($x='AE',$x1=0;$x1<count($oc2_tv['total_voltage']);$x++,$x1++){$sheet->SetCellValue($x.$coo, $oc2_tv['total_voltage'][$x1]);}
							
							$coo++;
							$ocv_cc = header_fun($item_alias,'ocv','charging_current');
							$oc_cc = header_fun($item_alias,'on_charge_voltage_1','charging_current');
							$dc_cc = header_fun($item_alias,'discharge_voltage','charging_current');
							$oc2_cc = header_fun($item_alias,'on_charge_voltage_2','charging_current');
							$sheet->SetCellValue('I'.$coo, 'Current (I)');
							$sheet->SetCellValue('J'.$coo, $ocv_cc['charging_current'][0]);
							for($z='K',$z1=0;$z1<count($oc_cc['charging_current']);$z++,$z1++){$sheet->SetCellValue($z.$coo, $oc_cc['charging_current'][$z1]);}
							for($y='U',$y1=0;$y1<count($dc_cc['charging_current']);$y++,$y1++){$sheet->SetCellValue($y.$coo, $dc_cc['charging_current'][$y1]);}
							for($x='AE',$x1=0;$x1<count($oc2_cc['charging_current']);$x++,$x1++){$sheet->SetCellValue($x.$coo, $oc2_cc['charging_current'][$x1]);}
							
							$coo++;
							$ocv_tmp = header_fun($item_alias,'ocv','temperature');
							$oc_tmp = header_fun($item_alias,'on_charge_voltage_1','temperature');
							$dc_tmp = header_fun($item_alias,'discharge_voltage','temperature');
							$oc2_tmp = header_fun($item_alias,'on_charge_voltage_2','temperature');
							$sheet->SetCellValue('I'.$coo, 'Temperature');
							$sheet->SetCellValue('J'.$coo, $ocv_tmp['temperature'][0]);
							for($z='K',$z1=0;$z1<count($oc_tmp['temperature']);$z++,$z1++){$sheet->SetCellValue($z.$coo, $oc_tmp['temperature'][$z1]);}
							for($y='U',$y1=0;$y1<count($dc_tmp['temperature']);$y++,$y1++){$sheet->SetCellValue($y.$coo, $dc_tmp['temperature'][$y1]);}
							for($x='AE',$x1=0;$x1<count($oc2_tmp['temperature']);$x++,$x1++){$sheet->SetCellValue($x.$coo, $oc2_tmp['temperature'][$x1]);}
	
							$objPHPExcel->getActiveSheet()->getStyle('I'.$coo1.':AN'.$coo)->applyFromArray($styleArray);
							$objPHPExcel->getActiveSheet()->getStyle('I'.$coo1.':AN'.$coo)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '336600')));
						}
				$k++;}
				}//else{ $coo++;}
			}
		}else{$sheet->SetCellValue("A2", "NO RECORDS FOUND");}
	*/
		$sh_index++;
	}
//TS
	if($ts){
		if($sh_index>0){ $objPHPExcel->createSheet(); }
		$objPHPExcel->setActiveSheetIndex($sh_index);
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setTitle('TS');
		$sql=mysqli_query($mr_con,"SELECT T1.*, T2.*, T3.*, T4.* FROM ec_tickets T1
				INNER JOIN ec_sitemaster T2 ON T1.site_alias = T2.site_alias
				INNER JOIN ec_ths_approved T3 ON T1.ticket_alias = T3.ticket_alias
				LEFT JOIN ec_ths_faulty_ocv T4 ON T3.alias = T4.ths_appr_alias
			AND $con T1.flag=0");
		if(mysqli_num_rows($sql)){
			$colArr = array("Ticket ID","Login Date","Visit Generated Date","Zone","State","District","Site ID","Site Name","Segment","Customer","Activity","Nature of Complaint","Complaint Description","No of Faulty Cells reported by Customer","No of Faulty Cells reported by Service Engineer","Product","Battery Bank Rating","No Of String","Mfd Date","Install Date","Sale Invoice Number","Sale Invoice Date","Sale PO Number","Service PO Number","Service PO Date","Site Type","Warranty Status","efsr No","efsr Date","Faulty Code","Closing Date","TAT","Visits","Level","Car Number","Line Number","Shift","Date Of Assembly","Date Of Jar formation","Faulty Cell Number","10th Hour Reading","OCV at Dispatch","Corrective Actions Planned","TS Status","Root Cause of nonconformity","Persons Notified","Deposition","Prevent Recurrence");
			$last_key = end(array_keys($colArr));
			$last_alpha = num2alpha($last_key);
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
			$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue)); $ch++; }
			$date_arr = array("B","C","S","T","V","Y","AC","AE","AL","AM");
			foreach($date_arr as $da){$sheet->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension($da)->setAutoSize(true);}
			$coo=1;
			while($row=mysqli_fetch_array($sql)){ $coo++;
				// 1) Ticket Details
				$ticket_alias = $row['ticket_alias'];
				// 2) Faulty Count
				$faulty_code = alias(alias($ticket_alias,'ec_engineer_observation','ticket_alias','faulty_code_alias'),'ec_faulty_code','faulty_alias','description');
				$f_count1 = alias($ticket_alias,'ec_engineer_observation','ticket_alias','total_faulty_count');
				if(strpos($row['ticket_id'],"|")!==false)if($f_count1=="NA" || $f_count1=="")$f_count1 = alias(alias(strtok($row['ticket_id'], "|"),'ec_tickets','ticket_id','ticket_alias'),'ec_engineer_observation','ticket_alias','total_faulty_count');
				// 1) Ticket Details
					$ticket_id = strtok($row['ticket_id'],"|");
					$sheet->SetCellValue('A'.$coo, checkemptydash($ticket_id))
						->SetCellValue('B'.$coo, ($row['login_date']=="" ? "-" : php_excel_date($row['login_date'])))
						->SetCellValue('C'.$coo, ($row['visit_gen_date']=="" ? "-" : php_excel_date($row['visit_gen_date'])))
						->SetCellValue('D'.$coo, checkemptydash(alias($row['zone_alias'],'ec_zone','zone_alias','zone_name')))
						->SetCellValue('E'.$coo, checkemptydash(alias($row['state_alias'],'ec_state','state_alias','state_name')))
						->SetCellValue('F'.$coo, checkemptydash(alias($row['district_alias'],'ec_district','district_alias','district_name')))
						//->SetCellValue('G'.$coo, checkemptydash($row['site_id']))
						->setCellValueExplicit('G'.$coo, checkemptydash($row['site_id']),PHPExcel_Cell_DataType::TYPE_STRING)
						->SetCellValue('H'.$coo, checkemptydash($row['site_name']))
						->SetCellValue('I'.$coo, checkemptydash(alias($row['segment_alias'],'ec_segment','segment_alias','segment_name')))
						->SetCellValue('J'.$coo, checkemptydash(alias($row['customer_alias'],'ec_customer','customer_alias','customer_code')))
						->SetCellValue('K'.$coo, checkemptydash(alias($row['activity_alias'],'ec_activity','activity_alias','activity_name')))
						->SetCellValue('L'.$coo, checkemptydash(alias($row['complaint_alias'],'ec_complaint','complaint_alias','complaint_name')))
						->SetCellValue('M'.$coo, checkemptydash($row['description']))
						->SetCellValue('N'.$coo, checkemptydash($row['faulty_cell_count']))
						->SetCellValue('O'.$coo, checkemptydash($f_count1))
						->SetCellValue('P'.$coo, checkemptydash(alias($row['product_alias'],'ec_product','product_alias','product_description')))
						->SetCellValue('Q'.$coo, checkemptydash($row['battery_bank_rating']))
						->SetCellValue('R'.$coo, checkemptydash($row['no_of_string']))
						->SetCellValue('S'.$coo, php_excel_date($row['mfd_date']))
						->SetCellValue('T'.$coo, php_excel_date($row['install_date']))
						
						->SetCellValue('U'.$coo, checkemptydash($row['sale_invoice_num']))
						->SetCellValue('V'.$coo, php_excel_date($row['sale_invoice_date']))
						->SetCellValue('W'.$coo, checkemptydash($row['po_num']))
						->SetCellValue('X'.$coo, checkemptydash($row['po_number']))
						->SetCellValue('Y'.$coo, php_excel_date($row['po_date']))
						->SetCellValue('Z'.$coo, checkemptydash(alias($row['site_type_alias'],'ec_site_type','site_type_alias','site_type')))
						->SetCellValue('AA'.$coo, ($row['warranty']>0 ? 'UNDER WARRANTY' : 'OUT OF WARRANTY'))
						//->SetCellValue('AB'.$coo, checkemptydash($row['efsr_no']))
						->setCellValueExplicit('AB'.$coo, checkemptydash($row['efsr_no']),PHPExcel_Cell_DataType::TYPE_STRING)
						->SetCellValue('AC'.$coo, ($row['efsr_date']=="" ? "-" : php_excel_date($row['efsr_date'])))
						->SetCellValue('AD'.$coo, checkemptydash($faulty_code))
						->SetCellValue('AE'.$coo, ($row['closing_date']=="" || $row['level']<6 ? "-" : php_excel_date($row['closing_date'])))
						->SetCellValue('AF'.$coo, checkemptydash((!empty($row['tat']) ? $row['tat'] : tat($row['ticket_alias']))))
						->SetCellValue('AG'.$coo, visit_exp_count($ticket_id))
						->SetCellValue('AH'.$coo, checkemptydash(($row['level']=='1' || $row['level']=='2' || $row['level']=='4' || $row['level']=='5' ? repl_planfail_tsrej($row['level'],$row['old_level'],$row['planned_date'],$row['purpose'],'name'):alias($row['level'],'ec_levels','level_alias','level_name'))))
						->SetCellValue('AI'.$coo, checkemptydash($row['car_number']))
						->SetCellValue('AJ'.$coo, checkemptydash($row['line_number']))
						->SetCellValue('AK'.$coo, checkemptydash(alias($row['shift'],'ec_shift','shift_alias','shift_name')))
						->SetCellValue('AL'.$coo, checkemptydash(php_excel_date($row['date_of_assembly'])))
						->SetCellValue('AM'.$coo, checkemptydash(php_excel_date($row['date_of_jar_form'])))
						->setCellValueExplicit('AN'.$coo, checkemptydash($row['faulty_cell_num']),PHPExcel_Cell_DataType::TYPE_STRING)
						->SetCellValue('AO'.$coo, checkemptydash($row['tenth_hour']))
						->SetCellValue('AP'.$coo, checkemptydash($row['ocv']))
						->SetCellValue('AQ'.$coo, checkemptydash($row['corect_act_Plan']))
						->SetCellValue('AR'.$coo,checkemptydash($row['old_level']=='8' && $row['level']!='5' ? 'Rejected' : 'Approved'));
				$sqlRem = mysqli_query($mr_con,"SELECT remarks,bucket FROM ec_remarks WHERE item_alias='$ticket_alias' AND module='TT' AND bucket IN('12','13','31','32') AND flag=0");
				while($rowRem=mysqli_fetch_array($sqlRem)){
					$root_cause=($rowRem['bucket']=='12' || $rowRem['bucket']=='13' ? $rowRem['remarks'] : '-');
					$dis_rem=($rowRem['bucket']=='31' || $rowRem['bucket']=='32' ? $rowRem['remarks'] : '-');
				}
				$sql1=mysqli_query($mr_con,"SELECT GROUP_CONCAT(name) AS emp_name FROM ec_employee_master WHERE employee_alias IN ('".str_replace("|","','",$row['persons_notified'])."') AND flag='0'");
				$emp_row=mysqli_fetch_array($sql1);
				$sheet->SetCellValue('AS'.$coo, $root_cause)
						->SetCellValue('AT'.$coo, checkemptydash($emp_row['emp_name']))
						->SetCellValue('AU'.$coo, checkemptydash($row['deposition']))
						->SetCellValue('AV'.$coo, $dis_rem);
			}$no_rec++;
		}$sh_index++;
	}
	if($no_rec>0){
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save("../../exports/$filename.xlsx");
		$result['file_name']=$filename;
		$resCode='0'; $resMsg='export';
	}else{$resCode='4';$resMsg='No Records found to Run Report!';}
	}else{$resCode='4';$resMsg='Please Select the Datatype';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function dateranges($a,$b){
	$start=strtotime($a);
	$end=strtotime($b);
	$array=array();
	while($start <= $end){
		$array[]= date('m/y', $start);
		$start = strtotime("+1 month", $start);
	}
	return $array;
}
function ticket_adv_update(){ global $mr_con;
	$emp_alias=$_REQUEST['emp_alias']; $token=$_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		if(isset($_REQUEST['ticket_alias'])){ $con='';
			$ticket_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['ticket_alias']));
			$ticket_id=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['ticket_id'])));
			$login_date=mysqli_real_escape_string($mr_con,trim(dateTime($_REQUEST['login_date'])));
			$activation_date=mysqli_real_escape_string($mr_con,trim(dateFormat($_REQUEST['activation_date'],'y')));
			$planned_date=mysqli_real_escape_string($mr_con,trim(dateFormat($_REQUEST['planned_date'],'y')));
			$service_engineer_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['service_engineer_alias']));
			//$site_id=mysqli_real_escape_string($mr_con,trim($_REQUEST['site_id']));
			$efsr_no=mysqli_real_escape_string($mr_con,trim($_REQUEST['efsr_no']));
			$efsr_date=mysqli_real_escape_string($mr_con,trim(dateTime($_REQUEST['efsr_date'])));
			$activity_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['activity_alias']));
			$complaint_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['complaint_alias']));
			$faulty_cell_count=mysqli_real_escape_string($mr_con,trim($_REQUEST['faulty_cell_count']));
			$milestone=mysqli_real_escape_string($mr_con,trim($_REQUEST['milestone']));
			$payment_terms=mysqli_real_escape_string($mr_con,trim($_REQUEST['payment_terms']));
			$tktstatus=mysqli_real_escape_string($mr_con,trim($_REQUEST['tktstatus']));
			$description=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['description'])));
			$closing_date=mysqli_real_escape_string($mr_con,trim(dateTime($_REQUEST['closing_date'])));
			$tat=mysqli_real_escape_string($mr_con,trim($_REQUEST['tat']));
			$old_level=mysqli_real_escape_string($mr_con,trim($_REQUEST['old_level']));
			$level=mysqli_real_escape_string($mr_con,trim($_REQUEST['level']));
			$purpose=mysqli_real_escape_string($mr_con,trim($_REQUEST['purpose']));
			$mode_of_contact=mysqli_real_escape_string($mr_con,trim($_REQUEST['mode_of_contact']));
			$moc_file = TRUE; $efsr_file = TRUE;
			if($mode_of_contact=='FAX' || $mode_of_contact=='LETTER'){
				if(isset($_FILES['moc_file']) && !empty($_FILES['moc_file']['name'])){
					$link = upload_file($_FILES['moc_file'],'report','pdf');
					list($code,$msg) = explode(",",$link);
					if($code=='0'){ $contact_link = $msg;
						$con.=",contact_link='$contact_link'";
					}else{$res=$msg; $moc_file = FALSE;}
				}else{$res="Please choose Mode of contact file"; $moc_file = FALSE;}
			}
			if(isset($_FILES['esca_efsr_link']['name']) && !empty($_FILES['esca_efsr_link']['name'])){
				$link1 = upload_file($_FILES['esca_efsr_link'],'esca_efsr','pdf');
				list($code1,$msg1) = explode(",",$link1);
				if($code1=='0'){ $esca_efsr_link = $msg1;
					$con.=",esca_efsr_link='$esca_efsr_link'";
				}else{$res=$msg1; $efsr_file = FALSE;}
			}
			if(empty($ticket_id)){$res = "Ticket ID Should Not Be Empty";}
			elseif(empty($login_date)){$res = "Login Date Should Not Be Empty";}
			elseif(empty($activity_alias)){$res = "Activity Should Not Be Empty";}
			elseif(empty($complaint_alias)){$res = "Complaint Should Not Be Empty";}
			elseif($faulty_cell_count==""){$res = "Faulty Cell Count Should Not Be Empty";}
			elseif(empty($tktstatus)){$res = "Ticket Status Should Not Be Empty";}
			elseif(empty($description)){$res = "Description Should Not Be Empty";}
			elseif($old_level==""){$res = "Old Level Should Not Be Empty";}
			elseif($level==""){$res = "Level Should Not Be Empty";}
			elseif($purpose==""){$res = "Purpose Should Not Be Empty";}
			elseif(empty($mode_of_contact)){$res = "Mode Of Contact Should Not Be Empty";}
			elseif(!$moc_file){$res = $msg;}
			elseif(!$efsr_file){$res = $msg1;}
			else{
				$con_ser=(!empty($service_engineer_alias) ? "service_engineer_alias='$service_engineer_alias'," : "" );
				$sqlTT = mysqli_query($mr_con,"UPDATE ec_tickets SET ticket_id='$ticket_id',login_date='$login_date',activation_date='$activation_date',planned_date='$planned_date',$con_ser efsr_no='$efsr_no',efsr_date='$efsr_date',activity_alias='$activity_alias',complaint_alias='$complaint_alias',faulty_cell_count='$faulty_cell_count',milestone='$milestone',payment_terms='$payment_terms',status='$tktstatus',description='$description',closing_date='$closing_date',tat='$tat',old_level='$old_level',level='$level',purpose='$purpose',mode_of_contact='$mode_of_contact' $con WHERE ticket_alias='$ticket_alias' AND flag=0");
				//Remarks
				for($i=0;$i<count($_REQUEST['remark_alias']);$i++){
					$remarkedby[$i]=mysqli_real_escape_string($mr_con,trim($_REQUEST['remarkedby'][$i]));
					$con_rem=(!empty($remarkedby[$i]) ? "remarked_by='$remarkedby[$i]'," : "" );
					$remarkedon[$i]=mysqli_real_escape_string($mr_con,trim(dateTime($_REQUEST['remarkedon'][$i])));
					$remark[$i]=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remark'][$i])));
					$remark_alias[$i]=mysqli_real_escape_string($mr_con,trim($_REQUEST['remark_alias'][$i]));
					if(!empty($remarkedby[$i]) && !empty($remarkedon[$i]) && !empty($remark[$i])){
						$sqlRem = mysqli_query($mr_con,"UPDATE ec_remarks SET remarks='$remark[$i]',$con_rem remarked_on='$remarkedon[$i]' WHERE remark_alias='$remark_alias[$i]' AND flag=0");
					}
				}
				//Action Taken
				for($i=0;$i<count($_REQUEST['action_alias']);$i++){
					$observation[$i]=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['observation'][$i])));
					$action_alias[$i]=mysqli_real_escape_string($mr_con,trim($_REQUEST['action_alias'][$i]));
					$sqlAct = mysqli_query($mr_con,"UPDATE ec_ticket_action SET observation='$observation[$i]' WHERE item_alias='$action_alias[$i]' AND flag=0");
				}
				//Cell Required
				for($j=0;$j<count($_REQUEST['item_alias']);$j++){
					$item_code[$j]=mysqli_real_escape_string($mr_con,trim($_REQUEST['item_code'][$j]));
					$quantity[$j]=mysqli_real_escape_string($mr_con,trim($_REQUEST['quantity'][$j]));
					$req_cell_status[$j]=mysqli_real_escape_string($mr_con,trim($_REQUEST['req_cell_status'][$j]));
					$approved_by[$j]=mysqli_real_escape_string($mr_con,trim($_REQUEST['approved_by'][$j]));
					$approved_on[$j]=mysqli_real_escape_string($mr_con,trim(dateFormat($_REQUEST['approved_on'][$j],'y')));
					$item_alias[$j]=mysqli_real_escape_string($mr_con,trim($_REQUEST['item_alias'][$j]));
					if(!empty($item_code[$j]) && !empty($quantity[$j])){
						$sqlReq = mysqli_query($mr_con,"UPDATE ec_cell_required SET cell_alias='$item_code[$j]', quanty='$quantity[$j]', approved_stat='$req_cell_status[$j]',approved_by='$approved_by[$j]',approved_on='$approved_on[$j]' WHERE item_alias='$item_alias[$j]' AND flag=0");
					}
				}
				if($sqlTT){
					$resCode='0'; $resMsg='Successfully Updated';
					$action=$ticket_id." Ticket Advance Edited";
					user_history($emp_alias,$action,$_REQUEST['ip_addr']);
				}else{$res='Not Updated, Please Try Again';}
			}
		}else{$res='Sorry, Not Updated';}
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}if(isset($res)){$resCode='4'; $resMsg=$res;}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function ticket_update(){ 
	global $mr_con;
	$emp_alias=$_REQUEST['emp_alias']; $token=$_REQUEST['token'];
	if(isset($_REQUEST['ticket_alias'])){$ticket_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['ticket_alias']));}
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$site_alias=alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
		$level = alias($ticket_alias,'ec_tickets','ticket_alias','level');
		switch($level){
			case '0': $final = ticket_0to1_update($ticket_alias,$emp_alias,iss($_REQUEST['online_tickets'])); break;
			case '1': $final = ticket_1to2_update($ticket_alias,$emp_alias,iss(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks']))),iss(mysqli_real_escape_string($mr_con,trim($_REQUEST['cell_remarks']))),iss($_REQUEST['general']),iss($_REQUEST['item_code']),iss($_REQUEST['quantity']),iss($_REQUEST['acc_code']),iss($_REQUEST['acc_quantity']),iss($_FILES['cust_file']),dateFormat(iss($_REQUEST['planned_date']),'y'),iss($_REQUEST['service_engineer_alias']),iss($_REQUEST['outward'])); break;
			case '2': $final = ticket_2to3_update($ticket_alias,$emp_alias,iss(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks']))),iss($_REQUEST['esca_action']),iss($_REQUEST['item_code']),iss($_REQUEST['quantity']),dateFormat(iss($_REQUEST['planned_date']),'y'),iss($_REQUEST['service_engineer_alias']),iss($_REQUEST['onrole']),iss($_REQUEST['escarole']),iss($_REQUEST['faulty_code']),iss($_REQUEST['faulty_aval']),iss($_REQUEST['mfg_date']),iss($_REQUEST['faulty_cell_no']),iss($_REQUEST['action_taken']),iss($_REQUEST['fsr_number']),dateFormat($_REQUEST['fsr_date'],'y'),dateFormat($_REQUEST['mfd_date'],'y'),dateFormat($_REQUEST['install_date'],'y'),iss($_REQUEST['job_perform']),iss($_REQUEST['acc_code']),iss($_REQUEST['acc_quantity']),iss($_FILES['efsr_file']),iss($_FILES['cust_file']),iss($_REQUEST['replaced_cell_no'])); break;
			case '3': $final = ticket_3to4_update($ticket_alias,$emp_alias,iss(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks']))),iss($_REQUEST['milestone']),iss($_REQUEST['payment_terms']),iss($_REQUEST['zonal_action']),iss($_REQUEST['item_code']),iss($_REQUEST['quantity']),iss($_REQUEST['acc_code']),iss($_REQUEST['acc_quantity']),iss($_FILES['cust_file'])); break;
			case '4': $final = ticket_4to5_update($ticket_alias,$emp_alias,iss($_REQUEST['nhs_action']),iss(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])))); break;
			case '8': $final = ticket_8to5_update($ticket_alias,$emp_alias,iss($_REQUEST['app_quantity']),iss($_REQUEST['item_alias']),iss($_REQUEST['ths_action']),iss($_REQUEST['line_number']),iss($_REQUEST['shift']),dateFormat(iss($_REQUEST['date_of_assembly']),'y'),dateFormat(iss($_REQUEST['date_of_jar_form']),'y'),iss($_REQUEST['corect_act_Plan']),iss($_REQUEST['persons_notified']),iss($_REQUEST['faulty_cell_num']),iss($_REQUEST['ocv_at_dispatch']),iss($_REQUEST['tenth_hour']),iss($_REQUEST['remarks']),iss($_REQUEST['deposition']),iss($_REQUEST['prevent_recurrence']),iss($_REQUEST['cell_type_chk']));break;
			case '5':
			case '6':
			case '7': $final = ticket_5to6_update($ticket_alias,$emp_alias,iss($_REQUEST['deposition']),iss($_REQUEST['prevent_recurrence'])); break;
			default: $final = "4,Error In Updating";
		}
		list($resCode,$resMsg) = explode(",",$final);
		//$resCode=$final[0]; $resMsg=$final[1];
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function ticket_0to1_update($ticket_alias,$emp_alias,$reject){ global $mr_con;
	if(!isset($reject) || $reject==''){$res="Select approval";}
	else{
		$site_alias=alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
		if($reject=="1"){ //accept
			$sql = mysqli_query($mr_con,"SELECT state_alias FROM ec_sitemaster WHERE site_alias='$site_alias'");
			$row = mysqli_fetch_array($sql);
			$state_code = alias($row['state_alias'],'ec_state','state_alias','state_code');
			$old_tkt_id=alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
			$ticket_id = ticketsID($site_alias,$state_code,1);
			$sqlTT = mysqli_query($mr_con,"UPDATE ec_tickets SET ticket_id='$ticket_id',level='1',old_level='0',transaction_date='".date('Y-m-d')."' WHERE ticket_alias='$ticket_alias' AND level='0' AND flag=0");
			$sqlSite = mysqli_query($mr_con,"UPDATE ec_sitemaster SET flag='0' WHERE site_alias='$site_alias' AND flag='1'");
			$action="The Ticket $old_tkt_id was approved by ".alias($emp_alias,'ec_employee_master','employee_alias','name')." which is generated by Customer., New generated ticket is $ticket_id";
		}else{ //reject
			$sqlTT = mysqli_query($mr_con,"DELETE FROM ec_tickets WHERE ticket_alias='$ticket_alias' AND level='0' AND flag='0'");
			$sqlSite = mysqli_query($mr_con,"DELETE FROM ec_sitemaster WHERE site_alias='$site_alias' AND flag='1'");
			$action="The Ticket $old_tkt_id was Rejected by ".alias($emp_alias,'ec_employee_master','employee_alias','name')." which is generated by Customer.";
		}
		if($sqlTT && $sqlSite){
			ticket_notification($ticket_alias,$action);
			user_history($emp_alias,$action,$_REQUEST['ip_addr']);
			$result="0,Successful!";
		}else{$res="Error In Updating";}
	}if(isset($res)){$result="4,$res";}
	return $result;
}
function ticket_1to2_update($ticket_alias,$emp_alias,$remarks,$cell_remarks,$general,$cell_alias,$quanty,$acc_alias,$acc_qty,$cust_file,$planned_date,$service_engineer_alias,$outward){ 
	global $mr_con;
	$ticket_id=alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
	if($general=="1"){ //cell required
		$cell_alias_fil=array_filter($cell_alias);
		$acc_alias_fil=array_filter($acc_alias);
		$quanty_fil=array_filter($quanty);
		$acc_qty_fil=array_filter($acc_qty);
		
		$cell_count=count($cell_alias_fil);
		$acc_count=count($acc_alias_fil);
		$cell_qty=count($quanty_fil);
		$acc_qty=count($acc_qty_fil);
		
		if($cell_count==0 && $acc_count==0){$res="Select Cells Or Accessories";}
		//elseif($cell_count<$cell_qty){$res="Select all Cells";}
		//elseif($cell_count>$cell_qty){$res="Enter all Cells Quantity";}
		elseif($acc_count<$acc_qty){$res="Select all Accessories";}
		elseif($acc_count>$acc_qty){$res="Enter all Accessories Quantity";}
		elseif(empty($cell_remarks)){$res="Enter Remarks";}
		else{$cc=$ac=1; $cust_er=TRUE;
			$cell_remarks=mysqli_real_escape_string($mr_con,$cell_remarks);
			if(isset($cust_file) && !empty($cust_file['name'])){
				$link = upload_file($cust_file,'other_report','pdf');
				list($code,$msg) = explode(",",$link);
				//$code='0';$msg='test.pdf';
				if($code=='0'){ $cust_file = $msg;
					$con=",cust_file='$cust_file'";
				}else{$res=$msg; $cust_er = FALSE;}
			}
			if($cust_er){
				for($i=0;$i<$cell_count;$i++){
					$alias=aliasCheck(generateRandomString(),'ec_cell_required','item_alias');
					$ce_alias=trim($cell_alias_fil[$i]);
					$quant=trim($quanty_fil[$i]);
					$sqlReq = mysqli_query($mr_con,"INSERT INTO ec_cell_required(ticket_alias,item_type,cell_alias,quanty,item_alias)VALUES('$ticket_alias','1','$ce_alias','$quant','$alias')");
					$cc++;
				}
				for($i=0;$i<$acc_count;$i++){
					$alias=aliasCheck(generateRandomString(),'ec_cell_required','item_alias');
					$ac_alias=trim($acc_alias_fil[$i]);
					$ac_quant=trim($acc_qty_fil[$i]);
					$sqlReq = mysqli_query($mr_con,"INSERT INTO ec_cell_required(ticket_alias,item_type,cell_alias,quanty,item_alias)VALUES('$ticket_alias','2','$ac_alias','$ac_quant','$alias')");
					$ac++;
				}
				$sub_msg=($cc>1 ? "Cells":"").($cc>1&&$ac>1 ? " and ":"").($ac>1 ? "Accessories":"");
				$sqlTT = mysqli_query($mr_con,"UPDATE ec_tickets SET level='8', old_level='1', activation_date='".date("Y-m-d")."',transaction_date='".date('Y-m-d')."' $con WHERE ticket_alias='$ticket_alias' AND flag=0");
				
				$rem_alias=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
				$sqlRem = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$cell_remarks','TT','5','$ticket_alias','$emp_alias','$rem_alias')");
				$action = "Ticket ID $ticket_id was sent for required $sub_msg to TS approval";
				if($sqlTT && $sqlRem){
					$fam_msg="Dear Team, request send for Technical Services verification of TT Number $ticket_id, Kindly verify and close the request";
					$site_alias=alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
					$state_alias=alias($site_alias,'ec_sitemaster','site_alias','state_alias');
					ecSendSms('ts_verification', $state_alias, "", $fam_msg);
					/*
					foreach(sms_contacts($ticket_alias,array("TS","HO")) as $phnum)messageSent($phnum,$fam_msg);
					*/
					ticket_notification($ticket_alias,$action);
					user_history($emp_alias,$action,$_REQUEST['ip_addr']);
					$result="0,Successful!";
				}else{$res="Error In Updating";}
			}
		}
	}elseif($general=="0"){ //general
		if($outward=='1')$res="Planning not allowed untill material outward is done against this TT Number";
		elseif(empty($planned_date))$res="Choose Planned Date";
		elseif(empty($service_engineer_alias))$res="Select Service Engineer";
		else{
			$sqlTT = mysqli_query($mr_con,"UPDATE ec_tickets SET planned_date='$planned_date', service_engineer_alias='$service_engineer_alias', level='2', old_level='1', activation_date='".date("Y-m-d")."',transaction_date='".date('Y-m-d')."' WHERE ticket_alias='$ticket_alias' AND flag=0");
			if($sqlTT){
				$action = "Ticket ".$ticket_id." assign planned date to SE-".alias($service_engineer_alias,'ec_employee_master','employee_alias','name');
				user_history($emp_alias,$action,$_REQUEST['ip_addr']);
				$dpr_up=mysqli_query($mr_con,"UPDATE ec_app_update_status SET dpr_drops='1' WHERE employee_alias='$service_engineer_alias' AND flag=0");
				$site_alias=alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
				$custNum=alias_flag_none($site_alias,'ec_sitemaster','site_alias','technician_number');
				$serNum=alias($service_engineer_alias,'ec_employee_master','employee_alias','mobile_number');
				$serMsg="Dear Team, against Ticket No-".$ticket_id." (Customer Mob-".$custNum.") allotted for site visit on dated ".$planned_date.". Plan accordingly.";
				//$custMsg="Dear Customer against your Ticket No-".$ticket_id.", SE-is allotted for site visit, Mob-".$serNum.", on dated ".$planned_date." Pls available.";
				$custMsg="DEAR CUSTOMER AGAINST YOUR TICKET NO-".$ticket_id.", EnerSys SE-IS ALLOTTED FOR SITE VISIT, MOB-".$serNum.", ON DATED ".$planned_date." PLS AVAILABLE.";
				
				/*
				messageSent($custNum,$custMsg);
				*/
				$state_alias = alias($site_alias,'ec_sitemaster','site_alias','state_alias');
				ecSendSms('tt_activation', $state_alias, $custNum, $custMsg);
				ecSendSms('tt_reactivation_new_service_engineer', $state_alias, $serNum, $serMsg);
				//$esca_check = alias($service_engineer_alias,'ec_employee_master','employee_alias','role_alias');
				//if($esca_check!='01ZMYJ4OLG'){
					//$reg_id=alias($service_engineer_alias,'ec_employee_master','employee_alias','reg_id');
					$purpose=alias($ticket_alias,'ec_tickets','ticket_alias','purpose');
					$pur=(empty($purpose) ? 'Site visit' : 'Replacement');
					$activity_code=alias(alias($ticket_alias,'ec_tickets','ticket_alias','activity_alias'),'ec_activity','activity_alias','activity_code');
					$mess="Ticket No-".$ticket_id." against the Activity $activity_code of Site name-".alias_flag_none($site_alias,'ec_sitemaster','site_alias','site_name')." is Assigned for $pur on Dated ".$planned_date.". Plan accordingly.";
					ticket_notification($ticket_alias,$mess);
					//notification($reg_id,$mess);
					/*
					messageSent($serNum,$serMsg);
					*/
				//}
				//event starts
				$created_on = date('Y-m-d');
				$scheduled_on = date('Y-m-d 9:00:00', strtotime($planned_date));
				/*$state_alias =alias($service_engineer_alias,'ec_employee_master','employee_alias','state_alias');
				if(!empty($state_alias)){
					$sqlEsca = mysqli_query($mr_con,"SELECT employee_alias FROM ec_employee_master WHERE privilege_alias='OX5E3EMI0U' AND state_alias RLIKE '".str_replace(", ","|",$state_alias)."' AND flag='0'");
					if(mysqli_num_rows($sqlEsca)>0){
						$rowesca=mysqli_fetch_array($sqlEsca);
						$zhs_alias= $rowesca['employee_alias'];
					}else{ $zhs_alias= "";}
				}else{ $zhs_alias= "";}*/
				$se_item_alias = aliasCheck(generateRandomString(),'ec_calender_event','alias');
				$sql_se = mysqli_query($mr_con,"INSERT INTO ec_calender_event(event_type,event_alias,created_on,scheduled_on,emp_alias,alias)VALUES('1','$ticket_alias','$created_on','$scheduled_on','$service_engineer_alias','$se_item_alias')");
				/*$zhs_item_alias = aliasCheck(generateRandomString(),'ec_calender_event','alias');
				$sql_zhs = mysqli_query($mr_con,"INSERT INTO ec_calender_event(event_type,event_alias,created_on,scheduled_on,emp_alias,alias)VALUES('1','$ticket_alias','$created_on','$scheduled_on','$zhs_alias','$zhs_item_alias')");*/
				//if($sql_se && $sql_zhs){ $resCode='0'; $resMsg="Successful";}else{ $resCode='-5'; $resMsg="Your request is not Submitted"; }
				//event ends
				$result="0,Successful!";
			}else{$res="Error In Updating";}
		}
	}else{//Declined
		if(empty($remarks)){$res="Enter Remark";}
		else{
			$remarks=mysqli_real_escape_string($mr_con,$remarks);
			$site_alias=alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
			$custNum=alias_flag_none($site_alias,'ec_sitemaster','site_alias','technician_number');
			$custMsg="Dear Customer your Ticket No-".$ticket_id." is declined on Dt-".date("Y-m-d h:i:s A").".For feedback contact 040-67046704 For more details please check  your e-mail.";
			
			$serNum=alias($service_engineer_alias,'ec_employee_master','employee_alias','mobile_number');
			$serMsg="Dear Team, Your site with Ticket No-".$ticket_id." is declined on Dt-".date("Y-m-d h:i:s A")." which allotted for site visit on dated ".$planned_date.".";
				
			$sqlTT = mysqli_query($mr_con,"UPDATE ec_tickets SET level='6', old_level='1', status='DECLINED', closing_date='".date("Y-m-d H:i:s")."', tat='".tat($ticket_alias)."',transaction_date='".date('Y-m-d')."' WHERE ticket_alias='$ticket_alias' AND flag=0");
			$alias=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
			$sqlRem = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','TT','40','$ticket_alias','$emp_alias','$alias')");
			if($sqlTT && $sqlRem){
				$sub_con="level='6', old_level='1', status='DECLINED',closing_date='".date("Y-m-d H:i:s")."', tat='".tat($ticket_alias)."'";
				sub_tickets_close_decline($ticket_alias,$sub_con);
				$action="Ticket No - $ticket_id against the Activity ".alias(alias($ticket_alias,"ec_tickets","ticket_alias","activity_alias"),"ec_activity","activity_alias","activity_name")." of Site name-".alias($site_alias,"ec_sitemaster","site_alias","site_name")." is DECLINED on Dt-".date("Y-m-d H:i:s").".";
				user_history($emp_alias,$action,$_REQUEST['ip_addr']);
				ticket_notification($ticket_alias,$action);
				/*
				if(!empty($custNum)){messageSent($custNum,$custMsg);}
				*/
				if(!empty($serNum)){messageSent($serNum,$serMsg);}
				$state_alias=alias($site_alias,'ec_sitemaster','site_alias','state_alias');
				ecSendSms('ticket_declined', $state_alias, $custNum, $custMsg);
				$xx=localURL()."services/tickets/mails/ticket_declined_mail?ticket_alias=".$ticket_alias;
				curlxing($xx);
				$result="0,Successful!";
			}else{$res="Error In Updating";}
		}
	}if(isset($res)){$result="4,$res";}
	return $result;
}
function ticket_2to3_update($ticket_alias,$emp_alias,$remarks,$esca_action,$cell_alias,$quanty,$planned_date,$service_engineer_alias,$onrole,$escarole,$faulty_code_alias,$faulty_aval,$mfg_date,$faulty_cell_no,$action_taken,$fsr_number,$fsr_date,$mfd_date,$install_date,$job_perform,$acc_code,$acc_quantity,$efsr_file,$cust_file,$replaced_cell_no){ global $mr_con;
	$ticket_id=alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
	if($onrole){
		if($esca_action=="1"){ //cell required
			$cell_alias_fil=array_filter($cell_alias);
			$acc_code_fil=array_filter($acc_code);
			$quanty_fil=array_filter($quanty);
			$acc_quantity_fil=array_filter($acc_quantity);
			
			$cell_count=count($cell_alias_fil);
			$acc_count=count($acc_code_fil);
			$cell_qty=count($quanty_fil);
			$acc_qty=count($acc_quantity_fil);
			
			if(empty($remarks)){$res="Enter Remarks";}
			elseif($cell_count==0 && $acc_count==0){$res="Select Cells Or Accessories";}
			//elseif($cell_count<$cell_qty){$res="Select all Cells";}
			//elseif($cell_count>$cell_qty){$res="Enter all Cells Quantity";}
			elseif($acc_count<$acc_qty){$res="Select all Accessories";}
			elseif($acc_count>$acc_qty){$res="Enter all Accessories Quantity";}
			else{$cc=$ac=1; $cust_er=TRUE;
				$remarks=mysqli_real_escape_string($mr_con,$remarks);
				if(isset($cust_file) && !empty($cust_file['name'])){
					$link = upload_file($cust_file,'other_report','pdf');
					list($code,$msg) = explode(",",$link);
					if($code=='0'){ $cust_file = $msg;
						$con=",cust_file='$cust_file'";
					}else{$res=$msg; $cust_er = FALSE;}
				}
				if($cust_er){
					for($i=0;$i<$cell_count;$i++){
						$alias=aliasCheck(generateRandomString(),'ec_cell_required','item_alias');
						$ce_alias=trim($cell_alias_fil[$i]);
						$quant=trim($quanty_fil[$i]);
						$sqlReq = mysqli_query($mr_con,"INSERT INTO ec_cell_required(ticket_alias,item_type,cell_alias,quanty,item_alias)VALUES('$ticket_alias','1','$ce_alias','$quant','$alias')");
						$cc++;
					}
					for($i=0;$i<$acc_count;$i++){
						$alias=aliasCheck(generateRandomString(),'ec_cell_required','item_alias');
						$ac_alias=trim($acc_code_fil[$i]);
						$ac_quant=trim($acc_quantity_fil[$i]);
						$sqlReq = mysqli_query($mr_con,"INSERT INTO ec_cell_required(ticket_alias,item_type,cell_alias,quanty,item_alias)VALUES('$ticket_alias','2','$ac_alias','$ac_quant','$alias')");
						$ac++;
					}
					$remalias=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
					$sqlRem = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','TT','5','$ticket_alias','$emp_alias','$remalias')");
					
					$sub_msg=($cc>1 ? "Cells":"").($cc>1&&$ac>1 ? " and ":"").($ac>1 ? "Accessories":"");
					$sqlTT = mysqli_query($mr_con,"UPDATE ec_tickets SET level='8', old_level='1', activation_date='".date("Y-m-d")."',transaction_date='".date('Y-m-d')."' $con WHERE ticket_alias='$ticket_alias' AND flag=0");
					$action = "Ticket ID $ticket_id was sent for required $sub_msg to TS approval";
					if($sqlTT && $sqlReq){
						$fam_msg="Dear Team, request send for Technical Services verification of TT Number $ticket_id, Kindly verify and close the request";
						$site_alias=alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
						$state_alias=alias($site_alias,'ec_sitemaster','site_alias','state_alias');
						ecSendSms('ts_verification', $state_alias, "", $fam_msg);
						/*
						foreach(sms_contacts($ticket_alias,array("TS","HO")) as $phnum)messageSent($phnum,$fam_msg);
						*/
						user_history($emp_alias,$action,$_REQUEST['ip_addr']);
						ticket_notification($ticket_alias,$action);
						$result="0,Successful!";}
					else{$res="Error In Updating";}
				}else{$result="4,$res";}
			}
			
		}elseif($esca_action=="0"){ //general
			if(empty($planned_date)){$res="Choose Planned Date";}
			elseif(empty($service_engineer_alias)){$res="Select Service Engineer";}
			elseif(empty($remarks)){$res="Enter Remarks";}
			else{ // ESCA re-assigning the service engineer
				$remarks=mysqli_real_escape_string($mr_con,$remarks);
				$old_service_engineer_alias = alias($ticket_alias,'ec_tickets','ticket_alias','service_engineer_alias');
				$old_planned_date = alias($ticket_alias,'ec_tickets','ticket_alias','planned_date');
				$alias=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
				$sqlRem = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','TT','6','$ticket_alias','$emp_alias','$alias')");
				if($sqlRem){
					$planned_remarks = $old_planned_date."|".$old_service_engineer_alias."|".$alias;
					$pr_check = alias($ticket_alias,'ec_tickets','ticket_alias','planned_remarks');
					if(!empty($pr_check)){ $planned_remarks = $pr_check.", ".$planned_remarks; }
					$sqlTT = mysqli_query($mr_con,"UPDATE ec_tickets SET planned_date='$planned_date', service_engineer_alias='$service_engineer_alias', planned_remarks='$planned_remarks',transaction_date='".date('Y-m-d')."' WHERE ticket_alias='$ticket_alias' AND flag=0");
					if($sqlTT){
						$action = "Ticket ".$ticket_id." Re assign planned date to SE-".alias($service_engineer_alias,'ec_employee_master','employee_alias','name');
						user_history($emp_alias,$action,$_REQUEST['ip_addr']);
						$dpr_up=mysqli_query($mr_con,"UPDATE ec_app_update_status SET dpr_drops='1' WHERE employee_alias='$service_engineer_alias' AND flag=0");
						// Notification starts
						$activity_name=alias(alias($ticket_alias,'ec_tickets','ticket_alias','activity_alias'),'ec_activity','activity_alias','activity_code');
						$site_name=alias_flag_none(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','site_name');
						//$old_reg_id=alias($old_service_engineer_alias,'ec_employee_master','employee_alias','reg_id');
						//$old_msg="Ticket No-".$ticket_id." against the Activity ".$activity_name." of Site name-".$site_name." has been assigned to other service engineer.";
						//notification($old_reg_id,$old_msg);
						//$reg_id=alias($service_engineer_alias,'ec_employee_master','employee_alias','reg_id');
						$mess="Ticket No-".$ticket_id." against the Activity ".$activity_name." of Site name-".$site_name." is Replanned for $purpose on Dated ".$planned_date.". Plan accordingly.";
						//notification($reg_id,$mess);
						ticket_notification($ticket_alias,$mess);
						// Notification ends
						// SMS starts
						$serNum=alias($service_engineer_alias,'ec_employee_master','employee_alias','mobile_number');
						$custNum=alias(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','technician_number');
						//$custMsg="Dear Customer we regret for the inconvenience caused, against your Ticket No-".$ticket_id.", SE-is re planned for site visit, Mob-".$serNum.", on dated ".$planned_date.". Pls available.";
						$custMsg="DEAR CUSTOMER WE REGRET FOR THE INCONVENIENCE CAUSED , AGAINST YOUR TICKET NO-".$ticket_id.", EnerSys SE-IS RE PLANNED FOR SITE VISIT, MOB-".$serNum.", ON DATED ".$planned_date.". PLS AVAILABLE."
						
						/*
						messageSent($custNum,$custMsg);
						*/
						$site_alias=alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
						$state_alias=alias($site_alias,'ec_sitemaster','site_alias','state_alias');
						ecSendSms('tt_reactivation_customer', $state_alias, $custNum, $custMsg);
						if($old_service_engineer_alias==$service_engineer_alias){
							$serMsg="Dear Team, against Ticket No-".$ticket_id." (Customer Mob-".$custNum.") allotted for site visit is Re assigned to you on dated ".$planned_date.". Plan accordingly.";
							/*
							messageSent($serNum,$serMsg);
							*/
							$site_alias=alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
							$state_alias=alias($site_alias,'ec_sitemaster','site_alias','state_alias');
							ecSendSms('tt_reactivation_new_service_engineer', $state_alias, $serNum, $serMsg);
						}else{
							$oldSerNum=alias($old_service_engineer_alias,'ec_employee_master','employee_alias','mobile_number');
							$oldSerMsg="Dear Team, This is to inform you that Ticket No-".$ticket_id." (Customer Mob-".$custNum.") alloted for site visit on dated ".$planned_date." Is cancelled and assigend to other engineer";
							$serMsg="Dear Team, Re assigned Ticket No-".$ticket_id." (Customer Mob-".$custNum.") allotted for site visit on dated ".$planned_date.". Plan accordingly.";
							/*
							messageSent($oldSerNum,$oldSerMsg);
							messageSent($serNum,$serMsg);
							*/
							ecSendSms('tt_reactivation_old_service_engineer', $state_alias, $oldSerNum, $oldSerMsg);
							ecSendSms('tt_reactivation_new_service_engineer', $state_alias, $serNum, $serMsg);
						}
						// SMS ends
						//event starts
						$sql_up = mysqli_query($mr_con,"UPDATE ec_calender_event SET status = '1' WHERE event_type='1' AND event_alias='$ticket_alias'");
						$created_on = date('Y-m-d');
						$scheduled_on = date('Y-m-d 9:00:00', strtotime($planned_date));
						/*$state_alias =alias($service_engineer_alias,'ec_employee_master','employee_alias','state_alias');
						if(!empty($state_alias)){
							$sqlEsca = mysqli_query($mr_con,"SELECT employee_alias FROM ec_employee_master WHERE privilege_alias='OX5E3EMI0U' AND state_alias RLIKE '".str_replace(", ","|",$state_alias)."' AND flag='0'");
							if(mysqli_num_rows($sqlEsca)>0){
								$rowesca=mysqli_fetch_array($sqlEsca);
								$zhs_alias= $rowesca['employee_alias'];
							}else{ $zhs_alias= "";}
						}else{ $zhs_alias= "";}*/
						$se_item_alias = aliasCheck(generateRandomString(),'ec_calender_event','alias');
						$sql_se = mysqli_query($mr_con,"INSERT INTO ec_calender_event(event_type,event_alias,created_on,scheduled_on,emp_alias,alias,p_level)VALUES('1','$ticket_alias','$created_on','$scheduled_on','$service_engineer_alias','$se_item_alias','2')");
						/*$zhs_item_alias = aliasCheck(generateRandomString(),'ec_calender_event','alias');
						$sql_zhs = mysqli_query($mr_con,"INSERT INTO ec_calender_event(event_type,event_alias,created_on,scheduled_on,emp_alias,alias)VALUES('1','$ticket_alias','$created_on','$scheduled_on','$zhs_alias','$zhs_item_alias')");*/
						//if($sql_se && $sql_zhs){ $resCode='0'; $resMsg="Successful";}else{ $resCode='-5'; $resMsg="Your request is not Submitted"; }
						//event ends
						$result="0,Successful!";
					}else{$res="Error In Ticket Updating";}
				}else{$res="Error In Updating";}
			}
		}else{ //Declined
			if(empty($remarks)){$res="Enter Remark";}
			else{
				$remarks=mysqli_real_escape_string($mr_con,$remarks);
				$custNum=alias(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','technician_number');
				$declienedMsg="Dear Customer your Ticket No-".$ticket_id." is declined on Dt-".date("Y-m-d h:i:s A").".For feedback contact 040-67046704 For more details please check your e-mail";
				
				$serNum=alias($service_engineer_alias,'ec_employee_master','employee_alias','mobile_number');
				$serMsg="Dear Team, Your site with Ticket No-".$ticket_id." is declined on Dt-".date("Y-m-d h:i:s A")." which allotted for site visit on dated ".$planned_date.".";
				
				$sqlTT = mysqli_query($mr_con,"UPDATE ec_tickets SET level='6', old_level='2', status='DECLINED', closing_date='".date("Y-m-d H:i:s")."', tat='".tat($ticket_alias)."',transaction_date='".date('Y-m-d')."' WHERE ticket_alias='$ticket_alias' AND flag=0");
				$alias=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
				$sqlRem = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','TT','40','$ticket_alias','$emp_alias','$alias')");
				if($sqlTT && $sqlRem){
					$sub_con="level='6', old_level='1', status='DECLINED',closing_date='".date("Y-m-d H:i:s")."', tat='".tat($ticket_alias)."'";
					sub_tickets_close_decline($ticket_alias,$sub_con);
					$action="Ticket No - $ticket_id against the Activity ".alias(alias($ticket_alias,"ec_tickets","ticket_alias","activity_alias"),"ec_activity","activity_alias","activity_name")." of Site name-".alias(alias($ticket_alias,"ec_tickets","ticket_alias","site_alias"),"ec_sitemaster","site_alias","site_name")." is DECLINED on Dt-".date("Y-m-d H:i:s").".";
					user_history($emp_alias,$action,$_REQUEST['ip_addr']);
					ticket_notification($ticket_alias,$action);
					$site_alias=alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
					$state_alias=alias($site_alias,'ec_sitemaster','site_alias','state_alias');
					ecSendSms('ticket_declined', $state_alias, $custNum, $declienedMsg);
					messageSent($serNum,$serMsg);
					/*
					messageSent($custNum,$declienedMsg);
					*/
					//ticket_declined_mail($ticket_alias);
					$xx=baseurl()."services/tickets/mails/ticket_declined_mail?ticket_alias=".$ticket_alias;
					curlxing($xx);
					$result="0,Successful!";
				}else{$res="Error In Updating";}
			}
		}
	}elseif($escarole){
		$planned_date1=alias($ticket_alias,'ec_tickets','ticket_alias','planned_date');
		if(empty($job_perform)){$res="Select Job Perform";}
		elseif(empty($faulty_code_alias)){$res="Select Faulty Code";}
		elseif(empty($mfd_date) || $mfd_date=="NA"){$res="Choose Manufacturing Date";}
		elseif(empty($install_date) || $install_date=="NA"){$res="Choose Installation Date";}
		elseif(empty($fsr_date) || $fsr_date=="NA" || ($fsr_date<$planned_date1)){$res="Choose FSR date OR FSR date should greaterthan or equal to planned Date";}
		elseif(empty($fsr_number)){$res="Enter FSR Number";}
		elseif(empty($remarks)){$res="Enter Remarks";}
		elseif(empty($action_taken)){$res="Enter Action Taken";}
		elseif(empty($efsr_file['name'])){$res="Upload FSR Report";}
		elseif(empty($faulty_aval)){$res="Select faulty cell availability";}
		else{ $res1="";
			$remarks=mysqli_real_escape_string($mr_con,$remarks);
			if($faulty_aval=='2'){
				$fault_cell_count=count($faulty_cell_no);
				$mfg_date_count=count($mfg_date);
				if(empty($fault_cell_count) || count(array_filter($faulty_cell_no))!=$fault_cell_count){$res1="Enter Faulty Cell Sr. No.";}
				elseif($fault_cell_count != count(array_unique($faulty_cell_no))){$res1=implode(",",array_unique(array_diff($faulty_cell_no,array_unique($faulty_cell_no))))." are the duplicate Faulty Cell Sr. No.";}
				elseif(empty($mfg_date_count) || count(array_filter($mfg_date))!=$mfg_date_count){$res1="Enter Manufacturing Dates";}
				else $res1="";
			}else $faulty_cell_no=array();
			if(!empty($res1)){$res=$res1;}
			elseif(!isset($replaced_cell_no) || $replaced_cell_no[0]==''){$res="Select Replaced Cell Sr. No.";}
			elseif(!isset($cell_alias) || count($cell_alias) == '0'){$res="Select Required Cells";}
			elseif(!isset($quanty) || count($quanty) == '0'){$res="Select Required Cells Quantity";}
			//elseif(count($acc_code) == 0){$res="Select Required Accessories";}
			//elseif(count($acc_quantity) == 0){$res="Select Required Accessories Quantity";}
			else{
				if(count($replaced_cell_no)=='1' && $replaced_cell_no[0]=='0')$replaced_cell_no[0] = '';
				$fsr_sql = mysqli_query($mr_con,"SELECT id FROM ec_tickets WHERE efsr_no='$fsr_number' AND flag='0'");
				if(mysqli_num_rows($fsr_sql)=='0'){
					$link = upload_file($efsr_file,'esca_efsr','pdf');
					list($code,$msg) = explode(",",$link);
					if($code=='0'){
						$esca_alias = alias($ticket_alias,'ec_tickets','ticket_alias','service_engineer_alias');
						$man_date = $mfd_date;
						$inst_date = $install_date;
						$site_alias = alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
						$sql = mysqli_query($mr_con,"UPDATE ec_sitemaster SET mfd_date='$man_date', install_date='$inst_date' WHERE site_alias='$site_alias' AND flag=0");
						for($i=0;$i<count($cell_alias);$i++){
							$cell_alia=trim($cell_alias[$i]);
							$quant=trim($quanty[$i]);
							if(!empty($cell_alia) && !empty($quant)){
								$alias=aliasCheck(generateRandomString(),'ec_cell_required','item_alias');
								$sqlReq = mysqli_query($mr_con,"INSERT INTO ec_cell_required(ticket_alias,item_type,cell_alias,quanty,item_alias)VALUES('$ticket_alias','1','$cell_alia','$quant','$alias')");
								$req_cells .= alias($cell_alia,'ec_product','product_alias','battery_rating')."-(".$quant."), ";
							}
						}$total_faulty_count = array_sum($quanty);
						for($i=0;$i<count($acc_code);$i++){
							$acc_cod=trim($acc_code[$i]);
							$acc_quan=trim($acc_quantity[$i]);
							if(!empty($acc_cod) && !empty($acc_quan)){
								$alias=aliasCheck(generateRandomString(),'ec_cell_required','item_alias');
								$sqlReq = mysqli_query($mr_con,"INSERT INTO ec_cell_required(ticket_alias,item_type,cell_alias,quanty,item_alias)VALUES('$ticket_alias','2','$acc_cod','$acc_quan','$alias')");
								$req_acc .= alias($acc_cod,'ec_accessories','accessories_alias','accessory_description')."-(".$acc_quan."), ";
							}
						}
						$req_cells = rtrim($req_cells,", ");
						$req_acc = rtrim($req_acc,", ");
						date_default_timezone_set("Asia/Kolkata");
						$fsr_close_date = date("Y-m-d H:i:s");
						if(preg_match("/\d{4}\-\d{2}-\d{2}/", $fsr_date) || preg_match("/\d{2}\-\d{2}-\d{4}/", $fsr_date)){
							$dat = $fsr_date." ".date("H:i:s");
							if(strpos($dat,'1970')===false){$fsr_close_date = $dat;}
						}
						$faulty_cell_no1 = implode(", ",$faulty_cell_no);
						if($replaced_cell_no!="" && count($replaced_cell_no)>'0'){
							foreach($replaced_cell_no as $itm_combo){
								list($itm_alias,$itm_code)=explode("@",$itm_combo);
								$replaced_cell_no1[]=$itm_code;
								$replaced_cell_alias[]=$itm_alias;
							}
						}else $replaced_cell_no1=$replaced_cell_alias=array();
						//$replaced_cell_no1 = ($replaced_cell_no!="" ? implode(", ",$replaced_cell_no) : "");
						//$replaced_cell_no1 = str_replace(",",", ",str_replace(" ","",$replaced_cell_no));
						$engineer_alias = aliasCheck(generateRandomString(),'ec_engineer_observation','item_alias');
						$engineer_sql = mysqli_query($mr_con,"INSERT INTO ec_engineer_observation(ticket_alias,faulty_cell_sr_no,faulty_code_alias,replaced_cell_no,req_acc,req_cells,total_faulty_count,job_performed,item_alias)VALUES('$ticket_alias','$faulty_cell_no1','$faulty_code_alias','".implode(", ",$replaced_cell_no1)."','$req_acc','$req_cells','$total_faulty_count','$job_perform','$engineer_alias')");		
						for($i=0;$i<$fault_cell_count;$i++){
							$fal_alias = aliasCheck(generateRandomString(),'ec_fsr_faulty_cells','item_alias');
							$fal_sql = mysqli_query($mr_con,"INSERT INTO ec_fsr_faulty_cells(ticket_alias,cell_sl_no,mf_date,faulty_code_alias,item_alias,fsr_type)VALUES('$ticket_alias','".$faulty_cell_no[$i]."','".$mfg_date[$i]."','$faulty_code_alias','$fal_alias','0')");
						}
						$remark_alias = aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
						$remark_sql = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','TT','7','$ticket_alias','$esca_alias','$remark_alias')");
						$action_alias = aliasCheck(generateRandomString(),'ec_ticket_action','item_alias');
						$action_sql = mysqli_query($mr_con,"INSERT INTO ec_ticket_action(ticket_alias,observation,item_alias)VALUES('$ticket_alias','$action_taken','$action_alias')");
						$update = mysqli_query($mr_con,"UPDATE ec_tickets SET level='3',old_level='2',esca_efsr_link ='$msg',status='VISITED',closing_date='$fsr_close_date',efsr_no='$fsr_number',efsr_date='$fsr_close_date',transaction_date='".date('Y-m-d')."',n_visits=(n_visits+1) WHERE ticket_alias='$ticket_alias'");
						if($update){
							if(!empty($faulty_cell_no1))$acc_inv = mysqli_query($mr_con,"UPDATE ec_tickets_inventory SET material_inward='1' WHERE ticket_alias='$ticket_alias' AND flag='0'");
							
							// Material Outward level update and remaining replace cell get back to warehouse start
							$sqlou=mysqli_query($mr_con,"SELECT COUNT(t1.id) AS cnt,GROUP_CONCAT(DISTINCT t2.item_description) AS itm_cod_ali FROM ec_material_outward t1 INNER JOIN ec_material_sent_details t2 ON t1.alias=t2.reference WHERE t1.from_type='1' AND t1.to_wh<>'2609' AND t1.status<>'6' AND t1.ref_no='$ticket_alias' AND t1.flag='0'");
							$rowou=mysqli_fetch_array($sqlou);
							$tlt_arr=($rowou['cnt']>'0' ? explode(",",$rowou['itm_cod_ali']) : array());
							if(count($replaced_cell_alias)){
								$tlt_cl = mysqli_query($mr_con,"UPDATE ec_total_cell SET stage='0',site_stage='1' WHERE cell_alias IN('".implode("','",$replaced_cell_alias)."') AND flag='0'");
								foreach($replaced_cell_alias as $cel1)$hist_sql1 = mysqli_query($mr_con,"INSERT INTO ec_total_cell_history(cell_alias,message)VALUES('$cel1','Cell replaced at Site ".alias_flag_none(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','site_name')." against TT Number ".$ticket_id."')");
							}
							$remain_array = array_diff($tlt_arr,$replaced_cell_alias);
							if(count($remain_array)){
								$remain_sql = mysqli_query($mr_con,"UPDATE ec_total_cell SET location=old_location,location_type=old_location_type,old_location='".alias($ticket_alias,'ec_tickets','ticket_alias','site_alias')."',old_location_type='2',stage='0',transDate='".date('Y-m-d')."' WHERE cell_alias IN('".implode("','",$remain_array)."') AND flag='0'");
								$wh_code = alias(alias(end($remain_array),'ec_total_cell','cell_alias','location'),'ec_warehouse','wh_alias','wh_code');
								foreach($remain_array as $cel)$hist_sql = mysqli_query($mr_con,"INSERT INTO ec_total_cell_history(cell_alias,message)VALUES('$cel','Cell not utilized at site hence cell inward to warehouse : ".$wh_code."')");
							}
							$out_cl = mysqli_query($mr_con,"UPDATE ec_material_outward SET status='6' WHERE from_type='1' AND to_wh<>'2609' AND ref_no='$ticket_alias' AND flag='0'");
							// Material Outward level update and remaining replace cell get bcak to warehouse end

							$msgg="FSR of Ticket No-".$ticket_id." against the Activity ".alias(alias($ticket_alias,"ec_tickets","ticket_alias","activity_alias"),"ec_activity","activity_alias","activity_name")." of Site name-".alias(alias($ticket_alias,"ec_tickets","ticket_alias","site_alias"),"ec_sitemaster","site_alias","site_name")." awaiting for your Approval.";
							ticket_notification($ticket_alias,$msgg);
							$action = "Employee ".alias($emp_alias,'ec_employee_master','employee_alias','name')." Ticket ".$ticket_id." Sent to Zonal Due";
							user_history($emp_alias,$action,$_REQUEST['ip_addr']);
							$result="0,Successful!";
						}else{$res="Error In Updating";}
					}else{$res = $msg;}
				}else{$res = "The Given FSR Number already used, Please try with other FSR Number.";}
			}
		}
	}
	if(isset($res)){$result="4,$res";}
	return $result;
}
function ticket_3to4_update($ticket_alias,$emp_alias,$remarks,$milestone,$payment_terms,$zonal_action,$cell_alias,$quanty,$acc_alias,$acc_qty,$cust_file){ 
	global $mr_con;
	$purpose=alias($ticket_alias,'ec_tickets','ticket_alias','purpose');
	$ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
	if(empty($milestone)){$res="Select Milestone";}
	elseif($milestone!='NHNYJS67AT' && $purpose=='1'){$res="Milestone doesn't match visit type";}
	elseif(empty($payment_terms)){$res="Select eFSR Efficiency";}
	elseif(empty($zonal_action)){$res="Select Zonal Action";}
	elseif(empty($remarks)){$res="Enter Remark";}
	else{
		$res=$con=$cel_act="";  $cust_er=TRUE;
		if(isset($cust_file) && !empty($cust_file['name'])){
			$link = upload_file($cust_file,'other_report','pdf');
			list($code,$msg) = explode(",",$link);
			//$code='0';$msg='test.pdf';
			if($code=='0'){ $cust_file = $msg;
				$con=",cust_file='$cust_file'";
			}else{$res=$msg; $cust_er = FALSE;}
		}
		if($cust_er){
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
					else{$cc=$ac=1;
							for($i=0;$i<$cell_count;$i++){
								$alias=aliasCheck(generateRandomString(),'ec_cell_required','item_alias');
								$ce_alias=trim($cell_alias_fil[$i]);
								$quant=trim($quanty_fil[$i]);
								$sqlReq = mysqli_query($mr_con,"INSERT INTO ec_cell_required(ticket_alias,item_type,cell_alias,quanty,item_alias)VALUES('$ticket_alias','1','$ce_alias','$quant','$alias')");
								$cc++;
							}
							for($i=0;$i<$acc_count;$i++){
								$alias=aliasCheck(generateRandomString(),'ec_cell_required','item_alias');
								$ac_alias=trim($acc_alias_fil[$i]);
								$ac_quant=trim($acc_qty_fil[$i]);
								$sqlReq = mysqli_query($mr_con,"INSERT INTO ec_cell_required(ticket_alias,item_type,cell_alias,quanty,item_alias)VALUES('$ticket_alias','2','$ac_alias','$ac_quant','$alias')");
								$ac++;
							}
							if($cc>1 || $ac>1)$cel_act = " and Requiered".($cc>1 ? " Cells":"").($cc>1&&$ac>1 ? " and Requiered ":"").($ac>1 ? "Accessories":"")." added.";
						
					}
				}else $res="Required ".($cell_qty>0 ? "Cells":"").($cell_qty>0 && $acc_count>0 ? " and Required ":"").($acc_count>0 ? "Accessories":"")." not neccessory for ".($zonal_action=="1" ? 'CLOSED' : 'DECLINED')." Ticket.";
			}
		}
		//cell required end
		if(empty($res)){
			$site_alias=alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
			$state_alias=alias($site_alias,'ec_sitemaster','site_alias','state_alias');
			$remarks=mysqli_real_escape_string($mr_con,$remarks);
			$cl_date = alias($ticket_alias,'ec_tickets','ticket_alias','closing_date');
			$efsr_date = alias($ticket_alias,'ec_tickets','ticket_alias','efsr_date');
			$closing_date = (empty($cl_date) || $cl_date=='0000-00-00' ? $efsr_date : $cl_date);
			$custNum=alias($site_alias,'ec_sitemaster','site_alias','technician_number');
			$closedMsg="Dear Customer your Ticket No-".$ticket_id." is closed on Dt-".$closing_date.".For feedback contact 040-67046704 For more details please check your e-mail";
			$declienedMsg="Dear Customer your Ticket No-".$ticket_id." is declined on Dt-".$closing_date.".For feedback contact 040-67046704 For more details please check  your e-mail";
			
			if($zonal_action=="1"){ $bucket='1'; //Close Ticket
				$sub_con="level='7', old_level='3', status='CLOSED'";sub_tickets_close_decline($ticket_alias,$sub_con);$msg = $closedMsg; $action = "Ticket ".$ticket_id." Closed at zonal level";
				$acc = mysqli_query($mr_con,"UPDATE ec_cell_required SET approved_stat='6' WHERE ticket_alias='$ticket_alias' AND flag='0'");
				ecSendSms('ticket_closed', $state_alias, $custNum, $closedMsg);
			}
			elseif($zonal_action=="2"){ $bucket='2'; //BB Not Maintained Properly
				$sub_con="level='6', old_level='3', status='DECLINED'";sub_tickets_close_decline($ticket_alias,$sub_con);$msg = $declienedMsg;$action = "Ticket ".$ticket_id." Declined at zonal level";
				$acc = mysqli_query($mr_con,"UPDATE ec_cell_required SET approved_stat='6' WHERE ticket_alias='$ticket_alias' AND flag='0'");
				ecSendSms('ticket_declined', $state_alias, $custNum, $declienedMsg);
			}
			elseif($zonal_action=="3"){ 
				$bucket='9';$sub_con="level='4', old_level='3'";$msg = 'NA';$action = "Ticket ".$ticket_id." sent to NHS Approval Required";
			} //NHS Approval Required
			elseif($zonal_action=="4"){ $bucket='11'; //Next visit
				//$acc = mysqli_query($mr_con,"UPDATE ec_cell_required SET approved_stat='1', approved_by='$emp_alias', approved_on='".date('Y-m-d')."' WHERE ticket_alias='$ticket_alias' AND flag='0'");
				$sub_con="level='5', old_level='3', status='VISITED'"; subticket($ticket_alias,'0');$msg = 'NA'; $action = "Ticket ".$ticket_id." Zonal Approved and go to second visit";
			}
			$sqlreq = mysqli_query($mr_con,"SELECT id FROM ec_cell_required WHERE ticket_alias='$ticket_alias' AND quanty > '0' AND flag='0'");
			$rec_ca=mysqli_num_rows($sqlreq);
			if($zonal_action!="3" || ($zonal_action=="3" && $rec_ca > '0')){
				$rec_re=mysqli_num_rows(mysqli_query($mr_con,"SELECT id FROM ec_material_request WHERE ticket_alias='$ticket_alias' AND status != '5' AND status != '6' AND flag='0'"));
				$rec_out=mysqli_num_rows(mysqli_query($mr_con,"SELECT id FROM ec_material_outward WHERE ref_no='$ticket_alias' AND status != '6' AND flag='0'"));
				$rec_out2=mysqli_num_rows(mysqli_query($mr_con,"SELECT id FROM ec_material_outward WHERE ref_no='$ticket_alias' AND status = '6' AND flag='0'"));
				if($zonal_action>="1" || ($zonal_action<"3" && (($rec_re == '0' && $rec_out=='0') || ($rec_re > '0' && $rec_out2 > '0')))){
					$sqlTT = mysqli_query($mr_con,"UPDATE ec_tickets SET milestone='$milestone',payment_terms='$payment_terms',$sub_con,transaction_date='".date('Y-m-d')."' $con WHERE ticket_alias='$ticket_alias' AND flag=0");
					$alias=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
					$sqlRem = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','TT','$bucket','$ticket_alias','$emp_alias','$alias')");
					if($sqlTT && $sqlRem){
						if($zonal_action=="1"){
							$mess="Ticket No - $ticket_id against the Activity ".alias(alias($ticket_alias,"ec_tickets","ticket_alias","activity_alias"),"ec_activity","activity_alias","activity_name")." of Site name-".alias(alias($ticket_alias,"ec_tickets","ticket_alias","site_alias"),"ec_sitemaster","site_alias","site_name")." is CLOSED on Dt-".$closing_date.".";
							ticket_notification($ticket_alias,$mess);
							//zhs_nhs_close_mail($ticket_alias);
							$xx=baseurl()."services/tickets/mails/zhs_nhs_close_mail?ticket_alias=".$ticket_alias;
							curlxing($xx);
						}elseif($zonal_action=="2"){
							$mess="Ticket No - $ticket_id against the Activity ".alias(alias($ticket_alias,"ec_tickets","ticket_alias","activity_alias"),"ec_activity","activity_alias","activity_name")." of Site name-".alias(alias($ticket_alias,"ec_tickets","ticket_alias","site_alias"),"ec_sitemaster","site_alias","site_name")." is DECLINED on Dt-".$closing_date.".";
							ticket_notification($ticket_alias,$mess);
							//zhs_nhs_decline_mail($ticket_alias);
							$xx=baseurl()."services/tickets/mails/zhs_nhs_decline_mail?ticket_alias=".$ticket_alias;
							curlxing($xx);
						}elseif($zonal_action=="3"){
							$mess="Ticket No - $ticket_id against the Activity ".alias(alias($ticket_alias,"ec_tickets","ticket_alias","activity_alias"),"ec_activity","activity_alias","activity_name")." of Site name-".alias(alias($ticket_alias,"ec_tickets","ticket_alias","site_alias"),"ec_sitemaster","site_alias","site_name")." is Sent to NHS for Approval.";
							ticket_notification($ticket_alias,$mess);
						}elseif($zonal_action=="4")ticket_notification($ticket_alias,"Ticket No - $ticket_id against the Activity ".alias(alias($ticket_alias,"ec_tickets","ticket_alias","activity_alias"),"ec_activity","activity_alias","activity_name")." of Site name-".alias(alias($ticket_alias,"ec_tickets","ticket_alias","site_alias"),"ec_sitemaster","site_alias","site_name")." is next visit generated by ZHS");
						user_history($emp_alias,$action.$cel_act,$_REQUEST['ip_addr']);
						/*
						if($msg!='NA')messageSent($custNum,$msg);
						*/
						$result="0,Successful!";
					}else $res="Error In Updating";
				}
				else $res="Ticket should not Closed OR Declined until Material reached at site.";
			}
			else $res="There is No Required Cells OR Accessories to sent NHS approval";
		}
	}
	if(isset($res) && !empty($res)){$result="4,$res";}
	return $result;
}
function ticket_4to5_update($ticket_alias,$emp_alias,$nhs_action,$remarks){ global $mr_con;
	if(isset($remarks) && isset($nhs_action)){
		if(empty($nhs_action)){$res="Select NHS Action";}
		elseif(empty($remarks)){$res="Enter Remark";}
		else{
			$remarks=mysqli_real_escape_string($mr_con,$remarks);
			$ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
			$cl_date = alias($ticket_alias,'ec_tickets','ticket_alias','closing_date');
			$efsr_date = alias($ticket_alias,'ec_tickets','ticket_alias','efsr_date');
			$closing_date = (empty($cl_date) || $cl_date=='0000-00-00' ? $efsr_date : $cl_date);
			$site_alias=alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
			$state_alias=alias($site_alias,'ec_sitemaster','site_alias','state_alias');
			$custNum=alias($site_alias,'ec_sitemaster','site_alias','technician_number');
			$closedMsg="Dear Customer your Ticket No-".$ticket_id." is closed on Dt-".$closing_date.".For feedback contact 040-67046704 For more details please check your e-mail";
			$declienedMsg="Dear Customer your Ticket No-".$ticket_id." is declined on Dt-".$closing_date.".For feedback contact 040-67046704 For more details please check  your e-mail";
			if($nhs_action=="1"){ $bucket='38'; //Close Ticket
				$sub_con="level='7', old_level='4', status='CLOSED',";sub_tickets_close_decline($ticket_alias,$sub_con);$msg = $closedMsg; $action = "Ticket ".$ticket_id." Closed at NHS level";
				$acc = mysqli_query($mr_con,"UPDATE ec_cell_required SET approved_stat='6' WHERE ticket_alias='$ticket_alias' AND flag='0'");
				ecSendSms('ticket_closed', $state_alias, $custNum, $closedMsg);
			}
			elseif($nhs_action=="2"){ $bucket='39'; //BB Not Maintained Properly
				$sub_con="level='6', old_level='4', status='DECLINED',";sub_tickets_close_decline($ticket_alias,$sub_con);$msg = $declienedMsg;$action = "Ticket ".$ticket_id." Declined at NHS level";
				$acc = mysqli_query($mr_con,"UPDATE ec_cell_required SET approved_stat='6' WHERE ticket_alias='$ticket_alias' AND flag='0'");
				ecSendSms('ticket_declined', $state_alias, $custNum, $declienedMsg);
			} //TS Approval Required
			elseif($nhs_action=="3"){$bucket='10'; $sub_con="level='8', old_level='4',";$msg = 'NA';$action = "Ticket ".$ticket_id." NHS sent to TS Approval Required";}
			elseif($nhs_action=="4"){ $bucket='37'; //Next visit
				$sub_con="level='5', old_level='4', status='VISITED',"; subticket($ticket_alias,'0');$msg = 'NA'; $action = "Ticket ".$ticket_id." NHS Approved and go to second visit";
			}
			$sqlreq = mysqli_query($mr_con,"SELECT id FROM ec_cell_required WHERE ticket_alias='$ticket_alias' AND quanty > '0' AND flag='0'");
			$rec_ca=mysqli_num_rows($sqlreq);
			if($nhs_action!="3" || ($nhs_action=="3" && $rec_ca > '0')){
				$rec_re=mysqli_num_rows(mysqli_query($mr_con,"SELECT id FROM ec_material_request WHERE ticket_alias='$ticket_alias' AND status != '6' AND flag='0'"));
				$rec_out=mysqli_num_rows(mysqli_query($mr_con,"SELECT id FROM ec_material_outward WHERE ref_no='$ticket_alias' AND status != '6' AND flag='0'"));
				$rec_out2=mysqli_num_rows(mysqli_query($mr_con,"SELECT id FROM ec_material_outward WHERE ref_no='$ticket_alias' AND status = '6' AND flag='0'"));
				if($nhs_action>"2" || ($nhs_action<"3" && (($rec_re == '0' && $rec_out=='0') || ($rec_re > '0' && $rec_out2 > '0')))){
					$sqlTT = mysqli_query($mr_con,"UPDATE ec_tickets SET $sub_con transaction_date='".date('Y-m-d')."' WHERE ticket_alias='$ticket_alias' AND flag=0");
					$alias=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
					$sqlRem = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','TT','$bucket','$ticket_alias','$emp_alias','$alias')");
					if($sqlTT && $sqlRem){
						user_history($emp_alias,$action,$_REQUEST['ip_addr']);
						/*
						if($msg!='NA')messageSent($custNum,$msg);
						*/
						if($nhs_action=="1"){
							$mess="Ticket No - $ticket_id against the Activity ".alias(alias($ticket_alias,"ec_tickets","ticket_alias","activity_alias"),"ec_activity","activity_alias","activity_name")." of Site name-".alias(alias($ticket_alias,"ec_tickets","ticket_alias","site_alias"),"ec_sitemaster","site_alias","site_name")." is CLOSED on Dt-".$closing_date.".";
							ticket_notification($ticket_alias,$mess);
							//zhs_nhs_close_mail($ticket_alias);
							curlxing(baseurl()."services/tickets/mails/zhs_nhs_close_mail?ticket_alias=".$ticket_alias);
						}elseif($nhs_action=="2"){
							$mess="Ticket No - $ticket_id against the Activity ".alias(alias($ticket_alias,"ec_tickets","ticket_alias","activity_alias"),"ec_activity","activity_alias","activity_name")." of Site name-".alias(alias($ticket_alias,"ec_tickets","ticket_alias","site_alias"),"ec_sitemaster","site_alias","site_name")." is DECLINED on Dt-".$closing_date.".";
							ticket_notification($ticket_alias,$mess);
							//zhs_nhs_decline_mail($ticket_alias);
							curlxing(baseurl()."services/tickets/mails/zhs_nhs_decline_mail?ticket_alias=".$ticket_alias);
						}elseif($nhs_action=="3"){
							$mess="Ticket No - $ticket_id against the Activity ".alias(alias($ticket_alias,"ec_tickets","ticket_alias","activity_alias"),"ec_activity","activity_alias","activity_name")." of Site name-".alias(alias($ticket_alias,"ec_tickets","ticket_alias","site_alias"),"ec_sitemaster","site_alias","site_name")." is Send to TS for Approval.";
							ticket_notification($ticket_alias,$mess);
							$fam_msg="Dear Team, request send for Technical Services verification of TT Number $ticket_id, Kindly verify and close the request";
							/*
							foreach(sms_contacts($ticket_alias,array("TS","HO")) as $phnum)messageSent($phnum,$fam_msg);
							*/
							$site_alias=alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
							$state_alias=alias($site_alias,'ec_sitemaster','site_alias','state_alias');
							ecSendSms('ts_verification', $state_alias, "", $fam_msg);
							curlxing(baseurl()."services/tickets/mails/nhs_approve_mail?ticket_alias=".$ticket_alias);
						}elseif($nhs_action=="4")ticket_notification($ticket_alias,"Ticket No - $ticket_id against the Activity ".alias(alias($ticket_alias,"ec_tickets","ticket_alias","activity_alias"),"ec_activity","activity_alias","activity_name")." of Site name-".alias(alias($ticket_alias,"ec_tickets","ticket_alias","site_alias"),"ec_sitemaster","site_alias","site_name")." is next visit generated by NHS");
						$result="0,Successful!";
					}else{$res="Error In Updating";}
				}else $res="Ticket should not Closed OR Declined until Material reached at site.";
			}else $res="There is No Required Cells OR Accessories to sent TS approval";
		}
	}
	if(isset($res) && !empty($res)){$result="4,$res";}
	return $result;
}
function ticket_8to5_update($ticket_alias,$emp_alias,$app_qty,$item_alias,$ths_action,$line_number,$shift,$date_of_assembly,$date_of_jar_form,$corect_act_Plan,$persons_notified,$faulty_cell_num,$ocv_at_dispatch,$tenth_hour,$remarks,$deposition,$prevent_recurrence,$cell_type_chk){ global $mr_con;
	$res="";
	if(empty($ths_action)){$res="Select TS Action";}
	if(empty($remarks)){$res="Enter Remark";}
	else{
		$ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
		$remarks=mysqli_real_escape_string($mr_con,$remarks);
		if($ths_action=="1"){ $bucket='12'; //TS Approved
			$tt_ch=mysqli_query($mr_con,"SELECT id FROM ec_cell_required WHERE ticket_alias='$ticket_alias' AND flag='0'");
			if(mysqli_num_rows($tt_ch)){
				$app_count=count($app_qty);
				$item_count=count($item_alias);
				if($app_count=='0' || $app_count!=count(array_filter($app_qty)))$res="Enter Approved Quantity";
				elseif($item_count=='0' || $item_count!=count(array_filter($item_alias)))$res="Something Went Wrong";
				else $req_check=TRUE;
			}else $req_check=TRUE;
			if($req_check){
				if($cell_type_chk=='2'){
					$acc_cnt = mysqli_query($mr_con,"SELECT SUM(quanty) AS qty_sum FROM ec_cell_required WHERE approved_stat='1' AND ticket_alias='$ticket_alias' AND flag='0'");
					if(mysqli_num_rows($acc_cnt)){$acc_row_cnt=mysqli_fetch_array($acc_cnt);$from=$acc_row_cnt['qty_sum'];}else $from=0;
					$to=(isset($app_qty) && is_array($app_qty) ? array_sum($app_qty) : 0);
					for($i=0;$i<$app_count;$i++)$acc = mysqli_query($mr_con,"UPDATE ec_cell_required SET quanty='".$app_qty[$i]."', approved_stat='2', approved_by='$emp_alias', approved_on='".date('Y-m-d')."' WHERE ticket_alias='$ticket_alias' AND item_alias='".$item_alias[$i]."' AND approved_stat='1' AND flag='0'");
					$acc_inv = mysqli_query($mr_con,"UPDATE ec_tickets_inventory SET material_outward='1' WHERE ticket_alias='$ticket_alias' AND flag='0'");
					$sub_con="level='5',old_level='8',status='VISITED',"; subticket($ticket_alias,'1'); $action = "Ticket ".$ticket_id." TS Approved and go to Next visit".($from!=$to ? " and approved count changed from $from to $to":"");
				}else{
					$f_count=count($faulty_cell_num);
					$o_count=count($ocv_at_dispatch);
					$t_count=count($tenth_hour);
					if(empty($line_number)){$res="Enter Line Number";}
					elseif(empty($shift)){$res="Select Shift";}
					elseif(empty($date_of_assembly) || $date_of_assembly=='NA'){$res="Choose Date Of Assembly";}
					elseif(empty($date_of_jar_form) || $date_of_jar_form=='NA'){$res="Choose Date Of Jar Formation";}
					elseif(empty($corect_act_Plan)){$res="Enter Correct Action Plan";}
					elseif(empty($persons_notified) || count($persons_notified)=='0'){$res="Select Persons Notified";}
					elseif(empty($deposition)){$res="Select Deposition";}
					elseif($deposition!='OPEN' && empty($prevent_recurrence)){$res="Select Deposition";}
					elseif($f_count=='0' || $f_count!=count(array_filter($faulty_cell_num))){$res="Enter Faulty Cell Number";}
					elseif($o_count=='0' || $o_count!=count(array_filter($ocv_at_dispatch))){$res="Enter Ocv At Dispatch";}
					elseif($t_count=='0' || $t_count!=count(array_filter($tenth_hour))){$res="Enter 10th Hour Reading";}
					elseif($f_count!=count(array_unique($faulty_cell_num))){$res="Duplicate Faulty Cell Numbers are not allowed";}
					else{
						$car_number=car_random(rand(00000,99999));
						$alias=aliasCheck(generateRandomString(),'ec_ths_approved','alias');
						$sqlThs = mysqli_query($mr_con,"INSERT INTO ec_ths_approved(ticket_alias,car_number,line_number,shift,date_of_assembly,date_of_jar_form,corect_act_Plan,persons_notified,deposition,alias)VALUES('$ticket_alias','$car_number','$line_number','$shift','$date_of_assembly','$date_of_jar_form','$corect_act_Plan','".implode("|",$persons_notified)."','$deposition','$alias')");
						if($sqlThs){
							for($i=0;$i<$f_count;$i++){
								$faulty_ocv_alias[$i]=aliasCheck(generateRandomString(),'ec_ths_faulty_ocv','alias');
								$sqlThs_fo = mysqli_query($mr_con,"INSERT INTO ec_ths_faulty_ocv(ths_appr_alias,faulty_cell_num,ocv,tenth_hour,alias)VALUES('$alias','$faulty_cell_num[$i]','$ocv_at_dispatch[$i]','$tenth_hour[$i]','$faulty_ocv_alias[$i]')");
							}
						}
						$acc_cnt = mysqli_query($mr_con,"SELECT SUM(quanty) AS qty_sum FROM ec_cell_required WHERE approved_stat='1' AND ticket_alias='$ticket_alias' AND flag='0'");
						if(mysqli_num_rows($acc_cnt)){$acc_row_cnt=mysqli_fetch_array($acc_cnt);$from=$acc_row_cnt['qty_sum'];}else $from=0;
						$to=(isset($app_qty) && is_array($app_qty) ? array_sum($app_qty) : 0);
						for($i=0;$i<$app_count;$i++)$acc = mysqli_query($mr_con,"UPDATE ec_cell_required SET quanty='".$app_qty[$i]."', approved_stat='2', approved_by='$emp_alias', approved_on='".date('Y-m-d')."' WHERE ticket_alias='$ticket_alias' AND item_alias='".$item_alias[$i]."' AND approved_stat='1' AND flag='0'");
						$acc_inv = mysqli_query($mr_con,"UPDATE ec_tickets_inventory SET material_outward='1' WHERE ticket_alias='$ticket_alias' AND flag='0'");
						$sub_con="level='5',old_level='8',status='VISITED',"; subticket($ticket_alias,'1'); $action = "Ticket ".$ticket_id." TS Approved and go to Next visit".($from!=$to ? " and approved count changed from $from to $to":"");
						if($deposition!='OPEN'){
							$dis_bucket=($deposition=='CLOSE' ? '31' : '32');
							$rem_alias=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
							$prevent_recurrence=mysqli_real_escape_string($mr_con,$prevent_recurrence);
							$sqlRem = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$prevent_recurrence','TT','$dis_bucket','$ticket_alias','$emp_alias','$rem_alias')");
						}
					}
				}
			}
		}elseif($ths_action=="2"){ $bucket='13'; //$ths_action=="5" -> TS Reject.
			$car_number=car_random(rand(00000,99999));
			$alias=aliasCheck(generateRandomString(),'ec_ths_approved','alias');
			$sqlThs = mysqli_query($mr_con,"INSERT INTO ec_ths_approved(ticket_alias,car_number,alias)VALUES('$ticket_alias','$car_number','$alias')");
			$sub_con="level='4',old_level='8',status='VISITED',"; $action = "Ticket ".$ticket_id." TS Rejected the ticket";
		}elseif($ths_action=="3"){ $bucket='14'; // Stock Approved.
			$app_count=count($app_qty);
			$item_count=count($item_alias);
			if($app_count=='0' || $app_count!=count(array_filter($app_qty))){$res="Enter Approved Quantity";}	
			elseif($item_count=='0' || $item_count!=count(array_filter($item_alias))){$res="Something Went Wrong";}
			else{
				for($i=0;$i<$app_count;$i++)$acc = mysqli_query($mr_con,"UPDATE ec_cell_required SET quanty='".$app_qty[$i]."', approved_stat='2', approved_by='$emp_alias', approved_on='".date('Y-m-d')."' WHERE ticket_alias='$ticket_alias' AND item_alias='".$item_alias[$i]."' AND approved_stat='1' AND flag='0'");
				$acc_inv = mysqli_query($mr_con,"UPDATE ec_tickets_inventory SET material_outward='1' WHERE ticket_alias='$ticket_alias' AND flag='0'");
				$sub_con="level='1', old_level='8', purpose='1', status='OPEN',";$action = "Ticket ".$ticket_id." Cells approved at TS level";
			}
		}
		elseif($ths_action=="4"){ $bucket='15'; // Stock Rejected.
			$rej = mysqli_query($mr_con,"DELETE FROM ec_cell_required WHERE ticket_alias='$ticket_alias' AND approved_stat='1' AND flag='0'");
			$sub_con="level='1', old_level='8', status='OPEN',"; $action = "Ticket ".$ticket_id." Cells rejected at TS level";
		}
		if(empty($res)){
			$sqlTT = mysqli_query($mr_con,"UPDATE ec_tickets SET $sub_con transaction_date='".date('Y-m-d')."' WHERE ticket_alias='$ticket_alias' AND flag=0");
			$alias=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
			$sqlRem = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','TT','$bucket','$ticket_alias','$emp_alias','$alias')");
			if($sqlTT && $sqlRem){
				user_history($emp_alias,$action,$_REQUEST['ip_addr']);
				$fam_msg="Dear Team, Technical Services verification of e-FSR is ".($ths_action=="1" || $ths_action=="3" ? "Approved":"Rejected")." against the TT Number ".$ticket_id.", Kindly Initiate the further Process.";
				/*
				foreach(sms_contacts($ticket_alias,array("ZHS","NHS","TS","HO"),"TT") as $phnum)messageSent($phnum,$fam_msg);
				*/
				$site_alias=alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
				$state_alias=alias($site_alias,'ec_sitemaster','site_alias','state_alias');
				ecSendSms('ts_verification_approved', $state_alias, "", $fam_msg);
				$result="0,Successful!";
				if($ths_action=="1" || $ths_action=="3"){
					$mess="Ticket No - $ticket_id against the Activity ".alias(alias($ticket_alias,"ec_tickets","ticket_alias","activity_alias"),"ec_activity","activity_alias","activity_name")." of Site name-".alias(alias($ticket_alias,"ec_tickets","ticket_alias","site_alias"),"ec_sitemaster","site_alias","site_name")." is ".($ths_action=="3" ? 'Stock ' : '')."Approved by TS.";
					ticket_notification($ticket_alias,$mess);
					curlxing(baseurl()."services/tickets/mails/ts_approve_mail?ticket_alias=".$ticket_alias);
				}
				elseif($ths_action=="2" || $ths_action=="4"){
					$mess="Ticket No - $ticket_id against the Activity ".alias(alias($ticket_alias,"ec_tickets","ticket_alias","activity_alias"),"ec_activity","activity_alias","activity_name")." of Site name-".alias(alias($ticket_alias,"ec_tickets","ticket_alias","site_alias"),"ec_sitemaster","site_alias","site_name")." is ".($ths_action=="4" ? 'Stock ' : '')."Rejected by TS.";
					ticket_notification($ticket_alias,"TS Rejected");
					curlxing(baseurl()."services/tickets/mails/ts_reject_mail?ticket_alias=".$ticket_alias);
				}
			}else{$res="Error In Updating";}
		}
	}
	if(!empty($res)){$result="4,$res";}
	return $result;
}
function ticket_5to6_update($ticket_alias,$emp_alias,$deposition,$prevent_recurrence){ global $mr_con;
	if(empty($deposition)){$res="Select Deposition";}
	elseif(empty($prevent_recurrence)){$res="Select prevent_recurrence";}
	else{
		$prevent_recurrence=mysqli_real_escape_string($mr_con,$prevent_recurrence);
		$sqlThs = mysqli_query($mr_con,"UPDATE ec_ths_approved SET deposition='$deposition' WHERE ticket_alias='$ticket_alias' AND flag='0'");
		$dis_bucket=($deposition=='CLOSE' ? '31' : '32');
		$rem_alias=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
		$sqlRem = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$prevent_recurrence','TT','$dis_bucket','$ticket_alias','$emp_alias','$rem_alias')");
		if($sqlThs && $sqlRem){
			$action="TS Deposition has updated as $deposition against ".alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
			user_history($emp_alias,$action,$_REQUEST['ip_addr']);
			$result="0,Successful!";
		}else{$res="Error In Updating";}
	}if(!empty($res)){$result="4,$res";}
	return $result;
}
//function ticket_6to7_update($ticket_alias,$reject){ global $mr_con;}
function sub_tickets_close_decline($ticket_alias,$sub_con){ global $mr_con;
	$ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
	if (strpos($ticket_id,"|")!== false){
		list($ticket,$end) = explode("|",$ticket_id);
		$sqlTT = mysqli_query($mr_con,"UPDATE ec_tickets SET $sub_con,transaction_date='".date('Y-m-d')."' WHERE ticket_id='$ticket' AND flag=0");
		$acc_inv = mysqli_query($mr_con,"UPDATE ec_tickets_inventory SET material_inward='2',material_outward='2' WHERE ticket_alias='$ticket_alias' AND flag='0'");
		for($i=2;$i<$end;$i++)$sqlTT = mysqli_query($mr_con,"UPDATE ec_tickets SET $sub_con,transaction_date='".date('Y-m-d')."' WHERE ticket_id='$ticket|$i' AND flag=0");
		all_tats_visits_update($ticket_alias);
	}
}
function subticket($ticket_alias,$purpose){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT ticket_id,activity_alias,login_date,site_alias,complaint_alias,mode_of_contact,contact_link,moc_num,description,n_visits,warranty FROM ec_tickets WHERE ticket_alias='$ticket_alias' AND flag=0");
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
	$moc_num=mysqli_real_escape_string($mr_con,$row['moc_num']);
	$description=mysqli_real_escape_string($mr_con,$row['description']);
	$alias = aliasCheck(generateRandomString(),'ec_tickets','ticket_alias');
	$sql1 = mysqli_query($mr_con,"INSERT INTO ec_tickets(ticket_id,activity_alias,site_alias,complaint_alias,mode_of_contact,contact_link,moc_num,description,login_date,visit_gen_date,level,old_level,status,n_visits,warranty,purpose,ticket_alias,transaction_date)VALUES('$ticket_id','$activity_alias','$site_alias','$complaint_alias','$mode_of_contact','$contact_link','$moc_num','$description','$login_date','".date('Y-m-d H:i:s')."','1','1','OPEN','$n_visits','$warranty','$purpose','$alias','".date('Y-m-d')."')");
	if($sql1){ all_tats_visits_update($alias);
		$acc_inv = mysqli_query($mr_con,"INSERT INTO ec_tickets_inventory(ticket_alias,material_outward)VALUES('$alias','1')");
		$cell = alias($ticket_alias,'ec_cell_required','ticket_alias','id');
		if(!empty($cell))$sql2 = mysqli_query($mr_con,"UPDATE ec_cell_required SET ticket_alias='$alias' WHERE ticket_alias='$ticket_alias' AND approved_stat='2' AND flag='0'");
	}
}
function all_tats_visits_update($ticket_alias){ global $mr_con;
	$ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
	$n_visits = alias($ticket_alias,'ec_tickets','ticket_alias','n_visits');
	if (strpos($ticket_id,"|")!== false){
		list($ticket,$end) = explode("|",$ticket_id);
		$login_date=date_create(alias($ticket,'ec_tickets','ticket_id','login_date'));
		$clos_date = alias($ticket_alias,'ec_tickets','ticket_alias','closing_date');
		$closing_date=date_create(empty($clos_date) ? date('Y-m-d H:i:s') : $clos_date);
		$diff=date_diff($login_date,$closing_date);
		$for_mat = $diff->format("%R%a");
		if($for_mat <= 15) $tat="TAT-1";
		elseif($for_mat >= 16 && $for_mat <= 25) $tat="TAT-2";
		else $tat="TAT-3"; //$for_mat > 25
		$sqlTT = mysqli_query($mr_con,"UPDATE ec_tickets SET tat='$tat',n_visits='$n_visits',transaction_date='".date('Y-m-d')."' WHERE ticket_id='$ticket' AND flag=0");
		for($i=2;$i<=$end;$i++)$sqlTT = mysqli_query($mr_con,"UPDATE ec_tickets SET tat='$tat',n_visits='$n_visits',transaction_date='".date('Y-m-d')."' WHERE ticket_id='$ticket|$i' AND flag=0");
	}
}
function subTTCheck($ticket_id){
	if (strpos($ticket_id,"|")!== false){
		$tt = explode("|",$ticket_id);
		$ret = $tt[0]."|".(end($tt)+1);
	}else{$ret = $ticket_id."|2";}
	return $ret;
}
function ticket_autocomplete(){ global $mr_con;
	if(isset($_REQUEST['emp_alias']))$emp_alias = mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias']));
	if(strtoupper($emp_alias)=='ADMIN')$emp = "";
	else $emp = "state_alias IN ('".implode("','",explode(", ",alias($emp_alias,'ec_employee_master','employee_alias','state_alias')))."') AND";
	$alias="";
	if(isset($_REQUEST['alias']))$alias.="site_id LIKE '%".mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']))."%' AND ";
	if(isset($_REQUEST['seg_alias']) && !empty($_REQUEST['seg_alias']))$alias.="segment_alias='".mysqli_real_escape_string($mr_con,trim($_REQUEST['seg_alias']))."' AND ";
	$sql = mysqli_query($mr_con,"SELECT site_id,site_alias FROM ec_sitemaster WHERE $alias $emp flag=0 ORDER BY site_id");
	if(mysqli_num_rows($sql)){$i=0;
		while($row=mysqli_fetch_array($sql)){$result[$i]['site_id']=$row['site_id'];$result[$i]['site_alias']=$row['site_alias'];$i++;}
	}else{$result[0]['site_id']="Add to Site Master";$result[0]['site_alias']="Add to Site Master";}
	echo json_encode($result);
}
function zoneMsg($activity_code,$site_alias,$ticket_id){ global $mr_con;
	$zone_alias=alias_flag_none($site_alias,'ec_sitemaster','site_alias','zone_alias');
	$site_name = alias_flag_none($site_alias,'ec_sitemaster','site_alias','site_name');
	$sql=mysqli_query($mr_con,"SELECT mobile_number FROM ec_employee_master WHERE zone_alias RLIKE '%$zone_alias%' AND role_alias<>'01ZMYJ4OLG' AND privilege_alias='OX5E3EMI0U' AND flag=0"); // Not ESCA role and ZHS privilage
	if(mysqli_num_rows($sql)>0){
		while($row = mysqli_fetch_array($sql)){
			$num=mysqli_real_escape_string($mr_con,$row['mobile_number']);
			$msg="Greetings from Enersys, your complaint has been registered against the ".$activity_code." of Site name- ".$site_name." Ticket No- ".$ticket_id.".";
			if(!empty($num)){messageSent($num,$msg);}
		}
	}
}
function num2alpha($n){
    for($r = ""; $n >= 0; $n = intval($n / 26) - 1) $r = chr($n%26 + 0x41) . $r;
    return $r;
}
function header_fun($item_alias,$type,$h){ global $mr_con;
	$result[$h] = array();
	$tkt_head=mysqli_query($mr_con,"SELECT $h FROM ec_bo_headers WHERE item_alias='$item_alias' AND type='$type' AND flag=0");
	if(mysqli_num_rows($tkt_head)){
		$n=0;while($tkt_head_row=mysqli_fetch_array($tkt_head)){
			$result[$h][$n] = $tkt_head_row[$h];
		$n++;}
		$count = count($result[$h]);
	}else{$count=0;}
	$limit=($type=='ocv' ? $count+1 : 10);
	for($i=$count;$i<$limit;$i++){$result[$h][$i]=($h=='header' ? '-' : '0');}
	return $result;
}
function dateTime($date){
	if(!empty($date) && $date!="NA"){
		$date = trim($date);
		if(strpos($date," ")!==false){ return dateTimeFormat($date,'y');}
		else{ return dateFormat($date,'y')." ".date('H:i:s'); /*." ".substr($date, strpos($date, " ") + 1);*/ }
	}else{return "";}
}
function mail_send(){ 
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = $_REQUEST['emp_alias']; $token = $_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$ticket_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mail_ticket_alias']));
		$mail_id = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['send_email']));
		if(empty($ticket_alias)){$resCode='4'; $resMsg='Try Again';}
		elseif(empty($mail_id) && !filter_var($mail_id, FILTER_VALIDATE_EMAIL)){$resCode='4'; $resMsg='Enter Mail ID';}
		else{
			$tr = send_mail($ticket_alias,$mail_id);
			if($tr){$resCode='0'; $resMsg='Successfully Sent';}
			else{$resCode='4'; $resMsg='Sending Failed';}
		}
	}elseif($rex=='1'){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function visit_count($count){ global $mr_con;
	$re=mysqli_query($mr_con,"SELECT ticket_id,ticket_alias FROM ec_tickets WHERE ticket_id NOT LIKE '%|%' AND flag=0");
	if(mysqli_num_rows($re)>0){$tk_a=array();
		while($rew = mysqli_fetch_array($re)){
			$ticket_id = $rew['ticket_id'];
			$ticket_alias = $rew['ticket_alias'];
			$v_re=mysqli_query($mr_con,"SELECT id FROM ec_tickets WHERE ticket_id LIKE '%".$ticket_id."%' AND ticket_id NOT LIKE '%".$ticket_id."-%' AND (efsr_no<>'' OR esca_efsr_link<>'') AND flag=0");
			$v_count = mysqli_num_rows($v_re);
			if($count==$v_count)$tk_a[]=$ticket_id;	
		}
		if(count($tk_a>'0'))$tkt=implode("|",$tk_a);
		else $tkt=0;
	}else{$tkt=0;}
	return $tkt;
}
function visits($ticket_id){ global $mr_con;
	$v_re=mysqli_query($mr_con,"SELECT id FROM ec_tickets WHERE ticket_id LIKE '%".$ticket_id."%' AND ticket_id NOT LIKE '%".$ticket_id."-%' AND (efsr_no<>'' OR esca_efsr_link<>'') AND flag=0");
	return $v_count = mysqli_num_rows($v_re);
}
function spotticket_mul_view(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){$cond="";
		if(isset($_REQUEST['ticketId']) && !empty($_REQUEST['ticketId']))$cond.="t1.ticket_id LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['ticketId'])."%' AND ";
		if(isset($_REQUEST['loginDate']) && !empty($_REQUEST['loginDate']))$cond.="t1.login_date LIKE '%".mysqli_real_escape_string($mr_con,dateFormat($_REQUEST['loginDate'],'y'))."%' AND ";
		if(isset($_REQUEST['activityAlias']) && !empty($_REQUEST['activityAlias']))$cond.="t1.activity_alias LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['activityAlias'])."%' AND ";
		//if(isset($_REQUEST['segmentAlias']) && !empty($_REQUEST['segmentAlias']))$cond.="t2.segment_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['segmentAlias'])."' AND ";
		//if(isset($_REQUEST['siteId']) && !empty($_REQUEST['siteId']))$cond.="t2.site_name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['siteId'])."%' AND ";
		if(isset($_REQUEST['segmentAlias']) && !empty($_REQUEST['segmentAlias'])){
			$segmentAlias=mysqli_real_escape_string($mr_con,$_REQUEST['segmentAlias']);
			$cond.="((t2.segment_alias ='$segmentAlias' AND t1.complaint_alias='') OR t1.complaint_alias='$segmentAlias') AND ";
		}
		if(isset($_REQUEST['siteId']) && !empty($_REQUEST['siteId'])){
			$siteId=mysqli_real_escape_string($mr_con,$_REQUEST['siteId']);
			$cond.="((t2.site_name LIKE '%$siteId%' AND t1.description='') OR t1.description LIKE '%$siteId%') AND ";
		}
		if(isset($_REQUEST['customerName']) && !empty($_REQUEST['customerName']))$cond.="t2.customer_alias LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['customerName'])."%' AND ";
		if(isset($_REQUEST['flag']) && !empty($_REQUEST['flag']))$cond.="t1.flag='".mysqli_real_escape_string($mr_con,$_REQUEST['flag'])."' AND ";
		$rec=mysqli_query($mr_con,"SELECT COUNT(t1.id) AS totalListing FROM ec_tickets t1 LEFT JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias WHERE $cond t1.flag!='0' and t1.flag!=9");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row['totalListing'];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			$totalpages=ceil($totalRecords/$limit);
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sqlTT=mysqli_query($mr_con,"SELECT t1.flag,t1.ticket_alias,t1.login_date,t1.ticket_id,t1.activity_alias,t1.complaint_alias,t1.efsr_date,t1.esca_efsr_link,t1.description,t2.segment_alias,t2.site_name,t2.customer_alias FROM ec_tickets t1 LEFT JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias WHERE $cond t1.flag!='0' and t1.flag!=9 ORDER BY t1.id DESC LIMIT $offset, $limit");
			$result['ticketDetails']=array();
			if(mysqli_num_rows($sqlTT)){
				$i=0;while($rowTT = mysqli_fetch_array($sqlTT)){
					$flag=$rowTT['flag'];
					$segment_alias=$rowTT['segment_alias'];
					if(empty($segment_alias))$segment_alias=$rowTT['complaint_alias'];
					$result['ticketDetails'][$i]['flag']=$flag;
					$result['ticketDetails'][$i]['ticket_alias']=$rowTT['ticket_alias'];
					$result['ticketDetails'][$i]['ticket_id']=$rowTT['ticket_id'];
					$result['ticketDetails'][$i]['login_date']=dateFormat(alias_flag_none(strtok($rowTT['ticket_id'],"|"),'ec_tickets','ticket_id','login_date'),'d');
					$result['ticketDetails'][$i]['activity']=$rowTT['activity_alias'];
					$result['ticketDetails'][$i]['flagcolor']=($flag=='1' ? alias('1','ec_levels','level_alias','level_color') : alias('2','ec_levels','level_alias','level_color'));
					$result['ticketDetails'][$i]['flagname']=($flag=='1' ? 'SPOT TICKETS' : 'OFFLINE TICKETS');
					$result['ticketDetails'][$i]['efsr_date']=$rowTT['efsr_date'];
					$result['ticketDetails'][$i]['efsr_link']=baseurl()."mobile_app/pdf/index.php?ticket_alias=".$rowTT['ticket_alias'];
					$result['ticketDetails'][$i]['segment_code']=alias($segment_alias,'ec_segment','segment_alias','segment_code');
					$result['ticketDetails'][$i]['segment_name']=alias($segment_alias,'ec_segment','segment_alias','segment_name');
					$result['ticketDetails'][$i]['site_name']=(empty($rowTT['site_name']) ? $rowTT['description'] : $rowTT['site_name']);
					$result['ticketDetails'][$i]['customer_code']=$rowTT['customer_alias'];
				$i++;}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}
		$result['edit']=grantable('EDIT','SPOT TICKETS',$emp_alias);
		$result['export']=grantable('EXPORT','SPOT TICKETS',$emp_alias);
		$result['delete']=grantable('DELETE','SPOT TICKETS',$emp_alias);
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';}
	else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}

function spotticket_view(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){ $ticket_alias = $_REQUEST['alias'];
		$sql=mysqli_query($mr_con,"SELECT ticket_id,site_alias,activity_alias,complaint_alias,flag FROM ec_tickets WHERE ticket_alias='$ticket_alias' AND flag!='0'");
		if(mysqli_num_rows($sql)){
			$row=mysqli_fetch_array($sql);
			$result['temp_ticket_alias']=$ticket_alias;
			$result['temp_ticket_id']=$row['ticket_id'];
			$result['temp_site_alias']=$row['site_alias'];
			$flag=$row['flag'];
			$result['flag']=$flag;
			if($flag==2){ //Offline
				$result['temp_site_name']=alias_flag_none($ticket_alias,'ec_tickets','ticket_alias','description');
				$segment_alias=alias_flag_none($row['site_alias'],'ec_sitemaster','site_alias','segment_alias');
				if(empty($segment_alias))$segment_alias=$row['complaint_alias'];
				$sql_tt=mysqli_query($mr_con,"SELECT t1.ticket_id,t1.ticket_alias FROM ec_tickets t1 INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias WHERE t2.segment_alias='$segment_alias' AND t1.level='2' AND t1.flag='0'");
				if(mysqli_num_rows($sql_tt)){
					$i=0;while($row_tt=mysqli_fetch_array($sql_tt)){
						$result['tt_drop'][$i]['ticket_id']=$row_tt['ticket_id'];
						$result['tt_drop'][$i]['ticket_alias']=$row_tt['ticket_alias'];
					$i++;}
				}else $result['tt_drop']=array();
			}elseif($flag==1){ //Spot
				$result['temp_site_name']=alias_flag_none($row['site_alias'],'ec_sitemaster','site_alias','site_name');
				$sql_tt=mysqli_query($mr_con,"SELECT activity_alias,complaint_alias,site_alias,description,faulty_cell_count,mode_of_contact,contact_link,moc_num FROM ec_tickets WHERE ticket_alias='$ticket_alias' AND flag='1'");
				$row_tt=mysqli_fetch_array($sql_tt);
				
				$result['activity_alias']=$row_tt['activity_alias'];
				$result['complaint_alias']=$row_tt['complaint_alias'];
				$result['description']=$row_tt['description'];
				$result['faulty_cell_count']=$row_tt['faulty_cell_count'];
				$result['mode_of_contact']=$row_tt['mode_of_contact'];
				$result['contact_link']=$row_tt['contact_link'];
				$result['moc_num']=$row_tt['moc_num'];
				
				$query=mysqli_query($mr_con,"SELECT * FROM ec_sitemaster WHERE site_alias='".$row_tt['site_alias']."' AND flag='1'");
				$srow=mysqli_fetch_array($query);
				$result['site_alias']=$srow['site_alias'];
				$result['site_name']=$srow['site_name'];
				$result['site_id']=$srow['site_id'];	
				$result['zone']=$srow['zone_alias'];
				$result['state']=$srow['state_alias'];
				$result['district']=$srow['district_alias'];
				$result['mfd_date']=dateFormat($srow['mfd_date'],'d');
				$result['install_date']=dateFormat($srow['install_date'],'d');
				$result['no_of_string']=$srow['no_of_string'];
				$result['technician_name']=$srow['technician_name'];
				$result['technician_number']=$srow['technician_number'];
				$result['manager_name']=$srow['manager_name'];
				$result['manager_number']=$srow['manager_number'];
				$result['manager_mail']=$srow['manager_mail'];
				$result['segment_alias']=$srow['segment_alias'];
				$result['segment_name']=alias($srow['segment_alias'],'ec_segment','segment_alias','segment_name');
				$segment_type=alias($srow['segment_alias'],'ec_segment','segment_alias','segment_type');
				if($segment_type=='1'){
					$result['other_act_name']=alias('2','ec_activity','activity_type','activity_name');
					$result['other_check']=TRUE;
				}else $result['other_act_name']=$result['other_check']=FALSE;
				$result['other_act_alias']=alias('2','ec_activity','activity_type','activity_alias');
				$result['site_type_alias']=$srow['site_type_alias'];
				$result['customer_alias']=$srow['customer_alias'];
				$result['site_address']=$srow['site_address'];
				$result['battery_bank_rating']=$srow['battery_bank_rating'];
				$result['product_alias']=$srow['product_alias'];
			}else{$resCode='4'; $resMsg='Invalid Ticket';} //Invalid
			$resCode='0'; $resMsg='Successful!';
		}
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function spotticket_update(){ global $mr_con;
	$emp_alias=$_REQUEST['emp_alias']; $token=$_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$ticket_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['ticket_alias']));
		$site_avail=mysqli_real_escape_string($mr_con,$_REQUEST['site_avail']);
		if(isset($site_avail) && !empty($site_avail)){
			$site_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['site_alias'])));
			$activity_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['activity_alias']));
			$mode_of_contact=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mode_of_contact']));
			$complaint_alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['complaint_alias']));
			$faulty_cell_count=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['faulty_cell_count']));
			$description=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['description']));
			if($site_avail=='1'){
				//Site Available
				$sit_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['sit_alias'])));
				$po_number=$po_date=$po_link='';
				if(empty($activity_alias)){$res="Select Activity";}
				else{ $at_check='1';
					$activity_type=alias($activity_alias,'ec_activity','activity_alias','activity_type');
					$activity_code=alias($activity_alias,'ec_activity','activity_alias','activity_code');
					if($activity_type=='0'){
						$po_number = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['po_number']));
						$po_date = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['po_date']));
						if(empty($po_number)){$at_check="Enter PO Number";}
						elseif(empty($po_date)){$at_check="Choose PO Date";}
						else{
							if(isset($_FILES['po_file']) && !empty($_FILES['po_file']['name'])){
								$po_file=$_FILES['po_file'];
								$p_link = upload_file($po_file,str_replace("&","_N_",$activity_code).'_PO_FILE','pdf');
								list($po_code,$po_msg) = explode(",",$p_link);
								if($po_code=='0'){
									$po_link = $po_msg;
								}else $at_check = $po_msg;
							}else $at_check = "Please Choose PO File";
						}
					}
					if($at_check!='1'){$res=$at_check;}
					elseif(empty($sit_alias)){$res="Select Site ID";}
					elseif($faulty_cell_count==''){$res="Enter Faulty Cell Count";}
					elseif(empty($complaint_alias)){$res="Select Complaint";}
					elseif(empty($mode_of_contact)){$res="Select Mode Of Complaint";}
					elseif(empty($description)){$res="Enter Description";}
					elseif(empty($site_alias)){$res="Some thing went wrong";}
					else{
						$moc_pdf=alias($mode_of_contact,'ec_moc','moc_alias','moc_file');
						$moc_text=alias($mode_of_contact,'ec_moc','moc_alias','moc_text');
						$moc_file=$moc_num=$res = "";
						if($moc_pdf=='1'){
							if(isset($_FILES['moc_file']) && !empty($_FILES['moc_file']['name'])){
								$moc_file=$_FILES['moc_file'];
							}else{$res = "Please Choose ".alias($mode_of_contact,'ec_moc','moc_alias','moc_name')." File";}
						}
						if($moc_text=='1'){
							if(isset($_REQUEST['moc_number']) && !empty($_REQUEST['moc_number'])){
								$moc_num=mysqli_real_escape_string($mr_con,$_REQUEST['moc_number']);
							}else{$res = "Please Enter".alias($mode_of_contact,'ec_moc','moc_alias','moc_name')." File";}
						}
						if(empty($res)){
							if($activity_type!='2'){
					//Site Available But Not Other Segment
					//Update All the Tickets details with flag from 0 to 1 but not update ticket_alias
					//Delete temp Site master details with which have flag=1
								$ticket_id = ticketsID($sit_alias,alias(alias($sit_alias,'ec_sitemaster','site_alias','state_alias'),'ec_state','state_alias','state_code'),1);
								$query=mysqli_query($mr_con,"SELECT id FROM ec_tickets WHERE site_alias ='$sit_alias' AND activity_alias='$activity_alias' AND level<>'6' AND level<>'7' AND flag='0'");
								if(mysqli_num_rows($query)==0){
									$num=alias($sit_alias,'ec_sitemaster','site_alias','technician_number');
									//$msg="Greetings from Enersys, your complaint has been registered against the ".$activity_code." of Site name-".alias($sit_alias,'ec_sitemaster','site_alias','site_name')." Ticket No- ".$ticket_id;
									$msg="GREETINGS FROM ENERSYS, YOUR COMPLAINT HAS BEEN REGISTERED AGAINST THE AT OF SITE NAME-".alias($site_alias,'ec_sitemaster','site_alias','site_name')." Ticket No- ".$ticket_id;

									$action="Spot and Site Available Ticket - ".alias_flag_none($ticket_alias,'ec_tickets','ticket_alias','ticket_id')." Converted to ".$ticket_id." Successfully";
									$tt_warranty=sitemanfdate_check($sit_alias);
									$notif_msg="Dear Team, New Complaint has been registered against the $activity_code of Site name-".alias($sit_alias,'ec_sitemaster','site_alias','site_name')." Ticket No- $ticket_id in your State.";
									$old_tt=alias_flag_none($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
									if(!empty($moc_file)){
										$link = upload_file($moc_file,str_replace(" ","_",alias($mode_of_contact,'ec_moc','moc_alias','moc_name')),'pdf');
										list($code,$msg1) = explode(",",$link);
										if($code=='0'){ $contact_link = $msg1;
											$sql = mysqli_query($mr_con,"UPDATE ec_tickets SET ticket_id='$ticket_id',activity_alias='$activity_alias',site_alias='$sit_alias',complaint_alias='$complaint_alias',faulty_cell_count='$faulty_cell_count',mode_of_contact='$mode_of_contact',contact_link='$contact_link',moc_num='$moc_num',description='$description',level='3',n_visits=(n_visits+1),warranty='$tt_warranty',po_number='$po_number',po_date='".dateFormat($po_date,'y')."',po_link='$po_link',flag='0' WHERE ticket_alias='$ticket_alias' AND flag='1'");
											if($sql){
												$sql_inv = mysqli_query($mr_con,"INSERT INTO ec_tickets_inventory(ticket_alias)VALUES('$ticket_alias')");
												ticket_notification($ticket_alias,$notif_msg);
												user_history($emp_alias,$action,$_REQUEST['ip_addr']);
												/*
												messageSent($num,$msg);
												zoneMsg($activity_code,$site_alias,$ticket_id);
												*/
												$site_alias=alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
												$state_alias=alias($site_alias,'ec_sitemaster','site_alias','state_alias');
												ecSendSms('new_tt_registration', $state_alias, $num, $msg);
												curlxing(baseurl()."services/tickets/mails/new_ticket_mail?site_alias=".$sit_alias."&ticket_alias=".$ticket_alias);
												$resCode='0'; $resMsg="Successful ".$ticket_id." Ticket Created";
											}else{$res = "Ticket didn't generate, Try again!";}
										}else{$res = $msg1.', Try again!';}
									}else{
										$contact_link='0';
										$sql = mysqli_query($mr_con,"UPDATE ec_tickets SET ticket_id='$ticket_id',activity_alias='$activity_alias',site_alias='$sit_alias',complaint_alias='$complaint_alias',faulty_cell_count='$faulty_cell_count',mode_of_contact='$mode_of_contact',contact_link='$contact_link',moc_num='$moc_num',description='$description',level='3',n_visits=(n_visits+1),warranty='$tt_warranty',po_number='$po_number',po_date='".dateFormat($po_date,'y')."',po_link='$po_link',flag='0' WHERE ticket_alias='$ticket_alias' AND flag='1'");
										if($sql){
											$sql_inv = mysqli_query($mr_con,"INSERT INTO ec_tickets_inventory(ticket_alias)VALUES('$ticket_alias')");
											ticket_notification($ticket_alias,$notif_msg);
											user_history($emp_alias,$action,$_REQUEST['ip_addr']);
											/*
											messageSent($num,$msg);
											zoneMsg($activity_code,$sit_alias,$ticket_id);
											*/
											$site_alias=alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
											$state_alias=alias($site_alias,'ec_sitemaster','site_alias','state_alias');
											ecSendSms('new_tt_registration', $state_alias, $num, $msg);
											curlxing(baseurl()."services/tickets/mails/new_ticket_mail?site_alias=".$sit_alias."&ticket_alias=".$ticket_alias);
											$resCode='0'; $resMsg="Successful ".$ticket_id." Ticket Created";
										}else{$res = "Ticket didn't generate, Try again!";}
									}
									if(!empty($old_tt))$dpr_update=mysqli_query($mr_con,"UPDATE ec_dpr SET ticket_alias='$ticket_alias' WHERE ticket_alias='$old_tt' AND flag='0'");
									if($sql)$quer=mysqli_query($mr_con,"DELETE FROM ec_sitemaster WHERE site_alias='$site_alias' AND flag='1'");
									if($sql && !empty($alias) && alias($sit_alias,'ec_sitemaster','site_alias','segment_alias')=="HXL5A1HOTZ")file_get_contents(baseurl()."mobile_app/efsr_submit_mail.php?ticketAlias=".$alias);
									if(isset($_REQUEST['remarks']) && !empty($_REQUEST['remarks'])){
										$remarks = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['remarks']));
										$rem_alias=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
										$sqlRem = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','TT','3','$ticket_alias','$emp_alias','$rem_alias')");
									}
									if(isset($_REQUEST['at_ic_rem']) && !empty($_REQUEST['at_ic_rem'])){
										$at_ic_rem = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['at_ic_rem']));
										$rem_alias2=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
										$sqlRem2 = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$at_ic_rem','TT','4','$ticket_alias','$emp_alias','$rem_alias2')");
									}
								}else{$res = 'The Requested SiteID and activity has already exist, Try with other values'; }
							}else{
		//Site Available But Other Segment
			//Insert fresh Tickets with flag 0 but not update ticket_alias
			//Insert Site master with flag=2 even site available
								$site_id = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_alias']));
								$zone_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['zone_alias']));
								$state_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['state_alias']));
								$district_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['district_alias']));
								$customer_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['customer_alias']));
								$product_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['product_alias']));
								$site_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_name']));
								
								$site_type_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_type_alias']));
								$batt_rating = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['batt_rating']));
								$mfd_date = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mfd_date']));
								$install_date = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['install_date']));
								$sale_invoice_date = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['sale_invoice_date']));
								$po_num = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['po_num']));
								$sale_invoice_num = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['sale_invoice_num']));
								$no_of_string = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['no_of_string']));
								
								$site_address = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_address']));
								$technician_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['technician_name']));
								$technician_number = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['technician_number']));
								$manager_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['manager_name']));
								$manager_number = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['manager_number']));
								$manager_mail = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['manager_mail']));
								if(empty($zone_alias))$res="Select Zone";
								elseif(empty($state_alias))$res="Select State";
								elseif(empty($district_alias))$res="Select District";
								elseif(empty($customer_alias))$res="Select Customer";
								elseif(empty($product_alias))$res="Select Product";
								elseif(empty($site_name))$res="Enter Site Name";
								elseif(empty($site_address))$res="Enter Site Address";
								elseif(empty($technician_name))$res="Enter Technician Name";
								elseif(empty($technician_number))$res="Enter Technician Number";
								elseif(empty($manager_name))$res="Enter Manager Name";
								elseif(empty($manager_number))$res="Enter Manager Number";
								elseif(empty($manager_mail))$res="Enter Manager Mail";
								else{
									$ticket_id = ticketsID("",alias($state_alias,'ec_state','state_alias','state_code'),1);
									$notif_msg="Dear Team, New Complaint has been registered against the $activity_code of Site name- $site_name Ticket No- $ticket_id in your State.";
									$moc_pdf=alias($mode_of_contact,'ec_moc','moc_alias','moc_file');
									$moc_text=alias($mode_of_contact,'ec_moc','moc_alias','moc_text');
									$moc_file=$moc_num=$res = "";
									if($moc_pdf=='1'){
										if(isset($_FILES['moc_file']) && !empty($_FILES['moc_file']['name'])){
											$moc_file=$_FILES['moc_file'];
										}else{$res = "Please Choose ".alias($mode_of_contact,'ec_moc','moc_alias','moc_name')." File";}
									}
									if($moc_text=='1'){
										if(isset($_REQUEST['moc_number']) && !empty($_REQUEST['moc_number'])){
											$moc_num=mysqli_real_escape_string($mr_con,$_REQUEST['moc_number']);
										}else{$res = "Please Enter".alias($mode_of_contact,'ec_moc','moc_alias','moc_name')." File";}
									}
									if(empty($res)){
										$query=mysqli_query($mr_con,"SELECT t1.id FROM ec_tickets t1 INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias WHERE t1.activity_alias='$activity_alias' AND t2.state_alias='$state_alias' AND customer_alias='$customer_alias' AND t1.level<>'6' AND t1.level<>'7' AND t1.flag='0' AND t2.flag<>'0'");
										if(mysqli_num_rows($query)==0){
											$site_alias = aliasCheck(generateRandomString(),'ec_sitemaster','site_alias');
											$sqls = mysqli_query($mr_con,"INSERT INTO ec_sitemaster(zone_alias,state_alias,district_alias,segment_alias,customer_alias,site_type_alias,site_id,site_name,site_alias,product_alias,mfd_date,install_date,no_of_string,technician_name,technician_number,manager_name,manager_number,manager_mail,site_address,battery_bank_rating,sale_invoice_num,sale_invoice_date,po_num,created_date,flag)VALUES('$zone_alias','$state_alias','$district_alias','$segment_alias','$customer_alias','$site_type_alias','$site_id','$site_name','$site_alias','$product_alias','$mfd_date','$install_date','$no_of_string','$technician_name','$technician_number','$manager_name','$manager_number','$manager_mail','$site_address','$batt_rating','$sale_invoice_num','$sale_invoice_date','$po_num','".date('Y-m-d')."','2')");
											$msg="Greetings from Enersys, your complaint has been registered against the ".$activity_code." of Site name- ".$site_name." Ticket No- ".$ticket_id;
											$old_tt=alias_flag_none($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
											$action="Other Segment Spot Ticket - ".$old_tt." Converted to ".$ticket_id." Successfully";
											if(!empty($moc_file)){
												$link = upload_file($moc_file,str_replace(" ","_",alias($mode_of_contact,'ec_moc','moc_alias','moc_name')),'pdf');
												list($code,$msg1) = explode(",",$link);
												if($code=='0'){ $contact_link = $msg1;
													$sql = mysqli_query($mr_con,"INSERT INTO ec_tickets(ticket_id,activity_alias,site_alias,complaint_alias,faulty_cell_count,mode_of_contact,contact_link,moc_num,description,login_date,level,status,warranty,po_number,po_date,po_link,n_visits,ticket_alias,transaction_date)VALUES('$ticket_id','$activity_alias','$site_alias','$complaint_alias','$faulty_cell_count','$mode_of_contact','$contact_link','$moc_num','$description','".date('Y-m-d H:i:s')."','1','OPEN','".sitemanfdate_check($site_alias)."','$po_number','".dateFormat($po_date,'y')."','$po_link','1','$alias','".date('Y-m-d')."')");
													if($sql){
														$sql_inv = mysqli_query($mr_con,"INSERT INTO ec_tickets_inventory(ticket_alias)VALUES('$alias')");
														ticket_notification($alias,$notif_msg);
														user_history($emp_alias,$action,$_REQUEST['ip_addr']);
														/*
														messageSent($$technician_number,$msg);
														zoneMsg($activity_code,$site_alias,$ticket_id);
														*/
														$site_alias=alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
														$state_alias=alias($site_alias,'ec_sitemaster','site_alias','state_alias');
														ecSendSms('new_tt_registration', $state_alias, $technician_number, $msg);
														curlxing(baseurl()."services/tickets/mails/new_ticket_mail?site_alias=".$site_alias."&ticket_alias=".$alias);
														$resCode='0'; $resMsg="Successful ".$ticket_id." Ticket Created";
													}
												}else{$res = $msg1.', Try again!';}
											}else{
												$contact_link='0';
												$sql = mysqli_query($mr_con,"INSERT INTO ec_tickets(ticket_id,activity_alias,site_alias,complaint_alias,faulty_cell_count,mode_of_contact,contact_link,moc_num,description,login_date,level,status,warranty,po_number,po_date,po_link,n_visits,ticket_alias,transaction_date)VALUES('$ticket_id','$activity_alias','$site_alias','$complaint_alias','$faulty_cell_count','$mode_of_contact','$contact_link','$moc_num','$description','".date('Y-m-d H:i:s')."','1','OPEN','".sitemanfdate_check($site_alias)."','$po_number','".dateFormat($po_date,'y')."','$po_link','1','$alias','".date('Y-m-d')."')");
												if($sql){
													$sql_inv = mysqli_query($mr_con,"INSERT INTO ec_tickets_inventory(ticket_alias)VALUES('$alias')");
													ticket_notification($alias,$notif_msg);
													user_history($emp_alias,$action,$_REQUEST['ip_addr']);
													/*
													messageSent($$technician_number,$msg);
													zoneMsg($activity_code,$site_alias,$ticket_id);
													*/
													$site_alias=alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
													$state_alias=alias($site_alias,'ec_sitemaster','site_alias','state_alias');
													ecSendSms('new_tt_registration', $state_alias, $technician_number, $msg);
													curlxing(baseurl()."services/tickets/mails/new_ticket_mail?site_alias=".$site_alias."&ticket_alias=".$alias);
													$resCode='0'; $resMsg="Successful ".$ticket_id." Ticket Created";
												}
											}
											if(!empty($old_tt))$dpr_update=mysqli_query($mr_con,"UPDATE ec_dpr SET ticket_alias='$alias' WHERE ticket_alias IN('$ticket_alias','$old_tt') AND flag='0'");
											if(isset($_REQUEST['remarks']) && !empty($_REQUEST['remarks'])){
												$remarks = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['remarks']));
												$rem_alias=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
												$sqlRem = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','TT','3','$alias','$emp_alias','$rem_alias')");
											}
											if(isset($_REQUEST['at_ic_rem']) && !empty($_REQUEST['at_ic_rem'])){
												$at_ic_rem = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['at_ic_rem']));
												$rem_alias2=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
												$sqlRem2 = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$at_ic_rem','TT','4','$alias','$emp_alias','$rem_alias2')");
											}
										}else{$res = 'The Requested SiteID and activity has already exist, Try with other values'; }
									}
								}
							}
						}
					}
				}
			}else{ //Site Not Available
					//Update Ticket ID and flag from 1 to 0 but not update ticket_alias
					//Update All site details and flag from 1 to 0
				$site_id=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_id']));
				$site_name=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_name']));
				$zone=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['zone_alias']));
				$state=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['state_alias']));
				$district=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['district_alias']));
				$po_num=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['po_num']));
				$sale_invoice_num=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['sale_invoice_num']));
				$sale_invoice_date=dateFormat(mysqli_real_escape_string($mr_con,$_REQUEST['sale_invoice_date']),'y');
				$mfd_date=dateFormat(mysqli_real_escape_string($mr_con,$_REQUEST['mfd_date']),'y');
				$inst_date=dateFormat(mysqli_real_escape_string($mr_con,$_REQUEST['install_date']),'y');
				$no_of_banks=mysqli_real_escape_string($mr_con,$_REQUEST['no_of_banks']);
				$fl_name=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['fl_name']));
				$fl_number=mysqli_real_escape_string($mr_con,$_REQUEST['fl_number']);
				$sl_name=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['sl_name']));
				$sl_number=mysqli_real_escape_string($mr_con,$_REQUEST['sl_number']);
				$sl_email=strtolower(mysqli_real_escape_string($mr_con,$_REQUEST['sl_email']));
				$segment_alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['segment_alias']));
				$site_type=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_type']));
				$cust_name=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['cust_name']));
				$product_code=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['product_alias']));
				$battery_bank_rating=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['battery_bank_rating']));
				$site_address=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_address']));
				$po_number=$po_date=$po_link='';
				if(empty($activity_alias))$res="Select Activity";
				else{ $at_check='1';
					$activity_type=alias($activity_alias,'ec_activity','activity_alias','activity_type');
					$activity_code=alias($activity_alias,'ec_activity','activity_alias','activity_code');
					if($activity_type=='0'){
						$po_number = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['po_number']));
						$po_date = dateFormat(mysqli_real_escape_string($mr_con,$_REQUEST['po_date']),'y');
						if(empty($po_number)){$at_check="Enter Service PO Number for AT or I&C";}
						elseif(empty($po_date) || $po_date=='NA'){$at_check="Choose Service PO Date for AT or I&C";}
						else{
							if(isset($_FILES['po_file']) && !empty($_FILES['po_file']['name'])){
								$po_file=$_FILES['po_file'];
								$p_link = upload_file($po_file,str_replace("&","_N_",$activity_code).'_PO_FILE','pdf');
								list($po_code,$po_msg) = explode(",",$p_link);
								if($po_code=='0'){
									$po_link = $po_msg;
								}else $at_check = $po_msg;
							}else $at_check = "Please Choose PO File";
						}
					}
					if($at_check!='1'){$res=$at_check;}
					elseif(empty($site_alias))$res="Select Site ID";
					elseif(empty($site_id))$res="Enter Site ID";
					elseif(empty($zone))$res="Enter Zone Name";
					elseif(empty($state))$res="Enter State Name";
					elseif(empty($district))$res="Enter District Name";
					elseif(empty($segment_alias))$res="Enter Segment Name";
					elseif(empty($cust_name))$res="Enter Customer Name";
					elseif(empty($product_code))$res="Enter Product Code";
					elseif(empty($site_name))$res="Enter Site Name";
					elseif(empty($site_address))$res="Enter Site Address";
					elseif(empty($fl_name))$res="Enter First Level Contact Name";
					elseif(empty($fl_number))$res="Enter First Level Contact Number";
					elseif(empty($sl_name))$res="Enter Second Level Contact Name";
					elseif(empty($sl_number))$res="Enter Second Level Contact Number";
					elseif(empty($sl_email))$res="Enter Second Level Contact Mail";
					elseif($faulty_cell_count=='')$res="Enter Faulty Cell Count";
					elseif(empty($complaint_alias))$res="Select Complaint";
					elseif(empty($mode_of_contact))$res="Select Mode Of Complaint";
					elseif(empty($description))$res="Enter Description";
					else{
						if($activity_type!='2'){ // NOT OTHER
							if(empty($po_num))$res="Enter Sale PO Number";
							elseif(empty($sale_invoice_num))$res="Enter Sale Invoice Number Name";
							elseif(empty($sale_invoice_date) || $sale_invoice_date=='NA')$res="Enter Sale Invoice Date";
							elseif(empty($mfd_date) || $mfd_date=='NA')$res="Enter Manufacturing Date";
							elseif(empty($inst_date) || $inst_date=='NA')$res="Enter Installation Date";
							elseif(empty($no_of_banks))$res="Enter No of Banks";
							elseif(empty($site_type))$res="Enter Site Type";
							elseif(empty($battery_bank_rating))$res="Enter  Battery Bank Rating";
							else $res="";
						}else $res="";
						if(empty($res)){
							$moc_pdf=alias($mode_of_contact,'ec_moc','moc_alias','moc_file');
							$moc_text=alias($mode_of_contact,'ec_moc','moc_alias','moc_text');
							$moc_file=$moc_num=$res = "";
							if($moc_pdf=='1'){
								if(isset($_FILES['moc_file']) && !empty($_FILES['moc_file']['name'])){
									$moc_file=$_FILES['moc_file'];
								}else{$res = "Please Choose ".alias($mode_of_contact,'ec_moc','moc_alias','moc_name')." File";}
							}
							if($moc_text=='1'){
								if(isset($_REQUEST['moc_number']) && !empty($_REQUEST['moc_number'])){
									$moc_num=mysqli_real_escape_string($mr_con,$_REQUEST['moc_number']);
								}else{$res = "Please Enter".alias($mode_of_contact,'ec_moc','moc_alias','moc_name')." File";}
							}
							if(empty($res)){
								if(mysqli_num_rows(mysqli_query($mr_con,"SELECT id FROM ec_tickets WHERE site_alias ='$site_alias' AND activity_alias='$activity_alias' AND level<>'6' AND level<>'7' AND flag='0'"))==0){
									if($activity_type=='2' || mysqli_num_rows(mysqli_query($mr_con,"SELECT id FROM ec_sitemaster WHERE site_id ='$site_id' AND product_alias LIKE '%$product_code%' AND customer_alias='$cust_name' AND state_alias='$state' AND flag='0'"))==0){
										$query1=mysqli_query($mr_con,"UPDATE ec_sitemaster SET zone_alias='$zone',state_alias='$state',district_alias='$district',segment_alias='$segment_alias',customer_alias='$cust_name',site_type_alias='$site_type',site_id='$site_id',site_name='$site_name',product_alias='$product_code',battery_bank_rating='$battery_bank_rating',po_num='$po_num',sale_invoice_num='$sale_invoice_num',sale_invoice_date='$sale_invoice_date',mfd_date='$mfd_date',install_date='$inst_date',no_of_string='$no_of_banks',technician_name='$fl_name',technician_number='$fl_number',manager_name='$sl_name',manager_number='$sl_number',manager_mail='$sl_email',site_address='$site_address',flag='0' WHERE site_alias='$site_alias' AND flag='1'");
										$ticket_id = ticketsID($site_alias,alias(alias($site_alias,'ec_sitemaster','site_alias','state_alias'),'ec_state','state_alias','state_code'),1);
										$num=alias($site_alias,'ec_sitemaster','site_alias','technician_number');
										//$msg="Greetings from Enersys, your complaint has been registered against the ".$activity_code." of Site name-".alias($site_alias,'ec_sitemaster','site_alias','site_name')." Ticket No- ".$ticket_id;
										$msg="GREETINGS FROM ENERSYS, YOUR COMPLAINT HAS BEEN REGISTERED AGAINST THE AT OF SITE NAME-".alias($site_alias,'ec_sitemaster','site_alias','site_name')." Ticket No- ".$ticket_id;

										$old_tt=alias_flag_none($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
										$action="Spot and Site Not Available Ticket - ".$old_tt." Converted to ".$ticket_id." Successfully";
										$tt_warranty=sitemanfdate_check($site_alias);
										$notif_msg="Dear Team, New Complaint has been registered against the $activity_code of Site name-".alias($site_alias,'ec_sitemaster','site_alias','site_name')." Ticket No- $ticket_id in your State.";
										if(!empty($moc_file)){
											$link = upload_file($moc_file,str_replace(" ","_",alias($mode_of_contact,'ec_moc','moc_alias','moc_name')),'pdf');
											list($code,$msg1) = explode(",",$link);
											if($code=='0'){ $contact_link = $msg1;
												$sql = mysqli_query($mr_con,"UPDATE ec_tickets SET ticket_id='$ticket_id',activity_alias='$activity_alias',site_alias='$site_alias',complaint_alias='$complaint_alias',faulty_cell_count='$faulty_cell_count',mode_of_contact='$mode_of_contact',contact_link='$contact_link',moc_num='$moc_num',description='$description',level='3',n_visits=(n_visits+1),warranty='$tt_warranty',po_number='$po_number',po_date='$po_date',po_link='$po_link',flag='0' WHERE ticket_alias='$ticket_alias' AND flag='1'");
												if($sql){
													$sql_inv = mysqli_query($mr_con,"INSERT INTO ec_tickets_inventory(ticket_alias)VALUES('$ticket_alias')");
													ticket_notification($ticket_alias,$notif_msg);
													user_history($emp_alias,$action,$_REQUEST['ip_addr']);
													/*
													messageSent($num,$msg);
													zoneMsg($activity_code,$site_alias,$ticket_id);
													*/
													$site_alias=alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
													$state_alias=alias($site_alias,'ec_sitemaster','site_alias','state_alias');
													ecSendSms('new_tt_registration', $state_alias, $num, $msg);
													curlxing(baseurl()."services/tickets/mails/new_ticket_mail?site_alias=".$site_alias."&ticket_alias=".$ticket_alias);
													$resCode='0'; $resMsg="Successful ".$ticket_id." Ticket Created";
												}
											}else{$res = $msg1.', Try again!';}
										}else{
											$contact_link='0';
											$sql = mysqli_query($mr_con,"UPDATE ec_tickets SET ticket_id='$ticket_id',activity_alias='$activity_alias',site_alias='$site_alias',complaint_alias='$complaint_alias',faulty_cell_count='$faulty_cell_count',mode_of_contact='$mode_of_contact',contact_link='$contact_link',moc_num='$moc_num',description='$description',level='3',n_visits=(n_visits+1),warranty='$tt_warranty',po_number='$po_number',po_date='$po_date',po_link='$po_link',flag='0' WHERE ticket_alias='$ticket_alias' AND flag='1'");
											if($sql){
												$sql_inv = mysqli_query($mr_con,"INSERT INTO ec_tickets_inventory(ticket_alias)VALUES('$ticket_alias')");
												ticket_notification($ticket_alias,$notif_msg);
												user_history($emp_alias,$action,$_REQUEST['ip_addr']);
												/*
												messageSent($num,$msg);
												zoneMsg($activity_code,$site_alias,$ticket_id);
												*/
												$site_alias=alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
												$state_alias=alias($site_alias,'ec_sitemaster','site_alias','state_alias');
												ecSendSms('new_tt_registration', $state_alias, $num, $msg);
												curlxing(baseurl()."services/tickets/mails/new_ticket_mail?site_alias=".$site_alias."&ticket_alias=".$ticket_alias);
												$resCode='0'; $resMsg="Successful ".$ticket_id." Ticket Created";
											}
										}
										if(!empty($old_tt))$dpr_update=mysqli_query($mr_con,"UPDATE ec_dpr SET ticket_alias='$ticket_alias' WHERE ticket_alias='$old_tt' AND flag='0'");
										if($sql && !empty($ticket_alias) && $segment_alias=="HXL5A1HOTZ")file_get_contents(baseurl()."mobile_app/efsr_submit_mail.php?ticketAlias=".$ticket_alias);
										if(isset($_REQUEST['remarks']) && !empty($_REQUEST['remarks'])){
											$remarks = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['remarks']));
											$rem_alias=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
											$sqlRem = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','TT','3','$ticket_alias','$emp_alias','$rem_alias')");
										}
										if(isset($_REQUEST['at_ic_rem']) && !empty($_REQUEST['at_ic_rem'])){
											$at_ic_rem = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['at_ic_rem']));
											$rem_alias2=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
											$sqlRem2 = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$at_ic_rem','TT','4','$ticket_alias','$emp_alias','$rem_alias2')");
										}
									}else{$res = 'The Requested SiteID and State and Customer and Product has already exist, Please check Site available OR Try with other values'; }
								}else{$res = 'The Requested SiteID and activity has already exist, Try with other values'; }
							}
						}
					}
				}
			}
		}else{
			//Offline Spot
			//Update site visit details in Tickets and delete temp ticket details with flag 2
			//Update Site master only customer details like email
			$rtt_alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['reqticket_alias']));
			if(empty($rtt_alias))$res="Please Select Ticket Number";
			else{ $cu = "";
				$tbl_nms=array("ec_fsr_faulty_cells","ec_fork_lift","ec_battery_details","ec_charger_details","ec_ticket_action","ec_coach_history","ec_check_points","ec_equip_details","ec_other_issues","ec_no_of_banks","ec_physical_observation","ec_technical_observation","ec_general_observation","ec_power_observation","ec_battery_bank_bb_cap","ec_engineer_observation","ec_customer_comments","ec_customer_satisfaction","ec_e_signature");
				foreach($tbl_nms as $tbl)$sql=mysqli_query($mr_con,"UPDATE $tbl SET ticket_alias='$rtt_alias' WHERE ticket_alias='$ticket_alias' AND flag=0");
				$sql2=mysqli_query($mr_con,"UPDATE ec_remarks SET item_alias='$rtt_alias' WHERE item_alias='$ticket_alias' AND flag=0");
				$site_alias = alias($rtt_alias,'ec_tickets','ticket_alias','site_alias');
				$segment_alias = alias($site_alias,'ec_sitemaster','site_alias','segment_alias');
				$email = alias($rtt_alias,'ec_e_signature','ticket_alias','email');
				$contact_number = alias($rtt_alias,'ec_e_signature','ticket_alias','contact_number');
				if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){$cu = "manager_mail='$email', ";}
				if(!empty($contact_number)){$cu .= "manager_number='$contact_number', ";}
				$e_customer_sql = mysqli_query($mr_con,"UPDATE ec_sitemaster SET $cu flag='0' WHERE site_alias='$site_alias' AND flag='0'");
				$efsr_no = alias_flag_none($ticket_alias,'ec_tickets','ticket_alias','efsr_no');
				$efsr_start = alias_flag_none($ticket_alias,'ec_tickets','ticket_alias','efsr_start');
				$efsr_date = alias_flag_none($ticket_alias,'ec_tickets','ticket_alias','efsr_date');
				$closing_date = alias_flag_none($ticket_alias,'ec_tickets','ticket_alias','closing_date');
				$update = mysqli_query($mr_con,"UPDATE ec_tickets SET level='3',old_level='2',status='VISITED',closing_date='".$closing_date."',tat='".tat($rtt_alias)."',efsr_no='".$efsr_no."',efsr_start='".$efsr_start."',efsr_date='".$efsr_date."',transaction_date='".date('Y-m-d')."',n_visits=(n_visits+1) WHERE ticket_alias='$rtt_alias' AND flag='0'");
				if($update){
					$ticket_id=alias($rtt_alias,'ec_tickets','ticket_alias','ticket_id');
					$serNum=alias(alias($rtt_alias,'ec_tickets','ticket_alias','service_engineer_alias'),'ec_employee_master','employee_alias','mobile_number');
					$custNum=alias(alias($rtt_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','technician_number');
					$custMsg="Greetings from Enersys, Against Ticket No-".$ticket_id." SE Mob-".$serNum." has completed the Site visit and status will be updated Shortly.";
					$state_alias=alias($site_alias,'ec_sitemaster','site_alias','state_alias');
					ecSendSms('job_done_with_efsr', $state_alias, $custNum, $custMsg);
					/*
					messageSent($custNum,$custMsg);
					*/
					if(!empty($faulty_cell_sr_no))$acc_inv = mysqli_query($mr_con,"UPDATE ec_tickets_inventory SET material_inward='1' WHERE ticket_alias='$ticket_alias' AND flag='0'");
					$old_tt = alias_flag_none($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
					$action="Offline Spot Ticket - ".$old_tt." Converted to ".alias($rtt_alias,'ec_tickets','ticket_alias','ticket_id')." Successfully";
					if(!empty($old_tt))$dpr_update=mysqli_query($mr_con,"UPDATE ec_dpr SET ticket_alias='$rtt_alias' WHERE ticket_alias IN('$ticket_alias','$old_tt') AND flag='0'");
					$msgg="e-FSR of Ticket No-".$ticket_id." against the Activity ".$mssg_activity_name." of Site name-".$mssg_site_name." awaiting for your Approval.";
					ticket_notification($rtt_alias,$msgg);
					user_history($emp_alias,$action,$_REQUEST['ip_addr']);
					if(!empty($rtt_alias) && $segment_alias=="HXL5A1HOTZ")file_get_contents(baseurl()."mobile_app/efsr_submit_mail.php?ticketAlias=".$rtt_alias);
					$sql1=mysqli_query($mr_con,"DELETE FROM ec_tickets WHERE ticket_alias='$ticket_alias' AND flag='2'");
					$resCode='0'; $resMsg='Successfully Updated';
				}else{$res="Error In Updating";}
			}
		}if(isset($res) && !empty($res)){$resCode='4'; $resMsg=$res;}
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function tt_sitename_drop(){
	//$emp_alias=$_REQUEST['emp_alias']; $token=$_REQUEST['token'];
	//$rex=authentication($emp_alias,$token);
	//if($rex==0){
		$result['site_name']=alias_flag_none(alias_flag_none($_REQUEST['alias'],'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','site_name');
		//$resCode='0'; $resMsg='Successful!';
	//}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	//}else{$resCode='2'; $resMsg='Account Locked';
	//}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function delete_spotticket() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	$grantable = grantable('DELETE','SPOT TICKETS',$emp_alias);
	if(!$grantable){
		$resCode = 1;
		$resMsg='Authentication Failed!';
	}
	if($grantable && $rex==0) {
		
		$ticket_id = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['ticket_id'])));
		$ticket_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['ticket_alias'])));
		$remarks = mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks']));
		if(empty($remarks)){$res="Provide remarks";}
		else if(empty($ticket_id) || empty($ticket_alias)){$res="Invalid Request";}
		else {
			$cond = " ticket_id = '$ticket_id' AND ticket_alias = '$ticket_alias'";
			$query = "SELECT id FROM ec_tickets WHERE $cond AND flag = 9";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql)=='0') {
				$query = "UPDATE ec_tickets SET flag = '9' WHERE $cond";
				$sql = mysqli_query($mr_con, $query);
				if($sql){
					$action = "SPOT Ticket with ID $ticket_id Deleted";
					user_history($emp_alias,$action,$_REQUEST['ip_addr'], $remarks);
					$resCode='0';$resMsg='Successful!';
				}
			}else{$res = 'Failed to delete Ticket'; }
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function delete_ticket() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	$grantable = grantable('DELETE','TICKETS',$emp_alias);
	if(!$grantable) {
		$resCode = 1;
		$resMsg='Authentication Failed!';
	}
	if($grantable && $rex==0) {
		
		$ticket_id = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['ticket_id'])));
		$ticket_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['ticket_alias'])));
		$remarks = mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks']));
		if(empty($remarks)){$res="Provide remarks";}
		else if(empty($ticket_id) || empty($ticket_alias)){$res="Invalid Request";}
		else {
			$cond = " ticket_id = '$ticket_id' AND ticket_alias = '$ticket_alias'";
			$query = "SELECT * FROM ec_tickets WHERE $cond AND flag = 0";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql)==1) {
				$ticketDetails = mysqli_fetch_array($sql);
				/* Updating of n_visits starts here*/
				$nVisit = $ticketDetails['n_visits'];
				list($ticketCommon, $id) = explode("|", $ticket_id);
				$hQCond = "";
				if(strpos($ticketCommon, '-') === false) {
					$hQCond = " and ticket_id not like '%-%'"; 
				}
				$hQ = "SELECT SUBSTRING_INDEX(ticket_id,'|',1) AS ticket_idx, max(n_visits) as n_visits FROM `ec_tickets` where ticket_id like '%{$ticketCommon}%' $hQCond GROUP BY ticket_idx";
				$hQSql = mysqli_query($mr_con, $hQ);
				$highestVisitsDetails = mysqli_fetch_array($hQSql);
				$n_visits = $highestVisitsDetails['n_visits'];
				if($n_visits>1) {
					$updateQuery = "UPDATE ec_tickets set n_visits = `n_visits` - 1 where n_visits>= $nVisit and ticket_id like '%{$ticketCommon}%' $hQCond";
					$updateSql = mysqli_query($mr_con, $updateQuery);
				}
				/* Updating of n_visits ends here*/
				
				$query = "UPDATE ec_tickets SET flag = '9' WHERE $cond";
				$sql = mysqli_query($mr_con, $query);
				$query2 = "UPDATE ec_remarks SET flag = '9' WHERE item_alias = '$ticket_alias' and module = 'TT' and bucket in ('7','8')";
				$sql2 = mysqli_query($mr_con, $query2);
				if($sql){
					$action = "Ticket with ID $ticket_id Deleted";
					user_history($emp_alias,$action,$_REQUEST['ip_addr'], $remarks);
					$resCode='0';$resMsg='Successful!';
				}
			}else{$res = 'Failed to delete Ticket'; }
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function emp_efsr_tickets() {

	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	// $employee_alias = mysqli_real_escape_string($mr_con,$_REQUEST['employee_alias']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk = authentication($emp_alias, $token);
	$resultSet = [];
	$validLevel = "2";
	$notValidStatus = "'CLOSED', 'DECLINED'";

	if($chk == 0) {
		$query = "SELECT t.ticket_id, t.ticket_alias, t.status, t.level, t.old_level, t.service_engineer_alias, em.name as service_engineer_name, sm.segment_alias FROM ec_tickets as t, ec_employee_master as em, ec_sitemaster as sm WHERE t.status not in ($notValidStatus) AND t.level in ($validLevel) AND t.service_engineer_alias = em.employee_alias AND t.site_alias = sm.site_alias order by t.ticket_id";
		
		$sql = mysqli_query($mr_con, $query);
		$numOfRows = mysqli_num_rows($sql);
		if($numOfRows > 0) {
			$i = 0;
			while($eachTicket = mysqli_fetch_array($sql)) {
				$resultSet[$i]['ticket_id'] = $eachTicket['ticket_id'];
				$resultSet[$i]['ticket_alias'] = $eachTicket['ticket_alias'];
				$resultSet[$i]['service_engineer_alias'] = $eachTicket['service_engineer_alias'];
				$resultSet[$i]['service_engineer_name'] = $eachTicket['service_engineer_name'];
				$resultSet[$i]['status'] = $eachTicket['status'];
				$resultSet[$i]['level'] = $eachTicket['level'];
				$resultSet[$i]['old_level'] = $eachTicket['old_level'];
				$resultSet[$i]['segment_name']=alias($eachTicket['segment_alias'],'ec_segment','segment_alias','segment_name');
				$i++;
			}
			$resCode = '0';
		}
	} elseif($rex==1) {
		$resCode='1';
		$resMsg='Authentication Failed!';
	} else {
		$resCode='2';
		$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode; 
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	$result['result'] = $resultSet;
	echo json_encode($result);
}

function map_efsr_tickets() {

	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$changeEfsr = $_REQUEST['changeEfsr'];
	$chk = authentication($emp_alias, $token);
	$resultSet = [];
	if($chk == 0) {
		$tablesToUpdate = ["ec_charger_details", "ec_fork_lift", "ec_battery_details", "ec_ticket_action",
		"ec_coach_history", "ec_check_points", "ec_equip_details", "ec_other_issues", 
		"ec_no_of_banks", "ec_physical_observation", "ec_technical_observation", 
		"ec_general_observation", "ec_power_observation", "ec_battery_bank_bb_cap", "ec_engineer_observation", "ec_customer_comments", "ec_customer_satisfaction", "ec_e_signature"];
		$updated = false;
		foreach($changeEfsr as $eachEfsr) {
			$exEfsr = $eachEfsr['existing_efsr'];
			$mapEfsr = $eachEfsr['mapped_efsr'];
			if($exEfsr && $mapEfsr) {
				$exEfsrQuery = "select ticket_id, ticket_alias, service_engineer_alias, efsr_no, efsr_start, efsr_date, esca_efsr_link from ec_tickets where ticket_alias = '$exEfsr'";
				$exEfsrSql = mysqli_query($mr_con, $exEfsrQuery);
				$exEfsrDetails = mysqli_fetch_array($exEfsrSql);
				$mapEfsrQuery = "select ticket_id, ticket_alias from ec_tickets where ticket_alias = '$mapEfsr'";
				$mapEfsrSql = mysqli_query($mr_con, $mapEfsrQuery);
				$mapEfsrDetails = mysqli_fetch_array($mapEfsrSql);
				if($exEfsrDetails && $mapEfsrDetails) {
					$updated = true;
					foreach($tablesToUpdate as $eachTable) {
						$query = "UPDATE $eachTable SET ticket_alias = '$mapEfsr' WHERE ticket_alias='$exEfsr' AND flag='0'";
						$mapEfsrSql = mysqli_query($mr_con, $query);
					}
					$query = "UPDATE ec_tickets SET level='2', old_level='1', efsr_no='', efsr_start='', efsr_date='', closing_date='', tat='', status='OPEN', esca_efsr_link = '' WHERE ticket_alias='$exEfsr'";
					$mapEfsrSql = mysqli_query($mr_con, $query);
					$query2 = "UPDATE ec_remarks SET item_alias = '$mapEfsr' WHERE item_alias = '$exEfsr' ";
					mysqli_query($mr_con, $query2);
					$query = "UPDATE ec_tickets SET efsr_no = '".$exEfsrDetails['efsr_no']."',  efsr_start = '".$exEfsrDetails['efsr_start']."', efsr_date = '".$exEfsrDetails['efsr_date']."', esca_efsr_link = '".$exEfsrDetails['esca_efsr_link'] ."', service_engineer_alias = '". $exEfsrDetails['service_engineer_alias'] ."', status = 'VISITED', level = '3', old_level = '2', n_visits=(n_visits+1) WHERE ticket_alias = '$mapEfsr'";
					$mapEfsrSql = mysqli_query($mr_con, $query);
				}
			}
		}
		if($updated) {
			$resCode='0';
			$resMsg='Updated Successfully';
		} else {
			$resCode='4';
			$resMsg='Failed to Update!';
		}
	} elseif($rex==1) {
		$resCode='1';
		$resMsg='Authentication Failed!';
	} else {
		$resCode='2';
		$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode; 
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	$result['result'] = $resultSet;
	echo json_encode($result);
}

function efsr_details() {

	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$ip_addr = mysqli_real_escape_string($mr_con,$_REQUEST['ip_addr']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$ticket_id = mysqli_real_escape_string($mr_con, $_REQUEST['ticket_id']);
	$chk = authentication($emp_alias, $token);
	$resultSet = [];
	if($chk == 0) {
		$query = "SELECT * FROM ec_tickets WHERE ticket_id = '$ticket_id'";
		$tktDetailsSql = mysqli_query($mr_con, $query);
		$tktDetails = mysqli_fetch_array($tktDetailsSql);
		$ticket_alias = $tktDetails['ticket_alias'];

		// Physical Observation
		$physicalObservations = getPhysicalObservations($ticket_alias);
		$charger_details = getChargerDetails($ticket_alias);
		$forklift_details = getForkLiftDetails($ticket_alias);
		$service_eng_observation = serviceEngObservation($ticket_alias);
		$customer_comments = customerComments($ticket_alias);
		
		$resultSet = [
			'physical_observation' => $physicalObservations,
			'charger_details' => $charger_details,
			'forklift_details' => $forklift_details,
			'service_eng_observation' => $service_eng_observation,
			'customer_comments' => $customer_comments,
		];
		$resCode='0';
		$resMsg='Successful!';
	} elseif($chk==1) {
		$resCode='1';
		$resMsg='Authentication Failed!';
	} else {
		$resCode='2';
		$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode; 
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	$result['result'] = $resultSet;
	echo json_encode($result);
}

function delete_ticket_efsr() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	$grantable = grantable('DELETE','TICKETS',$emp_alias);
	if(!$grantable) {
		$resCode = 1;
		$resMsg='Authentication Failed!';
	}
	if($grantable && $rex==0) {
		
		$ticket_id = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['ticket_id'])));
		$ticket_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['ticket_alias'])));
		$remarks = mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks']));
		if(empty($remarks)){$res="Provide remarks";}
		else if(empty($ticket_id) || empty($ticket_alias)){$res="Invalid Request";}
		else {
			$cond = " ticket_id = '$ticket_id' AND ticket_alias = '$ticket_alias'";
			$query = "SELECT id FROM ec_tickets WHERE $cond AND flag = 9";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql)=='0') {
				
				$bb_item=alias($ticket_alias,'ec_battery_bank_bb_cap','ticket_alias','item_alias');
				if(!empty($bb_item)){
					$sql2 = mysqli_query($mr_con,"DELETE FROM ec_bo_headers WHERE item_alias='$bb_item' AND flag='0'");
					$sql3 = mysqli_query($mr_con,"DELETE FROM ec_bo_telecom_ic WHERE battery_bb_alias='$bb_item' AND flag='0'");
					$sql4 = mysqli_query($mr_con,"DELETE FROM ec_bo_motive_ic WHERE battery_bb_alias='$bb_item' AND flag='0'");
				}
				$arr=array("ec_charger_details","ec_fork_lift","ec_battery_details","ec_ticket_action","ec_coach_history","ec_check_points","ec_equip_details","ec_other_issues","ec_no_of_banks","ec_physical_observation","ec_technical_observation","ec_general_observation","ec_power_observation","ec_battery_bank_bb_cap","ec_engineer_observation","ec_customer_comments","ec_customer_satisfaction","ec_e_signature");
				foreach($arr as $tbl) {
					$query = "DELETE from $tbl WHERE ticket_alias='$ticket_alias'";
					$sql = mysqli_query($mr_con, $query);
				}
				$updateQuery = "UPDATE ec_tickets SET level='2', old_level='1',efsr_no='',efsr_start='',efsr_date='',closing_date='',tat='',status='OPEN',n_visits=(n_visits-1) WHERE ticket_alias='$ticket_alias'";
				$sql1 = mysqli_query($mr_con, $updateQuery);
				$query2 = "UPDATE ec_remarks SET flag = '9' WHERE item_alias = '$ticket_alias' and module = 'TT' and bucket in ('7','8')";
				$sql2 = mysqli_query($mr_con, $query2);
				if($sql){
					$action = "Ticket EFSR with ticket ID $ticket_id Deleted";
					user_history($emp_alias,$action,$_REQUEST['ip_addr'], $remarks);
					$resCode='0';$resMsg='Successful!';
				}
			}else{
				$res = 'Failed to delete Ticket'; 
			}
		}
		if(isset($res)) {
			$resCode='4';$resMsg=$res;
		}
	}elseif($rex==1){
		$resCode='1';$resMsg='Authentication Failed!';
	}else{
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

?>