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
<div class="modal-style">
<div ng-controller="emailCalendarCtrl">
	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Email Calendar</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" name="emailForm" method="post" url="services/calender/sending_emails" ng-submit="sendEmail()" novalidate>
                <div class="row form-group">
                	<div ng-controller="roleEmpDropCtrl">
                        <div class="col-sm-10 col-sm-offset-1 mb20">
                           <select class="form-control selectdrop testSelAll2" name="role_alias1[]" ng-model="emprole" placeholder="Employee Role"  data-ng-change="role_emp_mul_all()" multiple="multiple" required>
                                <option ng-repeat="emprole in firstDrop" value="{{emprole.alias}}">{{emprole.name}}</option>
                           </select>
                           <span class="help-block" ng-show="emailForm['role_alias1[]'].$dirty && emailForm['role_alias1[]'].$invalid">
                                <span ng-show="emailForm['role_alias1[]'].$error.required">Select Employee Role</span>
                           </span>
                        </div>
                        <div class="col-sm-10 col-sm-offset-1 mb10">
                           <select class="form-control selectdrop testSelAll2" name="employee_alias1[]" placeholder="Employee Names" ng-model="employee_alias" multiple="multiple" required>
                                <option ng-repeat="emp in secondDrop" value="{{emp.alias}}">{{emp.name}}</option>
                           </select>
                           <span class="help-block" ng-show="emailForm['employee_alias1[]'].$dirty && emailForm['employee_alias1[]'].$invalid">
                                <span ng-show="emailForm['employee_alias1[]'].$error.required">Select Employee Names</span>
                           </span>
                        </div>
                    </div>
                    <div ng-controller="DatepickerDemoCtrl">
                        <div class="col-sm-5 col-sm-offset-1 mb10">
                            <md-input-container flex="" class="md-default-theme">
                                <label for="input_00D">From Date</label>
                                <input type="text" ng-model="fromdate" name="from_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" ng-focus="open($event,'opened1')" is-open="opened1" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" required="required"/>
                           </md-input-container>
                             <span class="help-block" ng-show="emailForm.from_date.$dirty && emailForm.from_date.$invalid">
                                <span ng-show="emailForm.from_date.$error.required">Select From Date</span>
                            </span>
                        </div>
                        <div class="col-sm-5 mb10">
                            <md-input-container flex="" class="md-default-theme">
                                <label for="input_00E">To Date</label>
                                <input type="text" ng-model="todate" name="to_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" ng-focus="open($event,'opened2')" is-open="opened2" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" required>
                            </md-input-container>
                             <span class="help-block" ng-show="emailForm.to_date.$dirty && emailForm.to_date.$invalid">
                                <span ng-show="emailForm.to_date.$error.required">Select To Date</span>
                            </span>
                        </div>
                    </div>
                     <div class="col-sm-10 col-sm-offset-1 mb10">
                     <select class="form-control selectdrop testSelAll2" placeholder="Select Event Type" required="required" name="p_level[]" multiple>
                     	<option value="1" >Ticket</option>
                        <option value="2">DPR</option>
                        <option value="0">Event</option>
                     </select>
                     <span class="help-block" ng-show="emailForm['p_level[]'].$dirty && emailForm['p_level[]'].$invalid">
                        <span ng-show="emailForm['p_level[]'].$error.required">Select Event Type</span>
                    </span>
                     </div>
                     <div class="col-sm-6 col-sm-offset-5">
						<p class="btn btn-info btn-sm" click-once ng-disabled="emailForm.$invalid || emailForm.$pristine" ng-click="sendEmail()">Send Calendar</p>
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