<style>
	.tbform input[type="text"], .tbform input[type="file"], .tbform select{border:none !important;margin:0 !important;padding:0 !important;width:100% !important;outline:none !important;webkit-box-shadow: none;box-shadow: none;}
	.tbform input[type="text"]:focus, .tbform input[type="file"]:focus, .tbform select:focus{outline:none !important;webkit-box-shadow: none;box-shadow: none;}
	.table-bordered{margin-bottom:5px !important;}
</style>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Book Expense</h3>
	</div>
	<div class="panel-body">
	<form role="form" class="ss_form" method="post" id="defaultForm" novalidate>
    <p class='alerta' role='alert'></p>
		<div class="col-xs-10 jerror"><?php if(isset($message))echo $message;?></div>
		<input type="hidden" value="<?php echo $ref;?>" name="ref" />
		<input type="hidden" value="<?php echo $expList[0]['approval_level'];?>" class="ref2" name="ref2" />
		<input type="hidden" value="<?php echo $expList[0]['expenses_alias'];?>" name="id" />
		<div class="col-md-4 form-group">
			<label>Date of Request : </label>
			<input class="form-control" type="text" name="dateofRequest" value="<?php echo date('d-M-Y'); ?>" placeholder="Date of Request" readonly="readonly"/>
		</div>
		<div class="col-md-4 form-group">
			<label>Employee ID : </label>
			<input class="form-control" type="text" name="empId" value="<?php echo employeeDetails('employee_id',$expList[0]['employee_alias']);?>" placeholder="Employee ID" readonly="readonly"/>
		</div>
		<div class="col-md-4 form-group">
			<label>Employee Name: </label>
			<input class="form-control" type="text" name="empName" value="<?php echo employeeDetails('name',$expList[0]['employee_alias']);?>" placeholder="Employee Name" readonly="readonly"/>
		</div>
		<div class="col-md-4 form-group">
			<label>Grade: </label>
			<input class="form-control" type="text" name="empGrade"  value="<?php echo grade($expList[0]['employee_alias'])?>" placeholder="Grade" readonly="readonly"/>
		</div>
		<div class="col-md-4 form-group">
			<label>Visit: Start Date: </label>
			<input type='text' class="form-control dpd1 cddl" tabindex="0" autofocus="autofocus" name="visitFromDate"  value="<?php echo date("d-m-Y", strtotime($expList[0]['period_of_visit_from'])); ?>"  placeholder="Period of Visit From" />
		</div>
		<div class="col-md-4 form-group">
			<label>Visit: End Date: </label>
			<input type='text' class="form-control dpd2 cddl" tabindex="0" name="visitToDate"  value="<?php echo date("d-m-Y", strtotime($expList[0]['period_of_visit_to'])); ?>" placeholder="Period of Visit To" />
		</div>
		<div class="col-md-4 form-group">
			<label>No. of days: </label>
			<input type="text" class="form-control" id="visitFromDate" value="<?php echo noofDays($expList[0]['period_of_visit_from'],$expList[0]['period_of_visit_to']);?>" placeholder="No. of days" readonly="readonly"/>
		</div>
		<div class="col-md-4 form-group">
			<label>Visited place's : </label>
			<input type="text" tabindex="0" class="form-control" name="placesOfVisit" value="<?php echo $expList[0]['places_of_visit'];?>" placeholder="Places of Visit" />
		</div>
		<div class="col-md-4 form-group">
            <label>Purpose: </label>
            <textarea tabindex="0" class="form-control" name="purpose" placeholder="Purpose" ><?php echo $expList[0]['purpose'];?></textarea>
		</div>
        <div class="row">
            <div class="col-md-4 form-group">
                <label>Remarks: </label>
                <textarea tabindex="4" class="form-control reasonForAdv" name="remarks" placeholder="Remarks" ><?php echo $remarks[0]['remarks'];?></textarea>
            </div>
        </div>
		<div class="col-lg-12 form-group">
			<label>Conveyance : </label>&nbsp;&nbsp;<a href="#" data-get="fare0" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span> New Field</a>
			<div class="clearfix">
				<div class="column">
                    <table class="table table-bordered" id="fare_tab">
                        <thead><tr class="blue cust"><th>Date of travel</th><th>Mode of travel</th><th>From</th><th>To</th><th>Amount</th><th>Files</th></tr></thead>
                        <?php if($conveyance!=0){?>
                        <tbody>
                           <?php foreach($conveyance as $conveyance1){$tamt+=$conveyance1['amount'];?>
                            <tr class="tbform">
                                <td>
                                    <input type="hidden" name="idc[]" value="<?php echo $conveyance1['alias'];?>"/>
                                    <input type="text" tabindex="0" class="form-control expense_dates cddl" name="dot[]" value="<?php echo date("d-m-Y", strtotime($conveyance1['date_of_travel'])); ?>" />
                                </td>
                                <td>
                                    <select class="form-control" name="mot[]" id="mot" tabindex="0" >
                                        <option value="0">Mode of travel</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'ACT');?> value="ACT">ACT</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'AIR');?> value="AIR">Air</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Train 2nd AC');?> value="Train 2nd AC">Train 2nd AC</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Train 3 tier');?> value="Train 3 tier">Train 3 tier</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Train Sleeper');?> value="Train Sleeper">Train Sleeper</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Volvo AC Bus');?> value="Volvo AC Bus">Volvo AC Bus</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Non-AC Bus');?> value="Non-AC Bus">Non-AC Bus</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control" tabindex="0" value="<?php echo $conveyance1['from_place'];?>" name="from[]" placeholder="From"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control" tabindex="0" value="<?php echo $conveyance1['to_place'];?>" name="to[]" placeholder="To"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control amtt tamfor tcm" tabindex="0" value="<?php echo $conveyance1['amount'];?>" name="amt[]" placeholder="Amount"/>
                                </td>
                                <td>
                                    <input type="hidden" class="form-control" name="motbill_old[]" value="<?php echo $conveyance1['document_link'];?>"/>
                                    <?php if($conveyance1['document_link']!=='0'){?>
                                        <a href="<?php echo $conveyance1['document_link'];?>" target="_blank" class="pdfil col-md-2">Click</a>
                                    <?php }?>
                                    <div class="col-md-10">
	                                    <input type="hidden" class="form-control" name="motbill[]" value="0"/>
                                    	<input type="file" class="form-control" tabindex="0" name="motbill[]"/>
                                    </div>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                        <?php }?>
                        <tbody id='fare0'>
                            <tr class="tbform">
                                <td>
                                    <input type="hidden" name="idc[]" value="0"/>
                                    <input type="text" class="form-control expense_dates cddl" tabindex="0" name="dot[]" placeholder="DD-MM-YYYY"/>
                                </td>
                                <td>
                                    <select class="form-control" tabindex="0" name="mot[]" id="mot">
                                        <option value="0">Mode of travel</option>
                                        <option value="ACT">ACT</option>
                                        <option value="AIR">Air</option>
                                        <option value="Train 2nd AC">Train 2nd AC</option>
                                        <option value="Train 3 tier">Train 3 tier</option>
                                        <option value="Train Sleeper">Train Sleeper</option>
                                        <option value="Volvo AC Bus">Volvo AC Bus</option>
                                        <option value="Non-AC Bus">Non-AC Bus</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control" tabindex="0" name="from[]" placeholder="From"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control" tabindex="0" name="to[]" placeholder="To"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control amtt tamfor tcm" name="amt[]" tabindex="0" placeholder="Amount"/>
                                </td>
                                <td>
                                    <input type="hidden" class="form-control" name="motbill[]" value="0"/>
                                    <input type="file" class="form-control" tabindex="0" name="motbill[]"/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
					<div class="col-md-4 pull-right"><input type="text" class="form-control tcmt" name="fare_total" placeholder="Total Conveyance"  value="<?php if($tamt!=0) echo $tamt;?>"/></div>
				</div>
			</div>
		</div>
		<div class="col-lg-12 form-group">
			<label>Local Conveyance : </label>&nbsp;&nbsp;<a href="#" data-get="fare5" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span> New Field</a>
			<div class="clearfix">
				<div class="column">
					<table class="table table-bordered" id="fare_tab">
						<thead><tr class="blue cust"><th>Date of travel</th><th>Mode of travel</th><th>From</th><th>To</th><th>Amount</th></tr></thead>
						<?php if($lconveyance!=0){?>
						<tbody>
							<?php foreach($lconveyance as $conveyance1){$tamtll+=$conveyance1['amount'];?>
							<tr class="tbform">
                                <td>
                                    <input type="hidden" name="idc_l[]" value="<?php echo $conveyance1['alias'];?>"/>
                                    <input type="text" class="form-control expense_dates cddl" tabindex="0" value="<?php echo date("d-m-Y", strtotime($conveyance1['date_of_travel']));?>" name="dot_l[]" placeholder="DD-MM-YYYY"/>
                                </td>
                                <td>
                                    <select class="form-control" tabindex="0" name="mot_l[]" id="mot">
                                        <option value="0">Mode of travel</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Own Vehicle');?> value="Own Vehicle">Own Vehicle</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Cab');?> value="Cab">Cab</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Auto');?> value="Auto">Auto</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Local Train');?> value="Local Train">Local Train</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Any Public Transport');?> value="Any Public Transport">Any Public Transport</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control" tabindex="0" value="<?php echo $conveyance1['from_place'];?>" name="from_l[]" placeholder="From"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control" tabindex="0" value="<?php echo $conveyance1['to_place'];?>" name="to_l[]" placeholder="To"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control amtt tamfor ttcm" value="<?php echo $conveyance1['amount'];?>" name="amt_l[]" placeholder="Amount"/>
                                </td>
							</tr>
							<?php }?>
						</tbody>
					<?php }?>
					<tbody id='fare5'>
						<tr class="tbform">
                            <td>
                                <input type="hidden" name="idc_l[]" value="0"/>
                                <input type="text" class="form-control expense_dates cddl" tabindex="0" name="dot_l[]" placeholder="DD-MM-YYYY"/>
                            </td>
                            <td>
                                <select class="form-control" tabindex="0" name="mot_l[]" id="mot">
                                    <option value="0">Mode of travel</option>
                                    <option value="Own Vehicle">Own Vehicle</option>
                                    <option value="Cab">Cab</option>
                                    <option value="Auto">Auto</option>
                                    <option value="Local Train">Local Train</option>
                                    <option value="Any Public Transport">Any Public Transport</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control" tabindex="0" name="from_l[]" placeholder="From"/>
                            </td>
                            <td>
                                <input type="text" class="form-control" tabindex="0" name="to_l[]" placeholder="To"/>
                            </td>
                            <td>
                                <input type="text" class="form-control amtt tamfor ttcm" tabindex="0" name="amt_l[]" placeholder="Amount"/>
                            </td>
						</tr>
					</tbody>
				</table>
				<div class="col-md-4 pull-right"><input type="text" class="form-control ttcmt" name="fare_total" placeholder="Total Conveyance"  value="<?php if($tamtll!=0) echo $tamtll;?>"/></div>
			</div>
		</div>
	</div>
	<div class="col-lg-12 form-group">
		<label>Lodging : </label>&nbsp;&nbsp;<a href="#" data-get="fare1" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span> New Field</a>
		<div class="clearfix">
			<div class="column">
				<table class="table table-bordered" id="fare_tab">
					<thead><tr class="blue cust"><th>Type of Stay</th><th>Visit: Start Date:</th><th>Visit: End Date:</th><th>Hotel Name</th><th>Amount</th><th>Files</th></tr></thead>
					<?php if($lodging!=0){?>
					<tbody>
						<?php foreach($lodging as $lodging1){$tamtl+=$lodging1['amount'];?>
						<tr class="tbform">
                            <td>
                                <input type="hidden" name="idl[]" tabindex="0" value="<?php echo $lodging1['alias'];?>"/>
                                <select class="form-control lodging_self" name="typeofstay[]" tabindex="0" >
                                    <option value="0">Select Stay Type</option>
                                    <option <?php echo checkSelected($lodging1['type_of_stay'],'Reimbursement');?> value="Reimbursement">Reimbursement</option>
                                    <option <?php echo checkSelected($lodging1['type_of_stay'],'Self');?> value="Self">Self</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control expense_dates checkin cddl" tabindex="0" value="<?php echo date("d-m-Y", strtotime($lodging1['check_in'])); ?>" name="checkin[]" placeholder="DD-MM-YYYY"/>
                            </td>
                            <td>
                                <input type="text" class="form-control expense_dates checkout cddl" tabindex="0" value="<?php echo date("d-m-Y", strtotime($lodging1['check_out'])); ?>" name="checkout[]" placeholder="DD-MM-YYYY"/>
                            </td>
                            <td class="changw">
                                <input type="text" class="form-control htname" name="hotelName[]" tabindex="0" value="<?php echo $lodging1['hotel_name'];?>" placeholder="Hotel Name"/>
                            </td>
                            <td>
                                <input type="text" class="form-control amtt tamfor tlam selfamm" tabindex="0" name="lamt[]" value="<?php echo $lodging1['amount'];?>" placeholder="Amount"/>
                            </td>
							<td>
								<input type="hidden" class="form-control" name="lfile_old[]" value="<?php echo $lodging1['document_link'];?>"/>
								<?php if($lodging1['document_link']!=='0'){?>
                                    <a href="<?php echo $lodging1['document_link'];?>" target="_blank" class="pdfil col-md-2">Click</a>
                                <?php }?>
								<div class="col-md-10">
                                    <input type="hidden" class="form-control" name="lfile[]" value="0"/>
                                    <input type="file" class="form-control" tabindex="0" name="lfile[]"/>
                                </div>
							</td>
						</tr>
						<?php }?>
						</tbody>
					<?php }?>
					<tbody id='fare1'> 
						<tr class="tbform">
                            <td>
                                <input type="hidden" name="idl[]" value="0"/>
                                <select class="form-control lodging_self" tabindex="0" name="typeofstay[]" >
                                    <option value="0">Select Stay Type</option>
                                    <option value="Reimbursement">Reimbursement</option>
                                    <option value="Self">Self</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control expense_dates checkin cddl" tabindex="0" name="checkin[]" placeholder="DD-MM-YYYY"/>
                            </td>
                            <td>
                                <input type="text" class="form-control expense_dates checkout cddl" tabindex="0" name="checkout[]" placeholder="DD-MM-YYYY"/>
                            </td>
							<td class="changw"></td>
                            <td>
                                <input type="text" class="form-control amtt tamfor tlam selfamm" tabindex="0" name="lamt[]" placeholder="Amount"/>
                            </td>
                            <td>
                                <input type="hidden" class="form-control" name="lfile[]" value="0"/>
                                <input type="file" class="form-control" tabindex="0" name="lfile[]"/>
                            </td>
						</tr>
					</tbody>
				</table>
				<div class="col-md-4 pull-right"><input type="text" class="form-control tlamt" placeholder="Total Lodging" value="<?php if($tamtl!=0) echo $tamtl;?>"/></div>
			</div>
		</div>
	</div>
	<div class="col-lg-12 form-group">
	<label>Boarding Allowance: </label>&nbsp;&nbsp;<a href="#" data-get="fare" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span> New Field</a>
		<div class="clearfix">
			<div class="column">
				<table class="table table-bordered" id="fare_tab">
					<thead><tr class="blue cust"><th>Visit: Start Date:</th><th>Visit: End Date:</th><th>State</th><th>Amount</th></tr></thead>
					<?php if($boarding!=0){?>
					<tbody>
						<?php foreach($boarding as $boarding1){$bamtl+=$boarding1['amount'];?>
						<tr class="tbform">
                            <td>
                                <input type="hidden" name="idb[]" tabindex="0" value="<?php echo $boarding1['alias'];?>"/>
                                <input type="text" class="form-control expense_dates checkin cddl" tabindex="0" value="<?php echo date("d-m-Y", strtotime($boarding1['check_in'])); ?>" name="checkinb[]" placeholder="DD-MM-YYYY"/>
                            </td>
                            <td>
                                <input type="text" class="form-control expense_dates checkout cddl" tabindex="0" value="<?php echo date("d-m-Y", strtotime($boarding1['check_out'])); ?>" name="checkoutb[]" placeholder="DD-MM-YYYY"/>
                            </td>
                            <td>
                            	<select name="state[]" class="bodvalto bhtname">
                                    <option value="0">Select</option>
                                    <option value="a1" <?php echo checkSelected($boarding1['state'],'a1');?>>A+</option>
                                    <option value="a" <?php echo checkSelected($boarding1['state'],'a');?>>A</option>
                                    <option value="b" <?php echo checkSelected($boarding1['state'],'b');?>>B</option>
                                    <option value="c" <?php echo checkSelected($boarding1['state'],'c');?>>C</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control amtt tamfor blam selfamm" tabindex="0" name="bamt[]" value="<?php echo $boarding1['amount'];?>" placeholder="Amount"/>
                            </td>
						</tr>
						<?php }?>
						</tbody>
					<?php }?>
					<tbody id='fare'> 
						<tr class="tbform">
                            <td>
                                <input type="hidden" name="idb[]" value="0"/>
                                <input type="text" class="form-control expense_dates checkin cddl" tabindex="0" name="checkinb[]" placeholder="DD-MM-YYYY"/>
                            </td>
                            <td>
                                <input type="text" class="form-control expense_dates checkout cddl" tabindex="0" name="checkoutb[]" placeholder="DD-MM-YYYY"/>
                            </td>
							<td><select name="state[]" class="bodvalto bhtname">
                                    <option value="0">Select</option>
                                    <option value="a1">A+</option>
                                    <option value="a">A</option>
                                    <option value="b">B</option>
                                    <option value="c">C</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control amtt tamfor blam selfamm" tabindex="0" name="bamt[]" placeholder="Amount"/>
                            </td>
						</tr>
					</tbody>
				</table>
				<div class="col-md-4 pull-right"><input type="text" class="form-control blamt" placeholder="Total Lodging" value="<?php if($bamtl!=0) echo $bamtl;?>"/></div>
			</div>
		</div>
	</div>
	<div class="col-lg-12 form-group">
		<label>Others : </label>&nbsp;&nbsp;<a href="#" data-get="fare2" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span> New Field</a>
		<div class="clearfix">
			<div class="column">
				<table class="table table-bordered" id="fare_tab">
					<thead><tr class="blue cust"><th>Description</th><th>Amount</th><th>Date</th><th>Files</th></tr></thead>
					<?php if($other_expenses!=0){?>
					<tbody>
						<?php foreach($other_expenses as $other_expenses1){$tamte+=$other_expenses1['amount'];?>
						<tr class="tbform">
                            <td>
                                <input type="hidden" name="ido[]" value="<?php echo $other_expenses1['alias'];?>" />
                                <input type="text" class="form-control" name="others[]" tabindex="0" value="<?php echo $other_expenses1['description'];?>"  placeholder="Description"/>
                            </td>
                            <td>
                                <input type="text" class="form-control amtt tamfor tlom" tabindex="0" value="<?php echo $other_expenses1['amount'];?>"  name="oamt[]" placeholder="Amount"/>
                            </td>
                            <td>
                                <input type="text" class="form-control expense_dates cddl" tabindex="0" value="<?php echo date("d-m-Y", strtotime($other_expenses1['checked_date'])); ?>"  name="odate[]" placeholder="DD-MM-YYYY"/>
                            </td>
                            <td>
                                <input type="hidden" class="form-control" name="ofile_old[]" value="<?php echo $other_expenses1['document_link'];?>"/>
                                <?php if($other_expenses1['document_link']!=='0'){?>
                                    <a href="<?php echo $other_expenses1['document_link'];?>" target="_blank" class="pdfil col-md-2">Click</a>
                                <?php }?>
                                <div class="col-md-10">
                                    <input type="hidden" class="form-control" name="ofile[]" value="0"/>
                                    <input type="file" class="form-control" tabindex="0" name="ofile[]"/>
                                </div>
                            </td>
						</tr>
						<?php }?>
					</tbody>
					<?php }?>
                    <tbody id='fare2'>  
                        <tr class="tbform">
                            <td>
                                <input type="hidden" name="ido[]" value="0"/>
                                <input type="text" class="form-control" tabindex="0" name="others[]" placeholder="Description"/>
                            </td>
                            <td>
                                <input type="text" class="form-control amtt tamfor tlom" tabindex="0" name="oamt[]" placeholder="Amount"/>
                            </td>
                            <td>
                                <input type="text" class="form-control expense_dates cddl" tabindex="0" name="odate[]" placeholder="DD-MM-YYYY"/>
                            </td>
                            <td>
                                <input type="hidden" class="form-control" name="ofile[]" value="0"/>
                                <input type="file" class="form-control" tabindex="0" name="ofile[]"/>
                            </td>
                        </tr>
                    </tbody>
				</table>
				<div class="col-md-4 pull-right"><input type="text" class="form-control tlomt" placeholder="Other's Total" value="<?php if($tamte!=0) echo $tamte;?>" /></div>
			</div>
		</div>
	</div>
	<div class="col-md-4 form-group">
		<label>Outstanding Balance: </label>
		<input type="text" class="form-control nsamt" value="<?php if(advanceNotSettled($expList[0]['employee_alias'])!=0)echo advanceNotSettled($expList[0]['employee_alias']); else echo "No pending Advances";?>" placeholder="Outstanding Balance"/>
	</div>
    <div class="col-md-4 form-group">
        <label>Total Expenses: </label>
        <input type="text" class="form-control texp" name="texp" value="<?php echo $expList[0]['total_tour_expenses'];?>" placeholder="Total Expenses"/>
    </div>
    <div class="col-md-4 form-group">
        <label>Final Amount (Total Expenses - Outstanding Balance): </label>
        <input type="text" class="form-control finchamt" value="<?php echo ($expList[0]['total_tour_expenses']-advanceNotSettled($expList[0]['employee_alias']));?>" placeholder="Total Expenses- Outstanding Balance"/>
    </div>
    <div class="col-md-4 form-group">
        <input type="hidden" class="form-control" name="tplanningreport_old" value="<?php echo $expList[0]['report'];?>"/>
        <label>Tour Report: 
           <?php if($expList[0]['report']!=='0' && $expList[0]['report']!==''){?><a href="<?php echo $expList[0]['report'];?>" target="_blank" class="pdfil">Click for old Report</a><?php }?>
        </label>
        <input type="file" class="form-control tplanningreport" name="tplanningreport" id="tplanningreport"/>
        <small class="redd">(Kinldy upload PDF format and size not exceeding 1MB)</small>
    </div>

	<div class="col-md-12">
        <div class="col-md-4 col-md-offset-4">
	        <input tabindex="14" type="submit" class="btn btn-primary ss_buttons saveinDraft" name="saveinDraft" value="Draft">
            <input tabindex="0" type="submit" class="btn btn-primary ss_buttons updatex" name="approve" value="Request">
        </div>
	</div>