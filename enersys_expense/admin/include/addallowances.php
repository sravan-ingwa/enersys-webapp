<?php 
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['grade'])){
	if($_REQUEST['grade']=='0'){$message="<p class='alert alert-danger' role='alert'>Select Grade</p>";}
	else if($_REQUEST['mot']==0){$message="<p class='alert alert-danger' role='alert'>Select Mode of travel</p>";}
	else if($_REQUEST['molc']==0){$message="<p class='alert alert-danger' role='alert'>Select Mode of Local Conveyance</p>";}
	else if(filter_var($_REQUEST['amt1'], FILTER_VALIDATE_INT) === false){$message="<p class='alert alert-danger' role='alert'>Enter Lodging Allowances A+</p>";}
	else if(filter_var($_REQUEST['amt2'], FILTER_VALIDATE_INT) === false){$message="<p class='alert alert-danger' role='alert'>Enter Lodging Allowances A</p>";}
	else if(filter_var($_REQUEST['amt3'], FILTER_VALIDATE_INT) === false){$message="<p class='alert alert-danger' role='alert'>Enter Lodging Allowances B</p>";}
	else if(filter_var($_REQUEST['amt4'], FILTER_VALIDATE_INT) === false){$message="<p class='alert alert-danger' role='alert'>Enter Lodging Allowances C</p>";}
	else if(filter_var($_REQUEST['amt5'], FILTER_VALIDATE_INT) === false){$message="<p class='alert alert-danger' role='alert'>Enter Lodging Allowances A+</p>";}
	else if(filter_var($_REQUEST['amt6'], FILTER_VALIDATE_INT) === false){$message="<p class='alert alert-danger' role='alert'>Enter Lodging Allowances A</p>";}
	else if(filter_var($_REQUEST['amt7'], FILTER_VALIDATE_INT) === false){$message="<p class='alert alert-danger' role='alert'>Enter Lodging Allowances B</p>";}
	else if(filter_var($_REQUEST['amt8'], FILTER_VALIDATE_INT) === false){$message="<p class='alert alert-danger' role='alert'>Enter Lodging Allowances C</p>";}
	else if(filter_var($_REQUEST['amt9'], FILTER_VALIDATE_INT) === false){$message="<p class='alert alert-danger' role='alert'>Enter Mobile Roaming Charges</p>";}
	else{
		$date=date("Y-m-d");
		$grade=$_REQUEST['grade'];
		if(alreadyexist($grade,'ec_daily_allowances','grade',$mr_con)==0){
			$amt1=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt1']));
			$amt2=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt2']));
			$amt3=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt3']));
			$amt4=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt4']));
			$amt5=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt5']));
			$amt6=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt6']));
			$amt7=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt7']));
			$amt8=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt8']));
			$amt9=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt9']));
			$mot=strtoupper(mysqli_real_escape_string($mr_con,implode(", ",$_REQUEST['mot'])));
			$molc=strtoupper(mysqli_real_escape_string($mr_con,implode(", ",$_REQUEST['molc'])));
			$alias=aliasCheck(generateRandomString(),"ec_daily_allowances","allowance_alias",$mr_con);
			$sql = "INSERT INTO ec_daily_allowances (grade, lodging_allowances_a1, lodging_allowances_a, lodging_allowances_b, lodging_allowances_c, boarding_allowances_a1, boarding_allowances_a, boarding_allowances_b, boarding_allowances_c, mode_of_travel, mode_of_conveyance, mobile_roaming, allowance_alias, created_date) VALUES ('".$grade."','".$amt1."','".$amt2."','".$amt3."','".$amt4."','".$amt5."','".$amt6."','".$amt7."','".$amt8."','".$mot."','".$molc."','".$amt9."','".$alias."','".$date."')";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>New record created successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Error: Try Again</p>";
			$mr_con->close();
		}else $message="<p class='alert alert-danger' role='alert'>Already exist</p>";
	}
}
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Allowances</h3>
	</div>
	<div class="panel-body">
        <div class="col-md-8 col-md-offset-2" align="center">
			<?php if(isset($message))echo $message;?>
            <form role="form" class="ss_form" method="post" id="defaultForm" novalidate>
            <input type="hidden" value="<?php echo $ref;?>" name="ref" />
            <div class="col-md-4 col-md-offset-1 form-group" align="left">
                <label>Grade : </label>
                <select class="form-control showgradedesg" tabindex="1" required="required" name="grade" autofocus="autofocus">
                    <option value="0" selected="selected" disabled="disabled">[Select Grade]</option>
                    <?php $listDgn=listGrade();if($listDgn!=0){foreach($listDgn as $rec){echo "<option value='".$rec['grade']."'>".$rec['grade']."</option>";}}else echo "<option disabled='disabled'>Add Designation</option>";?>
                </select>
            </div>
            <div class="col-md-6 form-group" align="left">
                <label>Designations : </label>
                  <p id="desglist">Select grade to Know designations </p>
            </div>
			<div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Others</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-4 form-group" align="left">
                            <label>Mode of Travel</label>
                            <select class="form-control" tabindex="2" required="required" name="mot[]" id="mot" multiple="multiple">
                                <option>ACT</option>
                                <option>Air</option>
                                <option>Train 2nd AC</option>
                                <option>Train 3 tier</option>
                                <option>Train Sleeper</option>
                                <option>Volvo AC Bus</option>
                                <option>Non-AC Bus</option>
		                    </select>
                        </div>
                        <div class="col-md-4 form-group" align="left">
                            <label>Mode of Local Conveyance</label>
                            <select class="form-control" tabindex="3" required="required" name="molc[]" id="molc" multiple="multiple">
                                <option>ACT</option>
                                <option>Cab</option>
                                <option>Auto</option>
                                <option>Local Train</option>
                                <option>Any Public Transport</option>
		                    </select>
                        </div>
                        <div class="col-md-4 form-group" align="left">
                            <label>Mobile Roaming Charges</label>
                               <input class="form-control" tabindex="4" type="text" name="amt9" placeholder="Amount" required="required"/>
                        </div>
                    </div>
                </div>
            </div>
			<div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lodging Allowances</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-3 form-group" align="left">
                            <label>A+</label>
                               <input class="form-control" tabindex="5" type="text" name="amt1" placeholder="Amount" required="required"/>
                        </div>
                        <div class="col-md-3 form-group" align="left">
                            <label>A</label>
                               <input class="form-control" tabindex="6" type="text" name="amt2" placeholder="Amount" required="required"/>
                        </div>
                        <div class="col-md-3 form-group" align="left">
                            <label>B</label>
                               <input class="form-control" tabindex="7" type="text" name="amt3" placeholder="Amount" required="required"/>
                        </div>
                        <div class="col-md-3 form-group" align="left">
                            <label>C</label>
                               <input class="form-control" tabindex="8" type="text" name="amt4" placeholder="Amount" required="required"/>
                        </div>

                    </div>
                </div>
            </div>
			<div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Daily/Boarding Allowances</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-3 form-group" align="left">
                            <label>A+</label>
                               <input class="form-control" tabindex="9" type="text" name="amt5" placeholder="Amount" required="required"/>
                        </div>
                        <div class="col-md-3 form-group" align="left">
                            <label>A</label>
                               <input class="form-control" tabindex="10" type="text" name="amt6" placeholder="Amount" required="required"/>
                        </div>
                        <div class="col-md-3 form-group" align="left">
                            <label>B</label>
                               <input class="form-control" tabindex="11" type="text" name="amt7" placeholder="Amount" required="required"/>
                        </div>
                        <div class="col-md-3 form-group" align="left">
                            <label>C</label>
                               <input class="form-control" tabindex="12" type="text" name="amt8" placeholder="Amount" required="required"/>
                        </div>

                    </div>
                </div>
            </div>
            <div class="form-group col-xs-12 morpad">
                <input tabindex="13" type="submit" class="btn btn-primary ss_buttons ademp" name="addEmp" value="Add Allowances">
                <button tabindex="14" type="reset" class="btn btn-primary ss_buttons" name="Reset">Reset</button>
            </div>
            </form>
        </div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		window.prettyPrint() && prettyPrint();
		$('#molc').multiselect({includeSelectAllOption: true});
		$('#mot').multiselect({includeSelectAllOption: true});
	});
</script>