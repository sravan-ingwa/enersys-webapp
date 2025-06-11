<?php include('v1/admin/functions.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php TitleFav();?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link href="v1/css/bootstrap.css" rel="stylesheet">
<link href="v1/css/main.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="v1/css/autoComplete.css" />
<link href="v1/css/autoFill2.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="screen" href="v1/css/bootstrap-datetimepicker.min.css" />
<style>
.topmenu{
	/*background:#212121; /*428bca*/
	background: url("v1/img/black-pattern.jpg") repeat scroll 0% 0% transparent;
	color:#FFF;
	padding:0 !important;
	height:40px;
}
.topmenu ul{
	list-style:none;
	margin:0 !important;padding:0 !important;
}
.topmenu ul li{display:inline-block;padding:0 7px;line-height:35px;font-size:20px;}
.topmenu h1{font-size:22px;font-weight:bold;margin:0 !important;line-height:35px;}
.contact-dropdown{
	width:250px !important;
	background-color:#790900 !important;
}
.btn-primar {
  color: #fff;
  background-color: #790900;
  border-color: #790900;
}
.btn-primar:hover{
  color: #fff;
  background-color: #922220;
  border-color: #922220;
	}
	.back-2-top {
	position: fixed;
	bottom: 0px;
	right: 10px;
	text-decoration: none;
	color: #fff !important;
	background-color: #790900;
	font-size: 16px;
	padding: 8px 15px;
	display: none;
	border-radius:10px 10px 0px 0px;
}
.back-2-top:hover {	
	background-color: #922220;
}
.shg{margin-top:-100px !important;}
@media (max-width: 767px) {
	.fdd{font-size: 18px !important;}
	.shg{margin-top:-50px !important;}
}
@media (max-width: 500px) {
	.fdd{font-size: 10px !important;}
	.shg{margin-top:-50px !important;}
}
textarea::-moz-placeholder {
	text-transform:capitalize !important;
}
textarea:-ms-input-placeholder {
	text-transform:capitalize !important;
}
textarea::-webkit-input-placeholder {
	text-transform:capitalize !important;
}
</style>
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body role="document" style="background:url(v1/img/body-pattern.jpg) repeat center;">
<!-- Modal Start-->
<!--<input type="button" class="trigger" data-toggle='modal' data-target='#myModal' value="click"/>-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">EnerSys Care</h4>
      </div>
      <div class="modal-body"><b>Request Taken Successfully, Ticket Number will receive to you Shortly.</b></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" style="width:100px;">Ok</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal End-->
<div class="container-fluid navbar-fixed-top"><!-- Starting Of Heading Container -->
	<div class="row topmenu">
        <div class="col-sm-2 hidden-xs text-left">
            <ul>
                <li><a href="" onclick="window.history.back()"><span class="glyphicon glyphicon-arrow-left"></span></a></li><!--http://www.enersys.com-->
            </ul>
        </div>
    	<div class="col-xs-8 text-center">
			<h1 class="fdd"><a href="onlinetickets.php" style="text-transform:none !important"><span style="font-size:27px !important;">E</span>nerSys <span style="color:#40AE51;text-shadow:-1px -1px 0 #FFF,1px -1px 0 #FFF,-1px 1px 0 #FFF,1px 1px 0 #FFF;">Care</span> Online Ticket Registration</a></h1>
        </div>
		<div class="col-sm-2 col-xs-4 text-right">
            <ul class="nav cont">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" style="padding:0px 10px !important;" data-toggle="dropdown"><i class="glyphicon glyphicon-phone-alt"></i><b class="caret"></b></a>
                    <div class="dropdown-menu contact-dropdown pull-right">
                    <div style="padding:0 2px; margin:0 !important;font-size:13px;line-height:25px;color:#fff;text-transform:none !important;"><b>Contact us:</b> 040-6704 6704</br><b>Feedback us:</b>feedback@enersys.co.in</div>
                        
                    </div>
                </li>
        	</ul>
        </div>
    </div>
	<!--<div class="row">
    	<div class="col-lg-12 topmenuc">
        	<ul class="menu-lh hidden-xs">
                <div class="testBody">
                </div>
            </ul>
        	</div>
        </div>-->
</div><!-- Closing Of Heading Container -->
    <div class="container-fluid shg" ><!-- Starting Of Body Container -->
        <div class="row">
            <div class="col-sm-1 hidden-xs"></div>
                <div class="col-xs-12 col-sm-10">
                    <div class="panel panel-primary" style="border-color: #790900;">
                        <div class="panel-heading" style="background-color: #790900;border-color: #790900;">
                            <h3 class="panel-title">Create Online Tickets</h3>
                        </div>
                        <div class="panel-body">
<?php
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['create'])){
	$a = mysql_escape_string($_REQUEST['natureOfActivity']);
	$b = strtoupper(mysql_escape_string($_REQUEST['siteID']));
	$c = ucwords(mysql_escape_string($_REQUEST['siteName']));
	if(is_numeric($_REQUEST['zone'])){$d = $_REQUEST['zone'];}else{$d = zoneGetID($_REQUEST['zone']);}
	if(is_numeric($_REQUEST['circle'])){$e = $_REQUEST['circle'];}else{$e = circleGetID($_REQUEST['circle']);}
	if(is_numeric($_REQUEST['cluster'])){$f = $_REQUEST['cluster'];}else{$f = clusterGetID($_REQUEST['cluster']);}
	if(is_numeric($_REQUEST['district'])){$g = $_REQUEST['district'];}else{$g = districtsGetID($_REQUEST['district']);}
	$h = mysql_escape_string($_REQUEST['mfdDate']);
	$i = mysql_escape_string($_REQUEST['installDate']);
	$k = mysql_escape_string($_REQUEST['noOfString']);
	$l = ucwords(mysql_escape_string($_REQUEST['customerName']));
	$m = mysql_escape_string($_REQUEST['customerNumber']);
	if(is_numeric($_REQUEST['customerCategory'])){$n = $_REQUEST['customerCategory'];}else{$n = customerCategoriesGetId($_REQUEST['customerCategory']);}
	$o = mysql_escape_string($_REQUEST['siteType']);
	if(is_numeric($_REQUEST['customerCode'])){$p = $_REQUEST['customerCode'];}else{$p = customerNameGetID($_REQUEST['customerCode']);}
	//$q = mysql_escape_string($_REQUEST['createdDate']);
	$r = mysql_escape_string($_REQUEST['natureOfComplaint']);
	if(is_numeric($_REQUEST['productCode'])){$s = $_REQUEST['productCode'];}else{$s = productCodeGetID($_REQUEST['productCode']);}
	$t = ucfirst(mysql_real_escape_string($_REQUEST['completeDesc']));
	$aa = ucwords(mysql_real_escape_string($_REQUEST['clusterManagerName']));
	$bb = mysql_real_escape_string($_REQUEST['clusterManagerNumber']);
	$cc = mysql_real_escape_string($_REQUEST['scheduleDays']);
	$dd = mysql_real_escape_string($_REQUEST['warrantyMonths']);
	$ee = mysql_real_escape_string($_REQUEST['siteStatus']);
	$ff = strtolower(mysql_real_escape_string($_REQUEST['clusterManagerMail']));
	$gg = ucfirst(mysql_real_escape_string($_REQUEST['siteAddress']));
	
		if($a==""){$result="Select Nature Of Activity";}
		elseif($b==""){$result="Enter Site ID";}
		elseif($c==""){$result="Enter Site Name";}
		elseif($d==""){$result="Select Zone";}
		elseif($e==""){$result="Select Circle";}
		elseif($f==""){$result="Select Cluster";}
		elseif($g==""){$result="Select District";}
		elseif($h==""){$result="Select Manufactured Date";}
		elseif($k==""){$result="Select No Of String";}
		elseif($l==""){$result="Select Customer Name";}
		elseif($m==""){$result="Select Customer Number";}
		elseif($n==""){$result="Select Customer Category";}
		elseif($p==""){$result="Select Customer Code";}
		elseif($r==""){$result="Select Nature Of Complaint";}
		elseif($t==""){$result="Enter Description";}
		else{
			$query=mysql_query("SELECT id FROM ss_tickets WHERE siteId ='$b' AND natureOfActivity='$a' AND checkStat!='5'");
			$que=mysql_query("SELECT id FROM ss_online_tickets WHERE siteId ='$b' AND flag=0");
			$count=mysql_num_rows($query);$cou=mysql_num_rows($que);
			if($count==0){
				if($cou==0){
				$id = checkx(rand(0000, 9999),'ss_online_tickets');
				$ac = mysql_query("INSERT INTO ss_online_tickets(id,natureOfActivity,siteId,siteName,zone,circle,cluster,district,mfdDate,installDate,numBanks,customerName,customerNumber,customerCategory,siteType,customerCode,createdDate,natureOfComplaint,productCode,description,clusterManagerName,clusterManagerNumber,scheduleDays,warrantyMonths,siteStatus,clusterManagerMail,siteAddress,flag) VALUES('$id','$a','$b','$c','$d','$e','$f','$g','$h','$i','$k','$l','$m','$n','$o','$p','".date('Y-m-d h:i:s')."','$r','$s','$t','$aa','$bb','$cc','$dd','$ee','$ff','$gg','0')");
			if($ac){
				/*echo "<script type='text/javascript'>window.location='view.php?y=".$id."&x=2432&ref=".uniqid()."'</script>";*/
			//$result="Request Taken Successfully, Ticket Number will receive to you Shortly.";
			echo "<script>setTimeout(function(){ $('#myModal').modal('show')},1000);</script>";
			onlineTTMail($c);
			}else $result="Sorry Please try Again!";
			}else{$result="SiteID already Sent for Approval";}
			}else{$result="Ticket already Registered";}
		} } ?>
