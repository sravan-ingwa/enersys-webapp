<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
include('../mpdf60/mpdf.php');
$stylesheet = file_get_contents('../../styles/pdf_style.css');
$ticket_alias = $_REQUEST['alias'];
$heading = 'TECHNICAL SERVICE REPORT';
$query = mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE ticket_alias='$ticket_alias' AND flag='0'");
if(mysqli_num_rows($query)){
	$row = mysqli_fetch_array($query);
	$site_alias = $row['site_alias'];
	$level = $row['level'];	
	$ticket_id=strtok($row['ticket_id'], "|");
	$f_count1 = alias($ticket_alias,'ec_engineer_observation','ticket_alias','total_faulty_count');
	$faulty_code = alias(alias($ticket_alias,'ec_engineer_observation','ticket_alias','faulty_code_alias'),'ec_faulty_code','faulty_alias','description');
	if(strpos($row['ticket_id'],"|")!==false)if($f_count1=="NA" || $f_count1=="")$f_count1 = alias(alias($ticket_id,'ec_tickets','ticket_id','ticket_alias'),'ec_engineer_observation','ticket_alias','total_faulty_count');
	
	$sqlSite = mysqli_query($mr_con,"SELECT * FROM ec_sitemaster WHERE site_alias='$site_alias'");
	if(mysqli_num_rows($sqlSite)){
		$rowSite = mysqli_fetch_array($sqlSite);
		$prod = explode(", ",$rowSite['product_alias']);
		foreach($prod as $pro){ $xx .= alias($pro,'ec_product','product_alias','product_description').", "; }
		$product=trim($xx,", ");
		$login_date=alias($ticket_id,'ec_tickets','ticket_id','login_date');
	$download='<html><body>
		<div class="td1">
				<table class="cont_3">
					<tr>
						<td align="left">TICKET DETAILS</td>
					</tr>
				</table>
					<table class="cont_2" cellpadding="5">
						<tr>
							<td width="33.33%"><h3>Ticket ID</h3><p>'.checkempty($row['ticket_id']).'</p></td>
							<td width="33.33%"><h3>Login Date</h3><p>'.(empty($login_date) ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$login_date)))).'</p></td>
							<td width="33.33%"><h3>Visit Generated Date</h3><p>'.(empty($row['login_date']) ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$row['login_date'])))).'</p></td>
						</tr>
						<tr>
							<td width="33.33%"><h3>Zone</h3><p>'.checkempty(alias($rowSite['zone_alias'],'ec_zone','zone_alias','zone_name')).'</p></td>
							<td width="33.33%"><h3>State</h3><p>'.checkempty(alias($rowSite['state_alias'],'ec_state','state_alias','state_name')).'</p></td>
							<td width="33.33%"><h3>District</h3><p>'.checkempty(alias($rowSite['district_alias'],'ec_district','district_alias','district_name')).'</p></td>
						</tr>
						<tr>
							<td width="33.33%"><h3>Site ID</h3><p>'.checkempty($rowSite['site_id']).'</p></td>
							<td width="33.33%"><h3>Site Name</h3><p>'.checkempty($rowSite['site_name']).'</p></td>
							<td width="33.33%"><h3>Segment</h3><p>'.checkempty(alias($rowSite['segment_alias'],'ec_segment','segment_alias','segment_name')).'</p></td>
						</tr>
						<tr>
							<td width="33.33%"><h3>Customer</h3><p>'.checkempty(alias($rowSite['customer_alias'],'ec_customer','customer_alias','customer_name')).'</p></td>
							<td width="33.33%"><h3>Activity</h3><p>'.checkempty(alias($row['activity_alias'],'ec_activity','activity_alias','activity_name')).'</p></td>
							<td width="33.33%"><h3>Complaint</h3><p>'.checkempty(alias($row['complaint_alias'],'ec_complaint','complaint_alias','complaint_name')).'</p></td>
						</tr>
						<tr>
							<td width="33.33%"><h3>Complete Observation</h3><p>'.checkempty(str_replace(",",", ",$row['description'])).'</p></td>
							<td width="33.33%"><h3>No of Faulty Cells reported by Customer</h3><p>'.(empty($row['faulty_cell_count']) ? 'Zero(0)' : $row['faulty_cell_count']).'</p></td>
							<td width="33.33%"><h3>No of Faulty Cells reported by Service Engineer</h3><p>'.$f_count1.'</p></td>
						</tr>
						<tr>
							<td width="33.33%"><h3>Product</h3><p>'.checkempty($product).'</p></td>
							<td width="33.33%"><h3>Battery Bank Rating</h3><p>'.checkempty($rowSite['battery_bank_rating']).'</p></td>
							<td width="33.33%"><h3>No Of Strings</h3><p>'.checkempty($rowSite['no_of_string']).'</p></td>
						</tr>
						<tr>
							<td width="33.33%"><h3>Site Type</h3><p>'.checkempty(alias($rowSite['site_type_alias'],'ec_site_type','site_type_alias','site_type')).'</p></td>
							<td width="33.33%"><h3>Manufacturing Date</h3><p>'.checkempty(dateFormat($rowSite['mfd_date'],'d')).'</p></td>
							<td width="33.33%"><h3>Installation Date</h3><p>'.checkempty(dateFormat($rowSite['install_date'],'d')).'</p></td>
						</tr>
						<tr>
							<td width="33.33%"><h3>Sale Invoice Date</h3><p>'.checkempty(dateFormat($rowSite['sale_invoice_date'],'d')).'</p></td>
							<td width="33.33%"><h3>Sale Invoice Number</h3><p>'.checkempty(ucfirst($rowSite['sale_invoice_num'])).'</p></td>
							<td width="33.33%"><h3>Sale PO Number</h3><p>'.checkempty($rowSite['po_num']).'</p></td>
						</tr>';
						if(!empty($row['po_number']) || $row['po_date']!='0000-00-00' || !empty($row['po_link'])){
			$download.='<tr>
							<td width="33.33%"><h3>Service PO Number</h3><p>'.checkempty(ucfirst($row['po_number'])).'</p></td>
							<td width="33.33%"><h3>Service PO Date</h3><p>'.checkempty(dateFormat($row['po_date'],'d')).'</p></td>
							<td width="33.33%"><h3>PO Copy</h3>'.(!empty($row['po_link']) ? '<p style="font-weight:bold;"><a href="'.baseurl()."images/reports/".$row['po_link'].'" target="_blank">Click Here</a></p>' : 'NA').'</td>
						</tr>';
						}
			$download.='<tr>
							<td width="33.33%"><h3>Warranty Status</h3><p>'.($row['warranty']>0 ? 'UNDER WARRANTY' : 'OUT OF WARRANTY').'</p></td>
							<td width="33.33%"><h3>eFSR No</h3><p>'.$row['efsr_no'].'</p></td>
							<td width="33.33%"><h3>eFSR Date</h3><p>'.($row['efsr_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$row['efsr_date'])))).'</p></td>
						</tr>
						<tr>
							<td width="33.33%"><h3>Faulty Code</h3><p>'.$faulty_code.'</p></td>
							<td width="33.33%"><h3>Closing Date</h3><p>'.($row['closing_date']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$row['closing_date'])))).'</p></td>
							<td width="33.33%"><h3>TAT</h3><p>'.tat($ticket_alias).'</p></td>
						</tr>
						<tr>
							<td width="33.33%"><h3>Visits</h3><p>'.visit_exp_count($ticket_id).'</p></td>
							<td width="33.33%"><h3>Level</h3><p>'.($level=='1' || $level=='2' || $level=='4' || $level=='5' ? repl_planfail_tsrej($level,$row['old_level'],$row['planned_date'],$row['purpose'],'name'):alias($level,'ec_levels','level_alias','level_name')).'</p></td>
							<td width="33.33%"></td>
						</tr>						
					</table>';
					
		//Remarks
		$sqlRem = mysqli_query($mr_con,"SELECT t2.name,t1.remarked_by,t2.employee_id,t2.privilege_alias,t1.remarks,t1.bucket,t1.remarked_on FROM ec_remarks t1 LEFT JOIN ec_employee_master t2 ON t1.remarked_by=t2.employee_alias WHERE t1.item_alias='$ticket_alias' AND t1.module='TT' AND t1.flag=0");//on se, esca se, zhs, nhs, ths
		$se_id=$zhs_id=$nhs_id=$ths_id=$se=$zhs=$nhs=$ths=$dis_remark='NA';
		if(mysqli_num_rows($sqlRem)){
			while($rowRem = mysqli_fetch_array($sqlRem)){
				if(strtoupper($rowRem['remarked_by'])=='ADMIN'){
					$remarked_by='ADMIN';
					if($rowRem['bucket']=='9')$zhs=$zhs_id='ADMIN';elseif($rowRem['bucket']=='10')$nhs=$nhs_id='ADMIN';else $ths=$ths_id='ADMIN';
				}else{
					$privilege_alias=$rowRem['privilege_alias'];
					$bucket=$rowRem['bucket'];
					if($bucket=='31' || $bucket=='32')$dis_remark=strtoupper($rowRem['remarks']);
					if($privilege_alias=='3WDRECJ0MA' || $privilege_alias=='PCNKPSJJEU'){ //SE
						$se=$rowRem['name'];
						$se_id=$rowRem['employee_id'];
					}elseif($privilege_alias=='OX5E3EMI0U' && ($rowRem['bucket']=='1' || $rowRem['bucket']=='2' || $rowRem['bucket']=='9' || $rowRem['bucket']=='11')){ //ZHS
						$zhs=$rowRem['name'];
						$zhs_id=$rowRem['employee_id'];
					}elseif($privilege_alias=='WIMYJFDJPT' && ($rowRem['bucket']=='1' || $rowRem['bucket']=='2' || $rowRem['bucket']=='10' || $rowRem['bucket']=='11')){ //NHS
						$nhs=$rowRem['name'];
						$nhs_id=$rowRem['employee_id'];
					}elseif($rowRem['bucket']=='12' || $rowRem['bucket']=='13' || $rowRem['bucket']=='14' || $rowRem['bucket']=='15'){ //THS
						$ths=$rowRem['name'];
						$ths_id=$rowRem['employee_id'];
						$ths_rem=$rowRem['remarks'];
						$ths_on=($rowRem['remarked_on']=="" ? "NA" : date("d-m-Y h:i:s A", strtotime(mysqli_real_escape_string($mr_con,$rowRem['remarked_on']))));
					}
				}
			}
		}
		//TS DETAILS	
		$sql2=mysqli_query($mr_con,"SELECT * FROM ec_ths_approved WHERE ticket_alias='$ticket_alias' AND flag=0");
		if(mysqli_num_rows($sql2)){ $row2=mysqli_fetch_array($sql2);
			$sql3=mysqli_query($mr_con,"SELECT GROUP_CONCAT(name SEPARATOR ',<br>') AS emp_name FROM ec_employee_master WHERE employee_alias IN ('".str_replace("|","','",$row2['persons_notified'])."') AND flag='0'");
			$emp_row=mysqli_fetch_array($sql3);
			$download.='
				<table class="cont_3">
					<tr>
						<td align="left">TECHNICAL SERVICE DETAILS</td>
					</tr>
				</table>
				<table class="cont_2" cellpadding="5">
					<tr>
						<td width="33.33%"><h3>CAR Number</h3><p>'.checkempty($row2['car_number']).'</p></td>
						<td width="33.33%"><h3>Line Number</h3><p>'.checkempty($row2['line_number']).'</p></td>
						<td width="33.33%"><h3>Shift</h3><p>'.checkempty(alias($row2['shift'],'ec_shift','shift_alias','shift_name')).'</p></td>
						</tr>
					<tr>
						<td width="33.33%"><h3>Date Of Assembly</h3><p>'.($row2['date_of_assembly']=="" || $row2['date_of_assembly']=="0000-00-00" ? "NA" : date("d-m-Y", strtotime(mysqli_real_escape_string($mr_con,$row2['date_of_assembly'])))).'</p></td>
						<td width="33.33%"><h3>Date Of Jar formation</h3><p>'.($row2['date_of_jar_form']=="" || $row2['date_of_jar_form']=="0000-00-00" ? "NA" : date("d-m-Y", strtotime(mysqli_real_escape_string($mr_con,$row2['date_of_jar_form'])))).'</p></td>
						<td width="33.33%"><h3>Corrective Actions Planned</h3><p>'.checkempty(strtoupper($row2['corect_act_Plan'])).'</p></td>
					</tr>
					<tr>
						<td width="33.33%"><h3>Persons Notified</h3><p>'.checkempty($emp_row['emp_name']).'</p></td>
						<td width="33.33%"><h3>TS Status</h3><p>'.($row['old_level']=='8' && $row['level']!='5' ? 'REJECTED' : 'APPROVED').'</p></td>
						<td width="33.33%"><h3>Root Cause of nonconformity</h3><p>'.checkempty(strtoupper($ths_rem)).'</p></td>
					</tr>
					<tr>
						<td width="33.33%"><h3>TS Remarks On</h3><p>'.checkempty($ths_on).'</p></td>
						<td width="33.33%"><h3>Deposition</h3><p>'.checkempty($row2['deposition']).'</p></td>
						<td width="33.33%"><h3>Prevent Recurrence</h3><p>'.checkempty($dis_remark).'</p></td>
					</tr>
				</table>';
			
			//FAULTY DETAILS
			$sql4=mysqli_query($mr_con,"SELECT * FROM ec_ths_faulty_ocv WHERE ths_appr_alias='".$row2['alias']."' AND flag=0");
			if(mysqli_num_rows($sql4)){
				$download.='
					<table class="cont_3">
						<tr>
							<td align="left">FAULTY CELL DETAILS</td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="10%" class="alinL"><h3>Sr. No.</h3></td>
							<td width="30%" class="alinL"><h3>FAULTY CELL Sr. No.</h3></td>
							<td width="30%" class="alinL"><h3>OCV AT DISPATCH</h3></td>
							<td width="30%" class="alinL"><h3>10th HOUR READING</h3></td>
						</tr>
					</table>';
				$j=0;while($row4 = mysqli_fetch_array($sql4)){
				$download.='
					<table class="cont_2">
						<tr>
							<td width="10%" class="alinL"><p>'.($j+1).'</p></td>
							<td width="30%" class="alinL"><p>'.checkempty($row4['faulty_cell_num']).'</p></td>
							<td width="30%" class="alinL"><p>'.checkempty($row4['ocv']).'</p></td>
							<td width="30%" class="alinL"><p>'.checkempty($row4['tenth_hour']).'</p></td>
						</tr>
					</table>';
					$j++;
				}
			}
		}
		$download.='</div>
		</body></html>';
	}else{$download='<h2 style="text-align:center">No Records<h2>';}
	}else{$download='<h2 style="text-align:center">No Records<h2>';}
	//$mpdf=new mPDF($mode, $format, $font_size, $font, $margin_left, $margin_right, $margin_top, $margin_bottom, $margin_header, $margin_footer, $orientation);
	$mpdf=new mPDF('','', 0, '', 5, 5, 30, 30, '', '2', '');
	$mpdf->SetHTMLHeader('
				<br><br><table class="tableHeader" width="100%">
					<tr>
						<td align="left" width="35%"><img src="../../images/gallery/logo1.png"></td>
						<td align="center" width="50%"><h2>'.$heading.'<h2></ td>
						<td align="right" width="35%"><img src="../../images/gallery/logo-4.jpg" width="100px"></td>
					</tr>
				</table>');
	$mpdf->SetHTMLFooter('<table width="100%" class="cont_2">
			<tr>
				<td width="25%" class="alinC">'.checkempty($se_id).'</td>
				<td width="25%" class="alinC">'.checkempty($zhs_id).'</td>
				<td width="25%" class="alinC">'.checkempty($nhs_id).'</td>
				<td width="25%" class="alinC">'.checkempty($ths_id).'</td>
			</tr>
			<tr>
				<td width="25%" class="alinC">'.checkempty($se).'</td>
				<td width="25%" class="alinC">'.checkempty($zhs).'</td>
				<td width="25%" class="alinC">'.checkempty($nhs).'</td>
				<td width="25%" class="alinC">'.checkempty($ths).'</td>
			</tr>
			<tr>
				<th width="25%">(SE)</th>
				<th width="25%">(ZHS)</th>
				<th width="25%">(NHS)</th>
				<th width="25%">(TS)</th>
			</tr>
		</table><p style="text-align:right;font-style: italic;font-size:12px;">{PAGENO}/{nbpg}</p>');
	$mpdf->pagenumPrefix = 'Page No : ';
	$mpdf->SetWatermarkImage('../../images/gallery/logo-3.png');
	$mpdf->showWatermarkImage = true;
	$mpdf->watermarkImageAlpha = 0.06;
	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($download,2);
	$filename='Tickets_'.date('d-m-Y_H_i_s');
	$mpdf->Output("$filename.pdf", "I");
	exit;
?>