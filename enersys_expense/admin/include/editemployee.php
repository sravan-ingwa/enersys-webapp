<?php 
session_start();
date_default_timezone_set("Asia/Kolkata");
if($_REQUEST['id']) $_SESSION['id']=$_REQUEST['id']; 
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Employee Details</h3>
	</div>
	<div class="panel-body">
        <form role="form" class="ss_form" method="post" id="defaultForm" novalidate>
        <?php if(isset($message))echo $message;?>
		<input type="hidden" value="qV9IPNva1M" name="role_alias" />
        <input type="hidden" value="RgPOOJAmsL" name="privilege_alias" />
        <input type="hidden" value="<?php echo $ref;?>" name="ref" />
        <input type="hidden" value="<?php echo $_SESSION['id'];?>" name="id" />
        <div class="col-md-4 form-group">
            <label>Employee ID : </label>
            <input class="form-control" autofocus="autofocus" tabindex="1" value="<?php echo employeeDetails('employee_id',$_SESSION['id']);?>" type="text" name="empId" placeholder="Employee ID" required="required"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Employee Name: </label>
            <input class="form-control" tabindex="2" type="text" value="<?php echo employeeDetails('name',$_SESSION['id']);?>" name="empName" placeholder="Employee Name" required="required"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Department: </label>
            <select class="form-control" tabindex="3" required="required" name="dep">
            	<option value="0" selected="selected" disabled="disabled">[Select Department]</option>
				<?php $listDgn=listdip();if($listDgn!=0){foreach($listDgn as $rec){echo "<option value='".$rec['alias']."' ".chexx($rec['alias'],employeeDetails('department_alias',$_SESSION['id'])).">".$rec['name']."</option>";}}else echo "<option disabled='disabled'>Add Department</option>";?>
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label>Designation: </label>
            <select class="form-control showAutofill" data-target="grade" tabindex="4" required="required" name="des">
			<option value="0" selected="selected" disabled="disabled">[Select Designation]</option>
			<?php $listDgn=listdgn();if($listDgn!=0){foreach($listDgn as $rec){echo "<option value='".$rec['alias']."' data-grade='".$rec['grade']."' ".chexx($rec['alias'],employeeDetails('designation_alias',$_SESSION['id']))." >".$rec['name']."</option>";}}else echo "<option disabled='disabled'>Add Designation</option>";?>
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label>Grade: </label>
            <input class="form-control grade" tabindex="5" type="text" value="<?php echo grade($_SESSION['id']);?>" name="grade" placeholder="Grade" readonly="readonly"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Date of Joining: </label>
            <input class="form-control datepicker" tabindex="5" type="text" name="doj" value="<?php echo date("d-m-Y", strtotime(employeeDetails('joining_date',$_SESSION['id'])));?>" placeholder="DD-MM-YYYY" required="required"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Email ID: </label>
            <input class="form-control nocap" tabindex="6" type="text" name="email" value="<?php echo employeeDetails('email_id',$_SESSION['id']);?>" placeholder="Email ID" required="required"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Mobile Number: </label>
            <input class="form-control" tabindex="7" type="text" name="mobile" value="<?php echo employeeDetails('mobile_number',$_SESSION['id']);?>" placeholder="Mobile Number" required="required"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Password: </label>
            <input class="form-control normalcap" tabindex="7" type="text" name="password" value="<?php echo employeeDetails('password',$_SESSION['id']);?>" placeholder="Password" required="required"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Cash card: </label>
            <input class="form-control" tabindex="7" type="text" name="ccard" value="<?php echo employeeDetails('cash_card',$_SESSION['id']);?>" placeholder="Cash Card"/>
        </div>
        <?php if(checkopbal($_SESSION['id'])==0){?>
        <div class="col-md-4 form-group">
            <label>Opening Balance: </label>
            <input class="form-control" tabindex="8" type="number" name="obal" placeholder="Opening Balance" required="required"/>
        </div>
        <?php }?>
        <div class="form-group col-xs-12 morpad">
            <div class="col-md-3">
             <input tabindex="9" type="submit" class="btn btn-primary ss_buttons updatex" name="addEmp" value="Update">
            <button tabindex="10" type="reset" class="btn btn-primary ss_buttons" name="Reset">Reset</button>
            </div>
        </div>
        </form>
	</div>
</div>
<?php
function chexx($fv1,$fv2){if($fv1==$fv2) return "selected='selected'";}
?>