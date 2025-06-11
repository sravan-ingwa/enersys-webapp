<?php 
session_start();
date_default_timezone_set("Asia/Kolkata");
if($_REQUEST['id']) $_SESSION['id']=$_REQUEST['id']; 
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Designation</h3>
	</div>
	<div class="panel-body">
        <form role="form" class="ss_form" method="post" id="defaultForm" novalidate>
        <?php if(isset($message))echo $message;?>
		<input type="hidden" value="qV9IPNva1M" name="role_alias" />
        <input type="hidden" value="RgPOOJAmsL" name="privilege_alias" />
        <input type="hidden" value="<?php echo $ref;?>" name="ref" />
        <input type="hidden" value="<?php echo $_SESSION['id'];?>" name="id" />
        <div class="col-md-4 col-md-offset-4 form-group">
            <label>Designation: </label>
            <input class="form-control" tabindex="1" type="text" value="<?php echo designation($_SESSION['id']);?>" name="designation" placeholder="Designation"/>
        </div>
        <div class="col-md-4 col-md-offset-4 form-group">
            <label>Grade: </label>
            <input class="form-control" tabindex="1" type="text" value="<?php echo desggrade($_SESSION['id']);?>" name="grade" placeholder="Grade"/>
        </div>
        <div class="form-group col-xs-12 morpad">
            <div class="col-md-3 col-md-offset-4">
             <input tabindex="2" type="submit" class="btn btn-primary ss_buttons updatex" name="addEmp" value="Update">
            <button tabindex="3" type="reset" class="btn btn-primary ss_buttons" name="Reset">Reset</button>
            </div>
        </div>
        </form>
	</div>
</div>
<?php
function chexx($fv1,$fv2){if($fv1==$fv2) return "selected='selected'";}
?>