<style>
table {
	margin-bottom: 5px !important;
}
.lineheight tr td{
	line-height:1.3 !important;
}
tfoot tr th {
	text-align: center !important;
	padding: 5px !important;
}
.tab-content {
	background: none !important;
	box-shadow: none !important;
	padding: 0px !important;
}
.tabs-linearrow{border:none !important;}
.loader { position: absolute; top: 30%; left: 40%; z-index: 10000;}
</style>
<div class="page page-ui-extras" ng-controller="ModalDemoCtrl">
	<div ng-controller="MaterialbalanceCtrl">
		<div ng-controller="mul_view_form" id="parent">
		<div class="panel panel-lined table-responsive panel-hovered mb10">
			<ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
				<li><a href="#/dashboard" class="padding-10">Home</a></li>
				<li><a href="" class="padding-10">Material Balance</a></li>
			</ol>
			<ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;">
				<li ng-if="datas.admin_nhs_priv"><a href="" ng-click="financ_exp_fun(financ_exp);" class="padding-10 export-btn">Financial Export</a></li>
				<li ng-if="datas.export"><a href="" ng-click="materialbalexportOpen()" class="padding-10 export-btn">Balance Sheet Export</a></li>
				<li ng-if="datas.export"><a href="" ng-click="sjobalexportOpen()" class="padding-10 export-btn">SJO Tracking Export</a></li>
			</ol>
		</div>
		<div class="row">
			<form class="form-horizontal forms_ec" url="services/inventory/material_balance_multi" name="userForm" method="post" novalidate>
				<div ng-if="financ_exp" class="col-xs-12">
					<input type="hidden" value="finance" name="financ_export"/>
					<table class="table table-condensed">
						<thead>
							<tr>
								<th>
									<select name="fy_year" placeholder="FY Year" class="SlectBox form-control" ng-model="fy_year" data-ng-change="listSorting()">
										<option value="" selected="">FY Year</option>
										<?php date_default_timezone_set("Asia/Kolkata");
											for($c=(date('y')-16);$c>=0;$c--){
												$date=date('Y',strtotime("-$c year"))."-".date('y',strtotime("-".($c-1)." year"));
												echo "<option value='$date'>$date</option>";
											}
										?>
									</select>
								</th>
								<th class="hidden-xs">
									<a class="tktid">Opening Balance&nbsp;<span class="arrow caret"></span></a>
									<input type="text" class="droptxt1 hidden form-control" name="opening_bal" placeholder="Type keyword" data-ng-keyup="listSorting()"  />
									<span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
								</th>
								<th class="hidden-xs">
									<a class="tktid">Closing Balance&nbsp;<span class="arrow caret"></span></a>
									<input type="text" class="droptxt1 hidden form-control" name="closing_bal" placeholder="Type keyword" data-ng-keyup="listSorting()"  />
									<span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
								</th>
								<th>Download</th>
							</tr>
						</thead>
					</table>
					<div class="div-table-content" style="background:#fff">
						<table class="table table-condensed table-hover">
							<tbody>
								<tr class="tktBackground" ng-repeat="data in datas.finance_details" >
									<td class="tktClick">{{data.fy_year}}</td>
									<td class="hidden-xs hidden-sm">{{data.opening_bal}}</td>
									<td class="hidden-xs hidden-sm">{{data.closing_bal}}</td>
									<td>
										<a href="{{base_url}}finance_archive/{{data.excel_download}}" ng-if="data.excel_download!=''" tooltip-placement="top" tooltip="{{data.trans_date}}"><i class="fa fa-download" aria-hidden="true"></i></a>
										<span ng-if="data.excel_download==''">NA</span>
									</td>
								</tr>
							</tbody>
							<tfoot ng-if="datas.balancecount=='0'"><tr><td>No Records</td></tr></tfoot>
						</table>
					</div>
					<div class="panel-footer clearfix" ng-if="datas.balancecount!='0'">
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
				</div>
				<div ng-if="!financ_exp">
				<input type="hidden" value="balance" name="financ_export"/>
				<div class="col-xs-12">
					<table class="table table-condensed">
						<thead>
							<tr>
								<th ng-controller="zoneslistsCntrl">
                                	<select name="zone" placeholder="Zone" class="SlectBox form-control" ng-model="zones" data-ng-change="listSorting()">
										<option value="" selected="">Zone</option>
										<option ng-repeat="zone in firstDrop" value="{{zone.alias}}">{{zone.name}}</option>
									</select>
								</th>
								<th ng-controller="selfWarehouse">
                                	<select class="SlectBox form-control" name="to_wh" ng-model="to_wh" data-ng-change="listSorting()">
										<option value="" style="display:none">Warehouse</option>
										<option ng-repeat="selectlist in firstDrop" value="{{selectlist.alias}}">{{selectlist.name}}</option>
										<option ng-if="firstDrop.length==0">No Records</option>
									</select>
								</th>
								<th ng-controller="customerdropCntrl">
                                	<select name="customer" placeholder="Customer" class="SlectBox form-control" ng-model="customer" data-ng-change="listSorting()">
										<option value="" selected="">Customer</option>
										<option ng-repeat="cust in firstDrop" value="{{cust.alias}}">{{cust.name}}</option>
									</select>
								</th>
								<th>
                                	<select class="SlectBox form-control" name="item_type" ng-model="item_type" ng-init="item_type='1'" data-ng-change="listSorting()">
										<option value="1">Cells</option>
										<option value="2">Accessories</option>
									</select>
								</th>
							</tr>
						</thead>
					</table>
				</div>
                <div ng-if="item_type=='1'">
				<div class="col-sm-12" ng-if="datas.balancecount=='1'">
					<div class="panel panel-default panel-hovered panel-stacked">
						<div class="panel-heading"><span>Balance Overview</span>
							<div class="right btn-group" style="margin: -10px 25px;" tooltip-placement="top" tooltip="{{datas.fin_date_tool_tip}}" ng-if="datas.admin_nhs_priv">
								<button type="button" ng-click="archive();" ng-disabled="datas.finance_date" class="btn btn-danger">Archive</button>
							</div>
						</div>
						<div class="panel-body pivot-pad">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>AH Capacity</th>
										<th>Opening</th>
										<th class="hidden-xs hidden-sm">New</th>
										<th class="hidden-xs hidden-sm">Revived</th>
										<th class="hidden-xs">Scrap</th>
										<th class="hidden-xs hidden-sm">Dispute</th>
										<th class="hidden-xs hidden-sm">Under Revival</th>
										<th class="hidden-xs hidden-sm">Under Transit</th>
										<th class="hidden-xs">Total</th>
										<th>Outstanding</th>
									</tr>
								</thead>
								</table>
                               <div class="div-table-content">
                                 <table class="table table-condensed table-hover"> 
								<tbody class="lineheight">
									<tr ng-repeat="data in datas.balance">
										<td>{{data.product_name}}</td>
										<td>{{data.opening_bal}}</td>
										<td class="hidden-xs hidden-sm">{{data.new_count}}</td>
										<td class="hidden-xs hidden-sm">{{data.revived_count}}</td>
										<td class="hidden-xs">{{data.scrap_count}}</td>
										<td class="hidden-xs hidden-sm">{{data.dispute_count}}</td>
										<td class="hidden-xs hidden-sm">{{data.Revival_count}}</td>
										<td class="hidden-xs">{{data.transit_count}}</td>
										<td class="hidden-xs hidden-sm">{{data.total_count}}</td>
										<td>{{data.outstandcount}}</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<th>Total</th>
										<th>{{datas.balancea.opening_bal_t}}</th>
										<th class="hidden-xs hidden-sm">{{datas.balancea.new_count_t}}</th>
										<th class="hidden-xs hidden-sm">{{datas.balancea.revived_count_t}}</th>
										<th class="hidden-xs">{{datas.balancea.scrap_count_t}}</th>
										<th class="hidden-xs hidden-sm">{{datas.balancea.dispute_count_t}}</th>
										<th class="hidden-xs hidden-sm">{{datas.balancea.Revival_count_t}}</th>
										<th class="hidden-xs hidden-sm">{{datas.balancea.transit_count_t}}</th>
										<th class="hidden-xs">{{datas.balancea.total_count_t}}</th>
										<th>{{datas.balancea.outstandcount_t}}</th>
									</tr>
								</tfoot>
							</table>
							</div>
						</div>
						<div class="panel-footer clearfix" ng-if="datas.requestDetails.length!='0'">
						<div class="col-md-4">
						  <p class="left small" style="margin:0px !important;">Showing {{datas.fromRecords}} to {{datas.toRecords}} of {{datas.totalRecords}} entries</p>
						</div>
						<div class="col-md-4">
						  <div class="small text-bold right ml15"> <span class="control-label">Page No. </span>
							<select class="form-control page-count"  name="page_no" ng-model="page_no" data-ng-change="listSorting()">
							  <option value="" style="display:none">1</option>
							  <option ng-repeat="pagess in datas.pages" value="{{pagess}}" ng-show="$index > 0">{{pagess}}</option>
							</select>
						  </div>
						</div>
						<div class="col-md-4">
						  <div class="small text-bold right ml15"> <span class="control-label">Count per page</span>
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
					</div>
				</div>
				<div class="col-sm-12 table-height" ng-if="datas.balancecount=='0'"> <img src="images/nostock.png" class="norecords"/> </div>
				</div>
                <div ng-if="item_type=='2'">
				<div class="col-sm-12" ng-if="datas.balancecount=='1'">
					<div class="panel panel-default panel-hovered panel-stacked">
						<div class="panel-heading"><span>Balance Overview</span></div>
						<div class="panel-body pivot-pad">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Accessory</th>
										<th>Good</th>
										<th>Damaged</th>
										<th>Lost</th>
										<th>Total</th>
									</tr>
								</thead>
								</table>
                               <div class="div-table-content">
                                 <table class="table table-condensed table-hover"> 
								<tbody class="lineheight">
									<tr ng-repeat="data in datas.balance">
                                        <td><span tooltip-placement="top" tooltip="{{data.product_name}}">{{data.product_name | limitTo:15}}{{data.product_name.length>15 ? '...':''}}</span></td>
										<td>{{data.new_count}}</td>
										<td>{{data.scrap_count}}</td>
										<td>{{data.lost_count}}</td>
										<td>{{data.total_count}}</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<th>Total</th>
										<th>{{datas.balancea.new_count_t}}</th>
										<th>{{datas.balancea.scrap_count_t}}</th>
										<th>{{datas.balancea.lost_count_t}}</th>
										<th>{{datas.balancea.total_count_t}}</th>
									</tr>
								</tfoot>
							</table>
							</div>
						</div>
						<div class="panel-footer clearfix"  ng-if="datas.requestDetails.length!='0'">
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
					</div>
				</div>
				<div class="col-sm-12 table-height" ng-if="datas.balancecount=='0'"> <img src="images/nostock.png" class="norecords"/> </div>
				</div>
				<?php /*?><div class="col-md-5 col-sm-12">
					<div class="panel panel-default panel-hovered panel-stacked mb20">
						<div class="panel-heading"><span>Inward</span></div>
						<div class="panel-body pivot-pad">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>AH Capacity</th>
										<th>From Factory</th>
										<th>From Field</th>
										<th>From Branch</th>
										<th>Total</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="data in datas.inward">
										<td>{{data.product_name}}</td>
										<td>{{data.factory_count}}</td>
										<td>{{data.field_count}}</td>
										<td>{{data.branch_count}}</td>
										<td>{{data.total_count}}</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<th>Total</th>
										<th>{{datas.inwarda.factory_count_t}}</th>
										<th>{{datas.inwarda.field_count_t}}</th>
										<th>{{datas.inwarda.branch_count_t}}</th>
										<th>{{datas.inwarda.total_count_t}}</th>
									</tr>
								</tfoot>
							</table>
						</div> 
					</div> 
				</div><?php */?>
				<?php /*?><div class="col-md-7 col-sm-12">
					<div class="panel panel-default panel-hovered panel-stacked mb20">
						<div class="panel-heading"><span>Outward</span></div>
						<div class="panel-body pivot-pad">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>AH Capacity</th>
										<th>New to Field</th>
										<th>New to branch</th>
										<th>Revived to Field</th>
										<th>Revived to branch</th>
										<th>Scrap to factory</th>
										<th>Total</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="data in datas.outward">
										<td>{{data.product_name}}</td>
										<td>{{data.field_count_new}}</td>
										<td>{{data.branch_count_new}}</td>
										<td>{{data.field_count_revied}}</td>
										<td>{{data.branch_count_revied}}</td>
										<td>{{data.factory_count}}</td>
										<td>{{data.total_count}}</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<tr>
										<th>Total</th>
										<th>{{datas.outwarda.field_count_new_t}}</th>
										<th>{{datas.outwarda.branch_count_new_t}}</th>
										<th>{{datas.outwarda.field_count_revied_t}}</th>
										<th>{{datas.outwarda.branch_count_revied_t}}</th>
										<th>{{datas.outwarda.factory_count_t}}</th>
										<th>{{datas.outwarda.total_count_t}}</th>

									</tr>
									</tr>
								</tfoot>
							</table>
						</div> 
					</div> 
				</div><?php */?>
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