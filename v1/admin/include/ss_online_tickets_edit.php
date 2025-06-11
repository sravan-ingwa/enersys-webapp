<?php 
$RefId =$_REQUEST['y'];
if(isset($_REQUEST['approve'])){
	$a = mysql_escape_string($_REQUEST['natureOfActivity']);
	$b = strtoupper(mysql_escape_string($_REQUEST['site_id']));
	$c = ucwords(mysql_escape_string($_REQUEST['siteName']));
	$d = mysql_escape_string($_REQUEST['zone']);
	$e = mysql_escape_string($_REQUEST['circle']);
	$f = mysql_escape_string($_REQUEST['cluster']);
	$g = mysql_escape_string($_REQUEST['district']);
	$h = mysql_escape_string($_REQUEST['mfdDate']);
	$i = mysql_escape_string($_REQUEST['installDate']);
	$k = mysql_escape_string($_REQUEST['numBanks']);
	$l = ucwords(mysql_escape_string($_REQUEST['CrName']));
	$m = mysql_escape_string($_REQUEST['CrNum']);
	$n = mysql_escape_string($_REQUEST['custCategory']);
	$o = mysql_escape_string($_REQUEST['siteType']);
	$p = mysql_escape_string($_REQUEST['custName']);
	$q = mysql_escape_string($_REQUEST['createdDate']);
	$r = mysql_escape_string($_REQUEST['natureOfComplaint']);
	$s = mysql_escape_string($_REQUEST['prodCode']);
	$t = ucfirst(mysql_real_escape_string($_REQUEST['completeDesc']));
	$aa = ucwords(mysql_real_escape_string($_REQUEST['clusterManagerName']));
	$bb = mysql_real_escape_string($_REQUEST['clusterManagerNumber']);
	$cc = mysql_real_escape_string($_REQUEST['scheduleDays']);
	$dd = mysql_real_escape_string($_REQUEST['warrantyMonths']);
	$ee = mysql_real_escape_string($_REQUEST['siteStatus']);
	$ff = strtolower(mysql_real_escape_string($_REQUEST['clusterManagerMail']));
	$gg = ucfirst(mysql_real_escape_string($_REQUEST['siteAddress']));
		if($a==""){$result="Select Nature Of Activity";}
		elseif($b==""){$result="Select Site ID";}
		elseif($c==""){$result="Enter Site Name";}
		elseif($d==""){$result="Select Zone";}
		elseif($e==""){$result="Select Circle";}
		elseif($f==""){$result="Select Cluster";}
		elseif($g==""){$result="Select District";}
		elseif($k==""){$result="Select No Of String";}
		elseif($l==""){$result="Select Customer Name";}
		elseif($m==""){$result="Select Customer Number";}
		elseif($n==""){$result="Select Customer Category";}
		elseif($p==""){$result="Select Customer Code";}
		elseif($r==""){$result="Select Nature Of Complaint";}
		elseif($t==""){$result="Enter Description";}
		else{
			$query=mysql_query("SELECT id FROM ss_tickets WHERE siteId ='$b' AND natureOfActivity='$a' AND checkStat!='5'");
			$count=mysql_num_rows($query);
			if($count==0){
				$it = checkx(rand(0000, 9999),'ss_tickets');
				$sql = mysql_query("SELECT id FROM ss_tickets");
				if((mysql_num_rows($sql)+1)>9){$x = "TT".strtoupper(circleGetName($e))."00".(mysql_num_rows($sql)+1);}
				elseif((mysql_num_rows($sql)+1)>99){$x = "TT".strtoupper(circleGetName($e))."0".(mysql_num_rows($sql)+1);}
				elseif((mysql_num_rows($sql)+1)>999){$x = "TT".strtoupper(circleGetName($e))."".(mysql_num_rows($sql)+1);}
				else{$x = "TT".strtoupper(circleGetName($e))."000".(mysql_num_rows($sql)+1);}
				$at = mysql_query("INSERT INTO ss_tickets(id,ticketId,natureOfActivity,siteId,siteName,zone,circle,cluster,district,mfgDate,installDate,numBanks,customerName,customerNumber,customerCategory,siteType,custName,createdDate,natureOfComplaint,productCode,description,moc,ticketStatus,ticketType,flag,checkStat,errorMessage,mailStat)VALUES('$it','$x','$a','$b','$c','$d','$e','$f','$g','$h','$i','$k','$l','$m','$n','$o','".customerNameGetName($p)."','$q','$r','".productCodeGetName($s)."','$t','Online','Open','Inactive','0','0','".ttMsg('1')."','1')");
					$quer=mysql_query("SELECT id FROM ss_site_master WHERE siteID ='$b' AND flag='0'");
					if(mysql_num_rows($quer)==0){ $is = checkx(rand(0000, 9999),'ss_site_master');				
						$as = mysql_query("INSERT INTO ss_site_master(id,createdDate,flag,zone,circle,cluster,district,customerCategory,customerCode,siteType,siteID,siteName,productCode,mfdDate,installDate,noOfString,customerName,customerNumber,clusterManagerName,clusterManagerNumber,scheduleDays,warrantyMonths,siteStatus,clusterManagerMail,siteAddress)VALUES('$is','$q','0','$d','$e','$f','$g','$n','$p','$o','$b','$c','$s','$h','$i','$k','$l','$m','$aa','$bb','$cc','$dd','$ee','$ff','$gg')");
					}
				if($at){
						$numberx=$m;
						$messagex=urlencode( "Greetings from Enersys, your complaint has been registered against the ".natureOfActivityGetName($a)." of Site name-".$c." Ticket No- ".$x ."");
						messageSent($numberx,$messagex);
					$queryy=mysql_query("SELECT contactNo FROM ss_employee_details WHERE circle ='$e' AND employeeRole<>'8226' AND flag=0");
						if(mysql_num_rows($queryy)>0){
							while($abc = mysql_fetch_array($queryy)){
								$numberx=mysql_escape_string($abc['contactNo']);
								$messagex=urlencode( "Greetings from Enersys, your complaint has been registered against the ".natureOfActivityGetName($a)." of Site name-".$c." Ticket No- ".$x ."");
								messageSent($numberx,$messagex);
							}
						}
				}
			if($at || $as){
					$ac = mysql_query("UPDATE ss_online_tickets SET stat='2',flag='1' WHERE id='$RefId'");
				$result="Ticket Registered Successfully";
				echo "<script type='text/javascript'>window.location='view.php?y=".$it."&x=2432'</script>";
			}else $result="Sorry Please try Again!";
			}else{$result="Ticket already Registered";}
		} }
