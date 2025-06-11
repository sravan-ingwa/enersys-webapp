<?php 
if(isset($_REQUEST['Create'])){
	$a=strtoupper(mysql_escape_string($_REQUEST['stockCode']));
	$b=mysql_escape_string($_REQUEST['stockDesc']);
	if($a==""){$result="Enter Stock Code";}
	if($b==""){$result="Enter Stock Description";}
	else{
		$query=mysql_query("SELECT * FROM ss_stock_code WHERE stockCode ='$a'");
		$count=mysql_num_rows($query);
		if($count==0){
			$d = checkx(rand(0000, 9999),'ss_stock_code');
			$ac = mysql_query("INSERT INTO ss_stock_code(id,stockCode,stockDesc,flag) value('$d','$a','$b','0')");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
		}else{$result=errorMsg('ERRMSG003');}
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
    <div class="col-md-4 form-group">
        <label>Stock Code</label>
        <input type="text" name="stockCode" class="form-control"autocomplete="off" placeholder="Enter Stock Code" tabindex="1" autofocus="autofocus"/>
    </div>
    <div class="col-md-4 form-group">
        <label>Stock Description</label>
        <input type="text" name="stockDesc" class="form-control" placeholder="Enter Stock Description" tabindex="2"/>
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="Create" tabindex="3">Add Stock</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="4">Reset</button>
        </div>
    </div>
</form>