<?php /*?>echo "<script>alert('".$rowzd[$fv1]."');</script>";<?php */?>
<?php
include("functions.php");
function getIds($fv1,$fv2,$tbx){
	$temp2=array();
	$chekid = mysql_query("SELECT searchTbName,searchColName,searchColName2 FROM ss_col_ref WHERE colName='$fv1' AND tbName='$tbx' AND searchRef='1' ORDER BY ordering");
	if(mysql_num_rows($chekid)>0){
		while($chekid_row=mysql_fetch_array($chekid)){
			$tb1=$chekid_row['searchTbName'];
			$searchColName = $chekid_row['searchColName'];
			$searchColName2 = $chekid_row['searchColName2'];
				$sqlz=mysql_query("SELECT * FROM $tb1 WHERE $searchColName LIKE '$fv2%' AND flag=0");
				while($rowz=mysql_fetch_array($sqlz)){
					$temp2[]=$rowz[$searchColName2];
				}
		}
		if(count($temp2)>0){$ee=implode("|",$temp2);}else{$ee=$fv2;}
	}else{$ee=$fv2;}
	return $ee;	
}

$xaa="";

function hix($hx,$hx1){
	if($hx=='1'){if (strpos($hx1, '@') !== false){return "class='hidden-xs hidden-sm nocap'";}else{return "class='hidden-xs hidden-sm'";}}
	else{if(strpos($hx1, '@') !== false){return "class='nocap'";}}
}
$tb= "ss_tickets";
$tblHead_query = mysql_query("SELECT colName,colRef,pSpl FROM ss_col_ref WHERE tbName='$tb'  AND pMobile='0' ORDER BY ordering");
if(mysql_num_rows($tblHead_query)>0){while($tblHead_row=mysql_fetch_array($tblHead_query)){$colName[]=$tblHead_row['colName'];$colref[]=$tblHead_row['colRef'];$pSpl[]=$tblHead_row['pSpl'];}}
for($xz=0;$xz<count($colName);$xz++){if($_REQUEST[$colName[$xz]]==""){$fv[]=$_REQUEST[$colName[$xz]];}else{$fv[]=getIds($colName[$xz],$_REQUEST[$colName[$xz]],$tb);}}
for($xz=0;$xz<count($colName);$xz++){if($fv[$xz]!=""){$xaa.=$colName[$xz]." RLIKE '".$fv[$xz]."' AND ";}}
$mainName=menuName(ss_tickets,"mainMenu");
$menuF=menuName(ss_tickets,"menu");
$urlx="index.php?x=".ss_tickets."";
$rec_limit = 30;
$sql="SELECT count(id) FROM ss_tickets";
$retval = mysql_query($sql);
if(!$retval){die('Could not get data: ' . mysql_error());}
$row = mysql_fetch_array($retval, MYSQL_NUM );
$rec_count = $row[0];
//$aps=$_REQUEST['page_no'];
$aps=1;
if($aps!="all"){$page = ($aps-1);if($page<0){$page=0;} $offset = $rec_limit * $page ;}
else{$page = 0;$offset = $rec_limit * $page ;}
$left_rec=$rec_count-($page*$rec_limit);
if($mainName=="tickets"){$tblBody_query=mysql_query("SELECT * FROM $tb WHERE $xaa flag='0' ORDER BY createdDate DESC LIMIT $offset, $rec_limit");}
elseif($menuF=="User Roles"){$tblBody_query=mysql_query("SELECT * FROM $tb WHERE $xaa flag='0' GROUP BY roleId LIMIT $offset, $rec_limit");}
elseif($menuF=="Revival" || $menuF=="Refreshing"){$tblBody_query=mysql_query("SELECT * FROM $tb WHERE $xaa flag='0' GROUP BY capacity LIMIT $offset, $rec_limit");}
else{$tblBody_query=mysql_query("SELECT * FROM $tb WHERE $xaa flag='0' LIMIT $offset, $rec_limit");}
if(mysql_num_rows($tblBody_query)>0){

	$result.= '{"ErrorDetails":{"ErrorCode":0,"ErrorMessage":"Success"},"ticket":[';
	while($row = mysql_fetch_array($tblBody_query, MYSQL_ASSOC)){
		$resulth.="{";
			for($af=0;$af<count($colName);$af++){
					$resulths.='"'.strtolower($colName[$af]).'":"'.refname($colref[$af],$row[$colName[$af]],$row['id']).'",';
			}$cxx++;
			$resulth .= rtrim($resulths,",");
		$resulth.="},";
	}
	$result .= rtrim($resulth,",");
	$result.="]}";
}
echo $result;
?>
