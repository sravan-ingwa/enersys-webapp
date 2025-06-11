<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
include('../mpdf60/mpdf.php');
$stylesheet = file_get_contents('../../styles/pdf_style.css');
$alias = $_REQUEST['alias'];
$heading = 'CUSTOMER DETAILS';
$query = mysqli_query($mr_con,"SELECT * FROM  ec_customer WHERE customer_alias='$alias' AND flag IN('0','1')");
if(mysqli_num_rows($query)){
	$row = mysqli_fetch_array($query);
	$prod = explode(", ",$row['product_alias']);
	foreach($prod as $pro){ $xx .= alias($pro,'ec_product','product_alias','product_description').", "; }
	$product = trim($xx,", ");
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
							<td width="33.33%"><h3>'.ucfirst('Customer Name').'</h3><p>'.checkempty(ucfirst($row['customer_name'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Customer Code').'</h3><p>'.checkempty(ucfirst($row['customer_code'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Customer Email').'</h3><p>'.checkempty(strtolower($row['customer_email'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.ucfirst('Customer Contact').'</h3><p>'.checkempty(ucfirst($row['customer_contact'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Dispatch Months').'</h3><p>'.checkempty(ucfirst($row['dispatch'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Installation Months').'</h3><p>'.checkempty(ucfirst($row['installation'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.ucfirst('Segment').'</h3><p>'.checkempty(ucfirst(alias($row['segment_alias'],'ec_segment','segment_alias','segment_name'))).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Product').'</h3><p>'.checkempty(ucfirst($product)).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Schedule').'</h3><p>'.checkempty(ucfirst($row['schedule'])).'</p></td>
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