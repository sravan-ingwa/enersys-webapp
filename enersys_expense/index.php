<?php 
include('lock.php');
include('functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Enersys Care</title>
<link rel="icon" href="img/favicon.png" type="image/png">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
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
<body role="document" >
<div id="loading">
	<div class="loadingBlock">
      <center><img src="img/ajax-loader.gif"><h3>Don't Refresh or Close the window</h3></center>
   </div>
</div>
<?php include('header.php'); ?>
<div class="container-fluid"><!-- Starting Of Body Container -->
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
			<div id="result"></div>
        </div>
    </div>
</div><!-- Closing Of Body Container -->
<!-- Closing Of Body Container -->
<script>
$(document).ready(function () {
    calloftheduty('dashboard');
});
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
		$('#'+fieldGet+ ' tr:last').find('.sel_empty select').html('<option value="">--Select--</option>');
		$('#'+fieldGet+ ' tr:last').find('td').css('border','1px solid rgb(221, 221, 221)');
		depDate();
		datepick();
		$('.tbform');
		$('.tbformm');
	});
	$(document).on('click','.addNewLoc',function(event){
		event.preventDefault();
		var fieldGet=$(this).attr('data-get');
		var numItems = $("#"+fieldGet).find('.localConv').children().last().attr("id");
		var num_split = numItems.split("_");
		var inc = parseInt(num_split[1])+parseInt(1);
		var result= $("#"+fieldGet).find('.localConv').children().last().html();
		var recRow = '<div id="localConv_'+inc+'" class="tbformm panel panel-default ajm">'+result+'</div>';
		$("#"+fieldGet).find('.localConv').append(recRow);
		$("#localConv_"+inc).find('.lclHide').addClass('hidden');
		$("#localConv_"+inc).find('.sel_empty select').html('<option value="">--Select--</option>');
		$('.selectpicker').selectpicker();
		$("#localConv_"+inc).find('.ticket_empty').children().last().remove();
		$("#localConv_"+inc).find('.ticket_empty1').children().last().remove();
		$("#localConv_"+inc).find('.panel-title').html('Local Conveyance '+inc);
		$("#localConv_"+inc).find('.form-group').children('select, input').css('border','1px solid rgb(221, 221, 221)');

		depDate();
		datepick();
	});
	
	$(document).on('click','.RemoveField',function(event){
		event.preventDefault();
		var fieldGet=$(this).attr('data-get');
		if($('#'+fieldGet+ ' tr').length!=1){$('#'+fieldGet+ ' tr:last').remove(); tamfor(); tamfor2();}
	});
	$(document).on('click','.RemoveLoc',function(event){
		event.preventDefault();
		var fieldGet=$(this).attr('data-get');
		var fieldcnt=$(this).attr('data-cnt');
		var numItems = $("#"+fieldGet).find('.localConv').children().last().attr("id");
		var num_split = numItems.split("_");
		var inc = parseInt(num_split[1]);
		if(inc != fieldcnt){$("#localConv_"+inc).remove(); tamfor();tamfor2(); }
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
	
<!--	$('.rowRemove').click(function(){$(this).parents('.ajm').remove();});
-->	
	$(document).on('click','.rowRemove',function(event){ //alert($(this).parents('.ajm').attr('class'));
		event.preventDefault();
		var r = confirm("Are you sure to Delete");
		var ref = $(this);
		if (r == true){
			$('#loading').css('display','block');
			$.ajax({
			url: "item.php",
			type: "POST",
			data: 'dRef='+$(this).attr('data-type')+'&dId='+$(this).attr('href')+'&sitem='+$(this).attr('sitem'),
			success: function(result){ 
				$('#loading').css('display','none');
				if(result.trim()=='1') { alert("Delete Successfull"); ref.parents('.ajm').remove();
				}else alert("Delete Unsuccessfull! Please Try Later");
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
						/*setTimeout(function(){
							$('#loading').css('display','none');
							if($('.referesh').attr('href').search("dvance")>='0'){calloftheduty("viewadvance");}
							else{calloftheduty("viewExpense");}
						},500);*/
					if($('.jerror').find('p').hasClass('alert-success')){  
						setTimeout(function(){
							$('#loading').css('display','none');
							if($('.referesh').attr('href').search("dvance")>='0'){calloftheduty("viewadvance");}
							else{calloftheduty("viewExpense");}
						},2000);
					}					
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
		//var draft = 1;
		chektoken=getvalidate();
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
				success: function(result) {// alert(result);
					$('#loading').css('display','none');
					$('#result').html(result).hide().fadeIn(500);
					if($('.jerror').find('p').hasClass('alert-success')){  
						setTimeout(function(){
							$('#loading').css('display','none');
							if($('.referesh').attr('href').search("dvance")>='0'){calloftheduty("viewadvance");}
							else{calloftheduty("viewExpense");}
						},2000);
					}					
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
	$('.datepickers').datepicker({format: 'dd-mm-yyyy'});
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
		else if($('input[name="others[]"]:eq(0)').val()=="" && $('select[name="typeofstay[]"]:eq(0)').val()=='0' &&  $('select[name="state[]"]:eq(0)').val()=='0' && $('input[name="dot_l[]"]:eq(0)').val()=="" && $('input[name="dot[]"]:eq(0)').val()==""){errelm=$(''); mess="Enter Atleast One Expense Details";}
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
			/*$('select[name="typeofstay[]"]').each(function(i,valuee){
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
			});*/
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
					else if($('.bhtname:eq('+i+')').val()=='' || $('.bhtname:eq('+i+')').val()=='0'){errelm=$('.bhtname:eq('+i+')').parent('td'); mess="Boarding: Select State";}
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
			
			if($('input[name="rem_amt"]').val()==""){errelm=$('.qntyy').parent('div'); mess="Enter Reimbursement";}		
		} 
	}else if($('input[name="ref"]').val()=="serEditExpense"){ 
		$('td').css('border', '1px solid #ddd'); 
		$('.form-group').css('border', '0px solid #fff'); 
		if($('input[name="visitFromDate"]').val()==""){ errelm=$('input[name="visitFromDate"]').parent('div');
		mess="Enter Visit from Date";}
		else if($('input[name="visitToDate"]').val()==""){errelm=$('input[name="visitToDate"]').parent('div');mess="Enter Visit To Date";}
		else if($('input[name="placesOfVisit"]').val()==""){errelm=$('input[name="placesOfVisit"]').parent('div');mess="Enter Places of Visit";}
		else if($('.reasonForAdv').val()==""){errelm=$('.reasonForAdv').parent('div'); mess="Enter Purpose";}
		else if($('input[name="others[]"]:eq(0)').val()=="" &&  $('select[name="zone_l[]"]:eq(0)').val()=="0" && $('input[name="checkinb[]"]:eq(0)').val()=="" && $('input[name="checkin[]"]:eq(0)').val()=="" && $('input[name="dot[]"]:eq(0)').val()==""){errelm=$(''); mess="Enter Atleast One Expense Details";}
		else{ 
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
						 if($('select[name="ticket_idl[]"]:eq('+i+')').val()!= ''){ $('select[name="ticket_idl[]"]:eq('+i+')').siblings().find('.selectpicker').removeClass('error');}
						 if($('input[name="dprNum_l[]"]:eq('+i+')').val() !=''){$('input[name="dprNum_l[]"]:eq('+i+')').removeClass('error');}						
						 if(($('input[name="amt_l[]"]:eq('+i+')').val()!='') && ($('input[name="amt_l[]"]:eq('+i+')').val()!='0')){$('input[name="amt_l[]"]:eq('+i+')').removeClass('error');}
					
					if($('select[name="state_l[]"]:eq('+i+')').val()=== null){$('select[name="state_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Select State";}
					else if($('select[name="district_l[]"]:eq('+i+')').val()=== null){$('select[name="district_l[]"]:eq('+i+')').addClass('error'); mess="Local Conveyance: Select District";}
					else if($('select[name="bucket[]"]:eq('+i+')').val()=== null){$('select[name="bucket[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Select Bucket";}
					else if($('select[name="bucket[]"]:eq('+i+')').val()!= null){
						
						 if($('input[name="dot_l[]"]:eq('+i+')').val() != null){$('input[name="dot_l[]"]:eq('+i+')').removeClass('error');}
						 if($('select[name="mot_l[]"]:eq('+i+')').val()!= null){$('select[name="mot_l[]"]:eq('+i+')').removeClass('error'); }
						 if($('input[name="from_l[]"]:eq('+i+')').val() !=''){$('input[name="from_l[]"]:eq('+i+')').removeClass('error');}
						 if($('input[name="to_l[]"]:eq('+i+')').val() !=''){$('input[name="to_l[]"]:eq('+i+')').removeClass('error');}
						 if($('select[name="ticket_idl[]"]:eq('+i+')').val()!= ''){ $('select[name="ticket_idl[]"]:eq('+i+')').siblings().find('.selectpicker').removeClass('error');}
						 if($('input[name="dprNum_l[]"]:eq('+i+')').val() !=''){$('input[name="dprNum_l[]"]:eq('+i+')').removeClass('error');}						
						 if(($('input[name="amt_l[]"]:eq('+i+')').val()!='') && ($('input[name="amt_l[]"]:eq('+i+')').val()!='0')){$('input[name="amt_l[]"]:eq('+i+')').removeClass('error');}
							if($('select[name="bucket[]"]:eq('+i+')').val()== "0"){ 
				 			
							 if($('select[name="cap[]"]:eq('+i+')').val() != ''){$('select[name="cap[]"]:eq('+i+')').removeClass('error');}
							 if($('input[name="numKilometers[]"]:eq('+i+')').val() !=''){$('input[name="numKilometers[]"]:eq('+i+')').removeClass('error');}
							 if($('input[name="quantityCell[]"]:eq('+i+')').val() !=''){$('input[name="quantityCell[]"]:eq('+i+')').removeClass('error');}

								if($('select[name="cap[]"]:eq('+i+')').val()==""){ 
									$('select[name="cap[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Select Capacity";
								}
								else if($('input[name="quantityCell[]"]:eq('+i+')').val()==''){$('input[name="quantityCell[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Enter Quantity";}
								else if($('input[name="numKilometers[]"]:eq('+i+')').val()==''){$('input[name="numKilometers[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Enter No.of Kilometers";}
								else if($('input[name="dot_l[]"]:eq('+i+')').val()== ''){$('input[name="dot_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Select Date of travel";}
								else if($('select[name="mot_l[]"]:eq('+i+')').val()=== null){$('select[name="mot_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Select Mode of travel";}
								else if($('input[name="from_l[]"]:eq('+i+')').val()==''){$('input[name="from_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Enter From place";}
								else if($('input[name="to_l[]"]:eq('+i+')').val()==''){$('input[name="to_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Enter To place";}					
								else if($('select[name="ticket_idl[]"]:eq('+i+')').val()== ''){$('select[name="ticket_idl[]"]:eq('+i+')').siblings().find('.selectpicker').addClass('error');mess="Local Conveyance: Select Ticket Id";}
								else if($('input[name="dprNum_l[]"]:eq('+i+')').val()==''){$('input[name="dprNum_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Enter DPR Number";}
								else if(($('input[name="amt_l[]"]:eq('+i+')').val()=='') || ($('input[name="amt_l[]"]:eq('+i+')').val()=='0')){$('input[name="amt_l[]"]:eq('+i+')').addClass('error'); mess="Local Conveyance: Enter Amount";}	
							else mess=1;
							} else {
								if($('input[name="dot_l[]"]:eq('+i+')').val()== ''){$('input[name="dot_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Select Date of travel";}
								else if($('select[name="mot_l[]"]:eq('+i+')').val()=== null){$('select[name="mot_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Select Mode of travel";}
								else if($('input[name="from_l[]"]:eq('+i+')').val()==''){$('input[name="from_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Enter From place";}
								else if($('input[name="to_l[]"]:eq('+i+')').val()==''){$('input[name="to_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Enter To place";}					
								else if($('select[name="ticket_idl[]"]:eq('+i+')').val()== ''){$('select[name="ticket_idl[]"]:eq('+i+')').siblings().find('.selectpicker').addClass('error');mess="Local Conveyance: Select Ticket Id";}
								else if($('input[name="dprNum_l[]"]:eq('+i+')').val()==''){$('input[name="dprNum_l[]"]:eq('+i+')').addClass('error');mess="Local Conveyance: Enter DPR Number";}
								else if(($('input[name="amt_l[]"]:eq('+i+')').val()=='') || ($('input[name="amt_l[]"]:eq('+i+')').val()=='0')){$('input[name="amt_l[]"]:eq('+i+')').addClass('error'); mess="Local Conveyance: Enter Amount";}	
							else mess=1;
							}
						}
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
					else if($('select[name="cticket_id[]"]:eq('+i+')').val()== ''){errelm=$('select[name="cticket_id[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select Ticket Id";}
					else if($('input[name="cdprno[]"]:eq('+i+')').val()==''){errelm=$('input[name="cdprno[]"]:eq('+i+')').parent('td'); mess="Conveyance: Enter DPR Number";}
					else if($('input[name="amt[]"]:eq('+i+')').val()==''){errelm=$('input[name="amt[]"]:eq('+i+')').parent('td'); mess="Conveyance: Enter Amount";}
					else mess=1;
				}
			});
			/* boarding */
			$('input[name="checkinb[]"]').each(function(i,valuee){
				if($(this).val()!=""){ 
					if($('input[name="checkoutb[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkoutb[]"]:eq('+i+')').parent('td'); mess="Boarding: Select Visit: End Date";}
					else if($('select[name="zone_bo[]"]:eq('+i+')').val()== "0"){errelm=$('select[name="zone_bo[]"]:eq('+i+')').parent('td'); mess="Boarding: Select Zone";}
					else if($('select[name="state_bo[]"]:eq('+i+')').val()=== null){errelm=$('select[name="state_bo[]"]:eq('+i+')').parent('td'); mess="Boarding: Select State";}
					else if($('select[name="district_bo[]"]:eq('+i+')').val()=== null){errelm=$('select[name="district_bo[]"]:eq('+i+')').parent('td'); mess="Boarding: Select District";}
					else if($('input[name="bamt[]"]:eq('+i+')').val()==''){errelm=$('input[name="bamt[]"]:eq('+i+')').parent('td'); mess="Boarding: Enter Amount";}	
					else if($('select[name="ticket_bo[]"]:eq('+i+')').val()== ''){errelm=$('select[name="ticket_bo[]"]:eq('+i+')').parent('td'); mess="Boarding: Select Ticket Id";}
					else if($('input[name="dprNum_bo[]"]:eq('+i+')').val()==''){errelm=$('input[name="dprNum_bo[]"]:eq('+i+')').parent('td'); mess="Boarding: Enter DPR Number";}
					else mess=1;
				}
			});
			/* others */
			$('input[name="others[]"]').each(function(i,valuee){
				if($(this).val()!=""){
					$('input[name="dprNum_l[]"]:eq('+i+')').removeClass('error');
					 if($('input[name="odate[]"]:eq('+i+')').val()==''){errelm=$('input[name="odate[]"]:eq('+i+')').parent('td');mess="Others: Select Date";}
					else if($('select[name="ticket_ot[]"]:eq('+i+')').val()==''){errelm=$('select[name="ticket_ot[]"]:eq('+i+')').parent('td');mess="Others: Select Ticket Id";}
					else if($('input[name="dprNum_ot[]"]:eq('+i+')').val()==''){errelm=$('input[name="dprNum_ot[]"]:eq('+i+')').parent('td');mess="Others: Enter DPR Number";}
					else if($('input[name="oamt[]"]:eq('+i+')').val()==''){errelm=$('input[name="oamt[]"]:eq('+i+')').parent('td');mess="Others: Enter Amount";}
					else mess=1;
				}
			});
		} 
		
		if($('input[name="rem_amt"]').val()==""){errelm=$('.qntyy').parent('div'); mess="Enter Reimbursement";}		
	
	}else mess=0;
	$(errelm).css('border', '2px solid red');
	return mess;
}
function getvalidate(){var mess; var errelm="";
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
		else if($('input[name="others[]"]:eq(0)').val()=="" && $('select[name="typeofstay[]"]:eq(0)').val()=='0' &&  $('select[name="state[]"]:eq(0)').val()=='0' && $('input[name="dot_l[]"]:eq(0)').val()=="" && $('input[name="dot[]"]:eq(0)').val()==""){errelm=$(''); mess="Enter Atleast One Expense Details";}
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
					else if($('.bhtname:eq('+i+')').val()=='' || $('.bhtname:eq('+i+')').val()=='0'){errelm=$('.bhtname:eq('+i+')').parent('td'); mess="Boarding: Select State";}
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
		else if($('input[name="others[]"]:eq(0)').val()=="" && $('select[name="typeofstay[]"]:eq(0)').val()=='0' &&  $('select[name="state[]"]:eq(0)').val()=='0' && $('input[name="dot_l[]"]:eq(0)').val()=="" && $('input[name="dot[]"]:eq(0)').val()==""){errelm=$(''); mess="Enter Atleast One Expense Details";}
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
					else if($('.bhtname:eq('+i+')').val()=='' || $('.bhtname:eq('+i+')').val()=='0'){errelm=$('.bhtname:eq('+i+')').parent('td'); mess="Boarding: Select State";}
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
		    var zonelArray=[],statelArray=[],districtlArray=[],bucketArray=[],ldotArray=[],lmotArray=[],lfromArray=[],ltoArray=[],lticketArray=[],ldprnoArray=[],lamtArray=[];
			var dotArray=[],motArray=[],fromArray=[],toArray=[],cticketArray=[],cdprnoArray=[],motbillArray=[],amtArray=[];
			var checkinArray=[],checkoutArray=[],zoneldArray=[],stateldArray=[],districtldArray=[],hotelArray=[],ldticketArray=[],lddprnoArray=[],ldamtArray=[];
			var checkinbArray=[],checkoutbArray=[],zonebdArray=[],statebdArray=[],districtbdArray=[],bdticketArray=[],bddprnoArray=[],bdamtArray=[];
			var othersArray=[],odateArray=[],ofileArray=[],oticketArray=[],odprnoArray=[],oamtArray=[];
		$('td').css('border', '1px solid #ddd'); 
		$('.form-group').css('border', '0px solid #fff'); 
		if($('input[name="visitFromDate"]').val()==""){ errelm=$('input[name="visitFromDate"]').parent('div');mess="Enter Visit from Date";}
		else if($('input[name="visitToDate"]').val()==""){errelm=$('input[name="visitToDate"]').parent('div');mess="Enter Visit To Date";}
		else if($('input[name="placesOfVisit"]').val()==""){errelm=$('input[name="placesOfVisit"]').parent('div');mess="Enter Places of Visit";}
		else if($('.reasonForAdv').val()==""){errelm=$('.reasonForAdv').parent('div'); mess="Enter Purpose";}
		else if($('.reasonForAdv1').val()==""){errelm=$('.reasonForAdv1').parent('div'); mess="Enter Remarks";}
		else if(($('input[name="fare_total_loc"]').val()=="") && ($('input[name="fare_total_con"]').val()=="")  && ($('input[name="fare_total_lod"]').val()=="") && ($('input[name="fare_total_bod"]').val()=="") && ($('input[name="fare_total_oth"]').val()=="")){errelm=$(''); mess="Enter Atleast One Expense Details. Expense amount is required";}
		else{mess=1;
			$('select[name="zone_l[]"]').each(function(i,valuee){
				if($(this).val() == "0"){zonelArray.push('');}else{zonelArray.push($(this).val());}
				if($('select[name="state_l[]"]:eq('+i+')').val()=='0') statelArray.push('');else statelArray.push($('select[name="state_l[]"]:eq('+i+')').val());
				if($('select[name="district_l[]"]:eq('+i+')').val()=='0') districtlArray.push('');else districtlArray.push($('select[name="district_l[]"]:eq('+i+')').val());
				if($('select[name="bucket[]"]:eq('+i+')').val()== "0"){ 
					 if($('select[name="cap[]"]:eq('+i+')').val()==""){mess="Local Conveyance: enter all fields";}
					 else if($('input[name="quantityCell[]"]:eq('+i+')').val()==''){mess="Local Conveyance: enter all fields";}
					 else if($('input[name="numKilometers[]"]:eq('+i+')').val()==''){mess="Local Conveyance: enter all fields";}
					 else {mess=1;}
				}
				bucketArray.push($('select[name="bucket[]"]:eq('+i+')').val());
				ldotArray.push($('input[name="dot_l[]"]:eq('+i+')').val());
				if($('select[name="mot_l[]"]:eq('+i+')').val()=='0') lmotArray.push('');else lmotArray.push($('select[name="mot_l[]"]:eq('+i+')').val());
				lfromArray.push($('input[name="from_l[]"]:eq('+i+')').val());
				ltoArray.push($('input[name="to_l[]"]:eq('+i+')').val());
				lticketArray.push($('select[name="ticket_idl[]"]:eq('+i+')').val());
				ldprnoArray.push($('input[name="dprNum_l[]"]:eq('+i+')').val());
				if($('input[name="amt_l[]"]:eq('+i+')').val()=='0') lamtArray.push('');else lamtArray.push($('input[name="amt_l[]"]:eq('+i+')').val());
				if(mess!=1){return false;}
			});
				
				if(mess==1){
					if(zonelArray.filter(String).length!=0 || statelArray.filter(String).length!=0 || districtlArray.filter(String).length!=0 || bucketArray.filter(String).length!=0 || ldotArray.filter(String).length!=0 || lmotArray.filter(String).length!=0 || lfromArray.filter(String).length!=0 || ltoArray.filter(String).length!=0 || lticketArray.filter(String).length!=0 || ldprnoArray.filter(String).length!=0 || lamtArray.filter(String).length!=0){
						if((zonelArray.length == zonelArray.filter(String).length) && (statelArray.length == statelArray.filter(String).length) && (districtlArray.length == districtlArray.filter(String).length) && (bucketArray.length == bucketArray.filter(String).length) && (ldotArray.length == ldotArray.filter(String).length) && (lmotArray.length == lmotArray.filter(String).length) && (lfromArray.length == lfromArray.filter(String).length)&& (ltoArray.length == ltoArray.filter(String).length)&& (lticketArray.length == lticketArray.filter(String).length) && (ldprnoArray.length == ldprnoArray.filter(String).length) && (lamtArray.length == lamtArray.filter(String).length)){
							mess=1;
						}else {mess="Local Conveyance: enter all fields";}
					}
				}
			
			if(mess==1){
			$('input[name="dot[]"]').each(function(i,valuee){
				dotArray.push($(this).val());
				if($('select[name="mot[]"]:eq('+i+')').val()=='0') motArray.push('');else motArray.push($('select[name="mot[]"]:eq('+i+')').val());
				fromArray.push($('input[name="from[]"]:eq('+i+')').val());
				toArray.push($('input[name="to[]"]:eq('+i+')').val());
				cticketArray.push($('select[name="cticket_id[]"]:eq('+i+')').val());
				cdprnoArray.push($('input[name="cdprno[]"]:eq('+i+')').val());
				motbillArray.push($('input[name="motbill[]"]:eq('+i+')').val());
				if($('input[name="amt[]"]:eq('+i+')').val()=='0') amtArray.push('');else amtArray.push($('input[name="amt[]"]:eq('+i+')').val());
			});
			if(dotArray.filter(String).length!=0 || motArray.filter(String).length!=0 || fromArray.filter(String).length!=0 || toArray.filter(String).length!=0 || cticketArray.filter(String).length!=0 || cdprnoArray.filter(String).length!=0 || motbillArray.filter(String).length!=0 || amtArray.filter(String).length!=0){
				if((dotArray.length == dotArray.filter(String).length) && (motArray.length == motArray.filter(String).length) && (fromArray.length == fromArray.filter(String).length) && (toArray.length == toArray.filter(String).length) && (cticketArray.length == cticketArray.filter(String).length) && (cdprnoArray.length == cdprnoArray.filter(String).length) && (motbillArray.length == motbillArray.filter(String).length)&& (amtArray.length == amtArray.filter(String).length)){
					mess=1;
				}else {mess="Conveyance: enter all fields";}
			}
			
			if(mess==1){
				$('input[name="checkin[]"]').each(function(i,valuee){
					checkinArray.push($(this).val());
					checkoutArray.push($('input[name="checkout[]"]:eq('+i+')').val());
					if($('select[name="zone_ld[]"]:eq('+i+')').val()=='0') zoneldArray.push('');else zoneldArray.push($('select[name="zone_ld[]"]:eq('+i+')').val());
					if($('select[name="state_ld[]"]:eq('+i+')').val()=='0') stateldArray.push('');else stateldArray.push($('select[name="state_ld[]"]:eq('+i+')').val());
					if($('select[name="district_ld[]"]:eq('+i+')').val()=='0') districtldArray.push('');else districtldArray.push($('select[name="district_ld[]"]:eq('+i+')').val());
					hotelArray.push($('input[name="hotelName[]"]:eq('+i+')').val());
					ldticketArray.push($('select[name="ticket_idld[]"]:eq('+i+')').val());
					lddprnoArray.push($('input[name="dprNum_ld[]"]:eq('+i+')').val());
					if($('input[name="lamt[]"]:eq('+i+')').val()=='0') ldamtArray.push('');else ldamtArray.push($('input[name="lamt[]"]:eq('+i+')').val());
				});
				
				if(checkinArray.filter(String).length!=0 || checkoutArray.filter(String).length!=0 || zoneldArray.filter(String).length!=0 || stateldArray.filter(String).length!=0 || districtldArray.filter(String).length!=0 || hotelArray.filter(String).length!=0 || ldticketArray.filter(String).length!=0 || lddprnoArray.filter(String).length!=0 || ldamtArray.filter(String).length!=0){
					if((checkinArray.length == checkinArray.filter(String).length) && (checkoutArray.length == checkoutArray.filter(String).length) && (zoneldArray.length == zoneldArray.filter(String).length) && (stateldArray.length == stateldArray.filter(String).length) && (districtldArray.length == districtldArray.filter(String).length) && (hotelArray.length == hotelArray.filter(String).length) && (ldticketArray.length == ldticketArray.filter(String).length) && (lddprnoArray.length == lddprnoArray.filter(String).length) && (ldamtArray.length == ldamtArray.filter(String).length)){
						mess=1;
					}else {mess="Lodging: enter all fields";}
				}
			
			if(mess==1){
				$('input[name="checkinb[]"]').each(function(i,valuee){
					checkinbArray.push($(this).val());
					checkoutbArray.push($('input[name="checkoutb[]"]:eq('+i+')').val());
					if($('select[name="zone_bo[]"]:eq('+i+')').val()=='0') zonebdArray.push('');else zonebdArray.push($('select[name="zone_bo[]"]:eq('+i+')').val());
					if($('select[name="state_bo[]"]:eq('+i+')').val()=='0') statebdArray.push('');else statebdArray.push($('select[name="state_bo[]"]:eq('+i+')').val());
					if($('select[name="district_bo[]"]:eq('+i+')').val()=='0') districtbdArray.push('');else districtbdArray.push($('select[name="district_bo[]"]:eq('+i+')').val());
					bdticketArray.push($('select[name="ticket_bo[]"]:eq('+i+')').val());
					bddprnoArray.push($('input[name="dprNum_bo[]"]:eq('+i+')').val());
					if($('input[name="bamt[]"]:eq('+i+')').val()=='0') bdamtArray.push('');else bdamtArray.push($('input[name="bamt[]"]:eq('+i+')').val());
				});
			
				if(checkinbArray.filter(String).length!=0 || checkoutbArray.filter(String).length!=0 || zonebdArray.filter(String).length!=0 || statebdArray.filter(String).length!=0 || districtbdArray.filter(String).length!=0 || bdticketArray.filter(String).length!=0 || bddprnoArray.filter(String).length!=0 || bdamtArray.filter(String).length!=0){
					if((checkinbArray.length == checkinbArray.filter(String).length) && (checkoutbArray.length == checkoutbArray.filter(String).length) && (zonebdArray.length == zonebdArray.filter(String).length) && (statebdArray.length == statebdArray.filter(String).length) && (districtbdArray.length == districtbdArray.filter(String).length) && (bdticketArray.length == bdticketArray.filter(String).length) && (bddprnoArray.length == bddprnoArray.filter(String).length) && (bdamtArray.length == bdamtArray.filter(String).length)){
						mess=1;
					}else {mess="Boarding: enter all fields";}
				}
			
			if(mess==1){
				
				var othersArray=[],odateArray=[],ofileArray=[],oticketArray=[],odprnoArray=[],oamtArray=[];
				
				$('input[name="others[]"]').each(function(i,valuee){
					othersArray.push($(this).val());
					odateArray.push($('input[name="odate[]"]:eq('+i+')').val());
					ofileArray.push($('input[name="ofile[]"]:eq('+i+')').val());
					oticketArray.push($('select[name="ticket_ot[]"]:eq('+i+')').val());
					odprnoArray.push($('input[name="dprNum_ot[]"]:eq('+i+')').val());
					if($('input[name="oamt[]"]:eq('+i+')').val()=='0') oamtArray.push('');else oamtArray.push($('input[name="oamt[]"]:eq('+i+')').val());
				});
			
				if(othersArray.filter(String).length!=0 || odateArray.filter(String).length!=0 || ofileArray.filter(String).length!=0 || oticketArray.filter(String).length!=0 || odprnoArray.filter(String).length!=0 || oamtArray.filter(String).length!=0){
					if((othersArray.length == othersArray.filter(String).length) && (odateArray.length == odateArray.filter(String).length) && (ofileArray.length == ofileArray.filter(String).length) && (oticketArray.length == oticketArray.filter(String).length) && (odprnoArray.length == odprnoArray.filter(String).length) && (oamtArray.length == oamtArray.filter(String).length)){
						mess=1;
					}else {mess="Others: enter all fields";}
				}
			}
			}
			}
			}
		} 
	}else if($('input[name="ref"]').val()=="serEditExpense"){ 
		$('td').css('border', '1px solid #ddd'); 
		$('.form-group').css('border', '0px solid #fff'); 
		if($('input[name="visitFromDate"]').val()==""){ errelm=$('input[name="visitFromDate"]').parent('div');
		mess="Enter Visit from Date";}
		else if($('input[name="visitToDate"]').val()==""){errelm=$('input[name="visitToDate"]').parent('div');mess="Enter Visit To Date";}
		else if($('input[name="placesOfVisit"]').val()==""){errelm=$('input[name="placesOfVisit"]').parent('div');mess="Enter Places of Visit";}
		else if($('.reasonForAdv').val()==""){errelm=$('.reasonForAdv').parent('div'); mess="Enter Purpose";}
		else if($('.reasonForAdv1').val()==""){errelm=$('.reasonForAdv1').parent('div'); mess="Enter Remarks";}
		else if($('input[name="others[]"]:eq(0)').val()=="" &&  $('select[name="zone_l[]"]:eq(0)').val()=="0" && $('input[name="checkinb[]"]:eq(0)').val()=="" && $('input[name="checkin[]"]:eq(0)').val()=="" && $('input[name="dot[]"]:eq(0)').val()==""){errelm=$(''); mess="Enter Atleast One Expense Details";}
		else{ 
			mess=1;var start=end=0;
			$('select[name="zone_l[]"]').each(function(i,valuee){
				 if($(this).val()!="0"){  start++;
				 		 if($('select[name="state_l[]"]:eq('+i+')').val() != "0"){$('select[name="state_l[]"]:eq('+i+')').removeClass('error');}
						 if($('select[name="district_l[]"]:eq('+i+')').val() != "0"){$('select[name="district_l[]"]:eq('+i+')').removeClass('error'); }
						 if($('select[name="bucket[]"]:eq('+i+')').val() != ""){$('select[name="bucket[]"]:eq('+i+')').removeClass('error'); }
						 if($('input[name="dot_l[]"]:eq('+i+')').val() != ""){$('input[name="dot_l[]"]:eq('+i+')').removeClass('error');}
						 if($('select[name="mot_l[]"]:eq('+i+')').val()!= "0"){$('select[name="mot_l[]"]:eq('+i+')').removeClass('error'); }
						 if($('input[name="from_l[]"]:eq('+i+')').val() !=''){$('input[name="from_l[]"]:eq('+i+')').removeClass('error');}
						 if($('input[name="to_l[]"]:eq('+i+')').val() !=''){$('input[name="to_l[]"]:eq('+i+')').removeClass('error');}
						 if($('select[name="ticket_idl[]"]:eq('+i+')').val()!= ''){ $('select[name="ticket_idl[]"]:eq('+i+')').siblings().find('.selectpicker').removeClass('error');}
						 if($('input[name="dprNum_l[]"]:eq('+i+')').val() !=''){$('input[name="dprNum_l[]"]:eq('+i+')').removeClass('error');}						
						 if(($('input[name="amt_l[]"]:eq('+i+')').val()!='') && ($('input[name="amt_l[]"]:eq('+i+')').val()!='0')){$('input[name="amt_l[]"]:eq('+i+')').removeClass('error');}
					
					if($('select[name="state_l[]"]:eq('+i+')').val()== "0"){$('select[name="state_l[]"]:eq('+i+')').addClass('error');$('select[name="state_l[]"]:eq('+i+')').removeAttr("style");
					mess="Local Conveyance: Select State";}
					else if($('select[name="district_l[]"]:eq('+i+')').val()== "0"){$('select[name="district_l[]"]:eq('+i+')').addClass('error'); $('select[name="district_l[]"]:eq('+i+')').removeAttr("style"); mess="Local Conveyance: Select District";}
					else if($('select[name="bucket[]"]:eq('+i+')').val()== ""){$('select[name="bucket[]"]:eq('+i+')').addClass('error'); $('select[name="bucket[]"]:eq('+i+')').removeAttr("style");mess="Local Conveyance: Select Bucket";}
					else if($('select[name="bucket[]"]:eq('+i+')').val()!= ""){
						 if($('input[name="dot_l[]"]:eq('+i+')').val() != ""){$('input[name="dot_l[]"]:eq('+i+')').removeClass('error');}
						 if($('select[name="mot_l[]"]:eq('+i+')').val()!= "0"){$('select[name="mot_l[]"]:eq('+i+')').removeClass('error'); }
						 if($('input[name="from_l[]"]:eq('+i+')').val() !=''){$('input[name="from_l[]"]:eq('+i+')').removeClass('error');}
						 if($('input[name="to_l[]"]:eq('+i+')').val() !=''){$('input[name="to_l[]"]:eq('+i+')').removeClass('error');}
						 if($('select[name="ticket_idl[]"]:eq('+i+')').val()!= ''){ $('select[name="ticket_idl[]"]:eq('+i+')').siblings().find('.selectpicker').removeClass('error');}
						 
						 if($('input[name="dprNum_l[]"]:eq('+i+')').val() !=''){$('input[name="dprNum_l[]"]:eq('+i+')').removeClass('error');}						
						 if(($('input[name="amt_l[]"]:eq('+i+')').val()!='') && ($('input[name="amt_l[]"]:eq('+i+')').val()!='0')){$('input[name="amt_l[]"]:eq('+i+')').removeClass('error');}

						 if($('select[name="bucket[]"]:eq('+i+')').val()== "0"){ 
				 			 if($('select[name="cap[]"]:eq('+i+')').val() != ''){$('select[name="cap[]"]:eq('+i+')').siblings().find('.selectpicker').removeClass('error');}
							 if($('input[name="quantityCell[]"]:eq('+i+')').val() !=''){$('input[name="quantityCell[]"]:eq('+i+')').removeClass('error');}
							 if($('input[name="numKilometers[]"]:eq('+i+')').val() !=''){$('input[name="numKilometers[]"]:eq('+i+')').removeClass('error');}
								if($('select[name="cap[]"]:eq('+i+')').val()==""){$('select[name="cap[]"]:eq('+i+')').siblings().find('.selectpicker').addClass('error');mess="Local Conveyance: Select Capacity";}
								else if($('input[name="quantityCell[]"]:eq('+i+')').val()==''){$('input[name="quantityCell[]"]:eq('+i+')').addClass('error');$('input[name="quantityCell[]"]:eq('+i+')').removeAttr("style");mess="Local Conveyance: Enter Quantity";}
								else if($('input[name="numKilometers[]"]:eq('+i+')').val()==''){$('input[name="numKilometers[]"]:eq('+i+')').addClass('error'); $('input[name="numKilometers[]"]:eq('+i+')').removeAttr("style");mess="Local Conveyance: Enter No.of Kilometers";}
								else if($('input[name="dot_l[]"]:eq('+i+')').val()== ''){$('input[name="dot_l[]"]:eq('+i+')').addClass('error');$('input[name="dot_l[]"]:eq('+i+')').removeAttr("style");mess="Local Conveyance: Select Date of travel";}
								else if($('select[name="mot_l[]"]:eq('+i+')').val()== "0"){$('select[name="mot_l[]"]:eq('+i+')').addClass('error');$('select[name="mot_l[]"]:eq('+i+')').removeAttr("style");mess="Local Conveyance: Select Mode of travel";}
								else if($('input[name="from_l[]"]:eq('+i+')').val()==''){$('input[name="from_l[]"]:eq('+i+')').addClass('error');$('input[name="from_l[]"]:eq('+i+')').removeAttr("style");mess="Local Conveyance: Enter From place";}
								else if($('input[name="to_l[]"]:eq('+i+')').val()==''){$('input[name="to_l[]"]:eq('+i+')').addClass('error');$('input[name="to_l[]"]:eq('+i+')').removeAttr("style");mess="Local Conveyance: Enter To place";}					
								else if($('select[name="ticket_idl[]"]:eq('+i+')').val()== ''){$('select[name="ticket_idl[]"]:eq('+i+')').siblings().find('.selectpicker').addClass('error');$('select[name="ticket_idl[]"]:eq('+i+')').siblings().find('.selectpicker').removeAttr("style");mess="Local Conveyance: Select Ticket Id";}
								else if($('input[name="dprNum_l[]"]:eq('+i+')').val()==''){$('input[name="dprNum_l[]"]:eq('+i+')').addClass('error');$('input[name="dprNum_l[]"]:eq('+i+')').removeAttr("style");mess="Local Conveyance: Enter DPR Number";}
								else if(($('input[name="amt_l[]"]:eq('+i+')').val()=='') || ($('input[name="amt_l[]"]:eq('+i+')').val()=='0')){$('input[name="amt_l[]"]:eq('+i+')').addClass('error'); $('input[name="amt_l[]"]:eq('+i+')').removeAttr("style");mess="Local Conveyance: Enter Amount";}	
							 else {end++; mess=1;}
							} else {
								if($('input[name="dot_l[]"]:eq('+i+')').val()== ''){$('input[name="dot_l[]"]:eq('+i+')').addClass('error');$('input[name="dot_l[]"]:eq('+i+')').removeAttr("style");mess="Local Conveyance: Select Date of travel";}
								else if($('select[name="mot_l[]"]:eq('+i+')').val()== "0"){$('select[name="mot_l[]"]:eq('+i+')').addClass('error');$('select[name="mot_l[]"]:eq('+i+')').removeAttr("style");mess="Local Conveyance: Select Mode of travel";}
								else if($('input[name="from_l[]"]:eq('+i+')').val()==''){$('input[name="from_l[]"]:eq('+i+')').addClass('error');$('input[name="from_l[]"]:eq('+i+')').removeAttr("style");mess="Local Conveyance: Enter From place";}
								else if($('input[name="to_l[]"]:eq('+i+')').val()==''){$('input[name="to_l[]"]:eq('+i+')').addClass('error');$('input[name="to_l[]"]:eq('+i+')').removeAttr("style");mess="Local Conveyance: Enter To place";}					
								else if($('select[name="ticket_idl[]"]:eq('+i+')').val()== ''){$('select[name="ticket_idl[]"]:eq('+i+')').siblings().find('.selectpicker').addClass('error');$('select[name="ticket_idl[]"]:eq('+i+')').siblings().find('.selectpicker').removeAttr("style");mess="Local Conveyance: Select Ticket Id";}
								else if($('input[name="dprNum_l[]"]:eq('+i+')').val()==''){$('input[name="dprNum_l[]"]:eq('+i+')').addClass('error');$('input[name="dprNum_l[]"]:eq('+i+')').removeAttr("style");mess="Local Conveyance: Enter DPR Number";}
								else if(($('input[name="amt_l[]"]:eq('+i+')').val()=='') || ($('input[name="amt_l[]"]:eq('+i+')').val()=='0')){$('input[name="amt_l[]"]:eq('+i+')').addClass('error'); $('input[name="amt_l[]"]:eq('+i+')').removeAttr("style");mess="Local Conveyance: Enter Amount";}	
							 else {end++; mess=1;}
							}
						}
							 else {end++; mess=1;}
					if(mess!=1){return false;}
				}
			});
		if(start==end){start=end=0;
            /* Conveyance */
			$('input[name="dot[]"]').each(function(i,valuee){
				if($(this).val()!=""){start++;
					if($('select[name="mot[]"]:eq('+i+')').val()=='0'){errelm=$('select[name="mot[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select Mode of travel";}
					else if($('input[name="from[]"]:eq('+i+')').val()==''){errelm=$('input[name="from[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select From place"; }
					else if($('input[name="to[]"]:eq('+i+')').val()==''){errelm=$('input[name="to[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select To place"; }
					else if($('select[name="cticket_id[]"]:eq('+i+')').val()== ''){errelm=$('select[name="cticket_id[]"]:eq('+i+')').parent('td'); mess="Conveyance: Select Ticket Id"; }
					else if($('input[name="cdprno[]"]:eq('+i+')').val()==''){errelm=$('input[name="cdprno[]"]:eq('+i+')').parent('td'); mess="Conveyance: Enter DPR Number"; }
					else if($('input[name="motbill_old[]"]:eq('+i+')').length==0 && $('input[name="motbill[]"]:eq('+i+')').val()==''){errelm=$('input[name="motbill[]"]:eq('+i+')').parent('td');mess="Conveyance: Select File"; }					
					else if(($('input[name="amt[]"]:eq('+i+')').val()=='') || ($('input[name="amt[]"]:eq('+i+')').val()=='0') ){errelm=$('input[name="amt[]"]:eq('+i+')').parent('td'); mess="Conveyance: Enter Amount"; return false;}
							 else {end++; mess=1;}
					if(mess!=1){return false;}
				}
			});
		if(start==end){start=end=0;
			/* Lodging */
			$('input[name="checkin[]"]').each(function(i,valuee){
				if($(this).val()!=""){start++;
					if($('input[name="checkout[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkout[]"]:eq('+i+')').parent('td'); mess="Lodging: Select Check Out Date";}
					else if($('select[name="zone_ld[]"]:eq('+i+')').val()== "0"){errelm=$('select[name="zone_ld[]"]:eq('+i+')').parent('td'); mess="Lodging: Select Zone";}
					else if($('select[name="state_ld[]"]:eq('+i+')').val()== "0"){errelm=$('select[name="state_ld[]"]:eq('+i+')').parent('td'); mess="Lodging: Select State";}
					else if($('select[name="district_ld[]"]:eq('+i+')').val()== "0"){errelm=$('select[name="district_ld[]"]:eq('+i+')').parent('td'); mess="Lodging: Select District";}
					else if($('input[name="hotelName[]"]:eq('+i+')').val()==''){errelm=$('input[name="hotelName[]"]:eq('+i+')').parent('td'); mess="Lodging: Enter Hotel Name";}
					else if($('select[name="ticket_idld[]"]:eq('+i+')').val()== ''){errelm=$('select[name="ticket_idld[]"]:eq('+i+')').parent('td'); mess="Lodging: Select Ticket Id";}
					else if($('input[name="dprNum_ld[]"]:eq('+i+')').val()==''){errelm=$('input[name="dprNum_ld[]"]:eq('+i+')').parent('td'); mess="Lodging: Enter DPR Number";}
					else if(($('input[name="lamt[]"]:eq('+i+')').val()=='') || ($('input[name="lamt[]"]:eq('+i+')').val()=='0')){errelm=$('input[name="lamt[]"]:eq('+i+')').parent('td'); mess="Lodging: Enter Amount";}
							 else {end++; mess=1;}
					if(mess!=1){return false;}
				}
			});
		if(start==end){start=end=0;
			/* boarding */
			$('input[name="checkinb[]"]').each(function(i,valuee){
				if($(this).val()!=""){ start++;
					if($('input[name="checkoutb[]"]:eq('+i+')').val()==''){errelm=$('input[name="checkoutb[]"]:eq('+i+')').parent('td'); mess="Boarding: Select Visit: End Date";}
					else if($('select[name="zone_bo[]"]:eq('+i+')').val()== "0"){errelm=$('select[name="zone_bo[]"]:eq('+i+')').parent('td'); mess="Boarding: Select Zone";}
					else if($('select[name="state_bo[]"]:eq('+i+')').val()== "0"){errelm=$('select[name="state_bo[]"]:eq('+i+')').parent('td'); mess="Boarding: Select State";}
					else if($('select[name="district_bo[]"]:eq('+i+')').val()== "0"){errelm=$('select[name="district_bo[]"]:eq('+i+')').parent('td'); mess="Boarding: Select District";}
					else if($('select[name="ticket_bo[]"]:eq('+i+')').val()== ''){errelm=$('select[name="ticket_bo[]"]:eq('+i+')').parent('td'); mess="Boarding: Select Ticket Id";}
					else if($('input[name="dprNum_bo[]"]:eq('+i+')').val()==''){errelm=$('input[name="dprNum_bo[]"]:eq('+i+')').parent('td'); mess="Boarding: Enter DPR Number";}
					else if(($('input[name="bamt[]"]:eq('+i+')').val()=='') || ($('input[name="bamt[]"]:eq('+i+')').val()=='0')){errelm=$('input[name="bamt[]"]:eq('+i+')').parent('td'); mess="Boarding: Enter Amount";}	
							 else {end++; mess=1;}
					if(mess!=1){return false;}
				}
			});	
		if(start==end){start=end=0;
			/* others */
			$('input[name="others[]"]').each(function(i,valuee){
				if($(this).val()!=""){start++;
					if($('input[name="odate[]"]:eq('+i+')').val()==''){errelm=$('input[name="odate[]"]:eq('+i+')').parent('td');mess="Others: Select Date";}
					else if($('input[name="ofile_old[]"]:eq('+i+')').length==0 && $('input[name="ofile[]"]:eq('+i+')').val()==''){errelm=$('input[name="ofile[]"]:eq('+i+')').parent('td');mess="Others: Select File"; }
					else if($('select[name="ticket_ot[]"]:eq('+i+')').val()==''){errelm=$('select[name="ticket_ot[]"]:eq('+i+')').parent('td');mess="Others: Select Ticket Id";}
					else if($('input[name="dprNum_ot[]"]:eq('+i+')').val()==''){errelm=$('input[name="dprNum_ot[]"]:eq('+i+')').parent('td');mess="Others: Enter DPR Number";}
					else if(($('input[name="oamt[]"]:eq('+i+')').val()=='') || ($('input[name="oamt[]"]:eq('+i+')').val()=='0')){errelm=$('input[name="oamt[]"]:eq('+i+')').parent('td');mess="Others: Enter Amount";}
							 else {end++; mess=1;}
					if(mess!=1){return false;}
				}
			});	
			}
			}
			}
		}
		} 

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
	
function FormatDate(val) {
    var tmpDate = val.split("-");
    var DD = tmpDate[0];
    var MM = tmpDate[1];
    var YYYY = tmpDate[2];
    var fDate = new Date(MM + "/" + DD + "/" + YYYY);
    return fDate;
}

function jm_array_filter(oldArray) {
 var cleanArray = [];var element;
	for( element in oldArray){
		if(oldArray[element]!=undefined){cleanArray.push(oldArray[element]);}
	}
	return cleanArray;
}
</script>

</body>
</html>
