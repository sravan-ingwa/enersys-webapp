<?php 
session_start();
date_default_timezone_set("Asia/Kolkata");
if($_REQUEST['id']) $_SESSION['id']=$_REQUEST['id']; 
$getDetails=getserallowancesdetails($_SESSION['id']);
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Service Allowances</h3>
	</div>
	<div class="panel-body">
        <div class="col-md-12" align="center">
            <form role="form" class="ss_form" method="post" id="defaultForm" novalidate>
             <?php if(isset($message))echo $message;?>
            <input type="hidden" value="<?php echo $ref;?>" name="ref" />
            <input type="hidden" value="<?php echo $_SESSION['id'];?>" name="id" />
            <div class="col-md-3 form-group" align="left">
                <label>Zone</label>
                <select class="form-control showgradedesg" tabindex="1" name="zone"  required="required" autofocus onchange="ajaxSelect(this.options[this.selectedIndex].value,'state');">
                <option value="0" selected="selected" disabled="disabled">Select Zone</option>
                    <?php $getZn=getZones();if($getZn!=0){foreach($getZn as $rec){echo "<option value='".$rec['zone_alias']."' ".selectedcheck($rec['zone_alias'],$getDetails[0]['zone_alias']).">".$rec['zone_name']."</option>";}}else echo "<option disabled='disabled'>Add Zone</option>";?>               
                </select>
            </div>
            <div class="col-md-3 form-group" align="left">
                <label>State</label>
                <select class="form-control showgradedesg" tabindex="2"  required="required" name="state" autofocus id="ajaxSelect_state" onchange="ajaxSelect(this.options[this.selectedIndex].value,'district')">
                    <?php $getst=getStates($getDetails[0]['zone_alias']);if($getst!=0){foreach($getst as $srec){echo "<option value='".$srec['state_alias']."' ".selectedcheck($srec['state_alias'],$getDetails[0]['state_alias']).">".$srec['state_name']."</option>";}}else echo "<option disabled='disabled'>Add State</option>";?>
                </select>
            </div>
            <div class="col-md-3 form-group" align="left">
                <label>District</label>
                <select class="form-control showgradedesg" tabindex="3"  name="district" autofocus id="ajaxSelect_district" onchange="ajaxSelect(this.options[this.selectedIndex].value,'area')">
                   <?php $getdt=getDistricts($getDetails[0]['state_alias']);if($getdt!=0){foreach($getdt as $drec){echo "<option value='".$drec['district_alias']."' ".selectedcheck($drec['district_alias'],$getDetails[0]['district_alias']).">".$drec['district_name']."</option>";}}else echo "<option disabled='disabled'>Add District</option>";?>
                </select>
            </div>
            <div class="col-md-3 form-group" align="left">
                <label>Area</label>
                <?php $getarea= getArea($getDetails[0]['district_alias']);
				if($getarea==0){
					$disp_area = "Plain Area";
				}else if($getarea==1){
					$disp_area = "Hilly Area";
				}else{
					$disp_area = "";
				}
				
				?>
                <input class="form-control" type="text" name="area" placeholder="Area" value="<?php echo $disp_area;?>" id="ajaxSelect_area" readonly/>
            </div>
			<div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Service</h3>
                    </div>
                    <div class="panel-body">
                    	<div class="col-md-4 form-group" align="left">
                            <label>Lodging Amount</label>
                            <input class="form-control amtt tamfor ldgam" tabindex="4" type="text" required name="lodging_amount" placeholder="Amount" value="<?php echo $getDetails[0]['lodging_amount']?>"/>
                        </div>
                        <div class="col-md-4 form-group" align="left">
                            <label>Daily Allowance</label>
                            <input class="form-control amtt tamfor dailam" tabindex="4" type="text" name="daily_allowance" placeholder="Amount" value="<?php echo $getDetails[0]['daily_allowance']?>"/>
                        </div>
                        <div class="col-md-4 form-group" align="left">
                            <label>Local Conveyance</label>
                            <input class="form-control amtt tamfor localam" tabindex="4" type="text" name="local_conveyance" placeholder="Amount" value="<?php echo $getDetails[0]['local_conveyance']?>"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group col-xs-12 morpad">
           		 <input tabindex="13" type="submit" class="btn btn-primary ss_buttons updatex" name="addEmp" value="Update">
                <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose();">Close</button>
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
		if (type == "district") {
			$('#ajaxSelect_area').val("");
        }
    }
    </script>
<?php
function selectedcheck($fv1,$fv2){if($fv1===$fv2) return " selected=\"selected\" "; }
?>