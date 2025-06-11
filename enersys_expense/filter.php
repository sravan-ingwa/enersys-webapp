<?php
$int = 100.098;
if (!filter_var($int, FILTER_VALIDATE_INT) === false) {
    echo("Variable is an integer");
} else {
    echo("Variable is not an integer");
}
?>