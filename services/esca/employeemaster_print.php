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
$query = mysqli_query($mr_con,"SELECT * FROM  ec_employee_master WHERE employee_alias='$alias' AND flag='0'");
if(mysqli_num_rows($query)){
	$row = mysqli_fetch_array($query);
	$zons=explode(", ",$row['zone_alias']);
	foreach($zons as $zon){$aa.=alias($zon,'ec_zone','zone_alias','zone_name').", ";}
	$zone=trim($aa,", ");
	
	$stats=explode(", ",$row['zone_alias']);
	foreach($stats as $stat){$bb.=alias($stat,'ec_state','state_alias','state_name').", ";}
	$state=trim($bb,", ");
	
	$assets=explode(", ",$row['zone_alias']);
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
						<td align="left"><h3>'.strtoupper("EMPLOYEE MASTER DETAILS").'</h3></td>
					</tr>
				</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.strtoupper('Name').'</h3><p>'.checkempty(ucfirst($row['name'])).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Employee ID').'</h3><p>'.checkempty(ucfirst($row['employee_id'])).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Email ID').'</h3><p>'.checkempty(strtolower($row['email_id'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.strtoupper('Mobile Number').'</h3><p>'.checkempty(ucfirst($row['mobile_number'])).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Zone Name').'</h3><p>'.checkempty(ucfirst($zone)).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Sitate Name').'</h3><p>'.checkempty(ucfirst($state)).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.strtoupper('Base Location').'</h3><p>'.checkempty(ucfirst($row['base_location'])).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Designation').'</h3><p>'.checkempty(ucfirst(alias($row['designation_alias'],'ec_designation','designation_alias','designation'))).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Department').'</h3><p>'.checkempty(ucfirst(alias($row['department_alias'],'ec_department','department_alias','department_name'))).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.strtoupper('Role Name').'</h3><p>'.checkempty(ucfirst(alias($row['role_alias'],'ec_emprole','role_alias','role_name'))).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Esca Name').'</h3><p>'.checkempty(ucfirst(alias($row['esca_alias'],'ec_esca','esca_alias','esca_name'))).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Privilege Name').'</h3><p>'.checkempty(ucfirst(alias($row['privilege_alias'],'ec_privileges','privilege_alias','privilege_name'))).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.strtoupper('Qualification').'</h3><p>'.checkempty(ucfirst($row['qualification'])).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Specialization').'</h3><p>'.checkempty(ucfirst($row['specialization'])).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Total Experience').'</h3><p>'.checkempty(ucfirst($row['total_experience'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.strtoupper('El Experience').'</h3><p>'.el_experience($row['joining_date'], $row['relieving_date']).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Joining Date').'</h3><p>'.dateFormat(strtolower($row['joining_date']),'d').'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Relieving Date').'</h3><p>'.dateFormat(ucfirst($row['relieving_date']),'d').'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.strtoupper('Asset Name').'</h3><p>'.checkempty(ucfirst($asset)).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Status').'</h3><p>'.checkempty(ucfirst($row['status'])).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Created Date').'</h3><p>'.dateFormat(ucfirst($row['created_date']),'d').'</p></td>
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