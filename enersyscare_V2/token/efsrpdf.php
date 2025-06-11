<?php
date_default_timezone_set("Asia/Kolkata");
include('mysql.php');
include('pdfinclude/mpdf.php');
//$mpdf=new mPDF($mode, $format, $font_size, $font, $margin_left, $margin_right, $margin_top, $margin_bottom, $margin_header, $margin_footer, $orientation);
//$mpdf=new mPDF('','', 0, '', 15, 15, 35, 30, 5, 0, '');
$mpdf=new mPDF('','', 0, '', 15, 15, 35, 50, 5, 10, '');
	$ticket_alias=$_REQUEST['ticket_alias'];
	$sql=mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE ticket_alias='$ticket_alias' AND flag=0");
	$row=mysqli_fetch_array($sql);
	$d_s=alias($row['activity_alias'],'ec_activity','activity_alias','activity_code');
	$filename = $row['ticket_id'];
	$res='
<div class="container">
<table style="width:100%" class="table">
  <caption class="">Ticket Details</caption>
  <tr>
    <td class="head text-primary">'.check_empty('Ticket ID',$row['ticket_id']).'</td>
    <td class="head text-primary">'.check_empty('Login Date',$row['login_date']).'</td>
    <td class="head text-primary">'.check_empty('Activity',alias($row['activity_alias'],'ec_activity','activity_alias','activity_code')).'</td>
    <td class="head text-primary">'.check_empty('Segment',alias(alias($row['site_alias'],'ec_sitemaster','site_alias','segment_alias'),'ec_segment','segment_alias','segment_name')).'</td>
  </tr>
  <tr>
    <td class="head text-primary">'.check_empty('Site ID',alias($row['site_alias'],'ec_sitemaster','site_alias','site_id')).'</td>
    <td class="head text-primary">'.check_empty('Site Name',alias($row['site_alias'],'ec_sitemaster','site_alias','site_name')).'</td>
    <td class="head text-primary">'.check_empty('Zone',alias(alias($row['site_alias'],'ec_sitemaster','site_alias','zone_alias'),'ec_zone','zone_alias','zone_name')).'</td>
    <td class="head text-primary">'.check_empty('State',alias(alias($row['site_alias'],'ec_sitemaster','site_alias','state_alias'),'ec_state','state_alias','state_name')).'</td>
  </tr>
  <tr>
    <td class="head text-primary">'.check_empty('District',alias(alias($row['site_alias'],'ec_sitemaster','site_alias','district_alias'),'ec_district','district_alias','district_name')).'</td>
    <td class="head text-primary">'.check_empty('Planned',$row['planned_date']).'</td>
    <td class="head text-primary">'.check_empty('Manufacturing',alias($row['site_alias'],'ec_sitemaster','site_alias','mfd_date')).'</td>
    <td class="head text-primary">'.check_empty('Installation Date',alias($row['site_alias'],'ec_sitemaster','site_alias','install_date')).'</td>
  </tr>
  <tr>
    <td class="head text-primary">'.check_empty('Activation Date',$row['activation_date']).'</td>
    <td class="head text-primary">'.check_empty('Customer name ',alias(alias($row['site_alias'],'ec_sitemaster','site_alias','customer_alias'),'ec_customer','customer_alias','customer_code')).'</td>
    <td class="head text-primary">'.check_empty('Service Engineer',alias($row['service_engineer_alias'],'ec_employee_master','employee_alias','name')).'</td>
    <td class="head text-primary">'.check_empty('Service Engineer Mobile',alias($row['service_engineer_alias'],'ec_employee_master','employee_alias','mobile_number')).'</td>
  </tr>
  <tr>
    <td class="head text-primary">'.check_empty('Site Technician Name',alias($row['site_alias'],'ec_sitemaster','site_alias','technician_name')).'</td>
    <td class="head text-primary">'.check_empty('Site Technician Number',alias($row['site_alias'],'ec_sitemaster','site_alias','technician_number')).'</td>
    <td class="head text-primary">'.check_empty('Number Of Banks',alias($row['site_alias'],'ec_sitemaster','site_alias','no_of_string')).'</td>
    <td class="head text-primary">'.check_empty('Site Type',alias(alias($row['site_alias'],'ec_sitemaster','site_alias','site_type_alias'),'ec_site_type','site_type_alias','site_type')).'</td>
  </tr>
  <tr>
    <td class="head text-primary">'.check_empty('Nature Of Complaint',alias($row['complaint_alias'],'ec_complaint','complaint_alias','complaint_name')).'</td>
    <td class="head text-primary">'.check_empty('Product Description',alias(alias($row['site_alias'],'ec_sitemaster','site_alias','product_alias'),'ec_product','product_alias','product_description')).'</td>
    <td class="head text-primary">'.check_empty('Description',$row['description']).'</td>
    <td class="head text-primary" colspan="4">'.check_empty('Mode Of Contact',$row['mode_of_contact']).'</td>
  </tr>
</table>';



