<style>
.form-group div.col-sm-4 {
	margin-bottom: 15px
}
.modal-header>.close {
	right: -30px;
	top: -12px
}
.btn-default {
	border-color: transparent!important;
	/*border-bottom: 1px solid #e0e0e0!important*/
}
.autoselect {
	padding-top: 22px!important
}
.upload-file {
	border-bottom: 1px solid rgba(0,0,0,.12)
}
.ui-select-bootstrap>.ui-select-search:focus {
	border: none;
	background: #FFF!important;
	border-bottom: 1px solid #e0e0e0
}
.ui-select-bootstrap>.ui-select-match>button {
	text-align: left!important
}
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
<div class="modal-style" ng-controller="fromToDateCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Export Material Outward</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
		<form class="form-horizontal forms_add" name="outwardexportForm" data-went="#/Materialoutward" method="post" url="services/inventory/material_outward_export" ng-submit="sendPost()" novalidate>
            <div class="row form-group" ng-controller="DatepickerDemoCtrl">
                <div class="col-sm-6">
                    <md-input-container flex="" class="md-default-theme">
                        <label for="input_00D">From Date</label>
                        <input type="text" ng-model="fromdate" name="from_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" ng-focus="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"  ng-focus="fromtocal()"/>
                    </md-input-container>
                </div>
                <div class="col-sm-6">
                    <md-input-container flex="" class="md-default-theme">
                        <label for="input_00E">To Date</label>
						<input type="text" ng-model="todate" name="to_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" ng-focus="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}" min-date="dateDiff" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>
                    </md-input-container>
                </div>
			</div>
            <div class="row form-group" ng-controller="selfWarehouse">
				<div class="col-sm-6">
					<label class="selectlabel">Select From Warehouse</label>
                    <select class="form-control testSelAll3 selectdrop" name="fromwarehouse[]" ng-model="fromwarehouse" multiple>
                        <option ng-repeat="mrt in firstDrop" value="{{mrt.alias}}">{{mrt.name}}</option>
                    </select>
                </div>
               
				<div class="col-sm-6">
					<label class="selectlabel">Select To Warehouse</label>
                    <select class="form-control testSelAll3 selectdrop" name="towarehouse[]" ng-model="towarehouse" multiple>
                        <option ng-repeat="mrts in firstDrop" value="{{mrts.alias}}">{{mrts.name}}</option>
                    </select>
                </div>
			</div>
            <div class="row form-group">
				<div class="col-sm-6">
					<md-input-container flex="" class="md-default-theme md-input-has-value">
						<label for="input_00D">Reference No.</label>
						<input type="text" value="#" ng-modal="trans_id" name="trans_id" class="ng-pristine ng-valid md-input ng-touched" id="input_00D" tabindex="0" aria-invalid="false"/>
					</md-input-container>
				</div>
				 <div class="col-sm-6">
					<label class="selectlabel">Data Type&nbsp;&nbsp;<sub style="color:#F00;font-size:15px;">*</sub></label>
					<select class="form-control testSelAll3 selectdrop" placeholder="Data Type" name="data_type[]" ng-model="data_type" multiple="multiple">
                        <option value="1">Without Cell Serial number</option>
                        <option value="2">With Cell Serial number</option>
					</select>
				</div>
			</div>
            <div class="row form-group">
				<div class="col-sm-6" ng-controller="invenoryLevelsCtrl">
					<label class="selectlabel">Select Level</label>
                    <select class="form-control testSelAll3 selectdrop" name="level[]" ng-model="level" multiple>
						<option value="{{level.alias}}" ng-if="level.alias=='0' || level.alias=='4' || level.alias=='6'" ng-repeat="level in firstDrop">{{level.name}}</option>
                    </select>
                </div>
			</div>      
			<div class="row form-group">
				<div class="col-sm-6 col-sm-offset-5">
                     <input type="submit" click-once value="Run Report" class="btn btn-info btn-sm"/>
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