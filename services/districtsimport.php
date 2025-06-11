<?php 
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['import'])){
	if(isset($_FILES["file"])){ //if there was an error uploading the file
	if($_FILES["file"]["error"]>0){$result = "No file selected";}
		else{ $extn = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		if($extn=='xlsx' || $extn=='xls' ){
		set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
		include 'mysql.php';
		include 'functions.php';
		include 'Classes/PHPExcel/IOFactory.php';
		// This is the file path to be uploaded.
		$inputFileName = $_FILES["file"]["tmp_name"];
		try { $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);}
		catch(Exception $e){die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage()); }
		$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
		$already = array(); $wrongData = array();
		for($i=2;$i<=$arrayCount;$i++){
			$district_name = strtoupper(trim($allDataInSheet[$i]["A"]));
			$state_alias = textToCodeReplace(strtoupper(trim($allDataInSheet[$i]["B"])),'ec_state','state_name','state_alias');
			$sql = $mr_con->query("SELECT district_name FROM ec_district WHERE district_name='$district_name' AND flag=0");
			if($sql->num_rows==0){ 
			$district_alias = aliasCheck(generateRandomString(),'ec_district','district_alias',$mr_con);
				if($state_alias){
					$ac = $mr_con->query("INSERT INTO ec_district(district_name,district_alias,state_alias,created_date)VALUES('$district_name','$district_alias','$state_alias','".date('Y-m-d')."')");
				}else{ 
				$wrongData[] = $district_name; }
			}else{ $already[] = $district_name; }
			}
			if(count($already)!=0){ $result = 'Some District Names already exists...';} //errorMsg('ERRMSG003');
			else{
				if(count($wrongData)!=0){ $result = 'Some District Names has Wrong Data...';}
				else{ if($ac)$result="All District Names are successfully Inserted...";else $result='Sorry try again';}
			}
			}else{ $result = 'Invalid file...'; }
		}
	}else{ $result = "No file selected"; }
}
?>
<p class="errorP"><?php //if(isset($result))echo $result; ?></p>
<form role="form" class="ss_form" method="post" id="defaultForm" enctype="multipart/form-data" novalidate>
    <?php if(count($already)!=0){ ?>
        <div class="col-md-4 form-group">
            <label>Existed Districts name are :</label>
            <?php foreach($already as $num=>$alr){ echo "<p>".($num+1).". ".$alr."</p>"; } ?>
        </div>
    <?php } ?>
	<?php if(count($wrongData)!=0){ ?>
        <div class="col-md-4 form-group">
            <label>Wrong Districts name are :</label>
            <?php foreach($wrongData as $num=>$alr){ echo "<p>".($num+1).". ".$alr."</p>"; } ?>
        </div>
    <?php } ?>
	<p><?php if(isset($result)){echo $result;} ?></p>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons import" name="import" tabindex="1">Add Districts</button>
			<div class="btn btn-primary ss_buttons fileUpload"><span>Import</span>
            	<input type="file" name="file" class="upload" tabindex="2">
            </div><span style="color:red;margin-left:20px">* Choose Excel file Only</span>
        </div>
    </div>
</form>
<?php
function textToCodeReplace($a,$b,$c,$d){ global $mr_con;
	//echo  "SELECT $d FROM $b WHERE $c='$a' AND flag='0'<br>";
	$sql = $mr_con->query("SELECT $d FROM $b WHERE $c='$a'");
	if($sql->num_rows>0){$id = $sql->fetch_assoc();	/*echo $id[$d]."---<br>";*/ return $id[$d];}else{ /*echo "---<br>";*/ return FALSE;}
}
?>