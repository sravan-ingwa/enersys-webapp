<?php
session_start();
include('../functions.php');
if(isset($_REQUEST['ref']) && $_REQUEST['ref']=='editAdvance'){
	if($_REQUEST['ref2']=='0'){
			$ref='viewadvance';
			$alias=$_REQUEST['id'];
			$reqAmt=mysqli_real_escape_string($mr_con,$_REQUEST['advRequested']);
			$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
			$reqdate=date("Y-m-d");
			$levelx=expenseApprovalLevels($_SESSION['ec_user_alias']);
			switch ($levelx){
				case '1': $level=2;break;
				case '2': $level=2;break;
				case '3': $level=5;break;
				case '4': $level=5;break;
				case '5': $level=6;break;
				default : $level=1;break;
			}
			if($_FILES['tplanningreport']['size']>0){
				$ext = pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION);
				$fileName=$empalias.generateRandomString()."ADV.".$ext;
				move_uploaded_file($_FILES["tplanningreport"]["tmp_name"],"../attachments/tourReport/".$fileName);
				$profileimg = "attachments/tourReport/".$fileName;
				if($_REQUEST['tplanningreport_old']!=='0' && $_REQUEST['tplanningreport_old']!=='') unlink("../".$_REQUEST['tplanningreport_old']);
			}else{
				if($_REQUEST['tplanningreport_old']=='0')$profileimg=0;
				else $profileimg=$_REQUEST['tplanningreport_old'];
			}
			$sql="UPDATE ec_advances SET request_amount='$reqAmt',total_amount='$reqAmt',requested_date='$reqdate',approval_level='$level',report='$profileimg' WHERE advance_alias='$alias'";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Advance Request successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Advance Request Failed</p>";
			$mr_con->query("UPDATE ec_remarks SET remarks='$reasonForAdv',remarked_on='".date("Y-m-d H:i:s")."' WHERE item_alias='$alias'");
			if(file_exists('viewadvance.php')){include('viewadvance.php');}
			$url="http://enersyscare.co.in/enersys_expense/maillings/book_advance.php?ref=".$alias;
			file_get_contents($url);
	}
	if($_REQUEST['ref2']=='1'){
			$empalias=$_SESSION['ec_user_alias'];
			$ref='viewadvance';
			$alias=$_REQUEST['id'];
			$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
			$reqdate=date("Y-m-d");
			$advet=advancefullView($alias);
			$advanceNotSettled=advanceNotSettled($advet[0]['employee_alias']);				
			$advanceLimit=advancelimit($advet[0]['employee_alias']);
			//if($advanceNotSettled>$advanceLimit)$limit=2;
			if(($advet[0]['request_amount']+$advanceNotSettled)>$advanceLimit)$limit=2;
			else $limit =6;
			$sql="UPDATE ec_advances SET approval_level='$limit',approved_by='$empalias',approved_date='$reqdate' WHERE advance_alias='$alias'";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Approved successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Approval Failed</p>";
			$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
			if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BA','$alias','$empalias','$alias_remark')");
			if(file_exists('viewadvance.php')){include('viewadvance.php');}
			$url="http://enersyscare.co.in/enersys_expense/maillings/book_advance.php?ref=".$alias;
			file_get_contents($url);

	}
	if($_REQUEST['ref2']=='2'){
			$empalias=$_SESSION['ec_user_alias'];
			$ref='viewadvance';
			$alias=$_REQUEST['id'];
			$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
			$reqdate=date("Y-m-d");

			$advet=advancefullView($alias);
			$advanceNotSettled=advanceNotSettled($advet[0]['employee_alias']);				
			$advanceLimit=advancelimit($advet[0]['employee_alias']);
			$emplevel=expenseApprovalLevels($advet[0]['employee_alias']);
			if($emplevel==0)$limit=4;
			else if($advanceNotSettled>$advanceLimit && $emplevel!=0)$limit=5;
			else if($advet[0]['request_amount']>$advanceLimit && $emplevel!=0)$limit=5;
			else $limit =6;
			$approved_by=advancedetlimited('approved_by',$alias)."|".$empalias;
			$approved_date=advancedetlimited('approved_date',$alias)."|".$reqdate;
			$sql="UPDATE ec_advances SET approval_level='$limit',approved_by='$approved_by',approved_date='$approved_date' WHERE advance_alias='$alias'";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Approved successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Approval Failed</p>";
			$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
			if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BA','$alias','$empalias','$alias_remark')");
			if(file_exists('viewadvance.php')){include('viewadvance.php');}
			$url="http://enersyscare.co.in/enersys_expense/maillings/book_advance.php?ref=".$alias;
			file_get_contents($url);
	}
	if($_REQUEST['ref2']=='4'){
			$empalias=$_SESSION['ec_user_alias'];
			$ref='viewadvance';
			$alias=$_REQUEST['id'];
			$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
			$reqdate=date("Y-m-d");
			$limit =6;
			$approved_by=advancedetlimited('approved_by',$alias)."|".$empalias;
			$approved_date=advancedetlimited('approved_date',$alias)."|".$reqdate;
			$sql="UPDATE ec_advances SET approval_level='$limit',approved_by='$approved_by',approved_date='$approved_date' WHERE advance_alias='$alias'";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Approved successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Approval Failed</p>";
			$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
			if($reasonForAdv!='')$mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BA','$alias','$empalias','$alias_remark')");
			if(file_exists('viewadvance.php')){include('viewadvance.php');}
			$url="http://enersyscare.co.in/enersys_expense/maillings/book_advance.php?ref=".$alias;
			file_get_contents($url);
	}
	if($_REQUEST['ref2']=='5'){
			$empalias=$_SESSION['ec_user_alias'];
			$ref='viewadvance';
			$alias=$_REQUEST['id'];
			$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
			$reqdate=date("Y-m-d");
			$limit =6;
			$approved_by=advancedetlimited('approved_by',$alias)."|".$empalias;
			$approved_date=advancedetlimited('approved_date',$alias)."|".$reqdate;
			$sql="UPDATE ec_advances SET approval_level='$limit',approved_by='$approved_by',approved_date='$approved_date' WHERE advance_alias='$alias'";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Approved successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Approval Failed</p>";
			$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
			if($reasonForAdv!='')$mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BA','$alias','$empalias','$alias_remark')");
			if(file_exists('viewadvance.php')){include('viewadvance.php');}
			$url="http://enersyscare.co.in/enersys_expense/maillings/book_advance.php?ref=".$alias;
			file_get_contents($url);
	}
}
if(isset($_REQUEST['ref']) && $_REQUEST['ref']=='editExpense'){
	$ref='viewexpense';
	if($_REQUEST['ref2']=='0' || $_REQUEST['ref2']=='8'){
		if(isset($_REQUEST['texp'])){
			if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['visitFromDate'])){$message="<p class='alert alert-danger' role='alert'>Select Visit from Date</p>";}
			else if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['visitToDate'])){$message="<p class='alert alert-danger' role='alert'>Select Visit to Date</p>";}
			else if(mysqli_real_escape_string($mr_con,$_REQUEST['placesOfVisit'])==""){$message="<p class='alert alert-danger' role='alert'>Enter Places Of Visit</p>";}
			else if(mysqli_real_escape_string($mr_con,$_REQUEST['purpose'])==""){$message="<p class='alert alert-danger' role='alert'>Enter Purpose</p>";}
			else if(filter_var($_REQUEST['texp'], FILTER_VALIDATE_INT) == false){$message="<p class='alert alert-danger' role='alert'>Enter Total Amount</p>";}
			else{
				$empalias=$_SESSION['ec_user_alias'];
				$visitFromDate=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['visitFromDate']))));
				$visitToDate=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['visitToDate']))));
				$placesOfVisit=mysqli_real_escape_string($mr_con,$_REQUEST['placesOfVisit']);
				$purpose=mysqli_real_escape_string($mr_con,$_REQUEST['purpose']);
				$texp=array_sum($_REQUEST['amt'])+array_sum($_REQUEST['amt_l'])+array_sum($_REQUEST['lamt'])+array_sum($_REQUEST['bamt'])+array_sum($_REQUEST['oamt']);
				$reqdate=date("Y-m-d");
				$alias=$_REQUEST['id'];
				$remarkss=mysqli_real_escape_string($mr_con,$_REQUEST['remarks']);
				$levelx=expenseApprovalLevels($_SESSION['ec_user_alias']);
				switch ($levelx){
					case '1': $level=2;break;
					case '2': $level=5;break;
					case '3': $level=5;break;
					case '4': $level=5;break;
					case '5': $level=3;break;
					default : $level=1;break;
				}
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
							$alias1=aliasCheck(generateRandomString(),"ec_conveyance","alias");
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
							$alias1=aliasCheck(generateRandomString(),"ec_localconveyance","alias");
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
							$alias1=aliasCheck(generateRandomString(),"ec_lodging","alias");
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
					$f2[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['checkinb'][$i])));
					$f3[$i]=date("Y-m-d", strtotime(mysqli_real_escape_string($mr_con,$_REQUEST['checkoutb'][$i])));
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
							$alias1=aliasCheck(generateRandomString(),"ec_boarding","alias");
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
							$alias1=aliasCheck(generateRandomString(),"ec_other_expenses","alias");
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

				if($_FILES['tplanningreport']['size']>0){
					$ext = pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION);
					$fileName=$empalias.generateRandomString()."EXP.".$ext;
					move_uploaded_file($_FILES["tplanningreport"]["tmp_name"],"../attachments/tourReport/".$fileName);
					$profileimg = "attachments/tourReport/".$fileName;
					if($_REQUEST['tplanningreport_old']!=='0' && $_REQUEST['tplanningreport_old']!=='') unlink("../".$_REQUEST['tplanningreport_old']);
				}else{
					if($_REQUEST['tplanningreport_old']=='0')$profileimg=0;
					else $profileimg=$_REQUEST['tplanningreport_old'];
				}

				$sql="UPDATE ec_expenses SET period_of_visit_from='$visitFromDate', period_of_visit_to='$visitToDate', places_of_visit='$placesOfVisit', purpose='$purpose', total_tour_expenses='$texp', requested_date='$reqdate', approval_level='$level',report='$profileimg' WHERE expenses_alias='$alias'";
				$mr_con->query("UPDATE ec_remarks SET remarks='$remarkss',remarked_on='".date("Y-m-d H:i:s")."' WHERE item_alias='$alias'");
				if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Expense Submitted successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Expense Request Failed</p>";
				$url="http://enersyscare.co.in/enersys_expense/maillings/book_expense.php?ref=".$alias;
				file_get_contents($url);
				$mr_con->close();

			}
		}
	}
	if($_REQUEST['ref2']=='1'){
			$empalias=$_SESSION['ec_user_alias'];
			$ref='viewexpense';
			$alias=$_REQUEST['id'];
			$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
			$reqdate=date("Y-m-d");
			$sql="UPDATE ec_expenses SET approval_level='3',approved_by='$empalias',approved_date='$reqdate' WHERE expenses_alias='$alias'";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Approved successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Approval Failed</p>";
			$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
			if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
			$url="http://enersyscare.co.in/enersys_expense/maillings/book_expense.php?ref=".$alias;
			file_get_contents($url);
	}
	if($_REQUEST['ref2']=='2'){
			$empalias=$_SESSION['ec_user_alias'];
			$ref='viewexpense';
			$alias=$_REQUEST['id'];
			$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
			$reqdate=date("Y-m-d");
			$approved_by=expensedetlimited('approved_by',$alias)."|".$empalias;
			$approved_date=expensedetlimited('approved_date',$alias)."|".$reqdate;
			$sql="UPDATE ec_expenses SET approval_level='3', approved_by='$approved_by',approved_date='$approved_date' WHERE expenses_alias='$alias'";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Approved successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Approval Failed</p>";
			$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
			if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
			$url="http://enersyscare.co.in/enersys_expense/maillings/book_expense.php?ref=".$alias;
			file_get_contents($url);
			}
	if($_REQUEST['ref2']=='3'){
			$empalias=$_SESSION['ec_user_alias'];
			$ref='viewexpense';
			$alias=$_REQUEST['id'];
			$po_gnr=$_REQUEST['po_gnr'];
			$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
			$reqdate=date("Y-m-d");
			$approved_by=expensedetlimited('approved_by',$alias)."|".$empalias;
			$approved_date=expensedetlimited('approved_date',$alias)."|".$reqdate;
			$sql="UPDATE ec_expenses SET approval_level='4',po_gnr='$po_gnr',approved_by='$approved_by',approved_date='$approved_date' WHERE expenses_alias='$alias'";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Approved successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Approval Failed</p>";
			$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
			if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
			$url="http://enersyscare.co.in/enersys_expense/maillings/book_expense.php?ref=".$alias;
			file_get_contents($url);
	}
	if($_REQUEST['ref2']=='4'){
			$empalias=$_SESSION['ec_user_alias'];
			$ref='viewexpense';
			$alias=$_REQUEST['id'];
			$rem_amt=mysqli_real_escape_string($mr_con,$_REQUEST['rem_amt']);
			$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
			$reqdate=date("Y-m-d");
			$approved_by=expensedetlimited('approved_by',$alias)."|".$empalias;
			$approved_date=expensedetlimited('approved_date',$alias)."|".$reqdate;
			$sql="UPDATE ec_expenses SET approval_level='6',approved_by='$approved_by',approved_date='$approved_date',reimbursement_amount='$rem_amt' WHERE expenses_alias='$alias'";
			if($mr_con->query($sql)===TRUE){
				$expense=alias($alias,'ec_expenses','expenses_alias','total_tour_expenses');
				$expense_emp_alias=alias($alias,'ec_expenses','expenses_alias','employee_alias');
				$rec=$mr_con->query("SELECT total_amount,advance_alias FROM ec_advances WHERE employee_alias='$expense_emp_alias' AND  approval_level='6' AND total_amount <>'0' AND flag=0 ORDER BY requested_date");
				if($rec->num_rows>0){$axs=0;
					while($row = $rec->fetch_assoc()){
						$advances[$axs]=$row['advance_alias'];
						$adv_amt[$axs]=$row['total_amount'];
					$axs++;}
					for($x=0;$x<count($advances);$x++){
						if($expense>'0'){
							if($adv_amt[$x]<'0'){
								$expense=$expense-$adv_amt[$x];
								$adv_amt[$x]=0;
								$query_advances="UPDATE ec_advances SET total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
							}
							else if(($adv_amt[$x]-$expense) >'0'){
								$expense1=$expense;
								$expense=$expense-$adv_amt[$x];
								$adv_amt[$x]=$adv_amt[$x]-$expense1;
								$query_advances="UPDATE ec_advances SET total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
							}
							else if(($adv_amt[$x]-$expense) =='0'){
								$expense=$expense-$adv_amt[$x];
								$adv_amt[$x]=0;
								$query_advances="UPDATE ec_advances SET total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
							}
							else{
								$expense1=$expense;
								$expense=$expense1-$adv_amt[$x];
								//$adv_amt[$x]=$adv_amt[$x]-$expense1;
								$adv_amt[$x]=0;
								$query_advances="UPDATE ec_advances SET total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
							}
							$mr_con->query($query_advances);
						}
					}
					/*if($expense>'0'){
						$x=count($advances)-1;
						$adv_amt[$x]=0-$expense;
						$query_advances="UPDATE ec_advances SET total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
						$mr_con->query($query_advances);
					}*/
				}else $asz=0;

				$message="<p class='alert alert-success' role='alert'>Approved successfully</p>";
			}else $message="<p class='alert alert-danger' role='alert'>Approval Failed</p>";
			$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
			if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
			$url="http://enersyscare.co.in/enersys_expense/maillings/book_expense.php?ref=".$alias;
			file_get_contents($url);
	}
	if($_REQUEST['ref2']=='5'){
			$empalias=$_SESSION['ec_user_alias'];
			$ref='viewexpense';
			$alias=$_REQUEST['id'];
			$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
			$reqdate=date("Y-m-d");
			$approved_by=expensedetlimited('approved_by',$alias)."|".$empalias;
			$approved_date=expensedetlimited('approved_date',$alias)."|".$reqdate;
			$sql="UPDATE ec_expenses SET approval_level='3',approved_by='$approved_by',approved_date='$approved_date' WHERE expenses_alias='$alias'";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Approved successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Approval Failed</p>";
			$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
			if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
			$url="http://enersyscare.co.in/enersys_expense/maillings/book_expense.php?ref=".$alias;
			file_get_contents($url);
	}
	if($_REQUEST['ref2']=='6'){
			$empalias=$_SESSION['ec_user_alias'];
			$ref='viewexpense';
			$alias=$_REQUEST['id'];
			$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
			$utr_num=$_REQUEST['utr_num'];
			$reqdate=date("Y-m-d");
			$sql="UPDATE ec_expenses SET utr_num='$utr_num' WHERE expenses_alias='$alias'";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Updated successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Update Failed</p>";
			$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
			if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
	}
	if(file_exists('viewexpense.php')){include('viewexpense.php');}

}

