<?
include ('../mysql.php');
include ('../functions.php');
//$mailIds=array('sudhakararaju@enersys.co.in','madan@enersys.co.in','varaprasad@enersys.co.in','sivakumar.p@enersys.co.in','rameshbabu@enersys.co.in','anandak@enersys.co.in','ravikanthp@enersys.co.in','service@enersys.co.in','neeraj@enersys.co.in','fieldasset@enersys.co.in');
$nhs_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='WIMYJFDJPT' AND flag=0");
$zhs_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='OX5E3EMI0U' AND flag=0");
$sereng_query=mysqli_query($mr_con,"SELECT email_id FROM ec_employee_master WHERE privilege_alias='3WDRECJ0MA' AND flag=0");
while($nhs_row=mysqli_fetch_array($nhs_query)){$mailIds[]=$nhs_row['email_id'];}
while($zhs_row=mysqli_fetch_array($zhs_query)){$mailIds[]=$zhs_row['email_id'];}
while($sereng_row=mysqli_fetch_array($sereng_query)){$mailIds[]=$sereng_row['email_id'];}
if(count($mailIds)>'0'){$mail_Id=implode(", ",array_unique($mailIds));}else $mail_Id="jagan@mymgs.com";//$mail_Id="fieldasset@enersys.co.in";
$_REQUEST['a']="MZIEIOHYS8";
$alias=$_REQUEST['a'];



//$from='fieldasset@enersys.co.in';
$from = all_from_mail();
$headers = "From: EnerSys Inventory<".$from.">\r\n";
$headers.= "Reply-To: ".$from."\r\n";
$headers.= "Return-Path: ".$from."\r\n";
//$headers.= "CC: ".$ccemail."\r\n";
$headers.="Content-Type: text/html\r\n";
$headers.="X-Mailer: PHP/" . phpversion();
$headers.="MIME-Version: 1.0\r\n";
$admin="-odb -f $from";
//mail($mail_Id, $sub, $body, $headers, $admin);
