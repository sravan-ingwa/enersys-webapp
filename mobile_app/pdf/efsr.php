<?php
include('../../services/mysql.php');
include('../../services/functions.php');
	set_time_limit(0);
	ini_set('memory_limit', '20000M');
	$ticket_alias=$_REQUEST['ticket_alias'];
	$ref=(isset($_REQUEST['ref']) ? true : false);
	$sql=mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE ticket_alias='$ticket_alias'");
	$row=mysqli_fetch_array($sql);
	$flag=$row['flag']; //2 OFFLINe(TT Avial), 1 SPOT(TT NOT Avail)
	$result['ticket_id']=$row['ticket_id'];
	$result['login_date']=dateFormat($row['login_date'],"d");
	$result['planned_date']=dateFormat($row['planned_date'],"d");
	$result['activation_date']=dateFormat($row['activation_date'],"d");
	$result['emp_name']=alias($row['service_engineer_alias'],'ec_employee_master','employee_alias','name');
	$result['emp_mobile_number']=alias($row['service_engineer_alias'],'ec_employee_master','employee_alias','mobile_number');
	$result['activity_code']=alias($row['activity_alias'],'ec_activity','activity_alias','activity_code');
	$result['complaint_name']=alias($row['complaint_alias'],'ec_complaint','complaint_alias','complaint_name');
	$result['description']=($flag!=2 ? $row['description'] : '');
	$result['mode_of_contact']=alias($row['mode_of_contact'],'ec_moc','moc_alias','moc_name');
	$result['efsr_no']=$row['efsr_no'];
	$result['efsr_start']=$row['efsr_start'];
	$result['efsr_date']=$row['efsr_date'];
	$result['faulty_cell_count']=($flag==0 ? $row['faulty_cell_count'] : '');
	$activity_alias=$row['activity_alias'];
	$activity_type=alias($activity_alias,'ec_activity','activity_alias','activity_type');
	if($activity_type!='1'){
		$result['service_po_number']=$row['po_number'];
		$result['service_po_date']=dateFormat($row['po_date'],"d");
		$result['service_po_link']=$row['po_link'];
	}
	$result['moc_num']=$row['moc_num'];
	$result['warranty']=($flag==0 ? ($row['warranty']==0 ? 'Out Of Warranty':'Under Warranty') : '');
	
	//$d_s=alias($row['activity_alias'],'ec_activity','activity_alias','activity_code');
	//$segment_code = alias(alias($row['site_alias'],'ec_sitemaster','site_alias','segment_alias'),'ec_segment','segment_alias','segment_code');
	//$filename = $row['ticket_id'];

	//Ticket Details
	$site_sql=mysqli_query($mr_con,"SELECT * FROM ec_sitemaster WHERE site_alias='".$row['site_alias']."'");
	$site_row=mysqli_fetch_array($site_sql);
	$segment_alias=$site_row['segment_alias'];
	if(empty($segment_alias))$segment_alias=$row['complaint_alias'];
	$result['segment_alias']=$segment_alias;
	$result['segment_name']=alias($segment_alias,'ec_segment','segment_alias','segment_name');
	$result['site_id']=$site_row['site_id'];
	$result['site_name']=($row['flag']==2 ? $row['description'] : $site_row['site_name']);
	$result['site_address']=$site_row['site_address'];
	$result['zone_name']=alias($site_row['zone_alias'],'ec_zone','zone_alias','zone_name');
	$result['state_name']=alias($site_row['state_alias'],'ec_state','state_alias','state_name');
	$result['district_name']=alias($site_row['district_alias'],'ec_district','district_alias','district_name');
	$result['mfd_date']=dateFormat($site_row['mfd_date'],"d");
	$result['install_date']=dateFormat($site_row['install_date'],"d");
	$result['sales_invoice_number']=$site_row['sale_invoice_num'];
	$result['sales_invoice_date']=dateFormat($site_row['sale_invoice_date'],"d");
	$result['sales_po_no']=$site_row['po_num'];
	$result['customer_name']=alias($site_row['customer_alias'],'ec_customer','customer_alias','customer_code');
	$result['technician_name']=$site_row['technician_name'];
	$result['technician_number']=$site_row['technician_number'];
	$result['no_of_string']=$site_row['no_of_string'];
	$result['site_type']=alias($site_row['site_type_alias'],'ec_site_type','site_type_alias','site_type');
	$result['product_description']=alias($site_row['product_alias'],'ec_product','product_alias','product_description');
	$bb_rating=$result['battery_bank_rating']=$site_row['battery_bank_rating'];
	$result['dispat']=alias($site_row['customer_alias'],'ec_customer','customer_alias','dispatch');
	$result['inst']=alias($site_row['customer_alias'],'ec_customer','customer_alias','installation');
	//Other Issues
	$other_sql=mysqli_query($mr_con,"SELECT * FROM ec_other_issues WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($other_sql)){
		$i=0;while($other_row=mysqli_fetch_array($other_sql)){
			if($other_row['module']!="SEOBS"){
				$result['module'][$other_row['module']][0]['other_id']=$other_row['id'];
				$result['module'][$other_row['module']][0]['other_issue']=$other_row['other_issue'];
				$result['module'][$other_row['module']][0]['other_image']=$other_row['other_image'];
			}else{
				$result['module'][$other_row['module']][$i]['other_id']=$other_row['id'];
				$result['module'][$other_row['module']][$i]['other_issue']=$other_row['other_issue'];
				$result['module'][$other_row['module']][$i]['other_image']=$other_row['other_image'];
				$i++;
			}
		}
	}
	
	//Invertor Details
	$invertor_sql=mysqli_query($mr_con,"SELECT * FROM ec_invertor_details WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($invertor_sql)){$invertor_row=mysqli_fetch_array($invertor_sql);
		$result['invertor_details_id']=$invertor_row['id'];
		$result['invertor_make']=$invertor_row['invertor_make'];
		$result['invertor_capacity']=$invertor_row['invertor_capacity'];
		$result['invertor_manu_date']=dateFormat($invertor_row['invertor_manu_date'],"d");
		$result['invertor_install_date']=dateFormat($invertor_row['invertor_install_date'],"d");
		$result['invertor_type']=$invertor_row['invertor_type'];
		$result['invertor_load_current']=$invertor_row['invertor_load_current'];
		$result['low_voltage_cutoff_inv']=$invertor_row['low_voltage_cutoff_inv'];
	}
	
	//Railway segment
	$coach_sql=mysqli_query($mr_con,"SELECT * FROM ec_coach_history WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($coach_sql)){$coach_row=mysqli_fetch_array($coach_sql);
		$result['coach_history_id']=$coach_row['id'];
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
		$result['equip_details_id']=$equip_row['id'];
		$result['altenate_make']=$equip_row['altenate_make'];
		$result['altenate_make_doc']=$equip_row['altenate_make_doc'];
		$result['altenate_belt_status']=$equip_row['altenate_belt_status'];
		$result['altenate_belt_doc']=$equip_row['altenate_belt_doc'];
		$result['rru_make']=$equip_row['rru_make'];
		$result['invertor_make']=$equip_row['invertor_make'];
		$result['voltage_regulation']=$equip_row['voltage_regulation'];
		$result['regulator_make']=$equip_row['regulator_make'];
		
		//New
		$result['invertor_make_doc']=$equip_row['invertor_make_doc'];
		$result['alternator_capacity']=$equip_row['alternator_capacity'];
		$result['current_limit']=$equip_row['current_limit'];
		$result['equip_charger_cut_off']=$equip_row['equip_charger_cut_off'];
		$result['high_voltage_cut_off']=$equip_row['high_voltage_cut_off'];
		$result['invertor_mode']=$equip_row['invertor_mode'];
		$result['low_voltage_cut_off']=$equip_row['low_voltage_cut_off'];
	}
	//Check Points
	$check_points_sql=mysqli_query($mr_con,"SELECT * FROM ec_check_points WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($check_points_sql)){ $check_points_row=mysqli_fetch_array($check_points_sql);
		$result['check_points_id']=$check_points_row['id'];
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
		
		//New
		$result['terminal_temp']=$check_points_row['terminal_temp'];
		$result['any_leakage']=$check_points_row['leakage'];
		$result['valuephysicalcondition']=$check_points_row['physical_condition'];
		$result['valueleakagecondition']=$check_points_row['leakage_condition'];
		$result['leakage_image_pic']=$check_points_row['leakage_image_pic'];
	}
	//Motive Power
	//Charger Details
	$charger_sql=mysqli_query($mr_con,"SELECT * FROM ec_charger_details WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($charger_sql)){ $charger_row=mysqli_fetch_array($charger_sql);
		$result['charger_details_id']=$charger_row['id'];
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
		
		//New
		$result['charger_capacity']=$charger_row['charger_capacity'];
		$result['charger_input']=$charger_row['charger_input'];
		$result['equalize_charger_mode']=$charger_row['equalize_charger_mode'];
		$result['valueofequalize']=$charger_row['valueofequalize'];
		
	}
	//Fork Lift 
	$forklift_sql=mysqli_query($mr_con,"SELECT * FROM ec_fork_lift WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($forklift_sql)){ $forklift_row=mysqli_fetch_array($forklift_sql);
		$result['fork_lift_id']=$forklift_row['id'];
		$result['fork_lift_brand']=$forklift_row['fork_lift_brand'];
		$result['fork_lift_pic']=$forklift_row['fork_lift_pic'];
		$result['fork_lift_model']=$forklift_row['fork_lift_model'];
		$result['fork_lift_manf_date']=dateFormat($forklift_row['fork_lift_manf_date'],"d");
		
		//New
		$result['forklift_install_date']=dateFormat($forklift_row['forklift_install_date'],"d");
		$result['forlift_capacity']=$forklift_row['forlift_capacity'];
		$result['motor_capacity']=$forklift_row['motor_capacity'];
		$result['under_voltage_cutoff']=$forklift_row['under_voltage_cutoff'];
		$result['max_load_current']=$forklift_row['max_load_current'];
	}
	//Battery Details
	$battey_sql=mysqli_query($mr_con,"SELECT * FROM ec_battery_details WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($battey_sql)){ $battey_row=mysqli_fetch_array($battey_sql);
		$result['battery_details_id']=$battey_row['id'];
		$result['battey_type']=$battey_row['battey_type'];
		$result['bank_serial_no']=$battey_row['bank_serial_no'];
		$result['battey_manf_date']=dateFormat($battey_row['manf_date'],"d");
		$result['battey_ins_date']=dateFormat($battey_row['ins_date'],"d");
		$result['plug_type']=$battey_row['plug_type'];
		$result['acid_level']=$battey_row['acid_level'];
	}
	//General Observation
	$general_sql=mysqli_query($mr_con,"SELECT * FROM ec_general_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($general_sql)){ $general_row=mysqli_fetch_array($general_sql);
		$result['general_obs_id']=$general_row['id'];
		$result['dg_status']=$general_row['dg_status'];
		$result['dg_make']=$general_row['dg_make'];
		$result['dg_capacity']=$general_row['dg_capacity'];
		$result['dg_working_condition']=$general_row['dg_working_condition'];
		$result['dg_pic']=$general_row['dg_pic'];
		$result['avg_dg_run']=$general_row['avg_dg_run'];
		$result['site_load']=$general_row['site_load'];
		//new
		$result['dg_output']=$general_row['dg_output'];
	}
	//Power(EB) Observations
	$power_sql=mysqli_query($mr_con,"SELECT * FROM ec_power_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($power_sql)){ $power_row=mysqli_fetch_array($power_sql);
		$result['power_obs_id']=$power_row['id'];
		$result['eb_supply']=$power_row['eb_supply'];
		$result['failures_per_day']=$power_row['failures_per_day'];
		$result['avg_power_cut']=$power_row['avg_power_cut'];
		//new
		$result['ebinstalldate']=dateFormat($power_row['ebinstalldate'],"d");
	}
	//SMPS Observation
 	// Solar Telecom Solar Condition
