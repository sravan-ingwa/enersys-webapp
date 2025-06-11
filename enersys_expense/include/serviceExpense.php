<?php
	session_start();
	date_default_timezone_set("Asia/Kolkata");
	if(isset($_REQUEST['texp'])){ 
		if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['visitFromDate'])){$message="<p class='alert alert-danger' role='alert'>Select Visit from Date</p>";}
		else if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['visitToDate'])){$message="<p class='alert alert-danger' role='alert'>Select Visit to Date</p>";}
		else if(mysqli_real_escape_string($mr_con,$_REQUEST['placesOfVisit'])==""){$message="<p class='alert alert-danger' role='alert'>Enter Places Of Visit</p>";}
		else if(mysqli_real_escape_string($mr_con,$_REQUEST['purpose'])==""){$message="<p class='alert alert-danger' role='alert'>Enter Purpose</p>";}
		else if(filter_var($_REQUEST['texp'], FILTER_VALIDATE_INT) == false){$message="<p class='alert alert-danger' role='alert'>Enter Total Amount</p>";}
		//else if($_FILES['tplanningreport']['size']<=0){$message="<p class='alert alert-danger' role='alert'>Upload Tour Report</p>";}
		else{
			$rquestid="#".checkint(mt_rand(1000,999999999),'ec_expenses','bill_number');
			$empalias=$_SESSION['ec_user_alias'];
			$visitFromDate=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['visitFromDate']))));
			$visitToDate=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['visitToDate']))));
			$placesOfVisit=mysqli_real_escape_string($mr_con,$_REQUEST['placesOfVisit']);
			$purpose=mysqli_real_escape_string($mr_con,$_REQUEST['purpose']);
			$remarkss=mysqli_real_escape_string($mr_con,$_REQUEST['remarks']);
			$texp=round(array_sum($_REQUEST['amt'])+array_sum($_REQUEST['amt_l'])+array_sum($_REQUEST['lamt'])+array_sum($_REQUEST['bamt'])+array_sum($_REQUEST['oamt']));
			$reqdate=date("Y-m-d");
			$alias=aliasCheck(generateRandomString(),"ec_expenses","expenses_alias");
			$fault =array();
			$ins=0;
			if($empalias!=""){
				$req_bucket = $_REQUEST['bucket'];
				if(count($_REQUEST['bucket'])!=0){
					for($i = 0; $i < count($_REQUEST['bucket']);$i++){
					if ($req_bucket[$i] == '0')
					   $req_bucket[$i] = 1;
					}
				}

				//echo "cap-".count(array_filter($_REQUEST['cap']))."_". count($_REQUEST['cap']);echo "<br>";
				//echo "quantityCell-".count(array_filter($_REQUEST['quantityCell']))."_". count($_REQUEST['quantityCell']);echo "<br>";
				//echo "numKilometers-".count(array_filter($_REQUEST['numKilometers']))."_". count($_REQUEST['numKilometers']);echo "<br>";
				$sec_length  = count(array_keys( $_REQUEST['bucket'], "0" ));
			
				//Start - Local Conveyance
				if((count(array_filter($_REQUEST['zone_l'])) == count($_REQUEST['zone_l'])) && (count(array_filter($_REQUEST['state_l'])) == count($_REQUEST['state_l'])) && (count(array_filter($_REQUEST['district_l'])) == count($_REQUEST['district_l'])) && (count(array_filter($req_bucket)) == count($_REQUEST['bucket'])) && (count(array_filter($_REQUEST['dot_l'])) == count($_REQUEST['dot_l'])) && (count(array_filter($_REQUEST['mot_l'])) == count($_REQUEST['mot_l'])) && (count(array_filter($_REQUEST['from_l'])) == count($_REQUEST['from_l'])) && (count(array_filter($_REQUEST['to_l'])) == count($_REQUEST['to_l'])) && (count(array_filter($_REQUEST['ticket_idl'])) == count($_REQUEST['ticket_idl'])) && (count(array_filter($_REQUEST['dprNum_l'])) == count($_REQUEST['dprNum_l'])) && (count(array_filter($_REQUEST['amt_l'])) == count($_REQUEST['amt_l']))){
					for($i=0;$i<count($_REQUEST['amt_l']);$i++){
						$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['dot_l'][$i]))));
						$fa[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['mot_l'][$i]);
						$fb[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['from_l'][$i]);
						$fc[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['to_l'][$i]);
						$fd[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['amt_l'][$i]);
						$fe[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['zone_l'][$i]);
						$ff[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state_l'][$i]);
						$fg[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['district_l'][$i]);
						$fh[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['area_l'][$i]);
						$fi[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['bucket'][$i]);
						if($fi[$i] == 0){
							$fj[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['cap'][$i]);
							$fk[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['wofCell'][$i]);
							$fl[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['quantityCell'][$i]);
							$fm[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['numKilometers'][$i]);
						} else {
							$fj[$i]='';
							$fk[$i]='';
							$fl[$i]='';
							$fm[$i]='';
						}
						$fn[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['dprNum_l'][$i]);
						$fo[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['ticket_idl'][$i]);
						$alias1=aliasCheck(generateRandomString(),"ec_localconveyance","alias");
						/*if($fi[$i] == 0){
							if((count(array_filter($_REQUEST['cap'])) == $sec_length) && (count(array_filter($_REQUEST['quantityCell'])) == $sec_length) && (count(array_filter($_REQUEST['numKilometers'])) == $sec_length)){
								if($fd[$i]!="" && $fd[$i]!="0"){
									mysqli_query($mr_con,"INSERT INTO ec_localconveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,zone_alias,state_alias,district_alias,bucket,capacity,quantity,km,dpr_number,ticket_alias,alias,created_date) VALUES('$alias','$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$fe[$i]','$ff[$i]','$fg[$i]','$fi[$i]','$fj[$i]','$fl[$i]','$fm[$i]','$fn[$i]','$fo[$i]','$alias1','$reqdate')");
									$ins=1;
								}
							}
						} else {*/
							if($fd[$i]!="" && $fd[$i]!="0"){
								mysqli_query($mr_con,"INSERT INTO ec_localconveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,zone_alias,state_alias,district_alias,bucket,capacity,quantity,km,dpr_number,ticket_alias,alias,created_date) VALUES('$alias','$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$fe[$i]','$ff[$i]','$fg[$i]','$fi[$i]','$fj[$i]','$fl[$i]','$fm[$i]','$fn[$i]','$fo[$i]','$alias1','$reqdate')");
								$ins=1;
							}
						//}
					}
				}
				//End - Local Conveyance	
			
				//start - Conveyance
				if((count(array_filter($_REQUEST['dot'])) == count($_REQUEST['dot'])) && (count(array_filter($_REQUEST['mot'])) == count($_REQUEST['mot'])) && (count(array_filter($_REQUEST['from'])) == count($_REQUEST['from'])) && (count(array_filter($_REQUEST['to'])) == count($_REQUEST['to'])) && (count(array_filter($_REQUEST['cticket_id'])) == count($_REQUEST['cticket_id'])) && (count(array_filter($_REQUEST['cdprno'])) == count($_REQUEST['cdprno'])) && (count(array_filter($_FILES['motbill']['name'])) == count($_REQUEST['dot'])) && (count(array_filter($_REQUEST['amt'])) == count($_REQUEST['amt']))){
						for($i=0;$i<count($_REQUEST['amt']);$i++){
							$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['dot'][$i]))));
							$fa[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['mot'][$i]);
							$fb[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['from'][$i]);
							$fc[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['to'][$i]);
							$fd[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['amt'][$i]);
							$fe[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['cdprno'][$i]);
							$ff[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['cticket_id'][$i]);
							if($fd[$i]!="" && $fd[$i]!="0"){	
								if($_FILES['motbill']['size'][$i]>0){
									$ext = pathinfo($_FILES['motbill']['name'][$i], PATHINFO_EXTENSION);
									$fileName=$empalias.generateRandomString()."TC.".$ext;
									move_uploaded_file($_FILES["motbill"]["tmp_name"][$i],"attachments/".$fileName);
									$profileimg = "attachments/".$fileName;
								}else $profileimg ='0';
								$alias1=aliasCheck(generateRandomString(),"ec_conveyance","alias");
								if($profileimg=='0'){
									mysqli_query($mr_con,"INSERT INTO ec_conveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,document_link,dpr_number,ticket_alias,created_date) VALUES('$alias','$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$alias1','$profileimg','$fe[$i]','$ff[$i]','$reqdate')");
									$fault[]=1;
									$ins=1;
								}elseif(file_exists($profileimg)){
									mysqli_query($mr_con,"INSERT INTO ec_conveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,document_link,dpr_number,ticket_alias,created_date) VALUES('$alias','$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$alias1','$profileimg','$fe[$i]','$ff[$i]','$reqdate')");
									$fault[]=1;
									$ins=1;
								}else{ $fault[]=0;}
							}
						}
					}
				//End - Conveyance
	
				//Start - Lodging
				if((count(array_filter($_REQUEST['checkin'])) == count($_REQUEST['checkin'])) && (count(array_filter($_REQUEST['checkout'])) == count($_REQUEST['checkout'])) && (count(array_filter($_REQUEST['zone_ld'])) == count($_REQUEST['zone_ld'])) && (count(array_filter($_REQUEST['state_ld'])) == count($_REQUEST['state_ld'])) && (count(array_filter($_REQUEST['district_ld'])) == count($_REQUEST['district_ld'])) && (count(array_filter($_REQUEST['hotelName'])) == count($_REQUEST['hotelName'])) && (count(array_filter($_REQUEST['ticket_idld'])) == count($_REQUEST['ticket_idld'])) && (count(array_filter($_REQUEST['lamt'])) == count($_REQUEST['lamt']))){
					for($i=0;$i<count($_REQUEST['lamt']);$i++){
						$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkin'][$i]))));
						$fa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkout'][$i]))));
						//$fb[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['typeofstay'][$i]);
						$fc[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['hotelName'][$i]);
						$fd[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['lamt'][$i]);
						 $fe[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['zone_ld'][$i]);
						 $ff[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state_ld'][$i]);
						 $fg[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['district_ld'][$i]);
						$fh[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['dprNum_ld'][$i]);
						$fi[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['ticket_idld'][$i]);
						$profileimg =0;
						if($fd[$i]!="" && $fd[$i]!="0"){
							$alias1=aliasCheck(generateRandomString(),"ec_lodging","alias");
							mysqli_query($mr_con,"INSERT INTO ec_lodging(check_in,check_out,type_of_stay,hotel_name,amount,zone_alias,state_alias,district_alias,dpr_number,expenses_alias,alias,document_link,ticket_alias,created_date) VALUES('$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$fe[$i]','$ff[$i]','$fg[$i]','$fh[$i]','$alias','$alias1','$profileimg','$fi[$i]','$reqdate')");
							$ins=1;
						}
					}
				}
				//End - Lodging
				
				//Start - Boarding
				if((count(array_filter($_REQUEST['checkinb'])) == count($_REQUEST['checkinb'])) && (count(array_filter($_REQUEST['checkoutb'])) == count($_REQUEST['checkoutb'])) && (count(array_filter($_REQUEST['zone_bo'])) == count($_REQUEST['zone_bo'])) && (count(array_filter($_REQUEST['state_bo'])) == count($_REQUEST['state_bo'])) && (count(array_filter($_REQUEST['district_bo'])) == count($_REQUEST['district_bo']))  && (count(array_filter($_REQUEST['dprNum_bo'])) == count($_REQUEST['dprNum_bo'])) && (count(array_filter($_REQUEST['ticket_bo'])) == count($_REQUEST['ticket_bo']))){
					for($i=0;$i<count($_REQUEST['bamt']);$i++){
						$fa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkinb'][$i]))));
						$fb[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkoutb'][$i]))));
						$fc[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state'][$i]);
						$fd[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['bamt'][$i]);
						$fe[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['zone_bo'][$i]);
						$ff[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['state_bo'][$i]);
						$fg[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['district_bo'][$i]);
						$fh[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['dprNum_bo'][$i]);
						$fi[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['ticket_bo'][$i]);
						if($fd[$i]!="" && $fd[$i]!="0"){
							$alias1=aliasCheck(generateRandomString(),"ec_boarding","alias");
							mysqli_query($mr_con,"INSERT INTO ec_boarding(check_in,check_out,state,amount,zone_alias,state_alias,district_alias,dpr_number,ticket_alias,expenses_alias,alias,created_date) VALUES('$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$fe[$i]','$ff[$i]','$fg[$i]','$fh[$i]','$fi[$i]','$alias','$alias1','$reqdate')");
							$ins=1;
						}
					}
				}
				//End - Boarding
				
				//Start - Other expenses
				if((count(array_filter($_REQUEST['others'])) == count($_REQUEST['others'])) && (count(array_filter($_REQUEST['odate'])) == count($_REQUEST['odate'])) && (count(array_filter($_FILES['ofile']['name'])) == count($_REQUEST['others'])) && (count(array_filter($_REQUEST['ticket_ot'])) == count($_REQUEST['ticket_ot'])) && (count(array_filter($_REQUEST['dprNum_ot'])) == count($_REQUEST['dprNum_ot'])) && (count(array_filter($_REQUEST['oamt'])) == count($_REQUEST['oamt']))){
					for($i=0;$i<count($_REQUEST['oamt']);$i++){
						$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['odate'][$i]))));
						$fa[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['others'][$i]);
						$fb[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['oamt'][$i]);
						$fc[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['dprNum_ot'][$i]);
						$fd[$i]=mysqli_real_escape_string($mr_con,$_REQUEST['ticket_ot'][$i]);
						if($fb[$i]!="" && $fb[$i]!="0"){
							if($_FILES['ofile']['size'][$i]>0){
								$ext2 = pathinfo($_FILES['ofile']['name'][$i], PATHINFO_EXTENSION);
								$fileName=$empalias.generateRandomString()."TO.".$ext2;
								move_uploaded_file($_FILES["ofile"]["tmp_name"][$i],"attachments/".$fileName);
								$profileimg = "attachments/".$fileName;
							}else $profileimg =0;
							$alias1=aliasCheck(generateRandomString(),"ec_other_expenses","alias");
							if($profileimg=='0'){
								mysqli_query($mr_con,"INSERT INTO ec_other_expenses(checked_date, description, amount, expenses_alias, alias, document_link, dpr_number, ticket_alias, created_date) VALUES('$faa[$i]','$fa[$i]','$fb[$i]','$alias','$alias1','$profileimg','$fc[$i]','$fd[$i]','$reqdate')");
								$ins=1;
								$fault[]=1;
							}elseif(file_exists($profileimg)){
								mysqli_query($mr_con,"INSERT INTO ec_other_expenses(checked_date, description, amount, expenses_alias, alias, document_link, dpr_number, ticket_alias, created_date) VALUES('$faa[$i]','$fa[$i]','$fb[$i]','$alias','$alias1','$profileimg','$fc[$i]','$fd[$i]','$reqdate')");
								$fault[]=1;
								$ins=1;
							}else{ $fault[]=0;}
						}
					}
				}
				//End - Other expenses			
			
			if($ins==0){
				$message="<p class='alert alert-danger' role='alert'>Expense Request Failed.Fill all mandatory fields.</p>";		
			}else{
				if(isset($_REQUEST['rcq']) && $_REQUEST['rcq']=="save"){
					if($_FILES['tplanningreport']['size']>0){
						$ext = pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION);
						$fileName=$empalias.generateRandomString()."EXP.".$ext;
						move_uploaded_file($_FILES["tplanningreport"]["tmp_name"],"attachments/tourReport/".$fileName);
						$profileimg = "attachments/tourReport/".$fileName;
					}else $profileimg =0;
					$sql="INSERT INTO ec_expenses(bill_number,employee_alias,period_of_visit_from,period_of_visit_to,places_of_visit,purpose,total_tour_expenses,requested_date,expenses_alias,approval_level,report) VALUES ('$rquestid','$empalias','$visitFromDate','$visitToDate','$placesOfVisit','$purpose','$texp','$reqdate','$alias',0,'$profileimg')";
					if($mr_con->query($sql)===TRUE){
						$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
						if($remarkss!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$remarkss','BE','$alias','$empalias','$alias_remark')");
						$emcheck=alias($rquestid,'ec_expenses','bill_number','employee_alias');
						if($emcheck=="NA" || $emcheck==""){
							$message="<p class='alert alert-danger' role='alert'>Your Bill Number ".$rquestid." has been saved, But Will not Reflect in you details, So contact Admin</p>";
							//$url="http://enersyscare.co.in/enersys_expense/maillings/failed.php?type=2&ref=".$rquestid;
						}else{
							$message="<p class='alert alert-success' role='alert'>Expense Request Saved with Bill Number: ".$rquestid.", </p>";
						}
					}else $message="<p class='alert alert-danger' role='alert'>Expense Drafting Failed</p>";
				}else{
					if($_FILES['tplanningreport']['size']>0){
						$ext = pathinfo($_FILES['tplanningreport']['name'], PATHINFO_EXTENSION);
						$fileName=$empalias.generateRandomString()."EXP.".$ext;
						move_uploaded_file($_FILES["tplanningreport"]["tmp_name"],"attachments/tourReport/".$fileName);
						$profileimg = "attachments/tourReport/".$fileName;
					}else $profileimg =0;
					if(in_array("0", $fault)){$level=0;}
					else{
						$levelx=expenseApprovalLevels($_SESSION['ec_user_alias']);
						switch ($levelx){
							case '1': $level=2;break;
							case '2': $level=5;break;
							case '3': $level=5;break;
							case '4': $level=5;break;
							case '5': $level=3;break;
							default : $level=1;break;
						}
					}
					$sql="INSERT INTO ec_expenses(bill_number,employee_alias,period_of_visit_from,period_of_visit_to,places_of_visit,purpose,total_tour_expenses,requested_date,expenses_alias,approval_level,report) VALUES ('$rquestid','$empalias','$visitFromDate','$visitToDate','$placesOfVisit','$purpose','$texp','$reqdate','$alias','$level','$profileimg')";
					if($mr_con->query($sql)===TRUE){
						$alias_remark=aliasCheck(generateRandomString(),"ec_remarks","remark_alias");
						if($remarkss!='') $mr_con->query("INSERT INTO ec_remarks(remarks,module,item_alias,remarked_by,remark_alias) VALUES ('$remarkss','BE','$alias','$empalias','$alias_remark')");
						$emcheck=alias($rquestid,'ec_expenses','bill_number','employee_alias');
						if($emcheck=="NA" || $emcheck==""){
							$message="<p class='alert alert-danger' role='alert'>Your Bill Number ".$rquestid." has been Submitted, But Will not Reflect in you details, So contact Admin</p>";
							//$url="http://enersyscare.co.in/enersys_expense/maillings/failed.php?type=1&ref=".$rquestid;
						}else{
							if($level==0)$message="<p class='alert alert-success' role='alert'> Bill Number: ".$rquestid.", Some Files could not be uploaded, So Your Expense is saved in Drafts.<br>Kinldy Resubmit from Drafts.</p>";
							else $message="<p class='alert alert-success' role='alert'>Expense Submitted successfully with Bill Number: ".$rquestid." </p>"; 
							$url=$base_url."maillings/book_expense.php?ref=".$alias;
							file_get_contents($url);
						}
					}
					else $message="<p class='alert alert-danger' role='alert'>Expense Request Failed</p>";
				}
			}
			}else $message="<p class='alert alert-danger' role='alert'>Sorry Something Went Wrong! Please Referesh and try</p>";
		}
	}
