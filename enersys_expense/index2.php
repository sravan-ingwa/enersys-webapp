<?php
$servername = "localhost";
$username = "root";
$password = "enersys123";
$dbname = "ec_enersyscare_db";
$mr_con = new mysqli($servername, $username, $password, $dbname);
if ($mr_con->connect_error) {die("Connection failed");} 
function alias($alias,$tb,$col,$retrive){
	global $mr_con;
	$sql = $mr_con->query("SELECT $retrive FROM $tb WHERE $col='$alias' AND flag=0");
	if(mysqli_num_rows($sql)){
		$row = mysqli_fetch_array($sql);
		return $row[$retrive];
	}
}
$sql = mysqli_query($mr_con,"SELECT `bill_number`, `employee_alias`, `approval_level`, `approval_level`,`total_tour_expenses` FROM `ec_expenses`");
while($row = $sql->fetch_assoc()){$result[]=array('bill_number'=>$row['bill_number'],'employee_alias'=>$row['employee_alias'],'approval_level'=>$row['approval_level'],'total_tour_expenses'=>$row['total_tour_expenses']);}?>
<table>
<?php foreach($result as $r){?>
<tr>
    <td><?php echo $r['bill_number'];?></td>
    <td><?php echo alias($r['employee_alias'],"ec_employee_master","employee_alias","name");?></td>
    <td><?php echo $r['total_tour_expenses'];?></td>
    <td><?php echo alias($r['approval_level'],"ec_expense_level","level_alias","level_name");?></td>
</tr>	
<?php }?>
</table>
?>