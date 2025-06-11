<style>
.form-group {margin-bottom:0px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.upload-file{border-bottom: 1px solid rgba(0,0,0,0.12); padding-top:9px;}
select .form-control:{height:68px !important;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
</style>
<div class="modal-style" ng-controller="ticketAdvEditCntl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Advance Ticket Edit</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
		<form class="form-horizontal forms_add" reset-directive="singleViews" name="userForm" data-went="#/tickets" method="post" url="services/tickets/ticket_adv_update" ng-submit="sendPost()" enctype="multipart/form-data" novalidate>
            <input type="hidden" value="{{singleViews.ticket_alias}}" name="ticket_alias"/>
            <div class="row form-group">
                <div class="col-sm-4">
                    <md-input-container flex="" class="md-default-theme">
                        <label for="input_00D">Ticket Number</label>
                        <input ng-model="singleViews.ticket_id" value="{{singleViews.ticket_id}}" name="ticket_id" class="md-input ng-touched" id="ae_ticket_id" tabindex="0">
                    </md-input-container>
                </div>
                <div class="col-sm-4" ng-controller="DatepickerDemoCtrl">
               	 	<md-input-container flex="" class="md-default-theme">
                        <label for="input_00D">Login Date</label>
                        <input ng-model="singleViews.login_date" value="{{singleViews.login_date}}" name="login_date" class="datepicker md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" is-open="opened" min-date="dt" max-date="'22-06-2025'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>
                    </md-input-container>
                </div>
                <div class="col-sm-4" ng-controller="DatepickerDemoCtrl">
               	 	<md-input-container flex="" class="md-default-theme">
                        <label for="input_00D">Activation Date</label>
                        <input ng-model="singleViews.activation_date" value="{{singleViews.activation_date}}" name="activation_date" class="datepicker md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" is-open="opened" min-date="dt" max-date="'22-06-2025'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>
                    </md-input-container>
                </div>
              </div>
              
              <div class="row form-group">
                 <div class="col-sm-4" ng-controller="DatepickerDemoCtrl">
                   <md-input-container flex="" class="md-default-theme">
                        <label for="input_00D">Plan Date</label>
                        <input ng-model="singleViews.planned_date" value="{{singleViews.planned_date}}" name="planned_date" class="datepicker md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" is-open="opened" min-date="dt" max-date="'22-06-2025'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>
                   </md-input-container>
                </div>

                <div class="col-sm-4">
                	<label class="selectlabel">Engineer Role</label>
                    <select class="form-control testSelAll2 selectdrop" name="emp_role" ng-model="emprole" ng-change="dep_drop(emprole,'service_engineer_alias')" ng-init="dep_drop(singleViews.role_alias,'service_engineer_alias')">
                        <option value="">Service Engineer Role</option>
                        <option ng-repeat="role in firstDrop" value="{{role.alias}}" ng-selected="role.alias == singleViews.role_alias">{{role.name}}</option>
                   </select>
                </div>
                <div class="col-sm-4">
                <label class="selectlabel">Engineer Name</label>
                    <select class="form-control testSelAll2 selectdrop" name="service_engineer_alias" ng-model="service_engineer">
                        <option value="">Service Engineer Name</option>
                        <option ng-repeat="employeelist in secondDrop" value="{{employeelist.alias}}" ng-selected="employeelist.alias == singleViews.service_engineer_alias">{{employeelist.name}}</option>
                   </select>
                </div>
               </div>
               
               
            <div class="row form-group" ng-controller="activityComplaintCntrl">
                <div class="col-sm-4">
                    <md-input-container flex="" class="md-default-theme">
                        <label for="site_id">Site ID</label>
                        <input ng-model="singleViews.site_id" value="{{singleViews.site_id}}" name="site_id" class="md-input ng-touched" id="ae_site_id" tabindex="0" readonly="readonly">
                    </md-input-container>
                </div>
                <div class="col-sm-4">
                	<label class="selectlabel">Nature Of Activity</label>
                    <select id="Activity" class="form-control testSelAll2 selectdrop" name="activity_alias" ng-model="natureofactivity" ng-change="dep_drop(natureofactivity,'complaint_alias')" ng-init="dep_drop(singleViews.activity_alias,'complaint_alias')">
                        <option value="">Select Nature Of Activity</option>
                        <option ng-repeat="activity in firstDrop" value="{{activity.alias}}" ng-selected="activity.alias == singleViews.activity_alias">{{activity.name}}</option>
                    </select>
                </div>
                <div class="col-sm-4">
                	<label class="selectlabel">Nature of Complaint</label>
                    <select id="Firstactivity" class="form-control testSelAll2 selectdrop" name="complaint_alias" ng-model="complaint_alias">
                        <option value="">Select Nature of Complaint</option>
                        <option ng-repeat="complaint in secondDrop" value="{{complaint.alias}}" ng-selected="complaint.alias == singleViews.complaint_alias">{{complaint.name}}</option>
                    </select>
                </div>        
            </div>
            <div class="row form-group">
                <div class="col-sm-4" ng-controller="milestoneDropCtrl">
                <label class="selectlabel">Mile Stone</label>
                    <select class="form-control testSelAll2 selectdrop" name="milestone" ng-model="milestone">
                        <option value="">Select Mile Stone</option>
                        <option ng-repeat="mile in firstDrop" value="{{mile.alias}}" ng-selected="mile.alias == singleViews.milestone">{{mile.name}}</option>
                    </select>
                </div>
                <div class="col-sm-4" ng-controller="paymentCtrl">
                	<label class="selectlabel">Payment Terms</label>
                    <select class="form-control testSelAll2 selectdrop" name="payment_terms" ng-model="paymentterm">
                        <option value="">Select Payment Terms</option>
                        <option ng-repeat="payment in paymentterms" value="{{payment.name}}" ng-selected="payment.name == singleViews.payment_terms">{{payment.name}}</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <md-input-container flex="" class="md-default-theme">
                        <label for="input_00D">Faulty Cell Count By Customer</label>
                        <input type="text" ng-model="singleViews.faulty_cell_count" valid-input="4" value="{{singleViews.faulty_cell_count}}" name="faulty_cell_count" class="md-input ng-touched" id="ae_fccc_id" tabindex="0">
                    </md-input-container>
                </div>
            </div>
           <div class="row form-group">
                <div class="col-sm-4">
                    <textarea rows="2" name="description" ng-model="singleViews.description" class="form-control resize-v" placeholder="Complete Observation">{{singleViews.description}}</textarea>
                </div>
                <div class="col-sm-4">
                    <md-input-container flex="" class="md-default-theme">
                        <label for="efsr_no">efsr No.</label>
                        <input ng-model="singleViews.efsr_no" value="{{singleViews.efsr_no}}" name="efsr_no" class="md-input ng-touched" id="ae_efsr_no" tabindex="0">
                    </md-input-container>
                </div>
                
                 <div class="col-sm-4" ng-controller="DatepickerDemoCtrl">
                   <md-input-container flex="" class="md-default-theme">
                        <label for="input_00D">efsr Date</label>
                        <input ng-model="singleViews.efsr_date" value="{{singleViews.efsr_date}}" name="efsr_date" class="datepicker md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" is-open="opened" min-date="'01-01-2000'" max-date="'22-06-2025'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>
                   </md-input-container>
                </div>
            </div>
            
           <div class="row form-group">
            <div class="col-sm-4" ng-controller="DatepickerDemoCtrl">
                <md-input-container flex="" class="md-default-theme">
                    <label for="input_00D">Closed Date</label>
                    <input ng-model="singleViews.closing_date" value="{{singleViews.closing_date}}" name="closing_date" class="datepicker md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" is-open="opened" min-date="singleViews.close_planned_date" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>
                </md-input-container>
            </div>
            <div class="col-sm-4" ng-controller="tatDropCntrl">
           	 <label class="selectlabel">TAT</label>
                <select class="form-control testSelAll2 selectdrop" name="tat" ng-model="tat">
                    <option value="">Select TAT</option>
                    <option ng-repeat="tat in tats" value="{{tat.name}}" ng-selected="tat.name == singleViews.tat">{{tat.name}}</option>
                </select>
            </div>
            <div class="col-sm-4">
            	<label class="selectlabel">Status</label>
                 <select class="form-control testSelAll2 selectdrop" name="tktstatus" ng-model="status">
                    <option value="">Select Status</option>
                    <option value="OPEN" ng-selected="'OPEN' == singleViews.status">OPEN</option>
                    <option value="VISITED" ng-selected="'VISITED' == singleViews.status">VISITED</option>
                    <option value="DECLINED" ng-selected="'DECLINED' == singleViews.status">DECLINED</option>
                    <option value="CLOSED" ng-selected="'CLOSED' == singleViews.status">CLOSED</option>
                </select>
            </div>
           </div>
           
            <div class="row form-group" ng-controller="leveldropCntrl">
            <div class="col-sm-4">
            <label class="selectlabel">Old Level</label>
                <select class="form-control testSelAll2 selectdrop" name="old_level" ng-model="old_level">
                    <option value="">Old Level</option>
                    <option ng-repeat="lvl in firstDrop" value="{{lvl.alias}}" ng-selected="lvl.alias == singleViews.old_level_code">{{lvl.name}}</option>
                </select>
            </div>
            <div class="col-sm-4">
            <label class="selectlabel">Level</label>
                <select class="form-control testSelAll2 selectdrop" name="level" ng-model="level">
                    <option value="">Level</option>
                    <option ng-repeat="lvl in firstDrop" value="{{lvl.alias}}" ng-selected="lvl.alias == singleViews.level_code">{{lvl.name}}</option>
                </select>
            </div>
            <div class="col-sm-4">
            <label class="selectlabel">Purpose</label>
                <select class="form-control testSelAll2 selectdrop" name="purpose" ng-model="purpose">
                    <option value="">Purpose</option>
                    <option value="0" ng-selected="singleViews.purpose==0">VISIT</option>
                    <option value="1" ng-selected="singleViews.purpose==1">REPLACE</option>
                </select>
            </div>
           </div>				
            <div class="row form-group">
				<div ng-controller="mocDropCntrl">
					<div class="col-sm-4">
					<label class="selectlabel">MOC</label>
						<select class="form-control testSelAll2 selectdrop" name="mode_of_contact" ng-init="singleViews.moc_num!='' ? this_moc_text = '1' : '0'" id="file_text" ng-model="mode_of_contact" ng-change="mochange()" required>
							<option value="">Select MOC</option>
							<option ng-repeat="moc in firstDrop" ng-selected="moc.alias == singleViews.mode_of_contact_alias" data-file="{{moc.file}}" data-text="{{moc.text}}" value="{{moc.alias}}">{{moc.name}}</option>
						</select>
					</div>
					
					<div class="col-sm-4" ng-if="this_moc_text == '1'">
						<md-input-container flex="" class="md-default-theme">
							<label for="input_00D">{{this_text_show}} Number</label>
							<input ng-model="singleViews.moc_num" value="{{singleViews.moc_num}}" name="moc_number" class="ng-pristine ng-valid md-input ng-touched" id="input_00Q" tabindex="0" aria-invalid="false" required>
						</md-input-container>
					</div>
					
					<div class="col-sm-4 filesRow" ng-if="this_moc_file == '1'" ng-controller="fileUploadPrgCtrl">
						 <!--<label class="selectlabel">Mode Of Contact: <span style="color:red;">(Mandatory)</span></label><br /> -->                                                    
						<input value="{{file_name}}" class="form-control uploadFile" placeholder="Upload {{this_text_show}}" disabled="disabled"/>
						<div class="fileUpload btn btn-sm btn-info" tooltip="Choose MOC" tooltip-placement="right">
							<span class="ion ion-upload"></span>
							<input type="file" class="upload uploadBtn" name="moc_file" id="moc_file" onchange="angular.element(this).scope().file_load(this.files,'pdf')"/>
						</div>
						<div ng-if="determinateValue >= '100' ? closeloadings() : ''"></div>
						<div class="mb20" ng-if="prg_shw_hde">
							<md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
						</div>
					</div>
                    <div class="col-sm-4" ng-if="singleViews.contact_link != '' && singleViews.contact_link != 0">
                        <label class="selectlabel">MOC</label>
                        <a href="{{singleViews.contact_link}}" class="form-control" target="_blank"><b>CLICK HERE</b></a>
                   </div>
				</div>  
					<div class="col-sm-4 filesRow" ng-controller="fileUploadPrgCtrl">
						 <!--<label class="selectlabel">Mode Of Contact: <span style="color:red;">(Mandatory)</span></label><br /> -->                                                    
						<input value="{{file_name}}" class="form-control uploadFile" placeholder="Upload FSR" disabled="disabled"/>
						<div class="fileUpload btn btn-sm btn-info" tooltip="Choose FSR" tooltip-placement="right">
							<span class="ion ion-upload"></span>
							<input type="file" class="upload uploadBtn" name="esca_efsr_link" id="esca_efsr_link" onchange="angular.element(this).scope().file_load(this.files,'pdf')"/>
						</div>
						<div ng-if="determinateValue >= '100' ? closeloadings() : ''"></div>
						<div class="mb20" ng-if="prg_shw_hde">
						<md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
						</div>
					</div>
                    <!--<div class="col-sm-4">
                        <div class="upload-file">
                            <label class="selectlabel">Choose FSR</label>
                            <input type="file" name="esca_efsr_link" class="md-input ng-touched" id="input_00P" tabindex="0" aria-invalid="false">
                        </div>
                    </div>-->
                    <div class="col-sm-4" ng-if="singleViews.esca_efsr_link != ''">
                        <label class="selectlabel">FSR</label>
	           			<a href="images/esca_efsr/{{singleViews.esca_efsr_link}}" class="form-control" target="_blank"><b>CLICK HERE</b></a>
                    </div>
          		 </div>
<!-- All Remarks -->
            <div class="mb20" ng-if="singleViews.remark_length != 0">
                <h5 class="modal-title text-center">Remarks</h5>
                    <table class="table table-condensed" >
                        <thead>
                            <tr>
                                <th width="5%"><a class="tktid">Sr.No</a></th>
                                <th width="20%"><a class="tktid">Remark By</a></th>
                                <th width="20%"><a class="tktid">Remark On</a></th>
                                <th width="45%"><a class="tktid">Remark</a></th>
                                <th width="10%"><a class="tktid">Action</a></th>
                            </tr>
                        <thead>
                    </table>
                    <div class="">
                        <table class="table table-hover table-bordered">
                            <tbody>
                                <tr class="tktBackground {{rem.remark_alias}}" ng-repeat="(key,rem) in singleViews.remark">
                                    <td width="5%">{{key + 1}}</td>
                                   <td width="20%">
                                   	<input type="hidden" name="remark_alias[]" value="{{rem.remark_alias}}" />
                                    <label class="selectlabel">Employee Name</label>
                                      <select tooltip-placement="top" tooltip="{{rem.designation}}" class="form-control testSelAll2 selectdrop" name="remarkedby[]" ng-model="remarkedby">
                                        <option value="">Employee Name</option>
                                        <option value="ADMIN" ng-selected="rem.remarkedby == 'ADMIN'">ADMIN</option>
                                        <option ng-repeat="employeelist in thirdDrop" value="{{employeelist.alias}}" ng-selected="employeelist.alias == rem.remarkedby_alias">{{employeelist.name}}</option>
                                      </select>
                                   </td>
                                    <td class="hidden-xs hidden-sm" ng-controller="DatepickerDemoCtrl" width="20%"><input ng-model="rem.remarkedon" value="{{rem.remarkedon}}" name="remarkedon[]" class="datepicker md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" is-open="opened" min-date="'01-01-2000'" max-date="'22-06-2025'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/></td>
                                    <td width="45%"><textarea rows="2" name="remark[]" ng-model="rem.remark" class="form-control resize-v">{{rem.remark}}</textarea></td>
                                    <td width="10%"><button type="button" class="btn btn-info btn-sm" ng-click="rmrk(rem.remark_alias)">Delete</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
<!-- All Action -->
            <div class="mb20" ng-if="singleViews.action_length != 0">
                <h5 class="modal-title text-center">Action Taken</h5>
                    <table class="table table-condensed" >
                        <thead>
                            <tr>
                                <th width="20%"><a class="tktid">Sr.No</a></th>
                                <th width="60%"><a class="tktid">Action Taken</a></th>
                                <th width="20%"><a class="tktid">Action</a></th>
                            </tr>
                        <thead>
                    </table>
                    <div class="">
                        <table class="table table-hover table-bordered">
                            <tbody>
                                <tr class="tktBackground {{rem.action_alias}}" ng-repeat="(key,rem) in singleViews.action">
                                    <td width="20%">{{key + 1}}</td>
                                    <td width="60%">
										<input type="hidden" name="action_alias[]" value="{{rem.action_alias}}" />
										<textarea rows="2" name="observation[]" ng-model="rem.observation" class="form-control resize-v">{{rem.observation}}</textarea>
									</td>
                                    <td width="20%"><button type="button" class="btn btn-info btn-sm" ng-click="act_tkn(rem.action_alias)">Delete</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
<!-- All Cells Required -->
                <div class="mb20" ng-if="singleViews.required_cells.length > 0">
                <h5 class="modal-title text-center">Required Items</h5>
                <table class="table table-condensed" >
                    <thead>
                        <tr>
                            <th><a class="tktid">Item Type</a></th>
                            <th><a class="tktid">Item Desc</a></th>
                            <th><a class="tktid">Quantity</a></th>
                            <th><a class="tktid">Status</a></th>
                            <th><a class="tktid">Approved By</a></th>
                            <th><a class="tktid">Approved On</a></th>
                            <th><a class="tktid">Action</a></th>
                        </tr>
                    <thead>
                </table>
                <div class="">
                    <table class="table table-hover table-bordered">
                        <tbody>
                            <tr class="tktBackground {{rem.item_alias}}" ng-repeat="(key,rem) in singleViews.required_cells">
                                <td>{{rem.item_type==1 ? 'CELLS':'ACCESSORIES'}}<input type="hidden" name="item_alias[]" value="{{rem.item_alias}}" /></td>
                                <td ng-controller="productdropCntrl" ng-if="rem.item_type==1">
	                                <label class="selectlabel">Cells</label>
                                	<select class="form-control testSelAll2 selectdrop" name="item_code[]" ng-model="item_code" required>
                                        <option value="">Select Cells</option>
                                        <option ng-repeat="itemcode in firstDrop" value="{{itemcode.alias}}" ng-selected="itemcode.alias == rem.cell_alias">{{itemcode.name}}</option>
                                    </select>
                                </td>
                                <td ng-controller="accessorydropCntrl" ng-if="rem.item_type==2">
                                    <label class="selectlabel">Accessories</label>
                                	<select class="form-control testSelAll2 selectdrop" name="item_code[]" ng-model="item_code" required>
                                        <option value="">Select Accessories</option>
                                        <option ng-repeat="itemcode in firstDrop" value="{{itemcode.alias}}" ng-selected="itemcode.alias == rem.cell_alias">{{itemcode.name}}</option>
                                    </select>
                                </td>
                                <td><input type="text" value="{{rem.quantity}}" name="quantity[]" class="form-control md-input ng-touched" placeholder="Enter Quantity" id="input_00P" tabindex="0" aria-invalid="false"></td>
                                <td>
                                 <label class="selectlabel">Status</label>
                                  <select class="form-control testSelAll2 selectdrop" name="req_cell_status[]" ng-model="req_cell_status">
                                    <option value="">Status</option>
                                    <option value="1" ng-selected="rem.approved_stat_num == '1'">PENDING</option>
                                    <option value="{{rem.approved_stat_num}}" ng-selected="rem.approved_stat_num >= '2'">APPROVED</option>
                                  </select>
                                </td>
                                <td>
                                <label class="selectlabel">Employee Name</label>
                                  <select tooltip-placement="top" tooltip="{{rem.designation}}" class="form-control testSelAll2 selectdrop" name="approved_by[]" ng-model="approved_by">
                                    <option value="">Employee Name</option>
                                    <option value="ADMIN" ng-selected="rem.approved_by_alias == 'ADMIN'">ADMIN</option>
                                    <option ng-repeat="employeelist in thirdDrop" value="{{employeelist.alias}}" ng-selected="employeelist.alias == rem.approved_by_alias">{{employeelist.name}}</option>
                                  </select>
                                 </td>
                                 <td class="hidden-xs hidden-sm" ng-controller="DatepickerDemoCtrl"><input ng-model="rem.approved_on" value="{{rem.approved_on}}" name="approved_on[]" class="datepicker md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" is-open="opened" min-date="'01-01-2000'" max-date="'22-06-2025'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/></td>
                                <td><button type="button" class="btn btn-info btn-sm" ng-click="req_cel(rem.item_alias)">Delete</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
           <br>
            <div class="row form-group"> 
                <div class="col-sm-6 col-sm-offset-5">
                    <button type="submit" click-once class="btn btn-info btn-sm">Submit</button>
                    <button type="reset" class="btn btn-info btn-sm" ng-click="userForm.$setPristine(); userForm.$setUntouched();">Reset</button>
                </div>
            </div><br>
		</form>
	</div>
</div>
<script>
	setInterval(function(){
		$('.testSelAll2').SumoSelect();
		$('.forms_add').find('.SumoSelect').addClass('singleSelect');
	},0);
</script>