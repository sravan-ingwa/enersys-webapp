<table>
<tr>
    <th>Ticket Number</th>
    <th>e-FSR</th>
</tr>
<?php
date_default_timezone_set("Asia/Kolkata");
include('mysql.php');
	$sql=mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE flag=0");
	while($row=mysqli_fetch_array($sql)){
?>
<tr>
    <td><?php echo $row['ticket_id']; ?></td>
    <td><a href="efsrpdf.php?ticket_alias=<?php echo $row['ticket_alias']; ?>" target="_blank">Click Here</a></td>
</tr>
<?php } ?>
</table>