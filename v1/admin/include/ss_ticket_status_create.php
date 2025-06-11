<?php 
if(isset($_REQUEST['Create'])){
	$a=mysql_escape_string($_REQUEST['ticketStatus']);
	if($a==""){$result="Enter Ticket Status";}
	else{
		$query=mysql_query("SELECT * FROM ss_ticket_status WHERE ticketStatus ='$a'");
		$count=mysql_num_rows($query);
		if($count==0){
			$d = checkx(rand(0000, 9999),'ss_ticket_status');
			$ac = mysql_query("INSERT INTO ss_ticket_status(id,ticketStatus,flag) value('$d','$a','0')");
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
		}else{$result=errorMsg('ERRMSG003');}
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
    <div class="col-md-4 form-group">
        <label>Ticket Status</label>
        <input tabindex="1" autofocus="autofocus" class="form-control" type="text" name="ticketStatus" placeholder="Ticket Status">
    </div>
   <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="Create" tabindex="2">Create</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="3">Reset</button>
        </div>
    </div>
</form>