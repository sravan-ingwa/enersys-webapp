<style>
.form-group {margin-bottom:0px !important;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.btn-default{border-color:transparent !important;border-bottom:1px solid #e0e0e0 !important;}
.autoselect{padding-top:22px !important;}
.md-dialog-container {z-index:10000;}
.upload-file {
	border-bottom: 1px solid rgba(0,0,0,.12)
}
.ui-select-bootstrap>.ui-select-search:focus {
	border: none;
	background: #FFF!important;
	border-bottom: 1px solid #e0e0e0
}
.ui-select-bootstrap>.ui-select-match>button {
	text-align: left!important
}
.selectdrop {
	overflow-y: scroll
}
.singleSelect {
	width: 100%;
	border-bottom: 1px solid #e0e0e0
}
.SumoSelect>.optWrapper {
	right: 0!important
}
.SumoSelect>.CaptionCont>span.placeholder {
	color: #ccc!important
}
.singleSelect>.CaptionCont>label>i {
	color: #000
}
.SumoSelect>.optWrapper.open {
	top: 33px!important
}
</style>
	<div class="modal-style" ng-controller="activityComplaintCntrl">
		<div class="modal-header clearfix">
			<h4 class="modal-title">Create Tickets</h4>
			<span class="close ion ion-android-close" ng-click="ticketClose()" md-ink-ripple></span>
		</div>
		<div class="modal-body" ng-controller="addingform">
			<!--<div class="toast toast-topRight">
				<alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
					<div ng-bind-html="toast.msg"></div>
				</alert>
			</div>-->
			<form class="form-horizontal forms_add" name="userForm" role="form" data-went="#/tickets" enctype="multipart/form-data" method="post" url="services/tickets/ticket_add" ng-submit="sendPost()" novalidate>
				<div class="row form-group">
					<div class="col-sm-4">
					<label class="selectlabel">Nature Of Activity</label>
						<select id="Activity" class="form-control testSelAll2 selectdrop" name="activity_alias" ng-model="natureofactivity" ng-change="dep_drop(natureofactivity,'complaint_alias');activitychange();" required>
							<option value="" data-type="" selected="selected" disabled="disabled">Select Nature Of Activity</option>
							<option ng-repeat="activity in firstDrop" value="{{activity.alias}}" data-type="{{activity.type}}">{{activity.name}}</option>
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
					<div class="col-sm-4" ng-if="this_act_type != '2'">
						<div class="form-group autoselect">
                        	<input name="site_alias" value="{{sit_alias}}" type="hidden"/>
							<ui-select ng-model="person.selected" search-enabled="true" ng-change="autotickets(person.selected)" data-ng-keyup="sitemasterlist($select.search,'')">
								<ui-select-match placeholder="Select a Site ID">{{$select.selected.site_id}}</ui-select-match>
								<ui-select-choices repeat="person in datas">
									<div ng-bind-html="person.site_id"></div> 
								</ui-select-choices>
							</ui-select> 
						</div>
					</div>
                    <div class="col-sm-4" ng-if="this_act_type == '2'">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Site ID</label>
                            <input ng-model="siteid" class="ng-pristine ng-valid md-input ng-touched" name="site_alias" id="input_00C" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="userForm.site_alias.$dirty && userForm.site_alias.$invalid">
                            <span ng-show="userForm.site_alias.$error.required">Site ID is Required</span>
                        </span>
                    </div>
                  </div>
                  <div class="row form-group" ng-if="this_act_type == '0'">
                  	<div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">PO Number</label>
                            <input ng-model="po_number" name="po_number" class="ng-pristine ng-valid md-input ng-touched" id="input_00Q" tabindex="0" aria-invalid="false" required="required" >
                        </md-input-container>
                        <span class="help-block" ng-show="userForm.po_number.$dirty && userForm.po_number.$invalid">
                            <span ng-show="userForm.po_number.$error.required">PO Number is Required</span>
                        </span>
                    </div>
					<div class="col-sm-4" ng-controller="DatepickerDemoCtrl">
						<md-input-container flex="" class="md-default-theme">
							<label for="input_00C">PO Date</label>
							<input type="text" ng-model="po_date" name="po_date" class="datepicker ng-pristine ng-valid md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" tabindex="1" ng-click="open($event,'opened')" ng-focus="open($event,'opened')" is-open="opened" min-date="'01-01-2000'" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>
						</md-input-container>
					</div>
                    <div class="col-sm-4 filesRow" ng-controller="fileUploadPrgCtrl">
                         <!--<label class="selectlabel">Mode Of Contact: <span style="color:red;">(Mandatory)</span></label><br /> -->                                                    
                        <input value="{{file_name}}" class="form-control uploadFile" placeholder="Upload PO Copy" disabled="disabled"/>
                        <div class="fileUpload btn btn-sm btn-info" tooltip="Choose PO Copy" tooltip-placement="right">
                            <span class="ion ion-upload"></span>
                            <input type="file" class="upload uploadBtn" name="po_file" id="po_file" onchange="angular.element(this).scope().file_load(this.files,'pdf')"/>
                        </div>
                        <span class="help-block" ng-show="userForm.po_file.$dirty && userForm.po_file.$invalid">
                            <span ng-show="userForm.po_file.$error.required">Upload PO Copy</span>
                        </span>
                        <div ng-if="determinateValue >= '100' ? closeloadings() : ''"></div>
                        <div class="mb20" ng-if="prg_shw_hde">
                            <md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
                        </div>
                    </div>
                  </div>
<!--OTHER THAN OTHER ACTIVITY START-->
              <div ng-if="this_act_type != '2'">
                  <div class="row form-group">
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Site Name</label>
                            <input value="{{singleViews.site_name}}" readonly="readonly" class="ng-pristine ng-valid md-input ng-touched" id="input_00D" tabindex="0" aria-invalid="false">
                        </md-input-container>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Zone</label>
                            <input readonly="readonly" value="{{singleViews.zone_name}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00E" tabindex="0" aria-invalid="false">
                        </md-input-container>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">State</label>
                            <input readonly="readonly" value="{{singleViews.state_name}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00F" tabindex="0" aria-invalid="false">
                        </md-input-container>
                    </div>
                   </div>
                   <div class="row form-group"> 
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">District</label>
                            <input readonly="readonly" value="{{singleViews.district_name}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00G" tabindex="0" aria-invalid="false">
                        </md-input-container>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Manufactured Date</label>
                            <input readonly="readonly" value="{{singleViews.mfd_date}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00H" tabindex="0" aria-invalid="false">
                        </md-input-container>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Install Date</label>
                            <input readonly="readonly" value="{{singleViews.install_date}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00I" tabindex="0" aria-invalid="false">
                        </md-input-container>
                    </div>
                   </div>
                   <div class="row form-group"> 
                        <div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme md-input-has-value">
                                <label for="input_00D">Number Banks</label>
                                <input readonly="readonly" value="{{singleViews.no_of_string}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00J" tabindex="0" aria-invalid="false">
                            </md-input-container>
                        </div>
                        <div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme md-input-has-value">
                                <label for="input_00D">First Level Contact Name</label>
                                <input value="{{singleViews.technician_name}}" readonly="readonly" class="ng-pristine ng-valid md-input ng-touched" id="input_00K" tabindex="0" aria-invalid="false">
                            </md-input-container>
                        </div>
                        <div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme md-input-has-value">
                                <label for="input_00D">First Level Contact Number</label>
                                <input readonly="readonly" value="{{singleViews.technician_number}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00L" tabindex="0" aria-invalid="false">
                            </md-input-container>
                        </div>
                   </div>
                   <div class="row form-group"> 
                        <div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme md-input-has-value">
                                <label for="input_00D">Segment</label>
                                <input readonly="readonly" value="{{singleViews.segment_name}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00M" tabindex="0" aria-invalid="false">
                            </md-input-container>
                        </div>
                        <div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme md-input-has-value">
                                <label for="input_00D">Site Type</label>
                                <input readonly="readonly" value="{{singleViews.site_type}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00N" tabindex="0" aria-invalid="false">
                            </md-input-container>
                        </div>
                        <div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme md-input-has-value">
                                <label for="input_00D">Customer Name</label>
                                <input readonly="readonly" value="{{singleViews.customer_name}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00O" tabindex="0" aria-invalid="false">
                            </md-input-container>
                        </div>
                   </div>
                   <div class="row form-group"> 
                        <div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme md-input-has-value">
                                <label for="input_00D">Second Level Contact Name</label>
                                <input readonly="readonly" value="{{singleViews.manager_name}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00P" tabindex="0" aria-invalid="false">
                            </md-input-container>
                        </div>
                        <div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme md-input-has-value">
                                <label for="input_00D">Second Level Contact Number</label>
                                <input readonly="readonly" value="{{singleViews.manager_number}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00P" tabindex="0" aria-invalid="false">
                            </md-input-container>
                        </div>
                        <div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme md-input-has-value">
                                <label for="input_00D">Second Level Contact Email ID</label>
                                <input readonly="readonly" value="{{singleViews.manager_mail}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00P" tabindex="0" aria-invalid="false">
                            </md-input-container>
                        </div>
                   </div>
                   <div class="row form-group"> 
                        <div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme md-input-has-value">
                                <label for="input_00D">Product Code</label>
                                <input readonly="readonly" value="{{singleViews.product_description}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00Q" tabindex="0" aria-invalid="false">
                            </md-input-container>
                        </div>
						<div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme md-input-has-value">
                                <label for="input_00D">Battery Bank Rating</label>
                                <input readonly="readonly" value="{{singleViews.battery_bank_rating}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00Q" tabindex="0" aria-invalid="false">
                            </md-input-container>
                        </div>
                        <div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme md-input-has-value">
                                <label for="input_00D">Site Address</label>
                                <input readonly="readonly" value="{{singleViews.site_address}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00Q" tabindex="0" aria-invalid="false">
                            </md-input-container>
                        </div>
                   </div>
			  </div>
<!--OTHER THAN OTHER ACTIVITY END-->
<!--OTHER ACTIVITY START-->
              <div ng-if="this_act_type == '2'">
				<div class="row form-group" ng-controller="zoneStateCntrl">
                    <div class="col-sm-4">
                    <label class="selectlabel">Zone</label>
                        <select class="form-control testSelAll2 selectdrop" name="zone_alias" id="zone" ng-model="zones" ng-change="dep_drop(zones,'state_alias')" required="required">
                            <option value="" selected="selected"  disabled="disabled">Select Zone</option>
                            <option ng-repeat="zone in firstDrop" value="{{zone.alias}}" ng-if="zone.alias!='4VTSNSSBM9'">{{zone.name}}</option>
                        </select>
                        <span class="help-block" ng-show="userForm.zone_alias.$dirty && userForm.zone_alias.$invalid">
                            <span ng-show="userForm.zone_alias.$error.required">Select Zone Name</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                    <label class="selectlabel">State</label>
                        <select class="form-control testSelAll2 selectdrop" name="state_alias" id="state" ng-model="states" ng-change="dep_drop2(states,'district_alias')" required="required">
                            <option value="" selected="selected"  disabled="disabled">Select State</option>
                            <option ng-repeat="state in secondDrop" value="{{state.alias}}">{{state.name}}</option>
                        </select>
                        <span class="help-block" ng-show="userForm.state_alias.$dirty && userForm.state_alias.$invalid">
                            <span ng-show="userForm.state_alias.$error.required">Select State Name</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                    <label class="selectlabel">District</label>
                        <select class="form-control testSelAll2 selectdrop" name="district_alias" id="district" ng-model="districts" required="required">
                            <option value="" selected="selected"  disabled="disabled">Select District</option>
                            <option ng-repeat="district in thirdDrop" value="{{district.alias}}">{{district.name}}</option>
                        </select>
                        <span class="help-block" ng-show="userForm.district_alias.$dirty && userForm.district_alias.$invalid">
                            <span ng-show="userForm.district_alias.$error.required">Select District Name</span>
                        </span>  
                    </div>
                 </div>
                 <div ng-controller="segmentCustSitetypedropCntrl">
                 <div class="row form-group" ng-init="dep_drop(singleViews.alias,'customer_alias','site_type_alias')">
					<div class="col-sm-4">
						<input type="hidden" value="{{singleViews.alias}}" ng-model="singleViews.alias" name="segment_alias">
						<md-input-container flex="" class="md-default-theme md-input-has-value">
							<label for="input_00D">Segment</label>
							<input readonly="readonly" value="{{singleViews.name}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00Q" tabindex="0" aria-invalid="false">
						</md-input-container>
					</div>
                    <div class="col-sm-4">
						<label class="selectlabel">Customer</label>
                        <select class="form-control testSelAll2 selectdrop" name="customer_alias" ng-model="customer" required="required" ng-change="dep_drop_product(customer)">
                            <option value="" selected="" disabled="disabled">Select Customer</option>
                            <option ng-repeat="customer in secondDrop" value="{{customer.alias}}">{{customer.name}}</option>
                        </select>
                        <span class="help-block" ng-show="userForm.customer_alias.$dirty && userForm.customer_alias.$invalid">
                            <span ng-show="userForm.customer_alias.$error.required">Select Customer Name</span>
                        </span> 
                    </div>
                    <div class="col-sm-4">
                    <label class="selectlabel">Site Type <span style="color:#d1d1d1">(optional)</span></label>
                        <select class="form-control testSelAll2 selectdrop" name="site_type_alias" ng-model="sitetype">
                            <option value="" selected="" disabled="disabled">Select Site Type</option>
                            <option ng-repeat="sitetype in thirdDrop" value="{{sitetype.alias}}">{{sitetype.name}}</option>
                        </select>
                    </div>
                 </div>   
                 <div class="row form-group">
                     <div class="col-sm-4">
                     <label class="selectlabel">Product Code</label>
                        <select class="form-control testSelAll2 selectdrop" placeholder="Product Code" name="product_alias" ng-model="productcode" required>
                            <option value="" disabled="disabled">Select Product Code</option>
							<option ng-repeat="product in productDrop" value="{{product.alias}}">{{product.name}}</option>
                    	</select>
                         <span class="help-block" ng-show="userForm.product_alias.$dirty && userForm.product_alias.$invalid">
                            <span ng-show="userForm.product_alias.$error.required">Select Product Code</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Battery Bank Rating <span style="color:#d1d1d1">(optional)</span></label>
                            <input ng-model="battery_bank_rating" name="batt_rating" class="ng-pristine ng-valid md-input ng-touched" id="input_00N" tabindex="0" aria-invalid="false">
                        </md-input-container>
                    </div>
                   <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Site Name</label>
                            <input ng-model="sitename" class="ng-pristine ng-valid md-input ng-touched" name="site_name" id="input_00D" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="userForm.site_name.$dirty && userForm.site_name.$invalid">
                            <span ng-show="userForm.site_name.$error.required">Site Name is Required</span>
                        </span>
                    </div>
                 </div>
                </div>
                <div class="row form-group" ng-controller="DatepickerDemoCtrl">
					<div class="col-sm-4">
						<md-input-container flex="" class="md-default-theme">
							<label for="input_00C">Manufactured Date <span style="color:#d1d1d1">(optional)</span></label>
							<input type="text" ng-model="Manufactureddate" name="mfd_date" class="datepicker ng-pristine ng-valid md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened')" ng-focus="open($event,'opened')" is-open="opened" min-date="'01-01-2000'" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>
						</md-input-container>
					</div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00E">Installation Date <span style="color:#d1d1d1">(optional)</span></label>
                            <input type="text" ng-model="Installationdate" name="install_date" class="datepicker ng-pristine ng-valid md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" ng-focus="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false">
                        </md-input-container>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Sale Invoice Date <span style="color:#d1d1d1">(optional)</span></label>
                            <input type="text" ng-model="sale_invoice_date" name="sale_invoice_date" class="datepicker ng-pristine ng-valid md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" ng-focus="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>
                       </md-input-container>
                    </div>
				</div>	
                <div class="row form-group">
                     <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Sale PO Number <span style="color:#d1d1d1">(optional)</span></label>
                            <input type="text" ng-model="po_num" class="ng-pristine ng-valid md-input ng-touched" name="po_num">
                        </md-input-container>
                    </div>
                     <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Sale Invoice Number <span style="color:#d1d1d1">(optional)</span></label>
                            <input type="text" ng-model="sale_invoice_num" class="ng-pristine ng-valid md-input ng-touched" name="sale_invoice_num">
                        </md-input-container>
                    </div>
					<div class="col-sm-4">
						<md-input-container flex="" class="md-default-theme">
							<label for="Autocomplete">Site Address</label>
						   <input ng-model="site_address" placeholder="Site Address" name="site_address" class="ng-pristine ng-valid md-input ng-touched" required="required">
						</md-input-container>
						<span class="help-block" ng-show="userForm.site_address.$dirty && userForm.site_address.$invalid">
							<span ng-show="userForm.site_address.$error.required">Site Address is Required</span>
						</span>
					</div>
				</div>
                <div class="row form-group">
                    <div class="col-sm-4" ng-controller="noofstringsDropCntrl">
                    	<label class="selectlabel">No.Of Strings <span style="color:#d1d1d1">(optional)</span></label>
                        <select class="form-control testSelAll2 selectdrop" ng-model="noofstrings" name="no_of_string">
                            <option value="" selected disabled="disabled">No.Of Strings</option>
                            <option ng-repeat="string in noofstring" value="{{string.name}}">{{string.name}}</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                         <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">First Level Contact Name</label>
                            <input ng-model="sitetechnicianname" class="ng-pristine ng-valid md-input ng-touched" name="technician_name" id="input_00K" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="userForm.technician_name.$dirty && userForm.technician_name.$invalid">
                            <span ng-show="userForm.technician_name.$error.required">Site Technician Name is Required</span>
                        </span>
                    </div>  
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">First Level Contact Number</label>
                            <input ng-model="sitetechniciannumber" class="ng-pristine ng-valid md-input ng-touched" ng-pattern="/^[0-9]{1,10}$/" name="technician_number" id="input_00L" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="userForm.technician_number.$dirty && userForm.technician_number.$invalid">
                            <span ng-show="userForm.technician_number.$error.required">Site Technician Number is Required</span>
                            <span ng-show="userForm.technician_number.$error.pattern">Contact No should be 10 digits only.</span>
                        </span>
                    </div> 
                </div>
                <div class="row form-group">
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Second Level Contact Name</label>
                            <input ng-model="clustermanager" class="ng-pristine ng-valid md-input ng-touched" name="manager_name" id="input_00L" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="userForm.manager_name.$dirty && userForm.manager_name.$invalid">
                            <span ng-show="userForm.manager_name.$error.required">Cluster Manager Name is Required</span>
                        </span>
                    </div> 
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Second Level Contact Number</label>
                            <input ng-model="clustermanagernum" class="ng-pristine ng-valid md-input ng-touched" ng-pattern="/^[0-9]{1,10}$/" name="manager_number" id="input_00L" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="userForm.manager_number.$dirty && userForm.manager_number.$invalid">
                            <span ng-show="userForm.manager_number.$error.required">Cluster Manager Number is Required</span>
                            <span ng-show="userForm.manager_number.$error.pattern">Contact No should be 10 digits only.</span>
                        </span>
                    </div>
                     <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Second Level Contact Email</label>
                            <input type="text" ng-model="clustermanageremail" class="ng-pristine ng-valid md-input ng-touched" name="manager_mail" ng-pattern="/^(([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+([;,.](([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+)*$/" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="userForm.manager_mail.$dirty && userForm.manager_mail.$invalid">
                            <span ng-show="userForm.manager_mail.$error.required">Cluster Manager Email is Required</span>
                            <span ng-show="userForm.manager_mail.$error.pattern">Invalid Email Address</span>
                        </span>
                    </div>
                </div>
			  </div>
<!--OTHER ACTIVITY END-->
                   <div class="row form-group">
                    <div class="col-sm-4">
                        <label class="selectlabel">Nature of Complaint</label>
                            <select id="Firstactivity" class="form-control testSelAll2 selectdrop" name="complaint_alias" ng-model="activity" required>
                                <option value=""  selected="selected" disabled="disabled">Select Nature of Complaint</option>
                                <option ng-repeat="complaint in secondDrop" value="{{complaint.alias}}" ng-selected="complaint.alias == singleViews.complaint_alias">{{complaint.name}}</option>
                            </select>
                            <span class="help-block" ng-show="userForm.complaint_alias.$dirty && userForm.complaint_alias.$invalid">
                                <span ng-show="userForm.complaint_alias.$error.required">Nature of Complaint Required</span>
                            </span>
                        </div>
                        <div ng-controller="mocDropCntrl">
                            <div class="col-sm-4">
                            <label class="selectlabel">MOC</label>
                                <select class="form-control testSelAll2 selectdrop" name="mode_of_contact" id="file_text" ng-model="mode_of_contact" ng-change="mochange()" required>
                                    <option value="" selected disabled="disabled">Select MOC</option>
                                    <option ng-repeat="moc in firstDrop" data-file="{{moc.file}}" data-text="{{moc.text}}" value="{{moc.alias}}">{{moc.name}}</option>
                                </select>
                                <span class="help-block" ng-show="userForm.mode_of_contact.$dirty && userForm.mode_of_contact.$invalid">
                                    <span ng-show="userForm.mode_of_contact.$error.required">MOC Required</span>
                                </span>
                            </div>
                            
                            <div class="col-sm-4" ng-if="this_moc_text == '1'">
                                <md-input-container flex="" class="md-default-theme">
                                    <label for="input_00D">{{this_text_show}} Number</label>
                                    <input ng-model="moc_number" name="moc_number" class="ng-pristine ng-valid md-input ng-touched" id="input_00Q" tabindex="0" aria-invalid="false" required>
                                </md-input-container>
                                <span class="help-block" ng-show="userForm.moc_number.$dirty && userForm.moc_number.$invalid">
                                    <span ng-show="userForm.moc_number.$error.required">{{this_text_show}} Number is Required</span>
                                </span>
                            </div>
                            
							<div class="col-sm-4 filesRow" ng-if="this_moc_file == '1'" ng-controller="fileUploadPrgCtrl">
								 <!--<label class="selectlabel">Mode Of Contact: <span style="color:red;">(Mandatory)</span></label><br /> -->                                                    
								<input value="{{file_name}}" class="form-control uploadFile" placeholder="Upload {{this_text_show}}" disabled="disabled"/>
								<div class="fileUpload btn btn-sm btn-info" tooltip="Choose MOC" tooltip-placement="right">
									<span class="ion ion-upload"></span>
									<input type="file" class="upload uploadBtn" name="moc_file" id="moc_file" onchange="angular.element(this).scope().file_load(this.files,'pdf')"/>
								</div>
								<span class="help-block" ng-show="userForm.moc_file.$dirty && userForm.moc_file.$invalid">
									<span ng-show="userForm.moc_file.$error.required">Upload {{this_text_show}}</span>
								</span>
								<div ng-if="determinateValue >= '100' ? closeloadings() : ''"></div>
								<div class="mb20" ng-if="prg_shw_hde">
									<md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
								</div>
							</div>
                        </div>
                        
                        <div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme">
                                <label for="input_00D">Faulty Cells Count</label>
                                <input type="text"  ng-pattern-restrict="^[0-9]*$" ng-minlength="1" maxlength="4" ng-model="faulty_cell_count" name="faulty_cell_count" class="ng-pristine ng-valid md-input ng-touched" id="input_00Q" tabindex="0" aria-invalid="false" required>
                            </md-input-container>
                            <span class="help-block" ng-show="userForm.faulty_cell_count.$dirty && userForm.faulty_cell_count.$invalid">
                                <span ng-show="userForm.faulty_cell_count.$error.required">Faulty Cells Count is Required</span>
                                <span ng-show="userForm.faulty_cell_count.$error.minlength">Enter valid Faulty Cells Count</span>
                            </span>
                        </div>
                        <div class="col-sm-4">
                            <textarea rows="2" name="description" ng-model="description" class="form-control resize-v" placeholder="Complete Observation" required></textarea>
                            <span class="help-block" ng-show="userForm.description.$dirty && userForm.description.$invalid">
                                <span ng-show="userForm.description.$error.required">Complete Observation is Required</span>
                            </span>
                        </div>
                        <div class="col-sm-4" ng-if="at_ic_enable">
                            <textarea rows="2" name="at_ic_rem" ng-model="at_ic_rem" class="form-control resize-v" placeholder="AT / I&C Remarks" required></textarea>
                            <span class="help-block" ng-show="userForm.at_ic_rem.$dirty && userForm.at_ic_rem.$invalid">
                                <span ng-show="userForm.at_ic_rem.$error.required">AT / I&C Remarks is Required</span>
                            </span>
                        </div>
                        <div class="col-sm-4" ng-if="warranty_enable">
                            <textarea rows="2" name="remarks" ng-model="remarks" class="form-control resize-v" placeholder="Out Of Warranty Remarks" required></textarea>
                            <span class="help-block" ng-show="userForm.remarks.$dirty && userForm.remarks.$invalid">
                                <span ng-show="userForm.remarks.$error.required">Out Of Warranty Remarks is Required</span>
                            </span>
                        </div>
                   </div>
                   <div class="row form-group"> 
                    <div class="col-sm-6 col-sm-offset-5">
                        <button type="submit" click-once class="btn btn-info btn-sm"  ng-disabled="userForm.$invalid || userForm.$pristine">Create</button>
                        <button type="reset" class="btn btn-info btn-sm" ng-click="userForm.$setPristine(); userForm.$setUntouched();">Reset</button>
                    </div>
				</div>
			</form>
		</div>
	</div>
<script>
	setInterval(function(){
		$('.testSelAll2').SumoSelect();
		//$('.testSelAll3').SumoSelect({selectAll:true});
		$('.forms_add').find('.SumoSelect').addClass('singleSelect');
	},0);
</script>