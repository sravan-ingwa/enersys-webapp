<?php
include('mysql.php');
function TitleFav(){
	echo "<title>Enersys Care</title>";
	echo "<link rel='icon' href='../img/favicon.png' type='image/png'/>";
}
function checkint($fv1,$fv2,$fv3){
	include('mysql.php');
	$rec=$mr_con->query("SELECT id FROM $fv2 WHERE $fv3='#.".$fv1."'");
	return $rec->num_rows==0 ? $fv1 : checkint(mt_rand(1000,999999999),$fv2,$fv3);
}
function checkopbal($fv1){
	include('mysql.php');
	$rec=$mr_con->query("SELECT id FROM ec_advances WHERE employee_alias='".$fv1."' AND approved_by='' AND approval_level='6' AND flag='0'");
	return $rec->num_rows==0 ? 0 : 1;

}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++){$randomString .= $characters[rand(0, $charactersLength - 1)];}
    return strtoupper($randomString);
}

function aliasCheck($fv1,$fv2,$fv3,$mr_con){
	$rec=$mr_con->query("SELECT $fv3 FROM $fv2 WHERE $fv3='$fv1'");
	if($rec->num_rows==0)return $fv1; else  return aliasCheck(generateRandomString(),$fv2,$fv3,$mr_con);
}
function alreadyexist($fv1,$fv2,$fv3,$mr_con){
	$rec=$mr_con->query("SELECT id FROM $fv2 WHERE $fv3='$fv1'");
	if($rec->num_rows==0)return 0; else return 1;
}
function alreadyexist_level($fv1,$fv2,$mr_con){
	$rec=$mr_con->query("SELECT id FROM ec_expense_approvals WHERE approval_dep='$fv1' AND approval_level='$fv2'");
	if($rec->num_rows==0)return 0; else return 1;
}
function listdip(){
	include('mysql.php');
	$rec=$mr_con->query("SELECT department_name,department_alias FROM ec_department WHERE flag=0 ORDER BY department_name");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('name'=>$row['department_name'],'alias'=>$row['department_alias']);}
	return $result;
	}else return 0;
	
}
function listdgn(){
	include('mysql.php');
	$rec=$mr_con->query("SELECT designation,designation_alias,grade FROM ec_designation WHERE flag=0 ORDER BY designation");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('name'=>$row['designation'],'alias'=>$row['designation_alias'],'grade'=>$row['grade']);}
	return $result;
	}else return 0;
}
function listGrade(){
	include('mysql.php');
	$rec=$mr_con->query("SELECT grade FROM ec_designation WHERE flag=0 GROUP BY grade ORDER BY grade");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('grade'=>$row['grade']);}
	return $result;
	}else return 0;
}
function listlimt(){
	include('mysql.php');
	$rec=$mr_con->query("SELECT t2.designation,t1.limit_alias,t1.limit_amount FROM ec_expense_limits t1 LEFT JOIN ec_designation t2 ON t1.designation_alias = t2.designation_alias WHERE t1.flag=0  ORDER BY t1.limit_amount DESC");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('name'=>$row['designation'],'alias'=>$row['limit_alias'],'amount'=>$row['limit_amount']);}
	return $result;
	}else return 0;
}
function listApprovals(){
	include('mysql.php');
	$rec=$mr_con->query("SELECT approval_dep,approval_level,approver_dep,approver,approval_alias FROM ec_expense_approvals WHERE flag=0 ORDER BY created_date");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('approval_dep'=>departnment($row['approval_dep']),'approver_dep'=>departnment($row['approver_dep']),'approval_level'=>approver_level_name($row['approval_level']),'name'=>getMultiEmp($row['approver']),'alias'=>$row['approval_alias']);}
	return $result;
	}else return 0;
}
function approvalDetails($fv1=0){
	include('mysql.php');
	$rec=$mr_con->query("SELECT approval_dep,approval_level,approver_dep,approver,approval_alias FROM ec_expense_approvals WHERE approval_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('approval_dep'=>$row['approval_dep'],'approver_dep'=>$row['approver_dep'],'approval_level'=>$row['approval_level'],'name'=>$row['approver'],'alias'=>$row['approval_alias']);}
	return $result;
	}else return 0;
}
function approver_level_name($fv1){
	switch ($fv1){
		case '1': return "APPROVER LEVEL";break;
		case '2': return "SMCT LEVEL";break;
		case '3': return "FINANCE LEVEL";break;
		case '4': return "HOD LEVEL";break;
		case '5': return "MD LEVEL";break;
	}
}
function getMultiEmp($fv1){
	include('mysql.php');
	$fv2= "'".implode("','",explode("|",$fv1))."'";
	$rec=$mr_con->query("SELECT name FROM ec_employee_master WHERE employee_alias IN ($fv2) AND flag=0 ORDER BY name");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=$row['name'];}
	return implode(", ",$result);
	}else return 0;
}

