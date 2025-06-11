<?php
session_start();
include('../functions.php');
if(isset($_REQUEST['ref']) && $_REQUEST['ref']=='editAdvance'){
	$empalias=$_SESSION['ec_user_alias'];
	$ref='viewadvance';
	$alias=$_REQUEST['id'];
	$reasonForAdv=$_REQUEST['reasonForAdv'];
	$reqdate=date("Y-m-d");
	$limit =8;
	$sql="UPDATE ec_advances SET approval_level='$limit',approved_by='$empalias' WHERE advance_alias='$alias'";
	if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Rejected successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Approval Failed</p>";
	$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
	if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BA','$alias','$empalias','$alias_remark')");
	if(file_exists('viewadvance.php')){include('viewadvance.php');}
	$url="http://enersyscare.co.in/enersys_expense/maillings/book_advance.php?ref=".$alias;
	file_get_contents($url);
	//asyncInclude($url);
}
if(isset($_REQUEST['ref']) && $_REQUEST['ref']=='editExpense'){
	$empalias=$_SESSION['ec_user_alias'];
	$ref='viewexpense';
	$alias=$_REQUEST['id'];
	$reasonForAdv=$_REQUEST['reasonForAdv'];
	$reqdate=date("Y-m-d");
	$limit =8;
	$sql="UPDATE ec_expenses SET approval_level='$limit' WHERE expenses_alias='$alias'";
	if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Rejected successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Approval Failed</p>";
	$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
	if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
	if(file_exists('viewexpense.php')){include('viewexpense.php');}
	$url="http://enersyscare.co.in/enersys_expense/maillings/book_expense.php?ref=".$alias;
	file_get_contents($url);
	//asyncInclude($url);

}

if(isset($_REQUEST['ref']) && $_REQUEST['ref']=='serEditExpense'){
	$empalias=$_SESSION['ec_user_alias'];
	$ref='viewexpense';
	$alias=$_REQUEST['id'];
	$reasonForAdv=$_REQUEST['reasonForAdv'];
	$reqdate=date("Y-m-d");
	$limit =8;
	$sql="UPDATE ec_expenses SET approval_level='$limit' WHERE expenses_alias='$alias'";
	if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Rejected successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Approval Failed</p>";
	$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
	if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
	if(file_exists('viewexpense.php')){include('viewexpense.php');}
	$url="http://enersyscare.co.in/enersys_expense/maillings/book_expense.php?ref=".$alias;
	file_get_contents($url);
	//asyncInclude($url);

}


?>