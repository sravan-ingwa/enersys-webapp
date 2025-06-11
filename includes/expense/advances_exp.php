<style>
.form-group {margin-bottom:0px !important;}
.modal-header > .close {right:-30px; top:-12px;}
.datepicker {border-bottom: 1px solid #efefef !important;}
.upload-file {border-bottom: 1px solid rgba(0,0,0,0.12); padding-top: 9px;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
</style>
<div class="modal-style" ng-controller="EnersysExpenseCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">EXPORT ADVANCES</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body">
		<form class="form-horizontal forms_request" name="advanceRequest" data-went="#/advances" method="post" url="services/expense_tracker/advances_export" ng-submit="sendRequest()" novalidate>
			<div class="row form-group" ng-controller="DatepickerDemoCtrl">
            	<div class="col-sm-6">
                    <md-input-container flex="" class="md-default-theme">
                        <label for="input_00D">Visit Start Date</label>
                        <input type="text" ng-model="Startddate" name="start_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="dateCal('sdate','edate');open($event,'opened1')"/>
                   </md-input-container>
                </div>	
                <div class="col-sm-6">
                    <md-input-container flex="" class="md-default-theme">
                        <label for="input_00E">Visit End Date</label>
                        <input type="text" ng-model="Enddate" name="end_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="dateCal('sdate','edate');open($event,'opened2')">
                    </md-input-container>
                </div>
                <div class="col-sm-6">
                	<md-input-container flex="" class="md-default-theme">
                        <label for="input_00B">Amount</label>
                        <input name="amount" value="">
                    </md-input-container>
				</div>
                <div ng-controller="empnameexpDropCtrl">
                    <div class="col-sm-6">
					<label class="selectlabel">Approver Level</label>
                         <select name="aplevel" class="form-control selectdrop SlectBox" ng-model="aplevel" ng-init="dep_drop(aplevel)" id="appr_change">
                            <option value="">All</option>
                            <option ng-repeat="aplevels in firstDrop" value="{{aplevels.alias}}">{{aplevels.name}}</option>
                        </select>
                    </div>  
                    
                    
                    <!--<div ng-controller="appDropCntrl" ng-if="expenses.eadmin != 'eadmin' && expenses.eadmin != 'admin'">
                        <select name="aplevel" class="selectdrop form-control" ng-model="aplevel" ng-init="dep_drop(aplevel)" id="appr_change">
                            <option value="">All</option>
                            <option ng-repeat="aplevels in firstDrop" value="{{aplevels.alias}}">{{aplevels.name}}</option>
                        </select>			
                    </div>
                    <div ng-controller="admnappDropCntrl" ng-if="expenses.eadmin == 'admin' || expenses.eadmin=='eadmin'">
                        <select name="aplevel" class="selectdrop form-control" ng-model="aplevel" ng-init="dep_drop(aplevel)" id="appr_change">
                            <option value="">All</option>
                            <option ng-repeat="aplevels in firstDrop" value="{{aplevels.alias}}">{{aplevels.name}}</option>
                        </select>
                    <div>-->

                    
                    
                    
                                      
                        <div class="col-sm-12" ng-if="aplevel != '0' && secondDrop.alias!='0'">
                             <label class="selectlabel">Employee Name</label>
                             <select name="apl" class="form-control selectdrop SlectBox" ng-model="apl">
                                <option value="">All</option>
                                <option ng-repeat="emp in secondDrop" name="employees" value="{{emp.alias}}">{{emp.name}}</option>
                            </select>
                        </div>
                         <div class="col-sm-12" ng-if="aplevel == '0' && secondDrop.alias!='0'">
                             <input type="hidden" value="{{secondDrop.draft_alias}}" name="apl"/>
                         	<md-input-container flex="" class="md-default-theme md-input-has-value">
                             <label class="">Employee Name</label>
                             <input type="text" name="employees" value="{{secondDrop.draft_name}}" readonly="readonly"/>
                            </md-input-container>
                        </div>
                        
                    </div>
                
              </div>   
                <div class="row form-group"> 
                    <div class="col-sm-6 col-sm-offset-5 mt10">
                         <button type="submit" class="btn btn-info btn-sm">Export</button>
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
