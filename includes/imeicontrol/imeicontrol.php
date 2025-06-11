<style>.tab-content{background:none !important; box-shadow:none !important; padding:0px !important;}
.tabs-linearrow{border:none !important;}
.loader { position: absolute; top: 30%; left: 40%; z-index: 10000;}
.table > tbody > tr > td, .table > tfoot > tr > td { padding: 5px !important;}
</style>
<div class="page page-ui-extras" ng-controller="ModalDemoCtrl">
	<div ng-controller="imeiCtrl">
	<!--<div ng-include="'includes/loading.php'"></div>-->
    <div ng-controller="mul_view_form">
		<div class="panel panel-lined table-responsive panel-hovered mb10" style="" >
			<ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
                <li><a href="#/dashboard" class="padding-10">Home</a></li>
                <li><a href="" class="padding-10">Device Control</a></li>
			</ol>
			<!-- <ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;" ng-if="datas.export">
				<li><a href="" ng-click="deactExportOpen()" class="padding-10 export-btn">Export</a></li>
			</ol> -->
		</div>
		<div class="row">
			<div class="col-md-12 table-height">
				<div class="panel panel-lined table-responsive panel-hovered">
					<div class="panel panel-default">
						<form class="form-horizontal forms_ec" url="services/devicecontrol/device_mul_view" name="userForm" method="post" novalidate>
							<table class="table table-condensed">
								<thead>
									<tr>
                                        <th>
                                            <a class="tktid">Employee ID &nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" class="droptxt1 hidden" name="employee_id" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()" />
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                                        </th>
                                        <th>
                                            <a class="tktid">Name &nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" class="droptxt1 hidden" name="name" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()" />
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                                        </th>
                                        <!-- <th class="hidden-xs">
                                            <a class="tktid">Mobile Number &nbsp;<span class="arrow caret"></span></a>
                                            <input type="text" class="droptxt1 hidden" name="mobile_number" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()" />
                                            <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                                        </th> -->
                                        <th class="hidden-xs">
											Android ID
                                        </th>
                                        <th class="hidden-xs">
											Manufacturer
                                        </th>
                                        <th class="hidden-xs">
											Model
                                        </th>
										<!-- <th class="hidden-xs hidden-sm" ng-controller="emproledropCntrl">
											<select name="role_alias" placeholder="Role" class="SlectBox form-control" ng-model="role_alias" data-ng-change="listSorting()">
												<option value="" style="display:none">Role</option>
												<option ng-repeat="role in firstDrop" value="{{role.alias}}">{{role.name}}</option>
												<option ng-if="firstDrop.length==0">No Records</option>
											</select>
										</th> -->
										<th ng-controller="imeiactdropCntrl">
											<select name="action" placeholder="Action" class="SlectBox form-control" ng-model="action" data-ng-change="listSorting()">
												<option value="" style="display:none">Action</option>
												<option ng-repeat="imei in imeiactDrop" value="{{imei.alias}}">{{imei.name}}</option>
											</select>
										</th>
									</tr>
								</thead>
							</table>
							<div class="div-table-content">
								<table class="table table-condensed table-hover">
									<tbody>
                                        <tr class="tktBackground" ng-repeat="data in datas.devices" >
                                            <td ng-click="deacteditOpen(data.emp_alias)"><span tooltip="Click here to {{data.employee_id}} IMEI Activate/Deactivate" tooltip tooltip-placement="top">{{data.employee_id}}</span></td>
                                            <td class="hidden-xs"><span tooltip-placement="top" tooltip="{{data.full_name}}">{{data.name}}</span></td>
                                            <!-- <td class="hidden-xs">{{data.mobile_number}}</td> -->
                                            <td class="hidden-xs">{{data.android_id}}</td>
                                            <td class="hidden-xs">{{data.device_manufacturer}}</td>
                                            <td class="hidden-xs">{{data.device_model}}</td>
                                            <td>
												<a ng-if="data.act_grant" ng-click="actClick(data.emp_alias, data.name);" class="btn btn-primary btn-sm">Activate</a>
												<a ng-if="data.deact_grant" ng-click="deactClick(data.emp_alias, data.name);" class="btn btn-danger btn-sm">Deactivate</a>
											</td>
                                        </tr>
									</tbody>
									<tfoot ng-if="datas.empDetails.length=='0'"><tr><td>No Records</td></tr></tfoot>
								</table>
							</div>
							<div class="panel-footer clearfix" ng-if="datas.empDetails.length!='0'">
                                <div class="col-md-4">
                                   <p class="left small" style="margin:0px !important;">Showing {{datas.fromRecords}} to {{datas.toRecords}} of {{datas.totalRecords}} entries</p>
                                </div>
								<div class="col-md-4">
									<div class="small text-bold right ml15">
										<span class="control-label">Page No. </span>
                                        <select class="form-control page-count"  name="page_no" ng-model="selectt.id" data-ng-change="listSorting()">
                                            <option value="" style="display:none">1</option>
                                            <option ng-repeat="pagess in datas.pages" ng-show="$index > 0" value="{{pagess}}">{{pagess}}</option>
                                        </select> 
									</div>
								</div>
								<div class="col-md-4">
                                    <div class="small text-bold right ml15">
                                        <span class="control-label">Count per page</span>
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
	});
</script>