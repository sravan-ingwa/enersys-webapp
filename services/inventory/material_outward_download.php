<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
include('../mpdf60/mpdf.php');
$stylesheet = file_get_contents('../../styles/pdf_style.css');
$alias = $_REQUEST['alias'];
$heading = 'MATERIAL OUTWARD DETAILS';
$sql = mysqli_query($mr_con,"SELECT from_type, from_wh, to_wh, date_of_trans, totalamount, transport, docket, dispatch_date, ref_no,sjo_number, alias, trans_id FROM ec_material_outward WHERE alias ='$alias' AND flag=0");
		if(mysqli_num_rows($sql)){
			$row=mysqli_fetch_array($sql);
			if($row['to_wh']=='2609')$towh="BUFFER";
			elseif($row['from_type']=='2')$towh="FACTORY";
			elseif($row['from_type']=='1')$towh = alias($row['to_wh'],'ec_sitemaster','site_alias','site_name');
			else $towh=alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code');
			list($mrf_number,$sjo_number,$ticket_id)=explode("@",out_m_s_t($row['from_type'],$row['to_wh'],$row['ref_no'],$row['sjo_number']));
	$download='<table class="table1">
		<tr>
			<td>
				<br><br><br><table class="cont_3">
					<tr>
						<td align="left">'.strtoupper($heading).'</td>
					</tr>
				</table>';				
				$download.="<table width='100%' class='simp'>";
				$download.="<tr>";
					$download.="<td class='col-md-5 Exp_dashboard'>";
						$download.="<h4>REF NUMBER</h4>";
						$download.="<p>".checkempty(strtolower($row['trans_id']))."</p>";
					$download.="</td>";
		
					$download.="<td>";
						$download.="<h4>DATE OF TRANSACTION</h4>";
						$download.="<p>".checkempty(dateFormat($row['date_of_trans'],'d'))."</p>";
					$download.="</td>";
				$download.="</tr>";
				$download.="<tr>";
					$download.="<td>";
						$download.="<h4>FROM W/H</h4>";
						$download.="<p>".checkempty(ucfirst(strtolower(alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code'))))."</p>";
					$download.="</td>";
					$download.="<td>";
						$download.="<h4>TO W/H</h4>";
						$download.="<p>".$towh."</p>";
					$download.="</td>";
				$download.="</tr>";
				$download.="<tr>";
					$download.="<td>";
						$download.="<h4>TOTAL MATERIAL VALUE</h4>";
						$download.="<p>".checkempty(ucfirst(strtolower($row['totalamount'])))."</p>";
					$download.="</td>";
					$download.="<td>";
						$download.="<h4>TICKET ID</h4>";
						$download.="<p>".checkempty($ticket_id)."</p>";
					$download.="</td>";
				$download.="</tr>";
				$download.="<tr>";
					$download.="<td>";
						$download.="<h4>TRANSPORT DETAILS</h4>";
						$download.="<p>".checkempty(ucfirst(strtolower($row['transport'])))."</p>";
					$download.="</td>";
					$download.="<td>";
						$download.="<h4>DOCKET NUMBER</h4>";
						$download.="<p>".checkempty(ucfirst(strtolower($row['docket'])))."</p>";
					$download.="</td>";
				$download.="</tr>";
				$download.="<tr>";
					$download.="<td>";
						$download.="<h4>DECLARATION</h4>";
						$download.="<p>".checkempty(ucfirst(strtolower($row['transport'])))."</p>";
					$download.="</td>";
					$download.="<td>";
						$download.="<h4>MRF NUMBER</h4>";
						$download.="<p>".checkempty(ucfirst(strtolower($mrf_number)))."</p>";
					$download.="</td>";
				$download.="</tr>";
				$download.="<tr>";
					$download.="<td>";
						$download.="<h4>SJO NUMBER</h4>";
						$download.="<p>".checkempty(ucfirst(strtolower($sjo_number)))."</p>";
					$download.="</td>";
				$download.="</tr>";
			$download.="</table>";
				
					$sql2 = mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE item_alias ='$alias' AND module='MO' AND flag=0");
				if(mysqli_num_rows($sql2)){
						$download.='<table class="cont_3">
							<tr>
								<td align="left"><h3>REMARKS</h3></td>
							</tr>
						</table>
						<table class="cont_2" cellpadding="5">
						<tr><th align="left"><h3>SR.NO</h3></th><th align="left"><h3>REMARK BY</h3></th><th align="left"><h3>REMARK ON</h3></th><th align="left"><h3>REMARK</h3></th></tr>';
					$i=0;while($row2=mysqli_fetch_array($sql2)){						
						$download.='
						<tr>
							<td width="10%">'.($i+1).'</td>
							<td width="30%">'.checkempty(strtoupper($row2['remarked_by'])=='ADMIN' ? 'ADMIN':alias($row2['remarked_by'],'ec_employee_master','employee_alias','name')).'</td>
							<td width="20%">'.checkempty(ucfirst(dateFormat($row2['remarked_on'],'d'))).'</td>
							<td width="40%">'.checkempty(ucfirst(strtolower($row2['remarks']))).'</td>
						</tr>';
					$i++;}
					$download.='</table>';
				}
				$sql1 = mysqli_query($mr_con,"SELECT item_type, item_code, item_description, item_condition FROM ec_material_sent_details WHERE reference='$alias' AND flag=0");
				if(mysqli_num_rows($sql1)){
						$download1.='<table class="cont_3">
						<tr>
							<td align="left"><h3>SHIPPED ITEMS</h3></td>
						</tr>
						</table>';
						$download1.='<table class="cont_2" cellpadding="5">
						<tr><th align="left"><h3>SR.NO</h3></th><th align="left"><h3>ITEM TYPE</h3></th><th align="left"><h3>ITEM CODE</h3></th><th align="left"><h3>CELL NO/QUANTITY</h3></th><th align="left"><h3>CONDITION</h3></th><th align="left"><h3>LOCATION</h3></th></tr>';
						$i=0;while($row1=mysqli_fetch_array($sql1)){
						$download1.='<tr><td>'.($i+1).'</td>';
							if($row1['item_type']=='1'){$item_type="CELLS";$item_code=alias($row1['item_code'],'ec_product','product_alias','product_description');}
							else{$item_type="ACCESSORIES";$item_code=alias($row1['item_code'],'ec_accessories','accessories_alias','accessory_description');}
							$download1.='<td>'.checkempty($item_type).'</td>';
							$download1.='<td>'.checkempty(ucfirst($item_code)).'</td>
							<td>'.checkempty(ucfirst(alias($row1['item_description'],'ec_item_code','item_code_alias','item_description'))).'</td>
							<td>'.checkempty(alias($row1['item_condition'],'ec_stock','stock_alias','description')).'</td>';
							$wname=alias($row1['item_description'],'ec_total_cell','cell_alias','location');
							$download1.='<td>'.checkempty(($wname=='2609' ? 'BUFFER' : alias($wname,'ec_warehouse','wh_alias','wh_code'))).'</td></tr>';
					$i++;}
					$download1.='</table>';
				}
				
		$download.='</td></tr></table>';
	}
	else{$download='<h2 style="text-align:center">No Records<h2>';}
	$mpdf=new mPDF('','', 0, '', 5, 5, 5, 5, '', '2', '');
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
	$mpdf->AddPage('','', 0, '', 5, 5, 5, 20, '', '2', '');
	$mpdf->WriteHTML($download1,3);
	$filename='MaterialOutward_'.date('d-m-Y_H_i_s');
	$mpdf->Output("$filename.pdf", "I");
	exit;
?>