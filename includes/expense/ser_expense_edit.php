<style>
.table > tbody + tbody{border-top:1px solid #eee;}
.form-group {margin-bottom:0px !important;}
.form-group div.col-sm-6{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.datepicker {border-bottom: 1px solid #efefef !important;}
table > tbody > tr > td {text-align:center !important;}
.tbform input[type="text"], .tbform input[type="file"], .tbform select {border: none !important; margin: 0 !important;padding: 0 !important;width: 100% !important;outline: none !important;webkit-box-shadow: none;box-shadow: none;}
.panel-default .panel-heading{margin:0px; background-color:#428bca; color:#fff; padding:8px 0px;}
.panel-default .panel-heading span{margin-left:10px;}
.panel{border: 1px solid #e4e4e4 !important;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
.delLoc{margin-top: -15px; padding: 8px;color: #fff;}
.upload-file {border-bottom: 1px solid rgba(0,0,0,0.12); padding-top: 9px;}
.SumoSelect > .optWrapper > .options > .selected{background-color : #428bca;}
.SumoSelect > .optWrapper > .options > .selected > label{ color:#fff;}
.tab-content{padding:10px !important;}
</style>
<div class="modal-style" ng-controller="EnersysExpenseCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit Expenses</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body">
		<form class="form-horizontal forms_request" name="SerEditForm" data-went="#/expenses" method="post" url="services/expense_tracker/service_expences_edit" novalidate>
            <input type="hidden" value="{{expenseViews.expenses_alias}}" name="id" />
        	<input type="hidden" value="{{expenseViews.ref2}}" name="ref2" />
            <div class="row form-group">
            	<div class="col-sm-3">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00A">Date Of Request</label>
                        <input value="{{expenseViews.requested_date}}" readonly="readonly">
                    </md-input-container>
				</div>
                
                <div class="col-sm-3">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Employee ID</label>
                        <input value="{{expenseViews.employee_id}}" readonly="readonly">
                    </md-input-container>
				</div>
                
                 <div class="col-sm-3">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Employee Name</label>
                        <input value="{{expenseViews.employee_name}}" readonly="readonly">
                    </md-input-container>
				 </div>
              	<div ng-controller="DatepickerDemoCtrl">  
                     <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Grade</label>
                            <input value="{{expenseViews.grade}}" readonly="readonly">
                        </md-input-container>
                     </div>
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Visit Start Date</label>
                            <input type="text" value="{{expenseViews.period_of_visit_from}}" ng-model="expenseViews.period_of_visit_from" readonly="readonly" name="visitFromDate" class="" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"  data-ng-focus="dateCal();open($event,'opened1')"/>
                       </md-input-container>
                    </div>	
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00E">Visit End Date</label>
                            <input type="text" value="{{expenseViews.places_of_visit_to}}" ng-model="expenseViews.places_of_visit_to" readonly="readonly" name="visitToDate" class="" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" ng-init="dateCal()" data-ng-focus="dateCal();open($event,'opened2')">
                        </md-input-container>
                    </div>
              	</div>  
                <div class="col-sm-3">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">No.Of Days</label>
                        <input value="{{expenseViews.no_of_days}}" id="num_nights" readonly="readonly">
                    </md-input-container>
				</div>
                <div class="col-sm-3">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Visited Place's</label>
                        <input value="{{expenseViews.places_of_visit}}" name="placesOfVisit">
                    </md-input-container>
				</div>
                <div class="col-sm-3">
                	<textarea rows="2" class="form-control resize-v" name="purpose" placeholder="Purpose">{{expenseViews.purpose}}</textarea>
                </div>    
                <div class="col-sm-3">
                    <textarea rows="2" class="form-control resize-v" name="remarks" placeholder="Remarks">{{expenseViews.user_remarks}}</textarea>
                </div> 
               </div>
               
               <!---------   DPR Details -------->
               <div class="row form-group mt10" ng-init="dprreadViews(expenseViews.period_of_visit_from,expenseViews.places_of_visit_to,expenseViews.empalias)">  
                <div class="col-lg-12 dprDetails">
                    <label>DPR Details : </label>
                    <table class="table table-bordered">
                        <thead><tr class="blue cust"><th>DPR Number</th><th>Category</th><th>Submitted Date</th><th>Remarks</th><th>Expense</th></tr></thead>
                        <tbody>
                           <tr ng-repeat="dpr in dprViews.dprDetails">
                        	<td>{{dpr.dpr_ref_no}}</td>
                            <td>{{dpr.dpr_cat}}</td>
                            <td>{{dpr.sub_date}}</td>
                            <td>{{dpr.dpr_remarks}}</td>
                            <td>{{dpr.expense_incurred}}</td>
                          </tr>
                        </tbody>
                        <tfoot ng-if="dprViews.dprDetails.length=='0'"><tr><td colspan="5">No Records</td></tr></tfoot>
                    </table>
                </div>
               </div> 
                <tabset justified="true" class="tabs-linearrow mt10">
                	<tab>
                    	<tab-heading class="active">Local Conveyance</tab-heading>
                        	<div ng-controller="addFieldsExpCtrl" class="row form-group padding-10">
                            	<div class="col-sm-12">
                               		<div class="row form-group" ng-repeat="field in forms">  
                                   <div class="panel panel-default mb10 expHide" ng-repeat="(key,loc) in expenseViews.exp_locconveyance">
                                        <div class="panel-heading">
                                            <span>Local Conveyance {{key+1}}<a href="" ng-click="removeDyn(key,loc.alias,loc.expenses_alias,$event)" class="delLoc right"><span class="ion ion-android-delete fnt-20" data-ref="lc"></span></a></span>
                                        </div>
                                        <div class="panel-body locCon" ng-controller="loczoneStateMulCntrl">
                                        <input type="hidden" name="idc_l[]" value="{{loc.alias}}"/>
                                            <div class="row form-group">
                                                <div class="col-sm-3">
                                                    <label class="selectlabel">Zone</label>
                                                    <select name="zone_l[]" class="SlectBox form-control zoneChange" ng-model="zones" ng-init="dep_drop(loc.zone_alias)" data-ng-change="zone_loc(zones,$event);" data-ref="lc">
                                                        <option value="" style="display:none" selected="selected">Zones</option>
                                                        <option ng-repeat="zone in firstDrop" value="{{zone.alias}}" ng-selected="zone.alias == loc.zone_alias">{{zone.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="selectlabel">State</label>
                                                    <select class="form-control SlectBox stateChange" name="state_l[]" ng-model="states" ng-init="dep_drop2(loc.state_alias)" data-ng-change="state_loc(states, $event);">
                                                        <option value="" style="display:none" selected="selected">States</option>
                                                        <option ng-repeat="state in secondDrop" value="{{state.alias}}" ng-selected="state.alias == loc.state_alias">{{state.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="selectlabel">District</label>
                                                    <select class="form-control SlectBox districtChange" placeholder="District" name="district_l[]" ng-init="dep_drop3(loc.district_alias)" data-ng-change="district_loc(districts, $event);" ng-model="districts">
                                                        <option value="" style="display:none" selected="selected">Districts</option>
                                                        <option ng-repeat="district in thirdDrop" value="{{district.alias}}" ng-selected="district.alias == loc.district_alias">{{district.name}}</option>
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
                                                    <select name="bucket[]" class="form-control selectdrop SlectBox localConvy" ng-model="bucket" ng-init="localConvy(loc.bucket_val)" ng-change="localConvy(bucket);">
                                                        <option value="" selected="selected">Bucket</option>
                                                        <option value="0" ng-selected="loc.bucket_val == '0'">Secondary Transportation</option>
                                                        <option value="1" ng-selected="loc.bucket_val == '1'">Local Conveyance</option>
                                                    </select>
                                                </div>
                                                <div ng-class="abc" ng-controller="capdropCntrl">
                                                <div class="col-sm-3">
                                                    <label class="selectlabel">Capacity</label>
                                                    <select class="form-control SlectBox selectdrop capChange cap" placeholder="Product Code" name="cap[]" ng-model="productcode" ng-init="capChange(loc.capacity_val)" ng-change="capChange(productcode);" >
                                                        <option value="" style="display:none" selected="selected">Capacity</option>
                                                        <option ng-repeat="product in firstDrop" value="{{product.alias}}" ng-selected="product.alias == loc.capacity_val">{{product.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00D">Weight of cell</label>
                                                        <input  value="{{capChng.product_weight}}" readonly="readonly" name="wofCell[]" class="weightChange ocap" >
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">Quantity</label>
                                                        <input value="{{loc.quantity}}" name="quantityCell[]" class="qnty ocap" placeholder="Quantity"  ng-keyup="qnty(); qntyInt($event)" ng-keypress="qntyInt($event)" ng-focus="qntyInt($event)" autocomplete="off">
                                                    </md-input-container>
                                                </div>
                                             
                                               <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">No.of Kilometers</label>
                                                        <input value="{{loc.km}}" name="numKilometers[]" class="numKilo ocap" placeholder="No.of Kilometers" ng-keyup="numKilo()" autocomplete="off">
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
                                                        <input type="text" value="{{loc.date_of_travel}}" readonly="readonly" ng-model="loc.date_of_travel" class=" border-bottom" name="dot_l[]" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>  
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">From</label>
                                                        <input value="{{loc.from_place}}" name="from_l[]" placeholder="From Place">
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">To</label>
                                                        <input value="{{loc.to_place}}" name="to_l[]" placeholder="To Place">
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-3">
													<label class="selectlabel">Mode Of Travel</label>
                                                    <select class="form-control selectdrop SlectBox" ng-model="mot_l" name="mot_l[]" >
                                                        <option value="" selected>Mode Of Travel</option>
                                                        <option ng-repeat="mot in locOfTravel" value="{{mot.name}}" ng-selected="mot.name == loc.mode_of_travel">{{mot.name}}</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="col-sm-3" ng-controller="ticketDropCtrl">
                                                    <label class="selectlabel">Ticket ID</label>
                                                    <select class="form-control SlectBox" placeholder="Ticket ID" name="ticket_idl[]" ng-model="ticket_id" >
                                                        <option value="" selected="selected" style="display:none" >Select Ticket ID</option>
                                                        <option value="1" ng-selected="loc.ticket_alias == '1'">Others</option>
                                                        <option ng-repeat="ticket in firstDrop" value="{{ticket.alias}}" ng-selected="ticket.alias == loc.ticket_alias">{{ticket.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">DPR Number</label>
                                                        <input value="{{loc.dpr_number}}" name="dprNum_l[]">
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">Amount</label>
                                                        <input readonly="readonly" name="amt_l[]" value="{{loc.amount}}" class="amtt tamfor ttcm lc" ng-keyup="amnt();">
                                                    </md-input-container>
                                                </div>
                                             </div>
                                        </div>	
                                    </div>
                                   
                                   <div class="panel panel-default mb10" ng-repeat="(key,type) in field.itemtype">
                                        <div class="panel-heading">
                                            <span>Local Conveyance {{expenseViews.exp_locconveyance.length+key+1}}<a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20"></span></a></span>
                                        </div>
                                        <div class="panel-body locCon" ng-controller="loczoneStateMulCntrl">
                                            <input type="hidden" name="idc_l[]" value="0"/>
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
                                                    <select name="bucket[]" class="form-control selectdrop SlectBox localConvy" ng-model="bucket" ng-change="localConvy();">
                                                        <option value="" selected="selected">Bucket</option>
                                                        <option value="0">Secondary Transportation</option>
                                                        <option value="1">Local Conveyance</option>
                                                    </select>
                                                </div>
                                                <div ng-show="bucket == '0'" ng-controller="capdropCntrl">
                                                <div class="col-sm-3">
                                                    <label class="selectlabel">Capacity</label>
                                                    <select class="form-control SlectBox selectdrop capChange cap" placeholder="Product Code" name="cap[]" ng-model="productcode" ng-change="capChange(productcode);" >
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
                                                        <input value="" name="quantityCell[]" class="qnty ocap" placeholder="Quantity" ng-keyup="qnty()" autocomplete="off">
                                                    </md-input-container>
                                                </div>
                                             
                                               <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00B">No.of Kilometers</label>
                                                        <input value="" name="numKilometers[]" class="numKilo ocap" placeholder="No.of Kilometers" ng-keyup="numKilo()" autocomplete="off">
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
                                                        <input type="text" class="border-bottom" readonly="readonly" name="dot_l[]" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" ng-model="dot_l" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>  
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
                                                <div class="col-sm-3">
													<label class="selectlabel">Mode Of Travel</label>
                                                    <select class="form-control selectdrop SlectBox" ng-model="mot_l" name="mot_l[]" >
                                                        <option value="" selected>Mode Of Travel</option>
                                                        <option ng-repeat="mot in locOfTravel" value="{{mot.name}}">{{mot.name}}</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="col-sm-3" ng-controller="ticketDropCtrl">
                                                    <label class="selectlabel">Ticket ID</label>
                                                    <select class="form-control SlectBox" placeholder="Ticket ID" name="ticket_idl[]" ng-model="ticket_id" >
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
                                    <div class="col-md-4 right mt10">
                                        <input readonly="readonly" value="{{expenseViews.tot_lcon_amt}}" class="form-control ttcmt" name="fare_total_loc" placeholder="Total Local Conveyance">
                                    </div>
									<a href="" class="text-info fnt-20 ml10" ng-click="addFields(field,$event)"> New Field : <span class="ion ion-plus-circled fnt-20"></span></a>
                               </div>
                               	</div>
                            </div>
                    </tab>
                    <tab>
                    	<tab-heading class="active">Conveyance</tab-heading>
                        	<div ng-controller="addFieldsExpCtrl" class="row form-group padding-10">
                            	<div class="col-sm-12">
                              		<div class="row form-group" ng-repeat="field in forms">  
                                   <div class="panel panel-default mb10 expHide" ng-repeat="(key,con) in expenseViews.exp_conveyance">
                                        <div class="panel-heading">
                                            <span>Conveyance {{key+1}} <a href="" ng-click="removeDyn(key,con.alias,con.expenses_alias,$event)" class="delLoc right"><span class="ion ion-android-delete fnt-20" data-ref="co"></span></a></span>
                                        </div>
                                        <div class="panel-body">
                                        <input type="hidden" name="idc[]" value="{{con.alias}}" />
                                            <div class="row form-group">
                                                <div class="col-sm-3" ng-controller="DatepickerDemoCtrl">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">Date of Travel</label>
                                                        <input type="text" value="{{con.date_of_travel}}" readonly="readonly" ng-model="con.date_of_travel"  name="dot[]" class="border-bottom" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>  
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-3">
													<label class="selectlabel">Mode Of Travel</label>
                                                    <select  class="form-control selectdrop SlectBox" ng-model="mot" name="mot[]" >
                                                        <option value="" selected>Mode Of Travel</option>
                                                        <option ng-repeat="mot in modeOfTravel" value="{{mot.name}}" ng-selected="mot.name == con.mode_of_travel">{{mot.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">From</label>
                                                        <input value="{{con.from_place}}" name="from[]"  placeholder="From">
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">To</label>
                                                        <input value="{{con.to_place}}" name="to[]" placeholder="To">
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-3" ng-controller="ticketDropCtrl">
                                                    <label class="selectlabel">Ticket ID</label>
                                                    <select class="form-control SlectBox" placeholder="Ticket ID" name="cticket_id[]" ng-model="ticket_id" >
                                                        <option value="" selected="selected" style="display:none" >Select Ticket ID</option>
                                                        <option value="1" ng-selected="con.ticket_alias == '1'">Others</option>
                                                        <option ng-repeat="ticket in firstDrop" value="{{ticket.alias}}" ng-selected="ticket.alias == con.ticket_alias">{{ticket.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">DPR Number</label>
                                                        <input value="{{con.dpr_number}}" name="cdprno[]" placeholder="DPR Number">
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-3 oldfilesRow">
                                                    <input type="hidden" class="form-control" name="motbill_old[]" value="{{con.hidden_document_link}}"/>
                                                	<a href="{{con.document_link}}" target="_blank" ng-if="con.hidden_document_link!='' && con.hidden_document_link!='0'"><span style="color:red;">Click For Old Report</span></a>
                                                	<div>
                                                    <input class="form-control uploadFile" placeholder="Choose File" disabled="disabled" name="motbill[]"/>
                                                    <div class="fileUpload btn btn-sm btn-info" tooltip="Upload" tooltip-placement="bottom">
                                                        <span class="ion ion-upload"></span>
                                                        <input type="file" class="upload uploadBtn" name="motbill[]" />
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">Amount</label>
                                                        <input value="{{con.amount}}" class="amtt tamfor tcm amntDig" ng-keypress="onlyIntegers($event)" ng-keyup="onlyIntegers($event);amnt()" ng-focus="onlyIntegers($event)" name="amt[]" placeholder="Amount" autocomplete="off">
                                                    </md-input-container>
                                                </div>
                                             </div>
                                        </div>	
                                    </div>
                                   <div class="panel panel-default mb10" ng-repeat="(key,type) in field.itemtype">
                                        <div class="panel-heading">
                                            <span>Conveyance {{expenseViews.exp_conveyance.length+key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20"></span></a></span>
                                        </div>
                                        <div class="panel-body">
                                         <input type="hidden" name="idc[]" value="0" />
                                            <div class="row form-group">
                                                <div class="col-sm-3" ng-controller="DatepickerDemoCtrl">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">Date of Travel</label>
                                                        <input type="text" name="dot[]" readonly="readonly" class="border-bottom" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" ng-model="dot" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>  
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-3">
													<label class="selectlabel">Mode Of Travel</label>
                                                    <select  class="form-control selectdrop SlectBox" ng-model="mot" name="mot[]" >
                                                        <option value="" selected>Mode Of Travel</option>
                                                        <option ng-repeat="mot in modeOfTravel" value="{{mot.name}}">{{mot.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00B">From</label>
                                                        <input value="" name="from[]"  placeholder="From">
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00B">To</label>
                                                        <input value="" name="to[]" placeholder="To">
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-3" ng-controller="ticketDropCtrl">
                                                    <label class="selectlabel">Ticket ID</label>
                                                    <select class="form-control SlectBox" placeholder="Ticket ID" name="cticket_id[]" ng-model="ticket_id" >
                                                        <option value="" selected="selected" style="display:none" >Select Ticket ID</option>
                                                        <option value="1">Others</option>
                                                        <option ng-repeat="ticket in firstDrop" value="{{ticket.alias}}">{{ticket.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00B">DPR Number</label>
                                                        <input value="" name="cdprno[]" placeholder="DPR Number">
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-3 filesRow">
                                                    <input class="form-control uploadFile" placeholder="Choose File" disabled="disabled" name="motbill[]"/>
                                                    <div class="fileUpload btn btn-sm btn-info" tooltip="Upload" tooltip-placement="top">
                                                        <span class="ion ion-upload"></span>
                                                        <input type="file" class="upload uploadBtn" name="motbill[]" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00B">Amount</label>
                                                        <input class="amtt tamfor tcm amntDig" ng-keypress="onlyIntegers($event)" ng-keyup="onlyIntegers($event);amnt()" ng-focus="onlyIntegers($event)" name="amt[]" placeholder="Amount"  autocomplete="off">
                                                    </md-input-container>
                                                </div>
                                             </div>
                                        </div>	
                                    </div>
                                        <div class="col-md-4 right mt10">
                                            <input value="{{expenseViews.tot_con_amt}}" readonly="readonly" class="form-control tcmt" placeholder="Total Conveyance"  name="fare_total_con">
                                        </div>
										<a href="" class="text-info fnt-20 ml10" ng-click="addFields(field,$event)"> New Field : <span class="ion ion-plus-circled fnt-20"></span></a>
                               </div>
                                </div>
                            </div>
                    </tab>
                    <tab>
                    	<tab-heading class="active">Lodging</tab-heading>
                        	<div ng-controller="addFieldsExpCtrl" class="row form-group padding-10">
                            	<div class="col-sm-12">
                               		<div class="row form-group" ng-repeat="field in forms">  
                                   <div class="panel panel-default mb10 expHide" ng-repeat="(key,lod) in expenseViews.exp_lodging">
                                        <div class="panel-heading">
                                            <span>Lodging {{key+1}} <a href="" ng-click="removeDyn(key,lod.alias,lod.expenses_alias,$event)" class="delLoc right"><span class="ion ion-android-delete fnt-20"  data-ref="ld"></span></a></span>
                                        </div>
                                        <div class="panel-body locCon" ng-controller="loczoneStateMulCntrl">
                                         <input type="hidden" name="idl[]" value="{{lod.alias}}" />
                                             <div class="row form-group">
                                                <div ng-controller="DatepickerDemoCtrl">
                                                    <div class="col-sm-3">
                                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                            <label for="input_00D">Check in Date</label>
                                                            <input type="text" value="{{lod.check_in}}" readonly="readonly" ng-model="lod.check_in" class="bdpd3 cddl bg-white clc datepicker" name="checkin[]" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="loddateChange($event);open($event,'opened1')"/>
                                                       </md-input-container>
                                                    </div>	
                                                    <div class="col-sm-3">
                                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                            <label for="input_00E">Check out Date</label>
                                                            <input type="text" value="{{lod.check_out}}" readonly="readonly" ng-model="lod.check_out" class="bdpd4 cddl bg-white slc datepicker" name="checkout[]" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="loddateChange($event);open($event,'opened2')">
                                                        </md-input-container>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="selectlabel">Zone</label>
                                                    <select placeholder="Zone" name="zone_ld[]" class="SlectBox form-control zoneChange" ng-model="zones" ng-init="dep_drop(lod.zone_alias)"  data-ng-change="zone_loc(zones,$event);" data-ref="ld">
                                                        <option value="" style="display:none" selected="selected">Zones</option>
                                                        <option ng-repeat="zone in firstDrop" value="{{zone.alias}}" ng-selected="zone.alias == lod.zone_alias">{{zone.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="selectlabel">State</label>
                                                    <select class="form-control SlectBox stateChange" placeholder="State"  name="state_ld[]" id="state" ng-model="states"  ng-init="dep_drop2(lod.state_alias)"  data-ng-change="state_loc(states,$event);" >
                                                        <option value="" style="display:none" selected="selected">States</option>
                                                        <option ng-repeat="state in secondDrop" value="{{state.alias}}" ng-selected="state.alias == lod.state_alias">{{state.name}}</option>
                                                    </select>
                                                </div>
                                             </div>
                                             <div class="row form-group">   
                                                <div class="col-sm-3">
                                                    <label class="selectlabel">District</label>
                                                    <select class="form-control SlectBox districtChange" placeholder="District"  name="district_ld[]" ng-model="districts"  ng-init="dep_drop3(lod.district_alias)" ng-change="district_loc(districts,$event);" >
                                                        <option value="" style="display:none" selected="selected">Districts</option>
                                                        <option ng-repeat="district in thirdDrop" value="{{district.alias}}" ng-selected="district.alias == lod.district_alias">{{district.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">Hotel Name</label>
                                                        <input value="{{lod.hotel_name}}" name="hotelName[]" placeholder="Hotel Name">
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-3" ng-controller="ticketDropCtrl">
                                                    <label class="selectlabel">Ticket ID</label>
                                                    <select class="form-control SlectBox" placeholder="Ticket ID" name="ticket_idld[]" ng-model="ticket_id" >
                                                        <option value="" selected="selected" style="display:none" >Select Ticket ID</option>
                                                        <option value="1" ng-selected="lod.ticket_alias == '1'">Others</option>
                                                        <option ng-repeat="ticket in firstDrop" value="{{ticket.alias}}" ng-selected="ticket.alias == lod.ticket_alias">{{ticket.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">DPR Number</label>
                                                        <input value="{{lod.dpr_number}}" name="dprNum_ld[]" placeholder="DPR Number">
                                                    </md-input-container>
                                                </div>
                                             </div>
                                             <div class="row form-group">
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">Amount</label>
                                                        <input value="{{lod.amount}}" class="amtt tamfor tlam selfamm ld" readonly="readonly" name="lamt[]" ng-keyup="amnt()" placeholder="Amount">
                                                    </md-input-container>
                                                </div>
                                             </div>
                                        </div>	
                                    </div>
                                   <div class="panel panel-default mb10" ng-repeat="(key,type) in field.itemtype">
                                        <div class="panel-heading">
                                            <span>Lodging {{expenseViews.exp_lodging.length+key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20"></span></a></span>
                                        </div>
                                        <div class="panel-body locCon" ng-controller="loczoneStateMulCntrl">
                                         <input type="hidden" name="idl[]" value="0" />
                                             <div class="row form-group">
                                                <div ng-controller="DatepickerDemoCtrl">
                                                    <div class="col-sm-3">
                                                        <md-input-container flex="" class="md-default-theme">
                                                            <label for="input_00D">Check in Date</label>
                                                            <input type="text" ng-model="Startddate" readonly="readonly" class="bdpd3 cddl bg-white clc" name="checkin[]" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="loddateChange($event);open($event,'opened1')"/>
                                                       </md-input-container>
                                                    </div>	
                                                    <div class="col-sm-3">
                                                        <md-input-container flex="" class="md-default-theme">
                                                            <label for="input_00E">Check out Date</label>
                                                            <input type="text" ng-model="Endddate" readonly="readonly" class="bdpd4 cddl bg-white slc" name="checkout[]" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="loddateChange($event);open($event,'opened2')">
                                                        </md-input-container>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="selectlabel">Zone</label>
                                                    <select placeholder="Zone" name="zone_ld[]" class="SlectBox form-control zoneChange" ng-model="zones"  data-ng-change="zone_loc(zones,$event);" data-ref="ld">
                                                        <option value="" style="display:none" selected="selected">Zones</option>
                                                        <option ng-repeat="zone in firstDrop" value="{{zone.alias}}">{{zone.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="selectlabel">State</label>
                                                    <select class="form-control SlectBox stateChange" placeholder="State"  name="state_ld[]" id="state" ng-model="states"  data-ng-change="state_loc(states,$event);" >
                                                        <option value="" style="display:none" selected="selected">States</option>
                                                        <option ng-repeat="state in secondDrop" value="{{state.alias}}">{{state.name}}</option>
                                                    </select>
                                                </div>
                                             </div>
                                             <div class="row form-group">   
                                                <div class="col-sm-3">
                                                    <label class="selectlabel">District</label>
                                                    <select class="form-control SlectBox districtChange" placeholder="District"  name="district_ld[]" ng-model="districts" ng-change="district_loc(districts,$event);" >
                                                        <option value="" style="display:none" selected="selected">Districts</option>
                                                        <option ng-repeat="district in thirdDrop" value="{{district.alias}}">{{district.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00B">Hotel Name</label>
                                                        <input value="" name="hotelName[]" placeholder="Hotel Name">
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-3" ng-controller="ticketDropCtrl">
                                                    <label class="selectlabel">Ticket ID</label>
                                                    <select class="form-control SlectBox" placeholder="Ticket ID" name="ticket_idld[]" ng-model="ticket_id" >
                                                        <option value="" selected="selected" style="display:none" >Select Ticket ID</option>
                                                        <option value="1">Others</option>
                                                        <option ng-repeat="ticket in firstDrop" value="{{ticket.alias}}">{{ticket.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00B">DPR Number</label>
                                                        <input value="" name="dprNum_ld[]" placeholder="DPR Number">
                                                    </md-input-container>
                                                </div>
                                             </div>
                                             <div class="row form-group">
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">Amount</label>
                                                        <input  class="amtt tamfor tlam selfamm ld" readonly="readonly" name="lamt[]" ng-keyup="amnt()" placeholder="Amount">
                                                    </md-input-container>
                                                </div>
                                             </div>
                                        </div>	
                                    </div>
                                        <div class="col-md-4 right mt10">
                                            <input readonly="readonly"  class="form-control tlamt" placeholder="Total Lodging" name="fare_total_lod">
                                        </div>
										<a href="" class="text-info fnt-20 ml10" ng-click="addFields(field,$event)"> New Field : <span class="ion ion-plus-circled fnt-20"></span></a>
                               </div>
                               </div>
                            </div>
                    </tab>
                    <tab>
                    	<tab-heading class="active">Boarding</tab-heading>
                        	<div ng-controller="addFieldsExpCtrl" class="row form-group padding-10">
                            	<div class="col-sm-12">
                               		<div class="row form-group" ng-repeat="field in forms">  
                                   <div class="panel panel-default mb10 expHide" ng-repeat="(key,bod) in expenseViews.exp_boarding">
                                        <div class="panel-heading">
                                            <span>Boarding {{key+1}} <a href=""  ng-click="removeDyn(key,bod.alias,bod.expenses_alias,$event)" class="delLoc right"><span class="ion ion-android-delete fnt-20" data-ref="bd"></span></a></span>
                                        </div>
                                        <div class="panel-body locCon" ng-controller="loczoneStateMulCntrl">
                                         <input type="hidden" name="idb[]" value="{{bod.alias}}" />
                                             <div class="row form-group">
                                                <div ng-controller="DatepickerDemoCtrl">
                                                    <div class="col-sm-3">
                                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                            <label for="input_00D">Visit: Start Date</label>
                                                            <input type="text" value="{{bod.check_in}}" readonly="readonly" ng-model="bod.check_in" class="bdpd1 cddl bg-white clc datepicker" name="checkinb[]" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="boddateChange($event);open($event,'opened1')"/>
                                                       </md-input-container>
                                                    </div>	
                                                    <div class="col-sm-3">
                                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                            <label for="input_00E">Visit: End Date</label>
                                                            <input type="text" value="{{bod.check_out}}" readonly="readonly" ng-model="bod.check_out" class="bdpd2 cddl bg-white slc datepicker" name="checkoutb[]" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="boddateChange($event);open($event,'opened2')">
                                                        </md-input-container>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="selectlabel">Zone</label>
                                                    <select placeholder="Zone" name="zone_bo[]"  class="SlectBox form-control zoneChange" ng-model="zones"  ng-init="dep_drop(bod.zone_alias)" data-ng-change="zone_loc(zones,$event);" data-ref="bd">
                                                         <option value="" style="display:none" selected="selected">Zones</option>
                                                        <option ng-repeat="zone in firstDrop" value="{{zone.alias}}" ng-selected="zone.alias == bod.zone_alias">{{zone.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="selectlabel">State</label>
                                                    <select class="form-control SlectBox stateChange" placeholder="State"  name="state_bo[]"  ng-model="states"  ng-init="dep_drop2(bod.state_alias)"  data-ng-change="state_loc(states,$event);">
                                                        <option value="" style="display:none" selected="selected">States</option>
                                                        <option ng-repeat="state in secondDrop" value="{{state.alias}}" ng-selected="state.alias == bod.state_alias">{{state.name}}</option>
                                                    </select>
                                                </div>
                                             </div>
                                             <div class="row form-group">   
                                                <div class="col-sm-3">
                                                    <label class="selectlabel">District</label>
                                                    <select class="form-control SlectBox districtChange" placeholder="District" name="district_bo[]" id="district" ng-model="districts" ng-init="dep_drop3(bod.district_alias)" ng-change="district_loc(districts,$event);">
                                                        <option value="" style="display:none" selected="selected">Districts</option>
                                                        <option ng-repeat="district in thirdDrop" value="{{district.alias}}"  ng-selected="district.alias == bod.district_alias">{{district.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3" ng-controller="ticketDropCtrl">
                                                    <label class="selectlabel">Ticket ID</label>
                                                    <select class="form-control SlectBox" placeholder="Ticket ID" name="ticket_bo[]" ng-model="ticket_id" >
                                                        <option value="" selected="selected" style="display:none" >Select Ticket ID</option>
                                                        <option value="1" ng-selected="bod.ticket_alias == '1'">Others</option>
                                                        <option ng-repeat="ticket in firstDrop" value="{{ticket.alias}}" ng-selected="ticket.alias == bod.ticket_alias">{{ticket.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">DPR Number</label>
                                                        <input value="{{bod.dpr_number}}" name="dprNum_bo[]" placeholder="DPR Number">
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">Amount</label>
                                                        <input class="amtt tamfor blam selfamm bd" value="{{bod.amount}}" readonly="readonly" ng-keyup="amnt()" name="bamt[]" placeholder="Amount">
                                                    </md-input-container>
                                                </div>
                                             </div>
                                        </div>	
                                    </div>
                                   <div class="panel panel-default mb10" ng-repeat="(key,type) in field.itemtype">
                                        <div class="panel-heading">
                                            <span>Boarding {{expenseViews.exp_boarding.length+key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20"></span></a></span>
                                        </div>
                                        <div class="panel-body locCon" ng-controller="loczoneStateMulCntrl">
                                        <input type="hidden" name="idb[]" value="0" />
                                             <div class="row form-group">
                                                <div ng-controller="DatepickerDemoCtrl">
                                                    <div class="col-sm-3">
                                                        <md-input-container flex="" class="md-default-theme">
                                                            <label for="input_00D">Visit: Start Date</label>
                                                            <input type="text" ng-model="Startddate" readonly="readonly" class="bdpd1 cddl bg-white clc" name="checkinb[]" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="boddateChange($event);open($event,'opened1')"/>
                                                       </md-input-container>
                                                    </div>	
                                                    <div class="col-sm-3">
                                                        <md-input-container flex="" class="md-default-theme">
                                                            <label for="input_00E">Visit: End Date</label>
                                                            <input type="text" ng-model="Enddate" readonly="readonly" class="bdpd2 cddl bg-white slc" name="checkoutb[]" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="boddateChange($event);open($event,'opened2')">
                                                        </md-input-container>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="selectlabel">Zone</label>
                                                    <select placeholder="Zone" name="zone_bo[]"  class="SlectBox form-control zoneChange" ng-model="zones" data-ng-change="zone_loc(zones,$event);" data-ref="bd">
                                                         <option value="" style="display:none" selected="selected">Zones</option>
                                                        <option ng-repeat="zone in firstDrop" value="{{zone.alias}}">{{zone.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="selectlabel">State</label>
                                                    <select class="form-control SlectBox stateChange" placeholder="State"  name="state_bo[]"  ng-model="states"  data-ng-change="state_loc(states,$event);">
                                                        <option value="" style="display:none" selected="selected">States</option>
                                                        <option ng-repeat="state in secondDrop" value="{{state.alias}}">{{state.name}}</option>
                                                    </select>
                                                </div>
                                             </div>
                                             <div class="row form-group">   
                                                <div class="col-sm-3">
                                                    <label class="selectlabel">District</label>
                                                    <select class="form-control SlectBox districtChange" placeholder="District" name="district_bo[]" id="district" ng-model="districts" ng-change="district_loc(districts,$event);">
                                                        <option value="" style="display:none" selected="selected">Districts</option>
                                                        <option ng-repeat="district in thirdDrop" value="{{district.alias}}">{{district.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3" ng-controller="ticketDropCtrl">
                                                    <label class="selectlabel">Ticket ID</label>
                                                    <select class="form-control SlectBox" placeholder="Ticket ID" name="ticket_bo[]" ng-model="ticket_id" >
                                                        <option value="" selected="selected" style="display:none" >Select Ticket ID</option>
                                                        <option value="1">Others</option>
                                                        <option ng-repeat="ticket in firstDrop" value="{{ticket.alias}}">{{ticket.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00B">DPR Number</label>
                                                        <input value="" name="dprNum_bo[]" placeholder="DPR Number">
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">Amount</label>
                                                        <input class="amtt tamfor blam selfamm bd" readonly="readonly" ng-keyup="amnt()" name="bamt[]" placeholder="Amount">
                                                    </md-input-container>
                                                </div>
                                             </div>
                                        </div>	
                                    </div>
                                        <div class="col-md-4 right mt10">
                                            <input value="{{expenseViews.tot_bod_amt}}" readonly="readonly" class="form-control blamt" placeholder="Total Boarding" name="fare_total_bod">
                                        </div>
										<a href="" class="text-info fnt-20 ml10" ng-click="addFields(field,$event)"> New Field : <span class="ion ion-plus-circled fnt-20"></span></a>
                               </div>
                                </div>
                            </div>
                    </tab>
                    <tab>
                    	<tab-heading class="active">Other's</tab-heading>
                        	<div ng-controller="addFieldsExpCtrl" class="row form-group padding-10">
                            	<div class="col-sm-12">
                               		<div class="row form-group" ng-repeat="field in forms">  
                                   <div class="panel panel-default mb10 expHide" ng-repeat="(key,oth) in expenseViews.exp_others">
                                        <div class="panel-heading">
                                            <span>Others {{key+1}} <a href="" ng-click="removeDyn(key,oth.alias,oth.expenses_alias,$event)"  class="delLoc right"><span class="ion ion-android-delete fnt-20" data-ref="ot"></span></a></span>
                                        </div>
                                        <div class="panel-body">
                                        <input type="hidden" name="ido[]" value="{{oth.alias}}" />
                                            <div class="row form-group">
                                                <div class="col-sm-4">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">Description</label>
                                                        <input value="{{oth.description}}" name="others[]">
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-4" ng-controller="DatepickerDemoCtrl">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">Date</label>
                                                        <input type="text" value="{{oth.checked_date}}" readonly="readonly" ng-model="oth.checked_date" name="odate[]" class="border-bottom" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>  
                                                    </md-input-container>
                                                </div> 
                                                <div class="col-sm-4 oldfilesRow">
                                                	<input type="hidden" class="form-control" name="ofile_old[]" value="{{oth.hidden_document_link}}"/>
                                                    <a href="{{oth.document_link}}" target="_blank" ng-if="oth.hidden_document_link!='' && oth.hidden_document_link!='0'"><span style="color:red;">Click For Old Report</span></a>
                                                	<div>
                                                    <input class="form-control uploadFile" placeholder="Choose File" disabled="disabled" name="ofile[]"/>
                                                    <div class="fileUpload btn btn-sm btn-info" tooltip="Upload" tooltip-placement="bottom">
                                                        <span class="ion ion-upload"></span>
                                                        <input type="file" class="upload uploadBtn" name="ofile[]" />
                                                    </div>
                                                    </div>
                                                </div>
                                             </div>
                                             <div class="row form-group">   
                                                <div class="col-sm-4" ng-controller="ticketDropCtrl">
                                                    <label class="selectlabel">Ticket ID</label>
                                                    <select class="form-control SlectBox" placeholder="Ticket ID" name="ticket_ot[]"  ng-model="ticket_id" >
                                                        <option value="" selected="selected" style="display:none" >Select Ticket ID</option>
                                                        <option value="1" ng-selected="oth.ticket_alias == '1'">Others</option>
                                                        <option ng-repeat="ticket in firstDrop" value="{{ticket.alias}}" ng-selected="ticket.alias == oth.ticket_alias">{{ticket.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">DPR Number</label>
                                                        <input value="{{oth.dpr_number}}" name="dprNum_ot[]">
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-4">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">Amount</label>
                                                        <input value="{{oth.amount}}" class="amtt tamfor tlom amntDig" ng-keypress="onlyIntegers($event)" ng-keyup="onlyIntegers($event); amnt();" ng-focus="onlyIntegers($event)" name="oamt[]" autocomplete="off">
                                                    </md-input-container>
                                                </div>
                                             </div>
                                        </div>	
                                    </div>
                                   <div class="panel panel-default mb10" ng-repeat="(key,type) in field.itemtype">
                                        <div class="panel-heading">
                                            <span>Others {{expenseViews.exp_others.length+key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20"></span></a></span>
                                        </div>
                                        <div class="panel-body">
                                         <input type="hidden" name="ido[]" value="0" />
                                            <div class="row form-group">
                                                <div class="col-sm-4">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00B">Description</label>
                                                        <input value="" name="others[]">
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-4" ng-controller="DatepickerDemoCtrl">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">Date</label>
                                                        <input type="text" name="odate[]" readonly="readonly" class="border-bottom" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" ng-model="odate" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>  
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-4 filesRow">
                                                    <input class="form-control uploadFile" placeholder="Choose File" disabled="disabled" name="ofile[]"/>
                                                    <div class="fileUpload btn btn-sm btn-info" tooltip="Upload" tooltip-placement="top">
                                                        <span class="ion ion-upload"></span>
                                                        <input type="file" class="upload uploadBtn" name="ofile[]" />
                                                    </div>
                                                </div>
                                             </div>
                                             <div class="row form-group">   
                                                <div class="col-sm-4" ng-controller="ticketDropCtrl">
                                                    <label class="selectlabel">Ticket ID</label>
                                                    <select class="form-control SlectBox" placeholder="Ticket ID" name="ticket_ot[]" ng-model="ticket_id" >
                                                        <option value="" selected="selected" style="display:none" >Select Ticket ID</option>
                                                        <option value="1">Others</option>
                                                        <option ng-repeat="ticket in firstDrop" value="{{ticket.alias}}">{{ticket.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00B">DPR Number</label>
                                                        <input value="" name="dprNum_ot[]">
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-4">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00B">Amount</label>
                                                        <input class="amtt tamfor tlom amntDig" ng-keypress="onlyIntegers($event)" ng-keyup="onlyIntegers($event);amnt()" ng-focus="onlyIntegers($event)" name="oamt[]" autocomplete="off">
                                                    </md-input-container>
                                                </div>
                                             </div>
                                        </div>	
                                    </div>
                                        <div class="col-md-4 right mt10">
                                            <input value="{{expenseViews.tot_oth_amt}}" readonly="readonly" class="form-control tlomt"  placeholder="Total Other's" name="fare_total_oth">
                                        </div>
										<a href="" class="text-info fnt-20 ml10" ng-click="addFields(field,$event)"> New Field : <span class="ion ion-plus-circled fnt-20"></span></a>
                               </div>
                               </div>
                            </div>
                    </tab>
                </tabset>
               
               <div class="row form-group"> 
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Outstanding Balance</label>
                            <input value="{{expenseViews.outstanding}}" readonly="readonly" class="nsamt">
                        </md-input-container>
                    </div>
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Total Expenses</label>
                            <input value="{{expenseViews.booked_expenses}}" readonly="readonly" name="texp" class="texp">
                        </md-input-container>
                    </div>
                    <div class="col-sm-6">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Final Amount (Total Expenses- Outstanding Balance)</label>
                            <input value="{{expenseViews.final_amount}}" readonly="readonly" class="finchamt">
                        </md-input-container>
                    </div>
               </div>
                <div class="row form-group"> 
                    <div class="col-sm-6 col-sm-offset-5 mt10">
                    	 <button type="submit" class="btn btn-info btn-sm" ng-click="sendRequest('draft')">Draft</button>
                         <button type="submit" class="btn btn-info btn-sm" ng-click="sendRequest('request')">Request</button>
                    </div>
                </div> 
		</form>
	  </div>
	</div>
</div>
<script>
setInterval(function(){$('.SlectBox').SumoSelect();
$('.forms_request').find('.SumoSelect').addClass('singleSelect');},0);
/*$(document).on("keypress keyup focus",".qnty",function (event) {    
	   $(this).val($(this).val().replace(/[^\d].+/, ""));
		if ((event.which < 48 || event.which > 57)) {
			event.preventDefault();
		}
	});
$(document).on("keypress keyup focus",".numKilo, .amntDig",function (event) {    
		$(this).val($(this).val().replace(/[^0-9\.]/g,''));
			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
				event.preventDefault();
			}
});*/
$(document).on("change",".uploadBtn",function () { 
		$(this).parents('.filesRow').find('.uploadFile').val($(this).val());
		$(this).parents('.oldfilesRow').find('.uploadFile').val($(this).val());
});
</script>