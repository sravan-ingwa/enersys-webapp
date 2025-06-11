<style>
.selectdrop{overflow-y:scroll;}
.form-group {margin-bottom:0px !important;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.singleSelect{width:100%; border-bottom:1px solid #e0e0e0;}
.SumoSelect > .optWrapper {right:0px !important;}
.SumoSelect > .CaptionCont > span.placeholder {color:#ccc !important;}
.singleSelect > .CaptionCont > label > i {color:#000;}
.SumoSelect > .optWrapper.open {top:33px !important;}
.loader { position: absolute; top: 25%; left: 45%; z-index: 10000;}
.expLoader{width: 100%;background-color: transparent;height: 100%;position: absolute;z-index: 10; right:0px; top:0px; display:none;}
</style>
<div class="modal-style" ng-controller="fromToDateCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Export Tickets</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
		 <!--<div class="toast toast-topRight">
			<alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
				<div ng-bind-html="toast.msg"></div>
			</alert>
		</div>-->
		<div class="expLoader"><span class="loader"><img src="images/ajax-loader.gif" alt="loader"></span></div>
		<form class="form-horizontal forms_add" name="ticketsexportForm" data-went="#/tickets" method="post" url="services/esca/ticket_export" ng-submit="sendPost()" novalidate>
                <div class="row form-group">
                    <div class="col-sm-4" ng-controller="tktsegmentdropCntrl">
                    	<label class="selectlabel">Segment</label>
                        <select class="form-control selectdrop testSelAll2" placeholder="Segment" name="segment_alias[]" ng-model="segment" multiple="multiple" >
                            <option ng-repeat="segment in firstDrop" value="{{segment.alias}}">{{segment.name}}</option>
                        </select>
                    </div>
                    <div ng-controller="DatepickerDemoCtrl">
                        <div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme">
                                <label for="input_00D">From Date</label>
                                <input type="text" ng-model="fromdate" name="from_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" ng-focus="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false" ng-focus="fromtocal()"/>
                           </md-input-container>
                        </div>
                        <div class="col-sm-4">
                            <md-input-container flex="" class="md-default-theme">
                                <label for="input_00E">To Date</label>
                                <input type="text" ng-model="todate" name="to_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" ng-focus="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}"  min-date="dateDiff" max-date="dt" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" show-button-bar="false">
                            </md-input-container>
                        </div>
                    </div>
                </div>
                <div class="row form-group" ng-controller="expzoneStateMulCntrl">
                	<div class="col-sm-4">
                        <label class="selectlabel">Zone</label>
                        <select multiple="multiple" placeholder="Zone" name="zone_alias[]" class="testSelAll2 form-control selectdrop" ng-model="zones" ng-init="dep_drop(singleViews.zone_alias)" data-ng-change="dep_drop_mul_exp()">
                            <option ng-repeat="zone in firstDrop" value="{{zone.alias}}" ng-if="zone.alias!='4VTSNSSBM9'">{{zone.name}}</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label class="selectlabel">State</label>
                        <select class="form-control testSelAll2 selectdrop" placeholder="State" name="state_alias[]" id="state" ng-model="states" multiple="multiple">
                            <option ng-repeat="state in secondDrop" value="{{state.alias}}">{{state.name}}</option>
                        </select>
                    </div>
                    <div class="col-sm-4" ng-controller="tktactivitydropCntrl">
                        <label class="selectlabel">Activity</label>
                        <select class="form-control testSelAll2 selectdrop" placeholder="Activity" name="activity_alias[]" ng-model="activity" multiple="multiple">
                            <option ng-repeat="activity in firstDrop" value="{{activity.alias}}">{{activity.name}}</option>
                        </select>
                    </div>
                </div>    
                <div class="row form-group">   
                	<div class="col-sm-4" ng-controller="tktcomplaintdropCntrl">
                            <label class="selectlabel">Complaint</label>
                            <select class="form-control testSelAll2 selectdrop" placeholder="Complaint" name="complaint_alias[]" ng-model="complaint" multiple="multiple">
                                <option ng-repeat="complaint in firstDrop" value="{{complaint.alias}}">{{complaint.name}}</option>
                            </select>
                    </div> 
                    <div class="col-sm-4" ng-controller="tktcustomerdropCntrl">
                            <label class="selectlabel">Customer ID</label>
                            <select class="form-control testSelAll2 selectdrop" placeholder="Customer ID" name="customer_alias[]" ng-model="customer" multiple="multiple">
                                <option ng-repeat="customer in firstDrop" value="{{customer.alias}}">{{customer.name}}</option>
                            </select>
                    </div>
                    <div class="col-sm-4" ng-controller="productdropCntrl">
                        <label class="selectlabel">Product</label>
                        <select class="form-control testSelAll2 selectdrop" placeholder="Product" name="product[]" ng-model="product" multiple="multiple">
                            <option ng-repeat="product in firstDrop" value="{{product.alias}}">{{product.name}}</option>
                            <option ng-if="firstDrop.length==0">No Records</option>
                        </select>
                    </div>
                </div>   
                <div class="row form-group">
				<div class="col-sm-4">
                    <label class="selectlabel">Data Type</label>
                    <select class="form-control testSelAll2 selectdrop" placeholder="Data Type" name="export_bifurcation[]" ng-model="export_bifurcation" multiple="multiple">
                        <option value="1">Tickets</option>
                        <option value="2">TT SA</option>
                    </select>
                </div>
                <div class="col-sm-4" ng-controller="tatDropCntrl">
                    <label class="selectlabel">TAT</label>
                    <select class="form-control testSelAll2 selectdrop" placeholder="TAT" name="tat[]" ng-model="tat" multiple="multiple">
                        <option ng-repeat="tt in tats" value="{{tt.name}}">{{tt.name}}</option>
                        
                    </select>
                </div>
                <div class="col-sm-4" ng-controller="tktleveldropCntrl">
                    <label class="selectlabel">Ticket Level</label>
                    <select class="form-control testSelAll2 selectdrop" placeholder="Ticket Level" name="level_alias[]" ng-model="ticket_level" multiple="multiple">
                        <option ng-repeat="ticket in firstDrop" value="{{ticket.alias}}">{{ticket.name}}</option>
                        <option value="8" ng-if="firstDrop.length!=0">PLAN FAIL</option>
                        <option ng-if="firstDrop.length==0">No Records</option>
                    </select>
                </div>
                <!--<div class="col-sm-4" ng-controller="">
                    <label class="selectlabel">Aging</label>
                    <select class="form-control testSelAll2 selectdrop" placeholder="Aging" name="aging_alias[]" ng-model="agingcode" multiple="multiple">
                        <option ng-repeat="aging in firstDrop" value="{{aging.alias}}">{{aging.name}}</option>
                    </select>
                </div>-->
                </div>
                    
                <div class="row form-group">    
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

<!--<div class="col-sm-10 col-sm-offset-1 mb10" ng-controller="productdropCntrl">
        <label class="selectlabel">Product Code</label>
        <select class="form-control testSelAll2 selectdrop" placeholder="Product Code" name="product_alias[]" ng-model="productcode" multiple="multiple">
            <option ng-repeat="product in firstDrop" value="{{product.alias}}">{{product.name}}</option>
        </select>
</div>-->


<!-- <div class="col-sm-10 col-sm-offset-1 mb10" ng-controller="">
        <label class="selectlabel">Aging</label>
        <select class="form-control testSelAll2 selectdrop" placeholder="Aging" name="aging_alias[]" ng-model="agingcode" multiple="multiple">
            <option ng-repeat="aging in firstDrop" value="{{aging.alias}}">{{aging.name}}</option>
        </select>
    </div>-->