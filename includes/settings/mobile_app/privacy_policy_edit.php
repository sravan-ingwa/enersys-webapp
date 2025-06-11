<style>
	.form-group {margin-bottom:15px;}
	.form-group div.col-sm-4{margin-bottom:15px;}
	.modal-header > .close {right:-30px; top:-12px;}
</style>
<div>
<div class="modal-style" ng-controller="privacyController">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit Privacy and Policy</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" reset-directive="singleViews" name="privacyForm" data-went="#/settings" method="post" url="services/settings/privacy_policy_update" ng-submit="sendPost()" novalidate>
                <div class="row form-group">
                    <div class="col-sm-6">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00A">Help</label>
                            <input name="help" value="{{singleViews.help}}" ng-model="singleViews.help" class="ng-pristine ng-valid md-input ng-touched" required="required">              
                        </md-input-container>
                        <span class="help-block" ng-show="privacyForm.help.$dirty && privacyForm.help.$invalid">
                            <span ng-show="privacyForm.help.$error.required">Help Desc Number is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-6">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00A">Login Text</label>
                            <input name="login_text" value="{{singleViews.login_text}}" ng-model="singleViews.login_text" class="ng-pristine ng-valid md-input ng-touched" required="required">              
                        </md-input-container>
                        <span class="help-block" ng-show="privacyForm.login_text.$dirty && privacyForm.login_text.$invalid">
                            <span ng-show="privacyForm.login_text.$error.required">Login Text is Required</span>
                        </span>
                    </div>
					<div class="col-sm-12 mt20">
						<h5 class="text-center mb20">PRIVACY and POLICY</h5>
						<text-angular name="privacy_policy" ng-model="singleViews.privacy_policy" placeholder="Enter Condition Text"></text-angular>
					</div>
                     <div class="col-sm-6 col-sm-offset-5 mt30">
						<button type="submit" click-once class="btn btn-info btn-sm" ng-disabled="privacyForm.help.$dirty && privacyForm.help.$invalid || privacyForm.login_text.$dirty && privacyForm.login_text.$invalid">Update</button>
                        <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose()">Close</button>
                    </div>
               </div>
          </form>  
	</div>
</div>
</div>