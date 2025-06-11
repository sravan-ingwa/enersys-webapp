<?php
date_default_timezone_set("Asia/Kolkata");
include('mysql.php');
include('pdfinclude/mpdf.php');
//$mpdf=new mPDF($mode, $format, $font_size, $font, $margin_left, $margin_right, $margin_top, $margin_bottom, $margin_header, $margin_footer, $orientation);
$mpdf=new mPDF('','', 0, '', 15, 15, 30, 16, 9, 9, '');
$res='
<div class="container-fluid">
<br>
<br>
  <table class="table table-hover table-bordered">
    <thead>
    <tr>
    	<th colspan="14">I&C Battery Observation Report</th>
    </tr>';
	$ticket_alias=$_REQUEST['ticket_alias'];
	$sql1=mysqli_query($mr_con,"SELECT * FROM ec_battery_bank_bb_cap WHERE ticket_alias='$ticket_alias' AND flag=0");
	$row1=mysqli_fetch_array($sql1);
 $res.='<tr>
    	<th colspan="9" class="text-left">Battery Bank Rating: '.$row1['battery_bank_rating'].'</th>
        <th colspan="5" class="text-left">BB Capacity:'.$row1['bb_capacity'].' </th>
    </tr>
      <tr>
        <th rowspan="2">Sl No</th>
        <th rowspan="2">Cell Sl No</th>
        <th rowspan="2">MF Date</th>
        <th rowspan="2">OCV</th>
        <th colspan="3">On Charge Voltage</th>
        <th colspan="3">DisCharge Voltage</th>
        <th colspan="4">On Charge Voltage</th>
      </tr>
      <tr>
        <th>1 hr</th>
        <th>2 hr</th>
        <th>3 hr</th>
        <th>1 hr</th>
        <th>2 hr</th>
        <th>3 hr</th>
        <th>1 hr</th>
        <th>2 hr</th>
        <th>3 hr</th>
        <th>Remarks</th>
      </tr>
    </thead>
    <tbody>';
	$sql=mysqli_query($mr_con,"SELECT * FROM ec_bo_telecom_ic WHERE battery_bb_alias='".$row1['item_alias']."' AND flag=0");
	  $n=1;while($row=mysqli_fetch_array($sql)){
		$ocv += $row['ocv']; $hr1 += $row['1hr'];$hr2 += $row['2hr'];$hr3 += $row['3hr'];$hr4 += $row['4hr'];
		$hr5 += $row['5hr'];$hr6 += $row['6hr'];$hr7 += $row['7hr'];$hr8 += $row['8hr'];$hr9 += $row['9hr'];
	  $res.='<tr>
        <td>'.$n.'</td>
        <td>'.$row['cell_sl_no'].'</td>
        <td>'.$row['mf_date'].'</td>
        <td>'.$row['ocv'].'</td>
        <td>'.$row['1hr'].'</td>
        <td>'.$row['2hr'].'</td>
        <td>'.$row['3hr'].'</td>
        <td>'.$row['4hr'].'</td>
        <td>'.$row['5hr'].'</td>
        <td>'.$row['6hr'].'</td>
        <td>'.$row['7hr'].'</td>
        <td>'.$row['8hr'].'</td>
        <td>'.$row['9hr'].'</td>
        <td>'.$row['remarks'].'</td>
      </tr>';
	  $n++;}
      $res.='<tr class="tbl">
      	<td colspan="3">Total Voltage (V)</td>
        <td>'.$ocv.'</td>
        <td>'.$hr1.'</td>
        <td>'.$hr2.'</td>
        <td>'.$hr3.'</td>
        <td>'.$hr4.'</td>
        <td>'.$hr5.'</td>
        <td>'.$hr6.'</td>
        <td>'.$hr7.'</td>
        <td>'.$hr8.'</td>
        <td>'.$hr9.'</td>
        <td></td>
      </tr>
       <tr>
      	<td colspan="4">Charging Current (I)</td>
        <td>+</td>
        <td>+</td>
        <td>+</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>+</td>
        <td>+</td>
        <td>+</td>
        <td></td>
      </tr>
    </tbody>
  </table>
</div>';
//echo $res;
	$stylesheet = file_get_contents('bootstrap.css');
	$style = '
	table th{text-align:center;color:#2a6496;font-size:11px;}
	table td{font-size:10px;}
	.text-left{text-align:left !important;}
	.table thead tr th, .table tbody tr td{padding:7px !important;}
	@media print{.table-bordered>tbody>tr>td, .table-bordered>thead>tr>th{border: 1px solid #000 !important} .table th{color:#000;}}';
	$mpdf->SetHTMLHeader("<div style='text-align: left;'><img src='EnerSyslogo.png' alt='EnerSyslogo' width='150'></div>");
	$mpdf->SetWatermarkImage('EnerSyslogo.png');
	$mpdf->showWatermarkImage = true;
	$mpdf->watermarkImageAlpha = 0.05;
	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($style,1);
	$mpdf->WriteHTML($res,2);
	$mpdf->Output();
	//$mpdf->Output('physical_'.date('Y-m-d_H:i:s').'.pdf', 'D');
	exit;
?>