<p class="errorP"><?php if(isset($result))echo $result;?> </p>
<form role="form" class="ss_form" method="POST" name="contactform" action="" id="defaultForm" enctype="multipart/form-data" novalidate>
<div class="col-md-4 form-group">
    <label>Nature Of Activity : <i class="glyphicon glyphicon-question-sign tool" title="Select the dropdown for which Activity the TT should register"></i></label>
    <select tabindex="1" autofocus class="form-control" name="natureOfActivity" id="natureOfActivity">
    <option value="" disabled selected> Select Nature Of Activity </option><?php echo natureOfActivityOption(); ?>
    </select>
</div>
<div class="col-md-4 form-group">
	<label>Created Date : </label>
	<input tabindex="2" name="createdDate" type='text' class="form-control" placeholder="YYYY-MM-DD" value="<?php echo date('Y-m-d h:i:s'); ?>" readonly />
</div>
<div id="add">
<div class="col-md-4 form-group">
    <label>Site ID : <i class="glyphicon glyphicon-question-sign tool" title="Type the Site ID, if the data is available in our Database the form will fill Automatically, if not Select Add Manually."></i></label>
    <input tabindex="3" type="text" class="form-control noEnterSubmit" placeholder="Enter Site ID/ Coach Number" id="smaster0" name="siteID"/>
