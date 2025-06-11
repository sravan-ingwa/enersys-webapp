<style>
	.panel-group{margin-bottom:1px;}
</style>
<div class="page page-ui-extras" ng-controller="ModalDemoCtrl">
<div ng-controller="workguideCntl">
	<div class="panel panel-lined table-responsive panel-hovered mb10" style="">
		<ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
			<li><a href="#/dashboard" class="padding-10">Home</a></li>
			<li><a href="#/settings" class="padding-10">Settings</a></li>
			<li><a href="" class="padding-10">Work Guide</a></li>
		</ol>
         <ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;">
            <li><a href="exports/{{singleViews.file_name}}.xlsx" class="padding-10 export-btn" ng-if="export">Export</a></li>
        </ol>
	</div>
	<div class="row">
		<div class="col-md-12 table-height" ng-controller="mul_view_form">
		 <form class="form-horizontal forms_ec" url="services/settings/workguide_mul_view" name="userForm" method="post" novalidate>
			<table class="table table-condensed">
				<thead>
					<tr>
						<th>
							<a class="tktid">Work guide<span class="arrow caret"></span></a>
							<input type="text" class="droptxt1 hidden" name="work_guide" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()" />
							<span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
						</th>
					</tr>
				</thead>
			</table>
			<div>
				<accordion class="accordion-panel accord-data" ng-repeat="data in datas.workguideDetails">
					<accordion-group is-open="lc_status.open" ng-class="{'panel-info': lc_status.open}">
						<accordion-heading>
							<span>{{data.work_guide_title}} &nbsp; </span><i class="mt2 ion small" style="color:#000" ng-class="{'ion-chevron-down': lc_status.open, 'ion-chevron-right': !lc_status.open}" style="color:#000"></i>
							<div class="right">
								<div class="btn-group btn-group-sm">
									<a href="" ng-click="workguideeditOpen(data.mainguide_alias);" class="ml10" tooltip="Edit" tooltip tooltip-placement="bottom" ng-if="datas.edit"><span class="fa fa-edit"></span></a>
									<a ng-click="work_print(data.mainguide_alias);" target="_blank" tooltip="Print" class="ml10" tooltip-placement="bottom"><span class="fa fa-print"></span></a>
									<a ng-click="work_download(data.mainguide_alias);" target="_blank" tooltip="Download" class="ml10" tooltip-placement="bottom"><span class="fa fa-download"></span></a>
									<a ng-click="settingsDeleteOpen('workguide', data)" target="_blank" tooltip="Delete" class="ml10" tooltip-placement="bottom" ng-if="datas.delete"><span class="fa fa-delete-white"></span></a>
								</div>
							</div>
						</accordion-heading>
						<ul class="accord-showcontent" ng-repeat="dat in data.sub_work_guide">
							<li>{{dat.name}}</li>
						</ul>
					</accordion-group>
				</accordion>
			</div>
			<div class="div-table-content" ng-if="datas.workguideDetails.length=='0'">
				<table class="table table-condensed table-hover"><tbody><tr><td>No Records</td></tr></tbody></table>
			</div>
			<div class="panel-footer clearfix" ng-if="datas.workguideDetails.length!='0'">
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
	<div><button type="button" class="btn btn-info ion ion-plus compose-btn" tooltip="Addnew" tooltip-placement="top" ng-if="add" ng-click="workguideaddOpen()" md-ink-ripple></button></div> 
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