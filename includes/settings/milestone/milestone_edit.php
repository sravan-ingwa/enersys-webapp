<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
</style>
<div class="modal-style" ng-controller="milestoneEditCntl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit Milestone</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" reset-directive="singleViews" name="milestoneForm" data-went="#/settings/milestone/milestone_view" method="post" url="services/settings/milestone_update" ng-submit="sendPost()" novalidate>
                 <input name="mile_stone_alais" value="{{singleViews.mile_stone_alais}}" type="hidden">
                <div class="row form-group">
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Milestone</label>
                            <input value="{{singleViews.mile_stone}}" ng-model="singleViews.mile_stone" class="ng-pristine ng-valid md-input ng-touched" name="mile_stone" id="input_00A" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="milestoneForm.mile_stone.$dirty && milestoneForm.mile_stone.$invalid">
                            <span ng-show="milestoneForm.mile_stone.$error.required">Milestone is Required</span>
                        </span>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm" 
                             ng-disabled="milestoneForm.mile_stone.$dirty && milestoneForm.mile_stone.$invalid">Update</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose();">Close</button>
                    </div>
               </div>
          </form>   
	</div>
</div>
