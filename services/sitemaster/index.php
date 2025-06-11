<?php
date_default_timezone_set("Asia/Kolkata");
include ('../Classes/PHPExcel.php');
require ('../Classes/PHPExcel/IOFactory.php');
require ('../Slim/Slim.php');
include ('../mysql.php');
include ('../functions.php');
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->post('/sitemaster_add','sitemaster_add');
$app->post('/sitemaster_update','sitemaster_update');
$app->post('/sitemaster_mul_view','sitemaster_mul_view');
$app->post('/sitemaster_view','sitemaster_view');
$app->post('/sitemaster','sitemaster');
$app->post('/sitemaster_export','sitemaster_export');
$app->post('/sitemaster_import','sitemaster_import');
$app->post('/sitemanfdate','sitemanfdate');
$app->post('/delete','sitemaster_delete');
$app->post('/restore','sitemaster_restore');
$app->post('/sitemaster_can_be_deleted','sitemaster_can_be_deleted');

$app->run();
function sitemaster_add(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$rex=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($rex==0){
		$site_alias = aliasCheck(generateRandomString(),'ec_sitemaster','site_alias');
		$zone_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['zone_alias'])));
		$state_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['state_alias'])));
		$district_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['district_alias'])));
		$segment_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['segment_alias'])));
		$customer_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['customer_alias'])));
		$site_type_alias = strtoupper(trim(mysqli_real_escape_string($mr_con,$_REQUEST['site_type_alias'])));
		$site_id = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['site_id'])));
		$site_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['site_name'])));
		$product_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['product_alias'])));
		$mfd_date = mysqli_real_escape_string($mr_con,dateFormat(trim($_REQUEST['mfd_date']),'y'));
		$install_date = mysqli_real_escape_string($mr_con,dateFormat(trim($_REQUEST['install_date']),'y'));
		
		$po_num = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['po_num'])));
		$sale_invoice_num = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['sale_invoice_num'])));
		$sale_invoice_date = mysqli_real_escape_string($mr_con,dateFormat(trim($_REQUEST['sale_invoice_date']),'y'));
		
		$no_of_string = mysqli_real_escape_string($mr_con,trim($_REQUEST['no_of_string']));
		$technician_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['technician_name'])));
		$technician_number = mysqli_real_escape_string($mr_con,trim($_REQUEST['technician_number']));
		$manager_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['manager_name'])));
		$manager_number = mysqli_real_escape_string($mr_con,trim($_REQUEST['manager_number']));
		$manager_mail = strtolower(mysqli_real_escape_string($mr_con,trim($_REQUEST['manager_mail'])));
		$site_address = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['site_address'])));
		$batt_rating = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['batt_rating'])));
		if(empty($zone_alias)){$res="Select Zone";}
		elseif(empty($state_alias)){$res="Select State";}
		elseif(empty($district_alias)){$res="Select District";}
		elseif(empty($segment_alias)){$res="Select Segment";}
		elseif(empty($customer_alias)){$res="Select Customer";}
		elseif(empty($site_type_alias)){$res="Select Site Type";}
		elseif(empty($site_id)){$res="Enter Site ID";}
		elseif(empty($site_name)){$res="Enter Site Name";}
		elseif(empty($product_alias)){$res="Please Select Product";}
		
		elseif(empty($po_num)){$res="Enter PO Number";}
		elseif(empty($sale_invoice_num)){$res="Enter Sale Invoice Number";}
		elseif(empty($sale_invoice_date)){$res="Choose Sale Invoice Date";}
		
		elseif($mfd_date=='NA' && $install_date=='NA'){$res="Choose Manufactured Date OR Installation Date";}
		elseif(empty($no_of_string)){$res="Enter No Of String";}
		elseif(empty($technician_name)){$res="Enter First Level Contact Name";}
		elseif(empty($technician_number) || !preg_match("/^[6-9]\d{9}$/",$technician_number)){$res="Enter Valid First Level Contact Number";}
		elseif(empty($manager_name)){$res="Enter Second Level Contact Name";}
		elseif(empty($manager_number) || !preg_match("/^[6-9]\d{9}$/",$manager_number)){$res="Enter Valid Second Level Contact Number";}
		elseif(empty($manager_mail)){$res="Enter Second Level Contact Mail";}
		elseif(empty($site_address)){$res="Enter Site Address";}
		elseif(empty($batt_rating)){$res="Enter Battery Rating";}
		else{
			$sql = "SELECT id FROM ec_sitemaster WHERE site_id ='$site_id' AND product_alias LIKE '%$product_alias%' AND customer_alias='$customer_alias' AND state_alias='$state_alias' AND segment_alias !='TMRY7UL2VI' AND flag=0";
			$query=mysqli_query($mr_con, $sql);
			//$query=mysqli_query($mr_con,"SELECT id FROM ec_sitemaster WHERE site_id ='$site_id' AND state_alias='$state_alias' AND flag=0");
			if(mysqli_num_rows($query)=='0'){
				$iQuery = "INSERT INTO ec_sitemaster(zone_alias,state_alias,district_alias,segment_alias,customer_alias,site_type_alias,site_id,site_name,site_alias,product_alias,mfd_date,install_date,no_of_string,technician_name,technician_number,manager_name,manager_number,manager_mail,site_address,battery_bank_rating,sale_invoice_num,sale_invoice_date,po_num,created_date)VALUES('$zone_alias','$state_alias','$district_alias','$segment_alias','$customer_alias','$site_type_alias','$site_id','$site_name','$site_alias','$product_alias','$mfd_date','$install_date','$no_of_string','$technician_name','$technician_number','$manager_name','$manager_number','$manager_mail','$site_address','$batt_rating','$sale_invoice_num','$sale_invoice_date','$po_num','".date('Y-m-d')."')";
				$sql = mysqli_query($mr_con, $iQuery);
				if($sql){
					$action=$district_name." Site Name $site_name with SiteID $site_id Created";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$resCode='0';$resMsg='Successful!';
				}
			}else{$res = 'The Requested SiteID and State and Customer and Product has already exist, Try with other values'; }
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function sitemaster_update(){ 
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$rex=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($rex==0){
		$site_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['site_alias'])));
		$zone_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['zone_alias'])));		
		$state_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['state_alias'])));
		$district_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['district_alias'])));
		$segment_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['segment_alias'])));
		$customer_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['customer_alias'])));
		$site_type_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['site_type_alias'])));
		$site_id = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['site_id'])));
		$site_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['site_name'])));
		$product_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['product_alias'])));
		$mfd_date = mysqli_real_escape_string($mr_con,dateFormat(trim($_REQUEST['mfd_date']),'y'));
		$install_date = mysqli_real_escape_string($mr_con,dateFormat(trim($_REQUEST['install_date']),'y'));
		
		$po_num = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['po_num'])));
		$sale_invoice_num = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['sale_invoice_num'])));
		$sale_invoice_date = mysqli_real_escape_string($mr_con,dateFormat(trim($_REQUEST['sale_invoice_date']),'y'));
		
		$no_of_string = mysqli_real_escape_string($mr_con,trim($_REQUEST['no_of_string']));
		$technician_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['technician_name'])));
		$technician_number = mysqli_real_escape_string($mr_con,trim($_REQUEST['technician_number']));
		$manager_name = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['manager_name'])));
		$manager_number = mysqli_real_escape_string($mr_con,trim($_REQUEST['manager_number']));
		$manager_mail = strtolower(mysqli_real_escape_string($mr_con,trim($_REQUEST['manager_mail'])));
		$site_address = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['site_address'])));
		$batt_rating = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['batt_rating'])));
		if($zone_alias==''){$res="Select Zone";}
		elseif($state_alias==''){$res="Select State";}
		elseif($district_alias==''){$res="Select District";}
		elseif($segment_alias==''){$res="Select Segment";}
		elseif($customer_alias==''){$res="Select Customer";}
		elseif($site_type_alias==''){$res="Select Site Type";}
		elseif(empty($site_id)){$res="Enter Site ID";}
		elseif(empty($site_name)){$res="Enter Site Name";}
		elseif(empty($product_alias)){$res="Please Select Product";}
		
		elseif(empty($po_num)){$res="Enter PO Number";}
		elseif(empty($sale_invoice_num)){$res="Enter Sale Invoice Number";}
		elseif(empty($sale_invoice_date)){$res="Choose Sale Invoice Date";}
		
		elseif($mfd_date=='NA' && $install_date=='NA'){$res="Choose Manufactured Date OR Installation Date";}
		elseif(empty($no_of_string)){$res="Enter No Of String";}
		elseif(empty($technician_name)){$res="Enter First Level Contact Name";}
		elseif(empty($technician_number) || !preg_match("/^[6-9]\d{9}$/",$technician_number)){$res="Enter Valid First Level Contact Number";}
		elseif(empty($manager_name)){$res="Enter Second Level Contact Name";}
		elseif(empty($manager_number) || !preg_match("/^[6-9]\d{9}$/",$manager_number)){$res="Enter Valid Second Level Contact Number";}
		elseif(empty($manager_mail)){$res="Enter Second Level Contact Mail";}
		elseif(empty($site_address)){$res="Enter Site Address";}
		elseif(empty($batt_rating)){$res="Enter Battery Rating";}
		else{
			$query=mysqli_query($mr_con,"SELECT id FROM ec_sitemaster WHERE site_id ='$site_id' AND product_alias LIKE '%$product_alias%' AND customer_alias='$customer_alias' AND state_alias='$state_alias' AND site_alias<>'$site_alias' AND segment_alias !='TMRY7UL2VI' AND flag=0");
			if(mysqli_num_rows($query)=='0'){
				$upqry = "UPDATE ec_sitemaster SET zone_alias='$zone_alias',state_alias='$state_alias',district_alias='$district_alias',segment_alias='$segment_alias',customer_alias='$customer_alias',site_type_alias='$site_type_alias',site_id='$site_id',site_name='$site_name',product_alias='$product_alias',mfd_date='$mfd_date',install_date='$install_date',no_of_string='$no_of_string',technician_name='$technician_name',technician_number='$technician_number',manager_name='$manager_name',manager_number='$manager_number',manager_mail='$manager_mail',site_address='$site_address',battery_bank_rating='$batt_rating',sale_invoice_num='$sale_invoice_num',sale_invoice_date='$sale_invoice_date',po_num='$po_num' WHERE site_alias='$site_alias' AND flag=0";
				$sql = mysqli_query($mr_con, $upqry);
				if($sql){
					$tt_sql=mysqli_query($mr_con,"SELECT GROUP_CONCAT('''',ticket_alias,'''') AS tt_alias FROM ec_tickets WHERE site_alias='$site_alias' AND flag=0");
					$tt_row=mysqli_fetch_array($tt_sql);
					$tt_alias=$tt_row['tt_alias'];
					$req_sql = mysqli_query($mr_con,"UPDATE ec_material_request SET sales_invoice_no='$sale_invoice_num',sales_invoice_date='$sale_invoice_date',sales_po_no='$po_num' WHERE ticket_alias IN(".(!empty($tt_alias) ? $tt_alias : "''").") AND flag=0");
					$action=$district_name." Site Name $site_name with SiteID $site_id Updated";
					user_history($_REQUEST['emp_alias'],$action,$_REQUEST['ip_addr']);
					$resCode='0';$resMsg='Successful!';
				}
			}else{$res = 'The Requested SiteID and State and Customer and Product has already exist, Try with other values'; }
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function sitemaster_mul_view(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		if($_REQUEST['siteId']!="")$site_id="site_id LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['siteId'])."%' AND ";else $site_id="";
		if($_REQUEST['siteName']!="")$site_name="site_name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['siteName'])."%' AND ";else $site_name="";
		if($_REQUEST['zoneAlias']!="")$zone_alias="zone_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['zoneAlias'])."' AND ";else $zone_alias="";
		if($_REQUEST['stateName']!="")$state_code="state_code LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['stateName'])."%' AND ";else $state_code="";
		if($_REQUEST['customerCode']!="")$customer_code="customer_code LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['customerCode'])."%' AND ";else $customer_code="";
		if($_REQUEST['segmentAlias']!="")$segment_alias="segment_alias ='".mysqli_real_escape_string($mr_con,$_REQUEST['segmentAlias'])."' AND ";else $segment_alias="";
		if($_REQUEST['siteStatus']!=""){
			if($_REQUEST['siteStatus'] != 2){
				$site_status="site_alias IN ('".site_status(mysqli_real_escape_string($mr_con,$_REQUEST['siteStatus']))."') AND ";
			} else{
				$site_status=" flag = 9 AND ";
			}
		} else $site_status="";
		$condtion=$site_id.$site_name.$zone_alias.$segment_alias.$site_status."segment_alias !='TMRY7UL2VI' AND ";
		if(strtoupper($emp_alias)=='ADMIN'){$emp = "";}
		else{
			$state_alias  = alias($emp_alias,'ec_employee_master','employee_alias','state_alias');
			$states = "'".implode("','",explode(", ",$state_alias))."'";
			$emp = "state_alias IN ($states) AND";
		}
		if($_REQUEST['siteStatus'] != 2) {
			$query = "SELECT count(id) FROM ec_sitemaster WHERE $condtion $emp state_alias IN (SELECT state_alias FROM ec_state WHERE $state_code flag=0) AND customer_alias IN (SELECT customer_alias FROM ec_customer WHERE $customer_code flag in (0, 1))";
		} else {
			$query = "SELECT count(id) FROM ec_sitemaster WHERE $condtion $emp state_alias IN (SELECT state_alias FROM ec_state WHERE $state_code flag=0) AND customer_alias IN (SELECT customer_alias FROM ec_customer WHERE $customer_code flag in (0, 1))";
		}
		$rec = mysqli_query($mr_con, $query);
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			if($_REQUEST['siteStatus'] != 2) {
				$query = "SELECT * FROM ec_sitemaster WHERE $condtion $emp state_alias IN (SELECT state_alias FROM ec_state WHERE $state_code flag=0) AND customer_alias IN (SELECT customer_alias FROM ec_customer WHERE $customer_code flag in (0, 1)) ORDER BY ec_sitemaster.flag LIMIT $offset, $limit";
			} else {
				$query = "SELECT * FROM ec_sitemaster WHERE $condtion $emp state_alias IN (SELECT state_alias FROM ec_state WHERE $state_code flag=0) AND customer_alias IN (SELECT customer_alias FROM ec_customer WHERE $customer_code flag in (0, 1)) ORDER BY ec_sitemaster.flag LIMIT $offset, $limit";
			}
			$sql = mysqli_query($mr_con, $query);
			$result['sitemasterDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;while($row = mysqli_fetch_array($sql)){
						$result['sitemasterDetails'][$i]['zone_name']=alias($row['zone_alias'],'ec_zone','zone_alias','zone_name');
						$result['sitemasterDetails'][$i]['state_code']=alias($row['state_alias'],'ec_state','state_alias','state_code');
						$result['sitemasterDetails'][$i]['segment_code']=alias($row['segment_alias'],'ec_segment','segment_alias','segment_code');
						$result['sitemasterDetails'][$i]['customer_code']=alias($row['customer_alias'],'ec_customer','customer_alias','customer_code');
						$result['sitemasterDetails'][$i]['site_id']=$row['site_id'];
						$site_name = $row['site_name'];
						$result['sitemasterDetails'][$i]['full_site_name'] = $site_name;
						$result['sitemasterDetails'][$i]['site_name'] = ((strlen($site_name) > 12) ? substr($site_name,0,12)."..." : $site_name);
						$flag = $row['flag'];
						if($flag == 9){
							$result['sitemasterDetails'][$i]['site_status']= 'DELETED';
							$result['sitemasterDetails'][$i]['deleted']= '1';
						} else {
							$result['sitemasterDetails'][$i]['site_status']=(sitemanfdate_check($row['site_alias'])>0 ? 'UNDER WARRANTY' : 'OUT OF WARRANTY');
							$result['sitemasterDetails'][$i]['deleted']= '0';
						}
						$result['sitemasterDetails'][$i]['site_alias']=$row['site_alias'];
						$i++;
					}
			}$resCode='0'; $resMsg='Successful!';
		}else{$resCode='4'; $resMsg='No Records Found';}
		$result['import'] = grantable('IMPORT', 'SITEMASTER', $emp_alias);
		$result['export'] = grantable('EXPORT','SITEMASTER',$emp_alias);
		$result['add']=grantable('ADD','SITEMASTER',$emp_alias);
		$result['delete']=grantable('DELETE','SITEMASTER',$emp_alias);
		$result['restore']=grantable('RESTORE','SITEMASTER',$emp_alias);
	}elseif($rex==1){ $resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	echo json_encode($result);
}
function sitemaster_view(){ global $mr_con;
	$emp_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias']));
	$token=mysqli_real_escape_string($mr_con,trim($_REQUEST['token']));
	$alias= mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_sitemaster WHERE site_alias ='$alias'");
		if(mysqli_num_rows($sql)){
			while($row=mysqli_fetch_array($sql)){
				$result['site_alias']=$row['site_alias'];
				$result['zone_name']=alias($row['zone_alias'],'ec_zone','zone_alias','zone_name');
				$result['zone_alias']=$row['zone_alias'];
				$result['state_name']=alias($row['state_alias'],'ec_state','state_alias','state_name');
				$result['state_alias']=$row['state_alias'];
				$result['district_name']=alias($row['district_alias'],'ec_district','district_alias','district_name');
				$result['district_alias']=$row['district_alias'];
				$result['segment_name']=alias($row['segment_alias'],'ec_segment','segment_alias','segment_name');
				$result['segment_alias']=$row['segment_alias'];
				$result['customer_name']=alias($row['customer_alias'],'ec_customer','customer_alias','customer_name');
				$result['customer_alias']=$row['customer_alias'];
				$result['site_type']=alias($row['site_type_alias'],'ec_site_type','site_type_alias','site_type');
				$result['site_type_alias']=$row['site_type_alias'];
				$result['site_id']=$row['site_id'];
				$result['site_name']=$row['site_name'];
				
				$product = explode(", ",$row['product_alias']);
				foreach($product as $pro){ $xx .= alias($pro,'ec_product','product_alias','product_description').", "; }
				$result['product_description'] = trim($xx,", ");
				$result['product_alias']=$row['product_alias'];
				
				$result['battery_bank_rating']=$row['battery_bank_rating'];
				$result['mfd_date']=dateFormat($row['mfd_date'],'d');
				$result['install_date']=dateFormat($row['install_date'],'d');
				
				$result['sale_invoice_date']=dateFormat($row['sale_invoice_date'],'d');
				$result['sale_invoice_num']=$row['sale_invoice_num'];
				$result['po_num']=$row['po_num'];
				
				$result['no_of_string']=$row['no_of_string'];
				$result['technician_name']=$row['technician_name'];
				$result['technician_number']=$row['technician_number'];
				$result['manager_name']=$row['manager_name'];
				$result['manager_number']=$row['manager_number'];
				$result['manager_mail']=$row['manager_mail'];

				$site = sitestatus($result['customer_alias'],($result['sale_invoice_date']=='NA' ? $result['mfd_date'] : $result['sale_invoice_date']),$result['install_date']);
				$result['schedule']=$site['schedule'];
				$result['warrantyleft']=$site['warrantyleft'];
				$result['warrantymonths']=$site['warrantymonths'];
				$result['site_status']=$site['warrantystatus'];

				$result['site_address']=$row['site_address'];
				$result['created_date']=dateFormat($row['created_date'],'d');
				if($row['flag'] == 0) {
					$result['edit']=grantable('EDIT','SITEMASTER',$emp_alias);
				} else {
					$result['edit']=false;
				}
				
			}
		}else{$resCode='4';$resMsg='No Records Found!';}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function sitemaster(){ global $mr_con;
	$emp_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias']));
	$token=mysqli_real_escape_string($mr_con,trim($_REQUEST['token']));
	$alias= mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_sitemaster WHERE site_alias ='$alias' AND flag=0");
		if(mysqli_num_rows($sql)){
			while($row=mysqli_fetch_array($sql)){
				$result['site_alias']=$row['site_alias'];
				$result['zone_name']=alias($row['zone_alias'],'ec_zone','zone_alias','zone_name');
				$result['zone_alias']=$row['zone_alias'];
				$result['state_name']=alias($row['state_alias'],'ec_state','state_alias','state_name');
				$result['state_alias']=$row['state_alias'];
				$result['district_name']=alias($row['district_alias'],'ec_district','district_alias','district_name');
				$result['district_alias']=$row['district_alias'];
				$result['segment_name']=alias($row['segment_alias'],'ec_segment','segment_alias','segment_name');
				$result['segment_alias']=$row['segment_alias'];
				$result['customer_name']=alias($row['customer_alias'],'ec_customer','customer_alias','customer_name');
				$result['customer_alias']=$row['customer_alias'];
				$result['site_type']=alias($row['site_type_alias'],'ec_site_type','site_type_alias','site_type');
				$result['site_type_alias']=$row['site_type_alias'];
				$result['site_id']=$row['site_id'];
				$result['site_name']=$row['site_name'];
				
				$product = explode(", ",$row['product_alias']);
				foreach($product as $pro){ $xx .= alias($pro,'ec_product','product_alias','product_description').", "; }
				$result['product_description']=trim($xx,", ");
				$result['product_alias']=$row['product_alias'];
				
				$result['battery_bank_rating']=$row['battery_bank_rating'];
				$result['mfd_date']=dateFormat($row['mfd_date'],'d');
				$result['install_date']=dateFormat($row['install_date'],'d');
				
				$result['sale_invoice_date']=dateFormat($row['sale_invoice_date'],'d');
				$result['sale_invoice_num']=$row['sale_invoice_num'];
				$result['po_num']=$row['po_num'];
				
				$result['no_of_string']=$row['no_of_string'];
				$result['technician_name']=$row['technician_name'];
				$result['technician_number']=$row['technician_number'];
				$result['manager_name']=$row['manager_name'];
				$result['manager_number']=$row['manager_number'];
				$result['manager_mail']=$row['manager_mail'];
				$result['site_status']=alias($row['site_status_alias'],'ec_site_status','site_status_alias','site_status');
				$result['site_status_alias']=$row['site_status_alias'];
				$result['site_address']=$row['site_address'];
				$result['created_date']=dateFormat($row['created_date'],'d');
				$resCode='4';$resMsg='Success';
			}
		}else{$resCode='4';$resMsg='No Records Found!';}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function sitemaster_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){ $con='';
		if(isset($_REQUEST['zone_alias']) && count($_REQUEST['zone_alias'])>0){
			$zone = implode("|",$_REQUEST['zone_alias']);
			$zone_arr = $_REQUEST['zone_alias'];
			$con .= " zone_alias RLIKE '$zone' AND";
		}else{$con .='';}
		if(isset($_REQUEST['state_alias']) && count($_REQUEST['state_alias'])>0){
			$state = implode("|",$_REQUEST['state_alias']);
			$state_arr = $_REQUEST['state_alias'];
			$con .= " state_alias RLIKE '$state' AND";
		}else{$con .= '';}
		if(isset($_REQUEST['product_alias']) && count($_REQUEST['product_alias'])>0){
			$product = implode("|",$_REQUEST['product_alias']);
			$product_arr = $_REQUEST['product_alias'];
			$con .= " product_alias RLIKE '$product' AND";
		}else{$con .= '';}
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_sitemaster WHERE $con flag=0");
		$colArr=array('Site ID','Site Name','Manufacturing Date','Installation Date','Sale Invoice Date','Sale Invoice Num','Sale PO Number','Number of Strings','First Level Contact Name','First Level Contact Number','Second Level Contact Name','Second Level Contact Number','Second Level Contact Mail','Site Address','Battery Bank Rating','Zones','State','Districts','Segment','Customer Code','Product Code','Site Type','Site Status');
		$colArr2=array('site_id','site_name','mfd_date','install_date','sale_invoice_date','sale_invoice_num','po_num','no_of_string','technician_name','technician_number','manager_name','manager_number','manager_mail','site_address','battery_bank_rating');
		$filename = 'sitemaster_'.date('d-m-Y H_i_s');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getProperties()->setCreator("EnersysCare")->setLastModifiedBy("EnersysCare")->setTitle("Office 2007 XLSX SiteMaster Document")->setSubject("Office 2007 XLSX SiteMaster Document")->setDescription("SiteMaster document for Office 2007 XLSX, generated using PHP classes.");
		$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
		$ch = 'A';
		foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			if($ch=='C' || $ch=='D' || $ch=='E'){$objPHPExcel->getActiveSheet()->getStyle($ch)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$objPHPExcel->getActiveSheet()->getColumnDimension($ch)->setAutoSize(true);}
		$ch++;
		}
		$coo=1;
		while($row=mysqli_fetch_array($sql)){ 
			$zone_alias = explode(", ",$row['zone_alias']);
			$zcnt=count($zone_alias);
			$state_alias = explode(", ",$row['state_alias']);
			$scnt=count($state_alias);
			$product_alias = explode(", ",$row['product_alias']);
			$pcnt=count($product_alias);
			$max = max($zcnt,$scnt,$pcnt);
			for($s=0;$s<$max;$s++){
				$a = (count($zone_arr) ? in_array($zone_alias[$s],$zone_arr) : TRUE);
				$b = (count($state_arr) ? in_array($state_alias[$s],$state_arr) : TRUE);
				$c = (count($product_arr) ? in_array($product_alias[$s],$product_arr) : TRUE);
				if($a || $b || $c){ $coo++;
					$d = ($zone_alias[$s]!='' ?  alias($zone_alias[$s],'ec_zone','zone_alias','zone_name'):"-");
					$e = ($state_alias[$s]!='' ?  alias($state_alias[$s],'ec_state','state_alias','state_name'):"-");
					$f = ($product_alias[$s]!='' ?  alias($product_alias[$s],'ec_product','product_alias','product_description'):"-");
				}
			for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
				$value = $row[$colArr2[$af]];
				if($chr=='A' || $chr=='B')$objPHPExcel->getActiveSheet()->setCellValueExplicit($chr.$coo, $value,PHPExcel_Cell_DataType::TYPE_STRING);
				else $objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, ($chr=='C' || $chr=='D' || $chr=='E' ?  php_excel_date($value) : $value));
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$coo, $d);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$coo, $e);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$coo, alias($row['district_alias'],'ec_district','district_alias','district_name'));
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$coo, alias($row['segment_alias'],'ec_segment','segment_alias','segment_name'));
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$coo, alias($row['customer_alias'],'ec_customer','customer_alias','customer_name'));
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$coo,$f);
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$coo, alias($row['site_type_alias'],'ec_site_type','site_type_alias','site_type'));
			$site = sitestatus($row['customer_alias'],($row['sale_invoice_date']=='0000-00-00' ? $row['mfd_date'] : $row['sale_invoice_date']),$row['install_date']); $site['warrantystatus'];
			$objPHPExcel->getActiveSheet()->SetCellValue('W'.$coo, $site['warrantystatus']);
		}
	}
	$objPHPExcel->getActiveSheet()->setTitle('Sitemaster');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("../../exports/$filename.xlsx");
	$result['file_name']=$filename;
	$resCode='0'; $resMsg='export';
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function sitemaster_import(){  
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$rex=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($rex==0){
		if(isset($_FILES["file"])){ //if there was an error uploading the file
		if($_FILES["file"]["error"]>0){$res = "No file selected";}
			else{ $extn = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
				if($extn=='xlsx' || $extn=='xls' ){
					set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
					// This is the file path to be uploaded.
					$inputFileName = $_FILES["file"]["tmp_name"];
					try { $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);}
					catch(Exception $e){die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage()); }
					$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
					$highestColumm=$objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
					$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumm);
					if($highestColumnIndex!='19'){
						$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
						$already = array(); $wrongData = array(); $NOS = array('1','2','3','4','5');
						for($i=2;$i<=$arrayCount;$i++){
							$site_alias = aliasCheck(generateRandomString(),'ec_sitemaster','site_alias');
							$site_id = strtoupper(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["A"])));
							$site_name = strtoupper(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["B"])));
							$zone_alias = strtoupper(mysqli_real_escape_string($mr_con,alias(trim($allDataInSheet[$i]["C"]),'ec_zone','zone_name','zone_alias')));
							$state_alias = strtoupper(mysqli_real_escape_string($mr_con,alias(trim($allDataInSheet[$i]["D"]),'ec_state','state_name','state_alias')));
							$district_alias = strtoupper(mysqli_real_escape_string($mr_con,alias(trim($allDataInSheet[$i]["E"]),'ec_district','district_name','district_alias')));
							$segment_alias = strtoupper(mysqli_real_escape_string($mr_con,alias(trim($allDataInSheet[$i]["F"]),'ec_segment','segment_name','segment_alias')));
							$customer_alias = strtoupper(mysqli_real_escape_string($mr_con,alias(trim($allDataInSheet[$i]["G"]),'ec_customer','customer_code','customer_alias')));
							$product_alias = strtoupper(mysqli_real_escape_string($mr_con,alias(trim($allDataInSheet[$i]["H"]),'ec_product','product_description','product_alias')));
							
							$mfd_date = mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["I"]));
							$install_date = mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["J"]));
		
							$po_num = mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["K"]));
							$sale_invoice_num = mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["L"]));
							$sale_invoice_date = mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["M"]));
							
							$technician_name = strtoupper(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["N"])));
							$technician_number = mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["O"]));
							$manager_name = strtoupper(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["P"])));
							$manager_number = mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["Q"]));
							$manager_mail = strtolower(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["R"])));
							$no_of_string = (in_array(trim($allDataInSheet[$i]["S"]),$NOS) ? trim($allDataInSheet[$i]["S"]) : ''); // name for($ns=1;$ns<=5;$ns++){echo "<option value='$ns'>$ns</option>";}
							$site_type_alias = strtoupper(mysqli_real_escape_string($mr_con,alias(trim($allDataInSheet[$i]["T"]),'ec_site_type','site_type','site_type_alias')));
							$bb_rating = strtoupper(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["U"])));
							$site_address = strtoupper(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["V"])));
							$query=mysqli_query($mr_con,"SELECT id FROM ec_sitemaster WHERE site_id ='$site_id' AND product_alias LIKE '%$product_alias%' AND customer_alias='$customer_alias' AND state_alias='$state_alias' AND flag=0");
							if(mysqli_num_rows($query)==0){
								if(!empty($zone_alias) && !empty($state_alias) && !empty($district_alias) && !empty($segment_alias) && !empty($customer_alias) && !empty($site_type_alias) && !empty($product_alias)){
									$sql = mysqli_query($mr_con,"INSERT INTO ec_sitemaster(zone_alias,state_alias,district_alias,segment_alias,customer_alias,site_type_alias,site_id,site_name,site_alias,product_alias,mfd_date,install_date,sale_invoice_date,sale_invoice_num,po_num,no_of_string,technician_name,technician_number,manager_name,manager_number,manager_mail,battery_bank_rating,site_address,created_date)VALUES('$zone_alias','$state_alias','$district_alias','$segment_alias','$customer_alias','$site_type_alias','$site_id','$site_name','$site_alias','$product_alias','$mfd_date','$install_date','$sale_invoice_date','$sale_invoice_num','$po_num','$no_of_string','$technician_name','$technician_number','$manager_name','$manager_number','$manager_mail','$bb_rating','$site_address','".date('Y-m-d')."')");
									if($sql){$resCode='0';$resMsg='Successful!';}
								}else{ $result['wrongData'][] = $site_id; }
							}else{ $result['already'][] = $site_id; }
						}
						if(count($result['already'])!=0){ $res = 'Some siteIDs already exists...';}
						else{
							if(count($result['wrongData'])!=0){ $res = 'Some siteIDs has Wrong Data...';}
							else{ if($sql){$resCode='0';$resMsg="All SiteIDs are successfully Inserted...";}else $res='Not Inserted';}
						}
					}else{$res = 'Selected excel file has wrong format.'; }
				}else{ $res = 'Invalid file...'; }
			}
		}else{ $res = "No file selected"; 
	}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function sitemanfdate(){ global $mr_con;
	$cust=mysqli_real_escape_string($mr_con,$_REQUEST['customer']);
	$svdate=mysqli_real_escape_string($mr_con,dateFormat(str_replace(",","-",$_REQUEST['svdate']),'y'));
	$idate=mysqli_real_escape_string($mr_con,dateFormat(str_replace(",","-",$_REQUEST['idate']),'y'));
	echo json_encode(sitestatus($cust,$svdate,$idate));
}
function site_status($status){ global $mr_con;
	$rec=mysqli_query($mr_con,"SELECT site_alias,customer_alias,mfd_date,install_date,sale_invoice_date FROM ec_sitemaster WHERE flag='0'");
	if(mysqli_num_rows($rec)){
		while($row=mysqli_fetch_array($rec)){
			$customer_alias=$row['customer_alias'];
			$mfd_date=dateFormat(($row['sale_invoice_date']=='0000-00-00' ? $row['mfd_date'] : $row['sale_invoice_date']),'y');
			//$mfd_date=dateFormat($row['mfd_date'],'y');
			$install_date=dateFormat($row['install_date'],'y');
			$zz=sub_site_status($customer_alias,$mfd_date,$install_date);
			if($zz==$status){$cc[]=$row['site_alias'];}
		}
		return implode("','",$cc);
	}
}
function sub_site_status($cust,$mdate,$idate){ global $mr_con;
	if($cust==""){$status=0;}
	elseif($mdate=="NA" && $idate=="NA"){$status=0;}
	else{
		if($mdate!="NA"){
			$date1 = new DateTime($mdate);
			$date2 = new DateTime(date("Y-m-d"));
			$warrantyd1 = $date2->diff($date1)->format("%a");
		}else{$warrantyd1 = "NA";}
		if($idate!="NA"){
			$date1 = new DateTime($idate);
			$date2 = new DateTime(date("Y-m-d"));
			$warrantyd2 = $date2->diff($date1)->format("%a");
		}else{$warrantyd2 = "NA";}
		$sql=mysqli_query($mr_con,"SELECT dispatch,installation,schedule FROM ec_customer WHERE customer_alias='$cust' AND flag=0");
		if(mysqli_num_rows($sql)){
			$row=mysqli_fetch_array($sql);
			$dispatch=$row["dispatch"]*30;
			$installation=$row["installation"]*30;
			if($row["dispatch"]==0){$warrantyd1 = "NA";}
			if($row["installation"]==0){$warrantyd2 = "NA";}
			if($warrantyd1 != "NA"){$tempw1=$dispatch-$warrantyd1;$na1="";}else{$tempw1=0;$na1="NA";}
			if($warrantyd2 != "NA"){$tempw2=$installation-$warrantyd2;$na2="";}else{$tempw2=0;$na2="NA";}
			if($na1=="NA"){ $status = ($tempw2<=0 ? 0 : 1); }
			elseif($na2=="NA"){ $status = ($tempw1<=0 ? 0 : 1);}
			else{ $status = ($tempw1<=0 || $tempw2<=0 ? 0 : 1); }
		}else{$status=0;}
	}
	return $status;
}

