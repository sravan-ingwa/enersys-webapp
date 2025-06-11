<?php
date_default_timezone_set("Asia/Kolkata");
function dat($a){if(!empty($a))return date_format(date_create($a),"jS M Y");else return false;}
$adv_ali=$_REQUEST['ref'];
//$adv_ali="3XWGS88F1E";
if($adv_ali!=""){
	$requester=$Approvals1=$Approvals2=$Approvals3=$Approvals4=array();
	include('../functions.php');
	$adv_req=advancefullView($adv_ali);
	$level=$adv_req[0]['approval_level1'];
	$requester=explode("|", $adv_req[0]['employee_alias']);
	$emp_ddp=employeeDetails('department_alias',$adv_req[0]['employee_alias']);
	if($level==1 && approvelLevelemplist($emp_ddp, '1')!='0') {
		array_push($Approvals1,approvelLevelemplist($emp_ddp, '1'));
	}
	if($level==2 && approvelLevelemplist($emp_ddp, '4')!='0') {
		array_push($Approvals2, approvelLevelemplist($emp_ddp, '4'));
	}
	if($level == 4 && approvelLevelemplist($emp_ddp, '3') != '0') {
		array_push($Approvals3, approvelLevelemplist($emp_ddp, '3'));
	}
	if($level==5 && approvelLevelemplist($emp_ddp, '5')!='0') {
		array_push($Approvals3, approvelLevelemplist($emp_ddp, '5'));
	}
	$toList=array_merge($requester,$Approvals1,$Approvals2,$Approvals3,$Approvals4);
	foreach($toList as $key=>$to){
		$to_mail_id = employeeDetails('email_id',$to);
		//echo $to_mail_id;
		$settleAmount=advanceNotSettled($adv_req[0]['employee_alias']);
		$remarks=getRemarks($adv_ali,"BA");
		$approveBeforeEncode = "advance@@" . $adv_req[0]['advance_alias'] . "@@" . $to . "@@request@@" . $level;
		$rejectBeforeEncode = "advance@@" . $adv_req[0]['advance_alias'] . "@@" . $to . "@@reject@@" . $level;
		$approveUrl = baseurl() . "includes/expenses_dynamic_remark.php?verify=" . base64_encode($approveBeforeEncode);
		$rejectUrl = baseurl() . "includes/expenses_dynamic_remark.php?verify=" . base64_encode($rejectBeforeEncode);
		$headline = "Acknowledgement for Advance";
		$addApproval = false;
		if($adv_req[0]['employee_alias'] != $to) {
			if($level==1 && approvelLevelemplist($emp_ddp, '1') != '0') {
				$headline = "Advance Request - ".$adv_req[0]['request_id'];
				$addApproval = true;
			}
			if($level == 2 && approvelLevelemplist($emp_ddp, '4') != '0') {
				$headline = "Advance Request - ".$adv_req[0]['request_id'];
				$addApproval = true;
			}
			if($level == 4 && approvelLevelemplist($emp_ddp, '3') != '0') {
				$headline = "Advance Request - ".$adv_req[0]['request_id'];
				$addApproval = true;
			}
			if($level == 5 && approvelLevelemplist($emp_ddp, '5') != '0') {
				$headline = "Advance Request - ".$adv_req[0]['request_id'];
				$addApproval = true;
			}	
		} else {
			if($key > 0 && $level == 4 && approvelLevelemplist($emp_ddp, '3') != '0') {
				$headline = "Advance Request - ".$adv_req[0]['request_id'];
				$addApproval = true;
			}
		}
		$sub = "Advance Request-".$adv_req[0]['request_id'];
		if ($adv_req[0]["approval_level"] == "DRAFT") {
			$sub .= " - Draft";
			$headline .= " - Draft";
		}
		$res="<p>Dear ".employeeDetails('name',$to).",</p>";
		$res.="<table width='600px' style='border-collapse:collapse;' cellpadding='3' align='center'>";
			$res.="<tr align='center'>";
				$res.="<th align='center' style='border:1px solid #ddd; border-bottom:1px solid #fff;'>";
					$res.="<table width='100%'>";
						$res.="<tr>";
							$res.="<th align='left'><img src='http://enersyscare.co.in/enersys_expense/img/EnerSyslogo.png' alt='EnerSys_logo' width='150'></th>";
							$res.="<th align='right'><h3>EnerSys India Batteries Pvt. Ltd.</h3></th>";
						$res.="</tr>";
					$res.="</table>";
				$res.="</th>";
			$res.="</tr>";
			$res.="<tr>";
				$res.="<td align='center' style='border:1px solid #ddd;'>";
					$res.="<table width='100%' cellpadding='3'>";
						$res.="<tr>";
							$res.="<td align='right'><b>Date :</b>".dat($adv_req[0]['requested_date'])."</td>";
						$res.="</tr>";
						$res.="<tr>";
							$res.="<td align='right'><b>Request ID :</b>".$adv_req[0]['request_id']."</td>";
						$res.="</tr>";
						$res.="<tr>";
							$res.="<td align='center'><h3> $headline </h3></td>";
						$res.="</tr>";
					$res.="</table>";
					$res.="<table style='border-collapse:collapse;' cellpadding='8' align='center'>";
						$res.="<tr>";
							$res.="<td width='50%' style='border:1px solid #ddd;'><b>Employee ID : </b>".strtoupper(alias($adv_req[0]['employee_alias'],'ec_employee_master','employee_alias','employee_id'))."</td>";
							$res.="<td width='50%' style='border:1px solid #ddd;'><b>Employee Name : </b>".strtoupper(alias($adv_req[0]['employee_alias'],'ec_employee_master','employee_alias','name'))."</td>";
						$res.="</tr>";
						$res.="<tr>";
							$res.="<td style='border:1px solid #ddd;'><b>Department : </b>".ucfirst(alias(alias($adv_req[0]['employee_alias'],'ec_employee_master','employee_alias','department_alias'),'ec_department','department_alias','department_name'))."</td>";
							$res.="<td style='border:1px solid #ddd;'><b>Designation : </b>".ucfirst(alias(alias($adv_req[0]['employee_alias'],'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','designation'))."</td>";
						$res.="</tr>";
						$res.="<tr>";
							$res.="<td style='border:1px solid #ddd;'><b>Grade : </b>".ucfirst(alias(alias($adv_req[0]['employee_alias'],'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','grade'))."</td>";
							$res.="<td style='border:1px solid #ddd;'><b>Previous Advance not settled : </b>".moneyFormatIndia($settleAmount)."</td>";
						$res.="</tr>";
						if($remarks!=0){
							foreach($remarks as $remk){
								$res.="<tr>";
									$res.="<td style='border:1px solid #ddd;' colspan='2'>";
										$res.="<b>Remarks: <small>(By ".employeeDetails('name',$remk['remarked_by']).", On: ".date("d-M-Y", strtotime($remk['remarked_on'])).")</small></b>: ".$remk['remarks'];
									$res.="</td>";
								$res.="</tr>";
							}
						}
						$res.="<tr>";
							$res.="<td align='right' colspan='2'>Current Request: <b>Rs.".moneyFormatIndia($adv_req[0]['request_amount'])."</b></td>";
						$res.="</tr>";
						if($addApproval) {
							$res.="<tr>";
								$res.="<td align='right'><a href='$approveUrl' style='display:inline-block;background-color: #00552C;  color: #fff;padding: 0 7px; line-height: 25px;'>Approve</a></td>";
								$res.="<td align='left'><a href='$rejectUrl' style='display:inline-block;background-color: #FF0000;  color: #fff;padding: 0 7px; line-height: 25px;'>Reject</a></td>";
							$res.="</tr>";
						}
						$res.="<tr><td align='right' colspan='2'><br></td></tr>";
						// $res.="<tr><td colspan='2' style='font-style:italic;'>Note: Just a heads up, due to security reasons the Link will expire after 24 hours, If it's expired you still can perform the action by logging in to the web application.</td></tr>";
					$res.="</table>";
				$res.="<br><br></td>";
			$res.="</tr>";
		$res.="</table><br><br>";
		$body=$res;
		$body.="<p style='font-style:italic;text-align:center;'><small>*** This is a System generated email, Please do not reply ***</small></p>";
		$from=all_from_mail();
		$headers="From: $from\r\n";
		$headers.="Reply-To: $from\r\n";
		$headers.="Return-Path: $from\r\n";
		//$headers.= "CC: $ccemail \r\n";
		//$headers .= "BCC: $bccemail \r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$abc = mail($to_mail_id,$sub,$body,$headers);
		if($abc)success_mail_log($adv_ali,"BADV");
		else pending_mail_log($adv_ali,"BADV");
		//if($abc)return TRUE;else return FALSE;
	}
}
?>