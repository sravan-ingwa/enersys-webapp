<?php 
include('functions.php');

if(isset($_REQUEST['submit'])){
	$a=$_REQUEST['MainMenu'];
	$b=$_REQUEST['SubMenu'];
	$c=$_REQUEST['tblName'];
	if($a=="" || $c==""){$result="Enter MainMenu and Table Name";}
	else{
		$query=mysql_query("SELECT * FROM ss_menu WHERE mainMenu ='$a' AND subMenu='$b' AND tbName='$c'");
		$count=mysql_num_rows($query);
		if($count==0){
		$d = checkx(rand(0000, 9999),'ss_menu');
		$ac = mysql_query("INSERT INTO ss_menu(id,mainMenu,subMenu,tbName,flag) value('$d','$a','$b','$c','0')");
		if($ac)$result="Sucessfully Created the Menu";else $result="Sorry Please try Again!";	
		}else{$result="Menu already Avalilable!Please try with other Menu";}
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
                        <form role="form" class="ss_form" method="post">
                            <div>
                                <label>Main Menu</label>
                                <input type="text" name="MainMenu" placeholder="Enter MainMenu">
                            </div>
                            <div>
                                <label>Sub Menu</label>
                                <input type="text" name="SubMenu" placeholder="Enter SubMenu">
                            </div>
                            <div>
                                <label>Table Name</label>
                                <select name="tblName"><option value="">[Select Table]</option><?php tblname();?></select>
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
  </body>
</html>
