<?php
date_default_timezone_set("Asia/Kolkata");
include('db.php');
getDB();
set_time_limit(0);
ini_set('memory_limit', '512M');
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
if(isset($_REQUEST['ref2'])){
if(isset($_REQUEST['period_from']) && !empty($_REQUEST['period_from'])){$from = date("Y-m-d", strtotime($_REQUEST['period_from']));}else{$from = '';}
if(isset($_REQUEST['period_to']) && !empty($_REQUEST['period_to'])){$to = date("Y-m-d", strtotime($_REQUEST['period_to']));}else{$to = '';}
$val = mysqli_real_escape_string($mr_con,$_REQUEST['total_tour_expenses']);
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
if(!empty($val)){$con .= " total_tour_expenses='$val' AND";}
if($level!=''){
	$con .= " approval_level='$level' AND";
}
if($emp_alias !='' && $emp_alias !='0'){$con .= " employee_alias='$emp_alias' AND";}
else{$result=array();
	if($arr_inter_cnt == 0){
		$check_arr=implode("','",explode(',',$appr_dept));
		$rec=$mr_con->query("SELECT employee_alias FROM ec_employee_master WHERE flag=0 AND department_alias IN ('$check_arr') ORDER BY name");
		if($rec->num_rows>0){
			while($row = $rec->fetch_assoc()){$result[]=$row['employee_alias'];}
		}
		$con .= " employee_alias IN ('".implode("','",$result)."') AND";
	}else{
	}
}
//echo $con; exit;
//echo "SELECT * FROM ec_expenses WHERE $con flag=0";exit;
$sql = mysql_query("SELECT * FROM ec_expenses WHERE $con flag=0");
$colArr =array('Employee ID','Employee Name','Employee Designation','Employee Grade','Employee Department','Bill Number','Booking Date','Period Of Visit From','Period Of Visit To','Places Of Visit','Purpose','Expense For','Amount','Total Tour Expenses','Date Of Travel','Mode Of Travel','From','To','Type Of Stay','Visit Start Date','Visit End Date','Hotel Name/State','Ticket ID','DPR Number','Description',
'Date','Approval Level','Reimbursement Amount');
$colArr2 =array('places_of_visit','purpose');
$colArr3 =array('total_tour_expenses');
$tbls = array('ec_conveyance','ec_localconveyance','ec_lodging','ec_boarding','ec_other_expenses');
		if(mysql_num_rows($sql)){
			$filename = 'Expense-'.rand(0000,9999)."-".date("Y-m-d");
			include('Classes/PHPExcel.php');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			$sheet = $objPHPExcel->getActiveSheet();
			function php_excel_date($date){
				return (((strpos($date,"1970")!==false) || empty($date) || $date=="0000-00-00" || $date=="0000-00-00 00:00:00") ? "-" : (PHPExcel_Shared_Date::PHPToExcel(strtotime("+5 hours +30 minutes",strtotime($date)))));
			}
			function cellColor($cells,$color){ global $objPHPExcel;
				$objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => $color)));
			}
			$styleArray = array('font'  => array('bold'  => true, 'color' => array('rgb' => 'FFFFFF'),/*'size'  => 15,'name'  => 'Verdana'*/ ));
			$ch = 'A';
			foreach($colArr as $colrefValue){
				$sheet->SetCellValue($ch.'1',ucfirst($colrefValue));
				$sheet->getStyle($ch.'1')->applyFromArray($styleArray);
				cellColor($ch.'1', '428bca');
			$ch++;
			}
			$date_arr = array("G","H","I","O","T","U","Z");
			foreach($date_arr as $da){$sheet->getStyle($da)->getNumberFormat()->setFormatCode('mm/dd/yyyy');$sheet->getColumnDimension($da)->setAutoSize(true);}
			$coo=1;
			while($row=mysql_fetch_array($sql)){
				$explevel = $row['approval_level'];
				$empalias = $row['employee_alias'];
				if($explevel !=0){
					foreach($tbls as $tbl){
					$subsql = mysql_query("SELECT * FROM $tbl WHERE expenses_alias='".$row['expenses_alias']."' AND flag=0");
					while($subrow=mysql_fetch_array($subsql)){ $coo++;
						$sheet->SetCellValue('A'.$coo, alias($row['employee_alias'],'ec_employee_master','employee_alias','employee_id'));
						$sheet->SetCellValue('B'.$coo, alias($row['employee_alias'],'ec_employee_master','employee_alias','name'));
						$sheet->SetCellValue('C'.$coo, alias(alias($row['employee_alias'],'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','designation'));
						$sheet->SetCellValue('D'.$coo, alias(alias($row['employee_alias'],'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','grade'));
						$sheet->SetCellValue('E'.$coo, alias(alias($row['employee_alias'],'ec_employee_master','employee_alias','department_alias'),'ec_department','department_alias','department_name'));
						$sheet->SetCellValue('F'.$coo, $row['bill_number']);
						$sheet->SetCellValue('G'.$coo, php_excel_date($row['requested_date']));
						$sheet->SetCellValue('H'.$coo, php_excel_date($row['period_of_visit_from']));
						$sheet->SetCellValue('I'.$coo, php_excel_date($row['period_of_visit_to']));
						for($af=0,$chr='J';$af<count($colArr2);$af++,$chr++){
							$sheet->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
						}
						$date_of_travel = ($tbl=='ec_conveyance' || $tbl=='ec_localconveyance' ? $subrow['date_of_travel']:'-');
						$check_in = ($tbl=='ec_lodging' || $tbl=='ec_boarding' ? $subrow['check_in']:'-');
						$check_out = ($tbl=='ec_lodging' || $tbl=='ec_boarding' ? $subrow['check_out']:'-');
						$checked_date = ($tbl=='ec_other_expenses' ? $subrow['checked_date']:'-');
						$dpr = ($subrow['dpr_number']!='' ? $subrow['dpr_number']:'-') ;
						if($subrow['ticket_alias'] == 1){
							$ticket = 'Others';	
						}else{
							$ticket = ($subrow['ticket_alias']!='' ? getTicketName($subrow['ticket_alias']):'-') ;
						}						$sheet->SetCellValue('L'.$coo, exp_for($tbl)); // Expense For
						$sheet->SetCellValue('M'.$coo, $subrow['amount']); // Amount
						$sheet->SetCellValue('N'.$coo, $row['total_tour_expenses']);// Total tour exp
						$sheet->SetCellValue('O'.$coo, ($date_of_travel=='-' ? '-' : php_excel_date($date_of_travel))); //Date Of Travel
						$sheet->SetCellValue('P'.$coo, ($tbl=='ec_conveyance' || $tbl=='ec_localconveyance' ? $subrow['mode_of_travel']:'-')); //Mode Of Travel
						$sheet->SetCellValue('Q'.$coo, ($tbl=='ec_conveyance' || $tbl=='ec_localconveyance' ? $subrow['from_place']:'-')); //From
						$sheet->SetCellValue('R'.$coo, ($tbl=='ec_conveyance' || $tbl=='ec_localconveyance' ? $subrow['to_place']:'-')); //To
						$sheet->SetCellValue('S'.$coo, ($tbl=='ec_lodging' ? $subrow['type_of_stay']:'-')); //Type Of Stay
						$sheet->SetCellValue('T'.$coo, ($check_in=='-' ? '-' : php_excel_date($check_in))); //Visit Start Date
						$sheet->SetCellValue('U'.$coo, ($check_out=='-' ? '-' : php_excel_date($check_out))); //Visit End Date
						$sheet->SetCellValue('V'.$coo, ($tbl=='ec_lodging' ? $subrow['hotel_name']:($tbl=='ec_boarding' ? $subrow['state']:'-'))); //Hotel Name/State
						$sheet->SetCellValue('W'.$coo, $ticket); 
						$sheet->SetCellValue('X'.$coo, $dpr);
						$sheet->SetCellValue('Y'.$coo, ($tbl=='ec_other_expenses' ? $subrow['description']:'-')); //Description	
						$sheet->SetCellValue('Z'.$coo, ($checked_date=='-' ? '-' : php_excel_date($checked_date))); //Date
						$sheet->SetCellValue('AA'.$coo, exlevelsName($row['approval_level'])); //approval level
						$sheet->SetCellValue('AB'.$coo, $row['reimbursement_amount']); //reimbursement_amount
						
						$remSql = mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE item_alias='".$row['expenses_alias']."' AND module='BE' AND flag=0");
						$remCount=(mysqli_num_rows($remSql)*3);
						$j=1;
						for($i=1,$cb='AC';$i<=$remCount;$i++,$cb++){
							$sheet->getStyle($cb.'1')->applyFromArray($styleArray);
							$sheet->getStyle($cb.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
							if($i%3=='1'){$sheet->SetCellValue($cb.'1','Remarks '.$j);}
							if($i%3=='2'){$sheet->SetCellValue($cb.'1','Remarked By '.$j);}
							if($i%3=='0'){
								$sheet->SetCellValue($cb.'1','Remarked On '.$j);				
								$sheet->getStyle($cb)->getNumberFormat()->setFormatCode('mm/dd/yyyy');
								$sheet->getColumnDimension($cb)->setAutoSize(true);$j++;
							}
						}
						$cc = 'AC';
						$k=1;while($remRow = mysqli_fetch_array($remSql)){
							$sheet->SetCellValue($cc.$coo, $remRow['remarks']);$cc++;
							$sheet->SetCellValue($cc.$coo, (strtoupper($remRow['remarked_by'])!='ADMIN' ? alias($remRow['remarked_by'],'ec_employee_master','employee_alias','name') : "ADMIN"));$cc++;
							$sheet->SetCellValue($cc.$coo, php_excel_date($remRow['remarked_on']));
							$cc++;$k++;
						}
					}
				}
				} else {
					if($_SESSION['ec_user_alias'] == $empalias){
						foreach($tbls as $tbl){
					$subsql = mysql_query("SELECT * FROM $tbl WHERE expenses_alias='".$row['expenses_alias']."' AND flag=0");
					while($subrow=mysql_fetch_array($subsql)){ $coo++;
						$sheet->SetCellValue('A'.$coo, alias($row['employee_alias'],'ec_employee_master','employee_alias','employee_id'));
						$sheet->SetCellValue('B'.$coo, alias($row['employee_alias'],'ec_employee_master','employee_alias','name'));
						$sheet->SetCellValue('C'.$coo, alias(alias($row['employee_alias'],'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','designation'));
						$sheet->SetCellValue('D'.$coo, alias(alias($row['employee_alias'],'ec_employee_master','employee_alias','designation_alias'),'ec_designation','designation_alias','grade'));
						$sheet->SetCellValue('E'.$coo, alias(alias($row['employee_alias'],'ec_employee_master','employee_alias','department_alias'),'ec_department','department_alias','department_name'));
						$sheet->SetCellValue('F'.$coo, $row['bill_number']);
						$sheet->SetCellValue('G'.$coo, php_excel_date($row['requested_date']));
						$sheet->SetCellValue('H'.$coo, php_excel_date($row['period_of_visit_from']));
						$sheet->SetCellValue('I'.$coo, php_excel_date($row['period_of_visit_to']));
						for($af=0,$chr='J';$af<count($colArr2);$af++,$chr++){
							$sheet->SetCellValue($chr.$coo, $row[$colArr2[$af]]);
						}
						$date_of_travel = ($tbl=='ec_conveyance' || $tbl=='ec_localconveyance' ? $subrow['date_of_travel']:'-');
						$check_in = ($tbl=='ec_lodging' || $tbl=='ec_boarding' ? $subrow['check_in']:'-');
						$check_out = ($tbl=='ec_lodging' || $tbl=='ec_boarding' ? $subrow['check_out']:'-');
						$checked_date = ($tbl=='ec_other_expenses' ? $subrow['checked_date']:'-');
						$dpr = ($subrow['dpr_number']!='' ? $subrow['dpr_number']:'-') ;
						if($subrow['ticket_alias'] == 1){
							$ticket = 'Others';	
						}else{
							$ticket = ($subrow['ticket_alias']!='' ? getTicketName($subrow['ticket_alias']):'-') ;
						}						$sheet->SetCellValue('L'.$coo, exp_for($tbl)); // Expense For
						$sheet->SetCellValue('M'.$coo, $subrow['amount']); // Amount
						$sheet->SetCellValue('N'.$coo, $row['total_tour_expenses']);// Total tour exp
						$sheet->SetCellValue('O'.$coo, ($date_of_travel=='-' ? '-' : php_excel_date($date_of_travel))); //Date Of Travel
						$sheet->SetCellValue('P'.$coo, ($tbl=='ec_conveyance' || $tbl=='ec_localconveyance' ? $subrow['mode_of_travel']:'-')); //Mode Of Travel
						$sheet->SetCellValue('Q'.$coo, ($tbl=='ec_conveyance' || $tbl=='ec_localconveyance' ? $subrow['from_place']:'-')); //From
						$sheet->SetCellValue('R'.$coo, ($tbl=='ec_conveyance' || $tbl=='ec_localconveyance' ? $subrow['to_place']:'-')); //To
						$sheet->SetCellValue('S'.$coo, ($tbl=='ec_lodging' ? $subrow['type_of_stay']:'-')); //Type Of Stay
						$sheet->SetCellValue('T'.$coo, ($check_in=='-' ? '-' : php_excel_date($check_in))); //Visit Start Date
						$sheet->SetCellValue('U'.$coo, ($check_out=='-' ? '-' : php_excel_date($check_out))); //Visit End Date
						$sheet->SetCellValue('V'.$coo, ($tbl=='ec_lodging' ? $subrow['hotel_name']:($tbl=='ec_boarding' ? $subrow['state']:'-'))); //Hotel Name/State
						$sheet->SetCellValue('W'.$coo, $ticket); 
						$sheet->SetCellValue('X'.$coo, $dpr);
						$sheet->SetCellValue('Y'.$coo, ($tbl=='ec_other_expenses' ? $subrow['description']:'-')); //Description	
						$sheet->SetCellValue('Z'.$coo, ($checked_date=='-' ? '-' : php_excel_date($checked_date))); //Date
						$sheet->SetCellValue('AA'.$coo, exlevelsName($row['approval_level'])); //approval level
						$sheet->SetCellValue('AB'.$coo, $row['reimbursement_amount']); //reimbursement_amount
						
						$remSql = mysqli_query($mr_con,"SELECT * FROM ec_remarks WHERE item_alias='".$row['expenses_alias']."' AND module='BE' AND flag=0");
						$remCount=(mysqli_num_rows($remSql)*3);
						$j=1;
						for($i=1,$cb='AC';$i<=$remCount;$i++,$cb++){
							$sheet->getStyle($cb.'1')->applyFromArray($styleArray);
							$sheet->getStyle($cb.'1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '428bca')));
							if($i%3=='1'){$sheet->SetCellValue($cb.'1','Remarks '.$j);}
							if($i%3=='2'){$sheet->SetCellValue($cb.'1','Remarked By '.$j);}
							if($i%3=='0'){
								$sheet->SetCellValue($cb.'1','Remarked On '.$j);				
								$sheet->getStyle($cb)->getNumberFormat()->setFormatCode('mm/dd/yyyy');
								$sheet->getColumnDimension($cb)->setAutoSize(true);$j++;
							}
						}
						$cc = 'AC';
						$k=1;while($remRow = mysqli_fetch_array($remSql)){
							$sheet->SetCellValue($cc.$coo, $remRow['remarks']);$cc++;
							$sheet->SetCellValue($cc.$coo, (strtoupper($remRow['remarked_by'])!='ADMIN' ? alias($remRow['remarked_by'],'ec_employee_master','employee_alias','name') : "ADMIN"));$cc++;
							$sheet->SetCellValue($cc.$coo, php_excel_date($remRow['remarked_on']));
							$cc++;$k++;
						}
					}
				}
					}
				}
			}
			$sheet->setTitle('Simple');
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$objWriter->save("exports/$filename.xlsx");
			$message= "<a href='exports/$filename.xlsx' class='alert alert-success bhk' role='alert' target='_blank'>Click to download</a>";
			}else $message= "<p class='alert alert-success bhk' role='alert'>No records</p>";
}

?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Export Expenses</h3>
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
                <label>Expenses values : </label>
                <input type='text' class="form-control amtt" tabindex="4" name="total_tour_expenses" placeholder="Amount"/>
            </div>
            <div class="col-md-6 form-group">
                <label>Approvals Levels : </label>
                <select class="form-control visitFromDate" name="approval_level" id="appr_change">
                <option value="">All</option>
                <?php $listDgn=exlevels();if($listDgn!=0){foreach($listDgn as $rec){echo "<option value='".$rec['alias']."'>".$rec['name']."</option>";}}else echo "<option disabled='disabled'>Add Designation</option>";?>
                </select>
                <input type="hidden" id="draft_emp"/>
            </div>
            <?php if($get_cnt > 0){ ?>
            <div class="col-md-12 form-group">
                <label>Employees : </label>
                <select class="form-control" name="employees" required="required" id="sel_emp">
                <option value="0">All</option>
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
                <input type="submit" class="form-control validat exportx" tabindex="5" value="Export"/>
            </div>
           
        </form>
    </div>
</div>
<?php 
function exp_for($tbl){
	switch($tbl){
		case 'ec_conveyance': return 'Conveyance'; break;
		case 'ec_localconveyance': return 'Local Conveyance'; break;
		case 'ec_lodging': return 'Lodging'; break;
		case 'ec_boarding': return 'Boarding'; break;
		case 'ec_other_expenses': return 'Other Expenses'; break;
		default : return 'No Expense';
	}
}
?>
<script>
$('#appr_change').on('change', function() {
	var val = $(this).val();
	if(val=='0'){
		$('#draft_emp').val('<?php echo $_SESSION['ec_user_alias']; ?>');
		$('#draft_emp').attr('name','employees');
		$('#sel_emp option[value="<?php echo $_SESSION['ec_user_alias']; ?>"]').attr('selected','selected');
		$('#sel_emp').attr('disabled','disabled');
		$('#draft_emp').removeAttr('disabled','disabled');
	}else{
		$('#sel_emp option[value="0"]').attr('selected','selected');
		$('#sel_emp').removeAttr('disabled','disabled');
		$('#draft_emp').attr('disabled','disabled');
	}
  });
</script>