function departnment($fv1){
	include('mysql.php');
	$rec=$mr_con->query("SELECT department_name FROM ec_department WHERE department_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){$row = $rec->fetch_assoc();return $row['department_name'];
	}else return 0;
}
function designation($fv1){
	include('mysql.php');
	$rec=$mr_con->query("SELECT designation FROM ec_designation WHERE designation_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){$row = $rec->fetch_assoc();return $row['designation'];
	}else return 0;
}
function desggrade($fv1){
	include('mysql.php');
	$rec=$mr_con->query("SELECT grade FROM ec_designation WHERE designation_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){$row = $rec->fetch_assoc();return $row['grade'];
	}else return 0;
}
function grade($fv1){
	include('mysql.php');
	$rec=$mr_con->query("SELECT grade FROM ec_designation WHERE designation_alias = (SELECT designation_alias FROM ec_employee_master WHERE employee_alias='$fv1' AND flag =0) AND flag=0");
	if($rec->num_rows > 0){$row = $rec->fetch_assoc();return $row['grade'];}else return 0;
}
function employeeDetails($fv1,$fv2){
	if($fv2!="admin"){
		include('mysql.php');
		$rec=$mr_con->query("SELECT $fv1 FROM ec_employee_master WHERE employee_alias='$fv2' AND flag =0");
		if($rec->num_rows > 0){$row = $rec->fetch_assoc();return $row[$fv1];}else return 0;
	}else return "Admin";
}
function gradedesg($gradedesg){
	include('mysql.php');
	$rec=$mr_con->query("SELECT designation FROM ec_designation WHERE grade='$gradedesg' AND flag=0 ORDER BY designation");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('designation'=>$row['designation']);}
	return $result;
	}else return 0;
}
function empbydep($empbydep){
	include('mysql.php');
	$rec=$mr_con->query("SELECT name,employee_alias FROM ec_employee_master WHERE department_alias='$empbydep' AND flag=0 ORDER BY name");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('name'=>$row['name'],'alias'=>$row['employee_alias']);}
	return $result;
	}else return 0;
}
function getfullemplist($pageNo,$empid,$empname,$dep,$des){
	include('mysql.php');
	$condition="";
	if($empid!="")$condition.=" employee_id LIKE '%".$empid."%' AND ";
	if($empname!="")$condition.=" name LIKE '%".$empname."%' AND ";
	if($dep!="")$condition.=" department_alias = '".$dep."' AND ";
	if($des!="")$condition.=" designation_alias ='".$des."' AND ";
	$rec=mysqli_query($mr_con,"SELECT count(e.id) FROM ec_employee_master e,ec_emprole r WHERE e.role_alias = r.role_alias AND r.role_stat <> 1 AND $condition e.flag=0");
	if($rec){
		$row=mysqli_fetch_array($rec,MYSQLI_NUM);
		$rec_limit = 10;
		$rec_count = $row[0];
		if(is_float($rec_count/$rec_limit)){$totalpages=round($rec_count/$rec_limit)+1;}else{$totalpages=$rec_count/$rec_limit;}
		if($pageNo!="all"){$page = ($pageNo-1);
		if($page<0){$page=0;}
		$offset = $rec_limit * $page ;}
		else{$page = 0;$offset = $rec_limit * $page ;}
		$left_rec=$rec_count-($page*$rec_limit);
	$rec=$mr_con->query("SELECT employee_id,employee_alias,name,department_alias,designation_alias FROM ec_employee_master e,ec_emprole r WHERE e.role_alias = r.role_alias AND r.role_stat <> 1 AND $condition e.flag=0 ORDER BY e.name LIMIT $offset, $rec_limit");
	if($rec->num_rows>0){while($row = $rec->fetch_assoc()){$result[]=array('employee_alias'=>$row['employee_alias'],'empid'=>$row['employee_id'],'empname'=>$row['name'],'dep'=>$row['department_alias'],'des'=>$row['designation_alias'],'pagenumber'=>$pageNo,'totalpages'=>$totalpages);} return $result;}else return 0;
	}else return 0;
}
function getfullallowanceslist(){
	include('mysql.php');
	$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_daily_allowances WHERE flag=0");
	if($rec){
		$rec=$mr_con->query("SELECT grade, lodging_allowances_a1, lodging_allowances_a, lodging_allowances_b, lodging_allowances_c, boarding_allowances_a1, boarding_allowances_a, boarding_allowances_b, boarding_allowances_c, mode_of_travel, mode_of_conveyance, mobile_roaming, allowance_alias FROM ec_daily_allowances WHERE flag=0 GROUP BY grade");
		if($rec->num_rows>0){while($row = $rec->fetch_assoc()){$result[]=array('grade'=>$row['grade'],'lodging_allowances_a1'=>$row['lodging_allowances_a1'],'lodging_allowances_a'=>$row['lodging_allowances_a'],'lodging_allowances_b'=>$row['lodging_allowances_b'],'lodging_allowances_c'=>$row['lodging_allowances_c'],'boarding_allowances_a1'=>$row['boarding_allowances_a1'],'boarding_allowances_a'=>$row['boarding_allowances_a'],'boarding_allowances_b'=>$row['boarding_allowances_b'],'boarding_allowances_c'=>$row['boarding_allowances_c'],'mode_of_travel'=>$row['mode_of_travel'],'mode_of_conveyance'=>$row['mode_of_conveyance'],'mobile_roaming'=>$row['mobile_roaming'],'allowance_alias'=>$row['allowance_alias']);} return $result;}else return 0;
	}else return 0;
}
function getfullallowancesdetails($fv1){
	include('mysql.php');
	$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_daily_allowances WHERE allowance_alias='$fv1' AND flag=0");
	if($rec){
		$rec=$mr_con->query("SELECT grade, lodging_allowances_a1, lodging_allowances_a, lodging_allowances_b, lodging_allowances_c, boarding_allowances_a1, boarding_allowances_a, boarding_allowances_b, boarding_allowances_c, mode_of_travel, mode_of_conveyance, mobile_roaming, allowance_alias FROM ec_daily_allowances WHERE allowance_alias='$fv1' AND flag=0");
		if($rec->num_rows>0){while($row = $rec->fetch_assoc()){$result[]=array('grade'=>$row['grade'],'lodging_allowances_a1'=>$row['lodging_allowances_a1'],'lodging_allowances_a'=>$row['lodging_allowances_a'],'lodging_allowances_b'=>$row['lodging_allowances_b'],'lodging_allowances_c'=>$row['lodging_allowances_c'],'boarding_allowances_a1'=>$row['boarding_allowances_a1'],'boarding_allowances_a'=>$row['boarding_allowances_a'],'boarding_allowances_b'=>$row['boarding_allowances_b'],'boarding_allowances_c'=>$row['boarding_allowances_c'],'mode_of_travel'=>$row['mode_of_travel'],'mode_of_conveyance'=>$row['mode_of_conveyance'],'mobile_roaming'=>$row['mobile_roaming'],'allowance_alias'=>$row['allowance_alias']);} return $result;}else return 0;
	}else return 0;
}
function getvalues($alias,$tb,$col,$retrive){ 
	include('mysql.php');
	$sql = $mr_con->query("SELECT $retrive FROM $tb WHERE $col='$alias' AND flag=0");
	if($sql->num_rows>0){
		$row = $sql->fetch_assoc();
		return $row[$retrive];
	}
}
function exlevels(){
	include('mysql.php');
	$rec=$mr_con->query("SELECT level_name,level_alias FROM ec_expense_level WHERE flag=0 ORDER BY level_alias");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('name'=>$row['level_name'],'alias'=>$row['level_alias']);}
	return $result;
	}else return 0;
}
function exlevelsName($fv1){
	include('mysql.php');
	$rec=$mr_con->query("SELECT level_name FROM ec_expense_level WHERE level_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){$row = $rec->fetch_assoc(); return $row['level_name'];}else return 0;
}
function checkApproval($fv1){
	include('mysql.php');
	$rec=$mr_con->query("SELECT id FROM ec_expense_approvals WHERE approver = '$fv1' AND flag=0");
	if($rec->num_rows>0){return 1;}else return 0;
}
function alias($alias,$tb,$col,$retrive){
	include('mysql.php');
	$sql = $mr_con->query("SELECT $retrive FROM $tb WHERE $col='$alias' AND flag=0");
	if(mysqli_num_rows($sql)){
		$row = mysqli_fetch_array($sql);
		return $row[$retrive];
	}else return "NA";
}
function advanceNotSettled($fv1){
	include('mysql.php');
	$rec=$mr_con->query("SELECT SUM(total_amount) AS totalRequest FROM ec_advances WHERE employee_alias='$fv1' AND approval_level='6' AND flag=0");
	//if($rec->num_rows > 0){
	if($rec){
		$row = $rec->fetch_assoc();
		return $row['totalRequest'];
		}else return 0;
}
function advancefullView($fv1){
	include('mysql.php');
	$rec=$mr_con->query("SELECT employee_alias, request_amount, total_amount, request_id, approved_by, requested_date, advance_alias, approval_level FROM ec_advances WHERE advance_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){
			$result[]=array('employee_alias'=>$row['employee_alias'],'request_id'=>$row['request_id'],'request_amount'=>$row['request_amount'],'total_amount'=>$row['total_amount'],'requested_date'=>$row['requested_date'],'approved_by'=>$row['approved_by'],'approval_level'=>exlevelsName($row['approval_level']),'approval_level1'=>$row['approval_level'],'advance_alias'=>$row['advance_alias']);
			}
		return $result;
	}else return 0;
}
function expensefullView($fv1){
	include('mysql.php');
	$rec=$mr_con->query("SELECT bill_number,po_gnr, employee_alias,period_of_visit_from,period_of_visit_to,places_of_visit,purpose,total_tour_expenses,requested_date,expenses_alias,approval_level FROM ec_expenses WHERE expenses_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){
			$result[]=array('bill_number'=>$row['bill_number'],'po_gnr'=>$row['po_gnr'],'employee_alias'=>$row['employee_alias'],'period_of_visit_from'=>$row['period_of_visit_from'],'period_of_visit_to'=>$row['period_of_visit_to'],'places_of_visit'=>$row['places_of_visit'],'purpose'=>$row['purpose'],'total_tour_expenses'=>$row['total_tour_expenses'],'requested_date'=>$row['requested_date'],'expenses_alias'=>$row['expenses_alias'],'approval_level'=>$row['approval_level']);
			}
		return $result;
	}else return 0;
} 
function ec_conveyance($fv1){ 
	include('mysql.php');
	$rec=$mr_con->query("SELECT expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,document_link,created_date,dpr_number,ticket_alias FROM ec_conveyance WHERE expenses_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=array('expenses_alias'=>$row['expenses_alias'],'date_of_travel'=>$row['date_of_travel'],'mode_of_travel'=>$row['mode_of_travel'],'from_place'=>$row['from_place'],'to_place'=>$row['to_place'],'amount'=>$row['amount'],'alias'=>$row['alias'],'document_link'=>$row['document_link'],'created_date'=>$row['created_date'],'dpr_number'=>$row['dpr_number'],'ticket_alias'=>$row['ticket_alias']);}
		return $result;
	}else return 0;
}
function ec_localconveyance($fv1){ 
	include('mysql.php');
	$rec=$mr_con->query("SELECT expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,created_date,zone_alias,state_alias,district_alias,bucket,capacity,quantity,km,dpr_number,ticket_alias FROM ec_localconveyance WHERE expenses_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=array('expenses_alias'=>$row['expenses_alias'],'date_of_travel'=>$row['date_of_travel'],'mode_of_travel'=>$row['mode_of_travel'],'from_place'=>$row['from_place'],'to_place'=>$row['to_place'],'amount'=>$row['amount'],'alias'=>$row['alias'],'created_date'=>$row['created_date'],'zone_alias'=>$row['zone_alias'],'state_alias'=>$row['state_alias'],'district_alias'=>$row['district_alias'],'bucket'=>$row['bucket'],'capacity'=>$row['capacity'],'quantity'=>$row['quantity'],'km'=>$row['km'],'dpr_number'=>$row['dpr_number'],'ticket_alias'=>$row['ticket_alias']);}
		return $result;
	}else return 0;
}
function ec_lodging($fv1){ 
	include('mysql.php');
	$rec=$mr_con->query("SELECT expenses_alias,type_of_stay,check_in,check_out,hotel_name,amount,alias,document_link,created_date,zone_alias,state_alias,district_alias,dpr_number,ticket_alias FROM ec_lodging WHERE  expenses_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=array('expenses_alias'=>$row['expenses_alias'],'type_of_stay'=>$row['type_of_stay'],'check_in'=>$row['check_in'],'check_out'=>$row['check_out'],'hotel_name'=>$row['hotel_name'],'amount'=>$row['amount'],'alias'=>$row['alias'],'document_link'=>$row['document_link'],'created_date'=>$row['created_date'],'zone_alias'=>$row['zone_alias'],'state_alias'=>$row['state_alias'],'district_alias'=>$row['district_alias'],'dpr_number'=>$row['dpr_number'],'ticket_alias'=>$row['ticket_alias']);}
		return $result;
	}else return 0;
}
function ec_boarding($fv1){ 
	include('mysql.php');
	$rec=$mr_con->query("SELECT expenses_alias,check_in,check_out,state,amount,alias,created_date,zone_alias,state_alias,district_alias,dpr_number,ticket_alias FROM ec_boarding WHERE expenses_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=array('expenses_alias'=>$row['expenses_alias'],'check_in'=>$row['check_in'],'check_out'=>$row['check_out'],'state'=>$row['state'],'amount'=>$row['amount'],'alias'=>$row['alias'],'created_date'=>$row['created_date'],'zone_alias'=>$row['zone_alias'],'state_alias'=>$row['state_alias'],'district_alias'=>$row['district_alias'],'dpr_number'=>$row['dpr_number'],'ticket_alias'=>$row['ticket_alias']);}
		return $result;
	}else return 0;
}
function ec_other_expenses($fv1){ 
	include('mysql.php');
	$rec=$mr_con->query("SELECT expenses_alias,description,amount,checked_date,alias,document_link,created_date,dpr_number,ticket_alias FROM ec_other_expenses WHERE  expenses_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=array('expenses_alias'=>$row['expenses_alias'],'description'=>$row['description'],'amount'=>$row['amount'],'checked_date'=>$row['checked_date'],'alias'=>$row['alias'],'document_link'=>$row['document_link'],'created_date'=>$row['created_date'],'dpr_number'=>$row['dpr_number'],'ticket_alias'=>$row['ticket_alias']);}
		return $result;
	}else return 0;
}
function getRemarks($fv1,$fv2){ 
	include('mysql.php');
	$rec=$mr_con->query("SELECT remarks, remarked_by, remarked_on FROM ec_remarks WHERE item_alias='$fv1' AND module='$fv2' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=array('remarks'=>$row['remarks'],'remarked_by'=>$row['remarked_by'],'remarked_on'=>$row['remarked_on']);}
		return $result;
	}else return 0;
}
function getfulladvancelist($pageNo,$requestID,$requestDate,$requestamt,$reqStat,$empname){
	include('mysql.php');
	$condition="";
	if($requestID!="")$condition.=" request_id LIKE '%".$requestID."%' AND ";
	if($requestDate!="")$condition.=" requested_date=".$requestDate." AND ";
	if($empname!="")$condition.=" employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE name LIKE '%$empname%' AND flag=0) AND ";
	if($requestamt!="")$condition.=" request_amount LIKE '%".$requestamt."%' AND ";
	if($reqStat!="")$condition.=" approval_level LIKE '%".$reqStat."%' AND ";
	$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_advances WHERE $condition flag=0");
	if($rec){
		$row=mysqli_fetch_array($rec,MYSQLI_NUM);
		$rec_limit = 10;
		$rec_count = $row[0];
		if(is_float($rec_count/$rec_limit)){$totalpages=round($rec_count/$rec_limit)+1;}else{$totalpages=$rec_count/$rec_limit;}
		if($pageNo!="all"){$page = ($pageNo-1);
		if($page<0){$page=0;}
		$offset = $rec_limit * $page ;}
		else{$page = 0;$offset = $rec_limit * $page ;}
		$left_rec=$rec_count-($page*$rec_limit);
		$rec=mysqli_query($mr_con,"SELECT request_id,employee_alias,request_amount,total_amount,requested_date,approved_by,approval_level,advance_alias FROM ec_advances WHERE $condition flag=0 ORDER BY requested_date DESC LIMIT $offset, $rec_limit");
		if($rec->num_rows>0){while($row = $rec->fetch_assoc()){$result[]=array('employee_alias'=>$row['employee_alias'],'request_id'=>$row['request_id'],'request_amount'=>$row['request_amount'],'total_amount'=>$row['total_amount'],'requested_date'=>$row['requested_date'],'approval_level'=>exlevelsName($row['approval_level']),'approval_level1'=>$row['approval_level'],'approval_by'=>employeeDetails('name',$row['approved_by']),'pagenumber'=>$pageNo,'totalpages'=>$totalpages,'alias'=>$row['advance_alias'],'activa'=>$avtivea);} return $result;}else return 0;
	}else return 0;
}
function getfullexpenselist($pageNo,$bill_no,$requestDate,$totalExpense,$outbal,$placeofVisit,$reqStat,$empname){
	include('mysql.php');
	$condition="";
	if($bill_no!="")$condition.=" bill_number LIKE '%".$bill_no."%' AND ";
	if($requestDate!="")$condition.=" requested_date=".$requestDate." AND ";
	if($empname!="")$condition.=" employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE name LIKE '%$empname%' AND flag=0) AND ";
	if($totalExpense!="")$condition.=" total_tour_expenses LIKE '%".$totalExpense."%' AND ";
	if($placeofVisit!="")$condition.=" places_of_visit LIKE '%".$placeofVisit."%' AND ";
	if($reqStat!="")$condition.=" approval_level LIKE '%".$reqStat."%' AND ";
	$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_expenses WHERE $condition flag=0");
	if($rec){
		$row=mysqli_fetch_array($rec,MYSQLI_NUM);
		$rec_limit = 10;
		$rec_count = $row[0];
		if(is_float($rec_count/$rec_limit)){$totalpages=round($rec_count/$rec_limit)+1;}else{$totalpages=$rec_count/$rec_limit;}
		if($pageNo!="all"){$page = ($pageNo-1);
		if($page<0){$page=0;}
		$offset = $rec_limit * $page ;}
		else{$page = 0;$offset = $rec_limit * $page ;}
		$left_rec=$rec_count-($page*$rec_limit);
		$rec=mysqli_query($mr_con,"SELECT employee_alias,bill_number,requested_date,total_tour_expenses,places_of_visit,approval_level,expenses_alias FROM ec_expenses WHERE $condition flag=0 ORDER BY requested_date DESC LIMIT $offset, $rec_limit");
		if($rec->num_rows>0){while($row = $rec->fetch_assoc()){$result[]=array('employee_alias'=>$row['employee_alias'],'bill_number'=>$row['bill_number'],'requested_date'=>$row['requested_date'],'total_tour_expenses'=>$row['total_tour_expenses'],'outbal'=>advanceNotSettled($row['employee_alias']),'approval_level'=>exlevelsName($row['approval_level']),'places_of_visit'=>$row['places_of_visit'],'approval_level1'=>$row['approval_level'],'pagenumber'=>$pageNo,'totalpages'=>$totalpages,'alias'=>$row['expenses_alias'],'activa'=>$avtivea);} return $result;}else return 0;
	}else return 0;
}
function advancelimit($fv1){
	include('mysql.php');
	$rec=$mr_con->query("SELECT limit_amount FROM ec_expense_limits WHERE designation_alias = (SELECT designation_alias FROM ec_employee_master WHERE employee_alias='$fv1' AND flag =0) AND flag=0");
	if($rec->num_rows > 0){$row = $rec->fetch_assoc();return $row['limit_amount'];}else return 10000;
}
function expenseApprovalLevels($fv1){
	include('mysql.php');
	$fv2=employeeDetails('department_alias',$fv1);
	$rec=$mr_con->query("SELECT approval_level FROM ec_expense_approvals WHERE approver ='$fv1' AND flag=0 ORDER BY approval_level DESC");
	if($rec->num_rows>0){$row = $rec->fetch_assoc();return $row['approval_level'];}else return 0;
}
function deleteitems($fv1,$fv2){
	include('mysql.php');
	if($fv1=="viewadvance"){
		$rec=$mr_con->query("DELETE FROM ec_advances WHERE advance_alias='$fv2'");
		$mr_con->query("DELETE FROM ec_remarks WHERE item_alias='$fv2' AND module='BA'");
		if($rec) return "1";else return "0";
	}
	else{
		$arr = array("ec_conveyance","ec_localconveyance","ec_lodging","ec_other_expenses","ec_boarding");
		foreach($arr as $abc){
			if($abc!="ec_boarding" && $abc!="ec_localconveyance"){
				$xyz = alias($fv2,$abc,"expenses_alias","document_link");
				if(file_exists($xyz))@unlink($xyz);
			}
			$mr_con->query("DELETE FROM $abc WHERE expenses_alias='$fv2' AND flag=0");
		}
		$rec=$mr_con->query("DELETE FROM ec_expenses WHERE expenses_alias='$fv2'");
		$mr_con->query("DELETE FROM ec_remarks WHERE item_alias='$fv2' AND module='BE'");
		if($rec) return "1";else return "0";
	}
}

