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
.locCon{border:1px solid #eee;}
</style>
<div class="modal-style" ng-controller="locConvy_S_AddCtrl">	
	<div class="modal-header clearfix">
		<h4 class="modal-title">ADD LOCAL CONVEYANCE</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body">
		<form class="form-horizontal forms_update" name="expenseRequest" method="post" url="services/expense_tracker/ser_loc_single_add" ng-submit="addRequest()" novalidate>
            <input type="hidden" name="alias" value="{{expAlias}}">
            <div ng-controller="addFieldsExpCtrl">
                <div class="col-sm-12">
                  <div class="row form-group" ng-repeat="field in forms">  
                   <div class="panel panel-info mb10 ajm" id="aaaa" ng-repeat="(key,type) in field.itemtype">
                        <div class="panel-heading" style="padding:7px 18px;">
                            <span>Local Conveyance {{expenseViews.exp_lcon_count+key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20" style="line-height:1;"></span></a></span>
                        </div>
                        <div class="panel-body locCon" ng-controller="loczoneStateMulCntrl">
                            <div class="row form-group">
                                <div class="col-sm-3">
                                    <label class="selectlabel">Zone</label>
                                    <select name="zone_l[]" class="SlectBox form-control zoneChange" ng-model="zones" data-ng-change="zone_loc(zones,$event);" data-ref="lc">
                                        <option value="" style="display:none" selected="selected">Zones</option>
                                        <option ng-repeat="zone in firstDrop" value="{{zone.alias}}">{{zone.name}}</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label class="selectlabel">State</label>
                                    <select class="form-control SlectBox stateChange" name="state_l[]" ng-model="states" data-ng-change="state_loc(states, $event);">
                                        <option value="" style="display:none" selected="selected">States</option>
                                        <option ng-repeat="state in secondDrop" value="{{state.alias}}">{{state.name}}</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label class="selectlabel">District</label>
                                    <select class="form-control SlectBox districtChange" placeholder="District" name="district_l[]"  data-ng-change="district_loc(districts, $event);" ng-model="districts">
                                        <option value="" style="display:none" selected="selected">Districts</option>
                                        <option ng-repeat="district in thirdDrop" value="{{district.alias}}">{{district.name}}</option>
                                    </select>
                                </div>
                                 <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                        <label for="input_00B">Area</label>
                                        <input value="{{fourthDrop.area}}" readonly="readonly" name="area[]" class="area_change">
                                    </md-input-container>
                                 </div>
                             </div>
                             <div class="row form-group">
                                <div class="col-sm-3">
									<label class="selectlabel">Bucket</label>
                                    <select name="bucket[]" class="form-control SlectBox selectdrop localConvy" ng-model="bucket" ng-change="localConvy($event);">
                                        <option value="" selected="selected">Bucket</option>
                                        <option value="0">Secondary Transportation</option>
                                        <option value="1">Local Conveyance</option>
                                    </select>
                                </div>
                                <div ng-show="bucket == '0'" ng-controller="capdropCntrl">
                                <div class="col-sm-3">
                                    <label class="selectlabel">Capacity</label>
                                    <select class="form-control SlectBox selectdrop capChange cap" placeholder="Product Code" name="cap[]" ng-model="productcode" ng-change="capChange(productcode);">
                                        <option value="" style="display:none" selected="selected">Capacity</option>
                                        <option ng-repeat="product in firstDrop" value="{{product.alias}}">{{product.name}}</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                        <label for="input_00B">Weight of cell</label>
                                        <input name="wofCell[]" class="weightChange ocap" placeholder="Weight of cell" readonly="readonly" value="{{capChng.product_weight}}">
                                    </md-input-container>
                                </div>
                                <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme">
                                        <label for="input_00B">Quantity</label>
                                        <input value="" name="quantityCell[]" class="qnty ocap" placeholder="Quantity"  ng-keyup="qnty(); qntyInt($event)" ng-keypress="qntyInt($event)" ng-focus="qntyInt($event)" autocomplete="off" >
                                    </md-input-container>
                                </div>
                             
                               <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme">
                                        <label for="input_00B">No.of Kilometers</label>
                                        <input value="" name="numKilometers[]" class="numKilo ocap" placeholder="No.of Kilometers" ng-keypress="onlyIntegers($event)" ng-keyup="onlyIntegers($event); numKilo()" ng-focus="onlyIntegers($event)" autocomplete="off">
                                    </md-input-container>
                                </div>
                                <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                        <label for="input_00B">Amount Appilicable </label>
                                        <input name="amtappli[]" class="appliChange ocap" readonly="readonly" value="{{fourthDrop.ammount_appl}}">
                                    </md-input-container>
                                </div>
                                </div>
                                <div class="col-sm-3" ng-controller="DatepickerDemoCtrl">
                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                        <label for="input_00B">Date of Travel</label>
                                        <input type="text" class="border-bottom" readonly="readonly" name="dot_l[]" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" ng-model="dot_l" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="true"/>  
                                    </md-input-container>
                                </div>
                                <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme">
                                        <label for="input_00B">From</label>
                                        <input value="" name="from_l[]" placeholder="From Place">
                                    </md-input-container>
                                </div>
                                <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme">
                                        <label for="input_00B">To</label>
                                        <input value="" name="to_l[]" placeholder="To Place">
                                    </md-input-container>
                                </div>
                                <div class="col-sm-3" ng-controller="locOfTravelCntrl">
									<label class="selectlabel">Mode Of Travel</label>
                                    <select class="form-control selectdrop SlectBox" ng-model="mot_l" name="mot_l[]" >
                                        <option value="" selected>Mode Of Travel</option>
                                        <option ng-repeat="mot in locOfTravel" value="{{mot.name}}">{{mot.name}}</option>
                                    </select>
                                </div>
                                
                                <div class="col-sm-3" ng-controller="ticketDropCtrl">
                                    <label class="selectlabel">Ticket ID</label>
                                    <select class="form-control SlectBox" placeholder="Ticket ID" name="ticket_idl[]" id="ticket_id" ng-model="ticket_id">
                                        <option value="" selected="selected" style="display:none" >Select Ticket ID</option>
                                        <option value="1">Others</option>
                                        <option ng-repeat="ticket in firstDrop" value="{{ticket.alias}}">{{ticket.name}}</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme">
                                        <label for="input_00B">DPR Number</label>
                                        <input value="" name="dprNum_l[]">
                                    </md-input-container>
                                </div>
                                <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                        <label for="input_00B">Amount</label>
                                        <input readonly="readonly" name="amt_l[]"  class="amtt tamfor ttcm lc" ng-keyup="amnt();">
                                    </md-input-container>
                                </div>
                             </div>
                        </div>	
                    </div>
                    <div class="col-md-4 right mt5">
                        <input readonly="readonly" class="form-control ttcmt" name="fare_total_loc" placeholder="Total Local Conveyance">
                    </div>
                    <a href="" class="text-info fnt-20 ml10" ng-click="addFields(field,$event)"> New Field : <span class="ion ion-plus-circled fnt-20"></span></a>
               </div>
              </div>
           </div>
           <div class="row form-group"> 
            <div class="col-sm-6 col-sm-offset-5 mt10">
                  <button type="submit" class="btn btn-info btn-sm">Submit</button>
            </div>
           </div>   
           </form> 
		</div>
	</div>
</div>
<script>
setInterval(function(){$('.SlectBox').SumoSelect();
$('.forms_update').find('.SumoSelect').addClass('singleSelect');},0);
</script>