<?php
include('mysql.php');include('functions.php');
$to = $_REQUEST['to'];
if($to == "site"){ ?>
<div class="col-md-4 form-group">
 <label>TT Number : </label>
  <select class="selectpicker form-control" name="ttNumber" tabindex="4" data-live-search="true" onchange="ajaxOutward(this.value,'invent')">
    <option value="" selected disabled style="display:none;">Select TT Number</option>
		<?php $sql1 = mysql_query("SELECT ttNumber FROM ss_material_outward WHERE ttNumber<>'' AND flag='0' GROUP BY ttNumber");
        $tt = array(); while($row1 = mysql_fetch_array($sql1)){ $tt[] = $row1['ttNumber'];} $tts = "'".implode("','",$tt)."'";
		$sql = mysql_query("SELECT ticketId FROM ss_tickets WHERE errorMessage='NHS Accepted' AND ticketId NOT IN ($tts) AND flag='0' ");
        while($row = mysql_fetch_array($sql)){ echo "<option value='".$row['ticketId']."'>".$row['ticketId']."</option>";} ?>
  </select>
</div>
<div class="col-md-4 form-group">
    <label>Customer Code: </label>
    <input tabindex="4" type="text" class="form-control" id="invent0" name="customerCode" placeholder="Customer Code" readonly />
</div>
<div class="col-md-4 form-group">
    <label>Site Names : </label>
    <input tabindex="4" type="text" class="form-control" id="invent1" name="siteName" placeholder="Site Name" readonly />
</div>
<div class="col-md-4 form-group">
    <label>District : </label>
    <input tabindex="4" type="text" class="form-control" id="invent2" name="district" placeholder="District" readonly />
</div>
<? }elseif($to == "ist"){?>
<div class="col-md-4 form-group">
    <label>To w/h : </label>
    <select tabindex="4" name="toWh" class="form-control">
    <option value="">Select to w/h</option><?php whareHouseOptions(); ?>
    </select>
</div>
<?php }else{} ?>