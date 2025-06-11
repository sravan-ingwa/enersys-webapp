<?php 
//database settings
$connect = mysqli_connect("localhost", "root", "", "ec_enersyscare_db");

$result = mysqli_query($connect, "select * from ec_zone");

$data = array();

while ($row = mysqli_fetch_array($result)) {
  $data[] = $row;
}
    print json_encode($data);
 ?>