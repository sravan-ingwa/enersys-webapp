<?php
date_default_timezone_set("Asia/Kolkata");
include('db.php');
getDB();
if(isset($_REQUEST['ref2'])){ 
if(isset($_REQUEST['period_from']) && !empty($_REQUEST['period_from'])){$from = date("Y-m-d", strtotime($_REQUEST['period_from']));}else{$from = '';}
if(isset($_REQUEST['period_to']) && !empty($_REQUEST['period_to'])){$to = date("Y-m-d", strtotime($_REQUEST['period_to']));}else{$to = '';}
$val = mysqli_real_escape_string($mr_con,$_REQUEST['advance_value']);
$level = $_REQUEST['approval_level'];
$appr_cnt = $_REQUEST['appr_cnt'];
if($appr_cnt == "0"){
	$emp_alias = $_SESSION['ec_user_alias'];
}else{
	$emp_alias = $_REQUEST['employees'];	
}
if(!empty($from) && !empty($to)){$con = "(requested_date BETWEEN '$from' AND '$to') AND";}
elseif(!empty($from) && empty($to)){$con .= "requested_date >= '$from' AND";}
elseif(empty($from) && !empty($to)){$con .= "requested_date <= '$to' AND";}
if(!empty($val)){$con .= " request_amount='$val' AND";}
if($level!=''){$con .= " approval_level='$level' AND";}
if(!empty($emp_alias)){$con .= " employee_alias='$emp_alias' AND";}
$sql = mysql_query("SELECT * FROM ec_advances WHERE $con flag=0");
$colArr =array('Employee ID','Employee Name','Employee Designation','Employee Grade','Employee Department','Request Amount','Total Amount','Request ID','Requested Date','Approval Level','Approved By','Approved Date');
$colArr2 = array('request_amount','total_amount','request_id');
		if(mysql_num_rows($sql)){
			$filename = 'Advances-'.rand(0000,9999)."-".date("Y-m-d");
			include('Classes/PHPExcel.php');
			$objPHPExcel = new PHPExcel();
			function cellColor($cells,$color){ global $objPHPExcel;
				$objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => $color)));
			}
			$objPHPExcel->setActiveSheetIndex(0);
			$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF'),/*'size'  => 15,'name'  => 'Verdana'*/ ));
			$ch = 'A';
			foreach($colArr as $colrefValue){ $objPHPExcel->getActiveSheet()->mergeCells($ch.'1:'.$ch.'2');
				$objPHPExcel->getActiveSheet()->SetCellValue($ch.'1',ucfirst($colrefValue));
				$objPHPExcel->getActiveSheet()->getStyle($ch.'1')->applyFromArray($styleArray);
				cellColor($ch.'1', '428bca');
			$ch++;
			}
			$coo=2;
			while($row=mysql_fetch_array($sql)){ $coo++;
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$coo, alias($row['employee_alias'],'ec_employee_master','employee_alias','employee_id'));
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$coo, alias($row['employee_alias'],'ec_employee_master','employee_alias','name'));
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$coo, alias(alias($row['employee_alias'],'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','designation'));
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$coo, alias(alias($row['employee_alias'],'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','grade'));
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$coo, alias(alias($row['employee_alias'],'ec_employee_master','employee_alias','department_alias'),'ec_department','department_alias','department_name'));
				for($af=0,$chr='F';$af<count($colArr2);$af++,$chr++){
					$objPHPExcel->getActiveSheet()->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$coo, date("m/d/Y", strtotime($row['requested_date'])));
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$coo, exlevelsName($row['approval_level']));
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$coo, expo($row['approved_by']));
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$coo, str_replace("|",", ",$row['approved_date']));
	
				$remSql = mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE item_alias='".$row['advance_alias']."' AND module='BA' AND flag=0");
				$cc = 'M';
				$k=1;while($remRow = mysqli_fetch_array($remSql)){
					$cd = $cc;
					$objPHPExcel->getActiveSheet()->SetCellValue($cd.'1','Remarks '.$k);
					
					$objPHPExcel->getActiveSheet()->SetCellValue($cc.'2','Remarks');
					$objPHPExcel->getActiveSheet()->SetCellValue($cc.$coo, $remRow['remarks']);$cc++;
					
					$objPHPExcel->getActiveSheet()->SetCellValue($cc.'2','Remarked By');
					$objPHPExcel->getActiveSheet()->SetCellValue($cc.$coo, (strtoupper($remRow['remarked_by'])!='ADMIN' ? alias($remRow['remarked_by'],'ec_employee_master','employee_alias','name') : "ADMIN"));$cc++;
					
					$objPHPExcel->getActiveSheet()->SetCellValue($cc.'2','Remarked On');
					$objPHPExcel->getActiveSheet()->SetCellValue($cc.$coo, date("m/d/Y", strtotime($remRow['remarked_on'])));
					
					$objPHPExcel->getActiveSheet()->mergeCells($cd.'1:'.$cc.'1');
					
					$objPHPExcel->getActiveSheet()->getStyle($cd.'1:'.$cc.'2')->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle($cd.'1:'.$cc.'2')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
				$cc++;$k++;
				}
			}
			
			
			$objPHPExcel->getActiveSheet()->setTitle('Simple');
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$objWriter->save("exports/$filename.xlsx");
			$message= "<a href='exports/$filename.xlsx' class='alert alert-success bhk' role='alert' target='_blank'>Click to download</a>";
		}else $message= "<p class='alert alert-success bhk' role='alert'>No records</p>";
}
	$get_appr = mysql_query("SELECT * from ec_expense_approvals where approver = '".$_SESSION['ec_user_alias']."'");
	$get_cnt = mysql_num_rows($get_appr);
	if($get_cnt > 0){
		$get_lev = mysql_query("SELECT GROUP_CONCAT(DISTINCT approval_level) AS approval_level FROM ec_expense_approvals where approver = '".$_SESSION['ec_user_alias']."'");
		$get_lev_rs = mysql_fetch_array($get_lev);
		$appr_list = explode(',',$get_lev_rs['approval_level']);
		$all_levels =  array('3','4','5');
		$arr_inter = array_intersect($appr_list,$all_levels);
		$arr_inter_cnt = count($arr_inter);
		if($arr_inter_cnt == 0){ 
			$get_dep = mysql_query("SELECT GROUP_CONCAT(DISTINCT approval_dep) AS approval_dep FROM ec_expense_approvals where approver = '".$_SESSION['ec_user_alias']."'");
			$get_dept_rs = mysql_fetch_array($get_dep);
			$appr_dept = $get_dept_rs['approval_dep'];
		}
	}

