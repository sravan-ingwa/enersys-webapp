<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
.div-table-content{height:auto !important;max-height:400px !important;}
h6 {
	color: #428bca !important;
}
.header h4 {
	border-bottom: 1px solid #d1d1d1;
	padding:5px;
}
.pt10 {
	padding-top: 10px !important;
}
.md-default-theme label {
	color: #428bca !important;
	font-size: 14px !important;
}
.sub_lable{
	color:#428bca !important;
	font-size: 11px !important;
}
.intheme label{
	color: #999 !important;
	font-size: 14px !important;
}
.form-group, .form-group div.col-sm-4 {
	margin-bottom: 15px;
}
.modal-header>.close {
	right: -30px;
	top: -12px
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
	top: 15px!important
	margin-top:10px;
}
.resizeNone{
	resize:none;
}
</style>
<div class="modal-style" ng-controller="materialRequestEdit">
	<div ng-controller="addFieldsCtrl">
		<div class="modal-header clearfix">
			<h4 class="modal-title">Material Request Approval</h4>
			<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
		</div>
		<div class="modal-body" ng-controller="addingform">
           <form class="form-horizontal forms_add" name="userForm" role="form" data-went="#/Materialrequest" method="post" url="services/inventory/material_request_edit" ng-submit="sendPost()" ng-repeat="field in forms" novalidate>
			 <div class="panel-body">
				<input type="hidden" name="mrf_alias" value="{{singleViews.mrf_alias}}">
				<input type="hidden" name="mrf_status" value="{{singleViews.status}}">
				<accordion class="accordion-panel" ng-if="singleViews.ts_approved_length != '0'">
				  <div class="panel panel-default panel-hovered">
					<!--<div class="panel-heading exp_sing">TECHNICAL SERVICE REPORT</div>-->
					<accordion class="accordion-panel" >
						<accordion-group is-open="lc_status.open" ng-class="{'panel-info': lc_status.open}">
						<accordion-heading>
							<span class="panel-heading exp_sing">TECHNICAL SERVICE DETAILS &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <i class="mt2 ion small" ng-style="{color : ((lc_status.open) && '#FFF') || '#000'}" ng-class="{'ion-chevron-down': lc_status.open, 'ion-chevron-right': !lc_status.open}"></i></span>
						</accordion-heading>
						<div class="mb20">
							<div class="row mb20">
								<div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
								  <h5>Line Number</h5>
								  <span class="fnt-size-11">{{singleViews.line_number}}</span>
								</div>
								<div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
								  <h5>Shift</h5>
								  <span class="fnt-size-11">{{singleViews.shift}}</span>
								</div>
								<div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
								  <h5>Date Of Assembly</h5>
								  <span class="fnt-size-11">{{singleViews.date_of_assembly}}</span>
								</div>
								<div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
								  <h5>Date Of Jar formation</h5>
								  <span class="fnt-size-11">{{singleViews.date_of_jar_form}}</span>
								</div>
								<div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
								  <h5>Corrective Actions Planned</h5>
								  <span class="fnt-size-11">{{singleViews.corect_act_Plan}}</span>
								</div>
								<div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
								  <h5>Persons Notified</h5>
								  <span class="fnt-size-11">{{singleViews.persons_notified}}</span>
								</div>
								<div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
								  <h5>Deposition</h5>
								  <span class="fnt-size-11">{{singleViews.deposition}}</span>
								</div>
							</div>
							<div class="panel-heading exp_sing"><h5 class="modal-title text-center">Faulty Cells Details</h5></div>
							<table class="table table-condensed" >
								<thead>
									<tr>
										<th><a class="tktid">Sr.No</a></th>
										<th><a class="tktid">Faulty Cell Serial No.</a></th>
										<th><a class="tktid">OCV at dispatch</a></th>
										<th><a class="tktid">10th Hour reading</a></th>
									</tr>
								<thead>
							</table>
							<div class="">
								<table class="table table-hover table-bordered">
									<tbody>
										<tr class="tktBackground" ng-repeat="(key,ts) in singleViews.ts_approved">
											<td>{{key + 1}}</td>
											<td>{{ts.faulty_cell_num}}</td>
											<td class="hidden-xs hidden-sm">{{ts.ocv}}</td>
											<td>{{ts.tenth_hour}}</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
							</accordion-group>
						</accordion>
						</div>
					</accordion>
			 <accordion class="accordion-panel" ng-if="singleViews.request_length != 0">
				  <div class="panel panel-default panel-hovered">
					<accordion class="accordion-panel" >
						<accordion-group is-open="lc_status.open" ng-class="{'panel-info': lc_status.open}">
						<accordion-heading>
							<span class="panel-heading exp_sing">REMARKS &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <i class="mt2 ion small" ng-style="{color : ((lc_status.open) && '#FFF') || '#000'}" ng-class="{'ion-chevron-down': lc_status.open, 'ion-chevron-right': !lc_status.open}"></i></span>
						</accordion-heading>
						<div class="mb20">
							<div ng-if="singleViews.remark_length != 0">
								<table class="table table-condensed" >
									<thead>
										<tr>
											<th><a class="tktid">Sr.No</a></th>
											<th><a class="tktid">Remark By</a></th>
											<th><a class="tktid">Remark On</a></th>
											<th><a class="tktid">Bucket</a></th>
											<th><a class="tktid">Remark</a></th>
										</tr>
									<thead>
								</table>
								<div class="div-table-content">
									<table class="table table-hover table-bordered">
										<tbody>
											<tr class="tktBackground" ng-repeat="(key,rem) in singleViews.remark">
												<td>{{key + 1}}</td>
												<td><p tooltip-placement="top" tooltip="{{rem.designation}}">{{rem.remarked_by}}</p></td>
												<td class="hidden-xs hidden-sm">{{rem.remarked_on}}</td>
												<td>{{rem.bucket}}</td>
												<td>{{rem.remarks | uppercase}}</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
							</accordion-group>
						</accordion>
						</div>
					</accordion>
					<accordion class="accordion-panel" ng-if="singleViews.request_length != 0">
					  <div class="panel panel-default panel-hovered">
						<accordion class="accordion-panel" >
							<accordion-group is-open="lc_status.open" ng-class="{'panel-info': lc_status.open}">
							<accordion-heading>
								<span class="panel-heading exp_sing">REQUEST ITEMS &nbsp; <i class="mt2 ion small" ng-style="{color : ((lc_status.open) && '#FFF') || '#000'}" ng-class="{'ion-chevron-down': lc_status.open, 'ion-chevron-right': !lc_status.open}"></i></span>
							</accordion-heading>
							<div class="mb20">
								<div ng-if="singleViews.request_length != 0">
									<table class="table table-condensed" >
										<thead>
											<tr>
												<th><a class="tktid">Sr.No</a></th>
												<th><a class="tktid">Item Type</a></th>
												<th><a class="tktid">Description</a></th>
												<th><a class="tktid hidden-xs hidden-sm">Cell Type</a></th>
												<th><a class="tktid">Req Qty</a></th>
												<th><a class="tktid hidden-xs hidden-sm">Sent Qty</a></th>
												<th><a class="tktid hidden-xs hidden-sm">Left Qty</a></th>
												<th ng-if="singleViews.ppc_nhs"><a class="tktid">Clear Qty</a></th>
											</tr>
										<thead>
									</table>
									<div class="div-table-content">
										<table class="table table-hover table-bordered">
											<tbody>
												<tr class="tktBackground" ng-repeat="(key,rem) in singleViews.request_items">
													<td>{{key + 1}}</td>
													<td><p tooltip-placement="top" ng-if="rem.item_type ==1">Cells</p><p tooltip-placement="top" ng-if="rem.item_type ==2">Accessory</p></td>
													<td>{{rem.item_description}}</td>
													<td class="hidden-xs hidden-sm">{{rem.cell_type==1 ? 'NEW':'REVIVED'}}</td>
													<td>{{rem.quantity}}</td>
													<td class="hidden-xs hidden-sm">{{rem.sentquantity}}</td>
													<td class="hidden-xs hidden-sm">{{rem.left_quanty}}</td>
													<td ng-if="singleViews.ppc_nhs">
														<input type="hidden" name="item_code[{{key}}]" ng-model="rem.item_code" value="{{rem.item_code}}"/>
														<input type="hidden" name="cell_type[{{key}}]" ng-model="rem.cell_type" value="{{rem.cell_type}}"/>
														<input class="form-control add_clr" name="clr_qty[{{key}}]" ng-model="clr_qty[key]" data-ng-keyup="parsefloat($event,clr_qty[key],rem.left_quanty);" ng-init="clr_qty[key]=(singleViews.status=='2' || singleViews.status=='0' ? rem.left_quanty : rem.cappr_quanty);" required="required">
													</td>
												</tr>
												<tr class="tktBackground">
													<td colspan="4">Total</td>
													<td>{{singleViews.rQuantity}}</td>
													<td class="hidden-xs hidden-sm">{{singleViews.sQuantity}}</td>
													<td class="hidden-xs hidden-sm">{{singleViews.lQuantity}}</td>
													<td ng-if="singleViews.ppc_nhs">{{clr_qty_total}}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
								</accordion-group>
							</accordion>
							</div>
						</accordion>
                <div class="row form-group pt10" ng-if="!singleViews.ho_check">
					  <div class="col-sm-3">
						<md-input-container flex="" class="md-default-theme md-input-has-value">
						  <label>MRF Number</label>
						  <input value="{{singleViews.mrf_number}}" readonly="readonly">
						</md-input-container>
					  </div>
					  <div class="col-sm-3">
						<md-input-container flex="" class="md-default-theme md-input-has-value">
						  <label>Date Of Request</label>
						  <input value="{{singleViews.date_of_request}}" readonly="readonly">
						</md-input-container>
					  </div>
					  <div class="col-sm-3">
						<md-input-container flex="" class="md-default-theme md-input-has-value">
						  <label>From W/H</label>
						  <input value="{{singleViews.from_wh}}" readonly="readonly">
						</md-input-container>
					  </div>
					  <div class="col-sm-3">
						<md-input-container flex="" class="md-default-theme md-input-has-value">
						  <label>To W/H</label>
						  <input value="{{singleViews.to_wh}}" readonly="readonly">
						</md-input-container>
					  </div>
					  <div class="col-sm-3">
						<md-input-container flex="" class="md-default-theme md-input-has-value">
						  <label>Material Value</label>
						  <input value="{{singleViews.material_value}}" readonly="readonly">
						</md-input-container>
					  </div>
					  <div class="col-sm-3">
						<md-input-container flex="" class="md-default-theme md-input-has-value">
						  <label>Request Status</label>
						  <input value="{{singleViews.status_name}}" readonly="readonly">
						</md-input-container>
					  </div>
					  <div class="col-sm-3" ng-if="singleViews.ticket_id !='0' && singleViews.ticket_id !=''">
						<md-input-container flex="" class="md-default-theme md-input-has-value">
						  <label>Ticket ID</label>
						  <input value="{{singleViews.ticket_id}}" readonly="readonly">
						</md-input-container>
					  </div>
					  <div class="col-sm-3" ng-if="singleViews.sjo_number && singleViews.sjo_number !='0' && singleViews.sjo_number !=''">
						<md-input-container flex="" class="md-default-theme md-input-has-value">
						  <label>SJO Number</label>
						  <input value="{{singleViews.sjo_number}}" readonly="readonly">
						</md-input-container>
					  </div>
					  <div class="col-sm-3" ng-if="singleViews.sjo_date && singleViews.sjo_date !='0' && singleViews.sjo_date !=''">
						<md-input-container flex="" class="md-default-theme md-input-has-value">
						  <label>SJO Date</label>
						  <input value="{{singleViews.sjo_date}}" readonly="readonly">
						</md-input-container>
					  </div>
					  <div class="col-sm-3" ng-if="singleViews.sinv && singleViews.sinv !='0' && singleViews.sinv !=''">
						<md-input-container flex="" class="md-default-theme md-input-has-value">
						  <label>Sales Invoice Number</label>
						  <input value="{{singleViews.sinv}}" readonly="readonly">
						</md-input-container>
					  </div>
					  <div class="col-sm-3" ng-if="singleViews.sind && singleViews.sind !='0' && singleViews.sind !=''">
						<md-input-container flex="" class="md-default-theme md-input-has-value">
						  <label>Sales Invoice Date</label>
						  <input value="{{singleViews.sind}}" readonly="readonly">
						</md-input-container>
					  </div>
					  <div class="col-sm-3" ng-if="singleViews.spon && singleViews.spon !='0' && singleViews.spon !=''">
						<md-input-container flex="" class="md-default-theme md-input-has-value">
						  <label>Sales PO Number</label>
						  <input value="{{singleViews.spon}}" readonly="readonly">
						</md-input-container>
					  </div>
					  <div class="col-sm-3" ng-if="singleViews.ccname && singleViews.ccname !='0' && singleViews.ccname !=''">
						<md-input-container flex="" class="md-default-theme md-input-has-value">
						  <label>Customer Name</label>
						  <input value="{{singleViews.ccname}}" readonly="readonly">
						</md-input-container>
					  </div>
					  <div class="col-sm-3" ng-if="singleViews.ccnumber && singleViews.ccnumber !='0' && singleViews.ccnumber !=''">
						<md-input-container flex="" class="md-default-theme md-input-has-value">
						  <label>Customer number</label>
						  <input value="{{singleViews.ccnumber}}" readonly="readonly">
						</md-input-container>
					  </div>
					  <div class="col-sm-3 md-default-theme" ng-if="singleViews.sjo_file !=''">
						<label>SJO Scanned Copy</label>
						<p><a href="{{singleViews.sjo_file}}" target="_blank">Click Here</a></p>
					  </div>
					  <div class="col-sm-3 md-default-theme" ng-if="singleViews.ccadds && singleViews.ccadds !='0' && singleViews.ccadds !=''">
						  <md-input-container flex="" class="md-default-theme md-input-has-value">
							<label>Customer Address</label>
						   <!-- <p>{{singleViews.ccadds}}</p>-->
							<input value="{{singleViews.ccadds | uppercase}}" readonly="readonly">
						</md-input-container>
					  </div>
					  <div class="col-sm-3 md-default-theme">
						  <md-input-container flex="" class="md-default-theme md-input-has-value">
							<label>Road Permit</label>
							<input value="{{singleViews.road_permit==1 ? 'REQUIRED':'NOT REQUIRED'}}" readonly="readonly">
						</md-input-container>
					  </div>
				</div>

                <div ng-if="singleViews.ho_check">
				<div class="row form-group pt10">
				  <div class="col-sm-3">
					<md-input-container flex="" class="md-default-theme md-input-has-value">
					  <label for="input_A">MRF Number</label>
					  <input value="{{singleViews.mrf_number}}" ng-model="singleViews.mrf_number" class="ng-pristine ng-valid md-input ng-touched" id="input_A" readonly="readonly">
					</md-input-container>
				  </div>
				  <div class="col-sm-3" ng-controller="selfWarehouse">
					<label class="sub_lable">Material Request By</label>
					<select class="form-control selectdrop testSelAll2" name="from_wh" ng-model="from_wh" data-ng-change="itemRequestApprovedTickets(from_wh)" data-ng-init="itemRequestApprovedTickets(singleViews.from_wh_ali)" tabindex="0" autofocus>
					  <option value="">Material Request By</option>
					  <option ng-repeat="mrt in firstDrop" value="{{mrt.alias}}" ng-selected="mrt.alias==singleViews.from_wh_ali" ng-if="mrt.wtype=='0'">{{mrt.name}}</option>
					</select>
				  </div>
				  <div class="col-sm-3 dropalign" ng-controller="materialRequestTo">
					<label class="sub_lable">Material Request To</label>
					<select class="form-control selectdrop testSelAll2" name="to_wh" ng-model="to_wh" tabindex="0">
					  <option value="" selected="selected" disabled="disabled">Material Request To</option>
					  <option ng-repeat="mrt in firstDrop" ng-selected="mrt.alias==singleViews.to_wh_ali" value="{{mrt.alias}}">{{mrt.name}}</option>
					</select>
				  </div>
				  <div class="col-sm-3 dropalign">
					<label class="sub_lable">Ticket ID</label>
					<select class="form-control selectdrop testSelAll2" name="ticketID" ng-model="ticketID" data-ng-change="getitemslistfromticket(ticketID)" data-ng-init="ticketID=singleViews.ticket_ali;" tabindex="0">
					  <option value="">Select Ticket ID</option>
					  <option value="2609" ng-selected="singleViews.ticket_ali=='2609'">Customer Buffer Stock</option>
					  <option ng-repeat="ticketList_1 in ticketList" ng-selected="ticketList_1.ticketAlias==singleViews.ticket_ali" value="{{ticketList_1.ticketAlias}}">{{ticketList_1.ticketId}}</option>
					</select>
				  </div>
				</div>
				<div class="row form-group">
					  <div class="col-sm-3">
						<md-input-container flex="" class="md-default-theme">
						  <label for="input_A">SJO Number</label>
						  <input type="text" value="{{singleViews.sjo_number}}" ng-model="singleViews.sjo_number" name="sjo_number" id="input_A" tabindex="0">
						</md-input-container>
					  </div>
					  <div class="col-sm-3" ng-controller="DatepickerDemoCtrl">
						<md-input-container flex="" class="md-default-theme">
						  <label for="input_00C">SJO Date</label>
						  <input type="text" readonly="readonly" value="{{singleViews.sjo_date}}" ng-model="singleViews.sjo_date" class="datepicker border-bottom" name="sjo_date" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" is-open="opened" min-date="'01-01-2000'" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" tabindex="0"/>
						</md-input-container>
					  </div>
					  <div class="col-sm-3" ng-controller="DatepickerDemoCtrl">
						<label class="sub_lable">SJO Scanned Copy</label>
						<a href="{{singleViews.sjo_file}}" style="padding:5px 10px !important;" target="_blank" class="anchor_bottom border-bottom">Click Here</a>
					  </div>
					  <div class="col-sm-3 filesRow">
					  <input value="{{file_name}}" class="form-control uploadFile" placeholder="SJO Scanned Copy" disabled="disabled"/>
						<div class="fileUpload btn btn-sm btn-info" tooltip="Upload PDF" tooltip-placement="right">
							<span class="ion ion-upload"></span>
							<input type="file" class="upload uploadBtn" name="sjo_file" ng-model="sjo_file" id="sjo_file" onchange="angular.element(this).scope().sjo_scanned_copy(this.files,'pdf')"/>
						</div><p class="small text-danger">only .pdf file & size <=5MB</p>
						 <div ng-if="determinateValue >= '100' ? closeloadings() : ''"></div>
						<div class="mb20" ng-if="prg_shw_hde">
							<md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
						</div>
					  </div>
				</div>
				<div class="row form-group">
					  <div class="col-sm-3">
						<md-input-container flex="" class="md-default-theme">
						  <label for="input_q">Customer Contact Name</label>
						  <input name="ccname" ng-model="singleViews.ccname" value="{{singleViews.ccname}}" id="input_q" tabindex="0">
						</md-input-container>
					  </div>
					  <div class="col-sm-3">
						<md-input-container flex="" class="md-default-theme">
						  <label for="input_q">Customer Contact Number</label>
						  <input type="text" name="ccnumber" valid-input="10" ng-model="singleViews.ccnumber" value="{{singleViews.ccnumber}}" id="input_q" tabindex="0"/>
						</md-input-container>
						<span class="help-block" ng-show="userForm.ccnumber.$dirty && userForm.ccnumber.$invalid">
							<span ng-show="userForm.ccnumber.$error.required">Contact No is Required</span>
							<span ng-show="userForm.ccnumber.$error.minlength">Enter valid Contact No</span>
						</span>
					  </div>
					  <div class="col-sm-3">
						<md-input-container flex="" class="md-default-theme">
						  <label for="input_q">Customer Address</label>
						  <input name="customerAdd" ng-model="singleViews.ccadds" value="{{singleViews.ccadds}}">
						</md-input-container>
					  </div>
					  <div class="col-sm-3">
						<md-input-container flex="" class="md-default-theme">
						  <label for="input_q">Request Add Remarks</label>
						  <input ng-model="singleViews.ho_remark" value="{{singleViews.ho_remark}}" readonly/>
						</md-input-container>
					  </div>
				</div>
				<div class="row form-group">
					  <div class="col-sm-3">
						<md-input-container flex="" class="md-default-theme">
						  <label for="input_q">Sales Invoice Number</label>
						  <input name="sinvoice_number"  ng-model="singleViews.sinv" value="{{singleViews.sinv}}" id="input_q"  tabindex="0" >
						</md-input-container>
					  </div>
					  <div class="col-sm-3" ng-controller="DatepickerDemoCtrl">
						<md-input-container flex="" class="md-default-theme">
						  <label for="input_00C">Sales Invoice Date</label>
						  <input type="text" readonly="readonly" ng-model="singleViews.sind" value="{{singleViews.sind}}" class="datepicker border-bottom" name="sinvoice_date" datepicker-popup="{{format}}" tabindex="0" ng-click="open($event)" ng-focus="open($event)" is-open="opened" min-date="'01-01-2000'" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>
						</md-input-container>
					  </div>
					  <div class="col-sm-3">
						<md-input-container flex="" class="md-default-theme">
						  <label for="input_A">Sales PO Number</label>
						  <input name="po_number" ng-model="singleViews.spon" value="{{singleViews.spon}}" id="input_A" tabindex="0">
						</md-input-container>
					  </div>
					  <div class="col-sm-3">
						<md-input-container flex="" class="md-default-theme md-input-has-value">
						  <label for="input_q">Road Permit</label>
						  <input value="{{ticketList.length>0 ? (ticketList[0].road_permit==1 ? 'REQUIRED':'NOT REQUIRED'):''}}" readonly />
						</md-input-container>
					  </div>
				</div>
				<div class="row col-sm-12">
					  <div class="col-sm-3">
						<textarea class="form-control resizeNone" name="remarks" ng-maxlength="700" ng-model="remarks" placeholder="Enter Remarks"></textarea>
						<span class="help-block" ng-show="userForm.remarks.$dirty && userForm.remarks.$invalid">
							<span ng-show="userForm.remarks.$error.maxlength">Should not enter morethan a 700 characters</span>
						</span>
					  </div>
					  <div class="col-sm-3 dropalign" ng-if="bufferTT==2609" ng-controller="customerdropCntrl">
						<label>Customer</label>
						<select class="form-control selectdrop testSelAll2" name="cust_alias" ng-model="cust_alias">
						  <option value="" selected="selected" disabled="disabled">Select Customer</option>
						  <option ng-repeat="cust in firstDrop" ng-selected="cust.alias==singleViews.customer_alias" value="{{cust.alias}}">{{cust.name}}</option>
						</select>
					  </div>
				</div>
				<div class="row col-sm-12">
				  <div class="header mb20">
					<h4>Required Items
					  <a class="btn btn-info btn-sm" ng-click="addFields(field)">Add Item</a>
					  <a class="btn btn-info btn-sm" ng-click="removeFields(field)">Remove Item</a>
					</h4>
				  </div>
				  <div>
					<!--<div style="max-height:500px; overflow:auto; overflow-x:hidden;">-->
					<div ng-repeat="(key, temlist) in singleViews.itemx">
						<div class="form-group">
						  <div class="col-sm-{{temlist.itemtypeCode == 1 ? 3 : 4}}">
						  <label class="selectlabel">Stock Type</label>
							<select class="form-control testSelAll2 selectdrop" ng-model="temlist.itemtypeCode" name="item_type[]">
							  <option value="" selected="selected">Select Type</option>
							  <option value="1" ng-selected="1==temlist.itemtypeCode">CELL</option>
							  <option value="2" ng-selected="2==temlist.itemtypeCode">ACCESSORIES</option>
							</select>
						  </div>
						  <div class="col-sm-{{temlist.itemtypeCode == 1 ? 3 : 4}}" ng-controller="productdropCntrl" ng-if="temlist.itemtypeCode == 1">
							<label class="selectlabel">Select Cell</label>
							<select class="form-control selectdrop testSelAll2" placeholder="Select Cell" name="item_description[]" ng-model="itemcode.alias">
							  <option value="" selected="selected" disabled="disabled">Select Cell</option>
							  <option ng-repeat="itemcode in firstDrop" ng-selected="itemcode.alias==temlist.itemalias" value="{{itemcode.alias}}">{{itemcode.name}}</option>
							</select>
						  </div>
						  <div class="col-sm-4" ng-controller="accessorydropCntrl" ng-if="temlist.itemtypeCode == 2">
							<input type="hidden" ng-model="cell_type" name="cell_type[]" value="1"/>
							<label class="selectlabel">Select Accessory</label>
							<select class="form-control selectdrop testSelAll2" id="measurement_{{key}}" placeholder="Select Accessory" name="item_description[]" ng-model="itemcode.alias" ng-change="acc_measur_change(key)">
							  <option value="" selected="selected" disabled="disabled">Select Accessory</option>
							  <option ng-repeat="itemcode in firstDrop" ng-selected="itemcode.alias==temlist.itemalias" data="{{itemcode.measure}}" value="{{itemcode.alias}}">{{itemcode.name}}</option>
							</select>
						  </div>
						  <div class="col-sm-{{temlist.itemtypeCode == 1 ? 3 : 4}}" ng-if="temlist.itemtypeCode == 1">
							<label class="selectlabel">Cell Type</label>
							<select class="form-control selectdrop testSelAll2" placeholder="Select Cell Type" name="cell_type[]" ng-model="cell_type">
							  <option value="" selected="selected" disabled="disabled">Select Cell Type</option>
							  <option value="1" ng-selected="1==temlist.cell_type">NEW</option>
							  <option value="2" ng-selected="2==temlist.cell_type">REVIVED</option>
							</select>
						  </div>
						  <div class="col-sm-{{temlist.itemtypeCode == 1 ? 3 : 4}}">
							<md-input-container flex="" class="md-default-theme md-input-has-value">
							  <label for="input_B">Quantity</label>
							  <input type="text" class="ng-pristine ng-valid md-input ng-touched" valid-input="4" id="input_C" name="quantity[]" value="{{temlist.quanty}}" >
							</md-input-container>
						  </div>
						</div>
					  </div>
					<!--</div>-->
					<!--<div style="max-height:500px; overflow:auto; overflow-x:hidden;">-->
					<div class="form-group" ng-repeat="(key,type) in field.itemtype">
					  <div class="col-sm-{{itemType == 1 ? 3 : 4}}">
					  <label class="selectlabel">Stock Type</label>
						<select class="form-control testSelAll2 selectdrop" ng-model="itemType" name="item_type[]">
						  <option value="" selected="selected">Select Type</option>
						  <option value="1">CELL</option>
						  <option value="2">ACCESSORIES</option>
						</select>
					  </div>
					  <div class="col-sm-{{itemType == 1 ? 3 : 4}}" ng-controller="productdropCntrl" ng-if="itemType == 1">
						<label class="selectlabel">Select Cell</label>
						<select class="form-control selectdrop testSelAll2" placeholder="Select Cell" name="item_description[]" ng-model="itemcode.alias">
						  <option value="" selected="selected" disabled="disabled">Select Cell</option>
						  <option ng-repeat="itemcode in firstDrop" value="{{itemcode.alias}}">{{itemcode.name}}</option>
						</select>
					  </div>
					  <div class="col-sm-4" ng-controller="accessorydropCntrl" ng-if="itemType == 2">
						<input type="hidden" ng-model="cell_type" name="cell_type[]" value="1"/>
						<label class="selectlabel">Select Accessory</label>
						<select class="form-control selectdrop testSelAll2" id="measurement_{{key}}" placeholder="Select Accessory" name="item_description[]" ng-model="itemcode.alias" ng-change="acc_measur_change(key)">
						  <option value="" selected="selected" disabled="disabled">Select Accessory</option>
						  <option ng-repeat="itemcode in firstDrop" data="{{itemcode.measure}}" value="{{itemcode.alias}}">{{itemcode.name}}</option>
						</select>
					  </div>
					  <div class="col-sm-{{itemType == 1 ? 3 : 4}}" ng-if="itemType == 1">
						<label class="selectlabel">Cell Type</label>
						<select class="form-control selectdrop testSelAll2" placeholder="Select Cell Type" name="cell_type[]" ng-model="cell_type">
						  <option value="" selected="selected" disabled="disabled">Select Cell Type</option>
						  <option value="1">NEW</option>
						  <option value="2">REVIVED</option>
						</select>
					  </div>
					  <div class="col-sm-{{itemType == 1 ? 3 : 4}}">
						<md-input-container flex="" class="md-default-theme md-input-has-value">
						  <label for="input_C" id="qty_measure_{{key}}">Quantity</label>
						  <input type="text" ng-model="cell_no" valid-input="4" name="quantity[]" id="input_C">
						</md-input-container>
					  </div>
					</div>
					<!--</div>-->
				  </div>
				</div>
				</div>
								
					<div ng-if="singleViews.ppc_nhs">
						<!--<div class="row form-group pt10" ng-show="singleViews.rQuantity" style="text-align:center; background:RGBA(0,0,0,0.1)">
						  <div class="col-xs-4 md-default-theme col-sm-offset-1">
							<label>Requested Quantity</label>
							<p>{{singleViews.rQuantity}}</p>
						  </div>
						  <div class="col-sm-2 col-xs-4 md-default-theme">
							<label>Sent Quantity</label>
							<p>{{singleViews.sQuantity}}</p>
						  </div>
						  <div class="col-xs-4 md-default-theme">
							<label>Left Quantity</label>
							<p>{{singleViews.lQuantity}}</p>
						  </div>
						</div>-->
						<div class="row">
						  <div class="col-sm-4 col-sm-offset-2" ng-controller="DatepickerDemoCtrl">
							<md-input-container flex="" class="intheme">
							  <label for="input_00C">Material Readiness Date</label>
							  <input readonly="readonly" type="text" class="datepicker border-bottom" name="readiness_date" placeholder="Select date.." datepicker-popup="{{format}}" tabindex="1" ng-click="open($event)" ng-focus="open($event)" ng-model="readiness_date" is-open="opened" min-date="dt" max-date="'22-06-2025'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>
							</md-input-container>
							<span class="help-block" ng-show="userForm.readiness_date.$dirty && userForm.readiness_date.$invalid"> <span ng-show="userForm.readiness_date.$error.required">Material Readiness Date Required</span> </span>
						</div>
						  <div class="col-sm-4">
							<md-input-container flex="" class="intheme">
							  <label for="input_00B">Enter Remarks</label>
							  <input ng-model="remarks" class="ng-pristine ng-valid md-input ng-touched" name="remarks" id="input_00B" tabindex="1" aria-invalid="false">
							</md-input-container>
							<span class="help-block" ng-show="userForm.remarks.$dirty && userForm.remarks.$invalid"> <span ng-show="userForm.remarks.$error.required">Remarks Required</span> </span>
						</div>
						</div>
					</div>
					
					<div class="row form-group" ng-if="singleViews.dynamic_check">
						<div class="col-sm-6 mt20">
							<div class="ui-radio ui-radio-primary"> &nbsp; &nbsp; &nbsp; &nbsp;
								<label class="ui-radio-inline">
									<input type="radio" checked="checked" name="approval" value="1"> 
									<span>Approve</span>
								</label> &nbsp; &nbsp; &nbsp; &nbsp;
								<label class="ui-radio-inline">
									<input type="radio" name="approval" value="2"> 
									<span>Reject</span>
								</label> &nbsp; &nbsp; &nbsp; &nbsp;
								<label class="ui-radio-inline">
									<input type="radio" name="approval" value="3"> 
									<span>Hold</span>
								</label>
							</div>
						</div>
					  <div class="col-sm-6">
						<textarea class="form-control resizeNone" name="remarks" ng-model="remarks" ng-maxlength="700" placeholder="Enter Remarks"></textarea>
						<span class="help-block" ng-show="userForm.remarks.$dirty && userForm.remarks.$invalid">
							<span ng-show="userForm.remarks.$error.maxlength">Should not enter morethan a 700 characters</span>
						</span>
					  </div>
					</div>
					<div ng-if="singleViews.admin_priv || singleViews.nhs_priv">
						<div class="row">
						  <div class="col-sm-8 col-sm-offset-2">
							<md-input-container flex="" class="intheme">
							  <label for="input_00B">Enter Remarks For Short Close Request</label>
							  <textarea rows="2" name="remarks" ng-model="remarks" class="ng-pristine ng-valid md-input ng-touched form-control resize-v">{{rem.remarks}}</textarea>
							  <!--<input ng-model="remarks" class="ng-pristine ng-valid md-input ng-touched" name="remarks" id="input_00B" tabindex="1" aria-invalid="false">-->
							</md-input-container>
							<span class="help-block" ng-show="userForm.remarks.$dirty && userForm.remarks.$invalid"> <span ng-show="userForm.remarks.$error.required">Remarks Required</span> </span>
						  </div>
						</div>
					</div>
				</div>
				<div class="row form-group mt20">   
					<div class="col-sm-8 col-sm-offset-2" align="center">
						<button type="submit" click-once class="btn btn-info btn-sm">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	setInterval(function(){
		$('.testSelAll2').SumoSelect();
		$('.testSelAll3').SumoSelect({selectAll:true});
		$('.forms_add').find('.SumoSelect').addClass('singleSelect');
	},0);
</script>