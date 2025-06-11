<style>
	*{margin:0;padding:0;}
	table {margin-bottom: 10px!important}
	.table>tfoot>tr>td {padding: 8px!important}
	.dropdown-menu {min-width: 100px;margin-top: 7px}
	.panel-heading a {color: #535353}
	.SumoSelect>.CaptionCont>span.placeholder {color: #428bca;font-style: inherit;cursor: pointer}
	.SlectBox {min-width: 150px!important;width: 100%!important;padding: 10px 5px}
	.SumoSelect>.optWrapper.open {top: -1px}
	.SumoSelect>.optWrapper {top: 30px;min-width: 155px!important;right: 150px!important;left: auto!important}
	.SumoSelect>.CaptionCont>label>i {color: #428bca!important}
	.manfdate {left: -166px!important}
	.SumoSelect>.CaptionCont>span {color: #428bca}
	.bd-btm {border-bottom: 1px solid #e4e4e4}
</style>
<div class="page page-dashboard" ng-controller="DashboardCtrl">
	<div class="row" ng-controller="ModalDemoCtrl">
		<div class="col-md-12">
			<div class="dash-head clearfix mb20 panel-hovered">
				<div class="left">
					<h4 class="mb5 text-light">Welcome to EnerSys Care !!</h4>
					<p class="small"><strong>Version</strong> 2.0</p>
				</div>
			</div>
		</div>
		<!-- Ticket Status-->
		<div class="col-lg-6 col-md-6 col-sm-12" ng-if="singleViews1.TICKETSTATUS" ng-controller="dash_view_form" ng-init="listSortingdb()">
			<form class="form-horizontal forms_tec" url="services/dashboard/ticket_status" name="userForm" method="post">
				<div class="panel panel-default panel-hovered panel-stacked mb20" ng-show="datas.details.length>'0'" style="max-height: 441px;">
					<div class="panel-heading bd-btm">Ticket Status
						<a href="" class="right ticketdropdown"><span class="ion ion-android-settings"></span></a>
						<div class="ticketsetting">
							<ul>
								<li><select placeholder="State" name="state_alias[]" ng-options="state.name for state in firstDrop.ss track by state.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="state_alias" data-ng-change="listSortingdb()"></select></li>
								<li><select placeholder="Customer" name="customer_alias[]" ng-options="customer.name for customer in firstDrop.cs track by customer.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="customer_alias" data-ng-change="listSortingdb()"></select></li>
								<li><select placeholder="Segment" name="segment_alias[]" ng-options="segment.name for segment in firstDrop.ses track by segment.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="segment_alias" data-ng-change="listSortingdb()"></select></li>
								<li><select name="activity_alias[]" placeholder="Activity" ng-options="activity.name for activity in firstDrop.acs track by activity.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="activity_alias" data-ng-change="listSortingdb()"></select></li>
								<li><select name="faulty_alias[]" placeholder="Faulty Code" ng-options="faulty.name for faulty in firstDrop.fs track by faulty.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="faulty_alias" data-ng-change="listSortingdb()"></select></li>
								<li ng-controller="tatDropCntrl"><select Placeholder="Aging" name="tat[]" ng-options="aging.name for aging in tats track by aging.name" multiple="multiple" class="form-control selectdrop testSelAll2" ng-model="tat" data-ng-change="listSortingdb()"></select></li>
								<li><select placeholder="Select Year" name="year" ng-options="yearr.name for yearr in firstDrop.yrr track by yearr.alias" class="dateSelect form-control" ng-model="year" data-ng-change="listSortingdb()"><option value="">Select Year</option></select></li>
							</ul>
						</div>
					</div>
					<div class="panel-body pivot-pad">
						<table class="table table-hover">
							<thead>
								<tr>
									<th ng-show="datas.status" width="30%">{{datas.status}}</th>
									<th ng-repeat="data in datas.tktzone_name">{{data.zone_name}}</th>
									<th ng-show="datas.total">{{datas.total}}</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="data in datas.tktstatusDetails">
									<td class="web">{{data.level_name}}</td>
									<td ng-repeat="v in data.zone_count" style="padding:0">{{v.count}}</td>
									<td class="web">{{data.value}}</td>
								</tr>
							</tbody>
							<tfoot class="ticket-grandtotal">
								<tr>
									<td ng-show="datas.grandtotal">{{datas.grandtotal}}</td>
									<td ng-repeat="datas in datas.details">{{datas.cnt_value}}</td>
								</tr>
							</tfoot>
						</table>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="col-md-6 col-sm-6 col-xs-6 text-center"><span>OPEN : {{datas.opened}}</span></div>
							<div class="col-md-6 col-sm-6 col-xs-6 text-center"><span>CLOSED : {{datas.closed}}</span></div>
						</div>
					</div>
				</div>
			</form>
		</div>
		<!-- Customer Satisfication Score-->
		<div class="col-lg-6 col-md-6 col-sm-12" ng-if="singleViews1.CUSTOMERPULSE" ng-controller="customer_pulse_view" ng-init="listSortingcust()">
			<form class="form-horizontal forms_cust" url="services/dashboard/customer_pulse" name="userForm" method="post">
				<div class="panel panel-default mb20 panel-hovered" ng-show="td_info_show=='services/dashboard/customer_pulse'">
					<div class="panel-heading bd-btm"> <span>Customer Pulse</span> <a href class="right ticketdropdown"><span class="ion ion-android-settings"></span></a>
						<div class="ticketsetting">
							<ul>
								<li><select placeholder="State" name="state_alias[]" ng-options="state.name for state in firstDrop.ss track by state.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="state_alias" data-ng-change="listSortingcust()"></select></li>
								<li><select placeholder="Customer" name="customer_alias[]" ng-options="customer.name for customer in firstDrop.cs track by customer.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="customer_alias" data-ng-change="listSortingcust()"></select></li>
								<li><select placeholder="Segment" name="segment_alias[]" ng-options="segment.name for segment in firstDrop.ses track by segment.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="segment_alias" data-ng-change="listSortingcust()"></select></li>
								<li><select placeholder="Activity" name="activity_alias[]" ng-options="activity.name for activity in firstDrop.acs track by activity.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="activity_alias" data-ng-change="listSortingcust()"></select></li>
								<li><select placeholder="Select Year" name="year" ng-options="yearr.name for yearr in firstDrop.yrr track by yearr.alias" class="dateSelect form-control" ng-model="year" data-ng-change="listSortingcust()"><option value="">Select Year</option></select></li>
							</ul>
						</div>
					</div>
					<div class="panel-body text-center">
						<c3-chart id="c_pulse"></c3-chart>
					</div>
				</div>
			</form>
		</div>
		<!--Today's Report block -->
		<div class="col-lg-6 col-md-6 col-sm-12" ng-if="singleViews1.TODAYSINFOREPORTBLOCK" ng-controller="today_info_view" ng-init="listSortinginfo()">
			<form class="form-horizontal forms_today" name="userForm" url="services/dashboard/today_info_report_block" method="post">
				<div class="panel panel-default mb20 panel-hovered analytics" ng-show="td_info_show=='services/dashboard/today_info_report_block'">
					<div class="panel-heading bd-btm">
						<span>Today's Info Report block</span>
						<a href class="right ticketdropdown"><span class="ion ion-android-settings"></span></a>
						<div class="ticketsetting">
							<ul>
								<li><select placeholder="State" name="state_alias[]" ng-options="state.name for state in firstDrop.ss track by state.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="state_alias" data-ng-change="listSortinginfo()"></select></li>
								<li><select placeholder="Customer" name="customer_alias[]" ng-options="customer.name for customer in firstDrop.cs track by customer.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="customer_alias" data-ng-change="listSortinginfo()"></select></li>
								<li><select placeholder="Segment" name="segment_alias[]" ng-options="segment.name for segment in firstDrop.ses track by segment.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="segment_alias" data-ng-change="listSortinginfo()"></select></li>
								<li><select name="activity_alias[]" placeholder="Activity" ng-options="activity.name for activity in firstDrop.acs track by activity.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="activity_alias" data-ng-change="listSortinginfo()"></select></li>
								<li><select name="faulty_alias[]" placeholder="Faulty Code" ng-options="faulty.name for faulty in firstDrop.fs track by faulty.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="faulty_alias" data-ng-change="listSortinginfo()"></select></li>
								<li ng-controller="tatDropCntrl"><select Placeholder="Aging" name="tat[]" ng-options="aging.name for aging in tats track by aging.name" multiple="multiple" class="form-control selectdrop testSelAll2" ng-model="tat" data-ng-change="listSortinginfo()"></select></li>
							</ul>
						</div>
						<span class="right mr20">Grand Total : <span style="color:#428bca;" ng-show="extdata.totalcount">{{extdata.totalcount}}</span></span>
					</div>
					<div class="panel-body">
						<c3-chart id="td_info"></c3-chart>
					</div>
				</div>
			</form>
		</div>
		
		<!--TAT Status -->
		<div class="col-lg-6 col-md-6 col-sm-12" ng-if="singleViews1.TAT" ng-controller="tat_view" ng-init="listSortingtat()">
			<form class="form-horizontal forms_tat" name="userForm" url="services/dashboard/tat_status" method="post">
				<div class="panel panel-default mb20 panel-hovered" ng-show="td_info_show=='services/dashboard/tat_status'">
					<div class="panel-heading bd-btm"> <span>TAT</span> <a href class="right ticketdropdown"><span class="ion ion-android-settings"></span></a>
						<div class="ticketsetting">
							<ul>
								<li><select placeholder="State" name="state_alias[]" ng-options="state.name for state in firstDrop.ss track by state.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="state_alias" data-ng-change="listSortingtat()"></select></li>
								<li><select placeholder="Customer" name="customer_alias[]" ng-options="customer.name for customer in firstDrop.cs track by customer.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="customer_alias" data-ng-change="listSortingtat()"></select></li>
								<li><select placeholder="Segment" name="segment_alias[]" ng-options="segment.name for segment in firstDrop.ses track by segment.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="segment_alias" data-ng-change="listSortingtat()"></select></li>
								<li><select name="activity_alias[]" placeholder="Activity" ng-options="activity.name for activity in firstDrop.acs track by activity.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="activity_alias" data-ng-change="listSortingtat()"></select></li>
								<li><select name="faulty_alias[]" placeholder="Faulty Code" ng-options="faulty.name for faulty in firstDrop.fs track by faulty.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="faulty_alias" data-ng-change="listSortingtat()"></select></li>
								<li><select placeholder="Select Year" name="year" ng-options="yearr.name for yearr in firstDrop.yrr track by yearr.alias" class="dateSelect form-control" ng-model="year" data-ng-change="listSortingtat()"><option value="">Select Year</option></select></li>
							</ul>
						</div>
					</div>
					<div class="panel-body text-center">
						<c3-chart id="tat_con"></c3-chart>
					</div>
				</div>
			</form>
		</div>
		<!-- No.of Tickets Registered -->
		<div class="col-lg-6 col-md-6 col-sm-12" ng-if="singleViews1.MONTHLYANALYSIS" ng-controller="tktdash_view_form" ng-init="listSortingmnth()">
			<form class="form-horizontal forms_analysis" name="userForm" url="services/dashboard/tkt_status_mon" method="post">
				<div class="panel panel-default mb20 panel-hovered" ng-show="td_info_show=='services/dashboard/tkt_status_mon'">
					<div class="panel-heading bd-btm"> <span>Monthly Analysis</span> <a href class="right ticketdropdown"><span class="ion ion-android-settings"></span></a>
						<div class="ticketsetting">
							<ul>
								<li><select placeholder="State" name="state_alias[]" ng-options="state.name for state in firstDrop.ss track by state.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="state_alias" data-ng-change="listSortingmnth()"></select></li>
								<li><select placeholder="Customer" name="customer_alias[]" ng-options="customer.name for customer in firstDrop.cs track by customer.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="customer_alias" data-ng-change="listSortingmnth()"></select></li>
								<li><select placeholder="Segment" name="segment_alias[]" ng-options="segment.name for segment in firstDrop.ses track by segment.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="segment_alias" data-ng-change="listSortingmnth()"></select></li>
								<li><select name="activity_alias[]" placeholder="Activity" ng-options="activity.name for activity in firstDrop.acs track by activity.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="activity_alias" data-ng-change="listSortingmnth()"></select></li>
								<li><select placeholder="Select Year" name="year" ng-options="yearr.name for yearr in firstDrop.yrr track by yearr.alias" class="dateSelect form-control" ng-model="year" data-ng-change="listSortingmnth()"><option value="">Select Year</option></select></li>
							</ul>
						</div>
					</div>
					<div class="panel-body text-center">
						<c3-chart id="m_analasys"></c3-chart>
					</div>
				</div>
			</form>
		</div>
		<!-- Nature of Activity -->
		<div class="col-lg-6 col-md-6 col-sm-12" ng-if="singleViews1.NATUREOFACTIVITY" ng-controller="activity_view" ng-init="listSortingacty()">
			<form class="form-horizontal forms_activity" name="userForm" url="services/dashboard/nature_of_activity" method="post">
				<div class="panel panel-default mb20 panel-hovered" ng-show="td_info_show=='services/dashboard/nature_of_activity'">
					<div class="panel-heading bd-btm"> <span>Nature of Activity</span> <a href class="right ticketdropdown"><span class="ion ion-android-settings"></span></a>
						<div class="ticketsetting">
							<ul>
								<li><select placeholder="State" name="state_alias[]" ng-options="state.name for state in firstDrop.ss track by state.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="state_alias" data-ng-change="listSortingacty()"></select></li>
								<li><select placeholder="Customer" name="customer_alias[]" ng-options="customer.name for customer in firstDrop.cs track by customer.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="customer_alias" data-ng-change="listSortingacty()"></select></li>
								<li><select placeholder="Segment" name="segment_alias[]" ng-options="segment.name for segment in firstDrop.ses track by segment.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="segment_alias" data-ng-change="listSortingacty()"></select></li>
								<li><select placeholder="Select Year" name="year" ng-options="yearr.name for yearr in firstDrop.yrr track by yearr.alias" class="dateSelect form-control" ng-model="year" data-ng-change="listSortingacty()"><option value="">Select Year</option></select></li>
							</ul>
						</div>
					</div>
					<div class="panel-body text-center">
						<c3-chart id="n_act"></c3-chart>
					</div>
				</div>
			</form>
		</div>
		<!-- Fault Analysis -->
		<div class="col-lg-6 col-md-6 col-sm-12" ng-if="singleViews1.FAULTANALYSIS" ng-controller="faultydash_view_form" ng-init="listSortingfaulty()">
			<form class="form-horizontal forms_fec" url="services/dashboard/fault_analysis" name="userForm" method="post">
				<div class="panel panel-default mb20 panel-hovered" ng-show="td_info_show=='services/dashboard/fault_analysis'">
					<div class="panel-heading bd-btm"> <span>FAULT ANALYSIS</span> <a href class="right ticketdropdown"><span class="ion ion-android-settings"></span></a>
						<div class="ticketsetting">
							<ul>
								<li><select placeholder="State" name="state_alias[]" ng-options="state.name for state in firstDrop.ss track by state.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="state_alias" data-ng-change="listSortingfaulty()"></select></li>
								<li><select placeholder="Customer" name="customer_alias[]" ng-options="customer.name for customer in firstDrop.cs track by customer.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="customer_alias" data-ng-change="listSortingfaulty()"></select></li>
								<li><select placeholder="Segment" name="segment_alias[]" ng-options="segment.name for segment in firstDrop.ses track by segment.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="segment_alias" data-ng-change="listSortingfaulty()"></select></li>
								<li><select name="activity_alias[]" placeholder="Activity" ng-options="activity.name for activity in firstDrop.acs track by activity.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="activity_alias" data-ng-change="listSortingfaulty()"></select></li>
								<li><select placeholder="Select Year" name="year" ng-options="yearr.name for yearr in firstDrop.yrr track by yearr.alias" class="dateSelect form-control" ng-model="year" data-ng-change="listSortingfaulty()"><option value="">Select Year</option></select></li>
							</ul>
						</div>
					</div>
					<div class="panel-body text-center">
						<c3-chart id="f_analasys"></c3-chart>
					</div>
				</div>
			</form>
		</div>
			<!--Product Contribution in Failure-->
            <div class="col-lg-6 col-md-6 col-sm-12" ng-if="singleViews1.PRODUCTCONTRIBUTIONINFAILURE" ng-controller="product_cont_failure_form" ng-init="listSortingdbsp()" >
				<form class="form-horizontal forms_fecp" url="services/dashboard/product_cont_failure" name="userForm" method="post">
					<div class="panel panel-default panel-hovered panel-stacked mb20" ng-show="td_info_show=='services/dashboard/product_cont_failure'">
						<div class="panel-heading bd-btm">
							<span>PRODUCT CONTRIBUTION IN FAILURE</span>
							<a href class="right ticketdropdown"><span class="ion ion-android-settings"></span></a>
							<div class="ticketsetting">
							  <ul>
									<li><select placeholder="State" name="state_alias[]" ng-options="state.name for state in firstDrop.ss track by state.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="state_alias" data-ng-change="listSortingdbsp()"></select></li>
									<li><select placeholder="Customer" name="customer_alias[]" ng-options="customer.name for customer in firstDrop.cs track by customer.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="customer_alias" data-ng-change="listSortingdbsp()"></select></li>
									<li><select placeholder="Segment" name="segment_alias[]" ng-options="segment.name for segment in firstDrop.ses track by segment.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="segment_alias" data-ng-change="listSortingdbsp()"></select></li>
									<li><select name="activity_alias[]" placeholder="Activity" ng-options="activity.name for activity in firstDrop.acs track by activity.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="activity_alias" data-ng-change="listSortingdbsp()"></select></li>
									<li><select name="faulty_alias[]" placeholder="Faulty Code" ng-options="faulty.name for faulty in firstDrop.fs track by faulty.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="faulty_alias" data-ng-change="listSortingdbsp()"></select></li>
									<li><select placeholder="Select Year" name="year" ng-options="yearr.name for yearr in firstDrop.yrr track by yearr.alias" class="dateSelect form-control" ng-model="year" data-ng-change="listSortingdbsp()"><option value="">Select Year</option></select></li>
							  </ul>
							</div>
						</div>
						<div class="panel-body">
							<c3-chart id="p_contri"></c3-chart>
						</div>
					</div>
				</form>
		  </div>
		<!-- Manufacture Month Wise Failure -->
            <div class="col-lg-12 col-md-12 col-sm-12" ng-if="singleViews1.MANUFACTUREMONTHWISEFAILURE" ng-controller="manuf_month_failure_form" ng-init="listSortingdbspm()">
             <form class="form-horizontal forms_fecpm" url="services/dashboard/manufacturing_month_failure" name="userForm" method="post">
				<div class="panel panel-default panel-hovered panel-stacked mb20" ng-show="td_info_show=='services/dashboard/manufacturing_month_failure'">
					<div class="panel-heading bd-btm">
                        <span>MANUFACTURE MONTH WISE FAILURE</span>
                        <a href class="right ticketdropdown"><span class="ion ion-android-settings"></span></a>
                        <div class="ticketsetting">
                          <ul>
							<li><select placeholder="State" name="state_alias[]" ng-options="state.name for state in firstDrop.ss track by state.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="state_alias" data-ng-change="listSortingdbspm()"></select></li>
							<li><select placeholder="Customer" name="customer_alias[]" ng-options="customer.name for customer in firstDrop.cs track by customer.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="customer_alias" data-ng-change="listSortingdbspm()"></select></li>
							<li><select placeholder="Segment" name="segment_alias[]" ng-options="segment.name for segment in firstDrop.ses track by segment.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="segment_alias" data-ng-change="listSortingdbspm()"></select></li>
							<li><select name="activity_alias[]" placeholder="Activity" ng-options="activity.name for activity in firstDrop.acs track by activity.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="activity_alias" data-ng-change="listSortingdbspm()"></select></li>
							<li><select name="faulty_alias[]" placeholder="Faulty Code" ng-options="faulty.name for faulty in firstDrop.fs track by faulty.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="faulty_alias" data-ng-change="listSortingdbspm()"></select></li>
							<li><select placeholder="Select Year" name="year" ng-options="yearr.name for yearr in firstDrop.yrr track by yearr.alias" class="dateSelect form-control" ng-model="year" data-ng-change="listSortingdbspm()"><option value="">Select Year</option></select></li>
                          </ul>
                        </div>
                    </div>
					<div class="panel-body">
                    	<div class="text-center strong text-primary text-strong"><h5>{{singleViews.year}}</h5></div>
						<c3-chart id="m_month"></c3-chart>
					</div>
				</div>
                </form>
			</div>
	</div>


<!-- For Normal Logins-->


<!--<div ng-if="singleViews1.Dashboard=='Yes' && singleViews1.privilege_alias!='ADMIN' && singleViews1.privilege_alias!= 'NCPAT7QPTK' && singleViews1.privilege_alias!= 'OX5E3EMI0U' && singleViews1.privilege_alias!= 'WIMYJFDJPT'"> Admin, MD, ZHS, NHS
	<div class="row" ng-controller="ModalDemoCtrl">
				<div class="col-md-12">
					<div class="dash-head clearfix mb20 panel-hovered">
						<div class="left">
							<h4 class="mb5 text-light">Welcome to EnerSys Care !!</h4>
							<p class="small"><strong>Version</strong> 2.0</p>
						</div>
					</div>
				</div>
		<div class="col-lg-8 col-md-6 col-sm-12" ng-controller="dash_view_form" ng-init="listSortingdb()">
			<form class="form-horizontal forms_tec" url="services/dashboard/ticket_status" name="userForm" method="post">
				<div class="panel panel-default panel-hovered panel-stacked mb20">
					<div class="panel-heading bd-btm"> <span>Ticket Status</span> <a href class="right ticketdropdown"><span class="ion ion-android-settings"></span></a>
						<div class="ticketsetting">
							<ul>
								<li>
									<select placeholder="State" name="state_alias[]" ng-options="state.name for state in firstDrop.ss track by state.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="state_alias" data-ng-change="listSortingdb()">
									</select>
								</li>
								<li>
									<select placeholder="Customer" name="customer_alias[]" ng-options="customer.name for customer in firstDrop.cs track by customer.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="customer_alias" data-ng-change="listSortingdb()">
									</select>
								</li>
								<li>
									<select placeholder="Segment" name="segment_alias[]" ng-options="segment.name for segment in firstDrop.ses track by segment.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="segment_alias" data-ng-change="listSortingdb()">
									</select>
								</li>
								<li>
									<select name="activity_alias[]" placeholder="Activity" ng-options="activity.name for activity in firstDrop.acs track by activity.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="activity_alias" data-ng-change="listSortingdb()">
									</select>
								</li>
								<li>
									<select name="faulty_alias[]" placeholder="Faulty Code" ng-options="faulty.name for faulty in firstDrop.fs track by faulty.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="faulty_alias" data-ng-change="listSortingdb()">
									</select>
								</li>
								<li ng-controller="tatDropCntrl">
									<select Placeholder="Aging" name="tat[]" ng-options="aging.name for aging in tats track by aging.name" multiple="multiple" class="form-control selectdrop testSelAll2" ng-model="tat" data-ng-change="listSortingdb()">
									</select>
								</li>
								<li>
									<select placeholder="Select Year" name="year" ng-options="yearr.name for yearr in firstDrop.yrr track by yearr.alias" class="dateSelect form-control" ng-model="year" data-ng-change="listSortingdb()">
										<option value="">Select Year</option>
									</select>
								</li>
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
									<td style="font-size:12px; padding:7px !important;">{{data.level_name}}</td>
									<td ng-repeat="v in data.zone_count" style="font-size:12px; padding:7px !important;">{{v.count}}</td>
									<td style="font-size:12px; padding:7px !important;">{{data.value}}</td>
								</tr>
							</tbody>
							<tfoot class="ticket-grandtotal">
								<tr>
									<td ng-show="datas.grandtotal">{{datas.grandtotal}}</td>
									<td ng-repeat="datas in datas.details">{{datas.cnt_value}}</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</form>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12" ng-controller="customer_pulse_view" ng-init="listSortingcust()">
			<form class="form-horizontal forms_cust" url="services/dashboard/customer_pulse" name="userForm" method="post">
				<div class="panel panel-default mb20 panel-hovered">
					<div class="panel-heading bd-btm"> <span>Customer Pulse</span> <a href class="right ticketdropdown"><span class="ion ion-android-settings"></span></a>
						<div class="ticketsetting">
							<ul>
								<li>
									<select placeholder="State" name="state_alias[]" ng-options="state.name for state in firstDrop.ss track by state.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="state_alias" data-ng-change="listSortingcust()">
									</select>
								</li>
								<li>
									<select placeholder="Customer" name="customer_alias[]" ng-options="customer.name for customer in firstDrop.cs track by customer.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="customer_alias" data-ng-change="listSortingcust()">
									</select>
								</li>
								<li>
									<select placeholder="Segment" name="segment_alias[]" ng-options="segment.name for segment in firstDrop.ses track by segment.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="segment_alias" data-ng-change="listSortingcust()">
									</select>
								</li>
								<li>
									<select name="activity_alias[]" placeholder="Activity" ng-options="activity.name for activity in firstDrop.acs track by activity.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="activity_alias" data-ng-change="listSortingcust()">
									</select>
								</li>
								<li>
									<select placeholder="Select Year" name="year" ng-options="yearr.name for yearr in firstDrop.yrr track by yearr.alias" class="dateSelect form-control" ng-model="year" data-ng-change="listSortingcust()">
										<option value="">Select Year</option>
									</select>
								</li>
							</ul>
						</div>
					</div>
					<div class="panel-body text-center">
						<c3-chart id="c_pulse"></c3-chart>
					</div>
				</div>
			</form>
		</div>
		
		<div class="col-lg-7 col-md-6 col-sm-12" ng-controller="today_info_view" ng-init="listSortinginfo()">
			<form class="form-horizontal forms_today" name="userForm" url="services/dashboard/today_info_report_block" method="post">
				<div class="panel panel-default mb20 panel-hovered analytics">
					<div class="panel-heading bd-btm"> <span>Today's Info Report block</span> <a href class="right ticketdropdown"><span class="ion ion-android-settings"></span></a>
						<div class="ticketsetting">
							<ul>
								<li>
									<select placeholder="State" name="state_alias[]" ng-options="state.name for state in firstDrop.ss track by state.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="state_alias" data-ng-change="listSortinginfo()">
									</select>
								</li>
								<li>
									<select placeholder="Customer" name="customer_alias[]" ng-options="customer.name for customer in firstDrop.cs track by customer.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="customer_alias" data-ng-change="listSortinginfo()">
									</select>
								</li>
								<li>
									<select placeholder="Segment" name="segment_alias[]" ng-options="segment.name for segment in firstDrop.ses track by segment.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="segment_alias" data-ng-change="listSortinginfo()">
									</select>
								</li>
								<li>
									<select name="activity_alias[]" placeholder="Activity" ng-options="activity.name for activity in firstDrop.acs track by activity.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="activity_alias" data-ng-change="listSortinginfo()">
									</select>
								</li>
								<li>
									<select name="faulty_alias[]" placeholder="Faulty Code" ng-options="faulty.name for faulty in firstDrop.fs track by faulty.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="faulty_alias" data-ng-change="listSortinginfo()">
									</select>
								</li>
								<li ng-controller="tatDropCntrl">
									<select Placeholder="Aging" name="tat[]" ng-options="aging.name for aging in tats track by aging.name" multiple="multiple" class="form-control selectdrop testSelAll2" ng-model="tat" data-ng-change="listSortinginfo()">
									</select>
								</li>
							</ul>
						</div>
						<span class="right mr20">Grand Total : <span style="color:#428bca;" ng-show="extdata.totalcount">{{extdata.totalcount}}</span></span> </div>
					<div class="panel-body">
						<c3-chart id="td_info"></c3-chart>
					</div>
				</div>
			</form>
		</div>
		
		<div class="col-lg-5 col-md-6 col-sm-12" ng-controller="tat_view" ng-init="listSortingtat()">
			<form class="form-horizontal forms_tat" name="userForm" url="services/dashboard/tat_status" method="post">
				<div class="panel panel-default mb20 panel-hovered">
					<div class="panel-heading bd-btm"> <span>TAT</span> <a href class="right ticketdropdown"><span class="ion ion-android-settings"></span></a>
						<div class="ticketsetting">
							<ul>
								<li>
									<select placeholder="State" name="state_alias[]" ng-options="state.name for state in firstDrop.ss track by state.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="state_alias" data-ng-change="listSortingtat()">
									</select>
								</li>
								<li>
									<select placeholder="Customer" name="customer_alias[]" ng-options="customer.name for customer in firstDrop.cs track by customer.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="customer_alias" data-ng-change="listSortingtat()">
									</select>
								</li>
								<li>
									<select placeholder="Segment" name="segment_alias[]" ng-options="segment.name for segment in firstDrop.ses track by segment.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="segment_alias" data-ng-change="listSortingtat()">
									</select>
								</li>
								<li>
									<select name="activity_alias[]" placeholder="Activity" ng-options="activity.name for activity in firstDrop.acs track by activity.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="activity_alias" data-ng-change="listSortingtat()">
									</select>
								</li>
								<li>
									<select name="faulty_alias[]" placeholder="Faulty Code" ng-options="faulty.name for faulty in firstDrop.fs track by faulty.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="faulty_alias" data-ng-change="listSortingtat()">
									</select>
								</li>
								<li>
									<select placeholder="Select Year" name="year" ng-options="yearr.name for yearr in firstDrop.yrr track by yearr.alias" class="dateSelect form-control" ng-model="year" data-ng-change="listSortingtat()">
										<option value="">Select Year</option>
									</select>
								</li>
							</ul>
						</div>
					</div>
					<div class="panel-body text-center">
						<c3-chart id="tat_con"></c3-chart>
					</div>
				</div>
			</form>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12" ng-controller="activity_view" ng-init="listSortingacty()">
			<form class="form-horizontal forms_activity" name="userForm" url="services/dashboard/nature_of_activity" method="post">
				<div class="panel panel-default mb20 panel-hovered">
					<div class="panel-heading bd-btm"> <span>Nature of Activity</span> <a href class="right ticketdropdown"><span class="ion ion-android-settings"></span></a>
						<div class="ticketsetting">
							<ul>
								<li>
									<select placeholder="State" name="state_alias[]" ng-options="state.name for state in firstDrop.ss track by state.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="state_alias" data-ng-change="listSortingacty()">
									</select>
								</li>
								<li>
									<select placeholder="Customer" name="customer_alias[]" ng-options="customer.name for customer in firstDrop.cs track by customer.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="customer_alias" data-ng-change="listSortingacty()">
									</select>
								</li>
								<li>
									<select placeholder="Segment" name="segment_alias[]" ng-options="segment.name for segment in firstDrop.ses track by segment.alias" multiple="multiple" class="testSelAll2 form-control" ng-model="segment_alias" data-ng-change="listSortingacty()">
									</select>
								</li>
								<li>
									<select placeholder="Select Year" name="year" ng-options="yearr.name for yearr in firstDrop.yrr track by yearr.alias" class="dateSelect form-control" ng-model="year" data-ng-change="listSortingacty()">
										<option value="">Select Year</option>
									</select>
								</li>
							</ul>
						</div>
					</div>
					<div class="panel-body text-center">
						<c3-chart id="n_act"></c3-chart>
					</div>
				</div>
			</form>
		</div>
		
		</div>
	</div>-->
<!--<div ng-init="closeloadings()"></div>-->
<div ng-init="closeloadings()"></div>
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
			if(!$(e.target).hasClass('testSelAll2') && !$(e.target).hasClass('ticketsetting') && !$(e.target).hasClass('dateSelect') && !$(e.target).hasClass('dropdow') && !$(e.target).hasClass('textSearch')){$('.ticketsetting').hide();} 
		}
	});
</script>