<?php
if(isset($_REQUEST['update'])){
	$a=ucwords(mysql_escape_string($_REQUEST['displayName']));
	$b=strtolower(mysql_escape_string($_REQUEST['userEmail']));
	$c=mysql_escape_string($_REQUEST['password']);
	$d=mysql_escape_string($_REQUEST['role']);
	$e=mysql_escape_string($_REQUEST['employeeID']);
	$f=mysql_escape_string($_REQUEST['contact']);
	if($a==""){$result="Enter Display Name";}
	elseif($b==""){$result="Enter User Email";}
	elseif($c==""){$result="Enter Password";}
	elseif($d==""){$result="Enter User Role";}
	elseif($e==""){$result="Enter Employee ID";}
	elseif($f==""){$result="Enter Contact";}
	else{
			if(!empty($_FILES['file11']['name'])){
				$allowedExts = array("gif", "jpeg", "jpg", "png");
				$temp = explode(".", $_FILES["file11"]["name"]);
				$extension = end($temp);
				if (in_array($extension, $allowedExts)){
					if ($_FILES["file11"]["error"] > 0){$result="Return Code: " . $_FILES["file1"]["error"] . "<br>"; }
					else {
						$fileName=$e."-pic.".$extension;
						@unlink("../img/photo/".$fileName);
						move_uploaded_file($_FILES["file11"]["tmp_name"],"../img/photo/".$fileName);
						$profileimg = "img/photo/".$fileName;
						$RefId=$_REQUEST['y'];
						$ac = mysql_query("UPDATE ss_user_details SET displayName='".$a."',email='".$b."',password='".$c."',role='".$d."',empId='".$e."',contact='".$f."',profileImage='".$profileimg."' WHERE id=$RefId") or die('Data is not inserted');
						if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
					}
				}else{$result=errorMsg('ERRMSG004');}
			}
			else{
				$RefId =$_REQUEST['y'];
				$ac = mysql_query("UPDATE ss_user_details SET displayName='".$a."',email='".$b."',password='".$c."',role='".$d."',empId='".$e."',contact='".$f."' WHERE id=$RefId") or die('Data is not inserted');
				if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
			}

	}
}
$RefId =$_REQUEST['y'];
$query1=mysql_query("SELECT * FROM ss_user_details WHERE id='$RefId'");
$row = mysql_fetch_array($query1);
$co = mysql_num_rows(mysql_query("SELECT email FROM ss_customer_details WHERE email='$row[email]' AND flag='0'"));
?>
<p class="errorP"><?php if(isset($result)){echo $result;} ?> </p>

<form role="form" class="ss_form" method="post" enctype="multipart/form-data" id="defaultForm">
<input type="hidden" name="y" value="<?php echo $RefId;?>" />
    <div class="col-md-4 form-group">
        <label>Display Name</label>
        <input tabindex="1" autofocus="autofocus" class="form-control" type="text" name="displayName" value="<?php echo $row['displayName']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Email</label>
        <input tabindex="2" type="text" class="form-control nocap" onblur="this.value=this.value.toLowerCase()"  name="userEmail" value="<?php echo $row['email']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Password</label>
        <input tabindex="3" type="text" class="form-control normalcap" name="password" value="<?php echo $row['password']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Profile Images</label>
        <input tabindex="4" type="file" class="form-control" name="file11" value="<?php echo $row['profileImage']; ?>">
        <img src="../<?php echo $row['profileImage']; ?>" width="100px" height="100px"> 
    </div>
    <div class="col-md-4 form-group">
        <label>Role</label>
        <select tabindex="5" type="text" name="role" class="form-control"><option value="">[Select User Role]</option>
		<option value="<?php echo $row['role']; ?>" selected="selected"><?php echo roleGetName($row['role']); ?></option>
		<?php userRoleOption();?></select>
    </div>
    <div class="col-md-4 form-group">
        <label>Employee ID / Customer ID</label>
         <select tabindex="6" type="text" name="employeeID" class="form-control"><option value="">[Select Employee ID / Customer ID]</option>
         <?php if($co == 0 )echo employeeOptionEdit($row['empId']);else echo customerDetailsEdit($row['empId']); ?></select>
    </div>
    <div class="col-md-4 form-group">
        <label>Contact</label>
        <input tabindex="7" type="text" name="contact" class="form-control" placeholder="Enter Contact" value="<?php echo $row['contact']; ?>" readonly="readonly">
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="update" tabindex="8">Update</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="9">Reset</button>
        </div>
    </div>
</form>