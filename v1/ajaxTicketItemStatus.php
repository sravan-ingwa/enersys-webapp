<?php include('mysql.php'); include('functions.php');
$item = $_REQUEST['item']; $circle = $_REQUEST['circle'];
$sql = mysql_query("SELECT whCode FROM ss_warehouse_code WHERE circle='$circle' AND flag='0'");
	if(mysql_num_rows($sql)>0){ while($row=mysql_fetch_array($sql)){$wh .= whareHouseGetID($row['whCode']).",";}
	$wh = implode("|",explode(",",substr(trim($wh), 0, -1)));
$res = mysql_query("SELECT * FROM ss_material_inward WHERE toWh RLIKE '$wh' AND itemCode RLIKE '".itemGetID($item)."' AND stockCategory='".stockGetID('GS')."' AND flag='0'");
	if(mysql_num_rows($res)>0){$a = 'Available';}
$res1 = mysql_query("SELECT * FROM ss_material_outward WHERE fromWh RLIKE '$wh' AND itemCode RLIKE '".itemGetID($item)."' AND stockCategory='".stockGetID('GS')."' AND flag='0'");
	if(mysql_num_rows($res1)>0){$a = 'Available';}
if($a){ $HTML = $a; }else{ $HTML = 'Pending From factory';}
	}else{$HTML = "No WareHouse in this ".circleGetName($circle)." Circle";}
//$HTML = stockGetID('GS');
echo $HTML;
?>