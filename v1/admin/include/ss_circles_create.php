<?php 
if(isset($_REQUEST['Create'])){
	$a=mysql_escape_string($_REQUEST['zone']);
	$c=strtoupper(mysql_escape_string($_REQUEST['circle']));
	$b=mysql_escape_string($_REQUEST['description']);
	if($a==""){$result="Select Zone";}
	elseif($c==""){$result="Enter Circle Name";}
	elseif($b==""){$result="Enter Description";}
	else{
		$query=mysql_query("SELECT * FROM ss_circles WHERE zone ='$a' AND circle= '$c'");
		$count=mysql_num_rows($query);
		if($count==0){
		$d = checkx(rand(0000, 9999),'ss_circles');
		$ac = mysql_query("INSERT INTO ss_circles(id,zone,circle,description,flag) value('$d','$a','$c','$b','0')");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
		}else{$result=errorMsg('ERRMSG003');}
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
    <div class="col-md-4 form-group">
        <label>Zone</label>
        <select name="zone" class="form-control" autofocus="autofocus" tabindex="1"><option value="" selected="selected" disabled="disabled">[Select Zone]</option> <?php zonesOptions('');?></select>
    </div>
    <div class="col-md-4 form-group">
        <label>Circle</label>
        <input type="text" name="circle" class="form-control fulcap" placeholder="Circle" autocomplete="off" tabindex="2" />
    </div>
    <div class="col-md-4 form-group">
        <label>Description</label>
        <input type="text" name="description" class="form-control" placeholder="Description" autocomplete="off" tabindex="3" />
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="Create" tabindex="4">Create</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="5">Reset</button>
        </div>
    </div>
</form>