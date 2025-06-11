<?php 

if(isset($_REQUEST['update'])){
	$a=mysql_escape_string($_REQUEST['zone']);
	$c=mysql_escape_string($_REQUEST['circle']);
	$e=ucfirst(mysql_escape_string($_REQUEST['cluster']));
	if($a==""){$result="Select Zone";}
	elseif($c==""){$result="Select Circle";}
	elseif($e==""){$result="Enter Cluster";}
	else{
		$RefId =$_REQUEST['y'];
		//$ac = mysql_query("INSERT INTO ss_clusters(id,cluster,zone,circle,description,flag) value('$d','$e','$a','$c','$b','0')");
		$ac = mysql_query("UPDATE ss_clusters SET cluster = '".$e."',zone='".$a."' , circle='".$c."' WHERE id='$RefId'");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
	}
}
$RefId =$_REQUEST['y'];
$query1=mysql_query("SELECT * FROM  ss_clusters WHERE id='$RefId'");
$row = mysql_fetch_array($query1);
?>
<p class="errorP"><?php if(isset($result)){echo $result;} ?> </p>

<form role="form" class="ss_form" method="post" id="defaultForm">
<input type="hidden" name="y" value="<?php echo $RefId;?>" />
    <div class="col-md-4 form-group">
        <label>Zone</label>
        <select tabindex="1" autofocus="autofocus" class="form-control" name="zone" onchange="ajaxSelect(this.options[this.selectedIndex].value,'Circle')">
            <option value="">select zone</option><?php explodeEdit($row['zone'],'ss_zone','zone');?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Circle</label>
        <select tabindex="2" name="circle" class="form-control" id="ajaxSelect_Circle"  onchange="ajaxSelect(this.options[this.selectedIndex].value,'Cluster')">
            <option value="">Select Circle</option><?php explodeEdit($row['circle'],'circleGetName','circle');?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Cluster</label>
        <input tabindex="3" type="text" class="form-control" name="cluster" placeholder="Enter Cluster" value="<?php echo $row['cluster']; ?>">
    </div>
    
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="update" tabindex="2">Update</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="3">Reset</button>
        </div>
    </div>
</form>
                        
                        