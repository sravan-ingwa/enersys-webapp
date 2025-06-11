<?php 
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['amt'])){
	if($_REQUEST['des']!="0" && !filter_var($_REQUEST['amt'], FILTER_VALIDATE_INT) === false){
		$date=date("Y-m-d");
		$dep=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['des']));
		$amt=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt']));
		if(alreadyexist($dep,'ec_expense_limits','designation_alias',$mr_con)==0){
			$alias=aliasCheck(generateRandomString(),"ec_expense_limits","limit_alias",$mr_con);
			$sql = "INSERT INTO ec_expense_limits (designation_alias,limit_amount,limit_alias,created_date) VALUES ('".$dep."','".$amt."','".$alias."','".$date."')";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>New record created successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Error: Try Again</p>";
			$mr_con->close();
		}else $message="<p class='alert alert-danger' role='alert'>Already exist</p>";
	}else $message="<p class='alert alert-danger' role='alert'>Enter all Fields</p>";
}
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Advance Limits</h3>
	</div>
	<div class="panel-body">
        <div class="col-md-6 form-group">
			<?php
            	$listlimt=listlimt();
				if($listlimt!=0){
					echo "<table class='table-bordered table'><tr><th>Designation</th><th>Amount</th><th>options</th></tr>";
					foreach($listlimt as $rec){echo "<tr><td>".$rec['name']."</td><td>".$rec['amount']."</td><td><a href='".$rec['alias']."' class='edis' data-type='editlimits' title='Edit'>Edit</a></td></tr>";}
					echo "</table>";
				}else echo "<p align='center'>Start Adding Advance Limits</p>";
			?>
        </div>
        <div class="col-md-6" align="center">
			<?php if(isset($message))echo $message;?>
            <form role="form" class="ss_form" method="post" id="defaultForm" novalidate>
            <input type="hidden" value="<?php echo $ref;?>" name="ref" />
            <div class="col-md-6 form-group" align="left">
                <label>Designation : </label>
                <select class="form-control" tabindex="4" required="required" name="des">
                    <option value="0" selected="selected" disabled="disabled">[Select Designation]</option>
                    <?php $listDgn=listdgn();if($listDgn!=0){foreach($listDgn as $rec){echo "<option value='".$rec['alias']."'>".$rec['name']."</option>";}}else echo "<option disabled='disabled'>Add Designation</option>";?>
                </select>
            </div>
            <div class="col-md-6 form-group" align="left">
                <label>Limit Amount(INR) : </label>
                <input class="form-control" tabindex="2" type="text" name="amt" placeholder="Amount" required="required"/>
                <p class="help-block">Ex: 100000</p>
            </div>
            <div class="form-group col-xs-12 morpad">
                <input tabindex="9" type="submit" class="btn btn-primary ss_buttons ademp" name="addEmp" value="Add Advance Limit">
                <button tabindex="10" type="reset" class="btn btn-primary ss_buttons" name="Reset">Reset</button>
            </div>
            </form>
        </div>
	</div>
</div>
