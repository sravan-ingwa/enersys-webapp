<style>
	.tab-content{background:none !important; box-shadow:none !important; padding:0px !important;}
	.tabs-linearrow{border:none !important;}
	.loader { position: absolute; top: 30%; left: 40%; z-index: 10000;}
</style>
<div class="page page-ui-extras" ng-controller="ModalDemoCtrl">
	<div>
	<!--<div ng-include="'includes/loading.php'"></div>-->
    <div ng-controller="mul_view_form">
		<div class="panel panel-lined table-responsive panel-hovered mb10" style="" >
			<ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
                <li><a href="#/dashboard" class="padding-10">Home</a></li>
                <li><a href="" class="padding-10">Spot Tickets</a></li>
			</ol>
			<!--<ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;" ng-if="datas.export">
				<li><a href="" ng-click="ticketsExportOpen()" class="padding-10 export-btn">Export</a></li>
			</ol>-->
		</div>
		<div class="row">
			<div class="col-md-12 table-height">
				<div class="panel panel-lined table-responsive panel-hovered" style="overflow-x:hidden">
					<div class="panel panel-default">
						<form class="form-horizontal forms_ec" url="services/tickets/spotticket_mul_view" name="userForm" method="post" novalidate>
							<table class="table table-condensed">
								<thead>
									<tr>
                                        <th width="150px">
                                            <a class="tktid">Ticket ID&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" class="droptxt1 hidden" name="ticketId" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()" />
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                                        </th>
                                        <th class="hidden-xs hidden-sm" ng-controller="DatepickerDemoCtrl">
                                            <a class="tktid">Login Dt.&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" class="form-control datepicker border-bottom droptxt1 hidden" name="loginDate" placeholder="Select date.." ng-model="logindate" datepicker-popup="{{format}}" ng-click="open($event)" is-open="opened" min-date="'01-01-2000'" max-date="'22-06-2025'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="listSorting();open($event)"/>
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                                        </th>
                                        <th class="hidden-xs hidden-sm">
                                            <a class="tktid">Activity&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" class="droptxt1 hidden form-control" name="activityAlias" placeholder="Type keyword" data-ng-keyup="listSorting()"  />
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                                        </th>
                                        <th class="hidden-xs hidden-sm" ng-controller="segmentdropCntrl">	
                                            <select name="segmentAlias" placeholder="Segment" class="SlectBox form-control" ng-model="segmentAlias" data-ng-change="listSorting()">
                                                <option value="" style="display:none">Segment</option>
                                                <option ng-repeat="selectlist in firstDrop" value="{{selectlist.alias}}">{{selectlist.name}}</option>
                                                <option ng-if="firstDrop.length==0">No Records</option>
                                            </select>
                                        </th>
                                        <th class="hidden-xs" width="140px">
                                            <a class="tktid">Site Name&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" class="droptxt1 hidden form-control" name="siteId" placeholder="Type keyword" data-ng-keyup="listSorting()"  />
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                                        </th>
                                        <th class="hidden-xs hidden-sm">
                                            <a class="tktid">Customer&nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" class="droptxt1 hidden form-control" name="customerName" placeholder="Type keyword" data-ng-keyup="listSorting()"  />
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                                        </th>
                                        <th width="200px">
                                            <select name="flag" placeholder="Levels" class="SlectBox form-control" ng-model="flag" data-ng-change="listSorting()">
                                                <option value="" style="display:none">Levels</option>
                                                <option value="1">SPOT TICKETS</option>
                                                <option value="2">OFFLINE SPOT TICKETS</option>
                                            </select>
                                        </th>
										<th>Report</th>
										<th ng-if="datas.delete">
											Actions
										</th>
									</tr>
								</thead>
							</table>
							<div class="div-table-content">
								<table class="table table-condensed table-hover">
									<tbody>
                                        <tr class="tktBackground" ng-repeat="data in datas.ticketDetails" >
                                            <td width="150px" ng-click="datas.edit ? spotticketseditOpen(data.ticket_alias) : ''" class="tktClick"><span tooltip-placement="top" tooltip="Click to Edit of {{data.ticket_id}}">{{data.ticket_id | uppercase}}</span></td>
                                            <td class="hidden-xs hidden-sm">{{data.login_date}}</td>
                                            <td class="hidden-xs hidden-sm"><span tooltip-placement="top" tooltip="{{data.activity}}">{{data.activity!='' ? (data.activity | limitTo:12) : '-'}}{{data.activity.length>12 ? '...':''}}</span></td>
                                            <td class="hidden-xs hidden-sm"><span tooltip-placement="top" tooltip="{{data.segment_name}}">{{data.segment_code!='' ? data.segment_code : '-'}}</span></td>
                                            <td width="140px" class="hidden-xs"><span tooltip-placement="top" tooltip="{{data.site_name}}">{{data.site_name!=null ? (data.site_name | limitTo:12) : '-'}}{{data.site_name.length>12 ? '...':''}}</span></td>
                                            <td class="hidden-xs hidden-sm"><span tooltip-placement="top" tooltip="{{data.customer_code}}">{{data.customer_code!=null ? (data.customer_code | limitTo:12) : '-'}}{{data.customer_code.length>12 ? '...':''}}</span></td>
                                            
											<td width="200px"><span tooltip-placement="top" tooltip="{{data.flagname}}"><i class="fa fa-signal" style="color:{{data.flagcolor}} !important;"></i>&nbsp;{{data.flagname}}</span></td>
											<td><a href="{{data.efsr_link}}" target="_blank" tooltip-placement="bottom" tooltip="Attended Date {{data.efsr_date}}">e-FSR</a></td>
											<td ng-if="datas.delete">
                                      <a href="javascript:void(0)" class="ml10" tooltip="" 
                                        tooltip-placement="bottom" ng-click="spotTicketDeleteOpen(data);" >
                                        <span class="fa fa-delete"></span>
                                      </a>
											</td>
                                        </tr>
									</tbody>
									<tfoot ng-if="datas.ticketDetails.length=='0'"><tr><td>No Records</td></tr></tfoot>
								</table>
							</div>
							<div class="panel-footer clearfix" ng-if="datas.ticketDetails.length!='0'">
                                <div class="col-md-4">
                                   <p class="left small" style="margin:0px !important;">Showing {{datas.fromRecords}} to {{datas.toRecords}} of {{datas.totalRecords}} entries</p>
                                </div>
								<div class="col-md-4">
									<div class="small text-bold right ml15">
										<span class="control-label">Page No. </span>
                                        <select class="form-control page-count"  name="page_no" ng-model="page_no" data-ng-change="listSorting()">
                                            <option value="" style="display:none">1</option>
                                            <option ng-repeat="pagess in datas.pages" ng-show="$index > 0" value="{{pagess}}">{{pagess}}</option>
                                        </select> 
									</div>
								</div>
								<div class="col-md-4">
                                    <div class="small text-bold right ml15">
                                        <span class="control-label">Count per page</span>
                                        <select class="form-control page-count" name="perpagecount" ng-model="perpagecount" data-ng-change="listSorting()">
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
		/*setInterval(function(){$('.pageSlect').SumoSelect();
		$('.panel-footer').find('.SumoSelect').addClass('pageAlign');},0);*/
		$('.popMail').click(function(){ $('.sendMail').toggle(); $("#configform")[0].reset();});
		$('.btnCan').click(function(){ $('.sendMail').hide();});
		$(document).click(function(e){e.stopPropagation();
			if (!$(e.target).hasClass("sendMail") && !$(e.target).hasClass("sendPop") && !$(e.target).hasClass("fa-send")){$(".sendMail").hide();}
		});
	});
</script>