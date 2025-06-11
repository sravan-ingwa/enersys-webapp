<?php 
if(isset($_REQUEST['update'])){
	$a=mysql_escape_string($_REQUEST['zone']);
	$c=mysql_escape_string($_REQUEST['circle']);
	$e=mysql_escape_string($_REQUEST['cluster']);
	$f=ucfirst(mysql_escape_string($_REQUEST['district']));
	if($a==""){$result="Select Zone";}
	elseif($c==""){$result="Select Circle";}
	elseif($e==""){$result="Select Cluster";}
	elseif($f==""){$result="Enter District";}
	else{
		$RefId =$_REQUEST['y'];
		$ac = mysql_query("UPDATE ss_districts SET cluster = '".$e."',zone='".$a."' , circle='".$c."', district='".$f."' WHERE id='$RefId'");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
	}
}
$RefId =$_REQUEST['y'];
$query1=mysql_query("SELECT * FROM ss_districts WHERE id='$RefId'");
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
        <select tabindex="3" name="cluster" class="form-control" id="ajaxSelect_Cluster" onchange="ajaxSelect(this.options[this.selectedIndex].value,'District')">
            <option value="">Select Cluster</option><?php explodeEdit($row['cluster'],'clustersGetName','cluster');?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>District</label>
        <input tabindex="4" type="text" class="form-control" name="district" value="<?php echo $row['district']; ?>">
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="update" tabindex="5">Update</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="6">Reset</button>
        </div>
    </div>
</form>
                        
                        