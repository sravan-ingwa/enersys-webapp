<?php 
if(isset($_REQUEST['import'])){
	if(isset($_FILES["file"])){ //if there was an error uploading the file
	if($_FILES["file"]["error"]>0){ $result = "No file selected";}
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
			$already = array();
			for($i=2;$i<=$arrayCount;$i++){
				$itemCode = trim($allDataInSheet[$i]["A"]);
				$itemDesc = trim($allDataInSheet[$i]["B"]);
				$price = trim($allDataInSheet[$i]["C"]);
				$sql = mysql_query("SELECT itemCode FROM ss_item_code WHERE itemCode='$itemCode' AND flag=0");
				if(mysql_num_rows($sql)==0){
					$id = checkx(rand(0000, 9999),'ss_item_code');
				$insertTable = mysql_query("INSERT INTO ss_item_code(id,itemCode,itemDesc,price)VALUES('$id','$itemCode','$itemDesc','$price')");
					$result = 'Record has been added.';
				}else{ $already[] = $itemCode;	}
				}
			if(count($already)!=0){ $result = 'Some Items already exists...';}
			else{ $result = 'All Items are successfully Inserted...'; }
			}else{ $result = 'Invalid file...'; }
		}
	}else{ $result = "No file selected"; }
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm" enctype="multipart/form-data">
    <?php if(count($already)!=0){ ?>
        <div class="col-md-4 form-group">
            <label>Existed ItemCodes are :</label>
            <?php foreach($already as $num=>$alr){ echo "<p>".($num+1).". ".$alr."</p>"; } ?>
        </div>
    <?php } ?>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
			<div class="btn btn-primary ss_buttons fileUpload"><span>Choose</span>
            	<input type="file" name="file" class="upload" tabindex="1">
            </div>
            <button type="submit" class="btn btn-primary ss_buttons import" name="import" tabindex="2">Submit</button>
			<span class="hid" style="color:red;margin-left:20px">* Choose Excel file Only</span>
        </div>
    </div>
</form>