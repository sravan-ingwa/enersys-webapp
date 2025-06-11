<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
</style>
<div>
<div class="modal-style">
	<div class="modal-header clearfix">
		<h4 class="modal-title">Create Shift</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" name="shiftForm" data-went="#/settings/shift/shift_view" method="post" url="services/settings/shift_add" ng-submit="sendPost()" novalidate>
                <div class="row form-group">
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Shift</label>
                            <input ng-model="shift_name" name="shift_name" class="ng-pristine ng-valid md-input ng-touched" required>
                        </md-input-container>
                         <span class="help-block" ng-show="shiftForm.shift_name.$dirty && shiftForm.shift_name.$invalid">
                            <span ng-show="shiftForm.shift_name.$error.required">Shift Name is Required</span>
                        </span>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm subdisabled"  ng-disabled="shiftForm.$invalid || ShiftForm.$pristine">Create</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose()">Close</button>
                    </div>
               </div>
          </form>   
	</div>  
</div>
</div>