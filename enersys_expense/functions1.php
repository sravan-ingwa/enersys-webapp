<?php
$base_url="http://enersyscare.co.in/enersys_expense/";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ec_enersyscare_db_a";
$mr_con = new mysqli($servername, $username, $password, $dbname);
if ($mr_con->connect_error) {die("Connection failed");}
function all_from_mail(){ return "enersyscare_no_reply@enersys.com.cn"; }
function TitleFav(){
	echo "<title>Enersys Care</title>";
	echo "<link rel='icon' href='img/favicon.png' type='image/png'/>";
}
function generateRandomString($length = 13) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++){$randomString .= $characters[rand(0, $charactersLength - 1)];}
    return strtoupper($randomString);
}
function aliasCheck($fv1,$fv2,$fv3){ global $mr_con;
	$rec=$mr_con->query("SELECT $fv3 FROM $fv2 WHERE $fv3='$fv1'");
	if($rec->num_rows==0)return $fv1; else return aliasCheck(generateRandomString(),$fv2,$fv3);
}
function listdip(){ global $mr_con;
	$rec=$mr_con->query("SELECT department_name,department_alias FROM ec_department WHERE flag=0 ORDER BY department_name");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('name'=>$row['department_name'],'alias'=>$row['department_alias']);}
	return $result;
	}else return 0;
	
}
function checkint($fv1,$fv2,$fv3){ global $mr_con;
	$rec=$mr_con->query("SELECT id FROM $fv2 WHERE $fv3='#.".$fv1."'");
	return $rec->num_rows==0 ? $fv1 : checkint(mt_rand(1000,999999999),$fv2,$fv3);
}
function employeeDetails($fv1,$fv2){ global $mr_con;
	if($fv2=="admin"){return "Admin";}
	else{
		$rec=$mr_con->query("SELECT $fv1 FROM ec_employee_master WHERE employee_alias='$fv2' AND flag='0'");
		if($rec->num_rows > 0){$row = $rec->fetch_assoc();return $row[$fv1];}else return 0;
	}
}
function empdrop(){ global $mr_con;
	$rec=$mr_con->query("SELECT employee_alias,name FROM ec_employee_master WHERE flag=0 ORDER BY name");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('name'=>$row['name'],'alias'=>$row['employee_alias']);}
	return $result;
	}else return 0;
}
function exlevels(){ global $mr_con;
	$rec=$mr_con->query("SELECT level_name,level_alias FROM ec_expense_level WHERE flag=0 ORDER BY level_alias");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('name'=>$row['level_name'],'alias'=>$row['level_alias']);}
	return $result;
	}else return 0;
}
function exlevelsName($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT level_name FROM ec_expense_level WHERE level_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){$row = $rec->fetch_assoc(); return $row['level_name'];}else return 0;
}
function grade($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT grade FROM ec_designation WHERE designation_alias = (SELECT designation_alias FROM ec_employee_master WHERE employee_alias='$fv1' AND flag =0) AND flag=0");
	if($rec->num_rows > 0){$row = $rec->fetch_assoc();return $row['grade'];}else return 0;
}
function advanceNotSettled($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT SUM(request_amount) AS totalRequest FROM ec_advances WHERE employee_alias='$fv1' AND approval_level IN ('7','6') AND flag=0");
	$rec1=$mr_con->query("SELECT SUM(total_tour_expenses)-SUM(reimbursement_amount) AS totalRequest1 FROM ec_expenses WHERE employee_alias='$fv1' AND approval_level IN ('7','6') AND flag=0");

	//if($rec->num_rows > 0){
	if($rec){
		$row = $rec->fetch_assoc();
		$row1 = $rec1->fetch_assoc();
		return ($row['totalRequest']-$row1['totalRequest1']);
	}else return 0;
}
function toatlAdvances($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT SUM(request_amount) AS totalRequest FROM ec_advances WHERE employee_alias='$fv1' AND approval_level IN ('6','7') AND flag=0");
	if($rec->num_rows > 0){
		$row = $rec->fetch_assoc();
		if($row['totalRequest'] > 0) return $row['totalRequest']; else return 0;
	}else return 0;
}
function totalExpenses($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT SUM(total_tour_expenses)-SUM(reimbursement_amount) AS totalRequest FROM ec_expenses WHERE employee_alias='$fv1' AND approval_level IN ('6','7') AND flag=0");
	if($rec->num_rows > 0){
		$row = $rec->fetch_assoc();
		if($row['totalRequest'] > 0) return $row['totalRequest']; else return 0;
	}else return 0;
}
function totalAdvance($fv1,$fv2){ global $mr_con; 
	$ta=advanceNotSettled($fv2)+$fv1;
	$al=advancelimit($fv2);
	if($ta>$al) return $ta.'|1';
	else return $ta.'|0';
	}
