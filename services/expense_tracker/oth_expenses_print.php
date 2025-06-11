<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
$stylesheet = file_get_contents('../../styles/pdf_style.css');
include('../mpdf60/mpdf.php');
$mpdf=new mPDF('','', 0, '', 8, 8, 30, 15, '5', '', '');
$heading = 'EXPENSES';
$download="";
$tbl_start = "<table class='table1'><tr>";
$alias = $_REQUEST['alias'];
$resultz=expensefullView($alias);
	if($resultz!=""){
		$download.="<table width='100%' class='cont_2'><tr>";
		$download.="<td width='60%'><b>".strtoupper('Bill Number').":</b>".checkempty(ucfirst($resultz[0]['bill_number']))."</td>";
		$download.="<td><b>".ucfirst('PO /GR Number').": </b>".checkempty(ucfirst($resultz[0]['po_gnr']))."</td></tr>";
		$download.="<tr><td><b>".strtoupper('Date of Request'). ": </b>".checkempty(dateFormat($resultz[0]['requested_date'],'d'));
		$download.="<td><b>".ucfirst('Employee ID').": </b>".checkempty(ucfirst(employeeDetails('employee_id',$resultz[0]['employee_alias'])))."</td></tr>";
		$download.="<tr><td><b>".strtoupper('Employee Name'). ": </b>".checkempty(ucfirst(employeeDetails('name',$resultz[0]['employee_alias'])))."</td>";
		$download.="<td><b>".ucfirst('Grade')." : </b>".checkempty(ucfirst(alias(employeeDetails('designation_alias',$resultz[0]['employee_alias']),'ec_designation','designation_alias','grade')))."</td></tr>";
		$download.="<tr><td><b>".ucfirst('Period Of Visit From')." : </b>".checkempty(dateFormat($resultz[0]['period_of_visit_from'],'d'))."</td>";
		$download.="<td><b>".ucfirst('Period Of Visit To')." : </b>".checkempty(dateFormat($resultz[0]['period_of_visit_to'],'d'))."</td></tr>";
		$download.="<tr><td><b>".ucfirst('Places Of Visit')." : </b>".checkempty(ucfirst($resultz[0]['places_of_visit']))."</td>";
		$download.="<td><b>".ucfirst('Purpose')." : </b>".checkempty(ucfirst($resultz[0]['purpose']))."</td></tr></table>";					
			// conveyance
			$csql=mysqli_query($mr_con,"SELECT expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,document_link,created_date,dpr_number,ticket_alias FROM ec_conveyance WHERE expenses_alias='$alias' AND flag=0");
			$csum=mysqli_query($mr_con,"SELECT sum(amount) FROM ec_conveyance WHERE expenses_alias='$alias' AND flag=0");
			$csum_row=mysqli_fetch_array($csum);
			$con_count = mysqli_num_rows($csql);
			$result['exp_conveyance']=array();
			$result['exp_con_count']=$con_count;
			if(mysqli_num_rows($csql)){
			$i=0;
			$tot_con_amt ='';
			
			while($row = mysqli_fetch_array($csql)){
				$expenses_alias=$row['expenses_alias'];	
				$date_of_travel=dateFormat($row['date_of_travel'],'d');				
				$mode_of_travel=$row['mode_of_travel'];
				$from_place=$row['from_place'];
				$to_place=$row['to_place'];
				$amount=$row['amount'];
				if($row['document_link']!=='0'){$con_link=$row['document_link'];}else{$con_link='';}
				$document_link=$con_link[$i];
				
				$download.="<h4 class='cont_3'>Conveyance".($i+1)." : </h4>
				<table class='cont_2'>
					<tr>
                    	<td width='25%'><h3>Date Of Travel </h3>".checkempty($date_of_travel)."</td>
                        <td width='25%'><h3>Mode Of Travel </h3>".checkempty(ucfirst($mode_of_travel))."</td>
                        <td width='25%'><h3>From </h3>".checkempty(ucfirst($from_place))."</td>
                        <td width='25%'><h3>To </h3>".checkempty(ucfirst($to_place))."</td>
                	</tr>
					<tr>                    	
                        <td width='25%'><h3>Amount</h3>".checkempty($amount)."</td>
                        <td width='25%'></td>
						<td width='25%'></td>
                        <td width='25%'></td>
                	</tr>
				</table><br>";
			$i++;
			}
				$download.="<div class='alinR'>Total : <b> Rs.".$csum_row[0]." </b></div>";
			}
			
			
			
		//local conveyance		
		$lcsql=mysqli_query($mr_con,"SELECT expenses_alias,date_of_travel,mode_of_travel,from_place,to_place,amount,alias,created_date,zone_alias,state_alias,district_alias,bucket,capacity,quantity,km,dpr_number,ticket_alias FROM ec_localconveyance WHERE expenses_alias='$alias' AND flag=0");
		$lcsum=mysqli_query($mr_con,"SELECT sum(amount) FROM ec_localconveyance WHERE expenses_alias='$alias' AND flag=0");
		$lcsum_row=mysqli_fetch_array($lcsum);
		$lcon_count = mysqli_num_rows($lcsql);
		$result['exp_locconveyance']=array();
		$result['exp_lcon_count']=$lcon_count;
		if(mysqli_num_rows($lcsql)){			
			$i=0;			
			while($lrow = mysqli_fetch_array($lcsql)){
				$expenses_alias=$lrow['expenses_alias'];	
				$date_of_travel=dateFormat($lrow['date_of_travel'],'d');				
				$mode_of_travel=$lrow['mode_of_travel'];
				$from_place=$lrow['from_place'];
				$to_place=$lrow['to_place'];
				$amount=$lrow['amount'];
				$created_date=$lrow['created_date'];
			
			$download.="<h4 class='cont_3'>Local Conveyance".($i+1)." : </h4>
			<table class='cont_2'>
					<tr>
                        <td width='25%'><h3>Date of Travel </h3>".checkempty($date_of_travel)."</td>
                        <td width='25%'><h3>Mode of Travel </h3>".checkempty(ucfirst($mode_of_travel))."</td>
                        <td width='25%'><h3>From </h3>".checkempty(ucfirst($from_place))."</td>
                        <td width='25%'><h3>To </h3>".checkempty(ucfirst($to_place))."</td>
                   	</tr>
					<tr>
                        <td width='25%'><h3>Amount </h3>".checkempty($amount)."</td>
                        <td width='25%'></td>
                        <td width='25%'></td>
                        <td width='25%'></td>
                   	</tr>
				</table>";
				$i++;
				
			}
				$download.="<div class='alinR'>Total : <b> Rs.".$lcsum_row[0]." </b></div>";
		}
			
			
		// lodging
		$lod_sql=mysqli_query($mr_con,"SELECT expenses_alias,type_of_stay,check_in,check_out,hotel_name,amount,alias,document_link,created_date,zone_alias,state_alias,district_alias,dpr_number,ticket_alias FROM ec_lodging WHERE expenses_alias='$alias' AND flag=0");
		$lodsum=mysqli_query($mr_con,"SELECT sum(amount) FROM ec_lodging WHERE expenses_alias='$alias' AND flag=0");
		$lodsum_row=mysqli_fetch_array($lodsum);
		
		$lod_count = mysqli_num_rows($lod_sql);
		$result['exp_lodging']=array();
		$result['exp_lod_count']=$lod_count;
		if(mysqli_num_rows($lod_sql)){
			$i=0;
			while($lod_row = mysqli_fetch_array($lod_sql)){
				$expenses_alias=$lod_row['expenses_alias'];	
				$type_of_stay=$lod_row['type_of_stay'];				
				$check_in=dateFormat($lod_row['check_in'],'d');
				$check_out=dateFormat($lod_row['check_out'],'d');
				$hotel_name=$lod_row['hotel_name'];
				$amount=$lod_row['amount'];
				if($lod_row['document_link']!=='0'){$lod_link=$lod_row['document_link'];}else{$lod_link='';}
				$document_link=$lod_link;
				$created_date =$lod_row['created_date'];
				
			$download.="<h4 class='cont_3'>Lodging".($i+1)." : </h4>
					<table class='cont_2'>
					<tr>
                        <td width='25%'><h3>Type Of Stay </h3>".checkempty($type_of_stay)."</td>
                        <td width='25%'><h3>Check in Date </h3>".checkempty($check_in)."</td>
                        <td width='25%'><h3>Check out Date</h3>".checkempty($check_out)."</td>
                        <td width='25%'><h3>Hotel Name </h3>".checkempty(ucfirst($hotel_name))."</td>
                   	</tr>
					<tr>
                        <td width='25%'><h3>Amount</h3>".checkempty($amount)."</td>
                        <td width='25%'></td>
						<td width='25%'></td>
                        <td width='25%'></td>
                   	</tr>
				</table>";
		
				$i++;
				
			}
				$download.="<div class='alinR'>Total : <b> Rs.".$lodsum_row[0]." </b></div>";
		
		}
		
		
		// Boarding
		$bod_sql=mysqli_query($mr_con,"SELECT expenses_alias,check_in,check_out,state,amount,alias,created_date,zone_alias,state_alias,district_alias,dpr_number,ticket_alias FROM ec_boarding WHERE expenses_alias='$alias' AND flag=0");
		$bodsum=mysqli_query($mr_con,"SELECT sum(amount) FROM ec_boarding WHERE expenses_alias='$alias' AND flag=0");
		$bodsum_row=mysqli_fetch_array($bodsum);
		
		$bod_count = mysqli_num_rows($bod_sql);
		$result['exp_boarding']=array();
		$result['exp_bod_count']=$bod_count;
		if(mysqli_num_rows($bod_sql)){
			$i=0;
			$tot_bod_amt ='';
					
			while($bod_row = mysqli_fetch_array($bod_sql)){
				$expenses_alias=$bod_row['expenses_alias'];	
				$check_in=dateFormat($bod_row['check_in'],'d');
				$check_out=dateFormat($bod_row['check_out'],'d');
				
				if($bod_row['state'] == 'a1'){$state='A+';}else if($bod_row['state'] == 'a'){$state='A';}else if($bod_row['state'] == 'b'){$state='B';}else if($bod_row['state'] == 'c'){$state='C';}else{$state="";}
				$amount=$bod_row['amount'];
				$created_date=$bod_row['created_date'];
				$download.="<h4 class='cont_3'>Boarding".($i+1)." : </h4>
					<table class='cont_2'>
					<tr>
                        <td width='25%'><h3>Check in Date </h3>".checkempty($check_in)."</td>
                        <td width='25%'><h3>Check out Date </h3>".checkempty($check_out)."</td>
                        <td width='25%'><h3>State</h3>".checkempty($state)."</td>
                        <td width='25%'><h3>Amount </h3>".checkempty($amount)."</td>
                   	</tr>
				</table>";
				
				$i++;
				
			}
			$download.="<div class='alinR'>Total : <b> Rs. ".$bodsum_row[0]."</b></div>";
		}
		
		
		// Others
		$oth_sql=mysqli_query($mr_con,"SELECT expenses_alias,description,amount,checked_date,alias,document_link,created_date,dpr_number,ticket_alias FROM ec_other_expenses WHERE  expenses_alias='$alias' AND flag=0");
		$othsum=mysqli_query($mr_con,"SELECT sum(amount) FROM ec_other_expenses WHERE expenses_alias='$alias' AND flag=0");
		$othsum_row=mysqli_fetch_array($othsum);
		$oth_count = mysqli_num_rows($oth_sql);
		$result['exp_others']=array();
		$result['exp_oth_count']=$oth_count;
		if(mysqli_num_rows($oth_sql)){
			$i=0;
			while($oth_row = mysqli_fetch_array($oth_sql)){
				$expenses_alias=$oth_row['expenses_alias'];	
				$description=$oth_row['description'];
				$checked_date=dateFormat($oth_row['checked_date'],'d');
				if($oth_row['document_link']!=='0'){$oth_link=$oth_row['document_link'];}else{$oth_link='';}
				$document_link=$oth_link;
				$amount=$oth_row['amount'];
				$created_date=$oth_row['created_date'];
				
			$download.="<h4 class='cont_3'>Other Expenses".($i+1)." : </h4>
					<table class='cont_2'>
					<tr>
                        <td width='25%'><h3>Description </h3>".checkempty(ucfirst($description))."</td>
                        <td width='25%'><h3>Date </h3>".checkempty($checked_date)."</td>
                        <td width='25%'><h3>Amount </h3>".checkempty($amount)."</td>
						 <td width='25%'></td>
                   	</tr>
				</table>";
				$i++;
				
			}
				$download.="<div class='alinR'>Total : <b> Rs.".$othsum_row[0]."</b></div>";
		}
		
		$grandtot=$csum_row[0]+$lcsum_row[0]+$lodsum_row[0]+$bodsum_row[0]+$othsum_row[0];
		$download.='<table align="right" style="margin-right:5px;">
					<tr><td align="right">Grand Total : &nbsp;<b>Rs. '.$grandtot.'</b></td></tr>
				</table>';
				
				
				$download.="<h4 class='cont_3'>Summery </h4>
					<table class='cont_2'>
						<tr><td width='50%'><h3>Total Conveyance Amount: ".($csum_row[0]=='' || $csum_row[0]=='0' ? '0' : $csum_row[0])."</h3></td>
                        <td width='50%'><h3>Total Local Conveyance Amount: ".($lcsum_row[0]=='' || $lcsum_row[0]=='0' ? 0 : $lcsum_row[0])."</h3></td></tr>
                        <tr><td width='50%'><h3>Total Lodging Amount: ".($lodsum_row[0]=='' || $lodsum_row[0]=='0'? 0 : $lodsum_row[0])."</h3></td>
                        <td width='50%'><h3>Total Boarding Amount: ".($bodsum_row[0]=='' || $bodsum_row[0]=='0' ? '0' : $bodsum_row[0])."</h3></td></tr>
						<tr><td width='50%'><h3>Total Others Amount: ".($othsum_row[0]=='' || $othsum_row[0]=='0' ? '0' : $othsum_row[0])."</h3></td>
						
						<td width='50%'><h3>Grand Total : &nbsp;<b>Rs. ".$grandtot."</h3></b></td></tr>
				</table>";
				
		$download1.="<table class='cont_2' style='height:200px'><tr><td>(".employeeDetails('name',$resultz[0]['employee_alias']).")<br><b>Client Signature</b>";
		$download1.='</td><td align="center"><p style=\"text-align:center;font-style: italic;font-size:12px;\">Page No : {PAGENO}/{nbpg}</p></td><td align="right">('.hodname($resultz[0]['employee_alias']).')<br><b>Signature of HOD</b></td></tr></table>';
		$download.='</td></tr></table></body></html>';
	}else{$download='<h2 style="text-align:center">No Records<h2>';}
	$mpdf->SetHTMLHeader("<table class='tableHeader' width='100%'><tr><td align='left' width='30%'><img src='../../images/gallery/logo1.png'></td><td align='center' width='40%'><h2>".$heading."</h2></td><td align='right' width='30%'><img src='../../images/gallery/logo-4.jpg' width='100px'></td></tr></table><br><br>");
	$mpdf->SetHTMLFooter($download1);
	//$mpdf->SetHTMLFooter("<p style=\"text-align:right;font-style: italic;font-size:12px;\">{PAGENO}/{nbpg}</p>");	
	$mpdf->SetWatermarkImage('../../images/gallery/logo-3.png');
	$mpdf->showWatermarkImage = true;
	$mpdf->watermarkImageAlpha = 0.05;
	$mpdf->SetJS('this.print();');
	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($download,2);
	
	$mpdf->Output();
	exit;
?>