<?php
include('mysql.php');
function TitleFav(){
	$comp=mysql_query("SELECT * FROM ss_company_details WHERE status='active'");
	$comprow=mysql_fetch_array($comp);
	echo "<title>Enersys Care</title>";
	echo "<link rel='icon' href='$comprow[favicon]' type='image/png'/>";
}
function empDetails($fv1,$fv2){
	$query=mysql_query("SELECT $fv2 FROM ss_employee_details WHERE email='$fv1'");
	if(mysql_num_rows($query)>0){$row=mysql_fetch_array($query); return $row[$fv2];}
	else{return null;}
}
function columnCheck($fv1,$fv2){$cheq= mysql_query("SHOW COLUMNS FROM $fv1 LIKE '$fv2'");if($cheq)return $checked=(mysql_num_rows($cheq))?true:false; else{return false;}}

function activestate($me1, $state){if($me1 == $state){return("class='active'");}}
function checkstate($me1, $state){if($me1 == $state){return("selected='selected'");}}
function loginDetails($fv,$fw){
	$query = mysql_query("SELECT role,displayName,empId FROM ss_user_details WHERE email='$fv' AND flag='0'");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){
			if($fw=="role")return $row['role'];
			elseif($fw=="name")return $row['displayName'];
			elseif($fw=="empId")return $row['empId'];
			}
	}
}
function serviceAccess($fv1,$fv2,$fv3){
	$query = mysql_query("SELECT * FROM ss_user_role WHERE roleId ='$fv1' AND privilageItem='$fv2' AND privilageType='$fv3' AND  grantable='Yes'");
	if(mysql_num_rows($query)>0){return TRUE;}
}
function menuName($fv,$fw){
	$query = mysql_query("SELECT mainMenu,subMenu,tbName FROM ss_menu WHERE id='$fv' AND flag='0'");
	if(mysql_num_rows($query)>0){
		$row=mysql_fetch_array($query);
		if($fw=="menu"){
			if($row['subMenu']=="")return $row['mainMenu'];
			else{return $row['subMenu'];}
		}
		elseif($fw=="tbName"){return $row['tbName'];}
		elseif($fw=="mainMenu"){return $row['mainMenu'];}
	}
}
function dataTog($fv1){
	$query = mysql_query("SELECT subMenu FROM ss_menu WHERE id='$fv1' AND flag='0'");
	if(mysql_num_rows($query)>0){
	$row=mysql_fetch_array($query);
		if($row['subMenu']!="")return "data-toggle='dropdown'";
	}
}
function mainMenu($fv1,$fv2){
	$query = mysql_query("SELECT mainMenu FROM ss_menu WHERE id='$fv1' AND flag='0'");
	$row=mysql_fetch_array($query);
	$mainm=$row['mainMenu'];
	$query = mysql_query("SELECT * FROM ss_user_role  
	JOIN ss_menu ON ss_user_role.privilageItem=ss_menu.id
	WHERE ss_user_role.roleId ='$fv2' AND ss_user_role.privilageType='View' AND ss_menu.mainMenu<>'Settings' AND  ss_user_role.grantable='Yes' GROUP BY ss_menu.mainMenu ORDER BY ss_menu.ordering");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){
			//if($row['mainMenu'] !="Expense Tracker"){
				echo "<li ".activestate($mainm, $row['mainMenu'])." class='dropdown liWidth'>
						<a href='index.php?x=$row[id]' ".dataTog($row['id'])." class='dropdown-toggle'>$row[mainMenu]</a>
							<ul class='dropdown-menu' role='menu'>";?>
								<?php echo subMenuForXS($row['id'],loginDetails($_SESSION['login_user'],"role")); ?>
							</ul>
				<?php "</li>" ;
			//}
			/*if($row['id'] =="5484"){
				echo"<li class='dropdown liWidth'>
					<a href='http://enersyscare.co.in/enersys_expense/login.php' class='dropdown-toggle' target='_Blank'>Expense Tracker</a>
				</li>";		
			}*/
		}
	}
}
function subMenu($fv1,$fv2){
	$query = mysql_query("SELECT mainMenu,subMenu FROM ss_menu WHERE id='$fv1' AND flag='0'");
	$row=mysql_fetch_array($query);
	$mainm=$row['mainMenu'];$subM=$row['subMenu'];
	$query = mysql_query("SELECT * FROM ss_user_role  
	JOIN ss_menu ON ss_user_role.privilageItem=ss_menu.id
	WHERE ss_user_role.roleId ='$fv2' AND ss_user_role.privilageType='View' AND ss_menu.mainMenu='$mainm' AND ss_menu.subMenu<>''  AND ss_user_role.grantable='Yes' ORDER BY ss_menu.ordering");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<a href='index.php?x=$row[id]' ".activestate($subM, $row['subMenu']).">$row[subMenu]</a>";}
	}
}
function subMenuForXS($fv1,$fv2){
	$query = mysql_query("SELECT mainMenu,subMenu FROM ss_menu WHERE id='$fv1' AND flag='0'");
	$row=mysql_fetch_array($query);
	$mainm=$row['mainMenu'];$subM=$row['subMenu'];
	$query = mysql_query("SELECT * FROM ss_user_role  
	JOIN ss_menu ON ss_user_role.privilageItem=ss_menu.id
	WHERE ss_user_role.roleId ='$fv2' AND ss_user_role.privilageType='View' AND ss_menu.mainMenu='$mainm' AND ss_menu.subMenu<>''  AND ss_user_role.grantable='Yes' ORDER BY ss_menu.ordering");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<li><a href='index.php?x=$row[id]'><p>$row[subMenu]</p></a></li>";}
	}
}
function subMenuDrop($fv2){
	$query = mysql_query("SELECT * FROM ss_user_role  
	JOIN ss_menu ON ss_user_role.privilageItem=ss_menu.id
	WHERE ss_user_role.roleId ='$fv2' AND ss_user_role.privilageType='View' AND ss_menu.mainMenu='Settings' AND ss_menu.subMenu<>''  AND ss_user_role.grantable='Yes' ORDER BY ss_menu.ordering");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<li><a href='index.php?x=$row[id]'><p>$row[subMenu]</p></a></li>";}
	}
}
function explodeEdit($a,$b,$c){
	$z = explode(", ",$a);	$x = explode("_",$b);
	if($x[0] != 'ss'){foreach($z as $y){echo "<option value=".$y." selected='selected'>".$b($y)."</option>";}}
	else{
	$query = mysql_query("SELECT id,".$c." FROM ".$b." WHERE flag='0'");
		if(mysql_num_rows($query)>0){
			while($row=mysql_fetch_array($query)){
				echo "<option value='$row[id]'".(in_array($row['id'],$z) ? 'selected' : '').">$row[$c]</option>";}
		}else{echo "<option value=''>Add ".$c." first</option>";}
	}
}
function zonesOptions(){
	$query = mysql_query("SELECT * FROM ss_zone WHERE flag='0' ORDER BY zone");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<option value='$row[id]'>$row[zone]</option>";}
	}else{echo "<option value='' disabled>Add Zones first</option>";}
}
function designationOption(){
	$query = mysql_query("SELECT * FROM ss_designation WHERE flag='0' ORDER BY designation");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<option value='$row[id]'>$row[designation]</option>";}
	}else{echo "<option value='' disabled>Add Designation first</option>";}

}
function employeeRoleOption(){
	$query = mysql_query("SELECT * FROM ss_employee_roles WHERE flag='0' ORDER BY role");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<option value='$row[id]'>$row[role]</option>";}
	}else{echo "<option value='' disabled>Add Role first</option>";}

}
function customerDetailsOption(){
	$query = mysql_query("SELECT * FROM ss_customer_details WHERE flag='0'");
	if(mysql_num_rows($query)>0){
		echo "<option value=''>[ Select Customer ]</option>";
		while($row=mysql_fetch_array($query)){echo "<option value='$row[id]'>$row[customerName]</option>";}
	}else{echo "<option value='' disabled>Add Customer first</option>";}
}
function customerDetailsEdit($custId){
	$query = mysql_query("SELECT * FROM ss_customer_details WHERE flag='0' ORDER BY customerName");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<option value='$row[id]'".($row['id'] == $custId ? "selected" : "").">$row[customerName]</option>";}
	}else{echo "<option value='' disabled>Add Customer First</option>";}

}
function customerCategoryOption(){
	$query = mysql_query("SELECT * FROM ss_customer_category WHERE flag='0' ORDER BY category");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<option value='$row[id]'>$row[category]</option>";}
	}else{echo "<option value='' disabled>Add Category First</option>";}

}
function productCodeOption(){
	$query = mysql_query("SELECT * FROM ss_product_details WHERE flag='0' ORDER BY productCode");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<option value='$row[id]'>$row[productCode]</option>";}
	}else{echo "<option value='' disabled>Add Product Code</option>";}

}
function userRoleOption(){
	$query = mysql_query("SELECT * FROM ss_user_role WHERE flag='0' GROUP BY roleId ORDER BY roleName");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<option value='$row[roleId]'>$row[roleName]</option>";}
	}else{echo "<option value='' disabled>Add Role First</option>";}

}
function employeeOption(){
	$query = mysql_query("SELECT * FROM ss_employee_details WHERE flag='0' ORDER BY employeeName");
	if(mysql_num_rows($query)>0){
		echo "<option value=''>[ Select Employee Name ]</option>";
		while($row=mysql_fetch_array($query)){echo "<option value='$row[employeeId]'>$row[employeeName]</option>";}
	}else{echo "<option value='' disabled>Add Employee First</option>";}

}
function employeeOptionEdit($empId){
	$query = mysql_query("SELECT * FROM ss_employee_details WHERE flag='0' ORDER BY employeeName");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<option value='$row[employeeId]'".($row['employeeId'] == $empId ? "selected" : "").">$row[employeeName]</option>";}
	}else{echo "<option value='' disabled>Add Employee First</option>";}

}
function serviceEngineerOption($fv){
	$query = mysql_query("SELECT * FROM ss_employee_details WHERE circles LIKE '%$fv%' AND flag='0' ORDER BY employeeName");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<option value='$row[employeeId]'>$row[employeeName]</option>";}
	}else{echo "<option value='' disabled>Add Employee First</option>";}
}
function  natureOfActivityOption(){
	$query = mysql_query("SELECT * FROM  ss_nature_of_activity WHERE flag='0' ORDER BY activity");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<option value='$row[id]'>$row[activity]</option>";}
	}else{echo "<option value='' disabled>Add Activity First</option>";}

}
function  natureComplaintsOption(){
	$query = mysql_query("SELECT * FROM  ss_nature_of_complaint WHERE flag='0 ORDER BY complaint'");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<option value='$row[id]'>$row[complaint]</option>";}
	}else{echo "<option value='' disabled>Add Complaint First</option>";}

}
function  faultyCodeOption(){
	$query = mysql_query("SELECT * FROM  ss_fault_code WHERE flag='0' ORDER BY fault");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<option value='$row[id]'>$row[fault]</option>";}
	}else{echo "<option value='' disabled>Add Faulty Code First</option>";}

}
function faultyCodeGetOption(){
	$query = mysql_query("SELECT * FROM  ss_fault_code WHERE flag='0' ORDER BY description");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<option value='$row[id]'>$row[description]</option>";}
	}else{echo "<option value='' disabled>Add Fault Description</option>";}

}
function  smpsRatingOption(){
	$query = mysql_query("SELECT * FROM  ss_smps_rating WHERE flag='0' ORDER BY rating");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<option value='$row[id]'>$row[rating]</option>";}
	}else{echo "<option value='' disabled>Add SMPS Rating First</option>";}

}
function checkx($xx, $tbl){
		$count = mysql_num_rows(mysql_query("SELECT id FROM $tbl WHERE id='$xx'"));
		if($count==0){return $xx;}
		else{return checkx(rand(0000, 9999), $tbl);}
}
function ticketGetNumber($q){
	$query=mysql_query("SELECT ticketId FROM ss_tickets WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['ticketId'];
		}
}
function cdate($q){
	$query=mysql_query("SELECT closingDate FROM ss_tickets WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return date("jS M Y", strtotime($row['closingDate']));
		}
}

