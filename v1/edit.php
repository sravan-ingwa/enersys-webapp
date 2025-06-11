<?php include('lock.php'); include('functions.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php TitleFav();?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/autoComplete.css" />
<link href="css/autoFill.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datetimepicker.min.css" />
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body role="document">
<?php include('header.php'); 
$loginRole=loginDetails($_SESSION['login_user'],"role");
if(!isset($_REQUEST['x'])){
	$query = mysql_query("SELECT * FROM ss_user_role  
	JOIN ss_menu ON ss_user_role.privilageItem=ss_menu.id
	WHERE ss_user_role.privilageType='View' AND  ss_user_role.grantable='Yes' ORDER BY ss_menu.ordering");
	$row=mysql_fetch_array($query);
	if($row)echo "<script type='text/javascript'>window.location='index.php?x=$row[id]'</script>";
	else echo"<script type='text/javascript'>window.location='logout.php?ref=noview'</script>";
}
if(!serviceAccess($loginRole,$_REQUEST['x'],'Edit')){
	$query = mysql_query("SELECT * FROM ss_user_role  
	JOIN ss_menu ON ss_user_role.privilageItem=ss_menu.id
	WHERE ss_user_role.privilageType='Edit' AND  ss_user_role.grantable='Yes' ORDER BY ss_menu.ordering");
	$row=mysql_fetch_array($query);
	if($row)echo "<script type='text/javascript'>window.location='index.php?x=$row[id]'</script>";
	else echo"<script type='text/javascript'>window.location='logout.php?ref=noview'</script>";
}
?>
<div class="container-fluid"><!-- Starting Of Body Container -->
    <div class="row">
        <div class="col-sm-1 hidden-xs"></div>
        	<div class="col-xs-12 col-sm-10">
            	<div class="panel panel-primary">
                	<div class="panel-heading">
                    	<h3 class="panel-title">Edit <?php echo menuName($_REQUEST['x'],"menu"); ?></h3>
                    </div>
                	<div class="panel-body">
						<?php
						$ref=$_REQUEST['x'];
						$query=mysql_query("SELECT * FROM ss_menu  WHERE id='$ref'");
						if(mysql_num_rows($query)>0){
							$row=mysql_fetch_array($query);
							include('include/'.$row['tbName'].'_edit.php');
						}
						?>
                	</div>
            	</div>
        	</div><!-- Closing Of col-xs-12 -->
    	<div class="col-sm-1 hidden-xs"></div>
    </div>
</div><!-- Closing Of Body Container -->
	<script type="text/javascript" src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.autocomplete.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.2.custom.min.js"></script>
	<script type="text/javascript" src="js/moment.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>
    <script>
    function smpsdisplay(fv1){
    if(fv1==='Not Working'){$("#boostvoltage").removeClass("boostvoltage");$("#lvdsetting").removeClass("lvdsetting");}
    else{$("#boostvoltage").addClass("boostvoltage");$("#lvdsetting").addClass("lvdsetting");}
    }
    </script>
    <script src="js/bootstrapValidator.min.js"></script>
    <script src="js/validation.js"></script>
	<script>
		$('.tooltips').tooltip();
        $(document).ready(function(){
            var arr = [ "all", "create", "view", "edit", "delete", "xport", "special" ];
            $.each( arr, function( i, val ) {
            $('#uncheck_'+val).click(function(){$('.'+val).prop('checked', false);});
            $('#check_'+val).click(function(){$('.'+val).prop('checked', true);});
            });
        });
    </script>

<script type="text/javascript">
function ajaxSelect(id, type) {
    if (id != "") {
		if(type.search(",") == "-1"){
			$.ajax({
				type: "POST",
				url: "ajaxSelect.php",
				data: 'type=' + type + '&id=' + id,
				cache: false,
				success: function(result) {
					$("#ajaxSelect_" + type).html(result);
				}
			});
		}
		else{
			var temp = new Array();
			temp = type.split(",");
			var x;
			for(x in temp){multipleAjaxSelect(temp[x],id);}
			function multipleAjaxSelect(mtype,mid){
				$.ajax({ 
						type: "POST",
						url: "ajaxSelect.php",
						data: 'type=' + mtype + '&id=' + mid,
						cache: false,
						success: function(result){$("#ajaxSelect_" +mtype).html(result);}
					});
			}
		}
    }
    if (type == "Circle") {
        $("#ajaxSelect_Circle").html("<option value='' disabled='disabled'>Select Circle</option>");
        $("#ajaxSelect_Cluster").html("<option value='' disabled='disabled'>Select Cluster</option>");
        $("#ajaxSelect_District").html("<option value='' disabled='disabled'>Select District</option>")
		$("#ajaxSelect_serviceEngineer").html("<option value='' disabled='disabled'>Select Service Engineer</option>")
		$("#ajaxSelect_regionalManager").html("<option value='' disabled='disabled'>Select Regional Manager</option>")
    }
    if (type == "Cluster") {
        $("#ajaxSelect_Cluster").html("<option value='' disabled='disabled'>Select Cluster</option>");
        $("#ajaxSelect_District").html("<option value='' disabled='disabled'>Select District</option>")
		$("#ajaxSelect_serviceEngineer").html("<option value='' disabled='disabled'>Select Service Engineer</option>")
		$("#ajaxSelect_regionalManager").html("<option value='' disabled='disabled'>Select Regional Manager</option>")
    }
    if (type == "District") {
        $("#ajaxSelect_District").html("<option value='' disabled='disabled'>Select District</option>")
    }
    if (type == "CustomerName") {
        $("#ajaxSelect_CustomerName").html("<option value='' disabled='disabled'>Select Customer</option>")
    }
}
</script>
<script type="text/javascript">
function ajaxText(id,type){
	if(id!=""){
		var links='type='+type+'&id='+id+'&ref=ajax';
		$.ajax({
			type: "POST",
			url: "ajaxText.php",
			data: links,
			cache: false,
			success: function(result){
				switch(type){
					case 'District':$("#ajaxText_"+type).html("<option value='' disabled='disabled'>Select Base Location</option>"); $("#ajaxText_"+type).append(result);break;
					default:$("#ajaxText_"+type).autocomplete('ajaxText.php?result='+result+'&type='+type+'&ref=autocomplete', {selectFirst: true});
					}
			   }
		});
	}
	if(type=="Circle"){document.getElementById("ajaxText_Circle").value = "";document.getElementById("ajaxText_Cluster").value = "";$("#ajaxText_District").html("<option value='' disabled='disabled'>Select Base Location</option>");}if(type=="Cluster"){document.getElementById("ajaxText_Cluster").value = "";$("#ajaxText_District").html("<option value='' disabled='disabled'>Select Base Location</option>");}if(type=="District"){$("#ajaxText_District").html("<option value='' disabled='disabled'>Select Base Location</option>");}	
}
</script>
	<script type="text/javascript">
    function ajaxfit(id,type,tbna){var date="";
        if(tbna=='prwarr'){id=document.getElementById('ajaxSelect_CustomerName').value;date=document.getElementById('installDate').value;}
        if(id!=""){
            var links='type='+type+'&id='+id+'&tbna='+tbna+'&date='+date;
            $.ajax({
                type: "POST",
                url: "ajaxfit.php",
                data: links,
                cache: false,
                success: function(result){ //alert(result);
					if(type=='warranty'){
						today=new Date();
						var mf = document.getElementById("mfdDate").value;
						var ins = document.getElementById("installDate").value;
						var d = new Date(mf);
						/*var mfdMon=d.getMonth();var mfdDay=d.getDate();*/	var abc = Math.round((today.getTime()-d.getTime())/2592000000);
						var di = new Date(ins);
						/*var instMon=di.getMonth();var instDay=di.getDate();*/	var def = Math.round((today.getTime()-di.getTime())/2592000000);
						var xyz = result.split(",");
						if(isNaN(abc)){ abc=0; }if(isNaN(def)){ def=0; }
						var disp = xyz[0].trim(); var dispCal = disp-abc;
						var inst = xyz[1].trim(); var instCal = inst-def;
						if(mf=='' && ins==''){
							if((disp <= inst)){$("#ajaxSelect_"+type).val(disp);}
							else{$("#ajaxSelect_"+type).val(inst);}
							$("#ajaxSelect_warrantyLeft").val('Not Given');		
							$("#siteStatus").val("Not Given");
							document.getElementById("siteStatus").options[3].setAttribute("selected", "selected");
							}
						else if((dispCal <= 0) || (instCal <= 0)){
							if((dispCal) < (instCal)){ $("#ajaxSelect_"+type).val(disp);}
							else{$("#ajaxSelect_"+type).val(inst);}
							$("#ajaxSelect_warrantyLeft").val("Out Of Warranty");			
							$("#siteStatus").val("OutOfWarranty");		
							document.getElementById("siteStatus").options[2].setAttribute("selected", "selected");
							}
						else if(dispCal > instCal){
							$("#ajaxSelect_"+type).val(inst);
							$("#ajaxSelect_warrantyLeft").val(instCal+" Months");
							$("#siteStatus").val("Warranty");
							document.getElementById("siteStatus").options[1].setAttribute("selected", "selected");
							}
						else if(dispCal < instCal){
							$("#ajaxSelect_"+type).val(disp);
							$("#ajaxSelect_warrantyLeft").val(dispCal+" Months");	
							$("#siteStatus").val("Warranty");	
							document.getElementById("siteStatus").options[1].setAttribute("selected", "selected");
							}
						else{ // (xyz[0].trim()-abc) == (xyz[1].trim()-def)
							$("#ajaxSelect_"+type).val(disp);
							$("#ajaxSelect_warrantyLeft").val(dispCal+" Months");	
							$("#siteStatus").val("Warranty");
							document.getElementById("siteStatus").options[1].setAttribute("selected", "selected");	
							}
						}
					else if(tbna=='userdetails'){
						var xyz = result.split(",,");
						for(var i = 0; i < xyz.length; i++){document.getElementById("udata"+i).value = xyz[i].trim();}
					}
					else if(tbna=='roles'){ document.getElementById("userdetails").innerHTML = result;
					for(var i = 0; i < 3; i++){document.getElementById("udata"+i).value = '';}
					}
					else{document.getElementById("ajaxSelect_"+type).value=result.trim();}
				}
            });
        }
        document.getElementById("ajaxSelect_"+type).value = "";
    }
    </script>
<script type="text/javascript">
function ajaxSelectmulti(ids, type) {
	multipleValues = $( "#"+ids).val() || [];id=multipleValues.join( "," );
	if (id != "") {
		$.ajax({ 
				type: "POST",
				url: "ajaxSelectMulti.php",
				data: 'type=' + type + '&id=' + id,
				cache: false,
				success: function(result){
					if(type=='FromWH'){ $("#ajaxSelect_" +type).html(result+"<option value='sites'>[Sites]</option>"); }
					else{ $("#ajaxSelect_" +type).html(result);	}
				}
			});
		}
    if (type == "Circle") {
        $("#ajaxSelect_Circle").html("<option value='' disabled='disabled'>Select Circle</option>");
        $("#ajaxSelect_Cluster").html("<option value='' disabled='disabled'>Select Cluster</option>");
        $("#ajaxSelect_District").html("<option value='' disabled='disabled'>Select District</option>")
		$("#ajaxSelect_serviceEngineer").html("<option value='' disabled='disabled'>Select Service Engineer</option>")
		$("#ajaxSelect_regionalManager").html("<option value='' disabled='disabled'>Select Regional Manager</option>")
    }
    if (type == "Cluster") {
        $("#ajaxSelect_Cluster").html("<option value='' disabled='disabled'>Select Cluster</option>");
        $("#ajaxSelect_District").html("<option value='' disabled='disabled'>Select District</option>")
		$("#ajaxSelect_serviceEngineer").html("<option value='' disabled='disabled'>Select Service Engineer</option>")
		$("#ajaxSelect_regionalManager").html("<option value='' disabled='disabled'>Select Regional Manager</option>")
    }
    if (type == "District") {
        $("#ajaxSelect_District").html("<option value='' disabled='disabled'>Select District</option>")
    }
    if (type == "CustomerName") {
        $("#ajaxSelect_CustomerName").html("<option value='' disabled='disabled'>Select Customer</option>")
    }
    if (type == "ToWH") {
        $("#ajaxSelect_ToWH").html("<option value='' disabled >Select To W/H</option>")
    }
}
$(document).ready(function(){
	$('#fromWH').change(function(){ 
		if($(this).val()=='sites'){
			$('.siteAddress').html('<div class="col-md-4 form-group"><label>Site Address : </label><textarea tabindex="4" class="form-control" name="siteAddress" placeholder="Site Address"></textarea></div>');
			$('.inventHide').hide();
		}else{$('.siteAddress').html(''); $('.inventHide').show();}
	});
});
$(function(){
	$(".itemCodeAdd").click(function(e){ e.preventDefault();
		$('.itemCodeRow').append($('.itemMain').html());
			$('#defaultForm').bootstrapValidator('addField', $('.itemCodeRow').find('[name="itemCode[]"]'));
			$('#defaultForm').bootstrapValidator('addField', $('.itemCodeRow').find('[name="qty[]"]'));
			$('#defaultForm').bootstrapValidator('addField', $('.itemCodeRow').find('[name="stockCategory[]"]')); price();
		});//$(".itemCodeRow").on("click",".itemCodeRmv", function(e){ e.preventDefault(); $(this).parents('.rmv').remove(); });
	$(".itemCodeRmv").click(function(e){ e.preventDefault(); $('.itemCodeRow').find('span:last').remove(); CalcMaterialValue(); });
});
window.onload = price();
function price(){
	$(".price").change(function(e){ var pr = $(this)
		$.ajax({
			type: "POST",
			url: "ajaxMaterialValue.php",
			data: "mv="+$(this).val(),
			cache: false,
			success: function(result){ pr.parent().next().find('.itemPrice').val(result.trim());
			CalcMaterialValue();
			}
		});
	});
	$(".qty").each(function() { $(this).keyup(function(){ CalcMaterialValue(); }); });
}
function CalcMaterialValue(){ var sum = 0;
	$(".qty").each(function(){ if(!isNaN(this.value) && this.value.length!=0){
		var x = $(this).val();
		var y = $(this).siblings('input[type=hidden]').val();
		sum += parseFloat(x*y); }//else{alert('Please Enter Numbers Only'); }
	});$("#materialValue").val(sum.toFixed(5));
}
</script>
<script>
$(document).ready(function(){
	$('.addrej').click(function(e){ e.preventDefault();
	$('.falhid').hide(); // hides
	$('#rejid').html('<label style="display:block">Rejection Remarks : </label><textarea tabindex="11" name="falset" class="form-control" style="display:inline-block !important;width:80%;"></textarea> <button tabindex="44" type="submit" class="btn btn-primary ss_buttons" name="closett" style="margin-top:-20px;">Reject Ticket</button>'); });
});
</script>
<script type="text/javascript">
	$(function(){
		var sDate =  new Date('2000-01-01');
		var eDate = new Date();
		$('.singleDate').datetimepicker({format: 'YYYY-MM-DD'});
		$('.singleDateEnd').datetimepicker({format: 'YYYY-MM-DD', maxDate: eDate});
		$('.singleDateTime').datetimepicker({format: 'YYYY-MM-DD hh:mm:ss'});
		$('.singleDateTimeEnd').datetimepicker({format: 'YYYY-MM-DD hh:mm:ss', maxDate: eDate});
		$('.plannedDate').datetimepicker({format: 'YYYY-MM-DD',minDate:new Date('<?php echo plannedDate($_REQUEST['y']); ?>')});
		$('#mfdDate').datetimepicker({format:'YYYY-MM-DD',maxDate:eDate,minDate:sDate});//.on("dp.change",function(e){$('#installDate').data("DateTimePicker").minDate(e.date);});
		$('#installDate').datetimepicker({format:'YYYY-MM-DD',maxDate:eDate,minDate:sDate});//.on("dp.change",function(e){$('#mfdDate').data("DateTimePicker").maxDate(e.date);});
		$("#mfdDate").on("dp.change",function(e){$('#installDate').data("DateTimePicker").minDate(e.date);});
        $("#installDate").on("dp.change",function(e){$('#mfdDate').data("DateTimePicker").maxDate(e.date);});
		$("#mfgDate").datetimepicker({format:'YYYY-MM-DD',maxDate:eDate,minDate:sDate}).on('dp.change', function(selected){
			var d = new Date(selected.date.valueOf());
			var mfdMon=d.getMonth();
			var mfdDay=d.getDate();
			var abc = Math.floor((eDate.getTime()-d.getTime())/(86400000*30));
		var mont = document.getElementById('warrantyMonths').value - abc;
		if(mont > 0){document.getElementById('warrantyLeft').value = mont+" Months";}
		else{document.getElementById('warrantyLeft').value ="Out Of Warranty"; }
		});	
	});
</script>
<script type="text/javascript">
	$(function () {
		$('.dgCap').change(function(){
		if($(this).val() == 'NON DG'){$('.dgHide').hide();}
		else{$('.dgHide').show();}
		});
	});
</script>
<script type="text/javascript">
$(function(){
	$('#prodCat').change(function(){
		if($(this).val()==''){$("#siteType").html('<option value="" disabled selected>Select Site Type</option><option value="" disabled >First Select Segment</option>');}
		else if($(this).val() == '5169' ){$("#siteType").html('<option value="">Select Site Type</option><option value="AC3TR">AC3TR</option><option value="SL">SL</option>');}
		else{$("#siteType").html('<option value="">Select Site Type</option><option value="in">IN</option><option value="out">OUT</option>');}
	});
});
</script>
<script type="text/javascript">
$(function(){
	$('#itemCode').change(function(){
		if($(this).val() != ''){
			$.ajax({
				type: "POST",
				url: "ajaxTicketItemStatus.php",
				data: "item="+$(this).val()+"&circle="+$('#circle').val(),
				cache: false,
				success: function(result){ $('#itemStatus').val($.trim(result)); }
			});
		}else{$('#itemStatus').val('');}
	});
});
</script>
<script type="text/javascript">
$(function(){
	$('#fsrNumber').keyup(function(){
		if($(this).val() != ''){
			$.ajax({
				type: "POST",
				url: "ajaxSiteID.php",
				data: "fsrNumber="+$(this).val(),
				cache: false,
				success: function(result){ $('#fsrNumberError').html(result);
					if(result.length != 2 ){$('button[type=submit]').attr('disabled','disabled'); }
					else{ $('button[type=submit]').removeAttr('disabled'); }
				}
			});
		}else{ $('#fsrNumberError').html('');}
	});
});
</script>
<script>
function setSelectBoxByText(eid, etxt){
var eid = document.getElementById(eid);
if(etxt==='Reject'){$('#hideNHS').hide();/*eid.options[1].selected = true;*/}
else{$('#hideNHS').show(); eid.options[0].selected = true;}
}
function extraCloseField(fv1){
	if(fv1==2){
		$(".cst").html('<div class="col-md-4 form-group"><label>Replaced Cell Serial : </label><input class="form-control" type="text" name="replacedCellSerial"/></div>');
		$('#defaultForm').bootstrapValidator('addField', $('.cst').find('[name="replacedCellSerial"]'));
	}else $(".cst").html('');
}
</script>
	<script type="text/javascript">
		$("#siteID").bind('keyup keypress',function(e){ if(e.keyCode==32){ return false; }
					$.ajax({
						type: "POST",
						url: "ajaxSiteID.php",
						data: "siteID="+$(this).val(),
						cache: false,
						success: function(result){ result = result.replace(/^\s+|\s+$/gm,''); $('.errorP').html(result);
						if(result != ""){ $('button[type=submit]').prop('disabled',true);}else{$('button[type=submit]').prop('disabled',false);}}
					});
				});
		$("#natureOfActivity").change(function(e){
			$.ajax({
				type: "POST",
				url: "ajaxSiteID.php",
				data: "activity="+$(this).val(),
				cache: false,
				success: function(result){ $('#natureOfComplaint').html(result); }
			});
		});
    </script>
<script>            
	jQuery(document).ready(function() {
		var offset = 100;
		var duration = 500;
		jQuery(window).scroll(function() {
			if (jQuery(this).scrollTop() > offset) {
				jQuery('.back-to-top').fadeIn(duration);
			} else {
				jQuery('.back-to-top').fadeOut(duration);
			}
		});
		jQuery('.back-to-top').click(function(event) {
			event.preventDefault();
			jQuery('html, body').animate({scrollTop: 0}, duration);
			return false;
		})
	});
</script>
</body>
</html>