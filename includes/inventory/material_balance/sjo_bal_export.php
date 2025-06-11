<style>
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
</style>
<div class="modal-style" ng-controller="fromToDateCtrl">	<!-- wrapper for specific style -->
<div  ng-controller="stockcodeexpCtrl_cell">
	<div class="modal-header clearfix">
		<h4 class="modal-title">Export SJO Tracking</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
		<form class="form-horizontal forms_add" name="sjoexportForm" data-went="#/sjo_search" method="post" url="services/inventory/{{datas.emp_alias!='8NHXNU4NDP' ? 'sjo_bal_export' : 'scrap_inward_by_fact_export'}}" ng-submit="sendPost()" novalidate>
            <div ng-if="datas.emp_alias=='8NHXNU4NDP'">
				<div ng-controller="DatepickerDemoCtrl">
					<div class="col-sm-6">
						<md-input-container flex="" class="md-default-theme">
							<label for="input_00D">From Date</label>
							<input type="text" ng-model="fromdate" name="from_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"  ng-focus="fromtocal()"/>
						</md-input-container>
					</div>
					<div class="col-sm-6">
						<md-input-container flex="" class="md-default-theme">
							<label for="input_00E">To Date</label>
							<input type="text" ng-model="todate" name="to_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}" min-date="dateDiff" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>
						</md-input-container>
					</div>
				</div>
			</div>
			<div ng-if="datas.emp_alias!='8NHXNU4NDP'">
				<div class="row form-group"  ng-controller="DatepickerDemoCtrl">
					<div class="col-sm-4">
						<label class="selectlabel">Select Data Filter <span style="color:#F00">(Choose this to enable dates)</span></label>
						<select class="form-control testSelAll2 selectdrop" ng-model="dates" ng-init="dates=''" name="re_dates">
							<option value="" ng-selected="true">Select Data Filter</option>
							<option value="1">Requested Date</option>
							<option value="2">SJO Date</option>
							<option value="3">Invoice Date</option>
						</select>
					</div> 
					 
					<div ng-controller="DatepickerDemoCtrl">
						<div class="col-sm-4">
							<md-input-container flex="" class="md-default-theme">
								<label for="input_00D">From Date</label>
								<input type="text" ng-model="fromdate" ng-disabled="dates==''" name="from_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" ng-focus="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"  ng-focus="fromtocal()"/>
							</md-input-container>
						</div>
						<div class="col-sm-4">
							<md-input-container flex="" class="md-default-theme">
								<label for="input_00E">To Date</label>
								<input type="text" ng-model="todate" ng-disabled="dates==''" name="to_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" ng-focus="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}" min-date="dateDiff" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>
							</md-input-container>
						</div>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-4">
						<label class="selectlabel">Select Item Type</label>
						<select class="form-control testSelAll2 selectdrop" ng-model="item_type" name="item_type[]" multiple="multiple">
							<option value="1" ng-selected="true">Cells</option>
							<option value="2">Accessories</option>
						</select>
					</div> 
					<div ng-controller="expzoneWareMulCntrl">
						<div class="col-sm-4">
							<label class="selectlabel">Zone</label>
							<select multiple="multiple" placeholder="Zone" name="zone_alias[]" class="testSelAll2 form-control selectdrop" ng-model="zone_alias" ng-change="dep_drop_mul_exp();">
								<option ng-repeat="zone in firstDrop" value="{{zone.alias}}">{{zone.name}}</option>
							</select>
						</div>
						<div class="col-sm-4">
						 <label class="selectlabel">Warehouse</label>
							<select class="form-control testSelAll2 selectdrop" name="wh_alias[]" ng-model="wh_alias">
								<option value="" disabled="disabled">Select Warehouse</option>
								<option ng-repeat="mrt in secondDrop" value="{{mrt.alias}}">{{mrt.name}}</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-4">
						<label class="selectlabel">Data Type</label>
						<select class="form-control testSelAll2 selectdrop" ng-disabled="item_type.indexOf('1') == -1" name="datetype">
							<option value="0" disabled="disabled">Select Data Type<sup>*</sup></option>
							<option value="1">Without Cell Serial number</option>
							<option value="2">With Cell Serial number</option>
							<option value="3">Non SJO</option>
						</select>
					</div> 					
					<div class="col-sm-4" ng-controller="tktcustomerdropCntrl">
						<label class="selectlabel">Customer ID</label>
						<select class="form-control testSelAll3 selectdrop" placeholder="Customer ID" name="customer_alias[]" ng-model="customer" multiple="multiple">
							<option ng-repeat="customer in firstDrop" value="{{customer.alias}}">{{customer.name}}</option>
						</select>
					 </div>
					<div class="col-sm-4" ng-controller="productdropCntrl">
						 <label class="selectlabel">Product</label>
						 <select class="form-control testSelAll2" placeholder="Product" name="product_alias[]" ng-model="product_alias" multiple="multiple">
						  <option ng-repeat="product in firstDrop" value="{{product.alias}}" >{{product.name}}</option>
						</select>
					</div>

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
</div>
<script>
	setInterval(function(){
		$('.testSelAll2').SumoSelect();
		$('.testSelAll3').SumoSelect({selectAll:true});
		$('.forms_add').find('.SumoSelect').addClass('singleSelect');
	},0);
</script>