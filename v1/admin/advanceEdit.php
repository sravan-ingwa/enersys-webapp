<?php include('lock.php'); include('functions.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php TitleFav();?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/autoComplete.css" />
<link href="css/autoFill.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datetimepicker.min.css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/datepicker.css" />
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body role="document">
<?php include('header.php');?>
<div class="container-fluid"><!-- Starting Of Body Container -->
    <div class="row">
        <div class="col-sm-1 hidden-xs"></div>
        	<div class="col-xs-12 col-sm-10">
            	<div class="panel panel-primary">
                	<div class="panel-heading">
                    	<h3 class="panel-title">Advance Edit</h3>
                    </div>
                	<div class="panel-body">




<?php
if(isset($_REQUEST['update'])){
		$a=mysql_escape_string($_REQUEST['ticketId']);
		$b=mysql_escape_string($_REQUEST['natureOfActivity']);		
		$c=mysql_escape_string($_REQUEST['siteId']);
		$d=mysql_escape_string($_REQUEST['siteName']);	
		$e=mysql_escape_string($_REQUEST['zone']);	
		$f=mysql_escape_string($_REQUEST['circle']);
		$g=mysql_escape_string($_REQUEST['cluster']);	
		$h=mysql_escape_string($_REQUEST['district']);		
		$i=mysql_escape_string($_REQUEST['mfgDate']);
		$j=mysql_escape_string($_REQUEST['installDate']);
		$k=mysql_escape_string($_REQUEST['serviceEngineer']);
		$l=mysql_escape_string($_REQUEST['numBanks']);
		$m=mysql_escape_string($_REQUEST['customerName']);
		$n=mysql_escape_string($_REQUEST['customerNumber']);	
		$o=mysql_escape_string($_REQUEST['customerCategory']);
		
		$p=mysql_escape_string($_REQUEST['siteType']);
		$q=mysql_escape_string($_REQUEST['custName']);
		$r=mysql_escape_string($_REQUEST['createdDate']);
		$s=mysql_escape_string($_REQUEST['natureOfComplaint']);
		$t=mysql_escape_string($_REQUEST['productCode']);
		$u=mysql_escape_string($_REQUEST['description']);
		$v=mysql_escape_string($_REQUEST['ticketStatus']);
		$w=mysql_escape_string($_REQUEST['ticketType']);
		$x=mysql_escape_string($_REQUEST['moc']);
		$y=mysql_escape_string($_REQUEST['faultcode']);
		$z=mysql_escape_string($_REQUEST['visitedby']);	
		$aa=mysql_escape_string($_REQUEST['contactnumber']);
		$ab=mysql_escape_string($_REQUEST['physicaldamages']);	
		$ac=mysql_escape_string($_REQUEST['smpscapacity']);	
		$ad=mysql_escape_string($_REQUEST['smpsdisplaycondition']);
		
		$ae=mysql_escape_string($_REQUEST['noofworkingmodules']);
		$af=mysql_escape_string($_REQUEST['permodulsrating']);	
		$ag=mysql_escape_string($_REQUEST['ebavailabilityperdayaspertechnician']);	
		$ah=mysql_escape_string($_REQUEST['dgrunhoursperdayaspertechnician']);	
		$ai=mysql_escape_string($_REQUEST['logbookstatus']);
		$aj=mysql_escape_string($_REQUEST['dgcapacity']);
		$ak=mysql_escape_string($_REQUEST['dgstatus']);	
		$al=mysql_escape_string($_REQUEST['sitegauardavailability']);	
		$am=mysql_escape_string($_REQUEST['acstatus']);	
		$an=mysql_escape_string($_REQUEST['sitetemperature']);
		$ao=mysql_escape_string($_REQUEST['floatvoltatterminal']);	
		$ap=mysql_escape_string($_REQUEST['lvdstatus']);	
		$aq=mysql_escape_string($_REQUEST['nooffaultycells']);
		$ar=mysql_escape_string($_REQUEST['boostvoltage']);		
		$as=mysql_escape_string($_REQUEST['siteload']);
		
		$at=mysql_escape_string($_REQUEST['completeobservation']);
		//$au=mysql_escape_string($_REQUEST['visitfsrreport']);
		//$av=mysql_escape_string($_REQUEST['closedfsrreport']);
		$aw=mysql_escape_string($_REQUEST['lvdsetting']);
		$ax=mysql_escape_string($_REQUEST['plannedDate']);
		$ay=mysql_escape_string($_REQUEST['checkStat']);	
		$az=mysql_escape_string($_REQUEST['serviceEngineerMobile']);
		$ba=mysql_escape_string($_REQUEST['errorAdmin']);	
		$bb=mysql_escape_string($_REQUEST['errorTechnical']);	
		$bc=mysql_escape_string($_REQUEST['errorMessage']);	
		$bd=mysql_escape_string($_REQUEST['noofBanks']);	
		$be=mysql_escape_string($_REQUEST['fsrNumber']);	
		$bf=mysql_escape_string($_REQUEST['faultyCellSerial']);
		$bg=mysql_escape_string($_REQUEST['replacedCellSerial']);	
		$bh=mysql_escape_string($_REQUEST['sitePhotoGraphs']);
		
		$bi=mysql_escape_string($_REQUEST['closingDate']);	
		$bj=mysql_escape_string($_REQUEST['closefsrNumber']);
		$bk=mysql_escape_string($_REQUEST['falseMessage']);
		$bl=mysql_escape_string($_REQUEST['smpsIDate']);	
		$bm=mysql_escape_string($_REQUEST['dgMake']);	
		$bn=mysql_escape_string($_REQUEST['tat']);	
		$bo=mysql_escape_string($_REQUEST['mocReport']);
		$bp=mysql_escape_string($_REQUEST['visitRemarks']);	
		$bq=mysql_escape_string($_REQUEST['activationDate']);	

/*		if($a==""){$result="Enter TicketId";}
		elseif($b==""){$result="Choose login Date";}
		elseif($c==""){$result="Select natureOfActivity";}
		elseif($d==""){$result="Select customerCategory";}
		elseif($e==""){$result="Enter siteId";}
		elseif($f==""){$result="Enter siteName";}
		elseif($g==""){$result="Select zone";}
		elseif($h==""){$result="Select circle";}
		elseif($i==""){$result="Select cluster";}
		elseif($j==""){$result="Select district";}
		elseif($k==""){$result="Choose plannedDate";}
		elseif($l==""){$result="Choose mfgDate";}
		elseif($m==""){$result="Choose activationDate";}
		elseif($n==""){$result="Choose installDate";}
		elseif($o==""){$result="Enter serviceEngineer";}
		elseif($p==""){$result="Enter serviceEngineerMobile";}
		elseif($q==""){$result="Enter customerName";}
		elseif($r==""){$result="Enter customerNumber";}
		elseif($s==""){$result="Enter noofBanks";}
		elseif($t==""){$result="Enter siteType";}
		elseif($u==""){$result="Enter custName";}
		elseif($v==""){$result="Select natureOfComplaint";}
		elseif($w==""){$result="Select productCode";}
		elseif($x==""){$result="Enter description";}
		elseif($y==""){$result="Enter ticketStatus";}
		elseif($z==""){$result="Enter ticketType";}
		elseif($z1==""){$result="Select moc";}
		else{*/
		$ac = mysql_query("UPDATE ss_tickets SET ticketId='$a', natureOfActivity='$b', siteId='$c', siteName='$d', zone='$e', circle='$f', cluster='$g', district='$h', mfgDate='$i', installDate='$j', serviceEngineer='$k', numBanks='$l', customerName='$m', customerNumber='$n', customerCategory='$o', siteType='$p', custName='$q', createdDate='$r', natureOfComplaint='$s', productCode='$t', description='$u', ticketStatus='$v', ticketType='$w', moc='$x', faultcode='$y', visitedby='$z',	contactnumber='$aa', physicaldamages='$ab', smpscapacity='$ac',	smpsdisplaycondition='$ad',	noofworkingmodules='$ae', permodulsrating='$af', ebavailabilityperdayaspertechnician='$ag', dgrunhoursperdayaspertechnician='$ah', logbookstatus='$ai', dgcapacity='$aj', dgstatus='$ak', sitegauardavailability='$al', acstatus='$am',	sitetemperature='$an', floatvoltatterminal='$ao', lvdstatus='$ap',	nooffaultycells='$aq',	boostvoltage='$ar', siteload='$as',	completeobservation='$at', lvdsetting='$aw', plannedDate='$ax', checkStat='$ay', serviceEngineerMobile='$az', errorAdmin='$ba', errorTechnical='$bb', errorMessage='$bc', noofBanks='$bd', fsrNumber='$be', faultyCellSerial='$bf', replacedCellSerial='$bg', sitePhotoGraphs='$bh', closingDate='$bi', closefsrNumber='$bj', falseMessage='$bk', smpsIDate='$bl', dgMake='$bm', tat='$bn', mocReport='$bo', visitRemarks='$bp', activationDate='$bq' WHERE id='".$_REQUEST['y'] ."'");
			if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){document.location = 'index.php?x=".$_REQUEST['x']."';},1000); </script>";else $result=errorMsg('ERRMSG002');
		//}
}
?>


