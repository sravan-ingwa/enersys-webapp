<?php
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
        <input tabindex="1" autofocus="autofocus" class="form-control" readonly="readonly" type="text" name="role_name" placeholder="Role Title" <?php echo roletext($RefId); ?> />
    </div>
    <div class="col-md-12 form-group">
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
						echo "<td><input onclick='return false' type='checkbox' class=' all ".$a."' name='grantable[".$roww['privilageType']."][".$roww['privilageItem']."]' ".checkedd($roww['grantable'])."></td>";
						}
						echo"</tr>";
                    	}
                    ?>
        </tbody></table>
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