<?php
date_default_timezone_set("Asia/Kolkata");
require('../Slim/Slim.php');
include('../mysql.php');
include('../functions.php');
require('../Classes/PHPExcel.php');
require('../Classes/PHPExcel/IOFactory.php');
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->post('/inventorylevels','inventorylevels');
$app->post('/loginhwtype','loginhwtype');
$app->post('/sitelistemp','sitelistemp');
$app->post('/selfWarehouse','selfWarehouse');
$app->post('/emprolenamelist','emprolenamelist');
$app->post('/emprolenamelist_planner','emprolenamelist_planner');
$app->post('/zoneslistsCntrl','zoneslistsCntrl');
$app->post('/nhsApprovedTickets','nhsApprovedTickets');
$app->post('/cellhistoryDetails','cellhistoryDetails');
$app->post('/getitemslistfromsjo','getitemslistfromsjo');
$app->post('/getitemslistfromsjo_ic','getitemslistfromsjo_ic');
$app->post('/faultycellsDetails','faultycellsDetails');
$app->post('/getitemslistfromticket','getitemslistfromticket');
$app->post('/materialRequestTo','materialRequestTo');
$app->post('/getrequiredCellsTickets','getrequiredCellsTickets');
$app->post('/ware_bal_count','ware_bal_count');
$app->post('/mrf_nhsapproved','mrf_nhsapproved');
$app->post('/ticketsList_mi','ticketsList_mi');
$app->post('/siteList_mi','siteList_mi');
$app->post('/mrfList_mi','mrfList_mi');
$app->post('/ticketsList_mo','ticketsList_mo');
$app->post('/sjoFullListforScrap','sjoFullListforScrap');
$app->post('/scrapcellsget','scrapcellsget');
$app->post('/whfList_mi','whfList_mi');
$app->post('/getscrapitemsfrmwh','getscrapitemsfrmwh');
$app->post('/empfaccheck','empfaccheck');
$app->post('/buffersjolist','buffersjolist_mo');
$app->post('/buffersjolist_scrp','buffersjolist_scrp_mo');
$app->post('/buffersjolist_scrp_full','buffersjolist_scrp_mo_full');
$app->post('/getbufferstocksforow','getbufferstocksforow_mo');

$app->post('/sjolist','sjolist');
$app->post('/sjodetails','sjodetails');
$app->post('/sjo_search','sjo_search');
$app->post('/getselectedsjo','getselectedsjo');
$app->post('/sjo_search_export','sjo_search_export');
$app->post('/sjo_bal_export','sjo_bal_export');
$app->post('/scrap_inward_by_fact_export','scrap_inward_by_fact_export');
$app->post('/stocks_export','stocks_export');
$app->post('/stocks_import','stocks_import');

$app->post('/item_code_add','item_code_add');
$app->post('/item_code_update','item_code_update');
$app->post('/item_code_view','item_code_view');
$app->post('/item_code_mul_view','item_code_mul_view');
$app->post('/item_code_export','item_code_export');
$app->post('/item_code_delete_check','item_code_delete_check');
$app->post('/item_code_delete','item_code_delete');

$app->post('/material_request_rand','material_request_rand');
$app->post('/material_request_add','material_request_add');
$app->post('/material_request_edit','material_request_edit');
$app->post('/material_request_adv_edit','material_request_adv_edit');
$app->post('/material_request_multi','material_request_multi');
$app->post('/material_request_single_view','material_request_single_view');
$app->post('/material_request_export','material_request_export');
$app->post('/material_request_check_delete_status','material_request_check_delete_status');
$app->post('/material_request_delete','material_request_delete');

$app->post('/matrialinwardwatdAdd','material_inward_add');
$app->post('/material_inward_multi','material_inward_multi');
$app->post('/material_inward_edit','material_inward_edit');
$app->post('/material_inward_single_view','material_inward_single_view');
$app->post('/material_inward_export','material_inward_export');
$app->post('/material_inward_import','material_inward_import');
$app->post('/material_inward_check_delete_status','material_inward_check_delete_status');
$app->post('/material_inward_delete','material_inward_delete');

$app->post('/matrialoutwardwatdAdd','material_outward_add');
$app->post('/material_outward_multi','material_outward_multi');
$app->post('/material_outward_edit','material_outward_edit');
$app->post('/material_outward_single_view','material_outward_single_view');
$app->post('/material_outward_export','material_outward_export');
$app->post('/material_outward_check_delete_status','material_outward_check_delete_status');
$app->post('/material_outward_delete','material_outward_delete');
$app->post('/material_outward_item_delete','material_outward_item_delete');

$app->post('/finance_archive','finance_archive');
$app->post('/material_balance_multi','material_balance_multi');
$app->post('/inward_balance_multi','inward_balance_multi');
$app->post('/outward_balance_multi','outward_balance_multi');

$app->post('/outwarditemlist','outwarditemlist');
$app->post('/material_balance_export','material_balance_export');
$app->post('/material_inward_balance_export','material_inward_balance_export');
$app->post('/material_outward_balance_export','material_outward_balance_export');

$app->post('/material_revival_add','material_revival_add');
$app->post('/material_revival_update','material_revival_update');
$app->post('/material_revival_adv_edit','material_revival_adv_edit');
$app->post('/material_revival_view','material_revival_view');
$app->post('/material_revival_mul_view','material_revival_mul_view');
$app->post('/material_revival_export','material_revival_export');
$app->post('/material_revival_delete','material_revival_delete');

$app->post('/material_refreshing_add','material_refreshing_add');
$app->post('/material_refreshing_update','material_refreshing_update');
$app->post('/material_refreshing_adv_edit','material_refreshing_adv_edit');
$app->post('/material_refreshing_view','material_refreshing_view');
$app->post('/material_refreshing_mul_view','material_refreshing_mul_view');
$app->post('/material_refreshing_export','material_refreshing_export');
$app->post('/material_refreshing_delete','material_refreshing_delete');

$app->post('/total_cell_revival','total_cell_revival');
$app->post('/total_cell_refreshing','total_cell_refreshing');
$app->post('/state_whcode_drop','state_whcode_drop');
$app->run();
function inventorylevels(){	global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT level_alias,level_name FROM ec_inventory_levels WHERE flag=0 ORDER BY level_alias");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['level_alias'];$result[$i]['name']=$row['level_name']; $i++;}
	}else{$result[0]['alias']='4';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function empfaccheck(){
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['x']);
	if($emp_alias!=""){
		$wh_temp=alias($emp_alias,'ec_employee_master','employee_alias','wh_alias');
		if($wh_temp!=""){
			if(preg_match('/,/',$wh_temp))$result['faccheka']='0';
			else{
				$wh_temp=alias($wh_temp,'ec_warehouse','wh_alias','wh_type');
				if($wh_temp=='1')$result['faccheka']='1';
				else $result['faccheka']='0';
			}
		}else{$result['faccheka']='0';}
	}else{$result['faccheka']='0';}
	echo json_encode($result);
}
function loginhwtype(){ global $mr_con;
	$emp_alias=mysqli_real_escape_string($mr_con,$_REQUEST['x']);
	if($emp_alias!=""){
		$wh_temp="'".str_replace(", ","','",alias($emp_alias,'ec_employee_master','employee_alias','wh_alias'))."'";
		$sql=mysqli_query($mr_con,"SELECT id FROM ec_warehouse WHERE wh_alias IN ($wh_temp) AND wh_type='1' AND flag=0");
		if(mysqli_num_rows($sql)>0){
			$result['facchek']='1';
		}else{$result['facchek']='0';}
	}else{$result['facchek']='0';}
	echo json_encode($result);
}
function ware_bal_count(){ global $mr_con;
	$wh_alias=mysqli_real_escape_string($mr_con,$_REQUEST['wh_alias']);
	if(!empty($wh_alias)){
		$sql=mysqli_query($mr_con,"SELECT COUNT(id) AS count,item_code,condition_id FROM ec_total_cell WHERE location ='$wh_alias' AND stage='0' AND location_type='1' AND flag=0 GROUP BY item_code,condition_id");
		if(mysqli_num_rows($sql)){ $result['records']=mysqli_num_rows($sql);
			$i=0;while($row=mysqli_fetch_array($sql)){
				$result['ware_bal'][$i]['count']=$row['count'];
				$result['ware_bal'][$i]['item_code']=alias($row['item_code'],'ec_product','product_alias','product_description');
				$result['ware_bal'][$i]['condition_id']=alias($row['condition_id'],'ec_stock','stock_alias','description');
				$i++;
			}
		}else $result['records']=($wh_alias==alias('1','ec_warehouse','wh_type','wh_alias') ? '-1':'0');
	}else $result['records']='0';
	echo json_encode($result);
}
function mrf_nhsapproved(){ global $mr_con;
	$emp_alias=mysqli_real_escape_string($mr_con,$_REQUEST['x']);
	$from_wh=mysqli_real_escape_string($mr_con,$_REQUEST['from_wh']);
	if($emp_alias!="" && $from_wh!=""){
		$reqh=alias($from_wh,'ec_warehouse','wh_alias','wh_type');
		if($reqh=='1'){
			$sql=mysqli_query($mr_con,"SELECT mrf_number,mrf_alias,sjo_number FROM ec_material_request WHERE to_wh ='$from_wh' AND status IN ('3') AND flag=0");
		}else{
			$sql=mysqli_query($mr_con,"SELECT mrf_number,mrf_alias,sjo_number FROM ec_material_request WHERE to_wh ='$from_wh' AND status IN ('0','9','3') AND flag=0");
		}
		if(mysqli_num_rows($sql)){
			$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['mrf_alias'];$result[$i]['name']=$row['mrf_number'];$result[$i]['sjo']=$row['sjo_number']; $i++;}
		}else{$result[0]['alias']='4';$result[0]['name']='No Records Found';$result[0]['sjo']='No Records Found';}
	}else{$result[0]['alias']='4';$result[0]['name']='No Records Found';$result[0]['sjo']='No Records Found';}
	echo json_encode($result);
}
function ticketsList_mi(){ global $mr_con; $result=array();
	$emp_alias=mysqli_real_escape_string($mr_con,$_REQUEST['x']);
	$to_wh=mysqli_real_escape_string($mr_con,$_REQUEST['to_wh']);
	if($emp_alias!="" && $to_wh!=""){
		$state_alias=alias($to_wh,'ec_warehouse','wh_alias','state_alias');
		$sql=mysqli_query($mr_con,"SELECT COUNT(ec_1.id) AS cnt,GROUP_CONCAT(ec_1.ticket_alias) AS ticket_alias,GROUP_CONCAT(ec_1.ticket_id) AS ticket_id FROM ec_tickets ec_1
			INNER JOIN ec_sitemaster ec_2 ON ec_1.site_alias=ec_2.site_alias
			INNER JOIN ec_tickets_inventory ec_3 ON ec_1.ticket_alias=ec_3.ticket_alias
			WHERE ec_2.state_alias='$state_alias' AND ec_1.level>='3' AND ec_3.material_inward='1' AND ec_1.flag='0' ORDER BY ec_1.id");
		$row=mysqli_fetch_array($sql);
		if($row['cnt']){
			$sql1=mysqli_query($mr_con,"SELECT COUNT(t1.id) AS fcnt,GROUP_CONCAT(DISTINCT t1.ticket_alias) AS ticket_alias FROM ec_fsr_faulty_cells t1
				INNER JOIN ec_item_code t2 ON t1.cell_sl_no=t2.item_description
				INNER JOIN ec_total_cell t3 ON t2.item_code_alias=t3.cell_alias
				WHERE t1.ticket_alias IN('".str_replace(",","','",$row['ticket_alias'])."') AND t3.condition_id NOT IN('3','4') AND t1.flag='0' ORDER BY t1.id");
			$row1=mysqli_fetch_array($sql1);
			if($row1['fcnt']){
				$mix_arr = array_combine(explode(",",$row['ticket_alias']),explode(",",$row['ticket_id']));
				$i=0;foreach(explode(",",$row1['ticket_alias']) as $ticket_alias){
					if (array_key_exists($ticket_alias,$mix_arr)){
						$result[$i]['alias']=$ticket_alias;
						$result[$i]['name']=$mix_arr[$ticket_alias];
						$i++;
					}
				}
			}
			//$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['ticket_alias'];$result[$i]['name']=$row['ticket_id']; $i++;}
			
		}//else{$result[0]['alias']='4';$result[0]['name']='No Records Found';}
		/*$sql=mysqli_query($mr_con,"SELECT ec_1.ticket_id,ec_1.ticket_alias FROM ec_tickets ec_1 INNER JOIN ec_engineer_observation ec_2 on ec_1.ticket_alias=ec_2.ticket_alias WHERE ec_1.site_alias IN (SELECT site_alias FROM ec_sitemaster WHERE state_alias='$state_alias' AND flag=0) AND ec_1.level>='3' AND ec_2.in_level='0'");
		if(mysqli_num_rows($sql)){
			$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['ticket_alias'];$result[$i]['name']=strtok($row['ticket_id'],"|"); $i++;}
		}else{$result[0]['alias']='4';$result[0]['name']='No Records Found';}*/
	}//else{$result[0]['alias']='4';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function ticketsList_mo(){ 
	global $mr_con; 
	$result=array();
	$emp_alias=mysqli_real_escape_string($mr_con,$_REQUEST['x']);
	$from_wh=mysqli_real_escape_string($mr_con,$_REQUEST['from_wh']);
	if($emp_alias!="" && $from_wh!=""){
		$state_alias=alias($from_wh,'ec_warehouse','wh_alias','state_alias');
		$sql=mysqli_query($mr_con,"SELECT ec_1.ticket_alias,SUBSTRING_INDEX(ec_1.ticket_id,'|',1) AS ticket_idx FROM ec_tickets ec_1
			INNER JOIN (SELECT MAX(ID) AS ID FROM ec_tickets WHERE flag='0' GROUP BY SUBSTRING_INDEX(ticket_id,'|',1)) AS P ON (ec_1.ID=P.ID)
			INNER JOIN ec_sitemaster ec_2 ON ec_1.site_alias=ec_2.site_alias
			INNER JOIN ec_tickets_inventory ec_3 ON ec_1.ticket_alias=ec_3.ticket_alias
			WHERE ec_2.state_alias='$state_alias' AND ec_3.material_outward='1' AND ec_1.level<>'5' AND ec_1.purpose='1' AND ec_1.flag='0' ORDER BY ec_1.id");
		if(mysqli_num_rows($sql)) {
			$i=0;
			while($row=mysqli_fetch_array($sql)) {
				$result[$i]['alias']=$row['ticket_alias'];
				$result[$i]['name']=$row['ticket_idx']; 
				$i++;
			}
		}
	}
	echo json_encode($result);
}
function buffersjolist_mo(){ global $mr_con;
	$emp_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['x']));
	$to_wh=mysqli_real_escape_string($mr_con,trim($_REQUEST['from_wh']));
	if($emp_alias!="" && $to_wh!=""){
		$sql=mysqli_query($mr_con,"SELECT mrf_alias,sjo_number,status FROM ec_material_request WHERE from_wh='$to_wh' AND ticket_alias='2609' AND status IN ('0','6') AND flag=0");
		if(mysqli_num_rows($sql)){$i=0;
			while($row=mysqli_fetch_array($sql)){
				$sql2=mysqli_query($mr_con,"SELECT id FROM `ec_material_outward` WHERE `to_wh` LIKE '2609' AND from_wh='$to_wh' AND from_type='1' AND sjo_number='".$row['mrf_alias']."'");
				if(mysqli_num_rows($sql2)=='0' || $row['status']=='0' || $row['status']=='6'){
					$result[$i]['alias']=$row['mrf_alias'];$result[$i]['name']=$row['sjo_number']; 
					$i++;
				}
			}
		}else{$result[0]['alias']='4';$result[0]['name']='No Records Found';}
	}else{$result[0]['alias']='4';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function buffersjolist_scrp_mo(){ global $mr_con;
	$emp_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['x']));
	$from_wh=mysqli_real_escape_string($mr_con,trim($_REQUEST['from_wh']));
	if($emp_alias!="" && $from_wh!=""){
		$sql=mysqli_query($mr_con,"SELECT mrf_alias,sjo_number FROM ec_material_request WHERE from_wh='$from_wh' AND ticket_alias='2609' AND status IN('0','6') AND flag=0");
		if(mysqli_num_rows($sql)){ $i=0;
			while($row=mysqli_fetch_array($sql)){
				$sql_a=mysqli_query($mr_con,"SELECT t1.id FROM ec_material_sent_details t1 INNER JOIN ec_material_outward t2 ON t1.reference=t2.alias WHERE t2.sjo_number='".$row['mrf_alias']."' AND t2.from_type='1' AND t1.item_condition IN ('1','2')");
				$sql_b=mysqli_query($mr_con,"SELECT t1.id FROM ec_material_received_details t1 INNER JOIN ec_material_inward t2 ON t1.reference=t2.alias WHERE t2.sjo_number='".$row['mrf_alias']."' AND t2.from_type='2'");
				$cnt_a = mysqli_num_rows($sql_a);
				$cnt_b = mysqli_num_rows($sql_b);
				if($cnt_a>'0' && $cnt_a>$cnt_b){
					$result[$i]['alias_a']=$row['mrf_alias'];
					$result[$i]['name_a']=$row['sjo_number'];
					$result[$i]['count_a']=$cnt_a-$cnt_b;
				}$i++;
			}
		}else{$result[0]['alias_a']='4';$result[0]['name_a']='No Records Found';}
	}else{$result[0]['alias_a']='4';$result[0]['name_a']='No Records Found';}
	echo json_encode($result);
}

// This is for inward as well as outward
function buffersjolist_scrp_mo_full(){ 
	global $mr_con;
	$emp_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['x']));
	$to_wh=mysqli_real_escape_string($mr_con,trim($_REQUEST['from_wh']));
	if($emp_alias!="" && $to_wh!=""){ $check=TRUE;
		$in_out=mysqli_real_escape_string($mr_con,trim($_REQUEST['in_out']));
		if($in_out=='in'){
			if(isset($_REQUEST['from_type']) && !empty($_REQUEST['from_type']))$from_type=mysqli_real_escape_string($mr_con,trim($_REQUEST['from_type']));else $from_type='';
			if(isset($_REQUEST['ticket_site_alias']) && !empty($_REQUEST['ticket_site_alias']))$ticket_site_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['ticket_site_alias']));else $ticket_site_alias='';
			if($from_type=='1')$item_code = alias(alias($ticket_site_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','product_alias'); //Tickets
			else $item_code = alias($ticket_site_alias,'ec_sitemaster','site_alias','product_alias'); //$from_type=='2' Site
			$abc=$xyz=$sjo=array();
			foreach(array("from_wh"=>"to_wh","to_wh"=>"from_wh") as $from=>$to){
				$b3=mysqli_query($mr_con,"SELECT COUNT(t1.id) AS from_to,t1.sjo_number AS sjo_num FROM ec_material_outward t1 INNER JOIN ec_material_sent_details t2 ON t1.alias=t2.reference WHERE t1.$from='XVX6AZ4VHT' AND t1.$to='$to_wh' AND t2.item_code='$item_code' AND t2.item_type='1' AND t1.flag='0' GROUP BY t1.sjo_number");
				if(mysqli_num_rows($b3)){
					while($bb3=mysqli_fetch_array($b3)){
						if($from=="from_wh") $abc[$bb3['sjo_num']]=$bb3['from_to'];
						else $xyz[$bb3['sjo_num']]=$bb3['from_to'];
					}
				}
			}
			$intersect=array_intersect_assoc($abc,$xyz);
			$first=array_diff_assoc($abc,$intersect);
			$last=array_diff_assoc($xyz,$intersect);
			foreach($first as $key=>$elem)if($elem != $last[$key])$sjo[]=$key;
			if(count($sjo)>'0'){
				$q = "SELECT COUNT(t1.id) AS from_to,t1.sjo_number AS sjo_num FROM ec_material_inward t1 INNER JOIN ec_material_received_details t2 ON t1.alias=t2.reference WHERE t1.from_type IN('1','2') AND t2.item_condition in ('3', '7') AND t1.to_wh='$to_wh' AND t2.item_code='$item_code' AND t1.sjo_number IN('".implode("','",$sjo)."') AND t2.item_type='1' AND t1.flag='0' GROUP BY t1.sjo_number";
				$b4=mysqli_query($mr_con, $q);
				if(mysqli_num_rows($b4)){
					while($bb4=mysqli_fetch_array($b4))$last[$bb4['sjo_num']]=$bb4['from_to'];
					foreach($first as $key=>$elem)if($elem == $last[$key])$sjo=array_filter($sjo, function($v){ return $v != $key; });
				}else $spec="mrf_alias IN('".implode("','",$sjo)."') AND ";
				//foreach (array_merge_recursive ($abc, $xyz) as $key => $value)$sums[$key] = (is_array($value) ? array_sum($value) : $value);
				$spec="mrf_alias IN('".implode("','",$sjo)."') AND ";
			}else $check=FALSE;
		}else $spec="";
		if($check){
			$sql=mysqli_query($mr_con,"SELECT mrf_alias,sjo_number FROM ec_material_request WHERE from_wh='$to_wh' AND sjo_number NOT IN ('0','') AND $spec status IN ('0','6') AND flag=0");
			if(mysqli_num_rows($sql)){$i=0;
				if(isset($first) && count($first)>'0')$first1=$first;else $first1=array();
				while($row=mysqli_fetch_array($sql)){
					$cnt = $first1[$row['mrf_alias']]-$last[$row['mrf_alias']];
					if($cnt > 0) {
						$result[$i]['count_a']=$cnt;
						$result[$i]['alias_a']=$row['mrf_alias'];
						$result[$i]['name_a']=$row['sjo_number'];
						$i++;
					}
				}if(empty($result)){$result[0]['alias_a']='4';$result[0]['name_a']='No Records Found';$result[0]['count_a']='0';}
			}else{$result[0]['alias_a']='4';$result[0]['name_a']='No Records Found';$result[0]['count_a']='0';}
		}else{$result[0]['alias_a']='4';$result[0]['name_a']='No Records Found';$result[0]['count_a']='0';}
	}else{$result[0]['alias_a']='4';$result[0]['name_a']='No Records Found';$result[0]['count_a']='0';}
	echo json_encode($result);
}
function sjoFullListforScrap(){ global $mr_con;
	$emp_alias=mysqli_real_escape_string($mr_con,$_REQUEST['x']);
	$from_wh=mysqli_real_escape_string($mr_con,$_REQUEST['from_wh']);
	if($emp_alias!="" && $from_wh!=""){
		$lost=$pend=$abc=$xyz=$sjo=array();
		$pend_sjo=mysqli_query($mr_con,"SELECT COUNT(t1.id) AS cnt,t1.sjo_number AS sjo_num FROM ec_material_inward t1 INNER JOIN ec_material_received_details t2 ON t1.alias=t2.reference WHERE t1.to_wh='$from_wh' AND t1.from_type IN('1','2') AND t2.item_condition IN ('3','4') AND t2.item_type='1' AND t1.flag='0' AND t1.sjo_number!='' AND t1.sjo_number NOT IN(SELECT t1.sjo_number FROM ec_material_outward t1 INNER JOIN ec_material_sent_details t2 ON t1.alias=t2.reference WHERE t1.to_wh='XVX6AZ4VHT' AND t1.from_wh='$from_wh' AND t1.from_type='2' AND t2.item_condition IN('3','4') AND t2.item_type='1' AND t1.flag='0') GROUP BY t1.sjo_number");
		if(mysqli_num_rows($pend_sjo))while($pend_row=mysqli_fetch_array($pend_sjo))$pend[$pend_row['sjo_num']]=$pend_row['cnt'];
		if(count($pend)){
			foreach(array_keys($pend) as $i=>$mrf_ali){
				$result[$i]['count_a']=$pend[$mrf_ali];
				$result[$i]['alias_a']=$mrf_ali;
				$result[$i]['name_a']=alias($mrf_ali,'ec_material_request','mrf_alias','sjo_number');
			}
		}else $i=0;
		$lost_sjo=mysqli_query($mr_con,"SELECT COUNT(t1.id) AS cnt,t1.sjo_number AS sjo_num FROM ec_material_inward t1 INNER JOIN ec_material_received_details t2 ON t1.alias=t2.reference WHERE t1.to_wh='$from_wh' AND t1.from_type IN('1','2','3') AND t2.item_condition='7' AND t2.item_type='1' AND t1.flag='0' AND t1.sjo_number!='' GROUP BY t1.sjo_number");
		if(mysqli_num_rows($lost_sjo))while($lost_row=mysqli_fetch_array($lost_sjo))$lost[$lost_row['sjo_num']]=$lost_row['cnt'];
		foreach(array("from_wh"=>"to_wh","to_wh"=>"from_wh") as $from=>$to){
			$b3=mysqli_query($mr_con,"SELECT COUNT(t1.id) AS from_to,t1.sjo_number AS sjo_num FROM ec_material_outward t1 INNER JOIN ec_material_sent_details t2 ON t1.alias=t2.reference WHERE t1.$from='XVX6AZ4VHT' AND t1.$to='$from_wh' AND t2.item_type='1' AND t1.flag='0' GROUP BY t1.sjo_number");
			if(mysqli_num_rows($b3)){
				while($bb3=mysqli_fetch_array($b3)){
					if($from=="from_wh")$abc[$bb3['sjo_num']]=$bb3['from_to'];else $xyz[$bb3['sjo_num']]=$bb3['from_to'];
				}
			}
		}
		$intersect=array_intersect_assoc($abc,$xyz);
		$first=array_diff_assoc($abc,$intersect);
		$last=array_diff_assoc($xyz,$intersect);
		foreach($first as $key=>$elem)if($elem != $last[$key])$sjo[]=$key;
		if(count($sjo)>'0'){
			$b4=mysqli_query($mr_con,"SELECT COUNT(t1.id) AS from_to,t1.sjo_number AS sjo_num FROM ec_material_outward t1 INNER JOIN ec_material_sent_details t2 ON t1.alias=t2.reference WHERE t1.from_type='2' AND t2.item_condition='3' AND t1.from_wh='$from_wh' AND t1.to_wh='XVX6AZ4VHT' AND t1.sjo_number IN('".implode("','",$sjo)."') AND t2.item_type='1' AND t1.flag='0' GROUP BY t1.sjo_number");
			if(mysqli_num_rows($b4)){
				while($bb4=mysqli_fetch_array($b4))$last[$bb4['sjo_num']]=$bb4['from_to'];
				foreach($first as $key=>$elem)if($elem == $last[$key])$sjo=array_filter($sjo, function($v){ return $v != $key; });
			}
			$sql=mysqli_query($mr_con,"SELECT mrf_alias,sjo_number FROM ec_material_request WHERE from_wh='$from_wh' AND sjo_number NOT IN ('0','') AND mrf_alias IN('".implode("','",$sjo)."') AND status IN ('0','6') AND flag=0");
			if(mysqli_num_rows($sql)){
				if(isset($first) && count($first)>'0')$first1=$first;else $first1=array();
				if($i!=0)$i++;
				while($row=mysqli_fetch_array($sql)){
					$cnt = $first1[$row['mrf_alias']]-$last[$row['mrf_alias']]-(count($lost) ? $lost[$row['mrf_alias']] : 0);
					//if($cnt!='0' && !array_key_exists($row['mrf_alias'],$pend)){}
					if($cnt!='0'){
						$result[$i]['count_a']=$cnt;
						$result[$i]['alias_a']=$row['mrf_alias'];
						$result[$i]['name_a']=$row['sjo_number'];
						$i++;
					}
				}
			}
		}
		if($i==0){$result[0]['alias_a']='4';$result[0]['name_a']='No Records Found';$result[0]['count_a']='0';}
	}else{$result[0]['alias']='4';$result[0]['name']='No Records Found';$result[0]['count_a']='0';}
	echo json_encode($result);
}
function scrapcellsget(){ global $mr_con;
	$srp_cell=array();
	$sjo=mysqli_real_escape_string($mr_con,$_REQUEST['sjo']);
	$loc=mysqli_real_escape_string($mr_con,$_REQUEST['y']);
	if(!empty($sjo) && !empty($loc)){
		if($sjo=="NA"){ //NON SJO
			$srp_cella=array();
			$qb=mysqli_query($mr_con,"SELECT t1.item_code_alias FROM ec_item_code t1 INNER JOIN ec_total_cell t2 ON t1.item_code_alias=t2.cell_alias WHERE t1.sjo_no='' AND t2.location='$loc' AND t2.condition_id IN ('3','4')");
			if(mysqli_num_rows($qb)>'0'){
				while($rb=mysqli_fetch_array($qb)){
					$srp_cell[]=$rb['item_code_alias'];
				}
			}
			$qc=mysqli_query($mr_con,"SELECT cell_alias FROM ec_total_cell WHERE cell_alias IN (SELECT item_description FROM ec_material_received_details WHERE item_type='1' AND reference IN (SELECT alias FROM ec_material_inward WHERE from_type ='1' AND to_wh='$loc' )) AND condition_id IN ('3','4') AND location='$loc' AND flag=0");
			if(mysqli_num_rows($qc)>'0'){
				while($rc=mysqli_fetch_array($qc)){
					$srp_cella[]=$rc['cell_alias'];
				}$srp_cell=array_diff($srp_cell,$srp_cella);
			}
		}else{ //With SJO
			$qa=mysqli_query($mr_con,"SELECT sjo_number,ticket_alias FROM ec_material_request WHERE mrf_alias='$sjo'");
			if(mysqli_num_rows($qa)>'0'){
				$ra=mysqli_fetch_array($qa);
				$mrf_als=$sjo;
				$sjo_num=$ra['sjo_number'];
				$ticket_als=$ra['ticket_alias'];
				if(!empty($sjo_num)){
					$qb=mysqli_query($mr_con,"SELECT t1.item_code_alias FROM ec_item_code t1 INNER JOIN ec_total_cell t2 ON t1.item_code_alias=t2.cell_alias WHERE t1.sjo_no='$mrf_als' AND t2.location='$loc' AND t2.condition_id IN ('3','4')");
					if(mysqli_num_rows($qb)>'0'){
						while($rb=mysqli_fetch_array($qb)){
							$srp_cell[]=$rb['item_code_alias'];
						}
					}
				}
				if(!empty($ticket_als)){
					//$qc=mysqli_query($mr_con,"SELECT cell_alias FROM ec_total_cell WHERE cell_alias IN (SELECT item_description FROM ec_material_received_details WHERE item_type='1' AND reference IN (SELECT alias FROM ec_material_inward WHERE ref_no ='$ticket_als')) AND condition_id IN ('3','4') AND location='$loc' AND flag=0");
					$qc=mysqli_query($mr_con,"SELECT cell_alias FROM ec_total_cell WHERE cell_alias IN (SELECT item_description FROM ec_material_received_details WHERE item_type='1' AND reference IN (SELECT alias FROM ec_material_inward WHERE from_type IN('1','2') AND sjo_number ='$sjo')) AND condition_id IN ('3','4') AND location='$loc' AND flag=0");
					if(mysqli_num_rows($qc)>'0'){
						while($rc=mysqli_fetch_array($qc)){
							$srp_cell[]=$rc['cell_alias'];
						}
					}
				}
			}
		}
		$srp_cell=array_unique($srp_cell);
		if(count($srp_cell)>0){
			$sql=mysqli_query($mr_con,"SELECT cell_alias,item_code FROM ec_total_cell WHERE cell_alias IN ('".implode("','",$srp_cell)."') AND condition_id IN ('3','4') AND location='$loc' AND flag=0");
			if(mysqli_num_rows($sql)){$result1['itemcount']=1;
				$i=0;while($row=mysqli_fetch_array($sql)){
					$result1['srapi'][$i]['alias']=$row['cell_alias'];
					$result1['srapi'][$i]['Productname']=alias($row['item_code'],'ec_product','product_alias','product_description'); 
					$result1['srapi'][$i]['name']=alias($row['cell_alias'],'ec_item_code','item_code_alias','item_description'); 
				$i++;}
			}else{$result1[0]['alias']='4';$result1[0]['name']='No Records Found';}
		}else{$result1[0]['alias']='4';$result1[0]['name']='No Records Found';}
	}else{$result1[0]['alias']='4';$result1[0]['name']='No Records Found';}
	echo json_encode($result1);
}
function siteList_mi(){ global $mr_con;
	$emp_alias=mysqli_real_escape_string($mr_con,$_REQUEST['x']);
	$to_wh=mysqli_real_escape_string($mr_con,$_REQUEST['to_wh']);
	if($emp_alias!="" || $to_wh!=""){
		$whtype=alias($to_wh,'ec_warehouse','wh_alias','wh_type');
		$state_alias=alias($to_wh,'ec_warehouse','wh_alias','state_alias');
		if($whtype=='1')$sql=mysqli_query($mr_con,"SELECT site_id,site_alias FROM ec_sitemaster WHERE flag=0");
		else $sql=mysqli_query($mr_con,"SELECT site_id,site_alias FROM ec_sitemaster WHERE state_alias='$state_alias' AND flag=0");
		if(mysqli_num_rows($sql)){
			$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['site_alias'];$result[$i]['name']=$row['site_id']; $i++;}
		}else{$result[0]['alias']='4';$result[0]['name']='No Records Found';}
	}else{$result[0]['alias']='4';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function mrfList_mi(){ global $mr_con;
	$emp_alias=mysqli_real_escape_string($mr_con,$_REQUEST['x']);
	$to_wh=mysqli_real_escape_string($mr_con,$_REQUEST['to_wh']);
	if($emp_alias!="" || $to_wh!=""){
		$sql=mysqli_query($mr_con,"SELECT mrf_number,mrf_alias FROM ec_material_request WHERE from_wh='$to_wh' AND status='4' AND sjo_number NOT IN ('0','') AND flag=0");
		if(mysqli_num_rows($sql)){
			$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['mrf_alias'];$result[$i]['name']=$row['mrf_number']; $i++;}
		}else{$result[0]['alias']='4';$result[0]['name']='No Records Found';}
	}else{$result[0]['alias']='4';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function whfList_mi(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT wh_code,wh_alias FROM ec_warehouse WHERE wh_type<>'1' AND flag=0");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['wh_alias'];$result[$i]['name']=$row['wh_code']; $i++;}
	}else{$result[0]['alias']='4';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function materialRequestTo(){ global $mr_con;
	$emp_alias=mysqli_real_escape_string($mr_con,$_POST['alias']);
	if(strtoupper($emp_alias)!="ADMIN"){
		$privilege_alias=alias(mysqli_real_escape_string($mr_con,$_POST['alias']),'ec_employee_master','employee_alias','privilege_alias');
		if($emp_alias!="" || $privilege_alias!=""){
			$sql=mysqli_query($mr_con,"SELECT grantable FROM ec_privileges WHERE privilege_type ='ADD' AND privilege_item='MATERIAL REQUEST' AND privilege_alias='$privilege_alias' AND flag=0");
			if(mysqli_num_rows($sql)){$row = mysqli_fetch_array($sql);$grant_a = $row['grantable'];}else{$grant_a="0";}
			$sql=mysqli_query($mr_con,"SELECT grantable FROM ec_privileges WHERE privilege_type ='SPECIAL' AND privilege_item='MATERIAL REQUEST' AND privilege_alias='$privilege_alias' AND flag=0");
			if(mysqli_num_rows($sql)){$row = mysqli_fetch_array($sql);$grant_b = $row['grantable'];}else{$grant_b="0";}
			if($grant_a=="1" && $grant_b=="1") $sql=mysqli_query($mr_con,"SELECT wh_code,wh_alias FROM ec_warehouse WHERE wh_type='1' AND flag=0");
			else $sql=mysqli_query($mr_con,"SELECT wh_code,wh_alias FROM ec_warehouse WHERE wh_type='0' AND flag=0");
			if(mysqli_num_rows($sql)){$i=0;
				while($row=mysqli_fetch_array($sql)){
					$result[$i]['alias']=$row['wh_alias'];
					$result[$i]['name']=$row['wh_code'];
					$i++;
				}
			}
		}else{$result['role']="0";}
	}else{
		$sql=mysqli_query($mr_con,"SELECT wh_alias, wh_code FROM ec_warehouse WHERE flag=0");
		if(mysqli_num_rows($sql)){$i=0;
			while($row=mysqli_fetch_array($sql)){
				$result[$i]['alias']=$row['wh_alias'];
				$result[$i]['name']=$row['wh_code'];
				$i++;
			}
		}else{$result['wh']=0;}
	}
	echo json_encode($result);
}
function selfWarehouse(){ global $mr_con;
	$fv1=mysqli_real_escape_string($mr_con,$_POST['alias']);
	if($fv1!=""){
		if(strtoupper($fv1)!="ADMIN"){
			$wh=alias($fv1,'ec_employee_master','employee_alias','wh_alias');
			if($wh==""){
				$state=alias($fv1,'ec_employee_master','employee_alias','state_alias');
				if($state!=""){
					$state="'".str_replace(", ","','",$state)."'";
					$sql=mysqli_query($mr_con,"SELECT wh_alias, wh_code, wh_type FROM ec_warehouse WHERE state_alias IN ($state) AND flag=0");
					if(mysqli_num_rows($sql)){$i=0;
						while($row=mysqli_fetch_array($sql)){
							$result[$i]['alias']=$row['wh_alias'];
							$result[$i]['name']=$row['wh_code'];
							$result[$i]['wtype']=$row['wh_type'];
							$i++;
						}
					}else{$result['wh']=0;}
				}else{$result['wh']=0;}
			}else{
				$wh=explode(", ",$wh);
				for($s=0;$s<count($wh);$s++){
					$result[$s]['alias']=$wh[$s];
					$result[$s]['name']=alias($wh[$s],'ec_warehouse','wh_alias','wh_code');
					$result[$s]['wtype']=alias($wh[$s],'ec_warehouse','wh_alias','wh_type');
				}
			}
		}else{
			$sql=mysqli_query($mr_con,"SELECT wh_alias, wh_code, wh_type FROM ec_warehouse WHERE flag=0");
			if(mysqli_num_rows($sql)){$i=0;
					while($row=mysqli_fetch_array($sql)){
						$result[$i]['alias']=$row['wh_alias'];
						$result[$i]['name']=$row['wh_code'];
						$result[$i]['wtype']=$row['wh_type'];
						$i++;
					}
			}else{$result['wh']=0;}
		}
	}else{$result['wh']=0;}
	echo json_encode($result);
}

function emprolenamelist(){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT employee_alias,name FROM ec_employee_master WHERE STATUS<>'RELIEVED' AND department_alias='TTTCL87RPU' AND flag=0");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){
			$result[$i]['alias']=$row['employee_alias'];
			$result[$i]['name']=$row['name'];
			$i++;
		}
	}else{$result[0]['alias']='4';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function emprolenamelist_planner() {
	global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT employee_alias, name FROM ec_employee_master WHERE (device<>'0' OR  device_2<>'0') AND flag=0");
	if(mysqli_num_rows($sql)){
		$i=0;
		while($row=mysqli_fetch_array($sql)){
			$result[$i]['alias']=$row['employee_alias'];
			$result[$i]['name']=$row['name'];
			$i++;
		}
	}else{$result[0]['alias']='4';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function zoneslistsCntrl(){ global $mr_con;
	$empname=strtoupper(mysqli_real_escape_string($mr_con,$_POST['alias']));
	if($empname=='ADMIN'){
		$sql = mysqli_query($mr_con,"SELECT zone_alias,zone_name FROM ec_zone WHERE flag=0");
	}else{
		$zoneList="'".str_replace(", ","','",alias($empname,'ec_employee_master','employee_alias','zone_alias'))."'";
		$sql = mysqli_query($mr_con,"SELECT zone_alias,zone_name FROM ec_zone WHERE zone_alias IN($zoneList) AND flag=0");
	}
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){
			$result[$i]['alias']=$row['zone_alias'];
			$result[$i]['name']=$row['zone_name'];
			$i++;
		}
	}else{$result[0]['alias']='4';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function sjolist(){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT sjo_no,item_code_alias FROM ec_item_code WHERE stat=0 AND flag=0 GROUP BY sjo_no");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){
			$result[$i]['alias']=$row['sjo_no'];
			$result[$i]['name']=alias($row['sjo_no'],'ec_material_request','mrf_alias','sjo_number');
			$i++;
		}
	}else{$result[0]['alias']='4';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function getitemslistfromsjo(){ 
	global $mr_con;
	$mrf_alias=$_REQUEST['alias'];$emp_alias=$_REQUEST['x'];
	$sql=mysqli_query($mr_con,"SELECT from_wh, to_wh FROM ec_material_request WHERE mrf_alias='$mrf_alias' AND flag=0 LIMIT 1");
	if(mysqli_num_rows($sql)){
		$row=mysqli_fetch_array($sql);
		$to_wh=$row['to_wh'];
		$result['ehfrommrf']=alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code');
		$result['road_permit']=alias($row['from_wh'],'ec_warehouse','wh_alias','road_permit');
		$sql1=mysqli_query($mr_con,"SELECT item_type,cell_type,item_description,quantity,request_items_alias,cappr_quanty FROM ec_request_items WHERE mrf_alias ='$mrf_alias' AND cappr_quanty<>'0' AND flag=0");
		if(mysqli_num_rows($sql1)){
			$i=0;
			while($row1=mysqli_fetch_array($sql1)){
				$itemtype=$row1['item_type'];
				$itemreq=$row1['item_description'];
				$result['itemx'][$i]['cell_type']=$row1['cell_type'];
				$result['itemx'][$i]['itemtype']=getitemtype($itemtype);
				$result['itemx'][$i]['itemalias']=$itemreq;
				$result['itemx'][$i]['itemdesc']=getitemname($itemtype,$itemreq);
				$result['itemx'][$i]['quanty']=$row1['quantity'];
				$result['itemx'][$i]['cappr_quanty']=$row1['cappr_quanty'];
				$result['itemx'][$i]['acc_desc']=acc_desc($row1['item_description'],$mrf_alias);
				$result['itemx'][$i]['alias']=$row1['request_items_alias'];
				$result['itemx'][$i]['celldrop']=getstockforwh_sjo($row1['cell_type'],$to_wh, $result['itemx'][$i]['itemalias'],$mrf_alias);
			$i++;}
			$result['itemcount']="1";
		}else $result['itemcount']="0";
	}else{$result['ehfrommrf']='No Records Found';}
	echo json_encode($result);
}
function acc_desc($item_description,$mrf_alias){ global $mr_con;
	$sql1=mysqli_query($mr_con,"SELECT item_code_alias FROM ec_item_code WHERE item_code='$item_description' AND sjo_no='$mrf_alias' AND item_type='2' AND id=(SELECT MAX(id) FROM ec_item_code WHERE item_code='$item_description' AND sjo_no='$mrf_alias' AND item_type='2' AND flag=0) AND flag=0");
	if(mysqli_num_rows($sql1)){ $row1=mysqli_fetch_array($sql1);
		return $row1['item_code_alias'];
	}else{return '0';}
}
function getitemslistfromsjo_ic(){ global $mr_con;
	$mrf_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
	$emp_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['x']));
	if(!empty($mrf_alias)&& $mrf_alias!="0"){ $conss='0';
		$sql=mysqli_query($mr_con,"SELECT mrf_number,sjo_file,sjo_number,sjo_date,sales_invoice_no,sales_invoice_date,sales_po_no,contact_person,customer_address,customer_phone, from_wh, to_wh, date_of_request, material_value, ticket_alias, status, mrf_alias,readiness_date FROM ec_material_request WHERE mrf_alias='$mrf_alias' AND flag=0 LIMIT 1");
		if(mysqli_num_rows($sql)){
			$row=mysqli_fetch_array($sql);
			$result['mrf_number']=$row['mrf_number'];
			$result['ehfrommrf']=alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code');
			if($row['to_wh']=='2') $result['to_wh']='Factory';
			else $result['to_wh']=alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code');
			$result['date_of_request']=dateFormat($row['date_of_request'],'d');
			$result['material_value']=$row['material_value'];
			$result['status']=$row['status'];
			$result['status_name']=fam_lvl_nm_clr($row['status'],"name",$mrf_alias);
			$result['status_color']=fam_lvl_nm_clr($row['status'],"color",$mrf_alias,$row['readiness_date']);
			if($row['ticket_alias']!='2609')$result['ticket_id']=j_getticketID($row['ticket_alias']);else $result['ticket_id']="Customer Buffer Stock";
			$result['sjo_number']=$row['sjo_number'];
			$result['sjo_date']=dateFormat($row['sjo_date'],'d');
			$result['sinv']=$row['sales_invoice_no'];
			$result['sind']=dateFormat($row['sales_invoice_date'],'d');
			$result['spon']=$row['sales_po_no'];
			$result['ccname']=$row['contact_person'];
			$result['ccadds']=$row['customer_address'];
			$result['ccnumber']=$row['customer_phone'];
			$result['sjo_file']=$row['sjo_file'];
			$conss='1';
		}else{$conss='0';$result['ehfrommrf']='No Records Found';}
		if($conss=='1'){$result['itemx']=array();
			$sql1=mysqli_query($mr_con,"SELECT item_type,cell_type,item_description,quantity,tappr_quanty,cappr_quanty,left_quanty FROM ec_request_items WHERE mrf_alias ='$mrf_alias' AND left_quanty >'0' AND flag=0");
			if(mysqli_num_rows($sql1)){
				$itemtype=$celltype=$itemreq=$rquantity=$lquantity=$acc_quantity=array();
				while($row1=mysqli_fetch_array($sql1)){
					$rquantity[]=$row1['quantity'];
					$taquantity[]=$row1['tappr_quanty'];
					$lquantity[]=$row1['left_quanty'];
					if($row1['cappr_quanty']!=0){
						$caquantity[]=$row1['cappr_quanty'];
						$itemtype[]=$row1['item_type'];
						$celltype[]=$row1['cell_type'];
						$itemreq[]=$row1['item_description'];
						$acc_quantity[$row1['item_description']]=($row1['item_type']=='2' ? $row1['cappr_quanty']:0);
					}
				}
				$result['rQuantity']=array_sum($rquantity);
				$result['lQuantity']=array_sum($lquantity);
				$result['taQuantity']=array_sum($taquantity);
				$result['caQuantity']=array_sum($caquantity);
				$result['sQuantity']=$result['rQuantity']-$result['lQuantity'];
				//$sql_a=mysqli_query($mr_con,"SELECT t2.id FROM ec_employee_master t1 INNER JOIN ec_privileges t2 ON t1.privilege_alias = t2.privilege_alias WHERE t1.employee_alias='$emp_alias' AND t2.privilege_item='STOCKS' AND t2.privilege_type='ADD' AND t2.grantable='1'");//Stock add (FACTORY QC)
				$sql_b=mysqli_query($mr_con,"SELECT t2.id FROM ec_employee_master t1 INNER JOIN ec_privileges t2 ON t1.privilege_alias = t2.privilege_alias WHERE t1.employee_alias='$emp_alias' AND t2.privilege_item='STOCKS' AND t2.privilege_type='SPECIAL' AND t2.grantable='1'");//Invoice add (FACTORY INVOICE)
				if(mysqli_num_rows($sql_b)=='0'){
					if($result['status']!='8'){
						if(array_sum($caquantity)>'500' && in_array('1',$itemtype)){
							$result['import']='0';
							$result['itemcount']='2';
							$result['mssg']='Requested Quantity are '.array_sum($caquantity).". You Need to Import the Cells using Excel";
						}else{
							$result['itemcount']='1';$i=0;
							for($z=0;$z<count($itemreq);$z++){
								if($itemtype[$z]=='2'){
									$result['itemx'][$i]['itemtypes']=$itemtype[$z];
									$result['itemx'][$i]['celltype']=$celltype[$z];
									$result['itemx'][$i]['itemtype']=getitemtype($itemtype[$z]);
									$result['itemx'][$i]['itemalias']=$itemreq[$z];
									$result['itemx'][$i]['itemdesc']=getitemname($itemtype[$z],$itemreq[$z]);
									$result['itemx'][$i]['cell_num']=$acc_quantity[$itemreq[$z]];
									$i++;
								}else{
									for($x=$i;$x<($i+$caquantity[$z]);$x++){
										$result['itemx'][$x]['itemtypes']=$itemtype[$z];
										$result['itemx'][$x]['celltype']=$celltype[$z];
										$result['itemx'][$x]['itemtype']=getitemtype($itemtype[$z]);
										$result['itemx'][$x]['itemalias']=$itemreq[$z];
										$result['itemx'][$x]['itemdesc']=getitemname($itemtype[$z],$itemreq[$z]);
										$result['itemx'][$x]['cell_num']="";
									}$i=$x;
								}
								
							}
						}
						$result['invoicing']="0";
					}elseif($result['status']=='8'){$result['invoicing']="1";}
				}else{
					$result['itema']=array();
					$result['invoicing']="1";
					$sql1=mysqli_query($mr_con,"SELECT item_type,item_code,item_description FROM ec_item_code WHERE invoice_no='' AND invoice_no!='NA' AND sjo_no ='$mrf_alias' AND flag='0'");
					if(mysqli_num_rows($sql1)>'0'){$i=0;
						while($row1=mysqli_fetch_array($sql1)){
							$itemtype=$row1['item_type'];
							$itemcode=$row1['item_code'];
							$itemdesc=$row1['item_description'];
							$result['itema'][$i]['itemtype']=getitemtype($itemtype);
							$result['itema'][$i]['itemcode']=getitemname($itemtype,$itemcode);
							$result['itema'][$i]['itemdesc']=$row1['item_description'];
							$i++;
						}
						$result['itemcount']="1";
					}else $result['itemcount']="0";
				}
			}else $result['itemcount']="0";
		}else{$result['ehfrommrf']='No Records Found';}
	}else{$result['ehfrommrf']='No Records Found';}
	$result['import']="0";
	echo json_encode($result);
}
function sitelistemp(){global $mr_con;
		if(isset($_REQUEST['alias']))$alias="site_id LIKE '%".mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']))."%' AND ";else $alias="";
		$state_alias_temp=alias($_REQUEST['x'],'ec_employee_master','employee_alias','state_alias');
		$state_alias="'".implode("','",explode(", ",$state_alias_temp))."'";
		$sql = mysqli_query($mr_con,"SELECT site_id FROM ec_sitemaster WHERE $alias flag=0 AND state_alias IN ($state_alias)");
		if(mysqli_num_rows($sql)>0){$i=0;
			while($row=mysqli_fetch_array($sql)){$result[$i]['site_id']=$row['site_id'];$i++;}
		}else{$result[0]['site_id']="No Records";}
	echo json_encode($result);
}
function faultycellsDetails(){ global $mr_con;
	$emp_alias=mysqli_real_escape_string($mr_con,$_REQUEST['x']);
	$ticketID=mysqli_real_escape_string($mr_con,$_REQUEST['ticketID']);
	if($emp_alias!="" || $ticketID!=""){
		//$sql1=mysqli_query($mr_con,"SELECT faulty_cell_sr_no FROM ec_engineer_observation WHERE ticket_alias='$ticketID'");
		$sql1=mysqli_query($mr_con,"SELECT cell_sl_no FROM ec_fsr_faulty_cells WHERE ticket_alias='$ticketID'");
		if(mysqli_num_rows($sql1)){
			$item_alias=alias(alias($ticketID,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','product_alias');
			$x=0;while($row1=mysqli_fetch_array($sql1)){
				$faultycell_temp=$row1['cell_sl_no'];
				$sql = mysqli_query($mr_con,"SELECT item_code,item_description FROM ec_item_code WHERE item_description ='".$faultycell_temp."' AND item_type='1' AND flag=0");
				if(mysqli_num_rows($sql)>0){$row=mysqli_fetch_array($sql);
					$result['itemx'][$x]['productAlias']=alias($row['item_code'],'ec_product','product_alias','product_description');
					$result['itemx'][$x]['cellNumber']=$row['item_description'];
					$result['itemx'][$x]['item_alias']=$row['item_code'];
				}else{
					$result['itemx'][$x]['productAlias']="NA";
					$result['itemx'][$x]['cellNumber']=$faultycell_temp;
					$result['itemx'][$x]['item_alias']=$item_alias;
				}$x++;
			}
			$result['sjo_check_result']=(alias($ticketID,'ec_material_request','ticket_alias','mrf_alias')!='' ? '0':'1');
		}else{$result[0]['alias']='4';$result[0]['name']='No Records Found';}
	}else{$result[0]['alias']='4';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function getitemslistfromticket(){ 
	global $mr_con;
	$ticket_alias="'".str_replace(",","','",$_REQUEST['alias'])."'";$emp_alias=$_REQUEST['x'];
	$site_alias=alias($_REQUEST['alias'],'ec_tickets','ticket_alias','site_alias');
	$sale_sql=mysqli_query($mr_con,"SELECT sale_invoice_date,sale_invoice_num,po_num FROM ec_sitemaster WHERE site_alias='$site_alias' AND flag=0");
	if(mysqli_num_rows($sale_sql)){ $sale_row=mysqli_fetch_array($sale_sql);
		$result['sale_invoice_date']=dateFormat($sale_row['sale_invoice_date'],'d');
		$result['sale_invoice_num']=$sale_row['sale_invoice_num'];
		$result['po_num']=$sale_row['po_num'];
	}
	$qry1 = "SELECT DISTINCT cell_alias,item_type FROM ec_cell_required WHERE ticket_alias IN ($ticket_alias) AND quanty!='0' AND cell_alias!='' AND approved_stat in ('2', '3') AND flag=0";
	$sql1=mysqli_query($mr_con, $qry1);
	if(mysqli_num_rows($sql1)){
		$i=0;
		while($row1=mysqli_fetch_array($sql1)){
			$itemtype=$row1['item_type'];
			$itemreq=$row1['cell_alias'];
			$qry = "SELECT SUM(quanty) as tQuanty,cell_alias FROM ec_cell_required WHERE ticket_alias IN ($ticket_alias) AND quanty > '0' AND cell_alias!='' AND approved_stat in ('2', '3') AND cell_alias='$itemreq' AND flag=0";
			$sql2=mysqli_query($mr_con, $qry);
			if(mysqli_num_rows($sql2)){
				while($row2=mysqli_fetch_array($sql2)){
					$result['itemx'][$i]['itemtypeCode']=$itemtype;
					$result['itemx'][$i]['itemalias']=$row2['cell_alias'];
					$result['itemx'][$i]['itemtype']=getitemtype($itemtype);
					$result['itemx'][$i]['itemdesc']=getitemname($itemtype,$itemreq);
					$result['itemx'][$i]['quanty']=$row2['tQuanty'];
					$i++;
				}
			}
		}
		$result['itemcount']="1";
	}else $result['itemcount']="0";
	echo json_encode($result);
}
function getrequiredCellsTickets(){global $mr_con;
	$ticketID=mysqli_real_escape_string($mr_con,trim($_REQUEST['ticketID']));
	$to_wh=alias(alias_flag_none(alias($ticketID,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','state_alias'),'ec_warehouse','state_alias','wh_alias');
	$emp_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['x']));
	$sql=mysqli_query($mr_con,"SELECT cell_alias,item_type,quanty,item_alias FROM ec_cell_required WHERE ticket_alias='$ticketID' AND quanty<>'0' AND approved_stat>='2' AND flag='0'");
	if(mysqli_num_rows($sql)){$i=0;
		while($row=mysqli_fetch_array($sql)){
			$acc_item_ali = acc_item_ali($to_wh,$row['cell_alias']);
			if(($acc_item_ali!='0' && $row['item_type']==2) || $row['item_type']==1){
				$result['itemx'][$i]['itemtype']=($row['item_type']==1 ? 'CELLS':'ACCESSORIES');
				$result['itemx'][$i]['itemalias']=$row['cell_alias'];
				$result['itemx'][$i]['acc_desc']=($row['item_type']==1 ? '0':$acc_item_ali);
				$result['itemx'][$i]['itemdesc']=getitemname($row['item_type'],$row['cell_alias']);
				$result['itemx'][$i]['celldrop']=getstockforwh($to_wh, $row['cell_alias']);
				$result['itemx'][$i]['cappr_quanty']=$row['cappr_quanty'];
				$result['itemx'][$i]['quanty']=$row['quanty'];
				$result['itemx'][$i]['alias']=$row['item_alias'];
			$i++;
			}
		}$result['sjo_check_result']=(alias($ticketID,'ec_material_request','ticket_alias','mrf_alias')!='' ? '0':'1');
		$result['itemcount']="1";
	}else{$result['itemcount']="0";}
	echo json_encode($result);
}
function acc_item_ali($wh_alias,$item_code){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT acc_alias FROM ec_total_accessories WHERE id=(SELECT MAX(id) FROM ec_total_accessories WHERE location ='$wh_alias' AND stage='0' AND good_qty>'0' AND item_code='$item_code' AND flag=0) AND flag=0");
	if(mysqli_num_rows($sql)){
		$row=mysqli_fetch_array($sql); return $row['acc_alias'];
	}else return '0';
}
function getbufferstocksforow_mo(){global $mr_con;
	$buffersjo=mysqli_real_escape_string($mr_con,trim($_REQUEST['buffersjo']));
	//$sq=mysqli_query($mr_con,"SET GLOBAL group_concat_max_len = 10000000");
	$sql2=mysqli_query($mr_con,"SELECT COUNT(t4.id) AS cnt,GROUP_CONCAT('''',t4.item_description,'''') AS done_cells FROM ec_material_sent_details t4 INNER JOIN ec_material_outward t3 ON t4.reference = t3.alias WHERE IF(t4.item_type != '2', t4.item_condition IN ('1','2'), t4.item_condition BETWEEN 0 AND 7) AND t3.from_type='1' AND t3.sjo_number='$buffersjo'");
	$row2=mysqli_fetch_array($sql2);
	$done_cells=($row2['cnt']>'0' ? $row2['done_cells'] : "''");

	$sql3=mysqli_query($mr_con,"SELECT MIN(t3.id) AS min_id FROM ec_material_received_details t4 INNER JOIN ec_material_inward t3 ON t4.reference = t3.alias WHERE IF(t4.item_type != '2', t4.item_condition IN ('1','2'), t4.item_condition BETWEEN 0 AND 7) AND t3.from_type='3' AND t3.sjo_number='$buffersjo' AND t4.item_description NOT IN(".$done_cells.")");
	$row3=mysqli_fetch_array($sql3);
	$min_id=$row3['min_id'];

	$sql=mysqli_query($mr_con,"SELECT t1.item_code,t1.item_type,t1.item_description,t1.item_condition FROM ec_material_received_details t1 INNER JOIN ec_material_inward t2 ON t1.reference = t2.alias WHERE t2.id='$min_id'");
	if(mysqli_num_rows($sql)){$i=0;
		while($row=mysqli_fetch_array($sql)){
			$result['itemx'][$i]['itemtype']=$row['item_type'];
			$result['itemx'][$i]['itemdesc']=alias($row['item_description'],'ec_item_code','item_code_alias','item_description');
			if($row['item_type']=='1'){
				$itemtype_text='CELLS';
				$itemcode=alias($row['item_code'],'ec_product','product_alias','product_description');
				$condition=alias($row['item_condition'],'ec_stock','stock_alias','description');
			}else{
				$itemtype_text='ACCESSORIES';
				$itemcode=alias($row['item_code'],'ec_accessories','accessories_alias','accessory_description');
				list($good,$damaged,$lost)=explode("@@",gd_dm_view_count($row['item_description'],'2'));
				$condition[0]['title']="Good";$condition[1]['title']="Damaged";$condition[2]['title']="Lost";
				$condition[0]['quantity']=$good;$condition[1]['quantity']=$damaged;$condition[2]['quantity']=$lost;
			}
			$result['itemx'][$i]['itemtype_text']=$itemtype_text;
			$result['itemx'][$i]['itemcode']=$itemcode;
			$result['itemx'][$i]['itemcondition']=$condition;
			$i++;
		}
		$result['itemcount']="1";
	}else{$result['itemcount']="0";}
	echo json_encode($result);
}
/*function getbufferstocksforow_mo(){global $mr_con;
	$buffersjo=mysqli_real_escape_string($mr_con,trim($_REQUEST['buffersjo']));
	$sql=mysqli_query($mr_con,"SELECT t1.item_code,t1.item_type,t1.item_description,t1.item_condition FROM ec_material_received_details t1 INNER JOIN ec_material_inward t2 ON t1.reference = t2.alias WHERE t2.from_type='3' AND t2.ref_no='$buffersjo'");
	if(mysqli_num_rows($sql)){$i=0;
		while($row=mysqli_fetch_array($sql)){
				$result['itemx'][$i]['itemtype']=$row['item_type']; //AND t1.item_condition IN ('1','2')
				$result['itemx'][$i]['itemcode']=alias($row['item_code'],'ec_product','product_alias','product_description');
				$result['itemx'][$i]['itemdesc']=alias($row['item_description'],'ec_item_code','item_code_alias','item_description');
				$result['itemx'][$i]['itemcondition']=gd_dm_view_count($row['item_description'],'2');//alias($row['item_condition'],'ec_stock','stock_alias','description');
			$i++;
		}
		$result['itemcount']="1";
	}else{$result['itemcount']="0";}
	
	echo json_encode($result);
}*/
function nhsApprovedTickets(){ 
	global $mr_con;
	$wh_alias = "";
	if(isset($_REQUEST['site_id'])){
		$site_alias=alias_flag_none(mysqli_real_escape_string($mr_con,$_REQUEST['site_id']),'ec_sitemaster','site_id','site_alias');
		$condition=" ec_t1.site_alias='".$site_alias."' AND ec_t2.approved_stat IN ('2')";
	}elseif(isset($_REQUEST['wh_alias'])){
		$wh_alias = mysqli_real_escape_string($mr_con,$_REQUEST['wh_alias']);
		$state_alias="'".str_replace(", ","','",alias($wh_alias,'ec_warehouse','wh_alias','state_alias'))."'";
		$condition=" ec_t1.site_alias IN (SELECT site_alias FROM ec_sitemaster WHERE state_alias IN ($state_alias)) AND ec_t2.approved_stat='".(isset($_REQUEST['ref']) && $_REQUEST['ref']=='edit' ? '3' : '2')."'";
		$result[0]['road_permit']=alias($wh_alias,'ec_warehouse','wh_alias','road_permit');
	}else{
		$state_alias="'".str_replace(", ","','",alias(mysqli_real_escape_string($mr_con,$_REQUEST['x']),'ec_employee_master','employee_alias','state_alias'))."'";
		$condition=" ec_t1.site_alias IN (SELECT site_alias FROM ec_sitemaster WHERE state_alias IN ($state_alias)) AND ec_t2.approved_stat='2'";
	}
	$found = false;
	$sql=mysqli_query($mr_con,"SELECT DISTINCT ec_t1.ticket_id, ec_t1.ticket_alias FROM ec_tickets ec_t1 INNER JOIN ec_cell_required ec_t2 ON ec_t1.ticket_alias = ec_t2.ticket_alias WHERE ec_t1.level NOT IN ('6','7') AND $condition ");
	$i=0;
	$tkts = [];
	if(mysqli_num_rows($sql)){
		if(isset($_REQUEST['site_id'])){$result['sitealias']=$site_alias;}
		while($row=mysqli_fetch_array($sql)){
			$found = true;
			$result[$i]['ticketAlias']=$row['ticket_alias'];
			$result[$i]['ticketId']=strtok($row['ticket_id'],"|");
			$tkts[] = $row['ticket_alias'];
			$i++;
		}
	}
	$qry = "SELECT DISTINCT ticket_id, ticket_alias FROM ec_tickets where ticket_alias in (SELECT distinct ticket_alias FROM ec_material_request WHERE status in (5) and from_wh = '$wh_alias' and flag = 0) and ticket_alias not in (SELECT distinct ticket_alias FROM ec_material_request WHERE status not in (5) and from_wh = '$wh_alias' and flag = 0) and level = 1";
	$sql=mysqli_query($mr_con, $qry);
	if(mysqli_num_rows($sql)){
		while($row=mysqli_fetch_array($sql)){
			$found = true;
			if(!in_array($row['ticket_alias'], $tkts)) {
				$result[$i]['ticketAlias']=$row['ticket_alias'];
				$result[$i]['ticketId']=strtok($row['ticket_id'],"|");
				$i++;
			}
		}
	}
	if (!$found) {
		$result[0]['ticketAlias']='0';
		$result[0]['ticketId']='No Records Found';
	}
	echo json_encode($result);
}
function getselectedsjo(){ 
	global $mr_con;
	date_default_timezone_set("Asia/Kolkata");
	$date=date('Y-m-d');
	$emp_alias=mysqli_real_escape_string($mr_con,$_REQUEST['alias']);
	$whouse=getempwarehouse($emp_alias);
	$sql_a=mysqli_query($mr_con,"SELECT t2.id FROM ec_employee_master t1 INNER JOIN ec_privileges t2 ON t1.privilege_alias = t2.privilege_alias WHERE t1.employee_alias='".$_REQUEST['alias']."' AND t2.privilege_item='STOCKS' AND t2.privilege_type='SPECIAL' AND t2.grantable='1'"); //Invoice
	if(mysqli_num_rows($sql_a)>'0'){
		$query = "SELECT t1.sjo_number,t1.mrf_alias, t1.flag FROM ec_material_request t1 INNER JOIN ec_item_code t2 ON t1.mrf_alias=t2.sjo_no WHERE t1.sjo_number NOT IN ('0','') AND t1.to_wh IN ($whouse) AND t1.status IN ('8') AND t1.flag='0' GROUP BY t1.mrf_alias";
		$sql=mysqli_query($mr_con, $query);
	} else {
		$query = "SELECT sjo_number,mrf_alias FROM ec_material_request WHERE to_wh IN ($whouse) AND status IN ('9','0') AND readiness_date>='$date' AND flag='0'";
		$sql=mysqli_query($mr_con, $query);
	} 
	if(mysqli_num_rows($sql)){$i=0;
		while($row=mysqli_fetch_array($sql)){ 
			$result[$i]['ticketAlias']=$row['mrf_alias'];
			$result[$i]['ticketId']=$row['sjo_number'];
			$result[$i]['flag']=$row['flag'];
			$i++;
		}
	}else{$result[0]['ticketAlias']='0';$result[0]['ticketId']='No Records Found';}
	echo json_encode($result);
}
function sjodetails(){ global $mr_con;
	$sjo_no = mysqli_real_escape_string($mr_con,$_REQUEST['alias']);
	$sql = mysqli_query($mr_con,"SELECT * FROM ec_item_code WHERE sjo_no='$sjo_no' AND flag=0");
	if(mysqli_num_rows($sql)){$result['itemcount']=1;
		$i=0;while($row = mysqli_fetch_array($sql)){
			$result['invoice_no']=$row['invoice_no'];
			$result['invoice_date']=$row['invoice_date'];
			$result['sjodetails'][$i]['item_type']=$row['item_type'];
			$result['sjodetails'][$i]['item_description']=$row['item_description'];
			$result['sjodetails'][$i]['item_code']=getitemname($result['sjodetails'][$i]['item_type'],$row['item_code']);
			$result['sjodetails'][$i]['item_alias']=$row['item_code_alias'];
		$i++;}
	}else $result['itemcount']=0;
	echo json_encode($result);
}
function sjo_search(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	$whouse=getempwarehouse($emp_alias);
	if($rex==0){
		$condtion=($_REQUEST['sjo_no']!="" ? "sjo_no IN (SELECT mrf_alias FROM ec_material_request WHERE sjo_number LIKE '%".mysqli_real_escape_string($mr_con,strtoupper($_REQUEST['sjo_no']))."%' AND flag='0') AND" : "");
		$rec=mysqli_query($mr_con,"SELECT COUNT(id) FROM ec_item_code WHERE $condtion flag=0");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sqlTT = mysqli_query($mr_con,"SELECT item_code,item_description,item_type,item_code_alias,sjo_no FROM ec_item_code WHERE $condtion flag=0 LIMIT $offset, $limit");
			$result['requestDetails']=array();
			$result['sjo_no']=$_REQUEST['sjo_no'];
			if(mysqli_num_rows($sqlTT)){ $i=0;
				while($rowTT = mysqli_fetch_array($sqlTT)){
					$result['requestDetails'][$i]['cell_number']=$rowTT['item_description'];
					$item_type=$rowTT['item_type'];
					if($item_type==1){
						$sqlet = mysqli_query($mr_con,"SELECT condition_id,stage,location_type,location FROM ec_total_cell WHERE cell_alias='".$rowTT['item_code_alias']."' AND flag='0'");
						if(mysqli_num_rows($sqlet)){
							$rowet = mysqli_fetch_array($sqlet);
							$current_location = current_location($rowet['stage'],$rowet['location_type'],$rowet['location']);
							$cell_condition=alias($rowet['condition_id'],'ec_stock','stock_alias','description');
							$item_desc='CELL';
							$cell_value=round(alias($rowTT['item_code'],'ec_product','product_alias','price'),2);
						}else $current_location =$cell_condition=$cell_value =$item_desc='NA';
					}elseif($item_type==2){
						$sss=mysqli_query($mr_con,"SELECT location,location_type,stage FROM ec_total_accessories WHERE acc_alias='".$rowTT['item_code_alias']."' AND flag='0'");
						if(mysqli_num_rows($sss)){
							$rowet=mysqli_fetch_array($sss);
							$current_location = current_location($rowet['stage'],$rowet['location_type'],$rowet['location']);
							$cell_condition='NEW';
							$item_desc='ACCESSORIES';
							$cell_value = round(alias($rowTT['item_code'],'ec_accessories','accessories_alias','price'),2);
						}else $current_location =$cell_condition=$cell_value =$item_desc='NA';
					}else $current_location =$cell_condition=$cell_value =$item_desc='NA';
					$result['requestDetails'][$i]['item_type']=$item_desc;
					$result['requestDetails'][$i]['current_location']=$current_location;
					$result['requestDetails'][$i]['cell_condition']=$cell_condition;
					$result['requestDetails'][$i]['cell_value']=$cell_value; 
					$result['requestDetails'][$i]['sjo_no']=$rowTT['sjo_no'];
					$result['requestDetails'][$i]['cell_alias']=$rowTT['item_code_alias'];
					$i++;
				}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
			$result['export']=grantable('EXPORT','SJO SEARCH',$emp_alias);
		}
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';}
	else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x;else $result['pages'][1]=1;
	echo json_encode($result);
}
function cellhistoryDetails(){ global $mr_con;
	$emp_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias']));
	$token=mysqli_real_escape_string($mr_con,trim($_REQUEST['token']));
	$alias= mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$rex=authentication($emp_alias,$token);
	$result['cell_alias']=$alias;
	if($rex==0){
		$sql=mysqli_query($mr_con,"SELECT * FROM ec_item_code WHERE item_code_alias='".$alias."'");
		if(mysqli_num_rows($sql)>0){
		$row=mysqli_fetch_array($sql);
		$item_type=$row['item_type'];
		$result['item_type']=$item_type;
			if($item_type==1){
				$result['cell_value']=round(alias($row['item_code'],'ec_product','product_alias','price'),2);
				$result['item_code']=alias($row['item_code'],'ec_product','product_alias','product_description');
				$sqloo=mysqli_query($mr_con,"SELECT condition_id,stage,location_type,location FROM ec_total_cell WHERE cell_alias='".$row['item_code_alias']."' AND flag='0'");
				if(mysqli_num_rows($sqloo)){
					$rowet = mysqli_fetch_array($sqloo);
					$condition_desc=alias($rowet['condition_id'],'ec_stock','stock_alias','description');
					$current_location=current_location($rowet['stage'],$rowet['location_type'],$rowet['location']);
				}else $condition_desc=$current_location='NA';
					
				$sql1 = mysqli_query($mr_con,"SELECT message,transaction_date FROM ec_total_cell_history WHERE cell_alias = '".$row['item_code_alias']."'");
				if(mysqli_num_rows($sql1)){
					$i=0;while($row1=mysqli_fetch_array($sql1)){
						$result['request_items'][$i]['message']=$row1['message'];
						$result['request_items'][$i]['transaction_date']=$row1['transaction_date'];
					$i++;}
				}
			}else{
				$result['item_code']=(!empty(alias($row['item_code'],'ec_accessories','accessories_alias','accessory_description')) ? alias($row['item_code'],'ec_accessories','accessories_alias','accessory_description') : 'NA');
					$result['cell_value']=$row['item_description']*(round(alias($row['item_code'],'ec_accessories','accessories_alias','price'),2));
					$sqlet = mysqli_query($mr_con,"SELECT stage,location_type,good_qty,damaged_qty,lost_qty,location FROM ec_total_accessories WHERE acc_alias='".$row['item_code_alias']."'");
					if(mysqli_num_rows($sqlet)){ $rowet = mysqli_fetch_array($sqlet);
						$condition_desc=gd_dm_view_count($row['item_code_alias'],'1');
						$current_location=current_location($rowet['stage'],$rowet['location_type'],$rowet['location']);
					}else $condition_desc=$current_location="NA";
					$sql1 = mysqli_query($mr_con,"SELECT message,transaction_date FROM ec_total_accessory_history WHERE cell_alias = '".$row['item_code_alias']."'");
					if(mysqli_num_rows($sql1)){
						$i=0;while($row1=mysqli_fetch_array($sql1)){
							$result['request_items'][$i]['message']=$row1['message'];
							$result['request_items'][$i]['transaction_date']=$row1['transaction_date'];
						$i++;}
					}else{$result['request_length']=0;}
			}
			$result['cell_number']=$row['item_description'];
			$result['sjo_number']=alias($row['sjo_no'],'ec_material_request','mrf_alias','sjo_number');
			$result['cell_condition']=(!empty($condition_desc) ? $condition_desc : 'NA');
			$result['current_location']=(!empty($current_location) ? $current_location : 'NA');
		}
		$resCode='0'; $resMsg='Successful!';	
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function outwarditemlist(){ global $mr_con;
	$mrf_alias=mysqli_real_escape_string($mr_con,$_REQUEST['alias']);
	//$sq1 = mysqli_query($mr_con,"SELECT item_type,item_code,item_description FROM ec_material_sent_details WHERE reference IN (SELECT alias FROM ec_material_outward WHERE ref_no ='$mrf_alias') ");
	$sq1 = mysqli_query($mr_con,"SELECT t1.item_type,t1.item_code,t1.item_description,t1.reference FROM ec_material_sent_details t1 INNER JOIN ec_material_outward t2 ON t1.reference=t2.alias WHERE t2.id=(SELECT MAX(id) FROM `ec_material_outward` WHERE ref_no='$mrf_alias' AND from_type='3' AND flag='0') AND t1.flag='0'");
	if(mysqli_num_rows($sq1)>'0'){$result['itemcount']=1;$i=0;
		while($rw1 = mysqli_fetch_array($sq1)){
			$result['sjodetails'][$i]['item_type']=($rw1['item_type']=='1' ? "CELLS" : "ACCESSORIES");
			$result['sjodetails'][$i]['item_code']=($rw1['item_type']=='1' ? alias($rw1['item_code'],'ec_product','product_alias','product_description') : alias($rw1['item_code'],'ec_accessories','accessories_alias','accessory_description'));
			$result['sjodetails'][$i]['item_description']=alias($rw1['item_description'],'ec_item_code','item_code_alias','item_description');
			$result['sjodetails'][$i]['item_alias']=$rw1['item_description'];
			$i++;
		}
		$f_wh=alias('1','ec_warehouse','wh_type','wh_alias');
		$sql0 = mysqli_query($mr_con,"SELECT transport,docket,dispatch_date,alias FROM ec_material_outward WHERE sjo_number ='$mrf_alias' AND from_wh='$f_wh' AND flag='0' ORDER BY id DESC LIMIT 1");
		if(mysqli_num_rows($sql0)){
			$result['disp_length']=mysqli_num_rows($sql0);
			$i=0;while($row0=mysqli_fetch_array($sql0)){
				$result['disp'][$i]['transport']=$row0['transport'];
				$result['disp'][$i]['docket']=$row0['docket'];
				$result['disp'][$i]['dispatch_date']=dateFormat($row0['dispatch_date'],'d');
				$result['disp_date_check']=dateFormat($row0['dispatch_date'],'m');
				$sql01 = mysqli_query($mr_con,"SELECT remarks FROM ec_remarks WHERE item_alias ='".$row0['alias']."' AND module='MO' AND flag='0'");
				if(mysqli_num_rows($sql01)){ $row01=mysqli_fetch_array($sql01);
					$result['disp'][$i]['out_rem']=$row01['remarks'];
				}else{$result['disp'][$i]['out_rem']='NA';} $i++;
			}
		}else $result['disp_length']='0';
		$result['sjo_number']=alias($mrf_alias,'ec_material_request','mrf_alias','sjo_number');
	}else $result['itemcount']=0;
	echo json_encode($result);
}
function getscrapitemsfrmwh(){ global $mr_con;
	$emp_alias=mysqli_real_escape_string($mr_con,$_REQUEST['x']);
	$from_wh=mysqli_real_escape_string($mr_con,$_REQUEST['alias']);
	if($emp_alias!="" || $wh!=""){
		$to_wh=alias('1','ec_warehouse','wh_type','wh_alias');
		$sql=mysqli_query($mr_con,"SELECT alias FROM ec_material_outward WHERE from_wh='$from_wh' AND to_wh='$to_wh' AND flag=0");
		if(mysqli_num_rows($sql)){$xa=0;$jagn=array();
			while($row=mysqli_fetch_array($sql)){
				$outward_alias=$row['alias'];
				$sq1 = mysqli_query($mr_con,"SELECT item_type,item_code,item_description,item_condition FROM ec_material_sent_details WHERE reference='".$outward_alias."'");
				if(mysqli_num_rows($sq1)>'0'){
					while($rw1 = mysqli_fetch_array($sq1)){
						$currentcondtion=alias($rw1['item_description'],'ec_total_cell','cell_alias','stage');
						if($currentcondtion=="1"){
							$result['scrapdetails'][$xa]['alias']=$rw1['item_description'];
							$result['scrapdetails'][$xa]['cellname']=alias($rw1['item_description'],'ec_item_code','item_code_alias','item_description');
							$result['scrapdetails'][$xa]['condition']=alias($rw1['item_condition'],'ec_stock','stock_alias','description');
							$result['scrapdetails'][$xa]['pname']=alias($rw1['item_code'],'ec_product','product_alias','product_description');
							$jagn[]=0;
							$xa++;
						}
						if(count($jagn)>'0')$result['itemcount']=1;else $result['itemcount']=0;
						
					}
				}else $result['itemcount']=0;
			}
		}else{$result[0]['alias']='4';$result[0]['name']='No Records Found';}
	}else{$result[0]['alias']='4';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
function trans_id($tbl,$field){global $mr_con;
	$trans_id = "#".rand('10000','99999');
	$sql = mysqli_query($mr_con,"SELECT id FROM $tbl WHERE $field='$trans_id' AND flag=0");
	if(mysqli_num_rows($sql)==0){ return $trans_id;	}
	else{ return trans_id($tbl,$field);}
}
//Material Request Service Starts
function material_request_rand(){
	$result['rand']=request_random(rand(00000,99999));
	echo json_encode($result);
}
function request_random($a){ global $mr_con;
	$rand="MRF-".$a;
	$query=mysqli_query($mr_con,"SELECT id FROM ec_material_request WHERE mrf_number='$rand' AND flag=0");
	return (mysqli_num_rows($query) ? request_random(rand(00000,99999)) : $rand);
}
function material_request_add(){ 
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = $_REQUEST['emp_alias']; $token = $_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		//$_REQUEST['item_type']=$_REQUEST['item_description']=$_REQUEST['quantity']=array();
		if(isset($_REQUEST['mrf_number']) && !empty(trim($_REQUEST['mrf_number'])))$mrf_number = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['mrf_number'])));else $mrf_number="0";
		if(isset($_REQUEST['from_wh']) && !empty(trim($_REQUEST['from_wh'])))$from_wh = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['from_wh'])));else $from_wh="0";
		if(isset($_REQUEST['to_wh']) && !empty(trim($_REQUEST['to_wh'])))$to_wh = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['to_wh'])));else $to_wh="0";
		if(isset($_REQUEST['sjo_number']) && !empty(trim($_REQUEST['sjo_number'])))$sjo_number = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['sjo_number'])));else $sjo_number=0;
		if(isset($_REQUEST['sjo_date']) && !empty(trim($_REQUEST['sjo_date'])))$sjo_date=dateFormat(strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['sjo_date']))),'y');else $sjo_date=0;
		if(isset($_REQUEST['ticketID']) && !empty(trim($_REQUEST['ticketID'])))$ticket_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['ticketID'])));else $ticket_alias=0;
		if(isset($_REQUEST['cust_alias']) && !empty(trim($_REQUEST['cust_alias'])))$customer_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['cust_alias'])));else $customer_alias=0;
		if(isset($_REQUEST['sinvoice_number']) && !empty(trim($_REQUEST['sinvoice_number'])))$sinvoice_number=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['sinvoice_number'])));else $sinvoice_number=0;
		if(isset($_REQUEST['sinvoice_date']) && !empty(trim($_REQUEST['sinvoice_date'])))$sinvoice_date=dateFormat(strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['sinvoice_date']))),'y');else $sinvoice_date=0;
		if(isset($_REQUEST['po_number']) && !empty(trim($_REQUEST['po_number'])))$po_number=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['po_number'])));else $po_number=0;
		if(isset($_REQUEST['ccname']) && !empty(trim($_REQUEST['ccname'])))$ccname=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['ccname'])));else $ccname=0;
		if(isset($_REQUEST['ccnumber']) && !empty(trim($_REQUEST['ccnumber'])))$ccnumber=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['ccnumber'])));else $ccnumber=0;
		if(isset($_REQUEST['customerAdd']) && !empty(trim($_REQUEST['customerAdd'])))$customerAdd=mysqli_real_escape_string($mr_con,trim($_REQUEST['customerAdd']));else $customerAdd=0;
		if(isset($_REQUEST['remarks']) && !empty(trim($_REQUEST['remarks'])))$remarks=mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks']));else $remarks=0;
		
		if(isset($_REQUEST['transit_damaged']) && trim($_REQUEST['transit_damaged'])!="")$transit_damaged=mysqli_real_escape_string($mr_con,trim($_REQUEST['transit_damaged']));else $transit_damaged="";
		if(isset($_REQUEST['amount_range']) && !empty(trim($_REQUEST['amount_range'])))$amount_range=mysqli_real_escape_string($mr_con,trim($_REQUEST['amount_range']));else $amount_range=0;
		
		if(isset($_REQUEST['cell_type']))$a0=count(array_filter($_REQUEST['cell_type']));else $a0=0;
		if(isset($_REQUEST['item_type']))$a1=count(array_filter($_REQUEST['item_type']));else $a1=0;
		if(isset($_REQUEST['item_description']))$a2=count(array_filter($_REQUEST['item_description']));else $a2=0;
		if(isset($_REQUEST['quantity']))$a3=count(array_filter($_REQUEST['quantity']));else $a3=0;
		if($a1 > '0'){$item_type = $_REQUEST['item_type'];}else{$item_type = '';}
		if($a0 > '0' && $a1 == $a0){$cell_type = $_REQUEST['cell_type'];}else{$cell_type = '';}
		if($a2 > '0' && $a1 == $a2){$item_description = $_REQUEST['item_description'];}else{$item_description = '';}
		if($a3 > '0' && $a2 == $a3){$quantity = $_REQUEST['quantity'];}else{$quantity = '';}
		//if(empty($mrf_number) || $mrf_number=='0'){$resCode='4';$resMsg="Enter MRF Number";}
		if(empty($from_wh) || $from_wh=='0'){$resCode='4';$resMsg="Select From Location";}
		elseif(empty($to_wh) || $to_wh=='0'){$resCode='4';$resMsg="Select To Location";}
		else{
			$to_wh_factory=alias('1','ec_warehouse','wh_type','wh_alias');
			if($to_wh_factory==$to_wh){
				if(empty($sjo_number))$sjo_test='0';else $sjo_test=alias($sjo_number,'ec_material_request','sjo_number','id');
				if($sjo_test=='0'){$resCode='4';$resMsg="Please Enter SJO Number";}
				elseif(!empty($sjo_test) && $sjo_test!='NA'){$resCode='4';$resMsg="The Selected SJO Number $sjo_number is already exist, please enter another one.";}
				elseif(empty($ticket_alias) || $ticket_alias=='0'){$resCode='4';$resMsg="Select Ticket Number";}
				elseif($ticket_alias=='2609' && empty($customer_alias)){$resCode='4';$resMsg="Select Customer";}
				//elseif(empty($sjo_number) || $sjo_number=='0'){$resCode='4';$resMsg="Enter SJO Number";}
				elseif(empty($sjo_date) || $sjo_date=='0'){$resCode='4';$resMsg="Select SJO Date";}
				elseif(empty($sinvoice_number) || $sinvoice_number=='0'){$resCode='4';$resMsg="Enter Sales Invoice Number";}
				elseif(empty($sinvoice_date) || $sinvoice_date=='0'){$resCode='4';$resMsg="Enter Sales Invoice Date";}
				elseif(empty($po_number) || $po_number=='0'){$resCode='4';$resMsg="Enter PO Number";}
				elseif(empty($ccname) || $ccname=='0'){$resCode='4';$resMsg="Enter Customer Name";}
				elseif(empty($ccnumber) || $ccnumber=='0'){$resCode='4';$resMsg="Enter Customer Number";}
				elseif(empty($customerAdd) || $customerAdd=='0'){$resCode='4';$resMsg="Enter Customer Address";}
				elseif(empty($remarks) || $remarks=='0'){$resCode='4';$resMsg="Enter Remarks";}
				
				elseif($transit_damaged==""){$resCode='4';$resMsg="Select Transit Damaged";}
				elseif($transit_damaged=="1" && empty($amount_range)){$resCode='4';$resMsg="Select amount range";}
				
				elseif($item_type==''){$resCode='4';$resMsg="Please Select Item Type";}
				elseif($item_description==''){$resCode='4';$resMsg="Please Select Item Description";}
				elseif($cell_type==''){$resCode='4';$resMsg="Please Select Cell Type";}
				elseif($quantity==''){$resCode='4';$resMsg="Please Enter Quantity";}
				else{ $ctp=count(array_unique(array_map(function($x) use ($cell_type) { return $cell_type[$x]; }, array_keys($item_type, "1"))));
					if($ctp<=1){
						$aa=$bb=$chc=array();
						for($i=0;$i<count($item_description);$i++){
							$te=trim($item_description[$i]).trim($cell_type[$i]);
							if(!in_array($te,$aa)){$aa[]=$te;$chc[]='1';}
							else{$bb[]=($item_type[$i]=='1' ? alias($item_description[$i],'ec_product','product_alias','product_description'):alias($item_description[$i],'ec_accessories','accessories_alias','accessory_description'));$chc[]='0';}
						}
						if(in_array('0',$chc)){$resCode='4';$resMsg=implode(",",array_unique($bb))." Duplication Items selected";}
						elseif($_FILES['sjo_file']['size']>0 && $_FILES['sjo_file']['size']<5242880){
							$ext = pathinfo($_FILES['sjo_file']['name'], PATHINFO_EXTENSION);
							if(strtoupper($ext)=="PDF"){
								$fileName=$emp_alias.$mrf_alias.generateRandomString()."MRSJ.".$ext;
								if(move_uploaded_file($_FILES["sjo_file"]["tmp_name"],"../../attachments/sjoFiles/".$fileName)){
									$profileimg="attachments/sjoFiles/".$fileName;
									$resCode='0';$resMsg="Successful";
								}else{$resCode='4';$resMsg="File Uploading Error! Try Again";}
							}else{$resCode='4';$resMsg="Kindly Upload Only .PDF format";}
						}else{$resCode='4';$resMsg="File Size Should by <=5MB";}

					}else{$resCode='4';$resMsg="Please Select Unique Cell Type (Either NEW OR REVIVED)";}
				}
			}else{
				if(empty($remarks) || $remarks=='0'){$resCode='4';$resMsg="Enter Remarks";}
				elseif($item_type==''){$resCode='4';$resMsg="Please Select Item Type";}
				elseif($item_description==''){$resCode='4';$resMsg="Please Select Item Description";}
				elseif($quantity==''){$resCode='4';$resMsg="Please Enter Quantity";}
				elseif(count(array_unique($item_description))!=count($item_description)){$resCode='4';$resMsg="Duplication Items selected";}
				else{$resCode='0';$resMsg="Successful";}
			}
		}
		if($resCode=='0'){
			$query=mysqli_query($mr_con,"SELECT id FROM ec_material_request WHERE mrf_number='$mrf_number' AND flag=0");
			if(mysqli_num_rows($query)=='0'){
				$value=0;
				$mrf_alias=aliasCheck(generateRandomString(),'ec_material_request','mrf_alias');
				$remark_alias=aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
				$item_desc=$ppc_item_desc="";
				for($i=0;$i<count($item_type);$i++){
					if(!empty($item_type[$i])){	
						$request_items_alias = aliasCheck(generateRandomString(),'ec_request_items','request_items_alias');
						$item_type[$i] = $_REQUEST['item_type'][$i];
						$item_description[$i] = $_REQUEST['item_description'][$i];
						$cell_type[$i] = $_REQUEST['cell_type'][$i];
						$quantity[$i] = $_REQUEST['quantity'][$i] ? $_REQUEST['quantity'][$i] : 0;
						$query = "INSERT INTO ec_request_items(mrf_alias,item_type,cell_type,item_description,quantity,left_quanty,request_items_alias)VALUES('$mrf_alias','$item_type[$i]','$cell_type[$i]','$item_description[$i]','$quantity[$i]','$quantity[$i]','$request_items_alias')";
						$sql = mysqli_query($mr_con, $query);
						if($item_type[$i]=='1'){
							if($cell_type[$i]=='1')$cl_price = round(($quantity[$i])*(alias($item_description[$i],'ec_product','product_alias','price')),2);else $cl_price=0;
							$material_value+=$cl_price;
							$itmC = alias($item_description[$i],'ec_product','product_alias','product_description')."- ".$quantity[$i];
							$item_desc.=$itmC." Cells, ";
							$ppc_item_desc.=$itmC.($cell_type[$i]=='1' ? " New" : " Revived")." Cells, ";
						}else{
							$material_value+=round(($quantity[$i])*(alias($item_description[$i],'ec_accessories','accessories_alias','price')),2);
							$itmA =alias($item_description[$i],'ec_accessories','accessories_alias','accessory_description')."- ".$quantity[$i];
							$item_desc.=$itmA." Accessories, ";
							$ppc_item_desc.=$itmA.($cell_type[$i]=='1' ? " New" : " Revived")." Accessories, ";
						}
					}
				}
				if(!empty($ticket_alias) && $ticket_alias!='2609')$customer_alias=alias(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','customer_alias');
				//$sjo_number=unique_sjo($sjo_number,"A");
				$query = "INSERT INTO ec_material_request(mrf_number,from_wh,to_wh,date_of_request,material_value,mrf_alias,status,sjo_number,sjo_date,ticket_alias,customer_alias,sjo_file,sales_invoice_no, sales_invoice_date, sales_po_no, contact_person, customer_phone, customer_address, transit_damaged, amount_range)VALUES('$mrf_number','$from_wh','$to_wh','".date('Y-m-d')."','$material_value','$mrf_alias','1','$sjo_number','$sjo_date','$ticket_alias','$customer_alias','$profileimg','$sinvoice_number','$sinvoice_date','$po_number','$ccname','$ccnumber','$customerAdd','$transit_damaged','$amount_range')";
				$sql1 = mysqli_query($mr_con, $query);
				$sql2 = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','MR','16','$mrf_alias','$emp_alias','$remark_alias')");
				if($sql1){
					$levell=(empty(next_dynamic($mrf_alias,'E')) ? '2' : '1');
					$sql3 = mysqli_query($mr_con,"UPDATE ec_material_request SET last_updated = now(), status='$levell' WHERE mrf_alias='$mrf_alias' AND flag='0'");
					$fwh_code = alias($from_wh,'ec_warehouse','wh_alias','wh_code');
					$action=$msg="Material Requested from $fwh_code to ".alias($to_wh,'ec_warehouse','wh_alias','wh_code')." with MRF No. - $mrf_number";
					inventory_notification($mrf_alias,$msg,'3');
					user_history($emp_alias,$action,$_REQUEST['ip_addr']);
					if($ticket_alias!='2609' && !empty($ticket_alias)){
						$rrrr=mysqli_query($mr_con,"UPDATE ec_cell_required SET approved_stat='3' WHERE ticket_alias='$ticket_alias' AND flag='0'");
						$ticket_id=alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
					}else $ticket_id="BUFFER";
					if($to_wh_factory==$to_wh){
						$fam_msg="Dear Team, New SJO request $sjo_number is raised for ".rtrim($item_desc,", ")." against $ticket_id of $fwh_code Circle, this request is Processed for further Approval.";
						$state_alais = alias($from_wh,'ec_warehouse','wh_alias','state_alias');
						ecSendSms('material_request_tofactory', $state_alias, "", $fam_msg);
						/*
						foreach(sms_contacts($mrf_alias,array("SE","ZHS","NHS","TS","HO","INVOICE")) as $phnum)messageSent($phnum,$fam_msg);
						$ppc_fam_msg="Dear Team, New SJO request $sjo_number is raised for ".rtrim($ppc_item_desc,", ")." against $ticket_id of $fwh_code Circle, this request is Processed for further Approval.";
						foreach(sms_contacts($mrf_alias,array("PPC")) as $phnum)messageSent($phnum,$ppc_fam_msg);
						*/
					}else{
						$fam_msg="Dear Team, New Internal WH Material request $mrf_number is raised for ".rtrim($item_desc,", ")." against $ticket_id of $fwh_code Circle, Kindly Initiate the Further Process.";
						/*
						foreach(sms_contacts($mrf_alias,array("ZHS","NHS","HO")) as $phnum)messageSent($phnum,$fam_msg);
						*/
						$state_alais = alias($from_wh,'ec_warehouse','wh_alias','state_alias');
						ecSendSms('mr_internal_req', $state_alias, "", $fam_msg);
					}
					curlxing(localURL()."services/inventory/mails/mrdmails?a=".$mrf_alias);
					$resCode='0';$resMsg='Successful! Your MRF Number is: '.$mrf_number;
				}else{$resCode='4';$resMsg="The Requested Not Successfull!, Try again Later"; }
			}else{$resCode='4';$resMsg="The Requested MRF Number has already exist, Try with other values"; }
		}		
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
/*function unique_sjo($sjo_number,$ch){ global $mr_con;
	$query=mysqli_query($mr_con,"SELECT id FROM ec_material_request WHERE sjo_number='$sjo_number' AND flag=0");
	if(mysqli_num_rows($query)=='0'){return $sjo_number;}else{$b=$ch;$b++; return unique_sjo(strtok($sjo_number,"_")."_".$ch,$b);}
}*/
function material_request_adv_edit(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,trim($_REQUEST['token']));
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$mrf_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['mrf_alias']));
		$mrf_status=mysqli_real_escape_string($mr_con,trim($_REQUEST['mrf_status']));
		$remark=mysqli_real_escape_string($mr_con,trim($_REQUEST['remark']));
		$partialEdit = true;
		if($mrf_status=="1" || $mrf_status=="2" || $mrf_status=="7" || $mrf_status=="9" || $mrf_status=="10") {
			$partialEdit = false;
		}
			if(isset($_REQUEST['from_wh']) && !empty(trim($_REQUEST['from_wh'])))$from_wh = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['from_wh'])));else $from_wh="0";
			if(isset($_REQUEST['to_wh']) && !empty(trim($_REQUEST['to_wh'])))$to_wh = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['to_wh'])));else $to_wh="0";
			if(isset($_REQUEST['sjo_number']) && !empty(trim($_REQUEST['sjo_number'])))$sjo_number = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['sjo_number'])));else $sjo_number=0;
			if(isset($_REQUEST['sjo_date']) && !empty(trim($_REQUEST['sjo_date'])))$sjo_date=dateFormat(strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['sjo_date']))),'y');else $sjo_date=0;
			if(isset($_REQUEST['ticketID']) && !empty(trim($_REQUEST['ticketID'])))$ticket_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['ticketID'])));else $ticket_alias=0;
			if(isset($_REQUEST['cust_alias']) && !empty(trim($_REQUEST['cust_alias'])))$customer_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['cust_alias'])));else $customer_alias=0;
			if(isset($_REQUEST['sinvoice_number']) && !empty(trim($_REQUEST['sinvoice_number'])))$sinvoice_number=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['sinvoice_number'])));else $sinvoice_number=0;
			if(isset($_REQUEST['sinvoice_date']) && !empty(trim($_REQUEST['sinvoice_date'])))$sinvoice_date=dateFormat(strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['sinvoice_date']))),'y');else $sinvoice_date=0;
			if(isset($_REQUEST['po_number']) && !empty(trim($_REQUEST['po_number'])))$po_number=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['po_number'])));else $po_number=0;
			if(isset($_REQUEST['ccname']) && !empty(trim($_REQUEST['ccname'])))$ccname=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['ccname'])));else $ccname=0;
			if(isset($_REQUEST['ccnumber']) && !empty(trim($_REQUEST['ccnumber'])))$ccnumber=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['ccnumber'])));else $ccnumber=0;
			if(isset($_REQUEST['customerAdd']) && !empty(trim($_REQUEST['customerAdd'])))$customerAdd=mysqli_real_escape_string($mr_con,trim($_REQUEST['customerAdd']));else $customerAdd=0;
			if(isset($_REQUEST['cell_type']))$a0=count(array_filter($_REQUEST['cell_type']));else $a0=0;
			if(isset($_REQUEST['item_type']))$a1=count(array_filter($_REQUEST['item_type']));else $a1=0;
			if(isset($_REQUEST['item_description']))$a2=count(array_filter($_REQUEST['item_description']));else $a2=0;
			if(isset($_REQUEST['quantity']))$a3=count(array_filter($_REQUEST['quantity']));else $a3=0;
			
			if(isset($_REQUEST['transit_damaged']) && trim($_REQUEST['transit_damaged'])!="")$transit_damaged=mysqli_real_escape_string($mr_con,trim($_REQUEST['transit_damaged']));else $transit_damaged="";
			if(isset($_REQUEST['amount_range']) && !empty(trim($_REQUEST['amount_range'])))$amount_range=mysqli_real_escape_string($mr_con,trim($_REQUEST['amount_range']));else $amount_range=0;
			
			if($a1 > '0')$item_type = $_REQUEST['item_type'];else $item_type = '';
			if($a0 > '0' && $a1 == $a0)$cell_type = $_REQUEST['cell_type'];else $cell_type = '';
			if($a2 > '0' && $a1 == $a2)$item_description = $_REQUEST['item_description'];else $item_description = '';
			if($a3 > '0' && $a2 == $a3)$quantity = $_REQUEST['quantity'];else $quantity = '';
			
			if(isset($_REQUEST['id'])){$id_count=count(array_filter($_REQUEST['id']));$id=$_REQUEST['id'];}
			if(isset($_REQUEST['remarks'])){$remarks_count=count(array_filter($_REQUEST['remarks']));$remarks=$_REQUEST['remarks'];}
			if(isset($_REQUEST['remarked_on'])){$remarked_on_count=count(array_filter($_REQUEST['remarked_on']));$remarked_on=$_REQUEST['remarked_on'];}
			
			$to_wh_factory=alias('1','ec_warehouse','wh_type','wh_alias');
			if(empty($remark))$res="Please Enter Remarks";
			elseif(empty($from_wh))$res="Select From Location";
			elseif(empty($to_wh))$res="Select To Location";
			elseif($from_wh == $to_wh_factory)$res="Factory can't request stock";
			elseif($from_wh==$to_wh)$res="From and To Locations are can't be same";
			elseif(empty($id_count) || $id_count != $remarks_count || $id_count != $remarked_on_count)$res="Please provide all the remarks details";
			else{
				// if($to_wh_factory==$to_wh){
					if(empty($sjo_number))$res="Please Enter SJO Number";
					elseif(empty($ticket_alias) || $ticket_alias=='0')$res="Select Ticket Number";
					elseif($ticket_alias=='2609' && empty($customer_alias))$res="Select Customer";
					elseif(empty($sjo_date) || $sjo_date=='0')$res="Select SJO Date";
					elseif(empty($sinvoice_number) || $sinvoice_number=='0')$res="Enter Sales Invoice Number";
					elseif(empty($sinvoice_date) || $sinvoice_date=='0')$res="Enter Sales Invoice Date";
					elseif(empty($po_number) || $po_number=='0')$res="Enter PO Number";
					elseif(empty($ccname) || $ccname=='0')$res="Enter Customer Name";
					elseif(empty($ccnumber) || $ccnumber=='0')$res="Enter Customer Number";
					elseif(empty($customerAdd) || $customerAdd=='0')$res="Enter Customer Address";
					elseif($transit_damaged==""){$resCode='4';$resMsg="Select Transit Damaged";}
					elseif($transit_damaged=="1" && empty($amount_range) && !is_nan($amount_range)){$res="Provide valid amount range";}
					elseif(!$partialEdit && $item_type=='')$res="Please Select Item Type";
					elseif(!$partialEdit && $item_description=='')$res="Please Select Item Description";
					elseif(!$partialEdit && $cell_type=='')$res="Please Select Cell Type";
					elseif(!$partialEdit && $quantity=='')$res="Please Enter Quantity";
					else{ $ctp=count(array_unique(array_map(function($x) use ($cell_type) { return $cell_type[$x]; }, array_keys($item_type, "1"))));
						if($ctp<=1){
							$aa=$bb=$chc=array();
							for($i=0;$i<count($item_description);$i++){
								$te=trim($item_description[$i]).trim($cell_type[$i]);
								if(!in_array($te,$aa)){$aa[]=$te;$chc[]='1';}
								else{$bb[]=($item_type[$i]=='1' ? alias($item_description[$i],'ec_product','product_alias','product_description'):alias($item_description[$i],'ec_accessories','accessories_alias','accessory_description'));$chc[]='0';}
							}
							if($ticket_alias!='2609' && !empty($ticket_alias))$customer_alias=alias(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','customer_alias');
							if(in_array('0',$chc)){$res=implode(",",array_unique($bb))." Duplication Items selected";}
							else{
								if($_FILES['sjo_file']['size']>0 && $_FILES['sjo_file']['size']<5242880){
									$ext = pathinfo($_FILES['sjo_file']['name'], PATHINFO_EXTENSION);
									if(strtoupper($ext)=="PDF"){
										$fileName=$emp_alias.$mrf_alias.generateRandomString()."MRSJ.".$ext;
										if(move_uploaded_file($_FILES["sjo_file"]["tmp_name"],"../../attachments/sjoFiles/".$fileName)){
											$profileimg="attachments/sjoFiles/".$fileName;
											$condition="sjo_file='$profileimg',";
										}else $res="File Uploading Error! Try Again";
									}else $res="Kindly Upload Only .PDF format";
								}
								if(!isset($res)){
									$check=TRUE;
									if(!$partialEdit) {
									$del=mysqli_query($mr_con,"DELETE FROM ec_request_items WHERE mrf_alias='$mrf_alias' AND flag='0'");
									if($del){
										$material_value=0;
										for($i=0;$i<count($item_type);$i++){
											if(!empty($item_type[$i])){
												$request_items_alias = aliasCheck(generateRandomString(),'ec_request_items','request_items_alias');
												$item_type[$i] = $_REQUEST['item_type'][$i];
												$item_description[$i] = $_REQUEST['item_description'][$i];
												$cell_type[$i] = $_REQUEST['cell_type'][$i];
												$quantity[$i] = $_REQUEST['quantity'][$i];
												$sql = mysqli_query($mr_con,"INSERT INTO ec_request_items(mrf_alias,item_type,cell_type,item_description,quantity,left_quanty,request_items_alias)VALUES('$mrf_alias','$item_type[$i]','$cell_type[$i]','$item_description[$i]','$quantity[$i]','$quantity[$i]','$request_items_alias')");
												if($item_type[$i]=='1' && $cell_type[$i]=='1'){ $material_value+=round(($quantity[$i])*(alias($item_description[$i],'ec_product','product_alias','price')),2);}
												if($item_type[$i]=='2'){ $material_value+=round(($quantity[$i])*(alias($item_description[$i],'ec_accessories','accessories_alias','price')),2);}
											}
										}
									}
									}
									$q=mysqli_query($mr_con,"SELECT sjo_number FROM ec_material_request WHERE mrf_alias='$mrf_alias' AND flag=0");
									if(mysqli_num_rows($q)>0){
										$mrf_row=mysqli_fetch_array($q);
										$addQuery = "";
										if(!$partialEdit) {
											$addQuery = ",from_wh='$from_wh',to_wh='$to_wh',ticket_alias='$ticket_alias',customer_alias='$customer_alias',material_value='$material_value'";
										}
										$query = "UPDATE ec_material_request SET last_updated = now(), $condition sjo_number='$sjo_number',sjo_date='$sjo_date',sales_invoice_no='$sinvoice_number',sales_invoice_date='$sinvoice_date',sales_po_no='$po_number',contact_person='$ccname',customer_phone='$ccnumber',customer_address='$customerAdd',transit_damaged='$transit_damaged', amount_range='$amount_range' $addQuery WHERE mrf_alias='$mrf_alias' AND flag=0";
										$sql = mysqli_query($mr_con, $query);
										if($sql){ 
											$sjo_number = $mrf_row['sjo_number'];
											for($i=0;$i<$id_count;$i++)$sql2 = mysqli_query($mr_con,"UPDATE ec_remarks SET remarks='$remarks[$i]',remarked_on='".dateTimeFormat($remarked_on[$i],'y')."' WHERE item_alias='$mrf_alias' AND module='MR' AND id='$id[$i]' AND flag='0'");
											$action="Material Request advance edit was done against SJO Number $sjo_number.";
											user_history($emp_alias,$action,$_REQUEST['ip_addr'], $remark);
											$resCode='0';$resMsg='Successful!'.$dd;
										} else {
											$res='Error in Updating!';
										}
									}else{$res='Action Not Succesful! Try again Later';}
								}
							}
						}else $res="Please Select Unique Cell Type (Either NEW OR REVIVED)";
					}
				// }else $res="Wrong Request";
			}
		
		if(!empty($res)) {
			$resCode='4';$resMsg=$res;
		}
	}elseif($rex=='1'){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';}
	if(isset($res) && !empty($res)){$resCode='4';$resMsg=$res;}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function material_request_edit(){
	global $mr_con;
	$emp_alias = $_REQUEST['emp_alias']; $token = $_REQUEST['token'];
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$mrf_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['mrf_alias']));
		$remarks=mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks']));		
		if(empty($remarks))$res="Enter Remarks";
		else{
			$mrf_status=mysqli_real_escape_string($mr_con,trim($_REQUEST['mrf_status']));
			if(admin_privilege($emp_alias) || alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias')=='WIMYJFDJPT'){
				if($mrf_status=="1" || $mrf_status=="7" || $mrf_status=="10" || $mrf_status=="0" || $mrf_status=="2" || $mrf_status=="9"){
					$q=mysqli_query($mr_con,"SELECT sjo_number FROM ec_material_request WHERE mrf_alias='$mrf_alias' AND flag=0");
					if(mysqli_num_rows($q)>0){
						$mrf_row=mysqli_fetch_array($q);
						$sql=mysqli_query($mr_con,"UPDATE ec_material_request SET last_updated = now(), status='5' WHERE mrf_alias='$mrf_alias' AND flag=0");
						if($sql){ 
							$sjo_number = $mrf_row['sjo_number'];
							$req_itms_sql=mysqli_query($mr_con,"UPDATE ec_request_items SET left_quanty='0' WHERE mrf_alias='$mrf_alias' AND flag=0");
							$remark_alias = aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
							$sql2 = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','MR','19','$mrf_alias','$emp_alias','$remark_alias')");
							$action="Dear Team, the request is Short Closed against SJO Number - $sjo_number.";
							curlxing(localURL()."services/inventory/mails/mrsmails?a=".$mrf_alias);
							inventory_notification($mrf_alias,$action,'3');
							user_history($emp_alias,$action,$_REQUEST['ip_addr']);
							$resCode='0';$resMsg='Successful!';
						}else $res='Error in Updating!';
					}else $res='Action Not Succesful! Try again Later';
				}else $res='Action Not Succesful! Try again Later';
			}else{ 
				$check=FALSE;
				if($mrf_status=="1" || $mrf_status=="7"){ // Dynamic Level
					$approval=mysqli_real_escape_string($mr_con,trim($_REQUEST['approval']));
					if(($approval=='1' || $approval=='2' || $approval=='3') && !empty($mrf_alias)){
						$list=next_dynamic($mrf_alias,'E','L');
						if(!empty($list)){
							list($next,$emp_ali)=explode("_",$list);
							if($approval=='1') { //Approve
								$condition=" status = '".($next=='L' ? '2':'1')."' ";
								$action = "Dynamic Approve:".alias($emp_alias,'ec_employee_master','employee_alias','name')." Approve";
								$bucket="21";
							} elseif($approval=='2'){ //Reject
								$condition=" status = '10' ";
								$action = "Dynamic Reject:".alias($emp_alias,'ec_employee_master','employee_alias','name')." Reject";
								$bucket="22";
							} else {  //Hold
								$condition=" status = '7' ";
								$action = "Dynamic Hold:".alias($emp_alias,'ec_employee_master','employee_alias','name')." Hold"; 
								$bucket="20";
							}
							if($approval=='1' || $approval=='2'){
								if(strpos($emp_ali,",")!==false)$cooo="IN('".str_replace(",","','",$emp_ali)."')";else $cooo="='$emp_ali'";
								$sql = mysqli_query($mr_con,"UPDATE ec_dynamic_verification SET flag='1' WHERE mrf_alias='$mrf_alias' AND employee_alias $cooo AND flag=0");
							}
						} else {
							$condition=" status = '2' ";
							$action = "Dynamic Approve: Approve"; 
							$bucket="21"; 
						}
						$check=TRUE;
					}else $res = 'No Request Found to Approve';
				}elseif($mrf_status=="0" || $mrf_status=="2" || $mrf_status=="9"){ //PPC
					if(isset($_REQUEST['item_code']) && count($_REQUEST['item_code']))$item_code=$_REQUEST['item_code'];else $item_code=0;
					if(isset($_REQUEST['cell_type']) && count($_REQUEST['cell_type']))$cell_type=$_REQUEST['cell_type'];else $cell_type=0;
					if(isset($_REQUEST['clr_qty']) && count($_REQUEST['clr_qty']))$clr_qty=$_REQUEST['clr_qty'];else $clr_qty=0;
					if($item_code=='0')$res="Error 1";
					elseif($cell_type=='0')$res="Error 2";
					elseif($clr_qty=='0')$res="Error 3";
					else{$ppc=($mrf_status=="9" ? 'r':'c');
						for($k=0;$k<count($item_code);$k++){
							if($mrf_status=="0")$q1=mysqli_query($mr_con,"UPDATE ec_request_items SET tappr_quanty=(tappr_quanty+$clr_qty[$k]),cappr_quanty='$clr_qty[$k]' WHERE cell_type='$cell_type[$k]' AND item_description='$item_code[$k]' AND mrf_alias='$mrf_alias' AND flag=0");
							else $q1=mysqli_query($mr_con,"UPDATE ec_request_items SET tappr_quanty=(tappr_quanty+($clr_qty[$k]-cappr_quanty)),cappr_quanty='$clr_qty[$k]' WHERE cell_type='$cell_type[$k]' AND item_description='$item_code[$k]' AND mrf_alias='$mrf_alias' AND flag=0");
						}
						$readiness_date=dateFormat(mysqli_real_escape_string($mr_con,trim($_REQUEST['readiness_date'])),'y');
						if(empty($readiness_date) || $readiness_date=="NA"){$res = 'Please Choose Material Readiness Date';}
						else{$condition=" status = '9', ppc_mail_log='0', readiness_date='$readiness_date'";$bucket="23";$check=TRUE;}
						if($mrf_status=="9")$bucket="24";
					}
				}elseif($mrf_status=="10"){ $bucket="17";// Dynamic Level rejected
					if(isset($_REQUEST['from_wh']) && !empty(trim($_REQUEST['from_wh'])))$from_wh = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['from_wh'])));else $from_wh="0";
					if(isset($_REQUEST['to_wh']) && !empty(trim($_REQUEST['to_wh'])))$to_wh = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['to_wh'])));else $to_wh="0";
					if(isset($_REQUEST['sjo_number']) && !empty(trim($_REQUEST['sjo_number'])))$sjo_number = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['sjo_number'])));else $sjo_number=0;
					if(isset($_REQUEST['sjo_date']) && !empty(trim($_REQUEST['sjo_date'])))$sjo_date=dateFormat(strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['sjo_date']))),'y');else $sjo_date=0;
					if(isset($_REQUEST['ticketID']) && !empty(trim($_REQUEST['ticketID'])))$ticket_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['ticketID'])));else $ticket_alias=0;
					if(isset($_REQUEST['cust_alias']) && !empty(trim($_REQUEST['cust_alias'])))$customer_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['cust_alias'])));else $customer_alias=0;
					if(isset($_REQUEST['sinvoice_number']) && !empty(trim($_REQUEST['sinvoice_number'])))$sinvoice_number=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['sinvoice_number'])));else $sinvoice_number=0;
					if(isset($_REQUEST['sinvoice_date']) && !empty(trim($_REQUEST['sinvoice_date'])))$sinvoice_date=dateFormat(strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['sinvoice_date']))),'y');else $sinvoice_date=0;
					if(isset($_REQUEST['po_number']) && !empty(trim($_REQUEST['po_number'])))$po_number=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['po_number'])));else $po_number=0;
					if(isset($_REQUEST['ccname']) && !empty(trim($_REQUEST['ccname'])))$ccname=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['ccname'])));else $ccname=0;
					if(isset($_REQUEST['ccnumber']) && !empty(trim($_REQUEST['ccnumber'])))$ccnumber=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['ccnumber'])));else $ccnumber=0;
					if(isset($_REQUEST['customerAdd']) && !empty(trim($_REQUEST['customerAdd'])))$customerAdd=mysqli_real_escape_string($mr_con,trim($_REQUEST['customerAdd']));else $customerAdd=0;
					if(isset($_REQUEST['cell_type']))$a0=count(array_filter($_REQUEST['cell_type']));else $a0=0;
					if(isset($_REQUEST['item_type']))$a1=count(array_filter($_REQUEST['item_type']));else $a1=0;
					if(isset($_REQUEST['item_description']))$a2=count(array_filter($_REQUEST['item_description']));else $a2=0;
					if(isset($_REQUEST['quantity']))$a3=count(array_filter($_REQUEST['quantity']));else $a3=0;
					if($a1 > '0')$item_type = $_REQUEST['item_type'];else $item_type = '';
					if($a0 > '0' && $a1 == $a0)$cell_type = $_REQUEST['cell_type'];else $cell_type = '';
					if($a2 > '0' && $a1 == $a2)$item_description = $_REQUEST['item_description'];else $item_description = '';
					if($a3 > '0' && $a2 == $a3)$quantity = $_REQUEST['quantity'];else $quantity = '';
					if(empty($from_wh))$res="Select From Location";
					elseif(empty($to_wh))$res="Select To Location";
					else{
						$to_wh_factory=alias('1','ec_warehouse','wh_type','wh_alias');
						if($to_wh_factory==$to_wh){
							if(empty($sjo_number))$res="Please Enter SJO Number";
							elseif(empty($ticket_alias) || $ticket_alias=='0')$res="Select Ticket Number";
							elseif($ticket_alias=='2609' && empty($customer_alias))$res="Select Customer";
							elseif(empty($sjo_date) || $sjo_date=='0')$res="Select SJO Date";
							elseif(empty($sinvoice_number) || $sinvoice_number=='0')$res="Enter Sales Invoice Number";
							elseif(empty($sinvoice_date) || $sinvoice_date=='0')$res="Enter Sales Invoice Date";
							elseif(empty($po_number) || $po_number=='0')$res="Enter PO Number";
							elseif(empty($ccname) || $ccname=='0')$res="Enter Customer Name";
							elseif(empty($ccnumber) || $ccnumber=='0')$res="Enter Customer Number";
							elseif(empty($customerAdd) || $customerAdd=='0')$res="Enter Customer Address";
							elseif($item_type=='')$res="Please Select Item Type";
							elseif($item_description=='')$res="Please Select Item Description";
							elseif($cell_type=='')$res="Please Select Cell Type";
							elseif($quantity=='')$res="Please Enter Quantity";
							else{ $ctp=count(array_unique(array_map(function($x) use ($cell_type) { return $cell_type[$x]; }, array_keys($item_type, "1"))));
								if($ctp<=1){
									$aa=$bb=$chc=array();
									for($i=0;$i<count($item_description);$i++){
										$te=trim($item_description[$i]).trim($cell_type[$i]);
										if(!in_array($te,$aa)){$aa[]=$te;$chc[]='1';}
										else{$bb[]=($item_type[$i]=='1' ? alias($item_description[$i],'ec_product','product_alias','product_description'):alias($item_description[$i],'ec_accessories','accessories_alias','accessory_description'));$chc[]='0';}
									}
									if($ticket_alias!='2609' && !empty($ticket_alias))$customer_alias=alias(alias($ticket_alias,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','customer_alias');
									if(in_array('0',$chc)){$res=implode(",",array_unique($bb))." Duplication Items selected";}
									else{
										$levell=(empty(next_dynamic($mrf_alias,'E')) ? '2' : '1');
										if($_FILES['sjo_file']['size']>0 && $_FILES['sjo_file']['size']<5242880){
											$ext = pathinfo($_FILES['sjo_file']['name'], PATHINFO_EXTENSION);
											if(strtoupper($ext)=="PDF"){
												$fileName=$emp_alias.$mrf_alias.generateRandomString()."MRSJ.".$ext;
												if(move_uploaded_file($_FILES["sjo_file"]["tmp_name"],"../../attachments/sjoFiles/".$fileName)){
													$profileimg="attachments/sjoFiles/".$fileName;
													$condition="sjo_file='$profileimg',";
												}else $res="File Uploading Error! Try Again";
											}else $res="Kindly Upload Only .PDF format";
										}
										if(!isset($res)){ $check=TRUE;
											$del=mysqli_query($mr_con,"DELETE FROM ec_request_items WHERE mrf_alias='$mrf_alias' AND flag='0'");
											if($del){ $bucket="17";
												for($i=0;$i<count($item_type);$i++){
													if(!empty($item_type[$i])){
														$request_items_alias = aliasCheck(generateRandomString(),'ec_request_items','request_items_alias');
														$item_type[$i] = $_REQUEST['item_type'][$i];
														$item_description[$i] = $_REQUEST['item_description'][$i];
														$cell_type[$i] = $_REQUEST['cell_type'][$i];
														$quantity[$i] = $_REQUEST['quantity'][$i];
														$sql = mysqli_query($mr_con,"INSERT INTO ec_request_items(mrf_alias,item_type,cell_type,item_description,quantity,left_quanty,request_items_alias)VALUES('$mrf_alias','$item_type[$i]','$cell_type[$i]','$item_description[$i]','$quantity[$i]','$quantity[$i]','$request_items_alias')");
														if($item_type[$i]=='1'){
															if($cell_type[$i]=='1')$cl_price = round(($quantity[$i])*(alias($item_description[$i],'ec_product','product_alias','price')),2);else $cl_price=0;
															$material_value+=$cl_price;
														}else{ $material_value+=round(($quantity[$i])*(alias($item_description[$i],'ec_accessories','accessories_alias','price')),2);}
													}
												}
											}
											$condition.="from_wh='$from_wh',to_wh='$to_wh',material_value='$material_value',mrf_alias='$mrf_alias',status='$levell',sjo_number='$sjo_number',sjo_date='$sjo_date',ticket_alias='$ticket_alias',customer_alias='$customer_alias',sales_invoice_no='$sinvoice_number',sales_invoice_date='$sinvoice_date',sales_po_no='$po_number',contact_person='$ccname',customer_phone='$ccnumber',customer_address='$customerAdd'";
										}
									}
								}else $res="Please Select Unique Cell Type (Either NEW OR REVIVED)";
							}
						}else $res="Wrong Request";
					}
				}
				if($check){
					$q=mysqli_query($mr_con,"SELECT sjo_number FROM ec_material_request WHERE mrf_alias='$mrf_alias' AND flag=0");
					if(mysqli_num_rows($q)>0){
						$mrf_row=mysqli_fetch_array($q);
						$sql=mysqli_query($mr_con,"UPDATE ec_material_request SET last_updated = now(), $condition WHERE mrf_alias='$mrf_alias' AND flag=0");
						if($sql){ $sjo_number = $mrf_row['sjo_number'];
							$remark_alias = ($bucket=='17' || $bucket=='23' || $bucket=='24' ? aliasCheck(generateRandomString(),'ec_remarks','remark_alias') : alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias'));
							$sql2 = mysqli_query($mr_con,"INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','MR','$bucket','$mrf_alias','$emp_alias','$remark_alias')");
							if($mrf_status=="1" || $mrf_status=="7" || $mrf_status=="10"){
								if($mrf_status!="10"){
									$privilege_alias=alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias');
									$arrr=array("ZHS","NHS","HO","PPC");
									if($privilege_alias=="NCPAT7QPTK")array_push($arrr,"TS");
									$sql4=mysqli_query($mr_con,"SELECT id FROM ec_request_items WHERE mrf_alias='$mrf_alias' AND item_type='1' AND cell_type='2' AND flag='0'");
									$fam_msg1="Dear Team, ".alias($privilege_alias,'ec_dynamic_levels','privilege_alias','level_name')." Action Against the SJO Number $sjo_number is ".($bucket=="20" ? "Hold" : ($bucket=="21" ? "Approved":"Reject")).($bucket!="21" ? "": (mysqli_num_rows($sql4)=='0' && $privilege_alias=="NCPAT7QPTK" ? ", This request is Processed for further Approval." : ", Kindly Initiate the further Process."));
									/*
									foreach(sms_contacts($mrf_alias,$arrr) as $phnum1)messageSent($phnum1,$fam_msg1);
									*/
									$state_alais = alias($from_wh,'ec_warehouse','wh_alias','state_alias');
									ecSendSms('approval1_approved_rejected', $state_alias, "", $fam_msg1);
								}
								if(empty(next_dynamic($mrf_alias,'E'))){
									list($ticket_id,$req_items)=explode("_@",request_desc_sms($mrf_alias,"CUST"));
									$fam_msg2="Dear Customer, Material request against $ticket_id, of $req_items was processed, will update Material readiness status shortly.";
									/*
									foreach(sms_contacts($mrf_alias,array("CUST","HO")) as $phnum2)messageSent($phnum2,$fam_msg2);	
									*/
									$state_alais = alias($from_wh,'ec_warehouse','wh_alias','state_alias');
									$custNo = alias($mrf_alias,'ec_material_request','mrf_alias','customer_phone');
									ecSendSms('mr_customer_communication', $state_alias, $custNo, $fam_msg2);
								}
								curlxing(localURL()."services/inventory/mails/mrdmails?a=".$mrf_alias."&bucket=".$bucket);
								$action=$action." the requested Stock against SJO Number - ".$sjo_number;
							}else if($mrf_status=="0" || $mrf_status=="2" || $mrf_status=="9"){
								if($mrf_status=="2"){
									$fam_msg="Dear Team, PPC dept has updated the Planned date to ".dateFormat($readiness_date,'d')." of Dispatch against SJO Number $sjo_number, Kindly add the cell Serial Numbers in Portal";
									/*
									foreach(sms_contacts($mrf_alias,array("ZHS","NHS","HO","QUALITY")) as $phnum)messageSent($phnum,$fam_msg);
									*/
									$state_alais = alias($from_wh,'ec_warehouse','wh_alias','state_alias');
									ecSendSms('mr_ppc_updated_planneddate', $state_alias, "", $fam_msg);
								}
								curlxing(localURL()."services/inventory/mails/mpmails?a=".$mrf_alias."&b=".$ppc);
								$action="PPC declared the Material Readiness Date on ".dateFormat($readiness_date,'d')." against SJO Number $sjo_number to add the stocks.";
							}
							inventory_notification($mrf_alias,$action,'3');
							user_history($emp_alias,$action,$_REQUEST['ip_addr']);
							$resCode='0';$resMsg='Successful!';
						}else $res='Error in Updating!';
					}else{$res='Action Not Succesful! Try again Later';}
				}else{$resCode='4';$resMsg=$res;}
			}
		}
	}elseif($rex=='1'){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';}
	if(isset($res) && !empty($res)){$resCode='4';$resMsg=$res;}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function material_request_single_view(){ 
	global $mr_con;
	$emp_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$token=mysqli_real_escape_string($mr_con,trim($_REQUEST['token']));
	$alias= mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$sql = mysqli_query($mr_con,"SELECT transit_damaged,amount_range,mrf_number,readiness_date,sjo_file,sjo_number,sjo_date,sales_invoice_no,sales_invoice_date,sales_po_no,contact_person,customer_address,customer_phone, from_wh, to_wh, date_of_request, material_value, ticket_alias, customer_alias, status, mrf_alias FROM ec_material_request WHERE mrf_alias ='$alias' AND flag=0");
		$editGrantable = grantable('ADV EDIT','MATERIAL REQUEST',$emp_alias);
		if(mysqli_num_rows($sql)){
			$admin_privilege = admin_privilege($emp_alias);
			while($row=mysqli_fetch_array($sql)){
				$result['mrf_number']=$row['mrf_number'];
				$result['from_wh_ali']=$row['from_wh'];
				$result['to_wh_ali']=$row['to_wh'];
				$result['from_wh']=alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code');
				$result['to_wh']=alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code');
				$result['date_of_request']=dateFormat($row['date_of_request'],'d');
				$result['material_value']=$row['material_value'];
				$result['status']=$row['status'];
				$result['status_name']=fam_lvl_nm_clr($row['status'],"name",$row['mrf_alias']);
				$result['status_color']=fam_lvl_nm_clr($row['status'],"color",$row['mrf_alias'],$row['readiness_date']);
				$result['mrf_alias']=$row['mrf_alias'];
				$result['ticket_ali']=$row['ticket_alias'];
				$customer_alias = $row['customer_alias'];
				$result['customer_alias']=$customer_alias;
				$result['ticket_id']=($row['ticket_alias']=='2609' ? "Customer Buffer Stock" : alias_flag_none($row['ticket_alias'],'ec_tickets','ticket_alias','ticket_id'));
				$result['site_name']=($row['ticket_alias']=='2609' ? "-" : alias_flag_none(alias_flag_none($row['ticket_alias'],'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','site_name'));
				$customer_name=alias($customer_alias,'ec_customer','customer_alias','customer_name');
				$result['customer']=(!empty($customer_name) ? $customer_name : "NA");
				$result['sjo_number']=$row['sjo_number'];
				$result['sjo_date']=dateFormat($row['sjo_date'],'d');
				$result['sinv']=$row['sales_invoice_no'];
				$result['sind']=dateFormat($row['sales_invoice_date'],'d');
				$result['readiness_date']=dateFormat($row['readiness_date'],'d');
				$result['spon']=$row['sales_po_no'];
				$result['ccname']=$row['contact_person'];
				$result['ccadds']=$row['customer_address'];
				$result['ccnumber']=$row['customer_phone'];
				$result['sjo_file']=$row['sjo_file'];
				
				$result['transit_damaged']=$row['transit_damaged'];
				$result['amount_range']=$row['amount_range'];
				$result['transit_damaged_val']=transit_damaged($row['transit_damaged']);
				$result['amount_range_val']=amount_range($row['amount_range']);
				
				$result['road_permit']= alias($row['from_wh'],'ec_warehouse','wh_alias','road_permit');
				$f_wh=alias('1','ec_warehouse','wh_type','wh_alias');
				$sql0 = mysqli_query($mr_con,"SELECT transport,docket,dispatch_date,alias FROM ec_material_outward WHERE sjo_number ='$alias' AND from_wh='$f_wh' AND flag='0'");
				$disp_length=mysqli_num_rows($sql0);
				if($disp_length){
					$i=0;while($row0=mysqli_fetch_array($sql0)){
						$result['disp'][$i]['transport']=$row0['transport'];
						$result['disp'][$i]['docket']=$row0['docket'];
						$result['disp'][$i]['dispatch_date']=dateFormat($row0['dispatch_date'],'d');
						$sql01 = mysqli_query($mr_con,"SELECT remarks FROM ec_remarks WHERE item_alias ='".$row0['alias']."' AND module='MO' AND flag='0'");
						if(mysqli_num_rows($sql01)){ $row01=mysqli_fetch_array($sql01);
							$result['disp'][$i]['out_rem']=$row01['remarks'];
						}else{$result['disp'][$i]['out_rem']='NA';} $i++;
					}
				}$result['disp_length']=$disp_length;
				$sql1 = mysqli_query($mr_con,"SELECT * FROM ec_request_items WHERE mrf_alias ='$alias' AND flag=0");
				if(mysqli_num_rows($sql1)){
					$rquantity=$lquantity=$taquanty=0;
					$i=0;while($row1=mysqli_fetch_array($sql1)){
						if($row['status']=='10' || $editGrantable){
							$result['itemx'][$i]['itemtypeCode']=$row1['item_type'];
							$result['itemx'][$i]['itemalias']=$row1['item_description'];
							$result['itemx'][$i]['cell_type']=$row1['cell_type'];
							$result['itemx'][$i]['itemtype']=getitemtype($row1['item_type']);
							$result['itemx'][$i]['itemdesc']=getitemname($row1['item_type'],$row1['item_description']);
							$result['itemx'][$i]['quanty']=$row1['quantity'];
						}						
						$result['request_items'][$i]['item_type']=$row1['item_type'];
						$result['request_items'][$i]['cell_type']=$row1['cell_type'];
						$result['request_items'][$i]['item_code']=$row1['item_description'];
						$result['request_items'][$i]['item_description']=getitemname($result['request_items'][$i]['item_type'],$row1['item_description']);
						$rquantity+=$result['request_items'][$i]['quantity']=$row1['quantity'];
						$taquanty+=$result['request_items'][$i]['tappr_quanty']=$row1['tappr_quanty'];
						$taquanty+=$result['request_items'][$i]['cappr_quanty']=$row1['cappr_quanty'];
						$lquantity+=$result['request_items'][$i]['left_quanty']=$row1['left_quanty'];
						$result['request_items'][$i]['sentquantity']=($row['status']=='5' ? '0' : ($result['request_items'][$i]['quantity']-$result['request_items'][$i]['left_quanty']));
						//$result['request_items'][$i]['quantity_from']=quantity_cells($row1['item_description'],$row['from_wh']);
						//$result['request_items'][$i]['quantity_to']=quantity_cells($row1['item_description'],$row['to_wh']);
					$i++;}
					$result['rQuantity']=$rquantity;
					$result['taQuantity']=$taquanty;
					$result['lQuantity']=$lquantity;
					$result['sQuantity']=$rquantity-$lquantity;
				}else{$result['request_length'] = '0';}
				$result['admin_priv']=($emp_alias=='ADMIN' ? TRUE : FALSE);
				
				//TS Details for MD view
				if($row['ticket_alias']!='2609' && ($emp_alias=='ADMIN' || $admin_privilege || alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias')=='NCPAT7QPTK')){
					$sqlTs = mysqli_query($mr_con,"SELECT * FROM ec_ths_approved WHERE ticket_alias='".$row['ticket_alias']."' AND deposition<>'' AND flag=0");
					$ts_count=mysqli_num_rows($sqlTs);
					if($ts_count=='0'){
						$lticket_id = strtok(alias($row['ticket_alias'],'ec_tickets','ticket_alias','ticket_id'),"|");
						$sqlTT = mysqli_query($mr_con,"SELECT ticket_alias FROM ec_tickets WHERE ticket_id LIKE '%".$lticket_id."%' AND ticket_id NOT LIKE '%".$lticket_id."-%' AND flag=0 ORDER BY id DESC LIMIT 1,1");
						$rowTT = mysqli_fetch_array($sqlTT);
						$sqlTs = mysqli_query($mr_con,"SELECT * FROM ec_ths_approved WHERE ticket_alias='".$rowTT['ticket_alias']."' AND deposition<>'' AND flag=0");
						$ts_count=mysqli_num_rows($sqlTs);
					}
					if($ts_count){
						$rowTs = mysqli_fetch_array($sqlTs);
						$sql3=mysqli_query($mr_con,"SELECT GROUP_CONCAT(name SEPARATOR ', ') AS emp_name FROM ec_employee_master WHERE employee_alias IN ('".str_replace("|","','",$rowTs['persons_notified'])."') AND flag='0'");
						$emp_row=mysqli_fetch_array($sql3);
						$result['line_number']=$rowTs['line_number'];
						$result['shift']=alias($rowTs['shift'],'ec_shift','shift_alias','shift_name');
						$result['date_of_assembly']=($rowTs['date_of_assembly']=="" || $rowTs['date_of_assembly']=="0000-00-00" ? "NA" : date("d-m-Y", strtotime(mysqli_real_escape_string($mr_con,$rowTs['date_of_assembly']))));
						$result['date_of_jar_form']=($rowTs['date_of_jar_form']=="" || $rowTs['date_of_jar_form']=="0000-00-00" ? "NA" : date("d-m-Y", strtotime(mysqli_real_escape_string($mr_con,$rowTs['date_of_jar_form']))));
						$result['corect_act_Plan']=$rowTs['corect_act_Plan'];
						$result['deposition']=$rowTs['deposition'];
						$result['persons_notified']=$emp_row['emp_name'];
						$sql4=mysqli_query($mr_con,"SELECT * FROM ec_ths_faulty_ocv WHERE ths_appr_alias='".$rowTs['alias']."' AND flag=0");
						if(mysqli_num_rows($sql4)){
							$j=0;while($row4 = mysqli_fetch_array($sql4)){
								$result['ts_approved'][$j]['faulty_cell_num']=$row4['faulty_cell_num'];
								$result['ts_approved'][$j]['ocv']=$row4['ocv'];
								$result['ts_approved'][$j]['tenth_hour']=$row4['tenth_hour'];
							$j++;}
						}$result['ts_approved_length']=$ts_count;
					}else $result['ts_approved_length']='0';
				}else $result['ts_approved_length']='0';
				
				$sql2 = mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE item_alias ='$alias' AND module='MR' AND flag=0 ORDER BY id");
				if(mysqli_num_rows($sql2)){
					$i=0;while($row2=mysqli_fetch_array($sql2)){
						if($row2['bucket']=='16')$result['ho_remark']=$row2['remarks'];
						$result['remark'][$i]['id']=$row2['id'];
						$result['remark'][$i]['remarks']=$row2['remarks'];
						$result['remark'][$i]['bucket']=alias($row2['bucket'],'ec_remarks_bucket','bucket_level','bucket');
						$result['remark'][$i]['remarked_by']=(strtoupper($row2['remarked_by'])=="ADMIN" ? "ADMIN" : alias($row2['remarked_by'],'ec_employee_master','employee_alias','name'));
						$result['remark'][$i]['remarked_on']=dateFormat($row2['remarked_on'],'d');
						$result['remark'][$i]['remarked_on_time']=dateTimeFormat($row2['remarked_on'],'d');
					$i++;}
				}else{$result['remark_length'] = mysqli_num_rows($sql2);}
			}$resCode='0';$resMsg='Successful';
			$result['edit']=grantable('EDIT','MATERIAL REQUEST',$emp_alias);
			$trem=next_dynamic($alias,'E');
			$result['dynamic_check'] =(!empty($trem) && strpos($trem,$emp_alias)!==false ? TRUE:FALSE);
			$result['ho_check'] =(alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias')=='5KPS8Q0ZNB' ? TRUE:FALSE);
			$result['ppc_nhs'] =(alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias')=='8BSTDFFQEP' ? TRUE:FALSE);
			$result['nhs_priv']=(alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias')=='WIMYJFDJPT' ? TRUE:FALSE);
			$result['partialEdit'] = true;
			if(!in_array($result['status'], [0, 3, 4, 5, 6, 8])) {
				$result['partialEdit'] = false;
			}
		}else{$resCode='4';$resMsg='No Records Found!';}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function material_request_multi(){
	global $mr_con;
	$emp_alias=mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token=mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex=='0'){
		$whouse=getempwarehouse($emp_alias);
		if($_REQUEST['ticket_id']!=""){
			if(strpos('BUFFER',strtoupper($_REQUEST['ticket_id']))!==false)$tkt="ticket_alias='2609' AND ";
			else $tkt="ticket_alias IN (SELECT ticket_alias FROM ec_tickets WHERE ticket_id LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['ticket_id'])."%') AND ";
		}else $tkt="";
		if($_REQUEST['mrfnumber']!="")$c1=" mrf_number LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['mrfnumber'])."%' AND ";else $c1="";
		if($_REQUEST['fwh']!=""){$ld="from_wh IN (SELECT wh_alias FROM ec_warehouse WHERE wh_code LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['fwh'])."%' AND wh_alias IN ($whouse)) AND ";}else $ld="";
		if($_REQUEST['towh']!=""){$aa="to_wh IN (SELECT wh_alias FROM ec_warehouse WHERE wh_code LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['towh'])."%') AND ";}else $aa="";
		if($_REQUEST['mdate']!="")$c4=" date_of_request ='".dateFormat(mysqli_real_escape_string($mr_con,$_REQUEST['mdate']),'y')."' AND ";else $c4="";
		if($_REQUEST['mvalue']!="")$c5=" material_value LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['mvalue'])."%' AND ";else $c5="";
		if($_REQUEST['level']!="")$c6=" status ='".mysqli_real_escape_string($mr_con,$_REQUEST['level'])."' AND ";else $c6="";
		if($_REQUEST['sjonumber']!="")$c7=" sjo_number LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['sjonumber'])."%' AND ";else $c7="";
		$mul_dynamic = mul_dynamic($emp_alias);
		if($mul_dynamic=='NA')
			$c8 = "(from_wh IN ($whouse) OR to_wh IN ($whouse)) AND ";
		elseif(empty($mul_dynamic))
			$c8 = "id='' AND ";
		else 
			$c8 = "mrf_alias IN('$mul_dynamic') AND ";
		$condtion=$tkt.$ld.$aa.$c1.$c4.$c5.$c6.$c7.$c8;
		if(alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias')=='8BSTDFFQEP')$condtion=$condtion."status<>'1' AND ";
		$query = "SELECT id FROM ec_material_request WHERE $condtion flag='0'";
		$rec=mysqli_query($mr_con, $query);
		$totalRecords=mysqli_num_rows($rec);
		if($totalRecords > '0'){
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			$totalpages = ceil($totalRecords/$limit);
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sqlTT = mysqli_query($mr_con,"SELECT mrf_number, from_wh,sjo_number,ticket_alias, to_wh, date_of_request, material_value, status, mrf_alias, readiness_date, sjo_file FROM ec_material_request WHERE $condtion flag=0 ORDER BY id DESC LIMIT $offset, $limit");
			if(mysqli_num_rows($sqlTT)){ $i=0;
				$result['requestDetails']=array();
				while($rowTT = mysqli_fetch_array($sqlTT)){
					$result['requestDetails'][$i]['mrfnumber']=$rowTT['mrf_number'];
					if($rowTT['sjo_number']!='0'&&$rowTT['sjo_number']!='')$result['requestDetails'][$i]['sjonumber']=$rowTT['sjo_number'];else $result['requestDetails'][$i]['sjonumber']='-';
					$result['requestDetails'][$i]['ticketid']=($rowTT['ticket_alias']=='2609' ? 'BUFFER' : alias($rowTT['ticket_alias'],'ec_tickets','ticket_alias','ticket_id'));
					$result['requestDetails'][$i]['mrf_alias']=$rowTT['mrf_alias'];
					$result['requestDetails'][$i]['fromwh']=alias($rowTT['from_wh'],'ec_warehouse','wh_alias','wh_code');
					if($rowTT['to_wh']==2)$result['requestDetails'][$i]['towh']='Factory';
					else $result['requestDetails'][$i]['towh']=alias($rowTT['to_wh'],'ec_warehouse','wh_alias','wh_code');
					$result['requestDetails'][$i]['dateofrequest']=$rowTT['date_of_request'];
					$result['requestDetails'][$i]['levelcolor']=fam_lvl_nm_clr($rowTT['status'],"color",$rowTT['mrf_alias'],$rowTT['readiness_date']);
					$result['requestDetails'][$i]['levelname']=fam_lvl_nm_clr($rowTT['status'],"name",$rowTT['mrf_alias']);
					$result['requestDetails'][$i]['level'] = $rowTT['status'];
					$result['requestDetails'][$i]['materialvalue']=$rowTT['material_value'];
					$result['requestDetails'][$i]['sjo_file']=$rowTT['sjo_file'];
					$i++;
				}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}else{$resCode='4'; $resMsg='No Records Found';}
	}elseif($rex==1){
		$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	if($resCode=='0'){
		$result['fromRecords']=$fromRecord;
		$result['toRecords']=$toRecord;
		$result['totalRecords']=$totalRecords;
		if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x;else $result['pages'][1]=1;
	}else $result['totalRecords']='0';
	$result['add']=grantable('ADD','MATERIAL REQUEST',$emp_alias);
	$result['advedit']=grantable('ADV EDIT','MATERIAL REQUEST',$emp_alias);
	$result['delete']=grantable('DELETE','MATERIAL REQUEST',$emp_alias);
	$result['export']=grantable('EXPORT','MATERIAL REQUEST',$emp_alias);
	echo json_encode($result);
}

function material_request_check_delete_status() {
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$mrQuery = "SELECT * FROM ec_material_request WHERE mrf_alias = '$alias'";
			$mrSql = mysqli_query($mr_con, $mrQuery);
			$mrDetails = mysqli_fetch_array($mrSql);
			if($mrDetails['id']) {
				// if level one of these
				// Partially closed or closed 
				if (in_array($mrDetails['status'], [0, 6])) {
					/*
					$mIQuery = "SELECT mi.alias, mi.from_wh, mi.to_wh, mi.trans_id, wh.wh_address FROM ec_material_inward as mi, ec_warehouse as wh WHERE mi.sjo_number = '$alias' AND mi.from_wh = '". $mrDetails['to_wh'] ."' AND mi.from_wh = wh.wh_alias AND  mi.flag = 0";
					$mISql = mysqli_query($mr_con, $mIQuery);
					$mIDetails = mysqli_fetch_array($mISql);
					if($mIDetails['alias']) {
						$res = "This record cannot be deleted as material is already inwarded from " . $mIDetails['wh_address'] . ". Please refer ". $mIDetails['trans_id'] ." in material inward.";
					} else {
						$mOQuery = "SELECT mi.alias, mi.from_wh, mi.to_wh, mi.trans_id, wh.wh_address FROM ec_material_outward as mi, ec_warehouse as wh WHERE mi.sjo_number = '$alias' AND mi.to_wh = wh.wh_alias AND  mi.flag = 0";
						$mOSql = mysqli_query($mr_con, $mOQuery);
						$mODetails = mysqli_fetch_array($mOSql);
						if($mODetails['alias']) {
							$res = "This record cannot be deleted as material is already outwarded to " . $mODetails['wh_address'] . ". Please refer ". $mODetails['trans_id'] ." in material outward.";
						}
					}
					*/
					$res = "Material request cannot be deleted at this stage";
				}
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function material_request_delete() {
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$remarks = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['remarks'])));
	$delType = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['delType'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else if(empty($remarks)) {
			$res="Pleas Provide Remarks";
		} else {
			$mrQuery = "SELECT * FROM ec_material_request WHERE mrf_alias = '$alias'";
			$mrSql = mysqli_query($mr_con, $mrQuery);
			$mrDetails = mysqli_fetch_array($mrSql);
			$resMsg='Successful!';
			if($delType != "STOCK") {
				if($mrDetails['id']) {
					// if status is dispatch pending, under transit, invoice pending
					if (in_array($mrDetails['status'], [3, 4, 8])) {
						$stocksQuery = "SELECT * FROM ec_item_code WHERE sjo_no = '$alias' and flag = 0";
						$stocksSql = mysqli_query($mr_con, $stocksQuery);
						if(mysqli_num_rows($stocksSql)) {
							$stocksQuery = "UPDATE ec_item_code set flag = 9 WHERE sjo_no = '$alias' and flag = 0";
							$stocksSql = mysqli_query($mr_con, $stocksQuery);
							$resMsg='Successful! Stocks added will be deleted!';
							if($mrDetails['status'] == 4) {
								$stocksQuery = "UPDATE ec_material_outward set flag = 9 WHERE sjo_number = '$alias' and flag = 0";
								$stocksSql = mysqli_query($mr_con, $stocksQuery);
								$resMsg='Successful! Stocks added and Material outwarded  will be deleted!';
							}
						}
					}
					$updateMRIQuery = "UPDATE ec_request_items SET flag = 9 WHERE mrf_alias = '$alias'";
					$updateMRISql = mysqli_query($mr_con, $updateMRIQuery);
					$updateQuery = "UPDATE ec_material_request SET last_updated = now(), flag = 9 WHERE mrf_alias = '$alias'";
					$updateMRSql = mysqli_query($mr_con, $updateQuery);
					if(!$updateMRSql) {
						$res = "Failed to delete material request";
					} else {
						$action = "Deleted material request - " . $mrDetails['mrf_number'];
						user_history($emp_alias, $action, $_REQUEST['ip_addr'], $remarks);
					}
				}
			} else {
				// del only new stocks added
				$delStocksQuery = "UPDATE ec_item_code SET flag = 9 WHERE sjo_no = '$alias' and cell_type in ('1', '2')";
				$delStocksSQL = mysqli_query($mr_con, $delStocksQuery);

				$delCellsQuery = "UPDATE ec_total_cell SET flag = 9 WHERE cell_alias in (SELECT item_code_alias FROM ec_item_code WHERE sjo_no = '$alias' and cell_type in ('1', '2')) and location = 'XVX6AZ4VHT'";
				$delCellsSQL = mysqli_query($mr_con, $delCellsQuery);

				$delAccesQuery = "UPDATE ec_total_accessories SET flag = 9 WHERE acc_alias in (SELECT item_code_alias FROM ec_item_code WHERE sjo_no = '$alias' and cell_type in ('1', '2')) and location = 'XVX6AZ4VHT'";
				$delAccesSQL = mysqli_query($mr_con, $delAccesQuery);

				if($mrDetails['status'] != '9') {
					$sjoUpdate = "UPDATE ec_material_request set status = 9 where mrf_alias = '". $alias ."'";
					$sjoUpSql = mysqli_query($mr_con, $sjoUpdate);
				}
				$action = "Deleted Stocks in Material Request - " . $mrDetails['mrf_number'];
				user_history($emp_alias, $action, $_REQUEST['ip_addr'], $remarks);
			}
			$resCode='0';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

//Material Request Service Ends
//Stocks Service Starts
/*function check_acc_sjo($sjo_no,$item_code,$item_description,$settled_amount=0){global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT quantity FROM ec_request_items WHERE mrf_alias='$sjo_no' AND item_description='$item_code' AND item_type='2' AND flag=0");
	$row=mysqli_fetch_array($sql);
	$requested_quanty=$row['quantity'];
	$current_quanty=$item_description;
	$sql = mysqli_query($mr_con,"SELECT item_description FROM ec_item_code WHERE sjo_no='$sjo_no' AND item_code='$item_code' AND item_type='2' AND flag=0");
	if(mysqli_num_rows($sql)){
		while($row=mysqli_fetch_array($sql)){
			$settled_amount+=$row['item_description'];
		}
	}
	if($requested_quanty<($current_quanty+$settled_amount)) return '0';
	else return '1';
}*/
function getquantyofrequests($itemtype,$mrf_alias,$itemreq,$request_quanty){global $mr_con;
	$settled_amount=0;
	$sql = mysqli_query($mr_con,"SELECT item_description,id FROM ec_item_code WHERE sjo_no='$mrf_alias' AND item_code='$itemreq' AND item_type='$itemtype' AND stat='0' AND flag=0");
	if(mysqli_num_rows($sql)){
		while($row=mysqli_fetch_array($sql)){
			if($itemtype=='1'){$settled_amount+=1;}// For Cells
			else{$settled_amount+=$row['item_description'];}// for Accessories
		}
	}
	$final_amount=$settled_amount;
	if($final_amount<0)$final_amount=0;
	return $final_amount;
}
function getquantyofrequests_ic($itemtype,$mrf_alias,$itemreq,$request_quanty){global $mr_con;
	$settled_amount=0;
	$sql = mysqli_query($mr_con,"SELECT item_description,id FROM ec_item_code WHERE sjo_no='$mrf_alias' AND item_code='$itemreq' AND item_type='$itemtype' AND flag=0");
	if(mysqli_num_rows($sql)){
		while($row=mysqli_fetch_array($sql)){
			if($itemtype=='1'){$settled_amount+=1;}
			else{$settled_amount+=$row['item_description'];}
		}
	}
	$final_amount=$request_quanty-$settled_amount;
	if($final_amount<0)$final_amount=0;
	return $final_amount;
}
function item_code_add(){ 
	global $mr_con;
	$emp_alias=mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token=mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk=='0'){
		if(isset($_REQUEST['sjo_no']) && !empty($_REQUEST['sjo_no'])){
			$sjo_no = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['sjo_no'])));
			$sjo_num=alias($sjo_no,'ec_material_request','mrf_alias','sjo_number');
			if(isset($_REQUEST['invoice_no'])){
				$reqw=alias($sjo_no,'ec_material_request','mrf_alias','status');
				$invoice_name=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['invoice_no'])));
				$invoice_date=mysqli_real_escape_string($mr_con,dateFormat(trim($_REQUEST['invoice_date']),"y"));
				$up=mysqli_query($mr_con,"UPDATE ec_item_code SET invoice_no='$invoice_name',invoice_date='$invoice_date' WHERE sjo_no='$sjo_no' AND invoice_no='' AND invoice_no!='NA' AND flag='0'");
				if($up && $reqw=='8'){
					$up2=mysqli_query($mr_con,"UPDATE ec_material_request SET last_updated = now(), status = '3' WHERE mrf_alias='$sjo_no' AND flag=0");
					$ab=mysqli_query($mr_con,"SELECT item_code_alias FROM ec_item_code WHERE item_type='1' AND sjo_no='$sjo_no' AND invoice_no='$invoice_name' AND flag=0");
					$act_msg_hist="Items are ready to Dispatch from Factory with Invoice Number: $invoice_name with Invoice Dated on : $invoice_date against SJO Number: $sjo_num";
					if(mysqli_num_rows($ab)>0)while($rowab = mysqli_fetch_array($ab))cellhistoryinsert($rowab['item_code_alias'],$act_msg_hist);
					list($ticket_id,$req_items)=explode("_@",request_desc_sms($sjo_no,"CUST"));
					$fam_msg="Dear Team,Invoice/ NRDC Number against the SJO Number $sjo_num is updated, Kindly plan the dispatch and update the dispatch details in portal";
					/*
					foreach(sms_contacts($sjo_no,array("HO","LOGISTICS")) as $phnum)messageSent($phnum,$fam_msg);
					*/
					$from_wh=alias($sjo_no,'ec_material_request','mrf_alias','from_wh');
					$state_alais = alias($from_wh,'ec_warehouse','wh_alias','state_alias');
					ecSendSms('mr_commercial_updated_invoice', $state_alias, "", $fam_msg);
					$fam_msg1="Dear Customer, Material request against $ticket_id, of $req_items was packed ,Kindly arrange Road Permit / Way bill against the Invoice $invoice_name to dispatch the Material";
					/*
					foreach(sms_contacts($sjo_no,array("CUST","SE","ZHS","NHS","HO")) as $phnum1)messageSent($phnum1,$fam_msg1);
					*/
					$custNo = alias($sjo_no,'ec_material_request','mrf_alias','customer_phone');
					ecSendSms('mr_road_permit_customer_communication', $state_alias, $custNo, $fam_msg1);
					curlxing(localURL()."services/inventory/mails/midmails?a=".$sjo_no."&b=d");
					inventory_notification($sjo_no,$act_msg_hist,'6');
					user_history($emp_alias,$act_msg_hist,$_REQUEST['ip_addr']);
					$resCode='0';$resMsg='Successful!';
				}else{$resCode='4';$resMsg='Sorry Try Again';}
			}else{ $level=array(); $ercode='0';
						if(isset($_FILES['file']) && !empty($_FILES['file']['name'])){
							set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
							$inputFileName = $_FILES["file"]["tmp_name"];
							$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
							try{$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);}
							catch(Exception $e){$ercode=1;$res ="Error loading file: ".$e->getMessage();}
							if($ercode=='0'){
								$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
								$arrayCount = count($allDataInSheet);
								$caarr=array();
								for($i=2;$i<=$arrayCount;$i++){
									$aaa[($i-2)]=strtoupper(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["A"])));
									$bet=strtoupper(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["B"])));
									if(array_key_exists($bet,$caarr)){
										$bbb[($i-2)]=$caarr[$bet];
									}else{
										$bbb[($i-2)]=($aaa[($i-2)]=="CELLS" ? alias($bet,'ec_product','product_description','product_alias') : alias($bet,'ec_accessories','accessory_description','accessories_alias'));
										$caarr[$bet]=$bbb[($i-2)];
									}
									$ccc[($i-2)]=strtoupper(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["C"])));
									$cet = strtoupper(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["D"])));
									$ddd[($i-2)]=($cet == 'NEW' ? 1 : ($cet == 'REVIVED' ? 2 : ''));
								}
							}$rrrr=false;
						}else $rrrr=true;
				if($rrrr){
					if((isset($_REQUEST['cellNumber_Quanty']) && count(array_filter($_REQUEST['cellNumber_Quanty']))!=count($_REQUEST['cellNumber_Quanty'])))$jjjj=true;else $jjjj=false;
					if(isset($_REQUEST['itemTypes']) && count($_REQUEST['itemTypes'])>0)$kkjj=false;else $kkjj=true;
				}else{$jjjj=$kkjj=false;}
				
				if($jjjj){$resCode='4';$resMsg="Please Enter All Cell Serial Numbers OR Quantity For Accessory";}
				else{
					if($kkjj){$resCode='4';$resMsg="Something went wrong! Try again Later.";}
					else{
						if($rrrr){ //Entering cell serial no. manually
							$temp=array_flip(array_keys($_REQUEST['cellNumber_Quanty'], ""));
							$itemTypes = array_values(array_diff_key($_REQUEST['itemTypes'],$temp));
							$celltype = array_values(array_diff_key($_REQUEST['celltype'],$temp));
							$itemalias = array_values(array_diff_key($_REQUEST['itemalias'],$temp));
							$cellNumber_Quanty=$cellNumber_Quanty1 = array_values(array_diff_key($_REQUEST['cellNumber_Quanty'],$temp));
						}else{ //Excel file import
							$temp=array_flip(array_keys($ccc, ""));
							$itemTypes = array_values(array_diff_key($aaa,$temp));
							$celltype = array_values(array_diff_key($ddd,$temp));
							$itemalias = array_values(array_diff_key($bbb,$temp));
							$cellNumber_Quanty=$cellNumber_Quanty1 = array_values(array_diff_key($ccc,$temp));
						}
						$lcount=$rcount=array();
						if(in_array("ACCESSORIES",$itemTypes)){
							$acc_key_count=array_keys($itemTypes, "ACCESSORIES");
							$cellNumber_Quanty1=array_values(array_diff_key($cellNumber_Quanty,array_flip($acc_key_count)));
							for($h=0;$h<count($acc_key_count);$h++){$g=$acc_key_count[$h];
								$lsql=mysqli_query($mr_con,"SELECT cappr_quanty FROM ec_request_items WHERE mrf_alias='$sjo_no' AND item_type='2' AND item_description='".$itemalias[$g]."' AND cappr_quanty='".$cellNumber_Quanty[$g]."' AND flag='0'");
								if(mysqli_num_rows($lsql)){$lrow=mysqli_fetch_array($lsql);$lcount[$h]=$lrow['cappr_quanty'];$rcount[$h]="";}else{$lcount[$h]="NA";$rcount[$h]=alias($itemalias[$g],'ec_accessories','accessories_alias','accessory_description');}
							}	
						}
						if(count(array_unique($cellNumber_Quanty1))!=count($cellNumber_Quanty1)){$resCode='4';$resMsg=implode(", ",array_diff_key($cellNumber_Quanty1,array_unique($cellNumber_Quanty1)))." are Duplicate Cell Serial Numbers Occured";	}
						else{
							if(!in_array("NA",$lcount)){$alex=array();
								if(in_array("CELLS",$itemTypes)){
									$sss=mysqli_query($mr_con,"SELECT item_description FROM ec_item_code WHERE item_type='1' AND item_description IN('".implode("','",$cellNumber_Quanty1)."') AND flag='0'");
									if(mysqli_num_rows($sss)){
										while($ro=mysqli_fetch_array($sss))$alex[]=$ro['item_description'];
										$ss=FALSE;
									}else $ss=TRUE;
								}else $ss=TRUE;
								if($ss){
									$iiii=$tttt=$inarr=$itmchc=$itmcha=$hhhh=$inew_array=array();
									$sjo_num=alias($sjo_no,'ec_material_request','mrf_alias','sjo_number');
									$fwh=alias('1','ec_warehouse','wh_type','wh_alias');
									for($i=0;$i<count($cellNumber_Quanty);$i++){
										$item_type=itemTypenumeric(strtoupper(mysqli_real_escape_string($mr_con,trim($itemTypes[$i]))));
										$cell_type=mysqli_real_escape_string($mr_con,trim($celltype[$i]));
										$item_code=strtoupper(mysqli_real_escape_string($mr_con,trim($itemalias[$i])));
										$item_description=strtoupper(mysqli_real_escape_string($mr_con,trim($cellNumber_Quanty[$i])));
										$date=date('Y-m-d');
										$inew_array=re_check_alias(aliasCheck(generateRandomString(),'ec_item_code','item_code_alias'),$inew_array,'ec_item_code','item_code_alias');
										$item_code_alias=end($inew_array);
										if($item_description!="" && $item_code!="" && $item_type=='1'){
											//$item_code_alias=aliasCheck(generateRandomString(),'ec_item_code','item_code_alias');
											if(!array_key_exists($item_code,$itmchc))$itmchc[$item_code]=round(alias($item_code,'ec_product','product_alias','price'),2);
											$iiii[]="('$item_code','$item_description','1','$sjo_no','$item_type','$cell_type','$item_code_alias','$date','".$itmchc[$item_code]."')";
											
											$tttt[]="('$item_code_alias','$item_code','$fwh','0','$fwh','0','1','$date')";
											$hhhh[]="('$item_code_alias','Cell is ready to Dispatch from Factory against SJO Number: $sjo_num and Pending to Invoice')";
											$level[$i]='1';
											$uuu=$item_code."_".$cell_type;
											if(array_key_exists($uuu,$inarr))$inarr[$uuu]=$inarr[$uuu]+1;else $inarr[$uuu]=1;
										}elseif($item_description!="" && $item_code!="" && $item_type=='2'){
											if(!array_key_exists($item_code,$itmcha))$itmcha[$item_code]=round(alias($item_code,'ec_accessories','accessories_alias','price'),2);
											$iiii[]="('$item_code','$item_description','$item_description','$sjo_no','$item_type','1','$item_code_alias','$date','".$itmcha[$item_code]."')";
											mysqli_query($mr_con,"INSERT INTO ec_total_accessories(acc_alias,item_code, location, good_qty, damaged_qty,lost_qty) VALUES('$item_code_alias','$item_code','$fwh','$item_description','0','0')");
											$level[$i]='1';
										}else $level[$i]='0';
									}
									if(!in_array('0',$level)){
										$sql = mysqli_query($mr_con,"INSERT INTO ec_item_code(item_code,item_description,quantity,sjo_no,item_type,cell_type,item_code_alias,created_date,item_price)VALUES".implode(",",$iiii)."");
										if(count($tttt)>'0')$sqlt = mysqli_query($mr_con,"INSERT INTO ec_total_cell(cell_alias, item_code,old_location,old_location_type,location,location_type,condition_id,transDate)VALUES".implode(",",$tttt)."");else $sqlt=true;
										if(count($hhhh)>'0')$sqlh = mysqli_query($mr_con,"INSERT INTO ec_total_cell_history(`cell_alias`, `message`)VALUES".implode(",",$hhhh)."");else $sqlh=true;
										$up=mysqli_query($mr_con,"UPDATE ec_material_request SET last_updated = now(), status = '8' WHERE mrf_alias='$sjo_no' AND flag=0");
										if($sql && $sqlt && $sqlh && $up){
											$act_msg_hist="Cell is ready to Dispatch from Factory against SJO Number: $sjo_num and Pending to Invoice";
											$fam_msg="Dear Team,Quality Dpt alloted the Cell serial numbers against the SJO Number $sjo_num, Kindy update the Invoice/ NRDC Details in Portal";
											$from_wh=alias($sjo_no,'ec_material_request','mrf_alias','from_wh');
											$state_alais = alias($from_wh,'ec_warehouse','wh_alias','state_alias');
											ecSendSms('mr_quality_updated_cell_serial_number', $state_alias, '', $fam_msg);
											/*
											foreach(sms_contacts($sjo_no,array("ZHS","NHS","HO","INVOICE")) as $phnum)messageSent($phnum,$fam_msg);
											*/
											list($ticket_id,$req_items)=explode("_@",request_desc_sms($sjo_no,"CUST"));
											$fam_msg1="Dear Customer, Material request against $ticket_id, of $req_items was packed ,will update Dispatch details shortly.";
											$custNo = alias($sjo_no,'ec_material_request','mrf_alias','customer_phone');
											ecSendSms('mr_packed_customer_communication', $state_alias, $custNo, $fam_msg1);
											/*
											foreach(sms_contacts($sjo_no,array("CUST","SE","ZHS","NHS","HO")) as $phnum1)messageSent($phnum1,$fam_msg1);
											*/
											curlxing(localURL()."services/inventory/mails/midmails?a=".$sjo_no."&b=i");
											inventory_notification($sjo_no,$act_msg_hist,'6');
											user_history($emp_alias,$act_msg_hist,$_REQUEST['ip_addr']);
											$resCode='0';$resMsg='Successful!';
										}else{$resCode='4';$resMsg='Some Problem Occured';}
									}else{$resCode='4';$resMsg='Sorry Try Again';}
								}else{$resCode='4';$resMsg=implode(",",$alex)." Cell Serial Numbers are already exist";}
							}else{$resCode='4';$resMsg="Accessories ".implode(",",array_filter($rcount))." count exceeds to PPC Planned count";}
						}
					}
				}
			}
		}else{$resCode='4';$resMsg="Please Select SJO Number";}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function item_code_update(){ global $mr_con;
	$emp_alias=mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token=mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){
		$item_code_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['item_code_alias'])));
		
		$cell_no = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['cell_no'])));
		$item_code = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['item_code'])));
		$sjo_no = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['sjo_no'])));
		
		$invoice_no = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['invoice_no'])));
		$invoice_date = mysqli_real_escape_string($mr_con,dateFormat(trim($_REQUEST['invoice_date']),"y"));
		$condtion = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['condtion'])));
		$cell_type = mysqli_real_escape_string($mr_con,trim($_REQUEST['cell_type']));
		
		if(empty($cell_no)){$res="Please Enter Cell Number";}
		elseif(empty($item_code)){$res="Please Select Item Code";}
		//elseif(empty($sjo_no)){$res="Please Select SJO Number";}
		//elseif(empty($invoice_no)){$res="Please Enter Invoice Number";}
		//elseif(empty($invoice_date) || $invoice_date=='NA'){$res="Please Choose Invoice Date";}
		elseif(empty($condtion)){$res="Please select Cell Condtion";}
		else{
			$q=mysqli_query($mr_con,"SELECT id FROM ec_item_code WHERE item_description='$cell_no' AND item_code_alias<>'$item_code_alias' AND flag='0'");
			if(mysqli_num_rows($q)=='0'){
				$sql = mysqli_query($mr_con,"UPDATE ec_item_code SET item_code='$item_code',cell_type='$cell_type',item_description='$cell_no',sjo_no='$sjo_no',invoice_no='$invoice_no',invoice_date='$invoice_date' WHERE item_code_alias='$item_code_alias' AND flag='0'");
				$sql1 = mysqli_query($mr_con,"UPDATE ec_total_cell SET item_code='$item_code',condition_id='$condtion' WHERE cell_alias='$item_code_alias' AND flag='0'");
				$sql2 = mysqli_query($mr_con,"UPDATE ec_material_received_details SET item_code='$item_code' WHERE item_description='$item_code_alias' AND flag='0'");
				$sql3 = mysqli_query($mr_con,"UPDATE ec_material_sent_details SET item_code='$item_code' WHERE item_description='$item_code_alias' AND flag='0'");
				if($sql){
					$action=($item_type=='1' ? "Cell":"Accessory")." : $item_description updated";
					user_history($emp_alias,$action,$_REQUEST['ip_addr']);
					$resCode='0';$resMsg='Successful!';}else{$resCode='4';$resMsg='Error in Updating!';}
			}else{$res = 'Cells with same Cell Number has already exist, Try with other values!';}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function item_code_view(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){
		$item_code_alias=mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
		$sql=mysqli_query($mr_con,"SELECT * FROM ec_item_code WHERE item_code_alias='$item_code_alias' AND flag=0");
		if(mysqli_num_rows($sql)>0){
			$row=mysqli_fetch_array($sql);
				$result['item_description']=$row['item_description'];
				$result['item_type']=$row['item_type'];
				$result['cell_type']=get_cell_type($row['cell_type']);
				$result['item_code_alias']=$row['item_code_alias'];
				$result['item_type_alias']=$row['item_code'];
				if($row['item_type']=="1"){
					$result['item_code']=(!empty(alias($row['item_code'],'ec_product','product_alias','product_description')) ? alias($row['item_code'],'ec_product','product_alias','product_description') : 'NA');
					$result['cell_value']=round(alias($row['item_code'],'ec_product','product_alias','price'),2);
					$sqlet = mysqli_query($mr_con,"SELECT stage,condition_id,location,location_type FROM ec_total_cell WHERE cell_alias='".$row['item_code_alias']."'");
					if(mysqli_num_rows($sqlet)){ $rowet = mysqli_fetch_array($sqlet);
						$condition_desc=alias($rowet['condition_id'],'ec_stock','stock_alias','description');
						$result['condition_id']=$rowet['condition_id'];
						$current_location = current_location($rowet['stage'],$rowet['location_type'],$rowet['location']);
					}else $current_location="";
					$sql1 = mysqli_query($mr_con,"SELECT message,transaction_date FROM ec_total_cell_history WHERE cell_alias = '".$row['item_code_alias']."'");
					if(mysqli_num_rows($sql1)){
						$i=0;while($row1=mysqli_fetch_array($sql1)){
							$result['request_items'][$i]['message']=$row1['message'];
							$result['request_items'][$i]['transaction_date']=$row1['transaction_date'];
						$i++;}
					}else{$result['request_length']=0;}
				}else{
					$result['item_code']=(!empty(alias($row['item_code'],'ec_accessories','accessories_alias','accessory_description')) ? alias($row['item_code'],'ec_accessories','accessories_alias','accessory_description') : 'NA');
					$result['cell_value']=$row['item_description']*(round(alias($row['item_code'],'ec_accessories','accessories_alias','price'),2));
					$sqlet = mysqli_query($mr_con,"SELECT stage,good_qty,damaged_qty,lost_qty,location,location_type FROM ec_total_accessories WHERE acc_alias='".$row['item_code_alias']."'");
					if(mysqli_num_rows($sqlet)){ $rowet = mysqli_fetch_array($sqlet);
						$condition_desc=gd_dm_view_count($row['item_code_alias'],'1');
						$current_location = current_location($rowet['stage'],$rowet['location_type'],$rowet['location']);
					}else $current_location="";
					$sql1 = mysqli_query($mr_con,"SELECT message,transaction_date FROM ec_total_accessory_history WHERE cell_alias = '".$row['item_code_alias']."'");
					if(mysqli_num_rows($sql1)){
						$i=0;while($row1=mysqli_fetch_array($sql1)){
							$result['request_items'][$i]['message']=$row1['message'];
							$result['request_items'][$i]['transaction_date']=$row1['transaction_date'];
						$i++;}
					}else{$result['request_length']=0;}
				}
				$result['mrf_alias']=$row['sjo_no'];
				$result['sjo_no']=alias($row['sjo_no'],'ec_material_request','mrf_alias','sjo_number');
				$result['road_permit']=alias(alias($result['mrf_alias'],'ec_material_request','mrf_alias','from_wh'),'ec_warehouse','wh_alias','road_permit');
				$result['invoice_no']=(!empty($row['invoice_no']) ? $row['invoice_no'] : 'NA');
				$result['invoice_date']=dateFormat($row['invoice_date'],"d");
				
				$result['cell_condition']=(!empty($condition_desc) ? $condition_desc : 'NA');
				$result['current_location']=(!empty($current_location) ? $current_location : 'NA');
						
				$resCode='0'; $resMsg='Successful!';
				$edit=grantable('EDIT','STOCKS',$emp_alias);
				$stock=grantable('STOCK','STOCKS',$emp_alias);
				$result['edit']=($edit && $stock ? TRUE : FALSE);
			}else{$resCode='4';$resMsg='No Records Found!';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function item_code_mul_view(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		if($_REQUEST['itemType']!="")$item_type="item_type = '".mysqli_real_escape_string($mr_con,$_REQUEST['itemType'])."' AND ";else $item_type="";
		if($_REQUEST['itemDesc']!="")$item_desc="item_description LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['itemDesc'])."%' AND ";else $item_desc="";
		if($_REQUEST['itemCode']!=""){
			$itcx=getproduct_accessoryalias($_REQUEST['itemCode']);
			if($itcx!='0')$item_code="item_code IN (".$itcx.") AND ";else $item_code="item_code ='' AND ";
		}else $item_code="";
		if($_REQUEST['sjoNo']!="")$sjo_no="sjo_no IN (SELECT mrf_alias FROM ec_material_request WHERE sjo_number LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['sjoNo'])."%') AND ";else $sjo_no="";
		if($_REQUEST['invdate']!="")$invoice_date="invoice_date ='".dateFormat(mysqli_real_escape_string($mr_con,$_REQUEST['invdate']),'y')."' AND ";else $invoice_date="";
		if($_REQUEST['invno']!="")$invoice_no="invoice_no LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['invno'])."%' AND ";else $invoice_no="";
		//$siteCondition=$item_code;
		$condtion=$item_type.$item_desc.$sjo_no.$item_code.$invoice_date.$invoice_no;
		$countQuery = "SELECT COUNT(id) FROM ec_item_code WHERE $condtion flag=0";
		$rec=mysqli_query($mr_con, $countQuery);
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="" && $_REQUEST['page_no']!="? string:2 ?")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			//echo $limit."-".$pageNo."-".$totalpages."-".$offset;
			$sql = mysqli_query($mr_con,"SELECT item_type,item_code,item_description,sjo_no,item_code_alias,invoice_no,invoice_date FROM ec_item_code WHERE $condtion flag=0 LIMIT $offset, $limit");
			$result['itemDetails']=array();
			if(mysqli_num_rows($sql)){
				$i=0;
				while($row = mysqli_fetch_array($sql)){
					$result['itemDetails'][$i]['item_type']=$row['item_type']; //1 -> CELLS, 2 -> ACCESSORIES
					if($row['item_type']=="1")$result['itemDetails'][$i]['item_code']=alias($row['item_code'],'ec_product','product_alias','product_description');
					if($row['item_type']=="2")$result['itemDetails'][$i]['item_code']=alias($row['item_code'],'ec_accessories','accessories_alias','accessory_description');
					$result['itemDetails'][$i]['item_desc']=$row['item_description'];
					$sjo_number=alias($row['sjo_no'],'ec_material_request','mrf_alias','sjo_number');
					$result['itemDetails'][$i]['sjo_no']=(!empty($sjo_number) ? $sjo_number : "-");
					$result['itemDetails'][$i]['item_code_alias']=$row['item_code_alias'];
					$result['itemDetails'][$i]['invoice_no']=(!empty($row['invoice_no']) ? $row['invoice_no'] : "-");
					$result['itemDetails'][$i]['invoice_date']=($row['invoice_date']=="0000-00-00" ? "-" : dateFormat($row['invoice_date'],"d"));
					$i++;
				}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x;else $result['pages'][1]=1;;
	$result['add']=grantable('ADD','STOCKS',$emp_alias);
	if(!$result['add'])$result['ADD']=grantable('ADV EDIT','STOCKS',$emp_alias);
	$result['advedit']=grantable('ADV EDIT','STOCKS',$emp_alias);
	$result['delete']=grantable('DELETE','STOCKS',$emp_alias);
	$result['export']=grantable('EXPORT','STOCKS',$emp_alias);
	echo json_encode($result);
}
function item_code_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){
		$sql = mysqli_query($mr_con,"SELECT item_type,item_code,item_description,item_price,sjo_no,invoice_no FROM ec_item_code WHERE flag=0");
		$colArr=array('Item Type','Item Description','Item Price','Sjo No','Invoice No','Item Code');
		$colArr2=array('item_type','item_description','item_price','sjo_no','invoice_no');
		$filename = 'Stock_'.date('d-m-Y H_i_s');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
		$ch = 'A';
		foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$ch++;
		} $coo=1;
		while($row=mysqli_fetch_array($sql)){ $coo++;
			for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++)$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
			if($row['item_type']==1)$objPHPExcel->getActiveSheet()->SetCellValue('F'.$coo, alias($row['item_code'],'ec_product','product_alias','item_code'));
			if($row['item_type']==2)$objPHPExcel->getActiveSheet()->SetCellValue('F'.$coo, alias($row['item_code'],'ec_accessories','accessories_alias','item_code'));
		}
		$objPHPExcel->getActiveSheet()->setTitle('Item Code');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save("../../exports/$filename.xlsx");
		$result['file_name']=$filename;
		$resCode='0'; $resMsg='export';
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
//Stocks Service Ends
//Material Inwards Service Starts
function material_inward_multi(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	$whouse=getempwarehouse($emp_alias);
	$privilege_ali=alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias');
	if($rex==0){
		if($_REQUEST['mrfnumber']!="")$tid="trans_id LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['mrfnumber'])."%' AND ";else $tid="";
		if($_REQUEST['fwh']!=""){
			$fwh=mysqli_real_escape_string($mr_con,$_REQUEST['fwh']);
			//if(strtoupper($fwh)=='BUFFER'){ $ld="from_wh ='2609' AND "; }
			if(strpos('BUFFER',strtoupper($fwh))!==false){ $ld="from_wh ='2609' AND "; }
			else{$ld="from_wh IN (SELECT wh_alias FROM ec_warehouse WHERE wh_code LIKE '%$fwh%' UNION ALL SELECT site_alias FROM ec_sitemaster WHERE site_name LIKE '%$fwh%') AND ";}
		}else $ld="";
		if($_REQUEST['towh']!="")$aa="to_wh IN (SELECT wh_alias FROM ec_warehouse WHERE wh_code LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['towh'])."%' AND  wh_alias IN ($whouse)) AND ";else $aa="";
		if($_REQUEST['mdate']!="")$sa="date_of_trans ='".dateFormat(mysqli_real_escape_string($mr_con,$_REQUEST['mdate']),'y')."' AND ";else $sa="";
		if($_REQUEST['mvalue']!="")$sid="totalamount LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['mvalue'])."%' AND ";else $sid="";
		if($_REQUEST['sjonumber']!="")$sjn="sjo_number IN (SELECT mrf_alias FROM ec_material_request WHERE sjo_number LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['sjonumber'])."%') AND ";else $sjn="";
		if($_REQUEST['inv_num']!="")$inv="inv_num LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['inv_num'])."%' AND ";else $inv="";
		
		$condtion=$ld.$aa.$tid.$sa.$sid.$sjn.$inv;
		$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_material_inward WHERE $condtion flag=0 AND to_wh IN ($whouse)");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			//echo "SELECT mrf_number, from_wh, to_wh, date_of_request, material_value, status, mrf_alias FROM ec_material_request WHERE $condtion flag=0 LIMIT $offset, $limit";
			$sqlTT = mysqli_query($mr_con,"SELECT from_type,from_wh,inv_num,to_wh, date_of_trans,ref_no, totalamount, alias, sjo_number, trans_id FROM ec_material_inward WHERE $condtion flag=0 AND to_wh IN ($whouse) ORDER BY id DESC LIMIT $offset, $limit");
			$result['requestDetails']=array();
			if(mysqli_num_rows($sqlTT)){
				$i=0;while($rowTT = mysqli_fetch_array($sqlTT)){
					$result['requestDetails'][$i]['mrf_alias']=$rowTT['alias'];
					$result['requestDetails'][$i]['mrfnumber']=$rowTT['trans_id'];
					$result['requestDetails'][$i]['dateofrequest']=$rowTT['date_of_trans'];
					//list($mrf_number,$sjo_number,$ticket_id)=explode("@",in_m_s_t($rowTT['from_type'],$rowTT['from_wh'],$rowTT['ref_no']));
					if($privilege_ali=="8NHXNU4NDP")$result['requestDetails'][$i]['sjonumber']=$rowTT['inv_num'];
					else $result['requestDetails'][$i]['sjonumber']=alias($rowTT['sjo_number'],'ec_material_request','mrf_alias','sjo_number');
					$result['requestDetails'][$i]['from_type']=$rowTT['from_type'];
					if($rowTT['from_wh']=='2609')$result['requestDetails'][$i]['fromwh']='BUFFER';
					elseif($rowTT['from_type']=='2' || $rowTT['from_type']=='1')$result['requestDetails'][$i]['fromwh']=alias($rowTT['from_wh'],'ec_sitemaster','site_alias','site_name');
					else $result['requestDetails'][$i]['fromwh']=alias($rowTT['from_wh'],'ec_warehouse','wh_alias','wh_code');
					$result['requestDetails'][$i]['towh']=alias($rowTT['to_wh'],'ec_warehouse','wh_alias','wh_code');
					$result['requestDetails'][$i]['materialvalue']=$rowTT['totalamount'];
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
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x;else $result['pages'][1]=1;
	$result['add']=grantable('ADD','MATERIAL INWARD',$emp_alias);
	$result['splEdit']=grantable('ADV EDIT','MATERIAL INWARD',$emp_alias);
	$result['delete']=grantable('DELETE','MATERIAL INWARD',$emp_alias);
	$result['export']=grantable('EXPORT','MATERIAL INWARD',$emp_alias);
	$result['sjo_inv_head']=($privilege_ali=="8NHXNU4NDP" ? TRUE : FALSE);
	//$result['query']="SELECT from_type,from_wh, to_wh, date_of_trans,ref_no, totalamount, alias, sjo_number, trans_id FROM ec_material_inward WHERE $condtion flag=0 AND to_wh IN ($whouse) ORDER BY date_of_trans DESC LIMIT $offset, $limit";
	echo json_encode($result);
}
function material_inward_single_view() { 
	global $mr_con;
	$emp_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$token=mysqli_real_escape_string($mr_con,trim($_REQUEST['token']));
	$alias= mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$sql = mysqli_query($mr_con,"SELECT from_type, inv_num, from_wh, to_wh, date_of_trans, sjo_number, totalamount, list_items, transport, docket, dispatch_date, ref_no, alias, trans_id FROM ec_material_inward WHERE alias ='$alias' AND flag=0");
		if(mysqli_num_rows($sql)){
			while($row=mysqli_fetch_array($sql)){
				$result['trans_id']=$row['trans_id'];
				$result['from_type']=$row['from_type'];
				if($row['from_wh']=='2609')$result['from_wh']='Buffer';
				elseif($row['from_type']=='2')$result['from_wh']=alias($row['from_wh'],'ec_sitemaster','site_alias','site_name');
				elseif($row['from_type']=='1') $result['from_wh']=alias($row['from_wh'],'ec_sitemaster','site_alias','site_name');
				else $result['from_wh']=alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code');
				$result['to_wh']=alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code');
				$road_permit = alias($row['to_wh'],'ec_warehouse','wh_alias','road_permit');
				$result['road_permit']=($road_permit!='' ? ($road_permit=='1' ? 'REQUIRED' : ' NOT REQUIRED') : 'NA');
				$result['date_of_request']=dateFormat($row['date_of_trans'],'d');
				$result['dispatch_date']=dateFormat($row['dispatch_date'],'d');
				$result['material_value']=$row['totalamount'];
				$result['mrf_alias']=$row['alias'];
				$result['transport_no']=$row['transport'];
				$result['docket_no']=$row['docket'];
				list($mrf_number,$sjo_number,$ticket_id)=explode("@",in_m_s_t($row['from_type'],$row['from_wh'],$row['ref_no']));
				$result['mrf_number']=$mrf_number;
				$result['sjo']=alias($row['sjo_number'],'ec_material_request','mrf_alias','sjo_number');
				$result['ticket_id']=$ticket_id;
				$result['inv_num']=$row['inv_num'];
				$result['admin_priv']=($emp_alias=='ADMIN' ? TRUE : FALSE);
				$sql1 = mysqli_query($mr_con,"SELECT mrd.id, mrd.item_type, mrd.item_code, mrd.item_description, mrd.item_condition, (SELECT count(*) from ec_material_sent_details WHERE item_description = mrd.item_description) as count FROM ec_material_received_details as mrd WHERE reference='$alias' AND flag=0");
				if(mysqli_num_rows($sql1)){
					$i=0;
					while($row1=mysqli_fetch_array($sql1)) {
						$result['request_items'][$i]['id']=$row1['id'];
						if ($row1['item_type']=='1') {
		$result['request_items'][$i]['allowconditionUpdate'] = inwardConditionCellUpdate($row1['item_description'], $row['to_wh']);					
						} else {
		$result['request_items'][$i]['allowconditionUpdate'] = inwardConditionAccUpdate($row1['item_description'], $row['to_wh']);
						}
						$result['request_items'][$i]['item_type']=$row1['item_type'];
						$result['request_items'][$i]['item_code_alias']=$row1['item_code'];
						$result['request_items'][$i]['item_condition']=$row1['item_condition'];
						$result['request_items'][$i]['item_description_alias']=$row1['item_description'];
						if($row1['item_type']=='1')$result['request_items'][$i]['item_code']=alias($row1['item_code'],'ec_product','product_alias','product_description');
						else $result['request_items'][$i]['item_code']=alias($row1['item_code'],'ec_accessories','accessories_alias','accessory_description');
						$result['request_items'][$i]['item_description']=alias($row1['item_description'],'ec_item_code','item_code_alias','item_description');
						$result['request_items'][$i]['condition']=($row1['item_type']=='1' ? alias($row1['item_condition'],'ec_stock','stock_alias','description'):gd_dm_view_count($row1['item_description'],'1'));
						$i++;
					}
				} else {
					$result['request_length'] = mysqli_num_rows($sql1);
				}
				$sql2 = mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE item_alias ='$alias' AND module='MI' AND flag=0");
				if(mysqli_num_rows($sql2)){
					$i=0;while($row2=mysqli_fetch_array($sql2)){
						$result['remark'][$i]['remark_alias']=$row2['remark_alias'];
						$result['remark'][$i]['remarks']=$row2['remarks'];
						$result['remark'][$i]['remarked_by_alias'] = strtoupper($row2['remarked_by']);
						$result['remark'][$i]['remarked_by']=(strtoupper($row2['remarked_by'])=="ADMIN" ? "ADMIN" : alias($row2['remarked_by'],'ec_employee_master','employee_alias','name'));
						$result['remark'][$i]['remarked_on']=dateFormat($row2['remarked_on'],'d');
					$i++;}
				}else{$result['remark_length'] = mysqli_num_rows($sql2);}
			}$result['edit']=grantable('EDIT','MATERIAL INWARD',$emp_alias);
		}else{$resCode='4';$resMsg='No Records Found!';}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function gd_dm_view_count($item_description,$ref){ global $mr_con; //1->view; 2->count;
	$sql = mysqli_query($mr_con,"SELECT good_qty,damaged_qty,lost_qty FROM ec_total_accessories WHERE acc_alias ='$item_description' AND flag='0'");
	if(mysqli_num_rows($sql)){ $row=mysqli_fetch_array($sql);
		$good_qty=$row['good_qty'];
		$damaged_qty=$row['damaged_qty'];
		$lost_qty=$row['lost_qty'];
		if($ref=='1'){ return (!empty($good_qty)?"Good:".$good_qty:"").(!empty($good_qty)&&!empty($damaged_qty)?", ":"").(!empty($damaged_qty)?"Damaged:".$damaged_qty:"").(!empty($good_qty)&&empty($damaged_qty)&&!empty($lost_qty)?", ":"").(!empty($damaged_qty)&&!empty($lost_qty)?", ":"").(!empty($lost_qty)?"Lost:".$lost_qty:"");}
		else{ return $good_qty."@@".$damaged_qty."@@".$lost_qty;}
	}else{return "NA";}
}
function material_inward_edit(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$alias = mysqli_real_escape_string($mr_con,$_REQUEST['alias']);
		$inv_num = mysqli_real_escape_string($mr_con,$_REQUEST['inv_num']);
		$dispatch_date = dateFormat(mysqli_real_escape_string($mr_con,$_REQUEST['invoice_date']),'y');
		$transport = mysqli_real_escape_string($mr_con,$_REQUEST['transporterDetails']);
		$docket = mysqli_real_escape_string($mr_con,$_REQUEST['docket']);
		$remarks = mysqli_real_escape_string($mr_con,$_REQUEST['remarks']);
		$remark_alias = $_REQUEST['remark_alias'];
		$remarked_by = $_REQUEST['remarked_by'];
		$remarked_on = $_REQUEST['remarked_on'];
		$remark = $_REQUEST['remark'];
		$item_alias = $_REQUEST['item_alias'];
		$item_condtion = $_REQUEST['item_condtion'] ? $_REQUEST['item_condtion'] : [];
		$item_description = $_REQUEST['item_description'] ? $_REQUEST['item_description'] : [];
		$fail = false;
		$remarksQuries = "";
		foreach($remark_alias as $key=>$each) {
			if(!$remarked_by[$key]) {
				$fail = true;
				$resMsg = "Please select remark by";
			}
			else if(!$remarked_on[$key]) {
				$fail = true;
				$resMsg = "Please select remark on date";
			}
			else if(!$remark[$key]) {
				$fail = true;
				$resMsg = "Please enter remark";
			}
			$date = date("Y-m-d H:m:s ", strtotime($remarked_on[$key]));
			$remarksQuries .= "UPDATE ec_remarks SET remarks='". $remark[$key] ."', remarked_on='". $date ."', remarked_by='". $remarked_by[$key] ."' WHERE remark_alias='$each';";
		}
		$itemQueries = "";
		foreach($item_condtion as $key=>$each) {
			if($each == 0) {
				$fail = true;
				$resMsg = "Please select condition for " . $item_description[$key];
				continue;
			}
			$itemQueries .= "UPDATE ec_material_received_details SET item_condition='$each' WHERE id='". $item_alias[$key] ."';";
		}
		if($fail){$resCode = '4';}
		elseif(empty($alias)){$resCode = '4';$resMsg = "Something went wrong, Please try again later";}
		elseif(empty($inv_num)){$resCode = '4';$resMsg = "Please Enter Inward Number";}
		elseif(empty($dispatch_date) || $dispatch_date=='NA'){$resCode = '4';$resMsg = "Please Enter Dispatch Date";}
		elseif(empty($transport)){$resCode = '4';$resMsg = "Please Enter Transporter";}
		elseif(empty($docket)){$resCode = '4';$resMsg = "Please Enter Docket";}
		elseif(empty($remarks)){$resCode = '4';$resMsg = "Please Enter Remarks";}
		else{
			$sql_sel = mysqli_query($mr_con,"SELECT inv_num, transport, docket, dispatch_date, trans_id FROM ec_material_inward WHERE alias='$alias' AND flag='0'");
			if(mysqli_num_rows($sql_sel)) {
				$row_sel = mysqli_fetch_array($sql_sel);
				$miQuery = "UPDATE ec_material_inward SET inv_num='$inv_num', transport='$transport', docket='$docket', dispatch_date='$dispatch_date' WHERE alias='$alias' AND flag='0'";
				$sql = mysqli_query($mr_con, $miQuery);
				$remarkUpdateSql = mysqli_multi_query($mr_con, $remarksQuries);
				$itemUpdateSql = mysqli_multi_query($mr_con, $itemQueries);
				if($sql && $remarkUpdateSql) {
					$action = "Updated Material inward trans id " . $row_sel['trans_id'];
					user_history($emp_alias,$action, $_REQUEST['ip_addr'], $remarks);
					$resCode='0'; $resMsg='Successful!';
				} else {
					$resCode='4'; $resMsg="Failed to update inward";
				}
			}
		}
	}elseif($rex=='1'){ $resCode='1'; $resMsg='Authentication Failed';}
	else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function material_inward_check_delete_status() {
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			// TODO:: Need to add additional checks
			$mIQuery = "SELECT * FROM ec_material_inward WHERE alias = '$alias'";
			$mISql = mysqli_query($mr_con, $mIQuery);
			$mIDetails = mysqli_fetch_array($mISql);
			if($mIDetails['id']) {
				if($mIDetails['from_wh'] == 'XVX6AZ4VHT') {
					$res = "Material inwarded from factory cannot be deleted";
				} else if ($mIDetails['to_wh'] == 'XVX6AZ4VHT') {
					// No check required
				} else {
					$mOQuery = "SELECT mo.alias, mo.from_wh, mo.to_wh, mo.trans_id FROM ec_material_outward as mo WHERE mo.sjo_number = '". $mIDetails['sjo_number'] ."' AND  mo.flag = 0 ";
					$mOSql = mysqli_query($mr_con, $mOQuery);
					if(mysqli_num_rows($mOSql) > 0 ) {
						$mODetails = mysqli_fetch_array($mOSql);
						$mSQuery = "SELECT DISTINCT(reference) FROM ec_material_sent_details WHERE item_description in (SELECT item_description FROM ec_material_received_details WHERE reference = '". $mIDetails['alias'] ."' AND flag = 0) AND flag = 0";
						$mSSql = mysqli_query($mr_con, $mSQuery);
						if(mysqli_num_rows($mSSql) > 0) {
							$mSDetails = mysqli_fetch_array($mSSql);
							$transId = alias($mSDetails['reference'],'ec_material_outward','alias','trans_id');
							$res = "These item can't be deleted as they have transactions against this SJO. Please refer " . $transId . " in material outwards.";
						}
					}
				}
				$resCode='0';
				$resMsg='Successful!';
			} else {
				$res="Invalid Request";
			}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function material_inward_delete() {
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$remarks = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['remarks'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else if(empty($remarks)) {
			$res="Pleas Provide Remarks";
		} else {
			$mIQuery = "SELECT * FROM ec_material_inward WHERE alias = '$alias'";
			$mISql = mysqli_query($mr_con, $mIQuery);
			$mIDetails = mysqli_fetch_array($mISql);
			if($mIDetails['id']) {
				if($mIDetails['from_wh'] == 'XVX6AZ4VHT') {
					$res = "Material inwarded from factory cannot be deleted";
				} else {
					$mRecQuery = "SELECT item_description FROM ec_material_received_details WHERE reference = '$alias' and flag = 0";
					$mRecSql = mysqli_query($mr_con, $mRecQuery);
					$mRecNoRows = mysqli_num_rows($mRecSql);
					if($mRecNoRows > 0) {
						$allItems = [];
						while($each = mysqli_fetch_array($mRecSql)) {
							$allItems[] = $each['item_description'];
						}
						if ($mIDetails['to_wh'] == 'XVX6AZ4VHT') {
							$mSentQuery = "SELECT DISTINCT(reference) FROM ec_material_sent_details WHERE item_description in ($mRecQuery) and flag = 0";
							$mSentSql = mysqli_query($mr_con, $mSentQuery);
							$query = "UPDATE ec_total_accessories set location = 'XVX6AZ4VHT', stage = '1', location_type = '0' WHERE acc_alias in ($mRecQuery)";
							mysqli_query($mr_con, $query);
							$query = "UPDATE ec_total_cell set location = 'XVX6AZ4VHT', stage = '1', location_type = '0' WHERE cell_alias in ($mRecQuery)";
							mysqli_query($mr_con, $query);
							while($mSentDetails = mysqli_fetch_array($mSentSql)) {
								$mSentRefQuery = "SELECT location, stage FROM `ec_total_cell` WHERE flag = 0 and cell_alias in (SELECT item_code_alias FROM ec_item_code WHERE flag = 0 and item_code_alias in (SELECT item_description FROM ec_material_sent_details WHERE flag = 0 and reference = '". $mSentDetails['reference'] ."'))";
								// $mSentRefQuery = "SELECT * FROM ec_material_sent_details WHERE reference = '". $mSentDetails['reference'] ."' and flag = 0";
								$mSentRefSql = mysqli_query($mr_con, $mSentRefQuery);
								$status = 4;
								while($mSentRefDetails = mysqli_fetch_array($mSentRefSql)) {
									if($mSentRefDetails['stage'] == 0) {
										$status = 0;
									}
								}
								$moUpdateQuery = "UPDATE ec_material_outward set `status` = '$status' where alias = '". $mSentDetails['reference'] ."'";
								$moUpdatSql = mysqli_query($mr_con, $moUpdateQuery);
							}
						} else {
							// Delete stock if inwarded from site / ticket
							$delStockQuery = "UPDATE ec_item_code set flag = 9 WHERE item_code_alias in ($mRecQuery)";
							mysqli_query($mr_con, $delStockQuery);
						}
					}
				}
				if(empty($res)) {
					$delMI = "UPDATE ec_material_inward set flag = 9 WHERE alias = '". $alias ."'";
					$delMaterialRec = "UPDATE ec_material_received_details set flag = 9 WHERE reference = '". $alias ."'";
					mysqli_query($mr_con, $delMaterialRec);
					if(!mysqli_query($mr_con, $delMI) ) {
						$res = "Failed to delete material inwards.";
					} else {
						$name = alias($alias,'ec_material_inward','alias','trans_id');
						$action = "Delete material inward - " . $name;
						user_history($emp_alias, $action, $_REQUEST['ip_addr'], $remarks);
					}
				}
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function material_outward_edit(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$alias = mysqli_real_escape_string($mr_con,$_REQUEST['alias']);
		$resp_engineer = mysqli_real_escape_string($mr_con,$_REQUEST['resp_engineer']);
		$dispatch_date = dateFormat(mysqli_real_escape_string($mr_con,$_REQUEST['invoice_date']),'y');
		$transport = mysqli_real_escape_string($mr_con,$_REQUEST['transporterDetails']);
		$docket = mysqli_real_escape_string($mr_con,$_REQUEST['docket']);
		$remarks = mysqli_real_escape_string($mr_con,$_REQUEST['remarks']);
		$change_tt = mysqli_real_escape_string($mr_con,$_REQUEST['change_tt']);
		$ref_no = mysqli_real_escape_string($mr_con,$_REQUEST['ref_no']);

		$remark_alias = $_REQUEST['remark_alias'];
		$remarked_by = $_REQUEST['remarked_by'];
		$remarked_on = $_REQUEST['remarked_on'];
		$remark = $_REQUEST['remark'];
		$item_alias = $_REQUEST['item_alias'];
		$item_condtion = $_REQUEST['item_condtion'] ? $_REQUEST['item_condtion'] : [];
		$item_description = $_REQUEST['item_description'] ? $_REQUEST['item_description'] : [];
		$fail = false;
		$remarksQuries = "";
		foreach($remark_alias as $key=>$each) {
			if(!$remarked_by[$key]) {
				$fail = true;
				$resMsg = "Please select remark by";
			}
			else if(!$remarked_on[$key]) {
				$fail = true;
				$resMsg = "Please select remark on date";
			}
			else if(!$remark[$key]) {
				$fail = true;
				$resMsg = "Please enter remark";
			}
			$date = date("Y-m-d H:m:s ", strtotime($remarked_on[$key]));
			$remarksQuries .= "UPDATE ec_remarks SET remarks='". $remark[$key] ."', remarked_on='". $date ."', remarked_by='". $remarked_by[$key] ."' WHERE remark_alias='$each';";
		}
		$itemQueries = "";
		foreach($item_condtion as $key=>$each) {
			if($each == 0) {
				$fail = true;
				$resMsg = "Please select condition for " . $item_description[$key];
				continue;
			}
			$itemQueries .= "UPDATE ec_material_sent_details SET item_condition='$each' WHERE id='". $item_alias[$key] ."';";
		}

		if($fail){$resCode = '4';}
		elseif(empty($alias)){$resCode = '4';$resMsg = "Something went wrong, Please try again later";}
		elseif(empty($resp_engineer)){$resCode = '4';$resMsg = "Please Select Responsible Engineer";}
		elseif(empty($dispatch_date) || $dispatch_date=='NA'){$resCode = '4';$resMsg = "Please Enter Dispatch Date";}
		elseif(empty($transport)){$resCode = '4';$resMsg = "Please Enter Transporter";}
		elseif(empty($docket)){$resCode = '4';$resMsg = "Please Enter Docket";}
		elseif(empty($remarks)){$resCode = '4';$resMsg = "Please Enter Remarks";}
		elseif(!empty($change_tt) && $change_tt == 1 && empty($ref_no) ){$resCode = '4';$resMsg = "Please Select Ticket";}
		else{
			$sql_sel = mysqli_query($mr_con,"SELECT resp_engineer, transport, docket, dispatch_date, trans_id FROM ec_material_outward WHERE alias='$alias' AND flag='0'");
			$additionalChanges = "";
			if($change_tt == 1) {
				if($ref == '2609') {
					$toWh = "2609";
				} else {
					$toWh = alias($ref_no, 'ec_tickets', 'ticket_alias', 'site_alias');
				}
				$additionalChanges = " , ref_no='$ref_no', to_wh = '$toWh' ";
			}
			$row_sel=mysqli_fetch_array($sql_sel);
			$sql = mysqli_query($mr_con,"UPDATE ec_material_outward SET resp_engineer='$resp_engineer', transport='$transport', docket='$docket', dispatch_date='$dispatch_date' $additionalChanges WHERE alias='$alias' AND flag='0'");
			// $itemUpdateSql = mysqli_multi_query($mr_con, $itemQueries);
			$remarkUpdateSql = mysqli_multi_query($mr_con, $remarksQuries);
			if($sql) {
				$action = "Updated Material outward trans id " . $row_sel['trans_id'];
				user_history($emp_alias, $action, $_REQUEST['ip_addr'], $remarks);
				$resCode='0'; $resMsg='Successful!';
			}
		}
	}elseif($rex=='1'){ $resCode='1'; $resMsg='Authentication Failed';}
	else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function material_inward_add(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$reverseSjo=0;
		$to_wh = mysqli_real_escape_string($mr_con,$_REQUEST['to_wh']);
		$fromtype = mysqli_real_escape_string($mr_con,$_REQUEST['materialToType']);
		$inv_num = mysqli_real_escape_string($mr_con,$_REQUEST['inv_num']);
		$transport = mysqli_real_escape_string($mr_con,$_REQUEST['transporterDetails']);
		$docket = mysqli_real_escape_string($mr_con,$_REQUEST['docket']);
		$remarks = mysqli_real_escape_string($mr_con,$_REQUEST['remarks']);
		$dispatch_date = mysqli_real_escape_string($mr_con,$_REQUEST['invoice_date']);
		$ref_no = mysqli_real_escape_string($mr_con,$_REQUEST['ref_no']);
		if(isset($_FILES['file']) && !empty($_FILES['file']['name'])){
			$ercode='0';
			set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
			$inputFileName = $_FILES["file"]["tmp_name"];
			$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
			try{$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);}
			catch(Exception $e){$ercode=1;$res ="Error loading file: ".$e->getMessage();}
			if($ercode=='0'){
				$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				$arrayCount = count($allDataInSheet);
				$caarr=array();
				$sql_nv_max=mysqli_query($mr_con,"SELECT MAX(CAST(SUBSTRING_INDEX(item_description,'-',-1) AS SIGNED)) AS nv_max FROM ec_item_code WHERE item_description LIKE '%NOT VISIBLE-%' AND flag='0'");
				$row_nv_max=mysqli_fetch_array($sql_nv_max);
				$nv_max=($row_nv_max['nv_max']!=NULL ? $row_nv_max['nv_max'] : '0');
				$mx=1;
				for($i=2;$i<=$arrayCount;$i++){
					$prod=strtoupper(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["A"])));
					if(array_key_exists($prod,$caarr)){
						$aaa[($i-2)]=$caarr[$prod];
					}else{
						$aaa[($i-2)]=alias($prod,'ec_product','product_description','product_alias');
						$caarr[$prod]=$aaa[($i-2)];
					}
					$cl=strtoupper(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["B"])));
					if($cl=="NA"){
						$bbb[($i-2)]= "NOT VISIBLE-".($nv_max+$mx); $mx++;				
					}else $bbb[($i-2)]=$cl;
					$ccc[($i-2)]=condition(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["C"])));
				}
				$rqitm=$aaa;
				$rcondtioncondtionqitm=$ccc;
				$cell_nocell_no=$bbb;
			}$rrrr=false;
		}else {$rrrr=true;
			$rqitm=$_REQUEST['batteryRating'];
			$rcondtioncondtionqitm=$_REQUEST['condtion'];
			$cell_nocell_no=$_REQUEST['cell_no'];
		}
		$main_sjo_number = mysqli_real_escape_string($mr_con,$_REQUEST['main_sjo_number']);
		if(empty($to_wh)){$resCode = '4';$resMsg = "Please Select Material Receiving By(Wh)";}
		elseif(empty($fromtype)){$resCode = '4';$resMsg = "Please Select Material Receiving From";}
		elseif(empty($inv_num)){$resCode = '4';$resMsg = "Please Enter Inward Number";}
		elseif(empty($dispatch_date)){$resCode = '4';$resMsg = "Please Enter Dispatch Date";}
		elseif(empty($transport)){$resCode = '4';$resMsg = "Please Enter Transporter";}
		elseif(empty($docket)){$resCode = '4';$resMsg = "Please Enter Docket";}
		elseif(empty($remarks)){$resCode = '4';$resMsg = "Please Enter Remarks";}
		//elseif(isset($main_sjo_number) && $main_sjo_number==''){$resCode = '4';$resMsg = "Please Select SJO Number";}
		
		elseif(isset($rqitm) && count(array_filter($rqitm)) && count(array_filter($rqitm)) != count($rqitm)){$resCode = '4';$resMsg = "Please Select Battery Rating";}
		elseif(isset($rcondtioncondtionqitm) && count(array_filter($rcondtioncondtionqitm)) && count(array_filter($rcondtioncondtionqitm)) != count($rcondtioncondtionqitm)){$resCode = '4';$resMsg = "Please Select Condition";}
		elseif(isset($cell_nocell_no) && count(array_filter($cell_nocell_no)) && count(array_filter($cell_nocell_no)) != count($cell_nocell_no)){$resCode = '4';$resMsg = "Please Enter Cell number";}
		elseif(isset($cell_nocell_no) && count(array_filter($cell_nocell_no)) && count(array_unique(array_filter($cell_nocell_no))) != count(array_filter($cell_nocell_no))){$resCode = '4';$resMsg = implode(",",array_diff_key(array_filter($cell_nocell_no),array_unique(array_filter($cell_nocell_no))))." are Duplicate Cell Numbers in submitted file.";}
		
		else{$vv=array();
			if($fromtype=='1'||$fromtype=='2'){
				$num=mysqli_query($mr_con,"SELECT t1.item_description FROM ec_item_code t1 INNER JOIN ec_total_cell t2 ON t1.item_code_alias=t2.cell_alias WHERE t1.item_description IN ('".implode("','",array_diff($cell_nocell_no, array("NA")))."') AND t1.item_type='1' AND t2.condition_id IN('3','4','5','7') AND t1.flag = 0 AND t2.flag = 0");
				if(mysqli_num_rows($num)!='0'){
					while($ttt=mysqli_fetch_array($num))$vv[]=$ttt['item_description'];
				}
			}
			if(count($vv)=='0'){
			$nhs=$zhs=$sereng=$other=array();
			$dispatch_date=date_format(date_create($dispatch_date), "Y-m-d");
			//Tickets
			if($fromtype=='1'){
				if(empty($ref_no)){$resCode = '1';$res="Please Select Ticket Number";$conform='0';}
				else{
					$from_wh=alias($ref_no,'ec_tickets','ticket_alias','site_alias');
					if(empty($main_sjo_number))$main_sjo_number=alias($ref_no,'ec_material_request','ticket_alias','mrf_alias');
					elseif($main_sjo_number=='NA')$main_sjo_number="";
					$conform='1';
				}
			}
			//Site
			elseif($fromtype=='2'){
				if(empty($ref_no)){
					$resCode = '1';$res="Please Select Site ID";$conform='0';
				}else{
					if(mysqli_real_escape_string($mr_con,$_REQUEST['ref_no'])=='2609'){
						$x1=mysqli_real_escape_string($mr_con,$_REQUEST['buffer_sjo']);
						if($x1!=""){
							$from_wh='2609';
							$conform='1';
							$ref_no=mysqli_real_escape_string($mr_con,$_REQUEST['buffer_sjo']);
							$main_sjo_number=$reverseSjo=$ref_no;
						}else{$resCode = '1';$res="Please Select Site ID";$conform='0';}
					}else{$from_wh=mysqli_real_escape_string($mr_con,$_REQUEST['ref_no']);
						if($main_sjo_number!='NA')$main_sjo_number=$main_sjo_number;else $main_sjo_number='';
						$conform='1';
					}
				}
			}
			//MRF
			elseif($fromtype=='3'){
				if(empty($ref_no)){$resCode = '1';$res="Please Select MRF Number";$conform='0';}
				else{
					$from_wh=alias($ref_no,'ec_material_request','mrf_alias','to_wh');
					$main_sjo_number=$ref_no;
					$conform='1';
				}
			}
			//Scrap Cells
			elseif($fromtype=='4'){if(empty($ref_no)){$resCode = '1';$res="Please Select Warehouse";$conform='0';}else{$from_wh=$ref_no;$main_sjo_number='';$conform='1';}}
			else{$resCode = '1';$resMsg='Invalid Material Receiving From';$conform='0';}
			
			$trans_id = trans_id('ec_material_inward','trans_id');
			$alias = aliasCheck(generateRandomString(),'ec_material_inward','alias');

  // Recieved By Warehouse (From factory OR another warehouse)
			if(isset($_REQUEST['itemTypes']) && count($_REQUEST['itemTypes'])>'0' && $conform=='1'){$total_amount=0;
				$to_wh_code=alias($to_wh,'ec_warehouse','wh_alias','wh_code');
				$from_wh_code=alias($from_wh,'ec_warehouse','wh_alias','wh_code');
				$mrf_num=alias($ref_no,'ec_material_request','mrf_alias','mrf_number');
				for($i=0;$i<count($_REQUEST['itemTypes']);$i++){
					$product_alias=alias(mysqli_real_escape_string($mr_con,$_REQUEST['itemAlias'][$i]),'ec_item_code','item_code_alias','item_code');
					$cell_condtion=mysqli_real_escape_string($mr_con,$_REQUEST['condtion'][$i]);
					if($_REQUEST['itemTypes'][$i]=='CELLS'){
						$cell_alias=mysqli_real_escape_string($mr_con,$_REQUEST['itemAlias'][$i]);
						if($fromtype=='1'||$fromtype=='2'){
							mysqli_query($mr_con, "UPDATE ec_total_cell SET location='$to_wh', stage='0',site_stage='0',condition_id='".$cell_condtion."' ,transDate='".date('Y-m-d')."' WHERE cell_alias='".$cell_alias."' AND flag=0");
						}else{
							mysqli_query($mr_con, "UPDATE ec_total_cell SET location='$to_wh', stage='0',condition_id='".$cell_condtion."' ,transDate='".date('Y-m-d')."' WHERE cell_alias='".$cell_alias."' AND flag=0");
						}
						mysqli_query($mr_con,"INSERT INTO ec_material_received_details(item_type, item_code, item_description, item_condition, reference)VALUES('1','".$product_alias."','".$cell_alias."','".$cell_condtion."','".$alias."')");
						$historymessage="Cell Received by Warehouse \'".$to_wh_code."\' which is dispatched from  Warehouse \'".$from_wh_code."\' Against MRF Number: \'".$mrf_num."\' through ".$transport." with Docket number: ".$docket;
						cellhistoryinsert($cell_alias,$historymessage);
						$total_amount+=round(alias($cell_alias,'ec_item_code','item_code_alias','item_price'),2);
					}
					if($_REQUEST['itemTypes'][$i]=='ACCESSORIES'){
						$dam_condtion=mysqli_real_escape_string($mr_con,$_REQUEST['dam_condtion'][$i]);
						$lost_condtion=mysqli_real_escape_string($mr_con,$_REQUEST['lost_condtion'][$i]);
						$dam_condtion=($dam_condtion=='' ? 0 : $dam_condtion);$lost_condtion=($lost_condtion=='' ? 0 : $lost_condtion);
						$cell_alias=mysqli_real_escape_string($mr_con,$_REQUEST['itemAlias'][$i]);
						mysqli_query($mr_con, "UPDATE ec_total_accessories SET location='$to_wh',stage='0',good_qty = (good_qty - ($dam_condtion+$lost_condtion)),damaged_qty = (damaged_qty + $dam_condtion),lost_qty = (lost_qty + $lost_condtion) WHERE acc_alias='$cell_alias' AND item_code='$product_alias' AND flag='0'");
						mysqli_query($mr_con,"INSERT INTO ec_material_received_details(item_type, item_code, item_description, item_condition, reference)VALUES('2','".$product_alias."','".$cell_alias."','0','".$alias."')");
						$total_amount+=round(alias($product_alias,'ec_accessories','accessories_alias','price'),2);
					}
				}
				if(empty($historymessage))$historymessage="Accessories Received by Warehouse \'".$to_wh_code."\' which is dispatched from  Warehouse \'".$from_wh_code."\' Against MRF Number: \'".$mrf_num."\' through ".$transport." with Docket number: ".$docket;
				$sql2=mysqli_query($mr_con,"INSERT INTO ec_material_inward(from_type,from_wh,to_wh,date_of_trans,totalamount,transport,docket,ref_no,sjo_number,alias,trans_id,dispatch_date,inv_num)VALUES('$fromtype','$from_wh','$to_wh','" . date('Y-m-d') . "','$total_amount','$transport','$docket','$ref_no','$main_sjo_number','$alias','$trans_id','$dispatch_date','$inv_num')");
				$remark_alias = aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
				$sqlRem = mysqli_query($mr_con, "INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','MI','25','$alias','$emp_alias','$remark_alias')");
				if($sql2 && $sqlRem){
					if($fromtype=='1'){
						mysqli_query($mr_con,"UPDATE ec_engineer_observation SET in_level='1' WHERE ticket_alias='$ref_no' AND flag=0");
						mysqli_query($mr_con,"UPDATE ec_cell_required SET approved_stat='6' WHERE ticket_alias='$ref_no' AND flag=0");
						mysqli_query($mr_con,"UPDATE ec_tickets_inventory SET material_inward='2' WHERE ticket_alias='$ref_no' AND flag=0");
					}
					if($fromtype=='3'){
						$tkt_alias=alias($ref_no,'ec_material_request','mrf_alias','ticket_alias');
						if(!empty($tkt_alias)){
							mysqli_query($mr_con,"UPDATE ec_tickets_inventory SET material_outward='1' WHERE material_outward='2' AND ticket_alias='$tkt_alias' AND flag=0");
						}
						$stat=(!request_items_bal_check($ref_no) ? '0' : '6');
						mysqli_query($mr_con,"UPDATE ec_material_request SET last_updated = now(), status='$stat' WHERE mrf_alias='$ref_no' AND flag=0");
					}$resCode = '0';$resMsg = "Inward Successfully Done, Inward Transation ID is $trans_id";
					/*if($fromtype=='4'){
						$action=$msg="Against the Request ID $trans_id Dated ".date('d-m-Y')." Material Received";
					}else{
						if($fromtype=='3'){ $action=$msg="Against the SJO Number ".alias($ref_no,'ec_material_request','mrf_alias','sjo_number')." Dated ".date('d-m-Y')." Received at field WH ".alias($to_wh,'ec_warehouse','wh_alias','wh_code');}
						else{$action=$msg="Against the Dated ".date('d-m-Y')." Received at field WH ".alias($to_wh,'ec_warehouse','wh_alias','wh_code');}
					}*/
					$item_req = mysqli_query($mr_con,"SELECT COUNT(id) AS cnt,item_type,item_code,GROUP_CONCAT(item_condition) AS itm_cond FROM ec_material_received_details WHERE reference='$alias' AND flag='0' GROUP BY item_code");
					if(mysqli_num_rows($item_req)){ $item_desc=$itm_cond_txt="";
						while($row_req=mysqli_fetch_array($item_req)){
							$itm_cond=array_unique(explode(",",$row_req['itm_cond']));
							if(in_array('1',$itm_cond))$itm_cond_txt .= "Good";
							if(in_array('4',$itm_cond))$itm_cond_txt .= (!empty($itm_cond_txt) ? ", ":"")."Damaged";
							if(in_array('7',$itm_cond))$itm_cond_txt .= (!empty($itm_cond_txt) ? ", ":"")."Lost";
							if($row_req['item_type']=='1')$item_desc.=alias($row_req['item_code'],'ec_product','product_alias','product_description')."- ".$row_req['cnt']." Cells, ";
							else $item_desc.=alias($row_req['item_code'],'ec_accessories','accessories_alias','accessory_description')."- ".$row_req['cnt']." Accessories, ";
						}
						$fam_msg1="Dear Team, Material ".rtrim($item_desc,",")." received against the SJO Number ".alias($ref_no,'ec_material_request','mrf_alias','sjo_number')." by Warehouse $to_wh_code in $itm_cond_txt Condition, This is for your information";
						$from_wh=alias($ref_no,'ec_material_request','mrf_alias','from_wh');
						$state_alais = alias($from_wh,'ec_warehouse','wh_alias','state_alias');
        				ecSendSms('mi_by_zhs_from_factory', $state_alias, "", $fam_msg1);
						/*
						foreach(sms_contacts($ref_no,array("NHS","HO","LOGISTICS")) as $phnum1)messageSent($phnum1,$fam_msg1);	
						*/
					}			
					curlxing(localURL()."services/inventory/mails/mimails?a=".$alias);
					outward_lvl_update($_REQUEST['itemAlias'],'3','3');
					inventory_notification($alias,$historymessage,'4');
					user_history($emp_alias,$historymessage,$_REQUEST['ip_addr']);
				}else{$resCode = '4';$resMsg = "Error In Updating";}
				
  // Recieved By factory (From Warehouse)
			}else if(isset($_REQUEST['crapAlias']) && count($_REQUEST['crapAlias'])>'0' && $conform=='1'){$total_amount=0;$checkbg=0; $scrap_arr=array();
				for($ax=0;$ax<count($_REQUEST['crapAlias']);$ax++){
					if($_REQUEST['sendx'][$ax]=="1"||$_REQUEST['sendx'][$ax]=="2"){
						$scrap_arr[]=$item_code_alias=$_REQUEST['crapAlias'][$ax];
						$batteryRating=alias($item_code_alias,'ec_total_cell','cell_alias','item_code');
						if($_REQUEST['sendx'][$ax]=='2'){$condtion='7'; $dfvg=", condition_id='7'";}
						else{$dfvg='';$condtion=alias($item_code_alias,'ec_total_cell','cell_alias','condition_id');}
						if($fromtype=='1'||$fromtype=='2'){
							mysqli_query($mr_con, "UPDATE ec_total_cell SET stage='0',site_stage='0' $dfvg  WHERE cell_alias='".$item_code_alias."' AND flag=0");
						}else{
							mysqli_query($mr_con, "UPDATE ec_total_cell SET stage='0' $dfvg WHERE cell_alias='".$item_code_alias."' AND flag=0");
						}
						mysqli_query($mr_con,"INSERT INTO ec_material_received_details(item_type, item_code, item_description, item_condition, reference)VALUES('1','".$batteryRating."','".$item_code_alias."','".$condtion."','".$alias."')");
						$total_amount+=round(alias($item_code_alias,'ec_item_code','item_code_alias','item_price'),2);
						$historymessage="Cell Received by FACTORY which is dispatched from Warehouse:  \'".alias($from_wh,'ec_warehouse','wh_alias','wh_code')."\' through ".$transport." with Docket number: ".$docket;
						cellhistoryinsert($item_code_alias,$historymessage);
						$checkbg='1';
					}
				}
				if($checkbg=='1'){
					$sql2=mysqli_query($mr_con,"INSERT INTO ec_material_inward(from_type,from_wh,to_wh,date_of_trans,totalamount,transport,docket,ref_no,sjo_number,alias,trans_id,dispatch_date,inv_num)VALUES('$fromtype','$from_wh','$to_wh','" . date('Y-m-d') . "','$total_amount','$transport','$docket','$ref_no','$main_sjo_number','$alias','$trans_id','$dispatch_date','$inv_num')");
					$remark_alias = aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
					$sqlRem = mysqli_query($mr_con, "INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','MI','27','$alias','$emp_alias','$remark_alias')");
					if($sql2 && $sqlRem){
						$resCode = '0';$resMsg = "Inward Successfully Done, Inward Transation ID is $trans_id";
						curlxing(localURL()."services/inventory/mails/mimails?a=".$alias);
						outward_lvl_update($scrap_arr,'2','4');
						inventory_notification($alias,$historymessage,'4');
						user_history($emp_alias,$historymessage,$_REQUEST['ip_addr']);			
					}else{$resCode = '4';$resMsg = "Error In Updating";}
				}else{$resCode = '4';$resMsg='No Items Selected for Inwards';}

  // Recieved By Warehouse (From Site)
			}else if(((isset($_REQUEST['cell_no']) && count($_REQUEST['cell_no'])>'0') || (isset($_FILES['file']) && !empty($_FILES['file']['name']))) && $conform=='1'){
				if($rrrr){
					if((isset($_REQUEST['cell_no']) && count(array_filter($_REQUEST['cell_no']))!=count($_REQUEST['cell_no'])))$jjjj=true;else $jjjj=false;
					if(isset($_REQUEST['batteryRating']) && count($_REQUEST['batteryRating'])>0)$kkjj=false;else $kkjj=true;
				}else{$jjjj=$kkjj=false;}
				
				if($jjjj){$resCode='4';$resMsg="Please Enter All Cell Serial Numbers";}
				else{
					if($kkjj){$resCode='4';$resMsg="Something went wrong! Check Product Description.";}
					else{
						if($rrrr){
							$temp=array_flip(array_keys($_REQUEST['cell_no'], ""));
							$batteryRating = array_values(array_diff_key($_REQUEST['batteryRating'],$temp));
							$condtion = array_values(array_diff_key($_REQUEST['condtion'],$temp));
							$cell_no= array_values(array_diff_key($_REQUEST['cell_no'],$temp));
						}else{
							$temp=array_flip(array_keys($bbb, ""));
							$batteryRating = array_values(array_diff_key($aaa,$temp));
							$condtion = array_values(array_diff_key($ccc,$temp));
							$cell_no= array_values(array_diff_key($bbb,$temp));
						}
						if(count(array_unique($cell_no))!=count($cell_no)){$resCode='4';$resMsg=implode(", ",array_diff_key($cell_no,array_unique($cell_no)))." are Duplicate Cell Serial Numbers Occured";	}
						else{ $out_check=TRUE;
							if(isset($_REQUEST['outstand_check'])){
								$outstand_check = mysqli_real_escape_string($mr_con,$_REQUEST['outstand_check']);
								 if(!empty($outstand_check)){
									if($outstand_check<count($cell_no))$out_check=FALSE;
								 }
							}
							if($out_check){
								if($fromtype=='1')$test_item_code = array(alias(alias($ref_no,'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','product_alias'));
								elseif($fromtype=='2' && $from_wh!='2609')$test_item_code = array(alias($ref_no,'ec_sitemaster','site_alias','product_alias'));
								elseif($fromtype=='2' && $from_wh=='2609'){
									$req=mysqli_query($mr_con,"SELECT item_description FROM ec_request_items WHERE mrf_alias='$ref_no' AND item_type='1' AND flag='0'");
									if(mysqli_num_rows($req))while($rqrow=mysqli_fetch_array($req))$test_item_code[]=$rqrow['item_description'];else $test_item_code=array();
								}
								if(count(array_diff(array_unique(array_filter($batteryRating)),$test_item_code))=='0'){
									$cell_no1=$alex=$itemalex=$pricealex=$error=array();
									$sss=mysqli_query($mr_con,"SELECT item_code,item_description,item_code_alias,item_price FROM ec_item_code WHERE item_type='1' AND item_description IN('".implode("','",$cell_no)."') AND flag='0'");
									if(mysqli_num_rows($sss)){
										while($ro=mysqli_fetch_array($sss)){
											$num=mysqli_query($mr_con,"SELECT t1.id FROM ec_item_code t1 INNER JOIN ec_total_cell t2 ON t1.item_code_alias=t2.cell_alias WHERE old_location='$to_wh' AND t1.item_code='".$batteryRating[array_search($ro['item_description'],$cell_no)]."' AND t1.item_description ='".$ro['item_description']."' AND t1.item_type='1' AND t2.condition_id NOT IN('3','4','5','7') AND t1.flag='0'");
											if(mysqli_num_rows($num)){
												$batteryra[]=$ro['item_code'];
												$alex[]=$ro['item_description'];
												$itemalex[]=$ro['item_code_alias'];
												$pricealex[]=$ro['item_price'];
											}else $error[]=$ro['item_description'];
										}
									}
									if(empty(count($error))){
										if(count($alex)>'0')$cell_no1=array_values(array_diff($cell_no,$alex));else $cell_no1=array_values($cell_no);
										$msi=$msj="";$iiii=$tttt=$itmchc=$itmcha=$hhhh=array();
										if(!empty($main_sjo_number)){$msi=",sjo_no";$msj=",'$main_sjo_number'";}
										if($fromtype=='1'){$historymessage="Cell Received by Warehouse \'".alias($to_wh,'ec_warehouse','wh_alias','wh_code')."\' which is dispatched from  Site \'".alias($from_wh,'ec_sitemaster','site_alias','site_name')."\' Against Ticket Number: \'".alias($ref_no,'ec_tickets','ticket_alias','ticket_id')."\' through ".$transport." with Docket number: ".$docket;}
										elseif($fromtype=='2'){$historymessage="Cell Received by Warehouse \'".alias($to_wh,'ec_warehouse','wh_alias','wh_code')."\' which is dispatched from  Site \'".alias($from_wh,'ec_sitemaster','site_alias','site_name')."\' through ".$transport." with Docket number: ".$docket;}
										$date=date('Y-m-d');
										$con_sub=$sit_sub="";$total_amount=0;
										$historymessage1=$historymessage." And this cell is received as FIELD GOOD cell.";
										for($i=0;$i<count($alex);$i++){
											$itm_cd_alis=$itemalex[$i];
											$cond_=$condtion[array_search($alex[$i],$cell_no)];
											if($cond_=='8'){$cond_='2';$hhhh[]="('$itm_cd_alis','$historymessage1')";}else $hhhh[]="('$itm_cd_alis','$historymessage')";
											$con_sub.="WHEN cell_alias = '$itm_cd_alis' THEN '$cond_' ";
											if($fromtype=='1'||$fromtype=='2')$sit_sub.="WHEN cell_alias = '$itm_cd_alis' THEN '0' ";
											$itmcha[]="('1','$batteryra[$i]','$itm_cd_alis','$cond_','$alias')";
											$total_amount+=round($pricealex[$i],2);
										}$dfdf=$inew_array=array();
										for($i=0;$i<count($cell_no1);$i++){
											//$item_code_alias[$i]=aliasCheck(generateRandomString(),'ec_item_code','item_code_alias');
											$inew_array=re_check_alias(aliasCheck(generateRandomString(),'ec_item_code','item_code_alias'),$inew_array,'ec_item_code','item_code_alias');
											$item_code_alias[$i]=end($inew_array);
											
											$batteryRati=strtoupper(mysqli_real_escape_string($mr_con,trim($batteryRating[$i])));
											$condti=strtoupper(mysqli_real_escape_string($mr_con,trim($condtion[$i])));
											$cell_=strtoupper(mysqli_real_escape_string($mr_con,trim($cell_no1[$i])));
											$dfdf[]=$condti;
											if($cell_!="" && $batteryRati!="" && $condti!=""){
												if($condti=='8'){$scr="-";$condti='2';$hhhh[]="('".$item_code_alias[$i]."','$historymessage1')";}else {$scr="NA";$hhhh[]="('".$item_code_alias[$i]."','$historymessage')";}
												if(!array_key_exists($batteryRati,$itmchc))$itmchc[$batteryRati]=round(alias($batteryRati,'ec_product','product_alias','price'),2);
												$total_amount+=$itmchc[$batteryRati];
												$iiii[]="('$batteryRati','1','$cell_','1','".$item_code_alias[$i]."','$scr', '$dispatch_date', '$date','0','".$itmchc[$batteryRati]."' $msj)";
												$tttt[]="('".$item_code_alias[$i]."','$batteryRati','$from_wh','2','$to_wh','1','$condti','$date')";
												$itmcha[]="('1','$batteryRati','".$item_code_alias[$i]."','$condti','$alias')";
											}
										}
										$tu_sql = mysqli_query($mr_con, "UPDATE ec_total_cell SET old_location=location,old_location_type=location_type,location = '$to_wh',location_type='1',stage = '0' ".(!empty($sit_sub) ? ",site_stage = (CASE $sit_sub END)":"").",transDate = '$date' ".(!empty($con_sub) ? ",condition_id = (CASE $con_sub END)":"")." WHERE cell_alias IN ('".implode("','",$itemalex)."') AND flag=0");
										$iti_sql_query = "INSERT INTO ec_item_code(item_code,item_type,item_description,quantity,item_code_alias,invoice_no,invoice_date, created_date,stat,item_price $msi)VALUES".implode(",",$iiii)."";
										$iti_sql = mysqli_query($mr_con, $iti_sql_query);
										$rci_query = "INSERT INTO ec_material_received_details(item_type, item_code, item_description, item_condition, reference)VALUES".implode(",",$itmcha)."";
										$rci_sql = mysqli_query($mr_con, $rci_query);
										if(count($tttt)>'0')
											$ti_sql = mysqli_query($mr_con,"INSERT INTO ec_total_cell(cell_alias,item_code,old_location,old_location_type,location,location_type,condition_id,transDate)VALUES".implode(",",$tttt)."");
										else 
											$ti_sql=true;
										if(count($hhhh)>'0')
											$hi_sql = mysqli_query($mr_con,"INSERT INTO ec_total_cell_history(cell_alias,message)VALUES".implode(",",$hhhh)."");
										else 
											$hi_sql=true;
										$ini_query = "INSERT INTO ec_material_inward(from_type,from_wh,to_wh,date_of_trans,totalamount,transport,docket,ref_no,sjo_number,alias,trans_id,dispatch_date,inv_num) VALUES ('$fromtype','$from_wh','$to_wh','".date('Y-m-d')."','$total_amount','$transport','$docket','$ref_no','$main_sjo_number','$alias','$trans_id','$dispatch_date','$inv_num')";
										$ini_sql=mysqli_query($mr_con, $ini_query);
										$remark_alias = aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
										$ri_sql = mysqli_query($mr_con, "INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','MI','26','$alias','$emp_alias','$remark_alias')");
										if($tu_sql && $rci_sql && $ti_sql && $hi_sql && $ini_sql && $ri_sql){
											if($fromtype=='1'){
												mysqli_query($mr_con,"UPDATE ec_engineer_observation SET in_level='1' WHERE ticket_alias='$ref_no' AND flag=0");
												mysqli_query($mr_con,"UPDATE ec_cell_required SET approved_stat='6' WHERE ticket_alias='$ref_no' AND flag=0");
												mysqli_query($mr_con,"UPDATE ec_tickets_inventory SET material_inward='2' WHERE ticket_alias='$ref_no' AND flag=0");
											}
											if($fromtype=='3'){mysqli_query($mr_con,"UPDATE ec_material_request SET last_updated = now(), status='6' WHERE mrf_alias='$ref_no' AND flag=0");}
											$resCode = '0';$resMsg = "Inward Successfully Done, Inward Transation ID is $trans_id";
											curlxing(localURL()."services/inventory/mails/mimails?a=".$alias);
											inventory_notification($alias,$historymessage,'4');
											user_history($emp_alias,$historymessage,$_REQUEST['ip_addr']);
										}else{$resCode = '4';$resMsg = "Error In Updating";}
									}else{$resCode = '4';$resMsg = implode(", ",$error)." Cells are already exist in database";}
								}else{$resCode = '4';$resMsg = "Battery Rating does not matching with ".($fromtype=='1' ? "Ticket ID" : ($from_wh=='2609' ? "SJO Number": "Site ID"))." Cell Capacity (".alias($test_item_code[0],'ec_product','product_alias','product_description').")";}
							}else{$resCode = '4';$resMsg = "Submitted cells quantity is more than outstanding cells quantity";}
						}
					}
				}
			}else{$resCode = '4';$resMsg='No Items Selected for Inwards';}
			}else{$resCode = '4';$resMsg=implode(', ',$vv).' Cell Serial No. are already exists.';}
		}
	}elseif($rex==1){ $resCode='1'; $resMsg='Authentication Failed';}
	else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
//Material Inwards Service Ends
//Material Outwards Service Starts
function material_outward_add() { 
	global $mr_con;
	$emp_alias=mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token=mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$main_sjo_number=$buffer_sjo='0';
		$trans_id = trans_id('ec_material_outward', 'trans_id');
		$alias=aliasCheck(generateRandomString(),'ec_material_outward','alias');
		$from_wh=mysqli_real_escape_string($mr_con,$_REQUEST['from_wh']);
		$ref_no=mysqli_real_escape_string($mr_con,$_REQUEST['ref_no']);
		$materialToType=mysqli_real_escape_string($mr_con,$_REQUEST['materialToType']);
		$transport=mysqli_real_escape_string($mr_con,$_REQUEST['transporterDetails']);
		$docket=mysqli_real_escape_string($mr_con,$_REQUEST['docket']);
		$dispatch_date=mysqli_real_escape_string($mr_con,$_REQUEST['invoice_date']);
		$remarks=mysqli_real_escape_string($mr_con,$_REQUEST['remarks']);
		$resengineer=mysqli_real_escape_string($mr_con,$_REQUEST['resengineer']);
		$main_sjo_number = mysqli_real_escape_string($mr_con,$_REQUEST['main_sjo_number']);
		if(empty($from_wh)){$res="Please Select Material Sending From";}
		elseif(empty($materialToType)){$res="Please Select Material Sending To";}
		elseif(empty($resengineer)){$res="Please Select Responsible Engineer";}
		elseif(empty($transport)){$res="Please Enter Transporter";}
		elseif(empty($docket)){$res="Please Enter Docket";}
		elseif(empty($remarks)){$res="Please Enter Remarks";}
		elseif(empty($dispatch_date)){$res="Please Enter Dispatch Date";}
		//elseif(isset($main_sjo_number) && $main_sjo_number==''){$res="Please Select SJO Number";}
		else{$tt='0';
			$dispatch_date=date_format(date_create($dispatch_date), "Y-m-d");
			if($materialToType=='1'){ //SITE
				if(empty($ref_no)){$resCode = '1';$res="Please Select Ticket Number";$conform='0';}
				else{
					if($ref_no!='2609'){
						$tt=$ref_no;
						$to_alias=alias($ref_no,'ec_tickets','ticket_alias','site_alias');
						if(!isset($main_sjo_number) || empty($main_sjo_number))$main_sjo_number=alias($ref_no,'ec_material_request','ticket_alias','mrf_alias');
						$conform='1';
						$to=alias($to_alias,'ec_sitemaster','site_alias','site_address');
					}else{
						if(isset($_REQUEST['buffer_sjo']) && !empty(trim($_REQUEST['buffer_sjo'])) && trim($_REQUEST['buffer_sjo'])!='0'){
							$buffer_sjo=mysqli_real_escape_string($mr_con,trim($_REQUEST['buffer_sjo']));
							$from_wh=alias($buffer_sjo,'ec_material_request','mrf_alias','from_wh');
							$to=$to_alias='2609';
							$main_sjo_number=$ref_no=$buffer_sjo;
							$conform='1';
						}else{$resCode = '1';$res="Please Select SJO Number";$conform='0';}
					}
				}
			}elseif($materialToType=='2'){ //FACTORY (Scrap Cells)
				if(empty($ref_no)){$resCode = '1';$res="Please Select SJO Number";$conform='0';}
				else{
					$to_alias=alias('1','ec_warehouse','wh_type','wh_alias');
					$to="FACTORY";
					if($ref_no!='NA')$main_sjo_number=$ref_no;else $main_sjo_number='';
					$conform='1';
					$ticket_alias15=alias($ref_no,'ec_material_request','mrf_alias','ticket_alias');
				}
			}elseif($materialToType=='3'){ //W/H
				if(empty($ref_no)){$resCode = '1';$res="Please Select MRF Number";$conform='0';}
				else{
					$to_alias=alias($ref_no,'ec_material_request','mrf_alias','from_wh');
					$to=alias($to_alias,'ec_warehouse','wh_alias','wh_code');
					$main_sjo_number=$ref_no;
					$conform='1';
				}
			}else{$resCode = '1';$resMsg='Invalid Material Sending To';$conform='0';}
			
//From Warehouse to Customer Buffer
			if($to_alias=='2609' && $buffer_sjo!='0' && $conform=='1'){
				
				$sql2=mysqli_query($mr_con,"SELECT COUNT(t4.id) AS cnt,GROUP_CONCAT('''',t4.item_description,'''') AS done_cells FROM ec_material_sent_details t4 INNER JOIN ec_material_outward t3 ON t4.reference = t3.alias WHERE IF(t4.item_type != '2', t4.item_condition IN ('1','2'), t4.item_condition BETWEEN 0 AND 7) AND t3.from_type='1' AND t3.sjo_number='$buffer_sjo'");
				$row2=mysqli_fetch_array($sql2);
				$done_cells=($row2['cnt']>'0' ? $row2['done_cells'] : "''");

				$sql3=mysqli_query($mr_con,"SELECT MIN(t3.id) AS min_id FROM ec_material_received_details t4 INNER JOIN ec_material_inward t3 ON t4.reference = t3.alias WHERE IF(t4.item_type != '2', t4.item_condition IN ('1','2'), t4.item_condition BETWEEN 0 AND 7) AND t3.from_type='3' AND t3.sjo_number='$buffer_sjo' AND t4.item_description NOT IN(".$done_cells.")");
				$row3=mysqli_fetch_array($sql3);
				$min_id=$row3['min_id'];
				
				$sql=mysqli_query($mr_con,"SELECT t1.item_code,t1.item_type,t1.item_description,t1.item_condition FROM ec_material_received_details t1 INNER JOIN ec_material_inward t2 ON t1.reference = t2.alias WHERE t2.id='$min_id'");
				if(mysqli_num_rows($sql)){$i=0;
					while($row=mysqli_fetch_array($sql)){$item_type=$row['item_type'];
						if($item_type=='1'){
							$itemcode=$row['item_code'];
							$itemdesc=$row['item_description'];
							$itemcondition=$row['item_condition'];
							if($materialToType=='1')mysqli_query($mr_con, "UPDATE ec_total_cell SET old_location=location,old_location_type=location_type,location='$to_alias',location_type='3',stage='1', site_stage='1', transDate='".date('Y-m-d')."' WHERE cell_alias='".$itemdesc."' AND flag=0");
							else mysqli_query($mr_con, "UPDATE ec_total_cell SET old_location=location,old_location_type=location_type,location='$to_alias',location_type='3',stage='".($to_alias=='XVX6AZ4VHT' ? '1':'0')."',transDate='".date('Y-m-d')."' WHERE cell_alias='".$itemdesc."' AND flag=0");
							
							mysqli_query($mr_con,"INSERT INTO ec_material_sent_details(item_type, item_code, item_description, item_condition, reference)VALUES('1','".$itemcode."','".$itemdesc."','".$itemcondition."','".$alias."')");
							$historymessage="Cell Dispatched from \'".alias($from_wh,'ec_warehouse','wh_alias','wh_code')."\' as Customer Buffer stock Against SJO Number: \'".alias($ref_no,'ec_material_request','mrf_alias','sjo_number')."\' through ".$transport." with Docket number: ".$docket;
							cellhistoryinsert($itemdesc,$historymessage);
							$total_amount+=round(alias($itemdesc,'ec_item_code','item_code_alias','item_price'),2);
						}else{
							$itemcode=$row['item_code'];
							$itemdesc=$row['item_description'];
							$itemcondition=$row['item_condition'];
							mysqli_query($mr_con, "UPDATE ec_total_accessories SET old_location=location,old_location_type=location_type,location='$to_alias',location_type='3',stage='1' WHERE acc_alias='".$itemdesc."' AND flag='0'");
							mysqli_query($mr_con,"INSERT INTO ec_material_sent_details(item_type, item_code, item_description, item_condition, reference)VALUES('2','".$itemcode."','".$itemdesc."','1','".$alias."')");
							$total_amount+=round(alias($itemdesc,'ec_item_code','item_code_alias','item_price'),2);
						}
						$i++;
					}
					$sql2=mysqli_query($mr_con,"INSERT INTO ec_material_outward(from_type,from_wh,to_wh,date_of_trans,totalamount,transport,docket,ref_no,sjo_number,alias,status,trans_id,dispatch_date,resp_engineer)VALUES('$materialToType','$from_wh','$to_alias','" . date('Y-m-d') . "','$total_amount','$transport','$docket','$ref_no','$main_sjo_number','$alias','6','$trans_id','$dispatch_date','$resengineer')");
					$remark_alias = aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
					mysqli_query($mr_con, "INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','MO','29','$alias','$emp_alias','$remark_alias')");
					$result['itemcount']="1";
					if($sql2){
						$resCode = '0';$resMsg = "Outward Successfully Done, Outward Transation ID is $trans_id";
						$xx=localURL()."services/inventory/mails/momails?a=".$alias;
						curlxing($xx);
						inventory_notification($alias,$historymessage,'5');
						user_history($emp_alias,$historymessage,$_REQUEST['ip_addr']);
					}else{$res = "Error In Updating";}
				}else{$result['itemcount']="0";}
			}
//From Warehouse to Site OR Warehouse to Warehouse
			elseif(isset($_REQUEST['itemTypes']) && count($_REQUEST['itemTypes'])>'0' && $conform=='1'){
				$ss=$ee=1;
				for($i=0;$i<count($_REQUEST['itemalias']);$i++){
					$req_qty=mysqli_real_escape_string($mr_con,$_REQUEST['req_qty'][$i]);
					if($_REQUEST['itemTypes'][$i]=='CELLS'){
						if(count($_REQUEST['cellnumbers'][$i])=='0' || $_REQUEST['cellnumbers'][$i][0]==''){$ee++;}
						//if($req_qty<count($_REQUEST['cellnumbers'][$i])){$ss++;}
					}else{
						if($_REQUEST['cellnumbers'][$i][0]==''){$ee++;}
						//if($req_qty<count($_REQUEST['cellnumbers'][$i])){$ss++;}
					}
				}
				if($ee==1){
					//if($ss==1){
						$total_amount=0;
						for($i=0;$i<count($_REQUEST['itemalias']);$i++){
							$product_alias=mysqli_real_escape_string($mr_con,$_REQUEST['itemalias'][$i]);
							if($_REQUEST['itemTypes'][$i]=='CELLS'){
								for($j=0;$j<count($_REQUEST['cellnumbers'][$i]);$j++){
									$cell_alias=mysqli_real_escape_string($mr_con,$_REQUEST['cellnumbers'][$i][$j]);
									$cell_condition=alias($cell_alias,'ec_total_cell','cell_alias','condition_id');
									
									if($materialToType=='1')mysqli_query($mr_con, "UPDATE ec_total_cell SET old_location=location,old_location_type=location_type,location='$to_alias',location_type='2',stage='1', site_stage='1', transDate='".date('Y-m-d')."' WHERE cell_alias='".$cell_alias."' AND flag=0");
									else mysqli_query($mr_con, "UPDATE ec_total_cell SET old_location=location,old_location_type=location_type,location='$to_alias',location_type='1',stage='1',transDate='".date('Y-m-d')."' WHERE cell_alias='".$cell_alias."' AND flag=0");
									
									mysqli_query($mr_con,"INSERT INTO ec_material_sent_details(item_type, item_code, item_description, item_condition, reference)VALUES('1','".$product_alias."','".$cell_alias."','".$cell_condition."','".$alias."')");
									
									if($materialToType=='1'){ $bucket='29';
										if($tt!='0'){
											mysqli_query($mr_con,"UPDATE ec_cell_required SET approved_stat='4', sent_quanty=(sent_quanty+1) WHERE ticket_alias='$tt' AND cell_alias='$product_alias' AND item_type='1' AND flag=0");
											$fv1=alias(alias($to_alias,'ec_sitemaster','site_alias','state_alias'),'ec_warehouse','state_alias','wh_alias');
											$sql_ch=mysqli_query($mr_con,"SELECT cell_alias FROM ec_total_cell WHERE location ='$fv1' AND stage='0' AND condition_id IN ('1','2') AND item_code='$product_alias' AND flag=0");
											if(request_items_bal_check($main_sjo_number) || mysqli_num_rows($sql_ch)=='0'){
												mysqli_query($mr_con,"UPDATE ec_tickets_inventory SET material_outward='2' WHERE ticket_alias='$tt' AND flag='0'");
											}
										}
										$historymessage="Cell Dispatched from \'".alias($from_wh,'ec_warehouse','wh_alias','wh_code')."\' to Site \'".alias($to_alias,'ec_sitemaster','site_alias','site_name')."\' Against Ticket ID: \'".alias($ref_no,'ec_tickets','ticket_alias','ticket_id')."\' through ".$transport." with Docket number: ".$docket;
									}elseif($materialToType=='3'){ $bucket='28';
										mysqli_query($mr_con,"UPDATE ec_request_items SET left_quanty=(left_quanty-1) WHERE mrf_alias='$ref_no' AND item_description='$product_alias' AND cell_type='".$_REQUEST['cell_type'][$i]."' AND item_type='1' AND flag='0'");
										$historymessage="Cell Dispatched from \'".alias($from_wh,'ec_warehouse','wh_alias','wh_code')."\' to Warehouse \'".alias($to_alias,'ec_warehouse','wh_alias','wh_code')."\' Against MRF Number: \'".alias($ref_no,'ec_material_request','mrf_alias','mrf_number')."\' through ".$transport." with Docket number: ".$docket;
									}
									
									cellhistoryinsert($cell_alias,$historymessage);
									$total_amount+=round(alias($cell_alias,'ec_item_code','item_code_alias','item_price'),2);
								}
							}
							
							if($_REQUEST['itemTypes'][$i]=='ACCESSORIES'){
								for($j=0;$j<count($_REQUEST['cellnumbers'][$i]);$j++){
									$cell_alias=mysqli_real_escape_string($mr_con,$_REQUEST['cellnumbers'][$i][$j]);
									
									mysqli_query($mr_con, "UPDATE ec_total_accessories SET old_location=location,old_location_type=location_type,location='$to_alias',location_type='2',stage='1' WHERE item_code='".$product_alias."' AND acc_alias='".$cell_alias."' AND flag='0'");
									mysqli_query($mr_con,"INSERT INTO ec_material_sent_details(item_type, item_code, item_description, item_condition, reference)VALUES('2','".$product_alias."','".$cell_alias."','1','".$alias."')");
									
									if($materialToType=='1'){ $bucket='29';
										if($tt!='0'){
											$re_sql=mysqli_query($mr_con,"SELECT left_quanty FROM ec_request_items WHERE item_description='$product_alias' AND mrf_alias='$ref_no' AND item_type='2' AND cell_type='1' AND flag='0'");
											$re_row=mysqli_fetch_array($re_sql); $left_quanty=$re_row['left_quanty'];
											mysqli_query($mr_con,"UPDATE ec_cell_required SET approved_stat='4', sent_quanty=(sent_quanty+$left_quanty) WHERE ticket_alias='$tt' AND cell_alias='$product_alias' AND item_type='2' AND flag=0");
											$fv1=alias(alias($to_alias,'ec_sitemaster','site_alias','state_alias'),'ec_warehouse','state_alias','wh_alias');
											$sql_ch=mysqli_query($mr_con,"SELECT acc_alias FROM ec_total_accessories WHERE location ='$fv1' AND good_qty!='0' AND item_code='$product_alias' AND flag=0");
											if(request_items_bal_check($main_sjo_number) || mysqli_num_rows($sql_ch)=='0'){
												mysqli_query($mr_con,"UPDATE ec_tickets_inventory SET material_outward='2' WHERE ticket_alias='$tt' AND flag='0'");
											}
										}
									}elseif($materialToType=='3'){ $bucket='28';
										mysqli_query($mr_con,"UPDATE ec_request_items SET left_quanty=(left_quanty-cappr_quanty) WHERE item_description='$product_alias' AND mrf_alias='$ref_no' AND item_type='2' AND flag='0'");
									}
									
									$total_amount+=round(alias($product_alias,'ec_accessories','accessories_alias','price'),2);
								}
							}
						}
						if(empty($historymessage)){
							if($materialToType=='1')$historymessage="Accessories Dispatched from \'".alias($from_wh,'ec_warehouse','wh_alias','wh_code')."\' to Site \'".alias($to_alias,'ec_sitemaster','site_alias','site_name')."\' Against Ticket ID: \'".alias($ref_no,'ec_tickets','ticket_alias','ticket_id')."\' through ".$transport." with Docket number: ".$docket;
							elseif($materialToType=='3')$historymessage="Accessories Dispatched from \'".alias($from_wh,'ec_warehouse','wh_alias','wh_code')."\' to Warehouse \'".alias($to_alias,'ec_warehouse','wh_alias','wh_code')."\' Against MRF Number: \'".alias($ref_no,'ec_material_request','mrf_alias','mrf_number')."\' through ".$transport." with Docket number: ".$docket;
							else $historymessage="";
						}
						$sql2=mysqli_query($mr_con,"INSERT INTO ec_material_outward(from_type,from_wh,to_wh,date_of_trans,totalamount,transport,docket,ref_no,sjo_number,alias,trans_id,dispatch_date,resp_engineer)VALUES('$materialToType','$from_wh','$to_alias','" . date('Y-m-d') . "','$total_amount','$transport','$docket','$ref_no','$main_sjo_number','$alias','$trans_id','$dispatch_date','$resengineer')");
						$remark_alias = aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
						mysqli_query($mr_con, "INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','MO','$bucket','$alias','$emp_alias','$remark_alias')");
						if($sql2){
							if($materialToType=='1'){
								list($ticket_id,$req_items)=explode("_@",request_desc_sms($main_sjo_number,"OUT"));
								$fam_msg1="Dear Team, New Material $req_items outward was done against $ticket_id, Make sure the replaced cell serial numbers are selected while filling e-FSR";
								$from_wh=alias($main_sjo_number,'ec_material_request','mrf_alias','from_wh');
								$state_alais = alias($from_wh,'ec_warehouse','wh_alias','state_alias');
								ecSendSms('mo_to_tt_number', $state_alias, "", $fam_msg1);
								/*
								foreach(sms_contacts($main_sjo_number,array("SE","ZHS","NHS","HO")) as $phnum1)messageSent($phnum1,$fam_msg1);	
								*/
							}elseif($materialToType=='3'){
								$qswed=alias($main_sjo_number,'ec_material_request','mrf_alias','status');
								if($qswed=='0')	mysqli_query($mr_con,"UPDATE ec_material_request SET last_updated = now(), status='2' WHERE mrf_alias='$main_sjo_number' AND flag=0");
								else mysqli_query($mr_con,"UPDATE ec_material_request SET last_updated = now(), status='4' WHERE mrf_alias='$main_sjo_number' AND flag=0");
								list($ticket_id,$req_items)=explode("_@",request_desc_sms($main_sjo_number,"CUST"));
								$fam_msg1="Dear Customer, Material request against $ticket_id, of $req_items dispatched by $transport with docket No. $docket, Kindly confirm back the receipt to 040-6704 6704 / service@enersys.co.in";
								$from_wh = alias($main_sjo_number,'ec_material_request','mrf_alias','from_wh');
								$state_alais = alias($from_wh,'ec_warehouse','wh_alias','state_alias');
								ecSendSms('mr_dispacted_customer_communication', $state_alias, "", $fam_msg1);		
								/*
								foreach(sms_contacts($main_sjo_number,array("CUST","HO")) as $phnum1)messageSent($phnum1,$fam_msg1);	
								*/
								$fam_msg2="Dear Team, Material $req_items are dispatched from factory against SJO Number ".alias($main_sjo_number,'ec_material_request','mrf_alias','sjo_number').", by $transport with docket No. $docket, Kindly confirm back the receipt.";
								$custNo = alias($main_sjo_number,'ec_material_request','mrf_alias','customer_phone');
								ecSendSms('mr_logistics_updated_dispatched_details', $state_alias, '', $fam_msg2);
								/*
								foreach(sms_contacts($main_sjo_number,array("SE","ZHS","NHS","HO","PPC")) as $phnum2)messageSent($phnum2,$fam_msg2);	
								*/
							}$resCode = '0';$resMsg = "Outward Successfully Done, Outward Transaction ID is $trans_id";
							/*if($materialToType=='2'){
								$action=$msg="Against the Dated ".date('d-m-Y')." Material Moved out from Factroy with Dispath Details";
							}else{
								if($materialToType=='3'){
									$action=$msg="Against the SJO Number ".alias($ref_no,'ec_material_request','mrf_alias','sjo_number')." Dated ".date('d-m-Y')." Received at field WH ".alias($to_wh,'ec_warehouse','wh_alias','wh_code')." and transported by $transport with Docket No. $docket.";
								}else{$action=$msg="Against the Dated ".date('d-m-Y')." Material dispached with transaction ID:$trans_id and transported by $transport with Docket No: $docket.";}
							}*/
							curlxing(localURL()."services/inventory/mails/momails?a=".$alias);
							inventory_notification($alias,$historymessage,'5');
							user_history($emp_alias,$historymessage,$_REQUEST['ip_addr']);
						}else{$res = "Error In Updating";}
					//}else{$res = "Requested quantity should greater than OR equal to selected quantity.";}
				}else{$res = "Please select atleast one cell serial numbers OR Accessories count can't be '0'";}
			}
//Scrap Cells From Warehouse to Factory
			elseif(isset($_REQUEST['scrapCellAlias']) && count($_REQUEST['scrapCellAlias'])>'0' && $conform=='1'){$erfdfdfgd=0;
				$total_amount=0;$ascdf=1;
				for($i=0;$i<count($_REQUEST['scrapCellAlias']);$i++){
					if($_REQUEST['sendx'][$i] =='1'){
						$cell_alias=mysqli_real_escape_string($mr_con,$_REQUEST['scrapCellAlias'][$i]);
						$product_alias=alias($cell_alias,'ec_item_code','item_code_alias','item_code');
						$cell_condition=alias($cell_alias,'ec_total_cell','cell_alias','condition_id');
						if($materialToType=='1') mysqli_query($mr_con, "UPDATE ec_total_cell SET old_location=location,old_location_type=location_type,location='$to_alias',location_type='2',stage='1', site_stage='1', transDate='".date('Y-m-d')."' WHERE cell_alias='".$cell_alias."' AND flag=0");
						else mysqli_query($mr_con, "UPDATE ec_total_cell SET old_location=location,old_location_type=location_type,location='$to_alias',location_type='0',stage='1',transDate='".date('Y-m-d')."' WHERE cell_alias='".$cell_alias."' AND flag=0");
						
						mysqli_query($mr_con,"INSERT INTO ec_material_sent_details(item_type, item_code, item_description, item_condition, reference)VALUES('1','".$product_alias."','".$cell_alias."','".$cell_condition."','".$alias."')");
						$historymessage="Cell Dispatched from \'".alias($from_wh,'ec_warehouse','wh_alias','wh_code')."\' to \'".alias($to_alias,'ec_warehouse','wh_alias','wh_code')."\' through ".$transport." with Docket number: ".$docket;
						cellhistoryinsert($cell_alias,$historymessage);
						$total_amount+=round(alias($cell_alias,'ec_item_code','item_code_alias','item_price'),2);
						$erfdfdfgd=1;
					}else $ascdf=0;
				}
				if($erfdfdfgd=='1'){
					$sql2=mysqli_query($mr_con,"INSERT INTO ec_material_outward(from_type,from_wh,to_wh,date_of_trans,totalamount,transport,docket,ref_no,sjo_number,alias,trans_id,dispatch_date,resp_engineer)VALUES('$materialToType','$from_wh','$to_alias','" . date('Y-m-d') . "','$total_amount','$transport','$docket','$ref_no','$main_sjo_number','$alias','$trans_id','$dispatch_date','$resengineer')");
					$remark_alias = aliasCheck(generateRandomString(),'ec_remarks','remark_alias');
					$sqlRem = mysqli_query($mr_con, "INSERT INTO ec_remarks(remarks,module,bucket,item_alias,remarked_by,remark_alias)VALUES('$remarks','MO','30','$alias','$emp_alias','$remark_alias')");
					if($sql2 && $sqlRem){$resCode = '0';$resMsg = "Outward Successfully Done, Outward Transation ID is $trans_id";
						if($ascdf=='1')mysqli_query($mr_con, "UPDATE ec_engineer_observation SET in_level='2' WHERE ticket_alias='".$ticket_alias15."'");
						/*if($materialToType=='2'){
							$action=$msg="Against the Dated ".date('d-m-Y')." Material Moved out from Factroy with transport $transport and Docket No. $docket.";
						}else{
							if($materialToType=='3'){
								$action=$msg="Against the SJO Number ".alias($ref_no,'ec_material_request','mrf_alias','sjo_number')." Dated ".date('d-m-Y')." Received at field WH ".alias($to_wh,'ec_warehouse','wh_alias','wh_code')." and transported by $transport with Docket No. $docket.";
							}else{$action=$msg="Against the Dated ".date('d-m-Y')." Material dispached with transaction ID:$trans_id and transported by $transport with Docket No: $docket.";}
						}*/
						$item_req = mysqli_query($mr_con,"SELECT COUNT(id) AS cnt,item_type,item_code FROM ec_material_sent_details WHERE reference='$alias' AND flag='0' GROUP BY item_code");
						if(mysqli_num_rows($item_req)){ $item_desc="";
							while($row_req=mysqli_fetch_array($item_req)){
								if($row_req['item_type']=='1')$item_desc.=alias($row_req['item_code'],'ec_product','product_alias','product_description')."- ".$row_req['cnt']." Cells, ";
								else $item_desc.=alias($row_req['item_code'],'ec_accessories','accessories_alias','accessory_description')."- ".$row_req['cnt']." Accessories, ";
							}
							$fam_msg1="Dear Team, Scrap Material ".rtrim($item_desc,",")." are booked from Warehouse ".alias($from_wh,'ec_warehouse','wh_alias','wh_code')." to Factory by $transport with Docket No- $docket, Kindly confirm back the receipt.";
							/*
							foreach(sms_contacts($main_sjo_number,array("NHS","TS","HO","STORES","LOGISTICS")) as $phnum1)messageSent($phnum1,$fam_msg1);	
							*/
							$from_wh=alias($main_sjo_number,'ec_material_request','mrf_alias','from_wh');
							$state_alais = alias($from_wh,'ec_warehouse','wh_alias','state_alias');
							ecSendSms('mo_by_zhs_to_factory', $state_alias, "", $fam_msg1);
						}
						curlxing(localURL()."services/inventory/mails/momails?a=".$alias);
						inventory_notification($alias,$historymessage,'5');
						user_history($emp_alias,$historymessage,$_REQUEST['ip_addr']);
					}else{$res = "Error In Updating";}
				}else {$resCode = '1';$resMsg= 'No Items Selected for Outwards';}
			}else {$resCode = '1';$resMsg= 'No Items Selected for Outwards';}
			
		//Mail Should come here
		}
	}elseif($rex == 1){$resCode = '1';$resMsg='Authentication Failed';}
	else{$resCode='2';$resMsg='Account Locked';}
	if(isset($res)){$resCode='4';$resMsg=$res;}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}
function material_outward_multi(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	$whouse=getempwarehouse($emp_alias);
	if($rex==0){
		if(grantable('SPECIAL','MATERIAL OUTWARD',$emp_alias) && !admin_privilege($emp_alias)){
			$from_to = "to_wh";
			$wh_ext = "";
		}else{
			$from_to = "from_wh";
			$wh_ext = "AND wh_alias IN ($whouse)";
		}
		if($_REQUEST['mrfnumber']!="")$tid="trans_id LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['mrfnumber'])."%' AND ";else $tid="";
		if($_REQUEST['fwh']!="")$ld="from_wh IN (SELECT wh_alias FROM ec_warehouse WHERE wh_code LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['fwh'])."%' $wh_ext) AND ";else $ld="";
		if($_REQUEST['towh']!=""){
			$twh=mysqli_real_escape_string($mr_con,$_REQUEST['towh']);
			if(strpos('BUFFER',strtoupper($twh))!==false)$aa="to_wh ='2609' AND ";
			else $aa="to_wh IN (SELECT wh_alias FROM ec_warehouse WHERE wh_code LIKE '%$twh%' UNION ALL SELECT site_alias FROM ec_sitemaster WHERE site_name LIKE '%$twh%') AND ";
		}else $aa="";
		if($_REQUEST['mdate']!="")$sa="date_of_trans ='".dateFormat(mysqli_real_escape_string($mr_con,$_REQUEST['mdate']),'y')."' AND ";else $sa="";
		if($_REQUEST['mvalue']!="")$sid="totalamount LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['mvalue'])."%' AND ";else $sid="";
		if($_REQUEST['sjonumber']!="")$sjn=(strpos("NON SJO",strtoupper($_REQUEST['sjonumber']))!==false ? "sjo_number IN('','0')" : "sjo_number IN (SELECT mrf_alias FROM ec_material_request WHERE sjo_number LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['sjonumber'])."%')")." AND ";else $sjn="";
		if($_REQUEST['ticket_id']!=""){
			$ticket_id = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['ticket_id']));
			$sub = (strpos("BUFFER",$ticket_id)!==false ? TRUE : FALSE);
			$ttn="(from_type='3' AND sjo_number IN(SELECT mrf_alias FROM ec_material_request WHERE ticket_alias IN(".($sub ? "'2609'" : "SELECT ticket_alias FROM ec_tickets WHERE ticket_id LIKE '%".$ticket_id."%' ")."))) OR (from_type='1' AND ( ".($sub ? "to_wh='2609' OR " : "")."ref_no IN(SELECT ticket_alias FROM ec_tickets WHERE ticket_id LIKE '%".$ticket_id."%' ))) AND ";
		}else $ttn="";
		if($_REQUEST['level']!="")$level="status='".mysqli_real_escape_string($mr_con,$_REQUEST['level'])."' AND ";else $level="";
		$condtion=$ld.$aa.$tid.$sa.$sid.$sjn.$ttn.$level;
		$rec=mysqli_query($mr_con,"SELECT COUNT(id) FROM ec_material_outward WHERE $condtion flag=0 AND $from_to IN ($whouse)");
		if(mysqli_num_rows($rec)>0){
			$row=mysqli_fetch_array($rec);
			$totalRecords=$row[0];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$outwardQuery = "SELECT from_type,from_wh,ref_no, to_wh, date_of_trans, totalamount, status, ref_no, sjo_number, alias, trans_id FROM ec_material_outward WHERE $condtion flag=0 AND $from_to IN ($whouse) ORDER BY id DESC LIMIT $offset, $limit";
			$sqlTT = mysqli_query($mr_con, $outwardQuery);
			$result['requestDetails']=array();
			if(mysqli_num_rows($sqlTT)){
				$i=0;while($rowTT = mysqli_fetch_array($sqlTT)){$site_nm_dis=false;
					$result['requestDetails'][$i]['mrf_alias']=$rowTT['alias'];
					$result['requestDetails'][$i]['mrfnumber']=$rowTT['trans_id'];
					$result['requestDetails'][$i]['dateofrequest']=$rowTT['date_of_trans'];
					list($mrf_number,$sjo_number,$ticket_id)=explode("@",out_m_s_t($rowTT['from_type'],$rowTT['to_wh'],$rowTT['ref_no'],$rowTT['sjo_number']));
					$result['requestDetails'][$i]['ticket_id']=$ticket_id;
					$result['requestDetails'][$i]['sjonumber']=$sjo_number;
					$result['requestDetails'][$i]['fromwh']=alias($rowTT['from_wh'],'ec_warehouse','wh_alias','wh_code');
					if($rowTT['to_wh']=='2609')$result['requestDetails'][$i]['towh']="BUFFER";
					elseif($rowTT['from_type']=='2')$result['requestDetails'][$i]['towh']="FACTORY";
					elseif($rowTT['from_type']=='1')$result['requestDetails'][$i]['towh']=alias($rowTT['to_wh'],'ec_sitemaster','site_alias','site_name');
					else $result['requestDetails'][$i]['towh']=alias($rowTT['to_wh'],'ec_warehouse','wh_alias','wh_code');
					$result['requestDetails'][$i]['levelcolor']=outward_nm_clr($rowTT['status'],"color");
					$result['requestDetails'][$i]['levelname']=outward_nm_clr($rowTT['status'],"name");
					$result['requestDetails'][$i]['materialvalue']=$rowTT['totalamount'];
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
	if($totalRecords>=1)
		for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x;
	else $result['pages'][1]=1;
	$result['add']=grantable('ADD','MATERIAL OUTWARD',$emp_alias);
	$result['splEdit']=grantable('ADV EDIT','MATERIAL OUTWARD',$emp_alias);
	$result['delete']=grantable('DELETE','MATERIAL OUTWARD',$emp_alias);
	$result['export']=grantable('EXPORT','MATERIAL OUTWARD',$emp_alias);
	echo json_encode($result);
}
function material_outward_single_view(){ 
	global $mr_con;
	$emp_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$token=mysqli_real_escape_string($mr_con,trim($_REQUEST['token']));
	$alias= mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$sql = mysqli_query($mr_con,"SELECT status, resp_engineer, from_type, from_wh, sjo_number, to_wh, date_of_trans, totalamount, transport, docket, dispatch_date, ref_no, alias, trans_id FROM ec_material_outward WHERE alias ='$alias' AND flag=0");
		if(mysqli_num_rows($sql)){
			while($row=mysqli_fetch_array($sql)){
				$result['trans_id']=$row['trans_id'];
				if($row['to_wh']=='2609')$result['to_wh']="Buffer";
				elseif($row['from_type']=='1')$result['to_wh']=alias($row['to_wh'],'ec_sitemaster','site_alias','site_name');
				else $result['to_wh']=alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code');
				$road_permit = alias($row['to_wh'],'ec_warehouse','wh_alias','road_permit');
				$result['road_permit']=($road_permit!='' ? ($road_permit=='1' ? 'REQUIRED' : ' NOT REQUIRED') : 'NA');
				$result['from_type']=$row['from_type'];
				$result['from_wh']=alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code');
				$result['from_wh_alias']=$row['from_wh'];
				$result['to_wh_alias']=$row['to_wh'];
				$result['date_of_request']=dateFormat($row['date_of_trans'],'d');
				$result['material_value']=$row['totalamount'];
				$result['status']=outward_nm_clr($row['status'],"name");
				$result['status_code']=$row['status'];
				$result['trans_alias']=$row['alias'];
				$result['transport_no']=$row['transport'];
				$result['docket_no']=$row['docket'];
				$result['admin_priv']=($emp_alias=='ADMIN' ? TRUE : FALSE);
				$result['dispatch_date']=dateFormat($row['dispatch_date'],'d');
				$result['resp_engineer_alias']=$row['resp_engineer'];
				$result['resp_engineer']=checkempty(alias($row['resp_engineer'],'ec_employee_master','employee_alias','name'));
				list($mrf_number,$sjo_number,$ticket_id)=explode("@",out_m_s_t($row['from_type'],$row['to_wh'],$row['ref_no'],$row['sjo_number']));
				$result['mrf_number']=$mrf_number;
				$result['sjo']=$sjo_number;
				$result['ticket_id']=$ticket_id;
				// $sql1 = mysqli_query($mr_con,"SELECT item_type, item_code, item_description, item_condition FROM ec_material_sent_details WHERE reference='$alias' AND flag=0");
				$sql1 = mysqli_query($mr_con,"SELECT mrd.id, mrd.item_type, mrd.item_code, mrd.item_description, mrd.item_condition, (SELECT count(*) from ec_material_received_details WHERE item_description = mrd.item_description) as count FROM ec_material_sent_details as mrd WHERE reference='$alias' AND flag=0");
				$partialEdit = false;
				$editTT = false;
				if($result['to_wh_alias'] == 'XVX6AZ4VHT' || $result['from_wh_alias'] == 'XVX6AZ4VHT') { // from wh or to wh is factory 
					if($result['from_wh_alias'] == 'XVX6AZ4VHT') {
						$partialEdit = true;
					} else {
						if($result['status_code'] == 6) { // Closed
							$partialEdit = true;
						}
					}
				} else {
					if($result['status_code'] == 4) { // Undertransit
						$editTT = true;
					} else { // partially closed or closed
						$partialEdit = true;	
					}
				}
				$result['partialEdit'] = $partialEdit;
				$result['editTT'] = $editTT;
				if(mysqli_num_rows($sql1)){
					$i=0;
					while($row1=mysqli_fetch_array($sql1)){
						$result['request_items'][$i]['id']=$row1['id'];
						if ($row1['item_type']=='1') {
	$result['request_items'][$i]['allowconditionUpdate'] = outwardConditionCellUpdate($row1['item_description'], $row['to_wh']);
						} else {
	$result['request_items'][$i]['allowconditionUpdate'] = outwardConditionAccUpdate($row1['item_description'], $row['to_wh']);
						}
						$result['request_items'][$i]['item_type']=$row1['item_type'];
						$result['request_items'][$i]['item_code_alias']=$row1['item_code'];
						$result['request_items'][$i]['item_condition']=$row1['item_condition'];
						$result['request_items'][$i]['item_description']=alias($row1['item_description'],'ec_item_code','item_code_alias','item_description');
						$result['request_items'][$i]['item_description_alias']=$row1['item_description'];
						if($row1['item_type']=='1'){
							$item_code=alias($row1['item_code'],'ec_product','product_alias','product_description');
							$item_condition=alias($row1['item_condition'],'ec_stock','stock_alias','description');
						}else{
							$item_code=alias($row1['item_code'],'ec_accessories','accessories_alias','accessory_description');
							$item_condition=gd_dm_view_count($row1['item_description'],'1');
						}
						$result['request_items'][$i]['item_code']=$item_code;
						// $result['request_items'][$i]['item_condition']=$item_condition;
						$result['request_items'][$i]['condition']=($row1['item_type']=='1' ? alias($row1['item_condition'],'ec_stock','stock_alias','description'):gd_dm_view_count($row1['item_description'],'1'));
						$i++;
					}
				} else {
					$result['request_length'] = mysqli_num_rows($sql1);
				}
				$sql2 = mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE item_alias ='$alias' AND module='MO' AND flag=0");
				if(mysqli_num_rows($sql2)){
					$i=0;
					while($row2=mysqli_fetch_array($sql2)){
						$result['remark'][$i]['remarks']=$row2['remarks'];
						$result['remark'][$i]['remarked_by']=(strtoupper($row2['remarked_by'])=="ADMIN" ? "ADMIN" : alias($row2['remarked_by'],'ec_employee_master','employee_alias','name'));
						$result['remark'][$i]['remarked_on']=dateFormat($row2['remarked_on'],'d');
						$result['remark'][$i]['remark_alias']=$row2['remark_alias'];
						$result['remark'][$i]['remarked_by_alias'] = strtoupper($row2['remarked_by']);
						$i++;
					}
				} else {
					$result['remark_length'] = mysqli_num_rows($sql2);
				}
			}$result['edit']=grantable('EDIT','MATERIAL OUTWARD',$emp_alias);
		}else{$resCode='4';$resMsg='No Records Found!';}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function checkEfsrSubmited($ticketId) {
	global $mr_con;
	$ttQuery = "SELECT ticket_id, efsr_no, efsr_date, site_alias FROM ec_tickets WHERE ticket_alias='$ticketId'";
	$result = [
		'status' => false,
		'msg' => "",
	];
	$ttSql = mysqli_query($mr_con, $ttQuery);
	$ttDetails = mysqli_fetch_array($ttSql);
	if(isset($ttDetails['efsr_no']) && $ttDetails['efsr_no'] != '') {
		$siteName = alias($ttDetails['site_alias'], 'ec_sitemaster', 'site_alias', 'site_name');
		$res = "These item can't be deleted as they are dispatch to site ". $siteName .". Please refer " . $ttDetails['ticket_id'] . ".";
		$result['status'] = true;
		$result['msg'] = $res;
	}
	return $result;
}

function material_outward_check_delete_status() {
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$mOQuery = "SELECT * FROM ec_material_outward WHERE alias = '$alias'";
			$mOSql = mysqli_query($mr_con, $mOQuery);
			$mODetails = mysqli_fetch_array($mOSql);
			if($mODetails['id']) {
				if($mODetails['status'] == 0) { // PARTIALLY CLOSED
					$res = "Partially closed materials cannot be deleted";
				} elseif($mODetails['status'] == 4) { // UNDER TRANSIT
					// Can be deleted
				} elseif($mODetails['status'] == 6) { // CLOSED
					$res = "Closed materials cannot be deleted";
					/*
					if($mODetails['from_wh'] == 'XVX6AZ4VHT' || $mODetails['to_wh'] == 'XVX6AZ4VHT') { // from wh or to wh is Factory
						$mIQuery = "SELECT mi.alias, mi.from_wh, mi.to_wh, mi.trans_id, wh.wh_address FROM ec_material_inward as mi, ec_warehouse as wh WHERE mi.sjo_number = '". $mODetails['sjo_number'] ."' AND mi.from_wh = '". $mODetails['from_wh'] ."' AND mi.to_wh = '". $mODetails['to_wh'] ."' AND mi.from_wh = wh.wh_alias AND  mi.flag = 0 ";
						$mISql = mysqli_query($mr_con, $mIQuery);
						if(mysqli_num_rows($mISql) > 0 ) {
							$mIDetails = mysqli_fetch_array($mISql);
							$res = "These item can't be deleted as they are dispatch from " . $mIDetails['wh_address'] . ". Please refer " . $mIDetails['trans_id'] . " in material inwards.";
						}
					} else {
						$ttQuery = "SELECT ticket_id, efsr_no, efsr_date, site_alias FROM ec_tickets WHERE ticket_alias='". $mODetails['ref_no'] ."'";
						$ttSql = mysqli_query($mr_con, $ttQuery);
						$ttDetails = mysqli_fetch_array($ttSql);
						if(isset($ttDetails['efsr_no']) && $ttDetails['efsr_no'] != '') {
							$siteName = alias($ttDetails['site_alias'], 'ec_sitemaster', 'site_alias', 'site_name');
							$res = "These item can't be deleted as they are dispatch from " . $mODetails['from_wh'] . " to site ". $siteName .". Please refer " . $ttDetails['ticket_id'] . ".";
						}
					}
					*/
				} else { // Not valid
					$res = "Invalid Request";
				}
			} else {
				$res = "Invalid Request";
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function material_outward_item_delete() {
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$remarks = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['remarks'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		$item_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['item_alias'])));
		$item_type = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['item_type'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$location = alias($alias, 'ec_material_outward', 'alias', 'from_wh');
			$msdQuery = "UPDATE ec_material_sent_details set flag = 9 WHERE reference = '$alias' AND item_description = '$item_alias'";
			$msdSql = mysqli_query($mr_con, $msdQuery);
			$item = "";
			if($item_type == 1) {
				$tcQuery = "UPDATE ec_total_cell set `location` = '$location', location_type = '1', stage = '0' WHERE cell_alias = '$item_alias'";
				$tcSql = mysqli_query($mr_con, $tcQuery);
				$item = "Cell";
			} else {
				$tcQuery = "UPDATE ec_total_accessories set `location` = '$location', location_type = '1', stage = '0' WHERE acc_alias = '$item_alias'";
				$tcSql = mysqli_query($mr_con, $tcQuery);
				$item = "Accessory";
			}
			if($msdSql) {
				$trans_id = alias($alias, 'ec_material_outward', 'alias', 'trans_id');
				$action = "Removed $item from material outward $trans_id";
				user_history($emp_alias, $action, $_REQUEST['ip_addr'], $remarks);
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function material_outward_delete() {
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['emp_alias'])));
	$remarks = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['remarks'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	if($rex==0) {
		$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($_REQUEST['alias'])));
		if(empty($alias)) {
			$res="Invalid Request";
		} else if(empty($remarks)) {
			$res="Pleas Provide Remarks";
		} else {
			$mOQuery = "SELECT * FROM ec_material_outward WHERE alias = '$alias'";
			$mOSql = mysqli_query($mr_con, $mOQuery);
			$mODetails = mysqli_fetch_array($mOSql);
			if($mODetails['id']) {
				if($mODetails['status'] == 0) { // PARTIALLY CLOSED
					$res = "Partially closed materials cannot be deleted";
				} elseif($mODetails['status'] == 4) { // UNDER TRANSIT
					// Change status to dispatch pending
					$location = $mODetails['from_wh'];
					$lType = 1;
					if($location == 'XVX6AZ4VHT') {
						$lType = 0;
					}
					$query = "UPDATE ec_total_accessories set location = '$location', stage = '0', location_type = '$lType' WHERE acc_alias in (SELECT item_description FROM ec_material_sent_details WHERE reference = '$alias' and flag = 0)";
					mysqli_query($mr_con, $query);
					$query = "UPDATE ec_total_cell set location = '$location', stage = '0', location_type = '$lType'  WHERE cell_alias in (SELECT item_description FROM ec_material_sent_details WHERE reference = '$alias' and flag = 0)";
					mysqli_query($mr_con, $query);
					if($mODetails['from_wh'] == 'XVX6AZ4VHT') {
						$mrQuery = "UPDATE ec_material_request SET last_updated = now(), status = '3' where mrf_alias = '" . $mODetails['sjo_number'] . "'";
						mysqli_query($mr_con, $mrQuery);
					}
				} elseif($mODetails['status'] == 6) { // CLOSED
					$res = "Closed materials cannot be deleted";
				}
				if(empty($res)) {
					$delMO = "UPDATE ec_material_outward set flag = 9 WHERE alias = '". $alias ."'";
					$delMaterialRec = "UPDATE ec_material_sent_details set flag = 9 WHERE reference = '". $alias ."'";
					mysqli_query($mr_con, $delMaterialRec);
					if(!mysqli_query($mr_con, $delMO) ) {
						$res = "Failed to delete material outwards.";
					} else {
						$name = alias($alias,'ec_material_outward','alias','trans_id');
						$action = "Delete material outward - " . $name;
						user_history($emp_alias, $action, $_REQUEST['ip_addr'], $remarks);
					}
				}
			}
			$resCode='0';
			$resMsg='Successful!';
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}
//Material Outwards Service Ends
/*function fresh_finance($ref){ global $mr_con;
	$pre_y=date('Y',strtotime("-1 year"))."-".date('y');
	$nxt_y=date('Y')."-".date('y',strtotime("+1 year"));
	//$year = ((date('m') < 4) ? $pre_y : $nxt_y);
	$new_finance_year=alias($nxt_y,'ec_financial_archive','fy_year','id');
	return (!empty($new_finance_year) ? "$ref>='".date('Y-03-31')."' AND $ref<='".date('Y-04-31',strtotime("+1 year"))."' AND ":($pre_y!='2016-17' ? "$ref>='".date('Y-03-31',strtotime("-1 year"))."' AND $ref<='".date('Y-04-31')."' AND ":""));
}*/
//finance_archive Starts
function finance_archive(){global $mr_con;
	set_time_limit(0);
	ini_set('memory_limit', '1024M');
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$finance_year0=date('Y',strtotime("-2 year"))."-".date('y',strtotime("-1 year"));
		$finance_year1=date('Y',strtotime("-1 year"))."-".date('y');
		$finance_year2=date('Y')."-".date('y',strtotime("+1 year"));
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Enersys")->setLastModifiedBy("Enersys")->setTitle("Office 2007 XLSX Finacial Year Balance Document")->setSubject("Office 2007 XLSX Tickets Document")->setDescription("Tickets document for Office 2007 XLSX, generated using PHP classes.");
		$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
		$financial_alias = aliasCheck(generateRandomString(),'ec_financial_archive','alias');
		$fct_wh=alias('1','ec_warehouse','wh_type','wh_alias');
//Material Balance
		$no_rec = $sh_index = 0;
		$open_count_t=$new_count_t=$revived_count_t=$scrap_count_t=$dispute_count_t=$Revival_count_t=$total_count_t=$transit_t=$outstandcount_t=0;
		$objPHPExcel->setActiveSheetIndex($sh_index);
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setTitle('Material Balance For Cells');
		$whsql=mysqli_query($mr_con,"SELECT COUNT(id) AS cnn,GROUP_CONCAT('''',wh_alias,'''') AS wh_temp FROM ec_warehouse WHERE flag=0");
		$whrow=mysqli_fetch_array($whsql);
		$whouse=(empty($whrow['cnn']) ? "''" : $whrow['wh_temp']);
		//$whouse=getempwarehouse($emp_alias);
		$colArr=array('Product Name','Opening Balance','New Count','Revived Count','Scrap Count','Dispute Count','Revival Count','Under Transit','Total Count','Outstand Count');
		$last_key = end(array_keys($colArr));
		$last_alpha = num2alpha($last_key);
		$sheet->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
		$sheet->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
		$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue)); $ch++; }
		$al_limt=array();
		$bq1=mysqli_query($mr_con,"SELECT jm2.item_code FROM ec_material_outward jm1 INNER JOIN ec_material_sent_details jm2 ON jm1.alias=jm2.reference WHERE jm1.from_wh IN ($whouse) AND jm2.item_type='1' GROUP BY jm2.item_code");
		$bq2=mysqli_query($mr_con,"SELECT jm2.item_code FROM ec_material_inward jm1 INNER JOIN ec_material_received_details jm2 ON jm1.alias=jm2.reference WHERE jm1.to_wh IN ($whouse) AND jm2.item_type='1' GROUP BY jm2.item_code");
		if(mysqli_num_rows($bq1)>'0'){while($rq1=mysqli_fetch_array($bq1)){$al_limt[]=$rq1['item_code'];}}
		if(mysqli_num_rows($bq2)>'0'){while($rq2=mysqli_fetch_array($bq2)){$al_limt[]=$rq2['item_code'];}}
		$product_alias=array_unique($al_limt);
		if(count($product_alias)>'0'){
			for($m=0,$coo=1;$m<count($product_alias);$m++){$coo++;
				$sql_sub_o=mysqli_query($mr_con,"SELECT outstanding FROM ec_financial_archive_sub WHERE fy_year='".(date('m')<'4' ? $finance_year0 : $finance_year1)."' AND product_alias='".$product_alias[$m]."' AND flag='0'");
				if(mysqli_num_rows($sql_sub_o)){$row_o = mysqli_fetch_array($sql_sub_o);$open = $row_o['outstanding'];}else $open = '0';
				$a=countcellslist($product_alias[$m],$whouse,'1');
				$b=countcellslist($product_alias[$m],$whouse,'2');
				$c=countcellslist($product_alias[$m],$whouse,'3|4');
				$d=countcellslist($product_alias[$m],$whouse,'7');
				$e=countcellslist($product_alias[$m],$whouse,'5|6');
				$f=countcellslist($product_alias[$m],$whouse,'0');
				$g=$a+$b+$c+$d+$e+$f;
				$i=outstandcounts($product_alias[$m],$whouse);
				$sql_sub=mysqli_query($mr_con,"INSERT INTO ec_financial_archive_sub(fy_year,product_alias,outstanding,reference)VALUES('$finance_year1','".$product_alias[$m]."','$i','$financial_alias')");
				$sheet->SetCellValue('A'.$coo, alias($product_alias[$m],'ec_product','product_alias','product_description'))
						->SetCellValue('B'.$coo, $open)
						->SetCellValue('C'.$coo, $a)
						->SetCellValue('D'.$coo, $b)
						->SetCellValue('E'.$coo, $c)
						->SetCellValue('F'.$coo, $d)
						->SetCellValue('G'.$coo, $e)
						->SetCellValue('H'.$coo, $f)
						->SetCellValue('I'.$coo, $g)
						->SetCellValue('J'.$coo, $i);
				$open_count_t+=$open;
				$new_count_t+=$a;
				$revived_count_t+=$b;
				$scrap_count_t+=$c;
				$dispute_count_t+=$d;
				$Revival_count_t+=$e;
				$transit_t+=$f;
				$total_count_t+=$g;
				$outstandcount_t+=$i;
				$last_total = $coo;
			}
			$last_total = $last_total+1;
			$sheet->getStyle("A".$last_total.":J".$last_total)->applyFromArray($styleArray);
			$sheet->getStyle("A".$last_total.":J".$last_total)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$sheet->SetCellValue('A'.$last_total, 'Grand Total')
					->SetCellValue('B'.$last_total, $open_count_t)
					->SetCellValue('C'.$last_total, $new_count_t)
					->SetCellValue('D'.$last_total, $revived_count_t)
					->SetCellValue('E'.$last_total, $scrap_count_t)
					->SetCellValue('F'.$last_total, $dispute_count_t)
					->SetCellValue('G'.$last_total, $Revival_count_t)
					->SetCellValue('H'.$last_total, $transit_t)
					->SetCellValue('I'.$last_total, $total_count_t)
					->SetCellValue('J'.$last_total, $outstandcount_t);
			$no_rec++;
		}$sh_index++;

//ACCESSORIES
		if($sh_index>0)$objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex($sh_index);
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setTitle('Material Bal For Accessories');
		$product_alias_acc=$good_count=$damaged_count=$lost_count=array();
		$bq1=mysqli_query($mr_con,"SELECT item_code,SUM(good_qty) as good,SUM(damaged_qty) as damaged,SUM(lost_qty) as lost FROM ec_total_accessories WHERE location IN ($whouse) AND stage='0' AND location_type IN ('0','1') AND ".open_date("transDate")." flag='0' GROUP BY item_code");
		if(mysqli_num_rows($bq1)>'0'){while($rq1=mysqli_fetch_array($bq1)){$product_alias_acc[]=$rq1['item_code'];$good_count[]=$rq1['good'];$damaged_count[]=$rq1['damaged'];$lost_count[]=$rq1['lost']; }}
		if(count($product_alias_acc)>'0'){
			$colArr1=array('Accessory Name','Good Quantity','Damaged Quantity','Lost Quantity','Total');
			$last_key1 = end(array_keys($colArr1));
			$last_alpha1 = num2alpha($last_key1);
			$sheet->getStyle('A1:'.$last_alpha1."1")->applyFromArray($styleArray);
			$sheet->getStyle('A1:'.$last_alpha1."1")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
			$ch = 'A'; foreach($colArr1 as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue)); $ch++; }
			$good_count_t=$damaged_count_t=$lost_count_t=$total_count_t=0;
			for($m=0,$coo=1;$m<count($product_alias_acc);$m++){$coo++;
				$total_count = $good_count[$m]+$damaged_count[$m]+$lost_count[$m];
				$sheet->SetCellValue('A'.$coo, alias($product_alias_acc[$m],'ec_accessories','accessories_alias','accessory_description'))
						->SetCellValue('B'.$coo, $good_count[$m])
						->SetCellValue('C'.$coo, $damaged_count[$m])
						->SetCellValue('D'.$coo, $lost_count[$m])
						->SetCellValue('E'.$coo, $total_count);
				$good_count_t+=$good_count[$m];
				$damaged_count_t+=$damaged_count[$m];
				$lost_count_t+=$lost_count[$m];
				$total_count_t+=$total_count;
				$last_total = $coo;
			}
			$last_total = $last_total+1;
			$sheet->getStyle("A".$last_total.":E".$last_total)->applyFromArray($styleArray);
			$sheet->getStyle("A".$last_total.":E".$last_total)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$sheet->SetCellValue('A'.$last_total, 'Grand Total')
					->SetCellValue('B'.$last_total, $good_count_t)
					->SetCellValue('C'.$last_total, $damaged_count_t)
					->SetCellValue('D'.$last_total, $lost_count_t)
					->SetCellValue('E'.$last_total, $total_count_t);
			$no_rec++;
		}$sh_index++;

//Inward Balance
		$c_from_fact_t=$c_from_field_t=$c_from_branch_t=$c_total_count_t=$a_from_fact_t=$a_from_field_t=$a_from_branch_t=$a_total_count_t=0;
		if($sh_index>0)$objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex($sh_index);
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setTitle('Inward Balance');
		$colArr=array('Product Name','Product Type','From Factory','From Field','From Branch','Total');
		$last_key = end(array_keys($colArr));
		$last_alpha = num2alpha($last_key);
		$sheet->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
		$sheet->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
		$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue)); $ch++; }
		$bal_query=mysqli_query($mr_con,"SELECT DISTINCT item_code,item_type FROM ec_material_received_details WHERE reference IN (SELECT alias FROM ec_material_inward WHERE to_wh IN ($whouse) AND flag='0')");
		if(mysqli_num_rows($bal_query)>'0'){
			while($bal_row=mysqli_fetch_array($bal_query)){$product_alias_a[]=$bal_row['item_code'];$itm_code[]=$bal_row['item_type'];}
			for($m=0,$coo=1;$m<count($product_alias_a);$m++){$coo++;
				$a=inwardcellslist($product_alias_a[$m],$whouse,'','3');
				$b=inwardcellslist($product_alias_a[$m],$whouse,'','1|2');
				$c=inwardcellslist($product_alias_a[$m],$whouse,'','4');
				$d=$a+$b+$c;
				if($itm_code[$m]=='1'){ //Cells
					$item_desc = alias($product_alias_a[$m],'ec_product','product_alias','product_description');
					$item_type = "CELLS";
					$c_from_fact_t+=$a;
					$c_from_field_t+=$b;
					$c_from_branch_t+=$c;
					$c_total_count_t+=$d;
				}else{ //Accessories
					$item_desc = alias($product_alias_a[$m],'ec_accessories','accessories_alias','accessory_description');
					$item_type = "ACCESSORIES";
					$a_from_fact_t+=$a;
					$a_from_field_t+=$b;
					$a_from_branch_t+=$c;
					$a_total_count_t+=$d;
				}
				$sheet->SetCellValue('A'.$coo, $item_desc)
						->SetCellValue('B'.$coo, $item_type)
						->SetCellValue('C'.$coo, $a)
						->SetCellValue('D'.$coo, $b)
						->SetCellValue('E'.$coo, $c)
						->SetCellValue('F'.$coo, $d);
				$last_total = $coo;
				
			}
			//Total Cells
			$last_total = $last_total+1;
			$sheet->getStyle("A".$last_total.":F".$last_total)->applyFromArray($styleArray);
			$sheet->getStyle("A".$last_total.":F".$last_total)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$sheet->SetCellValue('A'.$last_total, 'Grand Total')
					->SetCellValue('B'.$last_total, 'CELLS')
					->SetCellValue('C'.$last_total, $c_from_fact_t)
					->SetCellValue('D'.$last_total, $c_from_field_t)
					->SetCellValue('E'.$last_total, $c_from_branch_t)
					->SetCellValue('F'.$last_total, $c_total_count_t);
			//Total Accessories
			$last_total = $last_total+1;
			$sheet->getStyle("A".$last_total.":F".$last_total)->applyFromArray($styleArray);
			$sheet->getStyle("A".$last_total.":F".$last_total)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$sheet->SetCellValue('A'.$last_total, 'Grand Total')
					->SetCellValue('B'.$last_total, 'ACCESSORIES')
					->SetCellValue('C'.$last_total, $a_from_fact_t)
					->SetCellValue('D'.$last_total, $a_from_field_t)
					->SetCellValue('E'.$last_total, $a_from_branch_t)
					->SetCellValue('F'.$last_total, $a_total_count_t);
			$no_rec++;
			
		}$sh_index++;


//Outward Balance
		$c_new_2_field_t=$c_new_2_branch_t=$c_rev_2_field_t=$c_rev_2_branch_t=$c_scrap_2_fact_t=$c_total_count_t=$a_new_2_field_t=$a_new_2_branch_t=$a_rev_2_field_t=$a_rev_2_branch_t=$a_scrap_2_fact_t=$a_total_count_t=0;
		if($sh_index>0){ $objPHPExcel->createSheet(); }
		$objPHPExcel->setActiveSheetIndex($sh_index);
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setTitle('Outward Balance');
		$colArr=array('Product Name','Product Type','New to Field','New to Branch','Revived to Field','Revived to Branch','Scrap to Factory','Total');
		$last_key = end(array_keys($colArr));
		$last_alpha = num2alpha($last_key);
		$sheet->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
		$sheet->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
		$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue)); $ch++; }
		//$bal_query_lim=mysqli_query($mr_con,"SELECT DISTINCT item_code,item_type FROM ec_material_sent_details WHERE reference IN (SELECT alias FROM ec_material_outward WHERE from_wh IN ($whouse) AND ".open_date("date_of_trans")." flag='0')");
		$bal_query_lim=mysqli_query($mr_con,"SELECT t2.item_type,t2.item_code,
				COUNT(CASE WHEN t2.item_condition='1' && t1.from_type='1' THEN t2.id END) AS new_to_field,
				COUNT(CASE WHEN t2.item_condition='2' && t1.from_type='1' THEN t2.id END) AS new_to_branch,
				COUNT(CASE WHEN t2.item_condition='1' && t1.from_type='3' THEN t2.id END) AS revived_to_field,
				COUNT(CASE WHEN t2.item_condition='2' && t1.from_type='3' THEN t2.id END) AS revived_to_branch,
				COUNT(CASE WHEN t2.item_condition IN ('3','4') && t1.from_type='2' THEN t2.id END) AS scrap_to_factory
		FROM ec_material_outward t1 INNER JOIN ec_material_sent_details t2 ON t1.alias=t2.reference WHERE t1.from_wh IN ($whouse) AND ".open_date("t1.date_of_trans")." t1.flag='0' GROUP BY t2.item_code");
		if(mysqli_num_rows($bal_query_lim)>'0'){ $coo=1;
			while($bal_row=mysqli_fetch_array($bal_query_lim)){ $coo++;
				$new_to_field=$bal_row['new_to_field'];
				$new_to_branch=$bal_row['new_to_branch'];
				$revived_to_field=$bal_row['revived_to_field'];
				$revived_to_branch=$bal_row['revived_to_branch'];
				$scrap_to_factory=$bal_row['scrap_to_factory'];
				$total=$new_to_field+$new_to_branch+$revived_to_field+$revived_to_branch+$scrap_to_factory;
				if($bal_row['item_type']=='1'){//Cells
					$item_desc = alias($bal_row['item_code'],'ec_product','product_alias','product_description');
					$item_type="CELLS";
					$c_new_2_field_t+=$new_to_field;
					$c_new_2_branch_t+=$new_to_branch;
					$c_rev_2_field_t+=$revived_to_field;
					$c_rev_2_branch_t+=$revived_to_branch;
					$c_scrap_2_fact_t+=$scrap_to_factory;
					$c_total_count_t+=$total;
				}else{//Accessories
					$item_desc = alias($bal_row['item_code'],'ec_accessories','accessories_alias','accessory_description');
					$item_type="ACCESSORIES";
					$a_new_2_field_t+=$new_to_field;
					$a_new_2_branch_t+=$new_to_branch;
					$a_rev_2_field_t+=$revived_to_field;
					$a_rev_2_branch_t+=$revived_to_branch;
					$a_scrap_2_fact_t+=$scrap_to_factory;
					$a_total_count_t+=$total;
				}
				$sheet->SetCellValue('A'.$coo,$item_desc)
						->SetCellValue('B'.$coo, $item_type)
						->SetCellValue('C'.$coo, $new_to_field)
						->SetCellValue('D'.$coo, $new_to_branch)
						->SetCellValue('E'.$coo, $revived_to_field)
						->SetCellValue('F'.$coo, $revived_to_branch)
						->SetCellValue('G'.$coo, $scrap_to_factory)
						->SetCellValue('H'.$coo, $total);
				$last_total = $coo;
			}
			$last_total = $last_total+1;
			$sheet->getStyle("A".$last_total.":H".$last_total)->applyFromArray($styleArray);
			$sheet->getStyle("A".$last_total.":H".$last_total)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$sheet->SetCellValue('A'.$last_total, 'Grand Total')
					->SetCellValue('B'.$last_total, 'CELLS')
					->SetCellValue('C'.$last_total, $c_new_2_field_t)
					->SetCellValue('D'.$last_total, $c_new_2_branch_t)
					->SetCellValue('E'.$last_total, $c_rev_2_field_t)
					->SetCellValue('F'.$last_total, $c_rev_2_branch_t)
					->SetCellValue('G'.$last_total, $c_scrap_2_fact_t)
					->SetCellValue('H'.$last_total, $c_total_count_t);
					
			$last_total = $last_total+1;
			$sheet->getStyle("A".$last_total.":H".$last_total)->applyFromArray($styleArray);
			$sheet->getStyle("A".$last_total.":H".$last_total)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$sheet->SetCellValue('A'.$last_total, 'Grand Total')
					->SetCellValue('B'.$last_total, 'ACCESSORIES')
					->SetCellValue('C'.$last_total, $a_new_2_field_t)
					->SetCellValue('D'.$last_total, $a_new_2_branch_t)
					->SetCellValue('E'.$last_total, $a_rev_2_field_t)
					->SetCellValue('F'.$last_total, $a_rev_2_branch_t)
					->SetCellValue('G'.$last_total, $a_scrap_2_fact_t)
					->SetCellValue('H'.$last_total, $a_total_count_t);
			$no_rec++;
		}$sh_index++;
			
//SJO Balance Without Cell Serial number
		if($sh_index>0){ $objPHPExcel->createSheet(); }
		$objPHPExcel->setActiveSheetIndex($sh_index);
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setTitle('SJO Balance');
		$colArr=array('FY Year','Zone','State','SJO Number','SJO Date','Customer Name','Site Names','TT Number','Sales Invoice Number','Sales Invoice Date','Sales PO Number','Customer Address','Customer Contact Person','Customer Contact No','Cell Capacity/Item Name','Reason/Remarks','Requested Date','Requested QTY','Request Status','Invoice /NRBC Number','Invoice Date','Dispatched Status(SCM)','Dispached Date(SCM)','Transporter Details(SCM)','Docket Number(SCM)','Dispatched Status(To Factory)','Dispached Date(To Factory)','Transporter Details(To Factory)','Docket Number(To Factory)','Dispatched Quantity from Factory to Field','Faulty Cell Quantity','New Cells Quantity','Cells Replaced Quantity','Faulty Cells received at Factory Quantity','Balance Quantity need to Return to factory','SJO VS Dispatched Balance','Lost Cells at Field');
		$last_key = end(array_keys($colArr));
		$last_alpha = num2alpha($last_key);
		$sheet->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
		$sheet->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
		$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',$colrefValue); $ch++; }
		$date_arr = array("E","J","Q","U","W","AA");
		foreach($date_arr as $da){$sheet->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension($da)->setAutoSize(true);}
		$b=mysqli_query($mr_con,"SELECT jm1.from_wh, jm1.date_of_request, jm1.sjo_number, jm1.sjo_date, jm1.ticket_alias, jm1.customer_alias, jm1.sales_invoice_no, jm1.sales_invoice_date, jm1.sales_po_no, jm1.contact_person, jm1.customer_address, jm1.customer_phone, jm1.mrf_alias, jm1.status, jm2.item_description, jm2.quantity FROM ec_material_request jm1 INNER JOIN ec_request_items jm2 ON jm1.mrf_alias=jm2.mrf_alias WHERE jm1.sjo_number<>'0' AND jm1.ticket_alias<>'0' AND ".open_date("jm1.date_of_request")." jm2.item_type='1'");
		if(mysqli_num_rows($b)){ $i=0;$coo=1;
			while($bb=mysqli_fetch_array($b)){$coo++;
				$ticketalias[$i]=$bb['ticket_alias'];
				$mrfalias[$i]=$bb['mrf_alias'];
				$productalias[$i]=$bb['item_description'];
				if($ticketalias[$i]!="2609" && !empty($ticketalias[$i])){
					$site_temp[$i]=alias($ticketalias[$i],'ec_tickets','ticket_alias','site_alias');
					$site_name[$i]=alias($site_temp[$i],'ec_sitemaster','site_alias','site_name');
					$ticket_id[$i]=strtok(alias($ticketalias[$i],'ec_tickets','ticket_alias','ticket_id'),"|");
				}else{ $site_name[$i]="-";$ticket_id[$i]="BUFFER";}
				$a_fina_yr[$i]=financial_year($bb['date_of_request']);
				$b_zone[$i]=alias(alias($bb['from_wh'],'ec_warehouse','wh_alias','zone_alias'),'ec_zone','zone_alias','zone_name');
				$c_wh[$i]=alias($bb['from_wh'],'ec_warehouse','wh_alias','wh_code');
				$d_sjo_num[$i]=$bb['sjo_number'];
				$e_sjo_dt[$i]=php_excel_date($bb['sjo_date']);
				$f_cust[$i]=alias($bb['customer_alias'],'ec_customer','customer_alias','customer_name');
				$g_site_nam[$i]=$site_name[$i];
				$h_tt_id[$i]=$ticket_id[$i];
	
				$i_sal_inv_no[$i]=$bb['sales_invoice_no'];
				$j_sal_inv_dt[$i]=php_excel_date($bb['sales_invoice_date']);
				$k_sal_po_no[$i]=$bb['sales_po_no'];
				$l_cust_addr[$i]=$bb['customer_address'];
				$m_cont_per[$i]=$bb['contact_person'];
				$n_cont_phn[$i]=$bb['customer_phone'];
				
				$o_prod[$i]=alias($productalias[$i],'ec_product','product_alias','product_description');
				$p_resn_remr[$i]=getoneremark($mrfalias[$i],'MR');
				$q_mat_req_dt[$i]=php_excel_date($bb['date_of_request']);
				$r_qty[$i]=$bb['quantity'];
				$s_req_status[$i]=fam_lvl_nm_clr($bb['status'],"name",$bb['mrf_alias']);
				$inv_sql=mysqli_query($mr_con,"SELECT GROUP_CONCAT(DISTINCT invoice_no SEPARATOR ' | ') AS in_no,GROUP_CONCAT(DISTINCT invoice_date SEPARATOR ' | ') AS in_dt FROM ec_item_code WHERE sjo_no='".$mrfalias[$i]."' AND sjo_no<>'' AND sjo_no<>'0' AND invoice_no<>'' AND invoice_no<>'NA' AND item_type='1' AND flag='0'");
				if(mysqli_num_rows($inv_sql)>'0'){
					$inv_row=mysqli_fetch_array($inv_sql);
					$t_inv_no[$i]=$inv_row['in_no'];
					if(strpos($inv_row['in_dt'],"|")!==false)$u_inv_dt[$i]=$inv_row['in_dt'];else{$sheet->getStyle("U".$coo)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$u_inv_dt[$i]=php_excel_date($inv_row['in_dt']);}
				}else{$t_inv_no[$i]=$u_inv_dt[$i]='-';}
				
				$fdtd=cells_countings($fct_wh,$productalias[$i],$mrfalias[$i],'3');
				if(count(array_diff($fdtd,array('0','-','-','-')))>'0'){
					list($from_factory_count,$dispdt,$trans,$doct)=$fdtd;
					$v_fdisp_status[$i]="Dispatched";
					if(strpos($dispdt,"|")!==false)$w_fdisp_dt[$i]=$dispdt;else{$sheet->getStyle("W".$coo)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$w_fdisp_dt[$i]=php_excel_date($dispdt);}
					$x_ftrans[$i]=$trans;
					$y_fdoct[$i]=$doct;
				}else {$v_fdisp_status[$i]=$w_fdisp_dt[$i]=$x_ftrans[$i]=$y_fdoct[$i]="-";$from_factory_count='0';}
				
					$e_ak[$i]=lost_countings($productalias[$i],$mrfalias[$i]);	
				
				$tdtd=cells_countings($fct_wh,$productalias[$i],$mrfalias[$i],'2');
				if(count(array_diff($tdtd,array('0','-','-','-')))>'0'){
					list($to_factory_count,$dispdt,$trans,$doct)=$tdtd;
					$z_tdisp_status[$i]="Dispatched";
					if(strpos($dispdt,"|")!==false)$aa_tdisp_dt[$i]=$dispdt;else{$sheet->getStyle("AA".$coo)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$aa_tdisp_dt[$i]=php_excel_date($dispdt);}
					$ab_ttrans[$i]=$trans;
					$ac_tdoct[$i]=$doct;
				}else{$z_tdisp_status[$i]=$aa_tdisp_dt[$i]=$ab_ttrans[$i]=$ac_tdoct[$i]="-";$to_factory_count='0';}

				$e_ad[$i]= $from_factory_count;//From Factory
				$e_ae[$i]=faulty_cells_counting($productalias[$i],$mrfalias[$i],$ticketalias[$i]);
				$e_af[$i]=$e_ad[$i];
				$e_ag[$i]=replaced_cells_counting($productalias[$i],$ticketalias[$i]);
				$e_ah[$i]=$to_factory_count; //To Factory
				$e_ai[$i]=$e_ad[$i]-$e_ah[$i]-$e_ak[$i];//outstanding_count($fct_wh,$productalias[$i],$mrfalias[$i]);//$e_ac[$i]-$e_ag[$i];
				$e_aj[$i]=$r_qty[$i]-$e_ad[$i];
				
				$sheet->SetCellValue('A'.$coo, $a_fina_yr[$i])
						->SetCellValue('B'.$coo, $b_zone[$i])
						->SetCellValue('C'.$coo, $c_wh[$i])
						->SetCellValue('D'.$coo, $d_sjo_num[$i])
						->SetCellValue('E'.$coo, $e_sjo_dt[$i])
						->SetCellValue('F'.$coo, $f_cust[$i])
						->SetCellValue('G'.$coo, $g_site_nam[$i])
						->SetCellValue('H'.$coo, $h_tt_id[$i])
						->SetCellValue('I'.$coo, $i_sal_inv_no[$i])
						->SetCellValue('J'.$coo, $j_sal_inv_dt[$i])
						->SetCellValue('K'.$coo, $k_sal_po_no[$i])
						->SetCellValue('L'.$coo, $l_cust_addr[$i])
						->SetCellValue('M'.$coo, $m_cont_per[$i])
						->SetCellValue('N'.$coo, $n_cont_phn[$i])
						->SetCellValue('O'.$coo, $o_prod[$i])
						->SetCellValue('P'.$coo, $p_resn_remr[$i])
						->SetCellValue('Q'.$coo, $q_mat_req_dt[$i])
						->SetCellValue('R'.$coo, $r_qty[$i])
						->SetCellValue('S'.$coo, $s_req_status[$i])
						->SetCellValue('T'.$coo, $t_inv_no[$i])
						->SetCellValue('U'.$coo, $u_inv_dt[$i])
						
						->SetCellValue('V'.$coo, $v_fdisp_status[$i])
						->SetCellValue('W'.$coo, $w_fdisp_dt[$i])
						->SetCellValue('X'.$coo, $x_ftrans[$i])
						->SetCellValue('Y'.$coo, $y_fdoct[$i])
						
						->SetCellValue('Z'.$coo, $z_tdisp_status[$i])
						->SetCellValue('AA'.$coo, $aa_tdisp_dt[$i])
						->SetCellValue('AB'.$coo, $ab_ttrans[$i])
						->SetCellValue('AC'.$coo, $ac_tdoct[$i])
						
						->SetCellValue('AD'.$coo, $e_ad[$i])
						->SetCellValue('AE'.$coo, $e_ae[$i])
						->SetCellValue('AF'.$coo, $e_af[$i])
						->SetCellValue('AG'.$coo, $e_ag[$i])
						->SetCellValue('AH'.$coo, $e_ah[$i])
						->SetCellValue('AI'.$coo, $e_ai[$i])
						->SetCellValue('AJ'.$coo, $e_aj[$i])
						->SetCellValue('AK'.$coo, $e_ak[$i]);
					$i++;
			}$no_rec++;
		}$sh_index++;
		if($no_rec>0){
			$filename = "Finacial_Archive_".date('Y',strtotime("-1 year"))."-".date('y');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save("../../finance_archive/$filename.xlsx");
			$result['file_name']=$filename;
			create_zipfile(array("../../finance_archive/$filename.xlsx"),"../../finance_archive/$filename.zip");
			$sql_up=mysqli_query($mr_con,"UPDATE ec_financial_archive SET closing_bal='$outstandcount_t',excel_download='$filename.zip',trans_date='".date('Y-m-d H:i:s')."',alias='$financial_alias' WHERE alias='' AND fy_year='$finance_year1' AND flag='0'");
			if($sql_up)$sql_in=mysqli_query($mr_con,"INSERT INTO ec_financial_archive(fy_year,opening_bal)VALUES('$finance_year2','$outstandcount_t')");
			$resCode='0'; $resMsg='Successfully Financial year archive completed';
		}else{$resCode='4';$resMsg='No Records found to Run Report!';}
	}elseif($rex=='1'){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function open_date($col){ global $mr_con;
	$sql_o=mysqli_query($mr_con,"SELECT DATE_FORMAT(MAX(trans_date),'%Y-%m-%d') AS max_date FROM ec_financial_archive WHERE trans_date!='' AND flag='0'");
	$rw_o = mysqli_fetch_array($sql_o);
	return (empty($rw_o['max_date']) ? "" : "$col>='".$rw_o['max_date']."' AND");
}
function material_balance_multi(){global $mr_con;
	set_time_limit(0);
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$pre_pre_y=date('Y',strtotime("-2 year"))."-".date('y',strtotime("-1 year"));
		$pre_y=date('Y',strtotime("-1 year"))."-".date('y');
		$nxt_y=date('Y')."-".date('y',strtotime("+1 year"));
		$year = ((date('m') < 4) ? $pre_y : $nxt_y);
		$new_finance_year=alias($nxt_y,'ec_financial_archive','fy_year','alias');
		if(empty($new_finance_year)){
			$xyz=alias($pre_y,'ec_financial_archive','fy_year','alias');
			if(empty($xyz)){
				$fn_yr = $pre_y = $pre_pre_y;
			}else $fn_yr = $pre_y;
		} else $fn_yr = $year;
		$financ_export = mysqli_real_escape_string($mr_con,trim($_REQUEST['financ_export']));
		if($financ_export=='finance'){ $conn="";
			if(isset($_REQUEST['fy_year']) && $_REQUEST['fy_year']!='')$conn .= "fy_year='".mysqli_real_escape_string($mr_con,trim($_REQUEST['fy_year']))."' AND ";
			if(isset($_REQUEST['opening_bal']) && $_REQUEST['opening_bal']!='')$conn.="opening_bal LIKE '%".mysqli_real_escape_string($mr_con,trim($_REQUEST['opening_bal']))."%' AND ";
			if(isset($_REQUEST['closing_bal']) && $_REQUEST['closing_bal']!='')$conn.="closing_bal LIKE '%".mysqli_real_escape_string($mr_con,trim($_REQUEST['closing_bal']))."%' AND ";
			$sql=mysqli_query($mr_con,"SELECT id FROM ec_financial_archive WHERE $conn flag='0'");
			$totalRecords=mysqli_num_rows($sql);
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			$totalpages=ceil($totalRecords/$limit);
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$result['finance_details']=array();
			$sql1=mysqli_query($mr_con,"SELECT * FROM ec_financial_archive WHERE $conn flag='0' ORDER BY id DESC LIMIT $offset, $limit");
			if(mysqli_num_rows($sql1)){
				$result['balancecount']=1;
				$i=0;while($row1 = mysqli_fetch_array($sql1)){
					$result['finance_details'][$i]['fy_year']=$row1['fy_year'];
					$result['finance_details'][$i]['opening_bal']=$row1['opening_bal'];
					$result['finance_details'][$i]['closing_bal']=$row1['closing_bal'];
					$result['finance_details'][$i]['trans_date']=$row1['trans_date'];
					$result['finance_details'][$i]['excel_download']=$row1['excel_download'];
				$i++;}
				$resCode='0'; $resMsg='Successful!';
			}else{$result['balancecount']=0;$resCode='4'; $resMsg='No Records Found';}
		}else{
			if(isset($_REQUEST['customer']) && $_REQUEST['customer']!='')$customer = mysqli_real_escape_string($mr_con,trim($_REQUEST['customer']));else $customer='';
			if(isset($_REQUEST['item_type']) && $_REQUEST['item_type']!='')$item_type=mysqli_real_escape_string($mr_con,trim($_REQUEST['item_type']));else $item_type='1';
			if(isset($_REQUEST['to_wh']) && $_REQUEST['to_wh']!='')$whouse="'".mysqli_real_escape_string($mr_con,trim($_REQUEST['to_wh']))."'";
			else{
				if(isset($_REQUEST['zone']) && $_REQUEST['zone']!=''){
					$zone=mysqli_real_escape_string($mr_con,trim($_REQUEST['zone']));
					$bal_query=mysqli_query($mr_con,"SELECT DISTINCT wh_alias FROM ec_warehouse WHERE zone_alias ='$zone' AND flag='0'");
					if(mysqli_num_rows($bal_query)>'0'){$wh_aliasss=array();
						while($bal_row=mysqli_fetch_array($bal_query)){$wh_aliasss[]=$bal_row['wh_alias'];}
						$whouse="'".implode("','",$wh_aliasss)."'";
					}else $whouse=getempwarehouse($emp_alias);
				}else $whouse=getempwarehouse($emp_alias);
			}
			$al_limt=$open_limt=array();
			if($item_type=='1'){
				$scr_dis = open_date("transDate");
				if(!empty($customer)){
					$out_cust_con = "sjo_number IN(SELECT mrf_alias FROM ec_material_request WHERE (customer_alias='$customer' OR ticket_alias IN(SELECT ticket_alias FROM ec_tickets WHERE site_alias IN(SELECT site_alias FROM ec_sitemaster WHERE customer_alias='$customer'))) AND flag='0') AND ";
					$cust_con="t1.cell_alias IN(SELECT jm2.item_description FROM ec_material_outward jm1 INNER JOIN ec_material_sent_details jm2 ON jm1.alias=jm2.reference WHERE jm1.$out_cust_con jm2.item_type='1' AND jm1.flag='0' GROUP BY jm2.item_description) AND ";
				}else $out_cust_con=$cust_con="";
				$totalRecords=mysqli_num_rows(mysqli_query($mr_con,"SELECT t1.id FROM ec_total_cell t1 LEFT JOIN ec_financial_archive_sub t2 ON t1.item_code=t2.product_alias AND t2.fy_year='$fn_yr' WHERE $cust_con t1.flag='0' GROUP BY t1.item_code"));
				if($totalRecords){
					if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
					if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
					$totalpages = ceil($totalRecords/$limit);
					$offset=(($limit*$pageNo)-$limit);
					$fromRecord=(($limit*$pageNo)-$limit)+1;
					if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
					$result['balancecount']=1;
					//(SELECT outstanding FROM ec_financial_archive_sub WHERE fy_year='$pre_y' AND product_alias=t1.item_code) AS opening_bal,

					$query = "SELECT t1.item_code,
					(CASE WHEN t2.fy_year='$pre_y' THEN t2.outstanding END) AS opening_bal,
					COUNT(CASE WHEN t1.stage='0' && t1.location IN ($whouse) && t1.condition_id='1' THEN t1.id END) AS new_count,
					COUNT(CASE WHEN t1.stage='0' && t1.location IN ($whouse) && $scr_dis t1.condition_id IN('3','4') THEN t1.id END) AS scrap_count,
					COUNT(CASE WHEN t1.stage='0' && t1.location IN ($whouse) && t1.condition_id='2' THEN t1.id END) AS revived_count,
					COUNT(CASE WHEN t1.stage='0' && t1.location IN ($whouse) && $scr_dis t1.condition_id='7' THEN t1.id END) AS dispute_count,
					COUNT(CASE WHEN t1.stage='0' && t1.location IN ($whouse) && t1.condition_id IN('5','6') THEN t1.id END) AS revival_count,
					COUNT(CASE WHEN t1.stage='1' && ((t1.location IN ($whouse) AND t1.location_type!='2') || (t1.old_location IN ($whouse) && t1.location_type='2')) THEN t1.id END) AS transit_count
				FROM ec_total_cell t1 LEFT JOIN ec_financial_archive_sub t2 ON t1.item_code=t2.product_alias AND t2.fy_year='$fn_yr' WHERE $cust_con t1.flag='0' GROUP BY t1.item_code LIMIT $offset, $limit";
					$bal_sql=mysqli_query($mr_con, $query);
					$m=0;while($bal_row=mysqli_fetch_array($bal_sql)){
						$opening_bal = (empty($bal_row['opening_bal']) ? 0 : $bal_row['opening_bal']);
						$new_count = $bal_row['new_count'];
						$scrap_count = $bal_row['scrap_count'];
						$revived_count = $bal_row['revived_count'];
						$dispute_count = $bal_row['dispute_count'];
						$revival_count = $bal_row['revival_count'];
						$transit_count = $bal_row['transit_count'];
						$outstandcount = outstandcounts($bal_row['item_code'],$whouse,$out_cust_con);
						
						$total = $new_count+$scrap_count+$revived_count+$dispute_count+$revival_count+$transit_count;
						$result['balance'][$m]['product_name']=alias($bal_row['item_code'],'ec_product','product_alias','product_description');
						$result['balance'][$m]['opening_bal']=$opening_bal;
						$result['balance'][$m]['new_count']=$new_count;
						$result['balance'][$m]['scrap_count']=$scrap_count;
						$result['balance'][$m]['revived_count']=$revived_count;
						$result['balance'][$m]['dispute_count']=$dispute_count;
						$result['balance'][$m]['Revival_count']=$revival_count;
						$result['balance'][$m]['transit_count']=$transit_count;
						$result['balance'][$m]['outstandcount']=$outstandcount;
						$result['balance'][$m]['total_count']=$total;
						
						$result['balancea']['opening_bal_t']+=$opening_bal;
						$result['balancea']['new_count_t']+=$new_count;
						$result['balancea']['scrap_count_t']+=$scrap_count;
						$result['balancea']['revived_count_t']+=$revived_count;
						$result['balancea']['dispute_count_t']+=$dispute_count;
						$result['balancea']['Revival_count_t']+=$revival_count;
						$result['balancea']['transit_count_t']+=$transit_count;
						$result['balancea']['outstandcount_t']+=$outstandcount;
						$result['balancea']['total_count_t']+=$total;
					$m++;}
				}else $result['balancecount']=0;
			}else{
				$tran_date = open_date("transDate");
				$tran_date_t = (empty($tran_date) ? "" : "t1.".$tran_date);
				if(empty($customer))$totalRecords=mysqli_num_rows(mysqli_query($mr_con,"SELECT id FROM ec_total_accessories WHERE location IN ($whouse) AND stage='0' AND location_type IN ('0','1') AND $tran_date flag='0' GROUP BY item_code"));
				else $totalRecords=mysqli_num_rows(mysqli_query($mr_con,"SELECT t1.id FROM ec_total_accessories t1 INNER JOIN ec_item_code t2 ON t1.acc_alias=t2.item_code_alias INNER JOIN ec_material_request t3 ON t2.sjo_no=t3.mrf_alias WHERE t1.location IN ($whouse) AND t1.stage='0' AND t1.location_type IN ('0','1') AND $tran_date_t t2.item_type='2' AND (t3.customer_alias='$customer' OR t3.ticket_alias IN(SELECT ticket_alias FROM ec_tickets WHERE site_alias IN(SELECT site_alias FROM ec_sitemaster WHERE customer_alias='$customer'))) AND t1.flag='0' GROUP BY t1.item_code"));
				if($totalRecords){
					$result['balancecount']=1;
					if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
					if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
					$totalpages = ceil($totalRecords/$limit);
					$offset=(($limit*$pageNo)-$limit);
					$fromRecord=(($limit*$pageNo)-$limit)+1;
					if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
					if(empty($customer))$bq1=mysqli_query($mr_con,"SELECT item_code,SUM(good_qty) as good,SUM(damaged_qty) as damaged,SUM(lost_qty) as lost FROM ec_total_accessories WHERE location IN ($whouse) AND stage='0' AND location_type IN ('0','1') AND $tran_date flag='0' GROUP BY item_code LIMIT $offset, $limit");
					else $bq1=mysqli_query($mr_con,"SELECT t1.item_code,SUM(t1.good_qty) as good,SUM(t1.damaged_qty) as damaged,SUM(t1.lost_qty) as lost FROM ec_total_accessories t1 INNER JOIN ec_item_code t2 ON t1.acc_alias=t2.item_code_alias INNER JOIN ec_material_request t3 ON t2.sjo_no=t3.mrf_alias WHERE t1.location IN ($whouse) AND t1.stage='0' AND t1.location_type IN ('0','1') AND $tran_date_t t2.item_type='2' AND (t3.customer_alias='$customer' OR t3.ticket_alias IN(SELECT ticket_alias FROM ec_tickets WHERE site_alias IN(SELECT site_alias FROM ec_sitemaster WHERE customer_alias='$customer'))) AND t1.flag='0' GROUP BY t1.item_code LIMIT $offset, $limit");
					$m=0;while($rq1=mysqli_fetch_array($bq1)){
						$good=$rq1['good'];
						$damaged=$rq1['damaged'];
						$lost=$rq1['lost'];
						$total_a = $good+$damaged+$lost;
						$result['balance'][$m]['product_name']=alias($rq1['item_code'],'ec_accessories','accessories_alias','accessory_description');
						$result['balance'][$m]['new_count']=$good;
						$result['balance'][$m]['scrap_count']=$damaged;
						$result['balance'][$m]['lost_count']=$lost;
						$result['balance'][$m]['total_count']=$total_a;

						$result['balancea']['new_count_t']+=$good;
						$result['balancea']['scrap_count_t']+=$damaged;
						$result['balancea']['lost_count_t']+=$lost;
						$result['balancea']['total_count_t']+=$total_a;
						$m++;
					}
				}else $result['balancecount']=0;
			}
		}
		$result['admin_nhs_priv']=(admin_privilege($emp_alias) || alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias')=="WIMYJFDJPT" ? TRUE : FALSE);
		$date=strtotime(date('Y-m-d'));
		$result['finance_date']=(strtotime(date('Y-03-28'))<=$date && strtotime(date('Y-04-15'))>=$date && empty($new_finance_year) ? FALSE : TRUE);
		//$result['finance_date']=(strtotime(date('Y-02-08'))<=$date && strtotime(date('Y-02-10'))>=$date && empty($new_finance_year) ? FALSE : TRUE);
		$result['fin_date_tool_tip']=(empty($new_finance_year) ? "It's Enable from ".date('Y-03-28')." to ".date('Y-04-15') : "Archive is done for this Financial Year");
		$result['export']=grantable('EXPORT','MATERIAL BALANCE',$emp_alias);
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x;else $result['pages'][1]=1;
	echo json_encode($result);
}
//Inward Balance Service Starts
function inward_balance_multi(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){ $condition="";
		if(isset($_REQUEST['item_type']) && !empty($_REQUEST['item_type']))$condition.="t2.item_type ='".mysqli_real_escape_string($mr_con,$_REQUEST['item_type'])."' AND ";
		if(isset($_REQUEST['fromDate']) && !empty($_REQUEST['fromDate']))$condition.="t1.date_of_trans>='".dateFormat(mysqli_real_escape_string($mr_con,trim($_REQUEST['fromDate'])),'y')."' AND ";
		if(isset($_REQUEST['toDate']) && !empty($_REQUEST['toDate']))$condition.="t1.date_of_trans<='".dateFormat(mysqli_real_escape_string($mr_con,trim($_REQUEST['toDate'])),'y')."' AND ";
		if(isset($_REQUEST['engineer']) && !empty($_REQUEST['engineer']))$condition.="t1.resp_engineer ='".mysqli_real_escape_string($mr_con,$_REQUEST['engineer'])."' AND ";
		$condition.=open_date("t1.date_of_trans");
		if(isset($_REQUEST['to_wh']) && $_REQUEST['to_wh']!='')$whouse="'".mysqli_real_escape_string($mr_con,trim($_REQUEST['to_wh']))."'";
		else{
			if(isset($_REQUEST['zone']) && $_REQUEST['zone']!=''){
				$zone=mysqli_real_escape_string($mr_con,trim($_REQUEST['zone']));
				$bal_query=mysqli_query($mr_con,"SELECT DISTINCT wh_alias FROM ec_warehouse WHERE zone_alias ='$zone' AND flag='0'");
				if(mysqli_num_rows($bal_query)>'0'){$wh_aliasss=array();
					while($bal_row=mysqli_fetch_array($bal_query)){$wh_aliasss[]=$bal_row['wh_alias'];}
					$whouse="'".implode("','",$wh_aliasss)."'";
				}else $whouse=getempwarehouse($emp_alias);
			}else $whouse=getempwarehouse($emp_alias);
		}
		$totalRecords=mysqli_num_rows(mysqli_query($mr_con,"SELECT t2.id FROM ec_material_outward t1 INNER JOIN ec_material_sent_details t2 ON t1.alias=t2.reference WHERE t1.from_wh IN ($whouse) AND $condition t1.flag='0' GROUP BY t2.item_code"));
		if($totalRecords){
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			$totalpages = ceil($totalRecords/$limit);
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$result['inwardcount']=1;
			$out_bal_sql=mysqli_query($mr_con,"SELECT t2.item_type,t2.item_code,
					COUNT(CASE WHEN t1.from_type='3' && t1.from_wh='XVX6AZ4VHT' THEN t2.id END) AS factory_count,
					COUNT(CASE WHEN t1.from_type='4' && t1.from_wh<>'XVX6AZ4VHT' THEN t2.id END) AS branch_count,
					COUNT(CASE WHEN t1.from_type IN('1','2') THEN t2.id END) AS field_count
			FROM ec_material_inward t1 INNER JOIN ec_material_received_details t2 ON t1.alias=t2.reference WHERE t1.to_wh IN ($whouse) AND $condition t1.flag='0' GROUP BY t2.item_code LIMIT $offset, $limit");
			$m=0;while($out_bal_row=mysqli_fetch_array($out_bal_sql)){
				$factory_count = $out_bal_row['factory_count'];
				$branch_count = $out_bal_row['branch_count'];
				$field_count = $out_bal_row['field_count'];
				$total = $factory_count+$branch_count+$field_count;
				$result['inward'][$m]['product_name']=($out_bal_row['item_type']=='1' ? alias($out_bal_row['item_code'],'ec_product','product_alias','product_description') : alias($out_bal_row['item_code'],'ec_accessories','accessories_alias','accessory_description'));
				$result['inward'][$m]['factory_count']=$factory_count;
				$result['inward'][$m]['branch_count']=$branch_count;
				$result['inward'][$m]['field_count']=$field_count;
				$result['inward'][$m]['total_count']=$total;
				$result['inwarda']['factory_count_t']+=$factory_count;
				$result['inwarda']['branch_count_t']+=$branch_count;
				$result['inwarda']['field_count_t']+=$field_count;
				$result['inwarda']['total_count_t']+=$total;
			$m++;}
		}else $result['inwardcount']=0;
		$result['export']=grantable('EXPORT','MATERIAL BALANCE',$emp_alias);
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';}
	else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x;else $result['pages'][1]=1;
	echo json_encode($result);
}
//Material Balance Service Starts
function outward_balance_multi(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){ $condition="";
		if(isset($_REQUEST['item_type']) && !empty($_REQUEST['item_type']))$condition.="t2.item_type ='".mysqli_real_escape_string($mr_con,$_REQUEST['item_type'])."' AND ";
		if(isset($_REQUEST['fromDate']) && !empty($_REQUEST['fromDate']))$condition.="t1.date_of_trans>='".dateFormat(mysqli_real_escape_string($mr_con,trim($_REQUEST['fromDate'])),'y')."' AND ";
		if(isset($_REQUEST['toDate']) && !empty($_REQUEST['toDate']))$condition.="t1.date_of_trans<='".dateFormat(mysqli_real_escape_string($mr_con,trim($_REQUEST['toDate'])),'y')."' AND ";
		if(isset($_REQUEST['engineer']) && !empty($_REQUEST['engineer']))$condition.="t1.resp_engineer ='".mysqli_real_escape_string($mr_con,$_REQUEST['engineer'])."' AND ";
		$condition.=open_date("t1.date_of_trans");
		if(isset($_REQUEST['to_wh']) && $_REQUEST['to_wh']!='')$whouse="'".mysqli_real_escape_string($mr_con,trim($_REQUEST['to_wh']))."'";
		else{
			if(isset($_REQUEST['zone']) && $_REQUEST['zone']!=''){
				$zone=mysqli_real_escape_string($mr_con,trim($_REQUEST['zone']));
				$bal_query=mysqli_query($mr_con,"SELECT DISTINCT wh_alias FROM ec_warehouse WHERE zone_alias ='$zone' AND flag='0'");
				if(mysqli_num_rows($bal_query)>'0'){$wh_aliasss=array();
					while($bal_row=mysqli_fetch_array($bal_query)){$wh_aliasss[]=$bal_row['wh_alias'];}
					$whouse="'".implode("','",$wh_aliasss)."'";
				}else $whouse=getempwarehouse($emp_alias);
			}else $whouse=getempwarehouse($emp_alias);
		}
		$totalRecords=mysqli_num_rows(mysqli_query($mr_con,"SELECT t2.id FROM ec_material_outward t1 INNER JOIN ec_material_sent_details t2 ON t1.alias=t2.reference WHERE t1.from_wh IN ($whouse) AND $condition t1.flag='0' GROUP BY t2.item_code"));
		if($totalRecords){
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			$totalpages = ceil($totalRecords/$limit);
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$result['outwardcount']=1;
			$out_bal_sql=mysqli_query($mr_con,"SELECT t2.item_type,t2.item_code,
					COUNT(CASE WHEN t2.item_condition='1' && t1.from_type='1' THEN t2.id END) AS new_to_field,
					COUNT(CASE WHEN t2.item_condition='2' && t1.from_type='1' THEN t2.id END) AS new_to_branch,
					COUNT(CASE WHEN t2.item_condition='1' && t1.from_type='3' THEN t2.id END) AS revived_to_field,
					COUNT(CASE WHEN t2.item_condition='2' && t1.from_type='3' THEN t2.id END) AS revived_to_branch,
					COUNT(CASE WHEN t2.item_condition IN ('3','4') && t1.from_type='2' THEN t2.id END) AS scrap_to_factory
			FROM ec_material_outward t1 INNER JOIN ec_material_sent_details t2 ON t1.alias=t2.reference WHERE t1.from_wh IN ($whouse) AND $condition t1.flag='0' GROUP BY t2.item_code LIMIT $offset, $limit");
			$m=0;while($out_bal_row=mysqli_fetch_array($out_bal_sql)){
				$new_to_field = $out_bal_row['new_to_field'];
				$new_to_branch = $out_bal_row['new_to_branch'];
				$revived_to_field = $out_bal_row['revived_to_field'];
				$revived_to_branch = $out_bal_row['revived_to_branch'];
				$scrap_to_factory = $out_bal_row['scrap_to_factory'];
				$total = $new_to_field+$new_to_branch+$revived_to_field+$revived_to_branch+$scrap_to_factory;
				$result['outward'][$m]['product_name']=($out_bal_row['item_type']=='1' ? alias($out_bal_row['item_code'],'ec_product','product_alias','product_description') : alias($out_bal_row['item_code'],'ec_accessories','accessories_alias','accessory_description'));
				$result['outward'][$m]['field_count_new']=$new_to_field;
				$result['outward'][$m]['field_count_revied']=$new_to_branch;
				$result['outward'][$m]['branch_count_new']=$revived_to_field;
				$result['outward'][$m]['branch_count_revied']=$revived_to_branch;
				$result['outward'][$m]['factory_count']=$scrap_to_factory;
				$result['outward'][$m]['total_count']=$total;
				$result['outwarda']['factory_count_t']+=$scrap_to_factory;
				$result['outwarda']['field_count_new_t']+=$new_to_field;
				$result['outwarda']['field_count_revied_t']+=$new_to_branch;
				$result['outwarda']['branch_count_new_t']+=$revived_to_field;
				$result['outwarda']['branch_count_revied_t']+=$revived_to_branch;
				$result['outwarda']['total_count_t']+=$total;
			$m++;}
		}else $result['outwardcount']=0;
		$result['export']=grantable('EXPORT','MATERIAL BALANCE',$emp_alias);
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';}
	else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x;else $result['pages'][1]=1;
	echo json_encode($result);
}
function in_site($product_aliasa){global $mr_con;
	$bal_query=mysqli_query($mr_con,"SELECT id FROM ec_total_accessories WHERE item_code='".$product_aliasa."' AND location NOT IN (SELECT wh_alias FROM ec_warehouse WHERE flag='0') AND flag='0'");
	return mysqli_num_rows($bal_query);
}
function outstandcounts($item_code,$wh,$out_con=""){ global $mr_con;
	if(!empty($out_con))$out_con="t1.".$out_con;
	$from_fact=mysqli_num_rows(mysqli_query($mr_con,"SELECT t2.id FROM ec_material_outward t1 INNER JOIN ec_material_sent_details t2 ON t1.alias=t2.reference WHERE t2.item_code='$item_code' AND t1.to_wh IN($wh) AND t1.from_wh='XVX6AZ4VHT' AND t2.item_type='1' AND t1.status='6' AND $out_con t1.flag='0'"));
	//$to_fact=mysqli_num_rows(mysqli_query($mr_con,"SELECT t2.id FROM ec_material_inward t1 INNER JOIN ec_material_received_details t2 ON t1.alias=t2.reference WHERE t1.from_wh IN($wh) AND t1.to_wh='XVX6AZ4VHT' AND t1.sjo_number IN('','0') AND t1.from_type='4' AND t2.item_code='$item_code' AND t2.item_type='1' AND $out_con t1.flag='0'"));
	$tofact_lost_row=mysqli_fetch_array(mysqli_query($mr_con,"SELECT COUNT(CASE WHEN t1.from_wh IN($wh) && t1.to_wh='XVX6AZ4VHT' && t1.sjo_number IN('','0') && t1.from_type='4' THEN t2.id END) + COUNT(CASE WHEN t1.to_wh IN($wh) && t1.from_type IN('1','2','3') && t2.item_condition='7' THEN t2.id END) AS tofact_lost FROM ec_material_inward t1 INNER JOIN ec_material_received_details t2 ON t1.alias=t2.reference WHERE t2.item_code='$item_code' AND t2.item_type='1' AND $out_con t1.flag='0'"));
	$to_fact = $tofact_lost_row['tofact_lost'];
	$non_sjo=mysqli_num_rows(mysqli_query($mr_con,"SELECT t2.id FROM ec_material_outward t1 INNER JOIN ec_material_sent_details t2 ON t1.alias=t2.reference WHERE t1.from_wh IN($wh) AND t1.to_wh='XVX6AZ4VHT' AND t1.sjo_number IN('','0') AND t1.from_type='2' AND t2.item_code='$item_code' AND t2.item_type='1' AND t1.status='6' AND $out_con t1.flag='0'"));
	return $from_fact-$to_fact+$non_sjo;
}
function outwardcellslist($product_aliasa,$whouse,$condition,$level1,$fromtype,$ec){ global $mr_con;
	$level="'".str_replace("|","','",$level1)."'";
	$bal_query=mysqli_query($mr_con,"SELECT id FROM ec_material_sent_details WHERE  item_code='".$product_aliasa."' AND item_condition IN ($level) AND reference IN (SELECT alias FROM ec_material_outward WHERE from_type='$fromtype' AND from_wh IN ($whouse) AND $condition $ec flag='0')");
	return mysqli_num_rows($bal_query);
}
function inwardcellslist($product_aliasa,$whouse,$condition,$level1){ global $mr_con;
	if($level1=='3'){
		$bal_query=mysqli_query($mr_con,"SELECT id FROM ec_material_received_details WHERE item_code='".$product_aliasa."' AND reference IN (SELECT alias FROM ec_material_inward WHERE from_wh IN (SELECT wh_alias FROM ec_warehouse WHERE wh_type='1') AND to_wh IN ($whouse) AND $condition flag='0')");
		return mysqli_num_rows($bal_query);
	}elseif($level1=='4'){
		$bal_query=mysqli_query($mr_con,"SELECT id FROM ec_material_received_details WHERE item_code='".$product_aliasa."' AND reference IN (SELECT alias FROM ec_material_inward WHERE from_wh IN (SELECT wh_alias FROM ec_warehouse WHERE wh_type='0') AND to_wh IN ($whouse) AND $condition flag='0')");
		return mysqli_num_rows($bal_query);
	}else{
		$level="'".str_replace("|","','",$level1)."'";
		$bal_query=mysqli_query($mr_con,"SELECT id FROM ec_material_received_details WHERE item_code='".$product_aliasa."' AND reference IN (SELECT alias FROM ec_material_inward WHERE from_type IN ($level) AND to_wh IN ($whouse) AND $condition flag='0')");
		return mysqli_num_rows($bal_query);
	}
}
function countcellslist($product_aliasa,$whouse,$level1,$out_con=""){ global $mr_con;
	$transDate = ($level1=='3|4' || $level1=='7' ? open_date("transDate") : "");//if(!empty($transDate))$transDate = $transDate." location_type!='0' AND ";else $transDate="";
	if(!empty($out_con))$out_con="cell_alias IN(SELECT jm2.item_description FROM ec_material_outward jm1 INNER JOIN ec_material_sent_details jm2 ON jm1.alias=jm2.reference WHERE jm1.$out_con jm2.item_type='1' AND jm1.flag='0' GROUP BY jm2.item_description) AND ";
	if($level1=='0') $conn="stage='1' AND ((location IN ($whouse) AND location_type<>'2') OR (old_location IN ($whouse) AND location_type='2'))";
	else $conn="stage='0' AND location IN ($whouse) AND condition_id IN ('".str_replace("|","','",$level1)."')";
	$bal_query=mysqli_query($mr_con,"SELECT id FROM ec_total_cell WHERE item_code='$product_aliasa' AND $conn AND $transDate $out_con flag='0'");
	return mysqli_num_rows($bal_query);
}
/*function non_sjo_count($product_alias,$whouse,$out_con=""){ global $mr_con;
	if(!empty($out_con))$out_con="t1.".$out_con;
	return mysqli_num_rows(mysqli_query($mr_con,"SELECT id FROM ec_total_cell WHERE item_code='$product_alias' AND stage='0' AND location IN ($whouse) AND condition_id='3' AND cell_alias IN(SELECT t2.item_description FROM ec_material_inward t1 INNER JOIN ec_material_received_details t2 ON t1.alias=t2.reference WHERE t1.to_wh IN($whouse) AND t1.from_wh!='XVX6AZ4VHT' AND t1.sjo_number IN('','0') AND t1.from_type IN('1','2') AND t2.item_code='$product_alias' AND t2.item_type='1' AND $out_con t1.flag='0')"));
	//$bq1=mysqli_query($mr_con,"SELECT jm2.id FROM ec_material_inward jm1 INNER JOIN ec_material_received_details jm2 ON jm1.alias=jm2.reference WHERE jm1.to_wh='XVX6AZ4VHT' AND jm1.from_type='4' AND jm2.item_code='$product_alias' AND jm2.item_type='1'");
	//return mysqli_num_rows($bq1);
}*/
function material_balance_export(){ 
	global $mr_con;
	set_time_limit(0);
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){
		if(isset($_REQUEST['data_type']) && count($_REQUEST['data_type'])){ $data_type = $_REQUEST['data_type'];
			$sh_index=$no_rec=0;
			if(isset($_REQUEST['warehouse']) && count($_REQUEST['warehouse']))$whouse = "'".implode("','",$_REQUEST['warehouse'])."'";else $whouse=getempwarehouse($emp_alias);
			$objPHPExcel = new PHPExcel();
			$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
			if(in_array('1',$data_type)){ //Cells
				$pre_pre_y=date('Y',strtotime("-2 year"))."-".date('y',strtotime("-1 year"));
				$pre_y=date('Y',strtotime("-1 year"))."-".date('y');
				$nxt_y=date('Y')."-".date('y',strtotime("+1 year"));
				$year = ((date('m') < 4) ? $pre_y : $nxt_y);
				$new_finance_year=alias($nxt_y,'ec_financial_archive','fy_year','alias');
				if(empty($new_finance_year)){
					$xyz=alias($pre_y,'ec_financial_archive','fy_year','alias');
					if(empty($xyz)){
						$fn_yr = $pre_y = $pre_pre_y;
					}else $fn_yr = $pre_y;
				} else $fn_yr = $year;
				$colArr=array('Product Name','Opening Count','New Count','Revived Count','Scrap Count','Dispute Count','Revival Count','Under Transit','Total Count','Outstand Count');
				$objPHPExcel->setActiveSheetIndex($sh_index);
				$sheet=$objPHPExcel->getActiveSheet();
				$sheet->setTitle('Material Bal For Cells');
				$ch = 'A';
				foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
					$sheet->getStyle($ch.'1')->applyFromArray($styleArray);
					$sheet->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
					$ch++;
				}
				$al_limt=array();
				$bq1=mysqli_query($mr_con,"SELECT jm2.item_code FROM ec_material_outward jm1 INNER JOIN ec_material_sent_details jm2 ON jm1.alias=jm2.reference WHERE jm1.from_wh IN ($whouse) AND jm2.item_type='1' AND jm1.flag='0' AND jm2.flag='0' GROUP BY jm2.item_code");
				$bq2=mysqli_query($mr_con,"SELECT jm2.item_code FROM ec_material_inward jm1 INNER JOIN ec_material_received_details jm2 ON jm1.alias=jm2.reference WHERE jm1.to_wh IN ($whouse) AND jm2.item_type='1' AND jm1.flag='0' AND jm2.flag='0' GROUP BY jm2.item_code");
				if(mysqli_num_rows($bq1)>'0'){
					while($rq1=mysqli_fetch_array($bq1)){$al_limt[]=$rq1['item_code'];}
				}
				if(mysqli_num_rows($bq2)>'0'){
					while($rq2=mysqli_fetch_array($bq2)){$al_limt[]=$rq2['item_code'];}
				}
				$opbq=mysqli_query($mr_con,"SELECT COUNT(id) AS cn,GROUP_CONCAT(product_alias) AS prod FROM ec_financial_archive_sub WHERE fy_year='$fn_yr' AND flag='0'");
				$opbr=mysqli_fetch_array($opbq);
				if($opbr['cn'])$open_limt=explode(",",$opbr['prod']);else $open_limt=array();
				$bal_limt = array_unique($al_limt);
				$al_limt=array_unique(array_merge($bal_limt,$open_limt));
				$product_alias=array_unique($al_limt);
				if(count($product_alias)>'0'){
					for($m=0,$coo=1;$m<count($product_alias);$m++){$coo++;
						$sss=mysqli_query($mr_con,"SELECT outstanding FROM ec_financial_archive_sub WHERE product_alias='".$product_alias[$m]."' AND fy_year='$fn_yr' AND flag='0'");
						if(mysqli_num_rows($sss)>'0'){ $ppp=mysqli_fetch_array($sss); $z = $ppp['outstanding']; }else $z = 0;
						$product_alias[$m]=(!in_array($product_alias[$m],$bal_limt) ? "" : $product_alias[$m]);
						$a=countcellslist($product_alias[$m],$whouse,'1');
						$b=countcellslist($product_alias[$m],$whouse,'2');
						$c=countcellslist($product_alias[$m],$whouse,'3|4');
						$d=countcellslist($product_alias[$m],$whouse,'7');
						$e=countcellslist($product_alias[$m],$whouse,'5|6');
						$f=countcellslist($product_alias[$m],$whouse,'0');
						$g=$a+$b+$c+$d+$e+$f;
						$i=outstandcounts($product_alias[$m],$whouse);
						$sheet->SetCellValue('A'.$coo, alias($product_alias[$m],'ec_product','product_alias','product_description'))
								->SetCellValue('B'.$coo, $z)
								->SetCellValue('C'.$coo, $a)
								->SetCellValue('D'.$coo, $b)
								->SetCellValue('E'.$coo, $c)
								->SetCellValue('F'.$coo, $d)
								->SetCellValue('G'.$coo, $e)
								->SetCellValue('H'.$coo, $f)
								->SetCellValue('I'.$coo, $g)
								->SetCellValue('J'.$coo, $i);
						$open_count_t+=$z;
						$new_count_t+=$a;
						$revived_count_t+=$b;
						$scrap_count_t+=$c;
						$dispute_count_t+=$d;
						$Revival_count_t+=$e;
						$transit_t+=$f;
						$total_count_t+=$g;
						$outstandcount_t+=$i;
						$last_total = $coo;
					}
					$last_total = $last_total+1;
					$sheet->getStyle("A".$last_total.":J".$last_total)->applyFromArray($styleArray);
					$sheet->getStyle("A".$last_total.":J".$last_total)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
					$sheet->SetCellValue('A'.$last_total, 'Grand Total')
							->SetCellValue('B'.$last_total, $open_count_t)
							->SetCellValue('C'.$last_total, $new_count_t)
							->SetCellValue('D'.$last_total, $revived_count_t)
							->SetCellValue('E'.$last_total, $scrap_count_t)
							->SetCellValue('F'.$last_total, $dispute_count_t)
							->SetCellValue('G'.$last_total, $Revival_count_t)
							->SetCellValue('H'.$last_total, $transit_t)
							->SetCellValue('I'.$last_total, $total_count_t)
							->SetCellValue('J'.$last_total, $outstandcount_t);
					$sh_index++;$no_rec++;
				}
			}if(in_array('2',$data_type)){ //Accessories
				if($sh_index>0)$objPHPExcel->createSheet();
				$objPHPExcel->setActiveSheetIndex($sh_index);
				$sheet = $objPHPExcel->getActiveSheet();
				$sheet->setTitle('Material Bal For Accessories');
				$product_alias_acc=$good_count=$damaged_count=$lost_count=array();
				$bq1=mysqli_query($mr_con,"SELECT item_code,SUM(good_qty) as good,SUM(damaged_qty) as damaged,SUM(lost_qty) as lost FROM ec_total_accessories WHERE location IN ($whouse) AND stage='0' AND location_type IN ('0','1') AND ".open_date("transDate")." flag='0' GROUP BY item_code");
				if(mysqli_num_rows($bq1)>'0'){while($rq1=mysqli_fetch_array($bq1)){$product_alias_acc[]=$rq1['item_code'];$good_count[]=$rq1['good'];$damaged_count[]=$rq1['damaged'];$lost_count[]=$rq1['lost']; }}
				if(count($product_alias_acc)>'0'){
					$colArr1=array('Accessory Name','Good Quantity','Damaged Quantity','Lost Quantity','Total');
					$last_key1 = end(array_keys($colArr1));
					$last_alpha1 = num2alpha($last_key1);
					$sheet->getStyle('A1:'.$last_alpha1."1")->applyFromArray($styleArray);
					$sheet->getStyle('A1:'.$last_alpha1."1")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
					$ch = 'A'; foreach($colArr1 as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue)); $ch++; }
					$good_count_t=$damaged_count_t=$lost_count_t=$total_count_t=0;
					for($m=0,$coo=1;$m<count($product_alias_acc);$m++){$coo++;
						$total_count = $good_count[$m]+$damaged_count[$m]+$lost_count[$m];
						$sheet->SetCellValue('A'.$coo, alias($product_alias_acc[$m],'ec_accessories','accessories_alias','accessory_description'))
								->SetCellValue('B'.$coo, $good_count[$m])
								->SetCellValue('C'.$coo, $damaged_count[$m])
								->SetCellValue('D'.$coo, $lost_count[$m])
								->SetCellValue('E'.$coo, $total_count);
						$good_count_t+=$good_count[$m];
						$damaged_count_t+=$damaged_count[$m];
						$lost_count_t+=$lost_count[$m];
						$total_count_t+=$total_count;
						$last_total = $coo;
					}
					$last_total = $last_total+1;
					$sheet->getStyle("A".$last_total.":E".$last_total)->applyFromArray($styleArray);
					$sheet->getStyle("A".$last_total.":E".$last_total)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
					$sheet->SetCellValue('A'.$last_total, 'Grand Total')
							->SetCellValue('B'.$last_total, $good_count_t)
							->SetCellValue('C'.$last_total, $damaged_count_t)
							->SetCellValue('D'.$last_total, $lost_count_t)
							->SetCellValue('E'.$last_total, $total_count_t);
					$no_rec++;
				}
			}
			if(!empty($no_rec)){
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$filename = 'Material_balance_'.date('d-m-Y H_i_s');
				$objWriter->save("../../exports/$filename.xlsx");
				$result['file_name']=$filename;
				$resCode='0'; $resMsg='export';
			}else{$resCode='4'; $resMsg='No Records Found To Run Report';}
		}else {$resCode='4'; $resMsg='Please Select Datatype';}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function material_inward_balance_export(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){
		if(isset($_REQUEST['warehouse']) && count($_REQUEST['warehouse']))$whouse = "'".implode("','",$_REQUEST['warehouse'])."'";else $whouse=getempwarehouse($emp_alias);
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$sheet = $objPHPExcel->getActiveSheet();
		$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
		$colArr=array('Product Name','Product Type','From Factory','From Field','From Branch','Total');
		$last_key = end(array_keys($colArr));
		$last_alpha = num2alpha($last_key);
		$sheet->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
		$sheet->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
		$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue)); $ch++; }
		$c_new_2_field_t=$c_new_2_branch_t=$c_rev_2_field_t=$c_rev_2_branch_t=$c_scrap_2_fact_t=$c_total_count_t=$a_new_2_field_t=$a_new_2_branch_t=$a_rev_2_field_t=$a_rev_2_branch_t=$a_scrap_2_fact_t=$a_total_count_t=0;
		$bal_query_lim=mysqli_query($mr_con,"SELECT t2.item_type,t2.item_code,
					COUNT(CASE WHEN t1.from_type='3' && t1.from_wh='XVX6AZ4VHT' THEN t2.id END) AS factory_count,
					COUNT(CASE WHEN t1.from_type='4' && t1.from_wh<>'XVX6AZ4VHT' THEN t2.id END) AS branch_count,
					COUNT(CASE WHEN t1.from_type IN('1','2') THEN t2.id END) AS field_count
			FROM ec_material_inward t1 INNER JOIN ec_material_received_details t2 ON t1.alias=t2.reference WHERE t1.to_wh IN ($whouse) AND ".open_date("t1.date_of_trans")." t1.flag='0' GROUP BY t2.item_code");
		if(mysqli_num_rows($bal_query_lim)>'0'){ $coo=1;
			while($bal_row=mysqli_fetch_array($bal_query_lim)){ $coo++;
				$factory_count=$bal_row['factory_count'];
				$branch_count=$bal_row['branch_count'];
				$field_count=$bal_row['field_count'];
				$total=$factory_count+$branch_count+$field_count;
				if($bal_row['item_type']=='1'){//Cells
					$item_desc = alias($bal_row['item_code'],'ec_product','product_alias','product_description');
					$item_type="CELLS";
					$c_factory_count_t+=$factory_count;
					$c_branch_count_t+=$branch_count;
					$c_field_count_t+=$field_count;
					$c_total_count_t+=$total;
				}else{//Accessories
					$item_desc = alias($bal_row['item_code'],'ec_accessories','accessories_alias','accessory_description');
					$item_type="ACCESSORIES";
					$a_factory_count_t+=$factory_count;
					$a_branch_count_t+=$branch_count;
					$a_field_count_t+=$field_count;
					$a_total_count_t+=$total;
				}
				$sheet->SetCellValue('A'.$coo,$item_desc)
						->SetCellValue('B'.$coo, $item_type)
						->SetCellValue('C'.$coo, $factory_count)
						->SetCellValue('D'.$coo, $field_count)
						->SetCellValue('E'.$coo, $branch_count)
						->SetCellValue('F'.$coo, $total);
				$last_total = $coo;
			}
			if(!empty($c_total_count_t)){
				$last_total = $last_total+1;
				$sheet->getStyle("A".$last_total.":F".$last_total)->applyFromArray($styleArray);
				$sheet->getStyle("A".$last_total.":F".$last_total)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
				$sheet->SetCellValue('A'.$last_total, 'Grand Total')
						->SetCellValue('B'.$last_total, 'CELLS')
						->SetCellValue('C'.$last_total, $c_factory_count_t)
						->SetCellValue('D'.$last_total, $c_field_count_t)
						->SetCellValue('E'.$last_total, $c_branch_count_t)
						->SetCellValue('F'.$last_total, $c_total_count_t);
			}
			if(!empty($a_total_count_t)){
				$last_total = $last_total+1;
				$sheet->getStyle("A".$last_total.":F".$last_total)->applyFromArray($styleArray);
				$sheet->getStyle("A".$last_total.":F".$last_total)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
				$sheet->SetCellValue('A'.$last_total, 'Grand Total')
						->SetCellValue('B'.$last_total, 'ACCESSORIES')
						->SetCellValue('C'.$last_total, $a_factory_count_t)
						->SetCellValue('D'.$last_total, $a_field_count_t)
						->SetCellValue('E'.$last_total, $a_branch_count_t)
						->SetCellValue('F'.$last_total, $a_total_count_t);
			}
			$filename = 'Material_inward_balance_'.date('d-m-Y H_i_s');
			$sheet->setTitle('Material Inward Balance');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save("../../exports/$filename.xlsx");
			$result['file_name']=$filename;
			$resCode='0'; $resMsg='export';
		}else{$resCode='4'; $resMsg='No Records';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function material_outward_balance_export(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){
		if(isset($_REQUEST['warehouse']) && count($_REQUEST['warehouse']))$whouse = "'".implode("','",$_REQUEST['warehouse'])."'";else $whouse=getempwarehouse($emp_alias);
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$sheet = $objPHPExcel->getActiveSheet();
		$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
		$colArr=array('Product Name','Product Type','New to Field','New to Branch','Revived to Field','Revived to Branch','Scrap to Factory','Total');
		$last_key = end(array_keys($colArr));
		$last_alpha = num2alpha($last_key);
		$sheet->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
		$sheet->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
		$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue)); $ch++; }
		$c_new_2_field_t=$c_new_2_branch_t=$c_rev_2_field_t=$c_rev_2_branch_t=$c_scrap_2_fact_t=$c_total_count_t=$a_new_2_field_t=$a_new_2_branch_t=$a_rev_2_field_t=$a_rev_2_branch_t=$a_scrap_2_fact_t=$a_total_count_t=0;
		$bal_query_lim=mysqli_query($mr_con,"SELECT t2.item_type,t2.item_code,
				COUNT(CASE WHEN t2.item_condition='1' && t1.from_type='1' THEN t2.id END) AS new_to_field,
				COUNT(CASE WHEN t2.item_condition='2' && t1.from_type='1' THEN t2.id END) AS new_to_branch,
				COUNT(CASE WHEN t2.item_condition='1' && t1.from_type='3' THEN t2.id END) AS revived_to_field,
				COUNT(CASE WHEN t2.item_condition='2' && t1.from_type='3' THEN t2.id END) AS revived_to_branch,
				COUNT(CASE WHEN t2.item_condition IN ('3','4') && t1.from_type='2' THEN t2.id END) AS scrap_to_factory
		FROM ec_material_outward t1 INNER JOIN ec_material_sent_details t2 ON t1.alias=t2.reference WHERE t1.from_wh IN ($whouse) AND ".open_date("t1.date_of_trans")." t1.flag='0' GROUP BY t2.item_code");
		if(mysqli_num_rows($bal_query_lim)>'0'){ $coo=1;
			while($bal_row=mysqli_fetch_array($bal_query_lim)){ $coo++;
				$new_to_field=$bal_row['new_to_field'];
				$new_to_branch=$bal_row['new_to_branch'];
				$revived_to_field=$bal_row['revived_to_field'];
				$revived_to_branch=$bal_row['revived_to_branch'];
				$scrap_to_factory=$bal_row['scrap_to_factory'];
				$total=$new_to_field+$new_to_branch+$revived_to_field+$revived_to_branch+$scrap_to_factory;
				if($bal_row['item_type']=='1'){//Cells
					$item_desc = alias($bal_row['item_code'],'ec_product','product_alias','product_description');
					$item_type="CELLS";
					$c_new_2_field_t+=$new_to_field;
					$c_new_2_branch_t+=$new_to_branch;
					$c_rev_2_field_t+=$revived_to_field;
					$c_rev_2_branch_t+=$revived_to_branch;
					$c_scrap_2_fact_t+=$scrap_to_factory;
					$c_total_count_t+=$total;
				}else{//Accessories
					$item_desc = alias($bal_row['item_code'],'ec_accessories','accessories_alias','accessory_description');
					$item_type="ACCESSORIES";
					$a_new_2_field_t+=$new_to_field;
					$a_new_2_branch_t+=$new_to_branch;
					$a_rev_2_field_t+=$revived_to_field;
					$a_rev_2_branch_t+=$revived_to_branch;
					$a_scrap_2_fact_t+=$scrap_to_factory;
					$a_total_count_t+=$total;
				}
				$sheet->SetCellValue('A'.$coo,$item_desc)
						->SetCellValue('B'.$coo, $item_type)
						->SetCellValue('C'.$coo, $new_to_field)
						->SetCellValue('D'.$coo, $new_to_branch)
						->SetCellValue('E'.$coo, $revived_to_field)
						->SetCellValue('F'.$coo, $revived_to_branch)
						->SetCellValue('G'.$coo, $scrap_to_factory)
						->SetCellValue('H'.$coo, $total);
				$last_total = $coo;
			}
			if(!empty($c_total_count_t)){
				$last_total = $last_total+1;
				$sheet->getStyle("A".$last_total.":H".$last_total)->applyFromArray($styleArray);
				$sheet->getStyle("A".$last_total.":H".$last_total)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
				$sheet->SetCellValue('A'.$last_total, 'Grand Total')
						->SetCellValue('B'.$last_total, 'CELLS')
						->SetCellValue('C'.$last_total, $c_new_2_field_t)
						->SetCellValue('D'.$last_total, $c_new_2_branch_t)
						->SetCellValue('E'.$last_total, $c_rev_2_field_t)
						->SetCellValue('F'.$last_total, $c_rev_2_branch_t)
						->SetCellValue('G'.$last_total, $c_scrap_2_fact_t)
						->SetCellValue('H'.$last_total, $c_total_count_t);
			}
			if(!empty($a_total_count_t)){
				$last_total = $last_total+1;
				$sheet->getStyle("A".$last_total.":H".$last_total)->applyFromArray($styleArray);
				$sheet->getStyle("A".$last_total.":H".$last_total)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
				$sheet->SetCellValue('A'.$last_total, 'Grand Total')
						->SetCellValue('B'.$last_total, 'ACCESSORIES')
						->SetCellValue('C'.$last_total, $a_new_2_field_t)
						->SetCellValue('D'.$last_total, $a_new_2_branch_t)
						->SetCellValue('E'.$last_total, $a_rev_2_field_t)
						->SetCellValue('F'.$last_total, $a_rev_2_branch_t)
						->SetCellValue('G'.$last_total, $a_scrap_2_fact_t)
						->SetCellValue('H'.$last_total, $a_total_count_t);
			}
			$filename = 'Material_outward_balance_'.date('d-m-Y H_i_s');
			$sheet->setTitle('Material Outward Balance');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save("../../exports/$filename.xlsx");
			$result['file_name']=$filename;
			$resCode='0'; $resMsg='export';
		}else{$resCode='4'; $resMsg='No Records';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function material_revival_add(){ 
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){ $result = array();
		$wh_alias = $_REQUEST['wh_alias'];
		$cell_sr_no = $_REQUEST['cell_sr_no'];
		$mf_date = $_REQUEST['mf_date'];
		$ocv = $_REQUEST['ocv'];
		$dis_current = $_REQUEST['dis_current'];
		$a = $_REQUEST['a'];
		$b = $_REQUEST['b'];
		$c = $_REQUEST['c'];
		$d = $_REQUEST['d'];
		$e = $_REQUEST['e'];
		$f = $_REQUEST['f'];
		$g = $_REQUEST['g'];
		$h = $_REQUEST['h'];
		$i = $_REQUEST['i'];
		$j = $_REQUEST['j'];
		$result = $_REQUEST['result'];
		$eng_name = $_REQUEST['eng_name'];
		if(empty($eng_name)){ $res="Please Enter Engineer Name";}
		elseif(!isset($_FILES['pdf']['name']) || empty($_FILES['pdf']['name']))$res = 'Upload PDF report';
		elseif(count($cell_sr_no)=='0' || count($result)=='0') $res="Please Select atleast one result";
		elseif(count($cell_sr_no) != count($result)) $res="Please Choose all the results";
		else{
			foreach($result as $k=>$ree) {
				if(empty($mf_date[$k])){
					$res="Enter Manufacturing Date for non empty result"; 
					break;
				}elseif(empty($a[$k]) && empty($b[$k]) && empty($c[$k]) && empty($d[$k]) && empty($e[$k]) && empty($f[$k]) && empty($g[$k]) && empty($h[$k]) && empty($i[$k]) && empty($j[$k])){
					$res="Enter atleast any one Hour reading for non empty result"; 
					break;
				}
			}
			if(empty($res)){
				$revival_no = '#'.rand(000000,999999);
				$link = upload_file($_FILES['pdf'],'revival','pdf');
				list($code,$msg) = explode(",",$link);
				if($code=='0'){ $pdf = $msg;
					$item_alias = aliasCheck(generateRandomString(),'ec_material_revival','item_alias');
					$wh_code=alias($wh_alias,'ec_warehouse','wh_alias','wh_code');
					for($n=0;$n<count($cell_sr_no);$n++){
						if(!empty($result[$n])){
							if($result[$n]=='6')$revivalStage=1;else $revivalStage=0;
							$revInsertQuery = "INSERT INTO ec_material_revival(revival_no,wh_alias,cell_sr_no,mf_date,ocv,dis_current,`1hr`, `2hr`, `3hr`, `4hr`, `5hr`, `6hr`, `7hr`, `8hr`, `9hr`, `10hr`, result, pdf,eng_name,item_alias)VALUES('$revival_no','$wh_alias','$cell_sr_no[$n]','$mf_date[$n]','$ocv[$n]','$dis_current[$n]','$a[$n]','$b[$n]','$c[$n]','$d[$n]','$e[$n]','$f[$n]','$g[$n]','$h[$n]','$i[$n]','$j[$n]','$result[$n]','$pdf','$eng_name','$item_alias')";
							$sql = mysqli_query($mr_con, $revInsertQuery);
							mysqli_query($mr_con,"UPDATE ec_total_cell SET condition_id='".$result[$n]."', revivalStage='$revivalStage',transDate='".date('Y-m-d')."' WHERE cell_alias='".$cell_sr_no[$n]."' AND flag=0");
							cellhistoryinsert($cell_sr_no[$n],"Revival is done against revival no. $revival_no in Warehouse \'".$wh_code."\' and cell current ".($result[$n]=='6' ? 'stage is REVIVAL IN PROGRESS' : "Condition is ".($result[$n]=='2'  ? 'REVIVED':'SCRAP')).".");
						}
					}
					if($sql){
						$resCode='0'; $resMsg="Successful ".$revival_no." Revival Created";
						$action=$msg="Material revived with reference no - $revival_no in warehouse - $wh_code on dated - ".date('d-m-Y H:i:s');
						$xx=localURL()."services/inventory/mails/mremails?a=".$item_alias;
						curlxing($xx);
						inventory_notification($item_alias,$msg,'7');
						user_history($emp_alias,$action,$_REQUEST['ip_addr']);
					}
				}else $res = "Error in uploading PDF, $msg";
			}
		}if(isset($res)){$resCode='4'; $resMsg=$res;}
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function material_revival_update(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){ $result = array();
		$revival_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['revival_alias'])));
		$eng_name = $_REQUEST['eng_name'];
		$cell_sr_no = $_REQUEST['cell_sr_no'];
		$mf_date = $_REQUEST['mf_date'];
		$ocv = $_REQUEST['ocv'];
		$dis_current = $_REQUEST['dis_current'];
		$a = $_REQUEST['a'];
		$b = $_REQUEST['b'];
		$c = $_REQUEST['c'];
		$d = $_REQUEST['d'];
		$e = $_REQUEST['e'];
		$f = $_REQUEST['f'];
		$g = $_REQUEST['g'];
		$h = $_REQUEST['h'];
		$i = $_REQUEST['i'];
		$j = $_REQUEST['j'];
		if(isset($_REQUEST['result']) && count($_REQUEST['result'])>0)$result = $_REQUEST['result'];
		if(count($cell_sr_no) != count(array_filter($result))){ $res = "Please Choose all the results";}
		elseif(empty($eng_name)){ $res="Please Enter Engineer Name";}
		else{
			if(isset($_FILES['pdf']['name']) && !empty($_FILES['pdf']['name'])){
				$link = upload_file($_FILES['pdf'],'revival','pdf');
				list($code,$msg) = explode(",",$link);
				if($code=='0'){ $pdf = $msg;
					$revival_no = alias($revival_alias,'ec_material_revival','item_alias','revival_no');
					$wh_code=alias(alias($revival_alias,'ec_material_revival','item_alias','wh_alias'),'ec_warehouse','wh_alias','wh_code');
					for($n=0;$n<count($cell_sr_no);$n++){
						if($_REQUEST['result'][$n]=='6')$revivalStage=1;else $revivalStage=0;
						$sql = mysqli_query($mr_con,"UPDATE ec_material_revival SET mf_date='$mf_date[$n]',ocv='$ocv[$n]',dis_current='$dis_current[$n]',1hr='$a[$n]',2hr='$b[$n]',3hr='$c[$n]',4hr='$d[$n]',5hr='$e[$n]',6hr='$f[$n]',7hr='$g[$n]',8hr='$h[$n]',9hr='$i[$n]',10hr='$j[$n]',result='$result[$n]',pdf='$pdf' WHERE item_alias='$revival_alias' AND cell_sr_no='$cell_sr_no[$n]' AND flag=0");
						mysqli_query($mr_con,"UPDATE ec_total_cell SET condition_id='".$result[$n]."', revivalStage='$revivalStage',transDate='".date('Y-m-d')."' WHERE cell_alias='".$cell_sr_no[$n]."' AND flag=0");
						if($result[$n]=='2')mysqli_query($mr_con,"UPDATE ec_item_code SET invoice_no='-' WHERE invoice_no='NA' AND item_code_alias='".$cell_sr_no[$n]."' AND flag=0");
						cellhistoryinsert($cell_sr_no[$n],"Revival updated against revival no. $revival_no in Warehouse \'".$wh_code."\' and cell current ".($result[$n]=='6' ? 'stage is REVIVAL IN PROGRESS' : "Condition is ".($result[$n]=='2'  ? 'REVIVED':'SCRAP')).".");
					}
					if(empty(count($cell_sr_no))){$res="There is no updation";}
					elseif($sql){
						if(isset($_REQUEST['old_pdf'])){@unlink("images/reports/".$_REQUEST['old_pdf']);}
						$action="Material revival updated with reference no - $revival_no in warehouse - $wh_code on dated - ".date('d-m-Y H:i:s');
						user_history($emp_alias,$action,$_REQUEST['ip_addr']);
						inventory_notification($revival_alias,$action,'7');
						$resCode='0';$resMsg='Successful!';
					}else{$res="Error In Updating";}
				}else{$res = 'Error in uploading PDF, Try again!';}
			}else{$res = 'Upload PDF report';}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function material_revival_adv_edit(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$revival_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['revival_alias'])));
		$eng_name = $_REQUEST['eng_name'];
		$cell_sr_no_alias = $_REQUEST['cell_sr_no_alias'];
		$mf_date = $_REQUEST['mf_date'];
		$ocv = $_REQUEST['ocv'];
		$dis_current = $_REQUEST['dis_current'];
		$a = $_REQUEST['a'];
		$b = $_REQUEST['b'];
		$c = $_REQUEST['c'];
		$d = $_REQUEST['d'];
		$e = $_REQUEST['e'];
		$f = $_REQUEST['f'];
		$g = $_REQUEST['g'];
		$h = $_REQUEST['h'];
		$i = $_REQUEST['i'];
		$j = $_REQUEST['j'];
		if(empty($eng_name)){ $res="Please Enter Engineer Name";}
		else{ $con="";$check=TRUE;
			if(isset($_FILES['pdf']['name']) && !empty($_FILES['pdf']['name'])){
				$link = upload_file($_FILES['pdf'],'revival','pdf');
				list($code,$pdf) = explode(",",$link);
				if($code=='0')$con=",pdf='$pdf'";
				else{$check=FALSE;$res = 'Error in uploading PDF, Try again!';}
			}
			if($check){
				for($n=0;$n<count($cell_sr_no_alias);$n++)$sql = mysqli_query($mr_con,"UPDATE ec_material_revival SET eng_name='$eng_name',mf_date='$mf_date[$n]',ocv='$ocv[$n]',dis_current='$dis_current[$n]',1hr='$a[$n]',2hr='$b[$n]',3hr='$c[$n]',4hr='$d[$n]',5hr='$e[$n]',6hr='$f[$n]',7hr='$g[$n]',8hr='$h[$n]',9hr='$i[$n]',10hr='$j[$n]' $con WHERE item_alias='$revival_alias' AND cell_sr_no='$cell_sr_no_alias[$n]' AND flag=0");
				if(empty(count($cell_sr_no_alias))){$res="There is no updation";}
				elseif($sql){
					if(isset($_REQUEST['old_pdf'])){@unlink("images/reports/".$_REQUEST['old_pdf']);}
					$action="Material revival advance edit done with reference no - ".alias($revival_alias,'ec_material_revival','item_alias','revival_no')." in warehouse - ".alias(alias($revival_alias,'ec_material_revival','item_alias','wh_alias'),'ec_warehouse','wh_alias','wh_code')." on dated - ".date('d-m-Y H:i:s');
					user_history($emp_alias,$action,$_REQUEST['ip_addr']);
					$resCode='0';$resMsg='Successful!';
				}else{$res="Error In Updating";}
			}	
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function material_revival_view(){ global $mr_con;
	$emp_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$token=mysqli_real_escape_string($mr_con,trim($_REQUEST['token']));
	$alias= mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_material_revival WHERE item_alias ='$alias' AND flag=0");
		if(mysqli_num_rows($sql)){ $wh_code=$capacity="";$cap_arr=$res_arr=array();
			$i=0;while($row=mysqli_fetch_array($sql)){
				$result['revival_no']=$row['revival_no'];
				$result['revival_alias']=$alias;
				if(empty($wh_code))$wh_code = alias($row['wh_alias'],'ec_warehouse','wh_alias','wh_code');
				$result['wh_code']= $wh_code;
				$item_code = alias($row['cell_sr_no'],'ec_item_code','item_code_alias','item_code');
				if(!array_key_exists($item_code,$cap_arr))$cap_arr[$item_code]=alias($item_code,'ec_product','product_alias','product_description');
				$result['type'][$i]['capacity']=$cap_arr[$item_code];
				$result['type'][$i]['cell_sr_no']=alias($row['cell_sr_no'],'ec_item_code','item_code_alias','item_description');
				$result['type'][$i]['cell_sr_no_alias']=$row['cell_sr_no'];
				$result['type'][$i]['mf_date']=$row['mf_date'];
				$result['type'][$i]['ocv']=$row['ocv'];
				$result['type'][$i]['dis_current']=$row['dis_current'];
				$result['type'][$i]['a']=$row['1hr'];
				$result['type'][$i]['b']=$row['2hr'];
				$result['type'][$i]['c']=$row['3hr'];
				$result['type'][$i]['d']=$row['4hr'];
				$result['type'][$i]['e']=$row['5hr'];
				$result['type'][$i]['f']=$row['6hr'];
				$result['type'][$i]['g']=$row['7hr'];
				$result['type'][$i]['h']=$row['8hr'];
				$result['type'][$i]['i']=$row['9hr'];
				$result['type'][$i]['j']=$row['10hr'];
				$result['type'][$i]['result']=$row['result'];
				if($row['result']=='6'){$res_arr[] = $result_text = 'In Progress';}
				elseif($row['result']=='2'){$result_text = 'Pass';}
				elseif($row['result']=='3'){$result_text = 'Fail';}
				else{$result_text = '';}
				$result['type'][$i]['result_text']=$result_text;
				$result['type'][$i]['disable']=($row['result']!=6 && $row['result']!='' ? TRUE : FALSE);
				$result['pdf']=$row['pdf'];
				$result['eng_name']=$row['eng_name'];
				$result['createdDate']=$row['createdDate'];
			$i++;}
			$result['edit']=(grantable('EDIT','REVIVAL',$emp_alias) && in_array('In Progress',$res_arr) ? TRUE : FALSE);
			$result['adv_edit']=($emp_alias=='ADMIN' ? TRUE : FALSE);
		}else{$resCode='4';$resMsg='No Records Found!';}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function material_revival_mul_view(){ global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){$condtion="";
		if($_REQUEST['revival_no']!="")$condtion.="t1.revival_no LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['revival_no'])."%' AND ";
		if($_REQUEST['transDate']!="")$condtion.="t1.createdDate LIKE '%".dateFormat(mysqli_real_escape_string($mr_con,$_REQUEST['transDate']),'y')."%' AND ";
		if($_REQUEST['wh_alias']!="")$condtion.="t2.wh_code LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['wh_alias'])."%' AND ";
		if($_REQUEST['eng_name']!="")$condtion.="t1.eng_name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['eng_name'])."%' AND ";
		if(!admin_privilege($emp_alias))$condtion.="t2.wh_alias IN('".str_replace(", ","','",alias($emp_alias,'ec_employee_master','employee_alias','wh_alias'))."') AND ";
		$row=mysqli_fetch_array(mysqli_query($mr_con,"SELECT COUNT(DISTINCT(t1.item_alias)) AS num FROM ec_material_revival t1 INNER JOIN ec_warehouse t2 ON t1.wh_alias=t2.wh_alias WHERE $condtion t1.flag=0"));
		$result['requestDetails']=array();
		if($row['num']>'0'){
			$totalRecords=$row['num'];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT t1.createdDate, t1.revival_no, t2.wh_code, t1.item_alias, t1.eng_name, t1.pdf FROM ec_material_revival t1 INNER JOIN ec_warehouse t2 ON t1.wh_alias=t2.wh_alias WHERE $condtion t1.flag=0 GROUP BY t1.item_alias ORDER BY t1.id DESC LIMIT $offset, $limit");
			if(mysqli_num_rows($sql)){ $i=0;
				while($row = mysqli_fetch_array($sql)){
					$result['requestDetails'][$i]['createdDate']=dateFormat($row['createdDate'],'y');
					$result['requestDetails'][$i]['revival_no']=$row['revival_no'];
					$result['requestDetails'][$i]['revival_alias']=$row['item_alias'];
					$result['requestDetails'][$i]['wh_code']=$row['wh_code'];
					$result['requestDetails'][$i]['eng_name']=$row['eng_name'];
					$result['requestDetails'][$i]['pdf']=$row['pdf'];
				$i++;}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}else{$resCode='4'; $resMsg='No Records Found';}
	}elseif($rex=='1'){ $resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	$result['add']=grantable('ADD','REVIVAL',$emp_alias);
	$result['advedit']=grantable('ADV EDIT','REVIVAL',$emp_alias);
	$result['delete']=grantable('DELETE','REVIVAL',$emp_alias);
	$result['export']=grantable('EXPORT','REVIVAL',$emp_alias);
	echo json_encode($result);
}
function material_revival_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	$grantable = grantable('DELETE','REVIVAL',$emp_alias);
	if(!$grantable){
		$resCode = 1;
		$resMsg='Authentication Failed!';
	}
	if($grantable && $rex==0) {
			
		$revival_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['revival_alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($revival_alias)) {
			$res="Invalid Request";
		} else {
			$query = "SELECT * FROM ec_material_revival WHERE item_alias = '$revival_alias' limit 1";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql)== 1) {
				$revivalDetails = mysqli_fetch_assoc($sql);
				$revival_no = $revivalDetails['revival_no'];
				$cell_sr_no = $revivalDetails['cell_sr_no'];
				$query = "UPDATE ec_material_revival set `flag` = '9' where item_alias = '$revival_alias'";
				$totcellquery = "UPDATE ec_total_cell SET condition_id='5', revivalStage='0' WHERE cell_alias='$cell_sr_no' AND flag=0";
				$sql = mysqli_query($mr_con, $query);
				$totcellsql = mysqli_query($mr_con, $totcellquery);
				if($sql && $totcellsql) {
					$action = "Material Revival with req no $revival_no is deleted";
					user_history($emp_alias, $action, $_REQUEST['ip_addr'], $remarks);
					$resCode='0';$resMsg='Successful!';
				} else {
					$res = 'Failed to delete revival.';	
				}
			}else{$res = "Revival doesn't exist."; }
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function material_refreshing_add(){ 
	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$result = array();
		$wh_alias = $_REQUEST['wh_alias'];
		$cell_sr_no = $_REQUEST['cell_sr_no'];
		$mf_date = $_REQUEST['mf_date'];
		$ocv = $_REQUEST['ocv'];
		$dis_current = $_REQUEST['dis_current'];
		$a = $_REQUEST['a'];
		$b = $_REQUEST['b'];
		$c = $_REQUEST['c'];
		$d = $_REQUEST['d'];
		$e = $_REQUEST['e'];
		$f = $_REQUEST['f'];
		$g = $_REQUEST['g'];
		$h = $_REQUEST['h'];
		$i = $_REQUEST['i'];
		$j = $_REQUEST['j'];
		$result = $_REQUEST['result'];
		$eng_name = $_REQUEST['eng_name'];
		if(empty($eng_name)){ $res="Please Enter Engineer Name";}
		elseif(!isset($_FILES['pdf']['name']) || empty($_FILES['pdf']['name']))$res = 'Upload PDF report';
		elseif(count($cell_sr_no)=='0' ||count($result)=='0') $res="Please Select atleast one result";
		elseif(count($cell_sr_no) != count($result)) $res="Please Choose all the results";
		else{
			foreach($result as $k=>$ree)if(empty($mf_date[$k])){ $res="Enter Manufacturing Date for non empty result"; break;}elseif(empty($a[$k]) && empty($b[$k]) && empty($c[$k]) && empty($d[$k]) && empty($e[$k]) && empty($f[$k]) && empty($g[$k]) && empty($h[$k]) && empty($i[$k]) && empty($j[$k])){ $res="Enter atleast any one Hour reading for non empty result"; break;}
			if(empty($res)){
				$refreshing_no = '#'.rand(000000,999999);
				$link = upload_file($_FILES['pdf'],'refreshing','pdf');
				list($code,$msg) = explode(",",$link);
				if($code=='0'){ $pdf = $msg;
					$item_alias = aliasCheck(generateRandomString(),'ec_material_refreshing','item_alias');
					$wh_code = alias($wh_alias,'ec_warehouse','wh_alias','wh_code');
					for($n=0;$n<count($cell_sr_no);$n++){
						if(!empty($result[$n])){
							//if($ocv[$n]!='' && $dis_current[$n]!=''){
								if($result[$n]=='6')$revivalStage=1;else $revivalStage=0;
								$sql = mysqli_query($mr_con,"INSERT INTO ec_material_refreshing(refreshing_no,wh_alias,cell_sr_no,mf_date,ocv,dis_current, `1hr`, `2hr`, `3hr`, `4hr`, `5hr`, `6hr`, `7hr`, `8hr`, `9hr`, `10hr`, result,pdf,eng_name,item_alias)VALUES('$refreshing_no','$wh_alias','$cell_sr_no[$n]','$mf_date[$n]','$ocv[$n]','$dis_current[$n]','$a[$n]','$b[$n]','$c[$n]','$d[$n]','$e[$n]','$f[$n]','$g[$n]','$h[$n]','$i[$n]','$j[$n]','0','$pdf','$eng_name','$item_alias')");
								mysqli_query($mr_con,"UPDATE ec_total_cell SET transDate='".date('Y-m-d')."' WHERE cell_alias='".$cell_sr_no[$n]."' AND flag=0");
							//}else { $res="Please Fill All OCV and Charging Current";}
							cellhistoryinsert($cell_sr_no[$n],"Refreshing is done against Refreshing no. $refreshing_no in Warehouse \'".$wh_code."\' and cell current ".($result[$n]=='6' ? 'stage is REVIVAL IN PROGRESS' : "Condition is ".($result[$n]=='2'  ? 'REVIVED':'SCRAP')).".");
						}
					}
					if($sql){
						$resCode='0'; $resMsg="Successful ".$refreshing_no." Refreshing Created";
						$action="Material refreshed with reference no - $refreshing_no in warehouse - $wh_code on dated - ".date('d-m-Y H:i:s');
						$xx=localURL()."services/inventory/mails/mrfmails?a=".$item_alias;
						curlxing($xx);
						inventory_notification($item_alias,$action,'8');
						user_history($emp_alias,$action,$_REQUEST['ip_addr']);
					}
				}else{$res = "Error in uploading PDF, $msg";}
			}
		}if(isset($res)){$resCode='4'; $resMsg=$res;}
	}elseif($rex==1){$resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function material_refreshing_update(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$result = array();
		$refreshing_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['refreshing_alias'])));
		$eng_name = $_REQUEST['eng_name'];
		$cell_sr_no = $_REQUEST['cell_sr_no'];
		$mf_date = $_REQUEST['mf_date'];
		$ocv = $_REQUEST['ocv'];
		$dis_current = $_REQUEST['dis_current'];
		$a = $_REQUEST['a'];
		$b = $_REQUEST['b'];
		$c = $_REQUEST['c'];
		$d = $_REQUEST['d'];
		$e = $_REQUEST['e'];
		$f = $_REQUEST['f'];
		$g = $_REQUEST['g'];
		$h = $_REQUEST['h'];
		$i = $_REQUEST['i'];
		$j = $_REQUEST['j'];
		if(isset($_REQUEST['result']) && count($_REQUEST['result'])>0)$result = $_REQUEST['result'];
		if(count($cell_sr_no) != count(array_filter($result))){ $res = "Please Choose all the results";}
		elseif(empty($eng_name)){ $res="Please Enter Engineer Name";}
		else{
			if(isset($_FILES['pdf']['name']) && !empty($_FILES['pdf']['name'])){
				$link = upload_file($_FILES['pdf'],'refreshing','pdf');
				list($code,$msg) = explode(",",$link);
				if($code=='0'){ $pdf = $msg;
					$refreshing_no = alias($refreshing_alias,'ec_material_refreshing','item_alias','refreshing_no');
					$wh_code=alias(alias($refreshing_alias,'ec_material_refreshing','item_alias','wh_alias'),'ec_warehouse','wh_alias','wh_code');
					for($n=0;$n<count($cell_sr_no);$n++){
						if($_REQUEST['result'][$n]=='6')$revivalStage=1;else $revivalStage=0;
						$sql = mysqli_query($mr_con,"UPDATE ec_material_refreshing SET cell_sr_no='$cell_sr_no[$n]',mf_date='$mf_date[$n]',ocv='$ocv[$n]',dis_current='$dis_current[$n]',1hr='$a[$n]',2hr='$b[$n]',3hr='$c[$n]',4hr='$d[$n]',5hr='$e[$n]',6hr='$f[$n]',7hr='$g[$n]',8hr='$h[$n]',9hr='$i[$n]',10hr='$j[$n]',result='0',pdf='$pdf' WHERE item_alias='$refreshing_alias' AND cell_sr_no='$cell_sr_no[$n]' AND flag=0");
						mysqli_query($mr_con,"UPDATE ec_total_cell SET transDate='".date('Y-m-d')."' WHERE cell_alias='".$cell_sr_no[$n]."' AND flag=0");
						cellhistoryinsert($cell_sr_no[$n],"Refreshing is updated against Refreshing no. $refreshing_no in Warehouse \'".$wh_code."\' and cell current ".($result[$n]=='6' ? 'stage is REVIVAL IN PROGRESS' : "Condition is ".($result[$n]=='2'  ? 'REVIVED':'SCRAP')).".");
					}
					if(empty(count($cell_sr_no))){$res="There is no updation";}
					elseif($sql){
						if(isset($_REQUEST['old_pdf'])){@unlink("images/reports/".$_REQUEST['old_pdf']);}
						$action="Material refreshing updated with reference no - $refreshing_no in warehouse - $wh_code on dated - ".date('d-m-Y H:i:s');
						$resCode='0';$resMsg='Successful!';
						user_history($emp_alias,$action,$_REQUEST['ip_addr']);
						inventory_notification($refreshing_alias,$action,'8');
					}else{$res="Error In Updating";}
				}else{$res = 'Error in uploading PDF, Try again!';}
			}else{$res = 'Upload PDF report';}
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function material_refreshing_adv_edit(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$refreshing_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['refreshing_alias'])));
		$eng_name = $_REQUEST['eng_name'];
		$cell_sr_no_alias = $_REQUEST['cell_sr_no_alias'];
		$mf_date = $_REQUEST['mf_date'];
		$ocv = $_REQUEST['ocv'];
		$dis_current = $_REQUEST['dis_current'];
		$a = $_REQUEST['a'];
		$b = $_REQUEST['b'];
		$c = $_REQUEST['c'];
		$d = $_REQUEST['d'];
		$e = $_REQUEST['e'];
		$f = $_REQUEST['f'];
		$g = $_REQUEST['g'];
		$h = $_REQUEST['h'];
		$i = $_REQUEST['i'];
		$j = $_REQUEST['j'];
		if(empty($eng_name)){ $res="Please Enter Engineer Name";}
		else{ $con="";$check=TRUE;
			if(isset($_FILES['pdf']['name']) && !empty($_FILES['pdf']['name'])){
				$link = upload_file($_FILES['pdf'],'refreshing','pdf');
				list($code,$pdf) = explode(",",$link);
				if($code=='0')$con=",pdf='$pdf'";
				else{$check=FALSE;$res = 'Error in uploading PDF, Try again!';}
			}
			if($check){
				for($n=0;$n<count($cell_sr_no_alias);$n++)$sql = mysqli_query($mr_con,"UPDATE ec_material_refreshing SET eng_name='$eng_name',mf_date='$mf_date[$n]',ocv='$ocv[$n]',dis_current='$dis_current[$n]',1hr='$a[$n]',2hr='$b[$n]',3hr='$c[$n]',4hr='$d[$n]',5hr='$e[$n]',6hr='$f[$n]',7hr='$g[$n]',8hr='$h[$n]',9hr='$i[$n]',10hr='$j[$n]' $con WHERE item_alias='$refreshing_alias' AND cell_sr_no='$cell_sr_no_alias[$n]' AND flag=0");
				if(empty(count($cell_sr_no_alias))){$res="There is no updation";}
				elseif($sql){
					if(isset($_REQUEST['old_pdf'])){@unlink("images/reports/".$_REQUEST['old_pdf']);}
					$action="Refreshing No ".alias($revival_alias,'ec_material_refreshing','item_alias','refreshing_no')." advance Edit Done";
					user_history($emp_alias,$action,$_REQUEST['ip_addr']);
					$resCode='0';$resMsg='Successful!';
				}else{$res="Error In Updating";}
			}	
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function material_refreshing_view(){ global $mr_con;
	$emp_alias=strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$token=mysqli_real_escape_string($mr_con,trim($_REQUEST['token']));
	$alias= mysqli_real_escape_string($mr_con,trim($_REQUEST['alias']));
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$rex=authentication($emp_alias,$token);
	if($rex==0){
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_material_refreshing WHERE item_alias ='$alias' AND flag=0");
		if(mysqli_num_rows($sql)){ $wh_code=$capacity ="";$cap_arr=array();
			$i=0;while($row=mysqli_fetch_array($sql)){
				$result['refreshing_no']=$row['refreshing_no'];
				$result['refreshing_alias']=$alias;
				if(empty($wh_code))$wh_code = alias($row['wh_alias'],'ec_warehouse','wh_alias','wh_code');
				$result['wh_code']= $wh_code;
				$result['type'][$i]['cell_sr_no_alias']=$row['cell_sr_no'];
				$item_code = alias($row['cell_sr_no'],'ec_item_code','item_code_alias','item_code');
				if(!array_key_exists($item_code,$cap_arr))$cap_arr[$item_code]=alias($item_code,'ec_product','product_alias','product_description');
				$result['type'][$i]['capacity']=$cap_arr[$item_code];
				$result['type'][$i]['cell_sr_no']=alias($row['cell_sr_no'],'ec_item_code','item_code_alias','item_description');
				$result['type'][$i]['mf_date']=$row['mf_date'];
				$result['type'][$i]['ocv']=$row['ocv'];
				$result['type'][$i]['dis_current']=$row['dis_current'];
				$result['type'][$i]['a']=$row['1hr'];
				$result['type'][$i]['b']=$row['2hr'];
				$result['type'][$i]['c']=$row['3hr'];
				$result['type'][$i]['d']=$row['4hr'];
				$result['type'][$i]['e']=$row['5hr'];
				$result['type'][$i]['f']=$row['6hr'];
				$result['type'][$i]['g']=$row['7hr'];
				$result['type'][$i]['h']=$row['8hr'];
				$result['type'][$i]['i']=$row['9hr'];
				$result['type'][$i]['j']=$row['10hr'];
				$result['type'][$i]['result']=$row['result'];
				if($row['result']=='6'){$result_text = 'In Progress';}
				elseif($row['result']=='2'){$result_text = 'Pass';}
				elseif($row['result']=='3'){$result_text = 'Fail';}
				elseif($row['result']=='0'){$result_text = 'Charged';}
				else{$result_text = '';}
				$result['type'][$i]['result_text']=$result_text;
				$result['type'][$i]['disable']=($row['result']!=6 && $row['result']!='' ? TRUE : FALSE);
				$result['pdf']=$row['pdf'];
				$result['eng_name']=$row['eng_name'];
				$result['createdDate']=$row['createdDate'];
			$i++;}
			$result['edit']=grantable('EDIT','REFRESHING',$emp_alias);
			$result['adv_edit']=($emp_alias=='ADMIN' ? TRUE : FALSE);
		}else{$resCode='4';$resMsg='No Records Found!';}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function material_refreshing_mul_view(){ 
	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){$condtion="";
		if($_REQUEST['refreshing_no']!="")$condtion.="t1.refreshing_no LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['refreshing_no'])."%' AND ";
		if($_REQUEST['transDate']!="")$condtion.="t1.createdDate LIKE '%".dateFormat(mysqli_real_escape_string($mr_con,$_REQUEST['transDate']),'y')."%' AND ";
		if($_REQUEST['wh_alias']!="")$condtion.="t2.wh_code LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['wh_alias'])."%' AND ";
		if($_REQUEST['eng_name']!="")$condtion.="t1.eng_name LIKE '%".mysqli_real_escape_string($mr_con,$_REQUEST['eng_name'])."%' AND ";
		if(!admin_privilege($emp_alias))$condtion.="t2.wh_alias IN('".str_replace(", ","','",alias($emp_alias,'ec_employee_master','employee_alias','wh_alias'))."') AND ";
		$row=mysqli_fetch_array(mysqli_query($mr_con,"SELECT COUNT(DISTINCT(t1.item_alias)) AS num FROM ec_material_refreshing t1 INNER JOIN ec_warehouse t2 ON t1.wh_alias=t2.wh_alias WHERE $condtion t1.flag=0"));
		$result['requestDetails']=array();
		if($row['num']>'0'){
			$totalRecords=$row['num'];
			if(isset($_REQUEST['perpagecount']) && $_REQUEST['perpagecount']!="")$limit=mysqli_real_escape_string($mr_con,$_REQUEST['perpagecount']);else $limit=10;
			if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!="")$pageNo=mysqli_real_escape_string($mr_con,$_REQUEST['page_no']);else $pageNo=1;
			if(is_float($totalRecords/$limit)){$ax=explode(".",($totalRecords/$limit));$totalpages=$ax[0]+1;}else{$totalpages=$totalRecords/$limit;}
			$offset=(($limit*$pageNo)-$limit);
			$fromRecord=(($limit*$pageNo)-$limit)+1;
			if(($limit*$pageNo)>$totalRecords)$toRecord=$totalRecords;else $toRecord=$limit*$pageNo;
			$sql = mysqli_query($mr_con,"SELECT t1.createdDate, t1.refreshing_no, t2.wh_code, t1.item_alias, t1.eng_name, t1.pdf FROM ec_material_refreshing t1 INNER JOIN ec_warehouse t2 ON t1.wh_alias=t2.wh_alias WHERE $condtion t1.flag=0 GROUP BY t1.item_alias ORDER BY t1.id DESC LIMIT $offset, $limit");
			if(mysqli_num_rows($sql)){ $i=0;
				while($row = mysqli_fetch_array($sql)){
					$result['requestDetails'][$i]['createdDate']=dateFormat($row['createdDate'],'y');
					$result['requestDetails'][$i]['refreshing_no']=$row['refreshing_no'];
					$result['requestDetails'][$i]['refreshing_alias']=$row['item_alias'];
					$result['requestDetails'][$i]['wh_code']=$row['wh_code'];
					$result['requestDetails'][$i]['eng_name']=$row['eng_name'];
					$result['requestDetails'][$i]['pdf']=$row['pdf'];
				$i++;}
				$resCode='0'; $resMsg='Successful!';
			}else{$resCode='4'; $resMsg='No Records Found';}
		}else{$resCode='4'; $resMsg='No Records Found';}
	}elseif($rex==1){ $resCode='1'; $resMsg='Authentication Failed';
	}else{$resCode='2'; $resMsg='Account Locked';}
	$result['ErrorCode']=$resCode; $result['ErrorMessage']=$resMsg;
	$result['fromRecords']=$fromRecord;
	$result['toRecords']=$toRecord;
	$result['totalRecords']=$totalRecords;
	if($totalRecords>=1)for($x=0;$x<=$totalpages;$x++)$result['pages'][$x]=$x; else $result['pages'][1]=1;
	$result['add']=grantable('ADD','REFRESHING',$emp_alias);
	$result['advedit']=grantable('ADV EDIT','REFRESHING',$emp_alias);
	$result['delete']=grantable('DELETE','REFRESHING',$emp_alias);
	$result['export']=grantable('EXPORT','REFRESHING',$emp_alias);
	echo json_encode($result);
}
function material_refreshing_delete() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['emp_alias'])));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	$grantable = grantable('DELETE','REFRESHING',$emp_alias);
	if(!$grantable){
		$resCode = 1;
		$resMsg='Authentication Failed!';
	}
	if($grantable && $rex==0) {
			
		$refreshing_alias = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['refreshing_alias'])));
		$remarks = strtoupper(mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks'])));
		if(empty($remarks)) {
			$res="Provide remarks";
		} else if(empty($refreshing_alias)) {
			$res="Invalid Request";
		} else {
			$query = "SELECT * FROM ec_material_refreshing WHERE item_alias = '$refreshing_alias'";
			$sql = mysqli_query($mr_con, $query);
			if(mysqli_num_rows($sql) > 0) {
				while($refreshingDetails = mysqli_fetch_array($sql)){
					$refreshing_no = $refreshingDetails['refreshing_no'];
					$p60Days = date('Y-m-d', strtotime('-90 day', strtotime(date('Y-m-d'))));
					$totalCellQuery = "UPDATE ec_total_cell SET transDate='".$p60Days."' WHERE cell_alias='" . $refreshingDetails['cell_sr_no'] . "' AND flag=0";
					$totalCellSql = mysqli_query($mr_con, $totalCellQuery);
				}
				$query = "UPDATE ec_material_refreshing set `flag` = '9' where item_alias = '$refreshing_alias'";
				$sql = mysqli_query($mr_con, $query);
				if($sql) {
					$action = "Material Refreshing with req no $refreshing_no is deleted";
					user_history($emp_alias, $action, $_REQUEST['ip_addr'], $remarks);
					$resCode='0';$resMsg='Successful!';
				} else {
					$res = 'Failed to delete refreshing.';	
				}
			}else{$res = "Refreshing doesn't exist."; }
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function total_cell_revival(){ 
	global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT cell_alias FROM ec_total_cell WHERE location='".$_REQUEST['alias']."' AND condition_id IN('5','6') AND revivalStage='0' AND flag=0");
	$result = array();
	if(mysqli_num_rows($sql)){
		$i=0;
		while($row=mysqli_fetch_array($sql)) { 
			$result[$i]['alias']=$row['cell_alias']; 
			$result[$i]['name']=alias($row['cell_alias'],'ec_item_code','item_code_alias','item_description'); 
			$i++;
		}
	}
	echo json_encode($result);
}
function total_cell_refreshing(){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT cell_alias FROM ec_total_cell WHERE location='".$_REQUEST['alias']."'AND flag=0 AND condition_id IN('1','2') AND transDate<= CURRENT_DATE - INTERVAL 60 DAY");
	$result = array();
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['cell_alias']; $result[$i]['name']=alias($row['cell_alias'],'ec_item_code','item_code_alias','item_description'); $i++;}
	}
	echo json_encode($result);
}
function state_whcode_drop(){ global $mr_con;
	$emp_alias = $_REQUEST['alias'];
	if(strtoupper($emp_alias)=='ADMIN'){$data='';}
	else{
		$s=mysqli_query($mr_con,"SELECT state_alias FROM ec_employee_master WHERE employee_alias ='$emp_alias' AND flag=0");
		$row=mysqli_fetch_array($s);
		$state_alias=$row['state_alias'];
		$data="state_alias IN ('".implode("','",explode(", ",$state_alias))."') AND";
	}
	$sql=mysqli_query($mr_con,"SELECT wh_code,wh_alias FROM ec_warehouse WHERE $data flag=0 ORDER BY wh_code ASC");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result[$i]['alias']=$row['wh_alias'];$result[$i]['name']=$row['wh_code']; $i++;}
	}//else{$result[0]['alias']='4';$result[0]['name']='No Records Found';}
	echo json_encode($result);
}
//Material Balance Service Ends
function cellhistoryinsert($celln,$mes){ global $mr_con;
	if($mes !="" && $celln!="")$sql=mysqli_query($mr_con,"INSERT INTO ec_total_cell_history(`cell_alias`, `message`)VALUES('$celln','$mes')");
}
function itemTypenumeric($fv1){
	if($fv1=="CELLS" || $fv1=="CELL") return '1';
	else return '2';
}
function getstockforwh_sjo($fv0,$fv1,$fv2,$fv3){ global $mr_con;
	//$state=alias($fv1,'ec_employee_master','employee_alias','state_alias');
	//$sql=mysqli_query($mr_con,"SELECT cell_alias FROM ec_total_cell WHERE location ='$fv1' AND stage='0' AND condition_id IN ('1','2') AND cell_alias IN (SELECT item_code_alias FROM ec_item_code WHERE item_code='$fv2' AND sjo_no='$fv3' AND flag=0) AND flag=0");
	//$sql=mysqli_query($mr_con,"SELECT cell_alias FROM ec_total_cell WHERE location ='$fv1' AND stage='0' AND condition_id IN ('1','2') AND item_code='$fv2' AND flag=0");
	if(alias($fv1,'ec_warehouse','wh_alias','wh_type')=='1'){
		$sql=mysqli_query($mr_con,"SELECT cell_alias FROM ec_total_cell WHERE location ='$fv1' AND stage='0' AND condition_id IN ('1','2') AND cell_alias IN (SELECT item_code_alias FROM ec_item_code WHERE item_code='$fv2' AND cell_type='$fv0' AND sjo_no='$fv3' AND flag=0) AND flag=0");
	}else{
		$sql=mysqli_query($mr_con,"SELECT cell_alias FROM ec_total_cell WHERE location ='$fv1' AND stage='0' AND condition_id IN ('1','2') AND item_code='$fv2' AND flag=0");
	}
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result1[$i]['alias1']=$row['cell_alias'];$result1[$i]['name1']=alias($row['cell_alias'],'ec_item_code','item_code_alias','item_description'); $i++;}
	}else{$result1['norec']=0;}//$result1[0]['alias1']='4';$result1[0]['name1']='No Records Found';}
	return $result1;
}
function getstockforwh($fv1,$fv2){ global $mr_con;
	//$state=alias($fv1,'ec_employee_master','employee_alias','state_alias');
	$sql=mysqli_query($mr_con,"SELECT cell_alias FROM ec_total_cell WHERE location ='$fv1' AND stage='0' AND condition_id IN ('1','2') AND item_code='$fv2' AND flag=0");
	if(mysqli_num_rows($sql)){
		$i=0;while($row=mysqli_fetch_array($sql)){ $result1[$i]['alias1']=$row['cell_alias'];$result1[$i]['name1']=alias($row['cell_alias'],'ec_item_code','item_code_alias','item_description'); $i++;}
	}else{$result1[0]['alias1']='4';$result1[0]['name1']='No Records Found';}
	return $result1;
}
function quantity_cells($fv2,$fv1){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT count(id) as quanty_count FROM ec_total_cell WHERE location ='$fv1' AND item_code='$fv2' AND flag=0");
	if(mysqli_num_rows($sql)>0){
		$row=mysqli_fetch_array($sql);
		return $row['quanty_count'];
	}else return 0;
}
function material_request_export(){ global $mr_con;
	set_time_limit(0);
	ini_set('memory_limit', '512M');
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){$a=$b=$c="";
		//if(isset($_REQUEST['data_filter']) && $_REQUEST['data_filter']!=""){
			if(isset($_REQUEST['from_date']) && $_REQUEST['from_date']!="") $fromDate=dateFormat(mysqli_real_escape_string($mr_con,$_REQUEST['from_date']),'y');else $fromDate='0';
			if(isset($_REQUEST['to_date']) && $_REQUEST['to_date']!="")$toDate=dateFormat(mysqli_real_escape_string($mr_con,$_REQUEST['to_date']),'y');else $toDate='0';
			if(isset($_REQUEST['level']) && ($_REQUEST['level'])!=''){$status="status ='".mysqli_real_escape_string($mr_con,$_REQUEST['level'])."' AND ";}else{$status="";}
			if(isset($_REQUEST['customer_alias']) && count(array_filter($_REQUEST['customer_alias']))){
				$customer="'".implode("','",$_REQUEST['customer_alias'])."'";
				$cust="customer_alias IN (".$customer.") AND ";
			}else{ $cust='';}
			if($_REQUEST['data_filter']=='1'){
				if($fromDate!='0')$a.=" date_of_request>='".$fromDate."' AND ";else $a.="";
				if($toDate!='0')$b.=" date_of_request<='".$toDate."' AND ";else $b.="";
			}else if($_REQUEST['data_filter']=='2'){
				if($fromDate!='0')$a.=" sjo_date>='".$fromDate."' AND ";else $a.="";
				if($toDate!='0')$b.=" sjo_date<='".$toDate."' AND ";else $b.="";
			}else {$a=$b="";}
			
			if(isset($_REQUEST['warehouse']) && $_REQUEST['warehouse']!=""){$c.="'".mysqli_real_escape_string($mr_con,strtoupper($_REQUEST['warehouse']))."'";}else{$c.=getempwarehouse($emp_alias);}
			$condtion=$status.$cust.$a.$b."(from_wh IN(".$c.") OR to_wh IN(".$c.")) AND";
			$ppc_privilege = alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias');
 //PPC Export
			if($ppc_privilege=='8BSTDFFQEP'){
				$sql = mysqli_query($mr_con,"SELECT transit_damaged,amount_range,mrf_alias,customer_alias,ticket_alias,from_wh,date_of_request,sjo_number,readiness_date,status FROM ec_material_request WHERE $condtion flag='0'");
				$colArr=array('Model','Item Type','Measurement','Cell Type','Customer','Destination','Date Of Request','SJO Number','Road Permit','Quantity','Dispatched Quantity','Left Quantity','Material Readiness Date','Dispatch Date','Status','PPC Remark','PPC Bucket','PPC Name','PPC Action Date and Time','Transit Damaged','Material Amount Range');
				$filename = 'Material_request_'.date('d-m-Y H_i_s');
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->setActiveSheetIndex(0);
				$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
				$date_arr = array("G","M","N");
				foreach($date_arr as $da){
					$objPHPExcel->getActiveSheet()->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');
					$objPHPExcel->getActiveSheet()->getColumnDimension($da)->setAutoSize(true);
				}
				$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
				$ch = 'A';
				foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
					$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
				$ch++;
				}
				$coo=1;
				while($row=mysqli_fetch_array($sql)){
					$sql0 = mysqli_query($mr_con,"SELECT dispatch_date FROM ec_material_outward WHERE ref_no ='".$row['mrf_alias']."' AND from_wh IN(SELECT wh_alias FROM ec_warehouse WHERE wh_type='1' AND flag='0') AND flag='0'");
					if(mysqli_num_rows($sql0)){ $row0=mysqli_fetch_array($sql0);
						$dispatch_date=php_excel_date($row0['dispatch_date']);
					}else $dispatch_date="-";
					$sql1 = mysqli_query($mr_con,"SELECT item_description,quantity,left_quanty,item_type,cell_type FROM ec_request_items WHERE mrf_alias ='".$row['mrf_alias']."' AND flag=0");
					if(mysqli_num_rows($sql1)){
						while($row1=mysqli_fetch_array($sql1)){ $coo++;
							if($row1['item_type']=='1'){
								$item_type='CELL';
								$items=alias($row1['item_description'],'ec_product','product_alias','product_description');
								$measurement='COUNT';
							}else{
								$item_type='ACCESSORY';
								$items=alias($row1['item_description'],'ec_accessories','accessories_alias','accessory_description');
								$measurement=alias($row1['item_description'],'ec_accessories','accessories_alias','measurement');
							}
							$objPHPExcel->getActiveSheet()->SetCellValue('A'.$coo, $items);
							$objPHPExcel->getActiveSheet()->SetCellValue('B'.$coo, $item_type);
							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$coo, $measurement);
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$coo, get_cell_type($row1['cell_type']));
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$coo, checkemptydash((empty($row['customer_alias']) ? alias_flag_none(alias_flag_none(alias_flag_none($row['ticket_alias'],'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','customer_alias'),'ec_customer','customer_alias','customer_name') : alias($row['customer_alias'],'ec_customer','customer_alias','customer_name'))));
							$objPHPExcel->getActiveSheet()->SetCellValue('F'.$coo, alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code'));
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$coo, php_excel_date($row['date_of_request']));
							$objPHPExcel->getActiveSheet()->SetCellValue('H'.$coo, $row['sjo_number']);
							$objPHPExcel->getActiveSheet()->SetCellValue('I'.$coo, (alias($row['from_wh'],'ec_warehouse','wh_alias','road_permit')=='1' ? 'REQUIRED':'NOT REQUIRED'));
							$objPHPExcel->getActiveSheet()->SetCellValue('J'.$coo, $row1['quantity']);
							$objPHPExcel->getActiveSheet()->SetCellValue('K'.$coo, ($row['status']=='5' ? '0' : ($row1['quantity']-$row1['left_quanty'])));
							$objPHPExcel->getActiveSheet()->SetCellValue('L'.$coo, $row1['left_quanty']);
							$objPHPExcel->getActiveSheet()->SetCellValue('M'.$coo, php_excel_date($row['readiness_date']));
							$objPHPExcel->getActiveSheet()->SetCellValue('N'.$coo, $dispatch_date);
							$objPHPExcel->getActiveSheet()->SetCellValue('O'.$coo, fam_lvl_nm_clr($row['status'],"name",$row['mrf_alias']));
							$sql2 = mysqli_query($mr_con,"SELECT t1.bucket,t1.remarks,t1.remarked_on,t2.name FROM ec_remarks t1 INNER JOIN ec_employee_master t2 ON t1.remarked_by=t2.employee_alias WHERE t1.item_alias ='".$row['mrf_alias']."' AND t1.module='MR' AND t2.privilege_alias='8BSTDFFQEP' AND t1.flag=0");
							$remarks=$bucket=$remarked_by=$remarked_on=array();
							if(mysqli_num_rows($sql2)){
								while($row2=mysqli_fetch_array($sql2)){
									$remarks[]=$row2['remarks'];
									$bucket[]=alias($row2['bucket'],'ec_remarks_bucket','bucket_level','bucket');
									$remarked_by[]=$row2['name'];
									$remarked_on[]=$row2['remarked_on'];
								}
							}
							if(count($remarked_on)=='1')$objPHPExcel->getActiveSheet()->getStyle('S'.$coo)->getNumberFormat()->setFormatCode('mm/dd/yyyy');
							
							$objPHPExcel->getActiveSheet()->SetCellValue('P'.$coo, checkemptydash(implode(" | ",$remarks)));
							$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$coo, checkemptydash(implode(" | ",$bucket)));
							$objPHPExcel->getActiveSheet()->SetCellValue('R'.$coo, checkemptydash(implode(" | ",$remarked_by)));
							$objPHPExcel->getActiveSheet()->SetCellValue('S'.$coo, checkemptydash((count($remarked_on)=='1' ? php_excel_date($remarked_on[0]) : implode(" | ",$remarked_on))));
							
							$objPHPExcel->getActiveSheet()->SetCellValue('T'.$coo, transit_damaged($row['transit_damaged']));
							$objPHPExcel->getActiveSheet()->SetCellValue('U'.$coo, amount_range($row['amount_range']));
						}
					}
				}
			}else{
	//Other than PPC Export
				$sql = mysqli_query($mr_con,"SELECT * FROM ec_material_request WHERE $condtion flag='0'");
				$colArr=array('MRF Number','From Wh','To Wh','Date Of Request','Material Value','SJO Number','SJO Date','Sales Invoice Number','Sales Invoice Date','Sales PO Number','Customer Name','Customer Representative Name','Customer Representative Number','Customer Adderss','Ticket Number','Status','Requested Items Type','Requested Items','Measurement','Cell Type','Road Permit','Material Readiness Date','Requested Quantity','PPC Quantity','Sent Quantity','Left Quantity','Transport Details(Logistic)','Docket Number(Logistic)','Dispatch Date(Logistic)','Dispatch Remarks(Logistic)','Material Requested Remarks','Material Requested Bucket','Material Requested Name','Material Requested Action Date and Time','NHS Remarks','NHS Bucket','NHS Name','NHS Action Date and Time','PPC Remarks','PPC Bucket','PPC Name','PPC Action Date and Time','Dynamic Remarks','Dynamic Bucket','Dynamic Name','Dynamic Action Date and Time','Transit Damaged','Material Amount Range','Site Name');
				$filename = 'Material_request_'.date('d-m-Y H_i_s');
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->setActiveSheetIndex(0);
				$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
				$date_arr = array("D","G","I","V");
				foreach($date_arr as $da){
					$objPHPExcel->getActiveSheet()->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');
					$objPHPExcel->getActiveSheet()->getColumnDimension($da)->setAutoSize(true);
				}
				$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setAutoSize(true);
				$ch = 'A';
				foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
					$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
				$ch++;
				}
				$coo=1;
				while($row=mysqli_fetch_array($sql)){
					$transport=$docket=$dispatch_date=$dis_remarks=array();
					$sql0 = mysqli_query($mr_con,"SELECT transport,docket,dispatch_date,alias FROM ec_material_outward WHERE ref_no ='".$row['mrf_alias']."' AND from_wh IN(SELECT wh_alias FROM ec_warehouse WHERE wh_type='1' AND flag='0') AND flag='0'");
					if(mysqli_num_rows($sql0)){
						while($row0=mysqli_fetch_array($sql0)){
							$transport[]=$row0['transport'];
							$docket[]=$row0['docket'];
							$dispatch_date[]=date("m/d/Y",strtotime($row0['dispatch_date']));
							$sql01 = mysqli_query($mr_con,"SELECT remarks FROM ec_remarks WHERE item_alias ='".$row0['alias']."' AND module='MO' AND flag='0'");
							if(mysqli_num_rows($sql01)){ $row01=mysqli_fetch_array($sql01);
								$dis_remarks[]=$row01['remarks'];
							}
						}
					}
					$sql1 = mysqli_query($mr_con,"SELECT item_description,quantity,tappr_quanty,left_quanty,item_type,cell_type FROM ec_request_items WHERE mrf_alias ='".$row['mrf_alias']."' AND flag=0");
		//Other than PPC Export(If request items exist)
					if(mysqli_num_rows($sql1)){
						while($row1=mysqli_fetch_array($sql1)){ $coo++;
							if($row1['item_type']=='1'){
								$item_type='CELL';
								$items=alias($row1['item_description'],'ec_product','product_alias','product_description');
								$measurement='COUNT';
								$price=alias($row1['item_description'],'ec_product','product_alias','price');
							}else{
								$item_type='ACCESSORY';
								$items=alias($row1['item_description'],'ec_accessories','accessories_alias','accessory_description');
								$measurement=alias($row1['item_description'],'ec_accessories','accessories_alias','measurement');
								$price=alias($row1['item_description'],'ec_accessories','accessories_alias','price');
							}
							$objPHPExcel->getActiveSheet()->SetCellValue('A'.$coo, $row['mrf_number']);
							$objPHPExcel->getActiveSheet()->SetCellValue('B'.$coo, alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code'));
							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$coo, ($row['to_wh']=='2' ? 'FACTORY' : alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code')));
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$coo, php_excel_date($row['date_of_request']));
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$coo, ($row1['quantity'] * $price));
							$objPHPExcel->getActiveSheet()->SetCellValue('F'.$coo, $row['sjo_number']);
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$coo, php_excel_date($row['sjo_date']));
							$objPHPExcel->getActiveSheet()->SetCellValue('H'.$coo, $row['sales_invoice_no']);
							$objPHPExcel->getActiveSheet()->SetCellValue('I'.$coo, php_excel_date($row['sales_invoice_date']));
							$objPHPExcel->getActiveSheet()->SetCellValue('J'.$coo, $row['sales_po_no']);
							$objPHPExcel->getActiveSheet()->SetCellValue('K'.$coo, checkemptydash((empty($row['customer_alias']) ? alias_flag_none(alias_flag_none(alias_flag_none($row['ticket_alias'],'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','customer_alias'),'ec_customer','customer_alias','customer_name') : alias($row['customer_alias'],'ec_customer','customer_alias','customer_name'))));
							$objPHPExcel->getActiveSheet()->SetCellValue('L'.$coo, $row['contact_person']);
							$objPHPExcel->getActiveSheet()->SetCellValue('M'.$coo, $row['customer_phone']);
							$objPHPExcel->getActiveSheet()->SetCellValue('N'.$coo, $row['customer_address']);
							$objPHPExcel->getActiveSheet()->SetCellValue('O'.$coo, ($row['ticket_alias']=='2609' ? "BUFFER" : j_getticketID($row['ticket_alias'])));
							$objPHPExcel->getActiveSheet()->SetCellValue('P'.$coo, fam_lvl_nm_clr($row['status'],"name",$row['mrf_alias']));
							$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$coo, $item_type);
							$objPHPExcel->getActiveSheet()->SetCellValue('R'.$coo, $items);
							$objPHPExcel->getActiveSheet()->SetCellValue('S'.$coo, $measurement);
							$objPHPExcel->getActiveSheet()->SetCellValue('T'.$coo, ($row1['cell_type']=='1' ? 'NEW' : 'REVIVED'));
							$objPHPExcel->getActiveSheet()->SetCellValue('U'.$coo, (alias($row['from_wh'],'ec_warehouse','wh_alias','road_permit')=='1' ? 'REQUIRED':' NOT REQUIRED'));
							$objPHPExcel->getActiveSheet()->SetCellValue('V'.$coo, php_excel_date($row['readiness_date']));
							
							$objPHPExcel->getActiveSheet()->SetCellValue('W'.$coo, $row1['quantity']);
							$objPHPExcel->getActiveSheet()->SetCellValue('X'.$coo, $row1['tappr_quanty']);
							$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$coo, ($row['status']=='5' ? '0' : ($row1['quantity']-$row1['left_quanty'])));
							$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$coo, $row1['left_quanty']);
							
							$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$coo, checkemptydash(implode(" | ",$transport)));
							$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$coo, checkemptydash(implode(" | ",$docket)));
							$objPHPExcel->getActiveSheet()->SetCellValue('AC'.$coo, checkemptydash((count($dispatch_date)=='1' ? php_excel_date($dispatch_date[0]) : implode(" | ",$dispatch_date))));
							$objPHPExcel->getActiveSheet()->SetCellValue('AD'.$coo, checkemptydash(implode(" | ",$dis_remarks)));
							
							$sql2 = mysqli_query($mr_con,"SELECT t1.bucket,t1.remarks,t1.remarked_on,t2.name,t2.privilege_alias FROM ec_remarks t1 INNER JOIN ec_employee_master t2 ON t1.remarked_by=t2.employee_alias WHERE t1.item_alias ='".$row['mrf_alias']."' AND t1.module='MR' AND t1.flag=0");
							$co_remarks=$co_bucket=$co_remarked_by=$co_remarked_on=$nhs_remarks=$nhs_bucket=$nhs_remarked_by=$nhs_remarked_on=$ppc_remarks=$ppc_bucket=$ppc_remarked_by=$ppc_remarked_on=$dyn_remarks=$dyn_bucket=$dyn_remarked_by=$dyn_remarked_on=array();
							if(mysqli_num_rows($sql2)){
								while($row2=mysqli_fetch_array($sql2)){
									if($row2['privilege_alias']=='5KPS8Q0ZNB'){
										$co_remarks[]=$row2['remarks'];
										$co_bucket[]=alias($row2['bucket'],'ec_remarks_bucket','bucket_level','bucket');
										$co_remarked_by[]=$row2['name'];
										$co_remarked_on[]=$row2['remarked_on'];
									}elseif($row2['privilege_alias']=='WIMYJFDJPT'){
										$nhs_remarks[]=$row2['remarks'];
										$nhs_bucket[]=alias($row2['bucket'],'ec_remarks_bucket','bucket_level','bucket');
										$nhs_remarked_by[]=$row2['name'];
										$nhs_remarked_on[]=$row2['remarked_on'];
									}elseif($row2['privilege_alias']=='8BSTDFFQEP'){
										$ppc_remarks[]=$row2['remarks'];
										$ppc_bucket[]=alias($row2['bucket'],'ec_remarks_bucket','bucket_level','bucket');
										$ppc_remarked_by[]=$row2['name'];
										$ppc_remarked_on[]=$row2['remarked_on'];
									}elseif($row2['bucket']=='20' || $row2['bucket']=='21' || $row2['bucket']=='22'){
										$dyn_remarks[]=$row2['remarks'];
										$dyn_bucket[]=alias($row2['bucket'],'ec_remarks_bucket','bucket_level','bucket');
										$dyn_remarked_by[]=$row2['name'];
										$dyn_remarked_on[]=$row2['remarked_on'];
									}
								}
							}
							if(count($dispatch_date)=='1')$objPHPExcel->getActiveSheet()->getStyle('AC'.$coo)->getNumberFormat()->setFormatCode('mm/dd/yyyy');
							if(count($co_remarked_on)=='1')$objPHPExcel->getActiveSheet()->getStyle('AH'.$coo)->getNumberFormat()->setFormatCode('mm/dd/yyyy');
							if(count($nhs_remarked_on)=='1')$objPHPExcel->getActiveSheet()->getStyle('AL'.$coo)->getNumberFormat()->setFormatCode('mm/dd/yyyy');
							if(count($ppc_remarked_on)=='1')$objPHPExcel->getActiveSheet()->getStyle('AP'.$coo)->getNumberFormat()->setFormatCode('mm/dd/yyyy');
							if(count($dyn_remarked_on)=='1')$objPHPExcel->getActiveSheet()->getStyle('AT'.$coo)->getNumberFormat()->setFormatCode('mm/dd/yyyy');
							
							$objPHPExcel->getActiveSheet()->SetCellValue('AE'.$coo, checkemptydash(implode(" | ",$co_remarks)));
							$objPHPExcel->getActiveSheet()->SetCellValue('AF'.$coo, checkemptydash(implode(" | ",$co_bucket)));
							$objPHPExcel->getActiveSheet()->SetCellValue('AG'.$coo, checkemptydash(implode(" | ",$co_remarked_by)));
							$objPHPExcel->getActiveSheet()->SetCellValue('AH'.$coo, checkemptydash((count($co_remarked_on)=='1' ? php_excel_date($co_remarked_on[0]) : implode(" | ",$co_remarked_on))));
							
							$objPHPExcel->getActiveSheet()->SetCellValue('AI'.$coo, checkemptydash(implode(" | ",$nhs_remarks)));
							$objPHPExcel->getActiveSheet()->SetCellValue('AJ'.$coo, checkemptydash(implode(" | ",$nhs_bucket)));
							$objPHPExcel->getActiveSheet()->SetCellValue('AK'.$coo, checkemptydash(implode(" | ",$nhs_remarked_by)));
							$objPHPExcel->getActiveSheet()->SetCellValue('AL'.$coo, checkemptydash((count($nhs_remarked_on)=='1' ? php_excel_date($nhs_remarked_on[0]) : implode(" | ",$nhs_remarked_on))));
							
							$objPHPExcel->getActiveSheet()->SetCellValue('AM'.$coo, checkemptydash(implode(" | ",$ppc_remarks)));
							$objPHPExcel->getActiveSheet()->SetCellValue('AN'.$coo, checkemptydash(implode(" | ",$ppc_bucket)));
							$objPHPExcel->getActiveSheet()->SetCellValue('AO'.$coo, checkemptydash(implode(" | ",$ppc_remarked_by)));
							$objPHPExcel->getActiveSheet()->SetCellValue('AP'.$coo, checkemptydash((count($ppc_remarked_on)=='1' ? php_excel_date($ppc_remarked_on[0]) : implode(" | ",$ppc_remarked_on))));
						
							$objPHPExcel->getActiveSheet()->SetCellValue('AQ'.$coo, checkemptydash(implode(" | ",$dyn_remarks)));
							$objPHPExcel->getActiveSheet()->SetCellValue('AR'.$coo, checkemptydash(implode(" | ",$dyn_bucket)));
							$objPHPExcel->getActiveSheet()->SetCellValue('AS'.$coo, checkemptydash(implode(" | ",$dyn_remarked_by)));
							$objPHPExcel->getActiveSheet()->SetCellValue('AT'.$coo, checkemptydash((count($dyn_remarked_on)=='1' ? php_excel_date($dyn_remarked_on[0]) : implode(" | ",$dyn_remarked_on))));
							
							$objPHPExcel->getActiveSheet()->SetCellValue('AU'.$coo, transit_damaged($row['transit_damaged']));
							$objPHPExcel->getActiveSheet()->SetCellValue('AV'.$coo, amount_range($row['amount_range']));
							$objPHPExcel->getActiveSheet()->SetCellValue('AW'.$coo, checkemptydash(($row['ticket_alias']=='2609' ? "-" : alias_flag_none(alias_flag_none($row['ticket_alias'],'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','site_name'))));
						}
					}else{ $coo++;
		//Other than PPC Export(If request items not exist)
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$coo, $row['mrf_number']);
						$objPHPExcel->getActiveSheet()->SetCellValue('B'.$coo, alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code'));
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$coo, ($row['to_wh']=='2' ? 'Factory' : alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code')));
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$coo, php_excel_date($row['date_of_request']));
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$coo, $row['material_value']);
						$objPHPExcel->getActiveSheet()->SetCellValue('F'.$coo, $row['sjo_number']);
						$objPHPExcel->getActiveSheet()->SetCellValue('G'.$coo, php_excel_date($row['sjo_date']));
						$objPHPExcel->getActiveSheet()->SetCellValue('H'.$coo, $row['sales_invoice_no']);
						$objPHPExcel->getActiveSheet()->SetCellValue('I'.$coo, php_excel_date($row['sales_invoice_date']));
						$objPHPExcel->getActiveSheet()->SetCellValue('J'.$coo, $row['sales_po_no']);
						$objPHPExcel->getActiveSheet()->SetCellValue('K'.$coo, checkemptydash((empty($row['customer_alias']) ? alias_flag_none(alias_flag_none(alias_flag_none($row['ticket_alias'],'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','customer_alias'),'ec_customer','customer_alias','customer_name') : alias($row['customer_alias'],'ec_customer','customer_alias','customer_name'))));
						$objPHPExcel->getActiveSheet()->SetCellValue('L'.$coo, $row['contact_person']);
						$objPHPExcel->getActiveSheet()->SetCellValue('M'.$coo, $row['customer_phone']);
						$objPHPExcel->getActiveSheet()->SetCellValue('N'.$coo, $row['customer_address']);
						$objPHPExcel->getActiveSheet()->SetCellValue('O'.$coo, ($row['ticket_alias']=='2609' ? "BUFFER" : j_getticketID($row['ticket_alias'])));
						$objPHPExcel->getActiveSheet()->SetCellValue('P'.$coo, fam_lvl_nm_clr($row['status'],"name",$row['mrf_alias']));
						
						$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$coo, "-");
						$objPHPExcel->getActiveSheet()->SetCellValue('R'.$coo, "-");
						
						$objPHPExcel->getActiveSheet()->SetCellValue('S'.$coo, "-");
						$objPHPExcel->getActiveSheet()->SetCellValue('T'.$coo, "-");
						$objPHPExcel->getActiveSheet()->SetCellValue('U'.$coo, (alias($row['from_wh'],'ec_warehouse','wh_alias','road_permit')=='1' ? 'REQUIRED':' NOT REQUIRED'));
						$objPHPExcel->getActiveSheet()->SetCellValue('V'.$coo, php_excel_date($row['readiness_date']));
							
						$objPHPExcel->getActiveSheet()->SetCellValue('W'.$coo, "-");
						$objPHPExcel->getActiveSheet()->SetCellValue('X'.$coo, "-");
						$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$coo, "-");
						$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$coo, "-");

						$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$coo, checkemptydash(implode(" | ",$transport)));
						$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$coo, checkemptydash(implode(" | ",$docket)));
						$objPHPExcel->getActiveSheet()->SetCellValue('AC'.$coo, checkemptydash((count($dispatch_date)=='1' ? php_excel_date($dispatch_date[0]) : implode(" | ",$dispatch_date))));
						$objPHPExcel->getActiveSheet()->SetCellValue('AD'.$coo, checkemptydash(implode(" | ",$dis_remarks)));
					
						$sql2 = mysqli_query($mr_con,"SELECT t1.bucket,t1.remarks,t1.remarked_on,t2.name,t2.privilege_alias FROM ec_remarks t1 INNER JOIN ec_employee_master t2 ON t1.remarked_by=t2.employee_alias WHERE t1.item_alias ='".$row['mrf_alias']."' AND t1.module='MR' AND t1.flag=0");
						$co_remarks=$co_bucket=$co_remarked_by=$co_remarked_on=$nhs_remarks=$nhs_bucket=$nhs_remarked_by=$nhs_remarked_on=$ppc_remarks=$ppc_bucket=$ppc_remarked_by=$ppc_remarked_on=$dyn_remarks=$dyn_bucket=$dyn_remarked_by=$dyn_remarked_on=array();
						if(mysqli_num_rows($sql2)){
							while($row2=mysqli_fetch_array($sql2)){
								if($row2['privilege_alias']=='5KPS8Q0ZNB'){
									$co_remarks[]=$row2['remarks'];
									$co_bucket[]=alias($row2['bucket'],'ec_remarks_bucket','bucket_level','bucket');
									$co_remarked_by[]=$row2['name'];
									$co_remarked_on[]=$row2['remarked_on'];
								}elseif($row2['privilege_alias']=='WIMYJFDJPT'){
									$nhs_remarks[]=$row2['remarks'];
									$nhs_bucket[]=alias($row2['bucket'],'ec_remarks_bucket','bucket_level','bucket');
									$nhs_remarked_by[]=$row2['name'];
									$nhs_remarked_on[]=$row2['remarked_on'];
								}elseif($row2['privilege_alias']=='8BSTDFFQEP'){
									$ppc_remarks[]=$row2['remarks'];
									$ppc_bucket[]=alias($row2['bucket'],'ec_remarks_bucket','bucket_level','bucket');
									$ppc_remarked_by[]=$row2['name'];
									$ppc_remarked_on[]=$row2['remarked_on'];
								}elseif($row2['bucket']=='20' || $row2['bucket']=='21' || $row2['bucket']=='22'){
									$dyn_remarks[]=$row2['remarks'];
									$dyn_bucket[]=alias($row2['bucket'],'ec_remarks_bucket','bucket_level','bucket');
									$dyn_remarked_by[]=$row2['name'];
									$dyn_remarked_on[]=$row2['remarked_on'];
								}
							}
						}
						if(count($dispatch_date)=='1')$objPHPExcel->getActiveSheet()->getStyle('AC'.$coo)->getNumberFormat()->setFormatCode('mm/dd/yyyy');
						if(count($co_remarked_on)=='1')$objPHPExcel->getActiveSheet()->getStyle('AH'.$coo)->getNumberFormat()->setFormatCode('mm/dd/yyyy');
						if(count($nhs_remarked_on)=='1')$objPHPExcel->getActiveSheet()->getStyle('AL'.$coo)->getNumberFormat()->setFormatCode('mm/dd/yyyy');
						if(count($ppc_remarked_on)=='1')$objPHPExcel->getActiveSheet()->getStyle('AP'.$coo)->getNumberFormat()->setFormatCode('mm/dd/yyyy');
						if(count($dyn_remarked_on)=='1')$objPHPExcel->getActiveSheet()->getStyle('AT'.$coo)->getNumberFormat()->setFormatCode('mm/dd/yyyy');
							
						$objPHPExcel->getActiveSheet()->SetCellValue('AE'.$coo, checkemptydash(implode(" | ",$co_remarks)));
						$objPHPExcel->getActiveSheet()->SetCellValue('AF'.$coo, checkemptydash(implode(" | ",$co_bucket)));
						$objPHPExcel->getActiveSheet()->SetCellValue('AG'.$coo, checkemptydash(implode(" | ",$co_remarked_by)));
						$objPHPExcel->getActiveSheet()->SetCellValue('AH'.$coo, checkemptydash((count($co_remarked_on)=='1' ? php_excel_date($co_remarked_on[0]) : implode(" | ",$co_remarked_on))));
						
						$objPHPExcel->getActiveSheet()->SetCellValue('AI'.$coo, checkemptydash(implode(" | ",$nhs_remarks)));
						$objPHPExcel->getActiveSheet()->SetCellValue('AJ'.$coo, checkemptydash(implode(" | ",$nhs_bucket)));
						$objPHPExcel->getActiveSheet()->SetCellValue('AK'.$coo, checkemptydash(implode(" | ",$nhs_remarked_by)));
						$objPHPExcel->getActiveSheet()->SetCellValue('AL'.$coo, checkemptydash((count($nhs_remarked_on)=='1' ? php_excel_date($nhs_remarked_on[0]) : implode(" | ",$nhs_remarked_on))));
						
						$objPHPExcel->getActiveSheet()->SetCellValue('AM'.$coo, checkemptydash(implode(" | ",$ppc_remarks)));
						$objPHPExcel->getActiveSheet()->SetCellValue('AN'.$coo, checkemptydash(implode(" | ",$ppc_bucket)));
						$objPHPExcel->getActiveSheet()->SetCellValue('AO'.$coo, checkemptydash(implode(" | ",$ppc_remarked_by)));
						$objPHPExcel->getActiveSheet()->SetCellValue('AP'.$coo, checkemptydash((count($ppc_remarked_on)=='1' ? php_excel_date($ppc_remarked_on[0]) : implode(" | ",$ppc_remarked_on))));
						
						$objPHPExcel->getActiveSheet()->SetCellValue('AQ'.$coo, checkemptydash(implode(" | ",$dyn_remarks)));
						$objPHPExcel->getActiveSheet()->SetCellValue('AR'.$coo, checkemptydash(implode(" | ",$dyn_bucket)));
						$objPHPExcel->getActiveSheet()->SetCellValue('AS'.$coo, checkemptydash(implode(" | ",$dyn_remarked_by)));
						$objPHPExcel->getActiveSheet()->SetCellValue('AT'.$coo, checkemptydash((count($dyn_remarked_on)=='1' ? php_excel_date($dyn_remarked_on[0]) : implode(" | ",$dyn_remarked_on))));
						
						$objPHPExcel->getActiveSheet()->SetCellValue('AU'.$coo, transit_damaged($row['transit_damaged']));
						$objPHPExcel->getActiveSheet()->SetCellValue('AV'.$coo, amount_range($row['amount_range']));
						$objPHPExcel->getActiveSheet()->SetCellValue('AW'.$coo, checkemptydash(($row['ticket_alias']=='2609' ? "-" : alias_flag_none(alias_flag_none($row['ticket_alias'],'ec_tickets','ticket_alias','site_alias'),'ec_sitemaster','site_alias','site_name'))));
					}
				}
			}
			$objPHPExcel->getActiveSheet()->setTitle('Material Request');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save("../../exports/$filename.xlsx");
			$result['file_name']=$filename;
			$resCode='0'; $resMsg='export';
		//}else{ $resCode='4';$resMsg="Select Data Filter"; }
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function material_inward_export(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){$condtion=$condtion2="";
		if(isset($_REQUEST['from_date']) && $_REQUEST['from_date']!=""){ $condtion.=$zz="date_of_trans >='".mysqli_real_escape_string($mr_con,strtoupper(dateFormat($_REQUEST['from_date'],'y')))."' AND "; $condtion2.="t1.".$zz;}
		if(isset($_REQUEST['to_date']) && $_REQUEST['to_date']!=""){ $condtion.=$yy="date_of_trans <='".mysqli_real_escape_string($mr_con,strtoupper(dateFormat($_REQUEST['to_date'],'y')))."' AND "; $condtion2.="t1.".$yy;}
		if(isset($_REQUEST['fromwarehouse']) && count($_REQUEST['fromwarehouse'])>0){
			$fromwh="'".implode("','",$_REQUEST['fromwarehouse'])."'";
			$a=mysqli_query($mr_con,"SELECT COUNT(t1.id) AS num,GROUP_CONCAT('''',t2.site_alias,'''') AS alias,GROUP_CONCAT('''',t1.wh_alias,'''') AS whalias FROM ec_warehouse t1 INNER JOIN ec_sitemaster t2 ON t1.state_alias=t2.state_alias WHERE t1.wh_alias IN($fromwh) AND t1.flag='0'");
			$aa=mysqli_fetch_array($a);
			if($aa['num']){ $wh=$aa['alias'].",".$fromwh;}else $wh=$fromwh;
			$condtion.=$xx="from_wh IN ($wh) AND "; $condtion2.="t1.".$xx;
		}//else{ $whhh=getempwarehouse($emp_alias); if(!empty($whhh)){$condtion.=$xx="from_wh IN ($whhh) AND "; $condtion2.="t1.".$xx;} }
		if(isset($_REQUEST['towarehouse']) && count($_REQUEST['towarehouse'])>0){
			$condtion.=$ww="to_wh IN ('".implode("','",$_REQUEST['towarehouse'])."') AND "; $condtion2.="t1.".$ww;
		}else{ $whhh=getempwarehouse($emp_alias);
			if(!empty($whhh)){$condtion.=$ww="to_wh IN ($whhh) AND "; $condtion2.="t1.".$ww;}
		}
		if(isset($_REQUEST['trans_id']) && !empty($_REQUEST['trans_id']) && $_REQUEST['trans_id']!="#"){ $condtion.=$vv="trans_id='".mysqli_real_escape_string($mr_con,$_REQUEST['trans_id'])."' AND "; $condtion2.="t1.".$vv;}
		if(isset($_REQUEST['data_type']) && count($_REQUEST['data_type'])>'0'){
			$filename = 'Material_inward_'.date('d-m-Y H_i_s');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("EnersysCare")->setLastModifiedBy("EnersysCare")->setTitle("Office 2007 XLSX Tickets Document")->setSubject("Office 2007 XLSX Tickets Document")->setDescription("Tickets document for Office 2007 XLSX, generated using PHP classes.");
			$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
			$no_rec = $sh_index = 0;
			if(in_array('1',$_REQUEST['data_type'])){
				$objPHPExcel->setActiveSheetIndex($sh_index);
				$sheet = $objPHPExcel->getActiveSheet();
				$sheet->setTitle('Without Cell Serial No');
				$sql = mysqli_query($mr_con,"SELECT * FROM ec_material_inward WHERE $condtion flag=0");
				if(mysqli_num_rows($sql)){
					//$colArr=array('Transaction ID','From Wh','To Wh','MRF Number','SJO Number','Ticket ID','Item Descriptions','Cell Serial No');
					$colArr=array('Transaction ID','From Wh','To Wh','Date Of Transaction','Inward Number','Total Amount','Item Descriptions','Quantity','Measurement','MRF Number','SJO Number','Ticket ID','Transport','Docket','Inward Date','Remark','Remarked By','Remarked On');
					$last_key = end(array_keys($colArr));
					$last_alpha = num2alpha($last_key);
					$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
					$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue)); $ch++; }
					$date_arr = array("D","O","R");
					foreach($date_arr as $da){$sheet->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension($da)->setAutoSize(true);}
					$coo=1;
					while($row=mysqli_fetch_array($sql)){
						$remarks=$remarked_by=$remarked_on=array();
						$sql2 = mysqli_query($mr_con,"SELECT remarks,remarked_by,remarked_on FROM ec_remarks WHERE item_alias ='".$row['alias']."' AND module='MI' AND flag=0");
						if(mysqli_num_rows($sql2)){
							while($row2=mysqli_fetch_array($sql2)){
								$remarks[]=$row2['remarks'];
								$remarked_by[]=(strtoupper($row2['remarked_by'])=="ADMIN" ? "ADMIN" : alias($row2['remarked_by'],'ec_employee_master','employee_alias','name'));
								$remarked_on[]=$row2['remarked_on'];
							}
						}
						$sql_in = mysqli_query($mr_con,"SELECT DISTINCT item_code FROM ec_material_received_details WHERE reference='".$row['alias']."' AND flag=0");
						if(mysqli_num_rows($sql_in)>'0'){$aser=array();
							while($row_in = mysqli_fetch_array($sql_in))$aser[]=$row_in['item_code'];
							for($zx=0;$zx<count($aser);$zx++){
								$sql_ina = mysqli_query($mr_con,"SELECT COUNT(id) as qwerty, item_type,item_code FROM ec_material_received_details WHERE item_code='".$aser[$zx]."' AND reference='".$row['alias']."' AND flag=0");
								while($row_ina = mysqli_fetch_array($sql_ina)){ $coo++;
									list($mrf_number,$sjo_number,$ticket_id)=explode("@",in_m_s_t($row['from_type'],$row['from_wh'],$row['ref_no']));
									$sheet->SetCellValue('A'.$coo, checkemptydash($row['trans_id']))		
										->SetCellValue('B'.$coo, checkemptydash(($row['from_wh']=='2609' ? "BUFFER":($row['from_type']=='1' || $row['from_type']=='2' ? alias($row['from_wh'],'ec_sitemaster','site_alias','site_name') : alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code')))))
										->SetCellValue('C'.$coo, checkemptydash(alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code')))
										->SetCellValue('D'.$coo, php_excel_date($row['date_of_trans']))
										->SetCellValue('E'.$coo, checkemptydash($row['inv_num']))
										->SetCellValue('F'.$coo, checkemptydash(round(($row_ina['item_type'] =='1' ? alias($row_ina['item_code'],'ec_product','product_alias','price') : alias($row_ina['item_code'],'ec_accessories','accessories_alias','price'))*$row_ina['qwerty'],2)))
										->SetCellValue('G'.$coo, checkemptydash(($row_ina['item_type'] =='1' ? alias($row_ina['item_code'],'ec_product','product_alias','product_description'):alias($row_ina['item_code'],'ec_accessories','accessories_alias','accessory_description'))))
										->SetCellValue('H'.$coo, checkemptydash($row_ina['qwerty']))
										->SetCellValue('I'.$coo, checkemptydash($row_ina['item_type'] =='1' ? 'COUNT' : alias($row_ina['item_code'],'ec_accessories','accessories_alias','measurement')))
										->SetCellValue('J'.$coo, checkemptydash($mrf_number))
										->SetCellValue('K'.$coo, checkemptydash($sjo_number))
										->SetCellValue('L'.$coo, checkemptydash($ticket_id))
										->SetCellValue('M'.$coo, checkemptydash($row['transport']))
										->SetCellValue('N'.$coo, checkemptydash($row['docket']))
										->SetCellValue('O'.$coo, php_excel_date($row['dispatch_date']))
										->SetCellValue('P'.$coo, checkemptydash(implode(" | ",$remarks)))
										->SetCellValue('Q'.$coo, checkemptydash(implode(" | ",$remarked_by)))
										->SetCellValue('R'.$coo,checkemptydash((count($remarked_on)==1 ? php_excel_date(end($remarked_on)) : implode(" | ",$remarked_on))));
								}
							}
						}
					}$no_rec++;
				}$sh_index++;
			}
			if(in_array('2',$_REQUEST['data_type'])){
				if($sh_index>0)$objPHPExcel->createSheet();
				$objPHPExcel->setActiveSheetIndex($sh_index);
				$sheet = $objPHPExcel->getActiveSheet();
				$sheet->setTitle('With Cell Serial No');
				$sql = mysqli_query($mr_con,"SELECT t1.from_wh,t1.to_wh,t1.date_of_trans,t1.trans_id,t1.from_type,t1.ref_no,t2.item_type,t2.item_code,t2.item_description FROM ec_material_inward t1 INNER JOIN ec_material_received_details t2 ON t1.alias=t2.reference WHERE $condtion2 t1.flag=0");
				if(mysqli_num_rows($sql)){
					$colArr=array('Transaction ID','From Wh','To Wh','Date Of Transaction','MRF Number','SJO Number','Ticket ID','Item Type','Item Descriptions','Cell Serial No/Qty','Measurement');
					$last_key = end(array_keys($colArr));
					$last_alpha = num2alpha($last_key);
					$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
					$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue)); $ch++; }
					$date_arr = array("D");
					foreach($date_arr as $da){$sheet->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension($da)->setAutoSize(true);}
					$coo=1;
					while($row=mysqli_fetch_array($sql)){ $coo++;
						list($mrf_number,$sjo_number,$ticket_id)=explode("@",in_m_s_t($row['from_type'],$row['from_wh'],$row['ref_no']));
						$sheet->SetCellValue('A'.$coo, $row['trans_id'])
							->SetCellValue('B'.$coo, ($row['from_wh']=='2609' ? "BUFFER":($row['from_type']=='1' || $row['from_type']=='2' ? alias($row['from_wh'],'ec_sitemaster','site_alias','site_name') : alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code'))))
							->SetCellValue('C'.$coo, alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code'))
							->SetCellValue('D'.$coo, php_excel_date($row['date_of_trans']))
							->SetCellValue('E'.$coo, $mrf_number)
							->SetCellValue('F'.$coo, $sjo_number)
							->SetCellValue('G'.$coo, $ticket_id)
							->SetCellValue('H'.$coo, ($row['item_type'] =='1' ? 'CELL':'ACCESSORY'))
							->SetCellValue('I'.$coo, ($row['item_type'] =='1' ? alias($row['item_code'],'ec_product','product_alias','product_description'):alias($row['item_code'],'ec_accessories','accessories_alias','accessory_description')))
							->setCellValueExplicit('J'.$coo, alias($row['item_description'],'ec_item_code','item_code_alias','item_description'),PHPExcel_Cell_DataType::TYPE_STRING)
							->SetCellValue('K'.$coo, checkemptydash($row['item_type'] =='1' ? 'COUNT' : alias($row['item_code'],'ec_accessories','accessories_alias','measurement')));
					}$no_rec++;
				}$sh_index++;
			}
			if($no_rec>0){
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$objWriter->save("../../exports/$filename.xlsx");
				$result['file_name']=$filename;
				$resCode='0'; $resMsg='export';
			}else{$resCode='4';$resMsg='No Records found to Run Report!';}
		}else {$resCode='4';$resMsg='Please Select Data type';}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function material_outward_export(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){$condtion=$condtion2="";
		if(isset($_REQUEST['from_date']) && $_REQUEST['from_date']!=""){ $condtion.=$zz="date_of_trans >='".mysqli_real_escape_string($mr_con,strtoupper(dateFormat($_REQUEST['from_date'],'y')))."' AND "; $condtion2.="t1.".$zz;}
		if(isset($_REQUEST['to_date']) && $_REQUEST['to_date']!=""){ $condtion.=$yy="date_of_trans <='".mysqli_real_escape_string($mr_con,strtoupper(dateFormat($_REQUEST['to_date'],'y')))."' AND "; $condtion2.="t1.".$yy;}
		if(isset($_REQUEST['fromwarehouse']) && count($_REQUEST['fromwarehouse'])>0){
			$condtion.=$ww="from_wh IN ('".implode("','",$_REQUEST['fromwarehouse'])."') AND "; $condtion2.="t1.".$ww;
		}else{ $whhh=getempwarehouse($emp_alias);
			if(!empty($whhh)){$condtion.=$ww="from_wh IN ($whhh) AND "; $condtion2.="t1.".$ww;}
		}
		if(isset($_REQUEST['towarehouse']) && count($_REQUEST['towarehouse'])>0){
			$towh="'".implode("','",$_REQUEST['towarehouse'])."'";
			$a=mysqli_query($mr_con,"SELECT COUNT(t1.id) AS num,GROUP_CONCAT('''',t2.site_alias,'''') AS alias FROM ec_warehouse t1 INNER JOIN ec_sitemaster t2 ON t1.state_alias=t2.state_alias WHERE t1.wh_alias IN($towh) AND t1.flag='0'");
			$aa=mysqli_fetch_array($a);
			if($aa['num']){ $wh=$aa['alias'].",".$towh;}else $wh=$towh;
			$condtion.=$ww="to_wh IN ($wh) AND "; $condtion2.="t1.".$ww;
		}
		if(isset($_REQUEST['trans_id']) && !empty($_REQUEST['trans_id']) && $_REQUEST['trans_id']!="#"){ $condtion.=$vv="trans_id='".mysqli_real_escape_string($mr_con,$_REQUEST['trans_id'])."' AND "; $condtion2.="t1.".$vv;}
		if(isset($_REQUEST['level']) && $_REQUEST['level']!="" && count($_REQUEST['level'])>'0'){ $condtion.=$uu="status IN('".implode("','",$_REQUEST['level'])."') AND "; $condtion2.="t1.".$uu;}
		if(isset($_REQUEST['data_type']) && count($_REQUEST['data_type'])>'0'){
			$filename = 'Material_outward_'.date('d-m-Y H_i_s');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("EnersysCare")->setLastModifiedBy("EnersysCare")->setTitle("Office 2007 XLSX Tickets Document")->setSubject("Office 2007 XLSX Tickets Document")->setDescription("Tickets document for Office 2007 XLSX, generated using PHP classes.");
			$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
			$no_rec = $sh_index = 0;
			if(in_array('1',$_REQUEST['data_type'])){
				$objPHPExcel->setActiveSheetIndex($sh_index);
				$sheet = $objPHPExcel->getActiveSheet();
				$sheet->setTitle('Without Cell Serial No');
				$sql = mysqli_query($mr_con,"SELECT * FROM ec_material_outward WHERE $condtion flag=0");
				if(mysqli_num_rows($sql)){
					$colArr=array('Transaction ID','From Wh','To Wh','Date Of Transaction','Total Amount','Status','Item Descriptions','Quantity','Measurement','MRF Number','SJO Number','Ticket ID','Transport','Docket','Dispatch Date','Responsible Engineer','Remark','Remarked By','Remarked On');
					$last_key = end(array_keys($colArr));
					$last_alpha = num2alpha($last_key);
					$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
					$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue)); $ch++; }
					$date_arr = array("D","O","S");
					foreach($date_arr as $da){$sheet->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension($da)->setAutoSize(true);}
					$coo=1;
					while($row=mysqli_fetch_array($sql)){
						$remarks=$remarked_by=$remarked_on=array();
						$sql2 = mysqli_query($mr_con,"SELECT remarks,remarked_by,remarked_on FROM ec_remarks WHERE item_alias ='".$row['alias']."' AND module='MO' AND flag=0");
						if(mysqli_num_rows($sql2)){
							while($row2=mysqli_fetch_array($sql2)){
								$remarks[]=$row2['remarks'];
								$remarked_by[]=(strtoupper($row2['remarked_by'])=="ADMIN" ? "ADMIN" : alias($row2['remarked_by'],'ec_employee_master','employee_alias','name'));
								$remarked_on[]=$row2['remarked_on'];
							}
						}
						$sql_in = mysqli_query($mr_con,"SELECT DISTINCT item_code FROM ec_material_sent_details WHERE reference='".$row['alias']."' AND flag=0");
						if(mysqli_num_rows($sql_in)>'0'){$aser=array();
							while($row_in = mysqli_fetch_array($sql_in))$aser[]=$row_in['item_code'];
							for($zx=0;$zx<count($aser);$zx++){
								$sql_ina = mysqli_query($mr_con,"SELECT COUNT(id) as qwerty, item_type,item_code FROM ec_material_sent_details WHERE item_code='".$aser[$zx]."' AND reference='".$row['alias']."' AND flag=0");
								while($row_ina = mysqli_fetch_array($sql_ina)){ $coo++;
									list($mrf_number,$sjo_number,$ticket_id)=explode("@",out_m_s_t($row['from_type'],$row['to_wh'],$row['ref_no'],$row['sjo_number']));
									$sheet->SetCellValue('A'.$coo, checkemptydash($row['trans_id']))
										->SetCellValue('B'.$coo, checkemptydash(alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code')))
										->SetCellValue('C'.$coo, checkemptydash(($row['to_wh']=='2609' ? "BUFFER":($row['from_type']=='1' ? alias($row['to_wh'],'ec_sitemaster','site_alias','site_name') : alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code')))))
										->SetCellValue('D'.$coo, php_excel_date($row['date_of_trans']))
										->SetCellValue('E'.$coo, checkemptydash(round(($row_ina['item_type'] =='1' ? alias($row_ina['item_code'],'ec_product','product_alias','price') : alias($row_ina['item_code'],'ec_accessories','accessories_alias','price'))*$row_ina['qwerty'],2)))
										->SetCellValue('F'.$coo, checkemptydash(outward_nm_clr($row['status'],"name")))
										->SetCellValue('G'.$coo, checkemptydash(($row_ina['item_type'] =='1' ? alias($row_ina['item_code'],'ec_product','product_alias','product_description'):alias($row_ina['item_code'],'ec_accessories','accessories_alias','accessory_description'))))
										->SetCellValue('H'.$coo, checkemptydash($row_ina['qwerty']))
										->SetCellValue('I'.$coo, checkemptydash($row_ina['item_type'] =='1' ? 'COUNT' : alias($row_ina['item_code'],'ec_accessories','accessories_alias','measurement')))
										->SetCellValue('J'.$coo, checkemptydash($mrf_number))
										->SetCellValue('K'.$coo, checkemptydash($sjo_number))
										->SetCellValue('L'.$coo, checkemptydash($ticket_id))
										->SetCellValue('M'.$coo, checkemptydash($row['transport']))
										->SetCellValue('N'.$coo, checkemptydash($row['docket']))
										->SetCellValue('O'.$coo, php_excel_date($row['dispatch_date']))
										->SetCellValue('P'.$coo, checkemptydash(alias($row['resp_engineer'],'ec_employee_master','employee_alias','name')))
										->SetCellValue('Q'.$coo, checkemptydash(implode(" | ",$remarks)))
										->SetCellValue('R'.$coo, checkemptydash(implode(" | ",$remarked_by)))
										->SetCellValue('S'.$coo,checkemptydash((count($remarked_on)==1 ? php_excel_date(end($remarked_on)) : implode(" | ",$remarked_on))));
								}
							}
						}
					}$no_rec++;
				}$sh_index++;
			}
			if(in_array('2',$_REQUEST['data_type'])){
				if($sh_index>0)$objPHPExcel->createSheet();
				$objPHPExcel->setActiveSheetIndex($sh_index);
				$sheet = $objPHPExcel->getActiveSheet();
				$sheet->setTitle('With Cell Serial No');
				$sql = mysqli_query($mr_con,"SELECT t1.from_wh,t1.to_wh,t1.date_of_trans,t1.trans_id,t1.from_type,t1.ref_no,t1.sjo_number,t2.item_type,t2.item_code,t2.item_description FROM ec_material_outward t1 INNER JOIN ec_material_sent_details t2 ON t1.alias=t2.reference WHERE $condtion2 t1.flag=0");
				if(mysqli_num_rows($sql)){
					$colArr=array('Transaction ID','From Wh','To Wh','Date Of Transaction','MRF Number','SJO Number','Ticket ID','Item Type','Item Descriptions','Cell Serial No/Qty','Measurement');
					$last_key = end(array_keys($colArr));
					$last_alpha = num2alpha($last_key);
					$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
					$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue)); $ch++; }
					$date_arr = array("D");
					foreach($date_arr as $da){$sheet->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension($da)->setAutoSize(true);}
					$coo=1;
					while($row=mysqli_fetch_array($sql)){ $coo++;
						list($mrf_number,$sjo_number,$ticket_id)=explode("@",out_m_s_t($row['from_type'],$row['to_wh'],$row['ref_no'],$row['sjo_number']));
						$sheet->SetCellValue('A'.$coo, $row['trans_id'])
							->SetCellValue('B'.$coo, checkemptydash(alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code')))
							->SetCellValue('C'.$coo, checkemptydash(($row['to_wh']=='2609' ? "BUFFER":($row['from_type']=='1' ? alias($row['to_wh'],'ec_sitemaster','site_alias','site_name') : alias($row['to_wh'],'ec_warehouse','wh_alias','wh_code')))))
							->SetCellValue('D'.$coo, php_excel_date($row['date_of_trans']))
							->SetCellValue('E'.$coo, $mrf_number)
							->SetCellValue('F'.$coo, $sjo_number)
							->SetCellValue('G'.$coo, $ticket_id)
							->SetCellValue('H'.$coo, ($row['item_type'] =='1' ? 'CELL':'ACCESSORY'))
							->SetCellValue('I'.$coo, ($row['item_type'] =='1' ? alias($row['item_code'],'ec_product','product_alias','product_description'):alias($row['item_code'],'ec_accessories','accessories_alias','accessory_description')))
							->setCellValueExplicit('J'.$coo, alias($row['item_description'],'ec_item_code','item_code_alias','item_description'),PHPExcel_Cell_DataType::TYPE_STRING)
							->SetCellValue('K'.$coo, checkemptydash($row['item_type'] =='1' ? 'COUNT' : alias($row['item_code'],'ec_accessories','accessories_alias','measurement')));
					}$no_rec++;
				}$sh_index++;
			}
			if($no_rec>0){
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$objWriter->save("../../exports/$filename.xlsx");
				$result['file_name']=$filename;
				$resCode='0'; $resMsg='export';
			}else{$resCode='4';$resMsg='No Records found to Run Report!';}
		}else {$resCode='4';$resMsg='Please Select Data type';}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function material_revival_export(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){ $condtion="";
		if(isset($_REQUEST['from_date']) && $_REQUEST['from_date']!="") $condtion.="createdDate >='".mysqli_real_escape_string($mr_con,strtoupper(dateFormat($_REQUEST['from_date'],'y')))."' AND ";
		if(isset($_REQUEST['to_date']) && $_REQUEST['to_date']!="") $condtion.="createdDate <='".mysqli_real_escape_string($mr_con,strtoupper(dateFormat($_REQUEST['to_date'],'y')))." 23:59:59' AND ";
		if(isset($_REQUEST['wh_alias']) && count($_REQUEST['wh_alias'])>0)$condtion.="wh_alias IN ('".implode("','",$_REQUEST['wh_alias'])."') AND ";
		else{if(!admin_privilege($emp_alias))$condtion.="wh_alias IN('".str_replace(", ","','",alias($emp_alias,'ec_employee_master','employee_alias','wh_alias'))."') AND ";}
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_material_revival WHERE $condtion flag=0");
		$colArr=array('Revival No.','Ware House','Transaction Date','Cell Sr. No.','Capacity','Mfd Date','OCV','Discharge Current','1hr','2hr','3hr','4hr','5hr','6hr','7hr','8hr','9hr','10hr','Result','Engineer');
		//$colArr2=array('revival_no','wh_alias','cell_sr_no','mf_date','ocv','dis_current','1hr','2hr','3hr','4hr','5hr','6hr','7hr','8hr','9hr','10hr','result','eng_name');
		$filename = 'Revival_'.date('d-m-Y H_i_s');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
		$ch = 'A';
		foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
		$ch++;
		}$cap_arr=$wh_arr=array();
		$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('mm/dd/yyyy');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$coo=1;
		while($row=mysqli_fetch_array($sql)){ $coo++;
			/*for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
				$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
			}*/
			if(!array_key_exists($row['wh_alias'],$wh_arr))$wh_arr[$row['wh_alias']]=$wh_code=alias($row['wh_alias'],'ec_warehouse','wh_alias','wh_code');else $wh_code = $wh_arr[$row['wh_alias']];
			$item_code = alias($row['cell_sr_no'],'ec_item_code','item_code_alias','item_code');
			if(!array_key_exists($item_code,$cap_arr))$cap_arr[$item_code]=alias($item_code,'ec_product','product_alias','product_description');
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$coo, $row['revival_no']);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$coo, $wh_code);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$coo, php_excel_date($row['createdDate']));
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$coo, alias($row['cell_sr_no'],'ec_item_code','item_code_alias','item_description'),PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$coo, $cap_arr[$item_code]);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$coo, $row['mf_date']);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$coo, $row['ocv']);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$coo, $row['dis_current']);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$coo, $row['1hr']);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$coo, $row['2hr']);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$coo, $row['3hr']);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$coo, $row['4hr']);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$coo, $row['5hr']);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$coo, $row['6hr']);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$coo, $row['7hr']);
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$coo, $row['8hr']);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$coo, $row['9hr']);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$coo, $row['10hr']);
			$sql1 = mysqli_query($mr_con,"SELECT description FROM ec_stock WHERE stock_type='0' AND stock_alias='".$row['result']."' AND flag=0");
			$row1=mysqli_fetch_array($sql1);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$coo, $row1['description']);
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$coo, $row['eng_name']);
		}
		$objPHPExcel->getActiveSheet()->setTitle('Revival');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save("../../exports/$filename.xlsx");
		$result['file_name']=$filename;
		$resCode='0'; $resMsg='export';
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function material_refreshing_export(){ global $mr_con;
	$chk=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($chk==0){ $condtion="";
		if(isset($_REQUEST['from_date']) && $_REQUEST['from_date']!="") $condtion.="createdDate >='".mysqli_real_escape_string($mr_con,strtoupper(dateFormat($_REQUEST['from_date'],'y')))."' AND ";
		if(isset($_REQUEST['to_date']) && $_REQUEST['to_date']!="") $condtion.="createdDate <='".mysqli_real_escape_string($mr_con,strtoupper(dateFormat($_REQUEST['to_date'],'y')))." 23:59:59' AND ";
		if(isset($_REQUEST['wh_alias']) && count($_REQUEST['wh_alias'])>0)$condtion.="wh_alias IN ('".implode("','",$_REQUEST['wh_alias'])."') AND ";
		else{if(!admin_privilege($emp_alias))$condtion.="wh_alias IN('".str_replace(", ","','",alias($emp_alias,'ec_employee_master','employee_alias','wh_alias'))."') AND ";}
		$sql = mysqli_query($mr_con,"SELECT * FROM ec_material_refreshing WHERE $condtion flag=0");
		$colArr=array('Refreshing No.','Ware House','Transaction Date','Cell Sr. No.','Capacity','Mfd Date','OCV','Discharge Current','1hr','2hr','3hr','4hr','5hr','6hr','7hr','8hr','9hr','10hr','Result','Engineer');
		//$colArr2=array('refreshing_no','wh_alias','cell_sr_no','mf_date','ocv','dis_current','1hr','2hr','3hr','4hr','5hr','6hr','7hr','8hr','9hr','10hr','result','eng_name');
		$filename = 'Refreshing_'.date('d-m-Y H_i_s');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
		$ch = 'A';
		foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
		$ch++;
		}$cap_arr=$wh_arr=array();
		$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('mm/dd/yyyy');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$coo=1;
		while($row=mysqli_fetch_array($sql)){ $coo++;
			/*for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){
				$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
			}*/
			if(!array_key_exists($row['wh_alias'],$wh_arr))$wh_arr[$row['wh_alias']]=$wh_code=alias($row['wh_alias'],'ec_warehouse','wh_alias','wh_code');else $wh_code = $wh_arr[$row['wh_alias']];
			$item_code = alias($row['cell_sr_no'],'ec_item_code','item_code_alias','item_code');
			if(!array_key_exists($item_code,$cap_arr))$cap_arr[$item_code]=alias($item_code,'ec_product','product_alias','product_description');
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$coo, $row['revival_no']);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$coo, $wh_code);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$coo, php_excel_date($row['createdDate']));
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$coo, alias($row['cell_sr_no'],'ec_item_code','item_code_alias','item_description'),PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$coo, $cap_arr[$item_code]);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$coo, $row['mf_date']);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$coo, $row['ocv']);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$coo, $row['dis_current']);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$coo, $row['1hr']);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$coo, $row['2hr']);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$coo, $row['3hr']);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$coo, $row['4hr']);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$coo, $row['5hr']);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$coo, $row['6hr']);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$coo, $row['7hr']);
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$coo, $row['8hr']);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$coo, $row['9hr']);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$coo, $row['10hr']);
			$sql1 = mysqli_query($mr_con,"SELECT description FROM ec_stock WHERE stock_type='0' AND stock_alias='".$row['result']."' AND flag=0");
			$row1=mysqli_fetch_array($sql1);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$coo, $row1['description']);
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$coo, $row['eng_name']);
		}
		$objPHPExcel->getActiveSheet()->setTitle('Refreshing');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save("../../exports/$filename.xlsx");
		$result['file_name']=$filename;
		$resCode='0'; $resMsg='export';
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}

	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function stocks_export(){ global $mr_con;
	set_time_limit(0);
	ini_set('memory_limit', '1024M');
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){$c5=$sam=$sam1="";
		//if(isset($_REQUEST['date_filter']) && !empty($_REQUEST['date_filter'])){
			if(isset($_REQUEST['item_type']) && count($_REQUEST['item_type'])){
				$item_type=$_REQUEST['item_type'];
				if(strtoupper($emp_alias)!='ADMIN' || strtoupper($emp_alias)!='EADMIN'){$privilege=alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias');}else{$privilege="";}
				if(isset($_REQUEST['datetype']) && $_REQUEST['datetype']!="")$datetype=mysqli_real_escape_string($mr_con,$_REQUEST['datetype']);else $datetype='0';
				if(isset($_REQUEST['from_date']) && $_REQUEST['from_date']!="")$fromDate=dateFormat(mysqli_real_escape_string($mr_con,$_REQUEST['from_date']),'y');else $fromDate='0';
				if(isset($_REQUEST['to_date']) && $_REQUEST['to_date']!="")$toDate=dateFormat(mysqli_real_escape_string($mr_con,$_REQUEST['to_date']),'y');else $toDate='0';
				
				if($_REQUEST['date_filter']=='1'){
					if($fromDate!='0')$c11=" t3.date_of_request>='".$fromDate."' AND ";else $c1="";
					if($toDate!='0')$c12=" t3.date_of_request<='".$toDate."' AND ";else $c2="";
				}else if($_REQUEST['date_filter']=='2'){
					if($fromDate!='0')$c11=" t3.sjo_date>='".$fromDate."' AND ";else $c1="";
					if($toDate!='0')$c12=" t3.sjo_date<='".$toDate."' AND ";else $c2="";
				}else if($_REQUEST['date_filter']=='3'){
					if($fromDate!='0')$c11=" t1.invoice_date>='".$fromDate."' AND ";else $c1="";
					if($toDate!='0')$c12=" t1.invoice_date<='".$toDate."' AND ";else $c2="";
				}
				
				if($privilege=="DWH4PLGSLK"){ //varaprasad
					$sam=" t1.cell_type IN('1','2') AND ";
				}else if($privilege=="BWIHQNHG8F"){ //sudhakarraju
					$sam=" t1.cell_type IN('1','2') AND t1.invoice_no<>'' AND t1.invoice_no<>'NA' AND ";
				}else if($privilege=="GM5I41RNLO"){ //ravikanth
					$sam=" t1.cell_type IN('1','2') AND t1.invoice_no<>'' AND t1.invoice_no<>'NA' AND t3.status IN('0','5','6') AND ";
				}else if($privilege=="8NHXNU4NDP"){ //Chandrashekar
					$sam1=" t2.condition_id='3' AND t2.location='".alias('1','ec_warehouse','wh_type','wh_alias')."' AND ";
				}
				
				if(isset($_REQUEST['wh']) && count(array_filter($_REQUEST['wh'])))$wh="'".implode("','",$_REQUEST['wh'])."'";else $wh='0';
				if(isset($_REQUEST['b_rating']) && count(array_filter($_REQUEST['b_rating'])))$b_rating="'".implode("','",$_REQUEST['b_rating'])."'";else $b_rating='0';
				if(isset($_REQUEST['sjo_num']) && $_REQUEST['sjo_num']!="")$sjo_num=mysqli_real_escape_string($mr_con,$_REQUEST['sjo_num']);else $sjo_num='0';
				if(isset($_REQUEST['invc_num']) && $_REQUEST['invc_num']!="")$invc_num=mysqli_real_escape_string($mr_con,$_REQUEST['invc_num']);else $invc_num='0';
				if(isset($_REQUEST['cell_cond']) && count(array_filter($_REQUEST['cell_cond'])))$cell_cond="t2.condition_id IN ('".implode("','",$_REQUEST['cell_cond'])."') AND ";else $cell_cond='';
				
				if($wh!='0')$c0="t2.location IN ($wh) AND ";else $c0="";
				if($b_rating!='0')$c1="t1.item_code IN ($b_rating) AND ";else $c1="";
				if($sjo_num!='0'){
					$mrf_alias=alias($sjo_num,'ec_material_request','sjo_number','mrf_alias');
					if(empty($mrf_alias)){$mrf_alias=$sjo_num;$c2="t3.sjo_number='$mrf_alias' AND ";}else{$c2="t1.sjo_no='$mrf_alias' AND ";}
				}else $c2="";
				
				if($invc_num!='0')$c4="t1.invoice_no='$invc_num' AND ";else $c4="";
				//if($cell_cond!='0')$c5="t2.condition_id IN ($cell_cond) AND ";else $c5="";
				$condition=$c1.$c2.$c3.$c4.$c11.$c12.$c0.$sam;
				$cnd=$cell_cond.$sam1;
				//$rrrrrr="SELECT COUNT(t1.id) AS num FROM ec_item_code t1 INNER JOIN ec_total_cell t2 ON t1.item_code_alias=t2.cell_alias LEFT JOIN ec_material_request t3 ON t1.sjo_no=t3.mrf_alias WHERE $condition $cnd t1.item_type='1' AND t1.flag='0' AND t2.flag='0'";
				if($fromDate>$toDate && $toDate!=0){$resCode='4';$resMsg="Select toDate Greater than fromDate";}
				else{
					$filename = 'Stocks_'.date('d-m-Y H_i_s');
					$objPHPExcel = new PHPExcel();
					$nc=$ch_index=0;
					if(in_array('1',$item_type)){
						if($datetype!='0'){
							$objPHPExcel->setActiveSheetIndex($ch_index);
							$objPHPExcel->getActiveSheet();
							$objPHPExcel->getActiveSheet()->setTitle('With Out Cell History');
							$sq=mysqli_query($mr_con,"SELECT COUNT(t1.id) AS num FROM ec_item_code t1 INNER JOIN ec_total_cell t2 ON t1.item_code_alias=t2.cell_alias LEFT JOIN ec_material_request t3 ON t1.sjo_no=t3.mrf_alias WHERE $condition $cnd t1.item_type='1' AND t1.flag='0' AND t2.flag='0'");
							$count=mysqli_fetch_array($sq);
							if($count['num']){
	//With Out Cell History Starts
								$sql=mysqli_query($mr_con,"SELECT t1.*,t2.location,t2.condition_id FROM ec_item_code t1 INNER JOIN ec_total_cell t2 ON t1.item_code_alias=t2.cell_alias LEFT JOIN ec_material_request t3 ON t1.sjo_no=t3.mrf_alias WHERE $condition $cnd t1.item_type='1' AND t1.flag='0' AND t2.flag='0'");
								$colArr=array('Item Code','Factory Condition','Item Price','Item Type','Item Description','Quantity','SJO No.','SJO Date','Invoice No.','Invoice Date','Created Date','Status','Current Location');
								$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
								if($datetype=='1'){ $ch = 'A';
									foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
										$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
										$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
										$ch++;
									}
									$date_arr = array("H","J","K");
									foreach($date_arr as $da){
										$objPHPExcel->getActiveSheet()->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');
										$objPHPExcel->getActiveSheet()->getColumnDimension($da)->setAutoSize(true);
									}
									$coo=1;$item_code_alias=array();
									while($row=mysqli_fetch_array($sql)){$coo++; $item_code_alias[]=$row['item_code_alias'];
										$objPHPExcel->getActiveSheet()->SetCellValue('A'.$coo, alias($row['item_code'],'ec_product','product_alias','product_description'));
										$objPHPExcel->getActiveSheet()->SetCellValue('B'.$coo, get_cell_type($row['cell_type']));
										$objPHPExcel->getActiveSheet()->SetCellValue('C'.$coo, round(alias($row['item_code'],'ec_product','product_alias','price'),2));
										$objPHPExcel->getActiveSheet()->SetCellValue('D'.$coo, 'CELLS');
										$objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$coo, $row['item_description'],PHPExcel_Cell_DataType::TYPE_STRING);
										$objPHPExcel->getActiveSheet()->SetCellValue('F'.$coo, $row['quantity']);
										$sjo_number=alias($row['sjo_no'],'ec_material_request','mrf_alias','sjo_number');
										$objPHPExcel->getActiveSheet()->SetCellValue('G'.$coo, (!empty($sjo_number) ? $sjo_number : "-"));
										if(!empty($row['sjo_no']))$objPHPExcel->getActiveSheet()->SetCellValue('H'.$coo, php_excel_date(alias($row['sjo_no'],'ec_material_request','mrf_alias','sjo_date')));
										else $objPHPExcel->getActiveSheet()->SetCellValue('H'.$coo,'-');
										$objPHPExcel->getActiveSheet()->SetCellValue('I'.$coo, (!empty($row['invoice_no']) ? $row['invoice_no'] : "-"));
										$objPHPExcel->getActiveSheet()->SetCellValue('J'.$coo, php_excel_date($row['invoice_date']));
										$objPHPExcel->getActiveSheet()->SetCellValue('K'.$coo, php_excel_date($row['created_date']));
										$objPHPExcel->getActiveSheet()->SetCellValue('L'.$coo, alias($row['condition_id'],'ec_stock','stock_alias','description'));
										$location_ali = $row['location'];
										$location = alias($location_ali,'ec_warehouse','wh_alias','wh_code');
										$objPHPExcel->getActiveSheet()->SetCellValue('M'.$coo, ($location=="" || $location=="NA" ? alias($location_ali,'ec_sitemaster','site_alias','site_name') : $location));
									}
								}
	//With Out Cell History Ends
	//With Cell History Starts
								else if($datetype=='2'){
									$objPHPExcel->setActiveSheetIndex($ch_index);
									$objPHPExcel->getActiveSheet()->setTitle('With Cell History');
									$collArr=array('Cell Number','Cell History','Transaction Date');
									$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
									$ch = 'A';
									foreach($collArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
										$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
										$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
										$ch++;
									}
									$cooo=1;
									$objPHPExcel->getActiveSheet()->getStyle("C")->getNumberFormat()->setFormatCode('mm/dd/yyyy');
									$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
									$item_code_alias=array();
									while($row=mysqli_fetch_array($sql)){
										$coo++; $item_code_alias[]=$row['item_code_alias'];
										$s=mysqli_query($mr_con,"SELECT message,transaction_date FROM ec_total_cell_history WHERE cell_alias='".$row['item_code_alias']."' AND flag=0");
										while($rowsm=mysqli_fetch_array($s)){ $cooo++;
											$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$cooo, alias($row['item_code_alias'],'ec_item_code','item_code_alias','item_description'),PHPExcel_Cell_DataType::TYPE_STRING);
											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$cooo, $rowsm['message']);
											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$cooo, php_excel_date($rowsm['transaction_date']));
										}
									}
								}$ch_index++;
	//With Cell History Ends
							}else{ $no_rec=$objPHPExcel->getActiveSheet();$nc++;}
						}else{$resCode='4';$resMsg='Data Type is manditory';}
					}
	//ACCESSORIES STARTS
					if(in_array('2',$item_type) & $resCode!='4'){
						if($ch_index>0){$objPHPExcel->createSheet();}
						$objPHPExcel->setActiveSheetIndex($ch_index);
						$objPHPExcel->getActiveSheet()->setTitle('Accessory');
						$sq=mysqli_query($mr_con,"SELECT COUNT(t1.id) AS num FROM ec_item_code t1 INNER JOIN ec_total_accessories t2 ON t1.item_code_alias=t2.acc_alias LEFT JOIN ec_material_request t3 ON t1.sjo_no=t3.mrf_alias WHERE $condition t1.item_type='2' AND t1.flag='0' AND t2.flag='0'");
						$count=mysqli_fetch_array($sq);
						if($count['num']){
							$sql=mysqli_query($mr_con,"SELECT t1.invoice_no,t1.invoice_date,t1.item_description,t1.created_date,t1.quantity,t1.item_code_alias,t2.item_code,t2.location,t3.sjo_number,t3.sjo_date FROM ec_item_code t1
							INNER JOIN ec_total_accessories t2 ON t1.item_code_alias=t2.acc_alias
							LEFT JOIN ec_material_request t3 ON t1.sjo_no=t3.mrf_alias
							WHERE $condition t1.item_type='2' AND t1.flag='0' AND t2.flag='0'");
							$collArr=array('Accessory Description','Quantity','Item Type','SJO Number','SJO Date','Invoice Number','Invoice Date','Created Date','Price','Weight','Current Location');
							$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
							$ch = 'A';
							foreach($collArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
								$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
								$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
								$ch++;
							}
							$date_arr = array("E","G","H");
							foreach($date_arr as $da){
								$objPHPExcel->getActiveSheet()->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');
								$objPHPExcel->getActiveSheet()->getColumnDimension($da)->setAutoSize(true);
							}
							$cooo=1;							
							while($rowsm=mysqli_fetch_array($sql)){ $cooo++;
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$cooo, alias($rowsm['item_code'],'ec_accessories','accessories_alias','accessory_description'));
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$cooo, $rowsm['quantity']);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$cooo, "Accessory");
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$cooo, $rowsm['sjo_number']);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$cooo, php_excel_date($rowsm['sjo_date']));
								$objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$cooo, checkemptydash($rowsm['invoice_no']),PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$cooo, php_excel_date($rowsm['invoice_date']));
								$objPHPExcel->getActiveSheet()->SetCellValue('H'.$cooo, php_excel_date($rowsm['created_date']));
								$objPHPExcel->getActiveSheet()->SetCellValue('I'.$cooo, $rowsm['item_description']*(round(alias($rowsm['item_code'],'ec_accessories','accessories_alias','price'),2)));
								$objPHPExcel->getActiveSheet()->SetCellValue('J'.$cooo, alias($rowsm['item_code'],'ec_accessories','accessories_alias','weight'));
								
								$sss=mysql_query($mr_con,"SELECT location,location_type,stage FROM ec_total_accessories WHERE acc_alias='".$rowsm['item_code_alias']."' AND flag='0'");
								if(mysqli_num_rows($sss)){
									$rowet=mysqli_fetch_array($sss);
									$current_location = current_location($rowet['stage'],$rowet['location_type'],$rowet['location']);
								}else $current_location ='NA';
								$objPHPExcel->getActiveSheet()->SetCellValue('K'.$cooo, $current_location);
							}
						}else{$no_rec=$objPHPExcel->getActiveSheet();$nc++;}
					}
	//ACCESSORIES ENDS
					if($resCode!='4'){
						if($nc!=count($item_type)){
							if($nc=='1')$no_rec->SetCellValue('A1', 'No Records Found');
							$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
							$objWriter->save("../../exports/$filename.xlsx");
							$result['file_name']=$filename; 
							$resCode='0'; $resMsg='export';
						}else{$resCode='4';$resMsg="No Records Found";}
					}
				}
			}else{$resCode='4';$resMsg="Item Type is manditory";}
		//}else{$resCode='4';$resMsg="Data Filter is manditory";}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function sjo_search_export(){ global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	//$whouse=getempwarehouse($emp_alias);
	if($rex==0){
		if(isset($_REQUEST['alias']) && $_REQUEST['alias']!="" && strtoupper($_REQUEST['alias'])!="UNDEFINED"){ $condtion=" sjo_no IN (SELECT mrf_alias FROM ec_material_request WHERE sjo_number ='".mysqli_real_escape_string($mr_con,strtoupper($_REQUEST['alias']))."') AND ";}
		else{ $condtion=""; }
			//echo $_REQUEST['alias'];
			$sql = mysqli_query($mr_con,"SELECT item_code,item_description,item_code_alias,sjo_no,item_type FROM ec_item_code WHERE $condtion flag=0");
			$colArr=array('SJO Number','SJO Date','Cell Number/Qty','Cell Capacity/Accessory Desc','Item Condition','Current Location','Item Value');
			//$colArr2=array('item_description','from_wh','to_wh','date_of_request','material_value','sjo_number','ticket_alias','status');
			$filename = 'SJO_search_'.date('d-m-Y H_i_s');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
			$ch = 'A';
			foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
				$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
			$ch++;
			}
			$objPHPExcel->getActiveSheet()->getStyle("B")->getNumberFormat()->setFormatCode('mm/dd/yyyy');
			$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
			$coo=1;
			while($row=mysqli_fetch_array($sql)){ $coo++;
				//for($af=0,$chr='A';$af<count($colArr2);$af++,$chr++){	$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);}
				if(isset($_REQUEST['alias']) && $_REQUEST['alias']!="" && strtoupper($_REQUEST['alias'])!="UNDEFINED"){
					$sjo_number=mysqli_real_escape_string($mr_con,strtoupper($_REQUEST['alias']));
				}else{
					$sjo_number=($row['sjo_no']!='' ? alias($row['sjo_no'],'ec_material_request','mrf_alias','sjo_number') : '-');
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$coo, $sjo_number);
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$coo, php_excel_date(alias($row['sjo_no'],'ec_material_request','mrf_alias','sjo_date')));
				$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$coo, $row['item_description'],PHPExcel_Cell_DataType::TYPE_STRING);
				
				if($row['item_type']=='1'){ //Cells
					$sqlc = mysqli_query($mr_con,"SELECT t1.condition_id, t1.stage, t1.location, t1.location_type, t2.product_description, t2.price FROM ec_total_cell t1 INNER JOIN ec_product t2 ON t1.item_code=t2.product_alias WHERE t1.cell_alias='".$row['item_code_alias']."' AND t1.flag=0");
					if(mysqli_num_rows($sqlc)){
						$rowc=mysqli_fetch_array($sqlc);
						$description=$rowc['product_description'];
						$condi=alias($rowc['condition_id'],'ec_stock','stock_alias','description');
						$current_location = current_location($rowc['stage'],$rowc['location_type'],$rowc['location']);
						$price=round($rowc['price'],2);
					}else $description=$condi=$current_location=$price="NA";
				}else{ //Accessories
					$sqlc = mysqli_query($mr_con,"SELECT t1.good_qty,t1.damaged_qty,t1.lost_qty,t1.stage,t1.location_type, t1.location, t2.accessory_description, t2.price FROM ec_total_accessories t1 INNER JOIN ec_accessories t2 ON t1.item_code=t2.accessories_alias WHERE t1.acc_alias='".$row['item_code_alias']."' AND t1.flag=0");
					if(mysqli_num_rows($sqlc)){
						$rowa=mysqli_fetch_array($sqlc);
						$description=$rowa['accessory_description'];
						$condi="GOOD:".$rowa['good_qty'].", DAMAGED:".$rowa['damaged_qty'].", LOST:".$rowa['lost_qty'];
						$current_location = current_location($rowa['stage'],$rowa['location_type'],$rowa['location']);
						$price=round($rowa['price'],2);
					}else $description=$condi=$current_location=$price="NA";
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$coo,$description);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$coo,$condi);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$coo, $current_location);

				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$coo, $price);
			}
			$objPHPExcel->getActiveSheet()->setTitle('SJO Search');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save("../../exports/$filename.xlsx");
			$result['file_name']=$filename;
			$resCode='0'; $resMsg='export';
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function stocks_import(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$rex=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($rex==0){
		$mrf_alias=mysqli_real_escape_string($mr_con,$_REQUEST['sjo_no']);
		if(isset($_FILES["file"])){
			if($_FILES["file"]["error"]>0){$res = "No file selected";}
			else{$ercode=0;
				$extn = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
				if($extn=='xlsx' || $extn=='xls' || $extn=='XLSX' || $extn=='XLS'){
					set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
					$inputFileName = $_FILES["file"]["tmp_name"];
					try{$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);}
					catch(Exception $e){$ercode=1;$res ="Error loading file: ".$e->getMessage();}
					if($ercode=='0'){
						$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
						$highestColumm=$objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
						$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumm);
						$arrayCount = count($allDataInSheet);
						$a=$b=$c=$item_description=$item_type=$dd=$arsm=$jjj=array();
						//$sql1=mysqli_query($mr_con,"SELECT GROUP_CONCAT(DISTINCT(t1.item_type)) AS item_type,GROUP_CONCAT(DISTINCT(t2.product_description)) AS item_description,SUM(t1.left_quanty) AS total_left_qty FROM ec_request_items t1 INNER JOIN ec_product t2 ON t1.item_description=t2.product_alias WHERE t1.mrf_alias ='$mrf_alias' AND t1.flag=0 AND t2.flag=0");
						$sql1=mysqli_query($mr_con,"SELECT item_type,cell_type,item_description,SUM(cappr_quanty) AS total_left_qty FROM ec_request_items WHERE mrf_alias ='$mrf_alias' AND cappr_quanty<>'0' AND flag=0 GROUP BY item_description,cell_type");
						while($row1=mysqli_fetch_array($sql1)){
							$cell_type = ($row1['cell_type']=='1' ? 'NEW':'REVIVED');
							if($row1['item_type']=='1'){
								$a[]='CELLS';
								$item_disc=alias($row1['item_description'],'ec_product','product_alias','product_description')."_".$cell_type;
							}else{
								$item_disc=alias($row1['item_description'],'ec_accessories','accessories_alias','accessory_description')."_".$cell_type;
								$a[]='ACCESSORIES';
							}
							$item_description[]=$item_disc;
							$b[]=$row1['total_left_qty'];
							$c[$item_disc]=$row1['total_left_qty'];
						}
						foreach(array_keys(array_column($allDataInSheet,"A"),'ACCESSORIES') as $uu)$arsm[]=$allDataInSheet[$uu+1]["C"];
						$gg=array_count_values(array_column($allDataInSheet,"A"));
						$item_type=array_unique($a);
						$total_left_qty = array_sum($b);
						if($total_left_qty==($gg["CELLS"]+array_sum($arsm))){
							for($i=2;$i<=$arrayCount;$i++){
								$ty[($i-2)]=strtoupper(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["A"])));
								$zz=strtoupper(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["B"])));
								$ce[($i-2)]=strtoupper(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["C"])));
								$ct[($i-2)]=strtoupper(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["D"])));
								$pr[($i-2)]=$zz."_".$ct[($i-2)];
								$hhh[($i-2)]=$zz;
							}
							if(count($ty)!=count(array_filter($ty))){$res = "Having Empty Item Type in the Uploaded Excel";}
							elseif(count($hhh)!=count(array_filter($hhh))){$res = "Having Empty Battery Rating in the Uploaded Excel";}
							elseif(count($ce)!=count(array_filter($ce))){$res = "Having Empty Cell Serial Number in the Uploaded Excel";}
							elseif(count($ct)!=count(array_filter($ct))){$res = "Having Empty Cell Type in the Uploaded Excel";}
							else{
								/*$x=array_filter(array_unique($ce));
								$cell_dup = array_filter(array_diff_key($ce,$x));
								if(count($cell_dup)=='0'){*/
								$ch1=$ce;
								foreach(array_keys($ty,'ACCESSORIES') as $rr){$jjj[$pr[$rr]]=$ch1[$rr];unset($ch1[$rr]);}
								$ch1=array_values($ch1);
								$x=array_unique($ch1);
								$cell_dup=array_diff_key($ch1,$x);
								$counts = array_count_values($cell_dup);
								$tf = ((count($cell_dup)>'0' && count($cell_dup)==$counts["NA"]) ? TRUE : FALSE);
								if(count($cell_dup)=='0' || $tf){
									$typ_def=array('CELLS','ACCESSORIES');
									$typ = array_values($ty);
									$pro = array_values($pr);
									$cell_ser_arr = array_values($x);
									$ch=array_count_values($pro);
									
									foreach($jjj as $e=>$k)$ch[$e]=$k;
									
									$type_count=count(array_diff($item_type,$typ));
									$prod_count=count(array_diff($item_description,$pro));
									if(count($item_type)==count(array_unique($typ)) && $type_count=='0'){
										if(count($item_description)==count(array_unique($pro)) && $prod_count=='0'){
											foreach($c as $ke=>$f)if($f != $ch[$ke])$dd[]=$ke;
											if(!count($dd)){
												if(count(array_unique(array_merge($typ_def,$typ)))>'2'){
													$res = "Only 'CELLS' & 'ACCESSORIES' are allowed in first Column";
												}else{
													if($tf || in_array("NA",$x)){
														$x=$ce;
														$sql_nv_max=mysqli_query($mr_con,"SELECT MAX(CAST(SUBSTRING_INDEX(item_description,'-',-1) AS SIGNED)) AS nv_max FROM ec_item_code WHERE item_description LIKE '%NOT VISIBLE-%' AND flag='0'");
														$row_nv_max=mysqli_fetch_array($sql_nv_max);
														$nv_max=($row_nv_max['nv_max']!=NULL ? $row_nv_max['nv_max'] : '0');
													}
													$tplist="'".implode("','",array_unique($hhh))."'";
													$num=mysqli_query($mr_con,"SELECT accessory_description as progg, accessories_alias as sliss FROM ec_accessories WHERE accessory_description IN ($tplist) UNION SELECT product_description as progg, product_alias as sliss FROM ec_product WHERE product_description IN ($tplist)");
													if(mysqli_num_rows($num)>'0'){
														while($acr=mysqli_fetch_array($num)){$prolistt[]=$acr['progg'];}
														$errorprods=array_diff($hhh, $prolistt);
														if(count($errorprods)>'0')$res = implode(", ",array_unique($errorprods))." are Wrong product entries";
														else{
															$tclist="'".implode("','",$cell_ser_arr)."'";
															//echo "SELECT item_description FROM ec_item_code WHERE item_description IN ($tclist) AND item_type='1' AND flag='0'";
															$num=mysqli_query($mr_con,"SELECT item_description FROM ec_item_code WHERE item_description IN ($tclist) AND item_type='1' AND flag='0'");
															if(mysqli_num_rows($num)>'0'){
																while($acr=mysqli_fetch_array($num)){$excells[]=$acr['item_description'];}
																$res = implode(", ",array_unique($excells))." are Duplicate Cell Serial Entries";
															}else{
																for($k=0,$z=1;$k<count($ce);$k++){
																	if($ty[$k]=='CELLS'){
																		$result['itemx'][$k]['celltype']=($ct[$k]=='NEW' ? 1 : 2);
																		$result['itemx'][$k]['itemtypes']=1;
																		$item_alia=alias($hhh[$k],'ec_product','product_description','product_alias');
																	}
																	else{
																		$result['itemx'][$k]['celltype']=1;
																		$result['itemx'][$k]['itemtypes']=2;
																		$item_alia=alias($hhh[$k],'ec_accessories','accessory_description','accessories_alias');
																	}
																	$result['itemx'][$k]['itemtype']=$ty[$k];
																	$result['itemx'][$k]['itemdesc']=$result['itemx'][$k]['itemdesc']=$hhh[$k];
																	$result['itemx'][$k]['itemalias']=$item_alia;
																	if($ce[$k]=="NA"){$y='NOT VISIBLE-'.($nv_max+$z);$z++;}else{$y=$ce[$k];}
																	$result['itemx'][$k]['cell_num']=$y;
																	//$result['itemx'][$k]['cell_num']=$ce[$k];
																}
																$resCode=0;$resMsg='Successful';
																$result['invoicing']="0";
																$result['itemcount']="1";
																$result['mssga']="1";
															}
														}
													}
												}
											}else{$res = implode(", ",$dd)." are not match the requested quantity";}
										}else{$res = implode(", ",array_unique(array_diff($pro,$item_description)))." are Not Requested Items";}
									}else{$res = implode(", ",array_unique(array_diff($typ,$item_type)))." is Not Requested Item Type";}
								}else{ $res = implode(", ",(in_array("NA", $cell_dup) ? array_diff($cell_dup, array("NA")) : $cell_dup))." are duplicate entries of cell serial numbers in excel";}
							}
						}else if($highestColumnIndex!='4'){$res = 'Excel records should not having the Expected format';}
						else{$res = "Excel records should match the PPC planned quantity";}
					}
				}else{ $res = 'Invalid file...';}
			}
		}else{ $res = "No file selected"; }
		if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	$result['import']="1";
	echo json_encode($result);
}

function is_valid_date($value, $format = 'dd.mm.yyyy'){
	if(strlen($value) >= 6 && strlen($format) == 10){
		$separator_only = str_replace(array('m','d','y'),'', $format);
		$separator = $separator_only[0];
		if($separator && strlen($separator_only) == 2){
			$regexp = str_replace('mm', '(0?[1-9]|1[0-2])', $format);
			$regexp = str_replace('dd', '(0?[1-9]|[1-2][0-9]|3[0-1])', $regexp);
			$regexp = str_replace('yyyy', '(19|20)?[0-9][0-9]', $regexp);
			$regexp = str_replace($separator, "\\" . $separator, $regexp);
			if($regexp != $value && preg_match('/'.$regexp.'\z/', $value)){
				$arr=explode($separator,$value);$day=$arr[0];$month=$arr[1];$year=$arr[2]; 
				if(@checkdate($month, $day, $year))return true; 
			} 
		} 
	} 
	return false; 
}
function scrap_inward_by_fact_export(){ global $mr_con;
	set_time_limit(0);
	ini_set('memory_limit', '1024M');
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){ $no_rec=0; $condition="";
		if(isset($_REQUEST['from_date']) && $_REQUEST['from_date']!="")$fromDate=dateFormat(mysqli_real_escape_string($mr_con,$_REQUEST['from_date']),'y');else $fromDate='0';
		if(isset($_REQUEST['to_date']) && $_REQUEST['to_date']!="")$toDate=dateFormat(mysqli_real_escape_string($mr_con,$_REQUEST['to_date']),'y');else $toDate='0';
		if($fromDate!='0')$condition.="dispatch_date>='".$fromDate."' AND ";
		if($toDate!='0')$condition.="dispatch_date<='".$toDate."' AND ";
		if($fromDate > $toDate && $toDate!=0){$resCode='4';$resMsg="Select To Date must be Greater than From Date";}
		else{
			$bb=mysqli_query($mr_con,"SELECT t1.trans_id,t1.dispatch_date,GROUP_CONCAT(DISTINCT '''',t2.item_description,'''') AS item_desc FROM ec_material_inward t1 INNER JOIN ec_material_received_details t2 ON t1.alias=t2.reference WHERE t1.from_type='4' AND $condition t1.flag='0' GROUP BY t1.alias");
			if(mysqli_num_rows($bb)>'0'){
				$objPHPExcel = new PHPExcel();
				$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
				$objPHPExcel->setActiveSheetIndex(0);
				$sheet = $objPHPExcel->getActiveSheet();
				$objPHPExcel->setActiveSheetIndex(0);
				$sheet = $objPHPExcel->getActiveSheet();
				$sheet->setTitle('Scrap Inward');
				$colArr=array('Scrap Inward Reference','Inward Date','Faulty Cells Received By Factory Serial Number','Capacity','Replaced Cell Serial Number','SJO Raised TT Number','Outward TT Number','SJO Number');
				$last_key = end(array_keys($colArr));
				$last_alpha = num2alpha($last_key);
				$sheet->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
				$sheet->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
				$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',$colrefValue); $ch++; }
				$sheet->getStyle('B')->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension('B')->setAutoSize(true);
				$coo=1;
				while($bbb=mysqli_fetch_array($bb)){
					$sql_out=mysqli_query($mr_con,"SELECT t1.sjo_number,GROUP_CONCAT(DISTINCT '''',t2.item_description,'''') AS item_desc FROM ec_material_outward t1 INNER JOIN ec_material_sent_details t2 ON t1.alias=t2.reference WHERE t1.sjo_number<>'' AND t1.from_type='2' AND t2.item_description IN(".$bbb['item_desc'].") AND t1.flag='0' GROUP BY t1.sjo_number");
					if(mysqli_num_rows($sql_out)){
						while($row_out=mysqli_fetch_array($sql_out)){ $replaced_cells = array();
							$sjo_number = alias($row_out['sjo_number'],'ec_material_request','mrf_alias','sjo_number');
							$ticket_alias = alias($row_out['sjo_number'],'ec_material_request','mrf_alias','ticket_alias');
							if($ticket_alias=='2609')$raised_ticket_id='BUFFER';
							else{
								$raised_ticket_id = alias($ticket_alias,'ec_tickets','ticket_alias','ticket_id');
								if(empty($raised_ticket_id))$raised_ticket_id='-';
							}
							$tt_sql=mysqli_query($mr_con,"SELECT ref_no FROM ec_material_outward WHERE from_type='1' AND sjo_number='".$row_out['sjo_number']."' AND flag='0'");
							if(mysqli_num_rows($tt_sql)){
								$tt_row = mysqli_fetch_array($tt_sql);
								if($tt_row['ref_no']=='2609')$out_ticket_id='BUFFER';
								else{
									$out_ticket_id = alias($tt_row['ref_no'],'ec_tickets','ticket_alias','ticket_id');
									if(empty($out_ticket_id))$out_ticket_id='-';
									else{
										$replaced_cells = explode(", ",alias($tt_row['ref_no'],'ec_engineer_observation','ticket_alias','replaced_cell_no'));
									}
								}
							}else $out_ticket_id='-';
							$itm_sql=mysqli_query($mr_con,"SELECT item_code,item_description FROM ec_item_code WHERE item_code_alias IN(".$row_out['item_desc'].") AND flag='0'");
							if(mysqli_num_rows($itm_sql)>'0'){
								$i=0;while($itm_row=mysqli_fetch_array($itm_sql)){ $coo++;
									$sheet->SetCellValue('A'.$coo, $bbb['trans_id']) //Scrap Inward Reference
											->SetCellValue('B'.$coo, php_excel_date($bbb['dispatch_date'])) //Inward Date
											->setCellValueExplicit('C'.$coo, $itm_row['item_description'],PHPExcel_Cell_DataType::TYPE_STRING) //Faulty Cells Received By Factory Serial Number
											->SetCellValue('D'.$coo, alias($itm_row['item_code'],'ec_product','product_alias','product_description')) //Capacity
											->setCellValueExplicit('E'.$coo, (!empty($replaced_cells[$i]) ? $replaced_cells[$i] : '-'),PHPExcel_Cell_DataType::TYPE_STRING) //Replaced Cell Serial Number
											->setCellValue('F'.$coo, $raised_ticket_id) //SJO Raised TT Number
											->setCellValue('G'.$coo, $out_ticket_id) //Outward TT Number
											->SetCellValue('H'.$coo, $sjo_number); //SJO Number
								$i++;}
							}else{ $coo++;
								$sheet->SetCellValue('A'.$coo, $bbb['trans_id']) //Scrap Inward Reference
										->SetCellValue('B'.$coo, php_excel_date($bbb['dispatch_date'])) //Inward Date
										->setCellValueExplicit('C'.$coo, '-',PHPExcel_Cell_DataType::TYPE_STRING) //Faulty Cells Received By Factory Serial Number
										->SetCellValue('D'.$coo, '-') //Capacity
										->setCellValueExplicit('E'.$coo, (!empty($replaced_cells[0]) ? $replaced_cells[0] : '-'),PHPExcel_Cell_DataType::TYPE_STRING) //Replaced Cell Serial Number
										->setCellValue('F'.$coo, $raised_ticket_id) //SJO Raised TT Number
										->setCellValue('G'.$coo, $out_ticket_id) //Outward TT Number
										->SetCellValue('H'.$coo, $sjo_number); //SJO Number
							}
						}
					}else{ $coo++;
						$sheet->SetCellValue('A'.$coo, $bbb['trans_id']) //Scrap Inward Reference
								->SetCellValue('B'.$coo, php_excel_date($bbb['dispatch_date'])) //Inward Date
								->setCellValueExplicit('C'.$coo, '-',PHPExcel_Cell_DataType::TYPE_STRING) //Faulty Cells Received By Factory Serial Number
								->SetCellValue('D'.$coo, '-') //Capacity
								->setCellValueExplicit('E'.$coo, '-',PHPExcel_Cell_DataType::TYPE_STRING) //Replaced Cell Serial Number
								->setCellValue('F'.$coo, '-') //SJO Raised TT Number
								->setCellValue('G'.$coo, '-') //Outward TT Number
								->SetCellValue('H'.$coo, '-'); //SJO Number
					}
				}
				$filename = 'SJO_Balance_'.date('d-m-Y H_i_s');
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$objWriter->save("../../exports/$filename.xlsx");
				$result['file_name']=$filename;
				$resCode='0'; $resMsg='export';
			}else{$resCode='4';$resMsg="No Records Found To Run Report";}
		}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function sjo_bal_export(){ 
	global $mr_con;
	set_time_limit(0);
	ini_set('memory_limit', '1024M');
	//$sq=mysqli_query($mr_con,"SET GLOBAL group_concat_max_len = 10000000");
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex==0){ $item_type=array();
		if(isset($_REQUEST['item_type']) && count($_REQUEST['item_type']))$item_type=$_REQUEST['item_type'];else $item_type[]='0';
		if(!in_array('0',$item_type)){ $no_rec=0;
			if(isset($_REQUEST['from_date']) && $_REQUEST['from_date']!="")$fromDate=dateFormat(mysqli_real_escape_string($mr_con,$_REQUEST['from_date']),'y');else $fromDate='0';
			if(isset($_REQUEST['to_date']) && $_REQUEST['to_date']!="")$toDate=dateFormat(mysqli_real_escape_string($mr_con,$_REQUEST['to_date']),'y');else $toDate='0';
			if(isset($_REQUEST['datetype']) && $_REQUEST['datetype']!="")$datetype=mysqli_real_escape_string($mr_con,$_REQUEST['datetype']);else $datetype='0';
			if(alias($emp_alias,'ec_employee_master','employee_alias','privilege_alias')!='8NHXNU4NDP'){ //Sunkarachandra shekar
				if(isset($_REQUEST['zone_alias']) && count(array_filter($_REQUEST['zone_alias'])))$zone="'".implode("','",$_REQUEST['zone_alias'])."'";else $zone='0';
				if(isset($_REQUEST['wh_alias']) && count(array_filter($_REQUEST['wh_alias'])))$wh="'".implode("','",$_REQUEST['wh_alias'])."'";else $wh='0';
				if($zone=='0' && $wh=='0'){$wh=getempwarehouse($emp_alias);}
				elseif($zone!='0'){
					if($wh=='0'){
						$a=mysqli_query($mr_con,"SELECT COUNT(id) AS num,GROUP_CONCAT('''',wh_alias,'''') AS alias FROM ec_warehouse WHERE zone_alias IN ($zone) AND flag='0'");
						$aa=mysqli_fetch_array($a);
						if($aa['num']){ $wh=$aa['alias'];}
						else{ $wh=getempwarehouse($emp_alias); }
					}
				}else{ $wh=($wh!='0' ? $wh : getempwarehouse($emp_alias)); }
			}else $wh='0';
			//if($fromDate!='0')$c1=" date_of_request>='".$fromDate."' AND ";else $c1="";
			//if($toDate!='0')$c2=" date_of_request<='".$toDate."' AND ";else $c2="";
			$c1=$c2=$c3=$d1=$d2=$d3=$cust=$dust="";
			if(isset($_REQUEST['customer_alias']) && count(array_filter($_REQUEST['customer_alias']))){
				$customer="'".implode("','",$_REQUEST['customer_alias'])."'";
				$cust="customer_alias IN ($customer) AND ";
				$dust="jm1.customer_alias IN ($customer) AND ";
			}
			if(isset($_REQUEST['product_alias']) && count(array_filter($_REQUEST['product_alias']))){
				$prodd="'".implode("','",$_REQUEST['product_alias'])."'";
				$crod="mrf_alias IN ( SELECT mrf_alias FROM ec_request_items WHERE item_description IN ($prodd) AND flag='0') AND ";
				$prod="jm2.item_description IN ($prodd) AND ";
			}
			if(isset($_REQUEST['re_dates']) && !empty($_REQUEST['re_dates'])){
				$re_dates = $_REQUEST['re_dates'];
				if($re_dates=='1'){ $date_head="Requested Date"; //date_of_request
					if($fromDate!='0'){$c1="date_of_request>='".$fromDate."' AND ";$d1="jm1.date_of_request>='".$fromDate."' AND ";}
					if($toDate!='0'){$c2="date_of_request<='".$toDate."' AND ";$d2="jm1.date_of_request<='".$toDate."' AND ";}
				}else if($re_dates=='2'){ $date_head="SJO Date"; //sjo_date
					if($fromDate!='0'){$c1="sjo_date>='".$fromDate."' AND ";$d1="jm1.sjo_date>='".$fromDate."' AND ";}
					if($toDate!='0'){$c2="sjo_date<='".$toDate."' AND ";$d2="jm1.sjo_date<='".$toDate."' AND ";}
				}else if($re_dates=='3'){ $date_head="Sales Invoice Date"; //sales_invoice_date
					if($fromDate!='0'){$c1="sales_invoice_date>='".$fromDate."' AND ";$d1="jm1.sales_invoice_date>='".$fromDate."' AND ";}
					if($toDate!='0'){$c2="sales_invoice_date<='".$toDate."' AND ";$d2="jm1.sales_invoice_date<='".$toDate."' AND ";}
				}else if($re_dates=='4'){ $date_head="Inward Date"; //date_of_trans
					if($fromDate!='0'){$c1="mrf_alias IN (SELECT sjo_number FROM ec_material_inward WHERE date_of_trans >='".$fromDate."' AND flag='0') AND ";$d1="jm1.mrf_alias IN (SELECT sjo_number FROM ec_material_inward WHERE date_of_trans >='".$fromDate."' AND flag='0') AND ";}
					if($toDate!='0'){$c2="mrf_alias IN (SELECT sjo_number FROM ec_material_inward WHERE date_of_trans <='".$toDate."' AND flag='0') AND ";$d2="jm1.mrf_alias IN (SELECT sjo_number FROM ec_material_inward WHERE date_of_trans <='".$toDate."' AND flag='0') AND ";}
				}else $c1=$c2=$d1=$d2=$date_head="";
			}
			if($wh!='0'){$c3=" from_wh IN (".$wh.") AND ";$d3=" jm1.from_wh IN (".$wh.") AND ";}
			$condition=$c1.$c2.$c3.$cust.$crod;
			$dondition=$d1.$d2.$d3.$dust.$prod;
			if($fromDate > $toDate && $toDate!=0){$resCode='4';$resMsg="Select To Date must be Greater than From Date";}
			else{
				//if(isset($re_dates) && $re_dates!=""){
					//echo "SELECT COUNT(id) AS mrcount FROM ec_material_request WHERE $condition flag='0'";
				$bb=mysqli_query($mr_con,"SELECT COUNT(id) AS mrcount FROM ec_material_request WHERE $condition flag='0'");
				$bbb=mysqli_fetch_array($bb);
				if($bbb['mrcount']>'0'){
					$objPHPExcel = new PHPExcel();
					$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF')));
					$sh_index = 0;
					$fct_wh=alias('1','ec_warehouse','wh_type','wh_alias');
	//WithOut Cell Serial number
					if(in_array('1',$item_type)){
						if(isset($_REQUEST['datetype']) && !empty($_REQUEST['datetype'])){
							$objPHPExcel->setActiveSheetIndex($sh_index);
							$sheet = $objPHPExcel->getActiveSheet();
							if($datetype=='1'){
								$sheet->setTitle('Without Cell Serial number');
								$colArr=array('FY Year','Zone','State','SJO Number','SJO Date','Customer Name','Site Names','TT Number','Sales Invoice Number','Sales Invoice Date','Sales PO Number','Customer Address','Customer Contact Person','Customer Contact No','Cell Capacity/Item Name','Reason/Remarks','Requested Date','Requested QTY','Request Status','Invoice /NRBC Number','Invoice Date','Dispatched Status(SCM)','Dispached Date(SCM)','Transporter Details(SCM)','Docket Number(SCM)','Dispatched Status(To Factory)','Dispached Date(To Factory)','Transporter Details(To Factory)','Docket Number(To Factory)','Dispatched Quantity from Factory to Field','Faulty Cell Quantity','New Cells Quantity','Cells Replaced Quantity','Faulty Cells received at Factory Quantity','Balance Quantity need to Return to factory','SJO VS Dispatched Balance','Lost Cells at Field');
								$last_key = end(array_keys($colArr));
								$last_alpha = num2alpha($last_key);
								$sheet->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
								$sheet->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
								$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',$colrefValue); $ch++; }
								$date_arr = array("E","J","Q","U","W","AA");
								foreach($date_arr as $da){$sheet->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension($da)->setAutoSize(true);}
								$b=mysqli_query($mr_con,"SELECT jm1.from_wh, jm1.date_of_request, jm1.sjo_number, jm1.sjo_date, jm1.ticket_alias, jm1.customer_alias, jm1.sales_invoice_no, jm1.sales_invoice_date, jm1.sales_po_no, jm1.contact_person, jm1.customer_address, jm1.customer_phone, jm1.mrf_alias, jm1.status, jm2.item_description, jm2.quantity FROM ec_material_request jm1 INNER JOIN ec_request_items jm2 ON jm1.mrf_alias=jm2.mrf_alias WHERE jm1.sjo_number<>'0' AND jm1.ticket_alias<>'0' AND jm2.flag = 0 AND jm1.flag = 0 AND $dondition jm2.item_type='1'");
								if(mysqli_num_rows($b)){ $i=0;$coo=1;
									while($bb=mysqli_fetch_array($b)){$coo++;
										$ticketalias[$i]=$bb['ticket_alias'];
										$mrfalias[$i]=$bb['mrf_alias'];
										$productalias[$i]=$bb['item_description'];
										if($ticketalias[$i]!="2609" && !empty($ticketalias[$i])){
											$site_temp[$i]=alias($ticketalias[$i],'ec_tickets','ticket_alias','site_alias');
											$site_name[$i]=alias($site_temp[$i],'ec_sitemaster','site_alias','site_name');
											$ticket_id[$i]=strtok(alias($ticketalias[$i],'ec_tickets','ticket_alias','ticket_id'),"|");
										}else{ $site_name[$i]="-";$ticket_id[$i]="BUFFER";}
										$a_fina_yr[$i]=financial_year($bb['date_of_request']);
										$b_zone[$i]=alias(alias($bb['from_wh'],'ec_warehouse','wh_alias','zone_alias'),'ec_zone','zone_alias','zone_name');
										$c_wh[$i]=alias($bb['from_wh'],'ec_warehouse','wh_alias','wh_code');
										$d_sjo_num[$i]=$bb['sjo_number'];
										$e_sjo_dt[$i]=php_excel_date($bb['sjo_date']);
										$f_cust[$i]=alias($bb['customer_alias'],'ec_customer','customer_alias','customer_name');
										$g_site_nam[$i]=$site_name[$i];
										$h_tt_id[$i]=$ticket_id[$i];
							
										$i_sal_inv_no[$i]=$bb['sales_invoice_no'];
										$j_sal_inv_dt[$i]=php_excel_date($bb['sales_invoice_date']);
										$k_sal_po_no[$i]=$bb['sales_po_no'];
										$l_cust_addr[$i]=$bb['customer_address'];
										$m_cont_per[$i]=$bb['contact_person'];
										$n_cont_phn[$i]=$bb['customer_phone'];
										
										$o_prod[$i]=alias($productalias[$i],'ec_product','product_alias','product_description');
										$p_resn_remr[$i]=getoneremark($mrfalias[$i],'MR');
										$q_mat_req_dt[$i]=php_excel_date($bb['date_of_request']);
										$r_qty[$i]=$bb['quantity'];
										$s_req_status[$i]=fam_lvl_nm_clr($bb['status'],"name",$bb['mrf_alias']);
										$inv_sql=mysqli_query($mr_con,"SELECT GROUP_CONCAT(DISTINCT invoice_no SEPARATOR ' | ') AS in_no,GROUP_CONCAT(DISTINCT invoice_date SEPARATOR ' | ') AS in_dt FROM ec_item_code WHERE sjo_no='".$mrfalias[$i]."' AND sjo_no<>'' AND sjo_no<>'0' AND invoice_no<>'' AND invoice_no<>'NA' AND item_type='1' AND flag='0'");
										if(mysqli_num_rows($inv_sql)>'0'){
											$inv_row=mysqli_fetch_array($inv_sql);
											$t_inv_no[$i]=$inv_row['in_no'];
											if(strpos($inv_row['in_dt'],"|")!==false)$u_inv_dt[$i]=$inv_row['in_dt'];else{$sheet->getStyle("U".$coo)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$u_inv_dt[$i]=php_excel_date($inv_row['in_dt']);}
										}else{$t_inv_no[$i]=$u_inv_dt[$i]='-';}
										
										$fdtd=cells_countings($fct_wh,$productalias[$i],$mrfalias[$i],'3');
										if(count(array_diff($fdtd,array('0','-','-','-')))>'0'){
											list($from_factory_count,$dispdt,$trans,$doct)=$fdtd;
											$v_fdisp_status[$i]="Dispatched";
											if(strpos($dispdt,"|")!==false)$w_fdisp_dt[$i]=$dispdt;else{$sheet->getStyle("W".$coo)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$w_fdisp_dt[$i]=php_excel_date($dispdt);}
											$x_ftrans[$i]=$trans;
											$y_fdoct[$i]=$doct;
										}else {$v_fdisp_status[$i]=$w_fdisp_dt[$i]=$x_ftrans[$i]=$y_fdoct[$i]="-";$from_factory_count='0';}
														
										$e_ak[$i]=lost_countings($productalias[$i],$mrfalias[$i]);
										
										$tdtd=cells_countings($fct_wh,$productalias[$i],$mrfalias[$i],'2');
										if(count(array_diff($tdtd,array('0','-','-','-')))>'0'){
											list($to_factory_count,$dispdt,$trans,$doct)=$tdtd;
											$z_tdisp_status[$i]="Dispatched";
											if(strpos($dispdt,"|")!==false)$aa_tdisp_dt[$i]=$dispdt;else{$sheet->getStyle("AA".$coo)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$aa_tdisp_dt[$i]=php_excel_date($dispdt);}
											$ab_ttrans[$i]=$trans;
											$ac_tdoct[$i]=$doct;
										}else{$z_tdisp_status[$i]=$aa_tdisp_dt[$i]=$ab_ttrans[$i]=$ac_tdoct[$i]="-";$to_factory_count='0';}
										
										/*$b3=mysqli_query($mr_con,"SELECT GROUP_CONCAT(dispatch_date SEPARATOR ' | ') AS dispdt,GROUP_CONCAT(transport SEPARATOR ' | ') AS trans,GROUP_CONCAT(docket SEPARATOR ' | ') AS doct FROM ec_material_outward WHERE sjo_number='".$mrfalias[$i]."' AND from_wh='$fct_wh' AND flag='0' GROUP BY dispatch_date");
										if(mysqli_num_rows($b3)>'0'){
											$bb3=mysqli_fetch_array($b3);
											$v_fdisp_status[$i]="Dispatched";
											if(strpos($bb3['dispdt'],"|")!==false)$w_fdisp_dt[$i]=$bb3['dispdt'];else{$sheet->getStyle("W".($i+2))->getNumberFormat()->setFormatCode('mm/dd/yyyy');$w_fdisp_dt[$i]=php_excel_date($bb3['dispdt']);}
											$x_ftrans[$i]=$bb3['trans'];
											$y_fdoct[$i]=$bb3['doct'];
										}else{$v_fdisp_status[$i]="-";$w_fdisp_dt[$i]="-";$x_ftrans[$i]="-";$y_fdoct[$i]="-";}
										
										$b3=mysqli_query($mr_con,"SELECT GROUP_CONCAT(dispatch_date SEPARATOR ' | ') AS dispdt,GROUP_CONCAT(transport SEPARATOR ' | ') AS trans,GROUP_CONCAT(docket SEPARATOR ' | ') AS doct FROM ec_material_outward WHERE sjo_number='".$mrfalias[$i]."' AND to_wh='$fct_wh' AND flag='0' GROUP BY dispatch_date");
										if(mysqli_num_rows($b3)>'0'){
											$bb3=mysqli_fetch_array($b3);
											$z_tdisp_status[$i]="Dispatched";
											if(strpos($bb3['dispdt'],"|")!==false)$aa_tdisp_dt[$i]=$bb3['dispdt'];else{$sheet->getStyle("AA".($i+2))->getNumberFormat()->setFormatCode('mm/dd/yyyy');$aa_tdisp_dt[$i]=php_excel_date($bb3['dispdt']);}
											$ab_ttrans[$i]=$bb3['trans'];
											$ac_tdoct[$i]=$bb3['doct'];
										}else{$z_tdisp_status[$i]="-";$aa_tdisp_dt[$i]="-";$ab_ttrans[$i]="-";$ac_tdoct[$i]="-";}*/
							
										$e_ad[$i]= $from_factory_count;//From Factory
										$e_ae[$i]=faulty_cells_counting($productalias[$i],$mrfalias[$i],$ticketalias[$i]);
										$e_af[$i]=$e_ad[$i];
										$e_ag[$i]=replaced_cells_counting($productalias[$i],$ticketalias[$i]);
										$e_ah[$i]=$to_factory_count; //To Factory
										$e_ai[$i]=$e_ad[$i]-$e_ah[$i]-$e_ak[$i];//outstanding_count($fct_wh,$productalias[$i],$mrfalias[$i]);//$e_ac[$i]-$e_ag[$i];
										$e_aj[$i]=$r_qty[$i]-$e_ad[$i];
										
										$sheet->SetCellValue('A'.$coo, $a_fina_yr[$i])
												->SetCellValue('B'.$coo, $b_zone[$i])
												->SetCellValue('C'.$coo, $c_wh[$i])
												->SetCellValue('D'.$coo, $d_sjo_num[$i])
												->SetCellValue('E'.$coo, $e_sjo_dt[$i])
												->SetCellValue('F'.$coo, $f_cust[$i])
												->SetCellValue('G'.$coo, $g_site_nam[$i])
												->SetCellValue('H'.$coo, $h_tt_id[$i])
												->SetCellValue('I'.$coo, $i_sal_inv_no[$i])
												->SetCellValue('J'.$coo, $j_sal_inv_dt[$i])
												->SetCellValue('K'.$coo, $k_sal_po_no[$i])
												->SetCellValue('L'.$coo, $l_cust_addr[$i])
												->SetCellValue('M'.$coo, $m_cont_per[$i])
												->SetCellValue('N'.$coo, $n_cont_phn[$i])
												->SetCellValue('O'.$coo, $o_prod[$i])
												->SetCellValue('P'.$coo, $p_resn_remr[$i])
												->SetCellValue('Q'.$coo, $q_mat_req_dt[$i])
												->SetCellValue('R'.$coo, $r_qty[$i])
												->SetCellValue('S'.$coo, $s_req_status[$i])
												->SetCellValue('T'.$coo, $t_inv_no[$i])
												->SetCellValue('U'.$coo, $u_inv_dt[$i])
												
												->SetCellValue('V'.$coo, $v_fdisp_status[$i])
												->SetCellValue('W'.$coo, $w_fdisp_dt[$i])
												->SetCellValue('X'.$coo, $x_ftrans[$i])
												->SetCellValue('Y'.$coo, $y_fdoct[$i])
												
												->SetCellValue('Z'.$coo, $z_tdisp_status[$i])
												->SetCellValue('AA'.$coo, $aa_tdisp_dt[$i])
												->SetCellValue('AB'.$coo, $ab_ttrans[$i])
												->SetCellValue('AC'.$coo, $ac_tdoct[$i])
												
												->SetCellValue('AD'.$coo, $e_ad[$i])
												->SetCellValue('AE'.$coo, $e_ae[$i])
												->SetCellValue('AF'.$coo, $e_af[$i])
												->SetCellValue('AG'.$coo, $e_ag[$i])
												->SetCellValue('AH'.$coo, $e_ah[$i])
												->SetCellValue('AI'.$coo, $e_ai[$i])
												->SetCellValue('AJ'.$coo, $e_aj[$i])
												->SetCellValue('AK'.$coo, $e_ak[$i]);
											$i++;
									} $sh_index++;
								}else{$sheet->SetCellValue('A1', 'No Records Found');$no_rec++;}
							}
		//With Cell Serial number
								else if($datetype=='2'){
									$objPHPExcel->setActiveSheetIndex($sh_index);
									$sheet = $objPHPExcel->getActiveSheet();
									$sheet->setTitle('With Cell Serial number');
									$colArr=array('SJO Number','Requested TT Number','New Cells Serial Number Of Requested TT','New Cell Capacity','Outward TT Number','New Cells Serial Number Of Outward TT','Faulty CellSerial Number','Replaced Cell Serial Number','Faulty Cells Recieved By Factory Serial Number','Scrap Inward Reference');
									if(!empty($date_head))array_push($colArr,$date_head);
									$last_key = end(array_keys($colArr));
									$last_alpha = num2alpha($last_key);
									$sheet->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
									$sheet->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
									$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',$colrefValue); $ch++; }
									if(!empty($date_head)){$sheet->getStyle('K')->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension('K')->setAutoSize(true);}
									$get_dat=($re_dates=='1' ? 'date_of_request' : ($re_dates=='2' ? 'sjo_date' : ($re_dates=='3' ? 'sales_invoice_date' : '')));
									$b=mysqli_query($mr_con,"SELECT jm1.ticket_alias,jm1.sjo_number,jm1.mrf_alias,jm2.item_description ".(!empty($get_dat) ? ",jm1.".$get_dat : '')." FROM ec_material_request jm1 INNER JOIN ec_request_items jm2 ON jm1.mrf_alias=jm2.mrf_alias WHERE jm1.sjo_number<>'0' AND jm1.ticket_alias<>'0' AND jm2.flag=0 AND jm1.flag=0 AND $dondition jm2.item_type='1'");
									if(mysqli_num_rows($b)){$i=0;$coo=1;$temp=$temp_tt=array();
										$sql_s=mysqli_query($mr_con,"SELECT COUNT(id) AS cnt, GROUP_CONCAT('''',cell_alias,'''') AS scr_cells FROM ec_total_cell WHERE condition_id='3' AND location='$fct_wh' AND flag='0'");
										$row_s=mysqli_fetch_array($sql_s);
										$scr_cells=($row_s['cnt']>'0' ? $row_s['scr_cells'] : "''");
										while($bb=mysqli_fetch_array($b)){
											$mrfalias[$i]=$bb['mrf_alias'];
											$a_sjo_num[$i]=$bb['sjo_number'];
											$ticketalias[$i]=$bb['ticket_alias'];
											if($ticketalias[$i]!="2609" && !empty($ticketalias[$i]))$req_ticket[$i]=strtok(alias($ticketalias[$i],'ec_tickets','ticket_alias','ticket_id'),"|");else $req_ticket[$i]="BUFFER";
											if(!empty($get_dat))$k_re_date[$i]=php_excel_date($bb[$get_dat]);
											/*
											//C, G
											$c_new_req_tt=$d_cell_cap=$e_out_tt=$f_new_out_tt=$g_fault_cell=$h_repla_cell=array();
											$sql2=mysqli_query($mr_con,"SELECT COUNT(id) AS inum,GROUP_CONCAT(DISTINCT item_code) AS item_cod,GROUP_CONCAT(item_code_alias) AS item_cod_ali, GROUP_CONCAT(item_description) AS item_des FROM ec_item_code WHERE sjo_no ='".$mrfalias[$i]."' AND invoice_no<>'NA' AND item_type='1' AND flag='0'");
											$row2=mysqli_fetch_array($sql2);
											if($row2['inum']>'0'){
												//C -> New Cells Serial Number Of Requested TT
												$c_new_req_tt=explode(",",$row2['item_des']);
												$c_new_code=explode(",",$row2['item_cod_ali']);
												
												//G -> Cell Capacity
												foreach(explode(",",$row2['item_cod']) as $it){
													if(!array_key_exists($it,$temp))$temp[$it]=alias($it,'ec_product','product_alias','battery_rating');
													$d_cell_cap[]=$temp[$it];
												}
												//D, E, F and H
												$sql=mysqli_query($mr_con,"SELECT GROUP_CONCAT(DISTINCT t2.item_description) AS itm_cod, GROUP_CONCAT(DISTINCT t1.ref_no) AS out_ali FROM ec_material_outward t1 INNER JOIN ec_material_sent_details t2 ON t1.alias=t2.reference WHERE t2.item_description IN ('".implode("','",$c_new_code)."') AND t2.item_type='1' AND t1.from_type='1' AND t1.flag='0' GROUP BY t2.reference");
												if(mysqli_num_rows($sql)){
													while($row=mysqli_fetch_array($sql)){

														//E -> New Cells Serial Number Of Outward TT
														$rty=explode(",",$row['itm_cod']);
														foreach($rty as $tyu)$f_new_out_tt[]=$c_new_req_tt[end(array_keys($c_new_code,$tyu))];
														
														$c_nt=count($rty);
														if($row['out_ali']!="2609"){
															
															//D -> Outward TT Number
															$d_out_t=alias($row['out_ali'],'ec_tickets','ticket_alias','ticket_id');
															for($kk=1;$kk<=$c_nt;$kk++)$e_out_tt[]=$d_out_t;
															//F -> Faulty CellSerial Number
															$g_fault_cell[]=alias($row['out_ali'],'ec_fsr_faulty_cells','ticket_alias','cell_sl_no');
															
															//H -> Replaced Cell Serial Number
															$h_repla_cell=explode(",",str_replace(" ","",alias($row['out_ali'],'ec_engineer_observation','ticket_alias','replaced_cell_no')));
															
														}else {for($kk=1;$kk<=$c_nt;$kk++)$e_out_tt[]="BUFFER";}
													}
												}
											}
											*/
											
											$c_new_req_tt=$d_cell_cap=$e_out_tt=$f_new_out_tt=$g_fault_cell=$h_repla_cell=$i_fault_send_fact=$j_scr_inv=array();
											$sql2=mysqli_query($mr_con,"SELECT COUNT(id) AS inum,GROUP_CONCAT(item_code) AS item_cod,GROUP_CONCAT(item_code_alias) AS item_cod_ali, GROUP_CONCAT(item_description) AS item_des FROM ec_item_code WHERE sjo_no ='".$mrfalias[$i]."' AND invoice_no<>'NA' AND item_type='1' AND flag='0'");
											$row2=mysqli_fetch_array($sql2);
											if($row2['inum']>'0'){
												//C -> New Cells Serial Number Of Requested TT
												$c_new_req_tt=explode(",",$row2['item_des']);
												$c_new_code=explode(",",$row2['item_cod_ali']);
												$prod_ali=explode(",",$row2['item_cod']);
												$desc_key=array_combine($c_new_code,$c_new_req_tt);

												foreach($c_new_code as $kk=>$itm_ali){
													//D -> Cell Capacity
													$it=$prod_ali[$kk];
													if(!array_key_exists($it,$temp))$temp[$it]=alias($it,'ec_product','product_alias','battery_rating');
													$d_cell_cap[]=$temp[$it];

													//E, F, G and H
													$sql=mysqli_query($mr_con,"SELECT t2.item_description AS itm_cod, t1.ref_no AS out_ali FROM ec_material_outward t1 INNER JOIN ec_material_sent_details t2 ON t1.alias=t2.reference WHERE t2.item_description='$itm_ali' AND t2.item_type='1' AND t1.from_type='1' AND t1.flag='0' AND t2.flag='0'");
													if(mysqli_num_rows($sql)){
														while($row=mysqli_fetch_array($sql)){
															$out_key=$row['itm_cod'];
															//F -> New Cells Serial Number Of Outward TT
															$f_new_out_tt[]=$desc_key[$out_key];
															$tt_ali=$row['out_ali'];
															if($tt_ali!="2609"){
																//E -> Outward TT Number
																if(!array_key_exists($tt_ali,$temp_tt)){
																	$temp_tt[$tt_ali]=alias($tt_ali,'ec_tickets','ticket_alias','ticket_id');
																	$limit_tt[$tt_ali]=0;
																}else {$limit_tt[$tt_ali]=$limit_tt[$tt_ali]+1;}
																$e_out_tt[]=$temp_tt[$tt_ali];
																
																//G -> Faulty CellSerial Number
																$sql_f=mysqli_query($mr_con,"SELECT cell_sl_no FROM ec_fsr_faulty_cells WHERE ticket_alias ='$tt_ali' AND flag='0' LIMIT $limit_tt[$tt_ali],1");
																if(mysqli_num_rows($sql_f)){
																	$row_f=mysqli_fetch_array($sql_f);
																	$g_fault_cell[]=$row_f['cell_sl_no'];
																}else{$g_fault_cell[]='-';}
																
																//H -> Replaced Cell Serial Number
																if($limit_tt[$tt_ali]==0){
																	$repl_cel=explode(",",str_replace(" ","",alias($tt_ali,'ec_engineer_observation','ticket_alias','replaced_cell_no')));
																}$rep_emp=$repl_cel[$limit_tt[$tt_ali]];
																$h_repla_cell[]=(!empty($rep_emp) ? $rep_emp : '-');
															}else {$e_out_tt[]="BUFFER";$g_fault_cell[]=$h_repla_cell[]='-';}
														}
													}else {$f_new_out_tt[]=$e_out_tt[]=$g_fault_cell[]=$h_repla_cell[]='-';}
												}
											}

											//I and J
											$sql3=mysqli_query($mr_con,"SELECT COUNT(id) AS idesc, GROUP_CONCAT(item_code_alias) AS item_co, GROUP_CONCAT(item_description) AS item_des FROM ec_item_code WHERE sjo_no ='".$mrfalias[$i]."' AND item_code_alias IN (".$scr_cells.") AND item_type='1' AND flag='0'");
											$row3=mysqli_fetch_array($sql3);
											if($row3['idesc']>'0'){
												$i_desc=explode(",",$row3['item_des']);
												$i_code=explode(",",$row3['item_co']);
												$desc_key1=array_combine($i_code,$i_desc);
												$sql4=mysqli_query($mr_con,"SELECT COUNT(t2.id) AS inum,GROUP_CONCAT(t2.item_description) AS in_desc,t1.trans_id AS in_ali,t1.dispatch_date AS in_date FROM ec_material_inward t1 INNER JOIN ec_material_received_details t2 ON t1.alias=t2.reference WHERE t2.item_description IN ('".implode("','",$i_code)."') AND t2.item_type='1' AND t1.from_type='4' AND t1.flag='0' AND t2.flag='0' GROUP BY t1.trans_id");
												if(mysqli_num_rows($sql4)){
													while($row4=mysqli_fetch_array($sql4)){
														foreach(explode(",",$row4['in_desc']) as $rty){
															//I -> Faulty Cells recieved by Factory Serial Number.
															$i_fault_send_fact[]=$desc_key1[$rty];
															//J -> Scrap Inward Reference.
															$j_scr_inv[]=$row4['in_ali'];
															//K -> Scrap Inward Date.
															$k_re_date[]=php_excel_date($row4['in_date']);
														}
													}
												}
											}
											$c1=count($c_new_req_tt);$d1=count($d_cell_cap);$e1=count($e_out_tt);$f1=count($f_new_out_tt);$g1=count($g_fault_cell);$h1=count($h_repla_cell);$i1=count($i_fault_send_fact);$j1=count($j_scr_inv);$k1=count($k_re_date);
											$high_count= max($c1, $d1, $e1, $f1, $g1, $h1, $i1, $j1, $k1);
											for($x=0;$x<$high_count;$x++){ $coo++;
												$sheet->SetCellValue('A'.$coo, $a_sjo_num[$i])
														->SetCellValue('B'.$coo, $req_ticket[$i])
														->setCellValueExplicit('C'.$coo, (!empty($c_new_req_tt[$x]) ? $c_new_req_tt[$x] : '-'),PHPExcel_Cell_DataType::TYPE_STRING)
														->setCellValue('D'.$coo, (!empty($d_cell_cap[$x]) ?  $d_cell_cap[$x] : '-'))
														->setCellValue('E'.$coo, (!empty($e_out_tt[$x]) ? $e_out_tt[$x] : '-'))
														->setCellValueExplicit('F'.$coo, (!empty($f_new_out_tt[$x]) ?  $f_new_out_tt[$x] : '-'),PHPExcel_Cell_DataType::TYPE_STRING)
														->setCellValueExplicit('G'.$coo, (!empty($g_fault_cell[$x]) ?  $g_fault_cell[$x] : '-'),PHPExcel_Cell_DataType::TYPE_STRING)
														->setCellValueExplicit('H'.$coo, (!empty($h_repla_cell[$x]) ?  $h_repla_cell[$x] : '-'),PHPExcel_Cell_DataType::TYPE_STRING)
														->setCellValueExplicit('I'.$coo, (!empty($i_fault_send_fact[$x]) ?  $i_fault_send_fact[$x] : '-'),PHPExcel_Cell_DataType::TYPE_STRING)
														->setCellValue('J'.$coo, (!empty($j_scr_inv[$x]) ? $j_scr_inv[$x] : '-'));
							if(!empty($date_head))$sheet->SetCellValue('K'.$coo, $k_re_date[empty($get_dat) ? $x : $i]);
											}
										}$sh_index++;
									}else{$sheet->SetCellValue('A1', 'No Records Found');$no_rec++;}
								}elseif($datetype=='3'){
									$objPHPExcel->setActiveSheetIndex($sh_index);
									$sheet = $objPHPExcel->getActiveSheet();
									$sheet->setTitle('Non SJO');
									$colArr=array('Transaction ID','Zone Name','From Wh','Item Code','Cell Serial No');
									$out_con=$date_head="";
									if($re_dates=='1'){
										if($fromDate!='0')$out_con.="t1.date_of_trans>='".$fromDate."' AND ";
										if($toDate!='0')$out_con.="t1.date_of_trans<='".$toDate."' AND ";
									}elseif($re_dates=='4'){
										if($fromDate!='0')$out_con.="t1.dispatch_date>='".$fromDate."' AND ";
										if($toDate!='0')$out_con.="t1.dispatch_date<='".$toDate."' AND ";
									}
									if(isset($_REQUEST['zone_alias']) && count(array_filter($_REQUEST['zone_alias'])))$zone="'".implode("','",$_REQUEST['zone_alias'])."'";else $zone='0';
									if(isset($_REQUEST['wh_alias']) && count(array_filter($_REQUEST['wh_alias'])))$wh="'".implode("','",$_REQUEST['wh_alias'])."'";else $wh='0';
									if($zone=='0' && $wh=='0')$wh=getempwarehouse($emp_alias);
									elseif($zone!='0'){
										if($wh=='0'){
											$a=mysqli_query($mr_con,"SELECT COUNT(id) AS num,GROUP_CONCAT('''',wh_alias,'''') AS alias FROM ec_warehouse WHERE zone_alias IN ($zone) AND flag='0'");
											$aa=mysqli_fetch_array($a);
											if($aa['num']){ $wh=$aa['alias'];}
											else{ $wh=getempwarehouse($emp_alias); }
										}
									}else $wh=($wh!='0' ? $wh : getempwarehouse($emp_alias));
									if(!empty($wh))$out_con.="t1.to_wh IN($wh) AND ";
									if(isset($_REQUEST['product_alias']) && count(array_filter($_REQUEST['product_alias'])))$out_con.="t2.item_code IN('".implode("','",$_REQUEST['product_alias'])."') AND ";
									$non_sql=mysqli_query($mr_con,"SELECT t1.from_wh,t1.trans_id,t2.item_code,t2.item_description FROM ec_material_outward t1 INNER JOIN ec_material_sent_details t2 ON t1.alias=t2.reference WHERE t1.to_wh='XVX6AZ4VHT' AND t1.sjo_number IN('','0') AND t1.status='6' AND t1.from_type='2' AND t2.item_type='1' AND $out_con t1.flag='0' AND t2.flag='0'");
									if(mysqli_num_rows($non_sql)){
										$last_key = end(array_keys($colArr));
										$last_alpha = num2alpha($last_key);
										$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
										$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
										$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue)); $ch++; }
										$date_arr = array("F","G");
										foreach($date_arr as $da){$sheet->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension($da)->setAutoSize(true);}
										$coo=1;
										while($row=mysqli_fetch_array($non_sql)){ $coo++;
											$sheet->SetCellValue('A'.$coo, $row['trans_id'])
												->SetCellValue('B'.$coo, alias(alias($row['from_wh'],'ec_warehouse','wh_alias','zone_alias'),'ec_zone','zone_alias','zone_name'))
												->SetCellValue('C'.$coo, alias($row['from_wh'],'ec_warehouse','wh_alias','wh_code'))
												->SetCellValue('D'.$coo, alias($row['item_code'],'ec_product','product_alias','product_description'))
												->setCellValueExplicit('E'.$coo, alias($row['item_description'],'ec_item_code','item_code_alias','item_description'),PHPExcel_Cell_DataType::TYPE_STRING);
										}$sh_index++;
									}else{$sheet->SetCellValue('A1', 'No Records Found');$no_rec++;}
								}
						}else{$resCode='4';$resMsg='Select Data Type to export Details';}
					}else{$no_rec++;}
	//ACCESSORIES				
					if(in_array('2',$item_type)){
						$bc=mysqli_query($mr_con,"SELECT jm1.from_wh, jm1.date_of_request, jm1.sjo_number, jm1.sjo_date, jm1.ticket_alias, jm1.sales_invoice_no, jm1.sales_invoice_date, jm1.sales_po_no, jm1.contact_person, jm1.customer_address, jm1.customer_phone, jm1.mrf_alias,jm1.status,jm2.item_description, jm2.quantity FROM ec_material_request jm1 INNER JOIN ec_request_items jm2 ON jm1.mrf_alias=jm2.mrf_alias WHERE jm1.sjo_number<>'0' AND jm1.ticket_alias<>'0' AND jm2.item_type='2' AND $dondition jm1.flag='0' AND jm1.flag='0'");
						if(mysqli_num_rows($bc)){
							if($sh_index>0)$objPHPExcel->createSheet();
							$objPHPExcel->setActiveSheetIndex($sh_index);
							$sheet = $objPHPExcel->getActiveSheet();
							$sheet->setTitle('Accessories');
							$colArr=array('FY Year','Zone','State','Accessory Description','SJO Number','SJO Date','Customer Name','Site Names','TT Number','Sales Invoice Number','Sales Invoice Date','Sales PO Number','Customer Address','Customer Contact Person','Customer Contact No','Reason/Remarks','Requested Date','Requested QTY','Status','Invoice /GRN Number','Invoice Date','Dispatched Status(SCM)','Dispached Date(SCM)','Transporter Details(SCM)','Docket Number(SCM)','Dispatched Quantity from Factory to Field','Good Accessories Quantity','Damaged Accessories Quantity','Lost Accessories Quantity','SJO VS Dispatch Balance');
							$last_key = end(array_keys($colArr));
							$last_alpha = num2alpha($last_key);
							$ch = 'A'; foreach($colArr as $colrefValue){ $sheet->SetCellValue($ch.'1',ucfirst($colrefValue)); $ch++; }
							$sheet->getStyle('A1:'.$last_alpha.'1')->applyFromArray($styleArray);
							$sheet->getStyle('A1:'.$last_alpha.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));	
							$date_arr = array("F","K","Q");
							foreach($date_arr as $da){$sheet->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension($da)->setAutoSize(true);}
							$i=0;$coo=1;
							while($bb=mysqli_fetch_array($bc)){$coo++;
								$ticketalias[$i]=$bb['ticket_alias'];
								$mrfalias[$i]=$bb['mrf_alias'];
								$productalias[$i]=$bb['item_description'];
								if($ticketalias[$i]!="2609" && !empty($ticketalias[$i])){
									$site_temp[$i]=alias($ticketalias[$i],'ec_tickets','ticket_alias','site_alias');
									$cust_name[$i]=alias(alias($site_temp[$i],'ec_sitemaster','site_alias','customer_alias'),'ec_customer','customer_alias','customer_name');
									$site_name[$i]=alias($site_temp[$i],'ec_sitemaster','site_alias','site_name');
									$ticket_id[$i]=strtok(alias($ticketalias[$i],'ec_tickets','ticket_alias','ticket_id'),"|");
								}else{ $cust_name[$i]=$site_name[$i]="-";$ticket_id[$i]="BUFFER";}
								
								$a_fina_yr[$i]=financial_year($bb['date_of_request']);
								$b_zone[$i]=alias(alias($bb['from_wh'],'ec_warehouse','wh_alias','zone_alias'),'ec_zone','zone_alias','zone_name');
								$c_wh[$i]=alias($bb['from_wh'],'ec_warehouse','wh_alias','wh_code');
								$d_acc_desc[$i]=alias($bb['item_description'],'ec_accessories','accessories_alias','accessory_description');
								$e_sjo_no[$i]=$bb['sjo_number'];
								$f_sjo_dt[$i]=php_excel_date($bb['sjo_date']);
								$g_cust_name[$i]=$cust_name[$i];
								$h_site_name[$i]=$site_name[$i];
								$i_tt_id[$i]=$ticket_id[$i];
								$j_sal_inv_no[$i]=$bb['sales_invoice_no'];
								$k_sal_inv_dt[$i]=php_excel_date($bb['sales_invoice_date']);
								$l_sal_po_no[$i]=$bb['sales_po_no'];
								$m_cust_addr[$i]=$bb['customer_address'];
								$n_cust_con_per[$i]=$bb['contact_person'];
								$o_cust_con_pho[$i]=$bb['customer_phone'];
								$p_resn_remr[$i]=getoneremark($mrfalias[$i],'MR');
								$q_mat_req_dt[$i]=php_excel_date($bb['date_of_request']);
								$r_qty[$i]=$bb['quantity'];
								$s_req_status[$i]=fam_lvl_nm_clr($bb['status'],"name",$bb['mrf_alias']);
								
								$gdl=acc_countings($fct_wh,$productalias[$i],$mrfalias[$i]);
								if(count(array_diff($gdl,array('0','0','0','-','-','-','-','-')))>'0'){
									list($good,$damaged,$lost,$in_no,$in_dt,$dispdt,$trans,$doct)=$gdl;
									$t_inv_no[$i]=$in_no;
									if(strpos($in_dt,"|")!==false)$u_inv_dt[$i]=$in_dt;else{$sheet->getStyle("U".$coo)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$u_inv_dt[$i]=php_excel_date($in_dt);}
									$v_fdisp_status[$i]="Dispatched";
									if(strpos($dispdt,"|")!==false)$w_fdisp_dt[$i]=$dispdt;else{$sheet->getStyle("W".$coo)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$w_fdisp_dt[$i]=php_excel_date($dispdt);}
									$x_ftrans[$i]=$trans;
									$y_fdoct[$i]=$doct;
								}else{$t_inv_no[$i]=$u_inv_dt[$i]=$v_fdisp_status[$i]=$w_fdisp_dt[$i]=$x_ftrans[$i]=$y_fdoct[$i]="-";$good=$damaged=$lost='0';}
								
								/*$inv_sql=mysqli_query($mr_con,"SELECT GROUP_CONCAT(invoice_no SEPARATOR ' | ') AS in_no,GROUP_CONCAT(invoice_date SEPARATOR ' | ') AS in_dt FROM ec_item_code WHERE sjo_no='".$mrfalias[$i]."' AND sjo_no<>'' AND sjo_no<>'0' AND invoice_no<>'' AND invoice_no<>'0' AND item_code='".$productalias[$i]."' AND item_type='2' AND flag='0' GROUP BY invoice_no");
								if(mysqli_num_rows($inv_sql)>'0'){
									$inv_row=mysqli_fetch_array($inv_sql);
									$t_inv_no[$i]=$inv_row['in_no'];
									if(strpos($inv_row['in_dt'],"|")!==false)$u_inv_dt[$i]=$inv_row['in_dt'];else{$sheet->getStyle("U".($i+2))->getNumberFormat()->setFormatCode('mm/dd/yyyy');$u_inv_dt[$i]=php_excel_date($inv_row['in_dt']);}
								}else{$t_inv_no[$i]='-';$u_inv_dt[$i]='-';}
					
								$b3=mysqli_query($mr_con,"SELECT GROUP_CONCAT(dispatch_date SEPARATOR ' | ') AS dispdt,GROUP_CONCAT(transport SEPARATOR ' | ') AS trans,GROUP_CONCAT(docket SEPARATOR ' | ') AS doct FROM ec_material_outward WHERE sjo_number='".$mrfalias[$i]."' AND from_wh='$fct_wh' AND flag='0' GROUP BY dispatch_date");
								if(mysqli_num_rows($b3)>'0'){
									$bb3=mysqli_fetch_array($b3);
									$v_fdisp_status[$i]="Dispatched";
									if(strpos($bb3['dispdt'],"|")!==false)$w_fdisp_dt[$i]=$bb3['dispdt'];else{$sheet->getStyle("W".($i+2))->getNumberFormat()->setFormatCode('mm/dd/yyyy');$w_fdisp_dt[$i]=php_excel_date($bb3['dispdt']);}
									$x_ftrans[$i]=$bb3['trans'];
									$y_fdoct[$i]=$bb3['doct'];
								}else{$v_fdisp_status[$i]="-";$w_fdisp_dt[$i]="-";$x_ftrans[$i]="-";$y_fdoct[$i]="-";}
								
								if(!empty($gdl))list($good,$damaged,$lost)=explode($gdl);else $good=$damaged=$lost='0';*/
								
								$z_disp[$i]=($good+$damaged+$lost);
								$aa_gd[$i]=$good;
								$ab_da[$i]=$damaged;
								$ac_la[$i]=$lost;
								$ad_sj[$i]=$r_qty[$i]-$z_disp[$i];
								
								$sheet->SetCellValue('A'.$coo, $a_fina_yr[$i])
										->SetCellValue('B'.$coo, $b_zone[$i])
										->SetCellValue('C'.$coo, $c_wh[$i])
										->SetCellValue('D'.$coo, $d_acc_desc[$i])
										->SetCellValue('E'.$coo, $e_sjo_no[$i])
										->SetCellValue('F'.$coo, $f_sjo_dt[$i])
										->SetCellValue('G'.$coo, $g_cust_name[$i])
										->SetCellValue('H'.$coo, $h_site_name[$i])
										->SetCellValue('I'.$coo, $i_tt_id[$i])
										->SetCellValue('J'.$coo, $j_sal_inv_no[$i])
										->SetCellValue('K'.$coo, $k_sal_inv_dt[$i])
										->SetCellValue('L'.$coo, $l_sal_po_no[$i])
										->SetCellValue('M'.$coo, $m_cust_addr[$i])
										->SetCellValue('N'.$coo, $n_cust_con_per[$i])
										->SetCellValue('O'.$coo, $o_cust_con_pho[$i])
										->SetCellValue('P'.$coo, $p_resn_remr[$i])
										->SetCellValue('Q'.$coo, $q_mat_req_dt[$i])
										->SetCellValue('R'.$coo, $r_qty[$i])
										->SetCellValue('S'.$coo, $s_req_status[$i])
										->SetCellValue('T'.$coo, $t_inv_no[$i])
										->SetCellValue('U'.$coo, $u_inv_dt[$i])
										->SetCellValue('V'.$coo, $v_fdisp_status[$i])
										->SetCellValue('W'.$coo, $w_fdisp_dt[$i])
										->SetCellValue('X'.$coo, $x_ftrans[$i])
										->SetCellValue('Y'.$coo, $y_fdoct[$i])
										->SetCellValue('Z'.$coo, $z_disp[$i])
										->SetCellValue('AA'.$coo, $aa_gd[$i])
										->SetCellValue('AB'.$coo, $ab_da[$i])
										->SetCellValue('AC'.$coo, $ac_la[$i])
										->SetCellValue('AD'.$coo, $ad_sj[$i]);
									$i++;
							}
						}else{$sheet->SetCellValue('A1', 'No Records Found');$no_rec++;}
					}else{$no_rec++;}
					if($no_rec!=2){
						$filename = 'SJO_Balance_'.date('d-m-Y H_i_s');
						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
						$objWriter->save("../../exports/$filename.xlsx");
						$result['file_name']=$filename;
						$resCode='0'; $resMsg='export';
					}else{$resCode='4';$resMsg="No Records Found To Run Report";}
				}else{$resCode='4';$resMsg="No Records Found To Run Report";}
				//}else{$resCode='4';$resMsg="Select Data Filter";}
			}
		}else{$resCode='4';$resMsg="Select Item Type to export Details";}
	}elseif($chk=='1'){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function getoneremark($fv1,$fv2){global $mr_con;
	$rb=mysqli_query($mr_con,"SELECT remarks FROM ec_remarks WHERE module='$fv2' AND item_alias='$fv1' AND flag='0'");
	if(mysqli_num_rows($rb)){
		$rbb=mysqli_fetch_array($rb);
		return $rbb['remarks'];
	}else return '-';
}
/*function acc_count_from_factory($item_code,$mrf_alias){global $mr_con;
	$fct_wh=alias('1','ec_warehouse','wh_type','wh_alias');
	$sql=mysqli_query($mr_con,"SELECT COUNT(id) AS num,GROUP_CONCAT('''',alias,'''') AS tddf FROM ec_material_outward WHERE sjo_number='$mrf_alias' AND from_wh='$fct_wh' AND from_type='3' AND flag='0'");
	$row=mysqli_fetch_array($sql);
	if($row['num']>'0'){
		$sql1=mysqli_query($mr_con,"SELECT id FROM ec_material_sent_details WHERE reference IN (".$row['tddf'].") AND item_code='$item_code' AND item_type='2' AND flag='0'");
		if(mysqli_num_rows($sql1)>'0'){
			$sql2=mysqli_query($mr_con,"SELECT COUNT(id) AS numn,GROUP_CONCAT('''',item_code_alias,'''') AS itemdf FROM ec_item_code WHERE sjo_no='$mrf_alias' AND item_code='$item_code' AND item_type='2' AND flag='0'");
			$row2=mysqli_fetch_array($sql2);
			if($row2['numn']>'0'){
				$sql3=mysqli_query($mr_con,"SELECT COUNT(id) AS numnu,SUM(good_qty) AS good,SUM(damaged_qty) AS damaged,SUM(lost_qty) AS lost FROM ec_total_accessories WHERE acc_alias IN (".$row2['itemdf'].") AND item_code='$item_code' AND flag='0'");
				$row3=mysqli_fetch_array($sql3);
				if($row3['numnu']>'0')return $row3['good'].",".$row3['damaged'].",".$row3['lost'];else return '0';
			}else return '0';
		}else return '0';
	}else return '0';
}*/
function acc_countings($fct_wh,$item_code,$mrf_alias){global $mr_con; $result=array('0','0','0','-','-','-','-','-');
	//$sq=mysqli_query($mr_con,"SET GLOBAL group_concat_max_len = 1000000");
	$sql=mysqli_query($mr_con,"SELECT COUNT(id) AS num,GROUP_CONCAT('''',alias,'''') AS tddf,GROUP_CONCAT(dispatch_date SEPARATOR ' | ') AS dispdt,GROUP_CONCAT(transport SEPARATOR ' | ') AS trans,GROUP_CONCAT(docket SEPARATOR ' | ') AS doct FROM ec_material_outward WHERE sjo_number='$mrf_alias' AND from_wh='$fct_wh' AND from_type='3' AND flag='0'");
	$row=mysqli_fetch_array($sql);
	if($row['num']>'0'){ $result[5]=$row['dispdt'];$result[6]=$row['trans'];$result[7]=$row['doct'];
		$sql1=mysqli_query($mr_con,"SELECT id FROM ec_material_sent_details WHERE reference IN (".$row['tddf'].") AND item_code='$item_code' AND item_type='2' AND flag='0'");
		if(mysqli_num_rows($sql1)>'0'){
			$sql2=mysqli_query($mr_con,"SELECT COUNT(id) AS numn,GROUP_CONCAT('''',item_code_alias,'''') AS itemdf,GROUP_CONCAT(DISTINCT invoice_no SEPARATOR ' | ') AS in_no,GROUP_CONCAT(DISTINCT invoice_date SEPARATOR ' | ') AS in_dt FROM ec_item_code WHERE sjo_no='$mrf_alias' AND item_code='$item_code' AND item_type='2' AND flag='0'");
			$row2=mysqli_fetch_array($sql2);
			if($row2['numn']>'0'){$result[3]=$row2['in_no'];$result[4]=$row2['in_dt'];
				$sql3=mysqli_query($mr_con,"SELECT COUNT(id) AS numnu,SUM(good_qty) AS good,SUM(damaged_qty) AS damaged,SUM(lost_qty) AS lost FROM ec_total_accessories WHERE acc_alias IN (".$row2['itemdf'].") AND item_code='$item_code' AND flag='0'");
				$row3=mysqli_fetch_array($sql3);
				if($row3['numnu']>'0'){$result[0]=$row3['good'];$result[1]=$row3['damaged'];$result[2]=$row3['lost'];}
			}
		}
	}return $result;
}
function cells_countings($fct_wh,$item_code,$mrf_alias,$ref='3'){global $mr_con; $result=array('0','-','-','-');
	$rrr=($ref=='2' ? "to_wh":"from_wh");
	$sql=mysqli_query($mr_con,"SELECT COUNT(id) AS num,GROUP_CONCAT('''',alias,'''') AS tddf,GROUP_CONCAT(DISTINCT dispatch_date SEPARATOR ' | ') AS dispdt,GROUP_CONCAT(DISTINCT transport SEPARATOR ' | ') AS trans,GROUP_CONCAT(DISTINCT docket SEPARATOR ' | ') AS doct FROM ec_material_outward WHERE sjo_number='$mrf_alias' AND $rrr='$fct_wh' AND from_type='$ref' AND status='6' AND flag='0'");
	$row=mysqli_fetch_array($sql);
	if($row['num']>'0'){$result[1]=$row['dispdt'];$result[2]=$row['trans'];$result[3]=$row['doct'];
		$sql1=mysqli_query($mr_con,"SELECT COUNT(id) as scr ".($ref=='2' ? ",GROUP_CONCAT('''',item_description,'''') AS lost" : "")." FROM ec_material_sent_details WHERE reference IN (".$row['tddf'].") AND item_code='$item_code' AND item_type='1' AND flag='0'");
		$row1=mysqli_fetch_array($sql1);
		if($row1['scr']>'0')$result[0]=$row1['scr']-($ref=='2' ? mysqli_num_rows(mysqli_query($mr_con,"SELECT t2.id FROM ec_material_inward t1 INNER JOIN ec_material_received_details t2 ON t1.alias=t2.reference WHERE t1.from_type='4' AND t2.item_condition='7' AND t2.item_description IN(".$row1['lost'].") AND t2.item_code='$item_code' AND t1.sjo_number='' AND t2.item_type='1' AND t1.flag='0'")) : 0);else $result[0]='0';
	}return $result;
}
function lost_countings($item_code,$mrfalias){ global $mr_con;
	//return mysqli_num_rows(mysqli_query($mr_con,"SELECT t2.id FROM ec_material_inward t1 INNER JOIN ec_material_received_details t2 ON t1.alias=t2.reference WHERE t1.from_type!='4' AND t2.item_condition='7' AND t2.item_code='$item_code' AND t1.sjo_number='$mrfalias' AND t2.item_type='1' AND t1.flag='0'"));
	$out_lost = mysqli_fetch_array(mysqli_query($mr_con,"SELECT GROUP_CONCAT('''',t2.item_description,'''') AS lost_out FROM ec_material_outward t1 INNER JOIN ec_material_sent_details t2 ON t1.alias=t2.reference WHERE t1.from_type='2' AND t2.item_condition IN ('3','4') AND t2.item_code='$item_code' AND t1.sjo_number='$mrfalias' AND t2.item_type='1' AND t1.flag='0'"));
	$tlt_lost = mysqli_fetch_array(mysqli_query($mr_con,"SELECT COUNT(CASE WHEN t1.from_type!='4' && t1.sjo_number='$mrfalias' THEN t2.id END) ".(empty($out_lost['lost_out']) ? "" : "+ COUNT(CASE WHEN t1.from_type='4' && t1.sjo_number='' && t2.item_description IN(".$out_lost['lost_out'].") THEN t2.id END)")." AS lost_cont FROM ec_material_inward t1 INNER JOIN ec_material_received_details t2 ON t1.alias=t2.reference WHERE t2.item_condition='7' AND t2.item_code='$item_code' AND t2.item_type='1' AND t1.flag='0'"));
	return (empty($tlt_lost['lost_cont']) ? 0 : $tlt_lost['lost_cont']);
}
function outstanding_count($fct_wh,$item_code,$mrf_alias){global $mr_con;
	foreach(array("from_wh"=>"to_wh","to_wh"=>"from_wh") as $from=>$to){
		$b3=mysqli_query($mr_con,"SELECT COUNT(id) AS num,GROUP_CONCAT('''',alias,'''') AS tddf FROM ec_material_outward WHERE sjo_number='$mrf_alias' AND $from='XVX6AZ4VHT' AND $to='$fct_wh' AND flag='0'");
		$bb3=mysqli_fetch_array($b3);
		if($bb3['num']>'0')$acd[]=$bb3['tddf'];else $acd[]="''";
	}
	list($a,$b)=$acd;
	$b3=mysqli_query($mr_con,"SELECT COUNT(CASE WHEN reference IN ($a) THEN id END) - COUNT(CASE WHEN reference IN ($b) THEN id END) AS outstanding FROM ec_material_sent_details WHERE item_code='$item_code' AND item_type='1' AND flag='0'");
	$bb3=mysqli_fetch_array($b3);
	return $bb3['outstanding'];
}
function faulty_cells_counting($item_code,$mrf_alias,$ticket_alias){global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT COUNT(id) AS num,GROUP_CONCAT('''',alias,'''') AS tddf FROM ec_material_inward WHERE (ref_no='$ticket_alias' OR sjo_number='$mrf_alias') AND from_type IN ('1','2') AND flag='0'");
	$row=mysqli_fetch_array($sql);
	if($row['num']>'0'){
		$sql1=mysqli_query($mr_con,"SELECT COUNT(id) as scr FROM ec_material_received_details WHERE reference IN (".$row['tddf'].") AND item_code='$item_code' AND item_type='1' AND flag='0'");
		if(mysqli_num_rows($sql1)){
			$row1=mysqli_fetch_array($sql1);
			return $row1['scr'];
		}else return '0';
	}else return '0';
}
function replaced_cells_counting($item_code,$ticket_alias){global $mr_con;
	if($ticket_alias!='2609'){
		$replaced_cell_no=alias($ticket_alias,'ec_engineer_observation','ticket_alias','replaced_cell_no');
		if(!empty($replaced_cell_no) && $replaced_cell_no!='nil'){
			$sql=mysqli_query($mr_con,"SELECT COUNT(id) as iuyt FROM ec_item_code WHERE item_description IN ('".str_replace(", ","','",$replaced_cell_no)."') AND item_code='$fv1' AND item_type='1' AND flag='0'");
			if(mysqli_num_rows($sql)>'0'){
				$row=mysqli_fetch_array($sql);
				return $row['iuyt'];
			}else return '0';
		}else return '0';
	}else return '0';
}
/*function getoneremark($fv1,$fv2){global $mr_con;
	$rq2="SELECT remarks FROM ec_remarks WHERE module='".$fv2."' AND item_alias='".$fv1."'";
	$rb=mysqli_query($mr_con,$rq2);
	if(mysqli_num_rows($rb)){
		$rbb=mysqli_fetch_array($rb);
		return $rbb['remarks'];
	}else return '-';
}
function countsenting($fv1,$fv2,$fv3=0){global $mr_con;$acd=array();
	if($fv3=='0'){
		$q3="SELECT alias,dispatch_date,transport,docket FROM ec_material_outward WHERE sjo_number='".$fv2."' AND from_wh IN (SELECT wh_alias FROM ec_warehouse WHERE wh_type='1')";
		$b3=mysqli_query($mr_con,$q3);
		if(mysqli_num_rows($b3)>'0'){
			while($bb3=mysqli_fetch_array($b3))$acd[]=$bb3['alias'];
		}
	}elseif($fv3=='1'){
		$q3="SELECT alias,dispatch_date,transport,docket FROM ec_material_outward WHERE sjo_number='".$fv2."' AND to_wh IN (SELECT wh_alias FROM ec_warehouse WHERE wh_type='1')";
		$b3=mysqli_query($mr_con,$q3);
		if(mysqli_num_rows($b3)>'0'){
			while($bb3=mysqli_fetch_array($b3))$acd[]=$bb3['alias'];
		}
	}
	if(count($acd)>'0'){
		$fv4="'".implode("','",$acd)."'";
		$rq2="SELECT count(id) as scr FROM ec_material_sent_details WHERE reference IN ($fv4) AND item_code='".$fv1."' AND item_type='1'";
		$rb=mysqli_query($mr_con,$rq2);
		if(mysqli_num_rows($rb)){
		$rbb=mysqli_fetch_array($rb);
		return $rbb['scr'];
		}else return '0';
	}else return '0';
}
function countsenting_outstanding($fv1,$fv2){global $mr_con;
	$rq2="SELECT id FROM ec_material_sent_details WHERE reference IN (SELECT alias FROM ec_material_outward WHERE sjo_number='$fv2' AND from_wh IN(SELECT wh_alias FROM ec_warehouse WHERE wh_type='1')) AND item_code='$fv1' AND item_type='1'";
	$rb=mysqli_query($mr_con,$rq2);
	$co = mysqli_num_rows($rb);
	
	$rq3="SELECT id FROM ec_material_sent_details WHERE reference IN (SELECT alias FROM ec_material_outward WHERE sjo_number='$fv2' AND to_wh IN(SELECT wh_alias FROM ec_warehouse WHERE wh_type='1')) AND item_code='$fv1' AND item_type='1'";
	$rb1=mysqli_query($mr_con,$rq3);
	$co1 = mysqli_num_rows($rb1);
	return $co-$co1;
}
function faultycellcounting($fv1,$fv2){global $mr_con;
	$fv2=alias($fv2,'ec_material_inward','ref_no','alias');
	$rq2="SELECT count(id) as scr FROM ec_material_received_details WHERE reference='".$fv2."' AND item_code='".$fv1."' AND item_type='1'";
	$rb=mysqli_query($mr_con,$rq2);
	if(mysqli_num_rows($rb)){
	$rbb=mysqli_fetch_array($rb);
	return $rbb['scr'];
	}else return '0';

}
function replacecellscounting($fv1,$fv2){global $mr_con;$fv3=0;
	$fv3=alias($fv2,'ec_engineer_observation','ticket_alias','replaced_cell_no');
	if(!empty($fv3)){
		$fv3="'".str_replace(", ","','",$fv3)."'";
		$rq2="SELECT count(id) as iuyt FROM ec_item_code WHERE item_code_alias IN ($fv3) AND item_code='".$fv1."' AND item_type='1'";
		$rb=mysqli_query($mr_con,$rq2);
		if(mysqli_num_rows($rb)>'0'){
			$rbb=mysqli_fetch_array($rb);
			return $rbb['iuyt'];
		}else return '0';
	}else return 0;
}*/
function num2alpha($n){
    for($r="";$n>=0;$n=intval($n/26)-1)$r=chr($n%26 + 0x41).$r;
    return $r;
}
function material_inward_import(){ global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$rex=authentication($_REQUEST['emp_alias'],$_REQUEST['token']);
	if($rex==0){
		if(isset($_FILES["file"])){
			if($_FILES["file"]["error"]>0){$res = "No file selected";}
				else{ $extn = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
					if($extn=='xlsx' || $extn=='xls' ){
						set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
						$inputFileName = $_FILES["file"]["tmp_name"];
						try { $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);}
						catch(Exception $e){die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage()); }
						$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
						$arrayCount = count($allDataInSheet);
						for($i=2;$i<=$arrayCount;$i++){
							$b[($i-2)]=strtoupper(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["A"])));
							$c_a[($i-2)]=strtoupper(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["B"])));
							$con_arr[($i-2)] = strtoupper(mysqli_real_escape_string($mr_con,trim($allDataInSheet[$i]["C"])));
						}
						//$x=array_filter(array_unique($c_a));
						//$c = array_filter(array_diff_key($c_a,$x));
						//if(count($c)=='0'){
						$x=array_unique($c_a);
						$c=array_diff_key($c_a,$x);
						$counts = array_count_values($c);
						$tf = ((count($c)>'0' && count($c)==$counts["NA"]) ? TRUE : FALSE);
						if(count($c)=='0' || $tf){
							$typ_def=array('SCRAP CELL','TRANSIT DAMAGE','LOST CELL','FIELD REVIVAL','FIELD GOOD');
							$typ = array_values($con_arr);
							if(count(array_unique(array_merge($typ_def,$typ)))>'5'){
								$res = "Only 'SCRAP CELL', 'TRANSIT DAMAGE', 'FIELD REVIVAL' & 'LOST CELL' are allowed in Condition Column";
							}else{
								if($tf || in_array("NA",$x)){
									//unset($x);
									$x=$c_a;
									$sql_nv_max=mysqli_query($mr_con,"SELECT IFNULL(MAX(CAST(SUBSTRING_INDEX(item_description,'-',-1) AS SIGNED)),0) AS nv_max FROM ec_item_code WHERE item_description LIKE '%NOT VISIBLE-%' AND flag='0'");
									$row_nv_max=mysqli_fetch_array($sql_nv_max);
									$nv_max=$row_nv_max['nv_max'];
								}	
								//foreach($c as $k=>$a){unset($b[$k]);unset($con_arr[$k]);}
								$b_rat = array_values($b);
								$cell_ser_arr = array_values($x);
								$ccon = array_values($con_arr);
								$check=$che=$cell=$scr_con=$empty=array();
								for($j=0;$j<count($cell_ser_arr);$j++){
									$b_rating=$b_rat[$j];
									$cell_ser_num=$cell_ser_arr[$j];
									$condition = condition($ccon[$j]);
									if(!empty($b_rating) && !empty($cell_ser_num) && !empty($ccon[$j])){
										if($condition!='0'){
											if($cell_ser_num!="NA"){
												$num=mysqli_query($mr_con,"SELECT t1.id FROM ec_item_code t1 INNER JOIN ec_total_cell t2 ON t1.item_code_alias=t2.cell_alias WHERE t1.item_description='$cell_ser_num' AND t1.item_type='1' AND t2.condition_id IN('3','4','5','7') AND t2.site_stage='0'");
												$co=mysqli_num_rows($num);
											}else{$co='0';}
											if($co=='0'){
												$product_alias=alias($b_rating,'ec_product','product_description','product_alias');
												if(!empty($product_alias)){
													$check[]=$product_alias;
													$cond[]=$condition;
												}else{$che[]=$b_rating;}
											}else{ $cell[]=$cell_ser_num;}
										}else{ $scr_con[]=($j+2); }
									}else{ $empty[]=($j+2); }
								}
								if(!count($empty) && !count($scr_con)){
									if(!count($che) && !count($cell)){
										for($k=0,$z=1;$k<count($cell_ser_arr);$k++){
											$result['itemy'][$k]['product_dis']=$b_rat[$k];
											$result['itemy'][$k]['product_alias']=$check[$k];
											if($cell_ser_arr[$k]=="NA"){$y='NOT VISIBLE-'.($nv_max+$z);$z++;}else{$y=$cell_ser_arr[$k];}
											$result['itemy'][$k]['cellNumber']=$y;
											$result['itemy'][$k]['condition_dis']=$ccon[$k];
											$result['itemy'][$k]['condition_alias']=$cond[$k];
										}$resCode=0;$resMsg='Successfull';
									}else{$res = (count($che) ? "Wrong product entries : ".implode(", ",$che)."<br>" : "").(count($cell) ? "Already exists Cell Serial No. are in database : ".implode(", ",$cell) : "");}
								}else{$res = (count($empty) ? "Empty records exists. Empty rows no's are : ".implode(", ",$empty)."<br>" : "").(count($scr_con) ? "Scrap Condition exists. Scrap rows no's are : ".implode(", ",$scr_con) : "");}
							}
						}else{$res = implode(", ",$c)." are duplicate entries of cell serial numbers in excel";}
					}else{ $res = 'Invalid file...'; }
				}
			}else{ $res = "No file selected"; 
		}if(isset($res)){$resCode='4';$resMsg=$res;}
	}elseif($rex==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';
	}$result['ErrorDetails']['ErrorCode']=$resCode; $result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function request_items_bal_check($ref_no){ global $mr_con;
	$sql=mysqli_query($mr_con,"SELECT SUM(quantity) AS quantity_tot,SUM(quantity-left_quanty) AS sent_qty_tot FROM ec_request_items WHERE mrf_alias='$ref_no' AND flag='0'");
	if(mysqli_num_rows($sql)>0){
		$row = mysqli_fetch_array($sql);
		return ($row['quantity_tot']!="" && $row['sent_qty_tot']!="" && $row['quantity_tot']!=$row['sent_qty_tot'] ? FALSE : TRUE);
	}else{return FALSE;}
}
function condition($con){
	switch($con){
		//case 'CONDITION': return '0'; break;
		case 'NEW CELL': return '1'; break;
		case 'REVIVED NEW CELL': return '2'; break;
		case 'SCRAP CELL': return '3'; break;
		case 'TRANSIT DAMAGE': return '4'; break;
		case 'FIELD REVIVAL': return '5'; break;
		case 'UNDER REVIVAL CELLS': return '6'; break;
		case 'LOST CELL': return '7'; break;
		case 'FIELD GOOD': return '8'; break;
		default: return '3';
	}
}

function item_code_delete_check() {

	global $mr_con;
	$request = \Slim\Slim::getInstance()->request();
	$login = json_decode($request->getBody(),true);
	$emp_alias = $_REQUEST['emp_alias'];
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con, trim($emp_alias)));
	$rex = authentication($emp_alias, $_REQUEST['token']);
	$alias = $_REQUEST['alias'];
	$alias = strtoupper(mysqli_real_escape_string($mr_con, trim($alias)));
	if($rex==0) {
		if(empty($alias)) {
			$res="Invalid Request";
		} else {
			$selQuery = "SELECT * from ec_item_code where item_code_alias = '$alias' and flag = 0";
			$sql = mysqli_query($mr_con, $selQuery);
			$stockDetails = mysqli_fetch_array($sql);
			if(count($stockDetails)) {
				$sjoDetails = false;
				$mrfAlias = $stockDetails['sjo_no'];
				if($mrfAlias) {
					$sjoQuery = "SELECT * from ec_material_request where mrf_alias = '$mrfAlias' and flag = 0";
					$sjoSql = mysqli_query($mr_con, $sjoQuery);
					$sjoDetails = mysqli_fetch_array($sjoSql);
				}
				if($stockDetails['item_type'] == 1 && $stockDetails['cell_type'] == 1) {
					$cellQuery = "SELECT * from ec_total_cell where cell_alias = '". $alias ."' and flag = 0";
					$sql = mysqli_query($mr_con, $cellQuery);
					$cellDetails = mysqli_fetch_array($sql);
					if($cellDetails['location'] == 'XVX6AZ4VHT' && $cellDetails['stage'] == 0) {
						// Check if sjo status is any of the below
						// 9 -> Packing pending
						// 8 -> Invoice pending
						// 3 -> Dispatch pending
						if(!$sjoDetails || in_array($sjoDetails['status'],['9','8','3']) ) {
							// can be deleted
						} else {
							// cannot be delete
							$res = "Cannot be deleted at this stage";
						}
					} else {
						// cannot be deleted
						$res = "Cannot be deleted at this stage";
					}
				} else if ($stockDetails['item_type'] == 2 && $stockDetails['cell_type'] == 1) {
					$cellQuery = "SELECT * from ec_total_accessories where acc_alias = '". $alias ."' and flag = 0";
					$sql = mysqli_query($mr_con, $cellQuery);
					$cellDetails = mysqli_fetch_array($sql);
					if($cellDetails['location'] == 'XVX6AZ4VHT' && $cellDetails['stage'] == 0) {
						// Check if sjo status is any of the below
						// 9 -> Packing pending
						// 8 -> Invoice pending
						// 3 -> Dispatch pending
						if(!$sjoDetails || in_array($sjoDetails['status'],['9','8','3']) ) {
							// can be deleted
						} else {
							// cannot be delete
							$res = "Cannot be deleted at this stage";
						}
					} else {
						// cannot be deleted
						$res = "Cannot be deleted at this stage";
					}
				} else {
					// invalid type
					$res = "Invalid cell type";
				}
			} else {
				// invalid stock doesn't exists
				$res = "Invalid stock";
			}
		}
		if(isset($res)){$resCode='4';$resMsg=$res;}
		else {$resCode='0';$resMsg='Successful!';}
	} elseif($rex==1) {
		$resCode='1';$resMsg='Authentication Failed!';
	} else {
		$resCode='2';$resMsg='Account Locked!';
	}
	$result['ErrorDetails']['ErrorCode'] = $resCode;
	$result['ErrorDetails']['ErrorMessage'] = $resMsg;
	echo json_encode($result);
}

function item_code_delete() {

	global $mr_con;
	$emp_alias = mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']);
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$rex=authentication($emp_alias,$token);
	if($rex=='0') {
		$remarks = mysqli_real_escape_string($mr_con,trim($_REQUEST['remarks']));
		if(empty($remarks)){
			$res="Provide remarks";
		} else {
			$alias = mysqli_real_escape_string($mr_con, $_REQUEST['alias']);
			$selQuery = "SELECT * from ec_item_code where item_code_alias = '$alias' and flag = 0";
			$sql = mysqli_query($mr_con, $selQuery);
			$stockDetails = mysqli_fetch_array($sql);
			if(count($stockDetails)) {
				$sjoDetails = false;
				$mrfAlias = $stockDetails['sjo_no'];
				if($mrfAlias) {
					$sjoQuery = "SELECT * from ec_material_request where mrf_alias = '$mrfAlias' and flag = 0";
					$sjoSql = mysqli_query($mr_con, $sjoQuery);
					$sjoDetails = mysqli_fetch_array($sjoSql);
				}
				if($stockDetails['item_type'] == 1 && $stockDetails['cell_type'] == 1) {
					$cellQuery = "SELECT * from ec_total_cell where cell_alias = '". $alias ."' and flag = 0";
					$sql = mysqli_query($mr_con, $cellQuery);
					$cellDetails = mysqli_fetch_array($sql);
					if($cellDetails['location'] == 'XVX6AZ4VHT' && $cellDetails['stage'] == 0) {
						// Check if sjo status is any of the below
						// 9 -> Packing pending
						// 8 -> Invoice pending
						// 3 -> Dispatch pending
						if(!$sjoDetails || in_array($sjoDetails['status'],['9','8','3']) ) {
							$deleteCellQuery = "UPDATE ec_total_cell set flag = 9 where cell_alias = '". $alias ."'";
							$deleteItemQuery = "UPDATE ec_item_code set flag = 9 where item_code_alias = '". $alias ."'";
							$delCellSql = mysqli_query($mr_con, $deleteCellQuery);
							$delItemSql = mysqli_query($mr_con, $deleteItemQuery);
							if($sjoDetails && $sjoDetails['status'] != 9) {
								// check if there are any other items in material request
								$sjoQuery = "SELECT * from ec_item_code where sjo_no = '$mrfAlias' and flag = 0";
								$noOfSJOsSql = mysqli_query($mr_con, $sjoQuery);
								if(mysqli_num_rows($noOfSJOsSql) == 0) {
									$sjoUpdate = "UPDATE ec_material_request set status = 9 where mrf_alias = '". $mrfAlias ."'";
									$sjoUpSql = mysqli_query($mr_con, $sjoUpdate);
								}
							}
							$action="Deleted Cell - ". $stockDetails['item_description'] . " SJO No. - " . $sjoDetails['sjo_number'];
							user_history($emp_alias, $action, $_REQUEST['ip_addr'], $remarks);
						} else {
							// cannot be delete
							$res = "Cannot be deleted at this stage";
						}
					} else {
						// cannot be deleted
						$res = "Cannot be deleted at this stage";
					}
				} else if ($stockDetails['item_type'] == 2 && $stockDetails['cell_type'] == 1) {
					$cellQuery = "SELECT * from ec_total_accessories where acc_alias = '". $alias ."' and flag = 0";
					$sql = mysqli_query($mr_con, $cellQuery);
					$cellDetails = mysqli_fetch_array($sql);
					if($cellDetails['location'] == 'XVX6AZ4VHT' && $cellDetails['stage'] == 0) {
						// Check if sjo status is any of the below
						// 9 -> Packing pending
						// 8 -> Invoice pending
						// 3 -> Dispatch pending
						if(!$sjoDetails || in_array($sjoDetails['status'],['9','8','3']) ) {
							$deleteCellQuery = "UPDATE ec_total_accessories set flag = 9 where acc_alias = '". $alias ."'";
							$deleteItemQuery = "UPDATE ec_item_code set flag = 9 where item_code_alias = '". $alias ."'";
							$delCellSql = mysqli_query($mr_con, $deleteCellQuery);
							$delItemSql = mysqli_query($mr_con, $deleteItemQuery);
							if($sjoDetails && $sjoDetails['status'] != 9) {
								// check if there are any other items in material request
								$sjoQuery = "SELECT * from ec_item_code where sjo_no = '$mrfAlias' and flag = 0";
								$noOfSJOsSql = mysqli_query($mr_con, $sjoQuery);
								if(mysqli_num_rows($noOfSJOsSql) == 0) {
									$sjoUpdate = "UPDATE ec_material_request set status = 9 where mrf_alias = '". $mrfAlias ."'";
									$sjoUpSql = mysqli_query($mr_con, $sjoUpdate);
								}
							}
							$action="Deleted Accessory - ". $stockDetails['item_description'] . " SJO No. - " . $sjoDetails['sjo_number'];
							user_history($emp_alias, $action, $_REQUEST['ip_addr'], $remarks);
						} else {
							// cannot be delete
							$res = "Cannot be deleted at this stage";
						}
					} else {
						// cannot be deleted
						$res = "Cannot be deleted at this stage";
					}
				} else {
					// invalid type
					$res = "Invalid cell type";
				}
			} else {
				// invalid stock doesn't exists
				$res = "Invalid stock";
			}
		}
		if(isset($res)) {$resCode='4';$resMsg=$res;}
		else {$resCode='0';$resMsg='Successful!';}
	} elseif($rex=='1') {
		$resCode='1'; $resMsg='Authentication Failed';
	} else { 
		$resCode='2'; $resMsg='Account Locked';
	}
	$result['ErrorDetails']['ErrorCode']=$resCode; 
	$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}

?>