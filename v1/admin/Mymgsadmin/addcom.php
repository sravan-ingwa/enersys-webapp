<?php 
include('functions.php');

if(isset($_REQUEST['submit'])){
	$compname=$_REQUEST['cname'];
	if($compname==""){$result="Enter Company Name";}
	else{
		$status = 'Active';
		$d = checkx(rand(0000, 9999),'ss_company_details');
		if(!empty($_FILES['file1']['name']) && !empty($_FILES['file2']['name'])){
			if (file_exists("../img/logo/" . $_FILES["file1"]["name"]) && file_exists("../img/favicon/" . $_FILES["file2"]["name"]) ) {
				$result=$_FILES["file1"]["name"] . " already exists.<br> ". $_FILES["file2"]["name"]."Already existed";
			}else{	
					if ($_FILES["file1"]["type"] == "image/png" && $_FILES["file2"]["type"] == "image/png"){
						$tmpName1 = $_FILES['file1']['tmp_name'];
						$tmpName2 = $_FILES['file2']['tmp_name'];
						list($width, $height) = getimagesize($tmpName1);
						list($width1, $height1) = getimagesize($tmpName2);
						if(($height <= 700 && $width <= 800) && ($height1 <= 32 && $width1 <= 32)){		
							move_uploaded_file($_FILES["file1"]["tmp_name"],"../img/logo/" . $_FILES["file1"]["name"]);
							$logoimg = "img/logo/" . $_FILES["file1"]["name"];
							move_uploaded_file($_FILES["file2"]["tmp_name"],"../img/favicon/" . $_FILES["file2"]["name"]);
							$faviimg = "img/favicon/" . $_FILES["file2"]["name"];
							mysql_query("insert into ss_company_details (id,compName,logo,favicon,status,flag) value ('$d','$compname','$logoimg','$faviimg','$status','0')") or die("query not executed");
							$result='Sucessfully Added The Request ';
						}else{$result='images too large';}
					}else{$result='images Should Be in .png Format';}
				}
			}else{$result='Please Select all the Images';}
		}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <title></title>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body role="document">
    <?php include('header.php');?>
    <div class="container-fluid"><!-- Starting Of Body Container -->
        <div class="row">
            <div class="col-xs-1"></div>
            <div class="col-xs-10">
                <div class="panel panel-primary">
                	<div class="panel-heading"><h3 class="panel-title">Menu Listing</h3></div>
                    <div class="panel-body">
                    	<p class="errorP"><?php if(isset($result))echo $result;?></p>
                        <form role="form" class="ss_form" method="post" enctype="multipart/form-data">
                            <div><label>Comapny Name</label><input type="text" class="form-control frm1" name="cname" placeholder="Comapny Name"></div>
                            <div><label>Company Logo</label><input type="file" class="form-control frm1" name="file1"></div>
                            <div><label>Company Favicon</label><input type="file" class="form-control frm1" name="file2"></div>
                            <div>
                            	<button type="submit" class="btn btn-primary ss_buttons" name="submit">Submit</button>
                            	<button type="reset" class="btn btn-primary ss_buttons" name="reset">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>            	
			</div>
            <div class="col-xs-1"></div>
        </div>
    </div><!-- Closing Of Body Container -->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.js"></script>
	<script>
		$('.tooltips').tooltip();
		$(".ss_form div").addClass("col-md-4 form-group");
		$(".ss_form div:last").removeClass("col-md-4").addClass("col-xs-12");
		$(".ss_form input, .ss_form select, .ss_form textarea").addClass("form-control");
    </script>    
  </body>
</html>
