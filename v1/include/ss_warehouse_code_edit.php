<?php 
if(isset($_REQUEST['update'])){
	$a=strtoupper(mysql_escape_string($_REQUEST['whCode']));
	$b=mysql_escape_string($_REQUEST['whDesc']);
	$c=mysql_escape_string($_REQUEST['whAddress']);
	$d=mysql_escape_string($_REQUEST['zone']);
	$e=mysql_escape_string($_REQUEST['circle']);
	$f=mysql_escape_string($_REQUEST['empName']);
	if($a==""){$result="Enter Warehouse Code";}
	elseif($b==""){$result="Enter Warehouse Description";}
	elseif($c==""){$result="Enter Warehouse Address";}
	elseif($d==""){$result="Choose Zone";}
	elseif($e==""){$result="Choose Circle";}
	elseif($f==""){$result="Choose Employee Name";}
	else{
		$RefId =$_REQUEST['y'];
		//$ac = mysql_query("INSERT INTO ss_warehouse_code(id,whCode,whDesc,evCode,flag) value('$d','$a','$b','$c','0')");
		$ac = mysql_query("UPDATE ss_warehouse_code SET whCode='$a', whDesc='$b', whAddress='$c', zone='$d', circle='$e', empName='$f' WHERE id='$RefId'");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
	}
}
$RefId =$_REQUEST['y'];
$query1=mysql_query("SELECT * FROM ss_warehouse_code WHERE id='$RefId'");
$row = mysql_fetch_array($query1);
?>
<p class="errorP"><?php if(isset($result)){echo $result;} ?></p>

<form role="form" class="ss_form" method="post" id="defaultForm">
<input type="hidden" name="y" value="<?php echo $RefId;?>" />
    <div class="col-md-4 form-group">
        <label>Zone</label>
        <select tabindex="1" autofocus="autofocus" class="form-control" name="zone" onchange="ajaxSelect(this.options[this.selectedIndex].value,'Circle')">
        <option value="">select zone</option><?php explodeEdit($row['zone'],'ss_zone','zone'); ?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Circle</label>
        <select tabindex="2" name="circle" class="form-control" id="ajaxSelect_Circle"  onchange="ajaxSelect(this.options[this.selectedIndex].value,'EmployeeName')">
        <option value="">Select Circle</option><?php explodeEdit($row['circle'],'circleGetName','circle');?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label> Employee Name</label>
        <select tabindex="3" name="empName" class="form-control" id="ajaxSelect_EmployeeName">
        <option value="">Select EmployeeName</option><?php employeeOptionEdit($row['empName']); ?>
        </select>
    </div>
        <div class="col-md-4 form-group">
        <label>Warehouse Code</label>
        <input type="text" name="whCode" class="form-control" placeholder="Enter Warehouse Code" autocomplete="off" tabindex="4" value="<?php echo $row['whCode']; ?>"/>
    </div>
    <div class="col-md-4 form-group">
        <label>Warehouse Description</label>
        <input type="text" name="whDesc" class="form-control" placeholder="Enter Warehouse Description" tabindex="5" value="<?php echo $row['whDesc']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Warehouse Address</label>
        <input type="text" name="whAddress" class="form-control" placeholder="Enter Warehouse Address" tabindex="6" value="<?php echo $row['whAddress']; ?>">
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
        <button tabindex="7" type="submit" class="btn btn-primary ss_buttons" name="update">Update</button>
		<button tabindex="8" type="button" class="btn btn-primary ss_buttons" name="reset" onClick="window.location.reload(true);">Reset</button>   
    	</div>
    </div>
</form>