<form method="post">
<?php
	$tb= menuName($_REQUEST['x'],"tbName");
	//$query = mysql_query("SELECT colName,colRef FROM ss_col_ref WHERE tbName='$tb' AND pView='0' ORDER BY ordering"); if(mysql_num_rows($query)>0){while($row=mysql_fetch_array($query)){$colName[]=$row['colName'];$colref[]=$row['colRef'];}}
	$queryx=mysql_query("SELECT * FROM $tb WHERE id='$_REQUEST[y]'");
	while($rowx=mysql_fetch_array($queryx)){
?>
<p style="color:green;"><?php echo $result; ?></p>
<div class="col-md-4 form-group"><label> Ticket ID : </label><input tabindex="1" autofocus="autofocus" name="ticketId" type='text' class="form-control" placeholder="Ticket Id" value="<?php echo $rowx['ticketId']; ?>"/></div>
<div class="col-md-4 form-group"><label> Activity : </label><select tabindex="2" class="form-control" name="natureOfActivity"><option value="" disabled selected> Select Nature Of Activity </option><?php echo explodeEdit($rowx['natureOfActivity'],'ss_nature_of_activity','activity'); ?></select></div>
<div class="col-md-4 form-group"><label> Site ID : </label><input tabindex="3" type="text" class="form-control fulcap" name="siteId" value="<?php echo $rowx['siteId']; ?>"/></div>
<div class="col-md-4 form-group"><label> Site Name : </label><input tabindex="4" type="text" class="form-control" name="siteName" value="<?php echo $rowx['siteName']; ?>" /></div>
<div class="col-md-4 form-group"><label> Zones : </label><select tabindex="5" class="form-control" name="zone" onchange="ajaxSelect(this.options[this.selectedIndex].value,'Circle')"><option value="">select zone</option><?php echo explodeEdit($rowx['zone'],'ss_zone','zone'); ?></select></div>
<div class="col-md-4 form-group"><label> Circles : </label><select tabindex="6" name="circle" class="form-control" id="ajaxSelect_Circle"  onchange="ajaxSelect(this.options[this.selectedIndex].value,'Cluster')"><option value="">Select Circle</option><?php echo explodeEdit($rowx['circle'],'circleGetName','circle'); ?></select></div>
<div class="col-md-4 form-group"><label> Clusters : </label><select tabindex="7" name="cluster" class="form-control" id="ajaxSelect_Cluster" onchange="ajaxSelect(this.options[this.selectedIndex].value,'District')"><option value="">Select Cluster</option><?php echo explodeEdit($rowx['cluster'],'clustersGetName','cluster'); ?></select></div>
<div class="col-md-4 form-group"><label> Districts : </label><select tabindex="8" name="district" class="form-control" id="ajaxSelect_District"><option value="">Select District</option><?php echo explodeEdit($rowx['district'],'districtsGetName','district'); ?></select></div>
<div class="col-md-4 form-group"><label> Manufacturing Date : </label><input tabindex="9" name="mfgDate" type='text' class="form-control" id='mfdDate' placeholder="YYYY-MM-DD" contenteditable="false" value="<?php echo zeroDates($rowx['mfgDate']); ?>" /></div>
<div class="col-md-4 form-group"><label> Installation Date : </label><input tabindex="10" name="installDate" type='text' class="form-control" id='installDate' placeholder="YYYY-MM-DD" contenteditable="false" value="<?php echo zeroDates($rowx['installDate']); ?>"/></div>
<div class="col-md-4 form-group"><label> Service Engineer : </label><input tabindex="11" name="serviceEngineer" type='text' class="form-control" placeholder="Service Engineer" value="<?php echo $rowx['serviceEngineer']; ?>"/></div>
<div class="col-md-4 form-group"><label> Number Of Banks : </label><input tabindex="12" name="numBanks" type='text' class="form-control" placeholder="numBanks" value="<?php echo $rowx['numBanks']; ?>"/></div>
<div class="col-md-4 form-group"><label> Customer Name : </label><input tabindex="13" name="customerName" type='text' class="form-control" placeholder="customerName" value="<?php echo $rowx['customerName']; ?>"/></div>
<div class="col-md-4 form-group"><label> Customer Number : </label><input tabindex="14" name="customerNumber" type='text' class="form-control" placeholder="customerNumber" value="<?php echo $rowx['customerNumber']; ?>"/></div>
<div class="col-md-4 form-group"><label> Customer Category : </label><select tabindex="15" name="customerCategory" class="form-control"><option value="">Select Customer Category</option><?php echo explodeEdit($rowx['customerCategory'],'ss_customer_category','category'); ?></select></div>
<div class="col-md-4 form-group"><label> Site Type : </label><select tabindex="16" name="siteType" class="form-control" id="siteType"><option value="" disabled="disabled" >Select  Site Type</option><option value="in" <?php if($rowx['siteType']=="in")echo "selected"?>>IN</option><option value="out" <?php if($rowx['siteType']=="out")echo "selected"?>>OUT</option><option value="AC3TR" <?php if($rowx['siteType']=="AC3TR")echo "selected"?>>AC3TR</option><option value="SL" <?php if($rowx['siteType']=="SL")echo "selected"?>>SL</option></select></div>
<div class="col-md-4 form-group"><label> Cust Name : </label><select tabindex="17" name="custName" class="form-control" id="ajaxSelect_CustomerName" onchange="ajaxfit(this.options[this.selectedIndex].value,'schedule','smSchedule')"><option value="">Select Customer Code</option><option value="<?php echo $rowx['custName']; ?>" selected><?php echo $rowx['custName']; ?></option><?php echo customerCodeOptions(); ?></select></div>
<div class="col-md-4 form-group"><label> Login Date : </label><input tabindex="18" name="createdDate" type='text' class="form-control singleDateTime" placeholder="YYYY-MM-DD" contenteditable="false" value="<?php echo zeroDates($rowx['createdDate']); ?>" /></div>
<div class="col-md-4 form-group"><label> Nature Of Complaint : </label><select tabindex="19" name="natureOfComplaint" class="form-control"><option value="" disabled selected> Select Nature Of Complaint </option><?php echo explodeEdit($rowx['natureOfComplaint'],'ss_nature_of_complaint','complaint'); ?></select></div>
<div class="col-md-4 form-group"><label> Product Code : </label><select tabindex="20" name="productCode" class="form-control" onchange="ajaxfit('gf','warranty','prwarr')"><option value="">Select Product Code</option><option value="<?php echo $rowx['productCode']; ?>" selected><?php echo $rowx['productCode']; ?></option><?php echo productCodeOptions(); ?></select></div>
<div class="col-md-4 form-group"><label> Description : </label><input tabindex="21" name="description" type='text' class="form-control" placeholder="Description" value="<?php echo $rowx['description']; ?>"/></div>
<div class="col-md-4 form-group"><label> Status : </label><input tabindex="22" name="ticketStatus" type='text' class="form-control" placeholder="ticketStatus" value="<?php echo $rowx['ticketStatus']; ?>"/></div>
<div class="col-md-4 form-group"><label> Visit Planned : </label><input tabindex="23" name="ticketType" type='text' class="form-control" placeholder="ticketType" value="<?php echo $rowx['ticketType']; ?>"/></div>
<div class="col-md-4 form-group"><label> Mode Of Contact : </label><select tabindex="24" name="moc" id="moc" class="form-control"><option value="" disabled selected> Select MOC </option><option value="Email" <?php if($rowx['moc']=="Email")echo "selected"?>>Email</option><option value="Fax" <?php if($rowx['moc']=="Fax")echo "selected"?>>Fax</option><option value="Letter" <?php if($rowx['moc']=="Letter")echo "selected"?>>Letter</option><option value="Phone" <?php if($rowx['moc']=="Phone")echo "selected"?>>Phone</option></select></div>
<div class="col-md-4 form-group"><label> Fault Code : </label><input tabindex="25" type="text" class="form-control" name="faultcode" placeholder="Fault Code" value="<?php echo $rowx['faultcode']; ?>" /></div>
<div class="col-md-4 form-group"><label> Visited On : </label><input tabindex="26" type="text" name="visitedby" class="form-control singleDateEnd" placeholder="Visited By" value="<?php echo zeroDates($rowx['visitedby']); ?>" /></div>
<div class="col-md-4 form-group"><label> Contact Number : </label><input tabindex="27" type="text" name="contactnumber" class="form-control" placeholder="Contact Number" value="<?php echo $rowx['contactnumber']; ?>"/></div>
<div class="col-md-4 form-group"><label> Physical Damages : </label><input tabindex="28" type="text" name="physicaldamages" class="form-control" placeholder="Physical Damages" value="<?php echo $rowx['physicaldamages']; ?>"/></div>
<div class="col-md-4 form-group"><label> SMPS Capacity : </label><input tabindex="29" name="smpscapacity" type='text' class="form-control" placeholder="SMPS Capacity" value="<?php echo $rowx['smpscapacity']; ?>" /></div>
<div class="col-md-4 form-group"><label> SMPS Display Condition : </label><input tabindex="30" name="smpsdisplaycondition" type='text' class="form-control" placeholder="SMPS Display Condition" value="<?php echo $rowx['smpsdisplaycondition']; ?>"/></div>
<div class="col-md-4 form-group"><label> No Of Working Modules : </label><input tabindex="31" name="noofworkingmodules" type='text' class="form-control" placeholder="No Of Working Modules" value="<?php echo $rowx['noofworkingmodules']; ?>"/></div>
<div class="col-md-4 form-group"><label> Per Moduls Rating : </label><input tabindex="32" name="permodulsrating" type='text' class="form-control" placeholder="Per Moduls Rating" value="<?php echo $rowx['permodulsrating']; ?>"/></div>
<div class="col-md-4 form-group"><label> EB Availability Per Day as Per Technician : </label><input tabindex="33" name="ebavailabilityperdayaspertechnician" type='text' class="form-control" placeholder="EB Availability Per Day as Per Technician" value="<?php echo $rowx['ebavailabilityperdayaspertechnician']; ?>"/></div>
<div class="col-md-4 form-group"><label> Dgrun Hours Per Day as Per Technician : </label><input tabindex="34" name="dgrunhoursperdayaspertechnician" type='text' class="form-control" placeholder="DG Run Hours Per Day as Per Technician" value="<?php echo $rowx['dgrunhoursperdayaspertechnician']; ?>"/></div>
<div class="col-md-4 form-group"><label> Log Book Status : </label><input tabindex="35" name="logbookstatus" type='text' class="form-control" placeholder="Log Book Status" value="<?php echo $rowx['logbookstatus']; ?>"/></div>
<div class="col-md-4 form-group"><label> DG Capacity : </label><input tabindex="36" type="text" name="dgcapacity" class="form-control" placeholder="DG Capacity" value="<?php echo $rowx['dgcapacity']; ?>" /></div>
<div class="col-md-4 form-group"><label> DG Status : </label><input tabindex="37" type="text" name="dgstatus" class="form-control" placeholder="DG Status" value="<?php echo $rowx['dgstatus']; ?>" /></div>
<div class="col-md-4 form-group"><label> Site Guard Availability : </label><input tabindex="38" name="sitegauardavailability" type='text' class="form-control" placeholder="Site Guard Availability" value="<?php echo $rowx['sitegauardavailability']; ?>" /></div>
<div class="col-md-4 form-group"><label> AC Status : </label><input tabindex="39" name="acstatus" type='text' class="form-control" placeholder="AC Status" value="<?php echo $rowx['acstatus']; ?>" /></div>
<div class="col-md-4 form-group"><label> Site Temperature : </label><input tabindex="40" name="sitetemperature" type='text' class="form-control" placeholder="Site Temperature" value="<?php echo $rowx['sitetemperature']; ?>" /></div>
<div class="col-md-4 form-group"><label> Float Volt at Terminal : </label><input tabindex="41" name="floatvoltatterminal" type='text' class="form-control" placeholder="Float Volt at Terminal" value="<?php echo $rowx['floatvoltatterminal']; ?>"/></div>
<div class="col-md-4 form-group"><label> LVD Status : </label><input tabindex="42" name="lvdstatus" type='text' class="form-control" placeholder="LVD Status" value="<?php echo $rowx['lvdstatus']; ?>"/></div>
<div class="col-md-4 form-group"><label> No Of Faulty Cells : </label><input tabindex="43" name="nooffaultycells" type='text' class="form-control" placeholder="No Of Faulty Cells" value="<?php echo $rowx['nooffaultycells']; ?>"/></div>
<div class="col-md-4 form-group"><label> Boost Voltage : </label><input tabindex="44" name="boostvoltage" type='text' class="form-control" placeholder="Boost Voltage" value="<?php echo $rowx['boostvoltage']; ?>"/></div>
<div class="col-md-4 form-group"><label> Site Load : </label><input tabindex="45" name="siteload" type='text' class="form-control" placeholder="Site Load" value="<?php echo $rowx['siteload']; ?>"/></div>
<div class="col-md-4 form-group"><label> Complete Observation : </label><input tabindex="46" name="completeobservation" type='text' class="form-control" placeholder="Complete Observation" value="<?php echo $rowx['completeobservation']; ?>"/></div>
<?php /*?><div class="col-md-4 form-group"><label> Visit FSR Report : </label><input tabindex="47" name="visitfsrreport" type='text' class="form-control" placeholder="Visit FSR Report" value="<?php echo $rowx['visitfsrreport']; ?>"/></div>
<div class="col-md-4 form-group"><label> Closed FSR Report : </label><input tabindex="48" name="closedfsrreport" type='text' class="form-control" placeholder="closed FSR Report" value="<?php echo $rowx['closedfsrreport']; ?>"/></div><?php */?>
<div class="col-md-4 form-group"><label> LVD Setting : </label><input tabindex="49" name="lvdsetting" type='text' class="form-control" placeholder="LVD Setting" value="<?php echo $rowx['lvdsetting']; ?>" /></div>
<div class="col-md-4 form-group"><label> Planned Date : </label><input tabindex="50" name="plannedDate" type='text' class="form-control plannedDate" placeholder="YYYY-MM-DD" contenteditable="false" value="<?php echo zeroDates($rowx['plannedDate']); ?>" /></div>
<div class="col-md-4 form-group"><label> Check Status : </label><input tabindex="51" name="checkStat" type='text' class="form-control" placeholder="Check Status" value="<?php echo $rowx['checkStat']; ?>"/></div>
<div class="col-md-4 form-group"><label> Service Engineer Mobile : </label><input tabindex="52" name="serviceEngineerMobile" type='text' class="form-control" placeholder="Service Engineer Mobile" value="<?php echo $rowx['serviceEngineerMobile']; ?>"/></div>
<div class="col-md-4 form-group"><label> Error Admin : </label><input tabindex="53" name="errorAdmin" type='text' class="form-control" placeholder="Error Admin" value="<?php echo $rowx['errorAdmin']; ?>"/></div>
<div class="col-md-4 form-group"><label> Error Technical : </label><input tabindex="54" name="errorTechnical" type='text' class="form-control" placeholder="Error Technical" value="<?php echo $rowx['errorTechnical']; ?>"/></div>
<div class="col-md-4 form-group"><label> Error Message : </label><input tabindex="55" name="errorMessage" type='text' class="form-control" placeholder="Error Message" value="<?php echo $rowx['errorMessage']; ?>"/></div>
<div class="col-md-4 form-group"><label> No Of Banks : </label><input tabindex="56" name="noofBanks" type='text' class="form-control" placeholder="No Of Banks" value="<?php echo $rowx['noofBanks']; ?>"/></div>
<div class="col-md-4 form-group"><label> FSR Number : </label><input tabindex="57" name="fsrNumber" type='text' class="form-control" placeholder="FSR Number" value="<?php echo $rowx['fsrNumber']; ?>"/></div>
<div class="col-md-4 form-group"><label> Faulty Cell erial : </label><input tabindex="58" name="faultyCellSerial" type='text' class="form-control" placeholder="Faulty Cell Serial" value="<?php echo $rowx['faultyCellSerial']; ?>" /></div>
<div class="col-md-4 form-group"><label> Replaced Cell Serial : </label><input tabindex="59" name="replacedCellSerial" type='text' class="form-control" placeholder="Replaced Cell Serial" value="<?php echo $rowx['replacedCellSerial']; ?>" /></div>
<div class="col-md-4 form-group"><label> Site Photo Graphs : </label><input tabindex="60" name="sitePhotoGraphs" type='text' class="form-control" placeholder="Site Photo Graphs" value="<?php echo $rowx['sitePhotoGraphs']; ?>" /></div>
<div class="col-md-4 form-group"><label> Closing Date : </label><input tabindex="61" name="closingDate" type='text' class="form-control singleDateTimeEnd" placeholder="YYYY-MM-DD HH:MM:SS" contenteditable="false" value="<?php echo zeroDates($rowx['closingDate']); ?>"/></div>
<div class="col-md-4 form-group"><label> Close FSR Number : </label><input tabindex="62" name="closefsrNumber" type='text' class="form-control" placeholder="Close FSR Number" value="<?php echo $rowx['closefsrNumber']; ?>"/></div>
<div class="col-md-4 form-group"><label> False Message : </label><input tabindex="63" name="falseMessage" type='text' class="form-control" placeholder="False Message" value="<?php echo $rowx['falseMessage']; ?>"/></div>
<div class="col-md-4 form-group"><label> SMPS IDate : </label><input tabindex="64" name="smpsIDate" type='text' class="form-control singleDateEnd" placeholder="YYYY-MM-DD" contenteditable="false" value="<?php echo zeroDates($rowx['smpsIDate']); ?>"/></div>
<div class="col-md-4 form-group"><label> DG Make : </label><input tabindex="65" name="dgMake" type='text' class="form-control" placeholder="DG Make" value="<?php echo $rowx['dgMake']; ?>"/></div>
<div class="col-md-4 form-group"><label> Tat : </label><input tabindex="66" name="tat" type='text' class="form-control" placeholder="Tat" value="<?php echo $rowx['tat']; ?>"/></div>
<div class="col-md-4 form-group"><label> MOC Report : </label><input tabindex="67" name="mocReport" type='text' class="form-control" placeholder="MOC Report" value="<?php echo $rowx['mocReport']; ?>"/></div>
<div class="col-md-4 form-group"><label> Activation Date : </label><input tabindex="69" name="activationDate" type='text' class="form-control singleDateTimeEnd" placeholder="YYYY-MM-DD HH:MM:SS" contenteditable="false" value="<?php echo zeroDates($rowx['activationDate']); ?>" /></div>
<div class="col-md-4 form-group"><label> Visit Remarks : </label><textarea tabindex="68" name="visitRemarks" class="form-control" placeholder="Visit Remarks"><?php echo $rowx['visitRemarks']; ?></textarea></div>
<?php } ?>
<div class="form-group col-xs-12 morpad">
	<div class="col-xs-12">
