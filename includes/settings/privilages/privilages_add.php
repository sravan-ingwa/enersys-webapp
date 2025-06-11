<style>
	.form-group {margin-bottom:15px;}
	.form-group div.col-sm-4{margin-bottom:15px;}
	.modal-header > .close {right:-30px; top:-12px;}
	.privilage th{background-color:#428bca; color:#fff; padding:7px !important; text-align:center;}
	.privilage td{padding:0px !important;}
	.margin-none{margin:0px !important;}
	@media screen and (min-width: 304px) and (max-width: 992px) {
		.privilage-table > thead > tr > th {width:100px !important;}
	}
	@media screen and (min-width: 304px) and (max-width: 992px) {
		.privilage-table > thead {max-width:900px !important;}
		.privilage-table > tbody {max-width:900px !important;}
	}
</style>
<div class="modal-style" ng-controller="privilagesAddCntl"><!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Create User Roles</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <form class="form-horizontal forms_add" name="privilegeForm" data-went="#/settings/privilages/privilages_view" method="post" url="services/settings/privileges_add" ng-submit="sendPost()" novalidate>
                <div class="row form-group">
                    <div class="col-sm-8 col-sm-offset-2">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Enter Privilage Name</label>
                            <input ng-model="roletitle" name="privilege_name" class="ng-pristine ng-valid md-input ng-touched" id="input_00A" tabindex="0" aria-invalid="false" required="required">
                        </md-input-container>
                          <span class="help-block" ng-show="privilegeForm.privilege_name.$dirty && privilegeForm.privilege_name.$invalid">
                            <span ng-show="privilegeForm.privilege_name.$error.required">Privilege Name is Required</span>
                        </span>
                    </div>
               </div>
               <div class="row form-group">
                    <div class="col-sm-3 col-sm-offset-3 mb10">
                        <div class="ui-checkbox ui-checkbox-info margin-none">
                            <label class="btn btn-default">
                                <input type="checkbox" name="checkAll" id="checkAll" ng-click="check_All()" md-ink-ripple>
                                 <span>Check All</span>
                            </label>
                        </div>
       				</div>
                    <div class="col-sm-3">
						<!--<span ng-click="isAllOpen = !isAllOpen" class="btn btn-info btn-sm">Expand / Collapse All</span>-->
       				</div>
                </div>
                <div class="row form-group">
				
						<div class="col-sm-12 mb10" ng-controller="PrivilegesCheckCntrl">
							<accordion class="accordion-panel">
							  <div class="panel panel-default panel-hovered">
								<div class="panel-heading exp_sing text-center">Privilages</div>
								<accordion class="accordion-panel" ng-repeat="(key, data) in singleViews1">
									<accordion-group is-open="lc_status.open" ng-class="{'panel-info': lc_status.open}">
									<accordion-heading>
										<div>{{key}}&nbsp; <i class="mt2 ion small" style="color:#000" ng-class="{'ion-chevron-down': lc_status.open, 'ion-chevron-right': !lc_status.open}"></i></div>
									</accordion-heading>
									<div class="mb20" style="overflow:scroll;">
										<table class="table table-condensed" >
											<thead>
												<tr>
													<th ng-repeat="(key1, crud) in data.head" style="width:100px"><a class="tktid">{{crud !='SPECIAL' ? crud : 'SPCL'}}</a></th>
												</tr>
											</thead>
										</table>
										<table class="table table-hover table-bordered">
											<tbody>
												<tr class="tktBackground" ng-repeat="(key2, sub) in data.sub">
													<td style="width:100px"><span tooltip-placement="top" tooltip="{{sub}}">{{sub | limitTo:15}}{{sub.length>15 ? '...':''}}</span></td>
													<td ng-repeat="(key3, crud) in data.head" ng-if="$index!=0" style="padding: 0px;width: 100px;">
                                                        <div class="ui-checkbox ui-checkbox-info" ng-init="privilege_model[sub][crud] = 0">
                                                            <label>
																<input type="hidden" ng-if="!privilege_model[sub][crud]" value="{{sub}}-{{crud}}-0" name="privilege_value[]">
                                                                <input type="checkbox" class="chec" ng-model="privilege_model[sub][crud]" ng-click="privilege_value_click(privilege_model[sub][crud]);"  ng-checked="singleViews[sub][crud]==1" value="{{sub}}-{{crud}}-1" name="privilege_value[]">
                                                                <span></span>
                                                            </label>
                                                        </div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									</accordion-group>
								</accordion>
								</div>
							</accordion>
						</div>
						 <div class="col-sm-6 col-sm-offset-5 mt10">
							<button type="submit" click-once class="btn btn-info btn-sm" ng-disabled="privilegeForm.$invalid || privilegeForm.$pristine">Create</button>
                            <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose()">Close</button>
						</div>
                   </div>
          </form>   
	</div>
  </div> 
<script>
$('#checkAll').on('change', function() {
    if (this.checked) {
        $('.chec').each(function() {this.checked = true;});
    } else {
        $('.chec').each(function() {this.checked = false;});
    }
	$('.chec').on('change', function() {
		var isAllChecked = true;
		$('.chec').each(function() {
			if (!this.checked) {isAllChecked = false;}
		});
		if (isAllChecked) {$('#checkAll').prop('checked', true);} 
		else {$('#checkAll').prop('checked', false);}
	});
});
</script>