if(isset($_REQUEST['reject'])){
	$ac = mysql_query("DELETE FROM ss_online_tickets WHERE id='$RefId'");
	$result="Ticket Deleted Successfully";
	echo "<script type='text/javascript'>window.location='index.php?x=7313'</script>";
	}
$query1=mysql_query("SELECT * FROM ss_online_tickets WHERE id='$RefId'");
$row = mysql_fetch_array($query1);
?>
<p class="errorP"><?php if(isset($result)){echo $result;} ?> </p>
<form role="form" class="ss_form" method="post" id="defaultForm">
<input type="hidden" name="y" value="<?php echo $RefId;?>" />
<input type="hidden" name="mocReport" value="<?php echo $row['mocReport'];?>" />
    <div class="col-md-4 form-group">
    <label>Nature Of Activity : </label>
    <select tabindex="1" autofocus class="form-control" name="natureOfActivity" id="natureOfActivity">
    <option value="" disabled> Select Nature Of Activity </option><?php echo explodeEdit($row['natureOfActivity'],'ss_nature_of_activity','activity'); ?>
    </select>
</div>
<div class="col-md-4 form-group">
	<label>Created Date : </label>
	<input tabindex="2" name="createdDate" type='text' class="form-control" placeholder="YYYY-MM-DD" value="<?php echo $row['createdDate']; ?>" readonly />
