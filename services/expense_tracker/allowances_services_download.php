<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
include('../mpdf60/mpdf.php');
$stylesheet = file_get_contents('../../styles/pdf_style.css');
$ser_alias = $_REQUEST['alias'];
$heading = 'SERVICES ALLOWANCES';
$query = mysqli_query($mr_con,"SELECT *,(SELECT i.zone_name FROM ec_zone i WHERE i.zone_alias = s.zone_alias) AS zone_name, (SELECT t.state_name FROM ec_state t WHERE t.state_alias = s.state_alias) AS state_name,(SELECT d.district_name FROM ec_district d WHERE d.district_alias = s.district_alias) AS district_name,(SELECT d.area FROM ec_district d WHERE d.district_alias = s.district_alias) AS area FROM ec_service_allowances s WHERE s.service_allowance_alias='$ser_alias' AND s.flag=0");
if(mysqli_num_rows($query)){
	$row = mysqli_fetch_array($query);
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
						<td width="33.33%"><h3>'.strtoupper('Zone').'</h3><p>'.checkempty(ucfirst($row['zone_name'])).'</p></td>
						<td width="33.33%"><h3>'.strtoupper('State').'</h3><p>'.checkempty(ucfirst($row['state_name'])).'</p></td>
						<td width="33.33%"><h3>'.strtoupper('District').'</h3><p>'.checkempty(ucfirst($row['district_name'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>';
						$area=alias($row['district_alias'],'ec_district','district_alias','area');
						if($area==0){$area_name="Plain Area";}else{$area_name="Hilly Area";}
							$download.='<td width="33.33%"><h3>'.strtoupper('Area').'</h3><p>'.$area_name.'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Lodging Amount').'</h3><p>'.checkempty($row['lodging_amount']).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Dially Allowances').'</h3><p>'.checkempty($row['daily_allowance']).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
						<td width="33.33%"><h3>'.strtoupper('Local Conveyance').'</h3><p>'.checkempty($row['local_conveyance']).'</p></td>
						<td width="33.33%"></td>
						<td width="33.33%"></td>
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
	$filename='ServiceAllowancesdetails_'.date('d-m-Y_H_i_s');
	$mpdf->Output("$filename.pdf", "I");
	exit;
?>