/*if(($segment_alias!="KWJCZKSTBL" && $segment_alias!="DDEYO7NTTC") || (($segment_alias=="KWJCZKSTBL" || $segment_alias=="DDEYO7NTTC") && $result['dg_status']!='AVAILABLE' && strpos($result['eb_supply'],'YES')===false)){
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
		$result['panel_rating']=$smps_row['panel_rating'];
		$result['charge_controller_rate']=$smps_row['charge_controller_rate'];
		$result['no_solar_panels']=$smps_row['no_solar_panels'];
		$result['document_4']=$smps_row['document_4'];
		$result['single_panel_rating']=$smps_row['single_panel_rating'];
		$result['document_5']=$smps_row['document_5'];
		$result['panel_manufacturing_date']=dateFormat($smps_row['panel_manufacturing_date'],"d");
		$result['panel_installation_date']=dateFormat($smps_row['panel_installation_date'],"d");
								   
		$result['charge_controller_make']=$smps_row['charge_controller_make'];
		$result['charge_control_manufacturing_date']=dateFormat($smps_row['charge_control_manufacturing_date'],"d");

		//New
		$result['solar_system_rating']=$smps_row['solar_system_rating'];
		$result['single_module_rating']=$smps_row['single_module_rating'];
		$result['single_pv_moddule_rating_current']=$smps_row['single_pv_moddule_rating_current'];
		$result['pv_module_eff']=$smps_row['pv_module_eff'];
		$result['site_load']=$smps_row['site_load'];
		$result['auto_boost']=$smps_row['auto_boost'];
		$result['temp_compensation']=$smps_row['temp_compensation'];
	}
}else{*/
	$smps_sql=mysqli_query($mr_con,"SELECT * FROM ec_technical_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($smps_sql)){
		$i=0;while($smps_row=mysqli_fetch_array($smps_sql)){
			
			if(($segment_alias!="KWJCZKSTBL" && $segment_alias!="DDEYO7NTTC") || empty($smps_row['auto_boost']))$seg=$segment_alias;
			else { $seg=(empty($smps_row['site_load']) ? 'SMEY7SL24I' : 'HXL5A1HOTZ');} //UP TL
			
			$result['technical_obs'][$i]['smps_label']= smpslabel($seg);
			$result['technical_obs'][$i]['smps_heading']= smpsheading($seg);
			$result['technical_obs'][$i]['technical_obs_id']=$smps_row['id'];
			$result['technical_obs'][$i]['float_voltage']=$smps_row['float_voltage'];
			$result['technical_obs'][$i]['float_voltage_image']=$smps_row['document_1'];
			$result['technical_obs'][$i]['boast_voltage']=$smps_row['boast_voltage'];
			$result['technical_obs'][$i]['boast_voltage_image']=$smps_row['document_2'];
			$result['technical_obs'][$i]['current_limit']=$smps_row['current_limit'];
			$result['technical_obs'][$i]['voltage_ripple']=$smps_row['voltage_ripple'];
			$result['technical_obs'][$i]['high_voltage_cutoff']=$smps_row['high_voltage_cutoff'];
			$result['technical_obs'][$i]['low_voltage_cutoff']=$smps_row['low_voltage_cutoff'];
			$result['technical_obs'][$i]['voltage_regulation']=$smps_row['voltage_regulation'];
			$result['technical_obs'][$i]['document_3']=$smps_row['document_3'];
			$result['technical_obs'][$i]['panel_make']=$smps_row['panel_make'];
			$result['technical_obs'][$i]['panel_rating']=$smps_row['panel_rating'];
			$result['technical_obs'][$i]['charge_controller_rate']=$smps_row['charge_controller_rate'];
			$result['technical_obs'][$i]['no_solar_panels']=$smps_row['no_solar_panels'];
			$result['technical_obs'][$i]['document_4']=$smps_row['document_4'];
			$result['technical_obs'][$i]['single_panel_rating']=$smps_row['single_panel_rating'];
			$result['technical_obs'][$i]['document_5']=$smps_row['document_5'];
			$result['technical_obs'][$i]['panel_manufacturing_date']=dateFormat($smps_row['panel_manufacturing_date'],"d");
			$result['technical_obs'][$i]['panel_installation_date']=dateFormat($smps_row['panel_installation_date'],"d");

			$result['technical_obs'][$i]['charge_controller_make']=$smps_row['charge_controller_make'];
			$result['technical_obs'][$i]['charge_control_manufacturing_date']=dateFormat($smps_row['charge_control_manufacturing_date'],"d");

			//New
			$result['technical_obs'][$i]['solar_system_rating']=$smps_row['solar_system_rating'];
			$result['technical_obs'][$i]['single_module_rating']=$smps_row['single_module_rating'];
			$result['technical_obs'][$i]['single_pv_moddule_rating_current']=$smps_row['single_pv_moddule_rating_current'];
			$result['technical_obs'][$i]['pv_module_eff']=$smps_row['pv_module_eff'];
			$result['technical_obs'][$i]['site_load']=$smps_row['site_load'];
			$result['technical_obs'][$i]['auto_boost']=$smps_row['auto_boost'];
			$result['technical_obs'][$i]['temp_compensation']=$smps_row['temp_compensation'];
			$result['technical_obs'][$i]['site_input']=site_input_segment($smps_row['site_input']);
		$i++;}
	}
