<?php
include('mysql.php');
include('functions.php');
$sql = mysql_query("SELECT * FROM ss_employee_details WHERE id='$_REQUEST[empId]'");
$row = mysql_fetch_array($sql);
$HTML = $row['employeeName'].",".designationGetName($row['designation']);
echo $HTML;
?>