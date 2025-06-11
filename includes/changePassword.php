<style>
.Exp_dashboard {padding: 5px 10px;margin: 10px 30px;border: 1px solid #eee;border-left-width: 5px;border-radius: 3px;border-left-color: #428bca;}
.Exp_dashboard h4{color:#428bca; margin-top: 0;margin-bottom: 5px; font-size:15px;}
.Exp_dashboard p{position: relative;text-indent: 10px; font-size:13px; margin:0px;}
.panel-dashboard{border:1px solid #428bca;}
.panel-heading {color: #ffffff;background-color: #428bca !important;border-color: #428bca !important;}
@media only screen and (min-width : 993px) and (max-width : 1200px) {.Exp_dashboard {margin: 10px 20px;}}
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
								<span class="text">Change Password</span>
							</li>
						</ul>
						<hr class="solid mb20"/>
						<form class="forms_add form-horizontal col-lg-10" name="userForm" data-went="#/changePassword" method="post" url="services/change_password" ng-submit="sendPost()" novalidate>
							<div class="col-lg-10 col-md-offset-2">
								<md-input-container flex="" class="md-default-theme">
									<label for="input_00D">Old Password</label>
									<input type="password" ng-model="old_pass" class="ng-pristine ng-valid md-input ng-touched" name="old_pass" tabindex="1" aria-invalid="false" required/>
								</md-input-container>
							</div>
							
							<div class="col-lg-10 col-md-offset-2">
								<md-input-container flex="" class="md-default-theme">
									<label for="input_00D">New Password</label>
									<input type="password" ng-model="new_pass" class="ng-pristine ng-valid md-input ng-touched" name="new_pass" tabindex="2" aria-invalid="false" required/>
								</md-input-container>
							</div>
							
							<div class="col-lg-10 col-md-offset-2">
								<md-input-container flex="" class="md-default-theme">
									<label for="input_00D">Confirm Password</label>
									<input type="password" ng-model="con_pass" class="ng-pristine ng-valid md-input ng-touched" name="con_pass" tabindex="3" aria-invalid="false" required/>
								</md-input-container>
							</div>
							<div class="clearfix">
								<button type="submit" click-once class="btn btn-primary right mt20" ng-disabled="userForm.$invalid || userForm.$pristine">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- #end form wizard -->
		</div> <!-- #end row -->
	</div> <!-- #end page-wrap -->
</div>