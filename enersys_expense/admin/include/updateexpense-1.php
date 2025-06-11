	<style>
    .tbform input[type="text"], .tbform input[type="file"], .tbform select{border:none !important;margin:0 !important;padding:0 !important;width:100% !important;outline:none !important;webkit-box-shadow: none;box-shadow: none;}
    .tbform input[type="text"]:focus, .tbform input[type="file"]:focus, .tbform select:focus{outline:none !important;webkit-box-shadow: none;box-shadow: none;}
    .table-bordered{margin-bottom:5px !important;} 
	.form-control[disabled], .form-control[readonly="readonly"], fieldset[disabled] .form-control{background:none !important;}
    </style>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title" style="display:inline-block;">Book Expense</h3>
        </div>
        <div class="panel-body">
    	<form role="form" class="ss_form" method="post" id="defaultForm" novalidate>
        <p class='alerta' role='alert'></p>
            <input type="hidden" value="<?php echo $ref;?>" name="ref" />
            <input type="hidden" value="<?php echo $expList[0]['approval_level'];?>" class="ref2" name="ref2" />
            <input type="hidden" value="<?php echo $expList[0]['expenses_alias'];?>" name="id" />
            <?php if(isset($message))echo $message;?>
            <div class="col-md-4 form-group">
                <label>Date of Request : </label>
                <input class="form-control" type="text" value="<?php echo date("d-m-Y", strtotime($expList[0]['requested_date']));?>" placeholder="Date of Request" readonly="readonly"/>
            </div>
            <div class="col-md-4 form-group">
                <label>Employee ID : </label>
                <input class="form-control" type="text" value="<?php echo employeeDetails('employee_id',$expList[0]['employee_alias']);?>" placeholder="Employee ID" readonly="readonly"/>
            </div>
            <div class="col-md-4 form-group">
                <label>Employee Name: </label>
                <input class="form-control" type="text" value="<?php echo employeeDetails('name',$expList[0]['employee_alias']);?>" placeholder="Employee Name" readonly="readonly"/>
            </div>
            <div class="col-md-4 form-group">
                <label>Grade: </label>
                <input class="form-control" type="text" value="<?php echo grade($expList[0]['employee_alias'])?>" placeholder="Grade" readonly="readonly"/>
            </div>
            <div class="col-md-4 form-group">
                <label>Visit: Start Date: </label>
                <input type='text' class="form-control" tabindex="1" value="<?php echo date("d-m-Y", strtotime($expList[0]['period_of_visit_from'])); ?>"  placeholder="Period of Visit From" readonly="readonly"/>
            </div>
            <div class="col-md-4 form-group">
                <label>Visit: End Date: </label>
                <input type='text' class="form-control" tabindex="2" value="<?php echo date("d-m-Y", strtotime($expList[0]['period_of_visit_to'])); ?>" placeholder="Period of Visit To" readonly="readonly"/>
            </div>
            <div class="col-md-4 form-group">
                <label>No. of days: </label>
                <input type="text" tabindex="7" class="form-control" id="visitFromDate" placeholder="No. of days" readonly="readonly" />
            </div>
            <div class="col-md-4 form-group">
                <label>Visited place's : </label>
                <input type="text" tabindex="3" class="form-control" value="<?php echo $expList[0]['places_of_visit'];?>" placeholder="Places of Visit" readonly="readonly"/>
            </div>
            <div class="col-md-4 form-group">
                <label>Purpose: </label>
                <textarea tabindex="4" class="form-control" placeholder="Purpose" readonly="readonly"><?php echo $expList[0]['purpose'];?></textarea>
            </div>
            <div class="col-lg-12 form-group">
                <label>Conveyance : </label>
                <div class="clearfix">
                    <div class="column">
                        <table class="table table-bordered" id="fare_tab">
                            <thead><tr class="blue cust"><th>Date of travel</th><th>Mode of travel</th><th>From</th><th>To</th><th>Amount</th><th>Files</th></tr></thead>
                            <tbody id='fare0'>
                            <?php if($conveyance!=0){foreach($conveyance as $conveyance1){$tamt+=$conveyance1['amount'];?>
                                
                                <tr class="tbform">
                                    <td><input type="text" class="form-control" value="<?php echo date("d-m-Y", strtotime($conveyance1['date_of_travel'])); ?>"   placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                                    <td><input type="text" class="form-control" value="<?php echo $conveyance1['mode_of_travel']; ?>" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                                    <td><input type="text" class="form-control" value="<?php echo $conveyance1['from_place'];?>" placeholder="From" readonly="readonly"/></td>
                                    <td><input type="text" class="form-control" value="<?php echo $conveyance1['to_place'];?>" placeholder="To" readonly="readonly"/></td>
                                    <td><input type="text" class="form-control tamfor tcm" value="<?php echo $conveyance1['amount'];?>" placeholder="Amount" readonly="readonly"/></td>
                                    <td><?php if($conveyance1['document_link']!=='0'){?><a href="<?php echo $conveyance1['document_link'];?>" target="_blank" class="pdfil col-md-2" align='center'>Click</a><?php }else echo "<p class='col-md-12' align='center'>-NA-</p>";?></td>
                                </tr>
                                <?php }}else echo "<tr><td colspan='4' align='center'>No Records</td></tr>";?>
                            </tbody>
                        </table>
                        <div class="col-md-4 pull-right"><input type="text" class="form-control tcmt" placeholder="Total Conveyance" value="<?php if($tamt!=0) echo $tamt;?>"  readonly="readonly"/></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 form-group">
                <label>Local Conveyance : </label>
                <div class="clearfix">
                    <div class="column">
                        <table class="table table-bordered" id="fare_tab">
                            <thead><tr class="blue cust"><th>Date of travel</th><th>Mode of travel</th><th>From</th><th>To</th><th>Amount</th></tr></thead>
                            <tbody id='fare0'>
                            <?php if($lconveyance!=0){foreach($lconveyance as $conveyance1){$tamt+=$conveyance1['amount'];?>
                                
                                <tr class="tbform">
                                    <td><input type="text" class="form-control" value="<?php echo date("d-m-Y", strtotime($conveyance1['date_of_travel'])); ?>"   placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                                    <td><input type="text" class="form-control" value="<?php echo $conveyance1['mode_of_travel']; ?>" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                                    <td><input type="text" class="form-control" value="<?php echo $conveyance1['from_place'];?>" placeholder="From" readonly="readonly"/></td>
                                    <td><input type="text" class="form-control" value="<?php echo $conveyance1['to_place'];?>" placeholder="To" readonly="readonly"/></td>
                                    <td><input type="text" class="form-control tamfor tcm" value="<?php echo $conveyance1['amount'];?>" placeholder="Amount" readonly="readonly"/></td>
                                </tr>
                                <?php }}else echo "<tr><td colspan='4' align='center'>No Records</td></tr>";?>
                            </tbody>
                        </table>
                        <div class="col-md-4 pull-right"><input type="text" class="form-control tcmt" placeholder="Total Local Conveyance" value="<?php if($tamt!=0) echo $tamt;?>"  readonly="readonly"/></div>
                    </div>
                </div>
            </div>
    <div class="col-lg-12 form-group">
        <label>Lodging : </label>
        <div class="clearfix">
            <div class="column">
                <table class="table table-bordered" id="fare_tab">
                    <thead><tr class="blue cust"><th>Type of Stay</th><th>Visit: Start Date:</th><th>Visit: End Date:</th><th>Hotel Name</th><th>Amount</th><th>Files</th></tr></thead>
                    <tbody id='fare1'>
						<?php if($lodging!=0){foreach($lodging as $lodging1){$tamtl+=$lodging1['amount'];?>
                        
                        <tr class="tbform">
                            <td><input type="text" class="form-control " value="<?php echo $lodging1['type_of_stay']?>" readonly="readonly" /></td>
                            <td><input type="text" class="form-control " value="<?php echo date("d-m-Y", strtotime($lodging1['check_in'])); ?>" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                            <td><input type="text" class="form-control " value="<?php echo date("d-m-Y", strtotime($lodging1['check_out'])); ?>" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                            <td><input type="text" class="form-control" value="<?php echo $lodging1['hotel_name'];?>" placeholder="Hotel Name" readonly="readonly"/></td>
                            <td><input type="text" class="form-control tamfor tlam" value="<?php echo $lodging1['amount'];?>" placeholder="Amount" readonly="readonly"/></td>
                            <td><?php if($lodging1['document_link']!=='0'){?><a href="<?php echo $lodging1['document_link'];?>" target="_blank" class="pdfil col-md-2">Click</a><?php }else echo "<p class='col-md-12' align='center'>-NA-</p>";?></td>
                        </tr>
                        <?php }}else echo "<tr><td colspan='4' align='center'>No Records</td></tr>";?>
                    </tbody>
                </table>
                <div class="col-md-4 pull-right"><input type="text" class="form-control tlamt" placeholder="Total Lodging" value="<?php if($tamtl!=0) echo $tamtl;?>" readonly="readonly"/></div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 form-group">
        <label>Others : </label>
        <div class="clearfix">
            <div class="column">
                <table class="table table-bordered" id="fare_tab">
                    <thead><tr class="blue cust"><th>Description</th><th>Amount</th><th>Date</th><th>Files</th></tr></thead>
                    <tbody id='fare2'>
      					<?php if($other_expenses!=0){foreach($other_expenses as $other_expenses1){$tamte+=$other_expenses1['amount'];?>
                        <tr class="tbform">
                            <td><input type="text" class="form-control" value="<?php echo $other_expenses1['description'];?>"  placeholder="Description" readonly="readonly"="readonly="readonly""/></td>
                            <td><input type="text" class="form-control tamfor tlom" value="<?php echo $other_expenses1['amount'];?>" placeholder="Amount" readonly="readonly"="readonly="readonly""/></td>
                            <td><input type="text" class="form-control datepicker" value="<?php echo date("d-m-Y", strtotime($other_expenses1['checked_date'])); ?>"  placeholder="DD-MM-YYYY" readonly="readonly"="readonly="readonly""/></td>
                            <td><?php if($other_expenses1['document_link']!=='0'){?><a href="<?php echo $other_expenses1['document_link'];?>" target="_blank" class="pdfil col-md-2">Click</a><?php }else echo "<p class='col-md-12' align='center'>-NA-</p>";?></td>
                        </tr>
      					<?php }}else echo "<tr><td colspan='4' align='center'>No Records</td></tr>";?>
                    </tbody>
                </table>
                <div class="col-md-4 pull-right"><input type="text" class="form-control tlomt" placeholder="Other's Total" value="<?php if($tamte!=0) echo $tamte;?>" readonly="readonly" /></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 form-group">
        <label>Outstanding Balance: </label>
        <input type="text" tabindex="14" class="form-control nsamt" value="<?php if (advanceNotSettled($expList[0]['employee_alias'])!=0)echo advanceNotSettled($expList[0]['employee_alias']); else echo "No pending Advances";?>" placeholder="Outstanding Balance" readonly="readonly" />
    </div>
    <div class="col-md-4 form-group">
        <label>Total Expenses: </label>
        <input type="text" tabindex="14" class="form-control texp" value="<?php echo $expList[0]['total_tour_expenses'];?>" placeholder="Total Expenses" readonly="readonly" />
    </div>
    <div class="col-md-4 form-group">
        <label>Final Amount (Total Expenses- Outstanding Balance): </label>
        <input type="text" tabindex="14" class="form-control finchamt" value="<?php echo ($expList[0]['total_tour_expenses']-advanceNotSettled($expList[0]['employee_alias']));?>" placeholder="Total Expenses- Outstanding Balance" readonly="readonly" />
    </div>
