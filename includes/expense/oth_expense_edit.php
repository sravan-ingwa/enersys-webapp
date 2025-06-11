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
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
.tab-content{padding:10px !important;}
.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
    background-color: #efefef;
}
input[disabled] {
    background-color: #efefef;
}
md-input-container.md-default-theme .md-input[disabled], [disabled] md-input-container.md-default-theme .md-input {
    border-bottom-color: rgba(0,0,0,0.12);
}
</style>
<div class="modal-style" ng-controller="EnersysExpenseCtrl">	
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit Expenses</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body">
		<form class="form-horizontal forms_request" name="OthEditForm" data-went="#/expenses" method="post" url="services/expense_tracker/others_expences_edit" novalidate>
        <input type="hidden" value="{{expenseViews.expenses_alias}}" name="id" />
        <input type="hidden" value="{{expenseViews.ref2}}" name="ref2" />
        <input type="hidden" value="{{expenseViews.empdept}}" name="empdept" />
			<div class="row form-group">
            	<div class="col-sm-3">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00A">Date Of Request</label>
                        <input value="{{expenseViews.requested_date}}" disabled>
                    </md-input-container>
				</div>
                
                <div class="col-sm-3">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Employee ID</label>
                        <input value="{{expenseViews.employee_id}}" disabled>
                    </md-input-container>
				</div>
                
                 <div class="col-sm-3">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Employee Name</label>
                        <input value="{{expenseViews.employee_name}}" disabled>
                    </md-input-container>
				 </div> 
                  <div ng-controller="DatepickerDemoCtrl">  
                     <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00B">Grade</label>
                            <input value="{{expenseViews.grade}}" disabled>
                        </md-input-container>
                     </div>
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Visit Start Date</label>
                            <input type="text" value="{{expenseViews.period_of_visit_from}}" disabled ng-model="expenseViews.period_of_visit_from" name="visitFromDate" class="" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="dateCal();open($event,'opened1')"/>
                       </md-input-container>
                    </div>	
                    <div class="col-sm-3">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00E">Visit End Date</label>
                            <input type="text" value="{{expenseViews.places_of_visit_to}}" disabled ng-model="expenseViews.places_of_visit_to" name="visitToDate" class="" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="dateCal();open($event,'opened2')">
                        </md-input-container>
                    </div>
                   </div> 
                  <div class="col-sm-3">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">No.Of Days</label>
                        <input value="{{expenseViews.no_of_days}}" id="num_nights" disabled>
                    </md-input-container>
				 </div>
               
                <div class="col-sm-3">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Visited Place's</label>
                        <input value="{{expenseViews.places_of_visit}}" name="placesOfVisit">
                    </md-input-container>
				</div>
                <div class="col-sm-3">
                	<textarea rows="2" class="form-control resize-v" placeholder="Purpose" name="purpose">{{expenseViews.purpose}}</textarea>
                </div> 
                <div class="col-sm-3">
                    <textarea rows="2" class="form-control resize-v" placeholder="Purpose" name="remarks">{{expenseViews.remarkss}}</textarea>
                </div>
           </div>
               
           <tabset justified="true" class="tabs-linearrow mt10">
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
                                            <input type="hidden" name="idc[]" value="{{con.alias}}"/>
                                                <div class="row form-group">
                                                    <div class="col-sm-3" ng-controller="DatepickerDemoCtrl">
                                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                            <label for="input_00B">Date of Travel</label>
                                                            <input type="text" name="dot[]" disabled value="{{con.date_of_travel}}" class="border-bottom" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" ng-model="con.date_of_travel" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>  
                                                        </md-input-container>
                                                    </div>
                                                    <div class="col-sm-3">
														<label class="selectlabel">Mode Of Travel</label>
                                                        <select class="form-control selectdrop SlectBox" ng-model="mots" name="mot[]" >
                                                            <option value="" selected="selected">Mode Of Travel</option>
                                                            <option ng-repeat="mof in modeOfTravel" value="{{mof.name}}" ng-selected="mof.name == con.mode_of_travel">{{mof.name}}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                            <label for="input_00B">From</label>
                                                            <input value="{{con.from_place}}" name="from[]">
                                                        </md-input-container>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                            <label for="input_00B">To</label>
                                                            <input value="{{con.to_place}}" name="to[]">
                                                        </md-input-container>
                                                    </div>
                                                    <div class="col-sm-3 oldfilesRow">
                                                        <input type="hidden" class="form-control" name="motbill_old[]" value="{{con.hidden_document_link}}"/>
														<a href="{{con.document_link}}" target="_blank" ng-if="con.hidden_document_link!='' && con.hidden_document_link!='0'"><span style="color:red;">Click For Old Report</span></a>                                                        <div>
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
                                                            <input value="{{con.amount}}" class="amtt tamfor tcm amntDig" name="amt[]" ng-keypress="onlyIntegers($event)" ng-keyup="amnt(); onlyIntegers($event)" ng-focus="onlyIntegers($event)" autocomplete="off">
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
                                            <input type="hidden" name="idc[]" value="0"/>
                                                <div class="row form-group">
                                                    <div class="col-sm-3" ng-controller="DatepickerDemoCtrl">
                                                        <md-input-container flex="" class="md-default-theme">
                                                            <label for="input_00B">Date of Travel</label>
                                                            <input type="text" name="dot[]" disabled class="border-bottom" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" ng-model="expenseViews.date_of_travel" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>  
                                                        </md-input-container>
                                                    </div>
                                                    <div class="col-sm-3">
														<label class="selectlabel">Mode Of Travel</label>
                                                        <select name="mot[]" class="form-control selectdrop SlectBox" ng-model="mots" >
                                                            <option value="" selected="selected">Mode Of Travel</option>
                                                            <option ng-repeat="mof in modeOfTravel" value="{{mof.name}}">{{mof.name}}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <md-input-container flex="" class="md-default-theme">
                                                            <label for="input_00B">From</label>
                                                            <input value="{{expenseViews.from_place}}" name="from[]">
                                                        </md-input-container>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <md-input-container flex="" class="md-default-theme">
                                                            <label for="input_00B">To</label>
                                                            <input value="" name="to[]">
                                                        </md-input-container>
                                                    </div>
                                                     <div class="col-sm-3 filesRow">
                                                        <input class="form-control uploadFile" placeholder="Choose File" disabled="disabled" name="motbill[]"/>
                                                        <div class="fileUpload btn btn-sm btn-info" tooltip="Upload" tooltip-placement="top">
                                                            <span class="ion ion-upload"></span>
                                                            <input type="file" class="upload uploadBtn" name="motbill[]"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <md-input-container flex="" class="md-default-theme">
                                                            <label for="input_00B">Amount</label>
                                                            <input value="" class="amtt tamfor tcm amntDig" name="amt[]" ng-keypress="onlyIntegers($event)" ng-keyup="amnt(); onlyIntegers($event)" ng-focus="onlyIntegers($event)" autocomplete="off">
                                                        </md-input-container>
                                                    </div>
                                                 </div>
                                            </div>	
                                        </div>
                                   <div class="col-md-4 right mt10">
                                        <input value="{{expenseViews.tot_con_amt}}" disabled class="form-control tcmt" placeholder="Total Conveyance" name="fare_total_con" >
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
                               <div class="panel panel-default mb10 expHide" ng-repeat="(key,loc) in expenseViews.exp_locconveyance">
                                    <div class="panel-heading">
                                        <span>Local Conveyance {{key+1}} <a href="" ng-click="removeDyn(key,loc.alias,loc.expenses_alias,$event)" class="delLoc right"><span class="ion ion-android-delete fnt-20" data-ref="lc"></span></a></span>
                                    </div>
                                    <div class="panel-body">
                                     <input type="hidden" name="idc_l[]" value="{{loc.alias}}"/>
                                         <div class="row form-group">
                                            <div class="col-sm-3" ng-controller="DatepickerDemoCtrl">
                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                    <label for="input_00B">Date of Travel</label>
                                                    <input type="text" name="dot_l[]" disabled value="{{loc.date_of_travel}}" class="border-bottom" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" ng-model="loc.date_of_travel" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>  
                                                </md-input-container>
                                            </div>
                                            <div class="col-sm-3">
												<label class="selectlabel">Mode Of Travel</label>
                                                <select class="form-control selectdrop SlectBox" ng-model="mots" name="mot_l[]" >
                                                    <option value="" selected="selected">Mode Of Travel</option>
                                                    <option ng-repeat="mof in modeOfTravel" value="{{mof.name}}" ng-selected="mof.name == loc.mode_of_travel">{{mof.name}}</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                    <label for="input_00B">From</label>
                                                    <input value="{{loc.from_place}}" name="from_l[]">
                                                </md-input-container>
                                            </div>
                                            <div class="col-sm-3">
                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                    <label for="input_00B">To</label>
                                                    <input value="{{loc.to_place}}" name="to_l[]">
                                                </md-input-container>
                                            </div>
                                            <div class="col-sm-3">
                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                    <label for="input_00B">Amount</label>
                                                    <input value="{{loc.amount}}" name="amt_l[]" class="amtt tamfor ttcm amntDig"  ng-keypress="onlyIntegers($event)" ng-keyup="amnt(); onlyIntegers($event)" ng-focus="onlyIntegers($event)" autocomplete="off">
                                                </md-input-container>
                                            </div>
                                         </div>
                                    </div>	
                                </div>
                               <div class="panel panel-default mb10" ng-repeat="(key,type) in field.itemtype">
                                    <div class="panel-heading">
                                        <span>Local Conveyance {{expenseViews.exp_locconveyance.length+key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20"></span></a></span>
                                    </div>
                                    <div class="panel-body"><input type="hidden" name="idc_l[]" value="0"/>
                                         <div class="row form-group">
                                            <div class="col-sm-3" ng-controller="DatepickerDemoCtrl">
                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                    <label for="input_00B">Date of Travel</label>
                                                    <input type="text" name="dot_l[]" disabled class="border-bottom" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" ng-model="dot_l" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>  
                                                </md-input-container>
                                            </div>
                                            <div class="col-sm-3">
											   <label class="selectlabel">Mode Of Travel</label>
                                               <select class="form-control selectdrop SlectBox" ng-model="mots" name="mot_l[]" >
                                                    <option value="" selected="selected">Mode Of Travel</option>
                                                    <option ng-repeat="mof in modeOfTravel" value="{{mof.name}}" >{{mof.name}}</option>
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
                                                    <input value="" name="amt_l[]" class="amtt tamfor ttcm amntDig" ng-keypress="onlyIntegers($event)" ng-focus="onlyIntegers($event)" ng-keyup="amnt(); onlyIntegers($event)"  autocomplete="off">
                                                </md-input-container>
                                            </div>
                                         </div>
                                    </div>	
                                </div>
                               <div class="col-md-4 right mt10">
                                    <input value="{{expenseViews.tot_lcon_amt}}" disabled class="form-control ttcmt" placeholder="Total Local Conveyance"  name="fare_total_loc">
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
                               <div class="panel panel-default mb10 expHide" ng-repeat="(key,lod) in expenseViews.exp_lodging">
                                    <div class="panel-heading">
                                        <span>Lodging {{key+1}} <a href="" ng-click="removeDyn(key,lod.alias,lod.expenses_alias,$event)" class="delLoc right"><span class="ion ion-android-delete fnt-20" data-ref="ld"></span></a></span>
                                    </div>
                                    <div class="panel-body lodGing_amnt" ng-controller="othersExpenseeditCtrl"><input type="hidden" name="idl[]" value="{{lod.alias}}"/>
                                         <div class="row form-group">
                                            <div class="col-sm-3">
												<label class="selectlabel">Stay Type</label>
                                                <select class="form-control selectdrop SlectBox stay" ng-model="stayType" ng-init="lodging_self(lod.type_of_stay)" ng-change="lodging_self(stayType); amnt()" name="typeofstay[]">
                                                    <option value="" selected="selected">Select Stay Type</option>
                                                    <option value="Reimbursement" ng-selected="lod.type_of_stay == 'Reimbursement'">Reimbursement</option>
                                                    <option value="Self" ng-selected="lod.type_of_stay == 'Self'">Self</option>
                                                </select>
                                            </div>
                                            <div ng-controller="DatepickerDemoCtrl">
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00D">Check in Date</label>
                                                        <input type="text" value="{{lod.check_in}}" disabled ng-model="lod.check_in" name="checkin[]"  class="checkin" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="loadvalto($event);open($event,'opened1')"/>
                                                   </md-input-container>
                                                </div>	
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                        <label for="input_00E">Check out Date</label>
                                                        <input type="text" value="{{lod.check_out}}" disabled ng-model="lod.check_out" name="checkout[]" class="checkout" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="loadvalto($event);open($event,'opened2')">
                                                    </md-input-container>
                                                </div>
                                            </div>
                                             <div class="col-sm-3" ng-class="htName">
                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                    <label for="input_00B">Hotel Name</label>
                                                    <input value="{{lod.hotel_name}}" name="hotelName[]">
                                                </md-input-container>
                                            </div>
                                            <div class="col-sm-3" ng-class="stName">
												<label class="selectlabel">State</label>
                                                <select class="form-control selectdrop SlectBox lodvalto htname" ng-change="loadvalto($event);"  ng-model="state" name="hotelName1[]">
                                                    <option value="" selected="selected">State</option>
                                                    <option value="a1" ng-selected="lod.hotel_name == 'a1'">A+</option>
                                                    <option value="a" ng-selected="lod.hotel_name == 'a'">A</option>
                                                    <option value="b" ng-selected="lod.hotel_name == 'b'">B</option>
                                                    <option value="c" ng-selected="lod.hotel_name == 'c'">C</option>
                                                </select>
                                            </div>
                                         </div>
                                         <div class="row form-group">
                                            <div class="col-sm-3 oldfilesRow">
                                                <input type="hidden" name="lfile_old[]" value="{{lod.hidden_document_link}}"/>
                                                <a href="{{lod.document_link}}" target="_blank" ng-if="lod.hidden_document_link!='' && lod.hidden_document_link!='0'"><span style="color:red;">Click For Old Report</span></a>
                                                <div>
                                                <input class="form-control uploadFile" placeholder="Choose File" disabled="disabled" name="lfile[]"/>
                                                <div class="fileUpload btn btn-sm btn-info" tooltip="Upload" tooltip-placement="bottom">
                                                    <span class="ion ion-upload"></span>
                                                    <input type="file" class="upload uploadBtn" name="lfile[]" />
                                                </div>
                                                </div>
                                            </div>  
                                            <div class="col-sm-3">
                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                    <label for="input_00B">Amount</label>
                                                    <input value="{{lod.amount}}" ng-model="lod.amount" name="lamt[]" class="amtt tamfor tlam selfamm stAmnt amntDig" ng-keypress="onlyIntegers($event)" ng-focus="onlyIntegers($event)" disabled ng-keyup="amnt(); onlyIntegers($event)" autocomplete="off">
                                                </md-input-container>
                                            </div>
                                         </div>
                                    </div>	
                                </div>
                               <div class="panel panel-default mb10" ng-repeat="(key,type) in field.itemtype">
                                    <div class="panel-heading">
                                        <span>Lodging {{expenseViews.exp_lodging.length+key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20"></span></a></span>
                                    </div>
                                    <div class="panel-body lodGing_amnt" ng-controller="othersExpenseeditCtrl"><input type="hidden" name="idl[]" value="0"/>
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
                                                        <input type="text" ng-model="Startddate" disabled name="checkin[]" class="checkin" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="loadvalto($event);open($event,'opened1')"/>
                                                   </md-input-container>
                                                </div>	
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00E">Check out Date</label>
                                                        <input type="text" ng-model="Enddate" disabled name="checkout[]" class="checkout" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="loadvalto($event);open($event,'opened2')">
                                                    </md-input-container>
                                                </div>
                                            </div>
                                             <div class="col-sm-3" ng-if="stayType == 'Reimbursement'">
											<input type="hidden" name="hotelName1[]" value="" />
                                                <md-input-container flex="" class="md-default-theme">
                                                    <label for="input_00B">Hotel Name</label>
                                                    <input value="" name="hotelName[]">
                                                </md-input-container>
                                            </div>
                                            <div class="col-sm-3" ng-if="stayType == 'Self'">
											<input type="hidden" name="hotelName[]" value="" />
												<label class="selectlabel">State</label>
                                                <select class="form-control selectdrop SlectBox lodvalto htname" ng-change="loadvalto($event);"  ng-model="state" name="hotelName1[]">
                                                    <option value="" selected="selected">State</option>
                                                    <option value="a1">A+</option>
                                                    <option value="a">A</option>
                                                    <option value="b">B</option>
                                                    <option value="c">C</option>
                                                </select>
                                            </div>
                                         </div>
                                         <div class="row form-group">
                                            <div class="col-sm-3 filesRow">
                                                <input class="form-control uploadFile" placeholder="Choose File" disabled="disabled" name="lfile[]"/>
                                                <div class="fileUpload btn btn-sm btn-info" tooltip="Upload" tooltip-placement="top">
                                                    <span class="ion ion-upload"></span>
                                                    <input type="file" class="upload uploadBtn" name="lfile[]"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                    <label for="input_00B">Amount</label>
                                                    <input value="" name="lamt[]" class="amtt tamfor tlam selfamm amntDig" ng-keyup="amnt(); onlyIntegers($event)" ng-keypress="onlyIntegers($event)" ng-focus="onlyIntegers($event)"  autocomplete="off">
                                                </md-input-container>
                                            </div>
                                         </div>
                                    </div>	
                                </div>
                                 <div class="col-md-4 right mt10">
                                        <input value="{{expenseViews.tot_lod_amt}}" disabled class="form-control tlamt" placeholder="Total Lodging"  name="fare_total_lod">
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
                               <div class="panel panel-default mb10 expHide" ng-repeat="(key,bod) in expenseViews.exp_boarding">
                                    <div class="panel-heading">
                                        <span>Boarding {{key+1}} <a href="" ng-click="removeDyn(key,bod.alias,bod.expenses_alias,$event)" class="delLoc right"><span class="ion ion-android-delete fnt-20" data-ref="bd"></span></a></span>
                                    </div>
                                    <div class="panel-body boarding_amnt" ng-controller="othersExpenseeditCtrl"><input type="hidden" name="idb[]" value="{{bod.alias}}"/>
                                         <div class="row form-group">
                                            <div ng-controller="DatepickerDemoCtrl">
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00D">Visit: Start Date</label>
                                                        <input type="text" value="{{bod.check_in}}" disabled ng-model="bod.check_in" name="checkinb[]" class="checkin" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="boardvalto($event);open($event,'opened1')"/>
                                                   </md-input-container>
                                                </div>	
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00E">Visit: End Date</label>
                                                        <input type="text" value="{{bod.check_out}}" disabled ng-model="bod.check_out" name="checkoutb[]" class="checkout" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="boardvalto($event);open($event,'opened2')">
                                                    </md-input-container>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
												<label class="selectlabel">State</label>
                                                <select class="form-control selectdrop SlectBox bodvalto" ng-change="boardvalto($event);" ng-model="state" name="state[]">
                                                    <option value="" selected="selected">State</option>
                                                    <option value="a1" ng-selected="bod.state == 'a1'">A+</option>
                                                    <option value="a" ng-selected="bod.state == 'a'">A</option>
                                                    <option value="b" ng-selected="bod.state == 'b'">B</option>
                                                    <option value="c" ng-selected="bod.state == 'c'">C</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                    <label for="input_00B">Amount</label>
                                                    <input value="{{bod.amount}}" name="bamt[]" class="amtt tamfor blam selfamm amntDig"ng-keypress="onlyIntegers($event)" ng-keyup="amnt(); onlyIntegers($event)" ng-focus="onlyIntegers($event)"  autocomplete="off">
                                                </md-input-container>
                                            </div>
                                         </div>
                                    </div>	
                                </div>
                               <div class="panel panel-default mb10" ng-repeat="(key,type) in field.itemtype">
                                    <div class="panel-heading">
                                        <span>Boarding {{expenseViews.exp_boarding.length+key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20"></span></a></span>
                                    </div>
                                    <div class="panel-body boarding_amnt" ng-controller="othersExpenseeditCtrl"><input type="hidden" name="idb[]" value="0"/>
                                         <div class="row form-group">
                                            <div ng-controller="DatepickerDemoCtrl">
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00D">Check in Date</label>
                                                        <input type="text" ng-model="Startddate" disabled name="checkinb[]" class="checkin" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="boardvalto($event);open($event,'opened1')"/>
                                                   </md-input-container>
                                                </div>	
                                                <div class="col-sm-3">
                                                    <md-input-container flex="" class="md-default-theme">
                                                        <label for="input_00E">Check out Date</label>
                                                        <input type="text" ng-model="Enddate" disabled name="checkoutb[]" class="checkout" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="boardvalto($event);open($event,'opened2')">
                                                    </md-input-container>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
												<label class="selectlabel">State</label>
                                                <select class="form-control selectdrop SlectBox bodvalto" ng-change="boardvalto($event);" ng-model="state" name="state[]">
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
                                <div class="col-md-4 right mt10">
                                    <input value="{{expenseViews.tot_bod_amt}}" disabled class="form-control blamt" placeholder="Total Boarding" name="fare_total_bod">
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
                               <div class="panel panel-default mb10 expHide" ng-repeat="(key,oth) in expenseViews.exp_others">
                                    <div class="panel-heading">
                                        <span>Others {{key+1}} <a href="" ng-click="removeDyn(key,oth.alias,oth.expenses_alias,$event)" class="delLoc right"><span class="ion ion-android-delete fnt-20" data-ref="ot"></span></a></span>
                                    </div>
                                    <div class="panel-body"><input type="hidden" name="ido[]" value="{{oth.alias}}"/>
                                        <div class="row form-group">
                                            <div class="col-sm-3">
                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                    <label for="input_00B">Description</label>
                                                    <input value="{{oth.description}}" name="others[]">
                                                </md-input-container>
                                            </div>
                                            <div class="col-sm-3" ng-controller="DatepickerDemoCtrl">
                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                    <label for="input_00B">Date</label>
                                                    <input type="text" value="{{oth.checked_date}}"disabled name="odate[]" class="border-bottom" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" ng-model="oth.checked_date" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>  
                                                </md-input-container>
                                            </div>
                                            <div class="col-sm-3 oldfilesRow">
                                                <input type="hidden" name="ofile_old[]" value="{{oth.hidden_document_link}}"/>
                                                <a href="{{oth.document_link}}" target="_blank" ng-if="oth.hidden_document_link!='' && oth.hidden_document_link!='0'"><span style="color:red;">Click For Old Report</span></a>
                                                <div>
                                                <input class="form-control uploadFile" placeholder="Choose File" disabled="disabled" name="ofile[]"/>
                                                <div class="fileUpload btn btn-sm btn-info" tooltip="Upload" tooltip-placement="bottom">
                                                    <span class="ion ion-upload"></span>
                                                    <input type="file" class="upload uploadBtn" name="ofile[]" />
                                                </div>
                                                </div>
                                            </div> 
                                            <div class="col-sm-3">
                                                <md-input-container flex="" class="md-default-theme md-input-has-value">
                                                    <label for="input_00B">Amount</label>
                                                    <input value="{{oth.amount}}" name="oamt[]" class="amtt tamfor tlom amntDig" ng-keypress="onlyIntegers($event)" ng-keyup="amnt(); onlyIntegers($event)" ng-focus="onlyIntegers($event)"  autocomplete="off">
                                                </md-input-container>
                                            </div>
                                         </div>
                                    </div>	
                                </div>
                               <div class="panel panel-default mb10" ng-repeat="(key,type) in field.itemtype">
                                    <div class="panel-heading">
                                        <span>Others {{expenseViews.exp_others.length+key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20"></span></a></span>
                                    </div>

                                    <div class="panel-body"><input type="hidden" name="ido[]" value="0"/>
                                        <div class="row form-group">
                                            <div class="col-sm-3">
                                                <md-input-container flex="" class="md-default-theme">
                                                    <label for="input_00B">Description</label>
                                                    <input value="" name="others[]">
                                                </md-input-container>
                                            </div>
                                            <div class="col-sm-3" ng-controller="DatepickerDemoCtrl">
                                                <md-input-container flex="" class="md-default-theme">
                                                    <label for="input_00B">Date</label>
                                                    <input type="text" name="odate[]" disabled class="border-bottom" placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" ng-model="odate" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>  
                                                </md-input-container>
                                            </div>
                                            <div class="col-sm-3 filesRow">
                                                <input class="form-control uploadFile" placeholder="Choose File" disabled="disabled" name="ofile[]"/>
                                                <div class="fileUpload btn btn-sm btn-info" tooltip="Upload" tooltip-placement="top">
                                                    <span class="ion ion-upload"></span>
                                                    <input type="file" class="upload uploadBtn" name="ofile[]"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <md-input-container flex="" class="md-default-theme">
                                                    <label for="input_00B">Amount</label>
                                                    <input value="" name="oamt[]" class="amtt tamfor tlom amntDig" ng-keypress="onlyIntegers($event)" ng-keyup="amnt(); onlyIntegers($event)" ng-focus="onlyIntegers($event)"  autocomplete="off">
                                                </md-input-container>
                                            </div>
                                         </div>
                                    </div>	
                                </div>
                                <div class="col-md-4 right mt10">
                                    <input value="{{expenseViews.tot_oth_amt}}" disabled class="form-control tlomt" placeholder="Total Other's" name="fare_total_oth">
                                </div>
								<a href="" class="text-info fnt-20 ml10" ng-click="addFields(field,$event)"> New Field : <span class="ion ion-plus-circled fnt-20"></span></a>
                           </div>
                          </div>
                        </div>
                </tab>
           </tabset>
           
           <div class="row form-group"> 
                <div class="col-sm-4">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Outstanding Balance</label>
                        <input value="{{expenseViews.outstanding}}" disabled class="nsamt">
                    </md-input-container>
                </div>
                <div class="col-sm-4">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Booked Expenses</label>
                        <input value="{{expenseViews.booked_expenses}}" name="texp" class="texp" disabled>
                    </md-input-container>
                </div>
                <div class="col-sm-4">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Reimbursement</label>
                        <input value="{{expenseViews.reimbursement_amount}}" disabled>
                    </md-input-container>
                </div>
           </div>
           <div class="row form-group"> 
                <div class="col-sm-4">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Final Amount (Total Expenses- Outstanding Balance)</label>
                        <input value="{{expenseViews.final_amount}}" disabled class="finchamt">
                    </md-input-container>
                </div>
                <div class="col-sm-4 oldfilesRow" ng-if="expenseViews.empdept != '3'">
                     <label class="selectlabel">Tour Planning Report: <span style="color:red;">(Mandatory)</span></label>   
                     <input type="hidden" name="tplanningreport_old" value="{{expenseViews.hidden_report}}"/>                    
                     <a href="{{expenseViews.report}}" target="_blank" ng-if="expenseViews.hidden_report!='' && expenseViews.hidden_report!='0'" style="color:red;">Click</a><br /> 
                    <input class="form-control uploadFile" placeholder="Choose File" disabled="disabled" name="tplanningreport"/>
                    <div class="fileUpload btn btn-sm btn-info" tooltip="Upload" tooltip-placement="right">
                        <span class="ion ion-upload"></span>
                        <input type="file" class="upload uploadBtn tplanningreport" name="tplanningreport" id="tplanningreport"/>
                    </div><br />
               		<span style="color:red; font-size:9.5px;">(Kinldy upload PDF format and size not exceeding 1MB)</span>
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
/*$(document).on("keypress keyup focus",".amntDig",function (event) {    
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