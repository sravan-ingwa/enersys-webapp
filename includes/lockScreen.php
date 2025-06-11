<style>
.app.body-full .main-container{transform:none !important; top:0% !important;}
</style>
<div id="bg" class="" data-panel="fourth">
<div class="matt-black"></div>
  <img src="images/gallery/bg-map4.jpg" class="backgroundImg" alt="">
</div>
    <div class="page page-auth clearfix loginforms-bdy">
        <div class="auth-container lock-screen">
            <div class="form-container"  ng-controller="addingform">
                <div class="profile clearfix mb20" ng-controller="profileCtrl">
                    <img src="images/gallery/profile_male" width="150" height="150" alt="admin">
                    <h4 class="name">{{singleViews.emp_name}}</h4>
                    <p class="text-uppercase">{{singleViews.privilege_name}}</p>
                </div>
                <form class="form-horizontal forms_ec" data-went="#/dashboard" method="post" url="services/lockscreen" ng-submit="sendPost()" novalidate>
                    <md-input-container>
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Enter your password">
                    </md-input-container>
                    <button class="btn btn-success btn-block">Unlock</button>
                </form>
            </div>
        </div>
    </div>
<script>$('body').addClass("body-full");</script>