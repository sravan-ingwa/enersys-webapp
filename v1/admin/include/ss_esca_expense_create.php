<?php
if(isset($_REQUEST['Create'])){
	$a=mysql_escape_string($_REQUEST['escaName']);
	$b=mysql_escape_string($_REQUEST['invNumber']);	
	$c=mysql_escape_string($_REQUEST['invDate']);
	$d=mysql_escape_string($_REQUEST['natureOfActivity']);
	$e=mysql_escape_string($_REQUEST['ttNumber']);
	$f=mysql_escape_string($_REQUEST['basicValue']);
	$g=mysql_escape_string($_REQUEST['st']);
	$h=mysql_escape_string($_REQUEST['others']);
	$i=mysql_escape_string($_REQUEST['total']);
	$j=mysql_escape_string($_REQUEST['ESCARemarks']);

	if($a==""){$result="Choose ESCA Name";}
	elseif($b==""){$result="Enter Invoice Number";}
	elseif($c==""){$result="Enter Invoice Date";}
	elseif($d==""){$result="Select Nature Of Activity";}
	elseif($e==""){$result="Select TT Number";}
	elseif($g==""){$result="Enter Service tax % ";}
	elseif($j==""){$result="Enter ESCA Remarks";}
	else{
		$id = checkx(rand(0000, 9999),'ss_esca_expense');
		$sql = mysql_query("SELECT id FROM ss_esca_expense");
		$count = (mysql_num_rows($sql)+1);
		if($count > 999){$aa = "INV".$count;}elseif($count > 99){$aa = "INV0".$count;}elseif($count > 9){$aa = "INV00".$count;}else{$aa = "INV000".$count;}
		$ac = mysql_query("INSERT INTO ss_esca_expense(id,escaName,sysInvNumber,invNumber,invDate,natureOfActivity,ttNumber,basicValue,others,total,ESCARemarks,stat,flag) VALUES('$id','$a','$aa','$b','$c','$d','$e','$f','$h','$i','$j','0','0')");
	if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'view.php?x=".$_REQUEST['x']."&y=".$id."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
<div class="col-md-4 form-group">
    <label>ESCA Name : </label>
     <select tabindex="1" autofocus="autofocus" class="selectpicker form-control" name="escaName" data-live-search="true">
        <option value="" selected disabled style="display:none;">Select ESCA Name</option>
		<?php $query = mysql_query("SELECT id,employeeName FROM ss_employee_details WHERE designation='19' AND flag='0'");
			if(mysql_num_rows($query)>0){
				while($row=mysql_fetch_array($query)){echo "<option value='$row[id]'>$row[employeeName]</option>";}
				}else{echo "<option value=''>Add Contract Price First</option>"; }
		?>
      </select>
</div>
<div class="col-md-4 form-group">
    <label>Invoice Number : </label>
    <input type="text" tabindex="2" class="form-control" id="escaNm0" name="invNumber" placeholder="Invoice Number"/>
</div>
<div class="col-md-4 form-group">
    <label>Invoice Date : </label>
    <input type="text" tabindex="3" class="form-control singleDateEnd" id="escaNm1" name="invDate" placeholder="Invoice Date"/>
</div>
<div class="col-md-4 form-group">
    <label>Nature Of Activity : </label>
      <select class="form-control" name="natureOfActivity" tabindex="4" onchange="ajaxESCAActivity(this.value)">
        <option value=""> Select Nature Of Activity </option><?php echo natureOfActivityOption(); ?>
      </select>
</div>
<div class="col-md-4 form-group">
 <label>TT Number : </label>
  <select class="form-control escaAct" name="ttNumber" tabindex="5" multiple="multiple">
    <option value="" selected disabled>Select TT Number</option>
  </select>
</div>
<div class="col-md-4 form-group">
    <label>Basic Value : </label>
    <input type="text" tabindex="6" class="form-control" id="basicValue" name="basicValue" placeholder="Basic Value" readonly/>
</div>
<div class="col-md-4 form-group">
    <label>Service tax ( % ) : </label>
    <input type="text" tabindex="7" class="form-control" id="stPercent" value="12.36" name="st" placeholder="Percent"/>
</div>
<div class="col-md-4 form-group">
    <label>Others: </label>
    <input type="text" tabindex="8" class="form-control" id="others" name="others" placeholder="Others">
</div>
<div class="col-md-4 form-group">
    <label>Total : </label>
    <input type="text" tabindex="9" class="form-control" id="total" name="total" placeholder="Total" readonly >
</div>
<div class="col-md-4 form-group">
    <label>ESCA Remarks : </label>
    <textarea tabindex="10" class="form-control" name="ESCARemarks" placeholder="ESCA Remarks"></textarea>
</div>
<div class="form-group col-xs-12 morpad">
    <div class="col-xs-12">
    <button tabindex="11" type="submit" class="btn btn-primary ss_buttons" name="Create">Submit</button>
    <button tabindex="12" type="reset" class="btn btn-primary ss_buttons" name="reset">Reset</button>
	</div>
</div>
</form>