function advancelimit($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT limit_amount FROM ec_expense_limits WHERE designation_alias = (SELECT designation_alias FROM ec_employee_master WHERE employee_alias='$fv1' AND flag =0) AND flag=0");
	if($rec->num_rows > 0){$row = $rec->fetch_assoc();return $row['limit_amount'];}else return 10000;
}
function advancedetlimited($fv2,$fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT $fv2 FROM ec_advances WHERE advance_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){$row = $rec->fetch_assoc(); return $row[$fv2];}else return 0;
}
function expensedetlimited($fv2,$fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT $fv2 FROM ec_expenses WHERE expenses_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){$row = $rec->fetch_assoc(); return $row[$fv2];}else return 0;
}
function listPendingAdvances($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT request_id,total_amount,requested_date,approved_by FROM ec_advances WHERE employee_alias='$fv1' AND approval_level='6' AND total_amount!='0' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=array('request_id'=>$row['request_id'],'total_amount'=>$row['total_amount'],'requested_date'=>$row['requested_date'],'approved_by'=>$row['approved_by']);}
		return $result;
	}else return 0;
}
function getfulladvancelist($pageNo,$requestID,$requestDate,$requestamt,$reqStat,$user,$empname){ global $mr_con;
	$condition="";
	if($requestID!="")$condition.=" request_id LIKE '%".$requestID."%' AND ";
	if($requestDate!="")$condition.=" requested_date=".$requestDate." AND ";
	if($empname!="")$condition.=" employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE name LIKE '%$empname%' AND flag=0) AND ";
	if($requestamt!="")$condition.=" request_amount LIKE '%".$requestamt."%' AND ";
	if($reqStat!="")$condition.=" approval_level LIKE '%".$reqStat."%' AND ";
	$chapp=checkApproval($user);
	$emp_spl_dep=checkspldep($user);
	if($chapp<='0' && ($emp_spl_dep=="1" || $emp_spl_dep=="2")){
		$rec=mysqli_query($mr_con,"(SELECT count(id) FROM ec_advances WHERE $condition flag=0 AND approval_level<>'0' AND employee_alias<>'$user') UNION ALL (SELECT count(id) FROM ec_advances WHERE $condition employee_alias='$user' AND flag=0)");
	}else if($chapp>0){
		if (in_array('5', approvelvl($user))) {
			$rec=mysqli_query($mr_con,"(SELECT count(id) FROM ec_advances WHERE $condition employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE department_alias IN (SELECT approval_dep FROM ec_expense_approvals WHERE approver='$user' AND flag=0) AND flag =0) AND flag=0 AND (approval_level='5') AND employee_alias<>'$user') UNION ALL (SELECT count(id) FROM ec_advances WHERE $condition employee_alias='$user' AND flag=0)");
		}else{
			//echo "(SELECT count(id) FROM ec_advances WHERE $condition employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE department_alias IN (SELECT approval_dep FROM ec_expense_approvals WHERE approver='$user' AND flag=0) AND flag =0) AND flag=0 AND (approval_level<>'0' && approval_level<'6') AND employee_alias<>'$user') UNION ALL (SELECT count(id) FROM ec_advances WHERE $condition employee_alias='$user' AND flag=0)";
			$rec=mysqli_query($mr_con,"(SELECT count(id) FROM ec_advances WHERE $condition employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE department_alias IN (SELECT approval_dep FROM ec_expense_approvals WHERE approver='$user' AND flag=0) AND flag =0) AND flag=0 AND (approval_level<>'0' && approval_level<'6') AND employee_alias<>'$user') UNION ALL (SELECT count(id) FROM ec_advances WHERE $condition employee_alias='$user' AND flag=0)");
		}
	}else{
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_advances WHERE $condition employee_alias='$user' AND flag=0");
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
		if($chapp<='0' && ($emp_spl_dep=="1" || $emp_spl_dep=="2")){
			$rec=mysqli_query($mr_con,"(SELECT request_id,employee_alias,request_amount,total_amount,requested_date,approved_by,approval_level,advance_alias FROM ec_advances WHERE $condition flag=0 AND approval_level<>'0' AND employee_alias<>'$user' ORDER BY requested_date DESC LIMIT $offset, $rec_limit) UNION ALL (SELECT request_id,employee_alias,request_amount,total_amount,requested_date,approved_by,approval_level,advance_alias FROM ec_advances WHERE $condition employee_alias='$user' AND flag=0 ORDER BY requested_date DESC LIMIT $offset, $rec_limit)");
		}else if($chapp>0){$avtivea=1;
			if (in_array('5', approvelvl($user))) {
				$rec=mysqli_query($mr_con,"(SELECT request_id,employee_alias,request_amount,total_amount,requested_date,approved_by,approval_level,advance_alias FROM ec_advances WHERE $condition employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE department_alias IN (SELECT approval_dep FROM ec_expense_approvals WHERE approver='$user' AND flag=0) AND flag =0) AND flag=0 AND (approval_level='5') AND employee_alias<>'$user' ORDER BY requested_date DESC LIMIT $offset, $rec_limit) UNION ALL (SELECT request_id,employee_alias,request_amount,total_amount,requested_date,approved_by,approval_level,advance_alias FROM ec_advances WHERE $condition employee_alias='$user' AND flag=0 ORDER BY requested_date DESC LIMIT $offset, $rec_limit)");
			}else{
				//echo "(SELECT request_id,employee_alias,request_amount,total_amount,requested_date,approved_by,approval_level,advance_alias FROM ec_advances WHERE $condition employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE department_alias IN (SELECT approval_dep FROM ec_expense_approvals WHERE approver='$user' AND flag=0) AND flag =0) AND flag=0 AND (approval_level<>'0' && approval_level<'6') AND employee_alias<>'$user' ORDER BY requested_date DESC LIMIT $offset, $rec_limit) UNION ALL (SELECT request_id,employee_alias,request_amount,requested_date,approved_by,approval_level,advance_alias FROM ec_advances WHERE $condition employee_alias='$user' AND flag=0 ORDER BY requested_date DESC LIMIT $offset, $rec_limit)";
				$rec=mysqli_query($mr_con,"(SELECT request_id,employee_alias,request_amount,total_amount,requested_date,approved_by,approval_level,advance_alias FROM ec_advances WHERE $condition employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE department_alias IN (SELECT approval_dep FROM ec_expense_approvals WHERE approver='$user' AND flag=0) AND flag =0) AND flag=0 AND (approval_level<>'0' && approval_level<'6') AND employee_alias<>'$user' ORDER BY requested_date DESC LIMIT $offset, $rec_limit) UNION ALL (SELECT request_id,employee_alias,request_amount,total_amount,requested_date,approved_by,approval_level,advance_alias FROM ec_advances WHERE $condition employee_alias='$user' AND flag=0 ORDER BY requested_date DESC LIMIT $offset, $rec_limit)");
			}
		}else{$avtivea=0;
			$rec=mysqli_query($mr_con,"SELECT request_id,employee_alias,request_amount,total_amount,requested_date,approved_by,approval_level,advance_alias FROM ec_advances WHERE $condition employee_alias='$user' AND flag=0 ORDER BY requested_date DESC LIMIT $offset, $rec_limit");
		}
		if($rec->num_rows>0){while($row = $rec->fetch_assoc()){$result[]=array('employee_alias'=>$row['employee_alias'],'request_id'=>$row['request_id'],'request_amount'=>$row['request_amount'],'total_amount'=>$row['total_amount'],'requested_date'=>$row['requested_date'],'approval_level'=>exlevelsName($row['approval_level']),'approval_level1'=>$row['approval_level'],'approval_by'=>employeeDetails('name',$row['approved_by']),'pagenumber'=>$pageNo,'totalpages'=>$totalpages,'alias'=>$row['advance_alias'],'activa'=>$avtivea);} return $result;}else return 0;
	}else return 0;
}
function getfullexpenselist($pageNo,$bill_no,$requestDate,$totalExpense,$outbal,$placeofVisit,$reqStat,$user,$empname){ global $mr_con;
	$condition="";
	if($requestDate != ''){
	$requestDate=date("Y-m-d", strtotime($requestDate));}
	if($bill_no!="")$condition.=" bill_number LIKE '%".$bill_no."%' AND ";
	if($requestDate!="")$condition.=" requested_date='".$requestDate."' AND ";
	if($empname!="")$condition.=" employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE name LIKE '%$empname%' AND flag=0) AND ";
	if($totalExpense!="")$condition.=" total_tour_expenses LIKE '%".$totalExpense."%' AND ";
	if($placeofVisit!="")$condition.=" places_of_visit LIKE '%".$placeofVisit."%' AND ";
	if($reqStat!="")$condition.=" approval_level LIKE '%".$reqStat."%' AND ";
	$chapp=checkApproval($user);
	$emp_spl_dep=checkspldep($user);
	if($chapp<='0' && ($emp_spl_dep=="1" || $emp_spl_dep=="2")){
		$rec=mysqli_query($mr_con,"(SELECT count(id) FROM ec_expenses WHERE $condition flag=0 AND approval_level<>'0' AND employee_alias<>'$user') UNION ALL (SELECT count(id) FROM ec_expenses WHERE $condition employee_alias='$user' AND flag=0)");
	}
	else if($chapp>0){
		//print_r(approvelvl($user));
		if (in_array('5', approvelvl($user))) {
			$rec=mysqli_query($mr_con,"(SELECT count(id) FROM ec_expenses WHERE $condition employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE department_alias IN (SELECT approval_dep FROM ec_expense_approvals WHERE approver='$user' AND flag=0) AND flag =0) AND flag=0 AND approval_level='5' AND employee_alias<>'$user') UNION ALL (SELECT count(id) FROM ec_expenses WHERE $condition employee_alias='$user' AND flag=0)");
		}
		else{
			$rec=mysqli_query($mr_con,"(SELECT count(id) FROM ec_expenses WHERE $condition employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE department_alias IN (SELECT approval_dep FROM ec_expense_approvals WHERE approver='$user' AND flag=0) AND flag =0) AND flag=0 AND (approval_level<>'0' && approval_level<'6') AND employee_alias<>'$user') UNION ALL (SELECT count(id) FROM ec_expenses WHERE $condition employee_alias='$user' AND flag=0)");
		}
	}else{
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_expenses WHERE $condition employee_alias='$user' AND flag=0");
	}
	if($rec){
		$row=mysqli_fetch_array($rec,MYSQLI_NUM);
		$rec_limit = 10;
		$rec_count = $row[0];
		if(is_float($rec_count/$rec_limit)){$totalpages=floor($rec_count/$rec_limit)+1;}else{$totalpages=$rec_count/$rec_limit;}
		if($pageNo!="all"){$page = ($pageNo-1);
		if($page<0){$page=0;}
		$offset = $rec_limit * $page ;}
		else{$page = 0;$offset = $rec_limit * $page ;}
		$left_rec=$rec_count-($page*$rec_limit);
		if($chapp=='0' && ($emp_spl_dep=="1" || $emp_spl_dep=="2")){
			$rec=mysqli_query($mr_con,"(SELECT utr_num,employee_alias,bill_number,requested_date,total_tour_expenses,places_of_visit,approval_level,expenses_alias FROM ec_expenses WHERE $condition flag=0 AND approval_level<>'0' AND employee_alias<>'$user' ORDER BY requested_date DESC LIMIT $offset, $rec_limit) UNION ALL (SELECT utr_num,employee_alias,bill_number,requested_date,total_tour_expenses,places_of_visit,approval_level,expenses_alias FROM ec_expenses WHERE $condition employee_alias='$user' AND flag=0 ORDER BY requested_date DESC LIMIT $offset, $rec_limit)");
		}
		else if($chapp>0){
			if (in_array('5', approvelvl($user))) {
				$rec=mysqli_query($mr_con,"(SELECT utr_num,employee_alias,bill_number,requested_date,total_tour_expenses,places_of_visit,approval_level,expenses_alias FROM ec_expenses WHERE $condition employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE department_alias IN (SELECT approval_dep FROM ec_expense_approvals WHERE approver='$user' AND flag=0) AND flag =0) AND flag=0 AND approval_level='5' AND employee_alias<>'$user' ORDER BY requested_date DESC LIMIT $offset, $rec_limit) UNION ALL (SELECT utr_num,employee_alias,bill_number,requested_date,total_tour_expenses,places_of_visit,approval_level,expenses_alias FROM ec_expenses WHERE $condition employee_alias='$user' AND flag=0 ORDER BY requested_date DESC LIMIT $offset, $rec_limit)");
			}
			else{
				$rec=mysqli_query($mr_con,"(SELECT utr_num,employee_alias,bill_number,requested_date,total_tour_expenses,places_of_visit,approval_level,expenses_alias FROM ec_expenses WHERE $condition employee_alias IN (SELECT employee_alias FROM ec_employee_master WHERE department_alias IN (SELECT approval_dep FROM ec_expense_approvals WHERE approver='$user' AND flag=0) AND flag =0) AND flag=0 AND (approval_level<>'0' && approval_level<'6') AND employee_alias<>'$user' ORDER BY requested_date DESC LIMIT $offset, $rec_limit) UNION ALL (SELECT utr_num,employee_alias,bill_number,requested_date,total_tour_expenses,places_of_visit,approval_level,expenses_alias FROM ec_expenses WHERE $condition employee_alias='$user' AND flag=0 ORDER BY requested_date DESC LIMIT $offset, $rec_limit)");
			}
		}else{
			$rec=mysqli_query($mr_con,"SELECT utr_num,employee_alias,bill_number,requested_date,total_tour_expenses,places_of_visit,approval_level,expenses_alias FROM ec_expenses WHERE $condition employee_alias='$user' AND flag=0 ORDER BY requested_date DESC LIMIT $offset, $rec_limit");
		}
		if($rec->num_rows>0){while($row = $rec->fetch_assoc()){
			$result[]=array('utr_num'=>$row['utr_num'],'employee_alias'=>$row['employee_alias'],'bill_number'=>$row['bill_number'],'requested_date'=>$row['requested_date'],'total_tour_expenses'=>$row['total_tour_expenses'],'outbal'=>advanceNotSettled($row['employee_alias']),'approval_level'=>exlevelsName($row['approval_level']),'places_of_visit'=>$row['places_of_visit'],'approval_level1'=>$row['approval_level'],'pagenumber'=>$pageNo,'totalpages'=>$totalpages,'alias'=>$row['expenses_alias'],'activa'=>$avtivea);} return $result;}else return 0;
		}else return 0;
}
function dasboarddet($pageNo="all",$emp_id="",$emp_name="",$dep="",$toal_advances="",$total_expenses="",$avl_balance="",$loginalias=""){ global $mr_con;
	$loginalias=$_SESSION['ec_user_alias'];
	$condition="";
	if($emp_id!="")$condition.=" employee_id LIKE '%".$emp_id."%' AND ";
	if($emp_name!="")$condition.=" name LIKE '%".$emp_name."%' AND ";
	if($dep!="")$condition.=" department_alias ='".$dep."' AND ";
	$chapp=checkApproval($loginalias);
	if($chapp>0){
		$rec=mysqli_query($mr_con,"SELECT count(e.id) FROM ec_employee_master e,ec_emprole r WHERE e.role_alias = r.role_alias AND r.role_stat <> 1 AND $condition e.department_alias IN (SELECT approval_dep FROM ec_expense_approvals d WHERE d.approver='$loginalias' AND d.flag=0) AND e.flag =0");
	}else{
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_employee_master WHERE $condition employee_alias='$loginalias' AND flag=0");
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
		if($chapp>0){
			$rec=mysqli_query($mr_con,"SELECT name, employee_id, employee_alias, department_alias FROM ec_employee_master e,ec_emprole r WHERE e.role_alias = r.role_alias AND r.role_stat <> 1 AND $condition e.department_alias IN (SELECT approval_dep FROM ec_expense_approvals d WHERE d.approver='$loginalias' AND d.flag=0) AND e.flag =0");
		}else{
			$rec=mysqli_query($mr_con,"SELECT name, employee_id, employee_alias, department_alias FROM ec_employee_master WHERE $condition employee_alias='$loginalias' AND flag=0");
		}
		if($rec->num_rows>0){while($row = $rec->fetch_assoc()){$result[]=array('employee_alias'=>$row['employee_alias'],'name'=>$row['name'],'employee_id'=>$row['employee_id'],'department_alias'=>$row['department_alias'],'pagenumber'=>$pageNo,'totalpages'=>$totalpages);} return $result;}else return 0;
	}else return 0;
}

