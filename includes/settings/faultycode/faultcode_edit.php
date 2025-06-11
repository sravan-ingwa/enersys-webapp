<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
</style>
<div>
<div class="modal-style" ng-controller="faultycodeEditCntl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit Fault Code</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" reset-directive="singleViews" name="faultycodeForm" data-went="#/settings/faultycode/faultcode_view" method="post" url="services/settings/faultycode_update" ng-submit="sendPost()" novalidate>
                <input name="faulty_alias" value="{{singleViews.faulty_alias}}" type="hidden">
                <div class="row form-group">
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Fault Code</label>
                            <input value="{{singleViews.faulty_code}}" ng-model="singleViews.faulty_code" class="ng-pristine ng-valid md-input ng-touched" name="faulty_code" id="input_00A" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="faultycodeForm.faulty_code.$dirty && faultycodeForm.faulty_code.$invalid">
                            <span ng-show="faultycodeForm.faulty_code.$error.required">Fault Code is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Description</label>
                            <input value="{{singleViews.description}}" ng-model="singleViews.description" class="ng-pristine ng-valid md-input ng-touched" name="description" id="input_00B" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="faultycodeForm.description.$dirty && faultycodeForm.description.$invalid">
                            <span ng-show="faultycodeForm.description.$error.required">Description is Required</span>
                        </span>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm" 
                             ng-disabled="faultycodeForm.faulty_code.$dirty && faultycodeForm.faulty_code.$invalid ||
                             faultycodeForm.description.$dirty && faultycodeForm.description.$invalid">Update</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose();">Close</button>
                    </div>
               </div>
          </form>   
	</div>
</div>
</div>
