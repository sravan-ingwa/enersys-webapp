<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
</style>
<div class="modal-style" ng-controller="designationEditCntl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit Designation</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" reset-directive="singleViews" name="designationForm" data-went="#/settings/designation/designation_view" method="post" url="services/settings/designation_update" ng-submit="sendPost()" novalidate>
                <input name="designation_alias" value="{{singleViews.designation_alias}}" type="hidden">
                <div class="row form-group">
                	<div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Grade</label>
                            <input value="{{singleViews.grade}}" ng-model="singleViews.grade" class="ng-pristine ng-valid md-input ng-touched" name="grade" id="input_00A" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="designationForm.grade.$dirty && designationForm.grade.$invalid">
                            <span ng-show="designationForm.grade.$error.required">Grade is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Designation</label>
                            <input value="{{singleViews.designation}}" ng-model="singleViews.designation" class="ng-pristine ng-valid md-input ng-touched" name="designation" id="input_00C" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="designationForm.designation.$dirty && designationForm.designation.$invalid">
                            <span ng-show="designationForm.designation.$error.required">Designation is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm" 
                             ng-disabled="designationForm.grade.$dirty && designationForm.grade.$invalid ||
                             designationForm.designation.$dirty && designationForm.designation.$invalid">Update</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose();">Close</button>
                    </div>
               </div>
          </form>   
	</div>
</div>