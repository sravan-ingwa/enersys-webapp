<?php  include('functions.php');
if(isset($_REQUEST['ref'])){
	$ref=$_REQUEST['ref'];
	if(file_exists('include/'.$ref.'.php')){include('include/'.$ref.'.php');}
	else{echo"<center><h1>Permission Denied</h1></center>";}
}
else if(isset($_REQUEST['gradedesg'])){
	$listDgn=gradedesg($_REQUEST['gradedesg']);
	foreach($listDgn as $rec){$ax[]=$rec['designation'];}
	echo implode(", ",$ax);
}
else if(isset($_REQUEST['empbydep'])){
	$vax="<select class='form-control' tabindex='2' required='required' name='aemp'>";
	$vax.="<option value='0' disabled='disabled' selected='selected'>Select Employee</option>";
	$empbydep=empbydep($_REQUEST['empbydep']);
	if($empbydep!=0)foreach($empbydep as $rec){$vax.="<option value='".$rec['alias']."'>".$rec['name']."</option>";}
	else $vax.="<option value='0' disabled='disabled'>No Employee</option>";
	$vax.="</select>";
	echo $vax;
}
else if(isset($_REQUEST['empiid'])){
		if($_REQUEST['empiid']!="" && alreadyexist($_REQUEST['empiid'],'ec_employee_master','employee_id',$mr_con)==1) echo "Employee ID Already Registered";
}
else if(isset($_REQUEST['forr'])){
	echo deleteitems($_REQUEST['dRef'],$_REQUEST['dId']);
}

else{echo"<center><h1>Permission Denied</h1></center>";}
?>