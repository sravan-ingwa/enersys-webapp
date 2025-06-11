<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.selectdrop {
	overflow-y: scroll
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
<div class="modal-style" ng-controller="mocEditCntl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit MOC</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" reset-directive="singleViews" name="mocForm" data-went="#/settings/moc/moc_view" method="post" url="services/settings/moc_update" ng-submit="sendPost()" novalidate>
                <input name="moc_alias" value="{{singleViews.moc_alias}}" type="hidden">
                <div class="row form-group">
                    <div class="col-sm-10 col-sm-offset-1">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00A">MOC</label>
                            <input name="moc_name" value="{{singleViews.moc_name}}" ng-model="singleViews.moc_name" class="ng-pristine ng-valid md-input ng-touched" required="required">              
                        </md-input-container>
                        <span class="help-block" ng-show="mocForm.moc_name.$dirty && mocForm.moc_name.$invalid">
                            <span ng-show="mocForm.moc_name.$error.required">MOC is Required</span>
                        </span>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 mb10">
                    	<label class="selectlabel">MOC File</label>
                        <select class="form-control testSelAll2 selectdrop" name="moc_file">
                            <option value="" selected="selected" disabled="disabled">Select MOC File</option>
                            <option value="0" ng-selected="singleViews.moc_file=='0'">DISABLE</option>
                            <option value="1" ng-selected="singleViews.moc_file=='1'">ENABLE</option>
                    	</select>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 mb10">
                    	<label class="selectlabel">MOC Text</label>
                        <select class="form-control testSelAll2 selectdrop" name="moc_text">
                            <option value="" selected="selected" disabled="disabled">Select MOC Text</option>
                            <option value="0" ng-selected="singleViews.moc_text=='0'">DISABLE</option>
                            <option value="1" ng-selected="singleViews.moc_text=='1'">ENABLE</option>
                    	</select>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm" ng-disabled="mocForm.moc_name.$dirty && mocForm.moc_name.$invalid">Update</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose();">Close</button>
                    </div>
               </div>
          </form>  
	</div>
</div>
</div>
<script>
	setInterval(function(){
		$('.testSelAll2').SumoSelect();
		//$('.testSelAll3').SumoSelect({selectAll:true});
		$('.forms_add').find('.SumoSelect').addClass('singleSelect');
	},0);
</script>