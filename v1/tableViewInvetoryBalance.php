<?php include('mysql.php');
function hix($hx,$hx1){
	if($hx=='1'){if (strpos($hx1, '@') !== false){return "class='hidden-xs hidden-sm nocap'";}else{return "class='hidden-xs hidden-sm'";}}
	else{if(strpos($hx1, '@') !== false){return "class='nocap'";}}
}
$z = array('Warehouse Code','Item Description','Stock Category','Material Inwards','Material Outwards','Balance Stock');
$emp_circle=str_replace(", ","|",empDetails($_SESSION['login_user'],'circle'));
$inward = mysql_query("SELECT toWh FROM ss_material_inward WHERE circle RLIKE '$emp_circle' AND flag='0' GROUP BY toWh");
if(mysql_num_rows($inward)){while($inwardRow = mysql_fetch_array($inward)){ $whCode[] = $inwardRow['toWh'];}
	$result="<input type='hidden' id='countt' value='".count($whCode)."'/>";
	$result.="<table class='table table-bordered'><thead><tr align='center' class='blue cust'>";
	$result.="<th ".hix(0,"").">Warehouse Code</th>";
	$result.="<th ".hix(1,"").">Item Description</th>";
	$result.="<th ".hix(1,"").">Stock Category</th>";
	$result.="<th ".hix(0,"").">Material Inwards</th>";
	$result.="<th ".hix(0,"").">Material Outwards</th>";
	$result.="<th ".hix(0,"").">Balance Stock</th>";
	$result.="<th width='100px'>Options</th>";
	$result.="</tr>";
	$result.="</thead>";
	$result.='<input type="hidden" value="'.$_REQUEST['x'].'" name="x">';
	$result.="<tbody align='center'>";
	for($i=0; $i<count($whCode); $i++ ){
		$inItem = mysql_query("SELECT itemCode,stockCategory FROM ss_material_inward WHERE toWh='".$whCode[$i]."' AND flag='0'");
		$itemCode = array(); $stockCategory = array();
		while($inItemRow = mysql_fetch_array($inItem)){ $itemCode[] = $inItemRow['itemCode']; $stockCategory[] = $inItemRow['stockCategory'];}
		$result.='<tr>';
			$result.="<td ".hix(0,"").">".whareHouseGetName($whCode[$i])."</td>";
			$result.="<td ".hix(1,"").">";
				$result.="<input type='hidden' id='wh".$i."' value='".$whCode[$i]."'/>";
				$result.="<select class='form-control' id='itemSelect".$i."'>";
					$result.="<option value=''>All</option>";
					foreach(array_unique($itemCode) as $item){$result.="<option value='".$item."'>".itemGetDesc($item)."</option>"; }
				$result.="</select>";
			$result.="</td>";
			$result.="<td ".hix(1,"").">";
				$result.="<select class='form-control' id='stockSelect".$i."'>";
					$result.="<option value=''>All</option>";
					foreach(array_unique($stockCategory) as $stockCat){$result.="<option value='".$stockCat."'>".stockGetName($stockCat)."</option>"; }
				$result.="</select>";
			$result.="</td>";
			$result.="<td id='matIn".$i."' ".hix(0,"")."></td>";
			$result.="<td id='matOut".$i."' ".hix(0,"")."></td>";
			$result.="<td id='balanceStk".$i."' ".hix(0,"")."></td>";
			$result.="<td class='operations'>";
				$result.="<span class='actionsc'>";
				$result.="<a href='inventoryView.php?x=".$_REQUEST['x']."&wh=".$whCode[$i]."' id='hideView".$i."' title='View'><span class='glyphicon glyphicon-eye-open'></span></a>";
				$result.="<a href='inventoryDownload.php?x=".$_REQUEST['x']."&wh=".$whCode[$i]."' id='hideView".$i."' title='Download'><span class='glyphicon glyphicon-download-alt'></span></a>";
				$result.="</span>";
			$result.="</td>";
		$result.="</tr>";
	} 
$result.="</tbody>";
$result.="</table>";
}else{
	$result="<table class='table table-bordered'><thead><tr align='center' class='blue cust'>";
	$result.="<th ".hix(0,"").">Warehouse Code</th>";
	$result.="<th ".hix(1,"").">Item Description</th>";
	$result.="<th ".hix(1,"").">Stock Category</th>";
	$result.="<th ".hix(0,"").">Material Inwards</th>";
	$result.="<th ".hix(0,"").">Material Outwards</th>";
	$result.="<th ".hix(0,"").">Balance Stock</th>";
	$result.='<th width="100px">Options</th></tr></thead><tbody><tr class="nmg">';
	$result.="<td colspan='7'><h4 align='center'>No Records</h4></td></tr>";
	$result.='</tbody>';
	$result.="</table>";
	}