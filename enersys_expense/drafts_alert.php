<?php 
include('lock.php');
include('functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Enersys Care</title>
<link rel="icon" href="img/favicon.png" type="image/png">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/datepicker.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/jquery.form.js"></script>
<link rel="stylesheet" href="css/prettify.css" type="text/css">
<link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="css/bootstrap-select.css" type="text/css">
<script type="text/javascript" src="js/bootstrap-select.js"></script>
<script type="text/javascript" src="js/prettify.js"></script>
<style>
.error{border:2px solid red;}
</style>
</head>
<body role="document" onLoad="calloftheduty('dashboard');">
<div id="loading">
	<div class="loadingBlock">
      <center><img src="img/ajax-loader.gif"><h3>Don't Refresh or Close the window</h3></center>
   </div>
</div>
<?php include('header.php'); ?>
<div class="container-fluid"><!-- Starting Of Body Container -->
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
			<div id="result"></div>
        </div>
    </div>
</div><!-- Closing Of Body Container -->
<!-- Closing Of Body Container -->
<script>
$(document).ready(function(){
	$(document).on('click','.nav li a.itemNav',function (event){
		event.preventDefault();
		calloftheduty($(this).attr('href'));
		var act=$(this).attr('data-active');
		$('.navbar-nav li').removeClass('active');
		$("."+act).addClass('active');
	});
	$(window).bind("beforeunload",function(){return "Refresh will loose the stored Data";});
	$(document).on('click','.addNew',function(event){
		event.preventDefault();
		var fieldGet=$(this).attr('data-get');
		var result= $("#"+fieldGet).first('tr').html().split("</tr>");
		$("#"+fieldGet).append(result[0]);
		$('.selectpicker').selectpicker();
		$('#'+fieldGet+ ' tr:last').find('.ticket_empty').children().last().remove();
		/*$('#'+fieldGet+ ' tr:last').find('.lclHide').children('.ocap').not('.wofCell').removeAttr('readonly');
		$('#'+fieldGet+ ' tr:last').find('.lclHide').children('.cap').not('.wofCell').removeAttr('disabled');*/
		$('#'+fieldGet+ ' tr:last').find('.sel_empty select').html('<option>--Select--</option>');
		depDate();
		datepick();
	});
	$(document).on('click','.addNewLoc',function(event){
		event.preventDefault();
		var fieldGet=$(this).attr('data-get');
		var numItems = $("#"+fieldGet).find('.localConv').children().last().attr("id");
		var num_split = numItems.split("_");
		var inc = parseInt(num_split[1])+parseInt(1);
		var result= $("#"+fieldGet).find('.localConv').children().last().html();
		var recRow = '<div id="localConv_'+inc+'" class="tbformm panel panel-default">'+result+'</div>';
		$("#"+fieldGet).find('.localConv').append(recRow);
		$("#localConv_"+inc).find('.lclHide').removeClass('hidden');
		$("#localConv_"+inc).find('.sel_empty select').html('<option>--Select--</option>');
		$('.selectpicker').selectpicker();
		$("#localConv_"+inc).find('.ticket_empty').children().last().remove();
		$("#localConv_"+inc).find('.panel-title').html('Local Conveyance '+inc);
		depDate();
		datepick();
	});
	
	$(document).on('click','.RemoveField',function(event){
		event.preventDefault();
		var fieldGet=$(this).attr('data-get');
		if($('#'+fieldGet+ ' tr').length!=1){$('#'+fieldGet+ ' tr:last').remove();}
	});
	$(document).on('click','.RemoveLoc',function(event){
		event.preventDefault();
		var fieldGet=$(this).attr('data-get');
		var fieldcnt=$(this).attr('data-cnt');
		var numItems = $("#"+fieldGet).find('.localConv').children().last().attr("id");
		var num_split = numItems.split("_");
		var inc = parseInt(num_split[1]);
		if(inc != fieldcnt){$("#localConv_"+inc).remove(); }
	});
	$(document).on('keyup','.amtt',function (e){if(isNaN($(this).val())){$(this).val("");}});
	$(document).on('click','.deletelist',function(event){
		event.preventDefault();
		var r = confirm("Are you sure to Delete");
		if (r == true){
			$('#loading').css('display','block');
			$.ajax({
			url: "item.php",
			type: "POST",
			data: 'dRef='+$(this).attr('data-type')+'&dId='+$(this).attr('href')+'&forr=1',
			success: function(result){
				$('#loading').css('display','none');
				if(result.trim()=='1') alert("Delete Successfull");else alert("Delete Unsuccessfull! Please Try Later");
				setTimeout(function(){
					if($('.referesh').attr('href').search("dvance")>='0'){
					calloftheduty("viewadvance");	
					}
					else{
						calloftheduty("viewExpense");
					}
				},200);
			}
		});
		}else{return false;}
	});
});
	$(document).on('click','.ademp',function (event){
		event.preventDefault();
		var chektoken=0;
		chektoken=getvalidate();
		if(chektoken =='1'){
			$('.alerta').html("");
			$('.alerta').removeClass("alert alert-danger");
			$('.fare1'+ ' tr').find('.lclHide').children('.cap').removeAttr('disabled');
			var formData = new FormData($('#defaultForm')[0]);
			$('#loading').css('display','block');
			$.ajax({
				url: "item.php",
				type: "POST",
				data: formData,
				processData: false,
				contentType: false,
				success: function(result) { 
					$('#result').html(result).hide().fadeIn(500);
					//$('.form-control').each(function(){$(this).val($(this).val().trim());});
					setTimeout(function(){
						$('#loading').css('display','none');
						if($('.referesh').attr('href').search("dvance")>='0'){calloftheduty("viewadvance");}
						else{calloftheduty("viewExpense");}
					},500);
					datepick();
				}
			});
		}else{
			$('.alerta').html(chektoken);
			$('.alerta').addClass("alert alert-danger");
		}
	});
	$(document).on('click','.updatex',function (event){
		event.preventDefault();
		var chektoken=0;
		chektoken=getvalidate_edit();
		
		if(chektoken =='1'){
			$('.alerta').html("");
			$('.alerta').removeClass("alert alert-danger");
		var formData = new FormData($('#defaultForm')[0]);
		$('#loading').css('display','block');
		$.ajax({
			url: "include/update.php",
			type: "POST",
			data: formData,
			processData: false,
			contentType: false,
			success: function(result) {
				$('#loading').css('display','none');
				$('#result').html(result).hide().fadeIn(500);
				$('.form-control').each(function(){$(this).val($(this).val().trim());});
				setTimeout(function(){
					if($('.referesh').attr('href').search("dvance")>='0'){
					calloftheduty("viewadvance");	
					}
					else{
						calloftheduty("viewExpense");
					}
				},2000);
				datepick();
			}
		});
		}else{
			$('.alerta').html(chektoken);
			$('.alerta').addClass("alert alert-danger");
		}
	});
	$(document).on('click','.exportx',function (event){
		event.preventDefault();
		if($(this).hasClass('validat')){
			if($('[name="employees"]').val()==''){
				alert("Please Select Employees");
				var check=0;
			}else{var check=1;}
		}else{var check=1;}
		if(check){
			var formData = new FormData($('#defaultForm')[0]);
			$('#loading').css('display','block');
			$.ajax({
				url: "item.php",
				type: "POST",
				data: formData,
				processData: false,
				contentType: false,
				success: function(result) {
					$('#loading').css('display','none');
					$('#result').html(result).hide().fadeIn(500);
					$('.form-control').each(function(){$(this).val($(this).val().trim());});
					
					datepick();
				}
			});
		}
	});

	
	$(document).on('click','.rejectx',function (event){
		event.preventDefault();
		var chektoken=0;
		chektoken=getvalidate_edit();
		if(chektoken =='1'){
			$('.alerta').html("");
			$('.alerta').removeClass("alert alert-danger");
		var formData = new FormData($('#defaultForm')[0]);
		$('#loading').css('display','block');
		$.ajax({
			url: "include/reject.php",
			type: "POST",
			data: formData,
			processData: false,
			contentType: false,
			success: function(result) {
				$('#loading').css('display','none');
				$('#result').html(result).hide().fadeIn(500);
				$('.form-control').each(function(){$(this).val($(this).val().trim());});
				setTimeout(function(){
					if($('.referesh').attr('href').search("dvance")>='0'){
					calloftheduty("viewadvance");	
					}
					else{
						calloftheduty("viewExpense");
					}
				},2000);
				datepick();
			}
		});
		}else{
			$('.alerta').html(chektoken);
			$('.alerta').addClass("alert alert-danger");
		}
	});
	$(document).on('click','.saveinDraft',function (event){
		event.preventDefault();
		var chektoken=0;
		var draft = 1;
		chektoken=getvalidate(draft);
		if(chektoken =='1'){
			$('.alerta').html("");
			$('.alerta').removeClass("alert alert-danger");
			var formData = new FormData($('#defaultForm')[0]);
			$('#loading').css('display','block');
			$.ajax({
				url: "item.php?rcq=save",
				type: "POST",
				data: formData,
				processData: false,
				contentType: false,
				success: function(result) {//alert(result);
					$('#loading').css('display','none');
					$('#result').html(result).hide().fadeIn(500);
					//$('.form-control').each(function(){$(this).val($(this).val().trim());});
					setTimeout(function(){
						if($('.referesh').attr('href').search("dvance")>='0'){calloftheduty("viewadvance");}
						else{calloftheduty("viewExpense");}
					},2000);
					datepick();
				}
			});
		}else{
			$('.alerta').html(chektoken);
			$('.alerta').addClass("alert alert-danger");
		}
	});
	
	$(document).on('click','.edis',function (event){
		$('#loading').css('display','block');
		event.preventDefault();
		var ref=$(this).attr('data-type');
		$.ajax({
			url: "item.php",
			type: "POST",
			data: 'ref='+$(this).attr('data-type')+'&id='+$(this).attr('href'),
			success: function(result) {
				$('#loading').css('display','none');
				$('#result').html(result).hide().fadeIn(500);
				$('.referesh').attr('href',ref);
				$('.form-control').each(function(){$(this).val($(this).val().trim());});
				datepick();
			}
		});
	});
function calloftheduty(ref){
$('#loading').css('display','block');
	$.ajax({
		url : 'item.php',
		data: 'ref='+ref,
		type:'post',
		cache:false,
		success: function(res){
			$('#loading').css('display','none');
			$('#result').html(res).hide().fadeIn(500);
			$('.referesh').attr('href',ref);
			$('.form-control').each(function(){$(this).val($(this).val().trim());});
			$('.datepicker_spl').datepicker({format: 'dd-mm-yyyy'}).on('changeDate', function(ev){listdetailsfun();});
			
			datepick();
		}
	});
}
function listdetailsfun(){
	$('#loading').css('display','block');
	$.ajax({
		type: "GET",
		url: "include/getdetails.php",
		data: $("#sortform").serialize(),
		cache: true,
		success: function(result){
			$('#loading').css('display','none');
			result=result.split("##");
			$('#getList').html(result[0]);
//			$('#totalcount').val(result[1]);
//			$('#pagx').html(result[2]);
			
			datepick();
		}
	});
}
function datepick(){
	var nowTemp1 = new Date();var now1 = new Date(nowTemp1.getFullYear(), nowTemp1.getMonth(), nowTemp1.getDate(), 0, 0, 0, 0);
	var gendate = $('.datepickers').datepicker({format: 'dd-mm-yyyy',onRender: function(date){return date.valueOf() > now1.valueOf() ? 'disabled' : '' ;}}).on('changeDate', function(ev){gendate.hide();}).data('datepicker');
	$('.datepicker').datepicker({format: 'dd-mm-yyyy'});
}

function getvalidate_edit(){var mess=1; var errelm="";
	if($('input[name="ref"]').val()=="editAdvance"){
		$('.form-group').css('border', 'none'); 
		if($('input[name="advRequested"]').val()==""){errelm=$('input[name="advRequested"]').parent('div');mess="Enter Request Amount";}
		else if($('.reasonForAdv').val()==""){errelm=$('.reasonForAdv').parent('div');mess="Enter Remarks";}
		else mess=1;
	}
	else if($('input[name="ref"]').val()=="editExpense"){
		$('td').css('border', '1px solid #ddd'); 
		$('.form-group').css('border', '0px solid #fff'); 
		if($('input[name="visitFromDate"]').val()==""){errelm=$('input[name="visitFromDate"]').parent('div');mess="Enter Visit from Date";}
		else if($('input[name="visitToDate"]').val()==""){errelm=$('input[name="visitToDate"]').parent('div');mess="Enter Visit To Date";}
		else if($('input[name="placesOfVisit"]').val()==""){errelm=$('input[name="placesOfVisit"]').parent('div');mess="Enter Places of Visit";}
		else if($('.reasonForAdv').val()==""){errelm=$('.reasonForAdv').parent('div'); mess="Enter Reason/ Remarks/ Purpose";}
		else if($('input[name="others[]"]:eq(0)').val()=="" &&  $('select[name="typeofstay[]"]:eq(0)').val()=='0' && $('input[name="dot_l[]"]:eq(0)').val()=="" && $('input[name="dot[]"]:eq(0)').val()==""){errelm=$(''); mess="Enter Atleast One Expense Details";}
		else{
			$('input[name="dot[]"]').each(function(i,valuee){
				if($(this).val()!=""){
					if($('select[name="mot[]"]:eq('+i+')').val()=='0'){errelm=$('select[name="mot[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select Mode of travel";}
					else if($('input[name="from[]"]:eq('+i+')').val()==''){errelm=$('input[name="from[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select From place";}
					else if($('input[name="to[]"]:eq('+i+')').val()==''){errelm=$('input[name="to[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select To place";}
					else if($('input[name="amt[]"]:eq('+i+')').val()==''){errelm=$('input[name="amt[]"]:eq('+i+')').parent('td'); mess="Conveyance: Enter Amount";}
				}
			});
			$('input[name="dot_l[]"]').each(function(i,valuee){
				if($(this).val()!=""){
					if($('select[name="mot_l[]"]:eq('+i+')').val()=='0'){errelm=$('select[name="mot_l[]"]:eq('+i+')').parent('td'); mess="Local Conveyance: Select Mode of travel";}
					else if($('input[name="from_l[]"]:eq('+i+')').val()==''){errelm=$('input[name="from_l[]"]:eq('+i+')').parent('td'); mess="Local Conveyance: Select From place";}
					else if($('input[name="to_l[]"]:eq('+i+')').val()==''){errelm=$('input[name="to_l[]"]:eq('+i+')').parent('td'); mess="Local Conveyance: Select To place";}
					else if($('input[name="amt_l[]"]:eq('+i+')').val()==''){errelm=$('input[name="amt_l[]"]:eq('+i+')').parent('td'); mess="Local Conveyance: Enter Amount";}	
				}
			});
			$('select[name="typeofstay[]"]').each(function(i,valuee){
				if($(this).val()!="0"){
					if($('input[name="checkin[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkin[]"]:eq('+i+')').parent('td'); mess="Lodging: Select Visit: Start Date";}
					else if($('input[name="checkout[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkout[]"]:eq('+i+')').parent('td'); mess="Lodging: Select Visit: End Date";}
					else if($('.htname:eq('+i+')').val()=='' || $('.htname:eq('+i+')').val()=='0'){errelm=$('.htname:eq('+i+')').parent('td'); mess="Lodging: Select Hotel Name";}
					else if($('input[name="lamt[]"]:eq('+i+')').val()==''){errelm=$('input[name="lamt[]"]:eq('+i+')').parent('td'); mess="Lodging: Enter Amount";}	
				}
			});
			$('select[name="state[]"]').each(function(i,valuee){
				if($(this).val()!="0"){
					if($('input[name="checkin[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkin[]"]:eq('+i+')').parent('td'); mess="Boarding: Select Visit: Start Date";}
					else if($('input[name="checkout[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkout[]"]:eq('+i+')').parent('td'); mess="Boarding: Select Visit: End Date";}
					else if($('.htname:eq('+i+')').val()=='' || $('.htname:eq('+i+')').val()=='0'){errelm=$('.htname:eq('+i+')').parent('td'); mess="Boarding: Select State";}
					else if($('input[name="bamt[]"]:eq('+i+')').val()==''){errelm=$('input[name="bamt[]"]:eq('+i+')').parent('td'); mess="Boarding: Enter Amount";}	
					else mess=1;
				}
			});
			$('input[name="others[]"]').each(function(i,valuee){
				if($(this).val()!=""){
					if($('input[name="oamt[]"]:eq('+i+')').val()==''){errelm=$('input[name="oamt[]"]:eq('+i+')').parent('td'); mess="Others: Enter Amount";} 
					else if($('input[name="odate[]"]:eq('+i+')').val()==''){errelm=$('input[name="odate[]"]:eq('+i+')').parent('td'); mess="Others: Select Date";}
				}
			});
		} 
	}else if($('input[name="ref"]').val()=="serEditExpense"){
		$('td').css('border', '1px solid #ddd'); 
		$('.form-group').css('border', '0px solid #fff'); 
		if($('input[name="visitFromDate"]').val()==""){errelm=$('input[name="visitFromDate"]').parent('div');mess="Enter Visit from Date";}
		else if($('input[name="visitToDate"]').val()==""){errelm=$('input[name="visitToDate"]').parent('div');mess="Enter Visit To Date";}
		else if($('input[name="placesOfVisit"]').val()==""){errelm=$('input[name="placesOfVisit"]').parent('div');mess="Enter Places of Visit";}
		else if($('.reasonForAdv').val()==""){errelm=$('.reasonForAdv').parent('div'); mess="Enter Purpose/ Reason/ Remarks";}
		else if($('input[name="others[]"]:eq(0)').val()=="" &&  $('select[name="zone_ld[]"]:eq(0)').val()!="0" && $('input[name="dot_l[]"]:eq(0)').val()=="" && $('input[name="dot[]"]:eq(0)').val()==""){errelm=$(''); mess="Enter Atleast One Expense Details";}
				
				/* Local Conveyance */
				$('select[name="zone_l[]"]').each(function(i,valuee){
				 if($(this).val()!="0"){  
				 		 if($('select[name="state_l[]"]:eq('+i+')').val() != null){$('select[name="state_l[]"]:eq('+i+')').removeClass('error');}
						 if($('select[name="district_l[]"]:eq('+i+')').val() != null){$('select[name="district_l[]"]:eq('+i+')').removeClass('error'); }
						 if($('select[name="bucket[]"]:eq('+i+')').val() != null){$('select[name="bucket[]"]:eq('+i+')').removeClass('error'); }
						 if($('input[name="dot_l[]"]:eq('+i+')').val() != null){$('input[name="dot_l[]"]:eq('+i+')').removeClass('error');}
						 if($('select[name="mot_l[]"]:eq('+i+')').val()!= null){$('select[name="mot_l[]"]:eq('+i+')').removeClass('error'); }
						 if($('input[name="from_l[]"]:eq('+i+')').val() !=''){$('input[name="from_l[]"]:eq('+i+')').removeClass('error');}
						 if($('input[name="to_l[]"]:eq('+i+')').val() !=''){$('input[name="to_l[]"]:eq('+i+')').removeClass('error');}
						 if(($('input[name="amt_l[]"]:eq('+i+')').val()!='') && ($('input[name="amt_l[]"]:eq('+i+')').val()!='0')){$('input[name="amt_l[]"]:eq('+i+')').removeClass('error');}
						 if($('select[name="ticket_idl[]"]:eq('+i+')').val()== ''){ $('select[name="ticket_idl[]"]:eq('+i+')').siblings().find('.selectpicker').removeClass('error');}
						 if($('input[name="dprNum_l[]"]:eq('+i+')').val() !=''){$('input[name="dprNum_l[]"]:eq('+i+')').removeClass('error');}						

					if($('select[name="state_l[]"]:eq('+i+')').val()=== null){$('select[name="state_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Select State";}
					else if($('select[name="district_l[]"]:eq('+i+')').val()=== null){$('select[name="district_l[]"]:eq('+i+')').addClass('error'); mess="Local Conveyance: Select District";}
					else if($('select[name="bucket[]"]:eq('+i+')').val()=== null){$('select[name="bucket[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Select Bucket";}
					else if($('input[name="dot_l[]"]:eq('+i+')').val()== ''){$('input[name="dot_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Select Date of travel";}
					else if($('select[name="mot_l[]"]:eq('+i+')').val()=== null){$('select[name="mot_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Select Mode of travel";}
					else if($('input[name="from_l[]"]:eq('+i+')').val()==''){$('input[name="from_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Enter From place";}
					else if($('input[name="to_l[]"]:eq('+i+')').val()==''){$('input[name="to_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Enter To place";}					
					else if(($('input[name="amt_l[]"]:eq('+i+')').val()=='') || ($('input[name="amt_l[]"]:eq('+i+')').val()=='0')){$('input[name="amt_l[]"]:eq('+i+')').addClass('error'); mess="Local Conveyance: Enter Amount";}	
					else if($('select[name="ticket_idl[]"]:eq('+i+')').val()== ''){$('select[name="ticket_idl[]"]:eq('+i+')').siblings().find('.selectpicker').addClass('error');mess="Local Conveyance: Select Ticket Id";}
					else if($('input[name="dprNum_l[]"]:eq('+i+')').val()==''){$('input[name="dprNum_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Enter DPR Number";}
					else mess=1;
				}
			});

			/* Conveyance */
			$('input[name="dot[]"]').each(function(i,valuee){
				if($(this).val()!=""){
					$('input[name="dprNum_l[]"]:eq('+i+')').removeClass('error');
					if($('select[name="mot[]"]:eq('+i+')').val()=='0'){errelm=$('select[name="mot[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select Mode of travel";}
					else if($('input[name="from[]"]:eq('+i+')').val()==''){errelm=$('input[name="from[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select From place";}
					else if($('input[name="to[]"]:eq('+i+')').val()==''){errelm=$('input[name="to[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select To place";}
					else if($('input[name="amt[]"]:eq('+i+')').val()==''){errelm=$('input[name="amt[]"]:eq('+i+')').parent('td'); mess="Conveyance: Enter Amount";}
					else if($('select[name="cticket_id[]"]:eq('+i+')').val()== ''){errelm=$('select[name="cticket_id[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select Ticket Id";}
					else if($('input[name="cdprno[]"]:eq('+i+')').val()==''){errelm=$('input[name="cdprno[]"]:eq('+i+')').parent('td'); mess="Conveyance: Enter DPR Number";}
					else mess=1;
				}
			});
			
			/* boarding */
			$('select[name="zone_bo[]"]').each(function(i,valuee){ 
				if($(this).val()!="0"){ 
					$('input[name="dprNum_l[]"]:eq('+i+')').removeClass('error');
					if($('select[name="state_bo[]"]:eq('+i+')').val()=== null){errelm=$('select[name="state_bo[]"]:eq('+i+')').parent('td'); mess="Lodging: Select State";}
					else if($('select[name="district_bo[]"]:eq('+i+')').val()=== null){errelm=$('select[name="district_bo[]"]:eq('+i+')').parent('td'); mess="Lodging: Select District";}
					else if($('input[name="checkinb[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkinb[]"]:eq('+i+')').parent('td'); mess="Boarding: Select Visit: Start Date";}
					else if($('input[name="checkoutb[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkoutb[]"]:eq('+i+')').parent('td'); mess="Boarding: Select Visit: End Date";}
					else if($('input[name="bamt[]"]:eq('+i+')').val()==''){errelm=$('input[name="bamt[]"]:eq('+i+')').parent('td'); mess="Boarding: Enter Amount";}	
					else if($('select[name="ticket_bo[]"]:eq('+i+')').val()== ''){errelm=$('select[name="ticket_bo[]"]:eq('+i+')').parent('td'); mess="Boarding: Select Ticket Id";}
					else if($('input[name="dprNum_bo[]"]:eq('+i+')').val()==''){errelm=$('input[name="dprNum_bo[]"]:eq('+i+')').parent('td'); mess="Boarding: Enter DPR Number";}
					else mess=1;
				}
			});
			
			/* Lodging */
			$('select[name="zone_ld[]"]').each(function(i,valuee){
				if($(this).val()!="0"){ 
					$('input[name="dprNum_l[]"]:eq('+i+')').removeClass('error');
					if($('select[name="state_ld[]"]:eq('+i+')').val()=== null){errelm=$('select[name="state_ld[]"]:eq('+i+')').parent('td'); mess="Lodging: Select State";}
					else if($('select[name="district_ld[]"]:eq('+i+')').val()=== null){errelm=$('select[name="district_ld[]"]:eq('+i+')').parent('td'); mess="Lodging: Select District";}
					else if($('input[name="checkin[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkin[]"]:eq('+i+')').parent('td'); mess="Lodging: Select Visit: Start Date";}
					else if($('input[name="checkout[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkout[]"]:eq('+i+')').parent('td'); mess="Lodging: Select Visit: End Date";}
					else if($('input[name="hotelName[]"]:eq('+i+')').val()==''){errelm=$('input[name="hotelName[]"]:eq('+i+')').parent('td'); mess="Lodging: Enter Hotel Name";}
					else if($('input[name="lamt[]"]:eq('+i+')').val()==''){errelm=$('input[name="lamt[]"]:eq('+i+')').parent('td'); mess="Lodging: Enter Amount";}
					else if($('select[name="ticket_idld[]"]:eq('+i+')').val()== ''){errelm=$('select[name="ticket_idld[]"]:eq('+i+')').parent('td'); mess="Lodging: Select Ticket Id";}
					else if($('input[name="dprNum_ld[]"]:eq('+i+')').val()==''){errelm=$('input[name="dprNum_ld[]"]:eq('+i+')').parent('td'); mess="Lodging: Enter DPR Number";}
					else mess=1;
				}
			});
			
			/* others */
			$('input[name="others[]"]').each(function(i,valuee){
				if($(this).val()!=""){
					$('input[name="dprNum_l[]"]:eq('+i+')').removeClass('error');
					if($('input[name="oamt[]"]:eq('+i+')').val()==''){errelm=$('input[name="oamt[]"]:eq('+i+')').parent('td');mess="Others: Enter Amount";}
					else if($('input[name="odate[]"]:eq('+i+')').val()==''){errelm=$('input[name="odate[]"]:eq('+i+')').parent('td');mess="Others: Select Date";}
					else if($('select[name="ticket_ot[]"]:eq('+i+')').val()==''){errelm=$('select[name="ticket_ot[]"]:eq('+i+')').parent('td');mess="Others: Select Ticket Id";}
					else if($('input[name="dprNum_ot[]"]:eq('+i+')').val()==''){errelm=$('input[name="dprNum_ot[]"]:eq('+i+')').parent('td');mess="Others: Enter DPR Number";}else mess=1;
				}
			});
		}else mess=0;
	$(errelm).css('border', '2px solid red');
	return mess;
}
function getvalidate(draft){var mess; var errelm="";
	//alert("____"); 
	//var draftval = draft; alert(draftval);
	if($('input[name="ref"]').val()=="editAdvance"){
		$('.form-group').css('border', 'none'); 
		if($('input[name="advRequested"]').val()==""){errelm=$('input[name="advRequested"]').parent('div');mess="Enter Request Amount";}
		else if($('.reasonForAdv').val()==""){errelm=$('.reasonForAdv').parent('div');mess="Enter Remarks";}
		else mess=1;
	}
	else if($('input[name="ref"]').val()=="bookAdvance"){
		$('.form-group').css('border', 'none'); 
		if($('input[name="advRequested"]').val()==""){errelm=$('input[name="advRequested"]').parent('div');mess="Enter Request Amount";}
		else if($('.reasonForAdv').val()==""){errelm=$('.reasonForAdv').parent('div');mess="Enter Remarks";}
		else if(ValidateExtension()=="0"){errelm=$('.tplanningreport').parent('div');mess="Upload Tour Planning Report(Only .pdf file Allowed)";}
		else mess=1;
	}
	else if($('input[name="ref"]').val()=="bookExpense"){
		$('td').css('border', '1px solid #ddd'); 
		$('.form-group').css('border', '0px solid #fff'); 
		if($('input[name="visitFromDate"]').val()==""){errelm=$('input[name="visitFromDate"]').parent('div');mess="Enter Visit from Date";}
		else if($('input[name="visitToDate"]').val()==""){errelm=$('input[name="visitToDate"]').parent('div');mess="Enter Visit To Date";}
		else if($('input[name="placesOfVisit"]').val()==""){errelm=$('input[name="placesOfVisit"]').parent('div');mess="Enter Places of Visit";}
		else if($('.reasonForAdv').val()==""){errelm=$('.reasonForAdv').parent('div'); mess="Enter Purpose";}
		else if($('input[name="others[]"]:eq(0)').val()=="" &&  $('select[name="typeofstay[]"]:eq(0)').val()=='0' && $('input[name="dot_l[]"]:eq(0)').val()=="" && $('input[name="dot[]"]:eq(0)').val()==""){errelm=$(''); mess="Enter Atleast One Expense Details";}
		else if(ValidateExtension()=="0"){errelm=$('.tplanningreport').parent('div');mess="Upload Tour Report(Only .pdf file Allowed)";}
		else{
			$('input[name="others[]"]').each(function(i,valuee){
				if($(this).val()!=""){
					if($('input[name="oamt[]"]:eq('+i+')').val()==''){errelm=$('input[name="oamt[]"]:eq('+i+')').parent('td'); mess="Others: Enter Amount";} 
					else if($('input[name="odate[]"]:eq('+i+')').val()==''){errelm=$('input[name="odate[]"]:eq('+i+')').parent('td'); mess="Others: Select Date";}
					else mess=1;
				}
			});

			$('select[name="state[]"]').each(function(i,valuee){
				if($(this).val()!="0"){
					if($('input[name="checkin[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkin[]"]:eq('+i+')').parent('td'); mess="Boarding: Select Visit: Start Date";}
					else if($('input[name="checkout[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkout[]"]:eq('+i+')').parent('td'); mess="Boarding: Select Visit: End Date";}
					else if($('.htname:eq('+i+')').val()=='' || $('.htname:eq('+i+')').val()=='0'){errelm=$('.htname:eq('+i+')').parent('td'); mess="Boarding: Select State";}
					else if($('input[name="bamt[]"]:eq('+i+')').val()==''){errelm=$('input[name="bamt[]"]:eq('+i+')').parent('td'); mess="Boarding: Enter Amount";}
					else mess=1;
				}
			});
			$('select[name="typeofstay[]"]').each(function(i,valuee){
				if($(this).val()!="0"){
					if($('input[name="checkin[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkin[]"]:eq('+i+')').parent('td'); mess="Lodging: Select Visit: Start Date";}
					else if($('input[name="checkout[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkout[]"]:eq('+i+')').parent('td'); mess="Lodging: Select Visit: End Date";}
					else if($('.htname:eq('+i+')').val()=='' || $('.htname:eq('+i+')').val()=='0'){errelm=$('.htname:eq('+i+')').parent('td'); mess="Lodging: Select Hotel Name";}
					else if($('input[name="lamt[]"]:eq('+i+')').val()==''){errelm=$('input[name="lamt[]"]:eq('+i+')').parent('td'); mess="Lodging: Enter Amount";}
					else mess=1;
				}
			});

			$('input[name="dot_l[]"]').each(function(i,valuee){
				if($(this).val()!=""){
					if($('select[name="mot_l[]"]:eq('+i+')').val()=='0'){errelm=$('select[name="mot_l[]"]:eq('+i+')').parent('td'); mess="Local Conveyance: Select Mode of travel";}
					else if($('input[name="from_l[]"]:eq('+i+')').val()==''){errelm=$('input[name="from_l[]"]:eq('+i+')').parent('td'); mess="Local Conveyance: Select From place";}
					else if($('input[name="to_l[]"]:eq('+i+')').val()==''){errelm=$('input[name="to_l[]"]:eq('+i+')').parent('td'); mess="Local Conveyance: Select To place";}
					else if($('input[name="amt_l[]"]:eq('+i+')').val()==''){errelm=$('input[name="amt_l[]"]:eq('+i+')').parent('td'); mess="Local Conveyance: Enter Amount";}
					else mess=1;
				}
			});
			$('input[name="dot[]"]').each(function(i,valuee){
				if($(this).val()!=""){
					if($('select[name="mot[]"]:eq('+i+')').val()=='0'){errelm=$('select[name="mot[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select Mode of travel";}
					else if($('input[name="from[]"]:eq('+i+')').val()==''){errelm=$('input[name="from[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select From place";}
					else if($('input[name="to[]"]:eq('+i+')').val()==''){errelm=$('input[name="to[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select To place";}
					else if($('input[name="amt[]"]:eq('+i+')').val()==''){errelm=$('input[name="amt[]"]:eq('+i+')').parent('td'); mess="Conveyance: Enter Amount";}
					else mess=1;
				}
			});
		} 

	}else if($('input[name="ref"]').val()=="editExpense"){
		$('td').css('border', '1px solid #ddd'); 
		$('.form-group').css('border', '0px solid #fff'); 
		if($('input[name="visitFromDate"]').val()==""){errelm=$('input[name="visitFromDate"]').parent('div');mess="Enter Visit from Date";}
		else if($('input[name="visitToDate"]').val()==""){errelm=$('input[name="visitToDate"]').parent('div');mess="Enter Visit To Date";}
		else if($('input[name="placesOfVisit"]').val()==""){errelm=$('input[name="placesOfVisit"]').parent('div');mess="Enter Places of Visit";}
		else if($('.reasonForAdv').val()==""){errelm=$('.reasonForAdv').parent('div'); mess="Enter Reason/ Remarks/ Purpose";}
		else if($('input[name="others[]"]:eq(0)').val()=="" &&  $('select[name="typeofstay[]"]:eq(0)').val()=='0' && $('input[name="dot_l[]"]:eq(0)').val()=="" && $('input[name="dot[]"]:eq(0)').val()==""){errelm=$(''); mess="Enter Atleast One Expense Details";}
		else{
			$('input[name="dot[]"]').each(function(i,valuee){
				if($(this).val()!=""){
					if($('select[name="mot[]"]:eq('+i+')').val()=='0'){errelm=$('select[name="mot[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select Mode of travel";}
					else if($('input[name="from[]"]:eq('+i+')').val()==''){errelm=$('input[name="from[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select From place";}
					else if($('input[name="to[]"]:eq('+i+')').val()==''){errelm=$('input[name="to[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select To place";}
					else if($('input[name="amt[]"]:eq('+i+')').val()==''){errelm=$('input[name="amt[]"]:eq('+i+')').parent('td'); mess="Conveyance: Enter Amount";}
					else mess=1;
				}
			});
			$('input[name="dot_l[]"]').each(function(i,valuee){
				if($(this).val()!=""){
					if($('select[name="mot_l[]"]:eq('+i+')').val()=='0'){errelm=$('select[name="mot_l[]"]:eq('+i+')').parent('td'); mess="Local Conveyance: Select Mode of travel";}
					else if($('input[name="from_l[]"]:eq('+i+')').val()==''){errelm=$('input[name="from_l[]"]:eq('+i+')').parent('td'); mess="Local Conveyance: Select From place";}
					else if($('input[name="to_l[]"]:eq('+i+')').val()==''){errelm=$('input[name="to_l[]"]:eq('+i+')').parent('td'); mess="Local Conveyance: Select To place";}
					else if($('input[name="amt_l[]"]:eq('+i+')').val()==''){errelm=$('input[name="amt_l[]"]:eq('+i+')').parent('td'); mess="Local Conveyance: Enter Amount";}	
					else mess=1;
				}
			});
			$('select[name="typeofstay[]"]').each(function(i,valuee){
				if($(this).val()!="0"){
					if($('input[name="checkin[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkin[]"]:eq('+i+')').parent('td'); mess="Lodging: Select Visit: Start Date";}
					else if($('input[name="checkout[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkout[]"]:eq('+i+')').parent('td'); mess="Lodging: Select Visit: End Date";}
					else if($('.htname:eq('+i+')').val()=='' || $('.htname:eq('+i+')').val()=='0'){errelm=$('.htname:eq('+i+')').parent('td'); mess="Lodging: Select Hotel Name";}
					else if($('input[name="lamt[]"]:eq('+i+')').val()==''){errelm=$('input[name="lamt[]"]:eq('+i+')').parent('td'); mess="Lodging: Enter Amount";}	
					else mess=1;
				}
			});
			$('select[name="state[]"]').each(function(i,valuee){
				if($(this).val()!="0"){
					if($('input[name="checkin[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkin[]"]:eq('+i+')').parent('td'); mess="Boarding: Select Visit: Start Date";}
					else if($('input[name="checkout[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkout[]"]:eq('+i+')').parent('td'); mess="Boarding: Select Visit: End Date";}
					else if($('.htname:eq('+i+')').val()=='' || $('.htname:eq('+i+')').val()=='0'){errelm=$('.htname:eq('+i+')').parent('td'); mess="Boarding: Select State";}
					else if($('input[name="bamt[]"]:eq('+i+')').val()==''){errelm=$('input[name="bamt[]"]:eq('+i+')').parent('td'); mess="Boarding: Enter Amount";}	
					else mess=1;
				}
			});
			$('input[name="others[]"]').each(function(i,valuee){
				if($(this).val()!=""){
					if($('input[name="oamt[]"]:eq('+i+')').val()==''){errelm=$('input[name="oamt[]"]:eq('+i+')').parent('td'); mess="Others: Enter Amount";} 
					else if($('input[name="odate[]"]:eq('+i+')').val()==''){errelm=$('input[name="odate[]"]:eq('+i+')').parent('td'); mess="Others: Select Date";}
					else mess=1;
				}
			});
		} 
	}
	else if($('input[name="ref"]').val()=="serviceExpense"){ 
		$('td').css('border', '1px solid #ddd'); 
		$('.form-group').css('border', '0px solid #fff'); 
		if($('input[name="visitFromDate"]').val()==""){ errelm=$('input[name="visitFromDate"]').parent('div');
		mess="Enter Visit from Date";}
		else if($('input[name="visitToDate"]').val()==""){errelm=$('input[name="visitToDate"]').parent('div');mess="Enter Visit To Date";}
		else if($('input[name="placesOfVisit"]').val()==""){errelm=$('input[name="placesOfVisit"]').parent('div');mess="Enter Places of Visit";}
		else if($('.reasonForAdv').val()==""){errelm=$('.reasonForAdv').parent('div'); mess="Enter Purpose";}
		else if($('input[name="others[]"]:eq(0)').val()=="" &&  $('select[name="zone_l[]"]:eq(0)').val()=="0" && $('select[name="zone_ld[]"]:eq(0)').val()=="0" && $('input[name="dot[]"]:eq(0)').val()==""){errelm=$(''); mess="Enter Atleast One Expense Details";}
		else if($('input[name="others[]"]:eq(0)').val()!="" ||  $('select[name="zone_l[]"]:eq(0)').val()!="0" || $('select[name="zone_ld[]"]:eq(0)').val()!="0" || $('input[name="dot[]"]:eq(0)').val()!="" || $('select[name="zone_bo[]"]:eq(0)').val()!="0"){ 
				/* Local Conveyance */
				$('select[name="zone_l[]"]').each(function(i,valuee){
				 if($(this).val()!="0"){  //alert($('input[name="amt_l[]"]:eq('+i+')').val());
				 		 if($('select[name="state_l[]"]:eq('+i+')').val() != null){$('select[name="state_l[]"]:eq('+i+')').removeClass('error');}
						 if($('select[name="district_l[]"]:eq('+i+')').val() != null){$('select[name="district_l[]"]:eq('+i+')').removeClass('error'); }
						 if($('select[name="bucket[]"]:eq('+i+')').val() != null){$('select[name="bucket[]"]:eq('+i+')').removeClass('error'); }
						 if($('input[name="dot_l[]"]:eq('+i+')').val() != null){$('input[name="dot_l[]"]:eq('+i+')').removeClass('error');}
						 if($('select[name="mot_l[]"]:eq('+i+')').val()!= null){$('select[name="mot_l[]"]:eq('+i+')').removeClass('error'); }
						 if($('input[name="from_l[]"]:eq('+i+')').val() !=''){$('input[name="from_l[]"]:eq('+i+')').removeClass('error');}
						 if($('input[name="to_l[]"]:eq('+i+')').val() !=''){$('input[name="to_l[]"]:eq('+i+')').removeClass('error');}
						 if(($('input[name="amt_l[]"]:eq('+i+')').val()!='') && ($('input[name="amt_l[]"]:eq('+i+')').val()!='0')){$('input[name="amt_l[]"]:eq('+i+')').removeClass('error');}
						 if($('select[name="ticket_idl[]"]:eq('+i+')').val()== ''){ $('select[name="ticket_idl[]"]:eq('+i+')').siblings().find('.selectpicker').removeClass('error');}
						 if($('input[name="dprNum_l[]"]:eq('+i+')').val() !=''){$('input[name="dprNum_l[]"]:eq('+i+')').removeClass('error');}						

					if($('select[name="state_l[]"]:eq('+i+')').val()=== null){$('select[name="state_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Select State";}
					else if($('select[name="district_l[]"]:eq('+i+')').val()=== null){$('select[name="district_l[]"]:eq('+i+')').addClass('error'); mess="Local Conveyance: Select District";}
					else if($('select[name="bucket[]"]:eq('+i+')').val()=== null){$('select[name="bucket[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Select Bucket";}
					else if($('input[name="dot_l[]"]:eq('+i+')').val()== ''){$('input[name="dot_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Select Date of travel";}
					else if($('select[name="mot_l[]"]:eq('+i+')').val()=== null){$('select[name="mot_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Select Mode of travel";}
					else if($('input[name="from_l[]"]:eq('+i+')').val()==''){$('input[name="from_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Enter From place";}
					else if($('input[name="to_l[]"]:eq('+i+')').val()==''){$('input[name="to_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Enter To place";}					
					else if(($('input[name="amt_l[]"]:eq('+i+')').val()=='') || ($('input[name="amt_l[]"]:eq('+i+')').val()=='0')){$('input[name="amt_l[]"]:eq('+i+')').addClass('error'); mess="Local Conveyance: Enter Amount";}	
					else if($('select[name="ticket_idl[]"]:eq('+i+')').val()== ''){$('select[name="ticket_idl[]"]:eq('+i+')').siblings().find('.selectpicker').addClass('error');mess="Local Conveyance: Select Ticket Id";}
					else if($('input[name="dprNum_l[]"]:eq('+i+')').val()==''){$('input[name="dprNum_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Enter DPR Number";}
					else mess=1;
				}
			});
			/* Conveyance */
			$('input[name="dot[]"]').each(function(i,valuee){
				if($(this).val()!=""){
					$('input[name="dprNum_l[]"]:eq('+i+')').removeClass('error');
					if($('select[name="mot[]"]:eq('+i+')').val()=='0'){errelm=$('select[name="mot[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select Mode of travel";}
					else if($('input[name="from[]"]:eq('+i+')').val()==''){errelm=$('input[name="from[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select From place";}
					else if($('input[name="to[]"]:eq('+i+')').val()==''){errelm=$('input[name="to[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select To place";}
					else if($('input[name="amt[]"]:eq('+i+')').val()==''){errelm=$('input[name="amt[]"]:eq('+i+')').parent('td'); mess="Conveyance: Enter Amount";}
					else if($('select[name="cticket_id[]"]:eq('+i+')').val()== ''){errelm=$('select[name="cticket_id[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select Ticket Id";}
					else if($('input[name="cdprno[]"]:eq('+i+')').val()==''){errelm=$('input[name="cdprno[]"]:eq('+i+')').parent('td'); mess="Conveyance: Enter DPR Number";}
					else mess=1;
				}
			});
			
			/* boarding */
			$('select[name="zone_bo[]"]').each(function(i,valuee){ 
				if($(this).val()!="0"){ 
				
				//else if($('input[name="bamt[]"]:eq('+i+')').val()==''){errelm=$('input[name="bamt[]"]:eq('+i+')').parent('td'); mess="Boarding: Enter Amount";}	

					$('input[name="dprNum_l[]"]:eq('+i+')').removeClass('error');
					if($('select[name="state_bo[]"]:eq('+i+')').val()=== null){errelm=$('select[name="state_bo[]"]:eq('+i+')').parent('td'); mess="Lodging: Select State";}
					else if($('select[name="district_bo[]"]:eq('+i+')').val()=== null){errelm=$('select[name="district_bo[]"]:eq('+i+')').parent('td'); mess="Lodging: Select District";}
					else if($('input[name="checkinb[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkinb[]"]:eq('+i+')').parent('td'); mess="Boarding: Select Visit: Start Date";}
					else if($('input[name="checkoutb[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkoutb[]"]:eq('+i+')').parent('td'); mess="Boarding: Select Visit: End Date";}
					else if($('input[name="bamt[]"]:eq('+i+')').val()==''){errelm=$('input[name="bamt[]"]:eq('+i+')').parent('td'); mess="Boarding: Enter Amount";}	
					else if($('select[name="ticket_bo[]"]:eq('+i+')').val()== ''){errelm=$('select[name="ticket_bo[]"]:eq('+i+')').parent('td'); mess="Boarding: Select Ticket Id";}
					else if($('input[name="dprNum_bo[]"]:eq('+i+')').val()==''){errelm=$('input[name="dprNum_bo[]"]:eq('+i+')').parent('td'); mess="Boarding: Enter DPR Number";}
					else mess=1;
				}
			});
			
			/* Lodging */
			$('select[name="zone_ld[]"]').each(function(i,valuee){
				if($(this).val()!="0"){ 
					$('input[name="dprNum_l[]"]:eq('+i+')').removeClass('error');
					if($('select[name="state_ld[]"]:eq('+i+')').val()=== null){errelm=$('select[name="state_ld[]"]:eq('+i+')').parent('td'); mess="Lodging: Select State";}
					else if($('select[name="district_ld[]"]:eq('+i+')').val()=== null){errelm=$('select[name="district_ld[]"]:eq('+i+')').parent('td'); mess="Lodging: Select District";}
					else if($('input[name="checkin[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkin[]"]:eq('+i+')').parent('td'); mess="Lodging: Select Visit: Start Date";}
					else if($('input[name="checkout[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkout[]"]:eq('+i+')').parent('td'); mess="Lodging: Select Visit: End Date";}
					else if($('input[name="hotelName[]"]:eq('+i+')').val()==''){errelm=$('input[name="hotelName[]"]:eq('+i+')').parent('td'); mess="Lodging: Enter Hotel Name";}
					else if($('input[name="lamt[]"]:eq('+i+')').val()==''){errelm=$('input[name="lamt[]"]:eq('+i+')').parent('td'); mess="Lodging: Enter Amount";}
					else if($('select[name="ticket_idld[]"]:eq('+i+')').val()== ''){errelm=$('select[name="ticket_idld[]"]:eq('+i+')').parent('td'); mess="Lodging: Select Ticket Id";}
					else if($('input[name="dprNum_ld[]"]:eq('+i+')').val()==''){errelm=$('input[name="dprNum_ld[]"]:eq('+i+')').parent('td'); mess="Lodging: Enter DPR Number";}
					else mess=1;
				}
			});
			
			/* others */
			$('input[name="others[]"]').each(function(i,valuee){
				if($(this).val()!=""){
					$('input[name="dprNum_l[]"]:eq('+i+')').removeClass('error');
					if($('input[name="oamt[]"]:eq('+i+')').val()==''){errelm=$('input[name="oamt[]"]:eq('+i+')').parent('td');mess="Others: Enter Amount";}
					else if($('input[name="odate[]"]:eq('+i+')').val()==''){errelm=$('input[name="odate[]"]:eq('+i+')').parent('td');mess="Others: Select Date";}
					else if($('select[name="ticket_ot[]"]:eq('+i+')').val()==''){errelm=$('select[name="ticket_ot[]"]:eq('+i+')').parent('td');mess="Others: Select Ticket Id";}
					else if($('input[name="dprNum_ot[]"]:eq('+i+')').val()==''){errelm=$('input[name="dprNum_ot[]"]:eq('+i+')').parent('td');mess="Others: Enter DPR Number";}else mess=1;
				}
			});
		} else {alert(draftval);
			if(draftval != 1){ alert("archana");
					if(ValidateExtension()=="0"){
						errelm=$('.tplanningreport').parent('div');
						mess="Upload Tour Report(Only .pdf file allowed and size not exceeding 1MB)";
					}else mess=1;
			}
		}

	}else if($('input[name="ref"]').val()=="serEditExpense"){
		$('td').css('border', '1px solid #ddd'); 
		$('.form-group').css('border', '0px solid #fff'); 
		if($('input[name="visitFromDate"]').val()==""){errelm=$('input[name="visitFromDate"]').parent('div');mess="Enter Visit from Date";}
		else if($('input[name="visitToDate"]').val()==""){errelm=$('input[name="visitToDate"]').parent('div');mess="Enter Visit To Date";}
		else if($('input[name="placesOfVisit"]').val()==""){errelm=$('input[name="placesOfVisit"]').parent('div');mess="Enter Places of Visit";}
		else if($('.reasonForAdv').val()==""){errelm=$('.reasonForAdv').parent('div'); mess="Enter Purpose";}
		else if($('input[name="others[]"]:eq(0)').val()=="" &&  $('select[name="zone_ld[]"]:eq(0)').val()!="0" && $('input[name="dot_l[]"]:eq(0)').val()=="" && $('input[name="dot[]"]:eq(0)').val()==""){errelm=$(''); mess="Enter Atleast One Expense Details";}
				
				/* Local Conveyance */
				$('select[name="zone_l[]"]').each(function(i,valuee){
				 if($(this).val()!="0"){  
				 		 if($('select[name="state_l[]"]:eq('+i+')').val() != null){$('select[name="state_l[]"]:eq('+i+')').removeClass('error');}
						 if($('select[name="district_l[]"]:eq('+i+')').val() != null){$('select[name="district_l[]"]:eq('+i+')').removeClass('error'); }
						 if($('select[name="bucket[]"]:eq('+i+')').val() != null){$('select[name="bucket[]"]:eq('+i+')').removeClass('error'); }
						 if($('input[name="dot_l[]"]:eq('+i+')').val() != null){$('input[name="dot_l[]"]:eq('+i+')').removeClass('error');}
						 if($('select[name="mot_l[]"]:eq('+i+')').val()!= null){$('select[name="mot_l[]"]:eq('+i+')').removeClass('error'); }
						 if($('input[name="from_l[]"]:eq('+i+')').val() !=''){$('input[name="from_l[]"]:eq('+i+')').removeClass('error');}
						 if($('input[name="to_l[]"]:eq('+i+')').val() !=''){$('input[name="to_l[]"]:eq('+i+')').removeClass('error');}
						 if(($('input[name="amt_l[]"]:eq('+i+')').val()!='') && ($('input[name="amt_l[]"]:eq('+i+')').val()!='0')){$('input[name="amt_l[]"]:eq('+i+')').removeClass('error');}
						 if($('select[name="ticket_idl[]"]:eq('+i+')').val()== ''){ $('select[name="ticket_idl[]"]:eq('+i+')').siblings().find('.selectpicker').removeClass('error');}
						 if($('input[name="dprNum_l[]"]:eq('+i+')').val() !=''){$('input[name="dprNum_l[]"]:eq('+i+')').removeClass('error');}						

					if($('select[name="state_l[]"]:eq('+i+')').val()=== null){$('select[name="state_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Select State";}
					else if($('select[name="district_l[]"]:eq('+i+')').val()=== null){$('select[name="district_l[]"]:eq('+i+')').addClass('error'); mess="Local Conveyance: Select District";}
					else if($('select[name="bucket[]"]:eq('+i+')').val()=== null){$('select[name="bucket[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Select Bucket";}
					else if($('input[name="dot_l[]"]:eq('+i+')').val()== ''){$('input[name="dot_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Select Date of travel";}
					else if($('select[name="mot_l[]"]:eq('+i+')').val()=== null){$('select[name="mot_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Select Mode of travel";}
					else if($('input[name="from_l[]"]:eq('+i+')').val()==''){$('input[name="from_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Enter From place";}
					else if($('input[name="to_l[]"]:eq('+i+')').val()==''){$('input[name="to_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Enter To place";}					
					else if(($('input[name="amt_l[]"]:eq('+i+')').val()=='') || ($('input[name="amt_l[]"]:eq('+i+')').val()=='0')){$('input[name="amt_l[]"]:eq('+i+')').addClass('error'); mess="Local Conveyance: Enter Amount";}	
					else if($('select[name="ticket_idl[]"]:eq('+i+')').val()== ''){$('select[name="ticket_idl[]"]:eq('+i+')').siblings().find('.selectpicker').addClass('error');mess="Local Conveyance: Select Ticket Id";}
					else if($('input[name="dprNum_l[]"]:eq('+i+')').val()==''){$('input[name="dprNum_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Enter DPR Number";}
					else mess=1;
				}
			});

			/* Conveyance */
			$('input[name="dot[]"]').each(function(i,valuee){
				if($(this).val()!=""){
					$('input[name="dprNum_l[]"]:eq('+i+')').removeClass('error');
					if($('select[name="mot[]"]:eq('+i+')').val()=='0'){errelm=$('select[name="mot[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select Mode of travel";}
					else if($('input[name="from[]"]:eq('+i+')').val()==''){errelm=$('input[name="from[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select From place";}
					else if($('input[name="to[]"]:eq('+i+')').val()==''){errelm=$('input[name="to[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select To place";}
					else if($('input[name="amt[]"]:eq('+i+')').val()==''){errelm=$('input[name="amt[]"]:eq('+i+')').parent('td'); mess="Conveyance: Enter Amount";}
					else if($('select[name="cticket_id[]"]:eq('+i+')').val()== ''){errelm=$('select[name="cticket_id[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select Ticket Id";}
					else if($('input[name="cdprno[]"]:eq('+i+')').val()==''){errelm=$('input[name="cdprno[]"]:eq('+i+')').parent('td'); mess="Conveyance: Enter DPR Number";}
					else mess=1;
				}
			});
			
			/* boarding */
			$('select[name="zone_bo[]"]').each(function(i,valuee){ 
				if($(this).val()!="0"){ 
					$('input[name="dprNum_l[]"]:eq('+i+')').removeClass('error');
					if($('select[name="state_bo[]"]:eq('+i+')').val()=== null){errelm=$('select[name="state_bo[]"]:eq('+i+')').parent('td'); mess="Lodging: Select State";}
					else if($('select[name="district_bo[]"]:eq('+i+')').val()=== null){errelm=$('select[name="district_bo[]"]:eq('+i+')').parent('td'); mess="Lodging: Select District";}
					else if($('input[name="checkinb[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkinb[]"]:eq('+i+')').parent('td'); mess="Boarding: Select Visit: Start Date";}
					else if($('input[name="checkoutb[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkoutb[]"]:eq('+i+')').parent('td'); mess="Boarding: Select Visit: End Date";}
					else if($('input[name="bamt[]"]:eq('+i+')').val()==''){errelm=$('input[name="bamt[]"]:eq('+i+')').parent('td'); mess="Boarding: Enter Amount";}	
					else if($('select[name="ticket_bo[]"]:eq('+i+')').val()== ''){errelm=$('select[name="ticket_bo[]"]:eq('+i+')').parent('td'); mess="Boarding: Select Ticket Id";}
					else if($('input[name="dprNum_bo[]"]:eq('+i+')').val()==''){errelm=$('input[name="dprNum_bo[]"]:eq('+i+')').parent('td'); mess="Boarding: Enter DPR Number";}
					else mess=1;
				}
			});
			
			/* Lodging */
			$('select[name="zone_ld[]"]').each(function(i,valuee){
				if($(this).val()!="0"){ 
					$('input[name="dprNum_l[]"]:eq('+i+')').removeClass('error');
					if($('select[name="state_ld[]"]:eq('+i+')').val()=== null){errelm=$('select[name="state_ld[]"]:eq('+i+')').parent('td'); mess="Lodging: Select State";}
					else if($('select[name="district_ld[]"]:eq('+i+')').val()=== null){errelm=$('select[name="district_ld[]"]:eq('+i+')').parent('td'); mess="Lodging: Select District";}
					else if($('input[name="checkin[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkin[]"]:eq('+i+')').parent('td'); mess="Lodging: Select Visit: Start Date";}
					else if($('input[name="checkout[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkout[]"]:eq('+i+')').parent('td'); mess="Lodging: Select Visit: End Date";}
					else if($('input[name="hotelName[]"]:eq('+i+')').val()==''){errelm=$('input[name="hotelName[]"]:eq('+i+')').parent('td'); mess="Lodging: Enter Hotel Name";}
					else if($('input[name="lamt[]"]:eq('+i+')').val()==''){errelm=$('input[name="lamt[]"]:eq('+i+')').parent('td'); mess="Lodging: Enter Amount";}
					else if($('select[name="ticket_idld[]"]:eq('+i+')').val()== ''){errelm=$('select[name="ticket_idld[]"]:eq('+i+')').parent('td'); mess="Lodging: Select Ticket Id";}
					else if($('input[name="dprNum_ld[]"]:eq('+i+')').val()==''){errelm=$('input[name="dprNum_ld[]"]:eq('+i+')').parent('td'); mess="Lodging: Enter DPR Number";}
					else mess=1;
				}
			});
			
			/* others */
			$('input[name="others[]"]').each(function(i,valuee){
				if($(this).val()!=""){
					$('input[name="dprNum_l[]"]:eq('+i+')').removeClass('error');
					if($('input[name="oamt[]"]:eq('+i+')').val()==''){errelm=$('input[name="oamt[]"]:eq('+i+')').parent('td');mess="Others: Enter Amount";}
					else if($('input[name="odate[]"]:eq('+i+')').val()==''){errelm=$('input[name="odate[]"]:eq('+i+')').parent('td');mess="Others: Select Date";}
					else if($('select[name="ticket_ot[]"]:eq('+i+')').val()==''){errelm=$('select[name="ticket_ot[]"]:eq('+i+')').parent('td');mess="Others: Select Ticket Id";}
					else if($('input[name="dprNum_ot[]"]:eq('+i+')').val()==''){errelm=$('input[name="dprNum_ot[]"]:eq('+i+')').parent('td');mess="Others: Enter DPR Number";}else mess=1;
				}
			});
			
			
	}else mess=0;
	$(errelm).css('border', '2px solid red');
	return mess;
}
function ValidateExtension() {
        var allowedFiles = [".pdf"];
        var fileUpload = document.getElementById("tplanningreport");
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");

		if(!fileUpload.value) return '0';
		if(fileUpload.files[0].size > 1300000) return '0';
        if (!regex.test(fileUpload.value.toLowerCase())) return '0';
        return '1';
    }
</script>
<script type="text/javascript">
var snowmax=35
var snowcolor=new Array("#aaaacc","#ddddff","#ccccdd","#f3f3f3","#f0ffff")
var snowtype=new Array("Times","Arial","Times","Verdana")
var snowletter="*"
var sinkspeed=0.6
var snowmaxsize=30
var snowminsize=8
var snowingzone=1
var snow=new Array()
var marginbottom
var marginright
var timer
var i_snow=0
var x_mv=new Array();
var crds=new Array();
var lftrght=new Array();
var browserinfos=navigator.userAgent
var ie5=document.all&&document.getElementById&&!browserinfos.match(/Opera/)
var ns6=document.getElementById&&!document.all
var opera=browserinfos.match(/Opera/)
var browserok=ie5||ns6||opera

function randommaker(range) {
        rand=Math.floor(range*Math.random())
    return rand
}

function initsnow() {
        if (ie5 || opera) {
                marginbottom = document.body.scrollHeight
                marginright = document.body.clientWidth-15
        }
        else if (ns6) {
                marginbottom = document.body.scrollHeight
                marginright = window.innerWidth-15
        }
        var snowsizerange=snowmaxsize-snowminsize
        for (i=0;i<=snowmax;i++) {
                crds[i] = 0;
            lftrght[i] = Math.random()*15;
            x_mv[i] = 0.03 + Math.random()/10;
                snow[i]=document.getElementById("s"+i)
                snow[i].style.fontFamily=snowtype[randommaker(snowtype.length)]
                snow[i].size=randommaker(snowsizerange)+snowminsize
                snow[i].style.fontSize=snow[i].size+'px';
                snow[i].style.color=snowcolor[randommaker(snowcolor.length)]
                snow[i].style.zIndex=1000
                snow[i].sink=sinkspeed*snow[i].size/5
                if (snowingzone==1) {snow[i].posx=randommaker(marginright-snow[i].size)}
                if (snowingzone==2) {snow[i].posx=randommaker(marginright/2-snow[i].size)}
                if (snowingzone==3) {snow[i].posx=randommaker(marginright/2-snow[i].size)+marginright/4}
                if (snowingzone==4) {snow[i].posx=randommaker(marginright/2-snow[i].size)+marginright/2}
                snow[i].posy=randommaker(2*marginbottom-marginbottom-2*snow[i].size)
                snow[i].style.left=snow[i].posx+'px';
                snow[i].style.top=snow[i].posy+'px';
        }
        movesnow()
}

function movesnow() {
        for (i=0;i<=snowmax;i++) {
                crds[i] += x_mv[i];
                snow[i].posy+=snow[i].sink
                snow[i].style.left=snow[i].posx+lftrght[i]*Math.sin(crds[i])+'px';
                snow[i].style.top=snow[i].posy+'px';

                if (snow[i].posy>=marginbottom-2*snow[i].size || parseInt(snow[i].style.left)>(marginright-3*lftrght[i])){
                        if (snowingzone==1) {snow[i].posx=randommaker(marginright-snow[i].size)}
                        if (snowingzone==2) {snow[i].posx=randommaker(marginright/2-snow[i].size)}
                        if (snowingzone==3) {snow[i].posx=randommaker(marginright/2-snow[i].size)+marginright/4}
                        if (snowingzone==4) {snow[i].posx=randommaker(marginright/2-snow[i].size)+marginright/2}
                        snow[i].posy=0
                }
        }
        var timer=setTimeout("movesnow()",50)
}

for (i=0;i<=snowmax;i++) {
        document.write("<span id='s"+i+"' style='position:absolute;top:-"+snowmaxsize+"'>"+snowletter+"</span>")
}
if (browserok) {
        window.onload=initsnow
}
</script>
</body>
</html>
