<?php include('lock.php'); include('functions.php'); ?>
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
<style>
.carousel-control {
  top: 86px !important;
  width: 11% !important;	
	}
</style>
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
        	<div class="col-xs-12 col-sm-10" id="ss_form">
            	<div id="myText">&nbsp;</div>
                <div class="panel panel-primary">
                	<div class="panel-heading">
                    	<h3 class="panel-title pull-left">View <?php echo menuName($_REQUEST['x'],"menu"); ?></h3>
                        <ul class="nav nav-pills pull-right splnav">
						<?php
                        $tableName= menuName($_REQUEST['x'],"tbName");
                        $querycc = mysql_query("SELECT * FROM $tableName WHERE id='".$_REQUEST['y']."' AND  flag='0'");
                        $rowxx=mysql_fetch_array($querycc);
                         if($rowxx['designation']!='NATIONAL HEAD SERVICE' && $rowxx['designation']!='ZONAL TEAM'){?>
                            <li><a href="download.php?x=<? echo $_REQUEST['x'];?>&y=<? echo $_REQUEST['y'];?>" target="_blank" class="tooltips" data-placement="top" title="Download"><span class="glyphicon glyphicon-download-alt"></span></a></li>
						<?php }?>
                        </ul>
                      <div class="clearfix"></div>
                    </div>
                  <?php if(isset($_REQUEST['ref']))echo '<p class="errorP">Ticket Registered! Below are the details</p>';?>
<div class="panel-body ss_form printable">
	<div class="row">
        <div class="col-md-12 expen">
			<?php $qu = mysql_query("SELECT * FROM $tableName WHERE id='".$_REQUEST['y']."' AND  flag='0'"); $ro=mysql_fetch_array($qu); ?>
              <ul class="col-md-3 col-xs-3"><li><label class="blue-color"> Employee ID</label></li><li><?php echo employeeGetName($ro['empId']); ?></li></ul>
              <ul class="col-md-2 col-xs-2"><li><label class="blue-color"> Employee Name</label></li><li><?php echo $ro['empName']; ?></li></ul>
              <ul class="col-md-2 col-xs-2"><li><label class="blue-color"> F1 Balance</label></li><li><?php echo $ro['f1Balance']; ?></li></ul>
              <ul class="col-md-2 col-xs-2"><li><label class="blue-color"> F2 Balance</label></li><li><?php echo $ro['f2Balance']; ?></li></ul>
              <ul class="col-md-3 col-xs-2"><li><label class="blue-color"> Total Balance</label></li><li><?php echo $ro['totalBalance']; ?></li></ul>
        </div><br /><br /><br />
<div class="col-md-2 pull-right" style="margin-right:30px;">
<select class="form-control" id="dropYear"><?php for($i = date("Y"); $i > date("Y")-5 ; $i--){ echo "<option value='$i'>$i</option>"; } ?></select>
<input type="hidden" id="empid" value="<?php echo $ro['empId']; ?>"/>
<br /></div></div>
  	<!-- thumb navigation carousel -->
    <div class="col-md-12 hidden-xs" id="slider-thumbs">
        <!-- thumb navigation carousel items -->
      <ul class="list-inline row">
		<?php $arrM = array("April","May","June","July","August","September","October","November","December","January","February","March");
		foreach($arrM as $a=>$b){ echo '<li class="col-md-1 col-sm-2 lst"><a id="carousel-selector-'.$a.'"'.($b==date('F') ? 'class="selected active"': '' ).'><span>'.$b.'</span></a></li>'; } ?>
      </ul>
    </div>
