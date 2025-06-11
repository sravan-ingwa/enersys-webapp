<?php
if(isset($_REQUEST['update'])){
	$a=mysql_escape_string($_REQUEST['mrfNumber']);
	$b=mysql_escape_string($_REQUEST['fromWh']);
	$c=mysql_escape_string($_REQUEST['toWh']);
	$e=mysql_escape_string($_REQUEST['ttNumber']);
	$f=mysql_escape_string($_REQUEST['customerCode']);
	$g=mysql_escape_string($_REQUEST['siteName']);
	$h=mysql_escape_string(districtsGetID($_REQUEST['district']));
	$i=mysql_escape_string($_REQUEST['custDeliverAddr']);
	$j=mysql_escape_string($_REQUEST['custName']);
	$jk=mysql_escape_string($_REQUEST['custNumber']);
	$kk=mysql_escape_string($_REQUEST['item']);

	if($a==""){$result="Enter MRF Number";}
	elseif($b==""){$result="Select From W/H";}
	//elseif($c==""){$result="Select To W/H";}
	//elseif($e==""){$result="Enter TT Number";}
	//elseif($f==""){$result="Enter Customer";}
	elseif($i==""){$result="Enter Customer Delivery Address";}
	elseif($j==""){$result="Enter Customer Contact Person Name";}
	elseif($jk==""){$result="Enter Customer Contact Person Number";}
	elseif($kk==""){$result="Select Item";}
	//elseif($k==""){$result="Select Item Code";}
	//elseif($l==""){$result="Enter Quantity";}
	//elseif($m==""){$result="Select Stock Category";}
	//elseif($n==""){$result="Enter Material Value";}
	//elseif($o==""){$result="Select MRF Status";}
	else{
		$RefId =$_REQUEST['y'];
		if(count($_REQUEST['itemCode'])==1){
			$k=mysql_escape_string(current($_REQUEST['itemCode']));
			$l=mysql_escape_string(current($_REQUEST['qty']));
			$m=mysql_escape_string(current($_REQUEST['stockCategory']));
			$n=mysql_escape_string($_REQUEST['materialValue']);
				$in = mysql_query("SELECT qty FROM ss_material_inward WHERE mrfNumber='$a'"); $countIn=0;
				while($rowIn=mysql_fetch_array($in)){ $countIn += $rowIn['qty'];}
				$out=mysql_query("SELECT qty FROM ss_material_outward WHERE mrfNumber='$a'"); $countOut=0;
				while($rowOut=mysql_fetch_array($out)){$countOut += $rowOut['qty'];}
				if($countIn<=$countOut+$l){ $o="Closed";}else{ $o="Open";} //mysql_escape_string($_REQUEST['mrfStatus']);
			$ac = mysql_query("UPDATE ss_material_outward SET mrfNumber='$a', fromWh='$b', toWh='$c', ttNumber='$e', customerCode='$f', siteName='$g', districts='$h', custDeliverAddr='$i', custName='$j',custNumber='$jk', item='$kk', itemCode='$k', qty='$l', stockCategory='$m', materialValue='$n', mrfStatus='$o' WHERE id='$RefId'");
		}elseif(count($_REQUEST['itemCode'])>=1){
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
			}else{$result=errorMsg('ERRMSG003');}
		}
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
	}
}
$RefId =$_REQUEST['y'];
$query1=mysql_query("SELECT * FROM ss_material_outward WHERE id='$RefId'");
$row = mysql_fetch_array($query1);
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
<div class="row">
<input type="hidden" name="y" value="<?php echo $RefId;?>" />
<div class="col-md-4 form-group">
    <label>MRF(Material Request Form) Number : </label>
    <input tabindex="1" autofocus="autofocus" class="form-control" type="text" name="mrfNumber" value="<?php echo $row['mrfNumber']; ?>" placeholder="Material Request Form" readonly/>
</div>
<div class="col-md-4 form-group">
    <label>From w/h : </label>
    <select tabindex="2" name="fromWh" class="form-control">
    <option value="">Select from w/h</option><?php explodeEdit($row['fromWh'],'ss_warehouse_code','whCode'); ?>
    </select>
