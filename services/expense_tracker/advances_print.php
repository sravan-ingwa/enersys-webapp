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
.alinC{text-align:center;}
</style>
<?php
include('../mysql.php');
include('../functions.php');
$alias = $_REQUEST['alias'];
$heading = 'Acknowledgement for Advance';
$query = mysqli_query($mr_con,"SELECT * FROM  ec_advances WHERE advance_alias='$alias' AND flag='0'");
if(mysqli_num_rows($query)){
	$row = mysqli_fetch_array($query);
	$dept_name=checkspldep($row['employee_alias']);
	$print.='<html><body>
	<table class="table1">
		<tr>
			<td class="td1">
				<table class="tableHeader" width="100%">
					<tr>
						<td align="left" width="30%"><img src="../../images/gallery/logo1.png"></td>
						<td align="center" width="40%"><h3>'.$heading.'</h3></td>
						<td align="right" width="30%"><img src="../../images/gallery/logo-4.jpg" width="100px"></td>
					</tr>
				</table>
			<table class="cont_3">
				<tr>
					<td align="left"><h3>'.strtoupper("ADVANCES DETAILS").'</h3></td>
				</tr>
			</table>
				<table class="cont_2">
						<tr>
						<td width="33.33%"><h3>'.strtoupper('Request ID').'</h3><p>'.checkempty(ucfirst($row['request_id'])).'</p></td>
						<td width="33.33%"><h3>'.strtoupper('Request Date').'</h3><p>'.checkempty(ucfirst($row['requested_date'])).'</p></td>
						<td width="33.33%"><h3>'.strtoupper('Employee Id').'</h3><p>'.checkempty(ucfirst(strtolower(alias_flag_none($row['employee_alias'],'ec_employee_master','employee_alias','employee_Id')))).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.strtoupper('Employee Name').'</h3><p>'.checkempty(ucfirst(strtolower(alias_flag_none($row['employee_alias'],'ec_employee_master','employee_alias','name')))).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Department').'</h3><p>'.checkempty(ucfirst(strtolower(alias_flag_none(alias_flag_none($row['employee_alias'],'ec_employee_master','employee_alias','department_alias'),'ec_department','department_alias','department_name')))).'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Designation').'</h3><p>'.checkempty(ucfirst(strtolower(alias_flag_none(alias_flag_none($row['employee_alias'],'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','designation')))).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.strtoupper('Grade').'</h3><p>'.checkempty(ucfirst(alias_flag_none(employeeDetails('designation_alias',$row['employee_alias']),'ec_designation','designation_alias','grade'))).'</p></td>';
							
							if(advanceNotSettled($row['employee_alias'])!=0){$prev=advanceNotSettled($row['employee_alias']);} else { $prev="No pending Advances";}
							
							$print.='<td width="33.33%"><h3>'.strtoupper('Previous Advance Not Settled').'</h3><p>'.$prev.'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Request Amount').'</h3><p>'.checkempty(ucfirst($row['request_amount'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.strtoupper('Available Amount').'</h3><p>'.checkempty(ucfirst($row['total_amount'])).'</p></td>';
							
							
							//if($dept_name!='3' && $row['report']!="" || $row['report']!='0'){
								//$print.='<td width="33.33%"><h3>'.strtoupper('Tour Planning Report').'</h3><p><a href="'.baseurl().checkempty(ucfirst($row['report'])).'" target="_blank">Click Here</a></p></td>';
							//}else{
								//$print.='<td width="33.33%"></td>';
							//}
							$print.='<td width="33.33%"></td>
							</tr>
							</table>
						<table class="cont_2">';
						$remquery=mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE item_alias='$alias' AND flag=0");
						$count = mysqli_num_rows($remquery);
							if($count>0){
							$i=3;while($remrow=mysqli_fetch_array($remquery)){
							if($i%3==0){$print.='<tr>';}	
							$print.='<td><h3>'.strtoupper('Remarks').'</h3><p>'.checkempty(ucfirst(strtolower($remrow['remarks']))).'</p></td>';	
							
							if($i%3 == 2 || $count+2 == $i ){$print.='</tr>'; } $i++; }}
						
					$print.='</table>';
					
					
					$print.="<br><br><table style='padding-left:10px; line-height:1.5;'><tr><td>(".alias_flag_none($row['employee_alias'],'ec_employee_master','employee_alias','name').")<br><b>Signature of client</b><br>Date : ".dat($row['requested_date']);
					$print.='</td></tr></table>';
						
				
					if($row['approved_by']!=""){
					$hsf = explode("|",$row['approved_by']);
					$hsfDate = explode("|",$row['approved_date']);
					$endexp = end($hsf);
					$endate = end($hsfDate);
					$sw=employeeDetails('name',$endexp);
					$ad=dat($endate);
					if($sw=='0'){
						$av=$hsf[count($hsf)-2];
						$sv=$hsfDate[count($hsfDate)-2];
						$ss=employeeDetails('name',$av);
						$sd=dat($sv);
					}else{$ss=employeeDetails('name',$endexp);$sd=dat($endate);}
					
					$print .=	'<table class="cont_2"><tr>';
					$print .=	"<td class='alinC' style='font-size:12px'>
							(".$ss.")<br>Date : ".$sd."
							</td>";
					$print.="</tr></table>";
				}
				
				
					
		$print.='</td>
			</tr>
		</table></body></html>';
	}else{$print='<h2 style="text-align:center">No Records<h2>';}
	echo $print;
	echo "<script>window.onload = function () {window.print();setTimeout(function(){window.close();}, 1);}</script>";
?>