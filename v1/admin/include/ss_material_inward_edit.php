<?php
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['update'])){
	$a=mysql_escape_string($_REQUEST['mrfNumber']);
	$b=mysql_escape_string(implode(", ",$_REQUEST['zone']));	
	$c=mysql_escape_string(implode(", ",$_REQUEST['circle']));
	$d=mysql_escape_string($_REQUEST['fromWh']);
	$dd=mysql_escape_string($_REQUEST['siteAddress']);
	$e=mysql_escape_string($_REQUEST['toWh']);
	$f=mysql_escape_string($_REQUEST['dateOfTransation']);
	$g=mysql_escape_string($_REQUEST['SJONumber']);
	$gg=mysql_escape_string($_REQUEST['invoiceNumber']);
	$ggg=mysql_escape_string($_REQUEST['invoiceDate']);
	$hh=mysql_escape_string($_REQUEST['transporterDetails']);
	$hhh=mysql_escape_string($_REQUEST['docketNumber']);
	$h=mysql_escape_string($_REQUEST['customerCode']);
	$i=mysql_escape_string($_REQUEST['custName']);
	$ii=mysql_escape_string($_REQUEST['custNumber']);
	$j=mysql_escape_string($_REQUEST['item']);

	if($a==""){$result="Enter MRF Number";}
	elseif($b==""){$result="Select Zone";}
	elseif($c==""){$result="Select Circle";}
	elseif($d==""){$result="Select From W/H";}
	elseif($e==""){$result="Select To W/H";}
	elseif($f==""){$result="Enter Transation Date";}
	//elseif($g==""){$result="Enter SJO Number";}
	//elseif($gg==""){$result="Enter Invoice Number";}
	//elseif($ggg==""){$result="Enter Invoice Date";}
	elseif($hh==""){$result="Enter Transporter Details";}
	elseif($hhh==""){$result="Enter Docket Number";}
	elseif($h==""){$result="Enter Customer Code";}
	elseif($i==""){$result="Enter Customer Contact Person Name";}
	elseif($ii==""){$result="Enter Customer Contact Person Number";}
	elseif($j==""){$result="Select Item";}
	//elseif($k==""){$result="Select Item Code";}
	//elseif($l==""){$result="Enter Quantity";}
	//elseif($m==""){$result="Select Stock Category";}
	//elseif($n==""){$result="Enter Material Value";}
	else{
		$RefId =$_REQUEST['y'];
		if(count($_REQUEST['itemCode'])==1){
			$k=mysql_escape_string(current($_REQUEST['itemCode']));
			$l=mysql_escape_string(current($_REQUEST['qty']));
			$m=mysql_escape_string(current($_REQUEST['stockCategory']));
			$n=mysql_escape_string($_REQUEST['materialValue']);
			$ac = mysql_query("UPDATE ss_material_inward SET mrfNumber='$a', zones='$b', circle='$c', fromWh='$d',siteAddress='$dd',toWh='$e',dateOfTransation='$f', SJONumber='$g',invoiceNumber='$gg',invoiceDate='$ggg',transporterDetails='$hh',docketNumber='$hhh',customerCode='$h', custName='$i',custNumber='$ii', item='$j', itemCode='$k', qty='$l', stockCategory='$m', materialValue='$n' WHERE id='$RefId'");
		}elseif(count($_REQUEST['itemCode'])>1){
			for($z=0;$z<count($_REQUEST['itemCode']);$z++){
				$id[$z] = checkx(rand(0000, 9999),'ss_material_inward'); //end(explode('-',$a));
				$k[$z]=mysql_escape_string($_REQUEST['itemCode'][$z]);
				$l[$z]=mysql_escape_string($_REQUEST['qty'][$z]);
				$m[$z]=mysql_escape_string($_REQUEST['stockCategory'][$z]);
				$query1=mysql_query("SELECT price FROM ss_item_code WHERE id='$k[$z]' AND flag='0'");
				if(mysql_num_rows($query1)){ $row = mysql_fetch_array($query1);$price = $row['price'];}else{ $price = 0; }
				$n[$z]=$price*$l[$z];
				$ac = mysql_query("INSERT INTO ss_material_inward(id,mrfNumber,zones,circle,fromWh,siteAddress,toWh,dateOfTransation,SJONumber,invoiceNumber,invoiceDate,transporterDetails,docketNumber,customerCode,custName,custNumber,item,itemCode,qty,stockCategory,materialValue,flag)VALUES('$id[$z]','$a','$b','$c','$d','$dd','$e','$f','$g','$gg','$ggg','$hh','$hhh','$h','$i','$ii','$j','$k[$z]','$l[$z]','$m[$z]','$n[$z]','0')");
			}
		}
		if($ac)$result="".errorMsg('ERRMSG001')." ";else $result=errorMsg('ERRMSG002');
	}
}
$RefId =$_REQUEST['y'];
$query1=mysql_query("SELECT * FROM ss_material_inward WHERE id='$RefId'");
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
    <label>Zone</label>
    <select tabindex="2" class="form-control" name="zone[]" multiple="multiple" id="zoneSelect"  onchange="ajaxSelectmulti(this.id,'Circle')">
        <option value="" disabled="disabled">select zone</option><?php explodeEdit($row['zones'],'ss_zone','zone');?>
    </select>
</div>
<div class="col-md-4 form-group">
    <label>Circle</label>
    <select tabindex="3" class="form-control" name="circle[]" multiple="multiple" id="ajaxSelect_Circle" onchange="ajaxSelectmulti(this.id,'ToWH')">
        <option value="" disabled="disabled">Select Circle</option><?php explodeEdit($row['circle'],'circleGetName','circle');?>
    </select>
