<?php 
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['dep'])){
	if($_REQUEST['dep']!=""){
		$date=date("Y-m-d");
		$dep=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['dep']));
		if(alreadyexist($dep,'ec_department','department_name',$mr_con)==0){
			$alias=aliasCheck(generateRandomString(),"ec_department","department_alias",$mr_con);
			$sql = "INSERT INTO ec_department (department_name,department_alias,created_date) VALUES ('".$dep."','".$alias."','".$date."')";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>New record created successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Error: Try Again</p>";
			$mr_con->close();
		}else $message="<p class='alert alert-danger' role='alert'>Already exist</p>";
	}else $message="<p class='alert alert-danger' role='alert'>Enter all Fields</p>";
}
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Department</h3>
	</div>
	<div class="panel-body">
        <div class="col-md-4 form-group">
			<?php
            	$listDep=listdip();
				if($listDep!=0){
					echo "<table class='table-bordered table'><tr><th>Department Name</th><th>options</th></tr>";
					foreach($listDep as $rec){echo "<tr><td>".$rec['name']."</td><td><a href='".$rec['alias']."' class='edis' data-type='editdepartment' title='Edit'>edit</a></td></tr>";}
					echo "</table>";
				}else echo "<p align='center'>Start Adding Departments</p>";
			?>
        </div>
        <div class="col-md-8" align="center">
            <form role="form" class="ss_form" method="post" id="defaultForm" novalidate>
            <?php if(isset($message))echo $message;?>
            <input type="hidden" value="<?php echo $ref;?>" name="ref" />
            <div class="col-md-6 col-md-offset-3 form-group" align="left">
                <label>Department : </label>
                <input class="form-control" tabindex="1" type="text" name="dep" placeholder="department" required="required" autofocus="autofocus"/>
            </div>
            <div class="form-group col-xs-12 morpad">
                <input tabindex="9" type="submit" class="btn btn-primary ss_buttons ademp" name="addEmp" value="Add Department">
                <button tabindex="10" type="reset" class="btn btn-primary ss_buttons" name="Reset">Reset</button>
            </div>
            </form>
        </div>
	</div>
</div>
