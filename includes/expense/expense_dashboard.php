<style>
.Exp_dashboard {padding: 5px 10px;margin: 10px 30px;border: 1px solid #eee;border-left-width: 5px;border-radius: 3px;border-left-color: #428bca;}
.Exp_dashboard h4{color:#428bca; margin-top: 0;margin-bottom: 5px; font-size:15px;}
.Exp_dashboard p{position: relative;text-indent: 10px; font-size:13px;}
.panel-dashboard{border:1px solid #428bca;}
.panel-heading {color: #ffffff;background-color: #428bca !important;border-color: #428bca !important;}
.SumoSelect > .CaptionCont > label{right:-20px;}
.empDash{margin:0px !important; color:#fff !important; padding:9px !important;}
</style>
<div class="page page-ui-buttons" ng-controller="EnersysExpenseCtrl">
   		<div class="panel panel-lined table-responsive panel-hovered mb10">
            <ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
                <li><a href="#/dashboard" class="padding-10">Home</a></li>
                <li><a href="" class="padding-10">Expence Traker</a></li>
                <li><a href="" class="padding-10">Dashboard</a></li>
            </ol>
            <ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;" ng-if="expenses.chapp == '0'">
                <li><a href="services/expense_tracker/dashboard_download.php?alias={{expenses.employee_alias}}" target="_blank" class="padding-10 export-btn">Download</a></li>
            </ol>
       </div>
        <div class="row">
            <!-- Data Table -->
            <div class="col-md-12 table-height">
                <div class="panel panel-lined table-responsive panel-hovered">
                <div class="panel panel-default">
                    <form class="form-horizontal forms_exp" url="services/expense_tracker/exp_dashboard" name="serviewForm" method="post" novalidate>
                    		<div  ng-show="expenses.chapp > '0' || expenses.dashboard.length=='0' && expenses.chapp != '0'">
							<table class="table table-condensed">
								<thead>
									<tr>
                                        <th>
                                            <a class="tktid">Employee ID&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" class="droptxt1 hidden" name="emp_id" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="expsorting()" />
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="expsorting()"></span>
                                        </th>
                                        <th ng-controller="DatepickerDemoCtrl">
                                            <a class="tktid">Employee Name&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" class="droptxt1 hidden" name="emp_name" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="expsorting()" />
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="expsorting()"></span>
                                        </th>
                                         <th ng-controller="departmentdropCntrl" class="hidden-xs">
                                            <select name="dep" placeholder="Department" class="SlectBox form-control" ng-model="selectt.id" data-ng-change="expsorting()">
                                                <option value="" style="display:none">Department</option>
                                                <option ng-repeat="department in firstDrop" value="{{department.alias}}">{{department.name}}</option>
                                                <option ng-if="firstDrop.length==0">No Records</option>
                                            </select>			
                                        </th>
                                        <th class="hidden-xs hidden-sm">Total Advances</th>
                                        <th class="hidden-xs hidden-sm">Total Expenses</th>
                                        <th class="hidden-xs hidden-sm">Total Reimbursement</th>
                                        <th class="hidden-xs hidden-sm">Total Refund</th>
                                        <th>Available Balance</th>
									</tr>
								</thead>
							</table>
							<div class="div-table-content">
								<table class="table table-condensed table-hover">
									<tbody>
                                        <tr class="tktBackground" ng-repeat="exp in expenses.dashboard" >
                                            <td ng-click="exp_dashboardView(); expDash(exp.employee_alias)" class="tktClick"><span tooltip-placement="top" tooltip="Click to know details of {{exp.employee_id}}">{{exp.employee_id}}</span></td>
                                            <td><span tooltip-placement="top" tooltip="{{exp.name}}">{{exp.name_half}}</span></td>
                                            <td class="hidden-xs">{{exp.department}}</td>
                                            <td class="hidden-xs hidden-sm">{{exp.total_advances}}</td>
                                            <td class="hidden-xs hidden-sm">{{exp.total_expenses}}</td>
                                            <td class="hidden-xs hidden-sm">{{exp.reimbursement_amount}}</td>
                                            <td class="hidden-xs hidden-sm">{{exp.refund_amount}}</td>
                                            <td>{{exp.available_balance}}</td>
                                        </tr>
									</tbody>
									<tfoot ng-if="expenses.dashboard.length=='0'"><tr><td>No Records</td></tr></tfoot>
								</table>
							</div>
							<div class="panel-footer clearfix" ng-if="expenses.dashboard.length!='0'">
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
                            <div ng-show="expenses.chapp == '0'">
                            <div class="panel panel-info panel-hovered panel-dashboard">
                                <div class="panel-heading empDash">Dashboard</div>
                                <div class="panel-body">
                                    <div class="row">
                                      <div class="col-md-10 col-md-offset-1">
                                        <div class="col-md-5 Exp_dashboard"><h4>Employee Id</h4><p>{{expenses.employee_id}}</p></div>
                                        <div class="col-md-5 Exp_dashboard"><h4>Employee Name</h4><p>{{expenses.name}}</p></div>
                                        <div class="col-md-5 Exp_dashboard"><h4>Department</h4><p>{{expenses.department}}</p></div>
                                        <div class="col-md-5 Exp_dashboard"><h4>Designation</h4><p>{{expenses.designation}}</p></div>
                                        <div class="col-md-5 Exp_dashboard"><h4>Grade</h4><p>{{expenses.grade}}</p></div>
                                        <div class="col-md-5 Exp_dashboard"><h4>Credit Limit</h4><p>{{expenses.credit_limit}}</p></div>
                                        <div class="col-md-5 Exp_dashboard"><h4>Total Advances</h4><p>{{expenses.total_advances}}</p></div>
                                        <div class="col-md-5 Exp_dashboard"><h4>Total Expenses</h4><p>{{expenses.total_expenses}}</p></div>
                                        <div class="col-md-5 Exp_dashboard"><h4>Total Reimbursement</h4><p>{{expenses.reimbursement_amount}}</p></div>
                                        <div class="col-md-5 Exp_dashboard"><h4>Total Refund</h4><p>{{expenses.refund_amount}}</p></div>
                                        <div class="col-md-5 Exp_dashboard"><h4>Total Outstanding Balance</h4><p>{{expenses.available_balance}}</p></div>
                                      </div>
                                   </div>
                              </div>
                            </div>
                            </div>
						</form>
                </div>
            </div>
        </div>
        <!-- #end row -->
    </div>
       
  <!------------- Dashboard view-2------------>
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