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
/*.botable td, .botable th{border:1px solid #d1d1d1;padding:3px;}*/
.subhead td{padding:3px;text-align:center;}
.single_record{
 page-break-after: always;
}
.simp{border-collapse:separate; 
border-spacing:10px;}
.simp td{
	width:50%;
	padding: 10px 5px !important;
	border: 1px solid #eee !important;
	border-left-width: 5px !important;
	border-radius: 3px;
	border-left-color: #428bca;
}
.simp p{
	margin-left:5px !important;
}
h4{color:#428bca; margin-top:5px !important; margin-bottom:5px !important; font-size:13px; font-weight:300;}
p{color:#262626 !important;font-size:11px;}

</style>
<?php
include('../mysql.php');
include('../functions.php');
$alias = $_REQUEST['alias'];
$heading = 'MATERIAL REQUEST DETAILS';
$sql = mysqli_query($mr_con,"SELECT transit_damaged,amount_range,mrf_number,sjo_file,sjo_number,sjo_date,sales_invoice_no,sales_invoice_date,sales_po_no,contact_person,customer_address,customer_phone, from_wh, to_wh, date_of_request, material_value,ticket_alias, status, readiness_date FROM ec_material_request WHERE mrf_alias ='$alias' AND flag=0");
	if(mysqli_num_rows($sql)){	
		$row=mysqli_fetch_array($sql);		
	$print='<html><body><table class="table1">
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
				$print.="<table width='100%' class='simp'>";
					$print.="<tr>";
						$print.="<td class='col-md-5 Exp_dashboard'>";
							$print.="<h4>MRF NUMBER</h4>";
							$print.="<p>".checkempty($row['mrf_number'])."</p>";
						$print.="</td>";
					$print.="<td>";
							$print.="<h4>DATE OF REQUEST</h4>";
							$print.="<p>".checkempty(dateFormat($row['date_of_request'],'d'))."</p>";
						$print.="</td>";
					$print.="</tr>";
					$print.="<tr>";
						$print.="<td>";
							$print.="<h4>FROM W/H</h4>";
							$print.="<p>".checkempty(strtoupper(alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code')))."</p>";
						$print.="</td>";
						$print.="<td>";
							$print.="<h4>TO W/H</h4>";
							$print.="<p>".checkempty($row['to_wh']=='2' ? 'Factory' : alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code'))."</p>";
						$print.="</td>";
					$print.="</tr>";
					$print.="<tr>";
						$print.="<td>";
							$print.="<h4>MATERIAL VALUE</h4>";
							$print.="<p>".checkempty(strtoupper($row['material_value']))."</p>";
						$print.="</td>";
						$print.="<td>";
							$print.="<h4>REQUEST STATUS</h4>";
							$print.="<p>".checkempty(fam_lvl_nm_clr($row['status'],"name",$alias))."</p>";
						$print.="</td>";
					$print.="</tr>";
					$print.="<tr>";
						$print.="<td>";
							$print.="<h4>TICKET ID</h4>";
							$print.="<p>".checkempty($row['ticket_alias']!='2609' ? j_getticketID($row['ticket_alias']) : "CUSTOMER BUFFER STOCK")."</p>";
						$print.="</td>";
						$print.="<td>";
							$print.="<h4>SJO NUMBER</h4>";
							$print.="<p>".checkempty(strtoupper($row['sjo_number']))."</p>";
						$print.="</td>";
					$print.="</tr>";
					$print.="<tr>";
						$print.="<td>";
							$print.="<h4>SJO DATE</h4>";
							$print.="<p>".checkempty(dateFormat($row['sjo_date'],'d'))."</p>";
						$print.="</td>";
						/*$print.="<td>";
							$print.="<h4>SJO SCANNED COPY</h4>";
							$print.="<p>".(!empty($row['sjo_file']) ? "<a href='".baseurl().$row['sjo_file']."' target='_blank'>CLICK HERE</a>" : "NA")."</p>";
						$print.="</td>";*/
						$print.="<td>";
							$print.="<h4>SALES INVOICE NUMBER</h4>";
							$print.="<p>".strtoupper($row['sales_invoice_no'])."</p>";
						$print.="</td>";
					$print.="</tr>";
					$print.="<tr>";
						$print.="<td>";
							$print.="<h4>SALES INVOICE DATE</h4>";
							$print.="<p>".dateFormat($row['sales_invoice_date'],'d')."</p>";
						$print.="</td>";
						$print.="<td>";
							$print.="<h4>SALES PO NUMBER</h4>";
							$print.="<p>".strtoupper($row['sales_po_no'])."</p>";
						$print.="</td>";
					$print.="</tr>";
					$print.="<tr>";
						$print.="<td>";
							$print.="<h4>CUSTOMER NAME</h4>";
							$print.="<p>".strtoupper($row['contact_person'])."</p>";
						$print.="</td>";
						$print.="<td>";
							$print.="<h4>CUSTOMER NUMBER</h4>";
							$print.="<p>".strtoupper($row['customer_phone'])."</p>";
						$print.="</td>";
					$print.="</tr>";
					$print.="<tr>";
						$print.="<td>";
							$print.="<h4>CUSTOMER ADDRESS</h4>";
							$print.="<p>".strtoupper($row['customer_address'])."</p>";
						$print.="</td>";
						$print.="<td>";
							$print.="<h4>ROAD PERMIT</h4>";
							$print.="<p>".get_road_permit(alias($row['from_wh'],'ec_warehouse','wh_alias','road_permit'))."</p>";
						$print.="</td>";
					$print.="</tr>";
					$print.="<tr>";
						$print.="<td>";
							$print.="<h4>MATERIAL READINESS DATE</h4>";
							$print.="<p>".dateFormat($row['readiness_date'],'d')."</p>";
						$print.="</td>";
						$print.="<td>";
							$print.="<h4>TRANSIT DAMAGED</h4>";
							$print.="<p>".transit_damaged($row['transit_damaged'])."</p>";
						$print.="</td>";
					$print.="</tr>";
					$print.="<tr>";
						$print.="<td>";
							$print.="<h4>MATERIAL AMOUNT RANGE</h4>";
							$print.="<p>".amount_range($row['amount_range'])."</p>";
						$print.="</td>";
						$print.="</tr>";
				$print.="</table>";
				$print.='<p class="single_record"></p>';
				$sql2 = mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE item_alias ='$alias' AND module='MR' AND flag=0");
				if(mysqli_num_rows($sql2)){
					$print.='<table class="cont_3">
						<tr>
							<td align="left"><h3>REMARKS</h3></td>
						</tr>
						</table>
						<table class="cont_2" cellpadding="5">
							<tr><th align="left"><h3>SR.NO</h3></th><th align="left"><h3>REMARK BY</h3></th><th align="left"><h3>REMARK ON</h3></th><th align="left"><h3>REMARK</h3></th></tr>';
					$i=0;while($row2=mysqli_fetch_array($sql2)){
					$print.='
						<tr>
							<td width="10%">'.($i+1).'</td>
							<td width="30%">'.checkempty(strtoupper($row2['remarked_by'])=='ADMIN' ? 'ADMIN':alias($row2['remarked_by'],'ec_employee_master','employee_alias','name')).'</td>
							<td width="20%">'.dateFormat($row2['remarked_on'],'d').'</td>
							<td width="40%">'.checkempty(strtoupper($row2['remarks'])).'</td>
						</tr>';
					$i++;}
					$print.="</table><br/>";
				}
					$sql1 = mysqli_query($mr_con,"SELECT * FROM ec_request_items WHERE mrf_alias ='$alias' AND flag=0");
					if(mysqli_num_rows($sql1)){
						$print.='<table class="cont_3">
						<tr>
							<td align="left"><h3>REQUESTED ITEMS</h3></td>
						</tr>
						</table>';
						$print.='<table class="cont_2" cellpadding="5">
						<tr><th align="left"><h3>SR.NO</h3></th><th align="left"><h3>ITEM TYPE</h3></th><th align="left"><h3>ITEM DESCRIPTION</h3></th><th align="left"><h3>CELL TYPE</h3></th><th align="left"><h3>REQ QTY</h3></th><th align="left"><h3>PPC QTY</h3></th><th align="left"><h3>SENT QTY</h3></th></tr>';
						$i=0;while($row1=mysqli_fetch_array($sql1)){
							$print.='<tr><td>'.($i+1).'</td>';
							if($row1['item_type']=='1'){$item_type="CELLS";$item_code=alias($row1['item_code'],'ec_product','product_alias','product_description');}
							else{$item_type="ACCESSORIES";$item_code=alias($row1['item_code'],'ec_accessories','accessories_alias','accessory_description');}
							$print.='<td>'.checkempty($item_type).'</td>';
							$print.='<td>'.checkempty(getitemname($item_type,$row1['item_description'])).'</td>
							<td>'.get_cell_type($row1['cell_type']).'</td>
							<td>'.$row1['quantity'].'</td>
							<td>'.$row1['tappr_quanty'].'</td>
							<td>'.($row1['quantity']-$row1['left_quanty']).'</td>';
						$i++;}
				$print.='</table>';
				}
		$print.='</td></tr></table></body></html>';
	}
	else{$print='<h2 style="text-align:center">No Records<h2>';}
	echo $print;
	echo "<script>window.onload = function () {window.print();setTimeout(function(){window.close();}, 1);}</script>";
?>