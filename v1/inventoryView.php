<?php include('lock.php'); include('functions.php'); if(isset($_SESSION['login_user'])){ $wh = $_REQUEST['wh'];
function hix($hx,$hx1){
	if($hx=='1'){if (strpos($hx1, '@') !== false){return "class='hidden-xs hidden-sm nocap'";}else{return "class='hidden-xs hidden-sm'";}}
	else{if(strpos($hx1, '@') !== false){return "class='nocap'";}}
}?>
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
</head>
<body role="document">
<?php include('header.php');?>
<?php if(!isset($_REQUEST['x'])){$query = mysql_query("SELECT * FROM ss_menu ORDER BY ordering");$row=mysql_fetch_array($query);if($row)echo "<script type='text/javascript'>window.location='index.php?x=$row[id]'</script>";else echo"<script type='text/javascript'>window.location='logout.php?ref=noview'</script>";}?>
<div class="container-fluid"><!-- Starting Of Body Container -->
    <div class="row">
        <div class="col-sm-1 hidden-xs"></div>
        	<div class="col-xs-12 col-sm-10" id="ss_form">
            	<div id="myText">&nbsp;</div>
                <div class="panel panel-primary">
                	<div class="panel-heading">
                    	<h3 class="panel-title pull-left">VIEW MATERIAL BALANCE</h3>
                        <ul class="nav nav-pills pull-right splnav">
                            <?php /* ?><li><a href="print.php?x=<? echo $_REQUEST['x'];?>&y=<? echo $_REQUEST['y'];?>" class="tooltips" data-placement="top" title="Print" ><span class="glyphicon glyphicon-print"></span></a></li><?php */ ?>
                            <li><a href="inventoryDownload.php?x=<? echo $_REQUEST['x'];?>&wh=<? echo $wh;?>" target="_blank" class="tooltips" data-placement="top" title="Download"><span class="glyphicon glyphicon-download-alt"></span></a></li>
                        </ul>
                        <div class="clearfix" ></div>
                    </div>
                    <div class="col-md-12" align="center" style="padding:7px 0px !important; font-size:18px;">
                        <div class="col-xs-4"><label>Ware House : </label><span class="blue-color"><?php echo whareHouseGetName($wh)." [".whareHouseGetDesc($wh)."]"; ?></span></div>
                    </div>
	          		<div class="panel-body ss_form printable">
						<?php
                        //$z = array('MRF Number','Item Description','Stock Category','Material Inwards','Material Outwards','Balance Stock');
                            $result.="<table class='table table-bordered'><thead><tr align='center' class='blue cust'>";
                            $result.="<th ".hix(0,"").">MRF Number</th>";
                            $result.="<th ".hix(1,"").">Item Description</th>";
                            $result.="<th ".hix(1,"").">Stock Category</th>";
                            $result.="<th ".hix(0,"").">Material Inwards</th>";
                            $result.="<th ".hix(0,"").">Material Outwards</th>";
                            $result.="<th ".hix(0,"").">Balance Stock</th>";
                            $result.="</tr>";
                            $result.="</thead>";
                            $result.="<tbody align='center'>";
                                $inItem = mysql_query("SELECT mrfNumber,itemCode,qty,stockCategory FROM ss_material_inward WHERE toWh='".$wh."' AND flag='0'");
                                while($inItemRow = mysql_fetch_array($inItem)){
                                $result.='<tr>';
                                    $result.="<td ".hix(0,"").">".$inItemRow['mrfNumber']."</td>";
                                    $result.="<td ".hix(1,"").">".itemGetDesc($inItemRow['itemCode'])."</td>";
                                    $result.="<td ".hix(1,"").">".stockGetName($inItemRow['stockCategory'])."</td>";
                                    $result.="<td ".hix(0,"").">".$inItemRow['qty']."</td>";
                                $outItem = mysql_query("SELECT qty FROM ss_material_outward WHERE itemCode='".$inItemRow['itemCode']."' AND stockCategory='".$inItemRow['stockCategory']."' AND fromWh='".$wh."' AND flag='0'");
                                $qty=0;while($outItemRow = mysql_fetch_array($outItem)){$qty += $outItemRow['qty'];}
                                    $result.="<td ".hix(0,"").">".$qty."</td>";
                                    $result.="<td ".hix(0,"").">".($inItemRow['qty']-$qty)."</td>";
                                $result.="</tr>"; $a +=$inItemRow['qty'];  $b +=$qty; $c += ($inItemRow['qty']-$qty);
                                }
						$result.="<tr><td colspan='3'><b>Total</b></td><td><b>$a</b></td><td><b>$b</b></td><td><b>$c</b></td></tr>";		
                        $result.="</tbody>";
                        $result.="</table>";
                        echo $result;
                        ?>
                	</div>
            	</div>
        	</div><!-- Closing Of col-xs-12 -->
    	<div class="col-sm-1 hidden-xs"></div>
    </div>
</div><!-- Closing Of Body Container -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script> $(document).ready(function(){ $('.tooltips').tooltip(); }); </script>
  </body>
</html>
<?php }else{echo "<script type='text/javascript'>window.location='login.php'</script>";} ?>