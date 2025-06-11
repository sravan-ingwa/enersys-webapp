<style>
	.loader{position: absolute; top: 42%; left: 48%; z-index: 10000;}
	.expLoader{width: 100%;background-color: transparent;height: 100%;position: absolute;z-index: 10; right:0px; top:0px; display:none;}
</style>
<div class="page page-auth">
    <div class="auth-container">
        <div class="form-head mb20">
            <h1 class="site-logo h2 mb5 mt5 text-center text-uppercase text-bold"><img src="images/gallery/EnerSyslogo.png" alt="logo" width="250"><span class="version">V 2.0</span></h1>
        </div>
        <div class="form-container"  ng-controller="addingform">
			<!--<div class="toast toast-topRight">
				<alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
					<div ng-bind-html="toast.msg"></div>
				</alert>
			</div>-->
            <div class="expLoader"><span class="loader"><img src="../images/ajax-loader.gif" height="40" width="40" alt="loader"></span></div>
            <form class="form-horizontal forms_add" data-went="#/signin" method="post" url="services/forgot" ng-submit="sendPost()" novalidate>
                <p class="small text-center">Enter your Employee ID. We'll send you reset link to the registered email id.</p>
                <md-input-container>
                    <label>Employee ID</label>
                    <input type="text" name="emp_id" placeholder="Enter your Employee ID">
                </md-input-container>
                <div class="btn-group btn-group-justified mb15">
                    <div class="btn-group">
                        <button type="reset" class="btn btn-facebook">Reset</button>
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success">Request</button>
                    </div>
                </div> 
            </form>
            <center><a href="#/signin" class="small">Sign In Now</a></center>
        </div>
    </div> <!-- #end signin-container -->
</div>
<script>$('body').addClass("body-full");</script>