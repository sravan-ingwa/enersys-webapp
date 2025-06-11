<?php include('lock.php');
$arrM = $arrM = array("April","May","June","July","August","September","october","November","December","January","February","March");
$arrF = array("F1","F2");
$year = $_REQUEST['year'];
$empid = $_REQUEST['empid'];
$act = $_REQUEST['act'];
foreach($arrM as $a=>$b){  
	echo '<div class="'.($a==$act ? 'active item row' : 'item').'">';
	foreach($arrF as $aF){ 	?>
	<div class="col-md-6 col-xs-6">
	<div class="row">
	<?php if($aF == 'F1'){ echo '<div class="col-md-2"></div>'; } ?>
	<div class="col-md-10">
	<?php $sqlf1 = mysql_query("SELECT * FROM ss_book_advance WHERE empId='$empid' AND advFor='$aF' AND year='$b-$year' AND flag='0'");
	while($rowf1=mysql_fetch_array($sqlf1)){ $req += $rowf1['advRequested']; $clr += $rowf1['advCleared'];}
	$sqlexp = mysql_query("SELECT * FROM ss_book_expenses WHERE empId='$empid' AND period='$aF $b $year' AND flag='0'");
	while($rowexp=mysql_fetch_array($sqlexp)){$netExp += $rowexp['netExpensesBooked'];} ?>
	<h3 class="blue-color"><?php echo "$b-$year $aF"; ?> Balance</h3>
		<table class="table table-responsive table-hover ">
			<tr><td><span>Advance Requested</span></td><td><?php echo ($req ? $req : 0); ?></td></tr>
			<tr><td><span>Advance Cleared</span></td><td><?php echo ($clr ? $clr : 0); ?></td></tr>
			<tr><td><span>Expenses</span></td><td><?php echo ($netExp ? $netExp : 0); ?></td></tr>
		</table></div>
		<?php if($aF == 'F2'){ echo '<div class="col-md-2 hidden-xs"></div>'; } ?>
		</div></div>
		<?php } ?>
	</div>
<?php } ?>