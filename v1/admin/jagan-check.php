<?php
$servername = "localhost";
$username = "mymgscom_smart";
$password = "smart12#";
$dbname = "mymgscom_enersyscare";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT ticketId, visitfsrreport, closedfsrreport, sitePhotoGraphs FROM ss_tickets  ORDER BY ticketId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
     echo "<table width='80%'><tr><th>ID</th><th>visitfsr</th><th>closedfsr</th><th>sitePhoto</th></tr>";
     // output data of each row
     while($row = $result->fetch_assoc()) {
			echo "<tr>";
			echo"<td>".$row['ticketId']."</td>";
			echo"<td>".visitcheck($row['visitfsrreport'])."</td>";
			echo"<td>".closedcheck($row['closedfsrreport'])."</td>";
			echo"<td>".sitevisitcheck($row['sitePhotoGraphs'])."</td>";
     }
     echo "</table>";
} else {
     echo "0 results";
}

$conn->close();


function visitcheck($fb){
	if($fb!=''){
		$link="../".$fb;
		if(file_exists($link)) return "<a href='".$link."' target='_blank' >Link</a>";
		else return "file not There";
	}else return "null";	
}
function closedcheck($fb){
	if($fb!=''){
		$link="../".$fb;
		if(file_exists($link)) return "<a href='".$link."' target='_blank' >Link</a>";
		else return "file not There";
	}else return "null";	
}
function sitevisitcheck($fb){
	if($fb!=''){
		$link="../".$fb;
		if(file_exists($link)) return "<a href='".$link."' target='_blank' >Link</a>";
		else return "file not There";
	}else return "null";	
}

?>  