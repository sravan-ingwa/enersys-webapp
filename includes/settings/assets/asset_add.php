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
<div class="modal-style" ng-controller="assetdropCntrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Create Asset</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" name="assetsForm" data-went="#/settings/assets/assets_view" method="post" url="services/settings/assets_add" ng-submit="sendPost()" novalidate>
                <div class="row form-group">
                 	<div class="col-sm-10 col-sm-offset-1 mb10">
                    	<label class="selectlabel">Asset Type</label>
                          <select class="form-control testSelAll2 selectdrop" name="asset_type" ng-model="asset_type" required>
                            <option value="" selected disabled="disabled">Asset Type</option>                 
                            <option ng-repeat="asset in assets" value="{{asset.name}}">{{asset.name}}</option>
                    	</select>
                        <span class="help-block" ng-show="assetsForm.asset_type.$dirty && assetsForm.asset_type.$invalid">
                            <span ng-show="assetsForm.asset_type.$error.required">Select Asset Type</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Asset Name</label>
                            <input ng-model="itemname" class="ng-pristine ng-valid md-input ng-touched" name="asset_name" id="input_00B" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="assetsForm.asset_name.$dirty && assetsForm.asset_name.$invalid">
                            <span ng-show="assetsForm.asset_name.$error.required">Asset Name is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Asset Make</label>
                            <input ng-model="itemmake" class="ng-pristine ng-valid md-input ng-touched" name="asset_make" id="input_00C" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="assetsForm.asset_make.$dirty && assetsForm.asset_make.$invalid">
                            <span ng-show="assetsForm.asset_make.$error.required">Asset Make is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Asset Serial Number</label>
                            <input ng-model="itemserialnumber" class="ng-pristine ng-valid md-input ng-touched" name="asset_serial_number" id="input_00D" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="assetsForm.asset_serial_number.$dirty && assetsForm.asset_serial_number.$invalid">
                            <span ng-show="assetsForm.asset_serial_number.$error.required">Asset Serial Number is Required</span>
                        </span>
                    </div>
                    <div ng-if="asset_type == 'TOOLS'" ng-controller="DatepickerDemoCtrl">
                        <div class="col-sm-10 col-sm-offset-1">
                            <md-input-container flex="" class="md-default-theme">
                                <label for="input_00D">Calibration Date</label>
                                <input type="text" class="form-control datepicker border-bottom" name="calibration_date" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" ng-focus="open($event,'opened1')" ng-model="calDate" is-open="opened1" min-date="'01-01-2000'" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" required="required"/>                                              
                            </md-input-container>
                            <span class="help-block" ng-show="assetsForm.calibration_date.$dirty && assetsForm.calibration_date.$invalid">
                                <span ng-show="assetsForm.calibration_date.$error.required">Calibration Date is Required</span>
                            </span>
                        </div>
                        <div class="col-sm-10 col-sm-offset-1">
                            <md-input-container flex="" class="md-default-theme">
                                <label for="input_00D">Calibration Due Date</label>
                                <input type="text" class="form-control datepicker border-bottom" name="calibration_due_date" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" ng-focus="open($event,'opened2')" ng-model="calDueDate" is-open="opened2" min-date="'01-01-2000'" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" required="required"/>                                          
                            </md-input-container>
                             <span class="help-block" ng-show="assetsForm.calibration_due_date.$dirty && assetsForm.calibration_due_date.$invalid">
                                <span ng-show="assetsForm.calibration_due_date.$error.required">Calibration Due Date is Required</span>
                            </span>
                        </div>
                    </div>    
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Specification</label>
                            <input ng-model="specification" class="ng-pristine ng-valid md-input ng-touched" name="specification" id="input_00D" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="assetsForm.specification.$dirty && assetsForm.specification.$invalid">
                            <span ng-show="assetsForm.specification.$error.required">Specification is Required</span>
                        </span>
                    </div>
                     <div class="col-sm-10 col-sm-offset-1 mb10" ng-controller="natureofassetDropCntrl">
                     	<label class="selectlabel">Nature Of Asset</label>
                        <select class="form-control testSelAll2 selectdrop" name="nature_of_asset" ng-model="natureofasset" required>
                            <option value="" selected="" disabled="disabled">Nature Of Asset</option>
                            <option ng-repeat="noa in natureofassets" value="{{noa.name}}">{{noa.name}}</option>
                    	</select>
                        <span class="help-block" ng-show="assetsForm.nature_of_asset.$dirty && assetsForm.nature_of_asset.$invalid">
                            <span ng-show="assetsForm.nature_of_asset.$error.required">Select Nature Of Asset</span>
                        </span>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm"  ng-disabled="assetsForm.$invalid || assetsForm.$pristine">Create</button>
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