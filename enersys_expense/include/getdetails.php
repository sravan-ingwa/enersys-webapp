<?php
session_start();
include('../functions.php');
function bglevel($fv1){
		if($fv1=='1' || $fv1=='2'|| $fv1=='3'|| $fv1=='4') return 'orangeac';
		if($fv1=='5' || $fv1=='6') return 'greenac';
		if($fv1=='7') return 'redac';
} 
if($_REQUEST['ref'] =="viewadvance"){
	$pageNo=$_REQUEST['pageNo'];
	$requestID=$_REQUEST['requestID'];
	$requestDate=$_REQUEST['requestDate'];
	$requestamt=$_REQUEST['requestamt'];
	$reqStat=$_REQUEST['reqStat'];
	$empname=$_REQUEST['empname'];
	$getdata=getfulladvancelist($pageNo,$requestID,$requestDate,$requestamt,$reqStat,$_SESSION['ec_user_alias'],$empname);
	//echo $getdata;
	if($getdata!=0){
	foreach($getdata as $requ){
		$message.="<tr class='magic'>";
		$message.="<td>".$requ['request_id']."</td>";
		if($requ['activa']==1 || checkspldep($_SESSION['ec_user_alias'])==1 || checkspldep($_SESSION['ec_user_alias'])==2)$message.="<td>".employeeDetails('name',$requ['employee_alias'])."</td>";
		$message.="<td>".$requ['requested_date']."</td>";
		$message.="<td>".$requ['request_amount']."</td>";
		$message.="<td class='".bglevel($requ['approval_level1'])."' >".$requ['approval_level']."</td>";
		$message.="<td class='actionIcons'>";
			$message.="<a href='".$requ['alias']."' data-type='detailadvance' class='edis' title='Full Details'><i class='glyphicon glyphicon-eye-open'></i></a>&nbsp;";
			$message.="<a href='pdf/advancePdf.php?ref=".$requ['alias']."' target='_blank' title='Download'><i class='glyphicon glyphicon-save'></i></a>&nbsp;";
			if(($_SESSION['ec_user_alias']==$requ['employee_alias']) && $requ['approval_level1']==0) $message.="<a  href='".$requ['alias']."' class='edis' data-type='editAdvance' title='Request'><i class='glyphicon glyphicon-edit'></i></a>&nbsp;";
			if(chouldshow($_SESSION['ec_user_alias'],$requ['approval_level1'])==1) $message.="<a href='".$requ['alias']."' class='edis' data-type='editAdvance' title='Approvals'><i class='glyphicon glyphicon-edit'></i></a>&nbsp;";
			if($requ['approval_level1']=="0")$message.="<a href='".$requ['alias']."' class='deletelist' data-type='viewadvance' title='Delete Advance'><i class='glyphicon glyphicon-trash'></i></a>";
			$message.="</td>";
		$message.="</tr>";
		$pageNo=$requ['pagenumber'];
		$totalpages=$requ['totalpages'];
	}
	for($x=1;$x<=$totalpages;$x++){$op.="<option value='".$x."' ".chx($x,$pageNo).">Page ".$x."</option>";}
	$message.="<tr><td colspan='6' align='center'><select name='pageNo' onchange='listdetailsfun()'>$op</select></td><tr>";
	}else $message="<tr><td colspan='6' align='center'>No Records found</td></tr>";
	
	echo $message;
}
if($_REQUEST['ref'] =="viewExpense"){
	$pageNo=$_REQUEST['pageNo'];
	$bill_no=$_REQUEST['bill_number'];
	$requestDate=$_REQUEST['requestDate'];
	$totalExpense=$_REQUEST['totalExpense'];
	$outbal=$_REQUEST['outbal'];
	$placeofVisit=$_REQUEST['placeofVisit'];
	$reqStat=$_REQUEST['reqStat'];
	$empname=$_REQUEST['empname'];
	$getdata=getfullexpenselist($pageNo,$bill_no,$requestDate,$totalExpense,$outbal,$placeofVisit,$reqStat,$_SESSION['ec_user_alias'],$empname);
	if($getdata!=0){
	foreach($getdata as $requ){
		
		if(checkspldep($requ['employee_alias'])=='3'){
			if(getRoleStat(employeeDetails('role_alias',$requ['employee_alias'])) == 0){
				$data_type_detail = 'serDetailexpense';
				$data_type_edit = 'serEditExpense';	
				$pdf_page = 'serexpensePdf';	
			} else {
				$data_type_detail = 'detailexpense';
				$data_type_edit = 'editExpense';	
				$pdf_page = 'expensePdf';	
			}
		} else {
			$data_type_detail = 'detailexpense';
			$data_type_edit = 'editExpense';
			$pdf_page = 'expensePdf';
		}
		
		$message.="<tr class='magic'>";
		$message.="<td>".$requ['bill_number']."</td>";
		if(checkApproval($_SESSION['ec_user_alias'])==1 || checkspldep($_SESSION['ec_user_alias'])==1 || checkspldep($_SESSION['ec_user_alias'])==2)
		$message.="<td>".employeeDetails('name',$requ['employee_alias'])."</td>";
		$message.="<td>".$requ['requested_date']."</td>";
		$message.="<td>".$requ['total_tour_expenses']."</td>";
		$message.="<td>".$requ['outbal']."</td>";
		$message.="<td>".$requ['places_of_visit']."</td>";
		$message.="<td class='".bglevel($requ['approval_level1'])."' >".$requ['approval_level']."</td>";
		$message.="<td class='actionIcons'>";
		$message.="<a href='".$requ['alias']."' data-type='".$data_type_detail."' class='edis' title='Full Details'><i class='glyphicon glyphicon-eye-open'></i></a>&nbsp;";
		$message.="<a href='pdf/".$pdf_page.".php?ref=".$requ['alias']."' target='_blank' title='Download'><i class='glyphicon glyphicon-save'></i></a>&nbsp;";
		if(($_SESSION['ec_user_alias']==$requ['employee_alias']) && ($requ['approval_level1']==0 || $requ['approval_level1']==8)) 
		$message.="<a  href='".$requ['alias']."' class='edis' data-type='".$data_type_edit."' title='Request'>
		<i class='glyphicon glyphicon-edit'></i></a>&nbsp;";
			if(chouldshow($_SESSION['ec_user_alias'],$requ['approval_level1'])==1) $message.="<a href='".$requ['alias']."' class='edis' data-type='".$data_type_edit."' title='Approvals'><i class='glyphicon glyphicon-edit'></i></a>&nbsp;";
			if(financeemp($_SESSION['ec_user_alias'])=='2' && $requ['approval_level1']=='6' && $requ['utr_num']=='0') $message.="<a href='".$requ['alias']."' class='edis' data-type='".$data_type_edit."' title='Approvals'><i class='glyphicon glyphicon-edit'></i></a>&nbsp;";
			if($requ['approval_level1']=="0")$message.="<a href='".$requ['alias']."' class='deletelist' data-type='viewExpense' title='Delete Expense'><i class='glyphicon glyphicon-trash'></i></a>";
			$message.="</td>";
		$message.="</tr>";
		$pageNo=$requ['pagenumber'];
		$totalpages=$requ['totalpages'];
	}
	for($x=1;$x<=$totalpages;$x++){$op.="<option value='' style='display:none;'>Page 1</option><option value='".$x."' ".chx($x,$pageNo).">Page ".$x."</option>";}
	$message.="<tr><td colspan='8' align='center'><select name='pageNo' onchange='listdetailsfun()'>$op</select></td><tr>";
	}else $message="<tr><td colspan='8' align='center'>No Records found</td></tr>";
	
	echo $message;
}

