<?php 
$var = 124;
if (is_float($var)) {
echo sprintf("%01.2f", $var);
} else {
echo $var;
}
?>