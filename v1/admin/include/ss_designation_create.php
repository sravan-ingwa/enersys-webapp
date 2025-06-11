<?php 
if(isset($_REQUEST['Create'])){
	$a=strtoupper(mysql_escape_string($_REQUEST['designation']));
	$b=mysql_escape_string($_REQUEST['description']);
	if($a==""){$result="Enter Designation";}
	elseif($b==""){$result="Enter Description";}
	else{
		$query=mysql_query("SELECT * FROM ss_designation WHERE designation ='$a'");
		$count=mysql_num_rows($query);
		if($count==0){
		$d = checkx(rand(0000, 9999),'ss_designation');
		$ac = mysql_query("INSERT INTO ss_designation(id,designation,description,flag) value('$d','$a','$b','0')");
		if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
		}else{$result=errorMsg('ERRMSG003');}
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
    <div class="col-md-4 form-group">
        <label>Designation</label>
        <input tabindex="1" autofocus="autofocus" class="form-control fulcap" type="text" name="designation" placeholder="Enter Designation">
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