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
<div class="modal-style" ng-controller="bod_S_EditCtrl">	
	<div class="modal-header clearfix">
		<h4 class="modal-title">EDIT BOARDING </h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body" ng-controller="updatingCntrl">
		<form class="form-horizontal forms_update" name="advanceRequest" method="post" url="services/expense_tracker/ser_bod_single_edit" ng-submit="upadteRequest()" novalidate>
           <div class="locCon" ng-controller="loczoneStateMulCntrl">
             <input type="hidden" name="idb" value="{{editViews.alias}}" />
             <input type="hidden" name="expenses_alias" value="{{editViews.expenses_alias}}" />
             <input type="hidden" name="prev_amt" value="{{editViews.amount}}" />
                 <div class="row form-group">
                    <div ng-controller="DatepickerDemoCtrl">
                        <div class="col-sm-3">
                            <md-input-container flex="" class="md-default-theme md-input-has-value">
                                <label for="input_00D">Visit: Start Date</label>
                                <input type="text" value="{{editViews.check_in}}" readonly="readonly" ng-model="editViews.check_in" class="bdpd1 cddl bg-white clc datepicker" name="checkinb" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="boddateChange($event);open($event,'opened1')"/>
                           </md-input-container>
                        </div>	
                        <div class="col-sm-3">
                            <md-input-container flex="" class="md-default-theme md-input-has-value">
                                <label for="input_00E">Visit: End Date</label>
                                <input type="text" value="{{editViews.check_out}}" readonly="readonly" ng-model="editViews.check_out" class="bdpd2 cddl bg-white slc datepicker" name="checkoutb" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="boddateChange($event);open($event,'opened2')">
                            </md-input-container>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label class="selectlabel">Zone</label>
                        <select placeholder="Zone" name="zone_bo"  class="SlectBox form-control zoneChange" ng-model="zones"  ng-init="dep_drop(editViews.zone_alias)" data-ng-change="zone_loc(zones,$event);" data-ref="bd">
                             <option value="" style="display:none" selected="selected">Zones</option>
                            <option ng-repeat="zone in firstDrop" value="{{zone.alias}}" ng-selected="zone.alias == editViews.zone_alias">{{zone.name}}</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label class="selectlabel">State</label>
                        <select class="form-control SlectBox stateChange" placeholder="State"  name="state_bo"  id="state" ng-model="states"  ng-init="dep_drop2(editViews.state_alias)"  data-ng-change="state_loc(states,$event);">
                            <option value="" style="display:none" selected="selected">States</option>
                            <option ng-repeat="state in secondDrop" value="{{state.alias}}" ng-selected="state.alias == editViews.state_alias">{{state.name}}</option>
                        </select>
                    </div>
                 </div>
                 <div class="row form-group">   
                    <div class="col-sm-3">
                        <label class="selectlabel">District</label>
                        <select class="form-control SlectBox districtChange" placeholder="District" name="district_bo" id="district" ng-model="districts" ng-init="dep_drop3(editViews.district_alias)" ng-change="district_loc(districts,$event);">
                            <option value="" style="display:none" selected="selected">Districts</option>
                            <option ng-repeat="district in thirdDrop" value="{{district.alias}}"  ng-selected="district.alias == editViews.district_alias">{{district.name}}</option>
                        </select>
                    </div>
                    <div class="col-sm-3" ng-controller="ticketDropCtrl">
                        <label class="selectlabel">Ticket ID</label>
                        <select class="form-control SlectBox" placeholder="Ticket ID" name="ticket_bo" id="ticket_id" ng-model="ticket_id" >
                            <option value="" selected="selected" style="display:none" >Select Ticket ID</option>
                            <option value="1" ng-selected="editViews.ticket_alias == '1'">Others</option>
                            <option ng-repeat="ticket in firstDrop" value="{{ticket.alias}}" ng-selected="ticket.alias == editViews.ticket_alias">{{ticket.name}}</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">DPR Number</label>
                            <input value="{{editViews.dpr_number}}" name="dprNum_bo" placeholder="DPR Number">
                        </md-input-container>
                    </div>
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Amount</label>
                            <input class="amtt tamfor blam selfamm bd" value="{{editViews.amount}}" readonly="readonly" ng-keyup="amnt()" name="bamt" placeholder="Amount">
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
$(document).on("change",".uploadBtn",function () { 
		$(this).parents('.filesRow').find('.uploadFile').val($(this).val());
		$(this).parents('.oldfilesRow').find('.uploadFile').val($(this).val());
});
</script>