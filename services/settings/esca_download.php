<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
include('../mpdf60/mpdf.php');
$stylesheet = file_get_contents('../../styles/pdf_style.css');
$alias = $_REQUEST['alias'];
$heading = 'ESCA DETAILS';
$query = mysqli_query($mr_con,"SELECT * FROM  ec_esca WHERE esca_alias='$alias' AND flag IN('0','1')");
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
							<td width="33.33%"><h3>'.ucfirst('Esca Id').'</h3><p>'.checkempty(ucfirst($row['esca_id'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Esca Name').'</h3><p>'.checkempty(ucfirst($row['esca_name'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Esca Number').'</h3><p>'.checkempty(strtolower($row['esca_number'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.ucfirst('Esca Email').'</h3><p>'.checkempty(ucfirst($row['esca_email'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Zone Name').'</h3><p>'.checkempty(ucfirst($zone)).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('State Name').'</h3><p>'.checkempty(ucfirst($state)).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.strtoupper('Status').'</h3><p>'.($row['flag']=='1' ? 'DE' : '').'ACTIVE</p></td>
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