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
			$employee_id = trim($allDataInSheet[$i]["A"]);
			$name = strtoupper(trim($allDataInSheet[$i]["B"]));
			$department_alias = textToCodeReplace(strtoupper(trim($allDataInSheet[$i]["C"])),'ec_department','department_name','department_alias');
			$designation_alias = textToCodeReplace(strtoupper(trim($allDataInSheet[$i]["D"])),'ec_designation','designation','designation_alias');
			$email_id = trim($allDataInSheet[$i]["E"]);
			$joining_date = trim($allDataInSheet[$i]["F"]);
			$mobile_number = trim($allDataInSheet[$i]["G"]);
			$password = trim($allDataInSheet[$i]["G"]);
			$role_alias = 'QV9IPNVA1M';
			$privilege_alias = 'RGPOOJAMSL';
			$sql = $mr_con->query("SELECT employee_id FROM ec_employee_master WHERE employee_id='$employee_id' AND flag=0");
			if($sql->num_rows==0){ 
			$employee_alias = aliasCheck(generateRandomString(),'ec_employee_master','employee_alias',$mr_con);
				if($designation_alias && $department_alias){
					//echo "INSERT INTO ec_employee_master(name,employee_id,email_id,mobile_number,password,designation_alias,department_alias,role_alias,privilege_alias,joining_date,employee_alias) VALUES('$name','$employee_id','$email_id','$mobile_number','$mobile_number','$designation_alias','$department_alias','$role_alias','$privilege_alias','$joining_date','$employee_alias'<br>";
					$ac = $mr_con->query("INSERT INTO ec_employee_master(name,employee_id,email_id,mobile_number,password,designation_alias,department_alias,role_alias,privilege_alias,joining_date,employee_alias) VALUES('$name','$employee_id','$email_id','$mobile_number','$mobile_number','$designation_alias','$department_alias','$role_alias','$privilege_alias','$joining_date','$employee_alias')");
				}else{ 
				//echo "INSERT INTO ec_employee_master(name,employee_id,email_id,mobile_number,password,designation_alias,department_alias,role_alias,privilege_alias,joining_date,employee_alias) VALUES('$name','$employee_id','$email_id','$mobile_number','$mobile_number','$designation_alias','$department_alias','$role_alias','$privilege_alias','$joining_date','$employee_alias')<br>";
				$wrongData[] = $employee_id; }
			}else{ $already[] = $employee_id; }
			}
			if(count($already)!=0){ $result = 'Some siteIDs already exists...';} //errorMsg('ERRMSG003');
			else{
				if(count($wrongData)!=0){ $result = 'Some siteIDs has Wrong Data...';}
				else{ if($ac)$result="All SiteIDs are successfully Inserted...";else $result='Sorry try again';}
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
            <label>Existed Employee ids are :</label>
            <?php foreach($already as $num=>$alr){ echo "<p>".($num+1).". ".$alr."</p>"; } ?>
        </div>
    <?php } ?>
	<?php if(count($wrongData)!=0){ ?>
        <div class="col-md-4 form-group">
            <label>Wrong Employee ids are :</label>
            <?php foreach($wrongData as $num=>$alr){ echo "<p>".($num+1).". ".$alr."</p>"; } ?>
        </div>
    <?php } ?>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons import" name="import" tabindex="1">Add Employee Master</button>
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