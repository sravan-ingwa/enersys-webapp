<style>
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
	<div class="modal-header clearfix">
		<h4 class="modal-title">Export Material Inward Balance</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
		  <!--<div class="toast toast-topRight">
			<alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
			  <div ng-bind-html="toast.msg"></div>
			</alert>
		  </div>-->
		<form class="form-horizontal forms_add" name="materialbalanceexportForm" data-went="#/Materialinward" method="post" url="services/inventory/material_inward_balance_export" ng-submit="sendPost()" novalidate>
            <div class="row form-group">
                <div class="col-sm-10 col-sm-offset-1" ng-controller="selfWarehouse">
					<label class="selectlabel">Select Warehouse</label>
                    <select class="form-control testSelAll3 selectdrop" name="warehouse[]" ng-model="warehouse" multiple="multiple">
                        <option ng-repeat="mrt in firstDrop" value="{{mrt.alias}}">{{mrt.name}}</option>
                    </select>
                </div>
                <!--<div ng-controller="monthYearCtrl">
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">From Date</label>
                            <input type="text" ng-model="fromdate" name="from_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{formatt}}" ng-click="open($event,'opened')" is-open="opened" date-lower-than="{{ToDate}}" min-mode="dt" datepicker-mode="'month'"  datepicker-options="{minMode: 'month'}" date-disabled="disabled(month, mode)"  show-button-bar="false"/>
                        </md-input-container>
                    </div>
                </div>-->
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
	setInterval(function(){$('.testSelAll2').SumoSelect();
	$('.forms_add').find('.SumoSelect').addClass('singleSelect');},0);
</script>