<style>
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
.col-sm-3{margin-bottom:15px;}

</style>
<div class="modal-style" ng-controller="matrialoutwatdAddcCtlr">
	<div ng-controller="addFieldsCtrl">
		<div class="modal-header clearfix">
			<h4 class="modal-title">Create Material Outward</h4>
			<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span> </div>
		<div class="modal-body" ng-controller="addingform">
			<!--<div class="toast toast-topRight">
				<alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
					<div ng-bind-html="toast.msg"></div>
				</alert>
			</div>-->
			<form class="form-horizontal forms_add" name="matrialoutwardwatdForm" data-went="#/Materialoutward" method="post" url="services/inventory/matrialoutwardwatdAdd" ng-submit="sendPost();"  ng-repeat="field in forms" novalidate>
				<div class="row form-group">
					<div class="col-sm-3" ng-controller="selfWarehouse">
						<label class="selectlabel">Material Sending From</label>
						<select class="form-control testSelAll2 selectdrop" name="from_wh" ng-model="from_wh" data-ng-change="material_to(from_wh); ware_bal_count(from_wh);">
							<option value="" selected="selected" disabled="disabled">Material Sending From</option>
							<option ng-repeat="mrt in firstDrop" value="{{mrt.alias}}">{{mrt.name}}</option>
						</select>
					</div>
					<div class="col-sm-3">
						<label class="selectlabel">Material Sending To</label>
						<select class="form-control testSelAll2 selectdrop" name="materialToType" ng-model="material" data-ng-change="material_to(material)">
							<option value="">Material Sending To</option>
							<option value="1" ng-if="empfac.faccheka=='0'">SITE</option>
							<option value="2" ng-if="empfac.faccheka=='0'">FACTORY (Scrap Cells)</option>
							<option value="3">W/H</option>
						</select>
					</div>
<!--From Warehouse to Site START-->
					<div ng-if="materialTo == 1" ng-controller="ticketsList_mo"><!-- SITE -->
						<div class="col-sm-3">
							<label class="selectlabel">Ticket ID</label>
							<select class="form-control testSelAll2 selectdrop" ng-model="ref_no" name="ref_no" data-ng-change="getrequiredCellsTickets(ref_no)">
								<option value="" selected="selected" disabled="disabled">{{firstDrop.length!='0' ? 'Select Ticket ID':'No Records Found'}}</option>
								<option value="2609">Customer Buffer Stock</option>
								<option ng-repeat="optionlist in firstDrop" value="{{optionlist.alias}}">{{optionlist.name}}</option>
							</select>
						</div>
                        
                        <div class="col-sm-3" ng-if="materialTo == 1 && datas.sjo_check_result=='1'" ng-controller="buffersjolist_scrp_full_out"><!-- SITE -->
                          <label class="selectlabel">SJO Number</label>
                            <select class="form-control testSelAll2 selectdrop" ng-model="main_sjo_id" name="main_sjo_number">
                              <option value="" selected="selected" disabled="disabled">Select SJO Number</option>
                              <option ng-repeat="optionlist in firstDrop" value="{{optionlist.alias_a}}">{{optionlist.name_a}}</option>
                            </select>
                        </div>
                        
						<div class="col-sm-3" ng-if="ref_no == 2609" ng-controller="buffersjolist">
							<label class="selectlabel">SJO Number</label>
							<select class="form-control testSelAll2 selectdrop" ng-model="buffer_sjo_id" name="buffer_sjo" data-ng-change="getbufferstocksforow(buffer_sjo_id)">
								<option value="" selected="selected" disabled="disabled">Select SJO Number</option>
								<option ng-repeat="optionlist in firstDrop" value="{{optionlist.alias}}">{{optionlist.name}}</option>
							</select>
						</div>
					</div>
<!--From Warehouse to Site END-->

