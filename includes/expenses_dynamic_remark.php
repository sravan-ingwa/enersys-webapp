<?php
//if($_SERVER["HTTPS"]!='on')echo "<script type='text/javascript'>window.top.location='https://enersyscare.co.in".$_SERVER['REQUEST_URI']."';</script>";
// if($_SERVER["HTTPS"]!='on')header('Location: https://enersyscare.co.in'.$_SERVER['REQUEST_URI']);
include('../services/mysql.php');
include('../services/functions.php');
// Function to get the client IP address
$ipaddress = getenv('HTTP_CLIENT_IP') ?: getenv('HTTP_X_FORWARDED_FOR') ?:
getenv('HTTP_X_FORWARDED') ?: getenv('HTTP_FORWARDED_FOR')?:
getenv('HTTP_FORWARDED') ?: getenv('REMOTE_ADDR');
if(isset($_REQUEST['verify'])){
	$baseUrl = "/";
	$verify = mysqli_real_escape_string($mr_con, $_REQUEST['verify']);
	list($table, $alias, $emp_alias, $ref, $ref2) = explode("@@", base64_decode($verify));
	$empName = alias($emp_alias, 'ec_employee_master', 'employee_alias', 'name');
	if($table == 'expense') {
		$url = $baseUrl . "services/expense_tracker/others_expences_edit";
		$expStatusQuery = "SELECT * FROM ec_expenses WHERE expenses_alias = '$alias'";
		$expStatusSql = mysqli_query($mr_con, $expStatusQuery);
		$expDetails = mysqli_fetch_array($expStatusSql);
		if($expDetails['flag'] == 0 && $expDetails['approval_level'] == $ref2 && !empty($empName)) {
			$lastUpdated = strtotime($expDetails['last_updated']);
			$lastUpdated = $lastUpdated + (24 * 60 * 60);
			$newDate = strtotime(date("Y-m-d H:i:s"));
			if($lastUpdated < $newDate) {
				$err = "Sorry, Your link expired and please perform the action through the web application.";
			} else {
				$suc = "Hello <strong>". $empName ."</strong>";
			}
		} else {
			$err = "Sorry, Your Link Expired.";
		}
	} else if($table == 'advance') {
		$url = $baseUrl . "services/expense_tracker/advances_update";
		$expStatusQuery = "SELECT * FROM ec_advances WHERE advance_alias = '$alias'";
		$expStatusSql = mysqli_query($mr_con, $expStatusQuery);
		$expDetails = mysqli_fetch_array($expStatusSql);
		if($expDetails['flag'] == 0 && $expDetails['approval_level'] == $ref2 && !empty($empName)) {
			$lastUpdated = strtotime($expDetails['last_updated']);
			$lastUpdated = $lastUpdated + (24 * 60 * 60);
			$newDate = strtotime(date("Y-m-d H:i:s"));
			if($lastUpdated < $newDate) {
				$err = "Sorry, Your link expired and please perform the action through the web application.";
			} else {
				$suc = "Hello <strong>". $empName ."</strong>";
			}
		} else {
			$err = "Sorry, Your Link Expired.";
		}
	} else {
		$err = "Sorry, Your Link Expired.";
	}
}else $err = "Authentication failed.";
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
            	<?php echo $suc; ?><br/> Please Enter your Remarks.
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
                <input type="hidden" name="emp_alias" value="<?php echo (isset($emp_alias) ? $emp_alias : ""); ?>" />
				<input type="hidden" name="id" value="<?php echo (isset($alias) ? $alias : ""); ?>" />
				<input type="hidden" name="advance_alias" value="<?php echo (isset($alias) ? $alias : ""); ?>" />
				<input type="hidden" name="ip_addr" value="<?php echo $ipaddress; ?>"/>
				<input type="hidden" name="ref" value="<?php echo (isset($ref) && !empty($ref)  ? $ref : ""); ?>"/>				
				<input type="hidden" name="ref2" value="<?php echo (isset($ref2) && !empty($ref2)  ? $ref2 : ""); ?>" />
				<input type="hidden" name="refer" value="<?php echo (isset($ref2) && !empty($ref2)  ? $ref2 : ""); ?>" />
				<div class="col-sm-12 mb20">
				  <input type="hidden" name="password" class="form-control" value="dynamic"/>
				</div>
				<?php
					if($table == 'expense' && $ref == 'request') {
						if($ref2 == 3) {
							// echo "<div class='col-sm-12 mb20'>";
							// 	echo "<input type='text' name='po_gnr' class='form-control' placeholder='PO/GNR Number'/>";
						  	// echo "</div>";
						} else if($ref2 == 4) {
							echo "<div class='col-sm-6 mb20'>";
								echo "<input type='text' name='rem_amt' class='form-control' placeholder='Reimbursement'/>";
						  	echo "</div>";
							echo "<div class='col-sm-6 mb20'>";
								echo "<input type='text' name='ref_amt' class='form-control' placeholder='Refund'/>";
							echo "</div>";
						}
					}
				?>
				<div class="col-sm-12 mb20">
					<textarea class="form-control" name="reasonForAdv" placeholder="Enter your Remarks"></textarea>
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
		<?php }else{echo "<a href='".$baseUrl."' class='btn btn-success'>Go To Login Page</a>";} ?>
        </div>
    </div> <!-- #end signin-container -->
<script src="../scripts/jquery-1.10.2.js" type="text/javascript"></script>
<script>$('body').addClass("body-full");</script>
<script type="text/javascript">
	function dynamic_ajax_rem(){
		jQuery('.expLoader').show();
		setTimeout(function(){
			var data = new FormData($('.reset_form')[0]);
			jQuery.ajax({
				url: "<?php echo $url ; ?>",
				type: "POST",
				data: data,
				cache: false,
				async: false,
				processData: false,
				contentType: false,
				success: function(result) {
					console.log(result);
					rs = JSON.parse(result);
					cl = "";
					if(rs.ErrorDetails.ErrorCode != '0') {
						cl = "err_msg";
					} else {
						cl = "suc_msg";
						$('.form-container').html("<a href='<?php echo $baseUrl; ?>' class='btn btn-success'>Go To Login Page</a>");
					}
					$('.' + cl).removeClass('hidden');
					$('.' + cl).html("<span>" + rs.ErrorDetails.ErrorMessage + "</span>");
					var set = setTimeout(function(){ 
						$('.' + cl).addClass('hidden');
						$('.page-auth .auth-container').css('margin','50px auto');
					}, 5000);
					jQuery('.expLoader').hide();
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