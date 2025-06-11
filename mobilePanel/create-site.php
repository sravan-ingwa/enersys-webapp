<?php include('mysql.php');
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++){$randomString .= $characters[rand(0, $charactersLength - 1)];}
		return strtoupper($randomString);
	}
	function aliasCheck($fv1,$fv2,$fv3){global $mr_con;
		$rec=mysqli_query($mr_con,"SELECT id FROM $fv2 WHERE $fv3='$fv1'");
		if(mysqli_num_rows($rec)==0)return $fv1; else return aliasCheck(generateRandomString(),$fv2,$fv3);
	}
	if($_REQUEST['sub']){
		$alias = aliasCheck(generateRandomString(),'ec_sitemaster','site_alias');
		$zone_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['zone_alias']));
		$state_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['state_alias']));
		$district_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['district_alias']));
		$segment_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['segment_alias']));
		$customer_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['customer_alias']));
		$site_type_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_type_alias']));
		$site_id = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_id']));
		$site_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_name']));
		$product_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['product_alias']));
		$mfd_date = mysqli_real_escape_string($mr_con,$_REQUEST['mfd_date']);
		$install_date = mysqli_real_escape_string($mr_con,$_REQUEST['install_date']);
		$no_of_string = mysqli_real_escape_string($mr_con,$_REQUEST['no_of_string']);
		$technician_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['technician_name']));
		$technician_number = mysqli_real_escape_string($mr_con,$_REQUEST['technician_number']);
		$manager_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['manager_name']));
		$manager_number = mysqli_real_escape_string($mr_con,$_REQUEST['manager_number']);
		$manager_mail = mysqli_real_escape_string($mr_con,$_REQUEST['manager_mail']);
		$site_status_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_status_alias']));
		$site_address = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_address']));
		$query=mysqli_query($mr_con,"INSERT INTO ec_sitemaster(zone_alias,state_alias,district_alias,segment_alias,customer_alias,site_type_alias,site_id,site_name,site_alias,product_alias,mfd_date,install_date,no_of_string,technician_name,technician_number,manager_name,manager_number,manager_mail,site_status_alias,site_address,created_date) VALUES('$zone_alias','$state_alias','$district_alias','$segment_alias','$customer_alias','$site_type_alias','$site_id','$site_name','$alias','$product_alias','$mfd_date','$install_date','$no_of_string ','$technician_name','$technician_number','$manager_name','$manager_number','$manager_mail','$site_status_alias','$site_address','".date('Y-m-d')."')");
		echo "Success";
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Enersys Care</title>
<link href="css/bootstrap.css" rel="stylesheet">
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
                    <form method="post">
                    <div class="col-md-4 form-group">
                    <label>Zone:</label>
                    <select class="form-control" name="zone_alias"><?php echo getdrop('zone_alias','zone_name','ec_zone');?></select>
                    </div>
                    <div class="col-md-4 form-group">
                    <label>State:</label>
                    <select class="form-control" name="state_alias"><?php echo getdrop('state_alias','state_name','ec_state');?></select>
                    </div>
                    <div class="col-md-4 form-group">
                    <label>District:</label>
                    <select class="form-control" name="district_alias"><?php echo getdrop('district_alias','district_name','ec_district');?></select>
                    </div>
                    <div class="col-md-4 form-group">
                    <label>Segment:</label>
                    <select class="form-control" name="segment_alias"><?php echo getdrop('segment_alias','segment_name','ec_segment');?></select>
                    </div>
                    <div class="col-md-4 form-group">
                    <label>Customer:</label>
                    <select class="form-control" name="customer_alias"><?php echo getdrop('customer_alias','customer_name','ec_customer');?></select>
                    </div>
                    <div class="col-md-4 form-group">
                    <label>Site Type:</label>
                    <select class="form-control" name="site_type_alias"><?php echo getdrop('site_type_alias','site_type','ec_site_type');?></select>
                    </div>
                    <div class="col-md-4 form-group">
                    <label>Site Id:</label>
                    <input class="form-control" type="text" name="site_id">
                    </div>
                    <div class="col-md-4 form-group">
                    <label>Site Name:</label>
                    <input class="form-control" type="text" name="site_name">
                    </div>
                    <div class="col-md-4 form-group">
                    <label>Product:</label>
                    <select class="form-control" name="product_alias"><?php echo getdrop('product_alias','product_description','ec_product');?></select>
                    </div>
                    <div class="col-md-4 form-group">
                    <label>MFD Date:</label>
                    <input class="form-control datepick" type="text" name="mfd_date">
                    </div>
                    <div class="col-md-4 form-group">
                    <label>Install Date:</label>
                    <input class="form-control datepick" type="text" name="install_date">
                    </div>
                    <div class="col-md-4 form-group">
                    <label>No Of String:</label>
                    <input class="form-control" type="text" name="no_of_string">
                    </div>
                    <div class="col-md-4 form-group">
                    <label>Technician Name:</label>
                    <input class="form-control" type="text" name="technician_name">
                    </div>
                    <div class="col-md-4 form-group">
                    <label>Technician Number:</label>
                    <input class="form-control" type="text" name="technician_number">
                    </div>
                    <div class="col-md-4 form-group">
                    <label>Manager Name:</label>
                    <input  class="form-control"type="text" name="manager_name">
                    </div>
                    <div class="col-md-4 form-group">
                    <label>Manager Number:</label>
                    <input class="form-control" type="text" name="manager_number">
                    </div>
                    <div class="col-md-4 form-group">
                    <label>Manager Mail:</label>
                    <input class="form-control" type="text" name="manager_mail">
                    </div>
                    <div class="col-md-4 form-group">
                    <label>Site Status:</label>
                    <select class="form-control" name="site_status_alias"><?php echo getdrop('site_status_alias','site_status','ec_site_status');?></select>
                    </div>
                    <div class="col-md-4 form-group">
                    <label>Site Address:</label>
                    <input class="form-control" type="text" name="site_address">
                    </div>
					<div class="col-md-4 col-md-offset-5 form-group">
                        <input type="submit" name="sub" value="Submit">
                    </div>
                    </form>
                    </div>
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
function getdrop($ali,$col,$tb){ global $mr_con;
	$query=mysqli_query($mr_con,"SELECT $ali,$col FROM $tb WHERE flag=0");
	 $res="<option value=''>$col</option>";
	if($query->num_rows){
		while($row=mysqli_fetch_array($query)){
			$res.="<option value='$row[$ali]'>$row[$col]</option>";
		}
	}else{ $res.="<option value='' disabled>Add first</option>";}
	return $res;
} 
?>