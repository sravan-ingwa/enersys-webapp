<?php
include('efsr.php');
ini_set('memory_limit','128M');
//ini_set('memory_limit','-1');

$base_url= localURL() . "mobile_app/";

function imgcheck($fv1){ global $base_url; if($fv1!="" && $fv1!='0'){return '<img style="float:right;" src="'.$base_url.$fv1.'" height="70" width="70"/>';}}
function signcheck($fv1){ global $base_url; if($fv1!="" && $fv1!='0'){return '<img style="float:right;" src="'.$base_url.$fv1.'" width="80"/>';}else{ return "NA";}}
function cust_signcheck($fv1){ global $base_url; if(empty($fv1))return "Customer Not Available";elseif($fv1=='1')return "Customer Is Not Ready To Sign";else return '<img style="float:right;" src="'.$base_url.$fv1.'" width="80"/>';}
function checkEmpty_pdf($label,$value,$per){return ($value!="" && $value!='NA' ? "<td width='$per%'><h3>$label</h3><p>".($value=='0' ? 'Zero(0)' : $value)."</p></td>":"");}
function checkEmpty_pdf_new($label,$value) { return ($value!="" && $value!='NA' ? "<h3>$label</h3><p>".($value=='0' ? 'Zero(0)' : $value)."</p>":""); }
function submit_duration($min_date,$max_date){
	if(!empty($min_date) && $min_date!='0000-00-00 00:00:00' && !empty($max_date) && $max_date!='0000-00-00 00:00:00'){
		return round(abs(strtotime($max_date)-strtotime($min_date))/60);
	}else return "";
}
function none_empty_tags($string,$ref){
	include_once('simplehtmldom/simple_html_dom.php');	
	$html = str_get_html($string);
	if(!empty($html)){
		foreach($html->find("td") as $kk=>$ht)if(($kk)%$ref==($ref-1))$ht->outertext .= '</tr><tr>';
		$html->save();
	}return $html;
}
function gettwodecimal($fv1){ if(is_numeric($fv1))return number_format($fv1, 2, '.', '');else return '0.00';}

function star($q){
	for($i=1;$i<=5;$i++)$stars.="<img src='images/".($i<=$q ? ($q==1 ? 'rated-red':($q==2 || $q==3 ? 'rated-orange':($q==4 || $q==5 ? 'rated-green':'empty'))) : 'empty').".png' width='25px'>";
	return $stars;
}
$stylesheet = file_get_contents('css/pdf_style.css');
$page1='<html><body>
			<table class="cont_3">
				<tr>
					<td align="left">TICKET DETAILS</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>';
			$string=checkEmpty_pdf('Ticket ID',$result['ticket_id'],20).
					checkEmpty_pdf('Login Date',$result['login_date'],20).
					checkEmpty_pdf('Activity',$result['activity_code'],20).
					checkEmpty_pdf('Segment',$result['segment_name'],20).
					checkEmpty_pdf('Nature Of Complaint',$result['complaint_name'],20).
				
					checkEmpty_pdf('Site ID',$result['site_id'],20).
					checkEmpty_pdf('Site Name',$result['site_name'],20).
					checkEmpty_pdf('Zone',$result['zone_name'],20).
					checkEmpty_pdf('State',$result['state_name'],20).
					checkEmpty_pdf('District',$result['district_name'],20).

					checkEmpty_pdf('Activation Date',$result['activation_date'],20).
					checkEmpty_pdf('Planned Date',$result['planned_date'],20).
					checkEmpty_pdf('Manf. Date',$result['mfd_date'],20).
					checkEmpty_pdf('Installation Date',$result['install_date'],20).
					checkEmpty_pdf('Customer Name',$result['customer_name'],20).

					checkEmpty_pdf('Service Engineer',$result['emp_name'],20).
					checkEmpty_pdf('Engineer Mobile',$result['emp_mobile_number'],20).
					checkEmpty_pdf('Site Technician',$result['technician_name'],20).
					checkEmpty_pdf('Technician Number',$result['technician_number'],20).
					checkEmpty_pdf('No.of Banks',$result['no_of_string'],20).
					
					checkEmpty_pdf('Site Type',$result['site_type'],20).
					checkEmpty_pdf('Product Description',$result['product_description'],20).
					checkEmpty_pdf('Battery Bank Rating',$result['battery_bank_rating'],20).
					checkEmpty_pdf('Mode Of Contact',$result['mode_of_contact'],20).
					checkEmpty_pdf('MOC Number',$result['moc_num'],20).
					checkEmpty_pdf('Faulty Cells Count',$result['faulty_cell_count'],20).
					
					checkEmpty_pdf('Sales Invoice Number',$result['sales_invoice_number'],20).
					checkEmpty_pdf('Sales Invoice Date',$result['sales_invoice_date'],20).
					checkEmpty_pdf('Sales PoNumber',$result['sales_po_no'],20).
					checkEmpty_pdf('Service PoNumber',$result['service_po_number'],20).

					checkEmpty_pdf('Service PoDate',$result['service_po_date'],20).
					//checkEmpty_pdf('Warranty',$result['warranty'],20).
					'<td width="20%"><h3>Warranty</h3><p>'.($result['mfd_date']!='NA' || $result['install_date']!='NA' || $result['sales_invoice_date']!='NA' ? $result['warranty'] : 'NA').'<p></td>'.
					($result['dispat']!='' || $result['inst']!='' ? '<td width="20%"><h3>Warranty Terms </h3><p>'.($result['mfd_date']!='NA' || $result['install_date']!='NA' || $result['sales_invoice_date']!='NA' ? 'DIS('.$result['dispat'].');DOI('.$result['inst'].')' : 'NA').'<p></td>' : '').
					checkEmpty_pdf('Complaint Description',str_replace(",",", ",$result['description']),20).
					($result['site_address']!='' ? '<td width="20%" colspan="'.(strlen($result['site_address'])>30 ? '2' : '1').'"><h3>Site Address </h3><p>'.$result['site_address'].'<p></td>' : '');
			$page1.=none_empty_tags($string,5).'</tr>
			</table>';
