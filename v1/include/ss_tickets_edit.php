<?php
date_default_timezone_set("Asia/Kolkata"); 
if(isset($_REQUEST['closett'])&&$_REQUEST['checkStat']<'2'){
	if($_REQUEST['falset']!=""){
		$ac = mysql_query("UPDATE ss_tickets SET falseMessage='".mysql_escape_string($_REQUEST['falset'])."', errorMessage='".ttMsg('10')."',ticketStatus='Reject', checkStat='2' WHERE id='".$_REQUEST['y'] ."'");
		if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');	
	}else $result="Enter Rejection Remarks";
}
if(isset($_REQUEST['closett'])&&$_REQUEST['checkStat']=='2'){
	if($_REQUEST['falset']!=""){
		$query=mysql_query("SELECT * FROM ss_tickets WHERE id='".$_REQUEST['y'] ."'");
		$row = mysql_fetch_array($query);
		if($_REQUEST['frej'] =='1'){
		$cDate=mysql_escape_string($_REQUEST['cDate']);
			$ac1 = mysql_query("UPDATE ss_tickets SET falseMessage='".mysql_escape_string($_REQUEST['falset'])."',closingDate='".$cDate."', tat='".tatcheck($_REQUEST['y'])."', errorMessage='".ttMsg('12')."',ticketStatus='Reject', checkStat='5', mailStat='1' WHERE id='".$_REQUEST['y'] ."'");
			if($ac1){
				/* Ticket closed SMS Function */
					$numberx=mysql_escape_string($_REQUEST['CrNumx']);
					$messagex=urlencode("Dear Customer your Ticket No-".$_REQUEST['ticketId']." is closed on Dt-".$cDate.".For feedback contact 040-67046704");
					messageSent($numberx,$messagex);                           
				/* Ticket closed SMS Function Close */
				$result="".errorMsg('ERRMSG009')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";
			}else $result=errorMsg('ERRMSG002');
		}
		elseif($_REQUEST['frej'] =='0' && $row['ticketType']=='Inactive'){
			$ac = mysql_query("UPDATE ss_tickets SET falseMessage='".mysql_escape_string($_REQUEST['falset'])."', errorMessage='".ttMsg('11')."',ticketStatus='Open', checkStat='0' WHERE id='".$_REQUEST['y'] ."'");
			if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
			}
		elseif($_REQUEST['frej'] =='0' && $row['ticketType']=='Active'){
			$ac = mysql_query("UPDATE ss_tickets SET falseMessage='".mysql_escape_string($_REQUEST['falset'])."', errorMessage='".ttMsg('11')."',ticketStatus='Open', checkStat='1' WHERE id='".$_REQUEST['y'] ."'");
			if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
			}
	}else $result="Enter Rejection Remarks";
}
if(isset($_REQUEST['update'])){ 
	if(isset($_REQUEST['plannedDate']) && $_REQUEST['checkStat']<'2'){
		$adate= date('Y-m-d H:i:s');
		$ac = mysql_query("UPDATE ss_tickets SET activationDate='$adate', plannedDate='".mysql_escape_string($_POST['plannedDate'])."' WHERE id='".$_REQUEST['y'] ."'");
		if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');	
	}
	if($_REQUEST['checkStat']=='0'){
		if(isset($_REQUEST['serviceEngineer'])){
			if($_REQUEST['serviceEngineer'] != ""){
				$yc=mysql_escape_string($_REQUEST['serviceEngineerMobile']);	
				$ac = mysql_query("UPDATE ss_tickets SET serviceEngineer='".mysql_escape_string($_POST['serviceEngineer'])."', serviceEngineerMobile='$yc', ticketType='Active', checkStat='1', errorMessage='".ttMsg('2')."' WHERE id='".$_REQUEST['y'] ."'");
			if($ac){
			/* Ticket Planned SMS Function */
				$numberx=mysql_escape_string($_REQUEST['CrNumx']);
				$messagex=urlencode("Dear Customer against your Ticket No-".$_REQUEST['ticketId'].", SE-is allotted for site visit, Mob-".mysql_escape_string($_REQUEST['serviceEngineerMobile']).", on dated ".$_REQUEST['plannedDate']." Pls available");
				messageSent($numberx,$messagex);                             
			/* Ticket Planned SMS Function Close */
				/* Ticket Planned SMS Function */
					$numberx1=mysql_escape_string($_REQUEST['serviceEngineerMobile']);
					$messagex1=urlencode("Dear ESCA Engineer against Ticket No-".$_REQUEST['ticketId']." (Customer Mob-".mysql_escape_string($_REQUEST['CrNumx']).") allotted for site visit on dated ".$_REQUEST['plannedDate'].". Plan accordingly.");
					messageSent($numberx1,$messagex1);                           
				/* Ticket Planned SMS Function Close */
				$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";
				}else $result=errorMsg('ERRMSG002');	
			}else $result="Enter Service Engineer";
		}
	}
	elseif($_REQUEST['checkStat']=='1' && natureOfActivityGetCode($_REQUEST['natureOfActivity'])=='AT'){
		$a=mysql_escape_string($_REQUEST['noofBanks']);
		$b=mysql_escape_string($_REQUEST['completeobservation']);
		$cd=mysql_escape_string($_REQUEST['fsrNumber']);
		$mfgDate=mysql_escape_string($_REQUEST['mfgDate']);
		$cDate=mysql_escape_string($_REQUEST['cDate']);
		if(empty($_FILES['closedfsrreport']['name'])){$result="Select Closing FSR Report";}
		else{
			if (!empty($_FILES['sitePhotoGraphs']['name']) && $_FILES['sitePhotoGraphs']['type'] == "application/pdf") {
				if ($_FILES["sitePhotoGraphs"]["error"] > 0){$result="Return Code: " . $_FILES["sitePhotoGraphs"]["error"] . "<br>"; }
				else {
					$fileName="spg".nameing($_REQUEST['y']).".pdf";
					$moveSitePhoto = move_uploaded_file($_FILES["sitePhotoGraphs"]["tmp_name"],"reports/sitePhotoGraphs/".$fileName);
					$profileimg = "reports/sitePhotoGraphs/".$fileName;
					if($moveSitePhoto){
						$ac = mysql_query("UPDATE ss_tickets SET sitePhotoGraphs='$profileimg' WHERE id='".$_REQUEST['y'] ."'");
						if($ac)$result="".errorMsg('ERRMSG004')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');	
					}else{$result="Error in uploading files, try again";}
				}
			}
			if ($_FILES['closedfsrreport']['type'] == "application/pdf") {
				if ($_FILES["closedfsrreport"]["error"] > 0){$result="Return Code: " . $_FILES["closedfsrreport"]["error"] . "<br>"; }
				else {
					$fileName="cfsr".nameing($_REQUEST['y']).".pdf";
					$moveCfsr = move_uploaded_file($_FILES["closedfsrreport"]["tmp_name"],"reports/closedfsrreport/".$fileName);
					$profileimg = "reports/closedfsrreport/".$fileName;
					if($moveCfsr){
						$ac = mysql_query("UPDATE ss_tickets SET closedfsrreport='$profileimg' WHERE id='".$_REQUEST['y'] ."'");
						if($ac)$result="".errorMsg('ERRMSG004')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');	
					}else{$result="Error in uploading files, try again";}
				}
			}else{$result="Upload Pdf File";}
			if($a!=""&&$b!=""){
				$ac = mysql_query("UPDATE ss_tickets SET noofBanks='$a', completeobservation='$b',fsrNumber='$cd',mfgDate='$mfgDate', closingDate='$cDate', checkStat='2', ticketStatus='Visited', errorMessage='".ttMsg('3')."' WHERE id='".$_REQUEST['y'] ."'");
				if($ac){
					$result="".errorMsg('ERRMSG004')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";
				}else $result=errorMsg('ERRMSG002');	
			}else $result="Enter All Fields";
		}
	}
	elseif($_REQUEST['checkStat']=='1' && natureOfActivityGetCode($_REQUEST['natureOfActivity'])=='I&C'){
		$a=mysql_escape_string($_REQUEST['noofBanks']);
		$b=mysql_escape_string($_REQUEST['completeobservation']);
		$cd=mysql_escape_string($_REQUEST['fsrNumber']);
		$mfgDate=mysql_escape_string($_REQUEST['mfgDate']);
		$cDate=mysql_escape_string($_REQUEST['cDate']);
		if(empty($_FILES['closedfsrreport']['name'])){$result="Select Closing FSR Report";}
		else{
			if (!empty($_FILES['sitePhotoGraphs']['name']) && $_FILES['sitePhotoGraphs']['type'] == "application/pdf") {
				if ($_FILES["sitePhotoGraphs"]["error"] > 0){$result="Return Code: " . $_FILES["sitePhotoGraphs"]["error"] . "<br>"; }
				else {
					$fileName="spg".nameing($_REQUEST['y']).".pdf";
					$moveSitePhoto = move_uploaded_file($_FILES["sitePhotoGraphs"]["tmp_name"],"reports/sitePhotoGraphs/".$fileName);
					$profileimg = "reports/sitePhotoGraphs/".$fileName;
					if($moveSitePhoto){
						$ac = mysql_query("UPDATE ss_tickets SET sitePhotoGraphs='$profileimg' WHERE id='".$_REQUEST['y'] ."'");
						if($ac)$result="".errorMsg('ERRMSG004')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');	
					}else{$result="Error in uploading files, try again";}
				}
			}
			if ($_FILES['closedfsrreport']['type'] == "application/pdf") {
				if ($_FILES["closedfsrreport"]["error"] > 0){$result="Return Code: " . $_FILES["closedfsrreport"]["error"] . "<br>"; }
				else {
					$fileName="cfsr".nameing($_REQUEST['y']).".pdf";
					$moveCfsr = move_uploaded_file($_FILES["closedfsrreport"]["tmp_name"],"reports/closedfsrreport/".$fileName);
					$profileimg = "reports/closedfsrreport/".$fileName;
					if($moveCfsr){
						$ac = mysql_query("UPDATE ss_tickets SET closedfsrreport='$profileimg' WHERE id='".$_REQUEST['y'] ."'");
						if($ac)$result="".errorMsg('ERRMSG004')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');	
					}else{$result="Error in uploading files, try again";}
				}
			}else{$result="Upload Pdf File";}
			if($a != "" && $b !=""){
				$ac = mysql_query("UPDATE ss_tickets SET noofBanks='$a', completeobservation='$b',fsrNumber='$cd',mfgDate='$mfgDate',closingDate='$cDate', checkStat='2', ticketStatus='Visited', errorMessage='".ttMsg('3')."'  WHERE id='".$_REQUEST['y'] ."'");
				if($ac){
					$result="".errorMsg('ERRMSG004')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";
				}else $result=errorMsg('ERRMSG002');
			}else $result="Enter All Fields";
		}
	}
	elseif($_REQUEST['checkStat']=='1' && natureOfActivityGetCode($_REQUEST['natureOfActivity'])=='WS'){
		$a=mysql_escape_string($_REQUEST['faultcode']);	
		$b=mysql_escape_string($_REQUEST['visitedby']);
		$d=mysql_escape_string($_REQUEST['physicaldamages']);	
		$e=mysql_escape_string($_REQUEST['smpscapacity']);	
		$f=mysql_escape_string($_REQUEST['smpsdisplaycondition']);	
		$g=mysql_escape_string($_REQUEST['noofworkingmodules']);	
		$h=mysql_escape_string($_REQUEST['permodulsrating']);	
		$i=mysql_escape_string($_REQUEST['ebavailabilityperdayaspertechnician']);
		$k=mysql_escape_string($_REQUEST['logbookstatus']);	
		$dga=mysql_escape_string($_REQUEST['dgcapacity']);	
		$dgb=mysql_escape_string($_REQUEST['dgstatus']);	
		$dgc=mysql_escape_string($_REQUEST['dgrunhoursperdayaspertechnician']);
		$dgd=mysql_escape_string($_REQUEST['dgMake']);
		$n=mysql_escape_string($_REQUEST['sitegauardavailability']);	
		$o=mysql_escape_string($_REQUEST['acstatus']);	
		$p=mysql_escape_string($_REQUEST['sitetemperature']);	
		$q=mysql_escape_string($_REQUEST['floatvoltatterminal']);
		$r=mysql_escape_string($_REQUEST['boostvoltage']);	
		$s=mysql_escape_string($_REQUEST['siteload']);	
		$t=mysql_escape_string($_REQUEST['lvdstatus']);
		$u=mysql_escape_string($_REQUEST['lvdsetting']);		
		$w=mysql_escape_string($_REQUEST['nooffaultycells']);
		$w1=mysql_escape_string($_REQUEST['faultyCellSerial']);
		$cd=mysql_escape_string($_REQUEST['fsrNumber']);
		$l1=mysql_escape_string($_REQUEST['smpsIDate']);
		$l3=mysql_escape_string($_REQUEST['mfgDate']);
		$cDate=mysql_escape_string($_REQUEST['cDate']);
		$l45=mysql_escape_string($_REQUEST['visitremark']);
		if($a==""){$result="Select Faulty Code";}
		elseif($b==""){$result="Select Visited Date";}
		elseif($d==""){$result="Select Physical Damages";}
		elseif($e==""){$result="Select SMPS Capacity";}
		elseif($f==""){$result="Select SMPS Display Condition";}
		elseif($f=="Working"&&$r==""){$result="Select Boost Voltage";}
		elseif($f=="Working"&&$u==""){$result="Select LVD Setting";}
		elseif($g==""){$result="Select No of Working Modules";}
		elseif($h==""){$result="Select Per Moduls  Rating";}
		elseif($i==""){$result="Select EB Availability Per Day";}
		elseif($k==""){$result="Select Log book status";}
		elseif($dga==""){$result="Select DG Capacity";}
		elseif($n==""){$result="Select Site Gauard Availability";}
		elseif($o==""){$result="Select AC Status";}
		elseif($p==""){$result="Select Site Temperature";}
		elseif($q==""){$result="Select Float Volt at Terminal";}
		
		elseif($s==""){$result="Select Site Load";}
		elseif($t==""){$result="Select LVD Status";}
		
		elseif($w==""){$result="Select No of Faulty Cells";}
		elseif($l45==""){$result="Select Visit Remarks";}
		elseif(empty($_FILES['visitfsrreport']['name'])){$result="Select Visit FSR Report";}
		else{
			$fileName="vfsr".nameing($_REQUEST['y']).".pdf";
			$moveVfsr = move_uploaded_file($_FILES["visitfsrreport"]["tmp_name"],"reports/visitfsrreport/".$fileName);
			$profileimg = "reports/visitfsrreport/".$fileName;
			if($moveVfsr){
				if(isset($_REQUEST['jobDone']) && $_REQUEST['jobDone']=='2'){
					$replacedCellSerial=mysql_escape_string($_REQUEST['replacedCellSerial']);
					if($replacedCellSerial==""){$result="Enter Replaced Cell Serial";}
					else{ $ac = mysql_query("UPDATE ss_tickets SET dgcapacity='$dga', dgstatus='$dgb', dgrunhoursperdayaspertechnician='$dgc', dgMake='$dgd', faultcode='$a',visitedby='$b',physicaldamages='$d',fsrNumber='$cd',faultyCellSerial='$w1',smpscapacity='$e',smpsdisplaycondition='$f',noofworkingmodules='$g', smpsIDate='$l1', mfgDate='$l3', permodulsrating='$h',ebavailabilityperdayaspertechnician='$i',logbookstatus='$k',sitegauardavailability='$n',acstatus='$o',sitetemperature='$p',floatvoltatterminal='$q',boostvoltage='$r',siteload='$s',lvdstatus='$t',lvdsetting='$u',nooffaultycells='$w',visitfsrreport='$profileimg', ticketStatus='Visited', checkStat='2',visitRemarks='$l45',closingDate='$b',replacedCellSerial='$replacedCellSerial', errorMessage='".ttMsg('3')."' WHERE id='".$_REQUEST['y'] ."'"); }
				}elseif(isset($_REQUEST['jobDone']) && $_REQUEST['jobDone']=='0'){
					$ac = mysql_query("UPDATE ss_tickets SET dgcapacity='$dga', dgstatus='$dgb', dgrunhoursperdayaspertechnician='$dgc', dgMake='$dgd', faultcode='$a',visitedby='$b',physicaldamages='$d',fsrNumber='$cd',faultyCellSerial='$w1',smpscapacity='$e',smpsdisplaycondition='$f',noofworkingmodules='$g', smpsIDate='$l1', mfgDate='$l3', permodulsrating='$h',ebavailabilityperdayaspertechnician='$i',logbookstatus='$k',sitegauardavailability='$n',acstatus='$o',sitetemperature='$p',floatvoltatterminal='$q',boostvoltage='$r',siteload='$s',lvdstatus='$t',lvdsetting='$u',nooffaultycells='$w',visitfsrreport='$profileimg', ticketStatus='Visited', checkStat='2',visitRemarks='$l45',closingDate='$b', errorMessage='".ttMsg('3')."' WHERE id='".$_REQUEST['y'] ."'");
				}
				if(isset($_REQUEST['oldfsrreport']) && $ac){@unlink($_REQUEST['oldfsrreport']);}
				if($ac)$result="".errorMsg('ERRMSG0041')."<script>setTimeout(function(){document.location = 'index.php?x=".$_REQUEST['x']."';},1000); </script>";else $result=errorMsg('ERRMSG002');
			}else{$result="Error in uploading files, try again";}
		}

	}
	elseif(isset($_REQUEST['checkStat'])&& $_REQUEST['checkStat']=='2'){
		if(isset($_REQUEST['fsraccept'])){
			$cvc=mysql_escape_string($_REQUEST['commentsSA']);
			if($cvc==""){$result="Enter Comments";}
			else{
				if($_REQUEST['fsraccept']==0){
					$ac = mysql_query("UPDATE ss_tickets SET checkStat='1',errorMessage='".ttMsg('4')."', errorAdmin='$cvc' WHERE id='".$_REQUEST['y'] ."'");
					if($ac)$result="".errorMsg('ERRMSG005')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
				}
				elseif($_REQUEST['fsraccept']==1 && (natureOfActivityGetCode($_REQUEST['natureOfActivity'])=='AT' || natureOfActivityGetCode($_REQUEST['natureOfActivity'])=='I&C')){
					$tat=tatcheck($_REQUEST['y']);
					$ac = mysql_query("UPDATE ss_tickets SET checkStat='5',errorMessage='".ttMsg('9')."',closingDate='".date('Y-m-d H:i:s')."', tat='$tat', ticketStatus='Closed', errorAdmin='$cvc', mailStat='1' WHERE id='".$_REQUEST['y'] ."'");
					if($ac){
					/* Ticket closed SMS Function */
						$numberx=mysql_escape_string($_REQUEST['CrNumx']);
						$cDate=cdate($_REQUEST['y']);
						$messagex=urlencode("Dear Customer your Ticket No-".$_REQUEST['ticketId']." is closed on Dt-".$cDate.".For feedback contact 040-67046704");
						messageSent($numberx,$messagex);                           
					/* Ticket closed SMS Function Close */
					$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";
					}else $result=errorMsg('ERRMSG002');
				}
				elseif($_REQUEST['fsraccept']==1 && $_REQUEST['tReq']==1){
					$ac = mysql_query("UPDATE ss_tickets SET checkStat='3',errorMessage='".ttMsg('6')."', errorAdmin='$cvc' WHERE id='".$_REQUEST['y'] ."'");
					if($ac)$result="".errorMsg('ERRMSG006')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
				}
				/*elseif($_REQUEST['fsraccept']==1 && $_REQUEST['tReq']==0){
					$ac = mysql_query("UPDATE ss_tickets SET checkStat='4',errorMessage='".ttMsg('5')."', errorAdmin='$cvc' WHERE id='".$_REQUEST['y'] ."'");
					if($ac)$result="".errorMsg('ERRMSG007')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
				}*/
				elseif($_REQUEST['fsraccept']==1 && $_REQUEST['tReq']==2){
						$tat=tatcheck($_REQUEST['y']);
						$cDate=date('Y-m-d H:i:s');
						$ac = mysql_query("UPDATE ss_tickets SET checkStat='5',errorMessage='".ttMsg('9')."', closingDate='$cDate', ticketStatus='Closed', tat='$tat', errorAdmin='$cvc', mailStat='1' WHERE id='".$_REQUEST['y'] ."'");
					if($ac){
					/* Ticket closed SMS Function */
						$numberx=mysql_escape_string($_REQUEST['CrNumx']);
						$cDate=cdate($_REQUEST['y']);
						$messagex=urlencode("Dear Customer your Ticket No-".$_REQUEST['ticketId']." is closed on Dt-".$cDate.".For feedback contact 040-67046704");
						messageSent($numberx,$messagex);                            
					/* Ticket closed SMS Function Close */
					$result="".errorMsg('ERRMSG007')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";
					}else $result=errorMsg('ERRMSG002');
				}
			}
		}
	}
	elseif(isset($_REQUEST['checkStat'])&& $_REQUEST['checkStat']=='3' && natureOfActivityGetCode($_REQUEST['natureOfActivity'])=='WS'){
		if(isset($_REQUEST['fsraccept2'])){
			$cvc=mysql_escape_string($_REQUEST['commentsTE']);
			if($_REQUEST['fsraccept2']==0){
				$ac = mysql_query("UPDATE ss_tickets SET checkStat='5' ,errorMessage='".ttMsg('9')."', closingDate='".date('Y-m-d H:i:s')."',ticketStatus='Reject', tat='".tatcheck($_REQUEST['y'])."', errorTechnical='$cvc', mailStat='1' WHERE id='".$_REQUEST['y'] ."'");
			if($ac){
				/* Ticket closed SMS Function */
					$numberx=mysql_escape_string($_REQUEST['CrNumx']);
					$cDate=cdate($_REQUEST['y']);
					$messagex=urlencode("Dear Customer your Ticket No-".$_REQUEST['ticketId']." is closed on Dt-".$cDate.".For feedback contact 040-67046704");
					messageSent($numberx,$messagex);                            
				/* Ticket closed SMS Function Close */
				$result="".errorMsg('ERRMSG009')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";
			}else $result=errorMsg('ERRMSG002');
			}
			if($_REQUEST['fsraccept2']==1){
				$ac = mysql_query("UPDATE ss_tickets SET checkStat='4',errorMessage='".ttMsg('8')."', errorTechnical='$cvc' WHERE id='".$_REQUEST['y'] ."'");
				if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
			}
		}
	}
	elseif(isset($_REQUEST['checkStat'])&& $_REQUEST['checkStat']=='4' && natureOfActivityGetCode($_REQUEST['natureOfActivity'])=='WS'){
		if(!isset($_REQUEST['completeobservation']) || $_REQUEST['completeobservation']==""){$result="Enter Closing Remarks";}
		elseif(empty($_FILES['closedfsrreport']['name'])){$result="Select Closing FSR Report";}
		else{
			$cd=mysql_escape_string($_REQUEST['fsrNumber']);
			$w2=mysql_escape_string($_REQUEST['replacedCellSerial']);
			$sjo=mysql_escape_string($_REQUEST['sjoNumber']);
			$cvc=mysql_escape_string($_REQUEST['completeobservation']);
			$cDate=mysql_escape_string($_REQUEST['cDate']);

			if ($_FILES['closedfsrreport']['type'] == "application/pdf") {
				if ($_FILES["closedfsrreport"]["error"] > 0){$result="Return Code: " . $_FILES["closedfsrreport"]["error"] . "<br>"; }
				else {
					$fileName="cfsr".nameing($_REQUEST['y']).".pdf";
					$moveCfsr = move_uploaded_file($_FILES["closedfsrreport"]["tmp_name"],"reports/closedfsrreport/".$fileName);
					$profileimg = "reports/closedfsrreport/".$fileName;
					$tat=tatcheck($_REQUEST['y']);
					if($moveCfsr){
						$ac = mysql_query("UPDATE ss_tickets SET closedfsrreport='$profileimg',replacedCellSerial='$w2',SJONumber='$sjo',completeobservation='$cvc', ticketStatus='Closed',closefsrNumber='$cd', checkStat='5', tat='$tat',errorMessage='".ttMsg('9')."', closingDate='$cDate', mailStat='1' WHERE id='".$_REQUEST['y']."'");
						if($ac){
						/* Ticket closed SMS Function */
						$numberx=mysql_escape_string($_REQUEST['CrNumx']);
						$cDate=cdate($_REQUEST['y']);
						$messagex=urlencode("Dear Customer your Ticket No-".$_REQUEST['ticketId']." is closed on Dt-".$cDate.".For feedback contact 040-67046704");
						messageSent($numberx,$messagex);                           
						/* Ticket closed SMS Function Close */
							$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";
						}else $result=errorMsg('ERRMSG002');
					}else{$result="Error in uploading files, try again";}
				}
			}else{$result="Upload Pdf File";}
		}
	}
}

