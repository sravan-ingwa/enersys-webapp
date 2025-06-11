<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
</style>
<div>
	<div class="modal-style" ng-controller="imeiEditCtrl">	<!-- wrapper for specific style -->
		<div class="modal-header clearfix">
			<h4 class="modal-title">Edit Deactivation</h4>
			<span class="close ion ion-android-close" ng-click="modalClose()"></span>
		</div>
		<div class="modal-body" ng-controller="addingform">
			<form class="form-horizontal forms_add" reset-directive="singleViews" name="imeiForm" data-went="#/imeicontrol" method="post" url="services/imeicontrol/imei_edit" ng-submit="sendPost()" novalidate>
				<input name="employee_alias" value="{{singleViews.employee_alias}}" type="hidden">
				<div class="row form-group">
					<div class="col-sm-6">
						<md-input-container flex="" class="md-default-theme md-input-has-value">
							<label for="input_00A">Employee ID</label>
							<input value="{{singleViews.employee_id}}" ng-model="singleViews.employee_id" class="ng-pristine ng-valid md-input ng-touched" readonly>
						</md-input-container>
					</div>
					<div class="col-sm-6">
						<md-input-container flex="" class="md-default-theme md-input-has-value">
							<label for="input_00A">Employee Name</label>
							<input value="{{singleViews.name}}" ng-model="singleViews.name" class="ng-pristine ng-valid md-input ng-touched" readonly>
						</md-input-container>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-6">
						<md-input-container flex="" class="md-default-theme md-input-has-value">
							<label for="input_00A">Device IMEI 1</label>
							<input name="device" value="{{singleViews.device}}" valid-input="15" ng-model="singleViews.device" class="ng-pristine ng-valid md-input ng-touched">
						</md-input-container>
						<span class="help-block" ng-show="imeiForm.device.$dirty && imeiForm.device.$invalid">
							<span ng-show="imeiForm.device.$error.minlength">Enter valid IMEI 1</span>
						</span>
					</div>
					<div class="col-sm-6">
						<md-input-container flex="" class="md-default-theme md-input-has-value">
							<label for="input_00A">Device IMEI 2</label>
							<input name="device_2" value="{{singleViews.device_2}}" valid-input="15" ng-model="singleViews.device_2" class="ng-pristine ng-valid md-input ng-touched">
						</md-input-container>
						<span class="help-block" ng-show="imeiForm.device_2.$dirty && imeiForm.device_2.$invalid">
							<span ng-show="imeiForm.device_2.$error.minlength">Enter valid IMEI 2</span>
						</span>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-12">
						<md-input-container flex="">
							<label for="input_00A">Remarks</label>
							<input name="remarks" ng-model="remarks" class="ng-pristine ng-valid md-input ng-touched">
						</md-input-container>
					</div>
				</div>
				<div class="row form-group">
					 <div class="col-sm-6 col-sm-offset-4">
						<button type="submit" click-once class="btn btn-info btn-sm" ng-disabled="imeiForm.device.$dirty && imeiForm.device.$invalid && imeiForm.device_2.$dirty && imeiForm.device_2.$invalid">Update</button>
						<button type="reset" class="btn btn-info btn-sm" ng-click="imeiForm.$setPristine(); imeiForm.$setUntouched();">Reset</button>
					</div>
				</div>
			</form>  
		</div>
	</div>
</div>