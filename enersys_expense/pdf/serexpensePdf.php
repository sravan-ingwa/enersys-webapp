<?php
date_default_timezone_set("Asia/Kolkata");
include('../db.php');
getDB();
include('pdfinclude/mpdf.php');
//$mpdf=new mPDF($mode, $format, $font_size, $font, $margin_left, $margin_right, $margin_top, $margin_bottom, $margin_header, $margin_footer, $orientation);
$mpdf=new mPDF('','', 0, '', 8, 8, 30, 8, '5', '', '');
if(isset($_REQUEST['ref'])){
$res="";
$tbl_start = "<table class='tbl'><tr>";
$exp_ali = $_REQUEST['ref'];
$sql = mysql_query("SELECT * FROM ec_expenses WHERE expenses_alias='$exp_ali' AND flag=0");
	if(mysql_num_rows($sql)){ $row=mysql_fetch_array($sql);
		$res.="<table width='100%'><tr>";
		$res.="<td width='60%'><b>Bill Number : </b>".$row['bill_number']."</td>";
		$res.="<td><b>PO /GR Number : </b>".$row['po_gnr']."</td></tr>";
		$res.="<tr><td><b>Date Of Request : </b>".$row['requested_date'];
		$res.="<td><b>Employee ID : </b>".strtoupper(alias($row['employee_alias'],'ec_employee_master','employee_alias','employee_id'))."</td></tr>";
		$res.="<tr><td><b>Employee Name : </b>".strtoupper(alias($row['employee_alias'],'ec_employee_master','employee_alias','name'))."</td>";
		$res.="<td><b>Grade : </b>".alias(alias($row['employee_alias'],'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','grade')."</td></tr>";
		$res.="<tr><td><b>Period Of Visit From : </b>".$row['period_of_visit_from']."</td>";
		$res.="<td><b>Period Of Visit To : </b>".$row['period_of_visit_to']."</td></tr>";
		$res.="<tr><td><b>Places Of Visit : </b>".($row['places_of_visit'])."</td>";
		$res.="<td><b>Purpose : </b>".$row['purpose']."</td></tr></table>";
		
		$sqlCon = mysql_query("SELECT * FROM ec_localconveyance WHERE expenses_alias='$exp_ali' AND flag=0");
		if(mysql_num_rows($sqlCon)){
			$l=1;
			while($rowCon=mysql_fetch_array($sqlCon)){ 
				$totalCon1 += $rowCon['amount'];
				if(getArea($rowCon['district_alias'])==0){ $area= 'Plain Area'; $amount_appli = 0.02;}else if(getArea($rowCon['district_alias'])==1){$area= 'Hilly area'; $amount_appli = 0.04;}
				if($rowCon['bucket'] ==0)$bucket='Secondary transportation';else $bucket= 'Local Conveyance';
				if(getWeights($rowCon['capacity'],'product') > 0)$capacity = getWeights($rowCon['capacity'],'product'); else $capacity = '';
				if(getWeights($rowCon['capacity'],'weight') > 0)$weight = getWeights($rowCon['capacity'],'weight'); else $weight = '';
				if($rowCon['quantity'] > 0) $quantity = $rowCon['quantity']; else $quantity = '';
				if($rowCon['km'] > 0) $km = $rowCon['km']; else $km = '';
				if($rowCon['zone_alias'] != '') $lczone = getNames($rowCon['zone_alias'],'ec_zone'); else $lczone = '--';
				if($rowCon['state_alias'] != '') $lcstate = ucfirst(getNames($rowCon['state_alias'],'ec_state')); else $lcstate = '--';
				if($rowCon['district_alias'] != '') $lcdistrict = ucfirst(getNames($rowCon['district_alias'],'ec_district')); else $lcdistrict = '--';
				if($rowCon['dpr_number'] != '') $lcdpr_number = $rowCon['dpr_number']; else $lcdpr_number = '--';
				if($rowCon['ticket_alias'] != '') { if($rowCon['ticket_alias'] == 1) { $lcticket_alias = 'Others';} else{$lcticket_alias = getTicketName($rowCon['ticket_alias']);} } else $lcticket_alias = '--';
				if($rowCon['bucket'] == '') {
					$res.="<h4 style='background-color:#2a6496; color:#fff;  padding:5px; margin-bottom:-2px;'>Local Conveyance ".$l."</h4>";
					$res.="<table width='100%' style='border:1px solid #2a6496; line-height:2;'><tr>";
					$res.="<td width='30%'><b>Date of Travel : </b>".date("d-m-Y", strtotime($rowCon['date_of_travel']))."</td>";
					$res.="<td width='35%'><b>Mode of Travel: </b>".$rowCon['mode_of_travel']."</td>";
					$res.="<td width='35%'><b>From: </b>".ucfirst($rowCon['from_place'])."</td></tr>";
					$res.="<tr><td width='30%'><b>To: </b>".ucfirst($rowCon['to_place'])."</td>";
					$res.="<td width='35%'><b>Amount: </b>".$rowCon['amount']."</td><td></td></tr></table>";
				} else {
					if($rowCon['bucket'] ==0){
						$res.="<h4 style='background-color:#2a6496; color:#fff; padding:5px;  margin-bottom:-2px;'>Local Conveyance ".$l."</h4>";
						$res.="<table width='100%' style='border:1px solid #2a6496; line-height:2;'><tr>";
						$res.="<td width='35%'><b>Zone : </b>".$lczone."</td>";
						$res.="<td width='35%'><b>State : </b>".$lcstate."</td>";
						$res.="<td width='30%'><b>District : </b>".$lcdistrict."</td></tr>";
						$res.="<tr><td width='35%'><b>Area : </b>".$area."</td>";
						$res.="<td width='35%'><b>Bucket : </b>".$bucket."</td>";
						$res.="<td width='30%'><b>Capacity : </b>".$capacity."</td></tr>";
						$res.="<tr><td width='35%'><b>Weight of cell : </b>".$weight."</td>";
						$res.="<td width='35%'><b>Quantity : </b>".$quantity."</td>";
						$res.="<td width='30%'><b>No.Of Kilometers : </b>".$km."</td></tr>";
						$res.="<tr><td width='35%'><b>Amount Appilicable : </b>".$amount_appli."</td>";
						$res.="<td width='35%'><b>Date of Travel : </b>".date("d-m-Y", strtotime($rowCon['date_of_travel']))."</td>";
						$res.="<td width='30%'><b>Mode of Travel: </b>".$rowCon['mode_of_travel']."</td></tr>";
						$res.="<tr><td width='35%'><b>From: </b>".ucfirst($rowCon['from_place'])."</td>";
						$res.="<td width='35%'><b>To: </b>".ucfirst($rowCon['to_place'])."</td>";
						$res.="<td width='35%'><b>Ticket ID: </b>".$lcticket_alias."</td></tr>";
						$res.="<tr><td width='35%'><b>DPR No: </b>".$rowCon['dpr_number']."</td>";
						$res.="<td width='30%'><b>Amount: </b>".$rowCon['amount']."</td>";
						$res.="<td width='30%'><b></b>".''."</td></tr></table>";
					} else if($rowCon['bucket'] ==1){
						$res.="<h4 style='background-color:#2a6496; color:#fff;  padding:5px; margin-bottom:-2px;'>Local Conveyance ".$l."</h4>";
						$res.="<table width='100%' style='border:1px solid #2a6496; line-height:2;'><tr>";
						$res.="<td width='35%'><b>Zone : </b>".getNames($rowCon['zone_alias'],'ec_zone')."</td>";
						$res.="<td width='35%'><b>State : </b>".ucfirst(getNames($rowCon['state_alias'],'ec_state'))."</td>";
						$res.="<td width='30%'><b>District : </b>".ucfirst(getNames($rowCon['district_alias'],'ec_district'))."</td></tr>";
						$res.="<tr><td width='35%'><b>Area : </b>".$area."</td>";
						$res.="<td width='35%'><b>Bucket : </b>".$bucket."</td>";
						$res.="<td width='30%'><b>Date of Travel : </b>".date("d-m-Y", strtotime($rowCon['date_of_travel']))."</td></tr>";
						$res.="<tr><td width='35%'><b>Mode of Travel: </b>".$rowCon['mode_of_travel']."</td>";
						$res.="<td width='35%'><b>From: </b>".ucfirst($rowCon['from_place'])."</td>";
						$res.="<td width='30%'><b>To: </b>".ucfirst($rowCon['to_place'])."</td></tr>";
						$res.="<tr><td width='35%'><b>Ticket ID: </b>".$lcticket_alias."</td>";
						$res.="<td width='30%'><b>DPR No: </b>".$rowCon['dpr_number']."</td>";
						$res.="<td width='35%'><b>Amount: </b>".$rowCon['amount']."</td></tr></table>";
					}
				}
				$l++;
			}
			$res.= "<br><div class='alinR'>Total : <b> Rs. ".moneyFormatIndia($totalCon1)."</b></div>";
		}

		$sqlCon = mysql_query("SELECT * FROM ec_conveyance WHERE expenses_alias='$exp_ali' AND flag=0");
		if(mysql_num_rows($sqlCon)){
		$res.="<h4>Conveyance : </h4>";
			$res.= $tbl_start."<th>Date Of Travel</th><th>Mode Of Travel</th><th>From</th><th>To</th><th>Ticket ID</th><th>DPR No</th><th>Amount</th></tr>";
			while($rowCon=mysql_fetch_array($sqlCon)){ $totalCon += $rowCon['amount'];
				if($rowCon['dpr_number'] != '') $ndpr_number = $rowCon['dpr_number']; else $ndpr_number = '--';
				if($rowCon['ticket_alias'] != '') { if($rowCon['ticket_alias'] == 1) { $nticket_alias = 'Others';} else{$nticket_alias = getTicketName($rowCon['ticket_alias']);} } else $nticket_alias = '--';
				$res.= "<tr><td>".date("d-m-Y", strtotime($rowCon['date_of_travel']))."</td>";
				$res.= "<td>".ucfirst($rowCon['mode_of_travel'])."</td>";
				$res.= "<td>".ucfirst($rowCon['from_place'])."</td>";
				$res.= "<td>".ucfirst($rowCon['to_place'])."</td>";
				$res.= "<td>".$nticket_alias."</td>";
				$res.= "<td>".$ndpr_number."</td>";
				$res.= "<td>".$rowCon['amount']."</td></tr>";
			}$res.='</table><br>';
			$res.= "<div class='alinR'>Total : <b> Rs. ".moneyFormatIndia($totalCon)."</b></div>";
		}
		$sqlLod = mysql_query("SELECT * FROM ec_lodging WHERE expenses_alias='$exp_ali' AND flag=0");
		if(mysql_num_rows($sqlLod)){
		$res.="<h4>Lodging : </h4>";
		$res.= $tbl_start."<th>Zone</th><th>State</th><th>District</th><th>From Date</th><th>To Date</th><th>Hotel Name</th><th>Ticket ID</th><th>DPR No</th><th>Amount</th></tr>";
			while($rowLod=mysql_fetch_array($sqlLod)){ $totalLod += $rowLod['amount'];
				if($rowLod['zone_alias'] != '') $ldzone = ucfirst(getNames($rowLod['zone_alias'],'ec_zone')); else $ldzone = '--';
				if($rowLod['state_alias'] != '') $ldstate = ucfirst(getNames($rowLod['state_alias'],'ec_state')); else $ldstate = '--';
				if($rowLod['district_alias'] != '') $lddistrict = ucfirst(getNames($rowLod['district_alias'],'ec_district')); else $lddistrict = '--';
				if($rowLod['dpr_number'] != '') $lddpr_number = $rowLod['dpr_number']; else $lddpr_number = '--';
				if($rowLod['ticket_alias'] != '') { if($rowLod['ticket_alias'] == 1) { $ldticket_alias = 'Others';} else{$ldticket_alias = getTicketName($rowLod['ticket_alias']);} } else $ldticket_alias = '--';
				$res.= "<tr><td>".$ldzone."</td>";
				$res.= "<td>".$ldstate."</td>";
				$res.= "<td>".$lddistrict."</td>";
				$res.= "<td>".date("d-m-Y", strtotime($rowLod['check_in']))."</td>";
				$res.= "<td>".date("d-m-Y", strtotime($rowLod['check_out']))."</td>";
				$res.= "<td>".ucfirst($rowLod['hotel_name'])."</td>";
				$res.= "<td>".$ldticket_alias."</td>";
				$res.= "<td>".$lddpr_number."</td>";
				$res.= "<td>".$rowLod['amount']."</td></tr>";
			}$res.='</table><br>';
			$res.= "<div class='alinR'>Total : <b> Rs. ".moneyFormatIndia($totalLod)."</b></div>";
		}
		$sqlLod = mysql_query("SELECT * FROM ec_boarding WHERE expenses_alias='$exp_ali' AND flag=0");
		if(mysql_num_rows($sqlLod)){
		$res.="<h4>Boarding : </h4>";
		$res.= $tbl_start."<th>Zone</th><th>State</th><th>District</th><th>Visit: Start Date</th><th>Visit: End Date</th><th>Ticket ID</th><th>DPR No</th><th>Amount</th></tr>";
			while($rowLod=mysql_fetch_array($sqlLod)){ $totalLoda += $rowLod['amount'];
				if($rowLod['zone_alias'] != '') $bzone = ucfirst(getNames($rowLod['zone_alias'],'ec_zone')); else $bzone = '--';
				if($rowLod['state_alias'] != '') $bstate = ucfirst(getNames($rowLod['state_alias'],'ec_state')); else $bstate = '--';
				if($rowLod['district_alias'] != '') $bdistrict = ucfirst(getNames($rowLod['district_alias'],'ec_district')); else $bdistrict = '--';
				if($rowLod['dpr_number'] != '') $bdpr_number = $rowLod['dpr_number']; else $bdpr_number = '--';
				if($rowLod['ticket_alias'] != '') { if($rowLod['ticket_alias'] == 1) { $bticket_alias = 'Others';} else{$bticket_alias = getTicketName($rowLod['ticket_alias']);} } else $bticket_alias = '--';
				$res.= "<tr><td>".$bzone."</td>";
				$res.= "<td>".$bstate."</td>";
				$res.= "<td>".$bdistrict."</td>";
				$res.= "<td>".date("d-m-Y", strtotime($rowLod['check_in']))."</td>";
				$res.= "<td>".date("d-m-Y", strtotime($rowLod['check_out']))."</td>";
				$res.= "<td>".$bticket_alias."</td>";
				$res.= "<td>".$bdpr_number."</td>";
				$res.= "<td>".$rowLod['amount']."</td></tr>";
			}$res.='</table><br>';
			$res.= "<div class='alinR'>Total : <b> Rs. ".moneyFormatIndia($totalLoda)."</b></div>";
		}
		$sqlOth = mysql_query("SELECT * FROM ec_other_expenses WHERE expenses_alias='$exp_ali' AND flag=0");
		if(mysql_num_rows($sqlOth)){
		$res.="<h4>Other Expenses : </h4>";
			$res.= $tbl_start."<th>Description</th><th>Date</th><th>Ticket ID</th><th>DPR No</th><th>Amount</th></tr>";
			while($rowOth=mysql_fetch_array($sqlOth)){ $totalOth += $rowOth['amount'];
				if($rowOth['dpr_number'] != '') $odpr_number = $rowOth['dpr_number']; else $odpr_number = '--';
				if($rowOth['ticket_alias'] != '') { if($rowOth['ticket_alias'] == 1) { $oticket_alias = 'Others';} else{$oticket_alias = getTicketName($rowOth['ticket_alias']);} } else $oticket_alias = '--';
				$res.= "<tr><td>".ucfirst($rowOth['description'])."</td>";
				$res.= "<td>".date("d-m-Y", strtotime($rowOth['checked_date']))."</td>";
				$res.= "<td>".$oticket_alias."</td>";
				$res.= "<td>".$odpr_number."</td>";
				$res.= "<td>".$rowOth['amount']."</td></tr>";
			}$res.="</table><br>";
			$res.= "<div class='alinR'>Total : <b> Rs. ".moneyFormatIndia($totalOth)."</b></div>";
		}
		$res.="<div class='alinR'>Grand Total : <b> Rs. ".moneyFormatIndia(round($row['total_tour_expenses']))."</b></div><br>";
		$res.="<div>(".alias($row['employee_alias'],'ec_employee_master','employee_alias','name').")<br><b>Signature of client</b></div><br>";
		if($row['approved_by']!=""){
			$hsf = explode("|",$row['approved_by']); $hsfDate = explode("|",$row['approved_date']);
			$no = count($hsf);
			$res .=	"<table width='100%'><tr>";
			for($xa=0;$xa<$no;$xa++){
				$res .=	"<td class='alinC' style='font-size:12px'>
					(".alias($hsf[$xa],'ec_employee_master','employee_alias','name').")<br>Date : ".dat($hsfDate[$xa])."
					</td>";
			}
			$res.="</tr></table>";
		}else $no=0;

	}
	//echo $res;
	$stylesheet = file_get_contents('css/mpdf.css'); // external css
	$mpdf->SetHTMLHeader("<table width='100%'><tr><td align='left'><div style='text-align: left;'><img src='EnerSys_logo.png' alt='EnerSys_logo' width='150'></div></td><td align='right'><h3>EnerSys India Batteries Pvt. Ltd.</h3></td></tr></table><br><br>");
	//$mpdf->SetWatermarkText("EnerSys");
	//$mpdf->showWatermarkText = true;
	$mpdf->SetWatermarkImage('EnerSys_logo.png');
	$mpdf->showWatermarkImage = true;
	$mpdf->watermarkImageAlpha = 0.05;
	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($res,2);
	$mpdf->Output();
	//$mpdf->Output('Expence_'.date('Y-m-d_H:i:s').'.pdf', 'D');
	exit;
}
function alias($alias,$tb,$col,$retrive){
	$sql = mysql_query("SELECT $retrive FROM $tb WHERE $col='$alias' AND flag=0");
	if(mysql_num_rows($sql)){
		$row = mysql_fetch_array($sql);
		return $row[$retrive];
	}
}
function dat($a){if(!empty($a))return date_format(date_create($a),"jS M Y");else return false;}
/*function moneyFormatIndia($num){
	$explrestunits = "" ;
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
	return $thecash; // writes the final format where $currency is the currency symbol.
}
*/
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
function getTicketName($fv1){
	$sql = mysql_query("SELECT ticket_id FROM ec_tickets WHERE flag=0 AND ticket_alias = '$fv1'");
	if(mysql_num_rows($sql)){
	$row = mysql_fetch_array($sql);
	return $row['ticket_id'];	
	}else return 0;
}

function getNames($fv1,$fv2){
	$where = ($fv2=='ec_zone' ? 'zone_alias' : ($fv2=='ec_state' ? 'state_alias' : 'district_alias'));
	$get = ($fv2=='ec_zone' ? 'zone_name' : ($fv2=='ec_state' ? 'state_name' : 'district_name'));
	$sql = mysql_query("SELECT $get as res FROM $fv2 WHERE flag=0 AND $where = '$fv1'");
	if(mysql_num_rows($sql)){
	$row = mysql_fetch_array($sql);
	return $res = $row['res'];
	}else return 0;
}
function getArea($fv1){
	$sql = mysql_query("SELECT area FROM ec_district WHERE flag=0 AND district_alias = '$fv1'");
	if(mysql_num_rows($sql)){
	$row = mysql_fetch_array($sql);
	return $res = $row['area'];
	}else return -1;
}

function getWeights($fv1,$fv2){
	$get = ($fv2=='weight' ? 'weight' : 'product_description');
	$sql = mysql_query("SELECT $get as res FROM ec_product WHERE flag=0 AND product_alias = '$fv1'");
	if(mysql_num_rows($sql)){
	$row = mysql_fetch_array($sql);
	return $res = $row['res'];
	}else return 0;
}

?>