<style>
html,body{width:100%;}
.table1{border-collapse:collapse;width:90%;height:950px;}
.td1{
	border:7px double #000;height:100%;width:90%;height:950px;vertical-align:top; 
}
.table2{border-collapse:collapse;width:100%;height:100%;}
.td2{
	border:7px double #000;height:100%;width:100%;vertical-align:top; 
}
.tableHeader{
	border-bottom:1px solid #d1d1d1;
	margin-bottom:5px;
}
.cont_1{
	width:740px;
	border-bottom:2px solid #212121;
	padding:3px 5px;
	font-weight:700;
	font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;
	margin:6px 5px;
}
.cont_2{
	width:740px;
	padding:4px 5px;
	margin:0px 5px;
	font-weight:700;
	font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;
	font-size:11px;
	vertical-align:top;
}
.cont_3{
	width:740px;
	border-bottom:2px solid #212121;
	background:#2a6496;
	color:#FFF;
	padding:3px 5px;
	font-weight:700;
	font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;
	margin:5px 5px 0px 5px;
	font-size:12px;
}
.cont_2 h3{color:#428bca;}
.cont_2 p{font-size:10px; font-weight:300;}
.cont_3 h3{background-color:#428bca; color:#fff;}
.botable{border-collapse:collapse;font-size:12px;width:740px;}
.botable thead th{background:#2a6496; color:#FFF;padding:5px;}
.subhead td{padding:3px;text-align:center;}
.single_record{
 page-break-after: always;
}
.simp{border-collapse:separate; 
border-spacing:10px;}
.simp td{
	width:50%;
	padding: 20px 10px !important;
	border: 1px solid #eee !important;
	border-left-width: 5px !important;
	border-radius: 3px;
	border-left-color: #428bca;
}
.simp p{
	margin-left:5px !important;
}
h4{color:#428bca; margin-top:10px !important; margin-bottom:10px !important; font-size:13px; font-weight:300;}
p{color:#262626 !important;font-size:11px;}
@page{
  @top-center {
    content: element(pageHeader);
  }
}
#pageHeader{
  position: running(pageHeader);
}
</style>
<?php
include('../mysql.php');
include('../functions.php');
$alias = $_REQUEST['alias'];
$heading = 'STOCKS DETAILS';
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
		if(mysqli_num_rows($sql)){	
		$row=mysqli_fetch_array($sql);
				if($row['item_type']=="1"){
					$item_code=alias($row['item_code'],'ec_product','product_alias','product_description');
					$cell_value=round(alias($row['item_code'],'ec_product','product_alias','price'),2);
				}
				
					
		$print='<html><body><table>
					<tr>
						<td>
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
					</table>';
					if($row['item_type']==1){
				$print.="<table width='100%' class='simp'>";
					$print.="<tr>";
						$print.="<td class='col-md-5 Exp_dashboard'>";
							$print.="<h4>ITEM TYPE</h4>";
							$print.="<p>".checkempty(($row['item_type']==1 ? "CELL":"ACCESSORY"))."</p>";
						$print.="</td>";
				
					$print.="<td>";
							$print.="<h4>ITEM CODE</h4>";
							$print.="<p>".checkempty($item_code)."</p>";
						$print.="</td>";
					$print.="</tr>";
					$print.="<tr>";
						$print.="<td>";
					if($row['item_type']=="1"){$print.="<h4>CELL NUMBER</h4>";}else{$print.="<h4>QUANTITY</h4>";}
							$print.="<p>".checkempty(ucfirst(strtoupper($row['item_description'])))."</p>";
						$print.="</td>";
						
						$print.="<td>";
							$print.="<h4>CELL VALUE</h4>";
							$print.="<p>".checkempty(ucfirst(strtoupper($cell_value)))."</p>";
						$print.="</td>";
					$print.="</tr>";
					
					$sqlet = mysqli_query($mr_con,"SELECT condition_id,location FROM ec_total_cell WHERE cell_alias='".$row['item_code_alias']."'");
					if(mysqli_num_rows($sqlet)){
							while($rowet = mysqli_fetch_array($sqlet)){
								$cell_condition=alias($rowet['condition_id'],'ec_stock','stock_alias','description');
								$current_location=alias($rowet['location'],'ec_warehouse','wh_alias','wh_code');
								if($current_location =="" || $current_location =='NA')$current_location=alias($rowet['location'],'ec_sitemaster','site_alias','site_name');
								
						$print.="<tr>";
							$print.="<td>";
								$print.="<h4>CURRENT LOCATION</h4>";
								$print.="<p>".checkempty(ucfirst(strtoupper($current_location)))."</p>";
							$print.="</td>";
							$print.="<td>";
								$print.="<h4>CELL CONDITION</h4>";
								$print.="<p>".checkempty(strtoupper($cell_condition))."</p>";
							$print.="</td>";
						$print.="</tr>";
							}
					}
					$print.="<tr>";
						$print.="<td>";
							$print.="<h4>SJO NUMBER</h4>";
							$print.="<p>".checkempty(ucfirst(strtoupper(alias($row['sjo_no'],'ec_material_request','mrf_alias','sjo_number'))))."</p>";
						$print.="</td>";
						$print.="<td>";
							$print.="<h4>INVOICE / NRDC NUMBER</h4>";
							$print.="<p>".checkempty(ucfirst(strtoupper($row['invoice_no'])))."</p>";
						$print.="</td>";
					$print.="</tr>";
					$print.="<tr>";
						$print.="<td>";
							$print.="<h4>INVOICE DATE</h4>";
							$print.="<p>".checkempty(ucfirst(strtoupper(dateFormat($row['invoice_date'],"d"))))."</p>";
						$print.="</td>";
						$print.="<td>";
							$print.="<h4>FACTORY CONDITION</h4>";
							$print.="<p>".checkempty(get_cell_type($row['cell_type']))."</p>";
						$print.="</td>";
					$print.="</tr>";
				$print.="</table>";
				$print.='<p class="single_record"></p>';
					$sql1 = mysqli_query($mr_con,"SELECT message,transaction_date FROM ec_total_cell_history WHERE cell_alias = '".$row['item_code_alias']."'");
					if(mysqli_num_rows($sql1)){
						$print.='<table class="cont_3">
						<tr><td align="left"><h3>CELL HISTORY</h3></td></tr></table>';
						$print.='<table class="cont_2">
						<tr><th align="left"><h3>SR.NO</h3></th><th><h3>History</h3></th><th align="left"><h3>Transaction Date</h3></th></tr>';
						$i=0;while($row1=mysqli_fetch_array($sql1)){
						$print.='<tr><td width="5%">'.($i+1).'</td>';
						$print.='<td width="70%">'.checkempty($row1['message']).'</td>';
						$print.='<td width="25%">'.checkempty(dateTimeFormat($row1['transaction_date'],'d')).'</td>';
					$i++;}
				}
				$print.='</tr></table>';
		}
		else{
		$print.="<table width='100%' class='simp'>";
					$print.="<tr>";
						$print.="<td class='col-md-5 Exp_dashboard'>";
							$print.="<h4>ITEM TYPE</h4>";
							$print.="<p>".checkempty(($row['item_type']==1 ? "CELL":"ACCESSORY"))."</p>";
						$print.="</td>";
					$print.="<td>";
							$print.="<h4>ITEM CODE</h4>";
							$print.="<p>".alias($row['item_code'],'ec_accessories','accessories_alias','accessory_description')."</p>";
						$print.="</td>";
					$print.="</tr>";
					$print.="<tr>";
						$print.="<td>";
					$print.="<h4>QUANTITY</h4>";
							$print.="<p>".checkempty($row['item_description'])."</p>";
						$print.="</td>";
						
						$print.="<td>";
							$print.="<h4>ACCESSORY VALUE</h4>";
							$print.="<p>".$row['item_description']*(round(alias($row['item_code'],'ec_accessories','accessories_alias','price'),2))."</p>";
						$print.="</td>";
					$print.="</tr>";
					
					$sqlet = mysqli_query($mr_con,"SELECT good_qty,damaged_qty,lost_qty,location FROM ec_total_accessories WHERE acc_alias='".$row['item_code_alias']."'");
					if(mysqli_num_rows($sqlet)){ $rowet = mysqli_fetch_array($sqlet);
						$condition_desc=gd_dm_view_count($row['item_code_alias'],'1');
						if($rowet['location']=='2609')$current_location="CUSTOMER BUFFER";
						else{
							$current_location=alias($rowet['location'],'ec_warehouse','wh_alias','wh_code');
							if($current_location =="" || $current_location =='NA')$current_location=alias($rowet['location'],'ec_sitemaster','site_alias','site_name');
						}
						$print.="<tr>";
							$print.="<td>";
								$print.="<h4>CURRENT LOCATION</h4>";
								$print.="<p>".checkempty(ucfirst(strtoupper($current_location)))."</p>";
							$print.="</td>";
							$print.="<td>";
								$print.="<h4>ACCESSORY CONDITION</h4>";
								$print.="<p>".checkempty(strtoupper($condition_desc))."</p>";
							$print.="</td>";
						$print.="</tr>";
					}
					
					$print.="<tr>";
						$print.="<td>";
							$print.="<h4>SJO NUMBER</h4>";
							$print.="<p>".checkempty(ucfirst(strtoupper(alias($row['sjo_no'],'ec_material_request','mrf_alias','sjo_number'))))."</p>";
						$print.="</td>";
						$print.="<td>";
							$print.="<h4>INVOICE / NRDC NUMBER</h4>";
							$print.="<p>".checkempty(ucfirst(strtoupper($row['invoice_no'])))."</p>";
						$print.="</td>";
					$print.="</tr>";
					$print.="<tr>";
						$print.="<td>";
							$print.="<h4>INVOICE DATE</h4>";
							$print.="<p>".checkempty(ucfirst(strtoupper(dateFormat($row['invoice_date'],"d"))))."</p>";
						$print.="</td>";
						$print.="<td>";
							$print.="<h4>FACTORY CONDITION</h4>";
							$print.="<p>".checkempty(get_cell_type($row['cell_type']))."</p>";
						$print.="</td>";
					$print.="</tr>";
				$print.="</table>";
				$print.='<p class="single_record"></p>';
					$sql1 = mysqli_query($mr_con,"SELECT message,transaction_date FROM ec_total_accessory_history WHERE cell_alias = '".$row['item_code_alias']."'");
					if(mysqli_num_rows($sql1)){
						$print.='<table class="cont_3">
						<tr><td align="left"><h3>ACCESSORY HISTORY</h3></td></tr></table>';
						$print.='<table class="cont_2">
						<tr><th align="left"><h3>SR.NO</h3></th><th><h3>History</h3></th><th align="left"><h3>Transaction Date</h3></th></tr>';
						$i=0;while($row1=mysqli_fetch_array($sql1)){
						$print.='<tr><td width="5%">'.($i+1).'</td>';
						$print.='<td width="70%">'.checkempty($row1['message']).'</td>';
						$print.='<td width="25%">'.checkempty(dateTimeFormat($row1['transaction_date'],'d')).'</td>';
					$i++;}
				}
				$print.='</tr></table>';
			}
		$print.='</td></tr></table></body></html>';
	}else{$print='<h2 style="text-align:center">No Records<h2>';}
	echo $print;
	echo "<script>window.onload = function () {window.print();setTimeout(function(){window.close();}, 1);}</script>";
?>