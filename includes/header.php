<style>
.btn-userpic{padding:5px 12px;
background-color:#0288d1; color:#fff;}
.fnt-size{font-size:20px;}
.dropdown-menu{margin-top:2px !important;}
.btn-userpic {padding: 5px 12px;background-color: #fff;color: #428dca;}
.contact-icon{margin-right:30px !important; color:#fff !important;}
.contact-dropdown{width:320px !important;  margin-top: 0px !important;-webkit-transform: translate(0, -2px);  -ms-transform: translate(0, -2px);
  -o-transform: translate(0, -2px);
  transform: translate(0, -2px);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);}
.contact-dropdown ul li{margin-bottom:20px !important;}
.contact-dropdown ul li a .ion{
padding: 6px 12px;
  color: #fff;
  margin-right: 15px;}
</style>
<ul class="list-unstyled left-elems">
	<li>
		<a href class="nav-trigger ion ion-drag navIcon visible-xs" md-ink-ripple ng-click="toggleNav()"></a>
		<!-- <md-switch class="nav-trigger" ng-model="navHorizontal" style="margin: 0" ng-change="toggleNav()"> -->
	</li>
	<!-- site-logo for mobile nav -->
	<li>
		<div class="site-logo visible-xs">
			<a href="#/dashboard" class="h3">
				<span class="text">EnerSys Care</span>
			</a>
		</div>
	</li> <!-- #end site-logo -->
    
    <!-- fullscreen -->
	<li class="fullscreen hidden-xs" ng-click="goFullScreen()">
		<a href><i class="ion ion-qr-scanner"></i></a>

	</li>	<!-- #end fullscreen -->

	<!-- notification drop -->
	<!-- <li class="notify-drop hidden-xs btn-refresh">
		<a href>
			<i class="ion ion-refresh fnt-size"></i>
		</a>
	</li>-->
     <li class="notify-drop hidden-xs dropdown" dropdown ng-controller="notificationsCtrl">
		<a href="javascript:;" dropdown-toggle ng-click="viewNotifi()">
			<i class="ion ion-ios-bell fnt-size"></i>
			<span ng-if="notificationsView.noti_count!=0" class="badge badge-danger badge-xs circle" ng-show="ng_show">{{notificationsView.noti_count}}</span>
		</a>
		<div class="panel panel-default dropdown-menu" ng-controller="leftMenuCtrl">
			<div class="panel-heading" style="margin:0px 15px;" ng-controller="ModalDemoCtrl">
				You have {{notificationsView.noti_count}} new notifications 
                <a href="" ng-click="sendMessage()" class="right btn btn-xs btn-info mt-3 ion ion-paper-airplane ml5 fnt-12" tooltip-placement="top" tooltip="Send" ng-show="menuitems.ADMIN"></a>
				<a href="#/notifications" class="right btn btn-xs btn-pink mt-3">Show All</a>
			</div>
			<div class="panel-body notif_height">
				<ul class="list-unstyled">
					<li class="clearfix" ng-repeat="notif in notificationsView.notification | limitTo:notifLimit">
						<a href="#/notifications">
							<div class="desc">
                            	<!--<span class="ion ion-android-person left bg-primary" ng-if="notif.type_ref=='2'"></span>
                                <span class="ion ion-monitor left bg-info pad-12 mr10" ng-if="notif.type_ref=='1'"></span>-->
								<strong class="text-info text-uppercase">{{notif.title}}</strong><br />
                           		<span class="small text-uppercase right fnt-10" style="color:#FF0000" ng-if="notif.type_ref!='2'">{{notif.level}}</span>
								<span class="small text-uppercase fnt-10">{{notif.message}}</span><span class="small text-uppercase right fnt-10" ng-if="notif.type_ref=='2'">{{notif.created_date_time}}</span><br />
                                <span class="small text-uppercase fnt-10" ng-if="notif.type_ref=='1'">{{notif.complaint}}</span>
                                <span class="small text-uppercase right fnt-10" ng-if="notif.type_ref!='2'">{{notif.created_date_time}}</span>
							</div>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</li>
</ul>


<ul class="list-unstyled right-elems" ng-controller="lockScreenCtrl">
	<!-- profile drop -->
	<li class="profile-drop dropdown" dropdown>
		<a href dropdown-toggle>
            <span class="btn ion ion-person btn-icon-circle icon btn-userpic"  md-ink-ripple></span>
		</a>
		<ul class="dropdown-menu dropdown-menu-right" ng-controller="profileCtrl">
			<li ng-if="singleViews1.profile_hide!='admin' && singleViews1.profile_hide!='esca'">
				<a href="{{adminProfile}}" ng-disabled="{{adminProfileDis}}"><span class="ion ion-person">&nbsp;&nbsp;</span>Profile</a>
			</li>
			<!--
			<li ng-if="singleViews1.profile_hide!='esca' && singleViews1.profile_hide!='emp'"><a href="#/changePassword"><span class="ion ion-key">&nbsp;&nbsp;</span>Change Password</a></li>
			-->
			<li ng-if="singleViews1.password_management"><a href="#/passwordManagement"><span class="ion-person-stalker">&nbsp;&nbsp;</span>Password Management</a></li>
			<li ng-if="singleViews1.profile_hide=='esca'" ng-click="lockScreen()"><a href><span class="ion ion-lock-combination">&nbsp;&nbsp;</span>Lock Screen</a></li>
			<li><a href="#/signin" onclick="delCookie();"><span class="ion ion-power">&nbsp;&nbsp;</span>Logout</a></li>
		</ul>
	</li>
	<!-- #end profile-drop -->
    
    <!-- notification drop -->
	<li class="notify-drop hidden-xs dropdown" dropdown>
		<a href dropdown-toggle class="contact-icon">
			<i class="ion ion-ios-telephone"  md-ink-ripple></i>
		</a>
		<div class="panel panel-default dropdown-menu dropdown-menu-right contact-dropdown">
			<div class="panel-body">
				<ul class="list-unstyled">
					<li class="clearfix">
						<a href>
							<span class="ion ion-alert-circled left bg-danger"></span>
							<div class="desc">
								<strong>Contact Us</strong>
								<p class="small text-muted"> servicedesk@enersys.com.sg </p>
							</div>
						</a>
					</li>
				</ul>
			</div>
		</div>

	</li>	<!-- #end notification drop -->
</ul>

<script>
$(document).ready(function(){
	$('.nav-trigger').click(function(){
		$('.left-elems li .navIcon').addClass('backIcon');
		var backIcon=$('.left-elems').find('.backIcon');
		if(!$('.theme-zero').hasClass('nav-expand')){backIcon.addClass('ion-drag'); backIcon.removeClass('ion-arrow-right-a');}
		else{ backIcon.removeClass('ion-drag'); backIcon.addClass('ion-arrow-right-a');}});
	});
</script>
