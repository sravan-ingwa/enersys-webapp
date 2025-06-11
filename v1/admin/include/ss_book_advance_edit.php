<?php
	date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['Create'])){
	$a=mysql_escape_string($_REQUEST['empname']);
	$b=mysql_escape_string($_REQUEST['empid']);
	$bb=mysql_escape_string($_REQUEST['contactNox']);
	$c=mysql_escape_string($_REQUEST['advReq']);
	$cc=mysql_escape_string($_REQUEST['year']);
	$f=mysql_escape_string($_REQUEST['advFor']);
	$g=mysql_escape_string($_REQUEST['total']);
	$RefId = $_REQUEST['y'];
	
	if($_REQUEST['oldStat']==0){
		$d=mysql_escape_string($_REQUEST['advCleared']);
		$e=mysql_escape_string($_REQUEST['remarksNHS']);
		if($d==""){$result="Enter Advance Cleared";}
		else{
			$ac = mysql_query("UPDATE ss_book_advance SET advCleared='$d' , remarksNHS='$e', totalBalance='$g', stat='1' WHERE id='$RefId'");
			if($d >= 0 && $ac){
				/* Corporate Deductions SMS Function */
				$toMessage=urlencode("Dear ".$a." against your advance request of ".$f."-".$cc." has been approved on Dated- ".date('Y-m-d')." .Requested Amt- ".$c." Passed Amt- ".$d." Diff. Amt- ".($c-$d)."");
				messageSent($bb,$toMessage);
				/* Corporate Deductions SMS Function Close */
				$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";
			}
		}
	}elseif($_REQUEST['oldStat']==1){
		$aa = mysql_escape_string($_REQUEST['stat']);
		if($aa==""){$result="Choose Status";}
		else{
			$que=mysql_query("SELECT advCleared FROM ss_book_advance WHERE stat='1' AND id='$RefId'");
			$rou= mysql_fetch_array($que);
			$d = $rou['advCleared'];
			$ac1 = mysql_query("UPDATE ss_book_advance SET stat='$aa', closingDate='".date('Y-m-d')."' WHERE id='$RefId'");
			$query=mysql_query("SELECT id FROM ss_el_expense WHERE empId='$b'");
			$count=mysql_num_rows($query);
			if($count==0){
				if($f=="F1"){$fsd1=$d;}else{$fsd1="0";}
				if($f=="F2"){$fsd2=$d;}else{$fsd2="0";}
				$tfb=$fsd1+$fsd2;
				$id = checkx(rand(0000, 9999),'ss_el_expense');
				$ac = mysql_query("INSERT INTO ss_el_expense(id,empId,empName,f1Balance,f2Balance,totalBalance,flag) VALUES('$id','$b','$a','$fsd1','$fsd2','$tfb','0')");
			}else{
				$sqlf1 = mysql_query("SELECT advCleared FROM ss_book_advance WHERE empId='$b' AND advFor='F1' AND stat='2' AND flag='0'");
				while( $rowf1=mysql_fetch_array($sqlf1)){ $clr1 += $rowf1['advCleared'];}
				$sqlf2 = mysql_query("SELECT advCleared FROM ss_book_advance WHERE empId='$b' AND advFor='F2' AND stat='2' AND flag='0'");
				while( $rowf2=mysql_fetch_array($sqlf2)){ $clr2 += $rowf2['advCleared'];}
				$sqlexp1 = mysql_query("SELECT netExpensesBooked FROM ss_book_expenses WHERE empId='$b' AND period LIKE '%F1%' AND stat='2' AND flag='0'");
				while($rowexp1=mysql_fetch_array($sqlexp1)){$netExp1 += $rowexp1['netExpensesBooked'];}
				$sqlexp2 = mysql_query("SELECT netExpensesBooked FROM ss_book_expenses WHERE empId='$b' AND period LIKE '%F2%' AND stat='2' AND flag='0'");
				while($rowexp2=mysql_fetch_array($sqlexp2)){$netExp2 += $rowexp2['netExpensesBooked'];}
				$tfb = $clr1 + $clr2 - ($netExp1 + $netExp2);
				if($f=="F1"){ $rfb1 = $clr1 - $netExp1;
					$ac = mysql_query("UPDATE ss_el_expense SET f1Balance='$rfb1', totalBalance='$tfb' WHERE empId='$b'");
				}else{$rfb2 = $clr2 - $netExp2;
					$ac = mysql_query("UPDATE ss_el_expense SET f2Balance='$rfb2', totalBalance='$tfb' WHERE empId='$b'");
				}
			}
			$ac2 = mysql_query("UPDATE ss_book_advance SET totalBalance='$tfb' WHERE id='$RefId'");
		}
		if($ac && $ac1 && $ac2){$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";
		}else $result=errorMsg('ERRMSG002');
	}
}
$tb= menuName($_REQUEST['x'],"tbName");
$query = mysql_query("SELECT colName,colRef FROM ss_col_ref WHERE tbName='$tb' AND pView='0' ORDER BY ordering");
if(mysql_num_rows($query)>0){while($row=mysql_fetch_array($query)){$colName[]=$row['colName'];$colref[]=$row['colRef'];}}
$queryx=mysql_query("SELECT * FROM $tb WHERE id='$_REQUEST[y]'");
while($rowx=mysql_fetch_array($queryx)){for($cx=0;$cx<count($colref);$cx++){if($rowx[$colName[$cx]]!="")$outpot.="<div class='col-md-4 form-group'><label>".$colref[$cx]."</label><p readonly='readonly' class='form-control' style='margin:0;height:auto;max-height:55px;word-wrap:break-word;overflow:auto;'>".refname($colref[$cx],$rowx[$colName[$cx]],$rowx['id'])."</p></div>";}}
$query=mysql_query("SELECT * FROM ss_book_advance WHERE id='".$_REQUEST['y'] ."'");
$row = mysql_fetch_array($query);
$queryxc=mysql_query("SELECT * FROM ss_el_expense WHERE empId='".$row['empId'] ."'");
$rowxc = mysql_fetch_array($queryxc);

