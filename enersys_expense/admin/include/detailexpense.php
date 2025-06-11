<style>
.bs-callout div{padding-bottom:5px;}
h4 span {font-size:14px;color:#262626;}
</style>
<?php 
if($_REQUEST['id']) $_SESSION['id']=$_REQUEST['id']; 
$resultz=expensefullView($_SESSION['id']);
$expList=expensefullView($_SESSION['id']);
$conveyance=ec_conveyance($expList[0]['expenses_alias']);
$lconveyance=ec_localconveyance($expList[0]['expenses_alias']);
$lodging=ec_lodging($expList[0]['expenses_alias']);
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
                        <h4>Places Of Visit: <span><?php echo $resultz[0]['places_of_visit'];?></span></h4>
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
				<?php if($conveyance!=0){?>
                <div class="col-lg-12 form-group">
                    <label>Conveyance : </label>
                    <div class="clearfix">
                        <div class="column">
                            <table class="table table-bordered" id="fare_tab">
                                <thead><tr class="blue cust"><th>Date of travel</th><th>Mode of travel</th><th>From</th><th>To</th><th>Amount</th><th>Files</th></tr></thead>
                                <tbody id='fare0'>
                                <?php foreach($conveyance as $conveyance1){$tamt+=$conveyance1['amount'];?>
                                    
                                    <tr class="tbform">
                                        <td><p><?php echo date("d-m-Y", strtotime($conveyance1['date_of_travel'])); ?></p></td>
                                        <td><p><?php echo $conveyance1['mode_of_travel'];?></p></td>
                                        <td><p><?php echo $conveyance1['from_place'];?></p></td>
                                        <td><p><?php echo $conveyance1['to_place'];?></p></td>
                                        <td><p><?php echo $conveyance1['amount'];?></p></td>
                                        <td><?php if($conveyance1['document_link']!=='0'){?><a href="<?php echo "../".$conveyance1['document_link'];?>" target="_blank" class="pdfil col-md-2" align='center'>Click</a><?php }else echo "<p class='col-md-12' align='center'>-NA-</p>";?></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                            <div class="col-md-4 pull-right"><p align="right"> Total: <?php if($tamt!=0) echo $tamt;?></p></div>
                        </div>
                    </div>
                </div>
                <?php }?>
				<?php if($lconveyance!=0){?>
                <div class="col-lg-12 form-group">
                    <label>Local Conveyance : </label>
                    <div class="clearfix">
                        <div class="column">
                            <table class="table table-bordered" id="fare_tab">
                                <thead><tr class="blue cust"><th>Date of travel</th><th>Mode of travel</th><th>From</th><th>To</th><th>Amount</th></tr></thead>
                                <tbody id='fare0'>
                                <?php foreach($lconveyance as $conveyance1){$tamtll+=$conveyance1['amount'];?>
                                    
                                    <tr class="tbform">
                                        <td><p><?php echo date("d-m-Y", strtotime($conveyance1['date_of_travel'])); ?></p></td>
                                        <td><p><?php echo $conveyance1['mode_of_travel'];?></p></td>
                                        <td><p><?php echo $conveyance1['from_place'];?></p></td>
                                        <td><p><?php echo $conveyance1['to_place'];?></p></td>
                                        <td><p><?php echo $conveyance1['amount'];?></p></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                            <div class="col-md-4 pull-right"><p align="right"> Total: <?php if($tamtll!=0) echo $tamtll;?></p></div>
                        </div>
                    </div>
                </div>
                <?php }?>
				<?php if($lodging!=0){?>
                <div class="col-lg-12 form-group">
                    <label>Lodging : </label>
                    <div class="clearfix">
                        <div class="column">
                            <table class="table table-bordered" id="fare_tab">
                                <thead><tr class="blue cust"><th>Type of Stay</th><th>From Date</th><th>To Date</th><th>Hotel Name</th><th>Amount</th><th>Files</th></tr></thead>
                                <tbody id='fare1'>
                                    <?php foreach($lodging as $lodging1){$tamtl+=$lodging1['amount'];?>
                                    
                                    <tr class="tbform">
                                        <td><p><?php echo $lodging1['type_of_stay']?></p></td>
                                        <td><p><?php echo date("d-m-Y", strtotime($lodging1['check_in']));?></p></td>
                                        <td><p><?php echo date("d-m-Y", strtotime($lodging1['check_out']));?></p></td>
                                        <td><p><?php echo $lodging1['hotel_name'];?></p></td>
                                        <td><p><?php echo $lodging1['amount'];?></p></td>
                                        <td><?php if($lodging1['document_link']!=='0'){?><a href="<?php echo "../".$lodging1['document_link'];?>" target="_blank" class="pdfil col-md-2">Click</a><?php }else echo "<p class='col-md-12' align='center'>-NA-</p>";?></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                            <div class="col-md-4 pull-right"><p align="right">Total: <?php if($tamtl!=0) echo $tamtl;?></p></div>
                        </div>
                    </div>
                </div>
				<?php }?>	
				<?php if($other_expenses!=0){?>
                <div class="col-lg-12 form-group">
                    <label>Others : </label>
                    <div class="clearfix">
                        <div class="column">
                            <table class="table table-bordered" id="fare_tab">
                                <thead><tr class="blue cust"><th>Description</th><th>Amount</th><th>Date</th><th>Files</th></tr></thead>
                                <tbody id='fare2'>
                                    <?php foreach($other_expenses as $other_expenses1){$tamte+=$other_expenses1['amount'];?>
                                    <tr class="tbform">
                                        <td><p><?php echo $other_expenses1['description'];?></p></td>
                                        <td><p><?php echo $other_expenses1['amount'];?></p></td>
                                        <td><p><?php echo date("d-m-Y", strtotime($other_expenses1['checked_date'])); ?></p></td>
                                        <td><?php if($other_expenses1['document_link']!=='0'){?><a href="<?php echo "../".$other_expenses1['document_link'];?>" target="_blank" class="pdfil col-md-2">Click</a><?php }else echo "<p class='col-md-12' align='center'>-NA-</p>";?></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                            <div class="col-md-4 pull-right"><p align="right">Total: <?php if($tamte!=0) echo $tamte;?></p></div>
                        </div>
                    </div>
                </div>
				<?php }?>
                <div class="col-md-3 bs-callout">
                    <h4>Outstanding Balance</h4>
                    <p><?php if (advanceNotSettled($expList[0]['employee_alias'])!=0)echo advanceNotSettled($expList[0]['employee_alias']); else echo "No pending Advances";?></p>
                </div>
                <div class="col-md-3 bs-callout">
                    <h4>Total Expenses</h4>
                    <p><?php echo $expList[0]['total_tour_expenses'];?></p>
                </div>
                <div class="col-md-3 bs-callout">
                    <h4>Final Amount</h4>
                    <p><?php echo ($expList[0]['total_tour_expenses']-advanceNotSettled($expList[0]['employee_alias']));?><p/>
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
