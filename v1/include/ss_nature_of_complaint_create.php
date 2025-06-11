<?php 
if(isset($_REQUEST['Create'])){
	$a=mysql_escape_string($_REQUEST['activity']);
	$b=ucwords(mysql_escape_string($_REQUEST['complaint']));
	if($a==""){$result="Choose Nature Of Activity";}
	elseif($b==""){$result="Enter Complaint";}
	else{
		$query=mysql_query("SELECT * FROM ss_nature_of_complaint WHERE complaint ='$b'");
		$count=mysql_num_rows($query);
		if($count==0){
			$d = checkx(rand(0000, 9999),'ss_nature_of_complaint');
			$ac = mysql_query("INSERT INTO ss_nature_of_complaint(id,activity,complaint,flag) value('$d','$a','$b','0')");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
		}else{$result=errorMsg('ERRMSG003');}
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
     <div class="col-md-4 form-group">
        <label>Nature of Activity</label>
        <select tabindex="1" autofocus="autofocus" class="form-control" name="activity"><option value="">Select Nature Of Activity</option><?php echo natureOfActivityOption(); ?></select>
    </div>
    <div class="col-md-4 form-group">
        <label>Nature of Complaint</label>
        <input tabindex="2" class="form-control" type="text" name="complaint" placeholder="Enter Complaint">
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="Create" tabindex="3">Create</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="4">Reset</button>
        </div>
    </div>
</form>