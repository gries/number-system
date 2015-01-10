<?php

use gries\NumberSystem\BinarySystem;
use gries\NumberSystem\Expression;
use gries\NumberSystem\ExpressionConverter;
use gries\NumberSystem\HexadecimalSystem;
use gries\NumberSystem\NumberSystem;

require_once __DIR__.'/../vendor/autoload.php';


class YoloSystem extends NumberSystem
{
    public function __construct()
    {
        parent::__construct(['1337', 'yolo', 'swag'], '¿');
    }
}

$systems = [
    new BinarySystem(),
    new HexadecimalSystem(),
    new YoloSystem()
];

$decimal           = new NumberSystem();
$converter         = new ExpressionConverter();
$decimalExpression = new Expression('(1337 * 7) + sin(5)-2', $decimal);

foreach ($systems as $system) {
    echo $converter->convert($decimalExpression, $system) . "\n";
}