<?php	
function hix($hx,$hx1){
	if($hx=='1'){if (strpos($hx1, '@') !== false){return "class='hidden-xs hidden-sm nocap'";}else{return "class='hidden-xs hidden-sm'";}}
	else{if(strpos($hx1, '@') !== false){return "class='nocap'";}}
}
$tb= menuName($_REQUEST['x'],"tbName");
$empId=loginDetails($_SESSION['login_user'],"empId");
$emprole=loginDetails($_SESSION['login_user'],"role");
$mainName=menuName($_REQUEST['x'],"mainMenu");
$menuF=menuName($_REQUEST['x'],"menu");
$query = mysql_query("SELECT colName,colRef,pSpl FROM ss_col_ref WHERE tbName='$tb' AND pTable='0' ORDER BY ordering");
if(mysql_num_rows($query)>0){while($row=mysql_fetch_array($query)){$colName[]=$row['colName'];$colref[]=$row['colRef'];$pSpl[]=$row['pSpl'];}}
if($mainName !="Settings"){
	$cheq= mysql_query("SHOW COLUMNS FROM $tb LIKE '%circle%'");
	if(mysql_num_rows($cheq)){$rowcheq=mysql_fetch_assoc($cheq);
		if($rowcheq['Field'] == "circle" || $rowcheq['Field'] == "circles"){
			$query=mysql_query("SELECT circle FROM  ss_employee_details WHERE employeeId='$empId'");
			if(mysql_num_rows($query)>0){$row=mysql_fetch_array($query);$circle=$row['circle'];}			
			$finalcircle=explode(", ",$circle);
			$circle = implode("|",$finalcircle);
		if($rowcheq['Field'] == "circle"){$query=mysql_query("SELECT * FROM  $tb WHERE circle RLIKE '$circle'");}
		if($rowcheq['Field'] == "circles"){$query=mysql_query("SELECT * FROM  $tb WHERE circles RLIKE '$circle'");}
		}else{$query=mysql_query("SELECT * FROM  $tb");}
	}else{$query=mysql_query("SELECT * FROM  $tb");}
}else{$query=mysql_query("SELECT * FROM  $tb");}
if(mysql_num_rows($query)>0){while($row=mysql_fetch_array($query)){$id.="'".$row['id']."',";}$id=rtrim($id,",");}else{$id=0;}
if($id!='0'){
$empcheck=mysql_query("SELECT designation FROM ss_employee_details WHERE employeeId='$empId'");
$rowcheck=mysql_fetch_array($empcheck);
$adeg=$rowcheck['designation'];

if($rowcheck['designation']==designationGetId('ZONAL TEAM')){ 
	if($mainName=="tickets"){$queryx=mysql_query("SELECT * FROM $tb WHERE id IN ($id) AND flag='0' ORDER BY createdDate DESC");}
	elseif($menuF=="User Roles"){$queryx=mysql_query("SELECT * FROM $tb WHERE id IN ($id) AND flag='0' GROUP BY roleId");}
	elseif($menuF=="Revival" || $menuF=="Refreshing"){$queryx=mysql_query("SELECT * FROM $tb WHERE id IN ($id) AND flag='0' GROUP BY capacity");}
	else{$queryx=mysql_query("SELECT * FROM $tb WHERE id IN ($id) AND flag='0'");}
}
elseif($rowcheck['designation']==designationGetId('NATIONAL HEAD SERVICE')){
	if($mainName=="tickets"){$queryx=mysql_query("SELECT * FROM $tb WHERE id IN ($id) AND flag='0' AND checkStat='3' ORDER BY createdDate DESC");}
	elseif($menuF=="User Roles"){$queryx=mysql_query("SELECT * FROM $tb WHERE id IN ($id) AND flag='0' GROUP BY roleId");}
	elseif($menuF=="Revival" || $menuF=="Refreshing"){$queryx=mysql_query("SELECT * FROM $tb WHERE id IN ($id) AND flag='0' GROUP BY capacity");}
	else{$queryx=mysql_query("SELECT * FROM $tb WHERE id IN ($id) AND flag='0'");}
}
else{
	if($mainName=="tickets"){$queryx=mysql_query("SELECT * FROM $tb WHERE id IN ($id) AND flag='0' ORDER BY createdDate DESC");}
	elseif($menuF=="User Roles"){$queryx=mysql_query("SELECT * FROM $tb WHERE id IN ($id) AND flag='0' GROUP BY roleId");}
	elseif($menuF=="Revival" || $menuF=="Refreshing"){$queryx=mysql_query("SELECT * FROM $tb WHERE id IN ($id) AND flag='0' GROUP BY capacity");}
	else{$queryx=mysql_query("SELECT * FROM $tb WHERE id IN ($id) AND flag='0'");}
}

	if(mysql_num_rows($queryx)>0){
		$result="<table class='tablesorter table-responsive' id='tblExport'><thead><tr>";
		for($abc=0;$abc<count($colref);$abc++){
			if($colref[$abc]=='Visit Planned' || $colref[$abc]=='TAT'){$result.="<th class='filter-select filter-exact hidden-xs hidden-sm' data-placeholder='' > ".$colref[$abc]."</th>";}
			else $result.="<th ".hix($pSpl[$abc],'')." > ".$colref[$abc]."</th>";
		}
		$result.='<th width="100px">Options</th></tr></thead><tbody align="center">';$coo=0;
		while($row=mysql_fetch_array($queryx)){
			$result.="<tr>";
			for($af=0;$af<count($colName);$af++){$result.="<td ".hix($pSpl[$af],$row[$colName[$af]]).">".refname($colref[$af],$row[$colName[$af]],$row['id'])."</td>";}
			$result.='<td class="operations">
			<span class="actionsc">';

				if(serviceAccess($loginRole,$_REQUEST['x'],'View')){$result.='<a href="view.php?y='.$row['id'].'&x='.$_REQUEST['x'].'" class="tooltips" data-placement="top" title="View"><i class="glyphicon glyphicon-eye-open"></i></a>';}
				if(serviceAccess($loginRole,$_REQUEST['x'],'Edit')){
					if($row['checkStat']!="5"){
						if($adeg==designationGetId('ZONAL TEAM') && $row['checkStat']=="2"){
							if(serviceAccess($loginRole,$_REQUEST['x'],'Edit')){$result.='<a href="edit.php?y='.$row['id'].'&x='.$_REQUEST['x'].'"  class="tooltips" data-placement="top" title="Approve"><i class="glyphicon glyphicon-off"></i></a>';}
						}
						elseif($adeg==designationGetId('NATIONAL HEAD SERVICE') && $row['checkStat']=="3"){
							if(serviceAccess($loginRole,$_REQUEST['x'],'Edit')){$result.='<a href="edit.php?y='.$row['id'].'&x='.$_REQUEST['x'].'"  class="tooltips" data-placement="top" title="Approve"><i class="glyphicon glyphicon-off"></i></a>';}
						}
						else{
							if($row['checkStat']=="0"){
								if(serviceAccess($loginRole,$_REQUEST['x'],'Edit')){$result.='<a href="edit.php?y='.$row['id'].'&x='.$_REQUEST['x'].'"  class="tooltips" data-placement="top" title="Activate"><i class="glyphicon glyphicon-plane"></i></a>';}
							}
							elseif($row['checkStat']=="1" || $row['checkStat']=="4"){
								if(serviceAccess($loginRole,$_REQUEST['x'],'Edit')){$result.='<a href="edit.php?y='.$row['id'].'&x='.$_REQUEST['x'].'"  class="tooltips" data-placement="top" title="Close"><i class="glyphicon glyphicon-off"></i></a>';}
							}
						}
					}
				}
				/*if(serviceAccess($loginRole,$_REQUEST['x'],'Delete')){$result.='<a data-conttent="'.$_REQUEST['x'].'-'.$row['id'].'" class="tooltips" data-toggle="confirmation-popout" id="'.$_REQUEST['x'].'-'.$row['id'].'" data-placement="left" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>';}*/
				if(serviceAccess($loginRole,$_REQUEST['x'],'Export')){$result.='<a href="download.php?x='.$_REQUEST['x'].'&y='.$row['id'].'" target="_blank" class="tooltips" data-placement="top" title="Download"><span class="glyphicon glyphicon-download-alt"></span></a>';}						

			$result.='</span></td></tr>';
$coo++;}
		$result.='</tbody>
		</table>
		<table class="tablesorter table-responsive" style="width:100%;margin-top:-10px;">
			<tfoot>	
				<tr>
					<th class="ts-pager form-horizontal">
						<button type="button" class="btn first btn-primary"><i class="icon-step-backward glyphicon glyphicon-step-backward"></i></button>
						<button type="button" class="btn prev btn-primary"><i class="icon-arrow-left glyphicon glyphicon-backward"></i></button>
						<span class="pagedisplay"></span> <!-- this can be any element, including an input -->
						<button type="button" class="btn next btn-primary"><i class="icon-arrow-right glyphicon glyphicon-forward"></i></button>
						<button type="button" class="btn last btn-primary"><i class="icon-step-forward glyphicon glyphicon-step-forward"></i></button>
						<div class="hidden-xs" style="display:inline-block;">
						<span> Page Size: </span>
						<select class="pagesize input-mini" title="Select page size">
						<option selected="selected" value="10">10</option>
						<option value="20">20</option>
						<option value="30">30</option>
						<option value="40">40</option>
						<option value="'.$coo.'">ALL</option>
						</select><span> Page Number : </span>
						<select class="pagenum input-mini" title="Select page number"></select>
						<div>
					</th>
				</tr>
			</tfoot>
		</table>';
	}else{$result='<p style="text-align:center;padding:10px;color:red;">No Records Found!</p>';}
}else{$result='<p style="text-align:center;padding:10px;color:red;">No Records Found!</p>';}	
