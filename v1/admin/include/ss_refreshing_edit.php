<?php
if(isset($_REQUEST['update'])){
	for($j=0;$j<count($_REQUEST['srNo']);$j++){
	$aa=mysql_escape_string($_REQUEST['mrfNumber']);
	$a=mysql_escape_string($_REQUEST['noOfCells']);
	$b=mysql_escape_string($_REQUEST['capacity']);
	$d[$j]=mysql_escape_string($_REQUEST['srNo'][$j]);
	$e[$j]=mysql_escape_string($_REQUEST['cellSrNo'][$j]);
	$f[$j]=mysql_escape_string($_REQUEST['ocv'][$j]);
	$g[$j]=mysql_escape_string($_REQUEST['disCurrent'][$j]);
	$h[$j]=mysql_escape_string($_REQUEST['1Hr'][$j]);
	$i[$j]=mysql_escape_string($_REQUEST['2Hr'][$j]);
	$ij[$j]=mysql_escape_string($_REQUEST['3Hr'][$j]);
	$k[$j]=mysql_escape_string($_REQUEST['4Hr'][$j]);
	$l[$j]=mysql_escape_string($_REQUEST['5Hr'][$j]);
	$m[$j]=mysql_escape_string($_REQUEST['6Hr'][$j]);
	$n[$j]=mysql_escape_string($_REQUEST['7Hr'][$j]);
	$o[$j]=mysql_escape_string($_REQUEST['8Hr'][$j]);
	$p[$j]=mysql_escape_string($_REQUEST['9Hr'][$j]);
	$q[$j]=mysql_escape_string($_REQUEST['10Hr'][$j]);
	$r[$j]=mysql_escape_string($_REQUEST['result'][$j]);
	if($j==0){
		if(!empty($_FILES['pdf']['name'])){
			$fileName = "Revival-".rand(0000,9999);
			$extension = pathinfo($_FILES['pdf']['name'], PATHINFO_EXTENSION);
			if($extension == "pdf"){
				if($_FILES["pdf"]["error"] > 0){echo "Return Code: ".$_FILES["pdf"]["error"]."<br/>";}
				else{
					$name = $fileName.".".$extension;
					if (file_exists("../reports/refreshing/".$name)){echo "<script>alert('".$name." already exists')</script>";}
					else{
						move_uploaded_file($_FILES["pdf"]["tmp_name"],"../reports/refreshing/".$name);
						$c = mysql_real_escape_string($name);
						if(isset($_REQUEST['oldPdf'])){@unlink("../reports/refreshing/".$_REQUEST['oldPdf']);}				
					}
				}
			}else{ $result = "Note : Choose pdf file only"; }
		}else{$c="";}}
	if($a==""){$result="Enter noOfCells";}
	elseif($b==""){$result="Enter capacity";}
	elseif($c==""){$result="Choose PDF File";}
	elseif($e[$j]==""){$result="Enter cellSrNo";}
	elseif($f[$j]==""){$result="Enter ocv";}
	elseif($g[$j]==""){$result="Enter Charging Current";}
	elseif($h[$j]==""){$result="Enter 1Hr";}
	elseif($i[$j]==""){$result="Enter 2Hr";}
	elseif($ij[$j]==""){$result="Enter 3Hr";}
	elseif($k[$j]==""){$result="Enter 4Hr";}
	elseif($l[$j]==""){$result="Enter 5Hr";}
	elseif($m[$j]==""){$result="Enter 6Hr";}
	elseif($n[$j]==""){$result="Enter 7Hr";}
	elseif($o[$j]==""){$result="Enter 8Hr";}
	elseif($p[$j]==""){$result="Enter 9Hr";}
	elseif($q[$j]==""){$result="Enter 10Hr";}
	elseif($r[$j]==""){$result="Enter 11Hr";}
	else{
		$RefId =$_REQUEST['y'];
		$ac = mysql_query("UPDATE ss_refreshing SET mrfNumber='$aa',noOfCells='$a',capacity='$b',pdf='$c',srNo='$d[$j]',cellSrNo='$e[$j]',ocv='$f[$j]',disCurrent='$g[$j]',1Hr='$h[$j]',2Hr='$i[$j]',3Hr='$ij[$j]',4Hr='$k[$j]',5Hr='$l[$j]',6Hr='$m[$j]',7Hr='$n[$j]',8Hr='$o[$j]',9Hr='$p[$j]',10Hr='$q[$j]',result='$r[$j]' WHERE id='$RefId' AND srNo='$d[$j]'");
	}
if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'view.php?x=".$_REQUEST['x']."&y=".$_REQUEST['y']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
	}
}
$RefId =$_REQUEST['y'];
$query=mysql_query("SELECT * FROM ss_refreshing WHERE id='$RefId'");
$row = mysql_fetch_array($query);
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm" enctype="multipart/form-data">
<input type="hidden" name="y" value="<?php echo $row['id'];?>" />
<div class="col-md-4 form-group">
    <label>MRF Number : </label>
    <input tabindex="1" autofocus="autofocus" class="form-control" type="text" name="mrfNumber" value="<?php echo $row['mrfNumber']; ?>" placeholder="MRF Number" readonly />