/*start- get the zones from db */
function getZones(){
	include('mysql.php');
	$rec=$mr_con->query("SELECT * FROM ec_zone WHERE flag=0");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('zone_alias'=>$row['zone_alias'],'zone_name'=>$row['zone_name']);}
	return $result;
	}else return 0;
}
/*end- get the zones from db */

/*start- get the list of service allowances from db*/
function getserallowanceslist($zone,$state,$district,$lamt,$dailyallow,$lclconv,$area){
	include('mysql.php');
	$condition="";
	if($zone!="") $condition.=" s.zone_alias = '".$zone."' AND ";
	if($state!="") $condition.=" s.state_alias = '".$state."' AND ";
	if($district!="") $condition.=" s.district_alias = '".$district."' AND ";
	if($lamt!="")$condition.=" s.lodging_amount LIKE '%".$lamt."%' AND ";
	if($dailyallow!="")$condition.=" s.daily_allowance LIKE '%".$dailyallow."%' AND ";
	if($lclconv!="")$condition.=" s.local_conveyance LIKE '%".$lclconv."%' AND ";
	if($area != ""){
	$rec=mysqli_query($mr_con,"SELECT count(s.id) FROM ec_service_allowances s,ec_district d WHERE $condition s.district_alias = d.district_alias AND d.	area=$area AND s.flag=0");
	}else{
	$rec=mysqli_query($mr_con,"SELECT count(s.id) FROM ec_service_allowances s WHERE $condition s.flag=0");
	}
	if($rec){
		$row=mysqli_fetch_array($rec,MYSQLI_NUM);
		$rec_limit = 10;
		$rec_count = $row[0];
		if(is_float($rec_count/$rec_limit)){$totalpages=round($rec_count/$rec_limit)+1;}else{$totalpages=$rec_count/$rec_limit;}
		if($pageNo!="all"){$page = ($pageNo-1);
		if($page<0){$page=0;}
		$offset = $rec_limit * $page ;}
		else{$page = 0;$offset = $rec_limit * $page ;}
		$left_rec=$rec_count-($page*$rec_limit);
		if($area != ""){
			$rec=$mr_con->query("SELECT *,(SELECT i.zone_name FROM ec_zone i WHERE i.zone_alias = s.zone_alias) AS zone_name, (SELECT t.state_name FROM ec_state t WHERE t.state_alias = s.state_alias) AS state_name,(SELECT d.district_name FROM ec_district d WHERE d.district_alias = s.district_alias) AS district_name,(SELECT d.area FROM ec_district d WHERE d.district_alias = s.district_alias) AS area FROM ec_service_allowances s,ec_district d WHERE $condition s.district_alias = d.district_alias AND d.area='$area' AND s.flag=0 ORDER BY s.id LIMIT $offset, $rec_limit");
		}else{
			$rec=$mr_con->query("SELECT *,(SELECT i.zone_name FROM ec_zone i WHERE i.zone_alias = s.zone_alias) AS zone_name, (SELECT t.state_name FROM ec_state t WHERE t.state_alias = s.state_alias) AS state_name,(SELECT d.district_name FROM ec_district d WHERE d.district_alias = s.district_alias) AS district_name,(SELECT d.area FROM ec_district d WHERE d.district_alias = s.district_alias) AS area FROM ec_service_allowances s WHERE $condition s.flag=0  ORDER BY s.id LIMIT $offset, $rec_limit");
		}
		if($rec->num_rows>0){$sno=1;while($row = $rec->fetch_assoc()){$result[]=array('sno'=>$sno,'zone_name'=>$row['zone_name'],'state_name'=>$row['state_name'],'district_name'=>$row['district_name'],'area'=>$row['area'],'lodging_amount'=>$row['lodging_amount'],'daily_allowance'=>$row['daily_allowance'],'local_conveyance'=>$row['local_conveyance'],'service_allowance_alias'=>$row['service_allowance_alias']);$sno++;} return $result;}else return 0;
	}else return 0;
}
/*start- get the list of service allowances from db*/

