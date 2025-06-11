<?php
date_default_timezone_set("Asia/Kolkata");
require ('../Slim/Slim.php');
include ('../mysql.php');
include ('../functions.php');
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->post('/coach_history_edit','coach_history_edit');
$app->post('/equip_details_edit','equip_details_edit');
$app->post('/check_points_edit','check_points_edit');
$app->post('/charger_details_edit','charger_details_edit');
$app->post('/fork_lift_edit','fork_lift_edit');
$app->post('/battery_details_edit','battery_details_edit');
$app->post('/general_obs_edit','general_obs_edit');
$app->post('/technical_obs_edit','technical_obs_edit');
$app->post('/physical_obs_edit','physical_obs_edit');
$app->post('/engineer_obs_edit','engineer_obs_edit');
$app->post('/customer_comments_edit','customer_comments_edit');
$app->post('/telecom_bb_edit','telecom_bb_edit');

$app->post('/bb_row_column_delete','bb_row_column_delete');
$app->post('/update_remarks','update_remarks');

$app->run();


/* other_issues_edit
invertor_details_edit
no_of_banks_edit
power_obs_edit
remarks
battery_bank_bb_cap
headers
customer_satisfaction
$other_issues_delete_sql=mysqli_query($mr_con,"UPDATE ec_other_issues SET flag=1 WHERE id='$id'");
$no_of_banks_delete_sql=mysqli_query($mr_con,"UPDATE ec_no_of_banks SET flag=1 WHERE id='$id'");
$remarks_delete_sql=mysqli_query($mr_con,"UPDATE ec_remarks SET flag=1 WHERE id='$id'");
*/

function other_issue_fun($id,$other_issue){ global $mr_con;
	$other_issue=mysqli_real_escape_string($mr_con,strtoupper($other_issue));
	$other_sql = mysqli_query($mr_con,"UPDATE ec_other_issues SET other_issue='$other_issue' WHERE id='$id' AND flag='0'");
	return ($other_sql ? TRUE : FALSE);
}
function other_issue_fun_insert($ticket_alias,$module,$other_issue){ global $mr_con;
	$other_alias = aliasCheck(generateRandomString(),'ec_other_issues','item_alias');
	$other_issue=mysqli_real_escape_string($mr_con,strtoupper($other_issue));
	$other_sql = mysqli_query($mr_con,"INSERT INTO ec_other_issues(ticket_alias,module,other_issue,item_alias)VALUES('$ticket_alias','$module','$other_issue','$other_alias')");
	return ($other_sql ? TRUE : FALSE);
}
function noofbank($id,$mfg_date,$install_date,$bb_make,$bb_capacity){ global $mr_con;
	$mfg_date=mysqli_real_escape_string($mr_con,strtoupper(dateFormat($mfg_date,"y")));
	$install_date=mysqli_real_escape_string($mr_con,strtoupper(dateFormat($install_date,"y")));
	$bb_make=mysqli_real_escape_string($mr_con,strtoupper($bb_make));
	$bb_capacity=mysqli_real_escape_string($mr_con,strtoupper($bb_capacity));
	$noof_sql = mysqli_query($mr_con,"UPDATE ec_no_of_banks SET mfg_date='$mfg_date',install_date='$install_date',bb_make='$bb_make',bb_capacity='$bb_capacity' WHERE id='$id' AND flag='0'");	
	return ($noof_sql ? TRUE : FALSE);
}

