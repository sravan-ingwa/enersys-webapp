<?php
include('mysql.php');
if(isset($_REQUEST['siteID'])){
	$query=mysql_query("SELECT id FROM ss_site_master WHERE siteID = '$_REQUEST[siteID]' AND circle='$_REQUEST[circle]' AND flag='0'");
	if(mysql_num_rows($query)>0){ echo "Request Site ID Already Avalilable! Please try with other value"; }else{ echo ""; }
}
if(isset($_REQUEST['activity'])){
	$query=mysql_query("SELECT * FROM ss_nature_of_complaint WHERE activity = '$_REQUEST[activity]' AND flag='0'");
	if(mysql_num_rows($query)>0){ $HTML = "<option value='' disabled selected> Select Nature Of Complaint </option>";
		while($row=mysql_fetch_array($query)){ $HTML .= "<option value='$row[id]'>$row[complaint]</option>";}
	}else{ $HTML = "<option value='' disabled selected> Add Nature Of Complaint</option>"; }
	echo $HTML;
}
if(isset($_REQUEST['fsrNumber'])){
	$query=mysql_query("SELECT fsrNumber FROM ss_tickets WHERE fsrNumber = '$_REQUEST[fsrNumber]' AND flag='0'");
	if(mysql_num_rows($query)>0){ echo "FSR Number Already Avalilable! Please try with other value"; }else{ echo ""; }
}
?>