</div>
<div class="col-md-4 form-group">
    <label>Customer Name : </label>
    <input tabindex="2" class="form-control" type="text" name="custName" value="<?php echo $row['custName']; ?>" placeholder="Customer Name" readonly />
</div>
<div class="col-md-4 form-group">
    <label>No. Of Cells : </label>
    <input tabindex="3" class="form-control" type="text" name="noOfCells" value="<?php echo $row['noOfCells']; ?>" placeholder="No. Of Cells"/>
</div>
<div class="col-md-4 form-group">
    <label>Capacity : </label>
    <input type="text"  tabindex="4" class="form-control" name="capacity" value="<?php echo $row['capacity']; ?>" placeholder="Capacity" >
</div>
<div class="col-md-4 form-group">
    <label>Old Report : </label>
    <a href="../reports/refreshing/<?php echo $row['pdf'];?>" tabindex="5" target="_blank" class="form-control" readonly style="cursor:pointer; color:#06F; font-weight:bold">Click Here</a>
</div>
<div class="col-md-4 form-group">
    <label>Upload a PDF File : </label>
    <input tabindex="6" type="file" class="form-control" name="pdf">
    <input type="hidden" name="oldPdf" value="<?php echo $row['pdf'];?>" />
</div>
<div class="col-md-4 form-group">
    <label>Engineer Name : </label>
    <input type="text"  tabindex="7" class="form-control" name="engName" value="<?php echo $row['engName']; ?>" placeholder="Engineer Name" readonly >
</div>
<div class="container">
    <div class="row clearfix">
		<div class="col-md-11 column">
			<table class="table table-bordered table-hover" id="tab_logic">
				<thead class="bg-primary"><tr>
                <?php $arr = array("Sr.<br>No.","Cell Sr. No.","OCV","Charging Current","1st Hr","2nd Hr","3rd Hr","4th Hr","5th Hr","6th Hr","7th Hr","8th Hr","9th Hr","10th Hr","Result");
				foreach($arr as $a){ ?> <th class="text-center"><?php echo $a; ?></th><?php } ?></tr></thead>
                <tbody>
                	<?php $query1 = mysql_query("SELECT * FROM ss_refreshing WHERE capacity='$row[capacity]'");
					 while($row1 = mysql_fetch_array($query1)){ ?>
                    <tr>
						<td width="60px"><input type="text"  tabindex="8" class="form-control" name="srNo[]" value="<?php echo $row1['srNo']; ?>" readonly /></td>
						<td width="95px"><input type="text"  tabindex="8" class="form-control" name="cellSrNo[]" value="<?php echo $row1['cellSrNo']; ?>" placeholder="Cell Sr. No." ></td>
						<td><input type="text"  tabindex="8" class="form-control" name="ocv[]" value="<?php echo $row1['ocv']; ?>" placeholder="OCV" ></td>
						<td><input type="text"  tabindex="8" class="form-control" name="disCurrent[]" value="<?php echo $row1['disCurrent']; ?>" placeholder="Charging Current" ></td>
                        <td><input type="text"  tabindex="8" class="form-control" name="1Hr[]" value="<?php echo $row1['1Hr']; ?>" placeholder="1st" ></td>
                        <td><input type="text"  tabindex="8" class="form-control" name="2Hr[]" value="<?php echo $row1['2Hr']; ?>" placeholder="2nd" ></td>
                        <td><input type="text"  tabindex="8" class="form-control" name="3Hr[]" value="<?php echo $row1['3Hr']; ?>" placeholder="3rd" ></td>
                        <td><input type="text"  tabindex="8" class="form-control" name="4Hr[]" value="<?php echo $row1['4Hr']; ?>" placeholder="4th" ></td>
                        <td><input type="text"  tabindex="8" class="form-control" name="5Hr[]" value="<?php echo $row1['5Hr']; ?>" placeholder="5th" ></td>
                        <td><input type="text"  tabindex="8" class="form-control" name="6Hr[]" value="<?php echo $row1['6Hr']; ?>" placeholder="6th" ></td>
                        <td><input type="text"  tabindex="8" class="form-control" name="7Hr[]" value="<?php echo $row1['7Hr']; ?>" placeholder="7th" ></td>
                        <td><input type="text"  tabindex="8" class="form-control" name="8Hr[]" value="<?php echo $row1['8Hr']; ?>" placeholder="8th" ></td>
                        <td><input type="text"  tabindex="8" class="form-control" name="9Hr[]" value="<?php echo $row1['9Hr']; ?>" placeholder="9th" ></td>
                        <td><input type="text"  tabindex="8" class="form-control" name="10Hr[]" value="<?php echo $row1['10Hr']; ?>" placeholder="10th" ></td>
                        <td width="95px"><select tabindex="8" class="form-control" name="result[]"><option value="pass" <?php echo ($row1['result']=='pass' ? 'selected':''); ?>>Pass</option>
                        <option value="fail" <?php echo ($row1['result']=='fail' ? 'selected':''); ?>>Fail</option></select></td>
					</tr>
                    <?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="form-group col-xs-12 morpad">
    <div class="col-xs-12">
    <button tabindex="9" type="submit" class="btn btn-primary ss_buttons" name="update">Update</button>
    <button tabindex="10" type="reset" class="btn btn-primary ss_buttons" name="reset">Reset</button>
    </div>
</div>
</form>