</div>
<?php if($row['toWh'] != ""){ ?>
<div class="col-md-4 form-group">
    <label>To w/h : </label>
    <select tabindex="3" name="toWh" class="form-control">
    <option value="">Select to w/h</option><?php explodeEdit($row['toWh'],'ss_warehouse_code','whCode');?>
    </select>
</div>
<?php }else{ ?>
<div class="col-md-4 form-group">
	<label>TT Number : </label>
	<input type="text" class="form-control" name="ttNumber" tabindex="4" value="<?php echo $row['ttNumber']; ?>" placeholder="Select TT Number" readonly/>
</div>
<div class="col-md-4 form-group">
    <label>Customer Code: </label>
    <input tabindex="5" type="text" class="form-control" value="<?php echo $row['customerCode']; ?>" name="customerCode" placeholder="Customer Code" readonly />
</div>
<div class="col-md-4 form-group">
    <label>Site Names : </label>
    <input tabindex="6" type="text" class="form-control" value="<?php echo $row['siteName']; ?>" name="siteName" placeholder="Site Name" readonly />
</div>
<div class="col-md-4 form-group">
    <label>District : </label>
    <input tabindex="7" type="text" class="form-control" value="<?php echo districtsGetName($row['districts']); ?>" name="district" placeholder="District" readonly />
</div>
<?php } ?>
<div class="col-md-4 form-group">
    <label>Customer Contact Person Name : </label>
    <input tabindex="8" type="text" class="form-control" name="custName" value="<?php echo $row['custName']; ?>" placeholder="Customer Contact Person Name">
</div>
<div class="col-md-4 form-group">
    <label>Customer Contact Person Number : </label>
    <input tabindex="9" type="text" class="form-control" name="custNumber" value="<?php echo $row['custNumber']; ?>" placeholder="Customer Contact Person Number">
</div>
<div class="col-md-4 form-group">
    <label>Customer Deliver Address :</label>
    <textarea tabindex="10" name="custDeliverAddr" class="form-control" placeholder="Complete Description"><?php echo $row['custDeliverAddr']; ?></textarea>
</div>
<div class="col-md-4 form-group">
    <label>Item : </label>
    <select tabindex="11" name="item" class="form-control">
       <?php echo item($row['item']); ?>       
    </select>
</div>
</div>
<div class="row form-group">
        <div class="col-md-4 form-group">
            <label>Item Code : </label>
            <select tabindex="15" name="itemCode[]" class="form-control">
                <option value="">Select Item Code</option><?php echo explodeEdit($row['itemCode'],'ss_item_code','itemDesc'); ?>
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label>QTY : </label>
            <input tabindex="15" type="text" class="form-control" value="<?php echo $row['qty']; ?>" name="qty[]" placeholder="QTY">
        </div>
        <div class="col-md-4 form-group">
            <label>Stock Category : </label>
            <select tabindex="15" name="stockCategory[]" class="form-control mrfNumber3">
                <option value="">Select Stock Category</option><?php echo explodeEdit($row['stockCategory'],'ss_stock_code','stockCode'); ?>
            </select>
        </div>
</div>
<span class="itemCodeRow"></span>
<div class="col-md-4 form-group">
    <label>Material value : </label>
    <input tabindex="16" type="hidden" class="form-control" value="<?php echo $row['materialValue']; ?>" id="materialValue" name="materialValue" placeholder="Material value">
</div>
<div class="form-group col-xs-12 morpad">
    <div class="col-xs-12">
    <button tabindex="16" type="submit" class="btn btn-primary ss_buttons" name="update">Update</button>
	<button tabindex="17" type="reset" class="btn btn-primary ss_buttons" name="reset" id="resetButton">Reset</button>
    <button tabindex="19" type="button" class="btn btn-primary ss_buttons itemCodeAdd">Add Fields</button>
    <button tabindex="20" type="button" class="btn btn-primary ss_buttons itemCodeRmv">Remove Fields</button>
	</div>
</div>
</form>
<div class="itemMain" style="display:none">
    <span>
        <div class="col-md-4 form-group">
            <label>Item Code : </label>
            <select tabindex="13" name="itemCode[]" class="form-control price">
                <option value="">Select Item Code</option><?php itemCodeOptions(); ?>
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label>Quantity : </label>
            <input type="hidden" tabindex="15" class="form-control itemPrice">
            <input tabindex="13" type="text" class="form-control qty" name="qty[]" placeholder="QTY">
        </div>
        <div class="col-md-4 form-group">
            <label>Stock Category : </label>
            <select tabindex="11" name="stockCategory[]" class="form-control">
                <option value="">Select Stock Category</option><?php stockOptions(); ?>
            </select>
        </div>
    </span>
</div>
<?php
function item($val){
	if($val == "cell"){echo "<option value=''>Select Item</option><option value='$val' selected>$val</option><option value='accessories'>Accessories</option>";}
	else{echo "<option value=''>Select Item</option><option value='cell'>Cell</option><option value='$val' selected>$val</option>";}
	}
?>