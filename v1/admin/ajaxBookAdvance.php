<?php
include('mysql.php');
include('functions.php');
if(date('d')>=1&&date('d')<=15){$fy="F1";}else{$fy="F2";}
$my=date('M-Y');

$sqla = mysql_query("SELECT * FROM ss_employee_details WHERE id='$_REQUEST[val]'");
$rowa = mysql_fetch_array($sqla);

$sql = mysql_query("SELECT totalBalance FROM ss_el_expense WHERE empId='$_REQUEST[val]'");
if(mysql_num_rows($sql)>0){
	$row = mysql_fetch_array($sql);
	//if($fy=="F1"){$fcv=$row['f1Balance'];}else{$fcv=$row['f2Balance'];}
	$fcv = $row['totalBalance'];
}else{$fcv="0";}
$HTML = $rowa['employeeName'].",,".$fcv;
echo $HTML;
?>
