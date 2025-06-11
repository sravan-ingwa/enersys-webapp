<style>
.selectdrop{overflow-y:scroll;}
.form-group {margin-bottom:0px !important;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.upload-file{border-bottom: 1px solid rgba(0,0,0,0.12);}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:-38px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
.bs-callout { padding: 5px 10px; margin: 10px 30px; border: 1px solid #eee;  border-left-width: 5px;border-radius: 3px; border-left-color: #428bca;}
.bs-callout h4 { margin-top: 0; margin-bottom: 5px; color: #428bca;font-size: 16px;line-height: 1.5;}
h4 span {font-size: 14px; color: #262626;}
.panel{border:1px solid #e4e4e4;}
</style>
<div ng-controller="EnersysExpenseCtrl">
<div class="modal-style">	
	<div class="modal-header clearfix">
		<h4 class="modal-title">Details Of: {{expenseViews.name}}</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body">
                	<div class="row">
                        <div class="col-md-5 bs-callout">
                            <div>
                                <h4>Employee ID:  <span>{{expenseViews.employee_id}}</span></h4>
                            </div>
                            <div>
                                <h4>Employee Name: <span>{{expenseViews.name}}</span></h4>
                            </div>
                        </div>
                        <div class="col-md-5 bs-callout">
                            <div>
                                <h4>Department:  <span>{{expenseViews.department}}</span></h4>
                            </div>
                            <div>
                                <h4>Designation:  <span>{{expenseViews.designation}}</span></h4>
                            </div>
                            <div>
                                <h4>Grade:  <span>{{expenseViews.grade}}</span></h4>
                            </div>
                      </div> 
                    </div>
                    <div class="panel panel-default">
                    <form class="form-horizontal forms_exp1" url="services/expense_tracker/dashboard_empview" name="dashviewForm" method="post" novalidate>
                    <input type="hidden" value="{{expenseViews.employee_alias}}" name="alias" />
							<table class="table table-condensed">
								<thead>
									<tr>
                                    	<th class="hidden-xs hidden-sm">
                                            <select name="reqtype" placeholder="Type of Request" class="SlectBox form-control" ng-model="selectt.id" data-ng-change="expdashsorting()">
                                                <option value="" style="display:none">Request Type</option>
                                                	<option value="0">Advance</option>
                                                    <option value="1">Expense</option>
                                            </select>			
                                        </th>
                                        <th>
                                            <a class="tktid">Req ID/ Bill No&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" class="droptxt1 hidden" name="requestID" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="expdashsorting(expenseViews.employee_alias)" />
                                            <span class="ion ion-ios-close-outline inptClose hidden"></span>
                                        </th>
                                        <th ng-controller="DatepickerDemoCtrl">
                                            <a class="tktid">Req. Date&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" class="form-control datepicker border-bottom droptxt1 hidden" name="requestDate" placeholder="Select date.." ng-model="reqdate" datepicker-popup="{{format}}" ng-click="open($event)" is-open="opened" min-date="'01-01-2000'" max-date="'22-06-2025'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="expdashsorting();open($event)"/>
                                            <span class="ion ion-ios-close-outline inptClose hidden"></span>
                                        </th>
                                         
                                        <th>
                                            <a class="tktid">Req. Amount&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" class="droptxt1 hidden form-control" name="requestamt" placeholder="Type keyword" data-ng-keyup="expdashsorting()"  />
                                            <span class="ion ion-ios-close-outline inptClose hidden"></span>
                                        </th>
                                        <th>Avl. Amount
                                            <!--<a class="tktid">Avl. Amount&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" class="droptxt1 hidden form-control" name="siteId" placeholder="Type keyword" data-ng-keyup="expdashsorting()"  />
                                            <span class="ion ion-ios-close-outline inptClose hidden"></span>-->
                                        </th>
                                        <th class="hidden-xs hidden-sm" ng-controller="appDropCntrl">
                                            <select name="reqStat" placeholder="Approval Status" class="SlectBox form-control" ng-model="selectt.id" data-ng-change="expdashsorting()">
                                                <option value="" style="display:none">Approval Status</option>
                                                 <option ng-repeat="aplevels in firstDrop" value="{{aplevels.alias}}">{{aplevels.name}}</option>
                                                <option ng-if="firstDrop.length==0">No Records</option>
                                            </select>			
                                        </th>
                                       
									</tr>
								</thead>
							</table>
							<div class="div-table-content">
								<table class="table table-condensed table-hover">
									<tbody>
                                       	<tr class="tktBackground" ng-repeat="exp in expenseViews.dashempview">
                                            <td class="tktClick">
                                            	<a href="services/expense_tracker/{{exp.download_page}}.php?alias={{exp.alias}}" target="_blank" tooltip="{{exp.requestId}}" class="ml10" tooltip-placement="bottom">{{exp.requestType}}</a>
                                            </td>
                                            <td>{{exp.requestId}}</td>
                                            <td>{{exp.rd}}</td>
                                            <td>{{exp.amt}}</td>
                                            <td>{{exp.tamt}}</td>
                                            <td>{{exp.explevel}}</td>
                                        </tr>
									</tbody>
									<tfoot ng-if="expenseViews.dashempview.length=='0'"><tr><td>No Records</td></tr></tfoot>
								</table>
							</div>
						</form>
                </div>
	</div>
</div>
</div>
<script>
$(document).ready(function(){
$('.tktid').click(function(){
var thw=($(this).parent('th').width());
$(this).parent('th').width(thw);
$('.droptxt1').width((thw));
$('.droptxt1, .inptClose').addClass('hidden');
$('.tktid').removeClass('hidden');
$(this).siblings('.droptxt1, .inptClose').removeClass('hidden');
$(this).siblings('.droptxt1').focus();
if(!$(this).hasClass('testSelAll2')){$(this).addClass('hidden');}

}); 
$('.testSelAll2').click(function(){
$('.droptxt1, .inptClose').addClass('hidden');
$('.tktid').removeClass('hidden');
});
$('.inptClose').click(function(){
$(this).addClass('hidden');
$(this).siblings('.tktid').removeClass('hidden');
$(this).siblings('.droptxt1').addClass('hidden');
});
$(document).click(function(e){
if (!$(e.target).hasClass("tktid") && $(".tktid").hasClass("hidden") && !$(e.target).hasClass("droptxt1")){
	$(".tktid").removeClass('hidden');
	$(".droptxt1").addClass('hidden');
	$(".inptClose").addClass('hidden');
	}
});

/*---multiple-select dropdown-----*/
setInterval(function(){$('.testSelAll2').SumoSelect({selectAll: true});
$('.forms_add').find('.SumoSelect').addClass('singleSelect');},0);
});
</script>