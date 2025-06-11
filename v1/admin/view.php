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
        	<div class="col-xs-12 col-sm-10" id="ss_form">
            	<div id="myText">&nbsp;</div>
                <div class="panel panel-primary">
                	<div class="panel-heading">
                    	<h3 class="panel-title pull-left">View <?php echo menuName($_REQUEST['x'],"menu"); ?></h3>
                        <input type="hidden" id="x" value="<?php echo $_REQUEST['x']; ?>"/>
                        <input type="hidden" id="y" value="<?php echo $_REQUEST['y']; ?>"/>
                        <ul class="nav nav-pills pull-right splnav">
						<?php
                        $tableName= menuName($_REQUEST['x'],"tbName");							
                        $querycc = mysql_query("SELECT * FROM $tableName WHERE id='".$_REQUEST['y']."' AND  flag='0'");
                        $rowxx=mysql_fetch_array($querycc);
                         if($rowxx['designation']!='NATIONAL HEAD SERVICE' && $rowxx['designation']!='ZONAL TEAM'){?>
					<?php if($_REQUEST['x'] == 2432){ ?><li <?php if($path=="advanceEdit") echo 'class="active"'; ?>><a href="advanceEdit.php?x=<? echo $_REQUEST['x'];?>&y=<? echo $_REQUEST['y'];?>" class="tooltips" data-placement="top" title="Advance Edit" id="Advance Edit"><span class="glyphicon glyphicon-wrench hidden-xs"></span></a></li><?php }?>
                            <li><a href="edit.php?x=<? echo $_REQUEST['x'];?>&y=<? echo $_REQUEST['y'];?>" class="tooltips" data-placement="top" title="Edit" id="Edit"><span class="glyphicon glyphicon-edit"></span></a></li>
                            <li><a href="print.php?x=<? echo $_REQUEST['x'];?>&y=<? echo $_REQUEST['y'];?>" class="tooltips" data-placement="top" title="Print" ><span class="glyphicon glyphicon-print"></span></a></li>
                            <li><a class="popconfirm deletePop tooltips" data="<?php echo $_REQUEST['x'].'-'.$_REQUEST['y']; ?>" data-toggle="confirmationx" data-placement="top" title="Delete"><i class="glyphicon glyphicon-trash"></i></a></li>
                            <li><a href="download.php?x=<? echo $_REQUEST['x'];?>&y=<? echo $_REQUEST['y'];?>" target="_blank" class="tooltips" data-placement="top" title="Download"><span class="glyphicon glyphicon-download-alt"></span></a></li>
                            <li><a  class="popconfirmMail mailSendPop tooltips" data="<?php echo $_REQUEST['x'].'-'.$_REQUEST['y']; ?>" data-placement="top" title="Send"><i class="glyphicon glyphicon-send"></i></a></li>
							<?php /*?><li><a href="#" class="tooltips" data-placement="left" data-conttent="<?php echo $_REQUEST['x'].'-'.$_REQUEST['y']; ?>" data-toggle="confirmation-popout" title="Delete"><span class="glyphicon glyphicon-trash"></span></a></li>
                            <li><a href="" class="tooltips" data-toggle="confirmation" data-placement="bottom"><span class="glyphicon glyphicon-send"></span></a></li><?php */?>
						<?php }?>
                        </ul>
                        <div class="clearfix" ></div>
                    </div>
                    <?php if(isset($_REQUEST['ref'])){echo '<p class="errorP">Ticket Registered! Below are the details</p>';
					echo "<script>setTimeout(function(){ document.location = 'create.php?x=2432';}, 6000 ); </script>";	} ?>
                	<div class="panel-body ss_form printable">
						<?php
						if($_REQUEST['x']!=5484){
						$tableName= menuName($_REQUEST['x'],"tbName");
						if($tableName =="ss_user_role"){include('include/ss_user_role_view.php');}
						elseif($tableName =="ss_revival"){include('include/ss_revival_view.php');}
						elseif($tableName =="ss_refreshing"){include('include/ss_refreshing_view.php');}
                        else{
                        $query = mysql_query("SELECT colName,colRef FROM ss_col_ref WHERE tbName='$tableName' AND pView='0' ORDER BY ordering");
                        if(mysql_num_rows($query)>0){$colName=array();$colref=array();
                        	while($row=mysql_fetch_array($query)){$colName[]=$row['colName'];$colref[]=$row['colRef'];}
                        	$query = mysql_query("SELECT * FROM $tableName WHERE id='".$_REQUEST['y']."' AND  flag='0'");
                        	if(mysql_num_rows($query)>0){
                        		while($row=mysql_fetch_array($query)){
                        			for($af=0;$af<count($colName);$af++){
	                        		 if($row[$colName[$af]]!=""){echo "<div class='form-group col-md-4 col-xs-6'><label class='control-label'>".$colref[$af]."</label><p class='form-control-static ".hix($row[$colName[$af]])."' style='margin:0;height:auto;word-wrap:break-word;'>". refname($colref[$af],$row[$colName[$af]],$row['id'])."</p></div>";	}							
                        			}
                        		}
							}
                        	}
                        }}else{ echo "<script>window.location='viewExpense.php?x=$_REQUEST[x]&y=$_REQUEST[y]'</script>";}
                        ?>
                	</div>
            	</div>
        	</div><!-- Closing Of col-xs-12 -->
    	<div class="col-sm-1 hidden-xs"></div>
    </div>
</div><!-- Closing Of Body Container -->
	<script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery.popconfirm.js"></script>
	<script type="text/javascript" src="js/jquery.popconfirmMail.js"></script>
	<script type="text/javascript">
	$(function(){
		$('.deletePop').click(function() {
			$.ajax({
					type: "POST",
					url: "delete.php",
					data: 'del='+$(this).attr('data'),
					cache: false,
					success: function(result){
						document.getElementById("myText").innerHTML = "<div class='alert alert-success' role='alert'>Successfully Deleted</div>";
						setTimeout(function(){window.location='index.php?x='+result;}, 1000);
					/*location.reload();*/ }
				});
		});
	});
</script>
<script>
	$(function(){
		$('.mailSendPop').click(function(){
			var send = document.getElementById('send').value;
			var x = document.getElementById('x').value;
			var y = document.getElementById('y').value;
			$('#myText').html('<div class="alert alert-success" role="alert">Mail Successfully Sent to '+send+'</div>');
			$.ajax({
					type: "POST",
					url: "mail.php",
					data: 'send='+send+'&x='+x+'&y='+y,
					cache: false,
					success: function(result){}
				});
			});
});
</script>
<script type="text/javascript">	$(function(){$(".popconfirm").popConfirm();});</script>
<script type="text/javascript">	$(function(){$(".popconfirmMail").popConfirmMail();});</script>
<script>
	$(document).ready(function(){
		$('.tooltips').tooltip();
	 });
    </script>
<!--	<script src="js/mail-confirmation.js"></script>
    <script src="js/bootstrap-confirmation.js"></script>
    <script>
	$(document).ready(function(){
		$('.tooltips').tooltip();
		$('[data-toggle="confirmation-popout"]').confirmation({popout: true});
		$('[data-toggle="confirmation"]').confirmationx({popout: true});
	 });
    </script>-->
  </body>
</html>