function advancefullView($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT report,employee_alias, request_amount, total_amount, request_id, approved_by, requested_date, advance_alias, approval_level FROM ec_advances WHERE advance_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){
			$result[]=array('employee_alias'=>$row['employee_alias'],'request_id'=>$row['request_id'],'request_amount'=>$row['request_amount'],'total_amount'=>$row['total_amount'],'requested_date'=>$row['requested_date'],'approved_by'=>$row['approved_by'],'approval_level'=>exlevelsName($row['approval_level']),'approval_level1'=>$row['approval_level'],'advance_alias'=>$row['advance_alias'],'report'=>$row['report']);
			}
		return $result;
	}else return 0;
}
function expensefullView($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT utr_num,report,bill_number,po_gnr, employee_alias,period_of_visit_from,period_of_visit_to,places_of_visit,purpose,total_tour_expenses,requested_date,expenses_alias,approval_level,reimbursement_amount FROM ec_expenses WHERE expenses_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){
			$result[]=array('utr_num'=>$row['utr_num'],'bill_number'=>$row['bill_number'],'po_gnr'=>$row['po_gnr'],'employee_alias'=>$row['employee_alias'],'period_of_visit_from'=>$row['period_of_visit_from'],'period_of_visit_to'=>$row['period_of_visit_to'],'places_of_visit'=>$row['places_of_visit'],'purpose'=>$row['purpose'],'total_tour_expenses'=>$row['total_tour_expenses'],'requested_date'=>$row['requested_date'],'expenses_alias'=>$row['expenses_alias'],'approval_level'=>$row['approval_level'],'report'=>$row['report'],'reimbursement_amount'=>$row['reimbursement_amount']);
			}
		return $result;
	}else return 0;
} 
function ec_conveyance($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,document_link,created_date,dpr_number,ticket_alias FROM ec_conveyance WHERE expenses_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=array('expenses_alias'=>$row['expenses_alias'],'date_of_travel'=>$row['date_of_travel'],'mode_of_travel'=>$row['mode_of_travel'],'from_place'=>$row['from_place'],'to_place'=>$row['to_place'],'amount'=>$row['amount'],'alias'=>$row['alias'],'document_link'=>$row['document_link'],'created_date'=>$row['created_date'],'dpr_number'=>$row['dpr_number'],'ticket_alias'=>$row['ticket_alias']);}
		return $result;
	}else return 0;
}
function ec_localconveyance($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,created_date,zone_alias,state_alias,district_alias,bucket,capacity,quantity,km,dpr_number,ticket_alias FROM ec_localconveyance WHERE expenses_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=array('expenses_alias'=>$row['expenses_alias'],'date_of_travel'=>$row['date_of_travel'],'mode_of_travel'=>$row['mode_of_travel'],'from_place'=>$row['from_place'],'to_place'=>$row['to_place'],'amount'=>$row['amount'],'alias'=>$row['alias'],'created_date'=>$row['created_date'],'zone_alias'=>$row['zone_alias'],'state_alias'=>$row['state_alias'],'district_alias'=>$row['district_alias'],'bucket'=>$row['bucket'],'capacity'=>$row['capacity'],'quantity'=>$row['quantity'],'km'=>$row['km'],'dpr_number'=>$row['dpr_number'],'ticket_alias'=>$row['ticket_alias']);}
		return $result;
	}else return 0;
}
function ec_lodging($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT expenses_alias,type_of_stay,check_in,check_out,hotel_name,amount,alias,document_link,created_date,zone_alias,state_alias,district_alias,dpr_number,ticket_alias FROM ec_lodging WHERE  expenses_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=array('expenses_alias'=>$row['expenses_alias'],'type_of_stay'=>$row['type_of_stay'],'check_in'=>$row['check_in'],'check_out'=>$row['check_out'],'hotel_name'=>$row['hotel_name'],'amount'=>$row['amount'],'alias'=>$row['alias'],'document_link'=>$row['document_link'],'created_date'=>$row['created_date'],'zone_alias'=>$row['zone_alias'],'state_alias'=>$row['state_alias'],'district_alias'=>$row['district_alias'],'dpr_number'=>$row['dpr_number'],'ticket_alias'=>$row['ticket_alias']);}
		return $result;
	}else return 0;
}
function ec_boarding($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT expenses_alias,check_in,check_out,state,amount,alias,created_date,zone_alias,state_alias,district_alias,dpr_number,ticket_alias FROM ec_boarding WHERE expenses_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=array('expenses_alias'=>$row['expenses_alias'],'check_in'=>$row['check_in'],'check_out'=>$row['check_out'],'state'=>$row['state'],'amount'=>$row['amount'],'alias'=>$row['alias'],'created_date'=>$row['created_date'],'zone_alias'=>$row['zone_alias'],'state_alias'=>$row['state_alias'],'district_alias'=>$row['district_alias'],'dpr_number'=>$row['dpr_number'],'ticket_alias'=>$row['ticket_alias']);}
		return $result;
	}else return 0;
}
function ec_other_expenses($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT expenses_alias,description,amount,checked_date,alias,document_link,created_date,dpr_number,ticket_alias FROM ec_other_expenses WHERE  expenses_alias='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=array('expenses_alias'=>$row['expenses_alias'],'description'=>$row['description'],'amount'=>$row['amount'],'checked_date'=>$row['checked_date'],'alias'=>$row['alias'],'document_link'=>$row['document_link'],'created_date'=>$row['created_date'],'dpr_number'=>$row['dpr_number'],'ticket_alias'=>$row['ticket_alias']);}
		return $result;
	}else return 0;
}
function getRemarks($fv1,$fv2){ global $mr_con;
	$rec=$mr_con->query("SELECT remarks, remarked_by, remarked_on FROM ec_remarks WHERE item_alias='$fv1' AND module='$fv2' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=array('remarks'=>$row['remarks'],'remarked_by'=>$row['remarked_by'],'remarked_on'=>$row['remarked_on']);}
		return $result;
	}else return 0;
}
function approvelLevelCheck($fv1,$fv2){ global $mr_con;
	$rec=$mr_con->query("SELECT id FROM ec_expense_approvals WHERE approver = '$fv1' AND approval_level ='$fv2' AND flag=0");
	if($rec->num_rows>0){return 1;}else return 0;
}
function approveldesig($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT approval_dep FROM ec_expense_approvals WHERE approver='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=$row['approval_dep'];}
		return $result;
	}else return 0;
}
function approvelvl($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT approval_level FROM ec_expense_approvals WHERE approver='$fv1' AND flag=0");
	if($rec->num_rows>0){
		while($row = $rec->fetch_assoc()){$result[]=$row['approval_level'];}
		return $result;
	}else return 0;
}
function checkApproval($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT id FROM ec_expense_approvals WHERE approver = '$fv1' AND flag=0");
	if($rec->num_rows>0){return 1;}else return 0;
}
function expenseApprovalLevels($fv1){ global $mr_con;
	$fv2=employeeDetails('department_alias',$fv1);
	$rec=$mr_con->query("SELECT approval_level FROM ec_expense_approvals WHERE approver ='$fv1' AND flag=0 ORDER BY approval_level DESC");
	if($rec->num_rows>0){$row = $rec->fetch_assoc();return $row['approval_level'];}else return 0;
}
function approvelLevelemplist($fv1,$fv2){ global $mr_con;
	$rec=$mr_con->query("SELECT approver FROM ec_expense_approvals WHERE approval_dep ='$fv1' AND approval_level ='$fv2' AND flag=0");
	if($rec->num_rows>0){$row = $rec->fetch_assoc();return $row['approver'];}else return 0;
}
function alias($alias,$tb,$col,$retrive){ global $mr_con;
	$sql = $mr_con->query("SELECT $retrive FROM $tb WHERE $col='$alias' AND flag=0");
	if(mysqli_num_rows($sql)){
		$row = mysqli_fetch_array($sql);
		return $row[$retrive];
	}else return "NA";
}
function moneyFormatIndia($num){
	$explrestunits = "" ;
	if(is_float($num)) {
		$thecash1 = sprintf("%01.2f", $num);
		$exp = explode('.',$thecash1);
		$exp1 = $exp[0];
		if(strlen($exp1)>3){
			$lastthree = substr($exp1, strlen($exp1)-3, strlen($exp1));
			$restunits = substr($exp1, 0, strlen($exp1)-3); // extracts the last three digits
			$restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
			$expunit = str_split($restunits, 2);
			for($i=0; $i<sizeof($expunit); $i++){
				// creates each of the 2's group and adds a comma to the end
				if($i==0){$explrestunits .= (int)$expunit[$i].",";} // if is first value , convert into integer
				else{$explrestunits .= $expunit[$i].",";}
			}$thecash = $explrestunits.$lastthree.".".$exp[1];
		}else{$thecash = $exp1.".".$exp[1];}
	
	} else {
		if(strlen($num)>3){
			$lastthree = substr($num, strlen($num)-3, strlen($num));
			$restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
			$restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
			$expunit = str_split($restunits, 2);
			for($i=0; $i<sizeof($expunit); $i++){
				// creates each of the 2's group and adds a comma to the end
				if($i==0){$explrestunits .= (int)$expunit[$i].",";} // if is first value , convert into integer
				else{$explrestunits .= $expunit[$i].",";}
			}$thecash = $explrestunits.$lastthree;
		}else{$thecash = $num;}
	}
	
	return $thecash; // writes the final format where $currency is the currency symbol.
}
function getalltransactions($reqtype="",$pageNo,$idd,$requestID,$requestDate,$requestamt,$reqStat,$loginUser){ global $mr_con;
	$loginUser=$_SESSION['ec_user_alias'];
	if(checkApproval($_SESSION['ec_user_alias'])==0 && $idd !=$loginUser){return "2";}
	else if(checkApproval($_SESSION['ec_user_alias'])==1){
		$condition=$condition1="";
		if($requestID!=""){
			$condition.="request_id LIKE '%".$requestID."%' AND ";
			$condition1.="bill_number LIKE '%".$requestID."%' AND ";
		}
		if($requestDate!=""){
			$condition.="requested_date ='".$requestDate."' AND ";
			$condition1.="requested_date ='".$requestDate."' AND ";
		}
		if($requestamt!=""){
			$condition.="request_amount LIKE '%".$requestamt."%' AND ";
			$condition1.="(total_tour_expenses LIKE '%".$requestamt."%' AND ";
		}
		if($reqStat!=""){
			$condition.="approval_level ='".$reqStat."' AND ";
			$condition1.="approval_level ='".$reqStat."' AND ";
		}
		if($reqtype==0 && $reqtype!=""){$condition1="bill_number = '0000' AND ";}
		elseif($reqtype==1 && $reqtype!=""){$condition="request_id = '0000' AND ";}
		$rec=mysqli_query($mr_con,"(SELECT count(id) as counti  FROM ec_advances WHERE employee_alias='$idd' AND $condition flag=0) UNION (SELECT count(id) as counti FROM ec_expenses WHERE employee_alias='$idd' AND $condition1 flag=0)");
	if($rec){
		$rec_count=0;
		while($row=mysqli_fetch_array($rec,MYSQLI_ASSOC)){$rec_count+=$row['counti'];}
		$rec_limit = 1;
		if(is_float($rec_count/$rec_limit)){$totalpages=round($rec_count/$rec_limit)+1;}else{$totalpages=$rec_count/$rec_limit;}
		if($pageNo!="all"){$page = ($pageNo-1);
		if($page<0){$page=0;}
		$offset = $rec_limit * $page ;}
		else{$page = 0;$offset = $rec_limit * $page ;}
		$left_rec=$rec_count-($page*$rec_limit);
		$rec=mysqli_query($mr_con,"(SELECT request_id as requestId,requested_date as rd,request_amount as amt,total_amount as tamt,approval_level as al,advance_alias as alias FROM ec_advances WHERE employee_alias='$idd' AND $condition flag=0 ORDER BY request_date) UNION (SELECT bill_number as requestId,requested_date as rd,total_tour_expenses as amt,flag as tamt,approval_level as al,expenses_alias as alias FROM ec_expenses WHERE employee_alias='$idd' AND $condition1 flag=0 ORDER BY request_date)");
		if($rec->num_rows>0){while($row = $rec->fetch_assoc()){$result[]=array('requestId'=>$row['requestId'],'rd'=>$row['rd'],'amt'=>$row['amt'],'tamt'=>$row['tamt'],'al'=>$row['al'],'alias'=>$row['alias'],'pagenumber'=>$pageNo,'totalpages'=>$totalpages);} return $result;}else return 0;
		}else return 0;
	}
	else{return "2";}
}
function requesttype($fv1,$fv2){ global $mr_con;
	$rec=$mr_con->query("SELECT id FROM ec_advances WHERE request_id='$fv1' AND advance_alias='$fv2' AND flag=0");
	$rec1=$mr_con->query("SELECT id FROM ec_expenses WHERE bill_number='$fv1' AND expenses_alias='$fv2' AND flag=0");
	if($rec->num_rows>0) return "advance";
	else if($rec1->num_rows>0) return "expense";
	else return "NA"; 
}
function selflodgingamount($fv1,$fv2,$fv3,$fv4){ global $mr_con;
	$fv2=grade($fv2);
	$fv1="lodging_allowances_".$fv1;
	$rec=$mr_con->query("SELECT $fv1 FROM ec_daily_allowances WHERE grade ='$fv2' AND flag=0");
	if($rec->num_rows>0){
		$row = $rec->fetch_assoc();
		if($row[$fv1]!="ACT"){
			$date1 = new DateTime($fv3);
			$date2 = new DateTime($fv4);
			if($date1<=$date2){
				$diff = ($date2->diff($date1)->format("%a"))+1;
				return (($row[$fv1]/2)*$diff);
			}else{return 0;}
		}
		else{return "";}
		
	}
	else return "";
}
function bordaingamount($fv1,$fv2,$fv3,$fv4){ global $mr_con;
	$fv2=grade($fv2);
	$fv1="boarding_allowances_".$fv1;
	$rec=$mr_con->query("SELECT $fv1 FROM ec_daily_allowances WHERE grade ='$fv2' AND flag=0");
	if($rec->num_rows>0){
		$row = $rec->fetch_assoc();
		if($row[$fv1]!="ACT"){
			$date1 = new DateTime($fv3);
			$date2 = new DateTime($fv4);
			if($date1<=$date2){
				$diff = ($date2->diff($date1)->format("%a"))+1;
				return (($row[$fv1])*$diff);
			}else{return 0;}
		}
		else{return "";}
		
	}
	else return "";
}
function deleteitems($fv1,$fv2){ global $mr_con;
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
function checkspldep($fv1){ global $mr_con;
	$temp1=alias($fv1,'ec_employee_master','employee_alias','department_alias');	
	$temp2=alias($temp1,'ec_department','department_alias','spl');
	return $temp2;
}

/*start- get the role_stat from db */
function getRoleStat($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT role_stat FROM ec_emprole WHERE flag=0 AND role_alias='$fv1'");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){
		$result = $row['role_stat'];
		}
	return $result;
	}else return 0;
}
/*end- get the role_stat from db */

