<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
include('../mpdf60/mpdf.php');
$stylesheet = file_get_contents('../../styles/pdf_style.css');
$alias = $_REQUEST['alias'];
$heading = 'REFRESHING DETAILS';
$sql = mysqli_query($mr_con,"SELECT createdDate,refreshing_no,wh_alias,eng_name,pdf FROM ec_material_refreshing WHERE item_alias ='$alias' AND flag='0' GROUP BY item_alias");
		if(mysqli_num_rows($sql)){ $row=mysqli_fetch_array($sql);
		$download='<html><body><table class="table1">
					<tr>
						<td>
							<table class="tableHeader" width="100%">
							<tr>
								<td align="left" width="35%"><img src="../../images/gallery/logo1.png"></td>
								<td align="center" width="50%"><h3>'.$heading.'</h3></ td>
								<td align="right" width="35%"><img src="../../images/gallery/logo-4.jpg" width="100px"></td>
							</tr>
						</table>
					<table class="cont_3">
						<tr>
							<td align="left">'.strtoupper($heading).'</td>
						</tr>
					</table>';
				$download.="<table width='100%' class='simp'>";
					$download.="<tr>";
						$download.="<td class='col-md-5 Exp_dashboard'>";
							$download.="<h4>REFRESHING No</h4>";
							$download.="<p>".checkempty(strtolower($row['refreshing_no']))."</p>";
						$download.="</td>";
						$download.="<td>";
						$download.="<h4>WARE HOUSE</h4>";
							$download.="<p>".checkempty(ucfirst(strtolower(alias($row['wh_alias'],'ec_warehouse','wh_alias','wh_code'))))."</p>";
						$download.="</td>";
						$download.="</tr>";
					$download.="<tr>";
						$download.="<td>";
							$download.="<h4>ENGINEER NAME</h4>";
							$download.="<p>".checkempty(ucfirst(strtolower($row['eng_name'])))."</p>";
						$download.="</td>";
						$download.="<td>";
							$download.="<h4>PDF</h4>";
							$download.="<p><a href='".checkempty(ucfirst(strtolower($row['pdf'])))."'>Click Here</a></p>";
						$download.="</td>";
					$download.="</tr>";
					$download.="<tr>";
						$download.="<td>";
							$download.="<h4>TRANSACTION DATE</h4>";
							$download.="<p>".checkempty($row['createdDate'])."</p>";
						$download.="</td>";
					$download.="</tr>";
				$download.="</table>";
				
					$sql1 = mysqli_query($mr_con,"SELECT * FROM ec_material_refreshing WHERE item_alias ='$alias' AND flag='0'");
					if(mysqli_num_rows($sql1)){$cap_arr=array();
						$download1.='<table class="cont_3" style="width:100%"><tr><td align="left"><h3>VIEW REFRESHING</h3></td></tr></table>';
						$download1.='<table cellpadding="7"><tr><th align="left" width="6%"><h3>SR.NO</h3></th><th align="left" width="8%"><h3>Cell Sr. No</h3></th><th align="left" width="8%"><h3>Capacity</h3></th><th align="left" width="6%"><h3>Mfd. Date</h3></th><th align="left" width="6%"><h3>OCV</h3></th><th align="left" width="6%"><h3>Discharge Current</h3></th><th align="left" width="6%"><h3>1st Hr</h3></th><th align="left" width="6%"><h3>2nd Hr</h3></th><th align="left" width="6%"><h3>3rd Hr</h3></th><th align="left" width="6%"><h3>4th Hr</h3></th><th align="left" width="6%"><h3>5th Hr</h3></th><th align="left" width="6%"><h3>6th Hr</h3></th><th align="left" width="6%"><h3>7th Hr</h3></th><th align="left" width="6%"><h3>8th Hr</h3></th><th align="left" width="6%"><h3>9th Hr</h3></th><th align="left" width="6%"><h3>10th Hr</h3></th><th align="left" width="8%"><h3>Result</h3></th></tr>';
						$i=0;while($row1=mysqli_fetch_array($sql1)){$result=$row1['result'];
						$download1.='<tr><td>'.($i+1).'</td>';
						$download1.='<td>'.checkempty(alias($row1['cell_sr_no'],'ec_item_code','item_code_alias','item_description')).'</td>';
						$item_code = alias($row1['cell_sr_no'],'ec_item_code','item_code_alias','item_code');
						if(!array_key_exists($item_code,$cap_arr))$cap_arr[$item_code]=alias($item_code,'ec_product','product_alias','product_description');
						$download1.='<td>'.checkempty($cap_arr[$item_code]).'</td>';
						$download1.='<td>'.checkempty($row1['mf_date']).'</td>';
						$download1.='<td>'.checkemptydash($row1['ocv']).'</td>';
						$download1.='<td>'.checkemptydash($row1['dis_current']).'</td>';
						$download1.='<td>'.checkemptydash($row1['1hr']).'</td>';
						$download1.='<td>'.checkemptydash($row1['2hr']).'</td>';
						$download1.='<td>'.checkemptydash($row1['3hr']).'</td>';
						$download1.='<td>'.checkemptydash($row1['4hr']).'</td>';
						$download1.='<td>'.checkemptydash($row1['5hr']).'</td>';
						$download1.='<td>'.checkemptydash($row1['6hr']).'</td>';
						$download1.='<td>'.checkemptydash($row1['7hr']).'</td>';
						$download1.='<td>'.checkemptydash($row1['8hr']).'</td>';
						$download1.='<td>'.checkemptydash($row1['9hr']).'</td>';
						$download1.='<td>'.checkemptydash($row1['10hr']).'</td>';
						$download1.='<td>'.checkemptydash(($result=='6' ? 'In Progress' : ($result=='2' ? 'Pass':($result=='3' ? 'Fail':($result=='0' ? 'Charged':'NA'))))).'</td>';
						$i++;}
					$download1.='</tr></table>';
				}					
		$download.='</td></tr></table></body></html>';
	}
	else{$download='<h2 style="text-align:center">No Records<h2>';}
	$mpdf=new mPDF('','', 0, '', 5, 5, 5, 5, '', '2', '');
	$mpdf->SetHTMLFooter("<p style=\"text-align:right;font-style: italic;font-size:12px;\">Page No : {PAGENO}/{nbpg}</p>");
	$mpdf->SetWatermarkImage('../../images/gallery/logo-3.png');
	$mpdf->showWatermarkImage = true;
	$mpdf->watermarkImageAlpha = 0.06;
	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($download,2);
	$mpdf->AddPage('L','','','0','',5,5,5,5,'',2);
	$mpdf->WriteHTML($download1,3);
	$filename='Refreshing_'.date('d-m-Y_H_i_s');
	$mpdf->Output("$filename.pdf", "I");
	exit;
?>