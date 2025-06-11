<?php 
include('mysql.php');
include('functions.php');
if($_REQUEST['sbmit']){
	$segment_name=$_REQUEST['segment_name'];
	$segment_alias=aliasCheck(generateRandomString(),'ec_segment','segment_alias');
	$query=mysqli_query($mr_con,"INSERT INTO ec_segment(segment_name,segment_alias,created_date) VALUES('$segment_name','$segment_alias','".date('Y-m-d')."')");
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
.dropdown-menu{min-width:50px !important;background:#f1f1f1;}
.dropdown-menu a{padding:10px !important;}
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
<div class="col-md-4 form-group"><label>Segment Name:</label><input class="form-control"  type="text" name="segment_name"></div>
<div class="col-md-4 col-md-offset-5 form-group"><input type="submit" name="sbmit"></div>
</form>
</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
</body>
</html>