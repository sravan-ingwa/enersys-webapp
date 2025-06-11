<?php
date_default_timezone_set("Asia/Kolkata");
include('../mysql.php');
include('../functions.php');
$stylesheet = file_get_contents('../../styles/pdf_style.css');
include('../mpdf60/mpdf.php');
$mpdf=new mPDF('','', 0, '', 8, 8, 30, 8, '5', '', '');
$heading = 'EXPENSES';
$download="";
$tbl_start = "<table class='table1'><tr>";
$alias = $_REQUEST['alias'];
$resultz=expensefullView($alias);
	if($resultz!=""){
		$download.="<table width='100%' class='cont_2'><tr>";
		$download.="<td width='60%'><b>".strtoupper('Bill Number').":</b>".checkempty(ucfirst($resultz[0]['bill_number']))."</td>";
		$download.="<td><b>".ucfirst('PO /GR Number').": </b>".checkempty(ucfirst($resultz[0]['po_gnr']))."</td></tr>";
		$download.="<tr><td><b>".strtoupper('Date of Request'). ": </b>".checkempty(ucfirst($resultz[0]['requested_date']));
		$download.="<td><b>".ucfirst('Employee ID').": </b>".checkempty(ucfirst(employeeDetails('employee_id',$resultz[0]['employee_alias'])))."</td></tr>";
		$download.="<tr><td><b>".strtoupper('Employee Name'). ": </b>".checkempty(ucfirst(employeeDetails('name',$resultz[0]['employee_alias'])))."</td>";
		$download.="<td><b>".ucfirst('Grade')." : </b>".checkempty(ucfirst(alias(employeeDetails('designation_alias',$resultz[0]['employee_alias']),'ec_designation','designation_alias','grade')))."</td></tr>";
		$download.="<tr><td><b>".ucfirst('Period Of Visit To')." : </b>".checkempty(ucfirst($resultz[0]['period_of_visit_to']))."</td>";
		$download.="<td><b>".ucfirst('Period Of Visit To')." : </b>".checkempty(ucfirst($resultz[0]['period_of_visit_to']))."</td></tr>";
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
			$i=0;while($row = mysqli_fetch_array($csql)){
				$expenses_alias=$row['expenses_alias'];	
				$date_of_travel=$row['date_of_travel'];				
				$mode_of_travel=$row['mode_of_travel'];
				$from_place=$row['from_place'];
				$to_place=$row['to_place'];
				$amount=$row['amount'];
				if($row['document_link']!=='0'){$con_link=urllink($row['created_date']).$row['document_link'];}else{$con_link='';}
				if($row['dpr_number'] != '') $con_dpr = $row['dpr_number'];else $con_dpr = '--';
				$dpr_number[$i]=$con_dpr;
				if($row['ticket_alias'] != ''){ if($row['ticket_alias'] == "1") 
				$con_ticket_name="Others"; else $con_ticket_name=getTicketName($row['ticket_alias']);}else {$con_ticket_name='--';}
				$ticket_alias=$con_ticket_name;
				$tot_con_amt+=$row['amount'];
				$download.="<h4 class='cont_3'>Conveyance".($i+1)." : </h4>
				<table class='cont_2'>
					<tr>
                    	<td width='25%'><h3>Date Of Travel </h3>".checkempty($date_of_travel)."</td>
                        <td width='25%'><h3>Mode Of Travel </h3>".checkempty(ucfirst($mode_of_travel))."</td>
                        <td width='25%'><h3>From </h3>".checkempty(ucfirst($from_place))."</td>
                        <td width='25%'><h3>To </h3>".checkempty(ucfirst($to_place))."</td>
                	</tr>
					<tr>
                    	<td width='25%'><h3>Ticket Id</h3>".checkempty($ticket_alias)."</td>
                        <td width='25%'><h3>Dpr Number</h3>".checkempty($con_dpr)."</td>";
						if($con_link !='')
                    	$download.="<td width='25%'><h3>Files</h3><a href=".$con_link.">Click Here</a></td>";
						else $download.="<td width='25%'><h3>Files</h3>-NA-</td>";						
                      $download.="<td width='25%'><h3>Amount</h3>".checkempty($amount)."</td>
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
			$i=0;while($lrow = mysqli_fetch_array($lcsql)){
				$expenses_alias=$lrow['expenses_alias'];	
				$date_of_travel=$lrow['date_of_travel'];				
				$mode_of_travel=$lrow['mode_of_travel'];
				$from_place=$lrow['from_place'];
				$to_place=$lrow['to_place'];
				$amount=$lrow['amount'];
				$created_date=$lrow['created_date'];
				$zone_alias=getNames($lrow['zone_alias'],'ec_zone');
				$state_alias=getNames($lrow['state_alias'],'ec_state');
				$district_alias=getNames($lrow['district_alias'],'ec_district');	
				if($lrow['bucket'] ==0)$bucket = 'Secondary transportation';else if($lrow['bucket']  ==1) $bucket = 'Local Conveyance'; else $bucket ='';
				$bucket=$bucket;
				if(getWeights($lrow['capacity'],'product') != 0) $capacity=getWeights($lrow['capacity'],'product'); else $capacity='';
				$capacity=$capacity;				
				if(getWeights($lrow['capacity'],'weight')!= 0) $weight=getWeights($lrow['capacity'],'weight'); else $weigh='';				
				$weight=$capacity;	
				$quantity=$lrow['quantity'];
				$km=$lrow['km'];
				$dpr_number=$lrow['dpr_number'];
				if($lrow['ticket_alias'] == "1") $loc_ticket_name="Others"; else $loc_ticket_name=getTicketName($lrow['ticket_alias']);
				$ticket_alias=$loc_ticket_name;
				if(getArea($lrow['district_alias'])==0){
					$area='Plain Area';
					$amount_appli = '0.02';}
				else if(getArea($lrow['district_alias'])==1)
				{$area='Hilly area'; 
				$amount_appli ='0.04';
				}else{
				$area=''; 
				$amount_appli = '';
				}
					$download.="<h4 class='cont_3'>Local Conveyance".($i+1)." : </h4>";
				if($lrow['bucket'] == 0){
				
				$download.="<table class='cont_2'>
					<tr>
                        <td width='25%'><h3>Zone </h3>".checkempty(ucfirst($zone_alias))."</td>
                        <td width='25%'><h3>State </h3>".checkempty(ucfirst($state_alias))."</td>
                        <td width='25%'><h3>District </h3>".checkempty(ucfirst($district_alias))."</td>
                        <td width='25%'><h3>Area </h3>".checkempty(ucfirst($area))."</td>
                   	</tr>
					<tr>
                        <td width='25%'><h3>Bucket </h3>".checkempty($bucket)."</td>
                        <td width='25%'><h3>Capacity </h3>".checkempty($capacity)."</td>
                        <td width='25%'><h3>Weight of the cell </h3>".checkempty($weight)."</td>
                        <td width='25%'><h3>Quantity </h3>".checkempty($quantity)."</td>
                   	</tr>
					<tr>
                        <td width='25%'><h3>No.Of Kilometers </h3>".checkempty($km)."</td>
                        <td width='25%'><h3>Amount Appilicable </h3>".checkempty($amount_appli)."</td>
                        <td width='25%'><h3>Date Of Travel </h3>".checkempty($date_of_travel)."</td>
                        <td width='25%'><h3>Mode Of Travel </h3>".checkempty(ucfirst($mode_of_travel))."</td>
                  	</tr>
					<tr>
                        <td width='25%'><h3>From </h3>".checkempty(ucfirst($from_place))."</td>
                        <td width='25%'><h3>To </h3>".checkempty(ucfirst($to_place))."</td>
                        <td width='25%'><h3>Ticket ID </h3>".checkempty($ticket_alias)."</td>
                        <td width='25%'><h3>DPR Number </h3>".checkempty($dpr_number)."</td>
                   	</tr>
					<tr>
                        <td width='25%'><h3>Amount </h3>".checkempty($amount)."</td>
                        <td></td>
                        <td></td>
                        <td></td>
                   </tr>
				</table>";
			
			}else if($lrow['bucket'] == 1){
			
			$download.="<table class='cont_2'>
					<tr>
                        <td width='25%'><h3>Zone </h3>".checkempty(ucfirst($zone_alias))."</td>
                        <td width='25%'><h3>State </h3>".checkempty(ucfirst($state_alias))."</td>
                        <td width='25%'><h3>District </h3>".checkempty(ucfirst($district_alias))."</td>
                        <td width='25%'><h3>Area </h3>".checkempty(ucfirst($area))."</td>
                   	</tr>
					<tr>
                        <td width='25%'><h3>Bucket </h3>".checkempty($bucket)."</td>
                        <td width='25%'><h3>Date of Travel </h3>".checkempty($date_of_travel)."</td>
                        <td width='25%'><h3>Mode of Travel </h3>".checkempty(ucfirst($mode_of_travel))."</td>
                        <td width='25%'><h3>From </h3>".checkempty(ucfirst($from_place))."</td>
                   	</tr>
					<tr>
                        <td width='25%'><h3>To </h3>".checkempty(ucfirst($to_place))."</td>
                        <td width='25%'><h3>Ticket ID </h3>".checkempty($ticket_alias)."</td>
                        <td width='25%'><h3>DPR Number </h3>".checkempty($dpr_number)."</td>
                        <td width='25%'><h3>Amount </h3>".checkempty($amount)."</td>
                  	</tr>
				</table>";			
			
			} else {
				
				$download.="<table class='cont_2'>
					<tr>
                        <td width='25%'><h3>Date of Travel </h3>".checkempty($date_of_travel)."</td>
                        <td width='25%'><h3>Mode of Travel </h3>".checkempty(ucfirst($mode_of_travel))."</td>
                        <td width='25%'><h3>From </h3>".checkempty(ucfirst($from_place))."</td>
                        <td width='25%'><h3>To </h3>".checkempty(ucfirst($to_place))."</td>
                   	</tr>
					<tr>
                        <td width='25%'><h3>Amount </h3>".checkempty($bucket)."</td>
                        <td></td>
                        <td></td>
                        <td></td>
                   	</tr>
				</table>";				
			}
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
			$i=0;while($lod_row = mysqli_fetch_array($lod_sql)){
				$expenses_alias=$lod_row['expenses_alias'];	
				$type_of_stay=$lod_row['type_of_stay'];				
				$check_in=$lod_row['check_in'];
				$check_out=$lod_row['check_out'];
				$hotel_name=$lod_row['hotel_name'];
				$amount=$lod_row['amount'];
				if($lod_row['document_link']!=='0'){$lod_link=$lod_row['document_link'];}else{$lod_link='';}
				$document_link=$lod_link;
				$created_date =$lod_row['created_date'];
				if($lod_row['zone_alias'] != ''){$lod_zone = getNames($lod_row['zone_alias'],'ec_zone');}else{$lod_zone = '--';}
				if($lod_row['state_alias'] != ''){$lod_state = getNames($lod_row['state_alias'],'ec_state');}else{$lod_state = '--';}
				if($lod_row['district_alias'] != ''){$lod_district = getNames($lod_row['district_alias'],'ec_district');}else{$lod_district = '--';}
				$zone_alias=$lod_zone;
				$state_alias=$lod_state;
				$district_alias=$lod_district;	
				if($lod_row['ticket_alias'] != ''){ if($lod_row['ticket_alias'] == "1") $lod_ticket_name="Others"; else $lod_ticket_name=getTicketName($lod_row['ticket_alias']);}else {$lod_ticket_name='--';}
				$ticket_alias=$lod_ticket_name;
				if($lod_row['dpr_number'] != '') $lod_dpr = $lod_row['dpr_number'];else $lod_dpr = '--';
				$dpr_number=$lod_dpr;
				$tot_lod_amt+=$lod_row['amount'];
				if($lod_row['document_link']!=='0'){$lod_link=urllink($lod_row['created_date']).$lod_row['document_link'];}else{$lod_link='';}
				
				if($type_of_stay  == "Reimbursement") {
					$download.="<h4 class='cont_3'>Lodging".($i+1)." : </h4>
					<table class='cont_2'>
						<tr>
							<td width='25%'><h3>Type Of Stay </h3>".checkempty($type_of_stay)."</td>
							<td width='25%'><h3>Check in Date </h3>".checkempty($check_in)."</td>
							<td width='25%'><h3>Check out Date </h3>".checkempty($check_out)."</td>
							<td width='25%'><h3>Hotel Name </h3>".checkempty(ucfirst($hotel_name))."</td>
						</tr>
						<tr>";
					if($lod_link !='')
						$download.="<td width='25%'><h3>Files</h3><a href=".$lod_link."> Click Here </a></td>";
					else 
						$download.="<td width='25%'><h3>Files</h3>-NA-</td>";
					$download.="<td width='25%'><h3>Ticket ID </h3>".checkempty($ticket_alias)."</td>
							<td width='25%'><h3>DPR Number </h3>".checkempty($dpr_number)."</td>
							<td width='25%'><h3>Amount </h3>".checkempty($amount)."</td>
						</tr>
					</table>";
				} else {
					$download.="<h4 class='cont_3'>Lodging".($i+1)." : </h4>
					<table class='cont_2'>
						<tr>
							<td width='25%'><h3>Type Of Stay </h3>".checkempty($type_of_stay)."</td>
							<td width='25%'><h3>Check in Date </h3>".checkempty($check_in)."</td>
							<td width='25%'><h3>Check out Date </h3>".checkempty($check_out)."</td>
							<td width='25%'><h3>Zone </h3>".checkempty(ucfirst($zone_alias))."</td>
						</tr>
						<tr>
							<td width='25%'><h3>State </h3>".checkempty(ucfirst($state_alias))."</td>
							<td width='25%'><h3>District </h3>".checkempty(ucfirst($district_alias))."</td>
							<td width='25%'><h3>Ticket ID </h3>".checkempty($ticket_alias)."</td>
							<td width='25%'><h3>DPR Number </h3>".checkempty($dpr_number)."</td>
						</tr>
						<tr>
							<td width='25%'><h3>Amount </h3>".checkempty($amount)."</td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</table>";
				}
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
					
			while($bod_row = mysqli_fetch_array($bod_sql)){
				$expenses_alias=$bod_row['expenses_alias'];	
				$check_in=$bod_row['check_in'];
				$check_out=$bod_row['check_out'];
				$state=$bod_row['state'];
				$amount=$bod_row['amount'];
				$created_date=$bod_row['created_date'];
				if($bod_row['zone_alias'] != ''){$bod_zone = getNames($bod_row['zone_alias'],'ec_zone');}else{$bod_zone = '--';}
				if($bod_row['state_alias'] != ''){$bod_state = getNames($bod_row['state_alias'],'ec_state');}else{$bod_state = '--';}
				if($bod_row['district_alias'] != ''){$bod_district = getNames($bod_row['district_alias'],'ec_district');}else{$bod_district = '--';}
				$zone_alias=$bod_zone;
				$state_alias=$bod_state;
				$district_alias=$bod_district;	
				if($bod_row['ticket_alias'] != ''){ if($bod_row['ticket_alias'] == "1") $bod_ticket_name="Others"; else $bod_ticket_name=getTicketName($bod_row['ticket_alias']);}else {$bod_ticket_name='--';}
				$ticket_alias=$bod_ticket_name;
				if($bod_row['dpr_number'] != '') $bod_dpr = $bod_row['dpr_number'];else $bod_dpr = '--';
				$dpr_number=$bod_dpr;
				$tot_bod_amt+=$bod_row['amount'];
				
				
				$download.="<h4 class='cont_3'>Boarding".($i+1)." : </h4>
				<table class='cont_2'>
                <tr>
                    <td width='25%'><h3>Check in Date </h3>".checkempty($check_in)."</td>
                    <td width='25%'><h3>Check out Date </h3>".checkempty($check_out)."</td>
                    <td width='25%'><h3>Zone </h3>".checkempty(ucfirst($zone_alias))."</td>
                    <td width='25%'><h3>State </h3>".checkempty(ucfirst($state_alias))."</td>
               </tr>
               <tr>
                    <td width='25%'><h3>District </h3>".checkempty(ucfirst($district_alias))."</td>
                    <td width='25%'><h3>Ticket ID </h3>".checkempty($ticket_alias)."</td>
                    <td width='25%'><h3>DPR Number </h3>".checkempty($dpr_number)."</td>
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
				$checked_date=$oth_row['checked_date'];
				if($oth_row['document_link']!=='0'){$oth_link=urllink($oth_row['created_date']).$oth_row['document_link'];}else{$oth_link='';}
				$document_link=$oth_link;
				$amount=$oth_row['amount'];
				$created_date=$oth_row['created_date'];
				if($oth_row['ticket_alias'] != ''){ if($oth_row['ticket_alias'] == "1") $oth_ticket_name="Others"; else $oth_ticket_name=getTicketName($oth_row['ticket_alias']);}else {$oth_ticket_name='--';}
				$ticket_alias=$oth_ticket_name;
				if($oth_row['dpr_number'] != '') $oth_dpr = $oth_row['dpr_number'];else $oth_dpr = '--';
				$dpr_number=$oth_dpr;
				$tot_oth_amt+=$oth_row['amount'];
				
			$download.="<h4 class='cont_3'>Other Expenses".($i+1)." : </h4>
						<table class='cont_2'>
						<tr>
							<td width='25%'><h3>Description </h3>".checkempty(ucfirst($description))."</td>
							<td width='25%'><h3>Date </h3>".checkempty($checked_date)."</td>";
						 if($oth_link !='')
                    	$download.="<td width='25%'><h3>Files</h3><a href=".$oth_link.">Click Here</a></td>";
						else $download.="<td width='25%'><h3>Files</h3>-NA-</td>";	
							$download.="<td width='25%'><h3>Ticket ID </h3>".checkempty($ticket_alias)."</td>
					   </tr>
					   <tr>
							<td width='25%'><h3>DPR Number </h3>".checkempty($dpr_number)."</td>
							<td width='25%'><h3>Amount </h3>".checkempty($amount)."</td>
							<td></td>
							<td></td>
					   </tr>
					</table>";
				$i++;
				
			}
			$download.="<div class='alinR'>Total : <b> Rs.".$othsum_row[0]."</b></div>";
				
		}
		$grandtot=$csum_row[0]+$lcsum_row[0]+$lodsum_row[0]+$bodsum_row[0]+$othsum_row[0];
	
		$download.="<div class='alinR'>Grand Total : <b> Rs.".$grandtot." </b></div>";
				
		$download.="<br><table style='padding-left:10px; line-height:1.5;'><tr><td>(".employeeDetails('name',$resultz[0]['employee_alias']).")<br><b>Signature of client</b></div><p>Date : ".dat($resultz[0]['requested_date'])."</p>";
		$download.='</td></tr></table>';
		
		if($resultz[0]['approved_by']!=""){
			$hsf = explode("|",$resultz[0]['approved_by']); 
			$hsfDate = explode("|",$resultz[0]['approved_date']);
			
			$download.="<table width='100%'><tr>";
			for($i=0;$i<count($hsf);$i++){
				$ss=employeeDetails('name',$hsf[$i]);
				if($ss!='' || $ss!='0'){
                $download.="<td class='alinC' style='font-size:12px'>(".$ss.")
                        <br>Date : ".dat($hsfDate[$i])."
                        </td>";}}
						$download.="</tr></table>";
					
			}
		
			$download.="</tr></table>";
		}

	else{$download='<h2 style="text-align:center">No Records<h2>';}
	$mpdf->SetHTMLHeader("<table class='tableHeader' width='100%'><tr><td align='left' width='30%'><img src='../../images/gallery/logo1.png'></td><td align='center' width='40%'><h2>".$heading."</h2></td><td align='right' width='30%'><img src='../../images/gallery/logo-4.jpg' width='100px'></td></tr></table><br><br>");
	$mpdf->SetHTMLFooter("<p style=\"text-align:center;font-style: italic;font-size:12px;\">{PAGENO}/{nbpg}</p>");
	$mpdf->SetWatermarkImage('../../images/gallery/logo-3.png');
	$mpdf->showWatermarkImage = true;
	$mpdf->watermarkImageAlpha = 0.05;
	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($download,2);
	$mpdf->Output();
	exit;
	
?>