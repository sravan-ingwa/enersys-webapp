<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
include('../mpdf60/mpdf.php');
$stylesheet = file_get_contents('../../styles/pdf_style.css');
$alias = $_REQUEST['alias'];
$heading = 'SITEMASTER DETAILS';
$query = mysqli_query($mr_con,"SELECT * FROM  ec_sitemaster WHERE site_alias='$alias' AND flag='0'");
if(mysqli_num_rows($query)){
	$row = mysqli_fetch_array($query);
	$pro=explode(", ",$row['product_alias']);
	foreach($pro as $prod){$xx.=alias($prod,'ec_product','product_alias','product_description').", ";}
	$product=trim($xx,", ");
	
	$site = sitestatus($row['customer_alias'],$row['mfd_date'],$row['install_date']);
	$schedule=$site['schedule'];
	$warrantyleft=$site['warrantyleft'];
	$warrantymonths=$site['warrantymonths'];
	$warrantystatus=$site['warrantystatus'];
	
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
							<td width="33.33%"><h3>'.ucfirst('Zone').'</h3><p>'.checkempty(ucfirst(alias($row['zone_alias'],'ec_zone','zone_alias','zone_name'))).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('State').'</h3><p>'.checkempty(ucfirst(alias($row['state_alias'],'ec_state','state_alias','state_name'))).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('District').'</h3><p>'.checkempty(ucfirst(alias($row['district_alias'],'ec_district','district_alias','district_name'))).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.ucfirst('Segment').'</h3><p>'.checkempty(ucfirst(alias($row['segment_alias'],'ec_segment','segment_alias','segment_name'))).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Customer').'</h3><p>'.checkempty(ucfirst(alias($row['customer_alias'],'ec_customer','customer_alias','customer_name'))).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Site Type').'</h3><p>'.checkempty(ucfirst(alias($row['site_type_alias'],'ec_site_type','site_type_alias','site_type'))).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.ucfirst('Site ID').'</h3><p>'.checkempty(ucfirst($row['site_id'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Site Name').'</h3><p>'.checkempty(ucfirst($row['site_name'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Product').'</h3><p>'.checkempty(ucfirst($product)).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.ucfirst('Sale PO Number').'</h3><p>'.checkempty(ucfirst($row['po_num'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Sale Invoice Number').'</h3><p>'.checkempty(ucfirst($row['sale_invoice_num'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Sale Invoice Date').'</h3><p>'.dateFormat($row['sale_invoice_date'],'d').'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.ucfirst('Mfd Date').'</h3><p>'.dateFormat(ucfirst($row['mfd_date']),'d').'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Install Date').'</h3><p>'.dateFormat(ucfirst($row['install_date']),'d').'</p></td>
							<td width="33.33%"><h3>'.ucfirst('No Of String').'</h3><p>'.checkempty(ucfirst($row['no_of_string'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.ucfirst('Technician Name').'</h3><p>'.checkempty(ucfirst($row['technician_name'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Technician Number').'</h3><p>'.checkempty(ucfirst($row['technician_number'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Manager Name').'</h3><p>'.checkempty(ucfirst($row['manager_name'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.ucfirst('Manager Number').'</h3><p>'.checkempty(ucfirst($row['manager_number'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Manager Mail').'</h3><p>'.checkempty(strtolower($row['manager_mail'])).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Site Address').'</h3><p>'.checkempty(ucfirst($row['site_address'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.ucfirst('Schedule').'</h3><p>'.ucfirst(($schedule=='0') ? "Zero" : $schedule).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Warrantyleft').'</h3><p>'.ucfirst($warrantyleft).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Warranty Months').'</h3><p>'.ucfirst($warrantymonths).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.ucfirst('Warranty Status').'</h3><p>'.ucfirst($warrantystatus).'</p></td>
							<td width="33.33%"><h3>'.ucfirst('Created Date').'</h3><p>'.dateFormat(ucfirst($row['created_date']),'d').'</p></td>
							<td width="33.33%"><h3></p></td>
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
	$filename='Sitemaster_'.date('d-m-Y_H_i_s');
	$mpdf->Output("$filename.pdf", "I");
	exit;
?>