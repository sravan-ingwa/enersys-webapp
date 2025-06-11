<style>
html,body{width:100%;}
.table1{border-collapse:collapse;width:90%;height:995px;}
.td1{
	border:7px double #000;height:100%;width:90%;height:995px;vertical-align:top;
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
$heading = 'EMPLOYEE MASTER';
$query = mysqli_query($mr_con,"SELECT * FROM  ec_employee_master WHERE employee_alias='$alias'");
if(mysqli_num_rows($query)){
	$row = mysqli_fetch_array($query);
	$zons=explode(", ",$row['zone_alias']);
	foreach($zons as $zon){$aa.=alias($zon,'ec_zone','zone_alias','zone_name').", ";}
	$zone=trim($aa,", ");
	
	$stats=explode(", ",$row['state_alias']);
	foreach($stats as $stat){$bb.=alias($stat,'ec_state','state_alias','state_name').", ";}
	$state=trim($bb,", ");
	
	$wh=explode(", ",$row['wh_alias']);
	foreach($wh as $wh_alias){$whh.=alias($wh_alias,'ec_warehouse','wh_alias','wh_code').", ";}
	$warehouse=trim($whh,", ");
	
	$segs=explode(", ",$row['segment_alias']);
	foreach($segs as $seg){$dd.=alias($seg,'ec_segment','segment_alias','segment_name').", ";}
	$segment=trim($dd,", ");
	
	$custs=explode(", ",$row['customer_alias']);
	foreach($custs as $cust){$ee.=alias($cust,'ec_customer','customer_alias','customer_code').", ";}
	$customer=trim($ee,", ");
	
	$assets=explode(", ",$row['asset_alias']);
	foreach($assets as $ass){$cc.=alias($ass,'ec_assets','asset_alias','asset_name').", ";}
	$asset=trim($cc,", ");
	
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
						<td align="left"><h3>EMPLOYEE MASTER DETAILS</h3></td>
					</tr>
				</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Name</h3><p>'.checkempty($row['name']).'</p></td>
							<td width="33.33%"><h3>Employee ID</h3><p>'.checkempty($row['employee_id']).'</p></td>
							<td width="33.33%"><h3>Email ID</h3><p>'.checkempty(strtolower($row['email_id'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Mobile Number</h3><p>'.checkempty($row['mobile_number']).'</p></td>
							<td width="33.33%"><h3>Zone Name</h3><p>'.checkempty($zone).'</p></td>
							<td width="33.33%"><h3>Sitate Name</h3><p>'.checkempty($state).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Ware Code</h3><p>'.checkempty($warehouse).'</p></td>
							<td width="33.33%"><h3>Segment</h3><p>'.checkempty($segment).'</p></td>
							<td width="33.33%"><h3>Customer</h3><p>'.checkempty($customer).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Base Location</h3><p>'.checkempty($row['base_location']).'</p></td>
							<td width="33.33%"><h3>Designation</h3><p>'.checkempty(alias($row['designation_alias'],'ec_designation','designation_alias','designation')).'</p></td>
							<td width="33.33%"><h3>Department</h3><p>'.checkempty(alias($row['department_alias'],'ec_department','department_alias','department_name')).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Role Name</h3><p>'.checkempty(alias($row['role_alias'],'ec_emprole','role_alias','role_name')).'</p></td>
							<td width="33.33%"><h3>Esca Name</h3><p>'.checkempty(alias($row['esca_alias'],'ec_esca','esca_alias','esca_name')).'</p></td>
							<td width="33.33%"><h3>Privilege Name</h3><p>'.checkempty(alias($row['privilege_alias'],'ec_privileges','privilege_alias','privilege_name')).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Qualification</h3><p>'.checkempty($row['qualification']).'</p></td>
							<td width="33.33%"><h3>Specialization</h3><p>'.checkempty($row['specialization']).'</p></td>
							<td width="33.33%"><h3>Total Experience</h3><p>'.checkempty($row['total_experience']).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>El Experience</h3><p>'.el_experience($row['joining_date'], $row['relieving_date']).'</p></td>
							<td width="33.33%"><h3>Joining Date</h3><p>'.dateFormat($row['joining_date'],'d').'</p></td>
							<td width="33.33%"><h3>Relieving Date</h3><p>'.dateFormat($row['relieving_date'],'d').'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Asset Name</h3><p>'.checkempty($asset).'</p></td>
							<td width="33.33%"><h3>Status</h3><p>'.checkempty($row['status']).'</p></td>
							<td width="33.33%"><h3>Created Date</h3><p>'.dateFormat($row['created_date'],'d').'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>Device IMEI 1</h3><p>'.checkempty($row['device']).'</p></td>
							<td width="33.33%"><h3>Device IMEI 2</h3><p>'.checkempty($row['device_2']).'</p></td>
							<td width="33.33%"><h3>Cash card</h3><p>'.checkempty($row['cash_card']).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>THS Notified</h3><p>'.($row['ths_notified']==1 ? 'SHOW':'HIDE').'</p></td>
							<td width="33.33%"><h3>Profile Picture</h3><p><img src="'.baseurl().(!empty($row['profile_pic']) ? 'images/profile_pics/'.$row['profile_pic'] : 'images/gallery/profile_male').'" width="50" height="50"></p></td>
							<td width="33.33%">'.(!empty($row['noc']) ? '<h3>NOC</h3><p><a href="'.baseurl().'images/reports/'.$row['noc'].'">Click Here</a></p>' : '').'</td>
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