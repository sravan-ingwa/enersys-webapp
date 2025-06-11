<?php 
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['dep'])){
	if($_REQUEST['dep']!="" && $_REQUEST['grade']!=""){
		$date=date("Y-m-d");
		$dep=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['dep']));
		$grade=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['grade']));
		if(alreadyexist($dep,'ec_designation','designation',$mr_con)==0){
			$alias=aliasCheck(generateRandomString(),"ec_designation","designation_alias",$mr_con);
			$sql = "INSERT INTO ec_designation (designation,designation_alias,grade,created_date) VALUES ('".$dep."','".$alias."','".$grade."','".$date."')";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>New record created successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Error: Try Again</p>";
			$mr_con->close();
		}else $message="<p class='alert alert-danger' role='alert'>Already exist</p>";
	}else $message="<p class='alert alert-danger' role='alert'>Enter all Fields</p>";
}
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Designation</h3>
	</div>
	<div class="panel-body">
        <div class="col-md-6 form-group">
			<?php
            	$listDgn=listdgn();
				if($listDgn!=0){
					echo "<table class='table-bordered table'><tr><th>Designation</th><th>Grade</th><th>options</th></tr>";
					foreach($listDgn as $rec){echo "<tr><td>".$rec['name']."</td><td>".$rec['grade']."</td><td><a href='".$rec['alias']."' class='edis' data-type='editdesignation' title='Edit'>Edit</a></td></tr>";}
					echo "</table>";
				}else echo "<p align='center'>Start Adding Designations</p>";
			?>
        </div>
        <div class="col-md-6" align="center">
			<?php if(isset($message))echo $message;?>
            <form role="form" class="ss_form" method="post" id="defaultForm" novalidate>
            <input type="hidden" value="<?php echo $ref;?>" name="ref" />
            <div class="col-md-6 form-group" align="left">
                <label>Designation : </label>
                <input class="form-control" tabindex="1" type="text" name="dep" placeholder="Designation" required="required" autofocus="autofocus"/>
            </div>
            <div class="col-md-6 form-group" align="left">
                <label>Grade : </label>
                <input class="form-control" tabindex="2" type="text" name="grade" placeholder="Grade" required="required"/>
            </div>
            <div class="form-group col-xs-12 morpad">
                <input tabindex="9" type="submit" class="btn btn-primary ss_buttons ademp" name="addEmp" value="Add Designation">
                <button tabindex="10" type="reset" class="btn btn-primary ss_buttons" name="Reset">Reset</button>
            </div>
            </form>
        </div>
	</div>
</div>
