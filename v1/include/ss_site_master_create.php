<?php 
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['Create'])){
	$a=mysql_escape_string($_POST['zone']);					$b=mysql_escape_string($_POST['circle']);
	$c=mysql_escape_string($_POST['cluster']);				$d=mysql_escape_string($_POST['district']);
	$e=mysql_escape_string($_POST['customerCategory']);		$f=mysql_escape_string($_POST['customerCode']);	
	$g=mysql_escape_string($_POST['siteType']);				$h=strtoupper(mysql_escape_string($_POST['siteID']));
	$i=ucwords(mysql_escape_string($_POST['siteName']));	$j=mysql_escape_string($_POST['productCode']);
	$k=mysql_escape_string($_POST['mfdDate']);				$l=mysql_escape_string($_POST['installDate']);
	$m=mysql_escape_string($_POST['noOfString']);			$n=ucwords(mysql_escape_string($_POST['customerName']));
	$o=mysql_escape_string($_POST['customerNumber']);		$p=ucwords(mysql_escape_string($_POST['clusterManagerName']));
	$q=mysql_escape_string($_POST['clusterManagerNumber']);	$r= mysql_escape_string(preg_replace('/\s+/', '', $_POST['scheduleDays']));
	$s=mysql_escape_string($_POST['warrantyMonths']);		$t=mysql_escape_string($_POST['siteStatus']);
	$u=strtolower(mysql_escape_string($_POST['clusterManagerMail']));	$v=ucfirst(mysql_real_escape_string($_POST['siteAddress']));
	if($a==""){$result="Select Zone";}
	elseif($b==""){$result="Select Circle";}
	elseif($c==""){$result="Select Cluster";}
	elseif($d==""){$result="Select District";}
	elseif($e==""){$result="Select Customer Category";}
	elseif($f==""){$result="Select Customer Code";}
	elseif($g==""){$result="Select Site Type";}
	elseif($h==""){$result="Select Site ID";}
	elseif($i==""){$result="Select Site Name";}
	elseif($j==""){$result="Select Product Code";}
	//elseif($k==""){$result="Select Manufactured Date ";}
	//elseif($l==""){$result="Select Installation Date";}
	elseif($k==""){$result="Select Manufactured Date";}
	elseif($m==""){$result="Select No. of String";}
	elseif($n==""){$result="Select Site Technician Name";}
	elseif($o==""){$result="Select Site Technician Number";}
	elseif($p==""){$result="Select Cluster Manager Name";}
	elseif($q==""){$result="Select Cluster Manager Number";}
	elseif($r==""){$result="Select Preventive Maintenance Schedule";}
	elseif($s==""){$result="Select Warranty Months";}
	elseif($t==""){$result="Select Site Status";}
	elseif($u==""){$result="Select Cluster Manager Mail";}
	elseif($v==""){$result="Select Site Address";}
	else{
		$query=mysql_query("SELECT id FROM ss_site_master WHERE siteID ='$h' AND circle='$b' AND flag='0'");
		$count=mysql_num_rows($query);
		if($count==0){
			$date= date('Y-m-d'); 
			$id = checkx(rand(0000, 9999),'ss_site_master');
			$ac = mysql_query("insert into ss_site_master(id,createdDate,flag,zone,circle,cluster,district,customerCategory,customerCode,siteType,siteID,siteName,productCode,mfdDate,installDate,noOfString,customerName,customerNumber,clusterManagerName,clusterManagerNumber,scheduleDays,warrantyMonths,siteStatus,clusterManagerMail,siteAddress) values('$id','$date','0','$a','$b','$c','$d','$e','$f','$g','$h','$i','$j','$k','$l','$m','$n','$o','$p','$q','$r','$s','$t','$u','$v')");
			if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
		}else{$result=errorMsg('ERRMSG003');}
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
    <div class="col-md-4 form-group">
        <label>Zone</label>
        <select tabindex="1" autofocus="autofocus" class="form-control" name="zone" onchange="ajaxSelect(this.options[this.selectedIndex].value,'Circle')">
        <option value="">select zone</option><?php zonesOptions(); ?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Circle</label>
        <select tabindex="2" name="circle" class="form-control" id="ajaxSelect_Circle"  onchange="ajaxSelect(this.options[this.selectedIndex].value,'Cluster')">
        <option value="">Select Circle</option>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Cluster</label>
        <select tabindex="3" name="cluster" class="form-control" id="ajaxSelect_Cluster" onchange="ajaxSelect(this.options[this.selectedIndex].value,'District')">
        <option value="">Select Cluster</option>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>District</label>
        <select tabindex="4" name="district" class="form-control" id="ajaxSelect_District">
        <option value="">Select District</option>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Segment</label>
        <select tabindex="5" name="customerCategory" class="form-control" id="prodCat" onchange="ajaxSelect(this.options[this.selectedIndex].value,'CustomerName')">
        <option value="">Select Segment</option><?php customerCategoryOption();?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Customer Code</label>
        <select tabindex="6" name="customerCode" class="form-control" id="ajaxSelect_CustomerName" onchange="ajaxfit(this.options[this.selectedIndex].value,'schedule','smSchedule')" />
        <option value="">Select Customer Code</option>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Site Type</label>
        <select tabindex="7" name="siteType" id="siteType" class="form-control">
        <option value="" disabled selected>Select Site Type</option>
        <option value="" disabled >First Select Segment</option>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Site ID</label>
        <input tabindex="8" type="text" autocomplete="off" class="form-control fulcap" name="siteID" id="siteID" placeholder="Enter Site ID/ Coach Number" />
    </div>
    <div class="col-md-4 form-group">
        <label>Site Name</label>
        <input tabindex="9" type="text" class="form-control" name="siteName" placeholder="Enter Site Name" />
    </div>
    <div class="col-md-4 form-group">
        <label>Site Address : </label>
        <textarea tabindex="10" name="siteAddress" class="form-control" placeholder="Site Address"></textarea>
    </div>
    <div class="col-md-4 form-group">
        <label>Manufactured Date</label>
        <input name="mfdDate" type='text' class="form-control" id='mfdDate' placeholder="YYYY-MM-DD" tabindex="11" contenteditable="false"/>
    </div>
    <div class="col-md-4 form-group">
        <label>Installation Date</label>
        <input name="installDate" type='text' class="form-control" id='installDate' placeholder="YYYY-MM-DD" tabindex="12" contenteditable="false"/>
    </div>
    <div class="col-md-4 form-group">
        <label>Product Code</label>
        <select tabindex="13" name="productCode" class="form-control" onchange="ajaxfit('gf','warranty','prwarr')">
        <option value="">Select Product Code</option><?php productCodeOption();?>
        </select>
    </div>

    <div class="col-md-4 form-group">
        <label>No. of Strings</label>
        <select tabindex="14" name="noOfString" class="form-control">
        <option value="">Select No. of String</option>
        <?php for($ns=1;$ns<=5;$ns++){echo "<option value='$ns'>$ns</option>";}?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Site Technician Name</label>
        <input tabindex="15" type="text" class="form-control" name="customerName" placeholder="Enter Site Technician Name">
    </div>
    <div class="col-md-4 form-group">
        <label>Site Technician Number</label>
        <input tabindex="16" type="text" class="form-control" name="customerNumber" placeholder="Enter Site Technician Number">
    </div>
    <div class="col-md-4 form-group">
    	<label>Cluster Manager Name</label>
        <input tabindex="17" type="text" class="form-control" name="clusterManagerName" placeholder="Enter Cluster Manager Name">
    </div>
    <div class="col-md-4 form-group">
    	<label>Cluster Manager Number</label>
        <input tabindex="18" type="text" class="form-control" name="clusterManagerNumber" placeholder="Enter Cluster Manager Number">
    </div>
    <div class="col-md-4 form-group">
    	<label>Cluster Manager Email</label>
        <input tabindex="19" type="text" class="form-control nocap" name="clusterManagerMail" placeholder="Enter Cluster Manager Email">
    </div>
    <div class="col-md-4 form-group">
        <label>Preventive Maintenance Schedule</label>
        <input tabindex="20" type="text" class="form-control"  name="scheduleDays" readonly="readonly" id="ajaxSelect_schedule">
        
    </div>
    <div class="col-md-4 form-group">
        <label>Warranty Months</label>
        <input tabindex="21" type="text" class="form-control" name="warrantyMonths" readonly="readonly" id="ajaxSelect_warranty">
    </div>
        <div class="col-md-4 form-group" id="hidden">
        <label>Warranty Left</label>
        <input tabindex="21" type="text" class="form-control" name="warrantyLeft" readonly="readonly" id="ajaxSelect_warrantyLeft">
    </div>
    <div class="col-md-4 form-group">
        <label>Site Status</label>
        <select tabindex="22" name="siteStatus" class="form-control" id="siteStatus">
        <option value="">Select Site Status</option>
        <option value="Warranty">Under Warranty</option>
        <option value="Out Of Warranty"> Out Of Warranty</option>
        <option value="Not Given"> Not Given</option>
        <option value="Amc"> AMC</option> 
        </select>
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="Create" tabindex="23">Create</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="24">Reset</button>
        </div>
    </div>
</form>