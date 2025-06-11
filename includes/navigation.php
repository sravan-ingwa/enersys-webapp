<style>
.list-unstyled{margin-bottom:12px;}
.main-container .nav-wrap .nav-foot{font-size:10px !important;}
.group .avail {color:#4caf50;display: inline-block;font-size: 10px;margin-top: -5px;margin-right:11px;}
.fontIcons{width: 40px;padding: 5px 0px;text-align: center;font-size: 16px;}
.main-container .nav-wrap .site-nav .nav-list li.active a i.fa, .main-container .nav-wrap .site-nav .nav-list li.open > a i.fa {color: #fff; border-color: #7eb0db; background: #428bca;}
.sub-drop{font-size:13px; display:none; background-color:#fff; margin-bottom:0px; margin-left:25px;}
.main-container .nav-wrap .site-nav .nav-list .sub-drop li.open > a{background-color:#fff;}
.main-container .nav-wrap .site-nav .nav-list .sub-drop li.open > a:hover{background-color:#f2f2f2; color:#616161;}
.main-container .nav-wrap .site-nav .nav-list .sub-drop li.open > a.active{background-color:#f00;}
.main-drop > a > .arrows{font-size:9px; right:25px; top:15px; color:#464646; display:inline-block; position:absolute;}
.hidden{display:none;}
.nav-logo{font-size: 22px;padding: 10px;font-weight: bold;}
.site-nav:hover > .nav-head{position:fixed !important;}
</style>
<!-- Site nav (vertical) -->
<nav class="site-nav clearfix" role="navigation">
<div class="nav-head" ng-controller="logoCtrl">
	<!-- site logo -->
	<a href="" ng-click="menu();" class="site-logo">
    	<span class="ion ion-drag nav-logo"></span>
		<span class="text">EnerSys <span>Care</span></span>
	</a>
</div>
  <a href="{{adminProfile}}" ng-disabled="{{adminProfileDis}}" ng-controller="profileCtrl">
	<div class="profile clearfix mb15">
		<img src="{{singleViews1.emp_name=='ADMIN' ? 'images/batt_hand.png' : singleViews1.profile_pic}}" width="38" height="38" alt="admin" class="profile-pic">
		<div class="group">
         	<span class="ion ion-record avail right on"></span>
			<h5 class="name" tooltip-placement="bottom" tooltip="{{singleViews1.emp_name}}">{{singleViews1.emp_name_short}}</h5>
			<small class="desig text-uppercase">{{singleViews1.privilege_name}}</small>
		</div>
	</div>
  </a>
	<!-- navigation -->
	<ul class="list-unstyled clearfix nav-list mb15" collapse-nav-accordion highlight-active ng-controller="leftMenuCtrl">
		<li ng-show="menuitems.TICKETSTATUS || menuitems.CUSTOMERPULSE || menuitems.TODAYSINFOREPORTBLOCK || menuitems.TAT || menuitems.MONTHLYANALYSIS || menuitems.NATUREOFACTIVITY || menuitems.FAULTANALYSIS || menuitems.PRODUCTCONTRIBUTIONINFAILURE || menuitems.MANUFACTUREMONTHWISEFAILURE">
			<a href="#/dashboard" md-ink-ripple>
				<i class="fa fa-dashboard fontIcons"></i>
				<span class="text">Dashboard</span>
			</a>
		</li>
		<li ng-show="menuitems.PLANNER">
			<a href="#/calendar" md-ink-ripple>
				<i class="ion ion-calendar"></i>
				<span class="text">Planner</span>
			</a>
		</li>
		<li ng-show="menuitems.SPOTTICKETS || menuitems.TICKETS">
        	<a href="javascript:;" md-ink-ripple>
				<i class="ion ion-monitor"></i>
				<span class="text">Ticket Master</span>
				<i class="arrow ion-chevron-left"></i>
			</a>
			<ul class="inner-drop list-unstyled">
				<li ng-show="menuitems.TICKETS"><a href="#/tickets" md-ink-ripple>Tickets</a></li>
                <li ng-show="menuitems.SPOTTICKETS"><a href="#/spottickets" md-ink-ripple>Spot Tickets</a></li>
			</ul>
		</li>
		<!-- <li ng-show="menuitems.SPOTTICKETS">
			<a href="#/spottickets" md-ink-ripple>
				<i class="ion ion-monitor"></i>
				<span class="text">Spot Tickets</span>
			</a>
		</li>
        <li ng-show="menuitems.TICKETS">
			<a href="#/tickets" md-ink-ripple>
				<i class="ion ion-monitor"></i>
				<span class="text">Tickets</span>
			</a>
		</li> -->
		<li ng-show="menuitems.SITEMASTER">
			<a href="#/Sitemaster" md-ink-ripple>
				<i class="fa fa-database fontIcons"></i>
				<span class="text">Site Master</span>
			</a>
		</li>
		<li ng-show="menuitems.EMPLOYEEMASTER">
		<a href="#/Employeemaster" md-ink-ripple>
				<i class="ion ion-person-stalker"></i>
				<span class="text">Employee Master</span>
			</a>
		</li>
		<li ng-show="menuitems.EXPENSETRACKER">
        	<a href="javascript:;" md-ink-ripple>
				<i class="ion ion-cash"></i>
				<span class="text">Expense Tracker</span>
				<i class="arrow ion-chevron-left"></i>
			</a>
			<ul class="inner-drop list-unstyled">
				<li ng-show="menuitems.expenseDashboard"><a href="#/expense_dashboard" md-ink-ripple>Dashboard</a></li>
				<li><a href="#/advances" md-ink-ripple>Advances</a></li>
                <li><a href="#/expense" md-ink-ripple>Expenses</a></li>
			</ul>
		</li>
		<li ng-show="menuitems.MATERIALBALANCE || menuitems.MATERIALINWARD || menuitems.MATERIALOUTWARD || menuitems.MATERIALREQUEST || menuitems.REFRESHING || menuitems.REVIVAL || menuitems.STOCKS || menuitems.SJOSEARCH">
        	<a href="javascript:;" md-ink-ripple>
				<i class="fa fa-cubes fontIcons"></i>
				<span class="text">Field Asset Management</span>
				<i class="arrow ion-chevron-left"></i>
			</a>
			<ul class="inner-drop list-unstyled">
				<li ng-show="menuitems.MATERIALBALANCE">
					<span class="main-drop">
						<a href="javascript:;" md-ink-ripple>Material Balance<i class="arrows ion-chevron-left"></i><i class="arrows ion-chevron-down hidden"></i></a>
						<ul class="sub-drop list-unstyled">
							<li><a href="#/Materialbalance" md-ink-ripple>Balance Overview</a></li>
							<li><a href="#/Inwardbalance" md-ink-ripple>Inward Balance</a></li>
							<li><a href="#/Outwardbalance" md-ink-ripple>Outward Balance</a></li>
						</ul>
					</span>
				</li>
				<li ng-show="menuitems.MATERIALINWARD"><a href="#/Materialinward" md-ink-ripple>Material Inward</a></li>
                <li ng-show="menuitems.MATERIALOUTWARD"><a href="#/Materialoutward" md-ink-ripple>Material Outward</a></li>
                <li ng-show="menuitems.MATERIALREQUEST"><a href="#/Materialrequest" md-ink-ripple>Material Request</a></li>
                <li ng-show="menuitems.REVIVAL"><a href="#/Revival" md-ink-ripple>Revival</a></li>
                <li ng-show="menuitems.REFRESHING"><a href="#/Refreshing" md-ink-ripple>Refreshing</a></li>
                <li ng-show="menuitems.STOCKS"><a href="#/items_view" md-ink-ripple>Stocks</a></li>
                <li ng-show="menuitems.SJOSEARCH"><a href="#/sjo_search" md-ink-ripple>SJO Search</a></li>
			</ul>
		</li>
        <li ng-show="menuitems.TRACKINGSYSTEM">
			<a href="#/usertracking" md-ink-ripple>
				<i class="ion ion-map"></i>
				<span class="text">Tracking System</span>
			</a>
		</li>
        <li ng-show="menuitems.IMEIACTDEACT">
			<a href="#/imeicontrol" md-ink-ripple>
				<i class="fa fa-mobile fontIcons"></i>
				<span class="text">Device Control</span>
			</a>
		</li>
		<li ng-show="menuitems.dashboard_esca">
			<a href="#/dashboard-esca" md-ink-ripple>
				<i class="fa fa-dashboard fontIcons"></i>
				<span class="text">Dashboard</span>
			</a>
		</li>
		<li ng-show="menuitems.tickets_esca">
			<a href="#/tickets-esca" md-ink-ripple>
				<i class="ion ion-monitor"></i>
				<span class="text">Tickets</span>
			</a>
		</li>
        <li ng-show="menuitems.employeemaster_esca">
			<a href="#/employeemaster-esca" md-ink-ripple>
				<i class="ion ion-person-stalker"></i>
				<span class="text">Employee Master</span>
			</a>
		</li>
		 <li ng-show="menuitems.dashboard_customer">
			<a href="#/dashboard-customer" md-ink-ripple>
				<i class="fa fa-dashboard fontIcons"></i>
				<span class="text">Dashboard</span>
			</a>
		</li>
        <li ng-show="menuitems.tickets_customer">
			<a href="#/tickets-customer" md-ink-ripple>
				<i class="ion ion-monitor"></i>
				<span class="text">Tickets</span>
			</a>
		</li>
        <li ng-show="menuitems.sitemaster_customer">
			<a href="#/sitemaster-customer" md-ink-ripple>
				<i class="fa fa-database fontIcons"></i>
				<span class="text">Sitemaster</span>
			</a>
		</li>
	</ul> <!-- #end navigation -->
</nav>


<!-- nav-foot -->
<footer class="nav-foot">
	<p>2015 &copy; <span>EnerSys India Batteries Pvt.Ltd</span></p>
</footer>
<script>
	$('.main-drop').click(function(){$('.sub-drop').toggle(); $(this).find('ul > li').toggleClass('open'); $('.main-drop a').children('.ion-chevron-down').toggleClass('hidden'); $('.main-drop a').children('.ion-chevron-left').toggleClass('hidden')});
	$('.sub-drop li').click(function(event){event.stopPropagation(); $(this).parent().show();});
</script>