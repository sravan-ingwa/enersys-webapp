<?php 
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['Create'])){
	$a=ucwords(mysql_escape_string($_REQUEST['customerName']));
	$b=strtoupper(mysql_escape_string($_REQUEST['customerCode']));
	$c=strtolower(mysql_escape_string($_REQUEST['email']));
	$d=mysql_escape_string($_REQUEST['contactNo']);
	$e=mysql_escape_string($_REQUEST['dispatch']);
	$f=mysql_escape_string($_REQUEST['installation']);
	$g=mysql_escape_string($_REQUEST['segment']);
	$h=mysql_escape_string($_REQUEST['schedule']);
	$i= date('Y-m-d');
	if($a==""){$result="Enter Customer Name";}
	elseif($b==""){$result="Enter Customer Code";}
	elseif($c==""){$result="Enter Customer Email";}
	elseif($d==""){$result="Enter Customer contact Number";}
	elseif($e==""){$result="Enter Warranty Dispatch(Months)";}
	elseif($f==""){$result="Enter Warranty Installation(Months)";}
	elseif($g==""){$result="Select Segment";}
	elseif($h==""){$result="Select Schedule";}
	else{
		$query=mysql_query("SELECT id FROM ss_customer_details WHERE customerCode ='$b' AND categories='$g' AND flag='0'");
		$count=mysql_num_rows($query);
		if($count==0){
			$id = checkx(rand(0000, 9999),'ss_customer_details');
			$ac = mysql_query("INSERT INTO ss_customer_details(id,customerName,customerCode,email,contactNo,dispatch,installation,categories,schedule,createdDate,flag) VALUES('$id','$a','$b','$c','$d','$e','$f','$g','$h','$i','0')");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
		}else{$result=errorMsg('ERRMSG003');}
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
    <div class="col-md-4 form-group">
        <label>Customer Name</label>
        <input tabindex="1" autofocus="autofocus" type="text" class="form-control" name="customerName" placeholder="Enter Customer Name">
    </div>
    <div class="col-md-4 form-group">
        <label>Customer Code</label>
        <input tabindex="2" type="text" name="customerCode" class="form-control fulcap" placeholder="Enter Product Code">
    </div>
    <div class="col-md-4 form-group">
        <label>Customer Email</label>
        <input tabindex="3" type="text" name="email" class="form-control" placeholder="Enter Email Address">
    </div>
    <div class="col-md-4 form-group">
        <label>Contact Number</label>
        <input tabindex="4" type="text" name="contactNo" class="form-control" placeholder="Enter Contact Number">
    </div>
    <div class="col-md-4 form-group">
        <label>Warranty From Dispatch</label>
        <input tabindex="5" type="text" name="dispatch" class="form-control" placeholder="Warranty From Dispatch(Months)">
    </div>
    <div class="col-md-4 form-group">
        <label>Warranty From Installation</label>
        <input tabindex="6" type="text" name="installation" class="form-control" placeholder="Warranty From Installation(Months)">
    </div>
    <div class="col-md-4 form-group">
        <label>Segment</label>
        <select tabindex="7" name="segment" class="form-control"><option value="">[Select Segment]</option><?php customerCategoryOption();?></select>
    </div>
    <div class="col-md-4 form-group">
        <label>Schedule</label>
        <select tabindex="8" name="schedule" class="form-control">
        <?php for($xz=0;$xz<=5;$xz++){echo "<option value='$xz'>$xz</option>";}?>
		</select>
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="Create" tabindex="9">Create</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="10">Reset</button>
        </div>
    </div>
</form>