<!--From Warehouse to Factory Scrap START-->
					<div class="col-sm-3" ng-if="materialTo == 2" ng-controller="sjoFullListforScrap"><!-- Factory -->
						<input type="hidden" name="outstand_check" value="{{outstand_count}}" ng-model="outstand_count" />
						<label class="selectlabel">SJO Number</label>
						<select class="form-control testSelAll2 selectdrop" ng-model="ref_no" data-ng-change="scraplistcells(ref_no)" name="ref_no">
							<option value="" selected="selected" disabled="disabled">Select SJO Number</option>
							<option value="NA">NON SJO</option>
							<option ng-repeat="optionlist in firstDrop" data-count="{{optionlist.count_a}}" value="{{optionlist.alias_a}}">{{optionlist.name_a}} ({{optionlist.count_a}})</option>
						</select>
					</div>
<!--From Warehouse to Factory Scrap END-->

<!--From Factory/Warehouse to Warehouse START-->
					<div ng-if="materialTo == 3"><!-- W/H -->
						<div class="col-sm-3 dropalign" ng-controller="mrf_nhsapproved">
							<label ng-if="empfac.faccheka=='0'"  class="selectlabel">MRF Number</label>
							<label ng-if="empfac.faccheka=='1'"  class="selectlabel">SJO Number</label>
							<select ng-if="empfac.faccheka=='0'" class="form-control testSelAll2 selectdrop" placeholder="MRF Number" name="ref_no" ng-model="from_mrf_no" data-ng-change="getitemslistfromsjo(from_mrf_no)">
								<option value="" selected="selected" disabled="disabled">Select MRF Number</option>
								<option ng-repeat="segment in firstDrop" value="{{segment.alias}}">{{segment.name}}</option>
							</select>
							<select ng-if="empfac.faccheka=='1'" class="form-control testSelAll2 selectdrop" name="ref_no" ng-model="from_mrf_no" data-ng-change="getitemslistfromsjo(from_mrf_no)">
								<option value="" selected="selected" disabled="disabled">Select SJO Number</option>
								<option ng-repeat="segment in firstDrop" value="{{segment.alias}}">{{segment.sjo}}</option>
							</select>
						</div>
						<div class="col-sm-3">
							<md-input-container flex="" class="md-default-theme md-input-has-value">
								<label for="input_00D">State</label>
								<input value="{{datas.ehfrommrf}}" ng-modal="datas.ehfrommrf" class="ng-pristine ng-valid md-input ng-touched" id="input_00D" tabindex="0" aria-invalid="false" readonly="readonly">
							</md-input-container>
						</div>
					</div>
<!--From Factory/warehouse to Warehouse END--> 

<!--For All START--> 
					<div class="col-sm-3" ng-if="materialTo == 3 && datas.road_permit.length>0">
						<md-input-container flex="" class="md-default-theme md-input-has-value">
							<label for="input_00D">Road Permit</label>
							<input value="{{datas.road_permit==1 ? 'REQUIRED':'NOT REQUIRED'}}" ng-modal="datas.road_permit==1 ? 'REQUIRED':'NOT REQUIRED'" class="ng-pristine ng-valid md-input ng-touched" id="input_00D" tabindex="0" aria-invalid="false" readonly="readonly">
						</md-input-container>
					</div>
					<div class="col-sm-3" ng-controller="emprolenameCntrl">
						<label class="selectlabel">Responsible Engineer</label>
						<select class="form-control selectdrop testSelAll2" name="resengineer">
							<option value="" selected="selected" disabled="disabled">Responsible Engineer</option>
							<option ng-repeat="emp in firstDrop" value="{{emp.alias}}">{{emp.name}}</option>
						</select>
					</div>
					<div class="col-sm-3" style="margin-bottom:14px" ng-controller="DatepickerDemoCtrl">
						<md-input-container flex="" class="md-default-theme">
							<label for="input_00C">Dispatch Date</label>
							<input readonly="readonly" type="text" class="datepicker border-bottom" name="invoice_date" placeholder="Select date.." datepicker-popup="{{format}}" tabindex="1" ng-click="open($event)" ng-focus="open($event)" ng-model="invoiceDate" is-open="opened" min-date="'01-01-2000'" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" required="required"/>
						</md-input-container>
						<span class="help-block" ng-show="matrialoutwardwatdForm.invoice_date.$dirty && matrialoutwardwatdForm.invoice_date.$invalid"> <span ng-show="matrialoutwardwatdForm.invoice_date.$error.required">Invoice Date is Required</span> </span> </div>
					<div class="col-sm-3">
						<md-input-container flex="" class="md-default-theme">
							<label for="input_00D">Transporter Details</label>
							<input type="text" ng-model="transporter" name="transporterDetails" class="ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false"/>
						</md-input-container>
					</div>
					
					<div class="col-sm-3">
						<md-input-container flex="" class="md-default-theme">
							<label for="input_00D">Docket Number</label>
							<input type="text" ng-model="docket" name="docket" class="ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false"/>
						</md-input-container>
					</div>
					<div class="col-sm-3">
						<textarea rows="2" name="remarks" ng-model="remarks" ng-maxlength="700" class="form-control resize-v" placeholder="Remarks/ Contact Details" required></textarea>
						<span class="help-block" ng-show="matrialoutwardwatdForm.remarks.$dirty && matrialoutwardwatdForm.remarks.$invalid">
							<span ng-show="matrialoutwardwatdForm.remarks.$error.maxlength">Should not enter morethan a 700 characters</span>
							<span ng-show="matrialoutwardwatdForm.remarks.$error.required">Remarks is Required</span>
						</span>
					</div>
				</div>
