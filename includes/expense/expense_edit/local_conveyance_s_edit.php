<style>
.form-group {margin-bottom:0px !important;}
.form-group div.col-sm-6{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.datepicker {border-bottom: 1px solid #efefef !important;}
.upload-file {border-bottom: 1px solid rgba(0,0,0,0.12); padding-top: 9px;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
</style>
<div class="modal-style" ng-controller="locConvy_S_EditCtrl">	
	<div class="modal-header clearfix">
		<h4 class="modal-title">EDIT LOCAL CONVEYANCE</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body" ng-controller="updatingCntrl">
		<form class="form-horizontal forms_update" name="advanceRequest" method="post" url="services/expense_tracker/ser_loc_single_edit" ng-submit="upadteRequest()" novalidate>
           <div class="locCon" ng-controller="loczoneStateMulCntrl">
            <input type="hidden" name="idc_l" value="{{editViews.alias}}"/>
           <input type="hidden" name="expenses_alias" value="{{editViews.expenses_alias}}" />
          	<input type="hidden" name="prev_amt" value="{{editViews.amount}}" />
                <div class="row form-group">
                    <div class="col-sm-3">
                        <label class="selectlabel">Zone</label>
                        <select name="zone_l" class="SlectBox form-control zoneChange" ng-model="zones" ng-init="dep_drop(editViews.zone_alias)" data-ng-change="zone_loc(zones,$event);" data-ref="lc">
                            <option value="" style="display:none" selected="selected">Zones</option>
                            <option ng-repeat="zone in firstDrop" value="{{zone.alias}}" ng-selected="zone.alias == editViews.zone_alias">{{zone.name}}</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label class="selectlabel">State</label>
                        <select class="form-control SlectBox stateChange" name="state_l" ng-model="states" ng-init="dep_drop2(editViews.state_alias)" data-ng-change="state_loc(states, $event);">
                            <option value="" style="display:none" selected="selected">States</option>
                            <option ng-repeat="state in secondDrop" value="{{state.alias}}" ng-selected="state.alias == editViews.state_alias">{{state.name}}</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label class="selectlabel">District</label>
                        <select class="form-control SlectBox districtChange" placeholder="District" name="district_l" ng-init="dep_drop3(editViews.district_alias)" data-ng-change="district_loc(districts, $event);" ng-model="districts">
                            <option value="" style="display:none" selected="selected">Districts</option>
                            <option ng-repeat="district in thirdDrop" value="{{district.alias}}" ng-selected="district.alias == editViews.district_alias">{{district.name}}</option>
                        </select>
                    </div>
                     <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Area</label>
                            <input value="{{fourthDrop.area}}" readonly="readonly" name="area" class="area_change">
                        </md-input-container>
                     </div>
                 </div>
                 <div class="row form-group">
                    <div class="col-sm-3">
						<label class="selectlabel">Bucket</label>
                        <select name="bucket" class="form-control selectdrop SlectBox localConvy" ng-model="bucket" ng-init="localConvy(editViews.bucket_val)" ng-change="localConvy(bucket);">
                            <option value="" selected="selected">Bucket</option>
                            <option value="0" ng-selected="editViews.bucket_val == '0'">Secondary Transportation</option>
                            <option value="1" ng-selected="editViews.bucket_val == '1'">Local Conveyance</option>
                        </select>
                    </div>
                    <div ng-class="abc" ng-controller="capdropCntrl">
                    <div class="col-sm-3">
                        <label class="selectlabel">Capacity</label>
                        <select class="form-control SlectBox selectdrop capChange cap" placeholder="Product Code" name="cap" ng-model="productcode" ng-init="capChange(editViews.capacity_val)" ng-change="capChange(productcode);" >
                            <option value="" style="display:none" selected="selected">Capacity</option>
                            <option ng-repeat="product in firstDrop" value="{{product.alias}}" ng-selected="product.alias == editViews.capacity_val">{{product.name}}</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Weight of cell</label>
                            <input  value="{{capChng.product_weight}}" readonly="readonly" name="wofCell" class="weightChange ocap" >
                        </md-input-container>
                    </div>
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Quantity</label>
                            <input value="{{editViews.quantity}}" name="quantityCell" class="qnty ocap" placeholder="Quantity"  ng-keyup="qnty(); qntyInt($event)" ng-keypress="qntyInt($event)" ng-focus="qntyInt($event)" autocomplete="off">
                        </md-input-container>
                    </div>
                 
                   <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">No.of Kilometers</label>
                            <input value="{{editViews.km}}" name="numKilometers" class="numKilo ocap" placeholder="No.of Kilometers" ng-keyup="numKilo(); onlyIntegers($event)" ng-keypress="onlyIntegers($event)" ng-focus="onlyIntegers($event)" autocomplete="off">
                        </md-input-container>
                    </div>
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Amount Appilicable </label>
                            <input name="amtappli" class="appliChange ocap" readonly="readonly" value="{{fourthDrop.ammount_appl}}">
                        </md-input-container>
                    </div>
                    </div>
                    <div class="col-sm-3" ng-controller="DatepickerDemoCtrl">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Date of Travel</label>
                            <input type="text" value="{{editViews.date_of_travel}}" readonly="readonly" ng-model="editViews.date_of_travel" class=" border-bottom" name="dot_l" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>  
                        </md-input-container>
                    </div>
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">From</label>
                            <input value="{{editViews.from_place}}" name="from_l" placeholder="From Place">
                        </md-input-container>
                    </div>
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">To</label>
                            <input value="{{editViews.to_place}}" name="to_l" placeholder="To Place">
                        </md-input-container>
                    </div>
                    <div class="col-sm-3" ng-controller="locOfTravelCntrl">
                        <select class="form-control selectdrop" ng-model="mot_l" name="mot_l" >
                            <option value="" selected>Mode Of Travel</option>
                            <option ng-repeat="mot in locOfTravel" value="{{mot.name}}" ng-selected="mot.name == editViews.mode_of_travel">{{mot.name}}</option>
                        </select>
                    </div>
                    
                    <div class="col-sm-3" ng-controller="ticketDropCtrl">
                        <label class="selectlabel">Ticket ID</label>
                        <select class="form-control SlectBox" placeholder="Ticket ID" name="ticket_idl" id="ticket_id" ng-model="ticket_id" >
                            <option value="" selected="selected" style="display:none" >Select Ticket ID</option>
                            <option value="1" ng-selected="editViews.ticket_alias == '1'">Others</option>
                            <option ng-repeat="ticket in firstDrop" value="{{ticket.alias}}" ng-selected="ticket.alias == editViews.ticket_alias">{{ticket.name}}</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">DPR Number</label>
                            <input value="{{editViews.dpr_number}}" name="dprNum_l">
                        </md-input-container>
                    </div>
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Amount</label>
                            <input readonly="readonly" name="amt_l" value="{{editViews.amount}}" class="amtt tamfor ttcm lc" ng-keyup="amnt();">
                        </md-input-container>
                    </div>
                 </div>
            </div>	
            <div class="row form-group"> 
                <div class="col-sm-6 col-sm-offset-5 mt10">
                      <button type="submit" class="btn btn-info btn-sm">Update</button>
                </div>
            </div>   
           </form> 
		</div>
</div>
<script>
setInterval(function(){$('.SlectBox').SumoSelect();
$('.forms_update').find('.SumoSelect').addClass('singleSelect');},0);
/*$(document).on("change",".uploadBtn",function () { 
	$(this).parents('.oldfilesRow').find('.uploadFile').val($(this).val());
});*/
</script>