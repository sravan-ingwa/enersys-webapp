<?php 
if(isset($_REQUEST['update'])){
	$a=mysql_escape_string($_REQUEST['activity']);
	$b=ucwords(mysql_escape_string($_REQUEST['complaint']));
	if($a==""){$result="Choose Nature Of Activity";}
	elseif($b==""){$result="Enter Complaint";}
	else{
		$RefId =$_REQUEST['y'];
		//$ac = mysql_query("INSERT INTO ss_nature_of_complaint(id,complaint,flag) value('$d','$a','0')");
		$ac = mysql_query("UPDATE ss_nature_of_complaint SET activity='$a', complaint='$b' WHERE id='$RefId'");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
	}
}
$RefId =$_REQUEST['y'];
$query1=mysql_query("SELECT * FROM ss_nature_of_complaint WHERE id='$RefId'");
$row = mysql_fetch_array($query1);
?>
<p class="errorP"><?php if(isset($result)){echo $result;} ?> </p>

<form role="form" class="ss_form" method="post" id="defaultForm">
<input type="hidden" name="y" value="<?php echo $RefId;?>" />
     <div class="col-md-4 form-group">
        <label>Nature of Activity</label>
        <select tabindex="1" autofocus="autofocus" class="form-control" name="activity"><option value="">Select Nature Of Activity</option><?php echo explodeEdit($row['activity'],'ss_nature_of_activity','activity'); ?></select>
    </div>
    <div class="col-md-4 form-group">
        <label>Nature of Complaint</label>
        <input tabindex="2" type="text" class="form-control" name="complaint" placeholder="Enter Complaint" value="<?php echo $row['complaint']; ?>">
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="update" tabindex="3">Update</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="4">Reset</button>
        </div>
    </div>
</form>