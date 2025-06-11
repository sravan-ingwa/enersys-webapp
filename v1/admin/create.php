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
<link href="css/bootstrap-select.min.css" type="text/css" rel="stylesheet">
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
	<?php include('header.php');?>
    <?php if(!isset($_REQUEST['x'])){$query = mysql_query("SELECT * FROM ss_menu ORDER BY ordering");$row=mysql_fetch_array($query);if($row)echo "<script type='text/javascript'>window.location='index.php?x=$row[id]'</script>";else echo"<script type='text/javascript'>window.location='logout.php?ref=noview'</script>";}?>
    <div class="container-fluid"><!-- Starting Of Body Container -->
        <div class="row">
            <div class="col-sm-1 hidden-xs"></div>
                <div class="col-xs-12 col-sm-10">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Create <?php echo menuName($_REQUEST['x'],"menu"); ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php
                            $ref=$_REQUEST['x'];
                            $query=mysql_query("SELECT * FROM ss_menu WHERE id='$ref'");
                            if(mysql_num_rows($query)>0){
                                $row=mysql_fetch_array($query);
                                include('include/'.$row['tbName'].'_create.php');
                            }
                            ?>
							<a href="#" class="back-to-top"><i class="glyphicon glyphicon-chevron-up"></i></a>
                        </div>
                    </div>
                </div><!-- Closing Of col-xs-12 -->
            <div class="col-sm-1 hidden-xs"></div>
        </div>
    </div><!-- Closing Of Body Container -->
    <script type="text/javascript" src="js/jquery.min.js"></script>
	<script>
    $(document).ready(function(){
        $('#moc').change(function(){
            if($(this).val()=='Fax' || $(this).val()=='Letter'){
                $('#res').html('<div class="col-md-4 form-group"><label>Upload a report : </label><input type="file" tabindex="19" class="form-control" name="pdf[]" multiple="multiple" /></div>');
                }else{$('#res').html('');}
            });
        $('#prodCat').change(function(){
            if($(this).val()==''){$("#siteType").html('<option value="" disabled selected>Select Site Type</option><option value="" disabled >First Select Segment</option>');}
            else if($(this).val() == '5169' ){$("#siteType").html('<option value="">Select Site Type</option><option value="AC3TR">AC3TR</option><option value="SL">SL</option>');}
            else{$("#siteType").html('<option value="">Select Site Type</option><option value="in">IN</option><option value="out">OUT</option>');}
        });
    });
    </script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrapValidator.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/validation.js"></script>
	<script type="text/javascript" src="js/jquery.autocomplete.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.2.custom.min.js"></script>
    <script type="text/javascript" src="js/moment.js"></script>
	<script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>
    <script>
	$(document).ready(function(){
		$('.tooltips').tooltip();
		var arr = [ "all", "create", "view", "edit", "delete", "xport", "special" ];
		$.each( arr, function( i, val ) {
			$('#uncheck_'+val).click(function(){$('.'+val).prop('checked', false);});
			$('#check_'+val).click(function(){$('.'+val).prop('checked', true);});
		});
	});
	</script>
	<script type="text/javascript">
    function ajaxSelect(id, type) {
        if(id != ""){
            if(type.search(",") == "-1"){
                $.ajax({
                    type: "POST",
                    url: "ajaxSelect.php",
                    data: 'type=' + type + '&id=' + id,
                    cache: false,
                    success: function(result) { //alert(result);
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
            $("#ajaxSelect_Circle").html("<option value='' disabled >Select Circle</option>");
            $("#ajaxSelect_Cluster").html("<option value='' disabled >Select Cluster</option>");
            $("#ajaxSelect_District").html("<option value='' disabled= >Select District</option>");
            $("#ajaxSelect_EmployeeName").html("<option value='' disabled >Select EmployeeName</option>");
            $("#ajaxSelect_serviceEngineer").html("<option value='' disabled >Select Service Engineer</option>");
            $("#ajaxSelect_regionalManager").html("<option value='' disabled >Select Regional Manager</option>");
        }
        if (type == "Cluster") {
            $("#ajaxSelect_Cluster").html("<option value='' disabled >Select Cluster</option>");
            $("#ajaxSelect_District").html("<option value='' disabled >Select District</option>");
            $("#ajaxSelect_serviceEngineer").html("<option value='' disabled >Select Service Engineer</option>");
            $("#ajaxSelect_regionalManager").html("<option value='' disabled >Select Regional Manager</option>");
        }
        if (type == "District") {
            $("#ajaxSelect_District").html("<option value='' disabled >Select District</option>");
        }
        if (type == "CustomerName") {
            $("#ajaxSelect_CustomerName").html("<option value='' disabled >Select Customer</option>");
        }
		if(type == "EmployeeName"){
        	$("#ajaxSelect_EmployeeName").html("<option value='' disabled >Select EmployeeName</option>");
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
                        case 'District':$("#ajaxText_"+type).html("<option value='' disabled selected>Select Base Location</option>"); $("#ajaxText_"+type).append(result);break;
                        default:$("#ajaxText_"+type).autocomplete('ajaxText.php?result='+result+'&type='+type+'&ref=autocomplete', {selectFirst: true});
                        }
                   }
            });
        }
        if(type=="Circle"){document.getElementById("ajaxText_Circle").value = "";document.getElementById("ajaxText_Cluster").value = "";$("#ajaxText_District").html("<option value='' disabled selected>Select Base Location</option>");}if(type=="Cluster"){document.getElementById("ajaxText_Cluster").value = "";$("#ajaxText_District").html("<option value='' disabled selected>Select Base Location</option>");}if(type=="District"){$("#ajaxText_District").html("<option value='' disabled selected>Select Base Location</option>");}	
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
	<script> 
    $(function(){
		$("#siteID").bind('keyup keypress',function(e){	if(e.keyCode==32){ return false; }
			$.ajax({
				type: "POST",
				url: "ajaxSiteID.php",
				data: "siteID="+$(this).val()+"&circle="+$("#ajaxSelect_Circle").val(),
				cache: false,
				success: function(result){ $('.errorP').html(result); }
			});
		});
        $("#smaster0").keydown(function(e){if(e.keyCode==13)return false; if(e.keyCode == 8)for(var i = 1; i <= 15; i++){document.getElementById("smaster"+i).value = ''; } });
        $("#smaster0").autocomplete({
            source: "autoLoad.php", minLength: 1,
            select: function(event, ui) {
                var getUrl = ui.item.id;
                if(getUrl == 'create.php?x=8324' ){ window.open('create.php?x=8324');}
                else{ 
                    var xyz = getUrl.split(",,");
                    for(var i = 0; i < xyz.length; i++){document.getElementById("smaster"+i).value = xyz[i];}
                }
            },html: true,open: function(event, ui) {$(".ui-autocomplete").css("z-index", 1000);}
        });
    });
    </script>
    <script type="text/javascript"> 
    function ajaxOutward(val,ref){
		$.ajax({
			type: "POST",
			url: "ajaxOutward.php",
			data: "tt="+val+"&ref="+ref,
			cache: false,
			success: function(result){ var xyz = result.trim().split(",");
				if(ref=='invent'){ for(var i = 0; i < xyz.length; i++){ $('#'+ref+i).val(xyz[i].trim());}}
				else{ for(var i = 1; i < xyz.length-1; i++){$('.'+ref+i).val(xyz[i].trim());}
					$('.'+ref+0).html("<option value=''>Select Item Code</option>"+xyz.pop());
					$('.'+ref+3).html("<option value=''>Select Stock Category</option>"+xyz[0]);
				}
			}
		});
    }
    </script>
	<script>
		$("#invoiceNumber").bind('keyup keypress',function(e){	if(e.keyCode==32){ return false; }
			$.ajax({
				type: "POST",
				url: "ajaxInventBalance.php",
				data: "invcNum="+$(this).val()+'&ref=invcRef',
				cache: false,
				success: function(result){ var res = result.trim();
					if(res!=''){$('#disbl').attr('disabled',true);}else{$('#disbl').removeAttr('disabled');}
					$('.errorP').html(res);
				}
			});
		});
    </script>
	<script>
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
    <script type="text/javascript"> 
    function ajaxBookAdvance(val){
		$.ajax({
			type: "POST",
			url: "ajaxBookAdvance.php",
			data: "val="+val,
			cache: false,
			success: function(result){
				var xyz = result.split(",,");
				for(var i = 0; i < xyz.length; i++){document.getElementById("aba"+i).value = xyz[i].trim();}
				}
		});
    }
    </script>
	<script type="text/javascript"> 
	function ajaxBookExpense(val){
		$.ajax({
			type: "POST",
			url: "ajaxBookExpense.php",
			data: "empId="+val,
			cache: false,
			success: function(result){
				var xyz = result.split(",");
				for(var i = 0; i < xyz.length; i++){document.getElementById("bookexp"+i).value = xyz[i].trim();}
			}
		});
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
				success: function(result){$("#ajaxSelect_" +type).html(result);	}
			});
		}
    if (type == "Circle") {
        $("#ajaxSelect_Circle").html("<option value='' disabled >Select Circle</option>");
        $("#ajaxSelect_Cluster").html("<option value='' disabled >Select Cluster</option>");
        $("#ajaxSelect_District").html("<option value='' disabled >Select District</option>")
		$("#ajaxSelect_serviceEngineer").html("<option value='' disabled >Select Service Engineer</option>")
		$("#ajaxSelect_regionalManager").html("<option value='' disabled >Select Regional Manager</option>")
    }
    if (type == "Cluster") {
        $("#ajaxSelect_Cluster").html("<option value='' disabled >Select Cluster</option>");
        $("#ajaxSelect_District").html("<option value='' disabled >Select District</option>")
		$("#ajaxSelect_serviceEngineer").html("<option value='' disabled >Select Service Engineer</option>")
		$("#ajaxSelect_regionalManager").html("<option value='' disabled >Select Regional Manager</option>")
    }
    if (type == "District") {
        $("#ajaxSelect_District").html("<option value='' disabled >Select District</option>")
    }
    if (type == "CustomerName") {
        $("#ajaxSelect_CustomerName").html("<option value='' disabled >Select Customer</option>")
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
</script>
<script>
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
		});$("#materialValue").val(sum.toFixed(2));
	}
