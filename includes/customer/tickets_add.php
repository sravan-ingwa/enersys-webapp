<style>
.form-group {margin-bottom:0px !important;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.btn-default{border-color:transparent !important;border-bottom:1px solid #e0e0e0 !important;}
.autoselect{padding-top:22px !important;}
.upload-file{border-bottom: 1px solid rgba(0,0,0,0.12); padding-top:9px;}
.ui-select-bootstrap > .ui-select-search:focus{border: none;background:#FFF !important;}
.md-dialog-container {z-index:10000;}
.ui-select-bootstrap>.ui-select-match>button {text-align: left!important;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
.mb25{margin-bottom: 25px;}
</style>
	<div class="modal-style" ng-controller="activityCompCustCntrl">	
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
			<form class="form-horizontal forms_add" name="userForm" role="form" data-went="#/tickets-customer" enctype="multipart/form-data" method="post" url="services/customer/online_ticket_add" ng-submit="sendPost()" novalidate>
				<input type="hidden" value="ticket" name="help">
                <div class="row form-group">
					<div class="col-sm-4">
					<label class="selectlabel">Nature Of Activity</label>
						<select id="Activity" class="form-control testSelAll2 selectdrop" name="activity_alias" ng-model="natureofactivity" ng-change="dep_drop(natureofactivity,'complaint_alias')" required>
							<option value=''  selected="selected" disabled="disabled">Select Nature Of Activity</option>
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
						<div class="form-group autoselect">
                        	<input name="site_alias" value="{{sit.alias}}" type="hidden"/>
							<ui-select ng-model="person.selected" search-enabled="true" ng-change="autotickets1(person.selected)" data-ng-keyup="sitemasterlist1($select.search)">
								<ui-select-match placeholder="Select a Site ID">{{$select.selected.site_id}}</ui-select-match>
								<ui-select-choices repeat="person in datas">
									<div ng-bind-html="person.site_id"></div> 
								</ui-select-choices>
							</ui-select> 
						</div> 
                        <!--<span class="help-block" ng-show="userForm.site_id.$dirty && userForm.site_id.$invalid">
                            <span ng-show="userForm.site_id.$error.required">Site Id Required</span>
                        </span>-->
					</div>
                  </div>
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
                   <div class="row form-group"> 
                        <div class="col-sm-4">
						<label class="selectlabel">Nature Of Complaint</label>
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
                                <select class="form-control testSelAll2 selectdrop" name="mode_of_contact" ng-model="thisValue" required>
                                    <option value="" selected disabled="disabled">Select MOC</option>
                                    <option ng-repeat="moc in firstDrop" value="{{moc.name}}">{{moc.name}}</option>
                                </select>
                                <span class="help-block" ng-show="userForm.mode_of_contact.$dirty && userForm.mode_of_contact.$invalid">
                                    <span ng-show="userForm.mode_of_contact.$error.required">MOC Required</span>
                                </span>
                            </div>
								<div class="col-sm-4 filesRow" ng-if="thisValue == 'FAX' || thisValue == 'LETTER'" ng-controller="fileUploadPrgCtrl">
									 <!--<label class="selectlabel">Mode Of Contact: <span style="color:red;">(Mandatory)</span></label><br /> -->                                                    
									<input value="{{file_name}}" class="form-control uploadFile" placeholder="Upload MOC" disabled="disabled"/>
									<div class="fileUpload btn btn-sm btn-info" tooltip="Choose MOC" tooltip-placement="right">
										<span class="ion ion-upload"></span>
										<input type="file" class="upload uploadBtn" name="moc_file" id="moc_file" onchange="angular.element(this).scope().file_load(this.files,'pdf')"/>
									</div>
									<span class="help-block" ng-show="userForm.moc_file.$dirty && userForm.moc_file.$invalid">
										<span ng-show="userForm.moc_file.$error.required">Upload MOC</span>
									</span>
									<div ng-if="determinateValue >= '100' ? closeloadings() : ''"></div>
									<div class="mb20" ng-if="prg_shw_hde">
										<md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
									</div>
								</div>
                             <!--<div class="col-sm-4" ng-if="thisValue == 'FAX' || thisValue == 'LETTER'">
                                    <div class="upload-file">
                                        <label class="selectlabel">Choose File</label>
                                        <input type="file" name="moc_file" class="ng-pristine ng-valid md-input ng-touched" id="input_00P" tabindex="0" aria-invalid="false">
                                  	</div>
                                  	<span class="help-block" ng-show="userForm.moc_file.$dirty && userForm.moc_file.$invalid">
                                        <span ng-show="userForm.moc_file.$error.required">Upload MOC</span>
                                    </span>
                            	</div>-->
                        </div>
                        <div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme">
                                <label for="input_00D">Faulty Cells Count</label>
                                <input ng-model="faulty_cell_count" value="{{singleViews.site_name}}" ng-pattern="/^(?=.)([+-]?([0-9]*)(\.([0-9]+))?)$/" name="faulty_cell_count" class="ng-pristine ng-valid md-input ng-touched" id="input_00Q" tabindex="0" aria-invalid="false" required>
                            </md-input-container>
                            <span class="help-block" ng-show="userForm.faulty_cell_count.$dirty && userForm.faulty_cell_count.$invalid">
                                <span ng-show="userForm.faulty_cell_count.$error.required">Faulty Cells Count is Required</span>
                                <span ng-show="userForm.faulty_cell_count.$error.pattern">Faulty Cells Count is Digits Only</span>
                            </span>
                        </div>
                        <div class="col-sm-4" ng-class="{'has-error' : submitted && userForm.description.$invalid }">
                            <textarea rows="2" name="description" ng-model="description" class="form-control resize-v" placeholder="Complete Observation" required></textarea>
                            <span class="help-block" ng-show="userForm.description.$dirty && userForm.description.$invalid">
                                <span ng-show="userForm.description.$error.required">Complete Observation is Required</span>
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
setInterval(function(){$('.testSelAll2').SumoSelect();
$('.forms_add').find('.SumoSelect').addClass('singleSelect');},0);
</script>