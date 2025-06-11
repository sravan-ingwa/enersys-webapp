<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
</style>
<div class="modal-style" ng-controller="levelsEditCntl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit Ticket Level</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" reset-directive="singleViews" name="levelForm" data-went="#/settings/levels/levels_view" method="post" url="services/settings/levels_update" ng-submit="sendPost()" novalidate>
                 <input name="level_alias" value="{{singleViews.level_alias}}" type="hidden">
                <div class="row form-group" ng-controller="leveldropCntrl">
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Level Name</label>
                            <input value="{{singleViews.level_name}}" ng-model="singleViews.level_name" class="ng-pristine ng-valid md-input ng-touched" name="level_name" id="input_00A" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="levelForm.level_name.$dirty && levelForm.level_name.$invalid">
                            <span ng-show="levelForm.level_name.$error.required">Level Name is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Level Color</label>
							<input colorpicker="hex" name="level_color" value="{{singleViews.level_color}}" ng-pattern="/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/" ng-model="singleViews.level_color" type="text"  class="form-control" style="color:#FFF" ng-style="{'background': singleViews.level_color}" required="required"/>
                        </md-input-container>
                        <span class="help-block" ng-show="levelForm.level_color.$dirty && levelForm.level_color.$invalid">
                            <span ng-show="levelForm.level_color.$error.required">Level Color is Required</span>
                            <span ng-show="levelForm.level_color.$error.pattern">Level Color Should (Ex:#f00 or #000000) Format only</span>
                        </span>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm" 
                             ng-disabled="levelForm.level_name.$dirty && levelForm.level_name.$invalid ||
                             levelForm.level_color.$dirty && levelForm.level_color.$invalid">Update</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose();">Close</button>
                    </div>
               </div>
          </form>   
	</div>
</div>