/*start- get the zones from db */
function getZones(){ global $mr_con;
	$rec=$mr_con->query("SELECT * FROM ec_zone WHERE flag=0");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('zone_alias'=>$row['zone_alias'],'zone_name'=>$row['zone_name']);}
	return $result;
	}else return 0;
}
/*end- get the zones from db */

/*start- get the zones from db */
function getCapacity(){ global $mr_con;
	$rec=$mr_con->query("SELECT product_description,product_alias FROM ec_product WHERE flag=0");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('product_alias'=>$row['product_alias'],'product_description'=>$row['product_description']);}
	return $result;
	}else return 0;
}
/*end- get the zones from db */

function getNames($fv1,$fv2){ global $mr_con;
	$where = ($fv2=='ec_zone' ? 'zone_alias' : ($fv2=='ec_state' ? 'state_alias' : 'district_alias'));
	$get = ($fv2=='ec_zone' ? 'zone_name' : ($fv2=='ec_state' ? 'state_name' : 'district_name'));
	$rec=$mr_con->query("SELECT $get as res FROM $fv2 WHERE flag=0 AND $where = '$fv1'");
	if($rec->num_rows>0){
	$row =$rec->fetch_assoc();
	return $res = $row['res'];
	}else return 0;
}

function getArea($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT area FROM ec_district WHERE flag=0 AND district_alias = '$fv1'");
	if($rec->num_rows>0){
	$row =$rec->fetch_assoc();
	return $res = $row['area'];
	}else return -1;
}

