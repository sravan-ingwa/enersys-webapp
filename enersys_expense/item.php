<?php session_start();
include('mysql.php');
include('functions.php');
if(isset($_REQUEST['ref'])){
	$ref=$_REQUEST['ref'];
	if(file_exists('include/'.$ref.'.php')){include('include/'.$ref.'.php');}
	else{echo"<center><h1>Permission Denied</h1></center>";}
}
/*else if(isset($_REQUEST['currentRequest'])){
	$listDgn=gradedesg($_REQUEST['gradedesg']);
	foreach($listDgn as $rec){$ax[]=$rec['designation'];}
	echo implode(", ",$ax);
}
else if(isset($_REQUEST['empbydep'])){
	$vax="<select class='form-control' tabindex='2' required='required' name='aemp[]' id='mot2' multiple='multiple'>";
	$empbydep=empbydep($_REQUEST['empbydep']);
	if($empbydep!=0)foreach($empbydep as $rec){$vax.="<option value='".$rec['alias']."'>".$rec['name']."</option>";}
	$vax.="</select>";
	echo $vax;
}*/
else if(isset($_REQUEST['currentRequest'])){echo totalAdvance($_REQUEST['currentRequest'],$_SESSION['ec_user_alias']);}
else if(isset($_REQUEST['locding'])){echo selflodgingamount($_REQUEST['locding'],$_SESSION['ec_user_alias'],$_REQUEST['cindate'],$_REQUEST['coutdate']);}
else if(isset($_REQUEST['bodding'])){echo bordaingamount($_REQUEST['bodding'],$_SESSION['ec_user_alias'],$_REQUEST['cindate'],$_REQUEST['coutdate']);}
else if(isset($_REQUEST['forr'])){
	echo deleteitems($_REQUEST['dRef'],$_REQUEST['dId']);
}else if(isset($_REQUEST['sitem'])){
	echo deleteSingleitem($_REQUEST['dRef'],$_REQUEST['dId'],$_REQUEST['sitem']);
}
else{echo"<center><h1>Permission Denied</h1></center>";}
?>
