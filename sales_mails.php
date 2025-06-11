<?php 
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['import'])){
	if(isset($_FILES["file"])){ //if there was an error uploading the file
		if($_FILES["file"]["error"]>0)echo "No file selected";
		else{ $extn = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			if($extn=='xlsx' || $extn=='xls' ){
				set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
				include('services/mysql.php');
				include('services/functions.php');
				include('services/Classes/PHPExcel/IOFactory.php');
				// This is the file path to be uploaded.
				$inputFileName = $_FILES["file"]["tmp_name"];
				try { $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);}
				catch(Exception $e){die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage()); }
				$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
				$inval_emails=$not_sent=array();
				$sub="Lead Price Increase-Alert mails";
				for($i=2;$i<=$arrayCount;$i++){
					$email_id = trim($allDataInSheet[$i]["B"]);
					$subdate = trim($allDataInSheet[$i]["C"]);
					$quotation_num = trim($allDataInSheet[$i]["D"]);
					if(!filter_var($email_id, FILTER_VALIDATE_EMAIL) === false) {
						$body="<p>Dear Sir,</p>
						<p>With reference to our Quotation number <b>".$quotation_num."</b>, Dated <b>".$subdate."</b>, We would like to bring to your kind notice that the prices quoted cannot be held any longer as there has been a significant increase in the cost of lead. Lead prices have been increased considerably (more than 40%) during the last six months (LME Lead Price Graph attached here with). However , validity of the offer can be extended with suitable price variation clause to absorb the lead price fluctuations. This is applicable with immediate effect and till further information from our end. Hope , you will understand the situation and will co-operate with us. We assure our best service at all the times...,</p>
						</br><p><img src='http://enersyscare.co.in/image003.jpg' width='558' height='319'></p>
						<p>Thanking you and looking forward to mutually beneficial long term association ...,</p>
						</br><p>For Enersys India Sales</p>";
						$ccmail_id="csraju@enersys.co.in, feedback@enersys.co.in";
						$from="feedback@enersys.co.in";
						$headers="From: EnerSys <$from>\r\n";
						$headers .="Reply-To: $from\r\n";
						$headers .="Return-Path: $from\r\n";
						$headers .= "CC: $ccmail_id \r\n";
						$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$abc = mail($email_id,$sub,$body,$headers);
						if(!$abc)$not_sent[]=$email_id;
					}else $inval_emails[]=$email_id;
				}
				if(count($not_sent)==0 && count($inval_emails)==0)echo "All Mails Successfully Sent";
				else{	
					if(count($inval_emails)) echo implode(", ",$inval_emails)." mails are Invalid Mails<br>";
					if(count($not_sent)) echo implode(", ",$not_sent)." mails are Not sent";
				}
			}else{ echo 'Invalid file...'; }
		}
	}else{ echo "No file selected"; }
}
?>
<p class="errorP">
<form role="form" class="ss_form" method="post" enctype="multipart/form-data" novalidate>
  <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
           <div class="btn btn-primary ss_buttons fileUpload"><span>Import</span>
            	<input type="file" name="file" class="upload" tabindex="2">
            </div><span style="color:red;margin-left:20px">* Choose Excel file Only</span>
        </div>
		<input type="submit" name="import" value="Submit">
    </div>
</form>
