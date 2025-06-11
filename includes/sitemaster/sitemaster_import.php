<div class="modal-style">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Import Site Master</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
     <!--<div class="toast toast-topRight">
        <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
            <div ng-bind-html="toast.msg"></div>
        </alert>
    </div>-->
		<form class="form-horizontal forms_add" data-went="#/Sitemaster" enctype="multipart/form-data" method="post" url="services/sitemaster/sitemaster_import" ng-submit="sendPost()" novalidate>
			<div class="row form-group">
				<div class="col-sm-12 filesRow" ng-controller="fileUploadPrgCtrl">
					 <!--<label class="selectlabel">Mode Of Contact: <span style="color:red;">(Mandatory)</span></label><br /> -->                                                    
					<input value="{{file_name}}" class="form-control uploadFile" placeholder="Choose excel file to import" disabled="disabled"/>
					<div class="fileUpload btn btn-sm btn-info" tooltip="Upload Excel File" tooltip-placement="right">
						<span class="ion ion-upload"></span>
						<input type="file" ng-click="clear();" class="upload uploadBtn" name="file" id="file" onchange="angular.element(this).scope().file_load(this.files,'xls')"/>
					</div>
					<div ng-if="determinateValue >= '100'" ng-init="closeloadings()"></div>
					<div class="mb20" ng-if="prg_shw_hde">
					<md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
					</div>
				</div>
			</div>
			
			
			<!--<div class="row form-group">
				<div class="col-sm-12">
					<input type="file" name="file">
				</div>
			</div>-->
			<div class="row form-group">
				<div class="col-sm-12 text-right">
					<button type="submit" click-once class="btn btn-success">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>
