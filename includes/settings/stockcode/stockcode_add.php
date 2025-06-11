<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
</style>
<div class="modal-style">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Create Stock Code</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" name="stockForm" data-went="#/settings/stockcode/stockcode_view" method="post" url="services/settings/stockcode_add" ng-submit="sendPost()" novalidate>
                <div class="row form-group">
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Enter Stock Code</label>
                            <input ng-model="stockcode" class="ng-pristine ng-valid md-input ng-touched" name="stock_code" id="input_00A" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="stockForm.stock_code.$dirty && stockForm.stock_code.$invalid">
                            <span ng-show="stockForm.stock_code.$error.required">Stock Code is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Enter Stock Description</label>
                            <input ng-model="stockdesc" class="ng-pristine ng-valid md-input ng-touched" name="description" id="input_00B" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="stockForm.description.$dirty && stockForm.description.$invalid">
                            <span ng-show="stockForm.description.$error.required">Stock Description is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-7 col-sm-offset-4">
                            <button type="submit" click-once class="btn btn-info btn-sm" ng-disabled="stockForm.$invalid">Add Stockcode</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose()">Close</button>
                    </div>
               </div>
          </form>   
	</div>
</div>