<!--For All END--> 

	<accordion class="accordion-panel" ng-if="bal_show.records>'0'">
	  <div class="panel panel-default panel-hovered">
		<!--<div class="panel-heading exp_sing">REMARKS</div>-->
		<accordion class="accordion-panel" >
			<accordion-group is-open="lc_status.open" ng-class="{'panel-info': lc_status.open}">
			<accordion-heading>
				Available Stock In <span style="font-weight:bold">{{wh_name}}</span> Warehouse &nbsp; <i class="mt2 ion small" ng-class="{'ion-chevron-down': lc_status.open, 'ion-chevron-right': !lc_status.open}"></i>
			</accordion-heading>
				<div class="mb20">
					<table class="table table-condensed" >
						<thead>
							<tr>
								<th><a class="tktid">Sr.No</a></th>
								<th><a class="tktid">Item Description</a></th>
								<th><a class="tktid">Item Condition</a></th>
								<th><a class="tktid">Quantity</a></th>
							</tr>
						<thead>
					</table>
					<div class="">
						<table class="table table-hover table-bordered">
							<tbody>
								<tr class="tktBackground" ng-repeat="(key,ware) in bal_show.ware_bal">
									<td>{{key + 1}}</td>
									<td>{{ware.item_code}}</td>
									<td class="hidden-xs hidden-sm">{{ware.condition_id}}</td>
									<td style="word-wrap:break-word">{{ware.count}}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</accordion-group>
		</accordion>
		</div>
	</accordion>
	<div class="row col-sm-12 mb20" style="color:#F00;text-align:center;font-weight:bold" ng-if="bal_show.records=='0'">
		NO STOCK AVAILABLE IN {{wh_name}} WAREHOUSE
	</div>

<!--From Warehouse to Factory START-->
				<div class="row col-sm-12" ng-if="materialTo==2 && singleViews.itemcount==1"><!-- Factory -->
					<div class="header">
						<h4 class="tkt-heading">Shipping Items</h4>
					</div>
					<div style="max-height:500px; overflow:auto; overflow-x:hidden;">
						<div class="form-group" ng-repeat="(key, temlist) in singleViews.srapi">
							<div class="col-sm-2">
								<md-input-container flex="" class="md-default-theme md-input-has-value">
									<label for="input_00D">Sl No.</label>
									<input type="hidden" name="scrapCellAlias[{{key}}]" value="{{temlist.alias}}">
									<input class="ng-pristine ng-valid md-input ng-touched" readonly="readonly" value="{{key+1}}" >
								</md-input-container>
							</div>
							<div class="col-sm-4">
								<md-input-container flex="" class="md-default-theme md-input-has-value">
									<label for="input_00D">Product Description</label>
									<input class="ng-pristine ng-valid md-input ng-touched" readonly="readonly" value="{{temlist.Productname}}" >
								</md-input-container>
							</div>
							<div class="col-sm-4">
								<md-input-container flex="" class="md-default-theme md-input-has-value">
									<label for="input_00D">Cell number</label>
									<input class="ng-pristine ng-valid md-input ng-touched" readonly="readonly" value="{{temlist.name}}">
								</md-input-container>
							</div>
							<div class="col-sm-2">
								<div class="ui-checkbox ui-checkbox-info input-sm" style="padding-top:25px;">
									<input type="hidden" name="sendx[key]" value="1">
									<label>
										<input type="checkbox" name="sendx[{{key}}]" checked value="1">
										<span></span>Send</label>
								</div>
							</div>
						</div>
					</div>
				</div>
