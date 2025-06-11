<?php
session_start();
include('../functions.php');
function bglevel($fv1){
		if($fv1=='1' || $fv1=='2'|| $fv1=='3'|| $fv1=='4') return 'orangeac';
		if($fv1=='5' || $fv1=='6') return 'greenac';
		if($fv1=='7') return 'redac';
} 
if($_REQUEST['ref'] =="listemployee"){
	$pageNo=$_REQUEST['pageNo'];
	$empid=$_REQUEST['empid'];
	$empname=$_REQUEST['empname'];
	$dep=$_REQUEST['dep'];
	$des=$_REQUEST['des'];
	$getdata=getfullemplist($pageNo,$empid,$empname,$dep,$des);
	if($getdata!=0){
		foreach($getdata as $requ){
			$message.="<tr class='magic'>";
			$message.="<td>".$requ['empid']."</td>";
			$message.="<td>".$requ['empname']."</td>";
			$message.="<td>".departnment($requ['dep'])."</td>";
			$message.="<td>".designation($requ['des'])."</td>";
			$message.="<td>". grade($requ['employee_alias'])."</td>";
			$message.="<td class='actionIcons'>";
			$message.="<a href='".$requ['employee_alias']."' data-type='viewemployee' class='edis' title='Full Details'><i class='glyphicon glyphicon-eye-open'></i></a>&nbsp;";
			$message.="<a href='".$requ['employee_alias']."' class='edis' data-type='editemployee' title='Edit'><i class='glyphicon glyphicon-edit'></i></a>";
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
if($_REQUEST['ref'] == "listallowances"){
	$getdata=getfullallowanceslist();
	if($getdata!=0){
		foreach($getdata as $requ){
			$message.="<tr class='magic'>";
			$message.="<td>".$requ['grade']."</td>";
			$message.="<td>".$requ['lodging_allowances_a1']."</td>";
			$message.="<td>".$requ['lodging_allowances_a']."</td>";
			$message.="<td>".$requ['lodging_allowances_b']."</td>";
			$message.="<td>".$requ['lodging_allowances_c']."</td>";
			$message.="<td>".$requ['boarding_allowances_a1']."</td>";
			$message.="<td>".$requ['boarding_allowances_a']."</td>";
			$message.="<td>".$requ['boarding_allowances_b']."</td>";
			$message.="<td>".$requ['boarding_allowances_c']."</td>";
			$message.="<td>".$requ['mode_of_travel']."</td>";
			$message.="<td>".$requ['mode_of_conveyance']."</td>";
			$message.="<td>".$requ['mobile_roaming']."</td>";
			$message.="<td class='actionIcons'>";
			$message.="<a href='".$requ['allowance_alias']."' class='edis' data-type='editallowances' title='Edit'><i class='glyphicon glyphicon-edit'></i></a>";
			$message.="</td>";
			$message.="</tr>";
		}
	}else $message="<tr><td colspan='13' align='center'>No Records found</td></tr>";
	echo $message;
}
if($_REQUEST['ref'] =="viewadvance"){
	$pageNo=$_REQUEST['pageNo'];
	$requestID=$_REQUEST['requestID'];
	$requestDate=$_REQUEST['requestDate'];
	$requestamt=$_REQUEST['requestamt'];
	$reqStat=$_REQUEST['reqStat'];
	$empname=$_REQUEST['empname'];
	$getdata=getfulladvancelist($pageNo,$requestID,$requestDate,$requestamt,$reqStat,$empname);
	//echo $getdata;
	if($getdata!=0){
	foreach($getdata as $requ){
		$message.="<tr class='magic'>";
		$message.="<td>".$requ['request_id']."</td>";
		$message.="<td>".employeeDetails('name',$requ['employee_alias'])."</td>";
		$message.="<td>".$requ['requested_date']."</td>";
		$message.="<td>".$requ['request_amount']."</td>";
		$message.="<td class='".bglevel($requ['approval_level1'])."' >".$requ['approval_level']."</td>";
		$message.="<td class='actionIcons'>";
			$message.="<a href='".$requ['alias']."' data-type='detailadvance' class='edis' title='Full Details'><i class='glyphicon glyphicon-eye-open'></i></a>&nbsp;";
			$message.="<a href='../pdf/advancePdf.php?ref=".$requ['alias']."' target='_blank' title='Download'><i class='glyphicon glyphicon-save'></i></a>&nbsp;";
			$message.="<a  href='".$requ['alias']."' class='edis' data-type='editAdvance' title='Edit'><i class='glyphicon glyphicon-edit'></i></a>&nbsp;";
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
	$getdata=getfullexpenselist($pageNo,$bill_no,$requestDate,$totalExpense,$outbal,$placeofVisit,$reqStat,$empname);
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
		$message.="<td>".employeeDetails('name',$requ['employee_alias'])."</td>";
		$message.="<td>".$requ['requested_date']."</td>";
		$message.="<td>".$requ['total_tour_expenses']."</td>";
		$message.="<td>".$requ['outbal']."</td>";
		$message.="<td>".$requ['places_of_visit']."</td>";
		$message.="<td class='".bglevel($requ['approval_level1'])."' >".$requ['approval_level']."</td>";
		$message.="<td class='actionIcons'>";
			$message.="<a href='".$requ['alias']."' data-type='".$data_type_detail."' data-toggle='confirmation' class='edis' title='Full Details'><i class='glyphicon glyphicon-eye-open'></i></a>&nbsp;";
			$message.="<a href='../pdf/".$pdf_page.".php?ref=".$requ['alias']."' target='_blank' title='Download'><i class='glyphicon glyphicon-save'></i></a>&nbsp;";
			$message.="<a  href='".$requ['alias']."' class='edis' data-type='".$data_type_edit."' title='Edit'><i class='glyphicon glyphicon-edit'></i></a>&nbsp;";
			if($requ['approval_level1']=="0")$message.="<a href='".$requ['alias']."' class='deletelist' data-type='viewExpense' title='Delete Expense'><i class='glyphicon glyphicon-trash'></i></a>";
		$message.="</td>";
		$message.="</tr>";
		$pageNo=$requ['pagenumber'];
		$totalpages=$requ['totalpages'];
	}
	for($x=1;$x<=$totalpages;$x++){$op.="<option value='".$x."' ".chx($x,$pageNo).">Page ".$x."</option>";}
	$message.="<tr><td colspan='8' align='center'><select name='pageNo' onchange='listdetailsfun()'>$op</select></td><tr>";
	}else $message="<tr><td colspan='8' align='center'>No Records found</td></tr>";
	echo $message;
}

/* start - display the list of service allowances */
if($_REQUEST['ref'] == "serlistallowances"){
	
	$pageNo=$_REQUEST['pageNo'];
	$zone=$_REQUEST['zone'];
	$state=$_REQUEST['state'];
	$district=$_REQUEST['district'];
	$lamt=$_REQUEST['ldgAmnt'];
	$dailyallow=$_REQUEST['dailyallow'];
	$lclconv=$_REQUEST['lclconv'];
	$area=$_REQUEST['area'];
	$getdata=getserallowanceslist($zone,$state,$district,$lamt,$dailyallow,$lclconv,$area);
	if($getdata!=0){
		foreach($getdata as $requ){
			if($requ['area'] == 0){$disp_area = 'Plain Area';}else if($requ['area'] == 1){$disp_area = 'Hilly Area';}
			$message.="<tr class='magic'>";
			$message.="<td>".$requ['sno']."</td>";
			$message.="<td>".$requ['zone_name']."</td>";
			$message.="<td>".$requ['state_name']."</td>";
			$message.="<td>".$requ['district_name']."</td>";
			$message.="<td>".$disp_area."</td>";
			$message.="<td>".$requ['lodging_amount']."</td>";
			$message.="<td>".$requ['daily_allowance']."</td>";
			$message.="<td>".$requ['local_conveyance']."</td>";
			$message.="<td class='actionIcons'>";
			$message.="<a href='".$requ['service_allowance_alias']."' class='edis' data-type='editserallowances' title='Edit'><i class='glyphicon glyphicon-edit'></i></a>";
			$message.="</td>";
			$message.="</tr>";
		}
	}else $message="<tr><td colspan='13' align='center'>No Records found</td></tr>";
	echo $message;
}


/* end - display the list of service allowances */


function chx($x,$pageNo){if($x==$pageNo)return "selected";}
?>