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
		<h4 class="modal-title">IMPORT HR APPROVALS</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body">
		<form class="form-horizontal forms_request" name="expenseRequest" data-went="#/expenses" method="post" url="services/expense_tracker/expense_import" ng-submit="sendRequest()" novalidate>
			<div class="row form-group">
				<div class="col-sm-6 col-sm-offset-3 mb10 filesRow" ng-controller="fileUploadCtrl">
					<input value="{{file_name}}" class="form-control uploadFile" placeholder="Choose File" disabled="disabled" name="scm_appr"/>
					<div class="fileUpload btn btn-sm btn-info" tooltip="Upload" tooltip-placement="right">
						<span class="ion ion-upload"></span>
						<input type="file" class="upload uploadBtn" name="scm_appr" onchange="angular.element(this).scope().file_load_exp(this.files)"/>
					</div>
					<div class="mb20" ng-if="prg_shw_hde">
						<md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
					</div>
				</div>
            </div>   
			<div class="row form-group"> 
				<div class="col-sm-6 col-sm-offset-5 mt10">
					 <button type="submit" class="btn btn-info btn-sm" click-once>Import</button>
				</div>
			</div>
		</form>    
	</div>
</div>
<script>
	setInterval(function(){$('.Selectbox').SumoSelect();
	$('.forms_request').find('.SumoSelect').addClass('singleSelect');},0);
</script>
