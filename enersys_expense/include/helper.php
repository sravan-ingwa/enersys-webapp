<?php
if($_REQUEST['rf']=='days'){
$date1=date_create($_REQUEST['d1']);
$date2=date_create($_REQUEST['d2']);
$diff=date_diff($date1,$date2);
echo ($diff->format("%a")+1)." Days";
}

?>