<?php
include('efsr.php');
$base_url="http://enersyscare.co.in/enersyscare_V2/token/";
function imgcheck($fv1){ global $base_url; if($fv1!="" && $fv1!='0'){return '<img style="float:right;" src="'.$base_url.$fv1.'" height="70" width="70"/>';}}
function signcheck($fv1){ global $base_url; if($fv1!="" && $fv1!='0'){return '<img style="float:right;" src="'.$base_url.$fv1.'" width="80"/>';}else{ return "NA";}}
function checkEmpty($label,$value){ return ($value!="" && $value!='NA' ? "<h3>$label</h3><p>$value</p>":"");}
function gettwodecimal($fv1){
	if(is_numeric($fv1)){
		return number_format($fv1, 2, '.', '');
	}else return 0.00;
}
function smpsheading($fv1){
	switch ($fv1){
		case 'HXL5A1HOTZ': return 'SMPS OBSERVATION';break; //TL
		case 'YGRKJJD4N7': return '';break; //MP
		case 'TQMBDTF5ZI': return '';break; //RL
		case 'KWJCZKSTBL': return 'SOLAR PANEL CONTROLLER OBSERVATIONS';break; //SA
		case 'W0PBT7IAZE': return 'FCBC (FLOAT CUM BOAST CHARGER) OBSERVATIONS';break; //PC
		case 'DDEYO7NTTC': return 'SOLAR PANEL CONTROLLER OBSERVATIONS';break; //TS
		case 'SMEY7SL24I': return 'UPS OBSERVATION';break; //UP
		default : break;
	}
}
function smpslabel($fv1){
	switch ($fv1){
		case 'HXL5A1HOTZ': return 'SMPS';break; //TL
		case 'YGRKJJD4N7': return '';break; //MP
		case 'TQMBDTF5ZI': return '';break; //RL
		case 'W0PBT7IAZE': return 'FCBC';break; //PC
		case 'KWJCZKSTBL':  //SA
		case 'DDEYO7NTTC': return 'PANEL';break; //TS
		case 'SMEY7SL24I': return 'UPS';break; //UP
		default : break;
	}
}
function star($q){
	for($i=1;$i<=5;$i++){
		if($i<=$q){
			$s = ($q==1 ? 'rated-red':($q==2 || $q==3 ? 'rated-orange':($q==4 || $q==5 ? 'rated-green':'empty')));
		}else{$s='empty';}
		$res.='<img src="images/'.$s.'.png" width="25px">';
	}return $res;
}
$stylesheet = file_get_contents('css/pdf_style.css');
$efsr='<html><body>
<table class="table1">
	<tr>
		<td class="td1">
			<table class="tableHeader" width="100%">
				<tr>
					<td align="left" width="35%"><img src="images/logo.png"></td>
					<td align="center" width="30%"><h2>e-FSR<h2></td>
					<td align="right" width="35%"><img src="images/logo-4.jpg" width="100px"></td>
				</tr>
			</table>
			<table class="cont_1">
				<tr>
					<td align="left">e-FSR No: '.$result['efsr_no'].'</td>
					<td align="right">Date: '.$result['efsr_date'].'</td>
				</tr>
			</table>
			<table class="cont_3">
				<tr>
					<td align="left">TICKET DETAILS</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>
					<td width="20%">'.checkEmpty('Ticket ID',$result['ticket_id']).'</td>
					<td width="20%">'.checkEmpty('Login Date',$result['login_date']).'</td>
					<td width="20%">'.checkEmpty('Activity',$result['activity_code']).'</td>
					<td width="20%">'.checkEmpty('Segment',$result['segment_name']).'</td>
					<td width="20%">'.checkEmpty('Nature Of Complaint',$result['complaint_name']).'</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>
					<td width="20%">'.checkEmpty('Site ID',$result['site_id']).'</td>
					<td width="20%">'.checkEmpty('Site Name',$result['site_name']).'</td>
					<td width="20%">'.checkEmpty('Zone',$result['zone_name']).'</td>
					<td width="20%">'.checkEmpty('State',$result['state_name']).'</td>
					<td width="20%">'.checkEmpty('District',$result['district_name']).'</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>
					<td width="20%">'.checkEmpty('Activation Date',$result['activation_date']).'</td>
					<td width="20%">'.checkEmpty('Planned Date',$result['planned_date']).'</td>
					<td width="20%">'.checkEmpty('Manf. Date',$result['mfd_date']).'</td>
					<td width="20%">'.checkEmpty('Installation Date',$result['install_date']).'</td>
					<td width="20%">'.checkEmpty('Customer Name',$result['customer_name']).'</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>
					<td width="20%">'.checkEmpty('Service Engineer',$result['emp_name']).'</td>
					<td width="20%">'.checkEmpty('Engineer Mobile',$result['emp_mobile_number']).'</td>
					<td width="20%">'.checkEmpty('Site Technician',$result['technician_name']).'</td>
					<td width="20%">'.checkEmpty('Technician Number',$result['technician_number']).'</td>
					<td width="20%">'.checkEmpty('No.of Banks',$result['no_of_string']).'</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>
					<td width="20%">'.checkEmpty('Site Type',$result['site_type']).'</td>
					<td width="20%">'.checkEmpty('Product Description',$result['product_description']).'</td>
					<td width="20%">'.checkEmpty('Mode Of Contact',$result['mode_of_contact']).'</td>
					<td width="20%"><h3>Faulty Cells Count: </h3> <p> '.$result['faulty_cell_count'].' </p></td>
					<td width="20%">'.checkEmpty('Customer Description',str_replace(",",", ",$result['description'])).'</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>
					<td  colspan="5">'.checkEmpty('Site Address',$result['site_address']).'</td>
				</tr>
			</table>';
