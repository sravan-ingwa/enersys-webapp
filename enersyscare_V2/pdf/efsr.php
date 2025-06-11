<?php
include('mysql.php');
	$ticket_alias=$_REQUEST['ticket_alias'];
	$sql=mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE ticket_alias='$ticket_alias' AND flag=0");
	$row=mysqli_fetch_array($sql);
	$d_s=alias($row['activity_alias'],'ec_activity','activity_alias','activity_code');
	$segment_code = alias(alias($row['site_alias'],'ec_sitemaster','site_alias','segment_alias'),'ec_segment','segment_alias','segment_code');
	$filename = $row['ticket_id'];

	//Ticket Details
	$result['ticket_id']=$row['ticket_id'];
	$result['login_date']=dateFormat($row['login_date'],"d");
	$result['segment_alias']=alias($row['site_alias'],'ec_sitemaster','site_alias','segment_alias');
	$result['segment_name']=alias(alias($row['site_alias'],'ec_sitemaster','site_alias','segment_alias'),'ec_segment','segment_alias','segment_name');
	$result['site_id']=alias($row['site_alias'],'ec_sitemaster','site_alias','site_id');
	$result['site_name']=alias($row['site_alias'],'ec_sitemaster','site_alias','site_name');
	$result['site_address']=alias($row['site_alias'],'ec_sitemaster','site_alias','site_address');
	$result['zone_name']=alias(alias($row['site_alias'],'ec_sitemaster','site_alias','zone_alias'),'ec_zone','zone_alias','zone_name');
	$result['state_name']=alias(alias($row['site_alias'],'ec_sitemaster','site_alias','state_alias'),'ec_state','state_alias','state_name');
	$result['district_name']=alias(alias($row['site_alias'],'ec_sitemaster','site_alias','district_alias'),'ec_district','district_alias','district_name');
	$result['planned_date']=dateFormat($row['planned_date'],"d");
	$result['mfd_date']=dateFormat(alias($row['site_alias'],'ec_sitemaster','site_alias','mfd_date'),"d");
	$result['install_date']=dateFormat(alias($row['site_alias'],'ec_sitemaster','site_alias','install_date'),"d");
	$result['activation_date']=dateFormat($row['activation_date'],"d");
	$result['customer_name']=alias(alias($row['site_alias'],'ec_sitemaster','site_alias','customer_alias'),'ec_customer','customer_alias','customer_name');
	$result['emp_name']=alias($row['service_engineer_alias'],'ec_employee_master','employee_alias','name');
	$result['emp_mobile_number']=alias($row['service_engineer_alias'],'ec_employee_master','employee_alias','mobile_number');
	$result['technician_name']=alias($row['site_alias'],'ec_sitemaster','site_alias','technician_name');
	$result['technician_number']=alias($row['site_alias'],'ec_sitemaster','site_alias','technician_number');
	$result['no_of_string']=alias($row['site_alias'],'ec_sitemaster','site_alias','no_of_string');
	$result['site_type']=alias(alias($row['site_alias'],'ec_sitemaster','site_alias','site_type_alias'),'ec_site_type','site_type_alias','site_type');
	$result['activity_code']=alias($row['activity_alias'],'ec_activity','activity_alias','activity_code');
	$result['complaint_name']=alias($row['complaint_alias'],'ec_complaint','complaint_alias','complaint_name');
	$result['product_description']=alias(alias($row['site_alias'],'ec_sitemaster','site_alias','product_alias'),'ec_product','product_alias','product_description');
	$result['batteryrating']=alias(alias($row['site_alias'],'ec_sitemaster','site_alias','product_alias'),'ec_product','product_alias','battery_rating');
	$bb_rating=alias($row['site_alias'],'ec_sitemaster','site_alias','battery_bank_rating');
	$result['description']=$row['description'];
	$result['mode_of_contact']=alias($row['mode_of_contact'],'ec_moc','moc_alias','moc_name');
	$result['efsr_no']=$row['efsr_no'];
	$result['faulty_cell_count']=$row['faulty_cell_count'];
	$result['efsr_date']=$row['efsr_date'];

	//Railway segment
	$coach_sql=mysqli_query($mr_con,"SELECT * FROM ec_coach_history WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($coach_sql)){$coach_row=mysqli_fetch_array($coach_sql);
		$result['train_no']=$coach_row['train_no'];
		$result['express_name']=$coach_row['express_name'];
		$result['coach_no']=$coach_row['coach_no'];
		$result['pre_attnd']=dateFormat($coach_row['pre_attnd'],"d");
		$result['poh']=dateFormat($coach_row['poh'],"d");
		$result['rpoh']=dateFormat($coach_row['rpoh'],"d");
		$result['zone']=$coach_row['zone'];
		$result['division']=$coach_row['division'];
		$result['workshop']=$coach_row['workshop'];
	}
	//Equipment Details
	$equip_sql=mysqli_query($mr_con,"SELECT * FROM ec_equip_details WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($equip_sql)){ $equip_row=mysqli_fetch_array($equip_sql);
		$result['altenate_make']=$equip_row['altenate_make'];
		$result['altenate_make_doc']=$equip_row['altenate_make_doc'];
		$result['altenate_belt_status']=$equip_row['altenate_belt_status'];
		$result['altenate_belt_doc']=$equip_row['altenate_belt_doc'];
		$result['rru_make']=$equip_row['rru_make'];
		$result['invertor_make']=$equip_row['invertor_make'];
		$result['voltage_regulation']=$equip_row['voltage_regulation'];
		$result['regulator_make']=$equip_row['regulator_make'];
	}
	//Check Points
	$check_points_sql=mysqli_query($mr_con,"SELECT * FROM ec_check_points WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($check_points_sql)){ $check_points_row=mysqli_fetch_array($check_points_sql);
		$result['icc_tightness']=$check_points_row['icc_tightness'];
		$result['heating_melting_marks']=$check_points_row['heating_melting_marks'];
		$result['terminal_tightness']=$check_points_row['terminal_tightness'];
		$result['alt_no_belt_avl']=$check_points_row['alt_no_belt_avl'];
		$result['vent_plug_tightness']=$check_points_row['vent_plug_tightness'];
		$result['belt']=$check_points_row['belt'];
		$result['log_book']=$check_points_row['log_book'];
		$result['coach_status']=$check_points_row['coach_status'];
		$result['physical_damage']=$check_points_row['physical_damage'];
		$result['physical_damage_pic']=$check_points_row['physical_damage_pic'];
		$result['cell_buldge']=$check_points_row['cell_buldge'];
		$result['cell_buldge_pic']=$check_points_row['cell_buldge_pic'];
	}
	//Motive Power
	//Charger Details
	$charger_sql=mysqli_query($mr_con,"SELECT * FROM ec_charger_details WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($charger_sql)){ $charger_row=mysqli_fetch_array($charger_sql);
		$result['charger_band']=$charger_row['charger_band'];
		$result['charger_pic']=$charger_row['charger_pic'];
		$result['charger_manufacturing_date']=dateFormat($charger_row['manf_date'],"d");
		$result['serial_no']=$charger_row['serial_no'];
		$result['charger_type']=$charger_row['charger_type'];
		$result['voltage']=$charger_row['voltage'];
		$result['charging_current']=$charger_row['charging_current'];
		$result['high_voltage_cutoff']=$charger_row['high_voltage_cutoff'];
		$result['voltage_ripple']=$charger_row['voltage_ripple'];
		$result['voltage_regulation']=$charger_row['voltage_regulation'];
	}
	//Fork Lift 
	$forklift_sql=mysqli_query($mr_con,"SELECT * FROM ec_fork_lift WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($forklift_sql)){ $forklift_row=mysqli_fetch_array($forklift_sql);
		$result['fork_lift_brand']=$forklift_row['fork_lift_brand'];
		$result['fork_lift_pic']=$forklift_row['fork_lift_pic'];
		$result['fork_lift_model']=$forklift_row['fork_lift_model'];
		$result['fork_lift_manf_date']=dateFormat($forklift_row['fork_lift_manf_date'],"d");
	}
	//Battery Details
	$battey_sql=mysqli_query($mr_con,"SELECT * FROM ec_battery_details WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($battey_sql)){ $battey_row=mysqli_fetch_array($battey_sql);
		$result['battey_type']=$battey_row['battey_type'];
		$result['bank_serial_no']=$battey_row['bank_serial_no'];
		$result['battey_manf_date']=dateFormat($battey_row['manf_date'],"d");
		$result['battey_ins_date']=dateFormat($battey_row['ins_date'],"d");
		$result['plug_type']=$battey_row['plug_type'];
		$result['acid_level']=$battey_row['acid_level'];
	}
	//UPS
	$ups_sql=mysqli_query($mr_con,"SELECT * FROM ec_technical_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($ups_sql) && $segment_code=="UP"){ $ups_row=mysqli_fetch_array($ups_sql);
		$result['float_voltage']=$ups_row['float_voltage'];
		$result['float_voltage_image']=$ups_row['document_1'];
		$result['boast_voltage']=$ups_row['boast_voltage'];
		$result['boast_voltage_image']=$ups_row['document_2'];
		$result['current_limit']=$ups_row['current_limit'];
		$result['voltage_ripple']=$ups_row['voltage_ripple'];
		$result['voltage_regulation']=$ups_row['voltage_regulation'];
		$result['high_voltage_cutoff']=$ups_row['high_voltage_cutoff'];
		$result['low_voltage_cutoff']=$ups_row['low_voltage_cutoff'];
		$result['panel_make']=$ups_row['panel_make'];
		$result['panel_rating']=$ups_row['panel_rating'];
		$result['panel_manufacturing_date']=dateFormat($ups_row['panel_manufacturing_date'],"d");
		$result['panel_installation_date']=dateFormat($ups_row['panel_installation_date'],"d");
	}
	//Solar/Telecom-Solar
	$solar_telecom_sql=mysqli_query($mr_con,"SELECT * FROM ec_technical_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($solar_telecom_sql) && ($segment_code=="SA" || $segment_code=="TS")){ $solar_telecom_row=mysqli_fetch_array($solar_telecom_sql);
		$result['float_voltage']=$solar_telecom_row['float_voltage'];
		$result['float_voltage_image']=$solar_telecom_row['document_1'];
		$result['boast_voltage']=$solar_telecom_row['boast_voltage'];
		$result['boast_voltage_image']=$solar_telecom_row['document_2'];
		$result['current_limit']=$solar_telecom_row['current_limit'];
		$result['voltage_ripple']=$solar_telecom_row['voltage_ripple'];
		$result['voltage_regulation']=$solar_telecom_row['voltage_regulation'];
		$result['high_voltage_cutoff']=$solar_telecom_row['high_voltage_cutoff'];
		$result['low_voltage_cutoff']=$solar_telecom_row['low_voltage_cutoff'];
		$result['panel_make']=$solar_telecom_row['panel_make'];
		$result['panel_rating']=$solar_telecom_row['panel_rating'];
		$result['charge_controller_rate']=$solar_telecom_row['charge_controller_rate'];
		$result['charge_controller_make']=$solar_telecom_row['charge_controller_make'];
		$result['no_solar_panels']=$solar_telecom_row['no_solar_panels'];
		$result['document_3']=$solar_telecom_row['document_3'];
		$result['single_panel_rating']=$solar_telecom_row['single_panel_rating'];
		$result['panel_manufacturing_date']=dateFormat($solar_telecom_row['panel_manufacturing_date'],"d");
		$result['charge_control_manufacturing_date']=dateFormat($solar_telecom_row['charge_control_manufacturing_date'],"d");
		$result['panel_installation_date']=dateFormat($solar_telecom_row['panel_installation_date'],"d");
	}
	//Physical Observation
	$physical_sql=mysqli_query($mr_con,"SELECT * FROM ec_physical_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($physical_sql)){ $physical_row=mysqli_fetch_array($physical_sql);
		$result['physical_damages']=$physical_row['physical_damages'];
		$result['physical_damages_document']=$physical_row['physical_damages_document'];
		$result['leakage']=$physical_row['leakage'];
		$result['leakage_document']=$physical_row['leakage_document'];
		$temp = explode("|",$physical_row['temperature']);
		$result['temperature_type']=$temp[0];
		$result['temperature']=$temp[1];
		$result['ambient_temperature']=$temp[2];
		$result['acid_temp_discharge']=$physical_row['acid_temp_discharge'];
		$result['acid_temp_charge']=$physical_row['acid_temp_charge'];
		$result['cells_temp_after_use']=$physical_row['cells_temp_after_use'];
		$result['cells_temp_at_charge']=$physical_row['cells_temp_at_charge'];
		$result['general_observation']=$physical_row['general_observation'];
		$vent = explode("|",$physical_row['vent_plug_thickness']);
		$result['vent_plug_type']=($vent[0]=="PERFECT" ? $vent[0] : $vent[0]." : ".$vent[1]);
		$torque = explode("|",$physical_row['terminal_torque']);
		$result['terminal_torque']=($torque[0]=="PERFECT" ? $torque[0] : $torque[0]." : ".$torque[1]);
	}
	//SMPS Observation
	$smps_sql=mysqli_query($mr_con,"SELECT * FROM ec_technical_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($smps_sql)){ $smps_row=mysqli_fetch_array($smps_sql);
		$result['float_voltage']=$smps_row['float_voltage'];
		$result['float_voltage_image']=$smps_row['document_1'];
		$result['boast_voltage']=$smps_row['boast_voltage'];
		$result['boast_voltage_image']=$smps_row['document_2'];
		$result['current_limit']=$smps_row['current_limit'];
		$result['voltage_ripple']=$smps_row['voltage_ripple'];
		$result['high_voltage_cutoff']=$smps_row['high_voltage_cutoff'];
		$result['low_voltage_cutoff']=$smps_row['low_voltage_cutoff'];
		$result['voltage_regulation']=$smps_row['voltage_regulation'];
		$result['document_3']=$smps_row['document_3'];
		$result['panel_make']=$smps_row['panel_make'];
		$result['panel_rating']=($smps_row['panel_rating']=='0' ? '0.0' : $smps_row['panel_rating']);
		$result['charge_controller_rate']=($smps_row['charge_controller_rate']=='0' ? '0.0' : $smps_row['charge_controller_rate']);
		$result['no_solar_panels']=$smps_row['no_solar_panels'];
		$result['document_4']=$smps_row['document_4'];
		$result['single_panel_rating']=$smps_row['single_panel_rating'];
		$result['document_5']=$smps_row['document_5'];
		$result['panel_manufacturing_date']=dateFormat($smps_row['panel_manufacturing_date'],"d");
		$result['panel_installation_date']=dateFormat($smps_row['panel_installation_date'],"d");
	}
	//General Observation
	$general_sql=mysqli_query($mr_con,"SELECT * FROM ec_general_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($general_sql)){ $general_row=mysqli_fetch_array($general_sql);
		$result['dg_status']=$general_row['dg_status'];
		$result['dg_make']=$general_row['dg_make'];
		$result['dg_capacity']=$general_row['dg_capacity'];
		$result['dg_working_condition']=$general_row['dg_working_condition'];
		$result['dg_pic']=$general_row['dg_pic'];
		$result['avg_dg_run']=$general_row['avg_dg_run'];
		$result['site_load']=$general_row['site_load'];
	}
	//Power(EB) Observations
	$power_sql=mysqli_query($mr_con,"SELECT * FROM ec_power_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($power_sql)){ $power_row=mysqli_fetch_array($power_sql);
		$result['eb_supply']=$power_row['eb_supply'];
		$result['failures_per_day']=$power_row['failures_per_day'];
		$result['avg_power_cut']=$power_row['avg_power_cut'];
	}
	//Service Engineer Observation
	$service_sql=mysqli_query($mr_con,"SELECT * FROM ec_engineer_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($service_sql)){ $service_row=mysqli_fetch_array($service_sql);
		$result['req_acc']=$service_row['req_acc'];
		$result['req_cells']=$service_row['req_cells'];
		$result['faulty_code']=alias($service_row['faulty_code_alias'],'ec_faulty_code','faulty_alias','description');
		$result['faulty_cell_sr_no']=$service_row['faulty_cell_sr_no'];
		$result['job_performed']=$service_row['job_performed'];
	
	//Replaced cells
		//$uu=""; 
		//$rep_arr = explode(", ",$service_row['replaced_cell_no']);
		//foreach($rep_arr as $rr){$uu .= alias($rr,'ec_item_code','item_code_alias','item_description').",";}
		$result['requested_cells']=$service_row['replaced_cell_no'];
		
		$service_rem=mysqli_query($mr_con,"SELECT remarks FROM ec_remarks WHERE item_alias='$ticket_alias' AND remarked_by='".$row['service_engineer_alias']."' AND module='TT' AND flag=0");
		if(mysqli_num_rows($service_rem)){ $service_rem_row=mysqli_fetch_array($service_rem);
			$result['remarks']=$service_rem_row['remarks'];
		}else{$result['remarks']='';}
		$result['observation']=alias($ticket_alias,'ec_ticket_action','ticket_alias','observation');
	}
