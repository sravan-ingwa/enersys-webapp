<style>
.modal-header > .close {right: -30px;top: -12px;}
.panel-heading b{color:#428bca; margin-right:20px;}.panel-heading i{color:#428bca;}.panel-heading span{color:#428bca}
.panel-info > .panel-heading { color: #ffffff !important; background-color: #428bca; border-color: #428bca;}
.panel-info > .panel-heading span{color:#fff;}
.panel-info > .panel-heading i{color:#fff;}
.panel-info > .panel-heading b{color:#fff;}
.right a span{color:#428bca;}
.exp_sing{padding:8px !important; margin:0px !important; background-color:#f5f5f5 !important;}
.exp_sing b{color:#535353}
.singPad{padding:5px 10px;}
</style>
<div class="modal-style" ng-controller="EnersysExpenseCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">View Expenses </h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body">
    <form class="form-horizontal forms_request" name="OthReadForm" data-went="#/expenses" method="post" url="services/expense_tracker/others_expences_edit" novalidate>
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
                 <div class="col-sm-3">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Grade</label>
                        <input value="{{expenseViews.grade}}" readonly="readonly">
                    </md-input-container>
				 </div>
                
                <div class="col-sm-3">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00D">Visit Start Date</label>
                        <input type="text" value="{{expenseViews.period_of_visit_from}}" readonly/>
                   </md-input-container>
                </div>	
                <div class="col-sm-3">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00E">Visit End Date</label>
                        <input type="text" value="{{expenseViews.places_of_visit_to}}" readonly>
                    </md-input-container>
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
                        <input value="{{expenseViews.places_of_visit}}" readonly>
                    </md-input-container>
				</div>
                <div class="col-sm-3">
                	<textarea rows="2" class="form-control resize-v padding-none" placeholder="Purpose" readonly>{{expenseViews.purpose}}</textarea>
                </div>   
               </div>
              <div class="row"> 
                <div class="col-sm-12 singPad">
                    <h4>Expense Details:</h4>
                    <!-- accordion -->
                    <accordion class="accordion-panel" >
                        <div class="panel panel-default panel-hovered" ng-if="expenseViews.exp_con_count > '0'">
                        <div class="panel-heading exp_sing">CONVEYANCE <b class="right mt2">Rs: {{expenseViews.tot_con_amt}}</b></div>
                            <!--local conveyance accordion -->
                            <accordion class="accordion-panel">
                                <accordion-group is-open="lc_status.open" ng-class="{'panel-info': lc_status.open}" ng-repeat="(key,con) in expenseViews.exp_conveyance">
                                <accordion-heading>
                                    CONVEYANCE {{key+1}} &nbsp; <i class="mt2 ion small" ng-class="{'ion-chevron-down': lc_status.open, 'ion-chevron-right': !lc_status.open}"></i><span class="right mr10">Rs: {{con.amount}}</span>
                                </accordion-heading>
                                    <div class="row">
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>Date of Travel</h5>
                                      <span class="fnt-size-11">{{con.date_of_travel}}</span>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>Mode of Travel</h5>
                                      <span class="fnt-size-11">{{con.mode_of_travel}}</span>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>From</h5>
                                      <span class="fnt-size-11">{{con.from_place}}</span>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>To</h5>
                                      <span class="fnt-size-11">{{con.to_place}}</span>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>Files</h5>
                                      <span class="fnt-size-11" ng-if="con.document_link != ''"><a href="{{con.document_link}}" target="_blank"><span style="color:red">Click</span></a></span>
                                      <span class="fnt-size-11" ng-if="con.document_link == ''">-NA-</a></span>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>Amount</h5>
                                      <span class="fnt-size-11">{{con.amount}}</span>
                                    </div>
                                    </div>
                                </accordion-group>
                            </accordion>
                            <!-- #end accordion -->
                        </div>
                    
                        <div class="panel panel-default panel-hovered" ng-if="expenseViews.exp_lcon_count > '0'">
                        <div class="panel-heading exp_sing" style="padding:8px;">LOCAL CONVEYANCE <b class="right mt2">Rs: {{expenseViews.tot_lcon_amt}}</b></div>
                            <!-- conveyance accordion -->
                            <accordion class="accordion-panel">
                                <accordion-group is-open="con_status.open" ng-class="{'panel-info': con_status.open}" ng-repeat="(key,loc) in expenseViews.exp_locconveyance">
                                <accordion-heading>
                                   LOCAL CONVEYANCE {{key+1}} &nbsp; <i class="mt2 ion small" ng-class="{'ion-chevron-down': con_status.open, 'ion-chevron-right': !con_status.open}"></i><span class="right mr10">Rs: {{loc.amount}}</span>
                                </accordion-heading>
                                    <div class="row">
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>Date of travel</h5>
                                      <span class="fnt-size-11">{{loc.date_of_travel}}</span>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>Mode of travel</h5>
                                      <span class="fnt-size-11">{{loc.mode_of_travel}}</span>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>From</h5>
                                      <span class="fnt-size-11">{{loc.from_place}}</span>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>To</h5>
                                      <span class="fnt-size-11">{{loc.to_place}}</span>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>Amount</h5>
                                      <span class="fnt-size-11">{{loc.amount}}</span>
                                    </div>
                                </div>
                                </accordion-group>
                            </accordion>
                            <!-- #end accordion -->
                        </div>
                        
                        <div class="panel panel-default panel-hovered" ng-if="expenseViews.exp_lod_count > '0'">
                        <div class="panel-heading exp_sing" style="padding:8px;">LODGING <b class="right mt2">Rs: {{expenseViews.tot_lod_amt}}</b></div>
                            <!-- Lodging accordion -->
                            <accordion class="accordion-panel">
                                <accordion-group is-open="con_status.open" ng-class="{'panel-info': con_status.open}" ng-repeat="(key,lod) in expenseViews.exp_lodging">
                                <accordion-heading>
                                    LODGING {{key+1}} &nbsp; <i class="mt2 ion small" ng-class="{'ion-chevron-down': con_status.open, 'ion-chevron-right': !con_status.open}"></i><span class="right mr10">Rs: {{lod.amount}}</span>
                                </accordion-heading>
                                    <div class="row">
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>Stay Type</h5>
                                      <span class="fnt-size-11">{{lod.type_of_stay}}</span>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>Check in Date</h5>
                                      <span class="fnt-size-11">{{lod.check_in}}</span>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>Check out Date</h5>
                                      <span class="fnt-size-11">{{lod.check_out}}</span>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>Hotel Name</h5>
                                      <span class="fnt-size-11">{{lod.hotel_name}}</span>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>Files</h5>
                                      <span class="fnt-size-11" ng-if="lod.document_link != ''"><a href="{{lod.document_link}}" target="_blank"><span style="color:red">Click</span></a></span>
                                      <span class="fnt-size-11" ng-if="lod.document_link == ''">-NA-</a></span>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>Amount</h5>
                                      <span class="fnt-size-11">{{lod.amount}}</span>
                                    </div>
                                </div>
                                </accordion-group>
                            </accordion>
                            <!-- #end accordion -->
                        </div>
        
                        <div class="panel panel-default panel-hovered" ng-if="expenseViews.exp_bod_count > '0'">
                        <div class="panel-heading exp_sing" style="padding:8px;">BOARDING <b class="right mt2">Rs: {{expenseViews.tot_bod_amt}}</b></div>
                            <!-- Lodging accordion -->
                            <accordion class="accordion-panel">
                                <accordion-group is-open="con_status.open" ng-class="{'panel-info': con_status.open}" ng-repeat="(key,bod) in expenseViews.exp_boarding">
                                <accordion-heading>
                                    BOARDING {{key+1}} &nbsp; <i class="mt2 ion small" ng-class="{'ion-chevron-down': con_status.open, 'ion-chevron-right': !con_status.open}"></i><span class="right mr10">Rs: {{bod.amount}}</span>
                                </accordion-heading>
                                    <div class="row">
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>Visit: Start Date</h5>
                                      <span class="fnt-size-11">{{bod.check_in}}</span>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>Visit: End Date</h5>
                                      <span class="fnt-size-11">{{bod.check_out}}</span>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>State</h5>
                                      <span class="fnt-size-11">{{bod.state}}</span>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>Amount</h5>
                                      <span class="fnt-size-11">{{bod.amount}}</span>
                                    </div>
                                </div>
                                </accordion-group>
                            </accordion>
                            <!-- #end accordion -->
                        </div>
                        
                        <div class="panel panel-default panel-hovered" ng-if="expenseViews.exp_oth_count > '0'">
                        <div class="panel-heading exp_sing" style="padding:8px;">OTHERS <b class="right mt2">Rs: {{expenseViews.tot_oth_amt}}</b></div>
                            <!-- Lodging accordion -->
                            <accordion class="accordion-panel">
                                <accordion-group is-open="con_status.open" ng-class="{'panel-info': con_status.open}" ng-repeat="(key,oth) in expenseViews.exp_others">
                                <accordion-heading>
                                    OTHERS {{key+1}} &nbsp; <i class="mt2 ion small" ng-class="{'ion-chevron-down': con_status.open, 'ion-chevron-right': !con_status.open}"></i><span class="right mr10">Rs: {{oth.amount}}</span>
                                </accordion-heading>
                                    <div class="row">
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>Description</h5>
                                      <span class="fnt-size-11">{{oth.description}}</span>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>Date</h5>
                                      <span class="fnt-size-11">{{oth.checked_date}}</span>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>Files</h5>
                                      <span class="fnt-size-11" ng-if="oth.document_link != ''"><a href="{{oth.document_link}}" target="_blank"><span style="color:red;">Click</span></a></span>
                                      <span class="fnt-size-11" ng-if="oth.document_link == ''">-NA-</span>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                      <h5>Amount</h5>
                                      <span class="fnt-size-11">{{oth.amount}}</span>
                                    </div>
                                </div>
                                </accordion-group>
                            </accordion>
                            <!-- #end accordion -->
                        </div>
                    </accordion>
                    <!-- #end accordion -->
                  </div>
              </div>
            <div class="row form-group"> 
                <div class="col-sm-3">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Outstanding Balance</label>
                        <input value="{{expenseViews.outstanding}}" readonly="readonly" class="nsamt">
                    </md-input-container>
                </div>
                <div class="col-sm-3">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Book Expenses</label>
                        <input value="{{expenseViews.booked_expenses}}" readonly="readonly" class="texp">
                    </md-input-container>
                </div>
                <div class="col-sm-3" ng-if="expenseViews.ref2 == '4'">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Reimbursement</label>
                        <input value="" name="rem_amt" autocomplete="off" ng-keypress="qntyInt($event)" ng-keyup="qntyInt($event); remAmnt()" ng-focus="qntyInt($event)" class="qntyy qnty">
                    </md-input-container>
                </div>
                <div class="col-sm-3" ng-if="expenseViews.ref2 == '4'">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Refund</label>
                        <input value="" name="ref_amt" autocomplete="off" ng-keypress="qntyInt($event)" ng-keyup="qntyInt($event);" ng-focus="qntyInt($event)">
                    </md-input-container>
                </div>
               <div class="col-sm-6">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Final Amount (Total Expenses- Outstanding Balance)</label>
                        <input value="{{expenseViews.final_amount}}" class="finchamt" readonly="readonly">
                        <input value="{{expenseViews.final_amount}}" class="finchamt_hid" type="hidden">
                    </md-input-container>
               </div>
               <!-- <div class="col-sm-3" ng-if="expenseViews.ref2 == '3'">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">PO/ GNR Number</label>
                        <input tabindex="1" class="qnty" name="po_gnr" ng-keypress="qntyInt($event)" ng-keyup="qntyInt($event);" ng-focus="qntyInt($event)"  placeholder="PO/ GNR Number" type="text"/>
                    </md-input-container>
               </div> -->
               <div class="col-sm-3" ng-if="expenseViews.ref2 == '6'">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">UTR Number</label>
                        <input tabindex="1" class="qnty" name="utr_num" placeholder="UTR Number" type="text"  ng-keypress="qntyInt($event)" ng-keyup="qntyInt($event);" ng-focus="qntyInt($event)" />
                    </md-input-container>
               </div>
               <div class="col-sm-3">
                    <textarea rows="3" class="form-control resize-v padding-none" placeholder="Remarks" name="reasonForAdv"></textarea>
               </div>
           </div>
           
			<div class="row">
         	<div class="col-md-11 bs-callout">
                <div class="col-md-6 form-group" ng-repeat="rem in expenseViews.remarks">
                    <h4>Remarks: <small>(By {{rem.remarked_by}}, On: {{rem.remarked_on}})</small></h4>
                    <p>{{rem.remarks_desc}}</p>
                </div>
            </div>
    	</div>           
        	<div class="row form-group"> 
                <div class="col-sm-6 col-sm-offset-5 mt10" ng-if="expenseViews.submit_button == '0'">
                     <button type="submit" class="btn btn-info btn-sm" click-once ng-click="sendRequest('request')">Approve</button>
                     <button type="submit" class="btn btn-info btn-sm" click-once ng-click="sendRequest('reject')">Reject</button>
                </div>
             	<div class="col-sm-6 col-sm-offset-5 mt10" ng-if="expenseViews.submit_button == '1'">
                      <button type="submit" class="btn btn-info btn-sm" click-once ng-click="sendRequest('request')">Submit</button>
                </div>
            </div> 
    </form>	
   </div>
</div>
