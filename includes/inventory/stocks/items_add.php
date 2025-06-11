<style>
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
label.gkf {
	border-radius: 3px;
	padding: 5px;
	margin: 0;
	position: relative;
	text-align: center;
	background: #333!important;
	color: #fff;
	border: none;
	cursor: pointer
}
[type=file]:hover, label.gkf:hover {
	background: #39f!important
}
</style>
<div class="modal-style" ng-controller="stocksAdd"> 
  <!--<div ng-include="'includes/loading.php'"></div>-->
  <div ng-controller="addFieldsCtrl"> <!-- wrapper for specific style -->
    <div class="modal-header clearfix">
      <h4 class="modal-title">Create Stocks</h4>
      <span class="close ion ion-android-close" ng-click="modalClose()"></span> </div>
    <div class="modal-body" ng-controller="addingform">
      <form class="form-horizontal forms_add" name="itemsForm" data-went="#/inventory/items/items_view" method="post" url="services/inventory/item_code_add" enctype="multipart/form-data" ng-submit="sendPost()" novalidate>
        <div class="row">
          <div class="col-sm-4 col-sm-offset-4" ng-controller="getapprovedsjonumber">
            <label class="selectlabel">SJO Number</label>
            <select class="form-control testSelAll3 selectdrop" placeholder="Select SJO Number" name="sjo_no" ng-model="sjo_no" ng-change="getitemslistfromsjo_ic(sjo_no)">
              <option value="" selected="selected" disabled="disabled">Select SJO Number</option>
              <option ng-repeat="ticketList_1 in ticketList" value="{{ticketList_1.ticketAlias}}">{{ticketList_1.ticketId}}</option>
            </select>
          </div>
        </div>
		<div ng-if="datas.mrf_number">
        <div class="row form-group pt10">
          <div class="col-sm-3">
            <md-input-container flex="" class="md-default-theme md-input-has-value">
              <label>MRF Number</label>
              <input value="{{datas.mrf_number}}" readonly="readonly">
            </md-input-container>
          </div>
          <div class="col-sm-3">
            <md-input-container flex="" class="md-default-theme md-input-has-value">
              <label>Date Of Request</label>
              <input value="{{datas.date_of_request}}" readonly="readonly">
            </md-input-container>
          </div>
          <div class="col-sm-3">
            <md-input-container flex="" class="md-default-theme md-input-has-value">
              <label>From W/H</label>
              <input value="{{datas.ehfrommrf}}" readonly="readonly">
            </md-input-container>
          </div>
          <div class="col-sm-3">
            <md-input-container flex="" class="md-default-theme md-input-has-value">
              <label>To W/H</label>
              <input value="{{datas.to_wh}}" readonly="readonly">
            </md-input-container>
          </div>
		</div>
        <div class="row form-group">
          <div class="col-sm-3">
            <md-input-container flex="" class="md-default-theme md-input-has-value">
              <label>Road Permit</label>
              <input value="{{datas.road_permit==1 ? 'REQUIRED':'NOT REQUIRED'}}" readonly="readonly">
            </md-input-container>
          </div>
          <div class="col-sm-3">
            <md-input-container flex="" class="md-default-theme md-input-has-value">
              <label>Material Value</label>
              <input value="{{datas.material_value}}" readonly="readonly">
            </md-input-container>
          </div>
          <div class="col-sm-3">
            <md-input-container flex="" class="md-default-theme md-input-has-value">
              <label>Request Status</label>
              <input value="{{datas.status_name}}" readonly="readonly">
            </md-input-container>
          </div>
          <div class="col-sm-3">
            <md-input-container flex="" class="md-default-theme md-input-has-value">
              <label>Ticket ID</label>
              <input value="{{datas.ticket_id !='0' ? datas.ticket_id : 'NA'}}" readonly="readonly">
            </md-input-container>
          </div>
		</div>
        <div class="row form-group">
          <div class="col-sm-3">
            <md-input-container flex="" class="md-default-theme md-input-has-value">
              <label>SJO Number</label>
              <input value="{{datas.sjo_number && datas.sjo_number !='0' && datas.sjo_number !='' ? datas.sjo_number : 'NA'}}" readonly="readonly">
            </md-input-container>
          </div>
          <div class="col-sm-3">
            <md-input-container flex="" class="md-default-theme md-input-has-value">
              <label>SJO Date</label>
              <input value="{{datas.sjo_date && datas.sjo_date !='0' && datas.sjo_date !='' ? datas.sjo_date : 'NA'}}" readonly="readonly">
            </md-input-container>
          </div>
          <div class="col-sm-3">
            <md-input-container flex="" class="md-default-theme md-input-has-value">
              <label>Sales Invoice Number</label>
              <input value="{{datas.sinv && datas.sinv !='0' && datas.sinv !='' ? datas.sinv : 'NA'}}" readonly="readonly">
            </md-input-container>
          </div>
          <div class="col-sm-3">
            <md-input-container flex="" class="md-default-theme md-input-has-value">
              <label>Sales Invoice Date</label>
              <input value="{{datas.sind && datas.sind !='0' && datas.sind !='' ? datas.sind : 'NA'}}" readonly="readonly">
            </md-input-container>
          </div>
		</div>
        <div class="row form-group">
          <div class="col-sm-3">
            <md-input-container flex="" class="md-default-theme md-input-has-value">
              <label>Sales PO Number</label>
              <input value="{{datas.spon && datas.spon !='0' && datas.spon !='' ? datas.spon : 'NA'}}" readonly="readonly">
            </md-input-container>
          </div>
          <div class="col-sm-3">
            <md-input-container flex="" class="md-default-theme md-input-has-value">
              <label>Customer Name</label>
              <input value="{{datas.ccname && datas.ccname !='0' && datas.ccname !='' ? datas.ccname : 'NA'}}" readonly="readonly">
            </md-input-container>
          </div>
          <div class="col-sm-3">
            <md-input-container flex="" class="md-default-theme md-input-has-value">
              <label>Customer number</label>
              <input value="{{datas.ccnumber && datas.ccnumber !='0' && datas.ccnumber !='' ? datas.ccnumber : 'NA'}}" readonly="readonly">
            </md-input-container>
          </div>
          <div class="col-sm-3 md-default-theme">
            <label>SJO Scanned Copy</label>
            <p><a href="{{datas.sjo_file !='' ? datas.sjo_file : 'NA'}}" target="_blank">Click Here</a></p>
          </div>
		</div>
        <div class="row form-group">
          <div class="col-sm-3 md-default-theme">
          <md-input-container flex="" class="md-default-theme md-input-has-value">
            <label>Customer Address</label>
           <!-- <p>{{datas.ccadds}}</p>-->
            <input value="{{datas.ccadds && datas.ccadds !='0' && datas.ccadds !='' ? datas.ccadds : 'NA'}}" readonly="readonly">
            </md-input-container>
          </div>
        </div>
		</div>
        <div class="row form-group pt10" ng-show="datas.rQuantity" style="text-align:center; background:RGBA(0,0,0,0.1)">
          <div class="col-sm-3 md-default-theme">
            <label>Requested Qty</label>
            <p>{{datas.rQuantity}}</p>
          </div>
          <div class="col-sm-3 col-xs-3 md-default-theme">
            <label>PPC Qty</label>
            <p>{{datas.taQuantity}}</p>
          </div>
          <div class="col-sm-3 col-xs-3 md-default-theme">
            <label>Sent Qty</label>
            <p>{{datas.sQuantity}}</p>
          </div>
          <div class="col-sm-3 md-default-theme">
            <label>Left Qty</label>
            <p>{{datas.lQuantity}}</p>
          </div>
        </div>
		
        <div class="row" ng-if="datas.invoicing=='1'">
          <div class="col-sm-4 col-sm-offset-2">
            <md-input-container flex="" class="intheme">
              <label for="input_00B">Invoice / NRDC Number </label>
              <input ng-model="invoiceno" class="ng-pristine ng-valid md-input ng-touched" name="invoice_no" id="input_00B" tabindex="1" aria-invalid="false" required="required">
            </md-input-container>
            <span class="help-block" ng-show="itemsForm.invoice_no.$dirty && itemsForm.invoice_no.$invalid"> <span ng-show="itemsForm.invoice_no.$error.required">Invoice / NRDC Number is Required</span> </span> </div>
          <div class="col-sm-4" ng-controller="DatepickerDemoCtrl">
            <md-input-container flex="" class="intheme">
              <label for="input_00C">Invoice Date</label>
              <input readonly="readonly" type="text" class="datepicker border-bottom" name="invoice_date" placeholder="Select date.." datepicker-popup="{{format}}" tabindex="1" ng-click="open($event)" ng-focus="open($event)" ng-model="invoiceDate" is-open="opened" min-date="'01-01-2000'" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" required="required"/>
            </md-input-container>
            <span class="help-block" ng-show="itemsForm.invoice_date.$dirty && itemsForm.invoice_date.$invalid"> <span ng-show="itemsForm.invoice_date.$error.required">Invoice Date is Required</span> </span> </div>
          <div class="col-sm-10 col-sm-offset-1">
            <table class="table table-condensed table-hover">
              <thead>
                <tr>
                  <th width="10%"><a class="tktid">Sno</a></th>
                  <th><a class="tktid">Item Type</a></th>
                  <th><a class="tktid">Product</a></th>
                  <th><a class="tktid">Cell Serial Number</a></th>
                </tr>
              </thead>
            </table>
            <div style="max-height:300px; overflow:auto;overflow-x:hidden;">
              <table class="table table-condensed table-hover">
                <tbody>
                  <tr class="tktBackground" ng-repeat="(key,data) in datas.itema">
                    <td width="10%">{{key + 1}}</td>
                    <td>{{data.itemtype}}</td>
                    <td>{{data.itemcode}}</td>
                    <td>{{data.itemdesc}}</td>
                    <td ng-if="key==(datas.itema.length)-1" ng-show="false" ng-init="closeloadings();"></td>
                  </tr>
                </tbody>
                <tfoot ng-if="(datas.itema.length)=='0' ? closeloadings() : ''">
                  <tr>
                    <td colspan="4">No Records</td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
		
        <div class="row" ng-if="datas.invoicing=='0'">
          <div class="row col-sm-4 col-sm-offset-4 filesRow">
            <label class="selectlabel">Import Items: <span style="color:red;">(Only Excel)</span></label>
            <br />
            <input value="{{file_name}}" class="form-control uploadFile" placeholder="Import Items" disabled="disabled"/>
            <div class="fileUpload btn btn-sm btn-info" tooltip="Upload Excel" tooltip-placement="right"> <span class="ion ion-upload"></span>
              <input type="file" class="upload uploadBtn" name="file" ng-model="file" id="file" onchange="angular.element(this).scope().itemslistimport(this.files,'xls')"/>
            </div>
            <div ng-if="determinateValue >= '100'" ng-init="closeloadings()"></div>
            <div class="mb20" ng-if="prg_shw_hde">
              <md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
            </div>
          </div>
          <!--<div class="row col-sm-4 col-sm-offset-4" align="center">
            <p>&nbsp;</p>
            <label for="f02" class="gkf">Import Items<small>(Only Excel)</small></label>
            <input type="file" id="f02" class="border-bottom" name="file" tabindex="1" ng-model="file" onchange="angular.element(this).scope().itemslistimport(this.files,'xls')" placeholder="Import Cells"/>
          </div>-->
          
          <div class="col-sm-12" ng-if="datas.itemcount=='1'">
            <div class="header">
              <h4 style="color:#428bca">Cells/Accessories</h4>
            </div>
            <div style="max-height:500px; overflow:auto;overflow-x:hidden;">
              <div ng-repeat="(key,temlist) in datas.itemx">
                <input type="hidden" name="itemTypes[]" value="{{temlist.itemtype}}" ng-model="temlist.itemtype" />
                <input type="hidden" name="itemalias[]" value="{{temlist.itemalias}}" ng-model="temlist.itemalias" />
                <input type="hidden" name="celltype[]" value="{{temlist.celltype}}" ng-model="temlist.celltype" />
                <div class="form-group">
                  <div class="col-sm-1">
                    <label>SL No.</label>
                    <p>{{key+1}}</p>
                  </div>
                  <div class="col-sm-2">
                    <label for="input_A">Stock Type</label>
                    <p>{{temlist.itemtype}}</p>
                  </div>
                  <div class="col-sm-3">
                    <label for="input_B"><span ng-show="temlist.itemtypes=='1'">Product</span><span ng-show="temlist.itemtypes=='2'">Accessory</span> Description</label>
                    <p>{{temlist.itemdesc}}</p>
                  </div>
                  <div class="col-sm-2">
                    <label for="input_A">Item Type</label>
                    <p>{{temlist.celltype==1 ? 'NEW':'REVIVED'}}</p>
                  </div>
                  <div class="col-sm-3">
                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                      <label for="input_B"><span ng-show="temlist.itemtypes=='1'">Cell Number</span><span ng-show="temlist.itemtypes=='2'">Quantity</span></label>
                      <input value="{{temlist.cell_num}}" class="upper" name="cellNumber_Quanty[]" valid-input ng-readonly="temlist.itemtypes=='1' ? false : true"/>
                    </md-input-container>
                  </div>
                </div>
                <div ng-if="key==(datas.itemx.length)-1 && datas.import=='0'" ng-show="false" ng-init="closeloadings();"></div>
                <div ng-if="key==(datas.itemx.length)-1 && datas.import=='1'" ng-show="false" ng-init="imp_closeloadings();"></div>
              </div>
              <div ng-if="datas.itemx.length=='0'" ng-init="closeloadings();"></div>
            </div>
          </div>
          <!--<div ng-if="datas.import=='0'" ng-init="closeloadings();"></div>-->
          <div class="col-sm-12" ng-if="datas.itemcount=='2'" ng-init="closeloadings();">
            <center>
              <h4>{{datas.mssg}}</h4>
            </center>
          </div>
        </div>
        <div class="row form-group">
          <div class="col-xs-12">&nbsp;</div>
          <div class="col-sm-6 col-sm-offset-5">
            <button type="submit" click-once class="btn btn-info btn-sm" ng-disabled="itemsForm.$invalid">Create</button>
            <button type="reset" class="btn btn-info btn-sm">Reset</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
	setInterval(function(){
		//$('.testSelAll2').SumoSelect({selectAll:true});
		$('.testSelAll3').SumoSelect();
		$('.forms_add').find('.SumoSelect').addClass('singleSelect');
	},0);
	$("[type=file]").on("change", function(){
	  var file = this.files[0].name;
	  var dflt = $(this).attr("placeholder");
	  if($(this).val()!="")$(this).next().text(file);else $(this).next().text(dflt);
	});
</script>