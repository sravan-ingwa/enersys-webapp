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
		<h4 class="modal-title">Create Warehouse Code</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" name="warehouseForm" data-went="#/settings/warehouse/warehouse_view" method="post" url="services/settings/warehouse_add" ng-submit="sendPost()" novalidate>
                <div class="row form-group">
                    <div class="col-sm-10 col-sm-offset-1 mb10">
						<label class="selectlabel">Zone</label>
                        <select class="form-control testSelAll2 selectdrop" name="zone_alias" id="zone" ng-model="zones" ng-change="dep_drop(zones,'state_alias')" required="required">
                            <option value="" selected="selected" disabled="disabled">Select Zone</option>
                            <option ng-repeat="zone in firstDrop" value="{{zone.alias}}">{{zone.name}}</option>
                        </select>
                         <span class="help-block" ng-show="warehouseForm.zone_alias.$dirty && warehouseForm.zone_alias.$invalid">
                            <span ng-show="warehouseForm.zone_alias.$error.required">Select Zone Name</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 mb10">
						<label class="selectlabel">State</label>
                        <select class="form-control testSelAll2 selectdrop" name="state_alias" id="state" ng-model="states" required="required">
                            <option value="" selected="selected" disabled="disabled">Select State</option>
                            <option ng-repeat="state in secondDrop" value="{{state.alias}}">{{state.name}}</option>
                        </select>
                         <span class="help-block" ng-show="warehouseForm.state_alias.$dirty && warehouseForm.state_alias.$invalid">
                            <span ng-show="warehouseForm.state_alias.$error.required">Select State Name</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Enter Warehouse Code</label>
                            <input ng-model="warehousecode" class="ng-pristine ng-valid md-input ng-touched" name="wh_code" id="input_00A" tabindex="0" aria-invalid="false" required>
                        </md-input-container>
                         <span class="help-block" ng-show="warehouseForm.wh_code.$dirty && warehouseForm.wh_code.$invalid">
                            <span ng-show="warehouseForm.wh_code.$error.required">Warehouse Code is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Enter Warehouse Description</label>
                            <input ng-model="warehousedesc" class="ng-pristine ng-valid md-input ng-touched" name="description" id="input_00B" tabindex="0" aria-invalid="false" required>
                        </md-input-container>
                         <span class="help-block" ng-show="warehouseForm.description.$dirty && warehouseForm.description.$invalid">
                            <span ng-show="warehouseForm.description.$error.required">Warehouse Description is Required</span>
                        </span>
                    </div>
                     <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Enter Warehouse Address</label>
                            <input ng-model="warehouseaddr" class="ng-pristine ng-valid md-input ng-touched" name="wh_address" id="input_00B" tabindex="0" aria-invalid="false" required>
                        </md-input-container>
                         <span class="help-block" ng-show="warehouseForm.wh_address.$dirty && warehouseForm.wh_address.$invalid">
                            <span ng-show="warehouseForm.wh_address.$error.required">Warehouse Address is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 mb10">
						<label class="selectlabel">Road Permit</label>
                        <select class="form-control testSelAll2 selectdrop" name="road_permit" id="road" ng-model="road_permit" required="required">
                            <option value="" selected="selected" disabled="disabled">Select Road Permit</option>
							<option value="0">NOT REQUIRED</option>
							<option value="1">REQUIRED</option>
                        </select>
                         <span class="help-block" ng-show="warehouseForm.road_permit.$dirty && warehouseForm.road_permit.$invalid">
                            <span ng-show="warehouseForm.road_permit.$error.required">Select Road Permit</span>
                        </span>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5 mt10">
                            <button type="submit" click-once class="btn btn-info btn-sm" ng-disabled="warehouseForm.$invalid || warehouseForm.$pristine">Create</button>
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