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
		$placesOfVisit=mysqli_real_escape_string($mr_con,$_REQUEST['placesOfVisit']);
		$purpose=mysqli_real_escape_string($mr_con,$_REQUEST['purpose']);
		$texp=round(array_sum($_REQUEST['amt'])+array_sum($_REQUEST['amt_l'])+array_sum($_REQUEST['lamt'])+array_sum($_REQUEST['bamt'])+array_sum($_REQUEST['oamt']));
		$reqdate=date("Y-m-d");
		$alias=$_REQUEST['id'];
		$remarkss=mysqli_real_escape_string($mr_con,$_REQUEST['remarks']);
		$rem_amt=mysqli_real_escape_string($mr_con,$_REQUEST['rem_amt']);
		$level=0;
		$ins=0;
		//Conveience Starts
			for($i=0;$i<count($_REQUEST['idc']);$i++){
				$f1[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['idc'][$i]);
				$f2[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['dot'][$i])));
				$f3[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['mot'][$i]);
				$f4[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['from'][$i]);
				$f5[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['to'][$i]);
				$f6[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['amt'][$i]);
				$f7[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['cdprno'][$i]);
				$f8[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['cticket_id'][$i]);
				if($f6[$i]!=""){
					if($f1[$i] !='0'){
						if($_FILES['motbill']['size'][$i]>0){
							$ext = pathinfo($_FILES['motbill']['name'][$i], PATHINFO_EXTENSION);
							$fileName=$empalias.generateRandomString()."TC.".$ext;
							$move = move_uploaded_file($_FILES["motbill"]["tmp_name"][$i],"attachments/".$fileName);
							if($move){
								$profileimg = "attachments/".$fileName;
								if($_REQUEST['motbill_old'][$i]!=='0') unlink($_REQUEST['motbill_old'][$i]);
							}else{$profileimg = "";}
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
								dpr_number='".$f7[$i]."',
								ticket_alias='".$f8[$i]."',
								created_date='".$reqdate."' 
								WHERE alias='".$f1[$i]."'");	
								$ins=1;					
					}else{
						$alias1=aliasCheck(generateRandomString(),"ec_conveyance","alias");
						if($_FILES['motbill']['size'][$i]>0){
							$ext = pathinfo($_FILES['motbill']['name'][$i], PATHINFO_EXTENSION);
							$fileName=$empalias.generateRandomString()."TC.".$ext;
							move_uploaded_file($_FILES["motbill"]["tmp_name"][$i],"attachments/".$fileName);
							$profileimg = "attachments/".$fileName;
						}else $profileimg =0;
						mysqli_query($mr_con,"INSERT INTO ec_conveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,document_link,created_date,dpr_number,ticket_alias) VALUES('$alias','$f2[$i]','$f3[$i]','$f4[$i]','$f5[$i]','$f6[$i]','$alias1','$profileimg','$reqdate','$f7[$i]','$f8[$i]')");
						$ins=1;
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
				$f7[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['zone_l'][$i]);
				$f8[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state_l'][$i]);
				$f9[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['district_l'][$i]);
				$f10[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['area_l'][$i]);
				$f11[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['bucket'][$i]);
				if($f11[$i] == 0){
					$f12[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['cap'][$i]);
					$f13[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['wofCell'][$i]);
					$f14[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['quantityCell'][$i]);
					$f15[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['numKilometers'][$i]);
				} else {
					$f12[$i]='';
					$f13[$i]='';
					$f14[$i]='';
					$f15[$i]='';
				}
				$f16[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['dprNum_l'][$i]);
				$f17[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['ticket_idl'][$i]);
				if($f11[$i] == 0){
					//if((count(array_filter($_REQUEST['cap'])) == count($_REQUEST['cap'])) && (count(array_filter($_REQUEST['quantityCell'])) == count($_REQUEST['quantityCell'])) && (count(array_filter($_REQUEST['numKilometers'])) == count($_REQUEST['numKilometers']))){
						if($f6[$i]!=""){
							if($f1[$i] !='0'){
								 mysqli_query($mr_con,"UPDATE ec_localconveyance SET date_of_travel='".$f2[$i]."', mode_of_travel='".$f3[$i]."', from_place='".$f4[$i]."', to_place='".$f5[$i]."', amount='".$f6[$i]."', created_date='$reqdate', zone_alias='".$f7[$i]."', state_alias='".$f8[$i]."', district_alias='".$f9[$i]."', bucket='".$f11[$i]."', capacity='".$f12[$i]."', quantity='".$f14[$i]."', km='".$f15[$i]."',dpr_number='".$f16[$i]."',ticket_alias='".$f17[$i]."'
								 WHERE alias='".$f1[$i]."'");
								 $ins=1;
							}else{
								if($f6[$i]!="" && $f6[$i]!="0"){
									$alias1=aliasCheck(generateRandomString(),"ec_localconveyance","alias");
									mysqli_query($mr_con,"INSERT INTO ec_localconveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,created_date,zone_alias,state_alias,district_alias,bucket,capacity,quantity,km,dpr_number,ticket_alias
									) VALUES('$alias','".$f2[$i]."','".$f3[$i]."','".$f4[$i]."','".$f5[$i]."','".$f6[$i]."','$alias1','$reqdate','".$f7[$i]."','".$f8[$i]."','".$f9[$i]."','".$f11[$i]."','".$f12[$i]."','".$f14[$i]."','".$f15[$i]."','".$f16[$i]."','".$f17[$i]."')");
									$ins=1;
								}
							}
						}
					//}
				}else{
					if($f6[$i]!=""){
						if($f1[$i] !='0'){
							 mysqli_query($mr_con,"UPDATE ec_localconveyance SET date_of_travel='".$f2[$i]."', mode_of_travel='".$f3[$i]."', from_place='".$f4[$i]."', to_place='".$f5[$i]."', amount='".$f6[$i]."', created_date='$reqdate', zone_alias='".$f7[$i]."', state_alias='".$f8[$i]."', district_alias='".$f9[$i]."', bucket='".$f11[$i]."', capacity='".$f12[$i]."', quantity='".$f14[$i]."', km='".$f15[$i]."',dpr_number='".$f16[$i]."',ticket_alias='".$f17[$i]."'
							 WHERE alias='".$f1[$i]."'");
							 $ins=1;
						}else{
							if($f6[$i]!="" && $f6[$i]!="0"){
								$alias1=aliasCheck(generateRandomString(),"ec_localconveyance","alias");
								mysqli_query($mr_con,"INSERT INTO ec_localconveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,created_date,zone_alias,state_alias,district_alias,bucket,capacity,quantity,km,dpr_number,ticket_alias
								) VALUES('$alias','".$f2[$i]."','".$f3[$i]."','".$f4[$i]."','".$f5[$i]."','".$f6[$i]."','$alias1','$reqdate','".$f7[$i]."','".$f8[$i]."','".$f9[$i]."','".$f11[$i]."','".$f12[$i]."','".$f14[$i]."','".$f15[$i]."','".$f16[$i]."','".$f17[$i]."')");
								$ins=1;
							}
						}
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
			$f7[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['zone_ld'][$i]);
			$f8[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state_ld'][$i]);
			$f9[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['district_ld'][$i]);
			$f10[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['dprNum_ld'][$i]);
			$f11[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['ticket_idld'][$i]);
			$profileimg =0;
			if($f6[$i]!=""){
				if($f1[$i] !='0'){
					mysqli_query($mr_con,"UPDATE ec_lodging SET check_in='".$f2[$i]."',
						check_out='".$f3[$i]."',
						type_of_stay='".$f4[$i]."', 
						hotel_name='".$f5[$i]."', 
						amount='".$f6[$i]."', 
						document_link='$profileimg', 
						created_date='$reqdate', 
						zone_alias='".$f7[$i]."', 
						state_alias='".$f8[$i]."', 
						district_alias='".$f9[$i]."', 
						dpr_number='".$f10[$i]."',
						ticket_alias='".$f11[$i]."'
						WHERE alias='".$f1[$i]."'");
						$ins=1;
				}else{
					if($f6[$i]!="" && $f6[$i]!="0"){
						$alias1=aliasCheck(generateRandomString(),"ec_lodging","alias");
						mysqli_query($mr_con,"INSERT INTO ec_lodging(check_in,check_out,type_of_stay,hotel_name,amount,expenses_alias,alias,document_link,created_date,zone_alias,state_alias,district_alias,dpr_number,ticket_alias) VALUES('".$f2[$i]."','".$f3[$i]."','".$f4[$i]."','".$f5[$i]."','".$f6[$i]."','$alias','$alias1','$profileimg','$reqdate','".$f7[$i]."','".$f8[$i]."','".$f9[$i]."','".$f10[$i]."','".$f11[$i]."')");
						$ins=1;
					}
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
				$f6[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['zone_bo'][$i]);
				$f7[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state_bo'][$i]);
				$f8[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['district_bo'][$i]);
				$f9[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['dprNum_bo'][$i]);
				$f10[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['ticket_bo'][$i]);
				if($f5[$i]!=""){
					if($f1[$i] !='0'){
						mysqli_query($mr_con,"UPDATE ec_boarding SET check_in='".$f2[$i]."',
							check_out='".$f3[$i]."',
							state='".$f4[$i]."', 
							amount='".$f5[$i]."',
							created_date='$reqdate', zone_alias='".$f6[$i]."', state_alias='".$f7[$i]."', district_alias='".$f8[$i]."', dpr_number='".$f9[$i]."',ticket_alias='".$f10[$i]."' 
							WHERE alias='".$f1[$i]."'");
							$ins=1;
					}else{
						if($f5[$i]!="" && $f5[$i]!="0"){
							$alias1=aliasCheck(generateRandomString(),"ec_boarding","alias");
							mysqli_query($mr_con,"INSERT INTO ec_boarding(check_in,check_out,state,amount,expenses_alias,alias,created_date,zone_alias,state_alias,district_alias,dpr_number,ticket_alias) VALUES('".$f2[$i]."','".$f3[$i]."','".$f4[$i]."','".$f5[$i]."','$alias','$alias1','$reqdate','".$f6[$i]."','".$f7[$i]."','".$f8[$i]."','".$f9[$i]."','".$f10[$i]."')");
							$ins=1;
						}
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
				$f7[$i]=mysql_escape_string($_REQUEST['dprNum_ot'][$i]);
				$f8[$i]=mysql_escape_string($_REQUEST['ticket_ot'][$i]);
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
								created_date='$reqdate', dpr_number='".$f7[$i]."',ticket_alias='".$f8[$i]."' 
								WHERE alias='".$f1[$i]."'");
								$ins=1;
					}else{
						$alias1=aliasCheck(generateRandomString(),"ec_other_expenses","alias");
						if($_FILES['ofile']['size'][$i]>0){
							$ext = pathinfo($_FILES['ofile']['name'][$i], PATHINFO_EXTENSION);
							$fileName=$empalias.generateRandomString()."TO.".$ext;
							move_uploaded_file($_FILES["ofile"]["tmp_name"][$i],"attachments/".$fileName);
							$profileimg = "attachments/".$fileName;
						}else $profileimg =0;
						if($f6[$i]!="" && $f6[$i]!="0"){
							mysqli_query($mr_con,"INSERT INTO ec_other_expenses(checked_date, description, amount, expenses_alias, alias, document_link, created_date,dpr_number,ticket_alias) VALUES('".$f2[$i]."','".$f3[$i]."','".$f6[$i]."','$alias','$alias1','$profileimg','$reqdate','".$f7[$i]."','".$f8[$i]."')");
							$ins=1;
						}
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
		
		if($ins==0){
				$message="<p class='alert alert-danger' role='alert'>Expense Request Failed.Fill all mandatory fields.</p>";		
		}else{
			$sql="UPDATE ec_expenses SET period_of_visit_from='$visitFromDate', period_of_visit_to='$visitToDate', places_of_visit='$placesOfVisit', purpose='$purpose', total_tour_expenses='$texp', requested_date='$reqdate', approval_level='$level',report='$profileimg',reimbursement_amount='$rem_amt' WHERE expenses_alias='$alias'";
		$mr_con->query("UPDATE ec_remarks SET remarks='$remarkss',remarked_on='".date("Y-m-d H:i:s")."' WHERE item_alias='$alias'");
		if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Expense Submitted successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Expense Request Failed</p>";
		}
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
if($expList[0]['approval_level']==0 ||$expList[0]['approval_level']==8){include('updateSerExpense-0.php');}
else if($expList[0]['approval_level']>=1 && $expList[0]['approval_level']<=6){include('updateSerExpense-1.php');?>	
	
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
$(document).on("keypress keyup focus",".qnty, .qntyy",function (event) {    
	   $(this).val($(this).val().replace(/[^\d].+/, ""));
		if ((event.which < 48 || event.which > 57)) {
			event.preventDefault();
		}
	});
	
$(document).on("keypress keyup focus",".numKilo",function (event) {    
		$(this).val($(this).val().replace(/[^0-9\.]/g,''));
			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
				event.preventDefault();
			}
});
	$(document).on('keyup','.tamfor',function (event){ tamfor2(); });
	function tamfor2(){
		var tamt=tcmt=tlamt=blamt=tlomt=ttcm=0;
		$(".tamfor").each(function(){tamt+=Number($(this).val());});
		$(".tcm").each(function(){tcmt+=Number($(this).val());});
		$(".ttcm").each(function(){ttcm+=Number($(this).val());});
		$(".tlam").each(function(){tlamt+=Number($(this).val());});
		$(".blam").each(function(){blamt+=Number($(this).val());});
		$(".tlom").each(function(){tlomt+=Number($(this).val());});
		//start--for float checking
		var n1=ttcm;
		if(isFloat(n1)==true){var v1=n1.toFixed(2);}else{var v1=n1;}
		$('.ttcmt').val(v1);
		
		var n2=tcmt;
		if(isFloat(n2)==true){var v2=n2.toFixed(2);}else{var v2=n2;}
		$('.tcmt').val(v2);
		
		var n3=tlamt;
		if(isFloat(n3)==true){var v3=n3.toFixed(2);}else{var v3=n3;}
		$('.tlamt').val(v3);
		
		var n4=blamt;
		if(isFloat(n4)==true){var v4=n4.toFixed(2);}else{var v4=n4;}
		$('.blamt').val(v4);
		
		var n5=tlomt;
		if(isFloat(n5)==true){var v5=n5.toFixed(2);}else{var v5=n5;}
		$('.tlomt').val(v5);
		//end--for float checking

/*		$('.ttcmt').val(ttcm);
		$('.tcmt').val(tcmt);
		$('.tlamt').val(tlamt);
		$('.blamt').val(blamt);
		$('.tlomt').val(tlomt);*/
		//$('.texp').val(Math.round(tamt));$('.finchamt').val(Math.round(tamt)-Number($('.nsamt').val()));
		var n6=Number($('.nsamt').val());
		if(isNaN(n6)==true){var v6=0;}else{var v6=Number($('.nsamt').val());}
		$('.texp').val(Math.round(tamt));$('.finchamt').val(Math.round(tamt)-v6);
	}
	$(document).on('focus','.tamfor',function (event){ tamfor();});
	function tamfor(){
		var tamt=tcmt=tlamt=blamt=tlomt=ttcm=0;
		var remb=$(".qntyy").val();
		$(".tamfor").each(function(){tamt+=Number($(this).val());});
		tamt=Number(tamt)-Number((remb!="" ? remb:0));
		$(".tcm").each(function(){tcmt+=Number($(this).val());});
		$(".ttcm").each(function(){ttcm+=Number($(this).val());});
		$(".tlam").each(function(){tlamt+=Number($(this).val());});
		$(".blam").each(function(){blamt+=Number($(this).val());});
		$(".tlom").each(function(){tlomt+=Number($(this).val());});
		//$('.ttcmt').val(ttcm);
		
		//start--for float checking
		var n1=ttcm;
		if(isFloat(n1)==true){var v1=n1.toFixed(2);}else{var v1=n1;}
		$('.ttcmt').val(v1);
		
		var n2=tcmt;
		if(isFloat(n2)==true){var v2=n2.toFixed(2);}else{var v2=n2;}
		$('.tcmt').val(v2);
		
		var n3=tlamt;
		if(isFloat(n3)==true){var v3=n3.toFixed(2);}else{var v3=n3;}
		$('.tlamt').val(v3);
		
		var n4=blamt;
		if(isFloat(n4)==true){var v4=n4.toFixed(2);}else{var v4=n4;}
		$('.blamt').val(v4);
		
		var n5=tlomt;
		if(isFloat(n5)==true){var v5=n5.toFixed(2);}else{var v5=n5;}
		$('.tlomt').val(v5);
		
		//end--for float checking

		//$('.tcmt').val(tcmt);$('.tlamt').val(tlamt);$('.blamt').val(blamt);$('.tlomt').val(tlomt);
		//$('.texp').val(Math.round(tamt));$('.finchamt').val(Math.round(tamt)-Number($('.nsamt').val()));
		var n6=Number($('.nsamt').val());
		if(isNaN(n6)==true){var v6=0;}else{var v6=Number($('.nsamt').val());}
		$('.texp').val(Math.round(tamt));$('.finchamt').val(Math.round(tamt)-v6);
	}

	$(document).on('keyup','.qntyy',function (event){ 
	var tm=Number($('.temp_tlt').val())-Number($(this).val());
		//$('.texp').val(tm);
		$('.finchamt').val(tm-Number($('.nsamt').val()));
	 });

function isFloat(n){ //alert(n);
    return n === Number(n) && n % 1 !== 0;
}
	
depDate();
function depDate(){
	var nowTemp = new Date();
	var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
	
	//No of days - visit start date
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
		//$('.dprDetails').removeClass('hidden');
		$.ajax({
			type: "GET",
			url: "include/helper.php",
			data: 'd1='+sDate+'&d2='+eDate+'&rf=days',
			cache: true,
			success: function(result){$('#visitFromDate').val(result);}
		});
		dpr(sDate,eDate);
		checkin.hide();
		 $('.dpd2')[index].focus();
	}).data('datepicker');
	
	//No of days - visit end date
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
		dpr(sDate,eDate);
	}).data('datepicker');
	
	//all date pickers
	var  expense_dates= $('.expense_dates').datepicker({
			format: 'dd-mm-yyyy',
			onRender: function(date){
				if(date.valueOf() > now.valueOf()) return 'disabled';
				else return '';
			}
		}).on('changeDate', function(ev){$(this).datepicker('hide');
	}).data('datepicker');

	// boarding -- visit start date,end date
	$('.stDate').each(function(index, element) {
		var stmonth = new Array();
		stmonth[0] = "01";
		stmonth[1] = "02";
		stmonth[2] = "03";
		stmonth[3] = "04";
		stmonth[4] = "05";
		stmonth[5] = "06";
		stmonth[6] = "07";
		stmonth[7] = "08";
		stmonth[8] = "09";
		stmonth[9] = "10";
		stmonth[10] = "11";
		stmonth[11] = "12";
		
		 var bcheckin = $(this).find('.bdpd1').datepicker({
			format: 'dd-mm-yyyy',
			onRender: function(date){return date.valueOf() > now.valueOf() ? 'disabled' : '';}
		}).on('changeDate', function(ev){
			if (ev.date.valueOf() < bcheckout.date.valueOf()) {	
				var old_checkout = $(this).parent().siblings().find('.bdpd2').val();
				var st = bcheckout.date; 
				var now2 = bcheckout.date.getDate()+"-"+stmonth[bcheckout.date.getMonth()]+"-"+bcheckout.date.getFullYear(); 
				var newDate = new Date(ev.date);
				newDate.setDate(newDate.getDate());
				bcheckout.setValue(newDate);
				var todaysDate = new Date();
				//if(st.setHours(0,0,0,0) != todaysDate.setHours(0,0,0,0)){bcheckout.setValue(now2); }
				bcheckout.setValue(newDate); 
				if(old_checkout==''){bcheckout.setValue(newDate); }
				else{ if(st.setHours(0,0,0,0) > todaysDate.setHours(0,0,0,0)){bcheckout.setValue(newDate);}else{bcheckout.setValue(now2);}}
				
			}
			if(ev.date.valueOf() >= bcheckout.date.valueOf()) {//alert("3");
				var st = bcheckout.date;
				var now2 = bcheckout.date.getDate()+"-"+stmonth[bcheckout.date.getMonth()]+"-"+bcheckout.date.getFullYear(); 
				var newDate = new Date(ev.date);
				newDate.setDate(newDate.getDate());
				bcheckout.setValue(newDate);
			}
			
			ajaxAmount($(this).parents('.ajm'));
			bcheckin.hide();
			//alert($(this).parent().siblings().attr('class'));
			$(this).parent().siblings().find('.bdpd2').focus();
		}).data('datepicker');
		 
		var bcheckout = $(this).find('.bdpd2').datepicker({
				format: 'dd-mm-yyyy',
				onRender: function(date){
					if(date.valueOf() < bcheckin.date.valueOf() || date.valueOf() > now.valueOf()) return 'disabled';
					else return'';
					//return date.valueOf() > now.valueOf() ? 'disabled' : '';
				}
			}).on('changeDate', function(ev){
				ajaxAmount($(this).parents('.ajm'));
				bcheckout.hide();
		}).data('datepicker');
	});

	// loadging -- visit start date,end date
	$('.stDate1').each(function(index, element) { 
		var stmonth = new Array();
		stmonth[0] = "01";
		stmonth[1] = "02";
		stmonth[2] = "03";
		stmonth[3] = "04";
		stmonth[4] = "05";
		stmonth[5] = "06";
		stmonth[6] = "07";
		stmonth[7] = "08";
		stmonth[8] = "09";
		stmonth[9] = "10";
		stmonth[10] = "11";
		stmonth[11] = "12";
		
		 var bcheckin = $(this).find('.bdpd3').datepicker({
			format: 'dd-mm-yyyy',
			onRender: function(date){return date.valueOf() > now.valueOf() ? 'disabled' : '';}
		}).on('changeDate', function(ev){
			if(ev.date.valueOf() < bcheckout.date.valueOf()) {
				var old_checkout = $(this).parent().siblings().find('.bdpd4').val();
				var st = bcheckout.date;
			var now2 = bcheckout.date.getDate()+"-"+stmonth[bcheckout.date.getMonth()]+"-"+bcheckout.date.getFullYear();
				var newDate = new Date(ev.date);
				newDate.setDate(newDate.getDate()+1);
				var todaysDate = new Date();//alert(st.setHours(0,0,0,0)+"-"+todaysDate.setHours(0,0,0,0));
				//alert(bcheckout.date.valueOf()+"-"+todaysDate.setHours(0,0,0,0)+"-"+st.setHours(0,0,0,0));
				bcheckout.setValue(newDate); 
				if(old_checkout==''){bcheckout.setValue(newDate); }
				else{ if(st.setHours(0,0,0,0) > todaysDate.setHours(0,0,0,0)){bcheckout.setValue(newDate);}else{bcheckout.setValue(now2);}}
			}
			if(ev.date.valueOf() == now.valueOf()){		//alert("2");		
				var newDate = new Date(ev.date);
				newDate.setDate(newDate.getDate()+1);
				bcheckout.setValue(newDate);
			}
			if(ev.date.valueOf() >= bcheckout.date.valueOf()) {//alert("3");
				var st = bcheckout.date;
				var now2 = bcheckout.date.getDate()+"-"+stmonth[bcheckout.date.getMonth()]+"-"+bcheckout.date.getFullYear(); 
				var newDate = new Date(ev.date);
				newDate.setDate(newDate.getDate()+1);
				bcheckout.setValue(newDate);
			}
		
			ajaxAmount($(this).parents('.ajm'));
			bcheckin.hide();
			$(this).parent().siblings().find('.bdpd4').focus();
		}).data('datepicker');
		 
		var bcheckout = $(this).find('.bdpd4').datepicker({
				format: 'dd-mm-yyyy',
				onRender: function(date){
				if(date.valueOf() <= bcheckin.date.valueOf() || date.valueOf() > now.valueOf()) return 'disabled';
					else return'';
				}
			}).on('changeDate', function(ev){
				ajaxAmount($(this).parents('.ajm'));
				bcheckout.hide();
		}).data('datepicker');
	});

}

function dpr(d1,d2){
	var v1=d1;
	var v2=d2;
		$.ajax({
			type: "GET",
			url: "include/dpr_details.php",
			data: 'd1='+v1+'&d2='+v2,
			cache: true,
			success: function(result){
				$('.dprDetails').removeClass('hidden');
				$('#dpr_res').html(result);
			}
		});
}

$(document).on('change','.localConvy',function(){
	var loc = $(this).parent().siblings('.lclHide');
	if($(this).val()==0){
		loc.removeClass('hidden');
		loc.removeClass('hidden');
	}
	else{loc.addClass('hidden');
	loc.addClass('hidden');}
	var sib =  $(this).parent().siblings();
	ajaxAmount($(this).parents('.ajm'));
});


$(document).on('change','.zone_change',function(){
	var sib =  $(this).parent().siblings();
	ajaxSelect($(this),sib);
	ajaxAmount($(this).parents('.ajm'));
	//ajaxAmount($(this).parents('.tbformm'));
	sib.find(".district_change").html("<option>Select District</option>");
	sib.find(".area_change").val("");
	sib.find(".appli_change").val("");
});
$(document).on('change','.state_change',function(){
	var sib =  $(this).parent().siblings();
	ajaxSelect($(this),sib);
	ajaxAmount($(this).parents('.ajm'));
	//ajaxAmount($(this).parents('.tbformm'));
	sib.find(".area_change").val("");
	sib.find(".appli_change").val("");
});
$(document).on('change','.district_change',function(){
	var sib =  $(this).parent().siblings();
	ajaxSelect($(this),sib);
	ajaxAmount($(this).parents('.ajm'));
	//ajaxAmount($(this).parents('.tbformm'));
});
$(document).on('change','.capacity_change',function(){
	var sib =  $(this).parent().siblings();
	ajaxSelect($(this),sib);
	ajaxAmount($(this).parents('.ajm'));
});
$(document).on('keyup','.qnty',function (){ 
	ajaxAmount($(this).parents('.ajm'));
});
$(document).on('keyup','.numKilo',function (){ 
	ajaxAmount($(this).parents('.ajm'));
});


    function ajaxSelect(tis,sib) {
		var id = tis.val();
		var type = tis.attr('data');

        if(id != ""){
                $.ajax({
                    type: "POST",
                    url: "admin/ajaxSelect.php",
                    data: 'type=' + type + '&id=' + id,
                    cache: false,
					async:false,
                    success: function(result) {	
						if(type == "state" || type == "district"){
							sib.find("."+type+"_change").html(result);	
						}
						if (type == "area") {							
							if(result == 0){
								var disp = 'Plain area';
								var disp_amnt = '0.02';
								sib.find("."+type+"_change").val(disp);
									sib.find(".appli_change").val(disp_amnt);
							}else if(result == 1){
								var disp = 'Hilly area';
								var disp_amnt = '0.04';
								sib.find("."+type+"_change").val(disp);
									sib.find(".appli_change").val(disp_amnt);
							}
						}
						if (type == "weight") {	
								sib.find("."+type+"_change").val($.trim(result));
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
	
	function ajaxAmount(tr) {
		var ref =  tr.find(".zone_change").attr('ref');
		var tmp = tr.find(".localConvy").val();
		var bucket = (tmp==null ? 5 : tmp);
		var zoneval = tr.find(".zone_change").val();
		var stateval = tr.find(".state_change").val();
		var districtval = tr.find(".district_change").val();
		var weight = tr.find(".weight_change").val();
		var qnty = tr.find(".qnty").val();
		var km = tr.find(".numKilo").val();
		var appli = tr.find(".appli_change").val();
		var frd=tr.find('.clc').val();
		var erd=tr.find('.slc').val();
		//alert('bucket=' + bucket + '&zonesel=' + zoneval + '&statesel=' + stateval + '&dissel=' + districtval + '&weight=' + weight + '&qnty=' + qnty + '&km=' + km + '&appli=' + appli+'&ref='+ref+'&fda='+frd+'&eda='+erd);
		if(bucket != ""){
                $.ajax({
                    type: "POST",
                    url: "ajaxAmount.php",
                    data: 'bucket=' + bucket + '&zonesel=' + zoneval + '&statesel=' + stateval + '&dissel=' + districtval + '&weight=' + weight + '&qnty=' + qnty + '&km=' + km + '&appli=' + appli+'&ref='+ref+'&fda='+frd+'&eda='+erd,
                    cache: false,
					async:false,
                    success: function(res) {
							tr.find("."+ref).val($.trim(res));
						tamfor();tamfor2();					
						}
                });
		}
	}
	
$(document).ready(function() {
	$('.selectpicker').selectpicker();
});
	
    </script>