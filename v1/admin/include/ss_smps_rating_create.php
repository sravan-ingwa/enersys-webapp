<?php 
if(isset($_REQUEST['Create'])){
	$a=mysql_escape_string($_REQUEST['rating']);
	$b=mysql_escape_string($_REQUEST['manufacturer']);
	if($a==""){$result="Enter SMPS Rating";}
	elseif($b==""){$result="Enter Manufacturer";}
	else{
		$query=mysql_query("SELECT * FROM ss_smps_rating WHERE rating ='$a'");
		$count=mysql_num_rows($query);
		if($count==0){
			$d = checkx(rand(0000, 9999),'ss_smps_rating');
			$ac = mysql_query("INSERT INTO ss_smps_rating(id,rating,manufacturer,flag) value('$d','$a','$b','0')");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
		}else{$result=errorMsg('ERRMSG003');}
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
    <div class="col-md-4 form-group">
        <label>SMPS Rating</label>
        <input tabindex="1" autofocus="autofocus" class="form-control" type="text" name="rating" placeholder="SMPS Rating">
    </div>
    <div class="col-md-4 form-group">
        <label>SMPS Manufacturer</label>
        <input tabindex="1" autofocus="autofocus" type="text" class="form-control" name="manufacturer" value="<?php echo $row['manufacturer']; ?>">
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="Create" tabindex="2">Create</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="3">Reset</button>
        </div>
    </div>
</form>