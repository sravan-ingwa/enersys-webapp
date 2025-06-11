<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
</style>
<div class="modal-style" ng-controller="addFieldsCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Create Stocks</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
            <!--<div class="toast toast-topRight">
                <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                    <div ng-bind-html="toast.msg"></div>
                </alert>
            </div>-->
        	<form class="form-horizontal forms_add" name="itemsForm" data-went="#/settings/items/items_view" method="post" url="services/settings/item_code_add" ng-submit="sendPost()" novalidate>
                 <div class="row form-group">
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00A">SJO Number</label>
                            <input ng-model="sjo_no" class="ng-pristine ng-valid md-input ng-touched" name="sjo_no" id="input_00A" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="itemsForm.sjo_no.$dirty && itemsForm.sjo_no.$invalid">
                            <span ng-show="itemsForm.sjo_no.$error.required">SJO Number is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00B">Invoice No</label>
                            <input ng-model="invoiceno" class="ng-pristine ng-valid md-input ng-touched" name="invoice_no" id="input_00B" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="itemsForm.invoice_no.$dirty && itemsForm.invoice_no.$invalid">
                            <span ng-show="itemsForm.invoice_no.$error.required">Invoice Number is Required</span>
                        </span>
                    </div>
                     <div class="col-sm-4" ng-controller="DatepickerDemoCtrl">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00C">Invoice Date</label>
                            <input type="text" class="datepicker border-bottom" name="invoice_date" ng-model="invoiceDate" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" is-open="opened" min-date="'01-01-2000'" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" required="required"/>                                                  </td>
                        </md-input-container>
                         <span class="help-block" ng-show="itemsForm.invoice_date.$dirty && itemsForm.invoice_date.$invalid">
                            <span ng-show="itemsForm.invoice_date.$error.required">Invoice Date is Required</span>
                        </span>
                    </div>
                 </div>   
                    <div class="row col-sm-12"  ng-repeat="field in forms">
                        <div class="header">
                            <h4>Items
                                <span  class="btn btn-info btn-sm" ng-click="addFields(field)">Add Item</span>
                                <span  class="btn btn-info btn-sm" ng-click="removeFields(field)">Remove Item</span>
                        	</h4>
                        </div>
                        <div style="max-height:500px;overflow:hidden;overflow-y:auto;">
                            <div class="form-group" ng-repeat="type in field.itemtype">
        	               		<div ng-controller="ItemcodeDropCntrl">
                                    <div class="col-sm-4">
                                        <select class="form-control selectdrop ng-pristine ng-valid md-input ng-touched" name="item_type[]" ng-model="itemType" ng-change="dep_drop_item(itemType)" required>
                                            <option value="" selected="">Select Type</option>
                                            <option ng-repeat="item in itemtypes" value="{{item.alias}}">{{item.name}}</option>
                                        </select>
                                        <span class="help-block" ng-show="itemsForm['item_type[]'].$dirty && itemsForm['item_type[]'].$invalid">
                                            <span ng-show="itemsForm['item_type[]'].$error.required">Select Item Type</span>
                                        </span>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-control selectdrop ng-pristine ng-valid md-input ng-touched" name="item_code[]" ng-model="itemCodes" required>
                                            <option value="" selected="">Item Code</option>
                                            <option ng-repeat="itemcode in firstDrop" value="{{itemcode.alias}}">{{itemcode.name}}</option>
                                        </select>
                                        <span class="help-block" ng-show="itemsForm['item_code[]'].$dirty && itemsForm['item_code[]'].$invalid">
                                            <span ng-show="itemsForm['item_code[]'].$error.required">Select Item Code</span>
                                        </span>
                                    </div>
                                    <div class="col-sm-4" ng-if="itemType == '1'">
                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                            <label for="input_00D">Cell Number</label>
                                            <input type="text" ng-model="description" name="item_description[]" class="ng-pristine ng-valid md-input ng-touched" required>
                                        </md-input-container>
                                         <span class="help-block" ng-show="itemsForm['item_description[]'].$dirty && itemsForm['item_description[]'].$invalid">
                                            <span ng-show="itemsForm['item_description[]'].$error.required">Item Description is Required</span>
                                        </span>
                                    </div>
                                    <div class="col-sm-4" ng-if="itemType == '2'">
                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                            <label for="input_00D">Quantity</label>
                                            <input type="text" ng-model="quantity" name="item_description[]" class="ng-pristine ng-valid md-input ng-touched" ng-pattern="/^[0-9]{1,}$/" required>
                                        </md-input-container>
                                         <span class="help-block" ng-show="itemsForm['item_description[]'].$dirty && itemsForm['item_description[]'].$invalid">
                                            <span ng-show="itemsForm['item_description[]'].$error.required">Quantity is Required</span>
                                			<span ng-show="itemsForm['item_description[]'].$error.pattern">Quantity should be digits only</span>
                                        </span>
                                    </div>
		                       </div>
                            </div>
                    	</div> 
                    </div>
                <div class="row form-group">
                     <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm" ng-disabled="itemsForm.$invalid">Create</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose()">Close</button>
                    </div>
               </div>
          </form>   
	</div>
</div>