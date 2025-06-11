<?php
header('Location: http://enersyscare.co.in/');
exit;
if(isset($_REQUEST['submit'])){
	include('mysql.php');
	$myusername=strtoupper(addslashes($_POST["userId"]));
	$mypassword=addslashes($_POST["pass"]);
	$result=mysqli_query($mr_con,"SELECT employee_alias,password,mobile_number,email_id FROM ec_employee_master WHERE BINARY employee_id= BINARY '$myusername' and BINARY password= BINARY '$mypassword'");
	$count=mysqli_num_rows($result);
	if($count==1){
		$row=mysqli_fetch_array($result);
		session_start();
		$_SESSION['ec_user_alias']=$row['employee_alias'];
		$_SESSION['ec_user_email']=$row['email_id'];
		if($row['mobile_number'] === $row['password']){echo "<script type='text/javascript'>window.location='forgetpassword.php'</script>";}
		else{echo "<script type='text/javascript'>window.location='index.php'</script>";}
		echo "<script type='text/javascript'>window.location='index.php'</script>";
    }
	else {$ref=uniqid();echo "<script type='text/javascript'>window.location='login.php?ref=$ref'</script>";}
}
//"
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
body{
	background: url(../images/2016.jpg) no-repeat center center fixed !important;; 
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
}
.dfgd{position:fixed;left:80px;top:100px;}
.dfgda{position:fixed;left:150px;top:300px;}
.page,.page-auth,.main-container{background:RGBA(0,0,0,0) !important;}
.auth-container{
	background:RGBA(255,255,255,0.1) !important;
	-webkit-transition: background 500ms linear;
	-moz-transition: background 500ms linear;
	-ms-transition: background 500ms linear;
	-o-transition: background 500ms linear;
	transition: background 500ms linear;
	}
.auth-container:hover{
	background:RGBA(255,255,255,0.9) !important;
	-webkit-transition: background 500ms linear;
	-moz-transition: background 500ms linear;
	-ms-transition: background 500ms linear;
	-o-transition: background 500ms linear;
	transition: background 500ms linear;
}
</style>
</head>
<body class="eternity-form">
<section class="colorBg3 colorBg" data-panel="fourth">
<?php if(isset($_REQUEST['ref']))echo"<p class='fail'>Please enter Correct Username/ password</p>";
elseif(isset($_REQUEST['ref2']))echo"<p class='fail'>".base64_decode($_REQUEST['ref2'])."</p>";
elseif(isset($_REQUEST['x'])){
	if($_REQUEST['x']=="success")echo"<p class='success'>Successfully Changed the Password</p>";
	elseif($_REQUEST['x']=="fail")echo"<p class='fail'>Password Change Failed! Try again Later</p>";
}
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
          <div class="login-content " data-animation="bounceIn">
            <form class="form-1" action="" method="post" novalidate>
              <div class="textbox-wrap">
                <div class="input-group" id="usererror"> <span class="input-group-addon "><i class="icon-user icon-color"></i></span>
                  <input type="text" name="userId" placeholder="Employee ID" tabindex="1" autocomplete="on" required class="form-control" style="background:transparent;"/>
                </div>
              </div>
              <div class="textbox-wrap">
                <div class="input-group"> <span class="input-group-addon "><i class="icon-key icon-color"></i></span>
                  <input type="password" name="pass" tabindex="2" autocomplete="off" required class="form-control " placeholder="Password" />
                </div>
              </div>
              <div class="login-form-action clearfix">
                <a class="btn btn-success pull-left blue-btn" href="forgetPassword-1.php">Request Password &nbsp; <i class="icon-chevron-right"></i></a>
                <button type="submit" name="submit" tabindex="3" class="btn btn-success pull-right blue-btn">LogIn &nbsp; <i class="icon-chevron-right"></i></button>
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
