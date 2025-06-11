<?php
session_start();
include('../functions.php');
if(isset($_REQUEST['ref']) && $_REQUEST['ref']=='editemployee'){
	$ref='editemployee';
	if(isset($_REQUEST['empId'])){
		if($_REQUEST['empId']==""){$message="<p class='alert alert-danger' role='alert'>Enter Employee ID</p>";}
		else if($_REQUEST['empName']==""){$message="<p class='alert alert-danger' role='alert'>Enter Employee Name</p>";}
		else if(!isset($_REQUEST['dep'])&&$_REQUEST['dep']==0){$message="<p class='alert alert-danger' role='alert'>Select Department</p>";}
		else if(!isset($_REQUEST['des'])&&$_REQUEST['des']==0){$message="<p class='alert alert-danger' role='alert'>Select Designation</p>";}
		else if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['doj'])){$message="<p class='alert alert-danger' role='alert'>Select Date of Joining</p>";}
		else if(!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)){$message="<p class='alert alert-danger' role='alert'>Enter Email ID</p>";}
		else if(!preg_match("/^[789][0-9]{9}$/",$_REQUEST['mobile'])){$message="<p class='alert alert-danger' role='alert'>Enter Mobile Number</p>";}
		else if(isset($_REQUEST['obal']) && !preg_match("/^[1-9][0-9]*$/",$_REQUEST['obal'])){$message="<p class='alert alert-danger' role='alert'>Enter Opening Balance</p>";}
		else if(isset($_REQUEST['ccard']) && !preg_match("/^[1-9][0-9]*$/",$_REQUEST['ccard'])){$message="<p class='alert alert-danger' role='alert'>Enter Only Numbers in Cash Card</p>";}
		else if($_REQUEST['password']==""){$message="<p class='alert alert-danger' role='alert'>Enter Password</p>";}
		else{	
			$date=date("Y-m-d");
			$empId=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['empId']));
			$empName=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['empName']));
			$dep=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['dep']));
			$des=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['des']));
			$doj=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['doj']))));
			$email=strtolower(mysqli_real_escape_string($mr_con,$_REQUEST['email']));
			$mobile=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['mobile']));
			$password=mysqli_real_escape_string($mr_con,$_REQUEST['password']);
			$alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['id']));
			$ccard=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['ccard']));
			
			$sql="UPDATE ec_employee_master SET employee_id='$empId',name='$empName',department_alias='$dep',designation_alias='$des', joining_date='$doj', email_id='$email', mobile_number='$mobile', password='$password', cash_card='$ccard' WHERE employee_alias='$alias'";
			if(isset($_REQUEST['obal'])){
				$obal=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['obal']));
				$rquestid="#".checkint(mt_rand(1000,999999999),'ec_advances','request_id');
				$alias_ad=aliasCheck(generateRandomString(),"ec_advances","advance_alias",$mr_con);
				$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias",$mr_con);
				$mr_con->query("INSERT INTO ec_advances(employee_alias,request_amount,total_amount,request_id,requested_date,advance_alias,approval_level) VALUES ('$alias','$obal','$obal','$rquestid','$date','$alias_ad','6')");
				$mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('Opening Balance','BA','$alias_ad','admin','$alias_remark')");
			}
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Updated successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Error: Try Again</p>";
			$mr_con->close();
		}
	}
	if(file_exists('editemployee.php')){include('editemployee.php');}
}
if(isset($_REQUEST['ref']) && $_REQUEST['ref']=='editdepartment'){
	$ref='editdepartment';
	if(isset($_REQUEST['department'])){
		if($_REQUEST['department']==""){$message="<p class='alert alert-danger' role='alert'>Enter Department</p>";}
		else{	
			$department=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['department']));
			$alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['id']));
			$sql="UPDATE ec_department SET department_name='$department' WHERE department_alias='$alias' AND flag='0'";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Updated successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Error: Try Again</p>";
			$mr_con->close();
		}
	}
	if(file_exists('editdepartment.php')){include('editdepartment.php');}
}
if(isset($_REQUEST['ref']) && $_REQUEST['ref']=='editdesignation'){
	$ref='editdesignation';
	if(isset($_REQUEST['designation'])){
		if($_REQUEST['designation']==""){$message="<p class='alert alert-danger' role='alert'>Enter Designation</p>";}
		else{	
			$designation=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['designation']));
			$grade=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['grade']));
			$alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['id']));
			$sql="UPDATE ec_designation SET designation='$designation', grade='$grade' WHERE designation_alias='$alias' AND flag='0'";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Updated successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Error: Try Again</p>";
			$mr_con->close();
		}
	}
	if(file_exists('editdesignation.php')){include('editdesignation.php');}
}
if(isset($_REQUEST['ref']) && $_REQUEST['ref']=='editlimits'){
	$ref='editlimits';
	if(isset($_REQUEST['limit'])){
		if($_REQUEST['limit']=="" && $_REQUEST['limit']=="0"){$message="<p class='alert alert-danger' role='alert'>Enter Limit</p>";}
		else{	
			$limit=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['limit']));
			$alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['id']));
			$sql="UPDATE ec_expense_limits SET limit_amount='$limit' WHERE limit_alias='$alias' AND flag='0'";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Updated successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Error: Try Again</p>";
			$mr_con->close();
		}
	}
	if(file_exists('editlimits.php')){include('editlimits.php');}
}
if(isset($_REQUEST['ref']) && $_REQUEST['ref']=='editallowances'){
	$ref='editallowances';
	if($_REQUEST['grade']=='0'){$message="<p class='alert alert-danger' role='alert'>Select Grade</p>";}
	else if($_REQUEST['mot']==0){$message="<p class='alert alert-danger' role='alert'>Select Mode of travel</p>";}
	else if($_REQUEST['molc']==0){$message="<p class='alert alert-danger' role='alert'>Select Mode of Local Conveyance</p>";}
	else if(filter_var($_REQUEST['amt1'], FILTER_VALIDATE_INT) === false){$message="<p class='alert alert-danger' role='alert'>Enter Lodging Allowances A+</p>";}
	else if(filter_var($_REQUEST['amt2'], FILTER_VALIDATE_INT) === false){$message="<p class='alert alert-danger' role='alert'>Enter Lodging Allowances A</p>";}
	else if(filter_var($_REQUEST['amt3'], FILTER_VALIDATE_INT) === false){$message="<p class='alert alert-danger' role='alert'>Enter Lodging Allowances B</p>";}
	else if(filter_var($_REQUEST['amt4'], FILTER_VALIDATE_INT) === false){$message="<p class='alert alert-danger' role='alert'>Enter Lodging Allowances C</p>";}
	else if(filter_var($_REQUEST['amt5'], FILTER_VALIDATE_INT) === false){$message="<p class='alert alert-danger' role='alert'>Enter Lodging Allowances A+</p>";}
	else if(filter_var($_REQUEST['amt6'], FILTER_VALIDATE_INT) === false){$message="<p class='alert alert-danger' role='alert'>Enter Lodging Allowances A</p>";}
	else if(filter_var($_REQUEST['amt7'], FILTER_VALIDATE_INT) === false){$message="<p class='alert alert-danger' role='alert'>Enter Lodging Allowances B</p>";}
	else if(filter_var($_REQUEST['amt8'], FILTER_VALIDATE_INT) === false){$message="<p class='alert alert-danger' role='alert'>Enter Lodging Allowances C</p>";}
	else if(filter_var($_REQUEST['amt9'], FILTER_VALIDATE_INT) === false){$message="<p class='alert alert-danger' role='alert'>Enter Mobile Roaming Charges</p>";}
	else{
		$amt1=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt1']));
		$amt2=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt2']));
		$amt3=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt3']));
		$amt4=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt4']));
		$amt5=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt5']));
		$amt6=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt6']));
		$amt7=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt7']));
		$amt8=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt8']));
		$amt9=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['amt9']));
		$mot=strtoupper(mysqli_real_escape_string($mr_con,implode(", ",$_REQUEST['mot'])));
		$molc=strtoupper(mysqli_real_escape_string($mr_con,implode(", ",$_REQUEST['molc'])));
		$alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['id']));
		$sql = "UPDATE ec_daily_allowances SET lodging_allowances_a1='$amt1',lodging_allowances_a='$amt2',lodging_allowances_b='$amt3',lodging_allowances_c='$amt4',boarding_allowances_a1='$amt5',boarding_allowances_a='$amt6',boarding_allowances_b='$amt7',boarding_allowances_c='$amt8',mode_of_travel='$mot',mode_of_conveyance='$molc',mobile_roaming='$amt9' WHERE allowance_alias='$alias'";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Updated successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Error: Try Again</p>";
		$mr_con->close();
	}
	if(file_exists('editallowances.php')){include('editallowances.php');}
}
if(isset($_REQUEST['ref']) && $_REQUEST['ref']=='editapprovals'){
	$ref='editapprovals';
	if($_REQUEST['dep']=='0'){$message="<p class='alert alert-danger' role='alert'>Select Department</p>";}
	else if($_REQUEST['aemp']=='0'){$message="<p class='alert alert-danger' role='alert'>Select Employee</p>";}
	else{	
		$dep=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['dep']));
		$molc=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['aemp']));
		$alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['id']));
		$sql="UPDATE ec_expense_approvals SET approver='$molc', approver_dep='$dep' WHERE approval_alias='$alias'";
		if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Updated successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Error: Try Again</p>";
		$mr_con->close();
	}
	if(file_exists('editapprovals.php')){include('editapprovals.php');}
}
if(isset($_REQUEST['ref']) && $_REQUEST['ref']=='editAdvance'){
	$ref='editAdvance';
	if($_REQUEST['advRequested']==''){$message="<p class='alert alert-danger' role='alert'>Enter Current Request (amt)</p>";}
	else{	
		$advRequested=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['advRequested']));
		$alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['id']));
		$old_ra=alias($alias,"ec_advances","advance_alias","request_amount");
		$old_aa=alias($alias,"ec_advances","advance_alias","total_amount");
		if($old_aa=='0') $ta=$advRequested-$old_ra;
		else $ta=$advRequested-($old_ra-$old_aa);
		$sql="UPDATE ec_advances SET request_amount='$advRequested', total_amount='$ta' WHERE advance_alias='$alias'";
		if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Updated successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Error: Try Again</p>";
		$mr_con->close();
	}
	if(file_exists('editAdvance.php')){include('editAdvance.php');}
}
if(isset($_REQUEST['ref']) && $_REQUEST['ref']=='editExpense'){
	$ref='editExpense';
		if(isset($_REQUEST['texp'])){
			if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['visitFromDate'])){$message="<p class='alert alert-danger' role='alert'>Select Visit from Date</p>";}
			else if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['visitToDate'])){$message="<p class='alert alert-danger' role='alert'>Select Visit to Date</p>";}
			else if($_REQUEST['placesOfVisit']==""){$message="<p class='alert alert-danger' role='alert'>Enter Places Of Visit</p>";}
			else if($_REQUEST['purpose']==""){$message="<p class='alert alert-danger' role='alert'>Enter Purpose</p>";}
			else if(filter_var($_REQUEST['texp'], FILTER_VALIDATE_INT) == false){$message="<p class='alert alert-danger' role='alert'>Enter Total Amount</p>";}
			else{
				$empalias=$_SESSION['ec_admin_alias'];
				$visitFromDate=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['visitFromDate']))));
				$visitToDate=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['visitToDate']))));
				$placesOfVisit=$_REQUEST['placesOfVisit'];
				$purpose=$_REQUEST['purpose'];
				$texp=array_sum($_REQUEST['amt'])+array_sum($_REQUEST['amt_l'])+array_sum($_REQUEST['lamt'])+array_sum($_REQUEST['oamt'])+array_sum($_REQUEST['bamt']);
				$reqdate=date("Y-m-d");
				$alias=$_REQUEST['id'];
				
				//Conveience Starts
				for($i=0;$i<count($_REQUEST['idc']);$i++){
					$f1[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['idc'][$i]);
					$f2[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['dot'][$i])));
					$f3[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['mot'][$i]);
					$f4[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['from'][$i]);
					$f5[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['to'][$i]);
					$f6[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['amt'][$i]);
					if($f6[$i]!=""){
						if($f1[$i] !='0'){
							if($_FILES['motbill']['size'][$i]>0){
								$ext = pathinfo($_FILES['motbill']['name'][$i], PATHINFO_EXTENSION);
								$fileName=$empalias.generateRandomString()."TC.".$ext;
								move_uploaded_file($_FILES["motbill"]["tmp_name"][$i],"../attachments/".$fileName);
								$profileimg = "attachments/".$fileName;
								if($_REQUEST['motbill_old'][$i]!=='0') unlink("../".$_REQUEST['motbill_old'][$i]);
							}else{
								if($_REQUEST['motbill_old'][$i]=='0') $profileimg =0;
								else $profileimg=$_REQUEST['motbill_old'][$i];
							}
								mysqli_query($mr_con,"UPDATE ec_conveyance SET 
									date_of_travel='".$f2[$i]."',
									mode_of_travel='".$f3[$i]."',
									from_place='".$f4[$i]."', 
									to_place='".$f5[$i]."', 
									amount='".$f6[$i]."', 
									document_link='".$profileimg."', 
									created_date='".$reqdate."' 
									WHERE alias='".$f1[$i]."'");						
						}else{
							$alias1=aliasCheck(generateRandomString(),"ec_conveyance","alias",$mr_con);
							if($_FILES['motbill']['size'][$i]>0){
								$ext = pathinfo($_FILES['motbill']['name'][$i], PATHINFO_EXTENSION);
								$fileName=$empalias.generateRandomString()."TC.".$ext;
								move_uploaded_file($_FILES["motbill"]["tmp_name"][$i],"../attachments/".$fileName);
								$profileimg = "attachments/".$fileName;
							}else $profileimg =0;
							mysqli_query($mr_con,"INSERT INTO ec_conveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,document_link,created_date) VALUES('$alias','$f2[$i]','$f3[$i]','$f4[$i]','$f5[$i]','$f6[$i]','$alias1','$profileimg','$reqdate')");
						}
					}
				}
				//Conveience Ends
				//Local Conveience Starts

				for($i=0;$i<count($_REQUEST['idc_l']);$i++){
					$f1[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['idc_l'][$i]);
					$f2[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['dot_l'][$i])));
					$f3[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['mot_l'][$i]);
					$f4[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['from_l'][$i]);
					$f5[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['to_l'][$i]);
					$f6[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['amt_l'][$i]);
					if($f6[$i]!=""){
						if($f1[$i] !='0'){
							mysqli_query($mr_con,"UPDATE ec_localconveyance SET date_of_travel='".$f2[$i]."', mode_of_travel='".$f3[$i]."', from_place='".$f4[$i]."', to_place='".$f5[$i]."', amount='".$f6[$i]."', created_date='$reqdate' WHERE alias='".$f1[$i]."'");
						}else{
							$alias1=aliasCheck(generateRandomString(),"ec_localconveyance","alias",$mr_con);
							mysqli_query($mr_con,"INSERT INTO ec_localconveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,created_date) VALUES('$alias','".$f2[$i]."','".$f3[$i]."','".$f4[$i]."','".$f5[$i]."','".$f6[$i]."','$alias1','$reqdate')");
						}
					}
				}
				//Local Conveience Ends
				//Lodging Starts
				for($i=0;$i<count($_REQUEST['idl']);$i++){
					$f1[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['idl'][$i]);
					$f2[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['checkin'][$i])));
					$f3[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['checkout'][$i])));
					$f4[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['typeofstay'][$i]);
					$f5[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['hotelName'][$i]);
					$f6[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['lamt'][$i]);
					if($f6[$i]!=""){
						if($f1[$i] !='0'){
							if($_FILES['lfile']['size'][$i]>0){
								$ext = pathinfo($_FILES['lfile']['name'][$i], PATHINFO_EXTENSION);
								$fileName=$empalias.generateRandomString()."TL.".$ext;
								move_uploaded_file($_FILES["lfile"]["tmp_name"][$i],"../attachments/".$fileName);
								$profileimg = "attachments/".$fileName;
								if($_REQUEST['lfile_old'][$i]!=='0') unlink("../".$_REQUEST['lfile_old'][$i]);
							}else{
								if($_REQUEST['lfile_old'][$i]=='0') $profileimg =0;
								else $profileimg=$_REQUEST['lfile_old'][$i];
							}
							mysqli_query($mr_con,"UPDATE ec_lodging SET check_in='".$f2[$i]."',
								check_out='".$f3[$i]."',
								type_of_stay='".$f4[$i]."', 
								hotel_name='".$f5[$i]."', 
								amount='".$f6[$i]."', 
								document_link='$profileimg', 
								created_date='$reqdate' 
								WHERE alias='".$f1[$i]."'");
						}else{
							$alias1=aliasCheck(generateRandomString(),"ec_lodging","alias",$mr_con);
							if($_FILES['lfile']['size'][$i]>0){
								$ext = pathinfo($_FILES['lfile']['name'][$i], PATHINFO_EXTENSION);
								$fileName=$empalias.generateRandomString()."TL.".$ext;
								move_uploaded_file($_FILES["lfile"]["tmp_name"][$i],"../attachments/".$fileName);
								$profileimg = "attachments/".$fileName;
							}else $profileimg =0;
							mysqli_query($mr_con,"INSERT INTO ec_lodging(check_in,check_out,type_of_stay,hotel_name,amount,expenses_alias,alias,document_link,created_date) VALUES('".$f2[$i]."','".$f3[$i]."','".$f4[$i]."','".$f5[$i]."','".$f6[$i]."','$alias','$alias1','$profileimg','$reqdate')");
						}
					}
				}
				//Lodging Ends
				//Boarding Starts
				for($i=0;$i<count($_REQUEST['idb']);$i++){
					$f1[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['idb'][$i]);
					$f2[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['checkin'][$i])));
					$f3[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['checkout'][$i])));
					$f4[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state'][$i]);
					$f5[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['bamt'][$i]);
					if($f5[$i]!=""){
						if($f1[$i] !='0'){
							mysqli_query($mr_con,"UPDATE ec_boarding SET check_in='".$f2[$i]."',

								check_out='".$f3[$i]."',
								state='".$f4[$i]."', 
								amount='".$f5[$i]."',
								created_date='$reqdate' 
								WHERE alias='".$f1[$i]."'");
						}else{
							$alias1=aliasCheck(generateRandomString(),"ec_boarding","alias",$mr_con);
							mysqli_query($mr_con,"INSERT INTO ec_boarding(check_in,check_out,state,amount,expenses_alias,alias,created_date) VALUES('".$f2[$i]."','".$f3[$i]."','".$f4[$i]."','".$f5[$i]."','$alias','$alias1','$reqdate')");
						}
					}
				}
				//Boarding Ends
				//Others Starts
				for($i=0;$i<count($_REQUEST['ido']);$i++){
					$f1[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['ido'][$i]);
					$f2[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['odate'][$i])));
					$f3[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['others'][$i]);
					$f6[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['oamt'][$i]);
					if($f6[$i]!=""){
						if($f1[$i] != '0'){
							if($_FILES['ofile']['size'][$i]>0){
								$ext = pathinfo($_FILES['ofile']['name'][$i], PATHINFO_EXTENSION);
								$fileName=$empalias.generateRandomString()."TO.".$ext;
								move_uploaded_file($_FILES["ofile"]["tmp_name"][$i],"../attachments/".$fileName);
								$profileimg = "attachments/".$fileName;
								if($_REQUEST['ofile_old'][$i]!=='0') unlink("../".$_REQUEST['ofile_old'][$i]);
							}else{
								if($_REQUEST['ofile_old'][$i]=='0') $profileimg =0;
								else $profileimg=$_REQUEST['ofile_old'][$i];
							}
							mysqli_query($mr_con,"UPDATE ec_other_expenses SET checked_date='".$f2[$i]."',
									description='".$f3[$i]."',
									amount='".$f6[$i]."', 
									document_link='$profileimg', 
									created_date='$reqdate' 
									WHERE alias='".$f1[$i]."'");
						}else{
							$alias1=aliasCheck(generateRandomString(),"ec_other_expenses","alias",$mr_con);
							if($_FILES['ofile']['size'][$i]>0){
								$ext = pathinfo($_FILES['ofile']['name'][$i], PATHINFO_EXTENSION);
								$fileName=$empalias.generateRandomString()."TO.".$ext;
								move_uploaded_file($_FILES["ofile"]["tmp_name"][$i],"../attachments/".$fileName);
								$profileimg = "attachments/".$fileName;
							}else $profileimg =0;
							mysqli_query($mr_con,"INSERT INTO ec_other_expenses(checked_date, description, amount, expenses_alias, alias, document_link, created_date) VALUES('".$f2[$i]."','".$f3[$i]."','".$f6[$i]."','$alias','$alias1','$profileimg','$reqdate')");
						}
					}
				}
				//Others Ends
				$sql="UPDATE ec_expenses SET period_of_visit_from='$visitFromDate', period_of_visit_to='$visitToDate', places_of_visit='$placesOfVisit', purpose='$purpose', total_tour_expenses='$texp' WHERE expenses_alias='$alias'";
				if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Expense Updated successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Request Failed</p>";
				$mr_con->close();

			}
		}
	if(file_exists('editExpense.php')){include('editExpense.php');}

}

