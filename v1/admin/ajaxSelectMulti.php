<?php
include('mysql.php');

$loadType = $_POST['type'];
$loadId = $_POST['id'];
$loadId = "'".implode("','",explode(",",$loadId))."'";

if($loadType == "Circle"){$sql="select id, circle from ss_circles where zone IN ($loadId)  AND flag='0' ORDER BY circle";}
else if($loadType=="Cluster"){$sql="select id, cluster from ss_clusters where circle IN ($loadId) AND flag='0' ORDER BY cluster";}
else if($loadType=="District"){$sql="select id, district from ss_districts where cluster IN ($loadId) AND flag='0' ORDER BY district";}
else if($loadType=="ToWH"){$sql="select id, whCode from ss_warehouse_code where circle IN ($loadId) AND flag='0' ORDER BY whCode";}
$HTML = "<option value='' disabled selected>Select $loadType</option>";
$res = mysql_query($sql);
if(mysql_num_rows($res) > 0){while($row=mysql_fetch_array($res)){$HTML.="<option value='".$row['0']."'>".$row['1']."</option>";}}
echo $HTML;
?>