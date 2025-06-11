<style>
.form-group {margin-bottom:0px !important;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.indent { margin-left: 50px;}
.move-down { margin-top: 100px;}
.pac-container{z-index:9999 !important;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
.selectdrop {overflow-y: scroll;}
</style>
<div>
<div ng-controller="warrantycalCtrl">
<div class="modal-style" ng-controller="zoneStateCntrl">
	<div class="modal-header clearfix">
		<h4 class="modal-title">Create Site Master</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
     <!--<div class="toast toast-topRight">
        <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
            <div ng-bind-html="toast.msg"></div>
        </alert>
    </div>-->
     <form class="form-horizontal forms_add" name="sitemasterForm" data-went="#/Sitemaster" method="post" url="services/sitemaster/sitemaster_add" ng-submit="sendPost()" novalidate>
                <div class="row form-group">
                    <div class="col-sm-4">
                    <label class="selectlabel">Zone</label>
                        <select class="form-control testSelAll2 selectdrop" name="zone_alias" id="zone" ng-model="zones" ng-change="dep_drop(zones,'state_alias')" required="required">
                            <option value="" selected="selected"  disabled="disabled">Select Zone</option>
                            <option ng-repeat="zone in firstDrop" value="{{zone.alias}}" ng-if="zone.alias!='4VTSNSSBM9'">{{zone.name}}</option>
                        </select>
                        <span class="help-block" ng-show="sitemasterForm.zone_alias.$dirty && sitemasterForm.zone_alias.$invalid">
                            <span ng-show="sitemasterForm.zone_alias.$error.required">Select Zone Name</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                    <label class="selectlabel">State</label>
                        <select class="form-control testSelAll2 selectdrop" name="state_alias" id="state" ng-model="states" ng-change="dep_drop2(states,'district_alias')" required="required">
                            <option value="" selected="selected"  disabled="disabled">Select State</option>
                            <option ng-repeat="state in secondDrop" value="{{state.alias}}">{{state.name}}</option>
                        </select>
                        <span class="help-block" ng-show="sitemasterForm.state_alias.$dirty && sitemasterForm.state_alias.$invalid">
                            <span ng-show="sitemasterForm.state_alias.$error.required">Select State Name</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                    <label class="selectlabel">District</label>
                        <select class="form-control testSelAll2 selectdrop" name="district_alias" id="district" ng-model="districts" required="required">
                            <option value="" selected="selected"  disabled="disabled">Select District</option>
                            <option ng-repeat="district in thirdDrop" value="{{district.alias}}">{{district.name}}</option>
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
                         <select class="form-control testSelAll2 selectdrop" name="segment_alias" ng-model="segments" ng-change="dep_drop(segments,'customer_alias','site_type_alias')" required="required">
                            <option value="" selected="" disabled="disabled">Select Segment</option>
                            <option ng-repeat="segment in firstDrop" value="{{segment.alias}}">{{segment.name}}</option>
                        </select>
                        <span class="help-block" ng-show="sitemasterForm.segment_alias.$dirty && sitemasterForm.segment_alias.$invalid">
                            <span ng-show="sitemasterForm.segment_alias.$error.required">Select Segment Name</span>
                        </span> 
                    </div>
                    <div class="col-sm-4">
                    <label class="selectlabel">Customer</label>
                        <select class="form-control testSelAll2 selectdrop" name="customer_alias" ng-model="customer" required="required" ng-change="dep_drop_product(customer)">
                            <option value="" selected="" disabled="disabled">Select Customer</option>
                            <option ng-repeat="customer in secondDrop" value="{{customer.alias}}">{{customer.name}}</option>
                        </select>
                        <span class="help-block" ng-show="sitemasterForm.customer_alias.$dirty && sitemasterForm.customer_alias.$invalid">
                            <span ng-show="sitemasterForm.customer_alias.$error.required">Select Customer Name</span>
                        </span> 
                        
                    </div>
                    <div class="col-sm-4">
                    <label class="selectlabel">Site Type</label>
                        <select class="form-control testSelAll2 selectdrop" name="site_type_alias" ng-model="sitetype" required="required">
                            <option value="" selected="" disabled="disabled">Select Site Type</option>
                            <option ng-repeat="sitetype in thirdDrop" value="{{sitetype.alias}}">{{sitetype.name}}</option>
                        </select>
                        <span class="help-block" ng-show="sitemasterForm.site_type_alias.$dirty && sitemasterForm.site_type_alias.$invalid">
                            <span ng-show="sitemasterForm.site_type_alias.$error.required">Select Site Type</span>
                        </span> 
                    </div>
                 </div>   
                 <div class="row form-group">
                     <div class="col-sm-4" ng-class="{'has-error' : submitted && sitemasterForm.product_alias.$invalid}">
                     <label class="selectlabel">Product Code</label>
                        <select class="form-control testSelAll2 selectdrop" placeholder="Product Code" name="product_alias" ng-model="productcode" required>
                            <option value="" disabled="disabled">Select Product Code</option>
							<option ng-repeat="product in productDrop" value="{{product.alias}}">{{product.name}}</option>
                    	</select>
                         <span class="help-block" ng-show="sitemasterForm.product_alias.$dirty && sitemasterForm.product_alias.$invalid">
                            <span ng-show="sitemasterForm.product_alias.$error.required">Select Product Code</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Battery Bank Rating</label>
                            <input ng-model="battery_bank_rating" name="batt_rating" class="ng-pristine ng-valid md-input ng-touched" id="input_00N" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="sitemasterForm.batt_rating.$dirty && sitemasterForm.batt_rating.$invalid">
                            <span ng-show="sitemasterForm.batt_rating.$error.required">Battery Bank Rating is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-4" ng-controller="noofstringsDropCntrl">
                    	<label class="selectlabel">No.Of Strings</label>
                        <select class="form-control testSelAll2 selectdrop" ng-model="noofstrings" name="no_of_string" required="required">
                            <option value="" selected disabled="disabled">No.Of Strings</option>
                            <option ng-repeat="string in noofstring" value="{{string.name}}">{{string.name}}</option>
                        </select>
                        <span class="help-block" ng-show="sitemasterForm.no_of_string.$dirty && sitemasterForm.no_of_string.$invalid">
                            <span ng-show="sitemasterForm.no_of_string.$error.required">Select No.Of Strings</span>
                        </span>
                    </div>
                 </div>
                </div>
                  <div class="row form-group" ng-controller="DatepickerDemoCtrl"> 
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Site Id</label>
                            <input ng-model="siteid" class="ng-pristine ng-valid md-input ng-touched" name="site_id" id="input_00C" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="sitemasterForm.site_id.$dirty && sitemasterForm.site_id.$invalid">
                            <span ng-show="sitemasterForm.site_id.$error.required">Site ID is Required</span>
                        </span>
                    </div>
                   <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Site Name</label>
                            <input ng-model="sitename" class="ng-pristine ng-valid md-input ng-touched" name="site_name" id="input_00D" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="sitemasterForm.site_name.$dirty && sitemasterForm.site_name.$invalid">
                            <span ng-show="sitemasterForm.site_name.$error.required">Site Name is Required</span>
                        </span>
                    </div>
                  	<div>
                        <div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme">
                                <label for="Autocomplete">Site Address</label>
                               <input ng-model="site_address" placeholder="Site Address" name="site_address" class="ng-pristine ng-valid md-input ng-touched" required="required">
                            </md-input-container>
                            <span class="help-block" ng-show="sitemasterForm.site_address.$dirty && sitemasterForm.site_address.$invalid">
                                <span ng-show="sitemasterForm.site_address.$error.required">Site Address is Required</span>
                            </span>
                        </div>
                 	</div>
                    <div class="row form-group">
                     <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Sale PO Number</label>
                            <input type="text" ng-model="po_num" class="ng-pristine ng-valid md-input ng-touched" name="po_num" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="sitemasterForm.po_num.$dirty && sitemasterForm.po_num.$invalid">
                            <span ng-show="sitemasterForm.po_num.$error.required">Sale PO Number is Required</span>
                        </span>
                    </div>
                     <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Sale Invoice Number</label>
                            <input type="text" ng-model="sale_invoice_num" class="ng-pristine ng-valid md-input ng-touched" name="sale_invoice_num" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="sitemasterForm.sale_invoice_num.$dirty && sitemasterForm.sale_invoice_num.$invalid">
                            <span ng-show="sitemasterForm.sale_invoice_num.$error.required">Sale Invoice Number is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Sale Invoice Date</label>
                            <input type="text" ng-model="sale_invoice_date" name="sale_invoice_date" class="datepicker ng-pristine ng-valid md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="manfdatescal('warr','warr','warr');open($event,'opened1')"/>
                       </md-input-container>
                    </div>
                </div>
					<div class="col-sm-4">
						<md-input-container flex="" class="md-default-theme">
							<label for="input_00C">Manufactured Date</label>
							<input type="text" ng-model="Manufactureddate" name="mfd_date" class="datepicker ng-pristine ng-valid md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened')" ng-focus="open($event,'opened')" is-open="opened" min-date="'01-01-2000'" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>
						</md-input-container>
					</div>	
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00E">Installation Date</label>
                            <input type="text" ng-model="Installationdate" name="install_date" class="datepicker ng-pristine ng-valid md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="manfdatescal('warr','warr','warr');open($event,'opened2')">
                        </md-input-container>
                    </div>
                    <div class="col-sm-4">
                         <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">First Level Contact Name</label>
                            <input ng-model="sitetechnicianname" class="ng-pristine ng-valid md-input ng-touched" name="technician_name" id="input_00K" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="sitemasterForm.technician_name.$dirty && sitemasterForm.technician_name.$invalid">
                            <span ng-show="sitemasterForm.technician_name.$error.required">Site Technician Name is Required</span>
                        </span>
                    </div>
                </div>
                <div class="row form-group">  
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">First Level Contact Number</label>
                            <input type="text" ng-model="sitetechniciannumber" valid-input="10" class="ng-pristine ng-valid md-input ng-touched" name="technician_number" id="input_00L" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="sitemasterForm.technician_number.$dirty && sitemasterForm.technician_number.$invalid">
                            <span ng-show="sitemasterForm.technician_number.$error.required">Site Technician Number is Required</span>
                            <span ng-show="sitemasterForm.technician_number.$error.minlength">Enter valid Contact No</span>
                        </span>
                    </div> 
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Second Level Contact Name</label>
                            <input ng-model="clustermanager" class="ng-pristine ng-valid md-input ng-touched" name="manager_name" id="input_00L" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="sitemasterForm.manager_name.$dirty && sitemasterForm.manager_name.$invalid">
                            <span ng-show="sitemasterForm.manager_name.$error.required">Cluster Manager Name is Required</span>
                        </span>
                    </div> 
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Second Level Contact Number</label>
                            <input type="text" ng-model="clustermanagernum" valid-input="10" class="ng-pristine ng-valid md-input ng-touched" name="manager_number" id="input_00L" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="sitemasterForm.manager_number.$dirty && sitemasterForm.manager_number.$invalid">
                            <span ng-show="sitemasterForm.manager_number.$error.required">Cluster Manager Number is Required</span>
                            <span ng-show="sitemasterForm.manager_number.$error.minlength">Enter valid Contact No</span>
                        </span>
                    </div>
                </div>
                <div class="row form-group">
                     <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Second Level Contact Email</label>
                            <input type="text" ng-model="clustermanageremail" class="ng-pristine ng-valid md-input ng-touched" name="manager_mail" ng-pattern="/^(([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+([;,.](([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+)*$/" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="sitemasterForm.manager_mail.$dirty && sitemasterForm.manager_mail.$invalid">
                            <span ng-show="sitemasterForm.manager_mail.$error.required">Cluster Manager Email is Required</span>
                            <span ng-show="sitemasterForm.manager_mail.$error.pattern">Invalid Email Address</span>
                        </span>
                    </div>
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
                </div>
                <div class="row form-group"> 
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Warranty Left</label>
                            <input ng-model="mafdates.warrantyleft" readonly="readonly" value="{{mafdates.warrantyleft}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00P" tabindex="0" aria-invalid="false">
                        </md-input-container>
                    </div>				
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Site Status</label>
                            <input ng-model="mafdates.warrantystatus" readonly="readonly" value="{{mafdates.warrantystatus}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00N" tabindex="0" aria-invalid="false">
                        </md-input-container>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-6 col-sm-offset-5 mt10">
                            <button type="submit" click-once class="btn btn-info btn-sm" ng-disabled="sitemasterForm.$invalid || sitemasterForm.$pristine">Create</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="sitemasterForm.$setPristine(); sitemasterForm.$setUntouched();">Reset</button>
                    </div>
               </div>
          </form> 
	</div>
</div>
</div>
</div>
<script>
setInterval(function(){$('.testSelAll2').SumoSelect();
$('.forms_add').find('.SumoSelect').addClass('singleSelect');},0);
</script>