<style>
table {margin-bottom: 0px !important;}
tfoot tr th {text-align: center !important;padding: 5px !important;}
</style>
<div class="page page-ui-extras" ng-controller="ModalDemoCtrl">
  <div ng-controller="itemsCtrl">
  <div ng-controller="mul_view_form">
    <div class="panel panel-lined table-responsive panel-hovered mb10" >
      <ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
        <li><a href="#/dashboard" class="padding-10">Home</a></li>
        <li><a href="" class="padding-10">Stocks</a></li>
      </ol>
      <ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;" ng-if="datas.export">
			<li><a href="" ng-click="itemsexport()" class="padding-10 export-btn">Export</a></li>
        </ol>
    </div>
    <div class="row">
      <div class="col-md-12 table-height">
        <div class="panel panel-lined table-responsive panel-hovered">
          <div class="panel panel-default">
            <form class="form-horizontal forms_ec" url="services/inventory/item_code_mul_view" name="userForm" method="post" novalidate>
              <table class="table table-condensed" >
                <thead>
                  <tr>
                    <th>
						<a class="tktid">Cell No./ Accessory&nbsp;<span class="arrow caret"></span></a>
						<input type="text" name="itemDesc" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
						<span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
					</th>
					<th class="hidden-xs">
						<select name="itemType" placeholder="Item Type" class="SlectBox form-control" ng-model="selectt.id" data-ng-change="listSorting()">
							<option value="">Item Type</option>
							<option value="1">Cells</option>
							<option value="2">Accessory</option>
						</select>
					</th>
					<th>
						<a class="tktid">Item Description&nbsp;<span class="arrow caret"></span></a>
						<input type="text" name="itemCode" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
						<span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
					</th>
					<th>
						<a class="tktid">SJO Number&nbsp;<span class="arrow caret"></span></a>
						<input type="text" name="sjoNo" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
						<span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
					</th>
                    <th class="hidden-xs hidden-sm" ng-controller="DatepickerDemoCtrl"> <a class="tktid">Invoice Date&nbsp;<span class="arrow caret"></span></a>
						<input type="text" name="invdate" class="form-control datepicker border-bottom droptxt1 hidden" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-model="dt" is-open="opened" min-date="minDate" max-date="'2025-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="listSorting();open($event)"/>
						<span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
					</th>
                    <th class="hidden-xs hidden-sm">
                        <a class="tktid">Invoice / NRDC Number&nbsp;<span class="arrow caret"></span></a>
                        <input type="text" name="invno" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
                        <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                    </th>
                    <th ng-if="datas.advedit || datas.delete">
                        Actions
                    </th>
                  </tr>
                </thead>
                </table>
                <div class="div-table-content">
                <table class="table table-condensed table-hover">
                    <tbody>
                      <tr class="tktBackground"  ng-repeat="(key,data) in datas.itemDetails">
                        <td ng-click="itemview(data.item_code_alias)"><span tooltip-placement="top" tooltip="Click to know details of {{data.item_desc}}">{{data.item_desc}}</span></td>
						<td class="hidden-xs">{{data.item_type==1 ? 'CELLS' : 'ACCESSORIES'}}</td>
						<td><span tooltip-placement="top" ng-attr-tooltip="{{data.item_code.length>15 ? data.item_code : ''}}">{{data.item_code | limitTo:15}}{{data.item_code.length>15 ? '...':''}}</span></td>
						<td>{{data.sjo_no}}</td>
						<td class="hidden-xs hidden-sm">{{data.invoice_date}}</td>
            <td class="hidden-xs hidden-sm">{{data.invoice_no}}</td>
            <td ng-if="datas.advedit || datas.delete">
              <a href="" class="ml3" tooltip="Advance Edit" tooltip-placement="bottom" ng-click="advUpdateStock(data.item_code_alias);" ng-if="datas.advedit">
                  <span class="fa fa-spl-edit"></span>
              </a>
              <a href="javascript:void(0)" class="ml3" tooltip="Delete" tooltip-placement="bottom" ng-click="settingsDeleteOpen('stocks', data);" ng-if="datas.delete">
                <span class="fa fa-delete"></span>
              </a>
            </td>
                      </tr>
                    </tbody>
                    <tfoot ng-if="datas.itemDetails.length=='0'">
                      <tr>
                        <td colspan="5">Oho! There are no records to Display</td>
                      </tr>
                    </tfoot>
              </table>
              </div>
              <div class="panel-footer clearfix" ng-if="datas.itemDetails.length!='0'">
                <div class="col-md-4">
                  <p class="left small" style="margin:0px !important;">Showing {{datas.fromRecords}} to {{datas.toRecords}} of {{datas.totalRecords}} entries</p>
                </div>
                <div class="col-md-4">
                  <div class="small text-bold right ml15"> <span class="control-label">Page No. </span>
                    <select class="form-control page-count"  name="page_no" ng-model="selectt.id" data-ng-change="listSorting()">
                      <option value="" style="display:none">1</option>
                      <option ng-repeat="pagess in datas.pages" value="{{pagess}}" ng-show="$index > 0">{{pagess}}</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="small text-bold right ml15"> <span class="control-label">Count per page</span>
                    <select class="form-control page-count" name="perpagecount" ng-model="selectt.ids" data-ng-change="listSorting()">
                      <option value="" style="display:none">10</option>
                      <option value="10">10</option>
                      <option value="20">20</option>
                      <option value="50">50</option>
                      <option value="75">75</option>
                      <option value="100">100</option>
                      <option value="150">150</option>
                    </select>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
		<div ng-if="datas.add">
		  <button type="button" class="btn btn-info ion ion-plus compose-btn" tooltip="Addnew" tooltip-placement="top" ng-click="itemsaddOpen()" md-ink-ripple></button>
		</div>
    </div>
	</div>
