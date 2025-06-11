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
<div class="modal-style" ng-controller="bod_O_AddCtrl">	
	<div class="modal-header clearfix">
		<h4 class="modal-title">ADD BOARDING</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body">
		<form class="form-horizontal forms_update" name="expenseRequest" method="post" url="services/expense_tracker/oth_bod_single_add" ng-submit="addRequest()" novalidate>
            <input type="hidden" name="alias" value="{{expAlias}}">
            <div ng-controller="addFieldsExpCtrl" class="row form-group padding-10">
                <div class="col-sm-12">
                    <div class="row form-group" ng-repeat="field in forms">  
                   <div class="panel panel-info mb10" ng-repeat="(key,type) in field.itemtype">
                        <div class="panel-heading" style="padding:7px 18px;">
                            <span>Boarding {{expenseViews.exp_bod_count+key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20" style="line-height:1;"></span></a></span>
                        </div>
                        <div class="panel-body boarding_amnt" ng-controller="othersExpenseeditCtrl">
                             <div class="row form-group">
                                <div ng-controller="DatepickerDemoCtrl">
                                    <div class="col-sm-3">
                                        <md-input-container flex="" class="md-default-theme">
                                            <label for="input_00D">Visit: Start Date</label>
                                            <input type="text" ng-model="Startddate" readonly="readonly" name="checkinb[]" class="checkin" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="true" data-ng-focus="boardvalto($event);open($event,'opened1')"/>
                                       </md-input-container>
                                    </div>	
                                    <div class="col-sm-3">
                                        <md-input-container flex="" class="md-default-theme">
                                            <label for="input_00E">Visit: End Date</label>
                                            <input type="text" ng-model="Enddate" readonly="readonly" name="checkoutb[]" class="checkout" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="true" data-ng-focus="boardvalto($event);open($event,'opened2')">
                                        </md-input-container>
                                    </div>
                                </div>
                                <div class="col-sm-3">
									<label class="selectlabel">State</label>
                                    <select class="form-control selectdrop SlectBox bodvalto" ng-model="state" ng-change="boardvalto($event);"  name="state[]">
                                        <option value="" selected="selected">State</option>
                                        <option value="a1">A+</option>
                                        <option value="a">A</option>
                                        <option value="b">B</option>
                                        <option value="c">C</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                        <label for="input_00B">Amount</label>
                                        <input value="" name="bamt[]" class="amtt tamfor blam selfamm amntDig" ng-keypress="onlyIntegers($event)" ng-keyup="amnt(); onlyIntegers($event)" ng-focus="onlyIntegers($event)" autocomplete="off">
                                    </md-input-container>
                                </div>
                             </div>
                        </div>	
                    </div>
                    <div class="col-md-4 right mt5">
                        <input readonly="readonly" class="form-control blamt" placeholder="Total Boarding" name="fare_total_bod">
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