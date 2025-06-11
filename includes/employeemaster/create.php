<style>
.selectdrop{overflow-y:scroll;}
.form-group {margin-bottom:0px !important;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.upload-file{border-bottom: 1px solid rgba(0,0,0,0.12);}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
</style>
<div class="modal-style">
	<div class="modal-header clearfix">
		<h4 class="modal-title">Create Employee Master</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
	<div  ng-controller="departmentdropCntrl">
        <!-- <div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
		<form class="form-horizontal forms_add" name="empmasterForm" data-went="#/Employeemaster" method="post" url="services/employeemaster/employeemaster_add" ng-submit="sendPost()" novalidate>
            	<div class="row form-group">
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00A">Employee ID</label>
                            <input ng-model="employeeid" name="emp_id" class="ng-pristine ng-valid md-input ng-touched" id="input_00A" tabindex="0" aria-invalid="false" required>
                        </md-input-container>
                        <span class="help-block" ng-show="empmasterForm.emp_id.$dirty && empmasterForm.emp_id.$invalid">
                            <span ng-show="empmasterForm.emp_id.$error.required">Employee ID is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00B">Employee Name</label>
                            <input ng-model="employeename" name="name" class="ng-pristine ng-valid md-input ng-touched" id="input_00B" tabindex="0" aria-invalid="false" required>
                        </md-input-container>
                        <span class="help-block" ng-show="empmasterForm.name.$dirty && empmasterForm.name.$invalid">
                            <span ng-show="empmasterForm.name.$error.required">Employee Name is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                    <label class="selectlabel">Department</label>
                        <select class="form-control testSelAll2 selectdrop" name="department_alias" ng-model="department" required>
                            <option value="" selected="" disabled="disabled">Department</option>
                            <option ng-repeat="department in firstDrop" value="{{department.alias}}">{{department.name}}</option>
                        </select>
                         <span class="help-block" ng-show="empmasterForm.department_alias.$dirty && empmasterForm.department_alias.$invalid">
                            <span ng-show="empmasterForm.department_alias.$error.required">Select Department</span>
                        </span>
                    </div>   
                </div>
                <div class="row form-group">     
                    <div class="col-sm-4" ng-controller="designationdropCntrl">
                    <label class="selectlabel">Designation</label>
                        <select class="form-control testSelAll2 selectdrop" name="designation_alias" ng-model="designation" required>
                            <option value="" selected="" disabled="disabled">Designation</option>
                            <option ng-repeat="designation in firstDrop" value="{{designation.alias}}">{{designation.name}}</option>
                        </select>
                         <span class="help-block" ng-show="empmasterForm.designation_alias.$dirty && empmasterForm.designation_alias.$invalid">
                            <span ng-show="empmasterForm.designation_alias.$error.required">Select Designation</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Email</label>
                            <input ng-model="loginemail" name="email_id" class="ng-pristine ng-valid md-input ng-touched" ng-pattern="/^(([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+([;,.](([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+)*$/" required>
                        </md-input-container>
                        <span class="help-block" ng-show="empmasterForm.email_id.$dirty && empmasterForm.email_id.$invalid">
                            <span ng-show="empmasterForm.email_id.$error.required">Login Email is Required</span>
                            <span ng-show="empmasterForm.email_id.$error.pattern">Invalid Email Address</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00E">Base Location</label>
                            <input ng-model="baselocation" name="base_location" class="ng-pristine ng-valid md-input ng-touched" id="input_00E" tabindex="0" aria-invalid="false" required>
                        </md-input-container>
                        <span class="help-block" ng-show="empmasterForm.base_location.$dirty && empmasterForm.base_location.$invalid">
                            <span ng-show="empmasterForm.base_location.$error.required">Base Location is Required</span>
                        </span>
                    </div>
                  </div>  
                 <div class="row form-group" ng-controller="zoneStateMulCntrl">
                    <div class="col-sm-4">
                        <label class="selectlabel">Zone</label>
                        <select multiple="multiple" placeholder="Zone" name="zone_alias[]" class="testSelAll3 form-control" ng-model="zones" data-ng-change="dep_drop_mul(zones)" required="required">
                            <option ng-repeat="zone in firstDrop" value="{{zone.alias}}">{{zone.name}}</option>
                        </select>
                        <span class="help-block" ng-show="empmasterForm['zone_alias[]'].$dirty && empmasterForm['zone_alias[]'].$invalid">
                            <span ng-show="empmasterForm['zone_alias[]'].$error.required">Select Zone</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <label class="selectlabel">State</label>
                        <select class="form-control testSelAll3" placeholder="State" name="state_alias[]" id="state" ng-model="states" multiple="multiple" data-ng-change="state_wh_mul(states)" required="required">
                            <option ng-repeat="state in secondDrop" value="{{state.alias}}">{{state.name}}</option>
                        </select>
                        <span class="help-block" ng-show="empmasterForm['state_alias[]'].$dirty && empmasterForm['state_alias[]'].$invalid">
                            <span ng-show="empmasterForm['state_alias[]'].$error.required">Select State</span>
                        </span>
                    </div>
                     <div class="col-sm-4">
                        <label class="selectlabel">Wh Code <span style="color:#d1d1d1">(optional)</span></label>
                        <select class="form-control testSelAll3" placeholder="Wharehouse Code" name="wh_alias[]" id="whcode" ng-model="warehouse" multiple="multiple">
                            <option ng-repeat="warehouse in thirdDrop" value="{{warehouse.alias}}">{{warehouse.name}}</option>
                        </select>
                    </div>
                </div> 
                 <div class="row form-group" ng-controller="segmentCustMuldropCntrl">
                    <div class="col-sm-4">
                        <label class="selectlabel">Segment <span style="color:#d1d1d1">(optional)</span></label>
                        <select multiple="multiple" placeholder="Segment" name="segment_alias[]" class="testSelAll3 form-control" ng-model="segment_alias" data-ng-change="dep_drop_mul(segment_alias)">
                            <option ng-repeat="seg in firstDrop" value="{{seg.alias}}">{{seg.name}}</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label class="selectlabel">Customer <span style="color:#d1d1d1">(optional)</span></label>
                        <select class="form-control testSelAll3" placeholder="Customer" name="customer_alias[]" id="customer" ng-model="customer_alias" multiple="multiple">
                            <option ng-repeat="cust in secondDrop" value="{{cust.alias}}">{{cust.name}}</option>
                        </select>
                    </div>     
					<div class="col-sm-4">
						<md-input-container flex="" class="md-default-theme">
							<label for="input_00C">Contact No</label>
							<input type="text" ng-model="contactno" valid-input="10" name="mobile_number" class="ng-pristine ng-valid md-input ng-touched" id="input_00C" tabindex="0" aria-invalid="false" required>
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
                     <select class="form-control testSelAll2 selectdrop" ng-model="qualification" name="qualification" required>
                        <option value="" selected  disabled="disabled">Qualification</option>
                        <option ng-repeat="qualif in qualifications" value="{{qualif.name}}">{{qualif.name}}</option>
                    </select>
                    <span class="help-block" ng-show="empmasterForm.qualification.$dirty && empmasterForm.qualification.$invalid">
                        <span ng-show="empmasterForm.qualification.$error.required">Select Qualification</span>
                    </span>
                </div>
                <div class="col-sm-4">
                    <md-input-container flex="" class="md-default-theme">
                        <label for="input_00C">Specialization</label>
                        <input ng-model="specialization" name="specialization" class="ng-pristine ng-valid md-input ng-touched" id="input_00C" tabindex="0" aria-invalid="false" required>
                    </md-input-container>
                    <span class="help-block" ng-show="empmasterForm.specialization.$dirty && empmasterForm.specialization.$invalid">
                        <span ng-show="empmasterForm.specialization.$error.required">Specialization is Required</span>
                    </span>
                </div>
				 <div class="col-sm-4">
				   <md-input-container flex="" class="md-default-theme">
						<label for="input_00A">Total Experience</label>
						<input ng-model="total_experience" name="total_experience" class="ng-pristine ng-valid md-input ng-touched" ng-pattern="/^(?=.)([+-]?([0-9]*)(\.([0-9]+))?)$/" required="required">
				   </md-input-container>
					<span class="help-block" ng-show="empmasterForm.total_experience.$dirty && empmasterForm.total_experience.$invalid">
						<span ng-show="empmasterForm.total_experience.$error.required">Total Experience is Required</span>
						<span ng-show="empmasterForm.total_experience.$error.pattern">Total Experience should be digits only</span>
					</span>
				</div>
            </div>
                <div class="row form-group">
                    <div class="col-sm-4" style="margin-bottom:0px;">
                        <md-input-container flex="" class="md-default-theme" ng-controller="DatepickerDemoCtrl">
                            <label for="input_00D">Joining Date</label>
                            <input type="text" ng-model="joiningdate" name="joining_date" class="datepicker border-bottom" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" required/>
                       </md-input-container>
                        <span class="help-block" ng-show="empmasterForm.joining_date.$dirty && empmasterForm.joining_date.$invalid">
                            <span ng-show="empmasterForm.joining_date.$error.required">Joining Date is Required</span>
                            <span ng-show="empmasterForm.joining_date.$invalid">Date should be (ex:dd-mm-yyyy) only</span>
                        </span>
                    </div>
					<div class="col-sm-4" ng-controller="privilagesdropCntrl">
						<label class="selectlabel">Privilages</label>
						<select class="form-control testSelAll2 selectdrop" name="privilege_alias" ng-model="privilages" required>
							<option value="" selected="" disabled="disabled">Privilages</option>
							<option ng-repeat="privilages in firstDrop" value="{{privilages.alias}}">{{privilages.name}}</option>
						</select>
						<span class="help-block" ng-show="empmasterForm.privilege_alias.$dirty && empmasterForm.privilege_alias.$invalid">
							<span ng-show="empmasterForm.privilege_alias.$error.required">Select Privilages</span>
						</span>
					</div>
                    <!--<div class="col-sm-4">
                    <label class="selectlabel">Employee Role</label>
                        <select class="form-control testSelAll2 selectdrop" name="role_alias" ng-model="emprole" required>
                            <option value="" selected="" disabled="disabled">Employee Role</option>
                            <option ng-if="department == 'TTTCL87RPU'" ng-repeat="emprole in firstDrop" value="{{emprole.alias}}">{{emprole.name}}</option>
                            <option ng-if="department != 'TTTCL87RPU'" value="RWRKFNVF49">ON ROLL</option>
                        </select>
                        <span class="help-block" ng-show="empmasterForm.role_alias.$dirty && empmasterForm.role_alias.$invalid">
                            <span ng-show="empmasterForm.role_alias.$error.required">Select Employee Role</span>
                        </span>
                    </div>-->
					<div ng-if="department == 'TTTCL87RPU'" ng-controller="emproledropCntrl">
						<div class="col-sm-4">
							<label class="selectlabel">Employee Role</label>
							<select class="form-control testSelAll2 selectdrop" name="role_alias" ng-model="emprole" required>
								<option value="" selected="" disabled="disabled">Employee Role</option>
								<option ng-repeat="emprole in firstDrop" value="{{emprole.alias}}">{{emprole.name}}</option>
							</select>
							<span class="help-block" ng-show="empmasterForm.role_alias.$dirty && empmasterForm.role_alias.$invalid">
								<span ng-show="empmasterForm.role_alias.$error.required">Select Employee Role</span>
							</span>
						</div>
						
						<div class="col-sm-4" ng-controller="escaservicedropCtrl" ng-if="emprole == '01ZMYJ4OLG'">
							<label class="selectlabel">ESCA</label>
							<select class="form-control testSelAll2 selectdrop" name="esca_alias" ng-model="escaname" required>
								<option value="" selected="selected" disabled="disabled">ESCA</option>
								<option ng-repeat="esca in firstDrop" value="{{esca.alias}}">{{esca.name}}</option>
							</select>
							<span class="help-block" ng-show="empmasterForm.esca_alias.$dirty && empmasterForm.esca_alias.$invalid">
								<span ng-show="empmasterForm.esca_alias.$error.required">Select Esca Name</span>
							</span>
						</div>
                    </div>
                    <div class="col-sm-4" ng-if="department != 'TTTCL87RPU'" ng-controller="emproledropCntrl">
						<label class="selectlabel">Employee Role</label>
                        <select class="form-control testSelAll2 selectdrop" name="role_alias" ng-model="emprole" required>
                            <option value="" selected="selected" disabled="disabled">Employee Role</option>
                            <option value="RWRKFNVF49">ON ROLE</option>
                        </select>
                        <span class="help-block" ng-show="empmasterForm.role_alias.$dirty && empmasterForm.role_alias.$invalid">
                            <span ng-show="empmasterForm.role_alias.$error.required">Select Employee Role</span>
                        </span>
                    </div>
					<div ng-controller="assetmuldropCntrl">
						<div class="col-sm-4">
							 <label class="selectlabel">Asset Type <span style="color:#d1d1d1">(optional)</span></label>
							 <select class="form-control testSelAll3" placeholder="Asset Type" name="asset_type[]" ng-model="asset_type" data-ng-change="dep_drop_mul()" multiple="multiple">
							  <option ng-repeat="asset in assets" value="{{asset.name}}" >{{asset.name}}</option>
							</select>
						 </div>
						 <div class="col-sm-4">
							 <label class="selectlabel">Asset Name <span style="color:#d1d1d1">(optional)</span></label>
							 <select class="form-control testSelAll3" placeholder="Asset Name" name="asset_name[]" ng-model="asset_name" data-ng-change="asset_make_drop()" multiple="multiple">
							  <option ng-repeat="asset in firstDrop" value="{{asset.alias}}" >{{asset.name}}</option>
							</select>
						 </div>
						 <div class="col-sm-4">
							 <label class="selectlabel">Asset Make <span style="color:#d1d1d1">(optional)</span></label>
							 <select class="form-control testSelAll3" placeholder="Asset Make" name="asset_make[]" ng-model="asset_make" data-ng-change="asset_sno_drop()" multiple="multiple">
							  <option ng-repeat="asset in secondDrop" value="{{asset.alias}}" >{{asset.name}}</option>
							</select>
						 </div>
						 <div class="col-sm-4">
							 <label class="selectlabel">Asset Serial No <span style="color:#d1d1d1">(optional)</span></label>
							 <select class="form-control testSelAll3" placeholder="Asset Serial No" name="asset_alias[]" ng-model="asset_alias" multiple="multiple">
								<option ng-repeat="asset in thirdDrop" value="{{asset.alias}}" >{{asset.name}}</option>
							</select>
						</div>
					  </div>
					  <div class="col-sm-4">
						 <md-input-container flex="" class="md-default-theme">
							<label for="input_00C">Cash Card <span style="color:#d1d1d1">(optional)</span></label>
							<input ng-model="cash_card" name="cash_card">
						</md-input-container>
					 </div>
					 <div class="col-sm-4">
						 <md-input-container flex="" class="md-default-theme">
							<label for="input_00C">Opening Balance <span style="color:#d1d1d1">(optional)</span></label>
							<input type="number" ng-model="opening_balance" name="opening_balance">
						</md-input-container>
					 </div>
					 <div class="col-sm-4">
						 <label class="selectlabel">TS Person Notified <span style="color:#d1d1d1">(optional)</span></label>
						 <select class="form-control testSelAll3" placeholder="TS Notified" name="ths_notified" ng-model="ths_notified">
							<option value="0">Hide</option>
							<option value="1">Show</option>
						</select>
					</div>
                </div>
                 <div class="row form-group">  
                    <div class="col-sm-6 col-sm-offset-5">
                        <button type="submit" click-once class="btn btn-info btn-sm" ng-disabled="empmasterForm.$invalid || empmasterForm.$pristine">Create</button>
                        <button type="reset" class="btn btn-info btn-sm" ng-click="empmasterForm.$setPristine(); empmasterForm.$setUntouched();">Reset</button>
                    </div>
                </div>   
		</form>
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