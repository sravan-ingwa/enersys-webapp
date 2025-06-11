<?php 
include('services/mysql.php');
function authentication($emp_alias,$token) { global $mr_con; 
	if(strtoupper($emp_alias)=="ADMIN" && strtoupper($token)=="ADMIN") return '0';
	else{
		$sql = mysqli_query($mr_con,"SELECT id FROM ec_token WHERE employee_alias='$emp_alias' AND token='$token' AND flag=0");
		$sql1 = mysqli_query($mr_con,"SELECT id FROM ec_employee_master WHERE employee_alias='$emp_alias' AND flag=1");
		$sql2 = mysqli_query($mr_con,"SELECT id FROM ec_token WHERE employee_alias='$emp_alias' AND token!='$token' AND flag=0");
		if(mysqli_num_rows($sql))return '0';
		elseif(mysqli_num_rows($sql1))return '2';
		else return '1';
	}
}
function admin_privilege($emp_alias){ global $mr_con;
	if(strtoupper($emp_alias)=="ADMIN")return TRUE;
	else{
		$privilege_alias=alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias');
		if(!empty($privilege_alias)){
			$query=mysqli_query($mr_con,"SELECT id FROM ec_privileges WHERE privilege_alias='$privilege_alias' AND grantable='0' AND flag=0");
			return (mysqli_num_rows($query) ? FALSE : TRUE);
		}else return FALSE;
	}
}
function alias($alias,$tb,$col,$retrive){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT $retrive FROM $tb WHERE $col='$alias'");
	if(mysqli_num_rows($sql)){
		$row = mysqli_fetch_array($sql);
		return $row[$retrive];
	}else return "";
}
function alias_flag_none($alias,$tb,$col,$retrive){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT $retrive FROM $tb WHERE $col='$alias'");
	if(mysqli_num_rows($sql)){
		$row = mysqli_fetch_array($sql);
		return $row[$retrive];
	}else return "";
}
$emp_alias = mysqli_real_escape_string($mr_con,$_COOKIE['emp_alias']);
$token = mysqli_real_escape_string($mr_con,$_COOKIE['token']);
$rex=authentication($emp_alias,$token);
if($rex=='0'){
	if($emp_alias=='ADMIN' || admin_privilege($emp_alias)){
		if(isset($_REQUEST['sub'])){
			if(isset($_COOKIE['emp_alias'])){
				$ticket_alias=$_REQUEST['ticket_alias'];
				$flag=alias_flag_none($ticket_alias,'ec_tickets','ticket_alias','flag');
				$bb_item=alias($ticket_alias,'ec_battery_bank_bb_cap','ticket_alias','item_alias');
				if(!empty($bb_item)){
					$sql2=mysqli_query($mr_con,"DELETE FROM ec_bo_headers WHERE item_alias='$bb_item' AND flag='0'");
					$sql3=mysqli_query($mr_con,"DELETE FROM ec_bo_telecom_ic WHERE battery_bb_alias='$bb_item' AND flag='0'");
					$sql4=mysqli_query($mr_con,"DELETE FROM ec_bo_motive_ic WHERE battery_bb_alias='$bb_item' AND flag='0'");
				}
				$arr=array("ec_charger_details","ec_fork_lift","ec_battery_details","ec_ticket_action","ec_coach_history","ec_check_points","ec_equip_details","ec_other_issues","ec_no_of_banks","ec_physical_observation","ec_technical_observation","ec_general_observation","ec_power_observation","ec_battery_bank_bb_cap","ec_engineer_observation","ec_customer_comments","ec_customer_satisfaction","ec_e_signature");
				foreach($arr as $tbl)$sql=mysqli_query($mr_con,"DELETE FROM $tbl WHERE ticket_alias='$ticket_alias' AND flag='0'");
				if(!empty($flag))$sql1=mysqli_query($mr_con,"DELETE FROM ec_tickets WHERE ticket_alias='$ticket_alias' AND flag!='0'");
				else $sql1=mysqli_query($mr_con,"UPDATE ec_tickets SET level='2',old_level='1',efsr_no='',efsr_start='',efsr_date='',closing_date='',tat='',status='OPEN',n_visits=(n_visits-1) WHERE ticket_alias='$ticket_alias' AND flag='0'");
				if($sql && $sql1){
					$sql5=mysqli_query($mr_con,"DELETE FROM ec_remarks WHERE item_alias='$ticket_alias' AND module='TT' AND bucket='8' AND flag='0'");
					echo "Successfully Deleted";
				}else echo "Deletion Problem";
			}else echo "Your are logged out";
		}
?>
	<html>
		<form method="post" novalidate>
		<b>Delete Ticket Details from Database which are filled by service engineer</b></br></br>
		<label>Enter Ticket Alias:</label></br></br>
		<input type="text" name="ticket_alias"></br></br>
		<input type="submit" name="sub" value="Submit">
		</form>
	</html>
<?php }else echo "<h2>Authentication failed, Please Login</h2>";
}elseif($rex=='1')echo "<h2>Authentication failed, Please Login</h2>";
else echo "<h2>Account Locked, Please Contact Admin</h2>";
?>

