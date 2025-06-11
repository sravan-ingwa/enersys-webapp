<?php 
if(isset($_REQUEST['update'])){
	$a=strtoupper(mysql_escape_string($_REQUEST['designation']));
	$b=mysql_escape_string($_REQUEST['description']);
	if($a==""){$result="Enter Designation";}
	elseif($b==""){$result="Enter Description";}
	else{

		$RefId =$_REQUEST['y'];
		//$ac = mysql_query("INSERT INTO ss_designation(id,designation,description,flag) value('$d','$a','$b','0')");
		$ac = mysql_query("UPDATE ss_designation SET designation='".$a."' , description='".$b."'  WHERE id='$RefId'");
		if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
	}
}
$RefId =$_REQUEST['y'];
$query1=mysql_query("SELECT * FROM ss_designation WHERE id='$RefId'");
$row = mysql_fetch_array($query1);
?>
<p class="errorP"><?php if(isset($result)){echo $result;} ?> </p>

<form role="form" class="ss_form" method="post" id="defaultForm">
<input type="hidden" name="y" value="<?php echo $RefId;?>" />
    <div class="col-md-4 form-group">
        <label>Designation</label>
        <input tabindex="1" autofocus="autofocus" type="text" class="form-control fulcap" name="designation" value="<?php echo $row['designation']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Description</label>
        <input tabindex="2" type="text" name="description" class="form-control" value="<?php echo $row['description']; ?>">
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="update" tabindex="3">Update</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="4">Reset</button>
        </div>
    </div>
</form>