<style>
html,body{width:100%;}
.table1{border-collapse:collapse;width:90%;height:995px;}
.td1{
	border:7px double #000;height:100%;width:90%;height:995px;vertical-align:top; 
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
.botable td, .botable th{border:1px solid #d1d1d1;padding:3px;}
.subhead td{padding:3px;text-align:center;}
</style>
<?php
include('../mysql.php');
include('../functions.php');
$alias = $_REQUEST['alias'];
$heading = 'SITEMASTER';
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
	
	$print='<html><body>
	<table class="table1">
		<tr>
			<td class="td1">
				<table class="tableHeader" width="100%">
					<tr>
						<td align="left" width="30%"><img src="../../images/gallery/logo1.png"></td>
						<td align="center" width="40%"><h2>'.$heading.'<h2></ td>
						<td align="right" width="30%"><img src="../../images/gallery/logo-4.jpg" width="100px"></td>
					</tr>
				</table>
				<table class="cont_3">
					<tr>
						<td align="left"><h3>'.strtoupper("SITEMASTER DETAILS").'</h3></td>
					</tr>
				</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.strtoupper('Zone').'</h3><p>'.checkempty(ucfirst(alias($row['zone_alias'],'ec_zone','zone_alias','zone_name'))).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('State').'</h3><p>'.checkempty(ucfirst(alias($row['state_alias'],'ec_state','state_alias','state_name'))).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('District').'</h3><p>'.checkempty(ucfirst(alias($row['district_alias'],'ec_district','district_alias','district_name'))).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.strtoupper('Segment').'</h3><p>'.checkempty(ucfirst(alias($row['segment_alias'],'ec_segment','segment_alias','segment_name'))).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Customer').'</h3><p>'.checkempty(ucfirst(alias($row['customer_alias'],'ec_customer','customer_alias','customer_name'))).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Site Type').'</h3><p>'.checkempty(ucfirst(alias($row['site_type_alias'],'ec_site_type','site_type_alias','site_type'))).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.strtoupper('Site ID').'</h3><p>'.checkempty(ucfirst($row['site_id'])).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Site Name').'</h3><p>'.checkempty(ucfirst($row['site_name'])).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Product').'</h3><p>'.checkempty(ucfirst($product)).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.strtoupper('Mfd Date').'</h3><p>'.dateFormat(ucfirst($row['mfd_date']),'d').'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Install Date').'</h3><p>'.dateFormat(ucfirst($row['install_date']),'d').'</p></td>
							<td width="33.33%"><h3>'.strtoupper('No Of String').'</h3><p>'.checkempty(ucfirst($row['no_of_string'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.strtoupper('Technician Name').'</h3><p>'.checkempty(ucfirst($row['technician_name'])).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Technician Number').'</h3><p>'.checkempty(ucfirst($row['technician_number'])).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Manager Name').'</h3><p>'.checkempty(ucfirst($row['manager_name'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.strtoupper('Manager Number').'</h3><p>'.checkempty(ucfirst($row['manager_number'])).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Manager Mail').'</h3><p>'.checkempty(strtolower($row['manager_mail'])).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Site Address').'</h3><p>'.checkempty(ucfirst($row['site_address'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.strtoupper('Schedule').'</h3><p>'.ucfirst(($schedule=='0') ? "Zero" : $schedule).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Warrantyleft').'</h3><p>'.ucfirst($warrantyleft).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Warranty Months').'</h3><p>'.ucfirst($warrantymonths).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.strtoupper('Warranty Status').'</h3><p>'.ucfirst($warrantystatus).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Created Date').'</h3><p>'.dateFormat(ucfirst($row['created_date']),'d').'</p></td>
							<td width="33.33%"><h3></p></td>
						</tr>
					</table>';
					
		$print.='</td>
			</tr>
		</table></body></html>';
	}else{$print='<h2 style="text-align:center">No Records<h2>';}
	echo $print;
	echo "<script>window.print();</script>";
	echo "<script> window.history.back(); </script>";
?>