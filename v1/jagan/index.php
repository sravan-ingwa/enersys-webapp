<?php
include("mysql.php");
$ticket=array();
$fc=array();
$query = mysql_query("SELECT ticketId,faultyCellSerial FROM ss_tickets");
while($row=mysql_fetch_array($query)){
	$ticket[]=$row['ticketId'];
	$fc[]=$row['faultyCellSerial'];
}


for($x=0;$x<count($ticket);$x++){
$axxx=str_replace(" ",",",str_replace("&",",",str_replace(".",",",$fc[$x])));
	$ax=explode(",",$axxx);
	echo "<table>";
	for($xz=0;$xz<count($ax);$xz++){
		echo "<tr><td>".$ticket[$x]."</td><td>".$ax[$xz]."</td></tr>";
	}
	echo "</table>";
}
