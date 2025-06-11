<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.selectdrop {
	overflow-y: scroll
}
.datepicker {
	border-bottom: 1px solid #efefef!important
}
.singleSelect {
	width: 100%;
	border-bottom: 1px solid #e0e0e0
}
.SumoSelect>.optWrapper {
	right: 0!important
}
.SumoSelect>.CaptionCont>span.placeholder {
	color: #ccc!important
}
.singleSelect>.CaptionCont>label>i {
	color: #000
}
.SumoSelect>.optWrapper.open {
	top: 33px!important
}
</style>
<div class="modal-style" ng-controller="ticketcomplaintEditCntl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit Nature Of Complaints</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" reset-directive="singleViews" name="complaintForm" data-went="#/settings/complaint/complaint_view" method="post" url="services/settings/ticketcomplaint_update" ng-submit="sendPost()" novalidate>
                <input name="complaint_alias" value="{{singleViews.complaint_alias}}" type="hidden">
                <div class="row form-group" ng-controller="activitydropCntrl">
                    <div class="col-sm-10 col-sm-offset-1 mb10">
                		<label class="selectlabel">Nature Of Activity</label>
                        <select id="Activity" class="form-control testSelAll2 editselectdrop" name="activity_alias" ng-model="natureofactivity" required>
                            <option value='' selected="selected" disabled="disabled">Select Nature Of Activity</option>
                            <option ng-repeat="activity in firstDrop" value="{{activity.alias}}" ng-selected="activity.alias == singleViews.activity_alias">{{activity.name}}</option>
                        </select>
                         <span class="help-block" ng-show="complaintForm.activity_alias.$dirty && complaintForm.activity_alias.$invalid">
                            <span ng-show="complaintForm.activity_alias.$error.required">Select Nature of Activity</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1" ng-class="{'has-error' : submitted && complaintForm.complaint_name.$invalid}">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Nature Of Complaint</label>
                            <input value="{{singleViews.complaint_name}}" ng-model="singleViews.complaint_name" class="ng-pristine ng-valid md-input ng-touched" name="complaint_name" id="input_00B" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                         <span class="help-block" ng-show="complaintForm.complaint_name.$dirty && complaintForm.complaint_name.$invalid">
                            <span ng-show="complaintForm.complaint_name.$error.required">Nature Of Complaint is Required</span>
                        </span>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm"
                             ng-disabled="complaintForm.activity_alias.$dirty && complaintForm.activity_alias.$invalid ||
                             complaintForm.complaint_name.$dirty && complaintForm.complaint_name.$invalid">
                             Update</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose();">Close</button>
                    </div>
               </div>
          </form>   
	</div>
</div>
<script>
	setInterval(function(){
		$('.testSelAll2').SumoSelect();
		$('.testSelAll3').SumoSelect({selectAll:true});
		$('.forms_add').find('.SumoSelect').addClass('singleSelect');
	},0);
</script>