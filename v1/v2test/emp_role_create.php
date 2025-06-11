<?php 
include('mysql.php');
include('functions.php');
if($_REQUEST['sub']){
	$role_name=$_REQUEST['role_name'];
	$description=$_REQUEST['desc'];
	$role_alias=aliasCheck(generateRandomString(),'ec_emprole','role_alias');
	$query=mysqli_query($mr_con,"INSERT INTO ec_emprole(role_name,description,role_alias,created_date) 	VALUES('$role_name','$description','$role_alias','".date('Y-m-d')."')");
}
?>
<form method="post">
	<label>Role Name : </label><input type="text" name="role_name"><br>
	<label>Description : </label><input type="text" name="desc"><br>
	<input type="submit" name="sub" value="Submit">
</form>