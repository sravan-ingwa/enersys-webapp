<?php
include('mysql.php');
date_default_timezone_set("Asia/Kolkata");
function all_from_mail(){ return "enersyscare_no_reply@enersys.com.cn"; }
function alias($alias,$tb,$col,$retrive){global $mr_con;
	$sql = $mr_con->query("SELECT $retrive FROM $tb WHERE $col='$alias' AND flag=0");
	if(mysqli_num_rows($sql)){
		$row = mysqli_fetch_array($sql);
		return $row[$retrive];
	}else return 'NA';
}
function generateRandomString($length = 18) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++){$randomString .= $characters[rand(0, $charactersLength - 1)];}
    return strtoupper($randomString);
}
if(isset($_REQUEST['submiting'])){
	if($_REQUEST['submiting']=="Request"){
		$actual_email_ID=strtoupper(alias($_REQUEST['emp_ID'],'ec_employee_master','employee_id','email_id'));
		$given_email_ID=strtoupper($_REQUEST['email']);
		if($actual_email_ID==$given_email_ID){
			$empalias=alias($_REQUEST['emp_ID'],'ec_employee_master','employee_id','employee_alias');
			$tokenn=generateRandomString();
			$ul= base64_encode($empalias."|".$tokenn);
			$sql=$mr_con->query("INSERT INTO ec_password_change(emp_alias,auth_token) VALUES ('$empalias','$tokenn')");
			$sub = "Password Change Request";
			$res="<p>Dear ".alias($_REQUEST['emp_ID'],'ec_employee_master','employee_id','name').",</p>";
			$res.="<table width='600px' style='border-collapse:collapse;' cellpadding='3' align='center'>";
			$res.="<tr align='center'>";
			$res.="<th align='center' style='border:1px solid #ddd; border-bottom:1px solid #fff;'>";
			$res.="<table width='100%'>";
			$res.="<tr>";
			$res.="<th align='left'><img src='http://enersyscare.co.in/enersys_expense/img/EnerSyslogo.png' alt='EnerSys_logo' width='150'></th>";
			$res.="<th align='right'><h3>EnerSys India Batteries Pvt. Ltd.</h3></th>";
			$res.="</tr>";
			$res.="</table>";
			$res.="</th>";
			$res.="</tr>";
			$res.="<tr>";
			$res.="<td align='center' style='border:1px solid #ddd;'>";
			$res.="<table width='100%' cellpadding='3'>";
			$res.="<tr>";
			$res.="<td align='right'><b>Date :</b>".date("d-m-Y")."</td>";
			$res.="</tr>";
			$res.="<tr>";
			$res.="<td align='right'></td>";
			$res.="</tr>";
			$res.="<tr>";
			$res.="<td align='center'><h3>Request for Password Change</h3></td>";
			$res.="</tr>";
			$res.="<tr>";
			$res.="<td align='center'><p>As you Requested for a password change we have generated a link(Click on below link), which will help you in creating the new password.</p></td>";
			$res.="</tr>";
			$res.="</table>";
			$res.="<table style='border-collapse:collapse;' cellpadding='8' align='center'>";
			$res.="<tr>";
			$res.="<td width='100%' style='border:1px solid #ddd;'><b>Request Link : <a href='http://enersyscare.co.in/enersys_expense/forgetPassword-1.php?x=".$ul."\'>Click Here</a></b></td>";
			$res.="</tr>";
			$res.="</table>";
			$res.="<br><br></td>";
			$res.="</tr>";
			$res.="<tr>";
			$res.="<td align='center'><small>The above link is valid only for 2 Hours.</small></td>";
			$res.="</tr>";
			$res.="</table><br><br>";
			$body=$res;
			$body.="<p style='font-style:italic;text-align:center;'><small>*** This is a System generated email, Please do not reply ***</small></p>";
			$from = all_from_mail();
			$header= 'From: EnerSys Advances <'.$from .'>' . "\r\n";
			$header.= 'Reply-To: '.$from ."\r\n";
			$header.= "Content-Type: text/html\r\n";
			$header.= "X-Mailer: PHP/" . phpversion();
			$header.= 'MIME-Version: 1.0' . "\r\n";
			$admin = "-odb -f $from";
			$abc = mail($actual_email_ID, $sub, $body, $header, $admin);
			$error="Mail Sent to your Registered email ID";
		}else $error="Given Email ID doesn't Match with the registered Email ID. Kindly Contact Admin";
	}
	elseif($_REQUEST['submiting']=="Change"){
		include('mysql.php');
		$x_y=explode("|",base64_decode($_REQUEST['xy']));
		$sql = $mr_con->query("SELECT request_date FROM ec_password_change WHERE emp_alias='".$x_y[0]."' AND auth_token='".$x_y[1]."' AND flag=0");
		if(mysqli_num_rows($sql)){
			$row = mysqli_fetch_array($sql);
			$request_date=$row['request_date'];
			$current_date=date("Y-m-d H:i:s");
			$hrs=round((strtotime($current_date) - strtotime($request_date))/(60*60));
			if($hrs<='2'){
				$employee_id=alias($x_y[0],'ec_employee_master','employee_alias','employee_id');
				$myusername=addslashes($employee_id);
				$mypassword=addslashes($_REQUEST["password"]);
				$result=mysqli_query($mr_con,"UPDATE ec_employee_master SET password='".$mypassword."' WHERE employee_id='".$myusername."'");
				if($result)echo "<script type='text/javascript'>window.location='index.php?x=success'</script>"; 
			}else $error="Sorry! Link Expired. Please Try Again with new Request";
		}else $error="Sorry! Wrong Link Submited. Please Try Again with new Request";
	}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Enersys Care</title>
<link rel="icon" href="img/favicon.png" type="image/png">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link href="css/login.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
<style>
h4{margin:0; padding:0;color:#FFF;text-align:left;padding-left:20px;font-weight:bolder !important;position:absolute;}
h4 small{color:#FFF; font-size:13px;}
</style>
</head>
<body class="eternity-form">
<section class="colorBg3 colorBg" data-panel="fourth">
	<?php if(isset($error))echo"<p class='fail'>".$error."</p>";?>
  <img src="img/world.png" style="position:absolute; margin-top:-200px;" width="100%"  data-animation="bounceIn" class="hidden-xs hidden-sm ">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 text-center"><br>
        <br>
      </div>
      <div class="col-xs-12 text-center visible-xs">
        <div class="leftlogo" data-animation="bounceIn">
          <p align="center"><img src="img/EnerSyslogo.png" class="img-responsive" width="300" ></p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 hidden-xs text-center" style="height:80px;" ></div>
      <div class="col-xs-5 text-center hidden-xs">
        <div class="leftlogo" data-animation="bounceIn">
          <p><img src="img/EnerSyslogo.png" class="img-responsive"></p>
        </div>
      </div>
      <div class="col-xs-12 col-sm-7 text-center">
        <div class="login-form-section">
          <div class="login-content" data-animation="bounceIn">
            <form class="form-1" action="" method="post" novalidate>
			<?php if(isset($_REQUEST['x'])){
				$x_x=explode("|",base64_decode($_REQUEST['x']));
				$emp_name=alias($x_x[0],'ec_employee_master','employee_alias','employee_id');
				?>
            	<input type="hidden" name="xy" value="<?php echo $_REQUEST['x'];?>" />
              <h4>Employee ID</h4>
              <div class="textbox-wrap">
                <div class="input-group" id="usererror"> <span class="input-group-addon "><i class="icon-user icon-color"></i></span>
                  <input type="text" name="userId" placeholder="New Password" tabindex="1" readonly value="<?php if(isset($emp_name)) echo $emp_name;?>" autocomplete="on" required class="form-control smallcap" style="background:transparent;"/>
                </div>
              </div>
              <h4>Enter New Password <small>(Dont use mobile no.)</small></h4>
              <div class="textbox-wrap">
                <div class="input-group" id="usererror"> <span class="input-group-addon "><i class="icon-key icon-color"></i></span>
                  <input type="password" name="password" placeholder="New Password" tabindex="1" autocomplete="on" required class="form-control" style="background:transparent;"/>
                </div>
              </div>
              <div class="login-form-action clearfix">
                <button type="reset" name="reset" tabindex="3" class="btn btn-success pull-left blue-btn">Reset &nbsp; <i class="icon-chevron-right"></i></button>
                <button type="submit" name="submiting" tabindex="3" value="Change" class="btn btn-success pull-right blue-btn">Change Password &nbsp; <i class="icon-chevron-right"></i></button>
              </div>
			<?php }else{?>
            <h4>Employee ID</h4>
              <div class="textbox-wrap">
                <div class="input-group" id="usererror"> <span class="input-group-addon "><i class="icon-user icon-color"></i></span>
                  <input type="text" name="emp_ID" placeholder="Employee ID" tabindex="1" required class="form-control smallcap" style="background:transparent;"/>
                </div>
              </div>
              <h4>Email ID</h4>
              <div class="textbox-wrap">
                <div class="input-group" id="usererror"> <span class="input-group-addon "><i class="icon-envelope icon-color"></i></span>
                  <input type="text" name="email" placeholder="Email ID" tabindex="2" autocomplete="on" required class="form-control" style="background:transparent;"/>
                </div>
              </div>
              <div class="login-form-action clearfix">
                <button type="reset" name="reset" tabindex="2" class="btn btn-success pull-left blue-btn">Reset &nbsp; <i class="icon-chevron-right"></i></button>
                <button type="submit" name="submiting" tabindex="3" value="Request" class="btn btn-success pull-right blue-btn">Request password &nbsp; <i class="icon-chevron-right"></i></button>
              </div>
			<?php }?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="js/jquery.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
</body>
</html>
