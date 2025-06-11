        <div class="col-lg-12 form-group">
            <label>Local Conveyance : </label>&nbsp;&nbsp;<a href="#" data-get="fare" class="addNewLoc"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare" class="RemoveLoc"><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix">
                <div class="column">
                    <table class="table table-bordered findcl1" id="fare_tab">
                        <thead class="localCon"><tr class="blue cust"><th>Zone</th><th>State</th><th>District</th><th>Area</th><th>Bucket</th><th>Capacity</th><th>Weight of the Cell</th><th>Quantity</th><th>No of Kilometers</th></tr></thead>
                        <tbody class='fare1'>
                        <tr class="tbform" data-ref="1">
                            	<td>
                                   <select class="form-control showgradedesg zone_change" tabindex="1" name="zone_l[]"  required="required" autofocus data="state" ref="lc">
                <option value="0" selected="selected" disabled="disabled">Zone</option>
                    <?php $getZn=getZones();if($getZn!=0){foreach($getZn as $rec){echo "<option value='".$rec['zone_alias']."'>".$rec['zone_name']."</option>";}}else echo "<option disabled='disabled'>Add Zone</option>";?>
                </select>
                                </td>
                                <td class="sel_empty">
                                    <select class="form-control showgradedesg state_change" tabindex="2"  required="required" name="state_l[]" autofocus data="district">
                    <option value="0" selected="selected" disabled="disabled" class="depsel">State</option>
                </select>
                                </td>
                                <td class="sel_empty">                                                                         
                                     <select class="form-control showgradedesg district_change" tabindex="3"  name="district_l[]" autofocus data="area">
                     <option value="0" selected="selected" disabled="disabled" class="depsel">District</option>
                </select>
                                </td>
                                 <td>
                                 <input class="form-control area_change" type="text" name="area_l[]" placeholder="Area" value=""  readonly="readonly"/>                                   
                                </td>
                                <td>
                                     <select class="form-control localConvy" tabindex="3" required="required" name="bucket[]" autofocus >
                                        <option value="" selected="selected" disabled="disabled">Bucket</option>
                                        <option value="0">Secondary transportation </option>
                                        <option value="1">Local Conveyance</option>
                                     </select>
                                </td>
                                <td class="lclHide">
                                     <select class="form-control capacity_change cap" tabindex="3" required="required" name="cap[]" autofocus data="weight">
                                        <option value="0" selected="selected" disabled="disabled">Capacity</option>
                                         <?php $getCp=getCapacity();if($getCp!=0){foreach($getCp as $rec){echo "<option value='".$rec['product_alias']."'>".$rec['product_description']."</option>";}}else echo "<option disabled='disabled'>Add Capacity</option>";?> 
                                     </select>
                                </td>
                                <td class="lclHide"><input type="text" class="form-control wofCell weight_change ocap" name="wofCell[]" placeholder="Weight of the cell" readonly/></td>
                                <td class="lclHide"><input type="text" class="form-control qnty ocap" name="quantityCell[]" placeholder="Quantity" /></td>
                                <td class="lclHide"><input type="text" class="form-control numKilo ocap" name="numKilometers[]" placeholder="No.of Kilometers"/></td>
                                </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered findcl2" id="fare_tab">
                        <thead class="localCon"><tr class="blue cust"><th>Amount Applicable</th><th>Date of travel</th><th>Mode of travel</th><th>From</th><th>To</th><th>Amount</th><th>Ticket ID</th><th>DPR Number</th></tr></thead>
                        <tbody class='fare2'>
                            <tr class="tbform" data-ref="1">
                            <td class="lclHide"><input type="text" class="form-control ocap wofCell appli_change" name="amtappli[]" placeholder="Amount" readonly/></td>
                            <td><input type="text" class="form-control  expense_dates cddl" name="dot_l[]" placeholder="DD-MM-YYYY" readonly/></td>
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
                                <td><input type="text" class="form-control amtt tamfor ttcm lc" name="amt_l[]" placeholder="Amount" readonly/></td>
                               <td>
                                    <select id="ticket_idl" class="form-control selectpicker" name="ticket_idl[]" data-live-search="true" placeholder="">
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                        <?php $getTid=getTicket($_SESSION['ec_user_alias']);
										 if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."'>".$rec['ticket_id']."</option>";}}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="dprNum_l[]" placeholder="DPR Number"/></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-4 pull-right"><input type="text" class="form-control ttcmt" name="fare_total" placeholder="Total Local Conveyance" readonly /></div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 form-group">
            <label>Local Conveyance : </label>&nbsp;&nbsp;<a href="#" data-get="fare5" class="addNew"><span class="glyphicon glyphicon-plus-sign"></span></a>
            <a href="#" data-get="fare5" class="RemoveField"><span class="glyphicon glyphicon-minus-sign"></span></a>
            <div class="clearfix">
                <div class="column">
                  <div style="width:1032px; overflow-x:scroll;">
                    <table class="table table-bordered" id="fare_tab" style="width:2000px !important;">
                        <thead class="localCon"><tr class="blue cust">
                        <th>Zone</th>
                        <th>State</th>
                        <th>District</th>
                        <th>Area</th>
                        <th>Bucket</th>

                        <th >Capacity</th>
                        <th>Weight of the Cell</th>
                        <th>Quantity</th>
                        <th>No of Kilometers</th>
                        <th>Amount Applicable</th>
                        <th>Date of travel</th>
                        <th>Mode of travel</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Amount</th>
                        <th>Ticket ID</th>
                        <th>DPR Number</th>
                        </tr></thead>
                         <tbody id='fare5'>
                        <?php if($lconveyance!=0){?>
						<tbody>
							<?php foreach($lconveyance as $conveyance1){$tamtll+=$conveyance1['amount'];?>
							<tr class="tbform">
                            <td><input type="hidden" name="idc_l[]" value="<?php echo $conveyance1['alias'];?>"/>
                             <select class="form-control showgradedesg" tabindex="1" name="zone_l[]"  required="required" autofocus onchange="ajaxSelect(this.options[this.selectedIndex].value,'state');">
                <option value="0" selected="selected" disabled="disabled">Select Zone</option>
                    <?php $getZn=getZones();if($getZn!=0){foreach($getZn as $rec){echo "<option value='".$rec['zone_alias']."' ".checkSelected($rec['zone_alias'],$conveyance1['zone_alias']).">".$rec['zone_name']."</option>";}}else echo "<option disabled='disabled'>Add Zone</option>";?>               
                </select>
                                </td>
                                <td class="sel_empty">                                  
                <select class="form-control showgradedesg" tabindex="2"  required="required" name="state_l[]" autofocus id="ajaxSelect_state" onchange="ajaxSelect(this.options[this.selectedIndex].value,'district')">
                    <?php $getst=getStates($conveyance1['zone_alias']);if($getst!=0){foreach($getst as $srec){echo "<option value='".$srec['state_alias']."' ".checkSelected($srec['state_alias'],$conveyance1['state_alias']).">".$srec['state_name']."</option>";}}else echo "<option disabled='disabled'>Add State</option>";?>
                </select>
                                </td>
                                <td class="sel_empty">                                                                         
                                    <select class="form-control showgradedesg" tabindex="3"  name="district_l[]" autofocus id="ajaxSelect_district" onchange="ajaxSelect(this.options[this.selectedIndex].value,'area')">
                   <?php $getdt=getDistricts($conveyance1['state_alias']);if($getdt!=0){foreach($getdt as $drec){echo "<option value='".$drec['district_alias']."' ".checkSelected($drec['district_alias'],$conveyance1['district_alias']).">".$drec['district_name']."</option>";}}else echo "<option disabled='disabled'>Add District</option>";?>
                </select>
                                </td>
                                 <td>
                    <?php $getarea= getArea($getDetails[0]['district_alias']);
						if($getarea==0){
							$loc_disp_area = "Plain Area";
						}else if($getarea==1){
							$loc_disp_area = "Hilly Area";
						}else{
							$loc_disp_area = "";
						}
						?>
                      <input class="form-control area_change" type="text" name="area_l[]" placeholder="Area" value="<?php echo $loc_disp_area;?>"  readonly="readonly"/>                                   
                                </td>
                                <td>
                                     <select class="form-control localConvy" tabindex="3" required="required" name="bucket[]" autofocus >
                                        <option value="" selected="selected" disabled="disabled">Bucket</option>
                                        <option value="0" <?php echo checkSelected($conveyance1['bucket'],'0');?>>Secondary transportation </option>
                                        <option value="1" <?php echo checkSelected($conveyance1['bucket'],'1');?>>Local Conveyance</option>
                                     </select>
                                </td>
                                <td class="lclHide">
                                     <select class="form-control capacity_change cap" tabindex="3" required="required" name="cap[]" autofocus data="weight">
                                        <option value="0" selected="selected" disabled="disabled">Capacity</option>
                                         <?php $getCp=getCapacity();if($getCp!=0){foreach($getCp as $rec){echo "<option value='".$rec['product_alias']."' ".checkSelected($rec['product_alias'],$conveyance1['capacity']).">".$rec['product_description']."</option>";}}else echo "<option disabled='disabled'>Add Capacity</option>";?> 
                                     </select>
                                </td>
                                <td class="lclHide"><input type="text" class="form-control wofCell weight_change ocap" name="wofCell[]" placeholder="Weight of the cell" readonly/></td>
                                <td class="lclHide"><input type="text" class="form-control qnty ocap" name="quantityCell[]" placeholder="Quantity" /></td>
                                <td class="lclHide"><input type="text" class="form-control numKilo ocap" name="numKilometers[]" placeholder="No.of Kilometers"/></td>
                                <td class="lclHide"><input type="text" class="form-control ocap wofCell appli_change" name="amtappli[]" placeholder="Amount" readonly/></td>
                                <td>
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
                         
                            <tr class="tbform">
                            	<td>
                                   <select class="form-control showgradedesg zone_change" tabindex="1" name="zone_l[]"  required="required" autofocus data="state" ref="lc">
                <option value="0" selected="selected" disabled="disabled">Zone</option>
                    <?php $getZn=getZones();if($getZn!=0){foreach($getZn as $rec){echo "<option value='".$rec['zone_alias']."'>".$rec['zone_name']."</option>";}}else echo "<option disabled='disabled'>Add Zone</option>";?>
                </select>
                                </td>
                                <td class="sel_empty">
                                    <select class="form-control showgradedesg state_change" tabindex="2"  required="required" name="state_l[]" autofocus data="district">
                    <option value="0" selected="selected" disabled="disabled" class="depsel">State</option>
                </select>
                                </td>
                                <td class="sel_empty">                                                                         
                                     <select class="form-control showgradedesg district_change" tabindex="3"  name="district_l[]" autofocus data="area">
                     <option value="0" selected="selected" disabled="disabled" class="depsel">District</option>
                </select>
                                </td>
                                 <td>
                                 <input class="form-control area_change" type="text" name="area_l[]" placeholder="Area" value=""  readonly="readonly"/>                                   
                                </td>
                                <td>
                                     <select class="form-control localConvy" tabindex="3" required="required" name="bucket[]" autofocus >
                                        <option value="" selected="selected" disabled="disabled">Bucket</option>
                                        <option value="0">Secondary transportation </option>
                                        <option value="1">Local Conveyance</option>
                                     </select>
                                </td>
                                <td class="lclHide">
                                     <select class="form-control capacity_change cap" tabindex="3" required="required" name="cap[]" autofocus data="weight">
                                        <option value="0" selected="selected" disabled="disabled">Capacity</option>
                                         <?php $getCp=getCapacity();if($getCp!=0){foreach($getCp as $rec){echo "<option value='".$rec['product_alias']."'>".$rec['product_description']."</option>";}}else echo "<option disabled='disabled'>Add Capacity</option>";?> 
                                     </select>
                                </td>
                                <td class="lclHide"><input type="text" class="form-control wofCell weight_change ocap" name="wofCell[]" placeholder="Weight of the cell" readonly/></td>
                                <td class="lclHide"><input type="text" class="form-control qnty ocap" name="quantityCell[]" placeholder="Quantity" /></td>
                                <td class="lclHide"><input type="text" class="form-control numKilo ocap" name="numKilometers[]" placeholder="No.of Kilometers"/></td>
                                <td class="lclHide"><input type="text" class="form-control ocap wofCell appli_change" name="amtappli[]" placeholder="Amount" readonly/></td>
                                <td><input type="text" class="form-control  expense_dates cddl" name="dot_l[]" placeholder="DD-MM-YYYY" readonly/></td>
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
                                <td><input type="text" class="form-control amtt tamfor ttcm lc" name="amt_l[]" placeholder="Amount" readonly/></td>
                               <td>
                                    <select id="ticket_idl" class="form-control selectpicker" name="ticket_idl[]" data-live-search="true" placeholder="">
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                        <?php $getTid=getTicket($_SESSION['ec_user_alias']);
										 if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."'>".$rec['ticket_id']."</option>";}}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="dprNum_l[]" placeholder="DPR Number"/></td>
                            </tr>
                        </tbody>
                    </table>
                   </div> 
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
                        <thead><tr class="blue cust"><th>Zone</th><th>State</th><th>District</th><th>Visit: Start Date:</th>
                        <th>Visit: End Date:</th><th>Hotel Name</th><th>Amount</th><th>Ticket ID</th><th>DPR Number</th></tr></thead>
                        <?php if($lodging!=0){?>
                        <tbody>
                        <?php foreach($lodging as $lodging1){$tamtl+=$lodging1['amount'];?>
                        <tr class="tbform">                           	
                                <td><input type="hidden" name="idl[]" tabindex="0" value="<?php echo $lodging1['alias'];?>"/>
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
                                <td><input type="text" class="form-control expense_dates checkin cddl" tabindex="0" value="<?php echo date("d-m-Y", strtotime($lodging1['check_in'])); ?>" name="checkin[]" placeholder="DD-MM-YYYY"/></td>
                                <td><input type="text" class="form-control expense_dates checkout cddl" tabindex="0" value="<?php echo date("d-m-Y", strtotime($lodging1['check_out'])); ?>" name="checkout[]" placeholder="DD-MM-YYYY"/></td>
								<td class="changw"><input type="text" class="form-control" name="hotelName[]" tabindex="0" value="<?php echo $lodging1['hotel_name'];?>" placeholder="Hotel Name"/></td>
                                <td><input type="text" class="form-control amtt tamfor tlam selfamm ld" tabindex="0" name="lamt[]" value="<?php echo $lodging1['amount'];?>" placeholder="Amount"/></td>
                                 <td>
                                    <select id="ticket_idld" class="form-control selectpicker" name="ticket_idld[]" data-live-search="true" placeholder="">
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                        <?php $getTid=getTicket($_SESSION['ec_user_alias']);
										 if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."' ".checkSelected($rec['ticket_alias'],$lodging1['ticket_alias']).">".$rec['ticket_id']."</option>";}}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="dprNum_ld[]" placeholder="Dpr Number" value="<?php echo $conveyance1['dpr_number'];?>"/></td>
                            </tr>
                         <?php }?>
                        </tbody>
                        <?php }?>
                        <tbody id='fare1'>
                        <tr class="tbform">
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
                                <td><input type="text" class="form-control expense_dates checkin cddl" name="checkin[]" placeholder="DD-MM-YYYY" readonly/></td>
                                <td><input type="text" class="form-control expense_dates checkout cddl" name="checkout[]" placeholder="DD-MM-YYYY" readonly/></td>
                                <td class="changw"><input type="text" class="form-control" name="hotelName[]" placeholder="Hotel Name" value=""/></td>
                                <td><input type="text" class="form-control amtt tamfor tlam selfamm ld" name="lamt[]" placeholder="Amount" readonly/></td>
                                 <td>
                                    <select id="ticket_idld" class="form-control selectpicker" name="ticket_idld[]" data-live-search="true" placeholder="">
                                    	<option value="" selected="selected">Select Ticket ID</option>
                                        <?php $getTid=getTicket($_SESSION['ec_user_alias']);
										 if($getTid!=0){foreach($getTid as $rec){echo "<option value='".$rec['ticket_alias']."'>".$rec['ticket_id']."</option>";}}
										 else echo "<option disabled='disabled'>Add Ticket</option>";?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="dprNum_ld[]" placeholder="Dpr Number" value=""/></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-4 pull-right"><input type="text" class="form-control tlamt" placeholder="Total Lodging" readonly /></div>
                </div>
            </div>
        </div>
