<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
.SumoSelect > .CaptionCont > span {margin-left:0px !important;}
</style>
<div class="modal-style">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Add Event</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" name="eventForm" method="post" data-went="#/calendar" url="services/calender/event_add" ng-submit="sendPost()" novalidate>
                <div class="row form-group">
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Title</label>
                            <input ng-model="title" class="ng-pristine ng-valid md-input ng-touched" name="title" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="eventForm.title.$dirty && eventForm.title.$invalid">
                            <span ng-show="eventForm.title.$error.required">Event Title is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Description</label>
                            <input ng-model="description" class="ng-pristine ng-valid md-input ng-touched" name="description" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="eventForm.description.$dirty && eventForm.description.$invalid">
                            <span ng-show="eventForm.description.$error.required">Event Description is Required</span>
                        </span>
                    </div>
                    
                    <div class="col-sm-10 col-sm-offset-1 mb10"  ng-controller="DatepickerDemoCtrl">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Select Date</label>
                            <input type="text" class="form-control datepicker border-bottom" name="event_date" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened')" ng-focus="open($event,'opened')" ng-model="event_date" is-open="opened" min-date="dt" max-date="'22-06-2025'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" required="required" show-button-bar="false"/>
                        </md-input-container>
                         <span class="help-block" ng-show="eventForm.event_date.$dirty && eventForm.event_date.$invalid">
                            <span ng-show="eventForm.event_date.$error.required">Event Date is Required</span>
                        </span>
                    </div>
                    
                    <div ng-controller="roleEmpDropCtrl">
                        <div class="col-sm-10 col-sm-offset-1 mb20">
						 <label class="selectlabel">Employee Role</label>
                           <select class="form-control selectdrop testSelAll2" name="role_alias1[]" ng-model="emprole" placeholder="Employee Role"  data-ng-change="role_emp_mul_all()" multiple="multiple" required>
                                <option value="" selected="" disabled="disabled">Employee Role</option>
								<option ng-repeat="emprole in firstDrop" value="{{emprole.alias}}">{{emprole.name}}</option>
                           </select>
                           <span class="help-block" ng-show="eventForm['role_alias1[]'].$dirty && eventForm['role_alias1[]'].$invalid">
                                <span ng-show="eventForm['role_alias1[]'].$error.required">Select Employee Role</span>
                           </span>
                        </div>
                        <div class="col-sm-10 col-sm-offset-1 mb10">
						<label class="selectlabel">Employee Names</label>
                           <select class="form-control selectdrop testSelAll2" name="employee_alias1[]" placeholder="Employee Names" ng-model="employee_alias"  multiple="multiple" required>
                                <option value="" selected="" disabled="disabled">Employee Names</option>
								<option ng-repeat="emp in secondDrop" value="{{emp.alias}}">{{emp.name}}</option>
                           </select>
                           <span class="help-block" ng-show="eventForm['employee_alias1[]'].$dirty && eventForm['employee_alias1[]'].$invalid">
                                <span ng-show="eventForm['employee_alias1[]'].$error.required">Select Employee Names</span>
                           </span>
                        </div>
                     </div>
                   
                     <div class="col-sm-10 col-sm-offset-1 mb10" ng-controller="dprdropCntrl">
                     <label class="selectlabel">DPR</label>
                         <select class="form-control selectdrop testSelAll3" name="dpr_alias" ng-model="dpr" required="required">
                            <option value="" selected="" disabled="disabled">Select DPR</option>
                            <option ng-repeat="dprs in firstDrop" value="{{dprs.alias}}">{{dprs.name}}</option>
                        </select>
                         <span class="help-block" ng-show="eventForm.dpr_alias.$dirty && eventForm.dpr_alias.$invalid">
                            <span ng-show="eventForm.dpr_alias.$error.required">Select DPR</span>
                        </span>
                    </div>
                     <input type="hidden" value="1"  name="p_level"/>
                     <?php /*?><div class="col-sm-10 col-sm-offset-1 mb10">
                     <select class="form-control selectdrop" name="p_level" ng-model="plevel" required="required">
                     	<option value="">Select Priority</option>
                     	<option value="0" selected="selected">Normal</option>
                        <option value="1">Important</option>
                        <option value="2">Most Important</option>
                     </select>
                     	<span class="help-block" ng-show="eventForm.p_level.$dirty && eventForm.p_level.$invalid">
                            <span ng-show="eventForm.p_level.$error.required">Select Priority</span>
                        </span>
                     </div><?php */?>
                     
                     <div class="col-sm-6 col-sm-offset-4">
                            <button type="submit" click-once class="btn btn-info btn-sm" ng-disabled="eventForm.$invalid || eventForm.$pristine">Create Event</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose()">Close</button>
                    </div>
               </div>
          </form>   
	</div>
</div>
<script>
setInterval(function(){$('.testSelAll2').SumoSelect({selectAll:true});
$('.testSelAll3').SumoSelect();
$('.forms_add').find('.SumoSelect').addClass('singleSelect');},0);
</script>