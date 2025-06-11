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
<div class="modal-style" ng-controller="lod_O_EditCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">EDIT LODGING</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body" ng-controller="updatingCntrl">
		<form class="form-horizontal forms_update" name="advanceRequest" method="post" url="services/expense_tracker/oth_lod_single_edit" ng-submit="upadteRequest()" novalidate>
           <div class="lodGing_amnt" ng-controller="othersExpenseeditCtrl">
           <input type="hidden" name="idl" value="{{editViews.alias}}"/>
           <input type="hidden" name="expenses_alias" value="{{editViews.expenses_alias}}" />
          	<input type="hidden" name="prev_amt" value="{{editViews.amount1}}" />
             <div class="row form-group">
                <div class="col-sm-3">
					<label class="selectlabel">Select Stay Type</label>
                    <select class="form-control selectdrop SlectBox stay" ng-model="stayType" ng-init="lodging_self(editViews.type_of_stay)" ng-change="lodging_self(stayType); amnt()" name="typeofstay">
                        <option value="" selected="selected">Select Stay Type</option>
                        <option value="Reimbursement" ng-selected="editViews.type_of_stay == 'Reimbursement'">Reimbursement</option>
                        <option value="Self" ng-selected="editViews.type_of_stay == 'Self'">Self</option>
                    </select>
                </div>
                <div ng-controller="DatepickerDemoCtrl">
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Check in Date</label>
                            <input type="text" value="{{editViews.check_in}}" readonly="readonly" ng-model="editViews.check_in" name="checkin"  class="checkin" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="loadvalto($event);open($event,'opened1')"/>
                       </md-input-container>
                    </div>	
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00E">Check out Date</label>
                            <input type="text" value="{{editViews.check_out}}" readonly="readonly" ng-model="editViews.check_out" name="checkout" class="checkout" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="loadvalto($event);open($event,'opened2')">
                        </md-input-container>
                    </div>
                </div>
                 <div class="col-sm-3" ng-class="htName">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Hotel Name</label>
                        <input type="text"  value="{{editViews.hotel_name}}" name="hotelName">
                    </md-input-container>
                </div>
                <div class="col-sm-3" ng-class="stName">
					<label class="selectlabel">State</label>
                    <select class="form-control selectdrop SlectBox lodvalto htname" ng-change="loadvalto($event);"  ng-model="state" name="hotelName1">
                        <option value="" selected="selected">State</option>
                        <option value="a1" ng-selected="editViews.hotel_name == 'a1'">A+</option>
                        <option value="a" ng-selected="editViews.hotel_name == 'a'">A</option>
                        <option value="b" ng-selected="editViews.hotel_name == 'b'">B</option>
                        <option value="c" ng-selected="editViews.hotel_name == 'c'">C</option>
                    </select>
                </div>
             </div>
             <div class="row form-group">
                <div class="col-sm-3 filesRow margin-none" ng-controller="fileUploadCtrl"> 
					<label class="selectlabel">Upload File</label>				
                    <input type="hidden" name="lfile_old" value="{{editViews.hidden_document_link}}"/>                                                                  
                    <div>
                        <input value="{{file_name}}" class="form-control uploadFile" placeholder="Choose File" disabled="disabled" name="lfile"/>
                        <div class="fileUpload btn btn-sm btn-info" tooltip="Upload" tooltip-placement="right">
                            <span class="ion ion-upload"></span>
                            <input type="file" class="upload uploadBtn" name="lfile" onchange="angular.element(this).scope().file_load_exp(this.files)"/>
                        </div>
                    </div>    
                    <div class="mb20" ng-if="prg_shw_hde">
                        <md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
                    </div>
					<a href="{{editViews.document_link}}" target="_blank" ng-if="editViews.hidden_document_link!='' && editViews.hidden_document_link!='0'"><span style="color:red;">Click For Old Report</span></a>     
                </div> 
                <div class="col-sm-3">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Amount</label>
                        <input value="{{editViews.amount}}" ng-model="editViews.amount" name="lamt" class="amtt tamfor tlam selfamm stAmnt amntDig" ng-keypress="onlyIntegers($event)" ng-focus="onlyIntegers($event)" readonly="readonly" ng-keyup="amnt(); onlyIntegers($event)" autocomplete="off">
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
</script>