<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
include('../mpdf60/mpdf.php');
$stylesheet = file_get_contents('../../styles/pdf_style.css');
$alias = $_REQUEST['alias'];
$heading = 'WAREHOUSE DETAILS';
$query = mysqli_query($mr_con,"SELECT * FROM  ec_warehouse WHERE wh_alias='$alias' AND flag='0'");
if(mysqli_num_rows($query)){
	$row = mysqli_fetch_array($query);
	
	$zons = explode(", ",$row['zone_alias']);
	foreach($zons as $zon){ $xx .= alias($zon,'ec_zone','zone_alias','zone_name').", "; }
	$zone = trim($xx,", ");
	
	$states = explode(", ",$row['state_alias']);
	foreach($states as $stat){ $yy .= alias($stat,'ec_state','state_alias','state_name').", "; }
	$state = trim($yy,", ");
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
							<td width="33.33%"><h3>WH CODE</h3><p>'.checkempty(ucfirst($row['wh_code'])).'</p></td>
							<td width="33.33%"><h3>WH ADDRESS</h3><p>'.checkempty(ucfirst($row['wh_address'])).'</p></td>
							<td width="33.33%"><h3>ZONE NAME</h3><p>'.checkempty(ucfirst($zone)).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>STATE NAME</h3><p>'.checkempty(ucfirst($state)).'</p></td>
							<td width="33.33%"><h3>ESCA EMAIL</h3><p>'.checkempty(ucfirst($row['esca_email'])).'</p></td>
							<td width="33.33%"><h3>DESCRIPTION</h3><p>'.checkempty(ucfirst($row['description'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>ROAD PERMIT</h3><p>'.checkempty(get_road_permit($row['road_permit'])).'</p></td>
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
	$filename='Customerdetails_'.date('d-m-Y_H_i_s');
	$mpdf->Output("$filename.pdf", "I");
	exit;
?>