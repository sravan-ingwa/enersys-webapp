<?php include('mysql.php');
$query=mysql_query("SELECT * FROM ss_company_details");
if(mysql_num_rows($query)>0){
	while($row=mysql_fetch_array($query)){
		$result.="<tr>";
		$result.="<td>$row[id]</td>";
		$result.="<td>$row[compName]</td>";
		$result.="<td><img src='../$row[logo]' width='200'></td>";
		$result.="<td><img src='../$row[favicon]' width='50' ></td>";
		$result.="<td>$row[status]</td>";
		$result.="<td>$row[flag]</td>";
		$result.="</tr>";
	}
}else{$result="<tr><td  colspan='6'>No results</td></tr>";}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <title></title>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body role="document">
    <?php include('header.php');?>
    <div class="container-fluid"><!-- Starting Of Body Container -->
        <div class="row">
            <div class="col-xs-1"></div>
            <div class="col-xs-10">
                <div class="panel panel-primary">
                	<div class="panel-heading"><h3 class="panel-title">Company Details</h3></div>
					<table class="table-responsive table table-bordered">
                    	<tr>
                        	<th>Id</th>
                            <th>company Name</th>
                            <th>Logo</th>
                            <th>Favicon</th>
                            <th>Status</th>
                            <th>Flag</th>
                        </tr>
                        <? if(isset($result))echo $result; ?>
                    </table>
                </div>            	
			</div>
            <div class="col-xs-1"></div>
        </div>
    </div><!-- Closing Of Body Container -->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.js"></script>
  </body>
</html>
