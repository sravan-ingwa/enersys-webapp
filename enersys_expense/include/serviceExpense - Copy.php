<style>
.tbform input[type="text"], .tbform input[type="file"], .tbform select{border:none !important;margin:0 !important;padding:0 !important;width:100% !important;outline:none !important;webkit-box-shadow: none;box-shadow: none;}
.tbform input[type="text"]:focus, .tbform input[type="file"]:focus, .tbform select:focus{outline:none !important;webkit-box-shadow: none;box-shadow: none;}
.table-bordered{margin-bottom:5px !important;}
.redd{color:#F00 !important;}
</style>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Book Expenses</h3>
	</div>
	<div class="panel-body">
        <form role="form" class="ss_form" method="post" id="defaultForm" novalidate>
        <input type="hidden" value="<?php echo $ref;?>" name="ref" />
       	<p class='alerta' role='alert'><i>fdfgdfg</i></p>
        <div class="col-xs-10 jerror"><?php if(isset($message))echo $message;?></div>
		<div class="row">
        <div class="col-md-4 form-group">
            <label>Date of Request : </label>
            <input class="form-control" type="text" value="<?php echo date('d-M-Y'); ?>" placeholder="Date of Request" readonly/>
        </div>
        <div class="col-md-4 form-group">
            <label>Employee ID : </label>
            <input class="form-control" type="text" value="<?php echo employeeDetails('employee_id',$_SESSION['ec_user_alias']);?>" placeholder="Employee ID" readonly/>
        </div>
        <div class="col-md-4 form-group">
            <label>Employee Name: </label>
            <input class="form-control" type="text" value="<?php echo employeeDetails('name',$_SESSION['ec_user_alias']);?>" placeholder="Employee Name" readonly/>
        </div>
        <div class="col-md-4 form-group">
            <label>Grade: </label>
            <input class="form-control" type="text" value="<?php echo grade($_SESSION['ec_user_alias'])?>" placeholder="Grade" readonly/>
        </div>
        <div class="col-md-4 form-group">
            <label>Visit: Start Date: </label>
            <input type='text' class="form-control dpd1 cddl" tabindex="1" name="visitFromDate" placeholder="DD-MM-YYYY" readonly="readonly" style="background-color:#fff;"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Visit: End Date: </label>
            <input type='text' class="form-control dpd2 cddl" tabindex="2" name="visitToDate" placeholder="DD-MM-YYYY" readonly="readonly" style="background-color:#fff;"/>
        </div>
		</div>
        <div class="row">
            <div class="col-md-4 form-group">
                <label>No. of days: </label>
                <input type="text" tabindex="7" class="form-control" id="visitFromDate" placeholder="No. of days" readonly />
            </div>
            <div class="col-md-4 form-group">
                <label>Visited place's : </label>
                <input type="text" tabindex="3" class="form-control" name="placesOfVisit" placeholder="Places of Visit"/>
            </div>
            <div class="col-md-4 form-group">
                <label>Purpose: </label>
                <textarea tabindex="4" class="form-control reasonForAdv" name="purpose" placeholder="Purpose" ></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 form-group">
                <label>Remarks: </label>
                <textarea tabindex="4" class="form-control reasonForAdv" name="remarks" placeholder="Remarks" ></textarea>
            </div>
        </div>
        <div class="col-lg-12 form-group">
            <label>Conveyance : </label>&nbsp;&nbsp;<a href="#" data-get="fare0" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare0" class="RemoveField"><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix">
                <div class="column">
                    <table class="table table-bordered" id="fare_tab">
                        <thead><tr class="blue cust"><th>Date of travel</th><th>Mode of travel</th><th>From</th><th>To</th><th>Amount</th><th>DPR Number</th><th>Files (No special characters in file name)</th></tr></thead>
                        <tbody id='fare0'>
                            <tr class="tbform">
                                <td><input type="text" class="form-control expense_dates cddl" name="dot[]" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                                <td><select class="form-control" tabindex="2" required="required" name="mot[]" id="mot">
                                        <option value="0">Mode of travel</option>
                                        <option value="ACT">ACT</option>
                                        <option value="AIR">Air</option>
                                        <option value="Train 2nd AC">Train 2nd AC</option>
                                        <option value="Train 3 tier">Train 3 tier</option>
                                        <option value="Train Sleeper">Train Sleeper</option>
                                        <option value="Volvo AC Bus">Volvo AC Bus</option>
                                        <option value="Non-AC Bus">Non-AC Bus</option>
                                        <option value="Own Vehicle">Own Vehicle</option>
                                        <option value="Cab">Cab</option>
                                        <option value="Auto">Auto</option>
                                        <option value="Local Train">Local Train</option>
                                        <option value="Any Public Transport">Any Public Transport</option>
                                    </select></td>
                                <td><input type="text" class="form-control" name="from[]" placeholder="From"/></td>
                                <td><input type="text" class="form-control" name="to[]" placeholder="To"/></td>
                                <td><input type="text" class="form-control amtt tamfor tcm" name="amt[]" placeholder="Amount"/></td>
                                <td><input type="text" class="form-control" name="dprno[]" placeholder="Dpr Number"/></td>
                                <td><input type="hidden" class="form-control" name="motbill[]" value="0"/><input type="file" class="form-control" name="motbill[]"/></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-4 pull-right"><input type="text" class="form-control tcmt" name="fare_total" placeholder="Total Conveyance" readonly /></div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 form-group">
            <label>Local Conveyance : </label>&nbsp;&nbsp;<a href="#" data-get="fare5" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare5" class="RemoveField"><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix">
                <div class="column">
                  <div style="width:1032px; overflow-x:scroll;">
                    <table class="table table-bordered" id="fare_tab" style="width:2000px !important;">
                        <thead class="localCon"><tr class="blue cust"><th>Zone</th><th>State</th><th>District</th><th>Area</th><th>Bucket</th><th >Capacity</th><th>Weight of the Cell</th><th>Quantity</th><th>No of Kilometers</th><th>Amount Applicable</th><th>Date of travel</th><th>Mode of travel</th><th>From</th><th>To</th><th>Amount</th><th>DPR Number</th></tr></thead>
                        <tbody id='fare5'>
                            <tr class="tbform">
                            	<td>
                                   <select class="form-control showgradedesg" tabindex="1" name="zone[]"  required="required" autofocus="autofocus" onchange="ajaxSelect(this.options[this.selectedIndex].value,'State');">
                <option value="0" selected="selected" disabled="disabled">Zone</option>
                    <?php $getZn=getZones();if($getZn!=0){foreach($getZn as $rec){echo "<option value='".$rec['zone_alias']."'>".$rec['zone_name']."</option>";}}else echo "<option disabled='disabled'>Add Zone</option>";?>
                </select>
                                </td>
                                <td class="sel_empty">
                                    <select class="form-control showgradedesg " tabindex="2"  required="required" name="state[]" autofocus="autofocus" id="ajaxSelect_State" onchange="ajaxSelect(this.options[this.selectedIndex].value,'District')">
                    <option value="0" selected="selected" disabled="disabled" class="depsel">State</option>
                </select>
                                </td>
                                <td class="sel_empty">                                                                         
                                     <select class="form-control showgradedesg " tabindex="3"  name="district[]" autofocus="autofocus" id="ajaxSelect_District" onchange="ajaxSelect(this.options[this.selectedIndex].value,'Area')">
                     <option value="0" selected="selected" disabled="disabled" class="depsel">District</option>
                </select>
                                </td>
                                 <td>
                                 <input class="form-control" type="text" name="area[]" placeholder="Area" value="" id="ajaxSelect_Area" readonly="readonly"/>                                   
                                </td>
                                <td>
                                     <select class="form-control localConvy" tabindex="3" required="required" name="bucket[]" autofocus="autofocus">
                                        <option value="" selected="selected" disabled="disabled">Bucket</option>
                                        <option value="0">Secondary transportation </option>
                                        <option value="1">Local Conveyance</option>
                                     </select>
                                </td>
                                <td class="lclHide">
                                     <select class="form-control" tabindex="3" required="required" name="cap[]" autofocus="autofocus">
                                        <option value="0" selected="selected" disabled="disabled">Capacity</option>
                                         
                                     </select>
                                </td>
                                <td class="lclHide"><input type="text" class="form-control wofCell" name="wofCell[]" placeholder="Weight of the cell" readonly="readonly"/></td>
                                <td class="lclHide"><input type="text" class="form-control qnty" name="quantityCell[]" placeholder="Quantity" /></td>
                                <td class="lclHide"><input type="text" class="form-control amtt tamfor numKilo" name="numKilometers[]" placeholder="No.of Kilometers"/></td>
                                <td class="lclHide"><input type="text" class="form-control" name="amtappli[]" placeholder="Amount" readonly="readonly"/></td>
                                <td><input type="text" class="form-control  expense_dates cddl" name="dot_l[]" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                                <td><select class="form-control" tabindex="2" required="required" name="mot_l[]" id="mot">
                                        <option value="0">Mode of travel</option>
                                        <option value="Own Vehicle">Own Vehicle</option>
                                        <option value="Cab">Cab</option>
                                        <option value="Auto">Auto</option>
                                        <option value="Local Train">Local Train</option>
                                        <option value="Any Public Transport">Any Public Transport</option>
                                    </select></td>
                                <td><input type="text" class="form-control" name="from_l[]" placeholder="From"/></td>
                                <td><input type="text" class="form-control" name="to_l[]" placeholder="To"/></td>
                                <td><input type="text" class="form-control amtt tamfor ttcm" name="amt_l[]" placeholder="Amount" readonly/></td>
                                <td><input type="text" class="form-control" name="dprNum[]" placeholder="DPR Number"/></td>
                            </tr>
                        </tbody>
                    </table>
                   </div> 
                    <div class="col-md-4 pull-right"><input type="text" class="form-control ttcmt" name="fare_total" placeholder="Total Local Conveyance" readonly /></div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 form-group">
            <label>Lodging : </label>&nbsp;&nbsp;<a href="#" data-get="fare1" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare1" class="RemoveField"><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix">
                <div class="column">
                    <table class="table table-bordered" id="fare_tab">
                        <thead><tr class="blue cust"><th>Zone</th><th>State</th><th>District</th><th>Visit: Start Date:</th><th>Visit: End Date:</th><th>Hotel Name</th><th>Amount</th><th>DPR Number</th></tr></thead>
                        <tbody id='fare1'>
                            <tr class="tbform">
                            	<td>
                                    <select class="form-control showgradedesg" tabindex="1" required="required" name="zone" autofocus="autofocus">
                                         <option value="0" selected="selected" disabled="disabled">zone</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control showgradedesg" tabindex="2" required="required" name="zone" autofocus="autofocus">
                                        <option value="0" selected="selected" disabled="disabled">State</option>
                                    </select>
                                </td>
                                <td>
                                     <select class="form-control showgradedesg" tabindex="3" required="required" name="zone" autofocus="autofocus">
                                        <option value="0" selected="selected" disabled="disabled">District</option>
                                     </select>
                                </td>
                                <td><input type="text" class="form-control expense_dates checkin cddl" name="checkin[]" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                                <td><input type="text" class="form-control expense_dates checkout cddl" name="checkout[]" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                                <td class="changw"><input type="text" class="form-control" name="hotelName" placeholder="Hotel Name" value=""/></td>
                                <td><input type="text" class="form-control amtt tamfor tlam selfamm" name="lamt[]" placeholder="Amount" readonly/></td>
                                <td><input type="text" class="form-control" name="dprNum[]" placeholder="Dpr Number" value=""/></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-4 pull-right"><input type="text" class="form-control tlamt" placeholder="Total Lodging" readonly /></div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 form-group">
            <label>Boarding Allowance: </label>&nbsp;&nbsp;<a href="#" data-get="fare" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare" class="RemoveField"><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix">
                <div class="column">
                    <table class="table table-bordered" id="fare_tab">
                        <thead><tr class="blue cust"><th>Zone</th><th>State</th><th>District</th><th>Visit: Start Date:</th><th>Visit: End Date:</th><th>Amount</th><th>DPR Number</th></tr></thead>
                        <tbody id='fare'>
                            <tr class="tbform">
                            	<td>
                                    <select class="form-control showgradedesg" tabindex="1" required="required" name="zone" autofocus="autofocus">
                                         <option value="0" selected="selected" disabled="disabled">zone</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control showgradedesg" tabindex="2" required="required" name="zone" autofocus="autofocus">
                                        <option value="0" selected="selected" disabled="disabled">State</option>
                                    </select>
                                </td>
                                <td>
                                     <select class="form-control showgradedesg" tabindex="3" required="required" name="zone" autofocus="autofocus">
                                        <option value="0" selected="selected" disabled="disabled">District</option>
                                     </select>
                                </td>
                                <td><input type="text" class="form-control expense_dates checkin cddl" name="checkinb[]" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                                <td><input type="text" class="form-control expense_dates checkout cddl" name="checkoutb[]" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                                <td><input type="text" class="form-control amtt tamfor blam selfamm" name="bamt[]" placeholder="Amount" readonly/></td>
                                <td><input type="text" class="form-control" name="dprNum[]" placeholder="DPR Number"/></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-4 pull-right"><input type="text" class="form-control blamt" placeholder="Total Lodging" readonly /></div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 form-group">
            <label>Others : </label>&nbsp;&nbsp;<a href="#" data-get="fare2" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare2" class="RemoveField"><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix">
                <div class="column">
                    <table class="table table-bordered" id="fare_tab">
                        <thead><tr class="blue cust"><th>Description</th><th>Amount</th><th>Date</th><th>Files (No special characters in file name)</th><th>DPR Number</th></tr></thead>
                        <tbody id='fare2'>
                            <tr class="tbform">
                                <td><input type="text" class="form-control" name="others[]" placeholder="Description"/></td>
                                <td><input type="text" class="form-control amtt tamfor tlom" name="oamt[]" placeholder="Amount"/></td>
                                <td><input type="text" class="form-control expense_dates cddl" name="odate[]" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                                <td><input type="hidden" class="form-control" name="ofile[]" value="0"/><input type="file" class="form-control" name="ofile[]"/></td>
                                <td><input type="text" class="form-control" name="dprNum[]" placeholder="DPR Number"/></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-4 pull-right"><input type="text" class="form-control tlomt" placeholder="Other's Total" readonly /></div>
                </div>
            </div>
        </div>
        <div class="col-md-4 form-group">
        <label>Outstanding Balance: </label>
        <input type="text" tabindex="14" class="form-control nsamt" value="" placeholder="Outstanding Balance" readonly />
        </div>
        <div class="col-md-4 form-group">
        <label>Total Expenses: </label>
        <input type="text" tabindex="14" class="form-control texp" name="texp" placeholder="Total Expenses" readonly />
        </div>
        <div class="col-md-4 form-group">
        <label>Final Amount (Total Expenses- Outstanding Balance): </label>
        <input type="text" tabindex="14" class="form-control finchamt" placeholder="Total Expenses- Outstanding Balance" readonly />
        </div>
        <!--<div class="col-md-4 form-group">
            <label>Reason/ Remarks: </label>
            <textarea tabindex="2" class="form-control" name="reasonForAdv" placeholder="Reason/ Remarks"></textarea>
        </div>
        -->
        <div class="col-md-4 form-group">
            <label>Tour Report: <small class="redd">(Mandatory)</small></label>
            <input type="file" class="form-control tplanningreport" name="tplanningreport" id="tplanningreport"/>
        	<small class="redd">(Kinldy upload PDF format and size not exceeding 1MB)</small>
        </div>
        <div class="col-md-4 form-group">&nbsp;</div>
        <div class="form-group col-xs-4 col-xs-offset-2 morpad">
            <div class="col-xs-12">
                <input tabindex="14" type="submit" class="btn btn-primary ss_buttons saveinDraft" name="saveinDraft" value="Draft">
                <input tabindex="13" type="submit" class="btn btn-primary ss_buttons ademp" name="addEmp" value="Submit Expense">
            </div>
        </div>
        </form>
</div>
</div>
<script>
$(document).on("keypress keyup focus",".qnty",function (event) {    
	   $(this).val($(this).val().replace(/[^\d].+/, ""));
		if ((event.which < 48 || event.which > 57)) {
			event.preventDefault();
		}
	});


	$(document).on('keyup','.tamfor',function (event){ 
		var tamt=tcmt=tlamt=blamt=tlomt=ttcm=0;
		$(".tamfor").each(function(){tamt+=Number($(this).val());});
		$(".tcm").each(function(){tcmt+=Number($(this).val());});
		$(".ttcm").each(function(){ttcm+=Number($(this).val());});
		$(".tlam").each(function(){tlamt+=Number($(this).val());});
		$(".blam").each(function(){blamt+=Number($(this).val());});
		$(".tlom").each(function(){tlomt+=Number($(this).val());});
		$(".numKilo").each(function(){numKilo+=Number($(this).val());});
		$('.ttcmt').val(ttcm);
		$('.tcmt').val(tcmt);$('.tlamt').val(tlamt);$('.blamt').val(blamt);$('.tlomt').val(tlomt);$('.texp').val(tamt);$('.finchamt').val(tamt-Number($('.nsamt').val()));
	});
	$(document).on('focus','.tamfor',function (event){ 
		var tamt=tcmt=tlamt=blamt=tlomt=ttcm=0;
		$(".tamfor").each(function(){tamt+=Number($(this).val());});
		$(".tcm").each(function(){tcmt+=Number($(this).val());});
		$(".ttcm").each(function(){ttcm+=Number($(this).val());});
		$(".tlam").each(function(){tlamt+=Number($(this).val());});
		$(".blam").each(function(){blamt+=Number($(this).val());});
		$(".tlom").each(function(){tlomt+=Number($(this).val());});
		$(".numKilo").each(function(){numKilo+=Number($(this).val());});
		$('.ttcmt').val(ttcm);
		$('.tcmt').val(tcmt);$('.tlamt').val(tlamt);$('.blamt').val(blamt);$('.tlomt').val(tlomt);$('.texp').val(tamt);$('.finchamt').val(tamt-Number($('.nsamt').val()));
	});
	$(document).on('change','.lodging_self',function(event){
		event.preventDefault();
		thisVal=$(this).val()
		$parentone=$(this).parents('.tbform');
		if(thisVal=="Self"){
			$parentone.children('.changw').html('<select name="hotelName[]" class="lodvalto htname"><option value="0">Select</option><option value="a1">A+</option><option value="a">A</option><option value="b">B</option><option value="c">C</option></select>');
		}else{
			$parentone.children('.changw').html('<input type="text" class="form-control htname" name="hotelName[]" placeholder="Hotel Name"/>');
			var coutdate1=$parentone.find('input[name="lamt[]"]');
			coutdate1.val("");
			coutdate1.focus();
			coutdate1.removeAttr("readonly");
		}
	});
	$(document).on('change','.lodvalto',function(event){
		event.preventDefault();
		thisVal=$(this).val()
		$parentone=$(this).parents('.tbform');
		var cindate=$parentone.find('.checkin');
		var coutdate=$parentone.find('.checkout');
		if(cindate.val()!="" && coutdate.val()!=""){
			$.ajax({
				url: "item.php",
				type: "POST",
				data: 'locding='+thisVal+'&cindate='+cindate.val()+'&coutdate='+coutdate.val(),
				success: function(result) {
					var coutdate1=$parentone.find('.amtt');
					coutdate1.val(result.trim());
					coutdate1.attr("readonly","readonly");
					coutdate1.focus();
				}
			});
		}
	});
	$(document).on('change','.bodvalto',function(event){
		event.preventDefault();
		thisVal=$(this).val()
		$parentone=$(this).parents('.tbform');
		var cindate=$parentone.find('.checkin');
		var coutdate=$parentone.find('.checkout');
		if(cindate.val()!="" && coutdate.val()!=""){
			$.ajax({
				url: "item.php",
				type: "POST",
				data: 'bodding='+thisVal+'&cindate='+cindate.val()+'&coutdate='+coutdate.val(),
				success: function(result) {
					var coutdate1=$parentone.find('.amtt');
					coutdate1.val(result.trim());
					coutdate1.attr("readonly","readonly");
					coutdate1.focus();
				}
			});
		}
	});
depDate();
function depDate(){
	var nowTemp = new Date();
	var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
	var checkin = $('.dpd1').datepicker({
		format: 'dd-mm-yyyy',
		onRender: function(date){return date.valueOf() > now.valueOf() ? 'disabled' : '';}
	}).on('changeDate', function(ev){
		if (ev.date.valueOf() < checkout.date.valueOf()) {
			var newDate = new Date(ev.date);
			newDate.setDate(newDate.getDate());
			checkout.setValue(newDate);
		}
		var sDate = $('.dpd1').val();
		var eDate = $('.dpd2').val();
		$.ajax({
			type: "GET",
			url: "include/helper.php",
			data: 'd1='+sDate+'&d2='+eDate+'&rf=days',
			cache: true,
			success: function(result){$('#visitFromDate').val(result);}
		});
		checkin.hide();
	}).data('datepicker');
	var checkout = $('.dpd2').datepicker({
			format: 'dd-mm-yyyy',
			onRender: function(date){
				if(date.valueOf() < checkin.date.valueOf() || date.valueOf() > now.valueOf()) return 'disabled';
				else return'';
			}
		}).on('changeDate', function(ev){
			checkout.hide();
			var sDate = $('.dpd1').val();
			var eDate = $('.dpd2').val();
			$.ajax({
				type: "GET",
				url: "include/helper.php",
				data: 'd1='+sDate+'&d2='+eDate+'&rf=days',
				cache: true,
				success: function(result){$('#visitFromDate').val(result);}
			});
	}).data('datepicker');
	var  expense_dates= $('.expense_dates').datepicker({
			format: 'dd-mm-yyyy',
			onRender: function(date){
				if(date.valueOf() > now.valueOf()) return 'disabled';
				else return '';
			}
		}).on('changeDate', function(ev){$(this).datepicker('hide');
	}).data('datepicker');
}
$(document).on('change','.localConvy',function(){
	if($(this).val()==1){$(this).parent().siblings('.lclHide').children().attr('readonly','readonly');}
	else{$(this).parent().siblings('.lclHide').children().not('.wofCell').removeAttr('readonly');}
	});
    function ajaxSelect(id, type) {
        if(id != ""){
                $.ajax({
                    type: "POST",
                    url: "admin/ajaxSelect.php",
                    data: 'type=' + type + '&id=' + id,
                    cache: false,
                    success: function(result) {						
						if(type == "State" || type == "District"){
							$("#ajaxSelect_" + type).html(result);	
						}
						if (type == "Area") {							
							//document.getElementById('ajaxSelect_Area').value = result;
							//$('#ajaxSelect_Area').val(result);
							//$('#ajaxSelect_Area').attr('value', result);							
							if(result == 0){
								var disp = 'Plain area';
								$('#ajaxSelect_Area').val(disp);
							}else if(result == 1){
								var disp = 'Hilly area';
								$('#ajaxSelect_Area').val(disp);
							
							}
						}
                    }
                });
        }
        if (type == "State") {
            $("#ajaxSelect_State").html("<option value='0' disabled >Select State</option>");
            $("#ajaxSelect_District").html("<option value='0' disabled >Select District</option>");
			$('#ajaxSelect_Area').val("");
        }
		if (type == "District") {
			$('#ajaxSelect_Area').val("");
        }
    }
    </script>

