<?php 
if(isset($_REQUEST['Create'])){
	$a=mysql_escape_string($_REQUEST['category']);
	if($a==""){$result="Enter Customer Category";}
	else{
		$query=mysql_query("SELECT * FROM ss_customer_category WHERE category ='$a'");
		$count=mysql_num_rows($query);
		if($count==0){
			$d = checkx(rand(0000, 9999),'ss_customer_category');
			$ac = mysql_query("INSERT INTO ss_customer_category(id,category,flag) value('$d','$a','0')");
			if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
		}else{$result=errorMsg('ERRMSG003');}
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
    <div class="col-md-4 form-group">
        <label>Customer Category</label>
        <input type="text" name="category" class="form-control" placeholder="Customer Category">
    </div>
   <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="Create" tabindex="2">Create</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="3">Reset</button>
        </div>
    </div>
</form>