<?php
ob_start();
include('functions.php');
TitleFav();
include('pdfinclude/mpdf.php');
$mpdf=new mPDF();
//$fp = fopen("sample-invoice.html","r");
//$strContent = fread($fp, filesize("sample-invoice.html"));
//fclose($fp);

$tableName= menuName($_REQUEST['x'],"tbName");
$menuName= menuName($_REQUEST['x'],"menu");
$yy=$_REQUEST['y'];
$query = mysql_query("SELECT colName,colRef FROM ss_col_ref WHERE tbName='$tableName' AND pView='0' ORDER BY ordering");
if(mysql_num_rows($query)>0){$colName=array();$colref=array();
	while($row=mysql_fetch_array($query)){$colName[]=$row['colName'];$colref[]=$row['colRef'];}
	$query = mysql_query("SELECT * FROM $tableName WHERE id='".$_REQUEST['y']."' AND  flag='0'");
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
$strContentx="<img src=".$comprow['logo']." alt=".$comprow['compName']." width='180'>";
if($menuName=='Book Expenses'){
	$strContentx.="<h3 style='background:#2a6496;color:#FFF;padding:0 5px;line-height:30px;text-transform:capitalize;font-size:16px;'>TOUR BILL</h3>";
	$exp=mysql_query("SELECT * FROM $tableName WHERE id='".$yy."' AND  flag='0'");
	$fare=mysql_query("SELECT * FROM ss_book_expenses_fare WHERE refId='".$yy."' AND  flag='0'");
	$hotel=mysql_query("SELECT * FROM ss_book_expenses_hotel WHERE refId='".$yy."' AND  flag='0'");
	$local=mysql_query("SELECT * FROM ss_book_expenses_local WHERE refId='".$yy."' AND  flag='0'");
	$other=mysql_query("SELECT * FROM ss_book_expenses_other WHERE refId='".$yy."' AND  flag='0'");
	$expRow=mysql_fetch_array($exp);
	$tblStart = "<table style='border-collapse:collapse;width:100%;'>";
	$tblEnd ="</table>";
// Bill No and general info
	$strContentx .= $tblStart.'<tr>'.strReplace("Bill Number", $expRow['billNo'],1).strReplace("Created Date", $expRow['createdDate'],1).'</tr>'.$tblEnd.'<br>';
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
}elseif($menuName=='Material Outward'){
	function whAddress($q){ $query=mysql_query("SELECT whAddress FROM ss_warehouse_code WHERE id='$q' AND flag='0'");
	if(mysql_num_rows($query)>0){$row=mysql_fetch_array($query);return $row['whAddress'];}}
	$query1 = mysql_query("SELECT itemCode,qty,fromWh,toWh,custDeliverAddr FROM ss_material_outward WHERE id='".$_REQUEST['y']."' AND flag='0'");
	$row1=mysql_fetch_array($query1);
	if(!empty($row1['toWh'])){$to = whAddress($row1['toWh']); }else{$to = $row1['custDeliverAddr'];}
	$strContentx.= '<h3 style="text-align:center;">EnerSys India Batteries Pvt. Ltd</h3>';
	$strContentx.="<h3 style='background:#2a6496;color:#FFF;padding:0 5px;line-height:30px;text-transform:capitalize;font-size:16px;'>To whom ever it may concern</h3>";
	$strContentx.= '<p style="text-align:right;">Date : '.date('d-F-Y').'</p><br>';
	$strContentx.= '<p style="line-height:30px;text-indent: 70px;">It is to certify that the below mentioned material, VRLA sealed Batteries is moving to below mentioned address from <b>'.whAddress($row1['fromWh']).'</b> to <b>'.$to.'</b> for warranty replacement. This material comes under Non-Hazardous category and these are sealed batteries, hence no chance of any acid leakages. The material is not for sale and the commercial value is Zero.</p>';
	$strContentx.= "<br><table style='border-collapse:collapse;width:100%;'>";
	$strContentx.= '<tr>'.strReplace("Capacity", itemGetDesc($row1['itemCode']),1).strReplace("Quantity",$row1['qty'],1).'</tr>';
	$strContentx.="</table><br>";
	$strContentx.= '<p style="line-height:30px;">Yours faithfully,<br>For EnerSys India Batteries Pvt. Ltd<br><br><br>Thanking You,<br><br>Authorized Signatory</p>';
}elseif($menuName=='ESCA Expense'){
	$esca=mysql_query("SELECT * FROM ss_esca_expense WHERE stat='3'");
	$escarow=mysql_fetch_array($esca);
	
	$conPrice=mysql_query("SELECT * FROM ss_contract_price WHERE escaName='$escarow[escaName]'");
	$con=mysql_fetch_array($conPrice);
	
	$tickets=mysql_query("SELECT * FROM ss_tickets WHERE ticketId='$escarow[ttNumber]'");
	$ttRow=mysql_fetch_array($tickets);
	
	$strContentx.='<!doctype html>
	<html lang="en">
	<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Bree+Serif">
  </head>
  <body style="font-family: Bree Serif, serif;">
    <div class="container">
      <div class="row">
        <div class="col-xs-6">
          <h1>
            <img src="img/logo/EnerSyslogo.png" width="200">
          </h1>
        </div>
        <div class="col-xs-12 text-center">
          <h3><u>INVOICE</u></h3>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-5">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h5>From, '.escaGetName($escarow['escaName']).'</h5>
            </div>
            <div class="panel-body">
              <p>
                Invoice Date : '.$escarow['invDate'].'<br>
				Invoice Number : '.strtoupper($escarow['invNumber']).'<br>
                Activity : '.natureOfActivityGetName($con['activity']).'<br>
                Circle : '.circleGetName($con['circle']).'<br>
              </p>
            </div>
          </div>
        </div>
        <div class="col-xs-5 col-xs-offset-1 text-right">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h5>To,</h5>
            </div>
            <div class="panel-body">
              <p>EnerSys India Batteries Private Limited.
			  1st Floor, 1057 M, Road Number 45, Jubilee Hills, Hyderabad, Telangana 500033
			  </p>
            </div>
          </div>
        </div>
      </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center"><h5>Ticket No.</h5></th>
            <th class="text-center"><h5>Site ID</h5></th>
            <th class="text-center"><h5>Site Name</h5></th>
            <th class="text-center"><h5>No. Unit</h5></th>
            <th class="text-center"><h5>Unit Cost</h5></th>
            <th class="text-center"><h5>Service TAX</h5></th>
            <th class="text-center"><h5>Sub Total</h5></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-center">'.$escarow['ttNumber'].'</td>
            <td class="text-center">'.$ttRow['siteId'].'</td>
            <td class="text-center">'.$ttRow['siteName'].'</td>
            <td class="text-center">'.$ttRow['numBanks'].'</td>
            <td class="text-center">'.$ttRow['numBanks'].'</td>
            <td class="text-center">12.36%</td>
            <td class="text-center">'.$escarow['basicValue'].'</td>
          </tr>
        </tbody>
      </table>
      <div class="row text-right">
        <div class="col-xs-2 col-xs-offset-6">
          <p>
            <strong>
            Total : <br>
            </strong>
          </p>
        </div>
        <div class="col-xs-2">
          <strong>Rs.'.$escarow['total'].'<br>
          </strong>
        </div>
      </div>
    </div>
  </body>
</html>';
}else{
	$strContentx.="<h3 style='background:#2a6496;color:#FFF;padding:0 5px;line-height:30px;text-transform:capitalize;font-size:16px;'>".ucfirst($menuName)."</h3>";
	$strContentx.="<table border='1' style='border-collapse:collapse;width:100%;' width='100%'>";
		$c=count($strContent);
		for($a=0;$a<$c;$a++){
			$strContentx.="<tr>";
			for($b=$a;$b<=$a+1;$b++){
				$strContentx.="<td style='padding:7px;text-align:justify;'>
				<h4 style='display:block;color:#2a6496;font-weight:bold;'>".ucfirst($strContent[$b])."</h4>
				<p>".ucfirst($strContent1[$b])."</p>
				</td>";
			}
			$a++;
			$strContentx.="</tr>";
		}
	$strContentx.="</table>";
}
//echo $strContentx;
$mpdf->WriteHTML($strContentx);
$mpdf->Output();
exit;
	function NA($a){ if(is_null($a) || $a == 0){ return 'NA'; }else{ return $a;} }
	function strReplace($a,$b,$c){
	$str="<td style='padding:5px;text-align:justify; font-size:12px; border:1px solid #000;'>";
	if($c==1){$str.="<h4 style='display:block;color:#2a6496;font-weight:bold;margin:0 !important;padding:0 !important;'>head</h4>";}
	$str.="<p style='display:block;margin:0 !important;padding:0 !important;'>rows</p></td>";
	return str_replace( array("head","rows"), array($a,$b),$str); }
?>