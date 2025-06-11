<?php
session_start();
function checkSelected($fv1,$fv2){if(strtoupper($fv1)==strtoupper($fv2)) return "selected";}
date_default_timezone_set("Asia/Kolkata");

if($_REQUEST['id']) $_SESSION['id']=$_REQUEST['id']; 
$expList=expensefullView($_SESSION['id']);
$conveyance=ec_conveyance($expList[0]['expenses_alias']);
$lconveyance=ec_localconveyance($expList[0]['expenses_alias']);
$lodging=ec_lodging($expList[0]['expenses_alias']);
$boarding=ec_boarding($expList[0]['expenses_alias']);
$other_expenses=ec_other_expenses($expList[0]['expenses_alias']);
$remarks=getRemarks($expList[0]['expenses_alias'],'BE');
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
		<h3 class="panel-title" style="display:inline-block;">Book Expense</h3>
	</div>
	<div class="panel-body">
        <form role="form" class="ss_form" method="post" id="defaultForm" novalidate>
      <p class='alerta' role='alert'></p>
      <?php if(isset($message))echo $message;?>
      <input type="hidden" value="<?php echo $ref;?>" name="ref" />
      <input type="hidden" value="<?php echo $expList[0]['expenses_alias'];?>" name="id" />
		<div class="row">
        <div class="col-md-4 form-group">
            <label>Date of Request : </label>
            <input class="form-control" type="text" name="dateofRequest" value="<?php echo date('d-M-Y'); ?>" placeholder="Date of Request" readonly/>
        </div>
        <div class="col-md-4 form-group">
            <label>Employee ID : </label>
            <input class="form-control" type="text"name="empId" value="<?php echo employeeDetails('employee_id',$expList[0]['employee_alias']);?>" placeholder="Employee ID" readonly/>
        </div>
        <div class="col-md-4 form-group">
            <label>Employee Name: </label>
            <input class="form-control" type="text" value="<?php echo employeeDetails('name',$expList[0]['employee_alias']);?>" placeholder="Employee Name" readonly/>
        </div>
        <div class="col-md-4 form-group">
            <label>Grade: </label>
            <input class="form-control" type="text" value="<?php echo grade($expList[0]['employee_alias'])?>" placeholder="Grade" readonly/>
        </div>
        <div class="col-md-4 form-group">
            <label>Visit: Start Date: </label>
			<input type='text' class="form-control dpd1 cddl bg-white" tabindex="0" autofocus="autofocus" name="visitFromDate"  value="<?php echo date("d-m-Y", strtotime($expList[0]['period_of_visit_from'])); ?>"  placeholder="Period of Visit From" />
        </div>
        <div class="col-md-4 form-group">
            <label>Visit: End Date: </label>
			<input type='text' class="form-control dpd2 cddl bg-white" tabindex="0" name="visitToDate"  value="<?php echo date("d-m-Y", strtotime($expList[0]['period_of_visit_to'])); ?>" placeholder="Period of Visit To" />
        </div>
		</div>
        <div class="row">
            <div class="col-md-4 form-group">
                <label>No. of days: </label>
                <input type="text" tabindex="7" class="form-control" id="visitFromDate" placeholder="No. of days" value="<?php echo noofDays($expList[0]['period_of_visit_from'],$expList[0]['period_of_visit_to']);?>" readonly />
            </div>
            <div class="col-md-4 form-group">
                <label>Visited place's : </label>
                <input type="text" tabindex="3" class="form-control" name="placesOfVisit" value="<?php echo $expList[0]['places_of_visit'];?>" placeholder="Places of Visit"/>
            </div>
            <div class="col-md-4 form-group">
                <label>Purpose: </label>
                <textarea tabindex="4" class="form-control reasonForAdv" name="purpose" placeholder="Purpose" ><?php echo $expList[0]['purpose'];?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 form-group">
                <label>Remarks: </label>
                <textarea tabindex="4" class="form-control reasonForAdv" name="remarks" placeholder="Remarks" ><?php echo $remarks[0]['remarks'];?></textarea>
            </div>
        </div>
        
      	<div class="col-lg-12 form-group">            <?php if($lconveyance!=0){ $lcnt = count($lconveyance); }?>

            <label>Local Conveyance : </label>&nbsp;&nbsp;<a href="#" data-get="fare11" class="addNewLoc"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare11" class="RemoveLoc" data-cnt="<?php echo ($lcnt+1);?>"><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix" id='fare11'>
            <div class="localConv">
           <?php if($lconveyance!=0){ ?>
           <?php
			 $l = 1; foreach($lconveyance as $conveyance1){$tamtll+=$conveyance1['amount'];
						 if(getArea($conveyance1['district_alias'])==0){
							 $disp_area='Plain Area'; $amount_appli = 0.02;
						}else if(getArea($conveyance1['district_alias'])==1){
								 $disp_area='Hilly area'; $amount_appli = 0.04;
						}?>
                   <div id="localConv_<?php echo $l;?>" class="panel panel-default tbformm ajm " >
                    	<div class="panel-heading panlbakg">
                        	<h3 class="panel-title">Local Conveyance <?php echo $l;?></h3>
                   		 </div>
                   		<div class="panel-body">
                    	<div class="row">
                             <div class="col-md-3 form-group">
                                <label>Zone : </label>
                                <input type="hidden" name="idc_l[]" value="<?php echo $conveyance1['alias'];?>"/>
                                <select class="form-control showgradedesg zone_change" tabindex="1" name="zone_l[]"  required="required" autofocus data="state" ref="lc">
                                    <option value="0" selected="selected" disabled="disabled">Zone</option>
                                        <?php $getZn=getZones();if($getZn!=0){foreach($getZn as $rec){echo "<option value='".$rec['zone_alias']."' ".checkSelected($rec['zone_alias'],$conveyance1['zone_alias']).">".$rec['zone_name']."</option>";}}else echo "<option disabled='disabled'>Add Zone</option>";?>               
                                 </select>
                            </div>
                            <div class="col-md-3 form-group sel_empty">
                                <label>State : </label>
                                 <select class="form-control showgradedesg state_change" tabindex="2"  required="required" name="state_l[]" autofocus data="district">
                    <?php $getst=getStates($conveyance1['zone_alias']);if($getst!=0){foreach($getst as $srec){echo "<option value='".$srec['state_alias']."' ".checkSelected($srec['state_alias'],$conveyance1['state_alias']).">".$srec['state_name']."</option>";}}else echo "<option disabled='disabled'>Add State</option>";?>
                </select>
                            </div>
                            <div class="col-md-3 form-group sel_empty">
                                <label>District : </label>
                                <select class="form-control showgradedesg district_change" tabindex="3"  name="district_l[]" autofocus data="area">
                   <?php $getdt=getDistricts($conveyance1['state_alias']);if($getdt!=0){foreach($getdt as $drec){echo "<option value='".$drec['district_alias']."' ".checkSelected($drec['district_alias'],$conveyance1['district_alias']).">".$drec['district_name']."</option>";}}else echo "<option disabled='disabled'>Add District</option>";?>
                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Area : </label>
                                <input class="form-control area_change" type="text" name="area_l[]" placeholder="Area" value="<?php echo $disp_area;?>"  readonly="readonly"/>   
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Bucket : </label>
                                     <select class="form-control localConvy" tabindex="3" required="required" name="bucket[]" autofocus >
                                        <option value="" selected="selected" disabled="disabled">Bucket</option>
                                        <option value="0"  <?php echo checkSelected($conveyance1['bucket'],'0');?>>Secondary transportation </option>
                                        <option value="1"  <?php echo checkSelected($conveyance1['bucket'],'1');?>>Local Conveyance</option>
                                     </select>
                            </div>
                             <div class="col-md-3 form-group lclHide <?php if($conveyance1['bucket'] == 1) echo "hidden";?>">
                                <label class="cap">Capacity : </label>   
                                     <select class="form-control capacity_change cap" tabindex="3" required="required" name="cap[]" autofocus data="weight" >
                                        <option value="" selected="selected">Capacity</option>
                                         <?php $getCp=getCapacity();if($getCp!=0){foreach($getCp as $rec){echo "<option value='".$rec['product_alias']."' ".checkSelected($rec['product_alias'],$conveyance1['capacity']).">".$rec['product_description']."</option>";}}else echo "<option disabled='disabled'>Add Capacity</option>";?> 
                                     </select>

                            </div>
                            <div class="col-md-3 form-group lclHide  <?php if($conveyance1['bucket'] == 1) echo "hidden";?>">
                                <label class="ocap">Weight of the cell : </label>   
                                <input type="text" class="form-control wofCell weight_change ocap" name="wofCell[]" placeholder="Weight of the cell" readonly <?php if($conveyance1['bucket'] == 0){?> value="<?php echo getWeights($conveyance1['capacity'],'weight');?>" <?php } ?>/>
                            </div>
                            <div class="col-md-3 form-group lclHide <?php if($conveyance1['bucket'] == 1) echo "hidden";?>">
                                <label class="ocap">Quantity : </label>   
                                <input type="text" class="form-control qnty ocap" name="quantityCell[]" autocomplete="off" placeholder="Quantity" <?php if($conveyance1['bucket'] == 0){?> value="<?php echo $conveyance1['quantity'];?>" <?php } ?>/>
                            </div>
                            <div class="col-md-3 form-group lclHide <?php if($conveyance1['bucket'] == 1) echo "hidden";?>">
                                <label class="ocap">No.of Kilometers : </label>   
                                <input type="text" class="form-control numKilo ocap" name="numKilometers[]" autocomplete="off" placeholder="No.of Kilometers" <?php if($conveyance1['bucket'] == 0){?> value="<?php echo $conveyance1['km'];?>" <?php }?>/>
                            </div>
                            <div class="col-md-3 form-group lclHide <?php if($conveyance1['bucket'] == 1) echo "hidden";?>">
                                <label class="ocap">Amount Appilicable : </label>   
                                <input type="text" class="form-control ocap wofCell appli_change" name="amtappli[]" placeholder="Amount" readonly value="<?php echo $amount_appli;?>"/>
                            </div>
                             <div class="col-md-3 form-group">
                                <label>Date of Travel : </label>   
                                <input type="text" class="form-control  expense_dates cddl bg-white" name="dot_l[]" placeholder="DD-MM-YYYY" readonly value="<?php echo date("d-m-Y", strtotime($conveyance1['date_of_travel']));?>"/>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Mode of travel : </label>   
                                <select class="form-control" tabindex="2" required="required" name="mot_l[]" id="mot">
                                        <option value="0">Mode of travel</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Own Vehicle');?> value="Own Vehicle">Own Vehicle</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Cab');?> value="Cab">Cab</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Auto');?> value="Auto">Auto</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Local Train');?> value="Local Train">Local Train</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Any Public Transport');?> value="Any Public Transport">Any Public Transport</option>
                                    </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>From : </label>  
                               <input type="text" class="form-control" name="from_l[]" placeholder="From" value="<?php echo $conveyance1['from_place'];?>"/>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>To : </label>  
                                <input type="text" class="form-control" name="to_l[]" placeholder="To" value="<?php echo $conveyance1['to_place'];?>"/>
                            </div>
                            <div class="col-md-3 form-group ticket_empty">
                                <label>Ticket ID : </label>  
                                <select id="ticket_idl" class="form-control selectpicker" name="ticket_idl[]" data-live-search="true" placeholder="">
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                        <option value="1" <?php if($conveyance1['ticket_alias'] == "1")echo "selected";?>>Others</option>
                                        <?php $getTid=getTicket($expList[0]['employee_alias']);
										 if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."' ".checkSelected($rec['ticket_alias'],$conveyance1['ticket_alias']).">".$rec['ticket_id']."</option>";}}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>DPR Number : </label>  
                                <input type="text" class="form-control" name="dprNum_l[]" placeholder="Dpr Number" value="<?php echo $conveyance1['dpr_number'];?>" />
                            </div>
                           <div class="col-md-3 form-group">
                                <label>Amount : </label>  
                                <input type="text" class="form-control amtt tamfor ttcm lc" name="amt_l[]" placeholder="Amount" readonly value="<?php echo $conveyance1['amount'];?>"/>
                            </div>

                        </div>
                    </div>
                    </div>
                    <?php $l++;}?>     
               <?php }?>
               
               
               <div id="localConv_<?php echo ($lcnt+1);?>" class="panel panel-default tbformm ajm" >
                    	<div class="panel-heading panlbakg">
                        	<h3 class="panel-title">Local Conveyance <?php echo ($lcnt+1);?></h3>
                   		 </div>
                   		<div class="panel-body">
                    	<div class="row">
                             <div class="col-md-3 form-group"><input type="hidden" name="idc_l[]" value="0"/>
                                <label>Zone : </label>
                                <select class="form-control showgradedesg zone_change" tabindex="1" name="zone_l[]"  required="required" autofocus data="state" ref="lc">
                                    <option value="0" selected="selected">Zone</option>
                                    <?php $getZn=getZones();if($getZn!=0){foreach($getZn as $rec){echo "<option value='".$rec['zone_alias']."'>".$rec['zone_name']."</option>";}}else echo "<option disabled='disabled'>Add Zone</option>";?>
                                </select>
                            </div>
                            <div class="col-md-3 form-group sel_empty">
                                <label>State : </label>
                                <select class="form-control showgradedesg state_change" tabindex="2"  required="required" name="state_l[]" autofocus data="district">
                                    <option value="0" selected="selected" disabled="disabled" class="depsel">State</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group sel_empty">
                                <label>District : </label>
                                <select class="form-control showgradedesg district_change" tabindex="3"  name="district_l[]" autofocus data="area">
                                     <option value="0" selected="selected" disabled="disabled" class="depsel">District</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Area : </label>
                                <input class="form-control area_change" type="text" name="area_l[]" placeholder="Area" value=""  readonly="readonly"/>   
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Bucket : </label>
                                 <select class="form-control localConvy" tabindex="3" required="required" name="bucket[]" autofocus >
                                    <option value="" selected="selected" disabled="disabled">Bucket</option>
                                    <option value="0">Secondary transportation </option>
                                    <option value="1">Local Conveyance</option>
                                 </select>   
                            </div>
                             <div class="col-md-3 form-group lclHide">
                                <label class="cap">Capacity : </label>   
                                <select class="form-control capacity_change cap" tabindex="3" required="required" name="cap[]" autofocus data="weight">
                                    <option value=" " selected="selected">Capacity</option>
                                     <?php $getCp=getCapacity();if($getCp!=0){foreach($getCp as $rec){echo "<option value='".$rec['product_alias']."'>".$rec['product_description']."</option>";}}else echo "<option disabled='disabled'>Add Capacity</option>";?> 
                                 </select>
                            </div>
                            <div class="col-md-3 form-group lclHide">
                                <label class="ocap">Weight of the cell : </label>   
                                <input type="text" class="form-control wofCell weight_change ocap" name="wofCell[]" placeholder="Weight of the cell" readonly/>
                            </div>
                            <div class="col-md-3 form-group lclHide">
                                <label class="ocap">Quantity : </label>   
                                <input type="text" class="form-control qnty ocap" name="quantityCell[]" autocomplete="off" placeholder="Quantity" />
                            </div>
                            <div class="col-md-3 form-group lclHide">
                                <label class="ocap">No.of Kilometers : </label>   
                                <input type="text" class="form-control numKilo ocap" name="numKilometers[]" autocomplete="off" placeholder="No.of Kilometers"/>
                            </div>
                            <div class="col-md-3 form-group lclHide">
                                <label class="ocap">Amount Appilicable : </label>   
                                <input type="text" class="form-control ocap wofCell appli_change" name="amtappli[]" placeholder="Amount" readonly/>
                            </div>
                             <div class="col-md-3 form-group">
                                <label>Date of Travel : </label>   
                                <input type="text" class="form-control  expense_dates cddl bg-white" name="dot_l[]" placeholder="DD-MM-YYYY" readonly/>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Mode of travel : </label>   
                                <select class="form-control" tabindex="2" required="required" name="mot_l[]" id="mot">
                                    <option value="0">Mode of travel</option>
                                    <option value="Own Vehicle">Own Vehicle</option>
                                    <option value="Cab">Cab</option>
                                    <option value="Auto">Auto</option>
                                    <option value="Local Train">Local Train</option>
                                    <option value="Any Public Transport">Any Public Transport</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>From : </label>  
                                <input type="text" class="form-control" name="from_l[]" placeholder="From"/>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>To : </label>  
                                <input type="text" class="form-control" name="to_l[]" placeholder="To"/>
                            </div>
                            <div class="col-md-3 form-group ticket_empty">
                                <label>Ticket ID : </label>  
                                <select id="ticket_idl" class="form-control selectpicker" name="ticket_idl[]" data-live-search="true" placeholder="">
                                    <option value="" selected="selected">Select Ticket ID</option>
                                    <option value="1">Others</option>
                                    <?php $getTid=getTicket($expList[0]['employee_alias']);
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
                  	<input type="text" class="form-control ttcmt" name="fare_total" placeholder="Total Conveyance"  value="<?php if($tamtll!=0) echo $tamtll;?>" readonly="readonly"/>
                 </div>
           </div>
        </div>
        
        <div class="col-lg-12 form-group">
            <label>Conveyance : </label>&nbsp;&nbsp;<a href="#" data-get="fare0" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare0" class="RemoveField"><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix">
                <div class="column">
                    <table class="table table-bordered" id="fare_tab">
                        <thead><tr class="blue cust"><th>Date of travel</th>
                        <th>Mode of travel</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Ticket ID</th>
                        <th>DPR Number</th>
                        <th>Files (No special characters in file name)</th>
                        <th>Amount</th>
                        </tr></thead>
                         <?php if($conveyance!=0){?>
                        <tbody>
                           <?php foreach($conveyance as $conveyance1){$tamt+=$conveyance1['amount'];?>
                            <tr class="tbform ajm">
                                <td>
                                    <input type="hidden" name="idc[]" value="<?php echo $conveyance1['alias'];?>"/>
                                    <input type="text" tabindex="0" class="form-control expense_dates cddl bg-white" name="dot[]" value="<?php echo date("d-m-Y", strtotime($conveyance1['date_of_travel'])); ?>" />
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
                                <td class="ticket_empty">
                                    <select id="cticketID" class="form-control selectpicker" name="cticket_id[]" data-live-search="true" placeholder="">
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                        <option value="1" <?php if($conveyance1['ticket_alias'] == "1")echo "selected";?>>Others</option>
                                        <?php $getTid=getTicket($expList[0]['employee_alias']);
										 if($getTid!=0){foreach($getTid as $rec){?> <option value=<?php echo $rec['ticket_alias']; ?> <?php echo checkSelected($conveyance1['ticket_alias'],$rec['ticket_alias']);?>><?php echo $rec['ticket_id']; ?></option><?php }}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                                </td>

                                <td><input type="text" class="form-control" name="cdprno[]" placeholder="Dpr Number" value="<?php echo $conveyance1['dpr_number'];?>"/></td>
                                <td>
                                    <input type="hidden" class="form-control" name="motbill_old[]" value="<?php echo $conveyance1['document_link'];?>"/>
                                    <?php if($conveyance1['document_link']!=='0'){?>
                                        <a href="../<?php echo $conveyance1['document_link'];?>" target="_blank" class="pdfil col-md-2">Click</a>
                                    <?php }?>
                                    <div class="col-md-10">
	                                    <input type="hidden" class="form-control" name="motbill[]" value="0"/>
                                    	<input type="file" class="form-control" tabindex="0" name="motbill[]"/>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" class="form-control amtt tamfor tcm" tabindex="0" autocomplete="off" value="<?php echo $conveyance1['amount'];?>" name="amt[]" placeholder="Amount"/>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                        <?php }?>
                        <tbody id='fare0'>
                            <tr class="tbform ajm">
                                <td> <input type="hidden" name="idc[]" value="0"/><input type="text" class="form-control expense_dates cddl bg-white" name="dot[]" placeholder="DD-MM-YYYY" readonly/></td>
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
                                <td class="ticket_empty">
                                    <select id="cticketID" class="form-control selectpicker" name="cticket_id[]" data-live-search="true" placeholder="">
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                        <option value="1">Others</option>
                                        <?php $getTid=getTicket($expList[0]['employee_alias']);
										 if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."'>".$rec['ticket_id']."</option>";}}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                                </td>

                                <td><input type="text" class="form-control" name="cdprno[]" placeholder="Dpr Number"/></td>
                                <td><input type="hidden" class="form-control" name="motbill[]" value="0"/><input type="file" class="form-control" name="motbill[]"/></td>
                                <td><input type="text" class="form-control amtt tamfor tcm" name="amt[]" autocomplete="off" placeholder="Amount"/></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-4 pull-right"><input type="text" class="form-control tcmt" name="fare_total" placeholder="Total Conveyance" value="<?php if($tamt!=0) echo $tamt;?>" readonly/></div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-12 form-group">
            <label>Lodging : </label>&nbsp;&nbsp;<a href="#" data-get="fare1" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare1" class="RemoveField"><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix">
                <div class="column">
                    <table class="table table-bordered" id="fare_tab">
                        <thead><tr class="blue cust"><th>Visit: Start Date:</th><th>Visit: End Date:</th><th>Zone</th><th>State</th><th>District</th><th>Hotel Name</th><th>Ticket ID</th><th>DPR Number</th><th>Amount</th></tr></thead>
                      <?php if($lodging!=0){?>
                       <tbody>
                       <?php foreach($lodging as $lodging1){$tamtl+=$lodging1['amount'];?>
                       
                        <tr class="tbform ajm stDate">
                               <td><input type="hidden" name="idl[]" tabindex="0" value="<?php echo $lodging1['alias'];?>"/>
                               <input type="text" class="form-control bdpd1 cddl bg-white clc" tabindex="0" value="<?php echo date("d-m-Y", strtotime($lodging1['check_in'])); ?>" name="checkin[]" placeholder="DD-MM-YYYY"/></td>
                                <td><input type="text" class="form-control bdpd2 cddl bg-white slc" tabindex="0" value="<?php echo date("d-m-Y", strtotime($lodging1['check_out'])); ?>" name="checkout[]" placeholder="DD-MM-YYYY"/></td>
                            	<td>
                                    <select class="form-control showgradedesg zone_change" tabindex="1" name="zone_ld[]"  required="required" autofocus data="state" ref="ld">
                <option value="0" selected="selected" disabled="disabled">Select Zone</option>
                    <?php $getZn=getZones();if($getZn!=0){foreach($getZn as $rec){echo "<option value='".$rec['zone_alias']."' ".checkSelected($rec['zone_alias'],$lodging1['zone_alias']).">".$rec['zone_name']."</option>";}}else echo "<option disabled='disabled'>Add Zone</option>";?>               
                </select>
                                </td>
                                <td class="sel_empty">                                  
                                    <select class="form-control showgradedesg state_change" tabindex="2"  required="required" name="state_ld[]" autofocus data="district">
                    <?php $getst=getStates($lodging1['zone_alias']);if($getst!=0){foreach($getst as $srec){echo "<option value='".$srec['state_alias']."' ".checkSelected($srec['state_alias'],$lodging1['state_alias']).">".$srec['state_name']."</option>";}}else echo "<option disabled='disabled'>Add State</option>";?>
                </select>
                                </td>
                                <td class="sel_empty">                                                                         
                                     <select class="form-control showgradedesg district_change" tabindex="3"  name="district_ld[]" autofocus>
                   <?php $getdt=getDistricts($lodging1['state_alias']);if($getdt!=0){foreach($getdt as $drec){echo "<option value='".$drec['district_alias']."' ".checkSelected($drec['district_alias'],$lodging1['district_alias']).">".$drec['district_name']."</option>";}}else echo "<option disabled='disabled'>Add District</option>";?>
                </select>
                                </td>
								<td class="changw"><input type="text" class="form-control" name="hotelName[]" tabindex="0" value="<?php echo $lodging1['hotel_name'];?>" placeholder="Hotel Name"/></td>
                                 <td class="ticket_empty">
                                    <select id="ticket_idld" class="form-control selectpicker" name="ticket_idld[]" data-live-search="true" placeholder="">
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                        <option value="1" <?php if($lodging1['ticket_alias'] == "1")echo "selected";?>>Others</option>
                                        <?php $getTid=getTicket($expList[0]['employee_alias']);
										 if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."' ".checkSelected($rec['ticket_alias'],$lodging1['ticket_alias']).">".$rec['ticket_id']."</option>";}}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="dprNum_ld[]" placeholder="Dpr Number" value="<?php echo $lodging1['dpr_number'];?>" /></td>
                                <td><input type="text" class="form-control amtt tamfor tlam selfamm ld" tabindex="0" name="lamt[]" value="<?php echo $lodging1['amount'];?>" placeholder="Amount" readonly="readonly"/></td>
                            </tr>
                          <?php }?>
                        </tbody>
					<?php }?>
                       
                        <tbody id='fare1'>
                        <tr class="tbform ajm stDate">
                                <td> <input type="hidden" name="idl[]" value="0"/>    
                                <input type="text" class="form-control bdpd1 cddl bg-white clc" name="checkin[]" placeholder="DD-MM-YYYY" readonly/></td>
                                <td><input type="text" class="form-control bdpd2 cddl bg-white slc" name="checkout[]" placeholder="DD-MM-YYYY" readonly/></td>
                                <td>                               
                                    <select class="form-control showgradedesg zone_change" tabindex="1" name="zone_ld[]"  required="required" autofocus data="state" ref="ld">
                <option value="0" selected="selected" disabled="disabled">Zone</option>
                    <?php $getZn=getZones();if($getZn!=0){foreach($getZn as $rec){echo "<option value='".$rec['zone_alias']."'>".$rec['zone_name']."</option>";}}else echo "<option disabled='disabled'>Add Zone</option>";?>
                </select>
                                </td>
                                <td class="sel_empty">                                    
                                    <select class="form-control showgradedesg state_change" tabindex="2"  required="required" name="state_ld[]" autofocus data="district">
                    <option value="0" selected="selected" disabled="disabled" class="depsel">State</option>
                </select>
                                </td>
                                <td class="sel_empty">
                                     <select class="form-control showgradedesg district_change" tabindex="3"  name="district_ld[]" autofocus>
                     <option value="0" selected="selected" disabled="disabled" class="depsel">District</option>
                </select>
                                </td>
                                <td class="changw"><input type="text" class="form-control" name="hotelName[]" placeholder="Hotel Name" value=""/></td>
                                 <td class="ticket_empty">
                                    <select id="ticket_idld" class="form-control selectpicker" name="ticket_idld[]" data-live-search="true" placeholder="">
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                        <option value="1">Others</option>
                                        <?php $getTid=getTicket($expList[0]['employee_alias']);
										 if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."'>".$rec['ticket_id']."</option>";}}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="dprNum_ld[]" placeholder="Dpr Number" value=""/></td>
                                <td><input type="text" class="form-control amtt tamfor tlam selfamm ld" name="lamt[]" placeholder="Amount" readonly/></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-4 pull-right"><input type="text" class="form-control tlamt" placeholder="Total Lodging" value="<?php if($tamtl!=0) echo $tamtl;?>" readonly/></div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-12 form-group">
            <label>Boarding Allowance: </label>&nbsp;&nbsp;
            <a href="#" data-get="fare" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare" class="RemoveField"><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix">
                <div class="column">
                    <table class="table table-bordered" id="fare_tab">
                        <thead><tr class="blue cust"><th>Visit: Start Date:</th><th>Visit: End Date:</th><th>Zone</th><th>State</th><th>District</th><th>Ticket ID</th><th>DPR Number</th><th>Amount</th></tr></thead>
                       <?php if($boarding!=0){?>
                        <tbody>
                        <?php foreach($boarding as $boarding1){$bamtl+=$boarding1['amount'];?>
                            <tr class="tbform ajm stDate">   
                                <td><input type="hidden" name="idb[]" tabindex="0" value="<?php echo $boarding1['alias'];?>"/> 
                                <input type="text" class="form-control bdpd1 cddl bg-white clc" tabindex="0" value="<?php echo date("d-m-Y", strtotime($boarding1['check_in'])); ?>" name="checkinb[]" placeholder="DD-MM-YYYY"/>
</td>
                                <td><input type="text" class="form-control bdpd2 cddl bg-white slc" tabindex="0" value="<?php echo date("d-m-Y", strtotime($boarding1['check_out'])); ?>" name="checkoutb[]" placeholder="DD-MM-YYYY"/></td>
                            	<td>                                  
                                    <select class="form-control showgradedesg zone_change" tabindex="1" name="zone_bo[]"  required="required" autofocus data="state" ref="bd">
                <option value="0" selected="selected" disabled="disabled">Zone</option>
                    <?php $getZn=getZones();if($getZn!=0){foreach($getZn as $rec){echo "<option value='".$rec['zone_alias']."'  ".checkSelected($rec['zone_alias'],$boarding1['zone_alias']).">".$rec['zone_name']."</option>";}}else echo "<option disabled='disabled'>Add Zone</option>";?>
                </select>
                                </td>
                                <td class="sel_empty">                                    
                            <select class="form-control showgradedesg state_change" tabindex="2"  required="required" name="state_bo[]" autofocus data="district">
                    <?php $getst=getStates($boarding1['zone_alias']);if($getst!=0){foreach($getst as $srec){echo "<option value='".$srec['state_alias']."' ".checkSelected($srec['state_alias'],$boarding1['state_alias']).">".$srec['state_name']."</option>";}}else echo "<option disabled='disabled'>Add State</option>";?>
                </select>
                                </td>
                                <td class="sel_empty">
                                     <select class="form-control showgradedesg district_change" tabindex="3"  name="district_bo[]" autofocus >
                   <?php $getdt=getDistricts($boarding1['state_alias']);if($getdt!=0){foreach($getdt as $drec){echo "<option value='".$drec['district_alias']."' ".checkSelected($drec['district_alias'],$boarding1['district_alias']).">".$drec['district_name']."</option>";}}else echo "<option disabled='disabled'>Add District</option>";?>
                </select>
                                </td>                                
                                 <td class="ticket_empty">
                                    <select id="ticket_bo" class="form-control selectpicker" name="ticket_bo[]" data-live-search="true" placeholder="">
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                        <option value="1" <?php if($boarding1['ticket_alias'] == "1")echo "selected";?>>Others</option>
                                        <?php $getTid=getTicket($expList[0]['employee_alias']);
										 if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."' ".checkSelected($rec['ticket_alias'],$boarding1['ticket_alias']).">".$rec['ticket_id']."</option>";}}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="dprNum_bo[]" placeholder="DPR Number" value="<?php echo $boarding1['dpr_number'];?>"/></td>
                                <td> <input type="text" class="form-control amtt tamfor blam selfamm bd" tabindex="0" name="bamt[]" value="<?php echo $boarding1['amount'];?>" placeholder="Amount" readonly="readonly"/></td>
                            </tr>
                            <?php }?>
                        </tbody>
                        <?php }?>
                        
                        <tbody id='fare'>
                            <tr class="tbform ajm stDate"> 
                                <td><input type="hidden" name="idb[]" value="0"/>
                           <input type="text" class="form-control bdpd1 cddl bg-white clc" name="checkinb[]" placeholder="DD-MM-YYYY" readonly /></td>
                           <td><input type="text" class="form-control bdpd2 cddl bg-white slc" name="checkoutb[]" placeholder="DD-MM-YYYY" readonly/></td>
                            	<td>
                                    <select class="form-control showgradedesg zone_change" tabindex="1" name="zone_bo[]"  required="required" autofocus data="state" ref="bd">
                <option value="0" selected="selected" disabled="disabled">Zone</option>
                    <?php $getZn=getZones();if($getZn!=0){foreach($getZn as $rec){echo "<option value='".$rec['zone_alias']."'>".$rec['zone_name']."</option>";}}else echo "<option disabled='disabled'>Add Zone</option>";?>
                </select>
                                </td>
                                <td class="sel_empty">                                    
                                    <select class="form-control showgradedesg state_change" tabindex="2"  required="required" name="state_bo[]" autofocus data="district">
                    <option value="0" selected="selected" disabled="disabled" class="depsel">State</option>
                </select>
                                </td>
                                <td class="sel_empty">
                                     <select class="form-control showgradedesg district_change" tabindex="3"  name="district_bo[]" autofocus >
                     <option value="0" selected="selected" disabled="disabled" class="depsel">District</option>
                </select>
                                </td>                                
                                 <td class="ticket_empty">
                                    <select id="ticket_bo" class="form-control selectpicker" name="ticket_bo[]" data-live-search="true" placeholder="">
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                         <option value="1">Others</option>
                                        <?php $getTid=getTicket($expList[0]['employee_alias']);
										 if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."'>".$rec['ticket_id']."</option>";}}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="dprNum_bo[]" placeholder="DPR Number"/></td>
                                <td><input type="text" class="form-control amtt tamfor blam selfamm bd" name="bamt[]" placeholder="Amount" readonly/></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-4 pull-right"><input type="text" class="form-control blamt" placeholder="Total Boarding" readonly value="<?php if($bamtl!=0) echo $bamtl;?>" /></div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-12 form-group">
            <label>Others : </label>&nbsp;&nbsp;<a href="#" data-get="fare2" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare2" class="RemoveField"><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix">
                <div class="column">
                    <table class="table table-bordered" id="fare_tab">
                        <thead><tr class="blue cust"><th>Description</th><th>Date</th><th>Files (No special characters in file name)</th><th>Ticket ID</th><th>DPR Number</th><th>Amount</th></tr></thead>
                        <?php if($other_expenses!=0){?>
                        <tbody>
                        <?php foreach($other_expenses as $other_expenses1){$tamte+=$other_expenses1['amount'];?>
                            <tr class="tbform ajm">
                                <td><input type="hidden" name="ido[]" value="<?php echo $other_expenses1['alias'];?>" />
                                <input type="text" class="form-control" name="others[]" tabindex="0" value="<?php echo $other_expenses1['description'];?>"  placeholder="Description"/></td>
                                <td><input type="text" class="form-control expense_dates cddl bg-white" tabindex="0" value="<?php echo date("d-m-Y", strtotime($other_expenses1['checked_date'])); ?>"  name="odate[]" placeholder="DD-MM-YYYY"/></td>
                                <td>
 								<input type="hidden" class="form-control" name="ofile_old[]" value="<?php echo $other_expenses1['document_link'];?>"/>
                                <?php if($other_expenses1['document_link']!=='0'){?>
                                    <a href="<?php echo $other_expenses1['document_link'];?>" target="_blank" class="pdfil col-md-2">Click</a>
                                <?php }?>
                                <div class="col-md-10">
                                    <input type="hidden" class="form-control" name="ofile[]" value="0"/>
                                    <input type="file" class="form-control" tabindex="0" name="ofile[]"/>
                                </div>                                </td>
                                <td class="ticket_empty">
                                    <select id="ticket_ot" class="form-control selectpicker" name="ticket_ot[]" data-live-search="true" placeholder="">
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                         <option value="1" <?php if($other_expenses1['ticket_alias'] == "1")echo "selected";?>>Others</option>
                                        <?php $getTid=getTicket($expList[0]['employee_alias']);
										 if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."' ".checkSelected($rec['ticket_alias'],$other_expenses1['ticket_alias']).">".$rec['ticket_id']."</option>";}}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="dprNum_ot[]" placeholder="DPR Number" value="<?php echo $other_expenses1['dpr_number'];?>"/></td>
                                <td><input type="text" class="form-control amtt tamfor tlom" autocomplete="off" tabindex="0" value="<?php echo $other_expenses1['amount'];?>"  name="oamt[]" placeholder="Amount"/></td>
                            </tr>
                            <?php }?>
                        </tbody>
                        <?php }?>
                        
                        <tbody id='fare2'>
                            <tr class="tbform ajm">
                                <td> <input type="hidden" name="ido[]" value="0"/><input type="text" class="form-control" name="others[]" placeholder="Description"/></td>
                                <td><input type="text" class="form-control expense_dates cddl bg-white" name="odate[]" placeholder="DD-MM-YYYY" readonly/></td>
                                <td><input type="hidden" class="form-control" name="ofile[]" value="0"/>
                                <input type="file" class="form-control" name="ofile[]"/></td>
                                <td class="ticket_empty">
                                    <select id="ticket_ot" class="form-control selectpicker" name="ticket_ot[]" data-live-search="true" placeholder="">
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                        <option value="1">Others</option>
                                        <?php $getTid=getTicket($expList[0]['employee_alias']);
										 if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."'>".$rec['ticket_id']."</option>";}}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="dprNum_ot[]" placeholder="DPR Number"/></td>
                                <td><input type="text" class="form-control amtt tamfor tlom" name="oamt[]" autocomplete="off" placeholder="Amount"/></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-4 pull-right"><input type="text" class="form-control tlomt" placeholder="Other's Total" readonly  value="<?php if($tamte!=0) echo $tamte;?>" /></div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 form-group">
        <label>Outstanding Balance: </label>
		<input type="text" class="form-control nsamt" value="<?php if(advanceNotSettled($expList[0]['employee_alias'])!=0)echo advanceNotSettled($expList[0]['employee_alias']); else echo "No pending Advances";?>" placeholder="Outstanding Balance" readonly="readonly"/>
        </div>
        <div class="col-md-4 form-group">
        <label>Total Expenses: </label>
        <input type="text" class="form-control texp" name="texp" value="<?php echo $expList[0]['total_tour_expenses'];?>" placeholder="Total Expenses" readonly="readonly"/>
        </div>
        <div class="col-md-4 form-group">
        <label>Final Amount (Total Expenses- Outstanding Balance): </label>
        <input type="text" class="form-control finchamt" value="<?php echo ($expList[0]['total_tour_expenses']-advanceNotSettled($expList[0]['employee_alias']));?>" placeholder="Total Expenses- Outstanding Balance" readonly="readonly"/>
        </div>
