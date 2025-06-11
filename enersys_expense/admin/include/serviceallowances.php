<?php 
date_default_timezone_set("Asia/Kolkata");
if(isset($_REQUEST['lodging_amount'])){
	if(!isset($_REQUEST['zone'])&&$_REQUEST['zone']==0){
		$mess="<p class='alert alert-danger' role='alert'>Select Zone</p>";;
		}else if(!isset($_REQUEST['state'])&&$_REQUEST['state']==0){$mess="<p class='alert alert-danger' role='alert'>Select State</p>";}
		else if(!isset($_REQUEST['district'])&&$_REQUEST['district']==0){$mess="<p class='alert alert-danger' role='alert'>Select District</p>";}
		else if($_REQUEST['lodging_amount']==""){$mess="<p class='alert alert-danger' role='alert'>Enter Lodging Amount</p>";}
		else if($_REQUEST['daily_allowance']==""){$mess="<p class='alert alert-danger' role='alert'>Enter Daily Allowance</p>";}
		else if($_REQUEST['local_conveyance']==""){$mess="<p class='alert alert-danger' role='alert'>Enter Local Conveyance</p>";}
	else{
		$date=date("Y-m-d");
		$zone=$_REQUEST['zone'];
		$state=$_REQUEST['state'];
		$dsitrict=$_REQUEST['district'];
		$ck_sql = mysqli_query($mr_con,"SELECT id FROM ec_service_allowances WHERE zone_alias = '".$zone."' AND state_alias = '".$state."' AND district_alias = '".$dsitrict."'");
		$scnt = mysqli_num_rows($ck_sql);
		if($scnt == 0) {
			$lodging_amt=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['lodging_amount']));
			$daily_allowance=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['daily_allowance']));
			$local_conveyance=strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['local_conveyance']));
			$alias=aliasCheck(generateRandomString(),"ec_service_allowances","service_allowance_alias",$mr_con);
				$sql = "INSERT INTO ec_service_allowances (zone_alias, state_alias, district_alias, lodging_amount, daily_allowance, local_conveyance, service_allowance_alias, created_date) VALUES ('".$zone."','".$state."','".$dsitrict."','".$lodging_amt."','".$daily_allowance."','".$local_conveyance."','".$alias."','".$date."')";
				if($mr_con->query($sql)===TRUE) $mess="<p class='alert alert-success' role='alert'>New record created successfully</p>"; else $mess="<p class='alert alert-danger' role='alert'>Error: Try Again</p>";
			$mr_con->close();
		}else{
			$mess="<p class='alert alert-danger' role='alert'>Already exist</p>";
		}
	}
}
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Service Allowances</h3>
	</div>
	<div class="panel-body">
        <div class="col-md-12" align="center">
            <form role="form" class="ss_form" method="post" id="defaultForm" novalidate>
             <?php if(isset($mess))echo $mess;?>
            <input type="hidden" value="<?php echo $ref;?>" name="ref" />
            <div class="col-md-3 form-group" align="left">
                <label>Zone</label>
                <select class="form-control showgradedesg" tabindex="1" name="zone"  required="required" autofocus="autofocus" onchange="ajaxSelect(this.options[this.selectedIndex].value,'state');">
                <option value="0" selected="selected" disabled="disabled">Select Zone</option>
                    <?php $getZn=getZones();if($getZn!=0){foreach($getZn as $rec){echo "<option value='".$rec['zone_alias']."'>".$rec['zone_name']."</option>";}}else echo "<option disabled='disabled'>Add Zone</option>";?>
                </select>
            </div>
            <div class="col-md-3 form-group" align="left">
                <label>State</label>
                <select class="form-control showgradedesg" tabindex="2"  required="required" name="state" autofocus="autofocus" id="ajaxSelect_state" onchange="ajaxSelect(this.options[this.selectedIndex].value,'district')">
                    <option value="0" selected="selected" disabled="disabled">Select State</option>
                </select>
            </div>
            <div class="col-md-3 form-group" align="left">
                <label>District</label>
                <select class="form-control showgradedesg" tabindex="3"  name="district" autofocus="autofocus" id="ajaxSelect_district" onchange="ajaxSelect(this.options[this.selectedIndex].value,'area')">
                    <option value="0" selected="selected" disabled="disabled">Select District</option>
                </select>
            </div>
            <div class="col-md-3 form-group" align="left">
                <label>Area</label>
                <input class="form-control" type="text" name="area" placeholder="Area" value="" id="ajaxSelect_area" readonly="readonly"/>
            </div>
			<div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Allowances</h3>
                    </div>
                    <div class="panel-body">
                    	<div class="col-md-4 form-group" align="left">
                            <label>Lodging Amount</label>
                            <input class="form-control amtt tamfor ldgam" tabindex="4" type="text" required="required" name="lodging_amount" placeholder="Amount"/>
                        </div>
                        <div class="col-md-4 form-group" align="left">
                            <label>Daily Allowance</label>
                            <input class="form-control amtt tamfor dailam" tabindex="4" type="text" name="daily_allowance" placeholder="Amount"/>
                        </div>
                        <div class="col-md-4 form-group" align="left">
                            <label>Local Conveyance</label>
                            <input class="form-control amtt tamfor localam" tabindex="4" type="text" name="local_conveyance" placeholder="Amount"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group col-xs-12 morpad">
                <input tabindex="13" type="submit" class="btn btn-primary ss_buttons ademp" name="addEmp" value="Add Allowances">
                <button tabindex="14" type="reset" class="btn btn-primary ss_buttons" name="Reset">Reset</button>
            </div>
            </form>
        </div>
	</div>
</div>

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
                    data: 'type=' + type + '&id=' + id,
                    cache: false,
                    success: function(result) {						
						if(type == "state" || type == "district"){
							$("#ajaxSelect_" + type).html(result);	
						}
						if (type == "area") {							
							//document.getElementById('ajaxSelect_Area').value = result;
							//$('#ajaxSelect_Area').val(result);
							//$('#ajaxSelect_Area').attr('value', result);							
							if(result == 0){
								var disp = 'Plain area';
								$('#ajaxSelect_area').val(disp);
							}else if(result == 1){
								var disp = 'Hilly area';
								$('#ajaxSelect_area').val(disp);
							
							}
						}
                    }
                });
        }
        if (type == "state") {
            $("#ajaxSelect_state").html("<option value='0' disabled >Select State</option>");
            $("#ajaxSelect_district").html("<option value='0' disabled >Select District</option>");
			$('#ajaxSelect_area').val("");
        }
		if (type == "District") {
			$('#ajaxSelect_area').val("");
        }
    }
    </script>