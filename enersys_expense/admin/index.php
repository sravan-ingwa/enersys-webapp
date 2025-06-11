<?php 
include('lock.php');
include('functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Enersys Care</title>
<link rel="icon" href="../img/favicon.png" type="image/png">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link href="../css/bootstrap.css" rel="stylesheet">
<link href="../css/main.css" rel="stylesheet">
<link href="../css/datepicker.css" rel="stylesheet">
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap-datepicker.js"></script>
<script src="../js/jquery.form.js"></script>
<link rel="stylesheet" href="../css/prettify.css" type="text/css">
<link rel="stylesheet" href="../css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="../js/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="../js/prettify.js"></script>
<link rel="stylesheet" href="../css/bootstrap-select.css" type="text/css">
<script type="text/javascript" src="../js/bootstrap-select.js"></script>

</head>
<body role="document" onLoad="calloftheduty('listemployee');">
<div id="loading">
	<div class="loadingBlock">
      <center><img src="../img/ajax-loader.gif"><h3>Don't Refresh or Close the window</h3></center>
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
<script src="../js/bootstrap-confirmation.js"></script>
<script>
$(document).ready(function(){
$('.nav li a.itemNav').on('click', function(event) {
		event.preventDefault();
		calloftheduty($(this).attr('href'));
		var act=$(this).attr('data-active');
		$('.navbar-nav li').removeClass('active');
		$("."+act).addClass('active');
	});
	$(document).on('keyup','.amtt',function (e){if(isNaN($(this).val())){$(this).val("");}});
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
		$("#localConv_"+inc).find('.lclHide').removeClass('hidden');
		$("#localConv_"+inc).find('.sel_empty select').html('<option value="">--Select--</option>');
		$('.selectpicker').selectpicker();
		$("#localConv_"+inc).find('.ticket_empty').children().last().remove();
		$("#localConv_"+inc).find('.panel-title').html('Local Conveyance '+inc);
		$("#localConv_"+inc).find('.form-group').children('select, input').css('border','1px solid rgb(221, 221, 221)');
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
				//$('.referesh').attr('href',ref);
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
	$(document).on('click','.ademp',function (event){
		event.preventDefault();
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
			//alert(result);
				$('#result').html(result).hide().fadeIn(500);
				datepick();
			}
		});
	});
	

	$(document).on('click','.edis',function (event){
		event.preventDefault();
		var ref=$(this).attr('data-type');
		$('#loading').css('display','block');
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
	$(document).on('click','.exportx',function (event){
		event.preventDefault();
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
	});
	$(document).on('click','.updatex',function (event){
		event.preventDefault();
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
				datepick();
			}
		});
	});
	$(document).on('change','.showAutofill',function (event){var targetx=$(this).attr('data-target');$('.'+targetx).val($(this).children('option:selected').attr('data-grade'));});
	$(document).on('change','.showgradedesg',function (event){
		$.ajax({
			url: "item.php",
			type: "POST",
			data: 'gradedesg='+encodeURIComponent($(this).val()),
			cache:false,
			success: function(result) {
				$('#desglist').html(result).hide().fadeIn(500);
			}
		});
	});
	$(document).on('focusout','.empiid',function (event){
		$.ajax({
			url: "item.php",
			type: "POST",
			data: 'empiid='+encodeURIComponent($(this).val()),
			cache:false,
			success: function(result) {
				$('.iderror').html(result.trim());
			}
		});
	});
	$(document).on('change','.showempbydep',function (event){
		$.ajax({
			url: "item.php",
			type: "POST",
			data: 'empbydep='+encodeURIComponent($(this).val()),
			cache:false,
			success: function(result) {
				$('#mot1').html(result).hide().fadeIn(500);
				window.prettyPrint() && prettyPrint();//$('#mot2').multiselect({includeSelectAllOption: true});
			}
		});
	});
});
function calloftheduty(ref){
$('#loading').css('display','block');
	$.ajax({
		url : 'item.php',
		data: 'ref='+encodeURIComponent(ref),
		type:'post',
		cache:false,
		success: function(res){
		$('#loading').css('display','none');
			$('#result').html(res).hide().fadeIn(500);
			$('.referesh').attr('href',ref);
			$('.form-control').each(function(){$(this).val($(this).val().trim());});
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
		}
	});
}

function serlistdetailsfun(){
$('#loading').css('display','block');
	$.ajax({
		type: "GET",
		url: "include/getdetails.php",
		data: $("#sortform").serialize(),
		cache: true,
		success: function(result){
			
			//alert();
		$('#loading').css('display','none');
			result=result.split("##");
			$('#getList').html(result[0]);
//			$('#totalcount').val(result[1]);
//			$('#pagx').html(result[2]);
		}
	});
}

function datepick(){
	var nowTemp = new Date();var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
	$('.datepicker').datepicker({format: 'dd-mm-yyyy',onRender: function(date){return date.valueOf() > now.valueOf() ? 'disabled' : '';}});
}
</script>
</body>
</html>
