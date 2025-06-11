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
<div class="modal-style" ng-controller="dynamiclevelEditCntl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit Dynamic Level</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <form class="form-horizontal forms_add" reset-directive="singleViews" name="dynamiclevelForm" data-went="#/settings/dynamiclevel/dynamic_level_view" method="post" url="services/settings/dynamic_level_update" ng-submit="sendPost()" novalidate>
                <input type="hidden" name="dynamic_alias" value="{{singleViews.dynamic_alias}}" ng-model="singleViews.dynamic_alias" >
                <div class="row form-group">
					<div class="col-sm-10 col-sm-offset-1 mb10">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00A">Privilege</label>
                            <input value="{{singleViews.privilege_name}}" ng-model="singleViews.privilege_name" class="ng-pristine ng-valid md-input ng-touched" readonly>              
                        </md-input-container>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 mb10">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Level Name</label>
                            <input type="text" value="{{singleViews.level_name}}" ng-model="singleViews.level_name" class="ng-pristine ng-valid md-input ng-touched" name="level_name" id="input_00A" tabindex="0" aria-invalid="false">
                        </md-input-container>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 mb10">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Level Color (Should (Ex:#f00 or #000000) Format only)</label>
							<input type="text" class="form-control" value="{{singleViews.level_color}}" name="level_color" ng-model="singleViews.level_color" style="color:#FFF"  ng-style="{'background': singleViews.level_color}" colorpicker="hex" ng-pattern="/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/"/>
                        </md-input-container>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 mb10">
                    	<label class="selectlabel">Grantable</label>
                        <select class="form-control testSelAll2 selectdrop" name="grantable">
                            <option value="">Select Grantable</option>
                            <option value="1" ng-selected="singleViews.grantable==1">YES</option>
                            <option value="0" ng-selected="singleViews.grantable==0">NO</option>
                    	</select>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 mb10">
                    	<label class="selectlabel">Level Order</label>
                        <select class="form-control testSelAll2 selectdrop" name="order_by">
                            <option value="">Select Level Order</option>
							<option value="{{ordr.val}}" ng-repeat="ordr in firstDrop.order" ng-selected="ordr.val == singleViews.order_by">{{ordr.val}}</option>
                            <option ng-if="firstDrop.order.length==0">No Records</option>
                    	</select>
                    </div>
                    <div class="col-sm-6 col-sm-offset-5">
						<button type="submit" click-once class="btn btn-info btn-sm"
						ng-disabled="dynamiclevelForm.privilege_alias.$dirty && dynamiclevelForm.privilege_alias.$invalid ||
						dynamiclevelForm.grantable.$dirty && dynamiclevelForm.grantable.$invalid ||
						dynamiclevelForm.order_by.$dirty && dynamiclevelForm.order_by.$invalid">Update</button>
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