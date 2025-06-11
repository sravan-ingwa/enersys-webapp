<?php 
if(isset($_REQUEST['update'])){
	$a=strtoupper(mysql_escape_string($_REQUEST['stockCode']));
	$b=mysql_escape_string($_REQUEST['stockDesc']);
	if($a==""){$result="Enter Stock Code";}
	if($b==""){$result="Enter Stock Description";}
	else{
		$RefId =$_REQUEST['y'];
		//$ac = mysql_query("INSERT INTO ss_stock_code(id,stockCode,stockDesc,flag) value('$d','$a','$b','0')");
		$ac = mysql_query("UPDATE ss_stock_code SET stockCode='$a', stockDesc='$b' WHERE id='$RefId'");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
	}
}
$RefId =$_REQUEST['y'];
$query1=mysql_query("SELECT * FROM ss_stock_code WHERE id='$RefId'");
$row = mysql_fetch_array($query1);
?>
<p class="errorP"><?php if(isset($result)){echo $result;} ?> </p>

<form role="form" class="ss_form" method="post" id="defaultForm">
<input type="hidden" name="y" value="<?php echo $RefId;?>" />
        <div class="col-md-4 form-group">
        <label>Stock Code</label>
		<input type="text" name="stockCode" class="form-control"autocomplete="off" placeholder="Enter Stock Code" tabindex="1" value="<?php echo $row['stockCode']; ?>" autofocus="autofocus"/>
    </div>
    <div class="col-md-4 form-group">
        <label>Stock Description</label>
        <input type="text" name="stockDesc" class="form-control" placeholder="Enter Stock Description" tabindex="2" value="<?php echo $row['stockDesc']; ?>"/>
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
        <button tabindex="3" type="submit" class="btn btn-primary ss_buttons" name="update">Update</button>
		<button tabindex="4" type="button" class="btn btn-primary ss_buttons" name="reset" onClick="window.location.reload(true);">Reset</button>   
    	</div>
    </div>
</form>