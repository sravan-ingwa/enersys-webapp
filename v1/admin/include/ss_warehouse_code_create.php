<?php 
if(isset($_REQUEST['Create'])){
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
		$query=mysql_query("SELECT * FROM ss_warehouse_code WHERE whCode ='$a'");
		$count=mysql_num_rows($query);
		if($count==0){
			$id = checkx(rand(0000, 9999),'ss_warehouse_code');
			$ac = mysql_query("INSERT INTO ss_warehouse_code(id,whCode,whDesc,whAddress,zone,circle,empName,flag) value('$id','$a','$b','$c','$d','$e','$f','0')");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
		}else{$result=errorMsg('ERRMSG003');}
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
    <div class="col-md-4 form-group">
        <label>Zone</label>
        <select tabindex="1" autofocus="autofocus" class="form-control" name="zone" onchange="ajaxSelect(this.options[this.selectedIndex].value,'Circle')">
        <option value="">select zone</option><?php zonesOptions(); ?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Circle</label>
        <select tabindex="2" name="circle" class="form-control" id="ajaxSelect_Circle"  onchange="ajaxSelect(this.options[this.selectedIndex].value,'EmployeeName')">
        <option value="">Select Circle</option>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label> Employee Name</label>
        <select tabindex="3" name="empName" class="form-control" id="ajaxSelect_EmployeeName">
        <option value="">Select EmployeeName</option>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Warehouse Code</label>
        <input type="text" name="whCode" class="form-control" placeholder="Enter Warehouse Code" autocomplete="off" tabindex="4" autofocus="autofocus"/>
    </div>
    <div class="col-md-4 form-group">
        <label>Warehouse Description</label>
        <input type="text" name="whDesc" class="form-control" placeholder="Enter Warehouse Description" tabindex="5"/>
    </div>
    <div class="col-md-4 form-group">
        <label>Warehouse Address</label>
        <input type="text" name="whAddress" class="form-control" placeholder="Enter Warehouse Address" tabindex="6"/>
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="Create" tabindex="7">Add Warehouse</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="8">Reset</button>
        </div>
    </div>
</form>