</div>
<div class="col-md-4 form-group">
    <label>Site Name : </label>
    <input tabindex="4" type="text" class="form-control"  placeholder="Site Name" id="smaster1" name="siteName" readonly />
</div>
<div class="col-md-4 form-group">
    <label>Zone : </label>
    <input tabindex="5" type="text" class="form-control"  placeholder="Zone" id="smaster2" name="zone" readonly />
</div>
<div class="col-md-4 form-group">
	<label>Circle : </label>
	<input tabindex="6" type="text" class="form-control" placeholder="Circle" id="smaster3" name="circle" readonly />
</div>
<div class="col-md-4 form-group">
	<label>Cluster : </label>
	<input tabindex="7" type="text" class="form-control" placeholder="Cluster" id="smaster4" name="cluster" readonly />
</div>
<div class="col-md-4 form-group">
	<label>District : </label>
	<input tabindex="8" type="text" class="form-control" placeholder="District" id="smaster5" name="district" readonly />
</div>
<div class="col-md-4 form-group">
	<label>Manufactured Date : </label>
	<input tabindex="9" type="text" class="form-control" placeholder="Manufactured Date" id="smaster6" name="mfdDate" readonly />
</div>
<div class="col-md-4 form-group">
	<label>Installation Date : </label>
	<input tabindex="10" type="text" class="form-control" placeholder="Installation Date" id="smaster7" name="installDate" readonly />
</div>
<div class="col-md-4 form-group">
    <label>Number Banks : </label>
    <input tabindex="11" type="text" class="form-control" placeholder="Number Banks" id="smaster8" name="noOfString" readonly />
</div>
<div class="col-md-4 form-group">
    <label>Site Technician Name : </label>
    <input tabindex="12" type="text" class="form-control" placeholder="Site Technician Name" id="smaster9" name="customerName" readonly />
</div>
<div class="col-md-4 form-group">
    <label>Site Technician Number : </label>
    <input tabindex="13" type="text" class="form-control" placeholder="Site Technician Number" id="smaster10" name="customerNumber" readonly />
</div>
<div class="col-md-4 form-group">
    <label>Segment : </label>
    <input tabindex="14" type="text" class="form-control" placeholder="Segment" id="smaster11" name="customerCategory" readonly />
