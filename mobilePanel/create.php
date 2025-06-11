<?php include('mysql.php');
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++){$randomString .= $characters[rand(0, $charactersLength - 1)];}
		return strtoupper($randomString);
	}
	function aliasCheck($fv1,$fv2,$fv3){global $mr_con;
		$rec=mysqli_query($mr_con,"SELECT id FROM $fv2 WHERE $fv3='$fv1'");
		if(mysqli_num_rows($rec)==0)return $fv1; else return aliasCheck(generateRandomString(),$fv2,$fv3);
	}
	if(isset($_REQUEST['sub'])){
		$natureOfActivity=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['natureOfActivity']));
		$site_alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['site_alias']));
		$natureOfComplaint=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['natureOfComplaint']));
		$moc=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['moc']));
		$completeDesc=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['completeDesc']));
		$date=date("Y-m-d");
		if($natureOfActivity!='0' && $site_alias!='0' && $natureOfComplaint!='0' && $moc!='0' && $completeDesc!=""){
			$ticket_id=ticketsID($site_alias);
			if($ticket_id!="" && $ticket_id!='0'){
				$ticket_alias=aliasCheck(generateRandomString(),"ec_tickets","ticket_alias");
				$query=mysqli_query($mr_con,"INSERT INTO ec_tickets(ticket_id,activity_alias,site_alias,login_date,complaint_alias,mode_of_contact,description,ticket_alias,level)VALUES('$ticket_id','$natureOfActivity','$site_alias','$date','$natureOfComplaint','$moc','$completeDesc','$ticket_alias','1')");
				if($query)echo "Success";else echo "Failure-0";
			}else echo "Failure-1";
		}else echo "Failure-2";
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Enersys Care</title>
<link href="css/bootstrap.css" rel="stylesheet">
<style>
.nav, .nav li{
float:none !important;
}
.nav li{
display:inline-block !important;
}
.table th{text-align:center !important;}
</style>
</head>
<body>
<?php include "header.php";?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title" style="display:inline-block;">Create Ticket</h3>
				</div>
				<div class="panel-body">
					<form method="POST">
                    <div class="col-md-4 form-group">
                        <label>Nature Of Activity : </label>
                        <select name="natureOfActivity" class="form-control">
                        <option value="0" disabled selected> Select </option>
                        <?php $query=mysqli_query($mr_con,"SELECT * FROM ec_activity");while($row=mysqli_fetch_array($query)){?>
                        <option value="<?php echo $row['activity_alias'];?>"><?php echo ucwords(strtolower($row['activity_name']));?></option><?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Created Date : </label>
                        <input type="text" class="form-control" name="createdDate" value="<?php echo date('Y-m-d'); ?>" readonly>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Site Id : </label>
                        <select name="site_alias" class="form-control"><option value="0" disabled selected> Select </option>
                        <?php $query=mysqli_query($mr_con,"SELECT * FROM ec_sitemaster");while($row=mysqli_fetch_array($query)){?>
                        <option value="<?php echo $row['site_alias'];?>"><?php echo $row['site_id']." (".ucwords(strtolower(alias($row['segment_alias'],'ec_segment','segment_alias','segment_name'))).")";?></option><?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Nature Of Complaint : </label>
                        <select name="natureOfComplaint" class="form-control">
                        <option value="0" disabled selected> Select </option>
                        <?php $query=mysqli_query($mr_con,"SELECT * FROM ec_complaint");while($row=mysqli_fetch_array($query)){?>
                        <option value="<?php echo $row['complaint_alias'];?>"><?php echo ucwords(strtolower($row['complaint_name']));?></option><?php } ?>
                        </select>

                    </div>
                    <div class="col-md-4 form-group">
                        <label>MOC : </label>
                        <select tabindex="19" name="moc" class="form-control">
                        <option value="0" disabled selected> Select MOC </option>
                        <option value="Email">Email</option>
                        <option value="Fax">Fax</option>
                        <option value="Letter">Letter</option>
                        <option value="Phone">Phone</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Complete Description : </label>
                        <textarea class="form-control" name="completeDesc"></textarea>
                    </div>
                    <div class="col-md-4 col-md-offset-5 form-group">
                        <input type="submit" name="sub" value="Submit">
                    </div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
<?php 
date_default_timezone_set("Asia/Kolkata");
function ticketsID($fv1){ global $mr_con;
	$num=0;
	$state=alias(alias($fv1,'ec_sitemaster','site_alias','state_alias'),'ec_state','state_alias','state_code');
	$segment_code=alias(alias($fv1,'ec_sitemaster','site_alias','segment_alias'),'ec_segment','segment_alias','segment_code');
	$sql = mysqli_query($mr_con,"SELECT count(id) as count FROM ec_tickets");
	$row = mysqli_fetch_array($sql);
	$num = $row['count']+1;
	$date=date("dmy");
	//echo $segment_code;
	if($state!="" && $state!='0' && $segment_code!="" && $segment_code!='0' && $num!="" && $num!='0' && $date!="" && $date!='0'){
		return $segment_code.$state.$date.$num;
	}else return 0;
}
function alias($alias,$tb,$col,$retrive){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT $retrive FROM $tb WHERE $col='$alias' AND flag=0");
	if(mysqli_num_rows($sql)){
		$row = mysqli_fetch_array($sql);
		return $row[$retrive];
	}else return 0;
}
?>