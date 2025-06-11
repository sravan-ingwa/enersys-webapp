<?php
include('mysql.php');
if(isset($_REQUEST['mv'])){
	$query=mysql_query("SELECT price FROM ss_item_code WHERE id='$_REQUEST[mv]' AND flag='0'");
	if(mysql_num_rows($query)){ 
		$row = mysql_fetch_array($query);
		echo $row['price'];
	}else{ echo ""; }
}
?>