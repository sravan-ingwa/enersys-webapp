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
		$res.="<tr><td><b>Places Of Visit : </b>".ucfirst($row['places_of_visit'])."</td>";
		$res.="<td><b>Purpose : </b>".$row['purpose']."</td></tr></table>";
		$sqlCon = mysql_query("SELECT * FROM ec_conveyance WHERE expenses_alias='$exp_ali' AND flag=0");
		if(mysql_num_rows($sqlCon)){
		$res.="<h4>Conveyance : </h4>";
			$res.= $tbl_start."<th>Date Of Travel</th><th>Mode Of Travel</th><th>From</th><th>To</th><th>Amount</th></tr>";
			while($rowCon=mysql_fetch_array($sqlCon)){ $totalCon += $rowCon['amount'];
				$res.= "<tr><td>".$rowCon['date_of_travel']."</td>";
				$res.= "<td>".ucfirst($rowCon['mode_of_travel'])."</td>";
				$res.= "<td>".ucfirst($rowCon['from_place'])."</td>";
				$res.= "<td>".ucfirst($rowCon['to_place'])."</td>";
				$res.= "<td>".$rowCon['amount']."</td></tr>";
			}$res.='</table><br>';
			$res.= "<div class='alinR'>Total : <b> Rs. ".moneyFormatIndia($totalCon)."</b></div>";
		}
		$sqlCon = mysql_query("SELECT * FROM ec_localconveyance WHERE expenses_alias='$exp_ali' AND flag=0");
		if(mysql_num_rows($sqlCon)){
		$res.="<h4>Local Conveyance : </h4>";
			$res.= $tbl_start."<th>Date Of Travel</th><th>Mode Of Travel</th><th>From</th><th>To</th><th>Amount</th></tr>";
			while($rowCon=mysql_fetch_array($sqlCon)){ $totalCon1 += $rowCon['amount'];
				$res.= "<tr><td>".$rowCon['date_of_travel']."</td>";
				$res.= "<td>".ucfirst($rowCon['mode_of_travel'])."</td>";
				$res.= "<td>".ucfirst($rowCon['from_place'])."</td>";
				$res.= "<td>".ucfirst($rowCon['to_place'])."</td>";
				$res.= "<td>".$rowCon['amount']."</td></tr>";
			}$res.='</table><br>';
			$res.= "<div class='alinR'>Total : <b> Rs. ".moneyFormatIndia($totalCon1)."</b></div>";
		}
		$sqlLod = mysql_query("SELECT * FROM ec_lodging WHERE expenses_alias='$exp_ali' AND flag=0");
		if(mysql_num_rows($sqlLod)){
		$res.="<h4>Lodging : </h4>";
		$res.= $tbl_start."<th>Type Of Stay</th><th>From Date</th><th>To Date</th><th>Hotel Name</th><th>Amount</th></tr>";
			while($rowLod=mysql_fetch_array($sqlLod)){ $totalLod += $rowLod['amount'];
				$res.= "<tr><td>".ucfirst($rowLod['type_of_stay'])."</td>";
				$res.= "<td>".$rowLod['check_in']."</td>";
				$res.= "<td>".$rowLod['check_out']."</td>";
				$res.= "<td>".ucfirst($rowLod['hotel_name'])."</td>";
				$res.= "<td>".$rowLod['amount']."</td></tr>";
			}$res.='</table><br>';
			$res.= "<div class='alinR'>Total : <b> Rs. ".moneyFormatIndia($totalLod)."</b></div>";
		}
		$sqlLod = mysql_query("SELECT * FROM ec_boarding WHERE expenses_alias='$exp_ali' AND flag=0");
		if(mysql_num_rows($sqlLod)){
		$res.="<h4>Boarding : </h4>";
		$res.= $tbl_start."<th>Visit: Start Date</th><th>Visit: End Date</th><th>State</th><th>Amount</th></tr>";
			while($rowLod=mysql_fetch_array($sqlLod)){ $totalLoda += $rowLod['amount'];
				$res.= "<tr>";
				$res.= "<td>".$rowLod['check_in']."</td>";
				$res.= "<td>".$rowLod['check_out']."</td>";
				$res.= "<td>".ucfirst($rowLod['state'])."</td>";
				$res.= "<td>".$rowLod['amount']."</td></tr>";
			}$res.='</table><br>';
			$res.= "<div class='alinR'>Total : <b> Rs. ".moneyFormatIndia($totalLoda)."</b></div>";
		}
		$sqlOth = mysql_query("SELECT * FROM ec_other_expenses WHERE expenses_alias='$exp_ali' AND flag=0");
		if(mysql_num_rows($sqlOth)){
		$res.="<h4>Other Expenses : </h4>";
			$res.= $tbl_start."<th>Description</th><th>Date</th><th>Amount</th></tr>";
			while($rowOth=mysql_fetch_array($sqlOth)){ $totalOth += $rowOth['amount'];
				$res.= "<tr><td>".ucfirst($rowOth['description'])."</td>";
				$res.= "<td>".$rowOth['checked_date']."</td>";
				$res.= "<td>".$rowOth['amount']."</td></tr>";
			}$res.="</table><br>";
			$res.= "<div class='alinR'>Total : <b> Rs. ".moneyFormatIndia($totalOth)."</b></div>";
		}
		$res.="<div class='alinR'>Grand Total : <b> Rs. ".moneyFormatIndia($row['total_tour_expenses'])."</b></div><br><br>";
		$res.="<div>(".alias($row['employee_alias'],'ec_employee_master','employee_alias','name').")<br><b>Signature of client</b></div><br><br>";
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
function moneyFormatIndia($num){
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
?>