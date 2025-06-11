<?php 
if(isset($_REQUEST['update'])){
	$a=strtoupper(mysql_escape_string($_REQUEST['itemCode']));
	$b=mysql_escape_string($_REQUEST['itemDesc']);
	$c=mysql_escape_string($_REQUEST['price']);
	if($a==""){$result="Enter Item Code";}
	if($b==""){$result="Enter Item Description";}
	if($c==""){$result="Enter Price";}
	else{
		$RefId =$_REQUEST['y'];
		//$ac = mysql_query("INSERT INTO ss_item_code(id,itemCode,itemDesc,price,flag) value('$d','$a','$b','$c','0')");
		$ac = mysql_query("UPDATE ss_item_code SET itemCode='$a', itemDesc='$b', price='$c' WHERE id='$RefId'");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
	}
}
$RefId =$_REQUEST['y'];
$query1=mysql_query("SELECT * FROM ss_item_code WHERE id='$RefId'");
$row = mysql_fetch_array($query1);
?>
<p class="errorP"><?php if(isset($result)){echo $result;} ?> </p>

<form role="form" class="ss_form" method="post" id="defaultForm">
<input type="hidden" name="y" value="<?php echo $RefId;?>" />
        <div class="col-md-4 form-group">
        <label>Item Code</label>
        <input type="text" tabindex="1" autofocus="autofocus" name="itemCode" class="form-control" placeholder="Enter Item Code" autocomplete="off" value="<?php echo $row['itemCode']; ?>"/>
    </div>
    <div class="col-md-4 form-group">
        <label>Item Description :</label>
        <textarea tabindex="2" name="itemDesc" value="<?php echo $row['itemDesc']; ?>" class="form-control" placeholder="Item Description"></textarea>
    </div>
    <div class="col-md-4 form-group">
        <label>Price</label>
        <input type="text" tabindex="3" name="price" class="form-control" placeholder="Enter Price" value="<?php echo $row['price']; ?>"/>
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
        <button tabindex="4" type="submit" class="btn btn-primary ss_buttons" name="update">Update</button>
		<button tabindex="5" type="button" class="btn btn-primary ss_buttons" name="reset" onClick="window.location.reload(true);">Reset</button>   
    	</div>
    </div>
</form>