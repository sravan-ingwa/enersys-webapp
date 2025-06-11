	<style>
    .tbform input[type="text"], .tbform input[type="file"], .tbform select{border:none !important;margin:0 !important;padding:0 !important;width:100% !important;outline:none !important;webkit-box-shadow: none;box-shadow: none;}
    .tbform input[type="text"]:focus, .tbform input[type="file"]:focus, .tbform select:focus{outline:none !important;webkit-box-shadow: none;box-shadow: none;}
    .table-bordered{margin-bottom:5px !important;} 
	.form-control[disabled], .form-control[readonly="readonly"], fieldset[disabled] .form-control{background:none !important;}
	.panel-default > .panlbakg{background-color:#2a6496; border:2px solid #2a6496; color:#fff;}

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
            <div class="col-xs-10 jerror"><?php if(isset($message))echo $message;?></div>
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
                <input type="text" tabindex="7" class="form-control" id="visitFromDate" placeholder="No. of days" value="<?php echo noofDays($expList[0]['period_of_visit_from'],$expList[0]['period_of_visit_to']);?>" readonly="readonly" />
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
            <label>Local Conveyance : </label>
            <div class="clearfix" id='fare11'>
            <div class="localConv">
            <?php if($lconveyance!=0){ $c=1;foreach($lconveyance as $conveyance1){$tamt121+=$conveyance1['amount'];?>
                   <div id="localConv_1" class="panel panel-default tbformm" >
                    	<div class="panel-heading panlbakg">
                        	<h3 class="panel-title">Local Conveyance <?php echo $c;?></h3>
                   		 </div>
                   		<div class="panel-body">
                    	<div class="row">
                             <div class="col-md-3 form-group">
                                <label>Zone : </label>
                                <input type="text" class="form-control" value="<?php echo getNames($conveyance1['zone_alias'],'ec_zone');?>"   placeholder="Zone" readonly="readonly"/>
                            </div>
                            <div class="col-md-3 form-group sel_empty">
                                <label>State : </label>
                                <input type="text" class="form-control" value="<?php echo getNames($conveyance1['state_alias'],'ec_state');?>"   placeholder="State" readonly="readonly"/>
                            </div>
                            <div class="col-md-3 form-group sel_empty">
                                <label>District : </label>
                               <input type="text" class="form-control" value="<?php echo getNames($conveyance1['district_alias'],'ec_district');?>"   placeholder="District" readonly="readonly"/>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Area : </label>
                                <input type="text" class="form-control" value="<?php if(getArea($conveyance1['district_alias'])==0){echo 'Plain Area'; $amount_appli = 0.02;}else if(getArea($conveyance1['district_alias'])==1){echo 'Hilly area'; $amount_appli = 0.04;}?>"   placeholder="Area" readonly="readonly"/> 
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Bucket : </label>
                                 <input type="text" class="form-control" value="<?php if($conveyance1['bucket'] ==0)echo 'Secondary transportation';else echo 'Local Conveyance';?>"   placeholder="Bucket" readonly="readonly"/>
                            </div>
                            <?php if($conveyance1['bucket'] ==0) { ?>
                             <div class="col-md-3 form-group lclHide">
                                <label class="cap">Capacity : </label>   
                                <input type="text" class="form-control" value="<?php if(getWeights($conveyance1['capacity'],'product') != 0) echo getWeights($conveyance1['capacity'],'product'); else echo '';?>"   placeholder="Capacity" readonly="readonly"/>
                            </div>
                            <div class="col-md-3 form-group lclHide">
                                <label class="ocap">Weight of the cell : </label>   
                                <input type="text" class="form-control" value="<?php if(getWeights($conveyance1['capacity'],'weight')!= 0) echo getWeights($conveyance1['capacity'],'weight'); else echo '';?>"   placeholder="Quantity" readonly="readonly"/>
                            </div>
                            <div class="col-md-3 form-group lclHide">
                                <label class="ocap">Quantity : </label>   
                               <input type="text" class="form-control" value="<?php if($conveyance1['quantity']!=0)echo $conveyance1['quantity']; else echo '';?>"   placeholder="Weight of the Cell" readonly="readonly"/>
                            </div>
                            <div class="col-md-3 form-group lclHide">
                                <label class="ocap">No.of Kilometers : </label>   
                               <input type="text" class="form-control" value="<?php if($conveyance1['km']!=0)echo $conveyance1['km']; else echo '';?>"   placeholder="No of Kilometers" readonly="readonly"/>
                            </div>
                            <div class="col-md-3 form-group lclHide">
                                <label class="ocap">Amount Appilicable : </label>   
                                <input type="text" class="form-control" value="<?php echo $amount_appli;?>"   placeholder="Amount Applicable" readonly="readonly"/>
                            </div>
                            <?php }?>
                             <div class="col-md-3 form-group">
                                <label>Date of Travel : </label>   
                               <input type="text" class="form-control" value="<?php echo date("d-m-Y", strtotime($conveyance1['date_of_travel'])); ?>"   placeholder="DD-MM-YYYY" readonly="readonly"/>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Mode of travel : </label>   
                               <input type="text" class="form-control" value="<?php echo $conveyance1['mode_of_travel'];?>" placeholder="DD-MM-YYYY" readonly="readonly"/>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>From : </label>  
                                <input type="text" class="form-control" value="<?php echo $conveyance1['from_place'];?>" placeholder="From" readonly="readonly"/>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>To : </label>  
                                <input type="text" class="form-control" value="<?php echo $conveyance1['to_place'];?>" placeholder="To" readonly="readonly"/>
                            </div>
                            <div class="col-md-3 form-group ticket_empty">
                                <label>Ticket ID : </label>  
                                <input type="text" class="form-control" value="<?php if($conveyance1['ticket_alias']=="1") echo "Others"; else getTicketName($conveyance1['ticket_alias']);?>" placeholder="Ticket ID" readonly="readonly"/>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>DPR Number : </label>  
                                <input type="text" class="form-control" value="<?php echo $conveyance1['dpr_number'];?>" placeholder="DPR Number" readonly="readonly"/>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Amount : </label>  
                                <input type="text" class="form-control tamfor tcm" value="<?php echo $conveyance1['amount'];?>" placeholder="Amount" readonly="readonly"/>
                            </div>
                        </div>
                    </div>
                    </div>
                    
                    <?php $c++;}}else echo " <div class='panel panel-default'><div class='panel-heading panlbakg'><h3 class='panel-title'>Local Conveyance 1</h3></div><h5 align='center'><b>No Records</b></h5></div>";?>
                </div>
                 <div class="col-md-4 form-group pull-right">
                  	<input type="text" class="form-control tcmt" placeholder="Total Local Conveyance" value="<?php if($tamt121!=0) echo $tamt121;?>"  readonly="readonly"/>
                 </div>
           </div>
        </div>
            
            
            <div class="col-lg-12 form-group">
                <label>Conveyance : </label>
                <div class="clearfix">
                    <div class="column">
                        <table class="table table-bordered" id="fare_tab">
                            <thead><tr class="blue cust"><th>Date of travel</th><th>Mode of travel</th><th>From</th><th>To</th><th>Ticket ID</th><th>DPR Number</th><th>Files</th><th>Amount</th></tr></thead>
                            <tbody id='fare0'>
                            <?php if($conveyance!=0){foreach($conveyance as $conveyance1){$tamt+=$conveyance1['amount'];?>
                                <tr class="tbform">
                                    <td><input type="text" class="form-control" value="<?php echo date("d-m-Y", strtotime($conveyance1['date_of_travel'])); ?>"   placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                                    <td><input type="text" class="form-control" value="<?php echo $conveyance1['mode_of_travel'];?>" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                                    <td><input type="text" class="form-control" value="<?php echo $conveyance1['from_place'];?>" placeholder="From" readonly="readonly"/></td>
                                    <td><input type="text" class="form-control" value="<?php echo $conveyance1['to_place'];?>" placeholder="To" readonly="readonly"/></td>
                                    <td><input type="text" class="form-control" value="<?php if($conveyance1['ticket_alias']=="1") echo "Others"; else echo getTicketName($conveyance1['ticket_alias']);?>"   placeholder="Ticket ID" readonly="readonly"/></td>
                                    <td><input type="text" class="form-control" value="<?php echo $conveyance1['dpr_number'];?>"   placeholder="DPR Number" readonly="readonly"/></td>
                                    <td><?php if($conveyance1['document_link']!=='0'){?><a href="<?php echo $conveyance1['document_link'];?>" target="_blank" class="pdfil col-md-2" align='center'>Click</a><?php }else echo "<p class='col-md-12' align='center'>-NA-</p>";?></td>
                                    <td><input type="text" class="form-control tamfor tcm" value="<?php echo $conveyance1['amount'];?>" placeholder="Amount" readonly="readonly"/></td>
                                </tr>
                                 <?php }}else echo "<tr><td colspan='8' align='center'>No Records</td></tr>";?>
                                <!--<tr><td colspan='7' align='center'>No Records</td></tr>-->
                            </tbody>
                        </table>
                        <div class="col-md-4 pull-right"><input type="text" class="form-control tcmt" placeholder="Total Conveyance" value="<?php if($tamt!=0) echo $tamt;?>" readonly="readonly"/></div>
                    </div>
                </div>
            </div>
            
    <div class="col-lg-12 form-group">
        <label>Lodging : </label>
        <div class="clearfix">
            <div class="column">
                <table class="table table-bordered" id="fare_tab">
                    <thead><tr class="blue cust"><th>Zone</th><th>State</th><th>District</th><th>Visit: Start Date:</th><th>Visit: End Date:</th><th>Hotel Name</th><th>Ticket ID</th><th>DPR Number</th><th>Amount</th></tr></thead>
                    <tbody id='fare1'>
                    <?php if($lodging!=0){foreach($lodging as $lodging1){$tamtl+=$lodging1['amount'];?>
                        <tr class="tbform">
                        	<td><input type="text" class="form-control" value="<?php echo getNames($lodging1['zone_alias'],'ec_zone');?>"   placeholder="Zone" readonly="readonly"/></td>
                            <td><input type="text" class="form-control" value="<?php echo getNames($lodging1['state_alias'],'ec_state');?>"   placeholder="State" readonly="readonly"/></td>
                            <td><input type="text" class="form-control" value="<?php echo getNames($lodging1['district_alias'],'ec_district');?>"   placeholder="District" readonly="readonly"/></td>
                            <td><input type="text" class="form-control " value="<?php echo date("d-m-Y", strtotime($lodging1['check_in']));?>" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                            <td><input type="text" class="form-control " value="<?php echo date("d-m-Y", strtotime($lodging1['check_out']));?>" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                            <td><input type="text" class="form-control" value="<?php echo $lodging1['hotel_name'];?>" placeholder="Hotel Name" readonly="readonly"/></td>
                            <td><input type="text" class="form-control" value="<?php if($lodging1['ticket_alias']=="1") echo "Others"; else echo getTicketName($lodging1['ticket_alias']);?>" placeholder="Ticket ID" readonly="readonly"/></td>
                            <td><input type="text" class="form-control" value="<?php echo $lodging1['dpr_number'];?>" placeholder="DPR Number" readonly="readonly"/></td>
                            <td><input type="text" class="form-control tamfor tlam" value="<?php echo $lodging1['amount'];?>" placeholder="Amount" readonly="readonly"/></td>
                        </tr>
                         <?php }}else echo "<tr><td colspan='9' align='center'>No Records</td></tr>";?>
                        <!--<tr><td colspan='6' align='center'>No Records</td></tr>-->
                    </tbody>
                </table>
                <div class="col-md-4 pull-right"><input type="text" class="form-control tlamt" placeholder="Total Lodging" value="<?php if($tamtl!=0) echo $tamtl;?>" readonly="readonly"/></div>
            </div>
        </div>
    </div>
	<div class="col-lg-12 form-group">
        <label>Boarding Allowance: </label>
        <div class="clearfix">
            <div class="column">
                <table class="table table-bordered" id="fare_tab">
                    <thead><tr class="blue cust"><th>Zone</th><th>State</th><th>District</th><th>Visit: Start Date:</th><th>Visit: End Date:</th><th>Ticket ID</th><th>DPR Number</th><th>Amount</th></tr></thead>
                    <tbody id='fare1'>
                    <?php if($boarding!=0){foreach($boarding as $boarding1){$bamtl+=$boarding1['amount'];?>
                        <tr class="tbform">
                        	<td><input type="text" class="form-control" value="<?php echo getNames($boarding1['zone_alias'],'ec_zone');?>"   placeholder="Zone" readonly="readonly"/></td>
                            <td><input type="text" class="form-control" value="<?php echo getNames($boarding1['state_alias'],'ec_state');?>"   placeholder="State" readonly="readonly"/></td>
                            <td><input type="text" class="form-control" value="<?php echo getNames($boarding1['district_alias'],'ec_district');?>"   placeholder="District" readonly="readonly"/></td>
                            <td><input type="text" class="form-control " value="<?php echo date("d-m-Y", strtotime($boarding1['check_in']));?>" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                            <td><input type="text" class="form-control " value="<?php echo date("d-m-Y", strtotime($boarding1['check_out']));?>" placeholder="DD-MM-YYYY" readonly="readonly"/></td>
						    <td><input type="text" class="form-control" value="<?php if($boarding1['ticket_alias'] == 1)echo "Others"; else echo getTicketName($boarding1['ticket_alias']);?>"  placeholder="Ticket ID" readonly="readonly"/></td>
                            <td><input type="text" class="form-control" value="<?php echo $boarding1['dpr_number'];?>" placeholder="DPR Number" readonly="readonly"/></td>
                            <td><input type="text" class="form-control tamfor blam" value="<?php echo $boarding1['amount'];?>" placeholder="Amount" readonly="readonly"/></td>
                        </tr>
                         <?php }}else echo "<tr><td colspan='8' align='center'>No Records</td></tr>";?>
                        <!--<tr><td colspan='4' align='center'>No Records</td></tr>-->
                    </tbody>
                </table>
                <div class="col-md-4 pull-right"><input type="text" class="form-control blamt" placeholder="Total Boarding" value="<?php if($bamtl!=0) echo $bamtl;?>" readonly="readonly"/></div>
            </div>
        </div>
    </div>
<div class="col-lg-12 form-group">
        <label>Others : </label>
        <div class="clearfix">
            <div class="column">
                <table class="table table-bordered" id="fare_tab">
                    <thead><tr class="blue cust"><th>Description</th><th>Date</th><th>Files</th><th>Ticket ID</th><th>DPR Number</th><th>Amount</th></tr></thead>
                    <tbody id='fare2'>
                    <?php if($other_expenses!=0){foreach($other_expenses as $other_expenses1){$tamte+=$other_expenses1['amount'];?>
                        <tr class="tbform">
                            <td><input type="text" class="form-control" value="<?php echo $other_expenses1['description'];?>"  placeholder="Description" readonly="readonly"/></td>
                            <td><input type="text" class="form-control datepicker" value="<?php echo date("d-m-Y", strtotime($other_expenses1['checked_date'])); ?>"  placeholder="DD-MM-YYYY" readonly="readonly"/></td>
                            <td><?php if($other_expenses1['document_link']!=='0'){?><a href="<?php echo $other_expenses1['document_link'];?>" target="_blank" class="pdfil col-md-2">Click</a><?php }else echo "<p class='col-md-12' align='center'>-NA-</p>";?></td>
                            <td><input type="text" class="form-control" value="<?php if($other_expenses1['ticket_alias']=="1") echo "Others"; else echo getTicketName($other_expenses1['ticket_alias']);?>" placeholder="Ticket ID" readonly="readonly"/></td>
                            <td><input type="text" class="form-control" value="<?php echo $other_expenses1['dpr_number'];?>" placeholder="DPR Number" readonly="readonly"/></td>
                            <td><input type="text" class="form-control tamfor tlom" value="<?php echo $other_expenses1['amount'];?>" placeholder="Amount" readonly="readonly"/></td>
                        </tr>
      					<?php }}else echo "<tr><td colspan='6' align='center'>No Records</td></tr>";?>
                    </tbody>
                </table>
                <div class="col-md-4 pull-right"><input type="text" class="form-control tlomt" placeholder="Other's Total" value="<?php if($tamte!=0) echo $tamte;?>" readonly="readonly" /></div>
            </div>
        </div>
    </div>    
    <div class="col-md-3 form-group">
        <label>Outstanding Balance: </label>
        <input type="text" tabindex="14" class="form-control nsamt" value="<?php if (advanceNotSettled($expList[0]['employee_alias'])!=0)echo advanceNotSettled($expList[0]['employee_alias']); else echo "No pending Advances";?>" placeholder="Outstanding Balance" readonly="readonly" />
    </div>
    <div class="col-md-3 form-group">
        <label>Total Expenses: </label>
        <input type="hidden" class="temp_tlt" value="<?php echo round($expList[0]['total_tour_expenses']);?>" />
        <input type="text" tabindex="14" class="form-control texp" value="<?php echo round($expList[0]['total_tour_expenses']);?>" placeholder="Total Expenses" readonly="readonly" name='tot_exp'/>
    </div>
    <?php if($expList[0]['approval_level']=='4'){?>
    <div class="col-md-3 form-group">
        <label>Reimbursement : </label>
        <input class="form-control qntyy" name="rem_amt" placeholder="Reimbursement" type="text" autocomplete="off"/>
    </div>
    <?php }?>
    <div class="col-md-3 form-group">
        <label>Final Amount (Total Expenses- Outstanding Balance): </label>
        <input type="text" tabindex="14" class="form-control finchamt" value="<?php echo (round($expList[0]['total_tour_expenses'])-advanceNotSettled($expList[0]['employee_alias']));?>" placeholder="Total Expenses- Outstanding Balance" readonly="readonly" name='final_amt'/>
    </div>

    <!--<div class="col-md-4 form-group">
        <label>Reason/ Remarks<sup>*</sup> : </label>
        <textarea tabindex="2" class="form-control reasonForAdv" name="reasonForAdv" placeholder="Reason/ Remarks" required="required"></textarea>
    </div>
    <div class="col-md-4 form-group">&nbsp;</div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-md-4 col-md-offset-4">
            <input tabindex="13" type="submit" class="btn btn-primary ss_buttons updatex" name="approve" value="Approve">
            <input tabindex="14" type="submit" class="btn btn-primary ss_buttons rejectx" name="reject" value="Reject">
        </div>
    </div>-->
