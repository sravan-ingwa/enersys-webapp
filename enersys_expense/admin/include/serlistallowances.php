<script>serlistdetailsfun();</script>
<div class="panel panel-primary" style="border:none !important;">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">ALLOWANCES DETAILS</h3>
	</div>
	<div class="table-responsive">
    <form id="sortform" novalidate>
    	<input type="hidden" value="<?php echo $ref;?>" name="ref" />
    	<input type="hidden" value="all" name="pageNo" />
        <table class="table table-bordered">
            <thead>
                <tr class="blue cust">
                    <th>Sr.No</th>
                    <th>Zone</th>
                    <th>State</th>
                    <th>District</th>
                    <th>Area</th>
                    <th>Lodging Amount</th>
                    <th>Daily Allowance</th>
                    <th>Local Conveyance</th>
                    <th>Options</th>
                </tr>
                <tr class="nmg">
                	<td></td>
                    <td>
                    <select name="zone" onchange="ajaxSelect(this.options[this.selectedIndex].value,'state'),serlistdetailsfun();">
                <option value=""></option>
                    <?php $getZn=getZones();if($getZn!=0){foreach($getZn as $rec){echo "<option value='".$rec['zone_alias']."' ".selectedcheck($rec['zone_alias'],$getDetails[0]['zone_alias']).">".$rec['zone_name']."</option>";}}else echo "<option disabled='disabled'>Add Zone</option>";?>
                </select> </td>
                    <td>	 <select class="form-control showgradedesg" tabindex="2"  required="required" name="state" autofocus="autofocus" id="ajaxSelect_state" onchange="ajaxSelect(this.options[this.selectedIndex].value,'district'),serlistdetailsfun();">
                    <option value=""></option>
                </select></td>
                
                    <td><select class="form-control showgradedesg" tabindex="3"  name="district" autofocus="autofocus" id="ajaxSelect_district" onchange="serlistdetailsfun();">
                    <option value=""></option>
                </select></td>
                
                    <td><select name="area"  onchange="serlistdetailsfun()"><option value=""></option>
                    <option value="0">Plain Area</option><option value="1">Hilly Area</option></select></td>
                    <td><input type="text"  name="ldgAmnt" onkeyup="serlistdetailsfun()"></td>
                    <td><input type="text"  name="dailyallow" onkeyup="serlistdetailsfun()"></td>
                    <td><input type="text"  name="lclconv" onkeyup="serlistdetailsfun()"></td>
                    <td><p class="sser"><i class="glyphicon glyphicon-search"></i></p></td>
                </tr>
            </thead>
            <tbody id="getList"></tbody>
        </table>
    </form>  
</div>
<div>
<script type="text/javascript">
	$(document).on('keyup','.tamfor',function (event){ 
		var tlomt=ttcm=0;
		$(".ldgam").each(function(){ldgamt+=Number($(this).val());});
		$(".dailam").each(function(){dailamt+=Number($(this).val());});
		$(".localam").each(function(){localamt+=Number($(this).val());});
	});
</script>
<script type="text/javascript">
    function ajaxSelect(id, type) {
        if(id != ""){
                $.ajax({
                    type: "POST",
                    url: "ajaxSelect.php",
                    data: 'type=' + type + '&id=' + id+ '&flag=list',
                    cache: false,
                    success: function(result) {						
						if(type == "state" || type == "district"){
							$("#ajaxSelect_" + type).html(result);	
						}
						if (type == "Area") {							
							if(result == 0){
								var disp = 'Plain area';
								$('#ajaxSelect_Area').val(disp);
							}else if(result == 1){
								var disp = 'Hilly area';
								$('#ajaxSelect_Area').val(disp);
							}
						}
                    }
                });
        }
        if (type == "state") {
            $("#ajaxSelect_state").html("<option value='0' disabled ></option>");
            $("#ajaxSelect_district").html("<option value='0' disabled ></option>");
			$('#ajaxSelect_Area').val("");
        }
		if (type == "district") {
			$('#ajaxSelect_Area').val("");
        }
    }
    </script>
<?php
function selectedcheck($fv1,$fv2){if($fv1===$fv2) return " selected=\"selected\" "; }
?>
