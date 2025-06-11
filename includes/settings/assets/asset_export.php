<div class="modal-style">
	<div class="modal-header clearfix">
		<h4 class="modal-title">Export Assets</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
		<form class="form-horizontal forms_add" url="services/settings/assets_export" data-went="#/services/settings/assets_mul_view" name="modal-demo-form" ng-submit="sendPost()" novalidate>
			<div class="row form-group">
				<div class="col-sm-12 text-center">
					<input type="submit" click-once class="btn btn-info btn-sm" value="Run Report">
				</div>
			</div>
		</form>
	</div>
</div>
