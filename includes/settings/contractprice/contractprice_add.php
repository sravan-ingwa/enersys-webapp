<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
</style>
<div class="modal-style" ng-controller="escanameDropCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Create Contact Price</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" name="contractpriceForm" data-went="#/settings/contractprice/contractprice_view" method="post" url="services/expense/expense_add" ng-submit="sendPost()" novalidate>
                <div class="row form-group">
                	<div class="col-sm-10 col-sm-offset-1 mb10">
                       <select class="form-control selectdrop" name="employee_alias" ng-model="escas" required ng-change="zone_state(escas)">
                            <option value="" selected="">ESCA Name</option>
                            <option ng-repeat="esca in firstDrop" value="{{esca.alias}}">{{esca.name}}</option>
                    	</select>
                        <span class="help-block" ng-show="contractpriceForm.employee_alias.$dirty && contractpriceForm.employee_alias.$invalid">
                            <span ng-show="contractpriceForm.employee_alias.$error.required">ESCA Name is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">ESCA Description</label>
                            <input ng-model="description" name="esca_desc" class="ng-pristine ng-valid md-input ng-touched" id="input_00E" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="contractpriceForm.esca_desc.$dirty && contractpriceForm.esca_desc.$invalid">
                            <span ng-show="contractpriceForm.esca_desc.$error.required">ESCA Description is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 mb10" ng-controller="milestoneDropCtrl">
                        <select class="form-control selectdrop" name="mile_stone_alais" ng-model="milestone" required="required">
                            <option value="">Select Mile Stone</option>
                            <option ng-repeat="mile in firstDrop" value="{{mile.alias}}">{{mile.name}}</option>
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
                        <select class="form-control selectdrop" name="unit" ng-model="unit" required>
                            <option value="">Unit</option>
                            <option value="{{unit.name}}" ng-repeat="unit in units">{{unit.name}}</option>
                    	</select>
                         <span class="help-block" ng-show="contractpriceForm.unit.$dirty && contractpriceForm.unit.$invalid">
                            <span ng-show="contractpriceForm.unit.$error.required">Select Unit</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Amount</label>
                            <input ng-model="amount" name="amount" class="ng-pristine ng-valid md-input ng-touched" ng-pattern="/^(?=.)([+-]?([0-9]*)(\.([0-9]+))?)$/" id="input_00F" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="contractpriceForm.amount.$dirty && contractpriceForm.amount.$invalid">
                            <span ng-show="contractpriceForm.amount.$error.required">Amount is Required</span>
                            <span ng-show="contractpriceForm.amount.$error.pattern">Amount Should be Digits Only</span>
                        </span>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm"  ng-disabled="contractpriceForm.$invalid">Create</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose()">Close</button>
                    </div>
               </div>
          </form>   
	</div>
</div>