function coach_history_edit(){ global $mr_con;
	$emp_alias=$_REQUEST['emp_alias']; $token=$_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$no_of_banks_id = $_REQUEST['no_of_banks_id'];
		if(count($no_of_banks_id)){
			$bb_make = $_REQUEST['bb_make'];
			$bb_capacity = $_REQUEST['bb_capacity'];
			$mfdt_date = $_REQUEST['mfdt_date'];
			$installdt_date = $_REQUEST['installdt_date'];
			foreach($no_of_banks_id as $k=>$nbank_id)noofbank($nbank_id,$mfdt_date[$k],$installdt_date[$k],$bb_make[$k],$bb_capacity[$k]);
		}
		$id = mysqli_real_escape_string($mr_con,trim($_REQUEST['id']));
		$train_no = mysqli_real_escape_string($mr_con,trim($_REQUEST['train_no']));
		$express_name = mysqli_real_escape_string($mr_con,trim($_REQUEST['express_name']));
		$coach_no = mysqli_real_escape_string($mr_con,trim($_REQUEST['coach_no']));
		
		$pre_attnd = dateFormat(mysqli_real_escape_string($mr_con,trim($_REQUEST['pre_attnd'])),'y');
		$poh = dateFormat(mysqli_real_escape_string($mr_con,trim($_REQUEST['poh'])),'y');
		$rpoh = dateFormat(mysqli_real_escape_string($mr_con,trim($_REQUEST['rpoh'])),'y');
			
		$zone = mysqli_real_escape_string($mr_con,trim($_REQUEST['zone']));
		$division = mysqli_real_escape_string($mr_con,trim($_REQUEST['division']));
		$workshop = mysqli_real_escape_string($mr_con,trim($_REQUEST['workshop']));
		
		$coach_history_update_sql=mysqli_query($mr_con,"UPDATE ec_coach_history SET
		train_no='$train_no',
		express_name='$express_name',
		coach_no='$coach_no',
		pre_attnd='$pre_attnd',
		poh='$poh',
		rpoh='$rpoh',
		zone='$zone',
		division='$division',
		workshop='$workshop'
		WHERE id='$id' AND flag=0");
		$resCode='0';$resMsg='Success';
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}if(isset($res)){$resCode='4'; $resMsg=$res;}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function equip_details_edit(){ global $mr_con;
	$emp_alias=$_REQUEST['emp_alias']; $token=$_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$id = mysqli_real_escape_string($mr_con,trim($_REQUEST['id']));
		$altenate_make = mysqli_real_escape_string($mr_con,trim($_REQUEST['altenate_make']));
		$rru_make = mysqli_real_escape_string($mr_con,trim($_REQUEST['rru_make']));
		$invertor_make = mysqli_real_escape_string($mr_con,trim($_REQUEST['invertor_make']));
		$regulator_make = mysqli_real_escape_string($mr_con,trim($_REQUEST['regulator_make']));
		$voltage_regulation = mysqli_real_escape_string($mr_con,trim($_REQUEST['voltage_regulation']));
		$altenate_belt_status = mysqli_real_escape_string($mr_con,trim($_REQUEST['altenate_belt_status']));
		$alternator_capacity = mysqli_real_escape_string($mr_con,trim($_REQUEST['alternator_capacity']));
		$current_limit = mysqli_real_escape_string($mr_con,trim($_REQUEST['current_limit']));
		$equip_charger_cut_off = mysqli_real_escape_string($mr_con,trim($_REQUEST['equip_charger_cut_off']));
		$high_voltage_cut_off = mysqli_real_escape_string($mr_con,trim($_REQUEST['high_voltage_cut_off']));
		$invertor_mode = mysqli_real_escape_string($mr_con,trim($_REQUEST['invertor_mode']));
		$low_voltage_cut_off = mysqli_real_escape_string($mr_con,trim($_REQUEST['low_voltage_cut_off']));
		
		$equip_details_update_sql=mysqli_query($mr_con,"UPDATE ec_equip_details SET
		altenate_make='$altenate_make',
		rru_make='$rru_make',
		invertor_make='$invertor_make',
		regulator_make='$regulator_make',
		voltage_regulation='$voltage_regulation',
		altenate_belt_status='$altenate_belt_status',
		alternator_capacity='$alternator_capacity',
		current_limit='$current_limit',
		equip_charger_cut_off='$equip_charger_cut_off',
		high_voltage_cut_off='$high_voltage_cut_off',
		invertor_mode='$invertor_mode',
		low_voltage_cut_off='$low_voltage_cut_off'
		WHERE id='$id' AND flag=0");
		$resCode='0';$resMsg='Success';
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}if(isset($res)){$resCode='4'; $resMsg=$res;}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function check_points_edit(){ global $mr_con;
	$emp_alias=$_REQUEST['emp_alias']; $token=$_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$id = mysqli_real_escape_string($mr_con,trim($_REQUEST['id']));
		$icc_tightness = mysqli_real_escape_string($mr_con,trim($_REQUEST['icc_tightness']));
		$heating_melting_marks = mysqli_real_escape_string($mr_con,trim($_REQUEST['heating_melting_marks']));
		$terminal_tightness = mysqli_real_escape_string($mr_con,trim($_REQUEST['terminal_tightness']));
		$alt_no_belt_avl = mysqli_real_escape_string($mr_con,trim($_REQUEST['alt_no_belt_avl']));
		$vent_plug_tightness = mysqli_real_escape_string($mr_con,trim($_REQUEST['vent_plug_tightness']));
		$belt = mysqli_real_escape_string($mr_con,trim($_REQUEST['belt']));
		$log_book = mysqli_real_escape_string($mr_con,trim($_REQUEST['log_book']));
		$cell_buldge = mysqli_real_escape_string($mr_con,trim($_REQUEST['cell_buldge']));
		$terminal_temp = mysqli_real_escape_string($mr_con,trim($_REQUEST['terminal_temp']));
		$coach_status = strtoupper(implode(", ",$_REQUEST['coach_status']));
		$physical_damage = mysqli_real_escape_string($mr_con,trim($_REQUEST['physical_damage']));
		if($physical_damage=='YES'){
			$physical_condition = strtoupper(implode(", ",$_REQUEST['physical_condition']));
		}
		$leakage = mysqli_real_escape_string($mr_con,trim($_REQUEST['leakage']));
		if($leakage=='YES'){
			$leakage_condition = strtoupper(implode(", ",$_REQUEST['leakage_condition']));
		}
		
		$check_points_update_sql=mysqli_query($mr_con,"UPDATE ec_check_points SET
		icc_tightness='$icc_tightness',
		heating_melting_marks='$heating_melting_marks',
		terminal_tightness='$terminal_tightness',
		alt_no_belt_avl='$alt_no_belt_avl',
		vent_plug_tightness='$vent_plug_tightness',
		belt='$belt',
		log_book='$log_book',
		coach_status='$coach_status',
		cell_buldge='$cell_buldge',
		terminal_temp='$terminal_temp',
		physical_damage='$physical_damage',
		leakage='$leakage',
		physical_condition='$physical_condition',
		leakage_condition='$leakage_condition'
		WHERE id='$id' AND flag=0");
		$resCode='0';$resMsg='Success';
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}if(isset($res)){$resCode='4'; $resMsg=$res;}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function charger_details_edit(){ global $mr_con;
	$emp_alias=$_REQUEST['emp_alias']; $token=$_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$con = "";
		$id = mysqli_real_escape_string($mr_con,trim($_REQUEST['id']));
		$charger_type = mysqli_real_escape_string($mr_con,trim($_REQUEST['charger_type']));
		$manf_date = dateFormat(mysqli_real_escape_string($mr_con,trim($_REQUEST['charger_manufacturing_date'])),'y');
		$serial_no = mysqli_real_escape_string($mr_con,trim($_REQUEST['serial_no']));
		$charging_current = mysqli_real_escape_string($mr_con,trim($_REQUEST['charging_current']));
		$high_voltage_cutoff = mysqli_real_escape_string($mr_con,trim($_REQUEST['high_voltage_cutoff']));
		$voltage_ripple = mysqli_real_escape_string($mr_con,trim($_REQUEST['voltage_ripple']));
		$voltage_regulation = mysqli_real_escape_string($mr_con,trim($_REQUEST['voltage_regulation']));
		$charger_capacity = mysqli_real_escape_string($mr_con,trim($_REQUEST['charger_capacity']));
		$charger_input = mysqli_real_escape_string($mr_con,trim($_REQUEST['charger_input']));
		if(isset($_REQUEST['equalize_charger_mode']))$con .= "equalize_charger_mode = '" . mysqli_real_escape_string($mr_con,trim($_REQUEST['equalize_charger_mode'])) . "',";
		if(isset($_REQUEST['valueofequalize']))$con .= "valueofequalize = '" . strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['valueofequalize']))) . "',";
		$voltage = mysqli_real_escape_string($mr_con,trim($_REQUEST['voltage']));
		$charger_band = mysqli_real_escape_string($mr_con,trim($_REQUEST['charger_band']));
		
		$charger_details_update_sql=mysqli_query($mr_con,"UPDATE ec_charger_details SET
		charger_band='$charger_band',
		manf_date='$manf_date',
		serial_no='$serial_no',
		charger_type='$charger_type',
		voltage='$voltage',
		charging_current='$charging_current',
		charger_capacity='$charger_capacity',
		high_voltage_cutoff='$high_voltage_cutoff',
		voltage_ripple='$voltage_ripple',
		voltage_regulation='$voltage_regulation',
		charger_input='$charger_input',
		$con flag=0
		WHERE id='$id' AND flag=0");
		$resCode='0';$resMsg='Success';
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}if(isset($res)){$resCode='4'; $resMsg=$res;}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function fork_lift_edit(){ global $mr_con;
	$emp_alias=$_REQUEST['emp_alias']; $token=$_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$id = mysqli_real_escape_string($mr_con,trim($_REQUEST['id']));
		$fork_lift_brand = mysqli_real_escape_string($mr_con,trim($_REQUEST['fork_lift_brand']));
		$fork_lift_model = mysqli_real_escape_string($mr_con,trim($_REQUEST['fork_lift_model']));
		$fork_lift_manf_date = dateFormat(mysqli_real_escape_string($mr_con,trim($_REQUEST['fork_lift_manf_date'])),'y');
		$forklift_install_date = dateFormat(mysqli_real_escape_string($mr_con,trim($_REQUEST['forklift_install_date'])),'y');
		$forlift_capacity = mysqli_real_escape_string($mr_con,trim($_REQUEST['forlift_capacity']));
		$motor_capacity = mysqli_real_escape_string($mr_con,trim($_REQUEST['motor_capacity']));
		$under_voltage_cutoff = mysqli_real_escape_string($mr_con,trim($_REQUEST['under_voltage_cutoff']));
		$max_load_current = mysqli_real_escape_string($mr_con,trim($_REQUEST['max_load_current']));
		
		$fork_lift_update_sql=mysqli_query($mr_con,"UPDATE ec_fork_lift SET
		fork_lift_brand='$fork_lift_brand',
		fork_lift_model='$fork_lift_model',
		fork_lift_manf_date='$fork_lift_manf_date',
		forklift_install_date='$forklift_install_date',
		forlift_capacity='$forlift_capacity',
		motor_capacity='$motor_capacity',
		under_voltage_cutoff='$under_voltage_cutoff',
		max_load_current='$max_load_current'
		WHERE id='$id' AND flag=0");
		$resCode='0';$resMsg='Success';
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}if(isset($res)){$resCode='4'; $resMsg=$res;}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function battery_details_edit(){ global $mr_con;
	$emp_alias=$_REQUEST['emp_alias']; $token=$_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$id = mysqli_real_escape_string($mr_con,trim($_REQUEST['id']));
		//$battey_type = mysqli_real_escape_string($mr_con,trim($_REQUEST['battey_type']));
		$bank_serial_no = mysqli_real_escape_string($mr_con,trim($_REQUEST['bank_serial_no']));
		//$manf_date = dateFormat(mysqli_real_escape_string($mr_con,trim($_REQUEST['battey_manf_date'])),'y');
		//$ins_date = dateFormat(mysqli_real_escape_string($mr_con,trim($_REQUEST['battey_ins_date'])),'y');
		$plug_type = strtoupper(implode(", ",$_REQUEST['plug_type']));
		$acid_level = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['acid_level'])));
		
		/* battey_type='$battey_type',
		manf_date='$manf_date',
		ins_date='$ins_date', */
		$battery_details_update_sql=mysqli_query($mr_con,"UPDATE ec_battery_details SET
		bank_serial_no='$bank_serial_no',
		plug_type='$plug_type',
		acid_level='$acid_level'
		WHERE id='$id' AND flag=0");
		$resCode='0';$resMsg='Success';
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}if(isset($res)){$resCode='4'; $resMsg=$res;}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function general_obs_edit(){ global $mr_con;
	$emp_alias=$_REQUEST['emp_alias']; $token=$_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$ticket_alias = mysqli_real_escape_string($mr_con,trim($_REQUEST['ticket_alias']));
		$other_id = mysqli_real_escape_string($mr_con,trim($_REQUEST['GNRLOBS_other_id']));
		$other_issue = mysqli_real_escape_string($mr_con,trim($_REQUEST['GNRLOBS_other_issue']));
		if(isset($other_id) && !empty($other_id))other_issue_fun($other_id,$other_issue);
		if(!isset($other_id) && !empty($other_issue))other_issue_fun_insert($ticket_alias,"GNRLOBS",$other_issue);
		
		$id = mysqli_real_escape_string($mr_con,trim($_REQUEST['id']));
		$site_load = mysqli_real_escape_string($mr_con,trim($_REQUEST['site_load']));
		$dg_make = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['dg_make'])));
		$dg_capacity = mysqli_real_escape_string($mr_con,trim($_REQUEST['dg_capacity']));
		$dg_working_condition = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['dg_working_condition'])));
		$avg_dg_run = mysqli_real_escape_string($mr_con,trim($_REQUEST['avg_dg_run']));
		$dg_output = mysqli_real_escape_string($mr_con,trim($_REQUEST['dg_output']));
		//$dg_status = mysqli_real_escape_string($mr_con,trim($_REQUEST['dg_status']));
		/* dg_status='$dg_status', */
		$general_obs_update_sql=mysqli_query($mr_con,"UPDATE ec_general_observation SET
		site_load='$site_load',
		dg_make='$dg_make',
		dg_capacity='$dg_capacity',
		dg_working_condition='$dg_working_condition',
		avg_dg_run='$avg_dg_run',
		dg_output='$dg_output'
		WHERE id='$id' AND flag=0");
		
		$power_id = mysqli_real_escape_string($mr_con,trim($_REQUEST['power_id']));
		$failures_per_day = mysqli_real_escape_string($mr_con,trim($_REQUEST['failures_per_day']));
		$avg_power_cut = mysqli_real_escape_string($mr_con,trim($_REQUEST['avg_power_cut']));
		$ebinstalldate=mysqli_real_escape_string($mr_con,dateFormat($_REQUEST['ebinstalldate'],"y"));
		//$eb_supply = mysqli_real_escape_string($mr_con,trim($_REQUEST['eb_supply']));
		/* eb_supply='$eb_supply', */
		$general_obs_update_sql=mysqli_query($mr_con,"UPDATE ec_power_observation SET
		failures_per_day='$failures_per_day',
		avg_power_cut='$avg_power_cut',
		ebinstalldate='$ebinstalldate'
		WHERE id='$power_id' AND flag=0");
		$resCode='0';$resMsg='Success';
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}if(isset($res)){$resCode='4'; $resMsg=$res;}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function technical_obs_edit(){ global $mr_con;
	$emp_alias=$_REQUEST['emp_alias']; $token=$_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		if(isset($_REQUEST['id']))
		for($i=0;$i<count($_REQUEST['id']);$i++){
			$id = mysqli_real_escape_string($mr_con,trim($_REQUEST['id'][$i]));
			$float_voltage = mysqli_real_escape_string($mr_con,trim($_REQUEST['float_voltage'][$i]));
			$boast_voltage = mysqli_real_escape_string($mr_con,trim($_REQUEST['boast_voltage'][$i]));
			$current_limit = mysqli_real_escape_string($mr_con,trim($_REQUEST['current_limit'][$i]));
			$voltage_ripple = mysqli_real_escape_string($mr_con,trim($_REQUEST['voltage_ripple'][$i]));
			$high_voltage_cutoff = mysqli_real_escape_string($mr_con,trim($_REQUEST['high_voltage_cutoff'][$i]));
			$low_voltage_cutoff = mysqli_real_escape_string($mr_con,trim($_REQUEST['low_voltage_cutoff'][$i]));
			$panel_make = mysqli_real_escape_string($mr_con,trim($_REQUEST['panel_make'][$i]));
			$panel_rating = mysqli_real_escape_string($mr_con,trim($_REQUEST['panel_rating'][$i]));
			$panel_manufacturing_date = dateFormat(mysqli_real_escape_string($mr_con,trim($_REQUEST['panel_manufacturing_date'][$i])),"y");
			if(isset($_REQUEST['panel_installation_date'][$i]) && !empty($_REQUEST['panel_installation_date'][$i])) $panel_installation_date = dateFormat(mysqli_real_escape_string($mr_con,trim($_REQUEST['panel_installation_date'][$i])),"y");
			else $panel_installation_date = "";
			$auto_boost = mysqli_real_escape_string($mr_con,trim($_REQUEST['auto_boost'][$i]));
			$temp_compensation = mysqli_real_escape_string($mr_con,trim($_REQUEST['temp_compensation'][$i]));
			$voltage_regulation = mysqli_real_escape_string($mr_con,trim($_REQUEST['voltage_regulation'][$i]));
			$charge_controller_rate = mysqli_real_escape_string($mr_con,trim($_REQUEST['charge_controller_rate'][$i]));
			$charge_controller_make = mysqli_real_escape_string($mr_con,trim($_REQUEST['charge_controller_make'][$i]));
			$solar_system_rating = mysqli_real_escape_string($mr_con,trim($_REQUEST['solar_system_rating'][$i]));
			$single_module_rating = mysqli_real_escape_string($mr_con,trim($_REQUEST['single_module_rating'][$i]));
			$single_pv_moddule_rating_current = mysqli_real_escape_string($mr_con,trim($_REQUEST['single_pv_moddule_rating_current'][$i]));
			$pv_module_eff = mysqli_real_escape_string($mr_con,trim($_REQUEST['pv_module_eff'][$i]));
			$single_panel_rating = mysqli_real_escape_string($mr_con,trim($_REQUEST['single_panel_rating'][$i]));
			$charge_control_manufacturing_date = dateFormat(mysqli_real_escape_string($mr_con,trim($_REQUEST['charge_control_manufacturing_date'][$i])),"y");
			$no_solar_panels = mysqli_real_escape_string($mr_con,trim($_REQUEST['no_solar_panels'][$i]));
			$site_load = mysqli_real_escape_string($mr_con,trim($_REQUEST['site_load'][$i]));
			$site_input = mysqli_real_escape_string($mr_con,trim($_REQUEST['site_input'][$i]));
			$technical_obs_update_sql=mysqli_query($mr_con,"UPDATE ec_technical_observation SET
			float_voltage='$float_voltage',
			boast_voltage='$boast_voltage',
			current_limit='$current_limit',
			voltage_ripple='$voltage_ripple',
			voltage_regulation='$voltage_regulation',
			high_voltage_cutoff='$high_voltage_cutoff',
			low_voltage_cutoff='$low_voltage_cutoff',
			panel_make='$panel_make',
			panel_rating='$panel_rating',
			charge_controller_rate='$charge_controller_rate',
			charge_controller_make='$charge_controller_make',
			no_solar_panels='$no_solar_panels',
			single_panel_rating='$single_panel_rating',
			panel_manufacturing_date='$panel_manufacturing_date',
			charge_control_manufacturing_date='$charge_control_manufacturing_date',
			panel_installation_date='$panel_installation_date',
			auto_boost='$auto_boost',
			temp_compensation='$temp_compensation',
			solar_system_rating='$solar_system_rating',
			single_module_rating='$single_module_rating',
			single_pv_moddule_rating_current='$single_pv_moddule_rating_current',
			pv_module_eff='$pv_module_eff',
			site_load='$site_load',
			site_input='$site_input'
			WHERE id='$id' AND flag=0");
		}
		
		$ticket_alias = mysqli_real_escape_string($mr_con,trim($_REQUEST['ticket_alias']));
		$other_id = mysqli_real_escape_string($mr_con,trim($_REQUEST['TLOBS_other_id']));
		$other_issue = mysqli_real_escape_string($mr_con,trim($_REQUEST['TLOBS_other_issue']));
		if(isset($other_id) && !empty($other_id))other_issue_fun($other_id,$other_issue);
		if(!isset($other_id) && !empty($other_issue))other_issue_fun_insert($ticket_alias,"TLOBS",$other_issue);
		
		if(isset($_REQUEST['invertor_make']))
		for($i=0;$i<count($_REQUEST['invertor_make']);$i++){
			$invertor_details_id = mysqli_real_escape_string($mr_con,trim($_REQUEST['invertor_details_id'][$i]));
			$invertor_make = mysqli_real_escape_string($mr_con,trim($_REQUEST['invertor_make'][$i]));
			$invertor_capacity = mysqli_real_escape_string($mr_con,trim($_REQUEST['invertor_capacity'][$i]));
			$invertor_manu_date = dateFormat(mysqli_real_escape_string($mr_con,trim($_REQUEST['invertor_manu_date'][$i])),"y");
			$invertor_install_date = dateFormat(mysqli_real_escape_string($mr_con,trim($_REQUEST['invertor_install_date'][$i])),"y");
			$invertor_type = mysqli_real_escape_string($mr_con,trim($_REQUEST['invertor_type'][$i]));
			$invertor_load_current = mysqli_real_escape_string($mr_con,trim($_REQUEST['invertor_load_current'][$i]));
			$low_voltage_cutoff_inv = mysqli_real_escape_string($mr_con,trim($_REQUEST['low_voltage_cutoff_inv'][$i]));
			if(isset($invertor_details_id) && !empty($invertor_details_id)){
				$invertor_update_sql=mysqli_query($mr_con,"UPDATE ec_invertor_details SET
					invertor_make='$invertor_make',
					invertor_capacity='$invertor_capacity',
					invertor_manu_date='$invertor_manu_date',
					invertor_install_date='$invertor_install_date',
					invertor_type='$invertor_type',
					invertor_load_current='$invertor_load_current',
					low_voltage_cutoff_inv='$low_voltage_cutoff_inv'
				WHERE id='$invertor_details_id' AND flag=0");
			}else $invertor_sql = mysqli_query($mr_con,"INSERT INTO ec_invertor_details(ticket_alias,invertor_make,invertor_capacity,invertor_manu_date,invertor_install_date,invertor_type,invertor_load_current,low_voltage_cutoff_inv)VALUES('$ticket_alias','$invertor_make','$invertor_capacity','$invertor_manu_date','$invertor_install_date','$invertor_type','$invertor_load_current','$low_voltage_cutoff_inv')");
		}
		$resCode='0';$resMsg='Success';
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}if(isset($res)){$resCode='4'; $resMsg=$res;}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function physical_obs_edit(){ global $mr_con;
	$emp_alias=$_REQUEST['emp_alias']; $token=$_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$no_of_banks_id = $_REQUEST['no_of_banks_id'];
		if(count($no_of_banks_id)){
			$bb_make = $_REQUEST['bb_make'];
			$bb_capacity = $_REQUEST['bb_capacity'];
			$mfdt_date = $_REQUEST['mfdt_date'];
			$installdt_date = $_REQUEST['installdt_date'];
			foreach($no_of_banks_id as $k=>$nbank_id)noofbank($nbank_id,$mfdt_date[$k],$installdt_date[$k],$bb_make[$k],$bb_capacity[$k]);
		}
		
		$ticket_alias = mysqli_real_escape_string($mr_con,trim($_REQUEST['ticket_alias']));
		$other_idM = mysqli_real_escape_string($mr_con,trim($_REQUEST['MTPWR_other_id']));
		$other_issueM = mysqli_real_escape_string($mr_con,trim($_REQUEST['MTPWR_other_issue']));
		if(isset($other_idM) && !empty($other_idM))other_issue_fun($other_idM,$other_issueM);
		if(!isset($other_idM) && !empty($other_issueM))other_issue_fun_insert($ticket_alias,"MTPWR",$other_issueM);
		
		$other_idP = mysqli_real_escape_string($mr_con,trim($_REQUEST['PHYOBS_other_id']));
		$other_issueP = mysqli_real_escape_string($mr_con,trim($_REQUEST['PHYOBS_other_issue']));
		if(isset($other_idP) && !empty($other_idP))other_issue_fun($other_idP,$other_issueP);
		if(!isset($other_idP) && !empty($other_issueP))other_issue_fun_insert($ticket_alias,"PHYOBS",$other_issueP);
		
		$id = mysqli_real_escape_string($mr_con,trim($_REQUEST['id']));
		
		//$bb_condition = mysqli_real_escape_string($mr_con,trim($_REQUEST['bb_condition']));
		
		$physical_condition = mysqli_real_escape_string($mr_con,trim($_REQUEST['physical_condition']));
		$leakage_condition = mysqli_real_escape_string($mr_con,trim($_REQUEST['leakage_condition']));
		
		if($physical_condition == 'YES'){
			$physical_damages = strtoupper(implode(", ",$_REQUEST['physical_damages']));
		}else $physical_damages = 'NO';
		
		if($leakage_condition == 'YES'){
			$leakage = strtoupper(implode(", ",$_REQUEST['leakage']));
		}else $leakage = 'NO';
		
		$torque = mysqli_real_escape_string($mr_con,trim($_REQUEST['torque']));
		if($torque=='LOOSE'){
			$torque_loose = mysqli_real_escape_string($mr_con,trim($_REQUEST['torque_loose']));
			$torque_perfect = mysqli_real_escape_string($mr_con,trim($_REQUEST['torque_perfect']));
			$terminal_torque = $torque ."|". $torque_loose ."|". $torque_perfect;
		}else $terminal_torque = $torque;
		
		$vent_type = mysqli_real_escape_string($mr_con,trim($_REQUEST['vent_type']));
		if($vent_type=='LOOSE'){
			$vent_loose = mysqli_real_escape_string($mr_con,trim($_REQUEST['vent_loose']));
			$vent_perfect = mysqli_real_escape_string($mr_con,trim($_REQUEST['vent_perfect']));
			$vent_plug_thickness = $vent_type ."|". $vent_loose ."|". $vent_perfect;
		}else $vent_plug_thickness = $vent_type;
		
		$temperature_type = mysqli_real_escape_string($mr_con,trim($_REQUEST['temperature_type']));
		if(empty($temperature_type))$temperature_type = "INDOOR";
		else $temp_data = strtoupper(implode(", ",$_REQUEST['temp_data']));
		$room_temperature = mysqli_real_escape_string($mr_con,trim($_REQUEST['temperature']));
		$ambient_temperature = mysqli_real_escape_string($mr_con,trim($_REQUEST['ambient_temperature']));
		$temperature=$temperature_type."|".$room_temperature."|".$ambient_temperature;
		
		$general_observation = strtoupper(implode(", ",$_REQUEST['general_observation']));
		
		$battery_top = mysqli_real_escape_string($mr_con,trim($_REQUEST['battery_top']));
		$acid_temp_discharge = mysqli_real_escape_string($mr_con,trim($_REQUEST['acid_temp_discharge']));
		$acid_temp_charge = mysqli_real_escape_string($mr_con,trim($_REQUEST['acid_temp_charge']));
		$cells_temp_after_use = mysqli_real_escape_string($mr_con,trim($_REQUEST['cells_temp_after_use']));
		$cells_temp_at_charge = mysqli_real_escape_string($mr_con,trim($_REQUEST['cells_temp_at_charge']));
		
		$electrolyte_temp_before = mysqli_real_escape_string($mr_con,trim($_REQUEST['electrolyte_temp_before']));
		$electrolyte_temp_after = mysqli_real_escape_string($mr_con,trim($_REQUEST['electrolyte_temp_after']));
		
		$electrolyte_temp_before_hr = mysqli_real_escape_string($mr_con,trim($_REQUEST['electrolyte_temp_before_hr']));
		$electrolyte_temp_before_restperiod = mysqli_real_escape_string($mr_con,trim($_REQUEST['electrolyte_temp_before_restperiod']));
		$electrolyte_temp_before_restperiod = $electrolyte_temp_before_restperiod . "|" .$electrolyte_temp_before_hr;
		
		$electrolyte_temp_after_hr = mysqli_real_escape_string($mr_con,trim($_REQUEST['electrolyte_temp_after_hr']));
		$electrolyte_temp_after_restperiod = mysqli_real_escape_string($mr_con,trim($_REQUEST['electrolyte_temp_after_restperiod']));
		$electrolyte_temp_after_restperiod = $electrolyte_temp_after_restperiod . "|" .$electrolyte_temp_after_hr;
		
		$dm_water_filling_type = mysqli_real_escape_string($mr_con,trim($_REQUEST['dm_water_filling_type']));
		$log_book = mysqli_real_escape_string($mr_con,trim($_REQUEST['log_book']));
		
		//bb_condition='$bb_condition',
		$physical_obs_update_sql=mysqli_query($mr_con,"UPDATE ec_physical_observation SET
		physical_damages='$physical_damages',
		leakage='$leakage',
		temperature='$temperature',
		temp_data='$temp_data',
		battery_top='$battery_top',
		general_observation='$general_observation',
		acid_temp_discharge='$acid_temp_discharge',
		acid_temp_charge='$acid_temp_charge',
		cells_temp_after_use='$cells_temp_after_use',
		cells_temp_at_charge='$cells_temp_at_charge',
		electrolyte_temp_before='$electrolyte_temp_before',
		electrolyte_temp_after='$electrolyte_temp_after',
		electrolyte_temp_before_restperiod='$electrolyte_temp_before_restperiod',
		electrolyte_temp_after_restperiod='$electrolyte_temp_after_restperiod',
		dm_water_filling_type='$dm_water_filling_type',
		terminal_torque='$terminal_torque',
		vent_plug_thickness='$vent_plug_thickness',
		log_book='$log_book'
		WHERE id='$id' AND flag=0");
		$resCode='0';$resMsg='Success';
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}if(isset($res)){$resCode='4'; $resMsg=$res;}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function engineer_obs_edit(){ global $mr_con;
	$emp_alias=$_REQUEST['emp_alias']; $token=$_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$other_id = $_REQUEST['other_id'];
		if(count($other_id)){
			$other_issue = $_REQUEST['other_issue'];
			foreach($other_id as $k=>$other)other_issue_fun($other,$other_issue[$k]);
		}
		$ticket_alias = mysqli_real_escape_string($mr_con,trim($_REQUEST['ticket_alias']));
		$other_issue_extra = $_REQUEST['other_issue_extra'];
		if(isset($other_issue_extra) && count($other_issue_extra))
		foreach($other_issue_extra as $k=>$other_extra)
		if(!empty($other_extra))other_issue_fun_insert($ticket_alias,"SEOBS",$other_extra);
		
		$remarks = mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks']));
		if(!empty($remarks)){
			$remarks_id = mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks_id']));
			$remarks_update_sql=mysqli_query($mr_con,"UPDATE ec_remarks SET remarks='$remarks' WHERE id='$remarks_id' AND flag=0");
		}
		$action_taken = mysqli_real_escape_string($mr_con,trim($_REQUEST['action_taken']));
		if(!empty($action_taken)){
			$action_taken_id = mysqli_real_escape_string($mr_con,trim($_REQUEST['action_taken_id']));
			$action_taken_update_sql=mysqli_query($mr_con,"UPDATE ec_ticket_action SET observation='$action_taken' WHERE id='$action_taken_id' AND flag=0");
		}
		$id = mysqli_real_escape_string($mr_con,trim($_REQUEST['id']));
		$faulty_code_alias = mysqli_real_escape_string($mr_con,trim($_REQUEST['faulty_code']));
		$req_cells = $req_acc = [];
		if(count($_REQUEST['req_cells'])){
			foreach($_REQUEST['req_cells'] as $k=>$reqCell){
				$req_cell_qty = mysqli_real_escape_string($mr_con,trim($_REQUEST['req_cell_qty'][$k]));
				if($req_cell_qty > 0){
					$reqCell = mysqli_real_escape_string($mr_con,trim($reqCell));
					$req_cells[] = $reqCell."-(" . $req_cell_qty . ")";
				}
			}
		}
		if(count($_REQUEST['req_acc'])){
			foreach($_REQUEST['req_acc'] as $k=>$reqAcc){
				$req_acc_qty = mysqli_real_escape_string($mr_con,trim($_REQUEST['req_acc_qty'][$k]));
				if($req_acc_qty > 0){
					$reqAcc = mysqli_real_escape_string($mr_con,trim($reqAcc));
					$req_acc[] = $reqAcc."-(" . $req_acc_qty . ")";
				}
			}
		}
			
		$faulty_cell_sr_no = mysqli_real_escape_string($mr_con,trim($_REQUEST['faulty_cell_sr_no']));
		$faulty_cell_sr_no = str_replace(",",", ",str_replace(" ","",$faulty_cell_sr_no));
		$total_faulty_count = (!empty($faulty_cell_sr_no) ? count(explode(",",str_replace(" ","",$faulty_cell_sr_no))) : 0);
		
		$jobperformed = $_REQUEST['job_performed'];
		if(count($jobperformed))$job_performed = strtoupper(implode(", ",$jobperformed));
		
		//"replaced_cell_no='$replaced_cell_no',";
		$engineer_obs_update_sql=mysqli_query($mr_con,"UPDATE ec_engineer_observation SET
		faulty_code_alias='$faulty_code_alias',
		req_acc='".implode(", ",$req_acc)."',
		req_cells='".implode(", ",$req_cells)."',
		total_faulty_count='$total_faulty_count',
		faulty_cell_sr_no='$faulty_cell_sr_no',
		job_performed='$job_performed'
		WHERE id='$id' AND flag=0");
		$resCode='0';$resMsg='Success';
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}if(isset($res)){$resCode='4'; $resMsg=$res;}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function customer_comments_edit(){ global $mr_con;
	$emp_alias=$_REQUEST['emp_alias']; $token=$_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$id = mysqli_real_escape_string($mr_con,trim($_REQUEST['id']));
		$name = mysqli_real_escape_string($mr_con,trim($_REQUEST['e_sig_name']));
		$designation = mysqli_real_escape_string($mr_con,trim($_REQUEST['e_sig_designation']));
		$contact_number = mysqli_real_escape_string($mr_con,trim($_REQUEST['e_sig_contact_number']));
		$email = mysqli_real_escape_string($mr_con,trim($_REQUEST['e_sig_email']));
		$e_signature_update_sql=mysqli_query($mr_con,"UPDATE ec_e_signature SET
		name='$name',
		designation='$designation',
		contact_number='$contact_number',
		email='$email'
		WHERE id='$id' AND flag=0");
		
		$customer_comments = mysqli_real_escape_string($mr_con,trim($_REQUEST['e_sig_customer_comments']));
		$customer_comment_id = mysqli_real_escape_string($mr_con,trim($_REQUEST['customer_comment_id']));
		$e_comments_update_sql=mysqli_query($mr_con,"UPDATE ec_customer_comments SET customer_comments='$customer_comments' WHERE id='$customer_comment_id' AND flag=0");
		
		$customer_satis_id = mysqli_real_escape_string($mr_con,trim($_REQUEST['customer_satis_id']));
		$q1 = mysqli_real_escape_string($mr_con,trim($_REQUEST['q1']));
		$q2 = mysqli_real_escape_string($mr_con,trim($_REQUEST['q2']));
		$q3 = mysqli_real_escape_string($mr_con,trim($_REQUEST['q3']));
		$q4 = mysqli_real_escape_string($mr_con,trim($_REQUEST['q4']));
		$q5 = mysqli_real_escape_string($mr_con,trim($_REQUEST['q5']));
		$customer_satis_update_sql=mysqli_query($mr_con,"UPDATE ec_customer_satisfaction SET
		q1='$q1',
		q2='$q2',
		q3='$q3',
		q4='$q4',
		q5='$q5'
		WHERE id='$customer_satis_id' AND flag=0");
		$resCode='0';$resMsg='Success';
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}if(isset($res)){$resCode='4'; $resMsg=$res;}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function telecom_bb_edit(){ global $mr_con;
	$emp_alias=$_REQUEST['emp_alias']; $token=$_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$bankid = $_REQUEST['bankid'];
		//$bank_rating = $_REQUEST['bank_rating'];
		$row_id = $_REQUEST['row_id'];
		$rowm_id = $_REQUEST['rowm_id'];
		$cell_sl_no = $_REQUEST['cellSlNo'];
		$mf_date = $_REQUEST['mf_date'];
		$ocv = (isset($_REQUEST['ocv']) ? $_REQUEST['ocv'] : [] );
		$sg_ocv = (isset($_REQUEST['sg_ocv']) ? $_REQUEST['sg_ocv'] : [] );
		$acid_density = (isset($_REQUEST['acid_density']) ? $_REQUEST['acid_density'] : [] );
		$battery_Volts = $_REQUEST['battery_Volts'];
		$battery_Volts_a = $_REQUEST['battery_Volts_a'];
		$battery_Volts_b = $_REQUEST['battery_Volts_b'];
		$bb_remarks = $_REQUEST['bb_remarks'];
		$bb_ter_o = $_REQUEST['bb_ter_o'];
		$bb_ter_a = $_REQUEST['bb_ter_a'];
		$bb_ter_b = $_REQUEST['bb_ter_b'];
		$bb_ter_c = $_REQUEST['bb_ter_c'];
		$cCurrent_o = $_REQUEST['cCurrent_o'];
		$cCurrent_a = $_REQUEST['cCurrent_a'];
		$cCurrent_b = $_REQUEST['cCurrent_b'];
		$cCurrent_c = $_REQUEST['cCurrent_c'];
		$charge_o = $_REQUEST['charge_o'];
		$charge_a = $_REQUEST['charge_a'];
		$charge_b = $_REQUEST['charge_b'];
		$charge_c = $_REQUEST['charge_c'];
		$header_o = $_REQUEST['header_o'];
		$header_a = $_REQUEST['header_a'];
		$header_b = $_REQUEST['header_b'];
		$header_c = $_REQUEST['header_c'];
		$hdr_o_id = $_REQUEST['hdr_o_id'];
		$hdr_a_id = $_REQUEST['hdr_a_id'];
		$hdr_b_id = $_REQUEST['hdr_b_id'];
		$hdr_c_id = $_REQUEST['hdr_c_id'];
		if(isset($_REQUEST['temp_o']) || isset($_REQUEST['temp_a']) || isset($_REQUEST['temp_b']) || isset($_REQUEST['temp_c'])){
			$temp_o = $_REQUEST['temp_o'];
			$temp_a = $_REQUEST['temp_a'];
			$temp_b = $_REQUEST['temp_b'];
			$temp_c = $_REQUEST['temp_c'];
		}else{
			$temp_o = array_map(function($a, $b) { return $a . '|' . $b; }, $_REQUEST['temp_o_min'], $_REQUEST['temp_o_max']);
			$temp_a = array_map(function($a, $b) { return $a . '|' . $b; }, $_REQUEST['temp_a_min'], $_REQUEST['temp_a_max']);
			$temp_b = array_map(function($a, $b) { return $a . '|' . $b; }, $_REQUEST['temp_b_min'], $_REQUEST['temp_b_max']);
			$temp_c = array_map(function($a, $b) { return $a . '|' . $b; }, $_REQUEST['temp_c_min'], $_REQUEST['temp_c_max']);
		}
		$tVoltage_o = $_REQUEST['tVoltage_o'];
		$tVoltage_a = $_REQUEST['tVoltage_a'];
		$tVoltage_b = $_REQUEST['tVoltage_b'];
		$tVoltage_c = $_REQUEST['tVoltage_c'];
		$onChrg1 = $disChrg = $onChrg2 = [];
		if(isset($rowm_id))$onChrgM1 = $disChrgM = $onChrgM2 = [];
		$ocv_con = $sg_ocv_con = $acid_density_con = "";
		if(count($bankid))
		for($i=0;$i<count($bankid);$i++){
			//$id = mysqli_real_escape_string($mr_con,trim($bankid[$i]));
			//$bankrating = mysqli_real_escape_string($mr_con,trim($bank_rating[$i]));
			//$bb_cap_update_sql=mysqli_query($mr_con,"UPDATE ec_battery_bank_bb_cap SET battery_bank_rating='$bankrating' WHERE id='$id' AND flag=0");
			for($k=0;$k<count($hdr_o_id[$i]);$k++)$bb_heado_update_sql=mysqli_query($mr_con,"UPDATE ec_bo_headers SET header='".$header_o[$i][$k]."',total_voltage='".$tVoltage_o[$i][$k]."',temperature='".$temp_o[$i][$k]."',charging_current='".$cCurrent_o[$i][$k]."',smps_charge_voltage='".$charge_o[$i][$k]."',bb_terminal_voltage='".$bb_ter_o[$i][$k]."' WHERE id='".$hdr_o_id[$i][$k]."' AND flag=0");
			for($k=0;$k<count($hdr_a_id[$i]);$k++)$bb_heada_update_sql=mysqli_query($mr_con,"UPDATE ec_bo_headers SET header='".$header_a[$i][$k]."',total_voltage='".$tVoltage_a[$i][$k]."',temperature='".$temp_a[$i][$k]."',charging_current='".$cCurrent_a[$i][$k]."',smps_charge_voltage='".$charge_a[$i][$k]."',bb_terminal_voltage='".$bb_ter_a[$i][$k]."' WHERE id='".$hdr_a_id[$i][$k]."' AND flag=0");
			for($k=0;$k<count($hdr_b_id[$i]);$k++)$bb_headb_update_sql=mysqli_query($mr_con,"UPDATE ec_bo_headers SET header='".$header_b[$i][$k]."',total_voltage='".$tVoltage_b[$i][$k]."',temperature='".$temp_b[$i][$k]."',charging_current='".$cCurrent_b[$i][$k]."',smps_charge_voltage='".$charge_b[$i][$k]."',bb_terminal_voltage='".$bb_ter_b[$i][$k]."' WHERE id='".$hdr_b_id[$i][$k]."' AND flag=0");
			for($k=0;$k<count($hdr_c_id[$i]);$k++)$bb_headc_update_sql=mysqli_query($mr_con,"UPDATE ec_bo_headers SET header='".$header_c[$i][$k]."',total_voltage='".$tVoltage_c[$i][$k]."',temperature='".$temp_c[$i][$k]."',charging_current='".$cCurrent_c[$i][$k]."',smps_charge_voltage='".$charge_c[$i][$k]."',bb_terminal_voltage='".$bb_ter_c[$i][$k]."' WHERE id='".$hdr_c_id[$i][$k]."' AND flag=0");
			
			for($j=0;$j<count($row_id[$i]);$j++){
				$rowid = mysqli_real_escape_string($mr_con,trim($row_id[$i][$j]));
				$cellSlNo = mysqli_real_escape_string($mr_con,trim($cell_sl_no[$i][$j]));
				$mfdate = mysqli_real_escape_string($mr_con,trim($mf_date[$i][$j]));
				if(count($ocv)){
					$_ocv = mysqli_real_escape_string($mr_con,trim($ocv[$i][$j]));
					$ocv_con = "ocv='$_ocv',";
				}
				if(count($sg_ocv)){
					$sgocv = mysqli_real_escape_string($mr_con,trim($sg_ocv[$i][$j]));
					$sg_ocv_con = "sg_ocv='$sgocv',";
				}
				$a=1;
				if(isset($battery_Volts[$i][$j]))
				for($k=0;$k<count($battery_Volts[$i][$j]);$k++){
					$batteryVolts = mysqli_real_escape_string($mr_con,trim($battery_Volts[$i][$j][$k]));
					if(isset($rowm_id)){
						if($k<30){
							if($k<20){
								if($k%2==0) array_push($onChrg1,$a . "hr = \'".$batteryVolts."\'");
								elseif($k%2==1){ array_push($onChrgM1,"sg_".$a . "hr = \'".$batteryVolts."\'"); $a++;}
							}else{
								if($k%2==0) array_push($onChrg1,"10" . num2alpha($a - 9) . "_hr = \'".$batteryVolts."\'");
								else { array_push($onChrgM1,"sg_10" . num2alpha($a - 9) . "_hr = \'".$batteryVolts."\'"); $a++;}
							}
						}
					}else{
						if($k<15){
							if($k<10) array_push($onChrg1,($k+1) . "hr = \'".$batteryVolts."\'");
							else array_push($onChrg1,"10" . num2alpha($k - 10) . "_hr = \'".$batteryVolts."\'");
						}
					}
				}
				
				$a=11;
				if(isset($battery_Volts_a[$i][$j]))
				for($k=0;$k<count($battery_Volts_a[$i][$j]);$k++){
					$batteryVoltsa = mysqli_real_escape_string($mr_con,trim($battery_Volts_a[$i][$j][$k]));
					if(isset($rowm_id)){
						if($k<30){
							if($k<20){
								if($k%2==0) array_push($disChrg,$a . "hr = \'".$batteryVoltsa."\'");
								elseif($k%2==1){ array_push($disChrgM,"sg_".$a . "hr = \'".$batteryVoltsa."\'"); $a++;}
							}else{
								if($k%2==0) array_push($disChrg,"20" . num2alpha($a - 9) . "_hr = \'".$batteryVoltsa."\'");
								else { array_push($disChrgM,"sg_20" . num2alpha($a - 9) . "_hr = \'".$batteryVoltsa."\'"); $a++;}
							}
						}
					}else{
						if($k<15){
							if($k<10) array_push($disChrg,($k+11) . "hr = \'".$batteryVoltsa."\'");
							else array_push($disChrg,"20" . num2alpha($k - 10) . "_hr = \'".$batteryVoltsa."\'");
						}
					}
				}
				$a=21;
				if(isset($battery_Volts_b[$i][$j]))
				for($k=0;$k<count($battery_Volts_b[$i][$j]);$k++){
					$batteryVoltsb = mysqli_real_escape_string($mr_con,trim($battery_Volts_b[$i][$j][$k]));
					if(isset($rowm_id)){
						if($k<30){
							if($k<20){
								if($k%2==0) array_push($onChrg2,$a . "hr = \'".$batteryVoltsb."\'");
								elseif($k%2==1){ array_push($onChrgM2,"sg_".$a . "hr = \'".$batteryVoltsb."\'"); $a++;}
							}else{
								if($k%2==0) array_push($onChrg2,"30" . num2alpha($a - 9) . "_hr = \'".$batteryVoltsb."\'");
								else { array_push($onChrgM2,"sg_30" . num2alpha($a - 9) . "_hr = \'".$batteryVoltsb."\'"); $a++;}
							}
						}
					}else{
						if($k<15){
							if($k<10) array_push($onChrg2,($k+21) . "hr = \'".$batteryVoltsb."\'");
							else array_push($onChrg2,"30" . num2alpha($k - 10) . "_hr = \'".$batteryVoltsb."\'");
						}
					}
				}
				$remarks = mysqli_real_escape_string($mr_con,trim($bb_remarks[$i][$j]));
				$bb_telecom_ic_update_sql=mysqli_query($mr_con,"UPDATE ec_bo_telecom_ic SET cell_sl_no='$cellSlNo',mf_date='$mfdate', $ocv_con ".stripslashes(implode(",",$onChrg1)).(count($onChrg1) ? "," : "").stripslashes(implode(",",$disChrg)).(count($disChrg) ? "," : "").stripslashes(implode(",",$onChrg2)).(count($onChrg2) ? "," : "")."remarks='$remarks' WHERE id='$rowid' AND flag=0");
				if(isset($rowm_id)){
					$rowmid = mysqli_real_escape_string($mr_con,trim($rowm_id[$i][$j]));
					$bb_motive_ic_update_sql=mysqli_query($mr_con,"UPDATE ec_bo_motive_ic SET $sg_ocv_con ".stripslashes(implode(",",$onChrgM1)).(count($onChrgM1) ? "," : "").stripslashes(implode(",",$disChrgM)).(count($disChrgM) ? "," : "").stripslashes(implode(",",$onChrgM2)).(count($onChrgM2) ? "," : "")."flag=0 WHERE id='$rowmid' AND flag=0");
				}
			}
		}
		//$result['ans'] = $_REQUEST;
		$resCode='0';$resMsg='Success';
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}if(isset($res)){$resCode='4'; $resMsg=$res;}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function bb_row_column_delete(){ global $mr_con;
	$emp_alias=$_REQUEST['emp_alias']; $token=$_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	$grantable = true;//grantable('DELETE','EFSR_EDIT',$emp_alias);
	if(!$grantable){
		$resCode = 1;
		$resMsg='Authentication Failed!';
	}
	if($grantable && $rex==0) {
		$ref = mysqli_real_escape_string($mr_con,$_REQUEST['ref']);
		$id = mysqli_real_escape_string($mr_con,$_REQUEST['id']);
		$remarks = mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks']));
		$ticket_id = mysqli_real_escape_string($mr_con,trim($_REQUEST['ticket_id']));
		$rowColData = mysqli_real_escape_string($mr_con,trim($_REQUEST['rowColData']));
		if(empty($remarks)){$res="Provide remarks";}
		else if(empty($ref) || empty($id)){$res="Invalid Request";}
		else {
			if($ref == "bb")$tbl = "ec_battery_bank_bb_cap";
			else if($ref == "column")$tbl = "ec_bo_headers";
			else if($ref == "row")$tbl = "ec_bo_telecom_ic";
			else $tbl = "";
			if($tbl != ""){
				$bb_cap_delete_sql=mysqli_query($mr_con,"UPDATE $tbl SET flag=1 WHERE id='$id'");
				if($bb_cap_delete_sql){
					if($ref == "row"){
						$battery_bb_alias = alias_flag_none($id,"ec_bo_telecom_ic","id","battery_bb_alias");
						//$bo_count_headers_sql=mysqli_query($mr_con,"SELECT type,count(type) as typeCnt FROM ec_bo_headers WHERE item_alias='$battery_bb_alias' GROUP BY type ORDER BY id");
						$bo_headers_sql=mysqli_query($mr_con,"SELECT id,type FROM ec_bo_headers WHERE item_alias='$battery_bb_alias' ORDER BY id");
						if(mysqli_num_rows($bo_headers_sql)){
							$on_charge_volt_1 = $discharge_volt = $on_charge_volt_2 = 1;
							while($bo_headers_row = mysqli_fetch_array($bo_headers_sql)){
								if($bo_headers_row['type'] == "ocv"){
									$telecom_ic_sql=mysqli_query($mr_con,"SELECT SUM(ocv) AS ocvSum FROM ec_bo_telecom_ic WHERE battery_bb_alias='$battery_bb_alias' AND flag='0'");
									$telecom_ic_row = mysqli_fetch_array($telecom_ic_sql);
									$bb_head_update_sql=mysqli_query($mr_con,"UPDATE ec_bo_headers SET total_voltage='".round($telecom_ic_row['ocvSum'],2)."' WHERE id='".$bo_headers_row['id']."'");
								}elseif($bo_headers_row['type'] == "on_charge_voltage_1"){
									if($on_charge_volt_1<11) $onChargeVolt1ColName = $on_charge_volt_1 . "hr";
									else $onChargeVolt1ColName = "10" . num2alpha($on_charge_volt_1 - 11) . "_hr";
									$telecom_ic_sql=mysqli_query($mr_con,"SELECT SUM( $onChargeVolt1ColName ) AS onChargeVolt1Sum FROM ec_bo_telecom_ic WHERE battery_bb_alias='$battery_bb_alias' AND flag='0'");
									$telecom_ic_row = mysqli_fetch_array($telecom_ic_sql);
									$bb_head_update_sql=mysqli_query($mr_con,"UPDATE ec_bo_headers SET total_voltage='".round($telecom_ic_row['onChargeVolt1Sum'],2)."' WHERE id='".$bo_headers_row['id']."'");
									$on_charge_volt_1++;
								}elseif($bo_headers_row['type'] == "discharge_voltage"){
									if($discharge_volt<11) $disChargeVoltColName = ($discharge_volt + 10) . "hr";
									else $disChargeVoltColName = "20" . num2alpha($discharge_volt - 11) . "_hr";
									$telecom_ic_sql=mysqli_query($mr_con,"SELECT SUM( $disChargeVoltColName ) AS disChargeVoltSum FROM ec_bo_telecom_ic WHERE battery_bb_alias='$battery_bb_alias' AND flag='0'");
									$telecom_ic_row = mysqli_fetch_array($telecom_ic_sql);
									$bb_head_update_sql=mysqli_query($mr_con,"UPDATE ec_bo_headers SET total_voltage='".round($telecom_ic_row['disChargeVoltSum'],2)."' WHERE id='".$bo_headers_row['id']."'");
									$discharge_volt++;
								}elseif($bo_headers_row['type'] == "on_charge_voltage_2"){
									if($on_charge_volt_2<11) $onChargeVolt2ColName = ($on_charge_volt_2 + 20) . "hr";
									else $onChargeVolt2ColName = "30" . num2alpha($on_charge_volt_2 - 11) . "_hr";
									$telecom_ic_sql=mysqli_query($mr_con,"SELECT SUM( $onChargeVolt2ColName ) AS onChargeVolt2Sum FROM ec_bo_telecom_ic WHERE battery_bb_alias='$battery_bb_alias' AND flag='0'");
									$telecom_ic_row = mysqli_fetch_array($telecom_ic_sql);
									$bb_head_update_sql=mysqli_query($mr_con,"UPDATE ec_bo_headers SET total_voltage='".round($telecom_ic_row['onChargeVolt2Sum'],2)."' WHERE id='".$bo_headers_row['id']."'");
									$on_charge_volt_2++;
								}
							}
						}
					}
					$action = "Ticket ID $ticket_id Battery Bank $ref $rowColData Deleted";
					user_history($emp_alias,$action,$_REQUEST['ip_addr'], $remarks);
					$resCode='0';$resMsg='Successfully '.$ref.' deleted';
				}
			}else {$resCode='1';$resMsg='Sorry, deletion failed';}
		}
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}if(isset($res)){$resCode='4'; $resMsg=$res;}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function update_remarks(){ global $mr_con;
	$emp_alias=$_REQUEST['emp_alias']; $token=$_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	$grantable = true;//grantable('DELETE','EFSR_EDIT',$emp_alias);
	if(!$grantable){
		$resCode = 1;
		$resMsg='Authentication Failed!';
	}
	if($grantable && $rex==0) {
		$remarks = mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks']));
		$ticket_id = mysqli_real_escape_string($mr_con,trim($_REQUEST['ticket_id']));
		$ref = mysqli_real_escape_string($mr_con,trim($_REQUEST['ref']));
		if(empty($remarks)){$res="Provide remarks";}
		else if(empty($ticket_id) || empty($ref)){$res="Invalid Request";}
		else {
			$action = "Ticket ID $ticket_id ".str_replace("-"," ",$ref)." Updated";
			$user_his_res = user_history($emp_alias,$action,$_REQUEST['ip_addr'], $remarks);
			if($user_his_res){ $resCode='0';$resMsg='Successfully '.$ref.' Updated';}
			else {$resCode='1';$resMsg='Sorry, '.$ref.' updation failed';}
		}
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}if(isset($res)){$resCode='4'; $resMsg=$res;}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function num2alpha($n){
    for($r = ""; $n >= 0; $n = intval($n / 26) - 1) $r = chr($n%26 + 0x41) . $r;
    return strtolower($r);
}
?>