<?php 
if(isset($_REQUEST['Create'])){
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
		$query=mysql_query("SELECT * FROM ss_employee_details WHERE employeeId ='$a' AND flag='0'");
		$count=mysql_num_rows($query);
		if($count==0){
		$id = checkx(rand(0000, 9999),'ss_employee_details');
		$ac = mysql_query("INSERT INTO ss_employee_details(id,employeeId,employeeName,contactNo,email,officialEmail,designation,zone,circle,baseLocation,joiningDate,relievingDate,createdBy,employeeRole,flag) value('$id','$a','$b','$c','$ca','$cb','$d','$f','$g','$i','$j','$k','$l','$e','0')");
		if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
		}else{$result=errorMsg('ERRMSG003');}
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
    <div class="col-md-4 form-group">
        <label>Employee ID</label>
        <input tabindex="1" autofocus="autofocus" type="text" class="form-control fulcap" name="employeeId" placeholder="Enter Employee Id">
    </div>
    <div class="col-md-4 form-group">
        <label>Employee Name</label>
        <input tabindex="2" type="text" name="employeeName" class="form-control" placeholder="Enter Employee Name">
    </div>
    <div class="col-md-4 form-group">
        <label>contact No.</label>
        <input tabindex="3" type="text" name="contactNo" class="form-control" placeholder="Enter contact No.">
    </div>
    <div class="col-md-4 form-group">
        <label>Login Email</label>
        <input tabindex="3" type="text" name="email" class="form-control nocap" placeholder="Enter Login Email Id">
    </div>
    <div class="col-md-4 form-group">
        <label>Designation</label>
        <select tabindex="4" name="designation" class="form-control" ><option value="">[Select Designation]</option><?php echo designationOption();?></select>
    </div>
    <div class="col-md-4 form-group">
        <label>Employee Role</label>
        <select tabindex="5" name="employeeRole" class="form-control" ><option value="">[Select Employee Role]</option><?php echo employeeRoleOption();?></select>
    </div>
    <span id="officialMail"></span>
    <div class="col-md-4 form-group">
        <label>Zone</label>
        <select tabindex="6" name="zone[]" class="form-control" multiple="multiple" id="zoneSelect"  onchange="ajaxSelectmulti(this.id,'Circle')">
            <option value="" disabled="disabled">select zone</option><?php zonesOptions(); ?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Circle</label>
        <select tabindex="7" name="circle[]" multiple="multiple" class="form-control" id="ajaxSelect_Circle"  onchange="ajaxSelectmulti(this.id,'Cluster')">
            <option value="" disabled="disabled">Select Circle</option>
        </select>
    </div>
    <!--<div class="col-md-4 form-group">
        <label>Cluster</label>
        <select tabindex="8" name="cluster[]" multiple="multiple" class="form-control" id="ajaxSelect_Cluster" onchange="ajaxSelectmulti(this.id,'District')">
            <option value="" disabled="disabled">Select Cluster</option>
        </select>
    </div>-->
    <div class="col-md-4 form-group">
        <label>Base Location</label>
        <input type='text' name="base_location" class="form-control" tabindex="9"/>
		<!--<select tabindex="9" name="base_location[]" class="form-control" multiple="multiple" id="ajaxSelect_District">
            <option value="" disabled="disabled">Select District</option>
        </select>-->
    </div>
    <div class="col-md-4 form-group">
        <label>Joining Date : </label>
        <input type='text' name="joiningDate"class="form-control fulcap" id='mfdDate' placeholder="YYYY-MM-DD" tabindex="10"/>
    </div>
    <div class="col-md-4 form-group">
        <label>Relieving Date : </label>
         <input type='text' name="relievingDate"class="form-control fulcap" id='installDate' placeholder="YYYY-MM-DD" tabindex="11"/>
    </div>
    <div class="col-md-4 form-group">
        <label>created By: </label>
        <input tabindex="12" type="text" name="createdBy" class="form-control" placeholder="Enter created By" value="Admin" readonly="readonly"/>
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="Create" tabindex="13">Create</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="14">Reset</button>
        </div>
    </div>
</form>