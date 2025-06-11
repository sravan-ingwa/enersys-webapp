<?php 
session_start();
date_default_timezone_set("Asia/Kolkata");
if($_REQUEST['id']) $_SESSION['id']=$_REQUEST['id']; 
$getDetails=getfullallowancesdetails($_SESSION['id']);
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title" style="display:inline-block;">Allowances</h3>
	</div>
	<div class="panel-body">
        <div class="col-md-8 col-md-offset-2" align="center">
			<?php if(isset($mess))echo $mess;?>
            <form role="form" class="ss_form" method="post" id="defaultForm" novalidate>
            <input type="hidden" value="<?php echo $ref;?>" name="ref" />
            <input type="hidden" value="<?php echo $_SESSION['id'];?>" name="id" />
            <div class="col-md-4 col-md-offset-1 form-group" align="left">
                <label>Grade : </label>
                <select class="form-control showgradedesg" tabindex="1" required="required" name="grade" autofocus="autofocus" disabled="disabled">
                    <option value="0" selected="selected" disabled="disabled">[Select Grade]</option>
                    <?php $listDgn=listGrade();if($listDgn!=0){foreach($listDgn as $rec){echo "<option value='".$rec['grade']."' ".selectedcheck($rec['grade'],$getDetails[0]['grade'])." >".$rec['grade']."</option>";}}else echo "<option disabled='disabled'>Add Designation</option>";?>
                </select>
            </div>
            <div class="col-md-6 form-group" align="left">
                <label>Designations : </label>
                  <p id="desglist">Select grade to Know designations </p>
            </div>
			<div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Others</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-4 form-group" align="left">
                            <label>Mode of Travel</label>
                            <select class="form-control" tabindex="2" required="required" name="mot[]" id="mot" multiple="multiple">
                                <option <?php echo selectedcheckmulti('ACT',$getDetails[0]['mode_of_travel']);?> >ACT</option>
                                <option <?php echo selectedcheckmulti('AIR',$getDetails[0]['mode_of_travel']);?> >Air</option>
                                <option <?php echo selectedcheckmulti('TRAIN 2ND AC',$getDetails[0]['mode_of_travel']);?> >Train 2nd AC</option>
                                <option <?php echo selectedcheckmulti('TRAIN 3 TIER',$getDetails[0]['mode_of_travel']);?> >Train 3 tier</option>
                                <option <?php echo selectedcheckmulti('TRAIN SLEEPER',$getDetails[0]['mode_of_travel']);?> >Train Sleeper</option>
                                <option <?php echo selectedcheckmulti('VOLVO AC BUS',$getDetails[0]['mode_of_travel']);?> >Volvo AC Bus</option>
                                <option <?php echo selectedcheckmulti('NON-AC BUS',$getDetails[0]['mode_of_travel']);?> >Non-AC Bus</option>
		                    </select>
                        </div>
                        <div class="col-md-4 form-group" align="left">
                            <label>Mode of Local Conveyance</label>
                            <select class="form-control" tabindex="3" required="required" name="molc[]" id="molc" multiple="multiple">
                                <option <?php echo selectedcheckmulti('ACT',$getDetails[0]['mode_of_conveyance']);?> >ACT</option>
                                <option <?php echo selectedcheckmulti('CAB',$getDetails[0]['mode_of_conveyance']);?> >Cab</option>
                                <option <?php echo selectedcheckmulti('AUTO',$getDetails[0]['mode_of_conveyance']);?> >Auto</option>
                                <option <?php echo selectedcheckmulti('LOCAL TRAIN',$getDetails[0]['mode_of_conveyance']);?> >Local Train</option>
                                <option <?php echo selectedcheckmulti('ANY PUBLIC TRANSPORT',$getDetails[0]['mode_of_conveyance']);?> >Any Public Transport</option>
		                    </select>
                        </div>
                        <div class="col-md-4 form-group" align="left">
                            <label>Mobile Roaming Charges</label>
                               <input class="form-control" tabindex="4" value="<?php echo $getDetails[0]['mobile_roaming']?>" type="text" name="amt9" placeholder="Amount" required="required"/>
                        </div>
                    </div>
                </div>
            </div>
			<div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lodging Allowances</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-3 form-group" align="left">
                            <label>A+</label>
                               <input class="form-control" tabindex="5" value="<?php echo $getDetails[0]['lodging_allowances_a1']?>" type="text" name="amt1" placeholder="Amount" required="required"/>
                        </div>
                        <div class="col-md-3 form-group" align="left">
                            <label>A</label>
                               <input class="form-control" tabindex="6" value="<?php echo $getDetails[0]['lodging_allowances_a']?>" type="text" name="amt2" placeholder="Amount" required="required"/>
                        </div>
                        <div class="col-md-3 form-group" align="left">
                            <label>B</label>
                               <input class="form-control" tabindex="7" value="<?php echo $getDetails[0]['lodging_allowances_b']?>" type="text" name="amt3" placeholder="Amount" required="required"/>
                        </div>
                        <div class="col-md-3 form-group" align="left">
                            <label>C</label>
                               <input class="form-control" tabindex="8" value="<?php echo $getDetails[0]['lodging_allowances_c']?>" type="text" name="amt4" placeholder="Amount" required="required"/>
                        </div>

                    </div>
                </div>
            </div>
			<div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Daily/Boarding Allowances</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-3 form-group" align="left">
                            <label>A+</label>
                               <input class="form-control" tabindex="9" value="<?php echo $getDetails[0]['boarding_allowances_a1']?>" type="text" name="amt5" placeholder="Amount" required="required"/>
                        </div>
                        <div class="col-md-3 form-group" align="left">
                            <label>A</label>
                               <input class="form-control" tabindex="10" value="<?php echo $getDetails[0]['boarding_allowances_a']?>" type="text" name="amt6" placeholder="Amount" required="required"/>
                        </div>
                        <div class="col-md-3 form-group" align="left">
                            <label>B</label>
                               <input class="form-control" tabindex="11" value="<?php echo $getDetails[0]['boarding_allowances_b']?>" type="text" name="amt7" placeholder="Amount" required="required"/>
                        </div>
                        <div class="col-md-3 form-group" align="left">
                            <label>C</label>
                               <input class="form-control" tabindex="12" value="<?php echo $getDetails[0]['boarding_allowances_c']?>" type="text" name="amt8" placeholder="Amount" required="required"/>
                        </div>

                    </div>
                </div>
            </div>
            <div class="form-group col-xs-12 morpad">
                <div class="col-md-3 col-md-offset-4">
                 <input tabindex="2" type="submit" class="btn btn-primary ss_buttons updatex" name="addEmp" value="Update">
                <button type="reset" class="btn btn-info btn-sm" ng-click="modalClose();">Close</button>
                </div>
            </div>
            </form>
        </div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		window.prettyPrint() && prettyPrint();
		$('#molc').multiselect({includeSelectAllOption: true});
		$('#mot').multiselect({includeSelectAllOption: true});
		$.ajax({
			url: "item.php",
			type: "POST",
			data: 'gradedesg='+encodeURIComponent($('.showgradedesg').val()),
			cache:false,
			success: function(result) {
				$('#desglist').html(result).hide().fadeIn(500);
			}
		});
	});
</script>
<?php
function selectedcheck($fv1,$fv2){if($fv1===$fv2) return " selected=\"selected\" "; }
function selectedcheckmulti($fv1,$fv2){
	$fv3=explode(", ",$fv2);
	if(in_array($fv1, $fv3)){return " selected=\"selected\" ";}
}

?>