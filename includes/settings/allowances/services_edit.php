<style>
.form-group {margin-bottom:0px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
.SumoSelect > .optWrapper > .options > .selected{background-color : #428bca;}
.SumoSelect > .optWrapper > .options > .selected > label{ color:#fff;}
</style>
<div class="modal-style" ng-controller="EnersysExpenseCtrl">	<!-- wrapper for specific style -->
<div ng-controller="ServicesCtrl">
	<div class="modal-header clearfix">
		<h4 class="modal-title">Update Service Allowances</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="alczoneStateMulCntrl">
        <form class="form-horizontal forms_request" name="servicesEditForm" data-went="includes/settings/allowances/Service-allowances" method="post" url="services/expense_tracker/serallowances_edit" ng-submit="sendRequest()" novalidate>
        	<input type="hidden" name="service_allowance_alias" value="{{expenseViews.service_allowance_alias}}" />
        		<div class="row form-group">
                    <div class="col-sm-6 mb10">
                        <label class="selectlabel">Zone</label>
                        <select  name="zone" class="SlectBox form-control" ng-model="zones" ng-init="dep_drop(expenseViews.zone_alias)" data-ng-change="zone_alc(zones)" required>
                            <!--<option value="" style="display:none" selected="selected">Zones</option>-->
                            <option ng-repeat="zone in firstDrop" value="{{zone.alias}}" ng-selected="zone.alias == expenseViews.zone_alias">{{zone.name}}</option>
                        </select>
                        <span class="help-block" ng-show="servicesEditForm.zone.$dirty && servicesEditForm.zone.$invalid">
                              <span ng-show="servicesEditForm.zone.$error.required">Zone is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-6 mb10">
                        <label class="selectlabel">State</label>
                        <select class="SlectBox form-control" name="state" placeholder="State" ng-model="states" ng-init="dep_drop2(expenseViews.state_alias)"  data-ng-change="state_alc(states)" required>
                            <!--<option value="" style="display:none" selected="selected">States</option>-->
                            <option ng-repeat="state in secondDrop" value="{{state.alias}}" ng-selected="state.alias == expenseViews.state_alias">{{state.name}}</option>
                        </select>
                        <span class="help-block" ng-show="servicesEditForm.state.$dirty && servicesEditForm.state.$invalid">
                              <span ng-show="servicesEditForm.state.$error.required">State is Required</span>
                        </span>
                    </div>
                </div>
                <div class="row form-group">    
                    <div class="col-sm-6">
                        <label class="selectlabel">District</label>
                        <select class="form-control SlectBox" placeholder="District" name="district" ng-model="districts" ng-init="dep_drop3(expenseViews.district_alias)" data-ng-change="district_alc(districts)" required>
                            <!--<option value="" style="display:none" selected="selected">Districts</option>-->
                            <option ng-repeat="district in thirdDrop" value="{{district.alias}}" ng-selected="district.alias == expenseViews.district_alias">{{district.name}}</option>
                        </select>
                        <span class="help-block" ng-show="servicesEditForm.district.$dirty && servicesEditForm.district.$invalid">
                              <span ng-show="servicesEditForm.district.$error.required">District is Required</span>
                        </span>
                    </div>
                     <div class="col-sm-6">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Area</label>
                            <input value="{{fourthDrop.area}}" name="area"  readonly="readonly" ng-init="{{expenseViews.area}}">
                        </md-input-container>
                     </div>
                 </div>
                 <div class="row form-group">
                     <div class="col-sm-6">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Lodging Amount</label>
                            <input name="lodging_amount" class="amntDig" ng-model="expenseViews.lodging_amount" value="{{expenseViews.lodging_amount}}" required>
                        </md-input-container>
                        <span class="help-block" ng-show="servicesEditForm.lodging_amount.$dirty && servicesEditForm.lodging_amount.$invalid">
                              <span ng-show="servicesEditForm.lodging_amount.$error.required">Lodging Amount is Required</span>
                        </span>
                     </div>
                     <div class="col-sm-6">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Daily Allowance</label>
                            <input name="daily_allowance" class="amntDig" ng-model="expenseViews.daily_allowance" value="{{expenseViews.daily_allowance}}" required>
                        </md-input-container>
                        <span class="help-block" ng-show="servicesEditForm.daily_allowance.$dirty && servicesEditForm.daily_allowance.$invalid">
                              <span ng-show="servicesEditForm.daily_allowance.$error.required">Daily Allowance is Required</span>
                        </span>
                     </div>
                  </div>
                  <div class="row form-group">
                     <div class="col-sm-6">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Local Conveyance</label>
                            <input name="local_conveyance" class="amntDig" ng-model="expenseViews.local_conveyance" value="{{expenseViews.local_conveyance}}" required>
                        </md-input-container>
                        <span class="help-block" ng-show="servicesEditForm.local_conveyance.$dirty && servicesEditForm.local_conveyance.$invalid">
                              <span ng-show="servicesEditForm.local_conveyance.$error.required">Local Conveyance is Required</span>
                        </span>
                     </div>
                 </div>
                <div class="row form-group">
                  <div class="col-sm-6 col-sm-offset-4">
                    <button type="submit" click-once class="btn btn-info btn-sm"
                    ng-disabled="servicesEditForm.zone.$dirty && servicesEditForm.zone.$invalid ||
                    servicesEditForm.state.$dirty && servicesEditForm.state.$invalid ||
                    servicesEditForm.district.$dirty && servicesEditForm.district.$invalid ||
                    servicesEditForm.lodging_amount.$dirty && servicesEditForm.lodging_amount.$invalid ||
                    servicesEditForm.daily_allowance.$dirty && servicesEditForm.daily_allowance.$invalid ||
                    servicesEditForm.local_conveyance.$dirty && servicesEditForm.local_conveyance.$invalid">Update Allowances</button>
                    <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose()">Close</button>
                  </div>
               </div>
          </form>   
	</div>
</div>

</div>

<script>
setInterval(function(){$('.SlectBox').SumoSelect();
$('.forms_request').find('.SumoSelect').addClass('singleSelect');},0);
$(document).on("keypress keyup focus",".amntDig",function (event) {    
	$(this).val($(this).val().replace(/[^0-9\.]/g,''));
		if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
			event.preventDefault();
	}
});
</script>