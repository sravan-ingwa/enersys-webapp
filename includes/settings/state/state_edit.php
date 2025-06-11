<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.selectdrop {
	overflow-y: scroll
}
.datepicker {
	border-bottom: 1px solid #efefef!important
}
.singleSelect {
	width: 100%;
	border-bottom: 1px solid #e0e0e0
}
.SumoSelect>.optWrapper {
	right: 0!important
}
.SumoSelect>.CaptionCont>span.placeholder {
	color: #ccc!important
}
.singleSelect>.CaptionCont>label>i {
	color: #000
}
.SumoSelect>.optWrapper.open {
	top: 33px!important
}
</style>
<div class="modal-style">	<!-- wrapper for specific style -->
<div ng-controller="stateEditCntl">
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit State</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" reset-directive="singleViews" name="stateForm" data-went="#/settings/state/state_view" method="post" url="services/settings/state_update" ng-submit="sendPost()" novalidate>
                <input name="state_alias" value="{{singleViews.state_alias}}" type="hidden">
                <div class="row form-group" ng-controller="selectZoneCntrl">
                    <div class="col-sm-10 col-sm-offset-1 mb10">
                		<label class="selectlabel">Zone</label>
                        <select class="form-control testSelAll2 editselectdrop" name="zone_alias" ng-model="zones" required>
                            <option value="" selected="" disabled="disabled">Select Zone</option>
                            <option ng-repeat="zone in firstDrop" value="{{zone.alias}}" ng-selected="zone.alias == singleViews.zone_alias">{{zone.name}}</option>
                    	</select>
                         <span class="help-block" ng-show="stateForm.zone_alias.$dirty && stateForm.zone_alias.$invalid">
                            <span ng-show="stateForm.zone_alias.$error.required">Select Zone Name</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">State Name</label>
                            <input value="{{singleViews.state_name}}" ng-model="singleViews.state_name" class="ng-pristine ng-valid md-input ng-touched" name="state_name" id="input_00B" tabindex="0" aria-invalid="false" required>
                        </md-input-container>
                         <span class="help-block" ng-show="stateForm.state_name.$dirty && stateForm.state_name.$invalid">
                            <span ng-show="stateForm.state_name.$error.required">State Name is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">State Code</label>
                            <input value="{{singleViews.state_code}}" ng-model="singleViews.state_code" name="state_code" class="ng-pristine ng-valid md-input ng-touched" id="input_00C" tabindex="0" aria-invalid="false" required>
                        </md-input-container>
                         <span class="help-block" ng-show="stateForm.state_code.$dirty && stateForm.state_code.$invalid">
                            <span ng-show="stateForm.state_code.$error.required">State Code is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm" 
                            ng-disabled="stateForm.zone_alias.$dirty && stateForm.zone_alias.$invalid ||
                             stateForm.state_name.$dirty && stateForm.state_name.$invalid || 
                            stateForm.state_code.$dirty && stateForm.state_code.$invalid">Update</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose();">Close</button>
                    </div>
               </div>
          </form>   
	</div>
  </div>
</div>
<script>
	setInterval(function(){
		$('.testSelAll2').SumoSelect();
		$('.testSelAll3').SumoSelect({selectAll:true});
		$('.forms_add').find('.SumoSelect').addClass('singleSelect');
	},0);
</script>