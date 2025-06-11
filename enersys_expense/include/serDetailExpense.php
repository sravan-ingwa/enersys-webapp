<style>.bs-callout div{padding-bottom:5px;} h4 span {font-size:14px;color:#262626;}
.panel-default > .panlbakg{background-color:#2a6496; border:2px solid #2a6496; color:#fff;}
</style>
<?php 
if($_REQUEST['id']) $_SESSION['id']=$_REQUEST['id']; 
$resultz=expensefullView($_SESSION['id']);
$expList=expensefullView($_SESSION['id']);
$conveyance=ec_conveyance($expList[0]['expenses_alias']);
$lconveyance=ec_localconveyance($expList[0]['expenses_alias']);
$lodging=ec_lodging($expList[0]['expenses_alias']);
$boarding=ec_boarding($expList[0]['expenses_alias']);
$other_expenses=ec_other_expenses($expList[0]['expenses_alias']);
$remarks=getRemarks($resultz[0]['expenses_alias'],'BE');
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Details of Bill No: <?php echo $resultz[0]['bill_number'];?></h3>
	</div>
	<div class="panel-body">
        <div class='row'>
	        <div class='col-md-12'>
    		    <div class='col-md-5 bs-callout'>
					<div>
                        <h4>Bill Number: <span><?php echo $resultz[0]['bill_number'];?></span></h4>
        			</div>
					<div>
                        <h4>Date of Request: <span><?php echo $resultz[0]['requested_date'];?></span></h4>
        			</div>
					<div>
                        <h4>Employee Name: <span><?php echo employeeDetails('name',$resultz[0]['employee_alias']);?></span></h4>
        			</div>
					<div>
                        <h4>Period Of Visit From: <span><?php echo $resultz[0]['period_of_visit_from'];?></span></h4>
        			</div>
					<div>
                        <h4>Places Of Visit: <span> <?php echo $resultz[0]['places_of_visit'];?></span></h4>
        			</div>
                </div>

    		    <div class='col-md-5 bs-callout'>
					<div>
                        <h4>PO /GR Number:  <span><?php echo $resultz[0]['po_gnr'];?></span></h4>
        			</div>
					<div>
                        <h4>Employee ID:  <span><?php echo employeeDetails('employee_id',$resultz[0]['employee_alias']);?></span></h4>
        			</div>
					<div>
                        <h4>Grade:  <span><?php echo alias(employeeDetails('designation_alias',$resultz[0]['employee_alias']),'ec_designation','designation_alias','grade');?></span></h4>
        			</div>
					<div>
                        <h4>Period Of Visit To:  <span><?php echo $resultz[0]['period_of_visit_to'];?></span></h4>
        			</div>
					<div>
                        <h4>Purpose:  <span><?php echo $resultz[0]['purpose'];?></span></h4>
        			</div>
                </div>
              <!--  <div class='col-md-5 bs-callout'>
                    <h4>Tour Report</h4>
                    <p><?php if($resultz[0]['report']!=='0' && $resultz[0]['report']!==''){?><a href="<?php echo $resultz[0]['report'];?>" target="_blank" class="pdfil">Click Here</a><?php }else echo "-";?></p>
                </div>-->
                <div class='col-md-5 bs-callout'>
                	<h4>UTR Number</h4>
                    <p><?php if($resultz[0]['utr_num']!=='0' && $resultz[0]['utr_num']!==''){?><?php echo $resultz[0]['utr_num'];}?></p>
                    <p></p>
                </div>
                <?php if($lconveyance!=0){?>
                <div class="col-lg-12 form-group">
            <label>Local Conveyance : </label>
            <div class="clearfix" id='fare11'>
            <div class="localConv">
            <?php if($lconveyance!=0){$c=1;foreach($lconveyance as $conveyance1){$tamt121+=$conveyance1['amount'];?>
                   <div id="localConv_1" class="panel panel-default tbformm" >
                    	<div class="panel-heading panlbakg">
                        	<h3 class="panel-title">Local Conveyance <?php echo $c;?></h3>
                   		 </div>
                   		<div class="panel-body">
                    	<div class="row">
                        <?php if($conveyance1['bucket'] != ''){?>
                             <div class="col-md-3">
                                <p><label>Zone : </label>
                                <?php echo getNames($conveyance1['zone_alias'],'ec_zone');?></p>
                            </div>
                            <div class="col-md-3">
                                <p title="<?php echo getNames($conveyance1['state_alias'],'ec_state');?>"><label>State : </label>
                                <?php echo strlen(getNames($conveyance1['state_alias'],'ec_state')) >= 25 ? substr(getNames($conveyance1['state_alias'],'ec_state'), 0, 23) . '..' : getNames($conveyance1['state_alias'],'ec_state');?></p>
                            </div>
                            <div class="col-md-3">
                                <p><label>District : </label>
                               <?php echo getNames($conveyance1['district_alias'],'ec_district');?></p>
                            </div>
                            <div class="col-md-3">
                                <p><label>Area : </label>
                                <?php if(getArea($conveyance1['district_alias'])==0){echo 'Plain Area'; $amount_appli = 0.02;}else if(getArea($conveyance1['district_alias'])==1){echo 'Hilly area'; $amount_appli = 0.04;}?><p>
                            </div>
                            <div class="col-md-3">
                                <p><label>Bucket : </label>
                                 <?php if($conveyance1['bucket'] ==0)echo 'Secondary transportation';else if($conveyance1['bucket'] ==1) echo 'Local Conveyance';?></p>
                            </div>
                            <?php if($conveyance1['bucket'] ==0) { ?>
                             <div class="col-md-3">
                                <p><label class="cap">Capacity : </label>   
                                <?php if(getWeights($conveyance1['capacity'],'product') != 0) echo getWeights($conveyance1['capacity'],'product'); else echo '';?></p>
                            </div>
                            <div class="col-md-3">
                                <p><label class="ocap">Weight of the cell : </label>   
                                <?php if(getWeights($conveyance1['capacity'],'weight')!= 0) echo getWeights($conveyance1['capacity'],'weight'); else echo '';?></p>
                            </div>
                            <div class="col-md-3">
                                <p><label class="ocap">Quantity : </label>   
                               <?php if($conveyance1['quantity']!=0)echo $conveyance1['quantity']; else echo '';?></p>
                            </div>
                            <div class="col-md-3">
                                <p><label class="ocap">No.of Kilometers : </label>   
                               <?php if($conveyance1['km']!=0)echo $conveyance1['km']; else echo '';?></p>
                            </div>
                            <div class="col-md-3">
                               <p><label class="ocap">Amount Appilicable : </label>   
                                <?php echo $amount_appli;?></p>
                            </div>
                            <?php }?>
                            <?php } ?>
                             <div class="col-md-3">
                                <p><label>Date of Travel : </label>   
                               <?php echo date("d-m-Y", strtotime($conveyance1['date_of_travel'])); ?></p>
                            </div>
                            <div class="col-md-3">
                                <p><label>Mode of travel : </label>   
                               <?php echo $conveyance1['mode_of_travel'];?></p>
                            </div>
                            <div class="col-md-3">
                                <p><label>From : </label>  
                                <?php echo $conveyance1['from_place'];?></p>
                            </div>
                            <div class="col-md-3">
                                <p><label>To : </label>  
                                <?php echo $conveyance1['to_place'];?></p>
                            </div>
                           
                            <?php if($conveyance1['bucket'] != ''){?>
                            <div class="col-md-3">
                                <p><label>Ticket ID : </label>  
                                <?php if($conveyance1['ticket_alias'] == "1") echo "Others"; else echo getTicketName($conveyance1['ticket_alias']);?></p>
                            </div>
                            <div class="col-md-3">
                                <p><label>DPR Number : </label>  
                                <?php echo $conveyance1['dpr_number'];?></p>
                            </div>
                            <?php }?>
                             <div class="col-md-3">
                                <p><label>Amount : </label>  
                                <?php echo $conveyance1['amount'];?></p>
                            </div>
                        </div>
                    </div>
                    </div>
                    <?php $c++;}}else echo "<div>No Records</div>";?>
                </div>
                <div class="col-md-4 pull-right"><p align="right"> Total: <?php if($tamt121!=0) echo $tamt121;?></p></div>
           </div>
        </div>

                
                <?php }?>

                
				<?php if($conveyance!=0){?>
                <div class="col-lg-12 form-group">
                    <label>Conveyance : </label>
                    <div class="clearfix">
                        <div class="column">
						<div style="max-width:1032px; overflow:auto;">
                            <table class="table table-bordered" id="fare_tab" style="width:1032px !important;">
                                <thead><tr class="blue cust"><th>Date of travel</th><th>Mode of travel</th><th>From</th><th>To</th><th>Ticket ID</th><th>DPR Number</th><th>Files</th><th>Amount</th></tr></thead>
                                <tbody id='fare0'>
                                <?php foreach($conveyance as $conveyance1){$tamt+=$conveyance1['amount'];?>
                                    <tr class="tbform">
                                        <td><p><?php echo date("d-m-Y", strtotime($conveyance1['date_of_travel'])); ?></p></td>
                                        <td><p><?php echo $conveyance1['mode_of_travel'];?></p></td>
                                        <td><p><?php echo $conveyance1['from_place'];?></p></td>
                                        <td><p><?php echo $conveyance1['to_place'];?></p></td>
                                        
                                            <td>
											<?php if($conveyance1['ticket_alias'] != '') { if($conveyance1['ticket_alias'] == "1") echo "Others"; else {echo "<p>".getTicketName($conveyance1['ticket_alias'])."</p>";}}else echo '<p align="center">--</p>'?>
                                           </td>
                                            <td><?php if($conveyance1['dpr_number'] != '') echo "<p>".$conveyance1['dpr_number']."</p>";else echo '<p align="center">--</p>'?></td>
                                       
                                        <td><?php if($conveyance1['document_link']!=='0'){?><a href="<?php echo $conveyance1['document_link'];?>" target="_blank" class="pdfil col-md-2" align='center'>Click</a><?php }else echo "<p class='col-md-12' align='center'>-NA-</p>";?></td>
                                    <td><p><?php echo $conveyance1['amount'];?></p></td>
                                    </tr>
                                     <?php }?>
                                </tbody>
                            </table>
                            <div class="col-md-4 pull-right"><p align="right"> Total: <?php if($tamt!=0) echo $tamt;?></p></div>
                        </div>
						</div>
                    </div>
                </div>
                <?php }?>
                <?php if($lodging!=0){?>
                <div class="col-lg-12 form-group">
                    <label>Lodging : </label>
                    <div class="clearfix">
                        <div class="column">
						<div style="max-width:1032px; overflow:auto;">
                            <table class="table table-bordered" id="fare_tab" style="width:1032px !important;">
                                <thead><tr class="blue cust"><th>Zone</th>
                                <th>State</th>
                                <th>District</th>
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>Hotel Name</th>
                                
                                <th>Ticket ID</th>
                                <th>DPR Number</th>
                                <th>Amount</th></tr></thead>
                                <tbody id='fare1'>
                                <?php foreach($lodging as $lodging1){$tamtl+=$lodging1['amount'];?>
                                    <tr class="tbform">
                                     <td><?php if($lodging1['zone_alias'] != '') echo "<p>".getNames($lodging1['zone_alias'],'ec_zone')."</p>";else echo '<p align="center">--</p>'?>
                                           </td>
                                            <td><?php if($lodging1['state_alias'] != '') echo "<p>".getNames($lodging1['state_alias'],'ec_state')."</p>";else echo '<p align="center">--</p>'?>
                                           </td>
                                            <td>
                                            <?php if($lodging1['district_alias'] != '') echo "<p>".getNames($lodging1['district_alias'],'ec_district')."</p>";else echo '<p align="center">--</p>'?>
                                           </td>
                                        <td><p><?php echo date("d-m-Y", strtotime($lodging1['check_in']));?></p></td>
                                        <td><p><?php echo date("d-m-Y", strtotime($lodging1['check_out']));?></p></td>
                                        <td><p><?php echo $lodging1['hotel_name'];?></p></td>
                                                                           
                                            <td>
											<?php if($lodging1['ticket_alias'] != '') { if($lodging1['ticket_alias'] == "1") echo "Others"; else {echo "<p>".getTicketName($lodging1['ticket_alias'])."</p>";}}else echo '<p align="center">--</p>'?>
                                           </td>
                                            <td><?php if($lodging1['dpr_number'] != '') echo "<p>".$lodging1['dpr_number']."</p>";else echo '<p align="center">--</p>'?></td>
                                     <td><p><?php echo $lodging1['amount'];?></p></td>    
                                    </tr>
                                 <?php }?>
                                </tbody>
                            </table>
                            <div class="col-md-4 pull-right"><p align="right">Total: <?php if($tamtl!=0) echo $tamtl;?></p></div>
                        </div>
						</div>
                    </div>
                </div>
				<?php }?>
                <?php if($boarding!=0){?>
                    <div class="col-lg-12 form-group">
                        <label>Boarding : </label>
                        <div class="clearfix">
                            <div class="column">
							<div style="max-width:1032px; overflow:auto;">
                                <table class="table table-bordered" id="fare_tab" style="width:1032px !important;">
                                    <thead><tr class="blue cust"><th>Zone</th><th>State</th><th>District</th><th>From Date</th><th>To Date</th><th>Ticket ID</th><th>DPR Number</th><th>Amount</th></tr></thead>
                                    <tbody id='fare'>
                                        <?php foreach($boarding as $boarding1){$bamtl+=$boarding1['amount'];?>
                                        <tr class="tbform">
                                            <td><?php if($boarding1['zone_alias'] != '') echo "<p>".getNames($boarding1['zone_alias'],'ec_zone')."</p>";else echo '<p align="center">--</p>'?>
                                           </td>
                                            <td><?php if($boarding1['state_alias'] != '') echo "<p>".getNames($boarding1['state_alias'],'ec_state')."</p>";else echo '<p align="center">--</p>'?>
                                           </td>
                                            <td>
                                            <?php if($boarding1['district_alias'] != '') echo "<p>".getNames($boarding1['district_alias'],'ec_district')."</p>";else echo '<p align="center">--</p>'?>
                                           </td>
                                            <td><p><?php echo date("d-m-Y", strtotime($boarding1['check_in']));?></p></td>
                                            <td><p><?php echo date("d-m-Y", strtotime($boarding1['check_out']));?></p></td>
                                           
                                            <td>
											<?php if($boarding1['ticket_alias'] != '') { if($boarding1['ticket_alias'] == "1") echo "Others"; else {echo "<p>".getTicketName($boarding1['ticket_alias'])."</p>";}}else echo '<p align="center">--</p>'?>
                                           </td>
                                            <td><?php if($boarding1['dpr_number'] != '') echo "<p>".$boarding1['dpr_number']."</p>";else echo '<p align="center">--</p>'?></td>
                                         <td><p><?php echo $boarding1['amount'];?></p></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                                <div class="col-md-4 pull-right"><p align="right">Total: <?php if($bamtl!=0) echo $bamtl;?></p></div>
                            </div>
							</div>
                        </div>
                    </div>
                    <?php } ?>
                  <?php if($other_expenses!=0){?>
                <div class="col-lg-12 form-group">
                    <label>Others : </label>
                    <div class="clearfix">
                        <div class="column">
						<div style="max-width:1032px; overflow:auto;">
                            <table class="table table-bordered" id="fare_tab" style="width:1032px !important;">
                                <thead><tr class="blue cust"><th>Description</th><th>Date</th><th>Files</th><th>Ticket ID</th><th>DPR Number</th><th>Amount</th></tr></thead>
                                <tbody id='fare2'>
                                <?php foreach($other_expenses as $other_expenses1){$tamte+=$other_expenses1['amount'];?>
                                    <tr class="tbform">
                                        <td><p><?php echo $other_expenses1['description'];?></p></td>
                                        
                                        <td><p><?php echo date("d-m-Y", strtotime($other_expenses1['checked_date'])); ?></p></td>
                                        <td><?php if($other_expenses1['document_link']!=='0'){?><a href="<?php echo $other_expenses1['document_link'];?>" target="_blank" class="pdfil col-md-2">Click</a><?php }else echo "<p class='col-md-12' align='center'>-NA-</p>";?></td>
                                            <td>
											<?php if($other_expenses1['ticket_alias'] != '') { if($other_expenses1['ticket_alias'] == "1") echo "Others"; else {echo "<p>".getTicketName($other_expenses1['ticket_alias'])."</p>";}}else echo '<p align="center">--</p>'?>
                                           </td>
                                            <td><?php if($other_expenses1['dpr_number'] != '') echo "<p>".$other_expenses1['dpr_number']."</p>";else echo '<p align="center">--</p>'?></td>
                                   <td><p><?php echo $other_expenses1['amount'];?></p></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                            <div class="col-md-4 pull-right"><p align="right">Total: <?php if($tamte!=0) echo $tamte;?></p></div>
                        </div>
						</div>
                    </div>
                </div>
				<?php }?>
                <div class="col-md-2 bs-callout">
                    <h4>Outstanding Amt</h4>
                    <p><?php if (advanceNotSettled($expList[0]['employee_alias'])!=0)echo advanceNotSettled($expList[0]['employee_alias']); else echo "No pending Advances";?></p>
                </div>
                <div class="col-md-2 bs-callout">
                    <h4>Booked Expenses</h4>
                    <p><?php echo round($expList[0]['total_tour_expenses']);?></p>
                </div>
                <div class="col-md-2 bs-callout">
                    <h4>Reimbursement</h4>
                    <p><?php echo round($expList[0]['reimbursement_amount']);?></p>
                </div>
                <div class="col-md-2 bs-callout">
                    <h4>Final Amount</h4>
                    <p><?php echo ( (round($expList[0]['total_tour_expenses'])-advanceNotSettled($expList[0]['employee_alias'])));?><p/>
                </div>
                <?php if($remarks!=0){?>
                    <div class='col-md-11 bs-callout'>
                     <?php foreach($remarks as $remk){?>
                        <div class="col-md-6 form-group">
                            <h4>Remarks: <small>(By <?php echo employeeDetails('name',$remk['remarked_by']);?>, On: <?php echo date("d-M-Y", strtotime($remk['remarked_on']));?>)</small></h4>
                            <p ><?php echo $remk['remarks'];?></p>
                        </div>
                         <?php }?>
                    </div>
                     <?php }?>
        	</div>
        </div>
    </div>
<div>
