<?php
date_default_timezone_set("Asia/Kolkata");
include ('../Classes/PHPExcel.php');
require ('../Classes/PHPExcel/IOFactory.php');
require ('../Slim/Slim.php');
include ('../mysql.php');
include ('../functions.php');
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->post('/send_message','send_message');
$app->post('/notifications_view','notifications_view');
$app->post('/notification_chng','notification_chng');
$app->run();
function send_message(){global $mr_con;
	$emp_alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token=mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$notif_alias = aliasCheck(generateRandomString(),'ec_notifications','notif_alias');
		$employee_alias=$_REQUEST['employee_alias1'];
		$title=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['title']));
		$message=mysqli_real_escape_string($mr_con,$_REQUEST['message']);
		if(count($employee_alias)==0){$res="Please Select an Employee Name";}
		elseif(empty($title)){$res="Please Enter Title";}
		elseif(empty($message)){$res="Please Enter Message";}
		else{ $data_mess="";
			if(admin_privilege($emp_alias)){
				array_push($employee_alias,'ADMIN');
				foreach($employee_alias as $emp_ali){
					$sql=mysqli_query($mr_con,"INSERT INTO ec_notifications(employee_alias,title_ticket,msg_stage,type_ref,notif_alias) VALUES('$emp_ali','$title','$message','2','$notif_alias')");
					$reg_id=alias($emp_ali,'ec_employee_master','employee_alias','reg_id');
					if(!empty($reg_id)){
						if(empty($data_mess)){
							$sql1=mysqli_query($mr_con,"SELECT msg_stage FROM ec_notifications WHERE type_ref='2' AND notif_alias='$notif_alias' AND flag='0' LIMIT 1");
							$row1=mysqli_fetch_array($sql1);
							$data_mess=$row1['msg_stage'];
							notification($reg_id,$data_mess);
						}else notification($reg_id,$data_mess);
					}
				}
				$action= "ADMIN Send the message - ".$message;
				user_history($emp_alias,$action,$_REQUEST['ip_addr']);
				$resCode='0';$resMsg='Successful!';
			}else $res="Your are not an admin";
		}if(isset($res) && !empty($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function notifications_view(){ global $mr_con;
	$emp_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$token=mysqli_real_escape_string($mr_con,trim($_REQUEST['token']));
	$rex=authentication($emp_alias,$token);
	if($rex=='0'){
		$type_ref = [];
		if($emp_alias=="ADMIN"){
			$type_ref = [1, 3, 4, 5, 6, 7, 8];
		} else {
			$qry = "SELECT DISTINCT privilege_item FROM `ec_privileges` WHERE privilege_alias in (SELECT privilege_alias FROM `ec_employee_master` where employee_alias = '$emp_alias') AND flag=0 and grantable = 1";
			$privilegeItems = [];
			$pri_sql = mysqli_query($mr_con, $qry);
			while($pri_row=mysqli_fetch_array($pri_sql)) {
				$privilegeItems[]=$pri_row['privilege_item'];
			}
			if (in_array("TICKET STATUS", $privilegeItems) || in_array("TICKETS", $privilegeItems) || in_array("SPOT TICKETS", $privilegeItems)) {
				$type_ref[] = 1;
			}
			if (in_array("STOCKS", $privilegeItems)) {
				$type_ref[] = 6;
			}
			if (in_array("MATERIAL INWARD", $privilegeItems)) {
				$type_ref[] = 4;
			}
			if (in_array("MATERIAL OUTWARD", $privilegeItems)) {
				$type_ref[] = 5;
			}
			if (in_array("MATERIAL REQUEST", $privilegeItems)) {
				$type_ref[] = 3;
			}
			if (in_array("REVIVAL", $privilegeItems)) {
				$type_ref[] = 7;
			}
			if (in_array("REFRESHING", $privilegeItems)) {
				$type_ref[] = 8;
			}
		}
		/*$conn="";
		if($emp_alias!="ADMIN"){
			$role=alias(alias($emp_alias,'ec_employee_master','employee_alias','role_alias'),'ec_emprole','role_alias','role_stat');
			//if($role=="0" || $role=="1"){$conn=" title_ticket IN(SELECT ticket_alias FROM ec_tickets WHERE service_engineer_alias='$emp_alias') AND ";}
			if($role=="0" || $role=="1"){$conn="( type_ref>'1' OR (type_ref='1' AND title_ticket IN(SELECT ticket_alias FROM ec_tickets WHERE ((service_engineer_alias='$emp_alias' AND level>'1') OR level='1')))) AND ";}
		}*/
		//if(admin_privilege($emp_alias))$emp_alias='ADMIN';
		$qry = "SELECT id FROM ec_notifications WHERE employee_alias='$emp_alias' AND flag='0'";
		if(count($type_ref) > 0) {
			$typeRefStr = implode(",", $type_ref);
			$qry .= " and type_ref in (". $typeRefStr .")";
		} else {
			$result = [
				"ErrorCode" => 4,
				"ErrorMessage" => "No Records Found!",
				"fromRecords" => 0,
				"toRecords" => 0,
				"totalRecords" => 0,
				"pages" => [1 => 1]
			];
			echo json_encode($result);
			exit;
		}
		$notifi=mysqli_query($mr_con, $qry);
		$totalRecords=mysqli_num_rows($notifi);
		if($totalRecords){
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_notifications WHERE employee_alias='$emp_alias' AND flag=0 ORDER BY created_date DESC LIMIT $offset, $limit");
		$result['notification']=array();
		$rowscount=mysqli_num_rows($sql);
		//$result['notification']['x']=$totalRecords."-".$rowscount;
		if($rowscount){
			$i=0;while($row=mysqli_fetch_array($sql)){
				$result['notification'][$i]['alias']=$row['employee_alias'];
				$title_ticket=$row['title_ticket'];
				$msg_stage=$row['msg_stage'];
				$notif_alias=$row['notif_alias'];
				//$result['notification'][$i]['not_admin']=($row['employee_alias']!='ADMIN' ? TRUE : FALSE);
				$type_ref=$row['type_ref'];
				$created_date=$row['created_date'];
				if($type_ref=='1'){//tickets
					$zz = mysqli_query($mr_con,"SELECT ticket_id,site_alias,complaint_alias FROM ec_tickets WHERE ticket_alias='$title_ticket' AND flag=0");
					if(mysqli_num_rows($zz)){ $tt_row=mysqli_fetch_array($zz);
						$ticket_id=$tt_row['ticket_id'];
						$site_alias = $tt_row['site_alias'];
						$site_id=alias_flag_none($site_alias,'ec_sitemaster','site_alias','site_id');
						$customer_name=alias(alias_flag_none($site_alias,'ec_sitemaster','site_alias','customer_alias'),'ec_customer','customer_alias','customer_code');
						$site_loc=alias(alias_flag_none($site_alias,'ec_sitemaster','site_alias','state_alias'),'ec_state','state_alias','state_name')." | ".$customer_name;
						
						$complaint=alias($tt_row['complaint_alias'],'ec_complaint','complaint_alias','complaint_name');
						$title = $ticket_id."|".$site_id;
						$message = $site_loc;
						if($msg_stage!='5')$level_name = "Ticket ".alias($msg_stage,'ec_levels','level_alias','level_name');
						else{
							/*$rem_ss=mysqli_query($mr_con,"SELECT bucket FROM ec_remarks WHERE item_alias='$title_ticket' AND module='TT' AND remarked_on LIKE '".date("Y-m-d H:i",strtotime($created_date))."%' AND flag='0'");
							$re_row=mysqli_fetch_array($rem_ss);
							$level_name = "Ticket ".alias($re_row['bucket'],'ec_remarks_bucket','bucket_level','bucket');*/
							$level_name = "Ticket ".ts_approved_lvl(alias($title_ticket,'ec_tickets','ticket_alias','old_level'));
						}
					}
				}elseif($type_ref=='2'){//Admin massage
					$emp=array();
					$emp_sql = mysqli_query($mr_con,"SELECT t2.name FROM ec_notifications t1 INNER JOIN ec_employee_master t2 ON t1.employee_alias=t2.employee_alias WHERE t1.employee_alias<>'ADMIN' AND t1.notif_alias='$notif_alias' AND t1.flag='0'");
					while($emp_row=mysqli_fetch_array($emp_sql)){$emp[]=$emp_row['name'];}
					$title = $title_ticket;
					$message1=$msg_stage;
					$message = ((strlen($msg_stage) > 30) ? substr($msg_stage,0,30).'....' : $msg_stage);
					$complaint = '';
					$level_name=($emp_alias=='ADMIN' ? "Employees List":"Admin Messege");
				}else{ //Inventory
					//$title = alias($title_ticket,'ec_material_request','mrf_alias','mrf_number');
					$message = $msg_stage;
					//$complaint = '';
					//$level_name = '';
					list($title,$complaint,$level_name)=explode("@_",inv_notif($title_ticket,$type_ref));
				}
				$result['collapse']=($emp_alias=='ADMIN' ? TRUE : FALSE);
				$result['notification'][$i]['emp_name']=$emp;
				$result['notification'][$i]['type_ref']=$type_ref;
				$result['notification'][$i]['title']=$title;
				$result['notification'][$i]['message']=$message;
				$result['notification'][$i]['message_full']=$message1;
				$result['notification'][$i]['complaint']=$complaint;
				$result['notification'][$i]['created_date']=date("d-m-Y",strtotime($created_date));
				$result['notification'][$i]['created_date_time']=date("d-m-Y h:i:s A",strtotime($created_date));
				$result['notification'][$i]['level']=$level_name;
				$i++;}
				$result['noti_count']=count_notification($emp_alias);
		}else{$resCode='4';$resMsg='No Records Found!';}
	}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function count_notification($emp_alias){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT id FROM ec_notifications WHERE employee_alias = '$emp_alias' AND status='0' AND flag=0");
	return mysqli_num_rows($sql);
}
function notification_chng(){ global $mr_con;
	$emp_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$q1=mysqli_query($mr_con,"UPDATE ec_notifications SET status='1' WHERE employee_alias='$emp_alias' AND flag='0'");
	if($q1){$resCode='0';$resMsg='Successful!';}
	else{$resCode='4';$resMsg='Un Successful!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);	
}
function inv_notif($title_ticket,$type_ref){ global $mr_con;
	if($type_ref=='3'){ //Request
		$sql=mysqli_query($mr_con,"SELECT mrf_number,sjo_number FROM ec_material_request WHERE mrf_alias='$title_ticket' AND flag='0'");
		$row=mysqli_fetch_array($sql);
		$title=$row['mrf_number'];
		$complaint=$row['sjo_number'];
		$level_name="MATERIAL REQUEST";
	}elseif($type_ref=='4'){ //Inward
		$sql=mysqli_query($mr_con,"SELECT trans_id,ref_no,inv_num FROM ec_material_inward WHERE alias='$title_ticket' AND flag='0'");
		$row=mysqli_fetch_array($sql);
		$title=$row['trans_id'];
		$complaint=$row['inv_num'];
		$level_name="MATERIAL INWARD";
	}elseif($type_ref=='5'){ //Outward
		$sql=mysqli_query($mr_con,"SELECT trans_id,ref_no,docket FROM ec_material_outward WHERE alias='$title_ticket' AND flag='0'");
		$row=mysqli_fetch_array($sql);
		$title=$row['trans_id'];
		$complaint=$row['docket'];
		$level_name="MATERIAL OUTWARD";
	}elseif($type_ref=='6'){ //Stocks
		$sql=mysqli_query($mr_con,"SELECT item_description,item_type,invoice_no FROM ec_item_code WHERE sjo_no='$title_ticket' AND flag='0'");
		$row=mysqli_fetch_array($sql);
		$title=alias($title_ticket,'ec_material_request','mrf_alias','sjo_number');
		$complaint=($row['item_type']=='1' ? "CELLS":"ACCESSORIES" );
		$level_name=($row['invoice_no']=='' ? "STOCK":"INVOICE")." ADDED";
	}elseif($type_ref=='7' || $type_ref=='8'){ // Revival & Refreshing
		if($type_ref=='7'){$get="revival_no";$tb="ec_material_revival";}else{$get="refreshing_no";$tb="ec_material_refreshing";}
		$sql=mysqli_query($mr_con,"SELECT $get,wh_alias FROM $tb WHERE item_alias='$title_ticket' AND flag='0'");
		$row=mysqli_fetch_array($sql);
		$title=$row[$get]."|".alias($row['wh_alias'],'ec_warehouse','wh_alias','wh_code');
		$complaint="";
		$level_name=($type_ref=='7' ? "REVIVAL":"REFRESHING" );
	}
	return $title."@_".$complaint."@_".$level_name;
}