<!--From Warehouse to Factory END-->

<!--From Factory to Warehouse START-->
				<div class="row col-sm-12">
					<div class="header" ng-if="datas.itemcount==1">
						<h4 class="tkt-heading mb20">Shipping Items</h4>
					</div>
					<!--<div style="max-height:500px; overflow:auto; overflow-x:hidden;">-->
						<div ng-repeat="(key, temlist) in datas.itemx">
							<input type="hidden" name="itemalias[{{key}}]" value="{{temlist.itemalias}}" ng-model="temlist.itemalias" />
							<input type="hidden" name="itemTypes[{{key}}]" value="{{temlist.itemtype}}" ng-model="temlist.itemtype" />
							<input type="hidden" name="cell_type[{{key}}]" value="{{temlist.cell_type}}" ng-model="temlist.cell_type" />
							
							<div class="form-group">
								<div class="col-sm-3">
									<md-input-container flex="" class="md-default-theme md-input-has-value">
										<label for="input_A">Stock Type</label>
										<input value="{{temlist.itemtype}}" class="ng-pristine ng-valid md-input ng-touched" id="input_A" readonly="readonly">
									</md-input-container>
								</div>
								<div class="col-sm-3">
									<md-input-container flex="" class="md-default-theme md-input-has-value">
										<label for="input_B">{{temlist.itemtype=='CELLS' ? 'Product' :'Accessory'}} Description</label>
										<input value="{{temlist.itemdesc}}" class="ng-pristine ng-valid md-input ng-touched" id="input_B" readonly="readonly">
									</md-input-container>
								</div>
								<div class="col-sm-3">
									<md-input-container flex="" class="md-default-theme md-input-has-value">
										<label for="input_C">Required Quantity</label>
										<input value="{{temlist.quanty}}" name="req_qty[{{key}}]" class="ng-pristine ng-valid md-input ng-touched" id="input_C" readonly="readonly">
									</md-input-container>
								</div>
								<div class="col-sm-3" ng-if="materialTo == 1 && temlist.itemtype=='ACCESSORIES' && temlist.acc_desc!='0'">
									<md-input-container flex="" class="md-default-theme md-input-has-value">
										<label for="input_D">Send Quantity</label>
										<input value="{{temlist.acc_desc}}" type="hidden" name="cellnumbers[{{key}}][]">
										<input value="{{temlist.quanty}}" class="ng-pristine ng-valid md-input ng-touched" id="input_D" tabindex="0" aria-invalid="false" readonly="readonly">
									</md-input-container>
								</div>
								<div class="col-sm-3" ng-if="materialTo != 1 && temlist.itemtype=='ACCESSORIES' && temlist.acc_desc!='0'">
									<md-input-container flex="" class="md-default-theme md-input-has-value">
										<label for="input_D">Send Quantity</label>
										<input value="{{temlist.acc_desc}}" type="hidden" name="cellnumbers[{{key}}][]">
										<input value="{{temlist.cappr_quanty}}" class="ng-pristine ng-valid md-input ng-touched" id="input_D" tabindex="0" aria-invalid="false" readonly="readonly">
									</md-input-container>
								</div>
								<div class="col-sm-3" ng-if="materialTo == 3 && temlist.itemtype=='CELLS'"><!-- W/H -->
									<md-input-container flex="" class="md-default-theme md-input-has-value">
										<label for="input_R">Send Quantity{{temlist.celldrop.norec}}</label>
										<input value="{{temlist.celldrop.norec==0 ? '' : dellss.alias1}}" type="hidden" name="cellnumbers[{{key}}][]" ng-repeat="dellss in temlist.celldrop"/>
										<input value="{{temlist.celldrop.norec==0 ? 'NO RECORDS' : temlist.celldrop.length}}" class="ng-pristine ng-valid md-input ng-touched" id="input_R" tabindex="0" aria-invalid="false" readonly="readonly"/>
									</md-input-container>
                                    <!--<div class="col-sm-3 " ng-if="temlist.itemtype=='CELLS'">
                                        <label class="selectlabel">Cell Number</label>
                                        <select class="testSelAll3 form-control selectdrop disb" ng-disabled="true" multiple="multiple" name="cellnumbers[{{key}}][]" placeholder="Select Cell Number" >
												<option ng-repeat="dellss in temlist.celldrop" selected="selected" value="{{dellss.alias1}}">{{dellss.name1}}</option>
                                        </select>
                                    </div>-->
                                </div>
                                <div ng-if="materialTo == 1"><!-- SITE -->
                                    <div class="col-sm-3 " ng-if="temlist.itemtype=='CELLS'">
                                        <label class="selectlabel">Cell Number</label>
                                        <select class="testSelAll3 form-control selectdrop" multiple="multiple" name="cellnumbers[{{key}}][]" placeholder="Select Cell Number" >
                                            <option ng-repeat="dellss in temlist.celldrop" value="{{dellss.alias1}}">{{dellss.name1}}</option>
                                        </select>
                                    </div>
                                </div>
							</div>
						</div>
					<!--</div>-->
				</div>
