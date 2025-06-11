<?php
  for($i=1;$i<=8;$i++){ 
  		if($i<=4) { echo  $i;} 
		else echo (9-$i);
	}
  
echo '<br>';

 for($x=4,$z=1;$x>=1;$x--){
	for($y=$z;$y<=4;$y++){
		echo $y;
	}
	echo $x;
	$z=5;
}

echo '<br>';

for($x=1,$z=0;$x<=4;$x++){
	echo $x;
	for($y=$z;$y>=1;$y--){
		echo $y;
	}
	if($x==3){$z=4;}
}
echo '<br>';


for ($a=1, $b=4; $a<='4', $b>=1 ; $a++, $b--) {
	$a1.=$a;$b1.=$b;
}
echo $a1.$b1;


?>