?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
<input name="y" value="<?php echo $_REQUEST['y'];?>" type="hidden"/>
<input name="x" value="<?php echo $_REQUEST['x'];?>" type="hidden"/>
<input name="empid" value="<?php echo $row['empId'];?>" type="hidden"/>
<input name="empname" value="<?php echo $row['nameOfEmployee'];?>" type="hidden"/>
<input name="advFor" value="<?php echo $row['advFor'];?>" type="hidden"/>
<input name="year" value="<?php echo $row['year'];?>" type="hidden"/>
<input name="advReq" value="<?php echo $row['advRequested'];?>" type="hidden"/>
<input name="oldStat" value="<?php echo $row['stat'];?>" type="hidden"/>
<input name="total" value="<?php echo $rowxc['totalBalance'];?>" type="hidden"/>
<?php $query1=mysql_query("SELECT contactNo,employeeName FROM ss_employee_details WHERE id='".$row['empId']."'");
$row1 = mysql_fetch_array($query1); ?>
<input name="contactNox" value="<?php echo $row1['contactNo'];?>" type="hidden"/>
<input name="empNamex" value="<?php echo $row1['employeeName'];?>" type="hidden"/>
<?php /*?>***Already Enter data***<?php */?>
<?php if(isset($outpot)&& $outpot!=""){echo $outpot;}?>
<?php /*?>***Already Enter data***<?php */?>
<?php
	//if($row['advFor']=="F1"){echo "<div class='col-md-4 form-group'><label>F1 Balance: </label><p readonly='readonly' class='form-control' style='margin:0;height:auto;max-height:55px;word-wrap:break-word;overflow:auto;'>";if($rowxc['f1Balance']!=""){echo $rowxc['f1Balance'];}else{echo"Nill";}echo"</p></div>";}
	//if($row['advFor']=="F2"){echo "<div class='col-md-4 form-group'><label>F2 Balance: </label><p readonly='readonly' class='form-control' style='margin:0;height:auto;max-height:55px;word-wrap:break-word;overflow:auto;'>";if($rowxc['f2Balance']!=""){echo $rowxc['f2Balance'];}else{echo"Nill";}echo"</p></div>";}
//echo "<div class='col-md-4 form-group'><label>Total Balance: </label><p readonly='readonly' class='form-control' style='margin:0;height:auto;max-height:55px;word-wrap:break-word;overflow:auto;'>";if($rowxc['totalBalance']==""){echo"Nill";}else{echo $rowxc['totalBalance'];}echo"</p></div>";
	?>
<?php $query2 = mysql_query("SELECT netExpensesBooked FROM ss_book_expenses WHERE empId='$row[empId]' AND (stat='0' OR stat='1') AND flag='0'");
while($row2 = mysql_fetch_array($query2)){$netExp += $row2['netExpensesBooked'];} ?>
<div class="col-md-4 form-group">
    <label>Pending Expenses : </label>
    <input type="text" tabindex="1" class="form-control" placeholder="Advance Cleared" value="<?php echo $netExp; ?>" readonly />
</div>
<?php if($row['stat']=='0'){ ?>
<div class="col-md-4 form-group">
    <label>Advance Cleared : </label>
    <input type="text" tabindex="1" autofocus="autofocus" class="form-control" name="advCleared" placeholder="Advance Cleared"/>
</div>
<div class="col-md-4 form-group">
    <label>Remarks By NHS: </label>
    <textarea tabindex="2" class="form-control" name="remarksNHS" ></textarea>
</div>
<?php }elseif($row['stat']=='1'){ ?>
<div class="col-md-4 form-group">
    <label>Status: </label>
    <select tabindex="3" class="form-control" name="stat" >
		<option value="">Select Status</option>
		<option value="2">Request sent to finance</option>
	</select>
</div>
<?php } ?>
<div class="form-group col-xs-12 morpad">
    <div class="col-xs-12">
    <button tabindex="4" type="submit" class="btn btn-primary ss_buttons" name="Create">Submit</button>
    <button tabindex="5" type="reset" class="btn btn-primary ss_buttons" name="reset">Reset</button>
	</div>
</div>
</form>