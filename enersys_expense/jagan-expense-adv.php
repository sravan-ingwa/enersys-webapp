<?php
include('functions.php');
$rec1=$mr_con->query("SELECT expenses_alias FROM ec_expenses WHERE approval_level='6' AND flag=0 ORDER BY requested_date");
if($rec1->num_rows>0){
	while($row1 = $rec1->fetch_assoc()){		
		$expense=alias($row1['expenses_alias'],'ec_expenses','expenses_alias','total_tour_expenses');
		$expense_emp_alias=alias($row1['expenses_alias'],'ec_expenses','expenses_alias','employee_alias');
		$rec=$mr_con->query("SELECT total_amount,advance_alias FROM ec_advances WHERE employee_alias='$expense_emp_alias' AND  approval_level='6' AND total_amount >0 AND flag=0 ORDER BY requested_date");
		if($rec->num_rows>0){$axs=0;$asz=1;
			while($row = $rec->fetch_assoc()){
				$advances[$axs]=$row['advance_alias'];
				$adv_amt[$axs]=$row['total_amount'];
				$axs++;
			}
		}else $asz=0;
		if($asz!=0){
			for($x=0;$x<count($advances);$x++){
				if($expense>0){
					if(($expense-$adv_amt[$x]) >0){
						$expense=$expense-$adv_amt[$x];
						$adv_amt[$x]=0;
						$query_advances="UPDATE ec_advances SET total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
					}
					else if(($expense-$adv_amt[$x]) ==0){
						$expense=$expense-$adv_amt[$x];
						$adv_amt[$x]=0;
						$query_advances="UPDATE ec_advances SET total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
					}
					else{
						$expense1=$expense;
						$expense=$expense1-$adv_amt[$x];
						$adv_amt[$x]=$adv_amt[$x]-$expense1;
						$query_advances="UPDATE ec_advances SET total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
					}
					$mr_con->query($query_advances);
				}
			}
			if($expense>'0'){
				$x=count($advances)-1;
				$adv_amt[$x]=0-$expense;
				$query_advances="UPDATE ec_advances SET total_amount='".$adv_amt[$x]."' WHERE advance_alias='".$advances[$x]."'";
				$mr_con->query($query_advances);
			}

		}
	}
}
?>