//Railway segment
$coach_sql=mysqli_query($mr_con,"SELECT * FROM ec_coach_history WHERE ticket_alias='$ticket_alias' AND flag=0");
if(mysqli_num_rows($coach_sql)){
$coach_row=mysqli_fetch_array($coach_sql);
$res.='
<table style="width:100%" class="table">
  <caption class="capt">Coach History</caption>
  <tr>
    <td class="head text-primary">'.check_empty('Train No',$coach_row['train_no']).'</td>
    <td class="head text-primary">'.check_empty('Express Name',$coach_row['express_name']).'</td>
    <td class="head text-primary">'.check_empty('Coach No',$coach_row['coach_no']).'</td>
    <td class="head text-primary">'.check_empty('Pre attnd',$coach_row['pre_attnd']).'</td>
</tr>
<tr>
    <td class="head text-primary">'.check_empty('POH',$coach_row['poh']).'</td>
    <td class="head text-primary">'.check_empty('RPOH',$coach_row['rpoh']).'</td>
    <td class="head text-primary">'.check_empty('Zone',$coach_row['zone']).'</td>
    <td class="head text-primary">'.check_empty('Division',$coach_row['division']).'</td>
</tr>';
if(!empty($coach_row['workshop'])){
$res.='
	<tr>
		<td class="head text-primary">Workshop<p>'.$coach_row['workshop'].'</p></td>
		<td class="head text-primary"><p></p></td>
		<td class="head text-primary"><p></p></td>
		<td class="head text-primary"><p></p></td>
	</tr>';
}
$res.='</table>';
}

$equip_sql=mysqli_query($mr_con,"SELECT * FROM ec_equip_details WHERE ticket_alias='$ticket_alias' AND flag=0");
if(mysqli_num_rows($equip_sql)){
$equip_row=mysqli_fetch_array($equip_sql);
$res.='
<table style="width:100%" class="table">
  <caption class="capt">Equipment Details</caption>
  <tr>
    <td class="head text-primary">'.check_empty('Alternate Make',$equip_row['altenate_make']);
	if($equip_row['altenate_make_doc']!='0'){$res.='<p><img src="data:image/jpeg;base64,'.$equip_row['altenate_make_doc'].'" height="80" width="80"/></p>';}
	$res.='</td>
    <td class="head text-primary">'.check_empty('Alternate Belt Status',$equip_row['altenate_belt_status']);
	if($equip_row['altenate_belt_doc']!='0'){$res.='<p><img src="data:image/jpeg;base64,'.$equip_row['altenate_belt_doc'].'" height="80" width="80"/></p>';}    
	$res.='</td>
    <td class="head text-primary">'.check_empty('RRU Make',$equip_row['rru_make']).'</td>
    <td class="head text-primary">'.check_empty('Inverter Make',$equip_row['invertor_make']).'</td>
</tr>
<tr>
    <td class="head text-primary">'.check_empty('Voltage Regulation',$equip_row['voltage_regulation']).'</td>
    <td class="head text-primary">'.check_empty('Regulator Make',$equip_row['regulator_make']).'</td>
	<td class="head text-primary"><p></p></td>
	<td class="head text-primary"><p></p></td>
</tr>
</table>';
}


$check_points_sql=mysqli_query($mr_con,"SELECT * FROM ec_check_points WHERE ticket_alias='$ticket_alias' AND flag=0");
if(mysqli_num_rows($check_points_sql)){
$check_points_row=mysqli_fetch_array($check_points_sql);
$res.='
<table style="width:100%" class="table">
  <caption class="capt">Check Points</caption>
  <tr>
    <td class="head text-primary">'.check_empty('ICC Tightness',$check_points_row['icc_tightness']).'</td>
    <td class="head text-primary">'.check_empty('Heating Melting Marks',$check_points_row['heating_melting_marks']).'</td>
    <td class="head text-primary">'.check_empty('Terminal Tightness',$check_points_row['terminal_tightness']).'</td>
    <td class="head text-primary">'.check_empty('Alt No Belt Avl',$check_points_row['alt_no_belt_avl']).'</td>
</tr>
<tr>
    <td class="head text-primary">'.check_empty('Vent Plug Tightness',$check_points_row['vent_plug_tightness']).'</td>
    <td class="head text-primary">'.check_empty('Belt',$check_points_row['belt']).'</td>
    <td class="head text-primary">'.check_empty('Log Book',$check_points_row['log_book']).'</td>
    <td class="head text-primary">'.check_empty('Coach Status',$check_points_row['coach_status']).'</td>
</tr>
<tr>
    <td class="head text-primary">'.check_empty('Physical Damage',$check_points_row['physical_damage']);
	if($check_points_row['physical_damage_pic']!='0'){$res.='<p><img src="data:image/jpeg;base64,'.$check_points_row['physical_damage_pic'].'" height="80" width="80"/></p>';}
	$res.='</td>
    <td class="head text-primary">'.check_empty('Cell Buldge',$check_points_row['cell_buldge']);
	if($check_points_row['cell_buldge_pic']!='0'){$res.='<p><img src="data:image/jpeg;base64,'.$check_points_row['cell_buldge_pic'].'" height="80" width="80"/></p>';}    
	$res.='</td>
</tr>
</table>';
}

