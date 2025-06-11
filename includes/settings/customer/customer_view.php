<div class="page page-ui-extras" ng-controller="ModalDemoCtrl">
<div ng-controller="CustomerCtrl">
   <div class="panel panel-lined table-responsive panel-hovered mb10" style="" >
        <ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
            <li><a href="#/dashboard" class="padding-10">Home</a></li>
             <li><a href="#/settings" class="padding-10">Settings</a></li>
            <li><a href="" class="padding-10">Customer</a></li>
        </ol>
        <ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;">
            <li><a href ng-click="customerexportOpen()" class="padding-10 export-btn" ng-if="export">Export</a></li>
        </ol>
   </div>
		<!-- row -->
		<div class="row">
			<!-- Data Table -->
			<div class="col-md-12 table-height">
				<div class="panel panel-lined table-responsive panel-hovered">
                 <div class="panel panel-default" ng-controller="mul_view_form">
            	 <form class="form-horizontal forms_ec" url="services/settings/customer_mul_view" name="userForm" method="post" novalidate>
                    <table class="table table-condensed" >
                        <thead>
                        <tr>
                            <th>
                                <a class="tktid">Customer Code&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" name="customerCode" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                            <th>
                                <a class="tktid">Customer Name&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" name="customerName" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                            <th class="hidden-xs" ng-controller="segmentdropCntrl">
                            	<select name="segmentAlias" placeholder="Segment" class="SlectBox form-control" ng-model="selectt.id" data-ng-change="listSorting()">
                                    <option value="" style="display:none">Segment</option>
                                    <option ng-repeat="segment in firstDrop" value="{{segment.alias}}">{{segment.name}}</option>
                                    <option ng-if="firstDrop.length==0">No Records</option>
                                </select>
                            </th>
                            <th class="hidden-xs hidden-sm">
                                <a class="tktid">Dispatch Warranty&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" name="dispatch" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                            <th class="hidden-xs hidden-sm">
                                <a class="tktid">Installation Warranty&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" name="installation" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                            <th class="hidden-xs" ng-controller="scheduleDropCtrl">
                            	<select name="schedule" placeholder="Schedule" class="SlectBox form-control" ng-model="schedule" data-ng-change="listSorting()">
                                    <option value="" style="display:none">Schedule</option>
                                    <option ng-repeat="schedule in schedules" value="{{schedule.name}}">{{schedule.name}}</option>
                                    <option ng-if="schedules.length==0">No Records</option>
                                </select>
                            </th>
                            <th class="hidden-xs">
                                <select name="status" placeholder="Status" class="SlectBox form-control" ng-model="status" data-ng-change="listSorting()">
                                    <option value="" style="display:none">Status</option>
                                    <option value="0">ACTIVE</option>
                                    <option value="1">DEACTIVE</option>
                                </select>
                            </th>
							<th>PO Copy</th>
                            <th class="hidden-xs hidden-sm" ng-if="datas.edit || datas.delete">
                                Actions
                            </th>
                        </tr>
                      </thead>
                    </table>

                    <div class="div-table-content">
                        <table class="table table-condensed table-hover">
                           <tbody>
                           		<tr class="tktBackground" ng-repeat="data in datas.customerDetails">
                                    <td ng-click="customerview(data.customer_alias)"><span tooltip-placement="top" tooltip="Click to know details of {{data.customer_code}}">{{data.customer_code}}</span></td>
									<td><span tooltip-placement="top" tooltip="{{data.customer_name}}">{{data.customer_name | strLimit:15}}</span></td>
                                    <td class="hidden-xs"><span tooltip-placement="top" tooltip="{{data.segment_name}}">{{data.segment_code}}</span></td>
                                    <td class="hidden-xs hidden-sm">{{data.dispatch}}</td>
                                    <td class="hidden-xs hidden-sm">{{data.installation}}</td>
                                    <td class="hidden-xs hidden-sm">{{data.schedule}}</td>
                                    <td class="hidden-xs">{{data.status=='1' ? 'DE' : ''}}ACTIVE</td>
									<td class="hidden-xs hidden-sm"><a href="{{data.po_file}}" ng-if="data.po_file!='-'" target="_blank" tooltip-placement="bottom" tooltip="Click for PO Copy">Click Here</a><span ng-if="data.po_file=='-'">{{data.po_file}}</span></td>
                                    <td class="hidden-xs hidden-sm" ng-if="datas.edit || datas.delete">
                                        <a href="" class="ml3" tooltip="Advance Edit" tooltip-placement="bottom" ng-click="setSettingsAlias(data.customer_alias);customereditOpen();" ng-if="datas.edit">
                                            <span class="fa fa-spl-edit"></span>
                                        </a>
                                        <a href="javascript:void(0)" class="ml3" tooltip="Delete" tooltip-placement="bottom" 
                                        ng-click="settingsDeleteOpen('customers', data);" ng-if="datas.delete">
                                            <span class="fa fa-delete"></span>
                                        </a>
                                    </td>
                                </tr>
                           </tbody>
                            <tfoot ng-if="datas.customerDetails.length=='0'"><tr><td>No Records</td></tr></tfoot>
                        </table>
                    </div>
                    <!-- #end data table -->	
                     <div class="panel-footer clearfix" ng-if="datas.customerDetails.length!='0'">
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
    <div><button type="button" class="btn btn-info ion ion-plus compose-btn" tooltip="Addnew" tooltip-placement="top" ng-click="customerOpen()" ng-if="add" md-ink-ripple></button></div>