function zoneGetName($q){
	$query=mysql_query("SELECT zone FROM ss_zone WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['zone'];
		}
}
function circleGetName($q){
	$query=mysql_query("SELECT circle FROM ss_circles WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['circle'];
		}
}
function clustersGetName($q){
	$query=mysql_query("SELECT cluster FROM ss_clusters WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['cluster'];
		}
}
function districtsGetName($q){
	$query=mysql_query("SELECT district FROM ss_districts WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['district'];
		}
}
function customerCategoriesGetName($q){
	$query=mysql_query("SELECT category FROM ss_customer_category WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['category'];
		}
}
function designationGetName($q){
	$query=mysql_query("SELECT designation FROM ss_designation WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['designation'];
		}
}
function employeeRoleGetName($q){
	$query=mysql_query("SELECT role FROM ss_employee_roles WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['role'];
		}
}
function roleGetName($q){
	$query=mysql_query("SELECT roleName FROM  ss_user_role WHERE roleId='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['roleName'];
		}
}
function customerCodeGetName($q){
	$query=mysql_query("SELECT customerCode FROM  ss_customer_details WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['customerCode'];
		}
}
function customerCodeGetNamex($q){
	$query=mysql_query("SELECT customerCode FROM  ss_customer_details WHERE customerName='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['customerCode'];
		}
}