</div>
<div class="col-md-4 form-group">
    <label>From W/H : </label>
    <select tabindex="4" name="fromWh" class="form-control" id="fromWH">
    <option value="">Select from W/H</option><option value="sites">[Sites]</option>
	<?php explodeEdit($row['fromWh'],'ss_warehouse_code','whCode'); ?>
    </select>
</div>
<span class="siteAddress"></span>
<div class="col-md-4 form-group">
    <label>To W/H : </label>
    <select tabindex="5" name="toWh" class="form-control" id="ajaxSelect_ToWH">
    <option value="">Select to W/H</option><?php explodeEdit($row['toWh'],'whareHouseGetName','whCode'); ?>
    </select>
</div>
<div class="col-md-4 form-group">
    <label>Date of Transation : </label>
    <input tabindex="6" type="text" class="form-control singleDateEnd" name="dateOfTransation" placeholder="Date Of Transation" value="<?php echo $row['dateOfTransation']; ?>"/>
</div>
<div class="col-md-4 form-group inventHide">
    <label>SJO Number : </label>
    <input tabindex="6" type="text" class="form-control" value="<?php echo $row['SJONumber']; ?>" name="SJONumber" placeholder="SJO Number">
</div>
<div class="col-md-4 form-group inventHide">
    <label>Invoice Number : </label>
    <input tabindex="7" type="text" class="form-control" name="invoiceNumber" value="<?php echo $row['invoiceNumber']; ?>" placeholder="Invoice Number">
</div>
<div class="col-md-4 form-group inventHide">
    <label>Invoice Date : </label>
    <input tabindex="8" type="text" class="form-control singleDateEnd" name="invoiceDate" value="<?php echo $row['invoiceDate']; ?>" placeholder="Invoice Date">
</div>
<div class="col-md-4 form-group">
    <label>Transporter Details : </label>
    <input tabindex="8" type="text" class="form-control" name="transporterDetails" value="<?php echo $row['transporterDetails']; ?>" placeholder="Transporter Details">
</div>
<div class="col-md-4 form-group">
    <label>Docket Number : </label>
    <input tabindex="8" type="text" class="form-control" name="docketNumber" value="<?php echo $row['docketNumber']; ?>" placeholder="Docket Number">
</div>
<div class="col-md-4 form-group">
    <label>Customer Code : </label>
	<select tabindex="9" class="form-control" name="customerCode">
        <option value="">Select Customer Code</option><?php explodeEdit($row['customerCode'],'ss_customer_details','customerName');?>
    </select>
</div>
<div class="col-md-4 form-group">
    <label>Customer Contact Person Name : </label>
    <input tabindex="9" type="text" class="form-control" value="<?php echo $row['custName']; ?>" name="custName" placeholder="Customer Contact Person Name">
</div>
<div class="col-md-4 form-group">
    <label>Customer Contact Person Number : </label>
    <input tabindex="9" type="text" class="form-control" value="<?php echo $row['custNumber']; ?>" name="custNumber" placeholder="Customer Contact Person Number">
</div>
<div class="col-md-4 form-group">
    <label>Item (Cell / Accessories) : </label>
    <select tabindex="10" name="item" class="form-control">
        <option value="">Select Item</option>
        <?php echo item($row['item']); ?>
    </select>
</div>
</div>
<div class="row form-group">
        <div class="col-md-4 form-group">
            <label>Item Code : </label>
            <select tabindex="13" name="itemCode[]" class="form-control price">
                <option value="">Select Item Code</option><?php echo explodeEdit($row['itemCode'],'ss_item_code','itemDesc'); ?>
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label>Quantity : </label>
            <input type="hidden" tabindex="15" class="form-control itemPrice" value="<?php echo hiddenPrice($row['qty']); ?>">
            <input tabindex="13" type="text" class="form-control qty" value="<?php echo $row['qty']; ?>" name="qty[]" placeholder="QTY">
        </div>
        <div class="col-md-4 form-group">
            <label>Stock Category : </label>
            <select tabindex="11" name="stockCategory[]" class="form-control">
                <option value="">Select Stock Category</option><?php explodeEdit($row['stockCategory'],'ss_stock_code','stockCode'); ?>
            </select>
        </div>
    <span class="itemCodeRow"></span>
    <div class="col-md-4 form-group">
        <label>Material value : </label>
        <input tabindex="12" type="text" class="form-control" value="<?php echo $row['materialValue']; ?>" id="materialValue" name="materialValue" placeholder="Material value" readonly />
    </div>
</div>
<div class="form-group col-xs-12 morpad">
    <div class="col-xs-12">
    <button tabindex="14" type="submit" class="btn btn-primary ss_buttons" name="update">Update</button>
	<button tabindex="15" type="reset" class="btn btn-primary ss_buttons" name="reset" id="resetButton">Reset</button>
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
	if($val == "cell"){echo "<option value='$val' selected>$val</option><option value='accessories'>Accessories</option>";}
	else{echo "<option value=''>Select Item</option><option value='cell'>Cell</option><option value='$val' selected>$val</option>";}
	}
function hiddenPrice($id){
	$query=mysql_query("SELECT price FROM ss_item_code WHERE id='$id' AND flag='0'");
		if(mysql_num_rows($query)){
			$row = mysql_fetch_array($query);
			return $row['price'];
		}else{ return 0; }
	}
?>