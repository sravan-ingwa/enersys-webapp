<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.singleSelect {
	width: 100%;
	border-bottom: 1px solid #e0e0e0;
}
.SumoSelect > .optWrapper {
	right: 0px !important;
}
.SumoSelect > .CaptionCont > span.placeholder {
	color: #ccc !important;
}
.singleSelect > .CaptionCont > label > i {
	color: #000;
}
.SumoSelect > .optWrapper.open {
	top: 33px !important;
}
</style>
<div class="modal-style" ng-controller="itemEditCntl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Update Items</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
            <!--<div class="toast toast-topRight">
                <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                    <div ng-bind-html="toast.msg"></div>
                </alert>
            </div>-->
        	<form class="form-horizontal forms_add" name="itemsForm" data-went="#/inventory/items/items_view" method="post" url="services/inventory/item_code_update" ng-submit="sendPost()" novalidate>
                 <input type="hidden" name="item_code_alias" value="{{singleViews.item_code_alias}}" />
                 <div class="row form-group">
                 	<div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00A">Cell Number</label>
                            <input ng-model="singleViews.item_description" valid-input value="{{singleViews.item_description}}" class="upper ng-pristine ng-valid md-input ng-touched" name="cell_no" id="input_00A" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="itemsForm.cell_no.$dirty && itemsForm.cell_no.$invalid">
                            <span ng-show="itemsForm.cell_no.$error.required">Cell Number is Required</span>
                        </span>
                    </div>


                    <div class="col-sm-4" ng-controller="productdropCntrl" ng-if="singleViews.item_type=='1'">
                      <label class="selectlabel">Item Code</label>
                      <select class="form-control testSelAll3 selectdrop" placeholder="Select Item Code" ng-model="item_code" name="item_code">
                        <option value="" selected="selected" disabled="disabled">Select Item Code</option>
                        <option ng-repeat="product in firstDrop" value="{{product.alias}}" ng-selected="product.alias==singleViews.item_type_alias">{{product.name}}</option>
                      </select>
                        <span class="help-block" ng-show="itemsForm.item_code.$dirty && itemsForm.item_code.$invalid">
                            <span ng-show="itemsForm.item_code.$error.required">Select Item Code</span>
                        </span>
                    </div>
                    <div class="col-sm-4" ng-controller="accessorydropCntrl" ng-if="singleViews.item_type=='2'">
                      <label class="selectlabel">Item Code</label>
                      <select class="form-control testSelAll3 selectdrop" placeholder="Select Item Code" ng-model="item_code" name="item_code">
                        <option value="" selected="selected" disabled="disabled">Select Item Code</option>
                        <option ng-repeat="product in firstDrop" value="{{product.alias}}" ng-selected="product.alias==singleViews.item_type_alias">{{product.name}}</option>
                      </select>
                        <span class="help-block" ng-show="itemsForm.item_code.$dirty && itemsForm.item_code.$invalid">
                            <span ng-show="itemsForm.item_code.$error.required">Select Item Code</span>
                        </span>
                    </div>
                    
                     <div class="col-sm-4" ng-controller="sjolist">
                        <label class="selectlabel">SJO Number</label>
                        <select class="form-control testSelAll3 selectdrop" placeholder="Select SJO Number" name="sjo_no" ng-model="sjo_no">
                          <option value="">Select SJO Number</option>
                          <option ng-repeat="sjo in firstDrop" ng-if="sjo.alias!=''" value="{{sjo.alias}}" ng-selected="sjo.alias == singleViews.mrf_alias">{{sjo.name}}</option>
                        </select>
                        <!--<span class="help-block" ng-show="itemsForm.sjo_no.$dirty && itemsForm.sjo_no.$invalid">
                            <span ng-show="itemsForm.sjo_no.$error.required">Select SJO Number</span>
                        </span>-->
                      </div>
                  </div>
                  
                  <div class="row form-group">
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00B">Invoice / GRN Number </label>
                            <input ng-model="singleViews.invoice_no" value="{{singleViews.invoice_no}}" class="ng-pristine ng-valid md-input ng-touched" name="invoice_no" id="input_00B" tabindex="0" aria-invalid="false">
                        </md-input-container>
                         <span class="help-block" ng-show="itemsForm.invoice_no.$dirty && itemsForm.invoice_no.$invalid">
                            <span ng-show="itemsForm.invoice_no.$error.required">Invoice / GRN Number is Required</span>
                        </span>
                    </div>
                    
                     <div class="col-sm-4" ng-controller="DatepickerDemoCtrl">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00C">Invoice Date</label>
                            <input readonly="readonly" type="text" ng-model="singleViews.invoice_date" value="{{singleViews.invoice_date}}" class="datepicker border-bottom" name="invoice_date" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" is-open="opened" min-date="01-01-2000" max-date="'22-06-2025'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>                                                  </td>
                        </md-input-container>
                        <!--<span class="help-block" ng-show="itemsForm.invoice_date.$dirty && itemsForm.invoice_date.$invalid">
                            <span ng-show="itemsForm.invoice_date.$error.required">Invoice Date is Required</span>
                        </span>-->
                      </div>
                      
                      <div class="col-sm-4" ng-controller="stockcodeCtrl_cell">
                        <label class="selectlabel">Select Cell Condtion</label>
                        <select class="form-control testSelAll3 selectdrop" placeholder="Select Cell Condtion" name="condtion" ng-model="condtion">
                          <option value="" selected="selected" disabled="disabled">Select Cell Condition</option>
                          <option ng-repeat="cond in firstDrop" value="{{cond.alias}}" ng-if="cond.name.indexOf('Accessory') === -1" ng-selected="cond.alias==singleViews.condition_id">{{cond.name}}</option>
                        </select>
                        <!--<span class="help-block" ng-show="itemsForm.condtion.$dirty && itemsForm.condtion.$invalid">
                            <span ng-show="itemsForm.condtion.$error.required">Select Cell Condtion</span>
                        </span>-->
                      </div>
                    </div>
					
					<div class="row form-group">
                      <div class="col-sm-4">
                        <label class="selectlabel">Select Factory Condtion</label>
                        <select class="form-control testSelAll3 selectdrop" placeholder="Select Factory Condtion" name="cell_type" ng-model="cell_type">
                          <option value="" disabled="disabled">Select Factory Condtion</option>
                          <option value="1" ng-selected="singleViews.cell_type=='NEW'">NEW</option>
						  <option value="2" ng-selected="singleViews.cell_type=='REVIVED'">REVIVED</option>
                        </select>
                        <!--<span class="help-block" ng-show="itemsForm.cell_type.$dirty && itemsForm.cell_type.$invalid">
                            <span ng-show="itemsForm.cell_type.$error.required">Select Factory Condtion</span>
                        </span>-->
                      </div>
					 </div>
                    
					<div class="row form-group">
                     <div class="col-sm-6 col-sm-offset-5">
                        <button type="submit" click-once class="btn btn-info btn-sm"
                         ng-disabled="itemsForm.cell_no.$dirty && itemsForm.cell_no.$invalid ||
                         itemsForm.item_code.$dirty && itemsForm.item_code.$invalid ||
                         itemsForm.sjo_no.$dirty && itemsForm.sjo_no.$invalid ||
                         itemsForm.invoice_no.$dirty && itemsForm.invoice_no.$invalid ||
                         itemsForm.invoice_date.$dirty && itemsForm.invoice_date.$invalid ||
                         itemsForm.condtion.$dirty && itemsForm.condtion.$invalid">Update</button>
                        <button type="reset" class="btn btn-info btn-sm">Reset</button>
                    </div>
               </div>
          </form>   
	</div>
</div>
<script>
	setInterval(function(){
		$('.testSelAll2').SumoSelect({selectAll:true});
		$('.testSelAll3').SumoSelect();
		$('.forms_add').find('.SumoSelect').addClass('singleSelect');
	},0);
</script>