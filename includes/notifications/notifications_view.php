<style>.well{padding:10px; margin-bottom:0px;}</style>
<div class="page page-ui-extras" ng-controller="mul_view_form">
    <div class="panel panel-lined table-responsive panel-hovered mb10" style="" >
        <ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
            <li><a href="#/dashboard" class="padding-10">Home</a></li>
            <li><a href="" class="padding-10">Notifications</a></li>
        </ol>
    </div>
    <form class="form-horizontal forms_ec" url="services/notifications/notifications_view" name="userForm" method="post" novalidate>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-default panel-hovered panel-stacked">
                <div class="panel-heading">List Of Notifications</div>
                <div class="panel-body notifi_page_view">
                    <div class="list-group mb10" ng-repeat="notif in datas.notification">
                        <a href="javascript:;" class="list-group-item" ng-init="isCollapsed=true">
                            <span class="ion ion-android-person left bg-primary pad-12 mr10" ng-if="notif.type_ref=='2'"></span>
                            <span class="ion ion-monitor left bg-info pad-12 mr10" ng-if="notif.type_ref=='1'"></span>
                            <span class="fa fa-cubes left bg-info pad-12 mr10" ng-if="notif.type_ref!='1' && notif.type_ref!='2'"></span>
                            <strong class="text-info">{{notif.title}}</strong>
                            <!--<span class="small text-uppercase right fnt-10" style="color:#FF0000" ng-if="notif.type_ref!='2'">{{notif.level}}</span><br />-->
							<span class="small text-uppercase right fnt-10" tooltip-placement="left" ng-style="{color : ((notif.type_ref=='2') && '#2196f3') || '#FF0000'}" ng-attr-tooltip="{{notif.type_ref=='2' && datas.collapse ? 'Click Here' : ''}}" ng-click="isCollapsed = (notif.type_ref=='2' ? !isCollapsed : isCollapsed)">{{notif.level}}</span><br />
                            <span class="small text-uppercase fnt-10" ng-if="notif.type_ref!='2'">{{notif.message}}</span>
							<span class="small text-uppercase fnt-10" ng-if="notif.type_ref=='2'">{{notif.message_full}}</span>
                            <span class="small text-uppercase right fnt-10">{{notif.created_date_time}}</span><br />
                            <span class="small text-uppercase fnt-10" ng-if="notif.type_ref=='1'">{{notif.complaint}}</span>
                            <div collapse="isCollapsed" class="mt10" ng-if="datas.collapse">
                                <div class="well well-large"><ul><li type="1" ng-repeat="emp in notif.emp_name">{{emp}}</li></ul></div> 
                            </div>
                        </a>
                    </div>
                </div> 
                <div class="panel-footer clearfix" ng-if="datas.notification.length!='0'">
                  <div class="col-md-4">
                    <p class="left small" style="margin:0px !important;">Showing {{datas.fromRecords}} to {{datas.toRecords}} of {{datas.totalRecords}} entries</p>
                  </div>
                  <div class="col-md-4">
                    <div class="small text-bold right ml15"> <span class="control-label">Page No. </span> 
                      <select class="form-control page-count" name="page_no" ng-model="selectt.id" data-ng-change="listSorting()">
                        <option value="" style="display:none">1</option>
                        <option ng-repeat="pagess in datas.pages" ng-show="$index > 0" value="{{pagess}}">{{pagess}}</option>
                      </select> 
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="small text-bold right ml15"> <span class="control-label">Count per page</span>
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
            </div> 
        </div>
    </div> 
  </form>
</div>