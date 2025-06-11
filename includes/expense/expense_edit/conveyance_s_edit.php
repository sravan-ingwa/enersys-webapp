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
<div class="modal-style" ng-controller="convy_S_EditCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">EDIT CONVEYANCE </h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body" ng-controller="updatingCntrl">
		<form class="form-horizontal forms_update" name="conUpdate" method="post" url="services/expense_tracker/ser_con_single_edit" ng-submit="upadteRequest()" novalidate>
            <input type="hidden" name="idc" value="{{editViews.alias}}" />
           <input type="hidden" name="expenses_alias" value="{{editViews.expenses_alias}}" />
           <input type="hidden" name="prev_amt" value="{{editViews.amount}}" />
                <div class="row form-group">
                    <div class="col-sm-3" ng-controller="DatepickerDemoCtrl">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Date of Travel</label>
                            <input type="text" value="{{editViews.date_of_travel}}" readonly="readonly" ng-model="editViews.date_of_travel"  name="dot" class="border-bottom" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>  
                        </md-input-container>
                    </div>
                    <div class="col-sm-3" ng-controller="modeOfTravelCntrl">
						<label class="selectlabel">Mode Of Travel</label>
                        <select  class="form-control selectdrop SlectBox" ng-model="mot" name="mot" >
                            <option value="" selected>Mode Of Travel</option>
                            <option ng-repeat="mot in modeOfTravel" value="{{mot.name}}" ng-selected="mot.name == editViews.mode_of_travel">{{mot.name}}</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">From</label>
                            <input value="{{editViews.from_place}}" name="from"  placeholder="From">
                        </md-input-container>
                    </div>
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">To</label>
                            <input value="{{editViews.to_place}}" name="to" placeholder="To">
                        </md-input-container>
                    </div>
                    <div class="col-sm-3" ng-controller="ticketDropCtrl">
                        <label class="selectlabel">Ticket ID</label>
                        <select class="form-control SlectBox" placeholder="Ticket ID" name="cticket_id" id="ticket_id" ng-model="ticket_id" >
                            <option value="" selected="selected" style="display:none" >Select Ticket ID</option>
                            <option value="1" ng-selected="editViews.ticket_alias == '1'">Others</option>
                            <option ng-repeat="ticket in firstDrop" value="{{ticket.alias}}" ng-selected="ticket.alias == editViews.ticket_alias">{{ticket.name}}</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">DPR Number</label>
                            <input value="{{editViews.dpr_number}}" name="cdprno" placeholder="DPR Number">
                        </md-input-container>
                    </div>
                    <div class="col-sm-3 filesRow margin-none" ng-controller="fileUploadCtrl">  
                    	<input type="hidden" class="form-control" name="motbill_old" value="{{editViews.hidden_document_link}}"/>
                        <a href="{{editViews.document_link}}" target="_blank" ng-if="editViews.hidden_document_link!='' && editViews.hidden_document_link!='0'"><span style="color:red;">Click For Old Report</span></a>                                                   
                        <div>
                        	<input value="{{file_name}}" class="form-control uploadFile" placeholder="Choose File" disabled="disabled" name="motbill"/>
                            <div class="fileUpload btn btn-sm btn-info" tooltip="Upload" tooltip-placement="right">
                                <span class="ion ion-upload"></span>
                                <input type="file" class="upload uploadBtn" name="motbill" onchange="angular.element(this).scope().file_load_exp(this.files)"/>
                            </div>
                        </div>    
                        <div class="mb20" ng-if="prg_shw_hde">
                            <md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Amount</label>
                            <input value="{{editViews.amount}}" class="amtt tamfor tcm amntDig" ng-keypress="onlyIntegers($event)" ng-keyup="onlyIntegers($event);amnt()" ng-focus="onlyIntegers($event)" name="amt" placeholder="Amount" autocomplete="off">
                        </md-input-container>
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
</div>
<script>
setInterval(function(){$('.SlectBox').SumoSelect();
$('.forms_update').find('.SumoSelect').addClass('singleSelect');},0);
</script>