$tb= menuName($_REQUEST['x'],"tbName");
$query = mysql_query("SELECT colName,colRef FROM ss_col_ref WHERE tbName='$tb' AND pView='0' ORDER BY ordering");
if(mysql_num_rows($query)>0){while($row=mysql_fetch_array($query)){$colName[]=$row['colName'];$colref[]=$row['colRef'];}}
$queryx=mysql_query("SELECT * FROM $tb WHERE id='$_REQUEST[y]'");
while($rowx=mysql_fetch_array($queryx)){for($cx=0;$cx<count($colref);$cx++){if($rowx[$colName[$cx]]!="")$outpot.="<div class='col-md-4 form-group'><label>".$colref[$cx]."</label><p readonly='readonly' class='form-control' style='margin:0;height:auto;max-height:55px;word-wrap:break-word;overflow:auto;'>".refname($colref[$cx],$rowx[$colName[$cx]],$rowx['id'])."</p></div>";}}
$query=mysql_query("SELECT * FROM ss_tickets WHERE id='".$_REQUEST['y'] ."'");
$row = mysql_fetch_array($query);
?>

<p class="errorP">
  <?php if(isset($result)){echo $result;}?>
</p>
<form role="form" class="ss_form" method="POST" name="myform" action="" enctype="multipart/form-data" id="defaultForm">
  <input name="y" value="<?php echo $_REQUEST['y'];?>" type="hidden"/>
  <input name="ticketId" value="<?php echo $row['ticketId'];?>" type="hidden"/>
  <input name="CrNumx" value="<?php echo $row['customerNumber'];?>" type="hidden"/>
  <input name="x" value="<?php echo $_REQUEST['x'];?>" type="hidden"/>
  <input name="checkStat" value="<?php echo $row['checkStat'];?>" type="hidden"/>
  <input name="natureOfActivity" value="<?php echo $row['natureOfActivity'];?>" type="hidden"/>
  <input id="circle" value="<?php echo $row['circle'];?>" type="hidden"/>
  <?php
