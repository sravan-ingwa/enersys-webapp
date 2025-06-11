<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.singleSelect {
	width: 100%;
	border-bottom: 1px solid #e0e0e0
}
.SumoSelect>.optWrapper {
	right: 0!important
}
.SumoSelect>.CaptionCont>span.placeholder {
	color: #ccc!important
}
.singleSelect>.CaptionCont>label>i {
	color: #000
}
.SumoSelect>.optWrapper.open {
	top: 15px!important
}
.upload-file{border-bottom: 1px solid rgba(0,0,0,0.12); margin-top:10px;}
@media (min-width: 992px).naresh { width: 1320px !important;}
</style>
<div class="modal-style" ng-controller="totalCellDropCtrl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Create Refreshing</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
   		<!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
		<form class="form-horizontal forms_add" name="userForm" role="form" data-went="#/Refreshing" enctype="multipart/form-data" method="post" url="services/inventory/material_refreshing_add" ng-submit="sendPost()" novalidate>
				<!--<div class="row form-group">
                     <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Refreshing Number</label>
                            <input ng-model="rev_number" disabled="" class="ng-pristine ng-valid md-input ng-touched" id="input_00B" aria-invalid="false">
                        </md-input-container>
                    </div>
                  </div>-->
                <div class="row form-group mt20">
                    <div class="col-sm-4 {{secondDrop.length=='0' ? 'col-sm-offset-4':''}}">
					 <label class="selectlabel">Ware House</label>
                        <select name="wh_alias" class="form-control testSelAll2 selectdrop" placeholder="Ware House" ng-model="wh_alias" data-ng-change="wh_refreshing(wh_alias)">
                            <option value="" selected="selected">Select Ware House</option>
							<option value="{{wh.alias}}" ng-repeat="wh in firstDrop">{{wh.name}}</option>
                        </select>
                    </div>
                    <div class="col-sm-4" ng-if="secondDrop.length!='0'">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Engineer Name</label>
                            <input ng-model="engineername" class="ng-pristine ng-valid md-input ng-touched" name="eng_name" id="input_00B" tabindex="0" aria-invalid="false">
                        </md-input-container>
                    </div>
					  <div class="col-sm-4 filesRow" ng-if="secondDrop.length!='0'">
							<input value="{{file_name}}" class="form-control uploadFile" placeholder="Upload A Report" disabled="disabled"/>
							<div class="fileUpload btn btn-sm btn-info" tooltip="Upload PDF" tooltip-placement="right">
								<span class="ion ion-upload"></span>
								<input type="file" class="upload uploadBtn" name="pdf" ng-model="pdf" id="pdf" onchange="angular.element(this).scope().upload_report(this.files,'pdf')"/>
							</div>
							 <div ng-if="determinateValue >= '100' ? closeloadings() : ''"></div>
							<div class="mb20" ng-if="prg_shw_hde">
								<md-progress-linear class="md-warn" md-mode="buffer" value="{{determinateValue}}" md-buffer-value="{{determinateValue2}}"></md-progress-linear>
							</div>
					  </div>
                   </div>
				<h3 ng-if="secondDrop.length=='0' && userForm.wh_alias.$dirty" class="text-center panel-body">No Cells for Refreshing</h3>
                <div ng-if="secondDrop.length!='0'">
               	<div class="row form-group mt10">
                    <div class="panel panel-default" style="overflow:scroll;height:500px;">
                        <table class="table table-condensed" style="width:1500px;">
                            <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th width="9%">Cell Sr. No.</th>
                                <th>Mfd. Date</th>
                                <th>OCV</th>
                                <th>Charging Current</th>
                                <th>1st Hr.</th>
                                <th>2nd Hr.</th>
                                <th>3rd Hr.</th>
                                <th>4th Hr.</th>
                                <th>5th Hr.</th>
                                <th>6th Hr.</th>
                                <th>7th Hr.</th>
                                <th>8th Hr.</th>
                                <th>9th Hr.</th>
                                <th>10th Hr.</th>
                                <th width="9%">Result</th>
                            </tr>
                            </thead>
                        </table>
                        <table class="table table-bordered table-striped" style="width:1500px;">
                            <tbody>
                                <tr ng-style="(clr[key] || clr1[key] || clr2[key] || clr3[key] || clr4[key] || clr5[key] || clr6[key] || clr7[key] || clr8[key] || clr9[key] || clr10[key] || clr11[key] || clr12[key] || clr13[key] || result[key]) && {'background-color':'#CCC'} || {'background-color': '#FFF'}" ng-modal="cells" ng-repeat="(key, cell) in secondDrop">
                                    <td><input type="text" class="form-control" placeholder="{{key+1}}" readonly="readonly"></td>
                                    <td width="9%" ng-init="result[key]=''">
                                    <input type="hidden" ng-attr-name="{{result[key]!='' ? 'cell_sr_no[]' : ''}}" value="{{cell.alias}}">
                                    <input type="text" class="upper form-control" readonly="readonly" valid-input placeholder="Cell Sr. No." value="{{cell.name}}"></td>
                                    <td><input type="text" ng-model="clr[key]" class="form-control" ng-attr-name="{{result[key]!='' ? 'mf_date[]' : ''}}" mask="19.99" ng-model="mf_date[key]" restrict="reject" clean="true" placeholder="Mfd. Date"></td>
                                    <td><input type="text" ng-model="clr2[key]" class="form-control" ng-attr-name="{{result[key]!='' ? 'ocv[]' : ''}}" mask="9.99" ng-model="ocv[key]" restrict="reject" clean="true" placeholder="OCV"></td>
                                    <td><input type="text" ng-model="clr3[key]" class="form-control" ng-attr-name="{{result[key]!='' ? 'dis_current[]' : ''}}" placeholder="Dis. Current "></td>
                                    <td><input type="text" ng-model="clr4[key]" class="form-control" ng-attr-name="{{result[key]!='' ? 'a[]' : ''}}" mask="9.99" ng-model="th1[key]" restrict="reject" clean="true" placeholder="1st"></td>
                                    <td><input type="text" ng-model="clr5[key]" class="form-control" ng-attr-name="{{result[key]!='' ? 'b[]' : ''}}" mask="9.99" ng-model="th2[key]" restrict="reject" clean="true" placeholder="2nd"></td>
                                    <td><input type="text" ng-model="clr6[key]" class="form-control" ng-attr-name="{{result[key]!='' ? 'c[]' : ''}}" mask="9.99" ng-model="th3[key]" restrict="reject" clean="true" placeholder="3rd"></td>
                                    <td><input type="text" ng-model="clr7[key]" class="form-control" ng-attr-name="{{result[key]!='' ? 'd[]' : ''}}" mask="9.99" ng-model="th4[key]" restrict="reject" clean="true" placeholder="4th"></td>
                                    <td><input type="text" ng-model="clr8[key]" class="form-control" ng-attr-name="{{result[key]!='' ? 'e[]' : ''}}" mask="9.99" ng-model="th5[key]" restrict="reject" clean="true" placeholder="5th"></td>
                                    <td><input type="text" ng-model="clr9[key]" class="form-control" ng-attr-name="{{result[key]!='' ? 'f[]' : ''}}" mask="9.99" ng-model="th6[key]" restrict="reject" clean="true" placeholder="6th"></td>
                                    <td><input type="text" ng-model="clr10[key]" class="form-control" ng-attr-name="{{result[key]!='' ? 'g[]' : ''}}" mask="9.99" ng-model="th7[key]" restrict="reject" clean="true" placeholder="7th"></td>
                                    <td><input type="text" ng-model="clr11[key]" class="form-control" ng-attr-name="{{result[key]!='' ? 'h[]' : ''}}" mask="9.99" ng-model="th8[key]" restrict="reject" clean="true" placeholder="8th"></td>
                                    <td><input type="text" ng-model="clr12[key]" class="form-control" ng-attr-name="{{result[key]!='' ? 'i[]' : ''}}" mask="9.99" ng-model="th9[key]" restrict="reject" clean="true" placeholder="9th"></td>
                                    <td><input type="text" ng-model="clr13[key]" class="form-control" ng-attr-name="{{result[key]!='' ? 'j[]' : ''}}" mask="9.99" ng-model="th10[key]" restrict="reject" clean="true" placeholder="10th"></td>
                                    <td width="9%">
                                    	<select ng-attr-name="{{result[key]!='' ? 'result[]' : ''}}" ng-model="result[key]" class="form-control" placeholder="Result">
                                        	<option value="" ng-selected="true">Result</option>
                                        	<option value="1">Charged</option>
                                        </select>                               
                                    </td>
                               </tr>
                           </tbody>
                        </table>
                    </div>
				</div>
                   <div class="row form-group"> 
                        <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm">Create</button>
                            <button type="reset" class="btn btn-info btn-sm">Reset</button>
                        </div>
                </div>
           </div>
		</form>
	</div>
