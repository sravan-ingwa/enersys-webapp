<?php
date_default_timezone_set("Asia/Kolkata");

include ('../../mysql.php');
include ('../../functions.php');

	$_REQUEST['a']="ZBOFQVGXG3";
	$alias=$_REQUEST['a'];
	$sql = mysqli_query($mr_con,"SELECT from_type, from_wh, to_wh, date_of_trans, totalamount, transport, docket, dispatch_date, ref_no, alias, trans_id FROM ec_material_outward WHERE alias ='$alias' AND flag=0");
	if(mysqli_num_rows($sql)){
		$row=mysqli_fetch_array($sql);
		$trans_id=$row['trans_id'];
		$from_type=$row['from_type'];
		if($row['from_type']=='1')$to_wh=alias($row['to_wh'],'ec_sitemaster','site_alias','site_name');else $to_wh=alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code');
		$from_wh=alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code');
		$date_of_request=dateFormat($row['date_of_trans'],'d');
		$transport_no=$row['transport'];
		$docket_no=$row['docket'];
		$dispatch_date=dateFormat($row['dispatch_date'],'d');
		$mrf_number=alias($row['ref_no'],'ec_material_request','mrf_alias','mrf_number');
		$sjo=alias($row['ref_no'],'ec_material_request','mrf_alias','sjo_number');
		$ticket_alias=$row['ref_no'];
		$ticket_id=alias($row['ref_no'],'ec_tickets','ticket_alias','ticket_id');
		$sql1 = mysqli_query($mr_con,"SELECT item_condition,item_type, item_code, count(id) as contx FROM ec_material_sent_details WHERE reference='$alias' AND flag=0 GROUP BY item_code");
		if(mysqli_num_rows($sql1)){$i=0;$lccount=0;
			while($row1=mysqli_fetch_array($sql1)){
				$item_type[$i]=$row1['item_type'];
				$item_description[$i]=getitemname($item_type[$i],$row1['item_code']);
				$quantity[$i]=$row1['contx'];
				if($row1['item_condition']=='4' || $row1['item_condition']=='7'){$lccount+=1;}
			$i++;}
		}
		$sql2 = mysqli_query($mr_con,"SELECT remarks FROM ec_remarks WHERE item_alias ='$alias' AND module='MO' AND flag=0 LIMIT 1");
		if(mysqli_num_rows($sql2)){$row2=mysqli_fetch_array($sql2);$remarks=$row2['remarks'];}else{$remarks="NA";}
	}
	$sub="New Material Outward - ".$sjo." - ".$date_of_request;
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
	//To and Cc mail IDS'
	$mr_to=array();$mr_cc=array();$nhs_m==array();$zhs_m=array();$se_m=array();$ho_m=array();
	$conn="state_alias IN(SELECT state_alias FROM ec_warehouse WHERE (wh_alias='".$row['from_wh']."' OR wh_alias='".$row['to_wh']."') AND flag='0') AND";
	$nhs_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='WIMYJFDJPT' AND flag=0");//nhs
	$zhs_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='OX5E3EMI0U' AND $conn flag=0");//zhs
	$hoco_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='5KPS8Q0ZNB' AND flag=0");//onrole se
	$sereng_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='3WDRECJ0MA' AND $conn flag=0");//onrole se
	while($nhs_row=mysqli_fetch_array($nhs_query)){$nhs_m[]=$nhs_row['email_id'];}
	while($zhs_row=mysqli_fetch_array($zhs_query)){$zhs_m[]=$zhs_row['email_id'];}
	while($hoco_row=mysqli_fetch_array($hoco_query)){$ho_m[]=$hoco_row['email_id'];}
	while($sereng_row=mysqli_fetch_array($sereng_query)){$se_m[]=$sereng_row['email_id'];}

	if(alias($row['to_wh'],'ec_warehouse','wh_alias','wh_type')=='1'){
		$mr_to=array('govindarajulu@enersys.co.in','chandra@enersys.co.in','Ravikanthp@enersys.co.in','rambhupal@enersys.co.in');
		$mr_cc=array('fieldasset@enersys.co.in','anandak@enersys.co.in','varaprasad@enersys.co.in','sivakumar.p@enersys.co.in','sudhakararaju@enersys.co.in','madan@enersys.co.in');
		$ccmails=array_merge($mr_cc,$nhs_m,$zhs_m,$ho_m,$se_m);
	}elseif(alias($row['from_wh'],'ec_warehouse','wh_alias','wh_type')=='1'){
		$mr_to=array('neeraj@enersys.co.in','varaprasad@enersys.co.in','chandra@enersys.co.in','Ravikanthp@enersys.co.in','sudhakararaju@enersys.co.in');
		$mr_cc=array('fieldasset@enersys.co.in','anandak@enersys.co.in','varaprasad@enersys.co.in','sivakumar.p@enersys.co.in','sudhakararaju@enersys.co.in','madan@enersys.co.in','chandra@enersys.co.in','Ravikanthp@enersys.co.in','neeraj@enersys.co.in');
		$ccmails=array_merge($mr_cc,$nhs_m);
		$mr_to=array_merge($mr_to,$zhs_m,$ho_m,$se_m);
	}else{
		$mr_to=array_merge($zhs_m,$se_m);
		$mr_cc=array('fieldasset@enersys.co.in');
		$ccmails=array_merge($mr_cc,$nhs_m,$ho_m);
	}
	if(count($mr_to)>'0'){$mail_Id=implode(", ",array_unique($mr_to));}else $mail_Id="fieldasset@enersys.co.in";
	if(count($ccmails)>'0'){$ccmail_id=implode(", ",array_unique($ccmails));}else $ccmail_id="fieldasset@enersys.co.in";
	$from = all_from_mail();
	$header= 'From: EnerSys Inventory<'.$from .'>' . "\r\n";
	$header.= 'Cc:'.$ccmail_id."\r\n";
	$header.= 'Reply-To: '.$from ."\r\n";
	$header.= "Content-Type: text/html\r\n";
	$header.= "X-Mailer: PHP/" . phpversion();
	$header.= 'MIME-Version: 1.0' . "\r\n";
	$admin = "-odb -f $from";
	echo "CCmail:".$ccmail_id."<br>To: ".$mail_Id;
