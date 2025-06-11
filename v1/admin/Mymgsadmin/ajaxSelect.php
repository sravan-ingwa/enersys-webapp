<?php
include('mysql.php');

$loadType = $_POST['type'];
$loadId = $_POST['id'];
if($loadType == "Circle"){$sql="select id, circle from ss_circles where zone='".$loadId."'";}
else if($loadType=="Cluster"){$sql="select id, cluster from ss_clusters where circle='".$loadId."'";}
else if($loadType=="District"){$sql="select id, district from ss_districts where cluster='".$loadId."'";}
$HTML = "<option value=''>Select $loadType</option>";
$res = mysql_query($sql);
if(mysql_num_rows($res) > 0){while($row=mysql_fetch_array($res)){$HTML.="<option value='".$row['0']."'>".$row['1']."</option>";}}
echo $HTML;
?>