if($result['segment_alias']=='TQMBDTF5ZI'){ // For Railways
		$efsr.='<table class="cont_3">
			<tr>
				<td align="left">History Of The Coach</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.checkEmpty('Train Number',$result['train_no']).'</td>
				<td width="25%">'.checkEmpty('Express Name',$result['express_name']).'</td>
				<td width="25%">'.checkEmpty('Coach Number',$result['coach_no']).'</td>
				<td width="25%">'.checkEmpty('Previous Attended Date',$result['pre_attnd']).'</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.checkEmpty('POH Date',$result['poh']).'</td>
				<td width="25%">'.checkEmpty('RPOH Date',$result['rpoh']).'</td>
				<td width="25%">'.checkEmpty('Zone',$result['zone']).'</td>
				<td width="25%">'.checkEmpty('Division',$result['division']).'</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.checkEmpty('Workshop OR Yard',$result['workshop']).'</td>
				<td width="25%"></td>
				<td width="25%"></td>
				<td width="25%"></td>
			</tr>
		</table>';
		$efsr.='<table class="cont_3">
			<tr>
				<td align="left">Equipment Details</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.checkEmpty('Alternate Make',$result['altenate_make']).'</td>
				<td width="25%">'.imgcheck($result['altenate_make_doc']).'</td>
				<td width="25%">'.checkEmpty('Alternator Belt Status',$result['altenate_belt_status']).'</td>
				<td width="25%">'.imgcheck($result['altenate_belt_doc']).'</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.checkEmpty('RRU ERRU Make',$result['rru_make']).'</td>
				<td width="25%">'.checkEmpty('Invertor Make',$result['invertor_make']).'</td>
				<td width="25%">'.checkEmpty('Regulator Make',$result['regulator_make']).'</td>
				<td width="25%">'.checkEmpty('Voltage Regulation',$result['voltage_regulation']).'</td>
			</tr>
		</table>';
		$efsr.='<table class="cont_3">
			<tr>
				<td align="left">Check Points</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.checkEmpty('ICC Tightness',$result['icc_tightness']).'</td>
				<td width="25%">'.checkEmpty('Any Heating OR Melt Marks',$result['heating_melting_marks']).'</td>
				<td width="25%">'.checkEmpty('Terminal Tightness',$result['terminal_tightness']).'</td>
				<td width="25%">'.checkEmpty('Alternate No Of Belts Available',$result['alt_no_belt_avl']).'</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.checkEmpty('Vent Plug Tightness',$result['vent_plug_tightness']).'</td>
				<td width="25%">'.checkEmpty('Vent Belt',$result['belt']).'</td>
				<td width="25%">'.checkEmpty('Log Book',$result['log_book']).'</td>
				<td width="25%">'.checkEmpty('Coach Status',$result['coach_status']).'</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.checkEmpty('Any Physical Damages',$result['physical_damage']).'</td>
				<td width="25%">'.imgcheck($result['physical_damage_pic']).'</td>
				<td width="25%">'.checkEmpty('Cell Budge',$result['cell_buldge']).'</td>
				<td width="25%">'.imgcheck($result['cell_buldge_pic']).'</td>
			</tr>
			<tr>
				<td width="50%" colspan="2"  align="left"><p>'.($result['e_sig_cust_sign']!="" && $result['e_sig_cust_sign']!='0' ? '<img style="float:right;" src="'.$base_url.$result['e_sig_cust_sign'].'" width="80"/>' : 'Customer Not Available').'</p></td>
				<td width="50%"  colspan="2" align="right"><p>'.signcheck($result['e_sig_engineer_sign']).'</p></td>
			</tr>
			<tr>
				<th width="50%"  colspan="2" align="left">(Customer Signature)</th>
				<th width="50%"  colspan="2" align="right">(Engineer Signature)</th>
			</tr>
		</table>';
}elseif($result['segment_alias']=='YGRKJJD4N7'){ // For Motive Power
		$efsr.='<table class="cont_3">
			<tr>
				<td align="left">PHYSICAL OBSERVATION</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.checkEmpty('Physical Damages',$result['physical_damages']).'</td>
				<td width="25%">'.imgcheck($result['physical_damages_document']).'</td>
				<td width="25%">'.checkEmpty('Leakage',$result['leakage']).'</td>
				<td width="25%">'.imgcheck($result['leakage_document']).'</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.($result['temperature']!='' ? '<h3>Room Temperature </h3><p>'.$result['temperature'].' <sup>o</sup>C</p>' : '').'</td>
				<td width="25%">'.($result['ambient_temperature']!='' ? '<h3>Ambient Temperature </h3> <p>'.$result['ambient_temperature'].' <sup>o</sup>C</p>' : '').'</td>
				<td width="25%">'.checkEmpty('General Observations',$result['general_observation']).'</td>
				<td width="25%">'.checkEmpty('Terminal Torque',$result['terminal_torque']).'</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.checkEmpty('Acid Temp Discharge',$result['acid_temp_discharge']).'</td>
				<td width="25%">'.checkEmpty('Acid Temp Charge',$result['acid_temp_charge']).'</td>
				<td width="25%">'.checkEmpty('Cells Temp After Use',$result['cells_temp_after_use']).'</td>
				<td width="25%">'.checkEmpty('Cells Temp At Charge',$result['cells_temp_at_charge']).'</td>
			</tr>
		</table>';
		$efsr.='<table class="cont_3">
			<tr>
				<td align="left">Charger Details</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.checkEmpty('Charger Type',$result['charger_type']).'</td>
				<td width="25%">'.checkEmpty('Charger Manufacturing Date',$result['charger_manufacturing_date']).'</td>
				<td width="25%">'.checkEmpty('Serial Number',$result['serial_no']).'</td>
				<td width="25%">'.($result['voltage']!="" ? '<h3>Voltage : '.$result['voltage'].' V</h3><p>'.imgcheck($result['charger_pic']) : "").'</p></td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.checkEmpty('Charging Current',$result['charging_current']).'</td>
				<td width="25%">'.checkEmpty('High Voltage Cut Off',$result['high_voltage_cutoff']).'</td>
				<td width="25%">'.checkEmpty('Voltage Ripple',$result['voltage_ripple']).'</td>
				<td width="25%">'.checkEmpty('Voltage Regulation',$result['voltage_regulation']).'</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.checkEmpty('Charger Band',$result['charger_band']).'</td>
				<td width="25%">'.imgcheck($result['charger_image']).'</td>
				<td width="25%"></td>
				<td width="25%"></td>
			</tr>
		</table>';
		$efsr.='<table class="cont_3">
			<tr>
				<td align="left">Forklift Details</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.checkEmpty('Forklift Brand',$result['fork_lift_brand']).'</td>
				<td width="25%">'.imgcheck($result['fork_lift_pic']).'</td>
				<td width="25%">'.checkEmpty('Forklift Model',$result['fork_lift_model']).'</td>
				<td width="25%">'.checkEmpty('Forklift Manufacturing Date',$result['fork_lift_manf_date']).'</td>
			</tr>
		</table>';
		$efsr.='<table class="cont_3">
			<tr>
				<td align="left">Battery Details</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.checkEmpty('Battery Type',$result['battey_type']).'</td>
				<td width="25%">'.checkEmpty('Battery Bank Serial Number',$result['bank_serial_no']).'</td>
				<td width="25%">'.checkEmpty('Manufacturing Date',$result['battey_manf_date']).'</td>
				<td width="25%">'.checkEmpty('Installation Date',$result['battey_ins_date']).'</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.checkEmpty('Plug Type',$result['plug_type']).'</td>
				<td width="25%">'.checkEmpty('Acid Level',$result['acid_level']).'</td>
				<td width="25%"></td>
				<td width="25%"></td>
			</tr>
		</table>';
}else{ // other than Railways and Motive Power
		$efsr.='<table class="cont_3">
			<tr>
				<td align="left">PHYSICAL OBSERVATION</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.($result['temperature']!='' && $result['ambient_temperature']!='' ? '<h3>Temperature Details</h3><p>'.$result['temperature_type'].':'.$result['temperature'].'<sup>o</sup>C || AMBIENT: '.$result['ambient_temperature'].'<sup>o</sup>C' : '').'</td>
				<td width="25%">'.checkEmpty('General Observations',$result['general_observation']).'</td>
				<td width="25%">'.($result['vent_plug_type']!='' ? '<h3>Vent plug Tightness</h3><p>'.$result['vent_plug_type'].'</p>' : '').'</td>
				<td width="25%">'.($result['terminal_torque']!='' ? '<h3>Terminal Torque</h3><p>'.$result['terminal_torque'].'</p>' : '').'</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.checkEmpty('Physical Damages',$result['physical_damages']).'</td>
				<td width="25%">'.imgcheck($result['physical_damages_document']).'</td>
				<td width="25%">'.checkEmpty('Leakage',$result['leakage']).'</td>
				<td width="25%">'.imgcheck($result['leakage_document']).'</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.checkEmpty('No Of Cell Tightened',$result['no_of_cell_tightened']).'</td>
				<td width="25%"></td>
				<td width="25%"></td>
				<td width="25%"></td>
			</tr>
		</table>';
		//SMPS Observation
		$efsr.='<table class="cont_3">
			<tr>
				<td align="left">'.smpsheading($result['segment_alias']).' - '.$result['panel_make'].'</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.($result['float_voltage']!='' ? '<h3>Float Voltage : '.$result['float_voltage'].' V</h3>' : '').imgcheck($result['float_voltage_image']).'</td>
				<td width="25%">'.($result['boast_voltage']!='' ? '<h3>Boost Voltage : '.$result['boast_voltage'].' V</h3>' : '').imgcheck($result['boast_voltage_image']).'</td>
				<td width="25%">'.($result['current_limit']!='' ? '<h3>Current Limit : </h3><p>'.$result['current_limit'].' AMPS</p>' : '').'</td>
				<td width="25%">'.($result['voltage_ripple']!='' ? '<h3>Voltage Ripple : </h3><p>'.$result['voltage_ripple'].' MV</p>' : '').'</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.($result['high_voltage_cutoff']!='' ? '<h3>High Voltage Cut Off : </h3><p>'.$result['high_voltage_cutoff'].' V</p>' : '').'</td>
				<td width="25%">'.($result['low_voltage_cutoff']!='' ? '<h3>Low Voltage Cut Off : </h3><p>'.$result['low_voltage_cutoff'].' V</p>' : '').'</td>
				<td width="25%">'.checkEmpty(smpslabel($result['segment_alias']).' Rating : ',$result['panel_rating']).'</td>
				<td width="25%">'.checkEmpty(smpslabel($result['segment_alias']).' Manf. Date :',$result['panel_manufacturing_date']).'</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.($result['voltage_regulation']!='' && $result['segment_alias']!='HXL5A1HOTZ' ? '<h3>Voltage Regulation:</h3><p>'.$result['voltage_regulation'].'</p>' : '').'</td>
				<td width="25%">'.checkEmpty(smpslabel($result['segment_alias']).' Installation Date:',$result['panel_installation_date']).'</td>';
if($result['segment_alias']=='KWJCZKSTBL' || $result['segment_alias']=='DDEYO7NTTC'){ // SA OR TS
		$efsr.='<td width="25%">'.checkEmpty('Charge Controller Rating',$result['charge_controller_rate']).'</td>
				<td width="25%">'.checkEmpty('Charger Controller Make',$result['charge_controller_make']).'</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.($result['no_solar_panels']!='' ? '<h3>Number of Solar Panels : '.$result['no_solar_panels'].'</h3>' : '').imgcheck($result['document_3']).'</td>
				<td width="25%">'.checkEmpty('Single Panel Rating (Watts)',$result['single_panel_rating']).'</td>
				<td width="25%">'.checkEmpty('Charge Controller Manufacturing Date',$result['charge_control_manufacturing_date']).'</td>
				<td width="25%"></td>';
}elseif($result['segment_alias']=='HXL5A1HOTZ'){ // TL
		$efsr.='<td width="25%">'.checkEmpty('SMR Moduls Rating(Amps)',$result['charge_controller_rate']).'</td>
				<td width="25%">'.($result['no_solar_panels']!='' ? '<h3>Working Modules: '.$result['no_solar_panels'].'</h3>' : '').imgcheck($result['document_3']).'</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%">'.($result['single_panel_rating']!='' ? '<h3>SMPS Display : '.$result['single_panel_rating'].'</h3><br>' : '').imgcheck($result['document_5']).'</td>
				<td width="25%">'.($result['voltage_regulation']!='' ? '<h3>LVD\'S Status : '.$result['voltage_regulation'].'</h3><br>' : '').imgcheck($result['document_4']).'</td>
				<td width="25%"></td>
				<td width="25%"></td>';
}
		$efsr.='</tr>
		</table>
		<table class="cont_3">
			<tr>
				<td align="left">GENERATOR & POWER OBSERVATIONS</td>
			</tr>
		</table>
		<table class="cont_2">
			<tr>
				<td width="25%" valign="top"><h3>DG Status: '.$result['dg_status'].'</h3>'.imgcheck($result['dg_pic']).'<br><h3>Site Load: </h3><p>'.gettwodecimal($result['site_load']).' AMPS</p></td>
				<td width="25%">';
				if($result['dg_status']=='AVAILABLE'){
					$efsr.='<h3>DG Make: </h3><p>'.$result['dg_make'].'</p><br><h3>DG Capacity: </h3><p>'.$result['dg_capacity'].' KVA </p>';
					$efsr.='</td>
					<td width="25%">
					<h3>Working Condition: </h3><p>'.$result['dg_working_condition'].'</p><br><h3>Avg DG Run: </h3><p>'.$result['avg_dg_run'].' HRS/DAY</p>';
				}
				
				$efsr.='</td><td width="25%"><h3> E.B suppy: </h3><p>'.$result['eb_supply'].'</p><br>';
				if($result['eb_supply']=='YES'){
					$efsr.='<h3>Failures per Day: </h3><p>'.$result['failures_per_day'].' HRS</p><br><h3> Average Power Cut: </h3><p>'.$result['avg_power_cut'].' HRS/DAY</p>';
				}
			$efsr.='</td></tr>
		</table>';
		}
