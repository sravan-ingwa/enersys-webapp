<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
</style>
<div>
<div class="modal-style">
	<div class="modal-header clearfix">
		<h4 class="modal-title">Create Site Status</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toastss" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" name="sitestatusForm" data-went="#/settings/sitestatus/sitestatus_view" method="post" url="services/settings/sitestatus_add" ng-submit="sendPost()" novalidate>
                <div class="row form-group">
                    <div class="col-sm-8 col-sm-offset-2" ng-class="{'has-error' : submitted && sitestatusForm.site_status.$invalid}">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">site status</label>
                            <input ng-model="site_status" name="site_status" class="ng-pristine ng-valid md-input ng-touched" id="input_00A" tabindex="0" aria-invalid="false" required>
                        </md-input-container>
                    	<span class="help-block" ng-show="submitted && sitestatusForm.site_status.$error.required">Site Status is Required</span>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm" ng-click="submitted=true">Create</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose()">Close</button>
                    </div>
               </div>
          </form>   
	</div>  
</div>
</div>