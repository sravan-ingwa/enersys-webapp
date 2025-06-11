<?php 
include('functions.php');

if(isset($_REQUEST['submit'])){
	$a=$_REQUEST['zone'];
	$c=$_REQUEST['circle'];
	$b=$_REQUEST['description'];
	$e=$_REQUEST['cluster'];
	if($a=="" || $b=="" || $c=="" || $e==""){$result="Enter Zone Name, Circle, Cluster and Description";}
	else{
		$query=mysql_query("SELECT * FROM ss_clusters WHERE zone ='$a' AND circle= '$c' AND cluster ='$e'");
		$count=mysql_num_rows($query);
		if($count==0){
		$d = checkx(rand(0000, 9999),'ss_circles');
		$ac = mysql_query("INSERT INTO ss_clusters(id,cluster,zone,circle,description,flag) value('$d','$e','$a','$c','$b','0')");
		if($ac)$result="Request Successful!";else $result="Sorry Please try Again!";	
		}else{$result="Already Avalilable!Please try with other value";}
	}
}
$query=mysql_query("SELECT * FROM ss_zone");
if(mysql_num_rows($query)>0){while($row=mysql_fetch_array($query)){$zone.="<option value='$row[id]'>$row[zone]</option>";}}
else{$zone="<option value=''>Add Zones first</option>";}
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
                	<div class="panel-heading"><h3 class="panel-title">Circles Listing</h3></div>
                    <div class="panel-body">
                    	<p class="errorP"><?php if(isset($result))echo $result;?></p>
                        <form role="form" class="ss_form" method="post">
                            <div>
                                <label>Zone</label>
                                <select name="zone" onchange="ajaxSelect(this.options[this.selectedIndex].value,'Circle')">
                                    <option value="">select zone</option><?php zonesOptions(); ?>
                                </select>
                            </div>
                            <div>
                                <label>Circle</label>
                                <select name="circle" id="ajaxSelect_Circle"  onchange="ajaxSelect(this.options[this.selectedIndex].value,'Cluster')">
                                    <option value="">Select Circle</option>
                                </select>
                            </div>
                            <div>
                                <label>Cluster</label>
                                <input type="text" name="cluster" placeholder="Enter Cluster">
                            </div>
                            <div>
                                <label>Description</label>
                                <input type="text" name="description" placeholder="Enter Description">
                            </div>
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
	<script type="text/javascript">function ajaxSelect(id,type){if(id!=""){$.ajax({type:"POST",url:"ajaxSelect.php",data:'type='+type+'&id='+id,cache:false,success:function(result){$("#ajaxSelect_"+type).html(result);}});}if(type=="Circle"){$("#ajaxSelect_Circle").html("<option value=''>Select circle</option>");$("#ajaxSelect_Cluster").html("<option value=''>Select cluster</option>");$("#ajaxSelect_District").html("<option value=''>Select district</option>")}if(type=="Cluster"){$("#ajaxSelect_Cluster").html("<option value=''>Select cluster</option>");$("#ajaxSelect_District").html("<option value=''>Select district</option>")}if(type=="District"){$("#ajaxSelect_District").html("<option value=''>Select district</option>")}}</script>
  </body>
</html>