<div class="clear"></div>
<!-- main slider carousel -->
	<div class="row">
		<div id="slider">
			<div id="carousel-bounding-box">
				<div id="myCarousel" class="carousel slide">
					<!-- main slider carousel items -->
					<div class="carousel-inner" id="dataLoad">
                        <?php $arrF = array("F1","F2"); $ye = date("Y");
						foreach($arrM as $a=>$b){  
                            echo '<div class="'.($b==date('F') ? 'active item row' : 'item').'">';
							foreach($arrF as $aF){ $req=0; $clr=0; $netExp=0; ?>
                            <div class="col-md-6 col-xs-6">
                          	<div class="row">
                            <?php if($aF == 'F1'){ echo '<div class="col-md-2"></div>'; } ?>
                            <div class="col-md-10">
	                        <?php $sqlf1 = mysql_query("SELECT * FROM ss_book_advance WHERE empId='$ro[empId]' AND advFor='$aF' AND year='$b-$ye' AND stat='2' AND flag='0'");
							while($rowf1=mysql_fetch_array($sqlf1)){ $req += $rowf1['advRequested']; $clr += $rowf1['advCleared'];}
							$sqlexp = mysql_query("SELECT * FROM ss_book_expenses WHERE empId='$ro[empId]' AND period='$aF $b $ye' AND stat='2' AND flag='0'");
							while($rowexp=mysql_fetch_array($sqlexp)){$netExp += $rowexp['netExpensesBooked'];} ?>
                            <h3 class="blue-color"><?php echo "$b-$ye $aF"; ?> Balance</h3>
					            <table class="table table-responsive table-hover ">
                                    <tr><td><span>Advance Requested</span></td><td><?php echo ($req ? $req : 0); ?></td></tr>
                                    <tr><td><span>Advance Given</span></td><td><?php echo ($clr ? $clr : 0); ?></td></tr>
                                    <tr><td><span>Bills Submitted</span></td><td><?php echo ($netExp ? $netExp : 0); ?></td></tr>
									<tr><td><span><b>Balance</b></span></td><td><b><?php echo ($clr || $netExp ? $clr-$netExp : 0); ?></b></td></tr>
                                </table></div>
                                <?php if($aF == 'F2'){ echo '<div class="col-md-2 hidden-xs"></div>'; } ?>
                                </div></div>
                                <?php } ?>
                            </div>
						<?php } ?>
					</div>
                    <!-- main slider carousel nav controls -->
                    <a class="carousel-control left size" href="#myCarousel" data-slide="prev" data-interval="false">‹</a>
                    <a class="carousel-control right size" href="#myCarousel" data-slide="next" data-interval="false">›</a>
				</div>
			</div>
		</div>
	</div>
</div>
</div></div>
<!-- Closing Of col-xs-12 -->
<div class="col-sm-1 hidden-xs"></div></div></div>
<!-- Closing Of Body Container -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/mail-confirmation.js"></script>
<script src="js/bootstrap-confirmation.js"></script>
<script>
	$(document).ready(function(){
		$('.tooltips').tooltip();
		$('[data-toggle="confirmation-popout"]').confirmation({popout: true});
		$('[data-toggle="confirmation"]').confirmationx({popout: true});
	});
</script>
<script src="js/bootstrap.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
	$('#myCarousel').carousel({interval: false});
		// handles the carousel thumbnails
	$('[id^=carousel-selector-]').click( function(){
		var id_selector = $(this).attr("id");
		var id = id_selector.substr(18);
		//if(id_selector.length == 20){  var id = id_selector.substr(id_selector.length -2);}
		id = parseInt(id);
		$('#myCarousel').carousel(id);
		$('[id^=carousel-selector-]').removeClass('selected');
		$(this).addClass('selected');
	});
	$(document).on('click.bs.carousel.data-api', '[data-slide], [data-slide-to]', function (e) {
		if($(this).attr('data-slide')=='next'){
			var arr = {"April":"1","May":"2","June":"3","July":"4","August":"5","September":"6","October":"7","November":"8","December":"9","January":"10","February":"11","March":"0"}
		}else{arr = {"April":"11","May":"0","June":"1","July":"2","August":"3","September":"4","October":"5","November":"6","December":"7","January":"8","February":"9","March":"10"}}
		var cc = $('.active').find('.blue-color').html();
		var dd = cc.split('-');
		$.each(arr,function(k,v){
			if(k==dd[0]){					
				$('[id^=carousel-selector-]').removeClass('selected');
				$('#carousel-selector-'+v).addClass('selected');
			}
		});
	});
</script>
<script>
$(function(){$('#dropYear').change(function(){ $('#dataLoad').load('ajaxViewExpense.php?year='+$(this).val()+'&empid='+$('#empid').val()+'&act='+$('.selected').attr('id').substr(18)); }); });
</script>
</body>
</html>