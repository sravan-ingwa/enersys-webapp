<?php 
include('mysql.php');
include('functions.php');
if(isset($_REQUEST['sub'])){
	$emp_alias=aliasCheck(generateRandomString(),'ec_employee_master','employee_alias');
	$emp_name=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_name']));
	$emp_id=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_id']));
	$email=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['email']));
	$mobile=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mobile']));
	$pwd=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['pwd']));
	$zone_alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['zone_alias']));
	$state_alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['state_alias']));
	$base_loc=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['base_loc']));
	$desig_alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['desig_alias']));
	$depart_alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['depart_alias']));
	$role_alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['role_alias']));
	$privilege_alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['privilege_alias']));
	$qualify=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['qualify']));
	$specialize=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['specialize']));
	$total_exp=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['total_exp']));
	$el_exp=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['el_exp']));
	$joining_date=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['joining_date']));
	$relieving_date=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['relieving_date']));
	$device=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['device']));
	$profile_pic=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['profile_pic']));
	$spl_previlage=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['spl_previlage']));
	$query=mysqli_query($mr_con,"INSERT INTO ec_employee_master(
	name,
	employee_id,
	employee_alias,
	email_id,
	mobile_number,
	password,
	zone_alias,
	state_alias,
	base_location,
	designation_alias,
	department_alias,
	role_alias,
	privilege_alias,
	qualification,
	specialization,
	total_experience,
	el_experience,
	joining_date,
	relieving_date,
	device,
	profile_pic,
	created_date,
	spl_previlage
	)VALUES('$emp_name','$emp_id','$emp_alias','$email','$mobile','$pwd','$zone_alias','$state_alias','$base_loc','$desig_alias','$depart_alias','$role_alias','$privilege_alias',
	'$qualify','$specialize','$total_exp','$el_exp','$joining_date','$relieving_date','$device','$profile_pic','$','".date('Y-m-d')."','$spl_previlage')");
}
?>
<!doctype html>
<html>
	<head>
		<title>Employee</title>
	</head>
	<body>
		<form method="post">
			<label>Employee Name : </label><input type="text" name="emp_name"><br>
			<label>Designation : </label>
			<select name="designation">
				<option value="" disabled> Select Designation</option>
				<?php $query=mysqli_query($mr_con,"SELECT designation,designation_alias FROM ec_designation");while($row=mysqli_fetch_array($query)){?>
				<option value="<?php echo $row['designation_alias'];?>"><?php echo $row['designation'];?></option><?php } ?>
			</select><br>
			<label>Grade : </label><input type="text" name="grade"><br>
			<label>Zone : </label>
			<select name="zone">
				<option value="" disabled> Select Zone</option>
				<?php $query=mysqli_query($mr_con,"SELECT zone_name,zone_alias FROM ec_zone");while($row=mysqli_fetch_array($query)){?>
				<option value="<?php echo $row['zone_alias'];?>"><?php echo $row['zone_name'];?></option><?php } ?>
			</select><br>
			<label>State : </label>
			<select name="state">
				<option value="" disabled> Select State </option>
				<?php $query=mysqli_query($mr_con,"SELECT state_name,state_alias FROM ec_state");while($row=mysqli_fetch_array($query)){?>
				<option value="<?php echo $row['state_alias'];?>"><?php echo $row['state_name'];?></option><?php } ?>
			</select><br>
			<label>Base Location : </label><input type="text" name="base_location"><br>
			<label>Qualification : </label>
			<select name="qualification">
				<option value="" disabled> Select Qualification </option>
				<option value="10th">10th</option>
				<option value="Intermediate">Intermediate</option>
				<option value="ITI">ITI</option>
				<option value="Poltechnic">Poltechnic</option>
				<option value="Diploma">Diploma</option>
				<option value="BTech">BTech</option>
				<option value="BSC">BSC</option>
			</select><br>
			<label>Specilization : </label><input type="text" name="specilization"><br> 
			<label>Total Experience : </label><input type="text" name="total_experie8nce"><br>
			<label>EL Experience : </label><input type="text" name="el_experience"><br> 
			<label>Joining Date : </label><input type="date" name="joining_date"><br>
			<label>Relieving Date : </label><input type="date" name="relieving_date"><br>
			<input type="submit" name="sub" value="Submit">
		</form>
	</body>
</html>