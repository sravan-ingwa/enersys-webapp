<style>
.dropdown-submenu{position:relative;}
.dropdown-submenu>.dropdown-menu{top:5px;left:100%;margin-top:-6px;margin-left:-1px;-webkit-border-radius:0 6px 6px 6px;-moz-border-radius:0 6px 6px 6px;border-radius:0 6px 6px 6px;}
.dropdown-submenu>a:after{display:block;content:" ";float:right;width:0;height:0;border-color:transparent;border-style:solid;border-width:5px 0 5px 5px;border-left-color:#cccccc;margin-top:5px;margin-right:-10px;}
.dropdown-submenu:hover>a:after{border-left-color:#ffffff;}
.dropdown-menu > li > a{color:#fff;}
.dropdown-submenu.pull-left{float:none;}.dropdown-submenu.pull-left>.dropdown-menu{left:-100%;margin-left:10px;-webkit-border-radius:6px 0 6px 6px;-moz-border-radius:6px 0 6px 6px;border-radius:6px 0 6px 6px;}
</style>
<div class="container-fluid navbar-fixed-top"><!-- Starting Of Heading Container -->
	<div class="row topmenuA">
    	<div class="col-sm-4 hidden-xs text-left">
            <ul><li><a href="dashboard" onclick="event.preventDefault();calloftheduty($(this).attr('href'));" class="referesh"><span class="glyphicon glyphicon-refresh"></span> Refresh</a></li></ul>
        </div>
    	<div class="col-sm-4 col-xs-7 text-center enersys-power">
			<h1><a href="index.php" style="text-transform:none !important">Employee Travel Portal</a></h1>
        </div>
		<div class="col-sm-4 col-xs-5 text-right pull-right">
            <?php /*?><ul class="nav cont hidden-xs" style="display:inline-block; float:right;">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" style="padding:0px 10px !important;" data-toggle="dropdown"><i class="glyphicon glyphicon-phone-alt"></i><b class="caret"></b></a>
                    <div class="dropdown-menu cont-dropdown pull-right">
                    <div style="padding:0 2px; margin:0 !important;font-size:13px;line-height:25px;text-transform:none !important;"><b>Contact us:</b> 040-6704 6704</br><b>Feedback us:</b>feedback@enersys.co.in</div>
                        
                    </div>
                </li>
        	</ul><?php */?>
            <ul style="display:inline-block; float:right;">
                <li class="hidden-xs"><a class="tooltips" data-placement="left">Welcome Admin</a></li>
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
                    <li class="active dropdown employee-c">
                    	<a href="#" data-toggle="dropdown" class="dropdown-toggle hidden-xs">Employee Details</a>
                        <ul class="dropdown-menu" role="menu">
							<li class="dropdown"><a href="listemployee" data-active="employee-c" data-toggle="dropdown" class="itemNav dropdown-toggle hidden-xs">Employee List</a></li>
                            <li class="dropdown"><a href="addemployee" data-active="employee-c" data-toggle="dropdown" class="itemNav dropdown-toggle hidden-xs">Add Employee</a></li>
                        </ul>
                    </li>
                	<li class="department-c"><a href="adddepartment" data-active="department-c" class="itemNav">Department</a></li>
                    <li class="designation-c"><a href="adddesignation" data-active="designation-c" class="itemNav">Designation</a></li>
                	<li class="approvers-c"><a href="addapprovals" data-active="approvers-c" class="itemNav">Approvers</a></li>
                    <li class="limits-c"><a href="addlimits" data-active="limits-c" class="itemNav">Limits</a></li>
                    <li class="dropdown">
                    	<a data-toggle="dropdown" class="dropdown-toggle hidden-xs">Allowances Details</a>
                        <ul class="dropdown-menu" role="menu">
							<li class="dropdown-submenu">
                            	<a tabindex="0" data-toggle="dropdown" class="dropdown-toggle hidden-xs">Services</a>
                                <ul class="dropdown-menu cc" role="menu">
                                    <li class="dropdown"><a href="serlistallowances" data-active="allowances-c" data-toggle="dropdown" class="itemNav xdfsdfs dropdown-toggle hidden-xs">Allowances List</a></li>
                                    <li class="dropdown"><a href="serviceallowances" data-active="allowances-c" data-toggle="dropdown" class="itemNav dropdown-toggle hidden-xs">Add Allowances</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                            	<a tabindex="1" data-toggle="dropdown" class="dropdown-toggle hidden-xs">Others</a>
                                <ul class="dropdown-menu cc" role="menu">
                                    <li class="dropdown"><a href="listallowances" data-active="allowances-c" data-toggle="dropdown" class="itemNav dropdown-toggle hidden-xs">Allowances List</a></li>
                                    <li class="dropdown"><a href="addallowances" data-active="allowances-c" data-toggle="dropdown" class="itemNav dropdown-toggle hidden-xs">Add Allowances</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown report-c">
                    	<a href="#" data-toggle="dropdown" class="dropdown-toggle">Reports</a>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        	<li><a href="exportEmp" data-active="report-c" class="itemNav">Employee List</a></li>
                            <li><a href="exportExpApprovals" data-active="report-c" class="itemNav">Approvers list</a></li>
                        </ul>
                    </li>
                    <li class="advances-c"><a href="viewadvance" data-active="advances-c" class="itemNav">Advances</a></li>
                    <li class="expences-c"><a href="viewexpense" data-active="expences-c" class="itemNav">Expenses</a></li>
                </ul>
            </div>
        </div>        
    </div>
</div><!-- Closing Of Heading Container -->
 <script>
$('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
	event.preventDefault(); 
	event.stopPropagation(); 
	$('ul.dropdown-menu [data-toggle=dropdown]').parent().removeClass('open');
	$(this).parent().addClass('open');
});
$('ul.cc [data-toggle=dropdown]').on('click', function() {$(this).parents().removeClass('open');});
</script>