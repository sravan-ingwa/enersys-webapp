<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
</style>
<div class="modal-style">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Export Customer</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
        <!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
        <form class="form-horizontal forms_add" name="customerForm" data-went="#/settings/customer/customer_view" method="post" url="services/settings/customer_export" ng-submit="sendPost()" novalidate>
                <div class="row form-group">
					<div class="col-sm-10 col-sm-offset-1 mb10" ng-controller="productdropCntrl">
						<label class="selectlabel">Product Code</label>
						<select class="form-control testSelAll2 selectdrop" placeholder="Product Code" name="product_alias[]" ng-model="productcode" multiple="multiple">
                            <option ng-repeat="product in firstDrop" value="{{product.alias}}">{{product.name}}</option>
                    	</select>
                    </div>
					<div class="col-sm-10 col-sm-offset-1 mb20">
						<label class="selectlabel">Status</label>
						<select placeholder="Status" name="status" class="testSelAll2 form-control" ng-model="status">
							<option value="0">ACTIVE</option>
							<option value="1">DEACTIVE</option>
						</select>
					</div>
                     <div class="col-sm-6 col-sm-offset-5">
                      <input type="submit" click-once value="Run Report" class="btn btn-info btn-sm"/>
                    </div>
               </div>
          </form>   
	</div>
</div>
<script>
setInterval(function(){$('.testSelAll2').SumoSelect({selectAll:true});
$('.forms_add').find('.SumoSelect').addClass('singleSelect');},0);
</script>