<?php 
include('mysql.php');
include('functions.php');
if(isset($_REQUEST['sub'])){
	$ticket_id=$_REQUEST['ticket_id'];
	$planned_date=mysqli_real_escape_string($mr_con,$_REQUEST['planned_date']);
	$service_engineer=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['service_engineer']));
	$query=mysqli_query($mr_con,"UPDATE ec_tickets SET planned_date='$planned_date', service_engineer_alias='$service_engineer',level='2' WHERE ticket_id='$ticket_id'");
	$reg_id=alias($service_engineer,'ec_employee_master','employee_alias','reg_id');
	$msg="New site with TT number ".$ticket_id." is assigned to you . Planned date- ".$planned_date;
	if($query)notification($reg_id,$msg);
}
?>
<form enctype='application/json' method="POST">
	<label>Ticket ID : </label>
	<select name="ticket_id">
		<option value="" disabled selected> Select </option>
		<?php $query=mysqli_query($mr_con,"SELECT ticket_id FROM ec_tickets");while($row=mysqli_fetch_array($query)){?>
		<option value="<?php echo $row['ticket_id'];?>"><?php echo $row['ticket_id'];?></option><?php } ?>
	</select>
	<label>Planned Date : </label><input type="text" name="planned_date" value="<?php echo date('Y-m-d'); ?>" readonly>
	<label>Service Engineer : </label>
	<select name="service_engineer">
		<option value="" disabled selected> Select </option>
		<?php $query=mysqli_query($mr_con,"SELECT employee_alias,name FROM ec_employee_master");while($row=mysqli_fetch_array($query)){?>
		<option value="<?php echo $row['employee_alias'];?>"><?php echo ucwords(strtolower($row['name']));?></option><?php } ?>
	</select>
	<input type="submit" name="sub" value="Submit">
</form>
<?php
function notification($reg_id,$mssg){
// API access key from Google API's Console
define('API_ACCESS_KEY', 'AIzaSyCPr4vEYPiylMHvnV--vULqzK4wBMQuGYU');
$registrationIds = array($reg_id);
// prep the bundle
$msg = array('message' 	=> $mssg);
$fields = array(
	'registration_ids' 	=> $registrationIds,
	'data'			=> $msg
);
$headers = array(
	'Authorization: key=' . API_ACCESS_KEY,
	'Content-Type: application/json'
);
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );
}
?>