function productCodeGetName($q){
	$query=mysql_query("SELECT productCode FROM  ss_product_details WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['productCode'];
		}
}
function productCodeGetID($q){
	$query=mysql_query("SELECT id FROM  ss_product_details WHERE productCode='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['id'];
		}
}
function employeeGetName($q){
	$query=mysql_query("SELECT employeeId FROM  ss_employee_details WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['employeeId'];
		}
}
function employeeGetID($q){
	$query=mysql_query("SELECT id FROM  ss_employee_details WHERE employeeId='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['id'];
		}
}
function customerNameGetName($q){
	$query=mysql_query("SELECT customerName FROM  ss_customer_details WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['customerName'];
		}
}
function customerNameGetID($q){
	$query=mysql_query("SELECT id FROM  ss_customer_details WHERE customerName='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['id'];
		}
}
function natureOfActivityGetCode($q){
	$query=mysql_query("SELECT code FROM  ss_nature_of_activity WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['code'];
		}
}
function natureOfActivityGetName($q){
	$query=mysql_query("SELECT activity FROM  ss_nature_of_activity WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['activity'];
		}
}
function natureOfComplaintGetName($q){
	$query=mysql_query("SELECT complaint FROM  ss_nature_of_complaint WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['complaint'];
		}
}
function faultyCodeGetDesc($q){
	$query=mysql_query("SELECT description FROM  ss_fault_code WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['description'];
		}
}
function faultyCodeGetName($q){
	$query=mysql_query("SELECT fault FROM  ss_fault_code WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['fault'];
		}
}
function smpsGetName($q){
	$query=mysql_query("SELECT rating FROM ss_smps_rating WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['rating'];
		}
}
function zoneGetID($q){
	$query=mysql_query("SELECT id FROM ss_zone WHERE zone='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['id'];
		}
}
function circleGetID($q){
	$query=mysql_query("SELECT id FROM ss_circles WHERE circle='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['id'];
		}
}
function clusterGetID($q){
	$query=mysql_query("SELECT id FROM ss_clusters WHERE cluster='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['id'];
		}
}
function districtsGetID($q){
	$query=mysql_query("SELECT id FROM ss_districts WHERE district='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['id'];
		}
}
function customerCategoriesGetId($q){
	$query=mysql_query("SELECT id FROM ss_customer_category WHERE category='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['id'];
		}
}
function designationGetId($q){
	$query=mysql_query("SELECT id FROM ss_designation WHERE designation='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['id'];
		}
}
function natureOfActivityGetID($q){
	$query=mysql_query("SELECT id FROM  ss_nature_of_activity WHERE activity='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['id'];
		}
}function itemCodeOptions(){
	$query = mysql_query("SELECT * FROM ss_item_code WHERE flag='0'");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<option value='$row[id]'>$row[itemDesc]</option>";}
	}else{echo "<option value='' disabled>Add Item first</option>";}
}
function itemGetName($q){
	$query=mysql_query("SELECT itemCode FROM ss_item_code WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['itemCode'];
		}
}
function itemGetDesc($q){
	$query=mysql_query("SELECT itemDesc FROM ss_item_code WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['itemDesc'];
		}
}
function itemGetID($q){
	$query=mysql_query("SELECT id FROM ss_item_code WHERE itemCode='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['id'];
		}
}
function whareHouseOptions(){
	$query = mysql_query("SELECT * FROM ss_warehouse_code WHERE flag='0'");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<option value='$row[id]'>$row[whCode]</option>";}
	}else{echo "<option value='' disabled>Add WareHouse first</option>";}
}
function whareHouseGetName($q){
	$query=mysql_query("SELECT whCode FROM ss_warehouse_code WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['whCode'];
		}
}
function whareHouseGetDesc($q){
	$query=mysql_query("SELECT whDesc FROM ss_warehouse_code WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['whDesc'];
		}
}
function whareHouseGetID($q){
	$query=mysql_query("SELECT id FROM ss_warehouse_code WHERE whCode='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['id'];
		}
}
function stockOptions(){
	$query = mysql_query("SELECT * FROM ss_stock_code WHERE flag='0'");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<option value='$row[id]'>$row[stockCode]</option>";}
	}else{echo "<option value='' disabled>Add Stock first</option>";}
}
function stockGetName($q){
	$query=mysql_query("SELECT stockCode FROM ss_stock_code WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['stockCode'];
		}
}
function stockGetID($q){
	$query=mysql_query("SELECT id FROM ss_stock_code WHERE stockCode='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['id'];
		}
}
function escaNameOptions(){
	$query = mysql_query("SELECT * FROM ss_contract_price WHERE flag='0'");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<option value='$row[id]'>$row[escaName]</option>";}
	}else{echo "<option value=''>Add Contract Price First</option>";}

}
function escaNameOptionsInCP(){
	$query = mysql_query("SELECT id,employeeName FROM ss_employee_details WHERE designation='19' AND flag='0'");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<option value='$row[id]'>$row[employeeName]</option>";}
	}else{echo "<option value=''>Add Employee Details First</option>";}

}
function escaGetName($q){
	$query=mysql_query("SELECT employeeName FROM ss_employee_details WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['employeeName'];
		}
}
function ttMsg($ttm){
	switch($ttm){
		case 1: return "Ticket Inactive";break;
		case 2: return "Site Not Visited";break;
		case 3: return "Zonal Approval Pending";break;
		case 4: return "Zonal Rejected";break;
		case 5: return "NHS Accepted";break;
		case 6: return "NHS Approval Pending";break;
		case 7: return "NHS Rejected";break;
		case 8: return "NHS Accepted";break;
		case 9: return "Ticket Closed";break;
		case 10: return "Zonal Approval Pending";break;
		case 11: return "Rejection Cancelled";break;
		case 12: return "Ticket Closed";break;
		default: return "";
	}
}
function color($cv,$cs1){
if($cs1=="Ticket Inactive"){return 'style="color:red !important" ';}
elseif($cs1=="Site Not Visited"){return 'style="color:orange !important" ';}
elseif($cs1=="Zonal Approval Pending"){return 'style="color:orange!important" ';}
elseif($cs1=="Zonal Rejected"){return 'style="color:orange!important" ';}
//elseif($cs1=="NHS Approval Not Required"){return 'style="color:orange !important" ';}
elseif($cs1=="NHS Approval Pending"){return 'style="color:orange !important" ';}
elseif($cs1=="NHS Rejected"){return 'style="color:orange !important" ';}
elseif($cs1=="NHS Accepted"){return 'style="color:orange !important" ';}
elseif($cs1=="Ticket Closed"){return 'style="color:green !important" ';}
elseif($cs1=="Rejection Cancelled"){return 'style="color:orange !important" ';}
elseif($cs1=="False Ticket"){return 'style="color:green !important" ';}

	/*if($cv =='0'){return 'style="color:red !important" ';}
	elseif($cv =='1'){return 'style="color:#000DFF !important" ';}
	elseif($cv =='2'){return 'style="color:orange !important" ';}
	elseif($cv =='3'){return 'style="color:#663399 !important" ';}
	elseif($cv =='4'){return 'style="color:#01FFDA !important" ';}
	elseif($cv >='5'){return 'style="color:green !important" ';}
	*/		
}
function refname($colRef,$value,$fv1){
	$colRef= preg_replace('/\s+/', '', $colRef); //echo $colRef;
	$path=basename($_SERVER['PHP_SELF'],'.php');
	switch ($colRef) {
		case Zones: 
			$pos=strpos($value, ",");
			if($pos === false){if(is_numeric ($value))$finalValue = zoneGetName($value);else{$finalValue = $value;}}
			else{$tempvlue=explode(",",rtrim(str_replace(" ","",$value), ","));foreach ($tempvlue as $arva){$finalValue.= zoneGetName($arva).", ";}}
		break;
		case Circles: 
			$pos=strpos($value, ",");
			if($pos === false){if(is_numeric ($value))$finalValue = circleGetName($value);else{$finalValue = $value;}}
			else{$tempvlue=explode(",",rtrim(str_replace(" ","",$value), ","));foreach ($tempvlue as $arva){$finalValue.= circleGetName($arva).", ";}}
		break;
		case Clusters: 
			$pos=strpos($value, ",");
			if($pos === false){if(is_numeric($value))$finalValue=clustersGetName($value);else $finalValue = $value;}
			else{$tempvlue=explode(",",rtrim(str_replace(" ","",$value), ","));foreach ($tempvlue as $arva){$finalValue.= clustersGetName($arva).", ";}}
		break;
		case Districts: 
		case BaseLocation:
			if(is_numeric ($value)){$finalValue = districtsGetName($value);}
			else{$finalValue = $value;}
		break;
		case Segment: 
			if(is_numeric ($value)){$finalValue = customerCategoriesGetName($value);}
			else{$finalValue = $value;}
		break;
		case Designation: 
			if(is_numeric ($value)){$finalValue = designationGetName($value);}
			else{$finalValue = $value;}
		break;

		case EmployeeRole: 
			if(is_numeric ($value)){$finalValue = employeeRoleGetName($value);}
			else{$finalValue = $value;}
		break;
		case EmployeeID:
			if(!is_numeric($value)){$finalValue = $value;}
			else{ if(employeeGetName($value)){$finalValue = employeeGetName($value);}else{$finalValue = $value;} }
		break;
		case Role: 
			if(ctype_alnum  ($value)){$finalValue = roleGetName($value);}
			else{$finalValue = $value;}
		break;
		case FaultCodeDescription: 
			$finalValue = faultyCodeGetDesc($value);
		break;
		case SMPSCapacity:
			$finalValue = smpsGetName($value);
			break;
		case CustomerCode: 
			if(is_numeric ($value)){$finalValue = customerCodeGetName($value);}
			else{$finalValue = $value;}
		break;
		case CustomerName: $finalValue = $value; break;
		case Customername: $finalValue = customerCodeGetNamex($value); break;
		case ProductCode: 
			if(is_numeric ($value)){$finalValue = productCodeGetName($value);}
			else{$finalValue = $value;}
		break;
		case ServiceEngineer:
		case RegionalManager:
			if(is_numeric ($value)){$finalValue = employeeGetName($value);}
			else{$finalValue = $value;}
		break;
		case Activity:
		case NatureOfActivity:
			if(is_numeric ($value)){$finalValue = natureOfActivityGetCode($value);}
			else{$finalValue = $value;}
		break;
		case NatureOfComplaint: 
			if(is_numeric($value)){$finalValue = natureOfComplaintGetName($value);}
			else{$finalValue = $value;}
		break;
		case 'FromW/H':
			if(is_numeric($value)){$finalValue = whareHouseGetName($value);}
			else{$finalValue = $value;}
		break;
		case 'ToW/H':
			if(empty($value)){
				$query1 = mysql_query("SELECT ttNumber FROM ss_material_outward WHERE toWh='".$value."' AND flag='0'");
				$row1=mysql_fetch_array($query1); $finalValue = $row1['ttNumber'];
				}
			elseif(is_numeric($value)){$finalValue = whareHouseGetName($value);}
			else{$finalValue = $value;}
		break;
		case StockCategory:
			if(is_numeric($value)){$finalValue = stockGetName($value);}
			else{$finalValue = $value;}
		break;
		case ItemCode:
			if(is_numeric($value)){$finalValue = itemGetDesc($value);}
			else{$finalValue = $value;}
		break;
		case SJOFile: 
			if($value!="")$finalValue = "<a href='http://enersyscare.co.in/v1/".$value."' target='_blank' style='color:#2a6496!important;font-weight:bold;'>Click Here</a>";
			else{$finalValue="No Report";}
		break;
		case EmployeeName:
		case ESCAName:
			if(is_numeric ($value)){$finalValue = escaGetName($value);}
			else{$finalValue = $value;}
		break;
		case VisitFSR: 
			$finalValue = "<a href='http://enersyscare.co.in/v1/".$value."' target='_blank' style='color:red !important;'>Click Here</a>";
		break;
		case ClosedFSR: 
			if($value!="")$finalValue = "<a href='http://enersyscare.co.in/v1/".$value."' target='_blank' style='color:#2a6496!important;font-weight:bold;'>Click Here</a>";
			else{$finalValue="No Report";}
		break;
		case SitePhotoGraphs: 
			if($value!="")$finalValue = "<a href='http://enersyscare.co.in/v1/".$value."' target='_blank' style='color:#2a6496!important;font-weight:bold;'>Click Here</a>";
			else{$finalValue="No Report";}
		break;
		case MOCReport: 
			if($value!=""){	$pos=strpos($value, ",");
			$tempvlue=explode(",",rtrim(str_replace(" ","",$value), ","));foreach ($tempvlue as $a=>$arva){
				$finalValue .= "<a href='http://enersyscare.co.in/v1/".$arva."' target='_blank' style='color:#2a6496!important;font-weight:bold;'>".(count($tempvlue)==1 ? 'Click Here' : "Report_".($a+1))."</a>&nbsp;&nbsp;";
			}}else{$finalValue="No Report";}
			/*if($value!="")$finalValue = "<a href='http://enersyscare.co.in/v1/".$value."' target='_blank' style='color:#2a6496!important;font-weight:bold;'>Click Here</a>";
			else{$finalValue="No Report";}*/
		break;
		case Levels:
			$query = mysql_query("SELECT errorMessage,plannedDate FROM ss_tickets WHERE id='$fv1'");
			if(mysql_num_rows($query)>0){$row=mysql_fetch_array($query);$errorMessage=$row['errorMessage'];}
			$finalValue='<a class="tooltips" data-placement="top" data-original-title="'.$errorMessage.'"><i class="glyphicon glyphicon-stats"'.checkPlannedRed($value,$errorMessage,$row['plannedDate']).'></i><span > '.$errorMessage.'</span>&nbsp;</a>';
		break;
		case Status:
			if($_REQUEST['x']==6643){ 
				if($value=="0"){$finalValue='<a class="tooltips" data-placement="top" data-original-title="NHS Approval Pending"><i class="glyphicon glyphicon-stats"'.color($value,"Ticket Inactive").'></i><span> NHS Approval Pending</span>&nbsp;</a>';}
				if($value=="1"){$finalValue='<a class="tooltips" data-placement="top" data-original-title="NHS Approved"><i class="glyphicon glyphicon-stats"'.color($value,"Zonal Approval Pending").'></i><span> NHS Approved</span>&nbsp;</a>';}
				if($value=="2"){$finalValue='<a class="tooltips" data-placement="top" data-original-title="Request Closed"><i class="glyphicon glyphicon-stats"'.color($value,"Ticket Closed").'></i><span> Request Closed</span>&nbsp;</a>';}
			}else{
				if($value=="0"){$finalValue='<a class="tooltips" data-placement="top" data-original-title="COO Approval Pending"><i class="glyphicon glyphicon-stats"'.color($value,"Ticket Inactive").'></i><span> COO Approval Pending</span>&nbsp;</a>';}
				if($value=="1"){$finalValue='<a class="tooltips" data-placement="top" data-original-title="NHS Approval Pending"><i class="glyphicon glyphicon-stats"'.color($value,"Zonal Approval Pending").'></i><span> NHS Approval Pending</span>&nbsp;</a>';}
				if($value=="2"){
					if($_REQUEST['x']==8865){$finalValue='<a class="tooltips" data-placement="top" data-original-title="Expense Approved"><i class="glyphicon glyphicon-stats"'.color($value,"Ticket Closed").'></i><span> Expense Approved</span>&nbsp;</a>';}
					elseif($_REQUEST['x']==4592){$finalValue='<a class="tooltips" data-placement="top" data-original-title="NHS Accepted"><i class="glyphicon glyphicon-stats"'.color($value,"Zonal Approval Pending").'></i><span> NHS Accepted</span>&nbsp;</a>';}
					elseif($_REQUEST['x']==7313){$finalValue='<a class="tooltips" data-placement="top" data-original-title="Ticket Registered"><i class="glyphicon glyphicon-stats"'.color($value,"Ticket Closed").'></i><span> Ticket Registered</span>&nbsp;</a>';}
				}
				if($value=="3"){$finalValue='<a class="tooltips" data-placement="top" data-original-title="ESCA Expense Approved"><i class="glyphicon glyphicon-stats"'.color($value,"Ticket Closed").'></i><span> ESCA Expense Approved</span>&nbsp;</a>';}
			}
		break;
		case MRFStatus:
			if($value=="Open"){$finalValue='<a class="tooltips" data-placement="top" data-original-title="'.$value.'"><i class="glyphicon glyphicon-stats" style="color:red !important" ></i><span > '.$value.'</span>&nbsp;</a>';}
			else{$finalValue='<a class="tooltips" data-placement="top" data-original-title="'.$value.'"><i class="glyphicon glyphicon-stats" style="color:green !important" ></i><span > '.$value.'</span>&nbsp;</a>';}
		break;
		case SiteName: if($path=="ajaxTable") {
			$finalValue = (strlen($value) > 12) ? "<span title='".$value."'><span style='display:none';>".$value."</span>".substr($value,0,12)."...</span>" : "<span>".$value."</span>";
		}else{$finalValue = $value;} break;
		default:$finalValue = $value;
	} 
	if($finalValue =="")$finalValue="NA";
	return(rtrim($finalValue, ", "));
}