//Motive Power
$charger_sql=mysqli_query($mr_con,"SELECT * FROM ec_charger_details WHERE ticket_alias='$ticket_alias' AND flag=0");
if(mysqli_num_rows($charger_sql)){
$charger_row=mysqli_fetch_array($charger_sql);
$res.='
<table style="width:100%" class="table">
  <caption class="capt">Charger Details</caption>
  <tr>
    <td class="head text-primary">'.check_empty('Charger Band',$charger_row['charger_band']);
	if($charger_row['charger_pic']!='0'){$res.='<p><img src="data:image/jpeg;base64,'.$charger_row['charger_pic'].'" height="80" width="80"/></p>';}
	$res.='</td>
    <td class="head text-primary">'.check_empty('Manufactured Date',$charger_row['manf_date']).'</td>
    <td class="head text-primary">'.check_empty('Serial No',$charger_row['serial_no']).'</td>
    <td class="head text-primary">'.check_empty('Charger Type',$charger_row['charger_type']).'</td>
</tr>
<tr>
    <td class="head text-primary">'.check_empty('Voltage',$charger_row['voltage']).'</td>
    <td class="head text-primary">'.check_empty('Charging Current',$charger_row['charging_current']).'</td>
    <td class="head text-primary">'.check_empty('High Voltage Cutoff(V)',$charger_row['high_voltage_cutoff']).'</td>
    <td class="head text-primary">'.check_empty('Voltage Ripple(mV)',$charger_row['voltage_ripple']).'</td>
</tr>';
if(!empty($charger_row['voltage_regulation'])){
$res.='
	<tr>
		<td class="head text-primary">Voltage Regulation<p>'.$charger_row['voltage_regulation'].'</p></td>
		<td class="head text-primary"><p></p></td>
		<td class="head text-primary"><p></p></td>
		<td class="head text-primary"><p></p></td>
	</tr>';
}
$res.='</table>';
}

$forklift_sql=mysqli_query($mr_con,"SELECT * FROM ec_fork_lift WHERE ticket_alias='$ticket_alias' AND flag=0");
if(mysqli_num_rows($forklift_sql)){
$forklift_row=mysqli_fetch_array($forklift_sql);
$res.='
<table style="width:100%" class="table">
  <caption class="capt">Forklift Details</caption>
  <tr>
    <td class="head text-primary">'.check_empty('Fork Lift Brand',$forklift_row['fork_lift_brand']);
	if($forklift_row['fork_lift_pic']!='0'){$res.='<p><img src="data:image/jpeg;base64,'.$forklift_row['fork_lift_pic'].'" height="80" width="80"/></p>';}
	$res.='</td>
    <td class="head text-primary">'.check_empty('ork Lift Model',$forklift_row['fork_lift_model']).'</td>
    <td class="head text-primary">'.check_empty('Fork Lift Manufacturing Date',$forklift_row['fork_lift_manf_date']).'</td>
    <td class="head text-primary"><p></p></td>
</tr>
</table>';
}

$battey_sql=mysqli_query($mr_con,"SELECT * FROM ec_battery_details WHERE ticket_alias='$ticket_alias' AND flag=0");
if(mysqli_num_rows($battey_sql)){
$battey_row=mysqli_fetch_array($battey_sql);
$res.='
<table style="width:100%" class="table">
  <caption class="capt">Battery Details</caption>
  <tr>
    <td class="head text-primary">'.check_empty('Battey Type',$battey_row['battey_type']).'</td>
    <td class="head text-primary">'.check_empty('Bank Serial No',$battey_row['bank_serial_no']).'</td>
    <td class="head text-primary">'.check_empty('Manufacturing Date',$battey_row['manf_date']).'</td>
    <td class="head text-primary">'.check_empty('Installation Date',$battey_row['ins_date']).'</td>
</tr>
  <tr>
    <td class="head text-primary">'.check_empty('Plug Type',$battey_row['plug_type']).'</td>
    <td class="head text-primary">'.check_empty('Acid Level',$battey_row['acid_level']).'</td>
    <td class="head text-primary"><p></p></td>
    <td class="head text-primary"><p></p></td>
</tr>
</table>';
}

