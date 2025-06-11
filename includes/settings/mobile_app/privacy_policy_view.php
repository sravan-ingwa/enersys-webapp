<style>
	.form-group {margin-bottom:15px;}
	.form-group div.col-sm-4{margin-bottom:15px;}
	.modal-header > .close {right:-30px; top:-12px;}
</style>
<div>
<div class="modal-style" ng-controller="privacyController">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Privacy and Policy</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body">
		<div class="row form-group">
			<div class="col-sm-6">
				<md-input-container flex="" class="md-default-theme md-input-has-value">
					<label for="input_00A">Help</label>
					<input ng-model="singleViews.help" class="ng-pristine ng-valid md-input ng-touched" readonly="readonly">
				</md-input-container>
			</div>
			<div class="col-sm-6 mb30">
				<md-input-container flex="" class="md-default-theme md-input-has-value">
					<label for="input_00A">Login Text</label>
					<input ng-model="singleViews.login_text" class="ng-pristine ng-valid md-input ng-touched" readonly="readonly">
				</md-input-container>
			</div>
			<h5 class="text-center">PRIVACY and POLICY</h5>
			<div class="col-sm-12" style="border:1px #d5d5d5 solid;">
				<p style="max-height:300px; height:250px; overflow:auto; overflow-x:hidden;" ng-bind-html="singleViews.privacy_policy"></p>
			</div>
			 <div class="col-sm-12 mt30 text-center">
				<div ng-click="modalClose()" style="width:10%;" class="btn btn-info btn-sm">OK</div>
				<!--<div ng-click="privacyeditOpen()" class="btn btn-info btn-sm">Edit</div>-->
			</div>
	   </div>
	</div>
</div>
</div>