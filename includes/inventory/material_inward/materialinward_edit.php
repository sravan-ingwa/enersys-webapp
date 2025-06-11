<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.upload-file{border-bottom: 1px solid rgba(0,0,0,0.12);}
md-input-container.md-default-theme .md-input[disabled]{ border-bottom-color: rgba(0,0,0,0.12) !important;}
select .form-control:{height:68px !important;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
</style>
<div class="modal-style" ng-controller="matrialinwardEdit">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit Material Inward</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
		<form class="form-horizontal forms_add" name="matrialinwardeditForm" data-went="#/Materialinward" method="post" url="services/inventory/material_inward_edit" ng-submit="sendPost()" novalidate>
			<input type="hidden" name="alias" value="{{singleViews.mrf_alias}}"/>
				<accordion class="accordion-panel" ng-if="singleViews.ts_approved_length != '0'">
				  <div class="panel panel-default panel-hovered">
					<accordion class="accordion-panel">
						<accordion-group is-open="lc_status.open" ng-class="{'panel-info': lc_status.open}">
							<accordion-heading>
								<span class="panel-heading exp_sing">INWARD DETAILS &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <i class="mt2 ion small" ng-style="{color : ((lc_status.open) && '#FFF') || '#000'}" ng-class="{'ion-chevron-down': lc_status.open, 'ion-chevron-right': !lc_status.open}"></i></span>
							</accordion-heading>
							<div class="mb20">
								<div class="row form-group">
									  <div class="col-sm-4">
										<md-input-container flex="" class="md-default-theme">
										  <label for="input_00A">Transaction ID</label>
										  <input type="text" value="{{singleViews.trans_id}}" ng-model="singleViews.trans_id" class="ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false" disabled="disabled"/>
										</md-input-container>
									  </div>
									  <div class="col-sm-4">
										<md-input-container flex="" class="md-default-theme">
										  <label for="input_00A">From Wh</label>
										  <input type="text" value="{{singleViews.from_wh}}" ng-model="singleViews.from_wh" class="ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false" disabled="disabled"/>
										</md-input-container>
									  </div>
									  <div class="col-sm-4">
										<md-input-container flex="" class="md-default-theme">
										  <label for="input_00A">To Wh</label>
										  <input type="text" value="{{singleViews.to_wh}}" ng-model="singleViews.to_wh" class="ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false" disabled="disabled"/>
										</md-input-container>
									  </div>
								</div>
								<div class="row form-group">
									  <div class="col-sm-4">
										<md-input-container flex="" class="md-default-theme">
										  <label for="input_00A">Date Of Request</label>
										  <input type="text" value="{{singleViews.date_of_request}}" ng-model="singleViews.date_of_request" class="ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false" disabled="disabled"/>
										</md-input-container>
									  </div>
									  <div class="col-sm-4">
										<md-input-container flex="" class="md-default-theme md-input-has-value">
										  <label for="input_00A" ng-init="singleViews.sjo = singleViews.sjo!='' ? singleViews.sjo : 'NON SJO'">SJO Number</label>
										  <input type="text" value="{{singleViews.sjo}}" ng-model="singleViews.sjo" class="ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false" disabled="disabled"/>
										</md-input-container>
									</div>
									<div class="col-sm-4">
									   <md-input-container flex="" class="md-default-theme">
											<label for="input_00D">Material Value</label>
											<input value="{{singleViews.material_value}}" ng-model="singleViews.material_value" class="ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false" disabled="disabled"/>
										</md-input-container>
									</div>
								</div>
							</div>
						</accordion-group>
					</accordion>
					</div>
				</accordion>
			<div class="row form-group">
			  <div class="col-sm-4">
				<md-input-container flex="" class="md-default-theme">
				  <label for="input_00D">Inward Number</label>
				  <input type="text" value="{{singleViews.inv_num}}" ng-model="singleViews.inv_num" name="inv_num" class="ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false"/>
				</md-input-container>
			  </div>
			  <div class="col-sm-4" ng-controller="DatepickerDemoCtrl">
				<md-input-container flex="" class="md-default-theme">
				  <label for="input_00C">Inward Date</label>
				  <input type="text" value="{{singleViews.dispatch_date}}" ng-model="singleViews.dispatch_date" name="invoice_date" class="datepicker border-bottom" placeholder="Select date.." datepicker-popup="{{format}}" tabindex="0" ng-click="open($event)" ng-focus="open($event)" is-open="opened" ng-focus="opened=true" min-date="datas.disp_date_check" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" required="required"/>
				</md-input-container>
				<span class="help-block" ng-show="matrialinwardeditForm.invoice_date.$dirty && matrialinwardeditForm.invoice_date.$invalid"> <span ng-show="matrialinwardeditForm.invoice_date.$error.required">Invoice Date is Required</span> </span>
			  </div>
			  <div class="col-sm-4">
				<md-input-container flex="" class="md-default-theme">
				  <label for="input_00D">Transporter Details</label>
				  <input type="text" value="{{singleViews.transport_no}}" ng-model="singleViews.transport_no" name="transporterDetails" class="ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false" required="required"/>
				</md-input-container>
			  </div>
			</div>
			<div class="row form-group">
			  <div class="col-sm-4">
				<md-input-container flex="" class="md-default-theme">
				  <label for="input_00D">Docket Number</label>
				  <input type="text" value="{{singleViews.docket_no}}" ng-model="singleViews.docket_no" name="docket" class="ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false" required="required"/>
				</md-input-container>
			  </div>
			  <div class="col-sm-4">
					<textarea rows="2" name="remarks" ng-model="remarks" ng-maxlength="700" class="form-control resize-v" placeholder="Remarks"></textarea>
			  </div>
			</div>
			
			<!-- All SHIPPED ITEMS -->
			<div class="mb20" ng-if="singleViews.remark_length != 0">
				<h5 class="modal-title text-center"> Items </h5>
				<table class="table table-condensed" >
						<thead>
								<tr>
										<th width="5%"><a class="tktid">Sr.No</a></th>
										<th width="25%"><a class="tktid">Code</a></th>
										<th width="25%"><a class="tktid">Cell no</a></th>
										<th width="35%"><a class="tktid">Conditioin</a></th>
								</tr>
						<thead>
				</table>
				<div ng-controller="productdropCntrl">
					<table class="table table-hover table-bordered">
							<tbody>
									<tr class="tktBackground" ng-repeat="(key, req) in singleViews.request_items">
											<td width="5%">{{key + 1}} <input type="hidden" name="item_alias[]" value="{{req.id}}" />
											<input type="hidden" name="item_description[]" value="{{req.item_description}}" /> </td>
											<td width="25%">{{req.item_code}}</td>
											<td width="25%">{{req.item_description}}</td>
											<td width="35%" ng-if="!req.allowconditionUpdate"> {{req.condition}}</td>
											<td width="35%" ng-if="req.allowconditionUpdate && req.item_type == 1">
												<select class="form-control testSelAll2 selectdrop" name="item_condtion[]" ng-model="req.item_condition" placeholder="Select Cell Condition" ng-if="singleViews.from_type != 3">
													<option value="0" ng-selected="req.item_condition == 0"> Condition </option>
													<option value="3" ng-selected="req.item_condition == 3"> Scrap Cell </option>
													<option value="4" ng-selected="req.item_condition == 4"> Transit Damage </option>
													<option value="5" ng-selected="req.item_condition == 5"> Field Revived </option> 
													<option value="8" ng-selected="req.item_condition == 8"> Field Good </option>
												</select>
												<select class="form-control testSelAll2 selectdrop" name="item_condtion[]" ng-model="req.item_condition" placeholder="Select Cell Condition" ng-if="singleViews.from_type == 3">
													<option value="0" ng-selected="req.item_condition == 0"> Condition </option>
													<option value="1" ng-selected="req.item_condition == 1"> New Cell </option>
													<option value="4" ng-selected="req.item_condition == 4"> Transit Damage </option>
													<option value="7" ng-selected="req.item_condition == 7"> Lost Cell </option>
												</select>
											</td>
											<td width="35%" ng-if="req.allowconditionUpdate && req.item_type == 2">
												<select class="form-control testSelAll2 selectdrop" name="item_condtion[]" ng-model="req.item_condition" placeholder="Select Cell Condition">
													<option value="0" ng-selected="req.item_condition == 0"> Good </option>
													<option value="1" ng-selected="req.item_condition == 1"> Damaged </option>
												</select>
											</td>
									</tr>
							</tbody>
					</table>
				</div>
			</div>

			<!-- All Remarks -->
			<div class="mb20" ng-if="singleViews.remark_length != 0">
				<h5 class="modal-title text-center">Remarks</h5>
				<table class="table table-condensed" >
						<thead>
								<tr>
										<th width="5%"><a class="tktid">Sr.No</a></th>
										<th width="20%"><a class="tktid">Remark By</a></th>
										<th width="20%"><a class="tktid">Remark On</a></th>
										<th width="45%"><a class="tktid">Remark</a></th>
								</tr>
						<thead>
				</table>
				<div class="">
					<table class="table table-hover table-bordered">
							<tbody>
									<tr class="tktBackground {{rem.remark_alias}}" ng-repeat="(key,rem) in singleViews.remark">
											<td width="5%">{{key + 1}}</td>
											<td width="20%">
											<input type="hidden" name="remark_alias[]" value="{{rem.remark_alias}}" />
												<select tooltip-placement="top" tooltip="{{rem.designation}}" class="form-control testSelAll2 selectdrop" name="remarked_by[]" ng-model="remarked_by">
													<option value="">Employee Name</option>
													<option value="ADMIN" ng-selected="rem.remarked_by == 'ADMIN'">ADMIN</option>
													<option ng-repeat="employeelist in thirdDrop" value="{{employeelist.alias}}" ng-selected="employeelist.alias == rem.remarked_by_alias">{{employeelist.name}}</option>
												</select>
											</td>
											<td class="hidden-xs hidden-sm" ng-controller="DatepickerDemoCtrl" width="20%"><input ng-model="rem.remarked_on" value="{{rem.remarked_on}}" name="remarked_on[]" class="datepicker md-input ng-touched" placeholder="Select date.." datepicker-popup="{{format2}}" ng-click="open($event)" ng-focus="open($event)" is-open="opened" min-date="'01-01-2000'" max-date="'22-06-2025'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/></td>
											<td width="45%"><textarea rows="2" name="remark[]" ng-model="rem.remarks" class="form-control resize-v">{{rem.remarks}}</textarea></td>
									</tr>
							</tbody>
					</table>
				</div>
			</div>

			<div class="row form-group">
				<div class="col-sm-6 col-sm-offset-3 mt10" align="center">
					<button type="submit" click-once class="btn btn-info btn-sm">Update</button>
					<button type="reset" class="btn btn-info btn-sm" ng-click="matrialinwardeditForm.$setPristine(); matrialinwardeditForm.$setUntouched();">Reset</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	setInterval(function(){
		$('.testSelAll2').SumoSelect();
		$('.forms_add').find('.SumoSelect').addClass('singleSelect');
	},0);
</script>