//Battery pdf
$bank_img=$battery_obs=$bank_rating=$bank_capacity=array();
$header_o=$tVoltage_o=$temp_o=$cCurrent_o=array('');
$header_a=$tVoltage_a=$temp_a=$cCurrent_a=array();
$header_b=$tVoltage_b=$temp_b=$cCurrent_b=array();
$header_c=$tVoltage_c=$temp_c=$cCurrent_c=array();
$query_bb=mysqli_query($mr_con,"SELECT battery_bank_rating, bb_capacity, item_alias FROM ec_battery_bank_bb_cap WHERE ticket_alias='$ticket_alias' AND (image='0'||image='') AND flag=0");
if(mysqli_num_rows($query_bb)>0){$x=0;
	while($row_bb=mysqli_fetch_array($query_bb)){
		$bank_rating[$x]=$bb_rating;//$row_bb['battery_bank_rating'];
		$bank_capacity[$x]=$row_bb['bb_capacity'];
		$battery_obs[$x]=$row_bb['item_alias'];
	$x++;}
	for($x=0;$x<count($battery_obs);$x++){
		$query_header=mysqli_query($mr_con,"SELECT header, total_voltage, temperature, charging_current FROM ec_bo_headers WHERE type='ocv' AND item_alias='".$battery_obs[$x]."' AND flag=0 ORDER BY id ASC");
		if(mysqli_num_rows($query_header)>0){$x_x=0;
			while($row_header=mysqli_fetch_array($query_header)){
				//if($row_header['total_voltage']){
					$header_o[$x][$x_x]=$row_header['header'];
					$tVoltage_o[$x][$x_x]=$row_header['total_voltage'];
					$temp_o[$x][$x_x]=$row_header['temperature'];
					$cCurrent_o[$x][$x_x]=$row_header['charging_current'];
				//}
			$x_x++;}
		}
		$query_header=mysqli_query($mr_con,"SELECT header, total_voltage, temperature, charging_current FROM ec_bo_headers WHERE type='on_charge_voltage_1' AND item_alias='".$battery_obs[$x]."' AND flag=0 ORDER BY id ASC");
		if(mysqli_num_rows($query_header)>0){$x_x=0;
			while($row_header=mysqli_fetch_array($query_header)){
				$header_a[$x][$x_x]=$row_header['header'];
				$tVoltage_a[$x][$x_x]=$row_header['total_voltage'];
				$temp_a[$x][$x_x]=$row_header['temperature'];
				$cCurrent_a[$x][$x_x]=$row_header['charging_current'];
			$x_x++;}
		}
		$query_header=mysqli_query($mr_con,"SELECT header, total_voltage, temperature, charging_current, type FROM ec_bo_headers WHERE type='discharge_voltage' AND item_alias='".$battery_obs[$x]."' AND flag=0 ORDER BY id ASC");
		if(mysqli_num_rows($query_header)>0){$x_x=0;
			while($row_header=mysqli_fetch_array($query_header)){
				$header_b[$x][$x_x]=$row_header['header'];
				$tVoltage_b[$x][$x_x]=$row_header['total_voltage'];
				$temp_b[$x][$x_x]=$row_header['temperature'];
				$cCurrent_b[$x][$x_x]=$row_header['charging_current'];
			$x_x++;}
		}
		$query_header=mysqli_query($mr_con,"SELECT header, total_voltage, temperature, charging_current, type FROM ec_bo_headers WHERE type='on_charge_voltage_2' AND item_alias='".$battery_obs[$x]."' AND flag=0 ORDER BY id ASC");
		if(mysqli_num_rows($query_header)>0){$x_x=0;
			while($row_header=mysqli_fetch_array($query_header)){
				$header_c[$x][$x_x]=$row_header['header'];
				$tVoltage_c[$x][$x_x]=$row_header['total_voltage'];
				$temp_c[$x][$x_x]=$row_header['temperature'];
				$cCurrent_c[$x][$x_x]=$row_header['charging_current'];
			$x_x++;}
		}
		$query_body=mysqli_query($mr_con,"SELECT cell_sl_no, mf_date, ocv, acid_density, 1hr, 2hr, 3hr, 4hr, 5hr, 6hr, 7hr, 8hr, 9hr, 10hr, 11hr, 12hr, 13hr, 14hr, 15hr, 16hr, 17hr, 18hr, 19hr, 20hr, 21hr, 22hr, 23hr, 24hr, 25hr, 26hr, 27hr, 28hr, 29hr, 30hr, remarks FROM ec_bo_telecom_ic WHERE battery_bb_alias='".$battery_obs[$x]."' AND flag=0 ORDER BY id ASC");
		if(mysqli_num_rows($query_body)>0){$x_x=0;
			while($row_body=mysqli_fetch_array($query_body)){
				$cell_sl_no[$x][$x_x]=$row_body['cell_sl_no'];
				$mf_date[$x][$x_x]=$row_body['mf_date'];
				$ocv[$x][$x_x]=$row_body['ocv'];
				$acid_density[$x][$x_x]=$row_body['acid_density'];
					$qw=0;$qw1=0;$qw2=0;
				$battery_Volts[$x][$x_x][$qw]=$row_body['1hr'];$qw++;
				$battery_Volts[$x][$x_x][$qw]=$row_body['2hr'];$qw++;
				$battery_Volts[$x][$x_x][$qw]=$row_body['3hr'];$qw++;
				$battery_Volts[$x][$x_x][$qw]=$row_body['4hr'];$qw++;
				$battery_Volts[$x][$x_x][$qw]=$row_body['5hr'];$qw++;
				$battery_Volts[$x][$x_x][$qw]=$row_body['6hr'];$qw++;
				$battery_Volts[$x][$x_x][$qw]=$row_body['7hr'];$qw++;
				$battery_Volts[$x][$x_x][$qw]=$row_body['8hr'];$qw++;
				$battery_Volts[$x][$x_x][$qw]=$row_body['9hr'];$qw++;
				$battery_Volts[$x][$x_x][$qw]=$row_body['10hr'];$qw++;

				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['11hr'];$qw1++;
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['12hr'];$qw1++;
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['13hr'];$qw1++;
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['14hr'];$qw1++;
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['15hr'];$qw1++;
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['16hr'];$qw1++;
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['17hr'];$qw1++;
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['18hr'];$qw1++;
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['19hr'];$qw1++;
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['20hr'];$qw1++;
				
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['21hr'];$qw2++;
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['22hr'];$qw2++;
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['23hr'];$qw2++;
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['24hr'];$qw2++;
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['25hr'];$qw2++;
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['26hr'];$qw2++;
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['27hr'];$qw2++;
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['28hr'];$qw2++;
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['29hr'];$qw2++;
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['30hr'];$qw2++;
				$remarks[$x][$x_x]=$row_body['remarks'];
			$x_x++;}
		}

	}
}else{
	$query_bb=mysqli_query($mr_con,"SELECT image,image_2 FROM ec_battery_bank_bb_cap WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($query_bb)>0){$x=0;
		while($row_bb=mysqli_fetch_array($query_bb)){
			$bank_img_1[$x]=$row_bb['image'];
			$bank_img_2[$x]=$row_bb['image_2'];
		$x++;}
		$bank_img = array_filter(array_merge($bank_img_1,$bank_img_2));
	}
}
	//Customer details
	//e-signature
	$signature_sql=mysqli_query($mr_con,"SELECT * FROM ec_e_signature WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($signature_sql)){ $signature_row=mysqli_fetch_array($signature_sql);
	
		$result['e_sig_name']=$signature_row['name'];
		$result['e_sig_email']=$signature_row['email'];
		$result['e_sig_designation']=$signature_row['designation'];
		$result['e_sig_contact_number']=$signature_row['contact_number'];
		$result['e_sig_photo']=$signature_row['photo'];
		$result['e_sig_engineer_photo']=$signature_row['engineer_photo'];
		$result['e_sig_cust_sign']=$signature_row['e_signature'];
		$result['e_sig_engineer_sign']=$signature_row['engineer_sign'];
		$result['e_sig_customer_comments']=alias($ticket_alias,'ec_customer_comments','ticket_alias','customer_comments');
	}
	//Customer Satisfaction
	$satisfication_sql=mysqli_query($mr_con,"SELECT * FROM ec_customer_satisfaction WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($satisfication_sql)){ $satisfication_row=mysqli_fetch_array($satisfication_sql);
		$result['q1']=$satisfication_row['q1'];
		$result['q2']=$satisfication_row['q2'];
		$result['q3']=$satisfication_row['q3'];
		$result['q4']=$satisfication_row['q4'];
		$result['q5']=$satisfication_row['q5'];
	}
//print_r($result);
//echo $res;
function alias($alias,$tb,$col,$retrive){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT $retrive FROM $tb WHERE $col='$alias' AND flag=0");
	if(mysqli_num_rows($sql)){
		$row = mysqli_fetch_array($sql);
		return $row[$retrive];
	}else return "";
}
function coll($fv1){
	if($fv1>1) return 'colspan="'.$fv1.'"';
}
function dateFormat($date,$x){ global $mr_con;
	if(preg_match("/\d{4}\-\d{2}-\d{2}/", $date) || preg_match("/\d{2}\-\d{2}-\d{4}/", $date)){
		if($date=='0000-00-00' || $date=='00-00-0000'){ $y = 'NA';}
		else{ $y = date(($x=="d" ? "d-m-Y" : "Y-m-d"), strtotime(mysqli_real_escape_string($mr_con,$date)));}
		if(strpos($y,'1970')!==false){$y = 'NA';}
	}else{$y = 'NA';}
	return $y;
}
?>