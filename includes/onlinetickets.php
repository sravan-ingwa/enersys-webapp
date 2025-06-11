<style>
.form-group {margin-bottom:0px !important;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.btn-default{border-color:transparent !important;}
.autoselect{padding-top:22px !important;}
.upload-file{border-bottom: 1px solid rgba(0,0,0,0.12); padding-top:9px;}
.ui-select-bootstrap > .ui-select-search:focus{border: none;background:#FFF !important;}
.md-dialog-container {z-index:10000;}
.page-auth .customer-page {background: #fff; max-width: 1100px; margin: 0 auto; box-shadow: 0 1px 8px rgba(0, 0, 0, 0.14);margin-top:40px; border: 1px solid #790900;}
.main-container .content-container.fixedHeader .page {margin-top: 0px !important;}
.contact-dropdown {margin-top: 9px !important;}
.page-auth .panel-heading {padding: 7px 15px; border-bottom: 1px solid transparent;}
.page-auth .panel-heading .panel-title {font-size: 16px;text-transform: none;color: #fff;font-weight: bold;}
.page-auth .forms_add{padding:20px;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
.toast { z-index:10000;}
.app.body-full .main-container{transform:none; -webkit-transform:none; -ms-transform:none; top:0px !important;}
</style>
	
    <div ng-controller="activityComplaintCntrl">
	<div class="row topmenu">
        <div class="col-sm-2 hidden-xs text-left"></div>
    	<div class="col-xs-8 text-center">
			<h1 class="fdd"><a href="javascript:;" style="text-transform:none !important"><span style="font-size:27px !important;">E</span>nerSys <span style="color:#40AE51;text-shadow:-1px -1px 0 #FFF,1px -1px 0 #FFF,-1px 1px 0 #FFF,1px 1px 0 #FFF;">Care</span><span class="hidden-xs"> Online Ticket Registration</span></a></h1>
        </div>
		<div class="col-sm-2 col-xs-4 text-right">
            <ul class="list-unstyled right-elems">
                <li class="notify-drop hidden-xs dropdown" dropdown style="margin-top:8px;">
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
                                            <p class="small text-muted"> 040-6704 6704</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="clearfix">
                                    <a href>
                                        <span class="ion ion-person left bg-info"></span>
                                        <div class="desc">
                                            <strong>Feedback Us</strong>
                                            <p class="small text-muted">feedback@enersys.co.in</p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
	<div class="page page-auth" ng-controller="warrantycalCtrl">
		<div class="customer-page" ng-controller="addingform">
			<!--<div class="toast toast-topRight1">
				<alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
					<div ng-bind-html="toast.msg"></div>
				</alert>
			</div>-->
            <div class="panel-heading" style="background-color: #790900; border-color: #790900;">
              <h3 class="panel-title">CREATE ONLINE TICKETS</h3>
            </div>
			<form class="form-horizontal forms_add" name="onlinetktForm" data-went="#/onlinetickets" method="post" url="services/tickets/online_ticket_add" ng-submit="sendPost()" novalidate>
                <input type="hidden" value="onlineticket" name="help">
                <div class="row form-group">
					<div class="col-sm-4">
						<select id="Activity" class="form-control selectdrop" name="activity_alias" ng-model="natureofactivity" ng-change="dep_drop(natureofactivity)" required>
							<option value=''  selected="selected">Select Nature Of Activity</option>
							<option ng-repeat="activity in firstDrop" value="{{activity.alias}}" ng-selected="activity.alias == singleViews.activity_alias">{{activity.name}}</option>
						</select>
                        <span class="help-block" ng-show="userForm.activity_alias.$dirty && userForm.activity_alias.$invalid">
                            <span ng-show="userForm.activity_alias.$error.required">Select Nature of Activity</span>
                        </span>
					</div>
					<div class="col-sm-4">
						<md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Created Date</label>
                            <input ng-model="date.value" readonly="readonly" class="ng-pristine ng-valid md-input ng-touched" id="input_00B" tabindex="0" aria-invalid="false">
						</md-input-container>
					</div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Site Id</label>
                            <input ng-model="siteid" class="ng-pristine ng-valid md-input ng-touched" name="site_id" id="input_00C" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="onlinetktForm.site_id.$dirty && onlinetktForm.site_id.$invalid">
                            <span ng-show="onlinetktForm.site_id.$error.required">Site ID is Required</span>
                        </span>
                    </div>
                  </div>
                <div class="row form-group" ng-controller="zoneStateCntrl">
                    <div class="col-sm-4">
                        <select class="form-control selectdrop" name="zone_alias" id="zone" ng-model="zones" ng-change="dep_drop(zones)" required="required">
                            <option value="" selected="selected">Select Zone</option>
                            <option ng-repeat="zone in firstDrop" ng-if="zone.name!='FACTORY'" value="{{zone.alias}}">{{zone.name}}</option>
                        </select>
                        <span class="help-block" ng-show="onlinetktForm.zone_alias.$dirty && onlinetktForm.zone_alias.$invalid">
                            <span ng-show="onlinetktForm.zone_alias.$error.required">Select Zone Name</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control selectdrop" name="state_alias" id="state" ng-model="states" ng-change="dep_drop2(states)" required="required">
                            <option value="" selected="selected">Select State</option>
                            <option ng-repeat="state in secondDrop" value="{{state.alias}}">{{state.name}}</option>
                        </select>
                        <span class="help-block" ng-show="onlinetktForm.state_alias.$dirty && onlinetktForm.state_alias.$invalid">
                            <span ng-show="onlinetktForm.state_alias.$error.required">Select State Name</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control selectdrop" name="district_alias" id="district" ng-model="districts" required="required">
                            <option value="" selected="selected">Select District</option>
                            <option ng-repeat="district in thirdDrop" value="{{district.alias}}">{{district.name}}</option>
                        </select>
                        <span class="help-block" ng-show="onlinetktForm.district_alias.$dirty && onlinetktForm.district_alias.$invalid">
                            <span ng-show="onlinetktForm.district_alias.$error.required">Select District Name</span>
                        </span>  
                    </div>
                 </div>
                 <div ng-controller="segmentCustSitetypedropCntrl">
                 <div class="row form-group">
                    <div class="col-sm-4">
                         <select class="form-control selectdrop" name="segment_alias" ng-model="segments" ng-change="dep_drop(segments)" required="required">
                            <option value="" selected="">Select Segment</option>
                            <option ng-repeat="segment in firstDrop" value="{{segment.alias}}">{{segment.name}}</option>
                        </select>
                        <span class="help-block" ng-show="onlinetktForm.segment_alias.$dirty && onlinetktForm.segment_alias.$invalid">
                            <span ng-show="onlinetktForm.segment_alias.$error.required">Select Segment Name</span>
                        </span> 
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control selectdrop" name="customer_alias" ng-model="customer" required="required" ng-change="dep_drop_product(customer)">
                            <option value="" selected="">Select Customer</option>
                            <option ng-repeat="customer in secondDrop" value="{{customer.alias}}">{{customer.name}}</option>
                        </select>
                        <span class="help-block" ng-show="onlinetktForm.customer_alias.$dirty && onlinetktForm.customer_alias.$invalid">
                            <span ng-show="onlinetktForm.customer_alias.$error.required">Select Customer Name</span>
                        </span> 
                        
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control selectdrop" name="site_type_alias" ng-model="sitetype" required="required">
                            <option value="" selected="">Select Site Type</option>
                            <option ng-repeat="sitetype in thirdDrop" value="{{sitetype.alias}}">{{sitetype.name}}</option>
                        </select>
                        <span class="help-block" ng-show="onlinetktForm.site_type_alias.$dirty && onlinetktForm.site_type_alias.$invalid">
                            <span ng-show="onlinetktForm.site_type_alias.$error.required">Select Site Type</span>
                        </span> 
                    </div>
                 </div>   
                 <div class="row form-group">
                     <div class="col-sm-4" ng-class="{'has-error' : submitted && sitemasterForm.product_alias.$invalid}">
                        <label class="selectlabel">Product Code</label>
                        <select class="form-control testSelAll2 selectdrop" placeholder="Product Code" name="product_alias[]" ng-model="productcode" required multiple="multiple">
                            <option ng-repeat="product in productDrop" value="{{product.alias}}">{{product.name}}</option>
                    	</select>
                         <span class="help-block" ng-show="onlinetktForm['product_alias[]'].$dirty && onlinetktForm['product_alias[]'].$invalid">
                            <span ng-show="onlinetktForm['product_alias[]'].$error.required">Select Product Code</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Battery Bank Rating</label>
                            <input ng-model="battery_bank_rating" name="batt_rating" class="ng-pristine ng-valid md-input ng-touched" id="input_00N" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="onlinetktForm.batt_rating.$dirty && onlinetktForm.batt_rating.$invalid">
                            <span ng-show="onlinetktForm.batt_rating.$error.required">Battery Bank Rating is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Site Name</label>
                            <input ng-model="sitename" class="ng-pristine ng-valid md-input ng-touched" name="site_name" id="input_00D" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="onlinetktForm.site_name.$dirty && onlinetktForm.site_name.$invalid">
                            <span ng-show="onlinetktForm.site_name.$error.required">Site Name is Required</span>
                        </span>
                    </div>
                 </div>
                </div>
                  <div class="row form-group" ng-controller="DatepickerDemoCtrl"> 
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="Autocomplete">Site Address</label>
                           <input ng-model="site_address" placeholder="Site Address" name="site_address" class="ng-pristine ng-valid md-input ng-touched" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="onlinetktForm.site_address.$dirty && onlinetktForm.site_address.$invalid">
                            <span ng-show="onlinetktForm.site_address.$error.required">Site Address is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Manufactured Date</label>
                            <input type="text" ng-model="Manufactureddate" name="mfd_date" class="datepicker ng-pristine ng-valid md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="manfdatescal('warr','warr','warr');open($event,'opened1')"/>
                       </md-input-container>
                    </div>	
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00E">Installation Date</label>
                            <input type="text" ng-model="Installationdate" name="install_date" class="datepicker ng-pristine ng-valid md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="manfdatescal('warr','warr','warr');open($event,'opened2')">
                        </md-input-container>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4">
                         <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Site Technician Name</label>
                            <input ng-model="sitetechnicianname" class="ng-pristine ng-valid md-input ng-touched" name="technician_name" id="input_00K" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="onlinetktForm.technician_name.$dirty && onlinetktForm.technician_name.$invalid">
                            <span ng-show="onlinetktForm.technician_name.$error.required">Site Technician Name is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Site Technician Number</label>
                            <input ng-model="sitetechniciannumber" class="ng-pristine ng-valid md-input ng-touched" ng-pattern="/^[0-9]{1,10}$/" name="technician_number" id="input_00L" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="onlinetktForm.technician_number.$dirty && onlinetktForm.technician_number.$invalid">
                            <span ng-show="onlinetktForm.technician_number.$error.required">Site Technician Number is Required</span>
                            <span ng-show="onlinetktForm.technician_number.$error.pattern">Contact No should be 10 digits only.</span>
                        </span>
                    </div>   
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Cluster Manager Name</label>
                            <input ng-model="clustermanager" class="ng-pristine ng-valid md-input ng-touched" name="manager_name" id="input_00L" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="onlinetktForm.manager_name.$dirty && onlinetktForm.manager_name.$invalid">
                            <span ng-show="onlinetktForm.manager_name.$error.required">Cluster Manager Name is Required</span>
                        </span>
                    </div> 
                </div>
                <div class="row form-group">
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Cluster Manager Number</label>
                            <input ng-model="clustermanagernum" class="ng-pristine ng-valid md-input ng-touched" ng-pattern="/^[0-9]{1,10}$/" name="manager_number" id="input_00L" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="onlinetktForm.manager_number.$dirty && onlinetktForm.manager_number.$invalid">
                            <span ng-show="onlinetktForm.manager_number.$error.required">Cluster Manager Number is Required</span>
                            <span ng-show="onlinetktForm.manager_number.$error.pattern">Contact No should be 10 digits only.</span>
                        </span>
                    </div>
                     <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Cluster Manager Email</label>
                            <input type="text" ng-model="clustermanageremail" class="ng-pristine ng-valid md-input ng-touched" name="manager_mail" ng-pattern="/^(([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+([;,.](([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+)*$/" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="onlinetktForm.manager_mail.$dirty && onlinetktForm.manager_mail.$invalid">
                            <span ng-show="onlinetktForm.manager_mail.$error.required">Cluster Manager Email is Required</span>
                            <span ng-show="onlinetktForm.manager_mail.$error.pattern">Invalid Email Address</span>
                        </span>
                    </div>
                    <div class="col-sm-4" ng-controller="noofstringsDropCntrl">
                        <select class="form-control selectdrop" ng-model="noofstrings" name="no_of_string" required="required">
                            <option value="" selected>No.Of Strings</option>
                            <option ng-repeat="string in noofstring" value="{{string.name}}">{{string.name}}</option>
                        </select>
                        <span class="help-block" ng-show="onlinetktForm.no_of_string.$dirty && onlinetktForm.no_of_string.$invalid">
                            <span ng-show="onlinetktForm.no_of_string.$error.required">Select No.Of Strings</span>
                        </span>
                    </div>
                </div>
                 <div class="row form-group">
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Preventive Maintenance Schedule</label>
                            <input ng-model="mafdates.schedule" readonly="readonly" value="{{mafdates.schedule}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00N" tabindex="0" aria-invalid="false">
                        </md-input-container>
                    </div> 
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Warranty Months</label>
                            <input ng-model="mafdates.warrantymonths" readonly="readonly" value="{{mafdates.warrantymonths}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00O" tabindex="0" aria-invalid="false">
                        </md-input-container>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Warranty Left</label>
                            <input ng-model="mafdates.warrantyleft" readonly="readonly" value="{{mafdates.warrantyleft}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00P" tabindex="0" aria-invalid="false">
                        </md-input-container>
                    </div>	
                </div>
                <div class="row form-group"> 			
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Site Status</label>
                            <input ng-model="mafdates.warrantystatus" readonly="readonly" value="{{mafdates.warrantystatus}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00N" tabindex="0" aria-invalid="false">
                        </md-input-container>
                    </div>
                    <div class="col-sm-4">
                        <select id="Firstactivity" class="form-control selectdrop" name="complaint_alias" ng-model="activity" required>
                            <option value=""  selected="selected">Select Nature of Complaint</option>
                            <option ng-repeat="complaint in secondDrop" value="{{complaint.alias}}" ng-selected="complaint.alias == singleViews.complaint_alias">{{complaint.name}}</option>
                        </select>
                        <span class="help-block" ng-show="onlinetktForm.complaint_alias.$dirty && onlinetktForm.complaint_alias.$invalid">
                            <span ng-show="onlinetktForm.complaint_alias.$error.required">Nature of Complaint Required</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Faulty Cells Count</label>
                            <input ng-model="faulty_cell_count" ng-pattern="/^(?=.)([+-]?([0-9]*)(\.([0-9]+))?)$/" name="faulty_cell_count" class="ng-pristine ng-valid md-input ng-touched" id="input_00Q" tabindex="0" aria-invalid="false" required>
                        </md-input-container>
                        <span class="help-block" ng-show="onlinetktForm.faulty_cell_count.$dirty && onlinetktForm.faulty_cell_count.$invalid">
                            <span ng-show="onlinetktForm.faulty_cell_count.$error.required">Faulty Cells Count is Required</span>
                            <span ng-show="onlinetktForm.faulty_cell_count.$error.pattern">Faulty Cells Count is Digits Only</span>
                        </span>
                    </div>
                </div>
                <div class="row form-group"> 
                    <div class="col-sm-4">
                        <textarea rows="2" name="description" ng-model="user.description" class="form-control resize-v" placeholder="Complete Observation" required></textarea>
                        <span class="help-block" ng-show="onlinetktForm.description.$dirty && onlinetktForm.description.$invalid">
                            <span ng-show="onlinetktForm.description.$error.required">Complete Observation is Required</span>
                        </span>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-6 col-sm-offset-5 mt10">
                            <button type="submit" class="btn btn-info btn-sm" ng-disabled="onlinetktForm.$invalid || onlinetktForm.$pristine">Create</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="onlinetktForm.$setPristine(); onlinetktForm.$setUntouched();" >Reset</button>
                    </div>
               </div>
          </form>
		</div>
	</div>
   </div> 
    
<script>
setInterval(function(){$('.testSelAll2').SumoSelect({selectAll:true});
$('.forms_add').find('.SumoSelect').addClass('singleSelect');},0);
</script>