$lr=loginDetails($_SESSION['login_user'],"empId");
$degQuery=mysql_query("SELECT designation FROM ss_employee_details WHERE employeeId='$lr'");
if(mysql_num_rows($degQuery)>0){
	$degRow=mysql_fetch_array($degQuery); 
/****Dislplay For  ZONAL TEAM****/
	if($degRow['designation']==designationGetId('ZONAL TEAM')){?>
  <?php if(isset($outpot)&& $outpot!=""){echo $outpot;}?>
  <?php /*?>***Rejecting of false ticket***<?php */?>
  <?php if($row['checkStat']=='2' && $row['ticketStatus']=='Reject'){?>
  <div class="col-md-4 form-group">
    <label style="display:block">Reject : </label>
	<input type='hidden' name="cDate" value="<?php  if(isset($row['visitedby'])&& $row['visitedby']!= "0000-00-00")echo $row['visitedby'];else echo date('Y-m-d H:i:s'); ?>" />
    <select name="frej" class="form-control">
      <option value="1">Accept Rejection</option>
      <option value="0">Cancel Rejection</option>
    </select>
  </div>
  <div class="col-md-4 form-group">
    <label style="display:block">Remarks :</label>
    <input tabindex="11" type="text" class="form-control" name="falset" />
    <br/>
  </div>
  <?php }?>
  <?php /*?>***Rejecting of false ticket***<?php */?>
  <?php /*?>***CIRCLE Verification for WS Tickets***<?php */?>
  <?php if($row['checkStat']=='2'&& $row['ticketStatus']=='Visited'){?>
  <div class="col-md-4 form-group">
    <label>Accept The Visiting FSR :</label>
    <select name="fsraccept" data='tReq' class="form-control" onchange="setSelectBoxByText(this.getAttribute('data'), this.options[this.selectedIndex].text);">
      <option value="" >(Select)</option>
      <option value="1">Accept</option>
      <option value="0">Reject</option>
    </select>
  </div>
  <?php if(natureOfActivityGetCode($row['natureOfActivity'])=='WS'){?>
  <div id="hideNHS">
  <div class="col-md-4 form-group">
    <label>NHS Approval :</label>
    <select name="tReq" id="tReq" class="form-control">
      <option value="1">Required</option>
      <!--<option value="0">Not Required</option>-->
      <option value="2">Close Ticket</option>
    </select>
  </div>
  </div>
  <?php } ?>
  <div class="col-md-4 form-group">
    <label>Comments : </label>
    <textarea name="commentsSA" class="form-control"></textarea>
  </div>
  <?php }?>
  <span class="ui-autocomplete-loading"></span>
  <p class="col-md-6 form-group" id="rejid"></p>
  <div class="form-group col-xs-12 morpad">
    <div class="col-xs-12">
      <?php if($row['checkStat']=='2' && $row['ticketStatus']=='Reject'){?>
      <button tabindex="44" type="submit" class="btn btn-primary ss_buttons" name="closett">Submit</button>
      <button tabindex="45" type="button" class="btn btn-primary ss_buttons" name="reset" onClick="window.location.reload(true);">Reset</button>
      <?php }?>
      <?php if(($row['ticketStatus']=='Open' && $row['checkStat']<'3') || ($row['ticketStatus']=='Open' && $row['ticketType']=='Inactive') || $row['checkStat']=='2'&& $row['ticketStatus']=='Visited'){?>
      <button tabindex="44" type="submit" class="btn btn-primary ss_buttons" name="update">Update</button>
      <?php if($row['ticketStatus']=='Open' && $row['checkStat']<='2'){?>
      <button tabindex="46" type="button" class="btn btn-primary ss_buttons addrej" name="Reject">Reject</button>
      <?php }?>
      <button tabindex="45" type="button" class="btn btn-primary ss_buttons" name="reset" onClick="window.location.reload(true);">Reset</button>
      <?php }?>
    </div>
  </div>
  <?php /*?>***CIRCLE Verification for WS Tickets***<?php */?>
  <?php /*?>***Dislplay For  ZONAL TEAM Ends***<?php */?>
  <?php /*?>***Dislplay For  NATIONAL HEAD SERVICE***<?php */?>
  <?php }elseif($degRow['designation']==designationGetId('NATIONAL HEAD SERVICE')){?>
  <?php if(isset($outpot)&& $outpot!=""){echo $outpot;}?>
  <?php /*?>***TECHNICAL Verification for WS Tickets***<?php */?>
  <?php if($row['checkStat']=='3'&& natureOfActivityGetCode($row['natureOfActivity'])=='WS'){?>
  <div class="col-md-4 form-group">
    <label>Accept The Visiting FSR :</label>
    <select tabindex="42" class="form-control" name="fsraccept2">
      <option value="1">Accept</option>
      <option value="0">Reject</option>
    </select>
  </div>
  <div class="col-md-4 form-group">
    <label>Comments :</label>
    <textarea tabindex="43" class="form-control" name="commentsTE" ></textarea>
  </div>
  <span class="ui-autocomplete-loading"></span>
  <p class="col-md-6 form-group" id="rejid"></p>
  <div class="form-group col-xs-12 morpad">
    <div class="col-xs-12">
      <button tabindex="44" type="submit" class="btn btn-primary ss_buttons" name="update">Submit</button>
      <button tabindex="45" type="button" class="btn btn-primary ss_buttons" name="reset" onClick="window.location.reload(true);">Reset</button>
    </div>
  </div>
  <?php }?>
  <?php /*?>***TECHNICAL Verification for WS Tickets***<?php */?>
  <?php /*?>***Dislplay For  NATIONAL HEAD SERVICE***<?php */?>
  <?php /*?>***Dislplay For  General Logins***<?php */?>
  <?php }else{ ?>
  <?php /*?>***Services Engineer***<?php */?>
  <?php if($row['ticketStatus']=='Open' && $row['ticketType']=='Inactive'){?>
  <div class="col-md-4 form-group falhid">
    <label>Planned Date : </label>
    <input name="plannedDate" type='text' class="form-control plannedDate" required="required" placeholder="YYYY-MM-DD" tabindex="1" contenteditable="false" value="<?php  if(isset($row['plannedDate'])&& $row['plannedDate']!= "0000-00-00")echo $row['plannedDate'];else echo date('Y-m-d'); ?>"/>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>Service Engineer : </label>
    <input tabindex="2" autofocus="autofocus" class="form-control" type="text" name="serviceEngineer" placeholder="Engineer Name"/>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>Service Engineer Mobile : </label>
    <input tabindex="3" class="form-control" type="text" name="serviceEngineerMobile" placeholder="Contact Number"/>
  </div>
  <?php }?>
  <?php /*?>***Services Engineer***<?php */?>
  <?php if(isset($outpot)&& $outpot!=""){echo $outpot;}?>
  <?php /*?>***AT***<?php */?>
  <?php if($row['checkStat']=='1'&& natureOfActivityGetCode($row['natureOfActivity'])=='AT'){?>
  <div class="col-md-4 form-group falhid">
    <label>Manufactured Date : </label>
    <input type='text' name="mfgDate" class="form-control" id="mfgDate" placeholder="YYYY-MM-DD" tabindex="7" value="<?php  if(isset($row['mfgDate'])&& $row['mfgDate']!= "0000-00-00")echo $row['mfgDate'];else echo date('Y-m-d'); ?>" />
  </div>
  <div class="col-md-4 form-group falhid">
    <label>Closing Date : </label>
    <input name="cDate" type='text' class="form-control singleDateTimeEnd" required="required" placeholder="YYYY-MM-DD" tabindex="8" contenteditable="false" value="<?php if(isset($row['closingDate'])){echo $row['closingDate'];}else{ echo date('Y-m-d H:i:s');} ?>" />
  </div>
  <div class="col-md-4 form-group falhid">
    <label>No of Banks : </label>
    <select tabindex="9" class="form-control" name="noofBanks">
      <option value="" >(Select No of Banks)</option>
      <?php for($i=1;$i<=5;$i++){ echo "<option ";if($row['noofBanks']!="")echo checkstate($row['noofBanks'],$i); echo " value='".$i."'>".$i."</option>"; } ?>
    </select>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>Site Photo Graphs Upload : </label>
    <input tabindex="10" class="form-control" type="file" name="sitePhotoGraphs"/>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>FSR Number : </label>
    <input tabindex="11" class="form-control" type="text" id="fsrNumber" name="fsrNumber"value="<?php echo $row['fsrNumber']; ?>"/>
  <small id="fsrNumberError" class="help-block" style="color:#a94442;"></small>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>FSR Report Upload : </label>
    <input tabindex="12" class="form-control" type="file" name="closedfsrreport"/>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>Closing Remarks : </label>
    <textarea tabindex="13" class="form-control" name="completeobservation"><?php echo $row['completeobservation']; ?></textarea>
  </div>
  <?php }?>
  <?php /*?>***AT***<?php */?>
  <?php /*?>***I&C***<?php */?>
  <?php if($row['checkStat']=='1'&& natureOfActivityGetCode($row['natureOfActivity'])=='I&C'){?>
  <div class="col-md-4 form-group falhid">
    <label>Manufactured Date : </label>
    <input type='text' name="mfgDate" class="form-control" id="mfgDate" placeholder="YYYY-MM-DD" tabindex="10" value="<?php  if(isset($row['mfgDate'])&& $row['mfgDate']!= "0000-00-00")echo $row['mfgDate'];else echo date('Y-m-d'); ?>" />
  </div>
  <div class="col-md-4 form-group falhid">
    <label>Closing Date : </label>
    <input name="cDate" type='text' class="form-control singleDateTimeEnd" required="required" placeholder="YYYY-MM-DD" tabindex="11" contenteditable="false"  value="<?php if(isset($row['closingDate'])){echo $row['closingDate'];}else{ echo date('Y-m-d H:i:s');} ?>" />
  </div>
  <div class="col-md-4 form-group falhid">
    <label>No of Banks : </label>
    <select tabindex="12" class="form-control" name="noofBanks">
      <option value="" >(Select No of Banks)</option>
      <?php for($i=1;$i<=5;$i++){ echo "<option ";if($row['noofBanks']!="")echo checkstate($row['noofBanks'],$i); echo " value='".$i."'>".$i."</option>"; } ?>
    </select>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>Closing Remarks : </label>
    <textarea tabindex="13" class="form-control" name="completeobservation"><?php echo $row['completeobservation']; ?></textarea>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>Site Photo Graphs Upload : </label>
    <input tabindex="14" class="form-control" type="file" name="sitePhotoGraphs"/>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>FSR Number : </label>
    <input tabindex="15" class="form-control" type="text" id="fsrNumber" name="fsrNumber" value="<?php echo $row['fsrNumber']; ?>"/>
  <small id="fsrNumberError" class="help-block" style="color:#a94442;"></small>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>FSR Report Upload : </label>
    <input tabindex="16" class="form-control" type="file" name="closedfsrreport"/>
  </div>
  <?php }?>
  <?php /*?>***I&C***<?php */?>
  <?php /*?>***WS visiting***<?php */?>
  <?php if($row['checkStat']=='1'&& natureOfActivityGetCode($row['natureOfActivity'])=='WS'){?>
  <div class="col-md-4 form-group falhid">
    <label>Fault Description : </label>
    <select tabindex="13" class="form-control" name="faultcode">
      <option value="" >(Select Fault Description)</option>
      <?php if($row['faultcode']!="")echo "<option selected='selected' value='$row[faultcode]'>".faultyCodeGetName($row['faultcode'])."</option>";?>
      <?php faultyCodeGetOption();?>
    </select>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>Visited On : </label>
    <input name="visitedby" type='text' class="form-control singleDateEnd" required="required" placeholder="YYYY-MM-DD" tabindex="14" contenteditable="false" value="<?php echo date('Y-m-d'); ?>" />
  </div>
  <div class="col-md-4 form-group falhid">
    <label>Manufactured Date : </label>
    <input type='text' name="mfgDate" class="form-control" id="mfgDate" placeholder="YYYY-MM-DD" tabindex="14" value="<?php  if(isset($row['mfgDate'])&& $row['mfgDate']!= "0000-00-00")echo $row['mfgDate'];else echo date('Y-m-d'); ?>" />
    <input type="hidden" value="<?php echo warrantyMonths($row['siteId']); ?>" id="warrantyMonths"/>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>Warranty Left : </label>
    <input type='text' class="form-control" id="warrantyLeft" tabindex="15" value="<?php echo warrantyLeft($row['siteId'],$row['mfgDate']); ?>" readonly />
  </div>
  <div class="col-md-4 form-group falhid">
    <label>Physical damages : </label>
    <select tabindex="16" class="form-control" name="physicaldamages">
      <option value="" >(Select Physical damages)</option>
      <option <?php if($row['physicaldamages']!="")echo checkstate($row['physicaldamages'],'Damaged'); ?>value="Damaged">Damaged</option>
      <option value="Not damaged" <?php if($row['physicaldamages']!="")echo checkstate($row['physicaldamages'],'Not damaged'); ?>>Not damaged</option>
    </select>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>SMPS Capacity : </label>
    <select tabindex="17" class="form-control" name="smpscapacity">
      <option value="" >(Select SMPS Capacity)</option>
      <?php if($row['smpscapacity']!="")echo "<option selected='selected' value='$row[smpscapacity]'>".smpsGetName($row['smpscapacity'])."</option>";?>
      <?php smpsRatingOption();  ?>
    </select>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>SMPS Installation Date : </label>
    <input type='text' name="smpsIDate" class="form-control singleDateEnd" placeholder="YYYY-MM-DD" tabindex="17" value="<?php  if(isset($row['smpsIDate'])&& $row['smpsIDate']!= "0000-00-00")echo $row['smpsIDate'];else echo date('Y-m-d'); ?>" />
  </div>
  <div class="col-md-4 form-group falhid">
    <label>SMPS Display : </label>
    <select tabindex="18" class="form-control smpsdisplaycondition" onchange="smpsdisplay(this.options[this.selectedIndex].value)" id="smpsdisplaycondition" name="smpsdisplaycondition">
      <option value="" >(Select SMPS Display)</option>
      <option <?php echo checkstate($row['smpsdisplaycondition'],'Working');?> value="Working">Working</option	>
      <option <?php echo checkstate($row['smpsdisplaycondition'],'Not Working');?> value="Not Working">Not Working</option	>
    </select>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>No of Working Modules : </label>
    <select tabindex="19" class="form-control" name="noofworkingmodules">
      <option value="" >(Select No of Working Modules)</option>
      <?php for($i=1;$i<=6;$i++){ echo "<option ";if($row['noofworkingmodules']!="")echo checkstate($row['noofworkingmodules'],$i); echo " value='".$i."'>".$i."</option>"; } ?>
    </select>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>Per Moduls Rating(Amps) : </label>
    <input tabindex="20" class="form-control" type="text"  value="<?php  echo $row['permodulsrating']; ?>" name="permodulsrating"/>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>EB Availability Per day : </label>
    <select tabindex="21" class="form-control" name="ebavailabilityperdayaspertechnician">
      <option value="" >(Select EB Availability)</option>
      <option value="NON EB" <?php echo checkstate($row['ebavailabilityperdayaspertechnician'],'NON EB');?> >NON EB</option>
      <?php for($i=1;$i<=24;$i++){ echo "<option ";echo checkstate($row['ebavailabilityperdayaspertechnician'],$i); echo " value='".$i."'>".$i." Hrs.</option>"; }?>
    </select>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>Log book status : </label>
    <select tabindex="22" class="form-control" name="logbookstatus">
      <option value="" >(Select Log book status)</option>
      <option value="Available" <?php echo checkstate($row['logbookstatus'],'Available');?>>Available</option>
      <option value="Not Available" <?php echo checkstate($row['logbookstatus'],'Not Available');?> >Not Available</option>
    </select>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>DG Capacity : </label>
    <select tabindex="23" class="form-control dgCap" name="dgcapacity">
      <option value="" >(Select DG Capacity)</option>
      <?php for($i=10;$i<=60;$i+=5){ echo "<option ";echo checkstate($row['dgcapacity'],$i); echo " value='".$i."'>".$i."</option>"; } ?>
      <option value="NON DG" <?php echo checkstate($row['logbookstatus'],'NON DG');?> >NON DG</option>
    </select>
  </div>
  <div class="col-md-4 form-group falhid dgHide">
    <label>DG Make : </label>
    <input type='text' name="dgMake" class="form-control" tabindex="24" value="<?php echo $row['dgMake'];?>" />
  </div>
  <div class="col-md-4 form-group falhid dgHide">
    <label>DG Status : </label>
    <select tabindex="25" class="form-control" name="dgstatus">
      <option value="" >(Select DG Status)</option>
      <option value="Auto" <?php echo checkstate($row['dgstatus'],'Auto');?> >Auto</option>
      <option value="Manual" <?php echo checkstate($row['dgstatus'],'Manual');?> >Manual</option>
      <option value="Working" <?php echo checkstate($row['dgstatus'],'Working');?> >Working</option>
      <option value="Not Working" <?php echo checkstate($row['dgstatus'],'Not Working');?> >Not Working</option>
    </select>
  </div>
  <div class="col-md-4 form-group falhid dgHide">
    <label>DG Run Hours Per Day : </label>
    <select tabindex="25" class="form-control" name="dgrunhoursperdayaspertechnician">
      <option value="" selected>(Select DG Run Hours)</option>
      <?php for($i=0;$i<=24;$i++){ echo "<option ";echo checkstate($row['dgrunhoursperdayaspertechnician'],$i); echo " value='".$i."'>".$i." Hrs.</option>"; } ?>
    </select>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>Site Gauard Availability : </label>
    <select tabindex="26" class="form-control" name="sitegauardavailability">
      <option value="" >(Select Site Gauard Availability)</option>
      <option value="Yes" <?php echo checkstate($row['sitegauardavailability'],'Yes');?> >Yes</option>
      <option value="No" <?php echo checkstate($row['sitegauardavailability'],'No');?> >No</option>
    </select>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>AC Status : </label>
    <select tabindex="27" class="form-control" name="acstatus">
      <option value="" >(Select AC Status)</option>
      <option value="Working" <?php echo checkstate($row['acstatus'],'Working');?> >Working</option>
      <option value="NotWorking" <?php echo checkstate($row['acstatus'],'NotWorking');?> >NotWorking</option>
      <option value="OD Sites" <?php echo checkstate($row['acstatus'],'OD Sites');?> >OD Sites</option>
      <option value="AC Not Available" <?php echo checkstate($row['acstatus'],'AC Not Available');?> >AC Not Available</option>
    </select>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>Site Temperature(In degrees) : </label>
    <input tabindex="28" class="form-control" type="text" name="sitetemperature" value="<?php  echo $row['sitetemperature']; ?>" />
  </div>
  <div class="col-md-4 form-group falhid">
    <label>Float Volt at Terminal(Volts) : </label>
    <input tabindex="29" class="form-control" type="text" name="floatvoltatterminal" value="<?php  echo $row['floatvoltatterminal']; ?>"  />
  </div>
  <div class="col-md-4 form-group falhid">
    <label>Boost Voltage(Volts) : </label>
    <input tabindex="30" class="form-control" type="text" id="boostvoltage" name="boostvoltage" value="<?php  echo $row['boostvoltage']; ?>" />
  </div>
  <div class="col-md-4 form-group falhid">
    <label>Site Load(AMPS) : </label>
    <input tabindex="31" class="form-control" type="text" name="siteload" value="<?php  echo $row['siteload']; ?>" />
  </div>
  <div class="col-md-4 form-group falhid">
    <label>LVD Status : </label>
    <select tabindex="32" class="form-control" name="lvdstatus">
      <option value="" >(Select LVD Status)</option>
      <option value="Closed" <?php echo checkstate($row['lvdstatus'],'Closed');?> >Closed</option>
      <option value="Bypass" <?php echo checkstate($row['lvdstatus'],'Bypass');?> >Bypass</option>
    </select>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>LVD Setting(Volts) : </label>
    <input tabindex="33" class="form-control" type="text" id="lvdsetting" name="lvdsetting" value="<?php  echo $row['lvdsetting']; ?>" />
  </div>
  <div class="col-md-4 form-group falhid">
    <label>Item Code : </label>
    <select tabindex="33" class="form-control" id="itemCode" name="itemCode">
      <option value="">(Select Item Code)</option>
      <?php	$query2 = mysql_query("SELECT * FROM ss_item_code WHERE flag='0'");
			if(mysql_num_rows($query2)>0){
				while($row2=mysql_fetch_array($query2)){echo "<option value='$row2[itemCode]'>$row2[itemDesc]</option>";}
			}else{echo "<option value=''>Add Item first</option>";}
      ?>
    </select>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>Item Status : </label>
    <input tabindex="33" class="form-control" type="text" id="itemStatus" name="" readonly/>
  </div>
  <div class="col-md-4 form-group falhid">
    <label>No of Faulty Cells : </label>
    <input tabindex="34" class="form-control" type="text" name="nooffaultycells" value="<?php  echo $row['nooffaultycells']; ?>" />
  </div>
  <div class="col-md-4 form-group falhid">
    <label>Faulty Cell Serial : </label>
    <input tabindex="35" class="form-control" type="text" name="faultyCellSerial" value="<?php  echo $row['faultyCellSerial']; ?>" />
  </div>
  <div class="col-md-4 form-group falhid">
    <label>FSR Number : </label>
    <input tabindex="36" class="form-control" type="text" id="fsrNumber" name="fsrNumber" value="<?php  echo $row['fsrNumber']; ?>" />
  <small id="fsrNumberError" class="help-block" style="color:#a94442;"></small>
  </div>
  <?php if($row['visitfsrreport']!=""){?>
  <div class="col-md-4 form-group">
    <label>Old FSR Report</label>
    <p><a href="<?php  echo $row['visitfsrreport']; ?>" target="_blank" style='color:red !important;'>Click Here</a></p>
  </div>
  <input type="hidden" name="oldfsrreport" value="<?php  echo $row['visitfsrreport']; ?>"/>
  <?php }?>
  <div class="col-md-4 form-group falhid">
    <label>Visit FSR Report Upload : </label>
    <input tabindex="37" class="form-control" type="file" name="visitfsrreport"/>
  </div> 
  <div class="col-md-4 form-group">
    <label>Job Done:</label>
    <select tabindex="37" name="jobDone" class="form-control" onchange="extraCloseField(this.options[this.selectedIndex].value)">
      <option value="">Job Done Select</option>
	  <option value="0">Site Visited</option>
      <option value="2">Site Closed</option>
    </select>
  </div>
  <span class="cst"></span>
  <div class="col-md-4 form-group">
    <label>Visit Remarks: </label>
    <textarea tabindex="38" class="form-control" name="visitremark"></textarea>
  </div>
  <?php }?>
  <?php /*?>***WS visiting***<?php */?>
  <?php /*?>***WS Closing***<?php */?>
  <?php if($row['checkStat']=='4'&& natureOfActivityGetCode($row['natureOfActivity'])=='WS'){?>
  <div class="col-md-4 form-group">
    <label>Closing Date : </label>
    <input name="cDate" type='text' class="form-control singleDateTimeEnd" required="required" placeholder="YYYY-MM-DD" tabindex="38" contenteditable="false" value="<?php echo date('Y-m-d H:i:s'); ?>" />
  </div>
  <div class="col-md-4 form-group">
    <label>Closed FSR Number : </label>
    <input tabindex="39" class="form-control" type="text" name="fsrNumber" value="<?php  echo $row['closefsrNumber']; ?>" />
  </div>
  <div class="col-md-4 form-group">
    <label>Replaced Cell Serial : </label>
    <input tabindex="40" class="form-control" type="text" name="replacedCellSerial" value="<?php  echo $row['replacedCellSerial']; ?>" />
  </div>
  <?php if(loginDetails($_SESSION['login_user'],"role")=='CO912'){ ?>
  <div class="col-md-4 form-group">
    <label>SJO Number :</label>
    <input type="text" tabindex="40" class="form-control" name="sjoNumber" />
  </div>
  <?php } ?>
  <div class="col-md-4 form-group">
    <label>Closed FSR Report Upload : </label>
    <input tabindex="41" class="form-control" type="file" name="closedfsrreport"/>
  </div>
  <div class="col-md-4 form-group">
    <label>Closing Remarks: </label>
    <textarea tabindex="38" class="form-control" name="completeobservation"></textarea>
  </div>
  <?php }?>
  <?php /*?>***WS Closing***<?php */?>
  <span class="ui-autocomplete-loading"></span>
  <p class="col-md-6 form-group" id="rejid"></p>
  <div class="form-group col-xs-12 morpad">
    <div class="col-xs-12">
      <button tabindex="44" type="submit" class="btn btn-primary ss_buttons" name="update">Update</button>
      <?php if($row['ticketStatus']=='Open' && $row['checkStat']<='2'){?>
      <button tabindex="46" type="button" class="btn btn-primary ss_buttons addrej" name="Reject">Reject</button>
      <?php }?>
      <button tabindex="45" type="button" class="btn btn-primary ss_buttons" name="reset" onClick="window.location.reload(true);">Reset</button>
    </div>
  </div>
  <?php /*?>***Dislplay For  General Logins***<?php */?>
  <?php }?>
  <?php }?>
</form>
<?php
function warrantyMonths($f1){
	$sql = mysql_query("SELECT warrantyMonths FROM ss_site_master WHERE siteId='$f1'");
	$r = mysql_fetch_array($sql);
	return $r['warrantyMonths'];
	}
function warrantyLeft($f1,$f2){
	date_default_timezone_set("Asia/Kolkata");
	$diff = abs(strtotime(date('Y-m-d')) - strtotime($f2));
	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$f4 =  warrantyMonths($f1) - $months;
	if($f4 > 0){ echo $f4." Months"; }else{ echo "Out Of Warranty"; }
}
?>
