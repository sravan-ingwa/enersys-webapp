<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
</style>
<div>
<div class="modal-style" ng-controller="changelogEditCntl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit Change Log{{singleViews.mainguide_alias}}</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
		<div>
        <form class="form-horizontal forms_add Editchangelog" name="changelogForm" data-went="#/settings/mobile_app/changelog_view" method="post" url="services/settings/changelog_update" ng-submit="sendPost()" novalidate>
			<div class="row form-group">
					<div class="clearfix"></div>
					<div class="panel cells" ng-controller="addFieldsCtrl1">
						<div class="panel-body">
							<div class="row form-group" ng-repeat="field in forms">
								 <md-input-container class="md-default-theme">
									<label for="input_00D">ChangeLog</label>
									 <input type="hidden" ng-model="singleViews.main_alias" value="{{singleViews.main_alias}}" name="main_alias" />
									<input ng-model="singleViews.main_title" name="main_name" value="{{singleViews.main_title}}" class="ng-pristine ng-valid md-input ng-touched" required="required" />
								</md-input-container>
								<div class="header ml10 right">
									<span class="btn btn-info btn-sm mr5" ng-click="addFields(field)">Add List</span>
								</div>
								<div>
									<div class="form-group">
										<div class="col-sm-12 newinput" ng-repeat="(key,type) in field.itemtype=singleViews.sub_changelog">
											<input type="hidden" ng-model="type.sub_alias" value="{{type.sub_alias}}" name="sub_alias[]" />
											<md-input-container flex="" class="md-default-theme md-input-has-value">
												<label for="input_00D">Sub Changelog {{key+1}}</label>
												<input type="text" ng-model="type.sub_title" value="{{type.sub_title}}" name="sub_title[]" class="md-input ng-touched" aria-invalid="false" id="input_00D" />
										   </md-input-container>
										   <div class="rem-input" style="right:10px !important;position:absolute !important">
												<a href="javascript:void(0)" ng-click="removeFields(field,key);delfield(type.sub_alias)">
												   <i class="fa fa-times" aria-hidden="true"></i>
												</a>
											</div>
										</div>
									</div>
								</div>           
							</div>
						</div>
					 </div>
					 <div class="col-sm-12 col-sm-offset-5">
						<button type="submit" click-once class="btn btn-info btn-sm subdisabled">Update</button>
						<button type="reset" class="btn btn-info btn-sm" ng-click="modalClose();">Close</button>
					</div>
				 </div>
          </form>  
	</div> 
	</div>
</div>
</div>