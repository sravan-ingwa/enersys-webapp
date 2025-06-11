<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
include('../mpdf60/mpdf.php');
$stylesheet = file_get_contents('../../styles/pdf_style.css');

$getdata=dasboarddets($_REQUEST['alias']);
$message.="<table width='100%'><tr><td align='left' width='35%'><img src='../../images/gallery/logo1.png'></td>
						<td align='center' width='50%'><h2>Account Summery<h2></ td>
						<td align='right' width='35%'><img src='../../images/gallery/logo-4.jpg' width='100px'></td></tr></table><br>";
if($getdata!=0){
	foreach($getdata as $requ){
	$message.="<table width='100%' class='simp'>";
		$message.="<tr>";
			$message.="<td>";
				$message.="<h4>Employee Id</h4>";
				$message.="<p>".$requ['employee_id']."</p>";
			$message.="</td>";
			$message.="<td>";
				$message.="<h4>Employee Name</h4>";
				$message.="<p>".$requ['name']."</p>";
			$message.="</td>";
		$message.="</tr>";
		$message.="<tr>";
			$message.="<td>";
				$message.="<h4>Department</h4>";
				$message.="<p>".alias($requ['department_alias'],'ec_department','department_alias','department_name')."</p>";
			$message.="</td>";
			$message.="<td>";
				$message.="<h4>Designation</h4>";
				$message.="<p>".alias($requ['designation_alias'],'ec_designation','designation_alias','designation')."</p>";
			$message.="</td>";
		$message.="</tr>";
		$message.="<tr>";
			$message.="<td>";
				$message.="<h4>Grade</h4>";
				$message.="<p>".alias($requ['designation_alias'],'ec_designation','designation_alias','grade')."</p>";
			$message.="</td>";
			$message.="<td>";
				$message.="<h4>Credit Limit</h4>";
				$cr_limit = alias(employeeDetails('designation_alias',$requ['employee_alias']),'ec_expense_limits','designation_alias','limit_amount');
						if($cr_limit == ''){
							$credit_limit='0';
						}else{
							$credit_limit=$cr_limit;
						}
				$message.="<p>".$cr_limit."</p>";
			$message.="</td>";
		$message.="</tr>";
		$message.="<tr>";
			$message.="<td>";
				$message.="<h4>Total Advances</h4>";
				$message.="<p>".toatlAdvances($requ['employee_alias'])."</p>";
			$message.="</td>";
			$message.="<td>";
				$message.="<h4>Total Expenses</h4>";
				$message.="<p>".totalExpenses($requ['employee_alias'])."</p>";
			$message.="</td>";
		$message.="</tr>";
		$message.="<tr>";
			$message.="<td>";
				$message.="<h4>Total Reimbursement</h4>";
				$message.="<p>".totalReimbursement($requ['employee_alias'])."</p>";
			$message.="</td>";
			$message.="<td>";
				$message.="<h4>Total Balance</h4>";
				$message.="<p>".advanceNotSettled($requ['employee_alias'])."</p>";
			$message.="</td>";
		$message.="</tr>";

	$message.="</table>";
	}

	
	}else{$download='<h2 style="text-align:center">No Records<h2>';}
	$mpdf=new mPDF('','', 0, '', 5, 5, 5, 5, '', '2', '');
	$mpdf->SetHTMLFooter("<p style=\"text-align:right;font-style: italic;font-size:12px;\">{PAGENO}/{nbpg}</p>");
	$mpdf->pagenumPrefix = 'Page No : ';
	$mpdf->SetWatermarkImage('../../images/gallery/logo-3.png');
	$mpdf->showWatermarkImage = true;
	$mpdf->watermarkImageAlpha = 0.06;
	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($message,2);
	$filename='Advancesdetails_'.date('d-m-Y_H_i_s');
	$mpdf->Output("$filename.pdf", "I");
	exit;

function dasboarddets($fv1){ global $mr_con;
	$rec=mysqli_query($mr_con,"SELECT name, employee_id, employee_alias, department_alias, designation_alias FROM ec_employee_master WHERE $condition employee_alias='$fv1' AND flag=0");
	if(mysqli_num_rows($rec)>0){while($row = mysqli_fetch_array($rec)){$result[]=array('employee_alias'=>$row['employee_alias'],'name'=>$row['name'],'employee_id'=>$row['employee_id'],'department_alias'=>$row['department_alias'],'designation_alias'=>$row['designation_alias']);} return $result;}else return 0;
}
?>
	
	
