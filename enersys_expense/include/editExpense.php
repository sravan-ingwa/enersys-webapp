<?php
session_start();
function checkSelected($fv1,$fv2){if(strtoupper($fv1)==strtoupper($fv2)) return "selected";}
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['texp'])){
	if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['visitFromDate'])){$message="<p class='alert alert-danger' role='alert'>Select Visit from Date</p>";}
	else if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['visitToDate'])){$message="<p class='alert alert-danger' role='alert'>Select Visit to Date</p>";}
	else if($_REQUEST['placesOfVisit']==""){$message="<p class='alert alert-danger' role='alert'>Enter Places Of Visit</p>";}
	else if($_REQUEST['purpose']==""){$message="<p class='alert alert-danger' role='alert'>Enter Purpose</p>";}
	else if(filter_var($_REQUEST['texp'], FILTER_VALIDATE_INT) == false){$message="<p class='alert alert-danger' role='alert'>Enter Total Amount</p>";}
	else{
		$empalias=$_SESSION['ec_user_alias'];
		$visitFromDate=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['visitFromDate']))));
		$visitToDate=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['visitToDate']))));
		$placesOfVisit=$_REQUEST['placesOfVisit'];
		$purpose=$_REQUEST['purpose'];
		$texp=array_sum($_REQUEST['amt'])+array_sum($_REQUEST['amt_l'])+array_sum($_REQUEST['lamt'])+array_sum($_REQUEST['bamt'])+array_sum($_REQUEST['oamt']);
		$reqdate=date("Y-m-d");
		$alias=mysqli_real_escape_string($mr_con,$_REQUEST['id']);
		$remarkss=mysqli_real_escape_string($mr_con,$_REQUEST['remarks']);
		$level=0;
		//Conveience Starts
		for($i=0;$i<count($_REQUEST['idc']);$i++){
			$f1[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['idc'][$i]);
			$f2[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['dot'][$i])));
			$f3[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['mot'][$i]);
			$f4[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['from'][$i]);
			$f5[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['to'][$i]);
			$f6[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['amt'][$i]);
			if($f6[$i]!=""){
				if($f1[$i] !='0'){
					if($_FILES['motbill']['size'][$i]>0){
						$ext = pathinfo($_FILES['motbill']['name'][$i], PATHINFO_EXTENSION);
						$fileName=$empalias.generateRandomString()."TC.".$ext;
						move_uploaded_file($_FILES["motbill"]["tmp_name"][$i],"attachments/".$fileName);
						$profileimg = "attachments/".$fileName;
						if($_REQUEST['motbill_old'][$i]!=='0') unlink($_REQUEST['motbill_old'][$i]);
					}else{
						if($_REQUEST['motbill_old'][$i]=='0') $profileimg =0;
						else $profileimg=$_REQUEST['motbill_old'][$i];
					}
						mysqli_query($mr_con,"UPDATE ec_conveyance SET 
							date_of_travel='".$f2[$i]."',
							mode_of_travel='".$f3[$i]."',
							from_place='".$f4[$i]."', 
							to_place='".$f5[$i]."', 
							amount='".$f6[$i]."', 
							document_link='".$profileimg."', 
							created_date='".$reqdate."' 
							WHERE alias='".$f1[$i]."'");						
				}else{
					$alias1=aliasCheck(generateRandomString(),"ec_conveyance","alias");
					if($_FILES['motbill']['size'][$i]>0){
						$ext = pathinfo($_FILES['motbill']['name'][$i], PATHINFO_EXTENSION);
						$fileName=$empalias.generateRandomString()."TC.".$ext;
						move_uploaded_file($_FILES["motbill"]["tmp_name"][$i],"attachments/".$fileName);
						$profileimg = "attachments/".$fileName;
					}else $profileimg =0;
					mysqli_query($mr_con,"INSERT INTO ec_conveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,document_link,created_date) VALUES('$alias','$f2[$i]','$f3[$i]','$f4[$i]','$f5[$i]','$f6[$i]','$alias1','$profileimg','$reqdate')");
				}
			}
		}
		//Conveience Ends
		//Local Conveience Starts
		for($i=0;$i<count($_REQUEST['idc_l']);$i++){
			$f1[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['idc_l'][$i]);
			$f2[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['dot_l'][$i])));
			$f3[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['mot_l'][$i]);
			$f4[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['from_l'][$i]);
			$f5[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['to_l'][$i]);
			$f6[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['amt_l'][$i]);
			if($f6[$i]!=""){
				if($f1[$i] !='0'){
					mysqli_query($mr_con,"UPDATE ec_localconveyance SET date_of_travel='".$f2[$i]."', mode_of_travel='".$f3[$i]."', from_place='".$f4[$i]."', to_place='".$f5[$i]."', amount='".$f6[$i]."', created_date='$reqdate' WHERE alias='".$f1[$i]."'");
				}else{
					$alias1=aliasCheck(generateRandomString(),"ec_localconveyance","alias");
					mysqli_query($mr_con,"INSERT INTO ec_localconveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,created_date) VALUES('$alias','".$f2[$i]."','".$f3[$i]."','".$f4[$i]."','".$f5[$i]."','".$f6[$i]."','$alias1','$reqdate')");
				}
			}
		}
		//Local Conveience Ends
		//Lodging Starts
		for($i=0;$i<count($_REQUEST['idl']);$i++){
			$f1[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['idl'][$i]);
			$f2[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['checkin'][$i])));
			$f3[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['checkout'][$i])));
			$f4[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['typeofstay'][$i]);
			$f5[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['hotelName'][$i]);
			$f6[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['lamt'][$i]);
			if($f6[$i]!=""){
				if($f1[$i] !='0'){
					if($_FILES['lfile']['size'][$i]>0){
						$ext = pathinfo($_FILES['lfile']['name'][$i], PATHINFO_EXTENSION);
						$fileName=$empalias.generateRandomString()."TL.".$ext;
						move_uploaded_file($_FILES["lfile"]["tmp_name"][$i],"attachments/".$fileName);
						$profileimg = "attachments/".$fileName;
						if($_REQUEST['lfile_old'][$i]!=='0') unlink($_REQUEST['lfile_old'][$i]);
					}else{
						if($_REQUEST['lfile_old'][$i]=='0') $profileimg =0;
						else $profileimg=$_REQUEST['lfile_old'][$i];
					}
					mysqli_query($mr_con,"UPDATE ec_lodging SET check_in='".$f2[$i]."',
						check_out='".$f3[$i]."',
						type_of_stay='".$f4[$i]."', 
						hotel_name='".$f5[$i]."', 
						amount='".$f6[$i]."', 
						document_link='$profileimg', 
						created_date='$reqdate' 
						WHERE alias='".$f1[$i]."'");
				}else{
					$alias1=aliasCheck(generateRandomString(),"ec_lodging","alias");
					if($_FILES['lfile']['size'][$i]>0){
						$ext = pathinfo($_FILES['lfile']['name'][$i], PATHINFO_EXTENSION);
						$fileName=$empalias.generateRandomString()."TL.".$ext;
						move_uploaded_file($_FILES["lfile"]["tmp_name"][$i],"attachments/".$fileName);
						$profileimg = "attachments/".$fileName;
					}else $profileimg =0;
					mysqli_query($mr_con,"INSERT INTO ec_lodging(check_in,check_out,type_of_stay,hotel_name,amount,expenses_alias,alias,document_link,created_date) VALUES('".$f2[$i]."','".$f3[$i]."','".$f4[$i]."','".$f5[$i]."','".$f6[$i]."','$alias','$alias1','$profileimg','$reqdate')");
				}
			}
		}
		//Lodging Ends
		//Boarding Starts
		for($i=0;$i<count($_REQUEST['idb']);$i++){
			$f1[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['idb'][$i]);
			$f2[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['checkinb'][$i])));
			$f3[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['checkoutb'][$i])));
			$f4[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state'][$i]);
			$f5[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['bamt'][$i]);
			if($f5[$i]!=""){
				if($f1[$i] !='0'){
					mysqli_query($mr_con,"UPDATE ec_boarding SET check_in='".$f2[$i]."',
						check_out='".$f3[$i]."',
						state='".$f4[$i]."', 
						amount='".$f5[$i]."',
						created_date='$reqdate' 
						WHERE alias='".$f1[$i]."'");
				}else{
					$alias1=aliasCheck(generateRandomString(),"ec_boarding","alias");
					mysqli_query($mr_con,"INSERT INTO ec_boarding(check_in,check_out,state,amount,expenses_alias,alias,created_date) VALUES('".$f2[$i]."','".$f3[$i]."','".$f4[$i]."','".$f5[$i]."','$alias','$alias1','$reqdate')");
				}
			}
		}
		//Boarding Ends
		//Others Starts
		for($i=0;$i<count($_REQUEST['ido']);$i++){
			$f1[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['ido'][$i]);
			$f2[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['odate'][$i])));
			$f3[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['others'][$i]);
			$f6[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['oamt'][$i]);
			if($f6[$i]!=""){
				if($f1[$i] != '0'){
					if($_FILES['ofile']['size'][$i]>0){
						$ext = pathinfo($_FILES['ofile']['name'][$i], PATHINFO_EXTENSION);
						$fileName=$empalias.generateRandomString()."TO.".$ext;
						move_uploaded_file($_FILES["ofile"]["tmp_name"][$i],"attachments/".$fileName);
						$profileimg = "attachments/".$fileName;
						if($_REQUEST['ofile_old'][$i]!=='0') unlink($_REQUEST['ofile_old'][$i]);
					}else{
						if($_REQUEST['ofile_old'][$i]=='0') $profileimg =0;
						else $profileimg=$_REQUEST['ofile_old'][$i];
					}
					mysqli_query($mr_con,"UPDATE ec_other_expenses SET checked_date='".$f2[$i]."',
							description='".$f3[$i]."',
							amount='".$f6[$i]."', 
							document_link='$profileimg', 
							created_date='$reqdate' 
							WHERE alias='".$f1[$i]."'");
				}else{
					$alias1=aliasCheck(generateRandomString(),"ec_other_expenses","alias");
					if($_FILES['ofile']['size'][$i]>0){
						$ext = pathinfo($_FILES['ofile']['name'][$i], PATHINFO_EXTENSION);
						$fileName=$empalias.generateRandomString()."TO.".$ext;
						move_uploaded_file($_FILES["ofile"]["tmp_name"][$i],"attachments/".$fileName);
						$profileimg = "attachments/".$fileName;
					}else $profileimg =0;
					mysqli_query($mr_con,"INSERT INTO ec_other_expenses(checked_date, description, amount, expenses_alias, alias, document_link, created_date) VALUES('".$f2[$i]."','".$f3[$i]."','".$f6[$i]."','$alias','$alias1','$profileimg','$reqdate')");
				}
			}
		}
		//Others Ends

		if($_FILES['tplanningreport']['size']>0){
			$ext = pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION);
			$fileName=$empalias.generateRandomString()."EXP.".$ext;
			move_uploaded_file($_FILES["tplanningreport"]["tmp_name"],"attachments/tourReport/".$fileName);
			$profileimg = "attachments/tourReport/".$fileName;
			if($_REQUEST['tplanningreport_old']!=='0' && $_REQUEST['tplanningreport_old']!=='') unlink($_REQUEST['tplanningreport_old']);
		}else{
			if($_REQUEST['tplanningreport_old']=='0')$profileimg=0;
			else $profileimg=$_REQUEST['tplanningreport_old'];
		}

		$sql="UPDATE ec_expenses SET period_of_visit_from='$visitFromDate', period_of_visit_to='$visitToDate', places_of_visit='$placesOfVisit', purpose='$purpose', total_tour_expenses='$texp', requested_date='$reqdate', approval_level='$level',report='$profileimg' WHERE expenses_alias='$alias'";
		$mr_con->query("UPDATE ec_remarks SET remarks='$remarkss',remarked_on='".date("Y-m-d H:i:s")."' WHERE item_alias='$alias'");
		if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Expense Submitted successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Expense Request Failed</p>";
	}
}

