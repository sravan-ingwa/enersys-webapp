<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
include('../mpdf60/mpdf.php');
$stylesheet = file_get_contents('../../styles/pdf_style.css');
$alias = $_REQUEST['alias'];
$heading = 'APPROVERS';
$query = mysqli_query($mr_con,"SELECT * FROM  ec_expense_approvals WHERE approval_alias='$alias' AND flag='0'");
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
						<td width="33.33%"><h3>'.strtoupper('Approval Department').'</h3><p>'.checkempty(ucfirst(alias($row['approval_dep'],'ec_department','department_alias','department_name'))).'</p></td>
						<td width="33.33%"><h3>'.strtoupper('Approval Level').'</h3><p>'.checkempty(ucfirst(expense_levels($row['approval_level']))).'</p></td>
						<td width="33.33%"><h3>'.strtoupper('Approver Department').'</h3><p>'.checkempty(ucfirst(alias($row['approver_dep'],'ec_department','department_alias','department_name'))).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.strtoupper('Approvers').'</h3><p>'.checkempty(ucfirst(alias($row['approver'],'ec_employee_master','employee_alias','name'))).'</p></td>
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
	$filename='Approversdetails_'.date('d-m-Y_H_i_s');
	$mpdf->Output("$filename.pdf", "I");
	exit;
?>