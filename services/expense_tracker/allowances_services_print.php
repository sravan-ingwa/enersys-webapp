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
.cont_2 h3{color:#428bca; margin-bottom:0px !important;}
.cont_2 p{font-size:10px; font-weight:300; margin-top:3px !important;}
.cont_3 h3{background-color:#428bca; color:#fff;}
.botable{border-collapse:collapse;font-size:12px;width:740px;}
.botable thead th{background:#2a6496; color:#FFF;padding:5px;}
.botable td, .botable th{border:1px solid #d1d1d1;padding:3px;}
.subhead td{padding:3px;text-align:center;}
</style>
<?php
include('../mysql.php');
include('../functions.php');
$ser_alias = $_REQUEST['alias'];
$heading = 'SERVICES ALLOWANCES';
$query = mysqli_query($mr_con,"SELECT *,(SELECT i.zone_name FROM ec_zone i WHERE i.zone_alias = s.zone_alias) AS zone_name, (SELECT t.state_name FROM ec_state t WHERE t.state_alias = s.state_alias) AS state_name,(SELECT d.district_name FROM ec_district d WHERE d.district_alias = s.district_alias) AS district_name,(SELECT d.area FROM ec_district d WHERE d.district_alias = s.district_alias) AS area FROM ec_service_allowances s WHERE s.service_allowance_alias='$ser_alias' AND s.flag=0");
if(mysqli_num_rows($query)){
	$row = mysqli_fetch_array($query);
	$print.='<html><body>
	<table class="table1">
		<tr>
			<td class="td1">
				<table class="tableHeader" width="100%">
					<tr>
						<td align="left" width="30%"><img src="../../images/gallery/logo1.png"></td>
						<td align="center" width="40%"><h2>'.$heading.'</h2></td>
						<td align="right" width="30%"><img src="../../images/gallery/logo-4.jpg" width="100px"></td>
					</tr>
				</table>
			<table class="cont_3">
				<tr>
					<td align="left"><h3>'.strtoupper("APPROVERS DETAILS").'</h3></td>
				</tr>
			</table>
				<table class="cont_2">
						<tr>
						<td width="33.33%"><h3>'.strtoupper('Zone').'</h3><p>'.checkempty(ucfirst($row['zone_name'])).'</p></td>
						<td width="33.33%"><h3>'.strtoupper('State').'</h3><p>'.checkempty(ucfirst($row['state_name'])).'</p></td>
						<td width="33.33%"><h3>'.strtoupper('District').'</h3><p>'.checkempty(ucfirst($row['district_name'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>';
						$area=alias($row['district_alias'],'ec_district','district_alias','area');
						if($area==0){$area_name="Plain Area";}else{$area_name="Hilly Area";}
							$print.='<td width="33.33%"><h3>'.strtoupper('Area').'</h3><p>'.$area_name.'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Lodging Amount').'</h3><p>'.checkempty($row['lodging_amount']).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Dially Allowances').'</h3><p>'.checkempty($row['daily_allowance']).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.strtoupper('Local Conveyance').'</h3><p>'.checkempty($row['local_conveyance']).'</p></td>
							<td width="33.33%"></td>
							<td width="33.33%"></td>
						</tr>
					</table>';
			$print.='</td>
			</tr>
		</table></body></html>';
	}else{$print='<h2 style="text-align:center">No Records<h2>';}
	echo $print;
	echo "<script>window.onload = function () {window.print();setTimeout(function(){window.close();}, 1);}</script>";
?>