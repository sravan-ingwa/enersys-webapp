<?php
//if($_SERVER["HTTPS"]!='on')echo "<script type='text/javascript'>window.top.location='https://enersyscare.co.in".$_SERVER['REQUEST_URI']."';</script>";
if($_SERVER["HTTPS"]!='on')header('Location: https://enersyscare.co.in'.$_SERVER['REQUEST_URI']);
include('../services/mysql.php');
include('../services/functions.php');
if(isset($_REQUEST['verify'])){
	$link=mysqli_real_escape_string($mr_con,$_REQUEST['verify']);
	list($verify,$emp_id) = explode("_@",base64_decode($link));
	if(strtoupper($emp_id)=='ADMIN' || strtoupper($emp_id)=='EADMIN'){
		$q2=mysqli_query($mr_con,"SELECT UPPER(user_name) AS emp_name FROM ec_admin WHERE verification_code='$link' AND user_name='$emp_id' AND flag='0'");
	}else{
		$q2=mysqli_query($mr_con,"SELECT UPPER(name) AS emp_name,employee_alias FROM ec_employee_master WHERE verification_code='$link' AND employee_id='$emp_id' AND flag='0'");
	}if(mysqli_num_rows($q2)){ $rq2 = mysqli_fetch_array($q2);
		$suc = "Hello <strong>".$rq2['emp_name']."</strong>";
		$emp_alias = ($rq2['emp_name']=='ADMIN' || $rq2['emp_name']=='EADMIN' ? $rq2['emp_name'] : $rq2['employee_alias']);
	}else{ $err = "Sorry, Your Link Expired."; }
}else{ $err = "Authentication failed"; }
?>
<html>
<head>
<link href="../styles/main.min.css" rel="stylesheet" type="text/css" />
<link href="../styles/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Roboto:400,500,700,300' rel='stylesheet' type='text/css' />
<link href="../styles/angular-material.min.css" rel="stylesheet" />
<link href="../styles/lazyload/tables.css" rel="stylesheet" />
<style>
body {
    letter-spacing: .5px;
    background: #efefef;
}
.page-auth .auth-container {
    margin: 77px auto;
}
.form-control {
    box-shadow: none !important;
    border: none;
    border-radius: 0!important;
    border-bottom: 1px solid #e0e0e0;
    position: relative;
    overflow: hidden;
}
.form-control:focus{
	 border-bottom: 2px solid #3b5998;
}
.loader{position: absolute; top: 42%; left: 48%; z-index: 10000;}
.expLoader{width: 100%;background-color: transparent;height: 100%;position: absolute;z-index: 10; right:0px; top:0px; display:none;}
</style>
</head>
<body class="app off-canvas theme-zero body-full">
<div class="page page-auth">
    <div class="auth-container">
            <div class="alert alert-success suc_msg <?php echo (isset($suc) ? "" : "hidden"); ?>" align="center">
            	<?php echo $suc; ?>
            </div>
            <div class="alert alert-danger err_msg <?php echo (isset($err) ? "" : "hidden"); ?>" align="center">
              <?php echo $err; ?>
            </div>
        <div class="form-head mb20">
            <h1 class="site-logo h2 mb5 mt5 text-center text-uppercase text-bold"><img src="../images/gallery/EnerSyslogo.png" alt="logo" width="250"><span class="version">V 2.0</span></h1>
        </div>
        <div class="form-container" align='center'>
		<?php if(!isset($err)){ ?>
            <div class="expLoader"><span class="loader"><img src="../images/ajax-loader.gif" height="40" width="40" alt="loader"></span></div>
            <form class="form-horizontal reset_form" method="post" novalidate>
       			 <p align="center"><small><b>Please Enter Your New Password</b></small></p>
                <input type="hidden" name="emp_alias" value="<?php echo (isset($emp_alias) ? $emp_alias : ""); ?>" />
                <div class="col-sm-12 mb20">
                    <input type="password" class="form-control" name="pwd" placeholder="Enter Password" />
                </div>
                <div class="col-sm-12 mb20">
                    <input type="password" name="cpwd" class="form-control" placeholder="Enter Confirm Password">
                </div>
                <div class="btn-group btn-group-justified mb15">
                    <div class="btn-group">
                        <button type="reset" class="btn btn-facebook">Reset</button>
                    </div>
                    <div class="btn-group">
                        <button type="button" name="submit" onClick="reset_ajax_pwd();" class="btn btn-success">Submit</button>
                    </div>
                </div> 
            </form>
		<?php }else{echo "<a href='".baseurl()."' class='btn btn-success'>Go To Login Page</a>";} ?>
        </div>
    </div> <!-- #end signin-container -->
<script>$('body').addClass("body-full");</script>
<script src="../scripts/jquery-1.10.2.js" type="text/javascript"></script>
<script type="text/javascript">
	function reset_ajax_pwd(){
		$('.expLoader').show();
		var data = new FormData($('.reset_form')[0]);
		//var emp_alias = $("input[name=emp_alias]").val();
		//var pwd = $("input[name=pwd]").val();
		//var cpwd = $("input[name=cpwd]").val();
		//var data = "emp_alias="+emp_alias+"&pwd="+pwd+"&cpwd="+cpwd;
		$.ajax({
			url: "<?php echo baseurl(); ?>includes/reset_ajax_pwd.php",
			type: "POST",
			data: data,
			cache: false,
			async: false,
			processData: false,
			contentType: false,
			success: function(result){
				$('.expLoader').hide();
				var cl,res = result.split('@@');
				if(res[0]==0){
					cl = 'suc_msg';
					$('.form-container').html("<a href='<?php echo baseurl(); ?>' class='btn btn-success'>Go To Login Page</a>");
				}else cl = 'err_msg';
				
				//clearTimeout(set);
				$('.'+cl).removeClass('hidden');
				$('.'+cl).html("<span>"+res[1]+"</span>");
				$('.'+cl).children().fadeOut(7000);
				var set = setTimeout(function(){ $('.'+cl).addClass('hidden'); },5000);
			}
		});
	}
	$(function(){
		$('p button').click(function(){
			$(this).toggleClass('active');
		});
	});
</script>
</body>
</html>