//UPS
$segment_code = alias(alias(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','segment_alias'),'ec_segment','segment_alias','segment_code');
$ups_sql=mysqli_query($mr_con,"SELECT * FROM ec_technical_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
if(mysqli_num_rows($ups_sql) && $segment_code=="UP"){
	$ups_row=mysqli_fetch_array($ups_sql);
	$res.='
	<table style="width:100%" class="table">
	  <caption class="capt">UPS/POWER Control</caption>
	  <tr>
		<td class="head text-primary">'.check_empty('Float Voltage(V)',$ups_row['float_voltage']);
		if($ups_row['document_1']!='0'){$res.='<p><img src="data:image/jpeg;base64,'.$ups_row['document_1'].'" height="80" width="80"/></p>';}
		$res.='</td>
		<td class="head text-primary">'.check_empty('Boast Voltage(V)',$ups_row['boast_voltage']);
		if($ups_row['document_2']!='0'){$res.='<p><img src="data:image/jpeg;base64,'.$ups_row['document_2'].'" height="80" width="80"/></p>';}
		$res.='</td>
		<td class="head text-primary">'.check_empty('Current Limit(Amps)',$ups_row['current_limit']).'</td>
		<td class="head text-primary">'.check_empty('Voltage Ripple(mV)',$ups_row['voltage_ripple']).'</p></td>
	</tr>
	  <tr>
		<td class="head text-primary">'.check_empty('Voltage Regulation',$ups_row['voltage_regulation']).'</td>
		<td class="head text-primary">'.check_empty('High Voltage Cutoff(V)',$ups_row['high_voltage_cutoff']).'</td>
		<td class="head text-primary">'.check_empty('Low Voltage Cutoff(V)',$ups_row['low_voltage_cutoff']).'</td>
		<td class="head text-primary">'.check_empty('Panel Make',$ups_row['panel_make']).'</td>
	</tr>
	  <tr>
		<td class="head text-primary">'.check_empty('Panel Rating',$ups_row['panel_rating']).'</td>
		<td class="head text-primary">'.check_empty('Panel Manufacturing Date',$ups_row['panel_manufacturing_date']).'</td>
		<td class="head text-primary">'.check_empty('Panel Installation Date',$ups_row['panel_installation_date']).'</td>
		<td class="head text-primary"><p></p></td>
	</tr>
	</table>';
}
//Solar/Telecom-Solar
$solar_telecom_sql=mysqli_query($mr_con,"SELECT * FROM ec_technical_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
if(mysqli_num_rows($solar_telecom_sql) && ($segment_code=="SA" || $segment_code=="TS")){
$solar_telecom_row=mysqli_fetch_array($solar_telecom_sql);
$res.='
<table style="width:100%" class="table">
  <caption class="capt">Solar/Telecom-Solar</caption>
  <tr>
    <td class="head text-primary">'.check_empty('Float Voltage(V)',$solar_telecom_row['float_voltage']);
	if($solar_telecom_row['document_1']!='0'){$res.='<p><img src="data:image/jpeg;base64,'.$solar_telecom_row['document_1'].'" height="80" width="80"/></p>';}
	$res.='</td>
    <td class="head text-primary">'.check_empty('Boast Voltage(V)',$solar_telecom_row['boast_voltage']);
	if($solar_telecom_row['document_2']!='0'){$res.='<p><img src="data:image/jpeg;base64,'.$solar_telecom_row['document_2'].'" height="80" width="80"/></p>';}
	$res.='</td>
    <td class="head text-primary">'.check_empty('Current Limit(Amps)',$solar_telecom_row['current_limit']).'</td>
    <td class="head text-primary">'.check_empty('Voltage Ripple(mV)',$solar_telecom_row['voltage_ripple']).'</td>
</tr>
  <tr>
    <td class="head text-primary">'.check_empty('Voltage Regulation',$solar_telecom_row['voltage_regulation']).'</td>
    <td class="head text-primary">'.check_empty('High Voltage Cutoff(V)',$solar_telecom_row['high_voltage_cutoff']).'</td>
    <td class="head text-primary">'.check_empty('Low Voltage Cutoff(V)',$solar_telecom_row['low_voltage_cutoff']).'</td>
    <td class="head text-primary">'.check_empty('Charge Controller Make',$solar_telecom_row['charge_controller_make']).'</td>
</tr>
  <tr>
    <td class="head text-primary">'.check_empty('No Solar Panels',$solar_telecom_row['no_solar_panels']);
	if($solar_telecom_row['document_3']!='0'){$res.='<p><img src="data:image/jpeg;base64,'.$solar_telecom_row['document_3'].'" height="80" width="80"/></p>';}
	$res.='</td>
    <td class="head text-primary">'.check_empty('Single Panel Rating',$solar_telecom_row['single_panel_rating']).'</td>
    <td class="head text-primary">'.check_empty('Panel Manufacturing Date',$solar_telecom_row['panel_manufacturing_date']).'</td>
    <td class="head text-primary">'.check_empty('Charge Control Manufacturing Date',$solar_telecom_row['charge_control_manufacturing_date']).'</td>
</tr>
  <tr>
    <td class="head text-primary">'.check_empty('Panel Installation Date',$solar_telecom_row['panel_installation_date']).'</td>
    <td class="head text-primary"><p></p></td>
    <td class="head text-primary"><p></p></td>
    <td class="head text-primary"><p></p></td>
</tr>
</table>';
}


//Physical Observation
	$physical_sql=mysqli_query($mr_con,"SELECT * FROM ec_physical_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
	$physical_row=mysqli_fetch_array($physical_sql);
$res.='
<table style="width:100%" class="table">
  <caption class="capt">Physical Observations</caption>
  <tr>
    <td class="head text-primary">'.check_empty('Physical Damages',$physical_row['physical_damages']);
	if($physical_row['physical_damages_document']!='0'){$res.='<p><img src="data:image/jpeg;base64,'.$physical_row['physical_damages_document'].'" height="80" width="80"/></p>';}
	$res.='</td>';
	$res.='<td class="head text-primary">'.check_empty('Leakage',$physical_row['leakage']);
	if($physical_row['leakage_document']!='0'){$res.='<p><img src="data:image/jpeg;base64,'.$physical_row['leakage_document'].'" height="80" width="80"/></p>';}    
	$res.='</td>';
	$temp = explode("|",$physical_row['temperature']);
	$res.='
	<td class="head text-primary">'.check_empty('Temperature',$temp[0]).'</td>
	<td class="head text-primary">'.check_empty($temp[0].' Temperature(c)',$temp[1]).'</td>
  </tr>
  <tr>
	<td class="head text-primary">'.check_empty('Ambient Temperature(c)',$temp[2]).'</td>
    <td class="head text-primary">'.check_empty('General Observations',$physical_row['general_observation']).'</td>
    <td class="head text-primary">'.check_empty('Vent plug Tightness',$physical_row['vent_plug_thickness']).'</td>
    <td class="head text-primary">'.check_empty('Terminal Torque (12nm)',$physical_row['terminal_torque']).'</td>
  </tr>
</table>';
	$smps_sql=mysqli_query($mr_con,"SELECT * FROM ec_technical_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
	$smps_row=mysqli_fetch_array($smps_sql);
$res.='
<table style="width:100%" class="table">
  <caption class="capt">SMPS Observations</caption>
  <tr>
    <td class="head text-primary">'.check_empty('Float Voltage(V)',$smps_row['float_voltage']);
	if($smps_row['document_1']!='0'){$res.='<p><img src="data:image/jpeg;base64,'.$smps_row['document_1'].'" height="80" width="80" /></p>';}
	$res.='</td>
    <td class="head text-primary">'.check_empty('Boast Voltage(V)',$smps_row['boast_voltage']);
	if($smps_row['document_2']!='0'){$res.='<p><img src="data:image/jpeg;base64,'.$smps_row['document_2'].'" height="80" width="80" /></p>';}
	$res.='</td>
    <td class="head text-primary">'.check_empty('Current Limit(Amps)',$smps_row['current_limit']).'</td>
    <td class="head text-primary">'.check_empty('Voltage Ripple(mV)',$smps_row['voltage_ripple']).'</td>
  </tr>
  <tr>
    <td class="head text-primary">'.check_empty('High voltage Cut off (V)',$smps_row['high_voltage_cutoff']).'</td>
    <td class="head text-primary">'.check_empty('Low voltage Cut off (V)',$smps_row['low_voltage_cutoff']).'</td>
    <td class="head text-primary">'.check_empty('LVDS Status',$smps_row['voltage_regulation']);
	if($smps_row['document_3']!='0'){$res.='<p><img src="data:image/jpeg;base64,'.$smps_row['document_3'].'" height="80" width="80"/></p>';}
	$res.='</td>
    <td class="head text-primary">'.check_empty('SMPS Make',$smps_row['panel_make']).'</td>
  </tr>
  <tr>
    <td class="head text-primary">'.check_empty('SMPS Rating',$smps_row['panel_rating']).'</td>
    <td class="head text-primary">'.check_empty('SMR Modules Rating(Amps)',$smps_row['charge_controller_rate']).'</td>
    <td class="head text-primary">'.check_empty('Number of Working Modules',$smps_row['no_solar_panels']);
	if($smps_row['document_4']!='0'){$res.='<p><img src="data:image/jpeg;base64,'.$smps_row['document_4'].'" height="80" width="80"/></p>';}
	$res.='</td>
    <td class="head text-primary">'.check_empty('SMPS Display',$smps_row['single_panel_rating']);
	if($smps_row['document_5']!='0'){$res.='<p><img src="data:image/jpeg;base64,'.$smps_row['document_5'].'" height="80" width="80"/></p>';}
	$res.='</td>
  </tr>
  <tr>
    <td class="head text-primary" colspan="4">'.check_empty('SMPS Manufacturing Date',$smps_row['panel_manufacturing_date']).'</td>
  </tr>
</table>';

	$general_sql=mysqli_query($mr_con,"SELECT * FROM ec_general_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
	$general_row=mysqli_fetch_array($general_sql);
$res.='
<table style="width:100%" class="table">
  <caption class="capt">Generator Observations</caption>
  <tr>
    <td class="head text-primary">'.check_empty('DG Status',$general_row['dg_status']).'</td>
	<td class="head text-primary">';
	if($general_row['dg_status']=='available'){
		$res.='DG Working Condition<p>'.$general_row['dg_working_condition'].'</p>';
		if($general_row['dg_pic']!='0'){$res.='<p><img src="data:image/jpeg;base64,'.$general_row['dg_pic'].'" height="80" width="80"/></p>';}
	}$res.='</td>
    <td class="head text-primary">'.check_depend($general_row['dg_status'],'available','Avg DG Run hrs/Day ',$general_row['avg_dg_run']).'</td>
  </tr>
</table>';

	$power_sql=mysqli_query($mr_con,"SELECT * FROM ec_power_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
	$power_row=mysqli_fetch_array($power_sql);
$res.='
<table style="width:100%" class="table">
  <caption class="capt">Power(EB) Observations</caption>
  <tr>
    <td class="head text-primary">'.check_empty('E.B supply Available',$power_row['eb_supply']).'</td>
    <td class="head text-primary">'.check_depend($power_row['eb_supply'],'Yes','Failures per Day ',$power_row['failures_per_day']).'</td>
    <td class="head text-primary">'.check_depend($power_row['eb_supply'],'Yes','Average Power Cut Hrs in Day ',$power_row['avg_power_cut']).'</td>
  </tr>
</table>';

	$service_sql=mysqli_query($mr_con,"SELECT * FROM ec_engineer_observation WHERE ticket_alias='$ticket_alias' AND flag=0");
	$service_row=mysqli_fetch_array($service_sql);
$res.='
<table style="width:100%" class="table">
  <caption class="capt">Service Engineer Observation</caption>
  <tr>
    <td class="head text-primary">'.check_empty('Faulty Code Selection',alias($service_row['faulty_alias'],'ec_faulty_code','faulty_alias','faulty_code')).'</td>
    <td class="head text-primary">'.check_empty('Item Code',alias($service_row['item_code_alias'],'ec_item_code','item_alias','item_code')).'</td>
    <td class="head text-primary">'.check_empty('Faulty cell Serial Number',$service_row['faulty_cell_s_no']).'</td>
    <td class="head text-primary">'.check_empty('Remarks',alias($ticket_alias,'ec_remarks','item_alias','remarks')).'</td>
  </tr>
  <tr>
    <td class="head text-primary">'.check_empty('Action',alias($ticket_alias,'ec_ticket_action','ticket_alias','observation')).'</td>
    <td class="head text-primary"><p></p></td>
    <td class="head text-primary"><p></p></td>
    <td class="head text-primary"><p></p></td>
  </tr>
</table>
</div>';

//Battery pdf
$sql1=mysqli_query($mr_con,"SELECT * FROM ec_battery_bank_bb_cap WHERE ticket_alias='$ticket_alias' AND flag=0");
if(mysqli_num_rows($sql1)){
$res.='<pagebreak type="NEXT-ODD" suppress="off" >
<div class="container">
  <table class="table table-hover table-bordered">
    <thead>
    <tr>
    	<th colspan="14">'.$d_s.' Battery Observation Report</th>
    </tr>';
	$row1=mysqli_fetch_array($sql1);
	$sql11=mysqli_query($mr_con,"SELECT count(id) as ix FROM ec_bo_headers WHERE type='on_charge_voltage_1' AND item_alias='".$row1['item_alias']."' AND flag=0 ORDER BY id ASC LIMIT 3");
	while($row11=mysqli_fetch_array($sql11)){$ix1=$row11['ix'];}
	$sql12=mysqli_query($mr_con,"SELECT count(id) as ix FROM ec_bo_headers WHERE type='discharge_voltage' AND item_alias='".$row1['item_alias']."' AND flag=0 ORDER BY id ASC LIMIT 3");
	while($row12=mysqli_fetch_array($sql12)){$ix2=$row12['ix'];}
	$sql13=mysqli_query($mr_con,"SELECT count(id) as ix FROM ec_bo_headers WHERE type='on_charge_voltage_2' AND item_alias='".$row1['item_alias']."' AND flag=0 ORDER BY id ASC LIMIT 3");
	while($row13=mysqli_fetch_array($sql13)){$ix3=$row13['ix'];}


	$res.='<tr>
    	<th colspan="14" class="text-left">Battery Bank Rating: '.$row1['battery_bank_rating'].'</th>
        </tr>
      <tr>
        <th>Sl No</th>
        <th>Cell Sl No</th>
        <th>MF Date</th>
        <th>OCV</th>
        <th '.coll($ix1).' >On Charge Voltage</th>
        <th '.coll($ix2).' >DisCharge Voltage</th>
        <th '.coll($ix3).' >On Charge Voltage</th>
		<th>Remarks</th>
      </tr>
      <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
	  ';
		$sql11=mysqli_query($mr_con,"SELECT header, total_voltage, temperature, charging_current FROM ec_bo_headers WHERE type='on_charge_voltage_1' AND item_alias='".$row1['item_alias']."' AND flag=0 ORDER BY id ASC");
		$ix1=mysqli_num_rows($sql11);
		while($row11=mysqli_fetch_array($sql11)){$res.='<th>'.$row11['header'].'</th>';}
		$sql12=mysqli_query($mr_con,"SELECT header, total_voltage, temperature, charging_current  FROM ec_bo_headers WHERE type='discharge_voltage' AND item_alias='".$row1['item_alias']."' AND flag=0 ORDER BY id ASC");
		$ix2=mysqli_num_rows($sql12);
		while($row12=mysqli_fetch_array($sql12)){$res.='<th>'.$row12['header'].'</th>';}
		$sql13=mysqli_query($mr_con,"SELECT header, total_voltage, temperature, charging_current  FROM ec_bo_headers WHERE type='on_charge_voltage_2' AND item_alias='".$row1['item_alias']."' AND flag=0 ORDER BY id ASC");
		$ix3=mysqli_num_rows($sql13);
		while($row13=mysqli_fetch_array($sql13)){$res.='<th>'.$row13['header'].'</th>';}
        $res.='<th></th>
      </tr>
    </thead>
    <tbody>';
	$sql2=mysqli_query($mr_con,"SELECT * FROM ec_bo_telecom_ic WHERE battery_bb_alias='".$row1['item_alias']."' AND flag=0");
	  $n=1;while($row2=mysqli_fetch_array($sql2)){$ocv += $row['ocv'];
	  $res.='<tr>
        <td>'.$n.'</td>
        <td>'.$row2['cell_sl_no'].'</td>
        <td>'.$row2['mf_date'].'</td>
        <td>'.$row2['ocv'].'</td>';
		if($ix1>=1)$res.='<td>'.$row2['1hr'].'</td>';
		if($ix1>=2)$res.='<td>'.$row2['2hr'].'</td>';
		if($ix1>=3)$res.='<td>'.$row2['3hr'].'</td>';
		if($ix1>=4)$res.='<td>'.$row2['4hr'].'</td>';
		if($ix1>=5)$res.='<td>'.$row2['5hr'].'</td>';
		if($ix1>=6)$res.='<td>'.$row2['6hr'].'</td>';
		if($ix1>=7)$res.='<td>'.$row2['7hr'].'</td>';
		if($ix1>=8)$res.='<td>'.$row2['8hr'].'</td>';
		if($ix1>=9)$res.='<td>'.$row2['9hr'].'</td>';
		if($ix1>=10)$res.='<td>'.$row2['10hr'].'</td>';
		
		if($ix2>=1)$res.='<td>'.$row2['11hr'].'</td>';
		if($ix2>=2)$res.='<td>'.$row2['12hr'].'</td>';
		if($ix2>=3)$res.='<td>'.$row2['13hr'].'</td>';
		if($ix2>=4)$res.='<td>'.$row2['14hr'].'</td>';
		if($ix2>=5)$res.='<td>'.$row2['15hr'].'</td>';
		if($ix2>=6)$res.='<td>'.$row2['16hr'].'</td>';
		if($ix2>=7)$res.='<td>'.$row2['17hr'].'</td>';
		if($ix2>=8)$res.='<td>'.$row2['18hr'].'</td>';
		if($ix2>=9)$res.='<td>'.$row2['19hr'].'</td>';
		if($ix2>=10)$res.='<td>'.$row2['20hr'].'</td>';
		
		if($ix3>=1)$res.='<td>'.$row2['21hr'].'</td>';
		if($ix3>=2)$res.='<td>'.$row2['22hr'].'</td>';
		if($ix3>=3)$res.='<td>'.$row2['23hr'].'</td>';
		if($ix3>=4)$res.='<td>'.$row2['24hr'].'</td>';
		if($ix3>=5)$res.='<td>'.$row2['25hr'].'</td>';
		if($ix3>=6)$res.='<td>'.$row2['26hr'].'</td>';
		if($ix3>=7)$res.='<td>'.$row2['27hr'].'</td>';
		if($ix3>=8)$res.='<td>'.$row2['28hr'].'</td>';
		if($ix3>=9)$res.='<td>'.$row2['29hr'].'</td>';
		if($ix3>=10)$res.='<td>'.$row2['30hr'].'</td>';
		$res.='<td>'.$row2['remarks'].'</td>
      </tr>';
	  $n++;}
      $res.='<tr class="tbl"><td colspan="3">Total Voltage (V)</td><td>'.$ocv.'</td>';
		$sql11=mysqli_query($mr_con,"SELECT total_voltage FROM ec_bo_headers WHERE type='on_charge_voltage_1' AND item_alias='".$row1['item_alias']."' AND flag=0 ORDER BY id ASC");
		while($row11=mysqli_fetch_array($sql11)){$res.='<td>'.$row11['total_voltage'].'</td>';}	
		$sql11=mysqli_query($mr_con,"SELECT total_voltage FROM ec_bo_headers WHERE type='discharge_voltage' AND item_alias='".$row1['item_alias']."' AND flag=0 ORDER BY id ASC");
		while($row11=mysqli_fetch_array($sql11)){$res.='<td>'.$row11['total_voltage'].'</td>';}	
		$sql11=mysqli_query($mr_con,"SELECT total_voltage FROM ec_bo_headers WHERE type='on_charge_voltage_2' AND item_alias='".$row1['item_alias']."' AND flag=0 ORDER BY id ASC");
		while($row11=mysqli_fetch_array($sql11)){$res.='<td>'.$row11['total_voltage'].'</td>';}	
      $res.='<td></td></tr>';
      $res.='<tr><td colspan="4">Charging Current (I)</td>';
		$sql11=mysqli_query($mr_con,"SELECT charging_current FROM ec_bo_headers WHERE type='on_charge_voltage_1' AND item_alias='".$row1['item_alias']."' AND flag=0 ORDER BY id ASC");
		while($row11=mysqli_fetch_array($sql11)){$res.='<td>'.$row11['charging_current'].'</td>';}	
		$sql11=mysqli_query($mr_con,"SELECT charging_current FROM ec_bo_headers WHERE type='discharge_voltage' AND item_alias='".$row1['item_alias']."' AND flag=0 ORDER BY id ASC");
		while($row11=mysqli_fetch_array($sql11)){$res.='<td>'.$row11['charging_current'].'</td>';}	
		$sql11=mysqli_query($mr_con,"SELECT charging_current FROM ec_bo_headers WHERE type='on_charge_voltage_2' AND item_alias='".$row1['item_alias']."' AND flag=0 ORDER BY id ASC");
		while($row11=mysqli_fetch_array($sql11)){$res.='<td>'.$row11['charging_current'].'</td>';}	
      $res.='<td></td></tr>';
      $res.='<tr><td colspan="4">Temperature</td>';
		$sql11=mysqli_query($mr_con,"SELECT temperature FROM ec_bo_headers WHERE type='on_charge_voltage_1' AND item_alias='".$row1['item_alias']."' AND flag=0 ORDER BY id ASC");
		while($row11=mysqli_fetch_array($sql11)){$res.='<td>'.$row11['temperature'].'</td>';}	
		$sql11=mysqli_query($mr_con,"SELECT temperature FROM ec_bo_headers WHERE type='discharge_voltage' AND item_alias='".$row1['item_alias']."' AND flag=0 ORDER BY id ASC");
		while($row11=mysqli_fetch_array($sql11)){$res.='<td>'.$row11['temperature'].'</td>';}	
		$sql11=mysqli_query($mr_con,"SELECT temperature FROM ec_bo_headers WHERE type='on_charge_voltage_2' AND item_alias='".$row1['item_alias']."' AND flag=0 ORDER BY id ASC");
		while($row11=mysqli_fetch_array($sql11)){$res.='<td>'.$row11['temperature'].'</td>';}	
      $res.='<td></td></tr>';
    $res.='</tbody>
  </table>
</div>';
}
//Customer details
	$signature_sql=mysqli_query($mr_con,"SELECT * FROM ec_e_signature WHERE ticket_alias='$ticket_alias' AND flag=0");
	$signature_row=mysqli_fetch_array($signature_sql);
$res.='<pagebreak type="NEXT-ODD" suppress="off">
<div class="container">
<div class="titl"><h2 style="font-family:\'Times New Roman\', Times, serif\"><i>CUSTOMER DETAILS</i></h2></div><br>
    <table  style="width:100%" class="table">
      <tr>
		<td class="head text-primary">'.check_empty('Name',$signature_row['name']).'</td>
		<td class="head text-primary">'.check_empty('Designation',$signature_row['designation']).'</td>
		<td class="head text-primary">'.check_empty('Contact Number',$signature_row['contact_number']).'</td>
	  </tr>
	  <tr>
		<td class="head text-primary" width="50%">Customer Photo<p><img src="data:image/jpeg;base64,'.$signature_row['photo'].'" alt="Customer Photo" height="80" width="80"></p></td>
		<td class="head text-primary" width="50%">Engineer Photo<p><img src="data:image/jpeg;base64,'.$signature_row['engineer_photo'].'" alt="Engineer Photo" height="80" width="80"></p></td>
	   
	  </tr>
	  <tr>
		<td class="head text-primary" colspan="3">'.check_empty('Customer Comments',alias($ticket_alias,'ec_customer_comments','ticket_alias','customer_comments')).'</td>
	    <td></td><td></td>
	  </tr>
    </table>';
	
	$satisfication_sql=mysqli_query($mr_con,"SELECT * FROM ec_customer_satisfaction WHERE ticket_alias='$ticket_alias' AND flag=0");
	$satisfication_row=mysqli_fetch_array($satisfication_sql);
$res.='
<table style="width:100%" class="table">
  <caption class="capt">Customer Satisfaction</caption>
  <tr>
    <td class="head text-primary">Are you satisfied with the Response<p>'.star($satisfication_row['q1']).'</p></td>
    <td class="head text-primary">Are you satisfied with the Technical Capability of the Service Personnel<p>'.star($satisfication_row['q2']).'</p></td>
 </tr>
  <tr>
    <td class="head text-primary">Are you satisfied with the professional conduct of the Service Personnel<p>'.star($satisfication_row['q3']).'</p></td>
    <td class="head text-primary">Are you satisfied with the Service provide <p>'.star($satisfication_row['q4']).'</p></td>
  </tr>
  <tr>
  	<td class="head text-primary" colspan="4">How do you rate over all after sales Services<p>'.star($satisfication_row['q5']).'</p></td>
  <td></td>
  </tr>
</table></div>';
	$stylesheet = file_get_contents('bootstrap.css');
	$style = '
	table{page-break-inside: avoid !important;}
	.mv{vertical-align:middle !important;}
	.titl h2{text-align:center;margin-top:0px !important;}
	caption{text-align:left;width:100%;padding:5px 10px;font-weight:bold; border-bottom:1px solid #999}
	.head{font-weight:bold;font-size:13px;}
	p{color:#000;font-weight:normal;font-size:12px;}
	table td{vertical-align:top;padding:7px;font-size:12px;border-bottom:1px solid #ccc}
	table th{text-align:center;color:#2a6496;font-size:13px;}
	table td p{margin-top:10px;}
	.text-left{text-align:left !important;}
	.table thead tr th, .table tbody tr td{padding:10px !important;}
	@media print{.table-bordered>tbody>tr>td, .table-bordered>thead>tr>th{border: 1px solid #000 !important} .table th{color:#000;}}
	';
	$mpdf->SetHTMLHeader("<table width=\"100%\"><tr><td width=\"40%\" align=\"left\"><img src=\"EnerSyslogo.png\" width=\"150\"/></td><td width=\"20%\" align=\"center\" class=\"mv\"><h1 style=\"font-family:'Times New Roman', Times, serif\"><b><i>e-FSR</i></b></h1></td><td width=\"40%\" align=\"right\"><img src=\"Going_Green.png\" height=\"75\"/></td></tr></table>");
	//$mpdf->SetHTMLFooter("<table width=\"100%\"><tr><td width=\"50%\" align=\"left\"><b>(Customer Signature)</b><p><img src='data:image/jpg;base64,".alias($ticket_alias,'ec_e_signature','ticket_alias','e_signature')."' alt='Engineer Signature' width='80'></p></td>
	//<td width=\"50%\" align=\"right\" class=\"mv\"><b>(Engineer Signature)</b><p><img src='data:image/jpg;base64,".alias($ticket_alias,'ec_e_signature','ticket_alias','engineer_sign')."' alt='Engineer Signature' width='80'></p></td></tr></table>");
	$mpdf->SetHTMLFooter("<table width=\"100%\" style=\"vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;\">
	<tr><td width=\"50%\" align=\"left\"><b>(Customer Signature)</b><p><img src='data:image/jpg;base64,".alias($ticket_alias,'ec_e_signature','ticket_alias','e_signature')."' alt='Engineer Signature' width='80'></p></td>
	<td width=\"50%\" align=\"right\" class=\"mv\"><b>(Engineer Signature)</b><p><img src='data:image/jpg;base64,".alias($ticket_alias,'ec_e_signature','ticket_alias','engineer_sign')."' alt='Engineer Signature' width='80'></p></td></tr>
	</table><p style=\"text-align: right;font-weight: bold; font-style: italic;\">{PAGENO}/{nbpg}</p>");
	$mpdf->pagenumPrefix = 'Page No : ';
	$mpdf->SetWatermarkImage('EnerSyslogoD.png');
	$mpdf->showWatermarkImage = true;
	$mpdf->watermarkImageAlpha = 0.05;
	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($style,1);
	$mpdf->WriteHTML($res,2);
	//$mpdf->Output();
	$mpdf->Output("$filename.pdf", "I");
		//D: download the PDF file
		//I: serves in-line to the browser
		//S: returns the PDF document as a string
		//F: save as file file_out
	exit;
function star($q){
	for($i=1;$i<=5;$i++){
		if($i<=$q){$s='rated';}else{$s='empty';}
		$res.='<img src="'.$s.'.png" height="20" width="20">';
	}return $res;
}
function alias($alias,$tb,$col,$retrive){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT $retrive FROM $tb WHERE $col='$alias' AND flag=0");
	if(mysqli_num_rows($sql)){
		$row = mysqli_fetch_array($sql);
		return $row[$retrive];
	}
}
function coll($fv1){
	if($fv1>1) return 'colspan="'.$fv1.'"';
}
function check_empty($label,$val){
	return (!empty($val) ? "$label<p>$val</p>" : ""); //if(!empty($val)){ return "$label<p>$val</p>";}else{return "";}
}
function check_depend($check1,$check2,$label,$val){
	return ($check1 == $check2 ? "$label<p>$val</p>" : "");
}
?>