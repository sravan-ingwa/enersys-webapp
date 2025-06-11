<?php 
if(isset($_REQUEST['update'])){
	$a=mysql_escape_string($_REQUEST['zone']);
	$c=strtoupper(mysql_escape_string($_REQUEST['circle']));
	$b=mysql_escape_string($_REQUEST['description']);
	if($a==""){$result="Select Zone";}
	elseif($c==""){$result="Enter Circle Name";}
	elseif($b==""){$result="Enter Description";}
	else{
		$RefId =$_REQUEST['y'];
		$ac = mysql_query("UPDATE ss_circles SET zone='$a' , circle='$c' , description='$b' WHERE id='$RefId'");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
	}
}
$RefId =$_REQUEST['y'];
$query1=mysql_query("SELECT * FROM ss_circles WHERE id='$RefId'");
$row = mysql_fetch_array($query1);
?>
<p class="errorP"><?php if(isset($result)){echo $result;} ?></p> 

<form role="form" class="ss_form" method="post" id="defaultForm">
    <input type="hidden" name="y" value="<?php echo $RefId;?>" />
	<div class="col-md-4 form-group">
        <label>Zone</label>
        <select tabindex="1" autofocus="autofocus" class="form-control" name="zone"><option value="">[Select Zone]</option><?php explodeEdit($row['zone'],'ss_zone','zone');?></select>
        
    </div>
    <div class="col-md-4 form-group">
        <label>Circle</label>
        <input tabindex="2" type="text" name="circle" class="form-control fulcap" value="<?php echo $row['circle']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Description</label>
        <input tabindex="3" type="text" name="description" class="form-control" value="<?php echo $row['description']; ?>">
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="update" tabindex="4">Update</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="5">Reset</button>
        </div>
    </div>
</form>