</div>
<script>
$(document).ready(function(){
	/* $(document).on('keypress','.voltVal',function (e){
		if(isNaN($(this).val())){
			$(this).val("");
		}else{
			var valint=$(this).val();
				if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) { return false;	}
				else{if(valint.length==1)valint=valint+'.';}
			if(valint.length>3)return false;
			else $(this).val(valint);
			
		}
	});
	$(document).on('keypress','.manfVal',function (e){
		var typed=String.fromCharCode(window.event.keyCode);
		var psr=/[0-9,\/]/;
		var valint=$(this).val();
		vsd=$(this);
		if(valint.length<=4){
			if(psr.test(typed)){
				if(valint.length==2){valint=valint+'/';}
				if(valint.length<=4){$(this).val(valint);}
				else return false; 
			}else{
				setTimeout(function(){$(vsd).val('');},100);
			}
		}else{return false;}  
	}); */
});	
</script>

<script>
	setInterval(function(){
		$('.testSelAll2').SumoSelect({selectAll:true});$('.testSelAll3').SumoSelect();
		$('.forms_add').find('.SumoSelect').addClass('singleSelect');
	},0);
	$("[type=file]").on("change", function(){
	  var file = this.files[0].name;
	  var dflt = $(this).attr("placeholder");
	  if($(this).val()!="")$(this).next().text(file);else $(this).next().text(dflt);
	});
</script>