<?php 
session_start();
date_default_timezone_set("Asia/Kolkata");
if($_REQUEST['id']) $_SESSION['id']=$_REQUEST['id']; 
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Employee Details of <?php echo employeeDetails('name',$_SESSION['id']);?></h3>
	</div>
	<div class="panel-body">
        <div class='row'>
	        <div class='col-md-12'>
    		    <div class='col-md-5 bs-callout'>
        			<h4>Employee Id</h4>
        			<p><?php echo employeeDetails('employee_id',$_SESSION['id']);?></p>
        		</div>
    		    <div class='col-md-5 bs-callout'>
        			<h4>Employee Name</h4>
        			<p><?php echo employeeDetails('name',$_SESSION['id']);?></p>
        		</div>
    		    <div class='col-md-5 bs-callout'>
        			<h4>Department</h4>
        			<p><?php echo departnment(employeeDetails('department_alias',$_SESSION['id']));?></p>
        		</div>
    		    <div class='col-md-5 bs-callout'>
        			<h4>Designation</h4>
        			<p><?php echo designation(employeeDetails('designation_alias',$_SESSION['id']));?></p>
        		</div>
    		    <div class='col-md-5 bs-callout'>
        			<h4>Grade</h4>
        			<p><?php echo grade($_SESSION['id']);?></p>
        		</div>
    		    <div class='col-md-5 bs-callout'>
        			<h4>Email Id</h4>
        			<p><?php echo employeeDetails('email_id',$_SESSION['id']);?></p>
        		</div>
    		    <div class='col-md-5 bs-callout'>
        			<h4>Mobile Number</h4>
        			<p><?php echo employeeDetails('mobile_number',$_SESSION['id']);?></p>
        		</div>
    		    <div class='col-md-5 bs-callout'>
        			<h4>Date of Joining</h4>
        			<p><?php echo employeeDetails('joining_date',$_SESSION['id']);?></p>
        		</div>
    		    <?php if(employeeDetails('relieving_date',$_SESSION['id'])!="0000-00-00"){?>
                <div class='col-md-5 bs-callout'>
        			<h4>Date of Relieving</h4>
        			<p><?php echo employeeDetails('relieving_date',$_SESSION['id']);?></p>
        		</div>
                <?php }?>
			</div>
		</div>        
	</div>
</div>
