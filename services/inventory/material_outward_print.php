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

</style>
<?php
include('../mysql.php');
include('../functions.php');
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
							$print.="<h4>REF NUMBER</h4>";
							$print.="<p>".checkempty(strtolower($row['trans_id']))."</p>";
						$print.="</td>";
			
					$print.="<td>";
							$print.="<h4>DATE OF TRANSACTION</h4>";
							$print.="<p>".checkempty(dateFormat($row['date_of_trans'],'d'))."</p>";
						$print.="</td>";
					$print.="</tr>";
					$print.="<tr>";
						$print.="<td>";
							$print.="<h4>FROM W/H</h4>";
							$print.="<p>".checkempty(ucfirst(strtolower(alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code'))))."</p>";
						$print.="</td>";
						$print.="<td>";
							$print.="<h4>TO W/H</h4>";
							$print.="<p>".$towh."</p>";
						$print.="</td>";
					$print.="</tr>";
					$print.="<tr>";
						$print.="<td>";
							$print.="<h4>TOTAL MATERIAL VALUE</h4>";
							$print.="<p>".checkempty(ucfirst(strtolower($row['totalamount'])))."</p>";
						$print.="</td>";
						$print.="<td>";
							$print.="<h4>TICKET ID</h4>";
							$print.="<p>".checkempty($ticket_id)."</p>";
						$print.="</td>";
					$print.="</tr>";
					$print.="<tr>";
						$print.="<td>";
							$print.="<h4>TRANSPORT DETAILS</h4>";
							$print.="<p>".checkempty(ucfirst(strtolower($row['transport'])))."</p>";
						$print.="</td>";
						$print.="<td>";
							$print.="<h4>DOCKET NUMBER</h4>";
							$print.="<p>".checkempty(ucfirst(strtolower($row['docket'])))."</p>";
						$print.="</td>";
					$print.="</tr>";
					$print.="<tr>";
						$print.="<td>";
							$print.="<h4>DECLARATION</h4>";
							$print.="<p>".checkempty(ucfirst(strtolower($row['transport'])))."</p>";
						$print.="</td>";
						$print.="<td>";
							$print.="<h4>MRF NUMBER</h4>";
							$print.="<p>".checkempty(ucfirst(strtolower($mrf_number)))."</p>";
						$print.="</td>";
					$print.="</tr>";
					$print.="<tr>";
						$print.="<td>";
							$print.="<h4>SJO NUMBER</h4>";
							$print.="<p>".checkempty(ucfirst(strtolower($sjo_number)))."</p>";
						$print.="</td>";
					$print.="</tr>";
				$print.="</table><br/>";
					$sql2 = mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE item_alias ='$alias' AND module='MO' AND flag=0");
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
							<td width="20%">'.checkempty(ucfirst(dateFormat($row2['remarked_on'],'d'))).'</td>
							<td width="40%">'.checkempty(ucfirst(strtolower($row2['remarks']))).'</td>
						</tr>';
					$i++;}
					$print.='</table>';
				}
				$print.='<p class="single_record"></p>';
				$sql1 = mysqli_query($mr_con,"SELECT item_type, item_code, item_description, item_condition FROM ec_material_sent_details WHERE reference='$alias' AND flag=0");
				if(mysqli_num_rows($sql1)){
						$print.='<table class="cont_3">
						<tr>
							<td align="left"><h3>SHIPPED ITEMS</h3></td>
						</tr>
						</table>';
						$print.='<table class="cont_2" cellpadding="5">
						<tr><th align="left"><h3>SR.NO</h3></th><th align="left"><h3>ITEM TYPE</h3></th><th align="left"><h3>ITEM CODE</h3></th><th align="left"><h3>CELL NO/QUANTITY</h3></th><th align="left"><h3>CONDITION</h3></th><th align="left"><h3>LOCATION</h3></th></tr>';
						$i=0;while($row1=mysqli_fetch_array($sql1)){	
						$print.='<tr><td>'.($i+1).'</td>';
							if($row1['item_type']=='1'){$item_type="CELLS";$item_code=alias($row1['item_code'],'ec_product','product_alias','product_description');}
							else{$item_type="ACCESSORIES";$item_code=alias($row1['item_code'],'ec_accessories','accessories_alias','accessory_description');}
							$print.='<td>'.checkempty($item_type).'</td>';
							$print.='<td>'.checkempty(ucfirst($item_code)).'</td>
							<td>'.checkempty(ucfirst(alias($row1['item_description'],'ec_item_code','item_code_alias','item_description'))).'</td>
							<td>'.checkempty(alias($row1['item_condition'],'ec_stock','stock_alias','description')).'</td>';
							$wname=alias($row1['item_description'],'ec_total_cell','cell_alias','location');
							$print.='<td>'.checkempty(($wname=='2609' ? 'BUFFER' : alias($wname,'ec_warehouse','wh_alias','wh_code'))).'</td></tr>';
						
					$i++;}
					$print.='</table>';
				}
		$print.='</td></tr></table></body></html>';
	}
	else{$print='<h2 style="text-align:center">No Records<h2>';}
	echo $print;
	echo "<script>window.onload = function () {window.print();setTimeout(function(){window.close();}, 1);}</script>";
?>