if($result['segment_alias']!='TQMBDTF5ZI'){ //Not railways
		$efsr.='<table width="100%">
			<tr>
				<td width="50%" align="left"><p>'.($result['e_sig_cust_sign']!="" && $result['e_sig_cust_sign']!='0' ? '<img style="float:right;" src="'.$base_url.$result['e_sig_cust_sign'].'" width="80"/>' : 'Customer Not Available').'</p></td>
				<td width="50%" align="right"><h3>'.signcheck($result['e_sig_engineer_sign']).'</h3></td>
			</tr>
			<tr>
				<th width="50%" align="left">(Customer Signature)</th>
				<th width="50%" align="right">(Engineer Signature)</th>
			</tr>
		</table>';
		}
$efsr.='</td>
	</tr>
</table></body></html>';

if(count($battery_obs)>0){
	if($result['segment_alias']=='YGRKJJD4N7'){ $tr = 1; $span = 4; $hspan = 6; }else{$tr = 0;$span = 3; $hspan = 5;}
	for($xxx=0;$xxx<count($battery_obs);$xxx++){
		$battery_ob[$xxx]='<html><body>';
		if((count($header_a[$xxx])+count($header_b[$xxx])+count($header_c[$xxx])+$hspan)>=17) $battery_ob[$xxx].='<table class="table2">';
		else $battery_ob[$xxx].='<table class="table1">';
		$battery_ob[$xxx].='<tr>';
		if((count($header_a[$xxx])+count($header_b[$xxx])+count($header_c[$xxx])+$hspan)>=17) $battery_ob[$xxx].='<td class="td2">';
		else $battery_ob[$xxx].='<td class="td1">';
		$battery_ob[$xxx].='<table class="tableHeader" width="100%">';
		$battery_ob[$xxx].='<tr>';
		$battery_ob[$xxx].='<td align="left" width="20%"><img src="images/logo.png"></td>';
		$battery_ob[$xxx].='<td align="center" width="60%"><h2>e-FSR<h2></td>';
		$battery_ob[$xxx].='<td align="right" width="20%"><img src="images/logo-4.jpg" width="100px"></td>';
		$battery_ob[$xxx].='</tr>';
		$battery_ob[$xxx].='</table>';
		$battery_ob[$xxx].='<table class="cont_1" style="width:100%">';
		$battery_ob[$xxx].='<tr>';
		$battery_ob[$xxx].='<td align="left">e-FSR No: '.$result['efsr_no'].'</td>';
		$battery_ob[$xxx].='<td align="right">Date: '.$result['efsr_date'].'</td>';
		$battery_ob[$xxx].='</tr>';
		$battery_ob[$xxx].='</table>';
		$battery_ob[$xxx].='<table class="botable">';
		$battery_ob[$xxx].='<thead>';
		$battery_ob[$xxx].='<tr><th colspan="'.(count($header_a[$xxx])+count($header_b[$xxx])+count($header_c[$xxx])+$hspan).'">Battery Observation Report For Bank - '.($xxx+1).'</th></tr>';
		$battery_ob[$xxx].='<tr><th colspan="'.(count($header_a[$xxx])+count($header_b[$xxx])+count($header_c[$xxx])+$hspan).'">Battery Bank Rating: '.$bank_rating[$xxx].'</th></tr>';
		$battery_ob[$xxx].='</thead>';
		$battery_ob[$xxx].='<tbody>';
		$battery_ob[$xxx].='<tr class="subhead">';
		$battery_ob[$xxx].='<td rowspan="2">Sl No</td>';
		$battery_ob[$xxx].='<td rowspan="2">MF Date</td>';
		$battery_ob[$xxx].='<td rowspan="2">Cell Sl No</td>';
		if($tr){$battery_ob[$xxx].='<td rowspan="2">Acid Density</td>';}
		$battery_ob[$xxx].='<td rowspan="2">OCV</td>';
		if(count($header_a[$xxx])>0)$battery_ob[$xxx].='<td colspan="'.(count($header_a[$xxx])).'">On Charge Voltage</td>';
		if(count($header_b[$xxx])>0)$battery_ob[$xxx].='<td colspan="'.(count($header_b[$xxx])).'">DisCharge Voltage</td>';
		if(count($header_c[$xxx])>0)$battery_ob[$xxx].='<td colspan="'.(count($header_c[$xxx])).'">On Charge Voltage</td>';
		$battery_ob[$xxx].='<td>Remarks</td>';
		$battery_ob[$xxx].='</tr>';
		$battery_ob[$xxx].='<tr>';
		for($y_x=0;$y_x<count($header_a[$xxx]);$y_x++){$battery_ob[$xxx].='<th>'.$header_a[$xxx][$y_x].'</th>';}
		for($y_x=0;$y_x<count($header_b[$xxx]);$y_x++){$battery_ob[$xxx].='<th>'.$header_b[$xxx][$y_x].'</th>';}
		for($y_x=0;$y_x<count($header_c[$xxx]);$y_x++){$battery_ob[$xxx].='<th>'.$header_c[$xxx][$y_x].'</th>';}
		$battery_ob[$xxx].='<th></th>';
		$battery_ob[$xxx].='</tr>';
		for($y_xa=0;$y_xa<count($cell_sl_no[$xxx]);$y_xa++){
			$battery_ob[$xxx].='<tr>';
			$battery_ob[$xxx].='<td>'.($y_xa+1).'</td>';
			$battery_ob[$xxx].='<td>'.$mf_date[$xxx][$y_xa].'</td>';
			$battery_ob[$xxx].='<td>'.$cell_sl_no[$xxx][$y_xa].'</td>';
			if($tr){$battery_ob[$xxx].='<td>'.$acid_density[$xxx][$y_xa].'</td>';}
			$battery_ob[$xxx].='<td>'.$ocv[$xxx][$y_xa].'</td>';
			for($y_xb=0;$y_xb<(count($header_a[$xxx]));$y_xb++){
				$battery_ob[$xxx].='<td>'.$battery_Volts[$xxx][$y_xa][$y_xb].'</td>';
			}
			for($y_xb=0;$y_xb<(count($header_b[$xxx]));$y_xb++){
				$battery_ob[$xxx].='<td>'.$battery_Volts_a[$xxx][$y_xa][$y_xb].'</td>';
			}
			for($y_xb=0;$y_xb<(count($header_c[$xxx]));$y_xb++){
				$battery_ob[$xxx].='<td>'.$battery_Volts_b[$xxx][$y_xa][$y_xb].'</td>';
			}

			$battery_ob[$xxx].='<td>'.$remarks[$xxx][$y_xa].'</td>';
			$battery_ob[$xxx].='</tr>';
		}
		$battery_ob[$xxx].='<tr>';
		$battery_ob[$xxx].='<td colspan="'.$span.'" align="right">Total Voltage (V)</td>';
		for($y_x=0;$y_x<count($header_o[$xxx]);$y_x++){$battery_ob[$xxx].='<td>'.$tVoltage_o[$xxx][$y_x].'</td>';}
		for($y_x=0;$y_x<count($header_a[$xxx]);$y_x++){$battery_ob[$xxx].='<td>'.$tVoltage_a[$xxx][$y_x].'</td>';}
		for($y_x=0;$y_x<count($header_b[$xxx]);$y_x++){$battery_ob[$xxx].='<td>'.$tVoltage_b[$xxx][$y_x].'</td>';}
		for($y_x=0;$y_x<count($header_c[$xxx]);$y_x++){$battery_ob[$xxx].='<td>'.$tVoltage_c[$xxx][$y_x].'</td>';}
		$battery_ob[$xxx].='<td></td>';
		$battery_ob[$xxx].='</tr>';
		$battery_ob[$xxx].='<tr>';
		$battery_ob[$xxx].='<td colspan="'.$span.'" align="right">Current (I)</td>';
		for($y_x=0;$y_x<count($header_o[$xxx]);$y_x++){$battery_ob[$xxx].='<td>+ '.$cCurrent_o[$xxx][$y_x].'</td>';}
		for($y_x=0;$y_x<count($header_a[$xxx]);$y_x++){$battery_ob[$xxx].='<td>+ '.$cCurrent_a[$xxx][$y_x].'</td>';}
		for($y_x=0;$y_x<count($header_b[$xxx]);$y_x++){$battery_ob[$xxx].='<td>- '.$cCurrent_b[$xxx][$y_x].'</td>';}
		for($y_x=0;$y_x<count($header_c[$xxx]);$y_x++){$battery_ob[$xxx].='<td>+ '.$cCurrent_c[$xxx][$y_x].'</td>';}
		$battery_ob[$xxx].='<td></td>';
		$battery_ob[$xxx].='</tr>';
		$battery_ob[$xxx].='<tr>';
		$battery_ob[$xxx].='<td colspan="'.$span.'" align="right">Temperature</td>';
		for($y_x=0;$y_x<count($header_o[$xxx]);$y_x++){$battery_ob[$xxx].='<td>'.$temp_o[$xxx][$y_x].'</td>';}
		for($y_x=0;$y_x<count($header_a[$xxx]);$y_x++){$battery_ob[$xxx].='<td>'.$temp_a[$xxx][$y_x].'</td>';}
		for($y_x=0;$y_x<count($header_b[$xxx]);$y_x++){$battery_ob[$xxx].='<td>'.$temp_b[$xxx][$y_x].'</td>';}
		for($y_x=0;$y_x<count($header_c[$xxx]);$y_x++){$battery_ob[$xxx].='<td>'.$temp_c[$xxx][$y_x].'</td>';}
		$battery_ob[$xxx].='<td></td>';
		$battery_ob[$xxx].='</tr>';
		$battery_ob[$xxx].='</tbody>';
		$battery_ob[$xxx].='</table><br><br><br>';
		$battery_ob[$xxx].='<table width="100%">';
		$battery_ob[$xxx].='<tr>';
		$battery_ob[$xxx].='<td width="50%" align="left"><p>'.($result['e_sig_cust_sign']!="" && $result['e_sig_cust_sign']!='0' ? '<img style="float:right;" src="'.$base_url.$result['e_sig_cust_sign'].'" width="80"/>' : 'Customer Not Available').'</p></td>';
		$battery_ob[$xxx].='<td width="50%" align="right"><p>'.signcheck($result['e_sig_engineer_sign']).'</p></td>';
		$battery_ob[$xxx].='</tr>';
		$battery_ob[$xxx].='<tr>';
		$battery_ob[$xxx].='<th width="50%" align="left">(Customer Signature)</th>';
		$battery_ob[$xxx].='<th width="50%" align="right">(Engineer Signature)</th>';
		$battery_ob[$xxx].='</tr>';
		$battery_ob[$xxx].='</table>';					
		$battery_ob[$xxx].='</td>';
		$battery_ob[$xxx].='</tr>';
		$battery_ob[$xxx].='</table></body></html>';
	}
}
if(count($bank_img)>0){
	for($xxx=0;$xxx<count($bank_img);$xxx++){
		$battery_ob[$xxx].='<html><body>';
		$battery_ob[$xxx].='<table class="table1">';
		$battery_ob[$xxx].='<tr>';
		$battery_ob[$xxx].='<td class="td1">';
		$battery_ob[$xxx].='<table class="tableHeader" width="100%">';
		$battery_ob[$xxx].='<tr>';
		$battery_ob[$xxx].='<td align="left" width="20%"><img src="images/logo.png"></td>';
		$battery_ob[$xxx].='<td align="center" width="60%"><h2>e-FSR</h2></td>';
		$battery_ob[$xxx].='<td align="right" width="20%"><img src="images/logo-4.jpg" width="100px"></td>';
		$battery_ob[$xxx].='</tr>';
		$battery_ob[$xxx].='</table>';
		$battery_ob[$xxx].='<table class="cont_1" style="width:100%">';
		$battery_ob[$xxx].='<tr>';
		$battery_ob[$xxx].='<td align="left">e-FSR No: '.$result['efsr_no'].'</td>';
		$battery_ob[$xxx].='<td align="right">Date: '.$result['efsr_date'].'</td>';
		$battery_ob[$xxx].='</tr>';
		$battery_ob[$xxx].='</table>';
		
		$battery_ob[$xxx].='<table class="botable">';
		$battery_ob[$xxx].='<thead>';
		$battery_ob[$xxx].='<tr><th>Battery Observation Report For Bank - '.($xxx+1).'</th></tr>';
		$battery_ob[$xxx].='<tr><th>Manual e-fsr - '.($xxx+1).'</th></tr>';
		$battery_ob[$xxx].='</thead>';
		$battery_ob[$xxx].='<tbody>';
		
		$battery_ob[$xxx].='<tr>';
		$battery_ob[$xxx].='<td align="center">';
		$battery_ob[$xxx].='<img src="'.$base_url.$bank_img[$xxx].'" height="100%">';
		$battery_ob[$xxx].='</td>';
		$battery_ob[$xxx].='</tr>';
		$battery_ob[$xxx].='</tbody>';
		$battery_ob[$xxx].='</table><br><br><br>';
		$battery_ob[$xxx].='<table width="100%">';
		$battery_ob[$xxx].='<tr>';
		$battery_ob[$xxx].='<td width="50%" align="left"><p>'.($result['e_sig_cust_sign']!="" && $result['e_sig_cust_sign']!='0' ? '<img style="float:right;" src="'.$base_url.$result['e_sig_cust_sign'].'" width="80"/>' : 'Customer Not Available').'</p></td>';
		$battery_ob[$xxx].='<td width="50%" align="right"><p>'.signcheck($result['e_sig_engineer_sign']).'</p></td>';
		$battery_ob[$xxx].='</tr>';
		$battery_ob[$xxx].='<tr>';
		$battery_ob[$xxx].='<th width="50%" align="left">(Customer Signature)</th>';
		$battery_ob[$xxx].='<th width="50%" align="right">(Engineer Signature)</th>';
		$battery_ob[$xxx].='</tr>';
		$battery_ob[$xxx].='</table>';					
		$battery_ob[$xxx].='</td>';
		$battery_ob[$xxx].='</tr>';
		$battery_ob[$xxx].='</table></body></html>';
	}
}

