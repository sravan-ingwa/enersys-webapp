<?php
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['Create'])){
	$a=mysql_escape_string($_REQUEST['empId']);
	$b=mysql_escape_string($_REQUEST['nameOfTheEmp']);
	$c=designationGetId(mysql_escape_string($_REQUEST['designation']));
	$d=mysql_escape_string($_REQUEST['visitFromDate']);
	$e=mysql_escape_string($_REQUEST['visitToDate']);
	$f=mysql_escape_string($_REQUEST['noOfDays']);
	$g=mysql_escape_string($_REQUEST['placesOfVisit']);
	$h=mysql_escape_string($_REQUEST['purpose']);	
	/*$i=mysql_escape_string($_REQUEST['fare_total']);
	$j=mysql_escape_string($_REQUEST['hotel_total']);
	$k=mysql_escape_string($_REQUEST['local_total']);
	$l=mysql_escape_string($_REQUEST['other_total']);*/
	if(isset($_REQUEST['fare_amount']) && count($_REQUEST['fare_amount'])!=0){foreach($_REQUEST['fare_amount'] as $ff){$i+=$ff;}}else{$i=0;}
	if(isset($_REQUEST['hotel_amount']) && count($_REQUEST['hotel_amount'])!=0){foreach($_REQUEST['hotel_amount'] as $hh){$j+=$hh;}}else{$j=0;}
	if(isset($_REQUEST['local_amount']) && count($_REQUEST['local_amount'])!=0){foreach($_REQUEST['local_amount'] as $ll){$k+=$ll;}}else{$k=0;}
	if(isset($_REQUEST['other_amount']) && count($_REQUEST['other_amount'])!=0){foreach($_REQUEST['other_amount'] as $oo){$l+=$oo;}}else{$l=0;}
	$m=mysql_escape_string($_REQUEST['totalTourexpenses']);
	//$p=mysql_escape_string($_REQUEST['corporateDeductions']);
	//$q=mysql_escape_string($_REQUEST['corporateRemarks']);
	//$r=mysql_escape_string($_REQUEST['netExpensesBooked']);
	if($a==""){$result="Select Employee ID";}
	elseif($d==""){$result="Enter Visit From Date";}
	elseif($e==""){$result="Enter Visit To Date";}
	elseif($g==""){$result="Enter Places Of Visit";}
	elseif($h==""){$result="Enter Purpose";}
	else{
		$refid = checkx(rand(0000, 9999),'ss_book_expenses');
		//$sql = mysql_query("SELECT id FROM ss_book_expenses");
		//$count = (mysql_num_rows($sql)+1);
		//if($count > 999){$x = "BN".$count;}elseif($count > 99){$x = "BN0".$count;}elseif($count > 9){$x = "BN00".$count;}else{$x = "BN000".$count;}
		$x = billNo(1);
		if(isset($_REQUEST['circleDeductions']) || isset($_REQUEST['circleRemarks'])){
			$n=mysql_escape_string($_REQUEST['circleDeductions']);
			$o=mysql_escape_string($_REQUEST['circleRemarks']);
			$p = $m-$n;
			$ac = mysql_query("INSERT INTO ss_book_expenses(id,billNo,empId,nameOfTheEmp,designation,visitFromDate,visitToDate,noOfDays,placesOfVisit,purpose,fareINR,hotelBills,localConveyance,anyOtherExpenses,totalTourExpenses,circleDeductions,circleRemarks,netExpensesBooked,stat,createdDate,flag,period) VALUES('$refid','$x','$a','$b','$c','$d','$e','$f','$g','$h','$i','$j','$k','$l','$m','$n','$o','$p','1','".date('Y-m-d')."','0','".$_REQUEST['period']."')");
		}else{
			$ac = mysql_query("INSERT INTO ss_book_expenses(id,billNo,empId,nameOfTheEmp,designation,visitFromDate,visitToDate,noOfDays,placesOfVisit,purpose,fareINR,hotelBills,localConveyance,anyOtherExpenses,totalTourExpenses,netExpensesBooked,stat,createdDate,flag,period) VALUES('$refid','$x','$a','$b','$c','$d','$e','$f','$g','$h','$i','$j','$k','$l','$m','$m','0','".date('Y-m-d')."','0','".$_REQUEST['period']."')");
		}
	}

//if($_REQUEST['fare_amount'][0]!=""){	
	/* Fare INR Insert starts  */
	for($i=0;$i<count($_REQUEST['fare_amount']);$i++){
			$fa[$i]=mysql_escape_string($_REQUEST['fare_dateOfTravel'][$i]);
			$fb[$i]=mysql_escape_string($_REQUEST['fare_modeOfTravel'][$i]);
			$fc[$i]=mysql_escape_string($_REQUEST['fare_travelFrom'][$i]);
			$fd[$i]=mysql_escape_string($_REQUEST['fare_travelTo'][$i]);
			$fe[$i]=mysql_escape_string($_REQUEST['fare_amount'][$i]);
			$fid[$i] = checkx(rand(0000, 9999),'ss_book_expenses_fare');
			if(!empty($fe[$i])){
				$fare = mysql_query("INSERT INTO ss_book_expenses_fare(id,refId,dateOfTravel,modeOfTravel,travelFrom,travelTo,amount,flag) VALUES('$fid[$i]','$refid','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$fe[$i]','0')");
			}
		}
	/* Fare INR Insert ends  */
//}
//if($_REQUEST['hotel_amount'][0]!=""){	
	/* Hotel Bills Insert starts  */
	for($i=0;$i<count($_REQUEST['hotel_amount']);$i++){
		$ha[$i]=mysql_escape_string($_REQUEST['hotel_checkIn'][$i]);
		$hb[$i]=mysql_escape_string($_REQUEST['hotel_checkOut'][$i]);
		$hc[$i]=mysql_escape_string($_REQUEST['hotel_totalDays'][$i]);
		$hd[$i]=mysql_escape_string($_REQUEST['hotel_amount'][$i]);
		$hid[$i] = checkx(rand(0000, 9999),'ss_book_expenses_hotel');
		if(!empty($hd[$i])){
			$hotel = mysql_query("INSERT INTO ss_book_expenses_hotel(id,refId,checkInDate,checkOutDate,totalDays,amount,flag) VALUES('$hid[$i]','$refid','$ha[$i]','$hb[$i]','$hc[$i]','$hd[$i]','0')");
		}
	}
	/* Hotel Bills Insert ends  */
//}
//if($_REQUEST['local_amount'][0]!=""){	
	/* Local Conveyance Insert starts  */
	for($i=0;$i<count($_REQUEST['local_amount']);$i++){
		$la[$i]=mysql_escape_string($_REQUEST['local_dateOfTravel'][$i]);
		$lb[$i]=mysql_escape_string($_REQUEST['local_modeOfTravel'][$i]);
		$lc[$i]=mysql_escape_string($_REQUEST['local_travelFrom'][$i]);
		$ld[$i]=mysql_escape_string($_REQUEST['local_travelTo'][$i]);
		$le[$i]=mysql_escape_string($_REQUEST['local_amount'][$i]);
		$lid[$i] = checkx(rand(0000, 9999),'ss_book_expenses_local');
		if(!empty($le[$i])){
			$local = mysql_query("INSERT INTO ss_book_expenses_local(id,refId,dateOfTravel,modeOfTravel,travelFrom,travelTo,amount,flag) VALUES('$lid[$i]','$refid','$la[$i]','$lb[$i]','$lc[$i]','$ld[$i]','$le[$i]','0')");
		}
	}
	/* Local Conveyance Insert ends  */
//}
//if($_REQUEST['other_amount'][0]!=""){
	/* Any Other Expenses Insert starts  */
	for($i=0;$i<count($_REQUEST['other_amount']);$i++){
		$oa[$i]=mysql_escape_string($_REQUEST['other_desc'][$i]);
		$ob[$i]=mysql_escape_string($_REQUEST['other_amount'][$i]);
		$oid[$i] = checkx(rand(0000, 9999),'ss_book_expenses_other');
		if(!empty($ob[$i])){
			$other = mysql_query("INSERT INTO ss_book_expenses_other(id,refId,description,amount,flag) VALUES('$oid[$i]','$refid','$oa[$i]','$ob[$i]','0')");
		}
	}
	/* Any Other Expenses Insert ends  */	
//}
if($ac)$result="".errorMsg('ERRMSG001')."<script>document.getElementById('disable').disabled = true; setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
<div class="col-md-4 form-group">
    <label>Employee ID : </label>
    <?php /* ?><select tabindex="1" autofocus="autofocus" name="empId" class="form-control selectpicker" data-live-search="true" onchange="ajaxBookexpense(this.value)">
    <option value="" style="display:none;">Select Employee ID</option>
    <?php $sql = mysql_query("SELECT id,employeeId,employeeName,designation FROM ss_employee_details WHERE email='".$_SESSION['login_user']."'");
		  if(mysql_num_rows($sql)>0){ $row = mysql_fetch_array($sql);
				echo "<option value='".$row['id']."'>".$row['employeeId']."</option>";
			}
	?>
    </select><?php */ ?>
	<?php $sql = mysql_query("SELECT id,employeeId,employeeName,designation FROM ss_employee_details WHERE email='".$_SESSION['login_user']."'");
		  if(mysql_num_rows($sql)>0){ $row = mysql_fetch_array($sql);} ?>
	<input tabindex="1" class="form-control" type="hidden" name="empId" value="<?php echo $row['id']; ?>" />
	<input tabindex="1" class="form-control" type="text" value="<?php echo $row['employeeId']; ?>" placeholder="Employee ID" readonly/>
</div>
<div class="col-md-4 form-group">
    <label>Name of the Employee : </label>
    <input tabindex="2" class="form-control" type="text" name="nameOfTheEmp" value="<?php echo $row['employeeName']; ?>" placeholder="Name of the Employee" readonly/>
</div>
<div class="col-md-4 form-group">
    <label>Designation : </label>
    <input type="text" tabindex="3" name="designation" class="form-control" value="<?php echo designationGetName($row['designation']); ?>" placeholder="Designation" readonly/>
</div>
<div class="col-md-4 form-group">
    <label>Period of Visit From : </label>
    <input type='text' class="form-control visitFromDate" tabindex="4" name="visitFromDate" placeholder="Period of Visit From"/>
</div>
<div class="col-md-4 form-group">
    <label>Period of Visit To : </label>
    <input type='text' class="form-control visitToDate" tabindex="5" name="visitToDate" placeholder="Period of Visit To"/>
</div>
<div class="col-md-4 form-group">
    <label>Period : </label>
    <input type='text' class="form-control" tabindex="6" id="visitToDate" name="period" placeholder="Period" readonly/>
</div>
<div class="col-md-4 form-group">
    <label>No. of days: </label>
    <input type="text" tabindex="7" class="form-control" id="visitFromDate" name="noOfDays" placeholder="No. of days" readonly />
</div>
<div class="col-md-4 form-group">
    <label>Places of Visit : </label>
    <input type="text" tabindex="8" class="form-control" name="placesOfVisit" placeholder="Places of Visit"/>
</div>
<div class="col-md-4 form-group">
    <label>Purpose: </label>
    <textarea tabindex="9" class="form-control" name="purpose" placeholder="Purpose" ></textarea>
</div>
<div class="col-lg-12 form-group">
    <label>Fare – INR : </label>
    <div class="clearfix">
		<div class="column">
			<table class="table table-bordered table-hover" id="fare_tab">
				<thead class="bg-primary">
					<tr><th class="text-center">Date of travel</th><th class="text-center">Mode of travel</th><th class="text-center">From</th><th class="text-center">To</th><th class="text-center">Amount</th></tr>
				</thead>
				<tbody><tr id='fare0' class="text-center">
                            <td><input type="text" tabindex="10" class="form-control singleDateEnd" name="fare_dateOfTravel[]" placeholder="Date Of Travel"/></td>
                            <td><input type="text" tabindex="10" class="form-control" name="fare_modeOfTravel[]" placeholder="Mode Of Travel"/></td>
                            <td><input type="text" tabindex="10" class="form-control" name="fare_travelFrom[]" placeholder="From"/></td>
                            <td><input type="text" tabindex="10" class="form-control" name="fare_travelTo[]" placeholder="To"/></td>
                            <td><input type="text" tabindex="10" class="form-control fare tour" name="fare_amount[]" id="fare_amount0" placeholder="Amount"/></td>
						</tr>
                        <tr id='fare1' class="text-center"></tr>
				</tbody>
                    	<tr class="text-center">
                            <td colspan="2"><a id="fare_add_row" tabindex="10" class="form-control btn btn-default">Add Row</a></td>
                            <td colspan="2"><a id='fare_del_row' tabindex="10" class="form-control btn btn-default">Delete Row</a></td>
                            <td><input type="text" tabindex="10" class="form-control" name="fare_total" id="fare_total" placeholder="Total" readonly/></td>
                        </tr>
			</table>
		</div>
	</div>
</div>
<div class="col-lg-12 form-group">
    <label>Hotel Bills : </label>
    <div class="clearfix">
		<div class="column">
			<table class="table table-bordered table-hover" id="hotel_tab">
				<thead class="bg-primary">
					<tr><th class="text-center">Check in Date</th><th class="text-center">Check out Date</th><th class="text-center">Total Days</th><th class="text-center">Amount</th></tr>
				</thead>
				<tbody><tr id='hotel0' class="text-center">
                            <td><input type="text" tabindex="11" class="form-control checkIn0" name="hotel_checkIn[]" placeholder="Check In Date"/></td>
                            <td><input type="text" tabindex="11" class="form-control checkOut0" name="hotel_checkOut[]" placeholder="Check Out Date"/></td>
                            <td><input type="text" tabindex="11" class="form-control" id="checkIn0" name="hotel_totalDays[]" placeholder="Total Days" readonly /></td>
                            <td><input type="text" tabindex="11" class="form-control hotel tour" name="hotel_amount[]" id="hotel_amount0" placeholder="Amount"/></td>
						</tr>
                        <tr id='hotel1' class="text-center"></tr>
				</tbody>
                    	<tr class="text-center">
                            <td colspan="2"><a id="hotel_add_row" tabindex="11" class="form-control btn btn-default">Add Row</a></td>
                            <td><a id='hotel_del_row' tabindex="11" class="form-control btn btn-default">Delete Row</a></td>
                            <td><input type="text" tabindex="11" class="form-control" name="hotel_total" id="hotel_total" placeholder="Total" readonly/></td>
                        </tr>
			</table>
		</div>
	</div>
</div>
<div class="col-lg-12 form-group">
    <label>Local Conveyance : </label>
     <div class="clearfix">
		<div class="column">
			<table class="table table-bordered table-hover" id="local_tab">
				<thead class="bg-primary">
					<tr><th class="text-center">Date of travel</th><th class="text-center">Mode of travel</th><th class="text-center">From</th><th class="cntr">To</th><th class="text-center">Amount</th></tr>
				</thead>
				<tbody><tr id='local0' class="text-center">
                            <td><input type="text" tabindex="12" class="form-control singleDateEnd" name="local_dateOfTravel[]" placeholder="Date Of Travel"/></td>
                            <td><input type="text" tabindex="12" class="form-control" name="local_modeOfTravel[]" placeholder="Mode Of Travel"/></td>
                            <td><input type="text" tabindex="12" class="form-control" name="local_travelFrom[]" placeholder="From"/></td>
                            <td><input type="text" tabindex="12" class="form-control" name="local_travelTo[]" placeholder="To"/></td>
                            <td><input type="text" tabindex="12" class="form-control local tour" name="local_amount[]" id="local_amount0" placeholder="Amount"/></td>
						</tr>
                        <tr id='local1' class="text-center"></tr>
				</tbody>
                    	<tr class="text-center">
                            <td colspan="2"><a id="local_add_row" tabindex="12" class="form-control btn btn-default">Add Row</a></td>
                            <td colspan="2"><a id='local_del_row' tabindex="12" class="form-control btn btn-default">Delete Row</a></td>
                            <td><input type="text" tabindex="12" class="form-control" name="local_total" id="local_total" placeholder="Total" readonly/></td>
                        </tr>
			</table>
		</div>
	</div>
</div>
<div class="col-lg-12 form-group">
    <label>Any other Expenses (With details & Supporting Bills): </label>
      <div class="clearfix">
		<div class="column">
			<table class="table table-bordered table-hover" id="other_tab">
				<thead class="bg-primary">
					<tr><th colspan="2" class="text-center">Description</th><th class="text-center">Amount</th></tr>
				</thead>
				<tbody><tr id='other0' class="text-center">
                            <td colspan="2"><input type="text" tabindex="13" class="form-control" name="other_desc[]" placeholder="Description"/></td>
							<td><input type="text" tabindex="13" class="form-control other tour" name="other_amount[]" id="other_amount0" placeholder="Amount"/></td>
						</tr>
                        <tr id='other1' class="text-center"></tr>
				</tbody>
                    	<tr class="text-center">
                            <td><a id="other_add_row" tabindex="13" class="form-control btn btn-default">Add Row</a></td>
                            <td><a id='other_del_row' tabindex="13" class="form-control btn btn-default">Delete Row</a></td>
                            <td><input type="text" tabindex="13" class="form-control" name="other_total" id="other_total" placeholder="Total" readonly/></td>
                        </tr>
			</table>
		</div>
	</div>
</div>
<div class="col-md-4 form-group">
<label>Total Tour expenses: </label>
<input type="text" tabindex="14" class="form-control" name="totalTourexpenses" id="tour_total" placeholder="Total Tour expenses" readonly/>
</div>
<?php if(loginDetails($_SESSION['login_user'],"role")=='CO912'){ ?>
<div class="col-md-4 form-group"><label>&nbsp;</label><p>&nbsp;</p><br /></div>
<div class="col-md-4 form-group"><label>&nbsp;</label><p>&nbsp;</p><br /></div>
<div class="col-md-4 form-group">
<label>Circle deductions: </label>
<input type="text" tabindex="15" class="form-control" name="circleDeductions" id="circleDeduction" placeholder="Circle deductions"/>
</div>
<div class="col-md-4 form-group">
<label>Remarks By Circle: </label>
<input type="text" tabindex="16" class="form-control" name="circleRemarks" placeholder="Remarks"/>
</div>
<div class="col-md-4 form-group"><label>&nbsp;</label><span>&nbsp;</span></div>
<div class="col-md-4 form-group"><label>&nbsp;</label><span>&nbsp;</span></div>
<?php } ?>
<?php /*?>
<div class="col-md-4 form-group">
<label>Corporate deductions: </label>
<input type="text" tabindex="17" class="form-control" name="corporateDeductions" id="corpDeduction" placeholder="Corporate deductions"/>
</div>
<div class="col-md-4 form-group">
<label>Remarks: </label>
<input type="text" tabindex="18" class="form-control" name="corporateRemarks" placeholder="Remarks"/>
</div>
<div class="col-md-4 form-group"><label>&nbsp;</label><span>&nbsp;</span></div>
<div class="col-md-4 form-group"><label>&nbsp;</label><span>&nbsp;</span></div>
<div class="col-md-4 form-group">
<label>NET Expenses Booked: </label>
<input type="text" tabindex="19" class="form-control" name="netExpensesBooked" id="netExp" placeholder="NET Expenses Booked" readonly/>
</div>
<div class="col-md-4 form-group"><label>&nbsp;</label><p>&nbsp;</p><br /></div>
<div class="col-md-4 form-group"><label>&nbsp;</label><p>&nbsp;</p><br /></div><?php */?>
<div class="form-group col-xs-12 morpad">
    <div class="col-xs-12">
    <button tabindex="20" type="submit" class="btn btn-primary ss_buttons" id="disable" name="Create">Submit</button>
    <button tabindex="21" type="reset" class="btn btn-primary ss_buttons" name="reset">Reset</button>
	</div>
</div>
</form>
<?php
function billNo($i){
	$sql = mysql_query("SELECT billNo FROM ss_book_expenses");
	$num = (mysql_num_rows($sql)+$i);
	if($num > 999){$x = "BN".$num;}
	elseif($num > 99){$x = "BN0".$num;}
	elseif($num > 9){$x = "BN00".$num;}
	else{$x = "BN000".$num;}
	$sql1 = mysql_query("SELECT billNo FROM ss_book_expenses WHERE billNo='$x'");
	if(mysql_num_rows($sql1)==0){ return $x;}
	else{return billNo(($i+1)); }
}
?>