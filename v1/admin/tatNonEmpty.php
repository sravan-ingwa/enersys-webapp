<?php
// Copy one column into another by using query....( Where null)
/*"UPDATE `ss_tickets` SET closingDate=visitedby WHERE errorMessage='Ticket Closed' AND ticketStatus='Closed' AND closingDate IS NULL";
"UPDATE `ss_tickets` SET closingDate=createdDate WHERE errorMessage='Ticket Closed' AND ticketStatus='Reject' AND closingDate IS NULL";*/

// Copy one column into another by using query....( Where 0000-00-00 00:00:00)
/*"UPDATE `ss_tickets` SET closingDate=visitedby WHERE errorMessage='Ticket Closed' AND ticketStatus='Closed' AND closingDate='0000-00-00 00:00:00'";
"UPDATE `ss_tickets` SET closingDate=createdDate WHERE errorMessage='Ticket Closed' AND ticketStatus='Reject' AND closingDate='0000-00-00 00:00:00'";*/

include('mysql.php');
include('functions.php');
//$abc = mysql_query("SELECT id FROM `ss_tickets` WHERE errorMessage='Ticket Closed' AND ticketStatus='Closed' AND checkStat='5' AND tat IS NULL");
$abc = mysql_query("SELECT id FROM `ss_tickets` WHERE errorMessage='Ticket Closed' AND ticketStatus='Reject' AND checkStat='5' AND tat IS NULL");
if(mysql_num_rows($abc)>0){
	while($roq=mysql_fetch_array($abc)){
	 mysql_query("UPDATE `ss_tickets` SET tat='".tatcheck($roq['id'])."' WHERE errorMessage='Ticket Closed' AND checkStat='5' AND tat IS NULL");
	 }
}
?>