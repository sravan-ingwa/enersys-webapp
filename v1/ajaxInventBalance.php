<?php
include('mysql.php');
$ref = $_REQUEST['ref'];
if($ref=='invBal'){
	$wh = $_REQUEST['wh']; $itm = $_REQUEST['itm']; $stk = $_REQUEST['stk']; $z = $_REQUEST['z'];
	if($itm == '' && $stk == ''){ $subQuery = ""; }
	elseif($itm == '' &&  $stk != ''){ $subQuery = "stockCategory = '$stk' AND"; }
	elseif($itm != '' &&  $stk == ''){ $subQuery = "itemCode = '$itm' AND"; }
	else{ $subQuery = "itemCode = '$itm' AND stockCategory = '$stk' AND"; }
	$res1 = mysql_query("SELECT qty FROM ss_material_inward WHERE ".$subQuery." toWh='$wh' AND flag='0'");
	if(mysql_num_rows($res1)){ while($row1=mysql_fetch_array($res1)){ $i1+=$row1['qty']; }}else{$i1=0;}
	$res2 = mysql_query("SELECT qty FROM ss_material_outward WHERE ".$subQuery." fromWh='$wh' AND flag='0'");
	if(mysql_num_rows($res2)){ while($row2=mysql_fetch_array($res2)){ $i2+=$row2['qty']; }}else{$i2=0;}
	$HTML = $i1.", ".$i2.", ".($i1-$i2).", ".$z;
}elseif($ref=='invcRef'){
	$invcNum = $_REQUEST['invcNum'];
	$query=mysql_query("SELECT id FROM ss_material_inward WHERE invoiceNumber = '$invcNum' AND flag='0'");
	if(mysql_num_rows($query)>0){ $HTML = "Invoice Number is Already Avalilable! Please try with other value"; }else{ $HTML = ""; }
}
echo $HTML;
?>