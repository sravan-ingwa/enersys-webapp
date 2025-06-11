<?php 
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['Create'])){
	$a=ucwords(mysql_escape_string($_REQUEST['displayName']));
	$b=strtolower(mysql_escape_string($_REQUEST['userEmail']));
	$c=mysql_escape_string($_REQUEST['password']);
	$d=mysql_escape_string($_REQUEST['role']);
	$e=mysql_escape_string($_REQUEST['employeeID']);
	$f=mysql_escape_string($_REQUEST['contact']);
	$g=mysql_escape_string($_REQUEST['empDetailsId']);
	$cd= date('Y-m-d');
	if($a==""){$result="Enter Display Name";}
	elseif($b==""){$result="Enter User Email";}
	elseif($c==""){$result="Enter Password";}
	elseif($d==""){$result="Enter User Role";}
	elseif($e==""){$result="Enter Employee ID";}
	elseif($f==""){$result="Enter Contact";}
	elseif(empty($_FILES['file1']['name'])){$result="Enter Profile Image";}
	else{
		$query=mysql_query("SELECT * FROM ss_user_details WHERE empId ='$a'");
		$count=mysql_num_rows($query);
		if($count==0){
			$id = checkx(rand(0000, 9999),'ss_user_details');
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			$temp = explode(".", $_FILES["file1"]["name"]);
			$extension = end($temp);
			if(in_array($extension, $allowedExts)){
				if ($_FILES["file1"]["error"] > 0){$result="Return Code: " . $_FILES["file1"]["error"] . "<br>"; }
				else {
					$fileName=$e."-pic.".$extension;
					move_uploaded_file($_FILES["file1"]["tmp_name"],"../img/photo/".$fileName);
					$profileimg = "img/photo/".$fileName;
					$ac = mysql_query("INSERT INTO ss_user_details(id,displayName,email,password,role,empId,contact,createdDate,flag,profileImage,empDetailsId) value('$id','$a','$b','$c','$d','$e','$f','$cd','0','$profileimg','$g')");
					if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
				}
			}else{$result=errorMsg('ERRMSG004');}
		}else{$result=errorMsg('ERRMSG003');}
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" enctype="multipart/form-data" id="defaultForm">
    <div class="col-md-4 form-group">
        <label>Role</label>
        <select tabindex="1" autofocus="autofocus" type="text" class="form-control" name="role" id="roles" onchange="ajaxfit(this.options[this.selectedIndex].value,'contact','roles')"><option value="">[Select User Role]</option><?php userRoleOption();?></select>
    </div>
    <div class="col-md-4 form-group">
        <label>Employee / Customer Name</label>
         <select tabindex="2" type="text" class="form-control" name="employeeID" id="userdetails" onchange="ajaxfit(this.options[this.selectedIndex].value,document.getElementById('roles').value,'userdetails')"><option value="">[Select User Role First]</option></select>
    </div>
    <div class="col-md-4 form-group">
        <label>Display Name</label>
        <input tabindex="3" class="form-control" type="text" name="displayName" id="udata2" readonly="readonly">
		<input type="hidden" name="empDetailsId" id="udata3">
	</div>
    <div class="col-md-4 form-group">
        <label>Contact</label>
        <input tabindex="4" type="text" class="form-control" name="contact" id="udata0" readonly="readonly">
    </div>
    <div class="col-md-4 form-group">
        <label>Email</label>
        <input tabindex="5" type="text" class="form-control nocap" onblur="this.value=this.value.toLowerCase()" name="userEmail" id="udata1"  readonly="readonly">
    </div>
    <div class="col-md-4 form-group">
        <label>Password</label>
        <input tabindex="6" type="text" class="form-control normalcap" name="password" placeholder="Enter Password">
    </div>
    <div class="col-md-4 form-group">
        <label>Profile Images</label>
        <input tabindex="7" type="file" class="form-control" name="file1" placeholder="Enter Profile Images">
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="Create" tabindex="8">Create</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="9">Reset</button>
        </div>
    </div>
</form>
