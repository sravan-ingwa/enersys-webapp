<div class="page page-ui-extras" ng-controller="ModalDemoCtrl">
<div ng-controller="manualCtrl">
   <div class="panel panel-lined table-responsive panel-hovered mb10" style="" >
        <ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
            <li><a href="#/dashboard" class="padding-10">Home</a></li>
            <li><a href="#/settings" class="padding-10">Settings</a></li>
            <li><a href="" class="padding-10">Manuals</a></li>
        </ol>
        <ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;">
            <li><a href="" ng-click="manualsexport()" class="padding-10 export-btn" ng-if="export">Export</a></li>
        </ol>
   </div>
		<!-- row -->
		<div class="row">
			<!-- Data Table -->
			<div class="col-md-12 table-height">
				<div class="panel panel-lined table-responsive panel-hovered">
                <div class="panel panel-default" ng-controller="mul_view_form">
            	 <form class="form-horizontal forms_ec" url="services/settings/manuals_mul_view" name="userForm" method="post" novalidate>
                    <table class="table table-condensed" >
                        <thead>
                        <tr>
                             <th>
                                <a class="tktid">Product Description&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" style="display:block; border:none; color:#000;" name="Product" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
							<th class="hidden-xs hidden-sm" ng-controller="segmentdropCntrl">
                            	<select name="segmentAlias" placeholder="Segment" class="SlectBox form-control" ng-model="segmentAlias" data-ng-change="listSorting()">
                                    <option value="" style="display:none">Segment</option>
                                    <option ng-repeat="segment in firstDrop" value="{{segment.alias}}">{{segment.name}}</option>
                                    <option ng-if="firstDrop.length==0">No Records</option>
                                </select>
                            </th>
							<th class="hidden-xs hidden-sm">
                            	<select name="view_stat" placeholder="View Status" class="SlectBox form-control" ng-model="view_stat" data-ng-change="listSorting()">
                                    <option value="" style="display:none">View Status</option>
                                    <option value="0">DISABLE</option>
									<option value="1">ENABLE</option>
                                </select>
                            </th>
                             <th class="hidden-xs hidden-sm">Manual Report</th>
                            <th class="hidden-xs hidden-sm" ng-if="datas.edit">
                                Actions
                            </th>
                        </tr>
                       </thead>
                    </table>
                    <div class="div-table-content">
                        <table class="table table-condensed table-hover">
                            <tbody>
                                <tr class="tktBackground" ng-repeat="data in datas.manualDetails">
                                    <td><span tooltip-placement="top" tooltip="Click to edit the details of {{data.product_name}}">{{data.product_name}}</span></td>
                                     <td class="hidden-xs hidden-sm"><span tooltip-placement="top" tooltip="{{data.segment_name}}">{{data.segment_name!='' ? (data.segment_name.length>=12 ? (data.segment_name | limitTo:12)+'...' : data.segment_name) :'-'}}</span></td>
									 <td class="hidden-xs hidden-sm">{{data.view_stat=='1' ? 'ENABLE' : 'DISABLE'}}</td>
									 <td class="hidden-xs hidden-sm">
										<a href="{{data.manual_file}}" ng-if="data.manual_file!=''" target="_blank">Click Here</a>
										<span ng-if="data.manual_file==''">-</span>
									 </td>
                                    <td class="hidden-xs hidden-sm" ng-if="datas.edit || datas.delete">
                                        <a href="" class="ml3" tooltip="Advance Edit" tooltip-placement="bottom" ng-click="manualeditOpen(data.product_alias);" ng-if="datas.edit">
                                            <span class="fa fa-spl-edit"></span>
                                        </a>
                                    </td>
                                </tr>
                           </tbody>
                           <tfoot ng-if="datas.manualDetails.length=='0'"><tr><td>No Records</td></tr></tfoot>
                        </table>
                    </div>
                    <!-- #end data table -->	
                     <div class="panel-footer clearfix" ng-if="datas.manualDetails.length!='0'">
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