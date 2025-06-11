<?php

function getPrivilegesForEmailAndSMSSettings($communicationType, $entityType) {
	global $mr_con;
	$query = "select * from ec_email_sms_settings where entity_type = '$entityType' and communication_type = '$communicationType'";
	$result = [
		'to' => '',
		'cc' => '',
		'flag' => null
	];
	$sql = mysqli_query($mr_con, $query);
	if(mysqli_num_rows($sql)) {
		while($row = mysqli_fetch_array($sql)) {
			$result['to'] = $row['send_to'];
			$result['cc'] = $row['send_cc'];
			$result['flag'] = $row['flag'];
		}
	}
	return $result;
}

function getMailIds($privileges, $stateAlias = "") {
	global $mr_con;
	$privilegeIds = explode(";", $privileges);
	$query = "select distinct(email_id) from ec_employee_master ";
	$cond = [];
	if(count($privilegeIds)) {
		foreach($privilegeIds as $privilegeId) {
			if($privilegeId != '') {
				$cond[] = " privilege_alias like '%$privilegeId%' ";
			}
		}
	}
	$result = [];
	if(count($cond)){
		$query .= " where (" . implode(" or ", $cond) . " )";
		if($stateAlias) {
			$query .= " and state_alias like '%$stateAlias%'";
		}
		$query .= " and flag = 0 and status = 'WORKING'";
		$sql = mysqli_query($mr_con, $query);
		if(mysqli_num_rows($sql)) {
			while($row = mysqli_fetch_array($sql)) {
				$result[] = $row['email_id'];
			}
		}
	}
	return $result;
}

function ecSendMails( $entity, $state, $sub, $body, $to, $logName, $logType) {
	$communicationType = "email";
	$privilegesToSendMail = getPrivilegesForEmailAndSMSSettings($communicationType, $entity);
	if($privilegesToSendMail['flag'] != 0 ) {
		return;
	}
	$toState = $state;
	$factoryWh = ["BWIHQNHG8F", "GM5I41RNLO", "DWH4PLGSLK"];
	if(in_array($privilegesToSendMail['to'], $factoryWh)) {
		$toState = "";
	}
	$ccState = $state;
	if(in_array($privilegesToSendMail['cc'], $factoryWh)) {
		$toState = "";
	}
	$toMails = getMailIds($privilegesToSendMail['to'], $state);
	$ccMails = getMailIds($privilegesToSendMail['cc'], $state);
	$materialArray = ["mr_raised", "mr_md_approved", "mr_md_rejected", "mr_ppc_updated", "mr_invoice_req", "mr_dispatch_req", "mi_at_wh", "mi_at_fc", "mo_at_wh", "mo_at_fc"];
	$ticketsArray = ["new_tt_registration","zonal_nhs_close_decline_ticket","efsr_submit","technical_service_approved","technical_service_rejected","zonal_approval_pending_6hrs","nhs_approval_pending_6hrs"];
	if(in_array($entity, $materialArray)) {
		$ccMails[] = "fieldasset@enersys.co.in";
		$ccMails[] = "service@enersys.co.in";
	} else if(in_array($entity, $ticketsArray)) {
		$ccMails[] = "ticket@enersys.co.in";
	}
    if(count($toMails)){
		if($to != "") {
			$to .= "," . implode(",", $toMails);
		} else {
			$to = implode(",", $toMails);
		}
    }
	$from = all_from_mail();
	$headers  = "From: EnerSys Care<$from>\r\n";
	$headers .= "Reply-To: $from\r\n";
	$headers .= "Return-Path: $from\r\n";
    if(count($ccMails)) {
        $ccemail  =  implode(",", $ccMails);
        $headers .= "CC: ".$ccemail."\r\n";
    }
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$sendMail = mail($to, $sub, $body, $headers);
	if($sendMail) {
		success_mail_log($logName, $logType);
	} else {
		pending_mail_log($logName, $logType);
	}
}

function getMobileNums($privileges, $stateAlias = "") {
	global $mr_con;
	$privilegeIds = explode(";", $privileges);
	$query = "select distinct(mobile_number) from ec_employee_master ";
	$cond = [];
	if(count($privilegeIds)) {
		foreach($privilegeIds as $privilegeId) {
			if($privilegeId != '') {
				$cond[] = " privilege_alias like '%$privilegeId%' ";
			}
		}
	}
	$result = [];
	if(count($cond)) {
		$query .= " where (" . implode(" or ", $cond) . " )";
		if($stateAlias) {
			$query .= " and state_alias like '%$stateAlias%'";
		}
		$query .= " and flag = 0 and status = 'WORKING'";
		$sql = mysqli_query($mr_con, $query);
		if(mysqli_num_rows($sql)) {
			while($row = mysqli_fetch_array($sql)) {
				$result[] = $row['mobile_number'];
			}
		}
	}
	return $result;
}

function ecSendSms( $entity, $state, $to, $msg) {

	$communicationType = "sms";
	$privileges = getPrivilegesForEmailAndSMSSettings($communicationType, $entity);
	if($privileges['flag'] != 0 ) {
		return;
	}
	$toNums = getMobileNums($privileges['to'], $state);
	if($to != "") {
		$toNums[] = $to;
	}
	foreach($toNums as $eachNum) {
		messageSent($eachNum, $msg);
	}
}

?>