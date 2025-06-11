 <style>
.tktid{padding:0px;}
table thead tr th {height:42px;}
 </style>
  <div class="page page-ui-extras" ng-controller="ModalDemoCtrl">
	<div ng-controller="revivalCtrl">
    <div ng-controller="mul_view_form">
   <div class="panel panel-lined table-responsive panel-hovered mb10" style="" >
        <ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
            <li><a href="#/dashboard" class="padding-10">Home</a></li>
            <li><a href="" class="padding-10">Revival</a></li>
        </ol>
        <ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;" ng-if="datas.export">
			<li><a href="" ng-click="revivalexport()" class="padding-10 export-btn">Export</a></li>
        </ol>
   </div>
		<!-- row -->
		<div class="row">
			<!-- Data Table -->
			<div class="col-md-12 table-height">
				<div class="panel panel-lined table-responsive panel-hovered">
                <div class="panel panel-default">
				<form class="form-horizontal forms_ec" url="services/inventory/material_revival_mul_view" name="userForm" method="post" novalidate>
                    <table class="table table-condensed" >
                        <thead>
                        <tr>
                            <th>
                                <a class="tktid">Revival No.&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" style="display:block; border:none; color:#000;" name="revival_no" placeholder="Revival No." ng-model="searchKeywords.revival_no" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
							<th class="hidden-xs" ng-controller="DatepickerDemoCtrl"> <a class="tktid">Transaction Date&nbsp;<span class="arrow caret"></span></a>
								<input type="text" name="transDate" class="form-control datepicker border-bottom droptxt1 hidden" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-model="transDate" is-open="opened" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="listSorting();open($event)"/>
								<span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
							</th>
                            <th>
                                <a class="tktid">Ware House.&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" style="display:block; border:none; color:#000;" name="wh_alias" placeholder="Wh Code" ng-model="searchKeywords.wh_alias" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                            <th class="hidden-xs">
                                <a class="tktid">Engineer Name&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" style="display:block; border:none; color:#000;" name="eng_name" placeholder="Eng Name" ng-model="searchKeywords.eng_name" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                             <th>PDF</th>
                            <th style="width:150px" ng-if="datas.advedit || datas.delete">
                                Actions
                            </th>
                        </tr>
                        </thead>
                    </table>
                    <div class="div-table-content">
                        <table class="table table-condensed">
                            <tbody>
                                <tr class="tktBackground" ng-repeat="data in datas.requestDetails">
                                    <td ng-click="revival_view(data.revival_alias)">{{data.revival_no}}</td>
                                    <td class="hidden-xs">{{data.createdDate}}</td>
                                    <td>{{data.wh_code}}</td>
                                    <td class="hidden-xs">{{data.eng_name}}</td>
                                    <td><a href="images/reports/{{data.pdf}}" target="_blank">Click Here</a></td>
                                    <td style="width:150px" ng-if="datas.advedit || datas.delete">
                            <a href="" class="ml3" tooltip="Advance Edit" tooltip-placement="bottom" ng-click="setAlias(data.revival_alias);revivaladveditOpen();" ng-if="datas.advedit">
                                <span class="fa fa-spl-edit"></span>
                            </a>
                            <a href="javascript:void(0)" class="ml3" tooltip="Delete Revival" tooltip-placement="bottom" ng-click="revivaldelOpen(data);" ng-if="datas.delete">
                                <span class="fa fa-delete"></span>
                            </a>
                                    </td>
                                </tr>
                           </tbody>
                           <tfoot ng-if="datas.requestDetails.length=='0'"><tr><td>No Records</td></tr></tfoot>
                        </table>
                    </div>
                    <!-- #end data table -->	
                     <div class="panel-footer clearfix" ng-if="datas.requestDetails.length!='0'">
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
		<div ng-if="datas.add"><button type="button" class="btn btn-info ion ion-plus compose-btn" tooltip="Addnew" tooltip-placement="top" ng-click="revivaladdOpen()" md-ink-ripple></button></div>
	</div> 
	</div>
