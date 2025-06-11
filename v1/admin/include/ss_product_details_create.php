<?php 
if(isset($_REQUEST['Create'])){
	date_default_timezone_set("Asia/Kolkata"); 
	$a=mysql_escape_string($_REQUEST['BatteryRating']);
	$b=mysql_escape_string($_REQUEST['CellVoltage']);
	$c=mysql_escape_string($_REQUEST['CellRating']);
	$d=mysql_escape_string($_REQUEST['ProductCode']);
	$e= date('Y-m-d');
	if($a==""){$result="Enter Battery Rating";}
	elseif($b==""){$result="Enter Cell Voltage";}
	elseif($c==""){$result="Enter Cell Rating";}
	elseif($d==""){$result="Enter Product Code";}
	else{
		$query=mysql_query("SELECT * FROM ss_product_details WHERE productCode ='$d'");
		$count=mysql_num_rows($query);
		if($count==0){
			$id = checkx(rand(0000, 9999),'ss_product_details');
			$ac = mysql_query("INSERT INTO ss_product_details(id,batteryRating,cellVoltage,cellRating,productCode,createdDate,flag) value('$id','$a','$b','$c','$d','$e','0')");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
		}else{$result=errorMsg('ERRMSG003');}
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
    <div class="col-md-4 form-group">
        <label>Battery Rating</label>
        <input tabindex="1" autofocus="autofocus" class="form-control" type="text" name="BatteryRating" placeholder="Enter Battery Rating">
    </div>
    <div class="col-md-4 form-group">
        <label>Cell Voltage</label>
        <input tabindex="2" type="text" class="form-control" name="CellVoltage" placeholder="Enter Cell Voltage">
    </div>
    <div class="col-md-4 form-group">
        <label>Cell Rating</label>
        <input tabindex="3" type="text" class="form-control" name="CellRating" placeholder=" Enter Cell Rating">
    </div>
    <div class="col-md-4 form-group">
        <label>Product Code</label>
        <input tabindex="4" type="text" class="form-control" name="ProductCode" placeholder="Enter Product Code">
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="Create" tabindex="5">Create</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="6">Reset</button>
        </div>
    </div>
</form>