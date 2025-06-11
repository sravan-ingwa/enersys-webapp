<?php 
if(isset($_REQUEST['Create'])){
	$a=strtoupper(mysql_escape_string($_REQUEST['code']));
	$b=mysql_escape_string($_REQUEST['activity']);
	if($a==""){$result="Enter Code";}
	elseif($b==""){$result="Enter activity";}
	else{
		$query=mysql_query("SELECT * FROM ss_nature_of_activity WHERE code ='$a' AND activity='$b'");
		$count=mysql_num_rows($query);
		if($count==0){
			$d = checkx(rand(0000, 9999),'ss_nature_of_activity');
			$ac = mysql_query("INSERT INTO ss_nature_of_activity(id,code,activity,flag) value('$d','$a','$b','0')");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
		}else{$result=errorMsg('ERRMSG003');}
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
    <div class="col-md-4 form-group">
        <label>Code</label>
        <input tabindex="1" autofocus="autofocus" class="form-control fulcap" type="text" name="code" placeholder="Activity Code">
    </div>
    <div class="col-md-4 form-group">
        <label>Activity</label>
        <input tabindex="2" type="text" class="form-control" name="activity" placeholder="Nature of Activity">
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="Create" tabindex="3">Create</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="4">Reset</button>
        </div>
    </div>
</form>