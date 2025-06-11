<?php 
if(isset($_REQUEST['Create'])){
	$a=mysql_escape_string($_REQUEST['zone']);
	$c=mysql_escape_string($_REQUEST['circle']);
	$e=mysql_escape_string($_REQUEST['cluster']);
	$f=ucfirst(mysql_escape_string($_REQUEST['district']));
	if($a==""){$result="Select Zone";}
	elseif($c==""){$result="Select Circle";}
	elseif($e==""){$result="Select Cluster";}
	elseif($f==""){$result="Enter District";}
	else{
		$query=mysql_query("SELECT * FROM ss_districts WHERE zone ='$a' AND circle= '$c' AND cluster ='$e' AND district='$f'");
		$count=mysql_num_rows($query);
		if($count==0){
		$d = checkx(rand(0000, 9999),'ss_districts');
		$ac = mysql_query("INSERT INTO ss_districts(id,district,zone,circle,cluster,flag) value('$d','$f','$a','$c','$e','0')");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
		}else{$result=errorMsg('ERRMSG003');}
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
    <div class="col-md-4 form-group">
        <label>Zone</label>
        <select name="zone" onchange="ajaxSelect(this.options[this.selectedIndex].value,'Circle')" class="form-control" placeholder="Zone" autocomplete="off" tabindex="1" autofocus="autofocus">
            <option value="">select zone</option><?php zonesOptions(); ?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Circle</label>
        <select tabindex="2" name="circle" class="form-control" id="ajaxSelect_Circle"  onchange="ajaxSelect(this.options[this.selectedIndex].value,'Cluster')">
            <option value="">Select Circle</option>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Cluster</label>
        <select tabindex="3" name="cluster" class="form-control" id="ajaxSelect_Cluster" onchange="ajaxSelect(this.options[this.selectedIndex].value,'District')">
            <option value="">Select Cluster</option>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>District</label>
        <input tabindex="4" type="text" class="form-control" name="district" placeholder="District">
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="Create" tabindex="5">Create</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="6">Reset</button>
        </div>
    </div>
</form>