$page3='<html><body>
<table class="table1">
	<tr>
		<td class="td1">
			<table class="tableHeader" width="100%">
				<tr>
					<td align="left" width="35%"><img src="images/logo.png"></td>
					<td align="center" width="30%"><h2>e-FSR<h2></td>
					<td align="right" width="35%"><img src="images/logo-4.jpg" width="100px"></td>
				</tr>
			</table>
			<table class="cont_1">
				<tr>
					<td align="left">e-FSR No: '.$result['efsr_no'].'</td>
					<td align="right">Date: '.$result['efsr_date'].'</td>
				</tr>
			</table>
			<table class="cont_3">
				<tr>
					<td align="left">SERVICE ENGINEER OBSERVATION</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>
					<td width="50%"><h3>Faulty Cells</h3><p>'.($result['faulty_cell_sr_no']=="" || $result['faulty_cell_sr_no']=="none" ? "NONE" : str_replace(",",", ",$result['faulty_cell_sr_no'])).'</p></td>
					<td width="50%">'.checkEmpty('Required Accessories',$result['req_acc']).'</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>
					<td width="50%">'.checkEmpty('Required Cells',$result['req_cells']).'</td>
					<td width="50%">'.checkEmpty('Faulty Code',$result['faulty_code']).'</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>
					<td width="50%" style="text-align:justify">'.checkEmpty('Action Taken',str_replace(",",", ",$result['observation'])).'</td>
					<td width="50%">'.checkEmpty('Job Performed',$result['job_performed']).'</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>
					<td width="50%" style="text-align:justify">'.checkEmpty('Remarks',str_replace(",",", ",$result['remarks'])).'</td>
					<td width="50%" style="text-align:justify">'.checkEmpty('Replaced Cells',str_replace(",",", ",$result['requested_cells'])).'</td>
				</tr>
			</table>
			<table class="cont_3">
				<tr>
					<td align="left">CUSTOMER REVIEW</td>
				</tr>
			</table>
			<table class="cont_2">
				<tr>
					<td width="30%">'.checkEmpty('Customer Name',$result['e_sig_name']).'</td>
					<td width="20%">'.checkEmpty('Designation',$result['e_sig_designation']).'</td>
					<td width="20%">'.checkEmpty('Contact Number',$result['e_sig_contact_number']).'</td>
					<td width="30%">'.checkEmpty('Remarks',$result['e_sig_customer_comments']).'</td>
				</tr>
				<tr>
					<td width="30%">'.checkEmpty('Customer Email',$result['e_sig_email']).'</td>
					<td width="20%"></td>
					<td width="20%"></td>
					<td width="30%"></td>
				</tr>
			</table>';
			if($result['q1'] || $result['q2'] || $result['q3'] || $result['q4'] || $result['q5'] || (!empty($result['e_sig_customer_comments']) ? 1 : 0)){
			$page3.='<table class="cont_2">
				<tr>
					<td width="45%">
						<h3>Are you satisfied with the Response</h3>
						<p>'.star($result['q1']).'</p>
					</td>
					<td width="10%"></td>
					<td width="45%">
						<h3>Are you satisfied with the Technical Capability of the Service Personnel</h3>
						<p>'.star($result['q2']).'</p>
					</td>
				</tr>
				<tr>
					<td width="45%">
						<h3>Are you satisfied with the professional conduct of the Service Personnel</h3>
						<p>'.star($result['q3']).'</p>
					</td>
					<td width="10%"></td>
					<td width="45%">
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
			$page3.='<table class="cont_2">
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
					<td width="50%" align="center"><p>'.($result['e_sig_cust_sign']!="" && $result['e_sig_cust_sign']!='0' ? '<img style="float:right;" src="'.$base_url.$result['e_sig_cust_sign'].'" width="80"/>' : 'Customer Not Available').'</p></td>
					<td width="50%" align="center"><p>'.signcheck($result['e_sig_engineer_sign']).'</p></td>
				</tr>
				<tr>
					<td width="50%" align="center"><p>'.($result['e_sig_cust_sign']!="" && $result['e_sig_cust_sign']!='0' ? $result['e_sig_name'] : '').'</p></td>
					<td width="50%" align="center"><p>'.$result['emp_name'].'</p></td>
				</tr>
			</table>
		</td>
	</tr>
</table></body></html>';
//$content=$efsr.$battery_ob;
$content=$efsr;
include('mpdf60/mpdf.php');
//$mpdf=new mPDF($mode, $format, $font_size, $font, $margin_left, $margin_right, $margin_top, $margin_bottom, $margin_header, $margin_footer, $orientation);
$mpdf=new mPDF('','', 0, '', 5, 5, 5, 5, '', '2', '');
$mpdf->SetHTMLFooter("<p style=\"text-align:right;font-style: italic;font-size:12px;\">{PAGENO}/{nbpg}</p>");
$mpdf->pagenumPrefix = 'Page No : ';
$mpdf->SetWatermarkImage('images/logo-3.png');
$mpdf->showWatermarkImage = true;
$mpdf->watermarkImageAlpha = 0.06;
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($content,2);

if(count($battery_obs)>0){
	for($xxx=0;$xxx<count($battery_obs);$xxx++){
		if((count($header_a[$xxx])+count($header_b[$xxx])+count($header_c[$xxx])+5)>=17) $mpdf->AddPage('L','','','0','',5,5,5,5,'',2);
		else $mpdf->AddPage('','','','0','',5,5,5,5,'',2);
		$mpdf->WriteHTML($battery_ob[$xxx],3);
	}
}
if(count($bank_img)>0){
	for($xxx=0;$xxx<count($bank_img);$xxx++){
		$mpdf->AddPage('','','','0','',5,5,5,5,'',2);
		$mpdf->WriteHTML($battery_ob[$xxx],3);
	}
}
$mpdf->AddPage('','','','0','',5,5,5,5,'',2);
$mpdf->WriteHTML($page3,3);
$filename=($result['ticket_id']!='' ? $result['ticket_id'] : "enersys_efsr");
$mpdf->Output("$filename.pdf", "I");
//echo $content;
//D: download the PDF file || I: serves in-line to the browser || S: returns the PDF document as a string || F: save as file file_out
exit;
