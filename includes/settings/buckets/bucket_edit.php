<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
</style>
<div>
<div class="modal-style" ng-controller="bucketEditCntl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit Bucket</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" reset-directive="singleViews" name="bucketForm" data-went="#/settings/buckets/bucket_view" method="post" url="services/settings/bucket_update" ng-submit="sendPost()" novalidate>
                <input name="bucket_alias" value="{{singleViews.bucket_alias}}" type="hidden">
                <div class="row form-group">
                    <div class="col-sm-8 col-sm-offset-2">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00A">Bucket</label>
                            <input name="bucket" value="{{singleViews.bucket}}" ng-model="singleViews.bucket" class="ng-pristine ng-valid md-input ng-touched" required="required">              
                        </md-input-container>
                        <span class="help-block" ng-show="bucketForm.bucket.$dirty && bucketForm.bucket.$invalid">
                            <span ng-show="bucketForm.bucket.$error.required">Bucket is Required</span>
                        </span>
                    </div>
                     <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm" ng-disabled="bucketForm.bucket.$dirty && bucketForm.bucket.$invalid">Update</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose()">Close</button>
                    </div>
               </div>
          </form>  
	</div>
</div>
</div>