<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
include('../mpdf60/mpdf.php');
$stylesheet = file_get_contents('../../styles/pdf_style.css');
$alias = $_REQUEST['alias'];
$heading = 'ASSETS DETAILS';
$query = mysqli_query($mr_con,"SELECT * FROM  ec_assets WHERE asset_alias='$alias' AND flag='0'");
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
							<td width="33.33%"><h3>'.ucfirst('Asset Type').'</h3><p>'.checkempty(ucfirst($row['asset_type'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Asset Name').'</h3><p>'.checkempty(ucfirst($row['asset_name'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Asset Make').'</h3><p>'.checkempty(ucfirst($row['asset_make'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.ucfirst('Asset Serial Number').'</h3><p>'.checkempty(ucfirst($row['asset_serial_number'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('specification').'</h3><p>'.checkempty(ucfirst($row['specification'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Nature Of Asset').'</h3><p>'.checkempty(ucfirst($row['nature_of_asset'])).'</p></td>
							
						</tr>
					</table>';
					if($row['asset_type']=="TOOLS"){
					$download.='<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.ucfirst('Calibration Date').'</h3><p>'.dateFormat(ucfirst($row['calibration_date']),'d').'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Calibration Due Date').'</h3><p>'.dateFormat(ucfirst($row['calibration_due_date']),'d').'</p></td>
							
							<td width="33.33%"></td>
						</tr>
					</table>';
					}
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
	$filename='Assetdetails_'.date('d-m-Y_H_i_s');
	$mpdf->Output("$filename.pdf", "I");
	exit;
?>