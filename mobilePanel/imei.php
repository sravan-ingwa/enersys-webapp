<?php include('mysql.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Enersys Care</title>
<link href="css/bootstrap.css" rel="stylesheet">
<style>
.nav, .nav li{
float:none !important;
}
.nav li{
display:inline-block !important;
}
.table th{text-align:center !important;}
.listtt{
	padding:0 !important;
list-style:none !important;}
.listtt li{
list-style:none !important;
}
</style>
<?php 
$ticketslist=ticketList();
if($ticketslist!="0"){
	foreach($ticketslist as $ticketslista){
		$resx.="<tr align=\"center\">";
		$resx.="<td>".$ticketslista['emp_id']."</td>";
		$resx.="<td>".$ticketslista['name']."</td>";
		$resx.="<td>".$ticketslista['device']."</td>";
		$resx.="<td>".$ticketslista['device_2']."</td>";
		$resx.="<td><ul class='listtt'>";
		$resx.="<li><a href='edit-jagan.php?x=".$ticketslista['alias']."'>Edit</a></li>";
		$resx.="</ul></td>";	
		$resx.="</tr>";
		
	}
}
?>
</head>
<body>
<?php include "header.php";?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1">
  			<div class="panel panel-primary">
    			<div class="panel-heading">
      				<h3 class="panel-title" style="display:inline-block;">Dashboard</h3>
    			</div>
    			<div class="panel-body">
      				<table class="table table-bordered">
        				<thead>
          					<tr>
                                <th>Employee ID</th>
                                <th>Employee Name</th>
                                <th>Device ID</th>
                                <th>Device ID 2</th>
                                <th>Options</th>
				          </tr>
        				</thead>
        				<tbody>
						<?php 
                        echo $resx;
                        ?>
        				</tbody>
      				</table>
    			</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
<?php
function ticketList(){
	global $mr_con;
	$data=mysqli_query($mr_con,"SELECT * FROM ec_employee_master WHERE flag=0");
	if(mysqli_num_rows($data)>0){
		while($rest=mysqli_fetch_assoc($data)){$result[]= array('alias'=>$rest['employee_alias'], 'emp_id'=>$rest['employee_id'], 'device'=>$rest['device'], 'device_2'=>$rest['device_2'], 'name'=>$rest['name']);}
		return $result;
	}else{return 0;}
}
function alias($alias,$tb,$col,$retrive){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT $retrive FROM $tb WHERE $col='$alias' AND flag=0");
	if(mysqli_num_rows($sql)){
		$row = mysqli_fetch_array($sql);
		return $row[$retrive];
	}else return 0;
}

?>
