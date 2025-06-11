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
</head>
<body role="document">
<?php include('header.php');
$loginRole=loginDetails($_SESSION['login_user'],"role");
$email=$_SESSION['login_user'];
$query=mysql_query("SELECT * FROM ss_user_details WHERE email='".$email."'");
$row = mysql_fetch_array($query);
?>
<div class="container-fluid"><!-- Starting Of Body Container -->
    <div class="row">
        <div class="col-sm-1 hidden-xs"></div>
        	<div class="col-xs-12 col-sm-10">
            	<div class="panel panel-primary">
                	<div class="panel-heading">
                    	<h3 class="panel-title">Profile View</h3>
                    </div>
                	<div class="panel-body">
                        <div class="col-xs-12 col-sm-3 ">                    
                            <h2>Profile Image</h2>      
                            <img src="<?php echo $row['profileImage']; ?>" class="img-responsive" alt="">		            	
                        </div>
                        <div class="col-xs-12 col-sm-9 ">                    
                            <h2>Profile Details</h2>
                                <table class="table table-responsive">
                                 <tbody>
                                <tr>
                                   <td>Name : </td>
                                   <td><?php echo $row['displayName'] ?></td>
                                </tr>
                                <tr>
                                   <td>Email :</td>
                                   <td style="text-transform:lowercase;"><?php echo $row['email'] ?></td>
                                </tr>
                                <tr>
                                   <td>Role :</td>
                                   <td><?php echo roleGetName($row['role']); ?></td>
                                </tr>
                                <tr>
                                   <td>EmpId :</td>
                                   <td><?php   echo $row['empId'] ?></td>
                                </tr>
                                <tr>
                                   <td>Contact :</td>
                                   <td><?php echo $row['contact'] ?></td>
                                </tr>
                                <tr>
                                   <td>Created Date :</td>
                                   <td><?php echo date("jS M Y", strtotime($row['createdDate'])); ?></td>
                                </tr>
                               <?php 
                                $emp = $row['empId'];
                                $qur1=mysql_query("SELECT * FROM ss_employee_details WHERE employeeId='".$emp."'");
                                $row = mysql_fetch_array($qur1);
                              ?>
                                 <tr>
                                   <td>Designation: </td>
                                   <td><?php echo designationGetName($row['designation']); ?></td>
                                </tr>
                                
                                 <tr>
                                   <td>zones: </td>
                                   <td>
									<?php 
                                    $value=$row['zones'];
									$pos=strpos($value, ",");$finalValue='';
									if($pos === false){if(is_numeric($value))$finalValue=zoneGetName($value);else $finalValue = $value;}
									else{$tempvlue=explode(",",rtrim(str_replace(" ","",$value), ","));foreach ($tempvlue as $arva){$finalValue.= zoneGetName($arva).", ";}}
									echo rtrim($finalValue,", ");
								   
								   ?>
                                   </td>
                                </tr>
                                
                                 <tr>
                                   <td>circles: </td>
                                   <td>
								   <?php
									$pos=strpos($row['circles'], ",");$finalValue='';
									if($pos === false){if(is_numeric ($row['circles']))$finalValue = circleGetName($row['circles']);else{$finalValue = $row['circles'];}}
									else{$tempvlue=explode(",",rtrim(str_replace(" ","",$row['circles']), ","));foreach ($tempvlue as $arva){$finalValue.= circleGetName($arva).", ";}}
									echo rtrim($finalValue,", ");
								   ?>
								   </td>
                                </tr>
                                
                                 <tr>
                                   <td>clusters: </td>
                                   <td>
									<?php
									$value=$row['clusters'];
									$pos=strpos($value, ",");$finalValue='';
									if($pos === false){if(is_numeric($value))$finalValue=clustersGetName($value);else $finalValue = $value;}
									else{$tempvlue=explode(",",rtrim(str_replace(" ","",$value), ","));foreach ($tempvlue as $arva){$finalValue.= clustersGetName($arva).", ";}}
									echo rtrim($finalValue,", ");
								    ?>
                                   </td>
                                </tr>
                                
                                 <tr>
                                   <td>baseLocation: </td>
                                   <td><?php echo districtsGetName($row['baseLocation']); ?></td>
                                </tr>
                                
                                 <tr>
                                   <td>joiningDate: </td>
                                   <td><?php echo date("jS M Y", strtotime($row['joiningDate'])) ?></td>
                                </tr>
                                <tr>
                                   <td>relievingDate: </td>
                                   <td><?php if($row['relievingDate']!="0000-00-00")echo date("jS M Y", strtotime($row['relievingDate'])); else echo "Not Available";?></td>
                                </tr>
                                <tr>
                                   <td>createdBy: </td>
                                   <td><?php echo $row['createdBy'] ?></td>
                                </tr>
                                <tr>
                                   <td>employeeRole: </td>
                                   <td><?php echo employeeRoleGetName($row['employeeRole']); ?></td>
                                </tr>
                                
                                </tbody>
                                </table>  	            	
                        </div>
                	</div>
            	</div>
        	</div><!-- Closing Of col-xs-12 -->
    	<div class="col-sm-1 hidden-xs"></div>
    </div>
</div><!-- Closing Of Body Container -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>$('.tooltips').tooltip();</script> 
