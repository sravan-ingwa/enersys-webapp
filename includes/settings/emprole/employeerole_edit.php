<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
</style>
<div class="modal-style" ng-controller="employeeroleEditCntl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit Roles</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" reset-directive="singleViews" name="emproleForm" data-went="#/settings/emprole/employeerole_view" method="post" url="services/settings/employee_role_update" ng-submit="sendPost()" novalidate>
               <input name="role_alias" value="{{singleViews.role_alias}}" type="hidden">
                <div class="row form-group">
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Employee Role</label>
                            <input value="{{singleViews.role_name}}" ng-model="singleViews.role_name" class="ng-pristine ng-valid md-input ng-touched" name="emp_role" id="input_00A" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="emproleForm.emp_role.$dirty && emproleForm.emp_role.$invalid">
                            <span ng-show="emproleForm.emp_role.$error.required">Employee Role is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Description</label>
                            <input value="{{singleViews.description}}" ng-model="singleViews.description" class="ng-pristine ng-valid md-input ng-touched" name="description" id="input_00B" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="emproleForm.description.$dirty && emproleForm.description.$invalid">
                            <span ng-show="emproleForm.description.$error.required">Description is Required</span>
                        </span>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm"  
                            ng-disabled="emproleForm.role_name.$dirty && emproleForm.role_name.$invalid ||
                             emproleForm.description.$dirty && emproleForm.description.$invalid">Update</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose();">Close</button>
                    </div>
               </div>
          </form>   
	</div>
</div>