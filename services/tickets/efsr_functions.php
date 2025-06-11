<?php

function getPhysicalObservations($ticket_alias) {
	global $mr_con;
	$noOfBanksQuery = "SELECT * FROM ec_no_of_banks WHERE ticket_alias = '$ticket_alias'";
	$noOfBanksSql = mysqli_query($mr_con, $noOfBanksQuery);
	$valuemanandinstall = [];
	$banksize = 0;
	while($row = mysqli_fetch_array($noOfBanksSql)) {
		$banksize = $row['bank_size'];
		$eachBank = [
			'manufaturing_date' => $row['mfg_date'],
			'installation_date' => $row['install_date'],
			'bbmake' => $row['bb_make'],
			'bbcapacity' => $row['bb_capacity'],
		];
		$valuemanandinstall[] = $eachBank;
	}
	$poQuery = "SELECT * FROM ec_physical_observation WHERE ticket_alias = '$ticket_alias'";
	$poSql = mysqli_query($mr_con, $poQuery);
	$poDetails = mysqli_fetch_array($poSql);
	$noofbank = [
		'banksize' => $banksize,
		'valuemanandinstall' => $valuemanandinstall
	];
	$go = explode(",",$poDetails['general_observation']);
	$general_observation = [];
	foreach($go as $each) {
		$value = [
			'value' => $each
		];
		$general_observation[] = $value;
	}
	return [
		'noofbank' => $noofbank,
		'any_leakage' => $poDetails['leakage'],
		'any_physical_damages' => $poDetails['physical_damages'],
		'battery_top' => $poDetails['battery_top'],
		'bb_condition' => $poDetails['bb_condition'],
		'dm_water_filling_type' => $poDetails['dm_water_filling_type'],
		'log_book' => $poDetails['log_book'],
		'terminal_torque' => $poDetails['terminal_torque'],
		'general_observation' => $general_observation
	];
}

function getChargerDetails($ticket_alias) {
	global $mr_con;
	$query = "SELECT * FROM ec_charger_details WHERE ticket_alias = '$ticket_alias'";
	$sql = mysqli_query($mr_con, $query);
	$details = mysqli_fetch_array($sql);
	return [
		'chager_serial_number' => $details['serial_no'],
		'charger_input' => $details['charger_input'],
		'charger_make' => $details['charger_band'],
		'charger_manu_date' => $details['manf_date'],
		'charger_type' => $details['charger_type'],
		'current_capacity' => $details['charger_capacity'],
		'equalize_charger_mode' => $details['equalize_charger_mode'],
		'high_voltage_cutoff' => $details['high_voltage_cutoff'],
		'max_current_limit' => $details['charging_current'],
		'volateg_regulation' => $details['voltage_regulation'],
		'voltage_ripple' => $details['voltage_ripple'],
		'charger_max_vol_limit' => [
			'value' => $details['voltage'],
			'image' => $details['charger_pic']
		],
	];
}

function batteryDetails($ticket_alias) {
	global $mr_con;
	$query = "SELECT * FROM ec_battery_details WHERE ticket_alias = '$ticket_alias'";
	$sql = mysqli_query($mr_con, $query);
	$details = mysqli_fetch_array($sql);
	return [
		//'battery_serial_no' => $details['fork_lift_model'],
		//'electrolyte_level' => $details['charger_input'],
		'forklift_install_date' => $details['forklift_install_date'],
		'forklift_manu_date' => $details['fork_lift_manf_date'],
		'forlift_capacity' => $details['forlift_capacity'],
		'forlift_make' => $details['fork_lift_brand'],
		'forlift_model' => $details['fork_lift_model'],
		'max_load_current' => $details['max_load_current'],
		'motor_capacity' => $details['motor_capacity'],
		'under_voltage_cutoff' => $details['under_voltage_cutoff'],
		'plug_type' => [
			'value' => $details['voltage'],
			'image' => $details['charger_pic']
		],
	];
}

