<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.singleSelect{width:475px; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
</style>
    <div class="modal-style">	<!-- wrapper for specific style -->
        <div class="modal-header clearfix">
            <h4 class="modal-title">Export State</h4>
            <span class="close ion ion-android-close" ng-click="modalClose()"></span>
        </div>
        <div class="modal-body" ng-controller="addingform">
            <form class="form-horizontal forms_add" data-went="#/settings/state/state_view" method="post" url="services/settings/state_export" ng-submit="sendPost()" novalidate>
              <div class="row form-group">
                   <div ng-controller="expzoneStateMulCntrl">
                        <div class="col-sm-10 col-sm-offset-1 mb20">
                   			<label class="selectlabel">Zone</label>
                            <select multiple="multiple" placeholder="Zone" name="zone_alias[]" class="testSelAll2 form-control selectdrop" ng-model="zones" ng-init="dep_drop(singleViews.zone_alias,'state_alias[]')" data-ng-change="dep_drop_mul_exp()">
                                <option ng-repeat="zone in firstDrop" value="{{zone.alias}}">{{zone.name}}</option>
                            </select>
                        </div>
                        <div class="col-sm-10 col-sm-offset-1 mb20">
                           	<label class="selectlabel">State</label>
                            <select class="form-control testSelAll2 selectdrop" placeholder="State" name="state_alias[]" id="state" ng-model="states" multiple="multiple">
                                <option ng-repeat="state in secondDrop" value="{{state.alias}}">{{state.name}}</option>
                            </select>

                        </div>
                    </div>
                    <div class="col-sm-6 col-sm-offset-5">
                        <input type="submit" click-once value="Run Report" class="btn btn-info btn-sm" />
                    </div>
                </div>
            </form>
          </div>
        </div>
<script>
setInterval(function(){$('.testSelAll2').SumoSelect({selectAll:true});
$('.forms_add').find('.SumoSelect').addClass('singleSelect');},0);
</script>