?>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Export Advances</h3>
	</div>
	<div class="panel-body">
		<?php if(isset($message))echo $message;?>
    	<form role="form" class="ss_form" method="post" id="defaultForm" novalidate>
        <input type="hidden" value="<?php echo $ref;?>" name="ref" />
        <input type="hidden" value="1" name="ref2" />
         <div class="col-md-6 col-md-offset-3">
            <div class="col-md-6 form-group">
                <label>Period From : </label>
                <input type='text' class="form-control visitFromDate datepickers" tabindex="4" name="period_from" placeholder="Period of Visit From"/>
            </div>
            <div class="col-md-6 form-group">
                <label>Period To : </label>
                <input type='text' class="form-control visitToDate datepickers" tabindex="5" name="period_to" placeholder="Period of Visit To"/>
            </div>
            <div class="col-md-6 form-group">
                <label>Advances values : </label>
                <input type='text' class="form-control visitFromDate" tabindex="4" name="advance_value amtt" placeholder=" Amount"/>
            </div>
            <div class="col-md-6 form-group">
                <label>Approvals Levels : </label>
                <select class="form-control visitFromDate" name="approval_level">
                <option value="">All</option>
                <?php $listDgn=exlevels();if($listDgn!=0){foreach($listDgn as $rec){echo "<option value='".$rec['alias']."'>".$rec['name']."</option>";}}else echo "<option disabled='disabled'>Add Designation</option>";?>
                </select>
            </div>
            <?php if($get_cnt > 0){ ?>
            <div class="col-md-12 form-group">
                <label>Employees : </label>
                <select class="form-control" name="employees" required="required">
                <option value="">All</option>
                <?php 
				// for appr level Finance,HOD,MD
				if($arr_inter_cnt > 0) { 
				 $empDgn=empdrop();if($empDgn!=0){foreach($empDgn as $rec){echo "<option value='".$rec['alias']."'>".$rec['name']."</option>";}}else echo "<option disabled='disabled'>Add Employees</option>";?>
              <?php  } else {
				  //for approval dept
             	 $empDeptDgn=empDeptdrop($appr_dept);
				 if($empDeptDgn!=0){
				 foreach($empDeptDgn as $rec){echo "<option value='".$rec['alias']."'>".$rec['name']."</option>";}}else echo "<option disabled='disabled'>Add Employees</option>";
               } ?>
                </select>
            </div>
           <?php } ?>
            </div>
            <div class="col-md-2 col-md-offset-5 form-group">
            	<label>&nbsp;</label><input type="hidden" name="appr_cnt" value="<?php echo $get_cnt;?>" />
                <input type="submit" class="form-control exportx" tabindex="5" value="Export"/>
            </div>
        </form>
    </div>
</div>
<?php 
function expense_ali($alias,$ref){
	$sql = mysql_query("SELECT SUM(amount) FROM $ref WHERE expenses_alias='$alias' AND flag=0");
	$row = mysql_fetch_array($sql);
	return $row[0];
	}
function expo($a){
	foreach(explode("|",$a) as $b){$c[]=alias($b,'ec_employee_master','employee_alias','name');}
	return implode(", ",$c);
}
	
?>