function getForkLiftDetails($ticket_alias) {
	global $mr_con;
	$query = "SELECT * FROM ec_fork_lift WHERE ticket_alias = '$ticket_alias'";
	$sql = mysqli_query($mr_con, $query);
	$details = mysqli_fetch_array($sql);
	return [
		//'battery_serial_no' => $details['fork_lift_model'],
		//'electrolyte_level' => $details['charger_input'],
		'forklift_install_date' => $details['forklift_install_date'],
		'forklift_manu_date' => $details['fork_lift_manf_date'],
		'forlift_capacity' => $details['forlift_capacity'],
		'forlift_make' => $details['fork_lift_brand'],
		'forlift_model' => $details['fork_lift_model'],
		'max_load_current' => $details['max_load_current'],
		'motor_capacity' => $details['motor_capacity'],
		'under_voltage_cutoff' => $details['under_voltage_cutoff'],
		'plug_type' => [
			'value' => $details['voltage'],
			'image' => $details['charger_pic']
		],
	];
}

function serviceEngObservation($ticket_alias) {

	global $mr_con;
	$query = "SELECT * FROM ec_remarks WHERE item_alias = '$ticket_alias' and module = 'TT' and bucket = '8'";
	$sql = mysqli_query($mr_con, $query);
	$remarksDetails = mysqli_fetch_array($sql);
	$query = "SELECT * FROM ec_ticket_action WHERE ticket_alias = '$ticket_alias'";
	$sql = mysqli_query($mr_con, $query);
	$details = mysqli_fetch_array($sql);
	$signDetails = ec_ticket_sign($ticket_alias);
	print_r($details);exit;
	return []; 
	return [
		'action_taken_suggestion' => $details['observation'],
		'eng_image' => $details['fork_lift_manf_date'],
		'fault_code' => $details['faulty_code_alias'],
		'observation' => $remarksDetails['remarks'],
		'signature' => $details['signature'],
        'site_address' => $details['max_load_current'],
        
		'job_performed' => $details['motor_capacity'],
		'otherissue' => $details['under_voltage_cutoff'],
		'required_accessories' => $details['under_voltage_cutoff'],
		'required_cell' => $details['required_cell']
	];
}

function customerComments($ticket_alias) {

	global $mr_con;
	$query = "SELECT * FROM ec_fork_lift WHERE ticket_alias = '$ticket_alias'";
	$sql = mysqli_query($mr_con, $query);
	$details = mysqli_fetch_array($sql);
	return [
		//'battery_serial_no' => $details['fork_lift_model'],
		//'electrolyte_level' => $details['charger_input'],
		'forklift_install_date' => $details['forklift_install_date'],
		'forklift_manu_date' => $details['fork_lift_manf_date'],
		'forlift_capacity' => $details['forlift_capacity'],
		'forlift_make' => $details['fork_lift_brand'],
		'forlift_model' => $details['fork_lift_model'],
		'max_load_current' => $details['max_load_current'],
		'motor_capacity' => $details['motor_capacity'],
		'under_voltage_cutoff' => $details['under_voltage_cutoff'],
		'plug_type' => [
			'value' => $details['voltage'],
			'image' => $details['charger_pic']
		],
	];
}

function ec_ticket_action() {

	global $mr_con;
	$query = "SELECT * FROM ec_ticket_action WHERE ticket_alias = '$ticket_alias'";
	$sql = mysqli_query($mr_con, $query);
    $details = mysqli_fetch_array($sql);
    if(!$details) {
        return [];
    }
	return [
		'observation' => $details['observation']
	];
}

function ec_ticket_sign($ticket_alias) {

	global $mr_con;
	$query = "SELECT * FROM ec_e_signature WHERE ticket_alias = '$ticket_alias'";
	$sql = mysqli_query($mr_con, $query);
    $details = mysqli_fetch_array($sql);
    if(!$details) {
        return [];
	}
	print_r($details);
	exit;
}