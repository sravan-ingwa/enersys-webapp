<?php
include('efsr.php');
ini_set('memory_limit','1000M');
$base_url="https://enersyscare.co.in/mobile_app/";
function imgcheck($fv1){ global $base_url; if($fv1!="" && $fv1!='0'){return '<img style="float:right;" src="'.$base_url.$fv1.'" height="70" width="70"/>';}}
function signcheck($fv1){ global $base_url; if($fv1!="" && $fv1!='0'){return '<img style="float:right;" src="'.$base_url.$fv1.'" width="80"/>';}else{ return "NA";}}
function checkEmpty($label,$value,$per){return ($value!="" && $value!='NA' ? "<td width='$per%'><h3>$label</h3><p>$value</p></td>":"");}
function submit_duration($min_date,$max_date){
	if(!empty($min_date) && $min_date!='0000-00-00 00:00:00' && !empty($max_date) && $max_date!='0000-00-00 00:00:00'){
		return round(abs(strtotime($max_date)-strtotime($min_date))/60);
	}else return "";
}
function none_empty_tags($string,$ref){
	include_once('simplehtmldom/simple_html_dom.php');	
	$html = str_get_html($string);
	if(!empty($html)){
		foreach($html->find("td") as $kk=>$ht)if(($kk)%$ref==($ref-1))$ht->outertext .= '</tr></table><table class="cont_2"><tr>';
		$html->save();
	}return $html;
}
function gettwodecimal($fv1){ if(is_numeric($fv1))return number_format($fv1, 2, '.', '');else return '0.00';}
function smpsheading($fv1){
	switch ($fv1){
		case 'HXL5A1HOTZ': return 'SMPS OBSERVATION';break; //TL
		case 'YGRKJJD4N7': return '';break; //MP
		case 'TQMBDTF5ZI': return '';break; //RL
		case 'W0PBT7IAZE': return 'FCBC (FLOAT CUM BOOST CHARGER) OBSERVATIONS';break; //PC
		case 'KWJCZKSTBL': //SA
		case 'DDEYO7NTTC': return 'SOLAR PANEL CONTROLLER OBSERVATIONS';break; //TS
		case 'SMEY7SL24I': return 'UPS OBSERVATIONS';break; //UP
		default : break;
	}
}
function smpslabel($fv1){
	switch ($fv1){
		case 'HXL5A1HOTZ': return 'SMPS';break; //TL
		case 'YGRKJJD4N7': return '';break; //MP
		case 'TQMBDTF5ZI': return '';break; //RL
		case 'W0PBT7IAZE': return 'FCBC';break; //PC
		case 'KWJCZKSTBL': //SA
		case 'DDEYO7NTTC': return 'PANEL';break; //TS
		case 'SMEY7SL24I': return 'UPS';break; //UP
		default : break;
	}
}
function star($q){
	for($i=1;$i<=5;$i++)$stars.="<img src='images/".($i<=$q ? ($q==1 ? 'rated-red':($q==2 || $q==3 ? 'rated-orange':($q==4 || $q==5 ? 'rated-green':'empty'))) : 'empty').".png' width='25px'>";
	return $stars;
}
$stylesheet = file_get_contents('css/pdf_style.css');
$page1='<html><body>
<table class="table1">
	<tr>
		<td class="td1">
			<table class="cont_3">
				<tr>
					<td align="left">TICKET DETAILS</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>';
			$string=checkEmpty('Ticket ID',$result['ticket_id'],20).
					checkEmpty('Login Date',$result['login_date'],20).
					checkEmpty('Activity',$result['activity_code'],20).
					checkEmpty('Segment',$result['segment_name'],20).
					checkEmpty('Nature Of Complaint',$result['complaint_name'],20).
				
					checkEmpty('Site ID',$result['site_id'],20).
					checkEmpty('Site Name',$result['site_name'],20).
					checkEmpty('Zone',$result['zone_name'],20).
					checkEmpty('State',$result['state_name'],20).
					checkEmpty('District',$result['district_name'],20).

					checkEmpty('Activation Date',$result['activation_date'],20).
					checkEmpty('Planned Date',$result['planned_date'],20).
					checkEmpty('Manf. Date',$result['mfd_date'],20).
					checkEmpty('Installation Date',$result['install_date'],20).
					checkEmpty('Customer Name',$result['customer_name'],20).

					checkEmpty('Service Engineer',$result['emp_name'],20).
					checkEmpty('Engineer Mobile',$result['emp_mobile_number'],20).
					checkEmpty('Site Technician',$result['technician_name'],20).
					checkEmpty('Technician Number',$result['technician_number'],20).
					checkEmpty('No.of Banks',$result['no_of_string'],20).
					
					checkEmpty('Site Type',$result['site_type'],20).
					checkEmpty('Product Description',$result['product_description'],20).
					checkEmpty('Mode Of Contact',$result['mode_of_contact'],20).
					checkEmpty('MOC Number',$result['moc_num'],20).
					checkEmpty('Faulty Cells Count',$result['faulty_cell_count'],20).
					
					checkEmpty('Customer Description',str_replace(",",", ",$result['description']),20).
					checkEmpty('Site Address',$result['site_address'],20).
					checkEmpty('Sales Invoice Number',$result['sales_invoice_number'],20).
					checkEmpty('Sales Invoice Date',$result['sales_invoice_date'],20).
					checkEmpty('Sales PoNumber',$result['sales_po_no'],20).
					
					checkEmpty('Service PoNumber',$result['service_po_number'],20).
					checkEmpty('Service PoDate',$result['service_po_date'],20).
					checkEmpty('Warranty',$result['warranty'],20).
					($result['dispat']!='' || $result['inst']!='' ? '<td width="20%"><h3>Warranty Terms </h3><p>DIS('.$result['dispat'].');INS('.$result['inst'].')<p></td>' : '');;
			$page1.=none_empty_tags($string,5).'</tr>
			</table>';
