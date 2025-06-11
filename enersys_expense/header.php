<div class="container-fluid navbar-fixed-top"><!-- Starting Of Heading Container -->
	<div class="row topmenuA">
    	<div class="col-sm-2 hidden-xs text-left">
            <ul><li><a href="dashboard" onclick="event.preventDefault();calloftheduty($(this).attr('href'));" class="referesh"><span class="glyphicon glyphicon-refresh"></span> Refresh</a></li></ul>
        </div>
    	<div class="col-sm-7 col-xs-7 text-center enersys-power hidden-xs">
			<h1><a href="index.php" style="text-transform:none !important">Employee Advance/ Expense Journal</a></h1>
        </div>
		<div class="col-sm-3 col-xs-5 text-right pull-right" style="padding:0px;">
	<?php /*?><ul class="nav cont hidden-sm hidden-xs" style="display:inline-block; float:right;">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" style="padding:0px 10px !important;" data-toggle="dropdown"><i class="glyphicon glyphicon-phone-alt"></i><b class="caret"></b></a>
                    <div class="dropdown-menu cont-dropdown pull-right">
                    <div style="padding:0 2px; margin:0 !important;font-size:13px;line-height:25px;text-transform:none !important;"><b>Contact us:</b> 040-6704 6704</br><b>Feedback us:</b>feedback@enersys.co.in</div>
                        
                    </div>
                </li>
        	</ul>
 <?php */ ?><ul style="display:inline-block; float:right;">
                <li class="hidden-sm hidden-xs hidden-md"><a class="tooltips" data-placement="left">Welcome, <?php echo employeeDetails('name',$_SESSION['ec_user_alias']);?></a></li>
                <li><a href="logout.php" class="btn btn-primary ss_buttons" role="button">Logout</a></li>
            </ul>
        </div>
    </div>
	<div class="row">
        <div class="navbar navbar-default mainmenu" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse"><span class="sr-only">Toggle navigation</span>EnerSys Tour Management<span class="caret"></span></button>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                	<li class="dashboard-c active"><a href="dashboard" data-active="dashboard-c" class="itemNav">Dashboard</a></li>
                    <li class="dropdown advance-c">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Advances</a>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        
                        	<li><a href="viewadvance" data-active="advance-c"  class="itemNav">Detailed View</a></li>
                            <li><a href="bookAdvance" data-active="advance-c"  class="itemNav">Advance Request</a></li>
                        </ul>
                    </li>
                    <li class="dropdown expense-c">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Expenses</a>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        	<li><a href="viewExpense" data-active="expense-c"  class="itemNav">Detailed View</a></li>   
                            <li><a <?php if(getRoleStat(employeeDetails('role_alias',$_SESSION['ec_user_alias'])) == 0) { ?> href="serviceExpense" <?php } else { ?> href="bookExpense" <?php }?>  data-active="expense-c"  class="itemNav">Submit Expenses</a></li>
                           </ul>
                    </li>
                    <li class="dropdown report-c">
                    	<a href="#" data-toggle="dropdown" class="dropdown-toggle">Reports</a>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        	<li><a href="exportAdvance" data-active="report-c" class="itemNav">Advances</a></li>
                            <li><a href="exportExpense" data-active="report-c" class="itemNav">Expenses</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>        
    </div>
</div><!-- Closing Of Heading Container -->