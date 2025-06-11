<style>.SumoSelect > .CaptionCont > label{right:-20px;}
.bs-callout { padding: 5px 10px; margin: 10px 0px; border: 1px solid #eee;  border-left-width: 5px;border-radius: 3px; border-left-color: #428bca;}
.bs-callout h4 { margin-top: 0; margin-bottom: 5px; color: #428bca;font-size: 14px;line-height: 1.5;}
.SumoSelect > .optWrapper.open{z-index:0;}
</style>
<div class="page page-ui-buttons" ng-controller="EnersysExpenseCtrl">
<div ng-controller="AdvancesCtrl">
   		<div class="panel panel-lined table-responsive panel-hovered mb10">
            <ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
                <li><a href="#/dashboard" class="padding-10">Home</a></li>
                <li><a href="" class="padding-10">Expence Tracker</a></li>
                <li><a href="" class="padding-10">Advances</a></li>
            </ol>
            <ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;" >
                <li><a href="" ng-click="advancesExport();" class="padding-10 export-btn">Export</a></li>
            </ol>
       </div>
        <div class="row">                           
            <!-- Data Table -->
            <div class="col-md-12 table-height">
                <div class="panel panel-lined table-responsive panel-hovered">
                <div class="panel panel-default">
                    <form class="form-horizontal forms_exp" url="services/expense_tracker/advances_mul_view" name="userForm" method="post" novalidate>
							<table class="table table-condensed">
								<thead>
									<tr>
                                        <th>
                                            <a class="tktid">Request ID&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" class="droptxt1 hidden" name="reqId" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="expsorting()" />
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="expsorting()"></span>
                                        </th>
                                         <th class="hidden-xs hidden-sm" ng-show="expenses.display_name == 'yes'">
                                            <a class="tktid">Request By&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" class="droptxt1 hidden" name="reqBy" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="expsorting()" />
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="expsorting()"></span>
                                        </th>
                                        <th ng-controller="DatepickerDemoCtrl"  class="hidden-xs hidden-sm">
                                            <a class="tktid">Requested Date&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" class="form-control datepicker border-bottom droptxt1 hidden" name="reqDate" placeholder="Select date.." ng-model="reqdate" datepicker-popup="{{format}}" ng-click="open($event)" is-open="opened" min-date="'01-01-2000'" max-date="'22-06-2025'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="expsorting();open($event)"/>
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="expsorting()"></span>
                                        </th>
                              			<th>
                                            <a class="tktid">Requested Amount&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" class="droptxt1 hidden form-control" name="reqAmt" placeholder="Type keyword" data-ng-keyup="expsorting()"  />
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="expsorting()"></span>
                                        </th>
                                        <th ng-controller="appDropCntrl" ng-if="expenses.eadmin != 'eadmin' && expenses.eadmin != 'admin'">
                                            <select name="appstatus" placeholder="Approval Status" class="SlectBox form-control" ng-model="selectt.id" data-ng-change="expsorting()">
                                                <option value="" style="display:none">Approval Status</option>
                                                <option ng-repeat="aplevels in firstDrop" value="{{aplevels.alias}}">{{aplevels.name}}</option>
                                                <option ng-if="firstDrop.length==0">No Records</option>
                                            </select>			
                                        </th>
                                        <th ng-controller="admnappDropCntrl" ng-if="expenses.eadmin == 'admin' || expenses.eadmin=='eadmin'">
                                       		<select name="appstatus" placeholder="Approval Status" class="SlectBox form-control" ng-model="selectt.id" data-ng-change="expsorting()">
                                                <option value="" style="display:none">Approval Status</option>
                                                <option ng-repeat="aplevels in firstDrop" value="{{aplevels.alias}}">{{aplevels.name}}</option>
                                                <option ng-if="firstDrop.length==0">No Records</option>
                                            </select>
                                          </th>
                                        <th class="hidden-xs hidden-sm" ng-if="expenses.splEdit || expenses.delete || expenses.mapping">Actions</th>
									</tr>
								</thead>
							</table>
							<div class="div-table-content">
								<table class="table table-condensed table-hover">
									<tbody>
                                        <tr class="tktBackground" ng-repeat="exp in expenses.advancesDetails">
                                            <td ng-click="advances(exp.advance_alias)" class="tktClick"><span tooltip-placement="top" tooltip="Click to know details of {{exp.request_id}}">{{exp.request_id}}</span></td>
                                            <td class="hidden-xs hidden-sm" ng-show="expenses.display_name == 'yes'"><span tooltip-placement="top" tooltip="{{exp.request_by}}">{{exp.request_by_half}}</span></td>
                                            <td class="hidden-xs hidden-sm">{{exp.requested_date}}</td>
                                            <td>{{exp.request_amount}}</td>
                                            <td>{{exp.approval_level_name}}</td>
                                            <td class="hidden-xs hidden-sm" ng-if="expenses.splEdit || expenses.delete || expenses.mapping">
                                                <a href="javascript:void(0)" class="ml3" tooltip="Status Change" tooltip-placement="bottom" ng-click="advanceMappingOpen(exp);" ng-if="expenses.mapping">
                                                    <span class="fa fa-copy"></span>
                                                </a>
                                                <a href="javascript:void(0)" class="ml3" tooltip="Advance Edit" tooltip-placement="bottom" ng-click="setAlias(exp.advance_alias);advancesAdvEditOpen();" ng-if="expenses.splEdit">
                                                    <span class="fa fa-spl-edit"></span>
                                                </a>
                                                <a href="javascript:void(0)" class="ml3" tooltip="Delete" tooltip-placement="bottom" ng-click="advanceDeleteOpen(exp);" ng-if="expenses.delete">
                                                    <span class="fa fa-delete"></span>
                                                </a>
                                            </td>
                                        </tr>
									</tbody>
									<tfoot ng-if="expenses.advancesDetails.length=='0'"><tr><td>No Records</td></tr></tfoot>
								</table>
							</div>
							<div class="panel-footer clearfix" ng-if="expenses.advancesDetails.length!='0'">
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
        <div ng-if="expenses.add">

	<button type="button" class="btn btn-info ion ion-plus compose-btn" tooltip="Addnew" tooltip-placement="top"  ng-click="advanceRequestOpen(); advReq(expenses.employee_alias);" md-ink-ripple></button></div>
	<div id="ticketviesw">
	<div class="site-settings ticketviesw clearfix  col-xs-6 floating-sidebar" ng-class="{'open': advances_open}">
        <div class="sidebar-wrap text-uppercase mt47">
                <div class="group clearfix head tkt-heading2">
                    <div class="left">
                    <span class="ion ion-close-round mr10 tktviewClose" ng-click="removeAdvances()"></span>
                        <span><strong>View Advances</strong></span>
                    </div>
                    <div class="right">
                        <div class="btn-group btn-group-sm">
                            <a href="" class="ml10" tooltip="{{expenseViews.hover_edit}}" tooltip-placement="bottom" ng-click="advanceseditOpen()"  ng-if="expenseViews.edit == 1"><span class="fa fa-edit"></span></a>
                            <a href="services/expense_tracker/advances_print.php?alias={{expenseViews.advance_alias}}" target="_blank" tooltip="Print" class="ml10" tooltip-placement="bottom"><span class="ion ion-android-print"></span></a>
                            <a href="services/expense_tracker/advances_download.php?alias={{expenseViews.advance_alias}}" target="_blank" tooltip="Download" class="ml10" tooltip-placement="bottom"><span class="ion ion-android-download"></span></a>
                        </div>
                    </div>
                </div>
            	<div class="panel-body clearfix freez-panel">
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Request Id</h6>
                          <span class="fnt-size-11">{{expenseViews.request_id}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Requested Date</h6>
                          <span class="fnt-size-11">{{expenseViews.requested_date}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Employee Id</h6>
                          <span class="fnt-size-11">{{expenseViews.employee_Id}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Employee Name</h6>
                          <span class="fnt-size-11">{{expenseViews.employee_Name}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Department</h6>
                          <span class="fnt-size-11">{{expenseViews.employee_dep}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Designation</h6>
                          <span class="fnt-size-11">{{expenseViews.employee_des}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Grade</h6>
                          <span class="fnt-size-11">{{expenseViews.grade}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Previous Advance not settled</h6>
                          <span class="fnt-size-11">{{expenseViews.prev_amount}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Request Amount</h6>
                          <span class="fnt-size-11">{{expenseViews.request_amount}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Avaliable Amount</h6>
                          <span class="fnt-size-11">{{expenseViews.avail_amount}}</span>
                        </div>
                         <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>UTR Number</h6>
                          <span class="fnt-size-11">{{expenseViews.utr_num}}</span>
                        </div>
                        <!--<div class="col-lg-4 col-md-4 col-sm-4" ng-if="expenseViews.approval_level == '0' && expenseViews.employee_dept!='3'">
                          <h6>Tour Planning Report</h6>
                           <span class="fnt-size-11" ng-if="expenseViews.report != ''"><a href="{{expenseViews.report}}"><span style="color:red;">Click</span></a></span>
                           <span class="fnt-size-11" ng-if="expenseViews.report == ''">-NA-</span>
                        </div>-->
                        
                        <div class="col-lg-4 col-md-4 col-sm-4" ng-if="expenseViews.show_report">
                          <h6>Tour Planning Report</h6>
                           <span class="fnt-size-11" ng-if="expenseViews.report != ''"><a href="{{expenseViews.report}}" target="_blank"><span style="color:red;">Click</span></a></span>
                           <span class="fnt-size-11" ng-if="expenseViews.report == ''">-NA-</span>
                        </div>
                        
                    </div>
                   <div class="row">
                        <div class="col-md-12 bs-callout">
                            <div class="col-md-6 form-group" ng-repeat="rem in expenseViews.remarks">
                                <h4>Remarks: <small>(By {{rem.remarked_by}}, On: {{rem.remarked_on}})</small></h4>
                                <p>{{rem.remarks_desc}}</p>
                            </div>
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