if($_REQUEST['id']) $_SESSION['id']=$_REQUEST['id']; 
$expList=expensefullView($_SESSION['id']);
$conveyance=ec_conveyance($expList[0]['expenses_alias']);
$lconveyance=ec_localconveyance($expList[0]['expenses_alias']);
$lodging=ec_lodging($expList[0]['expenses_alias']);
$boarding=ec_boarding($expList[0]['expenses_alias']);
$other_expenses=ec_other_expenses($expList[0]['expenses_alias']);
$remarks=getRemarks($expList[0]['expenses_alias'],'BE');
if($expList[0]['approval_level']==0 ||$expList[0]['approval_level']==8){include('updateexpense-0.php');}
else if($expList[0]['approval_level']>=1 && $expList[0]['approval_level']<=6){include('updateexpense-1.php');?>	
	<?php if($expList[0]['approval_level']=='3'){?>
    <div class="col-md-4 form-group">
        <label>PO/ GNR Number<sup>*</sup> : </label>
        <input tabindex="1" class="form-control amtt" name="po_gnr" placeholder="PO/ GNR Number" type="text" required="required" />
    </div>
    <?php }?>
	<?php if($expList[0]['approval_level']=='6'){?>
    <div class="col-md-4 form-group">
        <label>UTR Number<sup>*</sup> : </label>
        <input tabindex="1" class="form-control amtt" name="utr_num" placeholder="UTR Number" type="text" required="required" />
    </div>
    <?php }?>
    <div class="col-md-4 form-group">
        <label>Reason/ Remarks<sup>*</sup> : </label>
        <textarea tabindex="2" class="form-control reasonForAdv" name="reasonForAdv" placeholder="Reason/ Remarks" required="required"></textarea>
    </div>
    <div class="col-md-4 form-group">&nbsp;</div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-md-4 col-md-offset-4">
            <input tabindex="13" type="submit" class="btn btn-primary ss_buttons updatex" name="approve" value="Approve">
            <input tabindex="14" type="submit" class="btn btn-primary ss_buttons rejectx" name="reject" value="Reject">
        </div>
    </div>
    </form>
<?php }else echo "<script type='text/javascript'>window.location='index.php'</script>";?>
    </div>
    </div>