?>
<style>
.tbform input[type="text"], .tbform input[type="file"], .tbform select{border:none !important;margin:0 !important;padding:0 !important;width:100% !important;outline:none !important;webkit-box-shadow: none;box-shadow: none;}
.tbform input[type="text"]:focus, .tbform input[type="file"]:focus, .tbform select:focus{outline:none !important;webkit-box-shadow: none;box-shadow: none;}
.table-bordered{margin-bottom:5px !important;}
.redd{color:#F00 !important;}
.panel-default > .panlbakg{background-color:#2a6496; border:2px solid #2a6496; color:#fff;}
</style>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Book Expenses</h3>
	</div>
	<div class="panel-body">
        <form role="form" class="ss_form" method="post" id="defaultForm" name="ser_expense" novalidate>
         <p class='alerta' role='alert'></p>
        <input type="hidden" value="<?php echo $ref;?>" name="ref" />
        <div class="col-xs-10 jerror"><?php if(isset($message))echo $message;?></div>
		<div class="row">
       <div class="col-md-4 form-group">
            <label>Date of Request : </label>
            <input class="form-control" type="text" value="<?php echo date('d-M-Y'); ?>" placeholder="Date of Request" readonly/>
        </div>
        <div class="col-md-4 form-group">
            <label>Employee ID : </label>
            <input class="form-control" type="text" value="<?php echo employeeDetails('employee_id',$_SESSION['ec_user_alias']);?>" placeholder="Employee ID" readonly/>
        </div>
        <div class="col-md-4 form-group">
            <label>Employee Name: </label>
            <input class="form-control" type="text" value="<?php echo employeeDetails('name',$_SESSION['ec_user_alias']);?>" placeholder="Employee Name" readonly/>
        </div>
        <div class="col-md-4 form-group">
            <label>Grade: </label>
            <input class="form-control" type="text" value="<?php echo grade($_SESSION['ec_user_alias'])?>" placeholder="Grade" readonly/>
        </div>
        <div class="col-md-4 form-group">
            <label>Visit: Start Date: </label>
            <input type='text' class="form-control dpd1 cddl bg-white"  name="visitFromDate" placeholder="DD-MM-YYYY" readonly/>
        </div>
        <div class="col-md-4 form-group">
            <label>Visit: End Date: </label>
            <input type='text' class="form-control dpd2 cddl bg-white"  name="visitToDate" placeholder="DD-MM-YYYY" readonly/>
        </div>
		</div>
        <div class="row">
            <div class="col-md-4 form-group">
                <label>No. of days: </label>
                <input type="text"  class="form-control" id="visitFromDate" placeholder="No. of days" readonly />
            </div>
            <div class="col-md-4 form-group">
                <label>Visited place's : </label>
                <input type="text"  class="form-control" name="placesOfVisit" placeholder="Places of Visit"/>
            </div>
            <div class="col-md-4 form-group">
                <label>Purpose: </label>
                <textarea class="form-control reasonForAdv" name="purpose" placeholder="Purpose" ></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 form-group">
                <label>Remarks: </label>
                <textarea class="form-control reasonForAdv1" name="remarks" placeholder="Remarks" ></textarea>
            </div>
        </div>
        
        <!---------   DPR Details -------->
        <div class="col-lg-12 form-group dprDetails hidden">
            <label>DPR Details : </label>
            <table class="table table-bordered">
                <thead><tr class="blue cust"><th>DPR Number</th><th>Category</th><th>Submitted Date</th><th>Remarks</th><th>Expense</th></tr></thead>
                <tbody id="dpr_res">
                </tbody>
            </table>
        </div>
        
        <div class="col-lg-12 form-group">
            <label>Local Conveyance : </label>&nbsp;&nbsp;<a href="#" data-get="fare11" class="addNewLoc"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare11" class="RemoveLoc" data-cnt="1"><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix" id='fare11'>
            <div class="localConv">
                   <div id="localConv_1" class="panel panel-default tbformm ajm" >
                    	<div class="panel-heading panlbakg">
                        	<h3 class="panel-title">Local Conveyance 1</h3>
                   		 </div>
                   		<div class="panel-body">
                    	<div class="row">
                             <div class="col-md-3 form-group">
                                <label>Zone : </label>
                                <select class="form-control showgradedesg zone_change" name="zone_l[]"   data="state" ref="lc">
                                    <option value="0" selected="selected">Zone</option>
                                    <?php $getZn=getZones();if($getZn!=0){foreach($getZn as $rec){echo "<option value='".$rec['zone_alias']."'>".$rec['zone_name']."</option>";}}else echo "<option disabled='disabled'>Add Zone</option>";?>
                                </select>
                            </div>
                            <div class="col-md-3 form-group sel_empty ">
                                <label>State : </label>
                                <select class="form-control showgradedesg state_change " data-live-search="true"  name="state_l[]" data="district">
                                    <option value="0" selected="selected"  class="depsel">State</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group sel_empty ">
                                <label>District : </label>
                                <select class="form-control showgradedesg district_change " data-live-search="true" name="district_l[]" data="area">
                                     <option value="0" selected="selected"  class="depsel">District</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Area : </label>
                                <input class="form-control area_change" type="text" name="area_l[]" placeholder="Area" value=""  readonly="readonly"/>   
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Bucket : </label>
                                 <select class="form-control localConvy"   name="bucket[]"  >
                                    <option value="" selected="selected">Bucket</option>
                                    <option value="0">Secondary transportation </option>
                                    <option value="1">Local Conveyance</option>
                                 </select>   
                            </div>
                             <div class="col-md-3 form-group lclHide hidden ticket_empty1">
                                <label class="cap">Capacity : </label>   
                                <select class="form-control capacity_change cap selectpicker"  name="cap[]"  data="weight" data-live-search="true">
                                    <option value="" selected="selected">Capacity</option>
                                     <?php $getCp=getCapacity();if($getCp!=0){foreach($getCp as $rec){echo "<option value='".$rec['product_alias']."'>".$rec['product_description']."</option>";}}else echo "<option disabled='disabled'>Add Capacity</option>";?> 
                                 </select>
                            </div>
                            <div class="col-md-3 form-group lclHide hidden">
                                <label class="ocap">Weight of the cell : </label>   
                                <input type="text" class="form-control wofCell weight_change ocap" name="wofCell[]" placeholder="Weight of the cell" readonly/>
                            </div>
                            <div class="col-md-3 form-group lclHide hidden">
                                <label class="ocap">Quantity : </label>   
                                <input type="text" class="form-control qnty ocap" name="quantityCell[]" placeholder="Quantity" autocomplete="off" value=""/>
                            </div>
                            <div class="col-md-3 form-group lclHide hidden">
                                <label class="ocap">No.of Kilometers : </label>   
                                <input type="text" class="form-control numKilo ocap" name="numKilometers[]" placeholder="No.of Kilometers" value="" autocomplete="off"/>
                            </div>
                            <div class="col-md-3 form-group lclHide hidden">
                                <label class="ocap">Amount Appilicable : </label>   
                                <input type="text" class="form-control ocap wofCell appli_change" name="amtappli[]" placeholder="Amount" readonly/>
                            </div>
                             <div class="col-md-3 form-group">
                                <label>Date of Travel : </label>
                                <input type="text" class="form-control  expense_dates cddl bg-white " name="dot_l[]" placeholder="DD-MM-YYYY" readonly/>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Mode of travel : </label>   
                                <select class="form-control"   name="mot_l[]" id="mot">
                                    <option value="0" selected="selected">Mode of travel</option>
                                    <option value="Own Vehicle">Own Vehicle</option>
                                    <option value="Cab">Cab</option>
                                    <option value="Auto">Auto</option>
                                    <option value="Local Train">Local Train</option>
                                    <option value="Any Public Transport">Any Public Transport</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>From : </label>  
                                <input type="text" class="form-control" name="from_l[]" placeholder="From Place"/>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>To : </label>  
                                <input type="text" class="form-control" name="to_l[]" placeholder="To Place"/>
                            </div>
                           
                            <div class="col-md-3 form-group ticket_empty">
                                <label>Ticket ID : </label>  
                                <select id="ticket_idl" class="form-control selectpicker" name="ticket_idl[]" data-live-search="true" placeholder="">
                                    <option value="" selected="selected">Select Ticket ID</option>
                                    <option value="1">Others</option>
                                    <?php $getTid=getTicket($_SESSION['ec_user_alias']);
                                     if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."'>".$rec['ticket_id']."</option>";}}
                                     else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>DPR Number : </label>  
                                <input type="text" class="form-control" name="dprNum_l[]" placeholder="DPR Number"/>
                            </div>
                             <div class="col-md-3 form-group">
                                <label>Amount : </label>  
                                <input type="text" class="form-control amtt tamfor ttcm lc" name="amt_l[]" placeholder="Amount" readonly/>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                 <div class="col-md-4 form-group pull-right">
                  	<input type="text" class="form-control ttcmt" name="fare_total_loc" placeholder="Total Local Conveyance" readonly />
                 </div>
           </div>
        </div>               
        <div class="col-lg-12 form-group">
            <label>Conveyance : </label>&nbsp;&nbsp;<a href="#" data-get="fare0" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare0" class="RemoveField"><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix">
                <div class="column">
                    <table class="table table-bordered" id="fare_tab">
                        <thead><tr class="blue cust"><th>Date of travel</th><th>Mode of travel</th><th>From</th><th>To</th><th>Ticket ID</th><th>DPR Number</th><th>Files (No special characters in file name)</th><th>Amount</th></tr></thead>
                        <tbody id='fare0'>
                            <tr class="tbform ajm">
                                <td><input type="text" class="form-control expense_dates cddl bg-white" name="dot[]" placeholder="DD-MM-YYYY" readonly/></td>
                                <td><select class="form-control"  name="mot[]" id="mot">
                                        <option value="0">Mode of travel</option>
                                        <option value="ACT">ACT</option>
                                        <option value="AIR">Air</option>
                                        <option value="Train 2nd AC">Train 2nd AC</option>
                                        <option value="Train 3 tier">Train 3 tier</option>
                                        <option value="Train Sleeper">Train Sleeper</option>
                                        <option value="Volvo AC Bus">Volvo AC Bus</option>
                                        <option value="Non-AC Bus">Non-AC Bus</option>
                                        <option value="Own Vehicle">Own Vehicle</option>
                                        <option value="Cab">Cab</option>
                                        <option value="Auto">Auto</option>
                                        <option value="Local Train">Local Train</option>
                                        <option value="Any Public Transport">Any Public Transport</option>
                                    </select></td>
                                <td><input type="text" class="form-control" name="from[]" placeholder="From"/></td>
                                <td><input type="text" class="form-control" name="to[]" placeholder="To"/></td>
                               
                                <td class="ticket_empty">
                                    <select id="cticketID" class="form-control selectpicker" name="cticket_id[]" data-live-search="true" placeholder="">
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                    <option value="1">Others</option>
                                        <?php $getTid=getTicket($_SESSION['ec_user_alias']);
										 if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."'>".$rec['ticket_id']."</option>";}}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                                </td>

                                <td><input type="text" class="form-control" name="cdprno[]" placeholder="DPR Number"/></td>
                                
                                <td><!--<input type="hidden" class="form-control" name="motbill[]" value="0"/>-->
                                <input type="file" class="form-control" name="motbill[]"/></td>
                            <td><input type="text" class="form-control amtt tamfor tcm" name="amt[]" placeholder="Amount" autocomplete="off"/></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-4 pull-right"><input type="text" class="form-control tcmt" name="fare_total_con" placeholder="Total Conveyance" readonly /></div>                
				</div>
            </div>
        </div>
        
        <div class="col-lg-12 form-group">
            <label>Lodging : </label>&nbsp;&nbsp;<a href="#" data-get="fare1" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare1" class="RemoveField"><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix">
                <div class="column">
                    <table class="table table-bordered" id="fare_tab">
                        <thead><tr class="blue cust"><th>Check in Date</th><th>Check out Date</th><th>Zone</th><th>State</th><th>District</th><th>Hotel Name</th><th>Ticket ID</th><th>DPR Number</th><th>Amount</th></tr></thead>
                        <tbody id='fare1'>
                        <tr class="tbform ajm stDate1" >
                           <td><input type="text" class="form-control bdpd3 cddl bg-white clc" name="checkin[]" placeholder="DD-MM-YYYY" readonly /></td>
                           <td><input type="text" class="form-control bdpd4 cddl bg-white slc" name="checkout[]" placeholder="DD-MM-YYYY" readonly/></td>
                           <td>                                   
                                    <select class="form-control showgradedesg zone_change"  name="zone_ld[]"    data="state" ref="ld">
                <option value="0" selected="selected">Zone</option>
                    <?php $getZn=getZones();if($getZn!=0){foreach($getZn as $rec){echo "<option value='".$rec['zone_alias']."'>".$rec['zone_name']."</option>";}}else echo "<option disabled='disabled'>Add Zone</option>";?>
                </select>
                                </td>
                                <td class="sel_empty">                                    
                                    <select class="form-control showgradedesg state_change"   name="state_ld[]"  data="district">
                    <option value="0" selected="selected" class="depsel">State</option>
                </select>
                                </td>
                                <td class="sel_empty">
                                     <select class="form-control showgradedesg district_change"  name="district_ld[]" >
                     <option value="0" selected="selected" class="depsel">District</option>
                </select>
                                </td>
                                <td class="changw"><input type="text" class="form-control htname" name="hotelName[]" placeholder="Hotel Name" value=""/></td>
                                 <td class="ticket_empty">
                                    <select id="ticket_idld" class="form-control selectpicker" name="ticket_idld[]" data-live-search="true" placeholder="">
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                    <option value="1">Others</option>
                                        <?php $getTid=getTicket($_SESSION['ec_user_alias']);
										 if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."'>".$rec['ticket_id']."</option>";}}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="dprNum_ld[]" placeholder="DPR Number" value=""/></td>
                                <td><input type="text" class="form-control amtt tamfor tlam selfamm ld" name="lamt[]" placeholder="Amount" readonly/></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-4 pull-right"><input type="text" class="form-control tlamt" placeholder="Total Lodging" readonly name="fare_total_lod"/></div>
				</div>
            </div>
        </div>
        
        <div class="col-lg-12 form-group">
            <label>Boarding Allowance: </label>&nbsp;&nbsp;<a href="#" data-get="fare" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare" class="RemoveField"><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix">
                <div class="column">
                    <table class="table table-bordered" id="fare_tab">
                        <thead><tr class="blue cust"><th>Visit: Start Date</th><th>Visit: End Date</th><th>Zone</th><th>State</th><th>District</th><th>Ticket ID</th><th>DPR Number</th><th>Amount</th></tr></thead>
                        <tbody id='fare'>
                            <tr class="tbform ajm stDate">                            
                                <td><input type="text" class="form-control  bdpd1 cddl bg-white clc" name="checkinb[]" placeholder="DD-MM-YYYY" readonly/></td>
                                <td><input type="text" class="form-control  bdpd2 cddl bg-white slc" name="checkoutb[]" placeholder="DD-MM-YYYY" readonly/></td>
                                <td>
                                    <select class="form-control showgradedesg zone_change"  name="zone_bo[]"    data="state" ref="bd">
                <option value="0" selected="selected" >Zone</option>
                    <?php $getZn=getZones();if($getZn!=0){foreach($getZn as $rec){echo "<option value='".$rec['zone_alias']."'>".$rec['zone_name']."</option>";}}else echo "<option disabled='disabled'>Add Zone</option>";?>
                </select>
                                </td>
                                <td class="sel_empty">                                    
                                    <select class="form-control showgradedesg state_change"   name="state_bo[]"  data="district">
                    <option value="0" selected="selected"  class="depsel">State</option>
                </select>
                                </td>
                                <td class="sel_empty">
                                     <select class="form-control showgradedesg district_change"  name="district_bo[]"  >
                     <option value="0" selected="selected"  class="depsel">District</option>
                </select>
                                </td>                                
                                 <td class="ticket_empty">
                                    <select id="ticket_bo" class="form-control selectpicker" name="ticket_bo[]" data-live-search="true" placeholder="">
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                    <option value="1">Others</option>
                                        <?php $getTid=getTicket($_SESSION['ec_user_alias']);
										 if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."'>".$rec['ticket_id']."</option>";}}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="dprNum_bo[]" placeholder="DPR Number"/></td>
                                <td><input type="text" class="form-control amtt tamfor blam selfamm bd" name="bamt[]" placeholder="Amount" readonly/></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-4 pull-right"><input type="text" class="form-control blamt" placeholder="Total Lodging" readonly name="fare_total_bod"/></div>
				</div>
            </div>
        </div>
        
        <div class="col-lg-12 form-group">
            <label>Others : </label>&nbsp;&nbsp;<a href="#" data-get="fare2" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare2" class="RemoveField" ><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix">
                <div class="column">
                    <table class="table table-bordered" id="fare_tab">
                        <thead><tr class="blue cust"><th>Description</th><th>Date</th><th>Files (No special characters in file name)</th><th>Ticket ID</th><th>DPR Number</th><th>Amount</th></tr></thead>
                        <tbody id='fare2'>
                            <tr class="tbform ajm">
                                <td><input type="text" class="form-control" name="others[]" placeholder="Description"/></td>
                                <td><input type="text" class="form-control expense_dates cddl bg-white" name="odate[]" placeholder="DD-MM-YYYY" readonly/></td>
                                <td><!--<input type="hidden" class="form-control" name="ofile[]" value="0"/>-->
                                <input type="file" class="form-control" name="ofile[]"/></td>
                                <td class="ticket_empty">
                                    <select id="ticket_ot" class="form-control selectpicker" name="ticket_ot[]" data-live-search="true" placeholder="">
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                    <option value="1">Others</option>
                                        <?php $getTid=getTicket($_SESSION['ec_user_alias']);
										 if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."'>".$rec['ticket_id']."</option>";}}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="dprNum_ot[]" placeholder="DPR Number"/></td>
                                <td><input type="text" class="form-control amtt tamfor tlom" name="oamt[]" placeholder="Amount" autocomplete="off"/></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-4 pull-right"><input type="text" class="form-control tlomt" placeholder="Other's Total" readonly  name="fare_total_oth"/></div>
				</div>
            </div>
        </div>
        <div class="col-md-4 form-group">
        <label>Outstanding Balance: </label>
        <input type="text" class="form-control nsamt" value="<?php if (advanceNotSettled($_SESSION['ec_user_alias'])!=0)echo advanceNotSettled($_SESSION['ec_user_alias']); else echo "No pending Advances";?>" placeholder="Outstanding Balance" readonly />
        </div>
        <div class="col-md-4 form-group">
        <label>Total Expenses: </label>
        <input type="text" class="form-control texp" name="texp" placeholder="Total Expenses" readonly />
        </div>
        <div class="col-md-4 form-group">
        <label>Final Amount (Total Expenses- Outstanding Balance): </label>
        <input type="text" class="form-control finchamt" placeholder="Total Expenses- Outstanding Balance" readonly />
        </div>
        <!--<div class="col-md-4 form-group">
            <label>Reason/ Remarks: </label>
            <textarea tabindex="2" class="form-control" name="reasonForAdv" placeholder="Reason/ Remarks"></textarea>
        </div>
        -->
        <!--<div class="col-md-4 form-group">
            <label>Tour Report: <small class="redd">(Mandatory)</small></label>
            <input type="file" class="tplanningreport" name="tplanningreport" id="tplanningreport"/>
        	<small class="redd">(Kinldy upload PDF format and size not exceeding 1MB)</small>
        </div>-->
        <div class="col-md-4 form-group">&nbsp;</div>
        <div class="form-group col-xs-4 col-sm-6 col-sm-offset-1 morpad">
            <div class="col-xs-12">
                <input  type="submit" class="btn btn-primary ss_buttons saveinDraft" name="saveinDraft" value="Draft">
                <input  type="submit" class="btn btn-primary ss_buttons ademp" name="addEmp" value="Submit Expense">
            </div>
        </div>
        </form>
