<style>
html,body{width:100%;}
.table1{border-collapse:collapse;width:90%;height:950px;}
.td1{
	border:7px double #000;height:100%;width:90%;height:950px;vertical-align:top; 
}
.table2{border-collapse:collapse;width:100%;height:100%;}
.td2{
	border:7px double #000;height:100%;width:100%;vertical-align:top; 
}
.tableHeader{
	border-bottom:1px solid #d1d1d1;
	margin-bottom:5px;
}
.cont_1{
	width:740px;
	border-bottom:2px solid #212121;
	padding:3px 5px;
	font-weight:700;
	font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;
	margin:6px 5px;
}
.cont_2{
	width:740px;
	padding:4px 5px;
	margin:0px 5px;
	font-weight:700;
	font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;
	font-size:11px;
	vertical-align:top;
}
.cont_3{
	width:740px;
	border-bottom:2px solid #212121;
	background:#2a6496;
	color:#FFF;
	padding:3px 5px;
	font-weight:700;
	font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;
	margin:5px 5px 0px 5px;
	font-size:12px;
}
.cont_2 h3{color:#428bca;}
.cont_2 p{font-size:10px; font-weight:300;}
.cont_3 h3{background-color:#428bca; color:#fff;}
.botable{border-collapse:collapse;font-size:12px;width:740px;}
.botable thead th{background:#2a6496; color:#FFF;padding:5px;}
.botable td, .botable th{border:1px solid #d1d1d1;padding:3px;}
.subhead td{padding:3px;text-align:center;}
</style>
<?php
include('../mysql.php');
include('../functions.php');
$privilege_alias = $_REQUEST['alias'];
$heading = 'PRIVILEGES';
	$result = $result1 = array();
	$prv_arr=array("DASH BOARD","PLANNER","SPOT TICKETS","TICKETS","SITEMASTER","EMPLOYEE MASTER","EXPENSE TRACKER","FIELD ASSET MANAGEMENT","TRACKING SYSTEM","DYNAMIC TABS","IMEI ACT DEACT", "SETTINGS", "MASTERS", "PASSWORD MANAGEMENT");
	$dash_arr=array("TICKET STATUS","CUSTOMER PULSE","TODAYS INFO REPORT BLOCK","TAT","MONTHLY ANALYSIS","NATURE OF ACTIVITY","FAULT ANALYSIS","PRODUCT CONTRIBUTION IN FAILURE","MANUFACTURE MONTH WISE FAILURE");
	$fam_arr=array("MATERIAL BALANCE","MATERIAL INWARD","MATERIAL OUTWARD","MATERIAL REQUEST","REVIVAL","REFRESHING","SJO SEARCH","STOCKS");
	$settingsArr = array("EMAIL & SMS RECIPIENT", "BUCKETS","EMPLOYEE ROLES", "LEVELS", "PRIVACY POLICY", "DROPDOWNS", "SEGMENTS", "STOCK CODES");
	$mastersArr = array("ACCESSORIES", "ALLOWANCES", "APPROVERS", "ASSETS", "COMPLAINTS", "CUSTOMERS", "DEPARTMENTS", "DESIGNATIONS", "DISTRICTS", "DPR CATEGORIES",   "ESCA", "FAULTY CODES", "LIMITS", "MILESTONES", "MOC", "PRIVILEGES", "PRODUCTS", "SITE TYPES", "STATES", "SHIFTS", "WAREHOUSES", "WORK GUIDES", "ZONES", "ACTIVITIES",  "CHANGE LOG", "DYNAMIC LEVELS", "MANUALS");
	foreach($prv_arr as $prv){
		if($prv=="DASH BOARD")$head=array("PRIVILEGE ITEM","VIEW","SPECIAL");
		elseif($prv=="SPOT TICKETS")$head=array("PRIVILEGE ITEM","VIEW","EDIT","EXPORT","SPECIAL", "DELETE");
		elseif($prv=="TICKETS")$head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","EXPORT","PD","ZHS","NHS","TS","SPECIAL", "DELETE", "TRANSFER EFSR");
		elseif($prv=="TRACKING SYSTEM")$head=array("PRIVILEGE ITEM","VIEW","VIEW ALL","EXPORT","SPECIAL");
		elseif($prv=="FIELD ASSET MANAGEMENT")$head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","EXPORT","SPECIAL","STOCK","DELETE", "ADV EDIT");
		elseif($prv=="DYNAMIC TABS")$head=array("PRIVILEGE ITEM","TICKETS","APPROVALS","DPR","SPECIAL");
		elseif($prv=="IMEI ACT DEACT")$head=array("PRIVILEGE ITEM","VIEW","ACTIVATION","DEACTIVATION","EXPORT","SPECIAL");
		elseif($prv=="EMPLOYEE MASTER")$head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","IMPORT", "EXPORT","SPECIAL","DELETE", "RESTORE");
		elseif($prv=="SITEMASTER")$head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","EXPORT","SPECIAL","DELETE", "RESTORE");
		elseif($prv=="PLANNER")$head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","EXPORT","SPECIAL","DELETE");
		elseif($prv=="REVIVAL")$head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","EXPORT","SPECIAL","DELETE");
		elseif($prv=="REFRESHING")$head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","EXPORT","SPECIAL","DELETE");
		elseif($prv=="EXPENSE TRACKER")$head=array("PRIVILEGE ITEM","VIEW","VIEW ALL","ADD","EDIT","EXPORT","SPECIAL","DELETE", "MAPPING");
		elseif($prv=="STOCKS")$head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","EXPORT","SPECIAL","DELETE");
		elseif($prv=="SETTINGS")$head=array("PRIVILEGE ITEM","VIEW","EDIT","EXPORT");
		elseif($prv=="MASTERS")$head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","EXPORT","DELETE");
		elseif($prv=="PASSWORD MANAGEMENT")$head=array("PRIVILEGE ITEM","SPCL");
		else $head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","EXPORT","SPECIAL"); //PLANNER,SITEMASTER,EMPLOYEE_MASTER,EXPENSE_TRACKER,REMAINING_All

		if($prv=="DASH BOARD"){foreach($dash_arr as $b=>$dash)$result[$prv]['sub'][$b]=$dash;$result[$prv]['head']=$head;}
		elseif($prv=="FIELD ASSET MANAGEMENT"){foreach($fam_arr as $c=>$fam)$result[$prv]['sub'][$c]=$fam;$result[$prv]['head']=$head;}
		elseif($prv=="SETTINGS") {
			foreach($settingsArr as $c=>$setting) {
				$result[$prv]['sub'][$c]=$setting;
				$result[$prv]['head']=$head;
			}
		} elseif($prv=="MASTERS") {
			foreach($mastersArr as $c=>$master) {
				$result[$prv]['sub'][$c]=$master;
				$result[$prv]['head']=$head;
			}
		} 
		else {$result[$prv]['sub'][0]=$prv;$result[$prv]['head']=$head;}
	}
	
	$sql=mysqli_query($mr_con,"SELECT privilege_name,privilege_alias, privilege_item, privilege_type, grantable FROM ec_privileges WHERE privilege_alias='$privilege_alias' AND flag='0' ORDER BY privilege_item");
	if(mysqli_num_rows($sql)){
		while($row=mysqli_fetch_array($sql)){
			$result1['name']=$row['privilege_name'];
			$result1['alias']=$row['privilege_alias'];
			$result1[$row['privilege_item']][$row['privilege_type']]=$row['grantable'];
		}
	}
	
 	$print='<html><body>
				<table class="tableHeader" width="100%">
					<tr>
						<td align="left" width="35%"><img src="../../images/gallery/logo1.png"></td>
						<td align="center" width="50%"><h2>'.$heading.'<h2></ td>
						<td align="right" width="35%"><img src="../../images/gallery/logo-4.jpg" width="100px"></td>
					</tr>
				</table>
				<table class="cont_3">
					<tr>
						<td align="left">'.strtoupper($heading).'</td>
					</tr>
				</table>';
	if(count($result1)){
		foreach($result as $key=>$data){
			
			//Main head ex: DASH BOARD etc..
			$print .= "<h3 style='background-color:#179243; color:#FFF;padding:5px;'>$key</h3>";
			
			//Sub head ex: PRIVILEGE ITEM and VIEW and ADD etc..
			$print .= "<table class='table table-hover' cellpadding='7'><thead><tr style='background-color:#2A6496;'>";
				foreach($data['head'] as $key1=>$crud)$print .= "<th style='color:#ffffff'>$crud</th>";
			$print .= "</tr></thead><tbody>";
			//Sub head ex: TICKETS and CHECKBOXES etc..
				foreach($data['sub'] as $key2=>$sub){
					$print .= "<tr>";
					$print .= "<td><span tooltip-placement='top' tooltip='".$sub."'>".$sub."</span></td>";
						foreach($data['head'] as $key3=>$crud)if($key3!=0)$print.="<td align='center'><img src='".baseurl()."images/gallery/".($result1[$sub][$crud]==1 ? "checked":"empty")."_check.png' width='40px' height='40px'></td>";
					$print .= "</tr>";
				}
			$print .= "</tbody></table><br><br>";
		}
	}else $print.='<h2 style="text-align:center">No Records<h2>';
		$print.='</body></html>';
	echo $print;
	echo "<script>window.print();</script>";
	echo "<script> window.history.back(); </script>";
?>
