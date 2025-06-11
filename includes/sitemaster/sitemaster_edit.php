<style>
.form-group {margin-bottom:0px !important;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.indent { margin-left: 50px;}
.move-down {margin-top: 100px;}
.pac-container{z-index:9999 !important;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
</style>
<div>
<div ng-controller="siteMasterEditCntl">
<div class="modal-style" ng-controller="warrantycalCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit Site Master</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
	     <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
		<form class="form-horizontal forms_add" reset-directive="singleViews1" name="sitemasterForm" data-went="#/Sitemaster" method="post" url="services/sitemaster/sitemaster_update" ng-submit="sendPost()" novalidate>
           <input type="hidden" name="site_alias" value="{{singleViews1.site_alias}}"/>
			<div class="row form-group" ng-controller="zoneStateCntrl">
				 	<div class="col-sm-4">
                		<label class="selectlabel">Zone</label>
                        <select class="form-control testSelAll2 editselectdrop" name="zone_alias" id="zone" ng-model="zones" ng-change="dep_drop(zones,'state_alias')" ng-init="dep_drop(singleViews1.zone_alias,'state_alias')" required="required">
                            <option value="" selected="selected" disabled="disabled">Select Zone</option>
                            <option ng-repeat="zone in firstDrop" value="{{zone.alias}}" ng-if="zone.alias!='4VTSNSSBM9'" ng-selected="zone.alias == singleViews1.zone_alias">{{zone.name}}</option>
                        </select>
                        <span class="help-block" ng-show="sitemasterForm.zone_alias.$dirty && sitemasterForm.zone_alias.$invalid">
                            <span ng-show="sitemasterForm.zone_alias.$error.required">Select Zone Name</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                		<label class="selectlabel">State</label>
                        <select class="form-control testSelAll2 editselectdrop" name="state_alias" id="state" ng-model="states" ng-change="dep_drop2(states,'district_alias')" ng-init="dep_drop2(singleViews1.state_alias,'district_alias')" required="required">
                            <option value="" disabled="disabled">Select State</option>
                            <option ng-repeat="state in secondDrop" value="{{state.alias}}" ng-selected="state.alias == singleViews1.state_alias">{{state.name}}</option>
                        </select>
                        <span class="help-block" ng-show="sitemasterForm.state_alias.$dirty && sitemasterForm.state_alias.$invalid">
                            <span ng-show="sitemasterForm.state_alias.$error.required">Select State Name</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                		<label class="selectlabel">District</label>
                        <select class="form-control testSelAll2 editselectdrop" name="district_alias" id="district" ng-model="districts" required="required">
                            <option value="" disabled="disabled">Select District</option>
                            <option ng-repeat="district in thirdDrop" value="{{district.alias}}" ng-selected="district.alias == singleViews1.district_alias">{{district.name}}</option>
                        </select>
                        <span class="help-block" ng-show="sitemasterForm.district_alias.$dirty && sitemasterForm.district_alias.$invalid">
                            <span ng-show="sitemasterForm.district_alias.$error.required">Select District Name</span>
                        </span> 
                    </div>
                 </div>
                <div ng-controller="segmentCustSiteCntrl">
                <div class="row form-group">
                    <div class="col-sm-4">
                		<label class="selectlabel">Segment</label>
                         <select class="form-control testSelAll2 editselectdrop" name="segment_alias" ng-model="segments" ng-change="dep_drop(segments,'customer_alias','site_type_alias')" ng-init="dep_drop(singleViews1.segment_alias,'customer_alias','site_type_alias')" required="required">
                            <option value="" selected="" disabled="disabled">Select Segment</option>
                            <option ng-repeat="segment in firstDrop" value="{{segment.alias}}" ng-selected="segment.alias == singleViews1.segment_alias">{{segment.name}}</option>
                        </select>
                        <span class="help-block" ng-show="sitemasterForm.segment_alias.$dirty && sitemasterForm.segment_alias.$invalid">
                            <span ng-show="sitemasterForm.segment_alias.$error.required">Select Segment Name</span>
                        </span> 
                    </div>
                    <div class="col-sm-4">
                		<label class="selectlabel">Customer</label>
                       <select class="form-control testSelAll2 editselectdrop" name="customer_alias" ng-model="customer" ng-change="dep_drop_product(customer)" ng-init="dep_drop_product(singleViews1.customer_alias)" required="required">
                            <option value="" disabled="disabled">Select Customer</option>
                            <option ng-repeat="customer in secondDrop" value="{{customer.alias}}" ng-selected="customer.alias == singleViews1.customer_alias">{{customer.name}}</option>
                        </select>
                        <span class="help-block" ng-show="sitemasterForm.customer_alias.$dirty && sitemasterForm.customer_alias.$invalid">
                            <span ng-show="sitemasterForm.customer_alias.$error.required">Select Customer Name</span>
                        </span> 
                    </div>
                     <div class="col-sm-4">
                		<label class="selectlabel">Site Type</label>
                       <select class="form-control testSelAll2 editselectdrop" name="site_type_alias" ng-model="sitetype" required="required">
                            <option value="" selected="" disabled="disabled">Select Site Type</option>
                            <option ng-repeat="sitetype in thirdDrop" value="{{sitetype.alias}}" ng-selected="sitetype.alias == singleViews1.site_type_alias">{{sitetype.name}}</option>
                        </select>
                        <span class="help-block" ng-show="sitemasterForm.site_type_alias.$dirty && sitemasterForm.site_type_alias.$invalid">
                            <span ng-show="sitemasterForm.site_type_alias.$error.required">Select Site Type</span>
                        </span> 
                    </div>
                 </div>
                <div class="row form-group">
                    <div class="col-sm-4">
                		<label class="selectlabel">Product Code</label>
                        <select class="form-control testSelAll2 editselectdrop" placeholder="Product Code" name="product_alias" ng-model="productcode" required>
							<option value="" disabled="disabled"> Select Product</option>
                            <option ng-repeat="product in productDrop" value="{{product.alias}}" ng-selected="product.alias == singleViews1.product_alias">{{product.name}}</option>
                    	</select>
                        <span class="help-block" ng-show="sitemasterForm.product_alias.$dirty && sitemasterForm.product_alias.$invalid">
                            <span ng-show="sitemasterForm.product_alias.$error.required">Select  Product Code</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
	                    <md-input-container flex="" class="md-default-theme md-input-hasvalue">
                            <label for="input_00H">Battery Bank Rating</label>
                            <input ng-model="singleViews1.battery_bank_rating" name="batt_rating" value="{{mafdates.battery_bank_rating}}">
                        </md-input-container>
                        <span class="help-block" ng-show="sitemasterForm.batt_rating.$dirty && sitemasterForm.batt_rating.$invalid">
                            <span ng-show="sitemasterForm.batt_rating.$error.required">Battery Bank Rating is Required</span>
                        </span>
                    </div>
                     <div class="col-sm-4" ng-controller="noofstringsDropCntrl">
                		<label class="selectlabel">No.Of Strings</label>
                        <select class="form-control testSelAll2 editselectdrop" ng-model="noofstrings" name="no_of_string" required="required">
                            <option value="" selected disabled="disabled">No.Of Strings</option>
                            <option ng-repeat="string in noofstring" value="{{string.name}}" ng-selected="string.name == singleViews1.no_of_string">{{string.name}}</option>
                        </select>
                        <span class="help-block" ng-show="sitemasterForm.no_of_string.$dirty && sitemasterForm.no_of_string.$invalid">
                            <span ng-show="sitemasterForm.no_of_string.$error.required">Select No.Of Strings</span>
                        </span>
                    </div>
			  </div>
                </div>
                <div class="row form-group" ng-controller="DatepickerDemoCtrl">
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Site Id</label>
                            <input value="{{singleViews1.site_id}}" ng-model="singleViews1.site_id" name="site_id" class="ng-pristine ng-valid md-input ng-touched" id="input_00B" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="sitemasterForm.site_id.$dirty && sitemasterForm.site_id.$invalid">
                            <span ng-show="sitemasterForm.site_id.$error.required">Site ID is Required</span>
                        </span>
                    </div>
                	<div class="col-sm-4">
                        <md-input-container flex="dsffdfds" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Site Name</label>
                            <input value="{{singleViews1.site_name}}" ng-model="singleViews1.site_name" name="site_name" class="ng-pristine ng-valid md-input ng-touched" id="input_00D" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="sitemasterForm.site_name.$dirty && sitemasterForm.site_name.$invalid">
                            <span ng-show="sitemasterForm.site_name.$error.required">Site Name is Required</span>
                        </span>
                    </div>
                	<div>
                        <div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme">
                                <label for="Autocomplete">Site Address</label>
                               <input ng-model="singleViews1.site_address" name="site_address" class="ng-pristine ng-valid md-input ng-touched" required="required" details="details1" options="options1" value="{{singleViews1.site_address}}" >
                            </md-input-container>
                            <span class="help-block" ng-show="sitemasterForm.site_address.$dirty && sitemasterForm.site_address.$invalid">
                                <span ng-show="sitemasterForm.site_address.$error.required">Site Address is Required</span>
                            </span>
                       </div>
                   </div>
                   
                   <div class="row form-group">
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Sale PO Number</label>
                            <input type="text" name="po_num" value="{{singleViews1.po_num}}" ng-model="singleViews1.po_num" class="ng-pristine ng-valid md-input ng-touched" id="input_00D" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="sitemasterForm.po_num.$dirty && sitemasterForm.po_num.$invalid">
                            <span ng-show="sitemasterForm.po_num.$error.required">Sale PO Number is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Sale Invoice Number</label>
                            <input type="text" name="sale_invoice_num" value="{{singleViews1.sale_invoice_num}}" ng-model="singleViews1.sale_invoice_num" class="ng-pristine ng-valid md-input ng-touched" id="input_00D" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="sitemasterForm.sale_invoice_num.$dirty && sitemasterForm.sale_invoice_num.$invalid">
                            <span ng-show="sitemasterForm.sale_invoice_num.$error.required">Sale Invoice Number is Required</span>
                        </span>
                    </div>
                   
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Sale Invoice Date</label>
                            <input type="text" name="sale_invoice_date" value="{{singleViews1.sale_invoice_date}}" ng-model="singleViews1.sale_invoice_date" class="datepicker border-bottom" id="input_00D" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt"  datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="manfdatescal('warr','warr','warr');open($event,'opened1')"/>
                       </md-input-container>
                    </div>
                </div>
                
                
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Manufactured Date</label>
                            <input type="text" name="mfd_date" value="{{singleViews1.mfd_date}}" ng-model="singleViews1.mfd_date" class="datepicker border-bottom" id="input_00D" placeholder="Select date.." datepicker-popup="{{format}}" min-date="minDate" max-date="dt"  datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>
                       </md-input-container>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00E">Installation Date</label>
                            <input type="text" name="install_date" value="{{singleViews1.install_date}}" ng-model="singleViews1.install_date" class="datepicker border-bottom" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="manfdatescal('warr','warr','warr');open($event,'opened2')" data-ng-init="manfdatescal(singleViews1.customer_alias,singleViews1.mfd_date,singleViews1.install_date);">
                        </md-input-container>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">First Level Contact Name</label>
                            <input name="technician_name" value="{{singleViews1.technician_name}}" ng-model="singleViews1.technician_name" class="ng-pristine ng-valid md-input ng-touched" id="input_00D" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="sitemasterForm.technician_name.$dirty && sitemasterForm.technician_name.$invalid">
                            <span ng-show="sitemasterForm.technician_name.$error.required">Site Technician Name is Required</span>
                        </span>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">First Level Contact Number</label>
                            <input type="text" name="technician_number" valid-input="10" value="{{singleViews1.technician_number}}" ng-model="singleViews1.technician_number" class="ng-pristine ng-valid md-input ng-touched" id="input_00D" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="sitemasterForm.technician_number.$dirty && sitemasterForm.technician_number.$invalid">
                            <span ng-show="sitemasterForm.technician_number.$error.required">Site Technician Number is Required</span>
                            <span ng-show="sitemasterForm.technician_number.$error.minlength">Enter valid Contact No</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Second Level Contact Name</label>
                            <input name="manager_name" value="{{singleViews1.manager_name}}" ng-model="singleViews1.manager_name" class="ng-pristine ng-valid md-input ng-touched" id="input_00D" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="sitemasterForm.manager_name.$dirty && sitemasterForm.manager_name.$invalid">
                            <span ng-show="sitemasterForm.manager_name.$error.required">Cluster Manager Name is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Second Level Contact Number</label>
                            <input type="text" name="manager_number" valid-input="10" value="{{singleViews1.manager_number}}" ng-model="singleViews1.manager_number" class="ng-pristine ng-valid md-input ng-touched" id="input_00D" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="sitemasterForm.manager_number.$dirty && sitemasterForm.manager_number.$invalid">
                            <span ng-show="sitemasterForm.manager_number.$error.required">Cluster Manager Number is Required</span>
                            <span ng-show="sitemasterForm.manager_number.$error.minlength">Enter valid Contact No</span>
                        </span>
                    </div>
                </div>
                <div class="row form-group">
                     <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Second Level Contact Email</label>
                            <input type="text" name="manager_mail" value="{{singleViews1.manager_mail}}" ng-model="singleViews1.manager_mail" class="ng-pristine ng-valid md-input ng-touched" ng-pattern="/^(([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+([;,.](([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+)*$/" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="sitemasterForm.manager_mail.$dirty && sitemasterForm.manager_mail.$invalid">
                            <span ng-show="sitemasterForm.manager_mail.$error.required">Cluster Manager Email is Required</span>
                            <span ng-show="sitemasterForm.manager_mail.$error.pattern">Invalid Email Address</span>
                        </span>
                    </div>
                   <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-hasvalue">
                            <label for="input_00F">Preventive Maintenance Schedule</label>
                            <input ng-model="mafdates.schedule" readonly="readonly" value="{{mafdates.schedule}}" >
                        </md-input-container>
                    </div> 
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-hasvalue">
                            <label for="input_00G">Warranty Months</label>
                            <input ng-model="mafdates.warrantymonths" readonly="readonly" value="{{mafdates.warrantymonths}}">
                        </md-input-container>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-hasvalue">
                            <label for="input_00H">Warranty Left</label>
                            <input ng-model="mafdates.warrantyleft" readonly="readonly" value="{{mafdates.warrantyleft}}">
                        </md-input-container>
                    </div>
                    <div class="col-sm-4">
	                    <md-input-container flex="" class="md-default-theme md-input-hasvalue">
                            <label for="input_00H">Site Status</label>
                            <input ng-model="mafdates.warrantystatus" readonly="readonly" value="{{singleViews1.site_status}}">
                        </md-input-container>
                    </div>
                </div>
               <div class="row form-group">
				 <div class="col-sm-6 col-sm-offset-5 mt10">
                        <button type="submit" click-once class="btn btn-info btn-sm"
                        ng-disabled="sitemasterForm.zone_alias.$dirty && sitemasterForm.zone_alias.$invalid ||
                        sitemasterForm.state_alias.$dirty && sitemasterForm.state_alias.$invalid ||
                        sitemasterForm.district_alias.$dirty && sitemasterForm.district_alias.$invalid ||
                        sitemasterForm.segment_alias.$dirty && sitemasterForm.segment_alias.$invalid ||
                        sitemasterForm.customer_alias.$dirty && sitemasterForm.customer_alias.$invalid ||
                        sitemasterForm.po_num.$dirty && sitemasterForm.po_num.$invalid ||
                        sitemasterForm.sale_invoice_num.$dirty && sitemasterForm.sale_invoice_num.$invalid ||
                        sitemasterForm.sale_invoice_date.$dirty && sitemasterForm.sale_invoice_date.$invalid ||
                        sitemasterForm.site_type_alias.$dirty && sitemasterForm.site_type_alias.$invalid ||
                        sitemasterForm.site_id.$dirty && sitemasterForm.site_id.$invalid ||
                        sitemasterForm.site_name.$dirty && sitemasterForm.site_name.$invalid ||
                        sitemasterForm.site_address.$dirty && sitemasterForm.site_address.$invalid ||
                        sitemasterForm.product_alias.$dirty && sitemasterForm.product_alias.$invalid ||
                        sitemasterForm.no_of_string.$dirty && sitemasterForm.no_of_string.$invalid ||
                        sitemasterForm.technician_name.$dirty && sitemasterForm.technician_name.$invalid ||
                        sitemasterForm.technician_number.$dirty && sitemasterForm.technician_number.$invalid ||
                        sitemasterForm.manager_name.$dirty && sitemasterForm.manager_name.$invalid ||
                        sitemasterForm.manager_number.$dirty && sitemasterForm.manager_number.$invalid ||
                        sitemasterForm.batt_rating.$dirty && sitemasterForm.batt_rating.$invalid ||
                        sitemasterForm.manager_mail.$dirty && sitemasterForm.manager_mail.$invalid">Update</button>
                        <button type="reset" class="btn btn-info btn-sm" ng-click="sitemasterForm.$setPristine(); sitemasterForm.$setUntouched();">Reset</button>
                </div>
			</div>
		</form>
	</div>
</div>
</div>
</div>
<script>
setInterval(function(){
	$('.testSelAll2').SumoSelect();
	$('.forms_add').find('.SumoSelect').addClass('singleSelect');
},0);
</script>