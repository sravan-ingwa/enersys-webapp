<?php 
require '../Slim/Slim.php';
include ('../mysql.php');
include ('../functions.php');
require('../Classes/PHPExcel.php');
require('../Classes/PHPExcel/IOFactory.php');
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->post('/expense_add','expense_add');
$app->post('/expense_update','expense_update');
$app->post('/expense_mul_view','expense_mul_view');
$app->post('/expense_single_view','expense_single_view');
$app->run();

function expense_add(){global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
	$alias = aliasCheck(generateRandomString(),'ec_contract_price','contract_price_alias');
	$esca_name =strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['employee_alias']));
	$zone_name =strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['zone_alias']));
	$state_name =strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['state_alias']));
	$esca_desc = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['esca_desc']));
	$mile_stone_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mile_stone_alais']));
	$amount = mysqli_real_escape_string($mr_con,$_REQUEST['amount']);
	$unit = mysqli_real_escape_string($mr_con,$_REQUEST['unit']);
	if(empty($esca_name)){$res="Please Enter ESCA Name";}
	elseif(empty($esca_desc)){$res="Please Enter ESCA Description";}
	elseif(empty($mile_stone_alias)){$res="Please Enter Milestone";}
	elseif(empty($amount)){$res-="Please Enter Amount";}
	elseif(empty($unit)){$res-="Please Enter Unit";}
	else{
		$sql=mysqli_query($mr_con,"SELECT id FROM ec_contract_price WHERE esca_name='$esca_name' AND mile_stone_alais='$mile_stone_alias' AND flag=0");
		if(mysqli_num_rows($sql)==0){
			$q=mysqli_query($mr_con,"INSERT INTO ec_contract_price(esca_name,zone_alias,state_alias,esca_desc,mile_stone_alais,amount,unit,contract_price_alias,created_date) VALUES('$esca_name','$zone_name','$state_name','$esca_desc','$mile_stone_alias','$amount','$unit','$alias','".date('Y-m-d')."')");
			if($q){
				$action=alias($esca_name,'ec_employee_master','employee_alias','name')." ESCA created in contract price";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode='0'; $resMsg='Successfull!'; }else{$resCode='4'; $resMsg='Error in adding!';}
			}else{$res="The Requested ESCA Name has already exist, Try with other values";}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function expense_update(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
	$alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['contract_price_alias'])));
	$esca_name = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['esca_name']));
	$mile_stone_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mile_stone_alais']));
	$zone_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['zone_alias']));
	$state_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['state_alias']));
	$amount = mysqli_real_escape_string($mr_con,$_REQUEST['amount']);
	$unit = mysqli_real_escape_string($mr_con,$_REQUEST['unit']);
	if(empty($esca_name)){$res="Please Enter ESCA Name";}
	elseif(empty($mile_stone_alias)){$res="Please Enter Milestone";}
	elseif(empty($zone_alias)){$res="Please Enter Zone";}	
	elseif(empty($state_alias)){$res-="Please Enter State";}
	elseif(empty($amount)){$res-="Please Enter Amount";}
	elseif(empty($unit)){$res-="Please Enter Unit";}
	else{
		$sql=mysqli_query($mr_con,"SELECT id FROM ec_contract_price WHERE esca_name='$esca_name' AND mile_stone_alais='$mile_stone_alias' AND contract_price_alias<>'$alias' AND flag=0");
		//echo "SELECT id FROM ec_contract_price WHERE contract_price_alias<>'$alias' AND flag=0";
		if(mysqli_num_rows($sql)==0){
			$q=mysqli_query($mr_con,"UPDATE ec_contract_price SET esca_name='$esca_name',mile_stone_alais='$mile_stone_alias',zone_alias='$zone_alias',state_alias='$state_alias',amount='$amount',unit='$unit' WHERE contract_price_alias='$alias' AND flag=0");
			if($q){
				$action=alias($esca_name,'ec_employee_master','employee_alias','name')." ESCA updated in contract price";
				user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
				$resCode = '0';$resMsg='Successfull!';}else{$resCode = '4';$resMsg='Error in Updating!';}
		}else{$res="The Requested ESCA Name has already exist, Try with other values";}
		}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		if(isset($res)){$resCode='4';$resMsg=$res;}
		$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
		echo json_encode($result);
}
function expense_mul_view(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		if($_REQUEST['EscaName']!="")$esca_name="name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['EscaName'])."%' AND ";else $esca_name="";
		if($_REQUEST['escaDesc']!="")$esca_desc="esca_desc LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['escaDesc'])."%' AND ";else $esca_desc="";
		if($_REQUEST['milestone']!="")$milestone="mile_stone_alais ='".mysqli_real_escape_string($mr_con,$_REQUEST['milestone'])."' AND ";else $milestone="";
		if($_REQUEST['zoneAlias']!="")$zone_alias="zone_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['zoneAlias'])."' AND ";else $zone_alias="";
		if($_REQUEST['amount']!="")$amount="amount LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['amount'])."%' AND ";else $amount="";
		if($_REQUEST['unit']!="")$unit="unit LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['unit'])."%' AND ";else $unit="";
		$condition=$esca_desc.$milestone.$zone_alias.$amount.$unit;
		if(strtoupper($emp_alias)=='ADMIN'){$emp = "";}
		else{
			$state_alias  = alias($emp_alias,'ec_employee_master','employee_alias','state_alias');
			$states = "'".implode("','",explode(", ",$state_alias))."'";
			$emp = "state_alias IN ($states) AND";}
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_contract_price WHERE $condition flag=0 AND $emp esca_name IN (SELECT employee_alias FROM ec_employee_master WHERE $esca_name flag=0)");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT * FROM ec_contract_price WHERE $condition flag=0 AND $emp esca_name IN (SELECT employee_alias FROM ec_employee_master WHERE $esca_name flag=0) LIMIT 0, 10");
			$result['contractpriceDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){ $xyz='';
					$result['contractpriceDetails'][$i]['esca_name']=alias($row['esca_name'],'ec_employee_master','employee_alias','name');
					$result['contractpriceDetails'][$i]['esca_desc']=$row['esca_desc'];
					$result['contractpriceDetails'][$i]['mile_stone']=alias($row['mile_stone_alais'],'ec_milestone','mile_stone_alais','mile_stone');
					$zone = $row['zone_alias'];
					$zones = explode(", ",$zone);
					foreach($zones as $z){$xyz .= alias($z,'ec_zone','zone_alias','zone_name').", ";}
					$result['contractpriceDetails'][$i]['zone_name']=trim($xyz,", ");
					$result['contractpriceDetails'][$i]['contract_price_alias']=$row['contract_price_alias'];
					$result['contractpriceDetails'][$i]['amount']=$row['amount'];
					$result['contractpriceDetails'][$i]['unit']=$row['unit'];
					$i++;}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}
	}elseif($rex==1){
		$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	if($totalRecords>=1)for($x=1;$x<=$totalpages;$x++)$result['pages'][$x]['pagx']=$x;else $result['pages'][1]['pagx']=1;
	echo json_encode($result);		

	}
