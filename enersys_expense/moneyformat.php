<?php
function moneyFormatIndia($num){
	$explrestunits = "" ;
	if(is_float($num)) {
		$thecash1 = sprintf("%01.2f", $num);
		$exp = explode('.',$thecash1);
		$exp1 = $exp[0];
		if(strlen($exp1)>3){
			$lastthree = substr($exp1, strlen($exp1)-3, strlen($exp1));
			$restunits = substr($exp1, 0, strlen($exp1)-3); // extracts the last three digits
			$restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
			$expunit = str_split($restunits, 2);
			for($i=0; $i<sizeof($expunit); $i++){
				// creates each of the 2's group and adds a comma to the end
				if($i==0){$explrestunits .= (int)$expunit[$i].",";} // if is first value , convert into integer
				else{$explrestunits .= $expunit[$i].",";}
			}$thecash = $explrestunits.$lastthree.".".$exp[1];
		}else{$thecash = $exp1.".".$exp[1];}
	
	} else {
		if(strlen($num)>3){
			$lastthree = substr($num, strlen($num)-3, strlen($num));
			$restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
			$restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
			$expunit = str_split($restunits, 2);
			for($i=0; $i<sizeof($expunit); $i++){
				// creates each of the 2's group and adds a comma to the end
				if($i==0){$explrestunits .= (int)$expunit[$i].",";} // if is first value , convert into integer
				else{$explrestunits .= $expunit[$i].",";}
			}$thecash = $explrestunits.$lastthree;
		}else{$thecash = $num;}
	}
	
	return $thecash; // writes the final format where $currency is the currency symbol.
}

//echo moneyFormatIndia(1264.88);
$today = '2016-01-29';
$expire = '2016-01-29';
$today_dt = strtotime($today);
$expire_dt = strtotime($expire);
if($today_dt == $expire_dt){
	echo 'same';
}else{
	echo 'diff';
}
?>