<style>
/*.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
.selectdrop {
	overflow-y: scroll
}
.datepicker {
	border-bottom: 1px solid #efefef!important
}
.singleSelect {
	width: 100%;
	border-bottom: 1px solid #e0e0e0
}
.SumoSelect>.optWrapper {
	right: 0!important
}
.SumoSelect>.CaptionCont>span.placeholder {
	color: #ccc!important
}
.singleSelect>.CaptionCont>label>i {
	color: #000
}
.SumoSelect>.optWrapper.open {
	top: 33px!important
}*/
.selectdrop{overflow-y:scroll;}
.form-group {margin-bottom:0px !important;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.upload-file{border-bottom: 1px solid rgba(0,0,0,0.12);}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
</style>
<div ng-controller="customerAddCntl">
<div class="modal-style" ng-controller="segmentdropCntrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Create Customer</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">

        <form class="form-horizontal forms_add" name="customerForm" data-went="#/settings/customer/customer_view" method="post" url="services/settings/customer_add" ng-submit="sendPost()" novalidate>
                <div class="row form-group">
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Enter Customer Name</label>
                            <input ng-model="temp.customername" class="ng-pristine ng-valid md-input ng-touched" name="customer_name" id="input_00A" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="customerForm.customer_name.$dirty && customerForm.customer_name.$invalid">
                            <span ng-show="customerForm.customer_name.$error.required">Customer Name is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Customer Code</label>
                            <input ng-model="temp.customercode" class="ng-pristine ng-valid md-input ng-touched" name="customer_code" id="input_00B" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="customerForm.customer_code.$dirty && customerForm.customer_code.$invalid">
                            <span ng-show="customerForm.customer_code.$error.required">Customer Code is Required</span>
                        </span>
                    </div>
                     <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Customer Id</label>
                            <input ng-model="temp.customerid" class="ng-pristine ng-valid md-input ng-touched" ng-pattern="/^\S*$/" name="customer_id" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="customerForm.customer_id.$dirty && customerForm.customer_id.$invalid">
                            <span ng-show="customerForm.customer_id.$error.required">Customer Id is Required</span>
                            <span ng-show="customerForm.customer_id.$error.pattern">Spaces not allowed</span>
                        </span>
                    </div>
				</div>
			<div class="row form-group">
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Password</label>
                            <input ng-model="temp.password" class="ng-pristine ng-valid md-input ng-touched" name="password" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="customerForm.password.$dirty && customerForm.password.$invalid">
                            <span ng-show="customerForm.password.$error.required">Password is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Customer Email</label>
                            <input ng-model="customeremail" name="customer_email" class="ng-pristine ng-valid md-input ng-touched" ng-pattern="/^(([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+([;,.](([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+)*$/" required="required">
                        </md-input-container>
                        <span class="help-block" ng-show="customerForm.customer_email.$dirty && customerForm.customer_email.$invalid">
                            <span ng-show="customerForm.customer_email.$error.required">Customer Email is Required</span>
                            <span ng-show="customerForm.customer_email.$error.pattern">Invalid Email Address</span>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Warranty From Dispatch(Months)</label>
                            <input ng-model="warranty" class="ng-pristine ng-valid md-input ng-touched" ng-pattern="/^[0-9]{1,}$/" name="dispatch" id="input_00E" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                          <span class="help-block" ng-show="customerForm.dispatch.$dirty && customerForm.dispatch.$invalid">
                            <span ng-show="customerForm.dispatch.$error.required">Warranty From Dispatch is Required</span>
                            <span ng-show="customerForm.dispatch.$error.pattern">Warranty From Dispatch should be digits only</span>
                        </span>
                    </div>
				</div>
				<div class="row form-group">
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Warranty From Installation(Months)</label>
                            <input ng-model="installation" class="ng-pristine ng-valid md-input ng-touched" ng-pattern="/^[0-9]{1,}$/" name="installation" id="input_00F" tabindex="0" aria-invalid="false">
                        </md-input-container>
                         <!--<span class="help-block" ng-show="customerForm.installation.$dirty && customerForm.installation.$invalid">
                            <span ng-show="customerForm.installation.$error.required">Warranty From Installation is Required</span>
                            <span ng-show="customerForm.installation.$error.pattern">Warranty From Installation should be digits only</span>
                        </span>-->
                    </div>
                     <div class="col-sm-4">
                     	<label class="selectlabel">Segment</label>
                        <select class="form-control testSelAll2 selectdrop" name="segment_alias" ng-model="segments" required>
                            <option value="" selected="" disabled="disabled">Select Segment</option>
                            <option ng-repeat="segment in firstDrop" value="{{segment.alias}}">{{segment.name}}</option>
                    	</select>
                         <span class="help-block" ng-show="customerForm.segment_alias.$dirty && customerForm.segment_alias.$invalid">
                            <span ng-show="customerForm.segment_alias.$error.required">Select Segment</span>
                        </span>
                    </div>
                    <div class="col-sm-4 dropalign" ng-controller="scheduleDropCtrl">
                    	<label class="selectlabel">Schedule</label>
                        <select class="form-control testSelAll2 selectdrop" name="schedule" ng-model="schedule" required>
                            <option value="" disabled="disabled">Schedule</option>
                            <option value="{{schedule.name}}" ng-repeat="schedule in schedules">{{schedule.name}}</option>
                    	</select>
                         <span class="help-block" ng-show="customerForm.schedule.$dirty && customerForm.schedule.$invalid">
                            <span ng-show="customerForm.schedule.$error.required">Select Schedule</span>
                        </span>
                    </div>
				</div>
				<div class="row form-group">
					<div class="col-sm-4 dropalign" ng-controller="productdropCntrl">
						<label class="selectlabel">Product Code</label>
						<select class="form-control testSelAll2 selectdrop" placeholder="Product Code" name="product_alias[]" ng-model="productcode" required multiple="multiple">
                            <option ng-repeat="product in firstDrop" value="{{product.alias}}">{{product.name}}</option>
                    	</select>
                         <span class="help-block" ng-show="customerForm['product_alias[]'].$dirty && customerForm['product_alias[]'].$invalid">
                            <span ng-show="customerForm['product_alias[]'].$error.required">Select Product Code</span>
                        </span>
                    </div>

					<div class="col-sm-4 filesRow" ng-controller="fileUploadPrgCtrl">
						<input value="{{file_name}}" class="form-control uploadFile" placeholder="Upload PO" disabled="disabled"/>
						<div class="fileUpload btn btn-sm btn-info" tooltip="Choose PO" tooltip-placement="right">
							<span class="ion ion-upload"></span>
							<input type="file" class="upload uploadBtn" name="po_file" id="po_file" onchange="angular.element(this).scope().file_load(this.files,'pdf')"/>
						</div>
						<span class="help-block" ng-show="customerForm.po_file.$dirty && customerForm.po_file.$invalid">
							<span ng-show="customerForm.po_file.$error.required">Upload MOC</span>
						</span>
						<div ng-if="determinateValue >= '100' ? closeloadings() : ''"></div>
						<div class="mb20" ng-if="prg_shw_hde">
							<md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
						</div>
					</div>
				</div>
				<div class="row form-group">
                     <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm" ng-disabled="customerForm.$invalid || customerForm.$pristine">Create</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose()">Close</button>
                    </div>
               </div>
          </form>   
	</div>
</div>
</div>
<script>
setInterval(function(){$('.testSelAll2').SumoSelect({selectAll:true});
$('.forms_add').find('.SumoSelect').addClass('singleSelect');},0);
/*$('.resetting').on('click', function(){
	var num = $('option').length;
	for(var i=0; i<num; i++){
	$('.testSelAll2')[0].sumo.unSelectItem(i);
	}
});*/
</script>