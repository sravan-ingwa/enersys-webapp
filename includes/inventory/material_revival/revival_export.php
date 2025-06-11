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
		<h4 class="modal-title">Export Revival</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
		<form class="form-horizontal forms_add" name="revivalexportForm" data-went="#/Revival" method="post" url="services/inventory/material_revival_export" ng-submit="sendPost()" novalidate>
            <div class="row form-group" ng-controller="DatepickerDemoCtrl">
                <div class="col-sm-4">
                    <md-input-container flex="" class="md-default-theme">
                        <label for="input_00D">From Date</label>
                        <input type="text" ng-model="fromdate" name="from_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" ng-focus="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"  ng-focus="fromtocal()"/>
                    </md-input-container>
                </div>
                <div class="col-sm-4">
                    <md-input-container flex="" class="md-default-theme">
                        <label for="input_00E">To Date</label>
						<input type="text" ng-model="todate" name="to_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" ng-focus="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}" min-date="dateDiff" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>
                    </md-input-container>
                </div>
			  <div class="col-sm-4" ng-controller="selfWarehouse">
					<label class="selectlabel">Select Warehouse</label>
                    <select class="form-control testSelAll3 selectdrop" name="wh_alias[]" ng-model="wh_alias" multiple>
                        <option ng-repeat="mrt in firstDrop" value="{{mrt.alias}}">{{mrt.name}}</option>
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