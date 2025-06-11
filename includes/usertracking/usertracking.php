<style>
.tab-content {background: none !important;box-shadow: none !important;padding: 0px !important;}
.tabs-linearrow {border: none !important;}
#map {height:530px;width:100%;}
.infoWindowContent {font-size:  14px !important;border-top: 1px solid #ccc;padding-top: 10px;}
h2 {margin-bottom:0;margin-top: 0;}
</style>
<div class="page page-ui-extras" ng-controller="ModalDemoCtrl">
  <div ng-controller="userTrackingCtrl">
   <div ng-controller="mul_view_form">
    <div class="panel panel-lined table-responsive panel-hovered mb10">
      <ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
        <li><a href="#/dashboard" class="padding-10">Home</a></li>
        <li><a href="#/settings" class="padding-10">User Tracking</a></li>
      </ol>
		<ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;" ng-if="datas.export">
            <li><a style="cursor:pointer" ng-click="usertrackingexport('')" class="padding-10 export-btn">Export</a></li>
		</ol>
    </div>
    <!-- row -->
    <div class="row"> 
      <!-- Data Table -->
      <div class="col-md-12 table-height">
        <div class="panel panel-lined table-responsive panel-hovered">
          <div class="panel panel-default">
            <form class="form-horizontal forms_ec" url="services/usertracking/usertracking_mul_view" name="userForm" method="post" novalidate>
              <table class="table table-condensed" >
                <thead>
                  <tr>
                    <th> <a class="tktid">Employee ID&nbsp;<span class="arrow caret"></span></a>
                      <input type="text" class="droptxt1 hidden" name="employeeId" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
                      <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
					</th>
                    <th> <a class="tktid">Employee Name&nbsp;<span class="arrow caret"></span></a>
                      <input type="text" class="droptxt1 hidden" name="name" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
                      <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
					</th>
                    <th class="hidden-xs">
						<a class="tktid">Designation&nbsp;<span class="arrow caret"></span></a>
                      <input type="text" class="droptxt1 hidden" name="designation" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
                      <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
					</th>
                    <th ng-controller="DatepickerDemoCtrl"> <a class="tktid">Last Login&nbsp;<span class="arrow caret"></span></a>
                      <input type="text" name="dateTime" class="form-control datepicker border-bottom droptxt1 hidden" name="loginDate" placeholder="Select date.." ng-model="logindate" datepicker-popup="{{format}}" ng-click="open($event)" is-open="opened" min-date="'01-01-2000'" max-date="'22-06-2025'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" data-ng-focus="listSorting();open($event)"/>
                      <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
					</th>
					<th class="hidden-xs hidden-sm" ng-controller="empstatusdropCntrl">
						<select class="form-control SlectBox selectdrop" placeholder="Status" name="status" ng-model="status" data-ng-change="listSorting()">
							<option value="" style="display:none">Status</option>
							<option ng-repeat="status in statusDrop" value="{{status.name}}">{{status.name}}</option>
							<option ng-if="statusDrop.length==0">No Records</option>
						</select>
					</th>
                  </tr>
                </thead>
              </table>
              <div class="div-table-content">
                <table class="table table-condensed table-hover">
                  <tbody>
                    <tr class="tktBackground" ng-repeat="(key,data) in datas.usertrackingMulDetails">
                      <td ng-click="usertrackingview(data.employee_alias); usermapPlots(data.employee_alias);">{{data.employee_id}}</td>
					  <td><span tooltip-placement="top" tooltip="{{data.name}}">{{data.name | limitTo:30}}{{data.name.length > 30 ? '...':''}}</span></td>
                      <td class="hidden-xs">{{data.designation}}</td>
                      <td>{{data.date_time}}</td>
                      <td class="hidden-xs hidden-sm">{{data.status}}</td>
                    </tr>
                  </tbody>
                  <tfoot ng-if="datas.usertrackingMulDetails.length=='0'">
                    <tr>
                      <td>No Records</td>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <!-- #end data table   ng-style="key=='0' && {'background-color':'#eaeff3'}"  -->
              <div class="panel-footer clearfix" ng-if="datas.usertrackingMulDetails.length!='0'">
                <div class="col-md-4">
                  <p class="left small" style="margin:0px !important;">Showing {{datas.fromRecords}} to {{datas.toRecords}} of {{datas.totalRecords}} entries</p>
                </div>
                <div class="col-md-4">
                  <div class="small text-bold right ml15"> <span class="control-label">Page No. </span>
                    <select class="form-control page-count"  name="page_no" ng-model="page_no" data-ng-change="listSorting()">
                      <option value="" style="display:none">1</option>
                      <option ng-repeat="pagess in datas.pages" ng-show="$index >0" value="{{pagess}}">{{pagess}}</option>
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
            </form>
          </div>
        </div>
      </div>
      <!-- #end row --> 
    </div>
   <div id="ticketviesw">
    <div class="site-settings ticketviesw clearfix  col-xs-6 floating-sidebar" ng-class="{'open': usertracking_open}">
      <div class="sidebar-wrap text-uppercase mt46">
        <div class="group clearfix head tkt-heading2">
          <div class="left"> <span class="ion ion-close-round mr10 tktviewClose" ng-click="removeusertrackingView()"></span> <span><strong>{{singleViews.name}}</strong></span></div>
        </div>
        <tabset justified="true" class="tabs-linearrow">
          <tab>
              <tab-heading>History</tab-heading>
              <div class="clearfix tabing-panel">
                <div class="info-tab tab clearfix panel-body">
                  <div class="row tkt-panel">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <h6>Employee Id</h6>
                      <span class="fnt-size-11">{{singleViews.employee_id}}</span> </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <h6>Employee Name</h6>
                      <span class="fnt-size-11">{{singleViews.name}}</span> </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <h6>Last Login Date</h6>
                      <span class="fnt-size-11">{{singleViews.date_time}}</span> </div>
                  </div>
                  <div class="row">
                    <div class="panel panel-lined table-responsive panel-hovered mb10" style="" >
                      <ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
                        <li><a class="padding-10">User Tracking History</a></li>
                      </ol>
                        <ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;">
	                        <li><a style="cursor:pointer" ng-click="usertrackingexport(singleViews.employee_alias)" class="padding-10 export-btn">Export</a></li>
                        </ol>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="panel panel-lined table-responsive panel-hovered">
                        <div class="panel panel-default">
                          <form class="form-horizontal forms_single" url="services/usertracking/usertracking_history" name="historyForm" method="post" novalidate>
                            <table class="table table-condensed" >
                              <thead>
                                <tr>
                                  <th>History</th>
                                  <th>Login Details</th>
                                </tr>
                              </thead>
                            </table>
                            <table class="table table-condensed table-hover">
                              <tbody>
                                <tr class="tktBackground" ng-repeat="data in datasingle.usertrackingDetails">
                                  <td>{{data.action}}</td>
                                  <td>{{data.date_time}}</td>
                                </tr>
                              </tbody>
                              <tfoot ng-if="datasingle.usertrackingDetails.length=='0'">
                                <tr>
                                  <td>No Records</td>
                                </tr>
                              </tfoot>
                            </table>
                            <div class="panel-footer clearfix" ng-if="datasingle.usertrackingDetails.length!='0'">
                              <div class="col-md-4">
                                <p class="left small" style="margin:0px !important;">Showing {{datasingle.fromRecords}} to {{datasingle.toRecords}} of {{datasingle.totalRecords}} entries</p>
                              </div>
                              <div class="col-md-4">
                                <div class="small text-bold right ml15"> <span class="control-label">Page No. </span>
                                  <select class="form-control page-count"  name="page_no" ng-model="selectt.id" data-ng-change="historySorting(singleViews.employee_alias)">
                                    <option value="" style="display:none">1</option>
                                    <option ng-repeat="pagess in datasingle.pages" ng-show="$index >0" value="{{pagess}}">{{pagess}}</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="small text-bold right ml15"> <span class="control-label">Count per page</span>
                                  <select class="form-control page-count" name="perpagecount" ng-model="selectt.ids" data-ng-change="historySorting(singleViews.employee_alias)">
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
          </tab>
          <tab data-ng-click="usermapPlots(singleViews.employee_alias)">
              <tab-heading><span style="display:block">Location</span></tab-heading>
              <div class="chat-tab tab clearfix">
                <div>
                    <div class="col-md-12 form-group mt10" ng-controller="DatepickerDemoCtrl">
                        <input type="text" ng-model="periodto" name="mapdatesort" class="form-control" placeholder="Select Date.." datepicker-popup="{{format}}" ng-click="open($event)" ng-model="dt" is-open="opened" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false" data-ng-focus="usermapPlots(singleViews.employee_alias);open($event)"/>
                    </div>
                  <div id="map"></div>
                    <div id="class" ng-repeat="marker in markers | orderBy : 'title'">
                    </div>
                </div>
              </div>
          </tab>
        </tabset>
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
		setInterval(function(){$('.SlectBox').SumoSelect();},0);
	});
</script>