function errorMsg($err){
	switch($err){
		case ERRMSG001: return "Request Successful!";break;
		case ERRMSG002: return "Sorry Please try Again!";break;
		case ERRMSG003: return "Request Already Available! Please try with other value";break;
		case ERRMSG004: return "Request Successful! &amp; Sent for Zonal Verification";break;
		case ERRMSG005: return "Request Successful! &amp; Ticket Rejected";break;
		case ERRMSG006: return "Request Successful! &amp; Sent For National Head service Verification";break;
		case ERRMSG007: return "Request Successful! &amp; National Head service Verification Not Required";break;
		case ERRMSG008: return "Request Successful! &amp; Sent For NHS Approval";break;
		case ERRMSG009: return "Request Successful! &amp; Ticket Closed";break;
		case ERRMSG0041: return "Request Successful! &amp; Sent For COO Verification";break;
		default: return "";
		}
	}


function mailsent($fv1){
	$query1x=mysql_query("SELECT siteId,ticketId,circle FROM ss_tickets WHERE id='$fv1'");
	$row1x=mysql_fetch_array($query1x);
	$b=$row1x['siteId'];$x=$row1x['ticketId'];
	$sqlxx = mysql_query("SELECT clusterManagerMail,clusterManagerName,circle FROM ss_site_master where siteID='$b'");
	$rx100=mysql_fetch_array($sqlxx);
	$to = $rx100['clusterManagerMail'];
	$escacircle = $rx100['circle'];
	
	$queryesca = mysql_query("SELECT email FROM ss_employee_details WHERE designation='19' AND circle LIKE '%$escacircle%' AND flag='0'");
	if(mysql_num_rows($queryesca)>0){
		$rowesca=mysql_fetch_array($queryesca);
		$ccemail= "ticket@enersys.co.in, ".$rowesca['email'];
	}else $ccemail= "ticket@enersys.co.in";
	
	$sub = "Ticket Closed - ".$x." - ".date("d-m-Y");
	$query = mysql_query("SELECT colName,colRef FROM ss_col_ref WHERE tbName='ss_tickets' AND pExport='0' ORDER BY ordering");
	if(mysql_num_rows($query)>0){$colName=array();$colref=array();
	while($row=mysql_fetch_array($query)){$colName[]=$row['colName'];$colref[]=$row['colRef'];}
	$queryxx = mysql_query("SELECT * FROM ss_tickets WHERE ticketId='".$x."' AND  flag='0'");
	if(mysql_num_rows($queryxx)>0){
	while($rowxx=mysql_fetch_array($queryxx)){
	for($af=0;$af<count($colName);$af++){
	if($rowxx[$colName[$af]] !=""){
	$strContent[]=$colref[$af];
	$strContent1[]=refname($colref[$af],$rowxx[$colName[$af]],$rowxx['id']);
	}
	}
	}
	}
	}
	$body="<p>Dear ".ucfirst($rx100['clusterManagerName']).",</p>";
	$body.="<p>A Ticket has been Closed in ".strtoupper(circleGetName($row1x['circle']))." Circle. Below are the details of Ticket.</p>";
	$body.="<h3 style='background:#2a6496;color:#FFF;padding:0 5px;line-height:30px;font-size:16px;'>Ticket Details</h3>";
	$body.="<table style='border-collapse:collapse;width:100%;'>";
	$c=count($strContent);
	for($a=0;$a<$c;$a++){
	$body.="<tr>";
	for($b=$a;$b<=$a+1;$b++){
	$body.="<td style='padding:2px 5px;text-align:justify;border:1px solid #000;'>
	<h4 style='display:block;color:#2a6496;font-weight:bold; margin:0;padding:2px;'>".ucfirst($strContent[$b])."</h4>
	<p style='display:block;margin:0;padding:1px;'>".ucfirst($strContent1[$b])."</p>
	</td>";
	}
	$a++;
	$body.="</tr>";
	}
	$body.="</table><br>";
	$body.="<p style='font-style:italic;font-size:12px;'>*** This is a System generated email, Please do not reply ***</p>";
	$from="feedback@enersys.co.in";
	$headers="From: EnerSys Care <$from>\r\n";
	$headers.="Reply-To: $from\r\n";
	$headers.="Return-Path: $from\r\n";
	$headers .= "CC: $ccemail \r\n";
	//$headers .= "BCC: $bccemail \r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$abc = mail($to,$sub,$body,$headers);
	if($abc)return TRUE;else return FALSE;
}


