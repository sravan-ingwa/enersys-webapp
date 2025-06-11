<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
</style>
<div class="modal-style" ng-controller="EnersysExpenseCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Create Approvers</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body">
       
        <form class="form-horizontal forms_request" name="approversForm" data-went="#/approvers" method="post" url="services/expense_tracker/approvers_add" ng-submit="sendRequest()" novalidate>
                <div class="row form-group">
                 	<div class="col-sm-10 col-sm-offset-1 mb10" ng-controller="depDropCntrl">
                    	  <label class="selectlabel">Approval for(Department):</label>
                          <select class="form-control selectdrop testSelAll2" multiple name="department_alias[]" ng-model="department" placeholder="Department" required>
                            <!--<option value="" selected>Department</option>-->
                            <option ng-repeat="department in firstDrop" value="{{department.alias}}">{{department.name}}</option>
                    	</select>
                        <span class="help-block" ng-show="approversForm['department_alias[]'].$dirty && approversForm['department_alias[]'].$invalid">
                            <span ng-show="approversForm['department_alias[]'].$error.required">Department is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 mb10">
                    	  <label class="selectlabel">Approval Level:</label>
                          <select class="form-control padding-none testSelAll2" name="app_level" ng-model="approval_level" required>
                                <option value="" selected>Select Level</option>
                                <option ng-repeat="appr in applevels" value="{{appr.alias}}" >{{appr.name}}</option>
                           </select>
                           <span class="help-block" ng-show="approversForm.app_level.$dirty && approversForm.app_level.$invalid">
                                <span ng-show="approversForm.app_level.$error.required">Approval Level is Required</span>
                           </span>
                    </div>
                    <div ng-controller="depEmpDropCtrl">
                        <div class="col-sm-10 col-sm-offset-1 mb10">
                              <label class="selectlabel">Approver Department :</label>
                              <select class="form-control testSelAll2 selectdrop" name="appdepartment_alias" ng-model="department" data-ng-change="dep_emp_mul()" placeholder="Department" required> 
                                <!--<option value="" style="display:none;" selected>Department</option>-->
                                <option ng-repeat="apdep in firstDrop" value="{{apdep.alias}}">{{apdep.name}}</option>
                            </select>
                            <span class="help-block" ng-show="approversForm.appdepartment_alias.$dirty && approversForm.appdepartment_alias.$invalid">
                                <span ng-show="approversForm.appdepartment_alias.$error.required">Approver Department is Required</span>
                            </span>
                        </div>
                        <div class="col-sm-10 col-sm-offset-1 mb10">
                              <label class="selectlabel">Approval Employee :</label>
                              <select class="form-control testSelAll2 selectdrop" name="employ_alias" ng-model="employee" required>
                                <option value="" style="display:none;" selected>Select Employee</option>
                                <option ng-repeat="emp in secondDrop" value="{{emp.alias}}">{{emp.name}}</option>
                              </select>
                              <span class="help-block" ng-show="approversForm.employ_alias.$dirty && approversForm.employ_alias.$invalid">
                                    <span ng-show="approversForm.employ_alias.$error.required">Approval Employee is Required</span>
                              </span>
                        </div>
                    </div>
                     <div class="col-sm-6 col-sm-offset-4">
                            <button type="submit" class="btn btn-info btn-sm" click-once ng-disabled="approversForm.$invalid || approversForm.$pristine">Add Approvals</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose()">Close</button>
                    </div>
               </div>
          </form>   
	</div>
</div>

<script>
setInterval(function(){$('.testSelAll2').SumoSelect();
$('.forms_request').find('.SumoSelect').addClass('singleSelect');},0);
</script>