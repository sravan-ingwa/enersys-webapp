<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
</style>
<div class="modal-style" ng-controller="EnersysExpenseCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Advance Limits</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body">
        <form class="form-horizontal forms_request" name="limitsForm" data-went="#/limits" method="post" url="services/expense_tracker/limit_add" ng-submit="sendRequest()" novalidate>
            <div class="row form-group">
                 <div class="col-sm-10 col-sm-offset-1" ng-controller="desDropCntrl">
                      <label class="selectlabel">Designation :</label>
                      <select class="form-control selectdrop testSelAll2" multiple name="designation_alias[]" ng-model="designation" placeholder="Designation" required>
                         <!--<option value="" selected="">Designation</option>-->
                         <option ng-repeat="designation in firstDrop" value="{{designation.alias}}">{{designation.name}}</option>
                    </select>
                    <span class="help-block" ng-show="limitsForm.designation_alias.$dirty && limitsForm.designation_alias.$invalid">
                        <span ng-show="limitsForm.designation_alias.$error.required">Designation is Required</span>
                    </span>
                </div>
                
                <div class="col-sm-10 col-sm-offset-1">
                    <md-input-container flex="" class="md-default-theme">
                        <label for="input_00D">Amount</label>
                        <input ng-model="amount" name="limit_amount" class="amntDig"  ng-keypress="onlyIntegers($event)" ng-keyup="onlyIntegers($event);" ng-focus="onlyIntegers($event)"  required="required">
                    </md-input-container>
                    <span class="help-block" ng-show="limitsForm.limit_amount.$dirty && limitsForm.limit_amount.$invalid">
                        <span ng-show="limitsForm.limit_amount.$error.required">Amount is Required</span>
                    </span>
                </div>
                 <div class="col-sm-6 col-sm-offset-4">
                        <button type="submit" class="btn btn-info btn-sm" click-once ng-disabled="limitsForm.$invalid || limitsForm.$pristine">Add Advance Limit</button>
                        <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose()">Close</button>
                </div>
            </div>
       </form>   
	</div>
</div>

<script>
setInterval(function(){$('.testSelAll2').SumoSelect({selectAll: true});
$('.forms_request').find('.SumoSelect').addClass('singleSelect');},0);
</script>