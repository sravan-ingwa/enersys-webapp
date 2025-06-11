<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
.SumoSelect > .optWrapper > .options > .selected{background-color : #428bca;}
.SumoSelect > .optWrapper > .options > .selected > label{ color:#fff;}
</style>
<div ng-controller="EnersysExpenseCtrl">
<div class="modal-style" ng-controller="ApproversCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Update Approvers</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body">
        
        	 <form class="form-horizontal forms_request" name="approversEditForm" data-went="#/approvers" method="post" url="services/expense_tracker/approvers_update" ng-submit="sendRequest()" novalidate>
                <input type="hidden" name="approval_alias" value="{{expenseViews.approval_alias}}" />
                <div class="row form-group">
                 	<div class="col-sm-10 col-sm-offset-1 mb10" ng-controller="depDropCntrl">
                    	  <label class="selectlabel">Approval for(Department):</label>
                          <select class="form-control padding-none" name="department_alias" ng-model="department" ng-init="exp_dep_drop(expenseViews.department_alias)"  placeholder="Department" disabled="disabled">
                           <!-- <option value="" selected="">Department</option>-->
                            <option ng-repeat="department in firstDrop" value="{{department.alias}}"  ng-selected="expenseViews.approval_deptalias.indexOf(department.alias) != -1">{{department.name}}</option>
                    	</select>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 mb10">
                    	  <label class="selectlabel">Approval Level:</label>
                          <select class="form-control padding-none" name="app_level" ng-model="department" disabled="disabled">
                            <option value="" selected="">Select Level</option>
                            <option ng-repeat="appr in applevels" value="{{appr.alias}}" ng-selected="appr.alias == expenseViews.approval_levelalias">{{appr.name}}</option>
                    	  </select>
                    </div>
                    <div ng-controller="depEmpDropCtrl">
                        <div class="col-sm-10 col-sm-offset-1 mb10">
                              <label class="selectlabel">Approver Department :</label>
                              <select class="form-control padding-none SlectBox" name="appdepartment_alias" ng-model="department" ng-init="dep_drop(expenseViews.approver_depalias)" data-ng-change="dep_emp_mul()" placeholder="Department" required>
                                <!--<option value="" selected="">Department</option>-->
                                <option ng-repeat="department in firstDrop" value="{{department.alias}}" ng-selected="department.alias == expenseViews.approver_depalias">{{department.name}}</option>
                            </select>
                            <span class="help-block" ng-show="approversEditForm.appdepartment_alias.$dirty && approversEditForm.appdepartment_alias.$invalid">
                                <span ng-show="approversEditForm.appdepartment_alias.$error.required">Approver Department is Required</span>
                           </span>
                        </div>
                        <div class="col-sm-10 col-sm-offset-1 mb10">
                              <label class="selectlabel">Approval Employee :</label>
                              <select class="form-control padding-none SlectBox" name="employ_alias" ng-model="employee" ng-init="dep_drop2(expenseViews.approveralias)" required>
                                <option value="" selected="">Select Employee</option>
                                <option ng-repeat="emp in secondDrop" value="{{emp.alias}}" ng-selected="emp.alias == expenseViews.approveralias">{{emp.name}}</option>
                              </select>
                              <span class="help-block" ng-show="approversEditForm.employ_alias.$dirty && approversEditForm.employ_alias.$invalid">
                                    <span ng-show="approversEditForm.employ_alias.$error.required">Approval Employee is Required</span>
                               </span>
                        </div>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5">
                         <button type="submit" click-once class="btn btn-info btn-sm" 
                            ng-disabled="approversEditForm.appdepartment_alias.$dirty && approversEditForm.appdepartment_alias.$invalid ||
                            approversEditForm.employ_alias.$dirty && approversEditForm.employ_alias.$invalid">Update</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose();">Close</button>
                    </div>
               </div>
          </form>   
	</div>
</div>
</div>
<script>
setInterval(function(){$('.SlectBox').SumoSelect();
$('.forms_request').find('.SumoSelect').addClass('singleSelect');},0);
</script>