<style>
table{margin-bottom: 5px !important;}
tfoot tr th{text-align: center !important;padding: 5px !important;}
.tab-content{background: none !important;box-shadow: none !important;padding: 0px !important;}
</style>
<div class="page page-ui-extras" ng-controller="ModalDemoCtrl">
	<div ng-controller="outwardbalanceCtrl">
		<div ng-controller="mul_view_form">
		<div class="panel panel-lined table-responsive panel-hovered mb10">
			<ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
				<li><a href="#/dashboard" class="padding-10">Home</a></li>
				<li><a href="" class="padding-10">Outward Balance</a></li>
			</ol>
			<ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;" ng-if="datas.export">
				<li><a href="" ng-click="materialoutwardbalexportOpen()" class="padding-10 export-btn" md-ink-ripple>Export</a></li>
			</ol>
		</div>
		<div class="row">
			<form class="form-horizontal forms_ec" url="services/inventory/outward_balance_multi" name="userForm" method="post" novalidate>
				<div class="col-xs-12">
					<table class="table table-condensed">
						<thead>
							<tr>
								<th ng-controller="DatepickerDemoCtrl"> <a class="tktid">From Date&nbsp;<span class="arrow caret"></span></a>
									<input type="text" class="form-control datepicker border-bottom droptxt1 hidden" name="fromDate" placeholder="From date.." ng-model="logindate" datepicker-popup="{{format}}" ng-click="open($event)" is-open="opened" min-date="'01-01-2000'" max-date="'22-06-2025'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="listSorting();open($event)"/>
									<span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span> </th>
								<th ng-controller="DatepickerDemoCtrl"> <a class="tktid">To Date&nbsp;<span class="arrow caret"></span></a>
									<input type="text" class="form-control datepicker border-bottom droptxt1 hidden" name="toDate" placeholder="To date.." ng-model="logindate" datepicker-popup="{{format}}" ng-click="open($event)" is-open="opened" min-date="'01-01-2000'" max-date="'22-06-2025'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="listSorting();open($event)"/>
									<span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span> </th>
								<th ng-controller="zoneslistsCntrl"> <select name="zone" placeholder="Zone" class="SlectBox form-control" ng-model="zones" data-ng-change="listSorting()">
										<option value="" selected="">Zone</option>
										<option ng-repeat="zone in firstDrop" value="{{zone.alias}}">{{zone.name}}</option>
									</select>
								</th>
								<th ng-controller="selfWarehouse"> <select class="SlectBox form-control" name="to_wh" ng-model="to_wh" data-ng-change="listSorting()">
										<option value="" style="display:none">Warehouse</option>
										<option ng-repeat="selectlist in firstDrop" value="{{selectlist.alias}}">{{selectlist.name}}</option>
										<option ng-if="firstDrop.length==0">No Records</option>
									</select>
								</th>
                                <th>
                                	<select class="SlectBox form-control" name="item_type" ng-model="item_type" ng-init="item_type='1'" data-ng-change="listSorting()">
										<option value="1">CELLS</option>
										<option value="2">ACCESSORIES</option>
									</select>
								</th>
								<?php /*?><th ng-controller="emprolenameCntrl"> <select name="engineer" placeholder="Engineer" class="SlectBox form-control" ng-model="selectt.id" data-ng-change="listSorting()">
										<option value="" selected="">Engineer</option>
										<option ng-repeat="emp in firstDrop" value="{{emp.alias}}">{{emp.name}}</option>
									</select>
								</th><?php */?>
							</tr>
						</thead>
					</table>
				</div>
				<div class="col-sm-12" ng-if="datas.outwardcount=='1'">
					<div class="panel panel-default panel-hovered panel-stacked mb20">
						<div class="panel-heading"><span>Outward Balance Overview</span></div>
						<div class="panel-body pivot-pad">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>AH Capacity</th>
										<th>New to Field</th>
										<th class="hidden-xs">New to branch</th>
										<th class="hidden-xs">Revived to Field</th>
										<th class="hidden-xs">Revived to branch</th>
										<th>Scrap to factory</th>
										<th>Total</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="data in datas.outward">
										<td>{{data.product_name}}</td>
										<td>{{data.field_count_new}}</td>
										<td class="hidden-xs">{{data.branch_count_new}}</td>
										<td class="hidden-xs">{{data.field_count_revied}}</td>
										<td class="hidden-xs">{{data.branch_count_revied}}</td>
										<td>{{data.factory_count}}</td>
										<td>{{data.total_count}}</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<tr>
										<th>Total</th>
										<th>{{datas.outwarda.field_count_new_t}}</th>
										<th class="hidden-xs">{{datas.outwarda.branch_count_new_t}}</th>
										<th class="hidden-xs">{{datas.outwarda.field_count_revied_t}}</th>
										<th class="hidden-xs">{{datas.outwarda.branch_count_revied_t}}</th>
										<th>{{datas.outwarda.factory_count_t}}</th>
										<th>{{datas.outwarda.total_count_t}}</th>

									</tr>
									</tr>
								</tfoot>
							</table>
						</div>
						<div class="panel-footer clearfix" ng-if="datas.outwardcount=='1'">
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
					</div>
				</div>
				<div class="col-sm-12 table-height" ng-if="datas.outwardcount=='0'"> <img src="images/nostock.png" class="norecords"/> </div>
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