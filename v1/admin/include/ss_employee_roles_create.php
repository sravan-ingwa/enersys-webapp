<?php 
if(isset($_REQUEST['Create'])){
	$a=mysql_escape_string($_REQUEST['role']);
	$b=mysql_escape_string($_REQUEST['description']);
	if($a==""){$result="Enter Employee Role";}
	elseif($b==""){$result="Enter Description";}
	else{
		$query=mysql_query("SELECT * FROM ss_employee_roles WHERE role ='$a'");
		$count=mysql_num_rows($query);
		if($count==0){
		$d = checkx(rand(0000, 9999),'ss_employee_roles');
		$ac = mysql_query("INSERT INTO ss_employee_roles(id,role,description,flag) value('$d','$a','$b','0')");
		if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
		}else{$result=errorMsg('ERRMSG003');}
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
    <div class="col-md-4 form-group">
        <label>Employee Role</label>
        <input tabindex="1" autofocus="autofocus" class="form-control" type="text" name="role" placeholder="Employee Role">
    </div>
    <div class="col-md-4 form-group">
        <label>Description</label>
        <input tabindex="2" type="text" name="description" class="form-control" placeholder="Description">
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="Create" tabindex="3">Create</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="4">Reset</button>
        </div>
    </div>
</form>