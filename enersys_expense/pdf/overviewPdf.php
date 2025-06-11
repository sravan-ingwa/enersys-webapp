<?php
date_default_timezone_set("Asia/Kolkata");
include('../db.php');
getDB();
include('pdfinclude/mpdf.php');
include('../functions.php');
$mpdf=new mPDF();
if(isset($_REQUEST['ref'])){
$getdata=dasboarddets($_REQUEST['ref']);
$message="<table width='100%'><tr><td align='right'><h3>EnerSys India Batteries Pvt. Ltd.</h3></td></tr></table><br><br>";
$message.="<table width='100%'><tr><td><h3>Account Summary</h3></td></tr></table><br>";
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
				$message.="<p>".alias($requ['designation_alias'],'ec_expense_limits','designation_alias','limit_amount')."</p>";
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
				$message.="<h4>Total Balance</h4>";
				$message.="<p>".advanceNotSettled($requ['employee_alias'])."</p>";
			$message.="</td>";
		$message.="</tr>";
	$message.="</table>";
	}
}
	$stylesheet = file_get_contents('css/mpdf.css'); // external css
	$mpdf->SetHTMLHeader("<div style='text-align: left;'><img src='EnerSys_logo.png' alt='EnerSys_logo' width='150'></div>");
	//$mpdf->SetWatermarkText("EnerSys");
	//$mpdf->showWatermarkText = true;
	$mpdf->SetWatermarkImage('EnerSys_logo.png');
	$mpdf->showWatermarkImage = true;
	$mpdf->watermarkImageAlpha = 0.05;
	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($message,2);
	$mpdf->Output();
	//$mpdf->Output('Expence_'.date('Y-m-d_H:i:s').'.pdf', 'D');
	exit;
}
function dasboarddets($fv1){
	$rec=mysql_query("SELECT name, employee_id, employee_alias, department_alias, designation_alias FROM ec_employee_master WHERE $condition employee_alias='$fv1' AND flag=0");
	if(mysql_num_rows($rec)>0){while($row = mysql_fetch_array($rec)){$result[]=array('employee_alias'=>$row['employee_alias'],'name'=>$row['name'],'employee_id'=>$row['employee_id'],'department_alias'=>$row['department_alias'],'designation_alias'=>$row['designation_alias']);} return $result;}else return 0;
}
?>