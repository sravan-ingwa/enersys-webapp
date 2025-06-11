<style>
.Exp_dashboard {padding: 5px 10px;margin: 10px 30px;border: 1px solid #eee;border-left-width: 5px;border-radius: 3px;border-left-color: #428bca;}
.Exp_dashboard h4{color:#428bca; margin-top: 0;margin-bottom: 5px; font-size:15px;}
.Exp_dashboard p{position: relative;text-indent: 10px; font-size:13px; margin:0px;}
.panel-dashboard{border:1px solid #428bca;}
.panel-heading {color: #ffffff;background-color: #428bca !important;border-color: #428bca !important;}
@media only screen and (min-width : 993px) and (max-width : 1200px) {.Exp_dashboard {margin: 10px 20px;}}
.singleSelect {
	width: 100%;
	border-bottom: 1px solid #e0e0e0;
}
.SumoSelect > .optWrapper {
	right: 0px !important;
}
.SumoSelect > .CaptionCont > span.placeholder {
	color: #ccc !important;
}
.singleSelect > .CaptionCont > label > i {
	color: #000;
}
.SumoSelect > .optWrapper.open {
	top: 33px !important;
}
md-input-container.md-default-theme .md-input[disabled], [disabled] md-input-container.md-default-theme .md-input {
	border-bottom-color : #CCC;
	background-image:none;
}
.modal-backdrop.in { z-index: 1030; }
</style>
<div class="page page-forms-wizard">
	<div class="page-wrap" style="margin-top:75px">
		<!-- row -->
		<div class="row" ng-controller="addingform">
           <!--<div class="toast toast-topRight">
                <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                    <div ng-bind-html="toast.msg"></div>
                </alert>
            </div>-->
			<!-- Full Form wizard -->
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-default panel-stacked panel-hovered mb20">
					<div class="panel-body">
						<ul class="list-unstyled form-wizard-tabs mb20" style="text-align:center">
							<li class="active">
								<span class="text">Password Management</span>
							</li>
						</ul>
						<hr class="solid mb20"/>
						<form class="forms_add form-horizontal col-lg-10" name="userForm" data-went="#/passwordManagement" method="post" url="services/password_management" ng-submit="sendPost()">
							<div class="row" ng-controller="passwordManagementCtrl">
								<div class="col-lg-10 col-md-offset-2 dropalign">
									<!--<label class="selectlabel">Select User Type</label>-->
									<select class="form-control testSelAll2 selectdrop" tabindex="1" ng-model="userType" name="user_type" ng-change="userTypeChange(userType);user_alias=false" required >
										<option value="" selected="selected" disabled>Select User Type</option>
										<option value="1">Employee</option>
										<option value="2">Esca</option>
										<option value="3">Customer</option>
									</select>
								</div>
								<!-- <div class="col-lg-10 col-md-offset-2">
									<md-input-container flex="" class="md-default-theme">
										<label for="input_00D">User ID</label>
										<input type="text" ng-model="user_id" class="ng-pristine ng-valid md-input ng-touched" name="user_id" tabindex="2" aria-invalid="false" ng-disabled="!userType" required />
									</md-input-container>
								</div> -->
								<div class="col-lg-10 col-md-offset-2 dropalign mt30">
									<select class="form-control testSelAll2 selectdrop" tabindex="2" ng-model="user_alias" name="user_alias" required >
										<option value="" disabled="disabled">Select User</option>
										<option ng-repeat="user in firstDrop" value="{{user.alias}}">{{user.name}}</option>
									</select>
								</div>
								<div class="col-lg-10 col-md-offset-2">
									<md-input-container flex="" class="md-default-theme">
										<label for="input_00D">New Password</label>
										<input type="password" ng-model="new_pass" class="ng-pristine ng-valid md-input ng-touched" name="new_pass" tabindex="3" aria-invalid="false" ng-disabled="!userType || !user_alias" required />
									</md-input-container>
								</div>
								<div class="col-lg-10 col-md-offset-2">
									<md-input-container flex="" class="md-default-theme">
										<label for="input_00D">Confirm Password</label>
										<input type="password" ng-model="con_pass" class="ng-pristine ng-valid md-input ng-touched" name="con_pass" tabindex="4" aria-invalid="false" ng-disabled="!userType || !user_alias" required ng-blur="new_con_check=true"/>
									</md-input-container>
									 <span class="help-block" ng-show="new_con_check && new_pass!==con_pass">
										<span ng-show="new_con_check && new_pass!==con_pass">New Password and Confirm Password should match</span>
									</span>
								</div>
								<div id="adminPwdModal" class="modal fade" role="dialog" style="margin-top:10%">
									<div class="modal-dialog modal-sm">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Admin Password Required</h4>
											</div>
											<div class="modal-body">
												<div class="col-md-12">
													<md-input-container flex="" class="md-default-theme">
														<label for="input_00D">Enter Admin Password</label>
														<input type="password" ng-model="admin_pass" class="ng-pristine ng-valid md-input ng-touched" name="admin_pass" tabindex="6" />
													</md-input-container>
												</div>
											</div>
											<div class="modal-footer" style="border-top:none;text-align:center">
												<button type="submit" tabindex="7" click-once class="btn btn-primary mt20" ng-disabled="userForm.$invalid || userForm.$pristine">Submit</button>
												<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
											</div>
										</div>
									</div>
								</div>
								
								<div class="clearfix">
									<button type="submit" tabindex="7" click-once class="btn btn-primary btn-md right mt20" ng-disabled="userForm.$invalid || userForm.$pristine || new_pass!==con_pass">Submit</button>
									<!--<button type="submit" tabindex="5" click-once class="btn btn-primary right mt20" ng-disabled="userForm.$invalid || userForm.$pristine">Submit</button>-->
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- #end form wizard -->
		</div> <!-- #end row -->
	</div> <!-- #end page-wrap -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script>
	setTimeout(function(){
		$('.testSelAll2').SumoSelect();
		$('.forms_add').find('.SumoSelect').addClass('singleSelect');
	},0);
	setTimeout(function(){
		$('.testSelAll2').SumoSelect();
		$('.testSelAll3').SumoSelect({selectAll:true});
		$('.textSearch').keyup(function(){
			var cc = $(this).siblings('.options').find('li');
			var aa =$(this).siblings('.options > li');
			var valThis = $(this).val().toLowerCase();
			if(valThis == "")cc.removeClass('hidden');           
			else{
				cc.each(function(){
					var text = $(this).text().toLowerCase();
					(text.indexOf(valThis) >= 0) ? $(this).removeClass('hidden') : $(this).addClass('hidden');
				});
			};
		   if(cc.length==$(this).siblings('.options').find('.hidden').length){
				$(this).siblings('.options').append('<li class="no_rec"><label>No Records</label></li>');
				$(this).siblings('.select-all').addClass('hidden');
		   }else{
				$(this).siblings('.options').find('.no_rec').remove(); 
				$(this).siblings('.select-all').removeClass('hidden');
		   };
		   $('.forms_add').find('.SumoSelect').addClass('singleSelect');
		});
	},0);
	</script>
</div>