if($result['segment_alias']!='OTHER'){ //Not Others
	$dg_st=($result['dg_status']=='AVAILABLE' ? TRUE : FALSE);
	$eb_sp=(strpos(strtoupper($result['eb_supply']),'YES')!==false ? TRUE : FALSE);
	if($result['segment_alias']=='TQMBDTF5ZI'){ // For Railways
			$page1.='<table class="cont_3">
				<tr>
					<td align="left">History Of The Coach</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>';
				$string="";
			if($result['no_of_banks']!=''){
				$string.=checkEmpty('No Of Banks ',$result['no_of_banks'],25);
				for($i=0;$i<count($result['bb_make']);$i++){
			$string.=checkEmpty('BB Make '.($i+1),$result['bb_make'][$i],25).
					checkEmpty('BB Capacity '.($i+1),$result['bb_capacity'][$i],25).
					checkEmpty('Mfd Dt. '.($i+1),$result['mfdt_date'][$i],25).
					checkEmpty('Install Dt. '.($i+1),$result['installdt_date'][$i],25);
				}
			}
			$string.=checkEmpty('Train Number',$result['train_no'],25).
					checkEmpty('Express Name',$result['express_name'],25).
					checkEmpty('Coach Number',$result['coach_no'],25).
					checkEmpty('Previous Attended Date',$result['pre_attnd'],25).

					checkEmpty('POH Date',$result['poh'],25).
					checkEmpty('RPOH Date',$result['rpoh'],25).
					checkEmpty('Zone',$result['zone'],25).
					checkEmpty('Division',$result['division'],25).

					checkEmpty('Workshop OR Yard',$result['workshop'],25);
		$page1.=none_empty_tags($string,4).'</tr>
			</table>';
			$page1.='<table class="cont_3">
				<tr>
					<td align="left">Equipment Details</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>';
			$string=checkEmpty('Alternator Capacity',$result['alternator_capacity'],25).
					checkEmpty('RRU ERRU Make',$result['rru_make'],25).
					checkEmpty('Regulator Make',$result['regulator_make'],25).
					checkEmpty('Voltage Regulation',$result['voltage_regulation'],25).
					
					checkEmpty('Current Limit',$result['current_limit'],25).
					checkEmpty('Equip Charger Cut Off',$result['equip_charger_cut_off'],25).
					checkEmpty('High Voltage Cut Off',$result['high_voltage_cut_off'],25).
					checkEmpty('Invertor Mode',$result['invertor_mode'],25).
					
					checkEmpty('Low Voltage Cut Off',$result['low_voltage_cut_off'],25).
					($result['altenate_make']!='' ? '<td width="25%"><b>Alternate Make : </b>'.$result['altenate_make'].'<br>'.imgcheck($result['altenate_make_doc']).'</td>' : '').
					($result['altenate_belt_status']!='' ? '<td width="25%"><b>Alternator Belt Status : </b>'.$result['altenate_belt_status'].'<br>'.imgcheck($result['altenate_belt_doc']).'</td>' : '').
					($result['invertor_make']!='' ? '<td width="25%"><b>Invertor Make : </b>'.$result['invertor_make'].'<br>'.imgcheck($result['invertor_make_doc']).'</td>' : '');
		$page1.=none_empty_tags($string,4).'</tr>
			</table>';
			$page1.='<table class="cont_3">
				<tr>
					<td align="left">Check Points</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>';
			$string=checkEmpty('ICC Tightness',$result['icc_tightness'],25).
					checkEmpty('Any Heating OR Melt Marks',$result['heating_melting_marks'],25).
					checkEmpty('Terminal Tightness',$result['terminal_tightness'],25).
					checkEmpty('Alternate No Of Belts Available',$result['alt_no_belt_avl'],25).

					checkEmpty('Vent Plug Tightness',$result['vent_plug_tightness'],25).
					checkEmpty('Vent Belt',$result['belt'],25).
					checkEmpty('Log Book',$result['log_book'],25).
					checkEmpty('Coach Status',$result['coach_status'],25).

					checkEmpty('Terminal Temp',$result['terminal_temp'],25).
					checkEmpty('Physical Conditions',$result['valuephysicalcondition'],25).
					checkEmpty('Leakage Conditions',$result['valueleakagecondition'],25).
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
					$string.=checkEmpty('No Of Banks ',$result['no_of_banks'],25);
					for($i=0;$i<count($result['bb_make']);$i++){
				$string.=checkEmpty('BB Make '.($i+1),$result['bb_make'][$i],25).
						checkEmpty('BB Capacity '.($i+1),$result['bb_capacity'][$i],25).
						checkEmpty('Mfd Dt. '.($i+1),$result['mfdt_date'][$i],25).
						checkEmpty('Install Dt. '.($i+1),$result['installdt_date'][$i],25);
					}
				}
			$string.=($result['temperature']!='' && $result['ambient_temperature']!='' ? '<td width="25%"><h3>Temperature Details</h3><p>ROOM: '.$result['temperature'].'<sup>o</sup>C | AMBIENT: '.$result['ambient_temperature'].'<sup>o</sup>C</td>' : '').
					checkEmpty('General Observations',$result['general_observation'],25).
					checkEmpty('Terminal Torque',$result['terminal_torque'],25).

					checkEmpty('Cells Temp After Use',$result['cells_temp_after_use'],25).
					checkEmpty('Cells Temp At Charge',$result['cells_temp_at_charge'],25).
					checkEmpty('BB Condition',$result['bb_condition'],25).
					checkEmpty('Electrolyte Temp Discharge',$result['acid_temp_discharge'],25).

					checkEmpty('Electrolyte Temp Charge',$result['acid_temp_charge'],25).
					checkEmpty('Electrolyte Temp Before',$result['electrolyte_temp_before'],25).
					checkEmpty('Electrolyte Temp Before Restperiod',$result['electrolyte_temp_before_restperiod'],25).
					checkEmpty('Electrolyte Temp Before Hour',$result['electrolyte_temp_before_hr'],25).
					
					checkEmpty('Electrolyte Temp After',$result['electrolyte_temp_after'],25).
					checkEmpty('Electrolyte Temp After Restperiod',$result['electrolyte_temp_after_restperiod'],25).
					checkEmpty('Electrolyte Temp After Hour',$result['electrolyte_temp_after_hr'],25).
					checkEmpty('DM Water Filling Type',$result['dm_water_filling_type'],25).
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
			$string=checkEmpty('Charger Type',$result['charger_type'],25).
					checkEmpty('Charger Manufacturing Date',$result['charger_manufacturing_date'],25).
					checkEmpty('Serial Number',$result['serial_no'],25).
					checkEmpty('Charging Current',$result['charging_current'],25).
					
					checkEmpty('High Voltage Cut Off',$result['high_voltage_cutoff'],25).
					checkEmpty('Voltage Ripple',$result['voltage_ripple'],25).
					checkEmpty('Voltage Regulation',$result['voltage_regulation'],25).
					checkEmpty('Charging Capacity',$result['charger_capacity'],25).

					checkEmpty('Charging Input',$result['charger_input'],25).
					checkEmpty('Equalize Charger Mode',$result['equalize_charger_mode'],25).
					checkEmpty('Equalize',$result['valueofequalize'],25).
					($result['voltage']!="" ? '<td width="25%"><b>Voltage : </b>'.$result['voltage'].' V<br>'.imgcheck($result['charger_pic']).'</td>' : '').
					($result['charger_band']!='' ? '<td width="25%"><b>Charger Band : </b>'.$result['charger_band'].'<br>'.imgcheck($result['charger_image']).'</td>' : '');
		$page1.=none_empty_tags($string,4).'</tr>
			</table>';		
			$page1.='<table class="cont_3">
				<tr>
					<td align="left">Forklift Details</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>';
			$string=checkEmpty('Forklift Model',$result['fork_lift_model'],25).
					checkEmpty('Forklift Manufacturing Date',$result['fork_lift_manf_date'],25).
					checkEmpty('Forklift Installation Date',$result['forklift_install_date'],25).
					checkEmpty('Forklift Capacity',$result['forlift_capacity'],25).
					checkEmpty('Motor Capacity',$result['motor_capacity'],25).
					checkEmpty('Under Voltage Cut Off',$result['under_voltage_cutoff'],25).
					checkEmpty('Max Load Current',$result['max_load_current'],25).
					($result['fork_lift_brand']!='' ? '<td width="25%"><b>Forklift Brand : </b>'.$result['fork_lift_brand'].'<br>'.imgcheck($result['fork_lift_pic']).'</td>' : '');
		$page1.=none_empty_tags($string,4).'</tr>
			</table>';
			$page1.='<table class="cont_3">
				<tr>
					<td align="left">Battery Details</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>';
			$string=checkEmpty('Battery Type',$result['battey_type'],25).
					checkEmpty('Battery Bank Serial Number',$result['bank_serial_no'],25).
					checkEmpty('Manufacturing Date',$result['battey_manf_date'],25).
					checkEmpty('Installation Date',$result['battey_ins_date'],25).

					checkEmpty('Plug Type',$result['plug_type'],25).
					checkEmpty('Acid Level',$result['acid_level'],25);
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
				$string.=checkEmpty('No Of Banks ',$result['no_of_banks'],25);
				for($i=0;$i<count($result['bb_make']);$i++){
			$string.=checkEmpty('BB Make '.($i+1),$result['bb_make'][$i],25).
					checkEmpty('BB Capacity '.($i+1),$result['bb_capacity'][$i],25).
					checkEmpty('Mfd Dt. '.($i+1),$result['mfdt_date'][$i],25).
					checkEmpty('Install Dt. '.($i+1),$result['installdt_date'][$i],25);
				}
			}
			
			$string.=($result['temperature']!='' && $result['ambient_temperature']!='' ? '<td width="25%"><b>Temperature Details : </b>'.$result['temperature_type'].'<br><p>ROOM: '.$result['temperature'].'<sup>o</sup>C | AMBIENT: '.$result['ambient_temperature'].'<sup>o</sup>C</td>' : '').
					checkEmpty('Temperature Condition',$result['temp_data'],25).
					checkEmpty('General Observations',$result['general_observation'],25).
					($result['vent_plug_type']!='' ? '<td width="25%"><h3>Vent plug Tightness</h3><p>'.$result['vent_plug_type'].'</p></td>' : '').
					($result['terminal_torque']!='' ? '<td width="25%"><h3>Terminal Torque</h3><p>'.$result['terminal_torque'].'</p></td>' : '').
					checkEmpty('No Of Cell Tightened',$result['no_of_cell_tightened'],25).
					
					checkEmpty('DG Status',$result['dg_sta'],25).
					checkEmpty('EB Status',$result['eb_sta'],25).
					checkEmpty('Module Cleanness',$result['cleanness'],25).
					checkEmpty('Site Input',$result['site_input'],25).
					($result['physical_damages']!='' ? '<td width="25%"><b>Physical Damages : </b>'.$result['physical_damages'].'<br>'.imgcheck($result['physical_damages_document']).'</td>' : '').
					($result['leakage']!='' ? '<td width="25%"><b>Leakage : </b>'.$result['leakage'].'<br>'.imgcheck($result['leakage_document']).'</td>' : '').
					($result['module']['PHYOBS'][0]['other_issue']!='' ? '<td width="25%"><b>Other Issue : </b>'.$result['module']['PHYOBS'][0]['other_issue'].'<br>'.imgcheck($result['module']['PHYOBS'][0]['other_image']).'</td>' : '');
		$page1.=none_empty_tags($string,4).'</tr>
			</table>';
		$page1.='<pagebreak/>';
		$page1.='<pagebreak/>';
		$page1.='<table class="cont_3">
				<tr>
					<td align="left">GENERATOR & POWER OBSERVATIONS</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>';
			$string=checkEmpty('DG Make ',$result['dg_make'],25).
					($result['dg_capacity']!='' ? '<td width="25%"><h3>DG Capacity </h3><p>'.$result['dg_capacity'].' KVA</p></td>' : '').
					($result['dg_working_condition']!='' ? '<td width="25%"><h3>Working Condition</h3><p>'.$result['dg_working_condition'].'</p></td>' : '').
					($result['avg_dg_run']!='' ? '<td width="25%"><h3>Avg DG Run</h3><p>'.$result['avg_dg_run'].' HRS/DAY</td>' : '').
					checkEmpty('DG Output',$result['dg_output'],25).
					checkEmpty('E.B Suppy ',$result['eb_supply'],25).
					($result['failures_per_day']!='' ? '<td width="25%"><h3>No.Of Power Cuts</h3><p>'.$result['failures_per_day'].' HRS</p></td>' : '').
					($result['avg_power_cut']!='' ? '<td width="25%"><h3>Average Power Cut</h3><p>'.$result['avg_power_cut'].' HRS/DAY</p></td>' : '').
					($result['ebinstalldate']!='NA' ? '<td width="25%"><h3>EB Install Date</h3><p>'.$result['ebinstalldate'].'</p></td>' : '').
					($result['dg_status']!='' ? '<td width="25%"><b>DG Status : </b>'.$result['dg_status'].'<br>'.imgcheck($result['dg_pic']).'</td>' : '').
					($result['module']['GNRLOBS'][0]['other_issue']!='' ? '<td width="25%"><b>Other Issue : </b>'.$result['module']['GNRLOBS'][0]['other_issue'].'<br>'.imgcheck($result['module']['GNRLOBS'][0]['other_image']).'</td>' : '');
		$page1.=none_empty_tags($string,4).'</tr>
			</table>';
	}
}
$page1.='</td>
	</tr>
