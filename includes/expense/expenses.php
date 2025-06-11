<style>
.bs-callout { padding: 5px 10px; margin: 10px 25px; border: 1px solid #eee;  border-left-width: 5px;border-radius: 3px; border-left-color: #428bca;}
.bs-callout h4 { margin-top: 0; margin-bottom: 5px; color: #428bca;font-size: 14px;line-height: 1.5;}
h4 span {font-size: 14px; color: #262626;}
.service_lc{border:1px solid #e4e4e4;}
.service_lc .panel-heading{padding:7px 22px !important; margin:0px !important; background-color:#428bca; color:#fff;}
.tkt-panel{padding:0px !important;}
.tbl_bdr{border:1px solid #e4e4e4; border-collapse: separate;}
</style>
<div class="page page-ui-buttons" ng-controller="EnersysExpenseCtrl">
<div ng-controller="expenseSingCtrl">
   		<div class="panel panel-lined table-responsive panel-hovered mb10">
            <ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
                <li><a href="#/dashboard" class="padding-10">Home</a></li>
                <li><a href="" class="padding-10">Expence Traker</a></li>
                <li><a href="" class="padding-10">Expenses</a></li>
            </ol>
            <ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;" >
                <li><a href="" ng-click="expensesExport()" class="padding-10 export-btn">Export</a></li>
                <li ng-if="expenses.scm_import"><a href="" ng-click="expensesImport()" class="padding-10">Import</a></li>
                <li ng-if="expenses.finance_import"><a href="" ng-click="financeExpensesImport()" class="padding-10">Import</a></li>
            </ol>
       </div>
        <div class="row">
            <!-- Data Table -->
            <div class="col-md-12 table-height">
                <div class="panel panel-lined table-responsive panel-hovered">
                <div class="panel panel-default">
                    <form class="form-horizontal forms_exp" url="services/expense_tracker/user_expences_mul_view" name="expenseForm" method="post" novalidate>
							<table class="table table-condensed">
								<thead>
									<tr>
                                        <th>
                                            <a class="tktid">Bill Number&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" name="sortbill_number" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="expsorting()">
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="expsorting()"></span>
                                        </th>
                                         <th ng-show="expenses.display_name == 'yes'" class="hidden-xs hidden-sm">
                                            <a class="tktid">Request By&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" name="req_by" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="expsorting()">
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="expsorting()"></span>
                                        </th>
                                        <th class="hidden-xs hidden-sm" ng-controller="DatepickerDemoCtrl">
                                            <a class="tktid"> Requested Date&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" name="requestDate" class="form-control datepicker border-bottom droptxt1 hidden" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-model="requestDate" is-open="opened" min-date="minDate" max-date="'2025-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="expsorting();open($event)"/> 
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="expsorting()"></span>
                                        </th>
                                         <th>
                                            <a class="tktid">Tour Expenses&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" name="totalExpense" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" ng-model="searchKeywords.totaltourexpenses" data-ng-keyup="expsorting()">
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="expsorting()"></span>
                                        </th>
                                         <th>
                                            <a class="tktid">Refund&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" name="refund_amount" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" ng-model="searchKeywords.ref_amt" data-ng-keyup="expsorting()">
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="expsorting()"></span>
                                        </th>
                                        <th class="hidden-xs hidden-sm">Outstanding Balance</th>
                                        <th class="hidden-xs hidden-sm">
                                            <a class="tktid">Places Of Visit&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" name="placeofVisit" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" ng-model="searchKeywords.placesofvisit" data-ng-keyup="expsorting()">
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="expsorting()"></span>
                                        </th>
                                         <th ng-controller="appDropCntrl" ng-if="expenses.eadmin != 'eadmin' && expenses.eadmin != 'admin'">
                                             <select name="reqStat" placeholder="Approval Status" class="SlectBox form-control" ng-model="selectt.id" data-ng-change="expsorting()">
                                                <option value="" style="display:none">Approval Status</option>
                                                <option ng-repeat="aplevels in firstDrop" value="{{aplevels.alias}}">{{aplevels.name}}</option>
                                                <option ng-if="firstDrop.length==0">No Records</option>
                                            </select>
                                        </th>
                                        <th ng-controller="admnappDropCntrl" ng-if="expenses.eadmin == 'eadmin' || expenses.eadmin == 'admin'">
                                             <select name="reqStat" placeholder="Approval Status" class="SlectBox form-control" ng-model="selectt.id" data-ng-change="expsorting()">
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
                                        <tr class="tktBackground" ng-repeat="exp in expenses.user_expences" >
                                            <td ng-click="expensesSingleOpen(); singExp(exp.expenses_alias)"><span tooltip-placement="top" tooltip="Click to know details of {{exp.bill_number}}">{{exp.bill_number}}</span></td>
                                            <td ng-show="exp.display_name == 'yes'" class="hidden-xs hidden-sm"><span tooltip-placement="top" tooltip="{{exp.emp_name}}">{{exp.emp_name_half}}</span></td>
                                            <td class="hidden-xs hidden-sm">{{exp.requested_date}}</td>
                                            <td>{{exp.total_tour_expenses}}</td>
                                            <td>{{exp.refund_amount}}</td>
                                            <td class="hidden-xs hidden-sm">{{exp.outbal}}</td>
                                            <td class="hidden-xs hidden-sm"><span tooltip-placement="top" tooltip="{{exp.places_of_visit}}">{{exp.places_of_visit_half}}</span></td>
                                            <td>{{exp.approval_level}}</td>
                                            <td class="hidden-xs hidden-sm" ng-if="expenses.splEdit || expenses.delete || expenses.mapping">
                                                <a href="javascript:void(0)" class="ml3" tooltip="Status Change" tooltip-placement="bottom" ng-click="expensesMappingOpen(exp);" ng-if="expenses.mapping">
                                                    <span class="fa fa-copy"></span>
                                                </a>
                                                <a href="javascript:void(0)" class="ml3" tooltip="Advance Edit" tooltip-placement="bottom" ng-click="setAlias(exp.expenses_alias);advEditExpOpen();" ng-if="expenses.splEdit">
                                                    <span class="fa fa-spl-edit"></span>
                                                </a>
                                                <a href="javascript:void(0)" class="ml3" tooltip="Delete" tooltip-placement="bottom" ng-click="expensesDeleteOpen(exp);" ng-if="expenses.delete">
                                                    <span class="fa fa-delete"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
									<tfoot ng-if="expenses.user_expences.length == '0'"><tr><td>No Records</td></tr></tfoot>
								</table>
							</div>
							<div class="panel-footer clearfix" ng-if="expenses.user_expences.length!='0'">
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
                </div>
            </div>
        </div>
        <!-- #end row -->
    </div>  
    <div ng-if="expenses.open_page == 'serviceExpense' && expenses.add"><button type="button" class="btn btn-info ion ion-plus compose-btn" tooltip="Addnew" tooltip-placement="top" ng-click="serSubmitExpOpen(); serReq(expenses.employee_alias);" md-ink-ripple></button></div>
    <div ng-if="expenses.open_page == 'bookExpense' && expenses.add"><button type="button" class="btn btn-info ion ion-plus compose-btn" tooltip="Addnew" tooltip-placement="top" ng-click="othSubmitExpOpen(); serReq(expenses.employee_alias);" md-ink-ripple></button></div>         
	</form>
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
//$('.fileUpload').on('change',function() { alert();});
});
</script>
    
    