//}
	//Physical Observation
	$no_of_banks=mysqli_query($mr_con,"SELECT * FROM ec_no_of_banks WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($no_of_banks)>0){
		$i=0;while($no_of_rows=mysqli_fetch_array($no_of_banks)){
			$result['no_of_banks_id'][$i]=$no_of_rows['id'];
			$result['no_of_banks']=$no_of_rows['bank_size'];
			$result['mfdt_date'][$i]=dateFormat($no_of_rows['mfg_date'],"d");//$no_of_rows['mfg_date'];	
			$result['installdt_date'][$i]=dateFormat($no_of_rows['install_date'],"d");//$no_of_rows['install_date'];
			$result['bb_make'][$i]=$no_of_rows['bb_make'];
			$result['bb_capacity'][$i]=$no_of_rows['bb_capacity'];
		$i++;}
	}
	$physical_sql=mysqli_query($mr_con,"SELECT * FROM ec_physical_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($physical_sql)){ $physical_row=mysqli_fetch_array($physical_sql);
		$result['physical_obs_id']=$physical_row['id'];
		$result['physical_damages']=$physical_row['physical_damages'];
		$result['physical_damages_document']=$physical_row['physical_damages_document'];
		$result['leakage']=$physical_row['leakage'];
		$result['leakage_document']=$physical_row['leakage_document'];
		list($temp_type,$temp,$amb_temp) = explode("|",$physical_row['temperature']);
		$result['temperature_type']=$temp_type;
		$result['temp_data']=$physical_row['temp_data'];
		$result['temperature']=$temp;
		$result['ambient_temperature']=$amb_temp;
		$result['acid_temp_discharge']=$physical_row['acid_temp_discharge'];
		$result['acid_temp_charge']=$physical_row['acid_temp_charge'];
		$result['cells_temp_after_use']=$physical_row['cells_temp_after_use'];
		$result['cells_temp_at_charge']=$physical_row['cells_temp_at_charge'];
		$result['general_observation']=$physical_row['general_observation'];
		$result['temp_vent_plug_thickness']=$physical_row['vent_plug_thickness'];
		list($vent_type,$vent_loose,$vent_perfect) = explode("|",$physical_row['vent_plug_thickness']);
		$result['vent_plug_type']=($vent_type=="PERFECT" ? $vent_type : $vent_type." : ".$vent_loose.", PERFECT : ".$vent_perfect);
		$result['temp_terminal_torque']=$physical_row['terminal_torque'];
		list($torque,$torque_loose,$torque_perfect) = explode("|",$physical_row['terminal_torque']);
		$result['terminal_torque']=($torque=="PERFECT" ? $torque : $torque." : ".$torque_loose.", PERFECT : ".$torque_perfect);
		//$result['terminal_torque']=($torque[0]=="PERFECT" ? $torque[0]." : ".$torque[1] :'');
		//$result['terminal_torquelse']=($torque[0]="LOOSE" ? $torque[0]." : ".$torque[1] :'');
		//New
		$result['battery_top']=$physical_row['battery_top'];
		$result['battery_top_image']=$physical_row['battery_top_image'];
		$result['bb_condition']=$physical_row['bb_condition'];

		$result['electrolyte_temp_before']=$physical_row['electrolyte_temp_before'];
		list($bfr_rest,$bfr_hr)=explode("|",$physical_row['electrolyte_temp_before_restperiod']);
		$result['electrolyte_temp_before_restperiod']=$bfr_rest;
		$result['electrolyte_temp_before_hr']=$bfr_hr;
		
		$result['electrolyte_temp_after']=$physical_row['electrolyte_temp_after'];
		list($aftr_rest,$aftr_hr)=explode("|",$physical_row['electrolyte_temp_after_restperiod']);
		$result['electrolyte_temp_after_restperiod']=$aftr_rest;
		$result['electrolyte_temp_after_hr']=$aftr_hr;
		
		$result['dm_water_filling_type']=$physical_row['dm_water_filling_type'];
		$result['log_book']=$physical_row['log_book'];
		$result['log_image']=$physical_row['log_image'];
		
		$result['cleanness']=$physical_row['cleanness'];
		list($dg_sta,$eb_sta)=explode("|",$physical_row['dg_eb_status']);
		$result['dg_sta']=$dg_sta;
		$result['eb_sta']=$eb_sta;
		$result['site_input']=($segment_alias=="W0PBT7IAZE" ? site_input_segment(alias($ticket_alias,'ec_technical_observation','ticket_alias','site_input')) : '');
		
	}
	//Service Engineer Observation
	$service_sql=mysqli_query($mr_con,"SELECT * FROM ec_engineer_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
	if(mysqli_num_rows($service_sql)){ $service_row=mysqli_fetch_array($service_sql);
		$result['engineer_obs_id']=$service_row['id'];
		$result['req_acc']=$service_row['req_acc'];
		$result['req_cells']=$service_row['req_cells'];
		$result['faulty_code']=alias($service_row['faulty_code_alias'],'ec_faulty_code','faulty_alias','description');
		$result['faulty_cell_sr_no']=$service_row['faulty_cell_sr_no'];
		$result['job_performed']=$service_row['job_performed'];
		
		//Replaced cells
		$result['requested_cells']=$service_row['replaced_cell_no'];
		$service_rem=mysqli_query($mr_con,"SELECT id, remarks FROM ec_remarks WHERE item_alias='$ticket_alias' AND remarked_by='".$row['service_engineer_alias']."' AND module='TT' AND bucket='8' AND flag=0");
		if(mysqli_num_rows($service_rem)){ $service_rem_row=mysqli_fetch_array($service_rem);
			$result['remarks_id']=$service_rem_row['id'];
			$result['remarks']=$service_rem_row['remarks'];
		}else{$result['remarks']='';}
		$result['observation']=alias($ticket_alias,'ec_ticket_action','ticket_alias','observation');
	}
$motiv_seg=($segment_alias=="YGRKJJD4N7" ? TRUE : FALSE);
//Battery pdf
$bank_img=$battery_obs=$bank_rating=$bank_capacity=$bank_id=array();
$header_o=$tVoltage_o=$temp_o=$cCurrent_o=$charge_o=$header_o_id=array('');
$header_a=$tVoltage_a=$temp_a=$cCurrent_a=$charge_a=$header_a_id=array();
$header_b=$tVoltage_b=$temp_b=$cCurrent_b=$charge_b=$header_b_id=array();
$header_c=$tVoltage_c=$temp_c=$cCurrent_c=$charge_c=$header_c_id=array();
$query_bb=mysqli_query($mr_con,"SELECT id,battery_bank_rating, bb_capacity, item_alias, bb_condition FROM ec_battery_bank_bb_cap WHERE ticket_alias='$ticket_alias' AND (image='0'||image='') AND flag=0");
if(mysqli_num_rows($query_bb)>0){$x=0;
	while($row_bb=mysqli_fetch_array($query_bb)){
		$bank_rating[$x]=$bb_rating;//$row_bb['battery_bank_rating'];
		$bank_id[$x]=$row_bb['id'];
		$bank_capacity[$x]=$row_bb['bb_capacity'];
		$battery_obs[$x]=$row_bb['item_alias'];
		$bbcondition[$x]=$row_bb['bb_condition'];
	$x++;}
	for($x=0;$x<count($battery_obs);$x++){
		$query_header=mysqli_query($mr_con,"SELECT id, header, total_voltage, temperature, charging_current, smps_charge_voltage, bb_terminal_voltage FROM ec_bo_headers WHERE type='ocv' AND item_alias='".$battery_obs[$x]."' AND flag=0 ORDER BY id ASC");
		if(mysqli_num_rows($query_header)>0){$x_x=0;
			while($row_header=mysqli_fetch_array($query_header)){
				//if($row_header['total_voltage']){
					$header_o_id[$x][$x_x]=$row_header['id'];
					$header_o[$x][$x_x]=$row_header['header'];
					$tVoltage_o[$x][$x_x]=$row_header['total_voltage'];
					$temp_o[$x][$x_x]=($motiv_seg && strpos($row_header['temperature'],"|")!==false ? explode("|",$row_header['temperature']) : $row_header['temperature']);
					$cCurrent_o[$x][$x_x]=$row_header['charging_current'];
					$charge_o[$x][$x_x]=$row_header['smps_charge_voltage'];
					$bb_ter_o[$x][$x_x]=$row_header['bb_terminal_voltage'];
				//}
				$x_x++;
			}
		}
		$query_header=mysqli_query($mr_con,"SELECT id, header, total_voltage, temperature, charging_current, smps_charge_voltage, bb_terminal_voltage FROM ec_bo_headers WHERE type='on_charge_voltage_1' AND item_alias='".$battery_obs[$x]."' AND flag=0 ORDER BY id ASC");
		if(mysqli_num_rows($query_header)>0){$x_x=0;
			while($row_header=mysqli_fetch_array($query_header)){
				$header_a_id[$x][$x_x]=$row_header['id'];
				$header_a[$x][$x_x]=$row_header['header'];
				$tVoltage_a[$x][$x_x]=$row_header['total_voltage'];
				$temp_a[$x][$x_x]=($motiv_seg && strpos($row_header['temperature'],"|")!==false ? explode("|",$row_header['temperature']) : $row_header['temperature']);
				$cCurrent_a[$x][$x_x]=$row_header['charging_current'];
				$charge_a[$x][$x_x]=$row_header['smps_charge_voltage'];
				$bb_ter_a[$x][$x_x]=$row_header['bb_terminal_voltage'];$x_x++;
			}
		}
		$query_header=mysqli_query($mr_con,"SELECT id, header, total_voltage, temperature, charging_current, smps_charge_voltage, bb_terminal_voltage FROM ec_bo_headers WHERE type='discharge_voltage' AND item_alias='".$battery_obs[$x]."' AND flag=0 ORDER BY id ASC");
		if(mysqli_num_rows($query_header)>0){$x_x=0;
			while($row_header=mysqli_fetch_array($query_header)){
				$header_b_id[$x][$x_x]=$row_header['id'];
				$header_b[$x][$x_x]=$row_header['header'];
				$tVoltage_b[$x][$x_x]=$row_header['total_voltage'];
				$temp_b[$x][$x_x]=($motiv_seg && strpos($row_header['temperature'],"|")!==false ? explode("|",$row_header['temperature']) : $row_header['temperature']);
				$cCurrent_b[$x][$x_x]=$row_header['charging_current'];
				$charge_b[$x][$x_x]=$row_header['smps_charge_voltage'];
				$bb_ter_b[$x][$x_x]=$row_header['bb_terminal_voltage'];$x_x++;
			}
		}
		$query_header=mysqli_query($mr_con,"SELECT id, header, total_voltage, temperature, charging_current, smps_charge_voltage, bb_terminal_voltage FROM ec_bo_headers WHERE type='on_charge_voltage_2' AND item_alias='".$battery_obs[$x]."' AND flag=0 ORDER BY id ASC");
		if(mysqli_num_rows($query_header)>0){$x_x=0;
			while($row_header=mysqli_fetch_array($query_header)){
				$header_c_id[$x][$x_x]=$row_header['id'];
				$header_c[$x][$x_x]=$row_header['header'];
				$tVoltage_c[$x][$x_x]=$row_header['total_voltage'];
				$temp_c[$x][$x_x]=($motiv_seg && strpos($row_header['temperature'],"|")!==false ? explode("|",$row_header['temperature']) : $row_header['temperature']);
				$cCurrent_c[$x][$x_x]=$row_header['charging_current'];
				$charge_c[$x][$x_x]=$row_header['smps_charge_voltage'];
				$bb_ter_c[$x][$x_x]=$row_header['bb_terminal_voltage'];$x_x++;
			}
		}
		$query_body=mysqli_query($mr_con,"SELECT t1.id AS tele_id,t2.id AS motive_id,t1.*,t2.* FROM ec_bo_telecom_ic t1 LEFT JOIN ec_bo_motive_ic t2 ON t1.item_alias=t2.bo_telecome_alias WHERE t1.battery_bb_alias='".$battery_obs[$x]."' AND t1.flag=0 ORDER BY t1.id ASC");
		if(mysqli_num_rows($query_body)>0){$x_x=0;
			while($row_body=mysqli_fetch_array($query_body)){
				$telecom_id[$x][$x_x]=$row_body['tele_id'];
				$motive_id[$x][$x_x]=$row_body['motive_id'];
				$cell_sl_no[$x][$x_x]=$row_body['cell_sl_no'];
				$mf_date[$x][$x_x]=$row_body['mf_date'];
				$ocv[$x][$x_x]=$row_body['ocv'];
				if($motiv_seg)$sg_ocv[$x][$x_x]=$row_body['sg_ocv'];
				$qw=$qw1=$qw2=0;
				$battery_Volts[$x][$x_x][$qw]=$row_body['1hr'];$qw++;
				if($motiv_seg){$battery_Volts[$x][$x_x][$qw]=$row_body['sg_1hr'];$qw++;}
				$battery_Volts[$x][$x_x][$qw]=$row_body['2hr'];$qw++;
				if($motiv_seg){$battery_Volts[$x][$x_x][$qw]=$row_body['sg_2hr'];$qw++;}
				$battery_Volts[$x][$x_x][$qw]=$row_body['3hr'];$qw++;
				if($motiv_seg){$battery_Volts[$x][$x_x][$qw]=$row_body['sg_3hr'];$qw++;}
				$battery_Volts[$x][$x_x][$qw]=$row_body['4hr'];$qw++;
				if($motiv_seg){$battery_Volts[$x][$x_x][$qw]=$row_body['sg_4hr'];$qw++;}
				$battery_Volts[$x][$x_x][$qw]=$row_body['5hr'];$qw++;
				if($motiv_seg){$battery_Volts[$x][$x_x][$qw]=$row_body['sg_5hr'];$qw++;}
				$battery_Volts[$x][$x_x][$qw]=$row_body['6hr'];$qw++;
				if($motiv_seg){$battery_Volts[$x][$x_x][$qw]=$row_body['sg_6hr'];$qw++;}
				$battery_Volts[$x][$x_x][$qw]=$row_body['7hr'];$qw++;
				if($motiv_seg){$battery_Volts[$x][$x_x][$qw]=$row_body['sg_7hr'];$qw++;}
				$battery_Volts[$x][$x_x][$qw]=$row_body['8hr'];$qw++;
				if($motiv_seg){$battery_Volts[$x][$x_x][$qw]=$row_body['sg_8hr'];$qw++;}
				$battery_Volts[$x][$x_x][$qw]=$row_body['9hr'];$qw++;
				if($motiv_seg){$battery_Volts[$x][$x_x][$qw]=$row_body['sg_9hr'];$qw++;}
				$battery_Volts[$x][$x_x][$qw]=$row_body['10hr'];$qw++;
				if($motiv_seg){$battery_Volts[$x][$x_x][$qw]=$row_body['sg_10hr'];$qw++;}
				$battery_Volts[$x][$x_x][$qw]=$row_body['10a_hr'];$qw++;
				if($motiv_seg){$battery_Volts[$x][$x_x][$qw]=$row_body['sg_10a_hr'];$qw++;}
				$battery_Volts[$x][$x_x][$qw]=$row_body['10b_hr'];$qw++;
				if($motiv_seg){$battery_Volts[$x][$x_x][$qw]=$row_body['sg_10b_hr'];$qw++;}
				$battery_Volts[$x][$x_x][$qw]=$row_body['10c_hr'];$qw++;
				if($motiv_seg){$battery_Volts[$x][$x_x][$qw]=$row_body['sg_10c_hr'];$qw++;}
				$battery_Volts[$x][$x_x][$qw]=$row_body['10d_hr'];$qw++;
				if($motiv_seg){$battery_Volts[$x][$x_x][$qw]=$row_body['sg_10d_hr'];$qw++;}
				$battery_Volts[$x][$x_x][$qw]=$row_body['10e_hr'];$qw++;
				if($motiv_seg){$battery_Volts[$x][$x_x][$qw]=$row_body['sg_10e_hr'];$qw++;}

				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['11hr'];$qw1++;
				if($motiv_seg){$battery_Volts_a[$x][$x_x][$qw1]=$row_body['sg_11hr'];$qw1++;}
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['12hr'];$qw1++;
				if($motiv_seg){$battery_Volts_a[$x][$x_x][$qw1]=$row_body['sg_12hr'];$qw1++;}
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['13hr'];$qw1++;
				if($motiv_seg){$battery_Volts_a[$x][$x_x][$qw1]=$row_body['sg_13hr'];$qw1++;}
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['14hr'];$qw1++;
				if($motiv_seg){$battery_Volts_a[$x][$x_x][$qw1]=$row_body['sg_14hr'];$qw1++;}
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['15hr'];$qw1++;
				if($motiv_seg){$battery_Volts_a[$x][$x_x][$qw1]=$row_body['sg_15hr'];$qw1++;}
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['16hr'];$qw1++;
				if($motiv_seg){$battery_Volts_a[$x][$x_x][$qw1]=$row_body['sg_16hr'];$qw1++;}
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['17hr'];$qw1++;
				if($motiv_seg){$battery_Volts_a[$x][$x_x][$qw1]=$row_body['sg_17hr'];$qw1++;}
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['18hr'];$qw1++;
				if($motiv_seg){$battery_Volts_a[$x][$x_x][$qw1]=$row_body['sg_18hr'];$qw1++;}
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['19hr'];$qw1++;
				if($motiv_seg){$battery_Volts_a[$x][$x_x][$qw1]=$row_body['sg_19hr'];$qw1++;}
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['20hr'];$qw1++;
				if($motiv_seg){$battery_Volts_a[$x][$x_x][$qw1]=$row_body['sg_20hr'];$qw1++;}
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['20a_hr'];$qw1++;
				if($motiv_seg){$battery_Volts_a[$x][$x_x][$qw1]=$row_body['sg_20a_hr'];$qw1++;}
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['20b_hr'];$qw1++;
				if($motiv_seg){$battery_Volts_a[$x][$x_x][$qw1]=$row_body['sg_20b_hr'];$qw1++;}
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['20c_hr'];$qw1++;
				if($motiv_seg){$battery_Volts_a[$x][$x_x][$qw1]=$row_body['sg_20c_hr'];$qw1++;}
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['20d_hr'];$qw1++;
				if($motiv_seg){$battery_Volts_a[$x][$x_x][$qw1]=$row_body['sg_20d_hr'];$qw1++;}
				$battery_Volts_a[$x][$x_x][$qw1]=$row_body['20e_hr'];$qw1++;
				if($motiv_seg){$battery_Volts_a[$x][$x_x][$qw1]=$row_body['sg_20e_hr'];$qw1++;}
				
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['21hr'];$qw2++;
				if($motiv_seg){$battery_Volts_b[$x][$x_x][$qw2]=$row_body['sg_21hr'];$qw2++;}
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['22hr'];$qw2++;
				if($motiv_seg){$battery_Volts_b[$x][$x_x][$qw2]=$row_body['sg_22hr'];$qw2++;}
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['23hr'];$qw2++;
				if($motiv_seg){$battery_Volts_b[$x][$x_x][$qw2]=$row_body['sg_23hr'];$qw2++;}
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['24hr'];$qw2++;
				if($motiv_seg){$battery_Volts_b[$x][$x_x][$qw2]=$row_body['sg_24hr'];$qw2++;}
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['25hr'];$qw2++;
				if($motiv_seg){$battery_Volts_b[$x][$x_x][$qw2]=$row_body['sg_25hr'];$qw2++;}
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['26hr'];$qw2++;
				if($motiv_seg){$battery_Volts_b[$x][$x_x][$qw2]=$row_body['sg_26hr'];$qw2++;}
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['27hr'];$qw2++;
				if($motiv_seg){$battery_Volts_b[$x][$x_x][$qw2]=$row_body['sg_27hr'];$qw2++;}
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['28hr'];$qw2++;
				if($motiv_seg){$battery_Volts_b[$x][$x_x][$qw2]=$row_body['sg_28hr'];$qw2++;}
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['29hr'];$qw2++;
				if($motiv_seg){$battery_Volts_b[$x][$x_x][$qw2]=$row_body['sg_29hr'];$qw2++;}
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['30hr'];$qw2++;
				if($motiv_seg){$battery_Volts_b[$x][$x_x][$qw2]=$row_body['sg_30hr'];$qw2++;}
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['30a_hr'];$qw2++;
				if($motiv_seg){$battery_Volts_b[$x][$x_x][$qw2]=$row_body['sg_30a_hr'];$qw2++;}
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['30b_hr'];$qw2++;
				if($motiv_seg){$battery_Volts_b[$x][$x_x][$qw2]=$row_body['sg_30b_hr'];$qw2++;}
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['30c_hr'];$qw2++;
				if($motiv_seg){$battery_Volts_b[$x][$x_x][$qw2]=$row_body['sg_30c_hr'];$qw2++;}
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['30d_hr'];$qw2++;
				if($motiv_seg){$battery_Volts_b[$x][$x_x][$qw2]=$row_body['sg_30d_hr'];$qw2++;}
				$battery_Volts_b[$x][$x_x][$qw2]=$row_body['30e_hr'];$qw2++;
				if($motiv_seg){$battery_Volts_b[$x][$x_x][$qw2]=$row_body['sg_30e_hr'];$qw2++;}
				
				$remarks[$x][$x_x]=trim($row_body['remarks']);
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
		$result['e_sig_id']=$signature_row['id'];
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
		$result['customer_satis_id']=$satisfication_row['id'];
		$result['q1']=$satisfication_row['q1'];
		$result['q2']=$satisfication_row['q2'];
		$result['q3']=$satisfication_row['q3'];
		$result['q4']=$satisfication_row['q4'];
		$result['q5']=$satisfication_row['q5'];
	}
//print_r($result);
//echo $res;
if($ref){
	switch($segment_alias){
		case 'HXL5A1HOTZ': $segment_ref = "TL"; break;
		case 'YGRKJJD4N7': $segment_ref = "MP"; break;
		case 'TQMBDTF5ZI': $segment_ref = "RL"; break;
		case 'W0PBT7IAZE': $segment_ref = "PC"; break;
		case 'KWJCZKSTBL': $segment_ref = "SA"; break;
		case 'DDEYO7NTTC': $segment_ref = "TS"; break;
		case 'SMEY7SL24I': $segment_ref = "UP"; break;
		default : $segment_ref = "OT";
	}
	$result['ticket_alias'] = $ticket_alias;
	$result['req_cell_qty'] = $result['req_acc_qty'] = [];
	
	if(!empty($result['req_acc'])){
		$accq = explode(", ",$result['req_acc']);
		foreach($accq as $k=>$acc){
			$delim = (strpos($acc,'-(')!==false ? "-(" : "(");
			list($ac,$aq) = explode($delim,$acc);
			$result['req_acc_qty'][$k]['name'] = $ac;
			$result['req_acc_qty'][$k]['qty'] = str_replace(")","",$aq);
		}
	}
	if(!empty($result['req_cells'])){
		$celq = explode(", ",$result['req_cells']);
		foreach($celq as $k=>$cel){
			$delim = (strpos($cel,'-(')!==false ? "-(" : "(");
			list($cl,$cq) = explode($delim,$cel);
			$result['req_cell_qty'][$k]['name'] = $cl;
			$result['req_cell_qty'][$k]['qty'] = str_replace(")","",$cq);
		}
	}
	
	$result['plug_type'] = explode(", ",$result['plug_type']);

	$result['coach_status'] = explode(", ",$result['coach_status']);
	$result['valuephysicalcondition'] = explode(", ",$result['valuephysicalcondition']);
	$result['valueleakagecondition'] = explode(", ",$result['valueleakagecondition']);
	
	if($result['physical_damages'] != 'NO'){
		$result['physical_damages'] = explode(", ",$result['physical_damages']);
		$result['physical_condition'] = 'YES';
	}else{
		$result['physical_damages'] = [];
		$result['physical_condition'] = 'NO';
	}
	if($result['leakage'] != 'NO'){
		$result['leakage'] = explode(", ",$result['leakage']);
		$result['leakage_condition'] = 'YES';
	}else{
		$result['leakage'] = [];
		$result['leakage_condition'] = 'NO';
	}
	$result['general_observation'] = explode(", ",$result['general_observation']);
	list($vent_type,$vent_loose,$vent_perfect) = explode("|",$result['temp_vent_plug_thickness']);
	$result['vent_type'] = $vent_type;
	$result['vent_loose'] = $vent_loose;
	$result['vent_perfect'] = $vent_perfect;
	
	list($torque,$torque_loose,$torque_perfect) = explode("|",$result['temp_terminal_torque']);
	$result['torque'] = $torque;
	$result['torque_loose'] = $torque_loose;
	$result['torque_perfect'] = $torque_perfect;
	
	$result['dg_st']=($result['dg_status']=='AVAILABLE' ? TRUE : FALSE);
	$result['eb_sp']=(strpos(strtoupper($result['eb_supply']),'YES')!==false ? TRUE : FALSE);
	$result['job_performed_arr'] = (!empty($result['job_performed']) ? explode(", ",$result['job_performed']) : []);
	$result['customer_comment_id']=alias($ticket_alias,'ec_customer_comments','ticket_alias','id');
	$result['action_taken_id']=alias($ticket_alias,'ec_ticket_action','ticket_alias','id');
	$result['segment_ref'] = $segment_ref;
	$result['battery_obs'] = $battery_obs;
	$result['bbcondition'] = $bbcondition;
	$result['bankcapacity'] = $bank_capacity;
	$result['bankid'] = $bank_id;
	$result['bank_rating'] = $bank_rating;
	$result['header_o'] = $header_o;
	$result['header_a'] = $header_a;
	$result['header_b'] = $header_b;
	$result['header_c'] = $header_c;
	$result['header_o_id'] = $header_o_id;
	$result['header_a_id'] = $header_a_id;
	$result['header_b_id'] = $header_b_id;
	$result['header_c_id'] = $header_c_id;
	$result['bb_remarks'] = $remarks;
	//$result['bank_img'] = $bank_img;
	$result['mf_date'] = $mf_date;
	$result['cell_sl_no'] = $cell_sl_no;
	$result['telecom_id'] = $telecom_id;
	$result['motive_id'] = $motive_id;
	$result['ocv'] = $ocv;
	$result['sg_ocv'] = $sg_ocv;
	$result['battery_Volts'] = $battery_Volts;
	$result['battery_Volts_a'] = $battery_Volts_a;
	$result['battery_Volts_b'] = $battery_Volts_b;
	$result['tVoltage_o'] = $tVoltage_o;
	$result['tVoltage_a'] = $tVoltage_a;
	$result['tVoltage_b'] = $tVoltage_b;
	$result['tVoltage_c'] = $tVoltage_c;
	$result['bb_ter_o'] = $bb_ter_o;
	$result['bb_ter_a'] = $bb_ter_a;
	$result['bb_ter_b'] = $bb_ter_b;
	$result['bb_ter_c'] = $bb_ter_c;
	$result['cCurrent_o'] = $cCurrent_o;
	$result['cCurrent_a'] = $cCurrent_a;
	$result['cCurrent_b'] = $cCurrent_b;
	$result['cCurrent_c'] = $cCurrent_c;
	$result['temp_o'] = $temp_o;
	$result['temp_a'] = $temp_a;
	$result['temp_b'] = $temp_b;
	$result['temp_c'] = $temp_c;
	$result['charge_o'] = $charge_o;
	$result['charge_a'] = $charge_a;
	$result['charge_b'] = $charge_b;
	$result['charge_c'] = $charge_c;
	echo json_encode($result);
}
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
function coll($fv1){
	if($fv1>1) return 'colspan="'.$fv1.'"';
}
function site_input_segment($a){
	switch($a){
		case '1': $site_input='SMPS';break;
		case '2': $site_input='SOLAR';break;
		case '3': $site_input='FCBC';break; //POWERCONTROL
		case '4': $site_input='SOLAR';break;//TELECOMSOLAR
		case '5': $site_input='UPS';break;
		//case '6': $site_input='MOTIVE';break;
		//case '7': $site_input='RAILWAY';break;
		default : $site_input='';
	}return $site_input;
}
?>