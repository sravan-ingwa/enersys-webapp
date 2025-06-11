<style>
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
</style>
<div class="modal-style" ng-controller="fromToDateCtrl">
<div  ng-controller="stockcodeexpCtrl_cell">
	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Export Stocks</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
      <!--<div class="toast toast-topRight">
        <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
          <div ng-bind-html="toast.msg"></div>
        </alert>
      </div>-->
		<form class="form-horizontal forms_add" data-went="#/items_view" method="post" url="services/inventory/stocks_export" ng-submit="sendPost()" novalidate>
            <div class="row form-group">
				<div class="col-sm-4" ng-if="datas.emp_alias!='DWH4PLGSLK'">
					<label class="selectlabel">Select Data Filter</label>
					<select class="form-control testSelAll2 selectdrop" ng-model="date_filter" name="date_filter">
						<option value="" selected="selected" disabled="disabled">Select Data Filter</option>
						<option value="1">Created Date</option>
						<option value="2">SJO Date</option>
						<option value="3">Invoice Date</option>
					</select>
                </div>
				<div class="col-sm-4" ng-if="datas.emp_alias=='DWH4PLGSLK'">
					<label class="selectlabel">Select Data Filter</label>
					<select class="form-control testSelAll2 selectdrop" ng-model="date_filter" name="date_filter">
						<option value="" selected="selected" disabled="disabled">Select Data Filter</option>
						<option value="2">SJO Date</option>
					</select>
				</div>
			
			<div ng-controller="DatepickerDemoCtrl">
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
				</div>
			</div>
			<div class="row form-group">
				<div class="col-sm-4"  ng-controller="productdropCntrl">
                    <label class="selectlabel">Battery Rating</label>
                    <select multiple="multiple" placeholder="Battery Rating" name="b_rating[]" class="testSelAll3 form-control selectdrop" ng-model="b_rating">
                        <option ng-repeat="prod in firstDrop" value="{{prod.alias}}">{{prod.name}}</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <md-input-container flex="" class="md-default-theme">
                        <label for="input_00D">SJO Number</label>
                        <input type="text" ng-model="sjo_num" name="sjo_num" placeholder="SJO Number" />
                    </md-input-container>
                </div>
                <div class="col-sm-4">
                    <md-input-container flex="" class="md-default-theme">
                        <label for="input_00D">Invoice Number</label>
                        <input type="text" ng-model="invc_num" name="invc_num" placeholder="Invoice Number" />
                    </md-input-container>
                </div>
            </div>
            <div class="row form-group">
			<div ng-controller="stockcodeCtrl_cell">
				<div class="col-sm-4" ng-if="(datas.emp_alias!='DWH4PLGSLK') && (datas.emp_alias!='BWIHQNHG8F') && (datas.emp_alias!='GM5I41RNLO')">
                    <label class="selectlabel">Cell Condition</label>
                    <select multiple="multiple" placeholder="Cell Condition" name="cell_cond[]" class="testSelAll3 form-control selectdrop" ng-model="cell_cond">
                        <option ng-repeat="cell in firstDrop" value="{{cell.alias}}" ng-if="cell.name.indexOf('Accessory') === -1">{{cell.name}}</option>
                    </select>
                </div>
				
				<div class="col-sm-4" ng-if="(datas.emp_alias=='DWH4PLGSLK') || (datas.emp_alias=='BWIHQNHG8F') || (datas.emp_alias=='GM5I41RNLO')">
                    <label class="selectlabel">Cell Condition</label>
                    <select multiple="multiple" placeholder="Cell Condition" name="cell_cond[]" class="testSelAll3 form-control selectdrop" ng-model="cell_cond" readonly>
                        <option value="1" ng-selected="true">NEW CELL</option>
                    </select>
                </div>
				
				
                <div class="col-sm-4" ng-if="(datas.emp_alias=='DWH4PLGSLK') || (datas.emp_alias=='BWIHQNHG8F') || (datas.emp_alias=='GM5I41RNLO')" ng-controller="warehousedropCtrl">
	                <label class="selectlabel">Select Warehouse</label>
                    <select class="testSelAll3 form-control selectdrop" placeholder="Select Warehouse" name="wh[]" ng-model="wh" multiple="multiple">
                        <option ng-repeat="ware in firstDrop" value="{{ware.alias}}">{{ware.name}}</option>
                    </select>
                </div>
				<div class="col-sm-4" ng-if="(datas.emp_alias!='DWH4PLGSLK') && (datas.emp_alias!='BWIHQNHG8F') && (datas.emp_alias!='GM5I41RNLO')" ng-controller="warehouseEmpdropCtrl">
	                <label class="selectlabel">Select Warehouse</label>
                    <select class="testSelAll3 form-control selectdrop" placeholder="Select Warehouse" name="wh[]" ng-model="wh" multiple="multiple">
                        <option ng-repeat="ware in firstDrop" value="{{ware.alias}}">{{ware.name}}</option>
                    </select>
                </div>
				</div>
				<div class="col-sm-4">
                	<label class="selectlabel">Select Item Type<sup style="color:#F00">*</sup></label>
                    <select class="form-control testSelAll3 selectdrop" ng-model="item_type" name="item_type[]" multiple="multiple">
                        <option value="1" ng-selected="true">Cells</option>
                        <option value="2">Accessories</option>
                    </select>
                </div> 
            </div> 
			<div class="row form-group">
              <div class="col-sm-4">
                <label class="selectlabel">Data Type<sup style="color:#F00" ng-if="item_type.indexOf('1') != -1">*</sup></label>
                    <select class="form-control testSelAll2 selectdrop" ng-disabled="item_type.indexOf('1') == -1" placeholder="Select Data Type" name="datetype" ng-model="datetype">
						<option value="">Select Data Type</option>
                        <option value="1">Without Cell History</option>
                        <option value="2">With Cell History</option>
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
</div>
<script>
	setInterval(function(){
		$('.testSelAll2').SumoSelect();
		$('.testSelAll3').SumoSelect({selectAll:true});
		$('.forms_add').find('.SumoSelect').addClass('singleSelect');
	},0);
</script>