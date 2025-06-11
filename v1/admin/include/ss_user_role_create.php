<?php
if(isset($_REQUEST['Create'])){
		$r = checkx(rand(0000, 9999),'ss_user_role');
		$a = str_split(strtoupper(mysql_escape_string($_REQUEST['role_name'])), 2); //$a is an array.
		$ri = $a[0].$r;
	if($_REQUEST['role_name']==""){$result="Enter Role Name";}
	else{

		if(mysql_num_rows(mysql_query("SELECT roleName FROM ss_user_role WHERE roleName='".mysql_escape_string($_REQUEST['role_name'])."' OR roleId='$ri'"))==0){
			$rmna=mysql_escape_string($_REQUEST['role_name']);
			for($i=1; $i<=count($_REQUEST['id']); $i++){
				$id = $_REQUEST['id'][$i];
				if($_REQUEST['create'][$i]=='on'){$create='Yes';}else{$create='No';}
				if($_REQUEST['view'][$i]=='on'){$view='Yes';}else{$view='No';}
				if($_REQUEST['edit'][$i]=='on'){$edit='Yes';}else{$edit='No';}
				if($_REQUEST['delete'][$i]=='on'){$delete='Yes';}else{$delete='No';}
				if($_REQUEST['export'][$i]=='on'){$export='Yes';}else{$export='No';}
				if($_REQUEST['special'][$i]=='on'){$special='Yes';}else{$special='No';}

				$v = mysql_query("INSERT INTO ss_user_role(id,roleId,roleName,privilageItem,privilageType,grantable,flag) VALUES('$r','$ri','$rmna','$id','Create','$create','0')");
				$w = mysql_query("INSERT INTO ss_user_role(id,roleId,roleName,privilageItem,privilageType,grantable,flag) VALUES('$r','$ri','$rmna','$id','View','$view','0')");
				$x = mysql_query("INSERT INTO ss_user_role(id,roleId,roleName,privilageItem,privilageType,grantable,flag) VALUES('$r','$ri','$rmna','$id','Edit','$edit','0')");
				$y = mysql_query("INSERT INTO ss_user_role(id,roleId,roleName,privilageItem,privilageType,grantable,flag) VALUES('$r','$ri','$rmna','$id','Delete','$delete','0')");
				$z = mysql_query("INSERT INTO ss_user_role(id,roleId,roleName,privilageItem,privilageType,grantable,flag) VALUES('$r','$ri','$rmna','$id','Export','$export','0')");
				$zz = mysql_query("INSERT INTO ss_user_role(id,roleId,roleName,privilageItem,privilageType,grantable,flag) VALUES('$r','$ri','$rmna','$id','Special','$special','0')");
			}
			if($v && $w && $x && $y && $z && $zz)$result="".errorMsg('ERRMSG001')."<script>setTimeout(function(){ document.location = 'index.php?x=".$_REQUEST['x']."';}, 2000 ); </script>";
			else $result=errorMsg('ERRMSG002');
		}else{$result=errorMsg('ERRMSG003');}
	}
}
?>
<p class="errorP"><?php if(isset($result))echo $result;?></p>
<form role="form" class="ss_form" method="post" id="defaultForm">
    <div class="col-md-4 form-group">
        <label>Role Title</label>
        <input tabindex="1" autofocus="autofocus" class="form-control" type="text" name="role_name" placeholder="Role Title">
    </div>
    <div class="col-md-4 form-group">
    	<label>&nbsp;</label>
        <input tabindex="2" type="button" value="Check All" class="form-control" id="check_all"/>
    </div>
    <div class="col-md-4 form-group">
    	<label>&nbsp;</label>
        <input tabindex="3" type="button" value="Uncheck All" class="form-control" id="uncheck_all"/><br><br>
    </div>

    <div id="checkxx">
        <label for="role_permissions">Role permissions:</label>            
        <table class="table dataTable table-hover table-condensed" align="center">
            <thead>
            <tr class="bkgcolor"><th class="cntr">privilage Item</th>
            <th class="cntr">Create&nbsp;&nbsp;<span tabindex="4" class="glyphicon glyphicon-check" id="check_create"></span>&nbsp;<span tabindex="4" class="glyphicon glyphicon-unchecked" id="uncheck_create"></span></th>
            <th class="cntr">View&nbsp;&nbsp;<span tabindex="5" class="glyphicon glyphicon-check" id="check_view"></span>&nbsp;<span tabindex="5" class="glyphicon glyphicon-unchecked" id="uncheck_view"></span></th>
            <th class="cntr">Edit&nbsp;&nbsp;<span tabindex="6" class="glyphicon glyphicon-check" id="check_edit"></span>&nbsp;<span tabindex="6" class="glyphicon glyphicon-unchecked" id="uncheck_edit"></span></th>
            <th class="cntr">Delete&nbsp;&nbsp;<span tabindex="7" class="glyphicon glyphicon-check" id="check_delete"></span>&nbsp;<span tabindex="7" class="glyphicon glyphicon-unchecked" id="uncheck_delete"></span></th>
            <th class="cntr">Export&nbsp;&nbsp;<span tabindex="8" class="glyphicon glyphicon-check" id="check_xport"></span>&nbsp;<span tabindex="8" class="glyphicon glyphicon-unchecked" id="uncheck_xport"></span></th>
            <th class="cntr">Special&nbsp;&nbsp;<span tabindex="9" class="glyphicon glyphicon-check" id="check_special"></span>&nbsp;<span tabindex="9" class="glyphicon glyphicon-unchecked" id="uncheck_special"></span></th></tr></thead>
			<tbody>
			<?php
            $sql = mysql_query("SELECT * FROM ss_menu");
            $k=1; while($r = mysql_fetch_array($sql)){?>
            <tr align="center">
            <td><?php if($r['subMenu']=="")echo $r['mainMenu'];else echo $r['subMenu']; ?><input type="hidden" name="id[<?php echo $k; ?>]" value="<?php echo $r['id']; ?>"></td>
            <td><input type="checkbox" tabindex="<?php echo $k+9; ?>" class="all create" name="create[<?php echo $k; ?>]"/></td>
            <td><input type="checkbox" tabindex="<?php echo $k+9; ?>" class="all view" name="view[<?php echo $k; ?>]" checked="checked"/></td>
            <td><input type="checkbox" tabindex="<?php echo $k+9; ?>" class="all edit" name="edit[<?php echo $k; ?>]"/></td>
            <td><input type="checkbox" tabindex="<?php echo $k+9; ?>" class="all delete" name="delete[<?php echo $k; ?>]"/></td>
            <td><input type="checkbox" tabindex="<?php echo $k+9; ?>" class="all xport" name="export[<?php echo $k; ?>]"/></td>
            <td><input type="checkbox" tabindex="<?php echo $k+9; ?>" class="all special" name="special[<?php echo $k; ?>]"/></td>
            </tr>
            <?php
            $k++;}
            ?></tbody>
        </table>
    </div>
    <div class="form-group col-xs-12 morpad">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary ss_buttons" name="Create" tabindex="50">Create</button>
            <button type="button" class="btn btn-primary ss_buttons" id="resetButton" tabindex="51">Reset</button>
        </div>
    </div>
    </form>