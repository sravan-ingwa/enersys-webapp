<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
include('../mpdf60/mpdf.php');
$stylesheet = file_get_contents('../../styles/pdf_style.css');
$alias = $_REQUEST['alias'];
$heading = 'SJO SEARCH DETAILS';
function gd_dm_view_count($item_description,$ref){ global $mr_con; //1->view; 2->count;
	$sql = mysqli_query($mr_con,"SELECT good_qty,damaged_qty,lost_qty FROM ec_total_accessories WHERE acc_alias ='$item_description' AND flag='0'");
	if(mysqli_num_rows($sql)){ $row=mysqli_fetch_array($sql);
		$good_qty=$row['good_qty'];
		$damaged_qty=$row['damaged_qty'];
		$lost_qty=$row['lost_qty'];
		if($ref=='1'){ return (!empty($good_qty)?"Good:".$good_qty:"").(!empty($good_qty)&&!empty($damaged_qty)?", ":"").(!empty($damaged_qty)?"Damaged:".$damaged_qty:"").(!empty($good_qty)&&empty($damaged_qty)&&!empty($lost_qty)?", ":"").(!empty($damaged_qty)&&!empty($lost_qty)?", ":"").(!empty($lost_qty)?"Lost:".$lost_qty:"");}
		else{ return $good_qty."@@".$damaged_qty."@@".$lost_qty;}
	}else{return "NA";}
}
	$sql=mysqli_query($mr_con,"SELECT * FROM ec_item_code WHERE item_code_alias='$alias' AND flag=0");
	$download=$download1='';
		if(mysqli_num_rows($sql)){	
		$row=mysqli_fetch_array($sql);
				if($row['item_type']=="1"){
					$item_code=alias($row['item_code'],'ec_product','product_alias','product_description');
					$cell_value=round(alias($row['item_code'],'ec_product','product_alias','price'),2);
				}
		$download='<html><body><table class="table1">
					<tr>
						<td>
							<table class="tableHeader" width="100%">
							<tr>
								<td align="left" width="35%"><img src="../../images/gallery/logo1.png"></td>
								<td align="center" width="50%"><h3>'.$heading.'</h3></ td>
								<td align="right" width="35%"><img src="../../images/gallery/logo-4.jpg" width="100px"></td>
							</tr>
						</table>
					<table class="cont_3">
						<tr>
							<td align="left">'.strtoupper($heading).'</td>
						</tr>
					</table>';
					if($row['item_type']==1){
				$download.="<table width='100%' class='simp'>";
					$download.="<tr>";
						$download.="<td class='col-md-5 Exp_dashboard'>";
							$download.="<h4>ITEM TYPE</h4>";
							$download.="<p>".checkempty(($row['item_type']==1 ? "CELL":"ACCESSORY"))."</p>";
						$download.="</td>";
				
					$download.="<td>";
							$download.="<h4>ITEM CODE</h4>";
							$download.="<p>".checkempty($item_code)."</p>";
						$download.="</td>";
					$download.="</tr>";
					$download.="<tr>";
						$download.="<td>";
					$download.="<h4>CELL NUMBER</h4>";
							$download.="<p>".checkempty(ucfirst(strtoupper($row['item_description'])))."</p>";
						$download.="</td>";
						
						$download.="<td>";
							$download.="<h4>CELL VALUE</h4>";
							$download.="<p>".checkempty(ucfirst(strtoupper($cell_value)))."</p>";
						$download.="</td>";
					$download.="</tr>";
					
					$sqlet = mysqli_query($mr_con,"SELECT condition_id,location FROM ec_total_cell WHERE cell_alias='".$row['item_code_alias']."'");
					if(mysqli_num_rows($sqlet)){
							while($rowet = mysqli_fetch_array($sqlet)){
								$cell_condition=alias($rowet['condition_id'],'ec_stock','stock_alias','description');
								$current_location=alias($rowet['location'],'ec_warehouse','wh_alias','wh_code');
								if($current_location =="" || $current_location =='NA')$current_location=alias($rowet['location'],'ec_sitemaster','site_alias','site_name');
								
						$download.="<tr>";
							$download.="<td>";
								$download.="<h4>CURRENT LOCATION</h4>";
								$download.="<p>".checkempty(ucfirst(strtoupper($current_location)))."</p>";
							$download.="</td>";
							$download.="<td>";
								$download.="<h4>CELL CONDITION</h4>";
								$download.="<p>".checkempty(strtoupper($cell_condition))."</p>";
							$download.="</td>";
						$download.="</tr>";
							}
					}

					$download.="<tr>";
						$download.="<td>";
							$download.="<h4>SJO NUMBER</h4>";
							$download.="<p>".checkempty(ucfirst(strtoupper(alias($row['sjo_no'],'ec_material_request','mrf_alias','sjo_number'))))."</p>";
						$download.="</td>";
						
				$download.="</table>";
				$sql1 = mysqli_query($mr_con,"SELECT message,transaction_date FROM ec_total_cell_history WHERE cell_alias = '".$row['item_code_alias']."'");
				$ss=mysqli_num_rows($sql1);
				if($ss){
					$download1.='<table class="cont_3">
					<tr><td align="left"><h3>CELL HISTORY</h3></td></tr></table>';
					$download1.='<table class="cont_2" cellpadding="5">
					<tr><th align="left"><h3>SR.NO</h3></th><th><h3>HISTORY</h3></th><th align="left"><h3>TRANSATION DATE</h3></th></tr>';
					$i=0;while($row1=mysqli_fetch_array($sql1)){
						$download1.='<tr><td>'.($i+1).'</td>';
						$download1.='<td>'.checkempty($row1['message']).'</td>';
						$download1.='<td>'.checkempty(dateTimeFormat($row1['transaction_date'],'d')).'</td></tr>';
					$i++;}
					$download1.='</table>';
				}
			}else{
				$download.="<table width='100%' class='simp'>";
					$download.="<tr>";
						$download.="<td class='col-md-5 Exp_dashboard'>";
							$download.="<h4>ITEM TYPE</h4>";
							$download.="<p>".checkempty(($row['item_type']==1 ? "CELLS":"ACCESSORIES"))."</p>";
						$download.="</td>";
				
					$download.="<td>";
							$download.="<h4>ITEM CODE</h4>";
							$download.="<p>".alias($row['item_code'],'ec_accessories','accessories_alias','accessory_description')."</p>";
						$download.="</td>";
					$download.="</tr>";
					$download.="<tr>";
						$download.="<td>";
					$download.="<h4>QUANTITY</h4>";
							$download.="<p>".checkempty($row['item_description'])."</p>";
						$download.="</td>";
						
						$download.="<td>";
							$download.="<h4>ACCESSSORY VALUE</h4>";
							$download.="<p>'".$row['item_description']*(round(alias($row['item_code'],'ec_accessories','accessories_alias','price'),2))."'</p>";
						$download.="</td>";
					$download.="</tr>";
					
					$sqlet = mysqli_query($mr_con,"SELECT good_qty,damaged_qty,lost_qty,location FROM ec_total_accessories WHERE acc_alias='".$row['item_code_alias']."'");
					if(mysqli_num_rows($sqlet)){ $rowet = mysqli_fetch_array($sqlet);
						$condition_desc=gd_dm_view_count($row['item_code_alias'],'1');
						if($rowet['location']=='2609')$current_location="CUSTOMER BUFFER";
						else{
							$current_location=alias($rowet['location'],'ec_warehouse','wh_alias','wh_code');
							if($current_location =="" || $current_location =='NA')$current_location=alias($rowet['location'],'ec_sitemaster','site_alias','site_name');
						}
						$download.="<tr>";
							$download.="<td>";
								$download.="<h4>CURRENT LOCATION</h4>";
								$download.="<p>".checkempty(ucfirst(strtoupper($current_location)))."</p>";
							$download.="</td>";
							$download.="<td>";
								$download.="<h4>ACCESSORY CONDITION</h4>";
								$download.="<p>".checkempty(strtoupper($condition_desc))."</p>";
							$download.="</td>";
						$download.="</tr>";
					}

					$download.="<tr>";
						$download.="<td>";
							$download.="<h4>SJO NUMBER</h4>";
							$download.="<p>".checkempty(ucfirst(strtoupper(alias($row['sjo_no'],'ec_material_request','mrf_alias','sjo_number'))))."</p>";
						$download.="</td>";
					$download.="</tr>";
				$download.="</table>";
				$sql1 = mysqli_query($mr_con,"SELECT message,transaction_date FROM ec_total_accessory_history WHERE cell_alias = '".$row['item_code_alias']."'");
				$ss=mysqli_num_rows($sql1);
				if($ss){
					$download1.='<table class="cont_3">
					<tr><td align="left"><h3>ACCESSORY HISTORY</h3></td></tr></table>';
					$download1.='<table class="cont_2" cellpadding="5">
					<tr><th align="left"><h3>SR.NO</h3></th><th><h3>HISTORY</h3></th><th align="left"><h3>TRANSACTION DATE</h3></th></tr>';
					$i=0;while($row1=mysqli_fetch_array($sql1)){
						$download1.='<tr><td>'.($i+1).'</td>';
						$download1.='<td>'.checkempty($row1['message']).'</td>';
						$download1.='<td>'.checkempty(dateTimeFormat($row1['transaction_date'],'d')).'</td></tr>';
					$i++;}$download1.='</table>';
				}
				
			}	
		$download.='</td></tr></table></body></html>';
	}
	else{$download='<h2 style="text-align:center">No Records<h2>';}
	$mpdf=new mPDF('','', 0, '', 5, 5, 5, 5, '', '2', '');
	$mpdf->SetHTMLFooter("<p style=\"text-align:right;font-style: italic;font-size:12px;\">Page No : {PAGENO}/{nbpg}</p>");
	$mpdf->SetWatermarkImage('../../images/gallery/logo-3.png');
	$mpdf->showWatermarkImage = true;
	$mpdf->watermarkImageAlpha = 0.06;
	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($download,2);
	if($ss>5)$mpdf->AddPage('','', 0, '', 5, 5, 5, 5, '', '2', '');
	if(!empty($download1))$mpdf->WriteHTML($download1,3);
	$filename='SJOSearch_'.date('d-m-Y_H_i_s');
	$mpdf->Output("$filename.pdf", "I");
	exit;