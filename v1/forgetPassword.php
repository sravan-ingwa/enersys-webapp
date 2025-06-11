<?php
session_start();
include_once('functions.php');
include('mysql.php');
if($_REQUEST['sub']){
	$email = $_REQUEST['forgetPass'];
	$qur = mysql_query("SELECT * FROM ss_user_details WHERE email='$email'");
	if(mysql_num_rows($qur)>0){
	$row = mysql_fetch_array($qur);
	$to = $row['email']."<br>";
	$pass = $row['password'];
	$sub = 'Your Username and  Password !!!!';
	$body = "Your Email : <h3>".$emailD."<br/>Password : ".$pass."</h3><br/>Now you can login with your Email and Password..";
	$from = 'enersyscare';
	$header= 'From:'.$from."\r\n";
	$header.= "Content-Type: text/html\r\n";
	$header.= "X-Mailer: PHP/".phpversion();
	$header.= 'MIME-Version: 1.0'."\r\n";
		//$abc = mail($to, $sub, $body, $header);
		//if($abc){
			$re=base64_encode("Password has been successfully sent to ".$to);
			echo "<script type='text/javascript'>window.location='login.php?ref2=$re'</script>";
			//}
		}else{$se=base64_encode($email);
		echo "<script type='text/javascript'>window.location='forgetPassword.php?ref=$se'</script>";}
}
$comp=mysql_query("SELECT * FROM ss_company_details WHERE status='active'");
$comprow=mysql_fetch_array($comp);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php TitleFav(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="css/login.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
</head>
<body class="eternity-form">
    <section class="colorBg3 colorBg" data-panel="fourth">
		<?php if(isset($_REQUEST['ref']))echo"<p class='fail'>".base64_decode($_REQUEST['ref'])." is not present in our database</p>"; ?>
        <img src="img/world.png" style="position:absolute; margin-top:-200px;" width="100%"  data-animation="bounceIn" class="hidden-xs hidden-sm ">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h1 class="loghead text-center"><center><img src="img/logo/dfs.png" class="img-responsive" width="400" ></center></h1>
                </div>
                
                <div class="col-xs-12 text-center visible-xs">
                	<div class="leftlogo" data-animation="bounceIn">
                        <p align="center"><img src="<? if($comprow['logo']){echo $comprow['logo'];}?>" alt="<? if($comprow['compName']){echo $comprow['compName'];}?>" class="img-responsive" width="250" ></p>
                	</div>
                </div>
                
            </div>
            <div class="row">
            <div class="col-xs-12 hidden-xs text-center" style="height:80px;" ></div>
				<div class="col-xs-5 text-center hidden-xs">
                	<div class="leftlogo" data-animation="bounceIn">
                        <p><img src="<? if($comprow['logo']){echo $comprow['logo'];}?>" alt="<? if($comprow['compName']){echo $comprow['compName'];}?>" class="img-responsive"></p>
                	</div>
                </div>
				<div class="col-xs-12 col-sm-7 text-center">
                    <div class="login-form-section">
                        <div class="login-content " data-animation="bounceIn">
                            <form class="form-1" method="post">
                                <div class="textbox-wrap">
                                    <div class="input-group" id="usererror">
                                        <span class="input-group-addon "><i class="icon-user icon-color"></i></span>
                                        <input tabindex="1" type="email" tabindex="1" name="forgetPass" required class="form-control" style="background:transparent;" autofocus autocomplete="off" placeholder="Mail Id" />
                                    </div>
                                </div>
                                <div class="login-form-action clearfix">
                                	<a href="login.php" tabindex="3" class="btn btn-success pull-left blue-btn"><i class="icon-chevron-left"></i>&nbsp;&nbsp;Back To Login Page</a>
                                    <input type="submit" name="sub" tabindex="2" class="btn btn-success pull-right blue-btn" value="Send an e - mail">
                                </div>
                            </form>
                        </div>
                    </div>
            	 </div>
            </div>
        </div>
    </section>
    <script src="js/modernizr.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/respond.src.js"></script>
    <script src="js/jquery.icheck.js"></script>
    <script src="js/placeholders.min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.panelSnap.js"></script>
    <script type="text/javascript">$(function(){$("input").iCheck({checkboxClass:"icheckbox_square-blue",increaseArea:"20%"});$(".dark input").iCheck({checkboxClass:"icheckbox_polaris",increaseArea:"20%"});$(".form-control").focus(function(){$(this).closest(".textbox-wrap").addClass("focused")}).blur(function(){$(this).closest(".textbox-wrap").removeClass("focused")});if($(window).width()>=968&&!Modernizr.touch&&Modernizr.cssanimations){$("body").addClass("scroll-animations-activated");$("[data-animation-delay]").each(function(){var e=$(this).data("animation-delay");$(this).css({"-webkit-animation-delay":e,"-moz-animation-delay":e,"-o-animation-delay":e,"-ms-animation-delay":e,"animation-delay":e})});$("[data-animation]").waypoint(function(e){if(e=="down"){$(this).addClass("animated "+$(this).data("animation"))}},{offset:"90%"}).waypoint(function(e){if(e=="up"){$(this).removeClass("animated "+$(this).data("animation"))}},{offset:$(window).height()+1})}})</script>
</body>
</html>
 