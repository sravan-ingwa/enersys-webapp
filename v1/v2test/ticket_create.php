<?php 
include('mysql.php');
include('functions.php');
if(isset($_REQUEST['sub'])){
	$ticket_id=ticketsID(alias(alias($_REQUEST['site_alias'],'ec_sitemaster','site_alias','state_alias'),'ec_state','state_alias','state_code'),1);
	$natureOfActivity=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['natureOfActivity']));
	$site_alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_alias']));
	$natureOfComplaint=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['natureOfComplaint']));
	$moc=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['moc']));
	$complete_desc=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['complete_desc']));
	$moc_file=upload_file($_FILES['moc_file'],$moc,'pdf');
	//if($moc_file){
		$query=mysqli_query($mr_con,"INSERT INTO ec_tickets(ticket_id,activity_alias,site_alias,login_date,complaint_alias,mode_of_contact,description)VALUES('$ticket_id','$natureOfActivity','$site_alias','$_REQUEST[created_date]','$natureOfComplaint','$moc','$complete_desc')");
	//}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Tickets</title>
</head>
<body>
<form enctype='application/json' method="POST">
<label>Nature Of Activity : </label>
    <select name="natureOfActivity">
        <option value="" disabled selected> Select </option>
        <?php $query=mysqli_query($mr_con,"SELECT * FROM ec_activity");while($row=mysqli_fetch_array($query)){?>
        <option value="<?php echo $row['activity_alias'];?>"><?php echo ucwords(strtolower($row['activity_name']));?></option><?php } ?>
    </select>
<label>Created Date : </label><input type="text" name="created_date" value="<?php echo date('Y-m-d'); ?>" readonly>
<label>Site Id : </label><select name="site_alias"><option value="" disabled selected> Select </option>
    <?php $query=mysqli_query($mr_con,"SELECT * FROM ec_sitemaster");while($row=mysqli_fetch_array($query)){?>
    <option value="<?php echo $row['site_alias'];?>"><?php echo ucwords(strtolower($row['site_id']));?></option><?php } ?></select><br><br>
<label>Nature Of Complaint : </label>
	<select name="natureOfComplaint">
        <option value="" disabled selected> Select </option>
        <?php $query=mysqli_query($mr_con,"SELECT * FROM ec_complaint");while($row=mysqli_fetch_array($query)){?>
        <option value="<?php echo $row['complaint_alias'];?>"><?php echo ucwords(strtolower($row['complaint_name']));?></option><?php } ?>
    </select>
<label>MOC : </label>
    <select name="moc">
    <option value="" disabled selected> Select MOC </option>
    <option value="Email">Email</option>
    <option value="Fax">Fax</option>
    <option value="Letter">Letter</option>
    <option value="Phone">Phone</option>
    </select>
 <label>Complete Description : </label><input type="text" name="complete_desc" value=""><br><br>
<input type="submit" name="sub" value="Submit">
</form>
</body>
</html>
<?php 
function ticketsID($state,$i){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT ticket_id FROM ec_tickets");
	$num = (mysqli_num_rows($sql)+$i);
	if($num > 9){$x = "TT".$state."00".$num;}
	elseif($num > 99){$x = "TT".$state."0".$num;}
	elseif($num > 999){$x = "TT".$state."".$num;}
	else{$x = "TT".$state."000".$num;}
	$newTT = preg_replace('/\D/', '', $x); 
	while($tt = mysqli_fetch_array($sql)){
		$oldTT = preg_replace('/\D/', '', $tt['ticket_id']);
		if($oldTT==$newTT){ $arr[] = $oldTT;}
	}
	if(count($arr)==0){ return $x; }
	else{return ticketsID($state,($i+1)); }
}
function upload_file($file,$ref,$type){
	if(isset($file['name']) || !empty($file['name'])){
		$fileName = uniqid($ref.'_').$file['name'];
		if($type=='image'){$arr = array('png','jpg','gif','tif','rif','bmp','bpg');}
		else{$arr = array('pdf');}
		$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
		if(in_array($ext,$arr)){
			$name = $fileName.".".$extension;
				if($ref=='profile_pic'){$path = "profile_pics/".$name;}else{$path = "reports_images/".$name;}
				if(file_exists($path)){echo "<script>alert('".$name." already exists')</script>";}
				else{
					$move = move_uploaded_file($file["tmp_name"],$path);
					$pic = mysql_real_escape_string($path);
				if($move){return $pic;}else{return FALSE;}
				}
		}else{ echo "<script>alert('Choosen file is not an ".$type." file')</script>"; }
	}
}
?>