/*start- get the perticular record of service allowances from db*/
function getserallowancesdetails($fv1){
	include('mysql.php');
	$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_service_allowances WHERE service_allowance_alias='$fv1' AND flag=0");
	if($rec){
		$rec=$mr_con->query("SELECT zone_alias, state_alias, district_alias, lodging_amount, daily_allowance, local_conveyance, service_allowance_alias FROM ec_service_allowances WHERE service_allowance_alias='$fv1' AND flag=0");
		if($rec->num_rows>0){while($row = $rec->fetch_assoc()){$result[]=array('zone_alias'=>$row['zone_alias'],'state_alias'=>$row['state_alias'],'district_alias'=>$row['district_alias'],'lodging_amount'=>$row['lodging_amount'],'daily_allowance'=>$row['daily_allowance'],'local_conveyance'=>$row['local_conveyance'],'service_allowance_alias'=>$row['service_allowance_alias']);} return $result;}else return 0;
	}else return 0;
}
/*start-  get the perticular record of service allowances from db*/

/*start- get the states from db */
function getStates($fv1){
	include('mysql.php');
	$rec=$mr_con->query("SELECT * FROM ec_state WHERE flag=0 AND zone_alias='$fv1' ORDER BY state_name");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('state_alias'=>$row['state_alias'],'state_name'=>$row['state_name']);}
	return $result;
	}else return 0;
}
/*end- get the zones from db */