<!--<div class="col-md-4 form-group">
        <input type="hidden" class="form-control" name="tplanningreport_old" value="<?php echo $expList[0]['report'];?>"/>
        <label>Tour Report: 
           <?php if($expList[0]['report']!=='0' && $expList[0]['report']!==''){?><a href="<?php echo $expList[0]['report'];?>" target="_blank" class="pdfil">Click for old Report</a><?php }?>
        </label>
        <input type="file" class="form-control tplanningreport" name="tplanningreport" id="tplanningreport"/>
        <small class="redd">(Kinldy upload PDF format and size not exceeding 1MB)</small>
    </div> -->       
    <div class="col-md-4 form-group">&nbsp;</div>
    <div class="col-md-12">
            <div class="col-md-4 col-md-offset-4">
              <input tabindex="0" type="submit" class="btn btn-primary ss_buttons updatex" name="Update" value="Update Expense">
            </div>
          </div>
      
      </form>
</div>
</div>


<script>
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
		$('.ttcmt').val(ttcm);
		$('.tcmt').val(tcmt);
		$('.tlamt').val(tlamt);
		$('.blamt').val(blamt);
		$('.tlomt').val(tlomt);
		$('.texp').val(tamt);$('.finchamt').val(tamt-Number($('.nsamt').val()));
	}
	$(document).on('focus','.tamfor',function (event){ tamfor();});
	function tamfor(){
		var tamt=tcmt=tlamt=blamt=tlomt=ttcm=0;
		$(".tamfor").each(function(){tamt+=Number($(this).val());});
		$(".tcm").each(function(){tcmt+=Number($(this).val());});
		$(".ttcm").each(function(){ttcm+=Number($(this).val());});
		$(".tlam").each(function(){tlamt+=Number($(this).val());});
		$(".blam").each(function(){blamt+=Number($(this).val());});
		$(".tlom").each(function(){tlomt+=Number($(this).val());});
		$('.ttcmt').val(ttcm);
		$('.tcmt').val(tcmt);$('.tlamt').val(tlamt);$('.blamt').val(blamt);$('.tlomt').val(tlomt);$('.texp').val(tamt);$('.finchamt').val(tamt-Number($('.nsamt').val()));
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

	// boarding & loadging -- visit start date,end date
	$('.stDate').each(function(index, element) { 
		 var bcheckin = $(this).find('.bdpd1').datepicker({
			format: 'dd-mm-yyyy',
			onRender: function(date){return date.valueOf() > now.valueOf() ? 'disabled' : '';}
		}).on('changeDate', function(ev){
			if (ev.date.valueOf() < bcheckout.date.valueOf()) {
				var newDate = new Date(ev.date);
				newDate.setDate(newDate.getDate());
				bcheckout.setValue(newDate);
			}
			ajaxAmount($(this).parents('.ajm'));
			bcheckin.hide();
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
}
$(document).on('change','.localConvy',function(){
	var loc = $(this).parent().siblings('.lclHide');
	if($(this).val()==1){
		loc.addClass('hidden');
		loc.addClass('hidden');
	}
	else{loc.removeClass('hidden');
	loc.removeClass('hidden');}
	var sib =  $(this).parent().siblings();
	ajaxAmount($(this).parents('.ajm'));
});

$(document).on('change','.zone_change',function(){
	var sib =  $(this).parent().siblings();
	ajaxSelect($(this),sib);
	ajaxAmount($(this).parents('.ajm'));
	//ajaxAmount($(this).parents('.tbformm'));
	sib.find(".district_change").html("<option>Select District</option>");
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
                    url: "ajaxSelect.php",
                    data: 'type=' + type + '&id=' + id,
                    cache: false,
					async:false,
                    success: function(result) {	
						if(type == "state" || type == "district"){
							sib.find("."+type+"_change").html(result);	
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
            $("#ajaxSelect_State").html("<option value='0' disabled >Select State</option>");
            $("#ajaxSelect_District").html("<option value='0' disabled >Select District</option>");
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
                    url: "../ajaxAmount.php",
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