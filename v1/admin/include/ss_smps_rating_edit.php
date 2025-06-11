<?php 
if(isset($_REQUEST['update'])){
	$a=mysql_escape_string($_REQUEST['rating']);
	$b=mysql_escape_string($_REQUEST['manufacturer']);
	if($a==""){$result="Enter SMPS Rating";}
	elseif($b==""){$result="Enter Manufacturer";}
	else{
			$RefId =$_REQUEST['y'];
			//$ac = mysql_query("INSERT INTO ss_smps_rating(id,rating,flag) value('$d','$a','0')");
			$ac = mysql_query("UPDATE ss_smps_rating SET rating = '".$a."', manufacturer='".$b."' WHERE id='$RefId'");
			if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
	}
}
$RefId =$_REQUEST['y'];
$query1=mysql_query("SELECT * FROM ss_smps_rating WHERE id='$RefId'");
$row = mysql_fetch_array($query1);
?>
<p class="errorP"><?php if(isset($result)){echo $result;} ?> </p>

<form role="form" class="ss_form" method="post" id="defaultForm">
<input type="hidden" name="y" value="<?php echo $RefId;?>" />
    <div class="col-md-4 form-group">
        <label>SMPS Rating</label>
        <input tabindex="1" autofocus="autofocus" type="text" class="form-control" name="rating" value="<?php echo $row['rating']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>SMPS Manufacturer</label>
        <input tabindex="1" autofocus="autofocus" type="text" class="form-control" name="manufacturer" value="<?php echo $row['manufacturer']; ?>">
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="update" tabindex="2">Update</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="3">Reset</button>
        </div>
    </div>-
</form>