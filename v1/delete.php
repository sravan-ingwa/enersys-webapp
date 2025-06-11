<?php
include('functions.php');
$a = explode("-",$_REQUEST['del']);
$b = $a[0]; $c = $a[1];
$b = preg_replace('/\s+/', '_',menuName($b,'tbName'));
mysql_query("UPDATE $b SET flag='1' WHERE id='$c'");
echo $a[0];
?>