<?php
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['Update'])){
	$idx=mysql_escape_string($_REQUEST['idx']);	
	$contactNo=mysql_escape_string($_REQUEST['contactNox']);
	$empName=mysql_escape_string($_REQUEST['empNamex']);
	$billNo=mysql_escape_string($_REQUEST['billNox']);
	$nameOfTheEmp=mysql_escape_string($_REQUEST['nameOfTheEmpx']);
	$visitFromDate=mysql_escape_string($_REQUEST['visitFromDatex']);
	$visitToDate=mysql_escape_string($_REQUEST['visitToDatex']);
if($_REQUEST['stat']==0){
	$n=mysql_escape_string($_REQUEST['circleDeductions']);	
	$o=mysql_escape_string($_REQUEST['circleRemarks']);
	$totalTourExpenses=mysql_escape_string($_REQUEST['totalTourExpensesx']);
	if($n==""){$result="Enter Circle Deductions";}
	elseif($o==""){$result="Enter Remarks";}
	else{ $ta = $totalTourExpenses - $n;
	$ac = mysql_query("UPDATE ss_book_expenses SET circleDeductions='$n', circleRemarks='$o', netExpensesBooked='$ta', stat='1' WHERE id='$idx'");
	if($ac){$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";
	}else $result=errorMsg('ERRMSG002');
	}
}
elseif($_REQUEST['stat']==1){
	$n=mysql_escape_string($_REQUEST['corporateDeductions']);	
	$o=mysql_escape_string($_REQUEST['corporateRemarks']);
	if($n==""){$result="Enter Corporate Deductions";}
	elseif($o==""){$result="Enter Remarks";}
	else{
		$query=mysql_query("SELECT * FROM ss_book_expenses WHERE id='$idx'");
		$row = mysql_fetch_array($query);
		$a1=$row['totalTourExpenses'];
		$a2=$row['circleDeductions'];
		$totalTourExpenses = $a1-$a2;
		$ta=$a1-$a2-$n;
		$ac1 = mysql_query("UPDATE ss_book_expenses SET corporateDeductions='$n', corporateRemarks='$o',netExpensesBooked='$ta',stat='2' WHERE id='$idx'");
		$b1=current(explode(" ",$row['period']));
		$b2=$row['empId'];
		$querycv=mysql_query("SELECT id FROM ss_el_expense WHERE empId='$b2'");
		$count = mysql_num_rows($querycv);
		if($count==0){
			if($b1=="F1"){$fsd1= -$ta;}else{$fsd1="0";}
			if($b1=="F2"){$fsd2= -$ta;}else{$fsd2="0";}
			$tfb=$fsd1+$fsd2;
			$id = checkx(rand(0000, 9999),'ss_el_expense');
			$ac = mysql_query("INSERT INTO ss_el_expense(id,empId,empName,f1Balance,f2Balance,totalBalance,flag) VALUES('$id','$b2','$empName','$fsd1','$fsd2','$tfb','0')");
		}else{
			$sqlf1 = mysql_query("SELECT advCleared FROM ss_book_advance WHERE empId='$b2' AND advFor='F1' AND stat='2' AND flag='0'");
			while( $rowf1=mysql_fetch_array($sqlf1)){ $clr1 += $rowf1['advCleared'];}
			$sqlf2 = mysql_query("SELECT advCleared FROM ss_book_advance WHERE empId='$b2' AND advFor='F2' AND stat='2' AND flag='0'");
			while( $rowf2=mysql_fetch_array($sqlf2)){ $clr2 += $rowf2['advCleared'];}
			$sqlexp1 = mysql_query("SELECT netExpensesBooked FROM ss_book_expenses WHERE empId='$b2' AND period LIKE '%F1%' AND stat='2' AND flag='0'");
			while($rowexp1=mysql_fetch_array($sqlexp1)){$netExp1 += $rowexp1['netExpensesBooked'];}
			$sqlexp2 = mysql_query("SELECT netExpensesBooked FROM ss_book_expenses WHERE empId='$b2' AND period LIKE '%F2%' AND stat='2' AND flag='0'");
			while($rowexp2=mysql_fetch_array($sqlexp2)){$netExp2 += $rowexp2['netExpensesBooked'];}
			$tfb = $clr1 + $clr2 - ($netExp1 + $netExp2);
			if($b1=="F1"){$rfb1 = $clr1 - $netExp1;
				$ac = mysql_query("UPDATE ss_el_expense SET f1Balance='$rfb1', totalBalance='$tfb' WHERE empId='$b2'");
			}else{$rfb2 = $clr2 - $netExp2;
				$ac = mysql_query("UPDATE ss_el_expense SET f2Balance='$rfb2', totalBalance='$tfb' WHERE empId='$b2'");
			}
		}
		$ac2 = mysql_query("UPDATE ss_book_advance SET totalBalance='$tfb' WHERE empId='$b2'");
		if($ac && $ac1 && $ac2){
		/* Corporate Deductions SMS Function */
		$toMessage=urlencode("Dear ".$nameOfTheEmp." your tour bill No- ".$billNo." from dt- ".$visitFromDate." to ".$visitToDate." has been credited to the Ac on Date- ".date('Y-m-d')." .Claimed Amt- ".$totalTourExpenses." Passed Amt- ".$ta." Diff. Amt- ".$n."");
		messageSent($contactNo,$toMessage);
		/* Corporate Deductions SMS Function Close */
		$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";
		}else $result=errorMsg('ERRMSG002');
		}
	}
}
?>
<?php
$tb= menuName($_REQUEST['x'],"tbName");
$query = mysql_query("SELECT colName,colRef FROM ss_col_ref WHERE tbName='$tb' AND pView='0' ORDER BY ordering");
if(mysql_num_rows($query)>0){while($row=mysql_fetch_array($query)){$colName[]=$row['colName'];$colref[]=$row['colRef'];}}
$queryx=mysql_query("SELECT * FROM $tb WHERE id='".$_REQUEST['y'] ."'");
while($rowx=mysql_fetch_array($queryx)){for($cx=0;$cx<count($colref);$cx++){if($rowx[$colName[$cx]]!="")$outpot.="<div class='col-md-4 form-group'><label>".$colref[$cx]."</label><p readonly='readonly' class='form-control' style='margin:0;height:auto;max-height:55px;word-wrap:break-word;overflow:auto;'>".refname($colref[$cx],$rowx[$colName[$cx]],$rowx['id'])."</p></div>";}}

