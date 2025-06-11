<style>.tab-content{background:none !important; box-shadow:none !important; padding:0px !important;}</style>
<div class="page page-ui-extras" ng-controller="ModalDemoCtrl">
	<div ng-controller="ticketcustomerCtrl as main">
    <div ng-controller="mul_view_form">
		<div class="panel panel-lined table-responsive panel-hovered mb10" style="" >
			<ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
                <li><a href="#/dashboard" class="padding-10">Home</a></li>
                <li><a href="" class="padding-10">Tickets</a></li>
			</ol>
			<ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;">
				<li><a href="" ng-click="ticketcustexportOpen()" class="padding-10 export-btn">Export</a></li>
			</ol>
		</div>
		<div class="row">
			<div class="col-md-12 table-height">
				<div class="panel panel-lined table-responsive panel-hovered" style="overflow-x:hidden">
					<div class="panel panel-default">
						<form class="form-horizontal forms_ec" url="services/customer/ticket_mul_view" name="userForm" method="post" novalidate>
							<table class="table table-condensed">
								<thead>
									<tr>
                                        <th width="150px">
                                            <a class="tktid">Ticket ID&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" class="droptxt1 hidden" name="ticketId" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()" />
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                                        </th>
                                        <th class="hidden-xs hidden-sm" ng-controller="DatepickerDemoCtrl">
                                            <a class="tktid">Login Date&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" class="form-control datepicker border-bottom droptxt1 hidden" name="loginDate" placeholder="Select date.." ng-model="logindate" datepicker-popup="{{format}}" ng-click="open($event)" is-open="opened" min-date="'01-01-2000'" max-date="'22-06-2025'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="listSorting();open($event)"/>
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                                        </th>
                                        <th class="hidden-xs hidden-sm" ng-controller="activitylistCtrl">
                                            <select name="activityAlias" placeholder="Activity" class="SlectBox form-control" ng-model="selectt.id" data-ng-change="listSorting()">
                                                <option value="" style="display:none">Activity</option>
                                                <option ng-repeat="selectlist in firstDrop" value="{{selectlist.alias}}">{{selectlist.name}}</option>
                                                <option ng-if="firstDrop.length==0">No Records</option>
                                            </select>
                                        </th>
                                        <th class="hidden-xs hidden-sm" ng-controller="segmentdropCntrl">																								
                                            <select name="segmentAlias" placeholder="Segment" class="SlectBox form-control" ng-model="selectt.id" data-ng-change="listSorting()">
                                                <option value="" style="display:none">Segment</option>
                                                <option ng-repeat="selectlist in firstDrop" value="{{selectlist.alias}}">{{selectlist.name}}</option>
                                                <option ng-if="firstDrop.length==0">No Records</option>
                                            </select>
                                        </th>
                                        <th class="hidden-xs" width="140px">
                                            <a class="tktid">Site Name&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" class="droptxt1 hidden form-control" name="siteId" placeholder="Type keyword" data-ng-keyup="listSorting()"  />
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                                        </th>
                                        <th class="hidden-xs hidden-sm">
                                            <a class="tktid">Customer&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" class="droptxt1 hidden form-control" name="customerName" placeholder="Type keyword" data-ng-keyup="listSorting()"  />
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                                        </th>
                                        <th ng-controller="leveldropCntrl">
                                            <select name="levels" placeholder="Levels" class="SlectBox form-control" ng-model="selectt.id" data-ng-change="listSorting()">
                                                <option value="" style="display:none">Levels</option>
                                                <option ng-repeat="selectlist in firstDrop" value="{{selectlist.alias}}" ng-if="selectlist.alias!='5'">{{selectlist.name}}</option>
												<option value="pf" ng-if="firstDrop.length!=0">PLAN FAIL</option>
												<option value="tsr" ng-if="firstDrop.length!=0">TS REJECTED</option>
                                                <option ng-if="firstDrop.length==0">No Records</option>
                                            </select>
                                        </th>
                                        <th width="80px" class="hidden-xs hidden-sm" ng-controller="tatDropCntrl">
                                            <select name="tat" placeholder="TAT Level" class="SlectBox form-control" ng-model="selectt.id" data-ng-change="listSorting()">
                                                <option value="" style="display:none">TAT</option>
                                                <option ng-repeat="selectlist in tats" value="{{selectlist.name}}">{{selectlist.name}}</option>
                                                <option ng-if="firstDrop.length==0">No Records</option>
                                            </select>			
                                        </th>
                                        <th class="hidden-xs hidden-sm">
                                            <select name="report" placeholder="Report" class="SlectBox form-control" ng-model="report" data-ng-change="listSorting()">
                                                <option value="" style="display:none">Report</option>
                                                <option value="1">e-FSR</option>
                                                <option value="0">FSR</option>
                                            </select>			
                                        </th>
                                        <th class="hidden-xs hidden-sm">
                                            <select name="mrs" placeholder="MRS" class="SlectBox form-control" ng-model="mrs" data-ng-change="listSorting()">
                                                <option value="" style="display:none">MRS</option>
                                                <option value="RTF">RTF</option>
                                                <option value="ITF">ITF</option>
                                                <option value="INW">INW</option>
                                                <option value="ITS">ITS</option>
                                                <option value="CLS">CLS</option>
                                            </select>			
                                        </th>
									</tr>
								</thead>
							</table>
							<div class="div-table-content">
								<table class="table table-condensed table-hover">
									<tbody>
                                        <tr class="tktBackground" ng-repeat="data in datas.ticketDetails" >
                                            <td width="150px" ng-click="createing(data.ticket_alias)" class="tktClick"><span tooltip-placement="top" tooltip="Click to know details of {{data.ticket_id}}">{{data.ticket_id}}</span></td>
                                            <td class="hidden-xs hidden-sm">{{data.login_date}}</td>
                                            <td class="hidden-xs hidden-sm">{{data.activity}}</td>
                                            <td class="hidden-xs hidden-sm"><span tooltip-placement="top" tooltip="{{data.segment_name}}">{{data.segment_code}}</span></td>
                                            <td width="140px" class="hidden-xs"><span tooltip-placement="top" tooltip="{{data.site_name}}">{{data.site_name | limitTo:12}}{{data.site_name.length>12 ? '...':''}}</span></td>
                                            <td class="hidden-xs hidden-sm"><span tooltip-placement="top" tooltip="{{data.customer_name}}">{{data.customer_code}}</span></td>
                                            <td><span tooltip-placement="top" tooltip="{{data.pl_levelname}}"><i class="fa fa-signal" style="color:{{data.levelcolor}} !important;"></i>&nbsp;{{data.levelname}}</span></td>
                                            <td width="80px" class="hidden-xs hidden-sm">{{data.tat}}</td>
                                            <td ng-if="data.fsrreport=='0'"><span>-</span></td>
											<td ng-if="data.fsrreport=='1'"><a href="{{data.esca_efsr_link}}" target="_blank" tooltip-placement="bottom" tooltip="Attended Date {{data.efsr_date}}">e-FSR</a></td>
                                            <td ng-if="data.fsrreport=='2'"><a href="{{data.esca_efsr_link}}" target="_blank" tooltip-placement="bottom" tooltip="Attended Date {{data.efsr_date}}">FSR</a></td>
											<!--<td ng-if="data.fsrreport=='e-FSR'"><a href="{{base_url}}enersyscare_V2/pdf/?ticket_alias={{data.ticket_alias}}" target="_blank" tooltip-placement="bottom" tooltip="Attended Date {{data.efsr_date}}">{{data.fsrreport}}</a></td>
                                            <td ng-if="data.fsrreport=='-'"><span>{{data.fsrreport}}</span></td>-->
											<td class="hidden-xs hidden-sm"><span>{{data.mrf}}</span></td>
                                        </tr>
									</tbody>
									<tfoot ng-if="datas.ticketDetails.length=='0'"><tr><td>No Records</td></tr></tfoot>
								</table>
							</div>
							<div class="panel-footer clearfix" ng-if="datas.ticketDetails.length!='0'">
                                <div class="col-md-4">
                                        <p class="left small" style="margin:0px !important;">Showing {{datas.fromRecords}} to {{datas.toRecords}} of {{datas.totalRecords}} entries</p>
                                </div>
								<div class="col-md-4">
									<div class="small text-bold right ml15">
										<span class="control-label">Page No. </span>
                                        <select class="form-control page-count"  name="page_no" ng-model="selectt.id" data-ng-change="listSorting()">
                                            <option value="" style="display:none">1</option>
                                            <option ng-repeat="pagess in datas.pages" ng-show="$index > 0" value="{{pagess}}">{{pagess}}</option>
                                        </select> 
									</div>
								</div>
								<div class="col-md-4">
                                    <div class="small text-bold right ml15">
                                        <span class="control-label">Count per page</span>
                                        <select class="form-control page-count" name="perpagecount" ng-model="selectt.ids" data-ng-change="listSorting()">
                                            <option value="" style="display:none">10</option>
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                            <option value="75">75</option>
                                            <option value="100">100</option>
                                            <option value="150">150</option>
                                        </select> 
                                    </div>
								</div>
							</div>
						</form>						
					</div>
				</div>
			</div>
		<div><button type="button" class="btn btn-info ion ion-plus compose-btn" tooltip="Add New" tooltip-placement="top"  ng-click="ticketcustomerOpen()" md-ink-ripple></button></div>
		</div>
        </div>
     <div id="ticketviesw">
		<div class="site-settings ticketviesw clearfix  col-xs-6 floating-sidebar" ng-class="{'open': ticket_open}">
			<div class="sidebar-wrap text-uppercase mt46">	
				<div class="group clearfix head tkt-heading2">
                
					<div class="left">
						<span class="ion ion-close-round mr10 tktviewClose" ng-click="removeTickets()"></span>
						<span><strong>{{main_ticket_id}}</strong> &nbsp;<span class="fa fa-signal" style="color:{{levelcolor}} !important;"></span> &nbsp;<span class="mt5" style="font-size:8px;">{{level}}</span></span>
					</div>
					<div class="right">	
						<div class="btn-group btn-group-sm">
                            <a href="services/tickets/tickets_print.php?alias={{ticket_alias}}" tooltip="Print" class="ml10" tooltip-placement="bottom"><span class="ion ion-android-print"></span></a>
                            <a href="services/tickets/tickets_download.php?alias={{ticket_alias}}" target="_blank" tooltip="Download" class="ml10" tooltip-placement="bottom"><span class="ion ion-android-download"></span></a>
						</div>
					</div>
				</div>	
              
				<scrollable-tabset api="main.scrlTabsApi" tooltip-left-placement="right">
                 <tabset justified="true" class="tabs-linearrow">
                     <tab active="isActive[key]" ng-repeat="(key,tickets) in singleViews.obj"  ng-init="isActive[singleViews.obj.length-1]=true;(singleViews.obj.length-1==key ? main.scrollIntoView(key) : '');tabtickets(singleViews.main_ticket_id,singleViews.main_ticket_alias,singleViews.level_code,singleViews.levelcolor,singleViews.level)" ng-click="tabtickets(tickets.main_ticket_id,tickets.ticket_alias,tickets.level_code,tickets.levelcolor,tickets.level)">
                      	<tab-heading class="active">VISIT - {{key+1}}</tab-heading>
                        <div class="panel-body clearfix tabing-panel">
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Ticket Number</h6>
                                    <span class="fnt-size-11">{{tickets.ticket_id}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Login date</h6>
                                    <span class="fnt-size-11">{{tickets.login_date}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Activity</h6>
                                    <span class="fnt-size-11">{{tickets.activity}}</span>
                                </div>
                            </div>
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Planned date</h6>
                                    <span class="fnt-size-11">{{tickets.planned_date}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Service Engineer Name</h6>
                                    <span class="fnt-size-11">{{tickets.service_engineer_name}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Complaint</h6>
                                    <span class="fnt-size-11">{{tickets.complaint}}</span>
                                </div>
                            </div>
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>product code</h6>
                                    <span class="fnt-size-11">{{tickets.product_description}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Battery Bank Rating</h6>
                                    <span class="fnt-size-11">{{tickets.battery_bank_rating}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Segment</h6>
                                    <span class="fnt-size-11">{{tickets.segment_name}}</span>
                                </div>
                            </div>
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Customer Name</h6>
                                    <span class="fnt-size-11">{{tickets.customer_name}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>site id</h6>
                                    <span class="fnt-size-11">{{tickets.site_id}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>site name</h6>
                                    <span class="fnt-size-11">{{tickets.site_name}}</span>
                                </div>
                            </div>
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Zones</h6>
                                    <span class="fnt-size-11">{{tickets.zone_name}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>State</h6>
                                    <span class="fnt-size-11">{{tickets.state_name}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>District</h6>
                                    <span class="fnt-size-11">{{tickets.district_name}}</span>
                                </div>
                            </div>
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>First Level Contact Name</h6>
                                    <span class="fnt-size-11">{{tickets.technician_name}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>First Level Contact No.</h6>
                                    <span class="fnt-size-11">{{tickets.technician_number}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Second Level Contact Name</h6>
                                    <span class="fnt-size-11">{{tickets.manager_name}}</span>
                                </div>
                            </div>
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Second Level Contact No.</h6>
                                    <span class="fnt-size-11">{{tickets.manager_number}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Second Level Contact Email</h6>
                                    <span class="fnt-size-11">{{tickets.manager_mail}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Manufacturing Date</h6>
                                    <span class="fnt-size-11">{{tickets.mfd_date}}</span>
                                </div>
                            </div>
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Installation Date</h6>
                                    <span class="fnt-size-11">{{tickets.install_date}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>No.Of Strings</h6>
                                    <span class="fnt-size-11">{{tickets.no_of_string}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Site Address</h6>
                                    <span class="fnt-size-11">{{tickets.site_address}}</span>
                                </div>
                            </div>
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Site Status</h6>
                                    <span class="fnt-size-11">{{tickets.site_status}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Faulty Cell Count</h6>
                                    <span class="fnt-size-11">{{tickets.faulty_cell_count}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>MOC</h6>
                                    <span class="fnt-size-11" ng-if="tickets.mode_of_contact == 'FAX' || tickets.mode_of_contact == 'LETTER'">
                                        <a href="{{tickets.contact_link}}" tooltip-placement="top" tooltip="Click here to view moc file">{{tickets.mode_of_contact}}</a>
                                     </span>
                                     <span class="fnt-size-11" ng-if="tickets.mode_of_contact == 'EMAIL' || tickets.mode_of_contact == 'PHONE'">{{tickets.mode_of_contact}}</span>
                                </div>
                            </div>
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Activation Date</h6>
                                    <span class="fnt-size-11">{{tickets.activation_date}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Closed Date</h6>
                                    <span class="fnt-size-11">{{tickets.closing_date}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>TAT</h6>
                                    <span class="fnt-size-11">{{tickets.tat}}</span>
                                </div>
                            </div>
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Mile Stone</h6>
                                    <span class="fnt-size-11">{{tickets.milestone}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Payment Terms</h6>
                                    <span class="fnt-size-11">{{tickets.payment_terms}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Description</h6>
                                    <span class="fnt-size-11">{{tickets.description}}</span>
                                </div>
                            </div>
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Site Type</h6>
                                    <span class="fnt-size-11">{{tickets.site_type}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4" ng-if="tickets.efsr_no != ''">
                                    <h6>e-FSR No. </h6>
                                    <span class="fnt-size-11" tooltip-placement="right" tooltip="{{tickets.efsr_date}}">{{tickets.efsr_no}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4" ng-if="tickets.efsr_no != ''">
                                    <h6>e-FSR </h6>
                                    <span class="fnt-size-11"><a href="{{base_url}}enersyscare_V2/pdf/?ticket_alias={{tickets.ticket_alias}}" target="_blank" tooltip-placement="top" tooltip="Click for e-FSR of {{tickets.ticket_id}}">{{tickets.fsrreport}}</a></span>
                                </div>
                            </div>
                            <br/>
							<div ng-if="tickets.level_code > '2' && tickets.se_count!='0'">
								<div class="row mt30"><p style="color:#FFF;background-color:#428bca;text-align:center;font-weight:bold">Service Engineer Observation</p></div>
								<div class="row tkt-panel">
									<div class="col-lg-4 col-md-4 col-sm-4">
										<h6>Faulty Cells</h6>
										<span class="fnt-size-11 wrd_break">{{tickets.faulty_cell_sr_no}}</span>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4">
										<h6>Replaced Cells</h6>
										<span class="fnt-size-11 wrd_break">{{tickets.replaced_cell_no}}</span>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4">
										<h6>Required Cells</h6>
										<span class="fnt-size-11 wrd_break">{{tickets.req_cells}}</span>
									</div>
								</div>
								<div class="row tkt-panel" ng-if="tickets.action != ''">
									<div class="col-lg-4 col-md-4 col-sm-4">
										<h6>Action Taken By Engineer</h6>
										<span class="fnt-size-11 wrd_break">{{tickets.action}}</span>
									</div>
								</div>
							</div>
							<div class="mb20" ng-if="tickets.req.length != 0">
                                <h5 class="modal-title text-center">Required Cells</h5>
                                <table class="table table-condensed" >
                                    <thead>
                                        <tr>
                                            <th><a class="tktid">Cells</a></th>
                                            <th><a class="tktid">Quantity</a></th>
                                            <th><a class="tktid">Status</a></th>
                                            <th><a class="tktid">Approved By</a></th>
                                            <th><a class="tktid">Approved On</a></th>
                                        </tr>
                                    <thead>
                                </table>
                                <table class="table table-hover table-bordered">
                                    <tbody>
                                        <tr class="tktBackground" ng-repeat="(key,rem) in tickets.req">
                                            <td>{{rem.cell_name}}</td>
                                            <td>{{rem.quanty}}</td>
                                            <td>{{rem.approved_stat}}</td>
                                            <td>{{rem.approved_by}}</td>
                                            <td>{{rem.approved_on}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div ng-if="tickets.remark_length != 0">
                                <h4 class="modal-title text-center">Remarks</h4>
								<table class="table table-condensed" >
									<thead>
										<tr>
											<th><a class="tktid">Sr.No</a></th>
											<th><a class="tktid">Remark By</a></th>
											<th><a class="tktid">Remark On</a></th>
											<th><a class="tktid">Remark</a></th>
										</tr>
									</thead>
								</table>
								<table class="table table-hover table-bordered">
									<tbody>
										<tr class="tktBackground" ng-repeat="(key,rem) in tickets.remark">
											<td>{{key + 1}}</td>
											<td><p tooltip-placement="top" tooltip="{{rem.designation}}">{{rem.remarkedby}}</p></td>
											<td class="hidden-xs hidden-sm">{{rem.remarkedon}}</td>
											<td>{{rem.remark}}</td>
										</tr>
									</tbody>
								</table>
							</div>
                        </div>
                     </tab>
                 </tabset>
				</scrollable-tabset>
			</div>
		</div>
       </div>
	</div>
</div>
<script>
	$(document).ready(function(){
	   $('.tktid').click(function(){
		  var thw=($(this).parent('th').width());
		   $('.droptxt1').filter(function(){
				if($(this).val()==''){
				   $(this).width($(this).parent('th').width());
				   $(this).addClass('hidden');
				   $(this).siblings('.inptClose').addClass('hidden');
				   $(this).siblings('.tktid').removeClass('hidden');
				}
		   });
		   $(this).siblings('.droptxt1, .inptClose').removeClass('hidden');
		   $(this).siblings('.droptxt1').focus();
		   $(this).addClass('hidden');
	   });
		$('.droptxt1').click(function(){
		   $('.droptxt1').not(this).filter(function(){
				if($(this).val()==''){
				   $(this).width($(this).parent('th').width());
				   $(this).addClass('hidden');
				   $(this).siblings('.inptClose').addClass('hidden');
				   $(this).siblings('.tktid').removeClass('hidden');
				}
		   });
	   });
	   $('.inptClose').click(function(){
		   $(this).siblings('.droptxt1').val('');
		   $(this).addClass('hidden');
		   $(this).siblings('.tktid').removeClass('hidden');
		   $(this).siblings('.droptxt1').addClass('hidden');
	   });
	   $(document).click(function(e){
			if (!$(e.target).hasClass("tktid") && $(".tktid").hasClass("hidden") && !$(e.target).hasClass("droptxt1")){
				$('.droptxt1').filter(function(){
					if($(this).val()==''){
						$(this).siblings(".tktid").removeClass('hidden');
						$(this).addClass('hidden');
						$(this).siblings(".inptClose").addClass('hidden');
					}
				});
			}
		});
	   /*---multiple-select dropdown-----*/
		setInterval(function(){$('.SlectBox').SumoSelect();},0);
	});
</script>