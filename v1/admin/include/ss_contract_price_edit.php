<?php
if(isset($_REQUEST['update'])){
	$a=mysql_escape_string($_REQUEST['escaName']);
	$b=mysql_escape_string($_REQUEST['zone']);	
	$c=mysql_escape_string($_REQUEST['circle']);
	$d=mysql_escape_string($_REQUEST['natureOfActivity']);
	$e=mysql_escape_string($_REQUEST['amount']);
	$f=mysql_escape_string($_REQUEST['unit']);

	if($a==""){$result="Enter esca Name";}
	elseif($b==""){$result="Enter Zone";}
	elseif($c==""){$result="Enter Circle";}
	elseif($d==""){$result="Enter Nature Of Activity";}
	elseif($e==""){$result="Enter Amount";}
	elseif($f==""){$result="Enter Unit";}
	else{
		$RefId =$_REQUEST['y'];
		$ac = mysql_query("UPDATE ss_contract_price SET escaName='$a',zone='$b',circle='$c',activity='$d',amount='$e',unit='$f' WHERE id='$RefId'");
	if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
	}
}
$RefId =$_REQUEST['y'];
$query1=mysql_query("SELECT * FROM ss_contract_price WHERE id='$RefId'");
$row = mysql_fetch_array($query1);
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
<div class="col-md-4 form-group">
    <label>ESCA Name : </label>
	<input type="text" tabindex="1" autofocus="autofocus" class="form-control" name="escaName" value="<?php echo $row['escaName']; ?>" placeholder="ESCA Name">
</div>
<div class="col-md-4 form-group">
    <label>Nature Of Activity : </label>
    <select tabindex="2" class="form-control" name="natureOfActivity">
    <option value=""> Select Nature Of Activity </option><?php explodeEdit($row['activity'],'ss_nature_of_activity','activity'); ?>
    </select>
</div>
<div class="col-md-4 form-group">
    <label>Zone</label>
    <select tabindex="3" class="form-control" name="zone" onchange="ajaxSelect(this.options[this.selectedIndex].value,'Circle')">
    <option value="">select zone</option><?php explodeEdit($row['zone'],'ss_zone','zone'); ?>
    </select>
</div>
<div class="col-md-4 form-group">
    <label>Circle</label>
    <select tabindex="4" name="circle" class="form-control" id="ajaxSelect_Circle"  onchange="ajaxSelect(this.options[this.selectedIndex].value,'Cluster')">
    <option value="">Select Circle</option><?php explodeEdit($row['circle'],'circleGetName','circle'); ?>
    </select>
</div>
<div class="col-md-4 form-group">
    <label>Amount : </label>
    <input type="text" tabindex="5" class="form-control" name="amount" value="<?php echo $row['amount']; ?>" placeholder="Amount">
</div>
<div class="col-md-4 form-group">
    <label>Unit : </label>
    <select tabindex="6" class="form-control" name="unit"><?php echo unit($row['unit']); ?></select>
</div>
<div class="form-group col-xs-12 morpad">
    <div class="col-xs-12">
    <button tabindex="7" type="submit" class="btn btn-primary ss_buttons" name="update">Update</button>
	<button tabindex="8" type="reset" class="btn btn-primary ss_buttons" name="reset">Reset</button>
	</div>
</div>
</form>
<?php function unit($val){
	if($val == "perBank"){echo "<option value=''>Select Unit</option><option value='$val' selected>Per Bank</option><option value='perSite'>Per Site</option>";}
	else{echo "<option value=''>Select Unit</option><option value='perBank'>Per Bank</option><option value='$val' selected>vPer Site</option>";}
	}?>