<button tabindex="70" type="submit" class="btn btn-primary ss_buttons" name="update" >Update</button>
<button tabindex="71" type="button" class="btn btn-primary ss_buttons" name="reset" onClick="window.location.reload(true);" >Reset</button>
</div>
</div>
</form>
<?php
function  customerCodeOptions(){
	$query = mysql_query("SELECT * FROM  ss_customer_details WHERE flag='0'");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<option value='$row[customerName]'>$row[customerName]</option>";}
	}else{echo "<option value='' disabled>Add Customer Code First</option>";}

}
function  productCodeOptions(){
	$query = mysql_query("SELECT * FROM  ss_product_details WHERE flag='0'");
	if(mysql_num_rows($query)>0){
		while($row=mysql_fetch_array($query)){echo "<option value='$row[productCode]'>$row[productCode]</option>";}
	}else{echo "<option value='' disabled>Add Product Code First</option>";}

}
?>



















                	</div>
            	</div>
        	</div><!-- Closing Of col-xs-12 -->
    	<div class="col-sm-1 hidden-xs"></div>
    </div>
</div><!-- Closing Of Body Container -->
	<script type="text/javascript" src="js/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

    <script src="js/bootstrapValidator.min.js"></script>
    <script src="js/validation.js"></script>
    <script type="text/javascript" src="js/jquery.autocomplete.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.2.custom.min.js"></script>
	<script type="text/javascript" src="js/moment.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>

	<script>
		$('.tooltips').tooltip();
        $(document).ready(function(){
            var arr = [ "all", "create", "view", "edit", "delete", "xport", "special" ];
            $.each( arr, function( i, val ) {
            $('#uncheck_'+val).click(function(){$('.'+val).prop('checked', false);});
            $('#check_'+val).click(function(){$('.'+val).prop('checked', true);});
            });
        });
    </script>

