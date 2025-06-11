<?php 
if(isset($_REQUEST['update'])){
	date_default_timezone_set("Asia/Kolkata");
	$a=mysql_escape_string($_POST['zone']);					$b=mysql_escape_string($_POST['circle']);
	$c=mysql_escape_string($_POST['cluster']);				$d=mysql_escape_string($_POST['district']);
	$e=mysql_escape_string($_POST['customerCategory']);		$f=mysql_escape_string($_POST['customerCode']);	
	$g=mysql_escape_string($_POST['siteType']);				$h=strtoupper(mysql_escape_string($_POST['siteID']));
	$i=ucwords(mysql_escape_string($_POST['siteName']));	$j=mysql_escape_string($_POST['productCode']);
	$k=mysql_escape_string($_POST['mfdDate']);				$l=mysql_escape_string($_POST['installDate']);
	$m=mysql_escape_string($_POST['noOfString']);			$n=ucwords(mysql_escape_string($_POST['customerName']));
	$o=mysql_escape_string($_POST['customerNumber']);		$p=ucwords(mysql_escape_string($_POST['clusterManagerName']));
	$q=mysql_escape_string($_POST['clusterManagerNumber']);	$r= preg_replace('/\s+/', '', mysql_escape_string($_POST['scheduleDays']));
	$s=mysql_escape_string($_POST['warrantyMonths']);		$t=mysql_escape_string($_POST['siteStatus']);
	$u=strtolower(mysql_escape_string($_POST['clusterManagerMail']));	$v=mysql_real_escape_string($_POST['siteAddress']);
	if($k==""){$result="Select Manufactured Date";}
	else{
		$RefId =$_REQUEST['y'];
		$date= date('Y-m-d'); 
		$id = checkx(rand(0000, 9999),'ss_site_master');
		$ac=mysql_query("UPDATE ss_site_master SET zone='".$a."', circle='".$b."',cluster='".$c."',district='".$d."',customerCategory='".$e."',customerCode='".$f."',siteType='".$g."',siteID='".$h."',siteName='".$i."',productCode='".$j."',mfdDate='".$k."',installDate='".$l."',noOfString='".$m."',customerName='".$n."',customerNumber='".$o."',clusterManagerName='".$p."',clusterManagerNumber='".$q."',scheduleDays='".$r."',warrantyMonths='".$s."',siteStatus='".$t."',clusterManagerMail='".$u."',siteAddress='".$v."' WHERE id='$RefId' ");
		if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
	}
}
$RefId =$_REQUEST['y'];
$query1=mysql_query("SELECT * FROM  ss_site_master WHERE id='$RefId'");
$row = mysql_fetch_array($query1);
?>
<p class="errorP"><?php if(isset($result)){echo $result;} ?> </p>

