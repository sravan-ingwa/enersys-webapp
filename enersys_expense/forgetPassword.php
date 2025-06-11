<?php
if(isset($_REQUEST['submit'])){session_start();
	include('mysql.php');
	$myusername=addslashes($_SESSION["ec_user_email"]);
	$mypassword=addslashes($_POST["password"]);
	$result=mysqli_query($mr_con,"UPDATE ec_employee_master SET password='".$mypassword."' WHERE email_id='".$myusername."'");
	if($result)echo "<script type='text/javascript'>window.location='index.php'</script>"; 
}else{
	session_start();
	if(isset($_SESSION['ec_user_alias'])){
		include('mysql.php');
		$result=mysqli_query($mr_con,"SELECT employee_alias,password,mobile_number FROM ec_employee_master WHERE BINARY employee_alias= BINARY '$_SESSION[ec_user_alias]'");
		$count=mysqli_num_rows($result);
		if($count==1){$row=mysqli_fetch_array($result);
			if($row['mobile_number'] !== $row['password']){ echo "<script type='text/javascript'>window.location='index.php'</script>";}
		}
		else {$ref=uniqid();echo "<script type='text/javascript'>window.location='login.php?ref=$ref'</script>";}
	}else {$ref=uniqid();echo "<script type='text/javascript'>window.location='login.php?ref=$ref'</script>";}

}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Enersys Care</title>
<link rel="icon" href="img/favicon.png" type="image/png">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link href="css/login.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
<style>
h4{margin:0; padding:0;color:#FFF;text-align:left;padding-left:20px;font-weight:bolder !important;position:absolute;}
h4 small{color:#FFF; font-size:13px;}
</style>
</head>
<body class="eternity-form">
<section class="colorBg3 colorBg" data-panel="fourth">
<?php if(isset($_REQUEST['ref']))echo"<p class='fail'>Please enter Correct Username/ password</p>";
elseif(isset($_REQUEST['ref2']))echo"<p class='fail'>".base64_decode($_REQUEST['ref2'])."</p>";
?>
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
          <div class="textbox-wrap">
            <div class="input-group" id="usererror"> <span class="input-group-addon "><i class="icon-user icon-color"></i></span>
              <input type="text" name="userId" placeholder="New Password" tabindex="1" readonly value="<?php if(isset($_SESSION['ec_user_email'])) echo $_SESSION['ec_user_email'];?>" autocomplete="on" required class="form-control smallcap" style="background:transparent;"/>
            </div>
          </div>
			<h4>Enter new Password <small>(Dont use mobile no.)</small></h4>
              <div class="textbox-wrap">
                <div class="input-group" id="usererror"> <span class="input-group-addon "><i class="icon-key icon-color"></i></span>
                  <input type="password" name="password" placeholder="New Password" tabindex="1" autocomplete="on" required class="form-control" style="background:transparent;"/>
                </div>
              </div>
              <div class="login-form-action clearfix">
                <button type="reset" name="reset" tabindex="3" class="btn btn-success pull-left blue-btn">Reset &nbsp; <i class="icon-chevron-right"></i></button>
                <button type="submit" name="submit" tabindex="3" class="btn btn-success pull-right blue-btn">change password &nbsp; <i class="icon-chevron-right"></i></button>
              </div>
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