function getWeights($fv1,$fv2){ global $mr_con;
	$get = ($fv2=='weight' ? 'weight' : 'product_description');
	$rec=$mr_con->query("SELECT $get as res FROM ec_product WHERE flag=0 AND product_alias = '$fv1'");
	if($rec->num_rows>0){
	$row =$rec->fetch_assoc();
	return $res = $row['res'];
	}else return 0;
}
function getTicket($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT ticket_id,ticket_alias FROM ec_tickets WHERE flag=0 AND service_engineer_alias = '$fv1'");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('ticket_id'=>$row['ticket_id'],'ticket_alias'=>$row['ticket_alias']);}
	return $result;
	}else return 0;
}
function getTicketName($fv1){ global $mr_con;
	if($fv1=='1'){ return 'Others'; }
	else{
		$rec=$mr_con->query("SELECT ticket_id FROM ec_tickets WHERE ticket_alias = '$fv1' AND flag=0");
		if($rec->num_rows>0){
			$row = $rec->fetch_assoc();
			$result=$row['ticket_id'];
			return $result;
		}else return '';
	}
}

/*start- get the states from db */
function getStates($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT * FROM ec_state WHERE flag=0 AND zone_alias='$fv1' ORDER BY state_name");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('state_alias'=>$row['state_alias'],'state_name'=>$row['state_name']);}
	return $result;
	}else return 0;
}
/*end- get the zones from db */

