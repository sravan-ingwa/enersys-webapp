<?
include('mysql.php');

function tblname(){
	$res1=mysql_query("show tables from mymgscom_enersyscare");
	$check1=mysql_num_rows($res1);
	if($check1 > 0){
		$HTML="";
		while($row=mysql_fetch_array($res1)){
			$HTML.="<option value='".$row['0']."'>".$row['0']."</option>";
		}
		echo $HTML;
	}
}
function zonesOptions(){$sql = mysql_query("SELECT * FROM ss_zone WHERE flag='0'");while($row = mysql_fetch_array($sql)){echo "<option value='$row[id]'>$row[zone]</option>";}}
function checkx($xx, $tbl){
		$count = mysql_num_rows(mysql_query("SELECT id FROM $tbl WHERE id='$xx'"));
		if($count==0){return $xx;}
		else{checkx(rand(0000, 9999));}
}
function zoneGetName($q){
	$query=mysql_query("SELECT zone FROM ss_zone WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['zone'];
		}
}
function circleGetName($q){
	$query=mysql_query("SELECT circle FROM ss_circles WHERE id='$q'");
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query);
			return $row['circle'];
		}
}
?>