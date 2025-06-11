<?php $RefId = $_REQUEST['y'];
$sqlw = mysql_query("SELECT * FROM ss_revival WHERE id ='$RefId'");
$roww = mysql_fetch_array($sqlw);
?>
<div class="col-md-4 form-group">
    <label>MRF Number : </label>
    <input tabindex="1" autofocus="autofocus" class="form-control" type="text" value="<?php echo $roww['mrfNumber']; ?>" readonly/>
</div>
<div class="col-md-4 form-group">
    <label>Customer Name : </label>
    <input tabindex="2" class="form-control" type="text" value="<?php echo $roww['custName']; ?>" readonly/>
</div>
<div class="col-md-4 form-group">
    <label>No. Of Cells : </label>
    <input tabindex="3" class="form-control" type="text" value="<?php echo $roww['noOfCells']; ?>" readonly/>
</div>
<div class="col-md-4 form-group">
    <label>Capacity : </label>
    <input type="text"  tabindex="4" class="form-control" value="<?php echo $roww['capacity']; ?>" readonly/>
</div>
<div class="col-md-4 form-group">
    <label>PDF File : </label>
    <a href="../reports/revival/<?php echo $roww['pdf'];?>" tabindex="5" target="_blank" class="form-control" readonly style="cursor:pointer; font-weight:bold">Click Here</a>
</div>
<div class="col-md-4 form-group">
    <label>Engineer Name : </label>
    <input type="text"  tabindex="6" class="form-control" value="<?php echo $roww['engName']; ?>" readonly/>
</div>
<div class="container">
    <div class="row clearfix">
		<div class="col-md-11 column">
			<table class="table table-bordered table-hover" id="tab_logic">
				<thead class="bg-primary"><tr>
                <?php $arr = array("Sr.<br>No.","Cell Sr. No.","OCV","Discharge Current","1st Hr","2nd Hr","3rd Hr","4th Hr","5th Hr","6th Hr","7th Hr","8th Hr","9th Hr","10th Hr","Result");
				foreach($arr as $a){ ?> <th class="text-center"><?php echo $a; ?></th><?php } ?></tr></thead>
                <tbody>
					<?php $sqlw1 = mysql_query("SELECT * FROM ss_revival WHERE capacity ='$roww[capacity]'");
							while($roww1 = mysql_fetch_array($sqlw1)){ ?>
                	<tr>
						<td width="60px"><input type="text"  tabindex="8" class="form-control" value="<?php echo $roww1['srNo']; ?>" readonly></td>
						<td width="95px"><input type="text"  tabindex="8" class="form-control" value="<?php echo $roww1['cellSrNo']; ?>" readonly ></td>
						<td><input type="text"  tabindex="8" class="form-control" value="<?php echo $roww1['ocv']; ?>" readonly></td>
						<td><input type="text"  tabindex="8" class="form-control" value="<?php echo $roww1['disCurrent']; ?>" readonly></td>
                        <td><input type="text"  tabindex="8" class="form-control" value="<?php echo $roww1['1Hr']; ?>" readonly></td>
                        <td><input type="text"  tabindex="8" class="form-control" value="<?php echo $roww1['2Hr']; ?>" readonly></td>
                        <td><input type="text"  tabindex="8" class="form-control" value="<?php echo $roww1['3Hr']; ?>" readonly></td>
                        <td><input type="text"  tabindex="8" class="form-control" value="<?php echo $roww1['4Hr']; ?>" readonly></td>
                        <td><input type="text"  tabindex="8" class="form-control" value="<?php echo $roww1['5Hr']; ?>" readonly></td>
                        <td><input type="text"  tabindex="8" class="form-control" value="<?php echo $roww1['6Hr']; ?>" readonly></td>
                        <td><input type="text"  tabindex="8" class="form-control" value="<?php echo $roww1['7Hr']; ?>" readonly></td>
                        <td><input type="text"  tabindex="8" class="form-control" value="<?php echo $roww1['8Hr']; ?>" readonly></td>
                        <td><input type="text"  tabindex="8" class="form-control" value="<?php echo $roww1['9Hr']; ?>" readonly></td>
                        <td><input type="text"  tabindex="8" class="form-control" value="<?php echo $roww1['10Hr']; ?>" readonly></td>
                        <td width="95px"><input type="text"  tabindex="8" class="form-control" value="<?php echo $roww1['result']; ?>" readonly></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>