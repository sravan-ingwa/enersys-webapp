<?php include('lock.php');?>
<?php if(isset($_SESSION['login_user'])){ ?>
<?php  include('functions.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php TitleFav();?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap-select.min.css" type="text/css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/autoComplete.css" />
<link href="css/autoFill.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datetimepicker.min.css" />
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body role="document">
	<div class="loadx"></div>
	<?php include('header.php');?>
	<?php if(!isset($_REQUEST['x'])){$query = mysql_query("SELECT * FROM ss_menu WHERE flag='0' ORDER BY ordering ");$row=mysql_fetch_array($query);if($row)echo "<script type='text/javascript'>window.location='index.php?x=$row[id]'</script>";else echo"<script type='text/javascript'>window.location='logout.php?ref=noview'</script>";}?>
	<div class="container-fluid"><!-- Starting Of Body Container -->
		<div class="row">
			<div class="col-sm-1 hidden-xs"></div>
			<div class="col-xs-12 col-sm-10">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Create <?php echo menuName($_REQUEST['x'],"menu"); ?></h3>
					</div>
					<div class="panel-body">
						<?php
                            $ref=$_REQUEST['x'];
                            $query=mysql_query("SELECT * FROM ss_menu WHERE id='$ref'");
                            if(mysql_num_rows($query)>0){
                                $row=mysql_fetch_array($query);
                                if(file_exists('include/'.$row['tbName'].'_create.php')){include('include/'.$row['tbName'].'_create.php');}
                                else{echo"<center><h1>Permission Denied</h1></center>";}
                            }
                        ?>
					</div>
				</div>
			</div><!-- Closing Of col-xs-12 -->
			<div class="col-sm-1 hidden-xs"></div>
		</div>
	</div><!-- Closing Of Body Container -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrapValidator.min.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script src="js/validation.js"></script>
<script type="text/javascript" src="js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="js/moment.js"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="js/create.js"></script>
<script>$(window).load(function(){$(".loadx").fadeOut(400);});</script>
</body>
</html>
<?php }else{echo "<script type='text/javascript'>window.location='login.php'</script>";} ?>