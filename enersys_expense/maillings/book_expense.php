<?php
date_default_timezone_set("Asia/Kolkata");
function dat($a){if(!empty($a))return date_format(date_create($a),"jS M Y");else return false;}
$adv_ali=$_REQUEST['ref'];
//$adv_ali="EP2I7EWTTT";
if($adv_ali!=""){
	$requester=$Approvals1=$Approvals2=$Approvals3=$Approvals4=array();
	$oexptotal=$lodTotal=$bodTotal=$conTotal=0;
	include('../functions.php');
	$adv_req=expensefullView($adv_ali);

	$conveyance=ec_conveyance($adv_req[0]['expenses_alias']);
	if($conveyance!='0'){foreach($conveyance as $conveyance1){$conTotal+=$conveyance1['amount'];}}
	
	$lconveyance=ec_localconveyance($adv_req[0]['expenses_alias']);
	if($lconveyance!='0'){foreach($lconveyance as $lconveyance1){$lconTotal+=$lconveyance1['amount'];}}

	$lodging=ec_lodging($adv_req[0]['expenses_alias']);
	if($lodging!='0'){foreach($lodging as $lodging1){$lodTotal+=$lodging1['amount'];}}
	
	$boarding=ec_boarding($adv_req[0]['expenses_alias']);
	if($boarding!='0'){foreach($boarding as $boarding1){$bodTotal+=$boarding1['amount'];}}

	$other_expenses=ec_other_expenses($adv_req[0]['expenses_alias']);
	if($other_expenses!='0'){foreach($other_expenses as $other_expenses1){$oexptotal+=$other_expenses1['amount'];}}

	if(advanceNotSettled($adv_req[0]['employee_alias'])!=0)$avns=moneyFormatIndia(advanceNotSettled($adv_req[0]['employee_alias'])); else $avns="No pending Advances";
	$level=$adv_req[0]['approval_level'];
	$requester=explode("|", $adv_req[0]['employee_alias']);
	$remarks=getRemarks($adv_ali,"BE");
	$emp_ddp=employeeDetails('department_alias',$adv_req[0]['employee_alias']);
	if($level == 1 && approvelLevelemplist($emp_ddp, '1') != '0') { 
		array_push($Approvals1,approvelLevelemplist($emp_ddp,'1')); 
	}
	if($level==2 && approvelLevelemplist($emp_ddp, '4')!='0') {
		array_push($Approvals2, approvelLevelemplist($emp_ddp, '4'));
	}
	if($level==3 && approvelLevelemplist($emp_ddp, '2')!='0') {
		array_push($Approvals2, approvelLevelemplist($emp_ddp, '2'));
	}
	if($level==4 && approvelLevelemplist($emp_ddp, '3')!='0') {
		array_push($Approvals3, approvelLevelemplist($emp_ddp, '3'));
	}
	if($level==5 && approvelLevelemplist($emp_ddp, '5')!='0') {
		array_push($Approvals3, approvelLevelemplist($emp_ddp, '5'));
	}

	$toList=array_merge($requester,$Approvals1,$Approvals2,$Approvals3,$Approvals4);
	foreach($toList as $key=>$to){
		$to_mail_id = employeeDetails('email_id',$to);
		$settleAmount=advanceNotSettled($adv_req[0]['employee_alias']);
		$headline = "Acknowledgement for Expenses";
		$sub = "Expense Request-".$adv_req[0]['bill_number'];
		$approveBeforeEncode = "expense@@" . $adv_req[0]['expenses_alias'] . "@@" . $to . "@@request@@" . $level;
		$rejectBeforeEncode = "expense@@" . $adv_req[0]['expenses_alias'] . "@@" . $to . "@@reject@@" . $level;
		$approveUrl = baseurl() . "includes/expenses_dynamic_remark.php?verify=" . base64_encode($approveBeforeEncode);
		$rejectUrl = baseurl() . "includes/expenses_dynamic_remark.php?verify=" . base64_encode($rejectBeforeEncode);

		$addApproval = false;
		if($adv_req[0]['employee_alias'] != $to) {
			if($level==1 && approvelLevelemplist($emp_ddp, '1') != '0') {
				$headline = "Expenses Request - ".$adv_req[0]['bill_number'];
				$addApproval = true;
			}
			if($level == 2 && approvelLevelemplist($emp_ddp, '4') != '0') {
				$headline = "Expenses Request - ".$adv_req[0]['bill_number'];
				$addApproval = true;
			}
			if($level==3 && approvelLevelemplist($emp_ddp, '2')!='0') {
				$headline = "Expenses Request - ".$adv_req[0]['bill_number'];
				$addApproval = true;
			}
			if($level==4 && approvelLevelemplist($emp_ddp, '3')!='0') {
				$headline = "Expenses Request - ".$adv_req[0]['bill_number'];
				$addApproval = true;
			}
			if($level == 5 && approvelLevelemplist($emp_ddp, '5') != '0') {
				$headline = "Expenses Request - ".$adv_req[0]['bill_number'];
				$addApproval = true;
			}	
		} else {
			if($key > 0 && $level==3 && approvelLevelemplist($emp_ddp, '2')!='0') {
				$headline = "Expenses Request - ".$adv_req[0]['bill_number'];
				$addApproval = true;
			}
			if($key > 0 && $level == 4 && approvelLevelemplist($emp_ddp, '3') != '0') {
				$headline = "Expenses Request - ".$adv_req[0]['bill_number'];
				$addApproval = true;
			}
		}
		$sub = "Expense Request-".$adv_req[0]['bill_number'];
		if ($adv_req[0]["approval_level_name"] == "DRAFT") {
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
							$res.="<td align='right'><b>Bill No :</b>".$adv_req[0]['bill_number']."</td>";
						$res.="</tr>";
						$res.="<tr>";
							$res.="<td align='right'><b>PO /GR Number :</b>".$adv_req[0]['po_gnr']."</td>";
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
							$res.="<td style='border:1px solid #ddd;'><b>Period Of Visit From : </b>".dat($adv_req[0]['period_of_visit_from'])."</td>";
							$res.="<td style='border:1px solid #ddd;'><b>Period Of Visit To : </b>".dat($adv_req[0]['period_of_visit_to'])."</td>";
						$res.="</tr>";
						$res.="<tr>";
							$res.="<td style='border:1px solid #ddd;'><b>Places Of Visit : </b>".ucfirst($adv_req[0]['places_of_visit'])."</td>";
							$res.="<td style='border:1px solid #ddd;'><b>Purpose : </b>".ucfirst($adv_req[0]['purpose'])."</td>";
						$res.="</tr>";
						$res.="<tr>";
							$res.="<td style='border:1px solid #ddd;'><b>Total Conveyance : </b>".moneyFormatIndia($conTotal)."</td>";
							$res.="<td style='border:1px solid #ddd;'><b>Total Local Conveyance : </b>".moneyFormatIndia($lconTotal)."</td>";
						$res.="</tr>";
						$res.="<tr>";
							$res.="<td style='border:1px solid #ddd;'><b>Total Lodging : </b>".moneyFormatIndia($lodTotal)."</td>";
							$res.="<td style='border:1px solid #ddd;'><b>Total Boarding : </b>".moneyFormatIndia($bodTotal)."</td>";
						$res.="</tr>";
						$res.="<tr>";
							$res.="<td style='border:1px solid #ddd;'><b>Other Expense (Total) : </b>".moneyFormatIndia($oexptotal)."</td>";
							$res.="<td style='border:1px solid #ddd;'><b>Outstanding Balance : </b>".$avns."</td>";
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
							$res.="<td align='right' colspan='2'>Total Expenses : <b>Rs.".moneyFormatIndia($adv_req[0]['total_tour_expenses'])."</b></td>";
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
		if($abc)success_mail_log($adv_ali,"BEXP");
		else pending_mail_log($adv_ali,"BEXP");
		//if($abc)return TRUE;else return FALSE;
	}
}
?>