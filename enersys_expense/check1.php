<?php 
    $_REQUEST['requestDate'] = '20-01-2016';
	echo $requestDate= date("Y-m-d", strtotime($_REQUEST['requestDate']));

?>