/*$query = mysql_query("SELECT colName,colRef FROM ss_col_ref WHERE tbName='ss_book_expenses_fare' AND pView='0' ORDER BY ordering");
if(mysql_num_rows($query)>0){while($row=mysql_fetch_array($query)){$colName[]=$row['colName'];$colref[]=$row['colRef'];}}
$queryx=mysql_query("SELECT * FROM ss_book_expenses_fare WHERE refId='$_REQUEST[y]'");
while($rowx=mysql_fetch_array($queryx)){for($cx=0;$cx<count($colref);$cx++){if($rowx[$colName[$cx]]!="")$outpot.="<div class='col-md-4 form-group'><label>".$colref[$cx]."</label><p readonly='readonly' class='form-control' style='margin:0;height:auto;max-height:55px;word-wrap:break-word;overflow:auto;'>".refname($colref[$cx],$rowx[$colName[$cx]],$rowx['id'])."</p></div>";}}
*/
$query=mysql_query("SELECT * FROM ss_book_expenses WHERE id='".$_REQUEST['y'] ."'");
$row = mysql_fetch_array($query);
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
<input name="idx" value="<?php echo $row['id'];?>" type="hidden"/>
<input name="billNox" value="<?php echo $row['billNo'];?>" type="hidden"/>
<input name="nameOfTheEmpx" value="<?php echo $row['nameOfTheEmp'];?>" type="hidden"/>
<input name="visitFromDatex" value="<?php echo $row['visitFromDate'];?>" type="hidden"/>
<input name="visitToDatex" value="<?php echo $row['visitToDate'];?>" type="hidden"/>
<input name="totalTourExpensesx" value="<?php echo $row['totalTourExpenses'];?>" type="hidden"/>
<input name="stat" value="<?php echo $row['stat'];?>" type="hidden"/>
<?php $query1=mysql_query("SELECT contactNo,employeeName FROM ss_employee_details WHERE id='".$row['empId']."'");
$row1 = mysql_fetch_array($query1); ?>
<input name="contactNox" value="<?php echo $row1['contactNo'];?>" type="hidden"/>
<input name="empNamex" value="<?php echo $row1['employeeName'];?>" type="hidden"/>
<?php if(isset($outpot) && $outpot!=""){echo $outpot;}?>
<?php if($row['stat']=='0'){ ?>
<div class="col-md-4 form-group">
<label>Circle deductions: </label>
<input type="text" tabindex="15" autofocus="autofocus" class="form-control" name="circleDeductions" placeholder="Circle deductions"/>
</div>
<div class="col-md-4 form-group">
<label>Remarks By Circle: </label>
<input type="text" tabindex="16" class="form-control" name="circleRemarks" placeholder="Remarks"/>
</div>
<div class="col-md-4 form-group"><label>&nbsp;</label><span>&nbsp;</span></div>
<div class="col-md-4 form-group"><label>&nbsp;</label><span>&nbsp;</span></div>
<?php }elseif($row['stat']=='1'){ ?>
<div class="col-md-4 form-group">
<label>NHS deductions: </label>
<input type="text" tabindex="17" class="form-control" name="corporateDeductions" id="corpDeduction" placeholder="Corporate deductions"/>
</div>
<div class="col-md-4 form-group">
<label>Remarks By NHS: </label>
<input type="text" tabindex="18" class="form-control" name="corporateRemarks" placeholder="Remarks"/>
</div>
<div class="col-md-4 form-group"><label>&nbsp;</label><span>&nbsp;</span></div>
<div class="col-md-4 form-group"><label>&nbsp;</label><span>&nbsp;</span></div>
<?php } ?>
<!--<div class="col-md-4 form-group">
<label>NET Expenses Booked: </label>
<input type="text" tabindex="19" class="form-control" name="netExpensesBooked" id="netExp" placeholder="NET Expenses Booked" readonly/>
</div>-->
<div class="col-md-4 form-group"><label>&nbsp;</label><p>&nbsp;</p><br /></div>
<div class="col-md-4 form-group"><label>&nbsp;</label><p>&nbsp;</p><br /></div>
<div class="form-group col-xs-12 morpad">
    <div class="col-xs-12">
    <button tabindex="20" type="submit" class="btn btn-primary ss_buttons" name="Update">Submit</button>
    <button tabindex="21" type="reset" class="btn btn-primary ss_buttons" name="reset">Reset</button>
	</div>
</div>
</form>