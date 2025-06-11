<?php 
if(isset($_REQUEST['update'])){
	date_default_timezone_set("Asia/Kolkata"); 
	$a=mysql_escape_string($_REQUEST['BatteryRating']);
	$b=mysql_escape_string($_REQUEST['CellVoltage']);
	$c=mysql_escape_string($_REQUEST['CellRating']);
	$d=mysql_escape_string($_REQUEST['ProductCode']);
	if($a==""){$result="Enter Battery Rating";}
	elseif($b==""){$result="Enter Cell Voltage";}
	elseif($c==""){$result="Enter Cell Rating";}
	elseif($d==""){$result="Enter Product Code";}
	else{

			$RefId =$_REQUEST['y'];
			$ac = mysql_query("UPDATE ss_product_details SET batteryRating = '".$a."',cellVoltage = '".$b."',cellRating = '".$c."',productCode = '".$d."' WHERE id='$RefId'");
			if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
	}
}
$RefId =$_REQUEST['y'];
$query1=mysql_query("SELECT * FROM ss_product_details WHERE id='$RefId'");
$row = mysql_fetch_array($query1);
?>
<p class="errorP"><?php if(isset($result)){echo $result;} ?></p> 
<form role="form" class="ss_form" method="post" id="defaultForm">
<input type="hidden" name="y" value="<?php echo $RefId;?>" />
    <div class="col-md-4 form-group">
        <label>Battery Rating</label>
        <input tabindex="1" autofocus="autofocus" class="form-control" type="text" name="BatteryRating"value="<?php echo $row['batteryRating']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Cell Voltage</label>
        <input tabindex="2" type="text" class="form-control" name="CellVoltage" value="<?php echo $row['cellVoltage']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Cell Rating</label>
        <input tabindex="3" type="text" class="form-control" name="CellRating" value="<?php echo $row['cellRating']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Product Code</label>
        <input tabindex="4" type="text" class="form-control" name="ProductCode" value="<?php echo $row['productCode']; ?>">
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="update" tabindex="5">Update</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="6">Reset</button>
        </div>
    </div>
</form>