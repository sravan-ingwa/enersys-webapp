<?php
ob_start();
if(isset($_REQUEST['export'])){
	include('functions.php');
	date_default_timezone_set("Asia/Kolkata");
	function hix($hx){if($hx=='1')return "class='hidden-xs hidden-sm'";}
	$tableName= menuName($_REQUEST['x'],"tbName");
	$menuName=menuName($_REQUEST['x'],"menu");
	$mainName=menuName($_REQUEST['x'],"mainMenu");
	$filename = str_replace(" ","",$menuName)."-".date('Y-m-d_h-i-s a');
	if($menuName=='Material Balance'){
		$z = array('MRF Number','Warehouse Code','Item Description','Stock Category','Material Inwards','Material Outwards','Balance Stock');
			$result="<table border='1'><tr>";
			foreach($z as $y){$result.="<th bgcolor='#428bca' style='color:#FFF;'>$y</th>";}
			$result.="</tr>";
				$res1 = mysql_query("SELECT * FROM ss_material_inward WHERE flag='0'");
				if(mysql_num_rows($res1)){
					while($row1=mysql_fetch_array($res1)){
						$result.="<tr>";
							$result.="<td>".$row1['mrfNumber']."</td>";
							$result.="<td>".whareHouseGetName($row1['toWh'])."</td>";
							$result.="<td>".itemGetDesc($row1['itemCode'])."</td>";
							$result.="<td>".stockGetName($row1['stockCategory'])."</td>";
							$result.="<td>".$row1['qty']."</td>";
							$res2 = mysql_query("SELECT qty FROM ss_material_outward WHERE mrfNumber='".$row1['mrfNumber']."' AND fromWh='".$row1['toWh']."' AND itemCode='".$row1['itemCode']."' AND stockCategory='".$row1['stockCategory']."' AND flag='0'");
							if(mysql_num_rows($res2)){$i2=0;while($row2=mysql_fetch_array($res2)){ $i2+=$row2['qty'];}}else{$i2=0;}
							$result.="<td>".$i2."</td>";
							$result.="<td>".($row1['qty']-$i2)."</td>";
						$result.="</tr>";
					}
				}
			$result.="</table>";
	}else{
	$query = mysql_query("SELECT colName,colRef,pSpl FROM ss_col_ref WHERE tbName='$tableName' AND pExport='0' ORDER BY ordering");
	if(mysql_num_rows($query)>0){while($row=mysql_fetch_array($query)){$colName[]=$row['colName'];$colref[]=$row['colRef'];$pSpl[]=$row['pSpl'];}}
	$query=mysql_query("SELECT * FROM  $tableName");
	if(mysql_num_rows($query)>0){while($row=mysql_fetch_array($query)){$id.="'".$row['id']."',";}$id=rtrim($id,",");}else{$id=0;}
	if($id!='0'){
		if($menuName=='Detail View'){ $queryx = mysql_query("SELECT * FROM $tableName WHERE flag='0'");
			$arrM = array("April","May","June","July","August","September","October","November","December","January","February","March");
			$i = $_REQUEST['year'];
			$adv = $_REQUEST['advFor'];
			$result.="<table border='1'><tr><th bgcolor='#428bca' style='color:#FFF;'></th><th bgcolor='#428bca' style='color:#FFF;'></th>";
			for($x=0;$x<12;$x++){$result.= "<th colspan='4' bgcolor='#428bca' style='color:#FFF;'>$adv-$arrM[$x]-$i</th>";}
			$result.="</tr><tr><td bgcolor='#428bca' style='color:#FFF;'>Employee ID</td><td bgcolor='#428bca' style='color:#FFF;'>Employee Name</td>";
			for($x=0;$x<12;$x++){$result.= "<td bgcolor='#428bca' style='color:#FFF;'>Advance Requested</td><td bgcolor='#428bca' style='color:#FFF;'>Advance Given</td><td bgcolor='#428bca' style='color:#FFF;'>Bills Submitted</td><td bgcolor='#428bca' style='color:#FFF;'>Balance</td>";}
			$result.="</tr>";
			while($ro=mysql_fetch_array($queryx)){
				$result.="<tr><td>".employeeGetName($ro['empId'])."</td><td>".$ro['empName']."</td>";
					foreach($arrM as $m){ $req = 0; $clr = 0; $netExp = 0;
						$sqlf1 = mysql_query("SELECT * FROM ss_book_advance WHERE empId='$ro[empId]' AND advFor='$adv' AND year='$m-$i' AND stat='2' AND flag='0'");
						while($rowf1=mysql_fetch_array($sqlf1)){$req += $rowf1['advRequested']; $clr += $rowf1['advCleared'];}
						$sqlexp = mysql_query("SELECT * FROM ss_book_expenses WHERE empId='$ro[empId]' AND period='$adv $m $i' AND stat='2' AND flag='0'");
						while($rowexp=mysql_fetch_array($sqlexp)){$netExp += $rowexp['netExpensesBooked'];}
							$result.="<td>".($req ? $req : '0')."</td>";
							$result.="<td>".($clr ? $clr : '0')."</td>";
							$result.="<td>".($netExp ? $netExp : '0')."</td>";
							$result.="<td>".($clr || $netExp ? $clr-$netExp : '0')."</td>";
					}
				$result.="</tr>";
			}
			$result.="</table>";
		}else{
		if(isset($_REQUEST['circle']) && isset($_REQUEST['zone'])){
			$circle = implode("|",$_REQUEST['circle']);
			$zone = implode("|",$_REQUEST['zone']);
			$queryx=mysql_query("SELECT * FROM $tableName WHERE id IN ($id) AND zone RLIKE '$zone' AND circle RLIKE '$circle' AND flag=0");
		}
		elseif(!isset($_REQUEST['circle']) && isset($_REQUEST['zone'])){
			$zone = implode("|",$_REQUEST['zone']);
			$queryx=mysql_query("SELECT * FROM $tableName WHERE id IN ($id) AND zone RLIKE '$zone' AND flag=0");
		}
		else{$queryx=mysql_query("SELECT * FROM $tableName WHERE id IN ($id) AND flag=0");}	
		if(mysql_num_rows($queryx)>0){
			$coo=1;
			$result="<table border='1'><tr>";
			foreach($colref as $colrefValue){$result.="<th bgcolor='#428bca' style='color:#FFF;'>".ucfirst($colrefValue)."</th>";}
			$result.='</tr>';
			while($row=mysql_fetch_array($queryx)){$coo++;
				$result.="<tr>";
				for($af=0;$af<count($colName);$af++){$result.="<td nowrap>".ucfirst(refname($colref[$af],$row[$colName[$af]],$row['id']))."</td>";}
				$result.='</tr>';
			}
			$result.='</table>';
		}
	}
	}
	}
	header("Content-Disposition: attachment; filename=$filename.xls");
	echo $result;
}
else{?>
<?php include('lock.php'); include('functions.php');?>
<?php function hix($hx1){if(strpos($hx1,'@')!==false){return"nocap";}}?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php TitleFav();?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body role="document">
<?php include('header.php');?>
<?php if(!isset($_REQUEST['x'])){$query = mysql_query("SELECT * FROM ss_menu ORDER BY ordering");$row=mysql_fetch_array($query);if($row)echo "<script type='text/javascript'>window.location='index.php?x=$row[id]'</script>";else echo"<script type='text/javascript'>window.location='logout.php?ref=noview'</script>";}?>
<div class="container-fluid"><!-- Starting Of Body Container -->
    <div class="row">
        <div class="col-sm-1 hidden-xs"></div>
        	<div class="col-xs-12 col-sm-10">
            	<div class="panel panel-primary">
                	<div class="panel-heading">
                    	<h3 class="panel-title">Export <?php $menuName=menuName($_REQUEST['x'],"menu"); echo $menuName; ?></h3>
                    </div>
                	<div class="panel-body">
                        <p class="errorP"><?php if(isset($result))echo $result;?></p>
                        <form role="form" class="ss_form" method="post">
                        <input type="hidden" value="<?php echo $_REQUEST['x']; ?>" name="tbNName" />
						<?php
						if($menuName!='Material Balance'){
						$tb= menuName($_REQUEST['x'],"tbName");
						$cheq= mysql_query("SHOW COLUMNS FROM $tb LIKE '%circle%'");
							if(mysql_num_rows($cheq)){$rowcheq=mysql_fetch_assoc($cheq);
								if($rowcheq['Field'] == "circle" || $rowcheq['Field'] == "circles"){
						?>
						<div class="col-md-4 form-group">
                            <label>Zone</label>
                            <select name="zone[]" multiple="multiple" id="zoneSelect" class="form-control" onchange="ajaxSelect(this.id,'Circle')">
                                <option value="" disabled>select zone</option><?php zonesOptions(); ?>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Circle</label>
                            <select name="circle[]" multiple="multiple" class="form-control" id="ajaxSelect_Circle"  onchange="ajaxSelect(this.id,'Cluster')">
                                <option value="" disabled>Select Circle</option>
                            </select>
                        </div>
					<?php } } } ?> 
                       <!-- <div>
                            <label>Listed Since</label>
                            <select name="date">
                                <option value="">Select Listed Since</option>
                                <option value="30">30 Days</option>
                                <option value="45">45 Days</option>
                                
                            </select>
                        </div>-->
						<?php if($menuName=='Detail View'){ ?>
						  <div class="col-md-2 form-group">
							<select class="form-control" name="year"><?php for($i = date("Y"); $i > date("Y")-5 ; $i--){ echo "<option value='$i'>$i</option>"; } ?></select>
						  </div>
						  <div class="col-md-2 form-group">
							<select class="form-control" name="advFor"><option value="F1">F1</option><option value="F2">F2</option></select>
						  </div>
						<?php } ?> 
                        <div class="col-xs-12 form-group">
                            <button type="submit" class="btn btn-primary ss_buttons" name="export">Export</button>
                            <!--<button type="reset" class="btn btn-primary ss_buttons" name="reset">Reset</button>-->
                        </div>
                        </form>
                	</div>
            	</div>
        	</div><!-- Closing Of col-xs-12 -->
    	<div class="col-sm-1 hidden-xs"></div>
    </div>
</div><!-- Closing Of Body Container -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

<script>
	$('.tooltips').tooltip();
</script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.autocomplete.js"></script>
<script type="text/javascript">
function ajaxSelect(ids, type) {
	multipleValues = $( "#"+ids).val() || [];id=multipleValues.join( "," );
	if (id != "") {
		$.ajax({ 
				type: "POST",
				url: "ajaxSelectMulti.php",
				data: 'type=' + type + '&id=' + id,
				cache: false,
				success: function(result){$("#ajaxSelect_" +type).html(result);}
			});
		}
    if (type == "Circle") {
        $("#ajaxSelect_Circle").html("<option value=''>Select Circle</option>");
        $("#ajaxSelect_Cluster").html("<option value=''>Select Cluster</option>");
        $("#ajaxSelect_District").html("<option value=''>Select District</option>")
		$("#ajaxSelect_serviceEngineer").html("<option value=''>Select Service Engineer</option>")
		$("#ajaxSelect_regionalManager").html("<option value=''>Select Regional Manager</option>")
    }
    if (type == "Cluster") {
        $("#ajaxSelect_Cluster").html("<option value=''>Select Cluster</option>");
        $("#ajaxSelect_District").html("<option value=''>Select District</option>")
		$("#ajaxSelect_serviceEngineer").html("<option value=''>Select Service Engineer</option>")
		$("#ajaxSelect_regionalManager").html("<option value=''>Select Regional Manager</option>")
    }
    if (type == "District") {
        $("#ajaxSelect_District").html("<option value=''>Select District</option>")
    }
    if (type == "CustomerName") {
        $("#ajaxSelect_CustomerName").html("<option value=''>Select Customer</option>")
    }
}
</script>

<?php } ?>