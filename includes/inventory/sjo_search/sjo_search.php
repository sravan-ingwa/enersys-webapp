<div class="page page-ui-extras" ng-controller="ModalDemoCtrl">
<div ng-controller="sjoSearchCtrl">
	<div class="panel panel-lined table-responsive panel-hovered mb10" >
		<ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
            <li><a href="#/dashboard" class="padding-10">Home</a></li>
            <li><a href="" class="padding-10">SJO Search</a></li>
		</ol>
        <!--<ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;">
            <li><a href="" ng-click="materialinwardexportOpen()" class="padding-10 export-btn" md-ink-ripple>Export</a></li>
        </ol>-->
	</div>
	<div class="row" ng-controller="mul_view_form">
		<div class="col-md-12 table-height">
			<div class="panel panel-lined table-responsive panel-hovered">
				<div class="panel panel-default table-height">
					<form class="form-horizontal forms_ec" url="services/inventory/sjo_search" name="userForm" method="post" novalidate>
                    	<div>
                          <div class="col-sm-4 col-sm-offset-3">
                            <md-input-container flex="" class="md-default-theme md-input-has-value">
                              <label for="input_A">SJO Number</label>
                              <input type="text" ng-model="sjo_no_model" name="sjo_no" class="ng-pristine ng-valid md-input ng-touched" ng-keypress="($event.which === 13) ? listSorting():0" id="input_A"/>
                            </md-input-container>
                          </div>
                          <div class="col-sm-4">
                          	<br />
                            <span class="md-raised md-primary md-button md-default-theme" style="margin:0px;" ng-click="listSorting()"><span class="ng-scope">Search</span><div class="md-ripple-container"></div></span>
                            <a ng-if="datas.export" class="md-raised md-primary md-button md-default-theme" style="margin:0px;" ng-click="sjo_export(sjo_no_model)"><span class="ng-scope">Export</span><div class="md-ripple-container"></div></a>
                          </div>
						</div>
					<table class="table table-condensed" >
						<thead>
							<tr>
								<th><a class="tktid_nosort">Cell No./Accessory</a></th>
								<th><a class="tktid_nosort">Item Type</a></th>
                                <th><a class="tktid_nosort">Item Condition</a></th>
                                <th class="hidden-xs"><a class="tktid_nosort">Current Location</a></th>
                                <th class="hidden-xs hidden-sm"><a class="tktid_nosort">Item Value</a></th>
							</tr>
						</thead>
					</table>
					<div class="div-table-content">
						<table class="table table-condensed table-hover">
							<tbody>
								<tr class="tktBackground" ng-repeat="data in datas.requestDetails">
									<td ng-click="cellhistoryDetails(data.cell_alias)"><span tooltip-placement="top" tooltip="Click to know details of {{data.cell_number}}">{{data.cell_number}}</span></td>
									<td>{{data.item_type}}</td>
									<td>{{data.cell_condition}}</td>
									<td class="hidden-xs"><span tooltip-placement="top" ng-attr-tooltip="{{data.current_location.length>15 ? data.current_location : ''}}">{{data.current_location | limitTo:15}}{{data.current_location.length>15 ? '...':''}}</span></td>
									<td class="hidden-xs hidden-sm">{{data.cell_value | number : 2}}</td>
								</tr>
							</tbody>
							<tfoot ng-if="datas.requestDetails.length=='0'"><tr><td colspan="4">No Records</td></tr></tfoot>
						</table>
					</div>
					<div class="panel-footer clearfix" ng-if="datas.ErrorCode!='4'">
                        <div class="col-md-4">
                        <p class="left small" style="margin:0px !important;">Showing {{datas.fromRecords}} to {{datas.toRecords}} of {{datas.totalRecords}} entries</p>
                        </div>
                        <div class="col-md-4">
                        <div class="small text-bold right ml15">
                        <span class="control-label">Page No. </span>
                        <select class="form-control page-count"  name="page_no" ng-model="selectt.id" data-ng-change="listSorting()">
                            <option value="" style="display:none">1</option>
                            <option ng-repeat="pagess in datas.pages" value="{{pagess}}" ng-show="$index > 0">{{pagess}}</option>
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
    <div id="ticketviesw">
    <div class="site-settings ticketviesw clearfix  col-xs-6 floating-sidebar" ng-class="{'open': mInward_open}">
        <div class="sidebar-wrap text-uppercase mt46">
            <div class="group clearfix head tkt-heading2">
                <div class="left">
                    <span class="ion ion-close-round mr10 tktviewClose" ng-click="removeMinward()"></span>
                    <span><strong>{{singleViews.item_type=='1' ? 'Cell History of '+singleViews.cell_number:'Accessory History of '+singleViews.item_code}}</strong></span>
                </div>
                <div class="right">
                    <div class="btn-group btn-group-sm" ng-controller="ModalDemoCtrl">
                        <a href="services/inventory/sjo_search_print.php?alias={{singleViews.cell_alias}}" target="_blank" tooltip="Print" class="ml10" tooltip tooltip-placement="bottom"><span class="ion ion-android-print"></span></a>
                        <a href="services/inventory/sjo_search_download.php?alias={{singleViews.cell_alias}}" target="_blank" tooltip="Download" class="ml10" tooltip tooltip-placement="bottom"><span class="ion ion-android-download"></span></a>
                    </div>
                </div>
            </div>
            <div class="panel-body clearfix freez-panel">
                <div class="row tkt-panel">
				<div class="col-lg-4 col-md-4 col-sm-4">
                        <h6>ITEM TYPE</h6>
                        <span class="fnt-size-11">{{singleViews.item_type==1 ? 'Cell' : 'Accessory'}}</span>
                    </div>
					
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h6>{{singleViews.item_type==1 ? 'Cell Number' : 'Quantity'}}</h6>
                        <span class="fnt-size-11">{{singleViews.cell_number}}</span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h6>{{singleViews.item_type==1 ? 'Product' : 'Accessory Description'}}</h6>
                        <span class="fnt-size-11">{{singleViews.item_code}}</span>
                    </div>
					</div>
					 <div class="row tkt-panel">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h6>Current Location</h6>
                        <span class="fnt-size-11">{{singleViews.current_location}}</span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h6>{{singleViews.item_type==1 ? 'Cell' : 'Accessory'}} Condition</h6>
                        <span class="fnt-size-11">{{singleViews.cell_condition}}</span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <h6>{{singleViews.item_type==1 ? 'Cell' : 'Accessory'}} Value</h6>
                        <span class="fnt-size-11">Rs. {{singleViews.cell_value | number : 2}}</span>
                    </div>
					</div>
					 <div class="row tkt-panel">
                    <div class="col-lg-4 col-md-4 col-sm-4" ng-if="singleViews.sjo_number!='0' && singleViews.sjo_number!=''">
                        <h6>SJO Number</h6>
                        <span class="fnt-size-11">{{singleViews.sjo_number}}</span>
                    </div>
					</div>
                
                <div ng-if="singleViews.request_length != 0" class="mt10">
                    <h4 class="modal-title text-center">{{singleViews.item_type==1 ? 'Cell' : 'Accessory'}} History</h4>
                    <table class="table table-condensed" >
                        <thead>
                            <tr>
                                <th width="10%"><a class="tktid">Sno</a></th>
                                <th width="65%"><a class="tktid">History</a></th>
                                <th width="25%"><a class="tktid">Transaction Date</a></th>
                            </tr>
                        </thead>
                    </table>
				<div style="max-height:300px;overflow:auto; overflow-x:hidden;">
					<table class="table table-hover table-condensed">
                            <tbody>
                                <tr class="tktBackground" ng-repeat="(key,rem) in singleViews.request_items">
                                    <td width="10%">{{key + 1}}</td>
                                    <td width="65%">{{rem.message}}</td>
                                    <td width="25%">{{rem.transaction_date}}</td>
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