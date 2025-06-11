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
<div ng-controller="EnersysExpenseCtrl">
<div class="modal-style" ng-controller="LimitsCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix" >
		<h4 class="modal-title">Update Limits</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body">
        <form class="form-horizontal forms_request" name="limitseditForm" data-went="#/limits" method="post" url="services/expense_tracker/limit_update" ng-submit="sendRequest()" novalidate>
                <input type="hidden" name="limit_alias" value="{{expenseViews.limit_alias}}" />
                <div class="row form-group">
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Designation</label>
                            <input name="designation_alias" value="{{expenseViews.designation_alias}}" readonly>
                        </md-input-container>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Amount</label>
                            <input name="limit_amount" class="amntDig"  ng-keypress="onlyIntegers($event)" ng-keyup="onlyIntegers($event);" ng-focus="onlyIntegers($event)" ng-model="expenseViews.limit_amount" value="{{expenseViews.limit_amount}}" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="limitseditForm.limit_amount.$dirty && limitseditForm.limit_amount.$invalid">
                            <span ng-show="limitseditForm.limit_amount.$error.required">Amount is Required</span>
                        </span>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm" 
                            ng-disabled="limitseditForm.limit_amount.$dirty && limitseditForm.limit_amount.$invalid">Update</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose();">Close</button>
                    </div>
               </div>
          </form>   
	</div>
</div>

</div>
<script>
setInterval(function(){$('.testSelAll2').SumoSelect();
$('.forms_request').find('.SumoSelect').addClass('singleSelect');},0);
</script>