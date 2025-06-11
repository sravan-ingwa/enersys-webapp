<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
</style>
<div class="modal-style">
	<div class="modal-header clearfix">
		<h4 class="modal-title">Create Change Log</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" name="changelogForm" data-went="#/settings/mobile_app/changelog_view" method="post" url="services/settings/changelog_add" ng-submit="sendPost()" novalidate>
                <div class="row form-group newmd">
                    <div class="col-sm-12">
                        <md-input-container class="md-default-theme">
                            <label for="input_00D">ChangeLog Title</label>
                            <input ng-model="changelog" name="changelog_name" class="ng-pristine ng-valid md-input ng-touched">
                        </md-input-container>
                         <span class="help-block" ng-show="changelogForm.workguide_name.$dirty && changelogForm.workguide_name.$invalid">
                            <span ng-show="changelogForm.workguide_name.$error.required">Changelog is Required</span>
                        </span>
                    </div>
					<div class="clearfix"></div>
					<div class="panel cells" ng-controller="addFieldsCtrl">
						<div class="panel-body">
							<div class="row form-group" ng-repeat="field in forms">
								<div class="header ml10 right">
									<span  class="btn btn-info btn-sm " ng-click="removeFields(field)">Remove List</span>
									<span  class="btn btn-info btn-sm mr5" ng-click="addFields(field)">Add List</span>
								</div>
								<div>
									<div class="form-group" ng-repeat="type in field.itemtype">
										<div class="col-sm-12">
											<md-input-container flex="" class="md-default-theme md-input-has-value">
												<label for="input_00D">ChangeLog List</label>
												<input type="text" ng-model="quantity" name="quantity[]" class="md-input ng-touched" aria-invalid="false" id="input_00D" placeholder="Enter Cells Quantity"/>
										   </md-input-container>
										</div>
									</div>
								</div>           
							</div>
						</div>
					 </div>
					 <div class="col-sm-12">
						<button type="submit" click-once class="btn btn-info btn-sm subdisabled">Create</button>
                        <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose()">Close</button>
					</div>
				 </div>
          </form>  
	</div>  
</div>