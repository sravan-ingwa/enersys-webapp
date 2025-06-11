<?php
include('mysql.php');
include('functions.php');
$esca = $_REQUEST['id'];
$ref = $_REQUEST['ref'];
if($ref=='Esca2TT'){
	$res = mysql_query("SELECT ticketId FROM ss_tickets WHERE natureOfActivity='$esca' AND checkStat > 2 AND flag='0'");
	$HTML = "<option value=''>Select TT Number</option>"; $arr = array();
	while($row = mysql_fetch_array($res)){
		$res1 = mysql_query("SELECT ttNumber FROM ss_esca_expense WHERE flag='0'");
		while($row1 = mysql_fetch_array($res1)){ $arr[] = $row1['ttNumber']; }
		if(!in_array($row['ticketId'],$arr)){$HTML .= "<option value='$row[ticketId]'>$row[ticketId]</option>";}
	}
}elseif($ref=='escaZC'){
	$res = mysql_query("SELECT zone,circle FROM ss_employee_details WHERE id='$esca' AND flag='0'");
	$row = mysql_fetch_array($res);
	$HTML = zoneGetName($row['zone']).",,".circleGetName($row['circle']);
}else{
	$expo = explode(',',$esca);
	foreach($expo as $e){
		$res = mysql_query("SELECT numBanks,natureOfActivity FROM ss_tickets WHERE ticketId='$e' AND flag='0'");
		$row = mysql_fetch_array($res);
		$res1=mysql_query("SELECT amount,unit FROM ss_contract_price WHERE activity='$row[natureOfActivity]' AND flag='0'");
			$row1 = mysql_fetch_array($res1);
				if($row1['unit']=='perBank'){$HTML += $row['numBanks']*$row1['amount'];}
				elseif($row1['unit']=='perSite'){$HTML += $row1['amount'];}
				else{ $HTML += 0;}
		}
	}
echo $HTML;
?>