if($_REQUEST['ref'] =="dashboard"){
	$pageNo=$_REQUEST['pageNo'];
	$emp_id=$_REQUEST['emp_id'];
	$emp_name=$_REQUEST['emp_name'];
	$dep=$_REQUEST['dep'];
	$toal_advances=$_REQUEST['toal_advances'];
	$total_expenses=$_REQUEST['total_expenses'];
	$avl_balance=$_REQUEST['avl_balance'];
	$getdata=dasboarddet($pageNo,$emp_id,$emp_name,$dep,$toal_advances,$total_expenses,$avl_balance,$_SESSION['ec_user_alias']);
	if($getdata!=0){$message="";
		if(checkApproval($_SESSION['ec_user_alias'])==1){
			foreach($getdata as $requ){
				$message.="<tr class='magic'>";
				$message.="<td>".$requ['employee_id']."</td>";
				$message.="<td>".$requ['name']."</td>";
				$message.="<td>".alias($requ['department_alias'],'ec_department','department_alias','department_name')."</td>";
				$message.="<td>".toatlAdvances($requ['employee_alias'])."</td>";
				$message.="<td>".totalExpenses($requ['employee_alias'])."</td>";
				$message.="<td>".advanceNotSettled($requ['employee_alias'])."</td>";
				$message.="<td class='actionIcons'>";
					$message.="<a href='".$requ['employee_alias']."' data-type='detailemp' class='edis' title='Full Details'><i class='glyphicon glyphicon-eye-open'></i></a>&nbsp;";
					$message.="<a href='pdf/overviewPdf.php?ref=".$requ['employee_alias']."' target='_blank' title='Download'><i class='glyphicon glyphicon-save'></i></a>&nbsp;";
				$message.="</td>";
				$message.="</tr>";
				$pageNo=$requ['pagenumber'];
				$totalpages=$requ['totalpages'];
			}
			for($x=1;$x<=$totalpages;$x++){$op.="<option value='".$x."' ".chx($x,$pageNo).">Page ".$x."</option>";}
			$message.="<tr><td colspan='7' align='center'><select name='pageNo' onchange='listdetailsfun()'>$op</select></td><tr>";
		}else{
			foreach($getdata as $requ){
				$message.="<div class='row'>";
					$message.="<div class='col-md-10 col-md-offset-1'>";
						$message.="<div class='col-md-5 bs-callout'>";
							$message.="<h4>Employee Id</h4>";
							$message.="<p>".$requ['employee_id']."</p>";
						$message.="</div>";
						$message.="<div class='col-md-5 bs-callout'>";
							$message.="<h4>Employee Name</h4>";
							$message.="<p>".$requ['name']."</p>";
						$message.="</div>";
						$message.="<div class='col-md-5 bs-callout'>";
							$message.="<h4>Department</h4>";
							$message.="<p>".alias($requ['department_alias'],'ec_department','department_alias','department_name')."</p>";
						$message.="</div>";
						$message.="<div class='col-md-5 bs-callout'>";
							$message.="<h4>Designation</h4>";
							$message.="<p>".alias(employeeDetails('designation_alias',$requ['employee_alias']),'ec_designation','designation_alias','designation')."</p>";
						$message.="</div>";
						$message.="<div class='col-md-5 bs-callout'>";
							$message.="<h4>Grade</h4>";
							$message.="<p>".alias(employeeDetails('designation_alias',$requ['employee_alias']),'ec_designation','designation_alias','grade')."</p>";
						$message.="</div>";
						$message.="<div class='col-md-5 bs-callout'>";
							$message.="<h4>Credit Limit</h4>";
							$message.="<p>".alias(employeeDetails('designation_alias',$requ['employee_alias']),'ec_expense_limits','designation_alias','limit_amount')."</p>";
						$message.="</div>";
						$message.="<div class='col-md-5 bs-callout'>";
							$message.="<h4>Total Advances</h4>";
							$message.="<p>".toatlAdvances($requ['employee_alias'])."</p>";
						$message.="</div>";
						$message.="<div class='col-md-5 bs-callout'>";
							$message.="<h4>Total Expenses</h4>";
							$message.="<p>".totalExpenses($requ['employee_alias'])."</p>";
						$message.="</div>";
						$message.="<div class='col-md-5 bs-callout'>";
							$message.="<h4>Total Outstanding Balance</h4>";
							$message.="<p>".advanceNotSettled($requ['employee_alias'])."</p>";
						$message.="</div>";
					$message.="</div>";
				$message.="</div>";
			}
		 }
	}else $message="<tr><td colspan='7' align='center'>No Records found</td></tr>";
	echo $message;
}
if($_REQUEST['ref'] =="detailemp"){
	$pageNo=$_REQUEST['pageNo'];
	$idd=$_REQUEST['id'];
	$requestID=$_REQUEST['requestID'];
	$requestDate=$_REQUEST['requestDate'];
	$requestamt=$_REQUEST['requestamt'];
	$reqStat=$_REQUEST['reqStat'];
	$reqtype=$_REQUEST['reqtype'];
	
	$getdata=getalltransactions($reqtype,$pageNo,$idd,$requestID,$requestDate,$requestamt,$reqStat,$_SESSION['ec_user_alias']);
	if($getdata!=0){
	foreach($getdata as $requ){
		$message.="<tr class='magic'>";
		$message.="<td>".requesttype($requ['requestId'],$requ['alias'])."</td>";
		$message.="<td>".$requ['requestId']."</td>";
		$message.="<td>".$requ['rd']."</td>";
		$message.="<td>".$requ['amt']."</td>";
		$message.="<td>".$requ['tamt']."</td>";
		$message.="<td class='".bglevel($requ['al'])."'>".exlevelsName($requ['al'])."</td>";
		$message.="<td class='actionIcons'>";
			$message.="<a href='".$requ['alias']."' data-type='detail".requesttype($requ['requestId'],$requ['alias'])."' class='edis' title='Full Details'><i class='glyphicon glyphicon-eye-open'></i></a>&nbsp;";

			$message.="<a href='pdf/".requesttype($requ['requestId'],$requ['alias'])."Pdf.php?ref=".$requ['alias']."' target='_blank' title='Download'><i class='glyphicon glyphicon-save'></i></a>&nbsp;";

			if(($_SESSION['ec_user_alias']==$requ['employee_alias']) && $requ['approval_level1']==0) $message.="<a  href='".$requ['alias']."' class='edis' data-type='editAdvance' title='Request'><i class='glyphicon glyphicon-edit'></i></a>";
			if(chouldshow($_SESSION['ec_user_alias'],$requ['approval_level1'])==1)$message.="<a href='".$requ['alias']."' class='edis' data-type='editAdvance' title='Approvals'><i class='glyphicon glyphicon-edit'></i></a>";
		$message.="</td>";
		$message.="</tr>";
		$pageNo=$requ['pagenumber'];
		$totalpages=$requ['totalpages'];
	}
	/*for($x=1;$x<=$totalpages;$x++){$op.="<option value='".$x."' ".chx($x,$pageNo).">Page ".$x."</option>";}
	$message.="<tr><td colspan='6' align='center'><select name='pageNo' onchange='listdetailsfun()'>$op</select></td><tr>";*/
	}else $message="<tr><td colspan='6' align='center'>No Records found</td></tr>";
	
	echo $message;
}
function chx($x,$pageNo){if($x==$pageNo)return "selected";}
function chouldshow($fv1,$fv2){
	$q=approvelvl($fv1);
	if($q!=0){
		switch ($fv2){
			case '1': $level=1;break;
			case '2': $level=4;break;
			case '3': $level=2;break;
			case '4': $level=3;break;
			case '5': $level=5;break;
			default: $level=0;break;
		}
		if(in_array($level, $q)){return 1;
		}else return 0;
	}else return 0;
}
function financeemp($fv1){
	include('../mysql.php');
	$fv1=alias($fv1,'ec_employee_master','employee_alias','department_alias');
	$rec=$mr_con->query("SELECT spl FROM ec_department WHERE department_alias='$fv1' AND flag=0");
	if($rec->num_rows > 0){
		$row = $rec->fetch_assoc();
		if($row['spl'] =='2') return $row['spl']; else return 0;
	}else return 0;
}
?>
