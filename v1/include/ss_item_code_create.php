<?php 
if(isset($_REQUEST['Create'])){
	$a=strtoupper(mysql_escape_string($_REQUEST['itemCode']));
	$b=mysql_escape_string($_REQUEST['itemDesc']);
	$c=mysql_escape_string($_REQUEST['price']);
	if($a==""){$result="Enter Item Code";}
	if($b==""){$result="Enter Item Description";}
	if($c==""){$result="Enter Price";}
	else{
		$query=mysql_query("SELECT * FROM ss_item_code WHERE itemCode ='$a'");
		$count=mysql_num_rows($query);
		if($count==0){
			$d = checkx(rand(0000, 9999),'ss_item_code');
			$ac = mysql_query("INSERT INTO ss_item_code(id,itemCode,itemDesc,price,flag) value('$d','$a','$b','$c','0')");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
		}else{$result=errorMsg('ERRMSG003');}
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
    <div class="col-md-4 form-group">
        <label>Item Code</label>
        <input type="text" tabindex="1" autofocus="autofocus" name="itemCode" class="form-control" placeholder="Enter Item Code" autocomplete="off"/>
    </div>
    <div class="col-md-4 form-group">
        <label>Item Description :</label>
        <textarea tabindex="2" name="itemDesc" class="form-control" placeholder="Item Description"></textarea>
    </div>
    <div class="col-md-4 form-group">
        <label>Price</label>
        <input type="text" tabindex="3" name="price" class="form-control" placeholder="Enter Price"/>
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="Create" tabindex="4">Add Item</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="5">Reset</button>
        </div>
    </div>
</form>