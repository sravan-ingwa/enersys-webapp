<?php 
if(isset($_REQUEST['Create'])){
	$a=mysql_escape_string($_REQUEST['zone']);
	$c=mysql_escape_string($_REQUEST['circle']);
	$e=mysql_escape_string($_REQUEST['cluster']);
	if($a==""){$result="Select Zone";}
	elseif($c==""){$result="Select Circle";}
	elseif($e==""){$result="Enter Cluster";}
	else{
		$query=mysql_query("SELECT * FROM ss_clusters WHERE zone ='$a' AND circle= '$c' AND cluster ='$e'");
		$count=mysql_num_rows($query);
		if($count==0){
		$d = checkx(rand(0000, 9999),'ss_clusters');
		$ac = mysql_query("INSERT INTO ss_clusters(id,cluster,zone,circle,flag) value('$d','$e','$a','$c','0')");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
		}else{$result=errorMsg('ERRMSG003');}
	}
}

?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
    <div class="col-md-4 form-group">
        <label>Zone</label>
        <select name="zone" onchange="ajaxSelect(this.options[this.selectedIndex].value,'Circle')" class="form-control" autofocus="autofocus" tabindex="1">
            <option value="">select zone</option><?php zonesOptions(); ?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Circle</label>
        <select name="circle" id="ajaxSelect_Circle"  onchange="ajaxSelect(this.options[this.selectedIndex].value,'Cluster')" class="form-control" tabindex="2">
            <option value="">Select Circle</option>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Cluster</label>
        <input type="text" name="cluster" class="form-control" placeholder="Cluster" autocomplete="off" tabindex="3">
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="Create" tabindex="4">Create</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="5">Reset</button>
        </div>
    </div>
</form>         