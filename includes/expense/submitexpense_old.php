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
</style>
<div class="modal-style" ng-controller="EnersysExpenseCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Submit Expenses</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body">
		<form class="form-horizontal forms_add" name="modal-demo-form" action="javascript:;" novalidate>
			<div class="row form-group">
            	<div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00A">Date Of Request</label>
                        <input value="{{CurrentDate | date:'dd-MM-yyyy'}}" readonly="readonly">
                    </md-input-container>
				</div>
                
                <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Employee ID</label>
                        <input value="E00034" readonly="readonly">
                    </md-input-container>
				</div>
                
                 <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Employee Name</label>
                        <input value="MANI RAJ" readonly="readonly">
                    </md-input-container>
				 </div>
              </div>   
              <div class="row form-group" ng-controller="DatepickerDemoCtrl">  
                 <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Grade</label>
                        <input value="S2" readonly="readonly">
                    </md-input-container>
				 </div>
                
                <div class="col-sm-4">
                    <md-input-container flex="" class="md-default-theme">
                        <label for="input_00D">Visit Start Date</label>
                        <input type="text" ng-model="Startddate" name="start_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{format}}" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="dateCal('sdate','edate');open($event,'opened1')"/>
                   </md-input-container>
                </div>	
                <div class="col-sm-4">
                    <md-input-container flex="" class="md-default-theme">
                        <label for="input_00E">Visit End Date</label>
                        <input type="text" ng-model="Enddate" name="end_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="dateCal('sdate','edate');open($event,'opened2')">
                    </md-input-container>
                </div>
               </div>
               <div class="row form-group">  
                  <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">No.Of Days</label>
                        <input value="" id="num_nights" readonly="readonly">
                    </md-input-container>
				 </div>
               
                <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme">
                        <label for="input_00B">Visited Place's</label>
                        <input ng-model="visitedplaces">
                    </md-input-container>
				</div>
                <div class="col-sm-4">
                	<textarea rows="2" class="form-control resize-v" placeholder="Purpose"></textarea>
                </div>   
               </div>
               <div class="col-sm-12">
                   <div ng-controller="addFieldsCtrl">
                   <div class="row form-group" ng-repeat="field in forms">  
                       <label>Conveyance :</label>
                       <a href="" class="text-info" ng-click="addFields(field)">
                          <span class="ion ion-plus-circled"></span>
                          New Field
                       </a>
                       <div class="panel panel-default">
                            <table class="table table-condensed" >
                                <thead>
                                <tr><th>Date of travel</th><th>Mode of travel</th><th>From</th><th>To</th><th>Amount</th><th>Files</th><th>Option</th></tr>
                                </thead>
                                    <tbody class="tbform" ng-repeat="(key,type) in field.itemtype">
                                            <td ng-controller="DatepickerDemoCtrl">                    
                                                <input type="text" ng-model="startdate" class="form-control datepicker border-bottom " placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-model="startdate" is-open="opened" min-date="minDate" max-date="'2025-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>                                              
                                            </td>
                                            <td><select class="form-control" tabindex="2" required="required" name="mot[]" id="mot">
                                                    <option value="0">Mode of travel</option>
                                                    <option value="ACT">ACT</option>
                                                    <option value="AIR">Air</option>
                                                    <option value="Train 2nd AC">Train 2nd AC</option>
                                                    <option value="Train 3 tier">Train 3 tier</option>
                                                    <option value="Train Sleeper">Train Sleeper</option>
                                                    <option value="Volvo AC Bus">Volvo AC Bus</option>
                                                    <option value="Non-AC Bus">Non-AC Bus</option>
                                                    <option value="Own Vehicle">Own Vehicle</option>
                                                    <option value="Cab">Cab</option>
                                                    <option value="Auto">Auto</option>
                                                    <option value="Local Train">Local Train</option>
                                                    <option value="Any Public Transport">Any Public Transport</option>
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control" name="from" placeholder="From"></td>
                                            <td><input type="text" class="form-control" name="to" placeholder="To"></td>
                                            <td><input type="text" class="form-control" ng-model="conAmount" name="amount" placeholder="Amount"></td>
                                            <td>
                                            <label for="fileToUpload" class="btn btn-xs btn-info"><i class="ion ion-upload"></i>Upload</label>
                                            <input type="hidden" class="form-control" name="motbill[]" value="0">
                                            
                                            <input type="file" name="fileToUpload[]" class="fileUpload">
                                           <!--<input id="uploadFile" placeholder="Choose File" disabled="disabled" />
                                            <div class="fileUpload btn btn-primary">
                                                <span>Upload</span>
                                                <input id="uploadBtn" type="file" class="upload uploadBtn" />
                                            </div>-->

                                            <!--<input type="hidden" class="form-control" name="motbill[]" value="0">
                                            <input type="file" class="form-control" name="motbill[]">-->
                                            </td>
                                            <td><a href="" ng-click="removeExp(key,field)" class="text-info"><span class="ion ion-android-delete fnt-20"></span></a></td>
                                        </tr>
                                   </tbody>
                                </table>
                            <!-- #end data table -->	
                        </div>
                        <div class="col-md-4 mt10 right">
                            <input type="text" class="form-control" readonly="readonly" ng-model="conAmount" placeholder="Total Conveyance">
                        </div>
                   </div>
                   </div>
                   <div ng-controller="addFieldsCtrl">
                   <div class="row form-group" ng-repeat="field in forms">  
                       <label>Local Conveyance :</label>
                       <a href="" class="text-info" ng-click="addFields(field)">
                          <span class="ion ion-plus-circled"></span>
                          New Field
                       </a>
                       <div class="panel panel-default">
                            <table class="table table-condensed" >
                                <thead>
                                <tr><th>Date of travel</th><th>Mode of travel</th><th>From</th><th>To</th><th>Amount</th><th>Option</th></tr>
                                </thead>
                                    <tbody>
                                        <tr class="tbform" ng-repeat="(key,type) in field.itemtype">
                                            <td ng-controller="DatepickerDemoCtrl">                    
                                                <input type="text" ng-model="startdate" class="form-control datepicker border-bottom" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-model="startdate" is-open="opened" min-date="minDate" max-date="'2025-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>                                              
                                            </td>
                                            <td><select class="form-control" tabindex="2" required="required" name="mot[]" id="mot">
                                                    <option value="0">Mode of travel</option>
                                                    <option value="ACT">ACT</option>
                                                    <option value="AIR">Air</option>
                                                    <option value="Train 2nd AC">Train 2nd AC</option>
                                                    <option value="Train 3 tier">Train 3 tier</option>
                                                    <option value="Train Sleeper">Train Sleeper</option>
                                                    <option value="Volvo AC Bus">Volvo AC Bus</option>
                                                    <option value="Non-AC Bus">Non-AC Bus</option>
                                                    <option value="Own Vehicle">Own Vehicle</option>
                                                    <option value="Cab">Cab</option>
                                                    <option value="Auto">Auto</option>
                                                    <option value="Local Train">Local Train</option>
                                                    <option value="Any Public Transport">Any Public Transport</option>
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control" name="from" placeholder="From"></td>
                                            <td><input type="text" class="form-control" name="to" placeholder="To"></td>
                                            <td><input type="text" class="form-control" name="amount" placeholder="Amount"></td>
                                            <td><a href="" ng-click="removeExp(key,field)" class="text-info"><span class="ion ion-android-delete fnt-20"></span></a></td>
                                        </tr>
                                   </tbody>
                                </table>
                            <!-- #end data table -->	
                        </div>
                        <div class="col-md-4 mt10 right">
                            <input value="" readonly="readonly" class="form-control" placeholder="Total Local Conveyance">
                        </div>
                   </div>
                   </div>
                   <div ng-controller="addFieldsCtrl">
                   <div class="row form-group" ng-repeat="field in forms">  
                       <label>Lodging :</label>
                       <a href="" class="text-info" ng-click="addFields(field)">
                          <span class="ion ion-plus-circled"></span>
                          New Field
                       </a>
                       <div class="panel panel-default">
                            <table class="table table-condensed" >
                                <thead>
                                <tr><th>Type of Stay</th><th>Check in Date</th><th>Check out Date</th><th>Hotel Name</th><th>Amount</th><th>Files</th><th>Option</th></tr>
                                </thead>
                                    <tbody>
                                        <tr class="tbform" ng-repeat="(key,type) in field.itemtype">
                                            <td>
                                                <select class="form-control" tabindex="1" required="required">
                                                    <option value="0">Reimbursement</option>
                                                    <option value="self">Self</option>
                                                </select>
                                            </td>
                                            <td ng-controller="DatepickerDemoCtrl">                    
                                                <input type="text" ng-model="stratdate" class="form-control datepicker border-bottom " placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" is-open="opened" min-date="minDate" max-date="'2025-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>                                              
                                            </td>
                                            <td ng-controller="DatepickerDemoCtrl">                    
                                                <input type="text" ng-model="enddate" class="form-control datepicker border-bottom " placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" is-open="opened" min-date="minDate" max-date="'2025-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>                                              
                                            </td>
                                            <td><input type="text" class="form-control" name="hotelname" placeholder="Hotel Name"></td>
                                            <td><input type="text" class="form-control" name="amount" placeholder="Amount"></td>
                                            <td><input type="hidden" class="form-control" name="motbill[]" value="0"><input type="file" class="form-control" name="motbill[]"></td>
                                            <td><a href="" ng-click="removeExp(key,field)" class="text-info"><span class="ion ion-android-delete fnt-20"></span></a></td>
                                        </tr>
                                   </tbody>
                                </table>
                            <!-- #end data table -->	
                        </div>
                        <div class="col-md-4 mt10 right">
                            <input value="" readonly="readonly" class="form-control" placeholder="Total Lodging">
                        </div>
                   </div>
                   </div>
                   <div ng-controller="addFieldsCtrl">
                   <div class="row form-group" ng-repeat="field in forms">  
                       <label>Boarding :</label>
                       <a href="" class="text-info" ng-click="addFields(field)">
                          <span class="ion ion-plus-circled"></span>
                          New Field
                       </a>
                       <div class="panel panel-default">
                            <table class="table table-condensed" >
                                <thead>
                                <tr><th>Check in Date</th><th>Check out Date</th><th>State</th><th>Amount</th><th>Option</th></tr>
                                </thead>
                                    <tbody>
                                        <tr class="tbform" ng-repeat="(key,type) in field.itemtype">
                                            <td ng-controller="DatepickerDemoCtrl">                    
                                                <input type="text" ng-model="stratdate" class="form-control datepicker border-bottom " placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>                                              
                                            </td>
                                            <td ng-controller="DatepickerDemoCtrl">                    
                                                <input type="text" ng-model="enddate" class="form-control datepicker border-bottom " placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>                                              
                                            </td>
                                            <td><select class="form-control">
                                                    <option value="" selected="selected">Slect State</option>
                                                    <option value="0">A+</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control" name="amount" placeholder="Amount"></td>
                                            <td><a href="" ng-click="removeExp(key,field)" class="text-info"><span class="ion ion-android-delete fnt-20"></span></a></td>
                                        </tr>
                                   </tbody>
                                </table>
                            <!-- #end data table -->	
                        </div>
                        <div class="col-md-4 mt10 right">
                            <input value="" readonly="readonly" class="form-control" placeholder="Total Boarding">
                        </div>
                   </div>
                   </div>
                   <div ng-controller="addFieldsCtrl">
                   <div class="row form-group" ng-repeat="field in forms">  
                       <label>Others :</label>
                       <a href="" class="text-info" ng-click="addFields(field)">
                          <span class="ion ion-plus-circled"></span>
                          New Field
                       </a>
                       <div class="panel panel-default">
                            <table class="table table-condensed" >
                                <thead>
                                <tr><th>Description</th><th>Amount</th><th>Date</th><th>Files</th><th>Option</th></tr>
                                </thead>
                                <tbody>
                                    <tr class="tbform" ng-repeat="(key,type) in field.itemtype">
                                        <td><input type="text" class="form-control" name="description" placeholder="Description"></td>
                                        <td><input type="text" class="form-control" name="amount" placeholder="Amount"></td>
                                        <td ng-controller="DatepickerDemoCtrl">                    
                                            <input type="text" ng-model="date" class="form-control datepicker border-bottom " placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>                                              
                                        </td>
                                        <td><input type="hidden" class="form-control" name="motbill[]" value="0"><input type="file" class="form-control" name="motbill[]"></td>
                                        <td><a href="" ng-click="removeExp(key,field)" class="text-info"><span class="ion ion-android-delete fnt-20"></span></a></td>
                                    </tr>
                               </tbody>
                            </table>
                            <!-- #end data table -->	
                        </div>
                        <div class="col-md-4 mt10 right">
                            <input value="" readonly="readonly" class="form-control" placeholder="Others's Total">
                        </div>
                   </div>
                   </div>
               </div>
               <!-----------------------------Service------------------------------->
               <div class="col-sm-12" ng-if="">
               <div ng-controller="addFieldsCtrl">
                   <div class="row form-group" ng-repeat="field in forms">  
                       <label>Local Conveyance :</label>
                       <a href="" class="text-info" ng-click="addFields(field)">
                          <span class="ion ion-plus-circled"></span>
                          New Field
                       </a>
                       <div class="panel panel-default mb10" ng-repeat="(key,type) in field.itemtype">
                            <div class="panel-heading">
                                <span>Local Conveyance {{key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20"></span></a></span>
                            </div>
                            <div class="panel-body">
                                <div class="row form-group" ng-controller="lczoneStateMulCntrl">
                                    <div class="col-sm-3">
                                        <label class="selectlabel">Zone</label>
                                        <select multiple="multiple" placeholder="Zone" name="zone_alias_lc[]" class="testSelAll2 form-control" ng-model="zones" ng-init="dep_drop(singleViews.zone_alias)" data-ng-change="zone_lc(zones)" required="required">
                                            <option ng-repeat="zone in firstDrop" value="{{zone.alias}}">{{zone.name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="selectlabel">State</label>
                                        <select class="form-control testSelAll2" placeholder="State" name="state_alias_lc[]" ng-model="states" multiple="multiple" data-ng-change="state_lc(states)" required="required">
                                            <option ng-repeat="state in secondDrop" value="{{state.alias}}">{{state.name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="selectlabel">District</label>
                                        <select class="form-control testSelAll2" placeholder="District" name="district_alias_lc[]" ng-model="districts" required="required" multiple="multiple">
                                            <option ng-repeat="district in thirdDrop" value="{{district.alias}}">{{district.name}}</option>
                                        </select>
                                    </div>
                                     <div class="col-sm-3">
                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                            <label for="input_00B">Area</label>
                                            <input value="Plain Area" readonly="readonly">
                                        </md-input-container>
                                     </div>
                                 </div>
                                 <div class="row form-group">
                                    <div class="col-sm-3">
                                        <select name="bucket" class="form-control selectdrop" ng-model="bucket">
                                        	<option value="" selected="selected">Bucket</option>
                                            <option value="0">Secondary Transportation</option>
                                            <option value="1">Local Conveyance</option>
                                        </select>
                                    </div>
                                    <div ng-if="bucket == '0'">
                                    <div class="col-sm-3" ng-controller="productdropCntrl">
                                        <label class="selectlabel">Capacity</label>
                                        <select class="form-control testSelAll2 selectdrop" placeholder="Product Code" name="product_alias[]" ng-model="productcode" required multiple="multiple">
                                            <option ng-repeat="product in firstDrop" value="{{product.alias}}">{{product.name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                            <label for="input_00B">Weight of cell</label>
                                            <input value="Weight of cell" placeholder="Weight of cell" readonly="readonly">
                                        </md-input-container>
                                    </div>
                                    <div class="col-sm-3">
                                        <md-input-container flex="" class="md-default-theme">
                                            <label for="input_00B">Quantity</label>
                                            <input value="">
                                        </md-input-container>
                                    </div>
                                 
                                   <div class="col-sm-3">
                                        <md-input-container flex="" class="md-default-theme">
                                            <label for="input_00B">No.of Kilometers</label>
                                            <input value="">
                                        </md-input-container>
                                    </div>
                                    <div class="col-sm-3">
                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                            <label for="input_00B">Amount Appilicable </label>
                                            <input value="Amount Appilicable" readonly="readonly">
                                        </md-input-container>
                                    </div>
                                    </div>
                                    <div class="col-sm-3" ng-controller="DatepickerDemoCtrl">
                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                            <label for="input_00B">Date of Travel</label>
                                            <input type="text" ng-model="startdate" class="datepicker border-bottom" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-model="dt" is-open="opened" min-date="minDate" max-date="'2025-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>  
                                        </md-input-container>
                                    </div>
                                    <div class="col-sm-3">
                                        <md-input-container flex="" class="md-default-theme">
                                            <label for="input_00B">From</label>
                                            <input value="">
                                        </md-input-container>
                                    </div>
                                    <div class="col-sm-3">
                                        <md-input-container flex="" class="md-default-theme">
                                            <label for="input_00B">To</label>
                                            <input value="">
                                        </md-input-container>
                                    </div>
                                    <div class="col-sm-3">
                                        <select name="mot" class="form-control selectdrop" ng-model="mot">
                                        	<option value="" selected="selected">Mode Of Travel</option>
                                            <option value="0">Own Vehicle</option>
                                            <option value="1">Cab</option>
                                            <option value="2">Auto</option>
                                            <option value="3">Local Train</option>
                                            <option value="4">Any Public Transport</option>
                                        </select>
                                    </div>
                                 	
                                    <div class="col-sm-3">
                                        <label class="selectlabel">Ticket ID</label>
                                        <select class="form-control testSelAll2" placeholder="Ticket ID" name="ticket_id[]" id="ticket_id" ng-model="ticket_id" multiple="multiple" required="required">
                                            <option ng-repeat="ticket in firstDrop" value="{{ticket.alias}}">{{ticket.name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <md-input-container flex="" class="md-default-theme">
                                            <label for="input_00B">DPR Number</label>
                                            <input value="">
                                        </md-input-container>
                                    </div>
                                 	<div class="col-sm-3">
                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                            <label for="input_00B">Amount</label>
                                            <input value="Amount" readonly="readonly">
                                        </md-input-container>
                                    </div>
                                 </div>
                            </div>	
                        </div>
                        <div class="col-md-4 right">
                            <input value="" readonly="readonly" class="form-control" placeholder="Total Local Conveyance">
                        </div>
                   </div>
                   </div>
                   <div ng-controller="addFieldsCtrl">
                   <div class="row form-group" ng-repeat="field in forms">  
                       <label>Conveyance :</label>
                       <a href="" class="text-info" ng-click="addFields(field)"> <span class="ion ion-plus-circled"></span>New Field</a>
                       <div class="panel panel-default mb10" ng-repeat="(key,type) in field.itemtype">
                            <div class="panel-heading">
                                <span>Conveyance {{key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20"></span></a></span>
                            </div>
                            <div class="panel-body">
                                <div class="row form-group">
                                    <div class="col-sm-3" ng-controller="DatepickerDemoCtrl">
                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                            <label for="input_00B">Date of Travel</label>
                                            <input type="text" ng-model="startdate" class="datepicker border-bottom" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-model="dt" is-open="opened" min-date="minDate" max-date="'2025-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>  
                                        </md-input-container>
                                    </div>
                                    <div class="col-sm-3">
                                        <select name="mot" class="form-control selectdrop" ng-model="mot">
                                        	<option value="" selected="selected">Mode Of Travel</option>
                                            <option value="0">Own Vehicle</option>
                                            <option value="1">Cab</option>
                                            <option value="2">Auto</option>
                                            <option value="3">Local Train</option>
                                            <option value="4">Any Public Transport</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <md-input-container flex="" class="md-default-theme">
                                            <label for="input_00B">From</label>
                                            <input value="">
                                        </md-input-container>
                                    </div>
                                    <div class="col-sm-3">
                                        <md-input-container flex="" class="md-default-theme">
                                            <label for="input_00B">To</label>
                                            <input value="">
                                        </md-input-container>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="selectlabel">Ticket ID</label>
                                        <select class="form-control testSelAll2" placeholder="Ticket ID" name="ticket_id[]" id="ticket_id" ng-model="ticket_id" multiple="multiple" required="required">
                                            <option ng-repeat="ticket in firstDrop" value="{{ticket.alias}}">{{ticket.name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <md-input-container flex="" class="md-default-theme">
                                            <label for="input_00B">DPR Number</label>
                                            <input value="">
                                        </md-input-container>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="upload-file">
                                            <label class="selectlabel">Files</label>
                                            <input type="file" name="moc_file" class="ng-pristine ng-valid md-input ng-touched" id="input_00P" tabindex="0" aria-invalid="false">
                                        </div>
                                    </div> 
                                    <div class="col-sm-3">
                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                            <label for="input_00B">Amount</label>
                                            <input value="Amount">
                                        </md-input-container>
                                    </div>
                                 </div>
                            </div>	
                        </div>
                        <div class="col-md-4 right">
                            <input value="" readonly="readonly" class="form-control" placeholder="Total Conveyance">
                        </div>
                   </div>
                   </div>
                   
                   
                   
                   <div ng-controller="addFieldsCtrl">
                   <div class="row form-group" ng-repeat="field in forms">  
                       <label>Lodging :</label>
                       <a href="" class="text-info" ng-click="addFields(field)">
                          <span class="ion ion-plus-circled"></span>
                          New Field
                       </a>
                       <div class="panel panel-default mb10" ng-repeat="(key,type) in field.itemtype">
                            <div class="panel-heading">
                                <span>Lodging {{key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20"></span></a></span>
                            </div>
                            <div class="panel-body"  ng-controller="lodzoneStateMulCntrl">
                                 <div class="row form-group">
                                	<div ng-controller="DatepickerDemoCtrl">
                                        <div class="col-sm-3">
                                            <md-input-container flex="" class="md-default-theme">
                                                <label for="input_00D">Check in Date</label>
                                                <input type="text" ng-model="Startddate" name="start_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="dateCal('sdate','edate');"/>
                                           </md-input-container>
                                        </div>	
                                        <div class="col-sm-3">
                                            <md-input-container flex="" class="md-default-theme">
                                                <label for="input_00E">Check out Date</label>
                                                <input type="text" ng-model="Enddate" name="end_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="dateCal('sdate','edate');">
                                            </md-input-container>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="selectlabel">Zone</label>
                                        <select multiple="multiple" placeholder="Zone" name="zone_alias_ld[]" class="testSelAll2 form-control" ng-model="zones"  data-ng-change="zone_ld(zones)" required="required">
                                            <option ng-repeat="zone in firstDrop" value="{{zone.alias}}">{{zone.name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="selectlabel">State</label>
                                        <select class="form-control testSelAll2" placeholder="State" name="state_alias_ld[]" id="state" ng-model="states" multiple="multiple" data-ng-change="state_ld(states)" required="required">
                                            <option ng-repeat="state in secondDrop" value="{{state.alias}}">{{state.name}}</option>
                                        </select>
                                    </div>
                                 </div>
                                 <div class="row form-group">   
                                    <div class="col-sm-3">
                                        <label class="selectlabel">District</label>
                                        <select class="form-control testSelAll2" placeholder="District" name="district_alias_ld[]" id="district" ng-model="districts" required="required" multiple="multiple">
                                            <option ng-repeat="district in thirdDrop" value="{{district.alias}}">{{district.name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <md-input-container flex="" class="md-default-theme">
                                            <label for="input_00B">Hotel Name</label>
                                            <input value="">
                                        </md-input-container>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="selectlabel">Ticket ID</label>
                                        <select class="form-control testSelAll2" placeholder="Ticket ID" name="ticket_id[]" id="ticket_id" ng-model="ticket_id" multiple="multiple" required="required">
                                            <option ng-repeat="ticket in firstDrop" value="{{ticket.alias}}">{{ticket.name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <md-input-container flex="" class="md-default-theme">
                                            <label for="input_00B">DPR Number</label>
                                            <input value="">
                                        </md-input-container>
                                    </div>
                                 </div>
                                 <div class="row form-group">
                                 	<div class="col-sm-3">
                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                            <label for="input_00B">Amount</label>
                                            <input value="Amount" readonly="readonly">
                                        </md-input-container>
                                    </div>
                                 </div>
                            </div>	
                        </div>
                        <div class="col-md-4 right">
                            <input value="" readonly="readonly" class="form-control" placeholder="Total Lodging">
                        </div>
                   </div>
                   </div>
                   
                   <div ng-controller="addFieldsCtrl">
                   <div class="row form-group" ng-repeat="field in forms">  
                       <label>Boarding :</label>
                       <a href="" class="text-info" ng-click="addFields(field)">
                          <span class="ion ion-plus-circled"></span>
                          New Field
                       </a>
                       <div class="panel panel-default mb10" ng-repeat="(key,type) in field.itemtype">
                            <div class="panel-heading">
                                <span>Boarding {{key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20"></span></a></span>
                            </div>
                            <div class="panel-body" ng-controller="borzoneStateMulCntrl">
                                 <div class="row form-group">
                                	<div ng-controller="DatepickerDemoCtrl">
                                        <div class="col-sm-3">
                                            <md-input-container flex="" class="md-default-theme">
                                                <label for="input_00D">Check in Date</label>
                                                <input type="text" ng-model="Startddate" name="start_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="dateCal('sdate','edate');"/>
                                           </md-input-container>
                                        </div>	
                                        <div class="col-sm-3">
                                            <md-input-container flex="" class="md-default-theme">
                                                <label for="input_00E">Check out Date</label>
                                                <input type="text" ng-model="Enddate" name="end_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="dateCal('sdate','edate');">
                                            </md-input-container>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="selectlabel">Zone</label>
                                        <select multiple="multiple" placeholder="Zone" name="zone_alias_bd[]" class="testSelAll2 form-control" ng-model="zones"  data-ng-change="zone_bd(zones)" required="required">
                                            <option ng-repeat="zone in firstDrop" value="{{zone.alias}}">{{zone.name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="selectlabel">State</label>
                                        <select class="form-control testSelAll2" placeholder="State" name="state_alias_bd[]" id="state" ng-model="states" multiple="multiple" data-ng-change="state_bd(states)" required="required">
                                            <option ng-repeat="state in secondDrop" value="{{state.alias}}">{{state.name}}</option>
                                        </select>
                                    </div>
                                 </div>
                                 <div class="row form-group">   
                                    <div class="col-sm-3">
                                        <label class="selectlabel">District</label>
                                        <select class="form-control testSelAll2" placeholder="District" name="district_alias_bd[]" id="district" ng-model="districts" required="required" multiple="multiple">
                                            <option ng-repeat="district in thirdDrop" value="{{district.alias}}">{{district.name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="selectlabel">Ticket ID</label>
                                        <select class="form-control testSelAll2" placeholder="Ticket ID" name="ticket_id[]" id="ticket_id" ng-model="ticket_id" multiple="multiple" required="required">
                                            <option ng-repeat="ticket in firstDrop" value="{{ticket.alias}}">{{ticket.name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <md-input-container flex="" class="md-default-theme">
                                            <label for="input_00B">DPR Number</label>
                                            <input value="">
                                        </md-input-container>
                                    </div>
                                    <div class="col-sm-3">
                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                            <label for="input_00B">Amount</label>
                                            <input value="Amount" readonly="readonly">
                                        </md-input-container>
                                    </div>
                                 </div>
                            </div>	
                        </div>
                        <div class="col-md-4 right">
                            <input value="" readonly="readonly" class="form-control" placeholder="Total Boarding">
                        </div>
                   </div>
                   </div>
                   
                   <div ng-controller="addFieldsCtrl">
                   <div class="row form-group" ng-repeat="field in forms">  
                       <label>Other's :</label>
                       <a href="" class="text-info" ng-click="addFields(field)"> <span class="ion ion-plus-circled"></span>New Field</a>
                       <div class="panel panel-default mb10" ng-repeat="(key,type) in field.itemtype">
                            <div class="panel-heading">
                                <span>Others {{key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20"></span></a></span>
                            </div>
                            <div class="panel-body">
                                <div class="row form-group">
                                    <div class="col-sm-4">
                                        <md-input-container flex="" class="md-default-theme">
                                            <label for="input_00B">Description</label>
                                            <input value="">
                                        </md-input-container>
                                    </div>
                                    <div class="col-sm-4" ng-controller="DatepickerDemoCtrl">
                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                            <label for="input_00B">Date</label>
                                            <input type="text" ng-model="startdate" class="datepicker border-bottom" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-model="dt" is-open="opened" min-date="minDate" max-date="'2025-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>  
                                        </md-input-container>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="upload-file">
                                            <label class="selectlabel">Files</label>
                                            <input type="file" name="moc_file" class="ng-pristine ng-valid md-input ng-touched" id="input_00P" tabindex="0" aria-invalid="false">
                                        </div>
                                    </div> 
                                 </div>
                                 <div class="row form-group">   
                                    <div class="col-sm-4">
                                        <label class="selectlabel">Ticket ID</label>
                                        <select class="form-control testSelAll2" placeholder="Ticket ID" name="ticket_id[]" id="ticket_id" ng-model="ticket_id" multiple="multiple" required="required">
                                            <option ng-repeat="ticket in firstDrop" value="{{ticket.alias}}">{{ticket.name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <md-input-container flex="" class="md-default-theme">
                                            <label for="input_00B">DPR Number</label>
                                            <input value="">
                                        </md-input-container>
                                    </div>
                                    <div class="col-sm-4">
                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                            <label for="input_00B">Amount</label>
                                            <input value="Amount">
                                        </md-input-container>
                                    </div>
                                 </div>
                            </div>	
                        </div>
                        <div class="col-md-4 right">
                            <input value="" readonly="readonly" class="form-control" placeholder="Total Other's">
                        </div>
                   </div>
                   </div>
               </div>
               
               <div class="row form-group"> 
               		<div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Outstanding Balance</label>
                            <input value="5281" readonly="readonly">
                        </md-input-container>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Total Expenses</label>
                            <input value="5000" readonly="readonly">
                        </md-input-container>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Final Amount (Total Expenses- Outstanding Balance)</label>
                            <input value="5000" readonly="readonly">
                        </md-input-container>
                    </div>
               </div>
               <div class="row form-group"> 
                    <div class="col-sm-4">
                        <textarea rows="2" class="form-control resize-v" placeholder="Remarks"></textarea>
                    </div>
                </div>
               
                <div class="row form-group"> 
                    <div class="col-sm-6 col-sm-offset-5 mt10">
                    	 <button class="btn btn-info btn-sm">Draft</button>
                         <button class="btn btn-info btn-sm">Submit Expense</button>
                    </div>
                </div> 
			</div>
		</form>
	</div>
</div>

<script>
setInterval(function(){$('.testSelAll2').SumoSelect({selectAll: true});
$('.forms_add').find('.SumoSelect').addClass('singleSelect');},0);
</script>