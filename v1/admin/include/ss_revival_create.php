<?php
if(isset($_REQUEST['Create'])){
	$id = checkx(rand(0000, 9999),'ss_revival');
	for($j=0;$j<count($_REQUEST['srNo']);$j++){
	$a=mysql_escape_string($_REQUEST['mrfNumber']);
	$b=mysql_escape_string($_REQUEST['custName']);
	$c=mysql_escape_string($_REQUEST['noOfCells']);
	$d=mysql_escape_string($_REQUEST['capacity']);
	$e=mysql_escape_string($_REQUEST['engName']);
	$f[$j]=mysql_escape_string($_REQUEST['srNo'][$j]);
	$g[$j]=mysql_escape_string($_REQUEST['cellSrNo'][$j]);
	$h[$j]=mysql_escape_string($_REQUEST['ocv'][$j]);
	$i[$j]=mysql_escape_string($_REQUEST['disCurrent'][$j]);
	$ij[$j]=mysql_escape_string($_REQUEST['1Hr'][$j]);
	$k[$j]=mysql_escape_string($_REQUEST['2Hr'][$j]);
	$l[$j]=mysql_escape_string($_REQUEST['3Hr'][$j]);
	$m[$j]=mysql_escape_string($_REQUEST['4Hr'][$j]);
	$n[$j]=mysql_escape_string($_REQUEST['5Hr'][$j]);
	$o[$j]=mysql_escape_string($_REQUEST['6Hr'][$j]);
	$p[$j]=mysql_escape_string($_REQUEST['7Hr'][$j]);
	$q[$j]=mysql_escape_string($_REQUEST['8Hr'][$j]);
	$r[$j]=mysql_escape_string($_REQUEST['9Hr'][$j]);
	$s[$j]=mysql_escape_string($_REQUEST['10Hr'][$j]);
	$t[$j]=mysql_escape_string($_REQUEST['result'][$j]);
		if($j==0){
		if(!empty($_FILES['pdf']['name'])){
			$fileName = "Revival-".rand(0000,9999);
			$extension = pathinfo($_FILES['pdf']['name'], PATHINFO_EXTENSION);
			if($extension == "pdf"){
				if($_FILES["pdf"]["error"] > 0){echo "Return Code: ".$_FILES["pdf"]["error"]."<br/>";}
				else{
					$name = $fileName.".".$extension;
					if (file_exists("../reports/revival/".$name)){echo "<script>alert('".$name." already exists')</script>";}
					else{
						move_uploaded_file($_FILES["pdf"]["tmp_name"],"../reports/revival/".$name);
						$aa = mysql_real_escape_string($name);				
					}
				}
			}else{ $result = "Note : Choose pdf file only"; }
		}else{$aa="";}}
	if($a==""){$result="Choose MRF Number";}
	elseif($c==""){$result="Enter noOfCells";}
	elseif($d==""){$result="Enter capacity";}
	elseif($aa==""){$result="Choose PDF File";}
	elseif($e==""){$result="Enter Engineer Name";}
	elseif($g[$j]==""){$result="Enter cellSrNo";}
	elseif($h[$j]==""){$result="Enter ocv";}
	elseif($i[$j]==""){$result="Enter disCurrent";}
	elseif($ij[$j]==""){$result="Enter 1Hr";}
	elseif($k[$j]==""){$result="Enter 2Hr";}
	elseif($l[$j]==""){$result="Enter 3Hr";}
	elseif($m[$j]==""){$result="Enter 4Hr";}
	elseif($n[$j]==""){$result="Enter 5Hr";}
	elseif($o[$j]==""){$result="Enter 6Hr";}
	elseif($p[$j]==""){$result="Enter 7Hr";}
	elseif($q[$j]==""){$result="Enter 8Hr";}
	elseif($r[$j]==""){$result="Enter 9Hr";}
	elseif($s[$j]==""){$result="Enter 10Hr";}
	elseif($t[$j]==""){$result="Enter 11Hr";}
	else{
		$ac = mysql_query("INSERT INTO ss_revival(id,mrfNumber,custName,noOfCells,capacity,pdf,engName,srNo,cellSrNo,ocv,disCurrent,1Hr,2Hr,3Hr,4Hr,5Hr,6Hr,7Hr,8Hr,9Hr,10Hr,result,flag) VALUES('$id','$a','$b','$c','$d','$aa','$e','$f[$j]','$g[$j]','$h[$j]','$i[$j]','$ij[$j]','$k[$j]','$l[$j]','$m[$j]','$n[$j]','$o[$j]','$p[$j]','$q[$j]','$r[$j]','$s[$j]','$t[$j]','0')");
		}
	}
if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 1000 ); </script>";else $result=errorMsg('ERRMSG002');
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm" enctype="multipart/form-data">
<div class="col-md-3 form-group">
    <label>MRF(Material Request Form) Number : </label>
     <select class="selectpicker form-control" tabindex="1" autofocus="autofocus" name="mrfNumber" data-live-search="true" onchange="ajaxRevivRefreshCust('revival',this.value);">
        <option value="" selected disabled style="display:none;">Select MRF Number</option>
            <?php $sql = mysql_query("SELECT * FROM ss_material_inward");
            while($row = mysql_fetch_array($sql)){ echo "<option value='".$row['mrfNumber']."'>".$row['mrfNumber']."</option>";} ?>
     </select>
