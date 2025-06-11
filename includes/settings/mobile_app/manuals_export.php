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
    <div class="modal-style">	
        <div class="modal-header clearfix">
            <h4 class="modal-title">Export Manuals</h4>
            <span class="close ion ion-android-close" ng-click="modalClose()"></span>
        </div>
        <div class="modal-body" ng-controller="addingform">
            <form class="form-horizontal forms_add" data-went="#/settings/manuals/manuals_view" method="post" url="services/settings/manuals_export" ng-submit="sendPost()" novalidate>
              <div class="row form-group">
                   <div class="col-sm-10 col-sm-offset-1 mb20" ng-controller="productdropCntrl">
                        <label class="selectlabel">Product</label>
                        <select class="form-control testSelAll2 selectdrop" placeholder="Product" name="product[]" ng-model="product" multiple="multiple">
                            <option ng-repeat="product in firstDrop" value="{{product.alias}}">{{product.name}}</option>
                            <option ng-if="firstDrop.length==0">No Records</option>
                        </select>
                    </div>
					<div class="col-sm-10 col-sm-offset-1 mb20" ng-controller="segmentdropCntrl">
						<label class="selectlabel">Segment</label>
						<select name="segment[]" placeholder="Segment" class="form-control testSelAll2 selectdrop" ng-model="segment" multiple="multiple">
							<option ng-repeat="segment in firstDrop" value="{{segment.alias}}">{{segment.name}}</option>
							<option ng-if="firstDrop.length==0">No Records</option>
						</select>
                    </div>
			</div>
			<div class="row form-group">
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