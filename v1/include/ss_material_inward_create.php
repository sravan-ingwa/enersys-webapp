<?php
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['Create'])){
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
	//$n=mysql_escape_string($_REQUEST['materialValue']);
	if(!empty($_FILES['pdf']['name'])){
		$fileName = uniqid("inwards");
			$extension = pathinfo($_FILES['pdf']['name'], PATHINFO_EXTENSION);
			if($extension == "pdf"){
				if($_FILES["pdf"]["error"] > 0){echo "Return Code: ".$_FILES["pdf"]["error"]."<br/>";}
				else{
					$name = $fileName.".".$extension;
					if (file_exists("../reports/inwards/".$name)){echo "<script>alert('".$name." already exists')</script>";}
					else{
						move_uploaded_file($_FILES["pdf"]["tmp_name"],"../reports/inwards/".$name);
						$o = mysql_real_escape_string("reports/inwards/".$name);				
					}
				}
			}else{ $result = "Note : Choose pdf file only"; }
		}else{$o="";}
	if($a==""){$result="Enter MRF Number";}
	elseif($b==""){$result="Select Zone";}
	elseif($c==""){$result="Select Circle";}
	elseif($d==""){$result="Select From W/H";}
	elseif($e==""){$result="Select To W/H";}
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
	//elseif($o==""){$result="Choose PDF File";}
	else{
		$query=mysql_query("SELECT * FROM ss_material_inward WHERE mrfNumber='$a'");
		$count=mysql_num_rows($query);
		if($count==0){
			for($z=0;$z<count($_REQUEST['itemCode']);$z++){
			$id[$z] = checkx(rand(0000, 9999),'ss_material_inward'); //end(explode('-',$a));
					$k[$z]=mysql_escape_string($_REQUEST['itemCode'][$z]);
					$l[$z]=mysql_escape_string($_REQUEST['qty'][$z]);
					$m[$z]=mysql_escape_string($_REQUEST['stockCategory'][$z]);
					$query1=mysql_query("SELECT price FROM ss_item_code WHERE id='$k[$z]' AND flag='0'");
					if(mysql_num_rows($query1)){ $row = mysql_fetch_array($query1);$price = $row['price'];}else{ $price = 0; }
					$n[$z]=$price*$l[$z];
				$ac = mysql_query("INSERT INTO ss_material_inward(id,mrfNumber,zones,circle,fromWh,siteAddress,toWh,dateOfTransation,SJONumber,invoiceNumber,invoiceDate,transporterDetails,docketNumber,customerCode,custName,custNumber,item,itemCode,qty,stockCategory,materialValue,pdfFile,flag) VALUES('$id[$z]','$a','$b','$c','$d','$dd','$e','$f','$g','$gg','$ggg','$hh','$hhh','$h','$i','$ii','$j','$k[$z]','$l[$z]','$m[$z]','$n[$z]','$o','0')");
			}
		if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
		}else{$result=errorMsg('ERRMSG003');}
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
	<form role="form" class="ss_form" method="post" id="defaultForm" enctype="multipart/form-data">
<div class="row">
<div class="col-md-4 form-group">
    <label>MRF(Material Request Form) Number : </label>
    <input tabindex="1" autofocus="autofocus" class="form-control" type="text" name="mrfNumber" value="<?php echo "MRF-".checkx(rand(0000, 9999),'ss_material_inward'); ?>" readonly/>
</div>
<div class="col-md-4 form-group">
    <label>Zone</label>
    <select tabindex="2" class="form-control" name="zone[]" multiple="multiple" id="zoneSelect" onchange="ajaxSelectmulti(this.id,'Circle')">
        <option value="" disabled="disabled">select zone</option><?php zonesOptions(); ?>
    </select>
</div>
<div class="col-md-4 form-group">
    <label>Circle</label>
    <select tabindex="3" class="form-control" name="circle[]" multiple="multiple" id="ajaxSelect_Circle" onchange="ajaxSelectmulti(this.id,'ToWH')">
        <option value="" disabled="disabled">Select Circle</option>
    </select>
</div>
<div class="col-md-4 form-group">
    <label>From W/H : </label>
    <select tabindex="4" name="fromWh" class="form-control" id="fromWH">
    <option value="">Select from W/H</option><option value="sites">[Sites]</option><?php whareHouseOptions(); ?>
    </select>
</div>
<span class="siteAddress"></span>
<div class="col-md-4 form-group">
    <label>To W/H : </label>
    <select tabindex="5" name="toWh" class="form-control" id="ajaxSelect_ToWH">
    <option value="">Select to W/H</option>
    </select>
</div>
<div class="col-md-4 form-group">
    <label>Date of Transation : </label>
    <input tabindex="6" type="text" class="form-control singleDateEnd" name="dateOfTransation" value="<?php echo date('Y-m-d'); ?>"/>
</div>
<div class="col-md-4 form-group inventHide">
    <label>SJO Number : </label>
    <input tabindex="7" type="text" class="form-control" name="SJONumber" placeholder="SJO Number">
</div>
<div class="col-md-4 form-group inventHide">
    <label>Invoice Number : </label>
    <input tabindex="8" type="text" class="form-control" name="invoiceNumber" id="invoiceNumber" placeholder="Invoice Number">
</div>
<div class="col-md-4 form-group inventHide">
    <label>Invoice Date : </label>
    <input tabindex="9" type="text" class="form-control singleDateEnd" name="invoiceDate" placeholder="YYYY-MM-DD">
</div>
<div class="col-md-4 form-group">
    <label>Transporter Details : </label>
    <input tabindex="9" type="text" class="form-control" name="transporterDetails" placeholder="Transporter Details">
</div>
<div class="col-md-4 form-group">
    <label>Docket Number : </label>
    <input tabindex="9" type="text" class="form-control" name="docketNumber" placeholder="Docket Number">
</div>
<div class="col-md-4 form-group">
    <label>Customer Code : </label>
    <select tabindex="10" name="customerCode" class="form-control">
		<?php customerDetailsOption(); ?>
    </select>
</div>
<div class="col-md-4 form-group">
    <label>Customer Contact Person Name : </label>
    <input tabindex="11" type="text" class="form-control" name="custName" placeholder="Customer Contact Person Name">
</div>
<div class="col-md-4 form-group">
    <label>Customer Contact Person Number : </label>
    <input tabindex="12" type="text" class="form-control" name="custNumber" placeholder="Customer Contact Person Number">
</div>
<div class="col-md-4 form-group">
    <label>Item (Cell / Accessories) : </label>
    <select tabindex="13" name="item" class="form-control" id="accessories">
        <option value="">Select Item</option>
        <option value="cell">Cell</option>
        <option value="accessories">Accessories</option>
    </select>
</div>
<div class="col-md-4 form-group inventHide">
    <label>Upload a SJO File : </label>
    <input tabindex="14" type="file" class="form-control" name="pdf">
</div>
</div>
<div class="row form-group">
	<div class="itemMain">
    	<span>
            <div class="col-md-4 form-group">
                <label>Item Code : </label>
                <select tabindex="15" name="itemCode[]" class="form-control price">
                    <option value="">Select Item Code</option><?php itemCodeOptions(); ?>
                </select>
            </div>
            <div class="col-md-4 form-group">
                <label>Quantity : </label>
                <input type="hidden" tabindex="15" class="form-control itemPrice">
                <input type="text" tabindex="15" class="form-control qty" name="qty[]" placeholder="QTY">
            </div>
            <div class="col-md-4 form-group">
                <label>Stock Category : </label>
                <select tabindex="15" name="stockCategory[]" class="form-control stockCategory">
                    <option value="">Select Stock Category</option><?php stockOptions(); ?>
                </select>
            </div>
         </span>
    </div>
    <span class="itemCodeRow"></span>
    <div class="col-md-4 form-group">
        <label>Material value : </label>
        <input tabindex="16" type="text" class="form-control" name="materialValue" id="materialValue" placeholder="Material value" readonly />
    </div>
</div>
<div class="form-group col-xs-12 morpad">
    <div class="col-xs-12">
    <button tabindex="17" type="submit" class="btn btn-primary ss_buttons" id="disbl" name="Create">Submit</button>
    <button tabindex="18" type="reset" class="btn btn-primary ss_buttons" name="reset">Reset</button>
    <button tabindex="19" type="button" class="btn btn-primary ss_buttons itemCodeAdd">Add Fields</button>
    <button tabindex="20" type="button" class="btn btn-primary ss_buttons itemCodeRmv">Remove Fields</button>
    </div>
</div>
</form>