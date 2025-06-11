<?php 
if(isset($_REQUEST['update'])){
	$a=strtoupper(mysql_escape_string($_REQUEST['employeeId']));		$b=ucwords(mysql_escape_string($_REQUEST['employeeName']));
	$c=mysql_escape_string($_REQUEST['contactNo']);						$cb=strtolower(mysql_escape_string($_REQUEST['officialEmail']));
	$ca=strtolower(mysql_escape_string($_REQUEST['email']));			$d=mysql_escape_string($_REQUEST['designation']);
	$e=mysql_escape_string($_REQUEST['employeeRole']);					$f=mysql_escape_string(implode(", ",$_REQUEST['zone']));
	$i=mysql_escape_string($_REQUEST['base_location']);					$j=mysql_escape_string($_REQUEST['joiningDate']);
	$k=mysql_escape_string($_REQUEST['relievingDate']);					$l=mysql_escape_string($_REQUEST['createdBy']);
	$g=mysql_escape_string(implode(", ",$_REQUEST['circle']));			//$h=mysql_escape_string(implode(", ",$_REQUEST['cluster']));
	if($a==""){$result="Enter Employee Id";}
	elseif($b==""){$result="Enter Employee Name";}
	elseif($c==""){$result="Enter Contact No";}
	elseif($ca==""){$result="Enter Login Email";}
	elseif($d==""){$result="Enter Designation";}
	elseif($e==""){$result="Enter Employee Role";}
	elseif($f==""){$result="Enter Zone";}
	elseif($g==""){$result="Enter Circle";}
	//elseif($h==""){$result="Enter Cluster";}
	elseif($i==""){$result="Enter Base Location";}
	elseif($j==""){$result="Enter Joining Date";}
	elseif($l==""){$result="Enter Created By";}
	else{
		$RefId =$_REQUEST['y'];
		//$ac = mysql_query("INSERT INTO ss_employee_details(id,employeeId,employeeName,contactNo,designation,zones,circles,baseLocation,joiningDate,relievingDate,createdBy,employeeRole,flag) value('$id','$a','$b','$c','$d','$f','$g','$i','$j','$k','$l','$e','0')");
		$ac = mysql_query("UPDATE ss_employee_details SET employeeId = '".$a."',employeeName='".$b."',contactNo='".$c."',email='".$ca."',officialEmail='".$cb."',designation='".$d."',zone='".$f."',circle='".$g."',baseLocation='".$i."',joiningDate='".$j."',relievingDate='".$k."',createdBy='".$l."',employeeRole='".$e."' WHERE id='$RefId'");
		$ac1 = mysql_query("UPDATE ss_user_details SET displayName='".$b."',email='".$ca."',contact='".$c."' WHERE empDetailsId=$RefId");
		if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 2000 ); </script>";else $result=errorMsg('ERRMSG002');
	}
}
$RefId =$_REQUEST['y'];
$query1=mysql_query("SELECT * FROM  ss_employee_details WHERE id='$RefId'");
$row = mysql_fetch_array($query1);
?>
<p class="errorP"><?php if(isset($result)){echo $result;} ?> </p>

<form role="form" class="ss_form" method="post" id="defaultForm">
<input type="hidden" name="y" value="<?php echo $RefId;?>" />
    <div class="col-md-4 form-group">
        <label>Employee ID</label>
        <input tabindex="1" autofocus="autofocus" type="text" class="form-control fulcap" name="employeeId" value="<?php echo $row['employeeId']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Employee Name</label>
        <input tabindex="2" type="text" name="employeeName" class="form-control" value="<?php echo $row['employeeName']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>contact No.</label>
        <input tabindex="3" type="text" name="contactNo" class="form-control" value="<?php echo $row['contactNo']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Login Email</label>
        <input tabindex="3" type="text" name="email" class="form-control nocap" value="<?php echo $row['email']; ?>">
    </div>
	<?php if($row['designation']!='19'){ ?>
    <div class="col-md-4 form-group">
        <label>Official Email</label>
        <input tabindex="4" type="text" name="officialEmail" class="form-control nocap" value="<?php echo $row['officialEmail']; ?>">
    </div>
	<?php } ?>
    <div class="col-md-4 form-group">
        <label>Designation</label>
        <select tabindex="4" name="designation" class="form-control" ><option value="">[Select Designation]</option><?php explodeEdit($row['designation'],'ss_designation','designation'); ?></select>
    </div>
    <div class="col-md-4 form-group">
        <label>Employee Role</label>
        <select tabindex="5" name="employeeRole" class="form-control" ><option value="">[Select Employee Role]</option><?php explodeEdit($row['employeeRole'],'ss_employee_roles','role'); ?></select>
    </div>
    <div class="col-md-4 form-group">
        <label>Zone: </label>
        <select tabindex="6" name="zone[]" multiple="multiple" class="form-control" id="zoneSelect"  onchange="ajaxSelectmulti(this.id,'Circle');">
            <option value="" disabled>select Zone</option><?php explodeEdit($row['zone'],'ss_zone','zone');?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Circle : </label>
        <select tabindex="7" name="circle[]" multiple="multiple" class="form-control" id="ajaxSelect_Circle" onchange="ajaxSelectmulti(this.id,'Cluster');">
            <option value="" disabled>select circles</option><?php explodeEdit($row['circle'],'circleGetName','circle');?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Base Location</label>
        <input type='text' name="base_location" class="form-control" tabindex="9" value="<?php echo $row['baseLocation'];?>"/>
		<!--<select tabindex="9" name="base_location[]" class="form-control" multiple="multiple" id="ajaxSelect_District">
            <option value="" disabled="disabled">Select District</option>
        </select>-->
    </div>
    <div class="col-md-4 form-group">
        <label>Joining Date : </label>
        <input tabindex="10" type='text' name="joiningDate"class="form-control fulcap" id='mfdDate'  value="<?php echo $row['joiningDate']; ?>"/>
    </div>
    <div class="col-md-4 form-group">
        <label>Relieving Date : </label>
        <input tabindex="11"  type='text' name="relievingDate"class="form-control fulcap" id='installDate' placeholder="YYYY-MM-DD" value="<?php if($row['relievingDate']!='0000-00-00')echo $row['relievingDate']; ?>"/>
    </div>
    <div class="col-md-4 form-group">
        <label>created By: </label>
        <input tabindex="12" type="text" name="createdBy" class="form-control" value="<?php echo $row['createdBy']; ?>"/>
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="update" tabindex="13">Update</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="14">Reset</button>
        </div>
    </div>
</form>
