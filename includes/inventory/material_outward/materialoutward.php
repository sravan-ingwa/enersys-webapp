<div class="page page-ui-extras" ng-controller="ModalDemoCtrl">
  <div ng-controller="MaterialoutwardCtrl">
  <div ng-controller="mul_view_form">
    <div class="panel panel-lined table-responsive panel-hovered mb10" >
      <ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
        <li><a href="#/dashboard" class="padding-10">Home</a></li>
        <li><a href="" class="padding-10">Material Outward</a></li>
      </ol>
      <ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;" ng-if="datas.export">
            <!--<li><a href="exports/{{singleViews.file_name}}.xlsx" ng-click="materialoutwardexport()" class="padding-10 export-btn">Export</a></li>-->
			<li><a href="" ng-click="materialoutwardexportOpen()" class="padding-10 export-btn">Export</a></li>
        </ol>
    </div>
    <div class="row">
      <div class="col-md-12 table-height">
        <div class="panel panel-lined table-responsive panel-hovered">
          <div class="panel panel-default">
            <form class="form-horizontal forms_ec" url="services/inventory/material_outward_multi" name="userForm" method="post" novalidate>
              <table class="table table-condensed" >
                <thead>
                  <tr>
                    <th>
						<a class="tktid">Ref Number&nbsp;<span class="arrow caret"></span></a>
						<input type="text" name="mrfnumber" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" ng-model="searchKeywords.mrfnumber" data-ng-keyup="listSorting()">
						<span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
					</th>
                    <th class="hidden-xs hidden-sm" ng-controller="DatepickerDemoCtrl"> <a class="tktid">Date&nbsp;<span class="arrow caret"></span></a>
						<input type="text" name="mdate" class="form-control datepicker border-bottom droptxt1 hidden" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-model="dt" is-open="opened" min-date="minDate" max-date="'2025-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="listSorting();open($event)"/>
						<span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
					</th>
					<th>
						<a class="tktid">SJO Number&nbsp;<span class="arrow caret"></span></a>
						<input type="text" name="sjonumber" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" ng-model="searchKeywords.sjonumber" data-ng-keyup="listSorting()">
						<span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
					</th>
					<th class="hidden-xs">
						<a class="tktid">TT Number&nbsp;<span class="arrow caret"></span></a>
						<input type="text" name="ticket_id" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" ng-model="searchKeywords.ticket_id" data-ng-keyup="listSorting()">
						<span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
					</th>
                    <th class="hidden-xs">
                        <a class="tktid">From W/H&nbsp;<span class="arrow caret"></span></a>
                        <input type="text" name="fwh" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" ng-model="searchKeywords.fwh" data-ng-keyup="listSorting()">
                        <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                    </th>
                    <th class="hidden-xs">
                        <a class="tktid">To W/H&nbsp;<span class="arrow caret"></span></a>
                        <input type="text" name="towh" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" ng-model="searchKeywords.twh" data-ng-keyup="listSorting()">
                        <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                    </th>
                    <th class="hidden-xs hidden-sm">
						<a class="tktid">Material Value&nbsp;<span class="arrow caret"></span></a>
						<input type="text" name="mvalue" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" ng-model="searchKeywords.materialvalue" data-ng-keyup="listSorting()">
						<span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
					</th>
					<th>
						<select name="level" placeholder="Level" class="SlectBox form-control" ng-controller="invenoryLevelsCtrl" ng-model="levelsing" data-ng-change="listSorting()">
							<option value="" style="display:none">Level</option>
							<option value="{{level.alias}}" ng-if="level.alias=='0' || level.alias=='4' || level.alias=='6'" ng-repeat="level in firstDrop">{{level.name}}</option>
						</select>
					</th>
          <th class="hidden-xs hidden-sm" ng-if="datas.delete || datas.splEdit">
              Actions
          </th>
                  </tr>
                </thead>
                </table>
                <div class="div-table-content">
                <table class="table table-condensed table-hover">
                    <tbody>
                      <tr class="tktBackground" ng-repeat="data in datas.requestDetails">
                        <td ng-click="materialoutwardsingleview(data.mrf_alias)"><span tooltip-placement="top" tooltip="Click to know details of {{data.mrfnumber}}">{{data.mrfnumber}}</span></td>
                        <td class="hidden-xs hidden-sm">{{data.dateofrequest}}</td>
                        <td>{{data.sjonumber!='' ? data.sjonumber : '-'}}</td>
                        <td class="hidden-xs">{{data.ticket_id!='' ? data.ticket_id : '-'}}</td>
                        <td class="hidden-xs">{{data.fromwh}}</td>
						<td class="hidden-xs"><span tooltip-placement="top" ng-attr-tooltip="{{data.towh.length>15 ? data.towh : ''}}">{{data.towh | limitTo:15}}{{data.towh.length>15 ? '...':''}}</span></td>
                        <td class="hidden-xs hidden-sm">Rs. {{data.materialvalue | number : 2}}</td>
            <td><i class="fa fa-signal" style="color:{{data.levelcolor}} !important;" tooltip-placement="top" tooltip="{{data.levelname}}"></i>&nbsp;{{data.levelname}}</td>
            
            <td class="hidden-xs hidden-sm" ng-if="datas.delete || datas.splEdit">
              <a href="javascript:void(0)" class="ml3" tooltip="Advance Edit" tooltip-placement="bottom" ng-click="setSettingsAlias(data.mrf_alias);materialoutwardeditOpen();" ng-if="datas.splEdit">
                  <span class="fa fa-spl-edit"></span>
              </a>
              <a href="javascript:void(0)" class="ml3" tooltip="Delete" tooltip-placement="bottom" ng-click="settingsDeleteOpen('material_outward', data);" ng-if="datas.delete">
                  <span class="fa fa-delete"></span>
              </a>
            </td>
                      </tr>
                    </tbody>
                    <tfoot ng-if="datas.requestDetails.length=='0'">
                      <tr>
                        <td colspan="5">Oho! There are no records to Display</td>
                      </tr>
                    </tfoot>
              </table>
              </div>
              <div class="panel-footer clearfix" ng-if="datas.requestDetails.length!='0'">
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
				<div class="col-sm-12" ng-if="datas.requestDetails.length=='0'"> <img src="images/nostock.png" class="norecords"/> </div>
            </form>
          </div>
        </div>
      </div>
		<div ng-if="datas.add">
		  <button type="button" class="btn btn-info ion ion-plus compose-btn" tooltip="Addnew" tooltip-placement="top" ng-click="materialoutwardaddOpen()" md-ink-ripple></button>
		</div>
    </div>
	</div>