<form role="form" class="ss_form" method="post" id="defaultForm">
<input type="hidden" name="y" value="<?php echo $RefId;?>" />
    <div class="col-md-4 form-group">
        <label>Zone</label>
        <select tabindex="1" autofocus="autofocus" class="form-control" name="zone" onchange="ajaxSelect(this.options[this.selectedIndex].value,'Circle')">
        <option value="">select zone</option><?php explodeEdit($row['zone'],'ss_zone','zone');?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Circle</label>
        <select tabindex="2" name="circle" class="form-control" id="ajaxSelect_Circle"  onchange="ajaxSelect(this.options[this.selectedIndex].value,'Cluster')">
        <option value="">Select Circle</option><?php explodeEdit($row['circle'],'circleGetName','circle');?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Cluster</label>
        <select tabindex="3" name="cluster" class="form-control" id="ajaxSelect_Cluster" onchange="ajaxSelect(this.options[this.selectedIndex].value,'District')">
        <option value="">Select Cluster</option><?php explodeEdit($row['cluster'],'clustersGetName','cluster');?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>District</label>
        <select tabindex="4" name="district" class="form-control" id="ajaxSelect_District">
        <option value="">Select District</option><?php explodeEdit($row['district'],'districtsGetName','district');?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Segment</label>
        <select tabindex="5" name="customerCategory" class="form-control" id="prodCat" onchange="ajaxSelect(this.options[this.selectedIndex].value,'CustomerName')">
        <option value="">Select Segment</option><?php explodeEdit($row['customerCategory'],'ss_customer_category','category');?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Customer Code</label>
        <select tabindex="6" name="customerCode" class="form-control" id="ajaxSelect_CustomerName" onchange="ajaxfit(this.options[this.selectedIndex].value,'schedule','smSchedule')" >
        <option value="">Select Customer Code</option><?php explodeEdit($row['customerCode'],'customerCodeGetName','customerName');?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Site Type</label>
        <select tabindex="7" name="siteType" class="form-control" id="siteType">
        <option value="in" <?php if($row['siteType']=="in")echo "selected"?>>IN</option>
        <option value="out" <?php if($row['siteType']=="out")echo "selected"?>>OUT</option>
        <option value="AC3TR" <?php if($row['siteType']=="AC3TR")echo "selected"?>>AC3TR</option>
        <option value="SL" <?php if($row['siteType']=="SL")echo "selected"?>>SL</option>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Site ID</label>
        <input tabindex="8" type="text" autocomplete="off" class="form-control fulcap" name="siteID" value="<?php echo $row['siteID']; ?>"/>
    </div>
    <div class="col-md-4 form-group">
        <label>Site Name</label>
        <input tabindex="9" type="text" class="form-control" name="siteName" value="<?php echo $row['siteName']; ?>" />
    </div>
    <div class="col-md-4 form-group">
        <label>Site Address : </label>
        <textarea tabindex="22" name="siteAddress" class="form-control" ><?php echo $row['siteAddress']; ?></textarea>
    </div>
    <div class="col-md-4 form-group">
        <label>Manufactured Date</label>
        <input name="mfdDate" type='text' class="form-control" id='mfdDate' placeholder="YYYY-MM-DD" tabindex="10" contenteditable="false" value="<?php echo $row['mfdDate']; ?>" />
    </div>
    <div class="col-md-4 form-group">
        <label>Installation Date</label>
        <input  name="installDate" type='text' class="form-control" id='installDate' placeholder="YYYY-MM-DD" tabindex="10" contenteditable="false" value="<?php echo $row['installDate']; ?>"/>
    </div>
    <div class="col-md-4 form-group">
        <label>Product Code</label>
        <select tabindex="12" name="productCode" class="form-control" onchange="ajaxfit('gf','warranty','prwarr')">
        <option value="">Select Product Code</option>
		<option value="<?php echo $row['productCode']; ?>" selected="selected"><?php echo productCodeGetName($row['productCode']); ?></option>
		<?php productCodeOption();?>
		</select>
    </div>

    <div class="col-md-4 form-group">
        <label>No. of Strings</label>
        <select tabindex="13" name="noOfString" class="form-control">
        <option value="">Select No. of String</option>
        <?php for($ns=1;$ns<=5;$ns++){echo "<option value='".$ns."'".($row['noOfString']== $ns ? 'selected' : '' ).">".$ns."</option>";}?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Site Technician Name</label>
        <input tabindex="14" type="text" class="form-control" name="customerName" value="<?php echo $row['customerName']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Site Technician Number</label>
        <input tabindex="15" type="text" class="form-control" name="customerNumber" value="<?php echo $row['customerNumber']; ?>">
    </div>
    <div class="col-md-4 form-group">
    	<label>Cluster Manager Name</label>
        <input tabindex="16" type="text" class="form-control" name="clusterManagerName" value="<?php echo $row['clusterManagerName']; ?>">
    </div>
    <div class="col-md-4 form-group">
    	<label>Cluster Manager Number</label>
        <input tabindex="17" type="text" class="form-control" name="clusterManagerNumber" value="<?php echo $row['clusterManagerNumber']; ?>">
    </div>
    <div class="col-md-4 form-group">
    	<label>Cluster Manager Email</label>
        <input tabindex="18" type="text" class="form-control nocap" name="clusterManagerMail" value="<?php echo $row['clusterManagerMail']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Preventive Maintenance Schedule </label>
        <input tabindex="19" type="text"  class="form-control" name="scheduleDays" readonly="readonly" id="ajaxSelect_schedule" value="<?php echo $row['scheduleDays']; ?>">       
    </div>
    <div class="col-md-4 form-group">
        <label>Warranty Months</label>
        <input tabindex="20" type="text" class="form-control" name="warrantyMonths" readonly="readonly" id="ajaxSelect_warranty" value="<?php echo $row['warrantyMonths']; ?>">
    </div>
    <div class="col-md-4 form-group" id="hidden">
        <label>Warranty Left</label>
        <input tabindex="21" type="text" class="form-control" name="warrantyLeft" readonly="readonly" id="ajaxSelect_warrantyLeft" value="<?php echo warrantyLeft($row['customerCode'],$row['mfdDate'],$row['installDate']); ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Site Status</label>
        <select tabindex="21" name="siteStatus" class="form-control" id="siteStatus">
        <option value="">Select Site Status</option>
        <option value="Warranty"  <?php if(is_numeric(current(explode(" ",warrantyLeft($row['customerCode'],$row['mfdDate'],$row['installDate'])))))echo "selected"?>>Under Warranty</option>
        <option value="Out Of Warranty" <?php if(warrantyLeft($row['customerCode'],$row['mfdDate'],$row['installDate'])=="Out Of Warranty") echo "selected" ?>> Out Of Warranty</option>
        <option value="Not Given" <?php if(warrantyLeft($row['customerCode'],$row['mfdDate'],$row['installDate'])=="Not Given") echo "selected" ?>> Not Given</option>
        <option value="Amc" <?php if($row['siteStatus']=="Amc") echo "selected" ?>> AMC</option> 
        </select>
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="update" tabindex="23">Update</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="24">Reset</button>
        </div>
    </div>
</form>

<?php
function warrantyLeft($f1,$f2,$f3){
	date_default_timezone_set("Asia/Kolkata");
	
	$res = mysql_query("select dispatch,installation from ss_customer_details where id='".$f1."' AND flag='0'");
	if(mysql_num_rows($res)>0){$row=mysql_fetch_array($res);
		
		$dis = $row['dispatch'];
		$inst = $row['installation'];
		
		$diff1 = abs(strtotime(date('Y-m-d')) - strtotime($f2)); //$years = $diff / (365*60*60*24);
		$mfd = round($diff1 / (30*60*60*24));
		
		$diff2 = abs(strtotime(date('Y-m-d')) - strtotime($f3));
		$install = round($diff2 / (30*60*60*24));

		if($f2=='0000-00-00'){ $mfd = 0; }
		if($f3=='0000-00-00'){ $install = 0; }

	if($f2=='0000-00-00' && $f3=='0000-00-00'){	 return 'Not Given'; }
	elseif(($dis-$mfd <= 0) || ($inst-$install <= 0)){ return 'Out Of Warranty'; }
	elseif(($dis-$mfd) > ($inst-$install)){ return ($inst-$install).' Months'; }
	elseif(($dis-$mfd) < ($inst-$install)){ return ($dis-$mfd).' Months'; }
	else{ return ($dis-$mfd).' Months'; } // ($dis-$mfd) == ($inst-$install)
	}
}
?>