<script type="text/javascript">
function ajaxSelect(id, type) {
    if (id != "") {
		if(type.search(",") == "-1"){
			$.ajax({
				type: "POST",
				url: "ajaxSelect.php",
				data: 'type=' + type + '&id=' + id,
				cache: false,
				success: function(result) {
					$("#ajaxSelect_" + type).html(result);
				}
			});
		}
		else{
			var temp = new Array();
			temp = type.split(",");
			var x;
			for(x in temp){multipleAjaxSelect(temp[x],id);}
			function multipleAjaxSelect(mtype,mid){
				$.ajax({ 
						type: "POST",
						url: "ajaxSelect.php",
						data: 'type=' + mtype + '&id=' + mid,
						cache: false,
						success: function(result){$("#ajaxSelect_" +mtype).html(result);}
					});
			}
		}
    }
    if (type == "Circle") {
        $("#ajaxSelect_Circle").html("<option value='' disabled >Select Circle</option>");
        $("#ajaxSelect_Cluster").html("<option value='' disabled >Select Cluster</option>");
        $("#ajaxSelect_District").html("<option value='' disabled >Select District</option>")
		$("#ajaxSelect_serviceEngineer").html("<option value='' disabled >Select Service Engineer</option>")
		$("#ajaxSelect_regionalManager").html("<option value='' disabled >Select Regional Manager</option>")
    }
    if (type == "Cluster") {
        $("#ajaxSelect_Cluster").html("<option value='' disabled >Select Cluster</option>");
        $("#ajaxSelect_District").html("<option value='' disabled >Select District</option>")
		$("#ajaxSelect_serviceEngineer").html("<option value='' disabled >Select Service Engineer</option>")
		$("#ajaxSelect_regionalManager").html("<option value='' disabled >Select Regional Manager</option>")
    }
    if (type == "District") {
        $("#ajaxSelect_District").html("<option value='' disabled >Select District</option>")
    }
    if (type == "CustomerName") {
        $("#ajaxSelect_CustomerName").html("<option value='' disabled >Select Customer</option>")
    }
}
</script>
<script type="text/javascript">
function ajaxText(id,type){
	if(id!=""){
		var links='type='+type+'&id='+id+'&ref=ajax';
		$.ajax({
			type: "POST",
			url: "ajaxText.php",
			data: links,
			cache: false,
			success: function(result){
				switch(type){
					case 'District':$("#ajaxText_"+type).html("<option value='' disabled selected>Select Base Location</option>"); $("#ajaxText_"+type).append(result);break;
					default:$("#ajaxText_"+type).autocomplete('ajaxText.php?result='+result+'&type='+type+'&ref=autocomplete', {selectFirst: true});
					}
			   }
		});
	}
	if(type=="Circle"){document.getElementById("ajaxText_Circle").value = "";document.getElementById("ajaxText_Cluster").value = "";$("#ajaxText_District").html("<option value='' disabled='disabled'>Select Base Location</option>");}if(type=="Cluster"){document.getElementById("ajaxText_Cluster").value = "";$("#ajaxText_District").html("<option value='' disabled='disabled'>Select Base Location</option>");}if(type=="District"){$("#ajaxText_District").html("<option value='' disabled='disabled'>Select Base Location</option>");}	
}
</script>    
<script type="text/javascript"> 
$(function(){
	$('.noEnterSubmit').keypress(function(e){if(e.which==13)return false;});
	$("#smaster0").autocomplete({
		source: "autoLoad.php", minLength: 1,
		select: function(event, ui) {
			var getUrl = ui.item.id;
			if(getUrl == 'create.php?x=8324' ){ window.open('create.php?x=8324');}
			else{ 
				var xyz = getUrl.split(",");
				for(var i = 0; i < xyz.length; i++){document.getElementById("smaster"+i).value = xyz[i];}
			}
		},html: true,open: function(event, ui) {$(".ui-autocomplete").css("z-index", 1000);}
	});
});
</script>
	<script type="text/javascript">
    function ajaxfit(id,type,tbna){var date="";
        if(tbna=='prwarr'){id=document.getElementById('ajaxSelect_CustomerName').value;date=document.getElementById('installDate').value;}
        if(id!=""){
            var links='type='+type+'&id='+id+'&tbna='+tbna+'&date='+date;
            $.ajax({
                type: "POST",
                url: "ajaxfit.php",
                data: links,
                cache: false,
                success: function(result){ //alert(result);
					if(type=='warranty'){
						today=new Date();
						var d = new Date(document.getElementById("mfdDate").value.split("-").join(", "));
						/*var mfdMon=d.getMonth();var mfdDay=d.getDate();*/	var abc = Math.floor((today.getTime()-d.getTime())/(86400000*30));
						
						var di = new Date(document.getElementById("installDate").value.split("-").join(", "));
						/*var instMon=di.getMonth();var instDay=di.getDate();*/	var def = Math.floor((today.getTime()-di.getTime())/(86400000*30));

						var xyz = result.split(",");
						if((xyz[0].trim()-abc <= 0) || (xyz[1].trim()-def <= 0)){
							if((xyz[0].trim()-abc) < (xyz[1].trim()-def)){ $("#ajaxSelect_"+type).val(xyz[0].trim());}
							else{$("#ajaxSelect_"+type).val(xyz[1].trim());}
							$("#ajaxSelect_warrantyLeft").val("Out Of Warranty");					
							document.getElementById("siteStatus").options[2].setAttribute("selected", "selected");
							}
						else if((xyz[0].trim()-abc) > (xyz[1].trim()-def)){
							$("#ajaxSelect_"+type).val(xyz[1].trim());
							$("#ajaxSelect_warrantyLeft").val((xyz[1].trim()-def)+" Months");
							document.getElementById("siteStatus").options[1].setAttribute("selected", "selected");
							}
						else if((xyz[0].trim()-abc) < (xyz[1].trim()-def)){
							$("#ajaxSelect_"+type).val(xyz[0].trim());
							$("#ajaxSelect_warrantyLeft").val((xyz[0].trim()-abc)+" Months");		
							document.getElementById("siteStatus").options[1].setAttribute("selected", "selected");
							}
						else{ // (xyz[0].trim()-abc) == (xyz[1].trim()-def)
							$("#ajaxSelect_"+type).val(xyz[0].trim());
							$("#ajaxSelect_warrantyLeft").val((xyz[0].trim()-abc)+" Months");	
							document.getElementById("siteStatus").options[1].setAttribute("selected", "selected");	
							}
						}
					else if(tbna=='userdetails'){
						var xyz = result.split(",,");
						for(var i = 0; i < xyz.length; i++){document.getElementById("udata"+i).value = xyz[i].trim();}
					}
					else{document.getElementById("ajaxSelect_"+type).value=result.trim();}
				}
            });
        }
        document.getElementById("ajaxSelect_"+type).value = "";
    }
    </script>

