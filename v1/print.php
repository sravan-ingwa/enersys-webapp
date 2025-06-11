<?php
include('functions.php');
$xx = $_REQUEST['x']; $yy = $_REQUEST['y'];
$sub = menuName($xx,"menu")." - ".$yy." - ".date("d-m-Y");

	$tableName= menuName($xx,"tbName");
	$menuName= menuName($xx,"menu");
	$query = mysql_query("SELECT colName,colRef FROM ss_col_ref WHERE tbName='$tableName' AND pView='0' ORDER BY ordering");
	if(mysql_num_rows($query)>0){$colName=array();$colref=array();
		while($row=mysql_fetch_array($query)){$colName[]=$row['colName'];$colref[]=$row['colRef'];}
		$query = mysql_query("SELECT * FROM $tableName WHERE id='".$yy."' AND  flag='0'");
		if(mysql_num_rows($query)>0){
			while($row=mysql_fetch_array($query)){
				for($af=0;$af<count($colName);$af++){
					if($row[$colName[$af]]!=""){
						$strContent[]=$colref[$af];
						$strContent1[]=refname($colref[$af],$row[$colName[$af]],$row['id']);
					}
				}
			}
		}
	}
$comp=mysql_query("SELECT * FROM ss_company_details WHERE status='active'");
$comprow=mysql_fetch_array($comp);
$strContentx="<img src=".$comprow['logo']." alt=".$comprow['compName']." width='150' style='display:inline-block;'>";
if($xx != '8865'){
$strContentx.="<h3 style='display:inline-block; vertical-align:top; float:right'>".strtoupper($menuName)."</h3>";
	$strContentx.="<table style='border-collapse:collapse;width:100%;' width='100%'>";
		$c=count($strContent);
		for($a=0;$a<$c;$a++){
			$strContentx.="<tr>";
			for($b=$a;$b<=$a+1;$b++){
				$strContentx.="<td style='padding:5px;text-align:justify; border:1px solid #000;'>
				<h4 style='display:block;color:#2a6496;font-weight:bold;margin:0 !important;padding:0 !important;'>".ucfirst($strContent[$b])."</h4>
				<p style='display:block;margin:0 !important;padding:0 !important;'>".ucfirst($strContent1[$b])."</p>
				</td>";
			}
			$a++;
			$strContentx.="</tr>";
		}
	$strContentx.="</table>";
}else{
	$strContentx.="<h3 style='display:inline-block; vertical-align:top; float:right'>TOUR BILL</h3>";
	$exp=mysql_query("SELECT * FROM $tableName WHERE id='".$yy."' AND  flag='0'");
	$fare=mysql_query("SELECT * FROM ss_book_expenses_fare WHERE refId='".$yy."' AND  flag='0'");
	$hotel=mysql_query("SELECT * FROM ss_book_expenses_hotel WHERE refId='".$yy."' AND  flag='0'");
	$local=mysql_query("SELECT * FROM ss_book_expenses_local WHERE refId='".$yy."' AND  flag='0'");
	$other=mysql_query("SELECT * FROM ss_book_expenses_other WHERE refId='".$yy."' AND  flag='0'");
	$expRow=mysql_fetch_array($exp);
	$tblStart = "<table style='border-collapse:collapse;width:100%;'>";
	$tblEnd ="</table>";
// Bill No and general info
	$strContentx .= $tblStart.strReplace("Bill Number", $expRow['billNo'],1).'<br>'.strReplace("Created Date", $expRow['createdDate'],1).$tblEnd.'<br>';
	$strContentx .= $tblStart;
	$strContentx .= '<tr>'.strReplace("Employee ID", employeeGetName($expRow['empId']),1).strReplace("Name Of The Employee", $expRow['nameOfTheEmp'],1).strReplace("Designation", designationGetName($expRow['designation']),1).'</tr>';
	$strContentx .= '<tr>'.strReplace("Period Of Visit From", $expRow['visitFromDate'],1).strReplace("Period Of Visit To", $expRow['visitToDate'],1).strReplace("Period", $expRow['period'],1).'</tr>';
	$strContentx .= '<tr>'.strReplace("No. Of Days", $expRow['noOfDays'],1).strReplace("Places Of Visit", $expRow['placesOfVisit'],1).strReplace("Purpose", $expRow['purpose'],1).'</tr>';
	$strContentx .= $tblEnd;
// Fare – INR	
	if(mysql_num_rows($fare)>0){$strContentx .="<h3>Fare INR :</h3>".$tblStart; }
	$k=1;while($fareRow=mysql_fetch_array($fare)){
		$strContentx .= '<tr>'.strReplace("Date Of Travel", $fareRow['dateOfTravel'],$k).strReplace("Mode Of Travel", $fareRow['modeOfTravel'],$k).strReplace("From", $fareRow['travelFrom'],$k).strReplace("To", $fareRow['travelTo'],$k).strReplace("Amount", $fareRow['amount'],$k).'</tr>';		
		$k++;}
	if(mysql_num_rows($fare)>0){$strContentx .= "<tr><td></td><td></td><td></td><td></td>".strReplace("Total", $expRow['fareINR'],$k)."</tr>".$tblEnd;}
// Hotel Bills
	if(mysql_num_rows($hotel)>0){$strContentx .="<h3>Hotel Bills :</h3>".$tblStart;}
	$k=1;while($hotelRow=mysql_fetch_array($hotel)){
		$strContentx .= '<tr>'.strReplace("Check In Date", $hotelRow['checkInDate'],$k).strReplace("Check Out Date", $hotelRow['checkOutDate'],$k).strReplace("Total Days", $hotelRow['totalDays'],$k).strReplace("Amount", $hotelRow['amount'],$k).'</tr>';		
		$k++;}	
	if(mysql_num_rows($hotel)>0){$strContentx .= "<tr><td></td><td></td><td></td>".strReplace("Total", $expRow['hotelBills'],$k)."</tr>".$tblEnd;}
// Local Conveyance
	if(mysql_num_rows($local)>0){$strContentx .="<h3>Local Conveyance :</h3>".$tblStart;}
	$k=1;while($localRow=mysql_fetch_array($local)){
		$strContentx .= '<tr>'.strReplace("Date Of Travel", $localRow['dateOfTravel'],$k).strReplace("Mode Of Travel", $localRow['modeOfTravel'],$k).strReplace("From", $localRow['travelFrom'],$k).strReplace("To", $localRow['travelTo'],$k).strReplace("Amount", $localRow['amount'],$k).'</tr>';		
		$k++;}
	if(mysql_num_rows($local)>0){$strContentx .= "<tr><td></td><td></td><td></td><td></td>".strReplace("Total", $expRow['localConveyance'],1)."</tr>".$tblEnd;}
// Any Other Expenses (With Details & Supporting Bills)
	if(mysql_num_rows($other)>0){$strContentx .="<h3>Any Other Expenses (With Details & Supporting Bills):</h3>".$tblStart;}
	$k=1;while($otherRow=mysql_fetch_array($other)){
		$strContentx .= '<tr>'.strReplace("Description", $otherRow['description'],$k).strReplace("Amount", $otherRow['amount'],$k).'</tr>';		
		$k++;}	
	if(mysql_num_rows($other)>0){$strContentx .= "<tr><td></td>".strReplace("Total", $expRow['anyOtherExpenses'],1)."</tr>".$tblEnd;}
// Total Tour Expenses & Other Deductions
	$strContentx .="<br><br>".$tblStart;
	$strContentx .= '<tr>'.strReplace("Total Tour Expenses", $expRow['totalTourExpenses'],1).'</tr>';
	$strContentx .= '<tr>'.strReplace("Circle Deductions", $expRow['circleDeductions'],1).strReplace("Circle Remarks", NA($expRow['circleRemarks']),1).'</tr>';
	$strContentx .= '<tr>'.strReplace("Corporate Deductions", $expRow['corporateDeductions'],1).strReplace("Corporate Remarks", NA($expRow['corporateRemarks']),1).'</tr>';
	$strContentx .= '<tr>'.strReplace("Net Expenses Booked", $expRow['netExpensesBooked'],1).'</tr>';
	$strContentx .=$tblEnd.'<br><br><br><br><br><br>';
	$strContentx .= $tblStart;
	$strContentx .=	"<tr><td style='text-align:justify;'><b>Signature of client</td>";
	$strContentx .=	"<td style='text-align:left;'><b>Approved by</td>";
	$strContentx .=	"<td style='text-align:justify;'><b>Finance</td></tr>".$tblEnd;
}
	echo $strContentx;
	echo "<script type='text/javascript'>window.print();</script>";
	echo "<script> window.history.back() </script>";
	function NA($a){ if(is_null($a) || $a == 0){ return 'NA'; }else{ return $a;} }
	function strReplace($a,$b,$c){
	$str="<td style='padding:5px;text-align:justify; font-size:12px; border:1px solid #000;'>";
	if($c==1){$str.="<h4 style='display:block;color:#2a6496;font-weight:bold;margin:0 !important;padding:0 !important;'>head</h4>";}
	$str.="<p style='display:block;margin:0 !important;padding:0 !important;'>rows</p></td>";
	return str_replace( array("head","rows"), array($a,$b),$str); }
?>