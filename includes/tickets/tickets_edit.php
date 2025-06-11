<style>
.blue_place{color: #428bca !important;font-size: 14px !important;}
.form-group {margin-bottom:0px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.upload-file{border-bottom: 1px solid rgba(0,0,0,0.12); padding-top:9px;}
select .form-control:{height:68px !important;}
.cells{box-shadow: 0 3px 12px 0 rgba(0, 0, 0, 0.15);}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
.mb25{margin-bottom: 25px;}

.panel-heading b{color:#428bca; margin-right:20px;}.panel-heading i{color:#428bca;}.panel-heading span{color:#428bca}
.panel-info > .panel-heading { color: #ffffff !important; background-color: #2196f3; border-color: #2196f3;}
.panel-info > .panel-heading span{color:#fff;}
.panel-info > .panel-heading i{color:#fff;}
.panel-info > .panel-heading b{color:#fff;}
.right a span{color:#428bca;}
.exp_sing{padding:8px !important; margin:0px !important; background-color:#f5f5f5 !important;}
.exp_sing b{color:#535353}
.singPad{padding:5px 10px;}
</style>
<div class="modal-style" ng-controller="ticketEditCntl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit Tickets</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
		<form class="form-horizontal forms_add" reset-directive="singleViews" name="userForm" data-went="#/tickets" method="post" url="services/tickets/ticket_update" ng-submit="sendPost()" novalidate>
            <input type="hidden" value="{{singleViews.ticket_alias}}" name="ticket_alias"/>
	<!-- TS Approved -->
	  <accordion class="accordion-panel" ng-if="singleViews.ts_approved_length != '0'">
	  <div class="panel panel-default panel-hovered">
		<!--<div class="panel-heading exp_sing">TECHNICAL SERVICE REPORT</div>-->
		<accordion class="accordion-panel" >
			<accordion-group is-open="lc_status.open" ng-class="{'panel-info': lc_status.open}">
			<accordion-heading>
				TECHNICAL SERVICE DETAILS &nbsp; <i class="mt2 ion small" ng-class="{'ion-chevron-down': lc_status.open, 'ion-chevron-right': !lc_status.open}"></i>
			</accordion-heading>
			<div class="mb20">
				<div class="row mb20">
					<div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
					  <h5>Line Number</h5>
					  <span class="fnt-size-11">{{singleViews.line_number}}</span>
					</div>
					<div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
					  <h5>Shift</h5>
					  <span class="fnt-size-11">{{singleViews.shift}}</span>
					</div>
					<div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
					  <h5>Date Of Assembly</h5>
					  <span class="fnt-size-11">{{singleViews.date_of_assembly}}</span>
					</div>
					<div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
					  <h5>Date Of Jar formation</h5>
					  <span class="fnt-size-11">{{singleViews.date_of_jar_form}}</span>
					</div>
					<div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
					  <h5>Corrective Actions Planned</h5>
					  <span class="fnt-size-11">{{singleViews.corect_act_Plan}}</span>
					</div>
					<div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
					  <h5>Persons Notified</h5>
					  <span class="fnt-size-11">{{singleViews.persons_notified}}</span>
					</div>
					<div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
					  <h5>Deposition</h5>
					  <span class="fnt-size-11">{{singleViews.deposition}}</span>
					</div>
				</div>
				<div class="panel-heading exp_sing"><h5 class="modal-title text-center">Faulty Cells Details</h5></div>
				<table class="table table-condensed" >
					<thead>
						<tr>
							<th><a class="tktid">Sr.No</a></th>
							<th><a class="tktid">Faulty Cell Serial No.</a></th>
							<th><a class="tktid">OCV at dispatch</a></th>
							<th><a class="tktid">10th Hour reading</a></th>
						</tr>
					<thead>
				</table>
				<div class="">
					<table class="table table-hover table-bordered">
						<tbody>
							<tr class="tktBackground" ng-repeat="(key,ts) in singleViews.ts_approved">
								<td>{{key + 1}}</td>
								<td>{{ts.faulty_cell_num}}</td>
								<td class="hidden-xs hidden-sm">{{ts.ocv}}</td>
								<td>{{ts.tenth_hour}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
				</accordion-group>
			</accordion>
			</div>
		</accordion>
		
<!-- All Remarks -->
	  <accordion class="accordion-panel" ng-if="singleViews.remark_length != 0">
	  <div class="panel panel-default panel-hovered">
		<!--<div class="panel-heading exp_sing">REMARKS</div>-->
		<accordion class="accordion-panel" >
			<accordion-group is-open="lc_status.open" ng-class="{'panel-info': lc_status.open}">
			<accordion-heading>
				REMARKS &nbsp; <i class="mt2 ion small" ng-class="{'ion-chevron-down': lc_status.open, 'ion-chevron-right': !lc_status.open}"></i>
			</accordion-heading>
				<div class="mb20">
						<table class="table table-condensed" >
							<thead>
								<tr>
									<th><a class="tktid">Sr.No</a></th>
									<th><a class="tktid">Bucket</a></th>
									<th><a class="tktid">Remark By</a></th>
									<th><a class="tktid">Remark On</a></th>
									<th><a class="tktid">Remark</a></th>
								</tr>
							<thead>
						</table>
						<div class="">
							<table class="table table-hover table-bordered">
								<tbody>
									<tr class="tktBackground" ng-repeat="(key,rem) in singleViews.remark">
										<td>{{key + 1}}</td>
										<td>{{rem.bucket}}</td>
										<td><p tooltip-placement="top" tooltip="{{rem.designation}}">{{rem.remarkedby}}</p></td>
										<td class="hidden-xs hidden-sm">{{rem.remarkedon}}</td>
										<td style="word-wrap:break-word">{{rem.remark}}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</accordion-group>
			</accordion>
			</div>
		</accordion>
<!-- All Cells Required -->
	  <accordion class="accordion-panel" ng-if="singleViews.required_cells.length != 0">
	  <div class="panel panel-default panel-hovered">
		<!--<div class="panel-heading exp_sing">REMARKS</div>-->
		<accordion class="accordion-panel" >
			<accordion-group is-open="lc_status.open" ng-class="{'panel-info': lc_status.open}">
			<accordion-heading>
				REQUIRED ITEMS &nbsp; <i class="mt2 ion small" ng-class="{'ion-chevron-down': lc_status.open, 'ion-chevron-right': !lc_status.open}"></i>
			</accordion-heading>
				<div class="mb20">
					<!--<h5 class="modal-title text-center">Required Items</h5>-->
					<table class="table table-condensed" >
						<thead>
							<tr>
								<th><a class="tktid">Item Type</a></th>
								<th><a class="tktid">Item Desc</a></th>
								<th><a class="tktid">Req Qty</a></th>
								<th ng-if="singleViews.level_code=='8'"><a class="tktid">App Qty</a></th>
								<th><a class="tktid">Status</a></th>
								<th><a class="tktid">Approved By</a></th>
								<th><a class="tktid">Approved On</a></th>
							</tr>
						<thead>
					</table>
					<table class="table table-hover table-bordered">
						<tbody>
							<tr class="tktBackground" ng-repeat="(key,rem) in singleViews.required_cells">
								<td>{{rem.item_type==1 ? 'CELL' : 'ACCESSORY'}}</td>
								<td>{{rem.cells}}</td>
								<td>{{rem.quantity}}</td>
								<td ng-if="singleViews.level_code=='8'">
								{{rem.approved_stat != 'PENDING' ? rem.quantity : ''}}
									<md-input-container flex="" ng-if="rem.approved_stat == 'PENDING'">
										<input type="hidden" value="{{rem.item_alias}}" ng-model="rem.item_alias" name="item_alias[]">
										<input class="form-control" ng-pattern-restrict="^$|^[0-9][0-9]*$" ng-minlength="1" maxlength="4" type="text" ng-model="app_quantity" name="app_quantity[]" class="md-input ng-touched">
								   </md-input-container>
								</td>
								<td>{{rem.approved_stat}}</td>
								<td>{{rem.approved_by}}</td>
								<td>{{rem.approved_on}}</td>
							</tr>
						</tbody>
					</table>
				</div>
				</accordion-group>
			</accordion>
			</div>
		</accordion>
 <!-- Level 0 to 1-->
 
                <div class="row form-group"> 
                    <div ng-if="singleViews.level_code=='0'">
                        <div class="col-sm-8 col-sm-offset-2" ng-controller="onlinetktCtrl">
                		<label class="selectlabel">Online Ticket</label>
                            <select class="form-control testSelAll2 editselectdrop" name="online_tickets" ng-model="onlineticket" required="required">
                                <option value="" selected="selected" disabled="disabled">Select Online Ticket</option>
                                <option ng-repeat="ticket in onlinetickets" value="{{ticket.value}}">{{ticket.name}}</option>
                            </select>
                             <span class="help-block" ng-show="userForm.online_tickets.$dirty && userForm.online_tickets.$invalid">
                                <span ng-show="userForm.online_tickets.$error.required">Select Option</span>
                            </span>
                        </div>
                    </div>
                </div>
                
 <!-- Level 1 to 2 -->

                 <div class="row form-group" ng-controller="general"> 
                    <div ng-if="singleViews.level_code=='1'">
                        <div class="row form-group">
                            <div class="col-sm-9 col-sm-offset-1 mb10">
								<label class="selectlabel">General<span style="color:red" ng-if="singleViews.outward && thisValue.value==0">&nbsp;&nbsp;&nbsp;&nbsp;(Planning not allowed untill material outward is done against this TT Number)</span></label>
                                <select class="form-control testSelAll2 editselectdrop" name="general" ng-model="thisValue" ng-options="opt as opt.label for opt in options" required="required">
                                    <option value=""  disabled="disabled">--Select--</option>
                                </select>
                                <span class="help-block" ng-show="userForm.general.$dirty && userForm.general.$invalid">
                                    <span ng-show="userForm.general.$error.required">Select Any One Option</span>
                                </span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div ng-if="thisValue.value==0">
                                <div class="col-sm-3 col-sm-offset-1" ng-controller="DatepickerDemoCtrl">
								<input type="hidden" name="outward" value="{{singleViews.outward ? '1' : '2'}}" ng-model="singleViews.outward"/>
                                   <md-input-container flex="" class="md-default-theme">
                                        <label for="input_00D">Plan Date</label>
                                        <input type="text" ng-model="plandatedate" name="planned_date" class="datepicker ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false" id="input_00D" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" is-open="opened" min-date="dt" max-date="'22-06-2025'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" required="required"/>
                                   </md-input-container>
                                     <span class="help-block" ng-show="userForm.planned_date.$dirty && userForm.planned_date.$invalid">
                                        <span ng-show="userForm.planned_date.$error.required">Select Plan Date</span>
                                    </span>
                                </div>
                                <div class="col-sm-3">
                                <label class="selectlabel">Employee Role</label>
                                    <select class="form-control testSelAll2 selectdrop" name="emp_role" ng-model="emprole" ng-change="dep_drop(emprole,'service_engineer_alias')" required>
                                        <option value="" disabled="disabled">Employee Role</option>
                                        <option ng-repeat="role in firstDrop" value="{{role.alias}}">{{role.name}}</option>
                                   </select>
                                     <span class="help-block" ng-show="userForm.emp_role.$dirty && userForm.emp_role.$invalid">
                                        <span ng-show="userForm.emp_role.$error.required">Select Employee Role</span>
                                    </span>
                                </div>
                                <div class="col-sm-3">
                                <label class="selectlabel">Employee Name</label>
                                    <select class="form-control testSelAll2 selectdrop" name="service_engineer_alias" ng-model="service_engineer" required>
                                        <option value="" disabled="disabled">Employee Name</option>
                                        <option ng-repeat="employeelist in secondDrop" value="{{employeelist.alias}}">{{employeelist.name}}</option>
                                   </select>
                                     <span class="help-block" ng-show="userForm.service_engineer_alias.$dirty && userForm.service_engineer_alias.$invalid">
                                        <span ng-show="userForm.service_engineer_alias.$error.required">Select Employee Name</span>
                                    </span>
                                </div>
                            </div>
                        </div>
						
						<div ng-if="thisValue.value==1">
                            <div class="row form-group">
                               <div class="col-sm-6 mb10">
                                <div class="panel panel-lined mb20 cells" ng-controller="addFieldsCtrl">
                                    <div class="panel-body">
                                        <div class="row form-group" ng-repeat="field in forms" ng-controller="reqCellAccdropCntrl">
                                            <div class="header ml10" ng-init="req_ceh=secondDrop.length>1 ? true : false">
                                                <span><strong>REQUIRED CELLS</strong></span>
                                                <span ng-if="req_ceh" class="btn btn-info btn-sm right" ng-click="removeFields(field)">Remove</span>
                                                <span ng-if="req_ceh" class="btn btn-info btn-sm right mr5" ng-click="addFields(field)">Add</span>
                                            </div>
                                            <div>
                                                <div class="form-group" ng-repeat="type in field.itemtype">
                                                    <div class="col-sm-9 mb10">
														<md-input-container flex="" ng-if="!req_ceh" class="md-default-theme md-input-has-value">
															<label for="input_00D">REQUIRED CELLS</label>
															<input type="hidden" value="{{secondDrop[0].alias}}" ng-model="secondDrop[0].alias" name="item_code[]"/>
															<input type="text" ng-model="secondDrop[0].name" class="md-input ng-touched" aria-invalid="false" id="input_00D" readonly="readonly"/>
													   </md-input-container>
													   
                                                        <label ng-if="req_ceh" class="selectlabel">Required Cell</label>
                                                        <select ng-if="req_ceh" class="form-control testSelAll2 selectdrop" name="item_code[]" ng-model="item_code">
                                                            <option value="" selected="selected">Select Required Cell</option>
                                                            <option ng-repeat="itemcode in firstDrop" value="{{itemcode.alias}}">{{itemcode.name}}</option>
                                                        </select>
                                                     </div>
                                                    <div class="col-sm-3">
                                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                            <label for="input_00D">Quantity</label>
                                                            <input type="text" ng-model="quantity" valid-input="4" name="quantity[]" class="md-input ng-touched" aria-invalid="false" id="input_00D" placeholder="Enter Cells Quantity"/>
                                                       </md-input-container>
                                                    </div>
                                                </div>
                                            </div>           
                                        </div>
                                    </div>
                                 </div>
                               </div>
                             <div class="col-sm-6">
                                <div class="panel panel-lined mb20 cells" ng-controller="addFieldsCtrl">
                                    <div class="panel-body">
                                        <div class="row form-group" ng-repeat="field in forms">
                                            <div class="header ml10">
                                                <span><strong>REQUIRED ACCESSORIES </strong></span>
                                                <span class="btn btn-info btn-sm right" ng-click="removeFields(field)">Remove</span>
                                                <span class="btn btn-info btn-sm right mr5" ng-click="addFields(field)">Add</span>
                                            </div>
                                            <div ng-controller="accessorydropCntrl">
                                                <div class="form-group" ng-repeat="(key,type) in field.itemtype">
                                                    <div class="col-sm-9 mb10">
                                                    <label class="selectlabel">Required Accessory</label>
                                                    <select class="form-control testSelAll2 selectdrop" id="measurement_{{key}}" name="acc_code[]" ng-model="acc_code" ng-change="acc_measur_change(key)">
                                                        <option value="" selected="selected">Select Required Accessory</option>
                                                        <option ng-repeat="accessories in firstDrop" data="{{accessories.measure}}" value="{{accessories.alias}}">{{accessories.name}}</option>
                                                    </select>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                            <label for="input_00D" id="qty_measure_{{key}}">Quantity</label>
                                                            <input type="text" ng-model="acc_quantity" valid-input="4" name="acc_quantity[]" class="md-input ng-touched" placeholder="Enter Accessories Quantity">
                                                       </md-input-container>
                                                    </div>
                                                </div>
                                            </div>           
                                        </div>
                                    </div>
                                 </div>
                             </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-6 mb10">
                                    <textarea class="form-control" name="cell_remarks" ng-model="cell_remarks" ng-maxlength="700" placeholder="Enter Remarks"></textarea>
                                     <span class="help-block" ng-show="userForm.cell_remarks.$dirty && userForm.cell_remarks.$invalid">
										<span ng-show="userForm.cell_remarks.$error.maxlength">Should not enter morethan a 700 characters</span>
                                        <span ng-show="userForm.cell_remarks.$error.required">Remarks is Required</span>
                                    </span>
                                </div>
								<div class="col-sm-6 filesRow" ng-controller="fileUploadPrgCtrl">
									 <!--<label class="selectlabel">Mode Of Contact: <span style="color:red;">(Mandatory)</span></label><br /> -->                                                    
									<input value="{{file_name}}" class="form-control uploadFile" placeholder="Upload File" disabled="disabled"/>
									<div class="fileUpload btn btn-sm btn-info" tooltip="Choose File" tooltip-placement="right">
										<span class="ion ion-upload"></span>
										<input type="file" class="upload uploadBtn" name="cust_file" id="cust_file" onchange="angular.element(this).scope().file_load(this.files,'pdf')"/>
									</div>
									<span class="help-block" ng-show="userForm.cust_file.$dirty && userForm.cust_file.$invalid">
										<span ng-show="userForm.cust_file.$error.required">Upload File</span>
									</span>
									<div ng-if="determinateValue >= '100' ? closeloadings() : ''"></div>
									<div class="mb20" ng-if="prg_shw_hde">
									<md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
									</div>
								</div>
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div ng-if="thisValue.value==2">
                                <div class="col-sm-8 col-sm-offset-2 mb10">
                                    <textarea class="form-control" name="remarks" ng-maxlength="700" ng-model="remarks" placeholder="Enter Remarks" required="required"></textarea>
                                     <span class="help-block" ng-show="userForm.remarks.$dirty && userForm.remarks.$invalid">
										<span ng-show="userForm.remarks.$error.maxlength">Should not enter morethan a 700 characters</span>
                                        <span ng-show="userForm.remarks.$error.required">Remarks is Required</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
                 
 <!-- Level 2 to 3 -->
                <div ng-if="singleViews.level_code=='2'">
					<div ng-if="singleViews.onrole">
					 <div class="row form-group" ng-controller="general"> 
                        <div class="row form-group">
                            <div class="col-sm-9 col-sm-offset-1 mb10">
                            <input type="hidden" name="onrole" ng-model="singleViews.onrole" value="{{singleViews.onrole}}" />
                                <select class="form-control testSelAll2 editselectdrop" name="esca_action" ng-model="thisValue" ng-options="opt as opt.label for opt in options" required="required">
                                    <option value="" disabled="disabled">--Select--</option>
                                </select>
                                <span class="help-block" ng-show="userForm.esca_action.$dirty && userForm.esca_action.$invalid">
                                    <span ng-show="userForm.esca_action.$error.required">Select Any One Option</span>
                                </span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div ng-if="thisValue.value==0">
                                 <div class="col-sm-3 col-sm-offset-1" ng-controller="DatepickerDemoCtrl">
                                   <md-input-container flex="" class="md-default-theme">
                                        <label for="input_00D">Plan Date</label>
                                        <input type="text" ng-model="singleViews.planned_date" value="{{singleViews.planned_date}}" name="planned_date" class="datepicker ng-pristine ng-valid md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" is-open="opened" min-date="dt" max-date="'22-06-2025'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" required="required"/>
                                   </md-input-container>
                                     <span class="help-block" ng-show="userForm.planned_date.$dirty && userForm.planned_date.$invalid">
                                        <span ng-show="userForm.planned_date.$error.required">Select Plandate</span>
                                    </span>
                                </div>

								<div class="col-sm-3">
                                <label class="selectlabel">Employee Role</label>
                                    <select class="form-control testSelAll2 selectdrop" name="emp_role" ng-model="emprole" ng-change="dep_drop(emprole,'service_engineer_alias')" ng-init="dep_drop(singleViews.role_alias,'service_engineer_alias')" required>
                                        <option value="" disabled="disabled">Employee Role</option>
                                        <option ng-repeat="role in firstDrop" value="{{role.alias}}" ng-selected="role.alias == singleViews.role_alias">{{role.name}}</option>
                                   </select>
                                     <span class="help-block" ng-show="userForm.emp_role.$dirty && userForm.emp_role.$invalid">
                                        <span ng-show="userForm.emp_role.$error.required">Select Employee Role</span>
                                    </span>
                                </div>
                                <div class="col-sm-3">
                                <label class="selectlabel">Employee Name</label>
                                    <select class="form-control testSelAll2 selectdrop" name="service_engineer_alias" ng-model="service_engineer" required>
                                        <option value="" disabled="disabled">Employee Name</option>
                                        <option ng-repeat="employeelist in secondDrop" value="{{employeelist.alias}}" ng-selected="employeelist.alias == singleViews.service_engineer_alias">{{employeelist.name}}</option>
                                   </select>
                                     <span class="help-block" ng-show="userForm.service_engineer_alias.$dirty && userForm.service_engineer_alias.$invalid">
                                        <span ng-show="userForm.service_engineer_alias.$error.required">Select Employee Name</span>
                                    </span>
                                </div>
								<div class="row form-group">
                                    <div class="col-sm-9 col-sm-offset-1 mb10">
                                        <textarea class="form-control" name="remarks" ng-model="remarks" ng-maxlength="700" placeholder="Enter Remarks" required="required"></textarea>
                                         <span class="help-block" ng-show="userForm.remarks.$dirty && userForm.remarks.$invalid">
											<span ng-show="userForm.remarks.$error.maxlength">Should not enter morethan a 700 characters</span>
                                            <span ng-show="userForm.remarks.$error.required">Remarks is Required</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
						<div ng-if="thisValue.value==1">
                         <div class="row form-group">
                           <div class="col-sm-6 mb10">
                            <div class="panel panel-lined mb20 cells" ng-controller="addFieldsCtrl">
                                <div class="panel-body">
                                    <div class="row form-group" ng-repeat="field in forms" ng-controller="reqCellAccdropCntrl">
                                        <div class="header ml10" ng-init="req_ceh=secondDrop.length>1 ? true : false">
                                            <span><strong>REQUIRED CELLS</strong></span>
                                            <span ng-if="req_ceh" class="btn btn-info btn-sm right" ng-click="removeFields(field)">Remove</span>
                                            <span ng-if="req_ceh" class="btn btn-info btn-sm right mr5" ng-click="addFields(field)">Add</span>
                                        </div>
                                        <div class="form-group" ng-repeat="type in field.itemtype">
                                            <div class="col-sm-9 mb10">
												<md-input-container flex="" ng-if="!req_ceh" class="md-default-theme md-input-has-value">
													<label for="input_00D">REQUIRED CELLS</label>
													<input type="hidden" value="{{secondDrop[0].alias}}" ng-model="secondDrop[0].alias" name="item_code[]"/>
													<input type="text" ng-model="secondDrop[0].name" class="md-input ng-touched" aria-invalid="false" id="input_00D" readonly="readonly"/>
											   </md-input-container>
                                                <label ng-if="req_ceh" class="selectlabel">Required Cell</label>
                                                <select ng-if="req_ceh" class="form-control testSelAll2 selectdrop" name="item_code[]" ng-model="item_code">
                                                    <option value="">Select Required Cell</option>
                                                    <option ng-repeat="itemcode in secondDrop" value="{{itemcode.alias}}">{{itemcode.name}}</option>
                                                </select>
                                             </div>
                                            <div class="col-sm-3">
                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                    <label for="input_00D">Quantity</label>
                                                    <input type="text" ng-model="quantity" valid-input="4" name="quantity[]" class="md-input ng-touched" aria-invalid="false" id="input_00D" placeholder="Enter Cells Quantity"/>
                                               </md-input-container>
                                            </div>
                                        </div>        
                                    </div>
                                </div>
                             </div>
                           </div>
                         <div class="col-sm-6">
                            <div class="panel panel-lined mb20 cells" ng-controller="addFieldsCtrl">
                                <div class="panel-body">
                                    <div class="row form-group" ng-repeat="field in forms" ng-controller="accessorydropCntrl">
                                        <div class="header ml10">
                                            <span><strong>REQUIRED ACCESSORIES </strong></span>
                                            <span class="btn btn-info btn-sm right" ng-click="removeFields(field)">Remove</span>
                                            <span class="btn btn-info btn-sm right mr5" ng-click="addFields(field)">Add</span>
                                        </div>
                                        <div class="form-group" ng-repeat="(key,type) in field.itemtype">
                                            <div class="col-sm-9 mb10">
                                            <label class="selectlabel">Required Accessory</label>
                                            <select class="form-control testSelAll2 selectdrop" id="measurement_{{key}}" name="acc_code[]" ng-model="acc_code" ng-change="acc_measur_change(key)">
                                                <option value="">Select Required Accessory</option>
                                                <option ng-repeat="accessories in firstDrop" data="{{accessories.measure}}" value="{{accessories.alias}}">{{accessories.name}}</option>
                                            </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                    <label for="input_00D" id="qty_measure_{{key}}">Quantity</label>
                                                    <input type="text" ng-model="acc_quantity" valid-input="4" name="acc_quantity[]" class="md-input ng-touched" aria-invalid="false" id="input_00D" placeholder="Enter Accessories Quantity">
                                               </md-input-container>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                         </div>
                 		</div> 
						<div class="row form-group">
						   <div class="col-sm-6 mb10">
								<textarea class="form-control" name="remarks" ng-model="remarks" ng-maxlength="700" placeholder="Enter Remarks"></textarea>
								 <span class="help-block" ng-show="userForm.remarks.$dirty && userForm.remarks.$invalid">
									<span ng-show="userForm.remarks.$error.maxlength">Should not enter morethan a 700 characters</span>
									<span ng-show="userForm.remarks.$error.required">Remarks is Required</span>
								</span>
							</div>
							
							<div class="col-sm-6 filesRow" ng-controller="fileUploadPrgCtrl">
								 <!--<label class="selectlabel">Mode Of Contact: <span style="color:red;">(Mandatory)</span></label><br /> -->                                                    
								<input value="{{file_name}}" class="form-control uploadFile" placeholder="Upload File" disabled="disabled"/>
								<div class="fileUpload btn btn-sm btn-info" tooltip="Choose File" tooltip-placement="right">
									<span class="ion ion-upload"></span>
									<input type="file" class="upload uploadBtn" name="cust_file" id="cust_file" onchange="angular.element(this).scope().file_load(this.files,'pdf')"/>
								</div>
								<span class="help-block" ng-show="userForm.cust_file.$dirty && userForm.cust_file.$invalid">
									<span ng-show="userForm.cust_file.$error.required">Upload File</span>
								</span>
								<div ng-if="determinateValue >= '100' ? closeloadings() : ''"></div>
								<div class="mb20" ng-if="prg_shw_hde">
								<md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
								</div>
							</div>
						</div>
						</div>						

                        <div class="row form-group">
                            <div ng-if="thisValue.value==2">
                                <div class="col-sm-8 col-sm-offset-2 mb10">
                                    <textarea class="form-control" name="remarks" ng-model="remarks" ng-maxlength="700" placeholder="Enter Remarks" required="required"></textarea>
                                     <span class="help-block" ng-show="userForm.remarks.$dirty && userForm.remarks.$invalid">
										<span ng-show="userForm.remarks.$error.maxlength">Should not enter morethan a 700 characters</span>
                                        <span ng-show="userForm.remarks.$error.required">Remarks is Required</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                 </div>
				</div>

                <div ng-if="singleViews.escarole" ng-controller="reqCellAccdropCntrl">
                 <div class="row form-group">
                    <div class="col-sm-4" ng-controller="jobePerformCtrl">
                    	<label class="selectlabel">Job Perform <span style="color:#F00">*</span></label>
                        <select class="form-control testSelAll2 selectdrop" name="job_perform" ng-model="job_perform">
                            <option value="" disabled="disabled">Select Job Perform</option>
                            <option ng-repeat="jobperform in jobperforms" value="{{jobperform.name}}">{{jobperform.name}}</option>
                        </select>
                        <span class="help-block" ng-show="userForm.job_perform.$dirty && userForm.job_perform.$invalid">
                            <span ng-show="userForm.job_perform.$error.required">Select Job Perform</span>
                        </span>
                    </div>
                    <div class="col-sm-4" ng-controller="faultycodedropCntrl">
                        <input type="hidden" name="escarole" ng-model="singleViews.escarole" value="{{singleViews.escarole}}" />
                        <label class="selectlabel">Faulty Code <span style="color:#F00">*</span></label>
                        <select class="form-control testSelAll2 selectdrop" name="faulty_code" ng-model="faulty_code">
                            <option value="" disabled="disabled">Select Faulty Code</option>
                            <option ng-repeat="faulty in firstDrop" value="{{faulty.alias}}">{{faulty.name}}</option>
                        </select>
                        <span class="help-block" ng-show="userForm.faulty_code.$dirty && userForm.faulty_code.$invalid">
                            <span ng-show="userForm.faulty_code.$error.required">Select Faulty Code</span>
                        </span>
                    </div>
                    <div class="col-sm-4" ng-controller="DatepickerDemoCtrl">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">FSR Date <span style="color:#F00">*</span></label>
                            <input type="text" ng-model="fsr_date" name="fsr_date" class="datepicker ng-pristine ng-valid md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" is-open="opened" min-date="singleViews.close_planned_date" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>
                        </md-input-container>
                        <span class="help-block" ng-show="userForm.fsr_date.$dirty && userForm.fsr_date.$invalid">
                            <span ng-show="userForm.fsr_date.$error.required">FSR Date is Required</span>
                        </span>
                    </div>
                  </div>  
                  <div class="row form-group" ng-controller="warrantycalCtrl">
                     <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">FSR Number <span style="color:#F00">*</span></label>
                            <input ng-model="fsr_number" class="ng-pristine ng-valid md-input ng-touched" name="fsr_number">
                        </md-input-container>
                        <span class="help-block" ng-show="userForm.fsr_number.$dirty && userForm.fsr_number.$invalid">
                            <span ng-show="userForm.fsr_number.$error.required">FSR Number is Required</span>
                        </span>
                    </div>
                    <!--<div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00A">Faulty Cell No.</label>
                            <input ng-model="faulty_cell_no" class="ng-pristine ng-valid md-input ng-touched" name="faulty_cell_no" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="userForm.faulty_cell_no.$dirty && userForm.faulty_cell_no.$invalid">
                            <span ng-show="userForm.faulty_cell_no.$error.required">Faulty Cell No is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00A">Replaced Cell Sr. No.</label>

                            <input ng-model="replaced_cell_no" class="ng-pristine ng-valid md-input ng-touched" name="replaced_cell_no" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="userForm.replaced_cell_no.$dirty && userForm.replaced_cell_no.$invalid">
                            <span ng-show="userForm.replaced_cell_no.$error.required">Replaced Cell Sr. No.</span>
                        </span>
                    </div>-->
                  <div ng-controller="DatepickerDemoCtrl">
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Manufactured Date <span style="color:#F00">*</span></label>
                            <input type="text" ng-model="Manufactureddate" name="mfd_date" class="datepicker ng-pristine ng-valid md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="manfdatescal('warr','warr','warr');open($event,'opened1')"/>
                       </md-input-container>
                        <span class="help-block" ng-show="userForm.mfd_date.$dirty && userForm.mfd_date.$invalid">
                            <span ng-show="userForm.mfd_date.$error.required">Manufactured Date is Required</span>
                        </span>
                    </div>	
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00E">Installation Date <span style="color:#F00">*</span></label>
                            <input type="text" ng-model="Installationdate" name="install_date" class="datepicker ng-pristine ng-valid md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="manfdatescal('warr','warr','warr');open($event,'opened2')">
                        </md-input-container>
                        <span class="help-block" ng-show="userForm.install_date.$dirty && userForm.install_date.$invalid">
                            <span ng-show="userForm.install_date.$error.required">Installation Date is Required</span>
                        </span>
                    </div>
                  </div>
                 </div>
                <div class="row form-group">
					<div class="col-sm-4">
						<textarea class="form-control" name="remarks" style="resize:none;" ng-model="remarks" ng-maxlength="700" placeholder="Enter Remarks *"></textarea>
						 <span class="help-block" ng-show="userForm.remarks.$dirty && userForm.remarks.$invalid">
							<span ng-show="userForm.remarks.$error.maxlength">Should not enter morethan a 700 characters</span>
							<span ng-show="userForm.remarks.$error.required">Remarks is Required</span>
						</span>
					</div>
					<div class="col-sm-4">
						<textarea class="form-control" name="action_taken" style="resize:none;" ng-model="actionTaken" placeholder="Enter Action Taken *"></textarea>
						 <span class="help-block" ng-show="userForm.action_taken.$dirty && userForm.action_taken.$invalid">
							<span ng-show="userForm.action_taken.$error.required">Action Taken is Required</span>
						</span>
					</div>
                    <!-- <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Remarks <span style="color:#F00">*</span></label>
                            <input ng-model="remarks" class="ng-pristine ng-valid md-input ng-touched" ng-maxlength="700" name="remarks">
                        </md-input-container>
                        <span class="help-block" ng-show="userForm.remarks.$dirty && userForm.remarks.$invalid">
							<span ng-show="userForm.remarks.$error.maxlength">Should not enter morethan a 700 characters</span>
                            <span ng-show="userForm.remarks.$error.required">Remarks is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Action Taken <span style="color:#F00">*</span></label>
                            <input ng-model="actionTaken" class="ng-pristine ng-valid md-input ng-touched" name="action_taken">
                        </md-input-container>
                        <span class="help-block" ng-show="userForm.action_taken.$dirty && userForm.action_taken.$invalid">
                            <span ng-show="userForm.action_taken.$error.required">Action Taken is Required</span>
                        </span>
                    </div>-->
					
					<div class="col-sm-4 filesRow" ng-controller="fileUploadPrgCtrl">
						 <!--<label class="selectlabel">Mode Of Contact: <span style="color:red;">(Mandatory)</span></label><br /> -->                                                    
						<input value="{{file_name}}" class="form-control uploadFile" placeholder="Upload FSR *" disabled="disabled"/>
						<div class="fileUpload btn btn-sm btn-info" tooltip="Choose FSR" tooltip-placement="right">
							<span class="ion ion-upload"></span>
							<input type="file" class="upload uploadBtn" name="efsr_file" id="efsr_file" onchange="angular.element(this).scope().file_load(this.files,'pdf')"/>
						</div>
                        <span class="help-block" ng-show="userForm.efsr_file.$dirty && userForm.efsr_file.$invalid">
                            <span ng-show="userForm.efsr_file.$error.required">Upload FSR File</span>
                        </span>
						<div ng-if="determinateValue >= '100' ? enablebut() : disablebut()"></div>
						<div class="mb20" ng-if="prg_shw_hde">
						<md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
						</div>
					</div>
                   <!--<div class="col-sm-4">
                        <div class="upload-file">
                            <label class="selectlabel">Choose FSR File</label>
                            <input type="file" name="efsr_file" class="ng-pristine ng-valid md-input ng-touched" id="input_00P" tabindex="0" aria-invalid="false">
                        </div>
                        <span class="help-block" ng-show="userForm.efsr_file.$dirty && userForm.efsr_file.$invalid">
                            <span ng-show="userForm.efsr_file.$error.required">Upload FSR File</span>
                        </span>
                    </div>-->
                </div>
                <div class="row form-group">
                
                <div class="col-sm-6">
					<div class="panel panel-lined mb20 cells" ng-controller="addCellsTktCtrl">
						<div class="panel-body">
							<div class="row form-group">
								<div class="header ml10">
									<span><strong>FAULTY CELLS AVAILABILITY <span style="color:#F00">*</span></strong></span>
								</div>
								<div class="form-group">
									<div class="col-sm-8 ml10 mb25 mt30">
										<select ng-model="faulty_aval" name="faulty_aval" placeholder="Faulty Availability" class="testSelAll2 form-control">
                                            <option value="" disabled="disabled">Select Faulty Availability</option>
											<option value="1">NOT AVAILABLE</option>
											<option value="2">AVAILABLE</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row form-group" ng-repeat="field in forms" ng-if="faulty_aval==2">
								<div class="header ml10">
									<span><strong>FAULTY CELLS <span style="color:#F00">*</span></strong></span>
									<span class="btn btn-info btn-sm right" ng-click="removeFields(field)">Remove</span>
									<span class="btn btn-info btn-sm right mr5" ng-click="addFields(field)">Add</span>
								</div>
								<div style="max-height:400px; overflow:hidden; overflow-y:auto;margin-top:10px;">
									<div class="form-group" ng-repeat="(key,type) in field.itemtype">
										<div class="col-sm-3 ml10 mb10">
											<md-input-container flex="" class="md-default-theme md-input-has-value">
												<label for="input_00D">MFG Date</label>
												<input type="text" ng-model="mfg_date" name="mfg_date[]" minlength="5" maxlength="5" class="ng-pristine ng-valid md-input ng-touched manfVal" aria-invalid="false" id="input_00D" placeholder="Enter MFG date">
										   </md-input-container>
										</div>
										<div class="col-sm-8 ml10 mb10">
											<md-input-container flex="" class="md-default-theme md-input-has-value">
												<label for="input_00D">Faulty Cell No {{key+1}}</label>
												<input type="text" ng-model="faulty_cell_no" name="faulty_cell_no[]" valid-input class="upper ng-pristine ng-valid md-input ng-touched" aria-invalid="false" id="input_00D" placeholder="Enter Faulty Cell No">
										   </md-input-container>
										</div>
									</div>
								</div>           
							</div>
							<strong style="color:#2196f3" ng-if="faulty_aval==1">THERE IS NO FAULTY CELL</strong>
						 </div>
					 </div>
                 </div>
                 
                 <div class="col-sm-6" ng-controller="replacedcellsCntl">
					<div class="panel panel-lined mb20 cells">
						<div class="panel-body">
							<div class="row form-group">
								<div class="header ml10">
									<span><strong>REPLACED CELLS <small style="color:#F00">{{singleViews1.length=='0' ? '(No Replaced Cells)':'*'}}</small></strong></span>
								</div>
								<div class="form-group">
									<div class="col-sm-8 ml10 mb25 mt30">
										<input type="hidden" name="replaced_cell_no[]" value="0" ng-model="replaced_cell_no" ng-disabled="singleViews1.length!='0'" />
										<select multiple="multiple" placeholder="Replaced Cell No" name="replaced_cell_no[]" class="testSelAll3 form-control" ng-disabled="singleViews1.length=='0'" ng-model="replaced_cell_no">
											<option ng-repeat="rep in singleViews1" value="{{rep.alias}}@{{rep.name}}">{{rep.name}}</option>
										</select>
									</div>
								</div>          
							</div>
						 </div>
					 </div>
					 </div>
					<!--<div class="col-sm-6">
						<div class="panel panel-lined mb20 cells">
							<div class="panel-body">
								<div class="header ml10">
									<span><strong>REPLACED CELLS</strong></span>
								</div>
								<div style="max-height:400px; overflow:hidden; overflow-y:auto;margin-top:10px;">
									<div class="form-group">
										<div class="col-sm-8 ml10 mb10">
											<md-input-container flex="" class="md-default-theme md-input-has-value">
													<label for="input_00D">REPLACED CELLS</label>
													<input type="text" ng-model="replaced_cell_no" name="replaced_cell_no" class="md-input ng-touched" aria-invalid="false" id="input_00E" placeholder="Enter Replaced Cells">
										   </md-input-container>
										</div>
									</div>
								</div>   
							 </div>
						 </div>
					 </div>-->
                 </div>
                 <div class="row form-group">
                 <div class="col-sm-6">
                <div class="panel panel-lined mb20 cells" ng-controller="addFieldsCtrl">
                	<div class="panel-body">
                        <div class="row form-group" ng-repeat="field in forms">
                            <div class="header ml10" ng-init="req_ceh=secondDrop.length>1 ? true : false">
								<span><strong>REQUIRED CELLS <span style="color:#F00">*</span></strong></span>
								<span ng-if="req_ceh" class="btn btn-info btn-sm right" ng-disabled="secondDrop.length==1" ng-click="removeFields(field)">Remove</span>
								<span ng-if="req_ceh" class="btn btn-info btn-sm right mr5" ng-disabled="secondDrop.length==1" ng-click="addFields(field)">Add</span>
                            </div>
							<div class="form-group" ng-repeat="type in field.itemtype">
								<div class="col-sm-6 mt30">
										<md-input-container flex="" ng-if="!req_ceh" class="md-default-theme md-input-has-value">
											<input type="hidden" value="{{secondDrop[0].alias}}" ng-model="secondDrop[0].alias" name="item_code[]"/>
											<input type="text" ng-model="secondDrop[0].name" class="md-input ng-touched" aria-invalid="false" id="input_00D" readonly="readonly"/>
									   </md-input-container>
									<select ng-if="req_ceh" class="form-control testSelAll2 selectdrop" name="item_code[]" ng-model="item_code">
										<option value="" disabled="disabled">Select Required Cell</option>
										<option ng-repeat="itemcode in secondDrop" value="{{itemcode.alias}}" ng-selected="true">{{itemcode.name}}</option>
									</select>
									 <span ng-if="req_ceh" class="help-block" ng-show="userForm['item_code[]'].$dirty && userForm['item_code[]'].$invalid">
										<span ng-show="userForm['item_code[]'].$error.required">Select Required Cells</span>
									</span>
								</div>
								<div class="col-sm-6">
									<md-input-container flex="" class="md-default-theme md-input-has-value">
										<label for="input_00D">Quantity</label>
										<input type="text" ng-model="quantity" valid-input="4" name="quantity[]" class="ng-pristine ng-valid md-input ng-touched" aria-invalid="false" id="input_00D" placeholder="Enter Quantity"/>
								   </md-input-container>
									 <span class="help-block" ng-show="userForm['quantity[]'].$dirty && userForm['quantity[]'].$invalid">
										<span ng-show="userForm['quantity[]'].$error.required">Qunatity is Required</span>
									</span>
								</div>
							</div>          
                        </div>
                    </div>
                 </div>
                 </div>
                 <div class="col-sm-6">
                <div class="panel panel-lined mb20 cells" ng-controller="addFieldsCtrl">
                	<div class="panel-body">
                        <div class="row form-group" ng-repeat="field in forms">
                            <div class="header ml10">
								<span><strong>REQUIRED ACCESSORIES </strong></span>
								<span class="btn btn-info btn-sm right" ng-click="removeFields(field)">Remove</span>
								<span class="btn btn-info btn-sm right mr5" ng-click="addFields(field)">Add</span>
                            </div>
                            <div ng-controller="accessorydropCntrl">
                                <div class="form-group" ng-repeat="(key,type) in field.itemtype">
                                    <div class="col-sm-6 mt30">
                                        <select class="form-control testSelAll2 selectdrop" id="measurement_{{key}}" name="acc_code[]" ng-model="acc_code" ng-change="acc_measur_change(key)">
                                            <option value="" disabled="disabled">Select Required Accessory</option>
                                            <option ng-repeat="accessories in firstDrop" data="{{accessories.measure}}" value="{{accessories.alias}}">{{accessories.name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                            <label for="input_00D" id="qty_measure_{{key}}">Quantity</label>
                                            <input type="text" ng-model="acc_quantity" valid-input="4" name="acc_quantity[]" class="ng-pristine ng-valid md-input ng-touched" aria-invalid="false" id="input_00D" placeholder="Enter Quantity">
                                       </md-input-container>
                                    </div>
                                </div>
                            </div>           
                        </div>
                    </div>
                 </div>
                 </div>
                 </div>
                 
			</div>
		</div>
 
 <!-- Level 3 to 4 -->
 
                   <div ng-if="singleViews.level_code=='3'">
						<div class="row form-group">
						   <div class="col-sm-6 mb10">
							<div class="panel panel-lined mb20 cells" ng-controller="addFieldsCtrl">
								<div class="panel-body">
									<div class="row form-group" ng-repeat="field in forms" ng-controller="reqCellAccdropCntrl">
										<div class="header ml10" ng-init="req_ceh=secondDrop.length>1 ? true : false">
											<span><strong>REQUIRED CELLS (OPTIONAL)</strong></span>
											<span ng-if="req_ceh" class="btn btn-info btn-sm right" ng-click="removeFields(field)">Remove</span>
											<span ng-if="req_ceh" class="btn btn-info btn-sm right mr5" ng-click="addFields(field)">Add</span>
										</div>
										<div>
											<div class="form-group" ng-repeat="type in field.itemtype">
												<div class="col-sm-9 mb10">
													<md-input-container flex="" ng-if="!req_ceh" class="md-default-theme md-input-has-value">
														<label for="input_00D">REQUIRED CELLS</label>
														<input type="hidden" value="{{secondDrop[0].alias}}" ng-model="secondDrop[0].alias" name="item_code[]"/>
														<input type="text" ng-model="secondDrop[0].name" class="md-input ng-touched" aria-invalid="false" id="input_00D" readonly="readonly"/>
												   </md-input-container>
													<label ng-if="req_ceh" class="selectlabel">Required Cell</label>
													<select ng-if="req_ceh" class="form-control testSelAll2 selectdrop" name="item_code[]" ng-model="item_code">
														<option value="" selected="selected">Select Required Cell</option>
														<option ng-repeat="itemcode in firstDrop" value="{{itemcode.alias}}">{{itemcode.name}}</option>
													</select>
												 </div>
												<div class="col-sm-3">
													<md-input-container flex="" class="md-default-theme md-input-has-value">
														<label for="input_00D">Quantity</label>
														<input type="text" ng-model="quantity" valid-input="4" name="quantity[]" class="md-input ng-touched" aria-invalid="false" id="input_00D" placeholder="Enter Cells Quantity"/>
												   </md-input-container>
												</div>
											</div>
										</div>           
									</div>
								</div>
							 </div>
						   </div>
						 <div class="col-sm-6">
							<div class="panel panel-lined mb20 cells" ng-controller="addFieldsCtrl">
								<div class="panel-body">
									<div class="row form-group" ng-repeat="field in forms">
										<div class="header ml10">
											<span><strong>REQUIRED ACCESSORIES (OPTIONAL) </strong></span>
											<span class="btn btn-info btn-sm right" ng-click="removeFields(field)">Remove</span>
											<span class="btn btn-info btn-sm right mr5" ng-click="addFields(field)">Add</span>
										</div>
										<div ng-controller="accessorydropCntrl">
											<div class="form-group" ng-repeat="(key,type) in field.itemtype">
												<div class="col-sm-9 mb10">
												<label class="selectlabel">Required Accessory</label>
												<select class="form-control testSelAll2 selectdrop" id="measurement_{{key}}" name="acc_code[]" ng-model="acc_code" ng-change="acc_measur_change(key)">
													<option value="" selected="selected">Select Required Accessory</option>
													<option ng-repeat="accessories in firstDrop" data="{{accessories.measure}}" value="{{accessories.alias}}">{{accessories.name}}</option>
												</select>
												</div>
												<div class="col-sm-3">
													<md-input-container flex="" class="md-default-theme md-input-has-value">
														<label for="input_00D" id="qty_measure_{{key}}">Quantity</label>
														<input type="text" ng-model="acc_quantity" valid-input="4" name="acc_quantity[]" class="md-input ng-touched" placeholder="Enter Accessories Quantity">
												   </md-input-container>
												</div>
											</div>
										</div>           
									</div>
								</div>
							 </div>
						 </div>
						</div>				
                       <div class="row form-group">
							<div class="col-sm-4" ng-controller="milestoneDropCtrl">
								<label class="selectlabel">Mile Stone</label>
								<select class="form-control testSelAll2 selectdrop" name="milestone" ng-model="milestone">
									<option value="" disabled="disabled">Select Mile Stone</option>
									<option ng-repeat="mile in firstDrop" value="{{mile.alias}}">{{mile.name}}</option>
								</select>
								 <span class="help-block" ng-show="userForm.milestone.$dirty && userForm.milestone.$invalid">
									<span ng-show="userForm.milestone.$error.required">Select Milestone</span>
								</span>
							</div>
							<div class="col-sm-4" ng-controller="paymentCtrl">
								<label class="selectlabel">eFSR Efficiency</label>
								<select class="form-control testSelAll2 selectdrop" name="payment_terms" ng-model="paymentterm">
									<option value="" disabled="disabled">Select eFSR Efficiency</option>
									<option ng-repeat="payment in paymentterms" value="{{payment.name}}">{{payment.name}}</option>
								</select>
								 <span class="help-block" ng-show="userForm.payment_terms.$dirty && userForm.payment_terms.$invalid">
									<span ng-show="userForm.payment_terms.$error.required">Select eFSR Efficiency</span>
								</span>
							</div>
							<div class="col-sm-4" ng-controller="zonalactionCtrl">
							 <label class="selectlabel">Action</label>
								<select class="form-control testSelAll2 selectdrop" name="zonal_action" ng-model="zonalaction">
									<option value="" disabled="disabled">Select Action</option>
									<option ng-repeat="zonal in zonalactions" value="{{zonal.id}}">{{zonal.name}}</option>
								</select>
								 <span class="help-block" ng-show="userForm.zonal_action.$dirty && userForm.zonal_action.$invalid">
									<span ng-show="userForm.zonal_action.$error.required">Select Action</span>
								</span>
							</div>
						</div>
                       <div class="row form-group">
							<div class="col-sm-6 mb10">
								<textarea class="form-control" name="remarks" ng-model="remarks" ng-maxlength="700" placeholder="Enter Remarks"></textarea>
								 <span class="help-block" ng-show="userForm.remarks.$dirty && userForm.remarks.$invalid">
									<span ng-show="userForm.remarks.$error.maxlength">Should not enter morethan a 700 characters</span>
									<span ng-show="userForm.remarks.$error.required">Remarks is Required</span>
								</span>
							</div>
							<div class="col-sm-6 filesRow" ng-controller="fileUploadPrgCtrl">
								 <!--<label class="selectlabel">Mode Of Contact: <span style="color:red;">(Mandatory)</span></label><br /> -->                                                    
								<input value="{{file_name}}" class="form-control uploadFile" placeholder="Upload File" disabled="disabled"/>
								<div class="fileUpload btn btn-sm btn-info" tooltip="Choose File" tooltip-placement="right">
									<span class="ion ion-upload"></span>
									<input type="file" class="upload uploadBtn" name="cust_file" id="cust_file" onchange="angular.element(this).scope().file_load(this.files,'pdf')"/>
								</div>
								<span class="help-block" ng-show="userForm.cust_file.$dirty && userForm.cust_file.$invalid">
									<span ng-show="userForm.cust_file.$error.required">Upload File</span>
								</span>
								<div ng-if="determinateValue >= '100' ? closeloadings() : ''"></div>
								<div class="mb20" ng-if="prg_shw_hde">
								<md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
								</div>
							</div>
						</div>
                  </div>
                  
 <!-- Level 4 to 5 -->
                   <div class="row form-group">   
                        <div ng-if="singleViews.level_code=='4'">
                            <div class="col-sm-5 col-sm-offset-1" ng-controller="NHSactionCtrl">
                                <label class="selectlabel">Action</label>
                                <select class="form-control testSelAll2 selectdrop" name="nhs_action" ng-model="nhsaction" required="required">
                                    <option value="" disabled="disabled">Select Action</option>
                                    <option ng-repeat="nhs in nhsactions" value="{{nhs.id}}">{{nhs.name}}</option>
                                </select>
                                 <span class="help-block" ng-show="userForm.nhs_action.$dirty && userForm.nhs_action.$invalid">
                                    <span ng-show="userForm.nhs_action.$error.required">Select Action</span>
                                </span>
                            </div>
                            <div class="col-sm-5">
                                <textarea class="form-control" name="remarks" ng-model="remarks" ng-maxlength="700" placeholder="Enter Remarks" required="required"></textarea>
                                 <span class="help-block" ng-show="userForm.remarks.$dirty && userForm.remarks.$invalid">
									<span ng-show="userForm.remarks.$error.maxlength">Should not enter morethan a 700 characters</span>
                                    <span ng-show="userForm.remarks.$error.required">Select Action</span>
                                </span>
                            </div>
                        </div>
                   </div>
 <!-- Level 8 to 5 -->
 				<div class="row form-group mt10"> 
                    <div ng-if="singleViews.level_code=='8'" class="ml10">
                        <!--<div class="panel panel-lined cells">
                            <div class="panel-body">-->
                                <div class="row form-group" ng-if="singleViews.old_level_code=='1'">
                                    <div class="col-sm-5 col-sm-offset-1 mb30">
                                        <label class="selectlabel blue_place">TS Action</label>
                                        <select class="form-control testSelAll2 editselectdrop" name="ths_action" ng-model="ths_action">
                                            <option value="">--Select--</option>
                                            <option value="3">Approve Stock</option>
                                            <option value="4">Reject Stock</option>
                                        </select>
                                        <span class="help-block" ng-show="userForm.ths_action.$dirty && userForm.ths_action.$invalid">
                                            <span ng-show="userForm.ths_action.$error.required">Select TS Action</span>
                                        </span>
                                    </div>
                                    <div class="col-sm-5 mb30">
                                        <textarea class="form-control" name="remarks" style="resize:none" ng-maxlength="700" ng-model="remarks" placeholder="Enter Remarks"></textarea>
                                         <span class="help-block" ng-show="userForm.remarks.$dirty && userForm.remarks.$invalid">
											<span ng-show="userForm.remarks.$error.maxlength">Should not enter morethan a 700 characters</span>
                                            <span ng-show="userForm.remarks.$error.required">Remarks is Required</span>
                                        </span>
                                    </div>
                                </div>
                                
                                <div ng-if="singleViews.old_level_code=='4'">
                                    <div class="row form-group">
                                        <div class="col-sm-4 col-sm-offset-4 mb30">
                                            <label class="selectlabel blue_place">TS Action</label>
                                            <select class="form-control testSelAll2 editselectdrop" name="ths_action" ng-model="ths_action" required="required">
                                                <option value="">Select TS Action</option>
                                                <option value="1">Approve</option>
                                                <option value="2">Reject</option>
                                            </select>
                                            <span class="help-block" ng-show="userForm.ths_action.$dirty && userForm.ths_action.$invalid">
                                                <span ng-show="userForm.ths_action.$error.required">Select TS Action</span>
                                            </span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="cell_type_chk" ng-if="ths_action=='1' && singleViews.cell_type" value="1" ng-model="singleViews.cell_type"/>
                                    <input type="hidden" name="cell_type_chk" ng-if="ths_action=='1' && !singleViews.cell_type" value="2" ng-model="singleViews.cell_type"/>
                                    <div ng-if="ths_action=='1' && singleViews.cell_type">
                                        <div class="row form-group">
                                           <div class="col-sm-11 mb10 ml20">
												<div class="row form-group">
                                                    <div class="col-sm-4">
                                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                            <label for="input_00D">Line Number</label>
                                                            <input type="text" ng-model="line_number" ng-pattern-restrict="^[a-zA-Z0-9_]*$" maxlength="5" name="line_number" class="reg_check ng-pristine ng-valid md-input ng-touched" aria-invalid="false" id="input_00D" placeholder="Enter Line Number"/>
                                                       </md-input-container>
                                                        <span class="help-block" ng-show="userForm.line_number.$dirty && userForm.line_number.$invalid">
                                                            <!--<span ng-show="userForm.line_number.$error.pattern"> ng-pattern="/^(?=.)([+-]?([0-9]*)(\.([0-9]+))?)$/" Line Number should Digits Only</span>-->
                                                        </span>
                                                    </div>
                                                    <div class="col-sm-4" ng-controller="selectShiftCntrl">
                                                        <label class="selectlabel">Shift</label>
                                                        <select class="form-control testSelAll2 selectdrop" name="shift" ng-model="shift">
                                                            <option value="" selected="selected">Select Shift</option>
                                                            <option value="{{shift.alias}}" ng-repeat="shift in firstDrop">{{shift.name}}</option>
                                                        </select>
                                                     </div>
                                                    <div class="col-sm-4" ng-init="ths_notified_emp();">
                                                        <label class="selectlabel">Persons Notified</label>
                                                        <select class="form-control testSelAll3 selectdrop" name="persons_notified[]" multiple="multiple" ng-model="persons_notified">
									                        <option value="{{emp.alias}}" ng-repeat="emp in firstDrop">{{emp.name}}</option>
                                                        </select>
                                                     </div>
                                                  </div>
												<div class="row form-group">
                                                     <div ng-controller="DatepickerDemoCtrl">
                                                         <div class="col-sm-4">
                                                           <md-input-container flex="" class="md-default-theme">
                                                               <label for="input_00D">Date Of Assembly</label>
                                                               <input type="text" ng-model="date_of_assembly" name="date_of_assembly" class="datepicker ng-pristine ng-valid md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="pr" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="assem_jar('date_of_jar_form');open($event,'opened1')"/>
                                                           </md-input-container>
                                                             <span class="help-block" ng-show="userForm.date_of_assembly.$dirty && userForm.date_of_assembly.$invalid">
                                                                <span ng-show="userForm.date_of_assembly.$error.required">Select Date of Assembly</span>
                                                            </span>
                                                        </div>
                                                        
                                                         <div class="col-sm-4">
                                                           <md-input-container flex="" class="md-default-theme">
                                                               <label for="input_00D">Date Of Jar formation</label>
                                                               <input type="text" ng-model="date_of_jar_form" name="date_of_jar_form" class="datepicker ng-pristine ng-valid md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="assem_jar('date_of_assembly');open($event,'opened2')">
                                                           </md-input-container>
                                                             <span class="help-block" ng-show="userForm.date_of_jar_form.$dirty && userForm.date_of_jar_form.$invalid">
                                                                <span ng-show="userForm.date_of_jar_form.$error.required">Select Date of Assembly</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
														<span style="float:right;cursor: pointer" class="fa fa-info-circle" tooltip-placement="top" tooltip="Has a plan been developed that includes specific milestones and people responsible for implementation? Have error proofing techniques, preventive measures and/or visual aids been considered?"></span>
                                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                            <label for="input_00D">Corrective Actions Planned</label>
                                                            <input type="text" ng-model="corect_act_Plan" name="corect_act_Plan" class="md-input ng-touched" aria-invalid="false" id="input_00D" placeholder="Enter Corrective Actions Planned"/>
                                                       </md-input-container>
                                                    </div>
                                                  </div>
												<div class="row form-group">
													<div class="col-sm-4">
														<span style="float:right;cursor: pointer;margin-bottom:-17px;z-index:900;position: relative" class="fa fa-info-circle" tooltip-placement="top" tooltip="Define how this was determined and proven"></span>
														<textarea class="form-control" name="remarks" style="resize:none" ng-model="remarks" placeholder="Root Cause of nonconformity"></textarea>
														 <span class="help-block" ng-show="userForm.remarks.$dirty && userForm.remarks.$invalid">
															<span ng-show="userForm.remarks.$error.required">Root Cause of nonconformity is Required</span>
														</span>
													</div>
													<div class="col-sm-4">
														<label class="selectlabel">Deposition</label>
														<span style="float:right;cursor: pointer;" class="fa fa-info-circle" tooltip-placement="top" tooltip="Was the corrective action taken completed?"></span>
														<select class="form-control testSelAll2 selectdrop" name="deposition" ng-model="deposition">
                                                            <option value="" selected="selected">Select Deposition</option>
															<option value="OPEN">OPEN</option>
															<option value="CLOSE">CLOSE</option>
															<option value="REJECT">REJECT</option>
														</select>
													 </div>
													<div class="col-sm-4 mb20" ng-if="deposition=='CLOSE' || deposition=='REJECT'">
														<span style="float:right;cursor: pointer;margin-bottom:-17px;z-index:1000;position: relative;" class="fa fa-info-circle" tooltip-placement="top" tooltip="Have you investigated whether similar nonconformance could be produced in other products, operational processes or locations? Have changes been made that will prevent similar nonconformance from occurring?"></span>
														<textarea class="form-control" name="prevent_recurrence" style="resize:none" ng-model="prevent_recurrence" placeholder="Prevent recurrence"></textarea>
														 <span class="help-block" ng-show="userForm.prevent_recurrence.$dirty && userForm.prevent_recurrence.$invalid">
															<span ng-show="userForm.prevent_recurrence.$error.required">Prevent recurrence is Required</span>
														</span>
													</div>
                                                  </div>
												<div class="row form-group">
                                                    <div class="row form-group">
                                                        <div class="col-sm-12">
                                                            <div class="panel panel-lined cells" ng-controller="addFieldsCtrl1" ng-if="singleViews.se_eng.length == 0">
                                                                <div class="panel-body" ng-repeat="field in forms">
                                                                <div style="max-height:450px; overflow:auto; overflow-x:hidden;">
                                                                    <div class="header"><strong>10th Hour Reading</strong>
                                                                        <!--<span class="btn btn-info btn-sm right mr10" ng-click="removeFields(field)" ng-disabled="singleViews.se_eng.length <= len">Remove</span>-->
                                                                        <span class="btn btn-info btn-sm right mr5" ng-click="addFields(field)">Add</span>
                                                                     </div>
                                                                    <div class="form-group" ng-repeat="(key,type) in field.itemtype">
                                                                        <div class="mt5">
                                                                            <div class="col-sm-4">
                                                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                                                    <label for="input_00D">Faulty Cell Number {{key+1}}</label>
                                                                                    <input type="text" ng-model="faulty_cell_num" valid-input name="faulty_cell_num[]" class="upper md-input ng-touched" aria-invalid="false" id="input_00D" placeholder="Enter Faulty Cell Number"/>
                                                                               </md-input-container>
                                                                                <span class="help-block" ng-show="userForm['faulty_cell_num[]'].$dirty && userForm['faulty_cell_num[]'].$invalid">
                                                                                    <span ng-show="userForm['faulty_cell_num[]'].$error.minlength">Cell no have minimum  7 characters</span>
                                                                                </span>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                                                    <label for="input_00D">OCV at Dispatch</label>
                                                                                    <input type="text" ng-model="ocv_at_dispatch" name="ocv_at_dispatch[]" class="md-input ng-touched voltVal" aria-invalid="false" id="input_00D" placeholder="Enter OCV at Dispatch"/>
                                                                               </md-input-container>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                                                    <label for="input_00D">10th Hour Reading</label>
                                                                                    <input type="text" ng-model="tenth_hour" name="tenth_hour[]" class="md-input ng-touched voltVal" aria-invalid="false" id="input_00D" placeholder="Enter 10th Hour Reading"/>
                                                                               </md-input-container>
                                                                            </div>
                                                                            <div class="col-sm-1">
																				<span class="btn btn-info btn-sm mt30 ml5" ng-click="removeFields(field,key)">Remove</span>
																			</div>
																			<!--<div ng-if="key%2==1" style="border-left:1px solid #428bca; margin-left:50% !important;height:80px !important;"></div>-->
                                                                        </div>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div>
															
															<div class="panel panel-lined cells" ng-controller="addFieldsCtrl1" ng-if="singleViews.se_eng.length > 0">
                                                                <div class="panel-body" ng-repeat="field in forms" ng-init="field.itemtype=singleViews.se_eng;len=singleViews.se_eng.length;">
                                                                <div style="max-height:450px; overflow:auto; overflow-x:hidden;">
                                                                    <div class="header"><strong>10th Hour Reading</strong>
                                                                        <!--<span class="btn btn-info btn-sm right mr10" ng-click="removeFields(field)" ng-disabled="singleViews.se_eng.length <= len">Remove</span>-->
                                                                        <span class="btn btn-info btn-sm right mr5" ng-click="addFields(field)">Add</span>
                                                                     </div>
                                                                    <div class="form-group" ng-repeat="(key,type) in field.itemtype">
                                                                        <div class="mt5">
                                                                            <div class="col-sm-4" ng-init="mod=(len > key && type!='[object Object]') ? type : type.faulty_cell_sr_no">
                                                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                                                    <label for="input_00D">Faulty Cell Number {{key+1}}</label>
                                                                                    <input type="text" ng-model="mod" name="faulty_cell_num[]" ng-readonly="key<=len-1" valid-input class="upper md-input ng-touched" aria-invalid="false" id="input_00D" placeholder="Enter Faulty Cell Number"/>
                                                                               </md-input-container>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                                                    <label for="input_00D">OCV at Dispatch</label>
                                                                                    <input type="text" ng-model="ocv_at_dispatch" name="ocv_at_dispatch[]" class="md-input ng-touched voltVal" aria-invalid="false" id="input_00D" placeholder="Enter OCV at Dispatch"/>
                                                                               </md-input-container>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                                                    <label for="input_00D">10th Hour Reading</label>
                                                                                    <input type="text" ng-model="tenth_hour" name="tenth_hour[]" class="md-input ng-touched voltVal" aria-invalid="false" id="input_00D" placeholder="Enter 10th Hour Reading"/>
                                                                               </md-input-container>
                                                                            </div>
                                                                            <div class="col-sm-1">
																				<span class="btn btn-info btn-sm mt30 ml5" ng-click="removeFields(field,key)">Remove</span>
																			</div>
																			<!--<div ng-if="key%2==1" style="border-left:1px solid #428bca; margin-left:50% !important;height:80px !important;"></div>-->
                                                                        </div>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row form-group" ng-if="ths_action=='2' || (ths_action=='1' && !singleViews.cell_type)">
                                        <div class="col-sm-12 mb10">
                                            <textarea class="form-control" name="remarks" style="resize:none" ng-maxlength="700" ng-model="remarks" placeholder="Enter Remarks"></textarea>
                                             <span class="help-block" ng-show="userForm.remarks.$dirty && userForm.remarks.$invalid">
												<span ng-show="userForm.remarks.$error.maxlength">Should not enter morethan a 700 characters</span>
                                                <span ng-show="userForm.remarks.$error.required">Remarks is Required</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <!--</div>
                         </div>-->
                    </div>
                </div>
                 
                    <div class="row form-group"> 
                        <div ng-if="(singleViews.level_code=='5' && singleViews.old_level_code=='8') || singleViews.deposition_edit">
							<div class="row form-group mt10"> 
								<div class="ml10">
									<!--<div class="panel panel-lined cells">
										<div class="panel-body">-->
											<div class="row form-group">
											   <div class="col-sm-11 mb10 ml20">
													<div class="row form-group">
														<div class="col-sm-6">
															<label class="selectlabel">Deposition</label>
															<span style="float:right;cursor: pointer;" class="fa fa-info-circle" tooltip-placement="top" tooltip="Was the corrective action taken completed?"></span>
															<select class="form-control testSelAll2 selectdrop" name="deposition" ng-model="deposition">
																<option value="" selected="selected">Select Deposition</option>
																<option value="CLOSE">CLOSE</option>
																<option value="REJECT">REJECT</option>
															</select>
														 </div>
														<div class="col-sm-6 mb20">
															<span style="float:right;cursor: pointer;margin-bottom:-17px;z-index:1000;position: relative;" class="fa fa-info-circle" tooltip-placement="top" tooltip="Have you investigated whether similar nonconformance could be produced in other products, operational processes or locations? Have changes been made that will prevent similar nonconformance from occurring?"></span>
															<textarea class="form-control" name="prevent_recurrence" style="resize:none" ng-model="prevent_recurrence" placeholder="Prevent recurrence"></textarea>
															 <span class="help-block" ng-show="userForm.prevent_recurrence.$dirty && userForm.prevent_recurrence.$invalid">
																<span ng-show="userForm.prevent_recurrence.$error.required">Prevent recurrence is Required</span>
															</span>
														</div>
													  </div>
											   </div>
											</div>
										<!--</div>
									 </div>-->
								</div>
							</div>
                        </div>
                    </div>
                     <div class="row form-group"> 
                        <div ng-if="singleViews.level_code=='6'">
                        </div>
                     </div>
                      <div class="row form-group"> 
                        <div ng-if="singleViews.level_code=='7'">
                        </div>
                	</div>
				<div class="row form-group"><br/>
					<div class="col-sm-6 col-sm-offset-5">
						<button type="submit" click-once class="btn btn-info btn-sm" 
                        ng-disabled="userForm.general.$dirty && userForm.general.$invalid ||
                        userForm.online_tickets.$dirty && userForm.online_tickets.$invalid ||
                        userForm.planned_date.$dirty && userForm.planned_date.$invalid ||
                        userForm.service_engineer_alias.$dirty && userForm.service_engineer_alias.$invalid ||
                        userForm.cell_alias.$dirty && userForm.cell_alias.$invalid ||
                        userForm['item_code[]'].$dirty && userForm['item_code[]'].$invalid ||
                        userForm['quantity[]'].$dirty && userForm['quantity[]'].$invalid ||
                        userForm.cell_remarks.$dirty && userForm.cell_remarks.$invalid ||
                        userForm.remarks.$dirty && userForm.remarks.$invalid ||
                        userForm.milestone.$dirty && userForm.milestone.$invalid ||
                        userForm.payment_terms.$dirty && userForm.payment_terms.$invalid ||
                        userForm.zonal_action.$dirty && userForm.zonal_action.$invalid ||
                        userForm.nhs_action.$dirty && userForm.nhs_action.$invalid ||
                        userForm.faulty_code.$dirty && userForm.faulty_code.$invalid ||
                        userForm['faulty_cell_no[]'].$dirty && userForm['faulty_cell_no[]'].$invalid ||
                        userForm.action_taken.$dirty && userForm.action_taken.$invalid ||
                        userForm.fsr_number.$dirty && userForm.fsr_number.$invalid ||
                        userForm.fsr_date.$dirty && userForm.fsr_date.$invalid || 
                        userForm.mfd_date.$dirty && userForm.mfd_date.$invalid ||
                        userForm.install_date.$dirty && userForm.install_date.$invalid ||
                        userForm.closing_date.$dirty && userForm.closing_date.$invalid ||
                        userForm.job_perform.$dirty && userForm.job_perform.$invalid ||
                        userForm.efsr_file.$dirty && userForm.efsr_file.$invalid">Submit</button>
                        <button type="reset" class="btn btn-info btn-sm" ng-click="userForm.$setPristine(); userForm.$setUntouched();">Reset</button>
					</div>
				</div>
		</form>
	</div>
</div>
<script>
$(document).ready(function(){
	$(document).on('keypress','.voltVal',function (e){
		if(isNaN($(this).val())){
			$(this).val("");
		}else{
			var valint=$(this).val();
				if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) { return false;	}
				else{if(valint.length==1)valint=valint+'.';}
			if(valint.length>3)return false;
			else $(this).val(valint);
			
		}
	});
	$(document).on('keypress','.numeric_valid',function (e){
		if(isNaN($(this).val()))$(this).val("");
		else{
			if(e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))return false;
		}
	});
	$(document).on('keyup','.manfVal',function (e){
		var valint=$(this).val();
		if(e.keyCode!=8){
			var len=valint.length;
			if(len<6){
				if(1){
					if(len<3){
						if(valint<=12){
							if(len==1 && valint>1)$(this).val('');
							else if(len==2){
								if(valint!=0){
									valint=valint+'/';
									$(this).val(valint);
								}else $(this).val('');
							}
						}else $(this).val('');
					}else if(len<6){
						var year = valint.split("/");
						var yr = year[year.length-1];
						var c_yr = <?php echo date('y'); ?>;
						if((yr>2 && len==4)||(yr==0 && len==5))$(this).val(valint.replace(yr,""));
						else{
							if(yr<=c_yr){
								if(yr==c_yr){
									var c_mn = <?php echo date('m'); ?>;
									if(c_mn<year[0])$(this).val(valint.replace(yr,""));
								}
							}else $(this).val(valint.replace(yr,""));
						}
					}else $(this).val('');// return false;
				}else $(this).val('');// return false;
			}else $(this).val('');// return false;
		}
	});
	setInterval(function(){
		$('.testSelAll2').SumoSelect();
		$('.forms_add').find('.SumoSelect').addClass('singleSelect');
	},0);
});
</script>