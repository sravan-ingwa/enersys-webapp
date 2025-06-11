<?php
include('mysql.php');
function circleName($cirn){
		$i = array();
		$x = "'".implode("','",explode(", ",$cirn))."'";
		$sql = mysql_query("SELECT * FROM ss_circles WHERE circle IN ($x) AND flag='0'");
		while($f1=mysql_fetch_array($sql)){$i[]= $f1['id'];}
		$a = implode(", ",$i);
		return $a;
}
function clusterName($clusn){
		$j = array();
		$y = "'".implode("','",explode(", ",$clusn))."'";
		$sql = mysql_query("SELECT * FROM ss_clusters WHERE cluster IN ($y) AND flag='0'");
		while($f1=mysql_fetch_array($sql)){$j[]= $f1['id'];}
		$b = implode(", ",$j);
		return $b;
}
if($_REQUEST['ref']=="ajax"){
	$type = $_REQUEST['type'];
	$id = $_REQUEST['id'];
	if($type == "District"){
			$a = clusterName($id);
			$x = "'".implode("','",explode(", ",$a))."'";
			$sql = mysql_query("SELECT id,district FROM ss_districts WHERE cluster IN ($x) AND flag='0'");
			while($r = mysql_fetch_array($sql)){ $HTML.= "<option value=".$r['id'].">".$r['district']."</option>";}
	}
	else{$HTML=$id;}
	echo $HTML;
}
elseif($_REQUEST['ref']=="autocomplete"){
	if($_REQUEST['type']=="Circle"){
		$dat = mysql_real_escape_string($_REQUEST['q']);
		$result = $_REQUEST['result'];
		$res = mysql_query("SELECT circle FROM ss_circles WHERE circle LIKE '$dat%' AND zone LIKE '%$result%' AND flag='0'");
		while($row = mysql_fetch_array($res)){echo $row['circle']."\n";}
	}
	if($_REQUEST['type']=="Cluster"){
		$dat = mysql_real_escape_string($_REQUEST['q']);	
		$result = circleName($_REQUEST['result']);
		$x = "'".implode("','",explode(", ",$result))."'";
		$sql = mysql_query("SELECT cluster FROM ss_clusters WHERE cluster LIKE '$dat%' AND circle IN ($x) AND flag='0'");
		while($f1=mysql_fetch_array($sql)){echo $f1['cluster']."\n";}
	}
}
?>