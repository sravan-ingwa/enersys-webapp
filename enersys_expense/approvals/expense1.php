<!DOCTYPE html>
<html lang="en">
<head>
<title>Enersys Care</title>
<link rel="icon" href="img/favicon.png" type="image/png">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link href="../css/bootstrap.css" rel="stylesheet">
<link href="../css/main.css" rel="stylesheet">
</head>
<body>
	<div class="container-fluid navbar-fixed-top" align="center"><img src="../img/EnerSyslogo.png" width="250"></div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title" style="display:inline-block;">Advance Request</h3>
        </div>
        <div class="panel-body">

<?php
date_default_timezone_set("Asia/Kolkata");
include('../functions1.php');
if(isset($_REQUEST['submitt'])){
	$alias=$_REQUEST['id'];
	$empalias=$_REQUEST['approver'];
	$response=$_REQUEST['type'];
	$reasonForAdv=$_REQUEST['remarks'];
	$reqdate=date("Y-m-d");
	if($response=='1'){
		if($_REQUEST['ref2']=='1'){
				$sql="UPDATE ec_expenses SET approval_level='2',approved_by='$empalias',approved_date='$reqdate' WHERE expenses_alias='$alias'";
				if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Approved successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Approval Failed</p>";
				$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
				if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
				$url="http://enersyscare.co.in/enersys_expense/maillings/book_expense1.php?ref=".$alias;
				file_get_contents($url);
				//asyncInclude($url);
		}
		if($_REQUEST['ref2']=='2'){
				$po_gnr=$_REQUEST['po_gnr'];
				$approved_by=expensedetlimited('approved_by',$alias)."|".$empalias;
				$approved_date=expensedetlimited('approved_date',$alias)."|".$reqdate;
				$sql="UPDATE ec_expenses SET approval_level='3', po_gnr='$po_gnr',approved_by='$approved_by',approved_date='$approved_date' WHERE expenses_alias='$alias'";
				if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Approved successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Approval Failed</p>";
				$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
				if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
				$url="http://enersyscare.co.in/enersys_expense/maillings/book_expense1.php?ref=".$alias;
				file_get_contents($url);
				//asyncInclude($url);
				}
		if($_REQUEST['ref2']=='3'){
				$approved_by=expensedetlimited('approved_by',$alias)."|".$empalias;
				$approved_date=expensedetlimited('approved_date',$alias)."|".$reqdate;
				$sql="UPDATE ec_expenses SET approval_level='4',approved_by='$approved_by',approved_date='$approved_date' WHERE expenses_alias='$alias'";
				if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Approved successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Approval Failed</p>";
				$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
				if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
				$url="http://enersyscare.co.in/enersys_expense/maillings/book_expense1.php?ref=".$alias;
				file_get_contents($url);
				//asyncInclude($url);
		}
		if($_REQUEST['ref2']=='4'){
				$approved_by=expensedetlimited('approved_by',$alias)."|".$empalias;
				$approved_date=expensedetlimited('approved_date',$alias)."|".$reqdate;
				$sql="UPDATE ec_expenses SET approval_level='6',approved_by='$approved_by',approved_date='$approved_date' WHERE expenses_alias='$alias'";
				if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Approved successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Approval Failed</p>";
				$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
				if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
				$url="http://enersyscare.co.in/enersys_expense/maillings/book_expense1.php?ref=".$alias;
				file_get_contents($url);
				//asyncInclude($url);
		}
	}else{
		$limit =8;
		$sql="UPDATE ec_expenses SET approval_level='$limit' WHERE expenses_alias='$alias'";
		if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Rejected successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Approval Failed</p>";
		$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
		if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
		if(file_exists('viewexpense.php')){include('viewexpense.php');}
		$url="http://enersyscare.co.in/enersys_expense/maillings/book_expense1.php?ref=".$alias;
		file_get_contents($url);
		//asyncInclude($url);
	}
}
if(isset($_REQUEST['ref'])){
	$adv_ali=$_REQUEST['ref'];
	$approver=$_REQUEST['apby'];
	$response=$_REQUEST['type'];
	//$adv_ali="VR99KSZYYG";
	if($adv_ali!=""){
		$advList=expensefullView($adv_ali);
		$level=$advList[0]['approval_level'];?>
		
            <form action="" method="post" novalidate>
            	<?php echo $message;?>
                <input type="hidden" name="id" value="<?php echo $adv_ali;?>"/>
                <input type="hidden" name="approver" value="<?php echo $approver;?>"/>
                <input type="hidden" name="type" value="<?php echo $response;?>"/>
                <input type="hidden" name="ref2" value="<?php echo $level;?>"/>
				<?php if($level=='2' && $response==1){?>
                <div class="col-md-4 col-md-offset-2 form-group">
                    <label>PO/ GNR Number<sup>*</sup> : </label>
                    <input tabindex="1" class="form-control amtt" name="po_gnr" placeholder="PO/ GNR Number" type="text" required />
                </div>
                <?php }?>
                <div class="col-md-12 form-group checkf">
                <label>Remarks:</label>
                <textarea name="remarks" class="form-control" rows="7" required></textarea>
                </div>
                <div class="col-md-4 col-md-offset-4">
                <input type="submit" name="submitt" class="btn btn-primary ss_buttons updatex" value="<?php if($response==1)echo "Accept"; else echo "Reject";?>"/>
            	</div>
            </form>
		<?php 
	}
}
?>
        </div>
    </div>
</body>
</html>
