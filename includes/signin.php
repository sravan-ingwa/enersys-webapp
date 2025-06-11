<style>
	.oktalogo {
		font-size: 38px;
		vertical-align: middle;
		background: url(/images/okta-logo.png) no-repeat 71%;
		height: 50px;
		width: 70px;
		background-size: 70px;
		display: inline-block;
	}
	.oktalogoimg {
		width: 60px;
		height: 20px;
		margin-left: 11px;
		margin-top: -4px;
	}
	.connect_icon {
		text-align: center;
		margin-bottom: 30px;
		margin-top: 25px;
	}
	.connect_icon span {
		position: relative;
		left: 10px;
		line-height: 0;
		margin-bottom: 16px;
		top: 4px;
		line-height: 40px;
		font-size: 17px;
	}
	.mb50 {
		margin-top: 30px;
		margin-bottom: 30px;
	}
</style>

<div class="page page-auth" style="margin-top:0px;">
	<div class="auth-container">
		<div class="form-head">
			<h1 class="site-logo h2 mb5 mt5 text-center text-uppercase text-bold"><img src="images/logo_r.png" alt="logo" width="250"><br><span class="version"><!--<small>Powered by EnerSys</small>--></span></h1>
		</div>
		<div class="form-container" ng-controller="loginform" ng-if="!hideLoginForm">
			<div ng-include="'includes/loading.php'"></div>
			<form class="form-horizontal forms_ec" data-went="#/dashboard" method="post" url="services/login_web" ng-submit="loginValidate()" novalidate>
			<!--
				<div class="toast toast-topRight">
					<alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
						<div ng-bind-html="toast.msg"></div>
					</alert>
				</div>
			-->
				<div class="connect_icon">
                   	<span>Welcome to EnerSys Care! Sign in with your organizational account</span>
					<img src="/images/okta-logo.png" class="oktalogoimg">
                </div>
				<div class="btn-group btn-group-justified mb50">
					<div class="btn-group">
					</div>
					<div class="btn-group">
						<a href="/okta/login.php" type="reset" class="btn btn-success">Sign In</a>
					</div>
					<div class="btn-group">
					</div>
				</div>
				<div style="text-align: center;"> 
					Customers / Vendors <a href="javascript:void(0)" ng-click="toggleClientLogin()">Click Here</a> to login
				</div>
				<div ng-if="showClientLogin">
					<md-input-container>
						<label>Login ID</label>
						<input type="text" name="user" ng-blur="user_welcome()">
					</md-input-container>
					<md-input-container>
						<label>Password</label>
						<input type="password" name="pwd">
					</md-input-container>
					<!--
					<div class="clearfix mb15"><a href="#/forgetPassword" class="text-primary small">Forgot your password?</a></div>
					-->
					<div class="btn-group btn-group-justified">
						<div class="btn-group">
							<button type="reset" class="btn btn-facebook">Reset</button>
						</div>
						<div class="btn-group">
							<button type="submit" ng-click="reloadRoute()" class="btn btn-success">Sign In</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div> <!-- #end signin-container -->
</div>
<!--<script>$('body').addClass("body-full");</script>-->
