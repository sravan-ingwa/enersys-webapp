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
.delLoc{margin-top: -15px; padding: 8px;color: #fff;}
.upload-file {border-bottom: 1px solid rgba(0,0,0,0.12); padding-top: 9px;}
.tab-content{padding:10px !important;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
</style>
<div class="modal-style" ng-controller="EnersysExpenseCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Submit Expenses</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body">
		<form class="form-horizontal forms_request" name="submitRequest" data-went="#/expenses" method="post" url="services/expense_tracker/others_expences_add" novalidate>
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
                        <input type="text" ng-model="Startddate" readonly="readonly" name="visitFromDate" class="" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="dateCal();open($event,'opened1')"/>
                   </md-input-container>
                </div>	
                <div class="col-sm-3">
                    <md-input-container flex="" class="md-default-theme">
                        <label for="input_00E">Visit End Date</label>
                        <input type="text" ng-model="Enddate" readonly="readonly" name="visitToDate" class="" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="dateCal();open($event,'opened2')">
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
                	<textarea rows="2" class="form-control resize-v padding-none" placeholder="Purpose" name="purpose"></textarea>
                </div>  
                <div class="col-sm-3">
                    <textarea rows="2" class="form-control resize-v padding-none" name="remarks" placeholder="Remarks"></textarea>
                </div>   
               </div>
               
               <tabset justified="true" class="tabs-linearrow mt10">
                     <tab>
                      	<tab-heading class="active">Conveyance</tab-heading>
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
                                                    <input value="" name="from[]">
                                                </md-input-container>
                                            </div>
                                            <div class="col-sm-3">
                                                <md-input-container flex="" class="md-default-theme">
                                                    <label for="input_00B">To</label>
                                                    <input value=""  name="to[]">
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
                                                    <input value="" class="amtt tamfor tcm amntDig"  name="amt[]" ng-keypress="onlyIntegers($event)" ng-keyup="amnt(); onlyIntegers($event)" ng-focus="onlyIntegers($event)" autocomplete="off">
                                                </md-input-container>
                                            </div>
                                         </div>
                                    </div>	
                                </div>
                                <div class="col-md-4 right mt5">
                                    <input readonly="readonly" name="fare_total_con" class="form-control tcmt" placeholder="Total Conveyance">
                                </div>
								<a href="" class="text-info fnt-20 ml10" ng-click="addFields(field,$event)"> New Field : <span class="ion ion-plus-circled fnt-20"></span></a>
                           </div>
                           	</div>
                          </div>
                     </tab>
                     <tab>
                     	<tab-heading>Local Conveyance</tab-heading>
                           <div ng-controller="addFieldsExpCtrl" class="row form-group padding-10">
                               <div class="col-sm-12">
                                   <div class="row form-group" ng-repeat="field in forms">  
                                   <div class="panel panel-default mb10" ng-repeat="(key,type) in field.itemtype">
                                        <div class="panel-heading">
                                            <span>Local Conveyance {{key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20"></span></a></span>
                                        </div>
                                        <div class="panel-body">
                                             <div class="row form-group">
                                                <div class="col-sm-3" ng-controller="DatepickerDemoCtrl">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00B">Date of Travel</label>
                                                        <input type="text" name="dot_l[]" readonly="readonly" class="border-bottom" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" ng-model="dot_l" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="true"/>  
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-3">
													<label class="selectlabel">Mode Of Travel</label>
                                                     <select  class="form-control selectdrop SlectBox" ng-model="mot" name="mot_l[]" >
                                                        <option value="" selected>Mode Of Travel</option>
                                                        <option ng-repeat="mot in locOfTravel" value="{{mot.name}}">{{mot.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00B">From</label>
                                                        <input value="" name="from_l[]">
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00B">To</label>
                                                        <input value="" name="to_l[]">
                                                    </md-input-container>
                                                </div>
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00B">Amount</label>
                                                        <input value="" name="amt_l[]"  class="amtt tamfor ttcm amntDig" ng-keypress="onlyIntegers($event)" ng-keyup="amnt(); onlyIntegers($event)" ng-focus="onlyIntegers($event)" autocomplete="off">
                                                    </md-input-container>
                                                </div>
                                             </div>
                                        </div>	
                                    </div>
                                    <div class="col-md-4 right mt5">
                                        <input readonly="readonly" class="form-control ttcmt" placeholder="Total Local Conveyance" name="fare_total_loc">
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
                                    <div class="panel-body lodGing_amnt" ng-controller="othersExpenseeditCtrl">
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
                                                        <input type="text" name="checkin[]" readonly="readonly"  ng-model="Startddate" class="checkin" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="true" data-ng-focus="loadvalto($event);open($event,'opened1')"/>
                                                   </md-input-container>
                                                </div>	
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00E">Check out Date</label>
                                                        <input type="text" name="checkout[]" readonly="readonly" ng-model="Enddate" class="checkout" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="true" data-ng-focus="loadvalto($event);open($event,'opened2')"/>
                                                    </md-input-container>
                                                </div>
                                             </div>
                                             <div class="col-sm-3" ng-if="stayType == 'Reimbursement'">
                                                <md-input-container flex="" class="md-default-theme">
                                                    <label for="input_00B">Hotel Name</label>
                                                    <input value="" name="hotelName[]" >
                                                </md-input-container>
                                            </div>
                                            <div class="col-sm-3" ng-if="stayType == 'Self'">
												<label class="selectlabel">State</label>
                                                <select class="form-control selectdrop SlectBox lodvalto htname" ng-change="loadvalto($event);" ng-model="state"  name="hotelName[]" >
                                                    <option value="" selected="selected">State</option>
                                                    <option value="a1">A+</option>
                                                    <option value="a">A</option>
                                                    <option value="b">B</option>
                                                    <option value="c">C</option>
                                                </select>
                                            </div>
                                         </div>
                                         <div class="row form-group">
                                            <div class="col-sm-3 filesRow" ng-controller="fileUploadCtrl">
                                            <input value="{{file_name}}" class="form-control uploadFile" placeholder="Choose File" disabled="disabled" name="lfile[]"/>
                                                <div class="fileUpload btn btn-sm btn-info" tooltip="Upload" tooltip-placement="right">
                                                    <span class="ion ion-upload"></span>
                                                    <input type="file" class="upload uploadBtn" name="lfile[]" onchange="angular.element(this).scope().file_load_exp(this.files)"/>
                                                </div>
                                                <div class="mb20" ng-if="prg_shw_hde">
                                                    <md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                    <label for="input_00B">Amount</label>
                                                    <input value="" name="lamt[]" class="amtt tamfor tlam selfamm amntDig" ng-keypress="onlyIntegers($event)" ng-keyup="amnt(); onlyIntegers($event)" ng-focus="onlyIntegers($event)" autocomplete="off">
                                                </md-input-container>
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
                     </tab>
                     <tab>
                     	<tab-heading>Others's</tab-heading>
                       	 <div ng-controller="addFieldsExpCtrl" class="row form-group padding-10">
                        	<div class="col-sm-12">
                           <div class="row form-group" ng-repeat="field in forms">  
                               <div class="panel panel-default mb10" ng-repeat="(key,type) in field.itemtype">
                                    <div class="panel-heading">
                                        <span>Others {{key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20"></span></a></span>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row form-group">
                                            <div class="col-sm-3">
                                                <md-input-container flex="" class="md-default-theme">
                                                    <label for="input_00B">Description</label>
                                                    <input value=""  name="others[]">
                                                </md-input-container>
                                            </div>
                                            <div class="col-sm-3" ng-controller="DatepickerDemoCtrl">
                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                    <label for="input_00B">Date</label>
                                                    <input type="text" name="odate[]" readonly="readonly" class="border-bottom" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" ng-model="odate" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="true"/>  
                                                </md-input-container>
                                            </div>
                                            <div class="col-sm-3 filesRow" ng-controller="fileUploadCtrl">
                                            <input value="{{file_name}}" class="form-control uploadFile" placeholder="Choose File" disabled="disabled" name="ofile[]"/>
                                                <div class="fileUpload btn btn-sm btn-info" tooltip="Upload" tooltip-placement="right">
                                                    <span class="ion ion-upload"></span>
                                                    <input type="file" class="upload uploadBtn" name="ofile[]" onchange="angular.element(this).scope().file_load_exp(this.files)"/>
                                                </div>
                                                <div class="mb20" ng-if="prg_shw_hde">
                                                    <md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <md-input-container flex="" class="md-default-theme">
                                                    <label for="input_00B">Amount</label>
                                                    <input value="" name="oamt[]" class="amtt tamfor tlom amntDig" ng-keypress="onlyIntegers($event)" ng-keyup="amnt(); onlyIntegers($event)" ng-focus="onlyIntegers($event)" autocomplete="off">
                                                </md-input-container>
                                            </div>
                                         </div>
                                    </div>	
                                </div>
                                <div class="col-md-4 right mt5">
                                    <input readonly="readonly" class="form-control tlomt" placeholder="Total Other's" name="fare_total_oth">
                                </div>
								<a href="" class="text-info fnt-20 ml10" ng-click="addFields(field,$event)"> New Field : <span class="ion ion-plus-circled fnt-20"></span></a>
                           </div>
                         </div>
                         	</div>
                     </tab>
               </tabset>
               <!-----------------------------Service------------------------------->
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
                            <input value=""  name="texp" class="texp" readonly="readonly">
                        </md-input-container>
                    </div>
                    <div class="col-sm-6">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Final Amount (Total Expenses- Outstanding Balance)</label>
                            <input value="" class="finchamt" readonly="readonly">
                        </md-input-container>
                    </div>
               </div>
               <div class="row form-group" ng-if="expAdd.empdept != '3'"> 
                <div class="col-sm-4 filesRow" ng-controller="fileUploadCtrl">
                	<label class="selectlabel">Tour Planning Report: <span style="color:red;">(Mandatory)</span></label>   <br />   
                    <input value="{{file_name}}" class="form-control uploadFile" placeholder="Choose File" disabled="disabled" name="tplanningreport"/>
                        <div class="fileUpload btn btn-sm btn-info" tooltip="Upload" tooltip-placement="right">
                            <span class="ion ion-upload"></span>
                            <input type="file" class="upload uploadBtn tplanningreport" name="tplanningreport" id="tplanningreport" onchange="angular.element(this).scope().file_load_exp(this.files)"/>
                        </div><br />
                        <span style="color:red; font-size:9.5px;">(Kinldy upload PDF format and size not exceeding 1MB)</span>
                        <div class="mb20" ng-if="prg_shw_hde">
                            <md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
                        </div>
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