<!--From Factory to Warehouse END-->

<!--From Warehouse to Site START-->
				<div class="row col-sm-12" ng-if="buffer_stocks.itemcount==1">
					<div class="header">
						<h4 class="tkt-heading">Shipping Items</h4>
					</div>
					<div style="max-height:500px; overflow:auto; overflow-x:hidden;">
						<div ng-repeat="(key, temlist) in buffer_stocks.itemx">
							<div class="form-group">
								<div class="col-sm-1">
									<md-input-container flex="" class="md-default-theme md-input-has-value">
										<label>Sr. No.</label>
										<input value="{{(key+1)}}" readonly="readonly">
									</md-input-container>
								</div>
								<div class="col-sm-2">
									<md-input-container flex="" class="md-default-theme md-input-has-value">
										<label>Item Type</label>
										<input value="{{temlist.itemtype_text}}" readonly="readonly">
									</md-input-container>
								</div>
								<div class="col-sm-3">
									<md-input-container flex="" class="md-default-theme md-input-has-value">
										<label>{{temlist.itemtype=='1' ? 'Battery Rating' : 'Description'}}</label>
										<input value="{{temlist.itemcode}}" readonly="readonly">
									</md-input-container>
								</div>
								<div class="col-sm-3" ng-if="temlist.itemtype=='1'">
									<md-input-container flex="" class="md-default-theme md-input-has-value">
										<label>Cell Serial Number</label>
										<input value="{{temlist.itemdesc}}" readonly="readonly">
									</md-input-container>
								</div>
                                
                                <div class="col-sm-2" ng-if="temlist.itemtype=='2'" ng-repeat="(key,gdl) in temlist.itemcondition">
									<md-input-container flex="" class="md-default-theme md-input-has-value">
										<label>{{gdl.title}}</label>
										<input value="{{gdl.quantity}}" readonly="readonly">
									</md-input-container>
								</div>
                                
								<div class="col-sm-3" ng-if="temlist.itemtype=='1'">
									<md-input-container flex="" class="md-default-theme md-input-has-value">
										<label>Cell Condition</label>
										<input value="{{temlist.itemcondition}}" readonly="readonly">
									</md-input-container>
								</div>
							</div>
						</div>
					</div>
				</div>
<!--From Warehouse to Site END-->
				<div class="row form-group">
					<div class="col-sm-6 col-sm-offset-3" align="center">
						<button type="submit" click-once class="btn btn-info btn-sm" ng-disabled="matrialoutwardwatdForm.$invalid">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- materialTo
	1 -> SITE
	2 -> FACTORY (Scrap Cells)
	3 -> W/H
-->
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