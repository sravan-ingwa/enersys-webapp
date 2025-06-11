<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
</style>
<div class="modal-style" ng-controller="departmentEditCntl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit Department</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
         <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" reset-directive="singleViews" name="departmentForm" data-went="#/settings/department/department_view" method="post" url="services/settings/department_update" ng-submit="sendPost()" novalidate>
                <input name="department_alias" value="{{singleViews.department_alias}}" type="hidden">
                <div class="row form-group">
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Department Name</label>
                            <input value="{{singleViews.department_name}}" ng-model="singleViews.department_name" class="ng-pristine ng-valid md-input ng-touched" name="department_name" id="input_00A" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="departmentForm.department_name.$dirty && departmentForm.department_name.$invalid">
                            <span ng-show="departmentForm.department_name.$error.required">Department Name is Required</span>
                        </span>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm"  ng-disabled="departmentForm.department_name.$dirty && departmentForm.department_name.$invalid">Update</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose();">Close</button>
                    </div>
               </div>
          </form>   
	</div>
</div>