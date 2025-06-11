<?php
include('../services/mysql.php');
include('../services/functions.php');
if(isset($_REQUEST['emp_alias']) && isset($_REQUEST['mrf_alias']) && isset($_REQUEST['password']) && isset($_REQUEST['remarks']) && isset($_REQUEST['ref'])){
	$link=mysqli_real_escape_string($mr_con,$_REQUEST['link']);
	$emp_alias=mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$mrf_alias=mysqli_real_escape_string($mr_con,$_REQUEST['mrf_alias']);
	$ref=mysqli_real_escape_string($mr_con,$_REQUEST['ref']);
	$password=mysqli_real_escape_string($mr_con,$_REQUEST['password']);
	$remarks=mysqli_real_escape_string($mr_con,$_REQUEST['remarks']);
	if(empty($emp_alias))$res = "Sorry try again";
	elseif(empty($mrf_alias))$res = "Sorry try again";
	elseif(empty($password))$res = "Please Enter Password";
	elseif(empty($remarks))$res = "Please Enter Remarks";
	else{
		// $chsql=mysqli_query($mr_con,"SELECT id FROM ec_employee_master WHERE password='$password' AND employee_alias='$emp_alias' AND flag='0'");
		$chsql = 1;
		if($chsql){
			$q=mysqli_query($mr_con,"SELECT sjo_number FROM ec_material_request WHERE mrf_alias='$mrf_alias' AND flag=0");
			if(mysqli_num_rows($q)>0){
				$mrf_row=mysqli_fetch_array($q);
				$list=next_dynamic($mrf_alias,'E','L');
				if(!empty($list)){
					list($next,$emp_ali)=explode("_",$list);
					if($ref=='1'){$condition=" status = '".($next=='L' ? '2':'1')."' ";$action = "Dynamic Approve:".alias($emp_alias,'ec_employee_master','employee_alias','name')." Approve"; $bucket="21";}
					elseif($ref=='2'){$condition=" status = '10' ";$action = "Dynamic Reject:".alias($emp_alias,'ec_employee_master','employee_alias','name')." Reject"; $bucket="22";}
					else {$condition=" status = '7' ";$action = "Dynamic Hold:".alias($emp_alias,'ec_employee_master','employee_alias','name')." Hold"; $bucket="20";}
				}else{$condition=" status = '2' ";$action = "Dynamic Approve: Approve"; $bucket="21"; }
				$sqlreq=mysqli_query($mr_con,"UPDATE ec_material_request SET $condition WHERE mrf_alias='$mrf_alias' AND flag='0'");
				$remark_alias = alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias');
				$sqlrem = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','MR','$bucket','$mrf_alias','$emp_alias','$remark_alias')");
				if($sqlrem && $sqlreq){
					$action=$msg=$action." the requested Stock against SJO Number - ".$mrf_row['sjo_number'];
					curlxing(baseurl()."services/inventory/mails/mrdmails?a=".$mrf_alias."&bucket=".$bucket);
					inventory_notification($mrf_alias,$msg,'3');
					user_history($emp_alias,$action,"He submitted the requested through email.");
					if($ref=='1' || $ref=='2'){
						if(strpos($emp_ali,",")!==false)$cooo="IN('".str_replace(",","','",$emp_ali)."')";else $cooo="='$emp_ali'";
						$sql = mysqli_query($mr_con,"UPDATE ec_dynamic_verification SET flag='1' WHERE mrf_alias='$mrf_alias' AND employee_alias $cooo AND flag=0");
					}else $sql=TRUE;
					if($sql)$resMsg="0@@Your Remark Successfully Submitted";
					else $res="Sorry try again!";
				}
			}else{$res='Action Not Succesful! Try again Later';}
		}else $res="Wrong Password! Please try again";
	}if(isset($res) && !empty($res))$resMsg="4@@".$res;
	echo $resMsg;
}else echo "4@@Sorry try again!";
?>