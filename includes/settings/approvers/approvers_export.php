<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
</style>
<div class="modal-style" ng-controller="EnersysExpenseCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Export Approvals List</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_request" name="approversForm" data-went="#/approvers" method="post" url="services/expense_tracker/approvers_export" ng-submit="sendRequest()" novalidate>
                <div class="row form-group">
                 	<div class="col-sm-10 col-sm-offset-1 mb10" ng-controller="departmentdropCntrl">
                    	  <label class="selectlabel">Approval for(Department):</label>
                          <select class="form-control selectdrop testSelAll2" multiple name="department_alias" ng-model="department"  placeholder="Department">
                            <option value="" selected="">Department</option>
                            <option ng-repeat="department in firstDrop" value="{{department.alias}}">{{department.name}}</option>
                    	</select>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm">Export</button>
                    </div>
               </div>
          </form>   
	</div>
</div>
<script>
setInterval(function(){$('.testSelAll2').SumoSelect();
$('.forms_request').find('.SumoSelect').addClass('singleSelect');},0);
</script>