<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.viewDet{border-bottom:1px solid #eeeeee; padding:7px 15px;}
.tab-content{padding:0px;}
</style>
<div class="modal-style" ng-controller="CalendarDemoCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title" ng-show="{{detailEvents.event_type == '0'}}">Event Details</h4>
        <h4 class="modal-title" ng-show="{{detailEvents.event_type == '1'}}">Ticket Details</h4>
        <h4 class="modal-title" ng-show="{{detailEvents.event_type == '2'}}">DPR Details</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body">
        <div class="panel mb20 activities" ng-show="{{detailEvents.event_type == '0'}}">
            <ul class="list-unstyled">
                <li class="viewDet">
                    <h5 class="text-info">Title</h5>
                    <span class="time small">{{detailEvents.title}}</span>
                </li>
                <li class="viewDet">
                    <h5 class="text-info">Description</h5>
                    <span class="time small">{{detailEvents.service_engineer}}</span>
                </li>
                <li class="viewDet">
                    <h5 class="text-info">Event Date</h5>
                    <span class="time small">{{detailEvents.date}}</span>
                </li>
                <li class="viewDet">
                    <h5 class="text-info">Employee Name</h5>
                    <span class="time small">{{detailEvents.employee_name}}</span>
                </li>
                <li class="viewDet">
                    <h5 class="text-info">DPR</h5>
                    <span class="time small">{{detailEvents.dpr}}</span>
                </li>
				<li class="viewDet">
                    <h5 class="text-info">Created By</h5>
                    <span class="time small">{{detailEvents.created_by}}</span>
                </li>
            </ul>
        </div>
      
      
      
        <div class="panel mb20 activities" ng-show="{{detailEvents.event_type == '1'}}">
        <tabset justified="true" class="tabs-linearrow">
                     <tab ng-repeat="(key,detailEvents) in detailEvents.obj" ng-init="tabtickets(detailEvents.main_ticket_id,detailEvents.main_ticket_alias,detailEvents.level_code,detailEvents.levelcolor,detailEvents.level)" ng-click="tabtickets(tickets.main_ticket_id,tickets.ticket_alias,tickets.level_code,tickets.levelcolor,tickets.level)">
                      	<tab-heading class="active">{{detailEvents.purpose==0 ? 'VISIT':'REPLACE'}} - {{key+1}}</tab-heading>
                        <div class="panel-body clearfix tabing-panel">
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Ticket Number</h6>
                                    <span class="fnt-size-11">{{detailEvents.ticket_id}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Login date</h6>
                                    <span class="fnt-size-11">{{detailEvents.login_date}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Activity</h6>
                                    <span class="fnt-size-11">{{detailEvents.activity}}</span>
                                </div>
                            </div>
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Planned date</h6>
                                    <span class="fnt-size-11">{{detailEvents.planned_date}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Complaint</h6>
                                    <span class="fnt-size-11">{{detailEvents.complaint}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>product code</h6>
                                    <span class="fnt-size-11">{{detailEvents.product_description}}</span>
                                </div>
                            </div>
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Battery Bank Rating</h6>
                                    <span class="fnt-size-11">{{detailEvents.battery_bank_rating}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Segment</h6>
                                    <span class="fnt-size-11">{{detailEvents.segment_name}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Customer Name</h6>
                                    <span class="fnt-size-11">{{detailEvents.customer_name}}</span>
                                </div>
                            </div>
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>site id</h6>
                                    <span class="fnt-size-11">{{detailEvents.site_id}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>site name</h6>
                                    <span class="fnt-size-11">{{detailEvents.site_name}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Zones</h6>
                                    <span class="fnt-size-11">{{detailEvents.zone_name}}</span>
                                </div>
                            </div>
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>State</h6>
                                    <span class="fnt-size-11">{{detailEvents.state_name}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>District</h6>
                                    <span class="fnt-size-11">{{detailEvents.district_name}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Technician name</h6>
                                    <span class="fnt-size-11">{{detailEvents.technician_name}}</span>
                                </div>
                            </div>
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Technician No</h6>
                                    <span class="fnt-size-11">{{detailEvents.technician_number}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Manager Name</h6>
                                    <span class="fnt-size-11">{{detailEvents.manager_name}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Manager No</h6>
                                    <span class="fnt-size-11">{{detailEvents.manager_number}}</span>
                                </div>
                            </div>
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Manager Email</h6>
                                    <span class="fnt-size-11">{{detailEvents.manager_mail}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Manufacturing Date</h6>
                                    <span class="fnt-size-11">{{detailEvents.mfd_date}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Installation Date</h6>
                                    <span class="fnt-size-11">{{detailEvents.install_date}}</span>
                                </div>
                            </div>
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>No.Of Strings</h6>
                                    <span class="fnt-size-11">{{detailEvents.no_of_string}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Site Address</h6>
                                    <span class="fnt-size-11">{{detailEvents.site_address}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Site Status</h6>
                                    <span class="fnt-size-11">{{detailEvents.site_status}}</span>
                                </div>
                            </div>
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Faulty Cell Count</h6>
                                    <span class="fnt-size-11">{{detailEvents.faulty_cell_count}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>MOC</h6>
                                    <span class="fnt-size-11" ng-if="detailEvents.mode_of_contact == 'FAX' || detailEvents.mode_of_contact == 'LETTER'">
                                        <a href="{{detailEvents.contact_link}}" tooltip-placement="top" tooltip="Click here to view moc file">{{detailEvents.mode_of_contact}}</a>
                                     </span>
                                     <span class="fnt-size-11" ng-if="detailEvents.mode_of_contact == 'EMAIL' || detailEvents.mode_of_contact == 'PHONE' || detailEvents.mode_of_contact == 'ONLINE'">{{detailEvents.mode_of_contact}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Activation Date</h6>
                                    <span class="fnt-size-11">{{detailEvents.activation_date}}</span>
                                </div>
                            </div>
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Service Engineer Name</h6>
                                    <span class="fnt-size-11">{{detailEvents.service_engineer_name}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Closed Date</h6>
                                    <span class="fnt-size-11">{{detailEvents.closing_date}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>TAT</h6>
                                    <span class="fnt-size-11">{{detailEvents.tat}}</span>
                                </div>
                            </div>
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Mile Stone</h6>
                                    <span class="fnt-size-11">{{detailEvents.milestone}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Payment Terms</h6>
                                    <span class="fnt-size-11">{{detailEvents.payment_terms}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Description</h6>
                                    <span class="fnt-size-11">{{detailEvents.description}}</span>
                                </div>
                            </div>
                            <div class="row tkt-panel">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <h6>Site Type</h6>
                                    <span class="fnt-size-11">{{detailEvents.site_type}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4" ng-if="detailEvents.efsr_no != ''">
                                    <h6>e-FSR No. </h6>
                                    <span class="fnt-size-11" tooltip-placement="right" tooltip="{{detailEvents.efsr_date}}">{{detailEvents.efsr_no}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4" ng-if="detailEvents.efsr_no != ''">
                                    <h6>e-FSR </h6>
                                    <span class="fnt-size-11"><a href="{{base_url}}enersyscare_V2/pdf/?ticket_alias={{detailEvents.ticket_alias}}" target="_blank" tooltip-placement="top" tooltip="Click for e-FSR of {{detailEvents.ticket_id}}">{{detailEvents.fsrreport}}</a></span>
                                </div>
                            </div>
                            <br>
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
                                            <tr class="tktBackground" ng-repeat="(key,rem) in detailEvents.remark">
                                                <td>{{key + 1}}</td>
                                                <td><p tooltip-placement="top" tooltip="{{rem.designation}}">{{rem.remarkedby}}</p></td>
                                                <td class="hidden-xs hidden-sm">{{rem.remarkedon}}</td>
                                                <td>{{rem.remark}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                     <!--</tab>
                 </tabset>-->
             </div>    
        
        <div class="panel mb20 activities" ng-show="detailEvents.event_type == '2'" >
        <ul class="list-unstyled">
                <li class="viewDet">
                    <h5 class="text-info">DPR Ref No</h5>
                    <span class="time small">{{detailEvents.dpr_ref_no}}</span>
                </li>
                <li class="viewDet">
                    <h5 class="text-info">Description</h5>
                    <span class="time small">{{detailEvents.category}}</span>
                </li>
                <li class="viewDet">
                    <h5 class="text-info">Event Date</h5>
                    <span class="time small">{{detailEvents.sub_date_time}}</span>
                </li>
                <li class="viewDet">
                    <h5 class="text-info">Remarks</h5>
                    <span class="time small">{{detailEvents.remarks}}</span>
                </li>
                <li class="viewDet">
                    <h5 class="text-info">Expense Incurred</h5>
                    <span class="time small">{{detailEvents.expense_incurred}}</span>
                </li>
                <li class="viewDet">
                    <h5 class="text-info">Tracking Address</h5>
                    <span class="time small">{{detailEvents.tracking_alias}}</span>
                </li>
            </ul>
        </div>
        
	</div>
</div>