/*start- get the states from db */
function getDistricts($fv1){
	include('mysql.php');
	$rec=$mr_con->query("SELECT * FROM ec_district WHERE flag=0 AND state_alias='$fv1' ORDER BY district_name");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('district_alias'=>$row['district_alias'],'district_name'=>$row['district_name']);}
	return $result;
	}else return 0;
}
/*end- get the zones from db */


/*start- get the states from db */
function getArea($fv1){
	include('mysql.php');
	$rec=$mr_con->query("SELECT area FROM ec_district WHERE flag=0 AND district_alias='$fv1'");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){
		$result = $row['area'];
		}
	return $result;
	}else return 0;
}
/*end- get the zones from db */

function checkspldep($fv1){
	include('mysql.php');
	$temp1=alias($fv1,'ec_employee_master','employee_alias','department_alias');	
	$temp2=alias($temp1,'ec_department','department_alias','spl');
	return $temp2;
}

/*start- get the role_stat from db */
function getRoleStat($fv1){
	include('mysql.php');
	$rec=$mr_con->query("SELECT role_stat FROM ec_emprole WHERE flag=0 AND role_alias='$fv1'");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){
		$result = $row['role_stat'];
		}
	return $result;
	}else return 0;
}
/*end- get the role_stat from db */
function getNames($fv1,$fv2){
	$where = ($fv2=='ec_zone' ? 'zone_alias' : ($fv2=='ec_state' ? 'state_alias' : 'district_alias'));
	$get = ($fv2=='ec_zone' ? 'zone_name' : ($fv2=='ec_state' ? 'state_name' : 'district_name'));
	include('mysql.php');
	$rec=$mr_con->query("SELECT $get as res FROM $fv2 WHERE flag=0 AND $where = '$fv1'");
	if($rec->num_rows>0){
	$row =$rec->fetch_assoc();
	return $res = $row['res'];
	}else return 0;
}
function getTicketName($fv1){
	include('mysql.php');
	$rec=$mr_con->query("SELECT ticket_id FROM ec_tickets WHERE flag=0 AND ticket_alias = '$fv1'");
	if($rec->num_rows>0){
	$row = $rec->fetch_assoc();
	$result=$row['ticket_id'];
	return $result;
	}else return '';
}
function getWeights($fv1,$fv2){
	$get = ($fv2=='weight' ? 'weight' : 'product_description');
	include('mysql.php');
	$rec=$mr_con->query("SELECT $get as res FROM ec_product WHERE flag=0 AND product_alias = '$fv1'");
	if($rec->num_rows>0){
	$row =$rec->fetch_assoc();
	return $res = $row['res'];
	}else return 0;
}

function noofDays($fv1,$fv2){
	$date1=date_create($fv1);
	$date2=date_create($fv2);
	$diff=date_diff($date1,$date2);
	echo ($diff->format("%a")+1)." Days";
}
function getCapacity(){
	include('mysql.php');
	$rec=$mr_con->query("SELECT product_description,product_alias FROM ec_product
 WHERE flag=0");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('product_alias'=>$row['product_alias'],'product_description'=>$row['product_description']);}
	return $result;
	}else return 0;
}

function getTicket($fv1){
	include('mysql.php');
	$rec=$mr_con->query("SELECT ticket_id,ticket_alias FROM ec_tickets WHERE flag=0 AND service_engineer_alias = '$fv1'");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('ticket_id'=>$row['ticket_id'],'ticket_alias'=>$row['ticket_alias']);}
	return $result;
	}else return 0;
}

?>