<script type="text/javascript">
function ajaxSelectmulti(ids, type) {
	multipleValues = $( "#"+ids).val() || [];id=multipleValues.join( "," );
	if (id != "") {
		$.ajax({ 
				type: "POST",
				url: "ajaxSelectMulti.php",
				data: 'type=' + type + '&id=' + id,
				cache: false,
				success: function(result){$("#ajaxSelect_" +type).html(result);}
			});
		}
    if (type == "Circle") {
        $("#ajaxSelect_Circle").html("<option value='' disabled >Select Circle</option>");
        $("#ajaxSelect_Cluster").html("<option value='' disabled >Select Cluster</option>");
        $("#ajaxSelect_District").html("<option value='' disabled >Select District</option>")
		$("#ajaxSelect_serviceEngineer").html("<option value='' disabled >Select Service Engineer</option>")
		$("#ajaxSelect_regionalManager").html("<option value='' disabled >Select Regional Manager</option>")
    }
    if (type == "Cluster") {
        $("#ajaxSelect_Cluster").html("<option value='' disabled >Select Cluster</option>");
        $("#ajaxSelect_District").html("<option value='' disabled >Select District</option>")
		$("#ajaxSelect_serviceEngineer").html("<option value='' disabled >Select Service Engineer</option>")
		$("#ajaxSelect_regionalManager").html("<option value='' disabled >Select Regional Manager</option>")
    }
    if (type == "District") {
        $("#ajaxSelect_District").html("<option value='' disabled >Select District</option>")
    }
    if (type == "CustomerName") {
        $("#ajaxSelect_CustomerName").html("<option value='' disabled >Select Customer</option>")
    }
}
</script>
<script>
$(document).ready(function(){
	$('.addrej').click(function(e){ e.preventDefault();
	$('.falhid').hide(); // hides
	$('#rejid').html('<label style="display:block">Rejection Remarks : </label><textarea tabindex="11" name="falset" class="form-control" style="display:inline-block !important;width:80%;"></textarea> <button tabindex="44" type="submit" class="btn btn-primary ss_buttons" name="closett" style="margin-top:-20px;">Reject Ticket</button>'); });
});
</script>
<script type="text/javascript">
	$(function(){
		var sDate =  new Date('2000-01-01');
		var eDate = new Date();
		$('.singleDate').datetimepicker({format: 'YYYY-MM-DD'});
		$('.singleDateEnd').datetimepicker({format: 'YYYY-MM-DD',maxDate:eDate});
		$('.singleDateTime').datetimepicker({format: 'YYYY-MM-DD hh:mm:ss'});
		$('.singleDateTimeEnd').datetimepicker({format: 'YYYY-MM-DD hh:mm:ss',maxDate:eDate});
		$('.plannedDate').datetimepicker({format: 'YYYY-MM-DD',minDate:new Date('<?php echo plannedDate($_REQUEST['y']); ?>')});
		$('#mfdDate').datetimepicker({format:'YYYY-MM-DD',maxDate:eDate,minDate:sDate});//.on("dp.change",function(e){$('#installDate').data("DateTimePicker").minDate(e.date);});
		$('#installDate').datetimepicker({format:'YYYY-MM-DD',maxDate:eDate,minDate:sDate});//.on("dp.change",function(e){$('#mfdDate').data("DateTimePicker").maxDate(e.date);});
		$("#mfdDate").on("dp.change",function(e){$('#installDate').data("DateTimePicker").minDate(e.date);});
        $("#installDate").on("dp.change",function(e){$('#mfdDate').data("DateTimePicker").maxDate(e.date);});
		$("#mfgDate").datetimepicker({format:'YYYY-MM-DD',maxDate:eDate,minDate:sDate}).on('dp.change', function(selected){
			var d = new Date(selected.date.valueOf());
			var mfdMon=d.getMonth();
			var mfdDay=d.getDate();
			var abc = Math.floor((eDate.getTime()-d.getTime())/(86400000*30));
		var mont = document.getElementById('warrantyMonths').value - abc;
		if(mont > 0){document.getElementById('warrantyLeft').value = mont+" Months";}
		else{document.getElementById('warrantyLeft').value ="Out Of Warranty"; }
		});
	});