if(isset($_REQUEST['ref']) && $_REQUEST['ref']=='serEditExpense'){
	$ref='viewexpense';
	if($_REQUEST['ref2']=='0' || $_REQUEST['ref2']=='8'){
		if(isset($_REQUEST['texp'])){
			if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['visitFromDate'])){$message="<p class='alert alert-danger' role='alert'>Select Visit from Date</p>";}
			else if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['visitToDate'])){$message="<p class='alert alert-danger' role='alert'>Select Visit to Date</p>";}
			else if(mysqli_real_escape_string($mr_con,$_REQUEST['placesOfVisit'])==""){$message="<p class='alert alert-danger' role='alert'>Enter Places Of Visit</p>";}
			else if(mysqli_real_escape_string($mr_con,$_REQUEST['purpose'])==""){$message="<p class='alert alert-danger' role='alert'>Enter Purpose</p>";}
			else if(filter_var($_REQUEST['texp'], FILTER_VALIDATE_INT) == false){$message="<p class='alert alert-danger' role='alert'>Enter Total Amount</p>";}
			else{
				$empalias=$_SESSION['ec_user_alias'];
				$visitFromDate=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['visitFromDate']))));
				$visitToDate=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['visitToDate']))));
				$placesOfVisit=mysqli_real_escape_string($mr_con,$_REQUEST['placesOfVisit']);
				$purpose=mysqli_real_escape_string($mr_con,$_REQUEST['purpose']);
				$texp=array_sum($_REQUEST['amt'])+array_sum($_REQUEST['amt_l'])+array_sum($_REQUEST['lamt'])+array_sum($_REQUEST['bamt'])+array_sum($_REQUEST['oamt']);
				$reqdate=date("Y-m-d");
				$alias=$_REQUEST['id'];
				$remarkss=mysqli_real_escape_string($mr_con,$_REQUEST['remarks']);
				$levelx=expenseApprovalLevels($_SESSION['ec_user_alias']);
				switch ($levelx){
					case '1': $level=2;break;
					case '2': $level=5;break;
					case '3': $level=5;break;
					case '4': $level=5;break;
					case '5': $level=3;break;
					default : $level=1;break;
				}
				
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
							$move[$i]=move_uploaded_file($_FILES["motbill"]["tmp_name"][$i],"../attachments/".$fileName);
							$profileimg = "attachments/".$fileName;
							if($_REQUEST['motbill_old'][$i]!=='0') unlink("../".$_REQUEST['motbill_old'][$i]);
						}else{
							if($_REQUEST['motbill_old'][$i]=='0') $profileimg =0;
							else $profileimg=$_REQUEST['motbill_old'][$i];
							$move[$i]=TRUE;
						}
						if($move[$i]){
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
						}
					}else{
						$alias1=aliasCheck(generateRandomString(),"ec_conveyance","alias");
						if($_FILES['motbill']['size'][$i]>0){
							$ext = pathinfo($_FILES['motbill']['name'][$i], PATHINFO_EXTENSION);
							$fileName=$empalias.generateRandomString()."TC.".$ext;
							move_uploaded_file($_FILES["motbill"]["tmp_name"][$i],"../attachments/".$fileName);
							$profileimg = "attachments/".$fileName;
						}else {$profileimg =0;}
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
						$alias1=aliasCheck(generateRandomString(),"ec_localconveyance","alias");
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
						$alias1=aliasCheck(generateRandomString(),"ec_lodging","alias");
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
						$alias1=aliasCheck(generateRandomString(),"ec_boarding","alias");
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
				$f7[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['dprNum_ot'][$i]);
				$f8[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['ticket_ot'][$i]);
				if($f6[$i]!=""){
					if($f1[$i] != '0'){
						if($_FILES['ofile']['size'][$i]>0){
							$ext = pathinfo($_FILES['ofile']['name'][$i], PATHINFO_EXTENSION);
							$fileName=$empalias.generateRandomString()."TO.".$ext;
							$move[$i]=move_uploaded_file($_FILES["ofile"]["tmp_name"][$i],"../attachments/".$fileName);
							$profileimg = "attachments/".$fileName;
							if($_REQUEST['ofile_old'][$i]!=='0') unlink("../".$_REQUEST['ofile_old'][$i]);
						}else{
							if($_REQUEST['ofile_old'][$i]=='0') $profileimg =0;
							else $profileimg=$_REQUEST['ofile_old'][$i];
							$move[$i]=TRUE;
						}
						if($move[$i]){
							mysqli_query($mr_con,"UPDATE ec_other_expenses SET checked_date='".$f2[$i]."',
								description='".$f3[$i]."',
								amount='".$f6[$i]."', 
								document_link='$profileimg', 
								created_date='$reqdate', dpr_number='".$f7[$i]."',ticket_alias='".$f8[$i]."' 
								WHERE alias='".$f1[$i]."'");
						}
					}else{
						$alias1=aliasCheck(generateRandomString(),"ec_other_expenses","alias");
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
	
			if($_FILES['tplanningreport']['size']>0){
				$ext = pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION);
				$fileName=$empalias.generateRandomString()."EXP.".$ext;
				move_uploaded_file($_FILES["tplanningreport"]["tmp_name"],"../attachments/tourReport/".$fileName);
				$profileimg = "attachments/tourReport/".$fileName;
				if($_REQUEST['tplanningreport_old']!=='0' && $_REQUEST['tplanningreport_old']!=='') unlink("../".$_REQUEST['tplanningreport_old']);
			}else{
				if($_REQUEST['tplanningreport_old']=='0')$profileimg=0;
				else $profileimg=$_REQUEST['tplanningreport_old'];
			}

				$sql="UPDATE ec_expenses SET period_of_visit_from='$visitFromDate', period_of_visit_to='$visitToDate', places_of_visit='$placesOfVisit', purpose='$purpose', total_tour_expenses='$texp', requested_date='$reqdate', approval_level='$level',report='$profileimg' WHERE expenses_alias='$alias'";
				$mr_con->query("UPDATE ec_remarks SET remarks='$remarkss',remarked_on='".date("Y-m-d H:i:s")."' WHERE item_alias='$alias'");
				if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Expense Submitted successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Expense Request Failed</p>";
				$url="http://enersyscare.co.in/enersys_expense/maillings/book_expense.php?ref=".$alias;
				file_get_contents($url);
				$mr_con->close();

			}
		}
	}
	if($_REQUEST['ref2']=='1'){
			$empalias=$_SESSION['ec_user_alias'];
			$ref='viewexpense';
			$alias=$_REQUEST['id'];
			$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
			$reqdate=date("Y-m-d");
			$sql="UPDATE ec_expenses SET approval_level='3',approved_by='$empalias',approved_date='$reqdate' WHERE expenses_alias='$alias'";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Approved successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Approval Failed</p>";
			$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
			if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
			//$url="http://enersyscare.co.in/enersys_expense/maillings/book_expense.php?ref=".$alias;
			//file_get_contents($url);
	}
	if($_REQUEST['ref2']=='2'){
			$empalias=$_SESSION['ec_user_alias'];
			$ref='viewexpense';
			$alias=$_REQUEST['id'];
			$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
			$reqdate=date("Y-m-d");
			$approved_by=expensedetlimited('approved_by',$alias)."|".$empalias;
			$approved_date=expensedetlimited('approved_date',$alias)."|".$reqdate;
			$sql="UPDATE ec_expenses SET approval_level='3', approved_by='$approved_by',approved_date='$approved_date' WHERE expenses_alias='$alias'";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Approved successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Approval Failed</p>";
			$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
			if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
			//$url="http://enersyscare.co.in/enersys_expense/maillings/book_expense.php?ref=".$alias;
			//file_get_contents($url);
			}
	if($_REQUEST['ref2']=='3'){
			$empalias=$_SESSION['ec_user_alias'];
			$ref='viewexpense';
			$alias=$_REQUEST['id'];
			$po_gnr=$_REQUEST['po_gnr'];
			$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
			$reqdate=date("Y-m-d");
			$approved_by=expensedetlimited('approved_by',$alias)."|".$empalias;
			$approved_date=expensedetlimited('approved_date',$alias)."|".$reqdate;
			$sql="UPDATE ec_expenses SET approval_level='4',po_gnr='$po_gnr',approved_by='$approved_by',approved_date='$approved_date' WHERE expenses_alias='$alias'";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Approved successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Approval Failed</p>";
			$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
			if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
			//$url="http://enersyscare.co.in/enersys_expense/maillings/book_expense.php?ref=".$alias;
			//file_get_contents($url);
	}
	if($_REQUEST['ref2']=='4'){
			$empalias=$_SESSION['ec_user_alias'];
			$ref='viewexpense';
			$alias=$_REQUEST['id'];
			$rem_amt=mysqli_real_escape_string($mr_con,$_REQUEST['rem_amt']);
			$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
			$reqdate=date("Y-m-d");
			$approved_by=expensedetlimited('approved_by',$alias)."|".$empalias;
			$approved_date=expensedetlimited('approved_date',$alias)."|".$reqdate;
			$sql="UPDATE ec_expenses SET approval_level='6',approved_by='$approved_by',approved_date='$approved_date',reimbursement_amount='$rem_amt' WHERE expenses_alias='$alias'";
			if($mr_con->query($sql)===TRUE){
				$expense=alias($alias,'ec_expenses','expenses_alias','total_tour_expenses');
				$expense_emp_alias=alias($alias,'ec_expenses','expenses_alias','employee_alias');
				$rec=$mr_con->query("SELECT total_amount,advance_alias FROM ec_advances WHERE employee_alias='$expense_emp_alias' AND  approval_level='6' AND total_amount <>'0' AND flag=0 ORDER BY requested_date");
				if($rec->num_rows>0){$axs=0;
					while($row = $rec->fetch_assoc()){
						$advances[$axs]=$row['advance_alias'];
						$adv_amt[$axs]=$row['total_amount'];
					$axs++;}
					for($x=0;$x<count($advances);$x++){
						if($expense>'0'){
							if($adv_amt[$x]<'0'){
								$expense=$expense-$adv_amt[$x];
								$adv_amt[$x]=0;
								$query_advances="UPDATE ec_advances SET total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
							}
							else if(($adv_amt[$x]-$expense) >'0'){
								$expense1=$expense;
								$expense=$expense-$adv_amt[$x];
								$adv_amt[$x]=$adv_amt[$x]-$expense1;
								$query_advances="UPDATE ec_advances SET total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
							}
							else if(($adv_amt[$x]-$expense) =='0'){
								$expense=$expense-$adv_amt[$x];
								$adv_amt[$x]=0;
								$query_advances="UPDATE ec_advances SET total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
							}
							else{
								$expense1=$expense;
								$expense=$expense1-$adv_amt[$x];
								//$adv_amt[$x]=$adv_amt[$x]-$expense1;
								$adv_amt[$x]=0;
								$query_advances="UPDATE ec_advances SET total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
							}
							$mr_con->query($query_advances);
						}
					}
					/*if($expense>'0'){
						$x=count($advances)-1;
						$adv_amt[$x]=0-$expense;
						$query_advances="UPDATE ec_advances SET total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
						$mr_con->query($query_advances);
					}*/
				}else $asz=0;

				$message="<p class='alert alert-success' role='alert'>Approved successfully</p>";
			}else $message="<p class='alert alert-danger' role='alert'>Approval Failed</p>";
			$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
			if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
			//$url="http://enersyscare.co.in/enersys_expense/maillings/book_expense.php?ref=".$alias;
			//file_get_contents($url);
	}
	if($_REQUEST['ref2']=='5'){
			$empalias=$_SESSION['ec_user_alias'];
			$ref='viewexpense';
			$alias=$_REQUEST['id'];
			$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
			$reqdate=date("Y-m-d");
			$approved_by=expensedetlimited('approved_by',$alias)."|".$empalias;
			$approved_date=expensedetlimited('approved_date',$alias)."|".$reqdate;
			$sql="UPDATE ec_expenses SET approval_level='3',approved_by='$approved_by',approved_date='$approved_date' WHERE expenses_alias='$alias'";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Approved successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Approval Failed</p>";
			$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
			if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
			//$url="http://enersyscare.co.in/enersys_expense/maillings/book_expense.php?ref=".$alias;
			//file_get_contents($url);
	}
	if($_REQUEST['ref2']=='6'){
			$empalias=$_SESSION['ec_user_alias'];
			$ref='viewexpense';
			$alias=$_REQUEST['id'];
			$reasonForAdv=mysqli_real_escape_string($mr_con,$_REQUEST['reasonForAdv']);
			$utr_num=$_REQUEST['utr_num'];
			$reqdate=date("Y-m-d");
			$sql="UPDATE ec_expenses SET utr_num='$utr_num' WHERE expenses_alias='$alias'";
			if($mr_con->query($sql)===TRUE) $message="<p class='alert alert-success' role='alert'>Updated successfully</p>"; else $message="<p class='alert alert-danger' role='alert'>Update Failed</p>";
			$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
			if($reasonForAdv!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$reasonForAdv','BE','$alias','$empalias','$alias_remark')");
	}
	if(file_exists('viewexpense.php')){include('viewexpense.php');}

}
?>