</div>
</div>
<!--<script src="../js/bootstrap-datepicker.js"></script>
--><script>
$(document).on("keypress keyup focus",".qnty",function (event) {    
	   $(this).val($(this).val().replace(/[^\d].+/, ""));
		if ((event.which < 48 || event.which > 57)) {
			event.preventDefault();
		}
	});
	
$(document).on("keypress keyup focus",".numKilo",function (event) {    
		$(this).val($(this).val().replace(/[^0-9\.]/g,''));
			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
				event.preventDefault();
			}
});
	$(document).on('keyup','.tamfor',function (event){ tamfor2(); });
	function tamfor2(){
		var tamt=tcmt=tlamt=blamt=tlomt=ttcm=0;
		$(".tamfor").each(function(){tamt+=Number($(this).val());});
		$(".tcm").each(function(){tcmt+=Number($(this).val());});
		$(".ttcm").each(function(){ttcm+=Number($(this).val());});
		$(".tlam").each(function(){tlamt+=Number($(this).val());});
		$(".blam").each(function(){blamt+=Number($(this).val());});
		$(".tlom").each(function(){tlomt+=Number($(this).val());});
		//start--for float checking
		var n1=ttcm; 
		if(isFloat(n1)==true){var v1=n1.toFixed(2);}else{var v1=n1;}
		$('.ttcmt').val(v1);
		
		var n2=tcmt;
		if(isFloat(n2)==true){var v2=n2.toFixed(2);}else{var v2=n2;}
		$('.tcmt').val(v2);
		
		var n3=tlamt;
		if(isFloat(n3)==true){var v3=n3.toFixed(2);}else{var v3=n3;}
		$('.tlamt').val(v3);
		
		var n4=blamt;
		if(isFloat(n4)==true){var v4=n4.toFixed(2);}else{var v4=n4;}
		$('.blamt').val(v4);
		
		var n5=tlomt;
		if(isFloat(n5)==true){var v5=n5.toFixed(2);}else{var v5=n5;}
		$('.tlomt').val(v5);
		//end--for float checking

/*		$('.ttcmt').val(ttcm);
		$('.tcmt').val(tcmt);
		$('.tlamt').val(tlamt);
		$('.blamt').val(blamt);
		$('.tlomt').val(tlomt);*/
		//$('.texp').val(Math.round(tamt));$('.finchamt').val(Math.round(tamt)-Number($('.nsamt').val()));
		var n6=Number($('.nsamt').val());
		if(isNaN(n6)==true){var v6=0;}else{var v6=Number($('.nsamt').val());}
		
		$('.texp').val(Math.round(tamt));$('.finchamt').val(Math.round(tamt)-v6);
		
	}
	$(document).on('focus','.tamfor',function (event){ tamfor();});
	function tamfor(){
		var tamt=tcmt=tlamt=blamt=tlomt=ttcm=0;
		$(".tamfor").each(function(){tamt+=Number($(this).val());});
		$(".tcm").each(function(){tcmt+=Number($(this).val());});
		//$(".ttcm").each(function(){var n1=$(this).val(); if(isFloat(n1)==true){var v1=n1.toFixed(2);}else{var v1=n1;} if(v1 != 0) ttcm+=Number(v1);});
		$(".ttcm").each(function(){ttcm+=Number($(this).val());});
		//$(".ttcm").each(function(){var n1=$(this).val();if(isFloat(n1)==true){var v1=n1.toFixed(2);}else{var v1=n1;} ttcm+=v1;});
		$(".tlam").each(function(){tlamt+=Number($(this).val());});
		$(".blam").each(function(){blamt+=Number($(this).val());});
		$(".tlom").each(function(){tlomt+=Number($(this).val());});
		//$('.ttcmt').val(ttcm);
		
		//start--for float checking
		var n1=ttcm;
		if(isFloat(n1)==true){var v1=n1.toFixed(2);}else{var v1=n1;}
		$('.ttcmt').val(v1);
		
		var n2=tcmt;
		if(isFloat(n2)==true){var v2=n2.toFixed(2);}else{var v2=n2;}
		$('.tcmt').val(v2);
		
		var n3=tlamt;
		if(isFloat(n3)==true){var v3=n3.toFixed(2);}else{var v3=n3;}
		$('.tlamt').val(v3);
		
		var n4=blamt;
		if(isFloat(n4)==true){var v4=n4.toFixed(2);}else{var v4=n4;}
		$('.blamt').val(v4);
		
		var n5=tlomt;
		if(isFloat(n5)==true){var v5=n5.toFixed(2);}else{var v5=n5;}
		$('.tlomt').val(v5);
		
		//end--for float checking

		//$('.tcmt').val(tcmt);$('.tlamt').val(tlamt);$('.blamt').val(blamt);$('.tlomt').val(tlomt);
		//$('.texp').val(Math.round(tamt));$('.finchamt').val(Math.round(tamt)-Number($('.nsamt').val()));
		var n6=Number($('.nsamt').val());
		if(isNaN(n6)==true){var v6=0;}else{var v6=Number($('.nsamt').val());}
		$('.texp').val(Math.round(tamt));$('.finchamt').val(Math.round(tamt)-v6);
	
	}
	
