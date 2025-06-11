<style>.table-height {min-height: 400px;}</style>

<div class="page page-ui-extras" ng-controller="ModalDemoCtrl">
	<div ng-controller="MaterialRequestCtrl">
		<div ng-controller="mul_view_form">
		<div class="panel panel-lined table-responsive panel-hovered mb10" >
			<ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
				<li><a href="#/dashboard" class="padding-10">Home</a></li>
				<li><a href="" class="padding-10">Material Request</a></li>
			</ol>
			<ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;" ng-if="datas.export">
				<!--<li><a href="exports/{{singleViews.file_name}}.xlsx" ng-click="materialrequestexport()" class="padding-10 export-btn">Export</a></li>-->
				<li><a href="" ng-click="materialRequestexportOpen()" class="padding-10 export-btn">Export</a></li>
			</ol>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-lined table-responsive panel-hovered">
					<div class="panel panel-default">
						<form class="form-horizontal forms_ec" url="services/inventory/material_request_multi" name="userForm" method="post" novalidate>
							<table class="table table-condensed" >
								<thead>
									<tr>
										<th> <a class="tktid">MRF Number&nbsp;<span class="arrow caret"></span></a>
											<input type="text" name="mrfnumber" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" ng-model="searchKeywords.mrfnumber" data-ng-keyup="listSorting()">
											<span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
										</th>
										<th class="hidden-xs hidden-sm" ng-controller="DatepickerDemoCtrl"> <a class="tktid">MRF date&nbsp;<span class="arrow caret"></span></a>
											<input type="text" name="mdate" class="form-control datepicker border-bottom droptxt1 hidden" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-model="dt" is-open="opened" min-date="minDate" max-date="'2025-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="listSorting();open($event)"/>
											</td>
											<span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
										</th>
										<th> <a class="tktid">SJO Number&nbsp;<span class="arrow caret"></span></a>
											<input type="text" name="sjonumber" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" ng-model="searchKeywords.sjonumber" data-ng-keyup="listSorting()">
											<span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
										</th>
										<th class="hidden-xs">
											<a class="tktid">Ticket ID&nbsp;<span class="arrow caret"></span></a>
											<input type="text" name="ticket_id" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" ng-model="searchKeywords.ticket_id" data-ng-keyup="listSorting()">
											<span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
										</th>
										<th class="hidden-xs hidden-sm">
											<a class="tktid">From W/H&nbsp;<span class="arrow caret"></span></a>
											<input type="text" name="fwh" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" ng-model="searchKeywords.fwh" data-ng-keyup="listSorting()">
											<span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
										</th>
										<th class="hidden-xs hidden-sm">
											<a class="tktid">To W/H&nbsp;<span class="arrow caret"></span></a>
											<input type="text" name="towh" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" ng-model="searchKeywords.twh" data-ng-keyup="listSorting()">
											<span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
										</th>
										<th class="hidden-xs hidden-sm">
											<a class="tktid">Material Value&nbsp;<span class="arrow caret"></span></a>
											<input type="text" name="mvalue" class="droptxt1 hidden" style="display:block; border:none; color:#000;" placeholder="Type keyword" ng-model="searchKeywords.materialvalue" data-ng-keyup="listSorting()">
											<span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
										</th>
										<th>
											<select name="level" placeholder="Level" class="SlectBox form-control" ng-controller="invenoryLevelsCtrl" ng-model="levelsing" data-ng-change="listSorting()">
												<option value="" style="display:none">Level</option>
												<option value="{{level.alias}}" ng-repeat="level in firstDrop">{{level.name}}</option>
											</select>
										</th>
										<th width="100px" class="hidden-xs hidden-sm">SJO File</th>
                            <th class="hidden-xs hidden-sm" ng-if="datas.advedit || datas.delete">
                                Actions
                            </th>
									</tr>
								</thead>
                                </table>
                                <div class="div-table-content table-height">
                                    <table class="table table-condensed table-hover">
                                        <tbody ng-if="datas.totalRecords!='0'">
                                            <tr class="tktBackground" ng-repeat="data in datas.requestDetails">
                                                <td ng-click="materialRequestview(data.mrf_alias)"><span tooltip-placement="top" tooltip="Click to know details of {{data.mrfnumber}}">{{data.mrfnumber}}</span></td>
                                                <td class="hidden-xs hidden-sm">{{data.dateofrequest}}</td>
                                                <td>{{data.sjonumber}}</td>
												<td class="hidden-xs"><span tooltip-placement="top" tooltip="{{data.ticketid}}">{{data.ticketid | limitTo:15}}{{data.ticketid.length>15 ? '...':''}}</span></td>
                                                <td class="hidden-xs hidden-sm">{{data.fromwh}}</td>
                                                <td class="hidden-xs hidden-sm">{{data.towh}}</td>
                                                <td class="hidden-xs hidden-sm">Rs. {{data.materialvalue | number : 2}}</td>
                                                <td><i class="fa fa-signal" style="color:{{data.levelcolor}} !important;" tooltip-placement="top" tooltip="{{data.levelname}}"></i>&nbsp;{{data.levelname}}</td>
												<td width="100px" class="hidden-xs hidden-sm"><a href="{{data.sjo_file}}" target="_blank" tooltip-placement="bottom" tooltip="Click here for SJO Scanned Copy">Click Here</a></td>
                                    <td class="hidden-xs hidden-sm" ng-if="datas.advedit || datas.delete">
									  <a href="javascript:void(0)" class="ml3"
									  tooltip="Advance Edit" tooltip-placement="bottom"
									  ng-click="setSettingsAlias(data.mrf_alias);materialRequestAdveditOpen();" ng-if="datas.advedit">
										<span class="fa fa-spl-edit"></span>
                                      </a>
									  <a href="javascript:void(0)" class="ml3"
									  tooltip="Delete" tooltip-placement="bottom"
									  ng-click="settingsDeleteOpen('material_req', data);" ng-if="datas.delete && (data.level != 9 && data.level != 8 && data.level != 3)">
										<span class="fa fa-delete"></span>
                                      </a>
									  <a href="javascript:void(0)" class="ml3"
									  tooltip="Delete" tooltip-placement="bottom"
									  ng-click="settingsDeleteOpen('material_req_stock', data);" ng-if="datas.delete && (data.level == 9 || data.level == 8 || data.level == 3)">
										<span class="fa fa-delete"></span>
                                      </a>
                                    </td>
                                            </tr>
                                        </tbody>
                                        <tfoot ng-if="datas.totalRecords=='0'">
                                            <tr>
                                                <td colspan="6">Oho! There are no records to Display</td>
                                            </tr>
                                        </tfoot>
                                  </table>
                            </div>
							<div class="panel-footer clearfix" ng-if="datas.totalRecords!='0'">
								<div class="col-md-4">
									<p class="left small" style="margin:0px !important;">Showing {{datas.fromRecords}} to {{datas.toRecords}} of {{datas.totalRecords}} entries</p>
								</div>
								<div class="col-md-4">
									<div class="small text-bold right ml15"> <span class="control-label">Page No. </span>
										<select class="form-control page-count"  name="page_no" ng-model="selectt.id" data-ng-change="listSorting()">
											<option value="" style="display:none">1</option>
											<option ng-repeat="pagess in datas.pages" value="{{pagess}}" ng-show="$index > 0">{{pagess}}</option>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="small text-bold right ml15"> <span class="control-label">Count per page</span>
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
			<div ng-if="datas.add">
				<button type="button" class="btn btn-info ion ion-plus compose-btn" tooltip="Addnew" tooltip-placement="top" ng-click="materialRequestOpen()" md-ink-ripple></button>
			</div>
		</div>
		</div>
		<div id="ticketviesw">
			<div class="site-settings ticketviesw clearfix  col-xs-6 floating-sidebar" ng-class="{'open': mRequest_open}">
				<div class="sidebar-wrap text-uppercase mt46">
					<div class="group clearfix head tkt-heading2">
						<div class="left"> <span class="ion ion-close-round mr10 tktviewClose" ng-click="removeMrequest()"></span> <span><strong>Material Request Details</strong></span> </div>
						<div class="right">
							<div class="btn-group btn-group-sm" ng-controller="ModalDemoCtrl"> 
								<a href="" class="ml10" tooltip-placement="bottom" tooltip="Edit" ng-click="materialRequestedit()" ng-if="((singleViews.admin_priv || singleViews.nhs_priv) && (singleViews.status =='1' || singleViews.status =='7' || singleViews.status =='10' || singleViews.status =='2' || singleViews.status =='9' || singleViews.status =='0')) || (singleViews.dynamic_check && (singleViews.status =='1' || singleViews.status =='7')) || (singleViews.ho_check && singleViews.status =='10') || (singleViews.ppc_nhs && (singleViews.status =='2' || singleViews.status =='9' || singleViews.status =='0'))"><span class="fa fa-edit"></span></a>
								<a href="services/inventory/material_request_print.php?alias={{singleViews.mrf_alias}}" target="_blank" tooltip="Print" class="ml10" tooltip-placement="bottom"><span class="ion ion-android-print"></span></a>
								<a href="services/inventory/material_request_download.php?alias={{singleViews.mrf_alias}}" target="_blank" tooltip="Download" class="ml10" tooltip-placement="bottom"><span class="ion ion-android-download"></span></a>
							</div>
						</div>
					</div>
					<div class="panel-body clearfix freez-panel">
						<div class="row tkt-panel">
							<div class="col-lg-4 col-md-4 col-sm-4">
								<h6>MRF Number</h6>
								<span class="fnt-size-11">{{singleViews.mrf_number}}</span> </div>
							<div class="col-lg-4 col-md-4 col-sm-4">
								<h6>Date Of Request</h6>
								<span class="fnt-size-11">{{singleViews.date_of_request}}</span> </div>
							<div class="col-lg-4 col-md-4 col-sm-4">
								<h6>From W/H</h6>
								<span class="fnt-size-11">{{singleViews.from_wh}}</span> </div>
						</div>
						<div class="row tkt-panel">
							<div class="col-lg-4 col-md-4 col-sm-4">
								<h6>To W/H</h6>
								<span class="fnt-size-11">{{singleViews.to_wh}}</span> </div>
							<div class="col-lg-4 col-md-4 col-sm-4">
								<h6>Material Value</h6>
								<span class="fnt-size-11">Rs. {{singleViews.material_value | number : 2}}</span> </div>
							<div class="col-lg-4 col-md-4 col-sm-4">
								<h6>Request Status</h6>
								<span class="fnt-size-11">{{singleViews.status_name}}</span> </div>
						</div>
						<div class="row tkt-panel">
							<div class="col-lg-4 col-md-4 col-sm-4">
								<h6>Ticket ID</h6>
								<span class="fnt-size-11">{{singleViews.ticket_id !='0' ? singleViews.ticket_id : 'NA'}}</span> </div>
							<div class="col-lg-4 col-md-4 col-sm-4">
								<h6>Site Name</h6>
								<span class="fnt-size-11">{{singleViews.site_name !='0' ? singleViews.site_name : 'NA'}}</span> </div>
							<div class="col-lg-4 col-md-4 col-sm-4">
								<h6>Customer</h6>
								<span class="fnt-size-11">{{singleViews.customer !='' ? singleViews.customer : 'NA'}}</span> </div>
						</div>
						<div class="row tkt-panel">
							<div class="col-lg-4 col-md-4 col-sm-4">
								<h6>SJO Number</h6>
								<span class="fnt-size-11">{{singleViews.sjo_number && singleViews.sjo_number !='0' && singleViews.sjo_number !='' ? singleViews.sjo_number : 'NA'}}</span> </div>
							<div class="col-lg-4 col-md-4 col-sm-4">
								<h6>SJO Date</h6>
								<span class="fnt-size-11">{{singleViews.sjo_date && singleViews.sjo_date !='0' && singleViews.sjo_date !='' ? singleViews.sjo_date : 'NA'}}</span> </div>
							<div class="col-lg-4 col-md-4 col-sm-4">
								<h6>SJO Scanned Copy</h6>
								<span class="fnt-size-11" ng-if="singleViews.sjo_file !=''"><a href="{{singleViews.sjo_file}}" target="_blank">Click Here</a></span>
								<span class="fnt-size-11" ng-if="singleViews.sjo_file ==''">NA</span> </div>
						</div>
						<div class="row tkt-panel">
							<div class="col-lg-4 col-md-4 col-sm-4">
								<h6>Sales Invoice Number</h6>
								<span class="fnt-size-11">{{singleViews.sinv && singleViews.sinv !='0' && singleViews.sinv !='' ? singleViews.sinv : 'NA'}}</span> </div>
							<div class="col-lg-4 col-md-4 col-sm-4">
								<h6>Sales Invoice Date</h6>
								<span class="fnt-size-11">{{singleViews.sind && singleViews.sind !='0' && singleViews.sind !='' ? singleViews.sind : 'NA'}}</span> </div>
							<div class="col-lg-4 col-md-4 col-sm-4">
								<h6>Sales PO Number</h6>
								<span class="fnt-size-11">{{singleViews.spon && singleViews.spon !='0' && singleViews.spon !='' ? singleViews.spon : 'NA'}}</span> </div>
						</div>
						<div class="row tkt-panel">
							<div class="col-lg-4 col-md-4 col-sm-4">
								<h6>Customer Name</h6>
								<span class="fnt-size-11">{{singleViews.ccname && singleViews.ccname !='0' && singleViews.ccname !='' ? singleViews.ccname : 'NA'}}</span> </div>
							<div class="col-lg-4 col-md-4 col-sm-4">
								<h6>Readiness Date</h6>
								<span class="fnt-size-11">{{singleViews.readiness_date && singleViews.readiness_date !='0' && singleViews.readiness_date !='' ? singleViews.readiness_date : 'NA'}}</span> </div>
							<div class="col-lg-4 col-md-4 col-sm-4">
								<h6>Road Permit</h6>
								<span class="fnt-size-11">{{singleViews.road_permit==1 ? 'REQUIRED':'NOT REQUIRED'}}</span> </div>
						</div>
						<div class="row tkt-panel">
								<div class="col-lg-4 col-md-4 col-sm-4">
								<h6>Customer Number</h6>
								<span class="fnt-size-11">{{singleViews.ccnumber && singleViews.ccnumber !='0' && singleViews.ccnumber !='' ? singleViews.ccnumber : 'NA'}}</span> </div>
							<div class="col-lg-4 col-md-4 col-sm-4">
								<h6>Customer Address</h6>
								<span class="fnt-size-11">{{singleViews.ccadds && singleViews.ccadds !='0' && singleViews.ccadds !='' ? singleViews.ccadds : 'NA'}}</span> </div>
								
							<div class="col-lg-4 col-md-4 col-sm-4">
								<h6>Transit Damaged</h6>
								<span class="fnt-size-11">{{singleViews.transit_damaged_val}}</span> </div>
						</div>
						<div class="row tkt-panel">
							<div class="col-lg-4 col-md-4 col-sm-4">
								<h6>Material Amount Range</h6>
								<span class="fnt-size-11">{{singleViews.amount_range_val}}</span> </div>
						</div>
						
						
						<div ng-if="singleViews.disp_length != 0" class="mt10">
							<h4 class="modal-title text-center">Logistic Dispatch Details</h4>
							<table class="table table-condensed">
								<thead>
									<tr>
										<th width="5%"><a class="tktid">Sr.No</a></th>
										<th width="20%" style="text-align:right"><a class="tktid">Dispatch Date</a></th>
										<th align="center"><a class="tktid">Transport Details</a></th>
										<th><a class="tktid">Docket Number</a></th>
										<th><a class="tktid">Remarks / Contact Details</a></th>
									</tr>
								</thead>
							</table>
						<div style="max-height:300px;overflow:auto; overflow-x:hidden;">
							<table class="table table-hover table-condensed">
								<tbody>
									<tr class="tktBackground" ng-repeat="(key,dis) in singleViews.disp">
										<td width="7%">{{key + 1}}</td>
										<td width="20%"><p tooltip-placement="top">{{dis.dispatch_date}}</p></td>
										<td class="hidden-xs hidden-sm">{{dis.transport}}</td>
										<td>{{dis.docket}}</td>
										<td>{{dis.out_rem}}</td>
									</tr>
								</tbody>
							</table>
						</div>
						</div>
						
						<div ng-if="singleViews.request_length != 0" class="mt10">
							<h4 class="modal-title text-center">Requested Items</h4>
							<table class="table table-condensed">
								<thead>
									<tr>
										<th width="5%"><a class="tktid">Sr.No</a></th>
										<th width="20%" style="text-align:right"><a class="tktid">Item Type</a></th>
										<th align="center"><a class="tktid">Description</a></th>
										<th><a class="tktid">Type</a></th>
										<th><a class="tktid">Req Qty</a></th>
										<th><a class="tktid">PPC Qty</a></th>
										<th><a class="tktid">Sent Qty</a></th>
									</tr>
								</thead>
							</table>
						<div style="max-height:300px;overflow:auto; overflow-x:hidden;">
							<table class="table table-hover table-condensed">
								<tbody>
									<tr class="tktBackground" ng-repeat="(key,rem) in singleViews.request_items">
										<td width="7%">{{key + 1}}</td>
										<td width="20%"><p tooltip-placement="top" ng-if="rem.item_type ==1">Cells</p>
											<p tooltip-placement="top" ng-if="rem.item_type ==2">Accessory</p></td>
										<td class="hidden-xs hidden-sm">{{rem.item_description}}</td>
										<td>{{rem.cell_type==1 ? 'NEW':'REVIVED'}}</td>
										<td>{{rem.quantity}}</td>
										<td>{{rem.tappr_quanty}}</td>
										<td>{{rem.sentquantity}}</td>
									</tr>
								</tbody>
							</table>
						</div>
						</div>
						<div ng-if="singleViews.remark_length != 0" class="mt10">
							<h4 class="modal-title text-center">Remarks</h4>
							<table class="table table-condensed" >
								<thead>
									<tr>
										<th width="10%"><a class="tktid">Sr.No</a></th>
										<th><a class="tktid">Remark By</a></th>
										<th><a class="tktid">Remark On</a></th>
										<th><a class="tktid">Bucket</a></th>
										<th><a class="tktid">Remark</a></th>
									</tr>
								</thead>
								<tbody>
									<tr class="tktBackground" ng-repeat="(key,rem) in singleViews.remark">
										<td>{{key + 1}}</td>
										<td><p tooltip-placement="top" tooltip="{{rem.designation}}">{{rem.remarked_by}}</p></td>
										<td class="hidden-xs hidden-sm">{{rem.remarked_on}}</td>
										<td>{{rem.bucket}}</td>
										<td>{{rem.remarks}}</td>
									</tr>
								</tbody>
							</table>
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
		setTimeout(function(){$('.SlectBox').SumoSelect();
			$('.textSearch').keyup(function(){
				var cc = $(this).siblings('.options').find('li');
				var aa =$(this).siblings('.options > li');
				var valThis = $(this).val().toLowerCase();
					if(valThis == ""){
						cc.removeClass('hidden');           
					}else{
						cc.each(function(){
							var text = $(this).text().toLowerCase();
							(text.indexOf(valThis) >= 0) ? $(this).removeClass('hidden') : $(this).addClass('hidden');
						});
				   };
				   if(cc.length==$(this).siblings('.options').find('.hidden').length){
						$(this).siblings('.options').append('<li class="no_rec"><label>No Records</label></li>');
						$(this).siblings('.select-all').addClass('hidden');}
				   else{
						$(this).siblings('.options').find('.no_rec').remove(); 
						$(this).siblings('.select-all').removeClass('hidden');
				   };
			});
		},0);
	});
</script>