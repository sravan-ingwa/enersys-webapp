<div class="page page-ui-extras" ng-controller="EnersysExpenseCtrl">
<div ng-controller="ServicesCtrl">
   <div class="panel panel-lined table-responsive panel-hovered mb10">
        <ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
            <li><a href="#/dashboard" class="padding-10">Home</a></li>
            <li><a href="#/settings" class="padding-10">Settings</a></li>
            <li><a href="" class="padding-10">Allowances Details</a></li>
        </ol>
        <ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;">
            <li><a href="exports/{{expenseViews.file_name}}.xlsx" ng-click="serexport()" class="padding-10 export-btn" ng-if="expenses.export">Export</a></li>
        </ol>
   </div>
		<!-- row -->
		<div class="row">
			<!-- Data Table -->
			<div class="col-md-12 table-height">
				<div class="panel panel-lined table-responsive panel-hovered">
                 <div class="panel panel-default">
            	 <form class="form-horizontal forms_exp" url="services/expense_tracker/serallowances_mul_view" name="serviewForm" method="post" novalidate>
                    <table class="table table-condensed" >
                        <thead>
                        <tr>
                        	<th ng-controller="selectZoneCntrl" class="hidden-xs hidden-sm">
                                 <select name="zoneAlias" placeholder="Zones" class="SlectBox form-control" ng-model="selectt.id" data-ng-change="expsorting()">
                                    <option value="" style="display:none">Zones</option>
                                    <option ng-repeat="zones in firstDrop" value="{{zones.alias}}">{{zones.name}}</option>
                                    <option ng-if="firstDrop.length==0">No Records</option>
                                </select>
                            </th>
                            <th class="hidden-xs hidden-sm">
                                <a class="tktid">State&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" name="stateAlias" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="expsorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="expsorting()"></span>
                            </th>
                            <th>
                                <a class="tktid">District&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" name="districtAlias" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="expsorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="expsorting()"></span>
                            </th>
                            <th>
                                 <select name="areaAlias" placeholder="Area" class="SlectBox form-control" ng-model="selectt" data-ng-change="expsorting()">
                                    <option value="" style="display:none">Area</option>
                                    <option value="0">PLAIN AREA</option>
                                    <option value="1">HILLY AREA</option>
                                </select>
                            </th>
                            <th>
                                <a class="tktid">Lodging Amount&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" name="ldgAmntAlias" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="expsorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="expsorting()"></span>
                            </th>
                            <th>
                                <a class="tktid">Daily Allowance&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" name="dailyallowAlias" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="expsorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="expsorting()"></span>
                            </th>
                            <th class="hidden-xs">
                                <a class="tktid">Local Conveyance&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" name="lclconvAlias" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="expsorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="expsorting()"></span>
                            </th>
                            <th class="hidden-xs hidden-sm" ng-if="expenses.edit || expenses.delete">
                                Actions
                            </th>
                        </tr>
                      </thead>
                    </table>

                    <div class="div-table-content">
                        <table class="table table-condensed table-hover">
                           <tbody>
                           		<tr class="tktBackground" ng-repeat="exp in expenses.serallowancesDetails">
                                    <td class="hidden-xs hidden-sm" ng-click="services(exp.service_allowance_alias)"><span tooltip-placement="top" tooltip="Click to know details of {{exp.zone_name}}">{{exp.zone_name}}</span></td>
                                    <td class="hidden-xs hidden-sm">{{exp.state_name}}</td>
                                    <td>{{exp.district_name}}</td>
                                    <td>{{exp.area}}</td>
                                    <td>{{exp.lodging_amount}}</td>
                                    <td>{{exp.daily_allowance}}</td>
                                    <td class="hidden-xs">{{exp.local_conveyance}}</td>
                                    <td class="hidden-xs hidden-sm" ng-if="expenses.edit || expenses.delete">
                                        <a href="" class="ml3" tooltip="Advance Edit" tooltip-placement="bottom" ng-click="setAlias(exp.service_allowance_alias);servicesEditOpen();" ng-if="expenses.edit">
                                            <span class="fa fa-spl-edit"></span>
                                        </a>
                                        <a href="javascript:void(0)" class="ml3" tooltip="Delete" tooltip-placement="bottom" 
                                        ng-click="settingsDeleteOpen('serallowances', exp);" ng-if="expenses.delete">
                                            <span class="fa fa-delete"></span>
                                        </a>
                                    </td>
                                </tr>
                           </tbody>
                            <tfoot ng-if="expenses.serallowancesDetails.length=='0'"><tr><td>{{expenses.ErrorMessage}}</td></tr></tfoot>
                        </table>
                    </div>
                    <!-- #end data table -->	
                     <div class="panel-footer clearfix" ng-if="expenses.serallowancesDetails.length!='0'">
                        <div class="col-md-4">
                        <p class="left small" style="margin:0px !important;">Showing {{expenses.fromRecords}} to {{expenses.toRecords}} of {{expenses.totalRecords}} entries</p>
                        </div>
                        <div class="col-md-4">
                        <div class="small text-bold right ml15">
                        <span class="control-label">Page No. </span>
                        <select class="form-control page-count"  name="page_no" ng-model="selectt.id" data-ng-change="expsorting()">
                            <option value="" style="display:none">1</option>
                            <option ng-repeat="pagess in expenses.pages" ng-show="$index > 0" value="{{pagess}}">{{pagess}}</option>
                        </select> 
                        </div>
                        </div>
                        <div class="col-md-4">
                        <div class="small text-bold right ml15">
                        <span class="control-label">Count per page</span>
                        <select class="form-control page-count" name="perpagecount" ng-model="selectt.ids" data-ng-change="expsorting()">
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
    <div><button type="button" class="btn btn-info ion ion-plus compose-btn" tooltip="Addnew" tooltip-placement="top" ng-click="servicesOpen()" ng-if="expenses.add" md-ink-ripple></button></div>
<div id="ticketviesw">
	<div class="site-settings ticketviesw clearfix  col-xs-6 floating-sidebar" ng-class="{'open': services_open}">
        <div class="sidebar-wrap text-uppercase">
                <div class="group clearfix head tkt-heading">
                    <div class="left">
                    <span class="ion ion-close-round mr10 tktviewClose" ng-click="removeServices()"></span>
                        <span><strong>view Service Allowances</strong></span>
                    </div>
                    <div class="right">
                        <div class="btn-group btn-group-sm">
                            <a href="services/expense_tracker/allowances_services_print.php?alias={{expenseViews.service_allowance_alias}}" target="_blank" tooltip="Print" class="ml10"  tooltip-placement="bottom"><span class="ion ion-android-print"></span></a>
                            <a href="services/expense_tracker/allowances_services_download.php?alias={{expenseViews.service_allowance_alias}}" target="_blank" tooltip="Download" class="ml10" tooltip-placement="bottom"><span class="ion ion-android-download"></span></a>
                        </div>
                    </div>
                </div>
            	<div class="panel-body clearfix freez-panel">
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Zone</h6>
                          <span class="fnt-size-11">{{expenseViews.zone_name}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>State</h6>
                          <span class="fnt-size-11">{{expenseViews.state_name}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>District</h6>
                          <span class="fnt-size-11">{{expenseViews.district_name}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Area</h6>
                          <span class="fnt-size-11">{{expenseViews.area}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Lodging Amount</h6>
                          <span class="fnt-size-11">{{expenseViews.lodging_amount}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Daily Allowance</h6>
                          <span class="fnt-size-11">{{expenseViews.daily_allowance}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Local Conveyance</h6>
                          <span class="fnt-size-11">{{expenseViews.local_conveyance}}</span>
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
    