<?php
date_default_timezone_set("Asia/Kolkata");
include('../db.php');
getDB();
include('pdfinclude/mpdf.php');
$mpdf=new mPDF();
if(isset($_REQUEST['ref'])){
$res="<table width='100%'><tr>";
$res.="<td align='left'><img src='EnerSys_logo.png' width='150'></td><td align='right'><h3>EnerSys India Batteries Pvt. Ltd.</h3></td></tr></table><br><br>";
$tbl_start = "<table class='tbl'><tr>";
$adv_ali = $_REQUEST['ref'];
$sql = mysql_query("SELECT * FROM ec_advances WHERE advance_alias='$adv_ali' AND flag=0");
	if(mysql_num_rows($sql)){ $row=mysql_fetch_array($sql);
	$settle = mysql_query("SELECT SUM(request_amount) FROM ec_advances WHERE approval_level='6' AND employee_alias='".$row['employee_alias']."' AND flag=0");
	if(mysql_num_rows($settle)){ $settleRow=mysql_fetch_array($settle); $settleAmount = $settleRow[0];}
		$res.="<div class='alinR'>Date : ".dat($row['requested_date'])."</div><br><br>";
		$res.="<h3 class='alinC'>Acknowledgement for Advance</h3><br><br><br>";
		$res.="<table width='100%' class='tbl'><tr>";
		$res.="<td width='50%'><b>Employee ID : </b>".strtoupper(alias($row['employee_alias'],'ec_employee_master','employee_alias','employee_id'))."</td>";
		$res.="<td width='50%'><b>Employee Name : </b>".strtoupper(alias($row['employee_alias'],'ec_employee_master','employee_alias','name'))."</td></tr>";
		$res.="<tr><td><b>Department : </b>".ucfirst(alias(alias($row['employee_alias'],'ec_employee_master','employee_alias','department_alias'),'ec_department','department_alias','department_name'))."</td>";
		$res.="<td><b>Designation : </b>".ucfirst(alias(alias($row['employee_alias'],'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','designation'))."</td></tr>";
		$res.="<tr><td><b>Grade : </b>".ucfirst(alias(alias($row['employee_alias'],'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','grade'))."</td>";
		$res.="<td><b>Previous Advance not settled : </b>".moneyFormatIndia($settleAmount)."</td></tr>";
		$remark = mysql_query("SELECT remarks,remarked_by,remarked_on FROM ec_remarks WHERE item_alias='".$row['advance_alias']."' AND module='BA' AND flag=0");
		if(mysql_num_rows($remark)){
			$n=1;while($remarkRow=mysql_fetch_array($remark)){
				if($n%2==1)$res.="<tr>";
				$res.="<td><b>Remarks : </b><span style='font-size:11px;'>(by ".ucfirst(alias($remarkRow['remarked_by'],'ec_employee_master','employee_alias','name')).", on ".dat($remarkRow['remarked_on']).")</span><br>".$remarkRow['remarks']."</td>";
				if($n%2==0)$res.="</tr>";
			$n++;}
		}	
		$res.="</table><br><br>";
		$res.="<div class='alinR'>Current Request: <b>Rs.".moneyFormatIndia($row['request_amount'])."</b></div><br><br><br>";
		$res .=	"<div>(".alias($row['employee_alias'],'ec_employee_master','employee_alias','name').")<br><b>Signature of client</b><br>Date : ".dat($row['requested_date'])."</div><br><br><br>";
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
	//$mpdf->SetHTMLHeader("<div style='text-align: left;'><img src='EnerSys_logo.png' alt='EnerSys_logo' width='150'></div>");
	//$mpdf->SetWatermarkText("EnerSys");
	//$mpdf->showWatermarkText = true;
	//$mpdf->watermarkTextAlpha = 0.2;
	//$mpdf->watermark_font = 'DejaVuSansCondensed';
	$mpdf->SetWatermarkImage('EnerSys_logo.png');
	$mpdf->showWatermarkImage = true;
	$mpdf->watermarkImageAlpha = 0.05;
	$css='.alinL{text-align:left;}.alinC{text-align:center;}.alinR{text-align:right;}.tbl td{padding:5px;}';
	$mpdf->WriteHTML($css,1);
	//$stylesheet = file_get_contents('css/mpdf.css'); // external css
	//$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($res,2);
	$mpdf->Output();
	//$mpdf->Output('Advance_'.date('Y-m-d_H:i:s').'.pdf', 'D');
	exit;
}
function dat($a){if(!empty($a))return date_format(date_create($a),"jS M Y");else return false;}
function alias($alias,$tb,$col,$retrive){
	$sql = mysql_query("SELECT $retrive FROM $tb WHERE $col='$alias' AND flag=0");
	if(mysql_num_rows($sql)){
		$row = mysql_fetch_array($sql);
		return $row[$retrive];
	}
}
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