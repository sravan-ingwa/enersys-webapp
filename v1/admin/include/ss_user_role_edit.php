<?php
if(isset($_REQUEST['update'])){
	for($r=0;$r<count($_REQUEST['privilageItem']);$r++){
		$pit = mysql_escape_string($_REQUEST['privilageItem'][$r]);
		$sqlzc = mysql_query("SELECT privilageType FROM ss_user_role GROUP BY privilageType ORDER BY id");
		while($rowzc = mysql_fetch_array($sqlzc)){
			if($_REQUEST['grantable'][$rowzc['privilageType']][$_REQUEST['privilageItem'][$r]] == "on"){
			$ac = mysql_query("UPDATE ss_user_role SET roleName='$_REQUEST[role_name]', grantable='Yes' WHERE id ='$_REQUEST[role]' AND privilageItem = '$pit' AND  privilageType = '$rowzc[privilageType]'");
			}
			else{
			$ac = mysql_query("UPDATE ss_user_role SET roleName='$_REQUEST[role_name]', grantable='No' WHERE id ='$_REQUEST[role]' AND privilageItem = '$pit' AND  privilageType = '$rowzc[privilageType]'");
			}	
		}
	}if($ac)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 2000 ); </script>";else $result=errorMsg('ERRMSG002');
}
$RefId = $_REQUEST['y'];
$privilageType = array();
$sqlz = mysql_query("SELECT privilageType FROM ss_user_role GROUP BY privilageType");
while($rowz = mysql_fetch_array($sqlz)){$privilageType[] = $rowz['privilageType'];}
$arr = array('create', 'view', 'edit', 'delete', 'xport', 'special');
$privilageType2 = array_combine($arr, $privilageType);
?>
<p class="errorP"><?php if(isset($result))echo $result; ?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
    <div class="col-md-4 form-group">
        <label>Role Title</label>
        <input tabindex="1" autofocus="autofocus" class="form-control" type="text" name="role_name" placeholder="Role Title" <?php echo roletext($RefId); ?> />
        <input type="hidden" name="role" value="<?php echo $RefId; ?>" />
    </div>
        <div class="col-md-4 form-group">
    	<label>&nbsp;</label>
        <input type="button" value="Check All" class="form-control" id="check_all"/>
    </div>
    <div class="col-md-4 form-group">
    	<label>&nbsp;</label>
        <input type="button" value="Uncheck All" class="form-control" id="uncheck_all"/><br><br>
    </div>
    <div id="checkxx">
        <label for="role_permissions">Role permissions:</label>
        <table class="table dataTable table-hover table-condensed" align="center">
            <thead><tr class="bkgcolor cntr"><th class="cntr">privilage Item</th><?php foreach($privilageType2 as $a=>$privilageArray){ echo '<th class="cntr">'.$privilageArray.'&nbsp;&nbsp;<span class="glyphicon glyphicon-check" id="check_'.$a.'"></span>&nbsp;<span class="glyphicon glyphicon-unchecked" id="uncheck_'.$a.'"></span></th>';}?></tr></thead>
					<tbody>
					<?php
						$sqlq = mysql_query("SELECT * FROM ss_menu ORDER BY ordering");
						while($rowq = mysql_fetch_array($sqlq)){
						echo"<tr align='center'>"; ?>
						<td><?php if($rowq['subMenu']==""){ echo maintext($rowq['id']);} else{ echo $rowq['subMenu'];} echo "</td>";
						echo '<input type="hidden" name="privilageItem[]" value="'.$rowq['id'].'">';
						foreach($privilageType2 as $a=>$privilageArray){
						$sqlw = mysql_query("SELECT * FROM ss_user_role WHERE id ='$RefId' AND privilageItem = '$rowq[id]' AND privilageType ='$privilageArray' GROUP BY privilageItem");
						$roww = mysql_fetch_array($sqlw);
						echo "<td><input type='checkbox' class='all ".$a."' name='grantable[".$roww['privilageType']."][".$roww['privilageItem']."]' ".checkedd($roww['grantable'])."></td>";
						}
						echo"</tr>";
                    	}
                    ?>
        </tbody></table>
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="update" tabindex="2">Update</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="3">Reset</button>
        </div>
    </div>
</form>
<?php
function checkedd($grantt){if($grantt =="Yes")return "checked";}
function roletext($xr){
	//include('mysql.php');
	$maintext=mysql_query("SELECT roleName FROM ss_user_role WHERE id='$xr'");
	$maintextrow=mysql_fetch_array($maintext);
	return "value='".$maintextrow['roleName']."'";
}
function maintext($xa){
	//include('mysql.php');
	$maintext=mysql_query("SELECT mainMenu FROM ss_menu WHERE id='$xa'");
	$maintextrow=mysql_fetch_array($maintext);
	return $maintextrow['mainMenu'];
}
?>