<?php 
include('../lock.php'); 
include('../functions.php');
$comp=mysql_query("SELECT * FROM ss_company_details WHERE status='active'");
$comprow=mysql_fetch_array($comp);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php TitleFav();?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link href="../css/bootstrap.css" rel="stylesheet">
<link href="../css/main.css" rel="stylesheet">
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<style>
body{
background: #428bca;
}
</style>
</head>
  <body>
<img src="../img/world.png" style="position:absolute;margin-top:-20%;z-index:9;" width="80%;"  data-animation="bounceIn" class="hidden-xs hidden-sm">
<div style="width:100%;height:100%;z-index:999;">
 <p align="center"><img src="../<? if($comprow['logo']){echo $comprow['logo'];}?>" alt="<? if($comprow['compName']){echo $comprow['compName'];}?>" class="img-responsive"></p>
</div>
  </body>
</html>