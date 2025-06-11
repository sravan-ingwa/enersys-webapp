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
<div class="modal-style">
	<div class="modal-header clearfix">
		<h4 class="modal-title">Export DPR</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()"></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
		<form class="form-horizontal forms_add" data-went="#/calendar" method="post" url="services/calender/dprexport" ng-submit="sendPost()" novalidate>
			<div class="row form-group">
				<div ng-controller="DatepickerDemoCtrl">
					<div class="col-sm-6 mb20">
						<md-input-container flex="" class="md-default-theme">
							<label for="input_00D">From Date</label>
							<input type="text" ng-model="fromdate" name="from_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened1')" ng-focus="open($event,'opened1')" is-open="opened1" date-lower-than="{{ToDate}}" min-date="minDate" max-date="" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"  ng-focus="fromtocal()"/>
						</md-input-container>
					</div>
					<div class="col-sm-6 mb20">
						<md-input-container flex="" class="md-default-theme">
							<label for="input_00E">To Date</label>
							<input type="text" ng-model="todate" name="to_date" class="datepicker" placeholder="Select date.." datepicker-popup="{{format}}" ng-click="open($event,'opened2')" ng-focus="open($event,'opened2')" is-open="opened2" date-greater-than="{{FromDate}}" min-date="dateDiff" max-date="" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  show-button-bar="false"/>
						</md-input-container>
					</div>
				</div>
				<div ng-controller="roleEmpDropCtrl" ng-if="<?php echo $_REQUEST["drop_hide"]; ?>">
					<div class="col-sm-6">
					 <label class="selectlabel">Employee Role</label>
					   <select class="form-control selectdrop testSelAll2" name="role_alias1[]" ng-model="emprole" placeholder="Employee Role"  data-ng-change="role_emp_mul_all()" multiple="multiple">
							<option ng-repeat="emprole in firstDrop" value="{{emprole.alias}}">{{emprole.name}}</option>
					   </select>
					</div>
					<div class="col-sm-6">
					<label class="selectlabel">Employee Names</label>
					   <select class="form-control selectdrop testSelAll2" name="employee_alias1[]" placeholder="Employee Names" ng-model="employee_alias"  multiple="multiple">
							<option ng-repeat="emp in secondDrop" value="{{emp.alias}}">{{emp.name}}</option>
					   </select>
					</div>
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