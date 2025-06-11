<?php
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['Create'])){
	$a = mysql_real_escape_string($_REQUEST['natureOfActivity']);
	$b = strtoupper(mysql_real_escape_string($_REQUEST['site_id']));
	$cc = mysql_real_escape_string(circleGetID($_REQUEST['circlex']));
	$site=mysql_query("SELECT * FROM ss_site_master WHERE siteID ='$b' AND circle='$cc' AND flag='0'");
		if(mysql_num_rows($site)>0){ $site_row=mysql_fetch_array($site);
			$c = ucwords($site_row['siteName']);
			$d = $site_row['zone'];
			$e = $site_row['circle'];
			$f = $site_row['cluster'];
			$g = $site_row['district'];
			$h = $site_row['mfdDate'];
			$i = $site_row['installDate'];
			$k = $site_row['noOfString'];
			$l = ucwords($site_row['customerName']);
			$m = $site_row['customerNumber'];
			$n = $site_row['customerCategory'];
			$o = $site_row['siteType'];
			$p = customerNameGetName($site_row['customerCode']);
			$s = productCodeGetName($site_row['productCode']);

	/*$c = mysql_real_escape_string($_REQUEST['siteNamex']);
	$d = zoneGetID($_REQUEST['zonex']);
	$e = circleGetID($_REQUEST['circlex']);
	$f = clusterGetID($_REQUEST['clusterx']);
	$g = districtsGetID($_REQUEST['districtx']);
	$h = mysql_real_escape_string($_REQUEST['mfdDatex']);
	$i = mysql_real_escape_string($_REQUEST['installDatex']);
	$k = mysql_real_escape_string($_REQUEST['numBanksx']);
	$l = mysql_real_escape_string($_REQUEST['CrNamex']);
	$m = mysql_real_escape_string($_REQUEST['CrNumx']);
	$n = customerCategoriesGetId($_REQUEST['custCategoryx']);
	$o = mysql_real_escape_string($_REQUEST['siteTypex']);
	$p = mysql_real_escape_string($_REQUEST['custNamex']);
	$s = mysql_real_escape_string($_REQUEST['prodCodex']);*/
	
	$q = mysql_real_escape_string($_REQUEST['createdDate']);
	$r = mysql_real_escape_string($_REQUEST['natureOfComplaint']);
	$t = ucfirst(mysql_real_escape_string($_REQUEST['completeDesc']));
	$u = $_REQUEST['moc'];
		if($a==""){$result="Select Nature Of Activity";}
		elseif($b==""){$result="Select Site ID";}
		elseif($r==""){$result="Select Nature Of Complaint";}
		elseif($t==""){$result="Enter Description";}
		elseif($u==""){$result="Select Mode Of Contact";}
		else{
			$query=mysql_query("SELECT id FROM ss_tickets WHERE siteId ='$b' AND natureOfActivity='$a' AND checkStat!='5'");
			$count=mysql_num_rows($query);
			if($count==0){
				if(isset($_FILES['pdf']['name'])){
					for($nn=0;$nn<count($_FILES['pdf']['name']);$nn++){
					if(!empty($_FILES['pdf']['name'][$nn])){
						$fileName[$nn] = uniqid($u.'_').md5($_FILES['pdf']['name'][$nn]); 
							$extension[$nn] = pathinfo($_FILES['pdf']['name'][$nn], PATHINFO_EXTENSION);
							if($extension[$nn] == "pdf"){
								if($_FILES["pdf"]["error"][$nn] > 0){echo "Return Code: ".$_FILES["pdf"]["error"][$nn]."<br/>";}
								else{
									$name[$nn] = $fileName[$nn].".".$extension[$nn];
									if (file_exists("../reports/mocReport/".$name[$nn])){echo "<script>alert('".$name[$nn]." already exists')</script>";}
									else{
										move_uploaded_file($_FILES["pdf"]["tmp_name"][$nn],"../reports/mocReport/".$name[$nn]);
										$uu .= "reports/mocReport/".mysql_real_escape_string($name[$nn]).", ";
									}
								}
							}else{ $result = "Note : Choose pdf file only"; }
						}else{$uu .= "";}
					}
				}else{$uu="";} $uu = substr(trim($uu), 0, -1);
				$v = "Open";$w = "Inactive";$id = checkx(rand(0000, 9999),'ss_tickets');
				$x = ticketsID(strtoupper(circleGetName($e)),1);
				$ac = mysql_query("INSERT INTO ss_tickets(id,ticketId,natureOfActivity,siteId,siteName,zone,circle,cluster,district,mfgDate,installDate,numBanks,customerName,customerNumber,customerCategory,siteType,custName,createdDate,natureOfComplaint,productCode,description,moc,mocReport,ticketStatus,ticketType,flag,checkStat,errorMessage,mailStat) VALUES('$id','$x','$a','$b','$c','$d','$e','$f','$g','$h','$i','$k','$l','$m','$n','$o','$p','$q','$r','$s','$t','$u','$uu','$v','$w','0','0','".ttMsg('1')."','1')");
			if($ac){
				/* Ticket Created SMS Function */
					$message=urlencode( "Greetings from Enersys, your complaint has been registered against the ".natureOfActivityGetName($a)." of Site name-".$c." Ticket No- ".$x ."");
					messageSent($m,$message);
					/* Ticket Created  SMS Function Close */
				$queryy=mysql_query("SELECT contactNo FROM ss_employee_details WHERE circle ='$e' AND employeeRole<>'8226' AND flag=0");
					if(mysql_num_rows($queryy)>0){
						while($abc = mysql_fetch_array($queryy)){
							$numberx=mysql_real_escape_string($abc['contactNo']);
							$messagex=urlencode( "Greetings from Enersys, your complaint has been registered against the ".natureOfActivityGetName($a)." of Site name-".$c." Ticket No- ".$x ."");
							messageSent($numberx,$messagex);
						}
					}
				echo "<script type='text/javascript'>window.location='view.php?y=".$id."&x=2432&ref=".uniqid()."'</script>";
			}
			else $result="Sorry Please try Again!";
		}
		else{$result="Ticket already Registered";}
		}
	}else{$result="Error occurred, Please try again";}
?>
<p class="errorP"><?php if(isset($result))echo $result;?> </p>
<?php }else{ ?>
<form role="form" class="ss_form" method="POST" name="contactform" action="" id="defaultForm" enctype="multipart/form-data" > 
<div class="col-md-4 form-group">
    <label>Nature Of Activity : </label>
    <select tabindex="1" autofocus="autofocus" class="form-control" name="natureOfActivity" id="natureOfActivity">
    <option value="" disabled selected> Select Nature Of Activity </option><?php echo natureOfActivityOption(); ?>
    </select>
</div>
<div class="col-md-4 form-group">
	<label>Created Date : </label>
	<input tabindex="2" name="createdDate" type='text' class="form-control" placeholder="YYYY-MM-DD" contenteditable="false" value="<?php echo date('Y-m-d h:i:s'); ?>" readonly />
</div>
<div class="col-md-4 form-group">
    <label>Site Id : </label>
    <input tabindex="3" type="text" class="form-control noEnterSubmit" placeholder="Site Id" id="smaster0" name="site_id"/>
</div>
<div class="col-md-4 form-group">
    <label>Site Name : </label>
    <input tabindex="4" type="text" class="form-control"  placeholder="Site Name" id="smaster1" name="siteNamex" readonly />
</div>
<div class="col-md-4 form-group">
    <label>Zone : </label>
    <input tabindex="5" type="text" class="form-control"  placeholder="Zone" id="smaster2" name="zonex" readonly />
</div>
<div class="col-md-4 form-group">
	<label>Circle : </label>
	<input tabindex="6" type="text" class="form-control" placeholder="Circle" id="smaster3" name="circlex" readonly />
</div>
<div class="col-md-4 form-group">
	<label>Cluster : </label>
	<input tabindex="7" type="text" class="form-control" placeholder="Cluster" id="smaster4" name="clusterx" readonly />
</div>
<div class="col-md-4 form-group">
	<label>District : </label>
	<input tabindex="8" type="text" class="form-control" placeholder="District" id="smaster5" name="districtx" readonly />
</div>
<div class="col-md-4 form-group">
	<label>Manufactured Date : </label>
	<input tabindex="9" type="text" class="form-control" placeholder="Manufactured Date" id="smaster6" name="mfdDatex" readonly />
</div>
<div class="col-md-4 form-group">
	<label>Install Date : </label>
	<input tabindex="10" type="text" class="form-control" placeholder="Install Date" id="smaster7" name="installDatex" readonly />
</div>
<div class="col-md-4 form-group">
    <label>Number Banks : </label>
    <input tabindex="11" type="text" class="form-control" placeholder="Number Banks" id="smaster8" name="numBanksx" readonly />
</div>
<div class="col-md-4 form-group">
    <label>Site Technician Name : </label>
    <input tabindex="12" type="text" class="form-control" placeholder="CR Name" id="smaster9" name="CrNamex" readonly />
</div>
<div class="col-md-4 form-group">
    <label>Site Technician Number : </label>
    <input tabindex="13" type="text" class="form-control" placeholder="CR Number" id="smaster10" name="CrNumx" readonly />
</div>
<div class="col-md-4 form-group">
    <label>Segment : </label>
    <input tabindex="14" type="text" class="form-control" placeholder="Segment" id="smaster11" name="custCategoryx" readonly />
</div>
<div class="col-md-4 form-group">
    <label>Site Type : </label>
    <input tabindex="15" type="text" class="form-control" placeholder="Site Type" id="smaster12" name="siteTypex" readonly />
</div>
<div class="col-md-4 form-group">
    <label>Customer Name : </label>
    <input tabindex="16" type="text" class="form-control" placeholder="Customer Name" id="smaster13" name="custNamex" readonly />
</div>
<div class="col-md-4 form-group">
    <label>cluster Manager Mail ID : </label>
    <input tabindex="16" type="text" class="form-control nocap" placeholder="cluster Manager MailID" id="smaster14" readonly />
</div>
<div class="col-md-4 form-group">
    <label>Product Code : </label>
    <input tabindex="17" type="text" class="form-control" placeholder="Product Code" id="smaster15" name="prodCodex" readonly />
</div>
<div class="col-md-4 form-group">
    <label>Nature Of Complaint : </label>
    <select tabindex="18" name="natureOfComplaint" class="form-control" id="natureOfComplaint">
    <option value="" disabled selected> Select Nature Of Activity First</option>
    </select>
</div>
<div class="col-md-4 form-group">
    <label>MOC : </label>
    <select tabindex="19" name="moc" id="moc" class="form-control">
    <option value="" disabled selected> Select MOC </option>
    <option value="Email">Email</option>
    <option value="Fax">Fax</option>
    <option value="Letter">Letter</option>
    <option value="Phone">Phone</option>
    </select>
</div>
<span id="res"></span>
<div class="col-md-4 form-group">
    <label>Complete Description : </label>
    <textarea tabindex="20" name="completeDesc" class="form-control" placeholder="Complete Description"></textarea>
</div>
<span class="ui-autocomplete-loading"></span>
<div class="form-group col-xs-12 morpad">
    <div class="col-xs-12">
    <button tabindex="21" type="submit" class="btn btn-primary ss_buttons" name="Create">Create</button>
	<button tabindex="22" type="button" class="btn btn-primary ss_buttons" name="reset" onClick="window.location.reload(true);">Reset</button>   
	</div>
</div>
</form>
<?php }
function ticketsID($circle,$i){
	$sql = mysql_query("SELECT ticketId FROM ss_tickets");
	$num = (mysql_num_rows($sql)+$i);
	if($num > 9){$x = "TT".$circle."00".$num;}
	elseif($num > 99){$x = "TT".$circle."0".$num;}
	elseif($num > 999){$x = "TT".$circle."".$num;}
	else{$x = "TT".$circle."000".$num;}
	$newTT = preg_replace('/\D/', '', $x); 
	while($tt = mysql_fetch_array($sql)){
		$oldTT = preg_replace('/\D/', '', $tt['ticketId']);
		if($oldTT==$newTT){ $arr[] = $oldTT;}
	}
	if(count($arr)==0){ return $x; }
	else{return ticketsID($circle,($i+1)); }
}
?>