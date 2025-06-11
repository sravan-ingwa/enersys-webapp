<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
include('../mpdf60/mpdf.php');
$stylesheet = file_get_contents('../../styles/pdf_style.css');
$alias = $_REQUEST['alias'];
$heading = 'Acknowledgement for Advance';
$query = mysqli_query($mr_con,"SELECT * FROM  ec_advances WHERE advance_alias='$alias' AND flag='0'");
if(mysqli_num_rows($query)){
	$row = mysqli_fetch_array($query);
	$dept_name=checkspldep($row['employee_alias']);
	$download='<html><body>
	<table class="table1">
		<tr>
			<td class="td1">
				<table class="tableHeader" width="100%">
					<tr>
						<td align="left" width="35%"><img src="../../images/gallery/logo1.png"></td>
						<td align="center" width="50%"><h3>'.$heading.'</h3></ td>
						<td align="right" width="35%"><img src="../../images/gallery/logo-4.jpg" width="100px"></td>
					</tr>
				</table>
				<table class="cont_3">
					<tr>
						<td align="left">'.strtoupper("ADVANCES DETAILS").'</td>
					</tr>
				</table>
					<table class="cont_2">
						<tr>
						<td width="33.33%"><h3>'.strtoupper('Request ID').'</h3><p>'.checkempty(ucfirst(strtolower($row['request_id']))).'</p></td>
						<td width="33.33%"><h3>'.strtoupper('Request Date').'</h3><p>'.checkempty(ucfirst(strtolower($row['requested_date']))).'</p></td>
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
							
							$download.='<td width="33.33%"><h3>'.strtoupper('Previous Advance Not Settled').'</h3><p>'.$prev.'</p></td>
							<td width="33.33%"><h3>'.strtoupper('Request Amount').'</h3><p>'.checkempty(ucfirst($row['request_amount'])).'</p></td>
						</tr>
					</table>
					<table class="cont_2">
						<tr>
							<td width="33.33%"><h3>'.strtoupper('Available Amount').'</h3><p>'.checkempty(ucfirst($row['total_amount'])).'</p></td>';
							if($dept_name!='3' && $row['report']!="" && $row['report']!='0'){
								$download.='<td width="33.33%"><h3>'.strtoupper('Tour Planning Report').'</h3><p><a href="'.baseurl().$row['report'].'" target="_blank">Click Here</a></p></td>';
							}else{
								$download.='<td width="33.33%"></td>';
							}
							$download.='<td width="33.33%"></td>';
						$download.='</tr>
					</table>
					<table class="cont_2">';
						$remquery=mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE item_alias='$alias' AND flag=0");
						$count = mysqli_num_rows($remquery);
							if($count>0){
							$i=3;while($remrow=mysqli_fetch_array($remquery)){
							if($i%3==0){$download.='<tr>';}	
							$download.='<td><h3>'.strtoupper('Remarks').'</h3><p>'.checkempty(ucfirst(strtolower($remrow['remarks']))).'</p></td>';	
							
							if($i%3 == 2 || $count+2 == $i ){$download.='</tr>'; } $i++; }}
						
					$download.='</table>';
					
					$download.="<br><br><table style='padding-left:10px; line-height:1.5;'><tr><td>(".alias_flag_none($row['employee_alias'],'ec_employee_master','employee_alias','name').")<br><b>Signature of client</b><br>Date : ".dat($row['requested_date']);
					$download.='</td></tr></table>';
			
						
					if($row['approved_by']!=""){
					$hsf = explode("|",$row['approved_by']); 
					$hsfDate = explode("|",$row['approved_date']);
					$download .= '<table class="cont_2"><tr>';
					for($i=0;$i<count($hsf);$i++){
						$ss=employeeDetails('name',$hsf[$i]);
						if($ss!='' || $ss!='0'){
					$download .= "<td class='alinC' style='font-size:12px'>
							(".$ss.")<br>Date : ".dat($hsfDate[$i])."
							</td>";}}
					
					$download.="</tr></table>";
					}	
			
		$download.='</td></tr>
	</table></body></html>';
	}else{$download='<h2 style="text-align:center">No Records<h2>';}
	$mpdf=new mPDF('','', 0, '', 5, 5, 5, 5, '', '2', '');
	$mpdf->SetHTMLFooter("<p style=\"text-align:center;font-style: italic;font-size:12px;\">{PAGENO}/{nbpg}</p>");
	$mpdf->pagenumPrefix = 'Page No : ';
	$mpdf->SetWatermarkImage('../../images/gallery/logo-3.png');
	$mpdf->showWatermarkImage = true;
	$mpdf->watermarkImageAlpha = 0.06;
	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($download,2);
	$filename='Advancesdetails_'.date('d-m-Y_H_i_s');
	$mpdf->Output("$filename.pdf", "I");
	exit;
?>