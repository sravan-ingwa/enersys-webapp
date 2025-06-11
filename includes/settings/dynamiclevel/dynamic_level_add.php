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
<div class="modal-style">
	<div class="modal-header clearfix">
		<h4 class="modal-title">Create Dynamic Level</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <form class="form-horizontal forms_add" name="dynamiclevelForm" data-went="#/settings/dynamiclevel/dynamic_level_view" method="post" url="services/settings/dynamic_level_add" ng-submit="sendPost()" novalidate>
                <div class="row form-group" ng-controller="dynamiclevelprivilagesorderdropCntrl">
                    <div class="col-sm-10 col-sm-offset-1 mb10">
                    	<label class="selectlabel">Privilege</label>
                        <select class="form-control testSelAll2 selectdrop" name="privilege_alias">
                            <option value="" selected="selected" disabled="disabled">Select Privilege</option>
							<option value="{{data.alias}}" ng-repeat="data in firstDrop.privilege">{{data.name}}</option>
                    	</select>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 mb10">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Level Name</label>
                            <input ng-model="level_name" class="ng-pristine ng-valid md-input ng-touched" name="level_name" id="input_00A" tabindex="0" aria-invalid="false">
                        </md-input-container>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 mb10">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Level Color (Should (Ex:#f00 or #000000) Format only)</label>
							<input colorpicker="hex" type="text" class="form-control" name="level_color" ng-model="level_color"  ng-style="{'background': level_color}" ng-pattern="/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/"/>
                        </md-input-container>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 mb10">
                    	<label class="selectlabel">Grantable</label>
                        <select class="form-control testSelAll2 selectdrop" name="grantable">
                            <option value="" selected="selected" disabled="disabled">Select Grantable</option>
                            <option value="1">YES</option>
                            <option value="0">NO</option>
                    	</select>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 mb10">
                    	<label class="selectlabel">Level Order</label>
                        <select class="form-control testSelAll2 selectdrop" name="order_by">
                            <option value="">Select Level Order</option>
							<option value="{{ordr.val}}" ng-repeat="ordr in firstDrop.order" ng-selected="$last">{{ordr.val}}</option>
                    	</select>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5">
						<button type="submit" click-once class="btn btn-info btn-sm subdisabled">Create</button>
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
		//$('.testSelAll3').SumoSelect({selectAll:true});
		$('.forms_add').find('.SumoSelect').addClass('singleSelect');
	},0);
</script>