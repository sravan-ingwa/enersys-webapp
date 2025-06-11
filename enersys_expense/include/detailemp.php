<script>listdetailsfun();</script>
<style>
.bs-callout div{padding-bottom:5px;}
h4 span {font-size:14px;color:#262626;}
</style>
<?php 
if($_REQUEST['id']) $_SESSION['id']=$_REQUEST['id']; 
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Details of: <?php echo employeeDetails('name',$_SESSION['id']);?></h3>
	</div>
	<div class="panel-body">
        <div class='row'>
	        <div class='col-md-12'>
    		    <div class='col-md-5 bs-callout'>
					<div>
                        <h4>Employee ID:  <span><?php echo employeeDetails('employee_id',$_SESSION['id']);?></span></h4>
        			</div>
					<div>
                        <h4>Employee Name: <span><?php echo employeeDetails('name',$_SESSION['id']);?></span></h4>
        			</div>
                </div>
    		    <div class='col-md-5 bs-callout'>
					<div>
                        <h4>Department:  <span><?php echo alias(employeeDetails('department_alias',$_SESSION['id']),'ec_department','department_alias','department_name');?></span></h4>
        			</div>
					<div>
                        <h4>Designation:  <span><?php echo alias(employeeDetails('designation_alias',$_SESSION['id']),'ec_designation','designation_alias','designation');?></span></h4>
        			</div>
					<div>
                        <h4>Grade:  <span><?php echo alias(employeeDetails('designation_alias',$_SESSION['id']),'ec_designation','designation_alias','grade');?></span></h4>
        			</div>
                </div>
                <div class="table-responsive col-md-12">
                    <form id="sortform" novalidate>
                        <input type="hidden" value="<?php echo $ref;?>" name="ref" />
                        <input type="hidden" value="<?php echo $_SESSION['id'];?>" name="id" />
                        <input type="hidden" value="all" name="pageNo" />
                        <table class="table table-bordered">
                        <thead>
                        <tr class="blue cust">
                            <th>Type of Request</th>
                            <th>Request ID/ Bill No</th>
                            <th>Requested Date</th>
                            <th>Requested Amount</th>
                            <th title="Available Amount">Avl. Amount</th>
                            <th>Approval Status</th>
                            <th>Options</th>
                        </tr>
                        <tr class="nmg">
                        <td><select name="reqtype"  onchange="listdetailsfun()"><option value=""></option><option value="0">Advance</option><option value="1">Expense</option></select></td>
                            <td><input type="text" placeholder="Search..." name="requestID" onkeyup="listdetailsfun()"></td>
                            <td><input type="text"  name="requestDate" class="datepicker_spl"></td>
                            <td><input type="text"  name="requestamt" onkeyup="listdetailsfun()"></td>
							<td></td>
                            <td><select name="reqStat"  onchange="listdetailsfun()"><option value=""></option>
                            <?php $listDgn=exlevels();if($listDgn!=0){foreach($listDgn as $rec){echo "<option value='".$rec['alias']."'>".$rec['name']."</option>";}}else echo "<option disabled='disabled'>Add Designation</option>";?>
                            </select></td>
                            <td><p class="sser"><i class="glyphicon glyphicon-search"></i></p></td>
                        </tr>
                        </thead>
                        <tbody id="getList">
                        </tbody>
                        </table>
                    </form>  
                </div>
        	</div>
        </div>
    </div>
<div>