/*start- get the states from db */
function getDistricts($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT * FROM ec_district WHERE flag=0 AND state_alias='$fv1' ORDER BY district_name");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('district_alias'=>$row['district_alias'],'district_name'=>$row['district_name']);}
	return $result;
	}else return 0;
}
/*end- get the zones from db */


function noofDays($fv1,$fv2){
	$date1=date_create($fv1);
	$date2=date_create($fv2);
	$diff=date_diff($date1,$date2);
	echo ($diff->format("%a")+1)." Days";
}

/*function depSpl($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT spl FROM ec_department d,ec_employee_master e WHERE d.department_alias = e.department_alias AND e.employee_alias = '$fv1'");
	if($rec->num_rows>0){
	$row = $rec->fetch_assoc();
	$result=$row['spl'];
	return $result;
	}else return 0;
}*/


/*function deleteSingleitem($fv1,$fv2,$fv3){ global $mr_con;
	if($fv3=="lc"){
		$rec=$mr_con->query("DELETE FROM ec_localconveyance WHERE alias='$fv2'");
		if($rec) return "1";else return "0";
	}else if($fv3=="con"){
		$rec=$mr_con->query("DELETE FROM ec_conveyance WHERE alias='$fv2'");
		if($rec) return "1";else return "0";
		
	}else if($fv3=="ld"){
		$rec=$mr_con->query("DELETE FROM ec_lodging WHERE alias='$fv2'");
		if($rec) return "1";else return "0";
	
	}else if($fv3=="bd"){
		$rec=$mr_con->query("DELETE FROM ec_boarding WHERE alias='$fv2'");
		if($rec) return "1";else return "0";
	
	}else if($fv3=="ot"){
		$rec=$mr_con->query("DELETE FROM ec_other_expenses WHERE alias='$fv2'");
		if($rec) return "1";else return "0";
	} else {
		
	}
}*/
function deleteSingleitem($fv1,$fv2,$fv3){ global $mr_con;
	if($fv3=="lc"){
		$get_sql = mysqli_query($mr_con,"SELECT expenses_alias,amount FROM ec_localconveyance WHERE alias='$fv2'");
		$row = mysqli_fetch_array($get_sql);
		$ealias = $row['expenses_alias'];
		$eamount = $row['amount'];
		$get_amt_sqll = mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias ='".$ealias."' AND flag=0");
		$getamt_rss = mysqli_fetch_array($get_amt_sqll);
		$total_amt = $getamt_rss['total_tour_expenses'];	
		$diff_amt = $total_amt-$eamount;
		$rec=$mr_con->query("DELETE FROM ec_localconveyance WHERE alias='$fv2'");
		if($rec) {		
		$update_sql = mysqli_query($mr_con,"UPDATE ec_expenses SET total_tour_expenses = '".$diff_amt."'  WHERE expenses_alias ='".$ealias."' AND flag=0");
		return "1";}else return "0";
	}else if($fv3=="con"){
		$get_sql = mysqli_query($mr_con,"SELECT expenses_alias,amount FROM ec_conveyance WHERE alias='$fv2'");
		$row = mysqli_fetch_array($get_sql);
		$ealias = $row['expenses_alias'];
		$eamount = $row['amount'];
		$get_amt_sqll = mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias ='".$ealias."' AND flag=0");
		$getamt_rss = mysqli_fetch_array($get_amt_sqll);
		$total_amt = $getamt_rss['total_tour_expenses'];	
		$diff_amt = $total_amt-$eamount;
		$rec=$mr_con->query("DELETE FROM ec_conveyance WHERE alias='$fv2'");
		if($rec) {		
		$update_sql = mysqli_query($mr_con,"UPDATE ec_expenses SET total_tour_expenses = '".$diff_amt."'  WHERE expenses_alias ='".$ealias."' AND flag=0");
		return "1";}else return "0";
		
	}else if($fv3=="ld"){
		$get_sql = mysqli_query($mr_con,"SELECT expenses_alias,amount FROM ec_lodging WHERE alias='$fv2'");
		$row = mysqli_fetch_array($get_sql);
		$ealias = $row['expenses_alias'];
		$eamount = $row['amount'];
		$get_amt_sqll = mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias ='".$ealias."' AND flag=0");
		$getamt_rss = mysqli_fetch_array($get_amt_sqll);
		$total_amt = $getamt_rss['total_tour_expenses'];	
		$diff_amt = $total_amt-$eamount;
		$rec=$mr_con->query("DELETE FROM ec_lodging WHERE alias='$fv2'");
		if($rec) {		
		$update_sql = mysqli_query($mr_con,"UPDATE ec_expenses SET total_tour_expenses = '".$diff_amt."'  WHERE expenses_alias ='".$ealias."' AND flag=0");
		return "1";}else return "0";
	
	}else if($fv3=="bd"){
		$get_sql = mysqli_query($mr_con,"SELECT expenses_alias,amount FROM ec_boarding WHERE alias='$fv2'");
		$row = mysqli_fetch_array($get_sql);
		$ealias = $row['expenses_alias'];
		$eamount = $row['amount'];
		$get_amt_sqll = mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias ='".$ealias."' AND flag=0");
		$getamt_rss = mysqli_fetch_array($get_amt_sqll);
		$total_amt = $getamt_rss['total_tour_expenses'];	
		$diff_amt = $total_amt-$eamount;
		$rec=$mr_con->query("DELETE FROM ec_boarding WHERE alias='$fv2'");
		if($rec) {		
		$update_sql = mysqli_query($mr_con,"UPDATE ec_expenses SET total_tour_expenses = '".$diff_amt."'  WHERE expenses_alias ='".$ealias."' AND flag=0");
		return "1";}else return "0";
	}else if($fv3=="ot"){
		$get_sql = mysqli_query($mr_con,"SELECT expenses_alias,amount FROM ec_other_expenses WHERE alias='$fv2'");
		$row = mysqli_fetch_array($get_sql);
		$ealias = $row['expenses_alias'];
		$eamount = $row['amount'];
		$get_amt_sqll = mysqli_query($mr_con,"SELECT total_tour_expenses FROM ec_expenses WHERE expenses_alias ='".$ealias."' AND flag=0");
		$getamt_rss = mysqli_fetch_array($get_amt_sqll);
		$total_amt = $getamt_rss['total_tour_expenses'];	
		$diff_amt = $total_amt-$eamount;
		$rec=$mr_con->query("DELETE FROM ec_other_expenses WHERE alias='$fv2'");
		if($rec) {		
		$update_sql = mysqli_query($mr_con,"UPDATE ec_expenses SET total_tour_expenses = '".$diff_amt."'  WHERE expenses_alias ='".$ealias."' AND flag=0");
		return "1";}else return "0";
	} else {
		
	}
}

function empDeptdrop($appr_dept){ global $mr_con;
	$check_arr=implode("','",explode(',',$appr_dept));
	/*$exp_arr = explode(',',$appr_dept);
	$check_arr = '';
	$carr = count($exp_arr);
	$i=1;
	foreach($exp_arr as $exp){
		$check_arr .= "'";
		$check_arr .= $exp;
		$check_arr .= "'";
		if($carr != $i)$check_arr .= ", ";
		$i++;
	}*/
	$rec=$mr_con->query("SELECT employee_alias,name FROM ec_employee_master WHERE flag=0 AND department_alias IN ('$check_arr') ORDER BY name");
	if($rec->num_rows>0){
	while($row = $rec->fetch_assoc()){$result[]=array('name'=>$row['name'],'alias'=>$row['employee_alias']);}
	return $result;
	}else return 0;
}

function getDprCat($fv1){ global $mr_con;
	$rec=$mr_con->query("SELECT category FROM ec_dpr_category WHERE flag=0 AND category_alias = '$fv1'");
	if($rec->num_rows>0){
	$row = $rec->fetch_assoc();
	$result=$row['category'];
	return $result;
	}else return 0;
}

?>