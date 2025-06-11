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
.botable td, .botable th{border:1px solid #d1d1d1;padding:3px;}
.subhead td{padding:3px;text-align:center;}
</style>
<?php
include('../mysql.php');
include('../functions.php');
$alias = $_REQUEST['alias'];
$heading = 'CHANGE LOG';
$query = mysqli_query($mr_con,"SELECT change_logName FROM ec_app_change_log WHERE log_alias='$alias' AND ref_id='0' AND flag='0'");
if(mysqli_num_rows($query)){
	$row = mysqli_fetch_array($query);
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
						<td align="left"><h3>CHANGE LOG DETAILS</h3></td>
					</tr>
				</table><br>
					<table class="cont_2">
						<tr><td><h3>Version : '.$row['change_logName'].'</h3></td></tr>
					</table>
					<table class="cont_2">';
						$query1 = mysqli_query($mr_con,"SELECT change_logName FROM ec_app_change_log WHERE ref_id='$alias' AND flag='0'");
						if(mysqli_num_rows($query1)){
							$i=1;while($row1 = mysqli_fetch_array($query1)){
								$print.='<tr><td style="padding:5px;">'.$i.". ".checkempty(ucfirst($row1['change_logName'])).'</td></tr>';
								$i++;
							}
						}
						else '<tr><td><h2 style="text-align:center">No Records</h2></td></tr>';
			$print.='</table>
				</td>
			</tr>
		</table></body></html>';
	}else{$print='<h2 style="text-align:center">No Records</h2>';}
	echo $print;
	echo "<script>window.print();</script>";
	echo "<script> window.history.back(); </script>";
?>