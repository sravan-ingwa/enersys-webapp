<?php 
if(isset($_REQUEST['update'])){
	date_default_timezone_set("Asia/Kolkata"); 
	$a=ucwords(mysql_escape_string($_REQUEST['customerName']));
	$b=strtoupper(mysql_escape_string($_REQUEST['customerCode']));
	$c=strtolower(mysql_escape_string($_REQUEST['email']));
	$d=mysql_escape_string($_REQUEST['contactNo']);
	$e=mysql_escape_string($_REQUEST['dispatch']);
	$f=mysql_escape_string($_REQUEST['installation']);
	$g=mysql_escape_string($_REQUEST['segment']);
	$h=mysql_escape_string($_REQUEST['schedule']);
	//$i= date('Y-m-d');
	if($a==""){$result="Enter Customer Name";}
	elseif($b==""){$result="Enter Customer Code";}
	elseif($c==""){$result="Enter Customer Email";}
	elseif($d==""){$result="Enter Customer contact Number";}
	elseif($e==""){$result="Enter Warranty Dispatch(Months)";}
	elseif($f==""){$result="Enter Warranty Installation(Months)";}
	elseif($g==""){$result="Select segment";}
	elseif($h==""){$result="Select Schedule";}
	else{
		$RefId =$_REQUEST['y'];
		$ac = mysql_query("UPDATE ss_customer_details SET customerName='".$a."' , customerCode='".$b."', email='".$c."', contactNo='".$d."', dispatch='".$e."', installation='".$f."', categories='".$g."', schedule='".$h."' WHERE id='$RefId'");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
	}
}
$RefId =$_REQUEST['y'];
$query1=mysql_query("SELECT * FROM ss_customer_details WHERE id='$RefId'");
$row = mysql_fetch_array($query1);
?>
<p class="errorP"><?php if(isset($result)){echo $result;} ?> </p>

<form role="form" class="ss_form" method="post" id="defaultForm">
<input type="hidden" name="y" value="<?php echo $RefId;?>" />
    <div class="col-md-4 form-group">
        <label>Customer Name</label>
        <input tabindex="1" autofocus="autofocus" class="form-control" type="text" name="customerName" value="<?php echo $row['customerName']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Customer Code</label>
        <input tabindex="2" type="text" name="customerCode" class="form-control fulcap" value="<?php echo $row['customerCode']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Customer Email</label>
        <input tabindex="3" type="text" name="email" class="form-control" value="<?php echo $row['email']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Contact Number</label>
        <input tabindex="4" type="text" name="contactNo" class="form-control" value="<?php echo $row['contactNo']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Warranty From Date Of Dispatch(Months)</label>
        <input tabindex="5" type="text" name="dispatch" class="form-control" value="<?php echo $row['dispatch']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Warranty From Date Of Installation(Months)</label>
        <input tabindex="6" type="text" name="installation" class="form-control" value="<?php echo $row['installation']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Segment</label>
        <select tabindex="7" name="segment" class="form-control"><option value="">[Select Segment]</option>
			<?php explodeEdit($row['categories'],'ss_customer_category','category');?>
		</select>
    </div>
    <div class="col-md-4 form-group">
        <label>Schedule</label>
        <select tabindex="8" name="schedule" class="form-control"><option value="">[Select Schedule]</option>
			<?php schedule($row['schedule']);?>
		</select>
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="update" tabindex="9">Update</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="10">Reset</button>
        </div>
    </div>
</form>
<?php function schedule($a){ for($i=0;$i<=5;$i++){ echo "<option value='$i' ".($i==$a ? 'selected' : '').">$i</option>"; } } ?>