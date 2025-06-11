<?php
session_start();
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['advRequested'])){
	if(filter_var($_REQUEST['advRequested'], FILTER_VALIDATE_INT) == false){$message="<p class='alert alert-danger' role='alert'>Enter Request Amount</p>";}
	else if($_REQUEST['reasonForAdv']==""){$message="<p class='alert alert-danger' role='alert'>Enter Remarks</p>";}
	else if($_FILES['tplanningreport']['size']<=0){$message="<p class='alert alert-danger' role='alert'>Upload Tour Planning Report</p>";}
	else{
		$empalias=$_SESSION['ec_user_alias'];
		$reqAmt=mysqli_real_escape_string($mr_con,$_REQUEST['advRequested']);
		$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
		$reqdate=date("Y-m-d");
		$rquestid="#".checkint(mt_rand(1000,999999999),'ec_advances','request_id');
		$alias=aliasCheck(generateRandomString(),"ec_advances","advance_alias");
		$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
		if($empalias!=""){
			if(isset($_REQUEST['rcq']) && $_REQUEST['rcq']=="save"){
				if($_FILES['tplanningreport']['size']>0){
					$ext = pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION);
					$fileName=$empalias.generateRandomString()."ADV.".$ext;
					move_uploaded_file($_FILES["tplanningreport"]["tmp_name"],"attachments/tourReport/".$fileName);
					$profileimg = "attachments/tourReport/".$fileName;
				}else $profileimg =0;
				$sql="INSERT INTO ec_advances(employee_alias,request_amount,total_amount,request_id,requested_date,advance_alias,approval_level,report) VALUES ('$empalias','$reqAmt','$reqAmt','$rquestid','$reqdate','$alias','0','$profileimg')";
				if($mr_con->query($sql)===TRUE){
					$mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BA','$alias','$empalias','$alias_remark')");
					$emcheck=alias($rquestid,'ec_advances','request_id','employee_alias');
					if($emcheck=="NA" || $emcheck==""){
						$message="<p class='alert alert-danger' role='alert'>Your Request ID ".$rquestid." has been saved, But Will not Reflect in you details, So contact Admin</p>";
						//$url="http://enersyscare.co.in/enersys_expense/maillings/failed.php?type=1&ref=".$rquestid;
					}else{
						$message="<p class='alert alert-success' role='alert'>Advance Request Saved</p>";
						$url="http://enersyscare.co.in/enersys_expense/maillings/book_advance.php?ref=".$alias;
						file_get_contents($url);
					}
				}else $message="<p class='alert alert-danger' role='alert'>Advance Drafting Failed</p>";
			}
			else{
				$levelx=expenseApprovalLevels($_SESSION['ec_user_alias']);
				switch ($levelx){
					case '1': $level=2;break;
					case '2': $level=2;break;
					case '3': $level=5;break;
					case '4': $level=5;break;
					case '5': $level=6;break;
					default : $level=1;break;
				}
				if($_FILES['tplanningreport']['size']>0){
					$ext = pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION);
					$fileName=$empalias.generateRandomString()."ADV.".$ext;
					move_uploaded_file($_FILES["tplanningreport"]["tmp_name"],"attachments/tourReport/".$fileName);
					$profileimg = "attachments/tourReport/".$fileName;
				}else $profileimg =0;
				$sql="INSERT INTO ec_advances(employee_alias,request_amount,total_amount,request_id,requested_date,advance_alias,approval_level,report) VALUES ('$empalias','$reqAmt','$reqAmt','$rquestid','$reqdate','$alias','$level','$profileimg')";
				if($mr_con->query($sql)===TRUE){
					$mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BA','$alias','$empalias','$alias_remark')");
					$emcheck=alias($rquestid,'ec_advances','request_id','employee_alias');
					if($emcheck=="NA" || $emcheck==""){
						$message="<p class='alert alert-danger' role='alert'>Your Request ID ".$rquestid." has been Submitted, But Will not Reflect in you details, So contact Admin</p>";
						//$url="http://enersyscare.co.in/enersys_expense/maillings/failed.php?type=1&ref=".$rquestid;
					}else{
						$message="<p class='alert alert-success' role='alert'>Advance Request successfully</p>";
						$url="http://enersyscare.co.in/enersys_expense/maillings/book_advance.php?ref=".$alias;
						file_get_contents($url);
					}
				}
				else $message="<p class='alert alert-danger' role='alert'>Advance Request Failed</p>";
			}
		}else $message="<p class='alert alert-danger' role='alert'>Sorry Something Went Wrong! Please try Later</p>";
	}
}
?>
<style>.redd{color:#F00 !important;}</style>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Advance Request</h3>
	</div>
	<div class="panel-body">
    	<p class='alerta' role='alert'></p>
        <form role="form" class="ss_form" method="post" id="defaultForm" novalidate>
         <input type="hidden" value="<?php echo $ref;?>" name="ref" />
        <div class="col-xs-10 jerror"><?php if(isset($message))echo $message;?></div>
        <div class="col-md-4 form-group">
            <label>Date of Request : </label>
            <input class="form-control" type="text" value="<?php echo date('d-M-Y'); ?>" placeholder="Date of Request" readonly/>
        </div>
        <div class="col-md-4 form-group">
            <label>Employee ID : </label>
            <input class="form-control" type="text" value="<?php echo employeeDetails('employee_id',$_SESSION['ec_user_alias']);?>" placeholder="Employee ID" readonly/>
        </div>
        <div class="col-md-4 form-group">
            <label>Employee Name: </label>
            <input class="form-control" type="text" value="<?php echo employeeDetails('name',$_SESSION['ec_user_alias']);?>" placeholder="Employee Name" readonly/>
        </div>
        <div class="col-md-4 form-group">
            <label>Grade: </label>
            <input class="form-control" type="text" value="<?php echo grade($_SESSION['ec_user_alias'])?>" placeholder="Grade" readonly/>
        </div>
        <div class="col-md-4 form-group">
            <label>Credit Limit: </label>
            <input class="form-control limitt" type="text" value="<?php echo advancelimit($_SESSION['ec_user_alias']);?>" placeholder="Credit Limit" readonly/>
        </div>
        <div class="col-md-4 form-group">
            <label>Previous Advances Not Settled (amt): </label>
            <input class="form-control" type="text" value="<?php if (advanceNotSettled($_SESSION['ec_user_alias'])!=0)echo advanceNotSettled($_SESSION['ec_user_alias']); else echo "No pending Advances";?>" placeholder="Previous Advances Not Settled" readonly/>
        </div>
        <div class="col-md-4 form-group">
            <label>Current Request (amt): </label>
            <input type="text" tabindex="1" name="advRequested" class="form-control currentRequest amtt" placeholder="Current Request" autofocus="autofocus" autocomplete="off"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Toatl outstanding Advance (Current): </label>
            <input type="text" class="form-control tadv" placeholder="Total Advance" readonly="readonly"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Reason/ Remarks: </label>
            <textarea tabindex="2" class="form-control reasonForAdv" name="reasonForAdv" placeholder="Reason/ Remarks"></textarea>
        </div>
        <div class="col-md-4 form-group">
            <label>Tour Planning Report: <small class="redd">(Mandatory)</small></label>
            <input type="file" class="form-control tplanningreport" name="tplanningreport" id="tplanningreport"/>
        	<small class="redd">(Kinldy upload PDF format and size not exceeding 1MB)</small>
        </div>
        <div class="form-group col-xs-12 morpad">
            <div class="col-md-9 hidden-xs table-responsive">
				<table class="table table-bordered">
                	<thead>
                    	<tr class="blue cust">
                        	<th>Request ID</th>
                            <th>Requested Amount</th>
                            <th>Requested Date</th>
                            <th>Approved By</th>
                        </tr>
                    </thead>
                    <tbody>
					<?php 
                        $listDgn=listPendingAdvances($_SESSION['ec_user_alias']);
                        if($listDgn!=0){foreach($listDgn as $rec){
							$sw=employeeDetails('name',$rec['approved_by']);
							echo "<tr><td>".$rec['request_id']."</td><td>".$rec['total_amount']."</td><td>".$rec['requested_date']."</td><td>".$sw."</td></tr>";}}
                        else echo "<tr><td colspan='4' align='center'>No Balance Advance</td></tr>";
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-3">
                <input tabindex="13" type="submit" class="btn btn-primary ss_buttons ademp" name="addEmp" value="Request Advance">
                <input tabindex="14" type="submit" class="btn btn-primary ss_buttons saveinDraft" name="saveinDraft" value="Draft">
            </div>
        </div>
        </form>
	</div>
</div>
<script>
	$(document).on('focusout','.currentRequest',function (event){ 
		if($(this).val()!=""){
			$.ajax({
				url: "item.php",
				type: "POST",
				data: 'currentRequest='+encodeURIComponent($(this).val()),
				cache:false,
				success: function(result){
					var res = result.split("|");
					$('.tadv').val(res[0].trim());
					if(res[1]==1) alert('Please note: Your Request is not more than INR '+$('.limitt').val());
					return false;
				}
			});
		}
	});
</script>
