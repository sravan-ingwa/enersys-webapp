<?php 
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['import'])){
	if(isset($_FILES["file"])){ //if there was an error uploading the file
	if($_FILES["file"]["error"]>0){$result = "No file selected";}
		else{ $extn = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		if($extn=='xlsx' || $extn=='xls' ){
		set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
		include 'PHPExcel/IOFactory.php';
		// This is the file path to be uploaded.
		$inputFileName = $_FILES["file"]["tmp_name"];
		try { $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);}
		catch(Exception $e){die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage()); }
		$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
		$already = array(); $wrongData = array(); $NOS = array('1','2','3','4','5');
		for($i=2;$i<=$arrayCount;$i++){
			$zone = textToCodeReplace(trim($allDataInSheet[$i]["A"]),'ss_zone','zone'); // id ss_zone
			$circle = textToCodeReplace(trim($allDataInSheet[$i]["B"]),'ss_circles','circle'); // id ss_circles
			$cluster = textToCodeReplace(trim($allDataInSheet[$i]["C"]),'ss_clusters','cluster'); // id ss_clusters
			$district = textToCodeReplace(trim($allDataInSheet[$i]["D"]),'ss_districts','district'); // id ss_districts
			$customerCategory = textToCodeReplace(trim($allDataInSheet[$i]["E"]),'ss_customer_category','category'); // id ss_customer_category
			$customerCode = textToCodeReplace(trim($allDataInSheet[$i]["F"]),'ss_customer_details','customerCode'); // id ss_customer_details
			$siteType = trim($allDataInSheet[$i]["G"]); // name
			$siteID = trim($allDataInSheet[$i]["H"]); // name
			$siteName = trim($allDataInSheet[$i]["I"]); // name
			$siteAddress = trim($allDataInSheet[$i]["J"]); // name
			$mfdDate = trim($allDataInSheet[$i]["K"]); // name
			$installDate = trim($allDataInSheet[$i]["L"]); // name
			$productCode = textToCodeReplace(trim($allDataInSheet[$i]["M"]),'ss_product_details','productCode'); // id ss_product_details
			$noOfString = (in_array(trim($allDataInSheet[$i]["N"]),$NOS) ? trim($allDataInSheet[$i]["N"]) : ''); // name for($ns=1;$ns<=5;$ns++){echo "<option value='$ns'>$ns</option>";}
			$customerName = trim($allDataInSheet[$i]["O"]); // name
			$customerNumber = trim($allDataInSheet[$i]["P"]); // name
			$clusterManagerName = trim($allDataInSheet[$i]["Q"]); // name
			$clusterManagerNumber = trim($allDataInSheet[$i]["R"]); // name
			$clusterManagerMail = trim($allDataInSheet[$i]["S"]); // name
			$scheduleDays = schedule(trim($allDataInSheet[$i]["F"])); // select schedule from  ss_customer_details where id='' AND flag='0'
			
			$warrantyMonths = warranty($customerCode,$mfdDate,$installDate,'warr'); // 
			$siteStatus = warranty($customerCode,$mfdDate,$installDate,'status'); // name OutOfWarranty
			
			$sql = mysql_query("SELECT siteID FROM ss_site_master WHERE siteID='$siteID' AND flag=0");
			if(mysql_num_rows($sql)==0){ $id = checkx(rand(0000, 9999),'ss_site_master');
				if($zone && $circle && $cluster && $district && $customerCategory && $customerCode && $productCode){
					$ac = mysql_query("INSERT INTO ss_site_master(id,zone,circle,cluster,district,customerCategory,customerCode,siteType,siteID,siteName,siteAddress,mfdDate,installDate,productCode,noOfString,customerName,customerNumber,clusterManagerName,clusterManagerNumber,clusterManagerMail,scheduleDays,warrantyMonths,siteStatus,createdDate) VALUES('$id','$zone','$circle','$cluster','$district','$customerCategory','$customerCode','$siteType','$siteID','$siteName','$siteAddress','$mfdDate','$installDate','$productCode','$noOfString','$customerName','$customerNumber','$clusterManagerName','$clusterManagerNumber','$clusterManagerMail','$scheduleDays','$warrantyMonths','$siteStatus','".date('Y-m-d')."')");
				}else{ $wrongData[] = $siteID; }
			}else{ $already[] = $siteID; }
			}
			if(count($already)!=0){ $result = 'Some siteIDs already exists...';} //errorMsg('ERRMSG003');
			else{
				if(count($wrongData)!=0){ $result = 'Some siteIDs has Wrong Data...';}
				else{ if($ac)$result="All SiteIDs are successfully Inserted...";else $result=errorMsg('ERRMSG002');}
			}
			}else{ $result = 'Invalid file...'; }
		}
	}else{ $result = "No file selected"; }
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm" enctype="multipart/form-data">
    <?php if(count($already)!=0){ ?>
        <div class="col-md-4 form-group">
            <label>Existed Site IDs are :</label>
            <?php foreach($already as $num=>$alr){ echo "<p>".($num+1).". ".$alr."</p>"; } ?>
        </div>
    <?php } ?>
	<?php if(count($wrongData)!=0){ ?>
        <div class="col-md-4 form-group">
            <label>Wrong Site IDs are :</label>
            <?php foreach($wrongData as $num=>$alr){ echo "<p>".($num+1).". ".$alr."</p>"; } ?>
        </div>
    <?php } ?>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
			<div class="btn btn-primary ss_buttons fileUpload"><span>Choose</span>
            	<input type="file" name="file" class="upload" tabindex="1">
            </div>
            <button type="submit" class="btn btn-primary ss_buttons import" name="import" tabindex="2">Submit</button>
			<span style="color:red;margin-left:20px">* Choose Excel file Only</span>
        </div>
    </div>
