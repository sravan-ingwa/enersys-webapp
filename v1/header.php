<div class="container-fluid navbar-fixed-top"><!-- Starting Of Heading Container -->
	<div class="row topmenuA">
    	<div class="col-sm-4 hidden-xs text-left">
            <ul>
                <li><a href="" onclick="event.preventDefault();window.history.back()"><span class="glyphicon glyphicon-arrow-left"></span></a></li>
                <li><a href=""><span class="glyphicon glyphicon-refresh"></span></a></li>
            </ul>
        </div>
    	<div class="col-sm-4 col-xs-7 text-center enersys-power">
			<h1><!--<img src="img/battery_vertical.gif" width="12" height="18"/>--><a href="index.php" style="text-transform:none !important"><span style="font-size:27px !important;">E</span>nerSys Care</a></h1>
        </div>
		<div class="col-sm-4 col-xs-5 text-right pull-right">
            <ul class="nav cont hidden-xs" style="display:inline-block; float:right;">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" style="padding:0px 10px !important;" data-toggle="dropdown"><i class="glyphicon glyphicon-phone-alt"></i><b class="caret"></b></a>
                    <div class="dropdown-menu cont-dropdown pull-right">
                    <div style="padding:0 2px; margin:0 !important;font-size:13px;line-height:25px;text-transform:none !important;"><b>Contact us:</b> 040-6704 6704</br><b>Feedback us:</b>feedback@enersys.co.in</div>
                        
                    </div>
                </li>
        	</ul>
            <ul style="display:inline-block; float:right;">
                <li class="hidden-xs"><a class="tooltips" data-placement="left"><span class="glyphicon glyphicon-user"></span>&nbsp;<?php echo loginDetails($_SESSION['login_user'],"name");?></a></li>
                <li><a href="logout.php" class="btn btn-primary ss_buttons" role="button">Logout</a></li>
            </ul>
        </div>
    </div>
	<div class="row">
        <div class="navbar navbar-default mainmenu" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse"><span class="sr-only">Toggle navigation</span>Enersys Care Menu<span class="caret"></span></button>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <?php $loginRole=loginDetails($_SESSION['login_user'],"role"); mainMenu($_REQUEST['x'],$loginRole);?>
					
                    <li class="dropdown lg-right">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle hidden-xs"><span class="glyphicon glyphicon-cog"></span></a>
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle hidden-sm hidden-md hidden-lg">Settings</a>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            
							<?php subMenuDrop($loginRole);?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>        
    </div>
	<div class="row">
    	<div class="col-lg-12 topmenuc">
        	<ul class="menu-lh hidden-xs">
                <div class="testBody">
                    <li class="testRow">
                        <?php $loginRole=loginDetails($_SESSION['login_user'],"role"); subMenu($_REQUEST['x'],$loginRole);?>
                    </li>
                </div>
            </ul>
			<?php if(isset($_REQUEST['x'])){ ?>
            	<ul class="menu-rh"><? $path=basename($_SERVER['PHP_SELF'],'.php');
					if($_REQUEST['x'] == 5484 || $_REQUEST['x'] == 6643 || $_REQUEST['x'] == 8865 || $_REQUEST['x'] == 9658 || $_REQUEST['x'] == 4592 || $_REQUEST['x'] == 1764){ 
						 if(serviceAccess($loginRole,$_REQUEST['x'],'View')){?><li <?php if($path=="index"||$path=="view") echo 'class="active"'; ?> ><a href="index.php?x=<?php echo $_REQUEST['x']; ?>" title="View"><span class="glyphicon glyphicon-eye-open hidden-xs"></span><p>View</p></a></li><?php }
                         if(serviceAccess($loginRole,$_REQUEST['x'],'Export')){?><li <?php if($path=="export") echo 'class="active"'; ?>><a href="export.php?x=<?php echo $_REQUEST['x'];?>" title="Export"><span class="glyphicon glyphicon-export hidden-xs"></span><p>Export</p></a></li><?php }
					}else{ 
						 if(serviceAccess($loginRole,$_REQUEST['x'],'View')){?><li <?php if($path=="index"||$path=="view") echo 'class="active"'; ?> ><a href="index.php?x=<?php echo $_REQUEST['x']; ?>" title="View"><span class="glyphicon glyphicon-eye-open hidden-xs"></span><p>View</p></a></li><?php }
						 if(serviceAccess($loginRole,$_REQUEST['x'],'Create')){?><li <?php if($path=="create") echo 'class="active"'; ?>><a href="create.php?x=<?php echo $_REQUEST['x'];?>" title="Add"><span class="glyphicon glyphicon-plus hidden-xs"></span><p>Add New</p></a></li><?php }
						 if(serviceAccess($loginRole,$_REQUEST['x'],'Export')){?><li <?php if($path=="export") echo 'class="active"'; ?>><a href="export.php?x=<?php echo $_REQUEST['x'];?>" title="Export"><span class="glyphicon glyphicon-export hidden-xs"></span><p>Export</p></a></li><?php }
					 } ?>
                </ul>
			<?php } ?>
        	</div>
        </div>
</div><!-- Closing Of Heading Container -->
<script src="js/jquery.min.js"></script>
<script>
$(function(){
	$('.liWidth').click(function(){
		var zzz = $(this).width();
		$(this).find('ul').css({'min-width':zzz+'px','width':zzz+'px'});
		});
	});
</script>