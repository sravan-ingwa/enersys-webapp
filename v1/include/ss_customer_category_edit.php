<?php 
if(isset($_REQUEST['update'])){
	$a=mysql_escape_string($_REQUEST['category']);
	if($a==""){$result="Enter Customer Category";}
	else{
		$efId=$_REQUEST['y'];
		//$ac = mysql_query("INSERT INTO ss_customer_category(id,category,flag) value('$d','$a','0')");
		$ac = mysql_query("UPDATE ss_customer_category SET category='".$a."' WHERE id='$efId'");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
	}
}
$RefId =$_REQUEST['y'];
$query1=mysql_query("SELECT * FROM ss_customer_category WHERE id='$RefId'");
$row = mysql_fetch_array($query1);
?>
<p class="errorP"><?php if(isset($result)){echo $result;} ?> </p>

<form role="form" class="ss_form" method="post" id="defaultForm">
<input type="hidden" name="y" value="<?php echo $RefId;?>" />
    <div class="col-md-4 form-group">
        <label>Customer Category</label>
        <input tabindex="1" autofocus="autofocus" class="form-control" type="text" name="category" value="<?php echo $row['category']; ?>">
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="update" tabindex="2">Update</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="3">Reset</button>
        </div>
    </div>
</form>