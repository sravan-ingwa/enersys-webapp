<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
include('../mpdf60/mpdf.php');
$stylesheet = file_get_contents('../../styles/pdf_style.css');
$alias = $_REQUEST['alias'];
$heading = 'EMPLOYEEMASTER DETAILS';
$query = mysqli_query($mr_con,"SELECT * FROM ec_employee_master WHERE employee_alias='$alias'");
if(mysqli_num_rows($query)){
	$row = mysqli_fetch_array($query);
	$zons=explode(", ",$row['zone_alias']);
	foreach($zons as $zon){$aa.=alias($zon,'ec_zone','zone_alias','zone_name').", ";}
	$zone=trim($aa,", ");
	
	$stats=explode(", ",$row['state_alias']);
	foreach($stats as $stat){$bb.=alias($stat,'ec_state','state_alias','state_name').", ";}
	$state=trim($bb,", ");
	
	$wh=explode(", ",$row['wh_alias']);
	foreach($wh as $wh_alias){$whh.=alias($wh_alias,'ec_warehouse','wh_alias','wh_code').", ";}
	$warehouse=trim($whh,", ");
	
	$segs=explode(", ",$row['segment_alias']);
	foreach($segs as $seg){$dd.=alias($seg,'ec_segment','segment_alias','segment_name').", ";}
	$segment=trim($dd,", ");
	
	$custs=explode(", ",$row['customer_alias']);
	foreach($custs as $cust){$ee.=alias($cust,'ec_customer','customer_alias','customer_code').", ";}
	$customer=trim($ee,", ");
	
	$assets=explode(", ",$row['asset_alias']);
	foreach($assets as $ass){$cc.=alias($ass,'ec_assets','asset_alias','asset_name').", ";}
	$asset=trim($cc,", ");
	
	$download='<html><body>
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
						<td align="left">'.$heading.'</td>
					</tr>
				</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Name</h3><p>'.checkempty($row['name']).'</p></td>
							<td width="33.33%"><h3>Employee ID</h3><p>'.checkempty($row['employee_id']).'</p></td>
							<td width="33.33%"><h3>Email ID</h3><p>'.checkempty(strtolower($row['email_id'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Mobile Number</h3><p>'.checkempty($row['mobile_number']).'</p></td>
							<td width="33.33%"><h3>Zone Name</h3><p>'.checkempty($zone).'</p></td>
							<td width="33.33%"><h3>Sitate Name</h3><p>'.checkempty($state).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Ware Code</h3><p>'.checkempty($warehouse).'</p></td>
							<td width="33.33%"><h3>Segment</h3><p>'.checkempty($segment).'</p></td>
							<td width="33.33%"><h3>Customer</h3><p>'.checkempty($customer).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Base Location</h3><p>'.checkempty($row['base_location']).'</p></td>
							<td width="33.33%"><h3>Designation</h3><p>'.checkempty(alias($row['designation_alias'],'ec_designation','designation_alias','designation')).'</p></td>
							<td width="33.33%"><h3>Department</h3><p>'.checkempty(alias($row['department_alias'],'ec_department','department_alias','department_name')).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Role Name</h3><p>'.checkempty(alias($row['role_alias'],'ec_emprole','role_alias','role_name')).'</p></td>
							<td width="33.33%"><h3>Esca Name</h3><p>'.checkempty(alias($row['esca_alias'],'ec_esca','esca_alias','esca_name')).'</p></td>
							<td width="33.33%"><h3>Privilege Name</h3><p>'.checkempty(alias($row['privilege_alias'],'ec_privileges','privilege_alias','privilege_name')).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Qualification</h3><p>'.checkempty($row['qualification']).'</p></td>
							<td width="33.33%"><h3>Specialization</h3><p>'.checkempty($row['specialization']).'</p></td>
							<td width="33.33%"><h3>Total Experience</h3><p>'.checkempty($row['total_experience']).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>El Experience</h3><p>'.el_experience($row['joining_date'], $row['relieving_date']).'</p></td>
							<td width="33.33%"><h3>Joining Date</h3><p>'.dateFormat(strtolower($row['joining_date']),'d').'</p></td>
							<td width="33.33%"><h3>Relieving Date</h3><p>'.dateFormat($row['relieving_date'],'d').'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Asset Name</h3><p>'.checkempty($asset).'</p></td>
							<td width="33.33%"><h3>Status</h3><p>'.$row['status'].'</p></td>
							<td width="33.33%"><h3>Created Date</h3><p>'.dateFormat($row['created_date'],'d').'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Device IMEI 1</h3><p>'.checkempty($row['device']).'</p></td>
							<td width="33.33%"><h3>Device IMEI 2</h3><p>'.checkempty($row['device_2']).'</p></td>
							<td width="33.33%"><h3>Cash card</h3><p>'.checkempty($row['cash_card']).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>THS Notified</h3><p>'.($row['ths_notified']==1 ? 'SHOW':'HIDE').'</p></td>
							<td width="33.33%"><h3>Profile Picture</h3><p><img src="'.baseurl().(!empty($row['profile_pic']) ? 'images/profile_pics/'.$row['profile_pic'] : 'images/gallery/profile_male').'" width="50" height="50"></p></td>
							<td width="33.33%">'.(!empty($row['noc']) ? '<h3>NOC</h3><p><a href="'.baseurl().'images/reports/'.$row['noc'].'">Click Here</a></p>' : '').'</td>
						</tr>
					</table>';
		$download.='</td>
		</tr>
	</table></body></html>';
	}else{$download='<h2 style="text-align:center">No Records<h2>';}
	$mpdf=new mPDF('','', 0, '', 5, 5, 5, 5, '', '2', '');
	$mpdf->SetHTMLFooter("<p style=\"text-align:right;font-style: italic;font-size:12px;\">{PAGENO}/{nbpg}</p>");
	$mpdf->pagenumPrefix = 'Page No : ';
	$mpdf->SetWatermarkImage('../../images/gallery/logo-3.png');
	$mpdf->showWatermarkImage = true;
	$mpdf->watermarkImageAlpha = 0.06;
	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($download,2);
	$filename='Employeemaster_'.date('d-m-Y_H_i_s');
	$mpdf->Output("$filename.pdf", "I");
	exit;
?>