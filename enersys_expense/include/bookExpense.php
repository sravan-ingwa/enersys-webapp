<?php
	session_start();
	date_default_timezone_set("Asia/Kolkata");
	if(isset($_REQUEST['texp'])){
		if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['visitFromDate'])){$message="<p class='alert alert-danger' role='alert'>Select Visit from Date</p>";}
		else if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$_REQUEST['visitToDate'])){$message="<p class='alert alert-danger' role='alert'>Select Visit to Date</p>";}
		else if(mysqli_real_escape_string($mr_con,$_REQUEST['placesOfVisit'])==""){$message="<p class='alert alert-danger' role='alert'>Enter Places Of Visit</p>";}
		else if(mysqli_real_escape_string($mr_con,$_REQUEST['purpose'])==""){$message="<p class='alert alert-danger' role='alert'>Enter Purpose</p>";}
		else if(filter_var($_REQUEST['texp'], FILTER_VALIDATE_INT) == false){$message="<p class='alert alert-danger' role='alert'>Enter Total Amount</p>";}
		else if($_FILES['tplanningreport']['size']<=0){$message="<p class='alert alert-danger' role='alert'>Upload Tour Report</p>";}
		else{
			$rquestid="#".checkint(mt_rand(1000,999999999),'ec_expenses','bill_number');
			$empalias=$_SESSION['ec_user_alias'];
			$visitFromDate=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['visitFromDate']))));
			$visitToDate=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['visitToDate']))));
			$placesOfVisit=mysqli_real_escape_string($mr_con,$_REQUEST['placesOfVisit']);
			$purpose=mysqli_real_escape_string($mr_con,$_REQUEST['purpose']);
			$remarkss=mysqli_real_escape_string($mr_con,$_REQUEST['remarks']);
			$texp=array_sum($_REQUEST['amt'])+array_sum($_REQUEST['amt_l'])+array_sum($_REQUEST['lamt'])+array_sum($_REQUEST['bamt'])+array_sum($_REQUEST['oamt']);
			$reqdate=date("Y-m-d");
			$alias=aliasCheck(generateRandomString(),"ec_expenses","expenses_alias");
			$fault =array();
			if($empalias!=""){
				if($_REQUEST['amt'][0]!=""){	
					for($i=0;$i<count($_REQUEST['amt']);$i++){
						$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['dot'][$i]))));
						$fa[$i]=mysql_escape_string($_REQUEST['mot'][$i]);
						$fb[$i]=mysql_escape_string($_REQUEST['from'][$i]);
						$fc[$i]=mysql_escape_string($_REQUEST['to'][$i]);
						$fd[$i]=mysql_escape_string($_REQUEST['amt'][$i]);
						if($fd[$i]!=""){
							if($_FILES['motbill']['size'][$i]>0){
								$ext = pathinfo($_FILES['motbill']['name'][$i], PATHINFO_EXTENSION);
								$fileName=$empalias.generateRandomString()."TC.".$ext;
								move_uploaded_file($_FILES["motbill"]["tmp_name"][$i],"attachments/".$fileName);
								$profileimg = "attachments/".$fileName;
							}else $profileimg =0;
							$alias1=aliasCheck(generateRandomString(),"ec_conveyance","alias");
							if($profileimg=='0'){
								mysqli_query($mr_con,"INSERT INTO ec_conveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,document_link,created_date) VALUES('$alias','$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$alias1','$profileimg','$reqdate')");
								$fault[]=1;
							}elseif(file_exists($profileimg)){
								mysqli_query($mr_con,"INSERT INTO ec_conveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,document_link,created_date) VALUES('$alias','$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$alias1','$profileimg','$reqdate')");
								$fault[]=1;
							}else{ $fault[]=0;}
						}
					}
				}
				if($_REQUEST['amt_l'][0]!=""){	
					for($i=0;$i<count($_REQUEST['amt_l']);$i++){
						$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['dot_l'][$i]))));
						$fa[$i]=mysql_escape_string($_REQUEST['mot_l'][$i]);
						$fb[$i]=mysql_escape_string($_REQUEST['from_l'][$i]);
						$fc[$i]=mysql_escape_string($_REQUEST['to_l'][$i]);
						$fd[$i]=mysql_escape_string($_REQUEST['amt_l'][$i]);
						$alias1=aliasCheck(generateRandomString(),"ec_localconveyance","alias");
						if($fd[$i]!=""){

							mysqli_query($mr_con,"INSERT INTO ec_localconveyance(expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,created_date) VALUES('$alias','$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$alias1','$reqdate')");
						}
					}
				}
				if($_REQUEST['lamt'][0]!=""){	
					for($i=0;$i<count($_REQUEST['lamt']);$i++){
						$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkin'][$i]))));
						$fa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkout'][$i]))));
						$fb[$i]=mysql_escape_string($_REQUEST['typeofstay'][$i]);
						$fc[$i]=mysql_escape_string($_REQUEST['hotelName'][$i]);
						$fd[$i]=mysql_escape_string($_REQUEST['lamt'][$i]);
						if($fd[$i]!=""){
							if($_FILES['lfile']['size'][$i]>0){
								$ext1 = pathinfo($_FILES['lfile']['name'][$i], PATHINFO_EXTENSION);
								$fileName=$empalias.generateRandomString()."TL.".$ext1;
								move_uploaded_file($_FILES["lfile"]["tmp_name"][$i],"attachments/".$fileName);
								$profileimg = "attachments/".$fileName;
							}else $profileimg =0;
							$alias1=aliasCheck(generateRandomString(),"ec_lodging","alias");
							if($profileimg=='0'){
								mysqli_query($mr_con,"INSERT INTO ec_lodging(check_in,check_out,type_of_stay,hotel_name,amount,expenses_alias,alias,document_link,created_date) VALUES('$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$alias','$alias1','$profileimg','$reqdate')");
								$fault[]=1;
							}elseif(file_exists($profileimg)){
								mysqli_query($mr_con,"INSERT INTO ec_lodging(check_in,check_out,type_of_stay,hotel_name,amount,expenses_alias,alias,document_link,created_date) VALUES('$faa[$i]','$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$alias','$alias1','$profileimg','$reqdate')");
								$fault[]=1;
							}else{ $fault[]=0;}
						}
					}
				}
				if($_REQUEST['bamt'][0]!=""){
					for($i=0;$i<count($_REQUEST['bamt']);$i++){
						$fa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkinb'][$i]))));
						$fb[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['checkoutb'][$i]))));
						$fc[$i]=mysql_escape_string($_REQUEST['state'][$i]);
						$fd[$i]=mysql_escape_string($_REQUEST['bamt'][$i]);
						if($fd[$i]!=""){
							$alias1=aliasCheck(generateRandomString(),"ec_boarding","alias");
							mysqli_query($mr_con,"INSERT INTO ec_boarding(check_in,check_out,state,amount,expenses_alias,alias,created_date) VALUES('$fa[$i]','$fb[$i]','$fc[$i]','$fd[$i]','$alias','$alias1','$reqdate')");
						}
					}
				}
				if($_REQUEST['oamt'][0]!=""){	
					for($i=0;$i<count($_REQUEST['oamt']);$i++){
						$faa[$i]=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['odate'][$i]))));
						$fa[$i]=mysql_escape_string($_REQUEST['others'][$i]);
						$fb[$i]=mysql_escape_string($_REQUEST['oamt'][$i]);
						if($fb[$i]!=""){
							if($_FILES['ofile']['size'][$i]>0){
								$ext2 = pathinfo($_FILES['ofile']['name'][$i], PATHINFO_EXTENSION);
								$fileName=$empalias.generateRandomString()."TO.".$ext2;
								move_uploaded_file($_FILES["ofile"]["tmp_name"][$i],"attachments/".$fileName);
								$profileimg = "attachments/".$fileName;
							}else $profileimg =0;
							$alias1=aliasCheck(generateRandomString(),"ec_other_expenses","alias");
							if($profileimg=='0'){
								mysqli_query($mr_con,"INSERT INTO ec_other_expenses(checked_date, description, amount, expenses_alias, alias, document_link, created_date) VALUES('$faa[$i]','$fa[$i]','$fb[$i]','$alias','$alias1','$profileimg','$reqdate')");
								$fault[]=1;
							}elseif(file_exists($profileimg)){
								mysqli_query($mr_con,"INSERT INTO ec_other_expenses(checked_date, description, amount, expenses_alias, alias, document_link, created_date) VALUES('$faa[$i]','$fa[$i]','$fb[$i]','$alias','$alias1','$profileimg','$reqdate')");
								$fault[]=1;
							}else{ $fault[]=0;}
						}
					}
				}
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
			}else $message="<p class='alert alert-danger' role='alert'>Sorry Something Went Wrong! Please Referesh and try</p>";
		}
	}
