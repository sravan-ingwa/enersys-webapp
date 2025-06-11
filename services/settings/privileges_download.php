<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
include('../mpdf60/mpdf.php');
$stylesheet = file_get_contents('../../styles/pdf_style.css');
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
		elseif($prv=="SPOT TICKETS")$head=array("PRIVILEGE ITEM","VIEW","EDIT","EXPORT","SPECIAL");
		elseif($prv=="TICKETS")$head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","EXPORT","PD","ZHS","NHS","TS","SPECIAL", "DELETE", "TRANSFER EFSR");
		elseif($prv=="TRACKING SYSTEM")$head=array("PRIVILEGE ITEM","VIEW","VIEW ALL","EXPORT","SPECIAL");
		elseif($prv=="FIELD ASSET MANAGEMENT")$head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","EXPORT","SPECIAL","STOCK","DELETE", "ADV EDIT");
		elseif($prv=="DYNAMIC TABS")$head=array("PRIVILEGE ITEM","TICKETS","APPROVALS","DPR","SPECIAL");
		elseif($prv=="IMEI ACT DEACT")$head=array("PRIVILEGE ITEM","VIEW","ACTIVATION","DEACTIVATION","EXPORT","SPECIAL");
		elseif($prv=="EMPLOYEE MASTER")$head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","EXPORT","SPECIAL","DELETE", "RESTORE");
		elseif($prv=="SITEMASTER")$head=array("PRIVILEGE ITEM","VIEW","ADD","EDIT","IMPORT", "EXPORT","SPECIAL","DELETE", "RESTORE");
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
	
	
 	$download='<html><body>
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
			$download .= "<h3 style='background-color:#179243; color:#FFF;padding:5px;'>$key</h3>";
			
			//Sub head ex: PRIVILEGE ITEM and VIEW and ADD etc..
			$download .= "<table class='table table-hover' cellpadding='7'><thead><tr style='background-color:#2A6496;'>";
				foreach($data['head'] as $key1=>$crud)$download .= "<th style='color:#ffffff'>$crud</th>";
			$download .= "</tr></thead><tbody>";
			//Sub head ex: TICKETS and CHECKBOXES etc..
				foreach($data['sub'] as $key2=>$sub){
					$download .= "<tr>";
					$download .= "<td><span tooltip-placement='top' tooltip='".$sub."'>".$sub."</span></td>";
						foreach($data['head'] as $key3=>$crud)if($key3!=0)$download.="<td align='center'><img src='".baseurl()."images/gallery/".($result1[$sub][$crud]==1 ? "checked":"empty")."_check.png' width='20px' height='20px'></td>";
					$download .= "</tr>";
				}
			$download .= "</tbody></table><br><br>";
		}
	}else $download.='<h2 style="text-align:center">No Records<h2>';
		$download.='</body></html>';
	
	$mpdf=new mPDF('','', 0, '', 5, 5, 5, 5, '', '2', '');
	$mpdf->SetHTMLFooter("<p style=\"text-align:right;font-style: italic;font-size:12px;\">{PAGENO}/{nbpg}</p>");
	$mpdf->pagenumPrefix = 'Page No : ';
	$mpdf->SetWatermarkImage('../../images/gallery/logo-3.png');
	$mpdf->showWatermarkImage = true;
	$mpdf->watermarkImageAlpha = 0.06;
	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($download,2);
	$filename='Privilegedetails_'.date('d-m-Y_H_i_s');
	$mpdf->Output("$filename.pdf", "I");
	exit;
?>