if($result['segment_alias']!='TMRY7UL2VI'){ //Not Others
	$dg_st=($result['dg_status']=='AVAILABLE' ? TRUE : FALSE);
	$eb_sp=(strpos(strtoupper($result['eb_supply']),'YES')!==false ? TRUE : FALSE);
	if($result['segment_alias']=='TQMBDTF5ZI'){ // For Railways
			$page1.='<table class="cont_3">
				<tr>
					<td align="left">HISTORY OF THE COACH</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>';
				$string="";
			if($result['no_of_banks']!=''){
				$string.=checkEmpty_pdf('No Of Banks ',$result['no_of_banks'],25);
				for($i=0;$i<count($result['bb_make']);$i++){
			$string.=checkEmpty_pdf('BB Make '.($i+1),$result['bb_make'][$i],25).
					checkEmpty_pdf('BB Capacity '.($i+1),$result['bb_capacity'][$i],25).
					checkEmpty_pdf('Mfd Dt. '.($i+1),$result['mfdt_date'][$i],25).
					checkEmpty_pdf('Install Dt. '.($i+1),$result['installdt_date'][$i],25);
				}
			}
			$string.=checkEmpty_pdf('Train Number',$result['train_no'],25).
					checkEmpty_pdf('Express Name',$result['express_name'],25).
					checkEmpty_pdf('Coach Number',$result['coach_no'],25).
					checkEmpty_pdf('Previous Attended Date',$result['pre_attnd'],25).

					checkEmpty_pdf('POH Date',$result['poh'],25).
					checkEmpty_pdf('RPOH Date',$result['rpoh'],25).
					checkEmpty_pdf('Zone',$result['zone'],25).
					checkEmpty_pdf('Division',$result['division'],25).

					checkEmpty_pdf('Workshop OR Yard',$result['workshop'],25);
		$page1.=none_empty_tags($string,4).'</tr>
			</table>';
			$page1.='<table class="cont_3">
				<tr>
					<td align="left">EQUIPMENT DETAILS</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>';
			$string=checkEmpty_pdf('Alternator Capacity',$result['alternator_capacity'],25).
					checkEmpty_pdf('RRU ERRU Make',$result['rru_make'],25).
					checkEmpty_pdf('Regulator Make',$result['regulator_make'],25).
					checkEmpty_pdf('Voltage Regulation',$result['voltage_regulation'],25).
					
					checkEmpty_pdf('Current Limit',$result['current_limit'],25).
					checkEmpty_pdf('Equip Charger Cut Off',$result['equip_charger_cut_off'],25).
					checkEmpty_pdf('High Voltage Cut Off',$result['high_voltage_cut_off'],25).
					checkEmpty_pdf('Invertor Mode',$result['invertor_mode'],25).
					
					checkEmpty_pdf('Low Voltage Cut Off',$result['low_voltage_cut_off'],25).
					($result['altenate_make']!='' ? '<td width="25%"><b>Alternate Make : </b>'.$result['altenate_make'].'<br>'.imgcheck($result['altenate_make_doc']).'</td>' : '').
					($result['altenate_belt_status']!='' ? '<td width="25%"><b>Alternator Belt Status : </b>'.$result['altenate_belt_status'].'<br>'.imgcheck($result['altenate_belt_doc']).'</td>' : '').
					($result['invertor_make']!='' ? '<td width="25%"><b>Invertor Make : </b>'.$result['invertor_make'].'<br>'.imgcheck($result['invertor_make_doc']).'</td>' : '');
		$page1.=none_empty_tags($string,4).'</tr>
			</table>';
			$page1.='<table class="cont_3">
				<tr>
					<td align="left">CHECK POINTS</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>';
			$string=checkEmpty_pdf('ICC Tightness',$result['icc_tightness'],25).
					checkEmpty_pdf('Any Heating OR Melt Marks',$result['heating_melting_marks'],25).
					checkEmpty_pdf('Terminal Tightness',$result['terminal_tightness'],25).
					checkEmpty_pdf('Alternate No Of Belts Available',$result['alt_no_belt_avl'],25).

					checkEmpty_pdf('Vent Plug Tightness',$result['vent_plug_tightness'],25).
					checkEmpty_pdf('Vent Belt',$result['belt'],25).
					checkEmpty_pdf('Log Book',$result['log_book'],25).
					checkEmpty_pdf('Coach Status',$result['coach_status'],25).

					checkEmpty_pdf('Terminal Temp',$result['terminal_temp'],25).
					checkEmpty_pdf('Physical Conditions',$result['valuephysicalcondition'],25).
					checkEmpty_pdf('Leakage Conditions',$result['valueleakagecondition'],25).
					($result['physical_damage']!='' ? '<td width="25%"><b>Any Physical Damages : </b>'.$result['physical_damage'].'<br>'.imgcheck($result['physical_damage_pic']).'</td>' : '').

					($result['any_leakage']!='' ? '<td width="25%"><b>Any Leakage : </b>'.$result['any_leakage'].'<br>'.imgcheck($result['leakage_image_pic']).'</td>' : '').
					($result['cell_buldge']!='' ? '<td width="25%"><b>Cell Budge : </b>'.$result['cell_buldge'].'<br>'.imgcheck($result['cell_buldge_pic']).'</td>' : '');
			$page1.=none_empty_tags($string,4).'</tr>
			</table>';
	}elseif($result['segment_alias']=='YGRKJJD4N7'){ // For Motive Power
			$page1.='<table class="cont_3">
				<tr>
					<td align="left">PHYSICAL OBSERVATION</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>';
			$string="";
				if($result['no_of_banks']!=''){
					$string.=checkEmpty_pdf('No Of Banks ',$result['no_of_banks'],25);
					for($i=0;$i<count($result['bb_make']);$i++){
				$string.=checkEmpty_pdf('BB Make '.($i+1),$result['bb_make'][$i],25).
						checkEmpty_pdf('BB Capacity '.($i+1),$result['bb_capacity'][$i],25).
						checkEmpty_pdf('Mfd Dt. '.($i+1),$result['mfdt_date'][$i],25).
						checkEmpty_pdf('Install Dt. '.($i+1),$result['installdt_date'][$i],25);
					}
				}
			$string.=($result['temperature']!='' && $result['ambient_temperature']!='' ? '<td width="25%"><h3>Temperature Details</h3><p>ROOM: '.$result['temperature'].'<sup>o</sup>C | AMBIENT: '.$result['ambient_temperature'].'<sup>o</sup>C</td>' : '').
					checkEmpty_pdf('General Observations',$result['general_observation'],25).
					checkEmpty_pdf('Terminal Torque',$result['terminal_torque'],25).

					checkEmpty_pdf('Cells Temp After Usage',$result['cells_temp_after_use'],25).
					checkEmpty_pdf('Cells Temp At Charging',$result['cells_temp_at_charge'],25).
					checkEmpty_pdf('BB Condition',$result['bb_condition'],25).
					checkEmpty_pdf('Electrolyte Temp On Discharge',$result['acid_temp_discharge'],25).

					checkEmpty_pdf('Electrolyte Temp On Charge',$result['acid_temp_charge'],25).
					checkEmpty_pdf('Electrolyte Temp Before Charging',$result['electrolyte_temp_before'],25).
					checkEmpty_pdf('Electrolyte Temp Before Restperiod',$result['electrolyte_temp_before_restperiod'],25).
					checkEmpty_pdf('Electrolyte Temp Before Hour',$result['electrolyte_temp_before_hr'],25).
					
					
					checkEmpty_pdf('Electrolyte Temp After Charging',$result['electrolyte_temp_after'],25).
					checkEmpty_pdf('Electrolyte Temp After Restperiod',$result['electrolyte_temp_after_restperiod'],25).
					checkEmpty_pdf('Electrolyte Temp After Hour',$result['electrolyte_temp_after_hr'],25).
					checkEmpty_pdf('DM Water Filling Type',$result['dm_water_filling_type'],25).
					
					($result['physical_damages']!='' ? '<td width="25%"><b>Physical Damages : </b>'.$result['physical_damages'].'<br>'.imgcheck($result['physical_damages_document']).'</td>' : '').
					($result['leakage']!='' ? '<td width="25%"><b>Leakage : </b>'.$result['leakage'].'<br>'.imgcheck($result['leakage_document']).'</td>' : '').
					($result['battery_top']!='' ? '<td width="25%"><b>Battery Top : </b>'.$result['battery_top'].'<br>'.imgcheck($result['battery_top_image']).'</td>' : '').
					($result['log_book']!='' ? '<td width="25%"><b>Log Book : </b>'.$result['log_book'].'<br>'.imgcheck($result['log_image']).'</td>' : '').
					
					($result['module']['MTPWR'][0]['other_issue']!='' ? '<td width="25%"><b>Other Issue : '.$result['module']['MTPWR'][0]['other_issue'].'<br>'.imgcheck($result['module']['MTPWR'][0]['other_image']).'</td>' : '');;
		$page1.=none_empty_tags($string,4).'</tr>
			</table>';
			$page1.='<table class="cont_3">
				<tr>
					<td align="left">Charger Details</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>';
			$string=checkEmpty_pdf('Charger Type',$result['charger_type'],25).
					checkEmpty_pdf('Charger Manufacturing Date',$result['charger_manufacturing_date'],25).
					checkEmpty_pdf('Serial Number',$result['serial_no'],25).
					checkEmpty_pdf('Max Current Limit',$result['charging_current'],25).
					
					($result['high_voltage_cutoff']!='' ? '<td width="25%"><h3>High Voltage Cut Off</h3><p>'.$result['high_voltage_cutoff'].' V</td>' : '').
					($result['voltage_ripple']!='' ? '<td width="25%"><h3>Voltage Ripple</h3><p>'.$result['voltage_ripple'].' V</td>' : '').
					($result['voltage_regulation']!='' ? '<td width="25%"><h3>Voltage Regulation</h3><p>'.$result['voltage_regulation'].' V</td>' : '').
					//checkEmpty_pdf('High Voltage Cut Off',$result['high_voltage_cutoff'],25).
					//checkEmpty_pdf('Voltage Ripple',$result['voltage_ripple'],25).
					//checkEmpty_pdf('Voltage Regulation',$result['voltage_regulation'],25).
					checkEmpty_pdf('Charging Capacity',$result['charger_capacity'],25).

					checkEmpty_pdf('Charging Input',$result['charger_input'],25).
					checkEmpty_pdf('Equalize Charger Mode',$result['equalize_charger_mode'],25).
					checkEmpty_pdf('Equalize',$result['valueofequalize'],25).
					($result['voltage']!="" ? '<td width="25%"><b>Charger Max Voltage Limit : </b>'.$result['voltage'].' V<br>'.imgcheck($result['charger_pic']).'</td>' : '').
					($result['charger_band']!='' ? '<td width="25%"><b>Charger Make : </b>'.$result['charger_band'].'<br>'.imgcheck($result['charger_image']).'</td>' : '');
		$page1.=none_empty_tags($string,4).'</tr>
			</table>';		
			$page1.='<table class="cont_3">
				<tr>
					<td align="left">Forklift Details</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>';
			$string=checkEmpty_pdf('Forklift Model',$result['fork_lift_model'],25).
					checkEmpty_pdf('Forklift Manufacturing Date',$result['fork_lift_manf_date'],25).
					checkEmpty_pdf('Forklift Installation Date',$result['forklift_install_date'],25).
					checkEmpty_pdf('Forklift Capacity',$result['forlift_capacity'],25).
					checkEmpty_pdf('Motor Capacity',$result['motor_capacity'],25).
					checkEmpty_pdf('Under Voltage Cut Off',$result['under_voltage_cutoff'],25).
					checkEmpty_pdf('Max Load Current',$result['max_load_current'],25).
					($result['fork_lift_brand']!='' ? '<td width="25%"><b>Forklift Make : </b>'.$result['fork_lift_brand'].'<br>'.imgcheck($result['fork_lift_pic']).'</td>' : '');
		$page1.=none_empty_tags($string,4).'</tr>
			</table>';
			$page1.='<table class="cont_3">
				<tr>
					<td align="left">Battery Details</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>';
			$string=checkEmpty_pdf('Battery Type',$result['battey_type'],25).
					checkEmpty_pdf('Battery Bank Serial Number',$result['bank_serial_no'],25).
					checkEmpty_pdf('Manufacturing Date',$result['battey_manf_date'],25).
					checkEmpty_pdf('Installation Date',$result['battey_ins_date'],25).

					checkEmpty_pdf('Plug Type',$result['plug_type'],25).
					checkEmpty_pdf('Acid Level',$result['acid_level'],25);
		$page1.=none_empty_tags($string,4).'</tr>
			</table>';
	}else{ // other than Railways and Motive Power
			$page1.='<table class="cont_3">
				<tr>
					<td align="left">PHYSICAL OBSERVATION</td>
				</tr>
			</table>';
			$page1.='<table class="cont_2"><tr>';
			$string="";
			if($result['no_of_banks']!=''){
				$string.=checkEmpty_pdf('No Of Banks ',$result['no_of_banks'],25);
				for($i=0;$i<count($result['bb_make']);$i++){
			$string.=checkEmpty_pdf('BB Make '.($i+1),$result['bb_make'][$i],25).
					checkEmpty_pdf('BB Capacity '.($i+1),$result['bb_capacity'][$i],25).
					checkEmpty_pdf('Mfd Dt. '.($i+1),$result['mfdt_date'][$i],25).
					checkEmpty_pdf('Install Dt. '.($i+1),$result['installdt_date'][$i],25);
				}
			}
			
			$string.=($result['temperature']!='' && $result['ambient_temperature']!='' ? '<td width="25%"><b>Temperature Details : </b>'.$result['temperature_type'].'<br><p>ROOM: '.$result['temperature'].'<sup>o</sup>C | AMBIENT: '.$result['ambient_temperature'].'<sup>o</sup>C</td>' : '').
					checkEmpty_pdf('Temperature Condition',$result['temp_data'],25).
					checkEmpty_pdf('General Observations',$result['general_observation'],25).
					($result['vent_plug_type']!='' ? '<td width="25%"><h3>Vent plug Tightness</h3><p>'.$result['vent_plug_type'].'</p></td>' : '').
					($result['terminal_torque']!='' ? '<td width="25%"><h3>Terminal Torque</h3><p>'.$result['terminal_torque'].'</p></td>' : '').
					checkEmpty_pdf('No Of Cell Tightened',$result['no_of_cell_tightened'],25).
					
					checkEmpty_pdf('DG Status',$result['dg_sta'],25).
					checkEmpty_pdf('EB Status',$result['eb_sta'],25).
					checkEmpty_pdf('Module Cleanness',$result['cleanness'],25).
					checkEmpty_pdf('Site Input',$result['site_input'],25).
					($result['physical_damages']!='' ? '<td width="25%"><b>Physical Damages : </b>'.$result['physical_damages'].'<br>'.imgcheck($result['physical_damages_document']).'</td>' : '').
					($result['leakage']!='' ? '<td width="25%"><b>Leakage : </b>'.$result['leakage'].'<br>'.imgcheck($result['leakage_document']).'</td>' : '').
					($result['module']['PHYOBS'][0]['other_issue']!='' ? '<td width="25%"><b>Other Issue : </b>'.$result['module']['PHYOBS'][0]['other_issue'].'<br>'.imgcheck($result['module']['PHYOBS'][0]['other_image']).'</td>' : '');
		$page1.=none_empty_tags($string,4).'</tr>
			</table>';
		$page1.='<table class="cont_3">
				<tr>
					<td align="left">GENERATOR & POWER OBSERVATIONS</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>';
			$string=checkEmpty_pdf('DG Make ',$result['dg_make'],25).
					($result['dg_capacity']!='' ? '<td width="25%"><h3>DG Capacity </h3><p>'.$result['dg_capacity'].' KVA</p></td>' : '').
					($result['dg_working_condition']!='' ? '<td width="25%"><h3>Working Condition</h3><p>'.$result['dg_working_condition'].'</p></td>' : '').
					($result['avg_dg_run']!='' ? '<td width="25%"><h3>Avg DG Run</h3><p>'.$result['avg_dg_run'].' HRS/DAY</td>' : '').
					checkEmpty_pdf('DG Output',$result['dg_output'],25).
					checkEmpty_pdf('E.B Supply ',$result['eb_supply'],25).
					($result['failures_per_day']!='' ? '<td width="25%"><h3>No.Of Power Cuts</h3><p>'.$result['failures_per_day'].' IN A DAY</p></td>' : '').
					($result['avg_power_cut']!='' ? '<td width="25%"><h3>Average Power Cut</h3><p>'.$result['avg_power_cut'].' HRS/DAY</p></td>' : '').
					($result['ebinstalldate']!='NA' ? '<td width="25%"><h3>EB Install Date</h3><p>'.$result['ebinstalldate'].'</p></td>' : '').
					($result['dg_status']!='' ? '<td width="25%"><b>DG Status : </b>'.$result['dg_status'].'<br>'.imgcheck($result['dg_pic']).'</td>' : '').
					($result['module']['GNRLOBS'][0]['other_issue']!='' ? '<td width="25%"><b>Other Issue : </b>'.$result['module']['GNRLOBS'][0]['other_issue'].'<br>'.imgcheck($result['module']['GNRLOBS'][0]['other_image']).'</td>' : '');
		$page1.=none_empty_tags($string,4).'</tr>
			</table>';
	}
}
if($result['segment_alias']!='TMRY7UL2VI' && $result['segment_alias']!='TQMBDTF5ZI' && $result['segment_alias']!='YGRKJJD4N7'){
		//SMPS Observation
		//SA && TS
		//$page1.='<pagebreak>';
		for($i=0;$i<count($result['technical_obs']);$i++){ $technical_arr=$result['technical_obs'][$i];
			$page1.='<table class="cont_3">
					<tr>
						<td align="left">'.$technical_arr['smps_heading'].' - '.$technical_arr['panel_make'].'</td>
					</tr>
				</table>
				<table class="cont_2">
					<tr>';
				$string=($technical_arr['float_voltage']!='' ? '<td width="25%"><b>Float Voltage : </b>'.$technical_arr['float_voltage'].' V<br>'.imgcheck($technical_arr['float_voltage_image']).'</td>' : '').
						($technical_arr['boast_voltage']!='' ? '<td width="25%"><b>Boost Voltage : </b>'.$technical_arr['boast_voltage'].' V<br>'.imgcheck($technical_arr['boast_voltage_image']).'</td>' : '').
						($technical_arr['current_limit']!='' ? '<td width="25%"><h3>Current Limit </h3><p>'.$technical_arr['current_limit'].' AMPS</p></td>' : '').
						($technical_arr['voltage_ripple']!='' ? '<td width="25%"><h3>Voltage Ripple </h3><p>'.$technical_arr['voltage_ripple'].' MV</p></td>' : '').
						($technical_arr['high_voltage_cutoff']!=''  ? '<td width="25%"><h3>High Voltage Cut Off </h3><p>'.$technical_arr['high_voltage_cutoff'].' V</p></td>' : '').
						($technical_arr['low_voltage_cutoff']!=''  ? '<td width="25%"><h3>Low Voltage Cut Off </h3><p>'.$technical_arr['low_voltage_cutoff'].' V</p></td>' : '').
						//checkEmpty_pdf($technical_arr['smps_label'].' Make',$technical_arr['panel_make'],25).
						checkEmpty_pdf($technical_arr['smps_label'].' Rating',$technical_arr['panel_rating'],25).
						checkEmpty_pdf($technical_arr['smps_label'].' Manf. Date',$technical_arr['panel_manufacturing_date'],25).

						($technical_arr['auto_boost']!=''  ? '<td width="25%"><h3>Auto Boost</h3><p>'.$technical_arr['auto_boost'].'</p></td>' : '').
						($technical_arr['temp_compensation']!=''  ? '<td width="25%"><h3>Temp Compensation</h3><p>'.$technical_arr['temp_compensation'].'</p>' : '').

						($technical_arr['voltage_regulation']!='' && $result['segment_alias']!='HXL5A1HOTZ' ? '<td width="25%"><h3>Voltage Regulation</h3><p>'.$technical_arr['voltage_regulation'].'</p></td>' : '').
						checkEmpty_pdf($technical_arr['smps_label'].' Installation Date',$technical_arr['panel_installation_date'],25);
			if($result['segment_alias']=='KWJCZKSTBL' || $result['segment_alias']=='DDEYO7NTTC'){ // SA OR TS
				$string.=checkEmpty_pdf('Charger Controller Rating',$technical_arr['charge_controller_rate'],25).
						checkEmpty_pdf('Charger Controller Make',$technical_arr['charge_controller_make'],25).

						($technical_arr['solar_system_rating']!=''  ? '<td width="25%"><h3>Solar System Rating</h3><p>'.$technical_arr['solar_system_rating'].'</p></td>' : '').
						($technical_arr['single_module_rating']!=''  ? '<td width="25%"><h3>Single Module Rated Voltage</h3><p>'.$technical_arr['single_module_rating'].'</p></td>' : '').
						($technical_arr['single_pv_moddule_rating_current']!='' ? '<td width="25%"><h3>Single PV Module Rating Current</h3><p>'.$technical_arr['single_pv_moddule_rating_current'].'</p></td>' : '').
						($technical_arr['pv_module_eff']!='' ? '<td width="25%"><h3>PV Module Eff</h3><p>'.$technical_arr['pv_module_eff'].'</p></td>' : '');
				
				if(($result['segment_alias']=='KWJCZKSTBL' && (!$dg_st && !$eb_sp)) || $result['segment_alias']=='DDEYO7NTTC'){
				$string.=($result['invertor_make']!=''  ? '<td width="25%"><h3>Invertor Make</h3><p>'.$result['invertor_make'].'</p></td>' : '').
						($result['invertor_capacity']!=''  ? '<td width="25%"><h3>Invertor Capacity</h3><p>'.$result['invertor_capacity'].'</p></td>' : '').
						($result['invertor_manu_date']!='' ? '<td width="25%"><h3>Invertor Mfg Date</h3><p>'.$result['invertor_manu_date'].'</p></td>' : '').
						($result['invertor_install_date']!='' ? '<td width="25%"><h3>Invertor Install Date</h3><p>'.$result['invertor_install_date'].'</p></td>' : '').

						($result['invertor_type']!=''  ? '<td width="25%"><h3>Invertor Type</h3><p>'.$result['invertor_type'].'</p></td>' : '').
						($result['invertor_load_current']!=''  ? '<td width="25%"><h3>Invertor Load Current</h3><p>'.$result['invertor_load_current'].'</p></td>' : '').
						($result['low_voltage_cutoff_inv']!='' ? '<td width="25%"><h3>Low Voltage Cutoff Inv</h3><p>'.$result['low_voltage_cutoff_inv'].'</p></td>' : '');
					}
				$string.=checkEmpty_pdf('Single Panel Rating (Watts)',$technical_arr['single_panel_rating'],25).
						 checkEmpty_pdf('Charge Controller Manufacturing Date',$technical_arr['charge_control_manufacturing_date'],25).
						($technical_arr['no_solar_panels']!='' ? '<td width="25%"><b>Number of Solar Panels : </b>'.($technical_arr['no_solar_panels']=='0' ? 'Zero(0)' : $technical_arr['no_solar_panels']).'<br>'.imgcheck($technical_arr['document_3']).'</td>' : '');
			}elseif($result['segment_alias']=='HXL5A1HOTZ'){ // TL
				$string.=($technical_arr['site_load']!='' ? '<td width="25%"><h3>Site Load </h3><p>'.gettwodecimal($technical_arr['site_load']).' AMPS</p></td>' : '').
						checkEmpty_pdf('SMR Module Rating('.$technical_arr['charge_controller_make'].')',$technical_arr['charge_controller_rate'],25).
						($technical_arr['no_solar_panels']!='' ? '<td width="25%"><b>Working Modules: </b>'.($technical_arr['no_solar_panels']=='0' ? 'Zero(0)' : $technical_arr['no_solar_panels']).'<br>'.imgcheck($technical_arr['document_3']).'</td>' : '').
						($technical_arr['single_panel_rating']!='' ? '<td width="25%"><b>SMPS Display : </b>'.$technical_arr['single_panel_rating'].'<br>'.imgcheck($technical_arr['document_5']).'</td>' : '').
						($technical_arr['voltage_regulation']!='' ? '<td width="25%"><b>LVD\'S Status : </b>'.$technical_arr['voltage_regulation'].'<br>'.imgcheck($technical_arr['document_4']).'</td>' : '').
						($result['module']['TLOBS'][0]['other_issue']!='' ? '<td width="25%"><b>Other Issue : </b>'.$result['module']['TLOBS'][0]['other_issue'].'<br>'.imgcheck($result['module']['TLOBS'][0]['other_image']).'</td>' : '');
			}
			$page1.=none_empty_tags($string,4).'</tr>
				</table>';
		}
}
$page1.='</body></html>';
if(count($battery_obs)>0){ $loop=$next=0;$a_next=1; $land=array(); $lim=24;
	for($i=0;$i<count($battery_obs);$i++){$cl_cnt[$i]=count($cell_sl_no[$i]);$loop+=ceil($cl_cnt[$i]/$lim);}
	$tro=0;$hspan=3;$motiv_seg=FALSE;$tr=1;
	if($result['segment_alias']=='YGRKJJD4N7'){ $motiv_seg=TRUE;$tr=2;}
	for($j=0,$k=0;$j<$loop;$j++){$xxx=$k;
		$head_o=count($header_o[$xxx]);
		$head_a=count($header_a[$xxx])*$tr;
		$head_b=count($header_b[$xxx])*$tr;
		$head_c=count($header_c[$xxx])*$tr;
		$rem_show=(count(array_filter($remarks[$xxx])) ? TRUE : FALSE);
		if($cl_cnt[$k]<=$lim)$next=1;
		if($bbcondition[$xxx]=='BB IDLE'){$tro=1;$hspan++;if($motiv_seg)$hspan++;}
		
		if(empty($head_a) && empty($head_b) && empty($head_c) && empty($tro))$all_head=1;
		else if(empty($head_a) && empty($head_b) && empty($head_c) && !empty($tro))$all_head=($motiv_seg ? 2 : 1);
		else $all_head=($motiv_seg ? 3 : 2);
		
		if($rem_show)$hspan++;
		$land[]=$xxx.",".$hspan;
		$battery_ob[$j]='<html><body>';
		/* if(($head_a+$head_b+$head_c+$hspan)>=17)$battery_ob[$j].='<table class="table2">';
		else $battery_ob[$j].='<table class="table1">';
		$battery_ob[$j].='<tr>';
		if(($head_a+$head_b+$head_c+$hspan)>=17) $battery_ob[$j].='<td class="td2">';
		else $battery_ob[$j].='<td class="td1">'; */
		$battery_ob[$j].='<table class="botable">';
		$battery_ob[$j].='<thead>';
		$battery_ob[$j].='<tr><th colspan="'.($head_a+$head_b+$head_c+$hspan).'">BATTERY OBSERVATION REPORT FOR BANK - '.($xxx+1).' ('.$bbcondition[$xxx].')</th></tr>';
		$battery_ob[$j].='<tr><th colspan="'.($head_a+$head_b+$head_c+$hspan).'">BATTERY BANK RATING: '.$bank_rating[$xxx].'</th></tr>';
		$battery_ob[$j].='</thead>';
		
		$battery_ob[$j].='<tbody>';
		$battery_ob[$j].='<tr class="subhead">';
		$battery_ob[$j].='<td rowspan="'.$all_head.'">S.NO.</td>';
		$battery_ob[$j].='<td rowspan="'.$all_head.'">MFG DT.</td>';
		$battery_ob[$j].='<td rowspan="'.$all_head.'">CELL NO.</td>';
		if($tro)$battery_ob[$j].='<td colspan="'.($motiv_seg ? '2' :'1').'" rowspan="'.($all_head-($motiv_seg ? 1 :0)).'">OCV</td>';
		if($head_a>0)$battery_ob[$j].='<td colspan="'.$head_a.'">ONCHARGE VOLT 1</td>';
		if($head_b>0)$battery_ob[$j].='<td colspan="'.$head_b.'">DISCHARGE VOLT</td>';
		if($head_c>0)$battery_ob[$j].='<td colspan="'.$head_c.'">ONCHARGE VOLT 2</td>';
		if($rem_show)$battery_ob[$j].='<td rowspan="'.$all_head.'">REMARKS</td>';
		$battery_ob[$j].='</tr>';
		
		if((!empty($head_a) || !empty($head_b) || !empty($head_c))){
			$battery_ob[$j].='<tr>';
			for($y_x=0;$y_x<($head_a/$tr);$y_x++){$battery_ob[$j].='<th colspan="'.$tr.'">'.$header_a[$xxx][$y_x].'</th>';}
			for($y_x=0;$y_x<($head_b/$tr);$y_x++){$battery_ob[$j].='<th colspan="'.$tr.'">'.$header_b[$xxx][$y_x].'</th>';}
			for($y_x=0;$y_x<($head_c/$tr);$y_x++){$battery_ob[$j].='<th colspan="'.$tr.'">'.$header_c[$xxx][$y_x].'</th>';}
			$battery_ob[$j].='</tr>';
		}
		if($motiv_seg){
			$battery_ob[$j].='<tr>';
			if($tro)$battery_ob[$j].='<td>Vol</td><td>SG</td>';
			for($y_x=0;$y_x<($head_a/2);$y_x++){$battery_ob[$j].='<td>Vol</td><td>SG</td>';}
			for($y_x=0;$y_x<($head_b/2);$y_x++){$battery_ob[$j].='<td>Vol</td><td>SG</td>';}
			for($y_x=0;$y_x<($head_c/2);$y_x++){$battery_ob[$j].='<td>Vol</td><td>SG</td>';}
			$battery_ob[$j].='</tr>';
		}
	if($a_next){$y_xa=0;$z_xa=($cl_cnt[$k] >= $lim ? $lim : $cl_cnt[$k]);}
		for($y_xa=$y_xa;$y_xa<$z_xa;$y_xa++){
			$battery_ob[$j].='<tr>';
			$battery_ob[$j].='<td>'.($y_xa+1).'</td>';
			$battery_ob[$j].='<td>'.$mf_date[$xxx][$y_xa].'</td>';
			$battery_ob[$j].='<td>'.$cell_sl_no[$xxx][$y_xa].'</td>';
			if($tro)$battery_ob[$j].='<td>'.$ocv[$xxx][$y_xa].'</td>';
			if($tro && $motiv_seg)$battery_ob[$j].='<td>'.$sg_ocv[$xxx][$y_xa].'</td>';
			for($y_xb=0;$y_xb<$head_a;$y_xb++)$battery_ob[$j].='<td>'.$battery_Volts[$xxx][$y_xa][$y_xb].'</td>';
			for($y_xb=0;$y_xb<$head_b;$y_xb++)$battery_ob[$j].='<td>'.$battery_Volts_a[$xxx][$y_xa][$y_xb].'</td>';
			for($y_xb=0;$y_xb<$head_c;$y_xb++)$battery_ob[$j].='<td>'.$battery_Volts_b[$xxx][$y_xa][$y_xb].'</td>';
			if($rem_show)$battery_ob[$j].='<td>'.$remarks[$xxx][$y_xa].'</td>';
			$battery_ob[$j].='</tr>';
		}
		if($next && (!empty($head_a) || !empty($head_b) || !empty($head_c) || !empty($tro))){
			$battery_ob[$j].='<tr>';
			$battery_ob[$j].='<td colspan="3" align="right">TOTAL VOLTAGE (V)</td>';
			if($tro)for($y_x=0;$y_x<$head_o;$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$tVoltage_o[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<($head_a/$tr);$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$tVoltage_a[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<($head_b/$tr);$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$tVoltage_b[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<($head_c/$tr);$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$tVoltage_c[$xxx][$y_x].'</td>';}
			if($rem_show)$battery_ob[$j].='<td></td>';
			$battery_ob[$j].='</tr>';
			$battery_ob[$j].='<tr>';
			$battery_ob[$j].='<td colspan="3" align="right">BB TERMINAL VOLTAGE</td>';
			if($tro)for($y_x=0;$y_x<$head_o;$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$bb_ter_o[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<($head_a/$tr);$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$bb_ter_a[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<($head_b/$tr);$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$bb_ter_b[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<($head_c/$tr);$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$bb_ter_c[$xxx][$y_x].'</td>';}
			if($rem_show)$battery_ob[$j].='<td></td>';
			$battery_ob[$j].='</tr>';
			$battery_ob[$j].='<tr>';
			$battery_ob[$j].='<td colspan="3" align="right">CURRENT (I)</td>';
			if($tro)for($y_x=0;$y_x<$head_o;$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">+ '.$cCurrent_o[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<($head_a/$tr);$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">+ '.$cCurrent_a[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<($head_b/$tr);$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">- '.$cCurrent_b[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<($head_c/$tr);$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">+ '.$cCurrent_c[$xxx][$y_x].'</td>';}
			if($rem_show)$battery_ob[$j].='<td></td>';
			$battery_ob[$j].='</tr>';
			if($motiv_seg && is_array($temp_o[$xxx][0])){
				$battery_ob[$j].='<tr>';
				$battery_ob[$j].='<td colspan="3" align="right">ELECTROLYTE TEMP MIN</td>';
				if($tro)for($y_x=0;$y_x<$head_o;$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$temp_o[$xxx][$y_x][0].'</td>';}
				for($y_x=0;$y_x<($head_a/$tr);$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$temp_a[$xxx][$y_x][0].'</td>';}
				for($y_x=0;$y_x<($head_b/$tr);$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$temp_b[$xxx][$y_x][0].'</td>';}
				for($y_x=0;$y_x<($head_c/$tr);$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$temp_c[$xxx][$y_x][0].'</td>';}
				if($rem_show)$battery_ob[$j].='<td></td>';
				$battery_ob[$j].='</tr>';
				
				$battery_ob[$j].='<tr>';
				$battery_ob[$j].='<td colspan="3" align="right">ELECTROLYTE TEMP MAX</td>';
				if($tro)for($y_x=0;$y_x<$head_o;$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$temp_o[$xxx][$y_x][1].'</td>';}
				for($y_x=0;$y_x<($head_a/$tr);$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$temp_a[$xxx][$y_x][1].'</td>';}
				for($y_x=0;$y_x<($head_b/$tr);$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$temp_b[$xxx][$y_x][1].'</td>';}
				for($y_x=0;$y_x<($head_c/$tr);$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$temp_c[$xxx][$y_x][1].'</td>';}
				if($rem_show)$battery_ob[$j].='<td></td>';
				$battery_ob[$j].='</tr>';
			}else{
				$battery_ob[$j].='<tr>';
				$battery_ob[$j].='<td colspan="3" align="right">TEMPERATURE</td>';
				if($tro)for($y_x=0;$y_x<$head_o;$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$temp_o[$xxx][$y_x].'</td>';}
				for($y_x=0;$y_x<($head_a/$tr);$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$temp_a[$xxx][$y_x].'</td>';}
				for($y_x=0;$y_x<($head_b/$tr);$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$temp_b[$xxx][$y_x].'</td>';}
				for($y_x=0;$y_x<($head_c/$tr);$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$temp_c[$xxx][$y_x].'</td>';}
				if($rem_show)$battery_ob[$j].='<td></td>';
				$battery_ob[$j].='</tr>';
			}
			$battery_ob[$j].='<tr>';
			$battery_ob[$j].='<td colspan="3" align="right">CHARGE VOLTAGE</td>';
			if($tro)for($y_x=0;$y_x<$head_o;$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$charge_o[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<($head_a/$tr);$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$charge_a[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<($head_b/$tr);$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$charge_b[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<($head_c/$tr);$y_x++){$battery_ob[$j].='<td colspan="'.$tr.'">'.$charge_c[$xxx][$y_x].'</td>';}
			if($rem_show)$battery_ob[$j].='<td></td>';
			$battery_ob[$j].='</tr>';
			$battery_ob[$j].='</tbody>';
			
			$battery_ob[$j].='</table><br><br>';
			$battery_ob[$j].='</body></html>';
			if($tro==1)$tro=0;
			$next=0;
		}else{
			$battery_ob[$j].='</tbody>';
			$battery_ob[$j].='</table><br><br>';
			$battery_ob[$j].='</body></html>';
			if($tro==1)$tro=0;
		}$a_next=0;$hspan=3;
		if($z_xa==$cl_cnt[$k]){$k++;$a_next=1;}
		if($cl_cnt[$k]-$y_xa >= $lim){if($cl_cnt[$k]-$y_xa == $lim)$next=1;$z_xa=$y_xa+$lim;}else {$z_xa=$cl_cnt[$k];$next=1;}
	}
}
if(count($bank_img)>0){
	for($xxx=0;$xxx<count($bank_img);$xxx++){
		$battery_ob[$xxx].='<html><body>';
		$battery_ob[$xxx].='<table class="botable">';
		$battery_ob[$xxx].='<thead>';
		$battery_ob[$xxx].='<tr><th>Battery Observation Report For Bank - '.($xxx+1).'</th></tr>';
		$battery_ob[$xxx].='<tr><th>Manual e-fsr - '.($xxx+1).'</th></tr>';
		$battery_ob[$xxx].='</thead>';
		$battery_ob[$xxx].='<tbody>';
		$battery_ob[$xxx].='<tr><td align="center"><img src="'.$base_url.$bank_img[$xxx].'" height="100%"></td></tr>';
		$battery_ob[$xxx].='</tbody>';
		$battery_ob[$xxx].='</table><br><br>';
		$battery_ob[$xxx].='</body></html>';
	}
}
$page3='<html><body><br>
			<table class="cont_3">
				<tr>
					<td align="left">SERVICE ENGINEER OBSERVATION</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>';
			$string=($result['faulty_cell_sr_no']!="" ? '<td width="50%"><h3>Faulty Cells</h3><p>'.strtoupper(str_replace(",",", ",$result['faulty_cell_sr_no'])).'</p></td>' : '').
					checkEmpty_pdf('Replaced Cells',str_replace(",",", ",$result['requested_cells']),50).
					checkEmpty_pdf('Required Accessories',$result['req_acc'],50).
					checkEmpty_pdf('Required Cells',$result['req_cells'],50). 
					checkEmpty_pdf('Job Performed',$result['job_performed'],50). 
					checkEmpty_pdf('Faulty Code',$result['faulty_code'],50). 
					"</tr><tr><td colspan='4'>" . 
					checkEmpty_pdf_new('Action Taken',str_replace(",",", ",$result['observation'])). 
					"</td></tr><tr><td colspan='4'>" .
					checkEmpty_pdf_new('Remarks',str_replace(",",", ",$result['remarks'])). "</td>";
	$page3.=none_empty_tags($string,2).'</tr>
			</table>';
			if(isset($result['module']['SEOBS'])){ $z=0; //SEOBS GNRLOBS TLOBS
				$cnt=count($result['module']['SEOBS']);
				$page3.='<table class="cont_2">';
					$page3.='<tr><td><h3>Other Issues : </h3></td></tr><tr>';
					foreach($result['module']['SEOBS'] as $other_issue){
						$page3.='<td width="'.(100/$cnt).'%">'.($other_issue['other_issue']!='' ? ($z+1).': '.$other_issue['other_issue'].'<br>' : '').imgcheck($other_issue['other_image']).'</td>';
						if($z%($cnt)==($cnt-1))$page3.='</tr><tr>';$z++;
					}
					$page3.='</tr>';
				$page3.='</table>';
			}
			$page3.='<table class="cont_3">
				<tr>
					<td align="left">CUSTOMER REVIEW</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>';
			$string=checkEmpty_pdf('Customer Name',$result['e_sig_name'],50).
					checkEmpty_pdf('Designation',$result['e_sig_designation'],50).
					checkEmpty_pdf('Contact Number',$result['e_sig_contact_number'],50).
					checkEmpty_pdf('Remarks',$result['e_sig_customer_comments'],50).
					checkEmpty_pdf('Customer Email',strtolower($result['e_sig_email']),50);
		$page3.=none_empty_tags($string,2).'</tr>
			</table>';
			if($result['q1'] || $result['q2'] || $result['q3'] || $result['q4'] || $result['q5'] || (!empty($result['e_sig_customer_comments']) ? 1 : 0)){
			$page3.='<table class="cont_2">
				<tr>
					<td width="50%">
						<h3>Are you satisfied with the Response</h3>
						<p>'.star($result['q1']).'</p>
					</td>
					<td width="50%" style="padding-right:30px">
						<h3>Are you satisfied with the Technical Capability of the Service Personnel</h3>
						<p>'.star($result['q2']).'</p>
					</td>
				</tr>
				<tr>
					<td width="50%" style="padding-right:30px">
						<h3>Are you satisfied with the professional conduct of the Service Personnel</h3>
						<p>'.star($result['q3']).'</p>
					</td>
					<td width="50%">
						<h3>Are you satisfied with the Service provider</h3>
						<p>'.star($result['q4']).'</p>
					</td>
				</tr>
				<tr>
					<td width="50%" colspan="2">
						<h3>How do you rate over all after sales Services</h3>
						<p>'.star($result['q5']).'</p>
					</td>
				</tr>
			</table>';
			}
			$page3.='<br><table class="cont_2">
				<tr>
					<td width="50%" align="center"><p>'.imgcheck($result['e_sig_photo']).'</p></td>
					<td width="50%" align="center"><p>'.imgcheck($result['e_sig_engineer_photo']).'</p></td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>
					<td width="50%" align="center"><h3>Customer Photo</h3></td>
					<td width="50%" align="center"><h3>Service Engineer Photo</h3></td>
				</tr>
				<tr>
					<td width="50%" align="center"><p>'.(empty($result['e_sig_cust_sign']) ? 'Customer Not Available' : ($result['e_sig_cust_sign']=='1' ? 'Customer Is Not Ready To Sign' : $result['e_sig_name'])).'</p></td>
					<td width="50%" align="center"><p>'.$result['emp_name'].'</p></td>
				</tr>
			</table>
		</body></html>';

	/*$temp='<tr>
		<td width="50%" align="center"><p>'.cust_signcheck($result['e_sig_cust_sign']).'</p></td>
		<td width="50%" align="center"><p>'.signcheck($result['e_sig_engineer_sign']).'</p></td>
	</tr>';*/
	$efsr_start=$result['efsr_start'];
	$efsr_end=$result['efsr_date'];
	$efsr_footer=(!empty($efsr_start) ? date('s|i|H|d|m|y' ,strtotime($efsr_start)) : '')."-".(!empty($efsr_end) ? date('s|i|H|d|m|y' ,strtotime($efsr_end)) : '')."-".submit_duration($efsr_start,$efsr_end);
	
include('../../services/mpdf60/mpdf.php');
$portrait_image = 'images/e_care_diag_logo.png';
$landscape_image = 'images/e_care_diag_logo_l.png';
//$mpdf=new mPDF($mode, $format, $font_size, $font, $margin_left, $margin_right, $margin_top, $margin_bottom, $margin_header, $margin_footer, $orientation);
$mpdf=new mPDF('','', 0, '', 5, 5, 40, 40, 5, 2, '');
$mpdf->cacheTables = true;
$mpdf->packTableData=true;
$mpdf->SetHTMLHeader('<table width="100%">
				<tr>
					<td align="left" width="30%" style="padding-left:8px;padding-top:5px;"><img src="images/sys_safe_logo.png" width="200px"></td>
					<td align="center" width="35%"><h2>e-FSR<h2></td>
					<td align="right" width="35%" style="padding-right:8px;padding-top:5px;"><img src="images/go_green.jpg" width="100px"></td>
				</tr>
				<tr><td colspan="3"><hr width="100%" style="margin:0;color:#d5d5d5"></td></tr>
				<tr>
					<td align="left" width="30%" style="padding-left:8px;">e-FSR No: '.$result['efsr_no'].'</td>
					<td align="center" width="35%"></td>
					<td align="right" width="35%" style="padding-right:8px;">Date: '.$result['efsr_date'].'</td>
				</tr>
				<tr><td colspan="3"><hr width="98%" style="margin:0;color:#000"></td></tr>
			</table>');
$mpdf->SetHTMLFooter('<table width="100%" style="margin:10px">
			<tr>
				<td width="50%" align="left"><p>'.cust_signcheck($result['e_sig_cust_sign']).'</p></td>
				<td width="50%" align="right"><p>'.signcheck($result['e_sig_engineer_sign']).'</p></td>
			</tr>
			<tr>
				<th width="50%" align="left">(Customer Signature)</th>
				<th width="50%" align="right">(Engineer Signature)</th>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="50" align="left"><p>{PAGENO}/{nbpg}</p></td>
				<td width="50" align="right"><p>'.$efsr_footer.'</p></td>
			</tr>
		</table>');
//<p style=\"text-align:right;font-style: italic;font-size:12px;\">{PAGENO}/{nbpg}</p>
//$mpdf->SetHTMLFooter("<p style=\"text-align:right;font-style: italic;font-size:12px;\">{PAGENO}/{nbpg}</p>");
$mpdf->pagenumPrefix = 'Page No : ';
$mpdf->SetWatermarkImage($portrait_image);
$mpdf->showWatermarkImage = true;
$mpdf->watermarkImageAlpha = 1;
//$mpdf->allow_charset_conversion=true;
//$mpdf->charset_in='UTF-8';
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML(utf8_encode($page1),2,false,false);
//if(!empty($page2))$mpdf->WriteHTML(utf8_encode($page2),2,false,false);
$bb_affect=false;
if(count($battery_obs)>0){ $temp=false;
	for($xxx=0;$xxx<$loop;$xxx++){
		list($xx,$hspan)=explode(",",$land[$xxx]);
		if((count($header_a[$xx])+count($header_b[$xx])+count($header_c[$xx])+$hspan)>=17){
			$mpdf->AddPage('L','','',0,'',5,5,40,42,'',2);
			$mpdf->SetWatermarkImage($landscape_image);
			$mpdf->WriteHTML(utf8_encode($battery_ob[$xxx]),2,false,false);
			$temp=true;
		}else{
			//$orientation,$type,$resetpagenum,$pagenumstyle,$suppress,$margin-left,$margin-right,$margin-top,$margin-bottom,$margin-header,$margin-footer
			if($temp)$mpdf->AddPage('','','',0,'',5,5,25,27,'',2);
			else $mpdf->AddPage('','','',0,'',5,5,40,42,5,2);
			$mpdf->SetWatermarkImage($portrait_image);
			$mpdf->WriteHTML(utf8_encode($battery_ob[$xxx]),2,false,false);
			$temp=false;
		}
	}
}else $bb_affect=true;
if(count($bank_img)>0){
	for($xxx=0;$xxx<count($bank_img);$xxx++){
		$mpdf->AddPage('','','',0,'',5,5,40,40,'',2);
		$mpdf->SetWatermarkImage($portrait_image);
		$mpdf->WriteHTML(utf8_encode($battery_ob[$xxx]),2,false,false);
	}
}
if($bb_affect)$page3="<pagebreak>".$page3;
else $mpdf->AddPage('','','',0,'',5,5,25,27,5,2);
$mpdf->SetWatermarkImage($portrait_image);
$mpdf->WriteHTML(utf8_encode($page3),2,false,true);
$filename=($result['ticket_id']!='' ? $result['ticket_id'] : "enersys_efsr");
$mpdf->Output("$filename.pdf", "I");
//D: download the PDF file || I: serves in-line to the browser || S: returns the PDF document as a string || F: save as file file_out
exit;