</table></body></html>';
$page2='';
if($result['segment_alias']!='OTHER' && $result['segment_alias']!='TQMBDTF5ZI' && $result['segment_alias']!='YGRKJJD4N7'){
	$page2='<html><body>
	<table class="table1">
		<tr>
		<td class="td1">';
		//SMPS Observation
		//SA && TS
		for($i=0;$i<count($result['technical_obs']);$i++){ $technical_arr=$result['technical_obs'][$i];
			if($result['segment_alias']!="KWJCZKSTBL" && $result['segment_alias']!="DDEYO7NTTC")$seg=$result['segment_alias'];else $seg='';
			if(empty($seg)){if(empty($technical_arr['auto_boost']))$seg=$result['segment_alias'];else $seg=(empty($technical_arr['site_load']) ? 'SMEY7SL24I' : 'HXL5A1HOTZ');} //UP TL
			$page2.='<table class="cont_3">
					<tr>
						<td align="left">'.smpsheading($seg).' - '.$technical_arr['panel_make'].'</td>
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
						checkEmpty(smpslabel($seg).' Make',$technical_arr['panel_make'],25).
						checkEmpty(smpslabel($seg).' Rating',$technical_arr['panel_rating'],25).
						checkEmpty(smpslabel($seg).' Manf. Date',$technical_arr['panel_manufacturing_date'],25).

						($technical_arr['auto_boost']!=''  ? '<td width="25%"><h3>Auto Boost</h3><p>'.$technical_arr['auto_boost'].'</p></td>' : '').
						($technical_arr['temp_compensation']!=''  ? '<td width="25%"><h3>Temp Compensation</h3><p>'.$technical_arr['temp_compensation'].'</p>' : '').

						($technical_arr['voltage_regulation']!='' && $result['segment_alias']!='HXL5A1HOTZ' ? '<td width="25%"><h3>Voltage Regulation</h3><p>'.$technical_arr['voltage_regulation'].'</p></td>' : '').
						checkEmpty(smpslabel($seg).' Installation Date',$technical_arr['panel_installation_date'],25);
			if($result['segment_alias']=='KWJCZKSTBL' || $result['segment_alias']=='DDEYO7NTTC'){ // SA OR TS
				$string.=checkEmpty('Charge Controller Rating',$technical_arr['charge_controller_rate'],25).
						checkEmpty('Charger Controller Make',$technical_arr['charge_controller_make'],25).

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
				$string.=checkEmpty('Single Panel Rating (Watts)',$technical_arr['single_panel_rating'],25).
						 checkEmpty('Charge Controller Manufacturing Date',$technical_arr['charge_control_manufacturing_date'],25).
						($technical_arr['no_solar_panels']!='' ? '<td width="25%"><b>Number of Solar Panels : </b>'.$technical_arr['no_solar_panels'].'<br>'.imgcheck($technical_arr['document_3']).'</td>' : '');
			}elseif($result['segment_alias']=='HXL5A1HOTZ'){ // TL
				$string.=($technical_arr['site_load']!='' ? '<td width="25%"><h3>Site Load </h3><p>'.gettwodecimal($technical_arr['site_load']).' AMPS</p></td>' : '').
						checkEmpty('SMR Module Rating('.$technical_arr['charge_controller_make'].')',$technical_arr['charge_controller_rate'],25).
						($technical_arr['no_solar_panels']!='' ? '<td width="25%"><b>Working Modules: </b>'.$technical_arr['no_solar_panels'].'<br>'.imgcheck($technical_arr['document_3']).'</td>' : '').
						($technical_arr['single_panel_rating']!='' ? '<td width="25%"><b>SMPS Display : </b>'.$technical_arr['single_panel_rating'].'<br>'.imgcheck($technical_arr['document_5']).'</td>' : '').
						($technical_arr['voltage_regulation']!='' ? '<td width="25%"><b>LVD\'S Status : </b>'.$technical_arr['voltage_regulation'].'<br>'.imgcheck($technical_arr['document_4']).'</td>' : '').
						($result['module']['TLOBS'][0]['other_issue']!='' ? '<td width="25%"><b>Other Issue : </b>'.$result['module']['TLOBS'][0]['other_issue'].'<br>'.imgcheck($result['module']['TLOBS'][0]['other_image']).'</td>' : '');
			}
			$page2.=none_empty_tags($string,4).'</tr>
				</table>';
		}
		$page2.='</td>
			</tr>
		</table></body></html>';
}
if(count($battery_obs)>0){ $loop=$next=0;$a_next=1; $land=array(); $lim=24;
	for($i=0;$i<count($battery_obs);$i++){$cl_cnt[$i]=count($cell_sl_no[$i]);$loop+=ceil($cl_cnt[$i]/$lim);}
	$tro=0; $span=3; $hspan=4;$motiv_seg=FALSE;
	if($result['segment_alias']=='YGRKJJD4N7'){ $hspan=6; $motiv_seg=TRUE;}
	for($j=0,$k=0;$j<$loop;$j++){ $land[]=$xxx=$k;
		$rem_show=(count(array_filter($remarks[$xxx])) ? TRUE : FALSE);
		//$acid_den_show=(count(array_filter($acid_density[$xxx])) && $motiv_seg ? TRUE : FALSE);
		if($cl_cnt[$k]<=$lim)$next=1;
		if($bbcondition[$xxx]=='BB IDLE'){$tro=1;$hspan=5;}
		$battery_ob[$j]='<html><body>';
		if((count($header_a[$xxx])+count($header_b[$xxx])+count($header_c[$xxx])+$hspan)>=17) $battery_ob[$j].='<table class="table2">';
		else $battery_ob[$j].='<table class="table1">';
		$battery_ob[$j].='<tr>';
		if((count($header_a[$xxx])+count($header_b[$xxx])+count($header_c[$xxx])+$hspan)>=17) $battery_ob[$j].='<td class="td2">';
		else $battery_ob[$j].='<td class="td1">';
		$battery_ob[$j].='<table class="botable">';
		$battery_ob[$j].='<thead>';
		$battery_ob[$j].='<tr><th colspan="'.(count($header_a[$xxx])+count($header_b[$xxx])+count($header_c[$xxx])+$hspan).'">BATTERY OBSERVATION REPORT FOR BANK - '.($xxx+1).' ('.$bbcondition[$xxx].')</th></tr>';
		$battery_ob[$j].='<tr><th colspan="'.(count($header_a[$xxx])+count($header_b[$xxx])+count($header_c[$xxx])+$hspan).'">BATTERY BANK RATING: '.$bank_rating[$xxx].'</th></tr>';
		$battery_ob[$j].='</thead>';
		$battery_ob[$j].='<tbody>';
		$battery_ob[$j].='<tr class="subhead">';
		$battery_ob[$j].='<td rowspan="2">S.NO.</td>';
		$battery_ob[$j].='<td rowspan="2">MFG DT.</td>';
		$battery_ob[$j].='<td rowspan="2">CELL NO.</td>';
		//if($acid_den_show)$battery_ob[$j].='<td rowspan="2">ACID DENSITY</td>';
		if($tro)$battery_ob[$j].='<td rowspan="2">OCV</td>';
		if($tro && $motiv_seg)$battery_ob[$j].='<td rowspan="2">SG OCV</td>';
		if(count($header_a[$xxx])>0)$battery_ob[$j].='<td colspan="'.(count($header_a[$xxx])).'">ONCHARGE VOLT 1</td>';
		if(count($header_b[$xxx])>0)$battery_ob[$j].='<td colspan="'.(count($header_b[$xxx])).'">DISCHARGE VOLT</td>';
		if(count($header_c[$xxx])>0)$battery_ob[$j].='<td colspan="'.(count($header_c[$xxx])).'">ONCHARGE VOLT 2</td>';
		if($rem_show)$battery_ob[$j].='<td rowspan="2">REMARKS</td>';
		$battery_ob[$j].='</tr>';
		$battery_ob[$j].='<tr>';
		for($y_x=0;$y_x<count($header_a[$xxx]);$y_x++){$battery_ob[$j].='<th>'.$header_a[$xxx][$y_x].'</th>';}
		for($y_x=0;$y_x<count($header_b[$xxx]);$y_x++){$battery_ob[$j].='<th>'.$header_b[$xxx][$y_x].'</th>';}
		for($y_x=0;$y_x<count($header_c[$xxx]);$y_x++){$battery_ob[$j].='<th>'.$header_c[$xxx][$y_x].'</th>';}
		if(empty(count($header_a[$xxx])) && empty(count($header_b[$xxx])) && empty(count($header_c[$xxx])))$battery_ob[$j].='<th></th>';
		$battery_ob[$j].='</tr>';
	if($a_next){$y_xa=0;$z_xa=($cl_cnt[$k] >= $lim ? $lim : $cl_cnt[$k]);}
		for($y_xa=$y_xa;$y_xa<$z_xa;$y_xa++){
			$battery_ob[$j].='<tr>';
			$battery_ob[$j].='<td>'.($y_xa+1).'</td>';
			$battery_ob[$j].='<td>'.$mf_date[$xxx][$y_xa].'</td>';
			$battery_ob[$j].='<td>'.$cell_sl_no[$xxx][$y_xa].'</td>';
			//if($acid_den_show)$battery_ob[$j].='<td>'.$acid_density[$xxx][$y_xa].'</td>';
			if($tro)$battery_ob[$j].='<td>'.$ocv[$xxx][$y_xa].'</td>';
			if($tro && $motiv_seg)$battery_ob[$j].='<td>'.$sg_ocv[$xxx][$y_xa].'</td>';
			for($y_xb=0;$y_xb<(count($header_a[$xxx]));$y_xb++)$battery_ob[$j].='<td>'.$battery_Volts[$xxx][$y_xa][$y_xb].'</td>';
			for($y_xb=0;$y_xb<(count($header_b[$xxx]));$y_xb++)$battery_ob[$j].='<td>'.$battery_Volts_a[$xxx][$y_xa][$y_xb].'</td>';
			for($y_xb=0;$y_xb<(count($header_c[$xxx]));$y_xb++)$battery_ob[$j].='<td>'.$battery_Volts_b[$xxx][$y_xa][$y_xb].'</td>';
			if($rem_show)$battery_ob[$j].='<td>'.$remarks[$xxx][$y_xa].'</td>';
			$battery_ob[$j].='</tr>';
		}
		if($next){
			$battery_ob[$j].='<tr>';
			$battery_ob[$j].='<td colspan="'.$span.'" align="right">TOTAL VOLTAGE (V)</td>';
			if($tro)for($y_x=0;$y_x<count($header_o[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$tVoltage_o[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<count($header_a[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$tVoltage_a[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<count($header_b[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$tVoltage_b[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<count($header_c[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$tVoltage_c[$xxx][$y_x].'</td>';}
			if($rem_show)$battery_ob[$j].='<td></td>';
			$battery_ob[$j].='</tr>';
			$battery_ob[$j].='<tr>';
			$battery_ob[$j].='<td colspan="'.$span.'" align="right">BB TERMINAL VOLTAGE</td>';
			if($tro)for($y_x=0;$y_x<count($header_o[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$bb_ter_o[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<count($header_a[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$bb_ter_a[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<count($header_b[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$bb_ter_b[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<count($header_c[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$bb_ter_c[$xxx][$y_x].'</td>';}
			if($rem_show)$battery_ob[$j].='<td></td>';
			$battery_ob[$j].='</tr>';
			$battery_ob[$j].='<tr>';
			$battery_ob[$j].='<td colspan="'.$span.'" align="right">CURRENT (I)</td>';
			if($tro)for($y_x=0;$y_x<count($header_o[$xxx]);$y_x++){$battery_ob[$j].='<td>+ '.$cCurrent_o[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<count($header_a[$xxx]);$y_x++){$battery_ob[$j].='<td>+ '.$cCurrent_a[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<count($header_b[$xxx]);$y_x++){$battery_ob[$j].='<td>- '.$cCurrent_b[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<count($header_c[$xxx]);$y_x++){$battery_ob[$j].='<td>+ '.$cCurrent_c[$xxx][$y_x].'</td>';}
			if($rem_show)$battery_ob[$j].='<td></td>';
			$battery_ob[$j].='</tr>';
			if($motiv_seg && is_array($temp_o[$xxx][0])){
				$battery_ob[$j].='<tr>';
				$battery_ob[$j].='<td colspan="'.$span.'" align="right">ELECTROLYTE TEMP MIN</td>';
				if($tro)for($y_x=0;$y_x<count($header_o[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$temp_o[$xxx][$y_x][0].'</td>';}
				for($y_x=0;$y_x<count($header_a[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$temp_a[$xxx][$y_x][0].'</td>';}
				for($y_x=0;$y_x<count($header_b[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$temp_b[$xxx][$y_x][0].'</td>';}
				for($y_x=0;$y_x<count($header_c[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$temp_c[$xxx][$y_x][0].'</td>';}
				if($rem_show)$battery_ob[$j].='<td></td>';
				$battery_ob[$j].='</tr>';
				
				$battery_ob[$j].='<tr>';
				$battery_ob[$j].='<td colspan="'.$span.'" align="right">ELECTROLYTE TEMP MIN</td>';
				if($tro)for($y_x=0;$y_x<count($header_o[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$temp_o[$xxx][$y_x][1].'</td>';}
				for($y_x=0;$y_x<count($header_a[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$temp_a[$xxx][$y_x][1].'</td>';}
				for($y_x=0;$y_x<count($header_b[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$temp_b[$xxx][$y_x][1].'</td>';}
				for($y_x=0;$y_x<count($header_c[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$temp_c[$xxx][$y_x][1].'</td>';}
				if($rem_show)$battery_ob[$j].='<td></td>';
				$battery_ob[$j].='</tr>';
			}else{
				$battery_ob[$j].='<tr>';
				$battery_ob[$j].='<td colspan="'.$span.'" align="right">TEMPERATURE</td>';
				if($tro)for($y_x=0;$y_x<count($header_o[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$temp_o[$xxx][$y_x].'</td>';}
				for($y_x=0;$y_x<count($header_a[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$temp_a[$xxx][$y_x].'</td>';}
				for($y_x=0;$y_x<count($header_b[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$temp_b[$xxx][$y_x].'</td>';}
				for($y_x=0;$y_x<count($header_c[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$temp_c[$xxx][$y_x].'</td>';}
				if($rem_show)$battery_ob[$j].='<td></td>';
				$battery_ob[$j].='</tr>';
			}
			$battery_ob[$j].='<tr>';
			$battery_ob[$j].='<td colspan="'.$span.'" align="right">CHARGE VOLTAGE</td>';
			if($tro)for($y_x=0;$y_x<count($header_o[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$charge_o[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<count($header_a[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$charge_a[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<count($header_b[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$charge_b[$xxx][$y_x].'</td>';}
			for($y_x=0;$y_x<count($header_c[$xxx]);$y_x++){$battery_ob[$j].='<td>'.$charge_c[$xxx][$y_x].'</td>';}
			if($rem_show)$battery_ob[$j].='<td></td>';
			$battery_ob[$j].='</tr>';
			$battery_ob[$j].='</tbody>';
			$battery_ob[$j].='</table><br><br><br>';
			$battery_ob[$j].='</td>';
			$battery_ob[$j].='</tr>';
			$battery_ob[$j].='</table></body></html>';
			if($tro==1){$tro=0;$hspan=4;}
			$next=0;
		}else{
			$battery_ob[$j].='</tbody>';
			$battery_ob[$j].='</table><br><br><br>';
			$battery_ob[$j].='</td>';
			$battery_ob[$j].='</tr>';
			$battery_ob[$j].='</table></body></html>';
			if($tro==1){$tro=0;$hspan=4;}
		}$a_next=0;
		if($z_xa==$cl_cnt[$k]){$k++;$a_next=1;}
		if($cl_cnt[$k]-$y_xa >= $lim)$z_xa=$y_xa+$lim;else {$z_xa=$cl_cnt[$k];$next=1;}
	}
}
if(count($bank_img)>0){
	for($xxx=0;$xxx<count($bank_img);$xxx++){
		$battery_ob[$xxx].='<html><body>';
		$battery_ob[$xxx].='<table class="table1">';
		$battery_ob[$xxx].='<tr>';
		$battery_ob[$xxx].='<td class="td1">';
		$battery_ob[$xxx].='<table class="botable">';
		$battery_ob[$xxx].='<thead>';
		$battery_ob[$xxx].='<tr><th>Battery Observation Report For Bank - '.($xxx+1).'</th></tr>';
		$battery_ob[$xxx].='<tr><th>Manual e-fsr - '.($xxx+1).'</th></tr>';
		$battery_ob[$xxx].='</thead>';
		$battery_ob[$xxx].='<tbody>';
		$battery_ob[$xxx].='<tr><td align="center"><img src="'.$base_url.$bank_img[$xxx].'" height="100%"></td></tr>';
		$battery_ob[$xxx].='</tbody>';
		$battery_ob[$xxx].='</table><br><br><br>';
		$battery_ob[$xxx].='</td>';
		$battery_ob[$xxx].='</tr>';
		$battery_ob[$xxx].='</table></body></html>';
	}
}
$page3='<html><body>
<table class="table1">
	<tr>
		<td class="td1">
			<table class="cont_3">
				<tr>
					<td align="left">SERVICE ENGINEER OBSERVATION</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>';
			$string=($result['faulty_cell_sr_no']!="" ? '<td width="50%"><h3>Faulty Cells</h3><p>'.str_replace(",",", ",$result['faulty_cell_sr_no']).'</p></td>' : 'None').
					checkEmpty('Replaced Cells',str_replace(",",", ",$result['requested_cells']),50).
					checkEmpty('Required Accessories',$result['req_acc'],50).
					checkEmpty('Required Cells',$result['req_cells'],50).
					checkEmpty('Faulty Code',$result['faulty_code'],50).
					checkEmpty('Action Taken',str_replace(",",", ",$result['observation']),50).
					checkEmpty('Job Performed',$result['job_performed'],50).
					checkEmpty('Remarks',str_replace(",",", ",$result['remarks']),50).
					checkEmpty('Site Address',$result['site_address'],50);
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
			$string=checkEmpty('Customer Name',$result['e_sig_name'],50).
					checkEmpty('Designation',$result['e_sig_designation'],50).
					checkEmpty('Contact Number',$result['e_sig_contact_number'],50).
					checkEmpty('Remarks',$result['e_sig_customer_comments'],50).
					checkEmpty('Customer Email',strtolower($result['e_sig_email']),50);
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
			$page3.='<br><br><table class="cont_2">
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
					<td width="50%" align="center"><p>'.($result['e_sig_cust_sign']!="" && $result['e_sig_cust_sign']!='0' ? $result['e_sig_name'] : '').'</p></td>
					<td width="50%" align="center"><p>'.$result['emp_name'].'</p></td>
				</tr>
			</table>
		</td>
	</tr>
</table></body></html>';

	/*$temp='<tr>
		<td width="50%" align="center"><p>'.($result['e_sig_cust_sign']!="" && $result['e_sig_cust_sign']!='0' ? '<img style="float:right;" src="'.$base_url.$result['e_sig_cust_sign'].'" width="80"/>' : 'Customer Not Available').'</p></td>
		<td width="50%" align="center"><p>'.signcheck($result['e_sig_engineer_sign']).'</p></td>
	</tr>';*/
	$efsr_start=$result['efsr_start'];
	$efsr_end=$result['efsr_date'];
	$efsr_footer=(!empty($efsr_start) ? date('s|i|H|d|m|y' ,strtotime($efsr_start)) : '')."-".(!empty($efsr_end) ? date('s|i|H|d|m|y' ,strtotime($efsr_end)) : '')."-".submit_duration($efsr_start,$efsr_end);
	
include('../mpdf60/mpdf.php');
//$mpdf=new mPDF($mode, $format, $font_size, $font, $margin_left, $margin_right, $margin_top, $margin_bottom, $margin_header, $margin_footer, $orientation);
$mpdf=new mPDF('','', 0, '', 5, 5, 41, 5, 5, 2, '');
$mpdf->SetHTMLHeader('<table style="border-collapse:collapse;" width="100%">
	<tr>
		<td class="headd">
			<table class="tableHeader" width="100%">
				<tr>
					<td align="left" width="30%"><img src="images/sys_safe_logo.png" width="200px"></td>
					<td align="center" width="35%"><h2>e-FSR<h2></td>
					<td align="right" width="35%"><img src="images/go_green.jpg" width="100px"></td>
				</tr>
			</table>
			<table class="cont_1">
				<tr>
					<td align="left">e-FSR No: '.$result['efsr_no'].'</td>
					<td align="right">Date: '.$result['efsr_date'].'</td>
				</tr>
				<tr><td colspan="2"><hr width="98%" style="margin:0;color:#000"></td></tr>
			</table>
		</td>
	</tr>
</table>');
$mpdf->SetHTMLFooter('<table width="100%" style="margin:10px">
			<tr>
				<td width="50%" align="left"><p>'.($result['e_sig_cust_sign']!="" && $result['e_sig_cust_sign']!='0' ? '<img style="float:right;" src="'.$base_url.$result['e_sig_cust_sign'].'" width="80"/>' : 'Customer Not Available').'</p></td>
				<td width="50%" align="right"><h3>'.signcheck($result['e_sig_engineer_sign']).'</h3></td>
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
$mpdf->SetWatermarkImage('images/e_care_diag_logo.png');
$mpdf->showWatermarkImage = true;
$mpdf->watermarkImageAlpha = 0.06;
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($page1,2,true,false);
if(!empty($page2))$mpdf->WriteHTML($page2,2,false,false);
if(count($battery_obs)>0){
	for($xxx=0;$xxx<$loop;$xxx++){$ori='';
		if((count($header_a[$land[$xxx]])+count($header_b[$land[$xxx]])+count($header_c[$land[$xxx]])+4)>=17)$ori='L';
		$mpdf->AddPage($ori,'','',0,'',5,5,41,7,'',2);
		$mpdf->WriteHTML($battery_ob[$xxx],2,false,false);
	}
}
if(count($bank_img)>0){
	for($xxx=0;$xxx<count($bank_img);$xxx++){
		$mpdf->AddPage('','','',0,'',5,10,6,5,'',2);
		$mpdf->WriteHTML($battery_ob[$xxx],2,false,false);
	}
}
$mpdf->AddPage('','','',0,'',5,5,41,5,'',2);
$mpdf->WriteHTML($page3,2,false,true);
$filename=($result['ticket_id']!='' ? $result['ticket_id'] : "enersys_efsr");
$mpdf->Output("$filename.pdf", "I");
//echo $page1;
//D: download the PDF file || I: serves in-line to the browser || S: returns the PDF document as a string || F: save as file file_out
exit;
