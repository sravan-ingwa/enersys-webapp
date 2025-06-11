<?php 
include('mysql.php');
function alias($alias,$tb,$col,$retrive){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT $retrive FROM $tb WHERE $col='$alias' AND flag=0");
	if(mysqli_num_rows($sql)){
		$row = mysqli_fetch_array($sql);
		return $row[$retrive];
	}else return 0;
}
if(isset($_REQUEST['sub'])){
	$ticket_alias=$_REQUEST['ticket_alias'];
	$planned_date=mysqli_real_escape_string($mr_con,$_REQUEST['plannedDate']);
	$serviceEngineer=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['serviceEngineer']));
	if($ticket_alias!="" && $ticket_alias!="0" && $planned_date!="" && $planned_date!="0" && $serviceEngineer!="" && $serviceEngineer!="0"){
		$query=mysqli_query($mr_con,"UPDATE ec_tickets SET planned_date='$planned_date', service_engineer_alias='$serviceEngineer',level='2' WHERE ticket_alias='$ticket_alias'");
		$ticket_id=alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
		$reg_id=alias($serviceEngineer,'ec_employee_master','employee_alias','reg_id');
		$msg="New site with TT number $ticket_id is assigned to you . Planned date-$planned_date";
		if($query){ notification($reg_id,$msg);}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Enersys Care</title>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/datepicker.css" rel="stylesheet">
<style>
.nav, .nav li{
float:none !important;
}
.nav li{
display:inline-block !important;
}
.table th{text-align:center !important;}
</style>
</head>
<body>
<?php include "header.php";?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title" style="display:inline-block;">Create Ticket</h3>
				</div>
				<div class="panel-body">
                <form method="POST">
                	<input type="hidden" value="<?php echo $_REQUEST['x'];?>" name="ticket_alias">
	                <div class="col-md-4 form-group">
    		            <label>Planned Date : </label>
                        <input type="text" class="form-control datepick" name="plannedDate">
            		</div>
                    <div class="col-md-4 form-group">
                        <label>Service Engineer : </label>
                        <select name="serviceEngineer" class="form-control" >
                        <option value="0" disabled selected> Select </option>
                        <?php $query=mysqli_query($mr_con,"SELECT * FROM ec_employee_master");while($row=mysqli_fetch_array($query)){?>
                        <option value="<?php echo $row['employee_alias'];?>"><?php echo ucwords(strtolower($row['name']));?></option><?php } ?>
                        </select>
					</div>
                <input type="submit" name="sub" value="Submit">
                </form>
			</div>
		</div>
	</div>
</div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script>
$('.datepick').datepicker({format:"yyyy-mm-dd"});
</script>
</body>
</html>
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