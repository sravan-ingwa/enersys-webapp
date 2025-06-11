<?php
session_start();
include_once('functions.php');
include('mysql.php');
$comp=mysql_query("SELECT * FROM ss_company_details WHERE status='active'");
$comprow=mysql_fetch_array($comp);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <? TitleFav(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="css/login.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
</head>
<body class="eternity-form">
    <section class="colorBg3 colorBg" data-panel="fourth">
		<?php 
			if(isset($_REQUEST['ref']))echo"<p class='fail'>Please enter Correct Username/ password</p>";
			elseif(isset($_REQUEST['ref2']))echo"<p class='fail'>".base64_decode($_REQUEST['ref2'])."</p>";
		?>
        <img src="img/world.png" style="position:absolute; margin-top:-200px;" width="100%"  data-animation="bounceIn" class="hidden-xs hidden-sm ">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center"><br><br>
                                        <!--<h1 class="loghead text-center"><center><img src="img/logo/dfs.png" class="img-responsive" width="400" ></center></h1>-->
                </div>
                
                <div class="col-xs-12 text-center visible-xs">
                	<div class="leftlogo" data-animation="bounceIn">
                        <p align="center"><img src="<? if($comprow['logo']){echo $comprow['logo'];}?>" alt="<? if($comprow['compName']){echo $comprow['compName'];}?>" class="img-responsive" width="300" ></p>
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
                            <form class="form-1" action="login_script.php" method="post">
                                <div class="textbox-wrap">
                                    <div class="input-group" id="usererror">
                                        <span class="input-group-addon "><i class="icon-user icon-color"></i></span>
                                        <input type="text" name="userId" tabindex="1" autofocus autocomplete="off" required class="form-control" style="background:transparent;" placeholder="Username" />
                                    </div>
                                </div>
                                <div class="textbox-wrap">
                                    <div class="input-group">
                                        <span class="input-group-addon "><i class="icon-key icon-color"></i></span>
                                        <input type="password" name="pass" tabindex="2" autocomplete="off" required class="form-control " placeholder="Password" />
                                    </div>
                                </div>
                                <div class="login-form-action clearfix">
                                    <button type="reset" name="reset" tabindex="3" class="btn btn-success pull-left blue-btn">Reset &nbsp; <i class="icon-chevron-right"></i></button>
                                    <button type="submit" name="submit" tabindex="3" class="btn btn-success pull-right blue-btn">LogIn &nbsp; <i class="icon-chevron-right"></i></button>
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
