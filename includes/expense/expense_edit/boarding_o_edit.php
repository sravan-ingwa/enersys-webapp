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
<div class="modal-style" ng-controller="bod_O_EditCtrl">	
	<div class="modal-header clearfix">
		<h4 class="modal-title">EDIT BOARDING </h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body" ng-controller="updatingCntrl">
		<form class="form-horizontal forms_update" name="advanceRequest" method="post" url="services/expense_tracker/oth_bod_single_edit" ng-submit="upadteRequest()" novalidate>
           <div class="boarding_amnt" ng-controller="othersExpenseeditCtrl">
           <input type="hidden" name="idb" value="{{editViews.alias}}"/>
           <input type="hidden" name="expenses_alias" value="{{editViews.expenses_alias}}" />
           <input type="hidden" name="prev_amt" value="{{editViews.amount}}" />
             <div class="row form-group">
                <div ng-controller="DatepickerDemoCtrl">
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Visit: Start Date</label>
                            <input type="text" value="{{editViews.check_in}}" readonly="readonly" ng-model="editViews.check_in" name="checkinb" class="checkin" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="boardvalto($event);open($event,'opened1')"/>
                       </md-input-container>
                    </div>	
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00E">Visit: End Date</label>
                            <input type="text" value="{{editViews.check_out}}" readonly="readonly" ng-model="editViews.check_out" name="checkoutb" class="checkout" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="boardvalto($event);open($event,'opened2')">
                        </md-input-container>
                    </div>
                </div>
                <div class="col-sm-3">
					<label class="selectlabel">State</label>
                    <select class="form-control selectdrop SlectBox bodvalto" ng-change="boardvalto($event);" ng-model="state" name="state">
                        <option value="" selected="selected">State</option>
                        <option value="a1" ng-selected="editViews.state == 'a1'">A+</option>
                        <option value="a" ng-selected="editViews.state == 'a'">A</option>
                        <option value="b" ng-selected="editViews.state == 'b'">B</option>
                        <option value="c" ng-selected="editViews.state == 'c'">C</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Amount</label>
                        <input value="{{editViews.amount}}" name="bamt" class="amtt tamfor blam selfamm amntDig"ng-keypress="onlyIntegers($event)" ng-keyup="amnt(); onlyIntegers($event)" ng-focus="onlyIntegers($event)"  autocomplete="off">
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