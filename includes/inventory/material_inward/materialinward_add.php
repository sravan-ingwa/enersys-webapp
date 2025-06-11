<style>
.form-group {
	margin-bottom: 0px !important;
}
.form-group div.col-sm-4 {
	margin-bottom: 15px;
}
.modal-header > .close {
	right: -30px;
	top: -12px;
}
.btn-default {
	border-color: transparent !important;
	border-bottom: 1px solid #e0e0e0 !important;
}
.autoselect {
	padding-top: 22px !important;
}
.upload-file {
	border-bottom: 1px solid rgba(0,0,0,0.12);
}
.ui-select-bootstrap > .ui-select-search:focus {
	border: none;
	background: #FFF !important;
}
.ui-select-bootstrap > .ui-select-match > button {
	text-align: left !important;
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
.form-controlll {
    height: 38px;
    font-size: 14px;
    line-height: 1.57142857;
    color: #555555;
    background-color: #ffffff;
    background-image: none;
    border: 1px solid #e0e0e0;
    border-radius: 2px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    -webkit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
}
.col-sm-3{margin-bottom:15px;}
</style>
<div class="modal-style" ng-controller="matrialinwardwatdAddcCtlr"> <!-- wrapper for specific style -->
  <div ng-controller="addFieldsCtrl">
    <div class="modal-header clearfix">
      <h4 class="modal-title">Create Material Inward</h4>
      <span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span> </div>
    <div class="modal-body" ng-controller="addingform">
      <!--<div class="toast toast-topRight">
        <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
          <div ng-bind-html="toast.msg"></div>
        </alert>
      </div>-->
      <form class="form-horizontal forms_add" name="matrialinwardwatdForm" data-went="#/Materialinward" method="post" url="services/inventory/matrialinwardwatdAdd" ng-submit="sendPost()" ng-repeat="field in forms" novalidate>
        <div class="row form-group mb10">
          <div class="col-sm-3" ng-controller="selfWarehouse">
          	<label class="selectlabel">Material Receiving By(Wh)</label>
            <select class="form-control testSelAll2 selectdrop" name="to_wh" ng-model="to_wh" data-ng-change="material_from(to_wh)">
              <option value="" selected="selected" disabled="disabled">Material Receiving By(Wh)</option>
              <option ng-repeat="mrt in firstDrop" value="{{mrt.alias}}">{{mrt.name}}</option>
            </select>
          </div>
          <div class="col-sm-3 dropalign">
		  <label class="selectlabel">Material Receiving From</label>
            <select class="form-control testSelAll2 selectdrop" ng-model="material" name="materialToType" data-ng-change="material_from(material)">
              <option value="" selected="selected" disabled="disabled">Material Receiving From</option>
              <option value="1" ng-if="datasflo.facchek ==0 && materialFrom!='XVX6AZ4VHT'">Ticket</option>
              <option value="2" ng-if="materialFrom!='XVX6AZ4VHT'">Site</option>
              <option value="3" ng-if="datasflo.facchek ==0 && materialFrom!='XVX6AZ4VHT'">MRF</option>
              <option value="4" ng-if="datasflo.facchek ==1">Scrap Cells</option>
            </select>
          </div>
          <div class="col-sm-3" ng-if="materialFrom == 1" ng-controller="ticketsList_mi">
            <label class="selectlabel">Ticket ID</label>
            <select class="form-control testSelAll2 selectdrop" placeholder="Ticket ID" ng-model="ref_no" name="ref_no" data-ng-change="faultycellsDetails(ref_no)">
              <option value="" selected="selected" disabled="disabled">{{firstDrop.length!='0' ? 'Select Ticket ID':'No Records Found'}}</option>
              <option ng-repeat="optionlist in firstDrop" value="{{optionlist.alias}}">{{optionlist.name}}</option>
            </select>
          </div>
		<div class="col-sm-3" ng-if="materialFrom == 1 && datas.sjo_check_result=='1'" ng-controller="buffersjolist_scrp_full_in">
		  <input type="hidden" name="outstand_check" value="{{outstand_count}}" ng-model="outstand_count" />
		  <label class="selectlabel">SJO Number</label>
			<select class="form-control testSelAll2 selectdrop" ng-model="main_sjo_id" ng-change="outstand_sent();" name="main_sjo_number">
			  <option value="" selected="selected" disabled="disabled">Select SJO Number</option>
			  <option value="NA">NON SJO</option>
			  <option ng-repeat="optionlist in firstDrop" data-count="{{optionlist.count_a}}" value="{{optionlist.alias_a}}">{{optionlist.name_a}} ({{optionlist.count_a}})</option>
			</select>
		</div>
          <div class="col-sm-3" ng-if="materialFrom == 3" ng-controller="mrfList_mi">
            <label class="selectlabel">MRF Number</label>
            <select class="form-control selectdrop testSelAll2 validcheck" name="ref_no" placeholder="MRF Number" ng-model="ref_no"  data-ng-change="getitemfromoutward(ref_no)">
              <option value="" selected="" disabled="disabled">Select MRF Number</option>
              <option ng-repeat="optionlist in firstDrop" value="{{optionlist.alias}}">{{optionlist.name}}</option>
            </select>
          </div>
          <div class="col-sm-3" ng-if="materialFrom == 3 && datas.itemcount==1">
            <md-input-container flex="" class="md-default-theme md-input-has-value">
              <label for="input_00A">SJO Number</label>
              <input type="text" value="{{datas.sjo_number}}" class="ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false" readonly="readonly"/>
            </md-input-container>
          </div>
          <div class="col-sm-3" ng-if="materialFrom == 4" ng-controller="whfList_mi">
          <label class="selectlabel">Select Warehouse</label>
            <select class="form-control testSelAll2 selectdrop" name="ref_no" ng-model="ref_no"  data-ng-change="getscrapitemsfrmwh(ref_no)">
              <option value="" selected="selected" disabled="disabled">Select Warehouse</option>
              <option ng-repeat="optionlist in firstDrop" value="{{optionlist.alias}}">{{optionlist.name}}</option>
            </select>
          </div>
          <div ng-if="materialFrom == 2" ng-controller="siteList_mi">
            <div class="col-sm-3">
              <label class="selectlabel">Site ID</label>
              <select class="form-control selectdrop testSelAll2" placeholder="Site ID" ng-model="ref_no" ng-init="ref_no=''" name="ref_no">
                <option value="" selected="selected" disabled="disabled">Select Site ID</option>
                <option value="2609">Customer Buffer Stock</option>
                <option ng-repeat="optionlist in firstDrop" value="{{optionlist.alias}}">{{optionlist.name}}</option>
              </select>
            </div>
            <div class="col-sm-3" ng-if="ref_no == 2609" ng-controller="buffersjolist_scrp">
			  <input type="hidden" name="outstand_check" value="{{outstand_count}}" ng-model="outstand_count" />
              <label class="selectlabel">SJO Number</label>
                <select class="form-control testSelAll2 selectdrop" ng-model="buffer_sjo_id" ng-change="outstand_sent();" name="buffer_sjo">
                  <option value="" selected="selected" disabled="disabled">Select SJO Number</option>
                  <option ng-repeat="optionlist in firstDrop" data-count="{{optionlist.count_a}}" value="{{optionlist.alias_a}}">{{optionlist.name_a}} ({{optionlist.count_a}})</option>
                </select>
            </div>
            <div class="col-sm-3" ng-if="ref_no != '' && ref_no != 2609" ng-controller="buffersjolist_scrp_full_in">
			  <input type="hidden" name="outstand_check" value="{{outstand_count}}" ng-model="outstand_count" />
              <label class="selectlabel">SJO Number</label>
                <select class="form-control testSelAll2 selectdrop" ng-model="main_sjo_id" ng-change="outstand_sent();" name="main_sjo_number">
				  <option value="" selected="selected" disabled="disabled">Select SJO Number</option>
				  <option value="NA">NON SJO</option>
                  <option ng-repeat="optionlist in firstDrop" data-count="{{optionlist.count_a}}" value="{{optionlist.alias_a}}">{{optionlist.name_a}} ({{optionlist.count_a}})</option>
                </select>
            </div>
          </div>
          <div class="col-sm-3">
            <md-input-container flex="" class="md-default-theme">
              <label for="input_00D">Inward Number</label>
              <input type="text" name="inv_num" class="ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false"/>
            </md-input-container>
          </div>
          <div class="col-sm-3" ng-controller="DatepickerDemoCtrl">
            <md-input-container flex="" class="md-default-theme">
              <label for="input_00C">Inward Date</label>
              <input readonly="readonly" type="text" class="datepicker border-bottom" name="invoice_date" placeholder="Select date.." datepicker-popup="{{format}}" tabindex="1" ng-click="open($event)" ng-focus="open($event)" ng-model="invoiceDate" is-open="opened" min-date="datas.disp_date_check" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" required="required"/>
            </md-input-container>
            <span class="help-block" ng-show="matrialinwardwatdForm.invoice_date.$dirty && matrialinwardwatdForm.invoice_date.$invalid"> <span ng-show="matrialinwardwatdForm.invoice_date.$error.required">Invoice Date is Required</span> </span>
		  </div>
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
				<textarea rows="2" name="remarks" ng-model="remarks" ng-maxlength="700" class="form-control resize-v" placeholder="Remarks" required></textarea>
				<span class="help-block" ng-show="matrialinwardwatdForm.remarks.$dirty && matrialinwardwatdForm.remarks.$invalid">
					<span ng-show="matrialinwardwatdForm.remarks.$error.maxlength">Should not enter morethan a 700 characters</span>
					<span ng-show="matrialinwardwatdForm.remarks.$error.required">Remarks is Required</span>
				</span>
          </div>
        </div>
		
		<div ng-if="datas.disp_length > '0'" class="mt10">
			<h4 class="modal-title text-center">Logistic Dispatch Details</h4>
			<table class="table table-condensed">
				<thead>
					<tr>
						<th width="5%"><a class="tktid">Sr.No</a></th>
						<th width="20%" style="text-align:right"><a class="tktid">Dispatch Date</a></th>
						<th align="center"><a class="tktid">Transport Details</a></th>
						<th><a class="tktid">Docket Number</a></th>
						<th><a class="tktid">Remarks / Contact Details</a></th>
					</tr>
				</thead>
			</table>
			<div style="max-height:300px;overflow:auto; overflow-x:hidden;">
				<table class="table table-hover table-condensed">
					<tbody>
						<tr class="tktBackground" ng-repeat="(key,dis) in datas.disp">
							<td width="7%">{{key + 1}}</td>
							<td width="20%"><p tooltip-placement="top">{{dis.dispatch_date}}</p></td>
							<td class="hidden-xs hidden-sm">{{dis.transport}}</td>
							<td>{{dis.docket}}</td>
							<td>{{dis.out_rem}}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		
        <div ng-if="((materialFrom == 1 && (datas.itemx.length>0 || datas.itemy.length>0)) || (materialFrom == 2 && field.itemtype.length>0) )">
          <div class="header row">
            <h5 class="col-lg-2 col-md-2">Received Items</h5>
              <a href="javascript:void(0)" ng-if="materialFrom == 2" class="btn btn-info btn-sm col-lg-1 col-md-2 mr10" ng-click="addFields(field)">Add</a>
              <a href="javascript:void(0)" ng-if="materialFrom == 2" class="btn btn-info btn-sm col-lg-1 col-md-2 " ng-click="removeFields(field)">Remove</a>
              <a href="javascript:void(0)" ng-if="materialFrom == 2" class="filesRow col-md-4 col-lg-4" style="margin-top:0px;">
					 <!--<label class="selectlabel">Import Item: <span style="color:red;">(Only Excel)</span></label><br />-->                                                    
					<input value="{{file_name}}" class="form-control uploadFile" placeholder="Import Items" disabled="disabled" style="margin-top:-9px;"/>
					<div class="fileUpload btn btn-xs btn-info" tooltip="Upload Excel" tooltip-placement="right" style="padding-bottom:0px;">
						<span class="ion ion-upload"></span>
						<input type="file" ng-click="clear();" class="upload uploadBtn" name="file" ng-model="file" id="file" onchange="angular.element(this).scope().itemsimport(this.files,'xls')"/>
					</div>
            		<div ng-if="determinateValue >= '100'" ng-show="false" ng-init="closeloadings();"></div>
					<div class="mb20" ng-if="prg_shw_hde">
						<md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
					</div>
              </a>
          </div>
          <div>
           <!--<div style="max-height:500px; overflow:auto; overflow-x:hidden;">-->
		   <div ng-controller="productdropCntrl">
            <div class="form-group"  ng-repeat="(key, temlist) in datas.itemx">
              <div class="col-sm-2">
                <md-input-container flex="" class="md-default-theme md-input-has-value">
                  <label for="input_00D">Sl No.</label>
                  <input class="ng-pristine ng-valid md-input ng-touched" readonly="readonly" value="{{key+1}}" >
                </md-input-container>
              </div>
              <div class="col-sm-3" ng-if="temlist.productAlias != 'NA' && temlist.productAlias != ''">
                <input type="hidden" name="batteryRating[]" value="{{temlist.item_alias}}" >
				<md-input-container flex="" class="md-default-theme md-input-has-value">
                  <label for="input_00D">Battery Rating</label>
                  <input type="text" value="{{temlist.productAlias}}"class="ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false" readonly="readonly">
                </md-input-container>
              </div>
              <div class="col-sm-3" ng-if="temlist.productAlias == 'NA' || temlist.productAlias == ''">
			  <label class="selectlabel">Battery Rating</label>
			  <select class="form-control testSelAll2 selectdrop" placeholder="Select Battery Rating" ng-model="batteryRating" name="batteryRating[]">
				<option value="" disabled="disabled">Select Battery Rating</option>
				<option ng-repeat="product in firstDrop" ng-selected="temlist.item_alias==product.alias" value="{{product.alias}}">{{product.name}}</option>
			  </select>
              </div>
              <div class="col-sm-3">
                <md-input-container flex="" class="md-default-theme md-input-has-value">
                  <label for="input_00D">Cell Serial Number</label>
                  <input type="text" name="cell_no[]"  value="{{temlist.cellNumber}}" class="ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false" readonly="readonly">
                </md-input-container>
              </div>
              <div class="col-sm-4 dropalign">
                <label class="selectlabel">Cell Condition</label>
                <select class="form-control testSelAll2 selectdrop" name="condtion[]" ng-model="condtion" placeholder="Select Cell Condition">
                  <option value="0">Condition</option>
                  <option value="3" ng-selected='true'>Scrap Cell</option>
                  <option value="4">Transit Damage</option>
                  <option value="7">Lost Cell</option>
                  <option value="6">Field Revival</option>
                  <option value="8">Field Good</option>
                </select>
              </div>
			  <div ng-if="key==(datas.itemx.length)-1" ng-show="false" ng-init="closeloadings();"></div>
            </div>
			<div ng-if="datas[0].alias==4" ng-show="true" ng-init="closeloadings();" style='color:#F00;text-align:center'>NO RECORDS</div>
			</div>
			<!--</div>-->
            <!-- Import start -->
			<div style="max-height:500px; overflow:auto; overflow-x:hidden;">
				<div class="form-group"  ng-repeat="(key,temlist) in datas.itemy">
				  <div class="col-sm-1 mt20" align="center">{{key+1}}</div>
				  <div class="col-sm-4">
					<input type="hidden" name="batteryRating[]" value="{{temlist.product_alias}}"/>
					<md-input-container flex="" class="md-default-theme md-input-has-value">
					  <label for="input_00D">Battery Rating</label>
					  <input type="text" value="{{temlist.product_dis}}" class="ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false" readonly="readonly">
					</md-input-container>
				  </div>
				  <div class="col-sm-4">
					<md-input-container flex="" class="md-default-theme md-input-has-value">
					  <label for="input_00D">Cell Serial Number</label>
					  <input type="text" name="cell_no[]"  value="{{temlist.cellNumber}}" class="ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false" readonly="readonly">
					</md-input-container>
				  </div>
				  <div class="col-sm-3">
					<input type="hidden" name="condtion[]" value="{{temlist.condition_alias}}"/>
					<md-input-container flex="" class="md-default-theme md-input-has-value">
					  <label for="input_00D">Condition</label>
					  <input type="text" value="{{temlist.condition_dis}}" class="ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false" readonly="readonly">
					</md-input-container>
				  </div>
				  <div ng-if="key==(datas.itemy.length)-1" ng-show="false" ng-init="imp_closeloadings();"></div>
				</div>
			</div>
            <!-- Import end -->
            
            <!--<div style="max-height:500px; overflow:auto; overflow-x:hidden;">-->
			<div ng-controller="productdropCntrl">
            <div class="form-group" ng-repeat="(key,type) in field.itemtype" ng-if="materialFrom == 2 && temp">
			  <div class="col-sm-2">
                <md-input-container flex="" class="md-default-theme md-input-has-value">
                  <label for="input_00D">Sl No.</label>
                  <input class="ng-pristine ng-valid md-input ng-touched" readonly="readonly" value="{{key+1}}" >
                </md-input-container>
              </div>
              <div class="col-sm-3">
                  <label class="selectlabel">Battery Rating</label>
                  <select class="form-control testSelAll2 selectdrop" placeholder="Select Battery Rating" ng-model="itemType" name="batteryRating[]">
                    <option value="" selected="selected" disabled="disabled">Select Battery Rating</option>
                    <option ng-repeat="product in firstDrop" value="{{product.alias}}">{{product.name}}</option>
                  </select>
              </div>
              <div class="col-sm-4">
                <md-input-container flex="" class="md-default-theme md-input-has-value">
                  <label for="input_00D">Enter Cell Serial Number</label>
                  <input type="text" ng-model="cell_no" name="cell_no[]" valid-input class="upper ng-pristine ng-valid md-input ng-touched" tabindex="0" aria-invalid="false">
                </md-input-container>
              </div>
              <div class="col-sm-3">
				<label class="selectlabel">Condition</label>
                <select class="form-control testSelAll2 selectdrop" name="condtion[]" placeholder="Condition" ng-model="condtion">
                  <option value="0">Condition</option>
                  <option value="3" ng-selected='true'>Scrap Cell</option>
                  <option value="4">Transit Damage</option>
                  <option value="7">Lost Cell</option>
                  <option value="6">Field Revival</option>
                  <option value="8">Field Good</option>
                </select>
              </div>
			  </div>
			  </div>
            <!--</div>-->
          </div>
        </div>
        <div ng-if="materialFrom ==3">
          <div class="header mt20"  ng-if="datas.itemcount==1">
            <h4>Shipped Items</h4>
          </div>
          <div style="max-height:500px; overflow:auto; overflow-x:hidden;" ng-controller="stockcodeCtrl_cell">
            <div ng-repeat="(key,temlist) in datas.sjodetails">
              <input type="hidden" name="itemAlias[]" value="{{temlist.item_alias}}" ng-model="temlist.item_alias" />
              <div class="form-group">
                <div class="col-sm-1">
                  <md-input-container flex="" class="md-default-theme md-input-has-value">
                    <label for="input_00D">Sl No.</label>
                    <input class="ng-pristine ng-valid md-input ng-touched" readonly="readonly" value="{{key+1}}" >
                  </md-input-container>
                </div>
                <div class="col-sm-2">
                  <md-input-container flex="" class="md-default-theme">
                    <label for="input_H">Type</label>
                    <input value="{{temlist.item_type}}" name="itemTypes[]" ng-model="temlist.item_type" class="ng-pristine ng-valid md-input ng-touched" id="input_H" readonly="readonly">
                  </md-input-container>
                </div>
                <div class="col-sm-3">
                  <md-input-container flex="" class="md-default-theme">
                    <label for="input_I">Description</label>
                    <input value="{{temlist.item_code}}" ng-model="temlist.item_code" class="ng-pristine ng-valid md-input ng-touched" id="input_I" readonly="readonly">
                  </md-input-container>
                </div>
                <div class="col-sm-{{temlist.item_type=='CELLS' ? 3 : 3}}">
                  <md-input-container flex="" class="md-default-theme">
                    <label for="input_J">{{temlist.item_type=='CELLS' ? 'Cell Number' : 'Quantity'}}</label>
                    <input value="{{temlist.item_description}}" ng-model="temlist.item_description" data="precondit_{{key}}" class="ng-pristine ng-valid md-input ng-touched" id="input_J" readonly="readonly">
                  </md-input-container>
                </div>
                <div class="col-sm-1" ng-if="temlist.item_type=='ACCESSORIES'">
                  <md-input-container flex="" class="md-default-theme hoverClass">
                    <label for="input_K">Good</label>
                    <input name="condtion[]" ng-model="condtion" class="ng-pristine ng-valid md-input ng-touched gcondit_{{key}} condit_{{key}}" id="input_K">
                  </md-input-container>
                </div>
                <div class="col-sm-1" ng-if="temlist.item_type=='ACCESSORIES'">
                  <md-input-container flex="" class="md-default-theme hoverClass">
                    <label for="input_L">Damaged</label>
                    <input name="dam_condtion[]" ng-model="dam_condtion" class="ng-pristine ng-valid md-input ng-touched dcondit condit_{{key}}" id="input_L">
                  </md-input-container>
                </div>
                <div class="col-sm-1" ng-if="temlist.item_type=='ACCESSORIES'">
                  <md-input-container flex="" class="md-default-theme hoverClass">
                    <label for="input_M">Lost</label>
                    <input name="lost_condtion[]" ng-model="lost_condtion" class="ng-pristine ng-valid md-input ng-touched dcondit condit_{{key}}" id="input_M">
                  </md-input-container>
                </div>
                <div class="col-sm-3 dropalign" ng-if="temlist.item_type=='CELLS'">
                  <select class="form-control selectdrop" name="condtion[]">
                    <option value="0">Condition</option>
                    <option ng-repeat="zone in firstDrop" value="{{zone.alias}}" ng-selected="zone.alias == 1">{{zone.name}}</option>
                  </select>
                </div>
              </div>
              <div ng-if="key==(datas.sjodetails.length)-1" ng-show="false" ng-init="closeloadings();"></div>
            </div>
            <div ng-if="datas.sjodetails.length==0" ng-show="false" ng-init="closeloadings();"></div>
          </div>
        </div>
        <div ng-if="materialFrom ==4">
          <!--<div class="header mt20"  ng-if="datas.itemcount==1">
            <h4>Shipped Items</h4>
          </div>-->
          <div class="row" ng-if="datas.itemcount==1">
              <div class="col-md-12">
              <h4 class="left">Shipped Items</h4>
                  <div class="ui-checkbox ui-checkbox-info input-sm right">
                    <label>
                      <input type="checkbox" id="rl_all" ng-checked="check_all" ng-init="check_all=true" ng-click="checkAll('rl_all')"/>
                      <span></span>Recv/Lost All
                    </label>&nbsp;
                    <button type="button" class="btn btn-info btn-sm" ng-click="checkAll('uncheck')">Uncheck All</button>
                  </div>
              </div>
          </div>
          <div style="max-height:500px; overflow:auto; overflow-x:hidden;">
            <div ng-repeat="(key,temlist) in datas.scrapdetails">
              <input type="hidden" name="crapAlias[]" value="{{temlist.alias}}" ng-model="temlist.alias" />
              <div class="form-group">
                <div class="col-sm-2">
                  <md-input-container flex="" class="md-default-theme md-input-has-value">
                    <label for="input_00D">Sl No.</label>
                    <input class="ng-pristine ng-valid md-input ng-touched" readonly="readonly" value="{{key+1}}" >
                  </md-input-container>
                </div>
                <div class="col-sm-2">
                  <md-input-container flex="" class="md-default-theme md-input-has-value">
                    <label for="input_I">Battery Rating</label>
                    <input value="{{temlist.pname}}" ng-model="temlist.pname" class="ng-pristine ng-valid md-input ng-touched" id="input_I" readonly="readonly">
                  </md-input-container>
                </div>
                <div class="col-sm-3">
                  <md-input-container flex="" class="md-default-theme md-input-has-value">
                    <label for="input_J">Cell Number</label>
                    <input value="{{temlist.cellname}}" ng-model="temlist.cellname" class="ng-pristine ng-valid md-input ng-touched" id="input_J" readonly="readonly">
                  </md-input-container>
                </div>
                <div class="col-sm-2">
                  <md-input-container flex="" class="md-default-theme md-input-has-value">
                    <label for="input_J">Cell Condition</label>
                    <input value="{{temlist.condition}}" ng-model="temlist.condition" class="ng-pristine ng-valid md-input ng-touched" id="input_J" readonly="readonly">
                  </md-input-container>
                </div>
                <div class="col-sm-3">
                  <div class="ui-checkbox ui-checkbox-info input-sm" style="padding-top:25px;">
                    <input type="hidden" name="sendx[{{key}}]" ng-if="!temlist.recv_selected && !temlist.lost_selected" value="0">
                     <label><input type="radio" class="sngl_unch_recv chck" name="sendx[{{key}}]" value="1" ng-checked="temlist.recv_selected" ng-init="temlist.recv_selected=true"/><span></span>Receive</label>
                    &nbsp;
                    <label><input type="radio" class="sngl_unch_lst" name="sendx[{{key}}]" value="2" ng-checked="temlist.lost_selected"/><span></span>Lost</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row form-group mt30">
          <div class="col-sm-6 col-sm-offset-3" align="center">
            <button type="submit" click-once class="btn btn-info btn-sm confirms" ng-disabled="matrialinwardwatdForm.$invalid">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
	$(document).on('change','.validcheck',function (e){
		setTimeout(function(){
			$("[data^='precondit']").each(function(k,v){
				$(".gcondit_"+k).val($(this).val());
				$(".dcondit").val(0);
				$(".hoverClass").addClass("md-input-has-value");
				$(".condit_"+k).keyup(function (e){
					if(isNaN($(this).val())){$(this).val("");}
					else{ var valint=0,x=$(this);
						$(".condit_"+k).each(function(){
							$(this).val($(this).val().replace(/[^\d].+/, ""));
							valint+=parseInt((isNaN($(this).val())||$(this).val()=="" ? 0 : $(this).val()));
						});
						var valint1=parseInt($("[data^='precondit_"+k+"']").val());
						if(valint>valint1)x.val("");else x.val(x.val());
						
					}
				});
			});
		},2000);
	});
	$(document).on('click','.confirms',function (e){
		var r = confirm("Sure you want to Submit ?");
		if (r == true) {return true;} else {return false;}
	});
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
});
</script>