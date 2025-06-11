<?php 
if(isset($_REQUEST['Create'])){
	$a=strtoupper(mysql_escape_string($_REQUEST['fault']));
	$b=mysql_escape_string($_REQUEST['description']);
	if($a==""){$result="Enter Fault Code";}
	elseif($b==""){$result="Enter Description";}
	else{
		$query=mysql_query("SELECT * FROM ss_fault_code WHERE fault ='$a'");
		$count=mysql_num_rows($query);
		if($count==0){
			$d = checkx(rand(0000, 9999),'ss_fault_code');
			$ac = mysql_query("INSERT INTO ss_fault_code(id,fault,description,flag) value('$d','$a','$b','0')");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
		}else{$result=errorMsg('ERRMSG003');}
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
    <div class="col-md-4 form-group">
        <label>Fault Code</label>
        <input tabindex="1" autofocus="autofocus" class="form-control fulcap" type="text" name="fault" placeholder="Enter Fault Code">
    </div>
    <div class="col-md-4 form-group">
        <label>Description</label>
        <input tabindex="2" type="text" name="description" class="form-control" placeholder="Enter Description">
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="Create" tabindex="3">Create</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="4">Reset</button>
        </div>
    </div>
</form>