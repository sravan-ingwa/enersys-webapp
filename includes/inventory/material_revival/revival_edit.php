<style>
.form-group {margin-bottom:15px;}
.form-group div.col-sm-4{margin-bottom:15px;}
.modal-header > .close {right:-30px; top:-12px;}
.upload-file{border-bottom: 1px solid rgba(0,0,0,0.12); margin-top:10px;}
@media (min-width: 992px).naresh { width: 1320px !important;}
</style>
<div class="modal-style" ng-controller="revivalEditCntl">	<!-- wrapper for specific style -->
	<div class="modal-header clearfix">
		<h4 class="modal-title">Edit Revival</h4>
		<span class="close ion ion-android-close" ng-click="modalClose()" md-ink-ripple></span>
	</div>
	<div class="modal-body" ng-controller="addingform">
   		<!--<div class="toast toast-topRight">
            <alert ng-repeat="toast in toasts" type="{{toast.type}}" close="closeAlert($index)" class="toast-{{toast.anim}}">
                <div ng-bind-html="toast.msg"></div>
            </alert>
        </div>-->
		<form class="form-horizontal forms_add" name="userForm" role="form" data-went="#/Revival" enctype="multipart/form-data" method="post" url="services/inventory/material_revival_update" ng-submit="sendPost()" novalidate>
				<input type="hidden" name="revival_alias" value="{{singleViews.revival_alias}}" />
                <input type="hidden" name="old_pdf" value="{{singleViews.pdf}}" />
                <!--<div class="row form-group">
                     <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Revival Number</label>
                            <input ng-model="rev_number" disabled="" class="ng-pristine ng-valid md-input ng-touched" id="input_00B" aria-invalid="false">
                        </md-input-container>
                    </div>
                  </div>-->
                  
                <div class="row form-group mt20">
                    <div class="col-sm-4">
                        <md-input-container flex="" class="md-default-theme">
                            <label for="input_00D">Engineer Name</label>
                            <input type="text" ng-model="singleViews.eng_name" class="ng-pristine ng-valid md-input ng-touched" value="{{singleViews.eng_name}}" name="eng_name" id="input_00B" tabindex="0" aria-invalid="false">
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
               	<div class="row form-group mt10">
                    <div class="panel panel-default" style="overflow:scroll;height:500px;">
                        <table class="table table-condensed" style="width:1500px;">
                            <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th width="9%">Cell Sr. No.</th>
                                <th>Mfd. Date</th>
                                <th>OCV</th>
                                <th>Discharge Current</th>
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
                                <tr ng-modal="cells" ng-repeat="(key, cell) in singleViews.type">
                                    <td><input type="text" class="form-control" value="{{key+1}}" ng-readonly="true"></td>
                                    <td width="9%">
										<input type="hidden" value="{{cell.cell_sr_no_alias}}" name="cell_sr_no[]" ng-disabled="cell.disable"/>
										<input type="text" class="form-control" value="{{cell.cell_sr_no}}" ng-disabled="cell.disable" ng-readonly="!cell.disable" placeholder="Cell Sr. No."/>
									</td>
                                    <td><input type="text" class="form-control" value="{{cell.mf_date}}" name="mf_date[]" mask="19.99" ng-model="mf_date[key]" restrict="reject" clean="true" placeholder="Mfd. Date" ng-disabled="cell.disable"></td>
                                    <td><input type="text" class="form-control" value="{{cell.ocv}}" name="ocv[]" mask="9.99" ng-model="ocv[key]" restrict="reject" clean="true" placeholder="OCV" ng-disabled="cell.disable"></td>
                                    <td><input type="text" class="form-control" value="{{cell.dis_current}}" name="dis_current[]" placeholder="Dis. Current" ng-disabled="cell.disable"></td>
                                    <td><input type="text" class="form-control" value="{{cell.a}}" name="a[]" mask="9.99" ng-model="th1[key]" restrict="reject" clean="true" placeholder="1st" ng-disabled="cell.disable"></td>
                                    <td><input type="text" class="form-control" value="{{cell.b}}" name="b[]" mask="9.99" ng-model="th2[key]" restrict="reject" clean="true" placeholder="2nd" ng-disabled="cell.disable"></td>
                                    <td><input type="text" class="form-control" value="{{cell.c}}" name="c[]" mask="9.99" ng-model="th3[key]" restrict="reject" clean="true" placeholder="3rd" ng-disabled="cell.disable"></td>
                                    <td><input type="text" class="form-control" value="{{cell.d}}" name="d[]" mask="9.99" ng-model="th4[key]" restrict="reject" clean="true" placeholder="4th" ng-disabled="cell.disable"></td>
                                    <td><input type="text" class="form-control" value="{{cell.e}}" name="e[]" mask="9.99" ng-model="th5[key]" restrict="reject" clean="true" placeholder="5th" ng-disabled="cell.disable"></td>
                                    <td><input type="text" class="form-control" value="{{cell.f}}" name="f[]" mask="9.99" ng-model="th6[key]" restrict="reject" clean="true" placeholder="6th" ng-disabled="cell.disable"></td>
                                    <td><input type="text" class="form-control" value="{{cell.g}}" name="g[]" mask="9.99" ng-model="th7[key]" restrict="reject" clean="true" placeholder="7th" ng-disabled="cell.disable"></td>
                                    <td><input type="text" class="form-control" value="{{cell.h}}" name="h[]" mask="9.99" ng-model="th8[key]" restrict="reject" clean="true" placeholder="8th" ng-disabled="cell.disable"></td>
                                    <td><input type="text" class="form-control" value="{{cell.i}}" name="i[]" mask="9.99" ng-model="th9[key]" restrict="reject" clean="true" placeholder="9th" ng-disabled="cell.disable"></td>
                                    <td><input type="text" class="form-control" value="{{cell.j}}" name="j[]" mask="9.99" ng-model="th10[key]" restrict="reject" clean="true" placeholder="10th" ng-disabled="cell.disable"></td>
                                    <td width="9%">
                                    	<select name="result[]" class="form-control" placeholder="Result" ng-disabled="cell.disable">
                                        	<option value="">Result</option>
                                        	<option value="6" ng-selected="cell.result==6">In Progress</option>
                                        	<option value="2" ng-selected="cell.result==2">Pass</option>
                                        	<option value="3" ng-selected="cell.result==3">Fail</option>
                                        </select>                               
                                    </td>
                               </tr>
                           </tbody>
                        </table>
                    </div>
				</div> 
                   <div class="row form-group"> 
                        <div class="col-sm-6 col-sm-offset-5">
                            <button type="submit" click-once class="btn btn-info btn-sm">Update</button>
                            <button type="reset" class="btn btn-info btn-sm">Reset</button>
                        </div>
                </div>
		</form>
	</div>
</div>
<script>
$(document).ready(function(){
	$(document).on('keypress','.voltVal',function (e){
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
	});
});	
</script>