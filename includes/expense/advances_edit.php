<style>
.form-group {margin-bottom:0px !important;}
.form-group div.col-sm-6{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.datepicker {border-bottom: 1px solid #efefef !important;}
.upload-file {border-bottom: 1px solid rgba(0,0,0,0.12); padding-top: 9px;}
</style>
<div ng-controller="AdvancesCtrl">
<div class="modal-style" ng-controller="EnersysExpenseCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">EDIT ADVANCE REQUEST</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body">
		<form class="form-horizontal forms_request" name="advanceRequest" data-went="#/advances" method="post" url="services/expense_tracker/advances_update" novalidate>
            <input type="hidden" value="{{expenseViews.advance_alias}}" name="advance_alias" />
            <input type="hidden" value="{{expenseViews.approval_level}}" name="refer" />
            <input type="hidden" name="dept_name" value="{{expenseViews.employee_dept}}" />
			<div class="row form-group">
            	<div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00A">Date Of Request</label>
                        <input value="{{expenseViews.requested_date}}" readonly="readonly">
                    </md-input-container>
				</div>
                
                <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Employee ID</label>
                        <input value="{{expenseViews.employee_Id}}" readonly="readonly">
                    </md-input-container>
				</div>
                
                 <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Employee Name</label>
                        <input value="{{expenseViews.employee_Name}}" readonly="readonly">
                    </md-input-container>
				 </div>
              </div>   
              <div class="row form-group">  
                 <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Grade</label>
                        <input value="{{expenseViews.grade}}" readonly="readonly">
                    </md-input-container>
				 </div>
                
                <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Credit Lmit:</label>
                        <input class="limitt" value="{{expenseViews.credit_limit}}" readonly="readonly">
                    </md-input-container>
				 </div>
                
                 <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Previous Advances Not Settled (Amt):</label>
                        <input value="{{expenseViews.prev_amount}}" readonly="readonly" class="tamfor">
                    </md-input-container>
				 </div>
               </div>
               <div class="row form-group">  
                  <div class="col-sm-4" ng-if="expenseViews.approval_level >= '1'">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Current Request (Amt):</label>
                        <input value="{{expenseViews.request_amount}}" ng-model="expenseViews.request_amount" name="request_amount" readonly="readonly" class="tamfor">
                    </md-input-container>
				  </div>
                  <div class="col-sm-4" ng-if="expenseViews.approval_level == '0'">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Current Request (Amt):</label>
                        <input value="{{expenseViews.request_amount}}" name="request_amount" id="location" ng-model="expenseViews.request_amount" class="amntDig tamfor"  ng-keypress="onlyIntegers($event)" ng-keyup="onlyIntegers($event);currAmnt()" ng-focus="onlyIntegers($event)" autocomplete="off" required="required">
                    </md-input-container>
				  </div>
                  <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Toatl outstanding Advance (Current):</label>
                        <input value="{{expenseViews.tot_out_adv}}" name="tot_amount" readonly="readonly" class="tadv tamt">
                        <!--<input value="{{expenseViews.prev_amount -- expenseViews.request_amount}}" name="tot_amount" readonly="readonly" class="tadv">-->
                    </md-input-container>
				 </div>
                <div class="col-sm-4" ng-if="expenseViews.approval_level == '6'">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">UTR Number</label>
                        <input tabindex="1" class="qnty" name="utr_num" placeholder="UTR Number" type="text" ng-keypress="qntyInt($event)" ng-keyup="qntyInt($event);" ng-focus="qntyInt($event)" />
                    </md-input-container>
               </div>
                 <div ng-repeat="rem in expenseViews.remarks" ng-if="expenseViews.approval_level >= '1'">
                     <div class="col-sm-6">
                        <h5>Remarks: <small>(By {{rem.remarked_by}}, On: {{rem.remarked_on}})</small></h5>
                        <textarea rows="2" class="form-control resize-v padding-none" name="remarks" placeholder="Reason/Remarks" style="background-color:transparent;" readonly="readonly">{{rem.remarks_desc}}</textarea>
                     </div>
                </div>
                <div ng-repeat="rem in expenseViews.remarks" ng-if="expenseViews.approval_level == '0'">
                    <div class="col-sm-6">
                 		<h5>Remarks: <small>(By {{rem.remarked_by}}, On: {{rem.remarked_on}})</small></h5>
                        <textarea rows="2" class="form-control resize-v padding-none" name="remarks" id="rem" placeholder="Reason/Remarks" style="background-color:transparent;" required="required">{{rem.remarks_desc}}</textarea>
                    </div> 
               </div> 
                <div class="col-sm-4 mb10" ng-if="expenseViews.approval_level >= '1'">
                	<h5>Reason/Remarks: </h5>
                    <textarea rows="2" class="form-control resize-v padding-none" name="reasonForAdv" placeholder="Enter Remarks" id="rem" required="required"></textarea>
                </div> 
                <div class="col-sm-4 filesRow"  ng-if="expenseViews.approval_level == '0' && expenseViews.employee_dept!='3'" ng-controller="fileUploadCtrl">
                     <label class="selectlabel">Tour Planning Report: <span style="color:red;">(Mandatory)</span></label>   
                     <input type="hidden" name="tplanningreport_old" value="{{expenseViews.hidden_report}}"/>                    
                     <a href="{{expenseViews.report}}" target="_blank" ng-if="expenseViews.report != ''" style="color:red;">Click</a><br /> 
                    <input class="form-control uploadFile" value="{{file_name}}" placeholder="Choose File" disabled="disabled" name="tplanningreport"/>
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
                   <div class="panel panel-default">
                        <table class="table table-condensed" >
                            <thead>
                            <tr>
                                <th>Request ID</th>
                                <th>Requested Amount</th>
                                <th>Requested Date</th>
                                <th>Approved By</th>
                            </tr>
                            </thead>
                            <tbody>
                            	<tr ng-repeat="exp in expenseViews.advanceseditDetails">
                                	<td>{{exp.request_id}}</td>
                                	<td>{{exp.total_amount}}</td>
                                	<td>{{exp.requested_date}}</td>
                                	<td>{{exp.approved_by}}</td>
                                </tr>
                                <tfoot ng-if="expenseViews.advanceseditDetails.length=='0'"><tr><td>No Records</td></tr></tfoot>
                           </tbody>
                        </table>
                        <!-- #end data table -->	
                    </div>
               </div>
               <div class="row form-group"> 
                    <div class="col-sm-6 col-sm-offset-5 mt10" ng-if="expenseViews.approval_level >= '1' && expenseViews.submit_button == '0'">
                          <button type="submit" class="btn btn-info btn-sm"  ng-click="sendAdvRequest('approve')">Approve</button>
                          <button type="submit" class="btn btn-info btn-sm"  ng-click="sendAdvRequest('reject')">Reject</button>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5 mt10" ng-if="expenseViews.approval_level == '0' && expenseViews.submit_button == '0'">
                          <button type="submit" class="btn btn-info btn-sm"  ng-click="sendAdvRequest('adreq')">Advance Request</button>
                          <button type="submit" class="btn btn-info btn-sm" ng-click="sendAdvRequest('draft')">Draft</button>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5 mt10" ng-if="expenseViews.approval_level == '6' && expenseViews.submit_button == '1'">
                          <button type="submit" class="btn btn-info btn-sm"  ng-click="sendAdvRequest('approve')">Submit</button>
                    </div>
               </div>   
            </form> 
		</div>
	</div>
</div>
</div>