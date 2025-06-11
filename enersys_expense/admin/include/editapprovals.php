<?php 
session_start();
date_default_timezone_set("Asia/Kolkata");
if($_REQUEST['id']) $_SESSION['id']=$_REQUEST['id']; 
$approvalDetails=approvalDetails($_SESSION['id']);
$empbydep=empbydep($approvalDetails[0]['approver_dep']);
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Approvals</h3>
	</div>
	<div class="panel-body">
		 <?php if(isset($message))echo $message;?>
        <form role="form" class="ss_form" method="post" id="defaultForm" novalidate>
        <input type="hidden" value="<?php echo $ref;?>" name="ref" />
        <input type="hidden" value="<?php echo $_SESSION['id'];?>" name="id" />
            <div class="col-md-6 form-group">
                <label>Approval for(Department): </label>
                <select class="form-control" tabindex="1" required="required" disabled="disabled">
                    <option value="0">[Select Department]</option>
                    <?php $listDgn=listdip();if($listDgn!=0){foreach($listDgn as $rec){echo "<option value='".$rec['alias']."' ".selectedcheck($rec['alias'],$approvalDetails[0]['approval_dep'])." >".$rec['name']."</option>";}}else echo "<option disabled='disabled'>Add Department</option>";?>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label>Approval Level: </label>
                <select class="form-control" tabindex="1" required="required" disabled="disabled">
                    <option value="0">[Select Level]</option>
                    <option value="1" <?php echo selectedcheck('1',$approvalDetails[0]['approval_level']);?> >Approver Level</option>
                    <option value="2" <?php echo selectedcheck('2',$approvalDetails[0]['approval_level']);?> >HR Level</option>
                    <option value="3" <?php echo selectedcheck('3',$approvalDetails[0]['approval_level']);?> >Finance Level</option>
                    <option value="4" <?php echo selectedcheck('4',$approvalDetails[0]['approval_level']);?> >HOD Level</option>
                    <option value="5" <?php echo selectedcheck('5',$approvalDetails[0]['approval_level']);?> >MD Level</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label>Approver Department: </label>
                <select class="form-control showempbydep" tabindex="1" required="required" name="dep">
                    <option value="0" selected="selected" >[Select Department]</option>
                    <?php $listDgn=listdip();if($listDgn!=0){foreach($listDgn as $rec){echo "<option value='".$rec['alias']."' ".selectedcheck($rec['alias'],$approvalDetails[0]['approver_dep'])." >".$rec['name']."</option>";}}else echo "<option disabled='disabled'>Add Department</option>";?>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label>Approval Employee</label>
                <p  id="mot1">
                <select class='form-control' tabindex='2' required='required' name='aemp' id='mot2'>
                <?php 
                    if($empbydep!=0)foreach($empbydep as $rec){
                        echo "<option value='".$rec['alias']."' ".selectedcheckmulti($rec['alias'],$approvalDetails[0]['name'])." >".$rec['name']."</option>";
                }?>
                </select>
                </p>	
            </div>
        <div class="form-group col-xs-12 morpad">
            <div class="col-md-3 col-md-offset-6">
             <input tabindex="3" type="submit" class="btn btn-primary ss_buttons updatex" name="addEmp" value="Update">
            </div>
        </div>
        </form>
	</div>
</div>
<?php
function selectedcheck($fv1,$fv2){if($fv1===$fv2) return " selected=\"selected\" "; }
function selectedcheckmulti($fv1,$fv2){
	$fv3=explode("|",$fv2);
	if(in_array($fv1, $fv3)){return " selected=\"selected\" ";}
}

?>
<script type="text/javascript">
	$(document).ready(function() {
		window.prettyPrint() && prettyPrint();
		$('#mot2').multiselect({includeSelectAllOption: true});
	});
</script>