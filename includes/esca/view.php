<style>.profilepic-view img{border-radius:100%; border:2px solid #eee; width:50px; height:50px;}</style>
<div class="page page-ui-extras" ng-controller="ModalDemoCtrl">
<div ng-controller="EmployeeMasterEscaCtrl">
<div ng-controller="mul_view_form">
		<div class="panel panel-lined table-responsive panel-hovered mb10">
            <ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
                <li><a href="#/dashboard" class="padding-10">Home</a></li>
                <li><a href="" class="padding-10">Employee Master</a></li>
            </ol>
            <ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;">
                <li><a href="" ng-click="employeexportOpen()" class="padding-10 export-btn">Export</a></li>
            </ol>
       </div>
		<!-- row -->
		<div class="row">
			<!-- Data Table -->
			<div class="col-md-12 table-height">
            <div class="panel panel-lined table-responsive panel-hovered">
            <div class="panel panel-default">
             <form class="form-horizontal forms_ec" url="services/esca/employeemaster_mul_view" name="userForm" method="post" novalidate>
                <table class="table table-condensed" >
                        <thead>
                        <tr>
                            <th>
                                <a class="tktid">Employee ID&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden" name="employeeId" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                            <th>
                                <a class="tktid">Employee Name&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden form-control" name="name" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                            <th>
                                <a class="tktid">Designation&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden form-control" name="designation" placeholder="Type keyword"data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                            
                             <th class="hidden-xs hidden-sm" ng-controller="selectZoneCntrl">
                                <select name="zoneAlias" placeholder="Zones" class="SlectBox form-control" ng-model="selectt.id" data-ng-change="listSorting()">
                                    <option value="" style="display:none">Zones</option>
                                    <option ng-repeat="zones in firstDrop" value="{{zones.alias}}" ng-if="zone.alias!='4VTSNSSBM9'">{{zones.name}}</option>
                                    <option ng-if="firstDrop.length==0">No Records</option>
                                </select>
                            </th>
                            
                            <th class="hidden-xs hidden-sm">
                                <a class="tktid">Employee Role&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden form-control" name="roleName" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                            
                           <th class="hidden-xs hidden-sm">
                                <a class="tktid">Login Email ID&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden form-control" name="loginId" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                              <th class="hidden-xs hidden-sm">
                                <a class="tktid">Contact Number&nbsp;<span class="arrow caret"></span></a>
                                <input type="text" class="droptxt1 hidden form-control" name="mobileNumber" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                            </th>
                        </tr>
                        </thead>
                    </table>
                    <div class="div-table-content">
                        <table class="table table-hover">
                            <tbody>
                               <tr class="tktBackground" ng-repeat="data in datas.employeemasterDetails">
                                    <td ng-click="employeemaster(data.employee_alias)"><span tooltip-placement="top" tooltip="Click to know details of {{data.employee_id}}">{{data.employee_id}}</span></td>
                                    <td>{{data.name}}</td>
                                    <td>{{data.designation}}</td>
                                    <td class="hidden-xs hidden-sm">{{data.zone_name}}</td>
                                    <td class="hidden-xs hidden-sm">{{data.role_name}}</td>
                                    <td class="hidden-xs hidden-sm">{{data.email_id}}</td>
                                    <td class="hidden-xs hidden-sm">{{data.mobile_number}}</td>
                                </tr>
                            </tbody>
                            <tfoot ng-if="datas.employeemasterDetails.length=='0'"><tr><td>No Records</td></tr></tfoot>
                        </table>
                        </div>
                        <!-- #end data table -->	
                         <div class="panel-footer clearfix" ng-if="datas.employeemasterDetails.length!='0'">
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
</div>
<div id="ticketviesw">
	<div class="site-settings ticketviesw clearfix  col-xs-6 floating-sidebar" ng-class="{'open': employeeMaster_open}">
        <div class="sidebar-wrap text-uppercase mt47">
                <div class="group clearfix head tkt-heading2">
                    <div class="left">
                    <span class="ion ion-close-round mr10 tktviewClose" ng-click="removeemployeeMaster()"></span>
                        <span><strong>{{singleViews.employee_id}}</strong></span>
                    </div>
                    <div class="right">
                        <div class="btn-group btn-group-sm" ng-controller="ModalDemoCtrl">
                            <a href="services/employeemaster/employeemaster_print.php?alias={{singleViews.employee_alias}}" tooltip="Print" class="ml10" tooltip tooltip-placement="bottom"><span class="ion ion-android-print"></span></a>
                            <a href="services/employeemaster/employeemaster_download.php?alias={{singleViews.employee_alias}}" target="_blank" tooltip="Download" class="ml10" tooltip tooltip-placement="bottom"><span class="ion ion-android-download"></span></a>
                        </div>
                    </div>
                </div>
            	<div class="panel-body clearfix freez-panel">
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Employee ID</h6>
                          <span class="fnt-size-11">{{singleViews.employee_id}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Employee Name</h6>
                          <span class="fnt-size-11">{{singleViews.name}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Grade</h6>
                          <span class="fnt-size-11">{{singleViews.grade}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Designation</h6>
                          <span class="fnt-size-11">{{singleViews.designation}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Department</h6>
                          <span class="fnt-size-11">{{singleViews.department_name}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Email ID</h6>
                          <span class="fnt-size-11">{{singleViews.email_id}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Mobile No</h6>
                          <span class="fnt-size-11">{{singleViews.mobile_number}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Zones</h6>
                          <span class="fnt-size-11">{{singleViews.zone_name}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>State</h6>
                          <span class="fnt-size-11">{{singleViews.state_name}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Wh Code</h6>
                          <span class="fnt-size-11">{{singleViews.wh_code}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Base Location</h6>
                          <span class="fnt-size-11">{{singleViews.base_location}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Employee Role</h6>
                          <span class="fnt-size-11">{{singleViews.role_name}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Qualification</h6>
                          <span class="fnt-size-11">{{singleViews.qualification}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Specialization</h6>
                          <span class="fnt-size-11">{{singleViews.specialization}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Joining Date</h6>
                          <span class="fnt-size-11">{{singleViews.joining_date}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Relieving Date</h6>
                          <span class="fnt-size-11">{{singleViews.relieving_date}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Asset Type</h6>
                          <span class="fnt-size-11">{{singleViews.asset_type}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Asset Name</h6>
                          <span class="fnt-size-11">{{singleViews.asset_name}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Asset Make</h6>
                          <span class="fnt-size-11">{{singleViews.asset_make}}</span>
                        </div>
                    	<div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Asset Serial Number</h6>
                          <span class="fnt-size-11">{{singleViews.asset_serial_number}}</span>
                        </div>
                    	<div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Status</h6>
                          <span class="fnt-size-11">{{singleViews.status}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Total Experience</h6>
                          <span class="fnt-size-11">{{singleViews.total_experience}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>EL Experience</h6>
                          <span class="fnt-size-11">{{singleViews.el_experience}}</span>
                        </div>
						<div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>privilege</h6>
                          <span class="fnt-size-11">{{singleViews.privilege_name}}</span>
                        </div>
                    </div>
                    <div class="row tkt-panel">
                       <!--<div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Profilepic</h6>
                          <span class="profilepic-view">
                          	<img src="{{singleViews.profile_pic}}" width="38" height="38" alt="admin">
                          </span>
                        </div>-->
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <h6>Created Date</h6>
                          <span class="fnt-size-11">{{singleViews.created_date}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4" ng-if="singleViews.noc != ''">
                          <h6>NOC</h6>
                          <span class="fnt-size-11"><a href="images/reports/{{singleViews.noc}}">Click Here</a></span>
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