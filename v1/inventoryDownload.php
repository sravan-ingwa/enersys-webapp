<?php
ob_start(); $wh = $_REQUEST['wh'];
include('functions.php');
TitleFav();
include('pdfinclude/mpdf.php');
$mpdf=new mPDF();
$menuName= menuName($_REQUEST['x'],"menu");
$yy=$_REQUEST['y'];
$comp=mysql_query("SELECT logo,compName FROM ss_company_details WHERE status='active'");
$comprow=mysql_fetch_array($comp);
$strContentx="<img src=".$comprow['logo']." alt=".$comprow['compName']." width='180'>";
if($menuName=='Material Balance'){
	$z = array('MRF Number','Item Description','Stock Category','Material Inwards','Material Outwards','Balance Stock');
	$strContentx.="<h3 style='background:#2a6496;color:#FFF;padding:0 5px;line-height:30px;text-transform:capitalize;font-size:16px;'>Material Balance</h3>";	
	$strContentx.="<div><b>Ware House : </b>".whareHouseGetName($wh)." [".whareHouseGetDesc($wh)."]</div><br>";
	$strContentx.="<table class='table table-bordered' border='1'><thead><tr align='center'>";
	foreach($z as $zz){	$strContentx.="<th>$zz</th>";}
	$strContentx.="</tr>";
	$strContentx.="</thead>";
	$strContentx.="<tbody align='center'>";
		$inItem = mysql_query("SELECT mrfNumber,itemCode,qty,stockCategory FROM ss_material_inward WHERE toWh='".$wh."' AND flag='0'");
		while($inItemRow = mysql_fetch_array($inItem)){
		$strContentx.='<tr>';
			$strContentx.="<td style='padding:5px;text-align:center;'>".$inItemRow['mrfNumber']."</td>";
			$strContentx.="<td style='padding:5px;text-align:center;'>".itemGetDesc($inItemRow['itemCode'])."</td>";
			$strContentx.="<td style='padding:5px;text-align:center;'>".stockGetName($inItemRow['stockCategory'])."</td>";
			$strContentx.="<td style='padding:5px;text-align:center;'>".$inItemRow['qty']."</td>";
		$outItem = mysql_query("SELECT qty FROM ss_material_outward WHERE itemCode='".$inItemRow['itemCode']."' AND stockCategory='".$inItemRow['stockCategory']."' AND fromWh='".$wh."' AND flag='0'");
		$qty=0;while($outItemRow = mysql_fetch_array($outItem)){$qty += $outItemRow['qty'];}
			$strContentx.="<td style='padding:5px;text-align:center;'>".$qty."</td>";
			$strContentx.="<td style='padding:5px;text-align:center;'>".($inItemRow['qty']-$qty)."</td>";
            $strContentx.="</tr>"; $a +=$inItemRow['qty'];  $b +=$qty; $c += ($inItemRow['qty']-$qty);
		$strContentx.="</tr>";
		}
$strContentx.="<tr><td colspan='3' style='padding:5px;text-align:center;'><b>Total</b></td><td style='padding:5px;text-align:center;'><b>$a</b></td><td style='padding:5px;text-align:center;'><b>$b</b></td><td style='padding:5px;text-align:center;'><b>$c</b></td></tr>";
$strContentx.="</tbody>";
$strContentx.="</table>";
}
$mpdf->WriteHTML($strContentx);
$mpdf->Output();
exit;
?>