<div id="ticketviesw">
	<div class="site-settings ticketviesw clearfix  col-xs-6 floating-sidebar" ng-class="{'open': customer_open}" custom-scrollbar>
        <div class="sidebar-wrap text-uppercase">
                <div class="group clearfix head tkt-heading">
                    <div class="left">
                    <span class="ion ion-close-round mr10 tktviewClose" ng-click="removecustomerView()"></span>
                        <span><strong>view customer</strong></span>
                    </div>
                    <div class="right" ng-controller="ModalDemoCtrl">
                        <div class="btn-group btn-group-sm">
                            <a href="services/settings/customer_print.php?alias={{singleViews.customer_alias}}" tooltip="Print" class="ml10" tooltip tooltip-placement="bottom"><span class="ion ion-android-print"></span></a>
                            <a href="services/settings/customer_download.php?alias={{singleViews.customer_alias}}" target="_blank" tooltip="Download" class="ml10" tooltip tooltip-placement="bottom"><span class="ion ion-android-download"></span></a>
                        </div>
                    </div>
                </div>
            	<div class="panel-body">
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Customer Code</h6>
                          <span class="fnt-size-11">{{singleViews.customer_code}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Customer Id</h6>
                          <span class="fnt-size-11">{{singleViews.customer_id}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Customer Name</h6>
                          <span class="fnt-size-11">{{singleViews.customer_name}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <!--<div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Contact Number</h6>
                          <span class="fnt-size-11">{{singleViews.customer_contact}}</span>
                        </div>-->
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Email</h6>
                          <span class="fnt-size-11">{{singleViews.customer_email}}</span>
                        </div>
						<div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Product Code</h6>
                          <span class="fnt-size-11">{{singleViews.product_description}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Segment</h6>
                          <span class="fnt-size-11">{{singleViews.segment_name}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Warranty From Dispatch</h6>
                          <span class="fnt-size-11">{{singleViews.dispatch}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Warranty From Installation</h6>
                          <span class="fnt-size-11">{{singleViews.installation}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Schedule</h6>
                          <span class="fnt-size-11">{{singleViews.schedule}}</span>
                        </div>
					</div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Created Date</h6>
                          <span class="fnt-size-11">{{singleViews.created_date}}</span>
                        </div>
						<div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>PO Copy</h6>
                          <span class="fnt-size-11">
							<a href="{{singleViews.po_file}}" ng-if="singleViews.po_file!='-'" target="_blank" tooltip-placement="top" tooltip="Click Here For PO Copy"><b><u><i>Click Here</i></u></b></a>
							<span ng-if="singleViews.po_file=='-'">{{singleViews.po_file}}</span>
						  </span>
						</div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Status</h6>
                          <span class="fnt-size-11">{{singleViews.status=='1' ? 'DE':''}}ACTIVE</span>
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