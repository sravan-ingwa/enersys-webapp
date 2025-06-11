<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
</style>
<div class="modal-style">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Create Product</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" name="productForm" data-went="#/settings/product/product_view" method="post" url="services/settings/product_add" ng-submit="sendPost()" novalidate>
                <div class="row form-group">
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Battery Rating</label>
                            <input ng-model="batteryrating" class="ng-pristine ng-valid md-input ng-touched" name="battery_rating" id="input_00A" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="productForm.battery_rating.$dirty && productForm.battery_rating.$invalid">
                            <span ng-show="productForm.battery_rating.$error.required">Battery Rating is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Cell Volatge</label>
                            <input ng-model="cellvoltage" class="ng-pristine ng-valid md-input ng-touched" ng-pattern="/^(?=.)([+-]?([0-9]*)(\.([0-9]+))?)$/" name="cell_voltage" id="input_00B" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="productForm.cell_voltage.$dirty && productForm.cell_voltage.$invalid">
                            <span ng-show="productForm.cell_voltage.$error.required">Cell Volatge is Required</span>
                            <span ng-show="productForm.cell_voltage.$error.pattern">Cell Volatge Should be Digits Only</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Item Code</label>
                            <input ng-model="item_code" class="ng-pristine ng-valid md-input ng-touched" name="item_code" id="input_00C" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="productForm.item_code.$dirty && productForm.item_code.$invalid">
                            <span ng-show="productForm.item_code.$error.required">Item Code is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Product Description</label>
                            <input ng-model="productdescription" class="ng-pristine ng-valid md-input ng-touched" name="product_description" id="input_00D" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="productForm.product_description.$dirty && productForm.product_description.$invalid">
                            <span ng-show="productForm.product_description.$error.required">Product Description is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Product Price</label>
                            <input ng-model="productprice" class="ng-pristine ng-valid md-input ng-touched" ng-pattern="/^(?=.)([+-]?([0-9]*)(\.([0-9]+))?)$/" name="price" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="productForm.price.$dirty && productForm.price.$invalid">
                            <span ng-show="productForm.price.$error.required">Product Price is Required</span>
                            <span ng-show="productForm.price.$error.pattern">Product Price Should be Digits Only</span>
                        </span>
                    </div>
                     <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Product Weight</label>
                            <input ng-model="productweight" class="ng-pristine ng-valid md-input ng-touched" ng-pattern="/^(?=.)([+-]?([0-9]*)(\.([0-9]+))?)$/" name="weight" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="productForm.weight.$dirty && productForm.weight.$invalid">
                            <span ng-show="productForm.weight.$error.required">Product Weight is Required</span>
                            <span ng-show="productForm.weight.$error.pattern">Product Weight Should be Digits Only</span>
                        </span>
                    </div>
                    <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm" ng-disabled="productForm.$invalid || productForm.$pristine">Create</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose()">Close</button>
                    </div>
               </div>
          </form>   
	</div>
</div>
