<?php
date_default_timezone_set("Asia/Kolkata");
include('db.php');
getDB();
if(isset($_REQUEST['ref2'])){
if(isset($_REQUEST['department'])){$department = implode("|",$_REQUEST['department']);}else{$department = '';}
if(!empty($department)){$con .= " department_alias RLIKE '$department' AND";}
$sql = mysql_query("SELECT department_alias,designation_alias,employee_alias FROM ec_expense_approvals WHERE $con flag=0");
$colArr=array('Department','Designation','Employee Name');
	$filename = 'aprovals-'.rand(0000,9999)."-".date("Y-m-d");
	if(mysql_num_rows($sql)){
	include('../Classes/PHPExcel.php');
	$objPHPExcel = new PHPExcel();
	function cellColor($cells,$color){ global $objPHPExcel;
		$objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => $color)));
	}
	$objPHPExcel->setActiveSheetIndex(0);
	$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF'),/*'size'  => 15,'name'  => 'Verdana'*/ ));
	$ch = 'A';
	foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
		$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
		cellColor($ch.'1', '428bca');
	$ch++;
	}
	$coo=1;
	while($row=mysql_fetch_array($sql)){
		foreach(explode('|',$row['employee_alias']) as $a){$coo++;
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$coo, alias($row['department_alias'],'ec_department','department_alias','department_name'));
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$coo, alias(alias($a,'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','designation'));
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$coo, alias($a,'ec_employee_master','employee_alias','name'));
		
		}
	}
	$objPHPExcel->getActiveSheet()->setTitle('Simple');
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save("exports/$filename.xlsx");
			$message= "<a href='exports/$filename.xlsx' class='alert alert-success bhk' role='alert' target='_blank'>Click to download</a>";
		}else $message= "<p class='alert alert-success bhk' role='alert'>No records</p>";
}?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Export Approvals List</h3>
	</div>
	<div class="panel-body">
<?php if(isset($message))echo $message;?>
    	<form role="form" class="ss_form" method="post" id="defaultForm" novalidate>
        <input type="hidden" value="<?php echo $ref;?>" name="ref" />
        <input type="hidden" value="1" name="ref2" />
        <div class="col-md-6 col-md-offset-3">
            <div class="col-md-6 form-group">
            	<label>Department: </label>
                <select name="department[]" class="form-control" id='mot1' multiple="multiple" placeholder="Department"><?php echo allOptions('department_alias','department_name','ec_department'); ?></select>
            </div>
            <div class="col-md-3 form-group">
            	<label>&nbsp;</label>
                <input type="submit" class="form-control exportx" tabindex="5" value="Export"/>
            </div>
       </div>
</form>
<?php 

function allOptions($alias,$name,$tb){
	$sql = mysql_query("SELECT $alias,$name FROM $tb WHERE flag=0");
	if(mysql_num_rows($sql)){
		while($row = mysql_fetch_array($sql)){
			$res .= "<option value='$row[$alias]'>$row[$name]</option>";
			}
		return $res;
	}
}
?>
<script type="text/javascript">
	$(document).ready(function() {
		window.prettyPrint() && prettyPrint();
		$('#mot1').multiselect({includeSelectAllOption: true});
	});
</script>