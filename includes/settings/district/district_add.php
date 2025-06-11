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
<div class="modal-style" ng-controller="zoneStateCntrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Create District</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" name="districtForm" data-went="#/settings/district/district_view" method="post" url="services/settings/district_add" ng-submit="sendPost()" novalidate>
                <div class="row form-group">
                    <div class="col-sm-10 col-sm-offset-1 mb10">
                    	<label class="selectlabel">Zone</label>
                        <select class="form-control testSelAll2 selectdrop" name="zone_alias" id="zone" ng-model="zones" ng-change="dep_drop(zones,'state_alias')" required="required">
                            <option value="" selected="selected" disabled="disabled">Select Zone</option>
                            <option ng-repeat="zone in firstDrop" value="{{zone.alias}}">{{zone.name}}</option>
                        </select>
                         <span class="help-block" ng-show="districtForm.zone_alias.$dirty && districtForm.zone_alias.$invalid">
                            <span ng-show="districtForm.zone_alias.$error.required">Select Zone Name</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 mb10">
                    <label class="selectlabel">State</label>
                        <select class="form-control testSelAll2 selectdrop" name="state_alias" id="state" ng-model="states" required>
                            <option value="" selected="selected" disabled="disabled">Select State</option>
                            <option ng-repeat="state in secondDrop" value="{{state.alias}}">{{state.name}}</option>
                        </select>
                         <span class="help-block" ng-show="districtForm.state_alias.$dirty && districtForm.state_alias.$invalid">
                            <span ng-show="districtForm.state_alias.$error.required">Select State Name</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 mb10">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">District</label>
                            <input ng-model="District" class="ng-pristine ng-valid md-input ng-touched" name="district_name" id="input_00C" tabindex="0" aria-invalid="false" required>
                        </md-input-container>
                         <span class="help-block" ng-show="districtForm.district_name.$dirty && districtForm.district_name.$invalid">
                            <span ng-show="districtForm.district_name.$error.required">District Name is Required</span>
                        </span>
                    </div>
                     <div class="col-sm-10 col-sm-offset-1 mb10">
                     <label class="selectlabel">Area</label>
                        <select class="form-control testSelAll2 editselectdrop" name="area" id="area" ng-model="areas" required="required">
                            <option value="" disabled="disabled">Select Area</option>
                            <option value="0">Plain Area</option>
                            <option value="1">Hilly Area</option>
                        </select>
                        <span class="help-block" ng-show="districtForm.area.$dirty && districtForm.area.$invalid">
                            <span ng-show="districtForm.area.$error.required">Select Area</span>
                        </span>
                    </div>
                    <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm" ng-disabled="districtForm.$invalid || districtForm.$pristine">Create</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose()">Close</button>
                    </div>
               </div>
          </form>   
	</div>
</div>
<script>
	setInterval(function(){
		$('.testSelAll2').SumoSelect();
		$('.testSelAll3').SumoSelect({selectAll:true});
		$('.forms_add').find('.SumoSelect').addClass('singleSelect');
	},0);
</script>