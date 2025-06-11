<style>
html,body{width:100%;}
.table1{border-collapse:collapse;width:90%;height:950px;}
.td1{
	border:7px double #000;height:100%;width:90%;height:950px;vertical-align:top; 
}
.table2{border-collapse:collapse;width:100%;height:100%;}
.td2{
	border:7px double #000;height:100%;width:100%;vertical-align:top; 
}
.tableHeader{
	border-bottom:1px solid #d1d1d1;
	margin-bottom:5px;
}
.cont_1{
	width:740px;
	border-bottom:2px solid #212121;
	padding:3px 5px;
	font-weight:700;
	font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;
	margin:6px 5px;
}
.cont_2{
	width:740px;
	padding:4px 5px;
	margin:0px 5px;
	font-weight:700;
	font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;
	font-size:11px;
	vertical-align:top;
}
.cont_3{
	width:740px;
	border-bottom:2px solid #212121;
	background:#2a6496;
	color:#FFF;
	padding:3px 5px;
	font-weight:700;
	font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;
	margin:5px 5px 0px 5px;
	font-size:12px;
}
.cont_2 h3{color:#428bca;}
.cont_2 p{font-size:10px; font-weight:300;}
.cont_3 h3{background-color:#428bca; color:#fff;}
.botable{border-collapse:collapse;font-size:12px;width:740px;}
.botable thead th{background:#2a6496; color:#FFF;padding:5px;}
.botable td, .botable th{border:1px solid #d1d1d1;padding:3px;}
.subhead td{padding:3px;text-align:center;}
</style>
<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
include('../mpdf60/mpdf.php');
$stylesheet = file_get_contents('../../styles/pdf_style.css');
$ticket_alias = $_REQUEST['alias'];
$heading = 'TICKET';
$query = mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE ticket_alias='$ticket_alias' AND flag='0'");
if(mysqli_num_rows($query)){
	$row = mysqli_fetch_array($query);
	$site_alias = $row['site_alias'];
	$level = $row['level'];
	$sqlSite = mysqli_query($mr_con,"SELECT * FROM ec_sitemaster WHERE site_alias='$site_alias' AND flag=0");
	if(mysqli_num_rows($sqlSite)){
		$rowSite = mysqli_fetch_array($sqlSite);
		$prod = explode(", ",$rowSite['product_alias']);
		foreach($prod as $pro){ $xx .= alias($pro,'ec_product','product_alias','product_description').", "; }
		$product=trim($xx,", ");
		$login_date=alias(strtok($row['ticket_id'],"|"),'ec_tickets','ticket_id','login_date');
	$print='<html><body>
	<table class="table1">
		<tr>
			<td class="td1">
				<table class="tableHeader" width="100%">
					<tr>
						<td align="left" width="35%"><img src="../../images/gallery/logo1.png"></td>
						<td align="center" width="50%"><h2>'.$heading.'<h2></ td>
						<td align="right" width="35%"><img src="../../images/gallery/logo-4.jpg" width="100px"></td>
					</tr>
				</table>
				<table class="cont_3">
					<tr>
						<td align="left">'.strtoupper($heading).'</td>
					</tr>
				</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Ticket ID</h3><p>'.checkempty(ucfirst($row['ticket_id'])).'</p></td>
							<td width="33.33%"><h3>Login Date</h3><p>'.(empty($login_date) ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$login_date)))).'</p></td>
							<td width="33.33%"><h3>Visit Generated Date</h3><p>'.(empty($row['login_date']) ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$row['login_date'])))).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Planned Date</h3><p>'.checkempty(dateFormat($row['planned_date'],'d')).'</p></td>
							<td width="33.33%"><h3>Service Engineer</h3><p>'.checkempty(alias($row['service_engineer_alias'],'ec_employee_master','employee_alias','name')).'</p></td>
							<td width="33.33%"><h3>Activation Date</h3><p>'.checkempty(dateFormat($row['activation_date'],'d')).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Activity</h3><p>'.checkempty(ucfirst(alias($row['activity_alias'],'ec_activity','activity_alias','activity_name'))).'</p></td>
							<td width="33.33%"><h3>Zone</h3><p>'.checkempty(ucfirst(alias($rowSite['zone_alias'],'ec_zone','zone_alias','zone_name'))).'</p></td>
							<td width="33.33%"><h3>State</h3><p>'.checkempty(ucfirst(alias($rowSite['state_alias'],'ec_state','state_alias','state_name'))).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>District</h3><p>'.checkempty(ucfirst(alias($rowSite['district_alias'],'ec_district','district_alias','district_name'))).'</p></td>
							<td width="33.33%"><h3>Segment</h3><p>'.checkempty(ucfirst(alias($rowSite['segment_alias'],'ec_segment','segment_alias','segment_name'))).'</p></td>
							<td width="33.33%"><h3>Customer</h3><p>'.checkempty(ucfirst(alias($rowSite['customer_alias'],'ec_customer','customer_alias','customer_name'))).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Site Type</h3><p>'.checkempty(ucfirst(alias($rowSite['site_type_alias'],'ec_site_type','site_type_alias','site_type'))).'</p></td>
							<td width="33.33%"><h3>Site ID</h3><p>'.checkempty(ucfirst($rowSite['site_id'])).'</p></td>
							<td width="33.33%"><h3>Site Name</h3><p>'.checkempty(ucfirst($rowSite['site_name'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Product</h3><p>'.checkempty(ucfirst($product)).'</p></td>
							<td width="33.33%"><h3>Battery Bank Rating</h3><p>'.checkempty(ucfirst($rowSite['battery_bank_rating'])).'</p></td>
							<td width="33.33%"><h3>Manufacturing Date</h3><p>'.checkempty(dateFormat($rowSite['mfd_date'],'d')).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Installation Date</h3><p>'.checkempty(dateFormat($rowSite['install_date'],'d')).'</p></td>
							<td width="33.33%"><h3>Sale Invoice Date</h3><p>'.checkempty(dateFormat($rowSite['sale_invoice_date'],'d')).'</p></td>
							<td width="33.33%"><h3>Sale Invoice Number</h3><p>'.checkempty(ucfirst($rowSite['sale_invoice_num'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Sale PO Number</h3><p>'.checkempty($rowSite['po_num']).'</p></td>
							<td width="33.33%"><h3>Service PO Number</h3><p>'.checkempty(ucfirst($row['po_number'])).'</p></td>
							<td width="33.33%"><h3>Service PO Date</h3><p>'.checkempty(dateFormat($row['po_date'],'d')).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>No Of Strings</h3><p>'.checkempty(ucfirst($rowSite['no_of_string'])).'</p></td>
							<td width="33.33%"><h3>First Level Contact Name</h3><p>'.checkempty(ucfirst($rowSite['technician_name'])).'</p></td>
							<td width="33.33%"><h3>First Level Contact Number</h3><p>'.checkempty(ucfirst($rowSite['technician_number'])).'</p></td>
						</tr>
					</table>					
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Second Level Contact Name</h3><p>'.checkempty(ucfirst($rowSite['manager_name'])).'</p></td>
							<td width="33.33%"><h3>Second Level Contact Number</h3><p>'.checkempty($rowSite['manager_number']).'</p></td>
							<td width="33.33%"><h3>Second Level Contact e-mail</h3><p>'.checkempty(ucfirst($rowSite['manager_mail'])).'</p></td>
						</tr>
					</table>
			
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Site Address</h3><p>'.checkempty($rowSite['site_address']).'</p></td>
							<td width="33.33%"><h3>Complaint</h3><p>'.checkempty(ucfirst(alias($row['complaint_alias'],'ec_complaint','complaint_alias','complaint_name'))).'</p></td>
							<td width="33.33%"><h3>Site Warranty</h3><p>'.($rowSite['mfd_date']=='0000-00-00' && $rowSite['install_date']=='0000-00-00' && $rowSite['sale_invoice_date']=='0000-00-00' ? "NA" : (sitemanfdate_check($site_alias)>0 ? 'UNDER WARRANTY' : 'OUT OF WARRANTY')).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>TT Warranty</h3><p>'.($rowSite['mfd_date']=='0000-00-00' && $rowSite['install_date']=='0000-00-00' && $rowSite['sale_invoice_date']=='0000-00-00' ? "NA" : ($row['warranty']>0 ? 'UNDER WARRANTY' : 'OUT OF WARRANTY')).'</p></td>
							<td width="33.33%"><h3>eFSR Efficiency</h3><p>'.checkempty($row['payment_terms']).'</p></td>
							<td width="33.33%"><h3>Milestone</h3><p>'.checkempty(alias($row['milestone'],'ec_milestone','mile_stone_alais','mile_stone')).'</p></td>
						</tr>
					</table>';
					if(!empty($row['efsr_no'])){
						$print.='
						<table class="cont_2">
							<tr>
								<td width="33.33%"><h3>'.(empty($row['esca_efsr_link']) ? "e-":"").'FSR No</h3><p>'.$row['efsr_no'].'</p></td>
								<td width="33.33%"><h3>'.(empty($row['esca_efsr_link']) ? "e-":"").'FSR Date</h3><p>'.(empty($row['efsr_date']) ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$row['efsr_date'])))).'</p></td>
								<td width="33.33%"><h3>'.(empty($row['esca_efsr_link']) ? "e-":"").'FSR Report</h3><p style="font-weight:bold;"><a href="'.baseurl().(!empty($row['esca_efsr_link']) ? "images/esca_efsr/".$row['esca_efsr_link'] : "enersyscare_V2/pdf/?ticket_alias=".$ticket_alias).'" target="_blank">Click Here</a></p></td>
							</tr>
						</table>';
					}
					$print.='
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Complete Observation</h3><p>'.checkempty(ucfirst($row['description'])).'</p></td>
							<td width="33.33%"><h3>Faulty Cell Count</h3><p>'.$row['faulty_cell_count'].'</p></td>
							<td width="33.33%"><h3>Closing Date</h3><p>'.(empty($row['closing_date']) ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$row['closing_date'])))).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>TAT</h3><p>'.tat($ticket_alias).'</p></td>
							<td width="33.33%"><h3>Level</h3><p>'.($level=='1' || $level=='2' || $level=='4' || $level=='5' ? repl_planfail_tsrej($level,$row['old_level'],$row['planned_date'],$row['purpose'],'name'):alias($level,'ec_levels','level_alias','level_name')).'</p></td>
							<td width="33.33%"><h3>Mode Of Contact</h3><p>'.alias($row['mode_of_contact'],'ec_moc','moc_alias','moc_name').'</p></td>
						</tr>
					</table>
					<table class="cont_2">
							<tr>
								<td width="33.33%"><h3>Status</h3><p>'.$row['status'].'</p></td>';
								if(!empty($row['contact_link'])){
									$print.='<td width="33.33%"><h3>Mode Of Contact Link</h3><p style="font-weight:bold;"><a href="'.baseurl()."images/reports/".$row['contact_link'].'" target="_blank">Click Here</a></p></td>';
								}
								if(!empty($row['moc_num'])){
									$print.='<td width="33.33%"><h3>'.alias($row['mode_of_contact'],'ec_moc','moc_alias','moc_name').' Number</h3><p>'.$row['moc_num'].'</p></td>';
								}
								if(!empty($row['po_link'])){
									$print.='<td width="33.33%"><h3>PO Copy</h3><p style="font-weight:bold;"><a href="'.baseurl()."images/reports/".$row['po_link'].'" target="_blank">Click Here</a></p></td>';
								}
					$print.='</tr>
						</table>';
					
					//Remarks
					$sqlRem = mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE item_alias='$ticket_alias' AND module='TT' AND bucket IN ('1','2','9','10','11') AND flag=0");
					$zhs = $zhs_id= $nhs = $nhs_id = "NA";
					$se_id = alias($row['service_engineer_alias'],'ec_employee_master','employee_alias','employee_id');
					$se_name = alias($row['service_engineer_alias'],'ec_employee_master','employee_alias','name');
					if(mysqli_num_rows($sqlRem)){
							$print.='
							<table class="cont_3">
								<tr>
									<td align="left">REMARKS</td>
								</tr>
							</table>
							<table class="cont_2">
								<tr>
									<td width="20%"><h3>Remarked By</h3></td>
									<td width="20%"><h3>Designation</h3></td>
									<td width="20%"><h3>Remarked On</h3></td>
									<td width="20%"><h3>Bucket</h3></td>
									<td width="20%"><h3>Remark</h3></td>
								</tr>
							</table>';
						while($rowRem = mysqli_fetch_array($sqlRem)){
							if(strtoupper($rowRem['remarked_by'])=='ADMIN'){
								$remarked_by=$designation='ADMIN';
								if($rowRem['bucket']=='9')$zhs=$zhs_id='ADMIN';else $nhs=$nhs_id='ADMIN';
							}else{
								$sql_emp=mysqli_query($mr_con,"SELECT name,employee_id,privilege_alias,designation_alias FROM ec_employee_master WHERE employee_alias='".$rowRem['remarked_by']."'");
								if(mysqli_num_rows($sql_emp)){ $row_emp=mysqli_fetch_array($sql_emp);
									$remarked_by = $row_emp['name'];
									$emp_id = $row_emp['employee_id'];
									$privilege_alias = $row_emp['privilege_alias'];
									$designation = alias($row_emp['designation_alias'],'ec_designation','designation_alias','designation');
								}else{$privilege_alias = "";}
								if(!empty($privilege_alias)){
									if($privilege_alias=='OX5E3EMI0U' && ($rowRem['bucket']=='1' || $rowRem['bucket']=='2' || $rowRem['bucket']=='9' || $rowRem['bucket']=='11')){
										$zhs=$remarked_by; $zhs_id= $emp_id;
									}
									if($privilege_alias=='WIMYJFDJPT' && ($rowRem['bucket']=='1' || $rowRem['bucket']=='2' || $rowRem['bucket']=='10' || $rowRem['bucket']=='11')){
										$nhs=$remarked_by; $nhs_id= $emp_id;
									}
								}
							}
					$print.='<table class="cont_2">
								<tr>
									<td width="20%"><p>'.ucwords(strtoupper($remarked_by)).'</p></td>
									<td width="20%"><p>'.ucwords(strtoupper($designation)).'</p></td>
									<td width="20%"><p>'.dateTimeFormat($rowRem['remarked_on'],'d').'</p></td>
									<td width="20%"><p>'.strtoupper(alias($rowRem['bucket'],'ec_remarks_bucket','bucket_level','bucket')).'</p></td>
									<td width="20%"><p>'.strtoupper($rowRem['remarks']).'</p></td>
								</tr>
							</table>';
						}
					}
					$print.='<br><br>
					<table width="100%">
						<tr>
							<td width="33.33%" align="left">'.checkempty($se_id).'</td>
							<td width="33.33%" align="center">'.$zhs_id.'</td>
							<td width="33.33%" align="right">'.$nhs_id.'</td>
						</tr>
						<tr>
							<td width="33.33%" align="left">'.checkempty($se_name).'</td>
							<td width="33.33%" align="center">'.$zhs.'</td>
							<td width="33.33%" align="right">'.$nhs.'</td>
						</tr>
						<tr>
							<th width="33.33%" align="left">(SE)</th>
							<th width="33.33%" align="center">(ZHS)</th>
							<th width="33.33%" align="right">(NHS)</th>
						</tr>
					</table>';			
					
		$print.='</td>
			</tr>
		</table></body></html>';
	}else{$print='<h2 style="text-align:center">No Records<h2>';}
	}else{$print='<h2 style="text-align:center">No Records<h2>';}
	echo $print;
	echo "<script>window.print();</script>";
	echo "<script> window.history.back(); </script>";
?>