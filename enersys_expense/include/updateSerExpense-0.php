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
		<div class="col-xs-10 jerror"><?php if(isset($message))echo $message;?></div>
		<input type="hidden" value="<?php echo $ref;?>" name="ref" />
		<input type="hidden" value="<?php echo $expList[0]['approval_level'];?>" class="ref2" name="ref2" />
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
			<input type='text' class="form-control dpd1 cddl bg-white"  name="visitFromDate"  value="<?php echo date("d-m-Y", strtotime($expList[0]['period_of_visit_from'])); ?>"  placeholder="Period of Visit From" />
        </div>
        <div class="col-md-4 form-group">
            <label>Visit: End Date: </label>
			<input type='text' class="form-control dpd2 cddl bg-white" name="visitToDate"  value="<?php echo date("d-m-Y", strtotime($expList[0]['period_of_visit_to'])); ?>" placeholder="Period of Visit To" />
        </div>
		</div>
        <div class="row">
            <div class="col-md-4 form-group">
                <label>No. of days: </label>
                <input type="text"  class="form-control" id="visitFromDate" placeholder="No. of days" value="<?php echo noofDays($expList[0]['period_of_visit_from'],$expList[0]['period_of_visit_to']);?>" readonly />
            </div>
            <div class="col-md-4 form-group">
                <label>Visited place's : </label>
                <input type="text" class="form-control" name="placesOfVisit" value="<?php echo $expList[0]['places_of_visit'];?>" placeholder="Places of Visit"/>
            </div>
            <div class="col-md-4 form-group">
                <label>Purpose: </label>
                <textarea  class="form-control reasonForAdv" name="purpose" placeholder="Purpose" ><?php echo $expList[0]['purpose'];?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 form-group">
                <label>Remarks: </label>
                <textarea  class="form-control reasonForAdv1" name="remarks" placeholder="Remarks" ><?php echo $remarks[0]['remarks'];?></textarea>
            </div>
        </div>
        
        <div class="col-lg-12 form-group dprDetails">
            <label>DPR Details : </label>
            <table class="table table-bordered">
                <thead><tr class="blue cust"><th>DPR Number</th><th>Category</th><th>Submitted Date</th><th>Remarks</th><th>Expense</th></tr></thead>
                <tbody id="dpr_res">
                <?php
				$dprdate1=date("Y-m-d", strtotime($expList[0]['period_of_visit_from']));
				$dprdate2=date("Y-m-d", strtotime($expList[0]['period_of_visit_to']));
				$emp =$_SESSION['ec_user_alias'];
				$s1=mysqli_query($mr_con,"SELECT dpr_ref_no,category_alias,DATE(sub_date_time) as sub_date,remarks,expense_incurred FROM `ec_dpr` where emp_alias = '$emp' AND DATE(sub_date_time) BETWEEN '$dprdate1' AND '$dprdate2'");
				$numm=mysqli_num_rows($s1);
				if($numm>0){
					while($rss=mysqli_fetch_array($s1)){
						if($rss['category_alias']==0){
							$catt='Your DPR is not Submitted';
						}else{
							$catt=getDprCat($rss['category_alias']);
						}
				echo '<tr class="tbform">
										<td><p>'.$rss['dpr_ref_no'].'</p></td>
										<td><p>'.$catt.'</p></td>
										<td><p>'.date("Y-m-d", strtotime($rss['sub_date'])).'</p></td>
										<td><p>'.$rss['remarks'].'</p></td>
										<td><p>'.$rss['expense_incurred'].'</p></td>
									</tr>';
									
					}
				}else{
				echo ' <tr class="tbform">
										<td colspan="5" align="center"><p>No Records found</p></td>
										
									</tr>';
				}
								
				?>
                </tbody>
            </table>
        </div>
        
      	<div class="col-lg-12 form-group">  <?php if($lconveyance!=0){ $lcnt = count($lconveyance); }?>
            <label>Local Conveyance : </label>&nbsp;&nbsp;<a href="#" data-get="fare11" class="addNewLoc"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare11" class="RemoveLoc" data-cnt="<?php echo ($lcnt+1);?>"><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix" id='fare11'>
            <div class="localConv">
            <?php if($lconveyance!=0){ $lcnt = count($lconveyance); ?>
           <?php
			 $l = 1; foreach($lconveyance as $conveyance1){$tamtll+=$conveyance1['amount'];
						 if(getArea($conveyance1['district_alias'])==0){
							 $disp_area='Plain Area'; $amount_appli = 0.02;
						}else if(getArea($conveyance1['district_alias'])==1){
								 $disp_area='Hilly area'; $amount_appli = 0.04;
						}?>
                   <div id="localConv_<?php echo $l;?>" class="panel panel-default tbformm ajm" >
                    	<div class="panel-heading panlbakg">
                        	<h3 class="panel-title">Local Conveyance <?php echo $l;?>
                            <a class="pull-right rowRemove" data-toggle="tooltip" data-placement="top" title="Remove" href="<?php echo $conveyance1['alias'];?>" data-type="updateSerExpense-0" sitem="lc"><i class="glyphicon glyphicon-trash"></i></a></h3>
                   		 </div>
                   		<div class="panel-body">
                    	<div class="row">
                             <div class="col-md-3 form-group">
                                <label>Zone : </label>
                                <input type="hidden" name="idc_l[]" value="<?php echo $conveyance1['alias'];?>"/>
                                <select class="form-control showgradedesg zone_change"  name="zone_l[]"  data="state" ref="lc">
                                    <option value="0" selected="selected">Zone</option>
                                        <?php $getZn=getZones();if($getZn!=0){foreach($getZn as $rec){echo "<option value='".$rec['zone_alias']."' ".checkSelected($rec['zone_alias'],$conveyance1['zone_alias']).">".$rec['zone_name']."</option>";}}else echo "<option disabled='disabled'>Add Zone</option>";?>               
                                 </select>
                            </div>
                            <div class="col-md-3 form-group sel_empty">
                                <label>State : </label>
                                 <select class="form-control showgradedesg state_change"   name="state_l[]"  data="district">
                    <?php $getst=getStates($conveyance1['zone_alias']);if($getst!=0){foreach($getst as $srec){echo "<option value='".$srec['state_alias']."' ".checkSelected($srec['state_alias'],$conveyance1['state_alias']).">".$srec['state_name']."</option>";}}else echo "<option disabled='disabled'>Add State</option>";?>
                </select>
                            </div>
                            <div class="col-md-3 form-group sel_empty">
                                <label>District : </label>
                                <select class="form-control showgradedesg district_change"   name="district_l[]"  data="area">
                   <?php $getdt=getDistricts($conveyance1['state_alias']);if($getdt!=0){foreach($getdt as $drec){echo "<option value='".$drec['district_alias']."' ".checkSelected($drec['district_alias'],$conveyance1['district_alias']).">".$drec['district_name']."</option>";}}else echo "<option disabled='disabled'>Add District</option>";?>
                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Area : </label>
                                <input class="form-control area_change" type="text" name="area_l[]" placeholder="Area" value="<?php echo $disp_area;?>"  readonly="readonly"/>   
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Bucket : </label>
                                     <select class="form-control localConvy"  name="bucket[]"  >
                                        <option value="" selected="selected">Bucket</option>
                                        <option value="0"  <?php echo checkSelected($conveyance1['bucket'],'0');?>>Secondary transportation </option>
                                        <option value="1"  <?php echo checkSelected($conveyance1['bucket'],'1');?>>Local Conveyance</option>
                                     </select>
                            </div>
                             <div class="col-md-3 form-group lclHide <?php if($conveyance1['bucket'] == 1) echo "hidden";?>" ticket_empty1>
                                <label class="cap">Capacity : </label>   
                                     <select class="form-control capacity_change cap selectpicker" name="cap[]"  data="weight" data-live-search="true">
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
                                <select class="form-control"  name="mot_l[]" id="mot">
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
                               <input type="text" class="form-control" name="from_l[]" placeholder="From Place" value="<?php echo $conveyance1['from_place'];?>"/>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>To : </label>  
                                <input type="text" class="form-control" name="to_l[]" placeholder="To Place" value="<?php echo $conveyance1['to_place'];?>"/>
                            </div>
                            <div class="col-md-3 form-group ticket_empty">
                                <label>Ticket ID : </label>  
                                <select id="ticket_idl" class="form-control selectpicker" name="ticket_idl[]" data-live-search="true" placeholder>
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                        <option value="1" <?php if($conveyance1['ticket_alias'] == "1")echo "selected";?>>Others</option>
                                        <?php $getTid=getTicket($_SESSION['ec_user_alias']);
										 if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."' ".checkSelected($rec['ticket_alias'],$conveyance1['ticket_alias']).">".$rec['ticket_id']."</option>";}}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>DPR Number : </label>  
                                <input type="text" class="form-control" name="dprNum_l[]" placeholder="DPR Number" value="<?php echo $conveyance1['dpr_number'];?>" />
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
                                <select class="form-control showgradedesg zone_change" name="zone_l[]"  data="state" ref="lc">
                                    <option value="0" selected="selected">Zone</option>
                                    <?php $getZn=getZones();if($getZn!=0){foreach($getZn as $rec){echo "<option value='".$rec['zone_alias']."'>".$rec['zone_name']."</option>";}}else echo "<option disabled='disabled'>Add Zone</option>";?>
                                </select>
                            </div>
                            <div class="col-md-3 form-group sel_empty">
                                <label>State : </label>
                                <select class="form-control showgradedesg state_change"  name="state_l[]"  data="district">
                                    <option value="0" selected="selected" class="depsel">State</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group sel_empty">
                                <label>District : </label>
                                <select class="form-control showgradedesg district_change"   name="district_l[]"  data="area">
                                     <option value="0" selected="selected" class="depsel">District</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Area : </label>
                                <input class="form-control area_change" type="text" name="area_l[]" placeholder="Area" value  readonly="readonly"/>   
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Bucket : </label>
                                 <select class="form-control localConvy"  name="bucket[]"  >
                                    <option value="" selected="selected" >Bucket</option>
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
                                <input type="text" class="form-control qnty ocap" name="quantityCell[]" autocomplete="off" placeholder="Quantity" />
                            </div>
                            <div class="col-md-3 form-group lclHide hidden">
                                <label class="ocap">No.of Kilometers : </label>   
                                <input type="text" class="form-control numKilo ocap" name="numKilometers[]" autocomplete="off" placeholder="No.of Kilometers"/>
                            </div>
                            <div class="col-md-3 form-group lclHide hidden">
                                <label class="ocap">Amount Appilicable : </label>   
                                <input type="text" class="form-control ocap wofCell appli_change" name="amtappli[]" placeholder="Amount" readonly/>
                            </div>
                             <div class="col-md-3 form-group">
                                <label>Date of Travel : </label>   
                                <input type="text" class="form-control  expense_dates cddl bg-white" name="dot_l[]" placeholder="DD-MM-YYYY" readonly/>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Mode of travel : </label>   
                                <select class="form-control"  name="mot_l[]" id="mot">
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
                                <input type="text" class="form-control" name="from_l[]" placeholder="From Place"/>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>To : </label>  
                                <input type="text" class="form-control" name="to_l[]" placeholder="To Place"/>
                            </div>
                            <div class="col-md-3 form-group ticket_empty">
                                <label>Ticket ID : </label>  
                                <select id="ticket_idl" class="form-control selectpicker" name="ticket_idl[]" data-live-search="true" placeholder>
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
                                    <input type="text" class="form-control expense_dates cddl bg-white" name="dot[]" value="<?php echo date("d-m-Y", strtotime($conveyance1['date_of_travel'])); ?>" />
                                </td>
                                <td>
                                    <select class="form-control" name="mot[]" id="mot" >
                                        <option value="0">Mode of travel</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'ACT');?> value="ACT">ACT</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'AIR');?> value="AIR">Air</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Train 2nd AC');?> value="Train 2nd AC">Train 2nd AC</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Train 3 tier');?> value="Train 3 tier">Train 3 tier</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Train Sleeper');?> value="Train Sleeper">Train Sleeper</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Volvo AC Bus');?> value="Volvo AC Bus">Volvo AC Bus</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Non-AC Bus');?> value="Non-AC Bus">Non-AC Bus</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Own Vehicle');?> value="Own Vehicle">Own Vehicle</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Cab');?> value="Cab">Cab</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Auto');?> value="Auto">Auto</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Local Train');?> value="Local Train">Local Train</option>
                                        <option <?php echo checkSelected($conveyance1['mode_of_travel'],'Any Public Transport');?> value="Any Public Transport">Any Public Transport</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control"  value="<?php echo $conveyance1['from_place'];?>" name="from[]" placeholder="From"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="<?php echo $conveyance1['to_place'];?>" name="to[]" placeholder="To"/>
                                </td>
                                <td class="ticket_empty">
                                    <select id="cticketID" class="form-control selectpicker" name="cticket_id[]" data-live-search="true" placeholder>
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                        <option value="1" <?php if($conveyance1['ticket_alias'] == "1")echo "selected";?>>Others</option>

                                        <?php $getTid=getTicket($_SESSION['ec_user_alias']);
										 if($getTid!=0){foreach($getTid as $rec){?> <option value=<?php echo $rec['ticket_alias']; ?> <?php echo checkSelected($conveyance1['ticket_alias'],$rec['ticket_alias']);?>><?php echo $rec['ticket_id']; ?></option><?php }}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                                </td>

                                <td><input type="text" class="form-control" name="cdprno[]" placeholder="DPR Number" value="<?php echo $conveyance1['dpr_number'];?>"/></td>
                                <td>
                                    <input type="hidden" class="form-control" name="motbill_old[]" value="<?php echo $conveyance1['document_link'];?>"/>
                                    <?php if($conveyance1['document_link']!=='0'){?>
                                        <a href="<?php echo $conveyance1['document_link'];?>" target="_blank" class="pdfil col-md-2">Click</a>
                                    <?php }?>
                                    <div class="col-md-10">
	                                  <!--  <input type="hidden" class="form-control" name="motbill[]" value="0"/>-->
                                    	<input type="file" class="form-control" name="motbill[]" />
                                    </div>
                                </td>
                               <td><div class="col-md-9 pdNone"><input type="text" class="form-control amtt tamfor tcm" autocomplete="off" value="<?php echo $conveyance1['amount'];?>" name="amt[]" placeholder="Amount"/></div>
                                	<div><a class="pull-right rowRemove dlbtn" data-toggle="tooltip" data-placement="top" title="Remove" href="<?php echo $conveyance1['alias'];?>" data-type="updateSerExpense-0" sitem="con"><i class="glyphicon glyphicon-trash"></i></a></div>
                                </td>

                            </tr>
                            <?php }?>
                        </tbody>
                        <?php }?>
                        <tbody id='fare0'>
                            <tr class="tbform ajm">
                                <td> <input type="hidden" name="idc[]" value="0"/><input type="text" class="form-control expense_dates cddl bg-white" name="dot[]" placeholder="DD-MM-YYYY" readonly/></td>
                                <td><select class="form-control" name="mot[]" id="mot">
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
                                    <select id="cticketID" class="form-control selectpicker" name="cticket_id[]" data-live-search="true" placeholder>
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                         <option value="1" >Others</option>

                                        <?php $getTid=getTicket($_SESSION['ec_user_alias']);
										 if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."'>".$rec['ticket_id']."</option>";}}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                                </td>

                                <td><input type="text" class="form-control" name="cdprno[]" placeholder="DPR Number"/></td>
                                <td><!--<input type="hidden" class="form-control" name="motbill[]" value="0"/>-->
                                <input type="file" class="form-control" name="motbill[]"/></td>
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
                        <thead><tr class="blue cust"><th> Check in Date</th><th> Check out Date</th><th>Zone</th><th>State</th><th>District</th><th>Hotel Name</th><th>Ticket ID</th><th>DPR Number</th><th>Amount</th></tr></thead>
                      <?php if($lodging!=0){?>
                       <tbody>
                       <?php foreach($lodging as $lodging1){$tamtl+=$lodging1['amount'];?>
                        <tr class="tbform ajm stDate1">
                               <td><input type="hidden" name="idl[]"  value="<?php echo $lodging1['alias'];?>"/>
                               <input type="text" class="form-control bdpd3 cddl bg-white clc"  value="<?php echo date("d-m-Y", strtotime($lodging1['check_in'])); ?>" name="checkin[]" placeholder="DD-MM-YYYY"/></td>
                                <td><input type="text" class="form-control bdpd4 cddl bg-white slc"  value="<?php echo date("d-m-Y", strtotime($lodging1['check_out'])); ?>" name="checkout[]" placeholder="DD-MM-YYYY"/></td>
                            	<td>
                                    <select class="form-control showgradedesg zone_change"  name="zone_ld[]"  data="state" ref="ld">
                <option value="0" selected="selected" >Select Zone</option>
                    <?php $getZn=getZones();if($getZn!=0){foreach($getZn as $rec){echo "<option value='".$rec['zone_alias']."' ".checkSelected($rec['zone_alias'],$lodging1['zone_alias']).">".$rec['zone_name']."</option>";}}else echo "<option disabled='disabled'>Add Zone</option>";?>               
                </select>
                                </td>
                                <td class="sel_empty">                                  
                                    <select class="form-control showgradedesg state_change"   name="state_ld[]"  data="district">
                    <?php $getst=getStates($lodging1['zone_alias']);if($getst!=0){foreach($getst as $srec){echo "<option value='".$srec['state_alias']."' ".checkSelected($srec['state_alias'],$lodging1['state_alias']).">".$srec['state_name']."</option>";}}else echo "<option disabled='disabled'>Add State</option>";?>
                </select>
                                </td>
                                <td class="sel_empty">                                                                         
                                     <select class="form-control showgradedesg district_change"  name="district_ld[]" >
                   <?php $getdt=getDistricts($lodging1['state_alias']);if($getdt!=0){foreach($getdt as $drec){echo "<option value='".$drec['district_alias']."' ".checkSelected($drec['district_alias'],$lodging1['district_alias']).">".$drec['district_name']."</option>";}}else echo "<option disabled='disabled'>Add District</option>";?>
                </select>
                                </td>
								<td class="changw"><input type="text" class="form-control" name="hotelName[]" value="<?php echo $lodging1['hotel_name'];?>" placeholder="Hotel Name"/></td>
                                 <td class="ticket_empty">
                                    <select id="ticket_idld" class="form-control selectpicker" name="ticket_idld[]" data-live-search="true" placeholder>
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                  		<option value="1" <?php if($lodging1['ticket_alias'] == "1")echo "selected";?>>Others</option>
                                        <?php $getTid=getTicket($_SESSION['ec_user_alias']);
										 if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."' ".checkSelected($rec['ticket_alias'],$lodging1['ticket_alias']).">".$rec['ticket_id']."</option>";}}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="dprNum_ld[]" placeholder="DPR Number" value="<?php echo $lodging1['dpr_number'];?>" /></td>
                                <td>
                                	<div class="col-md-9 pdNone"><input type="text" class="form-control amtt tamfor tlam selfamm ld" name="lamt[]" value="<?php echo $lodging1['amount'];?>" placeholder="Amount" readonly="readonly"/></div>
                                	<div><a class="pull-right rowRemove dlbtn" data-toggle="tooltip" data-placement="top" title="Remove" href="<?php echo $lodging1['alias'];?>" data-type="updateSerExpense-0" sitem="ld"><i class="glyphicon glyphicon-trash" ></i></a></div>
                                </td>
                           
                            </tr>
                          <?php }?>
                        </tbody>
					<?php }?>
                       
                        <tbody id='fare1'>
                        <tr class="tbform ajm stDate1">
                                <td> <input type="hidden" name="idl[]" value="0"/>    
                                <input type="text" class="form-control bdpd3 cddl bg-white clc" name="checkin[]" placeholder="DD-MM-YYYY" readonly/></td>
                                <td><input type="text" class="form-control bdpd4 cddl bg-white slc" name="checkout[]" placeholder="DD-MM-YYYY" readonly/></td>
                                <td>                               
                                    <select class="form-control showgradedesg zone_change" name="zone_ld[]"  data="state" ref="ld">
                <option value="0" selected="selected">Zone</option>
                    <?php $getZn=getZones();if($getZn!=0){foreach($getZn as $rec){echo "<option value='".$rec['zone_alias']."'>".$rec['zone_name']."</option>";}}else echo "<option disabled='disabled'>Add Zone</option>";?>
                </select>
                                </td>
                                <td class="sel_empty">                                    
                                    <select class="form-control showgradedesg state_change" name="state_ld[]"  data="district">
                    <option value="0" selected="selected" class="depsel">State</option>
                </select>
                                </td>
                                <td class="sel_empty">
                                     <select class="form-control showgradedesg district_change"  name="district_ld[]" >
                     <option value="0" selected="selected" class="depsel">District</option>
                </select>
                                </td>
                                <td class="changw"><input type="text" class="form-control" name="hotelName[]" placeholder="Hotel Name" value/></td>
                                 <td class="ticket_empty">
                                    <select id="ticket_idld" class="form-control selectpicker" name="ticket_idld[]" data-live-search="true" placeholder>
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                        <option value="1">Others</option>
                                        <?php $getTid=getTicket($_SESSION['ec_user_alias']);
										 if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."'>".$rec['ticket_id']."</option>";}}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="dprNum_ld[]" placeholder="DPR Number" value/></td>
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
                        <thead><tr class="blue cust"><th> Visit: Start Date</th><th> Visit: End Date</th><th>Zone</th><th>State</th><th>District</th><th>Ticket ID</th><th>DPR Number</th><th>Amount</th></tr></thead>
                       <?php if($boarding!=0){?>
                        <tbody>
                        <?php foreach($boarding as $boarding1){$bamtl+=$boarding1['amount'];?>
                            <tr class="tbform ajm stDate">   
                                <td><input type="hidden" name="idb[]" value="<?php echo $boarding1['alias'];?>"/>
                                 <input type="text" class="form-control bdpd1 cddl bg-white clc"  value="<?php echo date("d-m-Y", strtotime($boarding1['check_in'])); ?>" name="checkinb[]" placeholder="DD-MM-YYYY"/>
</td>
                                <td><input type="text" class="form-control bdpd2 cddl bg-white slc"  value="<?php echo date("d-m-Y", strtotime($boarding1['check_out'])); ?>" name="checkoutb[]" placeholder="DD-MM-YYYY"/></td>
                            	<td>                                  
                                    <select class="form-control showgradedesg zone_change"  name="zone_bo[]"  data="state" ref="bd">
                <option value="0" selected="selected">Zone</option>
                    <?php $getZn=getZones();if($getZn!=0){foreach($getZn as $rec){echo "<option value='".$rec['zone_alias']."'  ".checkSelected($rec['zone_alias'],$boarding1['zone_alias']).">".$rec['zone_name']."</option>";}}else echo "<option disabled='disabled'>Add Zone</option>";?>
                </select>
                                </td>
                                <td class="sel_empty">                                    
                            <select class="form-control showgradedesg state_change"  name="state_bo[]"  data="district">
                    <?php $getst=getStates($boarding1['zone_alias']);if($getst!=0){foreach($getst as $srec){echo "<option value='".$srec['state_alias']."' ".checkSelected($srec['state_alias'],$boarding1['state_alias']).">".$srec['state_name']."</option>";}}else echo "<option disabled='disabled'>Add State</option>";?>
                </select>
                                </td>
                                <td class="sel_empty">
                                     <select class="form-control showgradedesg district_change" name="district_bo[]"  >
                   <?php $getdt=getDistricts($boarding1['state_alias']);if($getdt!=0){foreach($getdt as $drec){echo "<option value='".$drec['district_alias']."' ".checkSelected($drec['district_alias'],$boarding1['district_alias']).">".$drec['district_name']."</option>";}}else echo "<option disabled='disabled'>Add District</option>";?>
                </select>
                                </td>                                
                                 <td class="ticket_empty">
                                    <select id="ticket_bo" class="form-control selectpicker" name="ticket_bo[]" data-live-search="true" placeholder>
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                        <option value="1" <?php if($boarding1['ticket_alias'] == "1")echo "selected";?>>Others</option>
                                        <?php $getTid=getTicket($_SESSION['ec_user_alias']);
										 if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."' ".checkSelected($rec['ticket_alias'],$boarding1['ticket_alias']).">".$rec['ticket_id']."</option>";}}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="dprNum_bo[]" placeholder="DPR Number" value="<?php echo $boarding1['dpr_number'];?>"/></td>
                                <td><div class="col-md-9 pdNone"><input type="text" class="form-control amtt tamfor blam selfamm bd" name="bamt[]" value="<?php echo $boarding1['amount'];?>" placeholder="Amount" readonly="readonly"/></div>
                                	<div><a class="pull-right rowRemove dlbtn" data-toggle="tooltip" data-placement="top" title="Remove" href="<?php echo $boarding1['alias'];?>" data-type="updateSerExpense-0" sitem="bd"><i class="glyphicon glyphicon-trash"></i></a></div>
                                </td>
                           
                            </tr>
                            <?php }?>
                        </tbody>
                        <?php }?>
                        
                        <tbody id='fare'>
                            <tr class="tbform ajm stDate"> 
                                <td><input type="hidden" name="idb[]" value="0"/>
                                <input type="text" class="form-control bdpd1 cddl bg-white clc" name="checkinb[]" placeholder="DD-MM-YYYY" readonly/></td>
                                <td><input type="text" class="form-control bdpd2 cddl bg-white slc" name="checkoutb[]" placeholder="DD-MM-YYYY" readonly/></td>
                            	<td>
                                    <select class="form-control showgradedesg zone_change" tabindex="1" name="zone_bo[]"  data="state" ref="bd">
                <option value="0" selected="selected">Zone</option>
                    <?php $getZn=getZones();if($getZn!=0){foreach($getZn as $rec){echo "<option value='".$rec['zone_alias']."'>".$rec['zone_name']."</option>";}}else echo "<option disabled='disabled'>Add Zone</option>";?>
                </select>
                                </td>
                                <td class="sel_empty">                                    
                                    <select class="form-control showgradedesg state_change" name="state_bo[]"  data="district">
                    <option value="0" selected="selected" class="depsel">State</option>
                </select>
                                </td>
                                <td class="sel_empty">
                                     <select class="form-control showgradedesg district_change" name="district_bo[]"  >
                     <option value="0" selected="selected" class="depsel">District</option>
                </select>
                                </td>                                
                                 <td class="ticket_empty">
                                    <select id="ticket_bo" class="form-control selectpicker" name="ticket_bo[]" data-live-search="true" placeholder>
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
                                <input type="text" class="form-control" name="others[]" value="<?php echo $other_expenses1['description'];?>"  placeholder="Description"/></td>
                                <td><input type="text" class="form-control expense_dates cddl bg-white" value="<?php echo date("d-m-Y", strtotime($other_expenses1['checked_date'])); ?>"  name="odate[]" placeholder="DD-MM-YYYY"/></td>
                                <td>
 								<input type="hidden" class="form-control" name="ofile_old[]" value="<?php echo $other_expenses1['document_link'];?>"/>
                                <?php if($other_expenses1['document_link']!=='0'){?>
                                    <a href="<?php echo $other_expenses1['document_link'];?>" target="_blank" class="pdfil col-md-2">Click</a>
                                <?php }?>
                                <div class="col-md-10">
                                    <input type="file" class="form-control" name="ofile[]" />
                                </div>                                </td>
                                <td class="ticket_empty">
                                    <select id="ticket_ot" class="form-control selectpicker" name="ticket_ot[]" data-live-search="true" placeholder>
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                        <option value="1" <?php if($other_expenses1['ticket_alias'] == "1")echo "selected";?>>Others</option>
                                        <?php $getTid=getTicket($_SESSION['ec_user_alias']);
										 if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."' ".checkSelected($rec['ticket_alias'],$other_expenses1['ticket_alias']).">".$rec['ticket_id']."</option>";}}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="dprNum_ot[]" placeholder="DPR Number" value="<?php echo $other_expenses1['dpr_number'];?>"/></td>
                                <td>
                                	<div class="col-md-9 pdNone"><input type="text" class="form-control amtt tamfor tlom" autocomplete="off" value="<?php echo $other_expenses1['amount'];?>"  name="oamt[]" placeholder="Amount"/></div>
                                	<div><a class="pull-right rowRemove dlbtn" data-toggle="tooltip" data-placement="top" title="Remove" href="<?php echo $other_expenses1['alias'];?>" data-type="updateSerExpense-0" sitem="ot"><i class="glyphicon glyphicon-trash"></i></a></div>
                                </td>
                            
                            </tr>
                            <?php }?>
                        </tbody>
                        <?php }?>
                        
                        <tbody id='fare2'>
                            <tr class="tbform ajm">
                                <td> <input type="hidden" name="ido[]" value="0"/><input type="text" class="form-control" name="others[]" placeholder="Description"/></td>
                                <td><input type="text" class="form-control expense_dates cddl bg-white" name="odate[]" placeholder="DD-MM-YYYY" readonly/></td>
                                <td><!--<input type="hidden" class="form-control" name="ofile[]" value="0"/>-->
                                <input type="file" class="form-control" name="ofile[]"/></td>
                                <td class="ticket_empty">
                                    <select id="ticket_ot" class="form-control selectpicker" name="ticket_ot[]" data-live-search="true" placeholder>
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                         <option value="1">Others</option>
                                        <?php $getTid=getTicket($_SESSION['ec_user_alias']);
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
        <input type="text" class="form-control texp" name="texp" value="<?php echo round($expList[0]['total_tour_expenses']);?>" placeholder="Total Expenses" readonly="readonly"/>
        </div>
        
        <div class="col-md-4 form-group">
        <label>Final Amount (Total Expenses- Outstanding Balance): </label>
        <input type="text" class="form-control finchamt" value="<?php echo (round($expList[0]['total_tour_expenses'])-advanceNotSettled($expList[0]['employee_alias']));?>" placeholder="Total Expenses- Outstanding Balance" readonly="readonly"/>
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
        <div class="form-group col-xs-4 col-sm-6 col-sm-offset-1 morpad">
            <div class="col-xs-12">
	        <input  type="submit" class="btn btn-primary ss_buttons saveinDraft" name="saveinDraft" value="Draft">
            <input  type="submit" class="btn btn-primary ss_buttons updatex" name="approve" value="Request">
            </div>
        </div>
        </form>
</div>
</div>
