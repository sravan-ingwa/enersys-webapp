  <style>
  .SumoSelect > .optWrapper {right:-27px !important;}
  </style>
  <div class="page page-ui-extras" ng-controller="ModalDemoCtrl">
<div ng-controller="AssetsCtrl">
   <div class="panel panel-lined table-responsive panel-hovered mb10" style="" >
        <ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
            <li><a href="#/dashboard" class="padding-10">Home</a></li>
            <li><a href="#/settings" class="padding-10">Settings</a></li>
            <li><a href="" class="padding-10">Assets</a></li>
        </ol>
        <ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;">
            <li><a href="exports/{{singleViews.file_name}}.xlsx" ng-click="assetexport()" class="padding-10 export-btn" ng-if="export">Export</a></li>
        </ol>
   </div>
		<!-- row -->
		<div class="row">
			<!-- Data Table -->
			<div class="col-md-12 table-height">
				<div class="panel panel-lined table-responsive panel-hovered">
                <div class="panel panel-default" ng-controller="mul_view_form">
            	 <form class="form-horizontal forms_ec" url="services/settings/assets_mul_view" name="userForm" method="post" novalidate>
                    <table class="table table-condensed" >
                        <thead>
                        <tr>
                        	<th>
                                <a class="tktid">Asset Name&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" name="assetName" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                            <th ng-controller="assetdropCntrl">
                                 <select name="assetType" placeholder="Asset Type" class="SlectBox form-control" ng-model="selectt.id" data-ng-change="listSorting()">
                                    <option value="" style="display:none">Asset Type</option>
                                    <option ng-repeat="asset in assets" value="{{asset.name}}">{{asset.name}}</option>
                                    <option ng-if="firstDrop.length==0">No Records</option>
                                </select>
                            </th>
                            <th class="hidden-xs hidden-sm">
                                <a class="tktid">Asset Make&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" name="assetMake" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                             <th class="hidden-xs hidden-sm">
                                <a class="tktid">Asset Serial No&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" name="assetSerialNumber" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                            <th class="hidden-xs hidden-sm" ng-controller="DatepickerDemoCtrl">
                                <a class="tktid">Cal Date&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="form-control datepicker border-bottom droptxt1 hidden" name="calibrationDate" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-model="calDate" is-open="opened" min-date="minDate" max-date="'2025-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="listSorting();open($event)"/>
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                            <th class="hidden-xs hidden-sm" ng-controller="DatepickerDemoCtrl">
                                <a class="tktid">Cal Due Date&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="form-control datepicker border-bottom droptxt1 hidden" name="calibrationDueDate" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-model="calDueDate" is-open="opened" min-date="minDate" max-date="'2025-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="listSorting();open($event)"/>
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                            <th class="hidden-xs" ng-controller="natureofassetDropCntrl">
                                <select name="natureOfAsset" placeholder="Nature of Asset" class="SlectBox form-control" ng-model="selectt.id" data-ng-change="listSorting()">
                                    <option value="" style="display:none">Nature of Asset</option>
                                    <option ng-repeat="noa in natureofassets" value="{{noa.name}}">{{noa.name}}</option>
                                    <option ng-if="firstDrop.length==0">No Records</option>
                                </select>	
                            </th>
                             <th class="hidden-xs hidden-sm">
                                <a class="tktid">Specification&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" name="specification" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
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
                                <tr class="tktBackground" ng-repeat="data in datas.assetDetails">
                                 	<td ng-click="assetsview(data.asset_alias)"><span tooltip-placement="top" tooltip="Click to know details of {{data.asset_name}}">{{data.asset_name}}</span></td>
                                    <td>{{data.asset_type}}</td>
                                    <td class="hidden-xs hidden-sm">{{data.asset_make}}</td>
                                    <td class="hidden-xs hidden-sm">{{data.asset_serial_number}}</td>
                                    <td class="hidden-xs hidden-sm">{{data.calibration_date}}</td>
                                    <td class="hidden-xs hidden-sm">{{data.calibration_due_date}}</td>
                                    <td class="hidden-xs">{{data.nature_of_asset}}</td>
                                    <td class="hidden-xs hidden-sm">{{data.specification}}</td>
                                    <td class="hidden-xs hidden-sm" ng-if="datas.edit || datas.delete">
                                        <a href="" class="ml3" tooltip="Advance Edit" tooltip-placement="bottom" ng-click="setSettingsAlias(data.asset_alias);asseteditOpen();" ng-if="datas.edit">
                                            <span class="fa fa-spl-edit"></span>
                                        </a>
                                        <a href="javascript:void(0)" class="ml3" tooltip="Delete" tooltip-placement="bottom" 
                                        ng-click="settingsDeleteOpen('assets', data);" ng-if="datas.delete">
                                            <span class="fa fa-delete"></span>
                                        </a>
                                    </td>
                                </tr>
                           </tbody>
                           <tfoot ng-if="datas.assetDetails.length=='0'"><tr><td>No Records</td></tr></tfoot>
                        </table>
                    </div>
                    <!-- #end data table -->	
                     <div class="panel-footer clearfix" ng-if="datas.assetDetails.length!='0'">
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
    <div><button type="button" class="btn btn-info ion ion-plus compose-btn" tooltip="Addnew" tooltip-placement="top" ng-click="assetaddOpen()" ng-if="add" md-ink-ripple></button></div>


<div id="ticketviesw">
	<div class="site-settings ticketviesw clearfix  col-xs-6 floating-sidebar" ng-class="{'open': assets_open}" custom-scrollbar>
        <div class="sidebar-wrap text-uppercase">
                <div class="group clearfix head tkt-heading">
                    <div class="left">
                    <span class="ion ion-close-round mr10 tktviewClose" ng-click="removeassetsView()"></span>
                        <span><strong>View Asset</strong></span>
                    </div>
                    <div class="right" ng-controller="ModalDemoCtrl">
                        <div class="btn-group btn-group-sm">
                            <a href="services/settings/assets_print.php?alias={{singleViews.asset_alias}}" tooltip="Print" class="ml10" tooltip tooltip-placement="bottom"><span class="ion ion-android-print"></span></a>
                            <a href="services/settings/assets_download.php?alias={{singleViews.asset_alias}}" target="_blank" tooltip="Download" class="ml10" tooltip tooltip-placement="bottom"><span class="ion ion-android-download"></span></a>
                        </div>
                    </div>
                </div>
            	<div class="panel-body">
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Asset Type</h6>
                          <span class="fnt-size-11">{{singleViews.asset_type}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Asset Name</h6>
                          <span class="fnt-size-11">{{singleViews.asset_name}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Asset Make</h6>
                          <span class="fnt-size-11">{{singleViews.asset_make}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Asset Serial No</h6>
                          <span class="fnt-size-11">{{singleViews.asset_serial_number}}</span>
                        </div>
                         <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Calibration Date</h6>
                          <span class="fnt-size-11">{{singleViews.calibration_date}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Cal Due Date</h6>
                          <span class="fnt-size-11">{{singleViews.calibration_due_date}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                     	<div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Specification</h6>
                          <span class="fnt-size-11">{{singleViews.specification}}</span>
                        </div>
                    	<div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Nature Of Asset</h6>
                          <span class="fnt-size-11">{{singleViews.nature_of_asset}}</span>
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