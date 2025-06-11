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
.locCon{border:1px solid #eee;}
</style>
<div class="modal-style" ng-controller="oth_O_AddCtrl">	
	<div class="modal-header clearfix">
		<h4 class="modal-title">ADD OTHERS</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body">
		<form class="form-horizontal forms_update" name="expenseRequest" method="post" url="services/expense_tracker/oth_oth_single_add" ng-submit="addRequest()" novalidate>
            <input type="hidden" name="alias" value="{{expAlias}}">
            <div ng-controller="addFieldsExpCtrl" class="row form-group padding-10">
              <div class="col-sm-12">
               <div class="row form-group" ng-repeat="field in forms">  
                   <div class="panel panel-info mb10" ng-repeat="(key,type) in field.itemtype">
                        <div class="panel-heading" style="padding:7px 18px;">
                            <span>Others {{expenseViews.exp_oth_count+key+1}} <a href="" ng-click="removeExp(key,field)" class="delLoc right"><span class="ion ion-android-delete fnt-20" style="line-height:1;"></span></a></span>
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
            <div class="row form-group"> 
                <div class="col-sm-6 col-sm-offset-5 mt10">
                      <button type="submit" class="btn btn-info btn-sm">Submit</button>
                </div>
            </div>   
          </form> 
		</div>
	</div>
</div>
<script>
setInterval(function(){$('.SlectBox').SumoSelect();
$('.forms_update').find('.SumoSelect').addClass('singleSelect');},0);
</script>