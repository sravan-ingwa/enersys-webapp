<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
include('../mpdf60/mpdf.php');
$stylesheet = file_get_contents('../../styles/pdf_style.css');
$alias = $_REQUEST['alias'];
$heading = 'STOCKS DETAILS';
$query = mysqli_query($mr_con,"SELECT * FROM  ec_item_code WHERE item_code_alias='$alias' AND flag='0'");
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
							<td width="33.33%"><h3>'.ucfirst('Item Code').'</h3><p>'.checkempty(ucfirst($row['item_type']==1) ? alias($row['item_code'],'ec_product','product_alias','item_code'):alias($row['item_code'],'ec_accessories','accessories_alias','item_code')).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Item Type').'</h3><p>'.checkempty(ucfirst($row['item_type']==1) ? "CELLS" : "ACCESSORIES").'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Item Description').'</h3><p>'.checkempty(strtolower($row['item_description'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.ucfirst('Quantity').'</h3><p>'.checkempty(ucfirst($row['quantity'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Item Price').'</h3><p>'.checkempty(ucfirst($row['item_price'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Sjo No').'</h3><p>'.checkempty(ucfirst($row['sjo_no'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.ucfirst('Invoice No').'</h3><p>'.checkempty(ucfirst($row['invoice_no'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Invoice Date').'</h3><p>'.dateFormat(ucfirst($row['invoice_date']),'d').'</p></td>
							<td width="33.33%"><h3></h3><p></p></td>
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