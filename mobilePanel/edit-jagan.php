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
	$alias=$_REQUEST['alias'];
	$emp_id=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_id']));
	$emp_name=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['name']));
	$device=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['device']));
	$device_2=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['device_2']));
	$query=mysqli_query($mr_con,"UPDATE ec_employee_master SET name='$emp_name', employee_id='$emp_id',device='$device',device_2='$device_2' WHERE employee_alias='$alias'");
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
					<h3 class="panel-title" style="display:inline-block;">Edit Employee</h3>
				</div>
				<div class="panel-body">
                <form method="POST">
                	<input type="hidden" value="<?php echo $_REQUEST['x'];?>" name="alias">
	                <div class="col-md-6 form-group">
    		            <label>Employee ID : </label>
                        <input type="text" class="form-control" value="<?php echo alias($_REQUEST['x'],'ec_employee_master','employee_alias','employee_id');?>" name="emp_id">
            		</div>
	                <div class="col-md-6 form-group">
    		            <label>Employee Name : </label>
                        <input type="text" class="form-control" name="name" value="<?php echo alias($_REQUEST['x'],'ec_employee_master','employee_alias','name');?>">
            		</div>
	                <div class="col-md-6 form-group">
    		            <label>Device : </label>
                        <input type="text" class="form-control" name="device" value="<?php echo alias($_REQUEST['x'],'ec_employee_master','employee_alias','device')?>">
            		</div>
	                <div class="col-md-6 form-group">
    		            <label>Device 2 : </label>
                        <input type="text" class="form-control" name="device_2" value="<?php echo alias($_REQUEST['x'],'ec_employee_master','employee_alias','device_2')?>">
            		</div>
	                <div class="col-md-12 form-group" align="center">
                        <input type="submit" name="sub" value="Submit">
            		</div>
                
                </form>
			</div>
		</div>
	</div>
</div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
