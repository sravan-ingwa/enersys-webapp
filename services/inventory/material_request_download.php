<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
include('../mpdf60/mpdf.php');
$stylesheet = file_get_contents('../../styles/pdf_style.css');
$alias = $_REQUEST['alias'];
$heading = 'MATERIAL REQUEST DETAILS';
$sql = mysqli_query($mr_con,"SELECT transit_damaged,amount_range,mrf_number,sjo_file,sjo_number,sjo_date,sales_invoice_no,sales_invoice_date,sales_po_no,contact_person,customer_address,customer_phone, from_wh, to_wh, date_of_request, material_value,ticket_alias, status, readiness_date FROM ec_material_request WHERE mrf_alias ='$alias' AND flag=0");
		if(mysqli_num_rows($sql)){	
		$row=mysqli_fetch_array($sql);
	$download='<html><body><table class="table1">
		<tr>
			<td><br><br><br>
				<table class="cont_3">
					<tr>
						<td align="left">'.strtoupper($heading).'</td>
					</tr>
				</table>';
				$download.="<table width='100%' class='simp'>";
					$download.="<tr>";
						$download.="<td class='col-md-5 Exp_dashboard'>";
							$download.="<h4>MRF NUMBER</h4>";
							$download.="<p>".checkempty(strtoupper($row['mrf_number']))."</p>";
						$download.="</td>";
				
					$download.="<td>";
							$download.="<h4>DATE OF REQUEST</h4>";
							$download.="<p>".dateFormat($row['date_of_request'],'d')."</p>";
						$download.="</td>";
					$download.="</tr>";
					$download.="<tr>";
						$download.="<td>";
							$download.="<h4>FROM W/H</h4>";
							$download.="<p>".checkempty(strtoupper(alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code')))."</p>";
						$download.="</td>";
						$download.="<td>";
							$download.="<h4>TO W/H</h4>";
							$download.="<p>".checkempty($row['to_wh']=='2' ? 'Factory' : alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code'))."</p>";
						$download.="</td>";
					$download.="</tr>";
					$download.="<tr>";
						$download.="<td>";
							$download.="<h4>MATERIAL VALUE</h4>";
							$download.="<p>".checkempty(strtoupper($row['material_value']))."</p>";
						$download.="</td>";
						$download.="<td>";
							$download.="<h4>REQUEST STATUS</h4>";
							$download.="<p>".checkempty(fam_lvl_nm_clr($row['status'],"name",$alias))."</p>";
						$download.="</td>";
					$download.="</tr>";
					$download.="<tr>";
						$download.="<td>";
							$download.="<h4>TICKET ID</h4>";
							$download.="<p>".checkempty($row['ticket_alias']!='2609' ? j_getticketID($row['ticket_alias']) : "CUSTOMER BUFFER STOCK")."</p>";
						$download.="</td>";
						$download.="<td>";
							$download.="<h4>SJO NUMBER</h4>";
							$download.="<p>".checkempty(strtoupper($row['sjo_number']))."</p>";
						$download.="</td>";
					$download.="</tr>";
					$download.="<tr>";
						$download.="<td>";
							$download.="<h4>SJO DATE</h4>";
							$download.="<p>".checkempty(strtoupper(dateFormat($row['sjo_date'],'d')))."</p>";
						$download.="</td>";
						$download.="<td>";
							$download.="<h4>SJO SCANNED COPY</h4>";
							$download.="<p>".(!empty($row['sjo_file']) ? "<a href='".baseurl().$row['sjo_file']."' target='_blank'>CLICK HERE</a>" : "NA")."</p>";
						$download.="</td>";
					$download.="</tr>";
					$download.="<tr>";
						$download.="<td>";
							$download.="<h4>SALES INVOICE NUMBER</h4>";
							$download.="<p>".strtoupper($row['sales_invoice_no'])."</p>";
						$download.="</td>";
						$download.="<td>";
							$download.="<h4>SALES INVOICE DATE</h4>";
							$download.="<p>".dateFormat($row['sales_invoice_date'],'d')."</p>";
						$download.="</td>";
					$download.="</tr>";
					$download.="<tr>";
						$download.="<td>";
							$download.="<h4>SALES PO NUMBER</h4>";
							$download.="<p>".strtoupper($row['sales_po_no'])."</p>";
						$download.="</td>";
						$download.="<td>";
							$download.="<h4>CUSTOMER NAME</h4>";
							$download.="<p>".strtoupper($row['contact_person'])."</p>";
						$download.="</td>";
					$download.="</tr>";
					$download.="<tr>";
						$download.="<td>";
							$download.="<h4>CUSTOMER NUMBER</h4>";
							$download.="<p>".strtoupper($row['customer_phone'])."</p>";
						$download.="</td>";
						$download.="<td>";
							$download.="<h4>CUSTOMER ADDRESS</h4>";
							$download.="<p>".strtoupper($row['customer_address'])."</p>";
						$download.="</td>";
						$download.="</tr>";
					$download.="<tr>";
						$download.="<td>";
							$download.="<h4>ROAD PERMIT</h4>";
							$download.="<p>".get_road_permit(alias($row['from_wh'],'ec_warehouse','wh_alias','road_permit'))."</p>";
						$download.="</td>";
						$download.="<td>";
							$download.="<h4>MATERIAL READINESS DATE</h4>";
							$download.="<p>".dateFormat($row['readiness_date'],'d')."</p>";
						$download.="</td>";
						$download.="</tr>";
					$download.="<tr>";
						$download.="<td>";
							$download.="<h4>TRANSIT DAMAGED</h4>";
							$download.="<p>".transit_damaged($row['transit_damaged'])."</p>";
						$download.="</td>";
						$download.="<td>";
							$download.="<h4>MATERIAL AMOUNT RANGE</h4>";
							$download.="<p>".amount_range($row['amount_range'])."</p>";
						$download.="</td>";
						$download.="</tr>";
				$download.="</table><br/>";
				$sql2 = mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE item_alias ='$alias' AND module='MR' AND flag=0");
				if(mysqli_num_rows($sql2)){
					$download1.='<table class="cont_3">
						<tr>
							<td align="left"><h3>REMARKS</h3></td>
						</tr>
						</table>
					<table class="cont_2" cellpadding="5">
						<tr><th align="left"><h3>SR.NO</h3></th><th align="left"><h3>REMARK BY</h3></th><th align="left"><h3>REMARK ON</h3></th><th align="left"><h3>REMARK</h3></th></tr>';
					$i=0;while($row2=mysqli_fetch_array($sql2)){
					$download1.='
						<tr>
							<td width="10%">'.($i+1).'</td>
							<td width="30%">'.checkempty(strtoupper($row2['remarked_by'])=='ADMIN' ? 'ADMIN':alias($row2['remarked_by'],'ec_employee_master','employee_alias','name')).'</td>
							<td width="20%">'.dateFormat($row2['remarked_on'],'d').'</td>
							<td width="40%">'.checkempty(strtoupper($row2['remarks'])).'</td>
						</tr>';
					$i++;}
					$download1.="</table><br/>";
				}
				$sql1 = mysqli_query($mr_con,"SELECT * FROM ec_request_items WHERE mrf_alias ='$alias' AND flag='0'");
				if(mysqli_num_rows($sql1)){
					$download1.='<table class="cont_3">
					<tr>
						<td align="left"><h3>REQUESTED ITEMS</h3></td>
					</tr>
					</table>';
					$download1.='<table class="cont_2" cellpadding="5">
					<tr><th align="left"><h3>SR.NO</h3></th><th align="left"><h3>ITEM TYPE</h3></th><th align="left"><h3>ITEM DESCRIPTION</h3></th><th align="left"><h3>CELL TYPE</h3></th><th align="left"><h3>REQ QTY</h3></th><th align="left"><h3>PPC QTY</h3></th><th align="left"><h3>SENT QTY</h3></th></tr>';
					$i=0;while($row1=mysqli_fetch_array($sql1)){
						$download1.='<tr><td>'.($i+1).'</td>';
						if($row1['item_type']=='1'){$item_type="CELLS";$item_code=alias($row1['item_code'],'ec_product','product_alias','product_description');}
						else{$item_type="ACCESSORIES";$item_code=alias($row1['item_code'],'ec_accessories','accessories_alias','accessory_description');}
						$download1.='<td>'.checkempty($item_type).'</td>';
						$download1.='<td>'.checkempty(getitemname($item_type,$row1['item_description'])).'</td>
						<td>'.get_cell_type($row1['cell_type']).'</td>
						<td>'.$row1['quantity'].'</td>
						<td>'.$row1['tappr_quanty'].'</td>
						<td>'.($row1['quantity']-$row1['left_quanty']).'</td>';
					$i++;}
				$download1.='</table>';
				}
		$download.='</td></tr></table></body></html>';
	}
	else{$download='<h2 style="text-align:center">No Records<h2>';}
	$mpdf=new mPDF('','', 0, '', 5, 5, 5, 20, '', 2, '');
	$mpdf->SetHTMLHeader('<table class="tableHeader" width="100%">
					<tr>
						<td align="left" width="35%"><img src="../../images/gallery/logo1.png"></td>
						<td align="center" width="50%"><h2>'.$heading.'<h2></ td>
						<td align="right" width="35%"><img src="../../images/gallery/logo-4.jpg" width="100px"></td>
					</tr>
				</table>');
	$mpdf->SetHTMLFooter("<p style=\"text-align:right;font-style: italic;font-size:12px;\">{PAGENO}/{nbpg}</p>");
	$mpdf->SetWatermarkImage('../../images/gallery/logo-3.png');
	$mpdf->showWatermarkImage = true;
	$mpdf->watermarkImageAlpha = 0.06;
	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($download,2);
	$mpdf->AddPage('','', 0, '', 5, 5, 5, 20, '', 2, '');
	$mpdf->WriteHTML($download1,3);
	$filename='MaterialRequest_'.date('d-m-Y_H_i_s');
	$mpdf->Output("$filename.pdf", "I");
	exit;
?>