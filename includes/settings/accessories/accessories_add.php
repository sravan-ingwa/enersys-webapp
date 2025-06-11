<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
</style>
<div class="modal-style">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Create Accessories</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" name="accessoriesForm" data-went="#/settings/accessories/accessories_view" method="post" url="services/settings/accessories_add" ng-submit="sendPost()" novalidate>
                <div class="row form-group">
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Item Code</label>
                            <input ng-model="itemcode" class="ng-pristine ng-valid md-input ng-touched" name="item_code" id="input_00A" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="accessoriesForm.item_code.$dirty && accessoriesForm.item_code.$invalid">
                            <span ng-show="accessoriesForm.item_code.$error.required">Item Code is required.</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Accessory Description</label>
                            <input ng-model="accessory_description" class="ng-pristine ng-valid md-input ng-touched" name="accessory_description" id="input_00D" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="accessoriesForm.accessory_description.$dirty && accessoriesForm.accessory_description.$invalid">
                            <span ng-show="accessoriesForm.accessory_description.$error.required">Accessory Description is required.</span>
                        </span>
                    </div>
					<div class="col-sm-10 col-sm-offset-1" ng-controller="measurementdropCntrl">
                        <select class="form-control selectdrop" name="measurement" ng-model="measurement" required>
                            <option value="">Measurement</option>
                            <option ng-repeat="measure in measurementdrop" value="{{measure.name}}">{{measure.name}}</option>
                        </select>
                        <span class="help-block" ng-show="accessoriesForm.measurement.$dirty && accessoriesForm.measurement.$invalid">
                            <span ng-show="accessoriesForm.measurement.$error.required">Measurement is required.</span>
                        </span>
                    </div>
					<!---<div class="col-sm-10 col-sm-offset-1" ng-controller="productdropCntrl">
                        <select class="form-control selectdrop" name="product_alias" ng-model="product_alias" required>
                            <option value="" selected="">Product Description</option>
                            <option ng-repeat="product in firstDrop" value="{{product.alias}}">{{product.name}}</option>
                        </select>
                        <span class="help-block" ng-show="accessoriesForm.product_alias.$dirty && accessoriesForm.product_alias.$invalid">
                            <span ng-show="accessoriesForm.product_alias.$error.required">Product Description is required.</span>
                        </span>
                    </div>-->
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Price</label>
                            <input ng-model="price" class="ng-pristine ng-valid md-input ng-touched" name="price" ng-pattern="/^(?=.)([+-]?([0-9]*)(\.([0-9]+))?)$/" id="input_00A" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="accessoriesForm.price.$dirty && accessoriesForm.price.$invalid">
                            <span ng-show="accessoriesForm.price.$error.required">Price is required.</span>
                            <span ng-show="accessoriesForm.price.$error.pattern">Price Should be Number only.</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Weight</label>
                            <input ng-model="weight" class="ng-pristine ng-valid md-input ng-touched" ng-pattern="/^(?=.)([+-]?([0-9]*)(\.([0-9]+))?)$/" name="weight" id="input_00B" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="accessoriesForm.weight.$dirty && accessoriesForm.weight.$invalid">
                            <span ng-show="accessoriesForm.weight.$error.required">Weight is required.</span>
                            <span ng-show="accessoriesForm.weight.$error.pattern">Weight Should be Number only.</span>
                        </span>
                    </div>
                    <div class="col-sm-6 col-sm-offset-5">
                        <button type="submit" click-once class="btn btn-info btn-sm" ng-disabled="accessoriesForm.$invalid || accessoriesForm.$pristine">Create</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose()">Close</button>
                    </div>
               </div>
          </form>   
	</div>
</div>
