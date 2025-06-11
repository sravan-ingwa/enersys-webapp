<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-6{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.datepicker {border-bottom: 1px solid #efefef !important;}
table > tbody > tr > td {text-align:center !important;}
.tbform input[type="text"], .tbform input[type="file"], .tbform select {border: none !important;text-align:center;margin: 0 !important;padding: 0 !important;width: 100% !important;outline: none !important;webkit-box-shadow: none;box-shadow: none;}
</style>
<div class="modal-style">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">SUBMIT EXPENSES</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body">
		<form class="form-horizontal" name="modal-demo-form" action="javascript:;" novalidate>
			<div class="row form-group">
            	<div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00A">Date Of Request</label>
                        <input value="03-Jun-2015" disabled class="ng-pristine ng-valid md-input ng-touched" id="input_00A" tabindex="0" aria-invalid="false">
                    </md-input-container>
				</div>
                
                <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Employee ID</label>
                        <input value="E00034" disabled class="ng-pristine ng-valid md-input ng-touched" id="input_00B" tabindex="0" aria-invalid="false">
                    </md-input-container>
				</div>
                
                 <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Employee Name</label>
                        <input value="MANI RAJ" disabled class="ng-pristine ng-valid md-input ng-touched" id="input_00B" tabindex="0" aria-invalid="false">
                    </md-input-container>
				 </div>
              </div>   
              <div class="row form-group">  
                 <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Grade</label>
                        <input value="S2" disabled class="ng-pristine ng-valid md-input ng-touched" id="input_00B" tabindex="0" aria-invalid="false">
                    </md-input-container>
				 </div>
                
                 <div class="col-sm-4"  ng-controller="DatepickerDemoCtrl">
                	<md-input-container flex="" class="md-default-theme">
                        <label for="input_00B">Visit Start Date</label>
                        <input type="text" ng-model="stratdate" class="form-control datepicker border-bottom " placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" ng-model="dt" is-open="opened" min-date="minDate" max-date="'2025-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>                                              
                    </md-input-container>
				 </div>
                 
                 <div class="col-sm-4"  ng-controller="DatepickerDemoCtrl">
                	<md-input-container flex="" class="md-default-theme">
                        <label for="input_00B">Visit End Date</label>
                        <input type="text" ng-model="enddate" class="form-control datepicker border-bottom " placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" ng-model="dt" is-open="opened" min-date="minDate" max-date="'2025-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>                                              
                    </md-input-container>
				 </div>
               </div>
               <div class="row form-group">  
                  <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">No.Of Days</label>
                        <input value="No.Of Days" disabled class="ng-pristine ng-valid md-input ng-touched" id="input_00B" tabindex="0" aria-invalid="false">
                    </md-input-container>
				 </div>
               
                <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme">
                        <label for="input_00B">Visited Place's</label>
                        <input ng-model="visitedplaces" class="ng-pristine ng-valid md-input ng-touched" id="input_00B" tabindex="0" aria-invalid="false">
                    </md-input-container>
				</div>
                <div class="col-sm-4">
                	<textarea rows="2" class="form-control resize-v" placeholder="Purpose"></textarea>
                </div>   
               </div>
               <div class="row form-group">  
                   <label>Conveyance :</label>
                   <a href="" class="text-info">
                      <span class="ion ion-plus-circled"></span>
                      New Field
                   </a>
                   <div class="panel panel-default">
                        <table class="table table-condensed" >
                            <thead>
                            <tr>
                                <th>Date of travel</th>
                                <th>Mode of travel</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Amount</th>
                                <th>Files</th>
                            </tr>
                            </thead>
                        </table>
        
                        <div class="div-table-content">
                            <table class="table table-condensed">
                                <tbody>
                                    <tr class="tbform">
                                    	<td ng-controller="DatepickerDemoCtrl">                    
                                            <input type="text" ng-model="stratdate" class="form-control datepicker border-bottom " placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" ng-model="dt" is-open="opened" min-date="minDate" max-date="'2025-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>                                              
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
                                        <td><input type="hidden" class="form-control" name="motbill[]" value="0"><input type="file" class="form-control" name="motbill[]"></td>
                                    </tr>
                               </tbody>
                            </table>
                        </div>
                        <!-- #end data table -->	
                    </div>
                    <div class="col-md-4 right">
                     <md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B"></label>
                        <input value="Total Conveyance" disabled class="ng-pristine ng-valid md-input ng-touched" id="input_00B" tabindex="0" aria-invalid="false">
                     </md-input-container>
                    </div>
               </div>
               <div class="row form-group">  
                   <label>Lodging :</label>
                   <a href="" class="text-info">
                      <span class="ion ion-plus-circled"></span>
                      New Field
                   </a>
                   <div class="panel panel-default">
                        <table class="table table-condensed" >
                            <thead>
                            <tr>
                                <th>Type of Stay</th>
                                <th>Visit:Start Date:</th>
                                <th>Visit: End Date:</th>
                                <th>Hotel Name</th>
                                <th>Amount</th>
                                <th>Files</th>
                            </tr>
                            </thead>
                        </table>
        
                        <div class="div-table-content">
                            <table class="table table-condensed">
                                <tbody>
                                    <tr class="tbform">
                                    	<td>
                                        	<select class="form-control" tabindex="1" required="required">
                                                <option value="0">Reimbursement</option>
                                                <option value="self">Self</option>
                                            </select>
                                        </td>
                                    	<td ng-controller="DatepickerDemoCtrl">                    
                                            <input type="text" ng-model="stratdate" class="form-control datepicker border-bottom " placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" ng-model="dt" is-open="opened" min-date="minDate" max-date="'2025-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>                                              
										</td>
                                        <td ng-controller="DatepickerDemoCtrl">                    
                                            <input type="text" ng-model="enddate" class="form-control datepicker border-bottom " placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" ng-model="dt" is-open="opened" min-date="minDate" max-date="'2025-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>                                              
										</td>
                                        <td><input type="text" class="form-control" name="hotelname" placeholder="Hotel Name"></td>
                                        <td><input type="text" class="form-control" name="amount" placeholder="Amount"></td>
                                        <td><input type="hidden" class="form-control" name="motbill[]" value="0"><input type="file" class="form-control" name="motbill[]"></td>
                                    </tr>
                               </tbody>
                            </table>
                        </div>
                        <!-- #end data table -->	
                    </div>
                    <div class="col-md-4 right">
                     <md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B"></label>
                        <input value="Total Lodging" disabled class="ng-pristine ng-valid md-input ng-touched" id="input_00B" tabindex="0" aria-invalid="false">
                     </md-input-container>
                    </div>
               </div>
               <div class="row form-group">  
                   <label>Others :</label>
                   <a href="" class="text-info">
                      <span class="ion ion-plus-circled"></span>
                      New Field
                   </a>
                   <div class="panel panel-default">
                        <table class="table table-condensed" >
                            <thead>
                            <tr>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Files</th>
                            </tr>
                            </thead>
                        </table>
        
                        <div class="div-table-content">
                            <table class="table table-condensed">
                                <tbody>
                                    <tr class="tbform">
                                    	<td><input type="text" class="form-control" name="description" placeholder="Description"></td>
                                        <td><input type="text" class="form-control" name="amount" placeholder="Amount"></td>
                                    	<td ng-controller="DatepickerDemoCtrl">                    
                                            <input type="text" ng-model="date" class="form-control datepicker border-bottom " placeholder="DD-MM-YYYY" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" ng-model="dt" is-open="opened" min-date="minDate" max-date="'2025-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>                                              
										</td>
                                        <td><input type="hidden" class="form-control" name="motbill[]" value="0"><input type="file" class="form-control" name="motbill[]"></td>
                                    </tr>
                               </tbody>
                            </table>
                        </div>
                        <!-- #end data table -->	
                    </div>
                    <div class="col-md-4 right">
                     <md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B"></label>
                        <input value="0" disabled class="ng-pristine ng-valid md-input ng-touched" id="input_00B" tabindex="0" aria-invalid="false">
                     </md-input-container>
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
