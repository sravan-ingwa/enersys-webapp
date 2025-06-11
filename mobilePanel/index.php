<?php include('mysql.php');?>
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
		$resx.="<td>".$ticketslista['ticket_id']."</td>";
		$resx.="<td>".alias($ticketslista['site_alias'],'ec_sitemaster','site_alias','site_id')."</td>";
		$resx.="<td>".alias($ticketslista['activity_alias'],'ec_activity','activity_alias','activity_code')."</td>";
		if($ticketslista['planned_date']!="0000-00-00")$resx.="<td>".$ticketslista['planned_date']."</td>";else $resx.="<td>-</td>";
		$resx.="<td>".alias($ticketslista['level'],'ec_levels','level_alias','level_name')."</td>";
		$resx.="<td><ul class='listtt'>";
		if($ticketslista['level'] ==1) $resx.="<li><a href='edit.php?x=".$ticketslista['alias']."'>Edit</a></li>";
		if($ticketslista['level'] ==3) $resx.="<li><a href='http://enersyscare.co.in/enersyscare_V2/pdf/?ticket_alias=".$ticketslista['alias']."'>e-FSR</a></li>";
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
                                <th>Ticket ID</th>
                                <th>Site ID</th>
                                <th>Activity</th>
                                <th>Planned Date</th>
                                <th>Level</th>
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
	$data=mysqli_query($mr_con,"SELECT * FROM ec_tickets WHERE flag=0");
	if(mysqli_num_rows($data)>0){
		while($rest=mysqli_fetch_assoc($data)){$result[]= array('alias'=>$rest['ticket_alias'], 'ticket_id'=>$rest['ticket_id'], 'site_alias'=>$rest['site_alias'], 'activity_alias'=>$rest['activity_alias'], 'planned_date'=>$rest['planned_date'], 'level'=>$rest['level']);}
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