/* start- Edit service allowance */
if(isset($_REQUEST['ref']) && $_REQUEST['ref']=='editserallowances'){
	$ref='editserallowances';
	if(!isset($_REQUEST['zone'])&&$_REQUEST['zone']==0){
		$mess="<p class='alert alert-danger' role='alert'>Select Zone</p>";;
		}else if(!isset($_REQUEST['state'])&&$_REQUEST['state']==0){$mess="<p class='alert alert-danger' role='alert'>Select State</p>";}
		else if(!isset($_REQUEST['district'])&&$_REQUEST['district']==0){$mess="<p class='alert alert-danger' role='alert'>Select District</p>";}
		else if($_REQUEST['lodging_amount']==""){$mess="<p class='alert alert-danger' role='alert'>Enter Lodging Amount</p>";}
		else if($_REQUEST['daily_allowance']==""){$mess="<p class='alert alert-danger' role='alert'>Enter Daily Allowance</p>";}
		else if($_REQUEST['local_conveyance']==""){$mess="<p class='alert alert-danger' role='alert'>Enter Local Conveyance</p>";}
	else{
		$zone=$_REQUEST['zone'];
		$state=$_REQUEST['state'];
		$dsitrict=$_REQUEST['district'];
		$lodging_amt=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['lodging_amount']));
		$daily_allowance=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['daily_allowance']));
		$local_conveyance=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['local_conveyance']));
		$alias=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['id']));
		
		$ck_sql = mysqli_query($mr_con,"SELECT id FROM ec_service_allowances WHERE zone_alias = '".$zone."' AND state_alias = '".$state."' AND district_alias = '".$dsitrict."' AND service_allowance_alias <> '$alias'");
		$scnt = mysqli_num_rows($ck_sql);
		$message = "SELECT id FROM ec_service_allowances WHERE zone_alias = '".$zone."' AND state_alias = '".$state."' AND district_alias = '".$dsitrict."' AND service_allowance_alias <> '$alias'";
		if($scnt == 0) {
		$sql = "UPDATE ec_service_allowances SET zone_alias='$zone',state_alias='$state',district_alias='$dsitrict',lodging_amount='$lodging_amt',daily_allowance='$daily_allowance',local_conveyance='$local_conveyance' WHERE service_allowance_alias='$alias'";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Updated successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Error: Try Again</p>";
		$mr_con->close();
		} else {
			$message="<p class='alert alert-danger' role='alert'>Already exist</p>";
		}
	}
	if(file_exists('editserallowances.php')){include('editserallowances.php');}
}
/* End - Edit service allowance */

