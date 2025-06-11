<?php include('lock.php'); include('functions.php');?>
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
<style>
.fileUpload { position: relative; overflow: hidden; }
.fileUpload input.upload { position:absolute; top:0; right:0; margin:0; padding:0; cursor:pointer; opacity:0; }
</style>
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
                            <h3 class="panel-title">Import <?php echo menuName($_REQUEST['x'],"menu"); ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php
                            $ref=$_REQUEST['x'];
                            $query=mysql_query("SELECT * FROM ss_menu WHERE id='$ref'");
                            if(mysql_num_rows($query)>0){
                                $row=mysql_fetch_array($query);
                                include('include/'.$row['tbName'].'_import.php');
                            }
                            ?>
							<a href="#" class="back-to-top"><i class="glyphicon glyphicon-chevron-up"></i></a>
                        </div>
                    </div>
                </div><!-- Closing Of col-xs-12 -->
            <div class="col-sm-1 hidden-xs"></div>
        </div>
    </div><!-- Closing Of Body Container -->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>            
			jQuery(document).ready(function() {
				var offset = 100;
				var duration = 500;
				jQuery(window).scroll(function() {
					if (jQuery(this).scrollTop() > offset) {
						jQuery('.back-to-top').fadeIn(duration);
					} else {
						jQuery('.back-to-top').fadeOut(duration);
					}
				});
				
				jQuery('.back-to-top').click(function(event) {
					event.preventDefault();
					jQuery('html, body').animate({scrollTop: 0}, duration);
					return false;
				})
			});
		</script>
<script>
$(function(){
	$('.upload').change(function(){
		$('.hid').css('display','none');
		//var nam = $('.import').html();
		var sp = $(this).val().split("fakepath");
		$('.errorP').html("Click Submit Button to import <span style='color:red'>"+sp[1]+"</span> file");
		});
});
</script>
</body>
</html>