function nameing($fv1){
	$query=mysql_query("SELECT ticketId,natureOfActivity,siteId,createdDate FROM ss_tickets WHERE id='$fv1'");
	if(mysql_num_rows($query)>0){
		$row=mysql_fetch_array($query);
		return "-".$row['ticketId']."-".natureOfActivityGetCode($row['natureOfActivity'])."-".rand(0000,9999);
	}
}

function tatcheck($fv1){
	$query=mysql_query("SELECT createdDate,closingDate FROM ss_tickets WHERE id='$fv1'");
	if(mysql_num_rows($query)>0){
		$row=mysql_fetch_array($query);
		$r1=date_create($row['createdDate']);
		$r2=date_create($row['closingDate']);
		date_default_timezone_set("Asia/Kolkata");
		if($r2=="" || $r2=="0000-00-00"){$r2=date_create(date('Y-m-d'));}
		$diff=date_diff($r1,$r2);
		if($diff->format("%R%a") < 16){return "TAT-1";}
		elseif($diff->format("%R%a") > 15 && $diff->format("%R%a") < 26){return "TAT-2";}
		elseif($diff->format("%R%a") > 25){return "TAT-3";}
/*		return $diff->format("%R%a");*/
	}
}

function createMail($fv1,$fv2){
	date_default_timezone_set("Asia/Kolkata");
//$time = "start".date('Y-m-d h:i:s')."<br>";
	$sqlxx = mysql_query("SELECT clusterManagerMail,clusterManagerName,circle FROM ss_site_master where siteID='$fv1'");
	$rx100=mysql_fetch_array($sqlxx);
	$to = $rx100['clusterManagerMail'];
	$escacircle = $rx100['circle'];
//$time .= "first query".date('Y-m-d h:i:s')."<br>";	
	$queryesca = mysql_query("SELECT email FROM ss_employee_details WHERE designation='19' AND circle LIKE '%$escacircle%' AND flag='0'");
	if(mysql_num_rows($queryesca)>0){
		$rowesca=mysql_fetch_array($queryesca);
		$ccemail= "ticket@enersys.co.in, ".$rowesca['email'];
	}else $ccemail= "ticket@enersys.co.in";
//$time .= "second query".date('Y-m-d h:i:s')."<br>";
	$sub = "New Ticket - ".$fv2." - ".date("d-m-Y");
	$query = mysql_query("SELECT colName,colRef FROM ss_col_ref WHERE tbName='ss_tickets' AND pExport='0' ORDER BY ordering");
	if(mysql_num_rows($query)>0){$colName=array();$colref=array();
//$time .= "third query".date('Y-m-d h:i:s')."<br>";
	while($row=mysql_fetch_array($query)){$colName[]=$row['colName'];$colref[]=$row['colRef'];}
//$time .= "third query after while".date('Y-m-d h:i:s')."<br>";
	$queryxx = mysql_query("SELECT * FROM ss_tickets WHERE ticketId='".$fv2."' AND  flag='0'");
//$time .= "tickets query".date('Y-m-d h:i:s')."<br>";
	if(mysql_num_rows($queryxx)>0){
	while($rowxx=mysql_fetch_array($queryxx)){
	for($af=0;$af<count($colName);$af++){
	if($rowxx[$colName[$af]] !=""){
	$strContent[]=$colref[$af];
	$strContent1[]=refname($colref[$af],$rowxx[$colName[$af]],$rowxx['id']);
	}
	}
	}
//$time .= "after tickets while loop".date('Y-m-d h:i:s')."<br>";
	}
	}
	$body="<p>Dear ".ucfirst($rx100['clusterManagerName']).",</p>";
	$body.="<p>A New Ticket has been Registered in ".strtoupper(circleGetName($rx100['circle']))." Circle. Below are the details of Ticket.</p>";
	$body.="<h3 style='background:#2a6496;color:#FFF;padding:0 5px;line-height:30px;font-size:16px;'>Ticket Details</h3>";
	$body.="<table style='border-collapse:collapse;width:100%;'>";
	$c=count($strContent);
//$time .= "before for loop".date('Y-m-d h:i:s')."<br>";
	for($a=0;$a<$c;$a++){
	$body.="<tr>";
	for($b=$a;$b<=$a+1;$b++){
	$body.="<td style='padding:2px 5px;text-align:justify;border:1px solid #000;'>
	<h4 style='display:block;color:#2a6496;font-weight:bold; margin:0;padding:2px;'>".ucfirst($strContent[$b])."</h4>
	<p style='display:block;margin:0;padding:1px;'>".ucfirst($strContent1[$b])."</p>
	</td>";
	}
	$a++;
	$body.="</tr>";
	}
//$time .= "after for loop".date('Y-m-d h:i:s')."<br>";
	$body.="</table><br>";
	$body.="<p style='font-style:italic;font-size:12px;'>*** This is a System generated email, Please do not reply ***</p>";
	
	$from="feedback@enersys.co.in";
	$headers="From: EnerSys Care <$from>\r\n";
	$headers.="Reply-To: $from\r\n";
	$headers.="Return-Path: $from\r\n";
	$headers .= "CC: $ccemail \r\n";
	//$headers .= "BCC: $bccemail \r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$abc = mail($to,$sub,$body,$headers);
	if($abc)return TRUE;else return FALSE;
}
function messageSent($contactNo,$toMessage){
	$chu = curl_init();
	curl_setopt($chu, CURLOPT_URL, "http://bhashsms.com/api/sendmsg.php?user=enersyscare&pass=sairaam@5050&sender=EnrSys&phone=".$contactNo."&text=".$toMessage."&priority=ndnd&stype=normal");
	curl_setopt($chu, CURLOPT_FRESH_CONNECT, true);
	curl_setopt($chu, CURLOPT_TIMEOUT, 1);
	curl_exec($chu);
	curl_close($chu);
}
function zeroDates($a){
	if($a == '0000-00-00 00:00:00' || $a == '0000-00-00'){ return false; }else{ return $a; }
	}