</form>
<?php
function textToCodeReplace($a,$b,$c){
	$sql = mysql_query("SELECT id FROM $b WHERE $c='$a' AND flag='0'");
	if(mysql_num_rows($sql)>0){$id = mysql_fetch_array($sql);	return $id['id'];}else{ return FALSE;}
	}
function schedule($a){
	$sql1 = mysql_query("SELECT schedule FROM ss_customer_details WHERE customerCode='$a' AND flag='0'");
	$schedule = mysql_fetch_array($sql1);
	return $schedule['schedule'];
	}
function warranty($f1,$f2,$f3,$f4){
	date_default_timezone_set("Asia/Kolkata");
	$res = mysql_query("select dispatch,installation from ss_customer_details where id='".$f1."' AND flag='0'");
	if(mysql_num_rows($res)>0){$row=mysql_fetch_array($res);
		
		$dis = $row['dispatch'];
		$inst = $row['installation'];
		
		$diff1 = abs(strtotime(date('Y-m-d')) - strtotime($f2)); //$years = $diff / (365*60*60*24);
		$mfd = round($diff1 / (30*60*60*24));
		
		$diff2 = abs(strtotime(date('Y-m-d')) - strtotime($f3));
		$install = round($diff2 / (30*60*60*24));

	if($f2=='0000-00-00' && $f3=='0000-00-00'){	if(($dis <= $inst)){ return warr($dis,'OutOfWarranty',$f4); } else{ return warr($inst,'OutOfWarranty',$f4);} }
	elseif(($dis-$mfd <= 0) || ($inst-$install <= 0)){ if(($dis-$mfd) < ($inst-$install)){ return warr($dis,'OutOfWarranty',$f4);}else{return warr($inst,'OutOfWarranty',$f4);}	}
	elseif(($dis-$mfd) > ($inst-$install)){ return warr($inst,'Warranty',$f4); }
	elseif(($dis-$mfd) < ($inst-$install)){ return warr($dis,'Warranty',$f4); }
	else{ return warr($dis,'Warranty',$f4); } // ($dis-$mfd) == ($inst-$install)
	}
}
function warr($a,$b,$c){if($c=='warr'){ return $a; }else{ return $b;} }
?>