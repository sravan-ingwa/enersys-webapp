<style>
.form-group {margin-bottom:0px !important;}
.form-group div.col-sm-6{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.datepicker {border-bottom: 1px solid #efefef !important;}
.upload-file {border-bottom: 1px solid rgba(0,0,0,0.12); padding-top: 9px;}
</style>
<div class="modal-style" ng-controller="EnersysExpenseCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">ADVANCE REQUEST</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body">
		<form class="form-horizontal forms_request" name="advanceRequest" data-went="#/advances" method="post" url="services/expense_tracker/advances_add" novalidate>
            <input type="hidden" name="dept_name" value="{{advAdd.employee_dept}}" />
            <div class="row form-group">
            	<div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00A">Date Of Request</label>
                        <input value="{{CurrentDate | date:'dd-MM-yyyy'}}" name="date_of_request" readonly="readonly">
                    </md-input-container>
				</div>
                
                <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Employee ID</label>
                        <input value="{{advAdd.employee_Id}}" name="employee_Id" readonly="readonly">
                    </md-input-container>
				</div>
                
                 <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Employee Name</label>
                        <input value="{{advAdd.employee_Name}}" name="employee_name" readonly="readonly">
                    </md-input-container>
				 </div>
              </div>   
              <div class="row form-group">  
                 <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Grade</label>
                        <input value="{{advAdd.grade}}" name="grade" readonly="readonly">
                    </md-input-container>
				 </div>
                
                <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Credit Lmit:</label>
                        <input class="limitt" value="{{advAdd.credit_limit}}" name="credit_limit" readonly="readonly">
                    </md-input-container>
				 </div>
                
                 <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Previous Advances Not Settled (Amt):</label>
                        <input value="{{advAdd.prev_amount}}" name="prev_adv" readonly="readonly" class="tamfor">
                    </md-input-container>
				 </div>
               </div>
               <div class="row form-group">  
                  <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme">
                        <label for="input_00B">Current Request (Amt):</label>
                        <input value="" ng-model="currentrequest" name="current_request" id="location" class="amntDig tamfor" ng-keypress="onlyIntegers($event);" ng-keyup="onlyIntegers($event); currAmnt()" ng-focus="onlyIntegers($event)" autocomplete="off" required>
                    </md-input-container>
				  </div>
                  <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Toatl outstanding Advance (Current):</label>
                        <input value="" name="totalamt" readonly="readonly" class="tadv tamt">
<!--                        <input ng-if="advAdd.prev_amount!='No pending Advances'" value="{{advAdd.prev_amount1--currentrequest}}" name="totalamt" readonly="readonly" class="tadv">
-->                   
				 </md-input-container>
				 </div>
                <div class="col-sm-4">
                	<textarea rows="2" class="form-control resize-v" name="remarks" id="rem" placeholder="Reason/Remarks" required="required"></textarea>
                </div>  
               </div>
               <div class="row form-group" ng-if="advAdd.employee_dept!='3'">
					<div class="col-sm-4 filesRow" ng-controller="fileUploadCtrl">
                    	<label class="selectlabel">Tour Planning Report: <span style="color:red;">(Mandatory)</span></label>   <br />  
                    	<input value="{{file_name}}" class="form-control uploadFile" placeholder="Choose File" disabled="disabled" name="tplanningreport"/>
                        <div class="fileUpload btn btn-sm btn-info" tooltip="Upload" tooltip-placement="right">
                            <span class="ion ion-upload"></span>
                            <input type="file" class="upload uploadBtn tplanningreport" name="tplanningreport"  id="tplanningreport" onchange="angular.element(this).scope().file_load_exp(this.files)"/>
                        </div></br>
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
                            	<tr ng-repeat="exp in advAdd.advancesaddDetails">
                                	<td>{{exp.request_id}}</td>
                                	<td>{{exp.total_amount}}</td>
                                	<td>{{exp.requested_date}}</td>
                                	<td>{{exp.approved_by}}</td>
                                </tr>
                                <tfoot ng-if="advAdd.advancesaddDetails.length=='0'"><tr><td>No Records</td></tr></tfoot>
                           </tbody>
                        </table>
                        <!-- #end data table -->	
                    </div>
               </div>
                <div class="row form-group"> 
                    <div class="col-sm-6 col-sm-offset-5 mt10">
                         <button type="submit" class="btn btn-info btn-sm"  ng-click="sendAdvRequest('req')">Request Advance</button>
                         <button type="submit" class="btn btn-info btn-sm" ng-click="sendAdvRequest('draft')">Draft</button>
                    </div>
                </div> 
		</form>
        </div>
	</div>
</div>