</script>
<script>
	$(function(){
		var sDate =  new Date('2000-01-01');
		var eDate = new Date();
		$('.singleDate').datetimepicker({format: 'YYYY-MM-DD'});
		$('.singleDateEnd').datetimepicker({format: 'YYYY-MM-DD', maxDate: eDate});
		$('.singleDateTime').datetimepicker({format: 'YYYY-MM-DD hh:mm:ss'});
		$('.singleDateTimeEnd').datetimepicker({format: 'YYYY-MM-DD hh:mm:ss', maxDate: eDate});
		$('#mfdDate').datetimepicker({format:'YYYY-MM-DD',maxDate:eDate,minDate:sDate});//.on("dp.change",function(e){$('#installDate').data("DateTimePicker").minDate(e.date);});
		$('#installDate').datetimepicker({format:'YYYY-MM-DD',maxDate:eDate,minDate:sDate});//.on("dp.change",function(e){$('#mfdDate').data("DateTimePicker").maxDate(e.date);});
		$("#mfdDate").on("dp.change",function(e){$('#installDate').data("DateTimePicker").minDate(e.date);});
        $("#installDate").on("dp.change",function(e){$('#mfdDate').data("DateTimePicker").maxDate(e.date);});
	});
</script>
<script>
window.onload = myHandler();
	function myHandler(){
		var arr = {"visitFromDate":"visitToDate"};
		$(document).ready(function(){ for(var a = 0; a < $('input[name="hotel_checkIn[]"]').length; a++){ arr["checkIn"+a]="checkOut"+a;}
		$.each( arr, function( i, v ){ //alert(i);
		var month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
		var sDate =  new Date('2000-01-01');
		var eDate = new Date();
		var testStart = ''; var testEnd = '';
		$('.singleDate').datetimepicker({format: 'YYYY-MM-DD'});
		$('.singleDateEnd').datetimepicker({format: 'YYYY-MM-DD',maxDate:eDate}); // It is for fare and local ....
		$('.'+i).datetimepicker({format:'YYYY-MM-DD',maxDate:eDate,minDate:sDate});//.on("dp.change",function(e){$('.'+v).data("DateTimePicker").minDate(e.date);});
		$('.'+v).datetimepicker({format:'YYYY-MM-DD',maxDate:eDate,minDate:sDate});//.on("dp.change",function(e){$('.'+i).data("DateTimePicker").maxDate(e.date);});
		$('.'+i).on("dp.change",function(s){$('.'+v).data("DateTimePicker").minDate(s.date);
			testStart = 'testStart'; sChDate = s.date;
			if(testEnd){
				$('#'+i).val(Math.floor((eChDate - s.date)/86400000)+1);
				var sm = month[new Date(s.date.valueOf()).getMonth()];
				var sy = new Date(s.date.valueOf()).getFullYear();
				if(new Date(s.date.valueOf()).getDate()<16){ $('#'+v).val('F1 '+sm+' '+sy);} else $('#'+v).val('F2 '+sm+' '+sy);
			}
		});
		$('.'+v).on("dp.change",function(e){$('.'+i).data("DateTimePicker").maxDate(e.date);
			testEnd = 'testEnd'; eChDate = e.date;
			if(testStart){
				$('#'+i).val(Math.floor((e.date - sChDate)/86400000)+1);
				var em = month[new Date(e.date.valueOf()).getMonth()];
				var ey = new Date(e.date.valueOf()).getFullYear();
				if(new Date(e.date.valueOf()).getDate()<16){$('#'+v).val('F1 '+em+' '+ey);} else $('#'+v).val('F2 '+em+' '+ey);
			}
		});
	});
});
}
	</script>
	<script>
       $(function(){
		var j=1;
            $("#fare_add_row").click(function(){ 
				$('#fare'+j).html('<td><input type="text" tabindex="10" class="form-control singleDateEnd" name="fare_dateOfTravel[]" placeholder="Date Of Travel"/></td>'+
                            '<td><input type="text" tabindex="10" class="form-control" name="fare_modeOfTravel[]" placeholder="Mode Of Travel"/></td>'+
                            '<td><input type="text" tabindex="10" class="form-control" name="fare_travelFrom[]" placeholder="From"/></td>'+
                            '<td><input type="text" tabindex="10" class="form-control" name="fare_travelTo[]" placeholder="To"/></td>'+
                            '<td><input type="text" tabindex="10" class="form-control fare tour" name="fare_amount[]" id="fare_amount'+j+'" placeholder="Amount"/></td>');
				$('#fare_tab').append('<tr id="fare'+(j+1)+'" class="text-center"></tr>');
				j++; fare(); myHandler(); tour();
			}); $("#fare_del_row").click(function(){ if(j>1){ $("#fare"+(j-1)).html(''); j--; } });
			 var fare = function(){ $(".fare").each(function() { $(this).keyup(function(){ calculateSum('fare'); }); }); }
			 window.onload = fare();
		});

    function calculateSum(ref){ var sum = 0;
        $("."+ref).each(function(){ if(!isNaN(this.value) && this.value.length!=0){ sum += parseFloat(this.value); }//else{alert('Please Enter Numbers Only'); }
		});$("#"+ref+"_total").val(sum.toFixed(2));
    }
	window.onload = tour();
   function tour(){
		   $(function(){ $(".tour").each(function() { $(this).keyup(function(){ calculateSum('tour'); }); }); });
	}
	window.onload = netExp();
	function netExp(){
		   $(function(){ $(".netExp").each(function() { $(this).keyup(function(){ netExpSum('netExp'); }); }); });
	}
	function netExpSum(ref){ var sum = 0;
        $("."+ref).each(function(){ if(!isNaN(this.value) && this.value.length!=0){ sum += parseFloat(this.value); }
		}); $("#"+ref+"_total").val((parseFloat($("#tour_total").val()))-(parseFloat(sum.toFixed(2))));
    }
