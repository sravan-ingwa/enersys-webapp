<?php
$user_input = trim($_REQUEST['term']);
$display_json = array();
$json_arr = array();
$json_arr["id"] = "create.php?x=8324";
$json_arr["value"] = $user_input;
$json_arr["label"] = "Add To Site Master";
array_push($display_json, $json_arr);
$jsonWrite = json_encode($display_json); //encode that search data
echo $jsonWrite;
?>