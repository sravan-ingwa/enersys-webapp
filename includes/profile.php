<style>
.upload-button {display: block;float: left; padding:7px; position: relative;top: 5px; right:-2px;}
.file-upload {display: none !important;}
.Exp_dashboard {padding: 5px 10px;margin: 10px 30px;border: 1px solid #eee;border-left-width: 5px;border-radius: 3px;border-left-color: #428bca;}
.Exp_dashboard h4{color:#428bca; margin-top: 0;margin-bottom: 5px; font-size:15px;}
.Exp_dashboard p{position: relative;text-indent: 10px; font-size:13px; margin:0px;}
.panel-dashboard{border:1px solid #428bca;}
.panel-heading {color: #ffffff;background-color: #428bca !important;border-color: #428bca !important;}
.profile-img{border-radius: 100%;  border: 2px solid #eeeeee;}
@media only screen and (min-width : 993px) and (max-width : 1200px) {.Exp_dashboard {margin: 10px 20px;}}
.edit-profile{top:-50px; position:relative;}
.edit-profile span{font-size:16px;}
</style>
<div class="page page-forms-wizard" ng-controller="profileViewCtrl">
	<div class="page-wrap">
		<!-- row -->
		<div class="row" ng-controller="addingform">
           <!--<div class="toast toast-topRight">
                <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                    <div ng-bind-html="toast.msg"></div>
                </alert>
            </div>-->
                <form class="forms_add" enctype="multipart/form-data" method="post" novalidate>
                  <input type="hidden" value="{{singleViews.profile_pic}}" name="old_profile_pic"/>
                  <div class="col-md-6 col-md-offset-5 col-sm-offset-5 col-xs-offset-5 col-lg-offset-5 mb10">
                    <img src="{{singleViews.profile_pic}}" class="profile-img profile-pic" alt="user" width="100" height="100"><br />
                    <div class="upload-button btn btn-sm btn-primary">Upload Image</div>
                        <input type="file" class="file-upload" accept="image/*" name="profile_pic"/>
                  </div>  
              </form>
			<!-- Full Form wizard -->
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default panel-stacked panel-hovered mb20" ng-controller="FormWizardCtrl">
					<div class="panel-body">
						<ul class="list-unstyled form-wizard-tabs mb20">
							<li ng-class="{active: steps[0]}">
								<span class="text">Employee Info</span>
								<i class="fa fa-long-arrow-right"></i>
							</li>
							<li ng-class="{active: steps[1]}">
								<span class="text">User Info</span>
								<i class="fa fa-long-arrow-right"></i>
							</li>
							<li ng-class="{active: steps[2]}">
								<span class="text">Qualification Info</span>
							</li>
						</ul>
                        <!--<a href class="right edit-profile" tooltip="Edit" tooltip-placement="top"><span class="fa fa-edit "></span></a>-->
						<hr class="dashed mb20"/>

						<!-- step 1 -->
						<form class="form-horizontal col-lg-10" name="wizard-step-1" ng-show="steps[0]" novalidate>
							<div class="form-group">
								<label class="col-lg-4 control-label">Employee Name</label>
								<div class="col-lg-8">
									<input type="text" value="{{singleViews.name}}" disabled="disabled" class="form-control inputDisabled" ng-minlength="4">
								</div>
							</div>
                            
                            <div class="form-group">
								<label class="col-lg-4 control-label">Employee Id</label>
								<div class="col-lg-8">
									<input type="text" value="{{singleViews.employee_id}}" disabled="disabled" class="form-control inputDisabled" ng-minlength="4">
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-4 control-label">Email ID</label>
								<div class="col-lg-8">
									<input type="email" value="{{singleViews.email_id}}" disabled="disabled" class="form-control inputDisabled">
								</div>
							</div>
                            
                            <div class="form-group">
								<label class="col-lg-4 control-label">Mobile Number</label>
								<div class="col-lg-8">
									<input type="text" value="{{singleViews.mobile_number}}" disabled="disabled" class="form-control inputDisabled" ng-minlength="4">
								</div>
							</div>

							 <div class="form-group">
								<label class="col-lg-4 control-label">Designation</label>
								<div class="col-lg-8">
									<input type="text" value="{{singleViews.designation}}" disabled="disabled" class="form-control inputDisabled">
								</div>
							</div>

							<div class="clearfix">
								<button type="submit" class="btn btn-primary right" ng-click="stepNext(1)">Next</button>
							</div>
						</form>
						<!-- #end step 1 -->

						<!-- step 2 -->
						<form class="form-horizontal col-lg-10" name="wizard-step-2" ng-show="steps[1]" novalidate>
                        	<div class="form-group">
								<label class="col-lg-4 control-label">Zone</label>
								<div class="col-lg-8">
									<input type="text" value="{{singleViews.zone_name}}" disabled="disabled" class="form-control inputDisabled">
								</div>
							</div>
                            
                            <div class="form-group">
								<label class="col-lg-4 control-label">State</label>
								<div class="col-lg-8">
									<input type="text" value="{{singleViews.state_name}}" disabled="disabled" class="form-control inputDisabled" ng-minlength="4" placeholder="AP">
								</div>
							</div>
                            
                            <div class="form-group">
								<label class="col-lg-4 control-label">Department</label>
								<div class="col-lg-8">
									<input type="text" value="{{singleViews.department_name}}" disabled="disabled" class="form-control inputDisabled" placeholder="Service">
								</div>
							</div>
                            
                            <div class="form-group">
								<label class="col-lg-4 control-label">Grade</label>
								<div class="col-lg-8">
									<input type="text" value="{{singleViews.grade}}" disabled="disabled" class="form-control inputDisabled" placeholder="S2">
								</div>
							</div>
                            
                            <div class="form-group">
								<label class="col-lg-4 control-label">Roll</label>
								<div class="col-lg-8">
									<input type="text" value="{{singleViews.role_name}}" disabled="disabled" class="form-control inputDisabled">
								</div>
							</div>
							
							<div class="clearfix right">
								<button type="button" class="btn btn-primary mr5" ng-click="stepNext(0)">Previous</button>
								<button type="submit" class="btn btn-primary" ng-click="stepNext(2)">Next</button>
							</div>
						</form>
						<!-- #end step 2 -->
                        
						<!-- step 3 -->
                        <form class="form-horizontal col-lg-10" name="wizard-step-2" ng-show="steps[2]" novalidate>
                         	<div class="form-group">
								<label class="col-lg-4 control-label">Qualification</label>
								<div class="col-lg-8">
									<input type="text" disabled="disabled" value="{{singleViews.qualification}}" class="form-control inputDisabled">
								</div>
							</div>
                            <div class="form-group">
								<label class="col-lg-4 control-label">Specialization</label>
								<div class="col-lg-8">
									<input type="text" disabled="disabled" value="{{singleViews.specialization}}" class="form-control inputDisabled">
								</div>
							</div>
                            <div class="form-group">
								<label class="col-lg-4 control-label">Total Experience</label>
								<div class="col-lg-8">
									<input type="text" value="{{singleViews.total_experience}}" disabled="disabled" class="form-control inputDisabled">
								</div>
							</div>
                            <div class="form-group">
								<label class="col-lg-4 control-label">EL Experience</label>
								<div class="col-lg-8">
									<input type="text" value="{{singleViews.el_experience}}" disabled="disabled" class="form-control inputDisabled">
								</div>
							</div>
                            <div class="form-group">
								<label class="col-lg-4 control-label">Joining Date</label>
								<div class="col-lg-8">
									<input type="text"  value="{{singleViews.joining_date}}" disabled="disabled" class="form-control inputDisabled">
								</div>
							</div>
                            <div class="clearfix right">
								<button type="button" class="btn btn-primary mr5" ng-click="stepNext(1)">Previous</button>
								<button type="submit" class="btn btn-primary" ng-click="stepNext(0)">Next</button>
							</div>
                        </form>
						<!-- #end step 3 -->
					</div>
				</div>
			</div>
			<!-- #end form wizard -->
		</div> <!-- #end row -->
	</div> <!-- #end page-wrap -->
</div>