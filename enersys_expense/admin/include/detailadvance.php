<?php
if($_REQUEST['id']) $_SESSION['id']=$_REQUEST['id']; 
$resultz=advancefullView($_SESSION['id']);
$remarks=getRemarks($resultz[0]['advance_alias'],'BA');
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Details of Request Id: <?php echo $resultz[0]['request_id'];?></h3>
	</div>
	<div class="panel-body">
        <div class='row'>
	        <div class='col-md-12'>
    		    <div class='col-md-5 bs-callout'>
        			<h4>Request Id</h4>
        			<p><?php echo $resultz[0]['request_id'];?></p>
        		</div>
    		    <div class='col-md-5 bs-callout'>
        			<h4>Requested Date</h4>
        			<p><?php echo $resultz[0]['requested_date'];?></p>
        		</div>
    		    <div class='col-md-5 bs-callout'>
        			<h4>Employee Id</h4>
        			<p><?php echo employeeDetails('employee_id',$resultz[0]['employee_alias']);?></p>
        		</div>
        		<div class='col-md-5 bs-callout'>
        			<h4>Employee Name</h4>	
        			<p><?php echo employeeDetails('name',$resultz[0]['employee_alias']);?></p>
        		</div>
        		<div class='col-md-5 bs-callout'>
        			<h4>Department</h4>
        			<p><?php echo alias(employeeDetails('department_alias',$resultz[0]['employee_alias']),'ec_department','department_alias','department_name');?></p>
        		</div>
        		<div class='col-md-5 bs-callout'>
        			<h4>Designation</h4>
        			<p><?php echo alias(employeeDetails('designation_alias',$resultz[0]['employee_alias']),'ec_designation','designation_alias','designation');?></p>
        		</div>
        		<div class='col-md-5 bs-callout'>
        			<h4>Grade</h4>
        			<p><?php echo alias(employeeDetails('designation_alias',$resultz[0]['employee_alias']),'ec_designation','designation_alias','grade');?></p>
        		</div>
        		<div class='col-md-5 bs-callout'>
        			<h4>Previous Advance not settled</h4>
        			<p><?php echo advanceNotSettled($resultz[0]['employee_alias']);?></p>
        		</div>
        		<div class='col-md-5 bs-callout'>
        			<h4>Request Amount</h4>
        			<p><?php echo $resultz[0]['request_amount'];?></p>
        		</div>
        		<div class='col-md-5 bs-callout'>
        			<h4>Avaliable Amount</h4>
        			<p><?php echo $resultz[0]['total_amount'];?></p>
        		</div>
                <?php if($remarks!=0){?>
                    <div class='col-md-11 bs-callout'>
                        <?php foreach($remarks as $remk){?>
                        <div class="col-md-6 form-group">
                            <h4>Remarks: <small>(By <?php echo employeeDetails('name',$remk['remarked_by']);?>, On: <?php echo date("d-M-Y", strtotime($remk['remarked_on']));?>)</small></h4>
                            <p ><?php echo $remk['remarks'];?></p>
                        </div>
                        <?php }?>
                    </div>
                <?php }?>
        	</div>
        </div>
    </div>
<div>
