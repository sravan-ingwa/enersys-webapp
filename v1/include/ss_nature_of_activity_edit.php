<?php 
if(isset($_REQUEST['update'])){
	$a=strtoupper(mysql_escape_string($_REQUEST['code']));
	$b=mysql_escape_string($_REQUEST['activity']);
	if($a==""){$result="Enter Code";}
	elseif($b==""){$result="Enter activity";}
	else{
		$RefId =$_REQUEST['y'];
		$d = checkx(rand(0000, 9999),'ss_nature_of_activity');
		//$ac = mysql_query("INSERT INTO ss_nature_of_activity(id,code,activity,flag) value('$d','$a','$b','0')");
		$ac = mysql_query("UPDATE ss_nature_of_activity SET code = '".$a."',activity='".$b."' WHERE id='$RefId'");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
	}
}
$RefId =$_REQUEST['y'];
$query1=mysql_query("SELECT * FROM ss_nature_of_activity WHERE id='$RefId'");
$row = mysql_fetch_array($query1);
?>
<p class="errorP"><?php if(isset($result)){echo $result;} ?> </p>

<form role="form" class="ss_form" method="post" id="defaultForm">
<input type="hidden" name="y" value="<?php echo $RefId;?>" />
    <div class="col-md-4 form-group">
        <label>Code</label>
        <input tabindex="1" autofocus="autofocus" type="text" class="form-control fulcap" name="code" placeholder="Enter Code" value="<?php echo $row['code']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Activity</label>
        <input tabindex="2" type="text" name="activity" class="form-control" placeholder="Enter Activity" value="<?php echo $row['activity']; ?>">
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="update" tabindex="2">Update</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="3">Reset</button>
        </div>
    </div>
</form>