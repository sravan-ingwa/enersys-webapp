<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
</style>
<div>
<div class="modal-style" ng-controller="zoneEditCntl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit Zone</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" reset-directive="singleViews" name="zoneForm" data-went="#/settings/zone/zone_view" method="post" url="services/settings/zone_update" ng-submit="sendPost()" novalidate>
                <input name="zone_alias" value="{{singleViews.zone_alias}}" type="hidden">
                <div class="row form-group">
                    <div class="col-sm-8 col-sm-offset-2">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00A">Zone</label>
                            <input name="zone_name" value="{{singleViews.zone_name}}" ng-model="singleViews.zone_name" class="ng-pristine ng-valid md-input ng-touched" required="required">              
                        </md-input-container>
                        <span class="help-block" ng-show="zoneForm.zone_name.$dirty && zoneForm.zone_name.$invalid">
                            <span ng-show="zoneForm.zone_name.$error.required">Zone Name is Required</span>
                        </span>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm" ng-disabled="zoneForm.zone_name.$dirty && zoneForm.zone_name.$invalid">Update</button>
                        <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose();">Close</button>
                    </div>
               </div>
          </form>  
	</div>
</div>
</div>