function expense_single_view(){ global $mr_con;
		$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
		if($chk==0){
			$sql=mysqli_query($mr_con,"SELECT * FROM ec_contract_price WHERE contract_price_alias='$_REQUEST[alias]' AND flag=0");
			if(mysqli_num_rows($sql)>0){
				while($row=mysqli_fetch_array($sql)){
					$result['esca_name']=alias($row['esca_name'],'ec_employee_master','employee_alias','name');
					$result['esca_name_update']=$row['esca_name'];
					$result['esca_desc']=$row['esca_desc'];
					$result['mile_stone']=alias($row['mile_stone_alais'],'ec_milestone','mile_stone_alais','mile_stone');
					$result['mile_stone_alais']=$row['mile_stone_alais'];
				
					$result['zone_alias']=$row['zone_alias'];
					$zone = explode(", ",$row['zone_alias']);
					foreach($zone as $z){ $zz .= alias($z,'ec_zone','zone_alias','zone_name').", "; }
					$result['zone_name'] = trim($zz,", ");
					
					$result['state_alias']=$row['state_alias'];
					$state = explode(", ",$row['state_alias']);
					foreach($state as $s){ $ss .= alias($s,'ec_state','state_alias','state_name').", "; }
					$result['state_name'] = trim($ss,", ");

					$result['contract_price_alias']=$row['contract_price_alias'];
					$result['amount']=$row['amount'];
					$result['unit']=$row['unit'];
				}
				$resCode='0'; $resMsg='Successfull!';
				}else{$resCode='4'; $resMsg='No Records Found';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
		else{$resCode='2';$resMsg='Account Locked!';}
		$result['ErrorDetails']['ErrorCode']='2';$result['ErrorDetails']['ErrorMessage']='Account Locked!';
		echo json_encode($result);
}
?>