<style>
	table{margin-bottom:10px !important;}
	.table > tfoot > tr > td {padding:8px !important;}
	/*table > thead > tr > th {background-color: #428bca; color: #fff; font-size:12px; padding:7px !important;}
	table > tbody > tr > td {font-size:12px; padding:7px !important;}*/
	.dropdown-menu{min-width:100px; margin-top:7px;}
	.panel-heading a{color:#535353;}
	.SumoSelect > .CaptionCont > span.placeholder {color:#428bca; font-style: inherit;cursor: pointer;}
	.SlectBox {min-width: 150px !important; width:100% !important; padding:10px 5px;}
	.SumoSelect > .optWrapper.open {top: -1px;}
	.SumoSelect > .optWrapper {top: 30px;min-width: 155px !important; right:150px !important; left:auto !important;}
	.SumoSelect > .CaptionCont > label > i {color:#428bca !important;}
	.manfdate{left:-166px !important;}
	.SumoSelect > .CaptionCont > span {color:#428bca;}
</style>
<div class="page page-dashboard" ng-controller="DashboardCustCtrl">
    <div class="row" ng-controller="ModalDemoCtrl">
	   <!-----Heading------>
		<div class="col-md-12">
			<div class="dash-head clearfix mb20 panel-hovered">
				<div class="left">
					<h4 class="mb5 text-light">Welcome to EnerSys Care!</h4>
					<p class="small"><strong>Version</strong> 2.0</p>
				</div>
			</div>
		</div>
		<!-----Total no.of tickets------>
		<div class="col-lg-8 col-md-6 col-sm-12" ng-controller="cust_dash_view_form" ng-init="listSortingdb()">
			<form class="form-horizontal forms_customer" url="services/customer/ticket_status" name="userForm" method="post">
				<div class="panel panel-default panel-hovered panel-stacked mb20">
					<div class="panel-heading bd-btm"> <span>Ticket Status</span> <a href class="right ticketdropdown"><span class="ion ion-android-settings"></span></a>
						<div class="ticketsetting">
							<ul>
								<li><select placeholder="State" name="state_alias[]" ng-options="state.name for state in firstDrop.ss track by state.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="state_alias" data-ng-change="listSortingdb()"></select></li>
								<!--<li><select placeholder="Customer" name="customer_alias[]" ng-options="customer.name for customer in firstDrop.cs track by customer.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="customer_alias" data-ng-change="listSortingdb()"></select></li>-->
								<li><select placeholder="Segment" name="segment_alias[]" ng-options="segment.name for segment in firstDrop.ses track by segment.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="segment_alias" data-ng-change="listSortingdb()"></select></li>
								<li><select name="activity_alias[]" placeholder="Activity" ng-options="activity.name for activity in firstDrop.acs track by activity.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="activity_alias" data-ng-change="listSortingdb()"></select></li>
								<li><select name="faulty_alias[]" placeholder="Faulty Code" ng-options="faulty.name for faulty in firstDrop.fs track by faulty.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="faulty_alias" data-ng-change="listSortingdb()"></select></li>
								<li ng-controller="tatDropCntrl"><select Placeholder="Aging" name="tat[]" ng-options="aging.name for aging in tats track by aging.name" multiple="multiple" class="form-control selectdrop testSelAll2" ng-model="tat" data-ng-change="listSortingdb()"></select></li>
								<li><select placeholder="Select Year" name="year" ng-options="yearr.name for yearr in firstDrop.yrr track by yearr.alias" class="dateSelect form-control" ng-model="year" data-ng-change="listSortingdb()"><option value="">Select Year</option></select></li>
							</ul>
						</div>
					</div>
					<div class="panel-body pivot-pad" >
						<table class="table table-hover">
							<thead>
								<tr>
									<th ng-show="datas.status" style="background-color: #428bca; color: #fff; font-size:12px; padding:7px !important;">{{datas.status}}</th>
									<th ng-repeat="data in datas.tktzone_name" style="background-color: #428bca; color: #fff; font-size:12px; padding:7px !important;">{{data.zone_name}}</th>
									<th ng-show="datas.total" style="background-color: #428bca; color: #fff; font-size:12px; padding:7px !important;">{{datas.total}}</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="data in datas.tktstatusDetails">
									<td style="font-size:12px; padding:6px !important;">{{data.level_name}}</td>
									<td ng-repeat="v in data.zone_count" style="font-size:12px; padding:6px !important;">{{v.count}}</td>
									<td style="font-size:12px; padding:6px !important;">{{data.value}}</td>
								</tr>
							</tbody>
							<tfoot class="ticket-grandtotal">
								<tr>
									<td ng-show="datas.grandtotal">{{datas.grandtotal}}</td>
									<td ng-repeat="datas in datas.details">{{datas.cnt_value}}</td>
									<!--<td>180</td><td>125</td><td>180</td><td>200</td>--> 
								</tr>
							</tfoot>
						</table>
						<div class="col-md-12">
							<div class="col-md-6 text-center"><span>{{datas.txtopened}}  </span><span>: {{datas.opened}}</span></div>
							<div class="col-md-6 text-center"><span>{{datas.txtclosed}}  </span><span>: {{datas.closed}}</span></div>
							<p style="height:20px;"></p>
						</div>
					</div>
				</div>
			</form>
		</div>

		<!-- Nature of Activity -->
		
		<div class="col-lg-4 col-md-6 col-sm-12" ng-controller="custactivityconfigCtrl" ng-init="listSortingdb()">
			<form class="form-horizontal forms_cust_na" name="userForm" url="services/customer/nature_of_activity" method="post">
				<div class="panel panel-default mb20 panel-hovered">
					<div class="panel-heading bd-btm"> <span>Nature of Activity</span> <a href class="right ticketdropdown"><span class="ion ion-android-settings"></span></a>
						<div class="ticketsetting">
							<ul>
								<li><select placeholder="State" name="state_alias[]" ng-options="state.name for state in firstDrop.ss track by state.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="state_alias" data-ng-change="listSortingdb()"></select></li>
								<!--<li><select placeholder="Customer" name="customer_alias[]" ng-options="customer.name for customer in firstDrop.cs track by customer.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="customer_alias" data-ng-change="listSortingdb()"></select></li>-->
								<li><select placeholder="Segment" name="segment_alias[]" ng-options="segment.name for segment in firstDrop.ses track by segment.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="segment_alias" data-ng-change="listSortingdb()"></select></li>
								<li><select placeholder="Select Year" name="year" ng-options="yearr.name for yearr in firstDrop.yrr track by yearr.alias" class="dateSelect form-control" ng-model="year" data-ng-change="listSortingdb()"><option value="">Select Year</option></select></li>
							</ul>
						</div>
					</div>
				  <div class="panel-body text-center"><c3-chart id="cust_n_act"></c3-chart></div>
				</div>
			</form>
		</div>

		<!--Today's Report block -->

		<div class="col-lg-8 col-md-6 col-sm-12" ng-controller="custtodayinfoCtrl" ng-init="listSortingdb()">
			<form class="form-horizontal forms_cust_info" name="userForm" url="services/customer/today_info_report_block" method="post">
				<div class="panel panel-default mb20 panel-hovered analytics">
					<div class="panel-heading bd-btm"> <span>Today's Info Report block</span> <a href class="right ticketdropdown"><span class="ion ion-android-settings"></span></a>
						<div class="ticketsetting">
							<ul>
								<li><select placeholder="State" name="state_alias[]" ng-options="state.name for state in firstDrop.ss track by state.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="state_alias" data-ng-change="listSortingdb()"></select></li>
								<!--<li><select placeholder="Customer" name="customer_alias[]" ng-options="customer.name for customer in firstDrop.cs track by customer.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="customer_alias" data-ng-change="listSortingdb()"></select></li>-->
								<li><select placeholder="Segment" name="segment_alias[]" ng-options="segment.name for segment in firstDrop.ses track by segment.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="segment_alias" data-ng-change="listSortingdb()"></select></li>
								<li><select name="activity_alias[]" placeholder="Activity" ng-options="activity.name for activity in firstDrop.acs track by activity.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="activity_alias" data-ng-change="listSortingdb()"></select></li>
								<li><select name="faulty_alias[]" placeholder="Faulty Code" ng-options="faulty.name for faulty in firstDrop.fs track by faulty.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="faulty_alias" data-ng-change="listSortingdb()"></select></li>
								<li ng-controller="tatDropCntrl"><select Placeholder="Aging" name="tat[]" ng-options="aging.name for aging in tats track by aging.name" multiple="multiple" class="form-control selectdrop testSelAll2" ng-model="tat" data-ng-change="listSortingdb()"></select></li>
							</ul>
						</div>
						<span class="right mr20">Grand Total : <span style="color:#428bca;" ng-show="extdata.totalcount">{{extdata.totalcount}}</span></span>
					</div>
					<div class="panel-body"><c3-chart id="cust_td_info"></c3-chart></div>
				</div>
			</form>
		</div>     
	</div>     
</div>
 <script type="text/javascript">
	$(document).ready(function () {
		setInterval(function(){$('.testSelAll2').SumoSelect({selectAll:true});},0);
		setInterval(function(){$('.dateSelect').SumoSelect();},0);
		$(".datepicker").click(function(){$('.ng-valid-date-disabled').addClass('manfdate');});
	});
	$(document).click(function(e){
	  var target = $(e.target).parent().next();
		if(target.hasClass('ticketsetting')){
		  $('.ticketsetting').not(target).hide();
		  target.toggle();
		  e.stopImmediatePropagation();
		}else{
			$('.optWrapper').find('li, span, label, i').addClass('dropdow');
			if(!$(e.target).hasClass('testSelAll2') && !$(e.target).hasClass('ticketsetting') && !$(e.target).hasClass('dateSelect') && !$(e.target).hasClass('dropdow')){$('.ticketsetting').hide();} 
		}
	});
</script>
