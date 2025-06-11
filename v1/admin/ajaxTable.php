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
$tb= menuName($_REQUEST['x'],"tbName");
$tblHead_query = mysql_query("SELECT colName,colRef,pSpl FROM ss_col_ref WHERE tbName='$tb' AND pTable='0' ORDER BY ordering");
if(mysql_num_rows($tblHead_query)>0){while($tblHead_row=mysql_fetch_array($tblHead_query)){$colName[]=$tblHead_row['colName'];$colref[]=$tblHead_row['colRef'];$pSpl[]=$tblHead_row['pSpl'];}}
for($xz=0;$xz<count($colName);$xz++){
	//$fv[]=$_REQUEST[$colName[$xz]];

	if($_REQUEST[$colName[$xz]]==""){$fv[]=$_REQUEST[$colName[$xz]];}
	else{$fv[]=getIds($colName[$xz],$_REQUEST[$colName[$xz]],$tb);}

}
for($xz=0;$xz<count($colName);$xz++){if($fv[$xz]!=""){$xaa.=$colName[$xz]." RLIKE '".$fv[$xz]."' AND ";}}
$mainName=menuName($_REQUEST['x'],"mainMenu");
$menuF=menuName($_REQUEST['x'],"menu");
$urlx="index.php?x=".$_REQUEST['x']."";

$rec_limit = $_REQUEST['countt'];
$sql="SELECT count(id) FROM $tb WHERE $xaa flag='0'";
$retval = mysql_query($sql);
if(!$retval){die('Could not get data: ' . mysql_error());}
$row = mysql_fetch_array($retval, MYSQL_NUM );
$rec_count = $row[0];

if($_REQUEST['PageV']!="all"){$page = ($_REQUEST{'PageV'}-1);if($page<0){$page=0;} $offset = $rec_limit * $page ;}
else{$page = 0;$offset = $rec_limit * $page ;}
$left_rec=$rec_count-($page*$rec_limit);


if($mainName=="tickets"){$tblBody_query=mysql_query("SELECT * FROM $tb WHERE $xaa flag='0' ORDER BY createdDate DESC LIMIT $offset, $rec_limit");}
elseif($menuF=="User Roles"){$tblBody_query=mysql_query("SELECT * FROM $tb WHERE $xaa flag='0' GROUP BY roleId LIMIT $offset, $rec_limit");}
elseif($menuF=="Revival" || $menuF=="Refreshing"){$tblBody_query=mysql_query("SELECT * FROM $tb WHERE $xaa flag='0' GROUP BY capacity LIMIT $offset, $rec_limit");}
else{$tblBody_query=mysql_query("SELECT * FROM $tb WHERE $xaa flag='0' LIMIT $offset, $rec_limit");}
if(mysql_num_rows($tblBody_query)>0){
$cxx=0;
	while($row = mysql_fetch_array($tblBody_query, MYSQL_ASSOC)){
		$result.="<tr align='center'>";
		for($af=0;$af<count($colName);$af++){$result.="<td ".hix($pSpl[$af],$row[$colName[$af]]).">".refname($colref[$af],$row[$colName[$af]],$row['id'])."</td>";}
			$result.='<td class="operations">
			<span class="actionsc">';
				$loginRole=loginDetails($_SESSION['login_user'],"role");
				$result.='<a target="_blank" href="view.php?y='.$row['id'].'&x='.$_REQUEST['x'].'" title="View"><i class="glyphicon glyphicon-eye-open"></i></a>';
				if($_REQUEST['x'] != 5484){
					//if($row['designation']!='NATIONAL HEAD SERVICE' && $row['designation']!='ZONAL TEAM' && $row['stat']<'2'){
						if($_REQUEST['x']==6643 || $_REQUEST['x']==8865){
							if($row['stat']<2){ 
								$result.='<a target="_blank" href="edit.php?y='.$row['id'].'&x='.$_REQUEST['x'].'"  title="Approve"><i class="glyphicon glyphicon-off"></i></a>';}
							}
						elseif($_REQUEST['x']==4592){
							if($row['stat']<3){
								$result.='<a target="_blank" href="edit.php?y='.$row['id'].'&x='.$_REQUEST['x'].'"  title="Approve"><i class="glyphicon glyphicon-off"></i></a>';}
							}
						elseif($_REQUEST['x']==2432){
							if(isset($row['checkStat']) && $row['checkStat']!="5"){
								if(isset($row['ticketType']) && $row['ticketType']=='Inactive'){$result.='<a target="_blank" href="edit.php?y='.$row['id'].'&x='.$_REQUEST['x'].'" title="Activate"><i class="glyphicon glyphicon-plane"></i></a>';}
								elseif($row['ticketStatus']!='Closed'){$result.='<a target="_blank" href="edit.php?y='.$row['id'].'&x='.$_REQUEST['x'].'"  title="Close"><i class="glyphicon glyphicon-off"></i></a>';}
							}
						}elseif($_REQUEST['x']==4323){
							if(isset($row['mrfStatus']) && $row['mrfStatus']=="Open"){
								$result.='<a target="_blank" href="edit.php?y='.$row['id'].'&x='.$_REQUEST['x'].'" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>';
							}
						}else{ $result.='<a target="_blank" href="edit.php?y='.$row['id'].'&x='.$_REQUEST['x'].'"  title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>'; }
						$result.='<a class="popconfirm test-jquery-click" data="'.$_REQUEST['x'].'-'.$row['id'].'" data-toggle="confirmation-popout" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>';
					//}
				}
				$result.='<a href="download.php?x='.$_REQUEST['x'].'&y='.$row['id'].'" target="_blank" title="Download"><span class="glyphicon glyphicon-download-alt"></span></a>';					
			$result.='</span></td></tr>';
		$cxx++;
	}
}else{die('<tr><td colspan="'.(count($colName)+1).'" class=="minx"><h4 align="center">No Records</h4></td></tr>');}
$vountt='<option value="">[Page No.]</option>';
if(is_float($rec_count/$rec_limit)){$axxa=round($rec_count/$rec_limit)+1;}else{$axxa=$rec_count/$rec_limit;}
for($fxx=1;$fxx<=($axxa);$fxx++){$vountt.='<option value="'.$fxx.'" '.selectz($fxx,($page+1)).' >Page '.$fxx.'</option>';}
echo $result."##".$page."##".$vountt;
function selectz($fc1,$fc2){if($fc1==$fc2)return "selected";}
?>
<script>
$(function() {
    $(".test-jquery-click").click(function() {
        $.ajax({type: "POST",url: "delete.php",data: "del=" + $(this).attr("data"),cache: false,success: function(e) {
                document.getElementById("myText").innerHTML = "<div class='alert alert-success' role='alert'>Successfully Deleted</div>";
                setTimeout(function() {
                    window.location = "index.php?x=" + e
                }, 1e3)
            }})
    })
    $(".tooltips").tooltip();
	$(".popconfirm").popConfirm({popout: true});
});
</script>
<script type="text/javascript">
    var is_touch_device = 'ontouchstart' in document.documentElement;
    if(is_touch_device) $(".actionsc").fadeIn(300);
</script>