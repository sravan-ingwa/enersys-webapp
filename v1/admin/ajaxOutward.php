<?php
include('mysql.php');
include('functions.php');
if($_REQUEST['ref']){
	$ref = $_REQUEST['ref'];
	$tt = $_REQUEST['tt'];
	if($ref=='invent'){
		$sql = mysql_query("SELECT custName,siteName,district FROM ss_tickets WHERE ticketId='$tt'");
		$row = mysql_fetch_array($sql);
		$sql1 = mysql_query("SELECT customerCode FROM ss_customer_details WHERE customerName='$row[custName]'");
		$row1 = mysql_fetch_array($sql1);
		$HTML = $row1['customerCode'].",".$row['siteName'].",".districtsGetName($row['district']);
	}else{
		$sql = mysql_query("SELECT toWh,stockCategory,itemCode,item,qty FROM ss_material_inward WHERE mrfNumber='$tt'");
		while($row = mysql_fetch_array($sql)){
			$sql1 = mysql_query("SELECT qty FROM ss_material_outward WHERE mrfNumber='$tt' AND itemCode='$row[itemCode]' AND flag=0");
			$qty=0;while($row1 = mysql_fetch_array($sql1)){$qty+=$row1['qty'];}
				if($row['qty'] > $qty){
					$toWh = $row['toWh']; $item = $row['item'];
					$stock .= "<option value='".$row['stockCategory']."'>".stockGetName($row['stockCategory'])."</option>";
					$itemCode .= "<option value='".$row['itemCode']."'>".itemGetDesc($row['itemCode'])."</option>";
				}
			}
		$HTML = $stock.",".whareHouseGetName($toWh).",".$item.",".$itemCode;
	}
echo $HTML;
}
?>