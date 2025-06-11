<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4 {margin-bottom: 15px}
.modal-header>.close {right: -30px;top: -12px}
.btn-default {border-color: transparent!important;border-bottom: 1px solid #e0e0e0!important}
.autoselect {padding-top: 22px!important}
.upload-file {border-bottom: 1px solid rgba(0,0,0,.12)}
.ui-select-bootstrap>.ui-select-search:focus {border: none;background: #FFF!important;border-bottom: 1px solid #e0e0e0}
.ui-select-bootstrap>.ui-select-match>button {text-align: left!important}
.selectdrop {overflow-y: scroll}
.datepicker {border-bottom: 1px solid #efefef!important}
.singleSelect {width: 100%;border-bottom: 1px solid #e0e0e0}
.SumoSelect>.optWrapper {right: 0!important}
.SumoSelect>.CaptionCont>span.placeholder {color: #ccc!important}
.singleSelect>.CaptionCont>label>i {color: #000}
.SumoSelect>.optWrapper.open {top: 33px!important}
.panel-heading b{color:#000; margin-right:20px;}.panel-heading i{color:#000;}.panel-heading span{color:#000}
.panel-info > .panel-heading { color: #ffffff !important; background-color: #2196f3; border-color: #2196f3;}
.panel-info > .panel-heading span{color:#fff;}
.panel-info > .panel-heading i{color:#fff;}
.panel-info > .panel-heading b{color:#fff;}
.right a span{color:#000;}
md-input-container.md-default-theme .md-input[disabled]{ border-bottom-color: rgba(0,0,0,0.12) !important;}
</style>
<div class="modal-style" ng-controller="matrialoutwardEdit">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit Material Outward</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
		<form class="form-horizontal forms_add" name="matrialinwardeditForm" data-went="#/Materialoutward" method="post" url="services/inventory/material_outward_edit" ng-submit="sendPost()" novalidate>
			<input type="hidden" name="alias" value="{{singleViews.trans_alias}}"/>
				<accordion class="accordion-panel" ng-if="singleViews.ts_approved_length != '0'">
				  <div class="panel panel-default panel-hovered">
					<accordion class="accordion-panel">
						<accordion-group is-open="lc_status.open" ng-class="{'panel-info': lc_status.open}">
							<accordion-heading>
								<span class="panel-heading exp_sing">OUTWARD DETAILS &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <i class="mt2 ion small" ng-style="{color : ((lc_status.open) && '#FFF') || '#000'}" ng-class="{'ion-chevron-down': lc_status.open, 'ion-chevron-right': !lc_status.open}"></i></span>
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
									  <div class="col-sm-4" ng-if="singleViews.from_type != 1">
										<md-input-container flex="" class="md-default-theme">
										  <label for="input_00A">To Wh</label>
										  <input type="text" value="{{singleViews.to_wh}}" ng-model="singleViews.to_wh" class="ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false" disabled="disabled"/>
										</md-input-container>
									  </div>
									  <div class="col-sm-4" ng-if="singleViews.from_type == 1 && singleViews.status_code != 4">
										<md-input-container flex="" class="md-default-theme">
										  <label for="input_00A">To Wh</label>
										  <input type="text" value="{{singleViews.to_wh}}" ng-model="singleViews.to_wh" class="ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false" disabled="disabled"/>
										</md-input-container>
									  </div>
									  <div class="col-sm-3" ng-if="singleViews.from_type == 1 && singleViews.status_code == 4">
										<md-input-container flex="" class="md-default-theme">
										  <label for="input_00A">To Wh</label>
										  <input type="text" value="{{singleViews.to_wh}}" ng-model="singleViews.to_wh" class="ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false" disabled="disabled"/>
										</md-input-container>
									  </div>
									  <div class="col-sm-1" ng-if="singleViews.from_type == 1 && singleViews.status_code == 4" style="margin-top:30px;">
			<a href="javascript:void(0)" class="ml3 ng-scope" tooltip="Advance Edit" tooltip-placement="bottom" ng-click="changeEditTicket(singleViews.from_wh_alias);" ng-if="singleViews.from_type == 1" tabindex="0">
					<span class="fa fa-spl-edit"></span>
			</a>
									  </div>
								</div>
					<div class="row form-group"><!-- SITE -->
						<div class="col-sm-4"  ng-if="singleViews.from_type == 1 && singleViews.status_code == 4 && editTicket">
							<label class="selectlabel">Ticket ID</label>
							<input type="hidden" name="change_tt" value="1"/>
							<select class="form-control testSelAll2 selectdrop" ng-model="ref_no" name="ref_no" data-ng-change="getrequiredCellsTickets(ref_no)">
								<option value="" selected="selected" disabled="disabled">{{firstDrop.length!='0' ? 'Select Ticket ID':'No Records Found'}}</option>
								<option value="2609">Customer Buffer Stock</option>
								<option ng-repeat="optionlist in firstDrop" value="{{optionlist.alias}}">{{optionlist.name}}</option>
							</select>
						</div>
									  <div class="col-sm-4">
										<md-input-container flex="" class="md-default-theme">
										  <label for="input_00A">Transaction Date</label>
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
				<div class="col-sm-4" ng-controller="emprolenameCntrl">
					<label class="selectlabel">Responsible Engineer</label>
					<select class="form-control selectdrop testSelAll2" name="resp_engineer">
						<option value="" selected="selected" disabled="disabled">Responsible Engineer</option>
						<option ng-repeat="emp in firstDrop" ng-selected="singleViews.resp_engineer_alias==emp.alias" value="{{emp.alias}}">{{emp.name}}</option>
					</select>
				</div>
			  <div class="col-sm-4" ng-controller="DatepickerDemoCtrl">
				<md-input-container flex="" class="md-default-theme">
				  <label for="input_00C">Dispatch Date</label>
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
					<textarea rows="2" name="remarks" ng-maxlength="700" class="form-control resize-v" placeholder="Remarks" required="required"></textarea>
			  </div>
			</div>

			<!-- All SHIPPED ITEMS -->
			<div class="mb20" ng-if="singleViews.remark_length != 0">
				<h5 class="modal-title text-center"> Items </h5>
				<table class="table table-condensed" >
						<thead>
								<tr>
										<th width="5%"><a class="tktid">Sr.No</a></th>
										<th width="20%"><a class="tktid">Code</a></th>
										<th width="25%"><a class="tktid">Cell no</a></th>
										<th width="30%"><a class="tktid">Condition</a></th>
										<th width="10%"  ng-if="!singleViews.partialEdit"><a class="tktid">Actions</a></th>
								</tr>
						<thead>
				</table>
				<div ng-controller="productdropCntrl">
					<table class="table table-hover table-bordered">
							<tbody>
									<tr class="tktBackground" ng-repeat="(key, req) in singleViews.request_items">
											<td width="5%">{{key + 1}} <input type="hidden" name="item_alias[]" value="{{req.id}}" />
											<input type="hidden" name="item_description[]" value="{{req.item_description}}" /> </td>
											<td width="20%">{{req.item_code}}</td>
											<td width="25%">{{req.item_description}}</td>
											<td width="30%"> {{req.condition}}</td>
											
											<td width="10%" ng-if="!singleViews.partialEdit">
              <a href="javascript:void(0)" class="ml3" tooltip="Delete" tooltip-placement="bottom" ng-click="deleteItemFromMaterialOutward(singleViews.trans_alias, req.item_description_alias, req.item_type);" ng-if="req.allowconditionUpdate">
                  <span class="fa fa-delete"></span>
              </a>
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
		$('.testSelAll3').SumoSelect({selectAll:true});
		$('.forms_add').find('.SumoSelect').addClass('singleSelect');
	},0);
	setTimeout(function(){
		$('.testSelAll2').SumoSelect();
		$('.testSelAll3').SumoSelect({selectAll:true});
		$('.textSearch').keyup(function(){
			var cc = $(this).siblings('.options').find('li');
			var aa =$(this).siblings('.options > li');
			var valThis = $(this).val().toLowerCase();
			if(valThis == "")cc.removeClass('hidden');           
			else{
				cc.each(function(){
					var text = $(this).text().toLowerCase();
					(text.indexOf(valThis) >= 0) ? $(this).removeClass('hidden') : $(this).addClass('hidden');
				});
			};
		   if(cc.length==$(this).siblings('.options').find('.hidden').length){
				$(this).siblings('.options').append('<li class="no_rec"><label>No Records</label></li>');
				$(this).siblings('.select-all').addClass('hidden');
		   }else{
				$(this).siblings('.options').find('.no_rec').remove(); 
				$(this).siblings('.select-all').removeClass('hidden');
		   };
		   $('.forms_add').find('.SumoSelect').addClass('singleSelect');
		});
	},0);
</script>