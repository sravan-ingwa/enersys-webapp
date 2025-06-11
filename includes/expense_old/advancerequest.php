<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-6{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.datepicker {border-bottom: 1px solid #efefef !important;}
</style>
<div class="modal-style">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">ADVANCE REQUEST</h4>
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
                        <input value="ANUSHA" disabled class="ng-pristine ng-valid md-input ng-touched" id="input_00B" tabindex="0" aria-invalid="false">
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
                
                 <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Previous Advances Not Settled (Amt):</label>
                        <input value="No Pending Advances" disabled class="ng-pristine ng-valid md-input ng-touched" id="input_00B" tabindex="0" aria-invalid="false">
                    </md-input-container>
				 </div>
                 
                 <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme">
                        <label for="input_00B">Current Request (Amt):</label>
                        <input ng-model="currentrequest" class="ng-pristine ng-valid md-input ng-touched" id="input_00B" tabindex="0" aria-invalid="false">
                    </md-input-container>
				 </div>
               </div>
               <div class="row form-group">  
                  <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Toatl Outstanding Advance + Current Request</label>
                        <input value="Total Advance" disabled class="ng-pristine ng-valid md-input ng-touched" id="input_00B" tabindex="0" aria-invalid="false">
                    </md-input-container>
				 </div>
               
                <div class="col-sm-4">
                	<md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00B">Credit Limit</label>
                        <input value="10000" disabled class="ng-pristine ng-valid md-input ng-touched" id="input_00B" tabindex="0" aria-invalid="false">
                    </md-input-container>
				</div>
                <div class="col-sm-4">
                	<textarea rows="2" class="form-control resize-v" placeholder="Reason/Remarks"></textarea>
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
                        </table>
        
                        <div class="div-table-content">
                            <table class="table table-condensed">
                                <tbody>
                                    <tr><td>No Balance Advance</td></tr>
                               </tbody>
                            </table>
                        </div>
                        <!-- #end data table -->	
                    </div>
               </div>
                <div class="row form-group"> 
                    <div class="col-sm-6 col-sm-offset-5 mt10">
                         <button class="btn btn-info btn-sm">Request Advance</button>
                         <button class="btn btn-info btn-sm">Draft</button>
                    </div>
                </div>    
			</div>
		</form>
	</div>
</div>