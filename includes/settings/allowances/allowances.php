<style>
.allowList{margin-bottom:0px !important;}
.allowList li a{color:#2b387c; padding:13px 20px;}
.page-dashboard .list-widget ul > li{padding:0px !important;}
</style>
<div class="page page-dashboard" ng-controller="settingscountCtrl">
    <div class="panel panel-default list-widget">
        <ul class="list-unstyled clearfix allowList">
            <li>
            	<a href="#/Service-allowances" ng-click="modalClose()">
                    <span class="text"><b>Services</b></span>
                    <span class="badge badge-xs badge-primary right">{{singleViews.services_count}}</span>
                </a>
            </li>
            <li>
            	<a href="#/Others-allowances" ng-click="modalClose()">
                    <span class="text"><b>Others</b></span>
                    <span class="badge badge-xs badge-info right">{{singleViews.others_count}}</span>
                </a>
            </li>
        </ul>
    </div>
</div>