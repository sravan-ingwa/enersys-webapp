<?php
	date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['Create'])){
	$a=mysql_escape_string($_REQUEST['nameOfEmployee']);
	$b=mysql_escape_string($_REQUEST['empId']);	
	$c=mysql_escape_string($_REQUEST['advRequested']);
	$e=mysql_escape_string($_REQUEST['reasonForAdv']);
	$g=mysql_escape_string($_REQUEST['year']);
	$h=mysql_escape_string($_REQUEST['totalBalance']);
	$gg=explode("-",$g);
	$f=mysql_escape_string($gg[0]);
	$g=$gg[1]."-".$gg[2];
	if($a==""){$result="Enter name Of Employee";}
	elseif($b==""){$result="Select Employee ID";}
	elseif($c==""){$result="Enter Advance Requested";}
	elseif($e==""){$result="Enter Reason For Advance";}
	elseif($f==""){$result="Choose Advance For";}
	elseif($g==""){$result="Select Year";}
	else{
		$id = checkx(rand(0000, 9999),'ss_book_advance');
		$ac = mysql_query("INSERT INTO ss_book_advance(id,nameOfEmployee,empId,advRequested,reasonForAdv,advFor,year,totalBalance,stat,flag) VALUES('$id','$a','$b','$c','$e','$f','$g','$h','0','0')");
	if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
<div class="col-md-4 form-group">
    <label>Employee ID : </label>
    <select tabindex="1" autofocus="autofocus" name="empId" class="form-control selectpicker" onchange="ajaxBookAdvance(this.value)" data-live-search="true">
    <option value="" selected style="display:none;">Select Employee ID</option>
    <?php $sql = mysql_query("SELECT * FROM ss_employee_details WHERE designation <> '".designationGetId('ESCA')."'");
		if(mysql_num_rows($sql)>0){ while($row = mysql_fetch_array($sql)){ echo "<option value='".$row['id']."'>".$row['employeeId']."</option>"; }
		} ?>
    </select>
</div>
<div class="col-md-4 form-group">
    <label>Name of Employee : </label>
    <input tabindex="2" class="form-control" type="text" id="aba0" name="nameOfEmployee" placeholder="Name of Employee" readonly/>
</div>
<div class="col-md-4 form-group">
    <label>Advance For : </label>
    <input type="text" tabindex="3" name="year" class="form-control" value="<?php if(date('d')>=1 && date('d')<=15){echo "F1-";}else{echo "F2-";}echo date('F-Y'); ?>" readonly>
</div>
<div class="col-md-4 form-group">
    <label>Total Balance : </label>
    <input type="text" tabindex="4" name="totalBalance" class="form-control" id="aba1" readonly="readonly">
</div>
<div class="col-md-4 form-group">
    <label>Advance Requested : </label>
    <input type="text" tabindex="5" name="advRequested" class="form-control" placeholder="Advance Requested"/>
</div>
<div class="col-md-4 form-group">
    <label>Reason For Advance : </label>
    <textarea tabindex="6" class="form-control" name="reasonForAdv" placeholder="Reason For Advance"></textarea>
</div>
<div class="form-group col-xs-12 morpad">
    <div class="col-xs-12">
    <button tabindex="7" type="submit" class="btn btn-primary ss_buttons" name="Create">Submit</button>
    <button tabindex="8" type="reset" class="btn btn-primary ss_buttons" name="reset">Reset</button>
	</div>
</div>
</form>