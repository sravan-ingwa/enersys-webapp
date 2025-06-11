<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
</style>
<div ng-controller="contractpriceEditCntl">
<div class="modal-style" ng-controller="escanameDropCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit Contact Price</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" reset-directive="singleViews" name="contractpriceForm" data-went="#/settings/contractprice/contractprice_view" method="post" url="services/expense/expense_update" ng-submit="sendPost()" novalidate>
                <input type="hidden" name="contract_price_alias" value="{{singleViews.contract_price_alias}}"/>
                <div class="row form-group">
                    <div class="col-sm-10 col-sm-offset-1 mb10">
                       <select class="form-control selectdrop" name="esca_name" ng-model="escas" required ng-init="zone_state(singleViews.esca_name_update)" ng-change="zone_state(escas)" required>
                            <option value="" selected="">ESCA Name</option>
                            <option ng-repeat="esca in firstDrop" value="{{esca.alias}}" ng-selected="esca.alias == singleViews.esca_name_update">{{esca.name}}</option>
                    	</select>
                         <span class="help-block" ng-show="contractpriceForm.esca_name.$dirty && contractpriceForm.esca_name.$invalid">
                            <span ng-show="contractpriceForm.esca_name.$error.required">ESCA Name is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">ESCA Description</label>
                            <input ng-model="singleViews.esca_desc" value="{{singleViews.esca_desc}}" name="esca_desc" class="ng-pristine ng-valid md-input ng-touched" id="input_00E" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="contractpriceForm.esca_desc.$dirty && contractpriceForm.esca_desc.$invalid">
                            <span ng-show="contractpriceForm.esca_desc.$error.required">ESCA Description is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 mb10" ng-controller="milestoneDropCtrl">
                     	<label class="selectlabel">Milestone</label>
                        <select class="form-control editselectdrop" name="mile_stone_alais" ng-model="milestone" required="required">
                            <option value="">Select Mile Stone</option>
                            <option ng-repeat="mile in firstDrop" value="{{mile.alias}}" ng-selected="mile.alias == singleViews.mile_stone_alais">{{mile.name}}</option>
                        </select>
                        <span class="help-block" ng-show="contractpriceForm.mile_stone_alais.$dirty && contractpriceForm.mile_stone_alais.$invalid">
                            <span ng-show="contractpriceForm.mile_stone_alais.$error.required">Select Milestone</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Zone</label>
                            <input type="hidden" name="zone_alias" value="{{zoneStates.zone_alias}}" />
                            <input ng-model="zoneStates.zone_name" value="{{zoneStates.zone_name}}" readonly="readonly" name="zone_name" class="ng-pristine ng-valid md-input ng-touched"  id="input_00F" tabindex="0" aria-invalid="false">
                        </md-input-container>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">State</label>
                             <input type="hidden" name="state_alias" value="{{zoneStates.state_alias}}" />
                            <input ng-model="zoneStates.state_name" value="{{zoneStates.state_name}}" readonly="readonly" name="state_name" class="ng-pristine ng-valid md-input ng-touched"  id="input_00F" tabindex="0" aria-invalid="false">
                        </md-input-container>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1" ng-controller="unitDropCtrl">
                        <select class="form-control editselectdrop" name="unit" ng-model="unit" required>
                            <option value="">Unit</option>
                            <option value="{{unit.name}}" ng-repeat="unit in units" ng-selected="unit.name == singleViews.unit">{{unit.name}}</option>
                    	</select>
                         <span class="help-block" ng-show="contractpriceForm.unit.$dirty && contractpriceForm.unit.$invalid">
                            <span ng-show="contractpriceForm.unit.$error.required">Select Unit</span>
                        </span>
                    </div>
                     <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Amount</label>
                            <input ng-model="singleViews.amount" value="{{singleViews.amount}}" ng-pattern="/^(?=.)([+-]?([0-9]*)(\.([0-9]+))?)$/"  class="ng-pristine ng-valid md-input ng-touched" name="amount" id="input_00F" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="contractpriceForm.amount.$dirty && contractpriceForm.amount.$invalid">
                            <span ng-show="contractpriceForm.amount.$error.required">Amount is Required</span>
                            <span ng-show="contractpriceForm.amount.$error.pattern">Amount Should be Digits Only</span>
                        </span>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm" 
                            ng-disabled="contractpriceForm.esca_name.$dirty && contractpriceForm.esca_name.$invalid ||
                            contractpriceForm.esca_desc.$dirty && contractpriceForm.esca_desc.$invalid ||
                            contractpriceForm.mile_stone_alais.$dirty && contractpriceForm.mile_stone_alais.$invalid ||
                            contractpriceForm.zone_alias.$dirty && contractpriceForm.zone_alias.$invalid ||
                            contractpriceForm.state_alias.$dirty && contractpriceForm.state_alias.$invalid ||
                            contractpriceForm.amount.$dirty && contractpriceForm.amount.$invalid ||
                            contractpriceForm.unit.$dirty && contractpriceForm.unit.$invalid">Update</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose()">Close</button>
                    </div>
               </div>
          </form>   
	</div>
</div>
</div>