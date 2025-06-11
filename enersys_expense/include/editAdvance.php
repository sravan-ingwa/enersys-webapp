<?php 
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['advRequested'])){
	if(filter_var($_REQUEST['advRequested'], FILTER_VALIDATE_INT) == false){$message="<p class='alert alert-danger' role='alert'>Enter Request Amount</p>";}
	else if($_REQUEST['reasonForAdv']==""){$message="<p class='alert alert-danger' role='alert'>Enter Remarks</p>";}
	//else if($_FILES['tplanningreport']['size']<=0){$message="<p class='alert alert-danger' role='alert'>Upload Tour Planning Report</p>";}
	else{
		$ref='viewadvance';
		$alias=$_REQUEST['id'];
		$empalias=$_SESSION['ec_user_alias'];
		$reqAmt=mysqli_real_escape_string($mr_con,$_REQUEST['advRequested']);
		$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
		$reqdate=date("Y-m-d");
		$level=0;
		if($empalias!=""){
			if(isset($_REQUEST['rcq']) && $_REQUEST['rcq']=="save"){
				if($_FILES['tplanningreport']['size']>0){
					$ext = pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION);
					$fileName=$empalias.generateRandomString()."ADV.".$ext;
					move_uploaded_file($_FILES["tplanningreport"]["tmp_name"],"attachments/tourReport/".$fileName);
					$profileimg = "attachments/tourReport/".$fileName;
					if($_REQUEST['tplanningreport_old']!=='0' && $_REQUEST['tplanningreport_old']!=='') unlink($_REQUEST['tplanningreport_old']);
				}else{
					if($_REQUEST['tplanningreport_old']=='0')$profileimg=0;
					else $profileimg=$_REQUEST['tplanningreport_old'];
				}
				$sql="UPDATE ec_advances SET request_amount='$reqAmt',total_amount='$reqAmt',requested_date='$reqdate',approval_level='$level',report='$profileimg' WHERE advance_alias='$alias'";
				if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Advance Request successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Advance Request Failed</p>";
				$mr_con->query("UPDATE ec_remarks SET remarks='$reasonForAdv',remarked_on='".date("Y-m-d H:i:s")."' WHERE item_alias='$alias'");
				if(file_exists('viewadvance.php')){include('viewadvance.php');}
			}
		}else $message="<p class='alert alert-danger' role='alert'>Sorry Something Went Wrong! Please try Later</p>";
	}
}
if($_REQUEST['id']) $_SESSION['id']=$_REQUEST['id']; 
$advList=advancefullView($_SESSION['id']);
$remarks=getRemarks($advList[0]['advance_alias'],'BA');
if($advList[0]['approval_level1']<6){?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Advance Request</h3>
	</div>
	<div class="panel-body">
        <form role="form" class="ss_form" method="post" id="defaultForm" novalidate>
        <p class='alerta' role='alert'></p>
       <div class="col-xs-10 jerror"> <?php if(isset($message))echo $message;?></div>
        <input type="hidden" value="<?php echo $ref;?>" name="ref" />
        <input type="hidden" value="<?php echo $advList[0]['approval_level1'];?>" class="ref2" name="ref2" />
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
            <input type="text" tabindex="1" name="advRequested" value="<?php echo $advList[0]['request_amount'];?>" class="form-control amtt currentRequest" placeholder="Current Request" autofocus autocomplete="off" <?php if($advList[0]['approval_level1']>0) echo " readonly=\"readonly\""; ?> />
        </div>
        <div class="col-md-4 form-group">
            <label>Toatl outstanding Advance + Current Request: </label>
            <input type="text"  class="form-control tadv" name="totaladcan"  value="<?php echo (advanceNotSettled($advList[0]['employee_alias'])+$advList[0]['request_amount']);?>" placeholder="Total Advance" readonly="readonly"/>
        </div>

        <?php if($remarks!=0){foreach($remarks as $remk){?>
			<?php if($advList[0]['approval_level1']==0){?>
	        <div class="col-md-4 form-group">
                <label>Remarks: <small>(By <?php echo employeeDetails('name',$remk['remarked_by']);?>, On: <?php echo date("d-M-Y", strtotime($remk['remarked_on']));?>)</small></label>
                <textarea tabindex="2" class="form-control reasonForAdv" name="reasonForAdv" placeholder="Reason/ Remarks"><?php echo $remk['remarks'];?></textarea>
	        </div>
            <div class="col-md-4 form-group">
				<input type="hidden" class="form-control" name="tplanningreport_old" value="<?php echo $advList[0]['report'];?>"/>
                <label>Tour Planning Report: 
                       <?php if($advList[0]['report']!=='0' && $advList[0]['report']!==''){?><a href="<?php echo $advList[0]['report'];?>" target="_blank" class="pdfil">Click for old Report</a><?php }?>
                </label>
                <input type="file" class="form-control tplanningreport" name="tplanningreport" id="tplanningreport"/>
                <small class="redd">(Kinldy upload PDF format and size not exceeding 1MB)</small>
            </div>
            <?php }else{?>
	        <div class="col-md-4 form-group">
                <label>Remarks: <small>(By <?php echo employeeDetails('name',$remk['remarked_by']);?>, On: <?php echo date("d-M-Y", strtotime($remk['remarked_on']));?>)</small></label>
                <textarea tabindex="2" class="form-control" placeholder="Reason/ Remarks" readonly="readonly"><?php echo $remk['remarks'];?></textarea>
	        </div>
        <?php }}}?>

        <?php if($advList[0]['approval_level1']>0){?>
        <div class="col-md-4 form-group">
            <label>Reason/ Remarks: </label>
            <textarea tabindex="2" class="form-control reasonForAdv" name="reasonForAdv" placeholder="Reason/ Remarks" required></textarea>
        </div>
		<?php }?>

		<?php if($advList[0]['approval_level1']==0){?>
        <div class="col-md-4 col-md-offset-4">
            <input tabindex="13" type="submit" class="btn btn-primary ss_buttons updatex" name="approve" value="Request Advance">
            <input tabindex="14" type="submit" class="btn btn-primary ss_buttons saveinDraft" name="saveinDraft" value="Draft">
        </div>
		<?php }else{?>
        <div class="col-md-4 col-md-offset-4">
            <input tabindex="13" type="submit" class="btn btn-primary ss_buttons updatex" name="approve" value="Approve">
            <input tabindex="14" type="submit" class="btn btn-primary ss_buttons rejectx" name="reject" value="Reject">
        </div>
        <?php }?>
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
                        $listDgn=listPendingAdvances($advList[0]['employee_alias']);
                        if($listDgn!=0){foreach($listDgn as $rec){
							if(employeeDetails('name',$rec['approved_by'])==0) $sw="Not Approved"; else $sw=employeeDetails('name',$rec['approved_by']);
							echo "<tr><td>".$rec['request_id']."</td><td>".$rec['total_amount']."</td><td>".$rec['requested_date']."</td><td>".$sw."</td></tr>";}}
                        else echo "<tr><td colspan='4' align='center'>Nill Advance</td></tr>";
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        </form>
	</div>
</div>
<script>
	$(document).on('keyup','.currentRequest',function (event){ 
		$.ajax({
			url: "item.php",
			type: "POST",
			data: 'currentRequest='+encodeURIComponent($(this).val()),
			cache:false,
			success: function(result){var res = result.split("|");
				$('.tadv').val(res[0].trim());
				if(res[1]==1) alert('Your Request is morethan your Limit');
			}
		});
	});
</script>
<?php }else echo "<script type='text/javascript'>window.location='index.php'</script>";?>
