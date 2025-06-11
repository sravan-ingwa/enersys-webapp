<style>
.form-group {margin-bottom:0px !important;}
.form-group div.col-sm-6{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.datepicker {border-bottom: 1px solid #efefef !important;}
.upload-file {border-bottom: 1px solid rgba(0,0,0,0.12); padding-top: 9px;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
</style>
<div class="modal-style" ng-controller="mainexpCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">EDIT EXPENSE DETAILS</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body" ng-controller="updatingCntrl">
		<form class="form-horizontal forms_update" name="advanceRequest" method="post" url="services/expense_tracker/expense_main_edit" ng-submit="upadteRequest()" novalidate>
           <input type="hidden" value="{{editViews.expenses_alias}}" name="expenses_alias" />
           <input type="hidden" value="{{editViews.empdept}}" name="empdept" />
            <input type="hidden" value="{{editViews.ref2}}" name="ref2" />
            <input type="hidden" value="{{editViews.remark_alias}}" name="remark_alias" />
           <div class="row form-group">
            <div ng-controller="DatepickerDemoCtrl"> 
                <div class="col-sm-3">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00D">Visit Start Date</label>
                        <input type="text" value="{{editViews.period_of_visit_from}}" ng-model="editViews.period_of_visit_from" readonly="readonly" name="visitFromDate" class="" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"  data-ng-focus="dateCal();open($event,'opened1')"/>
                   </md-input-container>
                </div>	
                <div class="col-sm-3">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                        <label for="input_00E">Visit End Date</label>
                        <input type="text" value="{{editViews.places_of_visit_to}}" ng-model="editViews.places_of_visit_to" readonly="readonly" name="visitToDate" class="" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="pr" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" ng-init="dateNights()" data-ng-focus="dateCal();open($event,'opened2')">
                    </md-input-container>
                </div>
            </div>  
            <div class="col-sm-3">
                <md-input-container flex="" class="md-default-theme md-input-has-value">
                    <label for="input_00B">No.Of Days</label>
                    <input value="{{editViews.no_of_days}}" id="num_nights" readonly="readonly">
                </md-input-container>
            </div>
            <div class="col-sm-3">
                <md-input-container flex="" class="md-default-theme md-input-has-value">
                    <label for="input_00B">Visited Place's</label>
                    <input value="{{editViews.places_of_visit}}" name="placesOfVisit">
                </md-input-container>
            </div>
            <div class="col-sm-3">
                <textarea rows="3" class="form-control resize-v" name="purpose" placeholder="Purpose">{{editViews.purpose}}</textarea>
            </div>    
            <div class="col-sm-3">
                <textarea rows="3" class="form-control resize-v" name="remarks" placeholder="Remarks">{{editViews.remarkss}}</textarea>
            </div> 
            <div class="col-sm-3 filesRow margin-none" ng-controller="fileUploadCtrl" ng-if="editViews.empdept != '3'">
                <label class="selectlabel">Tour Planning Report: <span style="color:red;">(Mandatory)</span></label>  
                 <input type="hidden" name="tplanningreport_old" value="{{editViews.hidden_report}}"/>                    
                 <a href="{{editViews.report}}" target="_blank" ng-if="editViews.hidden_report!='' && editViews.hidden_report!='0'" style="color:red;">Click</a><br /> 
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
           <div class="row form-group mt10" ng-if="editViews.service_dept_onroll == 1" ng-init="dprreadViews1(editViews.period_of_visit_from,editViews.places_of_visit_to,editViews.empalias)">  
                <div class="col-lg-12 dprDetails">
                    <label>DPR Details : </label>
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
                        <tfoot ng-if="dprViews.dprDetails.length=='0'"><tr><td colspan="5">No Records</td></tr></tfoot>
                    </table>
                </div>
           </div>
           <div class="row form-group"> 
                <div class="col-sm-6 col-sm-offset-5 mt10">
                      <button type="submit" class="btn btn-info btn-sm">Update</button>
                </div>
           </div>   
           </form> 
		</div>
</div>
<script>
setInterval(function(){$('.SlectBox').SumoSelect();
$('.forms_update').find('.SumoSelect').addClass('singleSelect');},0);
</script>