</div>
<div class="col-md-4 form-group">
    <label>Site Type : </label>
    <input tabindex="15" type="text" class="form-control" placeholder="Site Type" id="smaster12" name="siteType" readonly />
</div>
<div class="col-md-4 form-group">
    <label>Customer Code : </label>
    <input tabindex="16" type="text" class="form-control" placeholder="Customer Code" id="smaster13" name="customerCode" readonly />
</div>
<div class="col-md-4 form-group">
    <label>cluster Manager Mail ID : </label>
    <input tabindex="17" type="text" class="form-control nocap" placeholder="cluster Manager Mail ID" id="smaster14" readonly />
</div>
<div class="col-md-4 form-group">
    <label>Product Code : </label>
    <input tabindex="18" type="text" class="form-control" placeholder="Product Code" id="smaster15" name="productCode" readonly />
</div>
</div>
<div class="col-md-4 form-group">
    <label>Nature Of Complaint : </label>
    <select tabindex="19" name="natureOfComplaint" class="form-control" id="natureOfComplaint">
    <option value="" disabled selected> Select Nature Of Activity First</option>
    </select>
</div>
<div class="col-md-4 form-group">
    <label>Complete Description : </label>
    <textarea tabindex="21" name="completeDesc" class="form-control" placeholder="Complete Description"></textarea>
</div>
<span class="ui-autocomplete-loading"></span>
<div class="form-group col-xs-12 morpad">
    <div class="col-xs-12">
    <button tabindex="22" type="submit" class="btn btn-primar ss_buttons" name="create">Submit</button>
	<button tabindex="23" type="button" class="btn btn-primar ss_buttons" name="reset" id="resetButton">Reset</button>   
	</div>
