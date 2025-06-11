<?php 
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['dep'])){
	if($_REQUEST['alevel']=='0'){$message="<p class='alert alert-danger' role='alert'>Select Level</p>";}
	else if($_REQUEST['dep']=='0'){$message="<p class='alert alert-danger' role='alert'>Select Department</p>";}
	else if($_REQUEST['aemp']=='0'){$message="<p class='alert alert-danger' role='alert'>Select Employee</p>";}
	else if($_REQUEST['adep']=='0'){$message="<p class='alert alert-danger' role='alert'>Select Department</p>";}
	else{	
		$date=date("Y-m-d");
		for($ax=0;$ax<count($_REQUEST['adep']);$ax++){
			$adep=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['adep'][$ax]));
			$alevel=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['alevel']));
			$dep=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['dep']));
			$molc=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['aemp']));
			if(alreadyexist_level($adep,$alevel,$mr_con)==0){
				$alias=aliasCheck(generateRandomString(),"ec_expense_approvals","approval_alias",$mr_con);
				$sql = "INSERT INTO ec_expense_approvals (approval_dep, approval_level, approver_dep, approver, approval_alias, created_date) VALUES ('".$adep."','".$alevel."','".$dep."','".$molc."','".$alias."','".$date."')";
				if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>New record created successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Error: Try Again</p>";
			}else $message="<p class='alert alert-danger' role='alert'>Already exist</p>";
		}
	}
}
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Approvals</h3>
	</div>
	<div class="panel-body">
 		<div class="col-md-6" >
        <div class="table-responsive">
            <table class="table table-bordered">
            <thead>
            <tr class="blue cust">
            <th>Department</th>
            <th>Approval Level</th>
            <th>Approver Department</th>
            <th>Approvers</th>
            <th>Options</th>
            </tr>
            </thead>
            <tbody>
            <?php 
            $listDgn=listApprovals();
            if($listDgn!=0){foreach($listDgn as $rec){echo "<tr><td>".$rec['approval_dep']."</td><td>".$rec['approval_level']."</td><td>".$rec['approver_dep']."</td><td>".$rec['name']."</td><td><a href='".$rec['alias']."' class='edis' data-type='editapprovals' title='Edit'>edit</a></td></tr>";}}
            else echo "<tr><td colspan='4' align='center'>No Approvers</td></tr>";
            ?>
            </tbody>
            </table>
		</div>                    
        </div>
        <div class="col-md-6" > 
            <form role="form" class="ss_form" method="post" id="defaultForm" novalidate>
             <?php if(isset($message))echo $message;?>
            <input type="hidden" value="<?php echo $ref;?>" name="ref" />
            <div class="col-md-6 form-group">
                <label>Approval for(Department): </label>
                <select class="form-control" tabindex="1" required="required" name="adep[]" id='mot3' multiple='multiple'>
                    <?php $listDgn=listdip();if($listDgn!=0){foreach($listDgn as $rec){echo "<option value='".$rec['alias']."'>".$rec['name']."</option>";}}else echo "<option disabled='disabled'>Add Department</option>";?>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label>Approval Level: </label>
                <select class="form-control" tabindex="1" required="required" name="alevel" onchange="approvalChek(this.options[this.selectedIndex].value,'aphine')">
                    <option value="0" selected="selected" >[Select Level]</option>
                    <option value="1">Approver Level</option>
                    <option value="2">HR Level</option>
                    <option value="3">Finance Level</option>
                    <option value="4">HOD Level</option>
                    <option value="5">MD Level</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label>Approver Department: </label>
                <select class="form-control showempbydep" tabindex="1" required="required" name="dep">
                    <option value="0" selected="selected" >[Select Department]</option>
                    <?php $listDgn=listdip();if($listDgn!=0){foreach($listDgn as $rec){echo "<option value='".$rec['alias']."'>".$rec['name']."</option>";}}else echo "<option disabled='disabled'>Add Department</option>";?>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label>Approval Employee</label>
                <p id="mot1"><input type="text" class="form-control" readonly="readonly" value="Select Department for employee" /></p>
            </div>
            <div class="form-group col-xs-12 morpad">
                <div class="col-md-6 col-md-offset-3">
                <input tabindex="3" type="submit" class="btn btn-primary ss_buttons ademp" name="addEmp" value="Add Approvals">
                <button tabindex="4" type="reset" class="btn btn-primary ss_buttons" name="Reset">Reset</button>
                </div>
            </div>
            </form>
        </div>
	</div>
</div>
<script>
$('#mot3').multiselect({includeSelectAllOption: true});
</script>