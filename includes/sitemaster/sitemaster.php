<div class="page page-ui-extras" ng-controller="ModalDemoCtrl">
<div ng-controller="SiteMasterCtrl">
	<!--<div ng-include="'includes/loading.php'"></div>-->
	<div ng-controller="mul_view_form">
    	<div class="panel panel-lined table-responsive panel-hovered mb10">
            <ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
                <li><a href="#/dashboard" class="padding-10">Home</a></li>
                <li><a href="" class="padding-10">Site Master</a></li>
            </ol>
            <ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;">
                <li ng-if="datas.export"><a href="" ng-click="sitemasterexportOpen()" class="padding-10 export-btn">Export</a></li>
                <li ng-if="datas.import"><a href="" ng-click="sitemasterimportOpen()" class="padding-10 export-btn">Import</a></li>
            </ol>
       </div>
		<!-- row -->
		<div class="row">
			<!-- Data Table -->
			<div class="col-md-12 table-height">
            <div class="panel panel-lined table-responsive panel-hovered">
            <div class="panel panel-default">
              <form class="form-horizontal forms_ec" url="services/sitemaster/sitemaster_mul_view" name="userForm" method="post" novalidate>
                <table class="table table-condensed" >
                        <thead>
                        <tr>
                            <th>
                                <a class="tktid">Site ID&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" name="siteId" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                            <th>
                                <a class="tktid">Site Name&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden form-control" name="siteName" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                            
                            <th class="hidden-xs hidden-sm" ng-controller="selectZoneCntrl">
                                 <select name="zoneAlias" placeholder="Zones" class="SlectBox form-control" ng-model="zoneAlias" data-ng-change="listSorting()">
                                    <option value="" style="display:none">Zones</option>
                                    <option ng-repeat="zones in firstDrop" value="{{zones.alias}}" ng-if="zones.alias!='4VTSNSSBM9'">{{zones.name}}</option>
                                    <option ng-if="firstDrop.length==0">No Records</option>
                                </select>
                            </th>
                            
                            <th class="hidden-xs hidden-sm">
                                <a class="tktid">States&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden form-control" name="stateName" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                             <th class="hidden-xs">
                                <a class="tktid">Customer&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden form-control" name="customerCode" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                           <!--<th class="hidden-xs hidden-sm">
                                <a class="tktid">Product&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden form-control" name="productName" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>-->
                            <th class="hidden-xs hidden-sm" ng-controller="segmentdropCntrl">
                               <select name="segmentAlias" placeholder="Segment" class="SlectBox form-control" ng-model="segmentAlias" data-ng-change="listSorting()">
                                    <option value="" style="display:none">Segment</option>
                                    <option ng-repeat="selectlist in firstDrop" value="{{selectlist.alias}}">{{selectlist.name}}</option>
                                    <option ng-if="firstDrop.length==0">No Records</option>
                                </select>
                            </th>
                            <th>
                               <select name="siteStatus" placeholder="siteStatus" class="SlectBox form-control" ng-model="siteStatus" data-ng-change="listSorting()">
                                    <option value="" style="display:none">Site Status</option>
                                    <option value="0">OUT OF WARRANTY</option>
                                    <option value="1">UNDER WARRANTY</option>
                                    <option value="2">DELETED</option>
                               </select>
                            </th>
                            <th class="hidden-xs hidden-sm"  ng-if="datas.delete || datas.restore">Actions</th>
                        </tr>
                        </thead>
                    </table>
                    <div class="div-table-content">
                        <table class="table table-hover">
                          <tbody>
                               <tr class="tktBackground" ng-repeat="data in datas.sitemasterDetails">
                              		<td ng-click="sitemaster(data.site_alias)"><span tooltip-placement="top" tooltip="Click to know details of {{data.site_id}}">{{data.site_id}}</span></td>
                                    <td><span tooltip-placement="top" tooltip="{{data.full_site_name}}"><span style='display:none';>{{data.full_site_name}}</span>{{data.site_name}}</span></td>
                                    <td class="hidden-xs hidden-sm">{{data.zone_name}}</td>
                                    <td class="hidden-xs hidden-sm"><span tooltip-placement="top" tooltip="{{data.state_name}}">{{data.state_code}}</span></td>
                                    <td class="hidden-xs"><span tooltip-placement="top" tooltip="{{data.customer_name}}">{{data.customer_code}}</span></td>
                                    <!--<td class="hidden-xs hidden-sm"><span tooltip-placement="top" tooltip="{{data.product_name}}">{{data.product_description}}</span></td>-->
                                    <td class="hidden-xs hidden-sm"><span tooltip-placement="top" tooltip="{{data.segment_name}}">{{data.segment_code}}</span></td>
                                    <td>{{data.site_status}}</td>
                                    <td ng-if="datas.delete || datas.restore" class="hidden-xs hidden-sm">
                                      <a href="javascript:void(0)" class="ml10" tooltip="Delete" 
                                        tooltip-placement="bottom" ng-click="siteMasterDeleteOpen(data);"
                                        ng-if="data.deleted == '0' && datas.delete">
                                        <span class="fa fa-delete"></span>
                                      </a>
                                      <a href="javascript:void(0)" class="ml10" tooltip="Restore" 
                                        tooltip-placement="bottom" ng-click="siteMasterRestoreOpen(data);" 
                                        ng-if="data.deleted == '1' && datas.restore">
                                        <span class="fa fa-rotate-right"></span>
                                      </a>
                                    </td>
                                </tr>
                          </tbody>
                         	 <tfoot ng-if="datas.sitemasterDetails.length=='0'"><tr><td>No Records</td></tr></tfoot>
                        </table>
                        </div>
                        <!-- #end data table -->	
                         <div class="panel-footer clearfix" ng-if="datas.sitemasterDetails.length!='0'">
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
    <div ng-if="datas.add"><button type="button" class="btn btn-info ion ion-plus compose-btn" tooltip="Add New" tooltip-placement="top" ng-click="sitemasteraddOpen()" md-ink-ripple></button></div>