<script>
	$(document).on('keyup','.tamfor',function (event){ 
		var tamt=tcmt=tlamt=blamt=tlomt=ttcm=0;
		$(".tamfor").each(function(){tamt+=Number($(this).val());});
		$(".tcm").each(function(){tcmt+=Number($(this).val());});
		$(".ttcm").each(function(){ttcm+=Number($(this).val());});
		$(".tlam").each(function(){tlamt+=Number($(this).val());});
		$(".blam").each(function(){blamt+=Number($(this).val());});
		$(".tlom").each(function(){tlomt+=Number($(this).val());});
		$('.ttcmt').val(ttcm);
		$('.tcmt').val(tcmt);$('.tlamt').val(tlamt);$('.blamt').val(blamt);$('.tlomt').val(tlomt);
		$('.texp').val(tamt);
		$('.finchamt').val(tamt-Number($('.nsamt').val()));
	});
	$(document).on('focus','.tamfor',function (event){ 
		var tamt=tcmt=tlamt=blamt=tlomt=ttcm=0;
		$(".tamfor").each(function(){tamt+=Number($(this).val());});
		$(".tcm").each(function(){tcmt+=Number($(this).val());});
		$(".ttcm").each(function(){ttcm+=Number($(this).val());});
		$(".tlam").each(function(){tlamt+=Number($(this).val());});
		$(".blam").each(function(){blamt+=Number($(this).val());});
		$(".tlom").each(function(){tlomt+=Number($(this).val());});
		$('.ttcmt').val(ttcm);
		$('.tcmt').val(tcmt);$('.tlamt').val(tlamt);$('.blamt').val(blamt);$('.tlomt').val(tlomt);
		$('.texp').val(tamt);
		$('.finchamt').val(tamt-Number($('.nsamt').val()));
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

	$(document).on('keyup','.qntyy',function (event){ 
	var tm=Number($('.temp_tlt').val())-Number($(this).val());
		//$('.texp').val(tm);
		$('.finchamt').val(tm-Number($('.nsamt').val()));
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
		if (ev.date.valueOf() > checkout.date.valueOf()) {
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
		 $('.dpd2')[0].focus();
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
</script>

