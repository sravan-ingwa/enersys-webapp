<script>listdetailsfun();</script>
<style>
.multiselect{min-width:200px;border:none !important;}
.multiselect:hover{background:none !important;}
</style>
<div class="panel panel-primary" <?php if(checkApproval($_SESSION['ec_user_alias'])==1){?>style="border:none !important;"<?php }?> >
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Dashboard</h3>
	</div>
	<div class="table-responsive">
        <form id="sortform" novalidate>
        <input type="hidden" value="<?php echo $ref;?>" name="ref" />
        <input type="hidden" value="all" name="pageNo" />
		<?php if(checkApproval($_SESSION['ec_user_alias'])==1){?>
                <table class="table table-bordered">
                    <thead>
                        <tr class="blue cust">
                            <th>Employee ID</th>
                            <th>Employee Name</th>
                            <th>Department</th>
                            <th>Total Advances</th>
                            <th>Total Expenses</th>
                            <th>Available Balance</th>
                            <th>Options</th>
                        </tr>
                        <tr class="nmg">
                            <td><input type="text" placeholder="Search..." name="emp_id" onkeyup="listdetailsfun()"></td>
                            <td><input type="text"  name="emp_name" onkeyup="listdetailsfun()"></td>
                            <td>
                                <select name="dep"  onchange="listdetailsfun()">
                                    <option value=""></option>
                                    <?php
										if(approvelLevelCheck($_SESSION['ec_user_alias'],1)=='1'){echo "<option disabled='disabled'>[No Permission]</option>";}
										if(approvelLevelCheck($_SESSION['ec_user_alias'],2)=='1'){$listDgn=listdip();if($listDgn!=0){foreach($listDgn as $rec){echo "<option value='".$rec['alias']."'>".$rec['name']."</option>";}}else echo "<option disabled='disabled'>Add Department</option>";}
										if(approvelLevelCheck($_SESSION['ec_user_alias'],3)=='1'){$listDgn=listdip();if($listDgn!=0){foreach($listDgn as $rec){echo "<option value='".$rec['alias']."'>".$rec['name']."</option>";}}else echo "<option disabled='disabled'>Add Department</option>";}
										if(approvelLevelCheck($_SESSION['ec_user_alias'],4)=='1'){}
										if(approvelLevelCheck($_SESSION['ec_user_alias'],5)=='1'){$listDgn=listdip();if($listDgn!=0){foreach($listDgn as $rec){echo "<option value='".$rec['alias']."'>".$rec['name']."</option>";}}else echo "<option disabled='disabled'>Add Department</option>";}
										if(approvelLevelCheck($_SESSION['ec_user_alias'],0)=='0'){echo "<option disabled='disabled'>[No Permission]</option>";}
                                     ?>
                                </select>
                            </td>
                            <td><input type="text"  name="toal_advances" onkeyup="listdetailsfun()"></td>
                            <td><input type="text"  name="total_expenses" onkeyup="listdetailsfun()"></td>
                            <td><input type="text"  name="avl_balance" onkeyup="listdetailsfun()"></td>
                            <td><p class="sser"><i class="glyphicon glyphicon-search"></i></p></td>
                        </tr>
                    </thead>
                    <tbody id="getList"></tbody>
            </table>
		<?php }else{?>
			<div id="getList" class="panel-body"></div>
		<?php }?>
        </form>
</div>
<div>
<script type="text/javascript">
	$(document).ready(function() {
		window.prettyPrint() && prettyPrint();
		$('#mot').multiselect({includeSelectAllOption: true,height:'150px'});
	});
</script>