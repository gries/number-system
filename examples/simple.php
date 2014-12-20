<?php

use gries\NumberSystem\HexadecimalSystem;
use gries\NumberSystem\Number;

require_once __DIR__.'/../vendor/autoload.php';

$number = new Number(15); // the default system is decimal
$hexNumber = new Number('FF', new HexadecimalSystem());

echo $number->add($hexNumber)->value(); // 270 (15 + 255)
echo $hexNumber->add($number)->value(); // 10E (F + FF)