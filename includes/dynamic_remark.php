<?php
//if($_SERVER["HTTPS"]!='on')echo "<script type='text/javascript'>window.top.location='https://enersyscare.co.in".$_SERVER['REQUEST_URI']."';</script>";
// if($_SERVER["HTTPS"]!='on')header('Location: https://enersyscare.co.in'.$_SERVER['REQUEST_URI']);
include('../services/mysql.php');
include('../services/functions.php');
if(isset($_REQUEST['verify'])){
	$link1=mysqli_real_escape_string($mr_con,$_REQUEST['verify']);
	list($link,$ref) = explode("@@",base64_decode($link1));
	list($verify,$mrf_alias,$emp_ali) = explode("_@",base64_decode($link));
	$q2=mysqli_query($mr_con,"SELECT flag,mrf_alias,employee_alias FROM ec_dynamic_verification WHERE employee_alias='$emp_ali' AND verification_code='$link' AND mrf_alias='$mrf_alias'");
	if(mysqli_num_rows($q2)){ 
		$rq2 = mysqli_fetch_array($q2);
		if($rq2['flag']=='0'){
			$emp_alias = $rq2['employee_alias'];
			$mrf_alias = $rq2['mrf_alias'];
			$emp_id = alias($emp_alias,'ec_employee_master','employee_alias','employee_id');
			$empName = alias($emp_alias,'ec_employee_master','employee_alias','name');
			$last_updated = alias($mrf_alias,'ec_material_request','mrf_alias','last_updated');
			$lastUpdated = strtotime($last_updated);
			$lastUpdated = $lastUpdated + (24 * 60 * 60);
			$newDate = strtotime(date("Y-m-d H:i:s"));
			if($lastUpdated < $newDate) {
				$err = "Sorry, Your link expired and please perform the action through the web application.";
			} else {
				$suc = "Hello <strong>". $empName ."</strong>";
			}
			$sjo_num = alias($mrf_alias,'ec_material_request','mrf_alias','sjo_number');
		}else{
			$q3=mysqli_query($mr_con,"SELECT bucket,remarked_by FROM ec_remarks WHERE bucket IN('20','21','22') AND module='MR' AND item_alias='$mrf_alias' AND flag='0' ORDER BY id DESC LIMIT 1");
			 if(mysqli_num_rows($q2)){ $rq3 = mysqli_fetch_array($q3);
				$err = "This request already ".($rq3['bucket']=='21' ? "APPROVED" : ($rq3['bucket']=='20' ? "HOLD" : "REJECT"))." by ".alias($rq3['remarked_by'],'ec_employee_master','employee_alias','name');
			 }else $err = "Sorry, Your Link Expired as action is already taken."; 
		}
	}else $err = "Sorry, Your Link Expired as action is already taken.";
}else $err = "Authentication failed";
?>
<html>
<head>
<link href="../styles/main.min.css" rel="stylesheet" type="text/css" />
<link href="../styles/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Roboto:400,500,700,300' rel='stylesheet' type='text/css' />
<link href="../styles/angular-material.min.css" rel="stylesheet" />
<link href="../styles/lazyload/tables.css" rel="stylesheet" />
<style>
body{ letter-spacing: .5px; background: #efefef;}
.page-auth .auth-container { margin: 77px auto;}
.form-control {box-shadow: none !important;border: none;border-radius: 0!important;border-bottom: 1px solid #e0e0e0;position: relative;overflow: hidden;}
.form-control:focus{ border-bottom: 2px solid #3b5998;}
.loader{position: absolute; top: 42%; left: 48%; z-index: 10000;}
.expLoader{width: 100%;background-color: transparent;height: 100%;position: absolute;z-index: 10; right:0px; top:0px; display:none;}
</style>
</head>
<body class="app off-canvas theme-zero body-full">
<div class="page page-auth">
    <div class="auth-container" style="max-width:600px;margin:50px auto">
            <div class="alert alert-success suc_msg <?php echo (isset($suc) ? "" : "hidden"); ?>" align="center">
            	<?php echo $suc; ?><br/>Please Enter your Remarks against SJO <?php echo (isset($sjo_num) ? $sjo_num : ""); ?>.
            </div>
            <?php /* ?><div class="alert alert-info err_msg <?php echo (isset($info) ? "" : "hidden"); ?>" align="center">
              <?php echo $info; ?>
            </div><?php */ ?>
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
                <input type="hidden" name="link" value="<?php echo (isset($link) && !empty($link) ? $link : ""); ?>" />
                <input type="hidden" name="emp_alias" value="<?php echo (isset($emp_alias) ? $emp_alias : ""); ?>" />
                <input type="hidden" name="mrf_alias" value="<?php echo (isset($mrf_alias) ? $mrf_alias : ""); ?>" />
				<input type="hidden" name="ref" value="<?php echo (isset($ref) && !empty($ref)  ? $ref : ""); ?>" />
				<!--
                <div class="col-sm-6 mb20">
					<p class="form-control" style="text-align:left"><?php echo (isset($emp_id) ? "<b>".$emp_id."</b>" : ""); ?></p>
				</div>
				-->
				<div class="col-sm-6 mb20">
				  <input type="hidden" name="password" class="form-control" value="dynamic"/>
                </div>
				<div class="col-sm-12 mb20">
					<textarea class="form-control" name="remarks" placeholder="Enter your Remarks"></textarea>
                </div>
                <div class="btn-group btn-group-justified mb15">
                    <div class="btn-group">
                        <button type="button" class="btn btn-facebook">Cancel</button>
                    </div>
                    <div class="btn-group">
                        <button type="button" name="submit" onClick="dynamic_ajax_rem();" class="btn btn-success">Submit</button>
                    </div>
                </div> 
            </form>
		<?php }else{echo "<a href='".baseurl()."' class='btn btn-success'>Go To Login Page</a>";} ?>
        </div>
    </div> <!-- #end signin-container -->
<script src="../scripts/jquery-1.10.2.js" type="text/javascript"></script>
<script>$('body').addClass("body-full");</script>
<!--<script src="https://code.jquery.com/jquery-1.12.4.js" type="text/javascript"></script>-->
<script type="text/javascript">
	function dynamic_ajax_rem(){
		jQuery('.expLoader').show();
		setTimeout(function(){
			var data = new FormData($('.reset_form')[0]);
			jQuery.ajax({
				url: "/includes/dynamic_ajax_rem.php",
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
					$('.page-auth .auth-container').css('margin','20px auto');
					$('.'+cl).children().fadeOut(7000);
					var set = setTimeout(function(){ $('.'+cl).addClass('hidden');$('.page-auth .auth-container').css('margin','50px auto');},5000);
				}
			});
		},100);
	}
	jQuery(function(){
		jQuery('p button').click(function(){
			jQuery(this).toggleClass('active');
		});
	});
</script>
</body>
</html>