</div>
<div class="col-md-3 form-group">
    <label>Customer Name : </label>
    <input tabindex="2" class="form-control" type="text" name="custName" id="revival" placeholder="Customer Name" readonly/>
</div>
<div class="col-md-3 form-group">
    <label>No. Of Cells : </label>
    <input tabindex="3" class="form-control" type="text" name="noOfCells" placeholder="No. Of Cells"/>
</div>
<div class="col-md-3 form-group">
    <label>Capacity : </label>
    <input type="text"  tabindex="4" class="form-control" name="capacity" placeholder="Capacity" >
</div>
<div class="col-md-3 form-group">
    <label>Enter No.Of Rows : </label>
    <input type="text"  tabindex="5" class="form-control" placeholder="Enter No.Of Rows" id="revivalAdd">
</div>
<div class="col-md-1 form-group">
    <label>Click : </label>
    <input type="button" tabindex="6" class="form-control" value="+" id="revivalClick">
</div>
<div class="container">
    <div class="row clearfix">
		<div class="col-md-11 column">
			<table class="table table-bordered table-hover" id="tab_logic">
				<thead class="bg-primary"><tr>
                <?php $arr = array("Sr.<br>No.","Cell Sr. No.","OCV","Discharge Current","1st Hr","2nd Hr","3rd Hr","4th Hr","5th Hr","6th Hr","7th Hr","8th Hr","9th Hr","10th Hr","Result");
				foreach($arr as $a){ ?> <th class="text-center"><?php echo $a; ?></th><?php } ?></tr></thead>
                <tbody id="revivalRows">
                	<tr>
						<td width="60px"><input type="text" tabindex="7" class="form-control" name="srNo[]" value="1" readonly /></td>
						<td width="95px"><input type="text" tabindex="8" class="form-control" name="cellSrNo[]" placeholder="Cell Sr. No." ></td>
						<td><input type="text" tabindex="9" class="form-control" name="ocv[]" placeholder="OCV" ></td>
						<td><input type="text" tabindex="10" class="form-control" name="disCurrent[]" placeholder="Current" ></td>
                        <td><input type="text" tabindex="11" class="form-control" name="1Hr[]" placeholder="1st" ></td>
                        <td><input type="text" tabindex="12" class="form-control" name="2Hr[]" placeholder="2nd" ></td>
                        <td><input type="text" tabindex="13" class="form-control" name="3Hr[]" placeholder="3rd" ></td>
                        <td><input type="text" tabindex="14" class="form-control" name="4Hr[]" placeholder="4th" ></td>
                        <td><input type="text" tabindex="15" class="form-control" name="5Hr[]" placeholder="5th" ></td>
                        <td><input type="text" tabindex="16" class="form-control" name="6Hr[]" placeholder="6th" ></td>
                        <td><input type="text" tabindex="17" class="form-control" name="7Hr[]" placeholder="7th" ></td>
                        <td><input type="text" tabindex="18" class="form-control" name="8Hr[]" placeholder="8th" ></td>
                        <td><input type="text" tabindex="19" class="form-control" name="9Hr[]" placeholder="9th" ></td>
                        <td><input type="text" tabindex="20" class="form-control" name="10Hr[]" placeholder="10th" ></td>
                        <td width="95px"><select tabindex="21" class="form-control" name="result[]"><option value="pass">Pass</option><option value="fail">Fail</option></select></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="col-md-4 form-group">
    <label>Upload a Report : </label>
    <input tabindex="24" type="file" class="form-control" name="pdf">
</div><div class="col-md-4 form-group">
    <label>Done By (Engineer Name) : </label>
    <input tabindex="25" type="text" class="form-control" name="engName" placeholder="Engineer Name">
</div>
<div class="form-group col-xs-12 morpad">
    <div class="col-xs-12">
    <button tabindex="26" type="submit" class="btn btn-primary ss_buttons" name="Create">Submit</button>
    <button tabindex="27" type="reset" class="btn btn-primary ss_buttons" name="reset">Reset</button>
    </div>
</div>
</form>