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
		<h4 class="modal-title">Edit Allowances</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body">
        <form class="form-horizontal forms_request" name="othersEditForm" data-went="includes/settings/allowances/Others-allowances" method="post" url="services/expense_tracker/othallowances_edit" ng-submit="sendRequest()" novalidate>
        		<input type="hidden" name="allowance_alias" value="{{expenseViews.allowance_alias}}" />
                <div class="row form-group" ng-controller="gradeCntrl">
                    <div class="col-sm-4">
                        <label class="selectlabel">Grade</label>
                        <select placeholder="Grade" name="grade" class="form-control Selectbox" ng-init="exp_dep_drop(expenseViews.grade)" data-ng-change="grade(grades)" ng-model="grades" disabled="disabled">
                            <option value="" style="display:none" selected="selected">Grade</option>
                            <option ng-repeat="grade in firstDrop" value="{{grade.grade_name}}" ng-selected="grade.grade_name == expenseViews.grade">{{grade.grade_name}}</option>
                        </select>
                    </div>
                    <div class="col-sm-8">
                    	<label class="selectlabel">Designations</label>
                        <p style="font-size:11px;">{{expenseViews.designation}}</p>
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
                                        <option ng-repeat="mof in modeOfTravel" value="{{mof.name}}" ng-selected="expenseViews.mode_of_travel.indexOf(mof.name) != -1">{{mof.name}}</option>
                                    </select>
                                    <span class="help-block" ng-show="othersEditForm['mot[]'].$dirty && othersEditForm['mot[]'].$invalid">
                                          <span ng-show="othersEditForm['mot[]'].$error.required">Mode Of Travel is Required</span>
                                    </span>
                                </div>
                                
                                <div class="col-sm-4">
                                    <label class="selectlabel">Mode of Local Conveyance</label>
                                    <select placeholder="Mode of Local Conveyance" name="molc[]" class="Selectbox form-control" multiple ng-model="molcs" required>
                                        <option ng-repeat="mol in locOfTravel" value="{{mol.name}}" ng-selected="expenseViews.mode_of_conveyance.indexOf(mol.name) != -1">{{mol.name}}</option>
                                    </select>
                                    <span class="help-block" ng-show="othersEditForm['molc[]'].$dirty && othersEditForm['molc[]'].$invalid">
                                          <span ng-show="othersEditForm['molc[]'].$error.required">Mode of Local Conveyance is Required</span>
                                    </span>
                                </div>
                                <div class="col-sm-4">
                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                        <label for="input_00B">Mobile Charges</label>
                                        <input name="amt9" class="amntDig" ng-model="expenseViews.mobile_roaming" value="{{expenseViews.mobile_roaming}}" required>
                                    </md-input-container>
                                    <span class="help-block" ng-show="othersEditForm.amt9.$dirty && othersEditForm.amt9.$invalid">
                                          <span ng-show="othersEditForm.amt9.$error.required">Mobile Charges C is Required</span>
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
                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                        <label for="input_00B">A+</label>
                                        <input name="amt1" class="amntDig" ng-model="expenseViews.lodging_allowances_a1" value="{{expenseViews.lodging_allowances_a1}}" required>
                                    </md-input-container>
                                    <span class="help-block" ng-show="othersEditForm.amt1.$dirty && othersEditForm.amt1.$invalid">
                                          <span ng-show="othersEditForm.amt1.$error.required">A+ is Required</span>
                                    </span>
                                 </div>
                                 <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                        <label for="input_00B">A</label>
                                        <input name="amt2" class="amntDig" ng-model="expenseViews.lodging_allowances_a" value="{{expenseViews.lodging_allowances_a}}" required>
                                    </md-input-container>
                                    <span class="help-block" ng-show="othersEditForm.amt2.$dirty && othersEditForm.amt2.$invalid">
                                          <span ng-show="othersEditForm.amt2.$error.required">A is Required</span>
                                    </span>
                                 </div>
                                 <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                        <label for="input_00B">B</label>
                                        <input name="amt3" class="amntDig" ng-model="expenseViews.lodging_allowances_b" value="{{expenseViews.lodging_allowances_b}}" required>
                                    </md-input-container>
                                    <span class="help-block" ng-show="othersEditForm.amt3.$dirty && othersEditForm.amt3.$invalid">
                                          <span ng-show="othersEditForm.amt3.$error.required">B is Required</span>
                                    </span>
                                 </div>
                                 <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                        <label for="input_00B">C</label>
                                        <input name="amt4" class="amntDig" ng-model="expenseViews.lodging_allowances_c" value="{{expenseViews.lodging_allowances_c}}" required>
                                    </md-input-container>
                                    <span class="help-block" ng-show="othersEditForm.amt4.$dirty && othersEditForm.amt4.$invalid">
                                          <span ng-show="othersEditForm.amt4.$error.required">C is Required</span>
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
                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                        <label for="input_00B">A+</label>
                                        <input name="amt5" class="amntDig" ng-model="expenseViews.boarding_allowances_a1" value="{{expenseViews.boarding_allowances_a1}}" required>
                                    </md-input-container>
                                    <span class="help-block" ng-show="othersEditForm.amt5.$dirty && othersEditForm.amt5.$invalid">
                                          <span ng-show="othersEditForm.amt5.$error.required">A+ is Required</span>
                                    </span>
                                 </div>
                                 <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                        <label for="input_00B">A</label>
                                        <input name="amt6" class="amntDig" ng-model="expenseViews.boarding_allowances_a" value="{{expenseViews.boarding_allowances_a}}" required>
                                    </md-input-container>
                                    <span class="help-block" ng-show="othersEditForm.amt6.$dirty && othersEditForm.amt6.$invalid">
                                          <span ng-show="othersEditForm.amt6.$error.required">A is Required</span>
                                    </span>
                                 </div>
                                 <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                        <label for="input_00B">B</label>
                                        <input name="amt7" class="amntDig" ng-model="expenseViews.boarding_allowances_b" value="{{expenseViews.boarding_allowances_b}}" required>
                                    </md-input-container>
                                    <span class="help-block" ng-show="othersEditForm.amt7.$dirty && othersEditForm.amt7.$invalid">
                                          <span ng-show="othersEditForm.amt7.$error.required">B is Required</span>
                                    </span>
                                 </div>
                                 <div class="col-sm-3">
                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                        <label for="input_00B">C</label>
                                        <input name="amt8" class="amntDig" ng-model="expenseViews.boarding_allowances_c" value="{{expenseViews.boarding_allowances_c}}" required>
                                    </md-input-container>
                                    <span class="help-block" ng-show="othersEditForm.amt8.$dirty && othersEditForm.amt8.$invalid">
                                          <span ng-show="othersEditForm.amt8.$error.required">C is Required</span>
                                    </span>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                  <div class="col-sm-6 col-sm-offset-5">
                    <button type="submit" click-once class="btn btn-info btn-sm"
                    ng-disabled="othersEditForm['mot[]'].$dirty && othersEditForm['mot[]'].$invalid ||
                    othersEditForm['molc[]'].$dirty && othersEditForm['molc[]'].$invalid ||
                    othersEditForm.amt9.$dirty && othersEditForm.amt9.$invalid ||
                    othersEditForm.amt1.$dirty && othersEditForm.amt1.$invalid ||
                    othersEditForm.amt2.$dirty && othersEditForm.amt2.$invalid ||
                    othersEditForm.amt3.$dirty && othersEditForm.amt3.$invalid ||
                    othersEditForm.amt4.$dirty && othersEditForm.amt4.$invalid ||
                    othersEditForm.amt5.$dirty && othersEditForm.amt5.$invalid ||
                    othersEditForm.amt6.$dirty && othersEditForm.amt6.$invalid ||
                    othersEditForm.amt7.$dirty && othersEditForm.amt7.$invalid ||
                    othersEditForm.amt8.$dirty && othersEditForm.amt8.$invalid">Update</button>
                    
                    <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose();">Close</button>
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