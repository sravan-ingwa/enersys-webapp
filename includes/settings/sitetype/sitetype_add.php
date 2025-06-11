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
<div>
<div class="modal-style">
	<div class="modal-header clearfix">
		<h4 class="modal-title">Create Site Type</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" name="sitetypeForm" data-went="#/settings/sitetype/sitetype_view" method="post" url="services/settings/sitetype_add" ng-submit="sendPost()" novalidate>
                <div class="row form-group">
                	<div class="col-sm-10 col-sm-offset-1 mb10" ng-controller="segmentdropCntrl">
                    <label class="selectlabel">Segment</label>
                         <select class="form-control testSelAll2 selectdrop" name="segment_alias" ng-model="segments" required="required">
                            <option value="" selected="" disabled="disabled">Select Segment</option>
                            <option ng-repeat="segment in firstDrop" value="{{segment.alias}}">{{segment.name}}</option>
                        </select>
                         <span class="help-block" ng-show="sitetypeForm.segment_alias.$dirty && sitetypeForm.segment_alias.$invalid">
                            <span ng-show="sitetypeForm.segment_alias.$error.required">Select Segment</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Site Type</label>
                            <input ng-model="site_type" name="site_type" class="ng-pristine ng-valid md-input ng-touched" id="input_00A" tabindex="0" aria-invalid="false" required>
                        </md-input-container>
                          <span class="help-block" ng-show="sitetypeForm.site_type.$dirty && sitetypeForm.site_type.$invalid">
                            <span ng-show="sitetypeForm.site_type.$error.required">Site Type is Required</span>
                        </span>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm" ng-disabled="sitetypeForm.$invalid || sitetypeForm.$pristine">Create</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose()">Close</button>
                    </div>
               </div>
          </form>   
	</div>  
</div>
</div>
<script>
	setInterval(function(){
		$('.testSelAll2').SumoSelect();
		$('.testSelAll3').SumoSelect({selectAll:true});
		$('.forms_add').find('.SumoSelect').addClass('singleSelect');
	},0);
</script>