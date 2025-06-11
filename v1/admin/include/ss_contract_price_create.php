<?php
if(isset($_REQUEST['Create'])){
	$a=mysql_escape_string($_REQUEST['escaName']);
	$aa=mysql_escape_string($_REQUEST['escaDesc']);
	$b=zoneGetID(mysql_escape_string($_REQUEST['zone']));
	$c=circleGetID(mysql_escape_string($_REQUEST['circle']));
	$d=mysql_escape_string($_REQUEST['natureOfActivity']);
	$e=mysql_escape_string($_REQUEST['amount']);
	$f=mysql_escape_string($_REQUEST['unit']);

	if($a==""){$result="Enter ESCA Name";}
	elseif($aa==""){$result="Enter ESCA Description";}
	elseif($b==""){$result="Enter Zone";}
	elseif($c==""){$result="Enter Circle";}
	elseif($d==""){$result="Enter Nature Of Activity";}
	elseif($e==""){$result="Enter Amount";}
	elseif($f==""){$result="Enter Unit";}
	else{
		$id = checkx(rand(0000, 9999),'ss_contract_price');
		$ac = mysql_query("INSERT INTO ss_contract_price(id,escaName,escaDesc,zone,circle,activity,amount,unit,flag) VALUES('$id','$a','$aa','$b','$c','$d','$e','$f','0')");
	if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
<div class="col-md-4 form-group">
    <label>ESCA Name : </label>
	<select tabindex="1" class="form-control" autofocus="autofocus" name="escaName" onchange="ajaxEscaZoneCircle(this.options[this.selectedIndex].value)" >
    <option value=""> Select ESCA Name </option><?php echo escaNameOptionsInCP(); ?>
    </select>
</div>
<div class="col-md-4 form-group">
    <label>ESCA Description : </label>
    <input type="text" tabindex="1" class="form-control" name="escaDesc" placeholder="ESCA Description">
    <!--<textarea tabindex="1" class="form-control" name="escaDesc" placeholder="ESCA Description"></textarea>-->
</div>
<div class="col-md-4 form-group">
    <label>Nature Of Activity : </label>
    <select tabindex="2" class="form-control" name="natureOfActivity">
    <option value=""> Select Nature Of Activity </option><?php echo natureOfActivityOptionspl(); ?>
    </select>
</div>
<div class="col-md-4 form-group">
    <label>Zone</label>
    <input type="text" tabindex="3" class="form-control" name="zone" id="escaZC0" placeholder="Zone" readonly>
</div>
<div class="col-md-4 form-group">
    <label>Circle</label>
    <input type="text" tabindex="4" class="form-control" name="circle" id="escaZC1" placeholder="circle" readonly>
</div>
<div class="col-md-4 form-group">
    <label>Unit : </label>
    <select tabindex="5" class="form-control" name="unit">
    <option value="">Select Unit</option><option value="perBank">Per Bank</option><option value="perSite">Per Site</option>
    </select>
</div>
<div class="col-md-4 form-group">
    <label>Amount : </label>
    <input type="text" tabindex="6" class="form-control" name="amount" placeholder="Amount">
</div>
<div class="form-group col-xs-12 morpad">
    <div class="col-xs-12">
    <button tabindex="7" type="submit" class="btn btn-primary ss_buttons" name="Create">Submit</button>
    <button tabindex="8" type="reset" class="btn btn-primary ss_buttons" name="reset">Reset</button>
	</div>
</div>
</form>