<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
include('../../../services/mpdf60/mpdf.php');
$stylesheet = file_get_contents('../../../styles/pdf_style.css');
$alias = $_REQUEST['alias'];
$heading = 'EMPLOYEEMASTER DETAILS';
$query = mysqli_query($mr_con,"SELECT * FROM  ec_employee_master WHERE employee_alias='$alias' AND flag='0'");
if(mysqli_num_rows($query)){
	$row = mysqli_fetch_array($query);
	$zons=explode(", ",$row['zone_alias']);
	foreach($zons as $zon){$aa.=alias($zon,'ec_zone','zone_alias','zone_name').", ";}
	$zone=trim($aa,", ");
	
	$stats=explode(", ",$row['zone_alias']);
	foreach($stats as $stat){$bb.=alias($stat,'ec_state','state_alias','state_name').", ";}
	$state=trim($bb,", ");
	
	$assets=explode(", ",$row['zone_alias']);
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
						<td align="left">'.strtoupper($heading).'</td>
					</tr>
				</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.ucfirst('Name').'</h3><p>'.checkempty(ucfirst($row['name'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Employee ID').'</h3><p>'.checkempty(ucfirst($row['employee_id'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Email ID').'</h3><p>'.checkempty(strtolower($row['email_id'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.ucfirst('Mobile Number').'</h3><p>'.checkempty(ucfirst($row['mobile_number'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Zone Name').'</h3><p>'.checkempty(ucfirst($zone)).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Sitate Name').'</h3><p>'.checkempty(ucfirst($state)).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.ucfirst('Base Location').'</h3><p>'.checkempty(ucfirst($row['base_location'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Designation').'</h3><p>'.checkempty(ucfirst(alias($row['designation_alias'],'ec_designation','designation_alias','designation'))).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Department').'</h3><p>'.checkempty(ucfirst(alias($row['department_alias'],'ec_department','department_alias','department'))).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.ucfirst('Role Name').'</h3><p>'.checkempty(ucfirst(alias($row['role_alias'],'ec_emprole','role_alias','role_name'))).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Esca Name').'</h3><p>'.checkempty(ucfirst(alias($row['esca_alias'],'ec_esca','esca_alias','esca_name'))).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Privilege Name').'</h3><p>'.checkempty(ucfirst(alias($row['privilege_alias'],'ec_privileges','privilege_alias','privilege_name'))).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.ucfirst('Qualification').'</h3><p>'.checkempty(ucfirst($row['qualification'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Specialization').'</h3><p>'.checkempty(ucfirst($row['specialization'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Total Experience').'</h3><p>'.checkempty(ucfirst($row['total_experience'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.ucfirst('El Experience').'</h3><p>'.el_experience($row['joining_date'], $row['relieving_date']).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Joining Date').'</h3><p>'.dateFormat(strtolower($row['joining_date']),'d').'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Relieving Date').'</h3><p>'.dateFormat(ucfirst($row['relieving_date']),'d').'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.ucfirst('Asset Name').'</h3><p>'.checkempty(ucfirst($asset)).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Status').'</h3><p>'.ucfirst($row['status']).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Created Date').'</h3><p>'.dateFormat(ucfirst($row['created_date']),'d').'</p></td>
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