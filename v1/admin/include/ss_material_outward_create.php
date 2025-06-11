<?php
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['Create'])){
	$a=mysql_escape_string($_REQUEST['mrfNumber']);
	$b=whareHouseGetID(mysql_escape_string($_REQUEST['fromWh']));
	$c=mysql_escape_string($_REQUEST['toWh']);
	$d=mysql_escape_string($_REQUEST['dateOfTransation']);
	$e=mysql_escape_string($_REQUEST['ttNumber']);
	$f=mysql_escape_string($_REQUEST['customerCode']);
	$g=mysql_escape_string($_REQUEST['siteName']);
	$h=mysql_escape_string(districtsGetID($_REQUEST['district']));
	$i=mysql_escape_string($_REQUEST['custDeliverAddr']);
	$j=mysql_escape_string($_REQUEST['custName']);
	$jj=mysql_escape_string($_REQUEST['custNumber']);
	$kk=mysql_escape_string($_REQUEST['item']);
	//$n=mysql_escape_string($_REQUEST['materialValue']);
	$p=mysql_escape_string($_REQUEST['to']);
	if($a==""){$result="Enter MRF Number";}
	elseif($b==""){$result="Select From W/H";}
	elseif($p==""){$result="Select To ToWH/TT";}
	elseif($p=="stk" && $c==""){$result="Select To W/H";}
	elseif($p=="site" && $e==""){$result="Enter TT Number";}
	elseif($i==""){$result="Enter Customer Delivery Address";}
	elseif($j==""){$result="Enter Customer Contact Person Name";}
	elseif($jj==""){$result="Enter Customer Contact Person Number";}
	elseif($kk==""){$result="Select Item";}
	//elseif($k==""){$result="Enter Item Code";}
	//elseif($l==""){$result="Enter Quantity";}
	//elseif($m==""){$result="Select Stock Category";}
	//elseif($n==""){$result="Enter Material Value";}
	//elseif($o==""){$result="Select MRF Status";}
	else{
		$query=mysql_query("SELECT * FROM ss_material_outward WHERE mrfNumber='$a' AND mrfStatus='Closed' AND flag=0");
		if(mysql_num_rows($query)==0){
			for($z=0;$z<count($_REQUEST['itemCode']);$z++){
				$id[$z] = checkx(rand(0000, 9999),'ss_material_outward');
				$k[$z]=mysql_escape_string($_REQUEST['itemCode'][$z]);
				$l[$z]=mysql_escape_string($_REQUEST['qty'][$z]);
				$m[$z]=mysql_escape_string($_REQUEST['stockCategory'][$z]);
					$query1=mysql_query("SELECT price FROM ss_item_code WHERE id='$k[$z]' AND flag='0'");
					if(mysql_num_rows($query1)){ $row = mysql_fetch_array($query1);$price = $row['price'];}else{ $price = 0; }
					$n[$z]=$price*$l[$z];
				$in = mysql_query("SELECT qty FROM ss_material_inward WHERE mrfNumber='$a'"); $countIn=0;
				while($rowIn=mysql_fetch_array($in)){ $countIn += $rowIn['qty'];}
				$out=mysql_query("SELECT qty FROM ss_material_outward WHERE mrfNumber='$a'"); $countOut=0;
				while($rowOut=mysql_fetch_array($out)){$countOut += $rowOut['qty'];}
				if($countIn<=$countOut+$l[$z]){ $o[$z]="Closed";}else{ $o[$z]="Open";} //mysql_escape_string($_REQUEST['mrfStatus']);
			$ac = mysql_query("INSERT INTO ss_material_outward(id,mrfNumber,fromWh,toWh,dateOfTransation,ttNumber,customerCode,siteName,districts,custDeliverAddr,custName,custNumber,item,itemCode,qty,stockCategory,materialValue,mrfStatus,flag) VALUES('$id[$z]','$a','$b','$c','$d','$e','$f','$g','$h','$i','$j','$jj','$kk','$k[$z]','$l[$z]','$m[$z]','$n[$z]','$o[$z]','0')");
			}
		if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
		}else{$result=errorMsg('ERRMSG003');}
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
<div class="row">
<div class="col-md-4 form-group">
    <label>MRF(Material Request Form) Number : </label>
     <select class="selectpicker form-control" name="mrfNumber" tabindex="1" autofocus="autofocus" data-live-search="true" onchange="ajaxOutward(this.value,'mrfNumber')">
        <option value="" selected disabled style="display:none;">Select MRF Number</option>
            <?php 
			//$sql = mysql_query("SELECT i.mrfNumber FROM ss_material_inward i LEFT JOIN ss_material_outward o ON i.mrfNumber=o.mrfNumber WHERE o.mrfNumber IS NULL");
            //while($row = mysql_fetch_array($sql)){ echo "<option value='".$row['mrfNumber']."'>".$row['mrfNumber']."</option>";}
			$sql = mysql_query("SELECT mrfNumber FROM ss_material_outward WHERE mrfStatus='Closed' AND flag=0");
            while($row = mysql_fetch_array($sql)){ $arr[] = $row['mrfNumber'];}
			$sql1 = mysql_query("SELECT mrfNumber FROM ss_material_inward WHERE flag=0");
            while($row1 = mysql_fetch_array($sql1)){ $arr1[] = $row1['mrfNumber'];}
			if(count($arr)){$arrdiff = array_diff($arr1,$arr);}else{$arrdiff=$arr1;}
			foreach(array_unique($arrdiff) as $mrf){echo "<option value='".$mrf."'>".$mrf."</option>";}
			?>
     </select>
</div>
<div class="col-md-4 form-group">
    <label>From W/H : </label>
    <input type="text" tabindex="2" class="form-control mrfNumber1" name="fromWh" readonly="readonly" />
</div>
<div class="col-md-4 form-group">
    <label>Item : </label>
    <input type="text" tabindex="3" class="form-control mrfNumber2" name="item" readonly="readonly" />
</div>
<div class="col-md-4 form-group">
    <label>Date of Transation : </label>
    <input tabindex="4" type="text" class="form-control singleDateEnd" name="dateOfTransation" value="<?php echo date('Y-m-d'); ?>"/>
</div>
<div class="col-md-4 form-group">
    <label>To : </label>
    <select tabindex="5" id="to" name="to" class="form-control">
    <option value="">Select for To WH / TT </option><option value="ist">Internal Stock Transfer</option><option value="site">Sites</option>
    </select>
</div>
<span class="resdiv"></span>
<div class="col-md-4 form-group">
    <label>Customer Contact Person Name : </label>
    <input tabindex="7" type="text" class="form-control" name="custName" placeholder="Customer Contact Person Name">
</div>
<div class="col-md-4 form-group">
    <label>Customer Contact Person Number : </label>
    <input tabindex="8" type="text" class="form-control" name="custNumber" placeholder="Customer Contact Person Number">
</div>
<div class="col-md-4 form-group">
    <label>Customer Deliver Address :</label>
    <textarea tabindex="9" name="custDeliverAddr" class="form-control" placeholder="Complete Description"></textarea>
</div>
</div>
<div class="row form-group">
	<div class="itemMain">
    	<span>
            <div class="col-md-4 form-group">
                <label>Item Code : </label>
                <select tabindex="10" name="itemCode[]" class="form-control mrfNumber0 price">
                    <option value="">Select Item Code</option>
                </select>
            </div>
            <div class="col-md-4 form-group">
                <label>Quantity : </label>
                <input type="hidden" tabindex="10" class="form-control itemPrice">
                <input tabindex="10" type="text" class="form-control qty" name="qty[]" placeholder="QTY">
            </div>
            <div class="col-md-4 form-group">
                <label>Stock Category : </label>
                <select tabindex="10" name="stockCategory[]" class="form-control mrfNumber3">
                    <option value="">Select Stock Category</option>
                </select>
            </div>
         </span>
    </div>
    <span class="itemCodeRow"></span>
    <div class="col-md-4 form-group" style="display:none">
        <label>Material value : </label>
        <input tabindex="11" type="text" class="form-control" name="materialValue" id="materialValue" placeholder="Material value" readonly />
    </div>
</div>
<div class="form-group col-xs-12 morpad">
    <div class="col-xs-12">
    <button tabindex="12" type="submit" class="btn btn-primary ss_buttons" name="Create">Submit</button>
    <button tabindex="13" type="reset" class="btn btn-primary ss_buttons" name="reset" id="resetButton">Reset</button>
    <button tabindex="14" type="button" class="btn btn-primary ss_buttons itemCodeAdd">Add Fields</button>
    <button tabindex="15" type="button" class="btn btn-primary ss_buttons itemCodeRmv">Remove Fields</button>
	</div>
</div>
</form>
<script src="js/jquery-1.11.1.min.js"></script>
<script>
$(document).ready(function(){
$('#to').change(function(){ $('.resdiv').load('ajaxToTTOutwards.php?to='+$('#to').val()); });
});</script>