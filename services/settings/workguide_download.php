<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
include('../mpdf60/mpdf.php');
$stylesheet = file_get_contents('../../styles/pdf_style.css');
$alias = $_REQUEST['alias'];
$heading = 'WORK GUIDE';
$query = mysqli_query($mr_con,"SELECT work_guide FROM ec_app_work_guide WHERE guide_alias='$alias' AND ref_id='0' AND flag='0'");
if(mysqli_num_rows($query)){
	$row = mysqli_fetch_array($query);
	$download='<html><body>
	<table class="table1">
		<tr>
			<td class="td1">
				<table class="tableHeader" width="100%">
					<tr>
						<td align="left" width="30%"><img src="../../images/gallery/logo1.png"></td>
						<td align="center" width="40%"><h2>'.$heading.'<h2></ td>
						<td align="right" width="30%"><img src="../../images/gallery/logo-4.jpg" width="100px"></td>
					</tr>
				</table>
				<table class="cont_3">
					<tr>
						<td align="left"><h3>WORK GUIDE DETAILS</h3></td>
					</tr>
				</table><br>
					<table class="cont_2">
						<tr><td><h3>'.$row['work_guide'].'</h3></td></tr>
					</table>
					<table class="cont_2">';
						$query1 = mysqli_query($mr_con,"SELECT work_guide FROM ec_app_work_guide WHERE ref_id='$alias' AND flag='0'");
						if(mysqli_num_rows($query1)){
							$i=1;while($row1 = mysqli_fetch_array($query1)){
								$download.='<tr><td style="padding:5px;">'.$i.". ".checkempty(ucfirst($row1['work_guide'])).'</td></tr>';
								$i++;
							}
						}
						else '<tr><td><h2 style="text-align:center">No Records</h2></td></tr>';
		$download.='</table>
				</td>
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
	$filename='Workguide_'.date('d-m-Y_H_i_s');
	$mpdf->Output("$filename.pdf", "I");
	exit;
?>