if(isset($_REQUEST['ref']) && $_REQUEST['ref']=='serEditExpense'){
	$ref='serEditExpense';
	if(isset($_REQUEST['texp'])){
		if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['visitFromDate'])){$message="<p class='alert alert-danger' role='alert'>Select Visit from Date</p>";}
		else if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['visitToDate'])){$message="<p class='alert alert-danger' role='alert'>Select Visit to Date</p>";}
		else if($_REQUEST['placesOfVisit']==""){$message="<p class='alert alert-danger' role='alert'>Enter Places Of Visit</p>";}
		else if($_REQUEST['purpose']==""){$message="<p class='alert alert-danger' role='alert'>Enter Purpose</p>";}
		else if(filter_var($_REQUEST['texp'], FILTER_VALIDATE_INT) == false){$message="<p class='alert alert-danger' role='alert'>Enter Total Amount</p>";}
		else{
			$empalias=$_SESSION['ec_admin_alias'];
			$visitFromDate=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['visitFromDate']))));
			$visitToDate=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['visitToDate']))));
			$placesOfVisit=$_REQUEST['placesOfVisit'];
			$purpose=$_REQUEST['purpose'];
			$texp=array_sum($_REQUEST['amt'])+array_sum($_REQUEST['amt_l'])+array_sum($_REQUEST['lamt'])+array_sum($_REQUEST['bamt'])+array_sum($_REQUEST['oamt']);
			$reqdate=date("Y-m-d");
			$alias=$_REQUEST['id'];
			//Conveience Starts
			for($i=0;$i<count($_REQUEST['idc']);$i++){
				$f1[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['idc'][$i]);
				$f2[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['dot'][$i])));
				$f3[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['mot'][$i]);
				$f4[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['from'][$i]);
				$f5[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['to'][$i]);
				$f6[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['amt'][$i]);
				$f7[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['cdprno'][$i]);
				$f8[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['cticket_id'][$i]);
				if($f6[$i]!=""){
					if($f1[$i] !='0'){
						if($_FILES['motbill']['size'][$i]>0){
							$ext = pathinfo($_FILES['motbill']['name'][$i], PATHINFO_EXTENSION);
							$fileName=$empalias.generateRandomString()."TC.".$ext;
							$move = move_uploaded_file($_FILES["motbill"]["tmp_name"][$i],"../attachments/".$fileName);
							if($move){
								$profileimg = "attachments/".$fileName;
								if($_REQUEST['motbill_old'][$i]!=='0') unlink($_REQUEST['motbill_old'][$i]);
							}else{$profileimg = "";}
						}else{
							if($_REQUEST['motbill_old'][$i]=='0') $profileimg =0;
							else $profileimg=$_REQUEST['motbill_old'][$i];
						}
							mysqli_query($mr_con,"UPDATE ec_conveyance SET 
								date_of_travel='".$f2[$i]."',
								mode_of_travel='".$f3[$i]."',
								from_place='".$f4[$i]."', 
								to_place='".$f5[$i]."', 
								amount='".$f6[$i]."', 
								document_link='".$profileimg."',
								dpr_number='".$f7[$i]."',
								ticket_alias='".$f8[$i]."',
								created_date='".$reqdate."' 
								WHERE alias='".$f1[$i]."'");						
					}else{
						$alias1=aliasCheck(generateRandomString(),"ec_conveyance","alias",$mr_con);
						if($_FILES['motbill']['size'][$i]>0){
							$ext = pathinfo($_FILES['motbill']['name'][$i], PATHINFO_EXTENSION);
							$fileName=$empalias.generateRandomString()."TC.".$ext;
							move_uploaded_file($_FILES["motbill"]["tmp_name"][$i],"../attachments/".$fileName);
							$profileimg = "attachments/".$fileName;
						}else $profileimg =0;
						mysqli_query($mr_con,"INSERT INTO ec_conveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,document_link,created_date,dpr_number,ticket_alias) VALUES('$alias','$f2[$i]','$f3[$i]','$f4[$i]','$f5[$i]','$f6[$i]','$alias1','$profileimg','$reqdate','$f7[$i]','$f8[$i]')");
					}
				}
			}
			//Conveience Ends
			//Local Conveience Starts
			for($i=0;$i<count($_REQUEST['idc_l']);$i++){
				$f1[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['idc_l'][$i]);
				$f2[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['dot_l'][$i])));
				$f3[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['mot_l'][$i]);
				$f4[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['from_l'][$i]);
				$f5[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['to_l'][$i]);
				$f6[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['amt_l'][$i]);
				$f7[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['zone_l'][$i]);
				$f8[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state_l'][$i]);
				$f9[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['district_l'][$i]);
				$f10[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['area_l'][$i]);
				$f11[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['bucket'][$i]);
				if($f11[$i] == 0){
					$f12[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['cap'][$i]);
					$f13[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['wofCell'][$i]);
					$f14[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['quantityCell'][$i]);
					$f15[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['numKilometers'][$i]);
				} else {
					$f12[$i]='';
					$f13[$i]='';
					$f14[$i]='';
					$f15[$i]='';
				}
				$f16[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['dprNum_l'][$i]);
				$f17[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['ticket_idl'][$i]);
				if($f6[$i]!=""){
					if($f1[$i] !='0'){
						$chkk = mysqli_query($mr_con,"SELECT count(l.id) as cnt FROM ec_localconveyance l, ec_expenses e WHERE l.expenses_alias = e.expenses_alias and e.employee_alias = '".$empalias."' and l.bucket = '".$f11[$i]."' and l.date_of_travel='".$f2[$i]."' and l.alias!='".$f1[$i]."'");
						$chkk_rs = mysqli_fetch_array($chkk);
						if($chkk_rs['cnt']==0){
						mysqli_query($mr_con,"UPDATE ec_localconveyance SET date_of_travel='".$f2[$i]."', mode_of_travel='".$f3[$i]."', from_place='".$f4[$i]."', to_place='".$f5[$i]."', amount='".$f6[$i]."', created_date='$reqdate', zone_alias='".$f7[$i]."', state_alias='".$f8[$i]."', district_alias='".$f9[$i]."', bucket='".$f11[$i]."', capacity='".$f12[$i]."', quantity='".$f14[$i]."', km='".$f15[$i]."',dpr_number='".$f16[$i]."',ticket_alias='".$f17[$i]."'
						 WHERE alias='".$f1[$i]."'");
						}
					}else{
						$chk = mysqli_query($mr_con,"SELECT count(l.id) as cnt FROM ec_localconveyance l, ec_expenses e WHERE l.expenses_alias = e.expenses_alias and e.employee_alias = '".$empalias."' and l.bucket = '".$f11[$i]."' and l.date_of_travel='".$f2[$i]."'");
						$chk_rs = mysqli_fetch_array($chk);
						if($chk_rs['cnt']==0){
							$alias1=aliasCheck(generateRandomString(),"ec_localconveyance","alias",$mr_con);
							mysqli_query($mr_con,"INSERT INTO ec_localconveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,created_date,zone_alias,state_alias,district_alias,bucket,capacity,quantity,km,dpr_number,ticket_alias
							) VALUES('$alias','".$f2[$i]."','".$f3[$i]."','".$f4[$i]."','".$f5[$i]."','".$f6[$i]."','$alias1','$reqdate','".$f7[$i]."','".$f8[$i]."','".$f9[$i]."','".$f11[$i]."','".$f12[$i]."','".$f14[$i]."','".$f15[$i]."','".$f16[$i]."','".$f17[$i]."')");
						}
					}
				}
			}
			//Local Conveience Ends
			//Lodging Starts
			for($i=0;$i<count($_REQUEST['idl']);$i++){
				$f1[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['idl'][$i]);
				$f2[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['checkin'][$i])));
				$f3[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['checkout'][$i])));
				$f4[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['typeofstay'][$i]);
				$f5[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['hotelName'][$i]);
				$f6[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['lamt'][$i]);
				$f7[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['zone_ld'][$i]);
				$f8[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state_ld'][$i]);
				$f9[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['district_ld'][$i]);
				$f10[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['dprNum_ld'][$i]);
				$f11[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['ticket_idld'][$i]);
				$profileimg =0;
				if($f6[$i]!=""){
					if($f1[$i] !='0'){
						mysqli_query($mr_con,"UPDATE ec_lodging SET check_in='".$f2[$i]."',
							check_out='".$f3[$i]."',
							type_of_stay='".$f4[$i]."', 
							hotel_name='".$f5[$i]."', 
							amount='".$f6[$i]."', 
							document_link='$profileimg', 
							created_date='$reqdate', 
							zone_alias='".$f7[$i]."', 
							state_alias='".$f8[$i]."', 
							district_alias='".$f9[$i]."', 
							dpr_number='".$f10[$i]."',
							ticket_alias='".$f11[$i]."'
							WHERE alias='".$f1[$i]."'");
					}else{
						$alias1=aliasCheck(generateRandomString(),"ec_lodging","alias",$mr_con);
						mysqli_query($mr_con,"INSERT INTO ec_lodging(check_in,check_out,type_of_stay,hotel_name,amount,expenses_alias,alias,document_link,created_date,zone_alias,state_alias,district_alias,dpr_number,ticket_alias) VALUES('".$f2[$i]."','".$f3[$i]."','".$f4[$i]."','".$f5[$i]."','".$f6[$i]."','$alias','$alias1','$profileimg','$reqdate','".$f7[$i]."','".$f8[$i]."','".$f9[$i]."','".$f10[$i]."','".$f11[$i]."')");
					}
				}
			}
			//Lodging Ends
			//Boarding Starts
			for($i=0;$i<count($_REQUEST['idb']);$i++){
				$f1[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['idb'][$i]);
				$f2[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['checkinb'][$i])));
				$f3[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['checkoutb'][$i])));
				$f4[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state'][$i]);
				$f5[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['bamt'][$i]);
				$f6[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['zone_bo'][$i]);
				$f7[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state_bo'][$i]);
				$f8[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['district_bo'][$i]);
				$f9[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['dprNum_bo'][$i]);
				$f10[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['ticket_bo'][$i]);
				if($f5[$i]!=""){
					if($f1[$i] !='0'){
						mysqli_query($mr_con,"UPDATE ec_boarding SET check_in='".$f2[$i]."',
							check_out='".$f3[$i]."',
							state='".$f4[$i]."', 
							amount='".$f5[$i]."',
							created_date='$reqdate', zone_alias='".$f6[$i]."', state_alias='".$f7[$i]."', district_alias='".$f8[$i]."', dpr_number='".$f9[$i]."',ticket_alias='".$f10[$i]."' 
							WHERE alias='".$f1[$i]."'");
					}else{
						$alias1=aliasCheck(generateRandomString(),"ec_boarding","alias",$mr_con);
						mysqli_query($mr_con,"INSERT INTO ec_boarding(check_in,check_out,state,amount,expenses_alias,alias,created_date,zone_alias,state_alias,district_alias,dpr_number,ticket_alias) VALUES('".$f2[$i]."','".$f3[$i]."','".$f4[$i]."','".$f5[$i]."','$alias','$alias1','$reqdate','".$f6[$i]."','".$f7[$i]."','".$f8[$i]."','".$f9[$i]."','".$f10[$i]."')");
					}
				}
			}
			//Boarding Ends
			//Others Starts
			for($i=0;$i<count($_REQUEST['ido']);$i++){
				$f1[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['ido'][$i]);
				$f2[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['odate'][$i])));
				$f3[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['others'][$i]);
				$f6[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['oamt'][$i]);
				$f7[$i]=mysql_escape_string($_REQUEST['dprNum_ot'][$i]);
				$f8[$i]=mysql_escape_string($_REQUEST['ticket_ot'][$i]);
				if($f6[$i]!=""){
					if($f1[$i] != '0'){
						if($_FILES['ofile']['size'][$i]>0){
							$ext = pathinfo($_FILES['ofile']['name'][$i], PATHINFO_EXTENSION);
							$fileName=$empalias.generateRandomString()."TO.".$ext;
							move_uploaded_file($_FILES["ofile"]["tmp_name"][$i],"../attachments/".$fileName);
							$profileimg = "attachments/".$fileName;
							if($_REQUEST['ofile_old'][$i]!=='0') unlink($_REQUEST['ofile_old'][$i]);
						}else{
							if($_REQUEST['ofile_old'][$i]=='0') $profileimg =0;
							else $profileimg=$_REQUEST['ofile_old'][$i];
						}
						mysqli_query($mr_con,"UPDATE ec_other_expenses SET checked_date='".$f2[$i]."',
								description='".$f3[$i]."',
								amount='".$f6[$i]."', 
								document_link='$profileimg', 
								created_date='$reqdate', dpr_number='".$f7[$i]."',ticket_alias='".$f8[$i]."' 
								WHERE alias='".$f1[$i]."'");
					}else{
						$alias1=aliasCheck(generateRandomString(),"ec_other_expenses","alias",$mr_con);
						if($_FILES['ofile']['size'][$i]>0){
							$ext = pathinfo($_FILES['ofile']['name'][$i], PATHINFO_EXTENSION);
							$fileName=$empalias.generateRandomString()."TO.".$ext;
							move_uploaded_file($_FILES["ofile"]["tmp_name"][$i],"../attachments/".$fileName);
							$profileimg = "attachments/".$fileName;
						}else $profileimg =0;
						mysqli_query($mr_con,"INSERT INTO ec_other_expenses(checked_date, description, amount, expenses_alias, alias, document_link, created_date,dpr_number,ticket_alias) VALUES('".$f2[$i]."','".$f3[$i]."','".$f6[$i]."','$alias','$alias1','$profileimg','$reqdate','".$f7[$i]."','".$f8[$i]."')");
					}
				}
			}
			//Others Ends
				$sql="UPDATE ec_expenses SET period_of_visit_from='$visitFromDate', period_of_visit_to='$visitToDate', places_of_visit='$placesOfVisit', purpose='$purpose', total_tour_expenses='$texp' WHERE expenses_alias='$alias'";
				if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Expense Updated successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Request Failed</p>";
				$mr_con->close();
	
		}
	}
	if(file_exists('serEditExpense.php')){include('serEditExpense.php');}

}


?>