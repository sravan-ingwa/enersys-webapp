<?php
session_start();
include('../mysql.php');
include('../functions.php');
$date1=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['d1']))));
$date2=date("Y-m-d", strtotime(strtoupper(mysqli_real_escape_string($mr_con,$_REQUEST['d2']))));
$emp =$_SESSION['ec_user_alias'];
$s1=mysqli_query($mr_con,"SELECT dpr_ref_no,category_alias,DATE(sub_date_time) as sub_date,remarks,expense_incurred FROM `ec_dpr` where emp_alias = '$emp' AND DATE(sub_date_time) BETWEEN '$date1' AND '$date2'");
$num=mysqli_num_rows($s1);
if($num>0){
	while($rs=mysqli_fetch_array($s1)){
		if($rs['category_alias']=='0'){
			$cat='Your DPR is not Submitted';
		}else{
			$cat=getDprCat($rs['category_alias']);
		}
echo '<tr class="tbform">
                        <td><p>'.$rs['dpr_ref_no'].'</p></td>
                        <td><p>'.$cat.'</p></td>
                        <td><p>'.date("Y-m-d", strtotime($rs['sub_date'])).'</p></td>
                        <td><p>'.$rs['remarks'].'</p></td>
                        <td><p>'.$rs['expense_incurred'].'</p></td>
                    </tr>';
					
	}
}else{
echo ' <tr class="tbform">
                        <td colspan="5" align="center"><p>No Records found</p></td>
                        
                    </tr>';
}

?>