function isFloat(n){ //alert(n);
    return n === Number(n) && n % 1 !== 0;
}
	
depDate();
function depDate(){
	var nowTemp = new Date();
	var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
	
	//No of days - visit start date
	var checkin = $('.dpd1').datepicker({
		format: 'dd-mm-yyyy',
		onRender: function(date){return date.valueOf() > now.valueOf() ? 'disabled' : '';}
	}).on('changeDate', function(ev){		
		if (ev.date.valueOf() < checkout.date.valueOf()) {
			var newDate = new Date(ev.date);
			newDate.setDate(newDate.getDate());
			checkout.setValue(newDate);
		}
		if (ev.date.valueOf() > checkout.date.valueOf()) {
			var newDate = new Date(ev.date);
			newDate.setDate(newDate.getDate());
			checkout.setValue(newDate);
		}
		var sDate = $('.dpd1').val();
		var eDate = $('.dpd2').val();
		//$('.dprDetails').removeClass('hidden');
		$.ajax({
			type: "GET",
			url: "include/helper.php",
			data: 'd1='+sDate+'&d2='+eDate+'&rf=days',
			cache: true,
			success: function(result){$('#visitFromDate').val(result);}
		});
		dpr(sDate,eDate);
		checkin.hide();
		 $('.dpd2')[0].focus();
	}).data('datepicker');
	
	//No of days - visit end date
	var checkout = $('.dpd2').datepicker({
			format: 'dd-mm-yyyy',
			onRender: function(date){
				if(date.valueOf() < checkin.date.valueOf() || date.valueOf() > now.valueOf()) return 'disabled';
				else return'';
			}
		}).on('changeDate', function(ev){
			checkout.hide();
			var sDate = $('.dpd1').val();
			var eDate = $('.dpd2').val();
			$.ajax({
				type: "GET",
				url: "include/helper.php",
				data: 'd1='+sDate+'&d2='+eDate+'&rf=days',
				cache: true,
				success: function(result){$('#visitFromDate').val(result);}
			});
		dpr(sDate,eDate);
	}).data('datepicker');
	
	//all date pickers
	var  expense_dates= $('.expense_dates').datepicker({
			format: 'dd-mm-yyyy',
			onRender: function(date){
				if(date.valueOf() > now.valueOf()) return 'disabled';
				else return '';
			}
		}).on('changeDate', function(ev){$(this).datepicker('hide');
	}).data('datepicker');

	// boarding -- visit start date,end date
	$('.stDate').each(function(index, element) {
		var stmonth = new Array();
		stmonth[0] = "01";
		stmonth[1] = "02";
		stmonth[2] = "03";
		stmonth[3] = "04";
		stmonth[4] = "05";
		stmonth[5] = "06";
		stmonth[6] = "07";
		stmonth[7] = "08";
		stmonth[8] = "09";
		stmonth[9] = "10";
		stmonth[10] = "11";
		stmonth[11] = "12";
		
		 var bcheckin = $(this).find('.bdpd1').datepicker({
			format: 'dd-mm-yyyy',
			onRender: function(date){return date.valueOf() > now.valueOf() ? 'disabled' : '';}
		}).on('changeDate', function(ev){
			if (ev.date.valueOf() < bcheckout.date.valueOf()) {	
				var old_checkout = $(this).parent().siblings().find('.bdpd2').val();
				var st = bcheckout.date; 
				var now2 = bcheckout.date.getDate()+"-"+stmonth[bcheckout.date.getMonth()]+"-"+bcheckout.date.getFullYear(); 
				var newDate = new Date(ev.date);
				newDate.setDate(newDate.getDate());
				bcheckout.setValue(newDate);
				var todaysDate = new Date();
				//if(st.setHours(0,0,0,0) != todaysDate.setHours(0,0,0,0)){bcheckout.setValue(now2); }
				bcheckout.setValue(newDate); 
				if(old_checkout==''){bcheckout.setValue(newDate); }
				else{ if(st.setHours(0,0,0,0) > todaysDate.setHours(0,0,0,0)){bcheckout.setValue(newDate);}else{bcheckout.setValue(now2);}}
				
			}
			if(ev.date.valueOf() >= bcheckout.date.valueOf()) {//alert("3");
				var st = bcheckout.date;
				var now2 = bcheckout.date.getDate()+"-"+stmonth[bcheckout.date.getMonth()]+"-"+bcheckout.date.getFullYear(); 
				var newDate = new Date(ev.date);
				newDate.setDate(newDate.getDate());
				bcheckout.setValue(newDate);
			}
			
			ajaxAmount($(this).parents('.ajm'));
			bcheckin.hide();
			//alert($(this).parent().siblings().attr('class'));
			$(this).parent().siblings().find('.bdpd2').focus();
		}).data('datepicker');
		 
		var bcheckout = $(this).find('.bdpd2').datepicker({
				format: 'dd-mm-yyyy',
				onRender: function(date){
					if(date.valueOf() < bcheckin.date.valueOf() || date.valueOf() > now.valueOf()) return 'disabled';
					else return'';
					//return date.valueOf() > now.valueOf() ? 'disabled' : '';
				}
			}).on('changeDate', function(ev){
				ajaxAmount($(this).parents('.ajm'));
				bcheckout.hide();
		}).data('datepicker');
	});

	// loadging -- visit start date,end date
	$('.stDate1').each(function(index, element) { 
		var stmonth = new Array();
		stmonth[0] = "01";
		stmonth[1] = "02";
		stmonth[2] = "03";
		stmonth[3] = "04";
		stmonth[4] = "05";
		stmonth[5] = "06";
		stmonth[6] = "07";
		stmonth[7] = "08";
		stmonth[8] = "09";
		stmonth[9] = "10";
		stmonth[10] = "11";
		stmonth[11] = "12";
		
		 var bcheckin = $(this).find('.bdpd3').datepicker({
			format: 'dd-mm-yyyy',
			onRender: function(date){return date.valueOf() > now.valueOf() ? 'disabled' : '';}
		}).on('changeDate', function(ev){
			if(ev.date.valueOf() < bcheckout.date.valueOf()) {
				var old_checkout = $(this).parent().siblings().find('.bdpd4').val();
				var st = bcheckout.date;
			var now2 = bcheckout.date.getDate()+"-"+stmonth[bcheckout.date.getMonth()]+"-"+bcheckout.date.getFullYear();
				var newDate = new Date(ev.date);
				newDate.setDate(newDate.getDate()+1);
				var todaysDate = new Date();//alert(st.setHours(0,0,0,0)+"-"+todaysDate.setHours(0,0,0,0));
				//alert(bcheckout.date.valueOf()+"-"+todaysDate.setHours(0,0,0,0)+"-"+st.setHours(0,0,0,0));
				bcheckout.setValue(newDate); 
				if(old_checkout==''){bcheckout.setValue(newDate); }
				else{ if(st.setHours(0,0,0,0) > todaysDate.setHours(0,0,0,0)){bcheckout.setValue(newDate);}else{bcheckout.setValue(now2);}}
			}
			if(ev.date.valueOf() == now.valueOf()){		//alert("2");		
				var newDate = new Date(ev.date);
				newDate.setDate(newDate.getDate()+1);
				bcheckout.setValue(newDate);
			}
			if(ev.date.valueOf() >= bcheckout.date.valueOf()) {//alert("3");
				var st = bcheckout.date;
				var now2 = bcheckout.date.getDate()+"-"+stmonth[bcheckout.date.getMonth()]+"-"+bcheckout.date.getFullYear(); 
				var newDate = new Date(ev.date);
				newDate.setDate(newDate.getDate()+1);
				bcheckout.setValue(newDate);
			}
		
			ajaxAmount($(this).parents('.ajm'));
			bcheckin.hide();
			$(this).parent().siblings().find('.bdpd4').focus();
		}).data('datepicker');
		 
		var bcheckout = $(this).find('.bdpd4').datepicker({
				format: 'dd-mm-yyyy',
				onRender: function(date){
				if(date.valueOf() <= bcheckin.date.valueOf() || date.valueOf() > now.valueOf()) return 'disabled';
					else return'';
				}
			}).on('changeDate', function(ev){
				ajaxAmount($(this).parents('.ajm'));
				bcheckout.hide();
		}).data('datepicker');
	});
}

