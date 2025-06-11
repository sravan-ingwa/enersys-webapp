<div class="page page-ui-extras" ng-controller="ModalDemoCtrl">
<div ng-controller="bucketCtrl">
	<div class="panel panel-lined table-responsive panel-hovered mb10" style="">
		<ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
			<li><a href="#/dashboard" class="padding-10">Home</a></li>
			<li><a href="#/settings" class="padding-10">Settings</a></li>
			<li><a href="" class="padding-10">Buckets</a></li>
		</ol>
        <ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;">
            <li><a href="exports/{{singleViews.file_name}}.xlsx" ng-click="bucketexport()" class="padding-10 export-btn" ng-if="export">Export</a></li>
        </ol>
	</div>
	<div class="row">
		<div class="col-md-12 table-height">
			<div class="panel panel-lined table-responsive panel-hovered">
				<div class="panel panel-default" ng-controller="mul_view_form">
            	 <form class="form-horizontal forms_ec" url="services/settings/bucket_mul_view" name="userForm" method="post" novalidate>
					<table class="table table-condensed">
						<thead>
							<tr>
                             <th width="40%">
                                <a class="tktid">Bucket&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" style="display:block; border:none; color:#000;" name="bucket" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                             <th>
                                <a class="tktid">Bucket Description&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" style="display:block; border:none; color:#000;" name="bucket_desc" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                            <th class="hidden-xs hidden-sm" ng-if="datas.edit">
                                Actions
                            </th>
							</tr>
						</thead>
					</table>
					<div class="div-table-content">
						<table class="table table-condensed table-hover">
							<tbody>
								<tr class="tktBackground" ng-repeat="data in datas.bucketDetails">
									<td width="40%"><span tooltip-placement="top" tooltip="Click to know details of {{data.bucket}}">{{data.bucket | uppercase}}</span></td>
									<td>{{data.bucket_desc | uppercase}}</td>
                                    <td class="hidden-xs hidden-sm" ng-if="datas.edit">
                                        <a href="" class="ml3" tooltip="Advance Edit" tooltip-placement="bottom" ng-click="bucketeditOpen(data.bucket_alias);" ng-if="datas.edit">
                                            <span class="fa fa-spl-edit"></span>
                                        </a>
                                    </td>
								</tr>
							</tbody>
							<tfoot ng-if="datas.bucketDetails.length=='0'"><tr><td>No Records</td></tr></tfoot>
						</table>
					</div>
					<div class="panel-footer clearfix" ng-if="datas.bucketDetails.length!='0'">
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
	<!--<div><button type="button" class="btn btn-info ion ion-plus compose-btn" tooltip="Addnew" tooltip-placement="top" ng-click="zoneOpen()" md-ink-ripple></button></div> -->
<div id="ticketviesw">
    <div class="site-settings ticketviesw clearfix col-xs-6 col-lg-4 col-md-4 col-sm-4 floating-sidebar" ng-class="{'open': bucket_open}" custom-scrollbar>
        <div class="sidebar-wrap text-uppercase">
            <div class="group clearfix head tkt-heading">
                <div class="left">
                    <span class="ion ion-close-round mr10 tktviewClose" ng-click="removebucketView()"></span>
                    <span><strong>View Bucket</strong></span>
                </div>
                <!--<div class="right">
                    <div class="btn-group btn-group-sm">
                        <a href="" ng-click="bucketeditOpen()" class="ml10" tooltip="Edit" tooltip tooltip-placement="bottom"><span class="fa fa-edit"></span></a>
                        <a href="services/settings/zone_print.php?alias={{singleViews.zone_alias}}" tooltip="Print" class="ml10" tooltip-placement="bottom"><span class="ion ion-android-print"></span></a>
                        <a href="services/settings/zone_download.php?alias={{singleViews.zone_alias}}" target="_blank" tooltip="Download" class="ml10" tooltip-placement="bottom"><span class="ion ion-android-download"></span></a>
                    </div>
                </div>-->
            </div>
            <div class="panel-body">
                <div class="row tkt-panel">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h6>Bucket</h6>
                        <span class="fnt-size-11">{{singleViews.bucket | uppercase}}</span>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h6>Bucket Description</h6>
                        <span class="fnt-size-11">{{singleViews.bucket_desc | uppercase}}</span>
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