<div class="page page-ui-extras" ng-controller="ModalDemoCtrl">
<div ng-controller="contractPriceCtrl">
		<div class="panel panel-lined table-responsive panel-hovered mb10">
            <ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
                <li><a href="#/dashboard" class="padding-10">Home</a></li>
                <li><a href="#/settings" class="padding-10">Settings</a></li>
                <li><a href="" class="padding-10">Contact Price</a></li>
            </ol>
            <!--<ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;">
                <li><a href="" ng-click="contractpriceexportOpen()" class="padding-10 export-btn">Export</a></li>
            </ol>-->
       </div>
		<!-- row -->
		<div class="row">
			<!-- Data Table -->
			<div class="col-md-12 table-height">
            <div class="panel panel-lined table-responsive panel-hovered">
            <div class="panel panel-default" ng-controller="mul_view_form">
              <form class="form-horizontal forms_ec" url="services/expense/expense_mul_view" name="userForm" method="post" novalidate>
                <table class="table table-condensed" >
                        <thead>
                        <tr>
                            <th>
                                <a class="tktid">ESCA Name&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden form-control" name="EscaName" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                             <th class="hidden-xs hidden-sm">
                                <a class="tktid">ESCA Description&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" name="escaDesc" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                             <th class="hidden-xs" ng-controller="milestoneDropCtrl">
                                 <select name="milestone" placeholder="Milestone" class="SlectBox form-control" ng-model="selectt.id" data-ng-change="listSorting()">
                                    <option value="" style="display:none">Milestone</option>
                                    <option ng-repeat="milestone in firstDrop" value="{{milestone.alias}}">{{milestone.name}}</option>
                                    <option ng-if="firstDrop.length==0">No Records</option>
                                </select>
                            </th>
                            <th ng-controller="selectZoneCntrl">
                                 <select name="zoneAlias" placeholder="Zones" class="SlectBox form-control" ng-model="selectt.id" data-ng-change="listSorting()">
                                    <option value="" style="display:none">Zones</option>
                                    <option ng-repeat="zones in firstDrop" value="{{zones.alias}}">{{zones.name}}</option>
                                    <option ng-if="firstDrop.length==0">No Records</option>
                                </select>
                            </th>
                            
                             <th class="hidden-xs hidden-sm">
                                <a class="tktid">Amount&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden form-control" name="amount" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                            
                           <th class="hidden-xs">
                                <a class="tktid">Unit&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden form-control" name="unit" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                        </tr>
                        </thead>
                    </table>
                    <div class="div-table-content">
                        <table class="table table-hover">
                          <tbody>
                               <tr class="tktBackground" ng-repeat="data in datas.contractpriceDetails">
								<td ng-click="contractprice(data.contract_price_alias)"><span tooltip-placement="top" tooltip="Click to know details of {{data.esca_name}}">{{data.esca_name}}</span></td>
                                    <td class="hidden-xs hidden-sm">{{data.esca_desc}}</td>
                                    <td class="hidden-xs">{{data.mile_stone}}</td>
                                    <td>{{data.zone_name}}</td>
                                    <td class="hidden-xs hidden-sm">{{data.amount}}</td>
                                    <td class="hidden-xs">{{data.unit}}</td>
                                </tr>
                          </tbody>
                         	 <tfoot ng-if="datas.contractpriceDetails.length=='0'"><tr><td>No Records</td></tr></tfoot>
                        </table>
                        </div>
                        <!-- #end data table -->	
                         <div class="panel-footer clearfix" ng-if="datas.contractpriceDetails.length!='0'">
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
	</div> <!-- #end page-wrap -->
    <div><button type="button" class="btn btn-info ion ion-plus compose-btn" tooltip="Addnew" tooltip-placement="top" ng-click="contractpriceaddOpen()" md-ink-ripple></button></div>

<div class="site-settings ticketviesw clearfix  col-xs-6 floating-sidebar" ng-class="{'open': contractprice_open}" custom-scrollbar>
        <div class="sidebar-wrap text-uppercase">
                <div class="group clearfix head tkt-heading">
                    <div class="left">
                    <span class="ion ion-close-round mr10 tktviewClose" ng-click="removeContractprice()"></span>
                        <span><strong>{{singleViews.esca_name}}</strong></span>
                    </div>
                    <div class="right">
                        <div class="btn-group btn-group-sm" ng-controller="ModalDemoCtrl">
                            <a href="" class="ml10" tooltip="Edit" tooltip tooltip-placement="bottom" ng-click="contractpriceeditOpen()"><span class="fa fa-edit"></span></a>
                        </div>
                    </div>
                </div>
            	<div class="panel-body">
                    <div class="row tkt-panel">
                    	<div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>ESCA Name</h6>
                          <span class="fnt-size-11">{{singleViews.esca_name}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>ESCA Description</h6>
                          <span class="fnt-size-11">{{singleViews.esca_desc}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Milestone</h6>
                          <span class="fnt-size-11">{{singleViews.mile_stone}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                    	<div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Zone</h6>
                          <span class="fnt-size-11">{{singleViews.zone_name}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>State</h6>
                          <span class="fnt-size-11">{{singleViews.state_name}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Amount</h6>
                          <span class="fnt-size-11">{{singleViews.amount}}</span>
                        </div>
                        
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Unit</h6>
                          <span class="fnt-size-11">{{singleViews.unit}}</span>
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