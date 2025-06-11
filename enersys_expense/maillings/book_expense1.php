<?php
date_default_timezone_set("Asia/Kolkata");
function dat($a){if(!empty($a))return date_format(date_create($a),"jS M Y");else return false;}
$adv_ali=$_REQUEST['ref'];
//$adv_ali="5E90A4IUV6UKD";
if($adv_ali!=""){
	$requester=$Approvals1=$Approvals2=$Approvals3=$Approvals4=array();
	$lconTotal=$oexptotal=$lodTotal=$bodTotal=$conTotal=0;
	include('../functions1.php');
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
	/*if($level>=1){if(approvelLevelemplist($emp_ddp,'1')!='0'){array_push($Approvals1,approvelLevelemplist($emp_ddp,'1'));}}
	if($level>=2){if(approvelLevelemplist($emp_ddp,'2')!='0'){array_push($Approvals2,approvelLevelemplist($emp_ddp,'2'));}}
	if($level>=3){if(approvelLevelemplist($emp_ddp,'3')!='0'){array_push($Approvals3,approvelLevelemplist($emp_ddp,'3'));}}
	if($level>=4){if(approvelLevelemplist($emp_ddp,'4')!='0'){array_push($Approvals1,approvelLevelemplist($emp_ddp,'4'));}}*/
	
	$toList=array_merge($requester,$Approvals1,$Approvals2,$Approvals3,$Approvals4);
	
	foreach($toList as $to){
		 $to_mail_id = employeeDetails('email_id',$to);
		$settleAmount=advanceNotSettled($adv_req[0]['employee_alias']);
/*
		if($level==1 && checkApproval_admin($to)==0 && checkApproval($to)==0){$sub = "Acknowledgement for Expense-".$adv_req[0]['bill_number'];}
		if($level==1 && checkApproval_admin($to)==0 && checkApproval($to)==1){$sub = "Expense Booked By ".employeeDetails('name',$adv_req[0]['employee_alias'])."-".$adv_req[0]['bill_number'];}

		if($level==2 && checkApproval_admin($to)==0 && checkApproval($to)==0){$sub = "Expense -Sent for SCMT Approval-".$adv_req[0]['bill_number'];}
		if($level==2 && checkApproval_admin($to)==0 && checkApproval($to)==1){$sub ="Expense -Sent for SCMT Approval-".$adv_req[0]['bill_number'];}
		if($level==2 && checkApproval_admin($to)==1 && checkApproval($to)==1){$sub = "Expense Booked By ".employeeDetails('name',$adv_req[0]['employee_alias'])."-".$adv_req[0]['bill_number'];}

		if($level==3 && checkApproval_admin($to)==0 && checkApproval($to)==0){$sub = "Expense -Sent for Finance Approval-".$adv_req[0]['bill_number'];}
		if($level==3 && checkApproval_admin($to)==0 && checkApproval($to)==1){$sub = "Expense -Sent for Finance Approval-".$adv_req[0]['bill_number'];}
		if($level==3 && checkApproval_admin($to)==1 && checkApproval($to)==1){$sub = "Expense -Sent for Finance Approval-".$adv_req[0]['bill_number'];}
		if($level==3 && checkApproval_admin($to)==2 && checkApproval($to)==1){$sub = "Expense Booked  By ".employeeDetails('name',$adv_req[0]['employee_alias'])."-".$adv_req[0]['bill_number'];}
		if($level==5){$sub = "Expense Approved-".$adv_req[0]['bill_number'];}
		if($level==7){$sub = "Expense Rejected-".$adv_req[0]['bill_number'];}
*/
		$sub = "Expense Request-".$adv_req[0]['bill_number'];
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
							$res.="<td align='center'><h3>Acknowledgement for Expenses</h3></td>";
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
						if($level==1 && approvelLevelCheck($to,1)==1){
							$res.="<tr>";
								$res.="<td align='right'><a href='http://enersyscare.co.in/enersys_expense/approvals/expense1.php?ref=".$adv_ali."&type=1&apby=".$to."' style='display:inline-block;background-color: #428bca;  color: #fff;padding: 0 7px; line-height: 25px;'>Accept</a></td>";
								$res.="<td align='left'><a href='http://enersyscare.co.in/enersys_expense/approvals/expense1.php?ref=".$adv_ali."&type=0&apby=".$to."' style='display:inline-block;background-color: #428bca;  color: #fff;padding: 0 7px; line-height: 25px;'>Reject</a></td>";
							$res.="</tr>";
						}
						if($level==2 && approvelLevelCheck($to,4)==1){
							$res.="<tr>";
								$res.="<td align='right'><a href='http://enersyscare.co.in/enersys_expense/approvals/expense1.php?ref=".$adv_ali."&type=1&apby=".$to."' style='display:inline-block;background-color: #428bca;  color: #fff;padding: 0 7px; line-height: 25px;'>Accept</a></td>";
								$res.="<td align='left'><a href='http://enersyscare.co.in/enersys_expense/approvals/expense1.php?ref=".$adv_ali."&type=0&apby=".$to."' style='display:inline-block;background-color: #428bca;  color: #fff;padding: 0 7px; line-height: 25px;'>Reject</a></td>";
							$res.="</tr>";
						}
						if($level==3 && approvelLevelCheck($to,2)==1){
							$res.="<tr>";
								$res.="<td align='right'><a href='http://enersyscare.co.in/enersys_expense/approvals/expense1.php?ref=".$adv_ali."&type=1&apby=".$to."' style='display:inline-block;background-color: #428bca;  color: #fff;padding: 0 7px; line-height: 25px;'>Accept</a></td>";
								$res.="<td align='left'><a href='http://enersyscare.co.in/enersys_expense/approvals/expense1.php?ref=".$adv_ali."&type=0&apby=".$to."' style='display:inline-block;background-color: #428bca;  color: #fff;padding: 0 7px; line-height: 25px;'>Reject</a></td>";
							$res.="</tr>";
						}
						if($level==4 && approvelLevelCheck($to,3)==1){
							$res.="<tr>";
								$res.="<td align='right'><a href='http://enersyscare.co.in/enersys_expense/approvals/expense1.php?ref=".$adv_ali."&type=1&apby=".$to."' style='display:inline-block;background-color: #428bca;  color: #fff;padding: 0 7px; line-height: 25px;'>Accept</a></td>";
								$res.="<td align='left'><a href='http://enersyscare.co.in/enersys_expense/approvals/expense1.php?ref=".$adv_ali."&type=0&apby=".$to."' style='display:inline-block;background-color: #428bca;  color: #fff;padding: 0 7px; line-height: 25px;'>Reject</a></td>";
							$res.="</tr>";
						}
						$res.="<tr>";$res.="<td align='right' colspan='2'><br></td>";$res.="</tr>";
					$res.="</table>";
				$res.="<br><br></td>";
			$res.="</tr>";
		$res.="</table><br><br>";
		$body=$res;
		$body.="<p style='font-style:italic;text-align:center;'><small>*** This is a System generated email, Please do not reply ***</small></p>";
		//echo $body;
		$from=all_from_mail();
		$headers="From: EnerSys Expenses<$from>\r\n";
		$headers.="Reply-To: $from\r\n";
		$headers.="Return-Path: $from\r\n";
		//$headers.= "CC: $ccemail \r\n";
		//$headers .= "BCC: $bccemail \r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$abc = mail($to_mail_id,$sub,$body,$headers);
		//if($abc)return TRUE;else return FALSE;
	}
}
?>