<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:0px;}
.modal-header > .close {right:-30px; top:-12px;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
.panel-heading{padding:7px 15px;}
</style>
<div ng-controller="EnersysExpenseCtrl">
<div class="modal-style" ng-controller="OthersCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Add Allowances</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body">
        <form class="form-horizontal forms_request" name="othersForm" data-went="includes/settings/allowances/Others-allowances" method="post" url="services/expense_tracker/othallowances_add" ng-submit="sendRequest()" novalidate>
        		<input type="hidden" name="allowance_alias" value="{{expenseViews.allowance_alias}}" />
                <div class="row form-group" ng-controller="gradeCntrl">
                    <div class="col-sm-4">
                        <label class="selectlabel">Grade</label>
                        <select placeholder="Grade" name="grade" class="form-control Selectbox" data-ng-change="grade(grades)" ng-model="grades" required>
                            <option value="" style="display:none" selected="selected">Grade</option>
                            <option ng-repeat="grade in firstDrop" value="{{grade.grade_name}}">{{grade.grade_name}}</option>
                        </select>
                        <span class="help-block" ng-show="othersForm.grade.$dirty && othersForm.grade.$invalid">
                              <span ng-show="othersForm.grade.$error.required">Grade is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-8">
                    	<label class="selectlabel">Designations</label>
                        <p style="font-size:11px;" ng-if="!grades">Select grade to Know designations</p>
                        <p style="font-size:11px;" ng-if="grades">{{expenseViews.designation}}</p>
                    </div>
                </div>
                <div class="row form-group" >
                    <div class="col-sm-12">
                        <div class="panel mb20 panel-info panel-hovered">
                            <div class="panel-heading text-center">OTHERS</div>
                            <div class="panel-body">
                                 <div class="col-sm-4">
                                    <label class="selectlabel">Mode Of Travel</label>
                                    <select placeholder="Mode Of Travel" name="mot[]" class="Selectbox form-control" multiple ng-model="mots" required>
                                        <option ng-repeat="mof in modeOfTravel" value="{{mof.name}}">{{mof.name}}</option>
                                    </select>
                                    <span class="help-block" ng-show="othersForm['mot[]'].$dirty && othersForm['mot[]'].$invalid">
                                          <span ng-show="othersForm['mot[]'].$error.required">Mode Of Travel is Required</span>
                                    </span>
                                </div>
                                
                                <div class="col-sm-4">
                                    <label class="selectlabel">Mode of Local Conveyance</label>
                                    <select placeholder="Mode of Local Conveyance" name="molc[]" class="Selectbox form-control" multiple ng-model="molcs" required>
                                        <option ng-repeat="mol in locOfTravel" value="{{mol.name}}">{{mol.name}}</option>
                                    </select>
                                    <span class="help-block" ng-show="othersForm['molc[]'].$dirty && othersForm['molc[]'].$invalid">
                                          <span ng-show="othersForm['molc[]'].$error.required">Mode of Local Conveyance is Required</span>
                                    </span>
                                </div>
                                <div class="col-sm-4">
                                    <md-input-container flex="" class="md-default-theme">
                                        <label for="input_00B">Mobile Charges</label>
                                        <input name="amt9" class="amntDig" ng-model="amt9" required>
                                    </md-input-container>
                                    <span class="help-block" ng-show="othersForm.amt9.$dirty && othersForm.amt9.$invalid">
                                          <span ng-show="othersForm.amt9.$error.required">Mobile Charges C is Required</span>
                                    </span>
                                 </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="panel mb20 panel-info panel-hovered">
                            <div class="panel-heading text-center">LODGING ALLOWANCES</div>
                            <div class="panel-body">
                                <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme">
                                        <label for="input_00B">A+</label>
                                        <input name="amt1" class="amntDig" ng-model="amt1" required>
                                    </md-input-container>
                                    <span class="help-block" ng-show="othersForm.amt1.$dirty && othersForm.amt1.$invalid">
                                          <span ng-show="othersForm.amt1.$error.required">A+ is Required</span>
                                    </span>
                                 </div>
                                 <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme">
                                        <label for="input_00B">A</label>
                                        <input name="amt2" class="amntDig" ng-model="amt2" required>
                                    </md-input-container>
                                    <span class="help-block" ng-show="othersForm.amt2.$dirty && othersForm.amt2.$invalid">
                                          <span ng-show="othersForm.amt2.$error.required">A is Required</span>
                                    </span>
                                 </div>
                                 <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme">
                                        <label for="input_00B">B</label>
                                        <input name="amt3" class="amntDig" ng-model="amt3" required>
                                    </md-input-container>
                                    <span class="help-block" ng-show="othersForm.amt3.$dirty && othersForm.amt3.$invalid">
                                          <span ng-show="othersForm.amt3.$error.required">B is Required</span>
                                    </span>
                                 </div>
                                 <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme">
                                        <label for="input_00B">C</label>
                                        <input name="amt4" class="amntDig" ng-model="amt4" required>
                                    </md-input-container>
                                    <span class="help-block" ng-show="othersForm.amt4.$dirty && othersForm.amt4.$invalid">
                                          <span ng-show="othersForm.amt4.$error.required">C is Required</span>
                                    </span>
                                 </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="panel mb20 panel-info panel-hovered">
                            <div class="panel-heading text-center">DAILY/BOARDING ALLOWANCES</div>
                            <div class="panel-body">
                                <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme">
                                        <label for="input_00B">A+</label>
                                        <input name="amt5" class="amntDig" ng-model="amt5" required>
                                    </md-input-container>
                                    <span class="help-block" ng-show="othersForm.amt5.$dirty && othersForm.amt5.$invalid">
                                          <span ng-show="othersForm.amt5.$error.required">A+ is Required</span>
                                    </span>
                                 </div>
                                 <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme">
                                        <label for="input_00B">A</label>
                                        <input name="amt6" class="amntDig" ng-model="amt6" required>
                                    </md-input-container>
                                    <span class="help-block" ng-show="othersForm.amt6.$dirty && othersForm.amt6.$invalid">
                                          <span ng-show="othersForm.amt6.$error.required">A is Required</span>
                                    </span>
                                 </div>
                                 <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme">
                                        <label for="input_00B">B</label>
                                        <input name="amt7" class="amntDig" ng-model="amt7" required>
                                    </md-input-container>
                                    <span class="help-block" ng-show="othersForm.amt7.$dirty && othersForm.amt7.$invalid">
                                          <span ng-show="othersForm.amt7.$error.required">B is Required</span>
                                    </span>
                                 </div>
                                 <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme">
                                        <label for="input_00B">C</label>
                                        <input name="amt8" class="amntDig" ng-model="amt8" required>
                                    </md-input-container>
                                    <span class="help-block" ng-show="othersForm.amt8.$dirty && othersForm.amt8.$invalid">
                                          <span ng-show="othersForm.amt8.$error.required">C is Required</span>
                                    </span>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                  <div class="col-sm-6 col-sm-offset-5">
                    <button type="submit" click-once class="btn btn-info btn-sm" ng-disabled="othersForm.$invalid || othersForm.$pristine">Submit</button>
                    <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose()">Close</button>
                  </div>
               </div>
          </form>   
	</div>
</div>
</div>
<script>
setInterval(function(){$('.Selectbox').SumoSelect();
$('.forms_request').find('.SumoSelect').addClass('singleSelect');},0);
$(document).on("keypress keyup focus",".amntDig",function (event) {    
	$(this).val($(this).val().replace(/[^0-9\.]/g,''));
		if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
			event.preventDefault();
	}
});
</script>