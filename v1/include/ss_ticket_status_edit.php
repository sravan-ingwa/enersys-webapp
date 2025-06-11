<?php 
if(isset($_REQUEST['update'])){
	$a=mysql_escape_string($_REQUEST['ticketStatus']);
	if($a==""){$result="Enter Ticket Status";}
	else{
		$RefId =$_REQUEST['y'];
		$ac = mysql_query("UPDATE ss_ticket_status SET ticketStatus = '".$a."' WHERE id='$RefId'");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
	}
}
$RefId =$_REQUEST['y'];
$query1=mysql_query("SELECT * FROM ss_ticket_status WHERE id='$RefId'");
$row = mysql_fetch_array($query1);
?>
<p class="errorP"><?php if(isset($result)){echo $result;} ?> </p>

<form role="form" class="ss_form" method="post" id="defaultForm">
<input type="hidden" name="y" value="<?php echo $RefId;?>" />
    <div class="col-md-4 form-group">
        <label>Ticket Status</label>
        <input tabindex="1" autofocus="autofocus" type="text" class="form-control" name="ticketStatus" value="<?php echo $row['ticketStatus']; ?>">
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="update" tabindex="2">Update</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="3">Reset</button>
        </div>
    </div>
</form>