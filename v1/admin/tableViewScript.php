<?php
function hix($hx,$hx1){
	if($hx=='1'){if (strpos($hx1, '@') !== false){return "class='hidden-xs hidden-sm nocap'";}else{return "class='hidden-xs hidden-sm'";}}
	else{if(strpos($hx1, '@') !== false){return "class='nocap'";}}
}
function inptfield($fv1,$fv2){
	if($fv2==0){$fv2="placeholder='Search...'";}else{$fv2="";}
	switch ($fv1) {
		case errorMessage: return ("<select onchange='xyz()' name='".$fv1."'><option value=''></option>".ticketStat()."</select>");break;
		case tat: return ("<select onchange='xyz()' name='".$fv1."'><option value=''></option><option value='TAT-1'>TAT-1</option><option value='TAT-2'>TAT-2</option><option value='TAT-3'>TAT-3</option></select>");break;
		case ticketStatus: return ("<select onchange='xyz()' name='".$fv1."'><option value=''></option> <option value='Open'>Open</option><option value='Visited'>Visited</option><option value='Reject'>Reject</option><option value='Closed'>Closed</option></select>");break;
		case 'stat': return ("<select onchange='xyz()' name='".$fv1."'><option value=''></option>".ExpenseStatus(menuName($_REQUEST['x'],'tbName'))."</select>");break;
		case mrfStatus: return ("<select onchange='xyz()' name='".$fv1."'><option value=''></option><option value='Open'>Open</option><option value='Closed'>Closed</option></select>");break;
		case dateOfTransation:
		case createdDate: return ("<input type='text' id='datepicker' ".$fv2." class='singleDateEnd form-control' name='".$fv1."'>");
		default: return ("<input type='text' ".$fv2." onkeyup='xyz()' name='".$fv1."'>");
	}
}
$tb= menuName($_REQUEST['x'],"tbName");
$tblHead_query = mysql_query("SELECT colName,colRef,pSpl FROM ss_col_ref WHERE tbName='$tb' AND pTable='0' ORDER BY ordering");
if(mysql_num_rows($tblHead_query)>0){while($tblHead_row=mysql_fetch_array($tblHead_query)){$colName[]=$tblHead_row['colName'];$colref[]=$tblHead_row['colRef'];$pSpl[]=$tblHead_row['pSpl'];}}
$result="<table class='table table-bordered'><thead><tr align='center' class='blue cust'>";
for($abc=0;$abc<count($colref);$abc++){$result.="<th ".hix($pSpl[$abc],"")." >".$colref[$abc]."</th>";}
$result.='<th width="100px">Options</th></tr><tr class="nmg">';
$result.='<input type="hidden" value="'.$_REQUEST['x'].'" name="x">';
for($abc=0;$abc<count($colref);$abc++){$result.="<td ".hix($pSpl[$abc],"")." >".inptfield($colName[$abc],$abc)."</td>";}
$result.='<td><p class="sser"><i class="glyphicon glyphicon-search"></i></p></td></tr></thead><tbody class="sortdis">';
$result.='</tbody>';
$result.="</table>";
function ticketStat(){
//<option value=''>[Select]</option><option value='Ticket Inactive'>Ticket Inactive</option><option value='Site Not Visited'>Site Not Visited</option><option value='Zonal Approval Pending'>Zonal Approval Pending</option><option value='Zonal Rejected'>Zonal Rejected</option><option value='NHS Approval Pending'>NHS Approval Pending</option><option value='NHS Rejected'>NHS Rejected</option><option value='NHS Accepted'>NHS Accepted</option><option value='Ticket Closed'>Ticket Closed</option><option value='Rejection Cancelled'>Rejection Cancelled</option>
	$sql=mysql_query("SELECT errorMessage FROM ss_tickets WHERE flag=0 GROUP BY errorMessage ORDER BY checkStat");
	while($row = mysql_fetch_array($sql)){ $ret .= "<option value='".$row['errorMessage']."'>".$row['errorMessage']."</option>";  }
	return $ret;
}
function ExpenseStatus($a){
if($a == 'ss_book_advance'){ $arr = array("NHS Approval Pending","NHS Approved","Request Closed");}
elseif($a == 'ss_online_tickets'){ $arr = array("COO Approval Pending","","Ticket Registered");}
else{
	if($a == 'ss_book_expenses'){$b = 'Expense Approved';}
	elseif($a == 'ss_esca_expense'){$b = 'NHS Accepted';}
	$arr = array("COO Approval Pending","NHS Approval Pending",$b,"ESCA Expense Approved");
}
	$sql=mysql_query("SELECT stat FROM ".$a." WHERE flag=0 GROUP BY stat ORDER BY stat");
	while($row = mysql_fetch_array($sql)){ $ret .= "<option value='".$row['stat']."'>".$arr[$row['stat']]."</option>";  }
	return $ret;
}
?>
