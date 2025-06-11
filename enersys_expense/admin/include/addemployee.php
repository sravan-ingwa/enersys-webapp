<?php 
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['empId'])){
	if($_REQUEST['empId']==""){$message="<p class='alert alert-danger' role='alert'>Enter Employee ID</p>";}
	else if($_REQUEST['empName']==""){$message="<p class='alert alert-danger' role='alert'>Enter Employee Name</p>";}
	else if(!isset($_REQUEST['dep'])&&$_REQUEST['dep']==0){$message="<p class='alert alert-danger' role='alert'>Select Department</p>";}
	else if(!isset($_REQUEST['des'])&&$_REQUEST['des']==0){$message="<p class='alert alert-danger' role='alert'>Select Designation</p>";}
	else if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['doj'])){$message="<p class='alert alert-danger' role='alert'>Select Date of Joining</p>";}
	else if(!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)){$message="<p class='alert alert-danger' role='alert'>Enter Email ID</p>";}
	else if(!preg_match("/^[789][0-9]{9}$/",$_REQUEST['mobile'])){$message="<p class='alert alert-danger' role='alert'>Enter Mobile Number</p>";}
	else if(!preg_match("/^[1-9][0-9]*$/",$_REQUEST['ccard'])){$message="<p class='alert alert-danger' role='alert'>Enter Only Numbers in Cash Card</p>";}
	else if(isset($_REQUEST['obal']) && !preg_match("/^[1-9][0-9]*$/",$_REQUEST['obal'])){$message="<p class='alert alert-danger' role='alert'>Enter Opening Balance</p>";}
	else{	
		$date=date("Y-m-d");
		$empId=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['empId']));
		if(alreadyexist($empId,'ec_employee_master','employee_id',$mr_con)==0){
			$empName=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['empName']));
			$dep=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['dep']));
			$des=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['des']));
			$doj=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['doj']))));
			$email=strtolower(mysqli_real_escape_string($mr_con,$_REQUEST['email']));
			$mobile=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mobile']));
			$password=$mobile;
			$ccard=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['ccard']));
			$role_alias=getvalues('2','ec_emprole','role_stat','role_alias');
			$privilege_alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['privilege_alias']));
			$alias=aliasCheck(generateRandomString(),"ec_employee_master","employee_alias",$mr_con);
			$sql = "INSERT INTO ec_employee_master (employee_id,name,department_alias,designation_alias,joining_date,email_id,mobile_number,password,employee_alias,role_alias,privilege_alias,created_date,cash_card) VALUES ('".$empId."','".$empName."','".$dep."','".$des."','".$doj."','".$email."','".$mobile."','".$password."','".$alias."','".$role_alias."','".$privilege_alias."','".$date."','".$ccard."')";
			if(isset($_REQUEST['obal'])){
				$obal=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['obal']));
				$rquestid="#".checkint(mt_rand(1000,999999999),'ec_advances','request_id');
				$alias_ad=aliasCheck(generateRandomString(),"ec_advances","advance_alias",$mr_con);
				$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias",$mr_con);
				$mr_con->query("INSERT INTO ec_advances(employee_alias,request_amount,total_amount,request_id,requested_date,advance_alias,approval_level) VALUES ('$alias','$obal','$obal','$rquestid','$date','$alias_ad','6')");
				$mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('Opening Balance','BA','$alias_ad','admin','$alias_remark')");
			}
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>New record created successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Error: Try Again</p>";
			$mr_con->close();
		}else $message="<p class='alert alert-danger' role='alert'>Employee Already exist</p>";
	}
}
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Employee Details</h3>
	</div>
	<div class="panel-body">
        <form role="form" class="ss_form" method="post" id="defaultForm" novalidate>
        <?php if(isset($message))echo $message;?>
        <input type="hidden" value="RgPOOJAmsL" name="privilege_alias" />
        <input type="hidden" value="<?php echo $ref;?>" name="ref" />
        <div class="col-md-4 form-group">
            <label>Employee ID : <span class="iderror label label-danger"></span></label>
            <input class="form-control empiid" autofocus="autofocus" tabindex="1" type="text" name="empId" placeholder="Employee ID" required="required" />
        </div>
        <div class="col-md-4 form-group">
            <label>Employee Name: </label>
            <input class="form-control" tabindex="2" type="text" name="empName" placeholder="Employee Name" required="required"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Department: </label>
            <select class="form-control" tabindex="3" required="required" name="dep">
            	<option value="0" selected="selected" disabled="disabled">[Select Department]</option>
				<?php $listDgn=listdip();if($listDgn!=0){foreach($listDgn as $rec){echo "<option value='".$rec['alias']."'>".$rec['name']."</option>";}}else echo "<option disabled='disabled'>Add Department</option>";?>
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label>Designation: </label>
            <select class="form-control showAutofill" data-target="grade" tabindex="4" required="required" name="des">
			<option value="0" selected="selected" disabled="disabled">[Select Designation]</option>
			<?php $listDgn=listdgn();if($listDgn!=0){foreach($listDgn as $rec){echo "<option value='".$rec['alias']."' data-grade='".$rec['grade']."'>".$rec['name']."</option>";}}else echo "<option disabled='disabled'>Add Designation</option>";?>
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label>Grade: </label>
            <input class="form-control grade" tabindex="5" type="text" name="grade" placeholder="Grade" readonly="readonly"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Date of Joining: </label>
            <input class="form-control datepicker" tabindex="5" type="text" name="doj" value="<?php echo date("d-m-Y");?>" placeholder="DD-MM-YYYY" required="required"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Email ID: </label>
            <input class="form-control nocap" tabindex="6" type="text" name="email" placeholder="Email ID" required="required"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Mobile Number: </label>
            <input class="form-control" tabindex="7" type="text" name="mobile" placeholder="Mobile Number" required="required"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Cash card: </label>
            <input class="form-control" tabindex="7" type="text" name="ccard" placeholder="Cash Card"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Opening Balance: </label>
            <input class="form-control" tabindex="8" type="number" name="obal" placeholder="Opening Balance" required="required"/>
        </div>
       <div class="form-group col-xs-12 morpad">
            <div class="col-md-3">
             <input tabindex="9" type="submit" class="btn btn-primary ss_buttons ademp" name="addEmp" value="Add Employee">
            <button tabindex="10" type="reset" class="btn btn-primary ss_buttons" name="Reset">Reset</button>
            </div>
        </div>
        </form>
	</div>
</div>
