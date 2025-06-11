<style>
.form-group {margin-bottom:0px !important;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.btn-default{border-color:transparent !important;border-bottom:1px solid #e0e0e0 !important;}
.autoselect{padding-top:22px !important;}
.upload-file{border-bottom: 1px solid rgba(0,0,0,0.12); padding-top:9px;}
.ui-select-bootstrap > .ui-select-search:focus{border: none;background:#FFF !important;}
.md-dialog-container {z-index:10000;}
.page-auth .customer-page {background: #fff; max-width: 1100px; margin: 0 auto; box-shadow: 0 1px 8px rgba(0, 0, 0, 0.14);margin-top:40px; border: 1px solid #790900;}
.main-container .content-container.fixedHeader .page {margin-top: 165px;}
.contact-dropdown {margin-top: 9px !important;}
.page-auth .panel-heading {padding: 7px 15px; border-bottom: 1px solid transparent;}
.page-auth .panel-heading .panel-title {font-size: 16px;text-transform: none;color: #fff;font-weight: bold;}
.page-auth .forms_add{padding:20px;}
.ui-select-bootstrap .ui-select-choices-row.active > a {background-color:#790900;}
.toast { z-index:10000;}
</style>
	<div class="row topmenu">
        <div class="col-sm-2 hidden-xs text-left"></div>
    	<div class="col-xs-8 text-center">
			<h1 class="fdd"><a href="javascript:;" style="text-transform:none !important"><span style="font-size:27px !important;">E</span>nerSys <span style="color:#40AE51;text-shadow:-1px -1px 0 #FFF,1px -1px 0 #FFF,-1px 1px 0 #FFF,1px 1px 0 #FFF;">Care</span> Online Ticket Registration</a></h1>
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
	<div class="page page-auth" ng-controller="onlineticketsCtrl">
		<div class="customer-page" ng-controller="addingform">
        <!--<div class="toast toast-topRight1">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <div class="panel-heading" style="background-color: #790900; border-color: #790900;">
          <h3 class="panel-title">CREATE ONLINE TICKETS</h3>
        </div>
			<form class="form-horizontal forms_add" name="userForm" role="form" data-went="#/bycustomer" method="post" url="services/tickets/online_ticket_add" ng-submit="sendPost()" novalidate>
				<input type="hidden" value="ticket" name="help">
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
						<div class="form-group autoselect">
                        	<input name="site_alias" value="{{sit.alias}}" type="hidden"/>
							<ui-select ng-model="person.selected" search-enabled="true" ng-change="onlinetickets(person.selected)" data-ng-keyup="sitemasterlist($select.search)">
								<ui-select-match placeholder="Select a Site ID">{{$select.selected.site_id}}</ui-select-match>
								<ui-select-choices repeat="person in sitemasterlists">
									<div ng-bind-html="person.site_id"></div> 
								</ui-select-choices>
							</ui-select> 
						</div> 
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
                                <label for="input_00D">Site Technician Name</label>
                                <input value="{{singleViews.technician_name}}" readonly="readonly" class="ng-pristine ng-valid md-input ng-touched" id="input_00K" tabindex="0" aria-invalid="false">
                            </md-input-container>
                        </div>
                        <div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme md-input-has-value">
                                <label for="input_00D">Site Technician Number</label>
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
                                <label for="input_00D">Cluster Manager Name</label>
                                <input readonly="readonly" value="{{singleViews.manager_name}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00P" tabindex="0" aria-invalid="false">
                            </md-input-container>
                        </div>
                        <div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme md-input-has-value">
                                <label for="input_00D">Cluster Manager Number</label>
                                <input readonly="readonly" value="{{singleViews.manager_number}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00P" tabindex="0" aria-invalid="false">
                            </md-input-container>
                        </div>
                        <div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme md-input-has-value">
                                <label for="input_00D">Cluster Manager Mail ID</label>
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
                            <select id="Firstactivity" class="form-control selectdrop" name="complaint_alias" ng-model="activity" required>
                                <option value=""  selected="selected">Select Nature of Complaint</option>
                                <option ng-repeat="complaint in secondDrop" value="{{complaint.alias}}" ng-selected="complaint.alias == singleViews.complaint_alias">{{complaint.name}}</option>
                            </select>
                            <span class="help-block" ng-show="userForm.complaint_alias.$dirty && userForm.complaint_alias.$invalid">
                                <span ng-show="userForm.complaint_alias.$error.required">Nature of Complaint Required</span>
                            </span>
                        </div>
                        <div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme">
                                <label for="input_00D">Faulty Cells Count</label>
                                <input ng-model="faulty_cell_count" ng-pattern="/^(?=.)([+-]?([0-9]*)(\.([0-9]+))?)$/" name="faulty_cell_count" class="ng-pristine ng-valid md-input ng-touched" id="input_00Q" tabindex="0" aria-invalid="false" required>
                            </md-input-container>
                            <span class="help-block" ng-show="userForm.faulty_cell_count.$dirty && userForm.faulty_cell_count.$invalid">
                                <span ng-show="userForm.faulty_cell_count.$error.required">Faulty Cells Count is Required</span>
                                <span ng-show="userForm.faulty_cell_count.$error.pattern">Faulty Cells Count is Digits Only</span>
                            </span>
                        </div>
                        <div class="col-sm-4">
                            <textarea rows="2" name="description" ng-model="user.description" class="form-control resize-v" placeholder="Complete Observation" required></textarea>
                            <span class="help-block" ng-show="userForm.description.$dirty && userForm.description.$invalid">
                                <span ng-show="userForm.description.$error.required">Complete Observation is Required</span>
                            </span>
                        </div>
                   </div>
                   <div class="row form-group"> 
                    <div class="col-sm-6 col-sm-offset-5">
                        <button type="submit" class="btn btn-info btn-sm"  ng-disabled="userForm.$invalid || userForm.$pristine">Create</button>
                        <button type="reset" class="btn btn-info btn-sm" ng-click="userForm.$setPristine(); userForm.$setUntouched();" >Reset</button>
                    </div>
				</div>
			</form>
		</div>
	</div>