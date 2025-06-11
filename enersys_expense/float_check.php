<?php
/*$lc = 2500.5678;
$recc = (($weight*$qnty*$km*$appli)+($lc/2)); 

$exp = explode('.',$recc);

if(count($exp)>1){
		//if(is_float($recc)) {
			$rec = sprintf("%01.2f", $recc);
		} else {
			$rec = $recc;
		}
	echo $rec;	*/
	
		?>
        <script>parseFloat(u.toFixed(2));
		</script>
		
        <?php
$number = 549.767;
echo round($number, 2). "<br />";
 
$number = 549;
echo round($number, 2). "<br />";
 
$number = .549;
echo round($number, 2). "<br /><br />";
?>