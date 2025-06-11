<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.singleSelect{width:462px; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
</style>
<div class="modal-style" ng-controller="employeenameDropCtrl">
	<div class="modal-header clearfix">
		<h4 class="modal-title">Send Message</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" data-went="#/notifications" method="post" url="services/notifications/send_message" ng-submit="sendPost()" novalidate>
                <div class="row form-group">
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Title</label>
                            <input ng-model="title" name="title" class="ng-pristine ng-valid md-input ng-touched" id="input_00A" tabindex="0" aria-invalid="false" required>
                        </md-input-container>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 mb10">
                        <textarea class="form-control" name="message" ng-model="message" placeholder="Message" style="padding:0px;"></textarea>
                    </div>
                    <div ng-controller="roleEmpDropCtrl">
                        <div class="col-sm-10 col-sm-offset-1 mb20">
                           <select class="form-control selectdrop testSelAll2" name="role_alias1[]" ng-model="emprole" placeholder="Employee Role"  data-ng-change="role_emp_mul_all()" multiple="multiple" required>
                                <option ng-repeat="emprole in firstDrop" value="{{emprole.alias}}">{{emprole.name}}</option>
                           </select>
                           <span class="help-block" ng-show="empmasterForm['role_alias1[]'].$dirty && empmasterForm['role_alias1[]'].$invalid">
                                <span ng-show="empmasterForm['role_alias1[]'].$error.required">Select Employee Role</span>
                           </span>
                        </div>
                        <div class="col-sm-10 col-sm-offset-1 mb10">
                           <select class="form-control selectdrop testSelAll2" name="employee_alias1[]" placeholder="Employee Names" ng-model="employee_alias" multiple="multiple" required>
                                <option ng-repeat="emp in secondDrop" value="{{emp.alias}}">{{emp.name}}</option>
                           </select>
                           <span class="help-block" ng-show="empmasterForm['employee_alias1[]'].$dirty && empmasterForm['employee_alias1[]'].$invalid">
                                <span ng-show="empmasterForm['employee_alias1[]'].$error.required">Select Employee Names</span>
                           </span>
                        </div>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" class="btn btn-info btn-sm">Send</button>
                    </div>
               </div>
          </form>   
	</div>  
</div>
<script>
setInterval(function(){$('.testSelAll2').SumoSelect({selectAll:true});
$('.forms_add').find('.SumoSelect').addClass('singleSelect');},0);
</script>