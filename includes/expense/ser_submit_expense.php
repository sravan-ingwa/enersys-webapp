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
.tab-content{padding:10px !important;}
</style>
<div class="modal-style" ng-controller="EnersysExpenseCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Submit Expenses</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body">
		<form class="form-horizontal forms_request" name="submitRequest" data-went="#/expenses" method="post" url="services/expense_tracker/service_expences_add" novalidate>
            <div class="row form-group">
            	<div class="col-sm-3">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00A">Date Of Request</label>
                        <input value="{{expAdd.dateof_request}}" readonly="readonly">
                    </md-input-container>
				</div>
                <div class="col-sm-3">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Employee ID</label>
                        <input value="{{expAdd.empid}}" readonly="readonly">
                    </md-input-container>
				</div>
                 <div class="col-sm-3">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Employee Name</label>
                        <input value="{{expAdd.employee_name}}" readonly="readonly">
                    </md-input-container>
				 </div>
              <div ng-controller="DatepickerDemoCtrl">  
                 <div class="col-sm-3">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Grade</label>
                        <input value="{{expAdd.grade}}" readonly="readonly">
                    </md-input-container>
				 </div>
                
                <div class="col-sm-3">
                    <md-input-container flex="" class="md-default-theme">
                        <label for="input_00D">Visit Start Date</label>
                        <input type="text" ng-model="Startddate" name="visitFromDate" class="" readonly="readonly" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="dateCal();open($event,'opened1')"/>
                   </md-input-container>
                </div>	
                <div class="col-sm-3">
                    <md-input-container flex="" class="md-default-theme">
                        <label for="input_00E">Visit End Date</label>
                        <input type="text" ng-model="Enddate" name="visitToDate" class="" readonly="readonly" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="dateCal();open($event,'opened2')">
                    </md-input-container>
                </div>
               </div> 
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">No.Of Days</label>
                            <input value="" id="num_nights" readonly="readonly">
                        </md-input-container>
                    </div>
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00B">Visited Place's</label>
                            <input ng-model="visitedplaces" name="placesOfVisit">
                        </md-input-container>
                    </div>
                    <div class="col-sm-3">
                        <textarea rows="2" class="form-control resize-v padding-none" name="purpose" placeholder="Purpose"></textarea>
                    </div>    
                    <div class="col-sm-3">
                        <textarea rows="2" class="form-control resize-v padding-none" name="remarks" placeholder="Remarks"></textarea>
                    </div> 
               </div>
               <!---------   DPR Details -------->
               <div class="row form-group mt10">  
                <div class="col-lg-12 dprDetails hidden">
                    <label>DPR Details :</label>
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
                        <tfoot ng-if="dprViews.dprDetails.length =='0'"><tr><td colspan="5">No Records</td></tr></tfoot>
                    </table>
                </div>
               </div>
               <tabset justified="true" class="tabs-linearrow mt10">
                 <tab>
                    <tab-heading class="active">Local Conveyance</tab-heading>
                    	<div ng-controller="addFieldsExpCtrl" class="row form-group padding-10">
                            <div class="col-sm-12">
                                <div class="row form-group" ng-repeat="field in forms">  
                               <div class="panel panel-default mb10 ajm" id="aaaa" ng-repeat="(key,type) in field.itemtype">
                                    <div class="panel-heading">
                                        <span>Local Conveyance {{key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20"></span></a></span>
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
                                                <select name="bucket[]" class="form-control selectdrop SlectBox localConvy" ng-model="bucket" ng-change="localConvy($event);">
                                                    <option value="" selected="selected">Bucket</option>
                                                    <option value="0">Secondary Transportation</option>
                                                    <option value="1">Local Conveyance</option>
                                                </select>
                                            </div>
                                            <div ng-show="bucket == '0'" ng-controller="capdropCntrl">
                                            <div class="col-sm-3">
                                                <label class="selectlabel">Capacity</label>
                                                <select class="form-control SlectBox selectdrop capChange cap" placeholder="Product Code" name="cap[]" ng-model="productcode" ng-change="capChange(productcode);" required>
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
                                            <div class="col-sm-3">
												<label class="selectlabel">Mode Of Travel</label>
                                                <select class="form-control selectdrop SlectBox" ng-model="mot_l" name="mot_l[]" >
                                                    <option value="" selected>Mode Of Travel</option>
                                                    <option ng-repeat="mot in locOfTravel" value="{{mot.name}}">{{mot.name}}</option>
                                                </select>
                                            </div>
                                            
                                            <div class="col-sm-3" ng-controller="ticketDropCtrl">
                                                <label class="selectlabel">Ticket ID</label>
                                                <select class="form-control SlectBox" placeholder="Ticket ID" name="ticket_idl[]" id="ticket_id" ng-model="ticket_id" required="required">
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
                 </tab>
                 <tab>
                    <tab-heading>Conveyance</tab-heading>
                    	<div ng-controller="addFieldsExpCtrl" class="row form-group padding-10">
                            <div class="col-sm-12">
                                <div class="row form-group" ng-repeat="field in forms">  
                                   <div class="panel panel-default mb10" ng-repeat="(key,type) in field.itemtype">
                                        <div class="panel-heading">
                                            <span>Conveyance {{key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20"></span></a></span>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row form-group">
                                                <div class="col-sm-3" ng-controller="DatepickerDemoCtrl">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">Date of Travel</label>
                                                        <input type="text" name="dot[]" readonly="readonly" class="border-bottom" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" ng-model="dot" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="true"/>  
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
                                                    <select class="form-control SlectBox" placeholder="Ticket ID" name="cticket_id[]" id="ticket_id" ng-model="ticket_id" required="required">
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
                                                <div class="col-sm-3 filesRow" ng-controller="fileUploadCtrl">
                                                	<input value="{{file_name}}" class="form-control uploadFile" placeholder="Choose File" disabled="disabled" name="motbill[]"/>
                                                    <div class="fileUpload btn btn-sm btn-info" tooltip="Upload" tooltip-placement="right">
                                                        <span class="ion ion-upload"></span>
                                                        <input type="file" class="upload uploadBtn" name="motbill[]" onchange="angular.element(this).scope().file_load_exp(this.files)"/>
                                                    </div>
                                                    <div class="mb20" ng-if="prg_shw_hde">
                                                        <md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00B">Amount</label>
                                                        <input class="amtt tamfor tcm amntDig" ng-keypress="onlyIntegers($event)" ng-keyup="onlyIntegers($event);amnt();" ng-focus="onlyIntegers($event)" name="amt[]" placeholder="Amount" autocomplete="off">
                                                    </md-input-container>
                                                </div>
                                             </div>
                                        </div>	
                                    </div>
                                    <div class="col-md-4 right mt5">
                                        <input readonly="readonly" class="form-control tcmt" placeholder="Total Conveyance" name="fare_total_con">
                                    </div>
									<a href="" class="text-info fnt-20 ml10" ng-click="addFields(field,$event)"> New Field : <span class="ion ion-plus-circled fnt-20"></span></a>
                               </div>
                            </div>
                        </div>
                 </tab>
                 <tab>
                    <tab-heading>Lodging</tab-heading>
                    	<div ng-controller="addFieldsExpCtrl" class="row form-group padding-10">
                       	   <div class="col-sm-12">
                           		<div class="row form-group" ng-repeat="field in forms">  
                               <div class="panel panel-default mb10" ng-repeat="(key,type) in field.itemtype">
                                    <div class="panel-heading">
                                        <span>Lodging {{key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20"></span></a></span>
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
                                                <select class="form-control SlectBox" placeholder="Ticket ID" name="ticket_idld[]" id="ticket_id" ng-model="ticket_id" required="required">
                                                    <option value="" selected="selected" style="display:none" >Select Ticket ID</option>
                                                    <option value="1">Others</option>
                                                    <option ng-repeat="ticket in firstDrop" value="{{ticket.alias}}">{{ticket.name}}</option>
                                                </select>
                                            </div>
                                         </div>
                                         <div class="row form-group" ng-show="stayType == 'Self'">  
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
                                            <div class="col-sm-4" ng-if="stayType == 'Reimbursement'">
                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                    <label for="input_00B">Amount</label>
                                                    <input type="number" class="amtt tamfor tlam selfamm ld" name="lamt[]" ng-keyup="amnt()" placeholder="Amount">
                                                </md-input-container>
                                            </div>
                                            <div class="col-sm-4" ng-if="stayType == 'Self'">
                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                    <label for="input_00B">Amount</label>
                                                    <input  class="amtt tamfor tlam selfamm ld" readonly="readonly" name="lamt[]" ng-keyup="amnt()" placeholder="Amount">
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
                 </tab>
                 <tab>
                    <tab-heading>Boarding</tab-heading>
                    	<div ng-controller="addFieldsExpCtrl" class="row form-group padding-10">
                        	<div class="col-sm-12">
                           		<div class="row form-group" ng-repeat="field in forms">  
                               <div class="panel panel-default mb10" ng-repeat="(key,type) in field.itemtype">
                                    <div class="panel-heading">
                                        <span>Boarding {{key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20"></span></a></span>
                                    </div>
                                    <div class="panel-body locCon" ng-controller="loczoneStateMulCntrl">
                                         <div class="row form-group">
                                            <div ng-controller="DatepickerDemoCtrl">
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00D">Visit: Start Date</label>
                                                        <input type="text" ng-model="Startddate" readonly="readonly" class="bdpd1 cddl bg-white clc" name="checkinb[]" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="true" data-ng-focus="boddateChange($event);open($event,'opened1')"/>
                                                   </md-input-container>
                                                </div>	
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00E">Visit: End Date</label>
                                                        <input type="text" ng-model="Enddate" readonly="readonly" class="bdpd2 cddl bg-white slc" name="checkoutb[]" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="true" data-ng-focus="boddateChange($event);open($event,'opened2')">
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
                                                <select class="form-control SlectBox stateChange" placeholder="State"  name="state_bo[]"  id="state" ng-model="states"  data-ng-change="state_loc(states,$event);">
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
                                                <select class="form-control SlectBox" placeholder="Ticket ID" name="ticket_bo[]" id="ticket_id" ng-model="ticket_id" required="required">
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
                                <div class="col-md-4 right mt5">
                                    <input readonly="readonly" class="form-control blamt" placeholder="Total Boarding" name="fare_total_bod">
                                </div>
							   <a href="" class="text-info fnt-20 ml10" ng-click="addFields(field,$event)"> New Field : <span class="ion ion-plus-circled fnt-20"></span></a>
                           </div>
                            </div>
                        </div>
                 </tab>
                 <tab>
                    <tab-heading>Other's</tab-heading>
                    	<div ng-controller="addFieldsExpCtrl" class="row form-group padding-10">
                        	<div class="col-sm-12">
                           		<div class="row form-group" ng-repeat="field in forms">  
                               <div class="panel panel-default mb10" ng-repeat="(key,type) in field.itemtype">
                                    <div class="panel-heading">
                                        <span>Others {{key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20"></span></a></span>
                                    </div>
                                    <div class="panel-body">
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
                                                    <input type="text" name="odate[]" readonly="readonly" class="border-bottom" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" ng-model="odate" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="true"/>  
                                                </md-input-container>
                                            </div>
                                            <div class="col-sm-4 filesRow" ng-controller="fileUploadCtrl">
                                                <input value="{{file_name}}" class="form-control uploadFile" placeholder="Choose File" disabled="disabled" name="ofile[]"/>
                                                <div class="fileUpload btn btn-sm btn-info" tooltip="Upload" tooltip-placement="right">
                                                    <span class="ion ion-upload"></span>
                                                    <input type="file" class="upload uploadBtn" name="ofile[]" onchange="angular.element(this).scope().file_load_exp(this.files)"/>
                                                </div>
                                                <div class="mb20" ng-if="prg_shw_hde">
                                                    <md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
                                                </div>
                                            </div>
                                            
                                         </div>
                                         <div class="row form-group">   
                                            <div class="col-sm-4" ng-controller="ticketDropCtrl">
                                                <label class="selectlabel">Ticket ID</label>
                                                <select class="form-control SlectBox" placeholder="Ticket ID" name="ticket_ot[]" id="ticket_id" ng-model="ticket_id" required="required">
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
                                                    <input class="amtt tamfor tlom amntDig" ng-keypress="onlyIntegers($event)" ng-keyup="onlyIntegers($event);amnt();" ng-focus="onlyIntegers($event)" name="oamt[]" autocomplete="off">
                                                </md-input-container>
                                            </div>
                                         </div>
                                    </div>	
                                </div>
                                <div class="col-md-4 right mt5">
                                    <input readonly="readonly" class="form-control tlomt"  placeholder="Total Other's" name="fare_total_oth">
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
                            <input value="{{expAdd.outstanding_bal}}" readonly="readonly" class="nsamt">
                        </md-input-container>
                    </div>
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Total Expenses</label>
                            <input readonly="readonly" name="texp" class="texp">
                        </md-input-container>
                    </div>
                    <div class="col-sm-6">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Final Amount (Total Expenses- Outstanding Balance)</label>
                            <input readonly="readonly" class="finchamt">
                        </md-input-container>
                    </div>
                </div>
               
                <div class="row form-group"> 
                    <div class="col-sm-6 col-sm-offset-5 mt10">
                    	 <button type="submit" class="btn btn-info btn-sm" ng-click="sendRequest('draft')">Draft</button>
                         <button type="submit" class="btn btn-info btn-sm" ng-click="sendRequest('sexp')">Submit Expense</button>
                    </div>
                </div> 
		</form>
	  </div>
	</div>
</div>

<script>
setInterval(function(){$('.SlectBox').SumoSelect();
$('.forms_request').find('.SumoSelect').addClass('singleSelect');},0);
</script>