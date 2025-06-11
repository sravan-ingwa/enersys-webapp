<div class="page page-ui-extras" ng-controller="ModalDemoCtrl">
<div  ng-controller="WarehousecodeCtrl">
   <div class="panel panel-lined table-responsive panel-hovered mb10" style="" >
        <ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
            <li><a href="#/dashboard" class="padding-10">Home</a></li>
             <li><a href="#/settings" class="padding-10">Settings</a></li>
            <li><a href="" class="padding-10">Warehouse Code</a></li>
        </ol>
        <ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;">
            <li><a href="" ng-click="warehouseexportOpen()" class="padding-10 export-btn" ng-if="export">Export</a></li>
        </ol>
   </div>
		<!-- row -->
		<div class="row">
			<!-- Data Table -->
			<div class="col-md-12 table-height">
				<div class="panel panel-lined table-responsive panel-hovered">
                <div class="panel panel-default" ng-controller="mul_view_form">
            	 <form class="form-horizontal forms_ec" url="services/settings/warehouse_mul_view" name="userForm" method="post" novalidate>
                    <table class="table table-condensed" >
                        <thead>
                        <tr>
                             <th>
                                <a class="tktid">Wh Code&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" name="whCode" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                            
                            <th>
                                <a class="tktid">Wh Description&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" name="description" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                            <th class="hidden-xs hidden-sm">
                                <a class="tktid">Wh Address&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" name="whAddress" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                        	<th class="hidden-xs hidden-sm" ng-controller="selectZoneCntrl">
                            	<select name="zoneAlias" placeholder="Zones" class="SlectBox form-control" ng-model="selectt.id" data-ng-change="listSorting()">
                                    <option value="" style="display:none">Zones</option>
                                    <option ng-repeat="Zones in firstDrop" value="{{Zones.alias}}">{{Zones.name}}</option>
                                    <option ng-if="firstDrop.length==0">No Records</option>
                                </select>
                            </th>
                            <th class="hidden-xs hidden-sm">
                                <a class="tktid">States&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" name="stateName" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                        	<th class="hidden-xs hidden-sm">
                            	<select name="road_permit" placeholder="Road Permit" class="SlectBox form-control" ng-model="road_permit" data-ng-change="listSorting()">
                                    <option value="" style="display:none">Road Permit</option>
                                    <option value="0">NOT REQUIRED</option>
									<option value="1">REQUIRED</option>
                                </select>
                            </th>
                            <th class="hidden-xs hidden-sm" ng-if="datas.edit || datas.delete">
                                Actions
                            </th>
                        </tr>
                        </thead>
                    </table>

                    <div class="div-table-content">
                        <table class="table table-condensed table-hover">
                           <tbody>
                           		<tr class="tktBackground" ng-repeat="data in datas.warehouseDetails">
                                    <td><span tooltip-placement="top" tooltip="Click to know details of {{data.wh_code}}" ng-click="warehousecodeview(data.wh_alias)">{{data.wh_code}}</span></td>
                                    <td><span tooltip-placement="top" tooltip="{{data.description.length > 15 ? data.description : ''}}">{{ data.description | strLimit: 15 }}</span></td>
                                    <td class="hidden-xs hidden-sm"><span tooltip-placement="top" tooltip="{{data.wh_address.length > 15 ? data.wh_address : ''}}">{{ data.wh_address | strLimit: 15 }}</span></td>
                                    <td class="hidden-xs hidden-sm">{{data.zone_alias}}</td>
                                    <td class="hidden-xs hidden-sm"><span tooltip-placement="top" tooltip="{{data.state_alias.length > 15 ? data.state_alias : ''}}">{{ data.state_alias | strLimit: 15 }}</span></td>
                                    <td class="hidden-xs hidden-sm">{{data.road_permit=='1' ? 'REQUIRED':'NOT REQUIRED'}}</td>
                                    <td class="hidden-xs hidden-sm" ng-if="datas.edit || datas.delete">
                                        <a href="" class="ml3" tooltip="Advance Edit" tooltip-placement="bottom" ng-click="setSettingsAlias(data.wh_alias);warehouseeditOpen();" ng-if="datas.edit">
                                            <span class="fa fa-spl-edit"></span>
                                        </a>
                                        <a href="javascript:void(0)" class="ml3" tooltip="Delete" tooltip-placement="bottom" 
                                        ng-click="settingsDeleteOpen('warehouse', data);" ng-if="datas.delete">
                                            <span class="fa fa-delete"></span>
                                        </a>
                                    </td>
                                </tr> 
                           </tbody>
                           <tfoot ng-if="datas.warehouseDetails.length=='0'"><tr><td>No Records</td></tr></tfoot>
                        </table>
                    </div>
                    <!-- #end data table -->	
                     <div class="panel-footer clearfix" ng-if="datas.warehouseDetails.length!='0'">
                        <div class="col-md-4">
                        <p class="left small" style="margin:0px !important;">Showing {{datas.fromRecords}} to {{datas.toRecords}} of {{datas.totalRecords}} entries</p>
                        </div>
                        <div class="col-md-4">
                        <div class="small text-bold right ml15">
                        <span class="control-label">Page No. </span>
                        <select class="form-control page-count"  name="page_no" ng-model="selectt.id" data-ng-change="listSorting()">
                            <option value="" style="display:none">1</option>
                            <option ng-repeat="pagess in datas.pages" ng-show="$index > 0" value="{{pagess}}">{{pagess}}</option>
                        </select> 
                        </div>
                        </div>
                        <div class="col-md-4">
                        <div class="small text-bold right ml15">
                        <span class="control-label">Count per page</span>
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
		<!-- #end row -->
	</div> 
    <div><button type="button" class="btn btn-info ion ion-plus compose-btn" tooltip="Addnew" tooltip-placement="top" ng-click="warehouseOpen()" ng-if="add" md-ink-ripple></button></div>
<div id="ticketviesw">
	<div class="site-settings ticketviesw clearfix  col-xs-6 floating-sidebar" ng-class="{'open': warehousecode_open}" custom-scrollbar>
        <div class="sidebar-wrap text-uppercase">
                <div class="group clearfix head tkt-heading">
                    <div class="left">
                    <span class="ion ion-close-round mr10 tktviewClose" ng-click="removewarehouseView()"></span>
                        <span><strong>view Warehouse code</strong></span>
                    </div>
                    <div class="right" ng-controller="ModalDemoCtrl">
                        <div class="btn-group btn-group-sm">
                            <a href="services/settings/warehouse_print.php?alias={{singleViews.wh_alias}}" tooltip="Print" class="ml10" tooltip tooltip-placement="bottom"><span class="ion ion-android-print"></span></a>
                            <a href="services/settings/warehouse_download.php?alias={{singleViews.wh_alias}}" target="_blank" tooltip="Download" class="ml10" tooltip tooltip-placement="bottom"><span class="ion ion-android-download"></span></a>
                        </div>
                    </div>
                </div>
            	<div class="panel-body">
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Wh Code</h6>
                          <span class="fnt-size-11">{{singleViews.wh_code}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Wh Description</h6>
                          <span class="fnt-size-11">{{singleViews.description}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Wh Address</h6>
                          <span class="fnt-size-11">{{singleViews.wh_address}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Zones</h6>
                          <span class="fnt-size-11">{{singleViews.zone_name}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>State</h6>
                          <span class="fnt-size-11">{{singleViews.state_name}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Road Permit</h6>
                          <span class="fnt-size-11">{{singleViews.road_permit=='1' ? 'REQUIRED':'NOT REQUIRED'}}</span>
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