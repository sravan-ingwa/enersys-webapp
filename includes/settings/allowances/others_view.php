<style>.pd7{padding:7px;}
.table > thead > tr > th{border:1px solid #2a6498;}
.table-bordered{border-color:#2a6498;}
.SumoSelect > .CaptionCont > label{right:-20px;}
.panel-info > .panel-heading{background-color:#428bca;}
</style>
<div class="page page-ui-extras" ng-controller="EnersysExpenseCtrl">
<div ng-controller="OthersCtrl">
   <div class="panel panel-lined table-responsive panel-hovered mb10">
        <ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
            <li><a href="#/dashboard" class="padding-10">Home</a></li>
            <li><a href="#/settings" class="padding-10">Settings</a></li>
            <li><a href="" class="padding-10">Allowances Details</a></li>
        </ol>
        <ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;">
            <li><a href="exports/{{expenseViews.file_name}}.xlsx" ng-click="othexport()" class="padding-10 export-btn" ng-if="expenses.export">Export</a></li>
        </ol>
   </div>
		<!-- row -->
		<div class="row">
			<!-- Data Table -->
			<div class="col-md-12 table-height">
				<div class="panel panel-lined table-responsive panel-hovered">
                 <div class="panel panel-default">
            	 <form class="form-horizontal forms_exp" url="services/expense_tracker/othallowances_mul_view" name="serviewForm" method="post" novalidate>
                    <table class="table table-bordered" >
                        <thead>
                        <tr>
                        	<th>Grade</th> <th colspan="4">Lodging Allowances</th> <th colspan="4">Daily/Boarding Allowances</th> <th class="hidden-xs">Mode Of Travel</th> <th class="hidden-xs hidden-sm">Mode Of Local Conveyance</th> <th class="hidden-xs hidden-sm">Mobile Roaming</th> <th class="hidden-xs hidden-sm"></th>
                        </tr>
                        <tr class="cust">
                           <tr><th></th><th>A+</th><th>A</th><th>B</th><th>C</th><th>A+</th><th>A</th><th>B</th><th>C</th><th class="hidden-xs"></th><th  class="hidden-xs hidden-sm"></th><th class="hidden-xs hidden-sm">in Rs</th>
                            <th class="hidden-xs hidden-sm" ng-if="expenses.edit || expenses.delete">
                                Actions
                            </th>
                            </tr>
                         </tr>
                      </thead>
                    </table>

                    <div class="div-table-content">
                        <table class="table table-condensed table-hover">
                           <tbody>
                           		<tr class="tktBackground" ng-repeat="exp in expenses.othallowancesDetails">
                                    <td ng-click="others(exp.allowance_alias)"><span tooltip-placement="top" tooltip="Click to know details of {{exp.grade}}">{{exp.grade}}</span></td>
                                    <td>{{exp.lodging_allowances_a1}}</td>
                                    <td>{{exp.lodging_allowances_a}}</td>
                                    <td>{{exp.lodging_allowances_b}}</td>
                                    <td>{{exp.lodging_allowances_c}}</td>
                                    <td>{{exp.boarding_allowances_a1}}</td>
                                    <td>{{exp.boarding_allowances_a}}</td>
                                    <td>{{exp.boarding_allowances_b}}</td>
                                    <td>{{exp.boarding_allowances_c}}</td>
                                    <td class="hidden-xs">{{exp.mode_of_travel}}</td>
                                    <td class="hidden-xs hidden-sm">{{exp.mode_of_conveyance}}</td>
                                    <td class="hidden-xs hidden-sm">{{exp.mobile_roaming}}</td>
                                    <td class="hidden-xs hidden-sm" ng-if="expenses.edit || expenses.delete">
                                        <a href="" class="ml3" tooltip="Advance Edit" tooltip-placement="bottom" ng-click="setAlias(exp.allowance_alias);othersEditOpen();" ng-if="expenses.edit">
                                            <span class="fa fa-spl-edit"></span>
                                        </a>
                                        <a href="javascript:void(0)" class="ml3" tooltip="Delete" tooltip-placement="bottom" 
                                        ng-click="settingsDeleteOpen('othallowances', exp);" ng-if="expenses.delete">
                                            <span class="fa fa-delete"></span>
                                        </a>
                                    </td>
                                </tr>
                           </tbody>
                            <tfoot ng-if="expenses.othallowancesDetails.length=='0'"><tr><td>No Records</td></tr></tfoot>
                        </table>
                    </div>
                    <!-- #end data table -->	
                     <div class="panel-footer clearfix" ng-if="expenses.othallowancesDetails.length!='0'">
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
    <div><button type="button" class="btn btn-info ion ion-plus compose-btn" tooltip="Addnew" tooltip-placement="top" ng-click="othersOpen()" ng-if="expenses.add" md-ink-ripple></button></div>
<div id="ticketviesw">
	<div class="site-settings ticketviesw clearfix  col-xs-6 floating-sidebar" ng-class="{'open': others_open}">
        <div class="sidebar-wrap text-uppercase">
                <div class="group clearfix head tkt-heading">
                    <div class="left">
                    <span class="ion ion-close-round mr10 tktviewClose" ng-click="removeOthers()"></span>
                        <span><strong>view Allowances</strong></span>
                    </div>
                </div>
            	<div class="panel-body clearfix freez-panel">
                <div class="row tkt-panel">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <h6>Grade</h6>
                      <span class="fnt-size-11">{{expenseViews.grade}}</span>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <h6>Designations</h6>
                      <span class="fnt-size-11">{{expenseViews.designation}}</span>
                    </div>
                </div>
                <div class="row form-group mt10" >
                    <div class="col-sm-12">
                        <div class="panel mb20 panel-info panel-hovered">
                            <div class="panel-heading text-center pd7">OTHERS</div>
                            <div class="panel-body">
                                 <div class="col-sm-4">
                                    <label class="selectlabel">Mode Of Travel</label>
                                    <p>{{expenseViews.mode_of_travel}}</p>
                                </div>
                                <div class="col-sm-4">
                                    <label class="selectlabel">Mode of Local Conveyance</label>
                                    <p>{{expenseViews.mode_of_conveyance}}</p>
                                </div>
                                <div class="col-sm-4">
                                	<label class="selectlabel">Mobile Charges</label>
                                    <p>{{expenseViews.mobile_roaming}}</p>
                                 </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="panel mb20 panel-info panel-hovered">
                            <div class="panel-heading text-center pd7">LODGING ALLOWANCES</div>
                            <div class="panel-body">
                                <div class="col-sm-3">
                                    <label class="selectlabel">A+</label>
                                    <p>{{expenseViews.lodging_allowances_a1}}</p>
                                 </div>
                                 <div class="col-sm-3">
                                    <label class="selectlabel">A</label>
                                    <p>{{expenseViews.lodging_allowances_a}}</p>
                                 </div>
                                 <div class="col-sm-3">
                                    <label class="selectlabel">B</label>
                                    <p>{{expenseViews.lodging_allowances_b}}</p>
                                 </div>
                                 <div class="col-sm-3">
                                    <label class="selectlabel">C</label>
                                    <p>{{expenseViews.lodging_allowances_c}}</p>
                                 </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="panel mb20 panel-info panel-hovered">
                            <div class="panel-heading text-center pd7">DAILY/BOARDING ALLOWANCES</div>
                            <div class="panel-body">
                                <div class="col-sm-3">
                                    <label class="selectlabel">A+</label>
                                    <p>{{expenseViews.boarding_allowances_a1}}</p>
                                 </div>
                                 <div class="col-sm-3">
                                    <label class="selectlabel">A</label>
                                    <p>{{expenseViews.boarding_allowances_a}}</p>
                                 </div>
                                 <div class="col-sm-3">
                                    <label class="selectlabel">B</label>
                                    <p>{{expenseViews.boarding_allowances_b}}</p>
                                 </div>
                                 <div class="col-sm-3">
                                    <label class="selectlabel">C</label>
                                    <p>{{expenseViews.boarding_allowances_c}}</p>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>  
             </div>
           </div>
        </div>
       </div>
      </div>
   </div>
