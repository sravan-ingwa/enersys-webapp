<?php
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++){$randomString .= $characters[rand(0, $charactersLength - 1)];}
    return strtoupper($randomString);
}
function aliasCheck($fv1,$fv2,$fv3){ global $mr_con;
	$rec=$mr_con->query("SELECT $fv3 FROM $fv2 WHERE $fv3='$fv1'");
	if($rec->num_rows==0)return $fv1; else return aliasCheck(generateRandomString(),$fv2,$fv3);
}
function alias($alias,$tb,$col,$retrive){ global $mr_con;
	$sql = mysqli_query($mr_con,"SELECT $retrive FROM $tb WHERE $col='$alias' AND flag=0");
	if(mysqli_num_rows($sql)){
		$row = mysqli_fetch_array($sql);
		return $row[$retrive];
	}
}
function getdrop($ali,$col,$tb){ global $mr_con;
	$query=mysqli_query($mr_con,"SELECT $ali,$col FROM $tb WHERE flag=0");
	if($query->num_rows){
		while($row=mysqli_fetch_array($query)){
			$res.="<option value='$row[$ali]'>$row[$col]</option>";
		}
	}//else{ $res.="<option value='' disabled>Add first</option>";}
	return $res;
}
function get_group_drop($ali,$col,$tb,$grp){ global $mr_con;
	$query=mysqli_query($mr_con,"SELECT $ali,$col FROM $tb WHERE flag=0 GROUP BY $grp");
	if($query->num_rows){
		while($row=mysqli_fetch_array($query)){
			$res.="<option value='$row[$ali]'>$row[$col]</option>";
		}
	}//else{ $res.="<option value='' disabled>Add first</option>";}
	return $res;
}  
?>
		