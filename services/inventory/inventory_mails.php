<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
$emp_email_id=$_REQUEST['emp'];
if($_REQUEST['type']=='0') material_outward($_REQUEST['x']);
function material_outward($ta){ global $mr_con;global $emp_email_id;
	$to = alias($emp_email_id,'ec_employee_master','employee_alias','email_id');
$rec=mysqli_query($mr_con,"SELECT count(id) FROM ec_material_outward WHERE $condtion flag=0 AND from_wh IN ($whouse)");
if(mysqli_num_rows($rec)>0){
$row=mysqli_fetch_array($rec);
}
	//$ccemail= "inventory@enersys.co.in, anandak@enersys.co.in, govindarajulu@enersys.co.in, service@enersys.co.in";
	$ccemail= "inventory@enersys.co.in";
	$sub = "New Material Outward".date("d-m-Y");
	$body="<p>Dear Name,</p>";
	$body.="<p>New Material Has been Sent</p>";
	$body.="<p style='font-style:italic;font-size:12px;'>*** This is a System generated email, Please do not reply ***</p>";
	//$from = 'inventory@enersys.co.in';
	$from = all_from_mail();
	$header= 'From: EnerSys Inventory<'.$from .'>' . "\r\n";
	$header.= 'Cc:'.$ccemail."\r\n";
	$header.= 'Reply-To: '.$from ."\r\n";
	$header.= "Content-Type: text/html\r\n";
	$header.= "X-Mailer: PHP/" . phpversion();
	$header.= 'MIME-Version: 1.0' . "\r\n";
	$admin = "-odb -f $from";
	$abc = mail($to, $sub, $body, $header, $admin);
	if($abc)return TRUE;else return FALSE;
}
