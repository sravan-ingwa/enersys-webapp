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
<div class="modal-style" ng-controller="escaEditCntl">
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit ESCA</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" reset-directive="singleViews" name="escaForm" data-went="#/settings/esca/esca_view" method="post" url="services/settings/esca_update" ng-submit="sendPost()" novalidate>
                <input type="hidden" value="{{singleViews.esca_alias}}" name="esca_alias">
                <div class="row form-group">
                	<div ng-controller="zoneStateMulCntrl">
                        <div class="col-sm-6">
                            <label class="selectlabel">Zone</label>
                            <select multiple="multiple" placeholder="Zone" name="zone_alias[]" class="testSelAll2 form-control" ng-model="zones" ng-init="dep_drop(singleViews.zone_alias,'state_alias[]')" data-ng-change="dep_drop_mul()" required="required">
                                <option ng-repeat="zone in firstDrop" value="{{zone.alias}}"  ng-selected="singleViews.zone_alias.indexOf(zone.alias) != -1">{{zone.name}}</option>
                            </select>
                             <span class="help-block" ng-show="escaForm['zone_alias[]'].$dirty && escaForm['zone_alias[]'].$invalid">
                                <span ng-show="escaForm['zone_alias[]'].$error.required">Select Zone</span>
                            </span>
                        </div>
                        <div class="col-sm-6">
                            <label class="selectlabel">State</label>
                            <select class="form-control testSelAll2" placeholder="State" name="state_alias[]" id="state" ng-model="states" multiple="multiple" required="required">
                                <option ng-repeat="state in secondDrop" value="{{state.alias}}"ng-selected="singleViews.state_alias.indexOf(state.alias) != -1">{{state.name}}</option>
                            </select>
                             <span class="help-block" ng-show="escaForm['state_alias[]'].$dirty && escaForm['state_alias[]'].$invalid">
                                <span ng-show="escaForm['state_alias[]'].$error.required">Select State</span>
                            </span>
                        </div>
                    </div>
                   </div>
                   <div class="row form-group"> 
                    <div class="col-sm-6">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Esca ID</label>
                            <input ng-model="singleViews.esca_id" value="{{singleViews.esca_id}}" class="ng-pristine ng-valid md-input ng-touched" name="esca_id" id="input_00A" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="escaForm.esca_id.$dirty && escaForm.esca_id.$invalid">
                            <span ng-show="escaForm.esca_id.$error.required">Esca ID is required.</span>
                        </span>
                    </div>
                    <div class="col-sm-6">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Esca Name</label>
                            <input ng-model="singleViews.esca_name" value="{{singleViews.esca_name}}" class="ng-pristine ng-valid md-input ng-touched" name="esca_name" id="input_00A" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="escaForm.esca_name.$dirty && escaForm.esca_name.$invalid">
                            <span ng-show="escaForm.esca_name.$error.required">Esca Name is required.</span>
                        </span>
                    </div>
                   </div>
                   <div class="row form-group"> 
                    <div class="col-sm-6">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Esca Number</label>
                            <input ng-model="singleViews.esca_number" value="{{singleViews.esca_number}}" class="ng-pristine ng-valid md-input ng-touched" name="esca_number" ng-pattern="/^[0-9]{1,10}$/" id="input_00A" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="escaForm.esca_number.$dirty && escaForm.esca_number.$invalid">
                            <span ng-show="escaForm.esca_number.$error.required">Esca Number is required.</span>
                            <span ng-show="escaForm.esca_number.$error.pattern">Esca Number should be 10 digits only.</span>
                        </span>
                    </div>
                    <div class="col-sm-6">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Esca Email</label>
                            <input type="text" ng-model="singleViews.esca_email" value="{{singleViews.esca_email}}" class="ng-pristine ng-valid md-input ng-touched" name="esca_email"  ng-pattern="/^(([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+([;,.](([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+)*$/" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="escaForm.esca_email.$dirty && escaForm.esca_email.$invalid">
                            <span ng-show="escaForm.esca_email.$error.required">Esca Email is required.</span>
                            <span ng-show="escaForm.esca_email.$error.pattern">Invalid Email Address</span>
                        </span>
                    </div>
                   </div>
                   <div class="row form-group" ng-if="singleViews.emp_alias=='ADMIN'">
                        <div class="col-sm-6">
                            <label class="selectlabel">Status</label>
                            <select placeholder="Status" name="status" class="testSelAll2 form-control" ng-model="status" required="required">
                                <option value="0" ng-selected="singleViews.status=='0'">ACTIVE</option>
                                <option value="1" ng-selected="singleViews.status=='1'">DEACTIVE</option>
                            </select>
                             <span class="help-block" ng-show="escaForm.status.$dirty && escaForm.status.$invalid">
                                <span ng-show="escaForm.status.$error.required">Select Status</span>
                            </span>
                        </div>
                   </div>
                   <div class="row form-group"> 
                    <div class="col-sm-6 col-sm-offset-5">
                        <button type="submit" click-once class="btn btn-info btn-sm" 
                        ng-disabled="escaForm['zone_alias[]'].$dirty && escaForm['zone_alias[]'].$invalid ||
                        escaForm['state_alias[]'].$dirty && escaForm['state_alias[]'].$invalid ||
                        escaForm.esca_id.$dirty && escaForm.esca_id.$invalid ||
                        escaForm.esca_name.$dirty && escaForm.esca_name.$invalid ||
                        escaForm.esca_number.$dirty && escaForm.esca_number.$invalid ||
						escaForm.status.$dirty && escaForm.status.$invalid && singleViews.emp_alias=='ADMIN' ||
                        escaForm.esca_email.$dirty && escaForm.esca_email.$invalid">Update</button>
                        <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose();">Close</button>
                    </div>
               </div>
          </form>   
	</div>
</div>
<script>
setInterval(function(){
	$('.testSelAll2').SumoSelect();
	$('.testSelAll3').SumoSelect({selectAll:true});
	$('.forms_add').find('.SumoSelect').addClass('singleSelect');
},0);
</script>