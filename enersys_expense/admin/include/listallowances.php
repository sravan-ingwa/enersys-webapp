<script>listdetailsfun();</script>
<div class="panel panel-primary" style="border:none !important;">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Allowances Details</h3>
	</div>
	<div class="table-responsive">
<form id="sortform" novalidate>
<input type="hidden" value="<?php echo $ref;?>" name="ref" />
    	<table class="table table-bordered">
        	<thead>
            	<tr class="blue cust">
                	<th>Grade</th>
                	<th colspan="4">Lodging Allowances</th>
                	<th colspan="4">Daily/Boarding Allowances</th>
                	<th>Mode of Travel</th>
                    <th>Mode of Local Conveyance</th>
                    <th>Mobile Roaming</th>
                    <th>Options</th>
            	</tr>
            	<tr class="cust">
                	<th>&nbsp;</th>
                	<th>A+</th>
                	<th>A</th>
                	<th>B</th>
                	<th>C</th>
                	<th>A+</th>
                	<th>A</th>
                	<th>B</th>
                	<th>C</th>
                	<th></th>
                	<th></th>
                	<th>in Rs.</th>
                	<th></th>
            	</tr>
        	</thead>
        	<tbody id="getList"></tbody>
    </table>
</form>  
</div>
<div>
