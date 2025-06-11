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
<div class="modal-style" ng-controller="lod_S_AddCtrl">
	<div class="modal-header clearfix">
		<h4 class="modal-title">ADD LODGING</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body">
		<form class="form-horizontal forms_update" name="expenseRequest" method="post" url="services/expense_tracker/ser_lod_single_add" ng-submit="addRequest()" novalidate>
            <input type="hidden" name="alias" value="{{expAlias}}">

			<div ng-controller="addFieldsExpCtrl">
               <div class="col-sm-12">
                    <div class="row form-group" ng-repeat="field in forms">  
                   <div class="panel panel-info mb10" ng-repeat="(key,type) in field.itemtype">
                        <div class="panel-heading" style="padding:7px 18px;">
                            <span>Lodging {{expenseViews.exp_lod_count+key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20" style="line-height:1;"></span></a></span>
                        </div>
                        <div class="panel-body locCon" ng-controller="loczoneStateMulCntrl">
                             <div class="row form-group">
                                <div class="col-sm-3">
                                    <label class="selectlabel">Stay Type</label>
                                    <select class="form-control selectdrop SlectBox stay" ng-model="stayType" ng-change="lodging_self($event); amnt()" name="typeofstay[]">
                                        <option value="" selected="selected">Select Stay Type</option>
                                        <option value="Reimbursement">Reimbursement</option>
                                        <option value="Self">Self</option>
                                    </select>
                                </div>
                                <div ng-controller="DatepickerDemoCtrl">
                                    <div class="col-sm-3">
                                        <md-input-container flex="" class="md-default-theme">
                                            <label for="input_00D">Check in Date</label>
                                            <input type="text" ng-model="Startddate" readonly="readonly" class="bdpd3 cddl bg-white clc" name="checkin[]" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="true" data-ng-focus="loddateChange($event);open($event,'opened1')"/>
                                       </md-input-container>
                                    </div>	
                                    <div class="col-sm-3">
                                        <md-input-container flex="" class="md-default-theme">
                                            <label for="input_00E">Check out Date</label>
                                            <input type="text" ng-model="Enddate" readonly="readonly" class="bdpd4 cddl bg-white slc" name="checkout[]" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="true" data-ng-focus="loddateChange($event);open($event,'opened2')">
                                        </md-input-container>
                                    </div>
                                </div>
                                <div class="col-sm-3" ng-controller="ticketDropCtrl">
                                    <label class="selectlabel">Ticket ID</label>
                                    <select class="form-control SlectBox" placeholder="Ticket ID" name="ticket_idld[]" id="ticket_id" ng-model="ticket_id">
                                        <option value="" selected="selected" style="display:none" >Select Ticket ID</option>
                                        <option value="1">Others</option>
                                        <option ng-repeat="ticket in firstDrop" value="{{ticket.alias}}">{{ticket.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row" ng-show="stayType == 'Self'">
                                <div class="col-sm-4">
                                    <label class="selectlabel">Zone</label>
                                    <select placeholder="Zone" name="zone_ld[]" class="SlectBox form-control zoneChange" ng-model="zones"   data-ng-change="zone_loc(zones,$event);" data-ref="ld">
                                        <option value="" style="display:none" selected="selected">Zones</option>
                                        <option ng-repeat="zone in firstDrop" value="{{zone.alias}}">{{zone.name}}</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label class="selectlabel">State</label>
                                    <select class="form-control SlectBox stateChange" placeholder="State"  name="state_ld[]" id="state" ng-model="states"  data-ng-change="state_loc(states,$event);" >
                                        <option value="" style="display:none" selected="selected">States</option>
                                        <option ng-repeat="state in secondDrop" value="{{state.alias}}">{{state.name}}</option>
                                    </select>
                                </div>   
                                <div class="col-sm-4">
                                    <label class="selectlabel">District</label>
                                    <select class="form-control SlectBox districtChange" placeholder="District"  name="district_ld[]" id="district" ng-model="districts" ng-change="district_loc(districts,$event);" >
                                        <option value="" style="display:none" selected="selected">Districts</option>
                                        <option ng-repeat="district in thirdDrop" value="{{district.alias}}">{{district.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-4">
                                    <md-input-container flex="" class="md-default-theme">
                                        <label for="input_00B">DPR Number</label>
                                        <input value="" name="dprNum_ld[]" placeholder="DPR Number">
                                    </md-input-container>
                                </div>
                                <div class="col-sm-4" ng-show="stayType == 'Reimbursement'">
                                    <md-input-container flex="" class="md-default-theme">
                                        <label for="input_00B">Hotel Name</label>
                                        <input value="" name="hotelName[]" placeholder="Hotel Name">
                                    </md-input-container>
                                </div>
                                <div class="col-sm-4" ng-if="stayType == 'Self'">
                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                        <label for="input_00B">Amount</label>
                                        <input type="number" class="amtt tamfor tlam selfamm ld" readonly="readonly" name="lamt[]" ng-keyup="amnt()" placeholder="Amount">
                                    </md-input-container>
                                </div>
                                <div class="col-sm-4" ng-if="stayType == 'Reimbursement'">
                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                        <label for="input_00B">Amount</label>
                                        <input type="number" class="amtt tamfor tlam selfamm ld" name="lamt[]" ng-keyup="amnt()" placeholder="Amount">
                                    </md-input-container>
                                </div>
                            </div>
                            <div class="row form-group" ng-show="stayType == 'Reimbursement'">
                                <div class="col-sm-4 filesRow" ng-controller="fileUploadCtrl">
                                <input value="{{file_name}}" class="form-control uploadFile" placeholder="Choose File" disabled="disabled" name="lfile[]"/>
                                    <div class="fileUpload btn btn-sm btn-info" tooltip="Upload" tooltip-placement="right">
                                        <span class="ion ion-upload"></span>
                                        <input type="file" class="upload uploadBtn" name="lfile[]" onchange="angular.element(this).scope().file_load_exp(this.files)"/>
                                    </div>
                                    <div class="mb20" ng-if="prg_shw_hde">
                                        <md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
                                    </div>
                                </div>
                            </div>
                        </div>	
                    </div>
                    <div class="col-md-4 right mt5">
                        <input readonly="readonly" class="form-control tlamt" placeholder="Total Lodging" name="fare_total_lod">
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