</script>
    <script>	
       $(function(){
		var j=1;
			$("#hotel_add_row").click(function(){
				$('#hotel'+j).html('<td><input type="text" tabindex="11" class="form-control checkIn'+j+'" name="hotel_checkIn[]" placeholder="Check In Date"/></td>'+
                            '<td><input type="text" tabindex="11" class="form-control checkOut'+j+'" name="hotel_checkOut[]" placeholder="Check Out Date"/></td>'+
                            '<td><input type="text" tabindex="11" class="form-control" id="checkIn'+j+'" name="hotel_totalDays[]" placeholder="Total Days" readonly /></td>'+
                            '<td><input type="text" tabindex="11" class="form-control hotel tour" name="hotel_amount[]" id="hotel_amount'+j+'" placeholder="Amount"/></td>');
				$('#hotel_tab').append('<tr id="hotel'+(j+1)+'" class="text-center"></tr>');
				j++; hotel(); myHandler(); tour();
            }); $("#hotel_del_row").click(function(){ if(j>1){ $("#hotel"+(j-1)).html(''); j--; } });
			 var hotel = function(){ $(".hotel").each(function() { $(this).keyup(function(){ calculateSum('hotel'); }); }); }
			 window.onload = hotel();
		});
	</script>
	<script>	
       $(function(){
		var j=1;
			$("#local_add_row").click(function(){
				$('#local'+j).html('<td><input type="text" tabindex="12" class="form-control singleDateEnd" name="local_dateOfTravel[]" placeholder="Date Of Travel"/></td>'+
                            '<td><input type="text" tabindex="12" class="form-control" name="local_modeOfTravel[]" placeholder="Mode Of Travel"/></td>'+
                            '<td><input type="text" tabindex="12" class="form-control" name="local_travelFrom[]" placeholder="From"/></td>'+
                            '<td><input type="text" tabindex="12" class="form-control" name="local_travelTo[]" placeholder="To"/></td>'+
                            '<td><input type="text" tabindex="12" class="form-control local tour" name="local_amount[]" id="local_amount'+j+'" placeholder="Amount"/></td>');
				$('#local_tab').append('<tr id="local'+(j+1)+'" class="text-center"></tr>');
				j++; local(); myHandler(); tour();
			}); $("#local_del_row").click(function(){ if(j>1){ $("#local"+(j-1)).html(''); j--; } });
            var local = function(){ $(".local").each(function() { $(this).keyup(function(){ calculateSum('local'); }); }); }
			 window.onload = local();
		});
	</script>
	<script>	
       $(function(){
		var j=1;
			$("#other_add_row").click(function(){
				$('#other'+j).html('<td colspan="2"><input type="text" tabindex="13" class="form-control" name="other_desc[]" placeholder="Description"/></td>'+
							'<td><input type="text" tabindex="13" class="form-control other tour" name="other_amount[]" id="other_amount'+j+'" placeholder="Amount"/></td>');
				$('#other_tab').append('<tr id="other'+(j+1)+'" class="text-center"></tr>');
				j++; other(); tour();
            }); $("#other_del_row").click(function(){ if(j>1){ $("#other"+(j-1)).html(''); j--; } });
				var other = function(){ $(".other").each(function() { $(this).keyup(function(){ calculateSum('other'); }); }); }
			 	window.onload = other();
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
<script type="text/javascript">
function ajaxRevivRefreshCust(ref,val){
	$.ajax({
		type: "POST",
		url: "ajaxRevivRefreshCust.php",
		data: 'val='+val,
		cache: false,
		success: function(result){ $("#"+ref).val($.trim(result)); }
	});
}
</script>
<script>
$(function(){
$('#revivalClick').click(function(){
	for(var i = $('input[name="srNo[]"]').length+1; i<=$('#revivalAdd').val(); i++){
		$('#revivalRows').append('<tr>'+
		'<td width="60px"><input type="text" tabindex="22" class="form-control" name="srNo[]" value="'+i+'" readonly /></td>'+
		'<td width="95px"><input type="text" tabindex="22" class="form-control" name="cellSrNo[]" placeholder="Cell Sr. No." ></td>'+
		'<td><input type="text" tabindex="22" class="form-control" name="ocv[]" placeholder="OCV" ></td>'+
		'<td><input type="text" tabindex="22" class="form-control" name="disCurrent[]" placeholder="Current" ></td>'+
		'<td><input type="text" tabindex="22" class="form-control" name="1Hr[]" placeholder="1st" ></td>'+
		'<td><input type="text" tabindex="22" class="form-control" name="2Hr[]" placeholder="2nd" ></td>'+
		'<td><input type="text" tabindex="22" class="form-control" name="3Hr[]" placeholder="3rd" ></td>'+
		'<td><input type="text" tabindex="22" class="form-control" name="4Hr[]" placeholder="4th" ></td>'+
		'<td><input type="text" tabindex="22" class="form-control" name="5Hr[]" placeholder="5th" ></td>'+
		'<td><input type="text" tabindex="22" class="form-control" name="6Hr[]" placeholder="6th" ></td>'+
		'<td><input type="text" tabindex="22" class="form-control" name="7Hr[]" placeholder="7th" ></td>'+
		'<td><input type="text" tabindex="22" class="form-control" name="8Hr[]" placeholder="8th" ></td>'+
		'<td><input type="text" tabindex="22" class="form-control" name="9Hr[]" placeholder="9th" ></td>'+
		'<td><input type="text" tabindex="22" class="form-control" name="10Hr[]" placeholder="10th" ></td>'+
		'<td width="95px"><select tabindex="22" class="form-control" name="result[]"><option value="pass">Pass</option><option value="fail">Fail</option></select></td>'+
		'</tr>');
		}
});
});
</script>
<script>
function ajaxESCAActivity(id){
	if(id!=""){
		$.ajax({
			type: "POST",
			url: "ajaxESCAActivity.php",
			data: 'id='+id+'&ref=Esca2TT',
			cache: false,
			success: function(result){ $(".escaAct").html(result); }
		});
	}else{$(".escaAct").html("<option value=''>Select TT Number</option>");}
}		
function ajaxEscaZoneCircle(id){
	$.ajax({
		type: "POST",
		url: "ajaxESCAActivity.php",
		data: 'id='+id+'&ref=escaZC',
		cache: false,
		success: function(result){ var xyz = result.split(",,"); for(var i = 0; i < xyz.length; i++){ document.getElementById("escaZC"+i).value = xyz[i].trim(); } }
	});
}
var fun = function(){ var u = 0, w = 0;
   if($("#basicValue").val() == ''){ $("#basicValue").val(0); }
   if($("#stPercent").val() == ''){ $("#stPercent").val(0); }
   if($("#others").val() == ''){ $("#others").val(0); }
}
$(function(){
	$(".escaAct").change(function(){
		$.ajax({
			type: "POST",
			url: "ajaxESCAActivity.php",
			data: 'id='+$(this).val()+'&ref=TT2Basic',
			cache: false,
			success: function(result){ var thval = result.trim();
				var thisIs = $("#basicValue");
				thisIs.val(thval);
				fun(); if(thisIs.val() == 0){ thisIs.val('');}
					if(!isNaN(thisIs.val()) && thisIs.val()!=''){
						u = parseFloat(thisIs.val())*(parseFloat($("#stPercent").val()) + 100)/100;
						w = parseFloat($("#others").val())+parseFloat(u.toFixed(2));
						$("#total").val(w.toFixed(2));
					}else{ $("#total").val('');}
				}
		});
	});
	$("#others").keyup(function(){ var z = $(this).val();  if($(this).val() == 0){ $(this).val('');}
		if( !isNaN(z) && z!=''){
			u = parseFloat($("#basicValue").val())*(parseFloat($("#stPercent").val()) + 100)/100;
			w = parseFloat(z)+parseFloat(u.toFixed(2));		
			$("#total").val(parseFloat(w.toFixed(2)));
			}					
		else{ $("#total").val(parseFloat(u.toFixed(2))); }
	});
	$("#stPercent").keyup(function(){ fun();  if($(this).val() == 0){ $(this).val('');}
	if(!isNaN($(this).val()) && $(this).val()!=''){
		u = parseFloat($("#basicValue").val())*(parseFloat($(this).val()) + 100)/100;
		w = parseFloat($("#others").val())+parseFloat(u.toFixed(2));
		$("#total").val(w.toFixed(2));
	}else{ $("#total").val('');}});
});
</script>
<script>
$(function(){
	$('.upload').change(function(){
		$('.hid').css('display','none');
	    $('.submit').attr('name','import');
		var sp = $(this).val().split("fakepath");
		$('.errorP').html("Click Add Item Button to import <span style='color:red'>"+sp[1]+"</span> file");
		});
});
</script>
<script>
$(function(){
	$('#designation').change(function(){
		if($(this).val()!='19'){
			$('#officialMail').html('<div class="col-md-4 form-group"><label>Official Email</label><input tabindex="5" type="text" name="officialEmail" class="form-control nocap" placeholder="Enter Official Email Id"></div>');
		}else{$('#officialMail').html('');}
	});
});
</script>
<script>
$('#accessories').change(function(){
	if(this.value=='accessories'){
		$(".stockCategory").html("<option value=''>Select Stock Category</option><option value='accessories' selected>Accessories</option>");
	}else{
		$(".stockCategory").html("<option value=''>Select Stock Category</option><?php stockOptions(); ?>")
	}
});
</script>
</body>
</html>