<div id="ticketviesw">    
    <div class="site-settings ticketviesw clearfix  col-xs-6 floating-sidebar" ng-class="{'open': item_open}">
      <div class="sidebar-wrap text-uppercase mt46">
        <div class="group clearfix head tkt-heading2">
          <div class="left"> <span class="ion ion-close-round mr10 tktviewClose" ng-click="removeitemView()"></span> <span><strong>{{singleViews.item_type==1 ? 'Cell' : 'Accessory'}} Details & History</strong></span> </div>
		  <div class="right">
			<div class="btn-group btn-group-sm">
				<a href="services/inventory/stocks_print.php?alias={{singleViews.item_code_alias}}" target="_blank" tooltip="Print" class="ml10" tooltip tooltip-placement="bottom"><span class="ion ion-android-print"></span></a>
				<a href="services/inventory/stocks_download.php?alias={{singleViews.item_code_alias}}" target="_blank" tooltip="Download" class="ml10" tooltip tooltip-placement="bottom"><span class="ion ion-android-download"></span></a>
			</div>
          </div>
        </div>
        <div class="panel-body clearfix freez-panel">
          <div class="row tkt-panel">
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>Item Type</h6>
              <span class="fnt-size-11">{{singleViews.item_type==1 ? 'CELLS' : 'ACCESSORIES'}}</span> </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>Item Description</h6>
              <span class="fnt-size-11">{{singleViews.item_code}}</span> </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>Factory Condition</h6>
              <span class="fnt-size-11">{{singleViews.cell_type}}</span> </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>{{singleViews.item_type==1 ? 'Cell Number' : 'Quantity'}}</h6>
              <span class="fnt-size-11">{{singleViews.item_description}}</span> </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>{{singleViews.item_type==1 ? 'Cell' : 'Accessory'}} Value</h6>
              <span class="fnt-size-11">Rs. {{singleViews.cell_value | number : 2}}</span> </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>Current Location</h6>
              <span class="fnt-size-11">{{singleViews.current_location}}</span> </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>{{singleViews.item_type==1 ? 'Cell' : 'Accessory'}} Condition</h6>
              <span class="fnt-size-11">{{singleViews.cell_condition}}</span> </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>Sjo Number</h6>
              <span class="fnt-size-11">{{singleViews.sjo_no}}</span> </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>Invoice / NRDC Number</h6>
              <span class="fnt-size-11">{{singleViews.invoice_no}}</span> </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>Invoice Date</h6>
              <span class="fnt-size-11">{{singleViews.invoice_date}}</span> </div>
		</div>
	       <div ng-if="singleViews.request_length != 0" class="mt10">
            <h4 class="modal-title text-center">{{singleViews.item_type==1 ? 'CELL HISTORY' : 'ACCESSORY HISTORY'}}</h4>
            <table class="table table-condensed" >
              <thead>
                <tr>
                  <th width="10%"><a class="tktid">Sr.No</a></th>
                  <th width="65%"><a class="tktid">History</a></th>
                  <th width="25%"><a class="tktid">Transaction Date</a></th>
                </tr>
              </thead>
            </table>
            <div style="max-height:500px; overflow:auto; overflow-x:hidden;">
              <table class="table table-hover table-bordered">
                <tbody>
                  <tr class="tktBackground" ng-repeat="(key,rem) in singleViews.request_items">
                    <td width="10%">{{key + 1}}</td>
                    <td width="65%">{{rem.message}}</td>
                    <td width="25%">{{rem.transaction_date}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    </div>
</div>
<script>
	$(document).ready(function(){
	   $('.tktid').click(function(){
		  var thw=($(this).parent('th').width());
		   $('.droptxt1').filter(function(){
				if($(this).val()==''){
				   $(this).width($(this).parent('th').width());
				   $(this).addClass('hidden');
				   $(this).siblings('.inptClose').addClass('hidden');
				   $(this).siblings('.tktid').removeClass('hidden');
				}
		   });
		   $(this).siblings('.droptxt1, .inptClose').removeClass('hidden');
		   $(this).siblings('.droptxt1').focus();
		   $(this).addClass('hidden');
	   });
		$('.droptxt1').click(function(){
		   $('.droptxt1').not(this).filter(function(){
				if($(this).val()==''){
				   $(this).width($(this).parent('th').width());
				   $(this).addClass('hidden');
				   $(this).siblings('.inptClose').addClass('hidden');
				   $(this).siblings('.tktid').removeClass('hidden');
				}
		   });
	   });
	   $('.inptClose').click(function(){
		   $(this).siblings('.droptxt1').val('');
		   $(this).addClass('hidden');
		   $(this).siblings('.tktid').removeClass('hidden');
		   $(this).siblings('.droptxt1').addClass('hidden');
	   });
	   $(document).click(function(e){
			if (!$(e.target).hasClass("tktid") && $(".tktid").hasClass("hidden") && !$(e.target).hasClass("droptxt1")){
				$('.droptxt1').filter(function(){
					if($(this).val()==''){
						$(this).siblings(".tktid").removeClass('hidden');
						$(this).addClass('hidden');
						$(this).siblings(".inptClose").addClass('hidden');
					}
				});
			}
		});
		setTimeout(function(){$('.SlectBox').SumoSelect();
			$('.textSearch').keyup(function(){
				var cc = $(this).siblings('.options').find('li');
				var aa =$(this).siblings('.options > li');
				var valThis = $(this).val().toLowerCase();
					if(valThis == ""){
						cc.removeClass('hidden');           
					}else{
						cc.each(function(){
							var text = $(this).text().toLowerCase();
							(text.indexOf(valThis) >= 0) ? $(this).removeClass('hidden') : $(this).addClass('hidden');
						});
				   };
				   if(cc.length==$(this).siblings('.options').find('.hidden').length){
						$(this).siblings('.options').append('<li class="no_rec"><label>No Records</label></li>');
						$(this).siblings('.select-all').addClass('hidden');}
				   else{
						$(this).siblings('.options').find('.no_rec').remove(); 
						$(this).siblings('.select-all').removeClass('hidden');
				   };
			});
		},0);
	});
</script>