</div>
</div> <!-- #end page-wrap -->
<div id="ticketviesw">
	<div class="site-settings ticketviesw clearfix  col-xs-6 floating-sidebar" ng-class="{'open': siteMaster_open}">
        <div class="sidebar-wrap text-uppercase mt47">
                <div class="group clearfix head tkt-heading2">
                    <div class="left">
                    <span class="ion ion-close-round mr10 tktviewClose" ng-click="removeSitemaster()"></span>
                        <span><strong>{{singleViews.site_id}}</strong></span>
                    </div>
                    <div class="right">
                        <div class="btn-group btn-group-sm" ng-controller="ModalDemoCtrl">
                            <a href="" class="ml10" tooltip="Edit" tooltip-placement="bottom" ng-click="sitemastereditOpen()" ng-if="singleViews.edit"><span class="fa fa-edit"></span></a>
                            <a href="services/sitemaster/sitemaster_print.php?alias={{singleViews.site_alias}}" tooltip="Print" class="ml10" tooltip-placement="bottom"><span class="ion ion-android-print"></span></a>
                            <a href="services/sitemaster/sitemaster_download.php?alias={{singleViews.site_alias}}" target="_blank" tooltip="Download" class="ml10" tooltip-placement="bottom"><span class="ion ion-android-download"></span></a>
                        </div>
                    </div>
                </div>
            	<div class="panel-body clearfix freez-panel">
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Site ID</h6>
                          <span class="fnt-size-11">{{singleViews.site_id}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Site Name</h6>
                          <span class="fnt-size-11">{{singleViews.site_name}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Zones</h6>
                          <span class="fnt-size-11">{{singleViews.zone_name}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>State</h6>
                          <span class="fnt-size-11">{{singleViews.state_name}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Districts</h6>
                          <span class="fnt-size-11">{{singleViews.district_name}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Customer Code</h6>
                          <span class="fnt-size-11">{{singleViews.customer_name}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Product Code</h6>
                          <span class="fnt-size-11">{{singleViews.product_description}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Battery Bank Rating</h6>
                          <span class="fnt-size-11">{{singleViews.battery_bank_rating}}</span>
                        </div>
                         <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Number Of Strings</h6>
                          <span class="fnt-size-11">{{singleViews.no_of_string}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Segment</h6>
                          <span class="fnt-size-11">{{singleViews.segment_name}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Manufacturing Date</h6>
                          <span class="fnt-size-11">{{singleViews.mfd_date}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Installation Date</h6>
                          <span class="fnt-size-11">{{singleViews.install_date}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Sale PO Number</h6>
                          <span class="fnt-size-11">{{singleViews.po_num}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Sale Invoice Number</h6>
                          <span class="fnt-size-11">{{singleViews.sale_invoice_num}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Sale Invoice Date</h6>
                          <span class="fnt-size-11">{{singleViews.sale_invoice_date}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>First Level Contact Name</h6>
                          <span class="fnt-size-11">{{singleViews.technician_name}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>First Level Contact Number</h6>
                          <span class="fnt-size-11">{{singleViews.technician_number}}</span>
                        </div>
                         <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Second Level Contact Name</h6>
                          <span class="fnt-size-11">{{singleViews.manager_name}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Second Level Contact Number</h6>
                          <span class="fnt-size-11">{{singleViews.manager_number}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Second Level Contact Email</h6>
                          <span class="fnt-size-11">{{singleViews.manager_mail}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Preventive Maintenance</h6>
                          <span class="fnt-size-11">{{singleViews.schedule}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Warranty (In Months)</h6>
                          <span class="fnt-size-11">{{singleViews.warrantymonths}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Warranty Left</h6>
                          <span class="fnt-size-11">{{singleViews.warrantyleft}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Site Status</h6>
                          <span class="fnt-size-11">{{singleViews.site_status}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Site Type</h6>
                          <span class="fnt-size-11">{{singleViews.site_type}}</span>
                        </div> 
                         <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Created Date</h6>
                          <span class="fnt-size-11">{{singleViews.created_date}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Site Address</h6>
                          <span class="fnt-size-11">{{singleViews.site_address}}</span>
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