<div id="ticketviesw">    
    <div class="site-settings ticketviesw clearfix  col-xs-6 floating-sidebar" ng-class="{'open': mInward_open}">
      <div class="sidebar-wrap text-uppercase mt46">
        <div class="group clearfix head tkt-heading2">
          <div class="left"> <span class="ion ion-close-round mr10 tktviewClose" ng-click="removeMinward()"></span> <span><strong>Material Outward Details</strong></span> </div>
          <div class="right">
        <!--<div class="btn-group btn-group-sm" ng-controller="ModalDemoCtrl">
				<a href="" ng-if="singleViews.edit" tooltip="Edit" class="ml10" tooltip tooltip-placement="bottom"><span class="fa fa-edit"></span></a>
				<a href="" tooltip="Print" class="ml10" tooltip-placement="bottom"><span class="ion ion-android-print"></span></a>
				<a href="" tooltip="Download" class="ml10" tooltip-placement="bottom"><span class="ion ion-android-download"></span></a>
			</div>-->
			<div class="btn-group btn-group-sm">
				<!--<a href="" ng-if="singleViews.admin_priv" class="ml10" tooltip-placement="bottom" tooltip="Edit" ng-click="materialoutwardeditOpen();"><span class="fa fa-wrench"></span></a>-->
				<a href="services/inventory/material_outward_print.php?alias={{singleViews.trans_alias}}" target="_blank" tooltip="Print" class="ml10" tooltip-placement="bottom"><span class="ion ion-android-print"></span></a>
				<a href="services/inventory/material_outward_download.php?alias={{singleViews.trans_alias}}" target="_blank" tooltip="Download" class="ml10" tooltip-placement="bottom"><span class="ion ion-android-download"></span></a>
           </div>
          </div>
        </div>
        <div class="panel-body clearfix freez-panel">
          <div class="row tkt-panel">
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>Ref Number</h6>
              <span class="fnt-size-11">{{singleViews.trans_id}}</span> </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>Date Of Transaction</h6>
              <span class="fnt-size-11">{{singleViews.date_of_request}}</span> </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>From W/H</h6>
              <span class="fnt-size-11">{{singleViews.from_wh}}</span> </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>To W/H</h6>
              <span class="fnt-size-11">{{singleViews.to_wh}}</span> </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>Road Permit</h6>
              <span class="fnt-size-11">{{singleViews.road_permit}}</span> </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>Total  Material Value</h6>
              <span class="fnt-size-11">{{singleViews.material_value | number : 2}}</span> </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>MRF Number</h6>
              <span class="fnt-size-11">{{singleViews.mrf_number}}</span> </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>SJO Number</h6>
              <span class="fnt-size-11">{{singleViews.sjo}}</span> </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>Ticket ID</h6>
              <span class="fnt-size-11">{{singleViews.ticket_id}}</span> </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>Transport Details</h6>
              <span class="fnt-size-11">{{singleViews.transport_no}}</span> </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>Docket Number</h6>
              <span class="fnt-size-11">{{singleViews.docket_no}}</span> </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>Dispatch Date</h6>
              <span class="fnt-size-11">{{singleViews.dispatch_date}}</span> </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <h6>Responsible Engineer</h6>
              <span class="fnt-size-11">{{singleViews.resp_engineer}}</span> </div>
			<div class="col-lg-4 col-md-4 col-sm-4">
              <h6>Declaration</h6>
			  <span class="fnt-size-11"><a href="<?php echo $baseurl;?>services/inventory/declaration.php?mo_alias={{singleViews.trans_alias}}" target="_blank" tooltip-placement="top" tooltip="Declaration of {{singleViews.trans_id}}">Click Here</a></span> </div>
          </div>
          <div ng-if="singleViews.request_length != 0" class="mt10">
            <h4 class="modal-title text-center">Shipped Items</h4>
            <table class="table table-condensed" >
              <thead>
                <tr>
                  <th width="7%"><a class="tktid">Sr.No</a></th>
                  <th><a class="tktid">Item Type</a></th>
                  <th><a class="tktid">Description</a></th>
                  <th><a class="tktid">Cell No. / Qty</a></th>
                  <th><a class="tktid">Condition</a></th>
                </tr>
              <thead>
            </table>
            <div style="max-height:300px; overflow:auto; overflow-x:hidden;">
              <table class="table table-hover table-condensed">
                <tbody>
                  <tr class="tktBackground" ng-repeat="(key,rem) in singleViews.request_items">
                    <td width="7%">{{key + 1}}</td>
                    <td>{{rem.item_type==1 ? 'Cells' : 'Accessory'}}</td>
                    <td class="hidden-xs hidden-sm">{{rem.item_code}}</td>
                    <td>{{rem.item_description}}</td>
                    <td>{{rem.condition}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div ng-if="singleViews.remark_length != 0" class="mt10">
            <h4 class="modal-title text-center">Remarks</h4>
            <table class="table table-condensed" >
              <thead>
                <tr>
                  <th><a class="tktid">Sr.No</a></th>
                  <th><a class="tktid">Remark By</a></th>
                  <th><a class="tktid">Remark On</a></th>
                  <th><a class="tktid">Remark</a></th>
                </tr>
              <thead>
            </table>
            <div style="max-height:500px; overflow:auto; overflow-x:hidden;">
              <table class="table table-hover table-bordered">
                <tbody>
                  <tr class="tktBackground" ng-repeat="(key,rem) in singleViews.remark">
                    <td>{{key + 1}}</td>
                    <td><p tooltip-placement="top" tooltip="{{rem.designation}}">{{rem.remarked_by}}</p></td>
                    <td class="hidden-xs hidden-sm">{{rem.remarked_on}}</td>
                    <td>{{rem.remarks}}</td>
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
	   /*---multiple-select dropdown-----*/
		setInterval(function(){$('.SlectBox').SumoSelect();},0);
	});
</script>