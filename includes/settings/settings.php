<style>
	.center{text-align:center !important;}
	.panel-footer-success, .panel-footer-primary,.panel-footer-info,
	.panel-footer-pink, a{color:#fff;  display:block;}
	.add{font-size: 12px; padding:8px 22px;}
	.add span{font-size: 12px; margin-right:5px;}
	 h6{font-size:11px;}
	.txt-color{color:#4f4f4f;}
	.padding-none{padding:0px;}
	.padding-none:hover {position: relative;overflow: hidden;-webkit-transition: box-shadow .4s;-moz-transition: box-shadow .4s;-ms-transition: box-shadow .4s; -o-transition: box-shadow .4s;transition: box-shadow .4s;cursor: inherit;}
	.padding-none :hover{ background: rgba(243, 243, 243, 0.3);}
	#portfolio-sort {text-align: center; margin-bottom: 1em;margin-top:75px;}
	#portfolio-sort a{color:#3f51b5; background-color:#fff;}
	#portfolio-sort a:hover{border-bottom:2px solid #3f51b5; color:#3f51b5;}
	#portfolio-sort a.active{border-bottom:2px solid #3f51b5; color:#3f51b5; box-shadow:none !important;}
	#portfolio-content { overflow: hidden;margin-top:30px;}
</style>
<div id="portfolio" ng-controller="settingscountCtrl">
<div id="portfolio-sort" ng-controller="leftMenuCtrl">
    <a href class="btn btn-sm text-bold" md-ink-ripple id="all">ALL</a>
    <a href class="btn btn-sm text-bold" md-ink-ripple data-cat="a" ng-show="menuitems.setting_show && (singleViews.activity_view || singleViews.bucket_view || singleViews.complaint_view || singleViews.customer_view || singleViews.district_view || singleViews.dpr_view || singleViews.faulty_view || singleViews.levels_view || singleViews.moc_view || singleViews.segment_view || singleViews.sitetype_view || singleViews.state_view || singleViews.shift_view || singleViews.zone_view)">TICKETS</a>
    <a href class="btn btn-sm text-bold" md-ink-ripple data-cat="b" ng-show="menuitems.setting_show && (singleViews.assets_view || singleViews.department_view || singleViews.designation_view || singleViews.emprole_view || singleViews.milestone_view || singleViews.privileges_view)">EMPLOYEE MASTER</a>
    <a href class="btn btn-sm text-bold" md-ink-ripple data-cat="c" ng-show="menuitems.setting_show && (singleViews.accessories_view || singleViews.dynamic_level_view || singleViews.product_view || singleViews.stock_view || singleViews.warehouse_view)">INVENTORY</a>
	<a href class="btn btn-sm text-bold" md-ink-ripple data-cat="d" ng-show="menuitems.setting_show && (singleViews.allowances_view || singleViews.approvers_view || singleViews.limits_view)">EXPENSE</a>
	<a href class="btn btn-sm text-bold" md-ink-ripple data-cat="e" ng-show="menuitems.setting_show && (singleViews.changelog_view || singleViews.dropdown_view || singleViews.manuals_view || singleViews.privacy_view || singleViews.work_guide_view)">MOBILE APP</a>
</div>
<div class="page page-dashboard" ng-controller="DashboardCtrl" id="portfolio-content">
	<div class="page-wrap" ng-controller="ModalDemoCtrl">
		<!-- mini boxes -->
		<div ng-controller="leftMenuCtrl">
		<div class="row"  ng-if="menuitems.setting_show">
        <div class="portfolio-item" data-cat="c" ng-if="singleViews.accessories_view">
            <div class="col-md-3 col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.accessories_view, '#/settings/accessories/accessories_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">ACCESSORIES</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.accessories_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                           <a href class="mt0 mb0 add" ng-click="checkAddOption('accessories', singleViews.accessories_add);"><span class="ion ion-plus"></span> Add </a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
        <div class="portfolio-item" data-cat="a" ng-if="singleViews.activity_view">
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.activity_view, '#/settings/activity/activity_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">ACTIVITY</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.activity_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a ng-click="redirectTo(singleViews.activity_view, '#/settings/activity/activity_view')" href="javascript:void(0)" class="mt0 mb0 add"><span class="ion ion-eye"></span>View</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
            
        <div class="portfolio-item" data-cat="d" ng-if="singleViews.allowances_view">
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a href="" ng-click="allowancesOpen()">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">ALLOWANCES</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.services_count + singleViews.others_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a href class="mt0 mb0 add" ng-click="allowancesOpen()"><span class="ion ion-eye"></span>View</a>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="portfolio-item" data-cat="d" ng-if="singleViews.approvers_view">
                <div class="col-md-3 col-lg-2 col-sm-6">
                <a href="#/approvers">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">APPROVERS</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.approvers_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a ng-click="redirectTo(singleViews.approvers_view, '#/approvers')" href="javascript:void(0)" class="mt0 mb0 add"><span class="ion ion-eye"></span>View</a>
                        </div>
                    </div>
                    </a>
            </div>
        </div>
        
        <div class="portfolio-item" data-cat="b" ng-if="singleViews.assets_view">
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.assets_view, '#/settings/assets/assets_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">ASSETS</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.assets_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a href class="mt0 mb0 add" ng-click="checkAddOption('assets', singleViews.assets_add);"><span class="ion ion-plus"></span>Add</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
        <div class="portfolio-item" data-cat="a" ng-if="singleViews.bucket_view">
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.bucket_view, '#/settings/buckets/bucket_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">BUCKETS</h6>
                                    <h6 class="text-light mb0 txt-color ">Count : <b>{{singleViews.bucket_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
							<a ng-click="redirectTo(singleViews.bucket_view, '#/settings/buckets/bucket_view')" href="javascript:void(0)" class="mt0 mb0 add"><span class="ion ion-eye"></span>View</a>
                        </div>
                    </div>
                  </a>
            </div>
         </div>
		
		<div class="portfolio-item" data-cat="e" ng-if="singleViews.changelog_view">
            <div class="col-md-3 col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.changelog_view, '#/settings/mobile_app/changelog_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">CHANGE LOG</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.changelog_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a href class="mt0 mb0 add" ng-click="checkAddOption('changelog', singleViews.changelog_add);"><span class="ion ion-plus"></span>Add</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
        <div class="portfolio-item" data-cat="a" ng-if="singleViews.complaint_view">
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.complaint_view, '#/settings/complaint/complaint_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">COMPLAINT</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.complaint_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a href class="mt0 mb0 add" ng-click="checkAddOption('complaint', singleViews.complaint_add);"><span class="ion ion-plus"></span>Add</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
        <div class="portfolio-item" data-cat="a" ng-if="singleViews.customer_view">
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.customer_view, '#/settings/customer/customer_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">CUSTOMER</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.customer_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a href class="mt0 mb0 add" ng-click="checkAddOption('customer', singleViews.customer_add);"><span class="ion ion-plus"></span>Add</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>           
        <div class="portfolio-item" data-cat="b" ng-if="singleViews.department_view">
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.department_view, '#/settings/department/department_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">DEPARTMENT</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.department_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a href class="mt0 mb0 add" ng-click="checkAddOption('department', singleViews.department_add);"><span class="ion ion-plus"></span>Add</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>            
        <div class="portfolio-item" data-cat="b" ng-if="singleViews.designation_view">
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.designation_view, '#/settings/designation/designation_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">DESIGNATION</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.designation_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a href class="mt0 mb0 add" ng-click="checkAddOption('designation', singleViews.designation_add);"><span class="ion ion-plus"></span>Add</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>           
        <div class="portfolio-item" data-cat="a" ng-if="singleViews.district_view">
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.district_view, '#/settings/district/district_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">DISTRICT</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.district_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a href class="mt0 mb0 add" ng-click="checkAddOption('district', singleViews.district_add);"><span class="ion ion-plus"></span>Add</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
		
		<div class="portfolio-item" data-cat="e" ng-if="singleViews.dropdown_view">
            <div class="col-md-3 col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.dropdown_view, '#/settings/mobile_app/tree_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">DROP DOWNS</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.tree_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a ng-click="redirectTo(singleViews.dropdown_view, '#/settings/mobile_app/tree_view')" href="javascript:void(0)" class="mt0 mb0 add"><span class="ion ion-eye"></span>View</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
        <div class="portfolio-item" data-cat="a" ng-if="singleViews.dpr_view">
            <div class="col-md-3 col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.dpr_view, '#/settings/dpr/dpr_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">DPR CATEGORY</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.dpr_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a href class="mt0 mb0 add" ng-click="checkAddOption('dpr', singleViews.dpr_add);"><span class="ion ion-plus"></span>Add</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
        <div class="portfolio-item" data-cat="c" ng-if="singleViews.dynamic_level_view">
            <div class="col-md-3 col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.dynamic_level_view, '#/settings/dynamiclevel/dynamic_level_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">DYNAMIC LEVELS</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.dynamic_level_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple ng-controller="dynamiclevelprivilagesorderdropCntrl">
                            <a href class="mt0 mb0 add" ng-click="checkAddOption('dynamic_level', singleViews.dynamic_level_add, firstDrop.privilege.length);"><span class="ion ion-plus"></span>Add</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
        <div class="portfolio-item" data-cat="b" ng-if="singleViews.email_sms_view">
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.email_sms_view, '#/settings/email_sms_recipient/view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">EMAIL & SMS RECIPIENT</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.email_sms_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a href class="mt0 mb0 add" ng-click="redirectTo(singleViews.email_sms_view, '#/settings/email_sms_recipient/view')"><span class="ion ion-eye"></span>View</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
        <div class="portfolio-item" data-cat="b" ng-if="singleViews.emprole_view">
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.emprole_view, '#/settings/emprole/employeerole_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">EMPLOYEE ROLE</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.emprole_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a href class="mt0 mb0 add" ng-click="redirectTo(singleViews.emprole_view, '#/settings/emprole/employeerole_view')"><span class="ion ion-eye"></span>View</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
            
        <div class="portfolio-item" data-cat="all" ng-if="singleViews.esca_view">
             <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.esca_view, '#/settings/esca/esca_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">ESCA</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.esca_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a href class="mt0 mb0 add" ng-click="checkAddOption('esca', singleViews.esca_add);"><span class="ion ion-plus"></span>Add</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
            
        <div class="portfolio-item" data-cat="a" ng-if="singleViews.faulty_view">
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.faulty_view, '#/settings/faultycode/faultcode_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">FAULTY CODE</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.faulty_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a href class="mt0 mb0 add" ng-click="checkAddOption('faulty', singleViews.faulty_add);"><span class="ion ion-plus"></span>Add</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
            
        <div class="portfolio-item" data-cat="a" ng-if="singleViews.levels_view">
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.levels_view, '#/settings/levels/levels_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">LEVELS</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.levels_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a ng-click="redirectTo(singleViews.levels_view, '#/settings/levels/levels_view')" href="javascript:void(0)" class="mt0 mb0 add"><span class="ion ion-eye"></span>View</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
		
        <div class="portfolio-item" data-cat="d" ng-if="singleViews.limits_view">
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a href="#/limits">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">LIMITS</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.limits_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a ng-click="redirectTo(singleViews.limits_view, '#/limits')" href="javascript:void(0)" class="mt0 mb0 add"><span class="ion ion-eye"></span>View</a>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="portfolio-item" data-cat="e" ng-if="singleViews.manuals_view">
             <div class="col-md-3 col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.manuals_view, '#/settings/mobile_app/manuals_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">MANUALS</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.manuals_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a ng-click="redirectTo(singleViews.manuals_view, '#/settings/mobile_app/manuals_view')" href="javascript:void(0)" class="mt0 mb0 add"><span class="ion ion-eye"></span>View</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
		
        <div class="portfolio-item" data-cat="b" ng-if="singleViews.milestone_view">
             <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.milestone_view, '#/settings/milestone/milestone_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">MILESTONE</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.milestone_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                           <a href class="mt0 mb0 add" ng-click="checkAddOption('milestone', singleViews.milestone_add);"><span class="ion ion-plus"></span> Add </a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
         
         <div class="portfolio-item" data-cat="a" ng-if="singleViews.moc_view">
             <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.moc_view, '#/settings/moc/moc_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">MOC</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.moc_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                           <a href class="mt0 mb0 add" ng-click="checkAddOption('moc', singleViews.moc_add);"><span class="ion ion-plus"></span> Add </a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
         <div class="portfolio-item" data-cat="e" ng-if="singleViews.privacy_view">
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a href ng-click="privacyviewOpen()">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">PRIVACY & POLICY</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>1</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                           <a href class="mt0 mb0 add" ng-click="checkAddOption('privacy', singleViews.privacy_edit);"><span class="ion ion-plus"></span> Edit </a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
        <div class="portfolio-item" data-cat="b" ng-if="singleViews.privileges_view">
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.privileges_view, '#/settings/privilages/privilages_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">PRIVILAGES</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.privileges_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a href class="mt0 mb0 add" ng-click="checkAddOption('privileges', singleViews.privileges_add);"><span class="ion ion-plus"></span>Add</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
		
        <div class="portfolio-item" data-cat="c" ng-if="singleViews.product_view">
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.product_view, '#/settings/product/product_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">PRODUCT</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.product_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a href class="mt0 mb0 add" ng-click="checkAddOption('product', singleViews.product_add);"><span class="ion ion-plus"></span>Add</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
            
        <div class="portfolio-item" data-cat="a" ng-if="singleViews.segment_view">
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.segment_view, '#/settings/segment/segment_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">SEGMENT</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.segment_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a ng-click="redirectTo(singleViews.segment_view, '#/settings/segment/segment_view')" href="javascript:void(0)" class="mt0 mb0 add"><span class="ion ion-eye"></span>View</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
            
        <div class="portfolio-item" data-cat="a" ng-if="singleViews.sitetype_view">
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.sitetype_view, '#/settings/sitetype/sitetype_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">SITE TYPE</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.sitetype_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a href class="mt0 mb0 add" ng-click="checkAddOption('sitetype', singleViews.sitetype_add);"><span class="ion ion-plus"></span>Add</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
        <div class="portfolio-item" data-cat="a" ng-if="singleViews.state_view">       
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.state_view, '#/settings/state/state_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">STATE</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.state_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a href class="mt0 mb0 add" ng-click="checkAddOption('state', singleViews.state_add);"><span class="ion ion-plus"></span>Add</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
            
        <div class="portfolio-item" data-cat="c" ng-if="singleViews.stock_view">
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.stock_view, '#/settings/stockcode/stockcode_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">STOCK CODE</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.stock_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a ng-click="redirectTo(singleViews.stock_view, '#/settings/stockcode/stockcode_view')" href="javascript:void(0)" class="mt0 mb0 add"><span class="ion ion-eye"></span>View</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
        <div class="portfolio-item" data-cat="a" ng-if="singleViews.shift_view">
            <div class="col-md-3 col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.shift_view, '#/settings/shift/shift_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">SHIFT</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.shift_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a href class="mt0 mb0 add" ng-click="checkAddOption('shift', singleViews.shift_add);"><span class="ion ion-plus"></span>Add</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
        <div class="portfolio-item" data-cat="c" ng-if="singleViews.warehouse_view">
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.warehouse_view, '#/settings/warehouse/warehouse_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">WAREHOUSE</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.warehouse_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a href class="mt0 mb0 add" ng-click="checkAddOption('warehouse', singleViews.warehouse_add);"><span class="ion ion-plus"></span>Add</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
		<div class="portfolio-item" data-cat="e" ng-if="singleViews.work_guide_view">
            <div class="col-md-3 col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.work_guide_view, '#/settings/mobile_app/workguide_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">WORK GUIDE</h6>
                                    <h6 class="text-light mb0 txt-color">Count : <b>{{singleViews.work_guide_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a href class="mt0 mb0 add" ng-click="checkAddOption('work_guide', singleViews.work_guide_add);"><span class="ion ion-plus"></span>Add</a>
                        </div>
                    </div>
                  </a>
            </div>
        </div>
		
        <div class="portfolio-item" data-cat="a" ng-if="singleViews.zone_view">
            <div class="col-md-3  col-lg-2 col-sm-6">
                <a ng-click="redirectTo(singleViews.zone_view, '#/settings/zone/zone_view')" href="javascript:void(0)">
                    <div class="panel panel-default mb20 mini-box panel-hovered">
                        <div class="panel-body center" md-ink-ripple>
                            <div class="clearfix">
                                <div class="info">
                                    <h6 class="mt0 text-primary text-bold">ZONE</h6>
                                    <h6 class="text-light mb0 txt-color ">Count : <b>{{singleViews.zone_count}}</b></h6>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix panel-footer-sm panel-footer-primary center padding-none" md-ink-ripple>
                            <a href class="mt0 mb0 add" ng-click="checkAddOption('zone', singleViews.zone_add);"><span class="ion ion-plus"></span>Add</a>
                        </div>
                    </div>
                  </a>
            </div>
         </div>
			<!-- #end mini boxes -->
		</div> <!-- #end row -->
		</div>
        
	</div> <!-- #end page-wrap -->
</div>
</div>
<script>
$(function(){
var Portfolio = {
    sort: function(items) {
        items.show();
        $('#portfolio-content').find('div.portfolio-item').not(items).fadeOut(500);
    },
    showAll: function(items) {items.fadeIn(500);},
    doSort: function() {
        $('a', '#portfolio-sort').on('click', function() {
            var $a = $(this);
			$('#portfolio-sort a').removeClass('active');
			$a.addClass('active');
            if (!$a.is('#all')) {
                var items = $('div[data-cat=' + $a.data('cat') + ']', '#portfolio-content');
                Portfolio.sort(items);
            } else {
                Portfolio.showAll($('div.portfolio-item', '#portfolio-content'));
            }
        });
    }
};
Portfolio.doSort();
});
</script>