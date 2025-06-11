<script>setInterval(function(){ window.close(); },25000);</script>
<?php

include('services/mysql.php');
include('services/functions.php');

//Notification Reminder
$query = "SELECT reg_id, mobile_number FROM ec_employee_master WHERE device NOT IN('0','') AND device_2 NOT IN('0','') AND role_alias<>'01ZMYJ4OLG' AND reg_id<>'' AND flag='0'";
$sql = mysqli_query($mr_con, $query);
$mssg = "Dear Team, Please submit your today's DPR. If submitted, Please ignore.";
$dprQuery = "SELECT privilege_alias FROM `ec_privileges` WHERE privilege_item = 'DYNAMIC TABS' and privilege_type = 'DPR' and grantable = 1";
$dprSql = mysqli_query($mr_con, $dprQuery);
$likeCons = [];
while($row = mysqli_fetch_array($dprSql)) {
    $likeCons[] = " privilege_alias like '%". $row['privilege_alias'] ."%' ";
}
$likeOrCon = implode(" OR ", $likeCons);
$dprMsgQuery = $query . " and ( ". $likeOrCon . " ) ";
$dprMsgSql = mysqli_query($mr_con, $dprMsgQuery);
while($row = mysqli_fetch_array($dprMsgSql)) {
    messageSent($row['mobile_number'], $mssg);
}

?>