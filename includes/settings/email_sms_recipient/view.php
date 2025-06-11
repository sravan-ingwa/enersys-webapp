<div class="page page-ui-extras" ng-controller="ModalDemoCtrl">
    <div ng-controller="emailAndSmsRecipientCtrl">
        <div class="panel panel-lined table-responsive panel-hovered mb10" style="">
            <ol class="breadcrumb breadcrumb-small left" style="margin-bottom:0px;">
                <li><a href="#/dashboard" class="padding-10">Home</a></li>
                <li><a href="#/settings" class="padding-10">Settings</a></li>
                <li><a href="" class="padding-10">Email & SMS Recipient</a></li>
            </ol>
             <ol class="breadcrumb breadcrumb-small right" style="margin-bottom:0px;">
                <li><a href="exports/{{singleViews.file_name}}.xlsx" ng-click="email_sms_export()" class="padding-10 export-btn" ng-if="export">Export</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-md-12 table-height">
                <div class="panel panel-lined table-responsive panel-hovered">
                    <div class="panel panel-default text-uppercase" ng-controller="mul_view_form">
                     <form class="form-horizontal forms_ec" url="services/settings/email_sms_recipient_mul_view" name="userForm" method="post" novalidate>
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th>
                                        <a class="tktid">When<span class="arrow caret"></span></a>
                                        <input type="text" class="droptxt1 hidden" name="entity_label" ng-model="entity_label" style="display:block; border:none; color:#000;" placeholder="Type keyword" data-ng-keyup="listSorting()">
                                        <span class="ion ion-ios-close-outline inptClose hidden" data-ng-click="listSorting()"></span>
                                    </th>
                                    <th>
                                        <select name="communication_type" placeholder="Communication Type" class="SlectBox form-control" ng-model="communication_type" ng-change="listSorting()">
                                            <option value="" style="display:none">Communication Type</option>
                                            <option value="sms">SMS</option>
                                            <option value="email">E-MAIL</option>
                                        </select>
                                    </th>
                                    <th ng-controller="privilagesdropCntrl">
                                        <select name="send_to" placeholder="TO : Users Notified" class="SlectBox form-control" ng-model="send_to" data-ng-change="listSorting()">
                                            <option value="" style="display:none">TO : Users Notified</option>
                                            <option ng-repeat="selectlist in firstDrop" value="{{selectlist.alias}}">{{selectlist.name}}</option>
                                            <option ng-if="firstDrop.length==0">No Records</option>
                                        </select>
                                    </th>
                                    <th ng-controller="privilagesdropCntrl">	
                                        <select name="send_cc" placeholder="CC : Users Notified" class="SlectBox form-control" ng-model="send_cc" data-ng-change="listSorting()">
                                            <option value="" style="display:none">CC : Users Notified</option>
                                            <option ng-repeat="selectlist in firstDrop" value="{{selectlist.alias}}">{{selectlist.name}}</option>
                                            <option ng-if="firstDrop.length==0">No Records</option>
                                        </select>
                                    </th>
                                    <th class="hidden-xs hidden-sm" >
                                        <select class="form-control SlectBox selectdrop" placeholder="Status" name="status" ng-model="status" data-ng-change="listSorting()">
                                            <option value="" style="display:none">Action</option>
                                            <option value="deactivate">Deactivated</option>
                                            <option value="active">Active</option>
                                        </select>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                        <div class="div-table-content">
                            <table class="table table-condensed table-hover">
                                <tbody>
                                    <tr class="tktBackground" ng-repeat="data in datas.details">
                                        <td ng-click="email_sms_recipientview(data.alias)"><span tooltip-placement="top" tooltip="Click to know details of {{data.entity_label}}">{{data.entity_label}}</span></td>
                                        <td>{{data.communication_type}}</td>
                                        <td>{{data.send_to_name}}</td>
                                        <td>{{data.send_cc_name}}</td>
                                        <td class="hidden-xs hidden-sm">
                                            <a href="" class="ml3" tooltip="Advance Edit" tooltip-placement="bottom" ng-click="setSettingsAlias(data.alias);email_sms_recipientOpen();" ng-if="datas.edit">
                                                <span class="fa fa-spl-edit"></span>
                                            </a>
                                          <a href="javascript:void(0)" class="ml3" tooltip="Deactivate" tooltip-placement="bottom" 
                                            ng-if="datas.delete && data.flag == '0'" ng-click="smsEmailDeleteOpen(data);" >
                                            <span class="fa fa-ban"></span>
                                          </a>
                                          <a href="javascript:void(0)" class="ml3" tooltip="Activate" 
                                            tooltip-placement="bottom" 
                                            ng-if="datas.delete && data.flag != '0'"
                                            ng-click="smsEmailDeleteOpen(data);" >
                                            <span class="fa fa-rotate-right"></span>
                                          </a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot ng-if="datas.details.length=='0'"><tr><td>No Records</td></tr></tfoot>
                            </table>
                        </div>
                        <div class="panel-footer clearfix" ng-if="datas.details.length!='0'">
                            <div class="col-md-4">
                            <p class="left small" style="margin:0px !important;">Showing {{datas.fromRecords}} to {{datas.toRecords}} of {{datas.totalRecords}} entries</p>
                            </div>
                            <div class="col-md-4">
                            <div class="small text-bold right ml15">
                            <span class="control-label">Page No. </span>
                            <select class="form-control page-count"  name="page_no" ng-model="page_no" data-ng-change="listSorting()">
                                <option value="" style="display:none">1</option>
                                <option ng-repeat="pagess in datas.pages" ng-show="$index > 0" value="{{pagess}}">{{pagess}}</option>
                            </select> 
                            </div>
                            </div>
                            <div class="col-md-4">
                            <div class="small text-bold right ml15">
                            <span class="control-label">Count per page</span>
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
        </div>
        
        <div id="ticketviesw">
            <div class="site-settings ticketviesw clearfix col-xs-6 col-lg-6 col-md-6 col-sm-6 floating-sidebar" ng-class="{'open': email_sms_recipient_open}" custom-scrollbar>
                <div class="sidebar-wrap text-uppercase">
                    <div class="group clearfix head tkt-heading">
                        <div class="left">
                            <span class="ion ion-close-round mr10 tktviewClose" ng-click="removeEmailSmsRecipientView()"></span>
                            <span><strong>View E-mail & SMS Recipient</strong></span>
                        </div>
                        <div class="right">
                            <div class="btn-group btn-group-sm">
                                
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row tkt-panel">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <h6>When</h6>
                                <span class="fnt-size-11">{{singleViews.entity_label}}</span>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                              <h6>Communication Type</h6>
                              <span class="fnt-size-11">{{singleViews.communication_type}}</span>
                            </div>
                        </div> 
                        <div class="row tkt-panel">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <h6>"TO" : Users Notified</h6>
                                <span class="fnt-size-11">
                                    {{singleViews.send_to_name}}
                                </span>
                            </div>
                        </div> 
                        <div class="row tkt-panel" ng-if="singleViews.communication_type == 'email'">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <h6>"CC" : Users Notified</h6>
                                <span class="fnt-size-11">
                                    {{singleViews.send_cc_name}}
                                </span>
                            </div>
                        </div>
                        <div class="row tkt-panel">
                            <div class="col-lg-12 col-md-12 col-sm-12" style="background-color:#EEE;font-size:10px;overflow-x: scroll;">
                                <h6> Template </h6>
                                <div ng-bind-html="singleViews.body"></div>
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