function dpr(d1,d2){
	var v1=d1;
	var v2=d2;
		$.ajax({
			type: "GET",
			url: "include/dpr_details.php",
			data: 'd1='+v1+'&d2='+v2,
			cache: true,
			success: function(result){
				$('.dprDetails').removeClass('hidden');
				$('#dpr_res').html(result);
			}
		});
}

$(document).on('change','.localConvy',function(){
	var loc = $(this).parent().siblings('.lclHide');
	if($(this).val()==0){
		loc.removeClass('hidden');
		loc.removeClass('hidden');
	}
	else{loc.addClass('hidden');
	loc.addClass('hidden');}
	var sib =  $(this).parent().siblings();
	ajaxAmount($(this).parents('.ajm'));
});


$(document).on('change','.zone_change',function(){
	var sib =  $(this).parent().siblings();
	ajaxSelect($(this),sib);
	ajaxAmount($(this).parents('.ajm'));
	//ajaxAmount($(this).parents('.tbformm'));
	sib.find(".district_change").html("<option value='0'>Select District</option>");
	sib.find(".area_change").val("");
	sib.find(".appli_change").val("");
});
$(document).on('change','.state_change',function(){
	var sib =  $(this).parent().siblings();
	ajaxSelect($(this),sib);
	ajaxAmount($(this).parents('.ajm'));
	//ajaxAmount($(this).parents('.tbformm'));
	sib.find(".area_change").val("");
	sib.find(".appli_change").val("");
});
$(document).on('change','.district_change',function(){
	var sib =  $(this).parent().siblings();
	ajaxSelect($(this),sib);
	ajaxAmount($(this).parents('.ajm'));
	//ajaxAmount($(this).parents('.tbformm'));
});
$(document).on('change','.capacity_change',function(){
	var sib =  $(this).parent().siblings();
	ajaxSelect($(this),sib);
	ajaxAmount($(this).parents('.ajm'));
});
$(document).on('keyup','.qnty',function (){ 
	ajaxAmount($(this).parents('.ajm'));
});
$(document).on('keyup','.numKilo',function (){ 
	ajaxAmount($(this).parents('.ajm'));
});


    function ajaxSelect(tis,sib) {
		var id = tis.val();
		var type = tis.attr('data');

        if(id != ""){
                $.ajax({
                    type: "POST",
                    url: "admin/ajaxSelect.php",
                    data: 'type=' + type + '&id=' + id,
                    cache: false,
					async:false,
                    success: function(result) {	 
						//$('.selectpicker').selectpicker().unload();
						if(type == "state" || type == "district"){
							sib.find("."+type+"_change").html(result);
							//setTimeout(function(){$('.selectpicker').selectpicker();},1000);
						}
						if (type == "area") {							
							if(result == 0){
								var disp = 'Plain area';
								var disp_amnt = '0.02';
								sib.find("."+type+"_change").val(disp);
									sib.find(".appli_change").val(disp_amnt);
							}else if(result == 1){
								var disp = 'Hilly area';
								var disp_amnt = '0.04';
								sib.find("."+type+"_change").val(disp);
									sib.find(".appli_change").val(disp_amnt);
							}
						}
						if (type == "weight") {	
								sib.find("."+type+"_change").val($.trim(result));
						}
                    }
                });
        }
        if (type == "State") {
            $("#ajaxSelect_State").html("<option value='0'>Select State</option>");
            $("#ajaxSelect_District").html("<option value='0'>Select District</option>");
			$('#ajaxSelect_Area').val("");
        }
		if (type == "District") {
			$('#ajaxSelect_Area').val("");
        }
    }
	
	function ajaxAmount(tr) {
		var ref =  tr.find(".zone_change").attr('ref');
		var tmp = tr.find(".localConvy").val();
		var bucket = (tmp==null ? 5 : tmp);
		var zoneval = tr.find(".zone_change").val();
		var stateval = tr.find(".state_change").val();
		var districtval = tr.find(".district_change").val();
		var weight = tr.find(".weight_change").val();
		var qnty = tr.find(".qnty").val();
		var km = tr.find(".numKilo").val();
		var appli = tr.find(".appli_change").val();
		var frd=tr.find('.clc').val();
		var erd=tr.find('.slc').val();
		//alert('bucket=' + bucket + '&zonesel=' + zoneval + '&statesel=' + stateval + '&dissel=' + districtval + '&weight=' + weight + '&qnty=' + qnty + '&km=' + km + '&appli=' + appli+'&ref='+ref+'&fda='+frd+'&eda='+erd);
		if(bucket != ""){
                $.ajax({
                    type: "POST",
                    url: "ajaxAmount.php",
                    data: 'bucket=' + bucket + '&zonesel=' + zoneval + '&statesel=' + stateval + '&dissel=' + districtval + '&weight=' + weight + '&qnty=' + qnty + '&km=' + km + '&appli=' + appli+'&ref='+ref+'&fda='+frd+'&eda='+erd,
                    cache: false,
					async:false,
                    success: function(res) {
							tr.find("."+ref).val($.trim(res));
						tamfor();tamfor2();					
						}
                });
		}
	}
	
$(document).ready(function() {
	$('.selectpicker').selectpicker();
});
	
    </script>