</div>
</form>
							<a href="#" class="back-2-top"><i class="glyphicon glyphicon-chevron-up"></i></a>
                        </div>
                    </div>
                </div><!-- Closing Of col-xs-12 -->
            <div class="col-sm-1 hidden-xs"></div>
        </div>
    </div><!-- Closing Of Body Container -->
    <script type="text/javascript" src="v1/js/jquery.min.js"></script>
    <script src="v1/js/bootstrap.min.js"></script>
	<script src="v1/js/bootstrapValidator.min.js"></script>
	<script src="v1/js/validation.js"></script>
	<script type="text/javascript" src="v1/js/jquery.autocomplete.js"></script>
	<script type="text/javascript" src="v1/js/jquery-ui-1.8.2.custom.min.js"></script>
    <script type="text/javascript" src="v1/js/moment.js"></script>
	<script type="text/javascript" src="v1/js/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript">
    function ajaxSelect(id, type) {
        if(id != ""){
            if(type.search(",") == "-1"){
                $.ajax({
                    type: "POST",
                    url: "v1/ajaxSelect.php",
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
                            url: "v1/ajaxSelect.php",
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
    function ajaxfit(id,type,tbna){var date="";
        if(tbna=='prwarr'){id=document.getElementById('ajaxSelect_CustomerName').value;date=document.getElementById('installDate').value;}
        if(id!=""){
            var links='type='+type+'&id='+id+'&tbna='+tbna+'&date='+date;
            $.ajax({
                type: "POST",
                url: "v1/ajaxfit.php",
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
    $(function(){ $(".tool").tooltip({placement : 'top'});
        $("#smaster0").keydown(function(e){if(e.keyCode==13)return false; if(e.keyCode == 8)for(var i = 1; i <= 15; i++){document.getElementById("smaster"+i).value = ''; } });
        $("#smaster0").autocomplete({
            source: "v1/autoLoad2.php", minLength: 1,
            select: function(event, ui) {
                var getUrl = ui.item.id;
                if(getUrl == 'Add Manually' ){  $("#add").html($("#app").html()); $(".tool").tooltip({placement : 'top'});
				$('#add').find('.form-control').each(function(){ $('#defaultForm').bootstrapValidator('addField', $(this).attr('name')); });
				//$('#defaultForm').bootstrapValidator('addField', $('#add').find('[name="siteID"],[name="siteName"],[name="zone"],[name="circle"],[name="cluster"],[name="district"],[name="noOfString"],[name="customerName"],[name="customerNumber"],[name="customerCategory"],[name="siteType"],[name="customerCode"],[name="productCode"],[name="siteAddress"],[name="clusterManagerName"],[name="clusterManagerNumber"],[name="clusterManagerMail"]'));
				$('#prodCat').change(function(){
					if($(this).val()==''){$("#siteType").html('<option value="" disabled selected>Select Site Type</option><option value="" disabled >First Select Segment</option>');}
					else if($(this).val() == '5169' ){$("#siteType").html('<option value="">Select Site Type</option><option value="AC3TR">AC3TR</option><option value="SL">SL</option>');}
					else{$("#siteType").html('<option value="">Select Site Type</option><option value="in">IN</option><option value="out">OUT</option>');}
				});
				
				$("#siteID").bind('keyup keypress',function(e){ if(e.keyCode==32){ return false; }
					$.ajax({
						type: "POST",
						url: "v1/ajaxSiteID.php",
						data: "siteID="+$(this).val(),
						cache: false,
						success: function(result){ result = result.replace(/^\s+|\s+$/gm,''); $('.errorP').html(result);
						if(result != ""){ $('button[type=submit]').prop('disabled',true);}else{$('button[type=submit]').prop('disabled',false);}}
					});
				});
				
				var sDate =  new Date('2000-01-01');
				var eDate = new Date();
				$('.singleDate').datetimepicker({format: 'YYYY-MM-DD'});
				$('.singleDateEnd').datetimepicker({format: 'YYYY-MM-DD',maxDate:eDate});
				$('.singleDateTime').datetimepicker({format: 'YYYY-MM-DD hh:mm:ss'});
				$('.singleDateTimeEnd').datetimepicker({format: 'YYYY-MM-DD hh:mm:ss',maxDate:eDate});
				$('#mfdDate').datetimepicker({format:'YYYY-MM-DD',maxDate:eDate,minDate:sDate});//.on("dp.change",function(e){$('#installDate').data("DateTimePicker").minDate(e.date);});
				$('#installDate').datetimepicker({format:'YYYY-MM-DD',maxDate:eDate,minDate:sDate});//.on("dp.change",function(e){$('#mfdDate').data("DateTimePicker").maxDate(e.date);});
				$("#mfdDate").on("dp.change",function(e){$('#installDate').data("DateTimePicker").minDate(e.date);});
				$("#installDate").on("dp.change",function(e){$('#mfdDate').data("DateTimePicker").maxDate(e.date);});
				}
                else{ 
                    var xyz = getUrl.split(",,");
                    for(var i = 0; i < xyz.length; i++){document.getElementById("smaster"+i).value = xyz[i];}
                }
            },html: true,open: function(event, ui) {$(".ui-autocomplete").css("z-index", 1000);}
        });
    });
    </script>
	<script type="text/javascript"> 
		$("#natureOfActivity").change(function(e){
			$.ajax({
				type: "POST",
				url: "v1/ajaxSiteID.php",
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
				jQuery('.back-2-top').fadeIn(duration);
			} else {
				jQuery('.back-2-top').fadeOut(duration);
			}
		});
		jQuery('.back-2-top').click(function(event) {
			event.preventDefault();
			jQuery('html, body').animate({scrollTop: 0}, duration);
			return false;
		})
	});
</script>
<div id="app" style="display:none">
    <div class="col-md-4 form-group">
        <label>Site ID : <i class="glyphicon glyphicon-question-sign tool" title="Type the Site ID"></i></label>
        <input tabindex="3" type="text" autofocus class="form-control fulcap" name="siteID" id="siteID" placeholder="Enter Site ID/ Coach Number" />
    </div>
    <div class="col-md-4 form-group">
        <label>Site Name : </label>
        <input tabindex="4" type="text" class="form-control" name="siteName" placeholder="Enter Site Name" />
    </div>
    <div class="col-md-4 form-group">
        <label>Zone : </label>
        <select tabindex="5" class="form-control" name="zone" onchange="ajaxSelect(this.options[this.selectedIndex].value,'Circle');">
        <option value="">select zone</option><?php zonesOptions(); ?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Circle : </label>
        <select tabindex="6" name="circle" class="form-control" id="ajaxSelect_Circle"  onchange="ajaxSelect(this.options[this.selectedIndex].value,'Cluster')">
        <option value="">Select Circle</option>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Cluster : </label>
        <select tabindex="7" name="cluster" class="form-control" id="ajaxSelect_Cluster" onchange="ajaxSelect(this.options[this.selectedIndex].value,'District')">
        <option value="">Select Cluster</option>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>District : </label>
        <select tabindex="8" name="district" class="form-control" id="ajaxSelect_District">
        <option value="">Select District</option>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Manufactured Date : </label>
        <input name="mfdDate" type='text' class="form-control" id='mfdDate' placeholder="YYYY-MM-DD" tabindex="9" contenteditable="false"/>
    </div>
    <div class="col-md-4 form-group">
        <label>Installation Date : </label>
        <input name="installDate" type='text' class="form-control" id='installDate' placeholder="YYYY-MM-DD" tabindex="10" contenteditable="false"/>
    </div>
    <div class="col-md-4 form-group">
        <label>No. of Strings : <i class="glyphicon glyphicon-question-sign tool" title="No of Battery banks connected"></i></label>
        <select tabindex="11" name="noOfString" class="form-control">
        <option value="">Select No. of String</option>
        <?php for($ns=1;$ns<=5;$ns++){echo "<option value='$ns'>$ns</option>";}?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Site Technician Name : </label>
        <input tabindex="11" type="text" class="form-control" name="customerName" placeholder="Enter Site Technician Name">
    </div>
    <div class="col-md-4 form-group">
        <label>Site Technician Number : </label>
        <input tabindex="11" type="text" class="form-control" name="customerNumber" placeholder="Enter Site Technician Number">
    </div>
    <div class="col-md-4 form-group">
        <label>Segment : </label>
        <select tabindex="11" name="customerCategory" class="form-control" id="prodCat" onchange="ajaxSelect(this.options[this.selectedIndex].value,'CustomerName')">
        <option value="">Select Segment</option><?php customerCategoryOption();?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Site Type : </label>
        <select tabindex="11" name="siteType" id="siteType" class="form-control">
        <option value="" disabled selected>Select Site Type</option>
        <option value="" disabled >First Select Segment</option>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Customer Code : </label>
        <select tabindex="11" name="customerCode" class="form-control" id="ajaxSelect_CustomerName" onchange="ajaxfit(this.options[this.selectedIndex].value,'schedule','smSchedule')" />
        <option value="">Select Customer Code</option>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Product Code : </label>
        <select tabindex="11" name="productCode" class="form-control" onchange="ajaxfit('gf','warranty','prwarr')">
        <option value="">Select Product Code</option><?php productCodeOption();?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Site Address : </label>
        <textarea tabindex="11" name="siteAddress" class="form-control" placeholder="Site Address"></textarea>
    </div>
    <div class="col-md-4 form-group">
    	<label>Cluster Manager Name : </label>
        <input tabindex="12" type="text" class="form-control" name="clusterManagerName" placeholder="Enter Cluster Manager Name">
    </div>
    <div class="col-md-4 form-group">
    	<label>Cluster Manager Number : </label>
        <input tabindex="13" type="text" class="form-control" name="clusterManagerNumber" placeholder="Enter Cluster Manager Number">
    </div>
    <div class="col-md-4 form-group">
    	<label>Cluster Manager Email : </label>
        <input tabindex="14" type="text" class="form-control nocap" name="clusterManagerMail" placeholder="Enter Cluster Manager Email">
    </div>
    <input tabindex="15" type="hidden" class="form-control"  name="scheduleDays" id="ajaxSelect_schedule">
    <input tabindex="16" type="hidden" class="form-control" name="warrantyMonths" id="ajaxSelect_warranty">
    <!--<input tabindex="17" type="hidden" class="form-control" name="warrantyLeft" id="ajaxSelect_warrantyLeft">-->
    <input tabindex="18" type="hidden" class="form-control" name="siteStatus" id="siteStatus">
    <!--<div class="col-md-4 form-group">
        <label>Preventive Maintenance Schedule : </label>
        <input tabindex="15" type="text" class="form-control"  name="scheduleDays" readonly id="ajaxSelect_schedule">
    </div>
    <div class="col-md-4 form-group">
        <label>Warranty Months : </label>
        <input tabindex="16" type="text" class="form-control" name="warrantyMonths" readonly id="ajaxSelect_warranty">
    </div>
    <div class="col-md-4 form-group" id="hidden">
        <label>Warranty Left : </label>
        <input tabindex="17" type="text" class="form-control" name="warrantyLeft" readonly id="ajaxSelect_warrantyLeft">
    </div>
    <div class="col-md-4 form-group">
        <label>Site Status : </label>
        <select tabindex="18" name="siteStatus" class="form-control" id="siteStatus">
        <option value="">Select Site Status</option>
        <option value="Warranty">Under Warranty</option>
        <option value="OutOfWarranty"> Out of Warranty</option>
        <option value="Amc"> AMC</option> 
        </select>
    </div>-->
</div>
</body>
</html>