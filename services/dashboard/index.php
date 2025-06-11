<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
require('../Slim/Slim.php');
require('../Classes/PHPExcel.php');
require('../Classes/PHPExcel/IOFactory.php');
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->post('/yogzkmi','yogzkmi_fun');
$app->post('/ticket_status','ticket_status');
$app->post('/customer_pulse','customer_pulse');
$app->post('/today_info_report_block','today_info_report_block');
$app->post('/tat_status','tat_status');
$app->post('/tkt_status_mon','tkt_status_mon');
$app->post('/nature_of_activity','nature_of_activity');
$app->post('/fault_analysis','fault_analysis');
$app->post('/manufacturing_month_failure','manufacturing_month_failure');
$app->post('/product_cont_failure','product_cont_failure');
$app->run();
function yogzkmi_fun(){
	global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	$result = [];
	if($chk=='0'){
		if($emp_alias!='ADMIN'){
			$s_temp=alias($emp_alias,'ec_employee_master','employee_alias','state_alias');
			$c1="state_alias IN ('".implode("','", explode(", ",$s_temp))."') AND state_name<>'FACTORY' AND ";
		}else $c1="state_name<>'FACTORY' AND ";
		$q1=mysqli_query($mr_con,"SELECT state_name as name,state_alias as alias FROM ec_state WHERE $c1 flag='0' ORDER BY name");
		$q2=mysqli_query($mr_con,"SELECT customer_code as name,customer_alias as alias FROM ec_customer WHERE flag='0' ORDER BY name");
		$q3=mysqli_query($mr_con,"SELECT segment_name as name,segment_alias as alias FROM ec_segment WHERE flag='0' ORDER BY name");
		$q4=mysqli_query($mr_con,"SELECT description as name,faulty_alias as alias FROM ec_faulty_code WHERE flag='0' ORDER BY name");
		$q5=mysqli_query($mr_con,"SELECT activity_code as name,activity_alias as alias FROM ec_activity WHERE flag='0' ORDER BY name");
		if(mysqli_num_rows($q1)>'0'){$x=0;while($r1=mysqli_fetch_array($q1)){$result['ss'][$x]['name']=$r1['name'];$result['ss'][$x]['alias']=$r1['alias'];$x++;}}else{$result['ss'][0]['name']="No Records";$result['ss'][0]['alias']="0";}
		if(mysqli_num_rows($q2)>'0'){$x=0;while($r1=mysqli_fetch_array($q2)){$result['cs'][$x]['name']=$r1['name'];$result['cs'][$x]['alias']=$r1['alias'];$x++;}}else{$result['cs'][0]['name']="No Records";$result['cs'][0]['alias']="0";}
		if(mysqli_num_rows($q3)>'0'){$x=0;while($r1=mysqli_fetch_array($q3)){$result['ses'][$x]['name']=$r1['name'];$result['ses'][$x]['alias']=$r1['alias'];$x++;}}else{$result['ses'][0]['name']="No Records";$result['ses'][0]['alias']="0";}
		if(mysqli_num_rows($q4)>'0'){$x=0;while($r1=mysqli_fetch_array($q4)){$result['fs'][$x]['name']=$r1['name'];$result['fs'][$x]['alias']=$r1['alias'];$x++;}}else{$result['fs'][0]['name']="No Records";$result['fs'][0]['alias']="0";}
		if(mysqli_num_rows($q5)>'0'){$x=0;while($r1=mysqli_fetch_array($q5)){$result['acs'][$x]['name']=$r1['name'];$result['acs'][$x]['alias']=$r1['alias'];$x++;}}else{$result['acs'][0]['name']="No Records";$result['acs'][0]['alias']="0";}
		for($c=14;$c<=date('y');$c++){
			$result['yrr'][$c-14]['name']="20".$c."-".($c+1);
			$result['yrr'][$c-14]['alias']=$c;
		}
	}
	echo json_encode($result);
}
function ticket_status(){ global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){
		$result['tktstatusDetails']=array();
		if(isset($_REQUEST['state_alias'])){$state_alias=$_REQUEST['state_alias'];}else{$state_alias="";}
		if(isset($_REQUEST['faulty_alias'])){$fal=$_REQUEST['faulty_alias'];}else{$fal="";}
		$segment_alias=alias($emp_alias,'ec_employee_master','employee_alias','segment_alias');
		if(isset($_REQUEST['segment_alias'])){
			if(empty($segment_alias)){
				if(isset($_REQUEST['segment_alias'])){$seg=$_REQUEST['segment_alias'];}else $seg="";
			}else $seg=array_intersect($_REQUEST['segment_alias'],explode(", ",$segment_alias));
		}elseif(!empty($segment_alias))$seg = explode(", ",$segment_alias);
		else $seg="";
		$customer_alias=alias($emp_alias,'ec_employee_master','employee_alias','customer_alias');
		if(isset($_REQUEST['customer_alias'])){
			if(empty($customer_alias)){
				if(isset($_REQUEST['customer_alias'])){$cust=$_REQUEST['customer_alias'];}else{$cust="";}
			}else $cust=array_intersect($_REQUEST['customer_alias'],explode(", ",$customer_alias));
		}elseif(!empty($customer_alias))$cust = explode(", ",$customer_alias);
		else $cust="";
		if(isset($_REQUEST['activity_alias'])){$activity_alias=$_REQUEST['activity_alias'];}else{$activity_alias="";}
		if(isset($_REQUEST['tat'])){$tat=$_REQUEST['tat'];}else{$tat="";}
		if(isset($_REQUEST['year'])&&!empty($_REQUEST['year'])){
			$year=$_REQUEST['year'];
			$from_date="20".$year."-04-01";
			$to_date="20".($year+1)."-03-31";
		}else{$from_date=0;$to_date=0;}
		$level_query=mysqli_query($mr_con,"SELECT level_name,level_alias FROM ec_levels WHERE level_alias<>'5' AND flag=0");
		while($level_row=mysqli_fetch_array($level_query)){
			$level_name[] = $level_row['level_name'];
			$level_alias[] = $level_row['level_alias'];
		}
		array_push($level_alias,"9","10","11");
		array_push($level_name,"PLAN FAIL","REPL DUE","TS REJECTED");
		if($emp_alias!="ADMIN"){
			$f=alias($emp_alias,'ec_employee_master','employee_alias','zone_alias');
			$empzone = explode(", ",$f);
		}else{$empzone = array();}
		$zone_query=mysqli_query($mr_con,"SELECT zone_name,zone_alias FROM ec_zone WHERE flag=0 LIMIT 0,4");
		while($zone_row=mysqli_fetch_array($zone_query)){
			$zone_name[] = $zone_row['zone_name'];
			$zone_alias[] = $zone_row['zone_alias'];
		}
		$level_count = count($level_alias);
		$zone_count = count($zone_alias);
		for($i=0;$i<$level_count;$i++){
			$result['tktstatusDetails'][$i]['level_name']=$level_name[$i];
			$tot=0;
			for($j=0;$j<$zone_count;$j++){
				$zx = $zone_alias[$j];
				$zone_alias1 = (in_array($zx,$empzone) || $emp_alias=="ADMIN"  ? $zx : "");
				$fun = zone_count($level_alias[$i],$state_alias,$zone_alias1,$seg,$fal,$cust,$activity_alias,$tat,$from_date,$to_date);
				if($i==0){$result['tktzone_name'][$j]['zone_name']=$zone_name[$j];}
				$result['tktstatusDetails'][$i]['zone_count'][$j]['count']=$fun;
				if($i==5 || $i==6)$closed+=$fun;else $opened+=$fun; //($i<5 || $i>=7)
				$tot+=$fun;
				if($j==0)$a+=$fun;
				elseif($j==1)$b+=$fun;
				elseif($j==2)$c+=$fun;
				elseif($j==3)$d+=$fun;
				$e+=$fun;		
			}
			$result['tktstatusDetails'][$i]['value']=$tot;
		}
		$result['details'][0]['cnt_value']=$a;
		$result['details'][1]['cnt_value']=$b;
		$result['details'][2]['cnt_value']=$c;
		$result['details'][3]['cnt_value']=$d;
		$result['details'][4]['cnt_value']=$e;
		$result['status']='STATUS';
		$result['total']='TOTAL';
		$result['grandtotal']='Grand Total';
		$result['opened']=$opened;
		$result['closed']=$closed;
		if($sql){$resCode='0'; $resMsg='Successfull!';
		}else{$resCode='4'; $resMsg='No Records Found';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function zone_count($level,$state_alias,$zone_alias,$segment,$faulty_code,$customer,$activity_alias,$tat,$from_date,$to_date){ global $mr_con;
	$con = "";
	if($from_date!='0' && $to_date!='0')$con .= "t1.login_date >= '".$from_date."' AND t1.login_date <= '".$to_date."' AND ";
	if($level=='2')$con .= "t1.level='$level' AND t1.planned_date >= '".date('Y-m-d')."' AND ";
	elseif($level=='9')$con .= "t1.level='2' AND t1.planned_date < '".date('Y-m-d')."' AND ";
	elseif($level=='1')$con .= "t1.level='1' AND t1.purpose = '0' AND ";
	elseif($level=='10')$con .= "t1.level='1' AND t1.purpose = '1' AND ";
	elseif($level=='4')$con .= "t1.level='4' AND t1.old_level = '3' AND ";
	elseif($level=='11')$con .= "t1.level='4' AND t1.old_level = '8' AND ";
	elseif($level=='6' || $level=='7')$con .= "t1.level='$level' AND t1.ticket_id NOT LIKE '%|%' AND ";
	else $con .= "t1.level='$level' AND ";
	if(isset($state_alias) && ($state_alias>0)){
		$state=implode("|",$state_alias);
		$con .= "t2.state_alias RLIKE '$state' AND ";
	}
	if(isset($segment) && count($segment)>0 && !empty($segment)){
		$seg = implode("|",$segment);
		$con .= "t2.segment_alias RLIKE '$seg' AND ";
	}
	if(isset($faulty_code) && count($faulty_code)>0 && !empty($faulty_code)){
		$gh=array();
		$faulty = implode("|",$faulty_code);
		$gh=mul_alias($faulty ,'ec_fsr_faulty_cells','faulty_code_alias','ticket_alias');
		$g=implode("|",$gh);
		if(!empty($g)){
			$con .= "t1.ticket_alias RLIKE '$g' AND ";
		}
	}
	if(isset($customer) && count($customer)>0 && !empty($customer)){
		$cu=implode("|",$customer);
		$con .= "t2.customer_alias RLIKE '$cu' AND ";
	}
	if(isset($activity_alias) && count($activity_alias)>0 && !empty($activity_alias)){
		$activity=implode("|",$activity_alias);
		$con .="t1.activity_alias RLIKE '$activity' AND ";
	}
	if(isset($tat) && count($tat)>0 && !empty($tat)){
		$ta=implode("|",$tat);
		$con .="t1.tat RLIKE '$ta' AND ";
	}
	$tt_sql=mysqli_query($mr_con,"SELECT t1.id FROM ec_tickets t1 JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias WHERE $con t2.zone_alias='$zone_alias' AND t1.flag=0");
	$total_count=mysqli_num_rows($tt_sql);
	return $total_count;
}
function customer_pulse(){ global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){ $a1=array();
		if(isset($_REQUEST['state_alias'])&&!empty($_REQUEST['state_alias']))$sa="t5.state_alias IN ('".implode("','",$_REQUEST['state_alias'])."') AND ";else $sa="";
		if(isset($_REQUEST['customer_alias'])&&!empty($_REQUEST['customer_alias']))$ca="t5.customer_alias IN ('".implode("','",$_REQUEST['customer_alias'])."') AND ";else $ca="";
		if(isset($_REQUEST['segment_alias'])&&!empty($_REQUEST['segment_alias']))$sga="t5.segment_alias IN ('".implode("','",$_REQUEST['segment_alias'])."') AND ";else $sga="";
		if(isset($_REQUEST['activity_alias'])&&!empty($_REQUEST['activity_alias']))$act="t3.activity_alias IN ('".implode("','",$_REQUEST['activity_alias'])."') AND ";else $act="";
		if(isset($_REQUEST['year'])&&!empty($_REQUEST['year'])){
			$year=$_REQUEST['year'];
			$from_date="20".$year."-04-01";
			$to_date="20".($year+1)."-03-31";
		}else{$from_date=$to_date=0;}
		if($from_date!='0' && $to_date!='0'){
			$cd= "t3.login_date >= '".$from_date."' AND t3.login_date <= '".$to_date."' AND ";
		}else $cd="";
		$cobb=$sa.$ca.$sga.$cd.$act;
		if($cobb!="")$wer=' INNER JOIN ec_tickets t3 ON t1.ticket_alias=t3.ticket_alias INNER JOIN ec_sitemaster t5 ON t3.site_alias=t5.site_alias ';else $wer="";
		$sql1=mysqli_query($mr_con,"SELECT t2.q1,t2.q2, t2.q3, t2.q4, t2.q5 FROM ec_customer_comments t1 INNER JOIN ec_customer_satisfaction t2 ON t1.ticket_alias=t2.ticket_alias $wer WHERE $sa $ca $sga $cd t1.flag=0 AND t2.flag=0");
			if(mysqli_num_rows($sql1)>'0'){
				while($row1=mysqli_fetch_array($sql1)){
					$a1[]=$row1['q1'];
					$a1[]=$row1['q2'];
					$a1[]=$row1['q3'];
					$a1[]=$row1['q4'];
					$a1[]=$row1['q5'];
				}
			}else{
				$result['data']['columns'][0][0]='NO Pulse';
				$result['data']['columns'][0][1]='0';
				$result['color']['pattern'][0]='#e0e0e0';
			}
		$result['bindto']='#c_pulse';
		if(array_sum($a1)>'0'){
			$count = count($a1)/5;
			$result['data']['columns'][0][]="Pulse";
			$result['data']['columns'][0][]=array_sum($a1)*100 /($count * 25 );
			$result['color']['pattern'][0]='#FF0000';
			$result['color']['pattern'][1]='#F97600';
			$result['color']['pattern'][2]='#F6C600';
			$result['color']['pattern'][3]='#60B044';
			$result['color']['threshold']['values'][0]=25;
			$result['color']['threshold']['values'][1]=50;
			$result['color']['threshold']['values'][2]=75;
			$result['color']['threshold']['values'][3]=100;
		}
		$result['data']['type']='gauge';
		$result['size']['height']='350';
		$result['gauge']['width']='70';
		$result['admin'] = $emp_alias;
		if($sql1){$resCode='0'; $resMsg='Successfull!';
		}else{$resCode='4'; $resMsg='No Records Found';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function today_info_report_block(){global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){
		if(isset($_REQUEST['state_alias'])&&!empty($_REQUEST['state_alias']))$sa="t2.state_alias IN ('".implode("','",$_REQUEST['state_alias'])."') AND ";else $sa="";
		if(isset($_REQUEST['customer_alias'])&&!empty($_REQUEST['customer_alias']))$ca="t2.customer_alias IN ('".implode("','",$_REQUEST['customer_alias'])."') AND ";else $ca="";
		if(isset($_REQUEST['segment_alias'])&&!empty($_REQUEST['segment_alias']))$sga="t2.segment_alias IN ('".implode("','",$_REQUEST['segment_alias'])."') AND ";else $sga="";
		if(isset($_REQUEST['activity_alias'])&&!empty($_REQUEST['activity_alias']))$act="t1.activity_alias IN ('".implode("','",$_REQUEST['activity_alias'])."') AND ";else $act="";
		if(isset($_REQUEST['faulty_alias'])&&!empty($_REQUEST['faulty_alias'])){
			$fa_a=' INNER JOIN ec_fsr_faulty_cells t3 ON t1.ticket_alias=t3.ticket_alias ';
			$fa="t3.faulty_code_alias IN ('".implode("','",$_REQUEST['faulty_alias'])."') AND ";
		}else{$fa="";$fa_a="";}
		if(isset($_REQUEST['tat'])&&!empty($_REQUEST['tat'])){$tatt= "t1.tat IN ('".implode("','",$_REQUEST['tat'])."') AND ";}else $tatt="";
		$con=$sa.$ca.$sga.$fa.$tatt.$act;
		$sql=mysqli_query($mr_con,"SELECT level_alias,level_name FROM ec_levels WHERE level_alias<>'0' AND flag=0");
		$i=0;while($l_row=mysqli_fetch_array($sql)){
			
			//$cc['level'][$i]=$l_row['level_name'];
			//$query=mysqli_query($mr_con,"SELECT COUNT(t1.id) AS coun FROM ec_tickets t1 INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias $fa_a WHERE $con t1.level='".$l_row['level_alias']."' AND transaction_date ='".date('Y-m-d')."' AND t1.flag=0 AND t2.flag=0");
			if($l_row['level_alias']=="5"){
				$cc['level'][$i] = "TS REJECTED";
				$con1="t1.level='4' AND t1.old_level='8' AND ";
			}else{
				$cc['level'][$i] = $l_row['level_name'];
				$con1= $l_row['level_alias']=="4" ? "t1.level='".$l_row['level_alias']."' AND t1.old_level<>'8' AND " : "t1.level='".$l_row['level_alias']."' AND ";
			}
			$query=mysqli_query($mr_con,"SELECT COUNT(DISTINCT SUBSTRING_INDEX(t1.ticket_id,'|',1)) AS coun FROM ec_tickets t1 INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias $fa_a WHERE $con $con1 t1.level<>'5' AND t1.transaction_date ='".date('Y-m-d')."' AND t1.flag=0");
			if(mysqli_num_rows($query)>'0'){$ro = mysqli_fetch_array($query);$co = $ro['coun'];}else{$co = 0;}
			$mm['tktcount'][0]="Tickets";
			$mm['tktcount'][$i+1]=$co;
			$kk+=$co;
		$i++;}
		$result['totalcount']=$kk;
		$result['bindto']='#td_info';
		$result['data']['columns'][0]=$mm['tktcount'];
		$result['data']['type']="bar";
		$result['color']['pattern'][0]="#3F51B5";
		$result['color']['pattern'][1]="#38B4EE";
		$result['color']['pattern'][2]="#4CAF50";
		$result['color']['pattern'][3]="#E91E63";
		$result['axis']['x']['type']='category';
		$result['axis']['x']['categories']=$cc['level'];
		$result['legend']['position']='inset';
		$result['bar']['width']['ratio']='0.4';
		$result['size']['height']='350';
		$result['admin'] = $emp_alias;
		if($sql){$resCode='0'; $resMsg='Successfull!';
		}else{$resCode='4'; $resMsg='No Records Found';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
 
}
function tat_status(){ global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){$con = ""; $emp = ""; $yr = "";
		if(isset($_REQUEST['state_alias'])&&!empty($_REQUEST['state_alias']))$sa="t2.state_alias IN ('".implode("','",$_REQUEST['state_alias'])."') AND ";else $sa="";
		if(isset($_REQUEST['customer_alias'])&&!empty($_REQUEST['customer_alias']))$ca="t2.customer_alias IN ('".implode("','",$_REQUEST['customer_alias'])."') AND ";else $ca="";
		if(isset($_REQUEST['segment_alias'])&&!empty($_REQUEST['segment_alias']))$sga="t2.segment_alias IN ('".implode("','",$_REQUEST['segment_alias'])."') AND ";else $sga="";
		if(isset($_REQUEST['activity_alias'])&&!empty($_REQUEST['activity_alias']))$act="t1.activity_alias IN ('".implode("','",$_REQUEST['activity_alias'])."') AND ";else $act="";
		if(isset($_REQUEST['faulty_alias'])&&!empty($_REQUEST['faulty_alias'])){
			$fa_a=' INNER JOIN ec_fsr_faulty_cells t3 ON t1.ticket_alias=t3.ticket_alias ';
			$fa="t3.faulty_code_alias IN ('".implode("','",$_REQUEST['faulty_alias'])."') AND ";
		}else{$fa=$fa_a="";}
		if(isset($_REQUEST['year'])&&!empty($_REQUEST['year'])){
			$year=$_REQUEST['year'];
			$from_date="20".$year."-04-01";
			$to_date="20".($year+1)."-03-31";
		}else $from_date=$to_date='0';
		if($from_date!='0' && $to_date!='0')$cd= "t1.login_date >= '".$from_date."' AND t1.login_date <= '".$to_date."' AND ";else $cd="";
		if($emp_alias!="ADMIN"){
			$f=alias($emp_alias,'ec_employee_master','employee_alias','state_alias');
			$emp = "t2.state_alias IN ('".str_replace(", ","','",$f)."') AND ";
		}
		$con=$sa.$ca.$sga.$cd.$fa.$act;
		$query = mysqli_query($mr_con,"SELECT COUNT(t1.id) as der, t1.tat FROM ec_tickets t1
				INNER JOIN (SELECT MAX(ID) AS ID FROM ec_tickets WHERE flag='0' GROUP BY SUBSTRING_INDEX(ticket_id,'|',1)) AS P ON (t1.ID=P.ID)
				INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias $fa_a WHERE $con t1.flag='0' GROUP BY t1.tat");
		//$query=mysqli_query($mr_con,"SELECT COUNT(t1.id) as der, t1.tat FROM ec_tickets t1 INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias $fa_a WHERE $con t1.flag=0 GROUP BY t1.tat");
		if(mysqli_num_rows($query)>'0'){$de=0;
			while($row=mysqli_fetch_array($query)){
				if(!empty($row['tat'])){
					$result['data']['columns'][$de][0]=$row['tat'];
					$result['data']['columns'][$de][1]=$row['der'];
					$de++;
				}
			}
		}else{
			$result['data']['columns'][0][0]='NO TAT';
			$result['data']['columns'][0][1]='1';
			$result['color']['pattern'][0]='#e0e0e0';
		}
		$result['bindto']='#tat_con';
		$result['data']['type']='pie';
		$result['size']['height']='350';
		$result['pie']['width']='70';
		if($query){$resCode='0'; $resMsg='Successfull!';
		}else{$resCode='4'; $resMsg='No Records Found';}
	}
	elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']=$resCode;$result['ErrorDetails']=$resMsg;
	echo json_encode($result);
}
function tkt_status_mon(){ global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){
		$con="";
		if(isset($_REQUEST['state_alias'])&&!empty($_REQUEST['state_alias']))$sa="t2.state_alias IN ('".implode("','",$_REQUEST['state_alias'])."') AND ";else $sa="";
		if(isset($_REQUEST['customer_alias'])&&!empty($_REQUEST['customer_alias']))$ca="t2.customer_alias IN ('".implode("','",$_REQUEST['customer_alias'])."') AND ";else $ca="";
		if(isset($_REQUEST['segment_alias'])&&!empty($_REQUEST['segment_alias']))$sga="t2.segment_alias IN ('".implode("','",$_REQUEST['segment_alias'])."') AND ";else $sga="";
		if(isset($_REQUEST['activity_alias'])&&!empty($_REQUEST['activity_alias']))$act="t1.activity_alias IN ('".implode("','",$_REQUEST['activity_alias'])."') AND ";else $act="";
		if(isset($_REQUEST['year'])&&!empty($_REQUEST['year']))$year=$_REQUEST['year'];else{
			$m=date('m');
			$year=(($m=='01' || $m=='02' || $m=='03') ? date('y', strtotime('-1 year')) : date('y'));
		}
		$mon_name=array("Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Jan","Feb","Mar","Apr");
		$month_j=array("04","05","06","07","08","09","10","11","12","01","02","03");
		for($x=0;$x<=12;$x++){
			if($x<'9'){$dates[$x]="20".$year."-".$month_j[$x];
			}else{$dates[$x]="20".($year+1)."-".$month_j[$x];}
		}
		$aa[0]="Logged"; $bb[0]="Closed";
		$con=$sa.$ca.$sga.$act;
		for($i=1;$i<count($dates);$i++){
			$sql=mysqli_query($mr_con,"SELECT t1.id FROM ec_tickets t1 INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias WHERE $con t1.login_date LIKE '%".$dates[$i-1]."%' AND t1.ticket_id NOT LIKE '%|%' AND t1.flag='0' AND t2.flag='0'");
			$sql1=mysqli_query($mr_con,"SELECT t1.id FROM ec_tickets t1 INNER JOIN (SELECT MAX(ID) AS ID FROM ec_tickets GROUP BY SUBSTRING_INDEX(ticket_id,'|',1)) AS P ON (t1.ID=P.ID) INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias WHERE $con t1.closing_date LIKE '%".$dates[$i-1]."%' AND t1.flag='0'");
			$aa[$i]=mysqli_num_rows($sql);
			$bb[$i]=mysqli_num_rows($sql1);
		}
		$result['bindto']='#m_analasys';
		$result['data']['columns'][]=$aa;
		$result['data']['columns'][]=$bb;
		$result['data']['axis']['rotated']=true;
		$result['data']['type']='bar';
		$result['axis']['x']['type']='category';
		$result['axis']['x']['categories']=$mon_name;
		$result['size']['height']='350';
		$result['bar']['width']['ratio']=0.9;
		$result['admin'] = $emp_alias;
		if($sql1 && $sql2){$resCode='0'; $resMsg='Successfull!';}else{$resCode='4'; $resMsg='No Records Found';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function nature_of_activity(){ global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){ $con = "";
		if(isset($_REQUEST['state_alias'])&&!empty($_REQUEST['state_alias']))$sa="t2.state_alias IN ('".implode("','",$_REQUEST['state_alias'])."') AND ";else $sa="";
		if(isset($_REQUEST['customer_alias'])&&!empty($_REQUEST['customer_alias']))$ca="t2.customer_alias IN ('".implode("','",$_REQUEST['customer_alias'])."') AND ";else $ca="";
		if(isset($_REQUEST['segment_alias'])&&!empty($_REQUEST['segment_alias']))$sga="t2.segment_alias IN ('".implode("','",$_REQUEST['segment_alias'])."') AND ";else $sga="";
		if(isset($_REQUEST['year'])&&!empty($_REQUEST['year'])){
			$year=$_REQUEST['year'];
			$from_date="20".$year."-04-01";
			$to_date="20".($year+1)."-03-31";
		}else{$from_date=0;$to_date=0;}
		if($from_date!='0' && $to_date!='0')$cd= "t1.login_date >= '".$from_date."' AND t1.login_date <= '".$to_date."' AND ";else $cd="";
		if($emp_alias!="ADMIN"){
			$f=alias($emp_alias,'ec_employee_master','employee_alias','state_alias');
			$emp = "t2.state_alias IN ('".str_replace(", ","','",$f)."') AND ";
		}else $emp="";
		$con=$sa.$ca.$sga.$cd.$emp;
		$aa['actname'] = array();$c=0;$i=0;
		$sql=mysqli_query($mr_con,"SELECT COUNT(DISTINCT SUBSTRING_INDEX(t1.ticket_id,'|',1)) AS gty, t3.activity_code FROM ec_tickets t1 INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias INNER JOIN ec_activity t3 ON t1.activity_alias=t3.activity_alias WHERE $con t1.flag='0' GROUP BY t1.activity_alias");
		while($sql_row=mysqli_fetch_array($sql)){
			$aa['actname'][$i][]=$sql_row['activity_code'];	
			$c+= $aa['actname'][$i][]=$sql_row['gty'];	
		$i++;}
		$result['bindto']='#n_act';
		if($c){
			$result['color']['pattern'][0]='#3F51B5';
			$result['color']['pattern'][1]='#4CAF50';
			$result['color']['pattern'][2]='#f44336';
			$result['color']['pattern'][3]='#E91E63';
			$result['color']['pattern'][4]='#38B4EE';
		}else{
			unset($aa['actname']);
			$aa['actname'][0][0]='No Activity';	
			$aa['actname'][0][1]=1;
			$result['color']['pattern'][0]='#e0e0e0';
		}
		$result['data']['columns']=$aa['actname'];
		$result['data']['type']="donut";
		$result['size']['height']='350';
		$result['donut']['width']='70';
		if($query){$resCode='0'; $resMsg='Successfull!';}
		}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';}
	else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function fault_analysis(){ global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){ $con = "";
		if(isset($_REQUEST['state_alias'])&&!empty($_REQUEST['state_alias']))$sa="t2.state_alias IN ('".implode("','",$_REQUEST['state_alias'])."') AND ";else $sa="";
		if(isset($_REQUEST['customer_alias'])&&!empty($_REQUEST['customer_alias']))$ca="t2.customer_alias IN ('".implode("','",$_REQUEST['customer_alias'])."') AND ";else $ca="";
		if(isset($_REQUEST['segment_alias'])&&!empty($_REQUEST['segment_alias']))$sga="t2.segment_alias IN ('".implode("','",$_REQUEST['segment_alias'])."') AND ";else $sga="";
		if(isset($_REQUEST['activity_alias'])&&!empty($_REQUEST['activity_alias']))$act="t1.activity_alias IN ('".implode("','",$_REQUEST['activity_alias'])."') AND ";else $act="";
		if(isset($_REQUEST['year'])&&!empty($_REQUEST['year'])){
			$year=$_REQUEST['year'];
			$from_date="20".$year."-04-01";
			$to_date="20".($year+1)."-03-31";
		}else{$from_date=0;$to_date=0;}
		if($from_date!='0' && $to_date!='0')$cd= "t1.login_date >= '".$from_date."' AND t1.login_date <= '".$to_date."' AND ";else $cd="";
		if($emp_alias!="ADMIN"){
			$f=alias($emp_alias,'ec_employee_master','employee_alias','state_alias');
			$emp = "t2.state_alias IN ('".str_replace(", ","','",$f)."') AND ";
		}else $emp="";
		$con=$sa.$ca.$sga.$cd.$emp.$act;
		$color = array('#0099ff','#993333','#f44336','#E91E63','#38B4EE','#D62728','#E377C2','#FF7F0E','#2CA02C','#8C564B','#1F77B4','#BCBD22','#9467BD','#7F7F7F','#8C564B');
		$l=0;
		$sql=mysqli_query($mr_con,"SELECT COUNT(t4.id) AS coun,t3.description FROM ec_tickets t1
			 INNER JOIN ec_sitemaster t2 ON t1.site_alias=t2.site_alias
			 INNER JOIN ec_fsr_faulty_cells t4 ON t1.ticket_alias=t4.ticket_alias
			 INNER JOIN ec_faulty_code t3 ON t4.faulty_code_alias=t3.faulty_alias WHERE $con t3.faulty_type<>'1' AND t1.flag='0' GROUP BY t4.faulty_code_alias");
		while($sql_row=mysqli_fetch_array($sql)){
			$aa['faultyDetails'][$l][]=$sql_row['description'];
			$aa['faultyDetails'][$l][]=$sql_row['coun'];	
		$l++;}
		$result['bindto']='#f_analasys';
		if($l==0){
			$aa['faultyDetails'][0][0]='No Faulty';
			$aa['faultyDetails'][0][1]=1;
			unset($color);
			$color = array('#e0e0e0');
		}
		foreach($color as $k=>$col){ $result['color']['pattern'][$k]=$col;}
		$result['data']['columns']=$aa['faultyDetails'];
		$result['data']['type']='donut';
		$result['legend']['position']='right';
		$result['size']['height']='350';
		$result['donut']['width']='70';
		$result['admin'] = $emp_alias;
		if($query){$resCode='0'; $resMsg='Successfull!';}else{$resCode='4'; $resMsg='No Records Found';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function manufacturing_month_failure(){ global $mr_con; $condition = "";
		$graph=array();
		$con=$accde=$sa=$ca=$sga=$act=$p=$d="";
		if(isset($_REQUEST['state_alias'])&&!empty($_REQUEST['state_alias']))$sa="t3.state_alias IN ('".implode("','",$_REQUEST['state_alias'])."') AND ";
		if(isset($_REQUEST['customer_alias'])&&!empty($_REQUEST['customer_alias']))$ca="t3.customer_alias IN ('".implode("','",$_REQUEST['customer_alias'])."') AND ";
		if(isset($_REQUEST['segment_alias'])&&!empty($_REQUEST['segment_alias']))$sga="t3.segment_alias IN ('".implode("','",$_REQUEST['segment_alias'])."') AND ";
		if(isset($_REQUEST['activity_alias'])&&!empty($_REQUEST['activity_alias']))$act="t2.activity_alias IN ('".implode("','",$_REQUEST['activity_alias'])."') AND ";
		if(isset($_REQUEST['faulty_alias'])&&!empty($_REQUEST['faulty_alias']))$fa="faulty_code_alias IN ('".implode("','",$_REQUEST['faulty_alias'])."') AND ";
		if(isset($_REQUEST['year'])&&!empty($_REQUEST['year']))$year=$_REQUEST['year'];
		else{
			$m=date('m');
			$year=(($m=='01' || $m=='02' || $m=='03') ? date('y', strtotime('-1 year')) : date('y'));
		}
		$month=array("Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Jan","Feb","Mar","Apr");
		$month_j=array("04","05","06","07","08","09","10","11","12","01","02","03");
		for($x=0;$x<=12;$x++){
			$dates[$x] = $month_j[$x]."/".($x<'9' ? $year : $year+1);
			$months[]=$month[$x]."-".($x<'9' ? $year : $year+1);
		}
		$con=$sa.$ca.$sga.$act.$fa;
		$prod=$less_pr=array();
		$sql1=mysqli_query($mr_con,"SELECT t4.battery_rating FROM ec_fsr_faulty_cells t1 INNER JOIN ec_tickets t2 ON t2.ticket_alias=t1.ticket_alias INNER JOIN ec_sitemaster t3 ON t3.site_alias=t2.site_alias INNER JOIN ec_product t4 ON t4.product_alias=t3.product_alias WHERE $con t1.flag=0 GROUP BY t4.product_alias");
		while($row1=mysqli_fetch_array($sql1)){$prod[$row1['battery_rating']]=array($row1['battery_rating']);}
		for($ax=0;$ax<12;$ax++){
			$sql=mysqli_query($mr_con,"SELECT t4.battery_rating,COUNT(DISTINCT t1.cell_sl_no,t1.mf_date,t4.product_alias) AS f_count FROM ec_fsr_faulty_cells t1 INNER JOIN ec_tickets t2 ON t2.ticket_alias=t1.ticket_alias INNER JOIN ec_sitemaster t3 ON t3.site_alias=t2.site_alias INNER JOIN ec_product t4 ON t4.product_alias=t3.product_alias WHERE $con t1.mf_date='".$dates[$ax]."' AND t1.flag=0 GROUP BY t4.battery_rating");
			$f_sum=0;$pp=array();
			$k=0;while($row=mysqli_fetch_array($sql)){
				$f_sum+=$row['f_count'];
				$less_pr[]=$row['battery_rating'];
				$pp[$row['battery_rating']] = $row['f_count'];
			$k++;}
			foreach($prod as $ee=>$gg){ array_push($prod[$ee],$pp[$ee]); }
			$graph[$ax]=$f_sum;
		}
		foreach(array_diff_key($prod,array_flip(array_unique($less_pr))) as $a=>$b){ unset($prod[$a]); }
		array_unshift($graph,'Fault Count');
		$result['data']['columns'][]=$graph;
		foreach($prod as $per){ $result['data']['columns'][]=$per; }
		$result['bindto']='#m_month';
		$result['data']['type']='spline';
		$result['data']['types']['Fault Count']='bar';
		$result['size']['height']='350';
		$result['axis']['x']['type']='category';
		$result['axis']['x']['categories']=$months;
		$result['admin'] = '';
	echo json_encode($result);
}
function product_cont_failure(){ global $mr_con;
	$emp_alias = strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['emp_alias']));
	$token = mysqli_real_escape_string($mr_con,$_REQUEST['token']);
	$chk=authentication($emp_alias,$token);
	if($chk==0){ $con = "";
		if(isset($_REQUEST['state_alias'])&&!empty($_REQUEST['state_alias']))$sa="t3.state_alias IN ('".implode("','",$_REQUEST['state_alias'])."') AND ";else $sa="";
		if(isset($_REQUEST['customer_alias'])&&!empty($_REQUEST['customer_alias']))$ca="t3.customer_alias IN ('".implode("','",$_REQUEST['customer_alias'])."') AND ";else $ca="";
		if(isset($_REQUEST['segment_alias'])&&!empty($_REQUEST['segment_alias']))$sga="t3.segment_alias IN ('".implode("','",$_REQUEST['segment_alias'])."') AND ";else $sga="";
		if(isset($_REQUEST['activity_alias'])&&!empty($_REQUEST['activity_alias']))$act="t2.activity_alias IN ('".implode("','",$_REQUEST['activity_alias'])."') AND ";else $act="";
		if(isset($_REQUEST['faulty_alias'])&&!empty($_REQUEST['faulty_alias']))$fa="t1.faulty_code_alias IN ('".implode("','",$_REQUEST['faulty_alias'])."') AND ";else $fa="";
		if(isset($_REQUEST['year'])&&!empty($_REQUEST['year'])){
			$year=$_REQUEST['year'];
			$from_date="20".$year."-04-01";
			$to_date="20".($year+1)."-03-31";
		}else{$from_date=0;$to_date=0;}
		if($from_date!='0' && $to_date!='0')$cd= "t2.login_date >= '".$from_date."' AND t2.login_date <= '".$to_date."' AND ";else $cd="";
		$con=$sa.$ca.$sga.$cd.$fa.$act;$d=0;$cell=array();

		$query=mysqli_query($mr_con,"SELECT t4.battery_rating,COUNT(DISTINCT t1.cell_sl_no,t1.mf_date) AS f_count FROM ec_fsr_faulty_cells t1 INNER JOIN ec_tickets t2 ON t2.ticket_alias=t1.ticket_alias INNER JOIN ec_sitemaster t3 ON t3.site_alias=t2.site_alias INNER JOIN ec_product t4 ON t4.product_alias=t3.product_alias WHERE $con t1.flag=0 GROUP BY t4.battery_rating");
		if(mysqli_num_rows($query)>'0'){
			while($query_row=mysqli_fetch_array($query)){
					$per[][]=$query_row['battery_rating'];
					$cell[]=$query_row['f_count'];
				}
		}
		$total=array_sum($cell);
		$result['bindto']='#p_contri';
		if($total==0){
			$per[0][0]='No Product Failure';
			$cell[0]=1;
			$total=1;
			$result['color']['pattern'][0]='#e0e0e0';
		}
		foreach($cell as $k=>$kount){ $per[$k][] = ($kount*100)/$total;}
		$result['data']['columns']=$per;
		$result['data']['type']='pie';
		$result['legend']['position']='right';	
		$result['size']['height']='350';
		$result['pie']['width']='70';	
		$result['admin'] = $emp_alias;
		if($query){$resCode='0'; $resMsg='Successfull!';}else{$resCode='4'; $resMsg='No Records Found';}
	}elseif($chk==1){$resCode='1';$resMsg='Authentication Failed!';
	}else{$resCode='2';$resMsg='Account Locked!';}
	$result['ErrorDetails']['ErrorCode']=$resCode;$result['ErrorDetails']['ErrorMessage']=$resMsg;
	echo json_encode($result);
}
function level_count($level_alias){ global $mr_con;
	$s=mysqli_query($mr_con,"SELECT COUNT(id) AS num FROM ec_tickets WHERE level='$level_alias' AND flag=0");
	$s_row=mysqli_fetch_array($s);
	$level_count=$s_row['num'];
	return $level_count;
}