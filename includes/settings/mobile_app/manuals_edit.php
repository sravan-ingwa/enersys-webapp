<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.selectdrop {overflow-y: scroll}
.datepicker {border-bottom: 1px solid #efefef!important}
.singleSelect {width: 100%;	border-bottom: 1px solid #e0e0e0}
.SumoSelect>.optWrapper {right: 0!important}
.SumoSelect>.CaptionCont>span.placeholder {color: #ccc!important}
.singleSelect>.CaptionCont>label>i {color: #000}
.SumoSelect>.optWrapper.open {top: 33px!important}
</style>
<div class="modal-style" ng-controller="manualEditCntl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Update Manuals</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        	<form class="form-horizontal forms_add" reset-directive="singleViews" name="manualsForm" data-went="#/settings/mobile_app/manuals_view" enctype="" method="post" url="services/settings/manuals_update" ng-submit="sendPost()" novalidate>
                 <input type="hidden" name="product_alias" value="{{singleViews.product_alias}}" />
                 <div class="row form-group">
                   <div class="col-sm-6 mb20">
                        <md-input-container flex="" class="md-default-theme md-input-has-value">
                            <label for="input_00D">Product Code</label>
                            <input value="{{singleViews.product_name}}" ng-model="singleViews.product_name" class="ng-pristine ng-valid md-input ng-touched" id="input_00A" tabindex="0" aria-invalid="false" readonly>
                        </md-input-container>                  
					</div>
					<div class="col-sm-6 mb20" ng-controller="segmentdropCntrl">
						<label class="selectlabel">Segment</label>
						<select multiple="multiple" placeholder="Segment" name="segment_alias[]" class="testSelAll3 form-control" ng-model="segment" required="required">
							<option ng-repeat="segment in firstDrop" value="{{segment.alias}}" ng-selected="singleViews.segment_alias.indexOf(segment.alias) != -1">{{segment.name}}</option>
						</select>
						 <span class="help-block" ng-show="manualsForm['segment_alias[]'].$dirty && manualsForm['segment_alias[]'].$invalid">
							<span ng-show="manualsForm['segment_alias[]'].$error.required">Select Zone</span>
						</span>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-6 mb20">
						<label class="selectlabel">View Status</label>
						<select placeholder="View Status" name="view_stat" class="testSelAll2 form-control" ng-model="view_stat" required="required">
						<option value="">Select View Satus</option>
							<option value="0" ng-selected="singleViews.view_stat==0">DISABLE</option>
							<option value="1" ng-selected="singleViews.view_stat==1">ENABLE</option>
						</select>
						 <span class="help-block" ng-show="manualsForm.view_stat.$dirty && manualsForm.view_stat.$invalid">
							<span ng-show="manualsForm.view_stat.$error.required">Select View Status</span>
						</span>
					</div>
					<div class="col-sm-6 mb20 filesRow" ng-controller="fileUploadPrgCtrl">
						<input value="{{file_name}}" class="form-control uploadFile" placeholder="Upload manuals" disabled="disabled"/>
						<div class="fileUpload btn btn-sm btn-info" tooltip="Choose manuals" tooltip-placement="right">
							<span class="ion ion-upload"></span>
							<input type="file" class="upload uploadBtn" name="m_file" id="m_file" onchange="angular.element(this).scope().file_load(this.files,'pdf')"/>
						</div>
						<span class="help-block" ng-show="manualsForm.m_file.$dirty && manualsForm.m_file.$invalid">
							<span ng-show="manualsForm.m_file.$error.required">Upload Manual PDF</span>
						</span>
						<div ng-if="determinateValue >= '100' ? closeloadings() : ''"></div>
						<div class="mb20" ng-if="prg_shw_hde">
							<md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
						</div>
					</div>
                </div>
					<div class="row form-group">
                     <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm" 
                             ng-disabled="manualsForm.view_stat.$dirty && manualsForm.view_stat.$invalid ||
                             manualsForm['segment_alias[]'].$dirty && manualsForm['segment_alias[]'].$invalid ||
                              manualsForm.m_file.$dirty && manualsForm.m_file.$invalid">Update</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose();">Close</button>
                    </div>
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