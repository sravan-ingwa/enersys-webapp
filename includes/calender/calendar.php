<style>
.page-app-calendar .calevents > li {padding:0px 15px; margin-bottom:5px;}
.allevents{max-height:350px; overflow-y:auto;}
.eventsView{margin: 0 0 5px;font-size: 10px;}
.page-app-calendar .calevents > li .event-date { position: absolute;top: 10px;right: 15px;cursor: pointer;font-weight:bold;}
.singleSelect{width:100%;}
.SumoSelect > .CaptionCont > label > i {right:5px;}
.SumoSelect > .optWrapper.open {top:33px !important;}
.SumoSelect > .CaptionCont > span.placeholder {margin-left:0px;}
.SumoSelect > .CaptionCont > span {margin-left:0px;}
.SumoSelect > .optWrapper{min-width:200px !important; right:-45px !important;}
.viewDetails{cursor:pointer;}
.eveDate{cursor: pointer;font-weight: bold; font-size:11px; float:right;}
.tab-content{background:none !important; box-shadow:none !important; padding:0px !important;}
.fc-basic-view td.fc-day-number{padding-bottom:0px !important;}
.fc-row .fc-content-skeleton tr td{padding-right:0px !important; padding-top:0px !important;}
.fc-more-popover .fc-event-container{max-height:250px; overflow-y:auto;}
</style>
   <div class="page page-app-calendar">
	<!--<ol class="breadcrumb breadcrumb-small">
		<li>Home</li>
		<li class="active"><a href="#/calendar">Calendar</a></li>
	</ol>-->
	<div class="page-wrap">
		<!-- row -->
		<form class="form-horizontal form_cal" url="services/calender/calender" name="userForm" method="post" novalidate>
		<div class="row">
			<div class="col-md-9">
				<!-- calendar toolbar, this will replaced default toolbar -->
				<div class="calendar-toolbar mb20 text-center">
					<div class="btn-group btn-group-sm left">
	                    <!--<input type="hidden" name="check" value="{{calmonth.check}}">-->
	                    <button class="btn btn-default ion ion-arrow-left-c" name="prevmonth" ng-click="prev('mycalendar');"></button>
	                    <button class="btn btn-default ion ion-arrow-right-c" name="nextmonth" ng-click="next('mycalendar');"></button>
	                </div>
	               	<button type="button" class="btn btn-default btn-sm ml15 left" ng-click="today('mycalendar')">today</button>
	               	<strong class="text-uppercase">{{currentDate}}</strong>
	               	<div class="btn-group btn-group-sm right">
	                    <button type="button" class="btn btn-default" ng-click="changeView('month', 'mycalendar')">Month</button>
	                    <button type="button" class="btn btn-default" ng-click="changeView('agendaWeek', 'mycalendar')">Week</button>
	                    <button type="button" class="btn btn-default" ng-click="changeView('agendaDay', 'mycalendar')">Day</button>
	                </div>
				</div>
				<div class="panel panel-lined panel-hovered mb15 backGround">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-xs-6 aa" ng-controller="selectZoneCntrl">
                            <select multiple="multiple" placeholder="Zones" name="zone_alias[]" class="testSelAll2 form-control" ng-model="zones" ng-init="dep_drop(singleViews.zone_alias)" data-ng-change="dep_drop_mul(zones); calSorting()">
                                <option ng-if="zone.alias!='4VTSNSSBM9'" ng-repeat="zone in firstDrop" value="{{zone.alias}}">{{zone.name}}</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-3 col-xs-6 aa" ng-controller="selectStateCntrl">
                            <select class="form-control testSelAll2" placeholder="States" name="state_alias[]" id="state" ng-model="states" multiple="multiple" data-ng-change="calSorting()">
                                <option ng-repeat="state in firstDrop" value="{{state.alias}}">{{state.name}}</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-3 col-xs-6 aa" ng-controller="emproledropCntrl">
                           <select class="form-control editselectdrop testSelAll2" name="role_alias[]" ng-model="role_alias" placeholder="Employee Role" required multiple="multiple" data-ng-change="calSorting()">
                                <option ng-repeat="emprole in firstDrop" value="{{emprole.alias}}">{{emprole.name}}</option>
                           </select>
                        </div>
                        <div class="col-lg-3 col-md-3 col-xs-6 aa" ng-controller="emproledropPlannerCntrl">
                           <select class="form-control selectdrop testSelAll2" name="employee_alias[]" ng-model="employee_alias" placeholder="Employee Names" required multiple="multiple" data-ng-change="calSorting()">
                                <option ng-repeat="emp in firstDrop" value="{{emp.alias}}">{{emp.name}}</option>
                           </select>
                        </div>  
                    </div>
                </div>
				<!-- calendar -->
				<div ui-calendar="uiConfig.calendar" ng-model="eventSources" calendar="mycalendar"></div>
			</div>

			<div class="col-md-3" ng-controller="ModalDemoCtrl">
				<!--<button type="button" ng-if="calenderEvents.add" class="btn btn-info btn-icon-inline btn-sm mb10" ng-click="addEvent()"> <i class="ion ion-plus"></i>Assign Schedule</button>-->
                <button type="button" ng-if="calenderEvents.add" class="btn btn-info btn-icon-inline btn-sm mb10" ng-click="emailSend()"><i class="ion ion-android-send"></i>Email</button>
                <button type="button" ng-if="calenderEvents.export" class="btn btn-info btn-icon-inline btn-sm mb10" ng-click="cexportOpen()"> <i class="ion ion-share"></i>Plan Export</button>
                <button type="button" ng-if="calenderEvents.export" class="btn btn-info btn-icon-inline btn-sm mb10" ng-click="dprexportOpen(calenderEvents.not_eng)"><i class="ion ion-share"></i>DPR Export&nbsp;</button>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default mb10 mini-box panel-hovered">
                            <div class="panel-footer clearfix panel-footer-sm panel-footer-info">
                                <p class="mt0 mb0 left">Summary</p>
                            </div>
                            <div class="panel-body" style="padding:10px 10px;">
                                <div class="clearfix">
                                    <div class="info">
                                        <h5><span class="col-lg-6 col-md-7 col-xs-10">Total Man Days</span>: <span>{{calenderEvents.manpower.totalpower}}</span></h5>
                                        <h5><span class="col-lg-6 col-md-7 col-xs-10">Engaged</span>: <span>{{calenderEvents.manpower.engaged}}</span></h5>
                                        <h5><span class="col-lg-6 col-md-7 col-xs-10">Vacant</span>: <span>{{calenderEvents.manpower.vacant}}</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="panel panel-lined panel-hovered mt5 strong" style="padding:5px 15px;">List of Events [Count: {{calenderEvents.eventcount}}]</p>
                <ul class="calevents list-unstyled allevents">
					<li ng-repeat="event in calenderEvents.events">
						<!--<input class="event-name" ng-model="event.title">-->
                        <h5>{{event.title}}</h5>
                        <p class="eventsView">{{event.category}}</p>
                        <p class="eventsView">{{event.service_engineer}}</p>
                        <div class="event-edit-icon ion ion-edit" 
                        ng-if="calenderEvents.edit && (event.event_type == 'Event' || event.event_type == 'DPR')" style="margin-right:6px;"
                        ng-click="editDetailsopen();details(event.event_alias,event.event_type);"></div>
                        <div class="event-remove-icon ion ion-trash-a" 
                        ng-if="calenderEvents.delete && (event.event_type == 'Event' || event.event_type == 'DPR')"
                        ng-click="calenderDeleteOpen(event)"></div>
                        <div class="viewDetails text-info mb10" ng-click="viewDetailsopen(); details(event.event_alias,event.event_type);">View Details
                            <span class="eveDate text-primary">{{event.date}}</span>
                        </div>
					</li>
                    <li ng-if="calenderEvents.eventcount =='0'"><h4 class="pad-12">No Events Found</h4></li>
				</ul>
				<div ng-if="calenderEvents.add"><button type="button" class="btn btn-info ion ion-plus compose-btn" tooltip="Assign Schedule" tooltip-placement="top"  ng-click="addEvent()" md-ink-ripple></button></div>
			</div>
		</div> <!-- #end row -->
        </form>
	</div> <!-- #end page-wrap -->
</div>

<script>
setInterval(function(){
    $('.testSelAll2').SumoSelect({selectAll:true});
    $('.forms_add').find('.SumoSelect').addClass('singleSelect');
}, 100);
$('.fc-view-container').find('.fc-widget-content').addClass('tcalender');
</script>