<div id="ticketviesw">
<div class="site-settings ticketviesw clearfix  col-xs-6 col-lg-6 floating-sidebar" ng-class="{'open': revival_open}">
        <div class="sidebar-wrap text-uppercase mt46">
                <div class="group clearfix head tkt-heading2">
                    <div class="left">
                    <span class="ion ion-close-round mr10 tktviewClose" ng-click="removerevival()"></span>
                        <span><strong>View Revival</strong></span>
                    </div>
                    <div class="right">
                        <div class="btn-group btn-group-sm" ng-controller="ModalDemoCtrl">
                            <a ng-if="singleViews.edit" href="" class="ml10" tooltip="Edit" tooltip-placement="bottom" ng-click="revivaleditOpen()"><span class="fa fa-edit"></span></a>
                            <a href="services/inventory/revival_print.php?alias={{singleViews.revival_alias}}" target="_blank" tooltip="Print" class="ml10" tooltip-placement="bottom"><span class="ion ion-android-print"></span></a>
                            <a href="services/inventory/revival_download.php?alias={{singleViews.revival_alias}}" target="_blank" tooltip="Download" class="ml10" tooltip-placement="bottom"><span class="ion ion-android-download"></span></a>
                        </div>
                    </div>
                </div>
            	<div class="panel-body clearfix freez-panel">
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Revival No</h6>
                          <span class="fnt-size-11">{{singleViews.revival_no}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Ware House</h6>
                          <span class="fnt-size-11">{{singleViews.wh_code}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Engineer Name</h6>
                          <span class="fnt-size-11">{{singleViews.eng_name}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Transaction Date</h6>
                          <span class="fnt-size-11">{{singleViews.createdDate}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>PDF</h6>
                          <span class="fnt-size-11"><a href="images/reports/{{singleViews.pdf}}" target="_blank">Click Here</a></span>
                        </div>
                    </div>
                    
                    
                    <div class="panel panel-default" style="overflow-x:scroll;">
                        <table class="table table-condensed" style="width:1300px;">
                            <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th width="9%">Cell Sr. No.</th>
                                <th width="9%">Capacity</th>
                                <th>Mfd. Date</th>
                                <th>OCV</th>
                                <th>Discharge Current</th>
                                <th>1st Hr.</th>
                                <th>2nd Hr.</th>
                                <th>3rd Hr.</th>
                                <th>4th Hr.</th>
                                <th>5th Hr.</th>
                                <th>6th Hr.</th>
                                <th>7th Hr.</th>
                                <th>8th Hr.</th>
                                <th>9th Hr.</th>
                                <th>10th Hr.</th>
                                <th width="9%">Result</th>
                            </tr>
                            </thead>
                        </table>
                        <table class="table table-bordered table-striped" style="width:1300px;">
                            <tbody>
                                <tr ng-modal="cells" ng-repeat="(key, cell) in singleViews.type">
                                    <td>{{key+1}}</td>
                                    <td width="9%">{{cell.cell_sr_no}}</td>
                                    <td width="9%">{{cell.capacity}}</td>
                                    <td>{{cell.mf_date!='' ? cell.mf_date : '-'}}</td>
                                    <td>{{cell.ocv!='' ? cell.ocv : '-'}}</td>
                                    <td>{{cell.dis_current!='' ? cell.dis_current : '-'}}</td>
                                    <td>{{cell.a!='' ? cell.a : '-'}}</td>
                                    <td>{{cell.b!='' ? cell.b : '-'}}</td>
                                    <td>{{cell.c!='' ? cell.c : '-'}}</td>
                                    <td>{{cell.d!='' ? cell.d : '-'}}</td>
                                    <td>{{cell.e!='' ? cell.e : '-'}}</td>
                                    <td>{{cell.f!='' ? cell.f : '-'}}</td>
                                    <td>{{cell.g!='' ? cell.g : '-'}}</td>
                                    <td>{{cell.h!='' ? cell.h : '-'}}</td>
                                    <td>{{cell.i!='' ? cell.i : '-'}}</td>
                                    <td>{{cell.j!='' ? cell.j : '-'}}</td>
                                    <td width="9%">{{cell.result_text!='' ? cell.result_text : '-'}}</td>
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