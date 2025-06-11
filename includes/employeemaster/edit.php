<style>
.editselectdrop{overflow-y:scroll;}
.form-group {margin-bottom:0px !important;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.upload-file{border-bottom: 1px solid rgba(0,0,0,0.12); padding-top:9px;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
</style>
<div>
<div class="modal-style" ng-controller="employeeMasterEditCntl">
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit Employee Master</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
	<div ng-controller="departmentdropCntrl">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
		<form class="form-horizontal forms_add" reset-directive="singleViews" name="empmasterForm" data-went="#/Employeemaster" method="post" url="services/employeemaster/employeemaster_update" ng-submit="sendPost()" enctype="multipart/form-data" novalidate>
            <input name="employee_alias" value="{{singleViews.employee_alias}}" type="hidden">
            <div class="row form-group">
            	<div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00A">Employee ID</label>
                        <input value="{{singleViews.employee_id}}" name="emp_id" ng-model="singleViews.employee_id" class="ng-pristine ng-valid md-input ng-touched" id="input_00A" tabindex="0" aria-invalid="false" required>
                    </md-input-container>
                     <span class="help-block" ng-show="empmasterForm.emp_id.$dirty && empmasterForm.emp_id.$invalid">
                        <span ng-show="empmasterForm.emp_id.$error.required">Employee ID is Required</span>
                    </span>
				</div>
                <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Employee Name</label>
                        <input value="{{singleViews.name}}" name="name" ng-model="singleViews.name" class="ng-pristine ng-valid md-input ng-touched" id="input_00B" tabindex="0" aria-invalid="false" required>
                    </md-input-container>
                    <span class="help-block" ng-show="empmasterForm.name.$dirty && empmasterForm.name.$invalid">
                        <span ng-show="empmasterForm.name.$error.required">Employee Name is Required</span>
                    </span>
				</div>
                <div class="col-sm-4">
                	<label class="selectlabel">Department</label>
                    <select class="form-control testSelAll2 editselectdrop" name="department_alias" ng-model="department" ng-init="department=singleViews.department_alias" required>
                        <option value="" selected="" disabled="disabled">Department</option>
                        <option ng-repeat="department in firstDrop" value="{{department.alias}}" ng-selected="department.alias == singleViews.department_alias">{{department.name}}</option>
                    </select>
                     <span class="help-block" ng-show="empmasterForm.department_alias.$dirty && empmasterForm.department_alias.$invalid">
                        <span ng-show="empmasterForm.department_alias.$error.required">Select Department</span>
                    </span>
				</div>
           </div> 
             <div class="row form-group"> 
                 <div class="col-sm-4" ng-controller="designationdropCntrl">
                	<label class="selectlabel">Designation</label>
                    <select class="form-control testSelAll2 editselectdrop" name="designation_alias" ng-model="designation" required>
                        <option value="" selected="" disabled="disabled">Designation</option>
                        <option ng-repeat="designation in firstDrop" value="{{designation.alias}}" ng-selected="designation.alias == singleViews.designation_alias">{{designation.name}}</option>
                    </select>            
                     <span class="help-block" ng-show="empmasterForm.designation_alias.$dirty && empmasterForm.designation_alias.$invalid">
                        <span ng-show="empmasterForm.designation_alias.$error.required">Select Designation</span>
                    </span>           
				</div>
				<div class="col-sm-4">
					<md-input-container flex="" class="md-default-theme md-input-has-value">
						<label for="input_00E">Base Location</label>
						<input value="{{singleViews.base_location}}" ng-model="singleViews.base_location" name="base_location" class="ng-pristine ng-valid md-input ng-touched" id="input_00E" tabindex="0" aria-invalid="false" required="required">
					</md-input-container>
					<span class="help-block" ng-show="empmasterForm.base_location.$dirty && empmasterForm.base_location.$invalid">
						<span ng-show="empmasterForm.base_location.$error.required">Base Location is Required</span>
					</span>
				</div>
				<div class="col-sm-4">
					<md-input-container flex="" class="md-default-theme md-input-has-value">
						<label for="input_00D">Email</label>
						<input value="{{singleViews.email_id}}" ng-model="singleViews.email_id" name="email_id" class="ng-pristine ng-valid md-input ng-touched" ng-pattern="/^(([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+([;,.](([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+)*$/" required="required">
					</md-input-container>
					<span class="help-block" ng-show="empmasterForm.email_id.$dirty && empmasterForm.email_id.$invalid">
						<span ng-show="empmasterForm.email_id.$error.required">Login Email is Required</span>
						<span ng-show="empmasterForm.email_id.$error.pattern">Invalid Email Address</span>
					</span>
				</div>
             </div>  
              <div class="row form-group"ng-controller="zoneStateMulCntrl">
                <div class="col-sm-4">
                    <label class="selectlabel">Zone</label>
                    <select multiple="multiple" placeholder="Zone" name="zone_alias[]" class="testSelAll3 form-control" ng-model="zones" ng-init="dep_drop(singleViews.zone_alias,'state_alias[]')" data-ng-change="dep_drop_mul()" required="required">
                        <option ng-repeat="zone in firstDrop" value="{{zone.alias}}" ng-selected="singleViews.zone_alias.indexOf(zone.alias) != -1">{{zone.name}}</option>
                    </select>
                     <span class="help-block" ng-show="empmasterForm['zone_alias[]'].$dirty && empmasterForm['zone_alias[]'].$invalid">
                        <span ng-show="empmasterForm['zone_alias[]'].$error.required">Select Zone</span>
                    </span>
                </div>
                <div class="col-sm-4" ng-class="{'has-error' : submitted && empmasterForm.state_alias.$invalid}">
                    <label class="selectlabel">State</label>
                    <select class="form-control testSelAll3" placeholder="State" name="state_alias[]" id="state" ng-model="states" multiple="multiple" ng-init="dep_drop2(singleViews.state_alias,'wh_alias[]')" data-ng-change="state_wh_mul(states)" required="required">
                        <option ng-repeat="state in secondDrop" value="{{state.alias}}" ng-selected="singleViews.state_alias.indexOf(state.alias) != -1">{{state.name}}</option>
                    </select>
                     <span class="help-block" ng-show="empmasterForm['state_alias[]'].$dirty && empmasterForm['state_alias[]'].$invalid">
                        <span ng-show="empmasterForm['state_alias[]'].$error.required">Select State</span>
                    </span>
                </div>
                  <div class="col-sm-4">
                        <label class="selectlabel">Wh Code <span style="color:#d1d1d1">(optional)</span></label>
                        <select class="form-control testSelAll3" placeholder="Wharehouse Code" name="wh_alias[]" id="whcode" ng-model="warehouse" multiple="multiple">
                            <option ng-repeat="warehouse in thirdDrop" value="{{warehouse.alias}}" ng-selected="singleViews.wh_alias.indexOf(warehouse.alias) != -1">{{warehouse.name}}</option>
                        </select>
                    </div>
               </div> 
              <div class="row form-group"ng-controller="segmentCustMuldropCntrl">
                <div class="col-sm-4">
                    <label class="selectlabel">Segment <span style="color:#d1d1d1">(optional)</span></label>
                    <select multiple="multiple" placeholder="Segment" name="segment_alias[]" class="testSelAll3 form-control" ng-model="segment_alias" ng-init="dep_drop(singleViews.segment_alias,'state_alias[]')" data-ng-change="dep_drop_mul(segment_alias)">
                        <option ng-repeat="seg in firstDrop" value="{{seg.alias}}" ng-selected="singleViews.segment_alias.indexOf(seg.alias) != -1">{{seg.name}}</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <label class="selectlabel">Customer <span style="color:#d1d1d1">(optional)</span></label>
                    <select class="form-control testSelAll3" placeholder="Customer" name="customer_alias[]" id="Customer" ng-model="customer_alias" multiple="multiple">
                        <option ng-repeat="cust in secondDrop" value="{{cust.alias}}" ng-selected="singleViews.customer_alias.indexOf(cust.alias) != -1">{{cust.name}}</option>
                    </select>
                </div>
				<div class="col-sm-4">
					<md-input-container flex="" class="md-default-theme md-input-has-value">
						<label for="input_00C">Contact No{{empmasterForm.mobile_number.$dirty}}{{empmasterForm.mobile_number.$invalid}}</label>
						<input type="text" value="{{singleViews.mobile_number}}" valid-input="10" ng-model="singleViews.mobile_number" name="mobile_number" class="ng-pristine ng-valid md-input ng-touched" id="input_00C" tabindex="0" required="required">
					</md-input-container>
					<span class="help-block" ng-show="empmasterForm.mobile_number.$dirty && empmasterForm.mobile_number.$invalid">
						<span ng-show="empmasterForm.mobile_number.$error.required">Contact No is Required</span>
						<span ng-show="empmasterForm.mobile_number.$error.minlength">Enter valid Contact No</span>
					</span>
				</div>
               </div> 
              	<div class="row form-group"> 
                    <div class="col-sm-4" ng-controller="qualifDropCntrl">
                        <label class="selectlabel">Qualification</label>
                        <select class="form-control testSelAll2 editselectdrop" ng-model="qualification" name="qualification" required="required">
                            <option value="" selected disabled="disabled">Qualification</option>
                            <option ng-repeat="qualif in qualifications" value="{{qualif.name}}" ng-selected="qualif.name == singleViews.qualification">{{qualif.name}}</option>
                        </select>
                        <span class="help-block" ng-show="empmasterForm.qualification.$dirty && empmasterForm.qualification.$invalid">
                            <span ng-show="empmasterForm.qualification.$error.required">Select Qualification</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00C">Specialization</label>
                            <input value="{{singleViews.specialization}}" ng-model="singleViews.specialization" name="specialization" class="ng-pristine ng-valid md-input ng-touched" id="input_00C" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="empmasterForm.specialization.$dirty && empmasterForm.specialization.$invalid">
                            <span ng-show="empmasterForm.specialization.$error.required">Specialization is Required</span>
                        </span>
					</div>
                 	<div class="col-sm-4">
                       <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00A">Total Experience</label>
                            <input value="{{singleViews.total_experience}}" ng-model="singleViews.total_experience" ng-pattern="/^(?=.)([+-]?([0-9]*)(\.([0-9]+))?)$/" name="total_experience" class="ng-pristine ng-valid md-input ng-touched" required>
                        </md-input-container>
                        <span class="help-block" ng-show="empmasterForm.total_experience.$dirty && empmasterForm.total_experience.$invalid">
                            <span ng-show="empmasterForm.total_experience.$error.required">Total Experience is Required</span>
                            <span ng-show="empmasterForm.total_experience.$error.pattern">Total Experience should be digits only</span>
                        </span>
                    </div>
                </div>
                <div class="row form-group">
                    <div ng-controller="DatepickerDemoCtrl">
                        <div class="col-sm-4">
                              <md-input-container flex="" class="md-default-theme md-input-has-value">
                                <label for="input_00D">Joining Date</label>
                                <input type="text" value="{{singleViews.joining_date}}" ng-model="singleViews.joining_date" name="joining_date" class="datepicker border-bottom ng-pristine ng-valid md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" ng-focus="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" required="required" ng-focus="fromtocal()"/>
                             </md-input-container>
                            <span class="help-block" ng-show="empmasterForm.joining_date.$dirty && empmasterForm.joining_date.$invalid">
                                <span ng-show="empmasterForm.joining_date.$error.required">Joining Date is Required</span>
								<span ng-show="empmasterForm.joining_date.$invalid">Date should be (ex:dd-mm-yyyy) only</span>
                            </span>
                        </div>
                        <div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme md-input-has-value">
                                <label for="input_00D">Relieving Date <span style="color:#d1d1d1">(optional)</span></label>
                                <input type="text" value="{{singleViews.relieving_date}}" ng-model="singleViews.relieving_date" name="relieving_date" class="datepicker ng-pristine ng-valid md-input ng-touched" placeholder="Select date.."  datepicker-popup="{{format}}" ng-click="open($event,'opened2')" ng-focus="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="dateDiff" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" ng-change="workingstatus()"/>
                            </md-input-container>
							<span class="help-block" ng-show="empmasterForm.relieving_date.$dirty && empmasterForm.relieving_date.$invalid">
                                <span ng-show="empmasterForm.relieving_date.$invalid">Date should be (ex:dd-mm-yyyy) only</span>
                            </span>
                        </div>
                    </div>
					<div class="col-sm-4" ng-controller="privilagesdropCntrl">
						<label class="selectlabel">Privilages</label>
						 <select class="form-control testSelAll2 editselectdrop" name="privilege_alias" ng-model="privilages" required>
							<option value="" selected="" disabled="disabled">Privilages</option>
							<option ng-repeat="privilages in firstDrop" value="{{privilages.alias}}" ng-selected="privilages.alias == singleViews.privilege_alias">{{privilages.name}}</option>
						</select>
						<span class="help-block" ng-show="empmasterForm.privilege_alias.$dirty && empmasterForm.privilege_alias.$invalid">
							<span ng-show="empmasterForm.privilege_alias.$error.required">Select Privilages</span>
						</span>
					</div>
                  </div>
                  
                  	<div class="row form-group">
                        <div ng-controller="emproledropCntrl">
                           <!--<div class="col-sm-4">
                                <label class="selectlabel">Employee Role</label>
                                 <select class="form-control testSelAll2 editselectdrop" name="role_alias" ng-model="emprole" ng-init="emprole=singleViews.role_alias" required>
                                    <option value="" selected="" disabled="disabled">Employee Role</option>-->
									<!--<option ng-if="(singleViews.department_alias=='TTTCL87RPU' || department == 'TTTCL87RPU')" ng-repeat="emprole in firstDrop" ng-selected="emprole.alias == singleViews.role_alias" value="{{emprole.alias}}">{{emprole.name}}</option>
									<option ng-if="(singleViews.department_alias!='TTTCL87RPU' || department != 'TTTCL87RPU')" value="RWRKFNVF49">ON ROLL</option>-->
                                    <!--<option ng-repeat="emprole in firstDrop" value="{{emprole.alias}}" ng-selected="emprole.alias == singleViews.role_alias">{{emprole.name}}</option>
                                </select>
                                <span class="help-block" ng-show="empmasterForm.role_alias.$dirty && empmasterForm.role_alias.$invalid">
                                    <span ng-show="empmasterForm.role_alias.$error.required">Select Employee Role</span>
                                </span>
                            </div>-->
							
                            <div ng-if="department == 'TTTCL87RPU'">
                                <div class="col-sm-4">
                                    <label class="selectlabel">Employee Role</label>
                                    <select class="form-control testSelAll2 editselectdrop" name="role_alias" ng-model="emprole" ng-init="emprole=singleViews.role_alias" required>
                                        <option value="" selected="" disabled="disabled">Employee Role</option>
                                        <option ng-repeat="emprole in firstDrop" value="{{emprole.alias}}" ng-selected="emprole.alias == singleViews.role_alias">{{emprole.name}}</option>
                                    </select>
                                    <span class="help-block" ng-show="empmasterForm.role_alias.$dirty && empmasterForm.role_alias.$invalid">
                                        <span ng-show="empmasterForm.role_alias.$error.required">Select Employee Role</span>
                                    </span>
                    			</div>
                                <div class="col-sm-4" ng-controller="escaservicedropCtrl" ng-if="emprole=='01ZMYJ4OLG'" ng-init="singleViews.role_alias == '01ZMYJ4OLG'">
                                    <label class="selectlabel">Esca Name</label>
                                    <select class="form-control testSelAll2 editselectdrop" name="esca_alias" ng-model="escaname" required>
                                        <option value="" selected="">ESCA</option>
                                        <option ng-repeat="esca in firstDrop" value="{{esca.alias}}" ng-selected="esca.alias == singleViews.esca_alias">{{esca.name}}</option>
                                    </select>
                                    <span class="help-block" ng-show="empmasterForm.esca_alias.$dirty && empmasterForm.esca_alias.$invalid">
                                        <span ng-show="empmasterForm.esca_alias.$error.required">Select Esca Name</span>
                                    </span>
                                </div>
                            </div>
                    
                    
                            <div class="col-sm-4" ng-if="department != 'TTTCL87RPU'">
                            <label class="selectlabel">Employee Role</label>
                                <select class="form-control testSelAll2 editselectdrop" name="role_alias" ng-model="emprole" required>
                                    <option value="" selected="" disabled="disabled">Employee Role</option>
                                    <option value="RWRKFNVF49" ng-selected="singleViews.role_alias=='RWRKFNVF49'">ON ROLE</option>
                                </select>
                                <span class="help-block" ng-show="empmasterForm.role_alias.$dirty && empmasterForm.role_alias.$invalid">
                                    <span ng-show="empmasterForm.role_alias.$error.required">Select Employee Role</span>
                                </span>
                            </div>
							
						
                       </div> 
                        <div ng-controller="assetmuldropCntrl">
                            <div class="col-sm-4">
                                 <label class="selectlabel">Asset Type <span style="color:#d1d1d1">(optional)</span></label>
                                 <select class="form-control testSelAll3" placeholder="Asset Type" name="asset_type[]" ng-init="dep_drop_asset_emp(singleViews.asset_type)" ng-model="asset_type" data-ng-change="dep_drop_mul()" multiple="multiple">
                                  <option ng-repeat="asset in assets" value="{{asset.name}}" ng-selected="singleViews.asset_type.indexOf(asset.name) != -1">{{asset.name}}</option>
                                </select>
                             </div>
                             <div class="col-sm-4">
                                 <label class="selectlabel">Asset Name <span style="color:#d1d1d1">(optional)</span></label>
                                 <select class="form-control testSelAll3" placeholder="Asset Name" name="asset_name[]" ng-model="asset_name" multiple="multiple" ng-init="dep_drop(singleViews.asset_name,'asset_make[]')" data-ng-change="asset_make_drop()">
                                  <option ng-repeat="asset in firstDrop" value="{{asset.alias}}" ng-selected="singleViews.asset_name.indexOf(asset.alias) != -1">{{asset.name}}</option>
                                </select>
                             </div>
                            <div class="col-sm-4">
                                 <label class="selectlabel">Asset Make <span style="color:#d1d1d1">(optional)</span></label>
                                 <select class="form-control testSelAll3" placeholder="Asset Make" name="asset_make[]" ng-model="asset_make" ng-init="dep_drop2(singleViews.asset_make,'asset_alias[]')" data-ng-change="asset_sno_drop()" multiple="multiple">
                                  <option ng-repeat="asset in secondDrop" value="{{asset.alias}}"  ng-selected="singleViews.asset_make.indexOf(asset.alias) != -1">{{asset.name}}</option>
                                </select>
                             </div>
                             <div class="col-sm-4">
                                 <label class="selectlabel">Asset Serial No <span style="color:#d1d1d1">(optional)</span></label>
                                 <select class="form-control testSelAll3" placeholder="Asset Serial No" name="asset_alias[]" multiple="multiple">
                                  <option ng-repeat="asset in thirdDrop" value="{{asset.alias}}" ng-selected="singleViews.asset_alias.indexOf(asset.alias) != -1">{{asset.name}}</option>
                                </select>
                             </div> 
                        </div> 
						<div class="col-sm-4">
                             <md-input-container flex="" class="md-default-theme">
                                <label for="input_00C">Cash Card <span style="color:#d1d1d1">(optional)</span></label>
                                <input value="{{singleViews.cash_card}}" ng-model="singleViews.cash_card" name="cash_card">
                            </md-input-container>
                         </div>
                         <div class="col-sm-4" ng-if="singleViews.opening_hide">
                             <md-input-container flex="" class="md-default-theme">
                                <label for="input_00C">Opening Balance <span style="color:#d1d1d1">(optional)</span></label>
                                <input type="text" value="{{singleViews.opening_balance}}" ng-model="singleViews.opening_balance" name="opening_balance">
                            </md-input-container>
                         </div>
                     <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00E">Status</label>
                            <input value="{{singleViews.status}}" readonly="readonly" ng-model="singleViews.status" name="status" class="ng-pristine ng-valid md-input ng-touched" id="input_00E" tabindex="0" aria-invalid="false">
                        </md-input-container>
                     </div>
					<div class="col-sm-4 filesRow" ng-if="singleViews.status == 'RESIGNED' || choose_resigned" ng-controller="fileUploadPrgCtrl">
						 <!--<label class="selectlabel">Mode Of Contact: <span style="color:red;">(Mandatory)</span></label><br /> -->                                                    
						<input value="{{file_name}}" class="form-control uploadFile" placeholder="Upload NOC" disabled="disabled"/>
						<div class="fileUpload btn btn-sm btn-info" tooltip="Choose NOC" tooltip-placement="right">
							<span class="ion ion-upload"></span>
							<input type="file" class="upload uploadBtn" name="noc" value="{{singleViews.noc}}" ng-model="singleViews.noc" id="noc" onchange="angular.element(this).scope().file_load(this.files,'pdf')"/>
						</div>
						<div ng-if="determinateValue >= '100' ? closeloadings() : ''"></div>
						<div class="mb20" ng-if="prg_shw_hde">
							<md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
						</div>
					</div>
                    <!--<div class="col-sm-4" ng-if="singleViews.status == 'RESIGNED'">
                        <div class="upload-file">
                            <label class="selectlabel">NOC</label>
                            <input type="file" name="noc" value="{{singleViews.noc}}" ng-model="singleViews.noc" class="ng-pristine ng-valid md-input ng-touched" id="input_00P" tabindex="0" aria-invalid="false">
                        </div>
                    </div>-->
                     <div class="col-sm-4">
                         <label class="selectlabel">TS Person Notified <span style="color:#d1d1d1">(optional)</span></label>
                         <select class="form-control testSelAll2" placeholder="TS Notified" name="ths_notified" ng-model="singleViews.ths_notified">
                            <option value="1" ng-selected="singleViews.ths_notified==1">SHOW</option>
                            <option value="0" ng-selected="singleViews.ths_notified==0">HIDE</option>
                        </select>
                    </div>
                </div>
                 <div class="row form-group">
                     <div class="col-sm-6 col-sm-offset-5">
                        <button type="submit" click-once class="btn btn-info btn-sm" 
                        ng-disabled="empmasterForm.emp_id.$dirty && empmasterForm.emp_id.$invalid ||
                        empmasterForm.name.$dirty && empmasterForm.name.$invalid ||
                        empmasterForm.department_alias.$dirty && empmasterForm.department_alias.$invalid ||
                        empmasterForm.designation_alias.$dirty && empmasterForm.designation_alias.$invalid ||
                        empmasterForm['zone_alias[]'].$dirty && empmasterForm['zone_alias[]'].$invalid ||
                        empmasterForm['state_alias[]'].$dirty && empmasterForm['state_alias[]'].$invalid ||
                        empmasterForm.base_location.$dirty && empmasterForm.base_location.$invalid ||
                        empmasterForm.email_id.$dirty && empmasterForm.email_id.$invalid ||
                        empmasterForm.mobile_number.$dirty && empmasterForm.mobile_number.$invalid ||
                        empmasterForm.qualification.$dirty && empmasterForm.qualification.$invalid ||
                        empmasterForm.specialization.$dirty && empmasterForm.specialization.$invalid ||
                        empmasterForm.total_experience.$dirty && empmasterForm.total_experience.$invalid ||
                        empmasterForm.joining_date.$dirty && empmasterForm.joining_date.$invalid ||
                        empmasterForm.role_alias.$dirty && empmasterForm.role_alias.$invalid ||
                        empmasterForm.privilege_alias.$dirty && empmasterForm.privilege_alias.$invalid ||
                        empmasterForm.noc.$dirty && empmasterForm.noc.$invalid">Update</button>
                        <button type="reset" class="btn btn-info btn-sm" ng-click="empmasterForm.$setPristine(); empmasterForm.$setUntouched();">Reset</button>
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
		$('.testSelAll3').SumoSelect({selectAll:true});
		$('.forms_add').find('.SumoSelect').addClass('singleSelect');
	},0);
</script>