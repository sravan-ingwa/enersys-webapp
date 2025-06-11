<?php
date_default_timezone_set("Asia/Kolkata");
require '../Slim/Slim.php';
include ('../mysql.php');
include ('../functions.php');
require('../Classes/PHPExcel.php');
require('../Classes/PHPExcel/IOFactory.php');
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->post('/ticket_add','ticket_add');
$app->post('/ticket_mul_view','ticket_mul_view');
$app->post('/ticket_view','ticket_view');
$app->post('/ticket_export','ticket_export');
$app->post('/onlineTickets','onlineTickets');
$app->post('/online_ticket_add','online_ticket_add');
$app->post('/sitemanfdate','sitemanfdate');
$app->post('/sitemaster_view','sitemaster_view');
$app->post('/sitemaster_mul_view','sitemaster_mul_view');
$app->post('/sitemaster_export','sitemaster_export');
//Dashboard
$app->post('/yogzkmi_fun','yogzkmi_fun');
$app->post('/ticket_status','ticket_status');
$app->post('/today_info_report_block','today_info_report_block');
$app->post('/nature_of_activity','nature_of_activity');
$app->run();
function yogzkmi_fun(){
	global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){ $s_temp=array();
		$q0=mysqli_query($mr_con,"SELECT state_alias FROM ec_sitemaster WHERE customer_alias='$emp_alias' AND flag='0'");
		if(mysqli_num_rows($q0)>'0'){while($r0=mysqli_fetch_array($q0)){$s_temp[]=$r0['state_alias'];}}
		$c1="state_alias IN ('".implode("','", array_unique($s_temp))."') AND state_name<>'FACTORY' AND ";
		$q1=mysqli_query($mr_con,"SELECT state_name as name,state_alias as alias FROM ec_state WHERE $c1 flag='0' ORDER BY name");
		//$q2=mysqli_query($mr_con,"SELECT customer_code as name,customer_alias as alias FROM ec_customer WHERE flag='0' ORDER BY name");
		$q3=mysqli_query($mr_con,"SELECT segment_name as name,segment_alias as alias FROM ec_segment WHERE flag='0' ORDER BY name");
		$q4=mysqli_query($mr_con,"SELECT description as name,faulty_alias as alias FROM ec_faulty_code WHERE flag='0' ORDER BY name");
		$q5=mysqli_query($mr_con,"SELECT activity_code as name,activity_alias as alias FROM ec_activity WHERE flag='0' ORDER BY name");
		if(mysqli_num_rows($q1)>'0'){$x=0;while($r1=mysqli_fetch_array($q1)){$result['ss'][$x]['name']=$r1['name'];$result['ss'][$x]['alias']=$r1['alias'];$x++;}}else{$result['ss'][0]['name']="No Records";$result['ss'][0]['alias']="0";}
		//if(mysqli_num_rows($q2)>'0'){$x=0;while($r1=mysqli_fetch_array($q2)){$result['cs'][$x]['name']=$r1['name'];$result['cs'][$x]['alias']=$r1['alias'];$x++;}}else{$result['cs'][0]['name']="No Records";$result['cs'][0]['alias']="0";}
		if(mysqli_num_rows($q3)>'0'){$x=0;while($r1=mysqli_fetch_array($q3)){$result['ses'][$x]['name']=$r1['name'];$result['ses'][$x]['alias']=$r1['alias'];$x++;}}else{$result['ses'][0]['name']="No Records";$result['ses'][0]['alias']="0";}
		if(mysqli_num_rows($q4)>'0'){$x=0;while($r1=mysqli_fetch_array($q4)){$result['fs'][$x]['name']=$r1['name'];$result['fs'][$x]['alias']=$r1['alias'];$x++;}}else{$result['fs'][0]['name']="No Records";$result['fs'][0]['alias']="0";}
		if(mysqli_num_rows($q5)>'0'){$x=0;while($r1=mysqli_fetch_array($q5)){$result['acs'][$x]['name']=$r1['name'];$result['acs'][$x]['alias']=$r1['alias'];$x++;}}else{$result['acs'][0]['name']="No Records";$result['acs'][0]['alias']="0";}
		for($c=14;$c<=date('y');$c++){
			$result['yrr'][$c-14]['name']="20".$c."-".($c+1);
			$result['yrr'][$c-14]['alias']=$c;
		}
	}
	echo json_encode($result);
}
function online_ticket_add(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = $_REQUEST['emp_alias']; $token = $_REQUEST['token'];$ip=$_REQUEST['ip_addr'];
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
			$site_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_alias']));
			if(empty($activity_alias)){$res="Select Activity";}
			elseif(empty($site_alias)){$res="Select Site ID";}
			elseif($site_alias=='NA'){$res="Select Under Warranty Site ID";}
			elseif($faulty_cell_count==''){$res="Enter Faulty Cell Count";}
			elseif(empty($complaint_alias)){$res="Select Complaint";}
			elseif(empty($description)){$res="Enter Description";}
			else{
				$query=mysqli_query($mr_con,"SELECT id FROM ec_tickets WHERE site_alias ='$site_alias' AND activity_alias='$activity_alias' AND level<>'6' AND level<>'7' AND flag='0'");
				if(mysqli_num_rows($query)==0){
					$tt_sql = mysqli_query($mr_con,"INSERT INTO ec_tickets(ticket_id,activity_alias,site_alias,complaint_alias,mode_of_contact,faulty_cell_count,description,login_date,level,status,ticket_alias)VALUES('$ticket_id','$activity_alias','$site_alias','$complaint_alias','".alias('1','ec_moc','moc_type','moc_alias')."','$faulty_cell_count','$description','".date('Y-m-d h:i:s A')."','0','Open','$ticket_alias')");
					if($tt_sql){
						$action = "Customer Create the ticket against Site Name - ".alias($site_alias,'ec_sitemaster','site_alias','site_name');
						user_history($emp_alias,$action,$ip);
						$resCode='0'; $resMsg="Request Taken Successfully, Ticket Number will receive to you Shortly.";
					}else{$res = 'Sorry Try Again';}
				}else{$res = 'The Requested SiteID and activity has already exist, Try with other values'; }
			}
		}/*else{
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
					$tt_sql = mysqli_query($mr_con,"INSERT INTO ec_tickets(ticket_id,activity_alias,site_alias,complaint_alias,mode_of_contact,faulty_cell_count,description,login_date,level,status,ticket_alias)VALUES('$ticket_id','$activity_alias','$site_alias','$complaint_alias','ONLINE','$faulty_cell_count','$description','".date('Y-m-d h:i:s A')."','0','Open','$ticket_alias')");
					if($site_sql && $tt_sql){
						$action = "Customer Create the ticket and siteID against Site Name - $site_name";
						user_history($emp_alias,$action,$ip);
						$resCode='0'; $resMsg="Request Taken Successfully, Ticket Number will receive to you Shortly.";
					}else{$res = 'Sorry Try Again';}
				}else{$res = 'The Requested SiteID and State has already exist, Try with other values'; }
			}
		}*/if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function ticket_add(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = $_REQUEST['emp_alias']; $token = $_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$alias = aliasCheck(generateRandomString(),'ec_tickets','ticket_alias');
		$ticket_id = ticketsID(alias($_REQUEST['site_alias'],'ec_sitemaster','site_id','site_alias'),alias(alias($_REQUEST['site_alias'],'ec_sitemaster','site_id','state_alias'),'ec_state','state_alias','state_code'),1);
		$activity_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['activity_alias']));
		$site_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_alias']));
		$complaint_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['complaint_alias']));
		$mode_of_contact = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mode_of_contact']));
		$description = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['description']));
		$faulty_cell_count = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['faulty_cell_count']));
		if($activity_alias==''){$res="Select Activity";}
		elseif($site_alias==''){$res="Select Site ID";}
		elseif($faulty_cell_count==''){$res="Enter Faulty Cell Count";}
		elseif($complaint_alias==''){$res="Select Complaint";}
		elseif($mode_of_contact==''){$res="Select Mode Of Complaint";}
		elseif(empty($description)){$res="Enter Description";}
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
					$msg=urlencode( "Greetings from Enersys, your complaint has been registered against the ".alias($activity_alias,'ec_activity','activity_alias','activity_name')." of Site name-".alias($site_alias,'ec_sitemaster','site_alias','site_name')." Ticket No- ".$ticket_id ."");
					$action = "The ticket ID : ".$ticket_id." was created by ".alias($emp_alias,'ec_customer','customer_alias','customer_code')." customer";
					if(!empty($moc_file)){
						$link = upload_file($moc_file,str_replace(" ","_",alias($mode_of_contact,'ec_moc','moc_alias','moc_name')),'pdf');
						if($link){ $contact_link = $link;
							$sql = mysqli_query($mr_con,"INSERT INTO ec_tickets(ticket_id,activity_alias,site_alias,complaint_alias,faulty_cell_count,mode_of_contact,contact_link,moc_num,description,login_date,level,status,ticket_alias)VALUES('$ticket_id','$activity_alias','$site_alias','$complaint_alias','$faulty_cell_count','$mode_of_contact','$contact_link','$moc_num','$description','".date('Y-m-d h:i:s A')."','1','Open','$alias')");
							if($sql){
								$sql_inv = mysqli_query($mr_con,"INSERT INTO ec_tickets_inventory(ticket_alias)VALUES('$alias')");
								ticket_notification($alias,"was Created by ".alias($emp_alias,'ec_customer','customer_alias','customer_code')." customer");
								user_history($emp_alias,$action,$_REQUEST['ip_addr']);
								messageSent($num,$msg);
								zoneMsg($activity_alias,$site_alias,$ticket_id);
								new_ticket_mail($site_alias,$ticket_id);
								$resCode='0'; $resMsg="Successfully ".$ticket_id." Ticket Created";
							}
						}else{$res = 'Error in uploading Mode Of Contact, Try again!';}
					}else{
						$contact_link='0';
						$sql = mysqli_query($mr_con,"INSERT INTO ec_tickets(ticket_id,activity_alias,site_alias,complaint_alias,faulty_cell_count,mode_of_contact,contact_link,moc_num,description,login_date,level,status,ticket_alias)VALUES('$ticket_id','$activity_alias','$site_alias','$complaint_alias','$faulty_cell_count','$mode_of_contact','$contact_link','$moc_num','$description','".date('Y-m-d h:i:s A')."','1','Open','$alias')");
						if($sql){
							$sql_inv = mysqli_query($mr_con,"INSERT INTO ec_tickets_inventory(ticket_alias)VALUES('$alias')");
							ticket_notification($alias,"was Created by ".alias($emp_alias,'ec_customer','customer_alias','customer_code')." customer");
							user_history($emp_alias,$action,$_REQUEST['ip_addr']);
							messageSent($num,$msg);
							zoneMsg($activity_alias,$site_alias,$ticket_id);
							new_ticket_mail($site_alias,$ticket_id);
							$resCode='0'; $resMsg="Successfully ".$ticket_id." Ticket Created";
						}
					}
				}else{$res = 'The Requested SiteID and activity has already exist, Try with other values'; }
			}
		}if(!empty($res)){$resCode='4'; $resMsg=$res;}
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function ticket_mul_view(){  global $mr_con;
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
		}else {$c7="t1.level<>'5' AND ";}
		if($_REQUEST['tat']!="")$c8="t1.tat ='".mysqli_real_escape_string($mr_con,$_REQUEST['tat'])."' AND ";else $c8="";
		if($_REQUEST['visits']!=""){$c9="t1.n_visits = '".mysqli_real_escape_string($mr_con,$_REQUEST['visits'])."' AND ";}else{$c9="";}
		if($_REQUEST['report']!="")$c12="t1.ticket_alias IN (".report_sort($_REQUEST['report']).") AND ";else $c12="";
		if($_REQUEST['mrs']!="")$c13="t1.ticket_alias IN (".mrs_sort($_REQUEST['mrs']).") AND ";else $c13="";
		
		$cond=$c1.$c2.$c3.$c4.$c5.$c6.$c7.$c8.$c9.$c10.$c12.$c13;
		$rec=mysqli_query($mr_con,"SELECT count(DISTINCT SUBSTRING_INDEX(t1.ticket_id,'|',1)) AS totalListing FROM ec_tickets t1
		INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias
		INNER JOIN ec_customer t3 ON t2.customer_alias=t3.customer_alias
		INNER JOIN ec_segment t4 ON t2.segment_alias=t4.segment_alias
		INNER JOIN ec_activity t5 ON t1.activity_alias=t5.activity_alias
		WHERE t3.customer_alias='$emp_alias' AND $cond t1.flag='0'");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row['totalListing'];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sqlTT = mysqli_query($mr_con,"SELECT t1.ticket_alias,SUBSTRING_INDEX(t1.ticket_id,'|',1) AS ticket_idx,t1.login_date,t1.purpose,t1.planned_date,t1.level,t1.old_level,t1.status,t1.tat,t1.esca_efsr_link,t1.efsr_date,t1.efsr_no,t1.n_visits,t2.site_name,t2.site_id,t3.customer_code,t3.customer_name,t4.segment_code,t4.segment_name,t5.activity_code,t5.activity_name,t6.level_name,t6.level_color FROM ec_tickets t1
				INNER JOIN (SELECT MAX(ID) AS ID FROM ec_tickets GROUP BY SUBSTRING_INDEX(ticket_id,'|',1)) AS P ON (t1.ID=P.ID)
						INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias
						INNER JOIN ec_customer t3 ON t2.customer_alias=t3.customer_alias
						INNER JOIN ec_segment t4 ON t2.segment_alias=t4.segment_alias
						INNER JOIN ec_activity t5 ON t1.activity_alias=t5.activity_alias
						INNER JOIN ec_levels t6 ON t1.level=t6.level_alias
						WHERE t3.customer_alias='$emp_alias' AND $cond t1.flag='0' ORDER BY t1.id DESC LIMIT $offset, $limit");
			$result['ticketDetails']=array();
			if(mysqli_num_rows($sqlTT)){
				$i=0;while($rowTT = mysqli_fetch_array($sqlTT)){
					$result['ticketDetails'][$i]['ticket_alias']=$rowTT['ticket_alias'];
					$result['ticketDetails'][$i]['ticket_id']=$rowTT['ticket_idx'];//(strpos($rowTT['ticket_id'],"|")!==false ? strtok($rowTT['ticket_id'], "|") : $rowTT['ticket_id']);
					$result['ticketDetails'][$i]['login_date']=dateFormat($rowTT['login_date'],'d');
					$result['ticketDetails'][$i]['activity']=$rowTT['activity_code'];
					$result['ticketDetails'][$i]['levelcolor']=($rowTT['level']=='1' || $rowTT['level']=='2' || $rowTT['level']=='4' || $rowTT['level']=='5' ? repl_planfail_tsrej($rowTT['level'],$rowTT['old_level'],$rowTT['planned_date'],$rowTT['purpose'],'color'):$rowTT['level_color']);
					$result['ticketDetails'][$i]['levelname']=($rowTT['level']=='1' || $rowTT['level']=='2' || $rowTT['level']=='4' || $rowTT['level']=='5' ? repl_planfail_tsrej($rowTT['level'],$rowTT['old_level'],$rowTT['planned_date'],$rowTT['purpose'],'name'):$rowTT['level_name']);
					$result['ticketDetails'][$i]['pl_levelname']=($rowTT['level']=='2' ? $rowTT['planned_date']:$rowTT['level_name']);
					$result['ticketDetails'][$i]['level']=$rowTT['level'];
					$result['ticketDetails'][$i]['status']=$rowTT['status'];
					$result['ticketDetails'][$i]['tat']=(!empty($rowTT['tat']) ? $rowTT['tat'] : tat($rowTT['ticket_alias']));//checkempty($rowTT['tat']);
					$result['ticketDetails'][$i]['visits']=$rowTT['n_visits'];//visits($result['ticketDetails'][$i]['ticket_id']);
					if($rowTT['efsr_no']!=''){
						$result['ticketDetails'][$i]['efsr_date']=$rowTT['efsr_date'];
						if($rowTT['esca_efsr_link']!=''){
							$result['ticketDetails'][$i]['fsrreport']='2';
							$result['ticketDetails'][$i]['esca_efsr_link']=baseurl()."images/esca_efsr/".$rowTT['esca_efsr_link'];
						}else{
							$result['ticketDetails'][$i]['fsrreport']='1';
							$result['ticketDetails'][$i]['esca_efsr_link']=baseurl()."enersyscare_V2/pdf/?ticket_alias=".$rowTT['ticket_alias'];
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
		}$result['add']=grantable('ADD','TICKETS',$emp_alias);
		$result['export']=grantable('EXPORT','TICKETS',$emp_alias);
	}elseif($rex==1){
		$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function ticket_view(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
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
		
		$sqlTT = mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE (ticket_id LIKE '%".$ticket_id."|%' OR ticket_id = '$ticket_id') AND flag=0");
		if(mysqli_num_rows($sqlTT)){
			$i=0;while($rowTT = mysqli_fetch_array($sqlTT)){
				$site_alias = $rowTT['site_alias'];
				$ticket_alias = $rowTT['ticket_alias'];
				$result['obj'][$i]['ticket_alias']=$rowTT['ticket_alias'];
				$result['obj'][$i]['main_ticket_id']=$ticket_id;
				$result['obj'][$i]['ticket_id']=$rowTT['ticket_id'];
				$result['obj'][$i]['activity']=alias($rowTT['activity_alias'],'ec_activity','activity_alias','activity_name');
				$sqlSite = mysqli_query($mr_con,"SELECT * FROM ec_sitemaster WHERE site_alias='$site_alias' AND flag=0");
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
				$sqlRem = mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE item_alias='$ticket_alias' AND module ='TT' AND flag=0");
				$rem_count=mysqli_num_rows($sqlRem);
				if($rem_count){
					$j=0;while($rowRem = mysqli_fetch_array($sqlRem)){
						if($rowRem['remarked_by']=='admin'){$remarked_by='admin'; $designation='admin';}
						else{
							$remarked_by=alias($rowRem['remarked_by'],'ec_employee_master','employee_alias','name');
							$designation=alias(alias($rowRem['remarked_by'],'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','designation');
							}
						$result['obj'][$i]['remark'][$j]['remarkedby']=ucwords(strtolower($remarked_by));
						$result['obj'][$i]['remark'][$j]['designation']=ucwords(strtolower($designation));
						$result['obj'][$i]['remark'][$j]['remarkedon']=dateFormat($rowRem['remarked_on'],'d');
						$result['obj'][$i]['remark'][$j]['remark']=$rowRem['remarks'];
					$j++;}
				}$result['obj'][$i]['remark_length']=$rem_count;
				$result['obj'][$i]['action']=alias($ticket_alias,'ec_ticket_action','ticket_alias','observation');
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
				$result['obj'][$i]['mode_of_contact']=alias($rowTT['mode_of_contact'],'ec_moc','moc_alias','moc_name');
				$result['obj'][$i]['moc_num']=$rowTT['moc_num'];
				$result['obj'][$i]['contact_link']=($rowTT['contact_link']!='0' ? baseurl()."images/reports/".$rowTT['contact_link'] : "");
				$result['obj'][$i]['service_engineer_alias']=checkempty($rowTT['service_engineer_alias']);
				$result['obj'][$i]['service_engineer_name']=alias($rowTT['service_engineer_alias'],'ec_employee_master','employee_alias','name');
				$result['obj'][$i]['level_code']=$rowTT['level'];
				$result['obj'][$i]['old_level_code']=$rowTT['old_level'];
				$result['obj'][$i]['purpose']=$rowTT['purpose'];
				
				$level = $rowTT['level'];
				$old_level = $rowTT['old_level'];
				$result['obj'][$i]['levelcolor']=($level=='1' || $level=='2' || $level=='4' || $level=='5' ? repl_planfail_tsrej($level,$old_level,$rowTT['planned_date'],$rowTT['purpose'],'color'):alias($level,'ec_levels','level_alias','level_color'));
				$result['obj'][$i]['level']=($level=='1' || $level=='2' || $level=='4' || $level=='5' ? repl_planfail_tsrej($level,$old_level,$rowTT['planned_date'],$rowTT['purpose'],'name'):alias($level,'ec_levels','level_alias','level_name'));
			
			//Required Cells
				$result['obj'][$i]['req']=array();
				$sqlReq=mysqli_query($mr_con,"SELECT * FROM ec_cell_required WHERE ticket_alias='$ticket_alias' AND flag='0'");
				if(mysqli_num_rows($sqlReq)){
					$j=0;while($rowReq = mysqli_fetch_array($sqlReq)){
						if(!empty($rowReq['cell_alias']) && $rowReq['cell_alias']!='NA' && !empty($rowReq['quanty'])){
							$result['obj'][$i]['req'][$j]['cell_name'] = alias($rowReq['cell_alias'],'ec_product','product_alias','product_description');
							$result['obj'][$i]['req'][$j]['quanty'] = $rowReq['quanty'];
							$result['obj'][$i]['req'][$j]['sent_quanty'] = $rowReq['sent_quanty'];
							$result['obj'][$i]['req'][$j]['approved_stat'] = ($rowReq['approved_stat']=='1' ? "PENDING" : "APPROVED");
							$result['obj'][$i]['req'][$j]['approved_by'] =  (empty($rowReq['approved_by'])? "NA" :(strtoupper($rowReq['approved_by'])=='ADMIN' ? "ADMIN" : strtoupper(alias($rowReq['approved_by'],'ec_employee_master','employee_alias','name'))));
							$result['obj'][$i]['req'][$j]['approved_on'] = ($rowReq['approved_on']=="0000-00-00" ? "NA":dateFormat($rowReq['approved_on'],'d'));
						$j++;
						}
					}
				}
			//Service Engineer Observation
				$sqlEng=mysqli_query($mr_con,"SELECT * FROM ec_engineer_observation WHERE ticket_alias='$ticket_alias' AND flag='0'");
				$se_count=mysqli_num_rows($sqlEng);
				if($se_count){
					$rowEng = mysqli_fetch_array($sqlEng);
					$result['obj'][$i]['req_cells'] = (!empty($rowEng['req_cells']) ? $rowEng['req_cells'] : 'NA');
					$result['obj'][$i]['faulty_cell_sr_no'] = (!empty($rowEng['faulty_cell_sr_no']) ? $rowEng['faulty_cell_sr_no'] : 'NA');
					$result['obj'][$i]['replaced_cell_no'] = (!empty($rowEng['replaced_cell_no']) ? $rowEng['replaced_cell_no'] : 'NA');
				}$result['obj'][$i]['se_count'] = $se_count;
				
				//$result['edit']=grantable('EDIT','TICKETS',$emp_alias);
				if($level == '1' || $level == '2'){$result['edit'] = grantable('PD','TICKETS',$emp_alias);}
				elseif($level == '3'){$result['edit'] = grantable('ZHS','TICKETS',$emp_alias);}
				elseif($level == '4'){$result['edit'] = grantable('NHS','TICKETS',$emp_alias);}
				elseif($level == '8'){$result['edit'] = grantable('TS','TICKETS',$emp_alias);}
				else{$result['edit'] = grantable('EDIT','TICKETS',$emp_alias);}

				$result['obj'][$i]['efsr_no']=$rowTT['efsr_no'];
				$result['obj'][$i]['fsrreport']=($rowTT['efsr_no']!='' ? "e-FSR" : "-");
				$result['obj'][$i]['efsr_date']=date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowTT['efsr_date'])));
				$result['obj'][$i]['status']=$rowTT['status'];
			$i++;}
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
	if($chk==0){ $con='';
	if(isset($_REQUEST['zone_alias']) && count($_REQUEST['zone_alias'])>0){
		$zone_arr = $_REQUEST['zone_alias'];
		$con .= "T2.zone_alias RLIKE '".implode("|",$_REQUEST['zone_alias'])."' AND ";
	}
	if(isset($_REQUEST['state_alias']) && count($_REQUEST['state_alias'])>0){
		$state_arr = $_REQUEST['state_alias'];
		$con .= "T2.state_alias RLIKE '".implode("|",$_REQUEST['state_alias'])."' AND ";
	}
	if(isset($_REQUEST['activity_alias']) && count($_REQUEST['activity_alias'])>0)$con .= "T1.activity_alias RLIKE '".implode("|",$_REQUEST['activity_alias'])."' AND ";
	if(isset($_REQUEST['complaint_alias']) && count($_REQUEST['complaint_alias'])>0)$con .= "T1.complaint_alias RLIKE '".implode("|",$_REQUEST['complaint_alias'])."' AND ";
	if(isset($_REQUEST['level_alias']) && count($_REQUEST['level_alias'])>0){
		$level_alias=$_REQUEST['level_alias'];
		if(!in_array('2',$level_alias) && !in_array('8',$level_alias))$con .= "T1.level RLIKE '".implode("|",$level_alias)."' AND ";
		else foreach($level_alias as $lvl)$con .= levelCheck($lvl);
	}
	if(isset($_REQUEST['segment_alias']) && count($_REQUEST['segment_alias'])>0)$con .= "T2.segment_alias RLIKE '".implode("|",$_REQUEST['segment_alias'])."' AND ";
	if(isset($_REQUEST['product']) && count($_REQUEST['product'])>0)$con .= "T2.product_alias RLIKE '".implode("|",$_REQUEST['product'])."' AND ";
	if(isset($_REQUEST['tat']) && count($_REQUEST['tat'])>0)$con .= "T1.tat RLIKE '".implode("|",$_REQUEST['tat'])."' AND ";
	if(isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date']))$con .= "login_date >= '".dateFormat($_REQUEST['from_date'],'y')."' AND ";
	if(isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date']))$con .= "login_date <= '".dateFormat($_REQUEST['to_date'],'y')." 23:59:59' AND ";
	$export_bifurcation = array();
	if(isset($_REQUEST['export_bifurcation']) && count($_REQUEST['export_bifurcation'])>0){
		$export_bifurcation = $_REQUEST['export_bifurcation'];
		$valid = TRUE;
	}else{$valid = FALSE;}
	if($valid){
	$f_arr = array(1=>'TICKETS_',2=>'TTSA_');
	foreach($f_arr as $k=>$v){
		if(in_array($k,$export_bifurcation)){// || !count($export_bifurcation)
			$file_name .= $v;
			if($k==1){$tt_dt=TRUE;}
			if($k==2){$tt_sa=TRUE;}
		}
	}
	$filename = $file_name.date('d-m-Y H_i_s');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("EnersysCare")->setLastModifiedBy("EnersysCare")->setTitle("Office 2007 XLSX Tickets Document")->setSubject("Office 2007 XLSX Tickets Document")->setDescription("Tickets document for Office 2007 XLSX, generated using PHP classes.");
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
	$sh_index = 0;
	if($tt_dt){
		$objPHPExcel->setActiveSheetIndex($sh_index);
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setTitle('Tickets');
		$sql=mysqli_query($mr_con,"SELECT T1.*, T2.* FROM ec_tickets T1 INNER JOIN ec_sitemaster T2 ON T1.site_alias = T2.site_alias WHERE $con T2.customer_alias='$emp_ali' AND T1.flag=0");
		if(mysqli_num_rows($sql)){
			$colArr = array("Ticket ID","Login Date","Visit Generated Date","Mode Of Contact","Zone","State","District","Site ID","Site Name","Site Address","First Level Contact Name","First Level Contact Number","Second Level Contact Name","Second Level Contact Number","Second Level Contact Email","Segment","Customer","Activity","Nature of Complaint","Complaint Description","No of Faulty Cells reported by Customer","No of Faulty Cells reported by Service Engineer","Product","Battery Bank Rating","No Of String","Mfd Date","Install Date","Site Type","Warranty Status","Activation Date","Planned Date","Planned Service Engineer","Planned Service Engineer Role","Planned Service Engineer Number","efsr No","efsr Date","Closing Date","TAT","Visits","Level","Ticket Status","Milestone","eFSR Efficiency","MRS","Visited SE Name","Visited SE Remarks","Visited SE Action Date and Time","Visited SE Action Taken","ZHS Name","ZHS Remarks","ZHS Action Date and Time","ZHS Aging","NHS Name","NHS Remarks","NHS Action Date and Time","NHS Aging");
			$last_key = end(array_keys($colArr));
			$last_alpha = num2alpha($last_key);
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
			$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue)); $ch++; }
			$date_arr = array("B","C","AB","AC","AE","AH","AK","AL","AQ","AR","BC","BH","BM","BR","BV","BY","CB","CE","CI");
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
					->SetCellValue('I'.$coo, checkemptydash($row['site_id']))
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
					->SetCellValue('AP'.$coo, checkemptydash($row['efsr_no']))
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
					
					->SetCellValue('CF'.$coo,checkemptydash(implode(" | ",$rem_result['other_rem'])))
					->SetCellValue('CG'.$coo,checkemptydash(implode(" | ",$rem_result['other_buc'])))
					->SetCellValue('CH'.$coo,checkemptydash(implode(" | ",$rem_result['other_by'])))
					->SetCellValue('CI'.$coo,checkemptydash((count($rem_result['other_on'])==1 ? php_excel_date(end($rem_result['other_on'])) : implode(" | ",$rem_result['other_on']))));
			}$no_rec++;
		}$sh_index++;
	}
//TT SA
	if($tt_sa){
		if($sh_index>0){ $objPHPExcel->createSheet(); }
		$objPHPExcel->setActiveSheetIndex($sh_index);
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setTitle('TT SA');
		$sql=mysqli_query($mr_con,"SELECT T1.*, T2.* FROM ec_tickets T1 JOIN ec_sitemaster T2 ON T1.site_alias = T2.site_alias WHERE $con T2.customer_alias='$emp_ali' AND T1.flag=0");
		if(mysqli_num_rows($sql)){
			$colArr = array("Ticket ID","Login Date","Visit Generated Date","Mode Of Contact","Zone","State","District","Site ID","Site Name","Site Address","First Level Contact Name","First Level Contact Number","Second Level Contact Name","Second Level Contact Number","Second Level Contact Email","Segment","Customer","Activity","Nature of Complaint","Complaint Description","No of Faulty Cells reported by Customer","No of faulty cells reported by Service Engineer","Product","Battery Bank Rating","No Of String","Mfd Date","Install Date","Site Type","Warranty Status","Activation Date","Planned Date","Planned Service Engineer","Planned Service Engineer Role","Planned Service Engineer Number","efsr No","efsr Date","Closing Date","TAT","Visits","Level","Ticket Status","Milestone","eFSR Efficiency","MRS","Faulty Code","Job Performed","Train No","Express Name","Coach No","Pre Attnd","Poh","Rpoh","Zone","Division","Workshop","Altenate Make","RRU Make","Invertor Make","Regulator Make","Voltage Regulation","Altenate Belt Status","Icc Tightness","Heating Melting Marks","Terminal Tightness","Alt No Belt Avl","Physical Damage","Vent Plug Tightness","Belt","Log Book","Coach Status","Cell Buldge","Charger Band","Manf Date","Serial No","Charger Type","Voltage","Charging Current","High Voltage Cutoff","Voltage Ripple","Voltage Regulation","Fork Lift Brand","Fork Lift Model","Fork Lift Manf Date","Battery Type","Bank Serial No","Manfacturing Date","Installation Date","Plug Type","Acid Level","Float Voltage","Boast Voltage","Current Limit","Voltage Ripple","Voltage Rgulation","High Voltage Cutoff","Low Voltage Cutoff","Panel Make","Panel Rating","Charge Controller Rate","Charge Controller Make","No Solar Panels","Single Panel Rating","Panel Manufacturing Date","Charge Control Manufacturing Date","Panel Installation Date","Physical Damages","Leakage","Temperature","Acid Temp Discharge","Acid Temp Charge","Cells Temp After Use","Cells Temp At Charge","General Observation","Terminal Torque","Vent Plug Thickness","Site Load","Dg Status","Dg Make","Dg Capacity","Dg Working Condition","Avg Dg Run","Eb Supply","Failures Per Day","Avg Power Cut","Required Acc","Required Cells","Faulty Cell Sr No","Replaced Cells Count","Customer Comments","Customer Name","Customer Designation","Customer Contact Number","Customer Email","Rating 1","Rating 2","Rating 3","Rating 4","Rating 5","Visited SE Name","Visited SE Remarks","Visited SE Action Date and Time","Visited SE Action Taken","ZHS Name","ZHS Remarks","ZHS Action Date and Time","ZHS Aging","NHS Name","NHS Remarks","NHS Action Date and Time","NHS Aging");
			//$colArr2=array('ticket_id','mode_of_contact','faulty_cell_count','description','login_date','activation_date','planned_date','payment_terms','closing_date','status','site_id','mfd_date','install_date','no_of_string','technician_name','technician_number','manager_name','manager_number','manager_mail','site_address');
			$last_key = end(array_keys($colArr));
			$last_alpha = num2alpha($last_key);
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
			$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue)); $ch++; }
			$sqlR=mysqli_query($mr_con,"SELECT COUNT(id) AS mycount FROM ec_remarks WHERE module='TT' AND flag=0 GROUP BY item_alias ORDER BY mycount DESC LIMIT 1");
			$rowR=mysqli_fetch_array($sqlR);
			$max_rem_count = $rowR['0'];
			$xx = $yy = 'EU'; 
			for($h=0;$h<$max_rem_count;$h++){
				$sheet->SetCellValue($xx.'1','Remarked By ('.($h+1).')'); $xx++;
				$sheet->SetCellValue($xx.'1','Remark ('.($h+1).')');  $xx++;
				$sheet->SetCellValue($xx.'1','Remarked On ('.($h+1).')');
				$sheet->getStyle($xx)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension($xx)->setAutoSize(true);
				$xx++;
			} $xx--;
			$sheet->getStyle($yy.'1:'.$xx.'1')->applyFromArray($styleArray);
			$sheet->getStyle($yy.'1:'.$xx.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$date_arr = array("B","C","Z","AA","AD","AE","AJ","AK","AX","AY","AZ","BU","CE","CH","CI","CY","CZ","DA","EK","EO","ES");
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
						//if($privilege_alias=='3WDRECJ0MA' || $privilege_alias=='PCNKPSJJEU' &&){
						if($rowRem['remarked_by']==$row['service_engineer_alias'] && $seBy=='' && ($bucket=='7' || $bucket=='8')){
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
						}elseif($nhsBy=='' && ($bucket=='37' || $bucket=='38' || $bucket=='10' || $bucket=='39')){
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
						->SetCellValue('D'.$coo, checkemptydash($row['mode_of_contact']))
						->SetCellValue('E'.$coo, checkemptydash(alias($row['zone_alias'],'ec_zone','zone_alias','zone_name')))
						->SetCellValue('F'.$coo, checkemptydash(alias($row['state_alias'],'ec_state','state_alias','state_name')))
						->SetCellValue('G'.$coo, checkemptydash(alias($row['district_alias'],'ec_district','district_alias','district_name')))
						->SetCellValue('H'.$coo, checkemptydash($row['site_id']))
						->SetCellValue('I'.$coo, checkemptydash($row['site_name']))
						->SetCellValue('J'.$coo, checkemptydash($row['site_address']))
						->SetCellValue('K'.$coo, checkemptydash($row['technician_name']))
						->SetCellValue('L'.$coo, checkemptydash($row['technician_number']))
						->SetCellValue('M'.$coo, checkemptydash($row['manager_name']))
						->SetCellValue('N'.$coo, checkemptydash($row['manager_number']))
						->SetCellValue('O'.$coo, checkemptydash($row['manager_mail']))
						->SetCellValue('P'.$coo, checkemptydash(alias($row['segment_alias'],'ec_segment','segment_alias','segment_name')))
						->SetCellValue('Q'.$coo, checkemptydash(alias($row['customer_alias'],'ec_customer','customer_alias','customer_code')))
						->SetCellValue('R'.$coo, checkemptydash(alias($row['activity_alias'],'ec_activity','activity_alias','activity_name')))
						->SetCellValue('S'.$coo, checkemptydash(alias($row['complaint_alias'],'ec_complaint','complaint_alias','complaint_name')))
						->SetCellValue('T'.$coo, checkemptydash($row['description']))
						->SetCellValue('U'.$coo, checkemptydash($row['faulty_cell_count']))
						->SetCellValue('V'.$coo, checkemptydash($f_count))
						->SetCellValue('W'.$coo, checkemptydash(alias($row['product_alias'],'ec_product','product_alias','product_description')))
						->SetCellValue('X'.$coo, checkemptydash($row['battery_bank_rating']))
						->SetCellValue('Y'.$coo, checkemptydash($row['no_of_string']))
						->SetCellValue('Z'.$coo, php_excel_date($row['mfd_date']))
						->SetCellValue('AA'.$coo, php_excel_date($row['install_date']))
						->SetCellValue('AB'.$coo, checkemptydash(alias($row['site_type_alias'],'ec_site_type','site_type_alias','site_type')))
						->SetCellValue('AC'.$coo, (sitemanfdate_check($row['site_alias']) ? "UNDER WARRANTY" : "OUT OF WARRANTY"))
						->SetCellValue('AD'.$coo, php_excel_date($row['activation_date']))
						->SetCellValue('AE'.$coo, php_excel_date($row['planned_date']))
						->SetCellValue('AF'.$coo, checkemptydash(alias_flag_none($row['service_engineer_alias'],'ec_employee_master','employee_alias','name')))
						->SetCellValue('AG'.$coo, checkemptydash(alias(alias_flag_none($row['service_engineer_alias'],'ec_employee_master','employee_alias','role_alias'),'ec_emprole','role_alias','role_name')))
						->SetCellValue('AH'.$coo, checkemptydash(alias_flag_none($row['service_engineer_alias'],'ec_employee_master','employee_alias','mobile_number')))
						->SetCellValue('AI'.$coo, checkemptydash($row['efsr_no']))
						->SetCellValue('AJ'.$coo, ($row['efsr_date']=="" ? "-" : php_excel_date($row['efsr_date'])))
						->SetCellValue('AK'.$coo, ($row['closing_date']=="" || $row['level']<6 ? "-" : php_excel_date($row['closing_date'])))
						->SetCellValue('AL'.$coo, checkemptydash((!empty($row['tat']) ? $row['tat'] : tat($ticket_alias))))
						->SetCellValue('AM'.$coo, visit_exp_count($ticket_id))
						->SetCellValue('AN'.$coo, checkemptydash(($row['level']=='1' || $row['level']=='2' || $row['level']=='4' || $row['level']=='5' ? repl_planfail_tsrej($row['level'],$row['old_level'],$row['planned_date'],$row['purpose'],'name'):alias($row['level'],'ec_levels','level_alias','level_name'))))
						->SetCellValue('AO'.$coo, checkemptydash($row['status']))
						->SetCellValue('AP'.$coo, checkemptydash(alias($row['milestone'],'ec_milestone','mile_stone_alais','mile_stone')))
						->SetCellValue('AQ'.$coo, checkemptydash($row['payment_terms']))
						->SetCellValue('AR'.$coo, checkemptydash(mrfStatus($row['ticket_alias'])))
				// 2) Engineer Observation
						->SetCellValue('AS'.$coo, checkemptydash(alias($tkt_segeng_row['faulty_code_alias'],'ec_faulty_code','faulty_alias','description')))
						->SetCellValue('AT'.$coo, checkemptydash($tkt_segeng_row['job_performed']))
				// 3) Coach History
						->SetCellValue('AU'.$coo, checkemptydash($tkt_seg_row['train_no']))
						->SetCellValue('AV'.$coo, checkemptydash($tkt_seg_row['express_name']))
						->SetCellValue('AW'.$coo, checkemptydash($tkt_seg_row['coach_no']))
						->SetCellValue('AX'.$coo, php_excel_date($tkt_seg_row['pre_attnd']))
						->SetCellValue('AY'.$coo, php_excel_date($tkt_seg_row['poh']))
						->SetCellValue('AZ'.$coo, php_excel_date($tkt_seg_row['rpoh']))
						->SetCellValue('BA'.$coo, checkemptydash($tkt_seg_row['zone']))
						->SetCellValue('BB'.$coo, checkemptydash($tkt_seg_row['division']))
						->SetCellValue('BC'.$coo, checkemptydash($tkt_seg_row['workshop']))
				// 4) Equipment details
						->SetCellValue('BD'.$coo, checkemptydash($tkt_segeq_row['altenate_make']))
						->SetCellValue('BE'.$coo, checkemptydash($tkt_segeq_row['rru_make']))
						->SetCellValue('BF'.$coo, checkemptydash($tkt_segeq_row['invertor_make']))
						->SetCellValue('BG'.$coo, checkemptydash($tkt_segeq_row['regulator_make']))
						->SetCellValue('BH'.$coo, checkemptydash($tkt_segeq_row['voltage_regulation']))
						->SetCellValue('BI'.$coo, checkemptydash($tkt_segeq_row['altenate_belt_status']))
				// 5) Checkpoints
						->SetCellValue('BJ'.$coo, checkemptydash($tkt_segchk_row['icc_tightness']))
						->SetCellValue('BK'.$coo, checkemptydash($tkt_segchk_row['heating_melting_marks']))
						->SetCellValue('BL'.$coo, checkemptydash($tkt_segchk_row['terminal_tightness']))
						->SetCellValue('BM'.$coo, checkemptydash($tkt_segchk_row['alt_no_belt_avl']))
						->SetCellValue('BN'.$coo, checkemptydash($tkt_segchk_row['physical_damage']))
						->SetCellValue('BO'.$coo, checkemptydash($tkt_segchk_row['vent_plug_tightness']))
						->SetCellValue('BP'.$coo, checkemptydash($tkt_segchk_row['belt']))
						->SetCellValue('BQ'.$coo, checkemptydash($tkt_segchk_row['log_book']))
						->SetCellValue('BR'.$coo, checkemptydash($tkt_segchk_row['coach_status']))
						->SetCellValue('BS'.$coo, checkemptydash($tkt_segchk_row['cell_buldge']))
				// 6) Charger Details
						->SetCellValue('BT'.$coo, checkemptydash($tkt_segchg_row['charger_band']))
						->SetCellValue('BU'.$coo, php_excel_date($tkt_segchg_row['mfd_date']))
						->SetCellValue('BV'.$coo, checkemptydash($tkt_segchg_row['serial_no']))
						->SetCellValue('BW'.$coo, checkemptydash($tkt_segchg_row['charger_type']))
						->SetCellValue('BX'.$coo, checkemptydash($tkt_segchg_row['voltage']))
						->SetCellValue('BY'.$coo, checkemptydash($tkt_segchg_row['charging_current']))
						->SetCellValue('BZ'.$coo, checkemptydash($tkt_segchg_row['high_voltage_cutoff']))
						->SetCellValue('CA'.$coo, checkemptydash($tkt_segchg_row['voltage_ripple']))
						->SetCellValue('CB'.$coo, checkemptydash($tkt_segchg_row['voltage_regulation']))
				// 7) Fork Lift
						->SetCellValue('CC'.$coo, checkemptydash($tkt_segfrk_row['fork_lift_brand']))
						->SetCellValue('CD'.$coo, checkemptydash($tkt_segfrk_row['fork_lift_model']))
						->SetCellValue('CE'.$coo, php_excel_date($tkt_segfrk_row['fork_lift_manf_date']))
				// 8) Battery Details
						->SetCellValue('CF'.$coo, checkemptydash($tkt_segbat_row['battey_type']))
						->SetCellValue('CG'.$coo, checkemptydash($tkt_segbat_row['bank_serial_no']))
						->SetCellValue('CH'.$coo, php_excel_date($tkt_segbat_row['manf_date']))
						->SetCellValue('CI'.$coo, php_excel_date($tkt_segbat_row['ins_date']))
						->SetCellValue('CJ'.$coo, checkemptydash($tkt_segbat_row['plug_type']))
						->SetCellValue('CK'.$coo, checkemptydash($tkt_segbat_row['acid_level']))
				// 9) Technical observations
						->SetCellValue('CL'.$coo, checkemptydash($tkt_segtch_row['float_voltage']))
						->SetCellValue('CM'.$coo, checkemptydash($tkt_segtch_row['boast_voltage']))
						->SetCellValue('CN'.$coo, checkemptydash($tkt_segtch_row['current_limit']))
						->SetCellValue('CO'.$coo, checkemptydash($tkt_segtch_row['voltage_ripple']))
						->SetCellValue('CP'.$coo, checkemptydash($tkt_segtch_row['voltage_regulation']))
						->SetCellValue('CQ'.$coo, checkemptydash($tkt_segtch_row['high_voltage_cutoff']))
						->SetCellValue('CR'.$coo, checkemptydash($tkt_segtch_row['low_voltage_cutoff']))
						->SetCellValue('CS'.$coo, checkemptydash($tkt_segtch_row['panel_make']))
						->SetCellValue('CT'.$coo, checkemptydash($tkt_segtch_row['panel_rating']))
						->SetCellValue('CU'.$coo, checkemptydash($tkt_segtch_row['charge_controller_rate']))
						->SetCellValue('CV'.$coo, checkemptydash($tkt_segtch_row['charge_controller_make']))
						->SetCellValue('CW'.$coo, checkemptydash($tkt_segtch_row['no_solar_panels']))
						->SetCellValue('CX'.$coo, checkemptydash($tkt_segtch_row['single_panel_rating']))
						->SetCellValue('CY'.$coo, php_excel_date($tkt_segtch_row['panel_manufacturing_date']))
						->SetCellValue('CZ'.$coo, php_excel_date($tkt_segtch_row['charge_control_manufacturing_date']))
						->SetCellValue('DA'.$coo, php_excel_date($tkt_segtch_row['panel_installation_date']))
				// 10) physical Observations
						->SetCellValue('DB'.$coo, checkemptydash($tkt_segphy_row['physical_damages']))
						->SetCellValue('DC'.$coo, checkemptydash($tkt_segphy_row['leakage']))
						->SetCellValue('DD'.$coo, checkemptydash($tkt_segphy_row['temperature']))
						->SetCellValue('DE'.$coo, checkemptydash($tkt_segphy_row['acid_temp_discharge']))
						->SetCellValue('DF'.$coo, checkemptydash($tkt_segphy_row['acid_temp_charge']))
						->SetCellValue('DG'.$coo, checkemptydash($tkt_segphy_row['cells_temp_after_use']))
						->SetCellValue('DH'.$coo, checkemptydash($tkt_segphy_row['cells_temp_at_charge']))
						->SetCellValue('DI'.$coo, checkemptydash($tkt_segphy_row['general_observation']))
						->SetCellValue('DJ'.$coo, checkemptydash($tkt_segphy_row['terminal_torque']))
						->SetCellValue('DK'.$coo, checkemptydash($tkt_segphy_row['vent_plug_thickness']))
				// 11) General Observations
						->SetCellValue('DL'.$coo, checkemptydash($tkt_seggnr_row['site_load']))
						->SetCellValue('DM'.$coo, checkemptydash($tkt_seggnr_row['dg_status']))
						->SetCellValue('DN'.$coo, checkemptydash($tkt_seggnr_row['dg_make']))
						->SetCellValue('DO'.$coo, checkemptydash($tkt_seggnr_row['dg_capacity']))
						->SetCellValue('DP'.$coo, checkemptydash($tkt_seggnr_row['dg_working_condition']))
						->SetCellValue('DQ'.$coo, checkemptydash($tkt_seggnr_row['avg_dg_run']))
				// 12)Power Observations
						->SetCellValue('DR'.$coo, checkemptydash($tkt_segpwr_row['eb_supply']))
						->SetCellValue('DS'.$coo, checkemptydash($tkt_segpwr_row['failures_per_day']))
						->SetCellValue('DT'.$coo, checkemptydash($tkt_segpwr_row['avg_power_cut']))
				// 2) Engineer Observation
						->SetCellValue('DU'.$coo, checkemptydash($tkt_segeng_row['req_acc']))
						->SetCellValue('DV'.$coo, checkemptydash($tkt_segeng_row['req_cells']))
						->SetCellValue('DW'.$coo, checkemptydash($tkt_segeng_row['faulty_cell_sr_no']))
						->SetCellValue('DX'.$coo, checkemptydash($rep_count))
				//Customer Comment
						->SetCellValue('DY'.$coo, checkemptydash(alias($ticket_alias,'ec_customer_comments','ticket_alias','customer_comments')))
				// 13) E-signature
						->SetCellValue('DZ'.$coo, checkemptydash($tkt_segesig_row['name']))
						->SetCellValue('EA'.$coo, checkemptydash($tkt_segesig_row['designation']))
						->SetCellValue('EB'.$coo, checkemptydash($tkt_segesig_row['contact_number']))
						->SetCellValue('EC'.$coo, checkemptydash($tkt_segesig_row['email']))
				// 14) Customer Satisfaction
						->SetCellValue('ED'.$coo, checkemptydash($tkt_segsatis_row['q1']))
						->SetCellValue('EE'.$coo, checkemptydash($tkt_segsatis_row['q2']))
						->SetCellValue('EF'.$coo, checkemptydash($tkt_segsatis_row['q3']))
						->SetCellValue('EG'.$coo, checkemptydash($tkt_segsatis_row['q4']))
						->SetCellValue('EH'.$coo, checkemptydash($tkt_segsatis_row['q5']))
				// 15) Remarks
						->SetCellValue('EI'.$coo,checkemptydash($seBy))
						->SetCellValue('EJ'.$coo,checkemptydash($seRem))
						->SetCellValue('EK'.$coo,$seOn)
						->SetCellValue('EL'.$coo,checkemptydash($seAction))
		
						->SetCellValue('EM'.$coo,checkemptydash($zhsBy))
						->SetCellValue('EN'.$coo,checkemptydash($zhsRem))
						->SetCellValue('EO'.$coo,$zhsOn)
						->SetCellValue('EP'.$coo,checkemptydash($zhsAge))
		
						->SetCellValue('EQ'.$coo,checkemptydash($nhsBy))
						->SetCellValue('ER'.$coo,checkemptydash($nhsRem))
						->SetCellValue('ES'.$coo,$nhsOn)
						->SetCellValue('ET'.$coo,checkemptydash($nhsAge));
				
				$cd = $c = 'EU';
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
	if($no_rec>0){
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save("../../exports/$filename.xlsx");
		$result['file_name']=$filename;
		$resCode='0'; $resMsg='export';
	}else{$resCode='4';$resMsg='No Records found to Run Report!';}
	}else{$resCode='4';$resMsg='Please Select the Datatype';}
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function onlineTickets(){ global $mr_con;
	if(isset($_REQUEST['emp_alias'])){$emp_alias = $_REQUEST['emp_alias'];}
	if(isset($_REQUEST['alias']))$alias="site_id LIKE '%".mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']))."%' AND";else $alias="";
	$request = \Slim\Slim::getInstance()->request();
		$sql = mysqli_query($mr_con,"SELECT site_id,site_alias FROM ec_sitemaster WHERE customer_alias='$emp_alias' AND $alias flag=0");
		if(mysqli_num_rows($sql)>0){$i=0;
			while($row=mysqli_fetch_array($sql)){$result[$i]['site_id']=$row['site_id'];$result[$i]['site_alias']=$row['site_alias'];$result[$i]['site_status'] = sitemanfdate_check($row['site_alias']);$i++;}
		}else{$result[0]['site_id']=$result[0]['site_alias']="No Record Found";$result[0]['site_status'] ="online";}
	echo json_encode($result);
}
function sitemanfdate(){ global $mr_con;
	$cust=mysqli_real_escape_string($mr_con,$_REQUEST['customer']);
	$mdate=mysqli_real_escape_string($mr_con,dateFormat(str_replace(",","-",$_REQUEST['mdate']),'y'));
	$idate=mysqli_real_escape_string($mr_con,dateFormat(str_replace(",","-",$_REQUEST['idate']),'y'));
	echo json_encode(sitestatus($cust,$mdate,$idate));
}
function sitemaster_view(){ global $mr_con;
	$emp_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias']));
	$token=mysqli_real_escape_string($mr_con,trim($_REQUEST['token']));
	$alias= mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_sitemaster WHERE site_alias ='$alias' AND flag=0");
		if(mysqli_num_rows($sql)){
			while($row=mysqli_fetch_array($sql)){
				$result['site_alias']=$row['site_alias'];
				$result['zone_name']=alias($row['zone_alias'],'ec_zone','zone_alias','zone_name');
				$result['zone_alias']=$row['zone_alias'];
				$result['state_name']=alias($row['state_alias'],'ec_state','state_alias','state_name');
				$result['state_alias']=$row['state_alias'];
				$result['district_name']=alias($row['district_alias'],'ec_district','district_alias','district_name');
				$result['district_alias']=$row['district_alias'];
				$result['segment_name']=alias($row['segment_alias'],'ec_segment','segment_alias','segment_name');
				$result['segment_alias']=$row['segment_alias'];
				$result['customer_name']=alias($row['customer_alias'],'ec_customer','customer_alias','customer_name');
				$result['customer_alias']=$row['customer_alias'];
				$result['site_type']=alias($row['site_type_alias'],'ec_site_type','site_type_alias','site_type');
				$result['site_type_alias']=$row['site_type_alias'];
				$result['site_id']=$row['site_id'];
				$result['site_name']=$row['site_name'];
				
				$product = explode(", ",$row['product_alias']);
				foreach($product as $pro){ $xx .= alias($pro,'ec_product','product_alias','product_description').", "; }
				$result['product_description'] = trim($xx,", ");
				$result['product_alias']=$row['product_alias'];
				
				$result['battery_bank_rating']=$row['battery_bank_rating'];
				$result['mfd_date']=dateFormat($row['mfd_date'],'d');
				$result['install_date']=dateFormat($row['install_date'],'d');
				$result['no_of_string']=$row['no_of_string'];
				$result['technician_name']=$row['technician_name'];
				$result['technician_number']=$row['technician_number'];
				$result['manager_name']=$row['manager_name'];
				$result['manager_number']=$row['manager_number'];
				$result['manager_mail']=$row['manager_mail'];

				$site = sitestatus($result['customer_alias'],$result['mfd_date'],$result['install_date']);
				$result['schedule']=$site['schedule'];
				$result['warrantyleft']=$site['warrantyleft'];
				$result['warrantymonths']=$site['warrantymonths'];
				$result['site_status']=$site['warrantystatus'];

				$result['site_address']=$row['site_address'];
				$result['created_date']=dateFormat($row['created_date'],'d');
				
				$result['edit']=grantable('EDIT','SITEMASTER',$emp_alias);
			}
		}else{$resCode='4';$resMsg='No Records Found!';}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function sitemaster_mul_view(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		if($_REQUEST['siteId']!="")$site_id="site_id LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['siteId'])."%' AND ";else $site_id="";
		if($_REQUEST['siteName']!="")$site_name="site_name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['siteName'])."%' AND ";else $site_name="";
		if($_REQUEST['zoneAlias']!="")$zone_alias="zone_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['zoneAlias'])."' AND ";else $zone_alias="";
		if($_REQUEST['stateName']!="")$state_code="state_code LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['stateName'])."%' AND ";else $state_code="";
		if($_REQUEST['customerCode']!="")$customer_code="customer_code LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['customerCode'])."%' AND ";else $customer_code="";
		if($_REQUEST['segmentAlias']!="")$segment_alias="segment_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['segmentAlias'])."' AND ";else $segment_alias="";
		if($_REQUEST['siteStatus']!="")$site_status="site_status LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['siteStatus'])."%' AND ";else $site_status="";
		
		$condtion=$site_id.$site_name.$zone_alias.$segment_alias;
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_sitemaster WHERE $condtion flag=0 AND site_alias IN (SELECT site_alias FROM ec_sitemaster WHERE customer_alias ='$emp_alias') AND state_alias IN (SELECT state_alias FROM ec_state WHERE $state_code flag=0) AND customer_alias IN (SELECT customer_alias FROM ec_customer WHERE $customer_code flag=0)");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT * FROM ec_sitemaster WHERE $condtion flag=0 AND site_alias IN (SELECT site_alias FROM ec_sitemaster WHERE customer_alias ='$emp_alias') AND state_alias IN (SELECT state_alias FROM ec_state WHERE $state_code flag=0) AND customer_alias IN (SELECT customer_alias FROM ec_customer WHERE $customer_code flag=0) LIMIT $offset, $limit");
			$result['sitemasterDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
						$result['sitemasterDetails'][$i]['zone_name']=alias($row['zone_alias'],'ec_zone','zone_alias','zone_name');
						$result['sitemasterDetails'][$i]['state_code']=alias($row['state_alias'],'ec_state','state_alias','state_code');
						$result['sitemasterDetails'][$i]['segment_code']=alias($row['segment_alias'],'ec_segment','segment_alias','segment_code');
						$result['sitemasterDetails'][$i]['customer_code']=alias($row['customer_alias'],'ec_customer','customer_alias','customer_code');
						$result['sitemasterDetails'][$i]['site_id']=$row['site_id'];
						$site_name = $row['site_name'];
						$result['sitemasterDetails'][$i]['full_site_name'] = $site_name;
						$result['sitemasterDetails'][$i]['site_name'] = ((strlen($site_name) > 12) ? substr($site_name,0,12)."..." : $site_name);
						$result['sitemasterDetails'][$i]['site_status']=(sitemanfdate_check($row['site_alias'])>0 ? 'UNDER WARRANTY' : 'OUT OF WARRANTY');
						$result['sitemasterDetails'][$i]['site_alias']=$row['site_alias'];
						$i++;} 
				}
				
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
			$result['export']=grantable('EXPORT','SITEMASTER',$emp_alias);
			$result['add']=grantable('ADD','SITEMASTER',$emp_alias);
	}elseif($rex==1){
		$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function sitemaster_export(){ 
	global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){ $con='';
		if(isset($_REQUEST['zone_alias']) && count($_REQUEST['zone_alias'])>0){
			$zone = implode("|",$_REQUEST['zone_alias']);
			$zone_arr = $_REQUEST['zone_alias'];
			$con .= " zone_alias RLIKE '$zone' AND";
		}else{$con .='';}
		if(isset($_REQUEST['state_alias']) && count($_REQUEST['state_alias'])>0){
			$state = implode("|",$_REQUEST['state_alias']);
			$state_arr = $_REQUEST['state_alias'];
			$con .= " state_alias RLIKE '$state' AND";
		}else{$con .= '';}
		if(isset($_REQUEST['product_alias']) && count($_REQUEST['product_alias'])>0){
			$product = implode("|",$_REQUEST['product_alias']);
			$product_arr = $_REQUEST['product_alias'];
			$con .= " product_alias RLIKE '$product' AND";
		}else{$con .= '';}
		$emp_alias = $_REQUEST['emp_alias'];
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_sitemaster WHERE $con flag=0 AND site_alias IN (SELECT site_alias FROM ec_sitemaster WHERE customer_alias ='$emp_alias')");
		$colArr=array('Site ID','Site Name','Manufacturing Date','Installation Date','Number of Strings','Site Technician Name','Site Technician Number','Manager Name','Manager Number','Manager Mail','Site Address','Zones','State','Districts','Segment','Customer Code','Product Code','Site Type','Site Status');
		$colArr2=array('site_id','site_name','mfd_date','install_date','no_of_string','technician_name','technician_number','manager_name','manager_number','manager_mail','site_address');
		$filename = 'sitemaster_'.date('d-m-Y H_i_s');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$sheet=$objPHPExcel->getActiveSheet();
		$objPHPExcel->getProperties()->setCreator("EnersysCare")->setLastModifiedBy("EnersysCare")->setTitle("Office 2007 XLSX SiteMaster Document")->setSubject("Office 2007 XLSX SiteMaster Document")->setDescription("SiteMaster document for Office 2007 XLSX, generated using PHP classes.");
		$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
		$ch = 'A';
		foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue));
			$sheet->getStyle($ch.'1')->applyFromArray($styleArray);
			$sheet->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
		$ch++;
		}
		$date_arr = array("C","D");
		foreach($date_arr as $da){$sheet->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension($da)->setAutoSize(true);}
		$coo=1;
		while($row=mysqli_fetch_array($sql)){ 
			$zone_alias = explode(", ",$row['zone_alias']);
			$zcnt=count($zone_alias);
			$state_alias = explode(", ",$row['state_alias']);
			$scnt=count($state_alias);
			$product_alias = explode(", ",$row['product_alias']);
			$pcnt=count($product_alias);
			$max = max($zcnt,$scnt,$pcnt);
			for($s=0;$s<$max;$s++){
				$a = (count($zone_arr) ? in_array($zone_alias[$s],$zone_arr) : TRUE);
				$b = (count($state_arr) ? in_array($state_alias[$s],$state_arr) : TRUE);
				$c = (count($product_arr) ? in_array($product_alias[$s],$product_arr) : TRUE);
				if($a || $b || $c){ $coo++;
					$d = ($zone_alias[$s]!='' ?  alias($zone_alias[$s],'ec_zone','zone_alias','zone_name'):"-");
					$e = ($state_alias[$s]!='' ?  alias($state_alias[$s],'ec_state','state_alias','state_name'):"-");
					$f = ($product_alias[$s]!='' ?  alias($product_alias[$s],'ec_product','product_alias','product_description'):"-");
				}
			for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
				$sheet->SetCellValue($chr.$coo, (($af==2 || $af==3) ? php_excel_date($row[$colArr2[$af]]) : $row[$colArr2[$af]]));
			}
			$sheet->SetCellValue('L'.$coo, "SELECT * FROM ec_sitemaster WHERE $con $emp flag=0");
			$sheet->SetCellValue('M'.$coo, $d);
			$sheet->SetCellValue('M'.$coo, $e);
			$sheet->SetCellValue('N'.$coo, alias($row['district_alias'],'ec_district','district_alias','district_name'));
			$sheet->SetCellValue('O'.$coo, alias($row['segment_alias'],'ec_segment','segment_alias','segment_name'));
			$sheet->SetCellValue('P'.$coo, alias($row['customer_alias'],'ec_customer','customer_alias','customer_name'));
			$sheet->SetCellValue('Q'.$coo,$f);
			$sheet->SetCellValue('R'.$coo, alias($row['site_type_alias'],'ec_site_type','site_type_alias','site_type'));
			$site = sitestatus($row['customer_alias'],$row['mfd_date'],$row['install_date']); $site['warrantystatus'];
			$sheet->SetCellValue('S'.$coo, $site['warrantystatus']);
		}
	}
	$sheet->setTitle('Sitemaster');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("../../exports/$filename.xlsx");
	$result['file_name']=$filename;
	$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function ticket_status(){ global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){
		$result['tktstatusDetails']=array();
		if(isset($_REQUEST['state_alias'])){$state_alias=$_REQUEST['state_alias'];}else{$state_alias="";}
		if(isset($_REQUEST['segment_alias'])){$seg=$_REQUEST['segment_alias'];}else{$seg="";}
		if(isset($_REQUEST['faulty_alias'])){$fal=$_REQUEST['faulty_alias'];}else{$fal="";}
		//if(isset($_REQUEST['customer_alias'])){$cust=$_REQUEST['customer_alias'];}else{$cust="";}
		if(isset($_REQUEST['activity_alias'])){$activity_alias=$_REQUEST['activity_alias'];}else{$activity_alias="";}
		if(isset($_REQUEST['tat'])){$tat=$_REQUEST['tat'];}else{$tat="";}
		if(isset($_REQUEST['year'])&&!empty($_REQUEST['year'])){
			$year=$_REQUEST['year'];
			$from_date="20".$year."-04-01";
			$to_date="20".($year+1)."-03-31";
		}else{$from_date=0;$to_date=0;}
		$level_query=mysqli_query($mr_con,"SELECT level_name,level_alias FROM ec_levels WHERE level_alias<>'5' AND flag=0");
		while($level_row=mysqli_fetch_array($level_query)){
			$level_name[] = $level_row['level_name'];
			$level_alias[] = $level_row['level_alias'];
		}
		array_push($level_alias,"8");
		array_push($level_name,"PLAN FAIL");
		
		$s=mysqli_query($mr_con,"SELECT site_alias,zone_alias FROM ec_sitemaster WHERE customer_alias ='$emp_alias'");
		$site_alias = array();//$empzone=array();
		while($s_row=mysqli_fetch_array($s)){ $site_alias[]=$s_row['site_alias'];$empzn.=$s_row['zone_alias'].", "; }
		$l=implode("','",$site_alias);
		$con = " t2.site_alias IN ('$l') AND";
		$empzone=array_unique(explode(", ",rtrim($empzn,", ")));
		
		$zone_query=mysqli_query($mr_con,"SELECT zone_name,zone_alias FROM ec_zone WHERE flag=0 LIMIT 0,4");
		while($zone_row=mysqli_fetch_array($zone_query)){
			$zone_name[] = $zone_row['zone_name'];
			$zone_alias[] = $zone_row['zone_alias'];
		}
		$level_count = count($level_alias);
		$zone_count = count($zone_alias);
		for($i=0;$i<$level_count;$i++){
			$result['tktstatusDetails'][$i]['level_name']=$level_name[$i];
			$tot=0;
			for($j=0;$j<$zone_count;$j++){
				$zx = $zone_alias[$j];
				$zone_alias1 = (in_array($zx,$empzone) ? $zx : "");
				$fun = zone_count($level_alias[$i],$state_alias,$zone_alias1,$seg,$fal,$activity_alias,$tat,$from_date,$to_date,$con);
				if($i==0){$result['tktzone_name'][$j]['zone_name']=$zone_name[$j];}
				$result['tktstatusDetails'][$i]['zone_count'][$j]['count']=$fun;
				if($i<5){$pot+=$fun;}
				if($i==5 || $i==6){$ss+=$fun;}
				if($i==7){$tt+=$fun;}
				$tot+=$fun;
				if($j==0){$a+=$fun;}
				if($j==1){$b+=$fun;}
				if($j==2){$c+=$fun;}
				if($j==3){$d+=$fun;}
				$e+=$fun;		
			}
			$result['tktstatusDetails'][$i]['value']=$tot;
		}
		$sm=$pot+$tt;
		$result['details'][0]['cnt_value']=$a;
		$result['details'][1]['cnt_value']=$b;
		$result['details'][2]['cnt_value']=$c;
		$result['details'][3]['cnt_value']=$d;
		$result['details'][4]['cnt_value']=$e;
		$result['status']='STATUS';
		$result['total']='TOTAL';
		$result['opened']=$sm;
		$result['closed']=$ss;
		$result['txtopened']='OPEN';
		$result['txtclosed']='CLOSED';
		$result['grandtotal']='Grand Total';
		if($sql){$resCode='0'; $resMsg='Successfull!';
		}else{$resCode='4'; $resMsg='No Records Found';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function zone_count($level,$state_alias,$zone_alias,$segment,$faulty_code,$activity_alias,$tat,$from_date,$to_date,$con){ global $mr_con;
	if($from_date!='0' && $to_date!='0')$con .= " t1.login_date >= '".$from_date."' AND t1.login_date <= '".$to_date."' AND";
	if($level=='2'){
		$con .= " t1.level='$level' AND t1.planned_date >= '".date('Y-m-d')."' AND";
	}elseif($level=='8'){
		$con .= " t1.level='2' AND t1.planned_date < '".date('Y-m-d')."' AND";
	}elseif($level=='6' || $level=='7'){
		$con .= " t1.level='$level' AND t1.ticket_id NOT LIKE '%|%' AND";
	}else{
		$con .= " t1.level='$level' AND";
	}
	if(isset($state_alias) && ($state_alias>0)){
		$state=implode("|",$state_alias);
		$con .= " t2.state_alias RLIKE '$state' AND";
	}
	if(isset($segment) && count($segment)>0 && !empty($segment)){
		$seg = implode("|",$segment);
		$con .= " t2.segment_alias RLIKE '$seg' AND";
	}
	if(isset($faulty_code) && count($faulty_code)>0 && !empty($faulty_code)){
		$gh=array();
		$faulty = implode("|",$faulty_code);
		$gh=mul_alias($faulty ,'ec_engineer_observation','faulty_code_alias','ticket_alias');
		$g=implode("|",$gh);
		if(!empty($g)){
			$con .= " t1.ticket_alias RLIKE '$g' AND";
		}
	}
	/*if(isset($customer) && count($customer)>0 && !empty($customer)){
		$cu=implode("|",$customer);
		$con .= " t2.customer_alias RLIKE '$cu' AND";
	}*/
	if(isset($activity_alias) && count($activity_alias)>0 && !empty($activity_alias)){
		$activity=implode("|",$activity_alias);
		$con .=" t1.activity_alias RLIKE '$activity' AND";
	}
	if(isset($tat) && count($tat)>0 && !empty($tat)){
		$ta=implode("|",$tat);
		$con .=" t1.tat RLIKE '$ta' AND";
	}
	$tt_sql=mysqli_query($mr_con,"SELECT t1.id FROM ec_tickets t1 JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias WHERE $con t2.zone_alias='$zone_alias' AND t1.flag=0");
	$total_count=mysqli_num_rows($tt_sql);
	return $total_count;
}
function today_info_report_block(){global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){
		if(isset($_REQUEST['state_alias'])&&!empty($_REQUEST['state_alias']))$sa="t2.state_alias IN ('".implode("','",$_REQUEST['state_alias'])."') AND ";else $sa="";
		//if(isset($_REQUEST['customer_alias'])&&!empty($_REQUEST['customer_alias']))$ca="t2.customer_alias IN ('".implode("','",$_REQUEST['customer_alias'])."') AND ";else $ca="";
		if(isset($_REQUEST['segment_alias'])&&!empty($_REQUEST['segment_alias']))$sga="t2.segment_alias IN ('".implode("','",$_REQUEST['segment_alias'])."') AND ";else $sga="";
		if(isset($_REQUEST['activity_alias'])&&!empty($_REQUEST['activity_alias']))$act="t1.activity_alias IN ('".implode("','",$_REQUEST['activity_alias'])."') AND ";else $act="";
		if(isset($_REQUEST['faulty_alias'])&&!empty($_REQUEST['faulty_alias'])){
			$fa_a=' INNER JOIN ec_engineer_observation t3 ON t1.ticket_alias=t3.ticket_alias ';
			$fa="t3.faulty_code_alias IN ('".implode("','",$_REQUEST['faulty_alias'])."') AND ";
		}else{$fa="";$fa_a="";}
		if(isset($_REQUEST['tat'])&&!empty($_REQUEST['tat'])){$tatt= "t1.tat IN ('".implode("','",$_REQUEST['tat'])."') AND ";}else $tatt="";
		$con=$sa.$sga.$fa.$tatt.$act;
		$sql=mysqli_query($mr_con,"SELECT level_alias,level_name FROM ec_levels WHERE level_alias<>'0' AND flag=0");
		$i=0;while($l_row=mysqli_fetch_array($sql)){
			$cc['level'][$i]=$l_row['level_name'];
			$query=mysqli_query($mr_con,"SELECT COUNT(t1.id) AS coun FROM ec_tickets t1 
				INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias
				$fa_a WHERE $con t2.customer_alias='$emp_alias' AND t1.level='".$l_row['level_alias']."' AND transaction_date ='".date('Y-m-d')."' AND t1.flag=0 AND t2.flag=0");
			if(mysqli_num_rows($query)>'0'){$ro = mysqli_fetch_array($query);$co = $ro['coun'];}else{$co = 0;}
			$mm['tktcount'][0]="Tickets";
			$mm['tktcount'][$i+1]=$co;
			$kk+=$co;
		$i++;}
		$result['totalcount']=$kk;
		$result['bindto']='#cust_td_info';
		$result['data']['columns'][0]=$mm['tktcount'];
		$result['data']['type']="bar";
		$result['color']['pattern'][0]="#3F51B5";
		$result['color']['pattern'][1]="#38B4EE";
		$result['color']['pattern'][2]="#4CAF50";
		$result['color']['pattern'][3]="#E91E63";
		$result['axis']['x']['type']='category';
		$result['axis']['x']['categories']=$cc['level'];
		$result['legend']['position']='inset';
		$result['bar']['width']['ratio']='0.4';
		$result['size']['height']='240';
		$result['admin'] = $emp_alias;
		if($sql){$resCode='0'; $resMsg='Successfull!';
		}else{$resCode='4'; $resMsg='No Records Found';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function level_count($level_alias){ global $mr_con;
$s=mysqli_query($mr_con,"SELECT count(id) FROM ec_tickets WHERE level='$level_alias' AND flag=0");
	$s_row=mysqli_fetch_array($s);
	$level_count=$s_row['count(id)'];
	return $level_count;
}
function nature_of_activity(){ global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){ $con = "";
		if(isset($_REQUEST['state_alias'])&&!empty($_REQUEST['state_alias']))$sa="t2.state_alias IN ('".implode("','",$_REQUEST['state_alias'])."') AND ";else $sa="";
		//if(isset($_REQUEST['customer_alias'])&&!empty($_REQUEST['customer_alias']))$ca="t2.customer_alias IN ('".implode("','",$_REQUEST['customer_alias'])."') AND ";else $ca="";
		if(isset($_REQUEST['segment_alias'])&&!empty($_REQUEST['segment_alias']))$sga="t2.segment_alias IN ('".implode("','",$_REQUEST['segment_alias'])."') AND ";else $sga="";
		if(isset($_REQUEST['year'])&&!empty($_REQUEST['year'])){
			$year=$_REQUEST['year'];
			$from_date="20".$year."-04-01";
			$to_date="20".($year+1)."-03-31";
		}else{$from_date=0;$to_date=0;}
		if($from_date!='0' && $to_date!='0')$cd= " t1.login_date >= '".$from_date."' AND t1.login_date <= '".$to_date."' AND";else $cd="";
		$con=$sa.$sga.$cd;
		$aa['actname'] = array();$c=0;$i=0;
		$sql=mysqli_query($mr_con,"SELECT COUNT(t1.id) as gty,t3.activity_code FROM ec_tickets t1 INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias INNER JOIN ec_activity t3 ON t1.activity_alias=t3.activity_alias WHERE $con t2.customer_alias ='$emp_alias' AND t1.flag='0' GROUP BY t1.activity_alias");
		while($sql_row=mysqli_fetch_array($sql)){
			$aa['actname'][$i][]=$sql_row['activity_code'];	
			$c+= $aa['actname'][$i][]=$sql_row['gty'];	
		$i++;}
		$result['bindto']='#cust_n_act';
		if($c){
			$result['color']['pattern'][0]='#3F51B5';
			$result['color']['pattern'][1]='#4CAF50';
			$result['color']['pattern'][2]='#f44336';
			$result['color']['pattern'][3]='#E91E63';
			$result['color']['pattern'][4]='#38B4EE';
		}else{
			unset($aa['actname']);
			$aa['actname'][0][0]='No Activity';	
			$aa['actname'][0][1]=1;
			$result['color']['pattern'][0]='#e0e0e0';
		}
		$result['data']['columns']=$aa['actname'];
		$result['data']['type']="donut";
		$result['size']['height']='343';
		$result['donut']['width']='50';
		if($query){$resCode='0'; $resMsg='Successfull!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function num2alpha($n){
    for($r = ""; $n >= 0; $n = intval($n / 26) - 1) $r = chr($n%26 + 0x41) . $r;
    return $r;
}