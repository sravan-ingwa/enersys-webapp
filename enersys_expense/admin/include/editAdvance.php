<?php 
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['id']) && $_REQUEST['id']!="")$_SESSION['id']=$_REQUEST['id']; 
$advList=advancefullView($_SESSION['id']);
$remarks=getRemarks($advList[0]['advance_alias'],'BA');
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Advance Request</h3>
	</div>
	<div class="panel-body">
        <form role="form" class="ss_form" method="post" id="defaultForm" novalidate>
        <p class='alerta' role='alert'></p>
        <?php if(isset($message))echo $message;?>
        <input type="hidden" value="<?php echo $ref;?>" name="ref" />
        <input type="hidden" value="<?php echo $advList[0]['advance_alias'];?>" name="id" />
        <div class="col-md-4 form-group">
            <label>Date of Request : </label>
            <input class="form-control" type="text" value="<?php if($advList[0]['approval_level1']>0){echo $advList[0]['requested_date'];}else echo date('d-m-Y'); ?>" placeholder="Date of Request"  readonly="readonly"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Employee ID : </label>
            <input class="form-control" type="text" value="<?php echo employeeDetails('employee_id',$advList[0]['employee_alias']);?>" placeholder="Employee ID"  readonly="readonly"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Employee Name: </label>
            <input class="form-control" type="text" value="<?php echo employeeDetails('name',$advList[0]['employee_alias']);?>" placeholder="Employee Name"  readonly="readonly"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Grade: </label>
            <input class="form-control" type="text"value="<?php echo grade($advList[0]['employee_alias'])?>" placeholder="Grade"  readonly="readonly"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Credit Limit: </label>
            <input class="form-control limitinh" name="creditlimit" type="text" value="<?php echo advancelimit($advList[0]['employee_alias']);?>" placeholder="Credit Limit"  readonly="readonly"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Previous Advances Not Settled (amt): </label>
            <input class="form-control" type="text" name="advanceNotSettled" value="<?php if (advanceNotSettled($advList[0]['employee_alias'])!=0)echo advanceNotSettled($advList[0]['employee_alias']); else echo "No pending Advances";?>" placeholder="Previous Advances Not Settled"  readonly="readonly"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Current Request (amt): </label>
            <input type="text" tabindex="1" name="advRequested" value="<?php echo $advList[0]['request_amount'];?>" class="form-control amtt currentRequest" placeholder="Current Request" autofocus autocomplete="off" />
        </div>
        <div class="col-md-4 form-group">
            <label>Toatl outstanding Advance + Current Request: </label>
            <input type="text"  class="form-control tadv" value="<?php echo (advanceNotSettled($advList[0]['employee_alias'])+$advList[0]['request_amount']);?>" placeholder="Total Advance" readonly="readonly"/>
        </div>

        <?php if($remarks!=0){foreach($remarks as $remk){?>
	        <div class="col-md-4 form-group">
                <label>Remarks: <small>(By <?php echo employeeDetails('name',$remk['remarked_by']);?>, On: <?php echo date("d-M-Y", strtotime($remk['remarked_on']));?>)</small></label>
                <textarea tabindex="2" class="form-control" placeholder="Reason/ Remarks" readonly="readonly"><?php echo $remk['remarks'];?></textarea>
	        </div>
        <?php }}?>
        <div class="col-md-4 col-md-offset-4">
            <input tabindex="13" type="submit" class="btn btn-primary ss_buttons updatex" name="approve" value="Update Advance">
        </div>
        </form>
	</div>
</div>