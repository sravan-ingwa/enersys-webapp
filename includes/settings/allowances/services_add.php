<style>
.form-group {margin-bottom:0px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
</style>
<div class="modal-style" ng-controller="EnersysExpenseCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Add Service Allowances</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="lczoneStateMulCntrl">
        <form class="form-horizontal forms_request" name="servicesForm" data-went="includes/settings/allowances/Service-allowances" method="post" url="services/expense_tracker/serallowances_add" ng-submit="sendRequest()" novalidate>
        		<div class="row form-group">
                    <div class="col-sm-6 mb10">
                        <label class="selectlabel">Zone</label>
                        <select name="zone[]" class="testSelAll2 form-control" multiple="multiple" ng-model="zones" data-ng-change="zone_lc(zones)" required placeholder="Zone">
                            <!--<option value="" style="display:none" selected="selected">Zones</option>-->
                            <option ng-repeat="zone in firstDrop" value="{{zone.alias}}">{{zone.name}}</option>
                        </select>
                        <span class="help-block" ng-show="servicesForm.zone.$dirty && servicesForm.zone.$invalid">
                              <span ng-show="servicesForm.zone.$error.required">Zone is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-6 mb10">
                        <label class="selectlabel">State</label>
                        <select class="form-control testSelAll2" name="state[]" multiple="multiple" placeholder="State" ng-model="states" data-ng-change="state_lc(states)" required>
                            <!--<option value="" style="display:none" selected="selected">States</option>-->
                            <option ng-repeat="state in secondDrop" value="{{state.alias}}">{{state.name}}</option>
                        </select>
                        <span class="help-block" ng-show="servicesForm.state.$dirty && servicesForm.state.$invalid">
                              <span ng-show="servicesForm.state.$error.required">State is Required</span>
                        </span>
                    </div>
                 </div>
                 <div class="row form-group">
                    <div class="col-sm-6">
                        <label class="selectlabel">District</label>
                        <select class="form-control testSelAll2" name="district[]" multiple="multiple" placeholder="District"  ng-model="districts" data-ng-change="district_lc(districts)" required>
                           <!-- <option value="" style="display:none" selected="selected">Districts</option>-->
                            <option ng-repeat="district in thirdDrop" value="{{district.alias}}">{{district.name}}</option>
                        </select>
                        <span class="help-block" ng-show="servicesForm.district.$dirty && servicesForm.district.$invalid">
                              <span ng-show="servicesForm.district.$error.required">District is Required</span>
                        </span>
                    </div>
                     <div class="col-sm-6">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00B">Lodging Amount</label>
                            <input name="lodging_amount" class="amntDig" ng-model="lodging_amount" required>
                        </md-input-container>
                        <span class="help-block" ng-show="servicesForm.lodging_amount.$dirty && servicesForm.lodging_amount.$invalid">
                              <span ng-show="servicesForm.lodging_amount.$error.required">Lodging Amount is Required</span>
                        </span>
                     </div>
                  </div>
                  <div class="row form-group">
                     
                     <div class="col-sm-6">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00B">Daily Allowance</label>
                            <input name="daily_allowance" class="amntDig" ng-model="daily_allowance" required>
                        </md-input-container>
                        <span class="help-block" ng-show="servicesForm.daily_allowance.$dirty && servicesForm.daily_allowance.$invalid">
                              <span ng-show="servicesForm.daily_allowance.$error.required">Daily Allowance is Required</span>
                        </span>
                     </div>
					 <div class="col-sm-6">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00B">Local Conveyance</label>
                            <input name="local_conveyance" class="amntDig" ng-model="local_conveyance" required>
                        </md-input-container>
                        <span class="help-block" ng-show="servicesForm.local_conveyance.$dirty && servicesForm.local_conveyance.$invalid">
                              <span ng-show="servicesForm.local_conveyance.$error.required">Local Conveyance is Required</span>
                        </span>
                     </div>
                  </div>                  
                <div class="row form-group">
                  <div class="col-sm-6 col-sm-offset-4">
                    <button type="submit" click-once class="btn btn-info btn-sm" ng-disabled="servicesForm.$invalid || servicesForm.$pristine">Add Allowances</button>
                    <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose()">Close</button>
                  </div>
               </div>
          </form>   
	</div>
</div>

<script>
setInterval(function(){$('.testSelAll2').SumoSelect({selectAll:true});
$('.forms_request').find('.SumoSelect').addClass('singleSelect');},0);
$(document).on("keypress keyup focus",".amntDig",function (event) {    
	$(this).val($(this).val().replace(/[^0-9\.]/g,''));
		if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
			event.preventDefault();
	}
});
</script>