</script>
<script type="text/javascript">
	$(function () {
		$('.dgCap').change(function(){
		if($(this).val() == 'NON DG'){$('.dgHide').hide();}
		else{$('.dgHide').show();}
		});
	});
</script>
<script type="text/javascript">
$(function(){
	$('#prodCat').change(function(){
		if($(this).val()==''){$("#siteType").html('<option value="" disabled selected>Select Site Type</option><option value="" disabled >First Select Segment</option>');}
		else if($(this).val() == '5169' ){$("#siteType").html('<option value="">Select Site Type</option><option value="AC3TR">AC3TR</option><option value="SL">SL</option>');}
		else{$("#siteType").html('<option value="">Select Site Type</option><option value="in">IN</option><option value="out">OUT</option>');}
	});
});
</script>
<script type="text/javascript">
$(function(){
	$('#itemCode').change(function(){
		if($(this).val() != ''){
			$.ajax({
				type: "POST",
				url: "ajaxTicketItemStatus.php",
				data: "item="+$(this).val()+"&circle="+$('#circle').val(),
				cache: false,
				success: function(result){ $('#itemStatus').val($.trim(result)); }
			});
		}else{$('#itemStatus').val('');}
	});
});
</script>
<script>
function setSelectBoxByText(eid, etxt){
var eid = document.getElementById(eid);
if(etxt==='Reject'){eid.options[1].selected = true;}
else{eid.options[0].selected = true;}
}
</script>
</body>
</html>