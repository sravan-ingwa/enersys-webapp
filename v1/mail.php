<?php
include('functions.php');
$to = $_REQUEST['send']; $xx = $_REQUEST['x']; $yy = $_REQUEST['y'];
if(menuName($xx,"menu") =='tickets'){$sub = ucfirst(menuName($xx,"menu"))." - ".ticketGetNumber($yy)." - ".date("d-m-Y");}
else{$sub = ucfirst(menuName($xx,"menu"))." - ".$yy." - ".date("d-m-Y");}


	$tableName= menuName($xx,"tbName");
	$menuName= menuName($xx,"menu");
	$query = mysql_query("SELECT colName,colRef FROM ss_col_ref WHERE tbName='$tableName' AND pExport='0'ORDER BY ordering");
	if(mysql_num_rows($query)>0){$colName=array();$colref=array();
		while($row=mysql_fetch_array($query)){$colName[]=$row['colName'];$colref[]=$row['colRef'];}
		$query = mysql_query("SELECT * FROM $tableName WHERE id='".$yy."' AND  flag='0'");
		if(mysql_num_rows($query)>0){
			while($row=mysql_fetch_array($query)){
				for($af=0;$af<count($colName);$af++){
					if($row[$colName[$af]]!=""){
						$strContent[]=$colref[$af];
						$strContent1[]=refname($colref[$af],$row[$colName[$af]],$row['id']);
					}
				}
			}
		}
	}
$strContentx.="<h3 style='background:#2a6496;color:#FFF;padding:0 5px;line-height:30px;text-transform:capitalize;'>".$menuName."</h3>";
$strContentx.="<table border='1' style='border-collapse:collapse;width:100%;' width='100%'>";
 	$c=count($strContent);
for($a=0;$a<$c;$a++){
	$strContentx.="<tr>";
	for($b=$a;$b<=$a+1;$b++){
			$strContentx.="<td style='padding:5px;text-align:justify;'>";
			$strContentx.="<h4 style='display:block;color:#2a6496;font-weight:bold;margin:0;padding:1px;'>".$strContent[$b]."</h4>";
			$strContentx.="<p style='margin:0;padding:1px;'>".$strContent1[$b]."</p></td>";
	}
$a++;
	$strContentx.="</tr>";
}
$strContentx.="</table>";

$from = 'feedback@enersys.co.in';
$header= 'From: EnerSys Care <'.$from.'>' . "\r\n".
$header.= 'Reply-To: '.$from ."\r\n" .
$header.= "Content-Type: text/html\r\n";
$header.= "X-Mailer: PHP/" . phpversion();
$header.= 'MIME-Version: 1.0' . "\r\n";
//echo '<div class="alert alert-success" role="alert">Mail Successfully Sent to '.$to.'</div>';
mail($to, $sub, $strContentx, $header);

?>