<?php
date_default_timezone_set("Asia/Kolkata");
require ('../../Slim/Slim.php');
include ('../../mysql.php');
include ('../../functions.php');
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->get('/mrmails','materialRequestMails');
$app->get('/mrtmails','materialaTransitDamageMails');
$app->get('/mrsmails','materialShortClosedMails');
$app->get('/mrdmails','materialDynamicMails');
$app->get('/mpmails','materialPPCMails');
$app->get('/midmails','materialInvoiceDispatchMails');
$app->get('/mimails','materialInwardMails');
$app->get('/momails','MaterialOutwardMails');
$app->get('/mremails','materialRevivalMails');
$app->get('/mrfmails','materialRefreshMails');
$app->run();
$newAddress = "<p style='font-size:11px; font-weight:600;'>Registered Office: EnerSys India Batteries Private Limited, 
Survey N.118,135,137 & 139, Narasimharaopalem (Village),
Veerullapadu (Mandal), VIJAYAWADA ,Krishna (District),
Andhra Pradesh-521181, India, 
Ph :9652525292, E-Mail : service@enersys.co.in</p>";
function materialRequestMails(){
	global $mr_con;
	global $newAddress;
	//$_REQUEST['a']="XR250WLGUF";
	$mrf_alias=$_REQUEST['a'];
	$sql = mysqli_query($mr_con,"SELECT mrf_number,sjo_file,sjo_number,sjo_date,sales_invoice_no,sales_invoice_date,sales_po_no,contact_person,customer_address,customer_phone,customer_alias,from_wh, to_wh, date_of_request, material_value, sjo_number, ticket_alias, status, mrf_alias FROM ec_material_request WHERE mrf_alias ='$mrf_alias' AND flag=0");
	if(mysqli_num_rows($sql)>'0'){
		$row=mysqli_fetch_array($sql);
		$item_type=array();
		$mrf_number=$row['mrf_number'];
		$from_wh_alias = $row['from_wh'];
		$from_wh=alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code');
		$to_wh=alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code');
		$date_of_request=dateFormat($row['date_of_request'],'d');
		$ticket_alias=$row['ticket_alias'];
		$ticket_id=j_getticketID($row['ticket_alias']);
		$customer_alias=$row['customer_alias'];
		$sjo_number=$row['sjo_number'];
		$sjo_date=dateFormat($row['sjo_date'],'d');
		$sjo_file=$row['sjo_file'];
		$sql2 = mysqli_query($mr_con,"SELECT remarks FROM ec_remarks WHERE item_alias ='$mrf_alias' AND module='MR' AND bucket='16' AND flag=0");
		if(mysqli_num_rows($sql2)){$row2=mysqli_fetch_array($sql2);$remarks=$row2['remarks'];}else{$remarks="NA";}
		$sql1 = mysqli_query($mr_con,"SELECT * FROM ec_request_items WHERE mrf_alias ='$mrf_alias' AND flag=0");
		if(mysqli_num_rows($sql1)){
			$i=0;while($row1=mysqli_fetch_array($sql1)){
				$item_type[$i]=$row1['item_type'];
				$item_description[$i]=getitemname($item_type[$i],$row1['item_description']);
				$quantity[$i]=$row1['quantity'];
			$i++;}
		}
		$sub = "Material Request to ".$to_wh." - ".$sjo_number." - ".date("d-m-Y");
		$body="<p>Dear Team,</p>";
		$body.="<p>New Material Request is Raised</p>";
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
									$body.="<td align='right' style='font-size:13px;'><b>Date : </b>".$date_of_request."</td>";
								$body.="</tr>";
							$body.="</table>";
							$body.="<table width='100%' cellpadding='5'>";
								$body.="<tr>";
									$body.="<td align='right'><b>MRF No </b>: ".$mrf_number."</td>";
								$body.="</tr>";
							$body.="<tr>";
								$body.="<td align='right'><b>SJO No  & Date</b>: ".$sjo_number." / ".$sjo_date."</td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table width='100%' cellpadding='2'>";
							$body.="<tr>";
								$body.="<td align='center'><u><h5 style='margin:2px;'>ACKNOWLEDGEMENT FOR MATERIAL REQUEST</h5></u></td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table border='1' width='95%' style='border-collapse:collapse; border:1px solid #ddd' cellpadding='8'>";
							$body.="<tr>";
								$body.="<td><b>Material Requested By: </b>".$from_wh."</td>";
								$body.="<td><b>Material Requested To :</b> ".$to_wh."</td>";
							$body.="</tr>";
							$body.="<tr>";
								$body.="<td><b>TT Number / WH :</b> ".($ticket_alias=='0' ? $to_wh:$ticket_id)."</td>";
								$body.="<td><b>Customer :</b> ".($ticket_alias=='2609' ? alias($customer_alias,'ec_customer','customer_alias','customer_name'):alias(alias(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','customer_alias'),'ec_customer','customer_alias','customer_name'))."</td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table width='100%' cellpadding='6' style='margin-left:22px;'>";
							$body.="<tr>";
								$body.="<td align='left'><b>Remarks : </b>".$remarks."</td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table width='100%' cellpadding='2'>";
							$body.="<tr>";
								$body.="<td align='center'><u><h5 style='margin:2px;'>REQUIRED ITEMS</h5></u></td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table border='1' width='95%' style='border-collapse:collapse; border:1px solid #ddd' cellpadding='5'>";
							$body.="<tr align='left'><th>SL No.</th><th>Type</th><th>Item</th><th>Quantity</th></tr>";
							for($r=0;$r<count($item_type);$r++){
							$body.="<tr>";
								$body.="<td>".($r+1)."</td>";
								$body.="<td>".($item_type[$r]==1 ? "Cell":"Accessory")."</td>";
								$body.="<td>".$item_description[$r]."</td>";
								$body.="<td>".$quantity[$r]."</td>";
							$body.="</tr>";
							}	
						$body.="</table>";
						$body.="<table width='100%' cellpadding='3' style='margin-left:20px;'>";
							$body.="<tr>";
								$body.="<td align='left'>For details please go through the SJO Enclosed <a href='".baseurl().$sjo_file."' target='_blank'>Click here</a></td>";
							$body.="</tr>";
							$body.="<tr>";
								$body.="<td align='left'></td>";
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
										$body.=$newAddress;
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
		//To and Cc mail IDS'
		$mr_to=array();$mr_cc=array();$nhs_m=array();$zhs_m=array();$se_m=array();$ho_m=array();
		$conn=sub_query($row['from_wh'],$row['to_wh']);
		$nhs_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='WIMYJFDJPT' AND flag=0 AND status='WORKING'");//nhs
		$zhs_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='OX5E3EMI0U' AND $conn flag=0 AND status='WORKING'");//zhs
		$hoco_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='5KPS8Q0ZNB' AND flag=0 AND status='WORKING'");//onrole se
		//$sereng_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='3WDRECJ0MA' AND $conn flag=0 AND status='WORKING'");//onrole se
		while($nhs_row=mysqli_fetch_array($nhs_query)){$nhs_m[]=$nhs_row['email_id'];}
		while($zhs_row=mysqli_fetch_array($zhs_query)){$zhs_m[]=$zhs_row['email_id'];}
		while($hoco_row=mysqli_fetch_array($hoco_query)){$ho_m[]=$hoco_row['email_id'];}
		//while($sereng_row=mysqli_fetch_array($sereng_query)){$se_m[]=$sereng_row['email_id'];}
		/*
		if(alias($row['to_wh'],'ec_warehouse','wh_alias','wh_type')=='1'){
			$mr_to=explode(",",mail_relieved_filter("neeraj@enersys.co.in,somesh@enersys.co.in,chandra@enersys.co.in,Ravikanthp@enersys.co.in,sudhakararaju@enersys.co.in"));
			$mr_cc=explode(",",mail_relieved_filter("anandak@enersys.co.in,sivakumar.p@enersys.co.in,madan@enersys.co.in,rambhupal@enersys.co.in,pradeep@enersys.co.in,saivaranasi@enersys.co.in"));
			$ccmails=array_merge($mr_cc,$nhs_m,$zhs_m,$ho_m);
		}else{
			$mr_to=array_merge($zhs_m,$ho_m);
			$mr_cc=explode(",",mail_relieved_filter("pradeep@enersys.co.in,saivaranasi@enersys.co.in"));
			$ccmails=array_merge($mr_cc,$nhs_m);
		}
		array_push($ccmails,'fieldasset@enersys.co.in');
		if(count($mr_to)>'0'){$mail_Id=implode(", ",array_filter(array_unique($mr_to)));}else $mail_Id="fieldasset@enersys.co.in";
		if(count($ccmails)>'0'){
			$ccmails = array_diff($ccmails, $mr_to);
			$ccmail_id=implode(", ",array_filter(array_unique($ccmails)));
		}else $ccmail_id="fieldasset@enersys.co.in";
		
		$from=all_from_mail();
		$headers="From: EnerSys Inventory<$from>\r\n";
		$headers.="Reply-To: $from\r\n";
		$headers.="Return-Path: $from\r\n";
		$headers .= "CC: $ccmail_id \r\n";
		//$headers .= "BCC: $bccemail \r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$abc = mail($mail_Id,$sub,$body,$headers);
		if($abc)success_mail_log($mrf_alias,"MR");
		else pending_mail_log($mrf_alias,"MR");

		//return $body;
		*/
		$state_alais = alias($from_wh_alias,'ec_warehouse','wh_alias','state_alias');
		$logName = $ticket_alias . "_" . $state_alais;
		// PPC
		$defaultMails = mul_priv_mails('8BSTDFFQEP', 'all');
		$to = implode(",", $defaultMails);
		ecSendMails("mr_md_approved", $state_alias, $sub, $body, $to, $logName, "MR");
	}
}
function materialaTransitDamageMails(){ 
	global $mr_con;
	global $newAddress;
	$mrf_alias=$_REQUEST['a'];
	$sql = mysqli_query($mr_con,"SELECT mrf_number,sjo_file,sjo_number,sjo_date,sales_invoice_no,sales_invoice_date,sales_po_no,contact_person,customer_address,customer_phone,customer_alias,from_wh, to_wh, date_of_request, material_value, sjo_number, ticket_alias, status, mrf_alias FROM ec_material_request WHERE mrf_alias ='$mrf_alias' AND flag=0");
	if(mysqli_num_rows($sql)>'0'){
		$row=mysqli_fetch_array($sql);
		$item_type=array();
		$mrf_number=$row['mrf_number'];
		$from_wh=alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code');
		$to_wh=alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code');
		$date_of_request=dateFormat($row['date_of_request'],'d');
		$ticket_alias=$row['ticket_alias'];
		$ticket_id=j_getticketID($row['ticket_alias']);
		$customer_alias=$row['customer_alias'];
		$sjo_number=$row['sjo_number'];
		$sjo_date=dateFormat($row['sjo_date'],'d');
		$sjo_file=$row['sjo_file'];
		$sql2 = mysqli_query($mr_con,"SELECT remarks FROM ec_remarks WHERE item_alias ='$mrf_alias' AND module='MR' AND bucket='16' AND flag=0");
		if(mysqli_num_rows($sql2)){$row2=mysqli_fetch_array($sql2);$remarks=$row2['remarks'];}else{$remarks="NA";}
		$sql1 = mysqli_query($mr_con,"SELECT * FROM ec_request_items WHERE mrf_alias ='$mrf_alias' AND flag=0");
		if(mysqli_num_rows($sql1)){
			$i=0;while($row1=mysqli_fetch_array($sql1)){
				$item_type[$i]=$row1['item_type'];
				$item_description[$i]=getitemname($item_type[$i],$row1['item_description']);
				$quantity[$i]=$row1['quantity'];
			$i++;}
		}
		$sub = "Transit Damage ".$sjo_number." Initiated";
		$body="<p>Dear Team,</p>";
		$body.="<p>Please find the below Transit Damage SJO details</p>";
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
									$body.="<td align='right' style='font-size:13px;'><b>Date : </b>".$date_of_request."</td>";
								$body.="</tr>";
							$body.="</table>";
							$body.="<table width='100%' cellpadding='5'>";
								$body.="<tr>";
									$body.="<td align='right'><b>MRF No </b>: ".$mrf_number."</td>";
								$body.="</tr>";
							$body.="<tr>";
								$body.="<td align='right'><b>SJO No  & Date</b>: ".$sjo_number." / ".$sjo_date."</td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table width='100%' cellpadding='2'>";
							$body.="<tr>";
								$body.="<td align='center'><u><h5 style='margin:2px;'>ACKNOWLEDGEMENT FOR MATERIAL REQUEST</h5></u></td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table border='1' width='95%' style='border-collapse:collapse; border:1px solid #ddd' cellpadding='8'>";
							$body.="<tr>";
								$body.="<td><b>Material Requested By: </b>".$from_wh."</td>";
								$body.="<td><b>Material Requested To :</b> ".$to_wh."</td>";
							$body.="</tr>";
							$body.="<tr>";
								$body.="<td><b>TT Number / WH :</b> ".($ticket_alias=='0' ? $to_wh:$ticket_id)."</td>";
								$body.="<td><b>Customer :</b> ".($ticket_alias=='2609' ? alias($customer_alias,'ec_customer','customer_alias','customer_name'):alias(alias(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','customer_alias'),'ec_customer','customer_alias','customer_name'))."</td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table width='100%' cellpadding='6' style='margin-left:22px;'>";
							$body.="<tr>";
								$body.="<td align='left'><b>Remarks : </b>".$remarks."</td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table width='100%' cellpadding='2'>";
							$body.="<tr>";
								$body.="<td align='center'><u><h5 style='margin:2px;'>REQUIRED ITEMS</h5></u></td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table border='1' width='95%' style='border-collapse:collapse; border:1px solid #ddd' cellpadding='5'>";
							$body.="<tr align='left'><th>SL No.</th><th>Type</th><th>Item</th><th>Quantity</th></tr>";
							for($r=0;$r<count($item_type);$r++){
							$body.="<tr>";
								$body.="<td>".($r+1)."</td>";
								$body.="<td>".($item_type[$r]==1 ? "Cell":"Accessory")."</td>";
								$body.="<td>".$item_description[$r]."</td>";
								$body.="<td>".$quantity[$r]."</td>";
							$body.="</tr>";
							}	
						$body.="</table>";
						$body.="<table width='100%' cellpadding='3' style='margin-left:20px;'>";
							$body.="<tr>";
								$body.="<td align='left'>For details please go through the SJO Enclosed <a href='".baseurl().$sjo_file."' target='_blank'>Click here</a></td>";
							$body.="</tr>";
							$body.="<tr>";
								$body.="<td align='left'></td>";
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
										$body.=$newAddress;
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
		
		//To and Cc mail IDS'
		$mail_Id="anandak@enersys.co.in";
		$ccmail_id="fieldasset@enersys.co.in";
		$from=all_from_mail();
		$headers="From: EnerSys Inventory<$from>\r\n";
		$headers.="Reply-To: $from\r\n";
		$headers.="Return-Path: $from\r\n";
		$headers .= "CC: $ccmail_id \r\n";
		//$headers .= "BCC: $bccemail \r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$abc = mail($mail_Id,$sub,$body,$headers);
		if($abc)success_mail_log($mrf_alias,"MRT");
		else pending_mail_log($mrf_alias,"MRT");
	}
}
function materialPPCMails() {
	global $mr_con;
	global $newAddress;
	$mrf_alias=$_REQUEST['a'];
	$ppc=$_REQUEST['b'];
	$sql = mysqli_query($mr_con,"SELECT mrf_number,sjo_file,sjo_number,sjo_date,sales_invoice_no,sales_invoice_date,sales_po_no,contact_person,customer_address,customer_phone,customer_alias,from_wh, to_wh, date_of_request, material_value, sjo_number, ticket_alias, status, readiness_date FROM ec_material_request WHERE mrf_alias ='$mrf_alias' AND flag=0");
	if(mysqli_num_rows($sql)>'0'){
		$row=mysqli_fetch_array($sql);
		$item_type=array();
		$mrf_number=$row['mrf_number'];
		$from_wh_alias = $row['from_wh'];
		$from_wh=alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code');
		$road_permit=alias($row['from_wh'],'ec_warehouse','wh_alias','road_permit');
		$to_wh=alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code');
		$date_of_request=dateFormat($row['date_of_request'],'d');
		$ticket_alias=$row['ticket_alias'];
		$ticket_id=j_getticketID($row['ticket_alias']);
		$customer_alias=$row['customer_alias'];
		$sjo_number=$row['sjo_number'];
		$sjo_date=dateFormat($row['sjo_date'],'d');
		$sjo_file=$row['sjo_file'];
		$readiness_date=$row['readiness_date'];
		$sql2 = mysqli_query($mr_con,"SELECT remarks FROM ec_remarks WHERE item_alias ='$mrf_alias' AND module='MR' AND bucket='16' AND flag=0");
		if(mysqli_num_rows($sql2)){$row2=mysqli_fetch_array($sql2);$remarks=$row2['remarks'];}else{$remarks="NA";}
		$sql1 = mysqli_query($mr_con,"SELECT * FROM ec_request_items WHERE mrf_alias ='$mrf_alias' AND flag=0");
		if(mysqli_num_rows($sql1)){
			$i=0;while($row1=mysqli_fetch_array($sql1)){
				$item_type[$i]=$row1['item_type'];
				$item_description[$i]=getitemname($item_type[$i],$row1['item_description']);
				$quantity[$i]=$row1['quantity'];
				$tappr_quanty[$i]=$row1['tappr_quanty'];
				$sent_quanty[$i]=($row1['quantity']-$row1['left_quanty']);
			$i++;}
		}
		$sub = "PPC Material ".($ppc=='c' ? "Clearance" : "Revised")." - ".$sjo_number." - ".date("d-m-Y");
		$body="<p>Dear Team,</p>";
		$body.="<p>Please find the below Material Readiness details agianst subjected SJO Number</p>";
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
									$body.="<td align='right' style='font-size:13px;'><b>Date : </b>".$date_of_request."</td>";
								$body.="</tr>";
							$body.="</table>";
							$body.="<table width='100%' cellpadding='5'>";
								$body.="<tr>";
									$body.="<td align='right'><b>MRF No </b>: ".$mrf_number."</td>";
								$body.="</tr>";
							$body.="<tr>";
								$body.="<td align='right'><b>SJO No  & Date</b>: ".$sjo_number." / ".$sjo_date."</td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table width='100%' cellpadding='2'>";
							$body.="<tr>";
								$body.="<td align='center'><u><h5 style='margin:2px;'>ACKNOWLEDGEMENT FOR MATERIAL READINESS ".($ppc=='c' ? "CLEARANCE" : "REVISED")."</h5></u></td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table border='1' width='95%' style='border-collapse:collapse; border:1px solid #ddd' cellpadding='8'>";
							$body.="<tr>";
								$body.="<td><b>Material Requested By: </b>".$from_wh."</td>";
								$body.="<td><b>Material Requested To :</b> ".$to_wh."</td>";
							$body.="</tr>";
							$body.="<tr>";
								$body.="<td><b>TT Number / WH :</b> ".($ticket_alias=='0' ? $to_wh:$ticket_id)."</td>";
								$body.="<td><b>Customer :</b> ".($ticket_alias=='2609' ? alias($customer_alias,'ec_customer','customer_alias','customer_name'):alias(alias(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','customer_alias'),'ec_customer','customer_alias','customer_name'))."</td>";
							$body.="</tr>";
							$body.="<tr>";
								$body.="<td><b>Road Permit :</b> ".get_road_permit($road_permit)."</td>";
								$body.="<td><b>Material Readiness Date :</b> ".dateFormat($readiness_date,'d')."</td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table width='100%' cellpadding='6' style='margin-left:22px;'>";
							$body.="<tr>";
								$body.="<td align='left'><b>Remarks : </b>".$remarks."</td>";
							$body.="</tr>";
						$body.="</table>";
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
						$body.="</table>";
						$body.="<table width='100%' cellpadding='3' style='margin-left:20px;'>";
							$body.="<tr>";
								$body.="<td align='left'>For details please go through the SJO Enclosed <a href='".baseurl().$sjo_file."' target='_blank'>Click here</a></td>";
							$body.="</tr>";
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
										$body.=$newAddress;
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
		//To and Cc mail IDS'
		$mr_to=array();$mr_cc=array();$nhs_m=array();$zhs_m=array();$se_m=array();$ho_m=array();
		$conn=sub_query($row['from_wh'],$row['to_wh']);
		$mailFlag = "PPCR";
		if($ppc == 'c') {
			$mailFlag = "PPCC";
		}
		$state_alais = alias($from_wh_alias,'ec_warehouse','wh_alias','state_alias');
		// Factory QC
		$defaultMails = mul_priv_mails('DWH4PLGSLK', 'all');
		$logName = $ticket_alias . "_" . $state_alais;
		$to = implode(",", $defaultMails);
		ecSendMails("mr_ppc_updated", $state_alias, $sub, $body, $to, $logName, $ppc);
	}
}

function materialInvoiceDispatchMails() {
	global $mr_con;
	global $newAddress;
	$mrf_alias=$_REQUEST['a'];
	$invd=$_REQUEST['b'];
	$sql = mysqli_query($mr_con,"SELECT mrf_number,sjo_file,sjo_number,sjo_date,sales_invoice_no,sales_invoice_date,sales_po_no,contact_person,customer_address,customer_phone, from_wh, to_wh, date_of_request, material_value, sjo_number, ticket_alias, status, readiness_date FROM ec_material_request WHERE mrf_alias ='$mrf_alias' AND flag=0");
	if(mysqli_num_rows($sql)>'0'){
		$row=mysqli_fetch_array($sql);
		$item_type=array();
		$mrf_number=$row['mrf_number'];
		$from_wh_alias = $row['from_wh'];
		$from_wh=alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code');
		$road_permit=alias($row['from_wh'],'ec_warehouse','wh_alias','road_permit');
		$to_wh=alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code');
		$date_of_request=dateFormat($row['date_of_request'],'d');
		$ticket_alias=$row['ticket_alias'];
		$ticket_id=j_getticketID($row['ticket_alias']);
		$sjo_number=$row['sjo_number'];
		$sjo_date=dateFormat($row['sjo_date'],'d');
		$sjo_file=$row['sjo_file'];
		$readiness_date=$row['readiness_date'];
		$sql2 = mysqli_query($mr_con,"SELECT remarks FROM ec_remarks WHERE item_alias ='$mrf_alias' AND module='MR' AND bucket='16' AND flag=0");
		if(mysqli_num_rows($sql2)){$row2=mysqli_fetch_array($sql2);$remarks=$row2['remarks'];}else{$remarks="NA";}
		$sql1 = mysqli_query($mr_con,"SELECT * FROM ec_request_items WHERE mrf_alias ='$mrf_alias' AND flag=0");
		if(mysqli_num_rows($sql1)){
			$i=0;while($row1=mysqli_fetch_array($sql1)){
				$item_type[$i]=$row1['item_type'];
				$item_description[$i]=getitemname($item_type[$i],$row1['item_description']);
				$quantity[$i]=$row1['quantity'];
				$tappr_quanty[$i]=$row1['tappr_quanty'];
				$sent_quanty[$i]=($row1['quantity']-$row1['left_quanty']);
			$i++;}
		}
		$sub = "SJO awaiting for ".($invd=='i' ? "INVOICE" : "DISPATCH")." details - ".$sjo_number." - ".date("d-m-Y");
		$body="<p>Dear Team,</p>";
		$body.="<p>As subjected kindly add the ".($invd=='i' ? "INVOICE" : "DISPATCH")." details for the subjected SJO Number</p>";
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
									$body.="<td align='right' style='font-size:13px;'><b>Date : </b>".$date_of_request."</td>";
								$body.="</tr>";
							$body.="</table>";
							$body.="<table width='100%' cellpadding='5'>";
								$body.="<tr>";
									$body.="<td align='right'><b>MRF No </b>: ".$mrf_number."</td>";
								$body.="</tr>";
							$body.="<tr>";
								$body.="<td align='right'><b>SJO No  & Date</b>: ".$sjo_number." / ".$sjo_date."</td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table width='100%' cellpadding='2'>";
							$body.="<tr>";
								$body.="<td align='center'><u><h5 style='margin:2px;'>MATERIAL AWAITING FOR ".($invd=='i' ? "INVOICE" : "DISPATCH")."</h5></u></td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table border='1' width='95%' style='border-collapse:collapse; border:1px solid #ddd' cellpadding='8'>";
							$body.="<tr>";
								$body.="<td><b>Material Requested By: </b>".$from_wh."</td>";
								$body.="<td><b>Material Requested To :</b> ".$to_wh."</td>";
							$body.="</tr>";
							$body.="<tr>";
								$body.="<td><b>TT Number / WH :</b> ".($ticket_alias=='0' ? $to_wh:$ticket_id)."</td>";
								$body.="<td><b>Customer :</b> ".($ticket_alias=='0' ? 'NA':alias(alias(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','customer_alias'),'ec_customer','customer_alias','customer_name'))."</td>";
							$body.="</tr>";
							$body.="<tr>";
								$body.="<td><b>Road Permit :</b> ".get_road_permit($road_permit)."</td>";
								$body.="<td><b>Material Readiness Date :</b> ".dateFormat($readiness_date,'d')."</td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table width='100%' cellpadding='6' style='margin-left:22px;'>";
							$body.="<tr>";
								$body.="<td align='left'><b>Remarks : </b>".$remarks."</td>";
							$body.="</tr>";
						$body.="</table>";
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
						$body.="</table>";
						$body.="<table width='100%' cellpadding='3' style='margin-left:20px;'>";
							$body.="<tr>";
								$body.="<td align='left'>For details please go through the SJO Enclosed <a href='".baseurl().$sjo_file."' target='_blank'>Click here</a></td>";
							$body.="</tr>";
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
										$body.=$newAddress;
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
		/*
		//To and Cc mail IDS'
		$mail_Id=($invd=='i' ? mail_relieved_filter("sudhakararaju@enersys.co.in") : mail_relieved_filter("Ravikanthp@enersys.co.in"));
		$ccmail_id="fieldasset@enersys.co.in";
		$from=all_from_mail();
		$headers="From: EnerSys Inventory<$from>\r\n";
		$headers.="Reply-To: $from\r\n";
		$headers.="Return-Path: $from\r\n";
		$headers .= "CC: $ccmail_id \r\n";
		//$headers .= "BCC: $bccemail \r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$abc = mail($mail_Id,$sub,$body,$headers);
		if($abc)success_mail_log($mrf_alias,($invd=='i' ? "INVC" : "DISP"));
		else pending_mail_log($mrf_alias,($invd=='i' ? "INVC" : "DISP"));
		*/
		$state_alais = alias($from_wh_alias, 'ec_warehouse', 'wh_alias', 'state_alias');
		if($invd == 'i') {
			$mailFlag = "INVC";
			// Factory invoice
			$defaultMails = mul_priv_mails('BWIHQNHG8F', 'all');
			$mailType = 'mr_invoice_req';
		} else {
			$mailFlag = "DISP";
			// Factory logistics
			$defaultMails = mul_priv_mails('GM5I41RNLO', 'all');
			$mailType = 'mr_dispatch_req';
		}
		$logName = $ticket_alias . "_" . $state_alais;
		$to = implode(",", $defaultMails);
		ecSendMails($mailType, $state_alias, $sub, $body, $to, $logName, $mailFlag);

	}
}
function materialInwardMails() {
	global $mr_con;
	global $newAddress;
	//$_REQUEST['a']="NSX9MMQXRF";
	$alias=$_REQUEST['a'];
	$sql = mysqli_query($mr_con,"SELECT from_type, from_wh, to_wh, date_of_trans, transport, docket, dispatch_date, ref_no, trans_id FROM ec_material_inward WHERE alias ='$alias' AND flag=0");
	if(mysqli_num_rows($sql)){
		$row=mysqli_fetch_array($sql);
		$item_type=array();
		$trans_id=$row['trans_id'];
		$date_of_request=dateFormat($row['date_of_trans'],'d');
		$from_type=$row['from_type'];
		$from_wh_alias=$row['from_wh'];
		list($mrf_number,$sjo,$ticket_id)=explode("@",in_m_s_t($row['from_type'],$row['from_wh'],$row['ref_no']));
		$ticket_alias=$row['ref_no'];
		if($row['from_type']=='2')$from_wh=alias($row['from_wh'],'ec_sitemaster','site_alias','site_name');
		elseif($row['from_type']=='1') $from_wh=alias($row['from_wh'],'ec_sitemaster','site_alias','site_name');
		else $from_wh=alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code');
		$to_wh=alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code');
		$transport_no=$row['transport'];
		$docket_no=$row['docket'];
		$dispatch_date=$row['dispatch_date'];
		$sql1 = mysqli_query($mr_con,"SELECT item_condition, item_type, item_code,item_description, count(id) as contx FROM ec_material_received_details WHERE reference='$alias' AND flag=0 GROUP BY item_code");
		if(mysqli_num_rows($sql1)){$i=0;$lccount=0;
			while($row1=mysqli_fetch_array($sql1)){
				$item_type[$i]=$row1['item_type'];
				$item_description[$i]=getitemname($item_type[$i],$row1['item_code']);
				$quantity[$i]=($row1['item_type']=='1' ? $row1['contx'] : alias($row1['item_description'],'ec_item_code','item_code_alias','quantity'));
				if($row1['item_condition']=='4' || $row1['item_condition']=='7'){$lccount+=1;}
			$i++;}
		}
		$sql2 = mysqli_query($mr_con,"SELECT remarks FROM ec_remarks WHERE item_alias ='$alias' AND module='MI' AND flag=0 LIMIT 1");
		if(mysqli_num_rows($sql2)){$row2=mysqli_fetch_array($sql2);$remarks=$row2['remarks'];}else{$remarks="NA";}
	}
	$consjo=(!empty($sjo) && $sjo!='-' ? "- ".$sjo." -" : "-");
	$sub = ($from_type!='3' ? "Scrap" : "New")." Material Inward ".$consjo." ".$date_of_request;
	$body="<p>Dear Team,</p>";
	$body.="<p>Below are the Inward Details</p>";
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
								$body.="<td align='right' style='font-size:13px;'><b>Date : </b>".$date_of_request."</td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table width='100%' cellpadding='5'>";
						if($from_type=='3'){
							$body.="<tr>";
								$body.="<td align='right'><b>MRF No </b>: ".$mrf_number."</td>";
							$body.="</tr>";
							$body.="<tr>";
								$body.="<td align='right'><b>SJO No </b> : ".$sjo."</td>";
							$body.="</tr>";
						}
						$body.="</table>";
						$body.="<table width='100%' cellpadding='2'>";
							$body.="<tr>";
								$body.="<td align='center'><u><h5 style='margin:2px;'>ACKNOWLEDGEMENT FOR MATERIAL IN WARD</h5></u></td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table border='1' width='95%' style='border-collapse:collapse; border:1px solid #ddd' cellpadding='8'>";
							$body.="<tr>";
								$body.="<td><b>Material Receiving By : </b> ".$to_wh."</td>";
								$body.="<td><b>Material Receiving  From :</b> ".$from_wh."</td>";
							$body.="</tr>";
							if($from_type=='1'){
							$body.="<tr>";
								$body.="<td><b>TT Number : ".$ticket_id."</b></td>";
								$body.="<td><b>Customer :</b> ".alias(alias(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','customer_alias'),'ec_customer','customer_alias','customer_name')."</td>";
							$body.="</tr>";
							}
							$body.="<tr>";
								$body.="<td><b>Inward Date  :</b>".$dispatch_date."</td>";
								$body.="<td><b>Transporter Details :</b> ".$transport_no."</td>";
							$body.="</tr>";
							$body.="<tr>";
								$body.="<td><b>Docket Number :</b> ".$docket_no."</td>";
								$body.="<td><b>Transaction ID :</b> ".$trans_id." </td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table width='100%' cellpadding='6' style='margin-left:22px;'>"; 
							$body.="<tr>";
								$body.="<td align='left'><b>Remarks : </b>".$remarks."</td>";
							$body.="</tr>";
						$body.="</table><br>";
						$body.="<table width='100%' cellpadding='2'>";
							$body.="<tr>";
								$body.="<td align='center'><u><h5 style='margin:2px;'>RECEIVED ITEMS</h5></u></td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table border='1' width='95%' style='border-collapse:collapse; border:1px solid #ddd' cellpadding='5'>";
							$body.="<tr align='left'><th>SL NO</th><th>Type</th><th>Item</th><th>Quantity</th></tr>";
							for($r=0;$r<count($item_type);$r++){
							$body.="<tr>";
								$body.="<td>".($r+1)."</td>";
								$body.="<td>".($item_type[$r]==1 ? "Cell":"Accessory")."</td>";
								$body.="<td>".$item_description[$r]."</td>";
								$body.="<td>".$quantity[$r]."</td>";
							$body.="</tr>";
							}	
						$body.="</table><br><br><br>";
						$body.="<table width='100%' cellpadding='5'>";
							if($lccount>'0'){
							$body.="<tr>";
								$body.="<td align='left'>Out of total ".array_sum($quantity)."Cells, ".$lccount." Cells are Transit Damaged/Lost</td>";
							$body.="</tr>";
							}
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
									$body.="<td align='center'>";
										$body.=$newAddress;
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
	//To and Cc mail IDS'

	$state_alais = alias($from_wh_alias, 'ec_warehouse', 'wh_alias', 'state_alias');
	if(alias($row['from_wh'], 'ec_warehouse', 'wh_alias', 'wh_type') == '1') {
		// From Factory
		// To Warehouse
		// Factory Logistics
		$defaultMails = mul_priv_mails('GM5I41RNLO', 'all');
		$mailType = 'mi_at_wh';
	} else {
		// From warehouse or Site
		if(alias($row['to_wh'], 'ec_warehouse', 'wh_alias', 'wh_type') == '1') {
			// From Warehouse
			$state_alais = alias($row['from_wh'], 'ec_warehouse', 'wh_alias', 'state_alias');
		} else {
			// From Site
			$state_alais = alias($row['from_wh'], 'ec_sitemaster', 'site_alias', 'state_alias');
		}
		// ZHS
		$defaultMails = mul_priv_mails('OX5E3EMI0U', $state_alais);
		$mailType = 'mi_at_fc';
	}
	$logName = $ticket_alias . "_" . $state_alais;
	$to = implode(",", $defaultMails);
	ecSendMails($mailType, $state_alias, $sub, $body, $to, $logName, 'MI');

}
function MaterialOutwardMails() {
	global $mr_con;
	global $newAddress;
	//$_REQUEST['a']="MZIEIOHYS8";
	$alias=$_REQUEST['a'];
	$sql = mysqli_query($mr_con,"SELECT from_type, from_wh, to_wh, date_of_trans, totalamount, transport, docket, dispatch_date, ref_no, sjo_number, alias, trans_id, resp_engineer FROM ec_material_outward WHERE alias ='$alias' AND flag=0");
	if(mysqli_num_rows($sql)){
		$row=mysqli_fetch_array($sql);
		$eidddddd=alias($row['resp_engineer'],'ec_employee_master','employee_alias','email_id');
		$trans_id=$row['trans_id'];
		$from_type=$row['from_type'];
		if($row['from_type']=='1')$to_wh=alias($row['to_wh'],'ec_sitemaster','site_alias','site_name');else $to_wh=alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code');
		$from_wh=alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code');
		$date_of_request=dateFormat($row['date_of_trans'],'d');
		$transport_no=$row['transport'];
		$docket_no=$row['docket'];
		$dispatch_date=dateFormat($row['dispatch_date'],'d');
		$ticket_alias=$row['ref_no'];
		list($mrf_number,$sjo,$ticket_id)=explode("@",out_m_s_t($row['from_type'],$row['to_wh'],$row['ref_no'],$row['sjo_number']));
		$sql1 = mysqli_query($mr_con,"SELECT item_condition,item_type, item_code,item_description, count(id) as contx FROM ec_material_sent_details WHERE reference='$alias' AND flag=0 GROUP BY item_code");
		if(mysqli_num_rows($sql1)){$i=0;$lccount=0;
			while($row1=mysqli_fetch_array($sql1)){
				$item_type[$i]=$row1['item_type'];
				$item_description[$i]=getitemname($item_type[$i],$row1['item_code']);
				$quantity[$i]=($row1['item_type']=='1' ? $row1['contx'] : alias($row1['item_description'],'ec_item_code','item_code_alias','quantity'));
				if($row1['item_condition']=='4' || $row1['item_condition']=='7'){$lccount+=1;}
			$i++;}
		}
		$sql2 = mysqli_query($mr_con,"SELECT remarks FROM ec_remarks WHERE item_alias ='$alias' AND module='MO' AND flag=0 LIMIT 1");
		if(mysqli_num_rows($sql2)){$row2=mysqli_fetch_array($sql2);$remarks=$row2['remarks'];}else{$remarks="NA";}
	}
	$consjo=(!empty($sjo) && $sjo!='-' ? "- ".$sjo." -" : "-");
	$sub=($from_type=='2' ? "Scrap" : "New")." Material Outward ".$consjo." ".$date_of_request;
	$body="<p>Dear Team,</p>";
	$body.="<p>Below are the outward Details</p>";
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
								$body.="<td align='right' style='font-size:13px;'><b>Date : </b>".$date_of_request."</td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table width='100%' cellpadding='5'>";
							if($from_type=='3'){
							$body.="<tr>";
								$body.="<td align='right' ><b>MRF No </b>: ".$mrf_number."</td>";
							$body.="</tr>";
							$body.="<tr>";
								$body.="<td align='right'><b>SJO No </b> : ".$sjo."</td>";
							$body.="</tr>";
							}
						$body.="</table>";
						$body.="<table width='100%' cellpadding='2'>";
							$body.="<tr>";
								$body.="<td align='center'><u><h5 style='margin:2px;'>ACKNOWLEDGEMENT FOR MATERIAL OUTWARD</h5></u></td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table border='1' width='95%' style='border-collapse:collapse; border:1px solid #ddd' cellpadding='8'>";
							$body.="<tr>";
								$body.="<td width='50%'><b>Material Send from : </b> ".$from_wh."</td>";
								$body.="<td><b>Material Send to :</b>".$to_wh."</td>";
							$body.="</tr>";
							if($from_type=='1'){
								$customer=alias(alias(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','customer_alias'),'ec_customer','customer_alias','customer_name');
							$body.="<tr>";
								$body.="<td><b>TT Number : ".$ticket_id."</b></td>";
								$body.="<td><b>Customer :</b> ".$customer."</td>";
							$body.="</tr>";
							}
							$body.="<tr>";
								$body.="<td><b>Dispatch Date  :</b> ".$dispatch_date."</td>";
								$body.="<td><b>Transporter Details :</b>".$transport_no."</td>";
							$body.="</tr>";
							$body.="<tr>";
								$body.="<td><b>Docket Number :</b> ".$docket_no."</td>";
								$body.="<td><b>Transaction ID :</b> ".$trans_id."</td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table width='100%' cellpadding='6' style='margin-left:22px;'>";
							$body.="<tr>";
								$body.="<td align='left'><b>Remarks : </b>".$remarks."</td>";
							$body.="</tr>";
						$body.="</table><br>";
						$body.="<table width='100%' cellpadding='2'>";
							$body.="<tr>";
								$body.="<td align='center'><u><h5 style='margin:2px;'>OUTWARD ITEMS</h5></u></td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table border='1' width='95%' style='border-collapse:collapse; border:1px solid #ddd' cellpadding='5'>";
							$body.="<tr><th>SL NO</th><th>Type</th><th >Item</th><th>Quantity</th></tr>";
							for($r=0;$r<count($item_type);$r++){
							$body.="<tr>";
								$body.="<td>".($r+1)."</td>";
								$body.="<td>".($item_type[$r]==1 ? "Cell":"Accessory")."</td>";
								$body.="<td>".$item_description[$r]."</td>";
								$body.="<td>".$quantity[$r]."</td>";
							$body.="</tr>";
							}	
						$body.="</table><br><br><br>";
						$body.="<table width='100%' cellpadding='5'>";
							if($lccount>'0'){
							$body.="<tr>";
								$body.="<td align='left'>Out of total ".array_sum($quantity)."Cells, ".$lccount." Cells are Transit Damaged/Lost</td>";
							$body.="</tr>";
							}
							$body.="<tr>";
								$body.="<td align='left'>For details please go through the declaration Enclosed <a href='https://enersyscare.co.in/services/inventory/declaration.php?mo_alias=".$alias."' target='_blank'>Click here</a><br><br></td>";
							$body.="</tr>";
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
									$body.="<td align='center'>";
										$body.=$newAddress;
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
	//To and Cc mail IDS'
	$mr_to=array();$mr_cc=array();$nhs_m=array();$zhs_m=array();$se_m=array();$ho_m=array();
	$conn=sub_query($row['from_wh'],$row['to_wh']);
	$nhs_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='WIMYJFDJPT' AND flag=0 AND status='WORKING'");//nhs
	$zhs_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='OX5E3EMI0U' AND $conn flag=0 AND status='WORKING'");//zhs
	$hoco_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='5KPS8Q0ZNB' AND flag=0 AND status='WORKING'");//onrole se
	//$sereng_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='3WDRECJ0MA' AND $conn flag=0 AND status='WORKING'");//onrole se
	while($nhs_row=mysqli_fetch_array($nhs_query)){$nhs_m[]=$nhs_row['email_id'];}
	while($zhs_row=mysqli_fetch_array($zhs_query)){$zhs_m[]=$zhs_row['email_id'];}
	while($hoco_row=mysqli_fetch_array($hoco_query)){$ho_m[]=$hoco_row['email_id'];}
	//while($sereng_row=mysqli_fetch_array($sereng_query)){$se_m[]=$sereng_row['email_id'];}
	$se_m[]=$eidddddd;

	$state_alais = alias($row['from_wh'], 'ec_warehouse', 'wh_alias', 'state_alias');
	if(alias($row['to_wh'], 'ec_warehouse', 'wh_alias', 'wh_type') == '1') { 
		// To Factory
		// FACTORY SCRAP INWARD & TS
		$defaultMails = mul_priv_mails('8NHXNU4NDP', 'all');
		$mailType = 'mo_at_fc';
	} else { 
		// To Warehouse or Site
		if(alias($row['from_wh'], 'ec_warehouse', 'wh_alias', 'wh_type') == '1') { 
			// To Warehouse
			$state_alais = alias($row['to_wh'], 'ec_warehouse', 'wh_alias', 'state_alias');	
		} else { 
			// To Site
			$state_alais = alias($row['to_wh'], 'ec_sitemaster', 'site_alias', 'state_alias');
		}
		// ZHS
		$defaultMails = mul_priv_mails('OX5E3EMI0U', $state_alais);
		$mailType = 'mo_at_wh';
	}
	/*
	array_push($ccmails,"fieldasset@enersys.co.in");
	if(count($mr_to)>'0'){$mail_Id=implode(", ",array_filter(array_unique($mr_to)));}else $mail_Id="fieldasset@enersys.co.in";
	if(count($ccmails)>'0'){
		$ccmails = array_diff($ccmails, $mr_to);
		$ccmail_id=implode(", ",array_filter(array_unique($ccmails)));
	}else $ccmail_id="fieldasset@enersys.co.in";
	$from=all_from_mail();
	$headers="From: EnerSys Inventory<$from>\r\n";
	$headers.="Reply-To: $from\r\n";
	$headers.="Return-Path: $from\r\n";
	$headers .= "CC: $ccmail_id \r\n";
	//$headers .= "BCC: $bccemail \r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$abc = mail($mail_Id,$sub,$body,$headers);
	if($abc)success_mail_log($alias,"MO");
	else pending_mail_log($alias,"MO");
	*/

	$logName = $ticket_alias . "_" . $state_alais;
	$to = implode(",", $defaultMails);
	ecSendMails($mailType, $state_alias, $sub . $state_alais, $body, $to, $logName, 'MO');
}
function materialRevivalMails(){
	global $mr_con;
	global $newAddress;
	//$_REQUEST['a']="XZCC2GA5WM";
	$revival_alias=$_REQUEST['a'];
	$rvQuery=mysqli_query($mr_con,"SELECT count(t2.id) as contx ,t3.product_description, t1.revival_no, t1.wh_alias, t1.createdDate, t1.eng_name FROM ec_material_revival t1 INNER JOIN ec_total_cell t2 ON t1.cell_sr_no=t2.cell_alias INNER JOIN ec_product t3 ON t2.item_code=t3.product_alias WHERE t1.item_alias='$revival_alias' AND t1.flag=0 GROUP BY t2.item_code");
	if(mysqli_num_rows($rvQuery)>'0'){
		$products=array();$pQuantity=array();$wh=array();
		while($rvRow=mysqli_fetch_array($rvQuery)){
			$revival_num=$rvRow['revival_no'];
			$revivalwh=$rvRow['wh_alias'];
			$wh[]=$revivalwh;
			$revival_date=dateFormat($rvRow['createdDate'],'d');
			$products[]=$rvRow['product_description'];
			$pQuantity[]=$rvRow['contx'];
			$eng_name=$rvRow['eng_name'];
		}
		
		//To and Cc mail IDS'
		$conn=sub_query("NAA",$wh);
		$mailIds=array('fieldasset@enersys.co.in');
		$ccmails=array('fieldasset@enersys.co.in');
		$nhs_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='WIMYJFDJPT' AND flag=0 AND status='WORKING'");
		$zhs_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='OX5E3EMI0U' AND $conn flag=0 AND status='WORKING'");
		$sereng_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='3WDRECJ0MA' AND $conn flag=0 AND status='WORKING'");
		while($nhs_row=mysqli_fetch_array($nhs_query)){$mailIds[]=$nhs_row['email_id'];}
		while($zhs_row=mysqli_fetch_array($zhs_query)){$ccmails[]=$zhs_row['email_id'];}
		while($sereng_row=mysqli_fetch_array($sereng_query)){$ccmails[]=$sereng_row['email_id'];}
		if(count($mailIds)>'0'){$mail_Id=implode(", ",array_filter(array_unique($mailIds)));}else $mail_Id="fieldasset@enersys.co.in";
		if(count($ccmails)>'0'){$ccmail_id=implode(", ",array_filter(array_unique($ccmails)));}else $ccmail_id="fieldasset@enersys.co.in";

		$sub = "New Revival Activity ".date("d-m-Y");
		$body="<p>Dear Team,</p>";
		$body.="<p>Below are the Revival Activity Details</p>";
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
									$body.="<td align='right' style='font-size:13px;'><b>Date : </b>".$revival_date."</td>";
								$body.="</tr>";
							$body.="</table>";
							$body.="<table width='98%' cellpadding='5'>";
								$body.="<tr>";
									$body.="<td align='right'><b>Reference ID</b> : ".$revival_num."</td>";
								$body.="</tr>";
							$body.="</table>";
							$body.="<table width='100%' cellpadding='2'>";
								$body.="<tr>";
									$body.="<td align='center'><u><h5 style='margin:2px;'>ACKNOWLEDGEMENT FOR REVIVAL ACTIVITY</h5></u></td>";
								$body.="</tr>";
							$body.="</table><br>";
							$body.="<table border='1' width='96%' style='border-collapse:collapse; border:1px solid #ddd' cellpadding='8'>";
								$body.="<tr>";
									$body.="<td><b>Material Revived at   : </b> ".alias($revivalwh,'ec_warehouse','wh_alias','wh_code')."</td>";
									$body.="<td><b>Engineer Name   : </b> ".$eng_name."</td>";
								$body.="</tr>"; 
							$body.="</table><br><br>";
							$body.="<table width='100%' cellpadding='2'>";
								$body.="<tr>";
									$body.="<td align='center'><u><h5 style='margin:2px;'>REVIVED ITEMS</h5></u></td>";
								$body.="</tr>";
							$body.="</table><br>";
							$body.="<table border='1' width='96%' style='border-collapse:collapse; border:1px solid #ddd' cellpadding='5'>";
								$body.="<tr align='left'><th>SL No.</th><th>Type</th><th>Item</th><th>Quantity</th></tr>";
								for($r=0;$r<count($products);$r++){
								$body.="<tr>";
									$body.="<td>".($r+1)."</td>";
									$body.="<td>Cell</td>";
									$body.="<td>".$products[$r]."</td>";
									$body.="<td>".$pQuantity[$r]."</td>";
								$body.="</tr>";
								}	
							$body.="</table><br><br><br>";
							$body.="<table width='98%' cellpadding='5'>";
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
										$body.="<td align='center'>";
										$body.=$newAddress;
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
		$from=all_from_mail();
		$headers="From: EnerSys Inventory<$from>\r\n";
		$headers.="Reply-To: $from\r\n";
		$headers.="Return-Path: $from\r\n";
		$headers .= "CC: $ccmail_id \r\n";
		//$headers .= "BCC: $bccemail \r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$abc = mail($mail_Id,$sub,$body,$headers);
		if($abc)success_mail_log($revival_alias,"RV");
		else pending_mail_log($revival_alias,"RV");
	}
}

function materialRefreshMails(){
	global $mr_con;
	global $newAddress;
	//$_REQUEST['a']="XZCC2GA5WM";
	$revival_alias=$_REQUEST['a'];
	$rvQuery=mysqli_query($mr_con,"SELECT count(t2.id) as contx ,t3.product_description, t1.refreshing_no, t1.wh_alias, t1.createdDate, t1.eng_name FROM ec_material_refreshing t1 INNER JOIN ec_total_cell t2 ON t1.cell_sr_no=t2.cell_alias INNER JOIN ec_product t3 ON t2.item_code=t3.product_alias WHERE t1.item_alias='$revival_alias' AND t1.flag=0 GROUP BY t2.item_code");
	if(mysqli_num_rows($rvQuery)>'0'){
		$products=array();$pQuantity=array();$wh=array();
		while($rvRow=mysqli_fetch_array($rvQuery)){
			$revival_num=$rvRow['refreshing_no'];
			$revivalwh=$rvRow['wh_alias'];
			$wh[]=$revivalwh;
			$revival_date=dateFormat($rvRow['createdDate'],'d');
			$products[]=$rvRow['product_description'];
			$pQuantity[]=$rvRow['contx'];
			$eng_name=$rvRow['eng_name'];
		}
		$conn=sub_query("NAA",$wh);
		$mailIds=array('fieldasset@enersys.co.in');
		$ccmails=array('fieldasset@enersys.co.in');
		$nhs_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='WIMYJFDJPT' AND flag=0 AND status='WORKING'");
		$zhs_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='OX5E3EMI0U' AND $conn flag=0 AND status='WORKING'");
		$sereng_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='3WDRECJ0MA' AND $conn flag=0 AND status='WORKING'");
		while($nhs_row=mysqli_fetch_array($nhs_query)){$mailIds[]=$nhs_row['email_id'];}
		while($zhs_row=mysqli_fetch_array($zhs_query)){$ccmails[]=$zhs_row['email_id'];}
		while($sereng_row=mysqli_fetch_array($sereng_query)){$ccmails[]=$sereng_row['email_id'];}
		if(count($mailIds)>'0'){$mail_Id=implode(", ",array_filter(array_unique($mailIds)));}else $mail_Id="fieldasset@enersys.co.in";
		if(count($ccmails)>'0'){$ccmail_id=implode(", ",array_filter(array_unique($ccmails)));}else $ccmail_id="fieldasset@enersys.co.in";
		
		$sub = "New Refreshing Charge Activity ".date("d-m-Y");
		$body="<p>Dear Team,</p>";
		$body.="<p>Below are the Refreshing Charge Details</p>";
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
									$body.="<td align='right' style='font-size:13px;'><b>Date : </b>".$revival_date."</td>";
								$body.="</tr>";
							$body.="</table>";
							$body.="<table width='98%' cellpadding='5'>";
								$body.="<tr>";
									$body.="<td align='right'><b>Reference ID</b> : ".$revival_num."</td>";
								$body.="</tr>";
							$body.="</table>";
							$body.="<table width='100%' cellpadding='2'>";
								$body.="<tr>";
									$body.="<td align='center'><u><h5 style='margin:2px;'>ACKNOWLEDGEMENT FOR REFRESHING CHARGE</h5></u></td>";
								$body.="</tr>";
							$body.="</table><br>";
							$body.="<table border='1' width='96%' style='border-collapse:collapse; border:1px solid #ddd' cellpadding='8'>";
								$body.="<tr>";
									$body.="<td><b>Material Refreshed at   : </b> ".alias($revivalwh,'ec_warehouse','wh_alias','wh_code')."</td>";
									$body.="<td><b>Engineer Name   : </b> ".$eng_name."</td>";
								$body.="</tr>"; 
							$body.="</table><br><br>";
							$body.="<table width='100%' cellpadding='2'>";
								$body.="<tr>";
									$body.="<td align='center'><u><h5 style='margin:2px;'>REFRESHED ITEMS</h5></u></td>";
								$body.="</tr>";
							$body.="</table><br>";
							$body.="<table border='1' width='96%' style='border-collapse:collapse; border:1px solid #ddd' cellpadding='5'>";
								$body.="<tr align='left'><th>SL No.</th><th>Type</th><th>Item</th><th>Quantity</th></tr>";
								for($r=0;$r<count($products);$r++){
								$body.="<tr>";
									$body.="<td>".($r+1)."</td>";
									$body.="<td>Cell</td>";
									$body.="<td>".$products[$r]."</td>";
									$body.="<td>".$pQuantity[$r]."</td>";
								$body.="</tr>";
								}	
							$body.="</table><br><br><br>";
							$body.="<table width='98%' cellpadding='5'>";
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
										$body.="<td align='center'>";
											$body.=$newAddress;
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
		$from=all_from_mail();
		$headers="From: EnerSys Inventory<$from>\r\n";
		$headers.="Reply-To: $from\r\n";
		$headers.="Return-Path: $from\r\n";
		$headers .= "CC: $ccmail_id \r\n";
		//$headers .= "BCC: $bccemail \r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$abc = mail($mail_Id,$sub,$body,$headers);
		if($abc)success_mail_log($revival_alias,"RF");
		else pending_mail_log($revival_alias,"RF");
	}
}
function materialDynamicMails(){ 
	global $mr_con;
	global $newAddress;
	$mrf_alias=$_REQUEST['a'];
	if(isset($_REQUEST['bucket']) && ($_REQUEST['bucket']=='20' || $_REQUEST['bucket']=='22'))materialsubDynamicMails($mrf_alias,'a',$_REQUEST['bucket']);
	else{
		$emp_ali = next_dynamic($mrf_alias,'E');
		if(!empty($mrf_alias) && !empty($emp_ali)){
			$randm=generateRandomString()."_@".$mrf_alias."_@";
			if(strpos($emp_ali,",")!==false){
				foreach(explode(",",$emp_ali) as $emp_alias)materialsubDynamicMails($mrf_alias,$emp_alias,base64_encode($randm.$emp_alias));
			}else materialsubDynamicMails($mrf_alias,$emp_ali,base64_encode($randm.$emp_ali));
		}else{
			if(!empty($mrf_alias) && empty($emp_ali)){
				$sql = mysqli_query($mr_con,"SELECT id FROM pending_mail_log WHERE bucket='MRD' AND item_alias='$mrf_alias' AND status='0' AND flag=0");
				if(mysqli_num_rows($sql))success_mail_log($mrf_alias,"MRD");
				else{
					curlxing(baseurl()."services/inventory/mails/mrmails?a=".$mrf_alias);
					$amount_range = alias($mrf_alias,'ec_material_request','mrf_alias','amount_range');
					if($amount_range=='2') {
						curlxing(baseurl()."services/inventory/mails/mrtmails?a=".$mrf_alias);
					}
				}
			}
		}
	}
}
function materialsubDynamicMails($mrf_alias,$emp_alias,$r){ 
	global $mr_con;
	global $newAddress;
	if(!empty($mrf_alias) && !empty($emp_alias)){
		$sql = mysqli_query($mr_con,"SELECT mrf_number,sjo_file,sjo_number,sjo_date,sales_invoice_no,sales_invoice_date,sales_po_no,contact_person,customer_address,customer_phone, from_wh, to_wh, date_of_request, material_value,ticket_alias, status FROM ec_material_request WHERE mrf_alias ='$mrf_alias' AND flag=0");
		if(mysqli_num_rows($sql)){ 
			$row=mysqli_fetch_array($sql); 
			$check=TRUE;
			$privilege_aliass = next_dynamic($mrf_alias,'P');
			$mailLevel = alias($privilege_aliass,'ec_dynamic_levels','privilege_alias','sjo_number');
			if($emp_alias=='a' && ($r=='20' || $r=='22')){
				$mailType = "mr_md_rejected";
				if($r=='22'){ //Reject
					$sql_rej = mysqli_query($mr_con,"SELECT email_id,name FROM ec_employee_master WHERE privilege_alias='5KPS8Q0ZNB' AND flag='0'"); //HO
					if(mysqli_num_rows($sql_rej)){
						$row_rej = mysqli_fetch_array($sql_rej);
						$email_id=$row_rej['email_id'];
						$emp_name=$row_rej['name'];
						$ccmail_id="fieldasset@enersys.co.in,service@enersys.co.in,".mail_relieved_filter("nathani.rajasekhar@enersys.co.in");
					}else $check=FALSE;
				}else{  // $r=='20' Hold
					$email_id="service@enersys.co.in";//$row_rej['email_id'];
					$emp_name="SRIPADHA MANI RAJ";//$row_rej['name'];
					$ccmail_id="fieldasset@enersys.co.in,service@enersys.co.in,".mail_relieved_filter("nathani.rajasekhar@enersys.co.in");
				}
			}else{
				$mailType = "";
				$sql0=mysqli_query($mr_con,"SELECT verification_code FROM ec_dynamic_verification WHERE employee_alias='$emp_alias' AND mrf_alias='$mrf_alias' AND flag='0'");
				if(mysqli_num_rows($sql0)){ $row0=mysqli_fetch_array($sql0);
					$r=$row0['verification_code'];
					$sql1=TRUE;
				}else $sql1=mysqli_query($mr_con,"INSERT INTO ec_dynamic_verification(employee_alias,mrf_alias,verification_code)VALUES('$emp_alias','$mrf_alias','$r')");
				if($sql1){
					$email_id=alias($emp_alias,'ec_employee_master','employee_alias','email_id');
					$emp_name=alias($emp_alias,'ec_employee_master','employee_alias','name');
					$ccmail_id="fieldasset@enersys.co.in,service@enersys.co.in,".mail_relieved_filter("nathani.rajasekhar@enersys.co.in");
				}else $check=FALSE;
			}
			if(!empty($email_id) && $email_id!="NA" && $check){
				$body="<style>.simp{border-collapse:separate; border-spacing:10px;}
				.simp td{width:33%;padding: 5px 10px !important;border: 1px solid #428bca !important;border-left-width: 7px !important;border-radius: 3px;}
				.simp p{margin-bottom:10px !important;}
				.reqp{width:97.5%; border-spacing:10px;border: 1px solid #428bca !important;border-left-width: 7px !important;border-radius: 3px;}
				.reqp th{padding: 5px 10px !important;border: 1px solid #428bca !important;color:#428bca; font-size:13px;}
				.reqp td{padding: 5px 10px !important;border: 1px solid #428bca !important;}
				h4{color:#428bca; margin-top:10px !important; margin-bottom:10px !important; font-size:13px;}
				p{color:#262626 !important;font-size:11px;}
				.approve{text-decoration:none;display:block;border:1px #4aab4e solid;width:150px;height:35px;line-height:35px;color:#FFF;background-color:#357938;border-radius:3px}
				.approve:hover{text-decoration:none;display:block;border:1px #4aab4e solid;width:150px;height:35px;line-height:35px;color:#FFF;background-color:#4caf50;border-radius:3px}
				.reject{text-decoration:none;display:block;border:1px #2a3f6c solid;width:150px;height:35px;line-height:35px;color:#FFF;background-color:#b12404;border-radius:3px}
				.reject:hover{text-decoration:none;display:block;border:1px #2a3f6c solid;width:150px;height:35px;line-height:35px;color:#FFF;background-color:#cc2a05;border-radius:3px}
				.hold{text-decoration:none;display:block;border:1px #b12404 solid;width:150px;height:35px;line-height:35px;color:#FFF;background-color:#1e2c4a;border-radius:3px}
				.hold:hover{text-decoration:none;display:block;border:1px #b12404 solid;width:150px;height:35px;line-height:35px;color:#FFF;background-color:#2d4373;border-radius:3px}</style>";
				$sub=($r=='22' ? "Material Request Rejected Against SJO - " : ($r=='20' ? "Material Request Hold Against SJO - " : "Material Approval Required for SJO - ")).$row['sjo_number'];
				$body.= "<html><body style='font-family:Calibri;'>";
				$body.="<table width='800px' style='border-collapse:collapse;' cellpadding='3' align='center'>";
					$body.="<tr align='center'>";
						$body.="<th align='center' style='border:1px solid #ddd; border-bottom:1px solid #fff;'>";
							$body.="<table width='100%' style='border-bottom:1px solid #000'>";
								$body.="<tr>";
									$body.="<th align='left'>
											<img src='".baseurl()."images/gallery/EnerSyslogo.png' alt='EnerSys_logo' height='80' width='150'>
											</th>";
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
									$body.="<td align='center'><u><h3 style='margin:2px;'>".($r=='22' ? "Request Rejected" : ($r=='20' ? "Request Hold" : "Approval Required"))."</h3></u></td>";
								$body.="</tr>";
							$body.="</table>";
							$body.="<table width='100%' cellpadding='5'>";
								$body.="<tr>";
									$body.="<td colspan='4' align='left'>Dear $emp_name,";
									$body .= "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please find the below".($r=='22' ? " Rejected " : ($r=='20' ? " Hold " : " "))."SJO details".($r=='21' ? ", can I have your approval":"").".</td>";
								$body.="</tr>";
								$body.="<tr>";
									$body.="<td colspan='4' align='left'>";
										$body.="<table width='100%' class='simp'>";
										$body.="<tr>";
											$body.="<td>";
												$body.="<h4>MRF NUMBER</h4>";
												$body.="<p>".checkempty(strtoupper($row['mrf_number']))."</p>";
											$body.="</td>";
											$body.="<td>";
												$body.="<h4>DATE OF REQUEST</h4>";
												$body.="<p>".dateFormat($row['date_of_request'],'d')."</p>";
											$body.="</td>";
											$body.="<td>";
												$body.="<h4>FROM W/H</h4>";
												$body.="<p>".checkempty(strtoupper(alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code')))."</p>";
											$body.="</td>";
										$body.="</tr>";
										$body.="<tr>";
											$body.="<td>";
												$body.="<h4>TO W/H</h4>";
												$body.="<p>".checkempty($row['to_wh']=='2' ? 'Factory' : alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code'))."</p>";
											$body.="</td>";
											$body.="<td>";
												$body.="<h4>MATERIAL VALUE</h4>";
												$body.="<p>".checkempty(strtoupper($row['material_value']))."</p>";
											$body.="</td>";
											$body.="<td>";
												$body.="<h4>REQUEST STATUS</h4>";
												$body.="<p>".checkempty(fam_lvl_nm_clr($row['status'],"name",$mrf_alias))."</p>";
											$body.="</td>";
										$body.="</tr>";
										$body.="<tr>";
											$body.="<td>";
												$body.="<h4>TICKET ID</h4>";
												$body.="<p>".checkempty($row['ticket_alias']!='2609' ? j_getticketID($row['ticket_alias']) : "CUSTOMER BUFFER STOCK")."</p>";
											$body.="</td>";
											$body.="<td>";
												$body.="<h4>SJO NUMBER</h4>";
												$body.="<p>".checkempty(strtoupper($row['sjo_number']))."</p>";
											$body.="</td>";
											$body.="<td>";
												$body.="<h4>SJO DATE</h4>";
												$body.="<p>".checkempty(strtoupper(dateFormat($row['sjo_date'],'d')))."</p>";
											$body.="</td>";
										$body.="</tr>";
										$body.="<tr>";
											$body.="<td>";
												$body.="<h4>ROAD PERMIT</h4>";
												$body.="<p>".get_road_permit(alias($row['from_wh'],'ec_warehouse','wh_alias','road_permit'))."</p>";
											$body.="</td>";
											$body.="<td>";
												$body.="<h4>SALES INVOICE NUMBER</h4>";
												$body.="<p>".strtoupper($row['sales_invoice_no'])."</p>";
											$body.="</td>";
											$body.="<td>";
												$body.="<h4>SALES INVOICE DATE</h4>";
												$body.="<p>".dateFormat($row['sales_invoice_date'],'d')."</p>";
											$body.="</td>";
										$body.="</tr>";
										$body.="<tr>";
											$body.="<td>";
												$body.="<h4>SALES PO NUMBER</h4>";
												$body.="<p>".strtoupper($row['sales_po_no'])."</p>";
											$body.="</td>";
											$body.="<td>";
												$body.="<h4>CUSTOMER NAME</h4>";
												$body.="<p>".strtoupper($row['contact_person'])."</p>";
											$body.="</td>";
											$body.="<td>";
												$body.="<h4>CUSTOMER NUMBER</h4>";
												$body.="<p>".strtoupper($row['customer_phone'])."</p>";
											$body.="</td>";
										$body.="</tr>";
										$body.="<tr>";
											$body.="<td>";
												$body.="<h4>CUSTOMER ADDRESS</h4>";
												$body.="<p>".strtoupper($row['customer_address'])."</p>";
											$body.="</td>";
											$body.="<td>";
												$remsql=mysqli_query($mr_con,"SELECT remarks,bucket,remarked_by FROM ec_remarks WHERE id IN (SELECT MAX(id) FROM ec_remarks WHERE module='MR' AND item_alias='$mrf_alias' AND flag='0') AND flag='0'");
												$remrow=mysqli_fetch_array($remsql);
												$bucket = $remrow['bucket'];
												if($bucket=='16')$hed = "REQUESTED";
												elseif($bucket=='17')$hed = "RE REQUESTED";
												elseif($bucket=='20' || $bucket=='21' || $bucket=='22')$hed = alias_flag_none(alias_flag_none($remrow['remarked_by'],'ec_employee_master','employee_alias','privilege_alias'),'ec_dynamic_levels','privilege_alias','level_name');
												else $hed = "";
												$body.="<h4>".$hed." Remarks</h4>";
												$body.="<p>".(!empty($remrow['remarks']) ? $remrow['remarks'] : "NA")."</p>";
											$body.="</td>";
											$body.="<td>";
												$body.="<h4>SJO File</h4>";
												$body.="<p>".(!empty($row['sjo_file']) ? "For details please go through the SJO Enclosed <a href='".baseurl().$row['sjo_file']."' target='_blank'>CLICK HERE</a>" : "NA")."</p>";
											$body.="</td>";	
										$body.="</tr>";
									$body.="</table>";
								$body.="</td>";
								$body.="</tr>";
								$body.="<tr><td colspan='4'><u><b>REQUESTED ITEMS</b></u>:<br><br>";
								$sql1 = mysqli_query($mr_con,"SELECT * FROM ec_request_items WHERE mrf_alias ='$mrf_alias' AND flag='0'");
								if(mysqli_num_rows($sql1)){
									$body.='<table class="reqp" align="center" cellpadding="5">
									<tr align="left"><th>SR.NO</th><th>ITEM TYPE</th><th>ITEM DESCRIPTION</th><th>CELL TYPE</th><th>REQ QTY</th></tr>';
									$i=0;while($row1=mysqli_fetch_array($sql1)){
										$body.='<tr><td>'.($i+1).'</td>';
										if($row1['item_type']=='1'){$item_type="CELLS";$item_code=alias($row1['item_code'],'ec_product','product_alias','product_description');}
										else{$item_type="ACCESSORIES";$item_code=alias($row1['item_code'],'ec_accessories','accessories_alias','accessory_description');}
										$body.='<td>'.checkempty($item_type).'</td>';
										$body.='<td>'.checkempty(getitemname($item_type,$row1['item_description'])).'</td>
										<td>'.get_cell_type($row1['cell_type']).'</td>
										<td>'.$row1['quantity'].'</td>';
									$i++;}
								$body.='</table>';
								}
								$body.="</td></tr>";
							if($r!='22' && $r!='20' && !empty($r)){
								$body.="<tr>";
									$body.="<td height='100px' align='center'><a class='approve' href='".baseurl()."includes/dynamic_remark.php?verify=".base64_encode($r."@@1")."' target='_blank'>APPROVE</a></td>";
									$body.="<td height='100px' align='center'><a class='reject' href='".baseurl()."includes/dynamic_remark.php?verify=".base64_encode($r."@@2")."' target='_blank'>REJECT</a></td>";
									$body.="<td height='100px' align='center'><a class='hold' href='".baseurl()."includes/dynamic_remark.php?verify=".base64_encode($r."@@3")."' target='_blank'>HOLD</a></td>";
								$body.="</tr>";
								// $body .="<tr><td colspan='2' style='font-style:italic;'>Note: Just a heads up, due to security reasons the Link will expire after 24 hours, If it's expired you still can perform the action by logging in to the web application.</td></tr>";
							}
							$body.="</table>";
							$body.="<table width='100%' cellpadding='5'>";
								$body.="<tr>";
									$body.="<td align='left'>Thanks and Regards.</td>";
								$body.="</tr>";
								$body.="<tr>";
									$body.="<td align='left'>EnerSys Care.</td>";
								$body.="</tr>";
							$body.="</table>";
							$body.="<table width='100%' cellpadding='1' style='border-top:1px solid #000'>";
								$body.="<tfoot>";
									$body.="<tr>";
										$body.="<td align='center' style='padding:8px;'>";
										$body.=$newAddress;
										$body.="</td>";
									$body.="</tr>";
								$body.="</tfoot>";
							$body.="</table>";
						$body.="</td>";
					$body.="</tr>";
				$body.="</table>";
				$body.="<p style='font-style:italic;text-align:center;'><small>*** This is system generated document no signature required ***</small></p>";
				$body.="</body></html>";
				if($mailType = "") {
				$from = all_from_mail();
				$headers="From: EnerSys Inventory<$from>\r\n";
				$headers.="Reply-To: $from\r\n";
				$headers.="Return-Path: $from\r\n";
				//$headers.= "CC: $ccmail_id \r\n";
				//$headers.= "BCC: $bccemail \r\n";
				$headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$headers.= "MIME-Version: 1.0\r\n";
				$mail=mail($email_id, $sub, $body, $headers);
				if($mail)success_mail_log($mrf_alias,"MRD");
				else pending_mail_log($mrf_alias,"MRD");
				} else {
					$state_alais = alias($from_wh_alias,'ec_warehouse','wh_alias','state_alias');
					$logName = $ticket_alias . "_" . $state_alais;
					ecSendMails($mailType, $state_alias, $sub, $body, $email_id, $logName, "MRD");
				}
			}else $result='The mail is not available in our database. please check!';
		}else $result="";
	}else $result="";
}
function materialShortClosedMails(){ 
	global $mr_con;
	global $newAddress;
	$mrf_alias=mysqli_real_escape_string($mr_con,$_REQUEST['a']);
	if(!empty($mrf_alias)){
		$sql = mysqli_query($mr_con,"SELECT mrf_number,sjo_file,sjo_number,sjo_date,sales_invoice_no,sales_invoice_date,sales_po_no,contact_person,customer_address,customer_phone, from_wh, to_wh, date_of_request, material_value,ticket_alias, status FROM ec_material_request WHERE mrf_alias ='$mrf_alias' AND flag=0");
		if(mysqli_num_rows($sql)){ $row=mysqli_fetch_array($sql);
			$body="<style>.simp{border-collapse:separate; border-spacing:10px;}
			.simp td{width:33%;padding: 5px 10px !important;border: 1px solid #428bca !important;border-left-width: 7px !important;border-radius: 3px;}
			.simp p{margin-bottom:10px !important;}
			.reqp{width:97.5%; border-spacing:10px;border: 1px solid #428bca !important;border-left-width: 7px !important;border-radius: 3px;}
			.reqp th{padding: 5px 10px !important;border: 1px solid #428bca !important;color:#428bca; font-size:13px;}
			.reqp td{padding: 5px 10px !important;border: 1px solid #428bca !important;}
			h4{color:#428bca; margin-top:10px !important; margin-bottom:10px !important; font-size:13px;}
			p{color:#262626 !important;font-size:11px;}</style>";
			$sub="Material Short Closed Against SJO - ".$row['sjo_number'];
			$body.= "<html><body style='font-family:Calibri;'>";
			$body.="<table width='800px' style='border-collapse:collapse;' cellpadding='3' align='center'>";
				$body.="<tr align='center'>";
					$body.="<th align='center' style='border:1px solid #ddd; border-bottom:1px solid #fff;'>";
						$body.="<table width='100%' style='border-bottom:1px solid #000'>";
							$body.="<tr>";
								$body.="<th align='left'>
										<img src='".baseurl()."images/gallery/EnerSyslogo.png' alt='EnerSys_logo' height='80' width='150'>
										</th>";
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
								$body.="<td align='center'><u><h3 style='margin:2px;'>Request Short Closed</h3></u></td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table width='100%' cellpadding='5'>";
							$body.="<tr>";
								$body.="<td colspan='4' align='left'>Dear Team<br><br><div style='text-aliagn:center'>Please find the below SJO details.</div></td>";
							$body.="</tr>";
							$body.="<tr>";
								$body.="<td colspan='4' align='left'>";
									$body.="<table width='100%' class='simp'>";
									$body.="<tr>";
										$body.="<td>";
											$body.="<h4>MRF NUMBER</h4>";
											$body.="<p>".checkempty(strtoupper($row['mrf_number']))."</p>";
										$body.="</td>";
										$body.="<td>";
											$body.="<h4>DATE OF REQUEST</h4>";
											$body.="<p>".dateFormat($row['date_of_request'],'d')."</p>";
										$body.="</td>";
										$body.="<td>";
											$body.="<h4>FROM W/H</h4>";
											$body.="<p>".checkempty(strtoupper(alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code')))."</p>";
										$body.="</td>";
									$body.="</tr>";
									$body.="<tr>";
										$body.="<td>";
											$body.="<h4>TO W/H</h4>";
											$body.="<p>".checkempty($row['to_wh']=='2' ? 'Factory' : alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code'))."</p>";
										$body.="</td>";
										$body.="<td>";
											$body.="<h4>MATERIAL VALUE</h4>";
											$body.="<p>".checkempty(strtoupper($row['material_value']))."</p>";
										$body.="</td>";
										$body.="<td>";
											$body.="<h4>REQUEST STATUS</h4>";
											$body.="<p>".checkempty(fam_lvl_nm_clr($row['status'],"name",$mrf_alias))."</p>";
										$body.="</td>";
									$body.="</tr>";
									$body.="<tr>";
										$body.="<td>";
											$body.="<h4>TICKET ID</h4>";
											$body.="<p>".checkempty($row['ticket_alias']!='2609' ? j_getticketID($row['ticket_alias']) : "CUSTOMER BUFFER STOCK")."</p>";
										$body.="</td>";
										$body.="<td>";
											$body.="<h4>SJO NUMBER</h4>";
											$body.="<p>".checkempty(strtoupper($row['sjo_number']))."</p>";
										$body.="</td>";
										$body.="<td>";
											$body.="<h4>SJO DATE</h4>";
											$body.="<p>".checkempty(strtoupper(dateFormat($row['sjo_date'],'d')))."</p>";
										$body.="</td>";
									$body.="</tr>";
									$body.="<tr>";
										$body.="<td>";
											$body.="<h4>ROAD PERMIT</h4>";
											$body.="<p>".get_road_permit(alias($row['from_wh'],'ec_warehouse','wh_alias','road_permit'))."</p>";
										$body.="</td>";
										$body.="<td>";
											$body.="<h4>SALES INVOICE NUMBER</h4>";
											$body.="<p>".strtoupper($row['sales_invoice_no'])."</p>";
										$body.="</td>";
										$body.="<td>";
											$body.="<h4>SALES INVOICE DATE</h4>";
											$body.="<p>".dateFormat($row['sales_invoice_date'],'d')."</p>";
										$body.="</td>";
									$body.="</tr>";
									$body.="<tr>";
										$body.="<td>";
											$body.="<h4>SALES PO NUMBER</h4>";
											$body.="<p>".strtoupper($row['sales_po_no'])."</p>";
										$body.="</td>";
										$body.="<td>";
											$body.="<h4>CUSTOMER NAME</h4>";
											$body.="<p>".strtoupper($row['contact_person'])."</p>";
										$body.="</td>";
										$body.="<td>";
											$body.="<h4>CUSTOMER NUMBER</h4>";
											$body.="<p>".strtoupper($row['customer_phone'])."</p>";
										$body.="</td>";
									$body.="</tr>";
									$body.="<tr>";
										$body.="<td>";
											$body.="<h4>CUSTOMER ADDRESS</h4>";
											$body.="<p>".strtoupper($row['customer_address'])."</p>";
										$body.="</td>";
										$body.="<td>";
											$body.="<h4>SHORT CLOSED REMARKS</h4>";
											$remsql=mysqli_query($mr_con,"SELECT remarks FROM ec_remarks WHERE id IN (SELECT MAX(id) FROM ec_remarks WHERE module='MR' AND bucket='19' AND item_alias='$mrf_alias' AND flag='0') AND flag='0'");
											$remrow=mysqli_fetch_array($remsql);
											$body.="<p>".(!empty($remrow['remarks']) ? $remrow['remarks'] : "NA")."</p>";
										$body.="</td>";	
										$body.="<td>";
											$body.="<h4>SJO File</h4>";
											$body.="<p>".(!empty($row['sjo_file']) ? "For details please go through the SJO Enclosed <a href='".baseurl().$row['sjo_file']."' target='_blank'>CLICK HERE</a>" : "NA")."</p>";
										$body.="</td>";	
									$body.="</tr>";
								$body.="</table>";
							$body.="</td>";
							$body.="</tr>";
							$body.="<tr><td colspan='4'><u><b>REQUESTED ITEMS</b></u>:<br><br>";
							$sql1 = mysqli_query($mr_con,"SELECT * FROM ec_request_items WHERE mrf_alias ='$mrf_alias' AND flag='0'");
							if(mysqli_num_rows($sql1)){
								$body.='<table class="reqp" align="center" cellpadding="5">
								<tr align="left"><th>SR.NO</th><th>ITEM TYPE</th><th>ITEM DESCRIPTION</th><th>CELL TYPE</th><th>REQ QTY</th></tr>';
								$i=0;while($row1=mysqli_fetch_array($sql1)){
									$body.='<tr><td>'.($i+1).'</td>';
									if($row1['item_type']=='1'){$item_type="CELLS";$item_code=alias($row1['item_code'],'ec_product','product_alias','product_description');}
									else{$item_type="ACCESSORIES";$item_code=alias($row1['item_code'],'ec_accessories','accessories_alias','accessory_description');}
									$body.='<td>'.checkempty($item_type).'</td>';
									$body.='<td>'.checkempty(getitemname($item_type,$row1['item_description'])).'</td>
									<td>'.get_cell_type($row1['cell_type']).'</td>
									<td>'.$row1['quantity'].'</td>';
								$i++;}
							$body.='</table>';
							}
							$body.="</td></tr>";
						$body.="</table>";
						$body.="<table width='100%' cellpadding='5'>";
							$body.="<tr>";
								$body.="<td align='left'>Thanks and Regards.</td>";
							$body.="</tr>";
							$body.="<tr>";
								$body.="<td align='left'>EnerSys Care.</td>";
							$body.="</tr>";
						$body.="</table>";
						$body.="<table width='100%' cellpadding='1' style='border-top:1px solid #000'>";
							$body.="<tfoot>";
								$body.="<tr>";
									$body.="<td align='center' style='padding:8px;'>";
									$body.=$newAddress;
									$body.="</td>";
								$body.="</tr>";
							$body.="</tfoot>";
						$body.="</table>";
					$body.="</td>";
				$body.="</tr>";
			$body.="</table>";
			$body.="<p style='font-style:italic;text-align:center;'><small>*** This is system generated document no signature required ***</small></p>";
			$body.="</body></html>";
			//To and Cc mail IDS'
			$mr_to=array();$mr_cc=array();$nhs_m=array();$zhs_m=array();$se_m=array();$ho_m=array();
			$conn=sub_query($row['from_wh'],$row['to_wh']);
			$nhs_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='WIMYJFDJPT' AND flag=0 AND status='WORKING'");//nhs
			$zhs_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='OX5E3EMI0U' AND $conn flag=0 AND status='WORKING'");//zhs
			$hoco_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='5KPS8Q0ZNB' AND flag=0 AND status='WORKING'");//onrole se
			//$sereng_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='3WDRECJ0MA' AND $conn flag=0 AND status='WORKING'");//onrole se
			while($nhs_row=mysqli_fetch_array($nhs_query)){$nhs_m[]=$nhs_row['email_id'];}
			while($zhs_row=mysqli_fetch_array($zhs_query)){$zhs_m[]=$zhs_row['email_id'];}
			while($hoco_row=mysqli_fetch_array($hoco_query)){$ho_m[]=$hoco_row['email_id'];}
			//while($sereng_row=mysqli_fetch_array($sereng_query)){$se_m[]=$sereng_row['email_id'];}
			if(alias($row['to_wh'],'ec_warehouse','wh_alias','wh_type')=='1'){
				$mr_to=explode(",",mail_relieved_filter("neeraj@enersys.co.in,somesh@enersys.co.in,chandra@enersys.co.in,Ravikanthp@enersys.co.in,sudhakararaju@enersys.co.in"));
				$mr_cc=explode(",",mail_relieved_filter("anandak@enersys.co.in,sivakumar.p@enersys.co.in,madan@enersys.co.in,rambhupal@enersys.co.in,pradeep@enersys.co.in,saivaranasi@enersys.co.in"));
				$ccmails=array_merge($mr_cc,$nhs_m,$zhs_m,$ho_m);
			}else{
				$mr_to=array_merge($zhs_m,$ho_m);
				$mr_cc=explode(",",mail_relieved_filter("pradeep@enersys.co.in,saivaranasi@enersys.co.in"));
				$ccmails=array_merge($mr_cc,$nhs_m);
			}
			array_push($ccmails,'fieldasset@enersys.co.in');
			if(count($mr_to)>'0'){$mail_Id=implode(", ",array_filter(array_unique($mr_to)));}else $mail_Id="fieldasset@enersys.co.in";
			if(count($ccmails)>'0'){
				$ccmails = array_diff($ccmails, $mr_to);
				$ccmail_id=implode(", ",array_filter(array_unique($ccmails)));
			}else $ccmail_id="fieldasset@enersys.co.in";
			
			$from=all_from_mail();
			$headers="From: EnerSys Inventory<$from>\r\n";
			$headers.="Reply-To: $from\r\n";
			$headers.="Return-Path: $from\r\n";
			$headers.= "CC: $ccmail_id \r\n";
			//$headers.= "BCC: $bccemail \r\n";
			$headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$headers.= "MIME-Version: 1.0\r\n";
			$mail=mail($mail_Id, $sub, $body, $headers);
			if($mail)success_mail_log($mrf_alias,"MRS");
			else pending_mail_log($mrf_alias,"MRS");
		}else $result="";
	}else $result="";
}