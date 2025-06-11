<style>
.form-group {
	margin-bottom: 15px;
}
.form-group div.col-sm-4 {
	margin-bottom: 15px;
}
.modal-header > .close {
	right: -30px;
	top: -12px;
}
.singleSelect {
	width: 100%;
	border-bottom: 1px solid #e0e0e0;
}
.SumoSelect > .optWrapper {
	right: 0px !important;
}
.SumoSelect > .CaptionCont > span.placeholder {
	color: #ccc !important;
}
.singleSelect > .CaptionCont > label > i {
	color: #000;
}
.SumoSelect > .optWrapper.open {
	top: 33px !important;
}
.resizeNone{
	resize:none;
}
</style>
<div class="modal-style" ng-controller="materialRequestAdd">
  <div ng-controller="addFieldsCtrl">
    <div class="modal-header clearfix">
      <h4 class="modal-title">Material Request Form</h4>
      <span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span> </div>
    <div class="modal-body" ng-controller="addingform">
      <!--<div class="toast toast-topRight">
        <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
          <div ng-bind-html="toast.msg"></div>
        </alert>
      </div>-->
      <form class="form-horizontal forms_add" name="userForm" role="form" data-went="#/Materialrequest" method="post" url="services/inventory/material_request_add" ng-submit="sendPost()" ng-repeat="field in forms" novalidate>
        <div class="row form-group">
          <div class="col-sm-4">
            <md-input-container flex="" class="md-default-theme md-input-has-value">
              <label for="input_A">MRF Number</label>
              <input value="{{singleViews.rand}}" name="mrf_number" ng-model="singleViews.rand" class="ng-pristine ng-valid md-input ng-touched" id="input_A" readonly="readonly">
            </md-input-container>
          </div>
          <div class="col-sm-4" ng-controller="selfWarehouse">
            <label>Material Request By</label>
            <select class="form-control selectdrop testSelAll2" name="from_wh" ng-model="from_wh" data-ng-change="itemRequestApprovedTickets(from_wh)" tabindex="0" autofocus>
              <option value="" selected="selected" disabled="disabled">Material Request By</option>
              <option ng-repeat="mrt in firstDrop" value="{{mrt.alias}}" ng-if="mrt.wtype=='0'">{{mrt.name}}</option>
            </select>
          </div>
          <div class="col-sm-4 dropalign" ng-controller="materialRequestTo">
            <label>Material Request To</label>
            <select class="form-control selectdrop testSelAll2" name="to_wh" ng-model="to_wh" tabindex="0">
              <option value="" selected="selected" disabled="disabled">Material Request To</option>
              <option ng-repeat="mrt in firstDrop" value="{{mrt.alias}}">{{mrt.name}}</option>
            </select>
          </div>
        </div>
		
			<div class="row form-group" ng-if="datasflo.facchek ==1">
				  <div class="col-sm-4 dropalign">
					<label>Ticket ID</label>
					<select class="form-control selectdrop testSelAll2" name="ticketID" ng-model="ticketID" data-ng-change="getitemslistfromticket(ticketID)" tabindex="0">
					  <option value="" selected="selected">Select Ticket ID</option>
					  <option value="2609">Customer Buffer Stock</option>
					  <option ng-repeat="ticketList_1 in ticketList" value="{{ticketList_1.ticketAlias}}">{{ticketList_1.ticketId}}</option>
					</select>
				  </div>
				  <div class="col-sm-4">
					<md-input-container flex="" class="md-default-theme">
					  <label for="input_A">SJO Number</label>
					  <input name="sjo_number" id="input_A" tabindex="0">
					</md-input-container>
				  </div>
				  <div class="col-sm-4" ng-controller="DatepickerDemoCtrl">
					<md-input-container flex="" class="md-default-theme">
					  <label for="input_00C">SJO Date</label>
					  <input type="text" readonly="readonly" class="datepicker border-bottom" name="sjo_date" datepicker-popup="{{format}}" ng-click="open($event)" ng-focus="open($event)" ng-model="sjoDate" is-open="opened" min-date="'01-01-2000'" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" tabindex="0"/>
					</md-input-container>
				  </div>
			</div>
			
			
			<div class="row form-group" ng-if="datasflo.facchek ==1">
				  <div class="col-sm-4 filesRow">
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
				  
				  <div class="col-sm-4">
					<md-input-container flex="" class="md-default-theme">
					  <label for="input_q">Sales Invoice Number</label>
					  <input name="sinvoice_number" ng-model="datas.sale_invoice_num" value="{{datas.sale_invoice_num}}" id="input_q"  tabindex="0" >
					</md-input-container>
				  </div>
				  <div class="col-sm-4" ng-controller="DatepickerDemoCtrl">
					<md-input-container flex="" class="md-default-theme">
					  <label for="input_00C">Sales Invoice Date</label>
					  <input type="text" readonly="readonly" ng-model="datas.sale_invoice_date" value="{{datas.sale_invoice_date}}" class="datepicker border-bottom" name="sinvoice_date" datepicker-popup="{{format}}" tabindex="0" ng-click="open($event)" ng-focus="open($event)" is-open="opened" min-date="'01-01-2000'" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>
					</md-input-container>
				  </div>
			</div>
		
		<div class="row form-group">
			  <div class="col-sm-4">
				<md-input-container flex="" class="md-default-theme">
				  <label for="input_A">Sales PO Number</label>
				  <input name="po_number" ng-model="datas.po_num" value="{{datas.po_num}}" id="input_A" tabindex="0">
				</md-input-container>
			  </div>
			  <div class="col-sm-4">
				<md-input-container flex="" class="md-default-theme">
				  <label for="input_q">Customer Contact Name</label>
				  <input name="ccname" id="input_q" tabindex="0">
				</md-input-container>
			  </div>
			  <div class="col-sm-4">
				<md-input-container flex="" class="md-default-theme">
				  <label for="input_q">Customer Contact Number</label>
				  <input type="text" name="ccnumber" class="ng-pristine ng-valid md-input ng-touched" valid-input="10" id="input_q" tabindex="0" required/>
				</md-input-container>
				<span class="help-block" ng-show="userForm.ccnumber.$dirty && userForm.ccnumber.$invalid">
					<span ng-show="userForm.ccnumber.$error.required">Contact No is Required</span>
					<span ng-show="userForm.ccnumber.$error.minlength">Enter valid Contact No</span>
				</span>
			  </div>
		</div>
		
		<div class="row form-group">
			  <div class="col-sm-4">
				<textarea class="form-control resizeNone" name="customerAdd" ng-model="customerAdd" placeholder="Customer Address"></textarea>
			  </div>
			  <div class="col-sm-4">
				<textarea class="form-control resizeNone" name="remarks" ng-maxlength="700" ng-model="remarks" placeholder="Enter Remarks"></textarea>
				<span class="help-block" ng-show="userForm.remarks.$dirty && userForm.remarks.$invalid">
					<span ng-show="userForm.remarks.$error.maxlength">Should not enter morethan a 700 characters</span>
				</span>
			  </div>
			  <div class="col-sm-4">
				<md-input-container flex="" class="md-default-theme md-input-has-value">
				  <label for="input_q">Road Permit</label>
				  <input value="{{ticketList.length>0 ? (ticketList[0].road_permit==1 ? 'REQUIRED':'NOT REQUIRED') : ''}}" readonly />
				</md-input-container>
			  </div>
		</div>
		
		<div class="row form-group" ng-if="datasflo.facchek ==1">
			  <div class="col-sm-4 dropalign" ng-if="bufferTT==2609" ng-controller="customerdropCntrl">
				<label>Customer</label>
				<select class="form-control selectdrop testSelAll2" name="cust_alias" ng-model="cust_alias">
				  <option value="" selected="selected">Select Customer</option>
				  <option ng-repeat="cust in firstDrop" value="{{cust.alias}}">{{cust.name}}</option>
				</select>
			  </div>
				  
			  <div class="col-sm-4 dropalign">
				<label>Transit Damaged</label>
				<select class="form-control selectdrop testSelAll2" name="transit_damaged" ng-model="transit_damaged">
				  <option value="" selected="selected">Select</option>
				  <option value="1">Yes</option>
				  <option value="0">No</option>
				</select>
			  </div>
			  <div class="col-sm-4 dropalign" ng-if="transit_damaged=='1'">
				<label>Material amount range</label>
				<select class="form-control selectdrop testSelAll2" name="amount_range" ng-model="amount_range">
				  <option value="" selected="selected">Select</option>
				  <option value="1">&lt;= 59,999</option>
				  <option value="2">&gt;= 60,000</option>
				</select>
			  </div>
        </div>
        <div class="row col-sm-12">
          <div class="header mb20" ng-if="userForm.ticketID.$dirty && bufferTT !=''">
            <h4>Required Items
              <a ng-if="bufferTT==2609" class="btn btn-info btn-sm" ng-click="addFields(field)">Add Item</a>
              <a ng-if="bufferTT==2609" class="btn btn-info btn-sm" ng-click="removeFields(field)">Remove Item</a>
            </h4>
          </div>
          <div>
			<!--<div style="max-height:500px; overflow:auto; overflow-x:hidden;">-->
            <div ng-repeat="(key, temlist) in datas.itemx">
                <input type="hidden" name="item_description[]" value="{{temlist.itemalias}}" ng-model="temlist.itemalias" />
                <input type="hidden" name="item_type[]" value="{{temlist.itemtypeCode}}" ng-model="temlist.itemtypeCode" />
                <input type="hidden" name="cell_type[]" value="1" ng-model="cell_type" ng-if="temlist.itemtypeCode==2"/>
                <div class="form-group">
                  <div class="col-sm-{{temlist.itemtypeCode == 1 ? 3 : 4}}">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                      <label for="input_A">Stock Type</label>
                      <input value="{{temlist.itemtype}}" class="ng-pristine ng-valid md-input ng-touched" id="input_A" readonly="readonly">
                    </md-input-container>
                  </div>
                  <div class="col-sm-{{temlist.itemtypeCode == 1 ? 3 : 4}}">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                      <label for="input_B">Product Description</label>
                      <input value="{{temlist.itemdesc}}" class="ng-pristine ng-valid md-input ng-touched" id="input_B" readonly="readonly">
                    </md-input-container>
                  </div>
				  <div class="col-sm-{{temlist.itemtypeCode == 1 ? 3 : 4}}" ng-if="temlist.itemtypeCode == 1">
					<label class="selectlabel">Cell Type</label>
					<select class="form-control selectdrop testSelAll2" placeholder="Select Cell Type" name="cell_type[]" ng-model="cell_type">
					  <option value="" selected="selected" disabled="disabled">Select Cell Type</option>
					  <option value="1">NEW</option>
					  <option value="2">REVIVED</option>
					</select>
				  </div>
                  <div class="col-sm-{{temlist.itemtypeCode == 1 ? 3 : 4}}">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                      <label for="input_B">Quantity</label>
                      <input type="text" class="ng-pristine ng-valid md-input ng-touched" valid-input="4" id="input_C" name="quantity[]" value="{{temlist.quanty}}" readonly="readonly">
                    </md-input-container>
                  </div>
                </div>
              </div>
            <!--</div>-->
			<!--<div style="max-height:500px; overflow:auto; overflow-x:hidden;">-->
            <div ng-if="bufferTT==2609" class="acc_measure form-group" ng-repeat="(key,type) in field.itemtype">
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
                  <input type="text" valid-input="4" ng-model="cell_no" name="quantity[]" id="input_C">
                </md-input-container>
              </div>
            </div>
			<!--</div>-->
          </div>
        </div>
        <div class="row form-group">
          <div class="col-sm-8 col-sm-offset-2 mt30" align="center">
            <button type="submit" click-once class="btn btn-info btn-sm" ng-disabled="prg_shw_hde || userForm.remarks.$dirty && userForm.remarks.$invalid">Request</button>
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