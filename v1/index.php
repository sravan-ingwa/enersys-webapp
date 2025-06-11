<?php 
include('lock.php');
if(isset($_SESSION['login_user'])){ 
	include('functions.php');
?>
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
<link href="css/main.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="all" href="css/jquery-ui.css" /> <!-- this is for date picker-->
<style>
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
  border: 0 !important;
  background: none !important;
  }
</style>
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style>table{height:100%;}td.height{height:100%;}
.pager{margin:0 !important;float:right;color:#000 !important;}
.pager li label{padding:0 10px; color:#FFF !important;}
</style>
</head>
<body role="document" onLoad="xyz()">
<div class="loadx"><table width=100% height=100%><tr><td class="height" style="text-align: center; vertical-align: middle;"><img src="img/loader_115_115.GIF"></td></tr></table></div>
<?php /*?><div class="loadx"><table width=100% height=100%><tr><td class="height" style="text-align: center; vertical-align: middle;"><img src="img/loader_115_115.GIF"></td></tr></table></div><?php */?>
<?php include('header.php'); ?>
<div class="container-fluid"><!-- Starting Of Body Container -->
    <div class="row">
        <div class="col-xs-12">
        <div id="myText"></div>
            <?php if($_REQUEST['x']){?>
		<div class="panel panel-primary" style="border:none !important;">
                <div class="panel-heading">
                
				<form id="sortform" method="POST">
                    <h3 class="panel-title" style="display:inline-block;"><?php echo menuName($_REQUEST['x'],"menu"); ?></h3>
					<ul class="pager" style="display:inline-block;">
                        <li><label class="hidden-xs">Count Per Page </label><select name='countt'  onchange='xyz()'><option value='10'>10</option><option value='20'>20</option><option value='30'>30</option><option value='50'>50</option><option value='80'>80</option><option value='100'>100</option></select></li>
                        <li><label class="hidden-xs">Page No. </label><select name='PageV' onchange='xyz()' id='pagx'></select></li>
                    </ul>
					
                </div>
				<div>
<?php } ?>	

						<?php 
                        if(!isset($_REQUEST['x'])){include('admin/welcome.php');}
						elseif($_REQUEST['x'] != 1764){include('tableViewScript.php');}
						else{include('tableViewInvetoryBalance.php');}
                        ?>
                    <?php echo $result;?>
				</div>
            </div>
        </div>
    </div>
</div><!-- Closing Of Body Container -->
<!-- Closing Of Body Container -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.popconfirm.js"></script>
<script src="js/index.js"></script>
<script src="js/jquery-ui.js"></script> <!-- this is for date picker-->
<script>
function xyz(){
	$.ajax({
		type: "GET",
		url: "ajaxTable.php",
		data: $("#sortform").serialize(),
		cache: true,
		success: function(result){
			result=result.split("##");
			$('.sortdis').html(result[0]);
			$('#totalcount').val(result[1]);
			$('#pagx').html(result[2]);
		}
	});
}
//$('.singleDate').datetimepicker({format:'YYYY-MM-DD'}).on("dp.change",function(e){xyz()});
$( "#datepicker" ).datepicker({dateFormat: 'yy-mm-dd'}).bind("change",function(){ xyz()});
</script>
</body>
</html>
<?php }else{echo "<script type='text/javascript'>window.location='login.php'</script>";} ?>