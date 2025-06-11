<?php
if(isset($_REQUEST['update'])){
	if($_REQUEST['oldStat']==0){
		$a=mysql_escape_string($_REQUEST['costTowardsWarranty']);
		$b=mysql_escape_string($_REQUEST['costTowardsBillable']);
		$c=mysql_escape_string($_REQUEST['submittedDate']);
		$d=mysql_escape_string($_REQUEST['COORemarks']);

		if($a==""){$result="Enter Cost Towards Warranty";}
		elseif($b==""){$result="Enter Cost Towards Billable";}
		elseif($c==""){$result="Enter Submitted Date";}
		elseif($d==""){$result='Enter COO Remarks';}
		else{
			$RefId = $_REQUEST['y'];
			$ac = mysql_query("UPDATE ss_esca_expense SET costTowardsWarranty='$a', costTowardsBillable='$b', submittedDate='$c', COORemarks='$d', stat='1' WHERE id='$RefId'");
			if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>"; else $result=errorMsg('ERRMSG002');
		}
	}elseif($_REQUEST['oldStat']==1){
		$a=mysql_escape_string($_REQUEST['stat']);
		if($a==''){$result='Select NHS Approval';}
		else{
			$RefId = $_REQUEST['y'];
			$ac = mysql_query("UPDATE ss_esca_expense SET stat='$a' WHERE id='$RefId'");
			if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
		}
	}elseif($_REQUEST['oldStat']==2){
		$a=mysql_escape_string($_REQUEST['paymentStatus']);
		$b=mysql_escape_string($_REQUEST['paymentDate']);
		if($a==""){$result="Enter Payment Status";}
		elseif($b==""){$result="Choose Payment Date";}
		else{
			$RefId = $_REQUEST['y'];
			$ac = mysql_query("UPDATE ss_esca_expense SET paymentStatus='$a', paymentDate='$b', stat='3' WHERE id='$RefId'");
			if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
		}
	
	}
}

$tb= menuName($_REQUEST['x'],"tbName");
$query = mysql_query("SELECT colName,colRef FROM ss_col_ref WHERE tbName='$tb' AND pView='0' ORDER BY ordering");
if(mysql_num_rows($query)>0){while($row=mysql_fetch_array($query)){$colName[]=$row['colName'];$colref[]=$row['colRef'];}}
$queryx=mysql_query("SELECT * FROM $tb WHERE id='$_REQUEST[y]'");
while($rowx=mysql_fetch_array($queryx)){for($cx=0;$cx<count($colref);$cx++){if($rowx[$colName[$cx]]!="")$outpot.="<div class='col-md-4 form-group'><label>".$colref[$cx]."</label><p readonly='readonly' class='form-control' style='margin:0;height:auto;max-height:55px;word-wrap:break-word;overflow:auto;'>".refname($colref[$cx],$rowx[$colName[$cx]],$rowx['id'])."</p></div>";}}

$RefId =$_REQUEST['y'];
$query1=mysql_query("SELECT * FROM ss_esca_expense WHERE id='$RefId'");
$row = mysql_fetch_array($query1);
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
<input type="hidden" name="y" value="<?php echo $RefId;?>" />
<input type="hidden" name="oldStat" value="<?php echo $row['stat'];?>" />
<?php if(isset($outpot)&& $outpot!=""){echo $outpot;}
if($row['stat'] == 0){ ?>
<div class="col-md-4 form-group">
    <label>Cost towards Warranty : </label>
    <input type="text" tabindex="13" class="form-control" name="costTowardsWarranty" value="<?php echo $row['costTowardsWarranty']; ?>" placeholder="Cost towards Warranty" >
</div>
<div class="col-md-4 form-group">
    <label>Cost towards Billable : </label>
    <input type="text" tabindex="14" class="form-control" name="costTowardsBillable" value="<?php echo $row['costTowardsBillable']; ?>" placeholder="Cost towards Billable" >
</div>
<div class="col-md-4 form-group">
    <label>Submitted Date : </label>
    <input type="text" tabindex="15" class="form-control singleDateEnd" name="submittedDate" value="<?php echo $row['submittedDate']; ?>" placeholder="Submitted Date" >
</div>
<div class="col-md-4 form-group">
    <label>COO Remarks : </label>
    <textarea tabindex="16" class="form-control" name="COORemarks" placeholder=" COO Remarks"><?php echo $row['COORemarks']; ?></textarea>
</div>
<?php }if($row['stat'] == 1){ ?>
<div class="col-md-4 form-group">
 <label>NHS Approval : </label>
	  <select class="form-control" autofocus="autofocus" tabindex="17" name="stat">
		<option value="">Select Approval</option><option value="2">Accept</option><option value="0">Reject</option>
	  </select>
  </div>
<?php }elseif($row['stat'] == 2 ){ ?>
<div class="col-md-4 form-group">
    <label>Payment Status : </label>
    <input type="text" tabindex="18" class="form-control" name="paymentStatus" value="<?php echo $row['paymentStatus']; ?>" placeholder="Payment Status">
</div>
<div class="col-md-4 form-group">
    <label>Payment Date : </label>
    <input type="text" tabindex="19" class="form-control singleDateEnd" name="paymentDate" value="<?php echo $row['paymentDate']; ?>" placeholder="Payment Date">
</div>
<?php } ?>
<div class="form-group col-xs-12 morpad">
    <div class="col-xs-12">
    <button tabindex="20" type="submit" class="btn btn-primary ss_buttons" name="update">Update</button>
    <button tabindex="21" type="reset" class="btn btn-primary ss_buttons" name="reset">Reset</button>
	</div>
</div>
</form>