function sitemaster_can_be_deleted() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	$grantable = grantable('DELETE','SITEMASTER',$emp_alias);
	if(!$grantable){
		$resCode = 1;
		$resMsg='Authentication Failed!';
	}
	if($grantable && $rex==0) {
		$site_id = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['site_id'])));
		$site_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['site_alias'])));
		$remarks = mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks']));
		if(empty($site_id) || empty($site_alias)) {
			$res="Invalid Request";
		} else {
			$query = "SELECT id FROM ec_sitemaster WHERE site_id ='$site_id' AND site_alias='$site_alias' AND flag=0";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$query = "SELECT `status` from ec_tickets WHERE site_alias = '{$site_alias}' and flag = '0'";
				$sql = mysqli_query($mr_con, $query);
				if(mysqli_num_rows($sql) == 0) {
					$resCode = 0;
					$resMsg = "Sitemaster can be deleted";
				} else {
					$res = 'Site master cannot be deleted. Few tickets are still open.';	
				}
			} else {
				$res = "Site master doesn't exists"; 
			}
		}
		if(isset($res)) {
			$resCode='4';
			$resMsg=$res;
		}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode; 
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);

}

function sitemaster_delete() {
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	$grantable = grantable('DELETE','SITEMASTER',$emp_alias);
	if(!$grantable){
		$resCode = 1;
		$resMsg='Authentication Failed!';
	}
	if($grantable && $rex==0) {
		
		$site_id = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['site_id'])));
		$site_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['site_alias'])));
		$remarks = mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks']));
		if(empty($remarks)){$res="Provide remarks";}
		else if(empty($site_id) || empty($site_alias)){$res="Invalid Request";}
		else {
			$query = "SELECT id FROM ec_sitemaster WHERE site_id ='$site_id' AND site_alias='$site_alias' AND flag=0";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql)>0) {
				$query = "SELECT `status` from ec_tickets WHERE site_alias = '{$site_alias}' and flag = '0'";
				$sql = mysqli_query($mr_con, $query);
				if(mysqli_num_rows($sql) == 0) {
					$query = "UPDATE ec_sitemaster set flag = '9' where site_alias='$site_alias'";
					$sql = mysqli_query($mr_con, $query);
					if($sql){
						$action = "SiteID $site_id Deleted";
						user_history($emp_alias,$action,$_REQUEST['ip_addr'], $remarks);
						$resCode='0';$resMsg='Successful!';
					}
				} else {
					$res = 'Failed to delete site master. Few tickets are still open.';	
				}
			}else{$res = 'Failed to delete site master'; }
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

function sitemaster_restore() {
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	$grantable = grantable('RESTORE','SITEMASTER',$emp_alias);
	if(!$grantable){
		$resCode = 1;
		$resMsg='Authentication Failed!';
	}
	if($grantable && $rex==0) {
		
		$site_id = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['site_id'])));
		$site_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['site_alias'])));
		$remarks = mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks']));
		if(empty($remarks)){$res="Provide remarks";}
		else if(empty($site_id) || empty($site_alias)){$res="Invalid Request";}
		else {
			$query = "SELECT id FROM ec_sitemaster WHERE site_id ='$site_id' AND site_alias='$site_alias'";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				$query = "UPDATE ec_sitemaster set flag = '0' where site_alias='$site_alias'";
				$sql = mysqli_query($mr_con, $query);
				if($sql) {
					$action = "SiteID $site_id Restored";
					user_history($emp_alias,$action,$_REQUEST['ip_addr'], $remarks);
					$resCode='0';
					$resMsg='Successful!';
				}
			}else{$res = 'Failed to restore site master'; }
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
?>