?>
<style>
.tbform input[type="text"], .tbform input[type="file"], .tbform select{border:none !important;margin:0 !important;padding:0 !important;width:100% !important;outline:none !important;webkit-box-shadow: none;box-shadow: none;}
.tbform input[type="text"]:focus, .tbform input[type="file"]:focus, .tbform select:focus{outline:none !important;webkit-box-shadow: none;box-shadow: none;}
.table-bordered{margin-bottom:5px !important;}
.redd{color:#F00 !important;}

</style>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Book Expenses</h3>
	</div>
	<div class="panel-body">
        <form role="form" class="ss_form" method="post" id="defaultForm" novalidate>
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
            <input type='text' class="form-control dpd1 cddl" tabindex="1" name="visitFromDate" placeholder="DD-MM-YYYY" readonly="readonly" style="background-color:#fff;"/>
        </div>
        <div class="col-md-4 form-group">
            <label>Visit: End Date: </label>
            <input type='text' class="form-control dpd2 cddl" tabindex="2" name="visitToDate" placeholder="DD-MM-YYYY" readonly="readonly" style="background-color:#fff;"/>
        </div>
		</div>
        <div class="row">
            <div class="col-md-4 form-group">
                <label>No. of days: </label>
                <input type="text" tabindex="7" class="form-control" id="visitFromDate" placeholder="No. of days" readonly />
            </div>
            <div class="col-md-4 form-group">
                <label>Visited place's : </label>
                <input type="text" tabindex="3" class="form-control" name="placesOfVisit" placeholder="Places of Visit"/>
            </div>
            <div class="col-md-4 form-group">
                <label>Purpose: </label>
                <textarea tabindex="4" class="form-control reasonForAdv" name="purpose" placeholder="Purpose" ></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 form-group">
                <label>Remarks: </label>
                <textarea tabindex="4" class="form-control reasonForAdv" name="remarks" placeholder="Remarks" ></textarea>
            </div>
        </div>
        <div class="col-lg-12 form-group">
            <label>Conveyance : </label>&nbsp;&nbsp;<a href="#" data-get="fare0" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare0" class="RemoveField"><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix">
                <div class="column">
                    <table class="table table-bordered" id="fare_tab">
                        <thead><tr class="blue cust"><th>Date of travel</th><th>Mode of travel</th><th>From</th><th>To</th><th>Amount</th><th>Files (No special characters in file name)</th></tr></thead>
                        <tbody id='fare0'>
                            <tr class="tbform">
                                <td><input type="text" class="form-control expense_dates cddl bg-white" name="dot[]" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                                <td><select class="form-control" tabindex="2" required="required" name="mot[]" id="mot">
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
                                <td><input type="text" class="form-control amtt tamfor tcm" name="amt[]" placeholder="Amount"/></td>
                                <td><input type="hidden" class="form-control" name="motbill[]" value="0"/><input type="file" class="form-control" name="motbill[]"/></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-4 pull-right"><input type="text" class="form-control tcmt" name="fare_total" placeholder="Total Conveyance" readonly /></div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 form-group">
            <label>Local Conveyance : </label>&nbsp;&nbsp;<a href="#" data-get="fare5" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare5" class="RemoveField"><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix">
                <div class="column">
                    <table class="table table-bordered" id="fare_tab">
                        <thead><tr class="blue cust"><th>Date of travel</th><th>Mode of travel</th><th>From</th><th>To</th><th>Amount</th></tr></thead>
                        <tbody id='fare5'>
                            <tr class="tbform">
                                <td><input type="text" class="form-control  expense_dates cddl bg-white" name="dot_l[]" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                                <td><select class="form-control" tabindex="2" required="required" name="mot_l[]" id="mot">
                                        <option value="0">Mode of travel</option>
                                        <option value="Own Vehicle">Own Vehicle</option>
                                        <option value="Cab">Cab</option>
                                        <option value="Auto">Auto</option>
                                        <option value="Local Train">Local Train</option>
                                        <option value="Any Public Transport">Any Public Transport</option>
                                    </select></td>
                                <td><input type="text" class="form-control" name="from_l[]" placeholder="From"/></td>
                                <td><input type="text" class="form-control" name="to_l[]" placeholder="To"/></td>
                                <td><input type="text" class="form-control amtt tamfor ttcm" name="amt_l[]" placeholder="Amount"/></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-4 pull-right"><input type="text" class="form-control ttcmt" name="fare_total" placeholder="Total Local Conveyance" readonly /></div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 form-group">
            <label>Lodging : </label>&nbsp;&nbsp;<a href="#" data-get="fare1" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare1" class="RemoveField"><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix">
                <div class="column">
                    <table class="table table-bordered" id="fare_tab">
                        <thead><tr class="blue cust"><th>Type of Stay</th><th>Visit: Start Date:</th><th>Visit: End Date:</th><th>Hotel Name</th><th>Amount</th><th>Files (No special characters in file name)</th></tr></thead>
                        <tbody id='fare1'>
                            <tr class="tbform">
                                <td><select class="form-control lodging_self" name="typeofstay[]"><option value="0">Select Stay Type</option><option value="Reimbursement">Reimbursement</option><option value="Self">Self Arrangement</option></select></td>
                                <td><input type="text" class="form-control expense_dates checkin cddl bg-white" name="checkin[]" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                                <td><input type="text" class="form-control expense_dates checkout cddl bg-white" name="checkout[]" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                                <td class="changw"></td>
                                <td><input type="text" class="form-control amtt tamfor tlam selfamm" name="lamt[]" placeholder="Amount"/></td>
                                <td><input type="hidden" class="form-control" name="lfile[]" value="0"/><input type="file" class="form-control" name="lfile[]"/></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-4 pull-right"><input type="text" class="form-control tlamt" placeholder="Total Lodging" readonly /></div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 form-group">
            <label>Boarding Allowance: </label>&nbsp;&nbsp;<a href="#" data-get="fare" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare" class="RemoveField"><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix">
                <div class="column">
                    <table class="table table-bordered" id="fare_tab">
                        <thead><tr class="blue cust"><th>Visit: Start Date:</th><th>Visit: End Date:</th><th>State</th><th>Amount</th></tr></thead>
                        <tbody id='fare'>
                            <tr class="tbform">
                                <td><input type="text" class="form-control expense_dates checkin cddl bg-white" name="checkinb[]" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                                <td><input type="text" class="form-control expense_dates checkout cddl bg-white" name="checkoutb[]" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                                <td><select name="state[]" class="bodvalto bhtname">
                                		<option value="0">Select</option>
                                        <option value="a1">A+</option>
                                        <option value="a">A</option>
                                        <option value="b">B</option>
                                        <option value="c">C</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control amtt tamfor blam selfamm" name="bamt[]" placeholder="Amount"/></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-4 pull-right"><input type="text" class="form-control blamt" placeholder="Total Lodging" readonly /></div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 form-group">
            <label>Others : </label>&nbsp;&nbsp;<a href="#" data-get="fare2" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare2" class="RemoveField"><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix">
                <div class="column">
                    <table class="table table-bordered" id="fare_tab">
                        <thead><tr class="blue cust"><th>Description</th><th>Amount</th><th>Date</th><th>Files (No special characters in file name)</th></tr></thead>
                        <tbody id='fare2'>
                            <tr class="tbform">
                                <td><input type="text" class="form-control" name="others[]" placeholder="Description"/></td>
                                <td><input type="text" class="form-control amtt tamfor tlom" name="oamt[]" placeholder="Amount"/></td>
                                <td><input type="text" class="form-control expense_dates cddl bg-white" name="odate[]" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                                <td><input type="hidden" class="form-control" name="ofile[]" value="0"/><input type="file" class="form-control" name="ofile[]"/></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-4 pull-right"><input type="text" class="form-control tlomt" placeholder="Other's Total" readonly /></div>
                </div>
            </div>
        </div>
        <div class="col-md-4 form-group">
        <label>Outstanding Balance: </label>
        <input type="text" tabindex="14" class="form-control nsamt" value="<?php if (advanceNotSettled($_SESSION['ec_user_alias'])!=0)echo advanceNotSettled($_SESSION['ec_user_alias']); else echo "No pending Advances";?>" placeholder="Outstanding Balance" readonly />
        </div>
        <div class="col-md-4 form-group">
        <label>Total Expenses: </label>
        <input type="text" tabindex="14" class="form-control texp" name="texp" placeholder="Total Expenses" readonly />
        </div>
        <div class="col-md-4 form-group">
        <label>Final Amount (Total Expenses- Outstanding Balance): </label>
        <input type="text" tabindex="14" class="form-control finchamt" placeholder="Total Expenses- Outstanding Balance" readonly />
        </div>
        <!--<div class="col-md-4 form-group">
            <label>Reason/ Remarks: </label>
            <textarea tabindex="2" class="form-control" name="reasonForAdv" placeholder="Reason/ Remarks"></textarea>
        </div>
        -->
        <div class="col-md-4 form-group">
            <label>Tour Report: <small class="redd">(Mandatory)</small></label>
            <input type="file" class="form-control tplanningreport" name="tplanningreport" id="tplanningreport"/>
        	<small class="redd">(Kinldy upload PDF format and size not exceeding 1MB)</small>
        </div>
        <div class="col-md-4 form-group">&nbsp;</div>
        <div class="form-group col-xs-4 col-xs-offset-2 morpad">
            <div class="col-xs-12">
                <input tabindex="14" type="submit" class="btn btn-primary ss_buttons saveinDraft" name="saveinDraft" value="Draft">
                <input tabindex="13" type="submit" class="btn btn-primary ss_buttons ademp" name="addEmp" value="Submit Expense">
            </div>
        </div>
        </form>
</div>
</div>
<script>
	$(document).on('keyup','.tamfor',function (event){ 
		var tamt=tcmt=tlamt=blamt=tlomt=ttcm=0;
		$(".tamfor").each(function(){tamt+=Number($(this).val());});
		$(".tcm").each(function(){tcmt+=Number($(this).val());});
		$(".ttcm").each(function(){ttcm+=Number($(this).val());});
		$(".tlam").each(function(){tlamt+=Number($(this).val());});
		$(".blam").each(function(){blamt+=Number($(this).val());});
		$(".tlom").each(function(){tlomt+=Number($(this).val());});
		$('.ttcmt').val(ttcm);
		$('.tcmt').val(tcmt);$('.tlamt').val(tlamt);$('.blamt').val(blamt);$('.tlomt').val(tlomt);$('.texp').val(tamt);$('.finchamt').val(tamt-Number($('.nsamt').val()));
	});
	$(document).on('focus','.tamfor',function (event){ 
		var tamt=tcmt=tlamt=blamt=tlomt=ttcm=0;
		$(".tamfor").each(function(){tamt+=Number($(this).val());});
		$(".tcm").each(function(){tcmt+=Number($(this).val());});
		$(".ttcm").each(function(){ttcm+=Number($(this).val());});
		$(".tlam").each(function(){tlamt+=Number($(this).val());});
		$(".blam").each(function(){blamt+=Number($(this).val());});
		$(".tlom").each(function(){tlomt+=Number($(this).val());});
		$('.ttcmt').val(ttcm);
		$('.tcmt').val(tcmt);$('.tlamt').val(tlamt);$('.blamt').val(blamt);$('.tlomt').val(tlomt);$('.texp').val(tamt);$('.finchamt').val(tamt-Number($('.nsamt').val()));
	});
	$(document).on('change','.lodging_self',function(event){
		event.preventDefault();
		thisVal=$(this).val()
		$parentone=$(this).parents('.tbform');
		if(thisVal=="Self"){
			$parentone.children('.changw').html('<select name="hotelName[]" class="lodvalto htname"><option value="0">Select</option><option value="a1">A+</option><option value="a">A</option><option value="b">B</option><option value="c">C</option></select>');
		}else{
			$parentone.children('.changw').html('<input type="text" class="form-control htname" name="hotelName[]" placeholder="Hotel Name"/>');
			var coutdate1=$parentone.find('input[name="lamt[]"]');
			coutdate1.val("");
			coutdate1.focus();
			coutdate1.removeAttr("readonly");
		}
	});
	$(document).on('change','.lodvalto',function(event){
		event.preventDefault();
		thisVal=$(this).val()
		$parentone=$(this).parents('.tbform');
		var cindate=$parentone.find('.checkin');
		var coutdate=$parentone.find('.checkout');
		if(cindate.val()!="" && coutdate.val()!=""){
			$.ajax({
				url: "item.php",
				type: "POST",
				data: 'locding='+thisVal+'&cindate='+cindate.val()+'&coutdate='+coutdate.val(),
				success: function(result) {
					var coutdate1=$parentone.find('.amtt');
					coutdate1.val(result.trim());
					coutdate1.attr("readonly","readonly");
					coutdate1.focus();
				}
			});
		}
	});
	$(document).on('change','.bodvalto',function(event){
		event.preventDefault();
		thisVal=$(this).val()
		$parentone=$(this).parents('.tbform');
		var cindate=$parentone.find('.checkin');
		var coutdate=$parentone.find('.checkout');
		if(cindate.val()!="" && coutdate.val()!=""){
			$.ajax({
				url: "item.php",
				type: "POST",
				data: 'bodding='+thisVal+'&cindate='+cindate.val()+'&coutdate='+coutdate.val(),
				success: function(result) {
					var coutdate1=$parentone.find('.amtt');
					coutdate1.val(result.trim());
					coutdate1.attr("readonly","readonly");
					coutdate1.focus();
				}
			});
		}
	});
depDate();
function depDate(){
	var nowTemp = new Date();
	var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
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
		$.ajax({
			type: "GET",
			url: "include/helper.php",
			data: 'd1='+sDate+'&d2='+eDate+'&rf=days',
			cache: true,
			success: function(result){$('#visitFromDate').val(result);}
		});
		checkin.hide();
		 $('.dpd2')[0].focus();
	}).data('datepicker');
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
	}).data('datepicker');
	var  expense_dates= $('.expense_dates').datepicker({
			format: 'dd-mm-yyyy',
			onRender: function(date){
				if(date.valueOf() > now.valueOf()) return 'disabled';
				else return '';
			}
		}).on('changeDate', function(ev){$(this).datepicker('hide');
	}).data('datepicker');
}
</script>

