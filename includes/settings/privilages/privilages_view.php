<style>.SumoSelect > .CaptionCont > span {padding-right: 30px !important;}
@media screen and (min-width: 304px) and (max-width: 992px) {
	.privilage-table > thead > tr > th {width:100px !important;}
	}
@media screen and (min-width: 304px) and (max-width: 992px) {
.privilage-table > thead {max-width:900px !important;}
.privilage-table > tbody {max-width:900px !important;}
}
.panel-group { margin-bottom: 0px;}
.panel-info > .panel-heading { 
	color: #535353;
	background-color: #ffffff; 
	border-color: #e4e4e4;
}
a.disabled {
	opacity: 0.5;
	cursor: default;
}
</style>
<div class="page page-ui-extras" ng-controller="ModalDemoCtrl">
<div  ng-controller="PrivilagesCtrl">
	<div>
   <div class="panel panel-lined table-responsive panel-hovered mb10" style="" >
        <ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
            <li><a href="#/dashboard" class="padding-10">Home</a></li>
            <li><a href="#/settings" class="padding-10">Settings</a></li>
            <li><a href="" class="padding-10">Privilages</a></li>
        </ol>
        <ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;">
            <li><a href="exports/{{singleViews.file_name}}.xlsx" ng-click="privilegesexport()" class="padding-10 export-btn" ng-if="export">Export</a></li>
        </ol>
   </div>
		<!-- row -->
		<div class="row">
			<!-- Data Table -->
			<div class="col-md-12 table-height">
				<div class="panel panel-lined table-responsive panel-hovered">
                <div class="panel panel-default" ng-controller="mul_view_form">
            	 <form class="form-horizontal forms_ec" url="services/settings/privileges_mul_view" name="userForm" method="post" novalidate>
                    <table class="table table-condensed" >
                        <thead>
                        <tr>
                            <th>
                                <a class="tktid">Role Name&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" name="privilegeName" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
							<th class="hidden-xs hidden-sm" ng-if="datas.edit || datas.delete">
								Actions
							</th>
                        </tr>
                        </thead>
                    </table>

                    <div class="div-table-content">
                        <table class="table table-condensed table-hover">
                            <tbody>
                                <tr class="tktBackground" ng-repeat="data in datas.privilegeDetails">
                                	<td ng-click="privilagesview(data.privilege_alias)"><span tooltip-placement="top" tooltip="Click to know details of {{data.privilege_name}}">{{data.privilege_name}}</span></td>
                                    <td class="hidden-xs hidden-sm" ng-if="datas.edit || datas.delete">
                                        <a href="" class="ml3" tooltip="Advance Edit" tooltip-placement="bottom" ng-click="setSettingsAlias(data.privilege_alias);privilageseditOpen();" ng-if="datas.edit">
                                            <span class="fa fa-spl-edit"></span>
                                        </a>
                                        <a href="javascript:void(0)" class="ml3" tooltip="Delete" tooltip-placement="bottom" 
                                        ng-click="settingsDeleteOpen('privilege', data);" ng-if="datas.delete && data.can_delete == 0">
                                            <span class="fa fa-delete"></span>
                                        </a>
                                        <a class="ml3 disabled" tooltip="Can't Delete" tooltip-placement="bottom" ng-if="datas.delete && data.can_delete == 1">
                                            <span class="fa fa-delete"></span>
                                        </a>
                                    </td>
                                </tr>
                           </tbody>
                           <tfoot ng-if="datas.privilegeDetails.length=='0'"><tr><td>No Records</td></tr></tfoot>
                        </table>
                    </div>
                    <!-- #end data table -->	
                     <div class="panel-footer clearfix" ng-if="datas.privilegeDetails.length!='0'">
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
		<!-- #end row -->
	</div>
    <div><button type="button" class="btn btn-info ion ion-plus compose-btn" tooltip="Addnew" tooltip-placement="top" ng-click="privilagesOpen()" ng-if="add" md-ink-ripple></button></div> 
</div>
<div id="ticketviesw">
	<div class="site-settings ticketviesw clearfix  col-xs-6 floating-sidebar" ng-class="{'open': privilagesView}" custom-scrollbar>
        <div class="sidebar-wrap text-uppercase mt47">
                <div class="group clearfix head tkt-heading2">
                    <div class="left">
                    <span class="ion ion-close-round mr10 tktviewClose" ng-click="removeprivilagesView()"></span>
                        <span><strong>VIEW USER ROLES</strong></span>
                    </div>
                    <div class="right" ng-controller="ModalDemoCtrl">
                        <div class="btn-group btn-group-sm">
                            <a href="services/settings/privileges_print.php?alias={{singleViews.alias}}" tooltip="Print" class="ml10" tooltip-placement="bottom" target="_blank" ><span class="ion ion-android-print"></span></a>
                   			<a href="services/settings/privileges_download.php?alias={{singleViews.alias}}" target="_blank" tooltip="Download" class="ml10" tooltip-placement="bottom"><span class="ion ion-android-download"></span></a>
                        </div>
                    </div>
                </div>
            	<div class="panel-body clearfix freez-panel">
                    <div class="row tkt-panel">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <form class="form-horizontal" name="modal-demo-form" action="javascript:;" novalidate>
                            <div class="row form-group">
                                <div class="col-sm-8 col-sm-offset-2 mb10">
                                    <md-input-container flex="" class="md-default-theme md-input-has-value">
                                        <label for="input_00D">Role Name</label>
                                        <input disabled="" value="{{singleViews.name}}" class="ng-pristine ng-valid md-input ng-touched" id="input_00A" tabindex="0" aria-invalid="false">
                                    </md-input-container>
                                </div>
								
								<div class="col-sm-12 mb10" ng-controller="PrivilegesCheckCntrl">
									<accordion class="accordion-panel">
									  <div class="panel panel-default panel-hovered">
										<div class="panel-heading exp_sing text-center">Privilages</div>
										<accordion class="accordion-panel" ng-repeat="(key, data) in singleViews1">
											<accordion-group is-open="lc_status.open" ng-class="{'panel-info': lc_status.open}">
											<accordion-heading>
												<div>{{key}}&nbsp; <i class="mt2 ion small" style="color:#000" ng-class="{'ion-chevron-down': lc_status.open, 'ion-chevron-right': !lc_status.open}"></i></div>
											</accordion-heading>
											<div class="mb20" style="overflow:scroll;">
												<table class="table table-condensed" >
													<thead>
														<tr>
															<th ng-repeat="(key1, crud) in data.head" style="width:100px"><a class="tktid">{{crud !='SPECIAL' ? crud : 'SPCL'}}</a></th>
														</tr>
													</thead>
												</table>
												<table class="table table-hover table-bordered">
													<tbody>
														<tr class="tktBackground" ng-repeat="(key2, sub) in data.sub">
															<td style="width:100px"><span tooltip-placement="top" tooltip="{{sub}}">{{sub | limitTo:15}}{{sub.length>15 ? '...':''}}</span></td>
															<td ng-repeat="(key3, crud) in data.head" ng-if="$index!=0" style="padding: 0px; width :100px;">
																<div class="ui-checkbox ui-checkbox-info">
																	<label><input type="checkbox" ng-disabled="true" ng-model="singleViews[sub][crud]==1 ? true : false"><span></span></label>
																</div>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
											</accordion-group>
										</accordion>
										</div>
									</accordion>
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
	});
</script>