</div>
    <div class="col-md-4 form-group">
        <label>Site ID : </label>
        <input tabindex="3" type="text" class="form-control fulcap" name="site_id" id="siteID" placeholder="Enter Site ID/ Coach Number" value="<?php echo $row['siteId']; ?>"/>
    </div>
    <div class="col-md-4 form-group">
        <label>Site Name : </label>
        <input tabindex="4" type="text" class="form-control" name="siteName" placeholder="Enter Site Name" value="<?php echo $row['siteName']; ?>" />
    </div>
    <div class="col-md-4 form-group">
        <label>Zone : </label>
        <select tabindex="5" class="form-control" name="zone" onchange="ajaxSelect(this.options[this.selectedIndex].value,'Circle');">
        <option value="">select zone</option><?php echo explodeEdit($row['zone'],'ss_zone','zone');?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Circle : </label>
        <select tabindex="6" name="circle" class="form-control" id="ajaxSelect_Circle"  onchange="ajaxSelect(this.options[this.selectedIndex].value,'Cluster')">
        <option value="">Select Circle</option><?php echo explodeEdit($row['circle'],'circleGetName','circle');?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Cluster : </label>
        <select tabindex="7" name="cluster" class="form-control" id="ajaxSelect_Cluster" onchange="ajaxSelect(this.options[this.selectedIndex].value,'District')">
        <option value="">Select Cluster</option><?php echo explodeEdit($row['cluster'],'clustersGetName','cluster');?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>District : </label>
        <select tabindex="8" name="district" class="form-control" id="ajaxSelect_District">
        <option value="">Select District</option><?php echo explodeEdit($row['district'],'districtsGetName','district');?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Manufactured Date : </label>
        <input name="mfdDate" type='text' class="form-control" id='mfdDate' placeholder="YYYY-MM-DD" tabindex="9" contenteditable="false" value="<?php echo $row['mfdDate']; ?>"/>
    </div>
    <div class="col-md-4 form-group">
        <label>Installation Date : </label>
        <input name="installDate" type='text' class="form-control" id='installDate' placeholder="YYYY-MM-DD" tabindex="10" contenteditable="false" value="<?php echo $row['installDate']; ?>"/>
    </div>
    <div class="col-md-4 form-group">
        <label>No. of Strings : </label>
        <select tabindex="11" name="numBanks" class="form-control">
        <option value="">Select No. of String</option>
        <?php for($ns=1;$ns<=5;$ns++){echo "<option value='$ns' ".selected($row['numBanks'],$ns).">$ns</option>";}?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Site Technician Name : </label>
        <input tabindex="12" type="text" class="form-control" name="CrName" placeholder="Enter Site Technician Name" value="<?php echo $row['customerName']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Site Technician Number : </label>
        <input tabindex="13" type="text" class="form-control" name="CrNum" placeholder="Enter Site Technician Number" value="<?php echo $row['customerNumber']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Segment : </label>
        <select tabindex="14" name="custCategory" class="form-control" id="prodCat" onchange="ajaxSelect(this.options[this.selectedIndex].value,'CustomerName')">
        <option value="">Select Segment</option><?php echo explodeEdit($row['customerCategory'],'ss_customer_category','category');?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Site Type : </label>
        <select tabindex="15" name="siteType" id="siteType" class="form-control">
        <option value="" disabled>Select Site Type</option>
        <option value="<?php echo $row['siteType']; ?>" selected><?php echo $row['siteType']; ?></option>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Customer Code : </label>
        <select tabindex="16" name="custName" class="form-control" id="ajaxSelect_CustomerName" onchange="ajaxfit(this.options[this.selectedIndex].value,'schedule','smSchedule')" />
        <option value="">Select Customer Code</option><?php echo explodeEdit($row['customerCode'],'ss_customer_details','customerName');?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Product Code : </label>
        <select tabindex="17" name="prodCode" class="form-control" onchange="ajaxfit('gf','warranty','prwarr')">
        <option value="">Select Product Code</option><?php echo explodeEdit($row['productCode'],'ss_product_details','productCode');?>
        </select>
    </div>
    <?php $quer=mysql_query("SELECT id FROM ss_site_master WHERE siteID ='$row[siteId]' AND flag='0'");
			if(mysql_num_rows($quer)==0){ ?>
    <div class="col-md-4 form-group">
        <label>Site Address : </label>
        <textarea tabindex="18" name="siteAddress" class="form-control" placeholder="Site Address"><?php echo $row['siteAddress'];?></textarea>
    </div>
    <div class="col-md-4 form-group">
    	<label>Cluster Manager Name : </label>
        <input tabindex="19" type="text" class="form-control" name="clusterManagerName" placeholder="Enter Cluster Manager Name" value="<?php echo $row['clusterManagerName']; ?>">
    </div>
    <div class="col-md-4 form-group">
    	<label>Cluster Manager Number : </label>
        <input tabindex="20" type="text" class="form-control" name="clusterManagerNumber" placeholder="Enter Cluster Manager Number" value="<?php echo $row['clusterManagerNumber']; ?>">
    </div>
    <div class="col-md-4 form-group">
    	<label>Cluster Manager Email : </label>
        <input tabindex="21" type="text" class="form-control nocap" name="clusterManagerMail" placeholder="Enter Cluster Manager Email" value="<?php echo $row['clusterManagerMail']; ?>">
    </div>
    <?php } ?>
    <input tabindex="22" type="hidden" class="form-control"  name="scheduleDays" id="ajaxSelect_schedule" value="<?php echo $row['scheduleDays']; ?>">
    <input tabindex="23" type="hidden" class="form-control" name="warrantyMonths" id="ajaxSelect_warranty" value="<?php echo $row['warrantyMonths']; ?>">
    <!--<input tabindex="17" type="hidden" class="form-control" name="warrantyLeft" id="ajaxSelect_warrantyLeft">-->
    <input tabindex="24" type="hidden" class="form-control" name="siteStatus" id="siteStatus" value="<?php echo $row['siteStatus']; ?>">
    <?php /*?><div class="col-md-4 form-group">
        <label>Preventive Maintenance Schedule : </label>
        <input tabindex="22" type="text" class="form-control"  name="scheduleDays" readonly id="ajaxSelect_schedule" value="<?php echo $row['scheduleDays']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Warranty Months : </label>
        <input tabindex="23" type="text" class="form-control" name="warrantyMonths" readonly id="ajaxSelect_warranty" value="<?php echo $row['warrantyMonths']; ?>">
    </div>
        <div class="col-md-4 form-group" id="hidden">
        <label>Warranty Left : </label>
        <input tabindex="24" type="text" class="form-control" name="warrantyLeft" readonly id="ajaxSelect_warrantyLeft">
    </div>
    <div class="col-md-4 form-group">
        <label>Site Status : </label>
        <select tabindex="25" name="siteStatus" class="form-control" id="siteStatus">
        <option value="">Select Site Status</option>
        <option value="Warranty" <?php echo selected($row['siteStatus'],"Warranty"); ?>>Under Warranty</option>
        <option value="OutOfWarranty" <?php echo selected($row['siteStatus'],"OutOfWarranty"); ?>> Out of Warranty</option>
        <option value="Amc" <?php echo selected($row['siteStatus'],"Amc"); ?>> AMC</option> 
        </select>
    </div><?php */?>
    <div class="col-md-4 form-group">
    <label>Nature Of Complaint : </label>
    <select tabindex="26" name="natureOfComplaint" class="form-control" id="natureOfComplaint">
    <option value="" disabled> Select Nature Of Activity First</option><?php echo explodeEdit($row['natureOfComplaint'],'ss_nature_of_complaint','complaint');?>
    </select>
</div>
<div class="col-md-4 form-group">
    <label>Complete Description : </label>
    <textarea tabindex="28" name="completeDesc" class="form-control" placeholder="Complete Description"><?php echo $row['description']; ?></textarea>
</div>
<span class="ui-autocomplete-loading"></span>
   <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="approve" tabindex="29">Approve</button>
            <button type="submit" class="btn btn-primary ss_buttons" name="reject" tabindex="30">Reject</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="31">Reset</button>
        </div>
    </div>
</form>
<?php function selected($a,$b){ if($a==$b){ return "selected"; } } ?>
