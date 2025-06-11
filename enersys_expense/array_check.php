<?php 
$allRecordTypes =  array('3','4','5');
$tempRecordTypes = array('1');
//$RecordType = in_array($tempRecordTypes,$allRecordTypes);
$RecordType = array_intersect($tempRecordTypes,$allRecordTypes);
print_r(count($RecordType));
?>