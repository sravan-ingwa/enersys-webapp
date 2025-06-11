<?php
include('mysql.php');
include('../../services/functions.php');
/*echo efsr_upload1();
function efsr_upload1(){	global $mr_con;
	date_default_timezone_set("Asia/Kolkata");
	$data = file_get_contents('efsr.json',TRUE);
	//$efsr_check = urldecode($request->getBody());
	$update=json_decode($data,true);
	$ticket_id=$update['ticket_details']['ticket_no'];
	$emp_id=$update['user_det']['emp_id'];
	$device_id =$update['user_det']['device_id'];
	$rex=putToken($device_id,$emp_id);
	if($rex=='0'){
		$ticket_alias = $update['ticket_details']['ticket_alias'];//alias($ticket_id,'ec_tickets','ticket_id','ticket_alias');
		if(listchecking('ec_physical_observation','ticket_alias',$ticket_alias)==0 && listchecking('ec_technical_observation','ticket_alias',$ticket_alias)==0 && listchecking('ec_general_observation','ticket_alias',$ticket_alias)==0 && listchecking('ec_power_observation','ticket_alias',$ticket_alias)==0 && listchecking('ec_battery_bank_bb_cap','ticket_alias',$ticket_alias)==0 && listchecking('ec_engineer_observation','ticket_alias',$ticket_alias)==0 && listchecking('ec_customer_comments','ticket_alias',$ticket_alias)==0 && listchecking('ec_customer_satisfaction','ticket_alias',$ticket_alias)==0 && listchecking('ec_e_signature','ticket_alias',$ticket_alias)==0){  
			//SiteMaster Update
			$man_date = dateFormat($update['ticket_details']['manufacturing_date'],"y");
			$inst_date = dateFormat($update['ticket_details']['install_date'],"y");
			$service_engineer_alias = alias($ticket_alias,'ec_tickets','ticket_alias','service_engineer_alias');
			$site_alias = alias($ticket_alias,'ec_tickets','ticket_alias','site_alias');
			$lat=$update['user_det']['lat'];
			$lng=$update['user_det']['lng'];
			$address_site=getAddress($lat, $lng);
			$con_site = "";
			if(!empty($lat)){$con_site .= "lat='$lat',";}
			if(!empty($lng)){$con_site .= "lng='$lng',";}
			if(!empty($man_date) && $man_date!='NA'){$con_site .= "mfd_date='$man_date',";}
			if(!empty($inst_date) && $inst_date!='NA'){$con_site .= "install_date='$inst_date',";}
			if(!empty($address_site)){$con_site .= "site_address='$address_site',";}
			$sql = mysqli_query($mr_con,"UPDATE ec_sitemaster SET $con_site flag=0 WHERE site_alias='$site_alias' AND flag=0");
			$segment_alias = alias($site_alias,'ec_sitemaster','site_alias','segment_alias');
			if($segment_alias=="TQMBDTF5ZI"){ //Railways
				//coach_history
				$coach_alias = aliasCheck(generateRandomString(),'ec_coach_history','item_alias');
				$train_no=mysqli_real_escape_string($mr_con,strtoupper($update['history_of_the_coach']['train_number']));
				$express_name=mysqli_real_escape_string($mr_con,strtoupper($update['history_of_the_coach']['express_name']));
				$coach_no=mysqli_real_escape_string($mr_con,strtoupper($update['history_of_the_coach']['coach_number']));
				$pre_attnd=mysqli_real_escape_string($mr_con,strtoupper(dateFormat($update['history_of_the_coach']['previous_attended_date'],"y")));
				$poh=mysqli_real_escape_string($mr_con,strtoupper(dateFormat($update['history_of_the_coach']['poh_date'],"y")));
				$rpoh=mysqli_real_escape_string($mr_con,strtoupper(dateFormat($update['history_of_the_coach']['rpoh_date'],"y")));
				$zone=mysqli_real_escape_string($mr_con,strtoupper($update['history_of_the_coach']['zone']));
				$division=mysqli_real_escape_string($mr_con,strtoupper($update['history_of_the_coach']['division']));
				$workshop=mysqli_real_escape_string($mr_con,strtoupper($update['history_of_the_coach']['workshop_or_yard']));
				$coach_sql = mysqli_query($mr_con,"INSERT INTO ec_coach_history(ticket_alias,train_no,express_name,coach_no,pre_attnd,poh,rpoh,zone,division,workshop,item_alias)VALUES('$ticket_alias','$train_no','$express_name','$coach_no','$pre_attnd','$poh','$rpoh','$zone','$division','$workshop','$coach_alias')");	
				
				//equipment_details				
				$equip_alias = aliasCheck(generateRandomString(),'ec_equip_details','item_alias');
				$altenate_make=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['alternate_make']));
				$rru_make=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['rru_erru_make']));
				$invertor_make=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['invertor_make']));
				$regulator_make=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['regulator_make']));
				$voltage_regulation=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['voltage_regulation']));
				$altenate_belt_status=mysqli_real_escape_string($mr_con,strtoupper($update['equipment_details']['alternator_belt_status']));
				if(isset($update['equipment_details']['alternate_make_image'])){
					$altenate_make_doc = base64_to_file('altenate_make_doc',$update['equipment_details']['alternate_make_image'],'doc');
				}else{$altenate_make_doc='0';}
				if(isset($update['equipment_details']['alternator_belt_status_image'])){$altenate_belt_doc = base64_to_file('altenate_belt_doc',$update['equipment_details']['alternator_belt_status_image'],'doc');}else{$altenate_belt_doc='0';}
				$equip_sql = mysqli_query($mr_con,"INSERT INTO ec_equip_details(ticket_alias,altenate_make,altenate_make_doc,rru_make,invertor_make,regulator_make,voltage_regulation,altenate_belt_status,altenate_belt_doc,item_alias)VALUES('$ticket_alias','$altenate_make','$altenate_make_doc','$rru_make','$invertor_make','$regulator_make','$voltage_regulation','$altenate_belt_status','$altenate_belt_doc','$equip_alias')");	
				
				//check_points
				$check_points_alias = aliasCheck(generateRandomString(),'ec_check_points','item_alias');				
				$icc_tightness=mysqli_real_escape_string($mr_con,strtoupper($update['check_points']['icc_tightness']));
				$heating_melting_marks=mysqli_real_escape_string($mr_con,strtoupper($update['check_points']['any_heating_or_melt_marks']));
				$terminal_tightness=mysqli_real_escape_string($mr_con,strtoupper($update['check_points']['terminal_tightness']));
				$alt_no_belt_avl=mysqli_real_escape_string($mr_con,strtoupper($update['check_points']['alternate_no_of_belts_available']));
				$physical_damage=mysqli_real_escape_string($mr_con,strtoupper($update['check_points']['any_physical_damages']));
				$vent_plug_tightness=mysqli_real_escape_string($mr_con,strtoupper($update['check_points']['vent_plug_tightness']));
				$belt=mysqli_real_escape_string($mr_con,strtoupper($update['check_points']['vent_belt']));
				$log_book=mysqli_real_escape_string($mr_con,strtoupper($update['check_points']['log_book']));
				$coach_status=mysqli_real_escape_string($mr_con,strtoupper($update['check_points']['coach_status']));
				$cell_buldge=mysqli_real_escape_string($mr_con,strtoupper($update['check_points']['cell_budge']));
				if(isset($update['check_points']['physical_damages_image'])){$physical_damage_pic = base64_to_file('physical_damage_pic',$update['check_points']['physical_damages_image'],'doc');}else{$physical_damage_pic='0';}
				if(isset($update['check_points']['cell_budge_image'])){$cell_buldge_pic = base64_to_file('cell_buldge_pic',$update['check_points']['cell_budge_image'],'doc');}else{$cell_buldge_pic='0';}
				$check_points_sql = mysqli_query($mr_con,"INSERT INTO ec_check_points(ticket_alias,icc_tightness,heating_melting_marks,terminal_tightness,alt_no_belt_avl,physical_damage,physical_damage_pic,vent_plug_tightness,belt,log_book,coach_status,cell_buldge,cell_buldge_pic,item_alias)VALUES('$ticket_alias','$icc_tightness','$heating_melting_marks','$terminal_tightness','$alt_no_belt_avl','$physical_damage','$physical_damage_pic','$vent_plug_tightness','$belt','$log_book','$coach_status','$cell_buldge','$cell_buldge_pic','$check_points_alias')");	
	
			}elseif($segment_alias=="YGRKJJD4N7"){ //Motive Power
				//Physical observation
				$physical_alias = aliasCheck(generateRandomString(),'ec_physical_observation','item_alias');
				$physical_damages =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['physical_damages']));
				$leakage =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['leakage']));
				$room_temperature =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['room_temperature']));
				$ambient_temperature =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['ambient_temperature']));
				$temperature="INDOOR|".$room_temperature."|".$ambient_temperature;
				$acid_temp_discharge =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['acid_temp_discharge']));
				$acid_temp_charge =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['acid_temp_charge']));
				$cells_temp_after_use =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['cells_temp_after_use']));
				$cells_temp_at_charge =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['cells_temp_at_charge']));
				$general_observation =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['general_observations']));
				$terminal_torque_type =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['terminal_torque']));
				$no_of_cell_loose =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['no_of_cell_loose']));
				$no_of_cell_tightened =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['no_of_cell_tightened']));
				$terminal_torque=$terminal_torque_type."|".$no_of_cell_loose."|".$no_of_cell_tightened;
				//$vent_plug =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['vent_plug']));
				if(isset($update['physical_observations']['physical_damage_image'])){$physical_damage_image = base64_to_file('physical_damage_pic',$update['physical_observations']['physical_damage_image'],'doc');}else{$physical_damage_image ='0';}
				if(isset($update['physical_observations']['leakage_image'])){$leakage_image = base64_to_file('leakage_image',$update['physical_observations']['leakage_image'],'doc');}else{$leakage_image ='0';}
				$physical_sql = mysqli_query($mr_con,"INSERT INTO ec_physical_observation(ticket_alias,physical_damages,leakage,temperature,acid_temp_discharge,acid_temp_charge,cells_temp_after_use,cells_temp_at_charge,general_observation,terminal_torque,item_alias,physical_damages_document,leakage_document)VALUES('$ticket_alias','$physical_damages','$leakage','$temperature','$acid_temp_discharge','$acid_temp_charge','$cells_temp_after_use','$cells_temp_at_charge','$general_observation','$terminal_torque','$physical_alias','$physical_damage_image','$leakage_image')");
				
				//charger_details
				$charger_alias = aliasCheck(generateRandomString(),'ec_charger_details','item_alias');
				$charger_band=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['charger_brand']));
				$manf_date=dateFormat($update['charger_details']['charger_manufacturing_date'],"y");
				$serial_no=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['serial_number']));
				$charger_type=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['charger_type']));
				$voltage=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['voltage']));
				$charging_current=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['charging_current']));
				$high_voltage_cutoff=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['high_voltage_cut_off']));
				$voltage_ripple=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['voltage_ripple']));
				$voltage_regulation=mysqli_real_escape_string($mr_con,strtoupper($update['charger_details']['voltage_regulation']));
				if(isset($update['charger_details']['charger_image'])){ $charger_pic = base64_to_file('charger_pic',$update['charger_details']['charger_image'],'doc');}else{$charger_pic='0';}
				$charger_sql = mysqli_query($mr_con,"INSERT INTO ec_charger_details(ticket_alias,charger_band,manf_date,serial_no,charger_type,voltage,charging_current,high_voltage_cutoff,voltage_ripple,voltage_regulation,charger_pic,item_alias)VALUES('$ticket_alias','$charger_band','$manf_date','$serial_no','$charger_type','$voltage','$charging_current','$high_voltage_cutoff','$voltage_ripple','$voltage_regulation','$charger_pic','$charger_alias')");	

				//forklift_details
				$forklift_alias = aliasCheck(generateRandomString(),'ec_fork_lift','item_alias');
				$fork_lift_brand=mysqli_real_escape_string($mr_con,strtoupper($update['forklift_details']['forklift_brand']));
				$fork_lift_model=mysqli_real_escape_string($mr_con,strtoupper($update['forklift_details']['forklift_model']));
				$fork_lift_manf_date=dateFormat($update['forklift_details']['forklift_manufacturing_date'],"y");
				if(isset($update['forklift_details']['forklift_image'])){$fork_lift_pic = base64_to_file('fork_lift_pic',$update['forklift_details']['forklift_image'],'doc');}else{$fork_lift_pic='0';}
				$forklift_sql = mysqli_query($mr_con,"INSERT INTO ec_fork_lift(ticket_alias,fork_lift_brand,fork_lift_model,fork_lift_manf_date,fork_lift_pic,item_alias)VALUES('$ticket_alias','$fork_lift_brand','$fork_lift_model','$fork_lift_manf_date','$fork_lift_pic','$forklift_alias')");	
				
				//battery_details
				$battey_alias = aliasCheck(generateRandomString(),'ec_battery_details','item_alias');
				$battey_type=mysqli_real_escape_string($mr_con,strtoupper($update['forklift_details']['battery_type']));
				$bank_serial_no=mysqli_real_escape_string($mr_con,strtoupper($update['forklift_details']['battery_bank_serial_number']));
				$manf_date=dateFormat($update['forklift_details']['manufacturing_date'],"y");
				$ins_date=dateFormat($update['forklift_details']['installation_date'],"y");
				$plug_type=mysqli_real_escape_string($mr_con,strtoupper($update['forklift_details']['plug_type']));
				$acid_level=mysqli_real_escape_string($mr_con,strtoupper($update['forklift_details']['acid_level']));
				$battey_sql = mysqli_query($mr_con,"INSERT INTO ec_battery_details(ticket_alias,battey_type,bank_serial_no,manf_date,ins_date,plug_type,acid_level,item_alias)VALUES('$ticket_alias','$battey_type','$bank_serial_no','$manf_date','$ins_date','$plug_type','$acid_level','$battey_alias')");	
			
			}elseif($segment_alias=="SMEY7SL24I" || $segment_alias=="W0PBT7IAZE"){ //UPS OR Power control
				
				//UPS-FSR/POWER Control-FSR
				$ups_alias = aliasCheck(generateRandomString(),'ec_technical_observation','item_alias');
				$float_voltage=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observations']['float_voltage']));
				$boast_voltage=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observations']['boast_voltage']));
				$current_limit=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observations']['current_limit']));
				$voltage_ripple=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observations']['voltage_ripple']));
				$voltage_regulation=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observations']['voltage_regulation']));
				$high_voltage_cutoff=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observations']['high_voltage_cut_off']));
				$low_voltage_cutoff=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observations']['low_voltage_cut_off']));
				$panel_make=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observations']['ups_make']));
				$panel_rating=mysqli_real_escape_string($mr_con,strtoupper($update['ups_observations']['ups_rating']));
				$panel_manufacturing_date=dateFormat($update['ups_observations']['ups_manufacturing_date'],"y");
				$panel_installation_date=dateFormat($update['ups_observations']['ups_installtaion_date'],"y");
				if(isset($update['ups_observations']['float_voltage_image'])){$document_1 = base64_to_file('float_voltage_image_ups_pc',$update['ups_observations']['float_voltage_image'],'doc');}else{$document_1='0';}
				if(isset($update['ups_observations']['boast_voltage_image'])){$document_2 = base64_to_file('boast_voltage_image_ups_pc',$update['ups_observations']['boast_voltage_image'],'doc');}else{$document_2='0';}
				$ups_sql = mysqli_query($mr_con,"INSERT INTO ec_technical_observation(ticket_alias,float_voltage,boast_voltage,current_limit,voltage_ripple,voltage_regulation,high_voltage_cutoff,low_voltage_cutoff,panel_make,panel_rating,charge_controller_rate,charge_controller_make,no_solar_panels,single_panel_rating,panel_manufacturing_date,charge_control_manufacturing_date,panel_installation_date,item_alias,document_1,document_2,document_3,document_4,document_5)VALUES('$ticket_alias','$float_voltage','$boast_voltage','$current_limit','$voltage_ripple','$voltage_regulation','$high_voltage_cutoff','$low_voltage_cutoff','$panel_make','$panel_rating','0','0','0','0','$panel_manufacturing_date','0','$panel_installation_date','$ups_alias','$document_1','$document_2','0','0','0')");	

			}elseif($segment_alias=="KWJCZKSTBL" || $segment_alias=="DDEYO7NTTC"){ // Solar OR Telecom-Solar
				//Solar/Telecom-Solar
				$solar_telecom_alias = aliasCheck(generateRandomString(),'ec_technical_observation','item_alias');
				$float_voltage=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['float_voltage']));
				$boast_voltage=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['boast_voltage']));
				$current_limit=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['current_limit']));
				$voltage_ripple=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['voltage_ripple']));
				$voltage_regulation=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['voltage_regulation']));
				$high_voltage_cutoff=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['high_voltage_cut_off']));
				$low_voltage_cutoff=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['low_voltage_cut_off']));
				$panel_make=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['panel_make']));
				$panel_rating=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['panel_rating']));
				$charge_controller_rate=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['charger_controller_rating']));
				$charge_controller_make=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['charger_controller_make']));
				$no_solar_panels=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['number_of_solar_panels']));
				$single_panel_rating=mysqli_real_escape_string($mr_con,strtoupper($update['solar_panel_controller_observations']['single_panel_rating']));
				$panel_manufacturing_date=dateFormat($update['solar_panel_controller_observations']['panel_manufacturing_date'],"y");
				$charge_control_manufacturing_date=dateFormat($update['solar_panel_controller_observations']['charge_controller_manufacturing_date'],"y");
				$panel_installation_date=dateFormat($update['solar_panel_controller_observations']['panel_installation_date'],"y");
				if(isset($update['solar_panel_controller_observations']['float_voltage_image'])){$document_1 = base64_to_file('float_voltage_image_sa_ts',$update['solar_panel_controller_observations']['float_voltage_image'],'doc');}else{$document_1='0';}
				if(isset($update['solar_panel_controller_observations']['boast_voltage_image'])){$document_2 = base64_to_file('boast_voltage_image_sa_ts',$update['solar_panel_controller_observations']['boast_voltage_image'],'doc');}else{$document_2='0';}
				if(isset($update['solar_panel_controller_observations']['number_of_solar_panels_image'])){$document_3 = base64_to_file('number_of_solar_panels_image_sa_ts',$update['solar_panel_controller_observations']['number_of_solar_panels_image'],'doc');}else{$document_3='0';}
				$solar_telecom_sql = mysqli_query($mr_con,"INSERT INTO ec_technical_observation(ticket_alias,float_voltage,boast_voltage,current_limit,voltage_ripple,voltage_regulation,high_voltage_cutoff,low_voltage_cutoff,panel_make,panel_rating,charge_controller_rate,charge_controller_make,no_solar_panels,single_panel_rating,panel_manufacturing_date,charge_control_manufacturing_date,panel_installation_date,item_alias,document_1,document_2,document_3,document_4,document_5)VALUES('$ticket_alias','$float_voltage','$boast_voltage','$current_limit','$voltage_ripple','$voltage_regulation','$high_voltage_cutoff','$low_voltage_cutoff','$panel_make','$panel_rating','$charge_controller_rate','$charge_controller_make','$no_solar_panels','$single_panel_rating','$panel_manufacturing_date','$charge_control_manufacturing_date','$panel_installation_date','$solar_telecom_alias','$document_1','$document_2','$document_3','0','0')");
			}
			if($segment_alias!="TQMBDTF5ZI" && $segment_alias!="YGRKJJD4N7"){ // Neither Railways nor Motive power
				//physical_observations
				$physical_alias = aliasCheck(generateRandomString(),'ec_physical_observation','item_alias');
				$physical_damages =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['physical_damage']));
				$leakage =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['leakage']));
				$temperature =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['temperature']));
				$general_observation =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['general_observations']));
				$terminal_torque =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['terminal_torque']));
				$vent_plug =mysqli_real_escape_string($mr_con,strtoupper($update['physical_observations']['vent_plug']));
				if(isset($update['physical_observations']['physical_damage_image'])){$physical_damage_image = base64_to_file('physical_damage_image',$update['physical_observations']['physical_damage_image'],'doc');}else{$physical_damage_image ='0';}
				if(isset($update['physical_observations']['leakage_image'])){$leakage_image = base64_to_file('leakage_image',$update['physical_observations']['leakage_image'],'doc');}else{$leakage_image ='0';}
				$physical_sql = mysqli_query($mr_con,"INSERT INTO ec_physical_observation(ticket_alias,physical_damages,leakage,temperature,general_observation,terminal_torque,vent_plug_thickness,item_alias,physical_damages_document,leakage_document)VALUES('$ticket_alias','$physical_damages','$leakage','$temperature','$general_observation','$terminal_torque','$vent_plug','$physical_alias','$physical_damage_image','$leakage_image')");
				if($segment_alias=="HXL5A1HOTZ"){ // Telecom
					//smps_observations
					$smps_alias = aliasCheck(generateRandomString(),'ec_technical_observation','item_alias');
					$float_voltage =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['float_voltage']));
					$boast_voltage =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['boast_voltage']));
					$current_limit =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['current_limit']));
					$voltage_ripple =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['voltage_ripple']));
					$voltage_regulation=mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['lvd_status']));// LVD'S Status
					$high_voltage_cutoff =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['high_voltage_cutoff']));
					$low_voltage_cutoff =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['low_voltage_cutoff']));
					$panel_make =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['panel_make']));// SMPS Make
					$panel_rating =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['panel_rating']));// SMPS Rating
					$charge_controller_rate =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['smr_module_rating']));// SMR Moduls Rating(Amps)
					if(isset($update['smps_observations']['charge_controller_make'])){$charge_controller_make = base64_to_file('charge_controller_make',$update['smps_observations']['charge_controller_make'],'doc');}else{$charge_controller_make='0';}
					$no_of_solar_panels =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['no_of_working_modules']));// Number of Working Modules
					$single_panel_rating =mysqli_real_escape_string($mr_con,strtoupper($update['smps_observations']['smps_display']));// SMPS Display
					
					$panel_manf_date =dateFormat($update['smps_observations']['panel_manf_date'],"y"); //SMPS Manufacturing Date
					$charger_controller_manf_date=dateFormat($update['smps_observations']['charger_controller_manf_date'],"y");
					$panel_install_date=dateFormat($update['smps_observations']['panel_install_date'],"y");
					if(isset($update['smps_observations']['document_1'])){$document_1 = base64_to_file('document_1',$update['smps_observations']['document_1'],'doc');}else{$document_1='0';}
					if(isset($update['smps_observations']['document_2'])){$document_2 = base64_to_file('document_2',$update['smps_observations']['document_2'],'doc');}else{$document_2='0';}
					if(isset($update['smps_observations']['document_3'])){$document_3 = base64_to_file('document_3',$update['smps_observations']['document_3'],'doc');}else{$document_3='0';}
					if(isset($update['smps_observations']['document_4'])){$document_4 = base64_to_file('document_4',$update['smps_observations']['document_4'],'doc');}else{$document_4='0';}
					if(isset($update['smps_observations']['document_5'])){$document_5 = base64_to_file('document_5',$update['smps_observations']['document_5'],'doc');}else{$document_5='0';}
					$smps_sql = mysqli_query($mr_con,"INSERT INTO ec_technical_observation(ticket_alias,float_voltage,boast_voltage,current_limit,voltage_ripple,voltage_regulation,high_voltage_cutoff,low_voltage_cutoff,panel_make,panel_rating,charge_controller_rate,charge_controller_make,no_solar_panels,single_panel_rating,panel_manufacturing_date,charge_control_manufacturing_date,panel_installation_date,item_alias,document_1,document_2,document_3,document_4,document_5)VALUES('$ticket_alias','$float_voltage','$boast_voltage','$current_limit','$voltage_ripple','$voltage_regulation','$high_voltage_cutoff','$low_voltage_cutoff','$panel_make','$panel_rating','$charge_controller_rate','charge_controller_make','$no_of_solar_panels','$single_panel_rating','$panel_manf_date','$charger_controller_manf_date','$panel_install_date','$smps_alias','$document_1','$document_2','$document_3','$document_4','$document_5')");
				}
				//generator_observations
				$general_alias = aliasCheck(generateRandomString(),'ec_general_observation','item_alias');
				$site_load =mysqli_real_escape_string($mr_con,strtoupper($update['generator_observations']['site_load']));
				$dg_status =mysqli_real_escape_string($mr_con,strtoupper($update['generator_observations']['dg_status']));
				if(isset($update['generator_observations']['dg_make'])){$dg_make =mysqli_real_escape_string($mr_con,strtoupper($update['generator_observations']['dg_make']));}else{$dg_make='0';}
				if(isset($update['generator_observations']['dg_capacity'])){$dg_capacity =mysqli_real_escape_string($mr_con,$update['generator_observations']['dg_capacity']);}else{$dg_capacity='0';}
				$dg_working_condition =mysqli_real_escape_string($mr_con,strtoupper($update['generator_observations']['dg_working_condition']));
				$avg_dg_run =mysqli_real_escape_string($mr_con,strtoupper($update['generator_observations']['avg_dg_run']));
				if(isset($update['generator_observations']['dg_pic'])){$dg_pic = base64_to_file('dg_pic',$update['generator_observations']['dg_pic'],'doc');}else{$dg_pic='0';}
				$general_sql = mysqli_query($mr_con,"INSERT INTO ec_general_observation(ticket_alias,site_load,dg_status,dg_make,dg_capacity,dg_working_condition,avg_dg_run,item_alias,dg_pic)VALUES('$ticket_alias','$site_load','$dg_status','$dg_make','$dg_capacity','$dg_working_condition','$avg_dg_run','$general_alias','$dg_pic')");

				//power_observation
				$power_alias = aliasCheck(generateRandomString(),'ec_power_observation','item_alias');
				$eb_supply =mysqli_real_escape_string($mr_con,strtoupper($update['generator_observations']['eb_supply_availability']));
				$failures_per_day =mysqli_real_escape_string($mr_con,strtoupper($update['generator_observations']['failures_per_day']));
				$avg_power_cut =mysqli_real_escape_string($mr_con,strtoupper($update['generator_observations']['avg_power_cut_hrs_in_day']));
				$power_sql = mysqli_query($mr_con,"INSERT INTO ec_power_observation(ticket_alias,eb_supply,failures_per_day,avg_power_cut,item_alias)VALUES('$ticket_alias','$eb_supply','$failures_per_day','$avg_power_cut','$power_alias')");
			}
			//Battery Observation
			for($j=0;$j<count($update['battery_observation']);$j++){
				if($j<2){
					$battery_bank_bb_alias = aliasCheck(generateRandomString(),'ec_battery_bank_bb_cap','item_alias');
					$battery_bank_rating =mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j]['battery_bank_rating']));
					$bb_capacity =mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j]['bb_capacity']));
					if(isset($update['battery_observation'][$j]['battery_report_image'])){$battery_report_image = base64_to_file('battery_report_image',$update['battery_observation'][$j]['battery_report_image'],'battery');}else{$battery_report_image='0';}
					if(isset($update['battery_observation'][$j]['battery_report_image_2'])){$battery_report_image_2 = base64_to_file('battery_report_image_2',$update['battery_observation'][$j]['battery_report_image_2'],'battery_2');}else{$battery_report_image_2='0';}
					$battery_bank_bb_sql=mysqli_query($mr_con,"INSERT INTO ec_battery_bank_bb_cap(ticket_alias,battery_bank_rating,bb_capacity,image,image_2,item_alias)VALUES('$ticket_alias','$battery_bank_rating','$bb_capacity','$battery_report_image','$battery_report_image_2','$battery_bank_bb_alias')");
					for($i=0;$i<count($update['battery_observation'][$j]['cell_sl_no']);$i++){
						$battery_alias = aliasCheck(generateRandomString(),'ec_bo_telecom_ic','item_alias');
						$cell_sl_no =mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j]['cell_sl_no'][$i]));
						$mf_date =mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j]['mf_date'][$i]));
						if($segment_alias=="YGRKJJD4N7"){
							$acid_density = mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j]['acid_density'][$i]));
						}else{$acid_density = '0';}
						//if(isset($update['battery_observation'][$j]['ocv']['ocv'])){
							$ocv =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['ocv']['ocv'][$i]);
						//}else{ $ocv =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['ocv'][$i]);}
						$hr1 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_1']['hr1'][$i]);
						$hr2 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_1']['hr2'][$i]);
						$hr3 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_1']['hr3'][$i]);
						$hr4 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_1']['hr4'][$i]);
						$hr5 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_1']['hr5'][$i]);
						$hr6 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_1']['hr6'][$i]);
						$hr7 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_1']['hr7'][$i]);
						$hr8 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_1']['hr8'][$i]);
						$hr9 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_1']['hr9'][$i]);
						$hr10 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_1']['hr10'][$i]);
						
						$hr11 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['discharge_voltage']['hr1'][$i]);
						$hr12 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['discharge_voltage']['hr2'][$i]);
						$hr13 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['discharge_voltage']['hr3'][$i]);
						$hr14 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['discharge_voltage']['hr4'][$i]);
						$hr15 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['discharge_voltage']['hr5'][$i]);
						$hr16 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['discharge_voltage']['hr6'][$i]);
						$hr17 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['discharge_voltage']['hr7'][$i]);
						$hr18 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['discharge_voltage']['hr8'][$i]);
						$hr19 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['discharge_voltage']['hr9'][$i]);
						$hr20 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['discharge_voltage']['hr10'][$i]);
						
						$hr21 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_2']['hr1'][$i]);
						$hr22 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_2']['hr2'][$i]);
						$hr23 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_2']['hr3'][$i]);
						$hr24 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_2']['hr4'][$i]);
						$hr25 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_2']['hr5'][$i]);
						$hr26 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_2']['hr6'][$i]);
						$hr27 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_2']['hr7'][$i]);
						$hr28 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_2']['hr8'][$i]);
						$hr29 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_2']['hr9'][$i]);
						$hr30 =mysqli_real_escape_string($mr_con,$update['battery_observation'][$j]['on_charge_voltage_2']['hr10'][$i]);
						
						$remarks =mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j]['remarks'][$i]));
						$battery_sql = mysqli_query($mr_con,"INSERT INTO ec_bo_telecom_ic(cell_sl_no,mf_date,ocv,acid_density,1hr,2hr,3hr,4hr,5hr,6hr,7hr,8hr,9hr,10hr,11hr,12hr,13hr,14hr,15hr,16hr,17hr,18hr,19hr,20hr,21hr,22hr,23hr,24hr,25hr,26hr,27hr,28hr,29hr,30hr,battery_bb_alias,item_alias,remarks)VALUES('$cell_sl_no','$mf_date','$ocv','$acid_density','$hr1', '$hr2', '$hr3', '$hr4', '$hr5', '$hr6', '$hr7', '$hr8', '$hr9', '$hr10', '$hr11', '$hr12', '$hr13', '$hr14', '$hr15', '$hr16', '$hr17', '$hr18', '$hr19', '$hr20', '$hr21', '$hr22', '$hr23', '$hr24', '$hr25', '$hr26', '$hr27', '$hr28', '$hr29', '$hr30', '$battery_bank_bb_alias','$battery_alias','$remarks')");
					}
					//bo header
						$headers='ocv';//mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j]['ocv']['headers'][0]));
						$total_voltage=mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j]['ocv']['total_voltage'][0]));
						$temperature=mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j]['ocv']['temperature'][0]));
						$charging_current=mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j]['ocv']['charging_current'][0]));
						$bo_header_sql=mysqli_query($mr_con,"INSERT INTO ec_bo_headers(header,total_voltage,temperature,charging_current,item_alias,type)VALUES('$headers','$total_voltage','$temperature','$charging_current','$battery_bank_bb_alias','$headers')");
						
					$arr = array('on_charge_voltage_1','discharge_voltage','on_charge_voltage_2');
					foreach($arr as $voltage){
						for($k=0;$k<count($update['battery_observation'][$j][$voltage]['headers']);$k++){
							if(!empty($update['battery_observation'][$j][$voltage]['headers'][$k])){
								$headers=mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j][$voltage]['headers'][$k]));
								$total_voltage=mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j][$voltage]['total_voltage'][$k]));
								$temperature=mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j][$voltage]['temperature'][$k]));
								$charging_current=mysqli_real_escape_string($mr_con,strtoupper($update['battery_observation'][$j][$voltage]['charging_current'][$k]));
								$bo_header_sql=mysqli_query($mr_con,"INSERT INTO ec_bo_headers(header,total_voltage,temperature,charging_current,item_alias,type)VALUES('$headers','$total_voltage','$temperature','$charging_current','$battery_bank_bb_alias','$voltage')");
							}
						}
					}
				}
			}
			//serviceengineer_observations
			$engineer_alias = aliasCheck(generateRandomString(),'ec_engineer_observation','item_alias');
			$faulty_cell_sr_no =mysqli_real_escape_string($mr_con,strtoupper(trim($update['serviceengineer_observations']['faulty_cell_serial_number'])));
			$faulty_code_alias =mysqli_real_escape_string($mr_con,alias(trim($update['serviceengineer_observations']['faulty_code']),'ec_faulty_code','description','faulty_alias'));
			$req_acc=mysqli_real_escape_string($mr_con,$update['serviceengineer_observations']['req_acc']);
			$req_cells=mysqli_real_escape_string($mr_con,$update['serviceengineer_observations']['req_cells']);
			$cell_alias = array(); $quanty = array();
			if(!empty($req_cells)){
				$plane = str_replace(")","",str_replace("(","",$req_cells));
				if(strpos($req_cells,",")!== false){
					$a = explode(", ",$plane);
					foreach($a as $b){
						list($cell, $quan) = explode("-",$b);
						$cell_alias[] = alias(trim($cell),'ec_product','battery_rating','product_alias');
						$quanty[] =$quan;
					}					
				}else{
					list($cell, $quan) = explode("-",$plane);
					$cell_alias[] = alias(trim($cell),'ec_product','battery_rating','product_alias');
					$quanty[] =$quan;
				}
				for($i=0;$i<count($cell_alias);$i++){
					$alias=aliasCheck(generateRandomString(),'ec_cell_required','item_alias');
					$cell_alia=trim($cell_alias[$i]);
					$quant=trim($quanty[$i]);
					$sqlReq = mysqli_query($mr_con,"INSERT INTO ec_cell_required(ticket_alias,cell_alias,quanty,item_alias)VALUES('$ticket_alias','$cell_alia','$quant','$alias')");
				}
				$total_faulty_count = array_sum($quanty);
			}else{$total_faulty_count = 0;}
			$job_performed =mysqli_real_escape_string($mr_con,strtoupper($update['serviceengineer_observations']['job_performed']));
			$remarks =mysqli_real_escape_string($mr_con,strtoupper($update['serviceengineer_observations']['remarks']));
			$action_taken =mysqli_real_escape_string($mr_con,strtoupper($update['serviceengineer_observations']['action_taken']));
			//Requested cells
			$request_cell=$update['serviceengineer_observations']['request_cell'];
			$replaced_cell_no="";
			if(isset($request_cell) && count($request_cell)){
				if(!in_array("No Replaced Cells",$request_cell)){$zx="";
					for($aa=0;$aa<count($request_cell);$aa++){
						//$zx.=alias(trim($update['serviceengineer_observations']['request_cell'][$aa]['item_description']),'ec_item_code','item_description','item_code_alias').", ";
						$zx.=trim($update['serviceengineer_observations']['request_cell'][$aa]['item_description']).", ";
					}$replaced_cell_no = rtrim($zx,", ");
				}
			}
			$faulty_cell_sr_no=str_replace(",",", ",str_replace(" ","",$faulty_cell_sr_no));
			$engineer_sql = mysqli_query($mr_con,"INSERT INTO ec_engineer_observation(ticket_alias,faulty_cell_sr_no,faulty_code_alias,req_acc,req_cells,total_faulty_count,job_performed,replaced_cell_no,item_alias)VALUES('$ticket_alias','$faulty_cell_sr_no','$faulty_code_alias','$req_acc','$req_cells','$total_faulty_count','$job_performed','$replaced_cell_no','$engineer_alias')");		
			$remark_alias = aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
			$remark_sql = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias)VALUES('$remarks','TT','$ticket_alias','$service_engineer_alias','$remark_alias')");
			$action_alias = aliasCheck(generateRandomString(),'ec_ticket_action','item_alias');
			$action_sql = mysqli_query($mr_con,"INSERT INTO ec_ticket_action(ticket_alias,observation,item_alias)VALUES('$ticket_alias','$action_taken','$action_alias')");
			//Customer comments
			$customer_comments_alias = aliasCheck(generateRandomString(),'ec_customer_comments','item_alias');
			$customer_comments =mysqli_real_escape_string($mr_con,strtoupper($update['customer_satisfaction']['customer_comments']));
			$customer_comments_sql = mysqli_query($mr_con,"INSERT INTO ec_customer_comments(ticket_alias,customer_comments,item_alias)VALUES('$ticket_alias','$customer_comments','$customer_comments_alias')");
			//Customer_satisfaction
			$customer_satisfaction_alias = aliasCheck(generateRandomString(),'ec_customer_satisfaction','item_alias');
			$rating1 =mysqli_real_escape_string($mr_con,$update['customer_satisfaction']['rating1']);
			$rating2 =mysqli_real_escape_string($mr_con,$update['customer_satisfaction']['rating2']);
			$rating3 =mysqli_real_escape_string($mr_con,$update['customer_satisfaction']['rating3']);
			$rating4 =mysqli_real_escape_string($mr_con,$update['customer_satisfaction']['rating4']);
			$rating5 =mysqli_real_escape_string($mr_con,$update['customer_satisfaction']['rating5']);
			$customer_satisfaction_sql = mysqli_query($mr_con,"INSERT INTO ec_customer_satisfaction(ticket_alias,q1,q2,q3,q4,q5,item_alias)VALUES('$ticket_alias','$rating1','$rating2','$rating3','$rating4','$rating5','$customer_satisfaction_alias')");
			//esignature
			$e_signature_alias = aliasCheck(generateRandomString(),'ec_e_signature','item_alias');
			$name =mysqli_real_escape_string($mr_con,strtoupper($update['e_signature']['name']));
			$email =mysqli_real_escape_string($mr_con,$update['e_signature']['user_email']);
			$designation =mysqli_real_escape_string($mr_con,strtoupper($update['e_signature']['designation']));
			$contact_number =mysqli_real_escape_string($mr_con,$update['e_signature']['contact_number']);
			if(isset($update['e_signature']['signature_image'])){$signature_image = base64_to_file('customer_signature',$update['e_signature']['signature_image'],'sign');}else{$signature_image ='0';}
			if(isset($update['e_signature']['user_photo'])){$user_photo = base64_to_file('customer_photo',$update['e_signature']['user_photo'],'photo');}else{$user_photo ='0';}
			if(isset($update['serviceengineer_observations']['engineer_photo'])){$engineer_photo = base64_to_file('engineer_photo',$update['serviceengineer_observations']['engineer_photo'],'photo');}else{$engineer_photo ='0';}
			if(isset($update['serviceengineer_observations']['engineer_signature'])){$engineer_sign = base64_to_file('engineer_signature',$update['serviceengineer_observations']['engineer_signature'],'sign');}else{$engineer_sign ='0';}
			$e_signature_sql = mysqli_query($mr_con,"INSERT INTO ec_e_signature(ticket_alias,name,email,designation,contact_number,photo,e_signature,item_alias,engineer_photo,engineer_sign)VALUES('$ticket_alias','$name','$email','$designation','$contact_number','$user_photo','$signature_image','$e_signature_alias','$engineer_photo','$engineer_sign')");
			//customer details update in sitemaster
			$cu = "";
			if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){$cu = "manager_mail='$email', ";}
			if(!empty($contact_number)){$cu .= "manager_number='$contact_number', ";}
			$e_customer_sql = mysqli_query($mr_con,"UPDATE ec_sitemaster SET $cu flag='0' WHERE site_alias='$site_alias' AND flag='0'");
			//tickets update
			$dat = date("Y-m-d H:i:s");
			$efsr_no = efsrNoCheck(efsrRandomNo());
			$update = mysqli_query($mr_con,"UPDATE ec_tickets SET level='3',old_level='2',status='VISITED',closing_date='".$dat."',tat='".tat($ticket_alias)."',efsr_no='".$efsr_no."',efsr_date='".$dat."',transaction_date='".date('Y-m-d')."',n_visits=(n_visits+1) WHERE ticket_alias='$ticket_alias'");
			if($update){
				$ticket_id=alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
				$serNum=alias(alias($ticket_alias,'ec_tickets','ticket_alias','service_engineer_alias'),'ec_employee_master','employee_alias','mobile_number');
				$custNum=alias(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','technician_number');
				$custMsg=urlencode("Greetings from Enersys, Against against Ticket No-".$ticket_id." SE Mob-".$serNum." has completed the Site visit and status will be updated Shortly.");
				messageSent($custNum,$custMsg);
				ticket_notification($ticket_alias,"Site Visited");
				if($segment_alias=="HXL5A1HOTZ"){
					file_get_contents("http://enersyscare.co.in/enersyscare_V2/mailling.php?ticketAlias=".$ticket_alias);
				}
				echo '{"err_details":{"err_code":0,"err_message":"Success"}}';
			}else{echo '{"err_details":{"err_code":-4,"err_message":"Not Success"}}';}
		}else{echo '{"err_details":{"err_code":-4,"err_message":"Ticket Already Submitted"}}';}
		}elseif($rex=='-3'){echo '{"err_details":{"err_code":-3,"err_message":"account locked"}}';}
		elseif($rex=='-2'){echo '{"err_details":{"err_code":-2,"err_message":"device not matched"}}';}
		else{echo '{"err_details":{"err_code":-1,"err_message":"authentication failed"}}';}
}
function putToken($device,$emp_id) { global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT employee_alias FROM ec_employee_master WHERE employee_id='$emp_id' AND (device='$device' OR device_2='$device') AND flag=0");
	$sql1 = mysqli_query($mr_con,"SELECT id FROM ec_employee_master WHERE employee_id='$emp_id' AND (device='$device' OR device_2='$device') AND flag=1");
	$sql2 = mysqli_query($mr_con,"SELECT id FROM ec_employee_master WHERE employee_id='$emp_id' AND device<>'$device' AND device_2<>'$device' AND flag=0");
	if(mysqli_num_rows($sql)){
		return '0';
	}
	elseif(mysqli_num_rows($sql1)){return '-3';}
	elseif(mysqli_num_rows($sql2)){return '-2';}
	else{return '-1';}
}

function efsrRandomNo($length = 5) {
		$characters = '012345';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++){$randomString .= $characters[rand(0, $charactersLength - 1)];}
		return $randomString;
}
function efsrNoCheck($fv1){ global $mr_con;
		$rec=$mr_con->query("SELECT efsr_no FROM ec_tickets WHERE efsr_no='$fv1'");
		if($rec->num_rows==0)return $fv1; else return efsrNoCheck(efsrRandomNo());
}
function base64_to_file($name,$base,$ref){
	if($ref=='doc'){$path='../../efsr_reports/reports_images/'.$name.'_'.date('Y-m-d_h_i_s').'.jpg';}
	elseif($ref=='sign'){$path='../../efsr_reports/cust_engineer_images/sign_images/'.$name.'_'.date('Y-m-d_h_i_s').'.jpg';}
	elseif($ref=='photo'){$path='../../efsr_reports/cust_engineer_images/'.$name.'_'.date('Y-m-d_h_i_s').'.jpg';}
	else{$path='../../efsr_reports/reports_images/'.$name.'_'.date('Y-m-d_h_i_s').'.png';}
	$ss = file_put_contents($path, base64_decode($base));
	if($ss)return $path;else return '0';
}
function getToken($emp_id,$token){ global $mr_con; return '0';
	$sql = mysqli_query($mr_con,"SELECT id FROM ec_token WHERE employee_alias='".alias($emp_id,'ec_employee_master','employee_id','employee_alias')."' AND token='$token' AND flag=0");
	if(mysqli_num_rows($sql)){return '0';}else{return '-1';}
}
function listchecking($fv1,$fv2,$fv3){ global $mr_con;
	$rec=$mr_con->query("SELECT id FROM $fv1 WHERE $fv2='$fv3'");
	if($rec){
		if($rec->num_rows==0)return 0; else return 1;
	}else return 1;
}*/

/*include('mysql.php');
$arr=array('ec_battery_bank_bb_cap','ec_cell_required','ec_charger_details','ec_check_points','ec_coach_history','ec_customer_comments','ec_customer_satisfaction','ec_engineer_observation','ec_equip_details','ec_e_signature','ec_fork_lift','ec_general_observation','ec_physical_observation','ec_power_observation','ec_technical_observation','ec_ticket_action');
$arr2=array();
$ticket_alias='RZYBN3X1KK';
foreach($arr as $tbl){
	$a=mysqli_query($mr_con,"SELECT id FROM $tbl WHERE ticket_alias='$ticket_alias' AND flag=0");
	$count = mysqli_num_rows($a);
	if($count){$arr2=$tbl;}
	//$b=mysqli_query($mr_con,"DELETE FROM $tbl WHERE ticket_alias='$ticket_alias'");
}print_r($arr2);
//'ec_remarks',
*/
?>