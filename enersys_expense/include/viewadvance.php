<script>listdetailsfun();</script>
<?php if(isset($message)) echo $message;?>
<div class="panel panel-primary" style="border:none !important;">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Advances Details</h3>
	</div>
	<div class="table-responsive">
<form id="sortform" novalidate>
<input type="hidden" value="<?php echo $ref;?>" name="ref" />
<input type="hidden" value="all" name="pageNo" />
    	<table class="table table-bordered">
        	<thead>
            	<tr class="blue cust">
                	<th>Request ID</th>
                	<?php if(checkApproval($_SESSION['ec_user_alias'])==1 || checkspldep($_SESSION['ec_user_alias'])==1 || checkspldep($_SESSION['ec_user_alias'])==2)echo "<th>Request By</th>";?>
                    <th>Requested Date</th>
                	<th>Requested Amount</th>
                    <th>Approval Status</th>
                	<th>Options</th>
            	</tr>
            	<tr class="nmg">
                	<td><input type="text" placeholder="Search..." name="requestID" onkeyup="listdetailsfun()"></td>
                	<?php if(checkApproval($_SESSION['ec_user_alias'])==1 || checkspldep($_SESSION['ec_user_alias'])==1 || checkspldep($_SESSION['ec_user_alias'])==2)echo "<td><input type='text' placeholder='' name='empname' onkeyup='listdetailsfun()'></td>";?>
                    <td><input type="text"  name="requestDate" class="datepicker_spl"></td>
                	<td><input type="text"  name="requestamt" onkeyup="listdetailsfun()"></td>
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
<div>