function plannedDate($a){
	$query = mysql_query("SELECT createdDate FROM ss_tickets WHERE id='$a'");
	$row = mysql_fetch_array($query);
	return $row['createdDate'];
}
function checkPlannedRed($a,$b,$c){
date_default_timezone_set("Asia/Kolkata");
	if($c<date('Y-m-d') && $b=='Site Not Visited'){ return 'style="color:red !important" '; }else{ return color($a,$b); }
	}
/*case CreatedDate: if($value!=0000-00-00){$finalValue = date("jS M Y", strtotime($value));} else {$finalValue="Not Available";} break;
		case RelievingDate: if($value!=0000-00-00){$finalValue = date("jS M Y", strtotime($value));} else {$finalValue="Not Available";} break;
		case JoiningDate: if($value!=0000-00-00){$finalValue = date("jS M Y", strtotime($value));} else {$finalValue="Not Available";} break;
		case ManufacturingDate: if($value!=0000-00-00){$finalValue = date("jS M Y", strtotime($value));} else {$finalValue="Not Available";} break;
		case InstallationDate: if($value!=0000-00-00){$finalValue = date("jS M Y", strtotime($value));} else {$finalValue="Not Available";} break;
		case PlannedDate: if($value!=0000-00-00){$finalValue = date("jS M Y", strtotime($value));} else {$finalValue="Not Available";} break;
		case VisitedBy: if($value!=0000-00-00){$finalValue = date("jS M Y", strtotime($value));} else {$finalValue="Not Available";} break;
		case ClosingDate: if($value!=0000-00-00){$finalValue = date("jS M Y", strtotime($value));} else {$finalValue="Not Available";} break;
		case LoginDate: if($value!=0000-00-00){$finalValue = date("jS M Y", strtotime($value));} else {$finalValue="Not Available";} break;
*/
?>